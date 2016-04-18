<?php

//"checked out successfully";

include('../includes/phpConnectHead.php');
$conn=new mysqli($servername,$username,$password,$database);


if($conn)
	;
else
	echo "Error";

// if(isset($_POST['submit']))

	$code=$_POST['code'];
	$sql1="UPDATE entrydetail SET TimeOut=now() WHERE Code='$code' AND TimeOut is NULL ";	
			if($conn->query($sql1))
			;
			else
				echo $conn->error;

?>