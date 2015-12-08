<?php

if($_COOKIE["adminname"]=="")
{

//echo "<script>alert('请登录!');history.go(-1);<000/script>";
echo "<script>alert('请登录!');parent.window.location.href='/fadminx/tj_Login.php';</script>";
exit();
  
}

?>