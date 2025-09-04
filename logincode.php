<?php
session_start();
include('db.php');

$email = mysqli_real_escape_string($con, $_POST['email']);
$password = mysqli_real_escape_string($con, $_POST['password']);

// ✅ Check if it's the hardcoded admin login
if ($email === "admin@gmail.com" && $password === "admin") {
    $_SESSION['admin_login'] = true;
    $_SESSION['email'] = $email;
    header("Location: admin/dashboard.php"); // redirect to admin panel
    exit();
}

// ✅ Normal user login
$sql = "SELECT * FROM login WHERE email='$email' AND password='$password'";
$run = mysqli_query($con, $sql);

if (!$run) {
    die("Query Error: " . mysqli_error($con));
}

if (mysqli_num_rows($run) == 1) {
    $row = mysqli_fetch_assoc($run);

    // Store important info in session
    $_SESSION['user_id'] = $row['id'];       // primary key from login table
    $_SESSION['username'] = $row['name'];    // optional, for display
    $_SESSION['email'] = $row['email'];      // optional, for reference

    header('Location: index.php');
    exit();
} else {
    $_SESSION['error_msg'] = "Email or Password does not match!!";
    header('Location: login.php');
    exit();
}
?>
