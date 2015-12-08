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

<?
if($_GET['act']=="qx")
{
	$sql="select * from getamount where id='".$_GET["id"]."' and states=0 ";
		 $query=$db->query($sql);
		 $rowhk=$db->fetch_array($query);
		 if(is_array($rowhk))
         {}
         else
         {
			 echo "<script>alert('操作错误!');history.go(-1);</script>";
	         exit();
	     }
		 //mysql_close();
		 
	$sql="select * from users where loginname='".$rowhk['userid']."'";
    $query=$db->query($sql);
	$rowuser=$db->fetch_array($query);
	if(is_array($rowuser))
         {}
         else
	{
		echo "<script>alert('会员不存在!');history.go(-1);</script>";
	    exit();
	}

    $bdsql="Update users set amount=amount+".$rowhk["amount"]." where id =".$rowuser['id']." ";
$db->query($bdsql);
shouzhi($db,$rowuser['loginname'],"管理员取消提现",$rowhk["amount"],"管理员取消提现");

//$db->query("insert into czlog (who,ip,types,beizhu,addtime) values ('".$_COOKIE["adminname"]."','".$_SERVER["REMOTE_ADDR"]."','取消提现','会员名称:".$rowhk['userid']."','".date("Y-m-d H:i:s")."')");

    $sql='delete from getamount WHERE id='.$_GET["id"].'';
    $db->query($sql);
	


echo "<script>alert('设置成功,现在返回!');window.location.href='?page=".$_GET['page']."';</script>";
exit();


}


if($_GET['act']=="sp")
{
	$sql="select * from getamount where id='".$_GET["id"]."' and states=0 ";
		 $query=$db->query($sql);
		 $rowhk=$db->fetch_array($query);
		 if(is_array($rowhk))
         {}
         else
         {
			 echo "<script>alert('操作错误!');history.go(-1);</script>";
	         exit();
	     }
		 //mysql_close();
		 
	$sql="select * from users where loginname='".$rowhk['userid']."'";
    $query=$db->query($sql);
	$rowuser=$db->fetch_array($query);
	if(is_array($rowuser))
         {}
         else
	{
		echo "<script>alert('会员不存在!');history.go(-1);</script>";
	    exit();
	}

    $sql='UPDATE getamount SET states=1 WHERE id='.$_GET["id"].'';
    $db->query($sql);
	//$db->query("insert into czlog (who,ip,types,beizhu,addtime) values ('".$_COOKIE["adminname"]."','".$_SERVER["REMOTE_ADDR"]."','设置提现成功','会员名称:".$rowhk['userid']."','".date("Y-m-d H:i:s")."')");


echo "<script>alert('设置成功,现在返回!');window.location.href='?page=".$_GET['page']."';</script>";
exit();


}



if($_POST['ArticleID']&&$_POST['Action']=="Del")
{

	$ids = implode(',', $_POST['ArticleID']);
	//////////
$sql12="select * from getamount where id in($ids) order by id asc ";
$query12=$db->query($sql12);
while($row12=$db->fetch_array($query12))
{
if($row12['states']==0)
{
	$sql="UPDATE getamount SET states=1 WHERE id='".$row12['id']."'";
    $db->query($sql);
    
}

}
/////////
//$db->query("insert into czlog (who,ip,types,beizhu,addtime) values ('".$_COOKIE["adminname"]."','".$_SERVER["REMOTE_ADDR"]."','设置提现成功','批量:".$ids."','".date("Y-m-d H:i:s")."')");

	echo "<script>alert('操作成功!');window.location.href='?page=".$_GET['page']."';</script>";
	exit;
}
?>
<LINK href="../Admin_STYLE.CSS" rel=stylesheet type=text/css>
<?php
if ($_GET['page']>1)
{
$riqi=$_GET['riqi'];
$riqi2=$_GET['riqi2'];
$myKeyword=$_GET['myKeyword'];
}
else
{
$riqi=$_POST['riqi'];
$riqi2=$_POST['riqi2'];
$myKeyword=$_POST['myKeyword'];
}
$zt=$_GET['zt'];
$myKeyword2=$_POST['myKeyword2'];
if($riqi)$sqladd.=" and adddate = '".trim($riqi)."' ";
if($riqi2)$sqladd.=" and change_time <= '".trim($riqi2)."' ";
if($myKeyword)$sqladd.=" and userid like '%".trim($myKeyword)."%' ";
if($zt<>'')$sqladd.=" and states = '".trim($zt)."' ";
$sqladd.=' ORDER BY id DESC';

$perNumber=20; //每页显示的记录数
$page=$_GET['page']; //获得当前的页面值
$count=$db->query("select count(*) from getamount where id>0 {$sqladd}"); //获得记录总数
$rs=$db->fetch_array($count); 
$totalNumber=$rs[0];
$totalPage=ceil($totalNumber/$perNumber); //计算出总页数
if (!isset($page)) {
 $page=1;
} //如果没有值,则赋值1
if(empty($page)) {$page=1;}
$startCount=($page-1)*$perNumber; //分页开始,根据此方法计算出开始的记录
$result=$db->query("select * from getamount where id>0 {$sqladd} limit $startCount,$perNumber"); //根据前面的计算出开始的记录和记录数
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
   if(confirm("确定要设置选中的记录吗？此操作将不能恢复！"))
     return true;
   else
     return false;
	 
}

</SCRIPT>
</head>

<body text="#000000" leftmargin="0" topmargin="0">
<div align="center"><br>

  提现申请管理
    (<a href="tixianmanage.php?zt=0">查看所有未处理</a> <a href="tixianmanage.php?zt=1">查看所有已经处理</a>)
    <table width="98%"  border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <form method="post" action="tixianmanage.php" name="form1">
      <td colspan="11" class="tdbg"><div align="right">  用户名
  <input type="text" name="myKeyword" size="16" value="<? echo $myKeyword?>">
  <input type="submit" name="Submit" value="搜索">
        </div>
        <div align="right"><span class="tdbg">
          </span>      </div>      </td>
    </form>
  </tr>
    </table>
</div>
<form name="del" method="Post" action="?page=<? echo $page?>" onSubmit="return ConfirmDel();">
<table width="98%" border="0" align="center" cellpadding="1" cellspacing="1" bordercolorlight=#145AA0 bordercolordark=#9CC7EF class='border'>

  <tr  class="title" align="center">
    <td width="3%" nowrap align="center" >选中全部&nbsp;</td>
    <td width="7%" nowrap ><div align="center">会员编号</div></td>
    <td width="6%" nowrap><div align="center">姓名</div></td>
    <td width="10%" nowrap align="center">银行</td>
    <td width="10%" nowrap><div align="center">银行帐号</div></td>
    <td width="10%" nowrap align="center">提现金额</td>
    <td width="12%" nowrap>手续费</td>
    <td width="12%" nowrap>实发</td>
    <td width="12%" nowrap><div align="center" class="style1"> 时间</div></td>
    <td width="22%" height="24" nowrap> <div align="center" class="style1"> 处理状态</div></td>
  </tr>
<?php
while ($row=$db->fetch_array($result)) 
{
?>
  <tr bgcolor="#FFFFFF" class="tdbg" align="center">
    <td align="center"><input name='ArticleID[]' type='checkbox' onClick="unselectall()" id="ArticleID[]" value='<? echo $row['id']?>'></td>
    <td><div align="center"><? echo $row['userid']?></div></td>
    <td><div align="center"><? echo $row['bankuser']?></div></td>
    <td align="center"><? echo $row['bank']?></td>
    <td><div align="center"><? echo $row['bankno']?></div></td>
    <td align="center"><? echo $row['amount']?></td>
    <td><? echo $row['get_amount']?></td>
    <td><? echo $row['amount']-$row['get_amount']?></td>
    <td><div align="center"><? echo $row['addtimes']?></div></td>
    <td height="20"><div align="center"><? if($row['states']=="1") {echo '处理成功';} else if($row['states']=="8") {echo '自动处理';} else {echo '未处理';} ?> <? if($row['states']=="0") {?><a onClick="javascript:return confirm(&#39;确定已经打款吗？&#39;);" href="?act=sp&id=<? echo $row['id']?>&page=<? echo $page?>">已经打款</a>&nbsp;&nbsp;<a onClick="javascript:return confirm(&#39;确定取消本次提现吗？&#39;);" href="?act=qx&id=<? echo $row['id']?>&page=<? echo $page?>">取消提现</a><? }?></div></td>
  </tr>
<?
}
?>
  <tr bgcolor="#FFFFFF"> 
    <td colspan="10" class="tdbg" align="center"><?
getNavHtml($page,$perNumber,$totalNumber,'?zt='.$zt.'&myKeyword='.$myKeyword.'&');
?>&nbsp;&nbsp;<input class="p_input" type="text" name="custompage" onKeyDown="if(event.keyCode==13) {window.location='?orderby=&page='+this.value; return false;}">
<input class="p_input" type="button" name="button" id="button" value="跳转" onClick="window.location='?orderby=&page='+custompage.value;" /></td>
  </tr>
</table>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr> 
            <td width="250" height="30"><input name="chkAll" type="checkbox" id="chkAll" onclick=CheckAll(this.form) value="checkbox">
              选中本页显示的所有记录</td>
            <td><input name="submit" type='submit' value='将选中的记录设置为处理成功'>
              <input name="Action" type="hidden" id="Action" value="Del"></td>
          </tr>
</table></form>
</body>
</html>
