<?php
include("../Admin.php");
include("../../includes/conn.php");
?>
<LINK href="../Admin_STYLE.CSS" rel=stylesheet type=text/css>
<?php
$l=$_GET['l'];
$riqi=$_POST['riqi'];
$riqi2=$_POST['riqi2'];
$myKeyword=$_POST['myKeyword'];
$myKeyword2=$_POST['myKeyword2'];
if($l<>"")$sqladd.=" and standardlevel= '".trim($l)."' ";
if($riqi)$sqladd.=" and DATE_FORMAT(addtimes,'%Y-%m-%d') >= '".trim($riqi)."' ";
if($riqi2)$sqladd.=" and DATE_FORMAT(addtimes,'%Y-%m-%d') <= '".trim($riqi2)."' ";
if($myKeyword)$sqladd.=" and userid like '%".trim($myKeyword)."%' ";
if($myKeyword2)$sqladd.=" and truename like '%".trim($myKeyword2)."%' ";
$sqladd.=' ORDER BY id DESC';

$perNumber=30; //每页显示的记录数
$page=$_GET['page']; //获得当前的页面值
$count=$db->query("select count(*) from juankuan where id>0 {$sqladd}"); //获得记录总数
$rs=$db->fetch_array($count); 
$totalNumber=$rs[0];
$totalPage=ceil($totalNumber/$perNumber); //计算出总页数
if (!isset($page)) {
 $page=1;
} //如果没有值,则赋值1
if(empty($page)) {$page=1;}
$startCount=($page-1)*$perNumber; //分页开始,根据此方法计算出开始的记录
$result=$db->query("select * from juankuan where id>0 {$sqladd} limit $startCount,$perNumber"); //根据前面的计算出开始的记录和记录数
?>
<html>
<head>
<title>会员管理</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="images/css1.css" type="text/css">

<style type="text/css">
<!--
.style1 {color: #000000}
-->
</style>
<script language="javascript" type="text/javascript" src="../../My97DatePicker/WdatePicker.js"></script>
</head>

<body text="#000000" leftmargin="0" topmargin="0">
<div align="right"></div>
<div align="center"><br>
  爱心捐款记录
    
    <table width="98%"  border="0" cellspacing="0" cellpadding="0">
    <tr> 
    <form method="post" action="ip.php" name="form1">
      <td colspan="11" class="tdbg"> 
        <div align="right"><span class="tdbg">
          日期
              <input name="riqi" type="text" id="riqi" value="<? echo $riqi?>" size="16" onFocus="WdatePicker({skin:'whyGreen'})" readonly>-<input name="riqi2" type="text" id="riqi2" value="<? echo $riqi2?>" size="16" onFocus="WdatePicker({skin:'whyGreen'})" readonly>
          用户名</span> 
          <input type="text" name="myKeyword" size="16" value="<? echo $myKeyword?>">
          <input type="submit" name="Submit" value="搜索">
      </div>      </td>
    </form>
  </tr>
</table>
</div>
<table width="98%" border="0" align="center" cellpadding="1" cellspacing="1" bordercolorlight=#145AA0 bordercolordark=#9CC7EF class='border'>
  <tr bgcolor="#eeeeee" class="title" align="center"> 
    <td height="22" nowrap>用户名</td>
    <td nowrap>金额</td>
    <td nowrap>时间</td>
  </tr>
<?php
while ($row=$db->fetch_array($result)) 
{
	

?>

  <tr bgcolor="#FFFFFF" class="tdbg" align="center"> 
    <td><? echo $row['userid']?></td>
    <td><? echo $row['amount']?></td>
    <td><? echo $row['addtimes']?></td>
  </tr>
<?
}
?>
<form action="" method="post">
  <tr bgcolor="#FFFFFF"> 
    <td colspan="3" class="tdbg" align="center"> 
<?
getNavHtml($page,$perNumber,$totalNumber,'?l='.$l.'&myKeyword='.$myKeyword.'&');
?>&nbsp;&nbsp;<input class="p_input" type="text" name="custompage" onKeyDown="if(event.keyCode==13) {window.location='?page='+this.value; return false;}">
<input class="p_input" type="button" name="button" id="button" value="跳转" onClick="window.location='?page='+custompage.value;" />
</td>
  </tr></form>
</table>
</body>
</html>
