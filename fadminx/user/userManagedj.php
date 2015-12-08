<?php
include("../Admin.php");
include("../../includes/conn.php");

if($_GET['id']!=""&&$_GET['act']=="jiechu")
{
	$delsql="update users set dongjie=0 where id ='".$_GET['id']."' ";
	$db->query($delsql);
	echo "<script>alert('解除冻结成功!');window.location.href='?page=".$_GET['page']."';</script>";
	exit;
}
?>
<LINK href="../Admin_STYLE.CSS" rel=stylesheet type=text/css>
<?php
$types=$_REQUEST['types'];
$jj=$_REQUEST['jj'];
$jj2=$_REQUEST['jj2'];
$riqi=$_REQUEST['riqi'];
$riqi2=$_REQUEST['riqi2'];
$jine1=$_REQUEST['jine1'];
$jine2=$_REQUEST['jine2'];
$myKeyword=$_REQUEST['myKeyword'];
$paixu=$_REQUEST['paixu'];
$oldlevel=$_REQUEST['oldlevel'];
$nowlevel=$_REQUEST['nowlevel'];
$level=$_REQUEST['level'];
$paixu=$_REQUEST['paixu'];
if($myKeyword!="")$sqladd.=" and loginname like '%".trim($myKeyword)."%' ";

if($jj)$sqladd.=" and amount_this >= '".trim($jj)."' ";
if($jj2)$sqladd.=" and amount_this <= '".trim($jj2)."' ";
if($riqi)$sqladd.=" and jihuodate >= '".trim($riqi)."' ";
if($riqi2)$sqladd.=" and jihuodate <= '".trim($riqi2)."' ";
if($jine1!="")$sqladd.=" and amount >= '".trim($jine1)."' ";
if($jine2!="")$sqladd.=" and amount <= '".trim($jine2)."' ";
//if($oldlevel!="")$sqladd.=" and oldstandardlevel= '".trim($oldlevel)."' ";
//if($nowlevel!="")$sqladd.=" and standardlevel= '".trim($nowlevel)."' ";
if($paixu==1)
{
$sqladd.=' ORDER BY amount asc';
}
elseif($paixu==2)
{
$sqladd.=' ORDER BY amount desc';
}
else
{
$sqladd.=' ORDER BY id DESC';
}

$perNumber=20; //每页显示的记录数
$page=$_GET['page']; //获得当前的页面值
$count=$db->query("select count(*) from users where dongjie=1 {$sqladd}"); //获得记录总数
$rs=$db->fetch_array($count); 
$totalNumber=$rs[0];
$totalPage=ceil($totalNumber/$perNumber); //计算出总页数
if (!isset($page)) {
 $page=1;
} //如果没有值,则赋值1
if(empty($page)) {$page=1;}
$startCount=($page-1)*$perNumber; //分页开始,根据此方法计算出开始的记录
$result=$db->query("select * from users where dongjie=1 {$sqladd} limit $startCount,$perNumber"); //根据前面的计算出开始的记录和记录数
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
  冻结会员管理&nbsp;
  <table width="98%"  border="0" cellspacing="0" cellpadding="0">
    <tr> 
    <form method="post" action="usermanage.php" name="form1">
      <td colspan="11" class="tdbg"> 
        <div align="right"><span class="tdbg">
          编号
            <input type="text" name="myKeyword" size="16" value="<? echo $myKeyword?>">
        </span>
          <input type="submit" name="Submit" value="搜索">
      </div>      </td>
    </form>
  </tr>
</table>
</div>
<table width="98%" border="0" align="center" cellpadding="1" cellspacing="1" bordercolorlight=#145AA0 bordercolordark=#9CC7EF class='border'>
  <tr bgcolor="#eeeeee" class="title" align="center">
    <td height="22" nowrap>会员编号</td>
    <td nowrap>会员姓名</td>
    <td nowrap>联系电话</td>
    <td nowrap>开户行</td>
    <td nowrap>开户账号</td>
    <td nowrap>推荐人数量</td>
    <td nowrap>级别</td>
    <td nowrap>电子币</td>
    <td nowrap>推荐人</td>
    <td nowrap>注册时间</td>
    <td nowrap>激活时间</td>
    <td nowrap> <div align="center"><font class="style1">操作</font></div></td>
  </tr>
<?php
while ($row=$db->fetch_array($result)) 
{
?>

  <tr bgcolor="#FFFFFF" class="tdbg" align="center">
    <td><? echo $row['loginname']?></td>
    <td><? echo $row['bankname']?></td>
    <td><? echo $row['tel']?></td>
    <td><? echo $row['bank']?></td>
    <td><? echo $row['bankno']?></td>
    <td><? echo $row['tjnum']?></td>
    <td><? echo $row['standardlevel']?>级</td>
    <td><? echo $row['amount']?></td>
    <td><? echo $row['rid']?></td>
    <td><? echo $row['addtime']?></td>
    <td><? echo $row['jihuotime']?></td>
    <td> <div align="center">&nbsp;&nbsp;<a href="?id=<? echo $row['id']?>&act=jiechu&page=<? echo $page?>">解除冻结</a></div></td>
  </tr>
<?
}
?>
<form action="" method="post">
  <tr bgcolor="#FFFFFF"> 
    <td colspan="12" class="tdbg" align="center"> 
<?
getNavHtml($page,$perNumber,$totalNumber,'?types='.$types.'&myKeyword='.$myKeyword.'&jj='.$jj.'&jj2='.$jj2.'&riqi='.$riqi.'&riqi2='.$riqi2.'&paixu='.$paixu.'&');
?>&nbsp;&nbsp;<input class="p_input" type="text" name="custompage" onKeyDown="if(event.keyCode==13) {window.location='?page='+this.value; return false;}">
<input class="p_input" type="button" name="button" id="button" value="跳转" onClick="window.location='?page='+custompage.value;" />
</td>
  </tr></form>
</table>
</body>
</html>
