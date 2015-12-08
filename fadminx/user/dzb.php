<?php
include("../Admin.php");
include("../../includes/conn.php");
?>
<LINK href="../Admin_STYLE.CSS" rel=stylesheet type=text/css>
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


$perNumber=20; //每页显示的记录数
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
<title>会员管理</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="images/css1.css" type="text/css">
<script language="javascript" type="text/javascript" src="../../My97DatePicker/WdatePicker.js"></script>
<style type="text/css">
<!--
.style1 {color: #000000}
.style2 {
	color: #FF0000;
	font-weight: bold;
}
-->
</style>
</head>

<body text="#000000" leftmargin="0" topmargin="0">
<br>
<div align="center">
电子币明细<input type="button" name="Button4" value="导出 Excel" id="Button4" onClick="window.location='dzb_excel.php?types=<? echo $types?>&riqi=<? echo $riqi?>&riqi2=<? echo $riqi2?>&myKeyword=<? echo $myKeyword?>&jine1=<? echo $jine1?>&jine2=<? echo $jine2?>&paixu=<? echo $paixu?>';"  /></div>
<table width="98%"  border="0" align="center" cellpadding="0" cellspacing="0">
      <tr> 
    <form method="post" action="?" name="form1">
      <td colspan="11" class="tdbg"><div align="right">  结算日期
              <input name="riqi" type="text" id="riqi" value="<? echo $riqi?>" size="16" onFocus="WdatePicker({skin:'whyGreen'})" readonly>-<input name="riqi2" type="text" id="riqi2" value="<? echo $riqi2?>" size="16" onFocus="WdatePicker({skin:'whyGreen'})" readonly>
          </span>类型：
          <input name="types" type="text" id="types" value="<? echo $types?>" size="16">
会员编号
<input type="text" name="myKeyword" size="16" value="<? echo $myKeyword?>">
数字范围 
<input name="jine1" type="text" id="jine1" value="<? echo $jine1?>" size="16">
  -
  <input name="jine2" type="text" id="jine2" value="<? echo $jine2?>" size="16">
  排序
  <select name="paixu" id="paixu">
    <option value="1" <? if($paixu==1){echo "selected";}?>>数字从小到大</option>
    <option value="2" <? if($paixu==2){echo "selected";}?>>数字从大到小</option>
    <option value="3" <? if($paixu==3){echo "selected";}?>>日期从小到大</option>
    <option value="4" <? if($paixu==4){echo "selected";}?>>日期从大到小</option>
  </select>
<input type="submit" name="Submit" value="搜索">
        </div>
        <div align="right"><span class="tdbg">
          </span>      </td>
    </form>
  </tr>
</table>
<table width="98%" border="0" align="center" cellpadding="1" cellspacing="1" bordercolorlight=#145AA0 bordercolordark=#9CC7EF class='border'>
  <tr bgcolor="#eeeeee" class="title" align="center"> 
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
  <tr bgcolor="#FFFFFF"> 
    <td colspan="6" class="tdbg" align="center"><?
getNavHtml($page,$perNumber,$totalNumber,'?riqi='.$riqi.'&riqi2='.$riqi2.'&myKeyword='.$myKeyword.'&types='.$types.'&jine1='.$jine1.'&jine2='.$jine2.'&paixu='.$paixu.'&');
?>&nbsp;&nbsp;<input class="p_input" type="text" name="custompage" onKeyDown="if(event.keyCode==13) {window.location='?orderby=&page='+this.value; return false;}">
<input class="p_input" type="button" name="button" id="button" value="跳转" onClick="window.location='?orderby=&page='+custompage.value;" /></td>
  </tr>
</table>
<br>
</body>
</html>
