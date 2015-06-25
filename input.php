<?php
echo '
<html>
<head>
<script type="text/javascript">
        function SetCursorToTextEnd(textControlID)
        {
            var text = document.getElementById(textControlID);
            if (text != null && text.value.length > 0)
            {
                if (text.createTextRange)
                {
                    var FieldRange = text.createTextRange();
                    FieldRange.moveStart("character", text.value.length);
                    FieldRange.collapse();
                    FieldRange.select();
                }
            }
        }
        function sbmtfrm(formname)
        {
        	document.forms[formname].submit();
        	}
</script>
</head>
<body OnLoad="document.inputform.code.focus();">
';
session_start();
$sid=session_id();
//echo $sid.'<br>';
if(isset($_POST['item'])){
	$inputval = $_POST['item'];
	}else{
		$inputval = '';
		}
$code = '"code"';
echo'
	<form name="inputform" default="1" method="post" action="receipt.php" target="receipt"
		 tabindex=1 OnLoad="SetCursorToTextEnd("code")">
		Item: <input name="code" type="text" value="'.$inputval.'"
			style="font-size:12pt;width:300px; height:35px;">
	<input name="enter" type="submit" value="Enter">
	</form>
</body>
</html>';
?>
