<?php
/*控制类*/
class config{
	//根据用户id获取控制信息
	public function get_config_byid($db,$id)
	{
		$sql = "select * from config where id=".$id;
		//$db = new DB();
		//$db->Connect(DBHOST,DBUSER,DBPW,DBNAME);
		$query = $db->query($sql);
		$result = $db->fetch_array($query);
		return $result;
	}
	//根据用户id获取开关信息
	public function get_close_byid($db,$id)
	{
		$sql = "select * from config_close where id=".$id;
		//$db = new DB();
		//$db->Connect(DBHOST,DBUSER,DBPW,DBNAME);
		$query = $db->query($sql);
		$result = $db->fetch_array($query);
		return $result;
	}
}


/*用户类*/
class users{
	
	//根据用户名获取用户信息
	public function get_user($db,$loginname)
	{
		$sql = "select * from users where loginname='".$loginname."'";
		//$db = new DB();
		//$db->Connect(DBHOST,DBUSER,DBPW,DBNAME);
		$query = $db->query($sql);
		$result = $db->fetch_array($query);
		return $result;
	}
	//根据用户id获取用户信息
	public function get_user_byid($db,$id)
	{
		$sql = "select * from users where id=".$id;
		//$db = new DB();
		//$db->Connect(DBHOST,DBUSER,DBPW,DBNAME);
		$query = $db->query($sql);
		$result = $db->fetch_array($query);
		return $result;
	}



// 说明：获取完整URL

function curPageURL()
{
    $pageURL = 'http';

    if ($_SERVER["HTTPS"] == "on")
    {
        $pageURL .= "s";
    }
    $pageURL .= "://";

    if ($_SERVER["SERVER_PORT"] != "80")
    {
        $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
    }
    else
    {
        $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
    }
    return $pageURL;
}

// 说明：获取完整URL,不包括域名

function GetCurUrl()
{
if(!empty($_SERVER["REQUEST_URI"]))
{
$scrtName = $_SERVER["REQUEST_URI"];
$nowurl = $scrtName;
}
else
{
$scrtName = $_SERVER["PHP_SELF"];
if(empty($_SERVER["QUERY_STRING"]))
{
$nowurl = $scrtName;
}
else
{
$nowurl = $scrtName."?".$_SERVER["QUERY_STRING"];
}
}
return $nowurl;
} 
}

	
$jjszsql = "select * from config where id=1";
$jjszquery = $db->query($jjszsql);
$result = $db->fetch_array($jjszquery);
$regjine = $result['regjine'];
$fenhongjine = $result['fenhongjine'];
$chujujine = $result['chujujine'];
$jiangjin1 = $result['jj1'];
$jiangjin2 = $result['jj2'];
$jiangjin3 = $result['jj3'];
$jiangjin4 = $result['jj4'];

function shouzhi($db,$uid,$userid,$types,$jine,$shifa,$fuli,$reason,$sfjj)
{

$dysql="select id,amount from users where id=".$uid."";
$dyquery=$db->query($dysql);
$dyrow=$db->fetch_array($dyquery);
if (!empty($dyrow['id']))
{
$nowamount=$dyrow['amount'];
}


		$sql="insert into income (uid,userid,types,addtime,jine,shifa,zhongzi,reason,sfjj,nowamount) values ('".$uid."','".$userid."','".$types."','".date('Y-m-d H:i:s')."','".$jine."','".$shifa."','".$fuli."','".$reason."','".$sfjj."','".$nowamount."')";
		$db->query($sql);


}


function userjibiename($level)
{
  if ($level == 0)
  {
    return "新人";
  }
  if ($level == 1)
  {
    return "一星会员";
  }
  if ($level == 2)
  {
    return "二星会员";
  }
  if ($level == 3)
  {
    return "三星会员";
  }
  if ($level == 4)
  {
    return "四星会员";
  }
  if ($level == 5)
  {
    return "五星群主";
  }
  if ($level == 6)
  {
    return "六星达人";
  }
  if ($level == 7)
  {
    return "七星达人";
  }
  if ($level == 8)
  {
    return "八星达人";
  }
  if ($level == 9)
  {
    return "九星达人";
  }

}



function format_money($STR)
{
  //        if ( $STR == "" )
  //        {
  //                return "";
  //        }
  if ($STR == ".00")
  {
    return "0.00";
  }
  if ($STR == "0")
  {
    return "0.00";
  }
  $TOK = strtok($STR, ".");
  if (strcmp($STR, $TOK) == "0")
  {
    $STR .= ".00";
  }
  else
  {
    $TOK = strtok(".");
    $I = 1;
    for (; $I <= 2-strlen($TOK); ++$I)
    {
      $STR .= "0";
    }
  }
  if (substr($STR, 0, 1) == ".")
  {
    $STR = "0".$STR;
  }
  return $STR;
}


//删除超过一天的会员
$sqlshenhe3="select * from users where adddate<='".date('Y-m-d',strtotime('-2 day'))."' and states=0 order by id asc";
$queryshenhe3=$db->query($sqlshenhe3);
while($rowshenhe3=$db->fetch_array($queryshenhe3))
{
	$sqlshenhe="select count(*) as allshenhe from shengji where userid= '".$rowshenhe3['id']."' and jibie=1 and passed=0";
    $queryshenhe=$db->query($sqlshenhe);
    $rowshenhe=$db->fetch_array($queryshenhe);
	if($rowshenhe['allshenhe']==0||$rowshenhe['allshenhe']==2)
	{
		$delsql="delete from shengji where userid= '".$rowshenhe3['id']."' and jibie=1 and passed=0 ";
	    $db->query($delsql);
		$delsql="delete from users where id ='".$rowshenhe3['id']."' and states=0 ";
	    $db->query($delsql);
	}
}
//删除超过一天的会员
?>