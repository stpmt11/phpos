<?php
require_once("regfunctions.php");

if(isset($_POST['logout'])){
			session_unset();
			session_destroy();
		   header( 'Location: http://localhost/phpos/login.php' ) ;
}else{
if($_POST['loginType']=='LDAP'){
authldap($_POST['username'],$_POST['password']);
}else{
authmysql($_POST['username'],$_POST['password']);
}
}

?>
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
</div>