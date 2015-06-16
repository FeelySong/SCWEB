<?php
session_start();
error_reporting(0);
require_once 'conn.php';
require_once 'check.php';

if($_POST['isverify']=="yes"){
	$_SESSION["cardflag"]="";
	$sqlb = "select * from ssc_member WHERE username='" . $_SESSION["username"] . "'";
	$rsb = mysql_query($sqlb);
	$rowb = mysql_fetch_array($rsb);
	
	if(md5($_POST['spwd'])==$rowb['cwpwd']){
		$sqla = "select * from ssc_bankcard WHERE id='" . $_POST['delid'] . "'";
		$rsa = mysql_query($sqla);
		$rowa = mysql_fetch_array($rsa);
		

		$sqlb = "delete from ssc_bankcard WHERE id='" . $_POST['delid'] . "'";
		$rsb = mysql_query($sqlb);
		amend("解绑银行卡".$rowa['cardno']);
		
		$_SESSION["backtitle"]="操作成功";
		$_SESSION["backurl"]="account_banks.php?check=114";
		$_SESSION["backzt"]="successed";
		$_SESSION["backname"]="我的银行卡";
		echo "<script language=javascript>window.location='sysmessage.php';</script>";
		exit;
	}else{
		$_SESSION["backtitle"]="资金密码错误";
		$_SESSION["backurl"]="account_banks.php?check=114";
		$_SESSION["backzt"]="failed";
		$_SESSION["backname"]="我的银行卡";
		echo "<script language=javascript>window.location='sysmessage.php';</script>";
		exit;
	}
}
?>