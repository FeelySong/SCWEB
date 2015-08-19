<?php
session_start();
error_reporting(0);
require_once 'conn.php';
require_once 'check.php';

$flag=$_REQUEST['flag'];
$lotteryid="9";
$lottery="福彩3D";

$sqls="select * from ssc_nums where cid='9' and endtime>='".date("H:i:s")."' order by id asc limit 1";
$rss=mysql_query($sqls) or  die("数据库修改出错1".mysql_error());
$nums=mysql_num_rows($rss);
$dymd=date("y");
$dymd2=date("Y-m-d");
if($nums==0){
	$sqls="select * from ssc_nums where cid='9' order by id asc limit 1";
	$rss=mysql_query($sqls) or  die("数据库修改出错2".mysql_error());
	$dymd=date("Y",strtotime("+1 day"));
	$dymd2=date("Y-m-d",strtotime("+1 day"));
}

if($nums==0){
$signss=1;
}

if($dymd2<$stopstart){
	$tnums=sprintf("%03d",date("z")+2);
}
if($dymd2>=$stopstart && $dymd2<=$stopend){
	$dymd=date("Y",strtotime($stopend)+24*3600);
	$dymd2=date("Y-m-d",strtotime($stopend)+24*3600);
	$tnums=sprintf("%03d",date("z")+1-7);
}
if($dymd2>$stopstart){
	$tnums=sprintf("%03d",date("z")+2-7-1);
}

$rows = mysql_fetch_array($rss);
$salenums=0;
$leftnums=1-$salenums;
$issue=$dymd.$tnums;
$opentime=$dymd2." ".$rows['opentime'];
$endtime=$dymd2." ".$rows['endtime'];

//$rows['nums']为xxc2012-12-27
if($rows['nums']=="01"){
	if(date("H:i:s")<$rows['starttime'] || date("H:i:s")>$rows['endtime']){
		$signss=1;
	}
}


if($flag=="gettime"){
//	$lotteryid=$_REQUEST['lotteryid'];
//	$issue=$_REQUEST['issue'];	//120225076
	echo abs(strtotime($endtime)-time());
}else if($flag=="gethistory"){
	$sqla="select * from ssc_data where cid='9' and issue='".$_REQUEST['issue']."'";
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

	$sqlc="select * from ssc_data where cid='9' order by issue desc limit 1";
	$rsc=mysql_query($sqlc) or  die("数据库修改出错!!".mysql_error());
	$rowc = mysql_fetch_array($rsc);
	
	$sqld = "select * from ssc_class WHERE cid='9' order by id asc";
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
	
	if($signss==1){
		$_SESSION["backtitle"]="未到销售时间";
		$_SESSION["backurl"]="help_security.php";
		$_SESSION["backzt"]="failed";
		$_SESSION["backname"]="系统公告";
		echo "<script language=javascript>window.location='sysmessage.php';</script>";
		exit;	
	}
//	print_r($rate);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD><TITLE><?php echo $webname;?>  - 开始游戏[福彩3D]</TITLE>
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
									<?php if($zt[283]=="1"){?>		
										{title:'直选',label:[{methoddesc:'从百位、十位、个位中至少各选1个号码。',
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
                                                  methodid : 294,
                                                  name:'复式',
                                                  prize:{1:'<?=$rate[294][0]?>'},
                                                  dyprize:[{"level":1,"prize":[{"point":"<?=$rebate[283]/100?>","prize":<?=$rate[294][0]?>},{"point":0,"prize":<?=floor($rate[294][0]*(1+$rebate[283]/90)*10)/10?>}]}],
                                                  modes:[{modeid:1,name:'元',rate:1},{modeid:2,name:'角',rate:0.1},{modeid:3,name:'分',rate:0.01}],
                                                  desc:'直选复式'
                                                },{methoddesc:'手动输入号码，至少输入1个三位数号码组成一注。',
methodhelp:'手动输入一个3位数号码组成一注，所选号码与开奖号码的百位、十位、个位相同，且顺序一致，即为中奖。',
                                    selectarea:{type:'input'},
                                    show_str : 'X',
                                    code_sp : ' ',
                                                  methodid : 294,
                                                  name:'单式',
                                                  prize:{1:'<?=$rate[294][0]?>'},
                                                  dyprize:[{"level":1,"prize":[{"point":"<?=$rebate[283]/100?>","prize":<?=$rate[294][0]?>},{"point":0,"prize":<?=floor($rate[294][0]*(1+$rebate[283]/90)*10)/10?>}]}],
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
                                                  methodid : 295,
                                                  name:'和值',
                                                  prize:{1:'<?=$rate[295][0]?>'},
                                                  dyprize:[{"level":1,"prize":[{"point":"<?=$rebate[283]/100?>","prize":<?=$rate[295][0]?>},{"point":0,"prize":<?=floor($rate[295][0]*(1+$rebate[283]/90)*10)/10?>}]}],
                                                  modes:[{modeid:1,name:'元',rate:1},{modeid:2,name:'角',rate:0.1},{modeid:3,name:'分',rate:0.01}],
                                                  desc:'直选和值'
                                                }]}<?php if($zt[284]=="1" || $zt[285]=="1" || $zt[286]=="1" || $zt[287]=="1" || $zt[288]=="1" || $zt[289]=="1" || $zt[290]=="1" || $zt[291]=="1" || $zt[292]=="1" || $zt[293]=="1"){echo ",";}?>
									<?php }?>
									<?php if($zt[284]=="1"){?>
												{title:'组选',label:[{methoddesc:'从0-9中任意选择2个或2个以上号码。',
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
                                                  methodid : 296,
                                                  name:'组三',
                                                  prize:{1:'<?=$rate[296][0]?>'},
                                                  dyprize:[{"level":1,"prize":[{"point":"<?=$rebate[284]/100?>","prize":<?=$rate[296][0]?>},{"point":0,"prize":<?=floor($rate[296][0]*(1+$rebate[284]/90)*10)/10?>}]}],
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
                                                  methodid : 297,
                                                  name:'组六',
                                                  prize:{2:'<?=$rate[297][0]?>'},
                                                  dyprize:[{"level":2,"prize":[{"point":"<?=$rebate[284]/100?>","prize":<?=$rate[297][0]?>},{"point":0,"prize":<?=floor($rate[297][0]*(1+$rebate[284]/90)*10)/10?>}]}],
                                                  modes:[{modeid:1,name:'元',rate:1},{modeid:2,name:'角',rate:0.1},{modeid:3,name:'分',rate:0.01}],
                                                  desc:'组六'
                                                },{methoddesc:'手动输入号码，至少输入1个三位数号码。',
methodhelp:'键盘手动输入购买号码，3个数字为一注，开奖号码的百位、十位、个位符合后三组三或组六均为中奖。',
                                    selectarea:{type:'input'},
                                    show_str : 'X',
                                    code_sp : ' ',
                                                  methodid : 298,
                                                  name:'混合',
                                                  prize:{1:'<?=$rate[298][0]?>',2:'<?=$rate[298][1]?>'},
                                                  dyprize:[{"level":1,"prize":[{"point":"<?=$rebate[284]/100?>","prize":<?=$rate[298][0]?>},{"point":0,"prize":<?=floor($rate[298][0]*(1+$rebate[284]/90)*10)/10?>}]},{"level":2,"prize":[{"point":"<?=$rebate[284]/100?>","prize":<?=$rate[298][0]?>},{"point":0,"prize":<?=floor($rate[298][0]*(1+$rebate[284]/90)*10)/10?>},{"point":"<?=$rebate[284]/100?>","prize":<?=$rate[298][1]?>},{"point":0,"prize":<?=floor($rate[298][1]*(1+$rebate[284]/90)*10)/10?>}]}],
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
                                                  methodid : 299,
                                                  name:'和值',
                                                  prize:{1:'<?=$rate[299][0]?>',2:'<?=$rate[299][1]?>'},
                                                  dyprize:[{"level":1,"prize":[{"point":"<?=$rebate[284]/100?>","prize":<?=$rate[299][0]?>},{"point":0,"prize":<?=floor($rate[299][0]*(1+$rebate[284]/90)*10)/10?>}]},{"level":2,"prize":[{"point":"<?=$rebate[284]/100?>","prize":<?=$rate[299][0]?>},{"point":0,"prize":<?=floor($rate[299][0]*(1+$rebate[284]/90)*10)/10?>},{"point":"<?=$rebate[284]/100?>","prize":<?=$rate[299][1]?>},{"point":0,"prize":<?=floor($rate[299][1]*(1+$rebate[284]/90)*10)/10?>}]}],
                                                  modes:[{modeid:1,name:'元',rate:1},{modeid:2,name:'角',rate:0.1},{modeid:3,name:'分',rate:0.01}],
                                                  desc:'组选和值'
                                                }]}<?php if($zt[285]=="1" || $zt[286]=="1" || $zt[287]=="1" || $zt[288]=="1" || $zt[289]=="1" || $zt[290]=="1" || $zt[291]=="1" || $zt[292]=="1" || $zt[293]=="1"){echo ",";}?>
									<?php }?>
									<?php if($zt[285]=="1" || $zt[286]=="1"){?>
												{title:'不定位',label:[<?php if($zt[285]=="1"){?>{methoddesc:'从0-9中任意选择1个或1个以上号码。',
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
                                                  methodid : 300,
                                                  name:'一码',
                                                  prize:{1:'<?=$rate[300][0]?>'},
                                                  dyprize:[{"level":1,"prize":[{"point":"<?=$rebate[285]/100?>","prize":<?=$rate[300][0]?>},{"point":0,"prize":<?=floor($rate[300][0]*(1+$rebate[285]/90)*10)/10?>}]}],
                                                  modes:[{modeid:1,name:'元',rate:1},{modeid:2,name:'角',rate:0.1},{modeid:3,name:'分',rate:0.01}],
                                                  desc:'一码不定位'
                                                }<?php if($zt[286]=="1"){echo ",";}?><?php }?><?php if($zt[286]=="1"){?>{methoddesc:'从0-9中任意选择2个或2个以上号码。',
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
                                                  methodid : 301,
                                                  name:'二码',
                                                  prize:{1:'<?=$rate[301][0]?>'},
                                                  dyprize:[{"level":1,"prize":[{"point":"<?=$rebate[286]/100?>","prize":<?=$rate[301][0]?>},{"point":0,"prize":<?=floor($rate[301][0]*(1+$rebate[286]/90)*10)/10?>}]}],
                                                  modes:[{modeid:1,name:'元',rate:1},{modeid:2,name:'角',rate:0.1},{modeid:3,name:'分',rate:0.01}],
                                                  desc:'二码不定位'
                                                }<?php }?>]}<?php if($zt[287]=="1" || $zt[288]=="1" || $zt[289]=="1" || $zt[290]=="1" || $zt[291]=="1" || $zt[292]=="1" || $zt[293]=="1"){echo ",";}?>
									<?php }?>
									<?php if($zt[287]=="1" || $zt[288]=="1" || $zt[289]=="1" || $zt[290]=="1"){?>
												{title:'二星',label:[<?php if($zt[288]=="1"){?>{methoddesc:'从十位和个位上至少各选1个号码。',
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
                                                  methodid : 303,
                                                  name:'后二直选复式',
                                                  prize:{1:'<?=$rate[303][0]?>'},
                                                  dyprize:[{"level":1,"prize":[{"point":"<?=$rebate[288]/100?>","prize":<?=$rate[303][0]?>},{"point":0,"prize":<?=floor($rate[303][0]*(1+$rebate[288]/90)*10)/10?>}]}],
                                                  modes:[{modeid:1,name:'元',rate:1},{modeid:2,name:'角',rate:0.1},{modeid:3,name:'分',rate:0.01}],
                                                  desc:'后二直选复式'
                                                },{methoddesc:'手动输入号码，至少输入1个两位数号码。',
methodhelp:'手动输入一个2位数号码组成一注，所选号码与开奖号码的十位、个位相同，且顺序一致，即为中奖。',
selectarea:{type:'input'},
show_str : 'X',
code_sp : ' ',
                                                  methodid : 303,
                                                  name:'后二直选单式',
                                                  prize:{1:'<?=$rate[303][0]?>'},
                                                  dyprize:[{"level":1,"prize":[{"point":"<?=$rebate[288]/100?>","prize":<?=$rate[303][0]?>},{"point":0,"prize":<?=floor($rate[303][0]*(1+$rebate[288]/90)*10)/10?>}]}],
                                                  modes:[{modeid:1,name:'元',rate:1},{modeid:2,name:'角',rate:0.1},{modeid:3,name:'分',rate:0.01}],
                                                  desc:'后二直选单式'
                                                }<?php if($zt[287]=="1" || $zt[289]=="1" || $zt[290]=="1"){echo ",";}?><?php }?><?php if($zt[290]=="1"){?>{methoddesc:'从0-9中任意选择2个或2个以上号码。',
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
                                                  methodid : 305,
                                                  name:'后二组选复式',
                                                  prize:{1:'<?=$rate[305][0]?>'},
                                                  dyprize:[{"level":1,"prize":[{"point":"<?=$rebate[290]/100?>","prize":<?=$rate[305][0]?>},{"point":0,"prize":<?=floor($rate[305][0]*(1+$rebate[290]/90)*10)/10?>}]}],
                                                  modes:[{modeid:1,name:'元',rate:1},{modeid:2,name:'角',rate:0.1},{modeid:3,name:'分',rate:0.01}],
                                                  desc:'后二组选复式'
                                                },{methoddesc:'手动输入号码，至少输入1个两位数号码。',
methodhelp:'手动输入购买号码，2个数字为一注，所选号码与开奖号码的十位、个位相同，顺序不限，即为中奖。',
selectarea:{type:'input'},
show_str : 'X',
code_sp : ' ',
                                                  methodid : 305,
                                                  name:'后二组选单式',
                                                  prize:{1:'<?=$rate[305][0]?>'},
                                                  dyprize:[{"level":1,"prize":[{"point":"<?=$rebate[290]/100?>","prize":<?=$rate[305][0]?>},{"point":0,"prize":<?=floor($rate[305][0]*(1+$rebate[290]/90)*10)/10?>}]}],
                                                  modes:[{modeid:1,name:'元',rate:1},{modeid:2,name:'角',rate:0.1},{modeid:3,name:'分',rate:0.01}],
                                                  desc:'后二组选单式'
                                                }<?php if($zt[287]=="1" || $zt[289]=="1"){echo ",";}?><?php }?><?php if($zt[287]=="1"){?>{methoddesc:'从百位和十位上至少各选1个号码。',
methodhelp:'从百位和十位上至少各选1个号码，所选号码与开奖号码的百位、十位相同，且顺序一致，即为中奖。',
                                    selectarea:{
                                               type   : 'digital',
                                               layout : [
                                                           {title:'百位', no:'0|1|2|3|4|5|6|7|8|9', place:0, cols:1},
                                                           {title:'十位', no:'0|1|2|3|4|5|6|7|8|9', place:1, cols:1}
                                                          ],
                                               noBigIndex : 5,
                                               isButton   : true
                                              },
                                    show_str : 'X,X,-,-,-',
                                    code_sp : '',
                                                  methodid : 302,
                                                  name:'前二直选复式',
                                                  prize:{1:'<?=$rate[302][0]?>'},
                                                  dyprize:[{"level":1,"prize":[{"point":"<?=$rebate[287]/100?>","prize":<?=$rate[302][0]?>},{"point":0,"prize":<?=floor($rate[302][0]*(1+$rebate[287]/90)*10)/10?>}]}],
                                                  modes:[{modeid:1,name:'元',rate:1},{modeid:2,name:'角',rate:0.1},{modeid:3,name:'分',rate:0.01}],
                                                  desc:'前二直选复式'
                                                },{methoddesc:'手动输入号码，至少输入1个两位数号码。',
methodhelp:'手动输入一个2位数号码组成一注，所选号码与开奖号码的百位、十位相同，且顺序一致，即为中奖。',
selectarea:{type:'input'},
show_str : 'X',
code_sp : ' ',
                                                  methodid : 302,
                                                  name:'前二直选单式',
                                                  prize:{1:'<?=$rate[302][0]?>'},
                                                  dyprize:[{"level":1,"prize":[{"point":"<?=$rebate[287]/100?>","prize":<?=$rate[302][0]?>},{"point":0,"prize":<?=floor($rate[302][0]*(1+$rebate[287]/90)*10)/10?>}]}],
                                                  modes:[{modeid:1,name:'元',rate:1},{modeid:2,name:'角',rate:0.1},{modeid:3,name:'分',rate:0.01}],
                                                  desc:'前二直选单式'
                                                }<?php if($zt[289]=="1"){echo ",";}?><?php }?><?php if($zt[289]=="1"){?>{methoddesc:'从0-9中任意选择2个或2个以上号码。',
methodhelp:'从0-9中选2个号码组成一注，所选号码与开奖号码的百位、十位相同，顺序不限，即为中奖。',
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
                                                  methodid : 304,
                                                  name:'前二组选复式',
                                                  prize:{1:'<?=$rate[304][0]?>'},
                                                  dyprize:[{"level":1,"prize":[{"point":"<?=$rebate[289]/100?>","prize":<?=$rate[304][0]?>},{"point":0,"prize":<?=floor($rate[304][0]*(1+$rebate[289]/90)*10)/10?>}]}],
                                                  modes:[{modeid:1,name:'元',rate:1},{modeid:2,name:'角',rate:0.1},{modeid:3,name:'分',rate:0.01}],
                                                  desc:'前二组选复式'
                                                },{methoddesc:'手动输入号码，至少输入1个两位数号码。',
methodhelp:'手动输入购买号码，2个数字为一注，所选号码与开奖号码的百位、十位相同，顺序不限，即为中奖。',
selectarea:{type:'input'},
show_str : 'X',
code_sp : ' ',
                                                  methodid : 304,
                                                  name:'前二组选单式',
                                                  prize:{1:'<?=$rate[304][0]?>'},
                                                  dyprize:[{"level":1,"prize":[{"point":"<?=$rebate[289]/100?>","prize":<?=$rate[304][0]?>},{"point":0,"prize":<?=floor($rate[304][0]*(1+$rebate[289]/90)*10)/10?>}]}],
                                                  modes:[{modeid:1,name:'元',rate:1},{modeid:2,name:'角',rate:0.1},{modeid:3,name:'分',rate:0.01}],
                                                  desc:'前二组选单式'
                                                }<?php }?>]}<?php if($zt[291]=="1" || $zt[292]=="1" || $zt[293]=="1"){echo ",";}?>
									<?php }?>
									<?php if($zt[291]=="1"){?>												
												{title:'定位胆',label:[{methoddesc:'在百位，十位，个位任意位置上任意选择1个或1个以上号码。',
methodhelp:'从百位、十位、个位任意1个位置或多个位置上选择1个号码，所选号码与相同位置上的开奖号码一致，即为中奖。',
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
                                    show_str : 'X,X,X',
                                    code_sp : '',
                                                  methodid : 306,
                                                  name:'定位胆',
                                                  prize:{1:'<?=$rate[306][0]?>'},
                                                  dyprize:[{"level":1,"prize":[{"point":"<?=$rebate[291]/100?>","prize":<?=$rate[306][0]?>},{"point":0,"prize":<?=floor($rate[306][0]*(1+$rebate[291]/90)*10)/10?>}]}],
                                                  modes:[{modeid:1,name:'元',rate:1},{modeid:2,name:'角',rate:0.1},{modeid:3,name:'分',rate:0.01}],
                                                  desc:'定位胆'
                                                }]}<?php if($zt[292]=="1" || $zt[293]=="1"){echo ",";}?>
									<?php }?>
									<?php if($zt[292]=="1" || $zt[293]=="1"){?>	
												{title:'大小单双',label:[<?php if($zt[292]=="1"){?>{methoddesc:'从百位、十位中的“大、小、单、双”中至少各选一个组成一注。',
methodhelp:'对百位和十位的“大（56789）小（01234）、单（13579）双（02468）”形态进行购买，所选号码的位置、形态与开奖号码的位置、形态相同，即为中奖。',
                                    selectarea:{
                                                type:'dxds',
                                                layout: [{title:'百位', no:'大|小|单|双', place:0, cols:1},
                                                         {title:'十位', no:'大|小|单|双', place:1, cols:1}]
                                              },
                                    show_str : 'X,X',
                                    code_sp : '',
                                                  methodid : 309,
                                                  name:'前二',
                                                  prize:{1:'<?=$rate[309][0]?>'},
                                                  dyprize:[{"level":1,"prize":[{"point":"<?=$rebate[292]/100?>","prize":<?=$rate[309][0]?>},{"point":0,"prize":<?=floor($rate[309][0]*(1+$rebate[292]/90)*10)/10?>}]}],
                                                  modes:[{modeid:1,name:'元',rate:1},{modeid:2,name:'角',rate:0.1},{modeid:3,name:'分',rate:0.01}],
                                                  desc:'前二大小单双'
                                                }<?php if($zt[293]=="1"){echo ",";}?><?php }?><?php if($zt[293]=="1"){?>{methoddesc:'从十位、个位中的“大、小、单、双”中至少各选一个组成一注。',
methodhelp:'对十位和个位的“大（56789）小（01234）、单（13579）双（02468）”形态进行购买，所选号码的位置、形态与开奖号码的位置、形态相同，即为中奖。',
                                    selectarea:{
                                                type:'dxds',
                                                layout: [{title:'十位', no:'大|小|单|双', place:0, cols:1},
                                                         {title:'个位', no:'大|小|单|双', place:1, cols:1}]
                                              },
                                    show_str : 'X,X',
                                    code_sp : '',
                                                  methodid : 310,
                                                  name:'后二',
                                                  prize:{1:'<?=$rate[310][0]?>'},
                                                  dyprize:[{"level":1,"prize":[{"point":"<?=$rebate[293]/100?>","prize":<?=$rate[310][0]?>},{"point":0,"prize":<?=floor($rate[310][0]*(1+$rebate[293]/90)*10)/10?>}]}],
                                                  modes:[{modeid:1,name:'元',rate:1},{modeid:2,name:'角',rate:0.1},{modeid:3,name:'分',rate:0.01}],
                                                  desc:'后二大小单双'
                                                }<?php }?>]}<?php }?>],
		cur_issue : {issue:'<?=$issue?>',endtime:'<?=$endtime?>',opentime:'<?=$opentime?>'},
		issues    : {//所有的可追号期数集合
                         today:[
                                {issue:'<?=$issue?>',endtime:'<?=$endtime?>'}								                               ],
                         tomorrow: [
                                                               ]
                     },
		servertime: '<?=date("Y-m-d H:i:s")?>',
		lotteryid : parseInt(9,10),
		isdynamic : 1,
		//onfinishbuy: function(){window.parent.abcd();},
		ajaxurl   : './play_fucai3d.php'
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
                                <h3>福彩3D</h3>
                                <p class="gct_now">正在销售 <strong>第 <span id="current_issue"><?=$issue?></span> 期</strong> 今日已开 <strong><span id="current_sale"><?=$salenums?></span></strong> 期 剩 <strong><span id="current_left"><?=$leftnums?></span></strong> 期</p>
                                <div class="clear"></div>
                                <div class="gct_time">
                                    <p class="gct_now">本期销售截止时间  <span class=nbox id="current_endtime"><?=$endtime?></span></p>
                                    <div class="clear"></div>
                                    <p class="gct_now gct_now1">剩余</p><div class="gct_time_now"><div class="gct_time_now_l"><span id="count_down">00:00:00</span></div></div>
                                </div>
                                <div class="gct_menu">
                                    <a class="gct_menu_yl" href='history_code.php?id=9' target="_blank"></a>                                </div>
                            </div>
                            <div class="gct_r">
                                <h3>福彩3D  第 <b> <span class=nn id="lt_gethistorycode"><?=$rowc['issue']?></span> </b> 期 
								<span id="lt_opentimebox" style="display:none;">&nbsp;&nbsp;<span id="waitopendesc">等待开奖</span>&nbsp;<span style="color:#F9CE46;" id="lt_opentimeleft" ></span></span><span id="lt_opentimebox2" style="display:none; color:#F9CE46;"><strong>&nbsp;&nbsp;正在开奖</strong></span></h3>
								
								<div style="display:none;" class="tad" id="showadvbox"><a href="promotion_center.php"><img src='images/v1/ad.jpg' border="0" /></a></div>
								
								<div class="gct_r_nub" id="showcodebox">
                                    <div class="gr_s " flag="normal"></div>
                                    <div class="gr_s " flag="normal"></div>
                                    <div class="gr_s gr_s<?=$rowc['n1']?>" name="historycode" flag="normal"></div>
                                    <div class="gr_s gr_s<?=$rowc['n2']?>" name="historycode" flag="normal"></div>
                                    <div class="gr_s gr_s<?=$rowc['n3']?>" name="historycode" flag="normal"></div>
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