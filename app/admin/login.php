<?php
session_start();
setcookie(session_name(), session_id(), time() + 3600*24, "/");
error_reporting(0);
require_once 'conn.php';

$name = trim($_POST['AdminId']);
$password = trim($_POST['Password']);
$vcode = trim($_POST['Code']);

if ($name == "" || $password == "") {
	echo "<script language=javascript>window.location='./';</script>";
	exit;
}
if ($vcode != $_SESSION['avalicode']) {
	echo "<script language=javascript>alert('验证码不正确，请重新输入');window.location='./';</script>";
	exit;
}

$sql = "select * from ssc_manager WHERE username='" . $name . "'";
$query = mysql_query($sql);
$dduser = mysql_fetch_array($query);


if(empty($dduser)){
	echo "<script>window.location='".$gourl."';</script>"; 
	exit;
}else{
	if($dduser['password']==md5($password)){
		$_SESSION["ausername"]=$name;
		$_SESSION["aid"]=$dduser['id'];
		$_SESSION["avalid"]=mt_rand(100000,999999);
		$_SESSION['admin_flag']=$dduser['qx'];

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

		$exe = mysql_query("update ssc_manager set lognums=lognums+1, lastip2=lastip, lastarea2=lastarea, lastdate2=lastdate, lastip='".$ip1."', lastarea='".$iparea."', lastdate='".date("Y-m-d H:i:s")."' where username='".$name."'");	
		$exe = mysql_query("insert into ssc_managerlogin set uid='".$dduser['id']."', username='".$name."', loginip='".$ip1."', loginarea='".$iparea."', logindate='".date("Y-m-d H:i:s")."', level='3'");
		$exe = mysql_query( "delete from ssc_online where username='".$name."'");
		$exe=mysql_query("delete from ssc_online where username='".$name."'") or  die("数据库修改出错". mysql_error());
		$exe=mysql_query("insert into ssc_online set yzstatus='1',uid='".$dduser['id']."', username='".$name."', ip='".$ip1."', addr='".$iparea."', adddate='".date("Y-m-d H:i:s")."', updatedate='".date("Y-m-d H:i:s")."', valid='".$_SESSION["avalid"]."', level='3'") or  die("数据库修改出错". mysql_error());
		echo "<script language=javascript>window.location='default_main.php';</script>";
		exit;
    }else{
        echo "<script>window.location='index.php';</script>"; 
        exit;
    }
}
?>
