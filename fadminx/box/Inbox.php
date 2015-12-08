<?php
include("../Admin.php");
include("../../includes/conn.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<title>火中红莲李</title>

<LINK href="../Admin_STYLE.CSS" rel=stylesheet type=text/css>

<style type="text/css">

<!--

td {

	font-size: 12px;

	line-height: 22px;

}

-->

</style>

</head>



<body>
<?
if($_POST['ArticleID']&&$_GET['Action']=="Del")
{
	$ids = implode(',', $_POST['ArticleID']);
	$delsql="delete from message where id in($ids)";
	$db->query($delsql);
	echo "<script>alert('删除成功!');window.location.href='?page=".$_GET['page']."';</script>";
	exit;
}
?>
<div id="toubu"><span class="tbbiaoti"><strong>收件箱</strong></span></div><br>

<table width="96%" border="0" align="center" cellpadding="0" cellspacing="0" class="border">
      <tr>
        <td height=100 align="right" valign="top">
          
          <table width="100%" border="0" align="center" cellpadding="0" cellspacing="1" class="tablebg2">
<form name="del" method="Post" action="?Action=Del&page=<? echo $page?>" onSubmit="return ConfirmDel();">
            <tr align="center" class="title">

              <td width="120"><input name="chkAll" type="checkbox" id="chkAll" onclick=CheckAll(this.form) value="checkbox"> </td>
              <td width="100" >发件人</td>
              <td align="left">主题</td>
              <td width="40">状态</td>
              <td width="150" >时间</td>

            </tr>
<?php
$t=$_GET['t'];
$myKeyword=$_POST['myKeyword'];
if($myKeyword!="")$sqladd.=" and title like '%".trim($myKeyword)."%' ";
$sqladd.=" ORDER BY id DESC";

$perNumber=15; //每页显示的记录数
$page=$_GET['page']; //获得当前的页面值
$count=$db->query("select count(*) from message where recuid='admin'  {$sqladd}"); //获得记录总数
$rs=$db->fetch_array($count); 
$totalNumber=$rs[0];
$totalPage=ceil($totalNumber/$perNumber); //计算出总页数
if (!isset($page)) {
 $page=1;
} //如果没有值,则赋值1
if(empty($page)) {$page=1;}
$startCount=($page-1)*$perNumber; //分页开始,根据此方法计算出开始的记录
$result=$db->query("select * from message where recuid='admin' {$sqladd} limit $startCount,$perNumber"); //根据前面的计算出开始的记录和记录数
?>
<?php
while ($row=$db->fetch_array($result)) 
{
?>
            <tr align="center" class="tdbg">
             <td  > <input name='ArticleID[]' type='checkbox' onClick="unselectall()" id="ArticleID[]" value='<? echo $row['id']?>'> </td>
             <td  > <? echo $row['senduid']?> </td>
              <td align="left"> <a href="box_view.php?id=<? echo $row['id']?>"><? echo $row['title']?></a></td>
              <td  ><? if($row['states']==1){echo "已阅";} else {echo "未阅";}?></td>
              <td  ><? echo $row['addtime']?></td>

            </tr>
<?
}
?>
            <tr align="center" class="tdbg" >
              <td  ><input name="submit" type='submit' value='删除选定的记录' ></td>
              <td colspan="4"  ></td>
            </tr>

</form>
            
            <tr class="tdbg" height="32">
              <td height="30" colspan=8 align="center" ><form action="" method="post">
<?
getNavHtml($page,$perNumber,$totalNumber,'?t='.$t.'&');
?>&nbsp;&nbsp;<input name="custompage" type="text" onKeyDown="if(event.keyCode==13) {window.location='?orderby=&page='+this.value; return false;}" size="2" class="text" >
<input class="buttom" type="button" name="button" id="button" value="GO" onClick="window.location='?orderby=&page='+custompage.value;" />
</form>
                </td>
            </tr>
          </table>
                  </td>
      </tr>

</table>
<SCRIPT language=javascript>
function unselectall()
{
    if(document.del.chkAll.checked){
	document.del.chkAll.checked = document.del.chkAll.checked&0;
    } 	
}

function CheckAll(form)
  {
  for (var i=0;i<form.elements.length;i++)
    {
    var e = form.elements[i];
    if (e.Name != "chkAll")
       e.checked = form.chkAll.checked;
    }
  }
function ConfirmDel()
{
   if(confirm("确定要删除选中的记录吗？一旦删除将不能恢复！"))
     return true;
   else
     return false;
	 
}

</SCRIPT>
</body>
</html>
