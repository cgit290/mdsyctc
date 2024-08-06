<?php
session_start();
include 'database.php';

$email = $_POST['email'];
$password = $_POST['password'];
$isAdmin = $_POST['isAdmin'] === 'true';

$response = ["success" => false, "message" => "Invalid login details."];

// Create a connection to the database
$con = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Prepare and bind
$stmt = $con->prepare("SELECT algpass, role FROM admintb WHERE algid = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->bind_result($hashedPassword, $role);
$stmt->fetch();
$stmt->close();

if ($hashedPassword) {
    // In a real application, use password_hash and password_verify
    if ($password === $hashedPassword) {
        if ($isAdmin && $role === 'admin') {
            $_SESSION['user_role'] = 'admin';
            $_SESSION['user_email'] = $email;
            $response = ["success" => true, "isAdmin" => true];
        } elseif (!$isAdmin && $role === 'user') {
            $_SESSION['user_role'] = 'user';
            $_SESSION['user_email'] = $email;
            $response = ["success" => true, "isAdmin" => false];
        } else {
            $response["message"] = "Access denied.";
        }
    } else {
        $response["message"] = "Invalid password.";
    }
} else {
    $response["message"] = "Invalid email.";
}

$con->close();

echo json_encode($response);
?>
