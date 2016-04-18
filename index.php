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

  <div class="back">
    <div id="main">
      <input type="text" id="input" onfocus="onFocusFunction()" onblur="onBlurFunction()" class="entryNumberInput" placeholder="Name..">
      <ul id="predictions">
        <!-- <li><a href="#">asd</a></li>
        <li><a href="#">asd</a></li> -->
      </ul>
    </div>
  </div>
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