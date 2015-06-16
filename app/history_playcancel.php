<?php 
session_start();
error_reporting(0);
require_once 'conn.php';
$id=$_POST['id'];
	$sql="select * from ssc_bills where dan='".$id."'";
	$rs=mysql_query($sql) or  die("数据库修改出错!!!!".mysql_error());
	$row = mysql_fetch_array($rs);
	if(empty($row)){
		echo "{\"stats\":\"error\",\"data\":\"操作失败\"}";
	}else if($row['zt']==4 || $row['zt']==5){
		echo "{\"stats\":\"error\",\"data\":\"该单已被撤消\"}";	
	}else{
		if(date("Y-m-d H:i:s")>$row['canceldead']){
			echo "{\"stats\":\"error\",\"data\":\"该期订单已停止销售,无法撤消\"}";			
		}else{
			$sqla = "update ssc_bills set canceldate='".date("Y-m-d H:i:s")."', zt='5' where dan='".$id."'";
			$exe=mysql_query($sqla) or  die("数据库修改出错3!!!".mysql_error());
			
			$sqlb="select * from ssc_record where dan1='".$id."' and types='7' order by id desc";
			$rsb=mysql_query($sqlb) or  die("数据库修改出错!!!!".mysql_error());
			$rowb = mysql_fetch_array($rsb);

			$sqla = "select * from ssc_record order by id desc limit 1";
			$rsa = mysql_query($sqla);
			$rowa = mysql_fetch_array($rsa);
			$dan1 = sprintf("%07s",strtoupper(base_convert($rowa['id']+1,10,36)));

			$lmoney=Get_mmoney($rowb['uid'])+$rowb['zmoney'];
			
//			$sqla="delete from ssc_record where dan1='".$rowb['dan1']."' and types='13'";
//			$exe=mysql_query($sqla) or  die("数据库修改出错3!!!".mysql_error());

			$sqla="insert into ssc_record set lotteryid='".$rowb['lotteryid']."', lottery='".$rowb['lottery']."', dan='".$dan1."', dan1='".$rowb['dan1']."', dan2='".$rowb['dan2']."', uid='".$rowb['uid']."', username='".$rowb['username']."', issue='".$rowb['issue']."', types='13', mid='".$rowb['mid']."', mode='".$rowb['mode']."', smoney=".$rowb['zmoney'].",leftmoney=".$lmoney.", cont='".$rowb['cont']."', regtop='".$rowb['regtop']."', regup='".$rowb['regup']."', regfrom='".$rowb['regfrom']."', adddate='".date("Y-m-d H:i:s")."'";
			$exe=mysql_query($sqla) or  die("数据库修改出错3!!!".mysql_error());
			
			$sqla="update ssc_member set leftmoney=".$lmoney.", usedmoney=usedmoney-".$rowb['zmoney']." where id='".$rowb['uid']."'"; 
			$exe=mysql_query($sqla) or  die("数据库修改出错2!!!".mysql_error());

			$sqlb="select * from ssc_record where dan1='".$id."' and types='11'";
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
			echo "{\"stats\":\"ok\",\"data\":1}";
		
		
		}
	}	


?>