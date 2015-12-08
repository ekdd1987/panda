<?php
/*
*业务逻辑类文件
*/
require_once ROOT."sysadmin/includes/config_global.php";
require_once ROOT."sysadmin/includes/classes/mysql.class.php";
require_once ROOT."sysadmin/includes/functions/common.php";

/*用户类*/
class users{
	//根据用户名获取用户信息
	public function get_user($loginname)
	{
		$sql = "select * from users where loginname='".$loginname."'";
		$db = new DB();
		$db->Connect(DBHOST,DBUSER,DBPW,DBNAME);
		$query = $db->query($sql);
		$result = $db->fetch_array($query);
		return $result;
	}
	//根据用户id获取用户信息
	public function get_user_byid($id)
	{
		$sql = "select * from users where id=".$id;
		$db = new DB();
		$db->Connect(DBHOST,DBUSER,DBPW,DBNAME);
		$query = $db->query($sql);
		$result = $db->fetch_array($query);
		return $result;
	}
	//根据用户id获取用户信息
	public function get_user_byid_net2($id)
	{
		$sql = "select n.id as nid,n.uid as id,n.pid as pid,u.loginname as loginname from net2 n,users u where n.uid = u.id and u.id=".$id;
		$db = new DB();
		$db->Connect(DBHOST,DBUSER,DBPW,DBNAME);
		$query = $db->query($sql);
		$result = $db->fetch_array($query);
		return $result;
	}
	//判断用户是已申请创业基金
	public function get_user_fund($id)
	{
		$sql = "select * from fundamount where states = 1 and userid=".$id;
		$db = new DB();
		$db->Connect(DBHOST,DBUSER,DBPW,DBNAME);
		$query = $db->query($sql);
		$count = $db->num_rows($query);
		return $count;
	}
	//获取发展用户数
	public function get_usercount_byrid($id)
	{
		$sql = "select * from users where states = 1 and  rid=".$id;
		$db = new DB();
		$db->Connect(DBHOST,DBUSER,DBPW,DBNAME);
		$query = $db->query($sql);
		$counts = $db->num_rows($query);//获取总条数
 		return $counts;
	}
	//获取发展用户数
	public function get_usercount_bypid($id)
	{
		$sql = "select * from users where states = 1 and  pid=".$id;
		$db = new DB();
		$db->Connect(DBHOST,DBUSER,DBPW,DBNAME);
		$query = $db->query($sql);
		$counts = $db->num_rows($query);//获取总条数
 		return $counts;
	}
	//获取发展用户在rid下的位置
	public function get_userarea_byrid($uid,$rid)
	{
		$sql = "select * from users where states = 1 and  rid=".$rid." order by id";
		
		$db = new DB();
		$db->Connect(DBHOST,DBUSER,DBPW,DBNAME);
		$query = $db->query($sql);
		$counts = $db->num_rows($query);//获取总条数
		for($i=1;$i<$counts;$i++)
		{	
			$row = $db->fetch_array($query);
			if($row["id"] == $uid)
			{
				break;
			}
		} 
		return $i;
	}
	//获取会员等级
	public function getlevel($productcount)
	{	 
		$bizset = new bizset();
		$bizsetinfo = $bizset->get_bizset_bykey("USERTYPE".$productcount);
		$level = $bizsetinfo["memo"];
		return $level;
	}
	//添加用户
	public function add_user($db,$loginname,$pwd,$pid,$sel,$qq,$pwd2,$pwd3,$truename,$identityid,$bank,$bankno,$bankname,$bankaddress,$tel,$qq,$rid,$area,$grade)
	{
		//插入用户数据
		$db->query("insert into users(pid,bizid,loginname,pwd1,pwd2,pwd3,truename,
		identityid,bank,bankno,bankname,bankaddress,tel,qq,rid,area,addtime,productcount) values
				   ('".$pid."','".$sel."','".$loginname."','".$pwd."','".$pwd2."','".$pwd3."','".$truename."','".$identityid."','".$bank."','".$bankno."','".$bankname."','".$bankaddress."','".$tel."','".$qq."','".$rid."','".$area."',now(),".$grade.")");
		//user_sub_count添加记录
		$users = new users();
		$usersinfo = $users->get_user($loginname);
		$users->insert_count($usersinfo["id"]);
		
		//$users->audit_user_byid($usersinfo["id"]);
		
		savelog($db,"用户[".$loginname."]注册成功");
		$result = 1;
		
	}
	
	//会员根据投资额升级
	public function user_upgrade()
	{
		//获取各等级投资额
		$bizset = new bizset();
		$bizsetinfo = $bizset->get_bizset_bykey("STOCKUPDATE1");
		$stockprice1 = $bizsetinfo["bizvalue"];
		$bizsetinfo = $bizset->get_bizset_bykey("STOCKUPDATE2");
		$stockprice2 = $bizsetinfo["bizvalue"];
		$bizsetinfo = $bizset->get_bizset_bykey("STOCKUPDATE3");
		$stockprice3 = $bizsetinfo["bizvalue"];
		$bizsetinfo = $bizset->get_bizset_bykey("STOCKUPDATE4");
		$stockprice4 = $bizsetinfo["bizvalue"];
		
		$db = new DB();
		$db->Connect(DBHOST,DBUSER,DBPW,DBNAME);
		$sql = "select * from users where states = 1 and id !=100000 ";
		$query = $db->query($sql);
		$count=$db->num_rows($query);
	  	for($i=0;$i<$count;$i++)
	  	{
			$row = $db->fetch_array($query);
			$id = $row["id"];
			$stock = $row["stock"];
			$productcount = $row["productcount"];//会员等级
			//获取最新股价
			$stockinfo = new stock();
			$new_price = $stockinfo->get_newprice(1);
			//用户投资额
			$user_stock_price = $stock*$new_price;
			if($productcount<4)
			{
				if($productcount==3)
				{
					if($user_stock_price>=$stockprice4)
					{
						$sql = "update users set productcount = 4  where id=".$id.""; 
						$db->query($sql);
					}
				}
				if($productcount==2)
				{
					if($user_stock_price>=$stockprice3)
					{
						$sql = "update users set productcount = 3  where id=".$id.""; 
						$db->query($sql);
					}
					if($user_stock_price>=$stockprice4)
					{
						$sql = "update users set productcount = 4  where id=".$id.""; 
						$db->query($sql);
					}
				}
				if($productcount==1)
				{
					if($user_stock_price>=$stockprice2)
					{
						$sql = "update users set productcount = 2  where id=".$id.""; 
						$db->query($sql);
					}
					if($user_stock_price>=$stockprice3)
					{
						$sql = "update users set productcount = 3  where id=".$id.""; 
						$db->query($sql);
					}
					if($user_stock_price>=$stockprice4)
					{
						$sql = "update users set productcount = 4  where id=".$id.""; 
						$db->query($sql);
					}
				}
			} 
		}
	}
	
	//根据用户id更新用户信息
	public function update_user_byid($id,$pwd1,$pwd2,$pwd3,$truename,$identityid,
       $bank,$bankno,$bankname,$bankaddress,$tel,$qq)
	{
		$sql = "update users set pwd1 = '".$pwd1."',pwd2 = '".$pwd2."',pwd3 = '".$pwd3."',truename = '".$truename."',identityid = '".$identityid."',bank = '".$bank."',bankno = '".$bankno."',bankname = '".$bankname."',bankaddress = '".$bankaddress."',tel = '".$tel."',qq = '".$qq."'  where id=".$id.""; 
		$db = new DB();
		$db->Connect(DBHOST,DBUSER,DBPW,DBNAME);
		$query = $db->query($sql);
		$result = 1;
		return $result;
	}
	//管理员根据用户id修改用户信息
	public function modify_user_byid($loginname,$pwd1,$pwd2,$pwd3,$truename,$identityid,
       $bank,$bankno,$bankname,$bankaddress,$tel,$qq,$procount,$id)
	{
		$sql = "update users set pwd1 = '".$pwd1."',pwd2 = '".$pwd2."',pwd3 = '".$pwd3."',truename = '".$truename."',identityid = '".$identityid."',bank = '".$bank."',bankno = '".$bankno."',bankname = '".$bankname."',bankaddress = '".$bankaddress."',tel = ".$tel.",qq = ".$qq." where loginname='".$loginname."'"; 
		$db = new DB();
		$db->Connect(DBHOST,DBUSER,DBPW,DBNAME);
		$query = $db->query($sql);
	
		$result = 1;
		return $result;
	}
	//管理员根据用户id审核用户
	public function audit_user_byid($id)
	{
		$db = new DB();
		$db->Connect(DBHOST,DBUSER,DBPW,DBNAME);
		$result = 0;
		$users = new users();
		$usersinfo = $users->get_user_byid($id);
		$userstate = $usersinfo["states"];
		$rid = $usersinfo["rid"];
		$count = $usersinfo["productcount"];
		$bizset = new  bizset();
		$bizsetinfo = $bizset->get_bizset_bykey("PRICE");
		$price = $bizsetinfo["bizvalue"];
		$stock = $usersinfo["stock"];//股数
		if($userstate=="0")
		{
			$award = new award();
			//递归累计发展用户数 user_sub_count
			$users->recursive_user_count($id,$count,1);
			
			//更新用户状态
			$sql = "update users set states = 1 where id=$id"; 
			$db->query($sql);
			
			//直接推荐奖
		/*	$bizsetinfo = $bizset->get_bizset_bykey("STOCKUPDATE".$count);
			$price = $bizsetinfo["bizvalue"];
			$award->recursiverid($db,$id,1,$price,"直接推荐奖");*/
			
			//插入stock_trans_list
		/*	$sql = "insert stock_trans_list(sid,uid,price,count,addtime,type) value(1,$id,1,$stock,now(),'首次购买股票')";
			$db->query($sql);
			$sql = "insert income(userid,types,amount,addtime,reason,states,settlementno) values(".$id.",'FIRSTBUYSTOCK',0,now(),'首次购买股票',2,'')";
			$db->query($sql);*/
			
			//见点奖 根据投资总额
			/*$stockinfo = new stock();
			$stock_price = $stockinfo->get_newprice(1);
			$amount = $stock*$stock_price;
			$award->recursivepid($db,$id,1,$amount);*/

			$result = 1;
			return $result;
		}
		else 
		{
			$result = '用户已审核';//已审核
			return $result;
		}
	}
	
	//审核会员的升级申请
	public function audit_use_upgrade($db,$id)
	{
		$users = new users();
		$userupgradeinfo = $users->get_userupgrade_byid($id);
		//推荐奖8层
		$award = new award();
		$award->recursivepid($db,$userupgradeinfo["uid"],1,$userupgradeinfo["gradecount"]);
		$sql = "update upgrade set states = 1 where id = ".$id."";
		$db->query($sql);
		$sql = "update users set productcount = ".$userupgradeinfo["newgrade"]." where id = ".$userupgradeinfo["uid"]."";
		$db->query($sql);
	}
	
	//根据用户id删除未审核用户
	public function delete_user_byid($id)
	{
		$result = 0;
		$users = new users();
		$usersinfo = $users->get_user_byid($id);
		$userstate = $usersinfo["states"];
		$pid = $usersinfo["pid"];
		$area = $usersinfo["area"];
		if($userstate=="0")
		{
			//查询该用户的下层用户下有多少个用户
			$db = new DB();
			$db->Connect(DBHOST,DBUSER,DBPW,DBNAME);
			$sql = "select id from users where pid = ".$id;
			$query = $db->query($sql);
			$count = $db->num_rows($query);
			if($count>=2)
			{
				$result = "该用户下层不只一个用户，无法删除";
				return $result;
			}
			else if($count==0)
			{
				//删除该用户
				$sql = "delete from users where id=".$id; 
				$db->query($sql);
				$result = 1;
				return $result;
			}
			else if($count==1)
			{
				//删除该用户
				$sql = "delete from users where id=".$id; 
				$db->query($sql);
				//更新下层用户的pid
				$sql = "update users set pid = ".$pid.",area = ".$area." where pid = ".$id.""; 
				$db->query($sql);
				$result = 1;
				return $result;
			}
		}
		else 
		{
			$result = 4;
			return $result;
		}
	}
	//商务中心审核自己的会员
	public function busi_audit_user_byid($id)
	{
		$db = new DB();
		$db->Connect(DBHOST,DBUSER,DBPW,DBNAME);
		$result = 0;
		$users = new users();
		$usersinfo = $users->get_user_byid($id);
		$userstate = $usersinfo["states"];
		$count = $usersinfo["productcount"];
		$rid = $usersinfo["rid"];
		$bizid = $usersinfo["bizid"];
		$bisiinfo = $users->get_bisi($bizid);
		$bizset = new  bizset();
		$bizsetinfo = $bizset->get_bizset_bykey("PRICE");
		$stock = $bizsetinfo["bizvalue"]*$count;//股数
		if($userstate=="0")
		{
			$award = new  award();
			$bizset = new  bizset();
			
			$bizsetinfo = $bizset->get_bizset_bykey("PRICE");
			$user_price = $bizsetinfo["bizvalue"]*$count;//发展用户金额

			//判断商务中心余额是否足够
			if($bisiinfo["total"]<$user_price)
			{
				$result = "商务中心余额不够，请充值后再审核用户";
				return $result;
			}
			else 
			{
				//递归累计发展用户数 user_sub_count
				$users->recursive_user_count($id,$count,1);
				
				//更新用户状态
				$sql = "update users set states = 1,stock=$stock/3 where id=$id"; 
				//$sql = "update users set states = 1,amount=amount-".$user_price." where id=".$id; 
				$db->query($sql);
				
				//插入stock_trans_list
				$sql = "insert stock_trans_list(sid,uid,price,count,addtime,type) value(1,$id,1,$stock/3,now(),'首次购买股票')";
				$db->query($sql);
				$sql = "insert income(userid,types,amount,addtime,reason,states,settlementno) values(".$id.",'FIRSTBUYSTOCK',0,now(),'首次购买股票',2,'')";
				$db->query($sql);
				
				 
				
				//服务中心奖励
				$bizsetinfo = $bizset->get_bizset_bykey("SUBSIDIES");
				$subpercent = $bizsetinfo["bizvalue"];
				$award->subsidies($bizid,$subpercent*$user_price);
				
				//代理中心扣除金额
				$sql = "update biz set total = total - ".$user_price."  where userid = ".$bizid;
			    $db->query($sql);

				
				
				/*//插入产品订购信息
				$db->query("insert into order_list(uid,pid,count,memo,addtime,states) values(".$id.",".$count.",1,'用户注册购买产品',now(),1)");
				$db->query($sql);
				//消费提成
				$product = new product();
				$orderid = $product->get_orderidbyuid($id);
				$award->recsell($db,$orderid,$id,1);
				//更新订购状态
				$db->query("update order_list set states = 1 where id=".$orderid);
				*/
				$result = 1;
				return $result;
			}
		}
		else 
		{
			$result = 5;//已审核
			return $result;
		}
	}
	
	//获取商务中心信息
	public function get_bisi($id)
	{
		$sql = "select * from biz where userid='".$id."'";
		$db = new DB();
		$db->Connect(DBHOST,DBUSER,DBPW,DBNAME);
		$query = $db->query($sql);
		$result = $db->fetch_array($query);
		return $result;
	}
	
	//根据用户types获取用户类型
	public function get_types($types)
	{
		if($types=="0")
		{
			return "普通用户";
		}
		else if($types=="1")
		{
			return "管理员";
		}
		else if($types=="2")
		{
			return "报单中心";
		}
	}

	//根据用户id判断用户是否存在
	public function isexit_user_byid($id)
	{
		$sql = "select * from users where id=".$id;
		$db = new DB();
		$db->Connect(DBHOST,DBUSER,DBPW,DBNAME);
		$query = $db->query($sql);
		$result = $db->num_rows($query);
		return $result;
	}
	//根据用户名称判断用户是否存在
	public function isexit($loginname)
	{
		$db = new DB();
		$db->Connect(DBHOST,DBUSER,DBPW,DBNAME);
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
	//根据用户id获取位置剩余用户数
	public function get_areacount_byid($id)
	{
		$sql = "select * from user_sub_count where uid=".$id; 
		$db = new DB();
		$db->Connect(DBHOST,DBUSER,DBPW,DBNAME);
		$query = $db->query($sql);
		$result = $db->fetch_array($query);
		return $result;
	}
	
	//递归累计发展用户数 user_sub_count
	public function recursive_user_count($id,$procount,$layer)
	{
 		//获取当前用户area rid
 		$users = new users();
		$usersinfo = $users->get_user_byid($id);
		$pid = $usersinfo["pid"];
		$area = $usersinfo["area"];
		$count = $procount;
		//echo $rid.$id;exit;
		if($pid!="0")
		{
			//更新user_sub_count
		    $result = $users->update_user_count($pid,$area,$count);
			//更新layerlist
		    $result2 = $users->update_layerlist($pid,$area,$layer,$count);
			
			
		    if($result == 1 && $result2 == 1)
		    {
				$layer=$layer+1;
				//echo $pid."-".$count."-".$layer;exit;
		   		$users->recursive_user_count($pid,$count,$layer);
		    }
		}
	}
	
	public function threeusers($db,$id)
	{
		$sql = "select id from users";
		$query22=$db->query($sql);
		$count = $db->num_rows($query22);
		for($i=0;$i<$count;$i++)
		{
			$result = $db->fetch_array($query22);
			self::threeusers2($db,$result["id"],$id);
		}
	}
	
	//生成3个子用户
	public function threeusers2($db,$rid,$id)
	{
		$users = new users();
		//判断第5层是否达到29单
		$count2 = $users->getcountbylayer($rid,5);	
		if($count2 == 29)
		{
			$usersinfo2 = $users->get_user_byid($rid);
			$loginname = $usersinfo2["loginname"];
			//增加三点位继续享受奖金
			//echo $rid.$id;exit;
			//用户注册自动选择位置与rid
			self::get_auto_area_byid($id);
			$db->query("insert into 		users(rid,pid,types,loginname,pwd1,pwd2,truename,addtime,bizid,productcount,states,identityid,bank,bankno,bankname,bankaddress,tel,area) values(".$_SESSION['autorid'].",".$rid.",1,'".$loginname."_01','1','1','1',now(),1000,1,0,1,'中国工商银行',1,1,1,1,".$_SESSION['autoarea'].")");
			//user_sub_count添加记录
			$usersinfo = $users->get_user($loginname."_01");
			$users->insert_count($usersinfo["id"]);
			$users->audit_user_byid($usersinfo["id"]);
			$_SESSION['autorid'] = "";
			$_SESSION['autoarea'] = "";
			
			//用户注册自动选择位置与rid
			self::get_auto_area_byid($id);
			$db->query("insert into 		users(rid,pid,types,loginname,pwd1,pwd2,truename,addtime,bizid,productcount,states,identityid,bank,bankno,bankname,bankaddress,tel,area) values(".$_SESSION['autorid'].",".$rid.",1,'".$loginname."_02','1','1','1',now(),1000,1,0,1,'中国工商银行',1,1,1,1,".$_SESSION['autoarea'].")");
			//user_sub_count添加记录
			$usersinfo = $users->get_user($loginname."_02");
			$users->insert_count($usersinfo["id"]);
			$users->audit_user_byid($usersinfo["id"]);
			$_SESSION['autorid'] = "";
			$_SESSION['autoarea'] = "";
			
			//用户注册自动选择位置与rid
			self::get_auto_area_byid($id);
			$db->query("insert into 		users(rid,pid,types,loginname,pwd1,pwd2,truename,addtime,bizid,productcount,states,identityid,bank,bankno,bankname,bankaddress,tel,area) values(".$_SESSION['autorid'].",".$rid.",1,'".$loginname."_03','1','1','1',now(),1000,1,0,1,'中国工商银行',1,1,1,1,".$_SESSION['autoarea'].")");
			//user_sub_count添加记录
			$usersinfo = $users->get_user($loginname."_03");
			$users->insert_count($usersinfo["id"]);
			$users->audit_user_byid($usersinfo["id"]);
			$_SESSION['autorid'] = "";
			$_SESSION['autoarea'] = "";
		}
	}
	
	//更新用户数
	public function update_user_count($id,$area,$count)
	{
		$db = new DB();
		$db->Connect(DBHOST,DBUSER,DBPW,DBNAME);
		$sql = "update user_sub_count set count_".$area." = count_".$area." + ".$count." where uid = ".$id."";
		$db->query($sql);
		
		$result = 1;
		return $result;
	 	
	}
	
	//更新用户数layerlist
	public function update_layerlist($id,$area,$layer,$productcount)
	{
		$db = new DB();
		$db->Connect(DBHOST,DBUSER,DBPW,DBNAME);
		/*//判断该位置是否已经有用户
		$sql = "select id from layerlist where uid=".$id." and layer=".$layer." and area=".$area."";
		$query=$db->query($sql);
		$count=$db->num_rows($query);
		if($count==0)//不存在
		{*/
			$sql = "insert layerlist(uid,layer,area,productcount,states) values(".$id.",".$layer.",".$area.",".$productcount.",0)";
			$db->query($sql);
		/*}*/
		$result = 1;
		return $result;
	}
	
	//根据层数获取的发展用户数
	public function getcountbylayer($id,$layer)
	{
		$db = new DB();
		$db->Connect(DBHOST,DBUSER,DBPW,DBNAME);

		$sql = "select id from layerlist where  uid not in (select pid from users) and uid=".$id." and layer=".$layer."";
		$query=$db->query($sql);
		$count=$db->num_rows($query);
		
		return $count;
	}
	
	//根据层数获取的发展用户数2
	public function getcountbylayer2($id,$layer)
	{
		$db = new DB();
		$db->Connect(DBHOST,DBUSER,DBPW,DBNAME);

		$sql = "select id from layerlist where uid=".$id." and layer=".$layer."";
		$query=$db->query($sql);
		$count=$db->num_rows($query);
		
		return $count;
	}
	
	//user_sub_count添加记录
	function insert_count($id)
	{
		$sql = "insert into user_sub_count(uid) values ('".$id."')";
		$db = new DB();
		$db->Connect(DBHOST,DBUSER,DBPW,DBNAME);
		$db->query($sql);
		$result = 1;
		return $result;
	}
	//根据用户id和area获取下层用户id
	public function get_userid_byidarea($id,$area)
	{
		$sql = "select * from users where pid=".$id." and area=".$area;
		$db = new DB();
		$db->Connect(DBHOST,DBUSER,DBPW,DBNAME);
		$query = $db->query($sql);
		$result = $db->fetch_array($query);
		return $result["id"];
	}
	//根据用户pid 递归取所有用户编号
	public function getrecursiveallusersid($uid)
	{			
	    $ls_return = "";
		
		//取PID会员信息			
		$db = new DB();
		$db->Connect(DBHOST,DBUSER,DBPW,DBNAME);
		$sql = "select * from users where states = 1 and pid=".$uid." order by id";			
		$query = $db->query($sql);
		$counts = $db->num_rows($query);//获取总条数				
		if ($counts > 0)
		{
			for($i=1;$i<=$counts;$i++)
			{	
				$row = $db->fetch_array($query);	
				$ls_return .= $row["id"] . ",";
				$ls_return .= self::getrecursiveallusersid($row["id"]);			
			} 
		}	
		$ls_return .= $uid.",";//将自己加入团队
		return $ls_return;
		
	}
	//根据用户id和area获取下层用户id
	public function get_userid_byidarea_net2($id,$area)
	{
		$sql = "select * from net2 where pid=".$id." and area=".$area;
		$db = new DB();
		$db->Connect(DBHOST,DBUSER,DBPW,DBNAME);
		$query = $db->query($sql);
		$result = $db->fetch_array($query);
		return $result["uid"];
	}
	
	//用户注册自动选择位置与rid
	public function get_auto_area_byid($id)
	{
		$db = new DB();
		$db->Connect(DBHOST,DBUSER,DBPW,DBNAME);
		//echo $id;exit;
		self::recursive_auto_area($db,$id);
		
		$allrid = substr($_SESSION["allrid"],0,length-1); 
		//echo $_SESSION["allrid"];exit;
		$_SESSION["allrid"]="";
		
		if($allrid == null)
		{
			$allrid = $id;
		}
		//echo $allrid;exit;
		
		 $query=$db->query("select rid,count(*) as c from users where rid in(".$allrid.")   group by rid order by c");
		$count=$db->num_rows($query);
		if($count > 0)
		{
			for($i=0;$i<$count;$i++)
			{
			  $row = $db->fetch_array($query);
			  if($row["c"] != 2)
			  {
				  $query=$db->query("select * from users where rid =  ".$row["rid"]."");
				  $result = $db->fetch_array($query);
				  if($result["area"]=="1")
				  {
					  //$pid = $row["pid"];
					  //$area = 2;
					  $_SESSION['autorid'] = $row["rid"];
					  $_SESSION['autoarea'] = 2;
					  break;
				  }
				  else
				  {
					  //$pid = $row["pid"];
					  //$area = "1";	
					  $_SESSION['autorid'] = $row["rid"];
					  $_SESSION['autoarea'] = "1";
					  break;
				  }
			  }
			  else
			  {
				  $query=$db->query("select *  from users where id in(".$allrid.") and id  not in(select rid from users) order by id limit 1");
				  $row = $db->fetch_array($query);
				  //$pid = $row["id"];
				  //$area = "1";
				  $_SESSION['autorid'] = $row["id"];
				  $_SESSION['autoarea'] = "1";
				  break;
			  }
			} 
		} 
		else
		{ 
			//$pid = $_SESSION['id'];
			//$area = "1";
			$_SESSION['autorid'] = $id;
		    $_SESSION['autoarea'] = "1";
		}
		//echo $_SESSION['autorid'].$_SESSION['autoarea'];exit;
	}
	
	//递归获取当前用户下的所有用户  根据rid
	public	function recursive_auto_area($db,$rid)
	{
		$sql = "select * from users where rid = ".$rid."";
		$query = $db->query($sql);
		$count=$db->num_rows($query);
		for($i=0;$i<$count;$i++)
		{
			$row = $db->fetch_array($query);
			$id = $row["id"];
			$_SESSION["allrid"] .= ($rid.",".$id.",");
			self::recursive_auto_area($db,$id);
		}
	}
	
	//根据rid获取被推荐用户数
	function getcount_by_rid($db,$rid)
	{
		$sql = "select * from users where rid = '".$rid."' and states = 1";
		$query = $db->query($sql);
		$result = $db->num_rows($query);
		return $result;
	}
	
	//升级
	function upgrade($db,$uid,$nowgrade,$newgrade)
	{
		$sql = "insert into upgrade(uid,newgrade,gradecount,addtimes) values(".$uid.",".$newgrade.",".($newgrade-$nowgrade).",now())";
		$db->query($sql);
	}
	
	//检测是否有未处理的升级
	function checkupdate_by_uid($db,$uid)
	{
		$sql = "select * from upgrade where uid = ".$uid." and states = 0";
		$query = $db->query($sql);
		$result = $db->num_rows($query);
		return $result;
	}
	
	//根据用户id获取用户升级信息
	public function get_userupgrade_byid($id)
	{
		$sql = "select * from upgrade where id=".$id;
		$db = new DB();
		$db->Connect(DBHOST,DBUSER,DBPW,DBNAME);
		$query = $db->query($sql);
		$result = $db->fetch_array($query);
		return $result;
	}
	
	//进入b网
	public function into_net2($uid,$settle_no)
	{
		$db = new DB();
		$db->Connect(DBHOST,DBUSER,DBPW,DBNAME);
		
		//检查用户是否已在b网
		$sql = "select id from net2 where uid = $uid";
		$query1=$db->query($sql);
		$count1=$db->num_rows($query1);
		if($count1>0)
		{
			return;
		}
		else
		{
			//用户注册自动选择位置与pid
			$pid = "100000";
			$area = "1";
			
			$query=$db->query("select pid,count(*) as c from net2 where pid <> 0   group by pid order by c");
			$count=$db->num_rows($query);
			for($i=0;$i<$count;$i++)
			{
			  $row = $db->fetch_array($query);
			  if($row["c"] != "2")
			  {
				  $pid = $row["pid"];
				  $area = "2";	  
				  break;
			  }
			  else
			  {
				  $query=$db->query("select * from net2 where uid not in(select pid from net2) order by id limit 1");
				  $row = $db->fetch_array($query);
				  $pid = $row["uid"];
				  $area = "1";
				  break;
			  }
			}
			
			$sql = "insert into net2(uid,pid,area) value($uid,$pid,$area)";
			$db->query($sql);
			//共同基金奖(b网见点)
			//见点奖
			$award = new award();
			$award->recursivepid_net2($uid,1,16,$settle_no);

		}
	}

}

/*文章类*/
class article{
	//获取文章信息
	public function get_article($aid)
	{
		$sql = "select * from article where id=".$aid."";
		$db = new DB();
		$db->Connect(DBHOST,DBUSER,DBPW,DBNAME);
		$query = $db->query($sql);
		$result = $db->fetch_array($query);
		return $result;
	}
	//添加文章
	public function add_article($kid,$title,$content)
	{
		$sql = "insert into article(kid,title,content,addtime)values(".$kid.",'".$title."','".$content."',now())";
		$db = new DB();
		$db->Connect(DBHOST,DBUSER,DBPW,DBNAME);
		$query = $db->query($sql);
		$result = 1;
		return $result;
	}
	//修改文章
	public function edit_article($aid,$kid,$title,$content)
	{
		$sql = "update article set kid=".$kid.",title='".$title."',content='".$content."' where id = ".$aid."";
		$db = new DB();
		$db->Connect(DBHOST,DBUSER,DBPW,DBNAME);
		$query = $db->query($sql);
		$result = 1;
		return $result;
	}
	//删除文章
	public function del_article($aid)
	{
		$sql="delete from article where id = ".$aid."";
		$db = new DB();
		$db->Connect(DBHOST,DBUSER,DBPW,DBNAME);
		$query = $db->query($sql);
	}
}

/*功能设置类*/
class bizset{
	//获取功能设置信息
	public function get_bizset($id)
	{
		$sql = "select * from bizset where id=".$id."";
		$db = new DB();
		$db->Connect(DBHOST,DBUSER,DBPW,DBNAME);
		$query = $db->query($sql);
		$result = $db->fetch_array($query);
		return $result;
	}
	//获取功能设置信息bykey
	public function get_bizset_bykey($key)
	{
		$sql = "select * from bizset where bizkey='".$key."'";
		$db = new DB();
		$db->Connect(DBHOST,DBUSER,DBPW,DBNAME);
		$query = $db->query($sql);
		$result = $db->fetch_array($query);
		return $result;
	}
}

/*支付类*/
class payment{
	//获取支付信息
	public function get_payment($id)
	{
		$sql = "select * from payment where id=".$id."";
		$db = new DB();
		$db->Connect(DBHOST,DBUSER,DBPW,DBNAME);
		$query = $db->query($sql);
		$result = $db->fetch_array($query);
		return $result;
	}
}

/*产品类*/
class product{
	//获取产品信息
	public function get_product($id)
	{
		$sql = "select * from product where id=".$id."";
		$db = new DB();
		$db->Connect(DBHOST,DBUSER,DBPW,DBNAME);
		$query = $db->query($sql);
		$result = $db->fetch_array($query);
		return $result;
	}
	
	//获取产品订购信息
	public function get_orderlist($id)
	{
		$sql = "select * from order_list where id=".$id."";
		$db = new DB();
		$db->Connect(DBHOST,DBUSER,DBPW,DBNAME);
		$query = $db->query($sql);
		$result = $db->fetch_array($query);
		return $result;
	}
	
	//获取产品订购信息byuid
	public function get_orderidbyuid($uid)
	{
		$sql = "select id from order_list where uid=".$uid." order by id desc";
		$db = new DB();
		$db->Connect(DBHOST,DBUSER,DBPW,DBNAME);
		$query = $db->query($sql);
		$result = $db->fetch_array($query);
		return $result["id"];
	}
	
	//获取用户订购总数
	public function get_ordercoutbyuid($id)
	{
		$sql = "select sum(count) as sumcount from order_list where uid=".$id." and states=1";
		$db = new DB();
		$db->Connect(DBHOST,DBUSER,DBPW,DBNAME);
		$query = $db->query($sql);
		$result = $db->fetch_array($query);
		$count = $result["sumcount"]==null ? 0 : $result["sumcount"];
		return $count;
	}
}

/*站内短信类*/
class message{
	//获取短信信息
	public function get_message($id)
	{
		$sql = "select * from message where id=".$id."";
		$db = new DB();
		$db->Connect(DBHOST,DBUSER,DBPW,DBNAME);
		$query = $db->query($sql);
		$result = $db->fetch_array($query);
		return $result;
	}
	//获取未读短信数目
	public function get_messagecount_noread($uid)
	{
		$sql = "select * from message where recuid = ".$uid." and states=0";
		$db = new DB();
		$db->Connect(DBHOST,DBUSER,DBPW,DBNAME);
		$query = $db->query($sql);
		$result = $db->num_rows($query);
		return $result;
	}
	//更新站内短信状态
	public function update_message_states($id)
	{
		$sql="update message set states=1 where id = ".$id."";
		$db = new DB();
		$db->Connect(DBHOST,DBUSER,DBPW,DBNAME);
		$query = $db->query($sql);
	}
}

/*奖励类*/
class award{
	//推荐奖
	public function recursiverid($db,$id,$layer,$amount,$type)
	{
		$users = new users();
		$bizset = new  bizset();
		
		$usersinfo = $users->get_user_byid($id);
		$pid = $usersinfo["rid"];
		$usersinfo_r = $users->get_user_byid($pid);
		$productcount = $usersinfo_r["productcount"];
		$bizsetinfo = $bizset->get_bizset_bykey("REC".$productcount);
		$recpercent=$bizsetinfo["bizvalue"];
		$money=$amount*$recpercent;
		if($pid!=0 )
		{ 
			self::recommend($db,$pid,$money,$layer,$type);
			if($layer ==1)
			{
				//收取网络服务费
				$settlement = new settlement();
				$settlement->do_deduction($pid,$money,'NETSERVICE','网络服务费','');
			}
/*			$layer++;
			self::recursiverid($db,$pid,$layer,$amount);*/
		}
	}
	
	//推荐奖income
	public function recommend($db,$id,$money,$layer,$type)
	{
		if($money>0)
		{
			$sql = "insert income(userid,types,amount,addtime,reason,states) values(".$id.",'REC','".$money."',now(),'$type',1)";
			$db->query($sql);
			//为用户增加金额
			/*$sql = "update users set amount = amount + ".$money." where id = ".$id."";
			$db->query($sql);*/
			$settlement = new settlement();
			$settlement->update_user_amount($db,$money,$id);
		}
	}

 
	//见点奖加钱
	public function seepointcommend($db,$id,$money,$layer)
	{
		if($money>0)
		{
			$sql = "insert income(userid,types,amount,addtime,reason,states) values(".$id.",'SEE','".$money."',now(),'见点奖(".$layer."代)',1)";
			$db->query($sql);
			//为用户增加金额
			/*$sql = "update users set amount = amount + ".$money." where id = ".$id."";
			$db->query($sql);*/
			$settlement = new settlement();
			$settlement->update_user_amount($db,$money,$id);
		}
	}
	
	//递归见点奖
	public function recursivepid($db,$id,$layer,$amount)
	{
		$users = new users();
		$bizset = new  bizset();
		
		$usersinfo = $users->get_user_byid($id);
		$pid = $usersinfo["pid"];
		$usersinfo_r = $users->get_user_byid($pid);
		$productcount = $usersinfo_r["productcount"];
		$bizsetinfo = $bizset->get_bizset_bykey("REC".$productcount."_".$layer);
		$recpercent=$bizsetinfo["bizvalue"];
		$bizsetinfo = $bizset->get_bizset_bykey("SEELAYER".$productcount);//见点层数
		$seelayer=$bizsetinfo["bizvalue"];
		$money=$amount*$recpercent;
		if($pid!=0 && $layer<=$seelayer)
		{ 
			self::seepointcommend($db,$pid,$money,$layer);
			if($layer ==1)
			{
				//收取网络服务费
				$settlement = new settlement();
				$settlement->do_deduction($pid,$money,'NETSERVICE','网络服务费','');
			}
			$layer++;
			self::recursivepid($db,$pid,$layer,$amount);
		}
	}
	
	//递归见点奖(b网)
	public function recursivepid_net2($uid,$layer,$layers,$settle_no)
	{
		//获取上层用户等级做见点奖限制
		$users = new users();
		$usersinfo = $users->get_user_byid_net2($uid);
		$pid = $usersinfo["pid"];
		$area = $usersinfo["area"];
		if($pid!="0")
		{
			//按层次见点
			self::seebylayer_net2($pid,$layer,$layers,$settle_no);
			$layer++;
			//递归
			self::recursivepid_net2($pid,$layer,$layers,$settle_no);
		}
	}
	
	//按层次见点
	public function seebylayer($pid,$layer,$layers)
	{
		$bizset = new  bizset();
		//n层见点
		if($layer<=$layers)
		{
			$bizsetinfo = $bizset->get_bizset_bykey("SEE");
			$bizmoney = $bizsetinfo["bizvalue"];
			self::seepointcommend($pid,$bizmoney);
		}
	}
	
	//按层次见点
	public function seebylayer_net2($pid,$layer,$layers,$settle_no)
	{
		$bizset = new  bizset();
		//n层见点
		if($layer<=$layers)
		{
			$bizsetinfo = $bizset->get_bizset_bykey("SEENET2");
			$bizmoney = $bizsetinfo["bizvalue"];
			self::seepointcommend_net2($pid,$bizmoney,$settle_no);
		}
	}
	
	//见点奖限制 针对普通会员 超过30天无法获取隔层见点奖
	public function seerules($id,$layer)
	{
		$sql = "select * from users where states = 1 and to_days(now()) - to_days(addtime) <= 30 and id = ".$id;
		$db = new DB();
		$db->Connect(DBHOST,DBUSER,DBPW,DBNAME);
		$query = $db->query($sql);
		$counts = $db->num_rows($query);
		if($counts > 0)
		{
			//按层次见点
			self::seebylayer($id,$layer);
		}
	}
	
	//代理中心补贴
	public function subsidies($id,$money)
	{
		$sql = "insert income(userid,types,amount,addtime,reason) values(".$id.",'SUBS','".$money."',now(),'服务中心奖励')";
		$db = new DB();
		$db->Connect(DBHOST,DBUSER,DBPW,DBNAME);
		$query = $db->query($sql);
		$result = $db->fetch_array($query);
		return $result;
	}
	
	//群体补偿（对碰奖）封顶处理
	public function check_comtop($uid,$money)
	{
		//获取用户types
		$users = new users();
		$usersinfo = $users->get_user_byid($uid);
		//获取对应群体补偿封顶值
		$bizset = new bizset();
		$bizsetinfo = $bizset->get_bizset_bykey("TOP".$usersinfo["productcount"]);
		if($bizsetinfo["bizvalue"]>$money)//未超过封顶值
		{
			return $money;
		}
		else 
		{
			return $bizsetinfo["bizvalue"];
		}
	}
	
	//隔层见点奖封顶处理
	public function check_seetop($uid,$amount)
	{
		//获取用户类型
		$users = new users();
		$bizset = new bizset();
		$usersinfo = $users->get_user_byid($uid);
		$level = $usersinfo["productcount"];//普通用户1 VIP用户2
		
		//获取发展用户数
		$usercount = $users->get_usercount_byrid($uid);

		//获取用户累计见点奖金额
		$db = new DB();
		$db->Connect(DBHOST,DBUSER,DBPW,DBNAME);
		$sql = "select sum(amount) as amount from income where states =1 and types = 'SEE' and userid = ".$uid."";
		$query = $db->query($sql);
		$result = $db->fetch_array($query);
		$see_allmoney =  $result["amount"];//累计见点奖金额
		
		if($level == 1)
		{
			if($usercount>=4)
			{
				$usercount = 4;
			}
			
			$bizsetinfo = $bizset->get_bizset_bykey("SEETOPC".$usercount);
			$topmoney = $bizsetinfo["bizvalue"];//见点奖封顶金额
			
			if(($see_allmoney + $amount)>$topmoney)
			{
				$resultmoney = $topmoney - $see_allmoney;
			}
			else
			{
				$resultmoney = $amount;
			}
		}
		elseif($level == 2)
		{
			if($usercount>=2)
			{
				$usercount = 2;
			}
			
			$bizsetinfo = $bizset->get_bizset_bykey("SEETOPV".$usercount);
			$topmoney = $bizsetinfo["bizvalue"];
			
			if(($see_allmoney + $amount)>$topmoney)
			{
				$resultmoney = $topmoney - $see_allmoney;
			}
			else
			{
				$resultmoney = $amount;
			}
		}
		return $resultmoney;

	}
	
	//推荐奖封顶处理
	public function check_rectop($uid,$amount)
	{
		//获取用户类型
		$users = new users();
		$bizset = new bizset();
		$usersinfo = $users->get_user_byid($uid);

		//获取用户累计推荐奖金额
		$db = new DB();
		$db->Connect(DBHOST,DBUSER,DBPW,DBNAME);
		$sql = "select sum(amount) as amount from income where states =1 and types = 'REC' and userid = ".$uid."";
		$query = $db->query($sql);
		$result = $db->fetch_array($query);
		$rec_allmoney =  $result["amount"];//累计推荐奖金额

		$bizsetinfo = $bizset->get_bizset_bykey("RECPERCENTTOP");
		$topmoney = $bizsetinfo["bizvalue"];//推荐奖封顶金额
		
		if(($rec_allmoney + $amount)>$topmoney)
		{
			$resultmoney = $topmoney - $rec_allmoney;
		}
		else
		{
			$resultmoney = $amount;
		}
		
		return $resultmoney;
	}
	
	//奖金封顶处理
	public function check_awardtop($uid,$money)
	{
		//获取用户types
		$users = new users();
		$usersinfo = $users->get_user_byid($uid);
		//获取对应封顶值
		$bizset = new bizset();
		$bizsetinfo = $bizset->get_bizset_bykey("TOP".$usersinfo["productcount"]);
		if($bizsetinfo["bizvalue"]>$money)//未超过封顶值
		{
			return $money;
		}
		else 
		{
			return $bizsetinfo["bizvalue"];
		}
	}

	//更新user_sub_count
	public function update_user_sub_count($db,$id,$remaincount,$area)
	{
		if($area =="1")
		{
			$sql = "update user_sub_count set count_1 = ".$remaincount.", count_2 = 0 where uid = ".$id." ";
		}
		if($area =="2")
		{
			$sql = "update user_sub_count set count_2 = ".$remaincount.", count_1 = 0 where uid = ".$id." ";
		}
		if($area =="0")
		{
			$sql = "update user_sub_count set count_2 = 0, count_1 = 0 where uid = ".$id." ";
		}
		$query = $db->query($sql);
	}
	
	//会员群体补偿
	public function recursive_user_info($db,$settle_no)
	{
		//获取用户types
		$users = new users();
		
		//获取群体补偿单价
		$bizset = new bizset();
		
		//遍历群体对碰数据
 		$sql = "select * from user_sub_count where count_1>0 and count_2>0";
		$query = $db->query($sql);
		$rowcount = $db->num_rows($query);
		for($i=0;$i<$rowcount;$i++)
		{
			$result = $db->fetch_array($query);
			$count_left =  $result["count_1"];
			$count_right = $result["count_2"];
			$uid = $result["uid"];
			$usersinfo = $users->get_user_byid($uid);
			//获取推荐用户数
			/*$reccount = $users->getcount_by_rid($db,$uid);
			if($reccount==2 || $reccount==3)
			{
				$bizsetinfo = $bizset->get_bizset_bykey("COM".$reccount);
			}
			else if($reccount>=4)
			{
				$bizsetinfo = $bizset->get_bizset_bykey("COM4");
			}*/
			$bizsetinfo = $bizset->get_bizset_bykey("COM");
			$comprice = $bizsetinfo["bizvalue"];
			if($count_left > $count_right)
			{
				$remaincount = $count_left - $count_right;//对碰后剩余一方的用户数
				$money = $count_right * $comprice;
				//对碰奖封顶处理
				//$money = self::check_comtop($uid,$money);
				//插入income
				$sql = "insert income(userid,types,amount,addtime,reason,states,settlementno) values(".$uid.",'COM','".$money."',now(),'对碰奖',1,'$settle_no')";
				$db->query($sql);
				//更新user_sub_count
			    self::update_user_sub_count($db,$uid,$remaincount,"1");
			}
			else if($count_left < $count_right)
			{
				$remaincount = $count_right - $count_left;//对碰后剩余一方的用户数
				$money = $count_left * $comprice;
				//对碰奖封顶处理
				//$money = self::check_comtop($uid,$money);
				//插入income
				$sql = "insert income(userid,types,amount,addtime,reason,states,settlementno) values(".$uid.",'COM','".$money."',now(),'对碰奖',1,'$settle_no')";
				$db->query($sql);
				//更新user_sub_count
			    self::update_user_sub_count($db,$uid,$remaincount,"2");
			}
			else if($count_left == $count_right)
			{
				$remaincount = 0;//对碰后剩余一方的用户数
				$money = $count_left * $comprice;
				//对碰奖封顶处理
				//$money = self::check_comtop($uid,$money);
				//插入income
				$sql = "insert income(userid,types,amount,addtime,reason,states,settlementno) values(".$uid.",'COM','".$money."',now(),'对碰奖',1,'$settle_no')";
				$db->query($sql);
				//更新user_sub_count
			    self::update_user_sub_count($db,$uid,$remaincount,"0");
			}
			
			$settlement = new settlement();
			//为用户增加金额
			$money = $settlement->update_user_amount($db,$money,$uid,$settle_no);
			//税费
			$settlement->do_deduction($uid,$money,'TAX','税费',$settle_no);
			//管理费
			$settlement->do_deduction_1($uid,'MANAGE','管理费',$settle_no);
			//旅游基金
			$settlement->do_deduction($uid,$money,'TFUND','旅游基金',$settle_no);
		}
	}
}


/*提现类*/
class getamount{
	//获取提现记录信息
	public function get_amount($id)
	{
		$sql = "select * from getamount where id=".$id."";
		$db = new DB();
		$db->Connect(DBHOST,DBUSER,DBPW,DBNAME);
		$query = $db->query($sql);
		$result = $db->fetch_array($query);
		return $result;
	}
	//获取基金记录信息
	public function fund_amount($id)
	{
		$sql = "select * from fundamount where id=".$id."";
		$db = new DB();
		$db->Connect(DBHOST,DBUSER,DBPW,DBNAME);
		$query = $db->query($sql);
		$result = $db->fetch_array($query);
		return $result;
	}
}

/*权限类*/
class power{
	//根据用户types获取权限列表
	public function get_power($tid)
	{
		$sql = "select * from power where tid=".$tid."";
		$db = new DB();
		$db->Connect(DBHOST,DBUSER,DBPW,DBNAME);
		$query = $db->query($sql);
		$result = $db->fetch_array($query);
		return $result;
	}
	//根据页面文件名判断是否有权限
	public function get_power_byfilename($filename,$tid)
	{
		$db = new DB();
		$db->Connect(DBHOST,DBUSER,DBPW,DBNAME);
		$sql = "select id from nav where url = '".$filename."'";
		$query = $db->query($sql);
		$result = $db->fetch_array($query);
		$pageid=$result["id"];
		$powerinfo=self::get_power($tid);
		$not_powerlist=split(",",$powerinfo["not_power"]);
		for($i=0;$i<count($not_powerlist);$i++)
		{
			if($pageid==$not_powerlist[$i])
			{
				return "no";
			}
		}
		return "yes";
	}
	//获取nav信息
	public function get_nav($filename)
	{
		$sql = "select * from nav where url = '".$filename."'";
		$db = new DB();
		$db->Connect(DBHOST,DBUSER,DBPW,DBNAME);
		$query = $db->query($sql);
		$result = $db->fetch_array($query);
		return $result;
	}
}

/*股票类*/
class stock{
	public function get_stockconfig($id)
	{
		$db = new DB();
		$db->Connect(DBHOST,DBUSER,DBPW,DBNAME);
		$sql = "select * from stock where id=$id";
		$query = $db->query($sql);
		$result = $db->fetch_array($query);
		return $result;
	}
	
	public function get_stock_results_config($id)
	{
		$db = new DB();
		$db->Connect(DBHOST,DBUSER,DBPW,DBNAME);
		$sql = "select * from stock_results_config where id=$id";
		$query = $db->query($sql);
		$result = $db->fetch_array($query);
		return $result;
	}
	
	public function get_newprice($sid)
	{
		$db = new DB();
		$db->Connect(DBHOST,DBUSER,DBPW,DBNAME);
		$sql = "select price from stock_price where sid=$sid order by id desc";
		$query = $db->query($sql);
		$result = $db->fetch_array($query);
		return $result["price"];
	}
	
	public function get_stockprice($id)
	{
		$db = new DB();
		$db->Connect(DBHOST,DBUSER,DBPW,DBNAME);
		$sql = "select * from stock_price where id = $id";
		$query = $db->query($sql);
		$result = $db->fetch_array($query);
		return $result;
	}
	
	public function get_stockpricelist($sid)
	{
		$db = new DB();
		$db->Connect(DBHOST,DBUSER,DBPW,DBNAME);
		$sql = "select * from stock_price where sid = $sid";
		$query = $db->query($sql);
		$count = $db->num_rows($query);
		for($i=0;$i<$count;$i++)
		{
			$result = $db->fetch_array($query);
			$data .= $result["price"].',';
		}
		return $data;
	}
	
	public function get_stockpricetimelist($sid)
	{
		$db = new DB();
		$db->Connect(DBHOST,DBUSER,DBPW,DBNAME);
		$sql = "select * from stock_price where sid = $sid";
		$query = $db->query($sql);
		$count = $db->num_rows($query);
		for($i=0;$i<$count;$i++)
		{
			$result = $db->fetch_array($query);
			$data .= $result["addtime"].',';
		}
		return $data;
	}
	
	public function get_stockvolumelist($sid)
	{
		$db = new DB();
		$db->Connect(DBHOST,DBUSER,DBPW,DBNAME);
		$sql = "select * from stock_price where sid = $sid";
		$query = $db->query($sql);
		$count = $db->num_rows($query);
		for($i=0;$i<$count;$i++)
		{
			$result = $db->fetch_array($query);
			$data .= $result["volume"].',';
		}
		return $data;
	}
	
	public function update_stockconfig($id,$code,$names,$counts,$issue_price,$states,$closedate,$fee,$mincount)
	{
		$db = new DB();
		$db->Connect(DBHOST,DBUSER,DBPW,DBNAME);
		$sql = "update stock set code='$code',names='$names',counts=$counts,issue_price=$issue_price,states=$states,closedate=$closedate,fee=$fee,mincount=$mincount where id=$id";
		$db->query($sql);
	}
	
	public function update_stockresultconfig($id,$sell5_price,$sell5_sum,$sell4_price,$sell4_sum,$sell3_price,$sell3_sum,$sell2_price,$sell2_sum,$sell1_price,$sell1_sum,$buy1_price,$buy1_sum,$buy2_price,$buy2_sum,$buy3_price,$buy3_sum,$buy4_price,$buy4_sum,$buy5_price,$buy5_sum,$newprice,$openprice,$huanshou,$topprice,$zhangfu,$diefu,$zhangting,$dieting,$y_price_green,$y_price_white,$y_price_red,$y_sum)
	{
		$db = new DB();
		$db->Connect(DBHOST,DBUSER,DBPW,DBNAME);
		$sql = "update stock_results_config set ".			
		"sell5_price='$sell5_price',sell5_sum='$sell5_sum',".
		"sell4_price='$sell4_price',sell4_sum='$sell4_sum',".
		"sell3_price='$sell3_price',sell3_sum='$sell3_sum',".
		"sell2_price='$sell2_price',sell2_sum='$sell2_sum',".
		"sell1_price='$sell1_price',sell1_sum='$sell1_sum',".
		
		"buy5_price='$buy5_price',buy5_sum='$buy5_sum',".
		"buy4_price='$buy4_price',buy4_sum='$buy4_sum',".
		"buy3_price='$buy3_price',buy3_sum='$buy3_sum',".
		"buy2_price='$buy2_price',buy2_sum='$buy2_sum',".
		"buy1_price='$buy1_price',buy1_sum='$buy1_sum',".
		
		"newprice='$newprice',openprice='$openprice',".
		"huanshou='$huanshou',topprice='$topprice',".
		"zhangfu='$zhangfu',diefu='$diefu',".
		"zhangting='$zhangting',dieting='$dieting',".
		"y_price_green='$y_price_green',y_price_white='$y_price_white',".
		"y_price_red='$y_price_red',y_sum='$y_sum'".
		" where id=$id";
		$db->query($sql);
	}
	
	public function add_stockprice($sid,$price,$addtime,$volume)
	{
		$db = new DB();
		$db->Connect(DBHOST,DBUSER,DBPW,DBNAME);
		$sql = "insert into stock_price(sid,price,addtime,volume) values($sid,$price,'$addtime',$volume)";
		$db->query($sql);
	}
	
	public function edit_stockprice($id,$sid,$price,$addtime,$volume)
	{
		$db = new DB();
		$db->Connect(DBHOST,DBUSER,DBPW,DBNAME);
		$sql = "Replace into stock_price(id,sid,price,addtime,volume) values($id,$sid,$price,'$addtime',$volume)";
		$db->query($sql);
	}
	
	public function del_stockprice($id)
	{
		$db = new DB();
		$db->Connect(DBHOST,DBUSER,DBPW,DBNAME);
		$sql = "delete from stock_price where id = $id";
		$db->query($sql);
	}
	
	public function buy_stock($sid,$uid,$price,$count)
	{
		$db = new DB();
		$db->Connect(DBHOST,DBUSER,DBPW,DBNAME);
		$sql = "insert stock_trans_list(sid,uid,price,count,addtime,type) value($sid,$uid,$price,$count,now(),'买入')";
		$db->query($sql);
		$sql = "update stock set counts = counts-$count where id=$sid";
		$db->query($sql);
		//扣钱
		$sumprice = $price*$count;
		$sql = "insert income(userid,types,amount,addtime,reason,states,settlementno) values(".$uid.",'BUYSTOCK','-".$sumprice."',now(),'购买股票',2,'')";
		$db->query($sql);
		$sql = "update users set inputamount = inputamount-$sumprice,stock=stock+$count where id=$uid";
		$db->query($sql);
		
		//购买股票产生见点奖 根据投资总额
		$stockinfo = new stock();
		$award = new award();
		/*$stock_price = $stockinfo->get_newprice(1);
		$amount = $count*$stock_price;*/
		$award->recursivepid($db,$uid,1,$sumprice);
	}
	
	public function sell_stock($sid,$uid,$price,$count)
	{
		$db = new DB();
		$db->Connect(DBHOST,DBUSER,DBPW,DBNAME);
		$sql = "insert stock_trans_list(sid,uid,price,count,addtime,type) value($sid,$uid,$price,-$count,now(),'沽出')";
		$db->query($sql);
		$sql = "update stock set counts = counts+$count where id=$sid";
		$db->query($sql);
		//加钱
		$sumprice = $price*$count;
		$sql = "insert income(userid,types,amount,addtime,reason,states,settlementno) values(".$uid.",'BUYSTOCK','".$sumprice."',now(),'沽出股票',2,'')";
		$db->query($sql);
		$sql = "update users set inputamount = inputamount+$sumprice,stock=stock-$count where id=$uid";
		$db->query($sql);
	}
	
	public function get_firstbuystockdate($uid)
	{
		$db = new DB();
		$db->Connect(DBHOST,DBUSER,DBPW,DBNAME);
		$sql = "select addtime from stock_trans_list where uid = $uid and type = '首次购买股票'";
		$query = $db->query($sql);
		$result = $db->fetch_array($query);
		return substr($result["addtime"],0,10);
	}
	//拆股
	public function split_stock($split_num,$sid)
	{
		$db = new DB();
		$db->Connect(DBHOST,DBUSER,DBPW,DBNAME);
		//系统总股仓更新
		$stock = new stock();
		$stockconfig = $stock->get_stockconfig(1);
		$allsotckcount = $stockconfig["counts"];	
		$sql = "update stock set counts = $allsotckcount*$split_num  where id=$sid";
		$db->query($sql);
		
		//股价更新
		$sql = "select * from stock_price where sid = $sid  order by id desc limit 1";
		$query = $db->query($sql);
		$result = $db->fetch_array($query);
		$now_price = $result["price"];
		$now_price_id = $result["id"];
		$split_price = $now_price/$split_num;
		$sql = "update stock_price set price = $split_price where id=$now_price_id";
		$db->query($sql);
		
		//用户股票更新
		$sql = "select * from users where states = 1 ";
		$query=$db->query($sql);
		$count=$db->num_rows($query);
	  	for($i=0;$i<$count;$i++)
	  	{
			$row = $db->fetch_array($query);
			$uid = $row["id"];
			$old_stock = $row["stock"];
			
			$new_stock = $old_stock*$split_num;

			//更新user stock
			$sql = "update users set stock=".$new_stock." where id=$uid";
			$db->query($sql);
			
		}
		
	}
}

/*结算类*/
class settlement{
	//获取最新结算号
	public function get_settle_no()
	{
		$sql = "select numbers from settlement order by id desc";
		$db = new DB();
		$db->Connect(DBHOST,DBUSER,DBPW,DBNAME);
		$query = $db->query($sql);
		$result = $db->fetch_array($query);
		$id = $result["numbers"];
		return $id;
	}
	//扣减
	public function do_deduction($uid,$amount,$type,$typeinfo,$settle_no)
	{
		$bizset = new bizset();
		$bizsetinfo = $bizset->get_bizset_bykey($type);//获取扣减项目对象
		$percent = $bizsetinfo["bizvalue"];//扣减比例
		$manageprice =  $amount * $percent;//扣除的费用
		$db = new DB();
		$db->Connect(DBHOST,DBUSER,DBPW,DBNAME);
		if($manageprice>0)
		{
			//插入income
			$sql = "insert income(userid,types,amount,addtime,reason,states,settlementno) values(".$uid.",'".$type."','-".$manageprice."',now(),'".$typeinfo."',2,'$settle_no')";
			$db->query($sql);
			//为用户扣减金额
			$sql = "update users set amount = amount - ".$manageprice." where id = ".$uid."";
			$db->query($sql);
		}
	}
	
	//一次性的扣减
	public function do_deduction_1($uid,$type,$typeinfo,$settle_no)
	{
		$db = new DB();
		$db->Connect(DBHOST,DBUSER,DBPW,DBNAME);
		$bizset = new bizset();
		$bizsetinfo = $bizset->get_bizset_bykey($type);//获取扣减项目对象
		$percent = $bizsetinfo["bizvalue"];//扣减比例
		$manageprice =  $percent;//扣除的费用
		//检查奖金是否达到扣款数
		$users = new users();
		$usersinfo = $users->get_user_byid($uid);
		if($usersinfo["amount"]<100)
		{
			return;
		}
		//检查是否已经扣过
		$sql = "select sum(amount) as sumamount from income where types='$type' and userid=$uid";
		$query_sumamount=$db->query($sql);
		$row = $db->fetch_array($query_sumamount);
		if(-$row["sumamount"]>=100){
			return;
		}
		
		if($manageprice>0)
		{
			//插入income
			$sql = "insert income(userid,types,amount,addtime,reason,states,settlementno) values(".$uid.",'".$type."','-".$manageprice."',now(),'".$typeinfo."',2,'$settle_no')";
			$db->query($sql);
			//为用户扣减金额
			$sql = "update users set amount = amount - ".$manageprice." where id = ".$uid."";
			$db->query($sql);
		}
	}
	
	////执行结算 分红 按照该级别的所有投资总和 
	public function do_settle($db)
	{
		//按级别分红
		self::divi_settle($db,1);
		self::divi_settle($db,2);
		self::divi_settle($db,3);
		self::divi_settle($db,4);
		
/*		//达标团队加权平均分红奖
		$bizset = new bizset();
		$bizsetinfo = $bizset->get_bizset_bykey("STANDARD");//达标业绩个数
		$standardcount = $bizsetinfo["bizvalue"];
		self::standard_settle($db,$standardcount);*/
		
		//获取最新结算号
		/*$settle_no = self::get_settle_no();
		//更新结算状态变成已结算，并将结算期号增加到income表
		$sql="update income set states = 1,settlementno = '". $settle_no."' where states = 1 and (settlementno is null or settlementno='')  ";
		$db->query($sql);
		 //将本次结算设置为已结算
		 $sql = "update settlement set states = 1 where numbers = '".$settle_no."'";
		 $db->query($sql);*/
		 
		//写入日志
		savelog($db,"执行结算成功");
		 
		return "ok";
	}
	
	//执行周结算
	public function do_settle2($db)
	{
		//达标团队加权平均分红奖
		$bizset = new bizset();
		$bizsetinfo = $bizset->get_bizset_bykey("STANDARD");//达标业绩个数
		$standardcount = $bizsetinfo["bizvalue"];
		self::standard_settle($db,$standardcount);
		
		//写入日志
		savelog($db,"执行结算成功");
		 
		return "ok";
	}
	
	//按级别分红 月度分红
	public function divi_settle($db,$level)
	{
		$users = new users();
		$bizset = new bizset();
		$award = new award();

		//获取最新结算号
		$settle_no = self::get_settle_no();
		//按级别分红
		$bizsetinfo = $bizset->get_bizset_bykey("DIVIDEND".$level);//根据级别获取分红比例
		$recpercent=$bizsetinfo["bizvalue"];
		
		//当前级别总营业额的分红按比例 
	    //$query=$db->query("select sum(amount) as amount  from income where states = 1  and (settlementno is null or settlementno='') and  userid in (select id from users where productcount = $level) ");
		//本月日期
		$day_begin = date('Y-m-d', mktime(0,0,0,date('n'),1,date('Y')));
		$day_end = date('Y-m-d H:i:s', mktime(0,0,0,date('n'),date('t'),date('Y')));
		//H=本月股票销售额
		$query=$db->query("select abs(sum(amount)) as amount  from income where types='BUYSTOCK' and  addtime >='$day_begin' and addtime <='".$day_end." 23:59:59"."'"); 
		$result = $db->fetch_array($query);
		$allamount = $result["amount"];
		$dividendamount = $allamount*$recpercent;
 
		//K=某投资级别所有投资者从开始到结算时的投资总和
		$query=$db->query("select abs(sum(amount)) as amount  from income where types='BUYSTOCK' and  addtime >='$day_begin' and addtime <='".$day_end." 23:59:59"."' and userid in(select id from users where productcount = $level)"); 
		$result = $db->fetch_array($query);
		$allamount_level = $result["amount"];
		
		//L=某投资级别本月的月分红系数=H/K
		if($allamount_level>0)
		{
			$percent_level = $dividendamount/$allamount_level;
		}
		
		//Q=该级别某个股东本月的投资补贴(月分红)=该股东的投资额*L
		//根据等级 遍历users 
		$query=$db->query("select * from users where states = 1 and productcount = $level");
	  	$count=$db->num_rows($query);
		
	  	for($i=0;$i<$count;$i++)
	  	{
			$row = $db->fetch_array($query);
			$uid = $row["id"];
			
			//获取投资者当月投资额
			$query_user = $db->query("select abs(sum(amount)) as amount  from income where types='BUYSTOCK' and  addtime >='$day_begin' and addtime <='".$day_end." 23:59:59"."' and userid = $uid"); 
			$result_user = $db->fetch_array($query_user);
			$allamount_user = $result_user["amount"];
			
			if($allamount_user>0)
			{
				$resultmoney = $allamount_user*$percent_level;
			}
			else
			{
				$resultmoney = 0;
			}
			if($resultmoney>0)
			{
				//插入income
				$sql = "insert income(userid,types,amount,addtime,reason,states,settlementno) values(".$uid.",'DIVI','".$resultmoney."',now(),'加权分红',1,'$settle_no')";
				$db->query($sql);
				//为用户增加金额
				$settlement = new settlement();
				$settlement->update_user_amount($db,$resultmoney,$uid);	
			}
			//更新结算状态变成已结算，并将结算期号增加到income表
			$sql="update income set states = 1,settlementno = '". $settle_no."' where states = 1 and (settlementno is null or settlementno='') and userid =$uid ";
			$db->query($sql);
		 }
		 //将本次结算设置为已结算
		 $sql = "update settlement set states = 1 where numbers = '".$settle_no."'";
		 $db->query($sql);
	}
	
	//达标团队加权平均分红奖
	public function standard_settle($db,$standardcount)
	{ 
		$users = new users();
		$bizset = new bizset();
		$award = new award();
		
		//获取最新结算号
		$settle_no = self::get_settle_no();
		//获取最新股价
		$stockinfo = new stock();
		$new_price = $stockinfo->get_newprice(1);
		
		//根据等级获取达标金额
		$bizsetinfo = $bizset->get_bizset_bykey("STANDARD_PRICE2");
		$standard_price2 = $bizsetinfo["bizvalue"];
		$bizsetinfo = $bizset->get_bizset_bykey("STANDARD_PRICE3");
		$standard_price3 = $bizsetinfo["bizvalue"];
		$bizsetinfo = $bizset->get_bizset_bykey("STANDARD_PRICE4");
		$standard_price4 = $bizsetinfo["bizvalue"];
		$bizsetinfo = $bizset->get_bizset_bykey("STANDARD_PRICE5");
		$standard_price5 = $bizsetinfo["bizvalue"];
		$bizsetinfo = $bizset->get_bizset_bykey("STANDARD_PRICE6");
		$standard_price6 = $bizsetinfo["bizvalue"];
		$bizsetinfo = $bizset->get_bizset_bykey("STANDARD_PRICE7");
		$standard_price7 = $bizsetinfo["bizvalue"];
		$bizsetinfo = $bizset->get_bizset_bykey("STANDARD_PRICE8");
		$standard_price8 = $bizsetinfo["bizvalue"];
		$bizsetinfo = $bizset->get_bizset_bykey("STANDARD_PRICE9");
		$standard_price9 = $bizsetinfo["bizvalue"];
		$bizsetinfo = $bizset->get_bizset_bykey("STANDARD_PRICE10");
		$standard_price10 = $bizsetinfo["bizvalue"];
		$bizsetinfo = $bizset->get_bizset_bykey("STANDARD_PRICE11");
		$standard_price11 = $bizsetinfo["bizvalue"];
		
		//根据等级获取达标分红比例
		$bizsetinfo = $bizset->get_bizset_bykey("STANDARD_PERCENT2");
		$standard_percent2 = $bizsetinfo["bizvalue"];
		$bizsetinfo = $bizset->get_bizset_bykey("STANDARD_PERCENT3");
		$standard_percent3 = $bizsetinfo["bizvalue"];
		$bizsetinfo = $bizset->get_bizset_bykey("STANDARD_PERCENT4");
		$standard_percent4 = $bizsetinfo["bizvalue"];
		$bizsetinfo = $bizset->get_bizset_bykey("STANDARD_PERCENT5");
		$standard_percent5 = $bizsetinfo["bizvalue"];
		$bizsetinfo = $bizset->get_bizset_bykey("STANDARD_PERCENT6");
		$standard_percent6 = $bizsetinfo["bizvalue"];
		$bizsetinfo = $bizset->get_bizset_bykey("STANDARD_PERCENT7");
		$standard_percent7 = $bizsetinfo["bizvalue"];
		$bizsetinfo = $bizset->get_bizset_bykey("STANDARD_PERCENT8");
		$standard_percent8 = $bizsetinfo["bizvalue"];
		$bizsetinfo = $bizset->get_bizset_bykey("STANDARD_PERCENT9");
		$standard_percent9 = $bizsetinfo["bizvalue"];
		$bizsetinfo = $bizset->get_bizset_bykey("STANDARD_PERCENT10");
		$standard_percent10 = $bizsetinfo["bizvalue"];
		$bizsetinfo = $bizset->get_bizset_bykey("STANDARD_PERCENT11");
		$standard_percent11 = $bizsetinfo["bizvalue"];
		
		 //遍历users 
		$query=$db->query("select * from users where states = 1");
	  	$count=$db->num_rows($query);
	  	for($i=0;$i<$count;$i++)
	  	{
			$row = $db->fetch_array($query);
			$uid = $row["id"];
			$usersinfo = $users->get_user_byid($uid);
			$stock = $usersinfo["stock"];
			 
			//用户投资额
			//$user_stock_price = $stock*$new_price;
			//获取达标个数
			$pidcount = $users->get_usercount_bypid($uid);
			if($pidcount == $standardcount)
			{
				//判断三个市场是否都达标 获取达标系数
				$sql_standard = "select * from users where states = 1 and pid = ".$uid;
				$query_standard = $db->query($sql_standard);
						
				for($i=0;$i<$standardcount;$i++)
	  			{
					$row_standard = $db->fetch_array($query_standard);
					$uid_standard = $row_standard["id"];
		
					$usersids = $users->getrecursiveallusersid($uid_standard);
					$usersids = substr($usersids,0,strlen($usersids)-1);
					if (strlen($usersids) <= 0)  $usersids = "0";
					
					if($usersids != "0")
					{
						//$sql = "select sum(stock) as price from users where id in ($usersids) ";
						//获取投资者投资额
						$sql ="select abs(sum(amount)) as price  from income where types='BUYSTOCK' and userid = $uid"; 
						$query_s = $db->query($sql);
						$result = $db->fetch_array($query_s);
						$sumamount = $result["price"];

						//用户投资额
						//$sumamount = $sumamount*$new_price;
						//达标分红比例
						if($sumamount >= $standard_price11)
						{
							$percent = $standard_percent11;
							$standard_amout = $standard_price11;
						}
						else if($sumamount >= $standard_price10)
						{
							$percent = $standard_percent10;
							$standard_amout = $standard_price10;
						}
						else if($sumamount >= $standard_price9)
						{
							$percent = $standard_percent9;
							$standard_amout = $standard_price9;
						}
						else if($sumamount >= $standard_price8)
						{
							$percent = $standard_percent8;
							$standard_amout = $standard_price8;
						}
						else if($sumamount >= $standard_price7)
						{
							$percent = $standard_percent7;
							$standard_amout = $standard_price7;
						}
						else if($sumamount >= $standard_price6)
						{
							$percent = $standard_percent6;
							$standard_amout = $standard_price6;
						}
						else if($sumamount >= $standard_price5)
						{
							$percent = $standard_percent5;
							$standard_amout = $standard_price5;
						}
						else if($sumamount >= $standard_price4)
						{
							$percent = $standard_percent4;
							$standard_amout = $standard_price4;
						}
						else if($sumamount >= $standard_price3)
						{
							$percent = $standard_percent3;
							$standard_amout = $standard_price3;
						}
						else if($sumamount >= $standard_price2)
						{
							$percent = $standard_percent2;
							$standard_amout = $standard_price2;
						}
						else
						{
							$percent = 0;
							break;
						}
					}
				}					
				//根据分红比例加权分红
				$usersids_all = $users->getrecursiveallusersid($uid);
				$usersids_all = substr($usersids_all,0,strlen($usersids_all)-1);
				if (strlen($usersids_all) <= 0)  $usersids_all = "0";	
				if($usersids_all != "0" && $percent>0)
				{
					self::award_standard_settle($db,$uid,$usersids_all,$percent,$settle_no,$standard_amout);
				}
			}	
			 //更新结算状态变成已结算，并将结算期号增加到income表
			$sql="update income set  settlementno = '". $settle_no."' where  (settlementno is null or settlementno='') and userid =$uid ";
			$db->query($sql);
		}
		 //将本次结算设置为已结算
		 $sql = "update settlement set states = 1 where numbers = '".$settle_no."'";
		 $db->query($sql);
	}
	
	//根据分红比例加权分红
	public function award_standard_settle($db,$uid,$usersids,$percent,$settle_no,$standard_amout)
	{ 
		$users = new users();
		$bizset = new bizset();
		$award = new award();
	
		//本期公司总的新增业绩
		//$query=$db->query("select sum(amount) as amount  from income where states = 1  and (settlementno is null or settlementno='')  ");
		//本周股票销售额
		$query=$db->query("select abs(sum(amount)) as amount  from income where types='BUYSTOCK' and (settlementno is null or settlementno='') "); 
		$result = $db->fetch_array($query);
		$allamount = $result["amount"];
		
		//A=该级别会员本期团队新增业绩
		$query=$db->query("select abs(sum(amount)) as amount  from income where types='BUYSTOCK'  and (settlementno is null or settlementno='') and  userid = $uid ");
		$result = $db->fetch_array($query);
		$useramount = $result["amount"];
		
		//B=同级别所有会员本期团队新增业绩的总和  
	  	//$query=$db->query("select abs(sum(amount)) as amount  from income where types='BUYSTOCK'  and (settlementno is null or settlementno='') and  userid in ($usersids) ");
		$query=$db->query("select abs(sum(amount)) as amount  from income where types='BUYSTOCK'  and (settlementno is null or settlementno='') and  abs(amount)>=$standard_amout ");
		$result = $db->fetch_array($query);
		$this_amount = $result["amount"];

		//C=本级别的本期分红总额=本期公司总的新增业绩*本级别的加权平均分红奖比例
		$dividendamount = $allamount*$percent;

		//D=某会员的的加权平均分红奖=（C/B）*A
		if($this_amount>0)
		{
			$dividend_user_amount = ($dividendamount/$this_amount)*$useramount;
		}
		
		if($dividend_user_amount>0)
		{
			//插入income
			$sql = "insert income(userid,types,amount,addtime,reason,states,settlementno) values(".$uid.",'STANDARD','".$dividend_user_amount."',now(),'达标团队分红奖',1,'$settle_no')";
			$db->query($sql);
			//为用户增加金额
			$settlement = new settlement();
			$settlement->update_user_amount($db,$dividend_user_amount,$uid);	
		}
	}
	
	
	//插入到结算结果表settle_result
	public function settle_result($db,$type,$uid,$amount,$settelmentno)
	{
		//判断同类记录是否存在
		$sql = "select id from settle_result where type='".$type."' and uid = ".$uid." and settelmentno = '".$settelmentno."'";
		$query_f = $db->query($sql);
		if($db->num_rows($query_f)>0)
		{
			$sql = "update settle_result set amount=amount+".$amount." where type='".$type."' and uid = ".$uid." and settelmentno = '".$settelmentno."'";
		}
		else
		{
			$sql = "insert into settle_result(type,uid,amount,settelmentno)values('".$type."',".$uid.",".$amount.",'".$settelmentno."')";
		}
		$db->query($sql);
	}
	
	//为用户增加金额
	public function update_user_amount($db,$resultmoney,$uid)
	{
		//$sql="select sum(amount) sumamount from income where userid = ".$uid." and left(addtime,10) = date(now()) and states=1";
		$sql="select sum(amount) sumamount from income where userid = ".$uid." and states=1";
		$query_amount = $db->query($sql);
		$result = $db->fetch_array($query_amount);
		$sumamount = $result["sumamount"];
		if($sumamount == "")
		{
			$sumamount = 0;
		}
		$users = new users();
		$usersinfo = $users->get_user_byid($uid);
		$bizset=new bizset();
		$bizsetinfo=$bizset->get_bizset_bykey("TOP".$usersinfo["productcount"]);
		$topmoney=$bizsetinfo["bizvalue"];
		
		if(($sumamount+$resultmoney)>$topmoney)
		{
			$resultmoney = $topmoney-$sumamount;
		}
		
		if($resultmoney>0)
		{
			$sql = "update users set amount = amount + ".$resultmoney." where id = ".$uid."";
			$db->query($sql);
			//个人收入扣税
			$settlement = new settlement();
			$settlement->do_deduction($uid,$resultmoney,'TAX','个人收入扣税','');
			return $resultmoney;
		}
		else
		{
			return 0;
		}
	}
}
?>