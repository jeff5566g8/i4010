<?php
// session_start();
require_once("../import/auth.php");
require_once('../import/gpsvars.php');
require_once('../import/configure.php');
require_once('../import/db_func.php');
$db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);
$sqlcmd = "SELECT * FROM user WHERE loginid='$LoginID' ";
$rs = querydb($sqlcmd, $db_conn);
if (count($rs) <= 0) die ('Unknown or invalid user!');



if (isset($action) && $action=='delete' && isset($cid)) {
    // Invalid this item
    $sqlcmd = "SELECT * FROM namelist WHERE cid='$cid' AND valid='Y'";
    $rs = querydb($sqlcmd, $db_conn);
    if (count($rs) > 0) {
        $sqlcmd = "UPDATE namelist SET valid='N' WHERE cid='$cid'";
        $result = updatedb($sqlcmd, $db_conn);
    }
}

///$_SESSION['CurPage'
$PageTitle = '管理者介面';

$sqlcmd = "SELECT count(*) AS listcount FROM namelist WHERE valid='Y'";
$rs = querydb($sqlcmd, $db_conn);
$listCount = $rs[0]['listcount'];
$ItemPerPage=10;
$TotalPage = (int) ceil($listCount/$ItemPerPage);
if (!isset($Page)) {
    if (isset($_SESSION['CurPage'])) $Page = $_SESSION['CurPage'];
    else $Page = 1;
}
if ($Page > $TotalPage) $Page = $TotalPage;
$_SESSION['CurPage'] = $Page;
$StartRec = ($Page-1) * $ItemPerPage;
$sqlcmd = "SELECT * FROM namelist WHERE valid='Y'"
    . "LIMIT $StartRec,$ItemPerPage";
$Contacts2 = querydb($sqlcmd, $db_conn);
$PrevPage = $NextPage = '';
if ($TotalPage > 1) {
    if ($Page>1) $PrevPage = $Page - 1;
    if ($Page<$TotalPage) $NextPage = $Page + 1;   
}
$PrevLink = $NextLink = '';
if (!empty($PrevPage)) 
    $PrevLink = '<a href="contactlistadmin.php?Page=' . $PrevPage . '">上一頁</a>';
if (!empty($NextPage)) 
    $NextLink = '<a href="contactlistadmin.php?Page=' . $NextPage . '">下一頁</a>';

$sqlcmd = "SELECT * FROM namelist WHERE valid='Y'";
$Contacts = querydb($sqlcmd, $db_conn);

require_once ('../include/cssheader.php');
?>
<body>
<script Language="javascript">
<!--
function confirmation(DspMsg, PassArg) {
var name = confirm(DspMsg)
    if (name == true) {
      location=PassArg;
    }
}
-->
</script>
<div style="text-align:center;margin-top:5px;font-size:20px;font-weight:bold;">
神奇寶貝大師</div>
<div style="text-align:center;margin:3px auto 1px auto;width:90%">
<div style="font-size:18px;">
<!---

<span style="float:left;"><a href="adduser.php">新增神奇寶貝到資料庫 &nbsp</a></span>&nbsp;

<span style="float:right;"><a href="logout.php">登出</a></span>
</div>-->
<table border="0" width="90%" align="center" cellspacing="0" cellpadding="2">
<tr>
  <td width="50%" align="left">
  <div style="font-size:28px;">
<?php if ($TotalPage > 1) { ?>
<form name="SelPage" method="POST" action="">
<?php if (!empty($PrevLink)) echo $PrevLink . '&nbsp;'; ?>
  第<select name="Page" onchange="submit();">
<?php 
for ($p=1; $p<=$TotalPage; $p++) { 
    echo '  <option value="' . $p . '"';
    if ($p == $Page) echo ' selected';
    echo ">$p</option>\n";
}
?>
  </select>頁 共<?php echo $TotalPage ?>頁
<?php if (!empty($NextLink)) echo '&nbsp;' . $NextLink; ?>
</form>
<?php } ?>
 </div>
  </td>
  <td align="right" width="30%">
  <div style="font-size:28px;">
    <a href="adduser.php"><b>新增神奇寶貝到資料庫</b></a>&nbsp;&nbsp;&nbsp;
    <a href="logout.php"><b>登出</b></a>
	</div>
  </td>
</tr>
</table>
</div>
</div>
<div style="text-align:center;margin-top:5px;">
<table class="mistab" width="90%" align="center">
<tr>
  <th width="15%">處理</th>
  
  <th width="20%">編號</th>
  <th width="40%">名字</th>
  
</tr>
<?php
foreach ($Contacts2 AS $item) {
  $cid = $item['cid'];
  $pname = $item['name'];
  $Valid = $item['valid'];
  $DspMsg = "'確定刪除項目?'";
  $PassArg = "'contactlistadmin.php?action=delete&cid=$cid'";
?>
<tr align="center"bgcolor="#FFFFFF">
  <td>

  <a href="javascript:confirmation(<?php echo $DspMsg ?>, <?php echo $PassArg ?>)">
  作廢</a>&nbsp;
  <a href="contactmod.php?cid=<?php echo $cid; ?>">
  修改</a>
  </td>
   <td><div style="font-size:20px;font-weight:bold;"><?php echo $cid ?></div></td> 

  
  <td><div style="font-size:20px;font-weight:bold;"><?php echo $pname ?></div></td>
       
</tr>
<?php
}
?>
</div>
</body>
<script Language="javascript">
<!--
function confirmation(DspMsg, PassArg) {
var name = confirm(DspMsg)
    if (name == true) {
      location=PassArg;
    }
}
-->
</script>
</html>