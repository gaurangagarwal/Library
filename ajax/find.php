<?php
	$value = $_POST['value'];
	// echo json_encode($value);
	include('../includes/phpConnectHead.php');
	$conn= mysqli_connect($servername,$username,$password,$database);
	if(!$conn) {
		echo mysqli_connect_error();
	}
	$arr = explode(" ",$value); // array of words
	$sql = null;
	if(count($arr) == 1) {
		$sql = "SELECT * FROM studentdetail WHERE Name LIKE '%" . $arr[0] .  "%'";
	} else if(count($arr) == 2){
		$sql = "SELECT * FROM studentdetail WHERE Name LIKE '%" . $arr[0] .  "%' and Name LIKE '%".$arr[1] ."%'";
	} else if(count($arr) == 3) {
		$sql = "SELECT * FROM studentdetail WHERE Name LIKE '%" . $arr[0] .  "%' and Name LIKE '%".$arr[1] ."%' and Name LIKE '%".$arr[2] ."%'";
	} else {
		$sql = "SELECT * FROM studentdetail WHERE Name LIKE '%" . $arr[0] .  "%' and Name LIKE '%".$arr[1] ."%' and Name LIKE '%".$arr[2] ."%' and Name LIKE '%".$arr[3] ."%'";
	} 
	// $sql = "SELECT * FROM studentdetail WHERE Name LIKE '%" . $value .  "%'";
	$result = mysqli_query($conn , $sql);
	$count = 0; // number of values matached
	$data = array();	
	if(mysqli_num_rows($result)) {
		while($row = mysqli_fetch_assoc($result)) {
			$data[$count++] = $row["Name"]; 
			$data[$count++] = $row["Code"]; 
			// echo json_encode($row["Name"]);
        	// echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
    	}
	}
	echo json_encode($data);
?>