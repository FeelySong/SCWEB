<?php
session_start();
error_reporting(0);
require_once 'conn.php';

if (strpos($_SESSION['admin_flag'],'95') ){}else{ 
	echo "<script language=javascript>alert('对不起，您无此权限！');window.history.go(-1);</script>";
exit;}

if($_GET['act']=="add"){
	$sql="insert into ssc_domin set url='".$_POST['url']."'";
	$exe=mysql_query($sql) or  die("数据库修改出错1");
	echo "<script>alert('添加成功！');window.location.href='url.php';</script>"; 
	exit;
}

if($_GET['act']=="edit"){
//	echo $_POST['content1'];
	$sql="update ssc_domin set url='".$_POST['url']."' where id=".$_GET['id'];
//	echo $sql;
	$exe=mysql_query($sql) or  die("数据库修改出错2");
	echo "<script>alert('编辑成功！');window.location.href='url.php';</script>"; 
	exit;
}
if($_GET['act']=="del"){
	mysql_query("Delete from ssc_domin where id=".$_GET['id']);
	echo "<script>alert('删除成功！');window.location.href='url.php';</script>"; 
	exit;
}


$sql="select * from ssc_domin order by id asc";
$rsnewslist = mysql_query($sql);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link href="css/index.css" rel="stylesheet" type="text/css">
</head>

<body>
<div align="center"><br />
	<table width="95%" border="0" cellpadding="0" cellspacing="0" class="top_list">
      <tr>
        <td class="top_list_td icons_a9">　　您现在的位置是：系统管理 &gt; 域名管理</td>
        <td width="100" class="top_list_td"><input name="Add_activity" type="button" value="添加域名" class="Font_B" onclick="javascript:window.location='url_edit.php?act=add';" id="Add_activity" /></td>
      </tr>
    </table>
<br />
	<table width="95%" border="1" cellpadding="0" cellspacing="0" bordercolor="#DDDDDD" class="t_list">
			<tr>
				<td class="t_list_caption">序号</td>
			  <td class="t_list_caption">域名</td>
			  <td width="120" class="t_list_caption">操作</td>
			</tr>
			<?php 
			$i=0;
			while ($row = mysql_fetch_array($rsnewslist)){?>
            <form action="?act=edit" method="post" name="form1" id="form1">
			<tr class="t_list_tr_<?=$i%2?>" onMouseOver="this.style.backgroundColor='#E8F1FF'" onMouseOut="this.style.backgroundColor=''">
				<td height="25"  align="center"><?=$row['id']?></td>
				<td align="center"><?=$row['url']?></td>
				<td align="center"><a href="url_edit.php?act=edit&id=<?=$row['id']?>"   onClick="return confirm('确认要修改吗?');">修改</a> <a href="url.php?act=del&id=<?=$row['id']?>"   onClick="return confirm('确认要删除吗?');">删除</a></td>
			</tr>
			</form>
			<?php 
			$i=$i+1;
			}
			?>
	</table>
</div>
</body>
</html>
