<?php
ob_start();
session_start();
session_regenerate_id();
session_destroy();
unset($_SESSION["username"]);
unset($_SESSION["role"]);
header("location: index?msg=You%20have%20been%20logged%20out!&type=information");
exit(1);
