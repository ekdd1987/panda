<?php
require_once("includes/conn.php");
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

$sql1="select * from xiangguan where articleid=1 ";
$query1=$db->query($sql1);
$row1=$db->fetch_array($query1);

$sql2="select * from xiangguan where articleid=2 ";
$query2=$db->query($sql2);
$row2=$db->fetch_array($query2);
?>    <div class="udd-body">
        <div class="panel">
          <div class="panel-head"><strong>关于天天创客！</strong></div>
          <div class="panel-body bg-white">
          	<?php echo $row1['content']?>
          </div>
       	</div>
        <br />
        <div class="panel">
          <div class="panel-head"><strong>欢迎加入天天创客！</strong></div>
          <div class="panel-body bg-white">
          	<?php echo $row2['content']?>
          </div>
        </div>
    </div>
<?php
require_once("foot.php");
?>
</div>	
</body>
</html>
