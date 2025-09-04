<?php
// Connect to DB
$conn = mysqli_connect("localhost", "root", "", "resume");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get the latest resume
$sql = "SELECT * FROM resumes ORDER BY id DESC LIMIT 1";
$run = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($run); // fetch as associative array



$sql1 = "SELECT * FROM achievements ORDER BY id DESC LIMIT 1";
$run1 = mysqli_query($conn, $sql1);
$achievements = mysqli_fetch_assoc($run1); // fetch as associative array


$sql2 = "SELECT * FROM education ORDER BY id DESC LIMIT 1";
$run2 = mysqli_query($conn, $sql2);
$education = mysqli_fetch_assoc($run2); // fetch as associative array


$sql3 = "SELECT * FROM experience ORDER BY id DESC LIMIT 1";
$run3 = mysqli_query($conn, $sql3);
$experience = mysqli_fetch_assoc($run3); // fetch as associative array


$sql4 = "SELECT * FROM languages ORDER BY id DESC LIMIT 1";
$run4 = mysqli_query($conn, $sql4);
$languages = mysqli_fetch_assoc($run4); // fetch as associative array


$sql5 = "SELECT * FROM projects ORDER BY id DESC LIMIT 1";
$run5 = mysqli_query($conn, $sql5);
$projects = mysqli_fetch_assoc($run5); // fetch as associative array


$sql6 = "SELECT * FROM resume_references ORDER BY id DESC LIMIT 1";
$run6 = mysqli_query($conn, $sql6);
$resume_references = mysqli_fetch_assoc($run6); // fetch as associative array


$sql7 = "SELECT * FROM skills ORDER BY id DESC LIMIT 1";
$run7 = mysqli_query($conn, $sql7);
$skills = mysqli_fetch_assoc($run7); // fetch as associative array
?>