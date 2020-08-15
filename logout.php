<?php
ob_start();
session_start();
session_regenerate_id();
unset($_SESSION["email"]);
unset($_SESSION["role"]);
unset($_SESSION['picture']);
unset($_SESSION['name']);
unset($_SESSION["username"]);
unset($_SESSION['fname']);
// remove all session variables
session_unset();
session_destroy();
header("location: login");
exit(1);
