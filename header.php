
<?php
session_start();
$sid=session_id();
include('regfunctions.php');
echo $_SESSION['user'];
echo '
<div id="logout" 
			style="width:64px ;
			height:24px ;
			background-color:#efeeee; 
			left:884px;
			top:12px;
			text-align: center;
			position:absolute;">
<form id="logoutform" method="post" action="login.php" target="_top">
<input id="logout" type="submit" value="Sign Out">
</form>
</div>';
$vw = viewable();
/*
echo '<div 	id="input"
		style="	width:430px ;
				height:48px ;
				border:1px ;
				background-color:#ffffff; 
				left:10px;
				top:10px;
				text-align: center;
				position:absolute;">
		<iframe src="input.php" id="i-input" name="input" width="100%" 
		frameborder="0" height="100%" scrolling="no">
		</iframe>
</div><BR><BR><BR>';*/
?>



