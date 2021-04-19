<?php

// session_start();
require_once("../import/auth.php");
require_once('../import/gpsvars.php');
require_once('../import/configure.php');
require_once('../import/db_func.php');
$db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);


$PageTitle = '戰鬥結束';
$count=0;
$check=0;

$_SESSION['conn']=0;
require_once ('../import/cssheader.php');
if($_SESSION['choose']==$_SESSION['ans']) $count++;
if($_SESSION['choose2']==$_SESSION['ans2']) $count++;
if(!isset( $_POST['q3'])) {
	echo "<script>alert('沒選算錯,咬我阿');</script>";
	$_POST['q3']=0;
}	
else if($_POST['q3']==$_SESSION['ans3']) $count++;
if($count==0)$check=0;
if($count==1)$check=25;
if($count==2)$check=50;
if($count==3)$check=75;
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
戰鬥結束!</div>


<div style="text-align:center;margin:10px auto 1px auto;width:bold">
<span style="font-size:50px;"><b><?php echo '你的回答: '.$_SESSION['choose'].$_SESSION['choose2'].$_POST['q3'].'<br/>'.'正確答案: '.$_SESSION['ans'].$_SESSION['ans2'].$_SESSION['ans3'].'<br/>'.'答對的題數: '.$count.'<br/>'.'POKENO: '.$_SESSION['pm'];?></b></span>
<br/>
<span style="font-size:30px;"><b>捕捉中...<br/>
<img src="pokamon/ball.gif" height = "320px"width="640px">
<!--<form action="final.php" method="post" name="q1"></b></span>
<br/>
<input type="submit" name="Confirm" value="看結果~~">

</form>-->
<form action="final.php" method="post" id="autos">
	<input type="hidden" name="action"  value="<?php echo $_SESSION['conn_id']?>">
<?php 
$_SESSION['check']=$check;
	  
	  ?>	
</form>
<!--
<meta http-equiv="Refresh" content="5;url=final.php" />

-->
<?php 
//$_SESSION['check']=$check;
	  
	  ?>
<?php 
require_once ('../import/footer.php');
?>
</body>
<script Language="javascript">
<!--
setTimeout("document.getElementById('autos').submit( );","5000"); 
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