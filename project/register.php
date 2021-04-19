<?php

// 使用者點選放棄新增按鈕
if (isset($_POST['Abort']) && !empty($_POST['Abort'])) {
    header("Location: index.php");
    exit();
}
session_start();
session_unset();
// Authentication 認證

// 變數及函式處理，請注意其順序
require_once("../import/gpsvars.php");
require_once("../import/configure.php");
require_once("../import/db_func.php");

$db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);
if (!isset($loginidx)) $loginidx = '';
if (!isset($password)) $password = '';
$password_sha1 = sha1($password);

if (isset($Confirm)) {   // 確認按鈕
    if (empty($loginidx)) $ErrMsg = 'Userid不可為空白\n';
    if (empty($password)) $ErrMsg = '密碼不可為空白\n';
	$sqlcmd = "SELECT * FROM user WHERE loginid='$loginidx' AND valid='Y'";
	$rs = querydb($sqlcmd, $db_conn);
	foreach ($rs AS $item) {
		$loginidxx = $item['loginid'];
	}
    if ($loginidx==$loginidxx) $ErrMsg = '使用者重複 請重試\n';
    
    if (empty($ErrMsg)) {
        
        
        $sqlcmd='INSERT INTO user (loginid,password) VALUES ('
            . "'$loginidx','$password_sha1')";
        $result = updatedb($sqlcmd, $db_conn);

        header("Location: index.php");
        exit();
    }
}
$PageTitle = '示範新增人員資料';
require_once("../include/cssheader.php");
?>
<body>
<div style="text-align:center;margin-top:5px;font-size:20px;font-weight:bold;">
神奇寶貝大濕</div>
<div align="center">
<form action="" method="post" name="inputform">
<b>新增使用者</b>
<br/>

<table border="10" width="30%" cellspacing="0" cellpadding="3" align="center">
<tr height="30">
  <th width="40%">帳號</th>
  <td><input type="text" name="loginidx" value="<?php echo $loginidx ?>" size="20"></td>
</tr>

<tr height="30">
  <th width="40%">密碼</th>
  <td><input type="password" name="password" value="<?php echo $password ?>" size="20"></td>
</tr>
</table>
<br/>
<br/>

<input type="submit" name="Confirm" value="存檔送出">&nbsp;
<input type="submit" name="Abort" value="放棄新增">
</form>
<br/>
<br/>
<br/>
</div>
<?php 
require_once ('../import/footer.php');
?>
</body>
</html>