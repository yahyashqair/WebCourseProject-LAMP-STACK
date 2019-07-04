<?php
session_start();

if ($_SESSION['logged'] == 1) {
    header('Location: ./index.php');
} else {



    ?>
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form" id="form">

        <H1>Welcome !</H1>
        <div class="editstep" style="display:none;">
            Check Your Information : <i> If you Want to to edit </i> .
        </div>
        <div class="firststep">
            Name : <br>
        <input type="text" name="name" id="name" required placeholder="Name"><br>
        Address :<br>
        <input type="text" name="address" id="address" required placeholder="Address"><br>
        Date Of Birth :<br>
        <input type="text" name="DOB" id="date"required placeholder="Date Of Birth"><br>
        Id Number :<br>
        <input type="text" name="id" id="id" required placeholder="ID Number"><br>
            Email : <br>
        <input type="text" name="email" id="email" required placeholder="Email"><br>
       Fax : <br>
        <input type="text" name="Fax" id="fax" required placeholder="Fax or Telephone"><br>
        </div>
        <div class="secondstep" style="display:none;">
        Username : <br>
        <input type="text" name="username" id="username" required placeholder="username"><br>
        Password : <br>
        <input type="password" name="password"id="password"  required placeholder="Password"><br>
        </div>
        <div class="editstep" style="display:none;">

        </div>
        <!-- <input type="submit" name="submit" value="Submit"><br> -->
        <input type="button" name="next" value="Next Step" onclick="reg()">
    <?php


}

error_reporting(E_ALL);
// check if submitted, check data and do display if no errors else show error
if ($_SERVER["REQUEST_METHOD"] == "POST"){
	$dbhost = "localhost";
	$dbuser = "c27code4fun";
	$dbpass = "comp334code4fun";
	$dbname = "c27code4fun";
	try{
     // create PDO Object
	$pdo = new PDO("mysql:host=$dbhost;dbname=$dbname",$dbuser, $dbpass);
	$name=$_POST['name'];
	$email=$_POST['email'];
	$cid=$_POST['id'];
	$DOB=$_POST['DOB'];
	$address=$_POST['address'];
	$phone=$_POST['Fax'];
	$username=$_POST['username'];
	$password=$_POST['password'];
    $date =explode("-", $DOB);
    $DOB=$date[2].'-'.$date[1].'-'.$date[0];
	$sql = "INSERT INTO customer (name , email , cid , DOB , address ,phone , username , password)
    VALUES ('$name', '$email', '$cid' , '$DOB','$address',$phone,'$username','$password')";
	    $pdo->exec($sql);
        echo "Registration successfully";
        header('Location: ./login.php');
	}
	catch(PDOException $e)
    {
	echo "Error";
    }


}
?>

</form>
<?php 
include('footer.php');
include('nav.php');?> 