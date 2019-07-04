<head>
	<title>Show employees</title>
</head>
<?php

function field() {

	 //database connection information
	$dbhost = "localhost";
	$dbuser = "c27code4fun";
	$dbpass = "comp334code4fun";
	$dbname = "c27code4fun";

     // create PDO Object
	$pdo = new PDO("mysql:host=$dbhost;dbname=$dbname",$dbuser, $dbpass);


	$q = $pdo->prepare("DESCRIBE employee");
	$q->execute();
	$fields = $q->fetchAll(PDO::FETCH_COLUMN);
	$flds=implode(",", $fields);
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
	$show = "SELECT * FROM employee";
 // Prepare the query
	$result = $pdo->query($show);
	
	$pdo=null;
	return $result;  
}
?>
<?php 
// this function prints the form with inserted values if submit is clicked and no values if not clicked
function printForm1()
{
	?>
	<br>
	<nav>
		<a href="index.html" style="font-size: 120%;color: black;float:left;border:0;padding-left: 60px;">Main Menu</a>
	</nav>
	<form action="<?php $_SERVER['PHP_SELF']?>" method="POST">
		<br>
		<br>
		<br>
		<input type="submit" name="show" value="Display employees" style="border-radius: 10px;font-size: 20px;">    
		<br />
	</form>
	<?php 
}
?>
<?php 
//to convert result to table
function createTable($result,$fields)
{
	$table = "<table border='1'><caption>Employees Table</caption><thead><tr>";

	foreach ($fields as  $value) {
		$table .="<th>".$value."</th>";
	}
	$table .="</tr></thead>";
	foreach ($result as $row)
	{
		$table.= "<tr>" ;
		foreach ($fields as  $value) {
			$table .="<td>" . $row[$value]   . "</td>";
		}

		$table.= "</tr>" ;
	}
	$table .= "</table>";
	return $table;
}

error_reporting(E_ALL);
ini_set('display_errors',1);
printForm1();
// check if submitted, check data and do display if no errors else show error
if ($_SERVER["REQUEST_METHOD"] == "POST"){

	if ($_POST['show'] ){

		$result=connectANDShow();
		$fields=field();
			// check the result
		if ($result!=null){
			$rows=$result->fetchAll();
			if (count($rows)==0)
				echo "no entries in this table";
			else {
				$table=createTable($rows,$fields);
				echo $table;
			}
		}
		else
			echo "failed";
	}
}
?>