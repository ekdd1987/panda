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

$perNumber=20; //每页显示的记录数
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
<title>会员管理</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="images/css1.css" type="text/css">
<script language="javascript" type="text/javascript" src="../../My97DatePicker/WdatePicker.js"></script>
<style type="text/css">
<!--
.style1 {color: #000000}
-->
</style>
</head>

<body text="#000000" leftmargin="0" topmargin="0">
<div align="center"><br>

  会员升级明细&nbsp;<input type="button" name="Button4" value="导出 Excel" id="Button4" onClick="window.location='shengji_excel.php?riqi=<? echo $riqi?>&riqi2=<? echo $riqi2?>&myKeyword=<? echo $myKeyword?>&myKeyword2=<? echo $myKeyword2?>';"  />
  <table width="98%"  border="0" cellspacing="0" cellpadding="0">
    <tr> 
    <form method="post" action="?" name="form1">
      <td colspan="11" class="tdbg"><div align="right">  日期
              <input name="riqi" type="text" id="riqi" value="<? echo $riqi?>" size="16" onFocus="WdatePicker({skin:'whyGreen'})" readonly>-<input name="riqi2" type="text" id="riqi2" value="<? echo $riqi2?>" size="16" onFocus="WdatePicker({skin:'whyGreen'})" readonly> 
              升级会员
              <input type="text" name="myKeyword" size="16" value="<? echo $myKeyword?>">
              接款会员
              <input type="text" name="myKeyword2" size="16" value="<? echo $myKeyword2?>">
            <input type="submit" name="Submit" value="搜索">
        </div>
        <div align="right"><span class="tdbg">
          </span>      </div>      </td>
    </form>
  </tr>
  </table>
</div>

<table width="98%" border="0" align="center" cellpadding="1" cellspacing="1" bordercolorlight=#145AA0 bordercolordark=#9CC7EF class='border'>

  <tr  class="title" align="center">
    <td height="24" nowrap >升级会员</td>
    <td nowrap align="center">申请级别</td>
    <td nowrap>接款会员</td>
    <td nowrap>状态</td>
    <td nowrap>申请时间</td>
    <td nowrap>确认时间</td>
    </tr>
<?php
while ($row=$db->fetch_array($result)) 
{
?>

  <tr bgcolor="#FFFFFF" class="tdbg" align="center">
    <td height="20"><? echo $row['userid']?></td>
    <td align="center"><? echo $row['jibie']?>级</td>
    <td><? echo $row['jieuserid']?></td>
    <td><? if($row['passed']==1){echo "已经确认";}else{echo "未处理";}?></td>
    <td><? echo $row['addtime']?></td>
    <td><? echo $row['passtime']?></td>
    </tr>
<?
}
?>

</table>
</form>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
<form action="" method="post">
          <tr> 
            <td height="30" align="center"><?
getNavHtml($page,$perNumber,$totalNumber,'?riqi='.$riqi.'&riqi2='.$riqi2.'&myKeyword='.$myKeyword.'&myKeyword2='.$myKeyword2.'&jine1='.$jine1.'&jine2='.$jine2.'&paixu='.$paixu.'&');
?>&nbsp;&nbsp;<input class="p_input" type="text" name="custompage" onKeyDown="if(event.keyCode==13) {window.location='?page='+this.value; return false;}">
<input class="p_input" type="button" name="button" id="button" value="跳转" onClick="window.location='?page='+custompage.value;" /></td>
          </tr></form>
</table>
</body>
</html>
