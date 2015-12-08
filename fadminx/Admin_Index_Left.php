<?php
include("Admin.php");
include("../includes/conn.php");
?>
<?
         $sql2="select * from adhgfqws65ljdlgr where ID=".$_COOKIE["adminid"]." order by id desc limit 1 ";
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
<html>
<head>
<title>管理导航</title>
<style type=text/css>
body  { background:#009286; margin:0px; font:14px 宋体; FONT-SIZE: 14px;text-decoration: none;
SCROLLBAR-FACE-COLOR: #C6EBDE;
SCROLLBAR-HIGHLIGHT-COLOR: #ffffff; SCROLLBAR-SHADOW-COLOR: #39867B; SCROLLBAR-3DLIGHT-COLOR: #39867B; SCROLLBAR-ARROW-COLOR: #330000; SCROLLBAR-TRACK-COLOR: #E2F3F1; SCROLLBAR-DARKSHADOW-COLOR: #ffffff;}
table  { border:0px; }
td  { font:normal 14px 宋体; }
img  { vertical-align:bottom; border:0px; }
a  { font:normal 14px 宋体; color:#000000; text-decoration:none; }
a:hover  { color:#cc0000;text-decoration:underline; }
.sec_menu  { border-left:1px solid white; border-right:1px solid white; border-bottom:1px solid white; overflow:hidden; background:#C6EBDE; }
.menu_title  { }
.menu_title span  { position:relative; top:2px; left:8px; color:#39867B; font-weight:bold; }
.menu_title2  { }
.menu_title2 span  { position:relative; top:2px; left:8px; color:#cc0000; font-weight:bold; }
</style>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<SCRIPT language=javascript1.2>
function showsubmenu(sid)
{
whichEl = eval("submenu" + sid);
if (whichEl.style.display == "none")
{
eval("submenu" + sid + ".style.display='';");
}
else
{
eval("submenu" + sid + ".style.display='none';");
}
}
</SCRIPT>
</head>

<BODY leftmargin="0" topmargin="0" marginheight="0" marginwidth="0">
<table width=100% cellpadding=0 cellspacing=0 border=0 align=left>
    <tr><td valign=top>
<table width=158 border="0" align=center cellpadding=0 cellspacing=0>
  <tr>
    <td height=42 valign=bottom>
	  <img src="Images/title.gif" width=158 height=38>
    </td>
  </tr>
</table>
<table cellpadding=0 cellspacing=0 width=158 align=center>
  <tr>
        <td height=25 class=menu_title onmouseover=this.className='menu_title2'; onmouseout=this.className='menu_title'; background=Images/title_bg_quit.gif id=menuTitle0> 
          <span><a href='Admin_Index_Main.php' target='main'><b>管理首页</b></a> | 
          <a href='Loginout.php' target='_top'><b>退出</b></a></span> </td>
  </tr>
  <tr>
    <td style="display:" id='submenu0'>
<div class=sec_menu style="width:158">
<table cellpadding=0 cellspacing=0 align=center width=130>
<tr><td height=20>用户名：<? echo $_COOKIE["adminname"]?></td></tr>
</table>
</div>
<div  style="width:158">
<table cellpadding=0 cellspacing=0 align=center width=130>
<tr><td height=20></td></tr>
</table>
</div>
	</td>
  </tr>
</table>
<table cellpadding=0 cellspacing=0 width=158 align=center >
  <tr>
        <td height=25 class=menu_title onmouseover=this.className='menu_title2'; onmouseout=this.className='menu_title'; background="Images/Admin_left_3.gif" id=menuTitle1 onClick="showsubmenu(1)" style="cursor:hand;"> 
          <span>会员系统管理</span> </td>
  </tr>
  <tr>
    <td style="display:inline" id='submenu1'>
<div class=sec_menu style="width:158">
<table cellpadding=0 cellspacing=0 align=center width=130>
<tr height=20 ><td><a href='user/lsusermanage.php' target='main'>临时会员管理</a></td></tr>
<tr height=20 ><td><a href='user/usermanage.php' target='main'>正式会员管理</a></td></tr>
<tr height=20 ><td><a href='user/shengji.php' target='main'>会员升级明细</a></td></tr>
<tr height=20 ><td><a href='xiangguan/newsModify.php?ArticleID=1' target='main'>关于我们</a></td></tr>
<tr height=20 ><td><a href='xiangguan/newsModify.php?ArticleID=2' target='main'>规则说明</a></td></tr>
</table>
	  </div>
<div  style="width:158">
<table cellpadding=0 cellspacing=0 align=center width=130>
<tr><td height=20></td></tr>
</table>
	  </div>
	</td>
  </tr>
</table>
<table cellpadding=0 cellspacing=0 width=158 align=center >
  <tr>
        <td height=25 class=menu_title onmouseover=this.className='menu_title2'; onmouseout=this.className='menu_title'; background="Images/Admin_left_3.gif" id=menuTitle5 onClick="showsubmenu(5)" style="cursor:hand;"> 
          <span>图谱管理</span> </td>
  </tr>
  <tr>
    <td style="display:inline" id='submenu5'>
<div class=sec_menu style="width:158">
<table cellpadding=0 cellspacing=0 align=center width=130>
<tr><td height=20><a href='user/User_FirstWeb.php' target=main>直推图</a></td></tr>
<tr><td height=20><a href='user/user_web.php' target=main>网络图</a></td></tr>
</table>
	  </div>
<div  style="width:158">
<table cellpadding=0 cellspacing=0 align=center width=130>
<tr><td height=20></td></tr>
</table>
	  </div>
	</td>
  </tr>
</table>
<? if($_COOKIE["Purview"]=="1") {?>
<table cellpadding=0 cellspacing=0 width=158 align=center >
  <tr>
        <td height=25 class=menu_title onmouseover=this.className='menu_title2'; onmouseout=this.className='menu_title'; background="Images/Admin_left_02.gif" id=menuTitle8 onClick="showsubmenu(8)" style="cursor:hand;"> 
          <span>账号管理</span> </td>
  </tr>
  <tr>
    <td style="display:inline" id='submenu8'>
<div class=sec_menu style="width:158">
            <table cellpadding=0 cellspacing=0 align=center width=130>

              <tr>
                <td height=20><a href=Admin/newsadd.php target=main>管理员添加</a> 
                </td>
              </tr>
			  
<tr>
                <td height=20><a href=Admin/newsmanage.php target=main>管理员管理</a> 
                </td>
              </tr>
              <tr><td height=20><a href=user/guanbi.php target=main>开关控制</a></td></tr>


            </table>
	  </div>
<div  style="width:158">
<table cellpadding=0 cellspacing=0 align=center width=130>
<tr><td height=20></td></tr>
</table>
	  </div>
	</td>
  </tr>
</table>
<? }?>


<table cellpadding=0 cellspacing=0 width=158 align=center>
  <tr>
        <td height=25 class=menu_title onmouseover=this.className='menu_title2'; onmouseout=this.className='menu_title'; background="Images/Admin_left_04.gif" id=menuTitle208> 
          <span>系统信息</span> </td>
  </tr>
  <tr>
    <td>
<div class=sec_menu style="width:158">
<table cellpadding=0 cellspacing=0 align=center width=140>
<tr><td height=20><br>
版权所有：&nbsp;会员系统<br>
设计制作：&nbsp;会员系统<BR>
技术支持：&nbsp;会员系统<br>
<br>
</td></tr>
</table>
	  </div>
	</td>
  </tr>
</table>
</body>
</html>

