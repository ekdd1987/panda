<?php
ini_set("max_execution_time", "1800"); 
set_time_limit(1800) ;
header("Content-type:application/vnd.ms-excel");
header("Content-Disposition:attachment;filename=zhuanzhang_data.xls");
include("../Admin.php");
include("../../includes/conn.php");
?>
<?php
$riqi=$_REQUEST['riqi'];
$riqi2=$_REQUEST['riqi2'];
$jine1=$_REQUEST['jine1'];
$jine2=$_REQUEST['jine2'];
$myKeyword=$_REQUEST['myKeyword'];
$myKeyword2=$_REQUEST['myKeyword2'];
$paixu=$_REQUEST['paixu'];
if($riqi)$sqladd.=" and DATE_FORMAT(addtime,'%Y-%m-%d') >= '".trim($riqi)."' ";
if($riqi2)$sqladd.=" and DATE_FORMAT(addtime,'%Y-%m-%d') <= '".trim($riqi2)."' ";
if($myKeyword)$sqladd.=" and userid like '%".trim($myKeyword)."%' ";
if($myKeyword2)$sqladd.=" and jieuserid like '%".trim($myKeyword2)."%' ";
if($jine1!="")$sqladd.=" and jine >= '".trim($jine1)."' ";
if($jine2!="")$sqladd.=" and jine <= '".trim($jine2)."' ";
if($paixu==1)
{
$sqladd.=' ORDER BY jine asc';
}
elseif($paixu==2)
{
$sqladd.=' ORDER BY jine desc';
}
else
{
$sqladd.=' ORDER BY id DESC';
}

$perNumber=20000; //每页显示的记录数
$page=$_GET['page']; //获得当前的页面值
$count=$db->query("select count(*) from shengji where id>0 {$sqladd}"); //获得记录总数
$rs=$db->fetch_array($count); 
$totalNumber=$rs[0];
$totalPage=ceil($totalNumber/$perNumber); //计算出总页数
if (!isset($page)) {
 $page=1;
} //如果没有值,则赋值1
if(empty($page)) {$page=1;}
$startCount=($page-1)*$perNumber; //分页开始,根据此方法计算出开始的记录
$result=$db->query("select * from shengji where id>0 {$sqladd} limit $startCount,$perNumber"); //根据前面的计算出开始的记录和记录数
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<table cellspacing="0" cellpadding="3" rules="cols" bordercolor="#999999" border="1" id="data" style="color:Black;background-color:White;border-color:#999999;border-width:1px;border-style:Solid;width:100%;border-collapse:collapse;">
  <tr  class="title" align="center">
    <td width="8%" height="24" nowrap  >升级会员</td>
    <td width="15%" nowrap >申请级别</td>
    <td width="13%" nowrap >接款会员</td>
    <td width="13%" nowrap >状态</td>
    <td width="13%" nowrap >申请时间</td>
    <td width="13%" nowrap >确认时间</td>
    </tr>
<?php
while ($row=$db->fetch_array($result)) 
{
?>

  <tr bgcolor="#FFFFFF" class="tdbg" align="center">
    <td height="20" ><? echo $row['userid']?></td>
    <td ><? echo $row['jibie']?>级</td>
    <td ><? echo $row['jieuserid']?></td>
    <td ><? if($row['passed']==1){echo "已经确认";}else{echo "未处理";}?></td>
    <td ><? echo $row['addtime']?></td>
    <td ><? echo $row['passtime']?></td>
    </tr>
<?
}
?>

</table>
