<?php 
session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<!---------------------------mata data and title of the page---------------------------->
	<title>Project main</title>
	<meta charset="UTF-8">
	<meta name="author" content="Sajeda Murra ">
	<meta http-equiv="Content-Type" content="text/html">
	<meta name="description" content="COMP334 1st assignment">
    <meta name="keywords" content="assignment1 COMP334 BZU">
    <link rel="stylesheet" type="text/css" href="style.css">

</head>
<body>
<nav>
    <div class="left">
    <a href="./index.php" >Home Page </a>
    </div>

    <div class="right">
    <?php
    if($_SESSION['logged']!=1){
    ?>
    <a href="./login.php" >log in</a>

    <a href="#" >registration</a>
    <?php }else{
        ?>
            <a>Welcome <?php echo $_SESSION['username'];?> </a>
     <a href="./logout.php" >log out </a>
        <?php
    } ?>
    <a href="#" >alr7lat</a>

    <a href="#" >r7laty</a>
    </div>
</nav>