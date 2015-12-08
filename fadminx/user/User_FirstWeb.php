<?php
include("../Admin.php");
include("../../includes/conn.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head><title>
	直推图
</title>
    <script src="../Scripts/jquery.min.js" type="text/javascript"></script>
    <script src="Scripts/Menu.js" type="text/javascript"></script>
    <script src="Scripts/ValidateCommon.js" type="text/javascript"></script>
    <link href="Styles/Style.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript">
        function openWin1(url) {
            $.dialog({ id: "openbox1", title: "", min: false, max: false, content: "url:"+url });
        }
        function openclose1() {
            $.dialog({ id: "openbox1" }).close();
        }
    </script>
    
<link rel="StyleSheet" href="tree/dtree.css" type="text/css" />
<script type="text/javascript" src="tree/dtree.js"></script>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>


    <div id="wrap">
	<!--header--><!--header end-->
	
	<div id="mainbody">
	  <div class="listBoxGen">
                <div class="listBoxTitleGen">
                    <div class="showTitle">
                        推荐图谱</div>
                </div>
                <div class="listBoxContentGen">
                    <div class="widths">
                    
                    
                    <div class="dtree">

	<p><a href="javascript: d.openAll();">open all</a> | <a href="javascript: d.closeAll();">close all</a></p>


<?
if ($_REQUEST['userid']!=""){
		 $sqluser="select * from users where loginname='".$_REQUEST['userid']."'";
}
else{
	$sqluser="select * from users where id=1";
    }
		 $queryuser=mysql_query($sqluser);
		 $rowuser=mysql_fetch_array($queryuser);
?>
	<script type="text/javascript">
		d = new dTree('d');
<?
Function getcatalogs($T_SerialNumber)
{
$tempStr="";
$sql="select * from users where rid='".$T_SerialNumber."'";
$query=mysql_query($sql);
while($row=mysql_fetch_array($query))
{
if ($row['states']==1){
	$jibie="已激活";}
	else
	{
	$jibie="<font color=red>未激活</font>";
	}
 //$view="<a href=User_FirstWeb.php?userid=".strtoupper($row['loginname']).">view</font>";

echo "d.add('".strtoupper($row['id'])."','".strtoupper($row['rid'])."','".strtoupper($row['loginname'])." - ".$jibie." ".$view."  ');";

  getcatalogs(strtoupper($row['id']));
}
}
?>

d.add('<? echo strtoupper($rowuser['id'])?>',-1,'<? echo strtoupper($rowuser['loginname'])?>');
<?
getcatalogs(strtoupper($rowuser['id']));
?>	
		document.write(d);

		d.closeAll();

	</script>



</div>



</div>
                </div>
            </div>


	</div>
</div>

<!-- Transparent layer --> 
<div id="divBox" style="filter:alpha(opacity=40);-moz-opacity:0.3;opacity:0.3;background-color:#000;width:100%;height:100%;z-index:1000;position: absolute;left:0;top:0;display:none;overflow: hidden;">
</div>
<!-- message layer --> 
<div id="divMsg" style="border:solid 5px #339999;background:#fff;padding:10px;width:780px;z-index:1001; position: absolute; display:none;top:50%; left:50%;margin:-200px 0 0 -400px;"> 
    <div style="padding:3px 15px 3px 15px;text-align:left;vertical-align:middle;"> 
        <div class="IndexShowMsg"> 
            <div id="divShowMsg"></div>
            
        </div> 
        <br/>
        <div id="showbtnCancel" style="text-align:right;"> 
            <input id="btnCancel" type="button" class="buttom" value=" 关闭 " onclick="ShowNo()"/> 
        </div> 
    </div> 
</div> 


</body>
</html>
