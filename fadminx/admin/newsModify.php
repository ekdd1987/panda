<?php
include("../Admin.php");
include("../../includes/conn.php");
?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<LINK href="../Admin_STYLE.CSS" rel=stylesheet type=text/css>
<!--jbox-->
<script type="text/javascript" src="../../jBox/jquery-1.4.2.min.js"></script>
<link id="skin" rel="stylesheet" href="../../jBox/Skins/Default/jbox.css" />
<script type="text/javascript" src="../../jBox/jquery.jBox-2.3.min.js"></script>
<script type="text/javascript" src="../../jBox/i18n/jquery.jBox-zh-CN.js"></script>
<!--jbox-->
<script charset="gb2312" src="../../kindeediitor/kindeditor-min.js"></script>
<script charset="gb2312" src="../../kindeediitor/lang/zh_CN.js"></script>
<script charset="gb2312" src="../../kindeediitor/plugins/code/prettify.js"></script>
	<script>
		KindEditor.ready(function(K) {
			var editor1 = K.create('textarea[name="content"]', {
				cssPath : '../../kindeediitor/plugins/code/prettify.css',
				uploadJson : '../../kindeediitor/asp/upload_json.php',
				fileManagerJson : '../../kindeediitor/asp/file_manager_json.php',
				allowFileManager : true,
				afterCreate : function() {
					var self = this;
					K.ctrl(document, 13, function() {
						self.sync();
						K('form[name=example]')[0].submit();
					});
					K.ctrl(self.edit.doc, 13, function() {
						self.sync();
						K('form[name=example]')[0].submit();
					});
				}
			});
			prettyPrint();
		});
	</script>
<style>
			form {
				margin: 0;
			}
			textarea {
				display: block;
			}
</style>
<?php
	$htmlData = '';
	if (!empty($_POST['content1'])) {
		if (get_magic_quotes_gpc()) {
			$htmlData = stripslashes($_POST['content1']);
		} else {
			$htmlData = $_POST['content1'];
		}
	}
?>

<?
$ArticleID=$_GET['ArticleID'];
		 $sql="select * from adhgfqws65ljdlgr where ID='".$ArticleID."'";
		 $query=$db->query($sql);
		 $row=$db->fetch_array($query);
?>

<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<body>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="862" align="center" valign="top">
	<br>
      <br>
      <b> </b><b>修 改 信 息</b><br>
      <form method="POST" name="myform" onSubmit="return CheckForm();" action="newsSave.php?action=Modify&types=<? echo $_GET['types']?>">
        <table width="900" border="0" align="center" cellpadding="0" cellspacing="0" class="border">
          <tr>
            <td height="25" align="center" class="title">&nbsp;</td>
    </tr>
    <tr align="center">
      <td class="tdbg">
	<table width="100%" border="0" cellpadding="0" cellspacing="2">

                <tr> 
                  <td width="121" height="22" align="right" >用户名：</td>
                  <td width="596" > <input name="username" type="text"
           id="Title2" value="<? echo $row['username']?>" size="50">
                  <font color="#FF0000">*</font></td>
                </tr>
                <tr> 
<script>
function demo_1_4() {
    $.jBox("iframe:../../tu.php", {
        title: "图片上传",
        width: 400,
        height: 30,
        buttons: { '关闭': true }
    });
}
</script>
                  <td width="121" height="22" align="right" >密码：</td>
                  <td width="596" > <input name="password" type="text"
           id="password" size="50">
                  <font color="#FF0000">*</font></td>
                </tr>
              </table>
      </td>
    </tr>
  </table>
  <div align="center">
    <p>
      <input name="ArticleID" type="hidden" id="ArticleID" value="<? echo $row['ID']?>">
      <input
  name="Save" type="submit"  id="Save" value="保存修改结果">
    </p>
  </div>
</form>
    </td>
  </tr>
</table>

