<?php

// session_start();
require_once("../import/auth.php");
require_once('../import/gpsvars.php');
require_once('../import/configure.php');
require_once('../import/db_func.php');
$db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);


$PageTitle = '戰鬥!';
$hide = $_SESSION['conn'];
$_SESSION['conn']++;
//上二判斷是否重整
$id=$_SESSION['pm'];
$sqlcmd = "SELECT * FROM namelist WHERE cid='$id'";
$rs = querydb($sqlcmd, $db_conn);
$rate=rand(0,100);
require_once ('../import/cssheader.php');
if($hide==0) { echo ""; }
else { 
		$_SESSION['check']=0;
		echo "<script>alert('你媽知道你在這裡偷偷來嗎?');</script>"; 
		echo "<script>window.location.href='contactlist.php?我不配成為神奇寶貝大師';</script>"; 
		
		}
?>

<body onload="history.go(1);">
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

<div style="text-align:center;margin:0;font-size:20px;font-weight:bold;">
神奇寶貝大師</div>
<div style="text-align:center;margin:10px;font-size:20px;font-weight:bold;">

</div>


<div style="text-align:center;margin:10px auto 1px auto;width:bold">

<br/>
<span style="font-size:50px;"><b>

<?php 

foreach ($rs AS $item) {
  $pid = $item['cid'];
  $pname = $item['name'];

if($_SESSION['check']>$rate){
	echo '不錯喔~有慧根!不過還差我一點,再加油好嗎?'.'<br/>'.'<img src="pokamon/get.jpg" height = "320px"width="640px">'/*.$check.'>'.$rate*/;
	$sqlcmd='INSERT INTO poketable (pid,loginid,pname) VALUES ('
            . "'$pid','$LoginID','$pname')";
        $result = updatedb($sqlcmd, $db_conn);
}
else {
	echo'嫩'.'<br/>'.'<img src="pokamon/notget.png" height = "320px"width="640px">'/*.$check.'>'.$rate*/;
}
}?>
<br/>




<a href="contactlist.php" "color:red;">回去保管中心</a>


<?php 
require_once ('../import/footer.php');
?>
</body>
<script Language="javascript">
<!--
setTimeout("fn_forward()",1);//禁止上一頁
function fn_forward() {
	history.forward();
	setTimeout("fn_forward()",1);
}
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