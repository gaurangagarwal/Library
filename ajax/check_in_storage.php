<?php

include('../includes/phpConnectHead.php');
$conn=new mysqli($servername,$username,$password,$database);

if($conn)
	;
else
	echo "Error";

	$laptop="";
	$book_collection="";

	$code=$_POST['code'];

	if(isset($_POST['laptop']))
	{
		$laptop=$_POST['laptop_brand'];

	}
	
	$notebooks_num=	$_POST['notebooks'];
	
	$personal_books_num=$_POST['personal_books'];

	if($personal_books_num==0)
	{
		;		
	}
	else{

		$i=0;


		for($i=1;$i <= $personal_books_num;$i++)
		{
			$n="inp".$i;
			$present_book=$_POST[$n];
			
			$book_collection=$book_collection.$present_book."<br>";			
		}


	}

			
			$sql="INSERT INTO entrydetail(Code,Laptop,Notebooks,Books,BookNames,TimeIn)
			VALUES('$code','$laptop','$notebooks_num','$personal_books_num','$book_collection',now())";

			if($conn->query($sql))
			echo json_encode("entered successfully");

?>