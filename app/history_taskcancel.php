<?php 
session_start();
error_reporting(0);
require_once 'conn.php';
$id=$_POST['taskid'];

$sign=0;
$tmoney=0;
for ($i=0; $i<count($_REQUEST['taskid']); $i++) {
	$sql="select * from ssc_zdetail where id='".$_REQUEST['taskid'][$i]."'";
	$rs=mysql_query($sql) or die("数据库修改出错!!!!".mysql_error());
	$row = mysql_fetch_array($rs);
	$tmoney=$tmoney+$row['money'];
	if(empty($row)){
		$sign=1;
//	}else if($row['zt']!=0){
//		$sign=1;
	}else{
		$dan=$row['dan'];
		if(date("Y-m-d H:i:s")>$row['canceldead']){
			$sign=1;
		}
		
		$sql="select * from ssc_bills where dan1='".$row['dan']."' and issue='".$row['issue']."'";
		$rs=mysql_query($sql) or  die("数据库修改出错!".mysql_error());
		$row = mysql_fetch_array($rs);
		if($row['zt']!=0){
			$sign=1;
		}
	}
}

if($sign==0){

	for ($i=0; $i<count($_REQUEST['taskid']); $i++) {
		$sql="update ssc_zdetail set zt=2 where id='".$_REQUEST['taskid'][$i]."'";
		$rs=mysql_query($sql) or die("数据库修改出错!!!!".mysql_error());

		$sql="select * from ssc_zdetail where id='".$_REQUEST['taskid'][$i]."'";
		$rs=mysql_query($sql) or die("数据库修改出错!!!!".mysql_error());
		$row = mysql_fetch_array($rs);

		$sqla = "update ssc_bills set canceldate='".date("Y-m-d H:i:s")."', zt='5' where dan1='".$row['dan']."' and issue='".$row['issue']."'";
		$exe=mysql_query($sqla) or  die("数据库修改出错3!!!".mysql_error());

		$sqla="select * from ssc_bills where dan1='".$row['dan']."' and issue='".$row['issue']."'";
		$rsa=mysql_query($sqla) or die("数据库修改出错!!!!".mysql_error());
		$rowa = mysql_fetch_array($rsa);
		if(empty($rowa)){
		}else{
			$did=$rowa['dan'];
			
//			$sqlb="select * from ssc_record where dan1='".$did."' and types='7'";
//			$rsb=mysql_query($sqlb) or  die("数据库修改出错!!!!".mysql_error());
//			$rowb = mysql_fetch_array($rsb);
	
//			$sqla = "select * from ssc_record order by id desc limit 1";
//			$rsa = mysql_query($sqla);
//			$rowa = mysql_fetch_array($rsa);
//			$dan1 = sprintf("%07s",strtoupper(base_convert($rowa['id']+1,10,36)));
	
//			$lmoney=Get_mmoney($rowb['uid'])+$rowb['zmoney'];
				
//			$sqla="insert into ssc_record set lotteryid='".$rowb['lotteryid']."', lottery='".$rowb['lottery']."', dan='".$dan1."', dan1='".$rowb['dan1']."', dan2='".$rowb['dan2']."', uid='".$rowb['uid']."', username='".$rowb['username']."', issue='".$rowb['issue']."', types='13', mid='".$rowb['mid']."', mode='".$rowb['mode']."', smoney=".$rowb['zmoney'].",leftmoney=".$lmoney.", cont='".$rowb['cont']."', regtop='".$rowb['regtop']."', regup='".$rowb['regup']."', regfrom='".$rowb['regfrom']."', adddate='".date("Y-m-d H:i:s")."'";
//			$exe=mysql_query($sqla) or  die("数据库修改出错3!!!".mysql_error());
				
	//		$sqla="update ssc_member set leftmoney=".$lmoney.", usedmoney=usedmoney-".$rowb['zmoney']." where id='".$rowb['uid']."'"; 
	//		$exe=mysql_query($sqla) or  die("数据库修改出错2!!!".mysql_error());
	
			$sqlb="select * from ssc_record where dan1='".$did."' and types='11' order by id desc";
			$rsb=mysql_query($sqlb) or  die("数据库修改出错!!!!".mysql_error());
			while ($rowb = mysql_fetch_array($rsb)){
				$sqla = "select * from ssc_record order by id desc limit 1";
				$rsa = mysql_query($sqla);
				$rowa = mysql_fetch_array($rsa);
				$dan1 = sprintf("%07s",strtoupper(base_convert($rowa['id']+1,10,36)));
	
				$lmoney=Get_mmoney($rowb['uid'])-$rowb['smoney'];
					
	//				$sqla="delete from ssc_record where dan1='".$rowb['dan1']."' and types='15'";
	//				$exe=mysql_query($sqla) or  die("数据库修改出错3!!!".mysql_error());
	
				$sqla="insert into ssc_record set lotteryid='".$rowb['lotteryid']."', lottery='".$rowb['lottery']."', dan='".$dan1."', dan1='".$rowb['dan1']."', dan2='".$rowb['dan2']."', uid='".$rowb['uid']."', username='".$rowb['username']."', issue='".$rowb['issue']."', types='15', mid='".$rowb['mid']."', mode='".$rowb['mode']."', zmoney=".$rowb['smoney'].",leftmoney=".$lmoney.", cont='".$rowb['cont']."', regtop='".$rowb['regtop']."', regup='".$rowb['regup']."', regfrom='".$rowb['regfrom']."', adddate='".date("Y-m-d H:i:s")."'";
				$exe=mysql_query($sqla) or  die("数据库修改出错3!!!".mysql_error());
					
				$sqla="update ssc_member set leftmoney=".$lmoney." where id='".$rowb['uid']."'"; 
				$exe=mysql_query($sqla) or  die("数据库修改出错2!!!".mysql_error());
			}		
		}
	}
	$sqla = "update ssc_zbills set cnums=cnums+".count($_REQUEST['taskid']).", cmoney=cmoney+".$tmoney." where dan='".$_REQUEST['id']."'";
	$rsa = mysql_query($sqla);

	$sqls="select * from ssc_zbills where dan ='".$_REQUEST['id']."'";
	$rss=mysql_query($sqls) or  die("数据库修改出错1".mysql_error());
	$rows = mysql_fetch_array($rss);

	$lmoney = Get_mmoney($rows['uid'])+$tmoney;

	$sqla = "select * from ssc_record order by id desc limit 1";
	$rsa = mysql_query($sqla);
	$rowa = mysql_fetch_array($rsa);
	$dan1 = sprintf("%07s",strtoupper(base_convert($rowa['id']+1,10,36)));//追号返款
	$sqla="insert into ssc_record set lotteryid='".$rows['lotteryid']."', lottery='".$rows['lottery']."', dan='".$dan1."', dan2='".$rows['dan']."', uid='".$rows['uid']."', username='".$rows['username']."', issue='".$rows['issue']."', types='10', mid='".$rows['mid']."', mode='".$rows['mode']."', smoney=".$tmoney.",leftmoney=".$lmoney.", cont='".$rows['cont']."', regtop='".$rows['regtop']."', regup='".$rows['regup']."', regfrom='".$rows['regfrom']."', adddate='".date("Y-m-d H:i:s")."'";
	$exe=mysql_query($sqla) or  die("数据库修改出错9!!!".mysql_error());

	$sqla="update ssc_member set leftmoney=".$lmoney.", usedmoney=usedmoney-".$tmoney." where id='".$rows['uid']."'"; 
	$exe=mysql_query($sqla) or  die("数据库修改出错!!!".mysql_error());

	$sqlb="select * from ssc_zdetail where dan='".$_REQUEST['id']."' and zt='0'";
	$rsb = mysql_query($sqlb) or  die("数据库修改出错!!!".mysql_error());
	$total = mysql_num_rows($rsb);
	if($total==0){
		$sqlb="update ssc_zbills set zt='1' where dan='".$_REQUEST['id']."'"; 
		$exe=mysql_query($sqlb) or  die("数据库修改出错!!!".mysql_error());
	}
	
	$_SESSION["backtitle"]="操作成功";
	$_SESSION["backurl"]="history_taskinfo.php?id=".$_REQUEST['id'];
	$_SESSION["backzt"]="successed";
	$_SESSION["backname"]="查看追号详情";
	echo "<script language=javascript>window.location='sysmessage.php';</script>";
	exit;
	
}else{
	$_SESSION["backtitle"]="操作失败";
	$_SESSION["backurl"]="history_taskinfo.php?id=".$_REQUEST['id'];
	$_SESSION["backzt"]="failed";
	$_SESSION["backname"]="查看追号详情";
	echo "<script language=javascript>window.location='sysmessage.php';</script>";
	exit;
}
?>