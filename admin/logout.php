<?php
include "../Config.php";
session_start();
session_unset();
session_destroy();
header("location:http://localhost/Blog_project/login.php");
exit();