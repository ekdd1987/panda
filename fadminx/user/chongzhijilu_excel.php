<?php
ini_set("max_execution_time", "1800"); 
set_time_limit(1800) ;
header("Content-type:application/vnd.ms-excel");
header("Content-Disposition:attachment;filename=chongzhi_a_data.xls");
include("../Admin.php");
include("../../includes/conn.php");
?>
<?php
$t=$_REQUEST['t'];
$riqi=$_REQUEST['riqi'];
$riqi2=$_REQUEST['riqi2'];
$myKeyword=$_REQUEST['myKeyword'];
$myKeyword2=$_REQUEST['myKeyword2'];
if($riqi)$sqladd.=" and DATE_FORMAT(adddate,'%Y-%m-%d') >= '".trim($riqi)."' ";
if($riqi2)$sqladd.=" and DATE_FORMAT(adddate,'%Y-%m-%d') <= '".trim($riqi2)."' ";
if($myKeyword)$sqladd.=" and userid like '%".trim($myKeyword)."%' ";
if($t!="")$sqladd.=" and types = '".trim($t)."' ";
$sqladd.=' and wang=1 ORDER BY id DESC';

$perNumber=20000; //每页显示的记录数
$page=$_GET['page']; //获得当前的页面值
$count=$db->query("select count(*) from czrecode where id>0 {$sqladd}"); //获得记录总数
$rs=$db->fetch_array($count); 
$totalNumber=$rs[0];
$totalPage=ceil($totalNumber/$perNumber); //计算出总页数
if (!isset($page)) {
 $page=1;
} //如果没有值,则赋值1
if(empty($page)) {$page=1;}
$startCount=($page-1)*$perNumber; //分页开始,根据此方法计算出开始的记录
$result=$db->query("select * from czrecode where id>0 {$sqladd} limit $startCount,$perNumber"); //根据前面的计算出开始的记录和记录数
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<table cellspacing="0" cellpadding="3" rules="cols" bordercolor="#999999" border="1" id="data" style="color:Black;background-color:White;border-color:#999999;border-width:1px;border-style:Solid;width:100%;border-collapse:collapse;">
  <tr  class="title" align="center">
    <td width="10%" height="24" nowrap >会员编号</td>
    <td width="15%" nowrap>充值金额</td>
    <td width="15%" nowrap>充值类型</td>
    <td width="12%" nowrap>充值时间</td>
    <td width="12%" nowrap>备注</td>
    </tr>
<?php
while ($row=$db->fetch_array($result)) 
{
?>

  <tr bgcolor="#FFFFFF" class="tdbg" align="center">
    <td height="20">&nbsp;<? echo $row['userid']?></td>
    <td><? echo $row['jine']?></td>
    <td><? if($row['types']==1){echo "积分";}else{echo "报单币";}?></td>
    <td><? echo $row['addtime']?></td>
    <td><? echo $row['reason']?></td>
    </tr>
<?
}
?>

</table>


