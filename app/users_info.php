<?php
session_start();
error_reporting(0);
require_once 'conn.php';
require_once 'check.php';

$ztt=array("停用","使用中"); 
$uid=$_REQUEST['uid'];
if($uid!=""){
	$sql = "select * from ssc_member WHERE id='" . $uid . "'";
}else{
	$sql = "select * from ssc_member WHERE username='" . $_SESSION["username"] . "'";
}

$rs = mysql_query($sql);
$row = mysql_fetch_array($rs);
$stra=explode(";",$row['rebate']);
for ($i=0; $i<count($stra)-1; $i++) {
	$strb=explode(",",$stra[$i]);
//	echo $strb[0]."_".$strb[1]."_".$strb[2]."<br>";
	$strc=explode("_",$strb[0]);
	$rebate[$strc[1]]=$strb[1];
	$zt[$strc[1]]=$ztt[$strb[2]];
}

	$sqld = "select * from ssc_class order by id asc";
	$rsd = mysql_query($sqld);
	while ($rowd = mysql_fetch_array($rsd)){
		$strd=explode(";",$rowd['rates']);
		for ($i=0; $i<count($strd); $i++) {
			$rate[$rowd['mid']][$i]=$strd[$i];
		}
	}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD><TITLE><?php echo $webname;?>  - 奖金详情</TITLE>
<META http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<META http-equiv="Pragma" content="no-cache" />
<LINK href="css/v1.css" rel="stylesheet" type="text/css" />
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
<SCRIPT language="javascript" type="text/javascript">
var  resizeTimer = null;
jQuery(document).ready(function(){
	
	jQuery("#mainbox").height( jQuery(document).height()-jQuery("#topbox").height() );
	jQuery("#leftbox").height( jQuery("#mainbox").height() );
	$(window).resize(function(){
		if(resizeTimer==null){
			resizeTimer = setTimeout("resizewindow()",300);
		}
	}); 

	jQuery("#dragbutton").click(function(){
		if( jQuery(this).attr("class") == "img_arrow_l" ){
			jQuery(this).attr("class",'img_arrow_r');
			jQuery("#leftbox").css({width:"0px"}).hide();
			jQuery("#mainbox").css({width:"100%"});
		}else{
			jQuery(this).attr("class",'img_arrow_l');
			jQuery("#leftbox").css({width:"160px"}).show();
			jQuery("#mainbox").css({width:"auto"});
		}
	});

$(function(){
	var _wrap=$('#zjtgul');
	var _interval=2000;
	var _moving;
	_wrap.hover(function(){
		clearInterval(_moving);
	},function(){
		_moving=setInterval(function(){
			var _field=_wrap.find('li:first');
			var _h=_field.height();
			_field.animate({marginTop:-_h+'px'},600,function(){
				_field.css('marginTop',0).appendTo(_wrap);
			})
		},_interval)
	}).trigger('mouseleave');
});

_permgetdata = setInterval(function(){
	$.ajax({
		type : 'POST',
		url  : 'default_frame.php',
		data : 'flag=gettoprize',
		timeout : 30000,
		success : function(data){
				var partn = /<(.*)>.*<\/\1>/;
				if( partn.exec(data) ){
					window.top.location.href="default_frame.php";
					return false;
				}
				if( data != 'empty' ){
					eval("data="+data+";");
					var html = '';
					$.each(data,function(i,n){
						html += '<li>恭喜 【<span class=c1>'+n.name+'</span>】 '+n.lottery+' <span class=c2>'+n.issue+'</span> 期, 喜中 <span class=c3>'+n.prize+'</span> 大奖!</li>';
					});
					$("#zjtgul").empty();
					$(html).appendTo("#zjtgul");
					//alert(html);
				}
				return true;
		},
		error: function(){
			$lf.html("<font color='#A20000'>获取失败</font>");
		}
	});
},290000);

_fastData = setInterval(function(){
	var $lf = $("#leftusermoney",window.top.frames['leftframe'].document);
	$.ajax({
		type : 'POST',
		url  : 'default_getfastdata.php',
		timeout : 9000,
		success : function(data){
				var partn = /<(.*)>.*<\/\1>/;
				if( partn.exec(data) ){
					window.top.location.href="default_frame.php";
					return false;
				}
				eval("data="+data+";");
				//用户余额
				if( data.money == 'Error' ){
					window.top.location.href="./";
					return false;
				}
				if( data.money != 'empty' ){
//					var dd = moneyFormat(data.money);
					var dd = data.money;
					dd = dd.substring(0,(dd.length-2));
					$lf.html(dd);
				}
				return true;
		}
	});
},10000);

});
function resizewindow(){
	jQuery("#mainbox").height( jQuery(window).height()-jQuery("#topbox").height() );
	jQuery("#leftbox").height( jQuery(window).height()-jQuery("#topbox").height() );
	resizeTimer = null;
}

</script>
<SCRIPT LANGUAGE='JavaScript'>function ResumeError() {return true;} window.onerror = ResumeError; </SCRIPT> 
</HEAD>
<BODY STYLE='background-color:#838383;'>


<H1>
<SPAN class="action-span"><A href="account_update.php" target='_self'>修改密码</a></SPAN>
<SPAN class="action-span"><A href="account_banks.php" target='_self'>我的银行卡</a></SPAN>
<SPAN class="action-span"><A href="users_message.php" target='_self'>我的消息</a></SPAN>
<SPAN class="action-span zhuangtai"><A href="users_info.php" target='_self'>奖金详情</a></SPAN>
<SPAN class="action-span1"><DIV class='tubiao'></DIV>当前位置: <A href="/" target='_top'><?php echo $webname;?></a> - 奖金详情  </SPAN><DIV style="clear:both"></DIV></H1>

<br/><STYLE>
.tab-div-s2 .bd{width:100%;_width:100%;*margin-top:0px;}
#tabbar-div-s2 .tab-front .content{padding:0px 4px;}
#tabbar-div-s2 .tab-back {*margin-top:7px;*height:32px;*overflow:hidden}
#tabbar-div-s2 .tab-back .content{padding:0px 4px;}
</STYLE>
<script language="javascipt" type="text/javascript">
;(function($){
$(document).ready(function(){
	$("span[id^='general_tab_']","#tabbar-div-s2").click(function(){
		$k = $(this).attr("id").replace("general_tab_","");
		$k = parseInt($k,10);
		$("span[id^='general_tab_']","#tabbar-div-s2").attr("class","tab-back");
		$("div[id^='general_txt_']").hide();
		$(this).attr("class","tab-front");
		$("#general_txt_"+$k).show();
		$("span[id^='tabbar_tab_"+$k+"_']:first").click();
		//$("table[id^='tabbar_txt_']:first").show();
	});
	$("span[id^='tabbar_tab_']").click(function(){
		$z = $(this).attr("id").replace("tabbar_tab_","");
		$("span[id^='tabbar_tab_']").attr("class","tab-back");
		$("table[id^='tabbar_txt_']").hide();
		$(this).attr("class","tab-front");
		$("#tabbar_txt_"+$z).show();
	});
	$("span[id^='general_tab_']:first","#tabbar-div-s2").click();
	//$("div[id^='general_txt_']:first").show();
});
})(jQuery);
</script>

<CENTER>
<div class="div_s1" style='text-align:left;'>
<div class='header'><DIV class='icons_mb3'></DIV> 账号: <?=$row['username']?> &nbsp;&nbsp;&nbsp;
昵称:<?=$row['nickname']?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <font color="#FF3300">高频彩</font>奖金限额:400000元&nbsp;&nbsp;&nbsp;&nbsp;<font color="#33FF00">低频彩</font>奖金限额：100000元</div>

<div class="tab-div-s2">
	<table width='100%' border="0" cellspacing="0" cellpadding="0"><tr><td id="tabbar-div-s2">
    	    <span class="tab-back"  id="general_tab_1" TITLE='重庆时时彩 (CQSSC)' ALT='重庆时时彩 (CQSSC)'>
		  <span class="tabbar-left"></span>
		  <span class="content">重庆</span>
		  <span class="tabbar-right"></span>
		</span>
    	    <span class="tab-back"  id="general_tab_2" TITLE='SC五分彩 (HLJSSC)' ALT='SC五分彩 (HLJSSC)'>
		  <span class="tabbar-left"></span>
		  <span class="content">全天</span>
		  <span class="tabbar-right"></span>
		</span>
    	    <span class="tab-back"  id="general_tab_3" TITLE='新疆时时彩 (XJSSC)' ALT='新疆时时彩 (XJSSC)'>
		  <span class="tabbar-left"></span>
		  <span class="content">新疆</span>
		  <span class="tabbar-right"></span>
		</span>
    	    <span class="tab-back"  id="general_tab_4" TITLE='江西时时彩 (JXSSC)' ALT='江西时时彩 (JXSSC)'>
		  <span class="tabbar-left"></span>
		  <span class="content">江西</span>
		  <span class="tabbar-right"></span>
		</span>
    	    <span class="tab-back"  id="general_tab_5" TITLE='上海时时乐 (SHSSL)' ALT='上海时时乐 (SHSSL)'>
		  <span class="tabbar-left"></span>
		  <span class="content">时时乐</span>
		  <span class="tabbar-right"></span>
		</span>
    	    <span class="tab-back"  id="general_tab_6" TITLE='十一运夺金 (山东11选5,SD11-5)' ALT='十一运夺金 (山东11选5,SD11-5)'>
		  <span class="tabbar-left"></span>
		  <span class="content">十一运</span>
		  <span class="tabbar-right"></span>
		</span>
    	    <span class="tab-back"  id="general_tab_7" TITLE='多乐彩 (江西11选5,JX11-5)' ALT='多乐彩 (江西11选5,JX11-5)'>
		  <span class="tabbar-left"></span>
		  <span class="content">多乐彩</span>
		  <span class="tabbar-right"></span>
		</span>
    	    <span class="tab-back"  id="general_tab_8" TITLE='广东11选5 (GD11-5)' ALT='广东11选5 (GD11-5)'>
		  <span class="tabbar-left"></span>
		  <span class="content">广东11选5</span>
		  <span class="tabbar-right"></span>
		</span>
    	    <span class="tab-back"  id="general_tab_9" TITLE='福彩3D (3D)' ALT='福彩3D (3D)'>
		  <span class="tabbar-left"></span>
		  <span class="content">3D</span>
		  <span class="tabbar-right"></span>
		</span>
    	    <span class="tab-back"  id="general_tab_10" TITLE='排列三、五 (P3P5)' ALT='排列三、五 (P3P5)'>
		  <span class="tabbar-left"></span>
		  <span class="content">排列3-5</span>
		  <span class="tabbar-right"></span>
		</span>
    	    <span class="tab-back"  id="general_tab_11" TITLE='重庆十一选五' ALT='重庆十一选五'>
		  <span class="tabbar-left"></span>
		  <span class="content">重庆11选5</span>
		  <span class="tabbar-right"></span>
		</span>
    	</td></tr>
	</table>

		<div class='bd'><div class='bd2' id="general_txt_1">
	<table class="tabbar-div-s3" width='100%' style="display:none;">
	  <tr>
        <td>
						 <span id="tabbar_tab_1_56" class="tab-back">
				<span class="tabbar-left"></span>
				<span class="content"> CQSSC[1800-6.6]</span>
				<span class="tabbar-right"></span>
			 </span>
					</td>
	  </tr>
	</table>
	<BR/>	<div class="ld" style='width:97%; margin:0px 10px 0px 10px;'>
		<table class="lt" id="tabbar_txt_1_56" border="0" cellspacing="0" cellpadding="0">
		<tr class='th'>
			<td>玩法组</td>
			<td><div class='line'></div>奖级</td>
			<td><div class='line'></div>奖金</td>
						<td><div class='line'></div>返点</td>
						<td><div class='line'></div>状态</td>
		</tr>
				<tr>
			<td align="center">五星直选</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[400][0]?><br></td>
						<td align="center"><?=$rebate[385]?></td>
						<td align="center"><?=$zt[385]?></td>
		</tr>
				<tr>
			<td align="center">前四直选</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[401][0]?><br></td>
						<td align="center"><?=$rebate[386]?></td>
						<td align="center"><?=$zt[386]?></td>
		</tr>
				<tr>
			<td align="center">后四直选</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[402][0]?><br></td>
						<td align="center"><?=$rebate[387]?></td>
						<td align="center"><?=$zt[387]?></td>
		</tr>
				<tr>
			<td align="center">中三直选</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[403][0]?><br></td>
						<td align="center"><?=$rebate[388]?></td>
						<td align="center"><?=$zt[388]?></td>
		</tr>
				<tr>
			<td align="center">中三组选</td>
			<td align="center">组三奖金<br>组六奖金<br></td>
			<td align="center"><?=$rate[407][0]?><br><?=$rate[407][1]?><br></td>
						<td align="center"><?=$rebate[389]?></td>
						<td align="center"><?=$zt[389]?></td>
		</tr>
				<tr>
			<td align="center">百家乐</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[409][0]?><br><?=$rate[409][1]?><br><?=$rate[409][2]?><br><?=$rate[409][3]?><br></td>
						<td align="center"><?=$rebate[390]?></td>
						<td align="center"><?=$zt[390]?></td>
		</tr>         
				<tr>
			<td align="center">前三直选</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[14][0]?><br></td>
						<td align="center"><?=$rebate[1]?></td>
						<td align="center"><?=$zt[1]?></td>
		</tr>
				<tr>
			<td align="center">后三直选</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[16][0]?><br></td>
						<td align="center"><?=$rebate[2]?></td>
						<td align="center"><?=$zt[2]?></td>
		</tr>
				<tr>
			<td align="center">前三组选</td>
			<td align="center">组三奖金<br>组六奖金<br></td>
			<td align="center"><?=$rate[20][0]?><br><?=$rate[20][1]?><br></td>
						<td align="center"><?=$rebate[3]?></td>
						<td align="center"><?=$zt[3]?></td>
		</tr>
				<tr>
			<td align="center">后三组选</td>
			<td align="center">组三奖金<br>组六奖金<br></td>
			<td align="center"><?=$rate[24][0]?><br><?=$rate[24][1]?><br></td>
						<td align="center"><?=$rebate[4]?></td>
						<td align="center"><?=$zt[4]?></td>
		</tr>
				<tr>
			<td align="center">一码不定位</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[26][0]?><br></td>
						<td align="center"><?=$rebate[5]?></td>
						<td align="center"><?=$zt[5]?></td>
		</tr>
				<tr>
			<td align="center">二码不定位</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[27][0]?><br></td>
						<td align="center"><?=$rebate[6]?></td>
						<td align="center"><?=$zt[6]?></td>
		</tr>
				<tr>
			<td align="center">前二直选</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[28][0]?><br></td>
						<td align="center"><?=$rebate[7]?></td>
						<td align="center"><?=$zt[7]?></td>
		</tr>
				<tr>
			<td align="center">后二直选</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[29][0]?><br></td>
						<td align="center"><?=$rebate[8]?></td>
						<td align="center"><?=$zt[8]?></td>
		</tr>
				<tr>
			<td align="center">前二组选</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[30][0]?><br></td>
						<td align="center"><?=$rebate[9]?></td>
						<td align="center"><?=$zt[9]?></td>
		</tr>
				<tr>
			<td align="center">后二组选</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[31][0]?><br></td>
						<td align="center"><?=$rebate[10]?></td>
						<td align="center"><?=$zt[10]?></td>
		</tr>
				<tr>
			<td align="center">定位胆</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[32][0]?><br></td>
						<td align="center"><?=$rebate[11]?></td>
						<td align="center"><?=$zt[11]?></td>
		</tr>
				<tr>
			<td align="center">大小单双(前二)</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[37][0]?><br></td>
						<td align="center"><?=$rebate[12]?></td>
						<td align="center"><?=$zt[12]?></td>
		</tr>
				<tr>
			<td align="center">大小单双(后二)</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[38][0]?><br></td>
						<td align="center"><?=$rebate[13]?></td>
						<td align="center"><?=$zt[13]?></td>
		</tr>
			</table>
		</div><BR/></div></div>
		<div class='bd'><div class='bd2' id="general_txt_2">
	<table class="tabbar-div-s3" width='100%' style="display:none;">
	  <tr>
        <td>
						 <span id="tabbar_tab_2_59" class="tab-back">
				<span class="tabbar-left"></span>
				<span class="content">HLJSSC[1800-6.6]</span>
				<span class="tabbar-right"></span>
			 </span>
					</td>
	  </tr>
	</table>
	<BR/>	<div class="ld" style='width:97%; margin:0px 10px 0px 10px;'>
		<table class="lt" id="tabbar_txt_2_59" border="0" cellspacing="0" cellpadding="0">
		<tr class='th'>
			<td>玩法组</td>
			<td><div class='line'></div>奖级</td>
			<td><div class='line'></div>奖金</td>
						<td><div class='line'></div>返点</td>
						<td><div class='line'></div>状态</td>
		</tr>
				<tr>
			<td align="center">前三直选</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[52][0]?><br></td>
						<td align="center"><?=$rebate[39]?></td>
						<td align="center"><?=$zt[39]?></td>
		</tr>
				<tr>
			<td align="center">后三直选</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[54][0]?><br></td>
						<td align="center"><?=$rebate[40]?></td>
						<td align="center"><?=$zt[40]?></td>
		</tr>
				<tr>
			<td align="center">前三组选</td>
			<td align="center">组三奖金<br>组六奖金<br></td>
			<td align="center"><?=$rate[58][0]?><br><?=$rate[58][1]?><br></td>
						<td align="center"><?=$rebate[41]?></td>
						<td align="center"><?=$zt[41]?></td>
		</tr>
				<tr>
			<td align="center">后三组选</td>
			<td align="center">组三奖金<br>组六奖金<br></td>
			<td align="center"><?=$rate[62][0]?><br><?=$rate[62][1]?><br></td>
						<td align="center"><?=$rebate[42]?></td>
						<td align="center"><?=$zt[42]?></td>
		</tr>
				<tr>
			<td align="center">一码不定位</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[64][0]?><br></td>
						<td align="center"><?=$rebate[43]?></td>
						<td align="center"><?=$zt[43]?></td>
		</tr>
				<tr>
			<td align="center">二码不定位</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[65][0]?><br></td>
						<td align="center"><?=$rebate[44]?></td>
						<td align="center"><?=$zt[44]?></td>
		</tr>
				<tr>
			<td align="center">前二直选</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[66][0]?><br></td>
						<td align="center"><?=$rebate[45]?></td>
						<td align="center"><?=$zt[45]?></td>
		</tr>
				<tr>
			<td align="center">后二直选</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[67][0]?><br></td>
						<td align="center"><?=$rebate[46]?></td>
						<td align="center"><?=$zt[46]?></td>
		</tr>
				<tr>
			<td align="center">前二组选</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[68][0]?><br></td>
						<td align="center"><?=$rebate[47]?></td>
						<td align="center"><?=$zt[47]?></td>
		</tr>
				<tr>
			<td align="center">后二组选</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[69][0]?><br></td>
						<td align="center"><?=$rebate[48]?></td>
						<td align="center"><?=$zt[48]?></td>
		</tr>
				<tr>
			<td align="center">定位胆</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[70][0]?><br></td>
						<td align="center"><?=$rebate[49]?></td>
						<td align="center"><?=$zt[49]?></td>
		</tr>
				<tr>
			<td align="center">大小单双(前二)</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[75][0]?><br></td>
						<td align="center"><?=$rebate[50]?></td>
						<td align="center"><?=$zt[50]?></td>
		</tr>
				<tr>
			<td align="center">大小单双(后二)</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[76][0]?><br></td>
						<td align="center"><?=$rebate[51]?></td>
						<td align="center"><?=$zt[51]?></td>
		</tr>
			</table>
		</div><BR/></div></div>
		<div class='bd'><div class='bd2' id="general_txt_3">
	<table class="tabbar-div-s3" width='100%' style="display:none;">
	  <tr>
        <td>
						 <span id="tabbar_tab_3_62" class="tab-back">
				<span class="tabbar-left"></span>
				<span class="content">XJSSC[1800-6.6]</span>
				<span class="tabbar-right"></span>
			 </span>
					</td>
	  </tr>
	</table>
	<BR/>	<div class="ld" style='width:97%; margin:0px 10px 0px 10px;'>
		<table class="lt" id="tabbar_txt_3_62" border="0" cellspacing="0" cellpadding="0">
		<tr class='th'>
			<td>玩法组</td>
			<td><div class='line'></div>奖级</td>
			<td><div class='line'></div>奖金</td>
						<td><div class='line'></div>返点</td>
						<td><div class='line'></div>状态</td>
		</tr>
				<tr>
			<td align="center">前三直选</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[90][0]?><br></td>
						<td align="center"><?=$rebate[77]?></td>
						<td align="center"><?=$zt[77]?></td>
		</tr>
				<tr>
			<td align="center">后三直选</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[92][0]?><br></td>
						<td align="center"><?=$rebate[78]?></td>
						<td align="center"><?=$zt[78]?></td>
		</tr>
				<tr>
			<td align="center">前三组选</td>
			<td align="center">组三奖金<br>组六奖金<br></td>
			<td align="center"><?=$rate[96][0]?><br><?=$rate[96][1]?><br></td>
						<td align="center"><?=$rebate[79]?></td>
						<td align="center"><?=$zt[79]?></td>
		</tr>
				<tr>
			<td align="center">后三组选</td>
			<td align="center">组三奖金<br>组六奖金<br></td>
			<td align="center"><?=$rate[100][0]?><br><?=$rate[100][1]?><br></td>
						<td align="center"><?=$rebate[80]?></td>
						<td align="center"><?=$zt[80]?></td>
		</tr>
				<tr>
			<td align="center">一码不定位</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[102][0]?><br></td>
						<td align="center"><?=$rebate[81]?></td>
						<td align="center"><?=$zt[81]?></td>
		</tr>
				<tr>
			<td align="center">二码不定位</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[103][0]?><br></td>
						<td align="center"><?=$rebate[82]?></td>
						<td align="center"><?=$zt[82]?></td>
		</tr>
				<tr>
			<td align="center">前二直选</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[104][0]?><br></td>
						<td align="center"><?=$rebate[83]?></td>
						<td align="center"><?=$zt[83]?></td>
		</tr>
				<tr>
			<td align="center">后二直选</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[105][0]?><br></td>
						<td align="center"><?=$rebate[84]?></td>
						<td align="center"><?=$zt[84]?></td>
		</tr>
				<tr>
			<td align="center">前二组选</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[106][0]?><br></td>
						<td align="center"><?=$rebate[85]?></td>
						<td align="center"><?=$zt[85]?></td>
		</tr>
				<tr>
			<td align="center">后二组选</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[107][0]?><br></td>
						<td align="center"><?=$rebate[86]?></td>
						<td align="center"><?=$zt[86]?></td>
		</tr>
				<tr>
			<td align="center">定位胆</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[108][0]?><br></td>
						<td align="center"><?=$rebate[87]?></td>
						<td align="center"><?=$zt[87]?></td>
		</tr>
				<tr>
			<td align="center">大小单双(前二)</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[113][0]?><br></td>
						<td align="center"><?=$rebate[88]?></td>
						<td align="center"><?=$zt[88]?></td>
		</tr>
				<tr>
			<td align="center">大小单双(后二)</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[114][0]?><br></td>
						<td align="center"><?=$rebate[89]?></td>
						<td align="center"><?=$zt[89]?></td>
		</tr>
			</table>
		</div><BR/></div></div>
		<div class='bd'><div class='bd2' id="general_txt_4">
	<table class="tabbar-div-s3" width='100%' style="display:none;">
	  <tr>
        <td>
						 <span id="tabbar_tab_4_65" class="tab-back">
				<span class="tabbar-left"></span>
				<span class="content">JXSSC[1800-6.6]</span>
				<span class="tabbar-right"></span>
			 </span>
					</td>
	  </tr>
	</table>
	<BR/>	<div class="ld" style='width:97%; margin:0px 10px 0px 10px;'>
		<table class="lt" id="tabbar_txt_4_65" border="0" cellspacing="0" cellpadding="0">
		<tr class='th'>
			<td>玩法组</td>
			<td><div class='line'></div>奖级</td>
			<td><div class='line'></div>奖金</td>
						<td><div class='line'></div>返点</td>
						<td><div class='line'></div>状态</td>
		</tr>
				<tr>
			<td align="center">前三直选</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[128][0]?><br></td>
						<td align="center"><?=$rebate[115]?></td>
						<td align="center"><?=$zt[115]?></td>
		</tr>
				<tr>
			<td align="center">后三直选</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[130][0]?><br></td>
						<td align="center"><?=$rebate[116]?></td>
						<td align="center"><?=$zt[116]?></td>
		</tr>
				<tr>
			<td align="center">前三组选</td>
			<td align="center">组三奖金<br>组六奖金<br></td>
			<td align="center"><?=$rate[134][0]?><br><?=$rate[134][1]?><br></td>
						<td align="center"><?=$rebate[117]?></td>
						<td align="center"><?=$zt[117]?></td>
		</tr>
				<tr>
			<td align="center">后三组选</td>
			<td align="center">组三奖金<br>组六奖金<br></td>
			<td align="center"><?=$rate[138][0]?><br><?=$rate[138][1]?><br></td>
						<td align="center"><?=$rebate[118]?></td>
						<td align="center"><?=$zt[118]?></td>
		</tr>
				<tr>
			<td align="center">一码不定位</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[140][0]?><br></td>
						<td align="center"><?=$rebate[119]?></td>
						<td align="center"><?=$zt[119]?></td>
		</tr>
				<tr>
			<td align="center">二码不定位</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[141][0]?><br></td>
						<td align="center"><?=$rebate[120]?></td>
						<td align="center"><?=$zt[120]?></td>
		</tr>
				<tr>
			<td align="center">前二直选</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[142][0]?><br></td>
						<td align="center"><?=$rebate[121]?></td>
						<td align="center"><?=$zt[121]?></td>
		</tr>
				<tr>
			<td align="center">后二直选</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[143][0]?><br></td>
						<td align="center"><?=$rebate[122]?></td>
						<td align="center"><?=$zt[122]?></td>
		</tr>
				<tr>
			<td align="center">前二组选</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[144][0]?><br></td>
						<td align="center"><?=$rebate[123]?></td>
						<td align="center"><?=$zt[123]?></td>
		</tr>
				<tr>
			<td align="center">后二组选</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[145][0]?><br></td>
						<td align="center"><?=$rebate[124]?></td>
						<td align="center"><?=$zt[124]?></td>
		</tr>
				<tr>
			<td align="center">定位胆</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[146][0]?><br></td>
						<td align="center"><?=$rebate[125]?></td>
						<td align="center"><?=$zt[125]?></td>
		</tr>
				<tr>
			<td align="center">大小单双(前二)</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[151][0]?><br></td>
						<td align="center"><?=$rebate[126]?></td>
						<td align="center"><?=$zt[126]?></td>
		</tr>
				<tr>
			<td align="center">大小单双(后二)</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[152][0]?><br></td>
						<td align="center"><?=$rebate[127]?></td>
						<td align="center"><?=$zt[127]?></td>
		</tr>
			</table>
		</div><BR/></div></div>
		<div class='bd'><div class='bd2' id="general_txt_5">
	<table class="tabbar-div-s3" width='100%' style="display:none;">
	  <tr>
        <td>
						 <span id="tabbar_tab_5_68" class="tab-back">
				<span class="tabbar-left"></span>
				<span class="content">SHSSL[1800-6.6]</span>
				<span class="tabbar-right"></span>
			 </span>
					</td>
	  </tr>
	</table>
	<BR/>	<div class="ld" style='width:97%; margin:0px 10px 0px 10px;'>
		<table class="lt" id="tabbar_txt_5_68" border="0" cellspacing="0" cellpadding="0">
		<tr class='th'>
			<td>玩法组</td>
			<td><div class='line'></div>奖级</td>
			<td><div class='line'></div>奖金</td>
						<td><div class='line'></div>返点</td>
						<td><div class='line'></div>状态</td>
		</tr>
				<tr>
			<td align="center">直选</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[164][0]?><br></td>
						<td align="center"><?=$rebate[153]?></td>
						<td align="center"><?=$zt[153]?></td>
		</tr>
				<tr>
			<td align="center">组选</td>
			<td align="center">组三奖金<br>组六奖金<br></td>
			<td align="center"><?=$rate[168][0]?><br><?=$rate[168][1]?><br></td>
						<td align="center"><?=$rebate[154]?></td>
						<td align="center"><?=$zt[154]?></td>
		</tr>
				<tr>
			<td align="center">一码不定位</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[170][0]?><br></td>
						<td align="center"><?=$rebate[155]?></td>
						<td align="center"><?=$zt[155]?></td>
		</tr>
				<tr>
			<td align="center">二码不定位</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[171][0]?><br></td>
						<td align="center"><?=$rebate[156]?></td>
						<td align="center"><?=$zt[156]?></td>
		</tr>
				<tr>
			<td align="center">前二直选</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[172][0]?><br></td>
						<td align="center"><?=$rebate[157]?></td>
						<td align="center"><?=$zt[157]?></td>
		</tr>
				<tr>
			<td align="center">后二直选</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[173][0]?><br></td>
						<td align="center"><?=$rebate[158]?></td>
						<td align="center"><?=$zt[158]?></td>
		</tr>
				<tr>
			<td align="center">前二组选</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[174][0]?><br></td>
						<td align="center"><?=$rebate[159]?></td>
						<td align="center"><?=$zt[159]?></td>
		</tr>
				<tr>
			<td align="center">后二组选</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[175][0]?><br></td>
						<td align="center"><?=$rebate[160]?></td>
						<td align="center"><?=$zt[160]?></td>
		</tr>
				<tr>
			<td align="center">定位胆</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[176][0]?><br></td>
						<td align="center"><?=$rebate[161]?></td>
						<td align="center"><?=$zt[161]?></td>
		</tr>
				<tr>
			<td align="center">大小单双(前二)</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[179][0]?><br></td>
						<td align="center"><?=$rebate[162]?></td>
						<td align="center"><?=$zt[162]?></td>
		</tr>
				<tr>
			<td align="center">大小单双(后二)</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[180][0]?><br></td>
						<td align="center"><?=$rebate[163]?></td>
						<td align="center"><?=$zt[163]?></td>
		</tr>
			</table>
		</div><BR/></div></div>
		<div class='bd'><div class='bd2' id="general_txt_6">
	<table class="tabbar-div-s3" width='100%' style="display:none;">
	  <tr>
        <td>
						 <span id="tabbar_tab_6_71" class="tab-back">
				<span class="tabbar-left"></span>
				<span class="content">SD11-5[1782-3.9]</span>
				<span class="tabbar-right"></span>
			 </span>
					</td>
	  </tr>
	</table>
	<BR/>	<div class="ld" style='width:97%; margin:0px 10px 0px 10px;'>
		<table class="lt" id="tabbar_txt_6_71" border="0" cellspacing="0" cellpadding="0">
		<tr class='th'>
			<td>玩法组</td>
			<td><div class='line'></div>奖级</td>
			<td><div class='line'></div>奖金</td>
						<td><div class='line'></div>返点</td>
						<td><div class='line'></div>状态</td>
		</tr>
				<tr>
			<td align="center">前三直选</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[197][0]?><br></td>
						<td align="center"><?=$rebate[181]?></td>
						<td align="center"><?=$zt[181]?></td>
		</tr>
				<tr>
			<td align="center">前三组选</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[198][0]?><br></td>
						<td align="center"><?=$rebate[182]?></td>
						<td align="center"><?=$zt[182]?></td>
		</tr>
				<tr>
			<td align="center">前二直选</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[199][0]?><br></td>
						<td align="center"><?=$rebate[183]?></td>
						<td align="center"><?=$zt[183]?></td>
		</tr>
				<tr>
			<td align="center">前二组选</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[200][0]?><br></td>
						<td align="center"><?=$rebate[184]?></td>
						<td align="center"><?=$zt[184]?></td>
		</tr>
				<tr>
			<td align="center">不定位</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[201][0]?><br></td>
						<td align="center"><?=$rebate[185]?></td>
						<td align="center"><?=$zt[185]?></td>
		</tr>
				<tr>
			<td align="center">定位胆</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[202][0]?><br></td>
						<td align="center"><?=$rebate[186]?></td>
						<td align="center"><?=$zt[186]?></td>
		</tr>
				<tr>
			<td align="center">定单双</td>
			<td align="center">5单0双<br>
			4单1双<br>
			3单2双<br>
			2单3双<br>
			1单4双<br>
			0单5双<br></td>
			<td align="center"><?=$rate[205][0]?><br><?=$rate[205][1]?><br><?=$rate[205][2]?><br><?=$rate[205][3]?><br><?=$rate[205][4]?><br><?=$rate[205][5]?><br></td>
						<td align="center"><?=$rebate[187]?></td>
						<td align="center"><?=$zt[187]?></td>
		</tr>
				<tr>
			<td align="center">猜中位</td>
			<td align="center">03,09<br>04,08<br>05,07<br>06<br></td>
			<td align="center"><?=$rate[206][0]?><br><?=$rate[206][1]?><br><?=$rate[206][2]?><br><?=$rate[206][3]?><br></td>
						<td align="center"><?=$rebate[188]?></td>
						<td align="center"><?=$zt[188]?></td>
		</tr>
				<tr>
			<td align="center">任选一中一</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[207][0]?><br></td>
						<td align="center"><?=$rebate[189]?></td>
						<td align="center"><?=$zt[189]?></td>
		</tr>
				<tr>
			<td align="center">任选二中二</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[208][0]?><br></td>
						<td align="center"><?=$rebate[190]?></td>
						<td align="center"><?=$zt[190]?></td>
		</tr>
				<tr>
			<td align="center">任选三中三</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[209][0]?><br></td>
						<td align="center"><?=$rebate[191]?></td>
						<td align="center"><?=$zt[191]?></td>
		</tr>
				<tr>
			<td align="center">任选四中四</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[210][0]?><br></td>
						<td align="center"><?=$rebate[192]?></td>
						<td align="center"><?=$zt[192]?></td>
		</tr>
				<tr>
			<td align="center">任选五中五</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[211][0]?><br></td>
						<td align="center"><?=$rebate[193]?></td>
						<td align="center"><?=$zt[193]?></td>
		</tr>
				<tr>
			<td align="center">任选六中五</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[212][0]?><br></td>
						<td align="center"><?=$rebate[194]?></td>
						<td align="center"><?=$zt[194]?></td>
		</tr>
				<tr>
			<td align="center">任选七中五</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[213][0]?><br></td>
						<td align="center"><?=$rebate[195]?></td>
						<td align="center"><?=$zt[195]?></td>
		</tr>
				<tr>
			<td align="center">任选八中五</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[214][0]?><br></td>
						<td align="center"><?=$rebate[196]?></td>
						<td align="center"><?=$zt[196]?></td>
		</tr>
			</table>
		</div><BR/></div></div>
		<div class='bd'><div class='bd2' id="general_txt_7">
	<table class="tabbar-div-s3" width='100%' style="display:none;">
	  <tr>
        <td>
						 <span id="tabbar_tab_7_73" class="tab-back">
				<span class="tabbar-left"></span>
				<span class="content">JX11-5[1782-3.9]</span>
				<span class="tabbar-right"></span>
			 </span>
					</td>
	  </tr>
	</table>
	<BR/>	<div class="ld" style='width:97%; margin:0px 10px 0px 10px;'>
		<table class="lt" id="tabbar_txt_7_73" border="0" cellspacing="0" cellpadding="0">
		<tr class='th'>
			<td>玩法组</td>
			<td><div class='line'></div>奖级</td>
			<td><div class='line'></div>奖金</td>
						<td><div class='line'></div>返点</td>
						<td><div class='line'></div>状态</td>
		</tr>
				<tr>
			<td align="center">前三直选</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[231][0]?><br></td>
						<td align="center"><?=$rebate[215]?></td>
						<td align="center"><?=$zt[215]?></td>
		</tr>
				<tr>
			<td align="center">前三组选</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[232][0]?><br></td>
						<td align="center"><?=$rebate[216]?></td>
						<td align="center"><?=$zt[216]?></td>
		</tr>
				<tr>
			<td align="center">前二直选</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[233][0]?><br></td>
						<td align="center"><?=$rebate[217]?></td>
						<td align="center"><?=$zt[217]?></td>
		</tr>
				<tr>
			<td align="center">前二组选</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[234][0]?><br></td>
						<td align="center"><?=$rebate[218]?></td>
						<td align="center"><?=$zt[218]?></td>
		</tr>
				<tr>
			<td align="center">不定位</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[235][0]?><br></td>
						<td align="center"><?=$rebate[219]?></td>
						<td align="center"><?=$zt[219]?></td>
		</tr>
				<tr>
			<td align="center">定位胆</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[236][0]?><br></td>
						<td align="center"><?=$rebate[220]?></td>
						<td align="center"><?=$zt[220]?></td>
		</tr>
				<tr>
			<td align="center">定单双</td>
			<td align="center">5单0双<br />
4单1双<br />
3单2双<br />
2单3双<br />
1单4双<br />
0单5双<br></td>
			<td align="center"><?=$rate[239][0]?><br><?=$rate[239][1]?><br><?=$rate[239][2]?><br><?=$rate[239][3]?><br><?=$rate[239][4]?><br><?=$rate[239][5]?><br></td>
						<td align="center"><?=$rebate[221]?></td>
						<td align="center"><?=$zt[221]?></td>
		</tr>
				<tr>
			<td align="center">猜中位</td>
			<td align="center">03,09<br>04,08<br>05,07<br>06<br></td>
			<td align="center"><?=$rate[240][0]?><br><?=$rate[240][1]?><br><?=$rate[240][2]?><br><?=$rate[240][3]?><br></td>
						<td align="center"><?=$rebate[222]?></td>
						<td align="center"><?=$zt[222]?></td>
		</tr>
				<tr>
			<td align="center">任选一中一</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[241][0]?><br></td>
						<td align="center"><?=$rebate[223]?></td>
						<td align="center"><?=$zt[223]?></td>
		</tr>
				<tr>
			<td align="center">任选二中二</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[242][0]?><br></td>
						<td align="center"><?=$rebate[224]?></td>
						<td align="center"><?=$zt[224]?></td>
		</tr>
				<tr>
			<td align="center">任选三中三</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[243][0]?><br></td>
						<td align="center"><?=$rebate[225]?></td>
						<td align="center"><?=$zt[225]?></td>
		</tr>
				<tr>
			<td align="center">任选四中四</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[244][0]?><br></td>
						<td align="center"><?=$rebate[226]?></td>
						<td align="center"><?=$zt[226]?></td>
		</tr>
				<tr>
			<td align="center">任选五中五</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[245][0]?><br></td>
						<td align="center"><?=$rebate[227]?></td>
						<td align="center"><?=$zt[227]?></td>
		</tr>
				<tr>
			<td align="center">任选六中五</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[246][0]?><br></td>
						<td align="center"><?=$rebate[228]?></td>
						<td align="center"><?=$zt[228]?></td>
		</tr>
				<tr>
			<td align="center">任选七中五</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[247][0]?><br></td>
						<td align="center"><?=$rebate[229]?></td>
						<td align="center"><?=$zt[229]?></td>
		</tr>
				<tr>
			<td align="center">任选八中五</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[248][0]?><br></td>
						<td align="center"><?=$rebate[230]?></td>
						<td align="center"><?=$zt[230]?></td>
		</tr>
			</table>
		</div><BR/></div></div>
		<div class='bd'><div class='bd2' id="general_txt_8">
	<table class="tabbar-div-s3" width='100%' style="display:none;">
	  <tr>
        <td>
						 <span id="tabbar_tab_8_75" class="tab-back">
				<span class="tabbar-left"></span>
				<span class="content">GD11-5[1782-3.9]</span>
				<span class="tabbar-right"></span>
			 </span>
					</td>
	  </tr>
	</table>
	<BR/>	<div class="ld" style='width:97%; margin:0px 10px 0px 10px;'>
		<table class="lt" id="tabbar_txt_8_75" border="0" cellspacing="0" cellpadding="0">
		<tr class='th'>
			<td>玩法组</td>
			<td><div class='line'></div>奖级</td>
			<td><div class='line'></div>奖金</td>
						<td><div class='line'></div>返点</td>
						<td><div class='line'></div>状态</td>
		</tr>
				<tr>
			<td align="center">前三直选</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[265][0]?><br></td>
						<td align="center"><?=$rebate[249]?></td>
						<td align="center"><?=$zt[249]?></td>
		</tr>
				<tr>
			<td align="center">前三组选</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[266][0]?><br></td>
						<td align="center"><?=$rebate[250]?></td>
						<td align="center"><?=$zt[250]?></td>
		</tr>
				<tr>
			<td align="center">前二直选</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[267][0]?><br></td>
						<td align="center"><?=$rebate[251]?></td>
						<td align="center"><?=$zt[251]?></td>
		</tr>
				<tr>
			<td align="center">前二组选</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[268][0]?><br></td>
						<td align="center"><?=$rebate[252]?></td>
						<td align="center"><?=$zt[252]?></td>
		</tr>
				<tr>
			<td align="center">不定位</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[269][0]?><br></td>
						<td align="center"><?=$rebate[253]?></td>
						<td align="center"><?=$zt[253]?></td>
		</tr>
				<tr>
			<td align="center">定位胆</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[270][0]?><br></td>
						<td align="center"><?=$rebate[254]?></td>
						<td align="center"><?=$zt[254]?></td>
		</tr>
				<tr>
			<td align="center">定单双</td>
			<td align="center">5单0双<br />
4单1双<br />
3单2双<br />
2单3双<br />
1单4双<br />
0单5双<br></td>
			<td align="center"><?=$rate[273][0]?><br><?=$rate[273][1]?><br><?=$rate[273][2]?><br><?=$rate[273][3]?><br><?=$rate[273][4]?><br><?=$rate[273][5]?><br></td>
						<td align="center"><?=$rebate[255]?></td>
						<td align="center"><?=$zt[255]?></td>
		</tr>
				<tr>
			<td align="center">猜中位</td>
			<td align="center">03,09<br>04,08<br>05,07<br>06<br></td>
			<td align="center"><?=$rate[274][0]?><br><?=$rate[274][1]?><br><?=$rate[274][2]?><br><?=$rate[274][3]?><br></td>
						<td align="center"><?=$rebate[256]?></td>
						<td align="center"><?=$zt[256]?></td>
		</tr>
				<tr>
			<td align="center">任选一中一</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[275][0]?><br></td>
						<td align="center"><?=$rebate[257]?></td>
						<td align="center"><?=$zt[257]?></td>
		</tr>
				<tr>
			<td align="center">任选二中二</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[276][0]?><br></td>
						<td align="center"><?=$rebate[258]?></td>
						<td align="center"><?=$zt[258]?></td>
		</tr>
				<tr>
			<td align="center">任选三中三</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[277][0]?><br></td>
						<td align="center"><?=$rebate[259]?></td>
						<td align="center"><?=$zt[259]?></td>
		</tr>
				<tr>
			<td align="center">任选四中四</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[278][0]?><br></td>
						<td align="center"><?=$rebate[260]?></td>
						<td align="center"><?=$zt[260]?></td>
		</tr>
				<tr>
			<td align="center">任选五中五</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[279][0]?><br></td>
						<td align="center"><?=$rebate[261]?></td>
						<td align="center"><?=$zt[261]?></td>
		</tr>
				<tr>
			<td align="center">任选六中五</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[280][0]?><br></td>
						<td align="center"><?=$rebate[262]?></td>
						<td align="center"><?=$zt[262]?></td>
		</tr>
				<tr>
			<td align="center">任选七中五</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[281][0]?><br></td>
						<td align="center"><?=$rebate[263]?></td>
						<td align="center"><?=$zt[263]?></td>
		</tr>
				<tr>
			<td align="center">任选八中五</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[282][0]?><br></td>
						<td align="center"><?=$rebate[264]?></td>
						<td align="center"><?=$zt[264]?></td>
		</tr>
			</table>
		</div><BR/></div></div>
		<div class='bd'><div class='bd2' id="general_txt_9">
	<table class="tabbar-div-s3" width='100%' style="display:none;">
	  <tr>
        <td>
						 <span id="tabbar_tab_9_77" class="tab-back">
				<span class="tabbar-left"></span>
				<span class="content">FC3D[1800-6.6]</span>
				<span class="tabbar-right"></span>
			 </span>
					</td>
	  </tr>
	</table>
	<BR/>	<div class="ld" style='width:97%; margin:0px 10px 0px 10px;'>
		<table class="lt" id="tabbar_txt_9_77" border="0" cellspacing="0" cellpadding="0">
		<tr class='th'>
			<td>玩法组</td>
			<td><div class='line'></div>奖级</td>
			<td><div class='line'></div>奖金</td>
						<td><div class='line'></div>返点</td>
						<td><div class='line'></div>状态</td>
		</tr>
				<tr>
			<td align="center">直选</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[294][0]?><br></td>
						<td align="center"><?=$rebate[283]?></td>
						<td align="center"><?=$zt[283]?></td>
		</tr>
				<tr>
			<td align="center">组选</td>
			<td align="center">组三奖金<br>组六奖金<br></td>
			<td align="center"><?=$rate[298][0]?><br><?=$rate[298][1]?><br></td>
						<td align="center"><?=$rebate[284]?></td>
						<td align="center"><?=$zt[284]?></td>
		</tr>
				<tr>
			<td align="center">一码不定位</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[300][0]?><br></td>
						<td align="center"><?=$rebate[285]?></td>
						<td align="center"><?=$zt[285]?></td>
		</tr>
				<tr>
			<td align="center">二码不定位</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[301][0]?><br></td>
						<td align="center"><?=$rebate[286]?></td>
						<td align="center"><?=$zt[286]?></td>
		</tr>
				<tr>
			<td align="center">前二直选</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[302][0]?><br></td>
						<td align="center"><?=$rebate[287]?></td>
						<td align="center"><?=$zt[287]?></td>
		</tr>
				<tr>
			<td align="center">后二直选</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[303][0]?><br></td>
						<td align="center"><?=$rebate[288]?></td>
						<td align="center"><?=$zt[288]?></td>
		</tr>
				<tr>
			<td align="center">前二组选</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[304][0]?><br></td>
						<td align="center"><?=$rebate[289]?></td>
						<td align="center"><?=$zt[289]?></td>
		</tr>
				<tr>
			<td align="center">后二组选</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[305][0]?><br></td>
						<td align="center"><?=$rebate[290]?></td>
						<td align="center"><?=$zt[290]?></td>
		</tr>
				<tr>
			<td align="center">定位胆</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[306][0]?><br></td>
						<td align="center"><?=$rebate[291]?></td>
						<td align="center"><?=$zt[291]?></td>
		</tr>
				<tr>
			<td align="center">大小单双(前二)</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[309][0]?><br></td>
						<td align="center"><?=$rebate[292]?></td>
						<td align="center"><?=$zt[292]?></td>
		</tr>
				<tr>
			<td align="center">大小单双(后二)</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[310][0]?><br></td>
						<td align="center"><?=$rebate[293]?></td>
						<td align="center"><?=$zt[293]?></td>
		</tr>
			</table>
		</div><BR/></div></div>
		<div class='bd'><div class='bd2' id="general_txt_10">
	<table class="tabbar-div-s3" width='100%' style="display:none;">
	  <tr>
        <td>
						 <span id="tabbar_tab_10_80" class="tab-back">
				<span class="tabbar-left"></span>
				<span class="content">P3P5[1800-6.6]</span>
				<span class="tabbar-right"></span>
			 </span>
					</td>
	  </tr>
	</table>
	<BR/>	<div class="ld" style='width:97%; margin:0px 10px 0px 10px;'>
		<table class="lt" id="tabbar_txt_10_80" border="0" cellspacing="0" cellpadding="0">
		<tr class='th'>
			<td>玩法组</td>
			<td><div class='line'></div>奖级</td>
			<td><div class='line'></div>奖金</td>
						<td><div class='line'></div>返点</td>
						<td><div class='line'></div>状态</td>
		</tr>
				<tr>
			<td align="center">排三直选</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[322][0]?><br></td>
						<td align="center"><?=$rebate[311]?></td>
						<td align="center"><?=$zt[311]?></td>
		</tr>
				<tr>
			<td align="center">排三组选</td>
			<td align="center">组三奖金<br>组六奖金<br></td>
			<td align="center"><?=$rate[326][0]?><br><?=$rate[326][1]?><br></td>
						<td align="center"><?=$rebate[312]?></td>
						<td align="center"><?=$zt[312]?></td>
		</tr>
				<tr>
			<td align="center">一码不定位</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[328][0]?><br></td>
						<td align="center"><?=$rebate[313]?></td>
						<td align="center"><?=$zt[313]?></td>
		</tr>
				<tr>
			<td align="center">二码不定位</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[329][0]?><br></td>
						<td align="center"><?=$rebate[314]?></td>
						<td align="center"><?=$zt[314]?></td>
		</tr>
				<tr>
			<td align="center">排五前二直选</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[330][0]?><br></td>
						<td align="center"><?=$rebate[315]?></td>
						<td align="center"><?=$zt[315]?></td>
		</tr>
				<tr>
			<td align="center">排五后二直选</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[331][0]?><br></td>
						<td align="center"><?=$rebate[316]?></td>
						<td align="center"><?=$zt[316]?></td>
		</tr>
				<tr>
			<td align="center">排五前二组选</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[332][0]?><br></td>
						<td align="center"><?=$rebate[317]?></td>
						<td align="center"><?=$zt[317]?></td>
		</tr>
				<tr>
			<td align="center">排五后二组选</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[333][0]?><br></td>
						<td align="center"><?=$rebate[318]?></td>
						<td align="center"><?=$zt[318]?></td>
		</tr>
				<tr>
			<td align="center">定位胆</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[334][0]?><br></td>
						<td align="center"><?=$rebate[319]?></td>
						<td align="center"><?=$zt[319]?></td>
		</tr>
				<tr>
			<td align="center">前二大小单双</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[339][0]?><br></td>
						<td align="center"><?=$rebate[320]?></td>
						<td align="center"><?=$zt[320]?></td>
		</tr>
				<tr>
			<td align="center">后二大小单双</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[340][0]?><br></td>
						<td align="center"><?=$rebate[321]?></td>
						<td align="center"><?=$zt[321]?></td>
		</tr>
			</table>
		</div><BR/></div></div>
		<div class='bd'><div class='bd2' id="general_txt_11">
	<table class="tabbar-div-s3" width='100%' style="display:none;">
	  <tr>
        <td>
						 <span id="tabbar_tab_11_120" class="tab-back">
				<span class="tabbar-left"></span>
				<span class="content">CQ11-5[1782-3.9]</span>
				<span class="tabbar-right"></span>
			 </span>
					</td>
	  </tr>
	</table>
	<BR/>	<div class="ld" style='width:97%; margin:0px 10px 0px 10px;'>
		<table class="lt" id="tabbar_txt_11_120" border="0" cellspacing="0" cellpadding="0">
		<tr class='th'>
			<td>玩法组</td>
			<td><div class='line'></div>奖级</td>
			<td><div class='line'></div>奖金</td>
						<td><div class='line'></div>返点</td>
						<td><div class='line'></div>状态</td>
		</tr>
				<tr>
			<td align="center">前三直选</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[358][0]?><br></td>
						<td align="center"><?=$rebate[341]?></td>
						<td align="center"><?=$zt[341]?></td>
		</tr>
				<tr>
			<td align="center">前三组选</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[359][0]?><br></td>
						<td align="center"><?=$rebate[342]?></td>
						<td align="center"><?=$zt[342]?></td>
		</tr>
				<tr>
			<td align="center">前二直选</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[360][0]?><br></td>
						<td align="center"><?=$rebate[343]?></td>
						<td align="center"><?=$zt[343]?></td>
		</tr>
				<tr>
			<td align="center">前二组选</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[361][0]?><br></td>
						<td align="center"><?=$rebate[344]?></td>
						<td align="center"><?=$zt[344]?></td>
		</tr>
				<tr>
			<td align="center">不定位</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[362][0]?><br></td>
						<td align="center"><?=$rebate[345]?></td>
						<td align="center"><?=$zt[345]?></td>
		</tr>
				<tr>
			<td align="center">定位胆</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[363][0]?><br></td>
						<td align="center"><?=$rebate[346]?></td>
						<td align="center"><?=$zt[346]?></td>
		</tr>
				<tr>
			<td align="center">定单双</td>
			<td align="center">5单0双<br />
4单1双<br />
3单2双<br />
2单3双<br />
1单4双<br />
0单5双<br></td>
			<td align="center"><?=$rate[366][0]?><br><?=$rate[366][1]?><br><?=$rate[366][2]?><br><?=$rate[366][3]?><br><?=$rate[366][4]?><br><?=$rate[366][5]?><br></td>
						<td align="center"><?=$rebate[347]?></td>
						<td align="center"><?=$zt[347]?></td>
		</tr>
				<tr>
			<td align="center">猜中位</td>
			<td align="center">03,09<br>04,08<br>05,07<br>06<br></td>
			<td align="center"><?=$rate[367][0]?><br><?=$rate[367][1]?><br><?=$rate[367][2]?><br><?=$rate[367][3]?><br></td>
						<td align="center"><?=$rebate[348]?></td>
						<td align="center"><?=$zt[348]?></td>
		</tr>
				<tr>
			<td align="center">任选一中一</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[368][0]?><br></td>
						<td align="center"><?=$rebate[349]?></td>
						<td align="center"><?=$zt[349]?></td>
		</tr>
				<tr>
			<td align="center">任选二中二</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[369][0]?><br></td>
						<td align="center"><?=$rebate[350]?></td>
						<td align="center"><?=$zt[350]?></td>
		</tr>
				<tr>
			<td align="center">任选三中三</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[370][0]?><br></td>
						<td align="center"><?=$rebate[351]?></td>
						<td align="center"><?=$zt[351]?></td>
		</tr>
				<tr>
			<td align="center">任选四中四</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[371][0]?><br></td>
						<td align="center"><?=$rebate[352]?></td>
						<td align="center"><?=$zt[352]?></td>
		</tr>
				<tr>
			<td align="center">任选五中五</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[372][0]?><br></td>
						<td align="center"><?=$rebate[353]?></td>
						<td align="center"><?=$zt[353]?></td>
		</tr>
				<tr>
			<td align="center">任选六中五</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[373][0]?><br></td>
						<td align="center"><?=$rebate[354]?></td>
						<td align="center"><?=$zt[354]?></td>
		</tr>
				<tr>
			<td align="center">任选七中五</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[374][0]?><br></td>
						<td align="center"><?=$rebate[355]?></td>
						<td align="center"><?=$zt[355]?></td>
		</tr>
				<tr>
			<td align="center">任选八中五</td>
			<td align="center">奖金<br></td>
			<td align="center"><?=$rate[375][0]?><br></td>
						<td align="center"><?=$rebate[356]?></td>
						<td align="center"><?=$zt[356]?></td>
		</tr>
			</table>
		</div><BR/></div></div>
	</div></div>

<BR/><div class="div_s1" style='line-height:22px;'>
<table STYLE='background-color:#E3E3E3;' width="100%" align="center" border="0" cellspacing="0" cellpadding="0">
<tr><td align="center"><font color='#333333'>浏览器建议：首选IE 8.0浏览器，其次为火狐浏览器。</font><br/>
</td></tr></table>
</div></CENTER><br/><br/>
<?php echo $count?>
</BODY></HTML>