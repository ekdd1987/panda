<?php
  /* 
  *数据库访问类 DB 
  *本访问类是基于PHP5的纯静态类,可以不实例化对象调用类的方法,在OOP开发中非常方便.本类带有数据库查询次数记忆,sql语句错误处理功能.具体功能请见代码.本类部分功能参考了discuz的数据库访问类功能后编写. 
  */ 
  class DB { 
   
   #公有属性 
   public static $conn; 
   public static $data; 
   public static $fields; 
   public static $row; 
   public static $row_num; 
   public static $insertid; 
   public static $version; 
   public static $affected_rows; 
   public static $query_num = 0; 
   public static $debug = false; 
   #私有属性 
   private static $user; 
   private static $pass; 
   private static $host; 
   private static $db; 
   
   
   
   #公有方法 
   
   /* 
   公有静态方法,链接数据库初始化数据库访问对象 
   $host 服务器地址 
   $user 用户名 
   $pass 密码 
   $db 数据库名称 
   
   无返回值 
   */ 
   public static function Connect($host,$user,$pass,$db) { 
   self::$host = $host; 
   self::$pass = $pass; 
   self::$user = $user; 
   self::$db = $db; 
   self::$conn = @ mysql_connect($host,$user,$pass) or self::msg('连接数据库失败!可能是mysql数据库用户名或密码不正确!'); 
   self::selectdb(self::$db); 
   if( self::version() >'4.1' ) { 
   mysql_query("SET NAMES 'GBK'"); 
   } 
   if( self::version() > '5.0.1' ) { 
   mysql_query("SET sql_mode=''"); 
   } 
   
   } 
   
   public static function query($sql) { 
   $query = @ mysql_query($sql,self::$conn) or self::msg("SQL语法错误:".htmlspecialchars($sql)); 
   if(self::$debug) { 
   echo $sql . "<br>\n"; 
   } 
   self::query_num(); 
   return $query; 
   } 
   
   //返回根据从结果集取得的行生成的数组，如果没有更多行则返回 FALSE,除了将数据以数字索引方式储存在数组中之外，还可以将数据作为关联索引储存，用字段名作为键名。 
   public static function fetch_array($query) { 
   self::$data = @mysql_fetch_array($query); 
   return self::$data; 
   } 
   
   //返回结果集中字段的数目
   public static function num_fields($query) { 
   self::$fields = @mysql_num_fields($query); 
   return self::$fields; 
   } 
   
   //返回根据从结果集取得的行生成的数组，如果没有更多行则返回 FALSE,只能将数据以数字索引方式储存在数组中
   public static function fetch_row($query) { 
   self::$row = @mysql_fetch_row($query); 
   return self::$row; 
   } 
   
   //返回结果集中行的数目
   public static function num_rows($query) { 
   self::$row_num = @mysql_num_rows($query); 
   return self::$row_num; 
   } 
   
   //返回给定的 link_identifier 中上一步 INSERT 查询中产生的 AUTO_INCREMENT 的 ID 号。如果没有指定 link_identifier，则使用上一个打开的连接。 如果上一查询没有产生 AUTO_INCREMENT 的值，则 mysql_insert_id() 返回 0。如果需要保存该值以后使用，要确保在产生了值的查询之后立即调用 mysql_insert_id()
   public static function insert_id() { 
   self::$insertid = mysql_insert_id(); 
   return self::$insertid; 
   } 
   
   //取得最近一次与 link_identifier 关联的 INSERT，UPDATE 或 DELETE 查询所影响的记录行数
   public static function affected_rows() { 
   self::$affected_rows = mysql_affected_rows(self::$conn); 
   return self::$affected_rows; 
   } 
   
   //取得一行数据
   public static function fetch_one_array($sql){ 
   $query = self::query($sql); 
   self::$data = self::fetch_array($query); 
   return self::$data; 
   } 
   
   public static function close() { 
   mysql_close(self::$conn); 
   } 
   
   #私有方法 
   
   private static function query_num(){ 
   self::$query_num++; 
   } 
   
   private static function selectdb($db) { 
   mysql_select_db($db,self::$conn) or self::msg('未找到指定数据库!'); 
   } 
   
   private static function version() { 
   self::$version = mysql_get_server_info(); 
   return self::$version; 
   } 
   
   private static function geterror() { 
   return mysql_error(); 
   } 
   
   private static function geterrno() { 
   return intval(mysql_errno()); 
   } 
   
   private static function msg($info) { 
   echo "<html><head>\n"; 
   echo "<meta http-equiv=\"Content-Type\" content=\"text/html ; charset=gb2312\">\n"; 
   echo "<title>警告,MySql查询错误.</title></head>\n<body>\n"; 
   echo "<table width=\"800\" align=\"center\" bgcolor=\"#f6f6f6\" cellpadding=\"0\" cellspacing=\"0\">"; 
   echo "<tr><td style=\"font-size:13px;font-family:Verdana;\">\t<b>错误信息：</b>$info<br />"; 
   echo "<b>Mysql error：</b><br />".self::geterror()."<br />"; 
   echo "<b>Mysql error number：</b>".self::geterrno()."<br />\n"; 
   echo "<b>Time</b>: ".gmdate("Y-n-j g:ia", time() + (8 * 3600))."<br />\n"; 
   echo "<b>Script</b>: ".$_SERVER['PHP_SELF']."<br /></td></tr>\n"; 
   echo "</table>\n</body>\n</html>\n"; 
   exit; 
   } 
   
 } 
 
 
 
function isexit($db,$loginname)
{
	$sql = "select * from users where loginname = '".$loginname."'";
	$query = $db->query($sql);
	$result = $db->num_rows($query);
	if($result>0)
	{
		return "yes";
	}
	else 
	{
		return "no";
	}
}


//登录
function login($loginname,$pwd,$db)
{
	$sql = "select * from users where states = 1 and loginname='".$loginname."' and pwd1 = '".$pwd."'";
	$query = $db->query($sql);
	$result = $db->num_rows($query);
	if($result==1)
	{
		//savelog($db,"用户[".$loginname."]登录成功");
	}
	return $result;
}
?>