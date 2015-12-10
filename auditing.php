<?php
require_once("includes/conn.php");
require_once("checkuser.php");
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>核实会员 - 天天创客</title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta name="mobileoptimized" content="0"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
    <meta http-equiv="Expires" content="-1">
    <meta http-equiv="pragram" content="no-cache">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <meta name="browsermode" content="application">

    <link rel="stylesheet" href="Static/css/pintuer.css?d=20150710">
    <link rel="stylesheet" href="Static/css/style.css?d=20150710">
    <script type="text/javascript" src="Static/js/jquery.min.js"></script>
    <script type="text/javascript" src="Static/js/pintuer.js?d=20150710"></script>
    <script type="text/javascript" src="Static/js/respond.js"></script>
</head>

<body>
<?
if ($_GET['act'] == "qr") {

    $sql = "select * from shengji where id='" . $_GET['id'] . "' and jieuserid='" . $rowuser['id'] . "' and passed=0 limit 1";
    $query = $db->query($sql);
    $row = $db->fetch_array($query);
    if (is_array($row)) {
        $sql2 = "select * from users where id='" . $row['userid'] . "' limit 1";
        $query2 = $db->query($sql2);
        $row2 = $db->fetch_array($query2);
        if (is_array($row2)) {
            if ($row2['standardlevel'] < $row['jibie']) {
                if ($row['jibie'] == 1) {
                    //如果是新会员

                    $sql12 = "select * from users where (find_in_set('" . $row2['rid'] . "', ppath) or id='" . $row2['rid'] . "') order by ceng asc,area asc,id asc ";
                    $query12 = $db->query($sql12);
                    while ($row12 = $db->fetch_array($query12)) {

                        $sql = "select count(*) as alluu from users where pid= '" . $row12['id'] . "' ";
                        $query = $db->query($sql);
                        $rowallbao = $db->fetch_array($query);
                        if ($rowallbao['alluu'] == 0) {
                            $hualuopid = $row12['id'];
                            $hualuoarea = 1;
                            $ceng = $row12['ceng'] + 1;
                            $ppath = $row12['ppath'] . "," . $row12['id'];
                            break;
                        } else if ($rowallbao['alluu'] == 1) {
                            $hualuopid = $row12['id'];
                            $hualuoarea = 2;
                            $ceng = $row12['ceng'] + 1;
                            $ppath = $row12['ppath'] . "," . $row12['id'];
                            break;
                        } else if ($rowallbao['alluu'] == 2) {
                            $hualuopid = $row12['id'];
                            $hualuoarea = 3;
                            $ceng = $row12['ceng'] + 1;
                            $ppath = $row12['ppath'] . "," . $row12['id'];
                            break;
                        }

                    }

                    $sql11 = "select count(*) as alluu11 from users where states=1 ";
                    $query11 = $db->query($sql11);
                    $rowallbao11 = $db->fetch_array($query11);
                    $nowshunxu = $rowallbao11['alluu11'];
                    $shunxu = $nowshunxu + 1;
                    //找出滑落点位

                    $sql = 'UPDATE users SET states=1,jihuodate="' . date("Y-m-d") . '",jihuotime="' . date("Y-m-d H:i:s") . '",shunxu="' . $shunxu . '",pid="' . $hualuopid . '",area="' . $hualuoarea . '",ceng="' . $ceng . '",ppath="' . $ppath . '" WHERE id=' . $row['userid'] . '';
                    $db->query($sql);
                    $sql = 'UPDATE users SET nextusernum=nextusernum+1 WHERE id="' . $hualuopid . '" ';
                    $db->query($sql);

                    $sql = 'UPDATE users SET tjnum=tjnum+1 WHERE id="' . $row['rid'] . '" ';
                    $db->query($sql);
                    //先写入
                    $str = $hualuoarea;
                    $sql12 = "select * from users where id in(" . $ppath . ")  order by ceng desc ";
                    $query12 = mysql_query($sql12);
                    while ($row12 = mysql_fetch_array($query12)) {
                        if ($str == 1) {
                            $asql12 = "Update users set num1=num1+1 where id =" . $row12['id'] . " ";
                            mysql_query($asql12);
                        }
                        if ($str == 2) {
                            $asql12 = "Update users set num2=num2+1 where id =" . $row12['id'] . " ";
                            mysql_query($asql12);
                        }
                        if ($str == 3) {
                            $asql12 = "Update users set num3=num3+1 where id =" . $row12['id'] . " ";
                            mysql_query($asql12);
                        }

                        $str = $row12['area'];
                    }
                    //先写入
                    //qqqqqq
                    $bdsql = "Update users set standardlevel=" . $row['jibie'] . " where id ='" . $row2['id'] . "' ";
                    $db->query($bdsql);

                    //如果是新会员
                } else {
                    //如果是老会员
                    $bdsql = "Update users set standardlevel=" . $row['jibie'] . " where id ='" . $row2['id'] . "' ";
                    $db->query($bdsql);
                }

                $bdsql = "Update shengji set passed=1,passtime='" . date("Y-m-d H:i:s") . "' where id ='" . $row['id'] . "' ";
                $db->query($bdsql);
            }
        }
    } else {
        echo "<script>alert('记录不存在!');history.go(-1);</script>";
        exit();
    }


    echo "<script>alert('通过成功!');window.parent.location.href='auditing.php';</script>";
    exit();


}
?>
<div class="container">
    <?php
    require_once("top.php");
    ?>
    <div class="udd-body">
        <div class="panel">
            <div class="panel-body bg-white">
                <span class="text-yellow icon-bell-o" style="color:#ffae31; font-size:16px"> 为确保会员真实性，请确认双方已加为微信好友再做核实通过操作。</span>
            </div>
        </div>
        <br/>
        <table class="table table-bordered">

            <tr class="blue">
                <th width="30%" class="text-center">会员/微信</th>
                <th width="22%" class="text-center">申请升级</th>
                <th class="text-center">申请时间</th>
                <th width="20%" class="text-center">核实</th>
            </tr>
            <?php
            $myKeyword = $_POST['myKeyword'];
            $t = $_GET['t'];
            if ($types) $sqladd .= " and types ='" . trim($types) . "' ";
            if ($t <> "") $sqladd .= " and states ='" . trim($t) . "' ";
            if ($myKeyword) $sqladd .= " and loginname like '%" . trim($myKeyword) . "%' ";
            $sqladd .= '  ORDER BY id DESC';

            $perNumber = 20; //每页显示的记录数
            $page = $_GET['page']; //获得当前的页面值
            $count = $db->query("select count(*) from shengji where jieuserid='" . $_SESSION["uuserid"] . "' {$sqladd}"); //获得记录总数
            $rs = $db->fetch_array($count);
            $totalNumber = $rs[0];
            $totalPage = ceil($totalNumber / $perNumber); //计算出总页数
            if (!isset($page)) {
                $page = 1;
            } //如果没有值,则赋值1
            if (empty($page)) {
                $page = 1;
            }
            $startCount = ($page - 1) * $perNumber; //分页开始,根据此方法计算出开始的记录
            $result = $db->query("select * from shengji where jieuserid='" . $_SESSION["uuserid"] . "' {$sqladd} limit $startCount,$perNumber"); //根据前面的计算出开始的记录和记录数
            ?>
            <?php
            while ($row = $db->fetch_array($result)) {

                $users = new users();
                $rowu = $users->get_user_byid($db, $row['userid']);
                if (!empty($rowu)) {
                    ?>
                    <tr class="bg-white">

                        <td><?php echo $rowu['nickname'] ?><br><span
                                class="text-yellow"><?php echo $rowu['wechat'] ?></span><br><span
                                class="text-blue"><?php echo $rowu['loginname'] ?></span></td>
                        <td><?php echo userjibiename($row['jibie']) ?>(<? if ($row['types'] == 1) {
                                echo "<font color=#b96d0a>升级</font>";
                            } else {
                                echo "<font color=blue>核实</font>";
                            } ?>)
                        </td>
                        <td><?php echo $row['addtime'] ?></td>
                        <td>
                            <span class="text-green"><? if ($row['passed'] == 1) {
                                    echo "已通过";
                                } else {
                                    echo "<a href=?act=qr&id=" . $row['id'] . " target='formprocess' onClick='javascript:return confirm(&#39;确认通过？&#39;);' target='formprocess'><font color=red>确认</font></a>";
                                } ?></span>
                        </td>
                    </tr>
                    <?
                }

            }
            ?>


            <tr class="bg-white">
                <td colspan="4" align="center"><?
                    getNavHtml($page, $perNumber, $totalNumber, '?t=' . $t . '&');
                    ?></td>
            </tr>
        </table>

    </div>
    <iframe src="null.html" name="formprocess" style="display:none;"></iframe>
    <br/>


    <?php
    require_once("foot.php");
    ?>
</div>
<script>
    $('.button-pass').click(function () {
        if (confirm('确定要通过该会员的升级申请吗？')) {
            var btn = $(this);
            var upid = $(this).attr('data-id');
            var url = 'auditing.php';
            var submitData = {
                action: 'auditing',
                upid: upid
            };
            btn.attr('disabled', 'disabled');
            $.post(url, submitData,
                function (responseText, status) {
                    if (status == 'success') {
                        if (responseText != '') {
                            var result = eval("(" + responseText + ")");
                            if (result.status == 1) {
                                btn.after('<span class="text-green">已通过</span>');
                                btn.remove();
                            } else {
                                alert(result.msg);
                            }
                        } else {
                            alert('返回数据错误！');
                        }
                    } else {
                        alert('服务器繁忙，请稍后重试！');
                    }
                    btn.removeAttr('disabled');
                });
        }
    });

</script>
</body>
</html>
