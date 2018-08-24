 <?php

 include 'db_conn.php';

	$fname=$_GET['fname'];
	$price=$_GET['price'];
	$uploadFile=$_GET['uploadFile'];
	$scat=$_GET['scat'];
	mysqli_query($conn,"UPDATE product set price='$price', uploadFile='$uploadFile', scat='$scat' where fname='$fname");

	?>