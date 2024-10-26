<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense Chart</title>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        // Fetch the data from PHP
        var data = google.visualization.arrayToDataTable(<?php echo json_encode(getExpenseData()); ?>);
        
        var options = {
          title: 'Expenses Overview',
          is3D: true
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));
        chart.draw(data, options);
      }

      // Function to fetch expense data
      function getExpenseData() {
        <?php
        function getExpenseData() {
            // Database connection
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "personal";
            $conn = new mysqli($servername, $username, $password, $dbname);
        
            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Fetch expense data
            $sql = "SELECT expense_type, SUM(expense) as total_expense FROM info GROUP BY expense_type";
            $result = $conn->query($sql);

            $data = [["Expense Type", "Total Expense"]]; // Header for the chart

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $data[] = [$row['expense_type'], (float)$row['total_expense']];
                }
            }

            $conn->close();
            return $data;
        }
        ?>
      }
    </script>
</head>
<body>
    <div id="piechart" style="width: 900px; height: 500px;"></div>
</body>
</html>