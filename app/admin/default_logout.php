<?php
session_start();
require_once 'conn.php';
//if(!defined('PHPYOU')) {
//	exit('Access Denied');
//}
mysql_query( "delete from ssc_online where username='".$_SESSION['ausername']."'");
unset($_SESSION['ausername']);
unset($_SESSION['aid']);
unset($_SESSION['admin_flag']);
echo "<meta http-equiv=refresh content=\"0;URL=./\">";exit;
?>