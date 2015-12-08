<?php 
@header('Content-type: text/html;charset=UTF-8');
require_once "config_global.php";
require_once "checkpostandget.php";
require_once "classes/key.class.php";
require_once "classes/mysql.class.php";
require_once "classes/page.php";

date_default_timezone_set('Asia/Shanghai');

set_time_limit(0);

@session_start();

$db = new DB();
$db->Connect(DBHOST,DBUSER,DBPW,DBNAME);
mysql_query("set names 'utf8'");

require_once "classes/lib.class.php";


?>
