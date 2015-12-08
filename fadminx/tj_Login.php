<html>
<head>
<title>管理员登录</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="Admin_Style.css">
<script language=javascript>
<!--
function SetFocus()
{
if (document.Login.UserName.value=="")
	document.Login.UserName.focus();
else
	document.Login.UserName.select();
}
function CheckForm()
{
	if(document.Login.UserName.value=="")
	{
		alert("请输入用户名！");
		document.Login.UserName.focus();
		return false;
	}
	if(document.Login.Password.value == "")
	{
		alert("请输入密码！");
		document.Login.Password.focus();
		return false;
	}
	if (document.Login.CheckCode.value==""){
       alert ("请输入您的验证码！");
       document.Login.CheckCode.focus();
       return(false);
    }
}


//-->
</script>
</head>
<body>
<?php
include("../includes/conn.php");
@session_start();
if($_POST['UserName']&&$_POST['Password']&&$_GET['act']=="login")
{

if($_POST['CheckCode']!=$_SESSION["sessionRound"])
{
	
	echo "<script>alert('验证码错误!');history.go(-1);</script>";
	exit();
}
$user=$_POST['UserName'];
$pwd=$_POST['Password'];

	$sql='SELECT * FROM adhgfqws65ljdlgr where username="'.$user.'" and password="'.md5($pwd).'" limit 1';
  $query=$db->query($sql);
  if($row=$db->fetch_array($query))
  { 
  	//@session_start(); 	
    //$_SESSION['usename']=$row['usename'];
    //$_SESSION['pwd']=$row['pwd'];
	setcookie("adminid", $row['ID'],time()+36000);
	setcookie("Purview", $row['Purview'],time()+36000);
	setcookie("adminname", $user,time()+36000);
    echo "<script>window.location.href='Admin_Index.html';</script>";
	exit();
  }
  else
  {
  	echo "<script>alert('登陆失败!');history.go(-1);</script>";
	exit();
  	
  }
  
  }
  

?>
<p>&nbsp;</p>
<p>&nbsp;</p>
<form name="Login" action="?act=login" method="post" target="_parent" onSubmit="return CheckForm();">
  <table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td colspan="2"><img src="Images/Admin_Login1.gif" width="600" height="126"></td>
    </tr>
    <tr>
      <td width="508" valign="top" background="Images/Admin_Login2.gif"><table width="508" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td height="37" colspan="7">&nbsp;</td>
        </tr>
        <tr>
          <td width="75" rowspan="2">&nbsp;</td>
          <td width="126"><font color="#043BC9">用户名称：</font></td>
          <td width="39" rowspan="2">&nbsp;</td>
          <td width="131"><font color="#043BC9">用户密码：</font></td>
          <td width="33">&nbsp;</td>
          <td colspan="2"><font color="#043BC9">验证码：</font></td>
          </tr>
        <tr>
          <td><input name="UserName"  type="text"  id="UserName" maxlength="20" style="width:110px; BORDER-RIGHT: #F7F7F7 0px solid; BORDER-TOP: #F7F7F7 0px solid; FONT-SIZE: 9pt; BORDER-LEFT: #F7F7F7 0px solid; BORDER-BOTTOM: #c0c0c0 1px solid; HEIGHT: 16px; BACKGROUND-COLOR: #F7F7F7" onMouseOver="this.style.background='#ffffff';" onMouseOut="this.style.background='#F7F7F7'" onFocus="this.select(); "></td>
          <td><input name="Password"  type="password" maxlength="20" style="width:110px; BORDER-RIGHT: #F7F7F7 0px solid; BORDER-TOP: #F7F7F7 0px solid; FONT-SIZE: 9pt; BORDER-LEFT: #F7F7F7 0px solid; BORDER-BOTTOM: #c0c0c0 1px solid; HEIGHT: 16px; BACKGROUND-COLOR: #F7F7F7" onMouseOver="this.style.background='#ffffff';" onMouseOut="this.style.background='#F7F7F7'" onFocus="this.select(); "></td>
          <td>&nbsp;</td>
          <td width="53"><input name="CheckCode" size="6" maxlength="4" style="width:50px; BORDER-RIGHT: #F7F7F7 0px solid; BORDER-TOP: #F7F7F7 0px solid; FONT-SIZE: 9pt; BORDER-LEFT: #F7F7F7 0px solid; BORDER-BOTTOM: #c0c0c0 1px solid; HEIGHT: 16px; BACKGROUND-COLOR: #F7F7F7" onMouseOver="this.style.background='#ffffff';" onMouseOut="this.style.background='#F7F7F7'" onFocus="this.select(); "></td>
          <td width="51"><img src="../checkcode.php?" onClick="this.src+=Math.random()"></td>
        </tr>
      </table></td>
      <td><input type='hidden' name='Action' value='Login'>
        <input type="image" name="Submit" src="Images/Admin_Login3.gif" style="width:92px; HEIGHT: 126px;"></td>
    </tr>
  </table>
  </form>

</body>
</html>

