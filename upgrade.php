<?php
require_once("includes/conn.php");
require_once("checkuser.php");
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>申请升级 - 天天创客</title>
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
<?php
$newjibie=$rowuser["standardlevel"]+1;


//$manzu=1;
//if($newjibie>=3&&$newjibie<=6)
//{
////关联1
//         $sqluser11="select * from users where pid=".$_SESSION["uuserid"]." and area=1 and states=1 ";
//		 $queryuser11=$db->query($sqluser11);
//		 $rowuser11=$db->fetch_array($queryuser11);
//		 if(is_array($rowuser11))
//         {
//
//$sql="select standardlevel from users where (find_in_set('".$rowuser11['id']."', ppath) or id=".$rowuser11['id'].") and states=1 order by standardlevel desc limit 1 ";
//$query=$db->query($sql);
//$rowgg=$db->fetch_array($query);
//if(is_array($rowgg))
//{
//	$zuigao1=$rowgg['standardlevel'];
//}
//else
//{
//	$zuigao1=0;
//}
//
//		 }
////关联1
//
////关联2
//         $sqluser22="select * from users where pid=".$_SESSION["uuserid"]." and area=2 and states=1 ";
//		 $queryuser22=$db->query($sqluser22);
//		 $rowuser22=$db->fetch_array($queryuser22);
//		 if(is_array($rowuser22))
//         {
//
//$sql="select standardlevel from users where (find_in_set('".$rowuser22['id']."', ppath) or id=".$rowuser22['id'].") and states=1 order by standardlevel desc limit 1 ";
//$query=$db->query($sql);
//$rowgg=$db->fetch_array($query);
//if(is_array($rowgg))
//{
//	$zuigao2=$rowgg['standardlevel'];
//}
//else
//{
//	$zuigao2=0;
//}
//
//		 }
////关联2
//
////关联3
//         $sqluser33="select * from users where pid=".$_SESSION["uuserid"]." and area=3 and states=1 ";
//		 $queryuser33=$db->query($sqluser33);
//		 $rowuser33=$db->fetch_array($queryuser33);
//		 if(is_array($rowuser33))
//         {
//
//$sql="select standardlevel from users where (find_in_set('".$rowuser33['id']."', ppath) or id=".$rowuser33['id'].") and states=1 order by standardlevel desc limit 1 ";
//$query=$db->query($sql);
//$rowgg=$db->fetch_array($query);
//if(is_array($rowgg))
//{
//	$zuigao3=$rowgg['standardlevel'];
//}
//else
//{
//	$zuigao3=0;
//}
//
//		 }
////关联3
//
//
//if(($zuigao1<$rowuser['standardlevel']&&$zuigao2<$rowuser['standardlevel'])||($zuigao1<$rowuser['standardlevel']&&$zuigao3<$rowuser['standardlevel'])||($zuigao2<$rowuser['standardlevel']&&$zuigao3<$rowuser['standardlevel']))
//    {
//		$manzu=0;
//	}
//
//}

if($_POST['action']=="apply")
{

//	if($manzu==0)
//    {
//		echo "<script>alert('未满足要求，不可申请!');window.parent.location.href='upgrade.php';<11111/script>";
//	    exit();
//	}


	//$sql="select * from shengji where userid='".$rowuser['id']."' and jibie=".$newjibie." and jieuserid='".$_POST['upid']."' and types='".$_POST['types']."' limit 1";
	$sql="select * from shengji where userid='".$rowuser['id']."' and jibie=".$newjibie." and types='".$_POST['types']."' limit 1";
    $query=$db->query($sql);
	$row=$db->fetch_array($query);
	if(is_array($row))
    {
		echo "<script>alert('不要重复申请!');window.parent.location.href='upgrade.php';</script>";
	    exit();
	}

	$sql2="select * from users where id='".$_POST['upid']."' limit 1";
    $query2=$db->query($sql2);
	$rowuser2=$db->fetch_array($query2);
	if(empty($rowuser2['id']))
    {
		echo "<script>alert('相关好友不存在!');window.parent.location.href='upgrade.php';</script>";
	    exit();
	}


	$sql="insert into shengji (types,userid,jieuserid,jibie,adddate,addtime) values ('".$_POST['types']."','".$rowuser['id']."','".$_POST['upid']."','".$newjibie."','".date("Y-m-d")."','".date("Y-m-d H:i:s")."')";
    $db->query($sql);

echo "<script>alert('申请成功!');window.parent.location.href='upgrade.php';</script>";
exit();

}
?>
<div class="container">
<?php
require_once("top.php");
?>    <div class="udd-body">
    	    	<div class="panel">
          <div class="panel-body bg-white">
            <span class="text-yellow icon-bell-o" style="color:#ffae31; font-size:16px"> 升级由群主或或高级会员核实通过即可，天天创客不收取任何费用！</span>
          </div>
        </div>
        <br />
<?php
if($rowuser["standardlevel"]==0)
{
?>
        <div class="panel">
          <div class="panel-head"><strong>需要升级【<span class="text-yellow">一级会员</span>】请用微信加以下会员为好友：</strong></div>
          <div class="panel-body bg-white">
<?php
         $sqluser1="select * from users where id='".$rowuser["rid"]."' limit 1 ";
		 $queryuser1=$db->query($sqluser1);
		 $rowuser1=$db->fetch_array($queryuser1);
		 if(is_array($rowuser1))
         {
		 }
			 ?>
            <form method="post" class="form form-block" target="formprocess">
            <input type="hidden" value="apply" name="action" />
            <input type="hidden" value="<?php echo $rowuser1['id']?>" name="upid" />
            <input type="hidden" value="1" name="types" />
          	<table class="table table-bordered">
            	<tr class="blue">
                	<td width="30%" class="text-right">会员昵称</th>
                	<td class="text-left"><?php echo $rowuser1['nickname']?></th>
                </tr>
                <tr class="white">
                	<td class="text-right">微信号</th>
                	<td class="text-left"><?php echo $rowuser1['wechat']?></th>
                </tr>
                <tr class="blue">
                	<td class="text-right">手机号</th>
                	<td class="text-left"><?php echo $rowuser1['loginname']?></th>
                </tr>
                <tr class="white">
                	<td width="30%" class="text-right">会员级别</th>
                	<td class="text-left"><?php echo userjibiename($rowuser1['standardlevel'])?>&nbsp;&nbsp;<div class='level_icon tips'><div class='left'></div><div class='right'></div><span><?php echo $rowuser1['standardlevel']?></span></div><div class='icons'><img src='Static/images/levels/<?php echo $rowuser1['standardlevel']?>.png' /></div></th>
                </tr>
<?php
	$sql="select * from shengji where userid='".$rowuser['id']."' and jibie=".$newjibie." and types=1 limit 1";
    $query=$db->query($sql);
	$row=$db->fetch_array($query);
	if(is_array($row))
    {
		?>
                <tr class="blue">
                	<td class="text-center" colspan="2">

                                        <button class="button bg-yellow" style=" background-color:#060"><?php if($row['passed']==1){echo "已经通过";}else{echo "已提交，待升级";}?></button>
                                        </th>
                </tr>
    <?php
	}
	else
	{?>
    <tr class="blue">
                	<td class="text-center" colspan="2">

                                        <button class="button bg-yellow" onClick="javascript:return confirm(&#39;确认向该好友提出申请吗？&#39;);">申请升级</button>
                                        </th>
                </tr>
    <?php }?>
            </table>
            </form>
            <br />




<?php
	$sql="select * from shengji where userid='".$rowuser['id']."' and jibie=".$newjibie."  and types=2 limit 1";
    $query=$db->query($sql);
	$row=$db->fetch_array($query);
	if(is_array($row))
    {

    $sqluser22="select * from users where id =".$row['jieuserid']." limit 1";
    $queryuser22=$db->query($sqluser22);
	$rowuser22=$db->fetch_array($queryuser22);
	if(is_array($rowuser22))
    {

	}
?>
          	<table class="table table-bordered">
            	<tr class="blue">
                	<td width="30%" class="text-right">会员昵称</th>
                	<td class="text-left"><?php echo $rowuser22['nickname']?></th>
                </tr>
                <tr class="white">
                	<td class="text-right">微信号</th>
                	<td class="text-left"><?php echo $rowuser22['wechat']?></th>
                </tr>
                <tr class="blue">
                	<td class="text-right">手机号</th>
                	<td class="text-left"><?php echo $rowuser22['loginname']?></th>
                </tr>
                <tr class="white">
                	<td width="30%" class="text-right">会员级别</th>
                	<td class="text-left"><?php echo userjibiename($rowuser22['standardlevel'])?>&nbsp;&nbsp;<div class='level_icon tips'><div class='left'></div><div class='right'></div><span><?php echo $rowuser22['standardlevel']?></span></div><div class='icons'><img src='Static/images/levels/<?php echo $rowuser22['standardlevel']?>.png' /></div></th>
                </tr>

                <tr class="blue">
                	<td class="text-center" colspan="2">

                                        <button class="button bg-yellow" style=" background-color:#060"><?php if($row['passed']==1){echo "已经通过";}else{echo "已提交，待核实";}?></button>
                                        </th>
                </tr>

            </table>
<?php
	}
	else
	{
?>

<?php
	$sqluser2="select * from users where id in(".$rowuser1['ppath'].") and standardlevel>=5 order by ceng desc limit 1";
    $queryuser2=$db->query($sqluser2);
	$rowuser2=$db->fetch_array($queryuser2);
	if(is_array($rowuser2))
    {
		$jiekuanuser=$rowuser2['loginname'];
	}
?>
            <form method="post" class="form form-block" target="formprocess">
            <input type="hidden" value="apply" name="action" />
            <input type="hidden" value="<?php echo $rowuser2['id']?>" name="upid" />
            <input type="hidden" value="2" name="types" />
          	<table class="table table-bordered">
            	<tr class="blue">
                	<td width="30%" class="text-right">会员昵称</th>
                	<td class="text-left"><?php echo $rowuser2['nickname']?></th>
                </tr>
                <tr class="white">
                	<td class="text-right">微信号</th>
                	<td class="text-left"><?php echo $rowuser2['wechat']?></th>
                </tr>
                <tr class="blue">
                	<td class="text-right">手机号</th>
                	<td class="text-left"><?php echo $rowuser2['loginname']?></th>
                </tr>
                <tr class="white">
                	<td width="30%" class="text-right">会员级别</th>
                	<td class="text-left"><?php echo userjibiename($rowuser2['standardlevel'])?>&nbsp;&nbsp;<div class='level_icon tips'><div class='left'></div><div class='right'></div><span><?php echo $rowuser2['standardlevel']?></span></div><div class='icons'><img src='Static/images/levels/<?php echo $rowuser2['standardlevel']?>.png' /></div></th>
                </tr>
                <?php
	$sql="select * from shengji where userid='".$rowuser['id']."' and jibie=".$newjibie."  and types=2 limit 1";
    $query=$db->query($sql);
	$row=$db->fetch_array($query);
	if(is_array($row))
    {
		?>
                <tr class="blue">
                	<td class="text-center" colspan="2">

                                        <button class="button bg-yellow" style=" background-color:#060"><?php if($row['passed']==1){echo "已经通过";}else{echo "已提交，待核实";}?></button>
                                        </th>
                </tr>
    <?php
	}
	else
	{?>
                <tr class="blue">
                	<td class="text-center" colspan="2">

                                        <button class="button bg-yellow" onClick="javascript:return confirm(&#39;确认向该好友提出申请吗？&#39;);">申请核实</button>
                                        </th>
                </tr>
    <?php }?>
            </table>
            </form>
<?php }?>
            <br />
                      <iframe src="null.html" name="formprocess" style="display:none;"></iframe>
          </div>
        </div>
<?php }else{
//if($rowuser['standardlevel']==1){$nextstandardlevel=2;$nextjine=$rowset['jine2'];}
//if($rowuser['standardlevel']==2){$nextstandardlevel=3;$nextjine=$rowset['jine3'];}
//if($rowuser['standardlevel']==3){$nextstandardlevel=4;$nextjine=$rowset['jine4'];}
//if($rowuser['standardlevel']==4){$nextstandardlevel=5;$nextjine=$rowset['jine5'];}
//if($rowuser['standardlevel']==5){$nextstandardlevel=6;$nextjine=$rowset['jine6'];}

//2级以上

$sftijiaoshengji=1;

$newstandardlevel=$rowuser['standardlevel']+1;
	?>

        <div class="panel">
          <div class="panel-head"><strong>需要升级【<span class="text-yellow"><?php echo userjibiename($newstandardlevel)?></span>】请用微信加以下会员为好友：</strong></div>
          <div class="panel-body bg-white">


<?php
	$sql="select * from shengji where userid='".$rowuser['id']."' and jibie=".$newjibie." and types=1 limit 1";
    $query=$db->query($sql);
	$row=$db->fetch_array($query);
	if(is_array($row))
    {

	$sqluser2="select * from users where id =".$row['jieuserid']." limit 1";
    $queryuser2=$db->query($sqluser2);
	$rowuser2=$db->fetch_array($queryuser2);
	if(is_array($rowuser2))
    {

	}

	$sftijiaoshengji=1;
		?>


<table class="table table-bordered">
            	<tr class="blue">
                	<td width="30%" class="text-right">会员昵称</th>
                	<td class="text-left"><?php echo $rowuser2['nickname']?></th>
                </tr>
                <tr class="white">
                	<td class="text-right">微信号</th>
                	<td class="text-left"><?php echo $rowuser2['wechat']?></th>
                </tr>
                <tr class="blue">
                	<td class="text-right">手机号</th>
                	<td class="text-left"><?php echo $rowuser2['loginname']?></th>
                </tr>
                <tr class="white">
                	<td width="30%" class="text-right">会员级别</th>
                	<td class="text-left"><?php echo userjibiename($rowuser2['standardlevel'])?>&nbsp;&nbsp;<div class='level_icon tips'><div class='left'></div><div class='right'></div><span><?php echo $rowuser2['standardlevel']?></span></div><div class='icons'><img src='Static/images/levels/<?php echo $rowuser2['standardlevel']?>.png' /></div></th>
                </tr>

                <tr class="blue">
                	<td class="text-center" colspan="2">

                                        <button class="button bg-yellow" style=" background-color:#060"><?php if($row['passed']==1){echo "已经通过";}else{echo "已提交，待升级";}?></button>
                                        </th>
                </tr>


            </table>
<?php
	}
	else
	{?>

    <?php
	$sqluser2="select * from users where id in(".$rowuser['ppath'].") and ceng<=".($rowuser['ceng']-$newstandardlevel)." and standardlevel>=".$newstandardlevel." and id not in(select jieuserid from shengji where userid='".$rowuser['id']."' and types=1 and jibie>1) order by ceng desc";
    $queryuser2=$db->query($sqluser2);
	$rowuser2=$db->fetch_array($queryuser2);
	if(is_array($rowuser2))
    {
		$jiekuanuser=$rowuser2['loginname'];
	}
	else
	{
		echo "<script>alert('相关好友不存在!');window.parent.location.href='user.php';</script>";
	    exit();
	}
?>
            <form method="post" class="form form-block" target="formprocess">
            <input type="hidden" value="apply" name="action" />
            <input type="hidden" value="<?php echo $rowuser2['id']?>" name="upid" />
            <input type="hidden" value="1" name="types" />
          	<table class="table table-bordered">
            	<tr class="blue">
                	<td width="30%" class="text-right">会员昵称</th>
                	<td class="text-left"><?php echo $rowuser2['nickname']?></th>
                </tr>
                <tr class="white">
                	<td class="text-right">微信号</th>
                	<td class="text-left"><?php echo $rowuser2['wechat']?></th>
                </tr>
                <tr class="blue">
                	<td class="text-right">手机号</th>
                	<td class="text-left"><?php echo $rowuser2['loginname']?></th>
                </tr>
                <tr class="white">
                	<td width="30%" class="text-right">会员级别</th>
                	<td class="text-left"><?php echo userjibiename($rowuser2['standardlevel'])?>&nbsp;&nbsp;<div class='level_icon tips'><div class='left'></div><div class='right'></div><span><?php echo $rowuser2['standardlevel']?></span></div><div class='icons'><img src='Static/images/levels/<?php echo $rowuser2['standardlevel']?>.png' /></div></th>
                </tr>

                <tr class="blue">
                	<td class="text-center" colspan="2">

                                        <!--<?php if($manzu==0){?><button class="button bg-yellow" style=" background-color:#060">未满足要求，不可申请！</button><?php }else{?><button class="button bg-yellow" onClick="javascript:return confirm(&#39;确认向该好友提出申请吗？&#39;);">申请升级</button><?php }?>-->
                                        <button class="button bg-yellow" onClick="javascript:return confirm(&#39;确认向该好友提出申请吗？&#39;);">申请升级</button>
                                        </th>
                </tr>

            </table>
            </form>
<?php }?>


            <br />


<?php
if($sftijiaoshengji==1)
{

	$sql="select * from shengji where userid='".$rowuser['id']."' and jibie=".$newjibie." and types=2 limit 1";
    $query=$db->query($sql);
	$row=$db->fetch_array($query);
	if(is_array($row))
    {

	$sqluser22="select * from users where id =".$row['jieuserid']." limit 1";
    $queryuser22=$db->query($sqluser22);
	$rowuser22=$db->fetch_array($queryuser22);
	if(is_array($rowuser22))
    {

	}
		?>
<table class="table table-bordered">
            	<tr class="blue">
                	<td width="30%" class="text-right">会员昵称</th>
                	<td class="text-left"><?php echo $rowuser22['nickname']?></th>
                </tr>
                <tr class="white">
                	<td class="text-right">微信号</th>
                	<td class="text-left"><?php echo $rowuser22['wechat']?></th>
                </tr>
                <tr class="blue">
                	<td class="text-right">手机号</th>
                	<td class="text-left"><?php echo $rowuser22['loginname']?></th>
                </tr>
                <tr class="white">
                	<td width="30%" class="text-right">会员级别</th>
                	<td class="text-left"><?php echo userjibiename($rowuser22['standardlevel'])?>&nbsp;&nbsp;<div class='level_icon tips'><div class='left'></div><div class='right'></div><span><?php echo $rowuser22['standardlevel']?></span></div><div class='icons'><img src='Static/images/levels/<?php echo $rowuser22['standardlevel']?>.png' /></div></th>
                </tr>

                <tr class="blue">
                	<td class="text-center" colspan="2">

                                        <button class="button bg-yellow" style=" background-color:#060"><?php if($row['passed']==1){echo "已经通过";}else{echo "已提交，待核实";}?></button>
                                        </th>
                </tr>

            </table>
<?php
	}
	else
	{?>

<?php }
}?>
            <br />
                      <iframe src="null.html" name="formprocess" style="display:none;"></iframe>
          </div>
        </div>
<?php }?>


            </div>
	  <br />


<?php
require_once("foot.php");
?>
</div>
</body>
</html>
