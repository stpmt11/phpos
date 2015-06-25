<?php
//////////////////////////////////////
////mysqlexe  executes a mysql 
////query or sql command 
//////////////////////////////////////
function mysqlexe($server,$db,$user,$pw,$query,$desc)
{
$myconn= new mysqli($server,$user,$pw,$db);
if($myconn->query($query)){
echo $desc ." successful";
echo "<br>";
	}else{
echo $desc." NOT successful  ---";
echo "<br>";
//echo $query;
	}	
mysqli_close($myconn);
}
//////////////////////////////////////
////mysqlrpt creates an associative 
////array from a mysql connection
//////////////////////////////////////
function mysqlrpt($server,$db,$user,$pw,$query)
{
$myconn = mysql_connect($server,$user,$pw);
$mydb = mysql_select_db($db,$myconn);
$myquery = mysql_query($query);
while($row = mysql_fetch_assoc($myquery))
    {
      $myresult[] = $row;
    }
return $myresult;
mysql_close(myconn);
}
//////////////////////////////////////
////mssql executes a mssql
////query or command
//////////////////////////////////////
function mssqlexe($server,$db,$user,$pw,$query,$desc)
{
$msconn = mssql_connect($server,$user,$pw);
$msdb = mssql_select_db($db,$msconn);
$msquery = mssql_query($query);
if($msquery){
echo $desc ." successful";
echo "<br>";
	}else{
echo $desc." NOT successful  ---";
echo "<br>";
//echo $msquery;
	}
	mssql_close($msconn);
}
//////////////////////////////////////
////mssqlrpt creates an associative
////array from a mssql connection
//////////////////////////////////////
function mssqlrpt($server,$db,$user,$pw,$query)
{
	//echo $query.' <br>';
$msconn = mssql_connect($server,$user,$pw);
$msdb = mssql_select_db($db,$msconn);
$msquery = mssql_query($query);
while($row = mssql_fetch_assoc($msquery))
    {
      $msresult[] = $row;
    }
return $msresult;	
//mssql_close($msconn);
//echo $query;
}

//////////////////////////////////////
////ldap_call generates a table 
////from a ldap query 
//////////////////////////////////////
function ldap_call($connection,$bind_user,$bind_pass,$filter){
$ds=ldap_connect($connection);
//echo $connection . $bind_user . $bind_pass . $filter ;
//personal e-mails 
if ($ds) {  
    $r=ldap_bind($ds,$bind_user,$bind_pass);  
    //$filter="(|(mail= null)(objectCategory=group))"; 
    $sr=ldap_search($ds, "ou=LMC, dc=lamontanita, dc=local",$filter);  
  	ldap_sort($ds,$sr,"cn");
    $info = ldap_get_entries($ds, $sr);
    //echo $info["count"] . " results returned:<p>";
	echo "<table id='ldaptable' border=1><tr><th>Name</th><th>E-mail</th></tr>";
    for ($i=0; $i<$info["count"]; $i++) {
    		if($info[$i]["mail"][0]!=null){
        echo "<td>". $info[$i]["cn"][0] . "</td>";
        echo "<td>" . $info[$i]["mail"][0] . "</td></tr>";
    }
    }    
	echo "</table>";
return $info;	
ldap_close($ds);

} else {
    echo "<h4>LDAP_CALL unable to connect to LDAP server</h4>";
}
}
//////////////////////////////////////
////AddDate creates a string representation of
////a date added with a month, day or year value
//////////////////////////////////////
function AddDate($Adt,$mo,$dy,$yr)
{
//echo $dt.'Orig Date <br>';
$dtY = date(Y,strtotime($Adt));//Year part
//echo $dtY .'Orig Year <br>';
$dtM = date(m,strtotime($Adt));//Month part
//echo $dtM .'Orig Month <br>';
$dtD = date(j,strtotime($Adt));//Day part
//echo $dtD .'Orig Day <br>';
return $dt = date("Y-m-d", mktime(0,0,0,$dtM + $mo,$dtD + $dy,$dtY + $yr));
//echo $dt;
}
//////////////////////////////////////
//DayCalc takes a day and finds 
//the nearest day of the week a year ago 
//////////////////////////////////////
function DayCalc($Ddate){
$dateDay = date(w,$Ddate);//Day of the week
$yearago = AddDate($Ddate,0,1,-1);
$dateYDay = date(w,$yearago);
if($dateYDay<>$dateDay){
$yearago = date("Y-m-d",AddDate($yearago,0,1,0));
}
return $yearago ;
}
//////////////////////////////////////
////WeekCalc uses AddDate to find the start and
////end dates of the week for a given date string
//////////////////////////////////////
function WeekCalc($Wdate)
{
//Find Week Start and Week End.
//Note LMC weeks begin with Monday (phpday #1)
//PHP Weeks begin with Sunday (phpday #0)
//need to declare the AddDate function in any page that requires this function 
//include ('/var/www/LMCIntranet/Util/AddDate.php');
//echo $Wdate . ' Wdate value <br>';
$dtW = date(w,strtotime($Wdate));//Day Of The Week
//echo $dtW.' Original DtW<br>';
if(strcmp($dtW,0)<>0){
$dtW = ($dtW - 1);
}else{
$dtW = 6;
}
//echo $dtW.' Adjusted DtW<br>';
$week['Start'] = AddDate($Wdate,0,-$dtW,0);
$week['End'] = AddDate($week['Start'],0,+6,0);
return $week;
}
//////////////////////////////////////
////Monthcalc takes a date and returns the first and last day of that month
////into an array that contains the ['Start'] and ['End'] elements 
/////////////////////////////////////
function MonthCalc($Mdate)
{
$monthDate = date(m,strtotime($Mdate));//Month count
$yearDate = date(Y,strtotime($Mdate));//Year count
$month['Start'] = date("Y-m-d",mktime(0, 0, 0, $monthDate, 1, $yearDate));
$month['End'] = date("Y-m-d",mktime(0, 0, 0, $monthDate + 1, 0, $yearDate));
$test = $month['Start'];
$test2 = $month['End'];
//echo $test .' test1 and test2 '.$test2.'<br>';
return $month;
}
//////////////////////////////////////
////dropdown_List creates an html dropdown box
////from a mssql query supporting both a field 
////and a returnfield for user selection**not yet functional
//////////////////////////////////////
function dropdown_List($field,$table,$PostName,$server,$user,$pw,$returnField)
{
if($returnField == null){
$returnField = $field;
}
mssql_connect($server,$user,$pw);
$query = mssql_query("SELECT Distinct ".$field." as 'col1',".$returnField." as 'col2' from ".$table." Union Select '',''");
echo '<select name="'.$PostName.'"><br>';
while ($row = mssql_fetch_assoc($query))
{
foreach ($row as $col => $val)
	{if(strcmp($col,'col1')<>0){$nKEY = $val;}
	 if(strcmp($col,'col2')<>0){$arey[$nKEY]=$val;}
	}
}
foreach ($arey as $key => $data)
{
echo '<option id = "'.$data.'" value = "'.$key.'" >'.$key.' '.$data.'</option><br>';
}
echo '</select>';
}
//////////////////////////////////////
////dd_List creates an html dropdown box
////from a mssql query supporting both a field 
////and a returnfield for user selection
//////////////////////////////////////
function dd_List($field,$table,$PostName,$server,$user,$pw)
{
//if($returnField == null){
$returnField = $field;
//}
mssql_connect($server,$user,$pw);
$query = mssql_query("SELECT Distinct ".$field." from ".$table." Group By ".$field." Union Select ''");
echo '<select name="'.$PostName.'"><br>';
while ($row = mssql_fetch_assoc($query))
{
foreach ($row as $data)
{
echo '<option id = "'.$data.'" value = "'.$data.'" >'.$data.'</option><br>';
}
}
echo '</select>';
}
//////////////////////////////////////
////my_List creates an html dropdown box
////from a mysql query supporting both a field 
////and a returnfield for user selection
//////////////////////////////////////
function my_List($field,$table,$PostName)
{
//if($returnField == null){
$returnField = $field;
//}
mysql_connect('itmysql','dbadmin','*ty47vc*');
$query = mysql_query("SELECT ".$field." from lmcds.".$table." Group By ".$field." Union Select ''");
//echo $query;
echo '<select name="'.$PostName.'"><br>';
while ($row = mysql_fetch_assoc($query))
{
foreach ($row as $data)
{
echo '<option id = "'.$data.'" value = "'.$data.'" >'.$data.'</option><br>';
}
}
echo '</select>';
}
//////////////////////////////////////
////DrawTbl creates an html table
////from a php array it also creates 
////a total for the selected number
////of columns counting from the 
////rightmost column
//////////////////////////////////////
function DrawTbl($arey,$cnt_tl_fld)
{
error_reporting(0);
$keys = array_keys($arey[0]);
$output = "<table id='areytable' border='1' ><tr>";
foreach ($keys as $hdr){
	$output .= "<th><center>".$hdr."</center></th>";
	}
$output .= "</tr>";
//table data goes here
$counter = Count($keys);
$tl = array(0,0,0,0,0,0,0,0);
foreach($arey as $row)
{
        // Handle record ...
       $output .= "<tr>";
		foreach ($row as $field){
		$output .= "<td><center>".$field."</center></td>";
		//insert totals here
		if($counter <= $cnt_tl_fld){
			$val = $tl[$counter];
			$tl[$counter] = $field+$val;
		}
		$counter--;
										}
		$output .= "</tr>";
		$counter = Count($keys);
}
if($cnt_tl_fld <>0){
$total = array_filter($tl);
$total[] = 'Totals:';
for(count($total) < count($keys);count($total) < count($keys);$total[] = '');
$total=array_reverse($total);
$output .= "<tr>";
$counter = Count($keys);
foreach ($total as $sum){
		if(is_int($sum)){
		$output .= "<th><center>".round($sum,2)."</center></th>";
						}else{
					$output .= "<th><center>".$sum."</center></th>"; 
							}
						}
$output .= "</tr>";
}					
//Close html table layout 
$output .= "</table>";
$output .= 'Total records in Report: ' . count($arey).'<br><br><br>';
echo $output;
return $output;
}

//////////////////////////////////////
////DrawsqlTbl creates an html table
////from a php array it also creates 
////a total for the selected number
////of columns counting from the 
////rightmost column --for rpt functions
//////////////////////////////////////
function DrawsqlTbl($arey,$cnt_tl_fld)
{
error_reporting(0);
//create html table layout
//headers from array key of first row
$keys = array_keys($arey[0]);
echo '<table id="sqltable" border="1" >';
echo "<tr>";
foreach ($keys as $hdr){
	echo "<th><center>".$hdr."</center></th>";
	}
echo "</tr>";
//table data goes here
$counter = Count($keys);
$tl = array(0,0,0,0,0,0,0,0);
foreach($arey as $row)
{
        // Handle record ...
      echo "<tr>";
	foreach ($row as $field){
		echo "<td><center>".$field."</center></td>";
		//insert totals here
		if($counter <= $cnt_tl_fld){
			$val = $tl[$counter];
			$tl[$counter] = $field+$val+0;
		}
		$counter--;
										}
		echo "</tr>";
		$counter = Count($keys);
}
if($cnt_tl_fld <>0){
$total = array_filter($tl);
$total[] = 'Totals:';
for(count($total) < count($keys);count($total) < count($keys);$total[] = '');
$total=array_reverse($total);

echo "<tr>";
$counter = Count($keys);
foreach ($total as $sum){
		if(is_int($sum)){
		echo "<th><center>".round($sum,2)."</center></th>";
						}else{
					echo "<th><center>".$sum."</center></th>";
							}
						}
echo "</tr>";	
}					
//Close html table layout 
echo "</table>";

echo "<br>";
echo '<div class="tbltotal">Total records in Report: ' .count($arey).'</div>';

}
//////////////////////////////////////
////getloc determines the location from which
////the client is currently requesting a page
//////////////////////////////////////
function getloc(){
$client = substr($_SERVER['REMOTE_ADDR'],8,2);//location of user running report
	switch ($client) {
    case '0.':
       	$loc = "N";
        break;
    case '1.':
       	$loc = "N";
        break;
    case '2.':
      	$loc = "R";
        break;
    case '3.':
      	$loc = "S";
        break;
    case '4.':
      	$loc = "G";
        break;
    case '5.':
      	$loc = "U";
        break;
    default:
      	$loc = "N";
        break;
        }
return $loc;
}
//////////////////////////////////////
////getlocsrv determines the location from which
////the client is currently requesting a page
////it extends the results to allow for login info
//////////////////////////////////////
function getlocsrv(){
$client = substr($_SERVER['REMOTE_ADDR'],8,2);//location of user running report
	switch ($client) {
    case '0.':
    		$loc['abbr']= 'N';
       	$loc['srv'] = "nobhillserver";
       	$loc['user'] = 'sa';
       	$loc['pw'] = '';
        break;
    case '1.':
  		   $loc['abbr']= 'N';
       	$loc['srv'] = "nobhillserver";
       	$loc['user'] = 'sa';
       	$loc['pw'] = '';
        break;
    case '2.':
    		$loc['abbr']= 'R';
       	$loc['srv'] = "valleyserver";
       	$loc['user'] = 'sa';
       	$loc['pw'] = '';
        break;
    case '3.':
     		$loc['abbr']= 'S';
       	$loc['srv'] = "santafeserver";
       	$loc['user'] = 'sa';
       	$loc['pw'] = '';
        break;
    case '4.':
    		$loc['abbr']= 'G';
       	$loc['srv'] = "gallupserver";
       	$loc['user'] = 'sa';
       	$loc['pw'] = '';
        break;
    case '5.':
     		$loc['abbr']= 'U';
       	$loc['srv'] = "unmgrabngo";
       	$loc['user'] = 'sa';
       	$loc['pw'] = 'gak@fahq2';
        break;
    default:
        	$loc['abbr']= 'N';
       	$loc['srv'] = "nobhillserver";
       	$loc['user'] = 'sa';
       	$loc['pw'] = '';
        break;
        }
return $loc;
}
//////////////////////////////////////
////sanitize removes certain characters from 
////user input and returns the string without 
////potentially dangerous characters. This is
////specifically to avoid code injection
//////////////////////////////////////
function sanitize($string){
$newstring=	str_replace("'","",$string);
$newstring=	str_replace('/',"",$newstring);
$newstring=	str_replace("\"","",$newstring);
$newstring=	str_replace("*","",$newstring);
$newstring=	str_replace("\\","",$newstring);
$newstring=	str_replace("%","",$newstring); 
$newstring=	str_replace(";","",$newstring); 
$newstring=	str_replace("-","",$newstring); 
$newstring=	str_replace("*/","",$newstring); 
$newstring=	str_replace("/*","",$newstring); 
$newstring=	str_replace("+","",$newstring); 
return $newstring;
}
//////////////////////////////////////
////sanitize removes certain characters from 
////user input and returns the string without 
////potentially dangerous characters. This is
////specifically to avoid code injection
//////////////////////////////////////
function sanitizepost($string){
$newstring=	str_replace("\"","",$newstring);
return $newstring;
}

//////////////////////////////////////
////areyexportcsv takes an array and prepares it 
////to be sent to a csv file.  Post this as a variable 
////to another page with the proper headers as a csv file
//////////////////////////////////////

function areyexportcsv($arey,$file){
////headers first
	$output = implode(',',array_keys($arey[0]));
	$output .= "\n";
////cycle through records and add them to output
foreach($arey as $line){
	$output .= rtrim(implode(',',$line),',');
	$output .= "\n";
}
	echo '<form name="export" method="post" action="export.php">
<input name="arey" value="'.$output.'" type="hidden">
<input name="file" value="'.$file.'" type="hidden">
<input name="Export" value="Export to csv(Excel)" type="submit">
</form>';
//	return $output
}
//////////////////////////////////////
////areyexporthtml takes an array and prepares it 
////to be sent to a html file.  Post this as a variable 
////to another page with the proper headers as a html file
//////////////////////////////////////

function areyexporthtml($data,$file){
	echo '<form name="export" method="post" action="exporthtml.php">
	<input name="output" value="'.$data.'" type="hidden">
	<input name="file" value="'.$file.'" type="hidden">
	<input name="Export" value="Export to html" type="submit">
	</form>';
	}
	
//////////////////////////////////////
////add_check_digit coverts upc into a full ean 
////and adds the calculated check digit
//////////////////////////////////////
function add_check_digit($nmb)
{
//GTIN12 = UPC-a  12 digit upc including check digit
//GTIN13 = EAN    13 digit EAN code with check digit
//Break out the number into it's digits
//n1 = ean only(you can add a '0' in front of the upc to make it ean compatible)
//n1	/n2/n3/n4/n5/n6/n7/n8/n9/n10/n11/n12/  /n13(check digit)
//*1	/*3/*1/*3/*1/*3/*1/*3/*1/ *3/ *1/ *3/
//take the digits and multiply them individually by the number below itself.
//(Every other number is a 3 nad every other number is a 1)
//n1+3(n2)+n3+3(n4)+n5+3(n6)+n7+3(n8)+n9+3(n10)+n11+3(n12)= $checksum
//take the right most digit of the checksum and subtract it from 10
//test numbers 
//01583900001-5,072778300260-0,02739300420-0,05138188714-8,
//74515890022-1,88424400820-2,85685600101-8 
		
	while(substr($nmb,0,1)=='0'){
		$nmb = substr($nmb,1,strlen($nmb)-1);
											}
	//echo $nmb.'<br>';
	$num = array_reverse(str_split($nmb));
	$checksum = 0;
	$count = 0;
	foreach($num as $place => $digit){
	if($count==0)		{
	$checksum += 3*$digit;
	//echo '+3]';
	$count = 1;
								}else{
	$checksum += $digit;
	//echo '+1]';
	$count = 0;
								}
	if(strcmp('0',substr($checksum,strlen($checksum)-1,1))<>'0'){
	$checkdigit = 10-substr($checksum,strlen($checksum)-1,1);
	}else{
	$checkdigit = 0;
	}
	$number = $nmb.$checkdigit;
												}
	/*	
	if(substr($number,0,1)==0)	{
	$number = substr($number,1,strlen($number)-1);
										}else{
	$number = substr($number,0,strlen($number)-1);
										}
	*/
	while(strlen($number)<12)	{
	$number = '0'.$number;
										}
	if(strlen($number)>13)	{
	$number = substr($nmb,0,13);
										}
	return $number;
unset($place);
}

//////////////////////////////////////
////DrawTblCk is the version of DrawTbl that 
////adds the check digit to each UPC
//////////////////////////////////////
function DrawTblCk($arey,$cnt_tl_fld)
{error_reporting(0);
$keys = array_keys($arey[0]);
$output = "<table id='areytable' border='1' ><tr>";
foreach ($keys as $hdr){
	$output .= "<th><center>".$hdr."</center></th>";
	}
$output .= "</tr>";
//table data goes here
$counter = Count($keys);
$tl = array(0,0,0,0,0,0,0,0);
foreach($arey as $row)
{
        // Handle record ...
       $output .= "<tr>";
		foreach ($row as $field){
			
			if($field == $row['upc']){
			$fld = add_check_digit($field);
			}else{
			$fld = $field;
			}			
			
		$output .= "<td><center>".$fld."</center></td>";
		//insert totals here
		if($counter <= $cnt_tl_fld){
			$val = $tl[$counter];
			$tl[$counter] = $field+$val;
		}
		$counter--;
										}
		$output .= "</tr>";
		$counter = Count($keys);
}
if($cnt_tl_fld <>0){
$total = array_filter($tl);
$total[] = 'Totals:';
for(count($total) < count($keys);count($total) < count($keys);$total[] = '');
$total=array_reverse($total);
$output .= "<tr>";
$counter = Count($keys);
foreach ($total as $sum){
		if(is_int($sum)){
		$output .= "<th><center>".round($sum,2)."</center></th>";
						}else{
					$output .= "<th><center>".$sum."</center></th>"; 
							}
						}
$output .= "</tr>";
}					
//Close html table layout 
$output .= "</table>";
$output .= 'Total records in Report: ' . count($arey).'<br><br><br>';
echo $output;
return $output;
}

//////////////////////////////////////
////DrawFSSTbl creates an html table
////from a php array it also creates 
////a total for the selected number
////of columns counting from the 
////rightmost column Customized for the full store sales
//////////////////////////////////////
function DrawFSSTbl($arey,$q2)
{
error_reporting(0);
$cnt_tl_fld = 6;
$keys = array_keys($arey[0]);
$output = "<table id='areytable' border='1' ><tr>";
foreach ($keys as $hdr){
	$output .= "<th><center>".$hdr."</center></th>";
	}
$output .= "</tr>";
//table data goes here
$counter = Count($keys);
$tl = array(0,0,0,0,0,0,0,0);
foreach($arey as $row)
{
        // Handle record ...
       $output .= "<tr>";
		foreach ($row as $field){
		$output .= "<td><center>".$field."</center></td>";
		//insert totals here
		if($counter <= $cnt_tl_fld){
			$val = $tl[$counter];
			$tl[$counter] = $field+$val;
		}
		$counter--;
										}
		$output .= "</tr>";
		$counter = Count($keys);
}
if($cnt_tl_fld <>0){
$total = array_filter($tl);
$total[] = 'Totals:';
for(count($total) < count($keys);count($total) < count($keys);$total[] = '');
$total=array_reverse($total);
$output .= "<tr>";
$counter = Count($keys);
$cnt = Count($keys);
$customercnt = mssqlrpt('mm-prod-cdc','posbdat','sa','',$q2);
foreach ($total as $sum){
		
			if($cnt==1){
				$output .= "<th><center>".$customercnt[0][computed]."</center></th>";
				}else{
					if(is_int($sum)){
							$output .= "<th><center>".round($sum,2)."</center></th>";
							$cnt = $cnt - 1;
						}else{
							$output .= "<th><center>".$sum."</center></th>";
							$cnt = $cnt - 1; 
							}
						}
					}
$output .= "</tr>";
}					
//Close html table layout 
$output .= "</table>";
$output .= 'Total records in Report: ' . count($arey).'<br><br><br>';
echo $output;
return $output;
}
?>