<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<?php
	session_start();

	$dbhost = "localhost";
	$dbuser = "c27code4fun";
	$dbpass = "comp334code4fun";
	$dbname = "c27code4fun";

     // create PDO Object
	$pdo = new PDO("mysql:host=$dbhost;dbname=$dbname",$dbuser, $dbpass);

	$pid = $_GET['pid'];
	$cid = $_GET['cid'];
	$eid = $_GET['eid'];
	$q = $pdo->query("SELECT * FROM reserve where pid  = $pid and cid = $cid and eid = $eid");
	$f = $q->fetch();
	$pdo = null;
	  ?>
	<div class="header">
	<?php 
	error_reporting(E_ALL);
    ?> 
	<?php
include('Leftaside.php');
?>


<div class="main">

	  <form method="post">
	  	<label>your ticket id = <?php echo $f['invoice'] ?> </label>
	  	<br>

	  	<label>number of people  = <?php echo $f['numOfPeople'] ?> </label>

	  	<br>

	  	<label>subtotal price = <?php echo $f['subtotal'] ?> </label>
	  	<br>

	  	<label>price of extra item = <?php echo $f['extreItemprice'] ?> </label>
	  	<br>

	  	<label>total paid = <?php echo $f['totalePrice'] ?> </label>
	  	<br>
	  	
	  </form>


</div>
<?php
include('rightaside.php');
?>
</div>

<?php 
include('footer.php');
include('nav.php');?> 

</body>
</html>