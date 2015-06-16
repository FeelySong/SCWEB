<?php
session_start();
error_reporting(0);
require_once 'conn.php';

//$_SESSION["sess_uid"]="";
if($_SESSION["sess_uid"]=="" || $_SESSION["username"] =="" || $_SESSION["valid"]==""){
	echo " {\"money\":\"Error\"}";
}else{
	$result = mysql_query("select count(*) from ssc_online where valid='".$_SESSION["valid"]."' and username='".$_SESSION["username"] ."'");   
	$num = mysql_result($result,"0");
	if($num!=0){
		$exe=mysql_query("update ssc_online set updatedate='".date("Y-m-d H:i:s")."' where valid='".$_SESSION["valid"]."' and username='".$_SESSION["username"] ."'"); 
		$sqla="select * from ssc_member where username='".$_SESSION["username"] ."'";
		$rsa=mysql_query($sqla) or  die("数据库修改出错!!!!".mysql_error());
		$rowa = mysql_fetch_array($rsa);
		if(empty($rowa)){
			$lmoney="empty";
		}else{
			$lmoney=number_format($rowa['leftmoney'],4);
		}
		echo " {\"money\":\"".$lmoney."\"}";
		$ddf=date( "Y-m-d H:i:s",time()-33);
		mysql_query( "delete from ssc_online where updatedate<'".$ddf."'");
	}else{
		echo " {\"money\":\"Error\"}";
	}

}
?>