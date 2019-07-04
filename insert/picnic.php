<head>
	<title>Show picnics</title>
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


	$q = $pdo->prepare("DESCRIBE picnic");
	$q->execute();
	$fields = $q->fetchAll(PDO::FETCH_COLUMN);
	$flds=implode(",", $fields);
	$pdo=null;
	return $fields;  
}
?>
<br>
	<nav>
		<a href="../index.html" style="font-size: 120%;color: black;float:left;border:0;padding-left: 60px;">Main Menu</a>
	</nav>
	<br>
	<br>
<form method="POST" action = "<?php echo $_SERVER['PHP_SELF']?>" >

<?php 
$fields = field();
foreach ($fields as  $value){
echo $value;
?>
<input type="text" name="<?php echo $value ?>">
<?php 
echo "<br>";
echo "<br>";

echo "<br>";
}
?> 


<input type="submit" value = "submit" >


</form>



<?php 
error_reporting(E_ALL);
ini_set('display_errors',1);
// check if submitted, check data and do display if no errors else show error
if ($_SERVER["REQUEST_METHOD"] == "POST"){

}
?>