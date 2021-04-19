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
$i=0;
$sqlcmd = "SELECT COUNT(*) AS pcount FROM poketable WHERE loginid = '$LoginID' AND valid ='Y'";
$Contacts = querydb($sqlcmd, $db_conn);
$Pcount = $Contacts[0]['pcount'];
$sqlcmd = "UPDATE user SET count='$Pcount' WHERE loginid = '$LoginID' ";
$rs = updatedb($sqlcmd, $db_conn);
$sqlcmd = "SELECT * FROM user WHERE loginid NOT IN ('admin','adminuser') ORDER BY count DESC ";
$Contacts2 = querydb($sqlcmd, $db_conn);

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
<span style="float:left;"><a href="gaming.php">抓神奇寶貝嚕</a></span>
<span style="float:right;"><a href="contactlist.php">回到保管中心</a></span>
</div>
<div style="text-align:center;">
<table class="mistab" width="90%" align="center">
<tr>
  <th width="15%">名次</th>
  <th width="15%">ID</th>
  <th width="15%">抓到的隻數</th>

</tr> 
<?php
foreach ($Contacts2 AS $item) {
  $uid = $item['loginid'];
  $pc = $item['count'];
  $i++;
  
  //$url = 'pokamon/'.$pid.'.jpg';
  ?>
<tr align="center"  bgcolor="#FFFFFF" >
<td><div style="font-size:20px;font-weight:bold;"><?php echo $i ?></div></td>  
<td><div style="font-size:20px;font-weight:bold;"><?php echo $uid ?></div></td>  
<td><div style="font-size:20px;font-weight:bold;"><?php echo $pc ?></div></td>

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