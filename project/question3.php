<?php

// session_start();
require_once("../import/auth.php");
require_once('../import/gpsvars.php');
require_once('../import/configure.php');
require_once('../import/db_func.php');
$db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);


$PageTitle = '戰鬥!';
$a=rand(1,15);
$sqlcmd = "SELECT * FROM question3 WHERE qid ='$a'";
$Contacts = querydb($sqlcmd, $db_conn);
$sqlcmd = "SELECT * FROM choose3 WHERE qid ='$a'";
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
<div style="text-align:center;margin:0;font-size:20px;font-weight:bold;">
神奇寶貝大師</div>
<div style="text-align:center;margin:10px;font-size:20px;font-weight:bold;">
回答問題來提高抓到牠的機率!</div>

<?php
foreach ($Contacts AS $item) {
  $qid = $item['qid'];
  $question = $item['question'];
  $answer3 = $item['answer'];
  foreach ($Contacts2 AS $item) {
	  $c1 = $item['c1'];
	  $c2 = $item['c2'];
	  $c3 = $item['c3'];
	  $c4 = $item['c4'];
?>
<div style="text-align:center;margin:10px auto 1px auto;width:bold">
<span style="font-size:50px;"><b>問題三:<?php echo $question ?></b></span>
<br/>
<span style="font-size:30px;"><b>請選擇:
<form action="answers.php" method="post" name="q3">
<input type="Radio" name="q3" value="1"><label><?php echo $c1 ?></label>
<input type="Radio" name="q3" value="2"><label><?php echo $c2 ?></label>
<input type="Radio" name="q3" value="3"><label><?php echo $c3 ?></label>
<input type="Radio" name="q3" value="4"><label><?php echo $c4 ?></label></b></span>
<br/>
<input type="submit" name="Confirm" value="結果~">
<?php 
$_SESSION['ans3']=$answer3;
if(!isset( $_POST['q2'])) {
	echo "<script>alert('沒選算錯,咬我阿');</script>";
	$_SESSION['choose2']=0;
}	
else $_SESSION['choose2']=$_POST['q2'];	  
	  ?>
</form>
</div> 





<?php
/*
if (isset($Confirm)){
	$q3=$_POST['q3'];
	$_SESSION['choose3']=$q3;
	$_SESSION['ans3']=$answer3;
	if($_SESSION['choose3']==$_SESSION['ans3']) $_SESSION['check3']='Y';
	else if ($_SESSION['choose3']!=$_SESSION['ans3']) $_SESSION['check3']='N';
	echo "<script>location.href='answers.php';</script>";
	exit();
}*/
  }
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