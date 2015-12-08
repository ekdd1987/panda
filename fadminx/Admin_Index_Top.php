<html>
<head>
<title>后台管理页面</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style type="text/css">
a:link { color:#000000;text-decoration:none}
a:hover {color:#666666;}
a:visited {color:#000000;text-decoration:none}

td {FONT-SIZE: 9pt; FILTER: dropshadow(color=#FFFFFF,offx=1,offy=1); COLOR: #000000; FONT-FAMILY: "宋体"}
img {filter:Alpha(opacity:100); chroma(color=#FFFFFF)}
</style>
<base target="main">
<script language="JavaScript" type="text/JavaScript">
function preloadImg(src)
{
	var img=new Image();
	img.src=src
}
preloadImg("Images/admin_top_open.gif");

var displayBar=true;
function switchBar(obj)
{
	if (displayBar)
	{
		parent.frame.cols="0,*";
		displayBar=false;
		obj.src="Images/admin_top_open.gif";
		obj.title="打开左边管理导航菜单";
	}
	else{
		parent.frame.cols="180,*";
		displayBar=true;
		obj.src="Images/admin_top_close.gif";
		obj.title="关闭左边管理导航菜单";
	}
}
</script>
</head>
<body background="Images/admin_top_bg.gif" leftmargin="0" topmargin="0">
<table height="100%" width="100%" border=0 cellpadding=0 cellspacing=0>
<tr valign=middle>
	<td width=118>
	&nbsp;<img onClick="switchBar(this)" src="Images/admin_top_close.gif" title="关闭左边管理导航菜单" style="cursor:hand">
	</td>
	<td width=22>
		<img src="Images/admin_top_icon_1.gif">
	</td>
	<td width=112>
		<a href="admin/newsModify.php?ArticleID=<? echo $_COOKIE["adminid"]?>">修改密码</a>
	</td>
	<td width=53>&nbsp;</td>
	<td width=44>&nbsp;</td>
	<td width="1330" align="left" style="color:#F00; font-size:18px; font-weight:bold">&nbsp;</td>
</tr>
</table>
</body>
</html>

