<?php
function ldap_call($connection,$bind_user,$bind_pass,$filter){
$ds=ldap_connect($connection);
if ($ds) {  
    $r=ldap_bind($ds,$bind_user,$bind_pass);  
    //$filter="(|(mail= null)(objectCategory=group))"; 
    $sr=ldap_search($ds, "ou=LMC, dc=lamontanita, dc=local",$filter);  
  	ldap_sort($ds,$sr,"cn");
    $info = ldap_get_entries($ds, $sr);
    //echo $info["count"] . " results returned:<p>";
/*	echo "<table id='ldaptable' border=1><tr><th>Name</th><th>E-mail</th></tr>";
    for ($i=0; $i<$info["count"]; $i++) {
    		if($info[$i]["mail"][0]!=null){
        echo "<td>". $info[$i]["cn"][0] . "</td>";
        echo "<td>" . $info[$i]["mail"][0] . "</td></tr>";
    }
    }    
	echo "</table>";*/
	echo '<pre>';
	print_r($info);
return $info;	
ldap_close($ds);

} else {
    echo "<h4>LDAP_CALL unable to connect to LDAP server</h4>";
}
}
ldap_call('192.168.0.240','diracct','up@organ','(|(cn=Co-Op)(objectCategory=person))');
?>