<?php
// session_start();
require_once("../import/auth.php");
require_once('../import/gpsvars.php');
require_once('../import/configure.php');
require_once('../import/db_func.php');
$db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);
$sqlcmd = "SELECT * FROM user WHERE loginid='$LoginID'";
$rs = querydb($sqlcmd, $db_conn);
if (count($rs) <= 0) die ('Unknown or invalid user!');

/*if (isset($action) && $action=='recover' && isset($cid)) {
    // Recover this item
    $sqlcmd = "SELECT * FROM namelist WHERE cid='$cid' AND valid='N'";
    $rs = querydb($sqlcmd, $db_conn);
    if (count($rs) > 0) {
        $sqlcmd = "UPDATE namelist SET valid='Y' WHERE cid='$cid'";
        $result = updatedb($sqlcmd, $db_conn);
    }
}*/
if (isset($action) && $action=='delete' && isset($sqno)) {
    // Invalid this item
    $sqlcmd = "SELECT * FROM poketable WHERE sqno='$sqno' AND valid='Y'";
    $rs = querydb($sqlcmd, $db_conn);
    if (count($rs) > 0) {
        $sqlcmd = "UPDATE poketable SET valid='N' WHERE sqno='$sqno'";
        $result = updatedb($sqlcmd, $db_conn);
    }
}

$PageTitle = '您的保管中心';
$sqlcmd = "SELECT count(*) AS pmlistcount FROM poketable WHERE loginid = '$LoginID' AND valid ='Y'";
$rs = querydb($sqlcmd, $db_conn);
$pmlistCount = $rs[0]['pmlistcount'];
$ItemPerPage=5;
$TotalPage = (int) ceil($pmlistCount/$ItemPerPage);
if (!isset($Page)) {
    if (isset($_SESSION['CurPage'])) $Page = $_SESSION['CurPage'];
    else $Page = 1;
}
if ($Page > $TotalPage) $Page = $TotalPage;
$_SESSION['CurPage'] = $Page;
$StartRec = ($Page-1) * $ItemPerPage;
$sqlcmd = "SELECT * FROM poketable WHERE loginid = '$LoginID' AND valid ='Y'"
    . "LIMIT $StartRec,$ItemPerPage";
$Contacts22 = querydb($sqlcmd, $db_conn);
$PrevPage = $NextPage = '';
if ($TotalPage > 1) {
    if ($Page>1) $PrevPage = $Page - 1;
    if ($Page<$TotalPage) $NextPage = $Page + 1;   
}
$PrevLink = $NextLink = '';
if (!empty($PrevPage)) 
    $PrevLink = '<a href="contactlist.php?Page=' . $PrevPage . '">上一頁</a>';
if (!empty($NextPage)) 
    $NextLink = '<a href="contactlist.php?Page=' . $NextPage . '">下一頁</a>';

$sqlcmd = "SELECT * FROM poketable WHERE loginid = '$LoginID' AND valid ='Y'";
$Contacts = querydb($sqlcmd, $db_conn);


require_once ('../import/cssheader.php');
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
<embed src="music/wait.mp3" autostart=true hidden=true volume=30>
<div style="text-align:center;margin:0;font-size:20px;font-weight:bold;">
神奇寶貝大師</div>
<div style="text-align:center;margin:3px auto 1px auto;width:90%">
<div style="font-size:18px;"><b>您的保管中心</b></div>
<br/>
<div style="font-size:18px;">
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
  <td align="right" width="50%">
  <div style="font-size:28px;">
    <a href="gaming.php"><b>抓神奇寶貝嚕</</b></a>&nbsp;&nbsp;
	<a href="ranking.php"><b>排行榜</</b></a>&nbsp;&nbsp;
    <a href="logout.php"><b>登出</b></a>
	<div style="font-size:18px;">
  </td>
</tr>
</table>
</div>
<!--
<span style="float:left;"><a href="gaming.php">抓神奇寶貝嚕</a></span>
<span style="float:center;"><a href="ranking.php">排行榜</a></span>
<span style="float:right;"><a href="logout.php">登出</a></span>
-->
</div>
<div style="text-align:center;">
<table class="mistab" width="90%" align="center">
<tr>
  <th width="15%">編號</th>
  <th width="15%">名字</th>
  <th width="15%">圖片</th>
  <th width="15%">放生</th>
</tr> 
<?php
foreach ($Contacts22 AS $item) {
  $sqno = $item['sqno'];
  $pid = $item['pid'];
  $pname = $item['pname'];
  $DspMsg = "'放生就掰了 確定嗎?'";
  $PassArg = "'contactlist.php?action=delete&sqno=$sqno'";
  //$url = 'pokamon/'.$pid.'.jpg';
  ?>
<tr align="center"  bgcolor="#FFFFFF" >
  
<td><div style="font-size:20px;font-weight:bold;"><?php echo $pid ?></div></td>  
<td><div style="font-size:20px;font-weight:bold;"><?php echo $pname ?></div></td>
<td><img src="<?php echo 'pokamon/'.$pid.'.jpg'?>" width="30%"></td>
<td>  <a href="javascript:confirmation(<?php echo $DspMsg ?>, <?php echo $PassArg ?>)">
 <div style="font-size:20px;font-weight:bold;"> let it go</div></a></td>
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