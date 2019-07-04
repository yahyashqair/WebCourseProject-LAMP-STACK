<?php
session_start();
?>

<!DOCTYPE html>
<html>

<head>
    <!---------------------------mata data and title of the page---------------------------->
    <title>Project main</title>
    <meta charset="UTF-8">
    <meta name="author" content="Sajeda Murra,Yahya Shqair , Hussam sameeh">
    <meta http-equiv="Content-Type" content="text/html">
    <meta name="description" content="COMP334 1st assignment">
    <meta name="keywords" content="assignment1 COMP334 BZU">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <script src="code.js"></script>

</head>

<body>
    <nav>
        <div class="left">
            <!-- <a href="./index.php"><img src="s4w.png" style="width:9% ;height:7% ;"></a> -->
            <a href="./index.php">Home Page </a>
        </div>
        <div class="dropdown">
            <button onclick="myFunction()" class="dropbtn">Menu</button>
            <div id="myDropdown" class="dropdown-content">
                <a href="help.php">Help</a>
                <a href="contact.php">Contact Us</a>
            </div>
        </div>

        <div class="right">
            <?php
            if ($_SESSION['logged'] != 1) {
                ?>
                <a href="./login.php">log in</a>

                <a href="./reg.php">registration</a>
            <?php } else {
            ?>
                <a>Welcome <?php echo $_SESSION['username']; ?> </a>
                <a href="./logout.php">log out </a>
            <?php
        } ?>
            <a href="pro.php">Scheduled Picnics</a>
            <?php
            // showmanager .. picnic 
            if (isset($_SESSION['logged']) &&isset($_SESSION['manager']) && $_SESSION['logged'] == 1&&$_SESSION['manager']==1){
                echo "<a href=" . "picnic.php" . " >Picnic </a>";
                echo "<a href=" . "managerShow.php" . " >Manager Show </a>";
            }
            if (isset($_SESSION['logged']) && $_SESSION['logged'] == 1)
                echo "<a href=" . "myPicnics.php" . " >Reserved Picnics</a>";
            ?>
        </div>
    </nav>