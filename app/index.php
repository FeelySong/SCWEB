<?php
session_start();
error_reporting(0);
require_once 'conn.php';

$name = trim($_POST['username']);
$pwd = trim($_POST['password']);
$vcode = strtoupper(trim($_POST['vcodesource']));

if ($vcode!=$_SESSION['valicode']) {
echo "<script>alert(\"请输入正确的验证码！\"); window.location.href = './'; </script>";
//echo "<script> alert(\"验证码不正确，请重新输入！\"); window.location.href = './'; </script>";
exit;
}

if($webzt!='1'){
    echo "<script>window.location='".$gourl."';</script>"; 
    exit;
}

if($_SESSION["sess_uid"]!="" && $_SESSION["username"] !="" && $_SESSION["valid"]!=""){
	$result = mysql_query("select * from ssc_online where valid='".$_SESSION["valid"]."' and username='".$_SESSION["username"] ."'");  
	$total = mysql_num_rows($result);
	if($total!=0){
		echo "<script language=javascript>window.location='default_frame.php';</script>";
		exit;
	}
}

$sql = "select * from ssc_lockip WHERE ip='" . $_SERVER['REMOTE_ADDR'] . "'";
$query = mysql_query($sql);
$dduser = mysql_fetch_array($query);

if(empty($dduser)){
}else{
    echo "<script>window.location='".$gourl."';</script>"; 
    exit;
    }

  
if ($name == "" || $pwd == "") {
    echo "<script language=javascript>window.location.href='www.baidu.com';</script>";
    exit;
    }


$sql = "select * from ssc_member WHERE username='" . $name . "'";
$query = mysql_query($sql);
$dduser = mysql_fetch_array($query);

if(empty($dduser)){
	echo "<script>window.location='".$gourl."';</script>"; 
	exit;
}else{
	$pwd2 = $dduser['password'];
	$uid = $dduser['id'];
	$pwd= md5($pwd);
	if($pwd == $pwd2){
		if($dduser['zt']==2){
			echo "<script language=javascript>alert('您的帐户被锁定！');window.location='./';</script>";
			exit;
		}
		$_SESSION["sess_uid"] = $uid; 
		$_SESSION["username"] = $name; 
		$_SESSION["level"] = $dduser['level'];
		$_SESSION["valid"] = mt_rand(100000,999999);

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
		$exe = mysql_query("update ssc_member set lognums=lognums+1, lastip2=lastip, lastarea2=lastarea, lastdate2=lastdate, lastip='".$ip1."', lastarea='".$iparea."', lastdate='".date("Y-m-d H:i:s")."' where username='".$name."'");
		$exe = mysql_query("insert into ssc_memberlogin set uid='".$dduser['id']."', username='".$name."', nickname='".$dduser['nickname']."', loginip='".$ip1."', loginarea='".$iparea."', explorer='".$_SERVER['HTTP_USER_AGENT']."', logindate='".date("Y-m-d H:i:s")."', level='".$dduser['level']."'");
		$exe = mysql_query( "delete from ssc_online where username='".$name."'");
		$exe=mysql_query("delete from ssc_online where username='".$name."'") or  die("数据库修改出错". mysql_error());
		$exe=mysql_query("insert into ssc_online set uid='".$dduser['id']."', username='".$name."', nickname='".$dduser['nickname']."', ip='".$ip1."', explorer='".$_SERVER['HTTP_USER_AGENT']."', addr='".$iparea."', adddate='".date("Y-m-d H:i:s")."', updatedate='".date("Y-m-d H:i:s")."', valid='".$_SESSION["valid"]."', level='".$dduser['level']."'") or  die("数据库修改出错". mysql_error());
		$sqla = "select * from ssc_total WHERE logdate='" . date("Y-m-d") . "'";
		$rsa = mysql_query($sqla);
		$rowa = mysql_fetch_array($rsa);
		if(empty($rowa)){
			$exe=mysql_query("insert into ssc_total set nums".$dduser['level']."=nums".$dduser['level']."+1, logdate='" . date("Y-m-d") . "'") or  die("数据库修改出错". mysql_error());
		}else{
			$exe=mysql_query("update ssc_total set nums".$dduser['level']."=nums".$dduser['level']."+1 where logdate='" . date("Y-m-d") . "'") or  die("数据库修改出错". mysql_error());
		}

//登录充值开始		
$sql_jc = "select * from ssc_huodong where id=3";
$rs_jc = mysql_query($sql_jc);
$row_jc = mysql_fetch_array($rs_jc);	
if($row_jc['kg']==1){
		$sql_login = "select count(id) as tj from ssc_memberlogin WHERE uid='" .$dduser['id']. "' and logindate like'%".date("Y-m-d")."%'";
		$rs_login = mysql_query($sql_login);
		$row_login = mysql_fetch_array($rs_login);	
		
		$sql_loginip= "select count(id) as tjip from ssc_memberlogin WHERE loginip='".$ip1."' and logindate like'%".date("Y-m-d")."%'";
		$rs_loginip = mysql_query($sql_loginip);
		$row_loginip = mysql_fetch_array($rs_loginip);	
	
	if($row_login['tj']==1 && $row_loginip['tjip']==1){

		$sqla = "select * from ssc_member WHERE id='" . $dduser['id'] . "'";
		$rsa = mysql_query($sqla);
		$rowa = mysql_fetch_array($rsa);
		$leftmoney=$rowa['leftmoney'];
		$sqlc = "select * from ssc_record order by id desc limit 1";		//帐变
		$rsc = mysql_query($sqlc);
		$rowc = mysql_fetch_array($rsc);
		$dan1 = sprintf("%07s",strtoupper(base_convert($rowc['id']+1,10,36)));
			$lmoney=$row_jc['jieguo'];
		
			$sqla="insert into ssc_record set dan='".$dan1."', uid='".$dduser['id']."', username='".Get_mname($dduser['id'])."', types='60', smoney=".$lmoney.",leftmoney=leftmoney+".$lmoney.", regtop='".$rowa['regtop']."', regup='".$rowa['regup']."', regfrom='".$rowa['regfrom']."', adddate='".date("Y-m-d H:i:s")."'";
			$exe=mysql_query($sqla) or  die("数据库修改出错6!!!".mysql_error());

			$sqlb="insert into ssc_savelist set uid='".$dduser['id']."', username='".Get_mname($dduser['id'])."', bank='登录充值', bankid='0', cardno='', money=".$lmoney.", sxmoney='0', rmoney=".$lmoney.", adddate='".date("Y-m-d H:i:s")."',zt='1',types='60'";
			$exe=mysql_query($sqlb) or  die("数据库修改出错6!!!".mysql_error());


			$sql="update ssc_member set leftmoney =(leftmoney+".$lmoney."),totalmoney=(totalmoney+".$lmoney.") where id ='".$dduser['id']."'";
			$exe=mysql_query($sql) or  die("数据库修改出错6!!!".mysql_error());		
	}	
}		
//登录充值结束		
		
		echo "<script language=javascript>window.location='default_frame.php';</script>";
		exit;
	}else{
		echo "<script language=javascript>alert('登陆失败，请检查您的帐户名与密码');window.location='./';</script>";
		exit;
	}
    }