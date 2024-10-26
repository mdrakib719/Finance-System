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

    // // Sanitize input to prevent SQL injection
    // $id = $conn->real_escape_string($id);
    // $password = $conn->real_escape_string($password);

    // Query to get the record with matching id and password
    $sql = "SELECT * FROM Registration WHERE id = '$id' AND password = '$password'";
    $result = $conn->query($sql);

    // Check if a record is found
    if ($result->num_rows > 0) {
        // Fetch the data
        $row = $result->fetch_assoc();
        $name = $row['name'];
        $point = $row['points'];

        // Output HTML with fetched data
        echo "<!DOCTYPE html>
            <html lang='en'>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <title>Account Info</title>
            </head>
            <body>
                <div class='account-info'>
                    <h1>Hi $name, welcome</h1>
                    <h2>Account number: $id<br></h2> 
                    <h2>Account holder name: $name<br></h2>
                    <h2>Account holder ID: $id <br></h2>
                    <h2>Account holder points: $point <br></h2>
                    
                </div>
            </body>
            </html>";
    } else {
        echo "Invalid ID or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h3><a href="info.php">give information</a></h3>
</body>
</html>