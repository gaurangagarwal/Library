<html>
<head>
<title>Test</title>
<!-- <link rel="stylesheet" type="text/css" href="css/styles.css"> -->
<style type="text/css">
	body {
		padding: 0px;
		margin: 0px;
	}
	.nav {
		font-size: 20px;
		background-color: #727272;
		text-align: right;
		box-shadow: 0px 0px 8px #888;
		/*margin-bottom: 0px;*/
		border:1px solid black;
	}
	.nav ul {
		padding-left: 4px;
		padding-right: 4px;
		margin: 0px;
	}
	.nav ul li  a {
		color: white;
		/*border:5px solid red;*/
	}
	.nav ul li {
		list-style-type: none;
		border:2px solid black;
		text-align: center;
		display: inline-block;
		width: 150px;
		padding: 5px 12px;
	}
	.nav ul li ul{
		position: absolute;
		width: inherit;
		margin-left: -18px;
		margin-top: 10px;
	}
	.nav ul li ul li{
		width: inherit;
		color: black;
		background-color: #ccc;
	}
	.tutorials:hover {
		text-align: center;
		background-color: #ccc;
	}
	
	.tutorials:hover  .subMenuTut li{
		display: block;

	}	
	.subMenuTut li:hover {
		display: block;
	}
	.nav ul li ul li{
		display: none;
	}
	a {
		text-decoration: none;
	}
	#main {
		margin-left: 25%;
		width: 50%;
	}
	#input {
		width: 100%;
		height:40px; 
		font-size:30px;
		margin-bottom: 0px;
	}
	#predictions{
		width: 100%;
		margin-top: 0px;
		list-style-type: none;
		/*border:1px solid black;*/
		padding: 0px;
	}
	#predictions li {
		border:1px solid black;
	}
	.back {
		/*border:5px solid black;*/
		width: 100%;
		height: 80%;
		background-color: #ccc;
		background-size: 100% 100%;
		padding-top:100px;
		margin: 0px; 
	}
</style>
</head>
<body>
	<!-- Header -->
	<div class="nav">
    	<ul>
    		<li><a href="#">Home</a></li>
    		<li class="tutorials"><a href="#">Tutorials</a>
	    		<ul class="subMenuTut">
	    			<li><a href="#">Tutorial 1</a></li>
	    			<li><a href="#">Tutorial 2</a></li>
	    		</ul>
    		</li>
    		<li><a href="#">About</a></li>
    		<li><a href="#">Newsletter</a></li>
    		<li><a href="#">Contact</a></li>
    	</ul>
    </div>

    <!-- Body-->
    <div class="back">
	    <div id="main">
	    	<input type="text" id="input">
	    	<ul id="predictions">
	    		<!-- <li><a href="#">asd</a></li>
	    		<li><a href="#">asd</a></li> -->
	    	</ul>
	    </div>
    </div>

<script type="text/javascript" src="js/jquery-2.2.0.min.js"></script>
<script type="text/javascript" src="js/script.js"></script>
</body>
</html>