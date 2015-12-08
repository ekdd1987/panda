<?php
include("../Admin.php");
include("../../includes/conn.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<LINK href="../Admin_STYLE.CSS" rel=stylesheet type=text/css>
<title>无标题文档</title>
<SCRIPT language=javascript>

function CheckAll(form)
  {
  for (var i=0;i<form.elements.length;i++)
    {
    var e = form.elements[i];
    if (e.Name != "chkAll")
       e.checked = form.chkAll.checked;
    }
  }
</script>
</head>

<body>

<?
         $sql2="select * from adhgfqws65ljdlgr where ID=".$_GET["id"]." order by id desc limit 1 ";
		 $query2=$db->query($sql2);
		 $row2=$db->fetch_array($query2);
		 if(is_array($row2))
         {}
         else
         {
			 echo "<script>alert('管理员不存在!');history.go(-1);</script>";
	         exit();
	     }
?>

<?
if($_GET['act']=="save")
{
	$ids = implode(',', $_POST['quanxian']);
	//echo $ids;exit;
		$sql="UPDATE adhgfqws65ljdlgr SET quanxian='".$ids."' WHERE id='".$row2["ID"]."' ";
		$db->query($sql);
		echo "<script>alert('设置成功!');window.location.href='newsmanage.php';</script>";
	    exit();
}
		?>
<body>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="862" align="center" >
      <form method="POST" name="myform" onSubmit="return CheckForm();" action="?act=save&id=<? echo $row2['ID']?>" target="_self">
        <table width="900" border="0" align="center" cellpadding="0" cellspacing="2" class="border">
          <tr> 
            <td height="20" align="center" class="title"><b>角色设置</b></td>
          </tr>
          <tr align="center"> 
            <td class="tdbg"> <table width="100%" border="0" cellpadding="0" cellspacing="2">

                <tr> 
                  <td width="112" height="22" align="right" >管理员账号：</td>
                  <td width="596" ><? echo $row2['username']?></td>
                </tr>

                <tr>
                  <td height="22" align="right" >&nbsp;</td>
                  <td ><input name="chkAll" type="checkbox" id="chkAll" onclick="CheckAll(this.form)" value="checkbox" />
                  选择全部</td>
                </tr>
                <tr> 
                  <td width="112" height="22" align="right" ><input name="quanxian[]" type="checkbox" id="quanxian[]" value="会员系统管理" <? if(strstr($row2['quanxian'],"会员系统管理")!=""){echo "checked";}?>></td>
                  <td width="596" >会员系统管理</td>
                </tr>
                <tr>
                  <td height="22" align="right" >&nbsp;</td>
                  <td ><table width="100%" border="0">
                    <tr>
                      <td width="3%"><input name="quanxian[]" type="checkbox" id="quanxian[]" value="会员管理" <? if(strstr($row2['quanxian'],"会员管理")!=""){echo "checked";}?> /></td>
                      <td width="97%">会员管理</td>
                    </tr>
                    <tr>
                      <td width="3%"><input name="quanxian[]" type="checkbox" id="quanxian[]" value="点位系谱图" <? if(strstr($row2['quanxian'],"点位系谱图")!=""){echo "checked";}?> /></td>
                      <td width="97%">点位系谱图</td>
                    </tr>
                    <tr>
                      <td width="3%"><input name="quanxian[]" type="checkbox" id="quanxian[]" value="所有点位" <? if(strstr($row2['quanxian'],"所有点位")!=""){echo "checked";}?> /></td>
                      <td width="97%">所有点位</td>
                    </tr>
                    <tr>
                      <td width="3%"><input name="quanxian[]" type="checkbox" id="quanxian[]" value="报单地区管理" <? if(strstr($row2['quanxian'],"报单地区管理")!=""){echo "checked";}?> /></td>
                      <td width="97%">报单地区管理</td>
                    </tr>
                    <tr>
                      <td width="3%"><input name="quanxian[]" type="checkbox" id="quanxian[]" value="未审核报单申请管理" <? if(strstr($row2['quanxian'],"未审核报单申请管理")!=""){echo "checked";}?> /></td>
                      <td width="97%">未审核报单申请管理</td>
                    </tr>
                    <tr>
                      <td width="3%"><input name="quanxian[]" type="checkbox" id="quanxian[]" value="已审核报单申请管理" <? if(strstr($row2['quanxian'],"已审核报单申请管理")!=""){echo "checked";}?> /></td>
                      <td width="97%">已审核报单申请管理</td>
                    </tr>
                    <tr>
                      <td width="3%"><input name="quanxian[]" type="checkbox" id="quanxian[]" value="转账记录管理" <? if(strstr($row2['quanxian'],"转账记录管理")!=""){echo "checked";}?> /></td>
                      <td width="97%">转账记录管理</td>
                    </tr>
                    <tr>
                      <td width="3%"><input name="quanxian[]" type="checkbox" id="quanxian[]" value="第三条线业绩" <? if(strstr($row2['quanxian'],"第三条线业绩")!=""){echo "checked";}?> /></td>
                      <td width="97%">第三条线业绩</td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td width="112" height="22" align="right" ><input name="quanxian[]" type="checkbox" id="quanxian[]" value="充值管理" <? if(strstr($row2['quanxian'],"充值管理")!=""){echo "checked";}?>></td>
                  <td width="596" >充值管理</td>
                </tr>
                <tr>
                  <td height="22" align="right" >&nbsp;</td>
                  <td ><table width="100%" border="0">
                    <tr>
                      <td width="3%"><input name="quanxian[]" type="checkbox" id="quanxian[]" value="充值记录" <? if(strstr($row2['quanxian'],"充值记录")!=""){echo "checked";}?> /></td>
                      <td width="97%">充值记录</td>
                    </tr>
                    <tr>
                      <td width="3%"><input name="quanxian[]" type="checkbox" id="quanxian[]" value="会员充值" <? if(strstr($row2['quanxian'],"会员充值")!=""){echo "checked";}?> /></td>
                      <td width="97%">会员充值</td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td width="112" height="22" align="right" ><input name="quanxian[]" type="checkbox" id="quanxian[]" value="财务管理" <? if(strstr($row2['quanxian'],"财务管理")!=""){echo "checked";}?>></td>
                  <td width="596" >财务管理</td>
                </tr>
                <tr>
                  <td height="22" align="right" >&nbsp;</td>
                  <td ><table width="100%" border="0">
                    <tr>
                      <td width="3%"><input name="quanxian[]" type="checkbox" id="quanxian[]" value="参数设置" <? if(strstr($row2['quanxian'],"参数设置")!=""){echo "checked";}?> /></td>
                      <td width="97%">参数设置</td>
                    </tr>
                    <tr>
                      <td width="3%"><input name="quanxian[]" type="checkbox" id="quanxian[]" value="奖金明细" <? if(strstr($row2['quanxian'],"奖金明细")!=""){echo "checked";}?> /></td>
                      <td width="97%">奖金明细</td>
                    </tr>
                    <tr>
                      <td width="3%"><input name="quanxian[]" type="checkbox" id="quanxian[]" value="电子币明细" <? if(strstr($row2['quanxian'],"电子币明细")!=""){echo "checked";}?> /></td>
                      <td width="97%">电子币明细</td>
                    </tr>
                    <tr>
                      <td width="3%"><input name="quanxian[]" type="checkbox" id="quanxian[]" value="未审核提现" <? if(strstr($row2['quanxian'],"未审核提现")!=""){echo "checked";}?> /></td>
                      <td width="97%">未审核提现</td>
                    </tr>
                    <tr>
                      <td width="3%"><input name="quanxian[]" type="checkbox" id="quanxian[]" value="已审核提现" <? if(strstr($row2['quanxian'],"已审核提现")!=""){echo "checked";}?> /></td>
                      <td width="97%">已审核提现</td>
                    </tr>
                    <tr>
                      <td width="3%"><input name="quanxian[]" type="checkbox" id="quanxian[]" value="月奖金结算" <? if(strstr($row2['quanxian'],"月奖金结算")!=""){echo "checked";}?> /></td>
                      <td width="97%">月奖金结算</td>
                    </tr>

                  </table></td>
                </tr>
                <tr>
                  <td width="112" height="22" align="right" ><input name="quanxian[]" type="checkbox" id="quanxian[]" value="邮件管理" <? if(strstr($row2['quanxian'],"邮件管理")!=""){echo "checked";}?>></td>
                  <td width="596" >邮件管理</td>
                </tr>
                <tr>
                  <td width="112" height="22" align="right" ><input name="quanxian[]" type="checkbox" id="quanxian[]" value="商品管理" <? if(strstr($row2['quanxian'],"商品管理")!=""){echo "checked";}?>></td>
                  <td width="596" >商品管理</td>
                </tr>
                <tr>
                  <td width="112" height="22" align="right" ><input name="quanxian[]" type="checkbox" id="quanxian[]" value="订单管理" <? if(strstr($row2['quanxian'],"订单管理")!=""){echo "checked";}?>></td>
                  <td width="596" >订单管理</td>
                </tr>
                <tr>
                  <td width="112" height="22" align="right" ><input name="quanxian[]" type="checkbox" id="quanxian[]" value="公告管理" <? if(strstr($row2['quanxian'],"公告管理")!=""){echo "checked";}?>></td>
                  <td width="596" >公告管理</td>
                </tr>
                <tr>
                  <td width="112" height="22" align="right" ><input name="quanxian[]" type="checkbox" id="quanxian[]" value="账号管理" <? if(strstr($row2['quanxian'],"账号管理")!=""){echo "checked";}?>></td>
                  <td width="596" >账号管理</td>
                </tr>
                <tr>
                  <td width="112" height="22" align="right" ><input name="quanxian[]" type="checkbox" id="quanxian[]" value="数据库管理" <? if(strstr($row2['quanxian'],"数据库管理")!=""){echo "checked";}?>></td>
                  <td width="596" >数据库管理</td>
                </tr>
              </table></td>
          </tr>
        </table>
        <div align="center"><p> 
        <input
  name="Add" type="submit"  id="Add" value="保存" >
      </p></div>
</form>   </td>
  </tr>
</table>
</body>