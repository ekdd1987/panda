<?php
include("../Admin.php");
include("../../includes/conn.php");
?>
<LINK href="../Admin_STYLE.CSS" rel=stylesheet type=text/css>
<?
if($_GET['action']=="add")
{
	if ($_POST['username']=="" || $_POST['password']=="")
	{echo "<script>alert('请填写完整!');history.go(-1);</script>";
	exit();}
		$sql="insert into adhgfqws65ljdlgr (username,password,Purview) values ('".$_POST['username']."','".md5($_POST['password'])."',1)";
		$db->query($sql);
		$newID = mysql_insert_id();
		
    //$db->query("insert into czlog (who,ip,types,beizhu,addtime) values ('".$_COOKIE["adminname"]."','".$_SERVER["REMOTE_ADDR"]."','添加管理员','管理员名称:".$_POST['username']."','".date("Y-m-d H:i:s")."')");
}

if($_GET['action']=="Modify")
{
	if ($_POST['username']=="" || $_POST['password']=="")
	{echo "<script>alert('请填写完整!');history.go(-1);</script>";
	exit();}
	
		$sql='UPDATE adhgfqws65ljdlgr SET username="'.$_POST['username'].'",password="'.md5($_POST['password']).'",Purview=1 WHERE ID='.$_POST['ArticleID'].'';
		$db->query($sql);
		$newID = $_POST['ArticleID'];
		//$db->query("insert into czlog (who,ip,types,beizhu,addtime) values ('".$_COOKIE["adminname"]."','".$_SERVER["REMOTE_ADDR"]."','修改管理员','管理员名称:".$_POST['username']."','".date("Y-m-d H:i:s")."')");
}
		?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="862" align="center" valign="top">
	<br>
      <br>
      <b> </b><br>
      <br>
      <br>
      <table class="border" align=center width="50%" border="0" cellpadding="0" cellspacing="2" bordercolor="#999999">
        <tr align=center bgcolor="#999999"> 
          <td  height="25" colspan="2" class="title"><b> 
<?
if ($_GET['action']=="add")
  echo "添加"; 
else
  echo "修改"; 
  ?>
            信息成功</b></td>
        </tr>
        <tr> 
          <td width="19%" height="22"  class="tdbg"> <p align="right">信息序号：</p></td>
          <td width="81%" bgcolor="#E3E3E3" class="tdbg"><? echo $newID?></td>
        </tr>
        <tr> 
          <td height="22"  class="tdbg"><div align="right">信息名称：</div></td>
          <td bgcolor="#E3E3E3" class="tdbg"><? echo $_POST['username']?></td>
        </tr>
        <tr> 
          <td height="22" colspan="2" bgcolor="#E3E3E3" class="tdbg"> 
            <p align="center"> 【<a href="newsModify.php?ArticleID=<? echo $newID?>&types=<? echo $_GET['types']?>">修改信息</a>】&nbsp;【<a href="newsAdd.php?types=<? echo $_GET['types']?>">继续添加信息</a>】&nbsp;【<a href="newsManage.php?types=<? echo $_GET['types']?>">信息管理</a>】&nbsp;</p></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
