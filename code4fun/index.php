<?php

session_start();

?>

	<!---------------aside element if you want to get back to home ---------------->
	<!-- nav bar here   -->
     <?php 
   include('nav.php');
    ?> 

	<!------------------------------------------------------------------------------------------------------------------>
	<br />
	<br />
	<br />
	<!---------------------------this part shows the pages of the assignment ------------------------------------------>
	<p style="font-size: 20px;">click on the part you want to show :</p>
	<ul>
		<li><a href="customer.php"style="font-size: 100%;color: black;margin: 10px;">Customers</a></li>
		<li><a href="employee.php"style="font-size: 100%;color: black;margin: 10px;">Employees</a></li>
		<li><a href="picnic.php"style="font-size: 100%;color: black;margin: 10px;">Picnics</a></li>
		<li><a href="reserve.php"style="font-size: 100%;color: black;margin: 10px;">Reservations</a></li>
		<li><a href="insert/customer.php"style="font-size: 100%;color: black;margin: 10px;">Insert Customers</a></li>
		<li><a href="insert/employee.php"style="font-size: 100%;color: black;margin: 10px;">Insert Employees</a></li>
		<li><a href="insert/picnic.php"style="font-size: 100%;color: black;margin: 10px;">Insert Picnics</a></li>
		<li><a href="insert/reserve.php"style="font-size: 100%;color: black;margin: 10px;">Insert Reservations</a></li>
	</ul>
