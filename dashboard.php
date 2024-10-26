<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "personal";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function fetchUserData($id, $password, $conn) {
    $sql = "SELECT * FROM Registration WHERE id = '$id' AND password = '$password'";
    return $conn->query($sql)->fetch_assoc();
}

function getExpenseData($id, $conn) {
    $sql = "SELECT expense_type, SUM(expense) as total_expense FROM info WHERE account_id = '$id' GROUP BY expense_type";
    $result = $conn->query($sql);
    $data = [["Expense Type", "Total Expense"]];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = [$row['expense_type'], (float)$row['total_expense']];
        }
    }
    return json_encode($data);
}

function fetchTotals($id, $conn) {
    $sql_salary = "SELECT SUM(salary) as total_salary FROM info WHERE account_id = '$id'";
    $sql_expenses = "SELECT SUM(expense) as total_expenses FROM info WHERE account_id = '$id'";

    $total_salary = $conn->query($sql_salary)->fetch_assoc()['total_salary'] ?? 0;
    $total_expenses = $conn->query($sql_expenses)->fetch_assoc()['total_expenses'] ?? 0;
    $total_left = $total_salary - $total_expenses;

    return [$total_salary, $total_expenses, $total_left];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $password = $_POST['password'];
    $userData = fetchUserData($id, $password, $conn);

    if ($userData) {
        $_SESSION['user_id'] = $id;
        $name = $userData['name'];
        $points = $userData['points'];
        list($total_salary, $total_expenses, $total_left) = fetchTotals($id, $conn);
        $expenseData = getExpenseData($id, $conn);

        echo renderDashboard($id, $name, $points, $total_salary, $total_expenses, $total_left, $expenseData);
    } else {
        echo "Invalid ID or password.";
    }
}

function renderDashboard($id, $name, $points, $total_salary, $total_expenses, $total_left, $expenseData) {
    return <<<HTML
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Dashboard - $name</title>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
            google.charts.load('current', {'packages':['corechart']});
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {
                var data = google.visualization.arrayToDataTable($expenseData);
                var options = {
                    title: 'Expense Overview for $name',
                    is3D: true
                };
                var chart = new google.visualization.PieChart(document.getElementById('piechart'));
                chart.draw(data, options);
            }
        </script>
    </head>
    <body>
        <div class='account-info'>
            <h1>Hi $name, welcome</h1>
            <h2>Account Number: $id</h2> 
            <h2>Points: $points</h2>
            <h2>Total Salary: $total_salary</h2>
            <h2>Total Expenses: $total_expenses</h2>
            <h2>Total Money Left: $total_left</h2>
            <a href="info.php">Update your Income/Expense</a>
            <a href="history.php">View Transaction History</a>
            <div id="piechart" style="width: 400px; height: 400px;"></div>
        </div>
    </body>
    </html>
    HTML;
}
?>