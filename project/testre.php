<?php
//Ref: http://wiki.splitbrain.org/wiki:tips:preventing-postdata-has-expired
if (!headers_sent()) {
	session_start();
	header('Cache-Control: private');
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=Big5">
<script language="JavaScript">
	//讓 "回上頁不觸發 onload() 事件的瀏覽器" 也能 "禁止回上頁"
	//Ref: http://www.boutell.com/newfaq/creating/backbutton.html
	setTimeout("fn_forward()",1);
	function fn_forward() {
		history.forward();
		setTimeout("fn_forward()",1);
	}
</script>
</head>
<body onload="history.go(1);fn_forward();">
<?php
if (isset($_POST['action'])) {
	$strAction = $_POST['action'];
} else {
	$strAction = "";
	$_SESSION['action'] = "";
}
if ($_SESSION['action'] > "" && $_SESSION['action'] == $strAction) {
	echo "Don't Do Refresh!";
} else {
	if ($strAction > "") {
		echo "action= " . $strAction;
		$_SESSION['action'] = $strAction;
	}
}
?>
<form action="<?php echo $_SERVER['SCRIPT_NAME']; ?>" method="post">
	<input type="hidden" name="action" value="<?php echo Time();?>">
	<input type="submit">
</form>
</body>
</html>