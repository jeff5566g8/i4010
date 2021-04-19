<?php
// 使用者點選放棄修改按鈕
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
$db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);
// 確認參數是否正確
if (!isset($cid)) $cid = '';
if (!isset($name)) $name = '';

// Authorization 授權
// =====================================================

// =====================================================

// 處理使用者異動之資料
if (isset($Confirm)) {   // 確認按鈕
    if (!isset($cid) || empty($cid)) $ErrMsg = '編號不可為空白\n';
    if (!isset($name) || empty($name)) $ErrMsg = '名字不可為空白\n';

    if (empty($ErrMsg)) {   // 資料經初步檢核沒問題
    // Demo for XSS
    //    $Name = xssfix($Name);
    //    $Phone = xssfix($Phone);
    // Demo for the reason to use addslashes
        if (!get_magic_quotes_gpc()) {
            $cid = addslashes($cid);
			$name = addslashes($name);
        }
        $sqlcmd="UPDATE namelist SET cid='$cid',name='$name' "
            . "WHERE cid='$cid'";
        $result = updatedb($sqlcmd, $db_conn);
        header("Location: contactlistadmin.php");
        exit();
    }
}


$PageTitle = '修改神奇寶貝資料';
require_once("../include/cssheader.php");
?>
<head>
  <meta charset="utf-8">
  <title>jQuery UI Datepicker - Default functionality</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  
  <script>
  $(function() {
    $.datepicker.regional['zh-TW']={
        monthNames:["一月","二月","三月","四月","五月","六月","七月","八月","九月","十月","十一月","十二月"],
        monthNamesShort:["一月","二月","三月","四月","五月","六月","七月","八月","九月","十月","十一月","十二月"],
        prevText:"上個月",
        nextText:"下個月",
        weekHeader:"星期",
        dayNames:["星期日","星期一","星期二","星期三","星期四","星期五","星期六"],
        dayNamesMin:["日","一","二","三","四","五","六"]
    };
    $.datepicker.setDefaults($.datepicker.regional["zh-TW"]);
    $( "#datepicker" ).datepicker({
        dateFormat:"yy-mm-dd",showMonthAfterYear:true,
        showOtherMonths: true, selectOtherMonths: 
        true,changeYear: true, changeMonth: true, yearRange:"-35:+1"
    });
  });
  </script>
</head>
<body>
<div style="text-align:center;margin-top:5px;font-size:20px;font-weight:bold;">
I4010 網頁程式設計與安全實務</div>
<div align="center">
<div align="text-align:center">
<form action="" method="post" name="inputform">
<input type="hidden" name="cid" value="<?php echo $cid ?>">
<b>修改神奇寶貝資料</b>
<table border="1" width="60%" cellspacing="0" cellpadding="3" align="center">
<tr height="30">
  <th width="40%">編號</th>
  <td><input type="text" name="cid" value="<?php echo $cid ?>" size="20"></td>
</tr>

<tr height="30">
  <th>名字</th>
  <td><input type="text" name="name" value="<?php echo $name ?>" size="50"></td>
</tr>

</table>
<input type="submit" name="Confirm" value="存檔送出">&nbsp;
<input type="submit" name="Abort" value="放棄修改">
</form>
</div>
<?php 
require_once ('../import/footer.php');
?>
</body>
</html>