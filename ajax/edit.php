<?php

include('../includes/phpConnectHead.php');
$conn= mysqli_connect($servername,$username,$password,$database);

if(!$conn)
	echo "Error";

	$laptop="";
	$book_collection="";

	$code=$_POST['code'];

	if(isset($_POST['laptop']))
	{
		$laptop=$_POST['laptop_brand'];
	}
	
	$notebooks_num=	$_POST['notebooks'];

	$count_books=0;
	
	for($i=1;$i<=4;$i++)
	{
		$temp="inp".$i;
		if($_POST[$temp]=="")
		{
			;
		}
		else{
			$count_books=$count_books+1;
			$present_book=$_POST[$temp];
			$book_collection=$book_collection.$present_book."<br>";	
		}
	}

		
			$sql="UPDATE entrydetail
			SET Laptop='$laptop', Notebooks='$notebooks_num' , Books='$count_books' , BookNames='$book_collection' 
			WHERE Code='$code' AND TimeOut is NULL";

			if(mysqli_query($conn, $sql ))
				echo json_encode("updated successfully");
			else
				echo json_encode(mysqli_error($conn));


?>