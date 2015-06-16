<?php
session_start();
setcookie(session_name(), session_id(), time() + 3600*24, "/");
error_reporting(0);
require_once 'conn.php';

if($_SESSION["aid"]=="" || $_SESSION["ausername"]=="" || $_SESSION["avalid"]==""){
	echo " {\"msga\":\"Error\"}";
}else{
	$result = mysql_query("select count(*) from ssc_online where valid='".$_SESSION["avalid"]."' and username='".$_SESSION["ausername"]."'");
	$num = mysql_result($result,"0");
	if($num!=0){
		$exe=mysql_query("update ssc_online set updatedate='".date("Y-m-d H:i:s")."' where valid='".$_SESSION["avalid"]."' and username='".$_SESSION["ausername"]."'"); 

		$sqla="select count(*) as numa from ssc_kf where sign=1 and zt=0";
		$rsa=mysql_query($sqla) or  die("数据库修改出错!!!!".mysql_error());
		$rowa = mysql_fetch_array($rsa);
		$msga=$rowa['numa'];
	
		$sqlb="select count(*) as numb from ssc_drawlist where zt=0";
		$rsb=mysql_query($sqlb) or  die("数据库修改出错!!!!".mysql_error());
		$rowb = mysql_fetch_array($rsb);
		$msgb=$rowb['numb'];
	
		echo " {\"msga\":\"".$msga."\",\"msgb\":\"".$msgb."\"}";
		$ddf=date( "Y-m-d H:i:s",time()-33);
		mysql_query( "delete from ssc_online where updatedate<'".$ddf."'");
	}else{
		echo " {\"msga\":\"Error\"}";
	}
}
?>