<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "personal";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>login    </title>
</head>
<body>
    <form action="dashboard.php" method="post">
        <label for="id">Account ID</label>
        <input type="number" id="id" name="id" placeholder="ex:10025600"><br>
        <label for="password">Account password:</label>
        <input type="text" id="password" name="password"><br>
        <button type="submit"> log in</button>
        <p><a href="#">Forgot Password?</a></p>
    </form>
    <!-- <form action='../bank.php' method='post'> -->
</body>
</html>