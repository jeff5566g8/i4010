<?php

// 使用者點選放棄新增按鈕
if (isset($_POST['Abort']) && !empty($_POST['Abort'])) {
    header("Location: contactlistadmin.php");
    exit();
}
// Authentication 認證
require_once("../import/auth.php");
// 變數及函式處理，請注意其順序
require_once("../import/gpsvars.php");
require_once("../import/configure.php");
require_once("../import/db_func.php");
// echo 'I am here';
$db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);
// echo 'I am here point 2';
$sqlcmd = "SELECT * FROM user WHERE loginid='$LoginID'";
$rs = querydb($sqlcmd, $db_conn);
if (count($rs) <= 0) die ('Unknown or invalid user!');
if (!isset($cid)) $cid = '';
if (!isset($name)) $name = '';





if (isset($Confirm)) {   // 確認按鈕
    //if (empty($loginidx)) $ErrMsg = 'Userid不可為空白\n';
    if (empty($name)) $ErrMsg = '編號或名字不可空白\n';
   
    
    if (empty($ErrMsg)) {
        // 確定此用戶可設定所選定群組的聯絡人資料
        
        // 若權限表未設定權限，則設為用戶的群組

        $sqlcmd='INSERT INTO namelist (cid,name) VALUES ('
            . "'$cid','$name')";
        $result = updatedb($sqlcmd, $db_conn);

        $sqlcmd = "SELECT count(*) AS reccount FROM namelist";
        $rs = querydb($sqlcmd, $db_conn);
        $RecCount = $rs[0]['reccount'];
        $TotalPage = (int) ceil($RecCount/$ItemPerPage);
        $_SESSION['CurPage'] = $TotalPage; 

        header("Location: contactlistadmin.php");
        exit();
    }
}
$PageTitle = '新增神奇寶貝資料';
require_once("../include/cssheader.php");
?>
<body>
<div style="text-align:center;margin-top:5px;font-size:20px;font-weight:bold;">
I4010 網頁程式設計與安全實務</div>
<div align="center">
<form action="" method="post" name="inputform">
<b>新增神奇寶貝資料</b>
<table border="1" width="60%" cellspacing="0" cellpadding="3" align="center">
<tr height="30">
  <th width="40%">編號</th>
  <td><input type="text" name="cid" value="<?php echo $cid ?>" size="20"></td>
</tr>

<tr height="30">
  <th width="40%">名字</th>
  <td><input type="text" name="name" value="<?php echo $name ?>" size="50"></td>
</tr>
</table>
<input type="submit" name="Confirm" value="存檔送出">&nbsp;
<input type="submit" name="Abort" value="放棄新增">
</form>
</div>
<?php 
require_once ('../import/footer.php');
?>
</body>
</html>