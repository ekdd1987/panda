
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>天天创客</title>
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
<div class="container">
<?php
require_once("top.php");
?>    <div class="udd-body">
    	<div class="panel">
          <div class="panel-body bg-white">
          	            <span class="text-yellow icon-bell-o" style="color:#ffae31; font-size:16px"> 欢迎加入天天创客交友社区！</span>
                      </div>
        </div>
        <br />
        <div class="panel">
         <p><a href="/about.php"><img src="Static/images/banner.png" width="100%" /></a></p>
		</div>
        <br />
        <div class="panel">
                    <div class="panel-head"><strong>用户登录</strong></div>
          <div class="panel-body bg-white">
            <form method="post" action="login_ac.php" class="form form-block" target="formprocess">
              <input type="hidden" value="login" name="action" />
              <div class="form-group">
                <div class="field field-icon">
                  <span class="icon icon-user"></span>
                  <input type="text" class="input" id="username" name="username" data-validate="required:用户名不能为空" size="30" placeholder="请输入手机号码" />
                  
                </div>
              </div>
              <div class="form-group">
                <div class="field field-icon">
                  <span class="icon icon-key"></span>
                  <input type="password" class="input" id="password" name="password" data-validate="required:密码为必填项" size="30" placeholder="请输入密码" />
                  
                </div>
              </div>
              
              <div class="form-button"><button class="button bg-yellow" type="submit">登录</button>&nbsp;&nbsp;&nbsp;&nbsp;<a href="reg.php" class="text-blue">还没注册？</a></div>
            </form>
            <iframe src="null.html" name="formprocess" style="display:none;"></iframe>
          
          </div>
                  </div>
        
	</div>
<?php
require_once("foot.php");
?>
</div>	
</body>
</html>
