
<html>
<head>
	<title>
		Library | Check Out
	</title>
	<link rel="stylesheet" type="text/css" href="css/check_in.css">
	<link rel="stylesheet" type="text/css" href="css/styles.css">
	<link rel="icon" href="img/Library.png">
	<style type="text/css">
	
	</style>
</head>

<body >
<?php
	$code = $_GET['code'];
	include('includes/phpConnectHead.php');
	$conn=new mysqli($servername,$username,$password,$database);

	if(!$conn)
		echo "Error";

	$sql_stud_det="SELECT * FROM studentdetail WHERE Code='$code' ";
	$result_stud_det=$conn->query($sql_stud_det);
	if ($result_stud_det->num_rows == 0) {  // if no such code exists redirect to home page
		header('Location: index.php');
	}
	$row_stud_det=$result_stud_det->fetch_assoc();
	$name = $row_stud_det['Name'];
	$email = $row_stud_det['Email'];
	$dept = $row_stud_det['Group'];		

	$sql="SELECT * FROM entrydetail WHERE Code='$code' AND TimeOut is NULL";
	$result=$conn->query($sql);
	$row=$result->fetch_assoc();
	$timeIn = $row["TimeIn"];

	// regarding the password
	$access = 0; // access Not granted
	if(isset($_POST['codePass'])) {
		$entered_password=$_POST['password'];
		$code = $_POST['codePass'];
		$sql="SELECT Password FROM studentdetail WHERE Code='$code' ";
		$result=$conn->query($sql);
		$roww=$result->fetch_assoc();
		if(password_verify( $entered_password, $roww['Password'])) {						
			$access= 1; // access Granted
		}
	}	
?>

	<div id="message" style="display:none">
		<table align="center" style="width:100%;" height="150" border="0">
			<tr>
				<td width="50%" id="messageText" style="text-align:center; font-size:35px;">Loading</td>
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
			Check-Out Portal
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
				<th>Time In</th>
				<td id="timeIn">
					<?php
						$dt = new DateTime($timeIn);
						$date = $dt->format('d M,y');
						$time = $dt->format('g:i a');
						echo $date, '  | ', $time;
 					?>
 				</td>
			</tr>
			<tr class="inf_tr">
				<th>Duration</th>
				<td id="duration">
					<?php
						$datetime1 = new DateTime();
						$datetime2 = new DateTime($timeIn);
						$interval = $datetime1->diff($datetime2);
						if($interval->format('%y') != '0')
							echo $interval->format('%y')." years ";
						if($interval->format('%m') != '0')
							echo $interval->format('%m')." months ";	
						if($interval->format('%a') != '0')
							echo $interval->format('%a')." days ";	
						if($interval->format('%h') != '0')
							echo $interval->format('%h')." hr ";	
						if($interval->format('%i') != '0')
							echo $interval->format('%i')." mins";	
						
						// $elapsed = $interval->format('%i minutes');
						// echo $elapsed;
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
						$sqlJoin = "SELECT entryDetail.TimeIn , entryDetail.TimeOut , entryDetail.Code
								FROM studentDetail
								INNER JOIN entryDetail
								ON entryDetail.Code = studentDetail.Code
								WHERE studentDetail.Name = '$name' and entryDetail.TimeOut IS NOT NULL
								ORDER BY entryDetail.TimeIn DESC";
						$logs =	 0;		
						$resultJoin = mysqli_query($conn, $sqlJoin);
						while($rowJoin = mysqli_fetch_assoc($resultJoin)) {
							$logs++;
							// if($logs>4)
								// break;
							$timeIn = new DateTime($rowJoin['TimeIn']);
							$timeOut = new DateTime($rowJoin['TimeOut']);
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
				<form method="post" action="check_out.php?code=<?php echo $code;?>">
				    <input placeholder="Password" class="inputField" type="password" id="password" name="password" /><br><br>
				  	<input type="text" style="display:none" id="codePass" value="<?php echo $code; ?>" name="codePass"/>
				    <button type="submit" id="passSubmit" name="passSub">Login</button>
				</form>
			</div>
		<?php
			} else {
		?>



		<div class="input_inf">
			<table width="100%" border="0">
			<tr>
				<td width="60%">

				<?php
					$check_lap=$row['Laptop'];
				?>		
					<label style="font-size:20px;">
						<strong>Laptop</strong><input type="checkbox" name="laptop" id="laptop" value="Laptop" onchange="laptop_name()" 
						<?php
							if($check_lap!="") 
								echo " checked='true'>";
							else
								echo " >";	
						?>
					</label>
				</td>
				<td>
					<div id="laptop_container">
					<?php
						if($check_lap!="") {
					?>
						<input type="text" name="laptop_brand" id="laptop_brand" class="laptop_brand" required="true" value="<?php echo $check_lap  ?>">
					<?php		
						}
					?>
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
						<?php
							$check_notebook=$row['Notebooks'];
							for($i =0 ; $i<=4; $i++) {
								echo "<option value='$i'"; 
									if($check_notebook == $i)
										echo " selected='true'>";
									else
										echo " >";
								echo "$i</option>";						
							}
						?>
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
					<?php
						$check_books=$row['Books'];
						$booksArr = explode("<br>", $row['BookNames']);
					?>

					<select class="dropDown" onchange="books(this.value, 
												<?php if($check_books==0) echo 1; else echo 2;?>
															)" id="personal_books" name="personal_books">
						<?php 
							for($i=0; $i<=4;$i++) {
								echo  "<option class='dropDownSub' value='$i'";
								if($i == $check_books) {
									echo " selected > ";
								} else
									echo " >";
								echo $i."</option>";
							}
						?>
					</select>
				</td>
			</tr>
				<td colspan="2">
				<div id="container">
					<?php
						for ($i=1; $i <=$check_books; $i++) { 
							echo "<input type='text' name='inp".$i."' id='inp".$i."' class='personal_books_fields' value='";
							echo $booksArr[$i-1]."'>";
						}
					?>
				</div>
				</td>
			</tr>
			
			<tr>
				<td colspan="2">
				<!-- <input type="submit" value="Save" name="save">	 -->
					<button style="margin-left:10%;" onclick="checkBtnClick('edit')" id="save" value="Save" name="save">Save</button>
					<input type="text" style="display:none" value="<?php echo $code; ?>" name="transfer_field" id="transfer_field">
					<!-- <button style="display:none"  type="text" value="<?php //echo $code ?>" name="transfer_field" id="transfer_field"></button> -->
					<button style="margin-left:10%;" onclick="checkBtnClick('out')"  id="check_out" value="Check Out" name="check_out">Check Out</button>
					
					<!-- <input type="submit" value="Check Out" name="submit">  -->
				</td>
			</tr>
			</table>
		</div>
		<?php
			}
		?>


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