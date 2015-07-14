<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title><meta http-equiv="refresh" content="10; "> 
<?php
include_once("conn.php");
include_once("autokja_qt.php");
function generate_password( $length = 5 ) {  
// 密码字符集，可任意添加你需要的字符  
$chars = "0123456789";  
$password = '';  
	for ( $i = 0; $i < $length; $i++ )  {  
	// 第二种是取字符数组 $chars 的任意元素  //  
	$password .= ",".$chars[ mt_rand(0, strlen($chars) - 1) ];  
	}  
return substr($password,1);  
} 
$t2=generate_password(5);


$qihao=$_GET['qihao'];
if($qihao){
//	$t2='1,2,3,4,5';
	$n=split(",",$t2);
	echo($n[0].$n[1].$n[2].$n[3].$n[4]);
	$jieguo=autokj_qt($n[0],$n[1],$n[2],$n[3],$n[4],2,$qihao,1);
	
	if($jieguo==$n[0].$n[1].$n[2].$n[3].$n[4]){
		$res_tj=mysql_query("select sum(money) as benjin,sum(prize)as jiangjin from ssc_bills_qt where lotteryid=2 and issue='$qihao'");
	//	echo("<br> select sum(money) as benjin,sum(prize)as jiangjin from ssc_bills_qt where lotteryid=2 and issue='$qihao'");
		$row_tj=mysql_fetch_array($res_tj);
		if($row_tj['benjin']<$row_tj['jiangjin']){
			echo('赔本了');	
	//		exit;
			echo("<script>location='autokja_kj.php?qihao=".$qihao."';</script>");
		}else{
			kjdata($t2,2,$qihao,$opentime);
			echo('赚了');	
	//		exit;
			echo("<script>location='autokja_kj.php';</script>");
		}
	}else{
		echo("<script>location='autokja_kj.php?qihao=".$qihao."';</script>");
	}
}else{	
	$now_time=time()-60;
	$sqls="select * from ssc_nums where cid='2' and opentime<='".date("H:i:s",$now_time)."' order by id desc limit 1";
	$rss=mysql_query($sqls) or  die("数据库修改出错1".mysql_error());
	$rows = mysql_fetch_array($rss);
	
	if($rows['nums']){
		$qihao=date("ymd",$now_time).$rows['nums'];
	}
	$opentime=$rows['opentime'];
	$sqls_jc="select * from ssc_data where cid='2' and issue='".$qihao."'";
	$rss_jc=mysql_query($sqls_jc) or  die("数据库修改出错1".mysql_error());
	$rows_jc = mysql_fetch_array($rss_jc);
	if($rows_jc['id']){
		echo("SC五分彩第".$rows_jc['issue']."期:".$rows_jc['code']."");
	}else{
		
	echo($qihao."<br>");
	$res_tz=mysql_query("select * from ssc_bills where lotteryid=2 and issue='$qihao'");
	$row_tz=mysql_fetch_array($res_tz);
	if($row_tz['id']){
		mysql_query("TRUNCATE TABLE `ssc_bills_qt` ");
		$res_tz=mysql_query("select * from ssc_bills where lotteryid=2 and issue='$qihao'");
		while($row_tz=mysql_fetch_array($res_tz)){
			$sqla="INSERT INTO ssc_bills_qt set lotteryid='".$row_tz['lotteryid']."', lottery='".$row_tz['lottery']."', dan='".$row_tz['dan']."', uid='".$row_tz['uid']."', username='".$row_tz['username'] ."', issue='".$row_tz['issue']."', type='".$row_tz['type']."', mid='".$row_tz['mid']."', codes='".$row_tz['codes']."', nums='".$row_tz['nums']."', times='".$row_tz['times']."', money='".$row_tz['money']."', mode='".$row_tz['mode']."', rates='".$row_tz['rates']."', point='".$row_tz['point']."', cont='".$row_tz['cont']."', regtop='".$row_tz['regtop']."', regup='".$row_tz['regup']."', regfrom='".$row_tz['regfrom']."', userip='".$row_tz['userip']."', adddate='".$row_tz['adddate']."', canceldead='".$row_tz['canceldead']."', zt='1'";
			$exe=mysql_query($sqla) or  die("数据库修改出错1!!".mysql_error());
		}
		$n=split(",",$t2);
		autokj_qt($n[0],$n[1],$n[2],$n[3],$n[4],2,$qihao,1);
		
		$res_tj=mysql_query("select sum(money) as benjin,sum(prize)as jiangjin from ssc_bills_qt where lotteryid=2 and issue='$qihao'");
		$row_tj=mysql_fetch_array($res_tj);
		if($row_tj['benjin']<$row_tj['jiangjin']){
			echo('赔本了');	
			echo("<script>location='autokja_kj.php?qihao=".$qihao."';</script>");
		}else{
			if($qihao){
				kjdata($t2,2,$qihao,$opentime);
			}
		}
	}else{
		if($qihao){
			kjdata($t2,2,$qihao,$opentime);
		}
	}
	
	//kjdata($t2,2,$qihao,$opentime);
	}
}


?>