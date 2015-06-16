<?php
set_magic_quotes_runtime(0);
@header("content-Type: text/html; charset=utf-8");
define('PHPYOU','v1.0');

if(function_exists('date_default_timezone_set')) {

	@date_default_timezone_set('Etc/GMT-8');

}

$conn = mysql_pconnect( "littlemonk.net", "root", "shl850325" );
if (!$conn)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db( "shijue" );
mysql_query( "SET NAMES 'utf8'" );
require_once 'autokja.php';

$sqlzz = "select * from ssc_config";
$rszz = mysql_query($sqlzz);
$rowzz = mysql_fetch_array($rszz);
$webzt=$rowzz['ht'];
$count=$rowzz['counts'];
$webname=$rowzz['webname'];
$gourl=$rowzz['rurl'];

function amend($rrr){   
	require_once 'ip.php';
	$ip1 = $_SERVER['REMOTE_ADDR'];
	$iplocation = new iplocate();
	$address=$iplocation->getaddress($ip1);
	$iparea = $address['area1'].$address['area2'];

	$exe = mysql_query( "insert into ssc_manageramend set uid = '".$_SESSION["aid"]."',username = '".$_SESSION["ausername"]."', cont='".$rrr."', ip='".$ip1."', area='".$iparea."', adddate='".date("Y-m-d H:i:s")."'");
//return $rrr;
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

function judgez($rrr){   
if($rrr<0){
	$rrr=0;
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
}else{
	$sss1=substr($sss,-2);
}
$result=mysql_query("Select * from ssc_nums where cid='".$rrr."' and nums='".$sss1."'"); 
$raa=mysql_fetch_array($result);

//$sss2="20".substr($sss,0,2)."-".substr($sss,2,2)."-".substr($sss,4,2);
$sss2=date("Y-m-d H:i:s",mktime(substr($raa['endtimes'],0,2),substr($raa['endtimes'],3,2),substr($raa['endtimes'],6,2),substr($sss,2,2),substr($sss,4,2),"20".substr($sss,0,2)));
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

function Get_aname($rrr){
$result=mysql_query("Select * from ssc_manager where id='".$rrr."'"); 
$raa=mysql_fetch_array($result); 
return $raa['username'];
}

function Get_cname($rrr){
$result=mysql_query("Select * from ssc_bankcard where id='".$rrr."'"); 
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

function kjdata($t2,$cid,$t1,$t3){
		if($t2!=""){
			$t4=split(",",$t2);
			$n1=$t4[0];
			$n2=$t4[1];
			$n3=$t4[2];
	//			echo $row['id'];
			if($cid!=5 && $cid!=9){
				$n4=$t4[3];
				$n5=$t4[4];
			}
		}
		$n1=intval($n1);
		$n2=intval($n2);
		$n3=intval($n3);
		$n4=intval($n4);
		$n5=intval($n5);
		
		echo Get_lottery($cid)."第".$t1."期:".$t2."<br>";
		
		$sql = "select * from ssc_data where cid='".$cid."' and issue='".$t1."'";		
//			echo $sql."<br>";
		$rsa = mysql_query($sql);
		$rowa = mysql_fetch_array($rsa);
		$tts=0;
		if($cid==1 || $cid==2 || $cid==3 || $cid==4){
			if($n1=="0" && $n2=="0" && $n3=="0" && $n4=="0" && $n5=="0"){$tts=1;}
			if($n1>9 || $n2>9 || $n3>9 || $n4>9 || $n5>9){$tts=1;}			
		}else if($cid==5){
			if($n1=="0" && $n2=="0" && $n3=="0"){$tts=1;}
			if($n1>9 || $n2>9 || $n3>9){$tts=1;}			
		}else if($cid==6 || $cid==7 || $cid==8 || $cid==11){
			if($n1=="0" && $n2=="0" && $n3=="0" && $n4=="0" && $n5=="0"){$tts=1;}
			if($n1>11 || $n2>11 || $n3>11 || $n4>11 || $n5>11){$tts=1;}
		}else if($cid==9){
			if($n1=="0" && $n2=="0" && $n3=="0"){$tts=1;}
			if($n1>9 || $n2>9 || $n3>9){$tts=1;}
		}else if($cid==10){
			if($n1=="0" && $n2=="0" && $n3=="0" && $n4=="0" && $n5=="0"){$tts=1;}
			if($n1>9 || $n2>9 || $n3>9 || $n4>9 || $n5>9){$tts=1;}			
		}
		
		if(empty($rowa)){
			if($tts==0){
				$sql="INSERT INTO ssc_data set cid='".$cid."', name='".Get_lottery($cid)."', issue='".$t1."', code='".$t2."', n1='".$n1."', n2='".$n2."', n3='".$n3."', n4='".$n4."', n5='".$n5."',opentime='".$t3."', addtime='".date("Y-m-d H:i:s")."'";
//				echo $row['name']."第".$t1."期:".$t2."<br>";
				$exe=mysql_query($sql) or  die("数据库修改出错!!!!".mysql_error());
			}
		}else{
			if($rowa['zt']!="1"){
				if($rowa['sign']>5){

				}else{
					$sqls="update ssc_data set sign=sign+1 where id ='".$rowa['id']."'";
					$rss=mysql_query($sqls) or  die("数据库修改出错1".mysql_error());
				}
			}
		}
		autokj($n1,$n2,$n3,$n4,$n5,$cid,$t1,1);
}

function determinebrowser ($Agent) {  
$browseragent="";   //浏览器  
$browserversion=""; //浏览器的版本  
	if (ereg('MSIE ([0-9].[0-9]{1,2})',$Agent,$version)) {  
		$browserversion=$version[1];
		$browseragent="Internet Explorer";
	} else if (ereg( 'Opera/([0-9]{1,2}.[0-9]{1,2})',$Agent,$version)) {  
		$browserversion=$version[1]; 
		$browseragent="Opera";  
	} else if (ereg( 'Firefox/([0-9.]{1,5})',$Agent,$version)) {  
		$browserversion=$version[1];  
		$browseragent="Firefox";  
	}else if (ereg( 'Chrome/([0-9.]{1,3})',$Agent,$version)) {  
		$browserversion=$version[1];  
		$browseragent="Chrome";  
	}else if (ereg( 'Safari/([0-9.]{1,3})',$Agent,$version)) {  
		$browseragent="Safari";  
		$browserversion="";  
	}else {  
		$browserversion="";  
		$browseragent="Unknown";  
	}  
	return $browseragent." ".$browserversion;  
}


function determineplatform ($Agent) {
$browserplatform=='';
if (eregi('win',$Agent) && strpos($Agent, '95')) {
	$browserplatform="Windows 95";  
}elseif (eregi('win 9x',$Agent) && strpos($Agent, '4.90')) {  
	$browserplatform="Windows ME";  
}elseif (eregi('win',$Agent) && ereg('98',$Agent)) {  
	$browserplatform="Windows 98";  
}elseif (eregi('win',$Agent) && eregi('nt 5.0',$Agent)) {  
	$browserplatform="Windows 2000";  
}elseif (eregi('win',$Agent) && eregi('nt 5.1',$Agent)) {  
	$browserplatform="Windows XP";  
}elseif (eregi('win',$Agent) && eregi('nt 6.0',$Agent)) {  
	$browserplatform="Windows Vista";  
}elseif (eregi('win',$Agent) && eregi('nt 6.1',$Agent)) {  
	$browserplatform="Windows 7";  
}elseif (eregi('win',$Agent) && ereg('32',$Agent)) {  
	$browserplatform="Windows 32";  
}elseif (eregi('win',$Agent) && eregi('nt',$Agent)) {  
	$browserplatform="Windows NT";  
}elseif (eregi('Mac OS',$Agent)) {  
	$browserplatform="Mac OS";  
}elseif (eregi('linux',$Agent)) {  
	$browserplatform="Linux";  
}elseif (eregi('unix',$Agent)) {  
	$browserplatform="Unix";  
}elseif (eregi('sun',$Agent) && eregi('os',$Agent)) {  
	$browserplatform="SunOS";  
}elseif (eregi('ibm',$Agent) && eregi('os',$Agent)) {  
	$browserplatform="IBM OS/2";  
}elseif (eregi('Mac',$Agent) && eregi('PC',$Agent)) {  
	$browserplatform="Macintosh";  
}elseif (eregi('PowerPC',$Agent)) {  
	$browserplatform="PowerPC";  
}elseif (eregi('AIX',$Agent)) {  
	$browserplatform="AIX";  
}elseif (eregi('HPUX',$Agent)) {  
	$browserplatform="HPUX";  
}elseif (eregi('NetBSD',$Agent)) {  
	$browserplatform="NetBSD";  
}elseif (eregi('BSD',$Agent)) {  
	$browserplatform="BSD";  
}elseif (ereg('OSF1',$Agent)) {  
	$browserplatform="OSF1";  
}elseif (ereg('IRIX',$Agent)) {  
	$browserplatform="IRIX";  
}elseif (eregi('FreeBSD',$Agent)) {  
	$browserplatform="FreeBSD";  
}if ($browserplatform=='') {$browserplatform = "Unknown"; }  
	return $browserplatform;  
}  
?>
