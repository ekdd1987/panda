<?php
function GetIP()
{  
	if(!empty($_SERVER["HTTP_CLIENT_IP"]))
		$cip = $_SERVER["HTTP_CLIENT_IP"];
	else if(!empty($_SERVER["HTTP_X_FORWARDED_FOR"]))
		$cip = $_SERVER["HTTP_X_FORWARDED_FOR"];
	else if(!empty($_SERVER["REMOTE_ADDR"]))
		$cip = $_SERVER["REMOTE_ADDR"];  
	else
		$cip = "";  
	return $cip; 
 } 
 
 function savelog($db,$log)
 {
 	$db->query("insert into logs(logcontent,addtime)values('".$log."',now())");
 }
?>