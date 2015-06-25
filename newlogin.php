<html>
<head></head>
<?php
echo '<body OnLoad="document.loginform.username.focus();">';
session_start();
$sid=session_id();
//echo $sid.'=id<br>';
session_destroy();
echo'
<form name="loginform" method="post" action="addnewuser.php">
New Username<input name="username" type="text"><br>
Enter Password<input name="password" type="password"><br>
Enter Password Again<input name="repassword" type="password"><br>
<input id="login" type="submit" value="Submit New Login">
</form>';
?>
</body>
</html>
