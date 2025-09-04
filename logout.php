<?php
session_start();
session_destroy();
session_start();
$_SESSION['logout_msg']="Logout Successfully!!";
header('location:index.php');
?>