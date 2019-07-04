<!DOCTYPE html>
<html>
<head>
	<title>enter payment method</title>
</head>
<body>
<div class="header">
	<?php 
error_reporting(E_ALL);

ini_set('display_errors',1);
	?> 
	<?php 
	session_start();
?> 
	<?php
include('Leftaside.php');
?>
	<div class="main">

<form method="post" id="cardform">
	<?php
	session_start();
	
	$dbhost = "localhost";
	$dbuser = "c27code4fun";
	$dbpass = "comp334code4fun";
	$dbname = "c27code4fun";

     // create PDO Object
	$pdo = new PDO("mysql:host=$dbhost;dbname=$dbname",$dbuser, $dbpass);

	$pid = $_GET['pid'];

	$q = $pdo->query("SELECT pricePerPerson FROM picnic where pid  = ".$pid."");

	$getcid = "SELECT cid from customer where username ='".$_GET['user']."'";
	$qq = $pdo->query($getcid);	
	$result2 = $pdo->query($getcid);
	$cv = $qq->fetch();
	$cid = $cv['cid'];
	$vals = $q->fetch();
	$hi = $vals['pricePerPerson'];
	$totone = $hi * $_GET['pplno'];

	$qqq = $pdo->query("SELECT itemPrice FROM item where itemName = '".$_GET['item']."'");
	$s = $qqq->fetch();
	$itemprice = $s['itemPrice'];
	$tot = $totone + $itemprice;

	

	?>

	<label> the total amount of money is : <?php echo $tot ?> </label>
	<br>
	<label> select card type </label>
	<br>
	<select>
		<option value="5555">visa</option>
		<option value="6666">masterCard</option>
		<option value="7777">paypal</option>
	</select>
<br>
<label> enter remaining number :  </label>
<input type="text" name="num" id="cardnum" >
<br>
<div>
<input type="checkbox" name="confirm" id="confirm" > confirm booking! 
<br>
</div>
<input type="button" onclick="bookvalid()"  name="sub" value="book !">
</form>
<?php
if(isset($_GET['pplno'])){
$qqqq = $pdo->query("SELECT escortid FROM picnic where pid  = ".$pid."");
$va = $qqqq->fetch();
$eid = $va['escortid'];


$insert =  "INSERT INTO reserve (pid, cid,eid,numOfPeople, payment, totalePrice, subtotal, extreItemprice) VALUES (?,?,?,?,?,?,?,?)";
      // Prepare the statement

	$pre = $pdo->prepare($insert);
	$check = $pre->execute([$pid,$cid,$eid,$_GET['pplno'],$_POST['num'],$tot,$totone,$itemprice]);
	if ($check)
			header("location:report.php?pid=$pid&cid=$cid&eid=$eid");
		else 
			echo "couldn't reserve this picinc";
		}

			$pdo=null;
?>

</div>
<?php
include('rightaside.php');
?>
</div>

<?php 
include('footer.php');
include('nav.php');

?> 
</body>
</html>