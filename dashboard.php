<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "personal";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $id = $_POST['id'];
  $password = $_POST['password'];


  $sql = "SELECT * FROM Registration WHERE id = '$id' AND password = '$password'";
  $result = mysqli_query($conn, $sql);

          echo "<!DOCTYPE html>
            <html lang='en'>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <title>Account Info</title>
                
            </head>
            <body>
                <div class='account-info'>
                    <h1>Hi $name, welcome to the bank</h1>
                    <h2>Account number: $id<br></h2> 
                    <h2>Account holder name: $name<br></h2>
                    <h2>Account holder ID: $id <br></h2>
                    <h2>Account holder pont: $point <br></h2>
  
                </div>
            </body>
            </html>";
}
    ?>