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
if($_POST['Action']=="Modify")
{
         if($_POST["txttitle"]==""||$_POST["txtcontent"]=="")
        {echo "<script>alert('请填写完整!');history.go(-1);</script>";exit();}

if($_POST["qunfa"]==0)
{
    $ridsql="select loginname from users where loginname='".$_POST['txtuser']."' limit 1";
    $ridquery=$db->query($ridsql);
	$ridrow=$db->fetch_array($ridquery);
	if ($ridrow['loginname']!=$_POST['txtuser']) 
	{
		echo "<script>alert('收件人不存在!');history.go(-1);</script>";
	    exit();
	}
}

$touser=$_POST['txtuser'];
if($_POST['qunfa']==1){$touser="群发";}
	
		$sql="insert into message (qunfa,types,senduid,recuid,title,content,addtime) values ('".$_POST['qunfa']."',2,'admin','".$touser."','".$_POST['txttitle']."','".$_POST['txtcontent']."','".date("Y-m-d H:i:s")."')";
		$db->query($sql);
		echo "<script>alert('发送成功!');window.location.href='Outbox.php';</script>";
	    exit(); 
}
?>
<div id="toubu"><span class="tbbiaoti"><strong>写邮件</strong></span></div>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="border">

  <tr class="tdbg">

    <td width="15"></td>

    <td><div align="left">

      <table width="30%" height="22"  border="0" cellpadding="0" cellspacing="0">

        <tr>

          <td width="14%" height="25"><div align="center"></div></td>

          <td width="86%" height="25" valign="bottom" style="font-size:12px">&nbsp;</td>

        </tr>

      </table>

    </div></td>

    <td width="15"></td>

  </tr>

  <tr class="tdbg">

    <td>&nbsp;</td>

    <td height="150">
<script language="javascript">
	
    function fmCheck()
    {
        with(document.fmOrder)
        {         
            //if (txtuser.value=="") {alert("收件人不能为空！");txtuser.focus();txtuser.style.border="1px solid #888888";return false;}
			if (txttitle.value=="") {alert("标题不能为空！");txttitle.focus();txttitle.style.border="1px solid #888888";return false;}
			if (txtcontent.value=="") {alert("内容不能为空！");txtcontent.focus();txtcontent.style.border="1px solid #888888";return false;}
            
        }
    }


</script>
<form name="fmOrder" action="?act=save" method="post" onSubmit="return fmCheck();">
<input name="Action" type="hidden" id="Action" value="Modify" />
<table width="99%" border="0" align="center" cellpadding="3" cellspacing="0" class="tablebg2">
  <tr >
    <td height="50" align="right" class="tit1">发送类型：</td>
    <td><input name="qunfa" type="radio" id="radio" value="0" checked="CHECKED">
      <label for="qunfa">单一</label><input type="radio" name="qunfa" id="radio" value="1">
      <label for="qunfa">群发</label></td>
  </tr>
  <tr >
    <td width="150" height="50" align="right" class="tit1">收件人：</td>
    <td>
      <input name="txtuser" type="text" class="float_left" id="txtuser" size="50" /></td>
  </tr>
  <tr >
    <td width="150" height="50" align="right" class="tit1">标题：</td>
    <td>
      <input name="txttitle" type="text" class="float_left" id="txttitle" size="50" /></td>
  </tr>
  <tr >
    <td width="150" height="50" align="right" class="tit1">内容：</td>
    <td><textarea name="txtcontent" cols="50" rows="6" class="float_left" id="txtcontent"></textarea></td>
  </tr>

   <tr>
     
     <td height="25" >&nbsp;</td>
     
     <td align="left">
       <input name="Submit2" type="submit" class="btn2" value="发送" />
       <input name="Submit22" type="reset" class="btn2" value="取消" />
       <font color='red'></font></td>
   </tr>
</table>
</form>
    <td>&nbsp;</td>

  </tr>


</table>
		
</body>
</html>
