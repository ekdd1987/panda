<?php
require_once("includes/conn.php");
require_once("checkuser.php");
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>修改资料 - 中国最大的移动交友社区</title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta name="mobileoptimized" content="0" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
<meta http-equiv="Expires" content="-1">
<meta http-equiv="pragram" content="no-cache">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="format-detection" content="telephone=no">
<meta name="browsermode" content="application">

<link rel="stylesheet" href="Static/css/pintuer.css?d=20150710">
<link rel="stylesheet" href="Static/css/style.css?d=20150710">
<script type="text/javascript" src="Static/js/jquery.min.js"></script>
<script type="text/javascript" src="Static/js/pintuer.js?d=20150710"></script>
<script type="text/javascript" src="Static/js/respond.js"></script></head>

<body>
<?
if($_POST['action']=="edit")
{

if($_POST['username']!=$rowuser["loginname"])
{
		 $sqluser77="select loginname from users where loginname='".trim($_POST["username"])."' ";
		 $queryuser77=$db->query($sqluser77);
		 $rowuser77=$db->fetch_array($queryuser77);
		 if(is_array($rowuser77))
         {
			 echo "<script>alert('手机号已经存在!');history.go(-1);</script>";
	         exit();
		 }
}

$pwd1=md5($_POST['oldpassword']);
if($pwd1!=$rowuser["pwd1"])
{
echo "<script>alert('原密码错误!');window.parent.location.href='editinfo.php';</script>";
exit();
}

if($_POST['password']!="")
{
        $sql='UPDATE users SET pwd1="'.md5($_POST['password']).'" WHERE id="'.$_SESSION["uuserid"].'" ';
		$db->query($sql);
}
		

		$sql='UPDATE users SET loginname="'.trim($_POST['username']).'",nickname="'.trim($_POST['nickname']).'",wechat="'.$_POST['wechat'].'" WHERE id="'.$_SESSION["uuserid"].'" ';
		$db->query($sql);

		echo "<script>alert('修改成功!');window.parent.location.href='user.php';</script>";
	    exit();
}
?>
<div class="container">
<?php
require_once("top.php");
?>    <div class="udd-body">
        <div class="panel">
          <div class="panel-head"><strong>修改个人资料</strong></div>
          <div class="panel-body bg-white">
          
            <form method="post" class="form form-block" target="formprocess">
            <input type="hidden" value="edit" name="action" />
              <div class="form-group">
              	<div class="label"><label for="username">登录手机号</label></div>
                <div class="field">
                  <input type="text" class="input" id="username" name="username" value="<?php echo $rowuser['loginname']?>"  data-validate="required:手机号码必填,mobile:手机号码必须填写" size="30" placeholder="请填写您的手机号码" />
                </div>
              </div>
              <div class="form-group">
              	<div class="label"><label for="nickname">昵称</label></div>
                <div class="field">
                  <input type="text" class="input" id="nickname" name="nickname" value="<?php echo $rowuser['nickname']?>"  data-validate="required:昵称必须填写" size="30" placeholder="请填写您的昵称" />
                </div>
              </div>
              <div class="form-group">
              	<div class="label"><label for="wechat">微信号</label></div>
                <div class="field">
                  <input type="text" class="input" id="wechat" name="wechat" value="<?php echo $rowuser['wechat']?>" size="30" data-validate="required:微信号码必须填写" placeholder="请输入您的微信号码" />
                </div>
              </div>
              <div class="form-group">
              <div class="label text-red"><label for="repassword">原密码</label></div>
                <div class="field">
                  <input type="password" class="input" id="oldpassword" name="oldpassword" data-validate="required:原密码为必填项,length#>=6:密码至少为6位以上" size="30" placeholder="请输入原密码" />
                </div>
              </div>
              <div class="form-group">
              	<div class="label"><label for="password">新密码</label></div>
                <div class="field">
                  <input type="password" class="input" id="password" name="password" size="30" data-validate="required:密码为必填项,length#>=6:密码至少为6位以上" placeholder="不改请留空" />
                </div>
              </div>
              <div class="form-group">
              <div class="label"><label for="repassword">确认新密码</label></div>
                <div class="field">
                  <input type="password" class="input" id="repassword" name="repassword" size="30" placeholder="不改请留空" data-validate="required:该项为必填项,repeat#password:两次输入的密码不一致" />
                </div>
              </div>
              
              <div class="form-button"><button class="button bg-yellow" type="submit">保存修改</button> <button type="button" class="button" onclick="history.go(-1)">返回</button></div>
            </form>
            <iframe src="null.html" name="formprocess" style="display:none;"></iframe>
          
          </div>
          
        </div>
        
    </div>
	  <br />


<?php
require_once("foot.php");
?>
</div>
</body>
</html>
