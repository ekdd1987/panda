<style type="text/css">
<!--
.STYLE1 {color: #666666;font-size:14px;}
.ttab {BORDER-RIGHT: #667a9d 1px solid; BORDER-TOP: #667a9d 1px solid; BORDER-LEFT: #667a9d 1px solid; BORDER-BOTTOM: #667a9d 1px solid; width:140px; HEIGHT: 20px; margin-left:10px; margin-right:10px;}
-->
</style>
<?php
include("../Admin.php");
include("../../includes/conn.php");
?>
<table width="500" align="center" cellpadding="3" cellspacing="1" class="tablebg">
      <tr>
      
        <td align="center"><form name="form1" method="post" action="?">
          搜索会员
              <input type="text" name="uuserid" id="uuserid" value="">
           <input type="submit" name="button" id="button" value="搜索">
        </form></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="10" cellpadding="0">
  <tr>
    <td align="center"><?
		 $sqluser8="select * from users where id=1";
		 $queryuser8=mysql_query($sqluser8);
		 $rowuser8=mysql_fetch_array($queryuser8);
?>
<TABLE  border=0 align="center" cellPadding=0 cellSpacing=1 borderColorLight=white borderColorDark=#ffffff class="ttab">
<TBODY>
<TR>
  <TD height="25" align=middle style="HEIGHT: 19px; BACKGROUND-COLOR: #95d8f1; color:#000; font-weight:bold"><? echo $rowuser8['loginname']?></TD>
  </TR>
<TR>
  <TD height="55" align=middle >(<? echo $rowuser8['wechat']?>)</TD>
  </tr>

</TBODY>
</TABLE></td>
  </tr>
  <tr>
    <td align="center"><?
		 $sqluser8="select * from users where id=9736";
		 $queryuser8=mysql_query($sqluser8);
		 $rowuser8=mysql_fetch_array($queryuser8);
?>
<TABLE  border=0 align="center" cellPadding=0 cellSpacing=1 borderColorLight=white borderColorDark=#ffffff class="ttab">
<TBODY>
<TR>
  <TD height="25" align=middle style="HEIGHT: 19px; BACKGROUND-COLOR: #95d8f1; color:#000; font-weight:bold"><? echo $rowuser8['loginname']?></TD>
  </TR>
<TR>
  <TD height="55" align=middle >(<? echo $rowuser8['wechat']?>)</TD>
  </tr>

</TBODY>
</TABLE></td>
  </tr>
  <tr>
    <td align="center"><?
		 $sqluser8="select * from users where id=9737";
		 $queryuser8=mysql_query($sqluser8);
		 $rowuser8=mysql_fetch_array($queryuser8);
?>
<TABLE  border=0 align="center" cellPadding=0 cellSpacing=1 borderColorLight=white borderColorDark=#ffffff class="ttab">
<TBODY>
<TR>
  <TD height="25" align=middle style="HEIGHT: 19px; BACKGROUND-COLOR: #95d8f1; color:#000; font-weight:bold"><? echo $rowuser8['loginname']?></TD>
  </TR>
<TR>
  <TD height="55" align=middle >(<? echo $rowuser8['wechat']?>)</TD>
  </tr>

</TBODY>
</TABLE></td>
  </tr>
  <tr>
    <td align="center"><?
		 $sqluser8="select * from users where id=9738";
		 $queryuser8=mysql_query($sqluser8);
		 $rowuser8=mysql_fetch_array($queryuser8);
?>
<TABLE  border=0 align="center" cellPadding=0 cellSpacing=1 borderColorLight=white borderColorDark=#ffffff class="ttab">
<TBODY>
<TR>
  <TD height="25" align=middle style="HEIGHT: 19px; BACKGROUND-COLOR: #95d8f1; color:#000; font-weight:bold"><? echo $rowuser8['loginname']?></TD>
  </TR>
<TR>
  <TD height="55" align=middle >(<? echo $rowuser8['wechat']?>)</TD>
  </tr>

</TBODY>
</TABLE></td>
  </tr>
  <tr>
    <td align="center"><?
		 $sqluser8="select * from users where id=9739";
		 $queryuser8=mysql_query($sqluser8);
		 $rowuser8=mysql_fetch_array($queryuser8);
?>
<TABLE  border=0 align="center" cellPadding=0 cellSpacing=1 borderColorLight=white borderColorDark=#ffffff class="ttab">
<TBODY>
<TR>
  <TD height="25" align=middle style="HEIGHT: 19px; BACKGROUND-COLOR: #95d8f1; color:#000; font-weight:bold"><? echo $rowuser8['loginname']?></TD>
  </TR>
<TR>
  <TD height="55" align=middle >(<? echo $rowuser8['wechat']?>)</TD>
  </tr>

</TBODY>
</TABLE></td>
  </tr>
  <tr>
    <td align="center"><?
		 $sqluser8="select * from users where id=9740";
		 $queryuser8=mysql_query($sqluser8);
		 $rowuser8=mysql_fetch_array($queryuser8);
?>
<TABLE  border=0 align="center" cellPadding=0 cellSpacing=1 borderColorLight=white borderColorDark=#ffffff class="ttab">
<TBODY>
<TR>
  <TD height="25" align=middle style="HEIGHT: 19px; BACKGROUND-COLOR: #95d8f1; color:#000; font-weight:bold"><? echo $rowuser8['loginname']?></TD>
  </TR>
<TR>
  <TD height="55" align=middle >(<? echo $rowuser8['wechat']?>)</TD>
  </tr>

</TBODY>
</TABLE></td>
  </tr>
</table>
<TABLE width="100%" border=0 align="center" cellPadding=0 cellSpacing=0 style="margin-top:10px; border:0px solid #7cc5de;">
    <TBODY>
      <TR>
        
        <TD colspan="12" align="center" style="border:0px;">

<?
         if ($_REQUEST['uuserid']!=""){
		 $sqluser8="select * from users where loginname='".$_REQUEST['uuserid']."' and states=1";
		 }
		 else
		 {
			 $sqluser8="select * from users where id=9741";
		 }
		 $queryuser8=mysql_query($sqluser8);
		 $rowuser8=mysql_fetch_array($queryuser8);
		 if (empty($rowuser8['loginname'])) 
	{
		echo "<script>alert('会员不存在!');history.go(-1);</script>";
	    exit();
	}

$area=1;
$uname=$rowuser8['loginname'];
$states=$rowuser8['states'];
$pid=$rowuser8['loginname'];
	//biaoge(1,1);
?>
<TABLE  border=0 align="center" cellPadding=0 cellSpacing=1 borderColorLight=white borderColorDark=#ffffff class="ttab">
<TBODY>
<? if(is_array($rowuser8)){?>
<TR>
  <TD height="25" colspan="3" align=middle style="HEIGHT: 19px; BACKGROUND-COLOR: #95d8f1; color:#000; font-weight:bold"><A href="?uuserid=<? echo $rowuser8['loginname']?>" style="color:#000" ><? echo $rowuser8['loginname']?></A></TD>
  </TR>
<TR>
  <TD height="55" colspan="3" align=middle >(<? echo $rowuser8['wechat']?>)</TD>
  </tr>


<? }else{?>
<TR>
  <TD height="25" colspan="3" align=middle style="HEIGHT: 19px; BACKGROUND-COLOR: #95d8f1; color:#000; font-weight:bold">空点位</TD>
  </tr>
<TR>
  <TD height="25" colspan="3" align=middle ><? if ($pid<>""&&$states="1"){ ?><a href="?pid=<? echo $pid?>&area=<? echo $area?>"><font color="#ffffff"></font></a><? }?></TD>
  </tr>
<? }?>
</TBODY>
</TABLE>
  
  </TD>
        </TR>
      
      <TR>
        <TD height="50"  colSpan=12 align="center" style="border:0px;">&nbsp;</TD>
      </TR>
      
      <TR>
        <TD colspan="6" align="center" style="border:0px;">
<?
		 $sqluser8="select * from users where pid='".$uname."' and area=1 ";
		 $queryuser8=mysql_query($sqluser8);
		 $rowuser8=mysql_fetch_array($queryuser8);
		 if(is_array($rowuser8))
		 {
		$uname1=$rowuser8['loginname'];
		$area=$rowuser8['area'];
        $states1=$rowuser8['states'];
		$pid1=$rowuser8['loginname'];
	}
    ?>
    <TABLE  border=0 align="center" cellPadding=0 cellSpacing=1 borderColorLight=white borderColorDark=#ffffff class="ttab">
<TBODY>
<? if(is_array($rowuser8)){?>
<TR>
  <TD height="25" colspan="3" align=middle style="HEIGHT: 19px; BACKGROUND-COLOR: #95d8f1; color:#000; font-weight:bold"><A href="?uuserid=<? echo $rowuser8['loginname']?>" style="color:#000" ><? echo $rowuser8['loginname']?></A></TD>
  </TR>
<TR>
  <TD height="55" colspan="3" align=middle >(<? echo $rowuser8['wechat']?>)</TD>
  </tr>


<? }else{?>
<TR>
  <TD height="25" colspan="3" align=middle style="HEIGHT: 19px; BACKGROUND-COLOR: #95d8f1; color:#000; font-weight:bold">空点位</TD>
  </tr>
<TR>
  <TD height="25" colspan="3" align=middle ><? if ($pid<>""&&$states=="1"){ ?><a href="?pid=<? echo $pid?>&area=1"><font color="#ffffff"></font></a><? }?></TD>
  </tr>
<? }?>
</TBODY>
</TABLE>
  
  </TD>
        <TD colspan="6" align="center" style="border:0px;">
        
        <?
		 $sqluser8="select * from users where pid='".$uname."' and area=2 ";
		 $queryuser8=mysql_query($sqluser8);
		 $rowuser8=mysql_fetch_array($queryuser8);
		 if(is_array($rowuser8))
		 {
		$uname2=$rowuser8['loginname'];
		$area=$rowuser8['area'];
        $states2=$rowuser8['states'];
		$pid2=$rowuser8['loginname'];
	}
    ?>
    <TABLE  border=0 align="center" cellPadding=0 cellSpacing=1 borderColorLight=white borderColorDark=#ffffff class="ttab">
<TBODY>
<? if(is_array($rowuser8)){?>
<TR>
  <TD height="25" colspan="3" align=middle style="HEIGHT: 19px; BACKGROUND-COLOR: #95d8f1; color:#000; font-weight:bold"><A href="?uuserid=<? echo $rowuser8['loginname']?>" style="color:#000" ><? echo $rowuser8['loginname']?></A></TD>
  </TR>
<TR>
  <TD height="55" colspan="3" align=middle >(<? echo $rowuser8['wechat']?>)</TD>
  </tr>


<? }else{?>
<TR>
  <TD height="25" colspan="3" align=middle style="HEIGHT: 19px; BACKGROUND-COLOR: #95d8f1; color:#000; font-weight:bold">空点位</TD>
  </tr>
<TR>
  <TD height="25" colspan="3" align=middle ><? if ($pid<>""&&$states=="1"){ ?><a href="?pid=<? echo $pid?>&area=2"><font color="#ffffff"></font></a><? }?></TD>
  </tr>
<? }?>
</TBODY>
</TABLE>
  
  </TD>
        </TR>
      <TR>
        <TD height="50" colSpan=6 align="center" style="border:0px;">&nbsp;</TD>
      <TD style="border:0px;" colSpan=6 align="center">&nbsp;</TD></TR>
      
      <TR>
        <TD colspan="3"  align="center" style="border:0px;">
        
        <?
		 $sqluser8="select * from users where pid='".$uname1."' and area=1 ";
		 $queryuser8=mysql_query($sqluser8);
		 $rowuser8=mysql_fetch_array($queryuser8);
		 if(is_array($rowuser8))
		 {
		$uname3=$rowuser8['loginname'];
		$area=$rowuser8['area'];
        $states=$rowuser8['states'];
	}
    ?>
    <TABLE  border=0 align="center" cellPadding=0 cellSpacing=1 borderColorLight=white borderColorDark=#ffffff class="ttab">
<TBODY>
<? if(is_array($rowuser8)){?>
<TR>
  <TD height="25" colspan="3" align=middle style="HEIGHT: 19px; BACKGROUND-COLOR: #95d8f1; color:#000; font-weight:bold"><A href="?uuserid=<? echo $rowuser8['loginname']?>" style="color:#000" ><? echo $rowuser8['loginname']?></A></TD>
  </TR>
<TR>
  <TD height="55" colspan="3" align=middle >(<? echo $rowuser8['wechat']?>)</TD>
  </tr>


<? }else{?>
<TR>
  <TD height="25" colspan="3" align=middle style="HEIGHT: 19px; BACKGROUND-COLOR: #95d8f1; color:#000; font-weight:bold">空点位</TD>
  </tr>
<TR>
  <TD height="25" colspan="3" align=middle ><? if ($pid1<>""&&$states1=="1"){ ?><a href="?pid=<? echo $pid1?>&area=1"><font color="#ffffff"></font></a><? }?></TD>
  </tr>
<? }?>
</TBODY>
</TABLE>
  
  </TD>
        <TD colspan="3"  align="center" style="border:0px;">
        <?
		 $sqluser8="select * from users where pid='".$uname1."' and area=2 ";
		 $queryuser8=mysql_query($sqluser8);
		 $rowuser8=mysql_fetch_array($queryuser8);
		 if(is_array($rowuser8))
		 {
		$uname4=$rowuser8['loginname'];
		$area=$rowuser8['area'];
        $states=$rowuser8['states'];
	}
    ?>
    <TABLE  border=0 align="center" cellPadding=0 cellSpacing=1 borderColorLight=white borderColorDark=#ffffff class="ttab">
<TBODY>
<? if(is_array($rowuser8)){?>
<TR>
  <TD height="25" colspan="3" align=middle style="HEIGHT: 19px; BACKGROUND-COLOR: #95d8f1; color:#000; font-weight:bold"><A href="?uuserid=<? echo $rowuser8['loginname']?>" style="color:#000" ><? echo $rowuser8['loginname']?></A></TD>
  </TR>
<TR>
  <TD height="55" colspan="3" align=middle >(<? echo $rowuser8['wechat']?>)</TD>
  </tr>


<? }else{?>
<TR>
  <TD height="25" colspan="3" align=middle style="HEIGHT: 19px; BACKGROUND-COLOR: #95d8f1; color:#000; font-weight:bold">空点位</TD>
  </tr>
<TR>
  <TD height="25" colspan="3" align=middle ><? if ($pid1<>""&&$states1=="1"){ ?><a href="?pid=<? echo $pid1?>&area=2"><font color="#ffffff"></font></a><? }?></TD>
  </tr>
<? }?>
</TBODY>
</TABLE>
  
  </TD>
        <TD colspan="3"  align="center" style="border:0px;">
        <?
		 $sqluser8="select * from users where pid='".$uname2."' and area=1 ";
		 $queryuser8=mysql_query($sqluser8);
		 $rowuser8=mysql_fetch_array($queryuser8);
		 if(is_array($rowuser8))
		 {
		$uname5=$rowuser8['loginname'];
		$area=$rowuser8['area'];
        $states=$rowuser8['states'];
	}
    ?>
    <TABLE  border=0 align="center" cellPadding=0 cellSpacing=1 borderColorLight=white borderColorDark=#ffffff class="ttab">
<TBODY>
<? if(is_array($rowuser8)){?>
<TR>
  <TD height="25" colspan="3" align=middle style="HEIGHT: 19px; BACKGROUND-COLOR: #95d8f1; color:#000; font-weight:bold"><A href="?uuserid=<? echo $rowuser8['loginname']?>" style="color:#000" ><? echo $rowuser8['loginname']?></A></TD>
  </TR>
<TR>
  <TD height="55" colspan="3" align=middle >(<? echo $rowuser8['wechat']?>)</TD>
  </tr>


<? }else{?>
<TR>
  <TD height="25" colspan="3" align=middle style="HEIGHT: 19px; BACKGROUND-COLOR: #95d8f1; color:#000; font-weight:bold">空点位</TD>
  </tr>
<TR>
  <TD height="25" colspan="3" align=middle ><? if ($pid2<>""&&$states2=="1"){ ?><a href="?pid=<? echo $pid2?>&area=1"><font color="#ffffff"></font></a><? }?></TD>
  </tr>
<? }?>
</TBODY>
</TABLE>
  
  </TD>
        <TD colspan="3"  align="center" style="border:0px;">
        <?
		 $sqluser8="select * from users where pid='".$uname2."' and area=2 ";
		 $queryuser8=mysql_query($sqluser8);
		 $rowuser8=mysql_fetch_array($queryuser8);
		 if(is_array($rowuser8))
		 {
		$uname6=$rowuser8['loginname'];
		$area=$rowuser8['area'];
        $states=$rowuser8['states'];
	}
    ?>
    <TABLE  border=0 align="center" cellPadding=0 cellSpacing=1 borderColorLight=white borderColorDark=#ffffff class="ttab">
<TBODY>
<? if(is_array($rowuser8)){?>
<TR>
  <TD height="25" colspan="3" align=middle style="HEIGHT: 19px; BACKGROUND-COLOR: #95d8f1; color:#000; font-weight:bold"><A href="?uuserid=<? echo $rowuser8['loginname']?>" style="color:#000" ><? echo $rowuser8['loginname']?></A></TD>
  </TR>
<TR>
  <TD height="55" colspan="3" align=middle >(<? echo $rowuser8['wechat']?>)</TD>
  </tr>


<? }else{?>
<TR>
  <TD height="25" colspan="3" align=middle style="HEIGHT: 19px; BACKGROUND-COLOR: #95d8f1; color:#000; font-weight:bold">空点位</TD>
  </tr>
<TR>
  <TD height="25" colspan="3" align=middle ><? if ($pid2<>""&&$states2=="1"){ ?><a href="?pid=<? echo $pid2?>&area=2"><font color="#ffffff"></font></a><? }?></TD>
  </tr>
<? }?>
</TBODY>
</TABLE>
  
  </TD>
        </TR>
      <TR>
        <TD height="50" colspan="3"  align="center" style="border:0px;">&nbsp;</TD>
        <TD colspan="3"  align="center" style="border:0px;">&nbsp;</TD>
        <TD colspan="3"  align="center" style="border:0px;">&nbsp;</TD>
        <TD colspan="3"  align="center" style="border:0px;">&nbsp;</TD>
      </TR>
      <TR>
        <TD  align="center" style="border:0px;"><?
		 $sqluser8="select * from users where pid='".$uname3."' and area=1 ";
		 $queryuser8=mysql_query($sqluser8);
		 $rowuser8=mysql_fetch_array($queryuser8);
		 if(is_array($rowuser8))
		 {
		$area=$rowuser8['area'];
        $states=$rowuser8['states'];
	}
    ?>
    <TABLE  border=0 align="center" cellPadding=0 cellSpacing=1 borderColorLight=white borderColorDark=#ffffff class="ttab">
<TBODY>
<? if(is_array($rowuser8)){?>
<TR>
  <TD height="25" colspan="3" align=middle style="HEIGHT: 19px; BACKGROUND-COLOR: #95d8f1; color:#000; font-weight:bold"><A href="?uuserid=<? echo $rowuser8['loginname']?>" style="color:#000" ><? echo $rowuser8['loginname']?></A></TD>
  </TR>
<TR>
  <TD height="55" colspan="3" align=middle >(<? echo $rowuser8['wechat']?>)</TD>
  </tr>


<? }else{?>
<TR>
  <TD height="25" colspan="3" align=middle style="HEIGHT: 19px; BACKGROUND-COLOR: #95d8f1; color:#000; font-weight:bold">空点位</TD>
  </tr>
<TR>
  <TD height="25" colspan="3" align=middle ><? if ($pid1<>""&&$states1=="1"){ ?><a href="?pid=<? echo $pid1?>&area=1"><font color="#ffffff"></font></a><? }?></TD>
  </tr>
<? }?>
</TBODY>
</TABLE></TD>
        <TD  align="center" style="border:0px;"><?
		 $sqluser8="select * from users where pid='".$uname3."' and area=2 ";
		 $queryuser8=mysql_query($sqluser8);
		 $rowuser8=mysql_fetch_array($queryuser8);
		 if(is_array($rowuser8))
		 {
		$area=$rowuser8['area'];
        $states=$rowuser8['states'];
	}
    ?>
    <TABLE  border=0 align="center" cellPadding=0 cellSpacing=1 borderColorLight=white borderColorDark=#ffffff class="ttab">
<TBODY>
<? if(is_array($rowuser8)){?>
<TR>
  <TD height="25" colspan="3" align=middle style="HEIGHT: 19px; BACKGROUND-COLOR: #95d8f1; color:#000; font-weight:bold"><A href="?uuserid=<? echo $rowuser8['loginname']?>" style="color:#000" ><? echo $rowuser8['loginname']?></A></TD>
  </TR>
<TR>
  <TD height="55" colspan="3" align=middle >(<? echo $rowuser8['wechat']?>)</TD>
  </tr>


<? }else{?>
<TR>
  <TD height="25" colspan="3" align=middle style="HEIGHT: 19px; BACKGROUND-COLOR: #95d8f1; color:#000; font-weight:bold">空点位</TD>
  </tr>
<TR>
  <TD height="25" colspan="3" align=middle ><? if ($pid1<>""&&$states1=="1"){ ?><a href="?pid=<? echo $pid1?>&area=1"><font color="#ffffff"></font></a><? }?></TD>
  </tr>
<? }?>
</TBODY>
</TABLE></TD>
        <TD  align="center" style="border:0px;">&nbsp;</TD>
        <TD  align="center" style="border:0px;"><?
		 $sqluser8="select * from users where pid='".$uname4."' and area=1 ";
		 $queryuser8=mysql_query($sqluser8);
		 $rowuser8=mysql_fetch_array($queryuser8);
		 if(is_array($rowuser8))
		 {
		$area=$rowuser8['area'];
        $states=$rowuser8['states'];
	}
    ?>
    <TABLE  border=0 align="center" cellPadding=0 cellSpacing=1 borderColorLight=white borderColorDark=#ffffff class="ttab">
<TBODY>
<? if(is_array($rowuser8)){?>
<TR>
  <TD height="25" colspan="3" align=middle style="HEIGHT: 19px; BACKGROUND-COLOR: #95d8f1; color:#000; font-weight:bold"><A href="?uuserid=<? echo $rowuser8['loginname']?>" style="color:#000" ><? echo $rowuser8['loginname']?></A></TD>
  </TR>
<TR>
  <TD height="55" colspan="3" align=middle >(<? echo $rowuser8['wechat']?>)</TD>
  </tr>


<? }else{?>
<TR>
  <TD height="25" colspan="3" align=middle style="HEIGHT: 19px; BACKGROUND-COLOR: #95d8f1; color:#000; font-weight:bold">空点位</TD>
  </tr>
<TR>
  <TD height="25" colspan="3" align=middle ><? if ($pid1<>""&&$states1=="1"){ ?><a href="?pid=<? echo $pid1?>&area=1"><font color="#ffffff"></font></a><? }?></TD>
  </tr>
<? }?>
</TBODY>
</TABLE></TD>
        <TD  align="center" style="border:0px;"><?
		 $sqluser8="select * from users where pid='".$uname4."' and area=2 ";
		 $queryuser8=mysql_query($sqluser8);
		 $rowuser8=mysql_fetch_array($queryuser8);
		 if(is_array($rowuser8))
		 {
		$area=$rowuser8['area'];
        $states=$rowuser8['states'];
	}
    ?>
    <TABLE  border=0 align="center" cellPadding=0 cellSpacing=1 borderColorLight=white borderColorDark=#ffffff class="ttab">
<TBODY>
<? if(is_array($rowuser8)){?>
<TR>
  <TD height="25" colspan="3" align=middle style="HEIGHT: 19px; BACKGROUND-COLOR: #95d8f1; color:#000; font-weight:bold"><A href="?uuserid=<? echo $rowuser8['loginname']?>" style="color:#000" ><? echo $rowuser8['loginname']?></A></TD>
  </TR>
<TR>
  <TD height="55" colspan="3" align=middle >(<? echo $rowuser8['wechat']?>)</TD>
  </tr>


<? }else{?>
<TR>
  <TD height="25" colspan="3" align=middle style="HEIGHT: 19px; BACKGROUND-COLOR: #95d8f1; color:#000; font-weight:bold">空点位</TD>
  </tr>
<TR>
  <TD height="25" colspan="3" align=middle ><? if ($pid1<>""&&$states1=="1"){ ?><a href="?pid=<? echo $pid1?>&area=1"><font color="#ffffff"></font></a><? }?></TD>
  </tr>
<? }?>
</TBODY>
</TABLE></TD>
        <TD  align="center" style="border:0px;">&nbsp;</TD>
        <TD  align="center" style="border:0px;"><?
		 $sqluser8="select * from users where pid='".$uname5."' and area=1 ";
		 $queryuser8=mysql_query($sqluser8);
		 $rowuser8=mysql_fetch_array($queryuser8);
		 if(is_array($rowuser8))
		 {
		$area=$rowuser8['area'];
        $states=$rowuser8['states'];
	}
    ?>
    <TABLE  border=0 align="center" cellPadding=0 cellSpacing=1 borderColorLight=white borderColorDark=#ffffff class="ttab">
<TBODY>
<? if(is_array($rowuser8)){?>
<TR>
  <TD height="25" colspan="3" align=middle style="HEIGHT: 19px; BACKGROUND-COLOR: #95d8f1; color:#000; font-weight:bold"><A href="?uuserid=<? echo $rowuser8['loginname']?>" style="color:#000" ><? echo $rowuser8['loginname']?></A></TD>
  </TR>
<TR>
  <TD height="55" colspan="3" align=middle >(<? echo $rowuser8['wechat']?>)</TD>
  </tr>


<? }else{?>
<TR>
  <TD height="25" colspan="3" align=middle style="HEIGHT: 19px; BACKGROUND-COLOR: #95d8f1; color:#000; font-weight:bold">空点位</TD>
  </tr>
<TR>
  <TD height="25" colspan="3" align=middle ><? if ($pid1<>""&&$states1=="1"){ ?><a href="?pid=<? echo $pid1?>&area=1"><font color="#ffffff"></font></a><? }?></TD>
  </tr>
<? }?>
</TBODY>
</TABLE></TD>
        <TD  align="center" style="border:0px;"><?
		 $sqluser8="select * from users where pid='".$uname5."' and area=2 ";
		 $queryuser8=mysql_query($sqluser8);
		 $rowuser8=mysql_fetch_array($queryuser8);
		 if(is_array($rowuser8))
		 {
		$area=$rowuser8['area'];
        $states=$rowuser8['states'];
	}
    ?>
    <TABLE  border=0 align="center" cellPadding=0 cellSpacing=1 borderColorLight=white borderColorDark=#ffffff class="ttab">
<TBODY>
<? if(is_array($rowuser8)){?>
<TR>
  <TD height="25" colspan="3" align=middle style="HEIGHT: 19px; BACKGROUND-COLOR: #95d8f1; color:#000; font-weight:bold"><A href="?uuserid=<? echo $rowuser8['loginname']?>" style="color:#000" ><? echo $rowuser8['loginname']?></A></TD>
  </TR>
<TR>
  <TD height="55" colspan="3" align=middle >(<? echo $rowuser8['wechat']?>)</TD>
  </tr>


<? }else{?>
<TR>
  <TD height="25" colspan="3" align=middle style="HEIGHT: 19px; BACKGROUND-COLOR: #95d8f1; color:#000; font-weight:bold">空点位</TD>
  </tr>
<TR>
  <TD height="25" colspan="3" align=middle ><? if ($pid1<>""&&$states1=="1"){ ?><a href="?pid=<? echo $pid1?>&area=1"><font color="#ffffff"></font></a><? }?></TD>
  </tr>
<? }?>
</TBODY>
</TABLE></TD>
        <TD  align="center" style="border:0px;">&nbsp;</TD>
        <TD  align="center" style="border:0px;"><?
		 $sqluser8="select * from users where pid='".$uname6."' and area=1 ";
		 $queryuser8=mysql_query($sqluser8);
		 $rowuser8=mysql_fetch_array($queryuser8);
		 if(is_array($rowuser8))
		 {
		$area=$rowuser8['area'];
        $states=$rowuser8['states'];
	}
    ?>
    <TABLE  border=0 align="center" cellPadding=0 cellSpacing=1 borderColorLight=white borderColorDark=#ffffff class="ttab">
<TBODY>
<? if(is_array($rowuser8)){?>
<TR>
  <TD height="25" colspan="3" align=middle style="HEIGHT: 19px; BACKGROUND-COLOR: #95d8f1; color:#000; font-weight:bold"><A href="?uuserid=<? echo $rowuser8['loginname']?>" style="color:#000" ><? echo $rowuser8['loginname']?></A></TD>
  </TR>
<TR>
  <TD height="55" colspan="3" align=middle >(<? echo $rowuser8['wechat']?>)</TD>
  </tr>


<? }else{?>
<TR>
  <TD height="25" colspan="3" align=middle style="HEIGHT: 19px; BACKGROUND-COLOR: #95d8f1; color:#000; font-weight:bold">空点位</TD>
  </tr>
<TR>
  <TD height="25" colspan="3" align=middle ><? if ($pid1<>""&&$states1=="1"){ ?><a href="?pid=<? echo $pid1?>&area=1"><font color="#ffffff"></font></a><? }?></TD>
  </tr>
<? }?>
</TBODY>
</TABLE></TD>
        <TD  align="center" style="border:0px;"><?
		 $sqluser8="select * from users where pid='".$uname6."' and area=2 ";
		 $queryuser8=mysql_query($sqluser8);
		 $rowuser8=mysql_fetch_array($queryuser8);
		 if(is_array($rowuser8))
		 {
		$area=$rowuser8['area'];
        $states=$rowuser8['states'];
	}
    ?>
    <TABLE  border=0 align="center" cellPadding=0 cellSpacing=1 borderColorLight=white borderColorDark=#ffffff class="ttab">
<TBODY>
<? if(is_array($rowuser8)){?>
<TR>
  <TD height="25" colspan="3" align=middle style="HEIGHT: 19px; BACKGROUND-COLOR: #95d8f1; color:#000; font-weight:bold"><A href="?uuserid=<? echo $rowuser8['loginname']?>" style="color:#000" ><? echo $rowuser8['loginname']?></A></TD>
  </TR>
<TR>
  <TD height="55" colspan="3" align=middle >(<? echo $rowuser8['wechat']?>)</TD>
  </tr>


<? }else{?>
<TR>
  <TD height="25" colspan="3" align=middle style="HEIGHT: 19px; BACKGROUND-COLOR: #95d8f1; color:#000; font-weight:bold">空点位</TD>
  </tr>
<TR>
  <TD height="25" colspan="3" align=middle ><? if ($pid1<>""&&$states1=="1"){ ?><a href="?pid=<? echo $pid1?>&area=1"><font color="#ffffff"></font></a><? }?></TD>
  </tr>
<? }?>
</TBODY>
</TABLE></TD>
        <TD  align="center" style="border:0px;">&nbsp;</TD>
      </TR>
    </TBODY>
</TABLE>
