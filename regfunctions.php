<?php

/////////////////////
////All aspects of the input heirarchy should be separated by a |
////example: manager|swap|ca|ck
/////////////////////

/////////////////////
////Sanitize to remove inadvertant characters from the entered string
/////////////////////

function viewable(){
	$qry = "Select viewable,accesslevel from phpos.UserPriv
where location like '".$_SERVER['PHP_SELF']."' 
and userid like '".$_SESSION['user']."' 
and authtype like '".$_SESSION['authtype']."' ; ";
$mysqli = new mysqli("localhost", "dbadmin", "*ty47vc*", "lmcms");
$result = $mysqli->query($qry);
$row = $result->fetch_assoc();
$mysqli->close();
echo $row['viewable'];
if ('1'!==$row['viewable']){
	echo '<br>You do not have access to this page.<br>';
	exit();
	}
	$_SESSION['accesslevel']=$row['accesslevel'];
	return $row;
}

function sanitize($string){
$newstring=	str_replace("'","",$string);
$newstring=	str_replace('/',"",$newstring);
$newstring=	str_replace("\"","",$newstring);
////This is needed for multiple products
//$newstring=	str_replace("*","",$newstring);
$newstring=	str_replace("\\","",$newstring);
$newstring=	str_replace("%","",$newstring); 
$newstring=	str_replace(";","",$newstring); 
$newstring=	str_replace("-","",$newstring); 
$newstring=	str_replace("+","",$newstring);
$newstring=	str_replace(".","",$newstring);  
return $newstring;
}

function sanitiz($string){
	$newstring = preg_replace("/[^a-zA-Z0-9\s]/", "", $string);
	return $newstring;
	}
//////////////////////////////////////
////sqlrpt creates an associative 
////array from a mysql connection
//////////////////////////////////////
function sqlrpt($server,$db,$user,$pw,$query)
{
$myconn = mysql_connect($server,$user,$pw);
$mydb = mysql_select_db($db,$myconn);
$myquery = mysql_query($query);
while($row = mysql_fetch_assoc($myquery))
    {
      $myresult[] = $row;
    }
return $myresult;
mysql_close($myconn);
}


function authmysql($user,$pass)	{
	$query = " Select * from UsersAuth where userid like '".$user."' ";
	echo $query;
	$auth = sqlrpt('localhost','phpos','dbadmin','*ty47vc*',$query);
	print_r($auth);
	if (strcmp(hash('sha256',$pass),$auth[0]['pass'])==0){
			session_start();
			$_SESSION['user'] = $user;
			$_SESSION['sid'] = session_id();
			$_SESSION['auth']=md5($_SESSION['sid'].$_SESSION['user']);
			$_SESSION['authtype'] = 'mysql';
			unset($auth);
			header( 'Location: http://localhost/phpos/pos.php' ) ;
	}else{
			header( 'Location: http://localhost/phpos/login.php' ) ;
			unset($auth);
		}
											}
											

function addusermysql($user,$pass)	{
	$query = " Select userid from UsersAuth where userid like '".$user."' ";
	echo $query;
	$myconn = mysql_connect('localhost','dbadmin','*ty47vc*');
	$mydb = mysql_select_db('phpos',$myconn);
try {
    //throw exception if result returns no records
    $result = mysql_query($query);
    }	catch(Exception $e)
  {
  echo 'Message: ' .$e->getMessage();
  }
	
	$auth = mysql_fetch_assoc($result);

	print_r($auth);
	if(isset($auth['userid'])){
		echo "I'm Sorry but that username already exists.<br> Please choose another.<br>";
		echo '<a href="http://localhost/phpos/newlogin.php">Back to New Login Page</a>'  ;
	}else	if($_POST['password']!==$_POST['repassword']){
		echo "I'm Sorry but your passwords don't match.<br> Please re enter them.<br>";
		echo '<a href="http://localhost/phpos/newlogin.php">Back to New Login Page</a>'  ;
		}else{
			$insert = " Insert into UsersAuth( userid,pass)
							Values ( '".$user."','".hash('sha256',$pass)."');";
			echo $insert;
			if($res=mysql_query($insert, $myconn)){
				echo 'Your Username and Password have been added';
				}
		echo '<a href="http://localhost/phpos/newlogin.php">Back to New Login Page</a>'  ;
		echo '<br><a href="http://localhost/phpos/login.php"> Login Page</a>'  ;
							}
				mysql_close($myconn);
	
											}											
											
function authldap($user,$pass)	{
///////LDAP FROM AD login
// using ldap bind
session_start();
$_SESSION['user'] = $user;
$_SESSION['sid'] = session_id();
$_SESSION['auth']=md5($_SESSION['sid'].$_SESSION['user']);
$_SESSION['authtype'] = 'ldap';
// connect to ldap server

$ldapconn = ldap_connect("192.168.0.240")
    or die("Could not connect to LDAP server.");
ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);

$binddn = $_SESSION['user']."@lamontanita.local";
echo $binddn;
    // binding to ldap server
    $ldapbind = ldap_bind($ldapconn,$binddn, $pass);
	ldap_close($ldapconn);
    // verify binding
    if ($ldapbind) 	{
		$filter='samaccountname='.$_SESSION['user']; 
      $sr=ldap_search($ldapconn, "ou=LMC, dc=lamontanita, dc=local",$filter); 
		$info = ldap_get_entries($ldapconn, $sr);
		$group = $info[0]['memberof'];
	foreach ($group as $item)	{
		$itm=str_replace('CN=','',$item);
		//$itm=str_replace(',OU=LMC,DC=lamontanita,DC=local','',$itm);
		$nmb = strpos($itm,',');
		$grp[] = substr($itm,0,$nmb);
										}
				echo '<pre>';
				print_r($grp);
				echo '</pre>';
         header( 'Location: http://localhost/phpos/pos.php' ) ;
	
							}else	{
							echo 'ldap Bind unsuccessful';
									}
//evaluate group access level
//
//
//
//
//
//
//
}



?>
