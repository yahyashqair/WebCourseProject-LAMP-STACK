<!DOCTYPE html>
<html>
<head>
	<title>info</title>
</head>
<body>
	<form method="get" action="picnic_info.php">
		<?php
		session_start();
		
	$dbhost = "localhost";
	$dbuser = "c27code4fun";
	$dbpass = "comp334code4fun";
	$dbname = "c27code4fun";

     // create PDO Object
	$pdo = new PDO("mysql:host=$dbhost;dbname=$dbname",$dbuser, $dbpass);
	$q = $pdo->query("SELECT * FROM picnic where pid = ".$_GET['id']."");
	
	$fields = $q->fetchAll();
	foreach ($fields as $key => $value) {
		
		foreach ($value as $k => $va) {
			if ( !is_int($k) && $k!="img1" && $k!="img2" && $k!="img3"){
			echo $k;
			echo " : ";
			echo $va;
			echo "<br>";
		}
		elseif( !is_int($k)) {
			echo $k;
			echo '<img src="'."$va".'"alt="iamge " />';
			echo "";
			//<?php echo base64_encode('.$va.');? 
		}
			# code...
		}

			# code..
		# code...
	}
	$pdo=null; 
		 ?>
</form>

</body>
</html>