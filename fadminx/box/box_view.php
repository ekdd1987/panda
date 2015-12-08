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
	     $sql11="select * from message where id='".$_GET["id"]."' limit 1";
		 $query11=$db->query($sql11);
		 $row11=$db->fetch_array($query11);
		 if(is_array($row11))
         {
if($row11['recuid']=="admin")
{
$asql="Update message set states=1 where id =".$row11['id']." ";
$db->query($asql);
} 
		 }
		 else
		 {
			 echo "<script>alert('记录不存在!');history.go(-1);</script>";
	         exit();
		 }
		 
if($_POST['Action']=="Modify")
{
         if($_POST["txttitle"]==""||$_POST["txtcontent"]=="")
        {echo "<script>alert('请填写完整!');history.go(-1);</script>";exit();}
		 
		$sql="insert into message (types,senduid,recuid,title,content,addtime) values (2,'admin','".$_POST['txtuser']."','".$_POST['txttitle']."','".$_POST['txtcontent']."','".date("Y-m-d H:i:s")."')";
		$db->query($sql);
		echo "<script>alert('回复成功!');window.location.href='Outbox.php';</script>";
	    exit();
}
?>
<div id="toubu"><span class="tbbiaoti"><strong>阅读邮件</strong></span></div>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="border">

  <tr class="tdbg" >

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

  <tr class="tdbg" >

    <td>&nbsp;</td>

    <td height="150">

<table width="99%" border="0" align="center" cellpadding="3" cellspacing="0" class="tablebg2">
  <tr >
    <td width="150" height="50" align="right" class="tit1">发件人：</td>
    <td>
      <? echo $row11['senduid']?></td>
  </tr>
  <tr >
    <td height="50" align="right" class="tit1">收件人：</td>
    <td><? echo $row11['recuid']?></td>
  </tr>
  <tr >
    <td height="50" align="right" class="tit1">发送时间：</td>
    <td><? echo $row11['addtime']?></td>
  </tr>
  <tr >
    <td width="150" height="50" align="right" class="tit1">标题：</td>
    <td>
      <? echo $row11['title']?></td>
  </tr>
  <tr >
    <td height="50" align="right" class="tit1">内容：</td>
    <td><? echo $row11['content']?></td>
  </tr>
  <? if($row11['recuid']=="admin"){?>
  <script language="javascript">
	
    function fmCheck()
    {
        with(document.fmOrder)
        {         
			if (txtcontent.value=="") {alert("内容不能为空！");txtcontent.focus();txtcontent.style.border="1px solid #888888";return false;}
            
        }
    }


</script>
<form name="fmOrder" action="?act=save&id=<? echo $row11['id']?>" method="post" onSubmit="return fmCheck();">
<input name="Action" type="hidden" id="Action" value="Modify" />
<input name="txtuser" type="hidden" id="txtuser" value="<? echo $row11['senduid']?>" />
<input name="txttitle" type="hidden" id="txttitle" value="回复：<? echo $row11['title']?>" />
  <tr >
    <td height="50" align="right" class="tit1"><strong>邮件回覆</strong></td>
    <td>&nbsp;</td>
  </tr>
  <tr >
    <td width="150" height="50" align="right" class="tit1">回覆内容：</td>
    <td><textarea name="txtcontent" cols="50" rows="6" class="float_left" id="txtcontent"></textarea></td>
  </tr>

   <tr>
     
     <td height="25" >&nbsp;</td>
     
     <td align="left">
       <input name="Submit2" type="submit" class="btn2" value="发送" />
       <input name="Submit22" type="reset" class="btn2" value="取消" />
       <font color='red'></font></td>
   </tr>
   </form>
<? }?>
</table>

<br>

    <td>&nbsp;</td>

  </tr>

  <tr class="tdbg" >

    <td></td>

    <td height="16" align="center">[<a href="#" onClick="javascript:history.go(-1)">返回</a>]</td>

    <td></td>

  </tr>

</table>
		
</body>
</html>
