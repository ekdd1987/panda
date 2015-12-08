<div class="udd-header clearfix">
  <div class="addfriend">
<?php
if($_SESSION["uuserid"]!="")
{

$sql112="select count(*) as alluu112 from shengji where jieuserid='".$_SESSION["uuserid"]."' and passed=0 ";
$query112=$db->query($sql112);
$rowallbao112=$db->fetch_array($query112);
$daishen=$rowallbao112['alluu112'];
?> 
    <a href="auditing.php?action=pending" class="button border-gray-light badge-corner text-yellow icon-smile-o"> 待审<span class="badge bg-red"><?php echo $daishen?></span></a>
    <?php }else{?>
    <a href="auditing.php" class="button border-gray-light badge-corner text-gray icon-smile-o"> 核实列表</a>
<?php }?>
        </div>
    <ul class="nav av-navicon nav-menu nav-inline admin-nav nav-tool">
<?
$url = $_SERVER['PHP_SELF']; 
$filename= substr( $url , strrpos($url , '/')+1 ); 
?>
  <table width="150" border="0" cellspacing="0" cellpadding="0" style=" font-size:12px">
  <tr>
    <td align="center"><a href="./"><img src="Static/images/1<?php if($filename=="index.php"){echo "1";}?>.png" width="40" height="41" /></a></td>
    <td align="center"><a href="user.php"><img src="Static/images/2<?php if($filename=="user.php"){echo "2";}?>.png" width="40" height="41" /></a></td>
    <?php if($filename=="reg.php"){?>
    <td align="center"><a href="#"><img src="Static/images/3<?php if($filename=="reg.php"){echo "3";}?>.png" width="40" height="41" /></a></td>
    <?php }else{?>
    <td align="center"><a href="reg.php?ic=<?php echo $rowuser["suijima"]?>"><img src="Static/images/3<?php if($filename=="reg.php"){echo "3";}?>.png" width="40" height="41" /></a></td>
    <?php }?>
  </tr>
</table>

       
        

            </ul>
</div>