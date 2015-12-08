<?php
require_once("includes/conn.php");
?>
<?
function verificationCode($leng) {
//$arr   = array_merge(range(0, 9), range('a', 'z'), range('A', 'Z'));
$arr   = array_merge(range(0, 9), range('a', 'z'));
shuffle($arr);
$str = implode('', array_slice($arr, 0, $leng));
return $str;
} 


//echo $suijima."<br>";

//function getRandomString($len, $chars=null)
//{
//    if (is_null($chars)){
//        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
//    } 
//    mt_srand(10000000*(double)microtime());
//    for ($i = 0, $str = '', $lc = strlen($chars)-1; $i < $len; $i++){
//        $str .= $chars[mt_rand(0, $lc)]; 
//    }
//    return $str;
//}
//
//$suijima=getRandomString(8);
//echo $suijima;exit;

if($_POST["action"]=="reg")
{
	
$suijima=verificationCode(10);
	
if($_POST["username"]==""||$_POST["wechat"]==""||$suijima==""){exit();}

//if($_POST["ic"]!="")
//{
	     $sqluser="select * from users where suijima='".$_POST["ic"]."' and states=1  ";
		 $queryuser=$db->query($sqluser);
		 $rowuser=$db->fetch_array($queryuser);
		 if(is_array($rowuser))
         {
			 $rid=$rowuser['id'];
			 $dai=$rowuser['dai']+1;
		     $rpath=$rowuser['rpath'].",".$rowuser['id'];}
         else
         {
			 echo "<script>alert('推荐人不存在!');history.go(-1);</script>";
	         exit();
	     }
//}
//else
//{
//	         $rid=9753;
//			 $dai=3;
//		     $rpath="0,1,9753";
//}

		 $sqls="select loginname from users where suijima='".trim($suijima)."' ";
		 $querys=$db->query($sqls);
		 $rows=$db->fetch_array($querys);
		 if(is_array($rows))
         {
			 echo "<script>alert('已经存在，请重新注册!');history.go(-1);</script>";
	         exit();
		 }

		 
		 $sqluser="select loginname from users where loginname='".trim($_POST["username"])."' ";
		 $queryuser=$db->query($sqluser);
		 $rowuser=$db->fetch_array($queryuser);
		 if(is_array($rowuser))
         {
			 echo "<script>alert('手机号已经存在!');history.go(-1);</script>";
	         exit();
		 }
		 
		 
		 
		 $sqluser="select loginname from users where wechat='".trim($_POST["wechat"])."' ";
		 $queryuser=$db->query($sqluser);
		 $rowuser=$db->fetch_array($queryuser);
		 if(is_array($rowuser))
         {
			 echo "<script>alert('微信号已经存在!');history.go(-1);</script>";
	         exit();
		 }
		 
		 $sqluser="select loginname from users where nickname='".trim($_POST["nickname"])."' ";
		 $queryuser=$db->query($sqluser);
		 $rowuser=$db->fetch_array($queryuser);
		 if(is_array($rowuser))
         {
			 echo "<script>alert('昵称已经存在!');history.go(-1);</script>";
	         exit();
		 }
		 
	$sql="insert into users (loginname,rid,pwd1,dai,rpath,nickname,wechat,suijima,adddate,addtime) values ('".trim($_POST['username'])."','".trim($rid)."','".md5($_POST['password'])."','".$dai."','".$rpath."','".$_POST['nickname']."','".$_POST['wechat']."','".$suijima."','".date('Y-m-d')."','".date("Y-m-d H:i:s")."')";
		$db->query($sql);
		$newID = mysql_insert_id();

$onlinetime=date("Y-m-d H:i:s");
$bdsql="Update users set logincishu=logincishu+1,onlinetime='".$onlinetime."' where id ='".$newID."' ";
$db->query($bdsql);
$sql="insert into loginrecode (userid,ip,adddate,addtime) values ('".$_POST['username']."','".$_SERVER["REMOTE_ADDR"]."','".date('Y-m-d')."','".date("Y-m-d H:i:s")."')";
$db->query($sql);
	
	@session_start(); 	
    $_SESSION['uusername']=trim($_POST['username']);
    $_SESSION['uuserid']=$newID;
	$_SESSION['pass2']="";
	$_SESSION['pass3']="";
	$_SESSION['onlinetime']=$onlinetime;
	
		echo "<script>alert('恭喜，注册成功，快去申请认证吧!');window.parent.location.href='index.php';</script>";
	    exit();

}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>加入天天创客 - 移动交友社区</title>
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
?>

<?php
if($_SESSION["uusername"]==""||$_SESSION["uuserid"]=="")
{
?>

    <div class="udd-body">
                <div class="panel">
          <div class="panel-body bg-white">
            <span class="text-yellow icon-bell-o"> 移动交友社区，永久免费！</span>
          </div>
        </div>
        <br />
        <div class="panel">
          <div class="panel-head"><strong style="color:#F00">加入天天创客，祝您快乐天天！</strong></div>
          <div class="panel-body bg-white">
          
            <form method="post"  class="form form-block" target="formprocess">
            <input type="hidden" value="reg" name="action" />
            <input type="hidden" value="<?php echo $_GET['ic']?>" name="ic" />
<?php
if($_GET['ic']!="")
{
$sqluser11="select * from users where suijima='".$_GET['ic']."' ";
$queryuser11=$db->query($sqluser11);
$rowuser11=$db->fetch_array($queryuser11);
if(is_array($rowuser11))
{
?>
            <div class="form-group">
              	<div class="label"><label for="username">邀请人</label></div>
                <div class="field">
                  昵称：<?php echo $rowuser11['nickname']?><br />
                  微信：<?php echo $rowuser11['wechat']?>
                </div>
              </div>

<?php
 }
 }?>
              <div class="form-group">
              	<div class="label"><label for="username">登录手机号</label></div>
                <div class="field">
                  <input type="text" class="input" id="username" name="username"  data-validate="required:手机号码必填,mobile:手机号码必须填写" size="30" placeholder="请填写您的手机号码" />
                </div>
              </div>
              <div class="form-group">
              	<div class="label"><label for="wechat">微信号</label></div>
                <div class="field">
                  <input type="text" class="input" id="wechat" name="wechat" size="30" data-validate="required:微信号码必须填写" placeholder="请输入您的微信号码" />
                </div>
              </div>
              <div class="form-group">
              	<div class="label"><label for="nickname">昵称</label></div>
                <div class="field">
                  <input type="text" class="input" id="nickname" name="nickname" size="30" data-validate="required:昵称必须填写" placeholder="请输入您的昵称" />
                </div>
              </div>
              <div class="form-group">
              	<div class="label"><label for="password">登录密码</label></div>
                <div class="field">
                  <input type="password" class="input" id="password" name="password" data-validate="required:密码为必填项,length#>=6:密码至少为6位以上" size="30" placeholder="请输入密码" />
                </div>
              </div>
              <div class="form-group">
              <div class="label"><label for="repassword">确认密码</label></div>
                <div class="field">
                  <input type="password" class="input" id="repassword" name="repassword" data-validate="required:该项为必填项,repeat#password:两次输入的密码不一致" size="30" placeholder="请再次输入密码" />
                </div>
              </div>
              <div class="form-button"><button class="button bg-yellow" type="submit">提交注册</button> <button type="button" class="button" onclick="history.go(-1)">返回</button></div>
            </form>
            <iframe src="null.html" name="formprocess" style="display:none;"></iframe>
          
          </div>
          
        </div>
                
    </div>
<?php }else{
	
	     $sqluser="select * from users where id=".$_SESSION["uuserid"]." ";
		 $queryuser=$db->query($sqluser);
		 $rowuser=$db->fetch_array($queryuser);
		 if(is_array($rowuser))
         {
if($rowuser['lockuser']==1)
{
	echo "<script>alert('账户处于冻结状态!');window.location.href='login.php';</script>";
	exit();
}
         }
         else
         {
			 echo "<script>alert('会员不存在!');window.location.href='login.php';</script>";
	         exit();
	     }
		 
		 ?>

        <div class="udd-body">
         
        <div class="panel">
          <div class="panel-body bg-white">
            <span class="text-yellow icon-bell-o" style="color:#ffae31; font-size:16px"> 将此页截图发给好友或直接分享页面给好友即可！</span>
          </div>
        </div>
        <br />
        <div class="panel">
            <div class="panel-body bg-white">
            	<div class="mycard">
                    <div class="qrcode"><img class="qrimg" src="qrcode.php?ct=http://<?php echo $_SERVER['SERVER_NAME']?>:<?php echo $_SERVER["SERVER_PORT"]?>/reg.php?ic=<? echo $rowuser['suijima']?>" /><img src="Static/images/logo_s1.png" class="qrlogo" /></div>
                    <p>你的好友【<font class="text-red"><? echo $rowuser['nickname']?></font>】，诚挚邀请您加入</p>
                    <p>天天创客移动交友社区</p>
                    <p>请长按此图进行二维码识别</p>
				</div>
            </div>
        </div>
        <br />
        <div class="panel">
        	<div class="panel-head"><strong>我的专属邀请链接</strong></div>
            <div class="panel-body bg-white">
            	<textarea class="input">http://<?php echo $_SERVER['SERVER_NAME']?>:<?php echo $_SERVER["SERVER_PORT"]?>/reg.php?ic=<? echo $rowuser['suijima']?></textarea>
            </div>
        </div>
                
    </div>
	  <br />


<?php
require_once("foot.php");
?>
</div>
<?php }?>
</body>
</html>
