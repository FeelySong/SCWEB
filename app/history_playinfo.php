<?php 
session_start();
error_reporting(0);
require_once 'conn.php';
$id=$_POST['id'];
	$sql="select * from ssc_bills where dan='".$id."'";
	$rs=mysql_query($sql) or  die("数据库修改出错!!!!".mysql_error());
	$row = mysql_fetch_array($rs);
	if(empty($row)){
		echo "{\"stats\":\"error\",\"data\":\"读取数据出错啦\"}";
	}else{
		if(date("Y-m-d H:i:s")<$row['canceldead'] && $row['zt']==0){
			$can=1;
		}else{
			$can=0;
		}
		if($row['mode']==1){
			$modes="元";
			$modes2=1;
		}else{
			$modes="角";
			$modes2=0.1;
		}
		
		if($row['dan1']!=""){
			$taskid=$row['dan1'];
		}else{
			$taskid=0;
		}
				
		$iscancel=0;
		$isgetprize=0;
		$prizestatus=1;//派奖
		if($row['zt']==4){
			$iscancel=2;
		}else if($row['zt']==5){
			$iscancel=1;
		}else if($row['zt']==6){
			$iscancel=3;
		}else{
			$isgetprize=$row['zt'];
		}
				
		if($row['mid']=="20" || $row['mid']=="21" || $row['mid']=="24" || $row['mid']=="25" || $row['mid']=="58" || $row['mid']=="59" || $row['mid']=="62" || $row['mid']=="63" || $row['mid']=="96" || $row['mid']=="97" || $row['mid']=="100" || $row['mid']=="101" || $row['mid']=="134" || $row['mid']=="135" || $row['mid']=="138" || $row['mid']=="139" || $row['mid']=="168" || $row['mid']=="169" || $row['mid']=="205" || $row['mid']=="206" || $row['mid']=="239" || $row['mid']=="240" || $row['mid']=="273" || $row['mid']=="274" || $row['mid']=="298" || $row['mid']=="299" || $row['mid']=="326" || $row['mid']=="327" || $row['mid']=="366" || $row['mid']=="367"){//point处理
			$sqla = "select * from ssc_class where mid='".$row['mid']."'";
			$rsa = mysql_query($sqla);
			$rowa = mysql_fetch_array($rsa);
//			$sstri=$rowa['sid'];
//			echo $rowa['rates'];
			$sstrd=explode(";",$rowa['rates']);

//			$sstra=explode(";",Get_mrebate($row['uid']));
//			$sstrb=explode(",",$sstra[$sstri-1]);
//			$spoint=$sstrb[1]/100;
			$dypointdec="";
		}else{
			$dypointdec=($row['rates']/$modes2)."-".($row['point']*100)."%";
			$sstrd=explode(";",$row['rates']/$modes2);
		}
		

		echo "{\"stats\":\"ok\",\"data\":{\"need\":0,\"money\":0,\"can\":".$can.",\"project\":{\"projectid\":\"".$row['dan']."\",\"userid\":\"".$row['uid']."\",\"packageid\":\"10\",\"taskid\":\"".$taskid."\",\"lotteryid\":\"".$row['lotteryid']."\",\"methodid\":\"".$row['mid']."\",\"issue\":\"".$row['issue']."\",\"bonus\":\"".$row['prize']."\",\"code\":\"".dcode($row['codes'],$row['lotteryid'])."\",\"codetype\":\"".$row['type']."\",\"singleprice\":\"".($row['money']/$row['times'])."\",\"multiple\":\"".$row['times']."\",\"totalprice\":\"".$row['money']."\",\"maxbouns\":\"".number_format($sstrd[0]*modes2,4)."\",\"lvtopid\":\"9\",\"lvtoppoint\":\"0.075\",\"lvproxyid\":\"27545\",\"userdefaultpoint\":\"0.050\",\"userpoint\":\"".$row['point']."\",\"dypointdec\":\"".$dypointdec."\",\"writetime\":\"".$row['adddate']."\",\"updatetime\":\"2012-03-12 12:42:03\",\"deducttime\":\"2012-03-12 12:42:03\",\"bonustime\":\"0000-00-00 00:00:00\",\"canceltime\":\"".$row['canceldate']."\",\"isdeduct\":\"1\",\"iscancel\":\"".$iscancel."\",\"isgetprize\":\"".$isgetprize."\",\"prizestatus\":\"".$prizestatus."\",\"userip\":\"".$row['userip']."\",\"cdnip\":\"127.0.0.1\",\"modes\":\"".$modes."\",\"sqlnum\":\"0\",\"hashvar\":\"a\",\"cnname\":\"".$row['lottery']."\",\"methodname\":\"".Get_mid($row['mid'])."\",\"username\":\"".$row['username']."\",\"nocode\":\"".$row['kjcode']."\",\"canneldeadline\":\"".$row['canceldead']."\",\"statuscode\":\"2\"},\"prizelevel\":[";
		for($i=0;$i<count($sstrd);$i=$i+1){
			$prize=number_format(floatval($sstrd[$i])*$modes2*$row['times'],4);
			echo "{\"entry\":\"17679965\",\"projectid\":\"17015274\",\"isspecial\":\"0\",\"level\":\"".($i+1)."\",\"codetimes\":\"".$row['times']."\",\"prize\":\"".$prize."\",\"expandcode\":\"".dcode($row['codes'],$row['lotteryid'])."\",\"updatetime\":\"".$row['adddate']."\",\"hashvar\":\"a\"}";
			if($i!=count($sstrd)-1){echo ",";}
		}
		echo "]}}";
	}


//{"stats":"ok","data":{"need":0,"money":0,"can":0,"project":{"projectid":"TRK5G1","userid":"99321","packageid":"13257281","taskid":"QSOVU5","lotteryid":"1","methodid":"37","issue":"120330062","bonus":"0.0000","code":"\u5927,\u5c0f","codetype":"dxds","singleprice":"0.2000","multiple":"4","totalprice":"0.8000","maxbouns":"3.0000","lvtopid":"24749","lvtoppoint":"0.075","lvproxyid":"59692","userdefaultpoint":"0.045","userpoint":"0.000","dypointdec":"7.5-0%","writetime":"2012-03-30 16:12:07","updatetime":"2012-03-30 16:22:03","deducttime":"2012-03-30 16:22:03","bonustime":"0000-00-00 00:00:00","canceltime":"0000-00-00 00:00:00","isdeduct":"1","iscancel":"0","isgetprize":"2","prizestatus":"0","userip":"127.0.0.1","cdnip":"127.0.0.1","modes":"\u89d2","sqlnum":"1","hashvar":"b6ca60a7e90cd46e6b0c897fe750b82f","cnname":"\u91cd\u5e86\u65f6\u65f6\u5f69","methodname":"\u524d\u4e8c\u5927\u5c0f\u5355\u53cc","username":"abc998","nocode":"65721","canneldeadline":"2012-03-30 16:18:30","statuscode":"2"},"prizelevel":[{"entry":"21212182","projectid":"20412802","isspecial":"0","level":"1","codetimes":"4","prize":"3.0000","expandcode":"\u5927,\u5c0f","updatetime":"2012-03-30 16:12:00","hashvar":"264bd7a6af93f7b2d06ff033dc68f70c"}]}}


//{"stats":"ok","data":{"need":0,"money":0,"can":0,"project":{"projectid":"TRK5GC","userid":"99321","packageid":"13257740","taskid":"QSOVHI","lotteryid":"1","methodid":"37","issue":"120330062","bonus":"0.0000","code":"\u5c0f,\u5927","codetype":"dxds","singleprice":"2.0000","multiple":"2","totalprice":"4.0000","maxbouns":"15.0000","lvtopid":"24749","lvtoppoint":"0.075","lvproxyid":"59692","userdefaultpoint":"0.045","userpoint":"0.000","dypointdec":"7.5-0%","writetime":"2012-03-30 16:12:07","updatetime":"2012-03-30 16:22:03","deducttime":"2012-03-30 16:22:03","bonustime":"0000-00-00 00:00:00","canceltime":"0000-00-00 00:00:00","isdeduct":"1","iscancel":"0","isgetprize":"2","prizestatus":"0","userip":"127.0.0.1","cdnip":"127.0.0.1","modes":"\u5143","sqlnum":"1","hashvar":"25af545808d4ef197cc14d40dacbf7c1","cnname":"\u91cd\u5e86\u65f6\u65f6\u5f69","methodname":"\u524d\u4e8c\u5927\u5c0f\u5355\u53cc","username":"abc998","nocode":"65721","canneldeadline":"2012-03-30 16:18:30","statuscode":"2"},"prizelevel":[{"entry":"21212195","projectid":"20412815","isspecial":"0","level":"1","codetimes":"2","prize":"15.0000","expandcode":"\u5c0f,\u5927","updatetime":"2012-03-30 16:12:00","hashvar":"0fe79d78af86e45e38147bcd4e850391"}]}}



//{"stats":"ok","data":{"need":0,"money":0,"can":0,"project":{"projectid":"TSLR9S","userid":"103298","packageid":"13920976","taskid":"0","lotteryid":"1","methodid":"20","issue":"120405017","bonus":"0.0000","code":"359","codetype":"input","singleprice":"0.2000","multiple":"1","totalprice":"0.2000","maxbouns":"60.0000","lvtopid":"24749","lvtoppoint":"0.075","lvproxyid":"59692","userdefaultpoint":"0.041","userpoint":"1.000","dypointdec":"","writetime":"2012-04-05 01:23:40","updatetime":"2012-04-05 01:22:49","deducttime":"0000-00-00 00:00:00","bonustime":"0000-00-00 00:00:00","canceltime":"0000-00-00 00:00:00","isdeduct":"0","iscancel":"0","isgetprize":"0","prizestatus":"0","userip":"221.11.43.110","cdnip":"176.32.79.52","modes":"\u89d2","sqlnum":"0","hashvar":"1efef3615a7e020dac4e9e6c84a5732a","cnname":"\u91cd\u5e86\u65f6\u65f6\u5f69","methodname":"\u524d\u4e09\u7ec4\u9009_\u6df7\u5408","username":"669988","nocode":"","canneldeadline":"2012-04-05 01:24:10","statuscode":"0"},"prizelevel":[{"entry":"22304226","projectid":"21463743","isspecial":"0","level":"1","codetimes":"1","prize":"60.0000","expandcode":"359","updatetime":"2012-04-05 01:22:49","hashvar":"a8a5e09605a701990dbffaf21efa939a"},{"entry":"22304227","projectid":"21463743","isspecial":"0","level":"2","codetimes":"1","prize":"30.0000","expandcode":"359","updatetime":"2012-04-05 01:22:49","hashvar":"ad5233107ed3f4e29fdcd3522dc5a5fa"}]}}
//"{\"stats\":\"ok\",\"data\":{\"need\":0,\"money\":0,\"can\":0,\"project\":{\"projectid\":\"TOTJJ9\",\"userid\":\"75802\",\"packageid\":\"11064812\",\"taskid\":\"0\",\"lotteryid\":\"1\",\"methodid\":\"23\",\"issue\":\"120312040\",\"bonus\":\"0.0000\",\"code\":\"0,1,2,4,5,8,9\",\"codetype\":\"digital\",\"singleprice\":\"7.0000\",\"multiple\":\"1\",\"totalprice\":\"7.0000\",\"maxbouns\":\"31.6000\",\"lvtopid\":\"9\",\"lvtoppoint\":\"0.075\",\"lvproxyid\":\"27545\",\"userdefaultpoint\":\"0.050\",\"userpoint\":\"0.000\",\"dypointdec\":\"316-0%\",\"writetime\":\"2012-03-12 12:32:22\",\"updatetime\":\"2012-03-12 12:42:03\",\"deducttime\":\"2012-03-12 12:42:03\",\"bonustime\":\"0000-00-00 00:00:00\",\"canceltime\":\"0000-00-00 00:00:00\",\"isdeduct\":\"1\",\"iscancel\":\"0\",\"isgetprize\":\"2\",\"prizestatus\":\"0\",\"userip\":\"123.184.134.252\",\"cdnip\":\"10.128.39.5\",\"modes\":\"\u89d2\",\"sqlnum\":\"0\",\"hashvar\":\"eacdc8686ff61e8d37e8a2ff2e525eed\",\"cnname\":\"\u91cd\u5e86\u65f6\u65f6\u5f69\",\"methodname\":\"\u540e\u4e09\u7ec4\u9009_\u7ec4\u516d\",\"username\":\"009988\",\"nocode\":\"21733\",\"canneldeadline\":\"2012-03-12 12:38:30\",\"statuscode\":\"2\"},\"prizelevel\":[{\"entry\":\"17679965\",\"projectid\":\"17015274\",\"isspecial\":\"0\",\"level\":\"2\",\"codetimes\":\"1\",\"prize\":\"31.6000\",\"expandcode\":\"0,1,2,4,5,8,9\",\"updatetime\":\"2012-03-12 12:29:18\",\"hashvar\":\"974173036cee9fb715f1fb5be7e54fcc\"}]}}";
?>