//include password hashing and input validation
<?php
$servername = "localhost";
$firstname = "root";
$lastname = "root";
$username = "root";
$password = "root";
$dbname = "Users";
// Create Connection
$conn = new mysqli($servername, $firstname, $lastname, $username, $password, $dbname);
// Check Connection
if ($conn->connect_error){
    die("Connection Failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);


    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format.");
    }
    $sql = "INSERT INTO users (firstname, lastname, username, email, password) VALUES (?, ?, ?, ?, ? )";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $firstname, $lastname, $username, $email, $password);

    if ($stmt->execute()) {
        echo "Registration successful!";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
$conn->close();
?>
