<?php

//session_start();

require_once("../import/auth.php");
//session_register('ans');
require_once('../import/gpsvars.php');
require_once('../import/configure.php');
require_once('../import/db_func.php');
$db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);


$PageTitle = '戰鬥!';
$ans='';

$a=rand(1,15);
$sqlcmd = "SELECT * FROM question1 WHERE qid ='$a'";
$Contacts = querydb($sqlcmd, $db_conn);
$sqlcmd = "SELECT * FROM choose1 WHERE qid ='$a'";
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
  $answer = $item['answer'];
  
  foreach ($Contacts2 AS $item) {
	  $c1 = $item['c1'];
	  $c2 = $item['c2'];
	  $c3 = $item['c3'];
	  $c4 = $item['c4'];
?>
<div style="text-align:center;margin:10px auto 1px auto;width:bold">
<span style="font-size:50px;"><b>問題一:<?php echo $question ?></b></span>
<br/>
<span style="font-size:30px;"><b>請選擇:
<form action="question2.php" method="post" name="q1">
<input type="Radio" name="q1" value="1"><label><?php echo $c1 ?></label>
<input type="Radio" name="q1" value="2"><label><?php echo $c2 ?></label>
<input type="Radio" name="q1" value="3"><label><?php echo $c3 ?></label>
<input type="Radio" name="q1" value="4"><label><?php echo $c4 ?></label></b></span>
<br/>
<input type="submit" name="Confirm" value="下一題~">
<?php 
$_SESSION['ans']=$answer;
  
	  ?>
</form>

</div>





<?php
/*if (isset($Confirm)){
	$q1=$_POST['q1'];
	$_SESSION['choose']=$q1;
	$_SESSION['ans']=$answer;
	if($_SESSION['choose']==$_SESSION['ans']) $_SESSION['check']='Y';
	else if ($_SESSION['choose']!=$_SESSION['ans']) $_SESSION['check']='N';
    //echo $answer.$q1.$_SESSION['ans'];
	//echo $q1.$_SESSION['ans'];
	header("Location: question2.php");
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