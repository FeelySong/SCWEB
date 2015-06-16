<?php
session_start();
error_reporting(0);
require_once 'conn.php';

$name = trim($_POST['username']);
$pwd2 = trim($_POST['loginpass_source']);
$pwd1 = trim($_POST['loginpass_first']);

if ($name == "" || $pwd1 == "" || $pwd2 == "") {
	echo "<script language=javascript>window.location='default_getpass.php';</script>";
	exit;
}
if ($pwd1 != $pwd2) {
	echo "<script language=javascript>alert('两次输入的密码不一致，请重新确认');window.location='default_getpass.php';</script>";
	exit;
}

$sql = "select * from ssc_member WHERE username='" . $name . "'";
$query = mysql_query($sql);
$dduser = mysql_fetch_array($query);

if(empty($dduser)){
	echo "<script>alert('帐号和资金密码验证失败');window.location='default_getpass.php';</script>"; 
	exit;
}else{
	$pwd = $dduser['password'];
	$pwd3= $dduser['cwpwd'];
	
	$pwd1= md5($pwd1);
	if($pwd1 == $pwd3){
		echo "<script language=javascript>alert('登陆密码不能和资金密码一样!');window.location='default_getpass.php';</script>";
		exit;	
	}
	if($pwd == $pwd1){
		echo "<script language=javascript>alert('登陆密码修改失败，新密码可能和原来密码一样');window.location='default_getpass.php';</script>";
		exit;
	}else{
		$exe = mysql_query( "update ssc_member set password = '".$pwd1."' where username='".$name."'");

		require_once 'ip.php';
		$ip1 = $_SERVER['REMOTE_ADDR'];
		$iplocation = new iplocate();
		$address=$iplocation->getaddress($ip1);
		$iparea = $address['area1'].$address['area2'];

//		$ip1=$_SERVER['REMOTE_ADDR'];
//		$ip2=explode(".",$ip1);
//		if(count($ip2)==4){
//			$ip3=$ip2[0]*256*256*256+$ip2[1]*256*256+$ip2[2]*256+$ip2[3];
			
//			$sql = "select * from ssc_ipdata WHERE StartIP<=".$ip3." and EndIP>=".$ip3."";
//			$quip = mysql_query($sql) or  die("数据库修改出错". mysql_error());
//			$dip = mysql_fetch_array($quip);
//			$iparea = $dip['Country']." ".$dip['Local'];
//		}
		$exe = mysql_query( "insert into ssc_memberamend set username = '".$name."',uid = '".$dduser['id']."',nickname = '".$dduser['nickname']."', cont='修改登陆密码', ip='".$ip1."', area='".$iparea."', adddate='".date("Y-m-d H:i:s")."', level='".$dduser['level']."'");
		echo "<script language=javascript>alert('修改登陆密码成功');window.location='./';</script>";
		exit;
	}
}
?>