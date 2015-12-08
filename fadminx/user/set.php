<?php
include("../Admin.php");
include("../../includes/conn.php");
?>
<LINK href="../Admin_STYLE.CSS" rel=stylesheet type=text/css>
<?
if($_GET['action']=="Modify")
{
		$sql='UPDATE config SET jine1="'.$_POST['jine1'].'",jine2="'.$_POST['jine2'].'",jine3="'.$_POST['jine3'].'",jine4="'.$_POST['jine4'].'",jine5="'.$_POST['jine5'].'",jine6="'.$_POST['jine6'].'" WHERE id=1';
		$db->query($sql);
		
		echo "<script>alert('修改成功!');window.location.href='set.php';</script>";
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
		 $sql="select * from config where ID=1";
		 $query=$db->query($sql);
		 $row=$db->fetch_array($query);
?>
<body text="#000000" leftmargin="0" topmargin="0">
              <FORM name="Form1" action="?action=Modify" method="post">
<br>
	            <table width=100% border=0 align="center" cellpadding=2 cellspacing=2 class='border'>
    <TR align=center class='title'>
      <TD width="13%">&nbsp;</TD> 
      <TD width="87%" height=20><B>系统设置</B></TD>
    </TR>
    <TR class="tdbg" >
      <TD >激活1级金额：</TD>
      <TD height="50" ><INPUT name=jine1   type=text id="jine1" value="<? echo $row['jine1']?>" size=20 ></TD>
    </TR>
    <TR class="tdbg" >
      <TD >1级升2级金额：</TD>
      <TD height="50" ><INPUT name=jine2   type=text id="jine2" value="<? echo $row['jine2']?>" size=20 ></TD>
    </TR>
    <TR class="tdbg" >
      <TD >2级升3级金额：</TD>
      <TD height="50" ><INPUT name=jine3   type=text id="jine3" value="<? echo $row['jine3']?>" size=20 ></TD>
    </TR>
        <TR class="tdbg" >
      <TD >3级升4级金额：</TD>
      <TD height="50" ><INPUT name=jine4   type=text id="jine4" value="<? echo $row['jine4']?>" size=20 ></TD>
    </TR>
    <TR class="tdbg" >
      <TD >4级升5级金额：</TD>
      <TD height="50" ><INPUT name=jine5   type=text id="jine5" value="<? echo $row['jine5']?>" size=20 ></TD>
    </TR>
    <TR class="tdbg" >
      <TD >5级升6级金额：</TD>
      <TD height="50" ><INPUT name=jine6   type=text id="jine6" value="<? echo $row['jine6']?>" size=20 ></TD>
    </TR>
          <TR align="center" class="tdbg" >
            <TD>&nbsp;</TD> 
      <TD height="40"><input name="Action" type="hidden" id="Action" value="Modify"> 
        <input name=Submit   type=submit id="Submit" value=" 保 存 "> </TD>
    </TR>
  </TABLE>
              </form>
</body>
</html>