<?php
include("../Admin.php");
include("../../includes/conn.php");
?>
<?php

@session_start();


$id=$_GET['id'];

$onlinetime=date("Y-m-d H:i:s");

	$sql='SELECT * FROM users where id="'.$id.'"  limit 1';
  $query=$db->query($sql);
  if($row=$db->fetch_array($query))
  { 
  	@session_start(); 	
	$_SESSION['uusername']=$row['loginname'];
    $_SESSION['uuserid']=$row['id'];
	$_SESSION['pass2']="1";
	$_SESSION['pass3']="1";
	$_SESSION['onlinetime']=$onlinetime;
	$_SESSION['cs']=date("Y-m-d H:i:s");

$bdsql="Update users set logincishu=logincishu+1,onlinetime='".$onlinetime."' where id ='".$row['id']."' ";
$db->query($bdsql);	
	

    {echo "<script>window.location.href='../../';</script>";}
	exit();
  }
  else
  {
  	echo "<script>alert('错误!');history.go(-1);</script>";
	exit();
  	
  }
  
  

?>