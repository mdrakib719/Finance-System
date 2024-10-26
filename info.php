<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <form action="info.php" method="post">
    <label for="id">Account ID:</label>
    <input type="number" id="id" name="id" placeholder="ex:10025600" required><br>

    <label for="blance">Total Salary:</label>
    <input type="number" name="blance" id="blance" step="0.01" required><br>
    <label for="expense">Expense Amount:</label>
    <input type="number" name="expense" id="expense" step="0.01" required><br><br>

    <label for="expense_type">Choose an Expense Type:</label>
    <select name="expense_type" id="expense_type" required>
      <option value="loan">Loan</option>
      <option value="rent">Rent</option>
      <option value="bus">Transportation</option>
      <option value="food">Food</option>
      <option value="cloth">Cloth</option>
    </select><br>


    <button type="submit">Submit</button>
  </form>
</body>
</html>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "personal";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $account_id = $_POST['id'];
    $salary = $_POST['blance'];
    $expense_type = $_POST['expense_type'];
    $expense = $_POST['expense'];

    // Calculate the remaining balance
    $total_left_balance = $salary - $expense;

    // Insert into main table
    $sql = "INSERT INTO info (account_id, salary, expense_type, expense, total_left_balance) 
            VALUES ('$account_id', '$salary', '$expense_type', '$expense', '$total_left_balance')";

    // Insert into history table
    $sql_history = "INSERT INTO info_history (account_id, salary, expense_type, expense, total_left_balance) 
                    VALUES ('$account_id', '$salary', '$expense_type', '$expense', '$total_left_balance')";

    if ($conn->query($sql) === TRUE && $conn->query($sql_history) === TRUE) {
        echo "Record inserted successfully into both tables!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close connection
$conn->close();
?>