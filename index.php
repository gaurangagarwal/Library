<!DOCTYPE html>
<html>
<head>
	<title>Library | Welcome</title>
  <link rel="stylesheet" type="text/css" href="css/styles.css">
  <link rel="icon" href="img/Library.png">

<style type="text/css">
  body{
    overflow: hidden;
  }
  #predictions li{
    width: 50%;
  }
</style>
</head>

<body>
  <header>
    <div class="nav">
      <ul>
        <li class="home"><a class="active" href="index.php">Home</a></li>
        <li class="logs"><a href="logs.php">Logs</a></li>
      </ul>
    </div>
  </header>

  <div id="headingHome">
    <ul>
      <li id="logo"><img src="img/iit.png" /></li>

      <!-- <div id="logo">
        <img src="iit.png" />
      </div> -->

      <li id="entry">
        <h1 align="center">LEEP</h1>
        <h2> Library Entry Exit Portal</h2>
        <!-- <h2>IIT, Ropar</h2>  -->
      </li>
    </ul>
  </div> 

  <div class="back" style="margin-bottom:2%;">
    <div id="main">
      <input type="text" id="input" onfocus="onFocusFunction()" onblur="onBlurFunction()" class="entryNumberInput" placeholder="Name..">
      <ul style="position:absolute" id="predictions">
        <!-- <li><a href="#">asd</a></li>
        <li><a href="#">asd</a></li> -->
      </ul>
    </div>
  </div>
<?php

  include('includes/phpConnectHead.php');
  $conn= mysqli_connect($servername,$username,$password,$database);

  $sql = "SELECT entryDetail.TimeIn , studentDetail.Name, studentDetail.Email, studentDetail.Group,
        entryDetail.Code, entryDetail.TimeOut,
          EXTRACT(DAY FROM TimeIn) AS DayIn, EXTRACT(MONTH FROM TimeIn) AS MonthIn, EXTRACT(YEAR FROM TimeIn) AS YearIn
      FROM studentDetail
      INNER JOIN entryDetail
      ON entryDetail.Code = studentDetail.Code
      ORDER BY entryDetail.TimeIn DESC";
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
        $logs= 0;
        while($row = mysqli_fetch_assoc($result)) {
              $logs++;
              if($logs > 8)  {
                break;
              }
            // $dt = new DateTime();
            // $day = $dt->format('j');
            // $month = $dt->format('n');
            // $year = $dt->format('Y');
            // if($row['DayIn']== $day &&  $row['YearIn']== $year &&  $row['MonthIn']== $month)  {
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
            // }
          } 
      ?>
    </table>




<script type="text/javascript" src="js/jquery-2.2.0.min.js"></script>
<script type="text/javascript" src="js/script.js"></script>
<script type="text/javascript">
 var predictions = document.getElementById("predictions");
  var input = document.getElementById("input");
  function onBlurFunction() {
    console.log(input.value);
    if(input.value == '' || input.value == input.defaultValue) {
      while(predictions.childNodes.length >0) {// removing old predictions
        predictions.removeChild(predictions.childNodes[0]);
      }
    }
  }
  function onFocusFunction() {
    console.log(input.value);
    if(input.value == '' || input.value == input.defaultValue) {
      while(predictions.childNodes.length >0) {// removing old predictions
        predictions.removeChild(predictions.childNodes[0]);
      }
    }
  }
</script>
</body>
</html>