<?php
set_magic_quotes_runtime(0);
@header("content-Type: text/html; charset=utf-8");
define('PHPYOU','v1.0');
//此软件仅供学习测试使用，不得用于非法用途！
if(function_exists('date_default_timezone_set')) {

	@date_default_timezone_set('Etc/GMT-8');

}

$conn = mysql_pconnect( "localhost", "root", "root" );
if (!$conn)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db( "yzcp2013" );
mysql_query( "SET NAMES 'utf8'" );

$sqlzz = "select * from ssc_config";
$rszz = mysql_query($sqlzz);
$rowzz = mysql_fetch_array($rszz);
$webzt=$rowzz['zt'];
$webzt2=$rowzz['zt2'];
$count=$rowzz['counts'];
$webname=$rowzz['webname'];
$gourl=$rowzz['rurl'];


function amend($rrr){   
	require_once 'ip.php';
	$ip1 = $_SERVER['REMOTE_ADDR'];
	$iplocation = new iplocate();
	$address=$iplocation->getaddress($ip1);
	$iparea = $address['area1'].$address['area2'];

	$exe = mysql_query( "insert into ssc_memberamend set uid = '".$_SESSION["sess_uid"]."',username = '".$_SESSION["username"] ."',level = '".$_SESSION["level"]."', cont='".$rrr."', ip='".$ip1."', area='".$iparea."', adddate='".date("Y-m-d H:i:s")."'");
//return $rrr;
}

function judgez($rrr){   
if($rrr<0){
	$rrr=0;
}
return $rrr;
}

function dlid($rrr,$lid){   
if($lid=="4"){
	$rrr="20".substr($rrr,0,6)."-".substr($rrr,-3);	
}else if($lid=="7" || $lid=="11"){
	$rrr="20".substr($rrr,0,6)."-".substr($rrr,-2);	
}
return $rrr;
}

function ddlid($rrr,$lid){   
if($lid=="4"){
	$rrr=substr(str_replace("-","",$rrr),-9);	
}else if($lid=="7" || $lid=="11"){
	$rrr=substr(str_replace("-","",$rrr),-8);	
}
return $rrr;
}

function dcode($rrr,$lid){   
if(strpos($rrr,"|")===false){
	$rrr=str_replace("&",",",$rrr);
}else{
	$rrr=str_replace("|",",",$rrr);
	if($lid=="6" || $lid=="7" || $lid=="8" || $lid=="11"){
		$rrr=str_replace("&"," ",$rrr);	
	}else{
		$rrr=str_replace("&","",$rrr);
	}
}
return $rrr;
}

function Get_member($rrr){
$result=mysql_query("Select * from ssc_member where username='".$_SESSION["username"] ."'"); 
$raa=mysql_fetch_array($result); 
return $raa[$rrr];
}

function Get_canceldate($rrr,$sss){
if($rrr<5){
	$sss1=substr($sss,-3);
}else if($rrr==9 || $rrr==10){
	$sss1=1;
	$sss=date("ymd");
}else{
	$sss1=substr($sss,-2);
}
$result=mysql_query("Select * from ssc_nums where cid='".$rrr."' and nums='".$sss1."'"); 
$raa=mysql_fetch_array($result);

//$sss2="20".substr($sss,0,2)."-".substr($sss,2,2)."-".substr($sss,4,2);
if($rrr==4 || $rrr==7 || $rrr==11){
$sss2=date("Y-m-d H:i:s",mktime(substr($raa['endtimes'],0,2),substr($raa['endtimes'],3,2),substr($raa['endtimes'],6,2),substr($sss,4,2),substr($sss,6,2),"20".substr($sss,2,2)));
}else{
$sss2=date("Y-m-d H:i:s",mktime(substr($raa['endtimes'],0,2),substr($raa['endtimes'],3,2),substr($raa['endtimes'],6,2),substr($sss,2,2),substr($sss,4,2),"20".substr($sss,0,2)));
}
//$rrr=$raa['endtime'];
return $sss2;
}

function Get_rate($rrr){
$result=mysql_query("Select * from ssc_class where mid='".$rrr."'"); 
$raa=mysql_fetch_array($result);
return $raa['rates'];
}

function Get_mname($rrr){
$result=mysql_query("Select * from ssc_member where id='".$rrr."'"); 
$raa=mysql_fetch_array($result); 
return $raa['username'];
}

function Get_mrebate($rrr){
$result=mysql_query("Select * from ssc_member where id='".$rrr."'"); 
$raa=mysql_fetch_array($result); 
return $raa['rebate'];
}

function Get_memid($rrr){
$result=mysql_query("Select * from ssc_member where username='".$rrr."'"); 
$raa=mysql_fetch_array($result); 
return $raa['id'];
}

function Get_mmoney($rrr){
$result=mysql_query("Select * from ssc_member where id='".$rrr."'"); 
$raa=mysql_fetch_array($result); 
return $raa['leftmoney'];
}

function Get_mmoneys($rrr){
$result=mysql_query("Select * from ssc_member where username='".$rrr."'"); 
$raa=mysql_fetch_array($result); 
return $raa['leftmoney'];
}

function Get_online($rrr){   
$result=mysql_query("Select count(*) as nums from ssc_online where username='".$rrr."'"); 
$raa=mysql_fetch_array($result); 
return $raa['nums'];
}

function Get_xj($rrr){   //下级
$result=mysql_query("Select count(*) as nums from ssc_member where regup='".$rrr."'"); 
$raa=mysql_fetch_array($result); 
return $raa['nums'];
}

function Get_mid($rrr){   
$result=mysql_query("Select * from ssc_class where mid='".$rrr."'"); 
$raa=mysql_fetch_array($result); 
return $raa['name'];
}

function Get_lottery($rrr){   
$result=mysql_query("Select * from ssc_set where id='".$rrr."'"); 
$raa=mysql_fetch_array($result); 
return $raa['name'];
}

function Get_province($rrr){   
$result=mysql_query("Select * from ssc_province where pid='".$rrr."'"); 
$raa=mysql_fetch_array($result); 
return $raa['name'];
}

function Get_bank($rrr){   
$result=mysql_query("Select * from ssc_banks where tid='".$rrr."'"); 
$raa=mysql_fetch_array($result); 
return $raa['name'];
}

function Get_city($rrr){   
$result=mysql_query("Select * from ssc_city where cid='".$rrr."'"); 
$raa=mysql_fetch_array($result); 
return $raa['name'];
}

function rep_str($rrr){   
$repa=str_replace(":","",$rrr);
$repa=str_replace(",","",$repa);
return $repa;
}
?>