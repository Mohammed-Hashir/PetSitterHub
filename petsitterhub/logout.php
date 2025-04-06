<?php
session_start();
session_destroy();
header("Location: login.php"); // or wherever you want to send them
exit();
?>