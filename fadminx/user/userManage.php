<?php
include("../Admin.php");
include("../../includes/conn.php");
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


if($riqi)$sqladd.=" and jihuodate >= '".trim($riqi)."' ";
if($riqi2)$sqladd.=" and jihuodate <= '".trim($riqi2)."' ";


$sqladd.=' ORDER BY id DESC';


$perNumber=20; //每页显示的记录数
$page=$_GET['page']; //获得当前的页面值
$count=$db->query("select count(*) from users where states>=1 {$sqladd}"); //获得记录总数
$rs=$db->fetch_array($count); 
$totalNumber=$rs[0];
$totalPage=ceil($totalNumber/$perNumber); //计算出总页数
if (!isset($page)) {
 $page=1;
} //如果没有值,则赋值1
if(empty($page)) {$page=1;}
$startCount=($page-1)*$perNumber; //分页开始,根据此方法计算出开始的记录
$result=$db->query("select * from users where states>=1 {$sqladd} limit $startCount,$perNumber"); //根据前面的计算出开始的记录和记录数
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
  系统会员管理&nbsp;
  <table width="98%"  border="0" cellspacing="0" cellpadding="0">
    <tr> 
    <form method="post" action="usermanage.php" name="form1">
      <td colspan="11" class="tdbg"> 
        <div align="right"><span class="tdbg">
          编号
            <input type="text" name="myKeyword" size="16" value="<? echo $myKeyword?>">
            
时间
<input name="riqi" type="text" id="riqi" value="<? echo $riqi?>" size="16" onFocus="WdatePicker({skin:'whyGreen'})" readonly>-<input name="riqi2" type="text" id="riqi2" value="<? echo $riqi2?>" size="16" onFocus="WdatePicker({skin:'whyGreen'})" readonly>
        </span>
          <input type="submit" name="Submit" value="搜索">
      </div>      </td>
    </form>
  </tr>
</table>
</div>
<table width="98%" border="0" align="center" cellpadding="1" cellspacing="1" bordercolorlight=#145AA0 bordercolordark=#9CC7EF class='border'>
  <tr bgcolor="#eeeeee" class="title" align="center">
    <td nowrap>ID</td>
    <td height="22" nowrap>会员编号</td>
    <td nowrap>微信</td>
    <td nowrap>推荐人数量</td>
    <td nowrap>级别</td>
    <td nowrap>推荐人</td>
    <td nowrap align="center">登录</td>
    <td nowrap>注册时间</td>
    <td nowrap>激活时间</td>
    <td nowrap> <div align="center"><font class="style1">资料修改</font></div></td>
  </tr>
<?php
while ($row=$db->fetch_array($result)) 
{
?>

  <tr bgcolor="#FFFFFF" class="tdbg" align="center">
    <td><? echo $row['id']?></td>
    <td><? echo $row['loginname']?></td>
    <td><? echo $row['wechat']?></td>
    <td><? echo $row['tjnum']?></td>
    <td><? echo $row['standardlevel']?>级</td>
    <td><? echo $row['rid']?></td>
    <td align="center"><? if($row['lockuser']=="1") {echo '已锁定';} else {echo '正常';} ?> </td>
    <td><? echo $row['addtime']?></td>
    <td><? echo $row['jihuotime']?></td>
    <td> <div align="center">&nbsp;&nbsp;<a href="usermod.php?id=<? echo $row['id']?>&username=<? echo $row['loginname']?>&page=<? echo $page?>">详细</a> <a href="l.php?id=<? echo $row['id']?>" target="_blank">进入前台</a></div></td>
  </tr>
<?
}
?>
<form action="" method="post">
  <tr bgcolor="#FFFFFF"> 
    <td colspan="10" class="tdbg" align="center"> 
<?
getNavHtml($page,$perNumber,$totalNumber,'?types='.$types.'&myKeyword='.$myKeyword.'&jj='.$jj.'&jj2='.$jj2.'&riqi='.$riqi.'&riqi2='.$riqi2.'&paixu='.$paixu.'&');
?>&nbsp;&nbsp;<input class="p_input" type="text" name="custompage" onKeyDown="if(event.keyCode==13) {window.location='?page='+this.value; return false;}">
<input class="p_input" type="button" name="button" id="button" value="跳转" onClick="window.location='?page='+custompage.value;" />
</td>
  </tr></form>
</table>
</body>
</html>
