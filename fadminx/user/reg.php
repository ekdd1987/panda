<?php
include("../Admin.php");
include("../../includes/conn.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<META http-equiv=X-UA-Compatible content=IE=EmulateIE7>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="Account/images/style.css" rel="stylesheet" type="text/css" />
<title>会员注册</title>
<SCRIPT type=text/javascript src="js/jquery.min.js"></SCRIPT>
</head>

<body>
<?
if($_GET["act"]=="save")
{
if($_POST["txt_rid"]==""||$_POST["txt_loginname"]==""){exit();}

		 
	     $sqluser="select * from users where loginname='".$_POST["txt_rid"]."' and states=1  ";
		 $queryuser=$db->query($sqluser);
		 $rowuser=$db->fetch_array($queryuser);
		 if(is_array($rowuser))
         {$dai=$rowuser['dai']+1;
		 $rpath=$rowuser['rpath'].",".$rowuser['id'];}
         else
         {
			 echo "<script>alert('推荐人不存在!');history.go(-1);</script>";
	         exit();
	     }


		 
		 $sqluser="select loginname from users where loginname='".strtolower(trim($_POST["txt_loginname"]))."' ";
		 $queryuser=$db->query($sqluser);
		 $rowuser=$db->fetch_array($queryuser);
		 if(is_array($rowuser))
         {
			 echo "<script>alert('用户名已经存在!');history.go(-1);</script>";
	         exit();
		 }
		 
		 $sqluser3="select loginname from users where tel='".trim($_POST["txt_tel"])."' ";
		 $queryuser3=$db->query($sqluser3);
		 $rowuser3=$db->fetch_array($queryuser3);
		 if(is_array($rowuser3))
         {
			 echo "<script>alert('一个手机号码只能注册一个用户!');history.go(-1);</script>";
	         exit();
		 }
		 
	$sql="insert into users (loginname,rid,pwd1,pwd2,dai,rpath,bank,bankaddress,bankno,bankname,qq,tel,identityid,question,answer,adddate,addtime,qunfaview) values ('".strtolower(trim($_POST['txt_loginname']))."','".strtolower(trim($_POST["txt_rid"]))."','".md5($_POST['txt_pwd1'])."','".md5($_POST['txt_pwd2'])."','".$dai."','".$rpath."','".$_POST['txt_bank']."','".$_POST['txt_bankaddress']."','".$_POST['txt_bankno']."','".$_POST['txt_bankname']."','".$_POST['txt_qq']."','".$_POST['txt_tel']."','".$_POST['txt_identityid']."','".$_POST['dropQuestion1']."','".$_POST['txtAnswer1']."','".date('Y-m-d')."','".date("Y-m-d H:i:s")."','0')";
		$db->query($sql);
		$newID = mysql_insert_id();


//找出滑落点位
$sql12="select * from users where shunxu>0 and nextusernum<2 order by shunxu asc ";
$query12=$db->query($sql12);
while($row12=$db->fetch_array($query12))
{
	
$sql="select count(*) as alluu from users where pid= '".$row12['loginname']."' ";
$query=$db->query($sql);
$rowallbao=$db->fetch_array($query);
if ($rowallbao['alluu']==0)
{
$hualuopid=$row12['loginname'];
$hualuoarea=1;
$ceng=$row12['ceng']+1;
$ppath=$row12['ppath'].",".$row12['id'];
$shunxu=$row12['shunxu']*2;
break;
}
else if ($rowallbao['alluu']==1)
{
$hualuopid=$row12['loginname'];
$hualuoarea=2;
$ceng=$row12['ceng']+1;
$ppath=$row12['ppath'].",".$row12['id'];
$shunxu=($row12['shunxu']*2)+1;
break;
}

}
//找出滑落点位

    $sql='UPDATE users SET states=1,standardlevel="'.$_POST["txt_level"].'",jihuodate="'.date("Y-m-d").'",jihuotime="'.date("Y-m-d H:i:s").'",shunxu="'.$shunxu.'",pid="'.$hualuopid.'",area="'.$hualuoarea.'",ceng="'.$ceng.'",ppath="'.$ppath.'" WHERE id='.$newID.'';
    $db->query($sql);
	$sql='UPDATE users SET nextusernum=nextusernum+1 WHERE loginname="'.$hualuopid.'" ';
    $db->query($sql);
	
	$sql='UPDATE users SET tjnum=tjnum+1 WHERE loginname="'.trim($_POST["txt_rid"]).'" ';
    $db->query($sql);

//先写入
$str=$hualuoarea;
$sql12="select * from users where id in(".$ppath.")  order by ceng desc ";
$query12=mysql_query($sql12);
while($row12=mysql_fetch_array($query12))
{
if ($str==1) 
{
	$asql12="Update users set num1=num1+1 where id =".$row12['id']." ";
    mysql_query($asql12);
}
if ($str==2) 
{
	$asql12="Update users set num2=num2+1 where id =".$row12['id']." ";
    mysql_query($asql12);
}

$str=$row12['area'];
}
//先写入


		echo "<script>alert('注册成功!');window.location.href='reg.php';</script>";
	    exit();

}
?>



<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" class="WhiteBack AllWrap" style="font-size:14px; margin-top:30px">
  <tr>
    <td width="792" align="center" valign="top"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="z_r_cont">
        <tr>
          <td align="center" >&nbsp;</td>
        </tr>
        
        
        <tr>
          <td>
  <script language="javascript">
function f(n){return document.getElementById(n);}
     function fmCheckUserName(str,thisvalue,txt1,txt2)
    {
		if (thisvalue==""||thisvalue.length<4||thisvalue.length>14) {alert("编号输入错误！");return false;}
        htmlobj=$.ajax({url:"ajax.php?do=CheckUserName&username=" + escape(thisvalue),async:false});
		if (escape(htmlobj.responseText)=="0"){f(str).innerHTML=txt1;return false;}
		if (escape(htmlobj.responseText)!="0"){f(str).innerHTML=htmlobj.responseText;return false;}
    }
	
    function fmCheck()
    {
        with(document.fmOrder)
        {         
		    if (txt_loginname.value==""||txt_loginname.value.length<4||txt_loginname.value.length>20) {alert("会员编号输入错误！");txt_loginname.focus();txt_loginname.style.border="1px solid #888888";return false;}
			if (txt_pwd1.value=="") {alert("请输入密码！");txt_pwd1.focus();txt_pwd1.style.border="1px solid #888888";return false;}
			if (txt_pwd12.value=="") {alert("请输入确认密码！");txt_pwd12.focus();txt_pwd12.style.border="1px solid #888888";return false;}
			if (txt_pwd1.value!=txt_pwd12.value) {alert("两次输入的密码不相符！");txt_pwd1.value="";txt_pwd12.value="";txt_pwd1.focus();txt_pwd1.style.border="1px solid #888888";txt_pwd12.style.border="1px solid #888888";return false;}
			if (txt_pwd2.value=="") {alert("请输入二级密码！");txt_pwd2.focus();txt_pwd2.style.border="1px solid #888888";return false;}
			if (txt_pwd22.value=="") {alert("请输入二级确认密码！");txt_pwd22.focus();txt_pwd22.style.border="1px solid #888888";return false;}
			if (txt_pwd2.value!=txt_pwd22.value) {alert("两次输入的二级密码不相符！");txt_pwd2.value="";txt_pwd22.value="";txt_pwd2.focus();txt_pwd2.style.border="1px solid #888888";txt_pwd22.style.border="1px solid #888888";return false;}
			if (txtAnswer1.value=="") {alert("问题答案不能为空！");txtAnswer1.focus();txtAnswer1.style.border="1px solid #888888";return false;}
			if (txt_rid.value=="") {alert("推荐人不能为空！");txt_rid.focus();txt_rid.style.border="1px solid #888888";return false;}
			if (txt_qq.value=="") {alert("请输入qq！");txt_qq.focus();txt_qq.style.border="1px solid #888888";return false;}
			if (txt_tel.value=="") {alert("请输入手机号码！");txt_tel.focus();txt_tel.style.border="1px solid #888888";return false;}
			if (txt_bankname.value=="") {alert("请输入开户姓名！");txt_bankname.focus();txt_bankname.style.border="1px solid #888888";return false;}
            if (txt_bankno.value=="") {alert("请输入银行卡号！");txt_bankno.focus();txt_bankno.style.border="1px solid #888888";return false;}
			if (txt_bankaddress.value=="") {alert("请输入银行开户地址！");txt_bankaddress.focus();txt_bankaddress.style.border="1px solid #888888";return false;}
            
        }
    }


</script>
            <form name="fmOrder" action="?act=save" method="post"  onSubmit="return fmCheck();">
              <table width="99%" border="0" align="center" cellpadding="3" cellspacing="0" class="tablebg2">
                <tr >
                  <td wIDth="170" height="30" align="right" ><span style="font-weight: bold">会员编号：</span></td>
                  <td wIDth="808" align="left">
                    <input name="txt_loginname" type="text" id="txt_loginname" size="30"  >
                  <span class="red">* </span></td>
                </tr>
                <tr >
                  <td wIDth="170" height="30" align="right" valign="middle" class="formtd_left"><span style="font-weight: bold">一级密码：</span></td>
                  <td wIDth="808" align="left"> 
                    
                    <input name="txt_pwd1" type="password" class="en_cpa" ID="txt_pwd1" value="1" size="30" maxlength="20">
                  <span class="red">*</span></td>
                </tr>
                <tr >
                  <td wIDth="170" height="30" align="right" valign="middle" class="formtd_left"><span style="font-weight: bold">密码确认：</span></td>
                  <td wIDth="808" align="left"> 
                    
                    <input name="txt_pwd12" type="password" class="en_cpa" id="txt_pwd12" value="1" size="30" maxlength="20" />
                  <span class="red">*</span></td>
                </tr>
                <tr >
                  <td wIDth="170" height="30" align="right" valign="middle" class="formtd_left"><span style="font-weight: bold">二级密码：</span></td>
                  <td wIDth="808" align="left"> 
                    
                    <input name="txt_pwd2" type="password" class="en_cpa" ID="txt_pwd2" value="2" size="30" maxlength="20">
                  <span class="red">*</span></td>
                </tr>
                <tr >
                  <td wIDth="170" height="30" align="right" valign="middle" class="formtd_left"><span style="font-weight: bold">密码确认：</span></td>
                  <td wIDth="808" align="left">            
                    <input name="txt_pwd22" type="password" class="en_cpa" id="txt_pwd22" value="2" size="30" maxlength="20" />
                  <span class="red">*</span></td>
                </tr>
                    <tr style="display: ">
            <td wIDth="170" height="30" align="right" class="formtd_left"><span style="font-weight: bold">密保问题：</span></td>
            <td wIDth="808" align="left">
              
                <select name="dropQuestion1" id="dropQuestion1">
		<option value="" >------请选择密保问题</option>
		<option value="您母亲的姓名是">您母亲的姓名是？</option>
        <option value="您配偶的生日是">您配偶的生日是？</option>
        <option value="您母亲的生日是">您母亲的生日是？</option>
        <option value="您父亲的姓名是">您父亲的姓名是？</option>
        <option value="您最喜欢的歌曲是">您最喜欢的歌曲是？</option>
        <option value="您最喜欢的电影是">您最喜欢的电影是？</option>
        <option value="您的幸运数字是">您的幸运数字是？</option>
        <option value="对您影响最大的人名字是">对您影响最大的人名字是？</option>
	</select>
                <span class="red">*</span></td>
          </tr>

<tr >
            <td wIDth="170" height="30" align="right" valign="middle" class="formtd_left"><span style="font-weight: bold">密保答案：</span></td>
            <td wIDth="808" align="left">            
              <input name="txtAnswer1" type="text" class="operl" id="txtAnswer1" size="30" maxlength="20" />
                  <span class="red">*必填，用于找回密码</span></td>
          </tr>
                
                <tr >
                  <td wIDth="170" height="30" align="right" class="formtd_left"><span style="font-weight: bold">推荐编号：</span></td>
                  <td wIDth="808" align="left"><input name="txt_rid" type="text" class="en_cpa" ID="txt_rid" value="<? echo $_GET["u"]?>" size="30"  maxlength="11">
                    <span class="red">* </span><span id="txt_rid_msg"></span>
                  </td>
                </tr>
                <tr  style="display: ">
                  <td wIDth="170" height="30" align="right" class="formtd_left"><span style="font-weight: bold">常用QQ：</span></td>
                  <td wIDth="808" align="left">
                    <input name="txt_qq" type="text" class="en_cpa" ID="txt_qq" value="1" size="30" maxlength="20">
                  &nbsp;&nbsp;</td>
                </tr>
                <tr  style="display: ">
                  <td wIDth="170" height="30" align="right" class="formtd_left"><span style="font-weight: bold">身份证：</span></td>
                  <td wIDth="808" align="left">
                    <input name="txt_identityid" type="text" class="en_cpa" ID="txt_identityid" value="1" size="30">
  &nbsp;</td>
                </tr>
                <tr  style="display: ">
                  <td wIDth="170" height="30" align="right" class="formtd_left"><span style="font-weight: bold">手机号码：</span></td>
                  <td wIDth="808" align="left">
                    <input name="txt_tel" type="text" class="en_cpa" ID="txt_tel" value="1" size="30">
  &nbsp;</td>
                </tr>
                
                
                <tr style="display: ">
                  <td wIDth="170" height="30" align="right" class="formtd_left"><span style="font-weight: bold">银行类别：</span></td>
                  <td wIDth="808" align="left">
                    
                    <select name="txt_bank"  class="ma_cpb"  ID="txt_bank"  >
                      <option value="" >--请选择类别--</option>
                      <option value="微信" selected>微信</option>
                      <option value="支付宝" selected>支付宝</option>
                      <option value="财付通" selected>财付通</option>
                      
                      <option value="中国农业银行" selected>中国农业银行</option>
                      
                      <option value="中国工商银行" selected>中国工商银行</option>
                      
                      <option value="中国建设银行" selected>中国建设银行</option>
                      
                      
                    </select>
                  <span class="red">*</span></td>
                </tr>
                <tr  ID="ShopTr" style="display:">
                  <td wIDth="170" height="30" align="right" class="formtd_left"><span style="font-weight: bold">银行姓名：</span></td>
                  <td wIDth="808" align="left"><input name="txt_bankname" type="text" class="en_cpa" id="txt_bankname" value="1" size="30" maxlength="100" />              <span class="red">*</span></td>
                </tr>
                <tr  style="display: ">
                  <td wIDth="170" height="30" align="right" class="formtd_left"><span style="font-weight: bold" >银行卡号：</span></td>
                  <td wIDth="808" align="left"><input name="txt_bankno" type="text" class="en_cpa" ID="txt_bankno" value="1" size="30">
                  <span class="red">*</span></td>
                </tr>
                <tr  style="display: ">
                  <td wIDth="170" height="30" align="right" class="formtd_left"><span style="font-weight: bold" >开户地址：</span></td>
                  <td wIDth="808" align="left"><input name="txt_bankaddress" type="text" class="en_cpa" ID="txt_bankaddress" value="1" size="30">
                  <span class="red">*</span></td>
                </tr>
                 <tr  style="display: ">
                  <td wIDth="170" height="30" align="right" class="formtd_left"><span style="font-weight: bold" >会员级别：</span></td>
                  <td wIDth="808" align="left"><select name="txt_level" id="txt_level">
                    <option value="1">1级</option>
                    <option value="2">2级</option>
                    <option value="3">3级</option>
                    <option value="4">4级</option>
                    <option value="5">5级</option>
                    <option value="6">6级</option>
                  </select>                    
                   <span class="red">*</span></td>
                </tr>
                
                <tr align="center" valign="bottom" >
                  <td colspan="2">
                    <input name="checkXY" type="checkbox" ID="checkXY" value="Y" checked="checked"  style="display:none " />
                    <input name="Submit2" type="submit" class="btn2"  value="提交">
                  <br></td>
                  
                </tr>
                
              </table>
              <table width="100%" height="100"  border="0" cellpadding="0" cellspacing="0" id="TableCount" style="display:none ">
                <tr>
                  <td align="center">会员正在注册中，请稍等</td>
                </tr>
              </table>
              
          </form></td>
        </tr> 
        <tr>
          <td align="center">&nbsp;</td>
        </tr>
        
    </table></td>
  </tr>
</table>


</body>
</html>
