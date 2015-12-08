<?php
include("../Admin.php");
include("../../includes/conn.php");
?>
<LINK href="../Admin_STYLE.CSS" rel=stylesheet type=text/css>
<?
if($_GET['action']=="add")
{
		$sql="insert into xiangguan (types,title,content,UpdateTime) values ('".$_GET['types']."','".$_POST['title']."','".$_POST['content']."','".$_POST['UpdateTime']."')";
		$db->query($sql);
		$newID = mysql_insert_id();
}

if($_GET['action']=="Modify")
{
	$tmp_data= str_replace("\"","'",$_POST['content']);
		$sql='UPDATE xiangguan SET title="'.$_POST['title'].'",content="'.$tmp_data.'" WHERE ArticleID="'.$_POST['ArticleID'].'"';
		$db->query($sql);
		$newID = $_POST['ArticleID'];
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
          <td height="22" colspan="2" bgcolor="#E3E3E3" class="tdbg"> 
            <p align="center"> 【<a href="newsModify.php?ArticleID=<? echo $newID?>">修改信息</a>】&nbsp;</p></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
