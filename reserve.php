<head>
	<title>Show Reservations</title>
</head>
<?php
session_start();
?>

<div class="header">
	<?php 
    ?> 
	<?php
include('Leftaside.php');
?>
	<div class="main">

<?php
function field() {

	 //database connection information
	$dbhost = "localhost";
	$dbuser = "c27code4fun";
	$dbpass = "comp334code4fun";
	$dbname = "c27code4fun";

     // create PDO Object
	$pdo = new PDO("mysql:host=$dbhost;dbname=$dbname",$dbuser, $dbpass);


	$q = $pdo->prepare("DESCRIBE reserve");
	$q->execute();
	$fields = $q->fetchAll(PDO::FETCH_COLUMN);
	$flds=implode(",", $fields);
	$pdo=null;
	return $fields;  
}
?>
<br>
	<br>
	<br>
<form method="POST">
	<?php
	$dbhost = "localhost";
	$dbuser = "c27code4fun";
	$dbpass = "comp334code4fun";
	$dbname = "c27code4fun";

     // create PDO Object
	$pdo = new PDO("mysql:host=$dbhost;dbname=$dbname",$dbuser, $dbpass);

	$pid = $_GET['pid'];

	$q = $pdo->query("SELECT pid,place,placeDiscription,picDate,pricePerPerson,departureTime,arrivalTime,returnTime FROM picnic where pid  = ".$pid."");
	
	$vals = $q->fetch();

	$string = "SELECT itemName from item";
	$item = $pdo->query($string);
	$it = $item->fetchAll();

	$pdo=null;


	?>

	<label> picinc id : </label>
	<input type="text"  name="pid" value="<?php echo $vals['pid'];  ?> " disabled>
	<br>

	<label> picinc place : </label>
	<input type="text" name="place" value="<?php echo $vals['place']; ?>" disabled>
	<br>
	
	<label> picinc description : </label>
	<input type="text" name="desc" value=" <?php  echo $vals['placeDiscription']; ?>" disabled>
	<br>
	
	<label> picinc departure time : </label>
	<input type="text" name="dep" value="<?php  echo $vals['departureTime']; ?>" disabled>
	<br>
	
	<label> picinc arival time : </label>
	<input type="text" name="arivaltime" value="<?php echo $vals['arrivalTime'];  ?>" disabled>
	<br>
	
	<label> picinc return time : </label>
	<input type="text" name="returntime" value="<?php echo $vals['returnTime'];  ?>" disabled>
	<br>
	
	<label> picinc price per person : </label>
	<input type="text" name="ppp" value=" <?php echo $vals['pricePerPerson']; ?>" disabled>
	<br>
	
	<label> enter number of people : </label>
	<input type="text" name="pplno">
	<br>
	<label>select special item : </label>
	<select name = "specialitem">
	<?php
	foreach ($it as  $value) {
	foreach ($value as $key => $val) {
		if (!is_int($key))
	echo "<option value = $val>".$val." </option>";
	
	}
	}
	?>
	</select>
	<br>


<input type="submit" name = 'in' value = "submit" >






<?php 
$lul = $_POST['pplno'];
error_reporting(E_ALL);
ini_set('display_errors',1);
// check if submitted, check data and do display if no errors else show error
if ($_SERVER["REQUEST_METHOD"] == "POST"){
	if ($_POST['in']){
		$user = $_GET['user'];
		$item = $_POST['specialitem'];
		header("location:cardinfo.php?pplno=$lul&pid=$pid&user=$user&item=$item");
	}
}

?>
</form>
</div>
<?php
include ("rightaside.php");
?>
</div>
<?php
include ("footer.php");
?>