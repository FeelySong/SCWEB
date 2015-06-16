<?php
session_start();
error_reporting(0);
require_once 'conn.php';

if (strpos($_SESSION['admin_flag'],'46') ){}else{ 
	echo "<script language=javascript>alert('对不起，您无此权限！');window.history.go(-1);</script>";
exit;}

$jb=array("用户","代理","总代理"); 

$uname=$_REQUEST['uname'];

$ordertype=$_REQUEST['ordertype'];
$starttime = $_REQUEST['starttime'];
$endtime = $_REQUEST['endtime'];
$lotteryid=$_REQUEST['lotteryid'];
$methodid=$_REQUEST['methodid'];
$mode=$_REQUEST['mode'];

$username_mem=$_REQUEST['username'];
$dan=$_REQUEST['dan'];

if($_GET['act']=="dels"){       //批量删除   
	$ids=$_POST['lids'];  
	$ids=implode(",", $ids);   //implode函数 把数组元素组合为一个字符串。   
	$sql="delete from ssc_record where id in ($ids)";  
	mysql_query($sql); 
}

if($_GET['act']=="del"){
	mysql_query("Delete from ssc_record where id=".$_GET['id']);
	echo "<script>window.location.href='account_record.php';</script>"; 
	exit;
}

$page = !($_GET['page'])?'1':intval($_GET['page']);
$pagesize=20;
$page2=($page-1)*$pagesize;

if($starttime==""){
	if(date("H:i:s")<"03:00:00"){
		$starttime=date("Y-m-d",strtotime("-1 day"))." 03:00:00";
	}else{
		$starttime=date("Y-m-d")." 03:00:00";
	}
}
	$s1=$s1." and adddate>='".$starttime."'";

if($endtime==""){
	if(date("H:i:s")<"03:00:00"){
		$endtime=date("Y-m-d")." 03:00:00";
	}else{
		$endtime=date("Y-m-d",strtotime("+1 day"))." 03:00:00";
	}
}
	$s1=$s1." and adddate<='".$endtime."'";

if($ordertype!="" && $ordertype!="0"){
	$s1=$s1." and types='".$ordertype."'";
}

if($lotteryid!="" && $lotteryid!="0"){
	$s1=$s1." and lotteryid='".$lotteryid."'";
}else{
	$lotteryid=0;
}
if($methodid!="" && $methodid!="0"){
	$s1=$s1." and mid='".$methodid."'";
}else{
	$methodid=0;
}

if($mode!="" && $mode!="0"){
	$s1=$s1." and mode='".$mode."'";
}

if($uname!=""){
	$username_mem=$uname;
}

if($username_mem!=""){
	$s1=$s1." and username='".$username_mem."'";
}

if($dan!=""){
	$s1=$s1." and dan='".$dan."'";
}

$urls="starttime=".$starttime."&endtime=".$endtime."&lotteryid=".$lotteryid."&methodid=".$methodid."&ordertype=".$ordertype."&mode=".$mode."&uname=".$uname."&username=".$username_mem."&dan=".$dan;

$s1=$s1." order by id desc";
$sql="select * from ssc_record where 1=1".$s1;

$rs = mysql_query($sql);
$total = mysql_num_rows($rs);

$sql="select * from ssc_record where 1=1".$s1." limit $page2,$pagesize";
$rsnewslist=mysql_query($sql);

$lastpg=ceil($total/$pagesize); //最后页，也是总页数
$page=min($lastpg,$page);
$prepg=$page-1; //上一页
$nextpg=($page==$lastpg ? 0 : $page+1); //下一页

if($page<5){
	$p1=1;
	$p2=min($lastpg,10);
}else{
	$p2=min($lastpg,$page+5);
	$p1=max($p2-9,1);
}
?>
<html>
<head>
<link href="css/index.css" rel="stylesheet" type="text/css">
<script language="javascript" type="text/javascript" src="js/jquery.js"></script>
<script language="javascript" type="text/javascript" src="js/common.js"></script>
<script type="text/javascript" src="js/calendar/jquery.dyndatetime.js"></script>
<script type="text/javascript" src="js/calendar/lang/calendar-utf8.js"></script>
<script language="javascript" src="js/dialog/jquery.dialogUI.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="js/calendar/css/calendar-blue2.css"  />
<script type="text/javascript">
		var data_method = {"1":{"14":{"lotteryid":"1","methodid":"14","methodname":"\u524d\u4e09\u76f4\u9009"},"28":{"lotteryid":"1","methodid":"28","methodname":"\u524d\u4e8c\u76f4\u9009"},"29":{"lotteryid":"1","methodid":"29","methodname":"\u540e\u4e8c\u76f4\u9009"},"30":{"lotteryid":"1","methodid":"30","methodname":"\u524d\u4e8c\u7ec4\u9009"},"31":{"lotteryid":"1","methodid":"31","methodname":"\u540e\u4e8c\u7ec4\u9009"},"32":{"lotteryid":"1","methodid":"32","methodname":"\u4e07\u4f4d"},"33":{"lotteryid":"1","methodid":"33","methodname":"\u5343\u4f4d"},"34":{"lotteryid":"1","methodid":"34","methodname":"\u767e\u4f4d"},"35":{"lotteryid":"1","methodid":"35","methodname":"\u5341\u4f4d"},"36":{"lotteryid":"1","methodid":"36","methodname":"\u4e2a\u4f4d"},"37":{"lotteryid":"1","methodid":"37","methodname":"\u524d\u4e8c\u5927\u5c0f\u5355\u53cc"},"38":{"lotteryid":"1","methodid":"38","methodname":"\u540e\u4e8c\u5927\u5c0f\u5355\u53cc"},"27":{"lotteryid":"1","methodid":"27","methodname":"\u4e8c\u7801\u4e0d\u5b9a\u4f4d"},"26":{"lotteryid":"1","methodid":"26","methodname":"\u4e00\u7801\u4e0d\u5b9a\u4f4d"},"15":{"lotteryid":"1","methodid":"15","methodname":"\u524d\u4e09\u76f4\u9009_\u548c\u503c"},"16":{"lotteryid":"1","methodid":"16","methodname":"\u540e\u4e09\u76f4\u9009"},"17":{"lotteryid":"1","methodid":"17","methodname":"\u540e\u4e09\u76f4\u9009_\u548c\u503c"},"18":{"lotteryid":"1","methodid":"18","methodname":"\u524d\u4e09\u7ec4\u9009_\u7ec4\u4e09"},"19":{"lotteryid":"1","methodid":"19","methodname":"\u524d\u4e09\u7ec4\u9009_\u7ec4\u516d"},"20":{"lotteryid":"1","methodid":"20","methodname":"\u524d\u4e09\u7ec4\u9009_\u6df7\u5408"},"21":{"lotteryid":"1","methodid":"21","methodname":"\u524d\u4e09\u7ec4\u9009_\u548c\u503c"},"22":{"lotteryid":"1","methodid":"22","methodname":"\u540e\u4e09\u7ec4\u9009_\u7ec4\u4e09"},"23":{"lotteryid":"1","methodid":"23","methodname":"\u540e\u4e09\u7ec4\u9009_\u7ec4\u516d"},"24":{"lotteryid":"1","methodid":"24","methodname":"\u540e\u4e09\u7ec4\u9009_\u6df7\u5408"},"25":{"lotteryid":"1","methodid":"25","methodname":"\u540e\u4e09\u7ec4\u9009_\u548c\u503c"}},"2":{"69":{"lotteryid":"2","methodid":"69","methodname":"\u540e\u4e8c\u7ec4\u9009"},"68":{"lotteryid":"2","methodid":"68","methodname":"\u524d\u4e8c\u7ec4\u9009"},"67":{"lotteryid":"2","methodid":"67","methodname":"\u540e\u4e8c\u76f4\u9009"},"66":{"lotteryid":"2","methodid":"66","methodname":"\u524d\u4e8c\u76f4\u9009"},"70":{"lotteryid":"2","methodid":"70","methodname":"\u4e07\u4f4d"},"71":{"lotteryid":"2","methodid":"71","methodname":"\u5343\u4f4d"},"72":{"lotteryid":"2","methodid":"72","methodname":"\u767e\u4f4d"},"73":{"lotteryid":"2","methodid":"73","methodname":"\u5341\u4f4d"},"74":{"lotteryid":"2","methodid":"74","methodname":"\u4e2a\u4f4d"},"75":{"lotteryid":"2","methodid":"75","methodname":"\u524d\u4e8c\u5927\u5c0f\u5355\u53cc"},"76":{"lotteryid":"2","methodid":"76","methodname":"\u540e\u4e8c\u5927\u5c0f\u5355\u53cc"},"65":{"lotteryid":"2","methodid":"65","methodname":"\u4e8c\u7801\u4e0d\u5b9a\u4f4d"},"64":{"lotteryid":"2","methodid":"64","methodname":"\u4e00\u7801\u4e0d\u5b9a\u4f4d"},"63":{"lotteryid":"2","methodid":"63","methodname":"\u540e\u4e09\u7ec4\u9009_\u548c\u503c"},"52":{"lotteryid":"2","methodid":"52","methodname":"\u524d\u4e09\u76f4\u9009"},"53":{"lotteryid":"2","methodid":"53","methodname":"\u524d\u4e09\u76f4\u9009_\u548c\u503c"},"54":{"lotteryid":"2","methodid":"54","methodname":"\u540e\u4e09\u76f4\u9009"},"55":{"lotteryid":"2","methodid":"55","methodname":"\u540e\u4e09\u76f4\u9009_\u548c\u503c"},"56":{"lotteryid":"2","methodid":"56","methodname":"\u524d\u4e09\u7ec4\u9009_\u7ec4\u4e09"},"57":{"lotteryid":"2","methodid":"57","methodname":"\u524d\u4e09\u7ec4\u9009_\u7ec4\u516d"},"58":{"lotteryid":"2","methodid":"58","methodname":"\u524d\u4e09\u7ec4\u9009_\u6df7\u5408"},"59":{"lotteryid":"2","methodid":"59","methodname":"\u524d\u4e09\u7ec4\u9009_\u548c\u503c"},"60":{"lotteryid":"2","methodid":"60","methodname":"\u540e\u4e09\u7ec4\u9009_\u7ec4\u4e09"},"61":{"lotteryid":"2","methodid":"61","methodname":"\u540e\u4e09\u7ec4\u9009_\u7ec4\u516d"},"62":{"lotteryid":"2","methodid":"62","methodname":"\u540e\u4e09\u7ec4\u9009_\u6df7\u5408"}},"3":{"107":{"lotteryid":"3","methodid":"107","methodname":"\u540e\u4e8c\u7ec4\u9009"},"106":{"lotteryid":"3","methodid":"106","methodname":"\u524d\u4e8c\u7ec4\u9009"},"105":{"lotteryid":"3","methodid":"105","methodname":"\u540e\u4e8c\u76f4\u9009"},"104":{"lotteryid":"3","methodid":"104","methodname":"\u524d\u4e8c\u76f4\u9009"},"108":{"lotteryid":"3","methodid":"108","methodname":"\u4e07\u4f4d"},"109":{"lotteryid":"3","methodid":"109","methodname":"\u5343\u4f4d"},"110":{"lotteryid":"3","methodid":"110","methodname":"\u767e\u4f4d"},"111":{"lotteryid":"3","methodid":"111","methodname":"\u5341\u4f4d"},"112":{"lotteryid":"3","methodid":"112","methodname":"\u4e2a\u4f4d"},"113":{"lotteryid":"3","methodid":"113","methodname":"\u524d\u4e8c\u5927\u5c0f\u5355\u53cc"},"114":{"lotteryid":"3","methodid":"114","methodname":"\u540e\u4e8c\u5927\u5c0f\u5355\u53cc"},"103":{"lotteryid":"3","methodid":"103","methodname":"\u4e8c\u7801\u4e0d\u5b9a\u4f4d"},"102":{"lotteryid":"3","methodid":"102","methodname":"\u4e00\u7801\u4e0d\u5b9a\u4f4d"},"101":{"lotteryid":"3","methodid":"101","methodname":"\u540e\u4e09\u7ec4\u9009_\u548c\u503c"},"90":{"lotteryid":"3","methodid":"90","methodname":"\u524d\u4e09\u76f4\u9009"},"91":{"lotteryid":"3","methodid":"91","methodname":"\u524d\u4e09\u76f4\u9009_\u548c\u503c"},"92":{"lotteryid":"3","methodid":"92","methodname":"\u540e\u4e09\u76f4\u9009"},"93":{"lotteryid":"3","methodid":"93","methodname":"\u540e\u4e09\u76f4\u9009_\u548c\u503c"},"94":{"lotteryid":"3","methodid":"94","methodname":"\u524d\u4e09\u7ec4\u9009_\u7ec4\u4e09"},"95":{"lotteryid":"3","methodid":"95","methodname":"\u524d\u4e09\u7ec4\u9009_\u7ec4\u516d"},"96":{"lotteryid":"3","methodid":"96","methodname":"\u524d\u4e09\u7ec4\u9009_\u6df7\u5408"},"97":{"lotteryid":"3","methodid":"97","methodname":"\u524d\u4e09\u7ec4\u9009_\u548c\u503c"},"98":{"lotteryid":"3","methodid":"98","methodname":"\u540e\u4e09\u7ec4\u9009_\u7ec4\u4e09"},"99":{"lotteryid":"3","methodid":"99","methodname":"\u540e\u4e09\u7ec4\u9009_\u7ec4\u516d"},"100":{"lotteryid":"3","methodid":"100","methodname":"\u540e\u4e09\u7ec4\u9009_\u6df7\u5408"}},"4":{"145":{"lotteryid":"4","methodid":"145","methodname":"\u540e\u4e8c\u7ec4\u9009"},"144":{"lotteryid":"4","methodid":"144","methodname":"\u524d\u4e8c\u7ec4\u9009"},"143":{"lotteryid":"4","methodid":"143","methodname":"\u540e\u4e8c\u76f4\u9009"},"142":{"lotteryid":"4","methodid":"142","methodname":"\u524d\u4e8c\u76f4\u9009"},"146":{"lotteryid":"4","methodid":"146","methodname":"\u4e07\u4f4d"},"147":{"lotteryid":"4","methodid":"147","methodname":"\u5343\u4f4d"},"148":{"lotteryid":"4","methodid":"148","methodname":"\u767e\u4f4d"},"149":{"lotteryid":"4","methodid":"149","methodname":"\u5341\u4f4d"},"150":{"lotteryid":"4","methodid":"150","methodname":"\u4e2a\u4f4d"},"151":{"lotteryid":"4","methodid":"151","methodname":"\u524d\u4e8c\u5927\u5c0f\u5355\u53cc"},"152":{"lotteryid":"4","methodid":"152","methodname":"\u540e\u4e8c\u5927\u5c0f\u5355\u53cc"},"141":{"lotteryid":"4","methodid":"141","methodname":"\u4e8c\u7801\u4e0d\u5b9a\u4f4d"},"140":{"lotteryid":"4","methodid":"140","methodname":"\u4e00\u7801\u4e0d\u5b9a\u4f4d"},"139":{"lotteryid":"4","methodid":"139","methodname":"\u540e\u4e09\u7ec4\u9009_\u548c\u503c"},"128":{"lotteryid":"4","methodid":"128","methodname":"\u524d\u4e09\u76f4\u9009"},"129":{"lotteryid":"4","methodid":"129","methodname":"\u524d\u4e09\u76f4\u9009_\u548c\u503c"},"130":{"lotteryid":"4","methodid":"130","methodname":"\u540e\u4e09\u76f4\u9009"},"131":{"lotteryid":"4","methodid":"131","methodname":"\u540e\u4e09\u76f4\u9009_\u548c\u503c"},"132":{"lotteryid":"4","methodid":"132","methodname":"\u524d\u4e09\u7ec4\u9009_\u7ec4\u4e09"},"133":{"lotteryid":"4","methodid":"133","methodname":"\u524d\u4e09\u7ec4\u9009_\u7ec4\u516d"},"134":{"lotteryid":"4","methodid":"134","methodname":"\u524d\u4e09\u7ec4\u9009_\u6df7\u5408"},"135":{"lotteryid":"4","methodid":"135","methodname":"\u524d\u4e09\u7ec4\u9009_\u548c\u503c"},"136":{"lotteryid":"4","methodid":"136","methodname":"\u540e\u4e09\u7ec4\u9009_\u7ec4\u4e09"},"137":{"lotteryid":"4","methodid":"137","methodname":"\u540e\u4e09\u7ec4\u9009_\u7ec4\u516d"},"138":{"lotteryid":"4","methodid":"138","methodname":"\u540e\u4e09\u7ec4\u9009_\u6df7\u5408"}},"5":{"174":{"lotteryid":"5","methodid":"174","methodname":"\u524d\u4e8c\u7ec4\u9009"},"175":{"lotteryid":"5","methodid":"175","methodname":"\u540e\u4e8c\u7ec4\u9009"},"176":{"lotteryid":"5","methodid":"176","methodname":"\u767e\u4f4d"},"177":{"lotteryid":"5","methodid":"177","methodname":"\u5341\u4f4d"},"178":{"lotteryid":"5","methodid":"178","methodname":"\u4e2a\u4f4d"},"179":{"lotteryid":"5","methodid":"179","methodname":"\u524d\u4e8c\u5927\u5c0f\u5355\u53cc"},"180":{"lotteryid":"5","methodid":"180","methodname":"\u540e\u4e8c\u5927\u5c0f\u5355\u53cc"},"173":{"lotteryid":"5","methodid":"173","methodname":"\u540e\u4e8c\u76f4\u9009"},"172":{"lotteryid":"5","methodid":"172","methodname":"\u524d\u4e8c\u76f4\u9009"},"171":{"lotteryid":"5","methodid":"171","methodname":"\u4e8c\u7801\u4e0d\u5b9a\u4f4d"},"164":{"lotteryid":"5","methodid":"164","methodname":"\u76f4\u9009"},"165":{"lotteryid":"5","methodid":"165","methodname":"\u76f4\u9009_\u548c\u503c"},"166":{"lotteryid":"5","methodid":"166","methodname":"\u7ec4\u4e09"},"167":{"lotteryid":"5","methodid":"167","methodname":"\u7ec4\u516d"},"168":{"lotteryid":"5","methodid":"168","methodname":"\u6df7\u5408\u7ec4\u9009"},"169":{"lotteryid":"5","methodid":"169","methodname":"\u7ec4\u9009\u548c\u503c"},"170":{"lotteryid":"5","methodid":"170","methodname":"\u4e00\u7801\u4e0d\u5b9a\u4f4d"}},"6":{"207":{"lotteryid":"6","methodid":"207","methodname":"\u4efb\u9009\u4e00\u4e2d\u4e00"},"208":{"lotteryid":"6","methodid":"208","methodname":"\u4efb\u9009\u4e8c\u4e2d\u4e8c"},"209":{"lotteryid":"6","methodid":"209","methodname":"\u4efb\u9009\u4e09\u4e2d\u4e09"},"210":{"lotteryid":"6","methodid":"210","methodname":"\u4efb\u9009\u56db\u4e2d\u56db"},"211":{"lotteryid":"6","methodid":"211","methodname":"\u4efb\u9009\u4e94\u4e2d\u4e94"},"212":{"lotteryid":"6","methodid":"212","methodname":"\u4efb\u9009\u516d\u4e2d\u4e94"},"213":{"lotteryid":"6","methodid":"213","methodname":"\u4efb\u9009\u4e03\u4e2d\u4e94"},"214":{"lotteryid":"6","methodid":"214","methodname":"\u4efb\u9009\u516b\u4e2d\u4e94"},"206":{"lotteryid":"6","methodid":"206","methodname":"\u731c\u4e2d\u4f4d"},"205":{"lotteryid":"6","methodid":"205","methodname":"\u5b9a\u5355\u53cc"},"197":{"lotteryid":"6","methodid":"197","methodname":"\u524d\u4e09\u76f4\u9009"},"198":{"lotteryid":"6","methodid":"198","methodname":"\u524d\u4e09\u7ec4\u9009"},"199":{"lotteryid":"6","methodid":"199","methodname":"\u524d\u4e8c\u76f4\u9009"},"200":{"lotteryid":"6","methodid":"200","methodname":"\u524d\u4e8c\u7ec4\u9009"},"201":{"lotteryid":"6","methodid":"201","methodname":"\u524d\u4e09\u4e0d\u5b9a\u4f4d"},"202":{"lotteryid":"6","methodid":"202","methodname":"\u7b2c\u4e00\u4f4d"},"203":{"lotteryid":"6","methodid":"203","methodname":"\u7b2c\u4e8c\u4f4d"},"204":{"lotteryid":"6","methodid":"204","methodname":"\u7b2c\u4e09\u4f4d"}},"7":{"241":{"lotteryid":"7","methodid":"241","methodname":"\u4efb\u9009\u4e00\u4e2d\u4e00"},"242":{"lotteryid":"7","methodid":"242","methodname":"\u4efb\u9009\u4e8c\u4e2d\u4e8c"},"243":{"lotteryid":"7","methodid":"243","methodname":"\u4efb\u9009\u4e09\u4e2d\u4e09"},"244":{"lotteryid":"7","methodid":"244","methodname":"\u4efb\u9009\u56db\u4e2d\u56db"},"245":{"lotteryid":"7","methodid":"245","methodname":"\u4efb\u9009\u4e94\u4e2d\u4e94"},"246":{"lotteryid":"7","methodid":"246","methodname":"\u4efb\u9009\u516d\u4e2d\u4e94"},"247":{"lotteryid":"7","methodid":"247","methodname":"\u4efb\u9009\u4e03\u4e2d\u4e94"},"248":{"lotteryid":"7","methodid":"248","methodname":"\u4efb\u9009\u516b\u4e2d\u4e94"},"240":{"lotteryid":"7","methodid":"240","methodname":"\u731c\u4e2d\u4f4d"},"239":{"lotteryid":"7","methodid":"239","methodname":"\u5b9a\u5355\u53cc"},"231":{"lotteryid":"7","methodid":"231","methodname":"\u524d\u4e09\u76f4\u9009"},"232":{"lotteryid":"7","methodid":"232","methodname":"\u524d\u4e09\u7ec4\u9009"},"233":{"lotteryid":"7","methodid":"233","methodname":"\u524d\u4e8c\u76f4\u9009"},"234":{"lotteryid":"7","methodid":"234","methodname":"\u524d\u4e8c\u7ec4\u9009"},"235":{"lotteryid":"7","methodid":"235","methodname":"\u524d\u4e09\u4e0d\u5b9a\u4f4d"},"236":{"lotteryid":"7","methodid":"236","methodname":"\u7b2c\u4e00\u4f4d"},"237":{"lotteryid":"7","methodid":"237","methodname":"\u7b2c\u4e8c\u4f4d"},"238":{"lotteryid":"7","methodid":"238","methodname":"\u7b2c\u4e09\u4f4d"}},"8":{"275":{"lotteryid":"8","methodid":"275","methodname":"\u4efb\u9009\u4e00\u4e2d\u4e00"},"276":{"lotteryid":"8","methodid":"276","methodname":"\u4efb\u9009\u4e8c\u4e2d\u4e8c"},"277":{"lotteryid":"8","methodid":"277","methodname":"\u4efb\u9009\u4e09\u4e2d\u4e09"},"278":{"lotteryid":"8","methodid":"278","methodname":"\u4efb\u9009\u56db\u4e2d\u56db"},"279":{"lotteryid":"8","methodid":"279","methodname":"\u4efb\u9009\u4e94\u4e2d\u4e94"},"280":{"lotteryid":"8","methodid":"280","methodname":"\u4efb\u9009\u516d\u4e2d\u4e94"},"281":{"lotteryid":"8","methodid":"281","methodname":"\u4efb\u9009\u4e03\u4e2d\u4e94"},"282":{"lotteryid":"8","methodid":"282","methodname":"\u4efb\u9009\u516b\u4e2d\u4e94"},"274":{"lotteryid":"8","methodid":"274","methodname":"\u731c\u4e2d\u4f4d"},"273":{"lotteryid":"8","methodid":"273","methodname":"\u5b9a\u5355\u53cc"},"265":{"lotteryid":"8","methodid":"265","methodname":"\u524d\u4e09\u76f4\u9009"},"266":{"lotteryid":"8","methodid":"266","methodname":"\u524d\u4e09\u7ec4\u9009"},"267":{"lotteryid":"8","methodid":"267","methodname":"\u524d\u4e8c\u76f4\u9009"},"268":{"lotteryid":"8","methodid":"268","methodname":"\u524d\u4e8c\u7ec4\u9009"},"269":{"lotteryid":"8","methodid":"269","methodname":"\u524d\u4e09\u4e0d\u5b9a\u4f4d"},"270":{"lotteryid":"8","methodid":"270","methodname":"\u7b2c\u4e00\u4f4d"},"271":{"lotteryid":"8","methodid":"271","methodname":"\u7b2c\u4e8c\u4f4d"},"272":{"lotteryid":"8","methodid":"272","methodname":"\u7b2c\u4e09\u4f4d"}},"9":{"304":{"lotteryid":"9","methodid":"304","methodname":"\u524d\u4e8c\u7ec4\u9009"},"305":{"lotteryid":"9","methodid":"305","methodname":"\u540e\u4e8c\u7ec4\u9009"},"306":{"lotteryid":"9","methodid":"306","methodname":"\u767e\u4f4d"},"307":{"lotteryid":"9","methodid":"307","methodname":"\u5341\u4f4d"},"308":{"lotteryid":"9","methodid":"308","methodname":"\u4e2a\u4f4d"},"309":{"lotteryid":"9","methodid":"309","methodname":"\u524d\u4e8c\u5927\u5c0f\u5355\u53cc"},"310":{"lotteryid":"9","methodid":"310","methodname":"\u540e\u4e8c\u5927\u5c0f\u5355\u53cc"},"303":{"lotteryid":"9","methodid":"303","methodname":"\u540e\u4e8c\u76f4\u9009"},"302":{"lotteryid":"9","methodid":"302","methodname":"\u524d\u4e8c\u76f4\u9009"},"301":{"lotteryid":"9","methodid":"301","methodname":"\u4e8c\u7801\u4e0d\u5b9a\u4f4d"},"294":{"lotteryid":"9","methodid":"294","methodname":"\u76f4\u9009"},"295":{"lotteryid":"9","methodid":"295","methodname":"\u76f4\u9009_\u548c\u503c"},"296":{"lotteryid":"9","methodid":"296","methodname":"\u7ec4\u4e09"},"297":{"lotteryid":"9","methodid":"297","methodname":"\u7ec4\u516d"},"298":{"lotteryid":"9","methodid":"298","methodname":"\u6df7\u5408\u7ec4\u9009"},"299":{"lotteryid":"9","methodid":"299","methodname":"\u7ec4\u9009\u548c\u503c"},"300":{"lotteryid":"9","methodid":"300","methodname":"\u4e00\u7801\u4e0d\u5b9a\u4f4d"}},"10":{"333":{"lotteryid":"10","methodid":"333","methodname":"\u6392\u4e94\u540e\u4e8c\u7ec4\u9009"},"334":{"lotteryid":"10","methodid":"334","methodname":"\u4e07\u4f4d"},"335":{"lotteryid":"10","methodid":"335","methodname":"\u5343\u4f4d"},"336":{"lotteryid":"10","methodid":"336","methodname":"\u767e\u4f4d"},"337":{"lotteryid":"10","methodid":"337","methodname":"\u5341\u4f4d"},"338":{"lotteryid":"10","methodid":"338","methodname":"\u4e2a\u4f4d"},"339":{"lotteryid":"10","methodid":"339","methodname":"\u524d\u4e8c\u5927\u5c0f\u5355\u53cc"},"340":{"lotteryid":"10","methodid":"340","methodname":"\u540e\u4e8c\u5927\u5c0f\u5355\u53cc"},"332":{"lotteryid":"10","methodid":"332","methodname":"\u6392\u4e94\u524d\u4e8c\u7ec4\u9009"},"331":{"lotteryid":"10","methodid":"331","methodname":"\u6392\u4e94\u540e\u4e8c\u76f4\u9009"},"330":{"lotteryid":"10","methodid":"330","methodname":"\u6392\u4e94\u524d\u4e8c\u76f4\u9009"},"322":{"lotteryid":"10","methodid":"322","methodname":"\u6392\u4e09\u76f4\u9009"},"323":{"lotteryid":"10","methodid":"323","methodname":"\u6392\u4e09\u76f4\u9009_\u548c\u503c"},"324":{"lotteryid":"10","methodid":"324","methodname":"\u6392\u4e09\u7ec4\u9009_\u7ec4\u4e09"},"325":{"lotteryid":"10","methodid":"325","methodname":"\u6392\u4e09\u7ec4\u9009_\u7ec4\u516d"},"326":{"lotteryid":"10","methodid":"326","methodname":"\u6392\u4e09\u7ec4\u9009_\u6df7\u5408"},"327":{"lotteryid":"10","methodid":"327","methodname":"\u6392\u4e09\u7ec4\u9009_\u548c\u503c"},"328":{"lotteryid":"10","methodid":"328","methodname":"\u4e00\u7801\u4e0d\u5b9a\u4f4d"},"329":{"lotteryid":"10","methodid":"329","methodname":"\u4e8c\u7801\u4e0d\u5b9a\u4f4d"}},"11":{"368":{"lotteryid":"11","methodid":"368","methodname":"\u4efb\u9009\u4e00\u4e2d\u4e00"},"369":{"lotteryid":"11","methodid":"369","methodname":"\u4efb\u9009\u4e8c\u4e2d\u4e8c"},"370":{"lotteryid":"11","methodid":"370","methodname":"\u4efb\u9009\u4e09\u4e2d\u4e09"},"371":{"lotteryid":"11","methodid":"371","methodname":"\u4efb\u9009\u56db\u4e2d\u56db"},"372":{"lotteryid":"11","methodid":"372","methodname":"\u4efb\u9009\u4e94\u4e2d\u4e94"},"373":{"lotteryid":"11","methodid":"373","methodname":"\u4efb\u9009\u516d\u4e2d\u4e94"},"374":{"lotteryid":"11","methodid":"374","methodname":"\u4efb\u9009\u4e03\u4e2d\u4e94"},"367":{"lotteryid":"11","methodid":"367","methodname":"\u731c\u4e2d\u4f4d"},"366":{"lotteryid":"11","methodid":"366","methodname":"\u5b9a\u5355\u53cc"},"365":{"lotteryid":"11","methodid":"365","methodname":"\u7b2c\u4e09\u4f4d"},"364":{"lotteryid":"11","methodid":"364","methodname":"\u7b2c\u4e8c\u4f4d"},"363":{"lotteryid":"11","methodid":"363","methodname":"\u7b2c\u4e00\u4f4d"},"362":{"lotteryid":"11","methodid":"362","methodname":"\u524d\u4e09\u4e0d\u5b9a\u4f4d"},"361":{"lotteryid":"11","methodid":"361","methodname":"\u524d\u4e8c\u7ec4\u9009"},"360":{"lotteryid":"11","methodid":"360","methodname":"\u524d\u4e8c\u76f4\u9009"},"359":{"lotteryid":"11","methodid":"359","methodname":"\u524d\u4e09\u7ec4\u9009"},"358":{"lotteryid":"11","methodid":"358","methodname":"\u524d\u4e09\u76f4\u9009"},"375":{"lotteryid":"11","methodid":"375","methodname":"\u4efb\u9009\u516b\u4e2d\u4e94"}}};
jQuery(document).ready(function() {		
	jQuery("#starttime").dynDateTime({
		ifFormat: "%Y-%m-%d %H:%M:00",
		daFormat: "%l;%M %p, %e %m,  %Y",
		align: "Br",
		electric: true,
		singleClick: false,
		button: ".next()", //next sibling
		onUpdate:function(){
			$("#starttime").change();
		},
		showOthers: true,
		weekNumbers: true,
		showsTime: true
	});
	jQuery("#starttime").change(function(){
		if(! validateInputDate(jQuery("#starttime").val()) )
		{
			jQuery("#starttime").val('');
			alert("时间格式不正确,正确的格式为:2011-01-01 12:01");
		}
		if($("#endtime").val()!="")
		{
			if($("#starttime").val()>$("#endtime").val())
			{
				$("#starttime").val("");
				alert("输入的时间不符合逻辑.");
			}
		}
	});
	jQuery("#endtime").dynDateTime({
		ifFormat: "%Y-%m-%d %H:%M:00",
		daFormat: "%l;%M %p, %e %m,  %Y",
		align: "Br",
		electric: true,
		singleClick: false,
		button: ".next()", //next sibling
		onUpdate:function(){
			$("#endtime").change();
		},
		showOthers: true,
		weekNumbers: true,
		showsTime: true
	});
	jQuery("#endtime").change(function(){
		if(! validateInputDate(jQuery("#endtime").val()) )
		{
			jQuery("#endtime").val('');
			alert("时间格式不正确,正确的格式为:2011-01-01 12:01");
		}
		if($("#starttime").val()!="")
		{
			if($("#starttime").val()>$("#endtime").val())
			{
				$("#endtime").val("");
				alert("输入的时间不符合逻辑.");
			}
		}
	});
	jQuery("#lotteryid").change(function(){
		var obj_method = $("#methodid")[0];
		i =  $("#lotteryid").val();
		$("#methodid").empty();
		addItem( obj_method,'所有玩法',0 );
		if(i>0)
		{
			$.each(data_method[i],function(j,k){
				addItem( obj_method,k.methodname,k.methodid );
			});
		}
		SelectItem(obj_method,<?=$methodid?>);
	});
	$("#lotteryid").val(<?=$lotteryid?>);
	$("#lotteryid").change();
});

function checkForm(obj)
{
	if( jQuery.trim(obj.ordertime_min.value) != "" )
	{
		if( false == validateInputDate(obj.ordertime_min.value) )
		{
			alert("时间格式不正确");
			obj.ordertime_min.focus();
			return false;
		}
	}
	if( jQuery.trim(obj.ordertime_max.value) != "" )
	{
		if( false == validateInputDate(obj.ordertime_max.value) )
		{
			alert("时间格式不正确");
			obj.ordertime_max.focus();
			return false;
		}
	}
}
var checkall=document.getElementsByName("lids[]");  
function select(){                          //全选   
	for(var $i=0;$i<checkall.length;$i++){  
		checkall[$i].checked=true;  
	} 
}  
function fanselect(){                        //反选   
	for(var $i=0;$i<checkall.length;$i++){  
		if(checkall[$i].checked){  
			checkall[$i].checked=false;  
		}else{  
			checkall[$i].checked=true;  
		}  
	}  
}           
function noselect(){                          //全不选   
	for(var $i=0;$i<checkall.length;$i++){  
		checkall[$i].checked=false;  
	}  
}  
</script>
<base target="mainframe" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>

<body>
<br>
	<table width="95%" border="0" cellpadding="0" cellspacing="0" class="top_list">
      <tr>
        <td class="top_list_td icons_a4">　　您现在的位置是：业务流水 &gt; 帐变明细</td>
      </tr>
    </table>
    <br>
    <form name="memberForm" method="post" action="?">
    <table width="95%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td class="top_list_td">帐变时间:
          <input name="starttime" type="text" class="inpa" id="starttime" style='width:144px;' value="<?=$starttime?>" size="19" />
          <img class='icons_mb4' src="images/comm/t.gif" id="time_min_button" style="cursor:pointer;" /> 至
          <input name="endtime" type="text" class="inpa" id="endtime" style='width:144px;' value="<?=$endtime?>" size="19" / >
          <img class='icons_mb4' src="images/comm/t.gif" id="time_min_button" style="cursor:pointer;" />&nbsp;&nbsp;帐变类型:
<select name="ordertype">
               <option value="0" <?php if($ordertype==0 || $ordertype==""){echo "SELECTED";}?>>所有类型</option>
               <option value="1" <?php if($ordertype==1){echo "SELECTED";}?>>账户充值</option>
               <option value="2" <?php if($ordertype==2){echo "SELECTED";}?>>账户提现</option>
               <option value="3" <?php if($ordertype==3){echo "SELECTED";}?>>提现失败</option>
               <option value="7" <?php if($ordertype==7){echo "SELECTED";}?>>投注扣款</option>
               <option value="9" <?php if($ordertype==9){echo "SELECTED";}?>>追号扣款</option>
               <option value="10" <?php if($ordertype==10){echo "SELECTED";}?>>追号返款</option>
               <option value="11" <?php if($ordertype==11){echo "SELECTED";}?>>游戏返点</option>
               <option value="12" <?php if($ordertype==12){echo "SELECTED";}?>>奖金派送</option>
               <option value="13" <?php if($ordertype==13){echo "SELECTED";}?>>撤单返款</option>
               <option value="14" <?php if($ordertype==14){echo "SELECTED";}?>>撤单手续费</option>
               <option value="15" <?php if($ordertype==15){echo "SELECTED";}?>>撤消返点</option>
               <option value="16" <?php if($ordertype==16){echo "SELECTED";}?>>撤消派奖</option>
               <option value="30" <?php if($ordertype==30){echo "SELECTED";}?>>充值扣费</option>
               <option value="31" <?php if($ordertype==31){echo "SELECTED";}?>>上级充值</option>
               <option value="32" <?php if($ordertype==32){echo "SELECTED";}?>>活动礼金</option>
               <option value="40" <?php if($ordertype==40){echo "SELECTED";}?>>系统分红</option>
               <option value="50" <?php if($ordertype==50){echo "SELECTED";}?>>系统扣款</option>
			   <option value="60" <?php if($ordertype==60){echo "SELECTED";}?>>登录红包</option>
               <option value="999" <?php if($ordertype==999){echo "SELECTED";}?>>其他</option>
             </select>
&nbsp;&nbsp;
        <input name="Find_VN" type="submit" class="btnb" value="搜 索" style="position: relative; top: 2px;">
            <br>
          游戏名称:
          <select name="lotteryid" id="lotteryid" style="width:100px;">
            <option value="0" <?php if($lotteryid==0 || $lotteryid==""){echo "SELECTED";}?>>所有游戏</option>
            <option value="1" <?php if($lotteryid==1){echo "SELECTED";}?>>重庆时时彩</option>
            <option value="2" <?php if($lotteryid==2){echo "SELECTED";}?>>黑龙江时时彩</option>
            <option value="3" <?php if($lotteryid==3){echo "SELECTED";}?>>新疆时时彩</option>
            <option value="4" <?php if($lotteryid==4){echo "SELECTED";}?>>江西时时彩</option>
            <option value="5" <?php if($lotteryid==5){echo "SELECTED";}?>>上海时时乐</option>
            <option value="6" <?php if($lotteryid==6){echo "SELECTED";}?>>十一运夺金</option>
            <option value="7" <?php if($lotteryid==7){echo "SELECTED";}?>>多乐彩</option>
            <option value="8" <?php if($lotteryid==8){echo "SELECTED";}?>>广东十一选五</option>
            <option value="9" <?php if($lotteryid==9){echo "SELECTED";}?>>福彩3D</option>
            <option value="10" <?php if($lotteryid==10){echo "SELECTED";}?>>排列三、五</option>
            <option value="11" <?php if($lotteryid==11){echo "SELECTED";}?>>重庆十一选五</option>
          </select>
          &nbsp;游戏玩法:
          <select name='methodid' id='methodid' style='width:100px;'>
          <option value='0' selected="selected">所有玩法</option>
        </select>
        &nbsp;游戏模式:
        <select name="mode" id="mode">
          <option value="0" <?php if($mode==0 || $mode==""){echo "SELECTED";}?>>全部</option>
          <option value="1" <?php if($mode==1){echo "SELECTED";}?>>元</option>
          <option value="2" <?php if($mode==2){echo "SELECTED";}?>>角</option>
        </select>        &nbsp;&nbsp;帐变编号:
<input name="dan" type="text" class="inpa" value="" size="15" maxlength="30" id="dan">
用户名:
<input name="username" type="text" class="inpa" id="username" size="15" maxlength="30"></td>
      </tr>
    </table>
</form>
<br>
  	<form method=post action="?act=dels">
	<table width="95%" border="1" cellpadding="0" cellspacing="0" bordercolor="#DDDDDD" class="t_list">
        <tr>
            <td class="t_list_caption">选择</td>
            <td class="t_list_caption">帐变编号</td>
          <td class="t_list_caption">用户名</td>
          <td class="t_list_caption">时间</td>
          <td class="t_list_caption">类型</td>
            <td class="t_list_caption">游戏</td>
            <td class="t_list_caption">玩法</td>
            <td class="t_list_caption">期号</td>
            <td class="t_list_caption">模式</td>
            <td class="t_list_caption">收入</td>
            <td class="t_list_caption">支出</td>
            <td class="t_list_caption">余额</td>
            <td class="t_list_caption">备注</td>
          <td class="t_list_caption">操作</td>
      </tr>
        <?php
		while ($row = mysql_fetch_array($rsnewslist))
		{
	if($row['dan']==""){
		$dan=sprintf("%07s",strtoupper(base_convert($row['id'],10,36)));
		$sql="update ssc_record set dan='".$dan."' where id ='".$row['id']."'";  
		mysql_query($sql); 
	}else{
		$dan=$row['dan'];
	}
		?>
            <tr class="t_list_tr_0" onMouseOver="this.style.backgroundColor='#FFFFA2'" onMouseOut="this.style.backgroundColor=''">
                <td><input name="lids[]" type="checkbox" id="checkbox2" value="<?=$row['id']?>"></td> 
                <td><?=$dan?></td>
                <td><?=$row['username']?></td>
                <td><?=$row['adddate']?></td>
              	<td><?php if($row['types']==1){echo "账户充值";
        }else if($row['types']==2){echo "账户提现";
        }else if($row['types']==3){echo "提现失败";
        }else if($row['types']==7){echo "投注扣款";
        }else if($row['types']==9){echo "追号扣款";
        }else if($row['types']==10){echo "追号返款";
        }else if($row['types']==11){echo "游戏返点";
        }else if($row['types']==12){echo "奖金派送";
        }else if($row['types']==13){echo "撤单返款";
        }else if($row['types']==14){echo "撤单手续费";
        }else if($row['types']==15){echo "撤消返点";
        }else if($row['types']==16){echo "撤消派奖";
        }else if($row['types']==30){echo "充值扣费";
        }else if($row['types']==31){echo "上级充值";
        }else if($row['types']==32){echo "活动礼金";
        }else if($row['types']==40){echo "系统分红";
        }else if($row['types']==50){echo "系统扣款";
		}else if($row['types']==60){echo "登录红包";
		}else if($row['types']==70){echo "投注佣金返利";
        }else if($row['types']==999){echo "其他";}
		?></td>
                <td><?php if($row['lottery']!=''){echo $row['lottery'];}else{echo "<font color='#D0D0D0'>---";}?></td>
                <td><?php if($row['mid']!=''){echo Get_mid($row['mid']);}else{echo "<font color='#D0D0D0'>---";}?></td>
                <td><?php if($row['issue']!=''){echo $row['issue'];}else{echo "<font color='#D0D0D0'>---";}?></td>
                <td><?php if($row['mode']=='1'){echo "元";}else if($row['mode']=='2'){echo "角";}elseif($row['mode']=='3'){echo "分";}else{echo "<font color='#D0D0D0'>---";}?></td>
                <td><?php if($row['smoney']>0){echo "<font color='#669900'>+".number_format($row['smoney'],4)."</font>";}else if($row['smoney']<0){echo "<font color='#FF3300'>".number_format($row['smoney'],4)."</font>";}else{echo "<font color='#D0D0D0'>---";}?></td>
                <td><?php if($row['zmoney']!=""){echo "<font color='#FF3300'>-".number_format($row['zmoney'],4)."</font>";}else{echo "<font color='#D0D0D0'>---";}?></td>
                <td><?=number_format($row['leftmoney'],4)?></td>
                <td><?php if($row['tag']!=''){echo $row['tag'];}else{echo "<font color='#D0D0D0'>---";}?></td>
              <td><a href="?act=del&id=<?=$row['id']?>" onClick="return confirm('确认要删除吗?');">删除</a></td>
  </tr>
 		<?php
		}
		?>

      <tr>
            <td colspan="14" class="t_list_bottom"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="170" height="35">　选择：<a href="javascript:select()">全选</a> - <a href="javascript:fanselect()">反选</a> - <a href="javascript:noselect()">不选</a></td>
                <td width="150"><input name="Submit" type="submit" class="btndel" onClick="return confirm('确认要删除吗?');" value=" " /></td>
                <td><div style='text-align:right;'>总计  <?=$total?> 条数据,  共 <?=$lastpg?> 页 , 当前第 <?=$page?> 页  |  <?php if($page>1){?> <A HREF="?<?=$urls?>&page=1">首页</A> <A HREF="?<?=$urls?>&page=<?=$page-1?>">上页</A><?php }?><?php for($i=$p1;$i<=$p2;$i++){
		if($i==$page){?> <span class='Font_R'><?=$i?></span> <?php }else{?> <A HREF="?<?=$urls?>&page=<?=$i?>"><?=$i?></A> <?php }}?><?php if($page!=$lastpg){?> <A HREF="?<?=$urls?>&page=<?=$page+1?>">下页</A> <A HREF="?<?=$urls?>&page=<?=$lastpg?>">尾页</A> <?php }?> | 转至 <SCRIPT LANGUAGE="JAVASCRIPT">function keepKeyNum(obj,evt){var  k=window.event?evt.keyCode:evt.which; if( k==13 ){ goPage(obj.value);return false; }} function goPage( iPage ){ if( !isNaN(parseInt(iPage)) ) { if(iPage< 0 ){iPage=0;} window.location.href="?<?=$urls?>&page="+iPage;}}</SCRIPT><INPUT onKeyPress="return keepKeyNum(this,event);" TYPE="TEXT" ID="iGotoPage" NAME="iGotoPage" size="3"> 页  &nbsp;<BUTTON onClick="javascript:goPage( document.getElementById('iGotoPage').value );return false;">GO</BUTTON></div></td>
              </tr>
            </table></td>
      </tr>
</table>
</form>
<br>


</body>
</html> 