<?php
session_start();
error_reporting(0);
require_once 'conn.php';
require_once 'check.php';

if(Get_member(cardlock)=="1"){
	$_SESSION["backtitle"]="您的银行卡资料已锁定";
	$_SESSION["backurl"]="account_banks.php?check=114";
	$_SESSION["backzt"]="failed";
	$_SESSION["backname"]="我的银行卡";
	echo "<script language=javascript>window.location='sysmessage.php';</script>";
	exit;
}
$sql = "select * from ssc_bankcard WHERE username='" . $_SESSION["username"] . "' order by id asc";
$rs = mysql_query($sql);
$banknums=mysql_num_rows($rs);
if($banknums>=5){
	$_SESSION["backtitle"]="您已经绑定了5张银行卡";
	$_SESSION["backurl"]="account_banks.php?check=114";
	$_SESSION["backzt"]="failed";
	$_SESSION["backname"]="我的银行卡";
	echo "<script language=javascript>window.location='sysmessage.php';</script>";
	exit;
}
if($banknums>0){
	if($_SESSION["cardflag"]!="ok"){
		$_SESSION["cardurl"]="account_cardadd.php";
		echo "<script language=javascript>window.location='account_confirm.php';</script>";
		exit;
	}
	$_SESSION["cardflag"]="";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD><TITLE><?php echo $webname;?>  - 增加银行卡</TITLE>
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
<BODY STYLE="background:#FFF url('images/v1/main_bg_0001.jpg') 0px -490px repeat-x; padding:10px;">
 

<DIV ID='main_box'>
<div class="box l"></div>
<div class="box c"></div>
<div class="box r"></div>
<div class="box m">

<H1><SPAN class="action-span"><A href="account_banks.php?check=114" target='_self'>我的银行卡</a></SPAN>
<SPAN class="action-span1"><DIV class='tubiao'></DIV>当前位置: <A href="/" target='_top'><?php echo $webname;?></a>
 - 增加银行卡 </SPAN><DIV style="clear:both"></DIV></H1>
<link href="js/keyboard/css/jquery-ui.css" rel="stylesheet">
<link href="js/keyboard/css/keyboard.css" rel="stylesheet">
<script src="js/keyboard/jquery.min.js"></script>
<script src="js/keyboard/jquery-ui.min.js"></script>
<script src="js/keyboard/jquery.keyboard.js"></script>
<script src="js/keyboard/keyboard.js"></script>
<script> 
$(function(){
	getNumKeyBoard($('#cardno,#cardno_again'));
});
</script>
<script type="text/javascript">
jQuery("document").ready( function(){
	/*checkname = function(){
		var nickname = $("#nickname").val();
		document.getElementById("nnchecked").value = 0;
		if (nickname != ""){
			$("#nick_msg").html("正在提交检查, 请稍候...");
			$.ajax({
				type:"POST",
				url:'./account_cardadd.php',
				data:'flag=checkname&nickname=' + nickname+'&check=855',
				success:function(data){
					if (data == 'error1'){
						$("#nick_msg").html("<font color='red'>别名格式错误, 由1至10个字符或汉字组成, 不能使用特殊字符</font>");
						document.getElementById("nnchecked").value = 0;
					}else if(data=='successed'){
						$("#nick_msg").html("<font color='green'>别名可以使用</font>");
						document.getElementById("nnchecked").value = 1;
					}else{
						$("#nick_msg").html("<font color='red'>别名已存在, 请更换</font>");
						document.getElementById("nnchecked").value = 0;
					}
				}
			});
		} else {
			$("#nick_msg").html("&nbsp;( 自定义银行卡名字, 由1至10个字符或汉字组成, 不能使用特殊字符 )");
		}
	}*/
	
	$("#bank").change(function(){
		id = parseInt($(this).val(),10);
		if( id==19){
			$("tr[title='bankinfo']").hide();
			$("span[id^='banknameinfo']").html("财付通号码");
			$("#cardno_msg").html("( 财付通号码由5-14位数字组成 )");
			$("#cardno_again_msg").html("( 财付通确认号码由只能手动输入, 不能粘贴 )");
		}else if( id==7){
			$("tr[title='bankinfo']").hide();
			$("span[id^='banknameinfo']").html("支付宝账号");
			$("#cardno_msg").html("( 支付宝账号由手机号码或邮箱组成 )");
			$("#cardno_again_msg").html("( 支付宝确认账号由只能手动输入, 不能粘贴 )");
		}else{
			$("tr[title='bankinfo']").show();
			if( id != 2 ){
				$("tr[class='branch']").hide();
			}
			$("span[id^='banknameinfo']").html("银行账号");
			$("#cardno_msg").html("( 银行卡账号由16位或19位数字组成 )");
			$("#cardno_again_msg").html("( 银行账号只能手动输入, 不能粘贴 )");
		}
	});
});
var cityarr = {"1":{"1":"\u5317\u4eac\u5e02"},"6":{"18":"\u5927\u540c\u5e02","180":"\u592a\u539f\u5e02","182":"\u9633\u6cc9\u5e02","183":"\u957f\u6cbb\u5e02","184":"\u664b\u57ce\u5e02","185":"\u6714\u5dde\u5e02","186":"\u53e4\u4ea4\u5e02","187":"\u5ffb\u5dde\u5e02","189":"\u4e34\u6c7e\u5e02","191":"\u970d\u5dde\u5e02","192":"\u8fd0\u57ce\u5e02","205":"\u6f5e\u57ce\u5e02","209":"\u9ad8\u5e73\u5e02","228":"\u539f\u5e73\u5e02","242":"\u4ecb\u4f11\u5e02","251":"\u6c7e\u9633\u5e02","254":"\u5b5d\u4e49\u5e02","276":"\u6cb3\u6d25\u5e02","277":"\u6c38\u6d4e\u5e02","2314":"\u4faf\u9a6c\u5e02","2601":"\u664b\u4e2d\u5e02","2643":"\u5415\u6881\u5e02"},"2":{"19":"\u4e0a\u6d77\u5e02"},"3":{"40":"\u5929\u6d25\u5e02"},"4":{"58":"\u91cd\u5e86\u5e02"},"5":{"99":"\u547c\u548c\u6d69\u7279\u5e02","100":"\u5305\u5934\u5e02","101":"\u4e4c\u6d77\u5e02","102":"\u8d64\u5cf0\u5e02","104":"\u4e30\u9547\u5e02","105":"\u9521\u6797\u6d69\u7279\u5e02","106":"\u4e8c\u8fde\u6d69\u7279\u5e02","108":"\u6ee1\u5dde\u91cc\u5e02","109":"\u7259\u514b\u77f3\u5e02","110":"\u624e\u5170\u5c6f\u5e02","111":"\u901a\u8fbd\u5e02","112":"\u970d\u6797\u90ed\u52d2\u5e02","2346":"\u4e4c\u5170\u6d69\u7279\u5e02","2626":"\u9102\u5c14\u591a\u65af\u5e02","2627":"\u547c\u4f26\u8d1d\u5c14\u5e02","2628":"\u5df4\u5f66\u6dd6\u5c14\u5e02","2629":"\u4e4c\u5170\u5bdf\u5e03\u5e02","2630":"\u5174\u5b89\u76df","2631":"\u9521\u6797\u90ed\u52d2\u76df","2632":"\u963f\u62c9\u5584\u76df","2633":"\u6839\u6cb3\u5e02","2634":"\u989d\u5c14\u53e4\u7eb3\u5e02","2635":"\u963f\u5c14\u5c71\u5e02"},"7":{"284":"\u77f3\u5bb6\u5e84\u5e02","285":"\u90af\u90f8\u5e02","286":"\u90a2\u53f0\u5e02","287":"\u4fdd\u5b9a\u5e02","288":"\u5f20\u5bb6\u53e3\u5e02","289":"\u627f\u5fb7\u5e02","290":"\u5510\u5c71\u5e02","291":"\u79e6\u7687\u5c9b\u5e02","292":"\u6ca7\u5dde\u5e02","293":"\u5eca\u574a\u5e02","294":"\u6b66\u5b89\u5e02","295":"\u9738\u5dde\u5e02","296":"\u6cca\u5934\u5e02","297":"\u4efb\u4e18\u5e02","298":"\u9ec4\u9a85\u5e02","299":"\u6cb3\u95f4\u5e02","300":"\u8861\u6c34\u5e02","312":"\u8fc1\u5b89\u5e02","317":"\u9075\u5316\u5e02","327":"\u4e09\u6cb3\u5e02","2234":"\u5b9a\u5dde\u5e02","2235":"\u5b89\u56fd\u5e02","2240":"\u6dbf\u5dde\u5e02","2241":"\u9ad8\u7891\u5e97\u5e02","2253":"\u8f9b\u96c6\u5e02","2254":"\u664b\u5dde\u5e02","2255":"\u85c1\u57ce\u5e02","2256":"\u65b0\u4e50\u5e02","2257":"\u9e7f\u6cc9\u5e02","2268":"\u6c99\u6cb3\u5e02","2271":"\u5357\u5bab\u5e02","2277":"\u5180\u5dde\u5e02","2278":"\u6df1\u5dde\u5e02"},"8":{"352":"\u6c88\u9633\u5e02","353":"\u5927\u8fde\u5e02","354":"\u978d\u5c71\u5e02","355":"\u629a\u987a\u5e02","356":"\u672c\u6eaa\u5e02","357":"\u4e39\u4e1c\u5e02","358":"\u9526\u5dde\u5e02","359":"\u846b\u82a6\u5c9b\u5e02","360":"\u8425\u53e3\u5e02","361":"\u961c\u65b0\u5e02","362":"\u8fbd\u9633\u5e02","363":"\u94c1\u5cad\u5e02","364":"\u671d\u9633\u5e02","365":"\u74e6\u623f\u5e97\u5e02","366":"\u6d77\u57ce\u5e02","367":"\u5174\u57ce\u5e02","368":"\u8c03\u5175\u5c71\u5e02","369":"\u5317\u7968\u5e02","370":"\u5f00\u539f\u5e02","371":"\u65b0\u6c11\u5e02","374":"\u5e84\u6cb3\u5e02","384":"\u51e4\u57ce\u5e02","389":"\u5317\u9547\u5e02","397":"\u706f\u5854\u5e02","404":"\u51cc\u6e90\u5e02","2207":"\u76d8\u9526\u5e02","2347":"\u76d6\u5dde\u5e02","2351":"\u4e1c\u6e2f\u5e02","2534":"\u666e\u5170\u5e97\u5e02","2535":"\u51cc\u6d77\u5e02","2625":"\u5927\u77f3\u6865\u5e02"},"9":{"407":"\u957f\u6625\u5e02","408":"\u5409\u6797\u5e02","409":"\u56db\u5e73\u5e02","410":"\u8fbd\u6e90\u5e02","411":"\u901a\u5316\u5e02","413":"\u516c\u4e3b\u5cad\u5e02","414":"\u6885\u6cb3\u53e3\u5e02","415":"\u96c6\u5b89\u5e02","416":"\u4e5d\u53f0\u5e02","417":"\u6866\u7538\u5e02","418":"\u86df\u6cb3\u5e02","419":"\u6986\u6811\u5e02","420":"\u767d\u57ce\u5e02","421":"\u6d2e\u5357\u5e02","423":"\u5927\u5b89\u5e02","424":"\u5ef6\u5409\u5e02","425":"\u56fe\u4eec\u5e02","426":"\u6566\u5316\u5e02","427":"\u9f99\u4e95\u5e02","428":"\u73f2\u6625\u5e02","431":"\u5fb7\u60e0\u5e02","433":"\u78d0\u77f3\u5e02","434":"\u8212\u5170\u5e02","436":"\u53cc\u8fbd\u5e02","453":"\u548c\u9f99\u5e02","2352":"\u767d\u5c71\u5e02","2353":"\u677e\u539f\u5e02","2354":"\u4e34\u6c5f\u5e02","2623":"\u5ef6\u8fb9\u671d\u9c9c\u65cf\u81ea\u6cbb\u5dde"},"10":{"454":"\u54c8\u5c14\u6ee8\u5e02","455":"\u9f50\u9f50\u54c8\u5c14\u5e02","456":"\u9e64\u5c97\u5e02","457":"\u53cc\u9e2d\u5c71\u5e02","458":"\u9e21\u897f\u5e02","459":"\u5927\u5e86\u5e02","460":"\u4f0a\u6625\u5e02","461":"\u7261\u4e39\u6c5f\u5e02","462":"\u4f73\u6728\u65af\u5e02","463":"\u4e03\u53f0\u6cb3\u5e02","464":"\u7ee5\u82ac\u6cb3\u5e02","466":"\u540c\u6c5f\u5e02","467":"\u5bcc\u9526\u5e02","468":"\u94c1\u529b\u5e02","469":"\u5bc6\u5c71\u5e02","470":"\u7ee5\u5316\u5e02","471":"\u5b89\u8fbe\u5e02","472":"\u8087\u4e1c\u5e02","473":"\u6d77\u4f26\u5e02","474":"\u9ed1\u6cb3\u5e02","475":"\u5317\u5b89\u5e02","476":"\u4e94\u5927\u8fde\u6c60\u5e02","477":"\u5c1a\u5fd7\u5e02","478":"\u53cc\u57ce\u5e02","483":"\u8bb7\u6cb3\u5e02","499":"\u6d77\u6797\u5e02","500":"\u7a46\u68f1\u5e02","501":"\u864e\u6797\u5e02","502":"\u5b81\u5b89\u5e02","528":"\u4e94\u5e38\u5e02","534":"\u5927\u5174\u5b89\u5cad\u5730\u533a"},"11":{"535":"\u5357\u4eac\u5e02","536":"\u5f90\u5dde\u5e02","537":"\u8fde\u4e91\u6e2f\u5e02","539":"\u76d0\u57ce\u5e02","540":"\u626c\u5dde\u5e02","541":"\u5357\u901a\u5e02","542":"\u9547\u6c5f\u5e02","544":"\u5e38\u5dde\u5e02","545":"\u65e0\u9521\u5e02","546":"\u82cf\u5dde\u5e02","547":"\u6cf0\u5dde\u5e02","548":"\u4eea\u5f81\u5e02","549":"\u5e38\u719f\u5e02","550":"\u5f20\u5bb6\u6e2f\u5e02","551":"\u6c5f\u9634\u5e02","552":"\u5bbf\u8fc1\u5e02","553":"\u4e39\u9633\u5e02","554":"\u4e1c\u53f0\u5e02","555":"\u5174\u5316\u5e02","556":"\u6dee\u5b89\u5e02","557":"\u5b9c\u5174\u5e02","558":"\u6606\u5c71\u5e02","559":"\u542f\u4e1c\u5e02","560":"\u65b0\u6c82\u5e02","561":"\u6ea7\u9633\u5e02","589":"\u5927\u4e30\u5e02","592":"\u6cf0\u5174\u5e02","594":"\u6c5f\u90fd\u5e02","595":"\u9756\u6c5f\u5e02","596":"\u9ad8\u90ae\u5e02","598":"\u5982\u768b\u5e02","600":"\u6d77\u95e8\u5e02","603":"\u53e5\u5bb9\u5e02","604":"\u626c\u4e2d\u5e02","606":"\u91d1\u575b\u5e02","609":"\u5434\u6c5f\u5e02","610":"\u592a\u4ed3\u5e02","2211":"\u901a\u5dde\u5e02","2359":"\u90b3\u5dde\u5e02","2624":"\u59dc\u5830\u5e02"},"12":{"611":"\u5408\u80a5\u5e02","612":"\u6dee\u5357\u5e02","613":"\u6dee\u5317\u5e02","614":"\u829c\u6e56\u5e02","615":"\u94dc\u9675\u5e02","616":"\u868c\u57e0\u5e02","617":"\u9a6c\u978d\u5c71\u5e02","618":"\u5b89\u5e86\u5e02","619":"\u9ec4\u5c71\u5e02","620":"\u5bbf\u5dde\u5e02","621":"\u6ec1\u5dde\u5e02","622":"\u5de2\u6e56\u5e02","626":"\u516d\u5b89\u5e02","627":"\u961c\u9633\u5e02","628":"\u6beb\u5dde\u5e02","629":"\u754c\u9996\u5e02","643":"\u6850\u57ce\u5e02","663":"\u5929\u957f\u5e02","671":"\u5b81\u56fd\u5e02","2366":"\u660e\u5149\u5e02","2368":"\u5ba3\u57ce\u5e02","2602":"\u6c60\u5dde\u5e02"},"13":{"692":"\u6d4e\u5357\u5e02","693":"\u9752\u5c9b\u5e02","694":"\u6dc4\u535a\u5e02","695":"\u67a3\u5e84\u5e02","696":"\u4e1c\u8425\u5e02","698":"\u70df\u53f0\u5e02","699":"\u5a01\u6d77\u5e02","700":"\u6d4e\u5b81\u5e02","701":"\u6cf0\u5b89\u5e02","702":"\u65e5\u7167\u5e02","703":"\u9752\u5dde\u5e02","704":"\u9f99\u53e3\u5e02","705":"\u66f2\u961c\u5e02","706":"\u83b1\u829c\u5e02","707":"\u65b0\u6cf0\u5e02","708":"\u80f6\u5dde\u5e02","709":"\u8bf8\u57ce\u5e02","710":"\u83b1\u9633\u5e02","711":"\u83b1\u5dde\u5e02","712":"\u6ed5\u5dde\u5e02","713":"\u6587\u767b\u5e02","714":"\u8363\u6210\u5e02","715":"\u5373\u58a8\u5e02","716":"\u5e73\u5ea6\u5e02","717":"\u83b1\u897f\u5e02","718":"\u80f6\u5357\u5e02","719":"\u5fb7\u5dde\u5e02","720":"\u4e50\u9675\u5e02","721":"\u6ee8\u5dde\u5e02","722":"\u4e34\u6c82\u5e02","724":"\u804a\u57ce\u5e02","725":"\u4e34\u6e05\u5e02","726":"\u7ae0\u4e18\u5e02","737":"\u660c\u9091\u5e02","739":"\u9ad8\u5bc6\u5e02","742":"\u5b89\u4e18\u5e02","743":"\u5bff\u5149\u5e02","745":"\u62db\u8fdc\u5e02","746":"\u6816\u971e\u5e02","747":"\u6d77\u9633\u5e02","748":"\u84ec\u83b1\u5e02","750":"\u4e73\u5c71\u5e02","751":"\u5156\u5dde\u5e02","762":"\u80a5\u57ce\u5e02","766":"\u79b9\u57ce\u5e02","2208":"\u6f4d\u574a\u5e02","2209":"\u83cf\u6cfd\u5e02","2396":"\u90b9\u57ce\u5e02"},"14":{"802":"\u676d\u5dde\u5e02","803":"\u5b81\u6ce2\u5e02","804":"\u6e29\u5dde\u5e02","805":"\u5609\u5174\u5e02","806":"\u6e56\u5dde\u5e02","807":"\u7ecd\u5174\u5e02","808":"\u91d1\u534e\u5e02","809":"\u8862\u5dde\u5e02","810":"\u821f\u5c71\u5e02","811":"\u4f59\u59da\u5e02","812":"\u6d77\u5b81\u5e02","813":"\u5170\u6eaa\u5e02","814":"\u745e\u5b89\u5e02","816":"\u6c5f\u5c71\u5e02","818":"\u4e1c\u9633\u5e02","819":"\u4e49\u4e4c\u5e02","820":"\u6148\u6eaa\u5e02","821":"\u5949\u5316\u5e02","822":"\u8bf8\u66a8\u5e02","824":"\u4e34\u6d77\u5e02","826":"\u4e3d\u6c34\u5e02","827":"\u9f99\u6cc9\u5e02","829":"\u4e34\u5b89\u5e02","831":"\u5bcc\u9633\u5e02","832":"\u5efa\u5fb7\u5e02","843":"\u4e50\u6e05\u5e02","846":"\u5e73\u6e56\u5e02","848":"\u6850\u4e61\u5e02","855":"\u4e0a\u865e\u5e02","858":"\u6c38\u5eb7\u5e02","869":"\u6e29\u5cad\u5e02","2216":"\u53f0\u5dde\u5e02","2361":"\u5d4a\u5dde\u5e02"},"15":{"879":"\u5357\u660c\u5e02","880":"\u666f\u5fb7\u9547\u5e02","881":"\u840d\u4e61\u5e02","882":"\u65b0\u4f59\u5e02","883":"\u4e5d\u6c5f\u5e02","884":"\u9e70\u6f6d\u5e02","885":"\u745e\u660c\u5e02","886":"\u4e0a\u9976\u5e02","887":"\u5fb7\u5174\u5e02","888":"\u5b9c\u6625\u5e02","889":"\u4e30\u57ce\u5e02","890":"\u6a1f\u6811\u5e02","892":"\u5409\u5b89\u5e02","894":"\u8d63\u5dde\u5e02","899":"\u4e50\u5e73\u5e02","911":"\u8d35\u6eaa\u5e02","925":"\u9ad8\u5b89\u5e02","957":"\u5357\u5eb7\u5e02","964":"\u745e\u91d1\u5e02","2376":"\u4e95\u5188\u5c71\u5e02","2377":"\u629a\u5dde\u5e02"},"16":{"969":"\u798f\u5dde\u5e02","970":"\u53a6\u95e8\u5e02","971":"\u4e09\u660e\u5e02","972":"\u8386\u7530\u5e02","973":"\u6cc9\u5dde\u5e02","974":"\u6f33\u5dde\u5e02","975":"\u6c38\u5b89\u5e02","976":"\u77f3\u72ee\u5e02","977":"\u798f\u6e05\u5e02","978":"\u5357\u5e73\u5e02","979":"\u90b5\u6b66\u5e02","980":"\u6b66\u5937\u5c71\u5e02","981":"\u5b81\u5fb7\u5e02","982":"\u798f\u5b89\u5e02","983":"\u9f99\u5ca9\u5e02","984":"\u6f33\u5e73\u5e02","991":"\u957f\u4e50\u5e02","1007":"\u5357\u5b89\u5e02","1008":"\u664b\u6c5f\u5e02","1011":"\u9f99\u6d77\u5e02","1020":"\u5efa\u9633\u5e02","1023":"\u5efa\u74ef\u5e02","1032":"\u798f\u9f0e\u5e02"},"17":{"1040":"\u957f\u6c99\u5e02","1041":"\u682a\u6d32\u5e02","1042":"\u6e58\u6f6d\u5e02","1043":"\u8861\u9633\u5e02","1044":"\u5cb3\u9633\u5e02","1045":"\u5e38\u5fb7\u5e02","1046":"\u5f20\u5bb6\u754c\u5e02","1047":"\u91b4\u9675\u5e02","1048":"\u6e58\u4e61\u5e02","1051":"\u6d25\u5e02\u5e02","1052":"\u97f6\u5c71\u5e02","1053":"\u90f4\u5dde\u5e02","1054":"\u8d44\u5174\u5e02","1055":"\u6c38\u5dde\u5e02","1057":"\u5a04\u5e95\u5e02","1058":"\u51b7\u6c34\u6c5f\u5e02","1059":"\u6d9f\u6e90\u5e02","1060":"\u6000\u5316\u5e02","1061":"\u6d2a\u6c5f\u5e02","1062":"\u76ca\u9633\u5e02","1063":"\u6c85\u6c5f\u5e02","1064":"\u5409\u9996\u5e02","1068":"\u6d4f\u9633\u5e02","1076":"\u6b66\u5188\u5e02","1080":"\u90b5\u9633\u5e02","1086":"\u4e34\u6e58\u5e02","2416":"\u8012\u9633\u5e02","2421":"\u5e38\u5b81\u5e02","2621":"\u6e58\u897f\u571f\u5bb6\u65cf\u82d7\u65cf\u81ea\u6cbb\u5dde","2622":"\u6c68\u7f57\u5e02"},"18":{"1138":"\u6b66\u6c49\u5e02","1139":"\u9ec4\u77f3\u5e02","1140":"\u8944\u6a0a\u5e02","1142":"\u8346\u5dde\u5e02","1144":"\u8346\u95e8\u5e02","1145":"\u9102\u5dde\u5e02","1146":"\u968f\u5dde\u5e02","1147":"\u8001\u6cb3\u53e3\u5e02","1148":"\u67a3\u9633\u5e02","1149":"\u5b5d\u611f\u5e02","1150":"\u5e94\u57ce\u5e02","1151":"\u5b89\u9646\u5e02","1152":"\u5e7f\u6c34\u5e02","1153":"\u9ebb\u57ce\u5e02","1154":"\u6b66\u7a74\u5e02","1156":"\u54b8\u5b81\u5e02","1158":"\u4ed9\u6843\u5e02","1159":"\u77f3\u9996\u5e02","1160":"\u5929\u95e8\u5e02","1161":"\u6d2a\u6e56\u5e02","1162":"\u6f5c\u6c5f\u5e02","1163":"\u5b9c\u660c\u5e02","1165":"\u5f53\u9633\u5e02","1166":"\u5341\u5830\u5e02","1167":"\u4e39\u6c5f\u53e3\u5e02","1168":"\u6069\u65bd\u5e02","1169":"\u5229\u5ddd\u5e02","1180":"\u795e\u519c\u67b6\u6797\u533a","1181":"\u6c49\u5ddd\u5e02","1197":"\u949f\u7965\u5e02","1201":"\u677e\u6ecb\u5e02","1206":"\u679d\u6c5f\u5e02","2410":"\u5927\u51b6\u5e02","2412":"\u9ec4\u5188\u5e02","2618":"\u6069\u65bd\u571f\u5bb6\u65cf\u82d7\u65cf\u81ea\u6cbb\u5dde","2619":"\u5b9c\u90fd\u5e02","2620":"\u8d64\u58c1\u5e02"},"19":{"1220":"\u90d1\u5dde\u5e02","1221":"\u5f00\u5c01\u5e02","1222":"\u6d1b\u9633\u5e02","1223":"\u5e73\u9876\u5c71\u5e02","1224":"\u7126\u4f5c\u5e02","1225":"\u9e64\u58c1\u5e02","1226":"\u65b0\u4e61\u5e02","1227":"\u5b89\u9633\u5e02","1228":"\u6fee\u9633\u5e02","1229":"\u8bb8\u660c\u5e02","1230":"\u6f2f\u6cb3\u5e02","1231":"\u4e09\u95e8\u5ce1\u5e02","1232":"\u4e49\u9a6c\u5e02","1233":"\u6c5d\u5dde\u5e02","1234":"\u6d4e\u6e90\u5e02","1235":"\u79b9\u5dde\u5e02","1236":"\u536b\u8f89\u5e02","1237":"\u8f89\u53bf\u5e02","1238":"\u6c81\u9633\u5e02","1239":"\u821e\u94a2\u5e02","1240":"\u5546\u4e18\u5e02","1241":"\u5468\u53e3\u5e02","1242":"\u9a7b\u9a6c\u5e97\u5e02","1243":"\u4fe1\u9633\u5e02","1244":"\u5357\u9633\u5e02","1245":"\u9093\u5dde\u5e02","1246":"\u8365\u9633\u5e02","1247":"\u767b\u5c01\u5e02","1249":"\u65b0\u90d1\u5e02","1260":"\u5043\u5e08\u5e02","1295":"\u957f\u845b\u5e02","1300":"\u7075\u5b9d\u5e02","1308":"\u6c38\u57ce\u5e02","1320":"\u9879\u57ce\u5e02","2398":"\u5de9\u4e49\u5e02","2403":"\u6797\u5dde\u5e02","2616":"\u65b0\u5bc6\u5e02","2617":"\u5b5f\u5dde\u5e02"},"20":{"1350":"\u5e7f\u5dde\u5e02","1351":"\u6df1\u5733\u5e02","1352":"\u73e0\u6d77\u5e02","1353":"\u6c55\u5934\u5e02","1354":"\u97f6\u5173\u5e02","1355":"\u6cb3\u6e90\u5e02","1356":"\u6885\u5dde\u5e02","1357":"\u60e0\u5dde\u5e02","1358":"\u6c55\u5c3e\u5e02","1359":"\u4e1c\u839e\u5e02","1360":"\u4e2d\u5c71\u5e02","1361":"\u6c5f\u95e8\u5e02","1362":"\u4f5b\u5c71\u5e02","1363":"\u9633\u6c5f\u5e02","1364":"\u6e5b\u6c5f\u5e02","1365":"\u8302\u540d\u5e02","1366":"\u8087\u5e86\u5e02","1367":"\u6e05\u8fdc\u5e02","1368":"\u6f6e\u5dde\u5e02","1370":"\u4ece\u5316\u5e02","1371":"\u589e\u57ce\u5e02","1382":"\u63ed\u9633\u5e02","1384":"\u5357\u96c4\u5e02","1389":"\u4e50\u660c\u5e02","1400":"\u5174\u5b81\u5e02","1408":"\u9646\u4e30\u5e02","1410":"\u53f0\u5c71\u5e02","1411":"\u5f00\u5e73\u5e02","1412":"\u6069\u5e73\u5e02","1413":"\u9e64\u5c71\u5e02","1419":"\u9633\u6625\u5e02","1420":"\u5434\u5ddd\u5e02","1424":"\u5ec9\u6c5f\u5e02","1425":"\u9ad8\u5dde\u5e02","1426":"\u4fe1\u5b9c\u5e02","1428":"\u5316\u5dde\u5e02","1429":"\u9ad8\u8981\u5e02","1431":"\u56db\u4f1a\u5e02","1433":"\u7f57\u5b9a\u5e02","1434":"\u4e91\u6d6e\u5e02","1439":"\u82f1\u5fb7\u5e02","2425":"\u8fde\u5dde\u5e02","2428":"\u666e\u5b81\u5e02","2607":"\u96f7\u5dde\u5e02"},"21":{"1446":"\u6d77\u53e3\u5e02","1447":"\u4e09\u4e9a\u5e02","1448":"\u4e94\u6307\u5c71\u5e02","1450":"\u6587\u660c\u5e02","1451":"\u743c\u6d77\u5e02","1452":"\u4e07\u5b81\u5e02","1460":"\u4e1c\u65b9\u5e02","2615":"\u510b\u5dde\u5e02"},"22":{"1465":"\u5357\u5b81\u5e02","1466":"\u67f3\u5dde\u5e02","1467":"\u6842\u6797\u5e02","1468":"\u68a7\u5dde\u5e02","1469":"\u5317\u6d77\u5e02","1470":"\u51ed\u7965\u5e02","1471":"\u5408\u5c71\u5e02","1472":"\u7389\u6797\u5e02","1473":"\u8d35\u6e2f\u5e02","1474":"\u767e\u8272\u5e02","1475":"\u6cb3\u6c60\u5e02","1488":"\u5d07\u5de6\u5e02","1497":"\u6765\u5bbe\u5e02","1515":"\u5c91\u6eaa\u5e02","1517":"\u8d3a\u5dde\u5e02","1521":"\u6842\u5e73\u5e02","1522":"\u5317\u6d41\u5e02","2430":"\u94a6\u5dde\u5e02","2435":"\u9632\u57ce\u6e2f\u5e02","2608":"\u5b9c\u5dde\u5e02","2609":"\u4e1c\u5174\u5e02"},"23":{"1546":"\u8d35\u9633\u5e02","1547":"\u516d\u76d8\u6c34\u5e02","1548":"\u9075\u4e49\u5e02","1549":"\u8d64\u6c34\u5e02","1550":"\u94dc\u4ec1\u5e02","1552":"\u5b89\u987a\u5e02","1553":"\u5174\u4e49\u5e02","1554":"\u51ef\u91cc\u5e02","1555":"\u90fd\u5300\u5e02","1563":"\u4ec1\u6000\u5e02","1581":"\u6bd5\u8282\u5e02","1594":"\u6e05\u9547\u5e02","1627":"\u798f\u6cc9\u5e02","2610":"\u9ed4\u897f\u5357\u5e03\u4f9d\u65cf\u82d7\u65cf\u81ea\u6cbb\u5dde","2611":"\u9ed4\u4e1c\u5357\u82d7\u65cf\u4f97\u65cf\u81ea\u6cbb\u5dde","2612":"\u9ed4\u5357\u5e03\u4f9d\u65cf\u82d7\u65cf\u81ea\u6cbb\u5dde","2613":"\u94dc\u4ec1\u5730\u533a","2614":"\u6bd5\u8282\u5730\u533a"},"24":{"1631":"\u6210\u90fd\u5e02","1632":"\u81ea\u8d21\u5e02","1633":"\u6500\u679d\u82b1\u5e02","1634":"\u6cf8\u5dde\u5e02","1635":"\u5fb7\u9633\u5e02","1636":"\u7ef5\u9633\u5e02","1637":"\u5e7f\u5143\u5e02","1638":"\u9042\u5b81\u5e02","1639":"\u5185\u6c5f\u5e02","1640":"\u4e50\u5c71\u5e02","1641":"\u5357\u5145\u5e02","1642":"\u5b9c\u5bbe\u5e02","1643":"\u5e7f\u5b89\u5e02","1644":"\u5e7f\u6c49\u5e02","1645":"\u897f\u660c\u5e02","1646":"\u6c5f\u6cb9\u5e02","1647":"\u5f6d\u5dde\u5e02","1648":"\u5d07\u5dde\u5e02","1649":"\u90fd\u6c5f\u5830\u5e02","1651":"\u5df4\u4e2d\u5e02","1652":"\u96c5\u5b89\u5e02","1653":"\u7709\u5c71\u5e02","1654":"\u963f\u575d\u85cf\u65cf\u7f8c\u65cf\u81ea\u6cbb\u5dde","1655":"\u7518\u5b5c\u85cf\u65cf\u81ea\u6cbb\u5dde","1656":"\u51c9\u5c71\u5f5d\u65cf\u81ea\u6cbb\u5dde","2452":"\u909b\u5d03\u5e02","2459":"\u5ce8\u7709\u5c71\u5e02","2467":"\u7b80\u9633\u5e02","2472":"\u7ef5\u7af9\u5e02","2473":"\u4ec0\u90a1\u5e02","2489":"\u8d44\u9633\u5e02","2645":"\u8fbe\u5dde\u5e02","2646":"\u9606\u4e2d\u5e02","2647":"\u534e\u84e5\u5e02","2648":"\u4e07\u6e90\u5e02"},"25":{"1659":"\u6606\u660e\u5e02","1661":"\u662d\u901a\u5e02","1662":"\u66f2\u9756\u5e02","1663":"\u7389\u6eaa\u5e02","1664":"\u4fdd\u5c71\u5e02","1665":"\u4e2a\u65e7\u5e02","1666":"\u5f00\u8fdc\u5e02","1667":"\u695a\u96c4\u5e02","1668":"\u5927\u7406\u5e02","1675":"\u5b89\u5b81\u5e02","1688":"\u5ba3\u5a01\u5e02","1706":"\u666e\u6d31\u5e02","1714":"\u4e34\u6ca7\u5e02","1728":"\u4e3d\u6c5f\u5e02","1749":"\u666f\u6d2a\u5e02","1772":"\u6f5e\u897f\u5e02","1775":"\u745e\u4e3d\u5e02","2670":"\u897f\u53cc\u7248\u7eb3\u50a3\u65cf\u81ea\u6cbb\u5dde","2671":"\u5fb7\u5b8f\u50a3\u65cf\u666f\u9887\u65cf\u81ea\u6cbb\u5dde","2672":"\u6012\u6c5f\u5088\u50f3\u65cf\u81ea\u6cbb\u5dde","2673":"\u8fea\u5e86\u85cf\u65cf\u81ea\u6cbb\u5dde","2674":"\u6587\u5c71\u58ee\u65cf\u82d7\u65cf\u81ea\u6cbb\u5dde","2675":"\u7ea2\u6cb3\u54c8\u5c3c\u65cf\u5f5d\u65cf\u81ea\u6cbb\u5dde","2676":"\u695a\u96c4\u5f5d\u65cf\u81ea\u6cbb\u5dde","2677":"\u5927\u7406\u767d\u65cf\u81ea\u6cbb\u5dde"},"26":{"1785":"\u897f\u5b89\u5e02","1787":"\u5b9d\u9e21\u5e02","1788":"\u54b8\u9633\u5e02","1789":"\u6986\u6797\u5e02","1790":"\u5ef6\u5b89\u5e02","1791":"\u6e2d\u5357\u5e02","1792":"\u97e9\u57ce\u5e02","1793":"\u534e\u9634\u5e02","1795":"\u5b89\u5eb7\u5e02","1796":"\u6c49\u4e2d\u5e02","1820":"\u5174\u5e73\u5e02","2505":"\u94dc\u5ddd\u5e02","2644":"\u5546\u6d1b\u5e02"},"27":{"1882":"\u5170\u5dde\u5e02","1883":"\u91d1\u660c\u5e02","1884":"\u767d\u94f6\u5e02","1885":"\u5929\u6c34\u5e02","1886":"\u5609\u5cea\u5173\u5e02","1887":"\u5e73\u51c9\u5e02","1889":"\u6b66\u5a01\u5e02","1890":"\u5f20\u6396\u5e02","1891":"\u7389\u95e8\u5e02","1892":"\u9152\u6cc9\u5e02","1894":"\u4e34\u590f\u5e02","1907":"\u5b9a\u897f\u5e02","1920":"\u5e86\u9633\u5e02","2603":"\u9647\u5357\u5e02","2604":"\u4e34\u590f\u56de\u65cf\u81ea\u6cbb\u5dde","2605":"\u7518\u5357\u85cf\u65cf\u81ea\u6cbb\u5dde","2606":"\u5408\u4f5c\u5e02"},"28":{"1964":"\u94f6\u5ddd\u5e02","1965":"\u77f3\u5634\u5c71\u5e02","1966":"\u5434\u5fe0\u5e02","1967":"\u9752\u94dc\u5ce1\u5e02","1975":"\u7075\u6b66\u5e02","1976":"\u4e2d\u536b\u5e02","1978":"\u56fa\u539f\u5e02"},"29":{"1984":"\u897f\u5b81\u5e02","1985":"\u683c\u5c14\u6728\u5e02","1986":"\u5fb7\u4ee4\u54c8\u5e02","1988":"\u6d77\u4e1c\u5730\u533a","2636":"\u6d77\u5317\u85cf\u65cf\u81ea\u6cbb\u5dde","2637":"\u9ec4\u5357\u85cf\u65cf\u81ea\u6cbb\u5dde","2638":"\u6d77\u5357\u85cf\u65cf\u81ea\u6cbb\u5dde","2639":"\u679c\u6d1b\u85cf\u65cf\u81ea\u6cbb\u5dde","2640":"\u7389\u6811\u85cf\u65cf\u81ea\u6cbb\u5dde","2641":"\u6d77\u897f\u8499\u53e4\u65cf\u85cf\u65cf\u81ea\u6cbb\u5dde","2642":"\u51b7\u6e56\u884c\u59d4"},"30":{"2026":"\u4e4c\u9c81\u6728\u9f50\u5e02","2027":"\u514b\u62c9\u739b\u4f9d\u5e02","2028":"\u77f3\u6cb3\u5b50\u5e02","2029":"\u5410\u9c81\u756a\u5e02","2030":"\u54c8\u5bc6\u5e02","2031":"\u548c\u7530\u5e02","2032":"\u963f\u514b\u82cf\u5e02","2033":"\u5580\u4ec0\u5e02","2034":"\u963f\u56fe\u4ec0\u5e02","2035":"\u5e93\u5c14\u52d2\u5e02","2036":"\u660c\u5409\u5e02","2037":"\u535a\u4e50\u5e02","2039":"\u4f0a\u5b81\u5e02","2040":"\u5854\u57ce\u5e02","2041":"\u963f\u52d2\u6cf0\u5e02","2085":"\u961c\u5eb7\u5e02","2104":"\u4e4c\u82cf\u5e02","2519":"\u594e\u5c6f\u5e02","2520":"\u4e94\u5bb6\u6e20\u5e02","2525":"\u963f\u62c9\u5c14\u5e02","2655":"\u535a\u5c14\u5854\u62c9\u8499\u53e4\u81ea\u6cbb\u5dde","2656":"\u5df4\u97f3\u90ed\u695e\u8499\u53e4\u81ea\u6cbb\u5dde","2657":"\u514b\u5b5c\u52d2\u82cf\u67ef\u5c14\u514b\u5b5c\u81ea\u6cbb\u5dde","2658":"\u4f0a\u7281\u54c8\u8428\u514b\u81ea\u6cbb\u5dde","2659":"\u56fe\u6728\u8212\u514b\u5e02","2660":"\u5410\u9c81\u756a\u5730\u533a","2661":"\u54c8\u5bc6\u5730\u533a","2662":"\u548c\u7530\u5730\u533a","2663":"\u963f\u514b\u82cf\u5730\u533a","2664":"\u5580\u4ec0\u5730\u533a","2665":"\u660c\u5409\u56de\u65cf\u81ea\u6cbb\u5dde","2666":"\u5854\u57ce\u5730\u533a","2667":"\u963f\u52d2\u6cf0\u5730\u533a","2668":"\u5410\u9c81\u756a\u5730\u533a","2669":"\u535a\u4e50\u5e02"},"31":{"2114":"\u62c9\u8428\u5e02","2115":"\u65e5\u5580\u5219\u5e02","2123":"\u90a3\u66f2\u53bf","2133":"\u660c\u90fd\u53bf","2186":"\u6797\u829d\u53bf","2527":"\u5c71\u5357\u5730\u533a","2649":"\u963f\u91cc\u5730\u533a","2650":"\u6797\u829d\u5730\u533a","2652":"\u65e5\u5580\u5219\u5730\u533a","2653":"\u90a3\u66f2\u5730\u533a","2654":"\u660c\u90fd\u5730\u533a"},"32":{"2530":"\u9999\u6e2f\u5730\u533a"},"33":{"2531":"\u6fb3\u95e8\u5730\u533a"},"34":{"2532":"\u53f0\u6e7e\u5168\u7701"}};
function changeCity(){
	var ProvinceId = document.getElementById("province").value;
	obj = $("#city")[0];
	$("#city").empty();
	if( cityarr[ProvinceId] != undefined ){
		$.each(cityarr[ProvinceId],function(i,n){
			addItem(obj,n,i);
//			addItem(obj,n,i);
		});
	}else{
		addItem(obj,'请选择 ...','');
	}
}


function exceptSpecial(obj){
	obj.value = obj.value.replace(/[\<\>\~\!\@\#\$\%\^\&\*\-\+\=\|\\\'\?\,\.\/\[\]\{}\(\)\"]{1,}/,'');
}

function checkform(obj){
  var repSpecial = /[\<\>\~\!\@\#\$\%\^\&\*\-\+\=\|\\\'\"\?\,\.\/\[\]\{}\(\)]{1,}/;
  /*if (obj.nickname.value != ""){
  	var re = /^(.){1,15}$/;
  	if( !re.test(obj.nickname.value) || repSpecial.test(obj.nickname.value)){
		alert("别名不符合规则, 请重新输入");
		obj.nickname.focus();
		return false;
	  }
  }
  var nickname = document.getElementById("nickname"); 
  if (nickname.value == ""){
	alert('请填写字段 "别名", 用于快速识别多个卡');
  	nickname.focus();
  	return false;
  }
  var nnchecked = document.getElementById("nnchecked");
   if (nnchecked.value != 1){
	alert('别名重复, 请更换');
	nickname.focus();
  	return false;
  }*/
  var bank = document.getElementById("bank");
  if (bank.value == ""){
    alert('请选择 "开户银行"');
  	bank.focus();
  	return false;
  }
  var bankid = parseInt(bank.value,10);
  if( bankid != 19 ||  bankid != 7){
	  var province = document.getElementById("province");
	  if (province.value == ""){
		alert('请选择 "开户银行卡省份"');
		province.focus();
		return false;
	  }
	  var city = document.getElementById("city");
	  if (city.value == ""){
		alert('请选择 "开户银行卡城市"');
		city.focus();
		return false;
	  }
	  if( bankid == 2 ){
	  	  var re = /^(.){1,20}$/;
		  if( !re.test(obj.branch.value) || repSpecial.test(obj.branch.value)){
			alert('"支行名称" 不符合规则, 请重新输入');
			obj.branch.focus();
			return false;
		  }
	  }
  }
  var re = /^(.){1,10}$/;
  if( !re.test(obj.realname.value) || repSpecial.test(obj.realname.value) || obj.realname == ""){
    alert('"开户人姓名" 不符合规则, 请重新输入');
	obj.realname.focus();
	return false;
  }
  if( bankid == 19 ){
  	  var re = /^\d{5,14}$/;
	  var cardno = document.getElementById("cardno");
	  if (!re.test(cardno.value)){
		alert('"财付通号码" 不符合规则, 请重新输入');
		cardno.focus();
		return false;
	  }
	  var cardno_again = document.getElementById("cardno_again");
	  if (cardno.value != cardno_again.value){
		alert('两次填写的 "财付通号码" 不相同, 请仔细核对后再次提交');
		cardno_again.focus();
		return false;
	  }
  }else{
	  var re = /^\d{16}$|^\d{19}$/;
	  var cardno = document.getElementById("cardno");
	  if (!re.test(cardno.value)){
		alert('"银行账号" 不符合规则, 请重新输入');
		cardno.focus();
		return false;
	  }
	  var cardno_again = document.getElementById("cardno_again");
	  if (cardno.value != cardno_again.value){
		alert('两次填写的 "银行账号" 不相同, 请仔细核对后再次提交');
		cardno_again.focus();
		return false;
	  }
   }
}
</script>


<div class="ld"><table class='st' border="0" cellspacing="0" cellpadding="0"><tr><td width='100%'>
<font color='#ff0000'>使用提示: </font><br/>
&nbsp;&nbsp;1, 银行卡绑定成功后, 平台任何区域都 <font color=#ff0000><b>不会</b></font> 出现您的完整银行账号, 开户姓名等信息。<!-- 请使用 <font color=#ff0000>"别名"</font> 更有效的识别您的账户--><br/>
&nbsp;&nbsp;2, 银行卡绑定成功后, 相关信息将无法查看与修改, 只能进行 <font color=#ff0000>解除绑定</font> 操作, 请仔细填写下表。<br/>
<!--&nbsp;&nbsp;3, 银行卡绑定成功后, <font color=#ff0000>解除绑定</font> 的过程, 需要您输入资金密码。<br/>-->
&nbsp;&nbsp;3, 每个游戏账户最多绑定 <font style="font-size:16px;color:#FF3300"><b>5</b></font>  张银行卡, 您已成功绑定 <font style="font-size:16px;color:#FF3300"><b><?=$banknums?></b></font> 张。<br/>
&nbsp;&nbsp;4, 新绑定的提款银行卡需要绑定时间超过&nbsp;<font style="font-size:16px;color:#F30;font-weight:bold;">6</font>&nbsp;小时才能正常提款。<br/>
&nbsp;&nbsp;5, 一个账户只能绑定同一个开户人姓名的银行卡<br/></td></tr></table></div><div style="clear:both; height:10px;"></div>


<div class="ld">
<table class="ct" border="0" cellspacing="0" cellpadding="0">
<form action="account_cardadd2.php" method="post" name="addform" id='addform' onsubmit="return checkform(this)">
<input type="hidden" name="flag" value="add" />
<input type="hidden" name="isverify" value="yes" />
<!--<input type='hidden' id='nnchecked' name='nnchecked' value=0 />-->
  <!--<tr>
  	<td class="nl"><font color="#FF0000">*</font>&nbsp;别名:</td>
    <td>
		<input style='width:166px;' type="text" name="nickname" id="nickname" maxlength="10" onblur="checkname();" onkeyup="exceptSpecial(this);" onchange="exceptSpecial(this);" />&nbsp;&nbsp;&nbsp;<span id="nick_msg"> ( 自定义银行卡名字, 由1至10个字符或汉字组成, 不能使用特殊字符 )</span>
    </td>
  </tr>-->
  <tr>
  	<td class="nl"><font color="#FF0000">*</font>&nbsp;开户银行:</td>
    <td>
    	<select name="bank" id="bank" style='width:170px;'>
    		<option value="">请选择 ...</option>
<?php
$sqla = "select * from ssc_banks WHERE zt2='1' order by sort desc";
$rsa = mysql_query($sqla);
while ($rowa = mysql_fetch_array($rsa)){
?>
    		<option value="<?=$rowa['tid']?>"><?=$rowa['name']?></option>
<?php }?>
    		</select>&nbsp;&nbsp;&nbsp;<span id="bank_msg" style="color:#ff3300"></span>
    </td>
  </tr>
  <tr title="bankinfo">
	<td class="nl"><font color="#FF0000">*</font>&nbsp;开户银行省份:</td>
	<td><select name="province" id="province" onchange="changeCity();" style='width:170px;'>
        	<option value="">请选择 ...</option>
        	        		<option value="1">北京</option>
        	        		<option value="2">上海</option>
        	        		<option value="3">天津</option>
        	        		<option value="4">重庆</option>
        	        		<option value="5">内蒙古</option>
        	        		<option value="6">山西</option>
        	        		<option value="7">河北</option>
        	        		<option value="8">辽宁</option>
        	        		<option value="9">吉林</option>
        	        		<option value="10">黑龙江</option>
        	        		<option value="11">江苏</option>
        	        		<option value="12">安徽</option>
        	        		<option value="13">山东</option>
        	        		<option value="14">浙江</option>
        	        		<option value="15">江西</option>
        	        		<option value="16">福建</option>
        	        		<option value="17">湖南</option>
        	        		<option value="18">湖北</option>
        	        		<option value="19">河南</option>
        	        		<option value="20">广东</option>
        	        		<option value="21">海南</option>
        	        		<option value="22">广西</option>
        	        		<option value="23">贵州</option>
        	        		<option value="24">四川</option>
        	        		<option value="25">云南</option>
        	        		<option value="26">陕西</option>
        	        		<option value="27">甘肃</option>
        	        		<option value="28">宁夏</option>
        	        		<option value="29">青海</option>
        	        		<option value="30">新疆</option>
        	        		<option value="31">西藏</option>
        	            </select>&nbsp;&nbsp;<span style="color:red;" id="province_msg"></span>
    </td>
   </tr>
   <tr title="bankinfo">
	<td class="nl"><font color="#FF0000">*</font>&nbsp;开户银行城市:</td>
	<td><select name="city" id="city"  style='width:170px;'>
        	<option value="">请选择 ...</option>
            </select>&nbsp;&nbsp;<span style="color:red;" id="city_msg"></span>
    </td>
   </tr>
   <tr title="bankinfo" class="branch">
  	<td class="nl"><font color="#FF0000">*</font>&nbsp;支行名称:</td>
    <td>
		<input type="text" name="branch" maxlength="20" id="branch" onkeyup="exceptSpecial(this);" onchange="exceptSpecial(this);" style='width:220px;'/>&nbsp;&nbsp;&nbsp;<span id="branch_msg">( 由1至20个字符或汉字组成, 不能使用特殊字符 ) </span>
    </td>
  </tr>
  <tr>
  	<td class="nl"><font color="#FF0000">*</font>&nbsp;开户人姓名:</td>
    <td>
		<input type="text" name="realname" maxlength="10" id="realname" onkeyup="exceptSpecial(this);" onchange="exceptSpecial(this);" style='width:220px;' />&nbsp;&nbsp;&nbsp;<span id="realname_msg">( 由1至10个字符或汉字组成, 不能使用特殊字符 )</span>
    </td>
  </tr>
  <tr>
  	<td class="nl"><font color="#FF0000">*</font>&nbsp;<span id="banknameinfo_1">银行账号</span>:</td>
    <td>
		<input maxlength="19" type="text" name="cardno" style="width:220px;" />&nbsp;&nbsp;&nbsp;<span id="cardno_msg" >( 银行卡账号由16位或19位数字组成 )</span>
    </td>
  </tr>
  <tr>
  	<td class="nl"><font color="#FF0000">*</font>&nbsp;确认<span id="banknameinfo_2">银行账号</span>:</td>
    <td>
		<input maxlength="19" type="text" name="cardno_again" onpaste="return false" style="width:220px;" />&nbsp;&nbsp;&nbsp;<span id="cardno_again_msg">( 银行账号只能手动输入, 不能粘贴 )</span>
    </td>
  </tr>
  <tr><td>&nbsp;</td><td><br/><button name="submit" type="submit" width='69' height='26' class="btn_next" /></button><br/><br/></td></tr>
</form>
</table>
</div>
<div id="footer"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td align="center"><table align="center" width="450">
<tr><td align="left">浏览器建议：首选IE 8.0浏览器，其次为火狐浏览器。</td></tr>
</table></td></tr><tr><td></td></tr></table></div>
<br/><br/>
</div></div>
<?php echo $count;?>
</BODY></HTML> 