<?php
session_start();
error_reporting(0);
require_once 'conn.php';
require_once 'check.php';

$flag = trim($_GET['flag']);
if($flag=="open"){
	if($_GET['uid']!=""){
        $sql = "update ssc_member set czzt='1', czxg='500' WHERE id='" . $_GET['uid'] . "'";
        $rs = mysql_query($sql);
    }

	$_SESSION["backtitle"]="操作成功";
	$_SESSION["backurl"]="users_listb.php";
	$_SESSION["backzt"]="successed";				
	$_SESSION["backname"]="用户列表";
	echo "<script language=javascript>window.location='sysmessage.php';</script>";
	exit;
}
if($flag=="close"){
	if($_GET['uid']!=""){
        $sql = "update ssc_member set czzt='0' WHERE like '%&".Get_mname($_GET['uid'])."%&')";	
        $rs = mysql_query($sql);
    }
	
	$_SESSION["backtitle"]="操作成功";
	$_SESSION["backurl"]="users_listb.php";
	$_SESSION["backzt"]="successed";				
	$_SESSION["backname"]="用户列表";
	echo "<script language=javascript>window.location='sysmessage.php';</script>";
	exit;
}

?>