<?php
session_start();
error_reporting(0);
require_once 'conn.php';
require_once 'check.php';

$frame=$_REQUEST['frame'];

if($frame=="team"){
	$sqls="select * from ssc_member where id='".$_REQUEST['uid']."'";
	$rss=mysql_query($sqls) or  die("数据库修改出错1".mysql_error());
	$rows = mysql_fetch_array($rss);
	echo "{error:0,result:".$rows['leftmoney']."}";
	exit;
}else if($frame=="menu"){
	$sqls="select * from ssc_member where regup='".Get_mname($_REQUEST['uid'])."'";
	$rss=mysql_query($sqls) or  die("数据库修改出错1".mysql_error());
	$rows = mysql_fetch_array($rss);
	echo "{\"result\":[{\"userid\":\"".$rows['id']."\",\"username\":\"".$rows['username']."\",\"usertype\":\"".$rows['level']."\",\"childcount\":\"".Get_xj($rows['username'])."\"}],\"error\":0}";
	exit;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>用户列表</title>
</head>
<frameset cols="150,*" frameborder="0" border="0" framespacing="0">
  <frame src="users_lista.php" name="userlist_menu" scrolling="yes" noresize="noresize" id="userlist_menu" title="menu" />
  <frame src="users_listb.php" name="userlist_content" id="userlist_content" title="content" />
</frameset>
<noframes><body>
</body>
</noframes></html>