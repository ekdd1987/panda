<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login</title>
</head>

<body>
<?php
include ("includes/conn.php");

$sqlclose="select * from config_close where id=1";
$queryclose=$db->query($sqlclose);
$rowclose=$db->fetch_array($queryclose);
if($rowclose['close1']==0){echo $rowclose['txt1'];exit();}


@session_start();
if($_POST['username']&&$_POST['password'])
{
	

$user=$_POST['username'];
$pwd=$_POST['password'];

  $sql='SELECT * FROM users where loginname="'.$user.'" and pwd1="'.md5($pwd).'" limit 1';
  $query=$db->query($sql);
  if($row=$db->fetch_array($query))
  { 
  
  if($row['lockuser']==1)
{
	
	echo "<script>alert('账户处于冻结状态!');window.location.href='./';</script>";
	exit();
}

$onlinetime=date("Y-m-d H:i:s");
$bdsql="Update users set logincishu=logincishu+1,onlinetime='".$onlinetime."' where id ='".$row['id']."' ";
$db->query($bdsql);
$sql="insert into loginrecode (userid,ip,adddate,addtime) values ('".$row['loginname']."','".$_SERVER["REMOTE_ADDR"]."','".date('Y-m-d')."','".date("Y-m-d H:i:s")."')";
$db->query($sql);




  	@session_start(); 	
    $_SESSION['uusername']=$row['loginname'];
    $_SESSION['uuserid']=$row['id'];
	$_SESSION['pass2']="";
	$_SESSION['pass3']="";
	$_SESSION['onlinetime']=$onlinetime;
	$_SESSION['cs']=date("Y-m-d H:i:s");
    echo "<script>window.parent.location.href='user.php';</script>";
	exit();
  }
  else
  {
  	echo "<script>alert('登陆失败,请检查用户名和密码是否正确!');window.location.href='login.php';</script>";
	exit();
  	
  }
  
  }
  

?></body>
</html>