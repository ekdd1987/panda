<?php
@session_start(); 
if($_SESSION["uusername"]==""||$_SESSION["uuserid"]=="")
{

echo "<script>alert('请登录!');window.location.href='login.php';</script>";
exit();
  
}



$sqlclose="select * from config_close where id=1";
$queryclose=$db->query($sqlclose);
$rowclose=$db->fetch_array($queryclose);
if($rowclose['close1']==0){echo $rowclose['txt1'];exit();}


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
		 
if($rowuser['onlinetime']!=$_SESSION['onlinetime'])
{

echo "<script>alert('你的账号已经在其他地方登陆!');window.location.href='login.php';</script>";
exit();
  
}
?>