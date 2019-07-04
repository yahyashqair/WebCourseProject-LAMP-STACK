<?php 
session_start();
unset($_SESSION['logged']);
if(!$_SERVER['HTTP_REFERER']=="myPicnics.php")
header('Location: ' . $_SERVER['HTTP_REFERER']);
else
header('Location: index.php');
?>