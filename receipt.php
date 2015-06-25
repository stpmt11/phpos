<?php
//echo "This is the receipt Page.<br>";
require('regfunctions.php');
session_start();
session_regenerate_id();
$sid=session_id();
echo'
<div 	id="input"
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
</div><BR><BR><BR>
';

////////////
//evaluate input
////////////
if(isset($_POST['code'])){//1
$code = sanitiz($_POST['code']);
	if (strcmp($code,'cn')==0)	{
		echo 'Receipt cancelled';
		session_unset();
		$_SESSION['item']='';
		goto ender;
					}
	if(isset($_SESSION['item'])){				
	$_SESSION['item'].=$code.'|';
	}else{
	$_SESSION['item']=$code.'|';
	}
	$item[] = explode('|',($_SESSION['item']));
	echo'
	<form name="receiptlist" default="1" method="post" action="input.php" target="input">
	';
	$itm = array_reverse($item[0],true);
	//print_r($item);
	echo '<br><br>';
	//print_r($itm);
	$_SESSION['counter']=0;
	foreach($itm as $head => $lineitem)	{
		if(strcmp($lineitem,'')==0){
			//ignore last entry in exploded value
											}else	{
		$hd = $head + 1;
		echo $hd;
		echo '<input name="item" type="submit" value="'.$lineitem.'" style="width:430px;"><br>';
													}
												}
	echo '
	</form>
	';
	
	
}//1
ender:
?>
