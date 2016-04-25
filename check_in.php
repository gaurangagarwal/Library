<?php
// session_start();

include('includes/phpConnectHead.php');
$conn= mysqli_connect($servername,$username,$password,$database);

if($conn)
	;
else
	echo "Error";

	$received_code=$_GET['code'];

	$sql="SELECT Password FROM studentdetail WHERE Code='$received_code' ";

	$result=$conn->query($sql);
	$row=$result->fetch_assoc();

	$password=$row['Password'];

	if($password==NULL) {
		header('Location: password.php?code='.$received_code);
	}

?>

<html>
<head>
	<title>Library | Check in</title>
	<link rel="stylesheet" type="text/css" href="css/check_in.css">
  	<link rel="stylesheet" type="text/css" href="css/styles.css">
	<link rel="icon" href="img/Library.png">	
</head>

<body>

<?php
	if(!isset($_GET['code']))
		header('Location: index.php');

	$code = $_GET['code'];
	include('includes/phpConnectHead.php');
	$conn = mysqli_connect($servername,$username,$password,$database);
	$sql = "SELECT * FROM entrydetail WHERE Code = '$code' and TimeOut IS NULL";
	$result = mysqli_query($conn , $sql);
	if(mysqli_num_rows($result) > 0) { // redirects to check_out if person is checked In
		header('Location: check_out.php?code='.$code);
	}

	$sql = "SELECT * FROM studentdetail WHERE Code = '$code'";
	$result = mysqli_query($conn , $sql);
	if(mysqli_num_rows($result) == 0) {// if no such code exists redirect to home page
		header('Location: index.php');
	}
	$row = mysqli_fetch_assoc($result);
	$name = $row['Name'];
	$dept = $row['Group'];
	$email = $row['Email'];

	// regarding the password
	$access = 0; // access Not granted
	if(isset($_POST['passSub'])) {
		$entered_password=$_POST['password'];
		$code=$_POST['codePass'];
		$sql="SELECT Password FROM studentdetail WHERE Code='$code' ";
		$result=$conn->query($sql);
		$roww=$result->fetch_assoc();
		if(password_verify( $entered_password, $roww['Password'])) {						
			$access= 1; // access Granted
		}
	}
?>
	<!-- <div id="dialog" title="Login Required" width="30%"> -->
	    
	<!-- </div> -->
	<div id="message" style="display:none">
		<table align="center" style="width:100%;" height="150" border="0">
			<tr>
				<td width="50%" id="messageText" style="text-align:center; font-size:35px;">Checked In</td>
				<td style="padding-left:10%"><img id="messageImage" src="img/complete.png" width="70%"></td>	
			</tr>
		</table>
	</div>


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
			Check-In Portal
		</h1>

	</div>
	<div class="welcomeStatement">
		Welcome <strong><?php echo $name; ?></strong> 
	</div>

	<div class="content_inf">
		<div class="pers_inf">
		<table border="0" width="100%" id="table_inf">
	<!-- 		<tr>
				<th>Name</th>
				<td id="name"> </td>
			</tr> -->
			
			<tr class="inf_tr">
				<th>Entry-number</th>
				<td id="entry_num"><?php  echo $code; ?></td>
			</tr>	
			
			<tr class="inf_tr">
				<th>Department</th>
				<td id="department"><?php  echo $dept; ?> </td>
			</tr>	
				
			<tr class="inf_tr">
				<th>Mail id</th>
				<td id="mail"><?php  echo $email; ?> </td>
			</tr>
			<tr class="inf_tr">
				<th>Current Time</th>
				<td id="timeIn">
					<?php
						$dt = new DateTime();
						$date = $dt->format('d M,y');
						$time = $dt->format('g:i a');
						echo $date, '  | ', $time;
 					?>
 				</td>
			</tr>
			<tr>
				<td style="border:0px"><strong>Recent Logs</strong></td>
			</tr>
			<tr>
				<td colspan="2">
					<div  style="margin-left:30%">
					<?php
						$sql = "SELECT entryDetail.TimeIn ,entryDetail.TimeOut , entryDetail.Code
								FROM studentDetail
								INNER JOIN entryDetail
								ON entryDetail.Code = studentDetail.Code
								WHERE studentDetail.Name = '$name'
								ORDER BY entryDetail.TimeIn DESC";
						$logs =	 0;		
						$result = mysqli_query($conn, $sql);
						while($row = mysqli_fetch_assoc($result)) {
							$logs++;
							// if($logs>5)
							// 	break;
							$timeIn = new DateTime($row['TimeIn']);
							$timeOut = new DateTime($row['TimeOut']);
							$date = $timeIn->format('d M,y');
							$timeIn = $timeIn->format('g:i a');
							$timeOut = $timeOut->format('g:i a');
							if($logs == 4)
								echo "<div id='more' style='display:none'>";
							echo "<strong>".$date."</strong> :-  ".$timeIn." to  ".$timeOut."<br>"; 
						}
						if($logs >=4)
							echo "</div>";
					?>
					<?php if($logs >= 4) { ?>
						<a onclick="moreBtnClick()" id="moreBtn">more..</a>
					<?php } ?>
					</div>
				</td>
			</tr>	
		</table>

		</div>

		<?php 
			if($access == 0) {
		?>
			<div class="input_inf" width="100%">
				<form method="post" action="check_in.php?code=<?php echo $code;?>">
				    <input placeholder="Password" class="inputField" type="password" id="password" name="password" /><br><br>
				  	<input type="text" style="display:none" id="codePass" value="<?php echo $code; ?>" name="codePass"/>
				    <button type="submit" id="passSubmit" name="passSub">Login</button>
				</form>
			</div>
		<?php
			} else {
		?>


		<div class="input_inf">
			
			<!-- <form enctype="multipart/form-data" class="input_form"> -->
				<!-- <br> -->
			<table width="100%" border="0">
			<tr>
				<td width="60%">
					<label style="font-size:20px;">
						<strong>Laptop</strong><input type="checkbox" name="laptop" id="laptop" value="Laptop" onchange="laptop_name()">
					</label>
				</td>	
				<td>
					<div id="laptop_container">
						
					</div>
				</td>
			</tr>
			<tr>
				<td>
					<span class="formLabel">
						<strong>Notebooks</strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					</span>
				</td>
				<td>
				<select class="dropDown" name="notebooks" id="notebooks">
					<option class="dropDownSub" value="0" selected>0</option>
  					<option class="dropDownSub" value="1">1</option>
  					<option class="dropDownSub" value="2">2</option>
  					<option class="dropDownSub" value="3">3</option>
 					<option class="dropDownSub" value="4">4</option>
				</select>
				</td>
			</tr>
			<tr valign="top">
				<td>
					<span class="formLabel">
						<strong>Personal Books</strong>&nbsp;&nbsp;&nbsp;&nbsp;
					</span>	
				</td>
				<td>	
					<select class="dropDown" onchange="books(this.value, 1)" id="personal_books" name="personal_books">
						<option class="dropDownSub" value="0" selected>0</option>
	  					<option class="dropDownSub" value="1">1</option>
	  					<option class="dropDownSub" value="2">2</option>
	  					<option class="dropDownSub" value="3">3</option>
	 					<option class="dropDownSub" value="4">4</option>
					</select>
					
				</td>
			</tr>
			<tr >
				<td colspan="2">
					<div id="container">
					</div>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<button style="margin-left:30%;" onclick="checkBtnClick('in')" name="check_in" id="check_in">Check In</button>
				</td>
			</tr>
			</table>
				<!-- <input value="">	 -->
				<!-- <input type="text" value="" name="code" id="code"> -->

			<!-- </form>				 -->

		</div>
		<?php 
			}
		?>
	</div>

	<div class="footer">
	</div>

	<script type="text/javascript" src="js/jquery-2.2.0.min.js"></script>
	<script type="text/javascript" src="js/in_out.js"></script>
	<script type="text/javascript">
		function moreBtnClick() {
			var moreBtn =document.getElementById("moreBtn");
			if(moreBtn.innerHTML == "less..") {
				moreBtn.innerHTML= "more..";
			} else {
				moreBtn.innerHTML= "less..";
			}
			// var more= document.getElementById("more");
			// more.style.display = "block"; 
			$("#more").slideToggle();	
		}
	</script>
</body>


</html>