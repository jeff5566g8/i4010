<?php
// 使用者點選放棄新增按鈕

// session_start();
require_once("../import/auth.php");
require_once('../import/gpsvars.php');
require_once('../import/configure.php');
require_once('../import/db_func.php');
$db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);


$PageTitle = '您的保管中心';
$sqlcmd = "SELECT count(*) AS reccount FROM namelist WHERE valid='Y'";
        $rs = querydb($sqlcmd, $db_conn);
        $RecCount = $rs[0]['reccount'];
$a=rand(1,$RecCount);//全部的
$sqlcmd = "SELECT * FROM namelist WHERE cid ='$a' AND valid='Y'";
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
<embed src="music/battle.mp3" autostart=true hidden=true volume=30><!--學術使用-->
<div style="text-align:center;margin:0;font-size:20px;font-weight:bold;">
神奇寶貝大師</div>


<?php
foreach ($Contacts AS $item) {
  $pid = $item['cid'];
  $pname = $item['name'];

?>
<div style="text-align:center;margin:10px auto 1px auto;width:bold">
<span style="font-size:50px;"><b>野生的<?php echo $pname ?>出現了!!!</b></span>
<br/>
<img src="<?php echo 'pokamon/'.$pid.'.jpg'?>" height = "320px"width="640px">
<form action="question.php" method="post" name="inputform">
<input type="submit" name="Confirm" value="戰鬥!">&nbsp;

<input type ="button" onclick="javascript:location.href='contactlist.php'" value="逃跑..."></input>  
<?php 
    $_SESSION['pm']=$pid; 
	  
	  ?>
</form>
</div>





<?php
}
?>
<?php 
require_once ('../import/footer.php');
?>
</body>
<script Language="javascript">
<!--
function confirmation(DspMsg, PassArg) {
var name = confirm(DspMsg)
    if (name == true) {
      location=PassArg;
    }
}
        //禁止刷新F5 和Ctrl+F5
        function ForbidFreshPage() {
            if ((window.event.ctrlKey && window.event.keyCode == 116) || window.event.keyCode == 116) {
               window.event.keyCode = 0;
               window.event.returnValue = false;
           } 
        }
        document.onkeydown = ForbidFreshPage;
-->
</script>
</html>