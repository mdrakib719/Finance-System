<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "personal";

if (!isset($_SESSION['user_id'])) {
    echo "Please log in to view your transaction history.";
    exit;
}

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_SESSION['user_id'];

$sql = "SELECT * FROM info WHERE account_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "<h1>Transaction History for Account ID: " . htmlspecialchars($id) . "</h1>";
    while ($row = $result->fetch_assoc()) {
        echo "<div class='info-block'>";
        echo "<p>Account ID: " . htmlspecialchars($row['account_id']) . "</p>";
        echo "<p>Name: " . htmlspecialchars($row['name']) . "</p>";
        echo "<p>Salary: " . htmlspecialchars($row['salary']) . "</p>";
        echo "<p>Expense Type: " . htmlspecialchars($row['expense_type']) . "</p>";
        echo "<p>Total Expense: " . htmlspecialchars($row['expense']) . "</p>";
        echo "</div><hr>";
    }
} else {
    echo "No transaction history found for Account ID: " . htmlspecialchars($id);
}

$conn->close();
?>