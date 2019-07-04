<?php 
session_start();

if($_SESSION['logged']==1){
    header('Location: ./index.php' );
}else{
include('nav.php');



?>
<form method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>"class="form">

<H1>Welcome back</H1>

<input type="text" name="email" require placeholder="Email" ><br>
<input type="password" name="password" require placeholder="Password"><br>
<input type="submit" name="submit" value="Submit" ><br>

<?php 


}


if($_SERVER['REQUEST_METHOD']=='POST'){
    if(empty($_POST['email'])||empty($_POST['password'])){
        echo "Please fill all the feilds";
    }else{
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
     $email=$_POST['email'];
     $password=$_POST['password'];
	$show = "SELECT * FROM customer where username='$email' and password='$password'";
    $result = $pdo->query($show);
    $row=$result->fetch();
    if(empty($row)){
        echo "Invalid Username and password";
    }else{
        $_SESSION['logged']=1;
        $_SESSION['username']=$row['username'];
        header('Location: ./index.php' );
    }
}

}

?>

</form>
