<?php
require_once("includes/conn.php");
require_once("checkuser.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>会员中心 - 天天创客</title>
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
if($_POST['action']=="resetpwd")
{

		$sql='UPDATE users SET pwd1="'.md5("123456").'" WHERE id="'.$_POST["id"].'" and rid="'.$rowuser['id'].'" ';
		mysql_query($sql);
		echo "<script>alert('重置成功，密码为123456，请及时通知用户自行更改!');window.parent.location.href='user.php';</script>";
	    exit();
}
?>
<div class="container">
<?php
require_once("top.php");
?>   <div class="udd-body">
    	<div class="panel">
          <div class="panel-body bg-white">
            <span class="text-yellow icon-bell-o" style="color:#ffae31; font-size:16px"> 
                        您目前是【<?php echo userjibiename($rowuser['standardlevel'])?>】<?php if($rowuser['standardlevel']<9){?>，如需升级请点击“申请升级”按钮，升级后您将会结交更多朋友。<?php }?>
                        </span>
          </div>
        </div>
        <br />
        <div class="panel"> 
          <div class="panel-head"><strong>会员资料</strong></div>
          <div class="panel-body bg-white">
          	<table class="table table-bordered">
            	<tr class="blue">
                	<td width="30%" class="text-right">我的昵称</td>
                    <td><?php echo $rowuser['nickname']?></td>
                </tr>
            	<tr class="white">
                	<td width="30%" class="text-right">我的微信</td>
                    <td><?php echo $rowuser['wechat']?></td>
                </tr>
                <tr class="blue">
                	<td width="30%" class="text-right">我的手机</td>
                    <td><?php echo $rowuser['loginname']?></td>
                </tr>
                <tr class="white">
                	<td class="text-right">我的级别</td>
                    <td><div class='level_icon tips'><div class='left'></div><div class='right'></div><span><?php echo $rowuser['standardlevel']?></span></div><div class='icons'><img src='Static/images/levels/<?php echo $rowuser['standardlevel']?>.png' /></div>&nbsp;&nbsp;<?php echo userjibiename($rowuser['standardlevel'])?></td>
                </tr>

            </table>
            <br />
			<div class="text-center"><?php if($rowuser['standardlevel']<9){?><button class="button bg-yellow" type="button" onclick="location.href='upgrade.php'">申请升级</button>&nbsp;&nbsp;<?php }?><button class="button" type="button" onclick="location.href='editinfo.php'">修改资料</button></div>
          </div>
          
        </div>
        <br />
        <div class="panel">
          <div class="panel-head"><strong>好友状况</strong></div>
          <div class="panel-body bg-white">
          	<table class="table table-bordered">
<?php
$sql="select count(*) as alluu from users where rid= '".$rowuser['id']."' ";
$query=$db->query($sql);
$rowtj=$db->fetch_array($query);
$sql="select count(*) as alluu2 from users where pid= '".$rowuser['id']."' ";
$query=$db->query($sql);
$rownext=$db->fetch_array($query);

$sql="select count(distinct userid) as alluu3 from shengji where jieuserid= '".$rowuser['id']."' and passed=1  ";
$query=$db->query($sql);
$row3=$db->fetch_array($query);

$sql="select count(0) as usernum from users where find_in_set('".$rowuser['id']."', ppath) and states=1 ";
$query=$db->query($sql);
$rowallbao=$db->fetch_array($query);

$zuigao1=0;
$zuigao2=0;
$zuigao3=0;
//关联1
         $sqluser11="select * from users where pid=".$_SESSION["uuserid"]." and area=1 and states=1 ";
		 $queryuser11=$db->query($sqluser11);
		 $rowuser11=$db->fetch_array($queryuser11);
		 if(is_array($rowuser11))
         {


$sql="select standardlevel from users where (find_in_set('".$rowuser11['id']."', ppath) or id=".$rowuser11['id'].") and states=1 order by standardlevel desc limit 1 ";
$query=$db->query($sql);
$rowgg=$db->fetch_array($query);
if(is_array($rowgg))
{
	$zuigao1=$rowgg['standardlevel'];
}
else
{
	$zuigao1=0;
}

		 }
//关联1

//关联2
         $sqluser22="select * from users where pid=".$_SESSION["uuserid"]." and area=2 and states=1 ";
		 $queryuser22=$db->query($sqluser22);
		 $rowuser22=$db->fetch_array($queryuser22);
		 if(is_array($rowuser22))
         {

$sql="select standardlevel from users where (find_in_set('".$rowuser22['id']."', ppath) or id=".$rowuser22['id'].") and states=1 order by standardlevel desc limit 1 ";
$query=$db->query($sql);
$rowgg=$db->fetch_array($query);
if(is_array($rowgg))
{
	$zuigao2=$rowgg['standardlevel'];
}
else
{
	$zuigao2=0;
}

		 }
//关联2

//关联3
         $sqluser33="select * from users where pid=".$_SESSION["uuserid"]." and area=3 and states=1 ";
		 $queryuser33=$db->query($sqluser33);
		 $rowuser33=$db->fetch_array($queryuser33);
		 if(is_array($rowuser33))
         {

$sql="select standardlevel from users where (find_in_set('".$rowuser33['id']."', ppath) or id=".$rowuser33['id'].") and states=1 order by standardlevel desc limit 1 ";
$query=$db->query($sql);
$rowgg=$db->fetch_array($query);
if(is_array($rowgg))
{
	$zuigao3=$rowgg['standardlevel'];
}
else
{
	$zuigao3=0;
}

		 }
//关联3
?>
                <tr class="white">
                	<td class="text-right">邀请好友</td>
                    <td><font color="#FF0000"><?php echo $rowtj['alluu']?>个</font></td>
                </tr>
                <tr class="white">
                	<td class="text-right">直接好友</td>
                    <td><font color="#FF0000"><?php echo $rownext['alluu2']?>个</font></td>
                </tr>
                <tr class="white"> 
                	<td width="30%"  class="text-right">已加好友</td>
                    <td><font color="#FF0000"><?php echo $row3['alluu3']?>个</font></td>
                </tr>
                <tr class="white">
                	<td width="30%"  class="text-right">关联好友</td>
                    <td><font color="#FF0000"><?php echo $rowallbao['usernum']?>个</font>&nbsp;&nbsp;<br />
<span class="text-blue">（最高<?php echo $zuigao1?>星）</span>&nbsp;&nbsp;<br />
<span class="text-blue" style="color:#C6F">（最高<?php echo $zuigao2?>星）</span>&nbsp;&nbsp;<br />
<span class="text-blue" style="color:#063">（最高<?php echo $zuigao3?>星）</span></td>
                </tr>

            </table>
            <br />
            <div class="text-center"><button class="button bg-yellow" type="button" onclick="location.href='reg.php?ic=<?php echo $rowuser['suijima']?>'">我要邀请好友</button></div>
          </div>
        </div>
        <br />
        <div class="panel">
          <div class="panel-head"><strong>邀请的好友</strong></div>
          <div class="panel-body bg-white">
          	<table class="table table-bordered">
                <tr class="blue">
                	<th class="text-center">会员</th>
                	<th width="45%" class="text-center">微信/手机</th>
                    <th width="80" class="text-center">操作</th>
                    
                </tr>
<? 
$sql="select * from users where rid='".$rowuser['id']."' order by id desc";
$query=$db->query($sql);
while($row=$db->fetch_array($query))
{
?>     
                
                <tr class="white">
                	<td class=" text-gray" style="padding:0px"><?php echo $row['nickname']?><br /><font class="text-yellow">(<?php echo userjibiename($row['standardlevel'])?>)</font></td>
                    <td class=" text-gray" style="padding:0px"><font class="text-yellow"><?php echo $row['wechat']?></font><br /><font class="text-blue"><?php echo $row['loginname']?></font></td>
                    <td class=" text-gray" style="padding:0px">
                    	<form method="post" class="form form-block" target="formprocess">
                        <input type="hidden" value="resetpwd" name="action" />
                    	<input type="hidden" value="<?php echo $row['id']?>" name="id" />
                    	<button type="submit" class="button button-small button-reset"  >重置密码</button>
                        </form>
                    </td>
                    
                </tr>
               
<?php }?>               
               
                            </table>
            
          </div>
        </div>
        <br />
        <div class="panel">
          <div class="panel-head"><strong>直接好友</strong></div>
          <div class="panel-body bg-white">
          	<table class="table table-bordered">
                <tr class="blue">
                	<th class="text-center">会员</th>
                	<th width="30%" class="text-center">微信号</th>
                    <th width="40%" class="text-center">手机号</th>
                    
                </tr>
<? 
$sql="select * from users where pid='".$rowuser['id']."' order by id desc";
$query=$db->query($sql);
while($row=$db->fetch_array($query))
{
?>  
                                <tr class="white">
                	<td class="" style="padding:0px"><?php echo $row['nickname']?><br /><font class="text-yellow"><?php echo userjibiename($row['standardlevel'])?></font><? if($row['pid']!=$row['rid']){?><br /><span class="tag bg-yellow">自动</span><? }?></td>
                    <td class="" style="padding:0px" align="center"><font class="text-yellow"><?php echo $row['wechat']?></font></td>
                    <td class="" style="padding:0px"><font class="text-blue"><?php echo $row['loginname']?></font></td>
                    
                </tr>
<?php }?>  

                            </table>
            
          </div>
        </div>
    </div>
    <iframe src="null.html" name="formprocess" style="display:none;"></iframe>
	  <br />


  <?php
require_once("foot.php");
?>
</div>
<script>
$('.button-reset').click(function(){
	return confirm('确定要重置该会员的密码吗？');	
});
</script>
</body>
</html>
