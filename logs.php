
<html>
<head>
	<title>
		Library | Check Out
	</title>
	<link rel="stylesheet" type="text/css" href="css/styles.css">
	<link rel="icon" href="img/Library.png">
	<style type="text/css">
	#heading {
		margin-bottom: 0px;
		font-size: 40px;
	}
	#monthNameHead{
		color:white;
		font-size: 150%;
		text-shadow:2px 2px black;
	}
	#datepicker{
		font-size: 18px;
		box-shadow: 2px 2px 8px #888;
	}
	select{
		box-shadow: 2px 2px 8px #888;
	}
	</style>
</head>

<body >

<header>
    <div class="nav">
      <ul>
        <li class="home"><a href="index.php">Home</a></li>
        <li class="logs"><a href="logs.php" class="active">Logs</a></li>
      </ul>
    </div>
</header>

<h1 align="center" id="heading">Logs</h1>
<table style="margin-left:5%;" border="0" cellspacing="20" cellpadding="8">
<tr valign="middle">
	<td style="font-size:20px; font-weight:bold;">Filters:</td>	
	<td style="padding-top:5%;">
	<form  method="post" action="logs.php" id="dateForm">
		<input name="date" onchange="dateFormSubmit()" id="datepicker" type="date" style="background-color:white">
	</form>
	</td>
	<td style="padding-top:5%;">	
	<form  method="post" action="logs.php" id="monthForm">
		<select id="month" onchange="monthFormSubmit()" class="dropDown" style="width:170px;background-position: 145px;" name="month">
			<option>Select Month</option>
			<?php 
				for($i = 1;$i <= 12; $i++){ 
				    $month =  date("F", mktime(0, 0, 0, $i)); 
				    echo "<option value='$i'>$month</option>"; 
				} 
			?>
		</select>
	</form>
	</td>
</tr>
</table>
<?php
	include('includes/phpConnectHead.php');
	$conn = mysqli_connect($servername,$username,$password,$database);
	$flag = 0; // to check if the form is submmited or not
	// $sql;
	if(isset($_POST['date'])) {
		$flag = 1;
		$postDate = new DateTime($_POST['date']);
		$postDateFormatted = $postDate->format('d F, Y');
		echo "<h3 style='margin-left:5%; margin-top:0px' >Date  :  <strong id='monthNameHead'>".$postDateFormatted."</strong> </h3>";
	} else if(isset($_POST['month'])) {
		$dateObj   = DateTime::createFromFormat('!m', $_POST['month']);
		$monthName = $dateObj->format('F');
		echo "<h3 style='margin-left:5%; margin-top:0px' >Month  :  <strong id='monthNameHead'>".$monthName."</strong></h3>";
		$flag = 1;
	} 

	$sql = "SELECT entryDetail.TimeIn , studentDetail.Name, studentDetail.Email, studentDetail.Group,
				entryDetail.Code, entryDetail.TimeOut,
					EXTRACT(DAY FROM TimeIn) AS DayIn, EXTRACT(MONTH FROM TimeIn) AS MonthIn, EXTRACT(YEAR FROM TimeIn) AS YearIn
			FROM studentDetail
			INNER JOIN entryDetail
			ON entryDetail.Code = studentDetail.Code
			ORDER BY entryDetail.TimeIn DESC";
	if($flag == 1) { 
		$srNo = 1;
		?>		
		<table width="90%" align="center" cellpadding="5" cellspacing="0">
			<tr style="font-size:20px;" >
				<td style=" border-bottom:2px solid white;"><strong>Sr. No.</strong></td>
				<td style=" border-bottom:2px solid white;"><strong>Name</strong></td>
				<td style=" border-bottom:2px solid white;"><strong>Entry Number</strong></td>
				<td style=" border-bottom:2px solid white;"><strong>Dept</strong></td>
				<td style=" border-bottom:2px solid white;"><strong>Email</strong></td>
				<td style=" border-bottom:2px solid white;"><strong>Time In</strong></td>
				<td style=" border-bottom:2px solid white;"><strong>Time Out</strong></td>
			</tr>
			<?php
				$result = mysqli_query($conn, $sql);
				while($row = mysqli_fetch_assoc($result)) {
					if(isset($_POST['date'])) {
						$dt = new DateTime($_POST['date']);
						$day = $dt->format('j');
						$month = $dt->format('n');
						$year = $dt->format('Y');
						if($row['DayIn']== $day &&  $row['YearIn']== $year &&  $row['MonthIn']== $month)  {
							echo "<tr>";
							echo "<td>".$srNo++."</td>";
							echo "<td>".$row['Name']."</td>";
							echo "<td>".$row['Code']."</td>";
							echo "<td>".$row['Group']."</td>";
							echo "<td>".$row['Email']."</td>";
							// echo "<td>".$row['TimeIn']."</td>";
							$dateT = new DateTime($row['TimeIn']);
							$dateTimeIn = $dateT->format('d M,y');
							$timeTimeIn = $dateT->format('g:i a');
							echo "<td>".$dateTimeIn, '  | ', $timeTimeIn."</td>";
							if($row['TimeOut'] != null) {
								$dateT = new DateTime($row['TimeOut']);
								$dateTimeOut = $dateT->format('d M,y');
								$timeTimeOut = $dateT->format('g:i a');
								echo "<td>".$dateTimeOut, '  | ', $timeTimeOut."</td>";
							} else {
								echo "<td> - </td>";
							}
							echo "</tr>";
						}
					} else {
						$month  = $_POST['month'];
						if($row['MonthIn'] == $month) {
							echo "<tr>";
							echo "<td>".$srNo++."</td>";
							echo "<td>".$row['Name']."</td>";
							echo "<td>".$row['Code']."</td>";
							echo "<td>".$row['Group']."</td>";
							echo "<td>".$row['Email']."</td>";
							$dateT = new DateTime($row['TimeIn']);
							$dateTimeIn = $dateT->format('d M,y');
							$timeTimeIn = $dateT->format('g:i a');
							echo "<td>".$dateTimeIn, '  | ', $timeTimeIn."</td>";
							if($row['TimeOut'] != null) {
								$dateT = new DateTime($row['TimeOut']);
								$dateTimeOut = $dateT->format('d M,y');
								$timeTimeOut = $dateT->format('g:i a');
								echo "<td>".$dateTimeOut, '  | ', $timeTimeOut."</td>";
							} else {
								echo "<td> - </td>";
							}	
							echo "</tr>";
							// echo $row['Name']."   " .$row['Code']."   ".$row['TimeIn']."<br>"; 
						}
					}
				}
			?>
		</table>
	<?php } ?>


<script type="text/javascript" src="js/jquery-2.2.0.min.js"></script>
<script type="text/javascript">
function dateFormSubmit() {
	var inputDate = document.getElementById("datepicker");
	console.log(inputDate.value);
	$('#dateForm').submit(); // <-- SUBMIT
}
function monthFormSubmit() {
	var inputDate = document.getElementById("month");
	console.log(inputDate.value);
	$('#monthForm').submit(); // <-- SUBMIT
}
</script>
</body>
</html>