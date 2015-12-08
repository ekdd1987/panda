<?php
include("../Admin.php");
include("../../includes/conn.php");
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<LINK href="../Admin_STYLE.CSS" rel=stylesheet type=text/css>
<script language=javascript>
function ConfirmDel()
{
   if(confirm("确定要删除吗？"))
     return true;
   else
     return false;
}
</script>
<?
if($_GET['act']=="save")
{
		$sql="insert into ipff (ip) values ('".$_POST['ip']."')";
		$db->query($sql);
		$newID = mysql_insert_id();
}

if($_GET['act']=="save2")
{
	//$tmp_data= str_replace("\"","'",$_POST['content']);
		$sql='UPDATE ipff SET ip="'.$_POST['ip'].'" WHERE id="'.$_GET['id'].'"';
		$db->query($sql);
		$newID = $_GET['id'];
}

if($_GET['id']&&$_GET['act']=="del")
{
	$delsql="delete from ipff where id ='".$_GET['id']."' ";
	$db->query($delsql);
	echo "<script>alert('删除成功!');window.location.href='?';</script>";
	exit;
}
?>

<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td  align="center" valign="top">
      <table width="800" border="0" cellpadding="0" cellspacing="1" class="border">
        <tr>
          <td class="topbg" height="25"><div align="center"><a href="kuaidi.asp" style="color:#FFFFFF; font-weight:bold"></a><a href="youfei.asp" style="color:#FFFFFF; font-weight:bold">封IP管理</a></div></td>
        </tr>
        <tr> 
          <td height="25"><div align="center">
              <table width="100%" border="0" align="center" cellpadding="0" cellspacing="1">
                <tr class="Title">
                  <td width="544" align="center"><strong>ip</strong></td>
                  <td width="249" height="25" align="center"><strong> 操作</strong></td>
                </tr>
<?
$sql12="select * from ipff order by id asc";
$query12=$db->query($sql12);
while($row12=$db->fetch_array($query12))
{
?>
                <tr class="tdbg">
                  <td height="22" align="center" class=tdbg><? echo $row12['ip']?></td>
                  <td align="center" class=tdbg><a href="?id=<? echo $row12['id']?>&act=mod">修改</a>&nbsp;&nbsp;<a href="?id=<? echo $row12['id']?>&act=del" onClick="return ConfirmDel();">删除</a></td>
                </tr>
<?
}
?>
              </table>
          </div></td>
        </tr>
      </table>
 <br />
<?
if($_GET['act']!="mod")
{
?>
 <table width="800" border="0" cellpadding="0" cellspacing="0" class="border">
        <tr class="tdbg">
          <form name="searchsoft" method="post" action="?act=save">
            <td height="30"><strong>添加：</strong>   
            IP： 
              <INPUT name="ip" type="text" id="ip" size="30">
          <input name="Query" type="submit" id="Query" value="添加" ></td></form>
        </tr>
      </table>
<?
}
?>

<?
if($_GET['act']=="mod")
{
?>
	  <table width="800" border="0" cellpadding="0" cellspacing="0" class="border">

<?
		 $sql="select * from ipff where id='".$_GET['id']."'";
		 $query=$db->query($sql);
		 $row=$db->fetch_array($query);
?>
        <tr class="tdbg">
          <form name="searchsoft" method="post" action="?act=save2&id=<? echo $row['id']?>">
            <td height="30"><strong>修改：</strong>              IP： 
              <INPUT name="ip" type="text" id="ip" value="<? echo $row['ip']?>" size="30">
              <input name="Query" type="submit" id="Query" value="修改">
              &nbsp;&nbsp;</td></form>
        </tr>
      </table>
<?
}
?>
    </td>
  </tr>
</table>
