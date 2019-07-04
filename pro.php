<head>
	<title>Show picnics</title>
</head>
<div class="header">
	<?php 
	session_start();

    ?> 
	<?php
include('Leftaside.php');
?>

<head>
    <link rel="stylesheet" type="text/css" href="table.css">
</head>
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

	$pl= $_POST['selectplace'];
	$p2 = $_POST['date'];
	$q = $pdo->query("SELECT pid,place,placeDiscription,picDate,pricePerPerson FROM picnic where place  = '".$pl."' and picDate ='".$p2."'");
	
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
	$show = "SELECT pid,place,placeDiscription,picDate,pricePerPerson FROM picnic where place  = '".$pl."' and picDate ='".$p2."'";
	
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
	<form action="<?php $_SERVER['PHP_SELF']?>" method="POST">
		<br>
		<br>
		<br>
		<label>enter a data   </label>
		<input type="date" name="date" required>
		<br>

		<br>
		<label>enter desired place   </label>
		<select name="selectplace">
			

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
				
				foreach ($value as $key => $p) {
					if (!is_int($key))
					echo "<option value ="."$p".">$p</option>";
				}
			}
			$pdo = null;
			?>
		</select>
		<br>
		<br>

		<input class="sb" type="submit" name="show" value="Display picnics">    
		<br />
		<?php 
	}
	?>
	<?php 
//to convert result to table
	function createTable($result,$fields)
	{
		$table = "<table><caption>Picnics Table</caption><thead><tr>";

		foreach ($fields as $value) {
			
			foreach ($value as $key => $val) {
				if (!is_int($key))
				$table .="<th>".$key."</th>";
			}
			break;
		}
		$table .="<th></th>";
		$table .="</tr></thead>";
		foreach ($result as $row)
		{
			$table.= "<tr>" ;
			foreach ($row as  $key => $va) {
				if (!is_int($key)){
				if ($key == 'pid')
				{
					$temp = $va;	
					$table .="<td>" .'<a href="picnic_info.php?id='.$va.'">'.$va."</a>"  . "</td>";
				}
				else
				{
					$table .="<td>" . $va   . "</td>";
				}
			}
			}
			$table .= "<td>".'<input class="sb" type = "submit" name ="lul" value = "'.$temp.'"> </td>';
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
		else
		{
			
			$temp2 = $_POST['lul'];
			echo $_SESSION['username'];
			if(isset($_SESSION['logged'])){
				if($_SESSION['logged'] == 1) {
					$user = $_SESSION['username'];
					header("location: reserve.php?pid=".$temp2."&user=".$user."");	
				}
			}else
			{
				$_SESSION['site'] = $_SERVER["REQUEST_URI"];
				$_POST['show']=null;
				echo  "<script>alert('You must Log in before reserving any picnic! '); window.location.href='login.php';</script>";
				
				
			}			
		}
	}
	?>
</form>


</div>
<?php
include('rightaside.php');
?>
</div>

<?php 
include('footer.php');
include('nav.php');include('nav.php');

?> 