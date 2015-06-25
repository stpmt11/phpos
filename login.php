<html>
<head></head>
<?php
echo '<body OnLoad="document.loginform.username.focus();">';
session_start();
$sid=session_id();
//echo $sid.'=id<br>';
session_destroy();
echo'
<form name="loginform" method="post" action="auth.php">
Username<input name="username" type="text"><br>
Password<input name="password" type="password"><br>
<input type="checkbox" name="loginType" value="LDAP"> LDAP<br>
<input type="checkbox" name="admin" value="admin"> Admin<br>
<input id="login" type="submit">
</form>';
echo '<br><a href="http://localhost/phpos/newlogin.php">Create New Login</a>'  ;
?>
</body>
</html>
