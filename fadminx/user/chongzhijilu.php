<?php
include("../Admin.php");
include("../../includes/conn.php");
?>
<?
if($_COOKIE["Purview"]!="1") 
{
echo "权限不足";
exit();
}
?>
<LINK href="../Admin_STYLE.CSS" rel=stylesheet type=text/css>
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

$perNumber=20; //每页显示的记录数
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

  充值记录&nbsp;
  <table width="98%"  border="0" cellspacing="0" cellpadding="0">
    <tr> 
    <form method="post" action="?" name="form1">
      <td colspan="11" class="tdbg"><div align="right">  日期
              <input name="riqi" type="text" id="riqi" value="<? echo $riqi?>" size="16" onFocus="WdatePicker({skin:'whyGreen'})" readonly>-<input name="riqi2" type="text" id="riqi2" value="<? echo $riqi2?>" size="16" onFocus="WdatePicker({skin:'whyGreen'})" readonly> 
              会员
              <input type="text" name="myKeyword" size="16" value="<? echo $myKeyword?>">
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
    <td height="20"><? echo $row['userid']?></td>
    <td><? echo $row['jine']?></td>
    <td><? if($row['types']==1){echo "星币";}else{echo "星币";}?></td>
    <td><? echo $row['addtime']?></td>
    <td><? echo $row['reason']?></td>
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
getNavHtml($page,$perNumber,$totalNumber,'?riqi='.$riqi.'&riqi2='.$riqi2.'&myKeyword='.$myKeyword.'&');
?>&nbsp;&nbsp;<input class="p_input" type="text" name="custompage" onKeyDown="if(event.keyCode==13) {window.location='?page='+this.value; return false;}">
<input class="p_input" type="button" name="button" id="button" value="跳转" onClick="window.location='?page='+custompage.value;" /></td>
          </tr></form>
</table>
</body>
</html>
