<LINK href="../Admin_STYLE.CSS" rel=stylesheet type=text/css>
<?php
include("../Admin.php");
include("../../includes/conn.php");

if($_GET['id']&&$_GET['act']=="del")
{
	$delsql="delete from users where id ='".$_GET['id']."' ";
	mysql_query($delsql);
	echo "<script>alert('删除成功!');window.location.href='?page=".$_GET['page']."';</script>";
	exit;
}

?>

<?php
$myKeyword=$_POST['myKeyword'];
if($types)$sqladd.=" and types ='".trim($types)."' ";
if($myKeyword)$sqladd.=" and loginname like '%".trim($myKeyword)."%' ";
$sqladd.=' ORDER BY id DESC';

$perNumber=20; //每页显示的记录数
$page=$_GET['page']; //获得当前的页面值
$count=mysql_query("select count(*) from users where states=0 {$sqladd}"); //获得记录总数
$rs=mysql_fetch_array($count); 
$totalNumber=$rs[0];
$totalPage=ceil($totalNumber/$perNumber); //计算出总页数
if (!isset($page)) {
 $page=1;
} //如果没有值,则赋值1
if(empty($page)) {$page=1;}
$startCount=($page-1)*$perNumber; //分页开始,根据此方法计算出开始的记录
$result=mysql_query("select * from users where states=0 {$sqladd} limit $startCount,$perNumber"); //根据前面的计算出开始的记录和记录数
?>
<html>
<head>
<title>会员管理</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="images/css1.css" type="text/css">
<script language=Javascript>
<!--
function jumpTo(i){
if(i==1){
	this.document.location="<%=thisUrl%>";}
if(i==2){
	this.document.location="<%=thisUrl%>&page=<%=page-1%>";}
if(i==3){
	this.document.location="<%=thisUrl%>&page=<%=page+1%>";}
if(i==4){
	this.document.location="<%=thisUrl%>&page=<%=rs.pageCount%>";}
}
//-->
</script>
<style type="text/css">
<!--
.style1 {color: #000000}
-->
</style>
</head>

<body text="#000000" leftmargin="0" topmargin="0">
<div align="center"><br>
  待激活会员管理 　</div>
<table width="95%" border="0" align="center" cellpadding="1" cellspacing="1" bordercolorlight=#145AA0 bordercolordark=#9CC7EF bgcolor="#cccccc">
  <tr bgcolor="#eeeeee"> 
    <form method="post" action="lsuserManage.php" name="form1">
      <td colspan="5"> <div align="right"><span class="style1">关键词</span> 
          <input type="text" name="myKeyword" size="16">
          <input type="submit" name="Submit" value="搜索">
        </div></td>
    </form>
  </tr>
  <tr bgcolor="#eeeeee"> 
    <td width="12%" nowrap bgcolor="#eeeeee">会员编号</td>
    <td width="9%" height="30" nowrap bgcolor="#eeeeee">推荐人</td>
    <td width="12%" nowrap>微信</td>
    <td width="13%" align="center" nowrap>注册时间</td>
    <td width="8%" nowrap align="center">操作</td>
  </tr>
<?php
while ($row=mysql_fetch_array($result)) 
{
?>

  <tr bgcolor="#FFFFFF"> 
    <td height="26"><? echo $row['loginname']?></td>
    <td height="26"><? echo $row['rid']?></td>
    <td><? echo $row['wechat']?></td>
    <td align="center"><? echo $row['addtime']?></td>
    <td align="center"><a onClick="javascript:return confirm(&#39;确定删除吗？&#39;);" href="?act=del&id=<? echo $row['id']?>&pid=<? echo $row['pid']?>&rid=<? echo $row['rid']?>&loginname=<? echo $loginname?>&page=<? echo $page?>">删除</a></td>
  </tr>
<?
}
?>

</table><table width="720" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td height="30" align="center">
<?
getNavHtml($page,$perNumber,$totalNumber,'?');
?>&nbsp;&nbsp;<input class="p_input" type="text" name="custompage" onKeyDown="if(event.keyCode==13) {window.location='?orderby=&page='+this.value; return false;}">
<input class="p_input" type="button" name="button" id="button" value="跳转" onClick="window.location='?orderby=&page='+custompage.value;" /></td>
          </tr>
        </table>
</body>
</html>
