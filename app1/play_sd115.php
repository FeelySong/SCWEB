<?php
session_start();
error_reporting(0);
require_once 'conn.php';
require_once 'check.php';

$flag=$_REQUEST['flag'];
$lotteryid="6";
$lottery="十一运夺金";

$sqls="select * from ssc_nums where cid='6' and endtime>='".date("H:i:s")."' order by id asc limit 1";
$rss=mysql_query($sqls) or  die("数据库修改出错1".mysql_error());
$nums=mysql_num_rows($rss);
$dymd=date("ymd");
$dymd2=date("Y-m-d");
if($nums==0){
	$sqls="select * from ssc_nums where cid='6' and endtime>='".date("H:i:s")."' order by id asc limit 1";
	$rss=mysql_query($sqls) or  die("数据库修改出错2".mysql_error());
	$dymd=date("ymd");
	$dymd2=date("Y-m-d");
}
$rows = mysql_fetch_array($rss);
$salenums=intval($rows['nums'])-1;
$leftnums=78-$salenums;
$issue=$dymd.substr($rows['nums'],1,2);
$opentime=$dymd2." ".$rows['opentime'];
$endtime=$dymd2." ".$rows['endtime'];

if($nums==0){
$signss=1;
}

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
	$sqla="select * from ssc_data where cid='6' and issue='".$_REQUEST['issue']."'";
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

	$sqlc="select * from ssc_data where cid='6' order by issue desc limit 1";
	$rsc=mysql_query($sqlc) or  die("数据库修改出错!!".mysql_error());
	$rowc = mysql_fetch_array($rsc);
	
	$sqld = "select * from ssc_class WHERE cid='6' order by id asc";
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
<HEAD><TITLE><?php echo $webname;?>  - 开始游戏[十一运夺金]</TITLE>
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
									<?php if($zt[181]=="1" || $zt[182]=="1"){?>
										{title:'三码',label:[<?php if($zt[181]=="1"){?>{methoddesc:'从第一位、第二位、第三位中至少各选择1个号码。',
methodhelp:'从01-11共11个号码中选择3个不重复的号码组成一注，所选号码与当期顺序摇出的5个号码中的前3个号码相同，且顺序一致，即为中奖。',
selectarea:{type:'digital',layout:[{title:'第一位', no:'01|02|03|04|05|06|07|08|09|10|11', place:0, cols:1},{title:'第二位', no:'01|02|03|04|05|06|07|08|09|10|11', place:1, cols:1},{title:'第三位', no:'01|02|03|04|05|06|07|08|09|10|11', place:2, cols:1}],noBigIndex:5,isButton:true},
show_str : 'X,X,X,-,-',
code_sp  : ' ',
                                                  methodid : 197,
                                                  name:'前三直选复式',
                                                  prize:{1:'<?=$rate[197][0]?>'},
                                                  dyprize:[{"level":1,"prize":[{"point":"<?=$rebate[181]/100?>","prize":<?=$rate[197][0]?>},{"point":0,"prize":<?=floor($rate[197][0]*(1+$rebate[181]/90)*10)/10?>}]}],
                                                  modes:[{modeid:1,name:'元',rate:1},{modeid:2,name:'角',rate:0.1},{modeid:3,name:'分',rate:0.01}],
                                                  desc:'前三直选复式'
                                                },{methoddesc:'手动输入号码，至少输入1个三位数号码组成一注。',
methodhelp:'手动输入3个号码组成一注，所输入的号码与当期顺序摇出的5个号码中的前3个号码相同，且顺序一致，即为中奖。',
selectarea:{type:'input'},
show_str : 'X',
code_sp : ';',
                                                  methodid : 197,
                                                  name:'前三直选单式',
                                                  prize:{1:'<?=$rate[197][0]?>'},
                                                  dyprize:[{"level":1,"prize":[{"point":"<?=$rebate[181]/100?>","prize":<?=$rate[197][0]?>},{"point":0,"prize":<?=floor($rate[197][0]*(1+$rebate[181]/90)*10)/10?>}]}],
                                                  modes:[{modeid:1,name:'元',rate:1},{modeid:2,name:'角',rate:0.1},{modeid:3,name:'分',rate:0.01}],
                                                  desc:'前三直选单式'
                                                }<?php if($zt[182]=="1"){echo ",";}?><?php }?><?php if($zt[182]=="1"){?>{methoddesc:'从0-9中任意选择3个或3个以上号码。',
methodhelp:'从01-11中共11个号码中选择3个号码，所选号码与当期顺序摇出的5个号码中的前3个号码相同，顺序不限，即为中奖。',
                                    selectarea:{
                                               type   : 'digital',
                                               layout : [
                                                           {title:'组选', no:'01|02|03|04|05|06|07|08|09|10|11', place:0, cols:1}
                                                          ],
                                               noBigIndex : 5,
                                               isButton   : true
                                              },
                                    show_str : 'X',
                                    code_sp : ',',
                                                  methodid : 198,
                                                  name:'前三组选复式',
                                                  prize:{1:'<?=$rate[198][0]?>'},
                                                  dyprize:[{"level":1,"prize":[{"point":"<?=$rebate[182]/100?>","prize":<?=$rate[198][0]?>},{"point":0,"prize":<?=floor($rate[198][0]*(1+$rebate[182]/90)*10)/10?>}]}],
                                                  modes:[{modeid:1,name:'元',rate:1},{modeid:2,name:'角',rate:0.1},{modeid:3,name:'分',rate:0.01}],
                                                  desc:'前三组选复式'
                                                },{methoddesc:'手动输入号码，至少输入1个三位数号码组成一注。',
methodhelp:'手动输入3个号码组成一注，所输入的号码与当期顺序摇出的5个号码中的前3个号码相同，顺序不限，即为中奖。',
                                    selectarea:{type:'input'},
                                    show_str : 'X',
                                    code_sp : ';',
                                                  methodid : 198,
                                                  name:'前三组选单式',
                                                  prize:{1:'<?=$rate[198][0]?>'},
                                                  dyprize:[{"level":1,"prize":[{"point":"<?=$rebate[182]/100?>","prize":<?=$rate[198][0]?>},{"point":0,"prize":<?=floor($rate[198][0]*(1+$rebate[182]/90)*10)/10?>}]}],
                                                  modes:[{modeid:1,name:'元',rate:1},{modeid:2,name:'角',rate:0.1},{modeid:3,name:'分',rate:0.01}],
                                                  desc:'前三组选单式'
                                                }<?php }?>]}<?php if($zt[183]=="1" || $zt[184]=="1" || $zt[185]=="1" || $zt[186]=="1" || $zt[187]=="1" || $zt[188]=="1" || $zt[189]=="1" || $zt[190]=="1" || $zt[191]=="1" || $zt[192]=="1" || $zt[193]=="1" || $zt[194]=="1" || $zt[195]=="1" || $zt[196]=="1"){echo ",";}?>
									<?php }?>
									<?php if($zt[183]=="1" || $zt[184]=="1"){?>												
												{title:'二码',label:[<?php if($zt[183]=="1"){?>{methoddesc:'从第一位、第二位中至少各选择1个号码。',
methodhelp:'从01-11共11个号码中选择2个不重复的号码组成一注，所选号码与当期顺序摇出的5个号码中的前2个号码相同，且顺序一致，即中奖。',
selectarea:{type:'digital',layout:[{title:'第一位', no:'01|02|03|04|05|06|07|08|09|10|11', place:0, cols:1},{title:'第二位', no:'01|02|03|04|05|06|07|08|09|10|11', place:1, cols:1}],noBigIndex:5,isButton:true},
show_str : 'X,X,-,-,-',
code_sp  : ' ',
                                                  methodid : 199,
                                                  name:'前二直选复式',
                                                  prize:{1:'<?=$rate[199][0]?>'},
                                                  dyprize:[{"level":1,"prize":[{"point":"<?=$rebate[183]/100?>","prize":<?=$rate[199][0]?>},{"point":0,"prize":<?=floor($rate[199][0]*(1+$rebate[183]/90)*10)/10?>}]}],
                                                  modes:[{modeid:1,name:'元',rate:1},{modeid:2,name:'角',rate:0.1},{modeid:3,name:'分',rate:0.01}],
                                                  desc:'前二直选复式'
                                                },{methoddesc:'手动输入号码，至少输入1个两位数号码组成一注。',
methodhelp:'手动输入2个号码组成一注，所输入的号码与当期顺序摇出的5个号码中的前2个号码相同，且顺序一致，即为中奖。',
selectarea:{type:'input'},
show_str : 'X',
code_sp : ';',
                                                  methodid : 199,
                                                  name:'前二直选单式',
                                                  prize:{1:'<?=$rate[199][0]?>'},
                                                  dyprize:[{"level":1,"prize":[{"point":"<?=$rebate[183]/100?>","prize":<?=$rate[199][0]?>},{"point":0,"prize":<?=floor($rate[199][0]*(1+$rebate[183]/90)*10)/10?>}]}],
                                                  modes:[{modeid:1,name:'元',rate:1},{modeid:2,name:'角',rate:0.1},{modeid:3,name:'分',rate:0.01}],
                                                  desc:'前二直选单式'
                                                }<?php if($zt[184]=="1"){echo ",";}?><?php }?><?php if($zt[184]=="1"){?>{methoddesc:'从0-9中任意选择2个或2个以上号码。',
methodhelp:'从01-11中共11个号码中选择2个号码，所选号码与当期顺序摇出的5个号码中的前2个号码相同，顺序不限，即为中奖。',
                                    selectarea:{
                                               type   : 'digital',
                                               layout : [
                                                           {title:'组选', no:'01|02|03|04|05|06|07|08|09|10|11', place:0, cols:1}
                                                          ],
                                               noBigIndex : 5,
                                               isButton   : true
                                              },
                                    show_str : 'X',
                                    code_sp : ',',
                                                  methodid : 200,
                                                  name:'前二组选复式',
                                                  prize:{1:'<?=$rate[200][0]?>'},
                                                  dyprize:[{"level":1,"prize":[{"point":"<?=$rebate[184]/100?>","prize":<?=$rate[200][0]?>},{"point":0,"prize":<?=floor($rate[200][0]*(1+$rebate[184]/90)*10)/10?>}]}],
                                                  modes:[{modeid:1,name:'元',rate:1},{modeid:2,name:'角',rate:0.1},{modeid:3,name:'分',rate:0.01}],
                                                  desc:'前二组选复式'
                                                },{methoddesc:'手动输入号码，至少输入1个两位数号码组成一注。',
methodhelp:'手动输入2个号码组成一注，所输入的号码与当期顺序摇出的5个号码中的前2个号码相同，顺序不限，即为中奖。',
selectarea:{type:'input'},
show_str : 'X',
code_sp : ';',
                                                  methodid : 200,
                                                  name:'前二组选单式',
                                                  prize:{1:'<?=$rate[200][0]?>'},
                                                  dyprize:[{"level":1,"prize":[{"point":"<?=$rebate[184]/100?>","prize":<?=$rate[200][0]?>},{"point":0,"prize":<?=floor($rate[200][0]*(1+$rebate[184]/90)*10)/10?>}]}],
                                                  modes:[{modeid:1,name:'元',rate:1},{modeid:2,name:'角',rate:0.1},{modeid:3,name:'分',rate:0.01}],
                                                  desc:'前二组选单式'
                                                }<?php }?>]}<?php if($zt[185]=="1" || $zt[186]=="1" || $zt[187]=="1" || $zt[188]=="1" || $zt[189]=="1" || $zt[190]=="1" || $zt[191]=="1" || $zt[192]=="1" || $zt[193]=="1" || $zt[194]=="1" || $zt[195]=="1" || $zt[196]=="1"){echo ",";}?>
									<?php }?>
									<?php if($zt[185]=="1"){?>
												{title:'不定位',label:[{methoddesc:'从01-11中任意选择1个或1个以上号码。',
methodhelp:'从01-11中共11个号码中选择1个号码，每注由1个号码组成，只要当期顺序摇出的第一位、第二位、第三位开奖号码中包含所选号码，即为中奖。',
                                    selectarea:{
                                               type   : 'digital',
                                               layout : [
                                                           {title:'不定位', no:'01|02|03|04|05|06|07|08|09|10|11', place:0, cols:1}
                                                          ],
                                               noBigIndex : 5,
                                               isButton   : true
                                              },
                                    show_str : 'X',
                                    code_sp : ',',
                                                  methodid : 201,
                                                  name:'不定位',
                                                  prize:{1:'<?=$rate[201][0]?>'},
                                                  dyprize:[{"level":1,"prize":[{"point":"<?=$rebate[185]/100?>","prize":<?=$rate[201][0]?>},{"point":0,"prize":<?=floor($rate[201][0]*(1+$rebate[185]/90)*10)/10?>}]}],
                                                  modes:[{modeid:1,name:'元',rate:1},{modeid:2,name:'角',rate:0.1},{modeid:3,name:'分',rate:0.01}],
                                                  desc:'前三不定位'
                                                }]}<?php if($zt[186]=="1" || $zt[187]=="1" || $zt[188]=="1" || $zt[189]=="1" || $zt[190]=="1" || $zt[191]=="1" || $zt[192]=="1" || $zt[193]=="1" || $zt[194]=="1" || $zt[195]=="1" || $zt[196]=="1"){echo ",";}?>
									<?php }?>
									<?php if($zt[186]=="1"){?>												
												{title:'定位胆',label:[{methoddesc:'从第一位，第二位，第三位任意位置上任意选择1个或1个以上号码。',
methodhelp:'从第一位，第二位，第三位任意1个位置或多个位置上选择1个号码，所选号码与相同位置上的开奖号码一致，即为中奖。',
                                    selectarea:{
                                               type   : 'digital',
                                               layout : [
                                                           {title:'第一位', no:'01|02|03|04|05|06|07|08|09|10|11', place:0, cols:1},
                                                           {title:'第二位', no:'01|02|03|04|05|06|07|08|09|10|11', place:1, cols:1},
                                                           {title:'第三位', no:'01|02|03|04|05|06|07|08|09|10|11', place:2, cols:1}
                                                          ],
                                               noBigIndex : 5,
                                               isButton   : true
                                              },
                                    show_str : 'X,X,X,-,-',
                                    code_sp : ' ',
                                                  methodid : 202,
                                                  name:'定位胆',
                                                  prize:{1:'<?=$rate[202][0]?>'},
                                                  dyprize:[{"level":1,"prize":[{"point":"<?=$rebate[186]/100?>","prize":<?=$rate[202][0]?>},{"point":0,"prize":<?=floor($rate[202][0]*(1+$rebate[186]/90)*10)/10?>}]}],
                                                  modes:[{modeid:1,name:'元',rate:1},{modeid:2,name:'角',rate:0.1},{modeid:3,name:'分',rate:0.01}],
                                                  desc:'定位胆'
                                                }]}<?php if($zt[187]=="1" || $zt[188]=="1" || $zt[189]=="1" || $zt[190]=="1" || $zt[191]=="1" || $zt[192]=="1" || $zt[193]=="1" || $zt[194]=="1" || $zt[195]=="1" || $zt[196]=="1"){echo ",";}?>
									<?php }?>
									<?php if($zt[187]=="1" || $zt[188]=="1"){?>
												{title:'趣味型',label:[<?php if($zt[187]=="1"){?>{methoddesc:'从不同的单双组合中任意选择1个或1个以上的组合。',
methodhelp:'从5种单双个数组合中选择1种组合，当期开奖号码的单双个数与所选单双组合一致，即为中奖。',
                                    selectarea:{
                                                type:'dds',
                                                layout: [{title:'', no:'5单0双|4单1双|3单2双|2单3双|1单4双|0单5双', place:0, cols:0}]
                                              },
                                    show_str : 'X',
                                    code_sp : '|',
                                                  methodid : 205,
                                                  name:'定单双',
                                                  prize:{1:'<?=$rate[205][0]?>',2:'<?=$rate[205][1]?>',3:'<?=$rate[205][2]?>',4:'<?=$rate[205][3]?>',5:'<?=$rate[205][4]?>',6:'<?=$rate[205][5]?>'},
                                                  dyprize:[{"level":1,"prize":[{"point":"<?=$rebate[187]/100?>","prize":<?=$rate[205][0]?>},{"point":0,"prize":<?=floor($rate[205][0]*(1+$rebate[187]/90)*10)/10?>}]},{"level":2,"prize":[{"point":"<?=$rebate[187]/100?>","prize":<?=$rate[205][0]?>},{"point":0,"prize":<?=floor($rate[205][0]*(1+$rebate[187]/90)*10)/10?>},{"point":"<?=$rebate[187]/100?>","prize":<?=$rate[205][1]?>},{"point":0,"prize":<?=floor($rate[205][1]*(1+$rebate[187]/90)*10)/10?>}]},{"level":3,"prize":[{"point":"<?=$rebate[187]/100?>","prize":<?=$rate[205][0]?>},{"point":0,"prize":<?=floor($rate[205][0]*(1+$rebate[187]/90)*10)/10?>},{"point":"<?=$rebate[187]/100?>","prize":<?=$rate[205][1]?>},{"point":0,"prize":<?=floor($rate[205][1]*(1+$rebate[187]/90)*10)/10?>},{"point":"<?=$rebate[187]/100?>","prize":<?=$rate[205][2]?>},{"point":0,"prize":<?=floor($rate[205][2]*(1+$rebate[187]/90)*10)/10?>}]},{"level":4,"prize":[{"point":"<?=$rebate[187]/100?>","prize":<?=$rate[205][0]?>},{"point":0,"prize":<?=floor($rate[205][0]*(1+$rebate[187]/90)*10)/10?>},{"point":"<?=$rebate[187]/100?>","prize":<?=$rate[205][1]?>},{"point":0,"prize":<?=floor($rate[205][1]*(1+$rebate[187]/90)*10)/10?>},{"point":"<?=$rebate[187]/100?>","prize":<?=$rate[205][2]?>},{"point":0,"prize":<?=floor($rate[205][2]*(1+$rebate[187]/90)*10)/10?>},{"point":"<?=$rebate[187]/100?>","prize":<?=$rate[205][3]?>},{"point":0,"prize":<?=floor($rate[205][3]*(1+$rebate[187]/90)*10)/10?>}]},{"level":5,"prize":[{"point":"<?=$rebate[187]/100?>","prize":<?=$rate[205][0]?>},{"point":0,"prize":<?=floor($rate[205][0]*(1+$rebate[187]/90)*10)/10?>},{"point":"<?=$rebate[187]/100?>","prize":<?=$rate[205][1]?>},{"point":0,"prize":<?=floor($rate[205][1]*(1+$rebate[187]/90)*10)/10?>},{"point":"<?=$rebate[187]/100?>","prize":<?=$rate[205][2]?>},{"point":0,"prize":<?=floor($rate[205][2]*(1+$rebate[187]/90)*10)/10?>},{"point":"<?=$rebate[187]/100?>","prize":<?=$rate[205][3]?>},{"point":0,"prize":<?=floor($rate[205][3]*(1+$rebate[187]/90)*10)/10?>},{"point":"<?=$rebate[187]/100?>","prize":<?=$rate[205][4]?>},{"point":0,"prize":<?=floor($rate[205][4]*(1+$rebate[187]/90)*10)/10?>}]},{"level":6,"prize":[{"point":"<?=$rebate[187]/100?>","prize":<?=$rate[205][0]?>},{"point":0,"prize":<?=floor($rate[205][0]*(1+$rebate[187]/90)*10)/10?>},{"point":"<?=$rebate[187]/100?>","prize":<?=$rate[205][1]?>},{"point":0,"prize":<?=floor($rate[205][1]*(1+$rebate[187]/90)*10)/10?>},{"point":"<?=$rebate[187]/100?>","prize":<?=$rate[205][2]?>},{"point":0,"prize":<?=floor($rate[205][2]*(1+$rebate[187]/90)*10)/10?>},{"point":"<?=$rebate[187]/100?>","prize":<?=$rate[205][3]?>},{"point":0,"prize":<?=floor($rate[205][3]*(1+$rebate[187]/90)*10)/10?>},{"point":"<?=$rebate[187]/100?>","prize":<?=$rate[205][4]?>},{"point":0,"prize":<?=floor($rate[205][4]*(1+$rebate[187]/90)*10)/10?>},{"point":"<?=$rebate[187]/100?>","prize":<?=$rate[205][5]?>},{"point":0,"prize":<?=floor($rate[205][5]*(1+$rebate[187]/90)*10)/10?>}]}],
                                                  modes:[{modeid:1,name:'元',rate:1},{modeid:2,name:'角',rate:0.1},{modeid:3,name:'分',rate:0.01}],
                                                  desc:'定单双'
                                                }<?php if($zt[188]=="1"){echo ",";}?><?php }?><?php if($zt[188]=="1"){?>{methoddesc:'从3-9中任意选择1个或1个以上数字。',
methodhelp:'从3-9中选择1个号码进行购买，所选号码与5个开奖号码按照大小顺序排列后的第3个号码相同，即为中奖。',
                                    selectarea:{
                                               type   : 'digital',
                                               layout : [
                                                           {title:'猜中位', no:'3|4|5|6|7|8|9', place:0, cols:1}
                                                          ],
                                               noBigIndex : 3,
                                               isButton   : true
                                              },
                                    show_str : 'X',
                                    code_sp : ',',
                                                  methodid : 206,
                                                  name:'猜中位',
                                                  prize:{1:'<?=$rate[206][0]?>',2:'<?=$rate[206][1]?>',3:'<?=$rate[206][2]?>',4:'<?=$rate[206][3]?>'},
                                                  dyprize:[{"level":1,"prize":[{"point":"<?=$rebate[188]/100?>","prize":<?=$rate[206][0]?>},{"point":0,"prize":<?=floor($rate[206][0]*(1+$rebate[188]/90)*10)/10?>}]},{"level":2,"prize":[{"point":"<?=$rebate[188]/100?>","prize":<?=$rate[206][0]?>},{"point":0,"prize":<?=floor($rate[206][0]*(1+$rebate[188]/90)*10)/10?>},{"point":"<?=$rebate[188]/100?>","prize":<?=$rate[206][1]?>},{"point":0,"prize":<?=floor($rate[206][1]*(1+$rebate[188]/90)*10)/10?>}]},{"level":3,"prize":[{"point":"<?=$rebate[188]/100?>","prize":<?=$rate[206][0]?>},{"point":0,"prize":<?=floor($rate[206][0]*(1+$rebate[188]/90)*10)/10?>},{"point":"<?=$rebate[188]/100?>","prize":<?=$rate[206][1]?>},{"point":0,"prize":<?=floor($rate[206][1]*(1+$rebate[188]/90)*10)/10?>},{"point":"<?=$rebate[188]/100?>","prize":<?=$rate[206][2]?>},{"point":0,"prize":<?=floor($rate[206][2]*(1+$rebate[188]/90)*10)/10?>}]},{"level":4,"prize":[{"point":"<?=$rebate[188]/100?>","prize":<?=$rate[206][0]?>},{"point":0,"prize":<?=floor($rate[206][0]*(1+$rebate[188]/90)*10)/10?>},{"point":"<?=$rebate[188]/100?>","prize":<?=$rate[206][1]?>},{"point":0,"prize":<?=floor($rate[206][1]*(1+$rebate[188]/90)*10)/10?>},{"point":"<?=$rebate[188]/100?>","prize":<?=$rate[206][2]?>},{"point":0,"prize":<?=floor($rate[206][2]*(1+$rebate[188]/90)*10)/10?>},{"point":"<?=$rebate[188]/100?>","prize":<?=$rate[206][3]?>},{"point":0,"prize":<?=floor($rate[206][3]*(1+$rebate[188]/90)*10)/10?>}]}],
                                                  modes:[{modeid:1,name:'元',rate:1},{modeid:2,name:'角',rate:0.1},{modeid:3,name:'分',rate:0.01}],
                                                  desc:'猜中位'
                                                }<?php }?>]}<?php if($zt[189]=="1" || $zt[190]=="1" || $zt[191]=="1" || $zt[192]=="1" || $zt[193]=="1" || $zt[194]=="1" || $zt[195]=="1" || $zt[196]=="1"){echo ",";}?>
									<?php }?>
									<?php if($zt[189]=="1" || $zt[190]=="1" || $zt[191]=="1" || $zt[192]=="1" || $zt[193]=="1" || $zt[194]=="1" || $zt[195]=="1" || $zt[196]=="1"){?>
												{title:'任选复式',label:[<?php if($zt[189]=="1"){?>{methoddesc:'从01-11中任意选择1个或1个以上号码。',
methodhelp:'从01-11共11个号码中选择1个号码进行购买，只要当期顺序摇出的5个开奖号码中包含所选号码，即为中奖。',
                                    selectarea:{
                                               type   : 'digital',
                                               layout : [
                                                           {title:'选一', no:'01|02|03|04|05|06|07|08|09|10|11', place:0, cols:1}
                                                          ],
                                               noBigIndex : 5,
                                               isButton   : true
                                              },
                                    show_str : 'X',
                                    code_sp : ',',
                                                  methodid : 207,
                                                  name:'任选一中一',
                                                  prize:{1:'<?=$rate[207][0]?>'},
                                                  dyprize:[{"level":1,"prize":[{"point":"<?=$rebate[189]/100?>","prize":<?=$rate[207][0]?>},{"point":0,"prize":<?=floor($rate[207][0]*(1+$rebate[189]/90)*10)/10?>}]}],
                                                  modes:[{modeid:1,name:'元',rate:1},{modeid:2,name:'角',rate:0.1},{modeid:3,name:'分',rate:0.01}],
                                                  desc:'任选一中一'
                                                }<?php if($zt[190]=="1" || $zt[191]=="1" || $zt[192]=="1" || $zt[193]=="1" || $zt[194]=="1" || $zt[195]=="1" || $zt[196]=="1"){echo ",";}?><?php }?><?php if($zt[190]=="1"){?>{methoddesc:'从01-11中任意选择2个或2个以上号码。',
methodhelp:'从01-11共11个号码中选择2个号码进行购买，只要当期顺序摇出的5个开奖号码中包含所选号码，即为中奖。',
                                    selectarea:{
                                               type   : 'digital',
                                               layout : [
                                                           {title:'选二', no:'01|02|03|04|05|06|07|08|09|10|11', place:0, cols:1}
                                                          ],
                                               noBigIndex : 5,
                                               isButton   : true
                                              },
                                    show_str : 'X',
                                    code_sp : ',',
                                                  methodid : 208,
                                                  name:'任选二中二',
                                                  prize:{1:'<?=$rate[208][0]?>'},
                                                  dyprize:[{"level":1,"prize":[{"point":"<?=$rebate[190]/100?>","prize":<?=$rate[208][0]?>},{"point":0,"prize":<?=floor($rate[208][0]*(1+$rebate[190]/90)*10)/10?>}]}],
                                                  modes:[{modeid:1,name:'元',rate:1},{modeid:2,name:'角',rate:0.1},{modeid:3,name:'分',rate:0.01}],
                                                  desc:'任选二中二'
                                                }<?php if($zt[191]=="1" || $zt[192]=="1" || $zt[193]=="1" || $zt[194]=="1" || $zt[195]=="1" || $zt[196]=="1"){echo ",";}?><?php }?><?php if($zt[191]=="1"){?>{methoddesc:'从01-11中任意选择3个或3个以上号码。',
methodhelp:'从01-11共11个号码中选择3个号码进行购买，只要当期顺序摇出的5个开奖号码中包含所选号码，即为中奖。',
                                    selectarea:{
                                               type   : 'digital',
                                               layout : [
                                                           {title:'选三', no:'01|02|03|04|05|06|07|08|09|10|11', place:0, cols:1}
                                                          ],
                                               noBigIndex : 5,
                                               isButton   : true
                                              },
                                    show_str : 'X',
                                    code_sp : ',',
                                                  methodid : 209,
                                                  name:'任选三中三',
                                                  prize:{1:'<?=$rate[209][0]?>'},
                                                  dyprize:[{"level":1,"prize":[{"point":"<?=$rebate[191]/100?>","prize":<?=$rate[209][0]?>},{"point":0,"prize":<?=floor($rate[209][0]*(1+$rebate[191]/90)*10)/10?>}]}],
                                                  modes:[{modeid:1,name:'元',rate:1},{modeid:2,name:'角',rate:0.1},{modeid:3,name:'分',rate:0.01}],
                                                  desc:'任选三中三'
                                                }<?php if($zt[192]=="1" || $zt[193]=="1" || $zt[194]=="1" || $zt[195]=="1" || $zt[196]=="1"){echo ",";}?><?php }?><?php if($zt[192]=="1"){?>{methoddesc:'从01-11中任意选择4个或4个以上号码。',
methodhelp:'从01-11共11个号码中选择4个号码进行购买，只要当期顺序摇出的5个开奖号码中包含所选号码，即为中奖。',
                                    selectarea:{
                                               type   : 'digital',
                                               layout : [
                                                           {title:'选四', no:'01|02|03|04|05|06|07|08|09|10|11', place:0, cols:1}
                                                          ],
                                               noBigIndex : 5,
                                               isButton   : true
                                              },
                                    show_str : 'X',
                                    code_sp : ',',
                                                  methodid : 210,
                                                  name:'任选四中四',
                                                  prize:{1:'<?=$rate[210][0]?>'},
                                                  dyprize:[{"level":1,"prize":[{"point":"<?=$rebate[192]/100?>","prize":<?=$rate[210][0]?>},{"point":0,"prize":<?=floor($rate[210][0]*(1+$rebate[192]/90)*10)/10?>}]}],
                                                  modes:[{modeid:1,name:'元',rate:1},{modeid:2,name:'角',rate:0.1},{modeid:3,name:'分',rate:0.01}],
                                                  desc:'任选四中四'
                                                }<?php if($zt[193]=="1" || $zt[194]=="1" || $zt[195]=="1" || $zt[196]=="1"){echo ",";}?><?php }?><?php if($zt[193]=="1"){?>{methoddesc:'从01-11中任意选择5个或5个以上号码。',
methodhelp:'从01-11共11个号码中选择5个号码进行购买，只要当期顺序摇出的5个开奖号码中包含所选号码，即为中奖。',
                                    selectarea:{
                                               type   : 'digital',
                                               layout : [
                                                           {title:'选五', no:'01|02|03|04|05|06|07|08|09|10|11', place:0, cols:1}
                                                          ],
                                               noBigIndex : 5,
                                               isButton   : true
                                              },
                                    show_str : 'X',
                                    code_sp : ',',
                                                  methodid : 211,
                                                  name:'任选五中五',
                                                  prize:{1:'<?=$rate[211][0]?>'},
                                                  dyprize:[{"level":1,"prize":[{"point":"<?=$rebate[193]/100?>","prize":<?=$rate[211][0]?>},{"point":0,"prize":<?=floor($rate[211][0]*(1+$rebate[193]/90)*10)/10?>}]}],
                                                  modes:[{modeid:1,name:'元',rate:1},{modeid:2,name:'角',rate:0.1},{modeid:3,name:'分',rate:0.01}],
                                                  desc:'任选五中五'
                                                }<?php if($zt[194]=="1" || $zt[195]=="1" || $zt[196]=="1"){echo ",";}?><?php }?><?php if($zt[194]=="1"){?>{methoddesc:'从01-11中任意选择6个或6个以上号码。',
methodhelp:'从01-11共11个号码中选择6个号码进行购买，只要当期顺序摇出的5个开奖号码中包含所选号码，即为中奖。',
                                    selectarea:{
                                               type   : 'digital',
                                               layout : [
                                                           {title:'选六', no:'01|02|03|04|05|06|07|08|09|10|11', place:0, cols:1}
                                                          ],
                                               noBigIndex : 5,
                                               isButton   : true
                                              },
                                    show_str : 'X',
                                    code_sp : ',',
                                                  methodid : 212,
                                                  name:'任选六中五',
                                                  prize:{1:'<?=$rate[212][0]?>'},
                                                  dyprize:[{"level":1,"prize":[{"point":"<?=$rebate[194]/100?>","prize":<?=$rate[212][0]?>},{"point":0,"prize":<?=floor($rate[212][0]*(1+$rebate[194]/90)*10)/10?>}]}],
                                                  modes:[{modeid:1,name:'元',rate:1},{modeid:2,name:'角',rate:0.1},{modeid:3,name:'分',rate:0.01}],
                                                  desc:'任选六中五'
                                                }<?php if($zt[195]=="1" || $zt[196]=="1"){echo ",";}?><?php }?><?php if($zt[195]=="1"){?>{methoddesc:'从01-11中任意选择7个或7个以上号码。',
methodhelp:'从01-11共11个号码中选择7个号码进行购买，只要当期顺序摇出的5个开奖号码中包含所选号码，即为中奖。',
                                    selectarea:{
                                               type   : 'digital',
                                               layout : [
                                                           {title:'选七', no:'01|02|03|04|05|06|07|08|09|10|11', place:0, cols:1}
                                                          ],
                                               noBigIndex : 5,
                                               isButton   : true
                                              },
                                    show_str : 'X',
                                    code_sp : ',',
                                                  methodid : 213,
                                                  name:'任选七中五',
                                                  prize:{1:'<?=$rate[213][0]?>'},
                                                  dyprize:[{"level":1,"prize":[{"point":"<?=$rebate[195]/100?>","prize":<?=$rate[213][0]?>},{"point":0,"prize":<?=floor($rate[213][0]*(1+$rebate[195]/90)*10)/10?>}]}],
                                                  modes:[{modeid:1,name:'元',rate:1},{modeid:2,name:'角',rate:0.1},{modeid:3,name:'分',rate:0.01}],
                                                  desc:'任选七中五'
                                                }<?php if($zt[196]=="1"){echo ",";}?><?php }?><?php if($zt[196]=="1"){?>{methoddesc:'从01-11中任意选择8个或8个以上号码。',
methodhelp:'从01-11共11个号码中选择8个号码进行购买，只要当期顺序摇出的5个开奖号码中包含所选号码，即为中奖。',
                                    selectarea:{
                                               type   : 'digital',
                                               layout : [
                                                           {title:'选八', no:'01|02|03|04|05|06|07|08|09|10|11', place:0, cols:1}
                                                          ],
                                               noBigIndex : 5,
                                               isButton   : true
                                              },
                                    show_str : 'X',
                                    code_sp : ',',
                                                  methodid : 214,
                                                  name:'任选八中五',
                                                  prize:{1:'<?=$rate[214][0]?>'},
                                                  dyprize:[{"level":1,"prize":[{"point":"<?=$rebate[196]/100?>","prize":<?=$rate[214][0]?>},{"point":0,"prize":<?=floor($rate[214][0]*(1+$rebate[196]/90)*10)/10?>}]}],
                                                  modes:[{modeid:1,name:'元',rate:1},{modeid:2,name:'角',rate:0.1},{modeid:3,name:'分',rate:0.01}],
                                                  desc:'任选八中五'
                                                }<?php }?>]}<?php if($zt[189]=="1" || $zt[190]=="1" || $zt[191]=="1" || $zt[192]=="1" || $zt[193]=="1" || $zt[194]=="1" || $zt[195]=="1" || $zt[196]=="1"){echo ",";}?>
									<?php }?>
									<?php if($zt[189]=="1" || $zt[190]=="1" || $zt[191]=="1" || $zt[192]=="1" || $zt[193]=="1" || $zt[194]=="1" || $zt[195]=="1" || $zt[196]=="1"){?>
												{title:'任选单式',label:[<?php if($zt[189]=="1"){?>{methoddesc:'手动输入号码，从01-11中任意输入1个号码组成一注。',
methodhelp:'从01-11中手动输入1个号码进行购买，只要当期顺序摇出的5个开奖号码中包含所输入号码，即为中奖。',
selectarea:{type:'input'},
show_str : 'X',
code_sp : ';',
                                                  methodid : 207,
                                                  name:'任选一中一',
                                                  prize:{1:'<?=$rate[207][0]?>'},
                                                  dyprize:[{"level":1,"prize":[{"point":"<?=$rebate[189]/100?>","prize":<?=$rate[207][0]?>},{"point":0,"prize":<?=floor($rate[207][0]*(1+$rebate[189]/90)*10)/10?>}]}],
                                                  modes:[{modeid:1,name:'元',rate:1},{modeid:2,name:'角',rate:0.1},{modeid:3,name:'分',rate:0.01}],
                                                  desc:'任选一中一'
                                                }<?php if($zt[190]=="1" || $zt[191]=="1" || $zt[192]=="1" || $zt[193]=="1" || $zt[194]=="1" || $zt[195]=="1" || $zt[196]=="1"){echo ",";}?><?php }?><?php if($zt[190]=="1"){?>{methoddesc:'手动输入号码，从01-11中任意输入2个号码组成一注。',
methodhelp:'从01-11中手动输入2个号码进行购买，只要当期顺序摇出的5个开奖号码中包含所输入号码，即为中奖。',
selectarea:{type:'input'},
show_str : 'X',
code_sp : ';',
                                                  methodid : 208,
                                                  name:'任选二中二',
                                                  prize:{1:'<?=$rate[208][0]?>'},
                                                  dyprize:[{"level":1,"prize":[{"point":"<?=$rebate[190]/100?>","prize":<?=$rate[208][0]?>},{"point":0,"prize":<?=floor($rate[208][0]*(1+$rebate[190]/90)*10)/10?>}]}],
                                                  modes:[{modeid:1,name:'元',rate:1},{modeid:2,name:'角',rate:0.1},{modeid:3,name:'分',rate:0.01}],
                                                  desc:'任选二中二'
                                                }<?php if($zt[191]=="1" || $zt[192]=="1" || $zt[193]=="1" || $zt[194]=="1" || $zt[195]=="1" || $zt[196]=="1"){echo ",";}?><?php }?><?php if($zt[191]=="1"){?>{methoddesc:'手动输入号码，从01-11中任意输入3个号码组成一注。',
methodhelp:'从01-11中手动输入3个号码进行购买，只要当期顺序摇出的5个开奖号码中包含所输入号码，即为中奖。',
selectarea:{type:'input'},
show_str : 'X',
code_sp : ';',
                                                  methodid : 209,
                                                  name:'任选三中三',
                                                  prize:{1:'<?=$rate[209][0]?>'},
                                                  dyprize:[{"level":1,"prize":[{"point":"<?=$rebate[191]/100?>","prize":<?=$rate[209][0]?>},{"point":0,"prize":<?=floor($rate[209][0]*(1+$rebate[191]/90)*10)/10?>}]}],
                                                  modes:[{modeid:1,name:'元',rate:1},{modeid:2,name:'角',rate:0.1},{modeid:3,name:'分',rate:0.01}],
                                                  desc:'任选三中三'
                                                }<?php if($zt[192]=="1" || $zt[193]=="1" || $zt[194]=="1" || $zt[195]=="1" || $zt[196]=="1"){echo ",";}?><?php }?><?php if($zt[192]=="1"){?>{methoddesc:'手动输入号码，从01-11中任意输入4个号码组成一注。',
methodhelp:'从01-11中手动输入4个号码进行购买，只要当期顺序摇出的5个开奖号码中包含所输入号码，即为中奖。',
selectarea:{type:'input'},
show_str : 'X',
code_sp : ';',
                                                  methodid : 210,
                                                  name:'任选四中四',
                                                  prize:{1:'<?=$rate[210][0]?>'},
                                                  dyprize:[{"level":1,"prize":[{"point":"<?=$rebate[192]/100?>","prize":<?=$rate[210][0]?>},{"point":0,"prize":<?=floor($rate[210][0]*(1+$rebate[192]/90)*10)/10?>}]}],
                                                  modes:[{modeid:1,name:'元',rate:1},{modeid:2,name:'角',rate:0.1},{modeid:3,name:'分',rate:0.01}],
                                                  desc:'任选四中四'
                                                }<?php if($zt[193]=="1" || $zt[194]=="1" || $zt[195]=="1" || $zt[196]=="1"){echo ",";}?><?php }?><?php if($zt[193]=="1"){?>{methoddesc:'手动输入号码，从01-11中任意输入5个号码组成一注。',
methodhelp:'从01-11中手动输入5个号码进行购买，只要当期顺序摇出的5个开奖号码中包含所输入号码，即为中奖。',
selectarea:{type:'input'},
show_str : 'X',
code_sp : ';',
                                                  methodid : 211,
                                                  name:'任选五中五',
                                                  prize:{1:'<?=$rate[211][0]?>'},
                                                  dyprize:[{"level":1,"prize":[{"point":"<?=$rebate[193]/100?>","prize":<?=$rate[211][0]?>},{"point":0,"prize":<?=floor($rate[211][0]*(1+$rebate[193]/90)*10)/10?>}]}],
                                                  modes:[{modeid:1,name:'元',rate:1},{modeid:2,name:'角',rate:0.1},{modeid:3,name:'分',rate:0.01}],
                                                  desc:'任选五中五'
                                                }<?php if($zt[194]=="1" || $zt[195]=="1" || $zt[196]=="1"){echo ",";}?><?php }?><?php if($zt[194]=="1"){?>{methoddesc:'手动输入号码，从01-11中任意输入6个号码组成一注。',
methodhelp:'从01-11中手动输入6个号码进行购买，只要当期顺序摇出的5个开奖号码中包含所输入号码，即为中奖。',
selectarea:{type:'input'},
show_str : 'X',
code_sp : ';',
                                                  methodid : 212,
                                                  name:'任选六中五',
                                                  prize:{1:'<?=$rate[212][0]?>'},
                                                  dyprize:[{"level":1,"prize":[{"point":"<?=$rebate[194]/100?>","prize":<?=$rate[212][0]?>},{"point":0,"prize":<?=floor($rate[212][0]*(1+$rebate[194]/90)*10)/10?>}]}],
                                                  modes:[{modeid:1,name:'元',rate:1},{modeid:2,name:'角',rate:0.1},{modeid:3,name:'分',rate:0.01}],
                                                  desc:'任选六中五'
                                                }<?php if($zt[195]=="1" || $zt[196]=="1"){echo ",";}?><?php }?><?php if($zt[195]=="1"){?>{methoddesc:'手动输入号码，从01-11中任意输入7个号码组成一注。',
methodhelp:'从01-11中手动输入7个号码进行购买，只要当期顺序摇出的5个开奖号码中包含所输入号码，即为中奖。',
selectarea:{type:'input'},
show_str : 'X',
code_sp : ';',
                                                  methodid : 213,
                                                  name:'任选七中五',
                                                  prize:{1:'<?=$rate[213][0]?>'},
                                                  dyprize:[{"level":1,"prize":[{"point":"<?=$rebate[195]/100?>","prize":<?=$rate[213][0]?>},{"point":0,"prize":<?=floor($rate[213][0]*(1+$rebate[195]/90)*10)/10?>}]}],
                                                  modes:[{modeid:1,name:'元',rate:1},{modeid:2,name:'角',rate:0.1},{modeid:3,name:'分',rate:0.01}],
                                                  desc:'任选七中五'
                                                }<?php if($zt[196]=="1"){echo ",";}?><?php }?><?php if($zt[196]=="1"){?>{methoddesc:'手动输入号码，从01-11中任意输入8个号码组成一注。',
methodhelp:'从01-11中手动输入8个号码进行购买，只要当期顺序摇出的5个开奖号码中包含所输入号码，即为中奖。',
selectarea:{type:'input'},
show_str : 'X',
code_sp : ';',
                                                  methodid : 214,
                                                  name:'任选八中五',
                                                  prize:{1:'<?=$rate[214][0]?>'},
                                                  dyprize:[{"level":1,"prize":[{"point":"<?=$rebate[196]/100?>","prize":<?=$rate[214][0]?>},{"point":0,"prize":<?=floor($rate[214][0]*(1+$rebate[196]/90)*10)/10?>}]}],
                                                  modes:[{modeid:1,name:'元',rate:1},{modeid:2,name:'角',rate:0.1},{modeid:3,name:'分',rate:0.01}],
                                                  desc:'任选八中五'
                                                }<?php }?>]}<?php }?>],
		cur_issue : {issue:'<?=$issue?>',endtime:'<?=$endtime?>',opentime:'<?=$opentime?>'},
		issues    : {//所有的可追号期数集合
                         today:[
<?php
if($nums==0){
	$sqlb="select * from ssc_nums where cid='6' order by id asc";
}else{
	$sqlb="select * from ssc_nums where cid='6' and endtime>='".date("H:i:s")."' order by id asc";
}
	$rsb=mysql_query($sqlb) or  die("数据库修改出错!".mysql_error());
	while ($rowb = mysql_fetch_array($rsb)){
		echo "{issue:'".$dymd.substr($rowb['nums'],1,2)."',endtime:'".$dymd2." ".$rowb['endtime']."'}";
		if($rowb['nums']!="78"){echo ",";}
	}

?>								                               ],
                         tomorrow: [
                                                               ]
                     },
		servertime: '<?=date("Y-m-d H:i:s")?>',
		lotteryid : parseInt(6,10),
		isdynamic : 1,
		//onfinishbuy: function(){window.parent.abcd();},
		ajaxurl   : './play_sd115.php'
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
                                <h3>十一运夺金</h3>
                                <p class="gct_now">正在销售 <strong>第 <span id="current_issue"><?=$issue?></span> 期</strong> 今日已开 <strong><span id="current_sale"><?=$salenums?></span></strong> 期 剩 <strong><span id="current_left"><?=$leftnums?></span></strong> 期</p>
                                <div class="clear"></div>
                                <div class="gct_time">
                                    <p class="gct_now">本期销售截止时间  <span class=nbox id="current_endtime"><?=$endtime?></span></p>
                                    <div class="clear"></div>
                                    <p class="gct_now gct_now1">剩余</p><div class="gct_time_now"><div class="gct_time_now_l"><span id="count_down">00:00:00</span></div></div>
                                </div>
                                <div class="gct_menu">
                                    <a class="gct_menu_yl" href='history_code.php?id=6' target="_blank"></a>                                </div>
                            </div>
                            <div class="gct_r">
                                <h3>十一运夺金  第 <b><span class=nn id="lt_gethistorycode"><?=substr($rowc['issue'],-8)?></span> </b> 期 
								<span id="lt_opentimebox" style="display:none;">&nbsp;&nbsp;<span id="waitopendesc">等待开奖</span>&nbsp;<span style="color:#F9CE46;" id="lt_opentimeleft" ></span></span><span id="lt_opentimebox2" style="display:none; color:#F9CE46;"><strong>&nbsp;&nbsp;正在开奖</strong></span></h3>
								
								<div style="display:none;" class="tad" id="showadvbox"><a href="promotion_center.php"><img src='images/v1/ad.jpg' border="0" /></a></div>
								
								<div class="gct_r_nub" id="showcodebox">
                                    <div class="gr_s gr_ss<?=$rowc['n1']?>" name="historycode" flag="normal"></div>
                                    <div class="gr_s gr_ss<?=$rowc['n2']?>" name="historycode" flag="normal"></div>
                                    <div class="gr_s gr_ss<?=$rowc['n3']?>" name="historycode" flag="normal"></div>
                                    <div class="gr_s gr_ss<?=$rowc['n4']?>" name="historycode" flag="normal"></div>
                                    <div class="gr_s gr_ss<?=$rowc['n5']?>" name="historycode" flag="normal"></div>
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