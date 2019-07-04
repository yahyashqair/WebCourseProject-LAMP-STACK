<div class="header">
	<?php
	include('nav.php');
	?>
	<?php
	include('Leftaside.php');
	?>
	<div class="main">

		<head>
			<title>SUBMIT FORM</title>
		</head>
		<?php
		function connectANDinsert($title, $place, $food, $act, $dep, $arr, $ret, $tran, $price, $cap, $fac, $suit, $img1, $img2, $img3)
		{

			//database connection information
			$dbhost = "localhost";
			$dbuser = "c27code4fun";
			$dbpass = "comp334code4fun";
			$dbname = "c27code4fun";

			// create PDO Object
			$pdo = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);

			if (!$pdo) {
				die("Could not connect to database");
			}
			// Write the SQL statement insert application
			$insertStat = "INSERT INTO picnic (title,picDate,pricePerPerson,place,activities,food,departureTime,arrivalTime,returnTime,transportation,capacity,
		suitableFor,facilities,img1,img2,img3) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
			// Prepare the statement
			$pre = $pdo->prepare($insertStat);
			$date = explode("T", $dep);

			$dep = str_replace("T", " ", $dep);
			$arr = str_replace("T", " ", $arr);
			$ret = str_replace("T", " ", $ret);
			/*$dep = date_create_from_format('Y-m-d H:i', $dep);
	$dep=$dep->getTimestamp();	
	$arr = date_create_from_format('Y-m-d H:i', $arr);
	$arr->getTimestamp();
	$ret = date_create_from_format('Y-m-d H:i', $ret);
	$ret->getTimestamp();
	*/
			try {
				$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);


				$check = $pre->execute([$title, $date[0], $price, $place, $act, $food, $dep, $arr, $ret, $tran, $cap, $suit, $fac, $img1, $img2, $img3]);
				// check the result
				if ($check)
					echo "Inserted successfully";
				else
					echo "Insertion faild,check inputs" . $e->getMessage();
			} catch (Exception $e) {
				echo 'Exception -> ';
				var_dump($e->getMessage());
			}

			$pdo = null;
		}
		?>
		<?php
		// this function prints the form with inserted values if submit is clicked and no values if not clicked
		function printForm($title, $place, $food, $act, $dep, $arr, $ret, $tran, $price, $cap, $baby, $fac)
		{
			?>

			<fieldset>
				<legend>Picnic information</legend>
				<br />
				<form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
					<label>Picnic Title:</label>
					<input type="text" name="title" value="<?php echo $title; ?>" required />
					<br />
					<br />
					<label>Place:</label>
					<input type="text" name="place" value="<?php echo $place; ?>" required>
					<br>
					Select images to upload:<br>
					<input type="file" name="img[]"><br>
					<input type="file" name="img[]"><br>
					<input type="file" name="img[]"><br>
					<br />
					<br />
					<label>Food:</label>
					<input type="text" name="food" value="<?php echo $food; ?>" required>
					<br />
					<br />
					<label>Activities:</label>
					<textarea name="act" required><?php echo $act; ?></textarea>
					<br />
					<br />
					<label>Departure time:</label>
					<input type="datetime-local" name="dep1" value="<?php echo $dep; ?>" required>
					<br />
					<br />
					<label>Arrival time:</label>
					<input type="datetime-local" name="arr" value="<?php echo $arr; ?>" required>
					<br />
					<br />
					<label>Return time:</label>
					<input type="datetime-local" name="ret" value="<?php echo $ret; ?>" required>
					<br />
					<br />
					<label>Transportation:</label>
					<input type="text" name="tran" value="<?php echo $tran; ?>" required>
					<br />
					<br />
					<label>Price per person:</label>
					<?php
					if ($price != "") {
						echo '<input type="number" name="price" value="' . $price . '" min="0" step="0.1" required>';
					} else
						echo '<input type="number" name="price" min="0"  step="0.1" required >';
					?>
					<br />
					<br />
					<label>Capacity:</label>
					<?php
					if ($cap != "") {
						echo '<input type="number" name="cap" value="' . $cap . '" min="20" max="50" step="1" required>';
					} else
						echo '<input type="number" name="cap" min="20" max="50"step="1" required >';
					?>
					<br />
					<br />
					<label>Suitable for:</label>
					<br />
					<input type="checkbox" name="suit[]" value="children">Children
					<input type="checkbox" name="suit[]" value="people with disabilities">People with disabilities
					<input type="checkbox" name="suit[]" value="Normal people">Other People
					<br />
					<br />
					<label>Baby facilities?</label>
					<input type="checkbox" name="babyF" id="cb">
					<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
					<script type="text/javascript">
						$(function() {
							$("#cb").click(function() {
								if ($(this).is(":checked")) {
									$("#fac").removeAttr("disabled");
									$("#fac").focus();
								} else {
									$("#fac").attr("disabled", "disabled");
								}
							});
						});
					</script>


					<textarea id="fac" name="faci" disabled><?php echo $fac; ?></textarea>

					<br />
					<br />

					<input type="submit" name="do" value="Insert picnic">
					<input type="submit" name="do" value="Reset Fields">

					<br />
				</form>
			</fieldset>
		<?php
	}
	?>
		<?php
		error_reporting(E_ALL);

		// check if submitted, check data and do insertion if no errors else show error
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			if ($_POST['do'] == "Insert picnic") {
				$title = trim($_POST['title'], " ");
				$place = trim($_POST['place'], " ");
				$food = trim($_POST['food'], " ");
				$act = trim($_POST['act'], " ");
				$dep = $_POST['dep1'];
				$arr = $_POST['arr'];
				$ret = $_POST['ret'];
				$tran = trim($_POST['tran'], " ");
				$price = $_POST['price'];
				$cap = $_POST['cap'];
				$suitableFor = "";
				if ($_POST['suit']) {
					foreach ($_POST['suit'] as $value) {
						$suitableFor = $suitableFor . "$value";
					}
				} else

			if (isset($_POST['babyF']))
					$fac = "";
				if (isset($_POST['faci']))
					$fac = trim($_POST['faci'], " ");
				else
					$fac = "";

				########################files section
				$uploads = count($_FILES["img"]["tmp_name"]);
				if ($uploads !== 3) {
					echo "you have to upload 3 photo";
					$uploadNum = 0;
				} else {
					$uploadNum = 1;
				}

				$dir = "images/";
				for ($i = 0; $i < 3; $i++) {
					$ta_file = $dir . basename($_FILES['img']['name'][$i]);
					$uploaded = 1;
					$file_type = explode(".", $_FILES['img']['name'][$i]);
					$filetype = $file_type[1];
					if (
						$filetype != "jpg" && $filetype != "png" && $filetype != "jpeg"
						&& $filetype != "gif"
					) {
						echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
						$uploaded = 0;
						break;
					}
					if ($uploaded == 1 && $uploadNum == 1) {
						$flagFile = move_uploaded_file($_FILES['img']['tmp_name'][$i], $ta_file);
					}
				}
				########################
				$img1 = "images/" . basename($_FILES['img']['name'][0]);
				$img2 = "images/" . basename($_FILES['img']['name'][1]);
				$img3 = "images/" . basename($_FILES['img']['name'][2]);
				printForm($title, $place, $food, $act, $dep, $arr, $ret, $tran, $price, $cap, "", $fac);
				connectANDinsert($title, $place, $food, $act, $dep, $arr, $ret, $tran, $price, $cap, $fac, $suitableFor, $img1, $img2, $img3);
			} elseif ($_POST['do'] == "Reset Fields") {
				printForm("", "", "", "", "", "", "", "", "", "", "", "");
			}
		} else
			printForm("", "", "", "", "", "", "", "", "", "", "", "");
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