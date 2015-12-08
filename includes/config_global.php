<?php
// ------------------  CONFIG PUBLIC  ------------------- //
define('CHARSET', 'UTF-8');
define('ROOT', $_SERVER['DOCUMENT_ROOT'].'/');
date_default_timezone_set (PRC); //
define('SITEURL','http://'.$_SERVER['HTTP_HOST'].'/');
session_start();
// ------------------  CONFIG DB  ------------------- //

define('DBHOST', 'localhost');
define('DBUSER', '150801');
define('DBPW', 'Z9vqdzrywy9Qmatz');
define('DBNAME', '150801');
define('DBCHARSET', 'UTF-8');
define('DBTABLEPRE', '');
define('DBCONNECT', 0);
?>