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
if($riqi)$sqladd.=" and DATE_FORMAT(change_time,'%Y-%m-%d') >= '".trim($riqi)."' ";
if($riqi2)$sqladd.=" and DATE_FORMAT(change_time,'%Y-%m-%d') <= '".trim($riqi2)."' ";
if($myKeyword)$sqladd.=" and send_userid like '%".trim($myKeyword)."%' ";
if($myKeyword2)$sqladd.=" and to_userid like '%".trim($myKeyword2)."%' ";
if($jine1!="")$sqladd.=" and money >= '".trim($jine1)."' ";
if($jine2!="")$sqladd.=" and money <= '".trim($jine2)."' ";
if($paixu==1)
{
$sqladd.=' ORDER BY money asc';
}
elseif($paixu==2)
{
$sqladd.=' ORDER BY money desc';
}
else
{
$sqladd.=' ORDER BY id DESC';
}

$perNumber=20; //每页显示的记录数
$page=$_GET['page']; //获得当前的页面值
$count=$db->query("select count(*) from change_money where id>0 {$sqladd}"); //获得记录总数
$rs=$db->fetch_array($count); 
$totalNumber=$rs[0];
$totalPage=ceil($totalNumber/$perNumber); //计算出总页数
if (!isset($page)) {
 $page=1;
} //如果没有值,则赋值1
if(empty($page)) {$page=1;}
$startCount=($page-1)*$perNumber; //分页开始,根据此方法计算出开始的记录
$result=$db->query("select * from change_money where id>0 {$sqladd} limit $startCount,$perNumber"); //根据前面的计算出开始的记录和记录数
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

  转账记录管理&nbsp;<input type="button" name="Button4" value="导出 Excel" id="Button4" onClick="window.location='changerecode_excel.php?riqi=<? echo $riqi?>&riqi2=<? echo $riqi2?>&myKeyword=<? echo $myKeyword?>&myKeyword2=<? echo $myKeyword2?>&jine1=<? echo $jine1?>&jine2=<? echo $jine2?>&paixu=<? echo $paixu?>';"  />
    
    <table width="98%"  border="0" cellspacing="0" cellpadding="0">
      <tr> 
    <form method="post" action="?" name="form1">
      <td colspan="11" class="tdbg"><div align="right">  日期
              <input name="riqi" type="text" id="riqi" value="<? echo $riqi?>" size="16" onFocus="WdatePicker({skin:'whyGreen'})" readonly>-<input name="riqi2" type="text" id="riqi2" value="<? echo $riqi2?>" size="16" onFocus="WdatePicker({skin:'whyGreen'})" readonly> 
              转出会员
              <input type="text" name="myKeyword" size="16" value="<? echo $myKeyword?>">转入会员
              <input type="text" name="myKeyword2" size="16" value="<? echo $myKeyword2?>">
  金额
  <input name="jine1" type="text" id="jine1" value="<? echo $jine1?>" size="16">
  -
  <input name="jine2" type="text" id="jine2" value="<? echo $jine2?>" size="16"> 
  排序
  <select name="paixu" id="paixu">
    <option value="1" <? if($paixu==1){echo "selected";}?>>数字从小到大</option>
    <option value="2" <? if($paixu==2){echo "selected";}?>>数字从大到小</option>
  </select>
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
    <td width="8%" height="24" nowrap >转出会员</td>
    <td width="15%" nowrap align="center">转入会员</td>
    <td width="15%" nowrap>转账金额</td>
    <td width="13%" nowrap>时间</td>
    </tr>
<?php
while ($row=$db->fetch_array($result)) 
{
?>

  <tr bgcolor="#FFFFFF" class="tdbg" align="center">
    <td height="20"><? echo $row['send_userid']?></td>
    <td align="center"><? echo $row['to_userid']?></td>
    <td><? echo $row['money']?></td>
    <td><? echo $row['change_time']?></td>
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
