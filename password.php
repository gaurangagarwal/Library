<?php

include('includes/phpConnectHead.php');
$conn= mysqli_connect($servername,$username,$password,$database);
if(!isset($_GET['code']))
	header('Location: index.php');

$code = $_GET['code'];

$sql = "SELECT * FROM studentdetail WHERE Code = '$code'";
$name = "as"; 
$result = mysqli_query($conn , $sql);
if(mysqli_num_rows($result) == 0) {// if no such code exists redirect to home page
	header('Location: index.php');
} else {
	$rowHelp = mysqli_fetch_assoc($result);
	$name = $rowHelp['Name'];
} 


if(isset($_POST['done'])) {
	$final_password=$_POST['password'];
	$code_value = $_GET['code'];
	echo $final_password."<br>";
	echo $code_value;
	$storePass = password_hash(mysql_real_escape_string($_POST['password']) , 
    		PASSWORD_BCRYPT, array('cost' => 10));
	$sql1="UPDATE studentdetail SET Password='$storePass' WHERE Code='$code_value' ";
	if($conn->query($sql1)) {
		header('Location: check_in.php?code='.$code);
	}
}
?>


<html>
<head>
	<title>Libary | Password</title>
	<link rel="icon" href="img/Library.png">
	<link rel="stylesheet" type="text/css" href="css/styles.css">
	<style type="text/css">
	
	</style>
</head>
<body>
	<header>
	    <div class="nav">
	      <ul>
	        <li class="home"><a href="index.php">Home</a></li>
	        <li class="logs"><a href="logs.php">Logs</a></li>
	      </ul>
	    </div>
	</header>
    <div class="header">
		<h1 class="heading" align="center">
			Authentication
		</h1>

	</div>
	
	<div align="center">
		<div class="welcomeStatement" style="font-size:130%">
			Hey <strong><?php echo $name; ?> </strong>,<br> you need to set up password. 
		</div>
		<br>
		<form action="password.php?code=<?php echo $code?>" method="post" enctype="multipart/form-data" onsubmit="return validate()" name="pass">
			<input type="password" class="inputField" placeholder="Password" name="password"><br>
			<br>
			<input class="inputField" type="password" placeholder="Repeat Password" name="password1"><br><br>
			<button type="submit" name="done">Proceed</button> 
		</form>
	</div>
	<script type="text/javascript" src="js/password.js"></script>
</body>
</html>
