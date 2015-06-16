<?php
session_start();
require_once 'conn.php';
//if(!defined('PHPYOU')) {
//	exit('Access Denied');
//}
mysql_query( "delete from ssc_online where username='".$_SESSION['username']."'");
unset($_SESSION['username']);
unset($_SESSION['uid']);
unset($_SESSION['valid']);
echo "<meta http-equiv=refresh content=\"0;URL=./\">";exit;
?>