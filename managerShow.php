
<?php
session_start();
?>

<?php
include('lefttaside.php');
?>
<head>
	<title>Show picnics</title>
	<link rel="stylesheet" type="text/css" href="table.css">
</head>
<div class="main">

<?php

function field1() {

	 //database connection information
	$dbhost = "localhost";
	$dbuser = "c27code4fun";
	$dbpass = "comp334code4fun";
	$dbname = "c27code4fun";

     // create PDO Object
	$pdo = new PDO("mysql:host=$dbhost;dbname=$dbname",$dbuser, $dbpass);
	$q = $pdo->query("SELECT pid,title, picDate, pricePerPerson, place, departureTime, arrivalTime, returnTime, capacity, escortId FROM picnic");
	
	$fields = $q->fetchAll();
	$pdo=null;
	return $fields;  
}
function connectANDShow() {

	 //database connection information
	$dbhost = "localhost";
	$dbuser = "c27code4fun";
	$dbpass = "comp334code4fun";
	$dbname = "c27code4fun";

     // create PDO Object
	$pdo = new PDO("mysql:host=$dbhost;dbname=$dbname",$dbuser, $dbpass);

	if(!$pdo ) {
		die("Could not connect to database");
	} 
     // Write the SQL statement update 
	$pl= $_POST['selectplace'];
	$p2 = $_POST['date'];
	$show = "SELECT pid,title, picDate, pricePerPerson,place, departureTime, arrivalTime, returnTime, capacity, escortId FROM picnic where place  = '".$pl."' and picDate ='".$p2."'";
 // Prepare the query
	$result = $pdo->query($show);
	$pdo=null;
	return $result;  
}

function connectANDShow1() {

	 //database connection information
	$dbhost = "localhost";
	$dbuser = "c27code4fun";
	$dbpass = "comp334code4fun";
	$dbname = "c27code4fun";

     // create PDO Object
	$pdo = new PDO("mysql:host=$dbhost;dbname=$dbname",$dbuser, $dbpass);

	if(!$pdo ) {
		die("Could not connect to database");
	} 
     // Write the SQL statement update 
	$show = "SELECT pid,title, picDate, pricePerPerson, place, departureTime, arrivalTime, returnTime, capacity, escortId FROM picnic";
	 // Write the SQL statement update 
	$findSum = "SELECT pid,sum(numOfPeople) FROM reserve group by pid";
 // Prepare the query
	$result = $pdo->query($show);
	$pdo=null;
	return $result;  
}
function sums() {

	 //database connection information
	$dbhost = "localhost";
	$dbuser = "c27code4fun";
	$dbpass = "comp334code4fun";
	$dbname = "c27code4fun";

     // create PDO Object
	$pdo = new PDO("mysql:host=$dbhost;dbname=$dbname",$dbuser, $dbpass);

	if(!$pdo ) {
		die("Could not connect to database");
	} 

	$findSum = "SELECT pid,sum(numOfPeople) FROM reserve group by pid";
	$sum = $pdo->query($findSum);
	$tot=$sum->fetchAll();
 // Prepare the query
	$pdo=null;
	return $tot;  
}
?>
<?php 
// this function prints the form with inserted values if submit is clicked and no values if not clicked
function printForm1()
{
	?>
	<br>
	<form action="<?php $_SERVER['PHP_SELF']?>" method="POST">
		<br>
		<label>Enter a data    </label>
		<input type="date" name="date" required>
		<br>
		<br>
		<label>Enter desired place     </label>
		<select name="selectplace" required>
			

			<?php 
			$dbhost = "localhost";
			$dbuser = "c27code4fun";
			$dbpass = "comp334code4fun";
			$dbname = "c27code4fun";

     // create PDO Object
			$pdo = new PDO("mysql:host=$dbhost;dbname=$dbname",$dbuser, $dbpass);

			if(!$pdo ) {
				die("Could not connect to database");
			} 
			$qu = "SELECT DISTINCT place FROM picnic";
			$result = $pdo->query($qu);
			$f = $result->fetchAll();
			foreach ($f as $value) {
				$v = array_unique($value);
				foreach ($v as $p) {
					echo "<option value ="."$p".">$p</option>";
				}
			}
			$pdo = null;
			?>
		</select>
		<br>
		<br>
		<input class="sb" type="submit" name="show" value="Display filtered picnics" >    
		<br />
		<?php 
	}
	?>
	<?php 
//to convert result to table
	function createTable($result,$fields,$sums)
	{
		$table = "<table><caption>Picnics Table</caption><thead><tr>";
		foreach ($fields as  $value) {

			foreach ($value as $key => $val) {
				if ( !is_int($key) ) 
					$table .="<th>".$key."</th>";
			}
			$table .="<th>number of people reserved</th>";
			$table .="<th></th>";
			break;
		}
		$table .="</tr></thead>";
		foreach ($result as $row)
		{
			$table.= "<tr>" ;
			foreach ($row as  $key => $va) {
				if ( !is_int($key) ) {

					if ($key == 'pid')
					{
						$pid=$va;
						$table .="<td>" .'<a href="picnic_info.php?id='.$va.'">'.$va."</a>"  . "</td>";
					}
					else
					{
						$table .="<td>" . $va   . "</td>";
					}

				}
			}
			$flag=0;
			foreach ($sums as $arr ) {
				if($arr[0]==$pid){
					$flag=1;
					$table .="<td>" .$arr[1] . "</td>";
				}
			}
			if ($flag==0)
				$table .="<td> </td>";
			$table .= "<td>".'<input class="sb" type = "submit" name ="lul" value = "'."add escort ".$pid.'"> </td>';
			$table.= "</tr>" ;
		}
		$table .= "</table>";
		return $table;
	}

	error_reporting(E_ALL);
	printForm1();
// check if submitted, check data and do display if no errors else show error
	if ($_SERVER["REQUEST_METHOD"] == "POST"){
		if ($_POST['show'] ){
			$result=connectANDShow();
			$fields=field1();
			$sums=sums();
		// check the result
			if ($result!=null){
				$rows=$result->fetchAll();
				if (count($rows)==0)
					echo "no entries in this table with these filters";
				else {
					$table=createTable($rows,$fields,$sums);
					echo $table;
				}
			}
			else
				echo "failed";
		}
		else
		{

			$temp2 =explode(" ", $_POST['lul']);
			header("location: addEscort.php?pid=".$temp2[2]."");	
		}
	}
	else{
		$result=connectANDShow1();
		$fields=field1();
		$sums=sums();
		// check the result
		if ($result!=null){
			$rows=$result->fetchAll();
			if (count($rows)==0)
				echo "no entries in this table with these filters";
			else {
				$table=createTable($rows,$fields,$sums);
				echo $table;
			}
		}
		else
			echo "failed";
	}
	?>
</form>
</div>
<?php
include('rightaside.php');
?>
<?php 
include('footer.php');
?> 
<?php 
include('nav.php');
?> 