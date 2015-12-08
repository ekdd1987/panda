<?php
include("../Admin.php");
include("../../includes/conn.php");
?>
<LINK href="../Admin_STYLE.CSS" rel=stylesheet type=text/css>
<?
if($_POST['Action']=="Modify")
{
		$sql='UPDATE config_close SET close1="'.$_POST['close1'].'",txt1="'.$_POST['txt1'].'" WHERE id=1';
		$db->query($sql);
		//$db->query("insert into czlog (who,ip,types,beizhu,addtime) values ('".$_COOKIE["adminname"]."','".$_SERVER["REMOTE_ADDR"]."','设置网站开关','说明:".$_POST['close1']."','".date("Y-m-d H:i:s")."')");
		echo "<script>alert('修改成功!');window.location.href='guanbi.php';</script>";
	    exit();
}
		?>
<html><head>
<title>会员管理</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="images/css1.css" type="text/css">
<style type="text/css">
<!--
.style1 {color: #000000}
-->
</style>
</head>
<?
$ArticleID=$_GET['ArticleID'];
		 $sql="select * from config_close where ID=1";
		 $query=$db->query($sql);
		 $row=$db->fetch_array($query);
?>
<body text="#000000" leftmargin="0" topmargin="0">
              <FORM name="Form1" action="guanbi.php" method="post">
<br>
	            <table width=800 border=0 align="center" cellpadding=2 cellspacing=2 class='border'>
    <TR align=center class='title'>
      <TD height="23" colspan="3"><font class=en><b>网站开关控制</b></font></TD> 
      </TR>

    <TR class="tdbg" >
      <TD width="79" ><B>系统关闭：</B></TD> 
      <TD width="150" ><B>
        <input name="close1" type="radio" value="1" <? if($row['close1']=="1") {echo 'checked';} else {echo '';} ?> align="absmiddle">
开启
<input name="close1" type="radio" value="0" <? if($row['close1']=="0") {echo 'checked';} else {echo '';} ?>>
关闭</B></TD>
      <TD width="349" ><input name="txt1" type="text" id="txt1" size="50" value="<? echo $row['txt1']?>" ></TD>
    </TR>
    <TR align="center" class="tdbg" >
      <TD height="40" colspan="3"><input name="Action" type="hidden" id="Action" value="Modify"> 
      <input name=Submit   type=submit id="Submit" value=" 保 存 "> </TD> 
      </TR>
  </TABLE>
              </form>
</body>
</html>