<?php 
session_start();
error_reporting(E_ALL);
ini_set('display_errors',1);

?>
<?php 
include('nav.php');
?> 
<?php
include('Leftaside.php');
?>
<div class="main">
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">
        <label for="records">Choose the number of records per page: </label>
        <input type="number" name="records" min="0" step="1">
        <input type="submit" name="submit" value="Submit">

    </form>
    <?php
    $_SESSION['logged']=1;
    $_SESSION['username']="sos";
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
                            echo "<&nbsp;&nbsp;&nbsp;";
                        echo "<a href='myPicnics.php?page=".$i."'>".$i."</a>&nbsp;&nbsp;"; 
                    }
                    echo "&nbsp;&nbsp;&nbsp;>";
                    $start=($_GET['page']-1)*$recPerPage;
                    $show = "SELECT * FROM reserve where cid='$id' limit $start,".$recPerPage;
                    $result = $pdo->query($show);
                    $table=createTable($result,$fields);
                    echo $table;
                }
            }
        }
        elseif (isset($_COOKIE[$user])){

             echo "$_COOKIE[$user]";
             $numOfpages=ceil((int)$count[0]/10);
            
            $_SESSION['numOfpages']=$numOfpages;
            $_SESSION['recPerPage']=$_COOKIE[$cookie_value];
            for ($i=1; $i<=$_SESSION['numOfpages']; $i++){
                if ($i==1)
                    echo '<&nbsp;&nbsp;&nbsp;';
                echo "<a href='myPicnics.php?page=".$i."'>".$i."</a>&nbsp;&nbsp;"; 
            }
            echo "&nbsp;&nbsp;&nbsp;>";
            $start=($_GET['page']-1)* $_SESSION['recPerPage'];
            $show = "SELECT * FROM reserve where cid='$id' limit $start,".$_SESSION['recPerPage'];
            $result = $pdo->query($show);
            $table=createTable($result,$fields);
            echo $table;
        
            if(!isset($_COOKIE[$user])) {
                 echo "Cookie named '" . $cookie_name . "' is not set!";
            } else {
                echo "Cookie '" . $cookie_name . "' is set!<br>";
                echo "Value is: " . $_COOKIE[$cookie_name];
            }
        }
        else{
            $numOfpages=ceil((int)$count[0]/10);
            $_SESSION['numOfpages']=$numOfpages;
            $_SESSION['recPerPage']=10;
            for ($i=1; $i<=$_SESSION['numOfpages']; $i++){
                if ($i==1)
                    echo '<&nbsp;&nbsp;&nbsp;';
                echo "<a href='myPicnics.php?page=".$i."'>".$i."</a>&nbsp;&nbsp;"; 
            }
            echo "&nbsp;&nbsp;&nbsp;>";
            $start=($_GET['page']-1)* $_SESSION['recPerPage'];
            $show = "SELECT * FROM reserve where cid='$id' limit $start,".$_SESSION['recPerPage'];
            $result = $pdo->query($show);
            $table=createTable($result,$fields);
            echo $table;
        } 
    }
    else{
       for ($i=1; $i<=$_SESSION['numOfpages']; $i++){
        if ($i==1)
            echo '<&nbsp;&nbsp;&nbsp;';
        echo "<a href='myPicnics.php?page=".$i."'>".$i."</a>&nbsp;&nbsp;"; 
    }
    echo "&nbsp;&nbsp;&nbsp;>";
    $start=($_GET['page']-1)* $_SESSION['recPerPage'];
    $show = "SELECT * FROM reserve where cid='$id' limit $start,".$_SESSION['recPerPage'];
    $result = $pdo->query($show);
    $table=createTable($result,$fields);
    echo $table;

}

}
}
// else{
//     include('nav.php');
// }

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