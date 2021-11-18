<?php require_once "Includes/function.php"; ?>
<?php require_once "Includes/session.php"; ?>
<?php
$_SESSION["UserId"] = null;
$_SESSION["UserName"] = null;
$_SESSION["AdminName"] = null;
session_destroy();
Redirect_to("Login.php");
?>
