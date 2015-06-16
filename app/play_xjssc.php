<?php
session_start();
error_reporting(0);
require_once 'conn.php';
require_once 'check.php';

$flag=$_REQUEST['flag'];
$lotteryid="3";
$lottery="新疆时时彩";


$sqls="select * from ssc_nums where cid='3' and endtime>='".date("H:i:s")."' order by endtime asc limit 1";
//echo($sqls);
//exit;
$rss=mysql_query($sqls) or  die("数据库修改出错1".mysql_error());
$nums=mysql_num_rows($rss);
$dymd=date("Ymd");
$dymd2=date("Y-m-d");
if($nums==0){
	$sqls="select * from ssc_nums where cid='3' and endtime>='".date("H:i:s")."' order by endtime asc limit 1";
	$rss=mysql_query($sqls) or  die("数据库修改出错2".mysql_error());
	$dymd=date("ymd");
	$dymd2=date("Y-m-d");
}
$rows = mysql_fetch_array($rss);
$salenums=intval($rows['nums'])-1;
$leftnums=intval(96-$salenums);
if(intval($rows['nums'])>84){
	$dymd=date("Ymd",strtotime("-1 day"));
}else{
	$dymd=date("Ymd");
}
$dymd2=date("Y-m-d");
$issue=intval($dymd.substr($rows['nums'],1,2));
$opentime=$dymd2." ".$rows['opentime'];
$endtime=$dymd2." ".$rows['endtime'];


if($nums==0){
	if(date("H:i:s")<$rows['starttime']){
		$signss=1;	
	}
}


if($flag=="gettime"){
//	$lotteryid=$_REQUEST['lotteryid'];
//	$issue=$_REQUEST['issue'];	//120225076
	echo abs(strtotime($endtime)-time());
}else if($flag=="gethistory"){
	$sqla="select * from ssc_data where cid='3' and issue='".$_REQUEST['issue']."'";
	$rsa=mysql_query($sqla) or  die("数据库修改出错3".mysql_error());
	$rowa = mysql_fetch_array($rsa);
	if(empty($rowa)){
		echo "empty";
	}else{
		echo "{\"code\":[\"".$rowa['n1']."\",\"".$rowa['n2']."\",\"".$rowa['n3']."\",\"".$rowa['n4']."\",\"".$rowa['n5']."\"],\"issue\":\"".$_REQUEST['issue']."\",\"statuscode\":\"2\"}";//empty
	}
}else if($flag=="read"){
	if($signss==1){
		echo "empty";
	}else{
		echo "{issue:'".$issue."',nowtime:'".date("Y-m-d H:i:s")."',opentime:'".$opentime."',saleend:'".$endtime."',sale:'".$salenums."',left:'".$leftnums."'}";//empty未到销售时间
	}
}else if($flag=="save"){
	require_once 'playact.php';
}else{

	$sqlc="select * from ssc_data where cid='3' order by issue desc limit 1";
	$rsc=mysql_query($sqlc) or  die("数据库修改出错!!".mysql_error());
	$rowc = mysql_fetch_array($rsc);
	
	$sqld = "select * from ssc_class WHERE cid='3' order by id asc";
	$rsd = mysql_query($sqld);
	while ($rowd = mysql_fetch_array($rsd)){
		$strd=explode(";",$rowd['rates']);
		for ($i=0; $i<count($strd); $i++) {
			$rate[$rowd['mid']][$i]=$strd[$i];
		}
//		$rebate[$rowd['mid']]=$rowd['rebate'];
	}
	
	$sqld = "select * from ssc_classb WHERE cid='".$lotteryid."' order by id asc";
	$rsd = mysql_query($sqld);
	while ($rowd = mysql_fetch_array($rsd)){
		$zt[$rowd['mid']]=$rowd['zt'];
	}	
	
	$rstra=explode(";",Get_member(rebate));
	for ($i=0; $i<count($rstra)-1; $i++) {
		$rstrb=explode(",",$rstra[$i]);
		$rstrc=explode("_",$rstrb[0]);
		$rebate[$rstrc[1]]=$rstrb[1];
//		$zt[$rstrc[1]]=$rstrb[2];
	}
//	print_r($rate);

	if($signss==1){
		$_SESSION["backtitle"]="未到销售时间";
		$_SESSION["backurl"]="help_security.php";
		$_SESSION["backzt"]="failed";
		$_SESSION["backname"]="系统公告";
		echo "<script language=javascript>window.location='sysmessage.php';</script>";
		exit;	
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD><TITLE><?php echo $webname;?>  - 开始游戏[新疆时时彩]</TITLE>
<META http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<META http-equiv="Pragma" content="no-cache" />
<link href="css/play.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="js/jquery.js"></script>
<script language="javascript" type="text/javascript" src="js/common.js"></script>
<script language="javascipt" type="text/javascript">
$(function(){
    if($(".needchangebg:even").eq(0).html() != null){
        $(".needchangebg:even").find("td").css("background","#FAFCFE");
        $(".needchangebg:odd").find("td").css("background","#F9F9F9");
        $(".forzenuser").find("td").css("background","#FFE8E8");
		$(".self_tr").find("td").css("background","#FFF4D2");
        $(".needchangebg").hover(function(){
            $(this).find("td").css("background","#E8F2FF");
            $(".forzenuser").find("td").css("background","#FFE8E8");
        },function(){
            $(".needchangebg:even").find("td").css("background","#FAFCFE");
            $(".needchangebg:odd").find("td").css("background","#F9F9F9");
            $(".forzenuser").find("td").css("background","#FFE8E8");
        }
        );
    }else{
        $(".needchangebg:odd").find("td").css("background","#FAFCFE");
        $(".needchangebg:even").find("td").css("background","#F9F9F9");
		$(".forzenuser").find("td").css("background","#FFE8E8");
		$(".self_tr").find("td").css("background","#FFF4D2");
        $(".gametitle").css("background","#F9F9F9");
        $(".needchangebg").hover(function(){
            $(this).find("td").css("background","#E8F2FF");
            $(".gametitle").css("background","#F9F9F9");
        },function(){
            $(".lt tr:odd").find("td").css("background","#FAFCFE");
            $(".lt tr:even").find("td").css("background","#F9F9F9");
            $(".gametitle").css("background","#F9F9F9");
        }
        );
    }
})
</script>
<SCRIPT LANGUAGE='JavaScript'>function ResumeError() {return true;} window.onerror = ResumeError; </SCRIPT> 
</HEAD>
<BODY STYLE='background-color:#d4d4d4;'>
<STYLE>
#tabbar-div-s2 .tab-front .content{padding:0px 2px;}
#tabbar-div-s2 .tab-back .content{padding:0px 2px;}

.tabbar-div-s3 {margin-bottom: 0px;}
.tabbar-div-s3 .tab-front {margin:0px 0px 0px 3px;}
.tabbar-div-s3 .tab-front .content{padding:0px 1px 0px 4px;}
.tabbar-div-s3 .tab-back {margin:0px 0px 0px 3px;}
.tabbar-div-s3 .tab-back .content{padding:0px 1px 0px 4px;}
.div_s1 {width:808px;}
</STYLE>
<script language="javascript" src="js/dialog/jquery.dialogUI.js"></script>
<script language="javascript" src="js/lottery/lang_zh.js"></script>
<script language="javascript" src="js/lottery/jquery.lottery.js"></script>
<SCRIPT language="javascipt" type="text/javascript">
(function($){
$(document).ready(function(){
	$.playInit({ 
		data_label: [
									<?php if($zt[78]=="1"){?>
										{title:'后三直选',label:[{methoddesc:'从百位、十位、个位中至少各选1个号码。',
methodhelp:'从百位、十位、个位中选择一个3位数号码组成一注，所选号码与开奖号码后3位相同，且顺序一致，即为中奖。',
                                    selectarea:{
                                               type   : 'digital',
                                               layout : [
                                                           {title:'百位', no:'0|1|2|3|4|5|6|7|8|9', place:0, cols:1},
                                                           {title:'十位', no:'0|1|2|3|4|5|6|7|8|9', place:1, cols:1},
                                                           {title:'个位', no:'0|1|2|3|4|5|6|7|8|9', place:2, cols:1}
                                                          ],
                                               noBigIndex : 5,
                                               isButton   : true
                                              },
                                    show_str : '-,-,X,X,X',
                                    code_sp : '',
                                                  methodid : 92,
                                                  name:'复式',
                                                  prize:{1:'<?=$rate[92][0]?>'},
                                                  dyprize:[{"level":1,"prize":[{"point":"<?=$rebate[78]/100?>","prize":<?=$rate[92][0]?>},{"point":0,"prize":<?=floor($rate[92][0]*(1+$rebate[78]/90)*10)/10?>}]}],
                                                  modes:[{modeid:1,name:'元',rate:1},{modeid:2,name:'角',rate:0.1},{modeid:3,name:'分',rate:0.01}],
                                                  desc:'直选复式'
                                                },{methoddesc:'手动输入号码，至少输入1个三位数号码组成一注。',
methodhelp:'手动输入一个3位数号码组成一注，所选号码与开奖号码的百位、十位、个位相同，且顺序一致，即为中奖。',
                                    selectarea:{type:'input'},
                                    show_str : 'X',
                                    code_sp : ' ',
                                                  methodid : 92,
                                                  name:'单式',
                                                  prize:{1:'<?=$rate[92][0]?>'},
                                                  dyprize:[{"level":1,"prize":[{"point":"<?=$rebate[78]/100?>","prize":<?=$rate[92][0]?>},{"point":0,"prize":<?=floor($rate[92][0]*(1+$rebate[78]/90)*10)/10?>}]}],
                                                  modes:[{modeid:1,name:'元',rate:1},{modeid:2,name:'角',rate:0.1},{modeid:3,name:'分',rate:0.01}],
                                                  desc:'直选单式'
                                                },{methoddesc:'从0-27中任意选择1个或1个以上号码',
methodhelp:'所选数值等于开奖号码的百位、十位、个位三个数字相加之和，即为中奖。',
                                    selectarea:{
                                               type   : 'digital',
                                               layout : [
                                                           {title:'和值', no:'0|1|2|3|4|5|6|7|8|9|10|11|12|13|14|15|16|17|18|19|20|21|22|23|24|25|26|27', place:0, cols:1}
                                                         ],
                                               isButton   : false
                                              },
                                    show_str : 'X',
                                    code_sp : ',',
                                                  methodid : 93,
                                                  name:'和值',
                                                  prize:{1:'<?=$rate[93][0]?>'},
                                                  dyprize:[{"level":1,"prize":[{"point":"<?=$rebate[78]/100?>","prize":<?=$rate[93][0]?>},{"point":0,"prize":<?=floor($rate[93][0]*(1+$rebate[78]/90)*10)/10?>}]}],
                                                  modes:[{modeid:1,name:'元',rate:1},{modeid:2,name:'角',rate:0.1},{modeid:3,name:'分',rate:0.01}],
                                                  desc:'直选和值'
                                                }]}<?php if($zt[77]=="1" || $zt[79]=="1" || $zt[80]=="1" || $zt[81]=="1" || $zt[82]=="1" || $zt[83]=="1" || $zt[84]=="1" || $zt[85]=="1" || $zt[86]=="1" || $zt[87]=="1" || $zt[88]=="1" || $zt[89]=="1"){echo ",";}?>
									<?php }?>
									<?php if($zt[80]=="1"){?>												
												{title:'后三组选',label:[{methoddesc:'从0-9中任意选择2个或2个以上号码。',
methodhelp:'从0-9中选择2个数字组成两注，所选号码与开奖号码的百位、十位、个位相同，且顺序不限，即为中奖。',
                                    selectarea:{
                                               type   : 'digital',
                                               layout : [
                                                           {title:'组三', no:'0|1|2|3|4|5|6|7|8|9', place:0, cols:1}
                                                          ],
                                               noBigIndex : 5,
                                               isButton   : true
                                              },
                                    show_str : 'X',
                                    code_sp : ',',
                                                  methodid : 98,
                                                  name:'组三',
                                                  prize:{1:'<?=$rate[98][0]?>'},
                                                  dyprize:[{"level":1,"prize":[{"point":"<?=$rebate[80]/100?>","prize":<?=$rate[98][0]?>},{"point":0,"prize":<?=floor($rate[98][0]*(1+$rebate[80]/90)*10)/10?>}]}],
                                                  modes:[{modeid:1,name:'元',rate:1},{modeid:2,name:'角',rate:0.1},{modeid:3,name:'分',rate:0.01}],
                                                  desc:'组三'
                                                },{methoddesc:'从0-9中任意选择3个或3个以上号码。',
methodhelp:'从0-9中任意选择3个号码组成一注，所选号码与开奖号码的百位、十位、个位相同，顺序不限，即为中奖。',
                                    selectarea:{
                                               type   : 'digital',
                                               layout : [
                                                           {title:'组六', no:'0|1|2|3|4|5|6|7|8|9', place:0, cols:1}
                                                          ],
                                               noBigIndex : 5,
                                               isButton   : true
                                              },
                                    show_str : 'X',
                                    code_sp : ',',
                                                  methodid : 99,
                                                  name:'组六',
                                                  prize:{2:'<?=$rate[99][0]?>'},
                                                  dyprize:[{"level":2,"prize":[{"point":"<?=$rebate[80]/100?>","prize":<?=$rate[99][0]?>},{"point":0,"prize":<?=floor($rate[99][0]*(1+$rebate[80]/90)*10)/10?>}]}],
                                                  modes:[{modeid:1,name:'元',rate:1},{modeid:2,name:'角',rate:0.1},{modeid:3,name:'分',rate:0.01}],
                                                  desc:'组六'
                                                },{methoddesc:'手动输入号码，至少输入1个三位数号码。',
methodhelp:'键盘手动输入购买号码，3个数字为一注，开奖号码的百位、十位、个位符合后三组三或组六均为中奖。',
                                    selectarea:{type:'input'},
                                    show_str : 'X',
                                    code_sp : ' ',
                                                  methodid : 100,
                                                  name:'混合',
                                                  prize:{1:'<?=$rate[100][0]?>',2:'<?=$rate[100][1]?>'},
                                                  dyprize:[{"level":1,"prize":[{"point":"<?=$rebate[80]/100?>","prize":<?=$rate[100][0]?>},{"point":0,"prize":<?=floor($rate[100][0]*(1+$rebate[80]/90)*10)/10?>}]},{"level":2,"prize":[{"point":"<?=$rebate[80]/100?>","prize":<?=$rate[100][0]?>},{"point":0,"prize":<?=floor($rate[100][0]*(1+$rebate[80]/90)*10)/10?>},{"point":"<?=$rebate[80]/100?>","prize":<?=$rate[100][1]?>},{"point":0,"prize":<?=floor($rate[100][1]*(1+$rebate[80]/90)*10)/10?>}]}],
                                                  modes:[{modeid:1,name:'元',rate:1},{modeid:2,name:'角',rate:0.1},{modeid:3,name:'分',rate:0.01}],
                                                  desc:'混合组选'
                                                },{methoddesc:'从1-26中任意选择1个或1个以上号码。',
methodhelp:'所选数值等于开奖号码百位、十位、个位三个数字相加之和，即为中奖。',
                                    selectarea:{
                                               type   : 'digital',
                                               layout : [
                                                           {title:'和值', no:'1|2|3|4|5|6|7|8|9|10|11|12|13|14|15|16|17|18|19|20|21|22|23|24|25|26', place:0, cols:1}
                                                         ],
                                               isButton   : false
                                              },
                                    show_str : 'X',
                                    code_sp : ',',
                                                  methodid : 101,
                                                  name:'和值',
                                                  prize:{1:'<?=$rate[101][0]?>',2:'<?=$rate[101][1]?>'},
                                                  dyprize:[{"level":1,"prize":[{"point":"<?=$rebate[80]/100?>","prize":<?=$rate[101][0]?>},{"point":0,"prize":<?=floor($rate[101][0]*(1+$rebate[80]/90)*10)/10?>}]},{"level":2,"prize":[{"point":"<?=$rebate[80]/100?>","prize":<?=$rate[101][0]?>},{"point":0,"prize":<?=floor($rate[101][0]*(1+$rebate[80]/90)*10)/10?>},{"point":"<?=$rebate[80]/100?>","prize":<?=$rate[101][1]?>},{"point":0,"prize":<?=floor($rate[101][1]*(1+$rebate[80]/90)*10)/10?>}]}],
                                                  modes:[{modeid:1,name:'元',rate:1},{modeid:2,name:'角',rate:0.1},{modeid:3,name:'分',rate:0.01}],
                                                  desc:'组选和值'
                                                }]}<?php if($zt[77]=="1" || $zt[79]=="1" || $zt[81]=="1" || $zt[82]=="1" || $zt[83]=="1" || $zt[84]=="1" || $zt[85]=="1" || $zt[86]=="1" || $zt[87]=="1" || $zt[88]=="1" || $zt[89]=="1"){echo ",";}?>
									<?php }?>
									<?php if($zt[81]=="1" || $zt[82]=="1"){?>												
												{title:'后三不定位',label:[<?php if($zt[81]=="1"){?>{methoddesc:'从0-9中任意选择1个或1个以上号码。',
methodhelp:'从0-9中选择1个号码，每注由1个号码组成，只要开奖号码的百位、十位、个位中包含所选号码，即为中奖。',
                                    selectarea:{
                                               type   : 'digital',
                                               layout : [
                                                           {title:'一码', no:'0|1|2|3|4|5|6|7|8|9', place:0, cols:1}
                                                          ],
                                               noBigIndex : 5,
                                               isButton   : true
                                              },
                                    show_str : 'X',
                                    code_sp : ',',
                                                  methodid : 102,
                                                  name:'一码',
                                                  prize:{1:'<?=$rate[102][0]?>'},
                                                  dyprize:[{"level":1,"prize":[{"point":"<?=$rebate[81]/100?>","prize":<?=$rate[102][0]?>},{"point":0,"prize":<?=floor($rate[102][0]*(1+$rebate[81]/90)*10)/10?>}]}],
                                                  modes:[{modeid:1,name:'元',rate:1},{modeid:2,name:'角',rate:0.1},{modeid:3,name:'分',rate:0.01}],
                                                  desc:'一码不定位'
                                                }<?php if($zt[82]=="1"){echo ",";}?><?php }?><?php if($zt[82]=="1"){?>{methoddesc:'从0-9中任意选择2个或2个以上号码。',
methodhelp:'从0-9中选择2个号码，每注由2个不同的号码组成，开奖号码的百位、十位、个位中同时包含所选的2个号码，即为中奖。',
                                    selectarea:{
                                               type   : 'digital',
                                               layout : [
                                                           {title:'二码', no:'0|1|2|3|4|5|6|7|8|9', place:0, cols:1}
                                                          ],
                                               noBigIndex : 5,
                                               isButton   : true
                                              },
                                    show_str : 'X',
                                    code_sp : ',',
                                                  methodid : 103,
                                                  name:'二码',
                                                  prize:{1:'<?=$rate[103][0]?>'},
                                                  dyprize:[{"level":1,"prize":[{"point":"<?=$rebate[82]/100?>","prize":<?=$rate[103][0]?>},{"point":0,"prize":<?=floor($rate[103][0]*(1+$rebate[82]/90)*10)/10?>}]}],
                                                  modes:[{modeid:1,name:'元',rate:1},{modeid:2,name:'角',rate:0.1},{modeid:3,name:'分',rate:0.01}],
                                                  desc:'二码不定位'
                                                }<?php }?>]}<?php if($zt[77]=="1" || $zt[79]=="1" || $zt[83]=="1" || $zt[84]=="1" || $zt[85]=="1" || $zt[86]=="1" || $zt[87]=="1" || $zt[88]=="1" || $zt[89]=="1"){echo ",";}?>
									<?php }?>
									<?php if($zt[77]=="1"){?>	
												{title:'前三直选',label:[{methoddesc:'从万位、千位、百位中至少各选1个号码。',
methodhelp:'从万位、千位、百位中选择一个3位数号码组成一注，所选号码与开奖号码前3位相同，且顺序一致，即为中奖。',
selectarea:{type:'digital',layout:[{title:'万位', no:'0|1|2|3|4|5|6|7|8|9', place:0, cols:1},{title:'千位', no:'0|1|2|3|4|5|6|7|8|9', place:1, cols:1},{title:'百位', no:'0|1|2|3|4|5|6|7|8|9', place:2, cols:1}],noBigIndex:5,isButton:true},
show_str : 'X,X,X,-,-',
code_sp  : '',
                                                  methodid : 90,
                                                  name:'复式',
                                                  prize:{1:'<?=$rate[90][0]?>'},
                                                  dyprize:[{"level":1,"prize":[{"point":"<?=$rebate[77]/100?>","prize":<?=$rate[90][0]?>},{"point":0,"prize":<?=floor($rate[90][0]*(1+$rebate[77]/90)*10)/10?>}]}],
                                                  modes:[{modeid:1,name:'元',rate:1},{modeid:2,name:'角',rate:0.1},{modeid:3,name:'分',rate:0.01}],
                                                  desc:'直选复式'
                                                },{methoddesc:'手动输入号码，至少输入1个三位数号码组成一注。',
methodhelp:'手动输入一个3位数号码组成一注，所选号码与开奖号码的万位、千位、百位相同，且顺序一致，即为中奖。',
selectarea:{type:'input'},
show_str : 'X',
code_sp : ' ',
                                                  methodid : 90,
                                                  name:'单式',
                                                  prize:{1:'<?=$rate[90][0]?>'},
                                                  dyprize:[{"level":1,"prize":[{"point":"<?=$rebate[77]/100?>","prize":<?=$rate[90][0]?>},{"point":0,"prize":<?=floor($rate[90][0]*(1+$rebate[77]/90)*10)/10?>}]}],
                                                  modes:[{modeid:1,name:'元',rate:1},{modeid:2,name:'角',rate:0.1},{modeid:3,name:'分',rate:0.01}],
                                                  desc:'直选单式'
                                                },{methoddesc:'从0-27中任意选择1个或1个以上号码。',
methodhelp:'所选数值等于开奖号码万位、千位、百位三个数字相加之和，即为中奖。',
                                    selectarea:{
                                               type   : 'digital',
                                               layout : [
                                                           {title:'和值', no:'0|1|2|3|4|5|6|7|8|9|10|11|12|13|14|15|16|17|18|19|20|21|22|23|24|25|26|27', place:0, cols:1}
                                                         ],
                                               isButton   : false
                                              },
                                    show_str : 'X',
                                    code_sp : ',',
                                                  methodid : 91,
                                                  name:'和值',
                                                  prize:{1:'<?=$rate[91][0]?>'},
                                                  dyprize:[{"level":1,"prize":[{"point":"<?=$rebate[77]/100?>","prize":<?=$rate[91][0]?>},{"point":0,"prize":<?=floor($rate[91][0]*(1+$rebate[77]/90)*10)/10?>}]}],
                                                  modes:[{modeid:1,name:'元',rate:1},{modeid:2,name:'角',rate:0.1},{modeid:3,name:'分',rate:0.01}],
                                                  desc:'直选和值'
                                                }]}<?php if($zt[79]=="1" || $zt[83]=="1" || $zt[84]=="1" || $zt[85]=="1" || $zt[86]=="1" || $zt[87]=="1" || $zt[88]=="1" || $zt[89]=="1"){echo ",";}?>
									<?php }?>
									<?php if($zt[79]=="1"){?>
												{title:'前三组选',label:[{methoddesc:'从0-9中任意任选2个或2个以上号码。',
methodhelp:'从0-9中选择2个数字组成两注，所选号码与开奖号码的万位、千位、百位相同，且顺序不限，即为中奖。',
                                    selectarea:{
                                               type   : 'digital',
                                               layout : [
                                                           {title:'组三', no:'0|1|2|3|4|5|6|7|8|9', place:0, cols:1}
                                                          ],
                                               noBigIndex : 5,
                                               isButton   : true
                                              },
                                    show_str : 'X',
                                    code_sp : ',',
                                                  methodid : 94,
                                                  name:'组三',
                                                  prize:{1:'<?=$rate[94][0]?>'},
                                                  dyprize:[{"level":1,"prize":[{"point":"<?=$rebate[79]/100?>","prize":<?=$rate[94][0]?>},{"point":0,"prize":<?=floor($rate[94][0]*(1+$rebate[79]/90)*10)/10?>}]}],
                                                  modes:[{modeid:1,name:'元',rate:1},{modeid:2,name:'角',rate:0.1},{modeid:3,name:'分',rate:0.01}],
                                                  desc:'组三'
                                                },{methoddesc:'从0-9中任意任选3个或3个以上号码。',
methodhelp:'从0-9中任意选择3个号码组成一注，所选号码与开奖号码的万位、千位、百位相同，顺序不限，即为中奖。',
                                    selectarea:{
                                               type   : 'digital',
                                               layout : [
                                                           {title:'组六', no:'0|1|2|3|4|5|6|7|8|9', place:0, cols:1}
                                                          ],
                                               noBigIndex : 5,
                                               isButton   : true
                                              },
                                    show_str : 'X',
                                    code_sp : ',',
                                                  methodid : 95,
                                                  name:'组六',
                                                  prize:{2:'<?=$rate[95][0]?>'},
                                                  dyprize:[{"level":2,"prize":[{"point":"<?=$rebate[79]/100?>","prize":<?=$rate[95][0]?>},{"point":0,"prize":<?=floor($rate[95][0]*(1+$rebate[79]/90)*10)/10?>}]}],
                                                  modes:[{modeid:1,name:'元',rate:1},{modeid:2,name:'角',rate:0.1},{modeid:3,name:'分',rate:0.01}],
                                                  desc:'组六'
                                                },{methoddesc:'手动输入号码，至少输入1个三位数号码组成一注。',
methodhelp:'键盘手动输入购买号码，3个数字为一注，开奖号码的万位、千位、百位符合前三的组三或组六均为中奖。',
                                    selectarea:{type:'input'},
                                    show_str : 'X',
                                    code_sp : ' ',
                                                  methodid : 96,
                                                  name:'混合',
                                                  prize:{1:'<?=$rate[96][0]?>',2:'<?=$rate[96][1]?>'},
                                                  dyprize:[{"level":1,"prize":[{"point":"<?=$rebate[79]/100?>","prize":<?=$rate[96][0]?>},{"point":0,"prize":<?=floor($rate[96][0]*(1+$rebate[79]/90)*10)/10?>}]},{"level":2,"prize":[{"point":"<?=$rebate[79]/100?>","prize":<?=$rate[96][0]?>},{"point":0,"prize":<?=floor($rate[96][0]*(1+$rebate[79]/90)*10)/10?>},{"point":"<?=$rebate[79]/100?>","prize":<?=$rate[96][1]?>},{"point":0,"prize":<?=floor($rate[96][1]*(1+$rebate[79]/90)*10)/10?>}]}],
                                                  modes:[{modeid:1,name:'元',rate:1},{modeid:2,name:'角',rate:0.1},{modeid:3,name:'分',rate:0.01}],
                                                  desc:'混合组选'
                                                },{methoddesc:'从1-26中任意选择1个或1个以上号码。',
methodhelp:'所选数值等于开奖号码万位、千位、百位三个数字相加之和，即为中奖。',
                                    selectarea:{
                                               type   : 'digital',
                                               layout : [
                                                           {title:'和值', no:'1|2|3|4|5|6|7|8|9|10|11|12|13|14|15|16|17|18|19|20|21|22|23|24|25|26', place:0, cols:1}
                                                         ],
                                               isButton   : false
                                              },
                                    show_str : 'X',
                                    code_sp : ',',
                                                  methodid : 97,
                                                  name:'和值',
                                                  prize:{1:'<?=$rate[97][0]?>',2:'<?=$rate[97][1]?>'},
                                                  dyprize:[{"level":1,"prize":[{"point":"<?=$rebate[79]/100?>","prize":<?=$rate[97][0]?>},{"point":0,"prize":<?=floor($rate[97][0]*(1+$rebate[79]/90)*10)/10?>}]},{"level":2,"prize":[{"point":"<?=$rebate[79]/100?>","prize":<?=$rate[97][0]?>},{"point":0,"prize":<?=floor($rate[97][0]*(1+$rebate[79]/90)*10)/10?>},{"point":"<?=$rebate[79]/100?>","prize":<?=$rate[97][1]?>},{"point":0,"prize":<?=floor($rate[97][0]*(1+$rebate[79]/90)*10)/10?>}]}],
                                                  modes:[{modeid:1,name:'元',rate:1},{modeid:2,name:'角',rate:0.1},{modeid:3,name:'分',rate:0.01}],
                                                  desc:'组选和值'
                                                }]}<?php if($zt[83]=="1" || $zt[84]=="1" || $zt[85]=="1" || $zt[86]=="1" || $zt[87]=="1" || $zt[88]=="1" || $zt[89]=="1"){echo ",";}?>
									<?php }?>
									<?php if($zt[83]=="1" || $zt[84]=="1" || $zt[85]=="1" || $zt[86]=="1"){?>												
												{title:'二星',label:[<?php if($zt[84]=="1"){?>{methoddesc:'从十位和个位上至少各选1个号码。',
methodhelp:'从十位和个位上至少各选1个号码，所选号码与开奖号码的十位、个位相同，且顺序一致，即为中奖。',
                                    selectarea:{
                                               type   : 'digital',
                                               layout : [
                                                           {title:'十位', no:'0|1|2|3|4|5|6|7|8|9', place:0, cols:1},
                                                           {title:'个位', no:'0|1|2|3|4|5|6|7|8|9', place:1, cols:1}
                                                          ],
                                               noBigIndex : 5,
                                               isButton   : true
                                              },
                                    show_str : '-,-,-,X,X',
                                    code_sp : '',
                                                  methodid : 105,
                                                  name:'后二直选复式',
                                                  prize:{1:'<?=$rate[105][0]?>'},
                                                  dyprize:[{"level":1,"prize":[{"point":"<?=$rebate[84]/100?>","prize":<?=$rate[105][0]?>},{"point":0,"prize":<?=floor($rate[105][0]*(1+$rebate[84]/90)*10)/10?>}]}],
                                                  modes:[{modeid:1,name:'元',rate:1},{modeid:2,name:'角',rate:0.1},{modeid:3,name:'分',rate:0.01}],
                                                  desc:'后二直选复式'
                                                },{methoddesc:'手动输入号码，至少输入1个两位数号码。',
methodhelp:'手动输入一个2位数号码组成一注，所选号码与开奖号码的十位、个位相同，且顺序一致，即为中奖。',
selectarea:{type:'input'},
show_str : 'X',
code_sp : ' ',
                                                  methodid : 105,
                                                  name:'后二直选单式',
                                                  prize:{1:'<?=$rate[105][0]?>'},
                                                  dyprize:[{"level":1,"prize":[{"point":"<?=$rebate[84]/100?>","prize":<?=$rate[105][0]?>},{"point":0,"prize":<?=floor($rate[105][0]*(1+$rebate[84]/90)*10)/10?>}]}],
                                                  modes:[{modeid:1,name:'元',rate:1},{modeid:2,name:'角',rate:0.1},{modeid:3,name:'分',rate:0.01}],
                                                  desc:'后二直选单式'
                                                }<?php if($zt[83]=="1" || $zt[85]=="1" || $zt[86]=="1"){echo ",";}?><?php }?><?php if($zt[86]=="1"){?>{methoddesc:'从0-9中任意选择2个或2个以上号码。',
methodhelp:'从0-9中选2个号码组成一注，所选号码与开奖号码的十位、个位相同，顺序不限，即中奖。',
                                    selectarea:{
                                               type   : 'digital',
                                               layout : [
                                                           {title:'组选', no:'0|1|2|3|4|5|6|7|8|9', place:0, cols:1}
                                                          ],
                                               noBigIndex : 5,
                                               isButton   : true
                                              },
                                    show_str : 'X',
                                    code_sp : ',',
                                                  methodid : 107,
                                                  name:'后二组选复式',
                                                  prize:{1:'<?=$rate[107][0]?>'},
                                                  dyprize:[{"level":1,"prize":[{"point":"<?=$rebate[86]/100?>","prize":<?=$rate[107][0]?>},{"point":0,"prize":<?=floor($rate[107][0]*(1+$rebate[86]/90)*10)/10?>}]}],
                                                  modes:[{modeid:1,name:'元',rate:1},{modeid:2,name:'角',rate:0.1},{modeid:3,name:'分',rate:0.01}],
                                                  desc:'后二组选复式'
                                               /* },{methoddesc:'手动输入号码，至少输入1个两位数号码。',
methodhelp:'手动输入购买号码，2个数字为一注，所选号码与开奖号码的十位、个位相同，顺序不限，即为中奖。',
selectarea:{type:'input'},
show_str : 'X',
code_sp : ' ',
                                                  methodid : 107,
                                                  name:'后二组选单式',
                                                  prize:{1:'<?=$rate[107][0]?>'},
                                                  dyprize:[{"level":1,"prize":[{"point":"<?=$rebate[86]/100?>","prize":<?=$rate[107][0]?>},{"point":0,"prize":<?=floor($rate[107][0]*(1+$rebate[86]/90)*10)/10?>}]}],
                                                  modes:[{modeid:1,name:'元',rate:1},{modeid:2,name:'角',rate:0.1},{modeid:3,name:'分',rate:0.01}],
                                                  desc:'后二组选单式'*/
                                                }<?php if($zt[83]=="1" || $zt[85]=="1"){echo ",";}?><?php }?><?php if($zt[83]=="1"){?>{methoddesc:'从万位和千位上至少各选1个号码。',
methodhelp:'从万位和千位上至少各选1个号码，所选号码与开奖号码的万位、千位相同，且顺序一致，即为中奖。',
                                    selectarea:{
                                               type   : 'digital',
                                               layout : [
                                                           {title:'万位', no:'0|1|2|3|4|5|6|7|8|9', place:0, cols:1},
                                                           {title:'千位', no:'0|1|2|3|4|5|6|7|8|9', place:1, cols:1}
                                                          ],
                                               noBigIndex : 5,
                                               isButton   : true
                                              },
                                    show_str : 'X,X,-,-,-',
                                    code_sp : '',
                                                  methodid : 104,
                                                  name:'前二直选复式',
                                                  prize:{1:'<?=$rate[104][0]?>'},
                                                  dyprize:[{"level":1,"prize":[{"point":"<?=$rebate[83]/100?>","prize":<?=$rate[104][0]?>},{"point":0,"prize":<?=floor($rate[104][0]*(1+$rebate[83]/90)*10)/10?>}]}],
                                                  modes:[{modeid:1,name:'元',rate:1},{modeid:2,name:'角',rate:0.1},{modeid:3,name:'分',rate:0.01}],
                                                  desc:'前二直选复式'
                                                },{methoddesc:'手动输入号码，至少输入1个两位数号码。',
methodhelp:'手动输入一个2位数号码组成一注，所选号码与开奖号码的万位、千位相同，且顺序一致，即为中奖。',
selectarea:{type:'input'},
show_str : 'X',
code_sp : ' ',
                                                  methodid : 104,
                                                  name:'前二直选单式',
                                                  prize:{1:'<?=$rate[104][0]?>'},
                                                  dyprize:[{"level":1,"prize":[{"point":"<?=$rebate[83]/100?>","prize":<?=$rate[104][0]?>},{"point":0,"prize":<?=floor($rate[104][0]*(1+$rebate[83]/90)*10)/10?>}]}],
                                                  modes:[{modeid:1,name:'元',rate:1},{modeid:2,name:'角',rate:0.1},{modeid:3,name:'分',rate:0.01}],
                                                  desc:'前二直选单式'
                                                }<?php if($zt[85]=="1"){echo ",";}?><?php }?><?php if($zt[85]=="1"){?>{methoddesc:'从0-9中任意选择2个或2个以上号码。',
methodhelp:'从0-9中选2个号码组成一注，所选号码与开奖号码的万位、千位相同，顺序不限，即为中奖。',
                                    selectarea:{
                                               type   : 'digital',
                                               layout : [
                                                           {title:'组选', no:'0|1|2|3|4|5|6|7|8|9', place:0, cols:1}
                                                          ],
                                               noBigIndex : 5,
                                               isButton   : true
                                              },
                                    show_str : 'X',
                                    code_sp : ',',
                                                  methodid : 106,
                                                  name:'前二组选复式',
                                                  prize:{1:'<?=$rate[106][0]?>'},
                                                  dyprize:[{"level":1,"prize":[{"point":"<?=$rebate[85]/100?>","prize":<?=$rate[106][0]?>},{"point":0,"prize":<?=floor($rate[106][0]*(1+$rebate[85]/90)*10)/10?>}]}],
                                                  modes:[{modeid:1,name:'元',rate:1},{modeid:2,name:'角',rate:0.1},{modeid:3,name:'分',rate:0.01}],
                                                  desc:'前二组选复式'
                                                },{methoddesc:'手动输入号码，至少输入1个两位数号码。',
methodhelp:'手动输入购买号码，2个数字为一注，所选号码与开奖号码的万位、千位相同，顺序不限，即为中奖。',
selectarea:{type:'input'},
show_str : 'X',
code_sp : ' ',
                                                  methodid : 106,
                                                  name:'前二组选单式',
                                                  prize:{1:'<?=$rate[106][0]?>'},
                                                  dyprize:[{"level":1,"prize":[{"point":"<?=$rebate[85]/100?>","prize":<?=$rate[106][0]?>},{"point":0,"prize":<?=floor($rate[106][0]*(1+$rebate[85]/90)*10)/10?>}]}],
                                                  modes:[{modeid:1,name:'元',rate:1},{modeid:2,name:'角',rate:0.1},{modeid:3,name:'分',rate:0.01}],
                                                  desc:'前二组选单式'
                                                }<?php }?>]}<?php if($zt[87]=="1" || $zt[88]=="1" || $zt[89]=="1"){echo ",";}?>
									<?php }?>
									<?php if($zt[87]=="1"){?>												
												{title:'定位胆',label:[{methoddesc:'在万位，千位，百位，十位，个位任意位置上任意选择1个或1个以上号码。',
methodhelp:'从万位、千位、百位、十位、个位任意1个位置或多个位置上选择1个号码，所选号码与相同位置上的开奖号码一致，即为中奖。',
                                    selectarea:{
                                               type   : 'digital',
                                               layout : [
                                                           {title:'万位', no:'0|1|2|3|4|5|6|7|8|9', place:0, cols:1},
                                                           {title:'千位', no:'0|1|2|3|4|5|6|7|8|9', place:1, cols:1},
                                                           {title:'百位', no:'0|1|2|3|4|5|6|7|8|9', place:2, cols:1},
                                                           {title:'十位', no:'0|1|2|3|4|5|6|7|8|9', place:3, cols:1},
                                                           {title:'个位', no:'0|1|2|3|4|5|6|7|8|9', place:4, cols:1}
                                                          ],
                                               noBigIndex : 5,
                                               isButton   : true
                                              },
                                    show_str : 'X,X,X,X,X',
                                    code_sp : '',
                                                  methodid : 108,
                                                  name:'定位胆',
                                                  prize:{1:'<?=$rate[108][0]?>'},
                                                  dyprize:[{"level":1,"prize":[{"point":"<?=$rebate[87]/100?>","prize":<?=$rate[108][0]?>},{"point":0,"prize":<?=floor($rate[108][0]*(1+$rebate[87]/90)*10)/10?>}]}],
                                                  modes:[{modeid:1,name:'元',rate:1},{modeid:2,name:'角',rate:0.1},{modeid:3,name:'分',rate:0.01}],
                                                  desc:'定位胆'
                                                }]}<?php if($zt[88]=="1" || $zt[89]=="1"){echo ",";}?>
									<?php }?>
									<?php if($zt[88]=="1" || $zt[89]=="1"){?>												
												{title:'大小单双',label:[<?php if($zt[88]=="1"){?>{methoddesc:'从万位、千位中的“大、小、单、双”中至少各选一个组成一注。',
methodhelp:'对万位和千位的“大（56789）小（01234）、单（13579）双（02468）”形态进行购买，所选号码的位置、形态与开奖号码的位置、形态相同，即为中奖。',
                                    selectarea:{
                                                type:'dxds',
                                                layout: [{title:'万位', no:'大|小|单|双', place:0, cols:1},
                                                         {title:'千位', no:'大|小|单|双', place:1, cols:1}]
                                              },
                                    show_str : 'X,X',
                                    code_sp : '',
                                                  methodid : 113,
                                                  name:'前二',
                                                  prize:{1:'<?=$rate[113][0]?>'},
                                                  dyprize:[{"level":1,"prize":[{"point":"<?=$rebate[88]/100?>","prize":<?=$rate[113][0]?>},{"point":0,"prize":<?=floor($rate[113][0]*(1+$rebate[88]/90)*10)/10?>}]}],
                                                  modes:[{modeid:1,name:'元',rate:1},{modeid:2,name:'角',rate:0.1},{modeid:3,name:'分',rate:0.01}],
                                                  desc:'前二大小单双'
                                                }<?php if($zt[89]=="1"){echo ",";}?><?php }?><?php if($zt[89]=="1"){?>{methoddesc:'从十位、个位中的“大、小、单、双”中至少各选一个组成一注。',
methodhelp:'对十位和个位的“大（56789）小（01234）、单（13579）双（02468）”形态进行购买，所选号码的位置、形态与开奖号码的位置、形态相同，即为中奖。',
                                    selectarea:{
                                                type:'dxds',
                                                layout: [{title:'十位', no:'大|小|单|双', place:0, cols:1},
                                                         {title:'个位', no:'大|小|单|双', place:1, cols:1}]
                                              },
                                    show_str : 'X,X',
                                    code_sp : '',
                                                  methodid : 114,
                                                  name:'后二',
                                                  prize:{1:'<?=$rate[114][0]?>'},
                                                  dyprize:[{"level":1,"prize":[{"point":"<?=$rebate[89]/100?>","prize":<?=$rate[114][0]?>},{"point":0,"prize":<?=floor($rate[114][0]*(1+$rebate[89]/90)*10)/10?>}]}],
                                                  modes:[{modeid:1,name:'元',rate:1},{modeid:2,name:'角',rate:0.1},{modeid:3,name:'分',rate:0.01}],
                                                  desc:'后二大小单双'
                                                }<?php }?>]}
									<?php }?>
												],
		cur_issue : {issue:'<?=$issue?>',endtime:'<?=$endtime?>',opentime:'<?=$opentime?>'},
		issues    : {//所有的可追号期数集合
                         today:[
<?php
if(intval($rows['nums'])>84){
	$sqlb="select * from ssc_nums where cid='3' and endtime>='".date("H:i:s")."' and endtime<='02:00:00' order by id asc";
}else{
	$sqlb="select * from ssc_nums where (cid='3' and endtime>='".date("H:i:s")."') or (cid='3' and endtime<='02:00:00') order by id asc";
}
	
//	$sqlb="select * from ssc_nums where cid='3' and endtimes >='".$dymd3."' order by id asc";

	$rsb=mysql_query($sqlb) or  die("数据库修改出错!".mysql_error());
	while ($rowb = mysql_fetch_array($rsb)){
		if($rowb['endtime']<="01:58:00"){
			echo "{issue:'".$dymd.substr($rowb['nums'],1,2)."',endtime:'".$dymd2." ".$rowb['endtime']."'}";
		}else{	
			echo "{issue:'".$dymd.substr($rowb['nums'],1,2)."',endtime:'".$dymd2." ".$rowb['endtime']."'}";
		}
		if($rowb['nums']!="096"){echo ",";}
	}

?>								                               ],
                         tomorrow: [
                                                               ]
                     },
		servertime: '<?=date("Y-m-d H:i:s")?>',
		lotteryid : parseInt(3,10),
		isdynamic : 1,
		//onfinishbuy: function(){window.parent.abcd();},
		ajaxurl   : './play_xjssc.php'
	});
});
})(jQuery);
</SCRIPT>

<CENTER>
<div id="rightcon">
            <div id="msgbox" class="win_bot" style="display:none;">
    <h5 id="msgtitle"></h5> <div class="wb_close" onclick="javascript:msgclose();"></div>
    <div class="clear"></div>
    <div class="wb_con">
            <p id="msgcontent"></p>
    </div>
    <div class="clear"></div>
    <a class="wb_p" href="#" onclick="javascript:prenotice();" id="msgpre">上一条</a><a class="wb_n" href="#" onclick="javascript:nextnotice();">下一条</a>
</div>            <div class=" game_rc"> 
                <form>
				
				
				
				
                    <!--奖期基本信息开始-->
                    <div class="gm_con">
                        <div class="gm_con_lt"></div>
                        <div class="gm_con_rt"></div>
                        <div class="gm_con_lb"></div>
                        <div class="gm_con_rb"></div>
                        <div class="gm_con_to">
                            <div class="gct_l">
                                <h3>新疆时时彩</h3>
                                <p class="gct_now">正在销售 <strong>第 <span id="current_issue"><?=$issue?></span> 期</strong> 今日已开 <strong><span id="current_sale"><?=$salenums?></span></strong> 期 剩 <strong><span id="current_left"><?=$leftnums?></span></strong> 期</p>
                                <div class="clear"></div>
                                <div class="gct_time">
                                    <p class="gct_now">本期销售截止时间  <span class=nbox id="current_endtime"><?=$endtime?></span></p>
                                    <div class="clear"></div>
                                    <p class="gct_now gct_now1">剩余</p><div class="gct_time_now"><div class="gct_time_now_l"><span id="count_down">00:00:00</span></div></div>
                                </div>
                                <div class="gct_menu">
                                    <a class="gct_menu_yl" href='history_code.php?id=3' target="_blank"></a>                                </div>
                            </div>
                            <div class="gct_r">
                                <h3>新疆时时彩  第 <b><span class=nn id="lt_gethistorycode"><?=substr($rowc['issue'],-10)?></span>  </b> 期 
								<span id="lt_opentimebox" style="display:none;">&nbsp;&nbsp;<span id="waitopendesc">等待开奖</span>&nbsp;<span style="color:#F9CE46;" id="lt_opentimeleft" ></span></span><span id="lt_opentimebox2" style="display:none; color:#F9CE46;"><strong>&nbsp;&nbsp;正在开奖</strong></span></h3>
								
								<div style="display:none;" class="tad" id="showadvbox"><a href="promotion_center.php"><img src='images/v1/ad.jpg' border="0" /></a></div>
								
								<div class="gct_r_nub" id="showcodebox">
                                    <div class="gr_s gr_s<?=$rowc['n1']?>" name="historycode" flag="normal"></div>
                                    <div class="gr_s gr_s<?=$rowc['n2']?>" name="historycode" flag="normal"></div>
                                    <div class="gr_s gr_s<?=$rowc['n3']?>" name="historycode" flag="normal"></div>
                                    <div class="gr_s gr_s<?=$rowc['n4']?>" name="historycode" flag="normal"></div>
                                    <div class="gr_s gr_s<?=$rowc['n5']?>" name="historycode" flag="normal"></div>
                              </div>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                    <!--奖期基本信息结束-->
                    <div class="gm_con">
                        <div class="gm_con_lt"></div>
                        <div class="gm_con_rt"></div>
                        <div class="gm_con_lb"></div>
                        <div class="gm_con_rb"></div>
                        <div class="gm_con_to">
                            <!--投注选号标签开始-->
                            <div class="tz_body">
                                <div class="unit">
                                    <div class="unit_title">
                                        <div class="ut_l"></div>
                                        <div class="u_tab_div" id="tabbar-div-s2"></div>
                                        <div class="ut_r"></div>
                                    </div>
                                    <div id="tabCon">
                                        <div class="tabcon_n">
                                            <div class="nl_lt"></div>
                                            <div class="nl_rt"></div>
                                            <div class="nl_lb"></div>
                                            <div class="nl_rb"></div>
											<div class=bd><div class=bd2 id="general_txt_0">
		<table class="tabbar-div-s3" id="tabbar-div-s3" width='100%'></table>
        <div class=bl3p></div>
	</div></div>
                                            <ul id="tabbar-div-s3"></ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="clear"></div>
                            </div>
                            <!--投注选标签开始-->
                            <div class="clear"></div>
                            <!--投注选号区开始-->
                            <div class="tzn_body">
                                <div class="tzn_b_n">
                                    <div class="tbn_lt"></div>
                                    <div class="tbn_lb"></div>
                                    <div class="tbn_rt"></div>
                                    <div class="tbn_rb"></div>
                                    <div class="tbn_top">
                                        <h5 id="lt_desc"></h5>
                                        <div class="clear"></div>
                                    </div>
                                    <div class="clear"></div>
                                    <div class="tbn_cen">
                                        <div class="tbn_c_ft"></div>
                                        <div class="tbn_c_s">
                                            <div id="lt_selector"></div>
                                            <div class="random_sel_button" id="random_sel_button" ></div>
                                            <div class="clear"></div>
                                        </div>
                                        <div class="tbn_c_fb"></div>
                                    </div>
                                    <div class="tbn_bot">
                                        <div class="tbn_b_top">
                                            <div class="tbn_bt_sel">
                                                您选择了 <strong><span class=n id="lt_sel_nums">0</span></strong> 注, 共 <strong><span class=n id="lt_sel_money">0</span></strong> 元,
                                                倍数:
                                                <!-- <span class="changetime" id="reducetime" title="减少1倍">－</span><INPUT name='lt_sel_times' type='TEXT' size=4 class='bei' id="lt_sel_times"><span class="changetime" id="plustime" title="增加1倍">＋</span>--><INPUT name='lt_sel_times' type='TEXT' size=4 class='bei' id="lt_sel_times">
                                                    倍
                                                    <select name="lt_sel_modes" id="lt_sel_modes">
                                                        <option>元模式</option>
                                                        <option>角模式</option>
                                                    </select>
                                                    <span id="lt_sel_prize"></span>
                                            </div>
                                            <div class="g_submit" id="lt_sel_insert"><span></span></div>
                                            <div class="clear"></div>
                                        </div>
                                        <div class="tbn_b_bot">
                                            <div class="tbn_bb_l">
                                                <div class="tbn_bb_ln">
                                                    <h4><input class="tbn_clear"  id="lt_cf_clear" name="" type="button" value="" /> <span class="icons_q1" id="lt_cf_help">&nbsp;&nbsp;&nbsp;</span> 投注项: <span id="lt_cf_count">0</span></h4>
                                                    <div class="tz_tab_list_box">
                                                        <table cellspacing=0 cellpadding=0 border=0 id="lt_cf_content" class="tz_tab_list">
                                                            <tr class='nr'>
                                                                <td class="tl_li_l" width="4"></td><td colspan="6" class="noinfo">暂无投注项</td><td class="tl_li_rn" width="4"></td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tbn_bb_r">
                                                <div class="sub_txt">
                                                    <p>总注数: <strong><span class='r' id="lt_cf_nums">0</span></strong> 注</p>
                                                    <p>总金额: <strong><span class='r' id="lt_cf_money">0</span></strong> 元</p>
                                                    <p>未来期: <span id="lt_issues"></span></p>
                                                </div>
                                                <div class="g_submit" id="lt_buy"><span></span></div>
                                            </div>
                                            <div class="clear"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--投注选号区结束-->
                            <div class="clear"></div>
                            <!--追号区开始-->
                            <div class="zh_body">
                                <div class="unit">
                                    <div class="unit_title" id="general_tab_100">
                                        <div class="ut_l"></div>
                                        <label class="zh_title" name="lt_trace_if" style="float:left;"><INPUT type="checkbox" name="lt_trace_if" id="lt_trace_if" value="yes">我要追号</label>
                                        <div class="ut_zh">
                                            <label class="zh_continue" name="lt_trace_stop">
                                                <input type="checkbox" name="lt_trace_stop" id="lt_trace_stop" disabled="disabled" value="yes">中奖后停止追号
                                            </label>
                                        </div>
                                        <div class="ut_r"></div>
                                    </div>
                                    <div id="lt_trace_box" STYLE='display:none' class="trace_box">
                                        <div class="tabcon_n">
                                            <div class="nl_lt"></div>
                                            <div class="nl_rt"></div>
                                            <div class="nl_lb"></div>
                                            <div class="nl_rb"></div>
                                            <div class="unit1">
                                                <div class="unit_title2">
                                                    <div>
                                                        <div  >
                                                            <div  id="general_txt_100">
                                                                <table width='100%'>
                                                                    <tr><td id="lt_trace_label"></td></tr>
                                                                </table>
                                                                <div class=bl3p></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="clear"></div>
                                                </div>
                                                <div class="clear"></div>
                                                <div class=zhgen>
                                                    <table width=100% border="0" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                            <td>
                                                                追号期数:<select id="lt_trace_qissueno">
                                                                    <option value="">请选择</option>
                                                                    <option value="5">5期</option>
                                                                    <option value="10" selected>10期</option>
                                                                    <option value="15">15期</option>
                                                                    <option value="20">20期</option>
                                                                    <option value="25">25期</option>
                                                                    <option value="all">全部</option>
                                                                </select>
                                                                总期数: <span class=y id="lt_trace_count">0</span> 期  追号总金额: <span class=y id="lt_trace_hmoney">0</span> 元
                                                                <br/>
                                                                追号计划: <span id="lt_trace_labelhtml"></span>                                                            </td>
                                                            <td rowspan=2 valign=bottom align=right>
                                                                <div class="g_submit" id="lt_trace_ok"><span></span></div>                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div class=zhlist id="lt_trace_issues"></div>
                                                <input type="hidden" name="lotteryid" id="lotteryid" value="1" />
                                                <input type="hidden" name="flag" id="flag" value="save" /> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--追号区结束-->
                        </div>
                    </div>
                                        <div class="clear"></div>
                                    </form>
            </div>
  </div>




<BR/><div id="footer"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td align="center"><table align="center" width="450">
<tr><td align="left">浏览器建议：首选IE 8.0浏览器，其次为火狐浏览器。</td></tr>
</table></td></tr><tr><td></td></tr></table></div>
</CENTER><br/><br/>
<?php echo $count?>
</BODY></HTML>
<?php }?>