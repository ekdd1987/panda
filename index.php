<?php
require_once("includes/conn.php");
@session_start(); 
if($_SESSION["uusername"]==""||$_SESSION["uuserid"]=="")
{
echo "<script>window.location.href='login.php';</script>";
exit();
}

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
          	            <span class="text-yellow icon-bell-o" style="color:#ffae31; font-size:16px"> HI【<?php echo $rowuser['nickname']?>】，欢迎使用天天创客交友社区！</span>
                      </div>
        </div>
        <br />
        <div class="panel">
         <p><a href="about.php"><img src="Static/images/banner.png" width="100%" /></a></p>
		</div>
        <br />
        <div class="panel">
             
          <div class="panel-head"><strong>我的信息</strong></div>
          <div class="panel-body bg-white">
          	<table class="table table-bordered">
            	
            	<tr class="white">
                	<td width="30%" class="text-right">我的微信</td>
                    <td><?php echo $rowuser['wechat']?></td>
                </tr>
                <tr class="blue">
                	<td class="text-right">我的级别</td>
                    <td><?php echo userjibiename($rowuser['standardlevel'])?>&nbsp;&nbsp;<div class='level_icon tips'><div class='left'></div><div class='right'></div><span><?php echo $rowuser['standardlevel']?></span></div><div class='icons'><img src='Static/images/levels/<?php echo $rowuser['standardlevel']?>.png' /></div></td>
                </tr>
<?php
$sql="select count(*) as alluu from users where rid= '".$rowuser['id']."' ";
$query=$db->query($sql);
$rowtj=$db->fetch_array($query);
$sql="select count(*) as alluu2 from users where pid= '".$rowuser['id']."' ";
$query=$db->query($sql);
$rownext=$db->fetch_array($query);
?>
                <tr class="white">
                	<td class="text-right">邀请总数</td>
                    <td><font color="#FF0000"><?php echo $rowtj['alluu']?>个</font></td>
                </tr>
                <tr class="white">
                	<td class="text-right">直接好友</td>
                    <td><font color="#FF0000"><?php echo $rownext['alluu2']?>个</font></td>
                </tr>
                
                                <tr class="white">
                	<td colspan="2" class="text-center"><?php if($rowuser['standardlevel']<9){?><button class="button bg-yellow" type="button" onclick="location.href='upgrade.php'">申请升级</button> <?php }?><button class="button" type="button" onclick="location.href='user.php'">会员中心</button></td>
                </tr>
                            </table>

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
