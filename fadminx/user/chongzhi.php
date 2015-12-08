<?php
include("../Admin.php");
include("../../includes/conn.php");
?>

<?
if($_COOKIE["Purview"]!="1") 
{
echo "权限不足";
exit();
}
?>

<LINK href="../Admin_STYLE.CSS" rel=stylesheet type=text/css>
<?
if($_POST['Action']=="Modify")
{
	$sql="select * from users where loginname='".$_POST['uusername']."' and states=1 limit 1";
    $query=$db->query($sql);
	$row=$db->fetch_array($query);
	if ($row['loginname']!=$_POST['uusername']) 
	{
		echo "<script>alert('会员不存在!');history.go(-1);</script>";
	    exit();
	}


	
	if (is_numeric($_POST['allmoney']))
	{}
	else
	{echo "<script>alert('金额有误!');history.go(-1);</script>";
	exit();}

$jine=$_POST['allmoney'];
if($jine<0){$jine=-$jine;}

if($_POST['leixing']=="1")
{
	if($_POST['allmoney']>0)
	{
		$asql="Update users set amount=amount+".$jine." where id =".$row['id']." ";
	}
	if($_POST['allmoney']<0)
	{
		$asql="Update users set amount=amount-".$jine.",allliutongfu=allliutongfu+".$jine." where id =".$row['id']." ";
	}
        $db->query($asql);
		shouzhi($db,$row['id'],$row['loginname'],"管理员充值电子币",$_POST["allmoney"],$_POST["allmoney"],0,$_POST['reason'],0);
$sql="insert into czrecode (wang,userid,jine,types,adddate,addtime,reason) values (1,'".$_POST['uusername']."','".$_POST['allmoney']."','".$_POST['leixing']."','".date('Y-m-d')."','".date("Y-m-d H:i:s")."','".$_POST['reason']."')";
$db->query($sql);

//$db->query("insert into czlog (who,ip,types,beizhu,addtime) values ('".$_COOKIE["adminname"]."','".$_SERVER["REMOTE_ADDR"]."','电子币充值','会员名称:".$_POST['uusername']."充值金额".$_POST['allmoney']."','".date("Y-m-d H:i:s")."')");

		echo "<script>alert('充值电子币成功!');window.location.href='chongzhijilu.php';</script>";
	    exit();
}




	
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

<body text="#000000" leftmargin="0" topmargin="0">
              <FORM name="Form1" action="?" method="post">
	            <p>&nbsp;</p>
	            <p>&nbsp;</p>
	            <table width=600 border=0 align="center" cellpadding=2 cellspacing=2 class='border'>
    <TR align=center class='title'> 
      <TD height=20 colSpan=2><font class=en><b>添加充值</b></font></TD>
    </TR>
    <TR class="tdbg" > 
      <TD width="120" align="right"><b>会员编号：</b></TD>
      <TD><input name="uusername" type="text" ></TD>
    </TR>
    <TR class="tdbg" >
      <TD align="right"><strong>充值类型：</strong></TD>
      <TD><input name="leixing" type="radio" value="1" checked>
      电子币      </TD>
    </TR>
    <TR class="tdbg" > 
      <TD width="120" align="right"><B>充值金额：</B></TD>
      <TD> <INPUT name=allmoney   type=text id="allmoney" > </TD>
    </TR>
    <TR class="tdbg" > 
      <TD width="120" align="right"><B>备注：</B></TD>
      <TD><textarea name="reason" cols="30" rows="5" id="reason"></textarea></TD>
    </TR>
    <TR align="center" class="tdbg" > 
      <TD height="40" colspan="2"><input name="Action" type="hidden" id="Action" value="Modify"> 
        <input name=Submit   type=submit id="Submit" value=" 保 存 "> </TD>
    </TR>
  </TABLE>
              </form>
</body>
</html>