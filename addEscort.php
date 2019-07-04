<head>
	<title>Show Reservations</title>
</head>
<?php 
	session_start();
?> 
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
	$pdo=null;

	?>

	<label> picinc id : </label>
	<input type="text" name="pid" disabled value="<?php echo $vals['pid'];  ?>">
	<br>

	<label> picinc place : </label>
	<input type="text" name="place" disabled value="<?php echo $vals['place']; ?>">
	<br>
	
	
	<label> picinc departure time : </label>
	<input type="text" name="dep" disabled value="<?php  echo $vals['departureTime']; ?>">
	<br>
	
	<label> picinc arival time : </label>
	<input type="text" name="arivaltime" disabled value="<?php echo $vals['arrivalTime'];  ?>">
	<br>
	
	<label> picinc return time : </label>
	<input type="text" name="returntime" disabled value="<?php echo $vals['returnTime'];  ?>">
	<br> 
	Employees:
	<select name="emp">
		<?php
		$dbhost = "localhost";
		$dbuser = "c27code4fun";
		$dbpass = "comp334code4fun";
		$dbname = "c27code4fun";

     // create PDO Object
		$pdo = new PDO("mysql:host=$dbhost;dbname=$dbname",$dbuser, $dbpass);

		$pid = $_GET['pid'];

		$q = "SELECT * FROM employee";
		$result = $pdo->query($q);
		while ($vals = $result->fetch()) {
			echo "<option value=".$vals['eid'].">".$vals['name']."</option>";
		}
		$pdo=null;
		?>
	</select>
	<br />

	<input type="submit" name = 'add' value = "Add Escort" >



	<?php 

	error_reporting(E_ALL);
	ini_set('display_errors',1);
// check if submitted, check data and do display if no errors else show error
	if ($_SERVER["REQUEST_METHOD"] == "POST"){
		if ($_POST['add']){
			if(isset($_POST['emp'])){
				$dbhost = "localhost";
				$dbuser = "c27code4fun";
				$dbpass = "comp334code4fun";
				$dbname = "c27code4fun";

     // create PDO Object
				$pdo = new PDO("mysql:host=$dbhost;dbname=$dbname",$dbuser, $dbpass);

				$pid = $_GET['pid'];
				$eid=$_POST['emp'];
				$q = "UPDATE picnic set escortId=".$eid." where pid=".$pid;
				$stat = $pdo->prepare($q);
				$result=$stat->execute();
				if($result){
					echo "";
					echo "Added";
				}
				else{
					echo "";
					echo "Failed";
				}

			}
		}
	}

	?>
</form>