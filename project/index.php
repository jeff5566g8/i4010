<?php
function userauth($ID, $PWD, $db_conn) {
    $sqlcmd = "SELECT * FROM user WHERE loginid='$ID' ";
    $rs = querydb($sqlcmd, $db_conn);
    // var_dump($rs);
    $retcode = 0;
    if (count($rs) > 0) {
        $Password = sha1($PWD);
        // echo '<br />' . $Password . '<br />' . $rs[0]['password'];
        if ($Password == $rs[0]['password']) $retcode = 1;
    }
    return $retcode;
}
session_start();
session_unset();
require_once("../import/gpsvars.php");
//echo "<script>alert('請重新註冊sorry');</script>"; 
$ErrMsg = "";
if (!isset($ID)) $ID = "";
if (isset($Submit)) {
	require ("../import/configure.php");
	require ("../import/db_func.php");
	$db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);
    if (strlen($ID) > 0 && strlen($ID)<=16 && $ID==addslashes($ID)) {
        $Authorized = userauth($ID,$PWD,$db_conn);
		if ($Authorized) {
		    $sqlcmd = "SELECT * FROM user WHERE loginid='$ID' ";
		    $rs = querydb($sqlcmd, $db_conn);
			$LoginID = $rs[0]['loginid'];
	        $_SESSION['LoginID'] = $LoginID;
			if($LoginID=="admin"||$LoginID=="adminuser") header ("Location:contactlistadmin.php");
			else header ("Location:contactlist.php");
			exit();
		}
		$ErrMsg = '<font color="Red">'
			. '您並非合法使用者或是使用權已被停止</font>';
    } else {
		$ErrMsg = '<font color="Red">'
			. 'ID錯誤，您並非合法使用者或是使用權已被停止</font>';
	}
  if (empty($ErrMsg)) $ErrMsg = '<font color="Red">登入錯誤</font>';
}
?>
<HTML>
<HEAD>
<meta HTTP-EQUIV="Content-Type" content="text/html; charset=utf8">
<meta HTTP-EQUIV="Expires" CONTENT="Tue, 01 Jan 1980 1:00:00 GMT">
<meta HTTP-EQUIV="Pragma" CONTENT="no-cache">
<link rel="stylesheet" title="Default" href="../css/i4010.css" type="text/css" />
<title>登入系統</title>
</HEAD>
<script type="text/javascript">
<!--
function setFocus()
{
<?php if (empty($ID)) { ?>
    document.LoginForm.ID.focus();
<?php } else { ?>
    document.LoginForm.PWD.focus();
<?php } ?>
}
//-->
</script>
<body onload="setFocus()">
<embed src="music/op1.mp3" autostart=true hidden=true volume=30><!--學術使用-->
<div style="text-align:center;margin-top:20px;font-size:30px;font-weight:bold;">
神奇寶貝大濕'ver2'<br/>
<img src="pokamon/title.png">
</div>
<div style="text-align:center;margin:20px;font-size:20px;"><b>
登入系統</b>
</div>
<div style="text-align:center"><b>
請於輸入框中輸入帳號與密碼，然後按「登入」按鈕登入。</b>
<form method="POST" name="LoginForm" action="">
<table width="300" border="1" cellspacing="0" cellpadding="2"
align="center" bordercolor="Blue">
<tr bgcolor="#FFCC33" height="35">
<td align="center"><b>登入系統</b>
</td>
</tr>
<tr bgcolor="#FFFFCC" height="35">
<td align="center">帳號：
  <input type="text" name="ID" size="16" maxlength="16"
	value="<?php echo $ID; ?>">
</td>
</tr>
<tr bgcolor="#FFFFCC" height="35">
<td align="center">密碼：
  <input type="password" name="PWD" size="16" maxlength="16">
</td>
</tr>
<tr bgcolor="#FFCC33" height="35">
<td align="center">

  <input type="submit" name="Submit" value="登入">
  <input type="button" value="註冊" onclick="location.href='register.php'">
</td>
</tr>
</table>
</form>

<?php if (!empty($ErrMsg)) echo $ErrMsg; ?>
</body>
</html>