<html>
<head>
<title>
PHPos
</title>
   <script type="text/javascript">
        function Scroll () {
            var myCont = document.getElementById ("receipt");
            myCont.scrollTop = 4000;
        }
    </script>

</head>
<body>
<div id="header"
style="	width:960px ;
			height:96px ;
			border:1px solid black;
			background-color:#efeeee; 
			left:0px;
			top:0px;
			text-align: center;
			position:absolute;">
<iframe src="header.php"  id="header" width="100%" 
frameborder="0" height="100%" scrolling="no">
</iframe>
</div>
<div id="receipt" name="receipt"
			onload="Scroll ();"
			style="	width:480px ;
					height:520px ;
					border:1px solid black;
					background-color:#ffffbb; 
					left:0px;
					top:97px;
					text-align: center;
					position:absolute;">
			<iframe src="receipt.php" id="receipt" name="receipt" width="100%" scrolling="vertical"
			frameborder="0" height="100%" scrolling="no">
			</iframe>
</div>
<div id="Options"
			style="	width:480px ;
					height:520px ;
					border:1px solid black;
					background-color:#eeeefe; 
					left:480px;
					top:97px;
					text-align: center;
					position:absolute;">
			<iframe src="options.php" id="options" width="100%" 
			frameborder="0" height="100%" scrolling="no">
			</iframe>
</div>
<div id="totals"
style="	width:960px ;
			height:144px ;
			border:1px solid black;
			background-color:#eefeee; 
			left:0px;
			top:618px;
			text-align: center;
			position:absolute;">
			<iframe src="totals.php" id="totals" width="100%" 
			frameborder="0" height="100%" scrolling="no">
			</iframe>
</div>
</body>
</html>