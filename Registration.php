<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registration</title>
  <script>
    function validateForm() {
      const password = document.getElementById("password").value;
      const confirmPassword = document.getElementById("confirm_password").value;

      if (password !== confirmPassword) {
        alert("Passwords do not match. Please try again.");
        return false; // Prevent form submission
      }
      return true; // Allow form submission
    }
  </script>
</head>
<body>
  <form action="Registration.php" method="post" onsubmit="return validateForm();">
    <label for="name">Name</label>
    <input type="text" name="name" id="name" placeholder="Enter your full name" required>
    
    <label for="code">Refer Person ID</label>
    <input type="number" name="code" id="code" placeholder="Enter refer person ID">
    
    <label for="password">Password</label>
    <input type="password" name="password" id="password" placeholder="Enter your password" required>
    
    <label for="confirm_password">Confirm Password</label>
    <input type="password" name="confirm_password" id="confirm_password" placeholder="Re-enter your password" required>
    
    <button type="submit">Submit</button>
  </form>
</body>
</html>

<?php

// Database connection details
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

// Function to generate a random 8-digit number
function generateRandomCode() {
    return rand(10000000, 99999999);  // Generates a random 8-digit number
}

// Function to check if the code already exists in the database
function isCodeUnique($conn, $code) {
    $sql = "SELECT id FROM Registration WHERE id = '$code'";
    $result = $conn->query($sql);
    
    // Return true if the code doesn't exist, false if it does
    return $result->num_rows === 0;
}

// Generate a unique 8-digit code
$uniqueCode = generateRandomCode();
while (!isCodeUnique($conn, $uniqueCode)) {
    $uniqueCode = generateRandomCode();  // Keep generating until we find a unique code
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the name, code, and password from the form
    $name = $_POST['name'];
    $code = $_POST['code'];
    $password = $_POST['password'];  // Get the password from the form

    // Hash the password before storing it
    // $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert the name, unique 8-digit ID, code, and hashed password into the database
    $sql = "INSERT INTO Registration (id, name, code, password, points) VALUES ('$uniqueCode', '$name', '$code', '$password', 0)";
    
    if ($conn->query($sql) === TRUE) {
        echo "Thanks for joining! Your unique ID is: " . $uniqueCode;
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>