<?php 
session_start();

?>

<div class="header">
	<?php 
   include('nav.php');
    ?> 
	<?php
include('Leftaside.php');
?>
<head>
    <link rel="stylesheet" type="text/css" href="table.css">
</head>
	<div class="main">    <form method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">
        <label for="records">Choose the number of records per page:    </label>
        <input type="number" name="records" min="0" step="1">
        <br>
        <br>
        <input class="sb" type="submit" name="submit" value="Submit">

    </form>
    <?php
    if(isset($_SESSION['logged'])){
        if($_SESSION['logged'] == 1) {
            $user=$_SESSION['username'];
     //database connection information

            $dbhost = "localhost";
            $dbuser = "c27code4fun";
            $dbpass = "comp334code4fun";
            $dbname = "c27code4fun";

     // create PDO Object
            $pdo = new PDO("mysql:host=$dbhost;dbname=$dbname",$dbuser, $dbpass);

            if(!$pdo ) 
             die("Could not connect to database");

      // Write the SQL statement select 
         $getId="SELECT cid FROM customer where username='$user'";
         $res = $pdo->query($getId);
         $row=$res->fetch();
         $id=$row['cid'];
         $show = "SELECT * FROM reserve where cid='$id'";
         $getCount="SELECT count(*) FROM reserve where cid='$id'";
         $result = $pdo->query($show);
         $countResult=$pdo->query($getCount);
         if (empty($result))
             echo "no picnics for ".$user;
         else
             $count=$countResult->fetch();

         $q = $pdo->prepare("DESCRIBE reserve");
         $q->execute();
         $fields = $q->fetchAll(PDO::FETCH_COLUMN);

         if(!isset($_GET['page'])){
            $_GET['page']=1;
            if ($_SERVER["REQUEST_METHOD"] == "POST"){
                if ($_POST['submit'] ){
                    if(!$_POST['records'] )
                        echo "Enter number of records per page";
                    else{
                        $recPerPage=$_POST['records'];
                        if ($recPerPage>0){
                            $numOfpages=ceil((int)$count[0]/(int)$recPerPage);
                            $_SESSION['numOfpages']=$numOfpages;
                            $_SESSION['recPerPage']=$recPerPage;
                            $cookie_name = $user;
                            $cookie_value =$recPerPage;
                            setcookie($cookie_name, $cookie_value, time() + (24*3600 * 30), "/");
                        }

                        for ($i=1; $i<=$numOfpages; $i++){
                            if ($i==1)
                                echo '<&nbsp;&nbsp;&nbsp;';
                            echo "<a href='myPicnics.php?page=".$i."'>".$i."</a>&nbsp;&nbsp;"; 
                            if ($i==$_SESSION['numOfpages'])
                               echo "&nbsp;&nbsp;&nbsp;>";
                       }
                       $start=($_GET['page']-1)*$recPerPage;
                       $show = "SELECT * FROM reserve where cid='$id' limit $start,".$recPerPage;
                       $result = $pdo->query($show);
                       $count=$result->rowCount();
                       if($count>0){
                        $table=createTable($result,$fields);
                        echo $table;
                    }
                    else echo "<br>There is no reserved Picnics for you";
                }
            }
        }
        elseif (isset($_COOKIE[$user])){

           $numOfpages=ceil((int)$count[0]/(int)$_COOKIE[$user]);

           $_SESSION['numOfpages']=$numOfpages;
           $_SESSION['recPerPage']=$_COOKIE[$user];
           for ($i=1; $i<=$_SESSION['numOfpages']; $i++){
            if ($i==1)
                echo '<&nbsp;&nbsp;&nbsp;';
            echo "<a href='myPicnics.php?page=".$i."'>".$i."</a>&nbsp;&nbsp;"; 
            if ($i==$_SESSION['numOfpages'])
               echo "&nbsp;&nbsp;&nbsp;>";
       }

       $start=($_GET['page']-1)* $_SESSION['recPerPage'];
       $show = "SELECT * FROM reserve where cid='$id' limit $start,".$_SESSION['recPerPage'];
       $result = $pdo->query($show);
       $count=$result->rowCount();
       if($count>0){
        $table=createTable($result,$fields);
        echo $table;
    }
    else echo "<br> There is no reserved Picnics for you";
}
else{
    $numOfpages=ceil((int)$count[0]/10);
    $_SESSION['numOfpages']=$numOfpages;
    $_SESSION['recPerPage']=10;
    for ($i=1; $i<=$_SESSION['numOfpages']; $i++){
      if ($i==1)
        echo '<&nbsp;&nbsp;&nbsp;';
    echo "<a href='myPicnics.php?page=".$i."'>".$i."</a>&nbsp;&nbsp;"; 
    if ($i==$_SESSION['numOfpages'])
       echo "&nbsp;&nbsp;&nbsp;>";
}
echo "&nbsp;&nbsp;&nbsp;>";
$start=($_GET['page']-1)* $_SESSION['recPerPage'];
$show = "SELECT * FROM reserve where cid='$id' limit $start,".$_SESSION['recPerPage'];
$result = $pdo->query($show);
$count=$result->rowCount();
if($count>0){
    $table=createTable($result,$fields);
    echo $table;
}
else echo "<br> There is no reserved Picnics for you";
} 
}
else{
 for ($i=1; $i<=$_SESSION['numOfpages']; $i++){
    if ($i==1)
        echo '<&nbsp;&nbsp;&nbsp;';
    echo "<a href='myPicnics.php?page=".$i."'>".$i."</a>&nbsp;&nbsp;"; 
    if ($i==$_SESSION['numOfpages'])
       echo "&nbsp;&nbsp;&nbsp;>";
}
$start=($_GET['page']-1)* $_SESSION['recPerPage'];
$show = "SELECT * FROM reserve where cid='$id' limit $start,".$_SESSION['recPerPage'];
$result = $pdo->query($show);
$count=$result->rowCount();
if($count>0){
    $table=createTable($result,$fields);
    echo $table;
}
else echo "<br>There is no reserved Picnics for you";

}

}
}

?>

<?php 
//to convert result to table
function createTable($result,$fields)
{
    $table = "<table><thead><tr>";
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
    $table .= "<caption>Reserved Picnics</caption></table>";
    return $table;
}
?>


</div>
<?php
include('rightaside.php');
?>
</div>
<?php 
include('footer.php');
?> 
<?php 
include('nav.php');
?> 