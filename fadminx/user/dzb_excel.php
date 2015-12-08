<?php
ini_set("max_execution_time", "1800"); 
set_time_limit(1800) ;
header("Content-type:application/vnd.ms-excel");
header("Content-Disposition:attachment;filename=user_data.xls");
include("../Admin.php");
include("../../includes/conn.php");
?>
<?php

$riqi=$_REQUEST['riqi'];
$riqi2=$_REQUEST['riqi2'];
$jine1=$_REQUEST['jine1'];
$jine2=$_REQUEST['jine2'];
$myKeyword=$_REQUEST['myKeyword'];
$types=$_REQUEST['types'];
$reason=$_REQUEST['reason'];
$paixu=$_REQUEST['paixu'];

if($riqi)$sqladd.=" and addtime >= '".trim($riqi)."' ";
if($riqi2)$sqladd.=" and addtime <= '".trim($riqi2)."' ";
if($jine1!="")$sqladd.=" and jine >= '".trim($jine1)."' ";
if($jine2!="")$sqladd.=" and jine <= '".trim($jine2)."' ";
if($myKeyword)$sqladd.=" and userid like '%".trim($myKeyword)."%' ";
if($types!="")$sqladd.=" and types like '%".trim($types)."%' ";
if($reason)$sqladd.=" and reason like '%".trim($reason)."%' ";
if($paixu==1)
{
	$sqladd.='  ORDER BY jine asc';
}
elseif($paixu==2)
{
	$sqladd.='  ORDER BY jine desc';
}
elseif($paixu==3)
{
	$sqladd.='  ORDER BY addtime asc';
}
elseif($paixu==4)
{
	$sqladd.='  ORDER BY addtime desc';
}
else
{
	$sqladd.='  ORDER BY id desc';
}


$perNumber=50000; //每页显示的记录数
$page=$_GET['page']; //获得当前的页面值
$count=$db->query("select count(*) from income where id>0 {$sqladd}"); //获得记录总数
$rs=$db->fetch_array($count); 
$totalNumber=$rs[0];
$totalPage=ceil($totalNumber/$perNumber); //计算出总页数
if (!isset($page)) {
 $page=1;
} //如果没有值,则赋值1
if(empty($page)) {$page=1;}
$startCount=($page-1)*$perNumber; //分页开始,根据此方法计算出开始的记录
$result=$db->query("select * from income where id>0 {$sqladd} limit $startCount,$perNumber"); //根据前面的计算出开始的记录和记录数
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<table cellspacing="0" cellpadding="3" rules="cols" bordercolor="#999999" border="1" id="data" style="color:Black;background-color:White;border-color:#999999;border-width:1px;border-style:Solid;width:100%;border-collapse:collapse;">
  <tr align="center"> 
    <td height="22" nowrap> 会员编号</td>
    <td nowrap>类型</td>
    <td nowrap>奖金</td>
    <td nowrap align="center">余额</td>
    <td nowrap align="center">说明</td>
    <td nowrap>颁发时间</td>
  </tr>
<?php
while ($row=$db->fetch_array($result)) 
{
?>
  <tr bgcolor="#FFFFFF" class="tdbg" align="center"> 
    <td height="20"> <? echo $row['userid']?>&nbsp;</td>
    <td><? echo $row['types']?></td>
    <td><? echo $row['jine']?></td>
    <td align="center"><? echo $row['nowamount']?></td>
    <td align="center"><? echo $row['reason']?></td>
    <td align="center"><? echo $row['addtime']?></td>
  </tr>
<?
}
?>
</table>