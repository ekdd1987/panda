<?php
include("../Admin.php");
include("../../includes/conn.php");

if($_GET['ArticleID']&&$_GET['Action']=="Del")
{
	$delsql="delete from neirong where ArticleID ='".$_GET['ArticleID']."' ";
	$db->query($delsql);
	echo "<script>alert('删除成功!');window.location.href='?types=".$_GET['types']."&page=".$_GET['page']."';</script>";
	exit;
}
if($_POST['ArticleID']&&$_GET['Action']=="Del")
{
	$ids = implode(',', $_POST['ArticleID']);
	$delsql="delete from neirong where ArticleID in($ids)";
	$db->query($delsql);
	echo "<script>alert('删除成功!');window.location.href='?types=".$_GET['types']."&page=".$_GET['page']."';</script>";
	exit;
}
?>
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

<script language="javascript">
    function updatediaoyong3(obj,value,leibie)
    {
        var opusCommend = document.getElementById("commend_" + obj).value;
        var xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
    		
url = "ajax.asp?act=updatediaoyong3&id=" + escape(obj) + "&opusCommend=" + escape(opusCommend)+"&leibie=" + escape(leibie);
	    xmlHttp.open("POST",url,false);
	    xmlHttp.send();
	    var res = unescape(xmlHttp.responseText);
	    if (res=="OK")
	    {
	        document.getElementById("commend_" + obj).value=value;
	        document.getElementById("commend_" + obj).style.border=0;
	    }
	    else
	    {
	        alert(res);
	        document.getElementById("commend_" + obj).value=document.getElementById("commend_" + obj).defaultValue;
	        document.getElementById("commend_" + obj).style.borderColor="red";
	    }
    }
	

</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<LINK href="../Admin_STYLE.CSS" rel=stylesheet type=text/css>
<?php
$Title=$_POST['Title'];
$types=$_GET['types'];
if($types)$sqladd.=" and types ='".trim($types)."' ";
if($Title)$sqladd.=" and title like '%".trim($Title)."%' ";
$sqladd.=' ORDER BY ArticleID DESC';

$perNumber=20; //每页显示的记录数
$page=$_GET['page']; //获得当前的页面值
$count=$db->query("select count(*) from neirong where 1=1 {$sqladd}"); //获得记录总数
$rs=$db->fetch_array($count); 
$totalNumber=$rs[0];
$totalPage=ceil($totalNumber/$perNumber); //计算出总页数
if (!isset($page)) {
 $page=1;
} //如果没有值,则赋值1
if(empty($page)) {$page=1;}

$startCount=($page-1)*$perNumber; //分页开始,根据此方法计算出开始的记录
$result=$db->query("select * from neirong where 1=1 {$sqladd} limit $startCount,$perNumber"); //根据前面的计算出开始的记录和记录数
?>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="862" align="center" valign="top">
	  <p><br>      
	      <strong>信息管理 (<a href="newsadd.php?types=<? echo $_GET['types']?>">添加</a>)</strong></p>
		  <form name="del" method="Post" action="?Action=Del&types=<? echo $_GET['types']?>&page=<? echo $page?>" onsubmit="return ConfirmDel();">
        <table width="720" border="0" cellpadding="0" cellspacing="2">
          <tr bgcolor="#CCCCCC" class="topbg"> 
            <td height="25"><a href="newsManage.asp">&nbsp;记录管理</a> 
              &gt;&gt; 

　</td>
            <td width="150">&nbsp;
            </td>
          </tr>
        </table>

        <table class="border" border="0" cellspacing="2" width="720" cellpadding="0" style="word-break:break-all">
          <tr  class="title"> 
            <td width="63" height="25" align="center"><strong>选中</strong></td>
            <td width="262" align="center"  ><strong>记录名称</strong></td>
            <td width="141" align="center" ><strong>加入时间</strong></td>
            <td width="133" align="center" ><strong>操作</strong></td>
          </tr>
<?php
while ($row=$db->fetch_array($result)) 
{
?>
          <tr class="tdbg"> 
            <td width="63" height="22" align="center"> <input name='ArticleID[]' type='checkbox' onclick="unselectall()" id="ArticleID[]" value='<? echo $row['ArticleID']?>'></td>
            <td>&nbsp;<a href="newsModify.php?ArticleID=<? echo $row['ArticleID']?>"><? echo $row['title']?></a></td>
            <td><? echo $row['UpdateTime']?></td>
            <td width="133" align="center"> 
              <a href="newsModify.php?ArticleID=<? echo $row['ArticleID']?>&types=<? echo $_GET['types']?>&page=<? echo $page?>">修改</a> 
              <a href="?ArticleID=<? echo $row['ArticleID']?>&Action=Del&types=<? echo $_GET['types']?>&page=<? echo $page?>" onClick="javascript:return confirm(&#39;确定删除吗？&#39;);">删除</a>            </td>
          </tr>
<?
}
?>
        </table>
        
        <table width="720" border="0" cellpadding="0" cellspacing="0">
          <tr> 
            <td width="250" height="30"><input name="chkAll" type="checkbox" id="chkAll" onclick=CheckAll(this.form) value="checkbox">
              选中本页显示的所有记录</td>
            <td><input name="submit" type='submit' value='删除选定的记录' > 
              <input name="Action" type="hidden" id="Action" value="Del"></td>
          </tr>
        </table>
<table width="720" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td height="30" align="center">
<?
getNavHtml($page,$perNumber,$totalNumber,'?');
?>&nbsp;&nbsp;<input class="p_input" type="text" name="custompage" onKeyDown="if(event.keyCode==13) {window.location='?page='+this.value; return false;}">
<input class="p_input" type="button" name="button" id="button" value="跳转" onclick="window.location='?page='+custompage.value;" /></td>
          </tr>
        </table>
      </form>
      <br> 
      <table width="720" border="0" cellpadding="0" cellspacing="0" class="border">
        <tr class="tdbg">
          <form name="searchsoft" method="post" action="newsManage.php?types=<? echo $_GET['types']?>">
            <td height="30"> <strong>查找记录：</strong> 
              <input name="Title" type="text" class=smallInput id="Title3" size="20" maxlength="50" value="<? echo $Title?>"> 
              <input name="Query" type="submit" id="Query" value="查 询">
              &nbsp;&nbsp;请输入记录名称。如果为空，则查找所有记录。</td>
          </form>
        </tr>
    </table></td>
  </tr>
</table>
