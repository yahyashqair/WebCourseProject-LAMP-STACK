<?php 
session_start();

if($_SESSION['logged']==1){
    header('Location: ./index.php' );
}else{


?>
<form method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>"class="form">

<H1>Welcome back</H1>

<input type="text" name="email" require placeholder="username" ><br>
<input type="password" name="password" require placeholder="Password"><br>
<input type="submit" name="submit" value="Submit" ><br>

<?php 


}


if($_SERVER['REQUEST_METHOD']=='POST'){
    $_SESSION['manager']=0;  
    if(empty($_POST['email'])||empty($_POST['password'])){
        echo "Please fill all the feilds";
    }else if($_POST['email']=="admin"&&$_POST['password']=="admin"){
        $_SESSION['manager']=1;  
        $_SESSION['logged']=1;
        $_SESSION['username']="admin";
        header('Location: ./index.php' );
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
    $show2 = "SELECT * FROM employee where username='$email' and password='$password'";
    $result2 = $pdo->query($show2);
    $row2=$result2->fetch();

    if(empty($row)&&empty($row2)){   
        echo "Invalid Username and password";
    }elseif(!empty($row)){
        $_SESSION['logged']=1;
        $_SESSION['username']=$row['username'];
        header('Location: ./index.php' );
    }else{
        $_SESSION['employee']=1;  
        $_SESSION['logged']=1;
        $_SESSION['username']=$row2['username'];
        if(isset($_SESSION['site'])){
            header('Location:'. $_SESSION['site']);
        }
        header('Location: ./index.php' );
    }

}

}

?>

</form>

<?php 
include('footer.php');
include('nav.php');?> 
