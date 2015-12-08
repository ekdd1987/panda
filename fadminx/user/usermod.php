<?php
include("../Admin.php");
include("../../includes/conn.php");
?>
<LINK href="../Admin_STYLE.CSS" rel=stylesheet type=text/css>
<?
$ID=$_GET['id'];
		 $sql="select * from users where id='".$ID."'";
		 $query=$db->query($sql);
		 $row=$db->fetch_array($query);
		 if(is_array($row))
         {
			 }
         else
         {
			 echo "<script>alert('会员不存在!');history.go(-1);</script>";
	exit();
	}
?>

<?
if($_POST['Action']=="Modify")
{
	
if($_POST['pwd1']=="")
{$pwd1=$row['pwd1'];}
else
{$pwd1=md5($_POST['pwd1']);}

if($_POST['pwd2']=="")
{$pwd2=$row['pwd2'];}
else
{$pwd2=md5($_POST['pwd2']);}









		$sql='UPDATE users SET pwd1="'.$pwd1.'",lockuser="'.$_POST['lockuser'].'",standardlevel="'.$_POST['level'].'",suijima="'.$_POST['suijima'].'" WHERE id="'.$_POST['userid'].'" ';
		$db->query($sql);
		
		
		echo "<script>alert('修改成功!');window.location.href='usermanage.php?page=".$_GET['page']."';</script>";
	    exit();
}
		?>



<html>
<head>
<title>会员管理</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="images/css1.css" type="text/css">
</head>

<body text="#000000" leftmargin="0" topmargin="0">
              <FORM name="Form1" action="usermod.php?id=<? echo $row['id']?>&page=<? echo $_GET['page']?>" method="post">
	            <p>&nbsp;</p>
	            <p>&nbsp;</p>
	            <table width=80% height="271" border=0 align="center" cellpadding=0 cellspacing=1 bgcolor="#CCCCCC" class='border'>
    <TR align=center bgcolor="#FFFFFF" class='title'> 
      <TD height=20 colSpan=2><font class=en><b>修改用户资料</b></font></TD>
    </TR>
    <TR bgcolor="#FFFFFF" class="tdbg" >
      <TD height="25" align="right"><strong>基本资料：</strong></TD>
      <TD>&nbsp;</TD>
    </TR>
    <TR bgcolor="#FFFFFF" class="tdbg" > 
      <TD width="211" height="25" align="right">编号：</TD>
      <TD width="1307"><? echo $row['loginname']?>
      <input name="userid" type="hidden" id="userid" value="<? echo $row['id']?>"></TD>
    </TR>
    <TR bgcolor="#FFFFFF" class="tdbg" >
      <TD height="25" align="right">随机码：</TD>
      <TD><INPUT 
                                name=suijima class=input_1 id=suijima  value="<? echo $row['suijima']?>" size="50" ></TD>
    </TR>
    <TR bgcolor="#FFFFFF" class="tdbg" >
      <TD height="25" align="right">级别：</TD>
      <TD><INPUT 
                                name=level class=input_1 id=level  value="<? echo $row['standardlevel']?>" size="50" ></TD>
    </TR>
    <TR bgcolor="#FFFFFF" class="tdbg" >
      <TD height="25" align="right">推荐人：</TD>
      <TD><? echo $row['rid']?><INPUT name=oldrid class=input_1 id=oldrid  value="<? echo $row['rid']?>" type="hidden"></TD>
    </TR>
                  <TR bgcolor="#FFFFFF" class="tdbg" >
                    <TD height="25" align="right"><strong>密码：</strong></TD>
                    <TD>&nbsp;</TD>
                  </TR>
                  <TR bgcolor="#FFFFFF" class="tdbg" >
      <TD height="25" align="right">登陆密码：</TD>
      <TD><input name="pwd1" type="text" class="float_left" id="pwd1"/>
      *不修改请保持为空</TD>
    </TR>

        <tr height="25px" class="tdbg">
          <td height="25" align="right"><strong>状态：</strong></td>
          <td>&nbsp;</td>
        </tr>
        <tr height="25px" class="tdbg">
     
     <td width="211" height="25" align="right">锁定登录：</td>
     
     <td><input type="radio" name="lockuser" id="radio" value="0" <? if($row['lockuser']=="0") {echo 'checked';} else {echo '';} ?>>
       正常
       <input type="radio" name="lockuser" id="radio2" value="1"  <? if($row['lockuser']=="1") {echo 'checked';} else {echo '';} ?>>
      锁定</td></tr>
    <TR align="center" bgcolor="#FFFFFF" class="tdbg" > 
      <TD height="40" colspan="2"><input name="Action" type="hidden" id="Action" value="Modify"> 
        <input name=Submit   type=submit id="Submit" value=" 保 存 "> </TD>
    </TR>
  </TABLE>
              </form>
</body>
</html>