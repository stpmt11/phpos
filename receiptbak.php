
<?php
/*
error_reporting(E_ALL);
session_start();
echo $_SESSION['user'];
$sid = session_id();
echo "<br>".$sid."<br>";
*/
/*
echo '
<div id="input"
style="	width:480px ;
			height:48px ;
			border:1px;
			left:0px;
			top:0px;
			text-align: center;
			position:absolute;">
<iframe src="input.php" id="input" width="100%" 
frameborder="0" height="100%" scrolling="no">
</iframe>
</div><br><br>';

*/


//////////////////////
/*

Steps:
1. Begin transaction page opened, and cashier recorded
2. Enter Items -- all input must be sanitized first
	a. Scanned items with upc codes, or PLU numbers
		i.		??? store the check digit, with options for others?
		ii.	upc can be scanned and recorded even if not in the system
				a. this feature can be turned off
				b. requires manual price entry
		iii.	{m}manual price entry keyed in before scan {price}{m}{qty}{*}{item entered}
				a. if weighted, item entered will request weight
				b. records standard cost into transaction table for later margin comparison.
	b. Weighted items with scale set in products table
		i.		{item price per unit}*{weight as percent of unit}
	c. Prefix based entering for any special functions
		i. 	{c}{custid} for customer
				a. customer level discount (adds discount into item enter process)
				b.	{dc}{percent off}{item}  --invalid as a customer line item
		ii.	{manager} for manager functions (will prompt for auth code)
				a. refund = {manager}{refund}{line item} or = refund{item entered again}
					i. returns should be handled as refunds to a new transaction, or incorporated into a new transaction
				b. tender loan in = {manager}{tender id}{in}{amount}
				c. tender loan out (or pickup)= {manager}{tender id}{out}{amount}
				d. tender re-assign (swap) = {manager}{swap}{from tender id}{to tender id}{tender amount}
				e. mgr authorize = {manager}{auth}{mgr passcode} (per transaction only)
				f. suspend transaction = {manager}{suspend}{transaction id}
				g.	resume transaction = {manager}{resume}{transaction id}
				h. reports ={manager}{reports}
		iii.	{v} for item removal or void (works as both line item, and upc enter)
		iv.	{d} for discounts
				a. item level = {da}{percent off}{item}
				b. programatic discount = {db}{prog disc ID}
				c. item discount removal = {v}{discount line of item}
				d.	programatic discount removal = {v}{prog disc id}
				e. clear customer discount = {v}{cust id}
					or {v}{cust entry lineno}				
				f. clear all discounts = {v}{discall} *** will not void customer discount
		v. 	{cancel}  cancels total transaction
		vi. 	instore credit accounts will be handled as tenders
		vii.	{t}{tenderid}{amount} receives tenders
				a. {cash} always cash
				b. {debit} for all debit cards (records as debit-Amex or debit-visa etc...)
				c. {credit} for all credit cards (records as credit-visa etc...)
				d. {check} for all checks
				e. {efs} for electronic tender food stamps
				g. tenders can also be created for other options like in store credit accounts 
					or employee or customer incentive programs etc. Electronic tenders will need 
					to be determined once the electronic payment option is programmed.
		ix.	{p} print last transaction receipt
		x.		{tax} removes any tax for tax exempt sales
		xi.	{tare} to enter manual tare weight
		xii.	{custlookup} opens customer search box
				a. customer search will give basic info upon search results, but allow for more indepth
					info based upon manager code
		xiii.	{prodlookup} opens a product search box 
				a. either description, item-code, or upc may be entered
3.	Re-Calculate any new discounts on total receipt
4. Calculate Sub total and fs eligible total
5. Update Receipt 
6. Update Totals (sub total) (total with tax) (fs total)(savings total for customer)
	a. 	if (Total with tax) is not 0 goto enter next item
				else end transaction print receipt and give change or cashback.
	b. 	print receipt command line options:
			i.  echo {line1} > /dev/usblp0
			ii. cat {filename} > /dev/usblp0	
	c.		Php print option
			$string 'echo "text to be printed \n new lines \n \n \n \n" > /dev/usblp0'; 
			exec($string);
*/
/////////////////////
////All aspects of the input heirarchy should be separated by a |
////example: value|manager|swap|ca|ck
////note value is always first, then 
////the second item in the string 
////is the top heirarchy, cascading down
/////////////////////

/////////////////////
////Sanitize to remove inadvertant characters from the entered string
/////////////////////

//require_once"regfunctions.php";

/*  user and lane definitions should be part of login page
define("user",$_POST['username'];
define("lane",$_POST['laneno'];
*/
//////////////////
////calculate all updates to new $_POST values then load the list of updated values
////this includes the reload of the Totals iframe
//////////////////
/*
if(isset($_POST['code'])){
////remove nonlegal characters from entry
$item = sanitize($_POST['code']);
$item2 = sanitiz($_POST['code']);
echo $item.'-'.$item2.'<br>';
//create array from split string entered from input.php
$command = explode('*',$item);
$_SESSION['trans'] = 1;
*/


/*
switch($command[1]){
	
	case 'c': 
	////customer/client id
	$var = clientid($item);								////clientid($client number)
	if($var==0){
	exesql($var);
	}else{
	returnerr($var);
	}																////exesql($query)
	$totals = recalc($trans);								////recalc($transcation number)
	unset($var);												////clientid may also add a discount into the transaction before recalc
	break;															
	
	case 'clookup': 
	////returns an array to be passed as client id
	$cval = clookup();										////clookup()
	$var = clientid($cval);
	if($var==0){
	exesql($var);
	}else{
	returnerr($var);
	}												
	$totals = recalc($trans);								
	unset($var); 
	break;
	
	case 'cancel': 
	////cancel order
	$var = cancel($trans);									////cancel(trnsno)clears current transaction data
	unset($var); 
	break;
	
	case 'd': 
	////line discount entered
	$var = discount($command);								////discount($discount_qualifications)
	if($var==0){
	exesql($var);
	}else{
	returnerr($var);
	}												
	$totals = recalc($trans);								
	unset($var); 
	break;
	
	case 'v': 
	////void or item correction
	$var = void($command);									////void($void_qualifications)
	if($var==0){
	exesql($var);
	}else{
	returnerr($var);
	}												
	$totals = recalc($trans);								
	unset($var); 
	break;
	
	case 'plookup': 
	////returns an array to be passed as product	
	$var = plookup();											////plookup()						
	unset($var); 
	break;	
	
	case 'p': 
	////prints full receipt at any time during transaction
	$var = printreceipt($trans);							////printreceipt(transaction number)						
	unset($var); 
	break;
	
	case 'tax': 
	////single item, or full transaction tax exempt
	$var = tax($command);									////tax($tax_qualifications)
	if($var==0){
	exesql($var);
	}else{
	returnerr($var);
	}												
	$totals = recalc($trans);								
	unset($var); 
	break;
	
	case 'tare': 
	////create tare for next item entered, or reset default tare
	$var = tare($command);									////tare($tare_qualifications)
	if($var==0){
	exesql($var);
	}else{
	returnerr($var);
	}												
	$totals = recalc($trans);								
	unset($var); 
	break;
	
	case 'manager': 
	////opens manager interface iframe	
	$var = manager();											////manager()						
	unset($var); 
	break;	
	
	case 't': 
	////tender value
	$var = tender($command);								////tender($tender_qualifications)
	if($var==0){
	exesql($var);
	}else{
	returnerr($var);
	}												
	$totals = recalc($trans);								
	unset($var); 
	break;	
	
	default:
	////any standard products
	$var = product($command);								////product($product Input)
	if($var==0){
	exesql($var);
	}else{
	returnerr($var);
	}
	$totals = recalc($trans);
	unset($var); 
	break;
	}
	}
	*/
/*

////drawreceipt should display a list of items entered onto the receipt iframe
drawreceipt($trans);
*/
?>