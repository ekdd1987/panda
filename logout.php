<?php
@session_start(); 	
    $_SESSION['uusername']="";
    $_SESSION['uuserid']="";
	$_SESSION['pass2']="";
	$_SESSION['pass3']="";
	$_SESSION['mibao']="";
    echo "<script>window.location.href='./';</script>";
	exit();
?>