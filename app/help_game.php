<?php
//error_reporting(0);
require_once 'conn.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD><TITLE><?php echo $webname;?>  - 玩法介绍</TITLE>
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
<BODY STYLE="background:#FFF url('images/v1/main_bg_0001.jpg') 0px -490px repeat-x; padding:10px;"><DIV ID='main_box'>
<div class="box l"></div>
<div class="box c"></div>
<div class="box r"></div>
<div class="box m">

<H1>
<SPAN class="action-span1"><DIV class='icons_mb1'></DIV>当前位置: <A href="/" target='_top'><?php echo $webname;?></a>
 - 玩法介绍 </SPAN><DIV style="clear:both"></DIV></H1>
<script>

(function($){
$(document).ready(function(){
	$("span[id^='general_tab_']").click(function(){
		$("span[id^='general_tab_']").attr("class","tab-back");
		$(this).attr("class","tab-front");
		$("div[id^='general_table_']").hide();
		id = $(this).attr("id").replace("general_tab_","");
		$("#general_table_"+id).show();
	});
});
})(jQuery);

</script>
<div class="tab-div">
	<div id="tabbar-div">
			<span class="tab-front"  id="general_tab_0">
		  <span class="tabbar-left"></span>
		  <span class="content">时时彩</span>
		  <span class="tabbar-right"></span>
		</span>
			<span class="tab-back"  id="general_tab_1">
		  <span class="tabbar-left"></span>
		  <span class="content">十一选五</span>
		  <span class="tabbar-right"></span>
		</span>
			<span class="tab-back"  id="general_tab_2">
		  <span class="tabbar-left"></span>
		  <span class="content">时时乐、3D</span>
		  <span class="tabbar-right"></span>
		</span>
			<span class="tab-back"  id="general_tab_3">
		  <span class="tabbar-left"></span>
		  <span class="content">排列三、五</span>
		  <span class="tabbar-right"></span>
		</span>
		</div>
  <div class="tabbar-bottom"></div>
            <div class="help-content" id="general_table_0" >
            <p>
<table border="0" cellspacing="0" cellpadding="0" width="100%" style="border-collapse: collapse">
    <colgroup><col width="92" style="width: 69pt; mso-width-source: userset; mso-width-alt: 2944" /><col width="122" style="width: 92pt; mso-width-source: userset; mso-width-alt: 3904" /><col width="388" style="width: 291pt; mso-width-source: userset; mso-width-alt: 12416" /><col width="22" style="width: 17pt; mso-width-source: userset; mso-width-alt: 704" /><col width="409" style="width: 307pt; mso-width-source: userset; mso-width-alt: 13088" /></colgroup>
    <tbody>
        <tr height="30" style="height: 22.5pt; mso-height-source: userset">
            <td class="xl82" height="65" colspan="5" align="center" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; height: 48.75pt; border-top: #ece9d8; border-right: #ece9d8">本平台时时彩包括：<span style="font-size: x-large"><span style="font-family: Tahoma"><font color="#FF3300"><strong>重庆时时彩、黑龙江时时彩、新疆时时彩、江西时时彩</strong></font></span></span></td>
        </tr>
        <tr height="31" style="height: 23.25pt; mso-height-source: userset">
            <td class="xl71" height="31" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2 0.5pt solid; background-color: #474747; height: 23.25pt; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><strong>玩法组</strong></font></span></span></td>
            <td class="xl71" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><strong>玩法</strong></font></span></span></td>
            <td class="xl72" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #474747 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><strong>玩法说明</strong></font></span></span></td>
            <td class="xl77" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2 0.5pt solid; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><strong>　</strong></font></span></span></td>
            <td class="xl77" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2 0.5pt solid; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><strong><font color="#ffffff">中奖举例</font></strong></span></span></td>
        </tr>
        <tr height="54" style="height: 40.5pt; mso-height-source: userset">
            <td class="xl85" height="184" rowspan="3" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2 0.5pt solid; background-color: #474747; height: 138pt; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">前三直选</font></span></span></td>
            <td class="xl81" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">直选复式</font></span></span></td>
            <td class="xl73" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #474747 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">从万位、千位、百位中选择一个3位数号码组成一注，所选号码与开奖号码前3位相同，且顺序一致，即为中奖。</font></span></span></td>
            <td class="xl74" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl74" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><span style="mso-spacerun: yes">&nbsp; </span>如：万位选择1，千位选择2，百位选择3，开奖号码为是123**，即为中奖。</font></span></span></td>
        </tr>
        <tr height="58" style="height: 43.5pt; mso-height-source: userset">
            <td class="xl81" height="58" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2; background-color: #474747; height: 43.5pt; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">直选单式</font></span></span></td>
            <td class="xl75" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #ece9d8"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">手动输入一个3位数号码组成一注，所选号码与开奖号码的万位、千位、百位相同，且顺序一致，即为中奖。</font></span></span></td>
            <td class="xl76" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #474747 0.5pt solid; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl74" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><span style="mso-spacerun: yes">&nbsp; </span>如：手动输入123，开奖号码为是123**，即为中奖。</font></span></span></td>
        </tr>
        <tr height="72" style="height: 54pt; mso-height-source: userset">
            <td class="xl81" height="72" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2; background-color: #474747; height: 54pt; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">直选和值</font></span></span></td>
            <td class="xl75" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #ece9d8"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">所选数值等于开奖号码万位、千位、百位三个数字相加之和，即为中奖。</font></span></span></td>
            <td class="xl76" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #474747 0.5pt solid; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl74" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><span style="mso-spacerun: yes">&nbsp; </span>如：选择6，开奖号码为123**、141**、114**、006**、060**等任意一个和值为6的结果，即为中奖。</font></span></span></td>
        </tr>
        <tr height="54" style="height: 40.5pt; mso-height-source: userset">
            <td class="xl85" height="157" rowspan="3" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2 0.5pt solid; background-color: #474747; height: 117.75pt; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">后三直选</font></span></span></td>
            <td class="xl81" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">直选复式</font></span></span></td>
            <td class="xl75" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #ece9d8"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">从百位、十位、个位中选择一个3位数号码组成一注，所选号码与开奖号码后3位相同，且顺序一致，即为中奖。</font></span></span></td>
            <td class="xl74" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl74" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><span style="mso-spacerun: yes">&nbsp; </span>如：百位选择1，十位选择2，个位选择3，开奖号码为是**123，即为中奖。</font></span></span></td>
        </tr>
        <tr height="52" style="height: 39pt; mso-height-source: userset">
            <td class="xl81" height="52" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2; background-color: #474747; height: 39pt; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">直选单式</font></span></span></td>
            <td class="xl75" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #ece9d8"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">手动输入一个3位数号码组成一注，所选号码与开奖号码的百位、十位、个位相同，且顺序一致，即为中奖。</font></span></span></td>
            <td class="xl76" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #474747 0.5pt solid; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl74" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><span style="mso-spacerun: yes">&nbsp; </span>如：手动输入123，开奖号码为是**123，即为中奖。</font></span></span></td>
        </tr>
        <tr height="51" style="height: 38.25pt; mso-height-source: userset">
            <td class="xl81" height="51" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2; background-color: #474747; height: 38.25pt; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">直选和值</font></span></span></td>
            <td class="xl75" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #ece9d8"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">所选数值等于开奖号码的百位、十位、个位三个数字相加之和，即为中奖。</font></span></span></td>
            <td class="xl74" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl74" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">如：选择6，开奖号码为**123、**141、**114、**006、**060等任意一个和值为6的结果，即为中奖。</font></span></span></td>
        </tr>
        <tr height="59" style="height: 44.25pt; mso-height-source: userset">
            <td class="xl85" height="228" rowspan="4" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2 0.5pt solid; background-color: #474747; height: 171pt; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">前三组选</font></span></span></td>
            <td class="xl83" style="border-bottom: #ece9d8; text-align: center; border-left: #f2f2f2; background-color: #474747; border-top: #ece9d8; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">组三</font></span></span></td>
            <td class="xl80" style="border-bottom: #ece9d8; border-left: #ece9d8; background-color: #474747; border-top: #ece9d8; border-right: #474747 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">从0-9中任意选择2个号码组成两注，所选号码与开奖号码的万位、千位、百位相同，且顺序不限，即为中奖。</font></span></span></td>
            <td class="xl70" style="border-bottom: #ece9d8; border-left: #ece9d8; background-color: #474747; border-top: #ece9d8; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl70" style="border-bottom: #ece9d8; border-left: #ece9d8; background-color: #474747; border-top: #ece9d8; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">如：选择12（展开为122**，212**，221** 和 112**、121**、211**），开奖号码为212** 或 121**，即为中奖。</font></span></span></td>
        </tr>
        <tr height="61" style="height: 45.75pt; mso-height-source: userset">
            <td class="xl81" height="61" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2; background-color: #474747; height: 45.75pt; border-top: #f2f2f2 0.5pt solid; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">组六</font></span></span></td>
            <td class="xl73" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2 0.5pt solid; border-right: #474747 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">从0-9中任意选择3个号码组成一注，所选号码与开奖号码的万位、千位、百位相同，顺序不限，即为中奖。</font></span></span></td>
            <td class="xl74" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2 0.5pt solid; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl74" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2 0.5pt solid; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><span style="mso-spacerun: yes">&nbsp; </span>如：选择123（展开为123**，132**，231**，213**，312**，321**），开奖号码为321**，即为中奖。</font></span></span></td>
        </tr>
        <tr height="54" style="height: 40.5pt; mso-height-source: userset">
            <td class="xl83" height="54" style="border-bottom: #ece9d8; text-align: center; border-left: #f2f2f2; background-color: #474747; height: 40.5pt; border-top: #ece9d8; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">组选和值</font></span></span></td>
            <td class="xl69" style="border-bottom: #ece9d8; border-left: #ece9d8; background-color: #474747; border-top: #ece9d8; border-right: #ece9d8"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">所选数值等于开奖号码万位、千位、百位三个数字相加之和，即为中奖。</font></span></span></td>
            <td class="xl70" style="border-bottom: #ece9d8; border-left: #ece9d8; background-color: #474747; border-top: #ece9d8; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl70" style="border-bottom: #ece9d8; border-left: #ece9d8; background-color: #474747; border-top: #ece9d8; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><span style="mso-spacerun: yes">&nbsp; </span>如：选择6，开奖号码为114**中组三奖，开奖号码为015**中组六奖。</font></span></span></td>
        </tr>
        <tr height="54" style="height: 40.5pt; mso-height-source: userset">
            <td class="xl81" height="54" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2; background-color: #474747; height: 40.5pt; border-top: #f2f2f2 0.5pt solid; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">混合组选</font></span></span></td>
            <td class="xl75" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2 0.5pt solid; border-right: #ece9d8"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">键盘手动输入购买号码，3个数字为一注，开奖号码的万位、千位、百位符合前三的组三或组六均为中奖。</font></span></span></td>
            <td class="xl76" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #474747 0.5pt solid; background-color: #474747; border-top: #f2f2f2 0.5pt solid; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl74" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2 0.5pt solid; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><span style="mso-spacerun: yes">&nbsp; </span>如：手动输入123、455，开奖号码为321**即中组六奖，开奖号码为545**即中组三奖。</font></span></span></td>
        </tr>
        <tr height="59" style="height: 44.25pt; mso-height-source: userset">
            <td class="xl85" height="214" rowspan="4" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2 0.5pt solid; background-color: #474747; height: 160.5pt; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">后三组选</font></span></span></td>
            <td class="xl81" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">组三</font></span></span></td>
            <td class="xl75" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #ece9d8"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">从0-9中任意选择2个号码组成两注，所选号码与开奖号码的百位、十位、个位相同，且顺序不限，即为中奖。</font></span></span></td>
            <td class="xl76" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #474747 0.5pt solid; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl74" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><span style="mso-spacerun: yes">&nbsp; </span>如：选择12（展开为**122，**212，**221 和 **112、**121、**211），开奖号码为**212 或 **121，即为中奖。</font></span></span></td>
        </tr>
        <tr height="59" style="height: 44.25pt; mso-height-source: userset">
            <td class="xl81" height="59" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2; background-color: #474747; height: 44.25pt; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">组六</font></span></span></td>
            <td class="xl75" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #ece9d8"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">从0-9中任意选择3个号码组成一注，所选号码与开奖号码的百位、十位、个位相同，顺序不限，即为中奖。</font></span></span></td>
            <td class="xl76" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #474747 0.5pt solid; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl74" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><span style="mso-spacerun: yes">&nbsp; </span>如：选择123（展开为**123，**132，**231，**213，**312，**321），开奖号码为**321，即为中奖。</font></span></span></td>
        </tr>
        <tr height="46" style="height: 34.5pt; mso-height-source: userset">
            <td class="xl81" height="46" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2; background-color: #474747; height: 34.5pt; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">组选和值</font></span></span></td>
            <td class="xl73" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #474747 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">所选数值等于开奖号码百位、十位、个位三个数字相加之和，即为中奖。</font></span></span></td>
            <td class="xl76" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #474747; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl74" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><span style="mso-spacerun: yes">&nbsp; </span>如：选择6，开奖号码为**114中组三奖，开奖号码为**015中组六奖。</font></span></span></td>
        </tr>
        <tr height="50" style="height: 37.5pt; mso-height-source: userset">
            <td class="xl81" height="50" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2; background-color: #474747; height: 37.5pt; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">混合组选</font></span></span></td>
            <td class="xl75" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #ece9d8"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">键盘手动输入购买号码，3个数字为一注，开奖号码的百位、十位、个位符合前三的组三或组六均为中奖。</font></span></span></td>
            <td class="xl74" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl74" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><span style="mso-spacerun: yes">&nbsp; </span>如：手动输入123、455，开奖号码为**321即中组六奖，开奖号码为**545即中组三奖。</font></span></span></td>
        </tr>
        <tr height="48" style="height: 36pt; mso-height-source: userset">
            <td class="xl85" height="113" rowspan="2" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2 0.5pt solid; background-color: #474747; height: 84.75pt; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">后三不定位</font></span></span></td>
            <td class="xl83" style="border-bottom: #ece9d8; text-align: center; border-left: #f2f2f2; background-color: #474747; border-top: #ece9d8; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">一码不定位</font></span></span></td>
            <td class="xl80" style="border-bottom: #ece9d8; border-left: #ece9d8; background-color: #474747; border-top: #ece9d8; border-right: #474747 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">从0-9中选择1个号码，每注由1个号码组成，只要开奖号码的百位、十位、个位中包含所选号码，即为中奖。</font></span></span></td>
            <td class="xl70" style="border-bottom: #ece9d8; border-left: #ece9d8; background-color: #474747; border-top: #ece9d8; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl70" style="border-bottom: #ece9d8; border-left: #ece9d8; background-color: #474747; border-top: #ece9d8; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><span style="mso-spacerun: yes">&nbsp; </span>如：选择一码不定位4，开出**4**、***4*、****4即为中奖。</font></span></span></td>
        </tr>
        <tr height="65" style="height: 48.75pt; mso-height-source: userset">
            <td class="xl81" height="65" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2; background-color: #474747; height: 48.75pt; border-top: #f2f2f2 0.5pt solid; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">二码不定位</font></span></span></td>
            <td class="xl73" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2 0.5pt solid; border-right: #474747 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">从0-9中选择2个号码，每注由2个不同的号码组成，开奖号码的百位、十位、个位中同时包含所选的2个号码，即为中奖。</font></span></span></td>
            <td class="xl74" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2 0.5pt solid; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl74" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2 0.5pt solid; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><span style="mso-spacerun: yes">&nbsp; </span>如：选择二码不定位4、5，开奖号码为***45、**5*4、***54即为中奖。</font></span></span></td>
        </tr>
        <tr height="49" style="height: 36.75pt; mso-height-source: userset">
            <td class="xl85" height="398" rowspan="8" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2 0.5pt solid; background-color: #474747; height: 298.5pt; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">二星</font></span></span></td>
            <td class="xl81" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">前二直选复式</font></span></span></td>
            <td class="xl73" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #474747 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">从万位和千位上至少各选1个号码，所选号码与开奖号码的万位、千位相同，且顺序一致，即为中奖。</font></span></span></td>
            <td class="xl74" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl74" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><span style="mso-spacerun: yes">&nbsp; </span>如：万位选择3，千位选择4，开出34***即为中奖。</font></span></span></td>
        </tr>
        <tr height="49" style="height: 36.75pt; mso-height-source: userset">
            <td class="xl81" height="49" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2; background-color: #474747; height: 36.75pt; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">前二直选单式</font></span></span></td>
            <td class="xl73" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #474747 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">手动输入一个2位数号码组成一注，所选号码与开奖号码的万位、千位相同，且顺序一致，即为中奖。</font></span></span></td>
            <td class="xl74" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl74" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><span style="mso-spacerun: yes">&nbsp; </span>如：手动输入12，开奖号码为是12***，即为中奖。</font></span></span></td>
        </tr>
        <tr height="50" style="height: 37.5pt; mso-height-source: userset">
            <td class="xl81" height="50" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2; background-color: #474747; height: 37.5pt; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">前二组选复式</font></span></span></td>
            <td class="xl73" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #474747 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">从0-9中选2个号码组成一注，所择号码与开奖号码的万位、千位相同，顺序不限，即为中奖。</font></span></span></td>
            <td class="xl74" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl74" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><span style="mso-spacerun: yes">&nbsp; </span>如：选择7、8，开奖号码78***或87***，即为中奖。</font></span></span></td>
        </tr>
        <tr height="50" style="height: 37.5pt; mso-height-source: userset">
            <td class="xl81" height="50" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2; background-color: #474747; height: 37.5pt; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">前二组选单式</font></span></span></td>
            <td class="xl73" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #474747 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">手动输入购买号码，2个数字为一注，所选号码与开奖号码的万位、千位相同，顺序不限，即为中奖。</font></span></span></td>
            <td class="xl74" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl74" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><span style="mso-spacerun: yes">&nbsp; </span>如：手动输入12，开奖号码为是21***或12***，即为中奖。</font></span></span></td>
        </tr>
        <tr height="50" style="height: 37.5pt; mso-height-source: userset">
            <td class="xl81" height="50" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2; background-color: #474747; height: 37.5pt; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">后二直选复式</font></span></span></td>
            <td class="xl73" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #474747 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">从十位和个位上至少各选1个号码，所选号码与开奖号码的十位、个位相同，且顺序一致，即为中奖。</font></span></span></td>
            <td class="xl74" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl74" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><span style="mso-spacerun: yes">&nbsp; </span>如：十位选择3，个位现在4，开奖号码为***34，即为中奖。</font></span></span></td>
        </tr>
        <tr height="50" style="height: 37.5pt; mso-height-source: userset">
            <td class="xl81" height="50" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2; background-color: #474747; height: 37.5pt; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">后二直选单式</font></span></span></td>
            <td class="xl73" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #474747 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">手动输入一个2位数号码组成一注，所选号码与开奖号码的十位、个位相同，且顺序一致，即为中奖。</font></span></span></td>
            <td class="xl74" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl74" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><span style="mso-spacerun: yes">&nbsp; </span>如：手动输入12，开奖号码为是***12，即为中奖。</font></span></span></td>
        </tr>
        <tr height="50" style="height: 37.5pt; mso-height-source: userset">
            <td class="xl81" height="50" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2; background-color: #474747; height: 37.5pt; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">后二组选复式</font></span></span></td>
            <td class="xl73" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #474747 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">从0-9中选2个号码组成一注，所选号码与开奖号码的十位、个位相同，顺序不限，即为中奖。</font></span></span></td>
            <td class="xl74" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl74" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><span style="mso-spacerun: yes">&nbsp; </span>如：选择7、8，开奖号码***78或***87即为中奖。</font></span></span></td>
        </tr>
        <tr height="50" style="height: 37.5pt; mso-height-source: userset">
            <td class="xl81" height="50" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2; background-color: #474747; height: 37.5pt; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">后二组选单式</font></span></span></td>
            <td class="xl80" style="border-bottom: #ece9d8; border-left: #ece9d8; background-color: #474747; border-top: #ece9d8; border-right: #474747 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">手动输入购买号码，2个数字为一注，所选号码与开奖号码的十位、个位相同，顺序不限，即为中奖。</font></span></span></td>
            <td class="xl74" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl74" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><span style="mso-spacerun: yes">&nbsp; </span>如：手动输入12，开奖号码为是***21或者***12，即为中奖。</font></span></span></td>
        </tr>
        <tr height="32" style="height: 24pt; mso-height-source: userset">
            <td class="xl85" height="160" rowspan="5" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2 0.5pt solid; background-color: #474747; height: 120pt; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">定位胆</font></span></span></td>
            <td class="xl81" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">万位</font></span></span></td>
            <td class="xl86" rowspan="5" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #f2f2f2 0.5pt solid; background-color: #474747; border-top: #f2f2f2 0.5pt solid; border-right: #ece9d8"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">从万位、千位、百位、十位、个位任意1个位置或多个位置上选择1个号码，所选号码与相同位置上的开奖号码一致，即为中奖。</font></span></span></td>
            <td class="xl78" style="border-bottom: #ece9d8; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl78" style="border-bottom: #ece9d8; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><span style="mso-spacerun: yes">&nbsp; </span>如：定万位为1，开奖号码为1****即为中奖。</font></span></span></td>
        </tr>
        <tr height="32" style="height: 24pt; mso-height-source: userset">
            <td class="xl81" height="32" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2; background-color: #474747; height: 24pt; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">千位</font></span></span></td>
            <td class="xl70" style="border-bottom: #ece9d8; border-left: #ece9d8; background-color: #474747; border-top: #ece9d8; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl74" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2 0.5pt solid; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><span style="mso-spacerun: yes">&nbsp; </span>如：定千位为2，开奖号码为*2***即为中奖。</font></span></span></td>
        </tr>
        <tr height="32" style="height: 24pt; mso-height-source: userset">
            <td class="xl81" height="32" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2; background-color: #474747; height: 24pt; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">百位</font></span></span></td>
            <td class="xl70" style="border-bottom: #ece9d8; border-left: #ece9d8; background-color: #474747; border-top: #ece9d8; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl70" style="border-bottom: #ece9d8; border-left: #ece9d8; background-color: #474747; border-top: #ece9d8; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><span style="mso-spacerun: yes">&nbsp; </span>如：定百位为3，开奖号码为**3**即为中奖。</font></span></span></td>
        </tr>
        <tr height="32" style="height: 24pt; mso-height-source: userset">
            <td class="xl81" height="32" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2; background-color: #474747; height: 24pt; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">十位</font></span></span></td>
            <td class="xl70" style="border-bottom: #ece9d8; border-left: #ece9d8; background-color: #474747; border-top: #ece9d8; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl74" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2 0.5pt solid; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><span style="mso-spacerun: yes">&nbsp; </span>如：定十位为4，开奖号码为***4*即为中奖。</font></span></span></td>
        </tr>
        <tr height="32" style="height: 24pt; mso-height-source: userset">
            <td class="xl84" height="32" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2; background-color: #474747; height: 24pt; border-top: #ece9d8; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">个位</font></span></span></td>
            <td class="xl79" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #ece9d8; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl79" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #ece9d8; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><span style="mso-spacerun: yes">&nbsp; </span>如：定个位为5，开奖号码为****5即为中奖。</font></span></span></td>
        </tr>
        <tr height="73" style="height: 54.75pt; mso-height-source: userset">
            <td class="xl85" height="146" rowspan="2" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2 0.5pt solid; background-color: #474747; height: 109.5pt; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">大小单双</font></span></span></td>
            <td class="xl81" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">前二</font></span></span></td>
            <td class="xl75" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #ece9d8"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">对万位和千位的&ldquo;大（56789）小（01234）、单（13579）双（02468）&rdquo;形态进行购买，所选号码的位置、形态与开奖号码的位置、形态相同，即为中奖。</font></span></span></td>
            <td class="xl76" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #474747 0.5pt solid; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl74" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><span style="mso-spacerun: yes">&nbsp; </span>如：万位选择大，千位选择单，开出63***即为中奖。</font></span></span></td>
        </tr>
        <tr height="73" style="height: 54.75pt; mso-height-source: userset">
            <td class="xl81" height="73" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2; background-color: #474747; height: 54.75pt; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">后二</font></span></span></td>
            <td class="xl75" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #ece9d8"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">对十位和个位的&ldquo;大（56789）小（01234）、单（13579）双（02468）&rdquo;形态进行购买，所选号码的位置、形态与开奖号码的位置、形态相同，即为中奖。</font></span></span></td>
            <td class="xl74" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl74" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><span style="mso-spacerun: yes">&nbsp; </span>如：十位选择小，个位选择双，开出***12即为中奖</font></span></span></td>
        </tr>
    </tbody>
</table>
</p>        </div>
            <div class="help-content" id="general_table_1" style="display:none">
            <p>
<table border="0" cellspacing="0" cellpadding="0" width="100%" style="border-collapse: collapse">
    <colgroup><col width="92" style="width: 69pt; mso-width-source: userset; mso-width-alt: 2944" /><col width="122" style="width: 92pt; mso-width-source: userset; mso-width-alt: 3904" /><col width="388" style="width: 291pt; mso-width-source: userset; mso-width-alt: 12416" /><col width="22" style="width: 17pt; mso-width-source: userset; mso-width-alt: 704" /><col width="409" style="width: 307pt; mso-width-source: userset; mso-width-alt: 13088" /></colgroup>
    <tbody>
        <tr height="30" style="height: 22.5pt; mso-height-source: userset">
            <td class="xl82" height="65" colspan="5" align="center" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; height: 48.75pt; border-top: #ece9d8; border-right: #ece9d8">本平台十一选五包括：<span style="font-size: x-large"><span style="font-family: Tahoma"><font color="#ff3300"><strong>十一运夺金、多乐彩、广东十一选五、重庆十一选五</strong></font></span></span></td>
        </tr>
        <tr height="31" style="height: 23.25pt; mso-height-source: userset">
            <td class="xl69" height="31" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2 0.5pt solid; background-color: #474747; height: 23.25pt; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><strong>玩法组</strong></font></span></span></td>
            <td class="xl69" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><strong>玩法</strong></font></span></span></td>
            <td class="xl81" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2; background-color: #474747; border-top: #f2f2f2; border-right: #474747 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><strong>玩法说明</strong></font></span></span></td>
            <td class="xl75" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2 0.5pt solid; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><strong>　</strong></font></span></span></td>
            <td class="xl75" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2 0.5pt solid; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><strong><font color="#ffffff">中奖举例</font></strong></span></span></td>
        </tr>
        <tr height="67" style="height: 50.25pt; mso-height-source: userset">
            <td class="xl93" height="214" rowspan="4" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2 0.5pt solid; background-color: #474747; height: 160.5pt; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">三码</font></span></span></td>
            <td class="xl71" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">前三直选复式</font></span></span></td>
            <td class="xl74" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #f2f2f2; background-color: #474747; border-top: #f2f2f2; border-right: #ece9d8"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">从01-11共11个号码中选择3个不重复的号码组成一注，所选号码与当期顺序摇出的5个号码中的前3个号码相同，且顺序一致，即为中奖。</font></span></span></td>
            <td class="xl73" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #474747 0.5pt solid; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl67" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #f2f2f2; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><span style="mso-spacerun: yes">&nbsp; </span>如：第一位选择01，第二位选择02，第三位选择03，开奖号码顺序为01，02，03 <font class="font10"><strong>* *</strong></font><font class="font7">，即为中奖。</font></font></span></span></td>
        </tr>
        <tr height="50" style="height: 37.5pt; mso-height-source: userset">
            <td class="xl77" height="50" style="border-bottom: #ece9d8; text-align: center; border-left: #f2f2f2; background-color: #474747; height: 37.5pt; border-top: #ece9d8; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">前三直选单式</font></span></span></td>
            <td class="xl79" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #f2f2f2; background-color: #474747; border-top: #f2f2f2; border-right: #474747 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">手动输入3个号码组成一注，所输入的号码与当期顺序摇出的5个号码中的前3个号码相同，且顺序一致，即为中奖。</font></span></span></td>
            <td class="xl68" style="border-bottom: #ece9d8; border-left: #ece9d8; background-color: #474747; border-top: #ece9d8; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl90" style="border-bottom: #ece9d8; border-left: #f2f2f2; background-color: #474747; border-top: #ece9d8; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><span style="mso-spacerun: yes">&nbsp; </span>如：手动输入01 02 03，开奖号码为是01 02 03 <font class="font9"><strong>* *</strong></font><font class="font8">，即为中奖。</font></font></span></span></td>
        </tr>
        <tr height="49" style="height: 36.75pt; mso-height-source: userset">
            <td class="xl71" height="49" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2; background-color: #474747; height: 36.75pt; border-top: #f2f2f2 0.5pt solid; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">前三组选复式</font></span></span></td>
            <td class="xl79" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #f2f2f2; background-color: #474747; border-top: #f2f2f2; border-right: #474747 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">从01-11中共11个号码中选择3个号码，所选号码与当期顺序摇出的5个号码中的前3个号码相同，顺序不限，即为中奖。</font></span></span></td>
            <td class="xl72" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2 0.5pt solid; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl67" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #f2f2f2; background-color: #474747; border-top: #f2f2f2 0.5pt solid; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><span style="mso-spacerun: yes">&nbsp; </span>如：选择01 02 03（展开为01 02 03 <font class="font10"><strong>* *</strong></font><font class="font7">，01 03 02 </font><font class="font10"><strong>* *</strong></font><font class="font7">，02 01 03</font><font class="font10"><strong> * *</strong></font><font class="font7">，02 03 01 </font><font class="font10"><strong>* *</strong></font><font class="font7">，03 01 02 </font><font class="font10"><strong>* *</strong></font><font class="font7">，03 02 01 </font><font class="font10"><strong>* *</strong></font><font class="font7">），开奖号码为03 01 02，即为中奖。</font></font></span></span></td>
        </tr>
        <tr height="48" style="height: 36pt; mso-height-source: userset">
            <td class="xl77" height="48" style="border-bottom: #ece9d8; text-align: center; border-left: #f2f2f2; background-color: #474747; height: 36pt; border-top: #ece9d8; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">前三组选单式</font></span></span></td>
            <td class="xl85" style="border-bottom: #ece9d8; border-left: #f2f2f2; background-color: #474747; border-top: #ece9d8; border-right: #474747 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">手动输入3个号码组成一注，所输入的号码与当期顺序摇出的5个号码中的前3个号码相同，顺序不限，即为中奖。</font></span></span></td>
            <td class="xl68" style="border-bottom: #ece9d8; border-left: #ece9d8; background-color: #474747; border-top: #ece9d8; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl86" style="border-bottom: #ece9d8; border-left: #f2f2f2; background-color: #474747; border-top: #ece9d8; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><span style="mso-spacerun: yes">&nbsp; </span>如：手动输入01 02 03（展开为01 02 03 <font class="font10"><strong>* *</strong></font><font class="font7">，01 03 02 </font><font class="font10"><strong>* * </strong></font><font class="font7">, 02 01 03</font><font class="font10"><strong> * *</strong></font><font class="font7">，02 03 01</font><font class="font10"><strong> * *，</strong></font><font class="font7">03 01 02 * *，03 02 01 </font><font class="font10"><strong>* *</strong></font><font class="font7">），开奖号码为01 03 02</font><font class="font10"><strong> * *</strong></font><font class="font7">，即为中奖。</font></font></span></span></td>
        </tr>
        <tr height="47" style="height: 35.25pt; mso-height-source: userset">
            <td class="xl93" height="198" rowspan="4" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2 0.5pt solid; background-color: #474747; height: 148.5pt; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">二码</font></span></span></td>
            <td class="xl71" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2; background-color: #474747; border-top: #f2f2f2 0.5pt solid; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">前二直选复式</font></span></span></td>
            <td class="xl79" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #f2f2f2; background-color: #474747; border-top: #f2f2f2 0.5pt solid; border-right: #474747 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">从01-11共11个号码中选择2个不重复的号码组成一注，所选号码与当期顺序摇出的5个号码中的前2个号码相同，且顺序一致，即中奖。</font></span></span></td>
            <td class="xl72" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2 0.5pt solid; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl87" width="402" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #f2f2f2; background-color: #474747; width: 302pt; border-top: #f2f2f2 0.5pt solid; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><span style="mso-spacerun: yes">&nbsp; </span>如：第一位选择01，第二位选择02，开奖号码 01 02 <font class="font9"><strong>* * *</strong></font><font class="font8">，即为中奖。</font></font></span></span></td>
        </tr>
        <tr height="49" style="height: 36.75pt; mso-height-source: userset">
            <td class="xl77" height="49" style="border-bottom: #ece9d8; text-align: center; border-left: #f2f2f2; background-color: #474747; height: 36.75pt; border-top: #ece9d8; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">前二直选单式</font></span></span></td>
            <td class="xl85" style="border-bottom: #ece9d8; border-left: #f2f2f2; background-color: #474747; border-top: #ece9d8; border-right: #474747 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">手动输入2个号码组成一注，所输入的号码与当期顺序摇出的5个号码中的前2个号码相同，且顺序一致，即为中奖。</font></span></span></td>
            <td class="xl68" style="border-bottom: #ece9d8; border-left: #ece9d8; background-color: #474747; border-top: #ece9d8; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl88" width="402" style="border-bottom: #ece9d8; border-left: #f2f2f2; background-color: #474747; width: 302pt; border-top: #ece9d8; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><span style="mso-spacerun: yes">&nbsp; </span>如：手动输入 01 02，开奖号码为01 02<font class="font9"><strong> * * *</strong></font><font class="font8">，即为中奖。</font></font></span></span></td>
        </tr>
        <tr height="52" style="height: 39pt; mso-height-source: userset">
            <td class="xl71" height="52" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2; background-color: #474747; height: 39pt; border-top: #f2f2f2 0.5pt solid; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">前二组选复式</font></span></span></td>
            <td class="xl79" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #f2f2f2; background-color: #474747; border-top: #f2f2f2 0.5pt solid; border-right: #474747 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">从01-11中共11个号码中选择2个号码，所选号码与当期顺序摇出的5个号码中的前2个号码相同，顺序不限，即为中奖。</font></span></span></td>
            <td class="xl72" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2 0.5pt solid; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl87" width="402" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #f2f2f2; background-color: #474747; width: 302pt; border-top: #f2f2f2 0.5pt solid; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><span style="mso-spacerun: yes">&nbsp; </span>如：选择01 02（展开为01 02 <font class="font9"><strong>* * *</strong></font><font class="font8">，02 01 </font><font class="font9"><strong>* * *</strong></font><font class="font8">），开奖号码为02 01</font><font class="font9"><strong> * * * </strong></font><font class="font8">或 01 02 </font><font class="font9"><strong>* * *</strong></font><font class="font8">，即为中奖。</font></font></span></span></td>
        </tr>
        <tr height="50" style="height: 37.5pt; mso-height-source: userset">
            <td class="xl77" height="50" style="border-bottom: #ece9d8; text-align: center; border-left: #f2f2f2; background-color: #474747; height: 37.5pt; border-top: #ece9d8; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">前二组选单式</font></span></span></td>
            <td class="xl66" style="border-bottom: #ece9d8; border-left: #ece9d8; background-color: #474747; border-top: #ece9d8; border-right: #ece9d8"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">手动输入2个号码组成一注，所输入的号码与当期顺序摇出的5个号码中的前2个号码相同，顺序不限，即为中奖。</font></span></span></td>
            <td class="xl73" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #474747 0.5pt solid; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl88" width="402" style="border-bottom: #ece9d8; border-left: #f2f2f2; background-color: #474747; width: 302pt; border-top: #ece9d8; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><span style="mso-spacerun: yes">&nbsp; </span>如：手动输入01 02（展开为01 02 <font class="font9"><strong>* * *</strong></font><font class="font8">，02 01 </font><font class="font9"><strong>* * *</strong></font><font class="font8">），开奖号码为02 01 *** 或 01 02 ***，即为中奖。</font></font></span></span></td>
        </tr>
        <tr height="49" style="height: 36.75pt; mso-height-source: userset">
            <td class="xl71" height="49" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2 0.5pt solid; background-color: #474747; height: 36.75pt; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">不定位</font></span></span></td>
            <td class="xl71" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2; background-color: #474747; border-top: #f2f2f2 0.5pt solid; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">前三不定位</font></span></span></td>
            <td class="xl79" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #f2f2f2; background-color: #474747; border-top: #f2f2f2 0.5pt solid; border-right: #474747 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">从01-11中共11个号码中选择1个号码，每注由1个号码组成，只要当期顺序摇出的第一位、第二位、第三位开奖号码中包含所选号码，即为中奖。</font></span></span></td>
            <td class="xl72" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl87" width="402" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #f2f2f2; background-color: #474747; width: 302pt; border-top: #f2f2f2 0.5pt solid; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><span style="mso-spacerun: yes">&nbsp; </span>如：选择01，开奖号码为01<font class="font9"><strong> * * * *</strong></font><font class="font8">，</font><font class="font9"><strong>* </strong></font><font class="font8">01</font><font class="font9"><strong> * * *</strong></font><font class="font8">，</font><font class="font9"><strong>* *</strong></font><font class="font8"> 01</font><font class="font9"><strong> * *</strong></font><font class="font8">，即为中奖。</font></font></span></span></td>
        </tr>
        <tr height="28" style="height: 21pt; mso-height-source: userset">
            <td class="xl93" height="84" rowspan="3" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2 0.5pt solid; background-color: #474747; height: 63pt; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">定位胆</font></span></span></td>
            <td class="xl70" style="border-bottom: #ece9d8; text-align: center; border-left: #f2f2f2; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">第一位</font></span></span></td>
            <td class="xl98" rowspan="3" width="418" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #f2f2f2 0.5pt solid; background-color: #474747; width: 314pt; border-top: #f2f2f2; border-right: #474747 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">从第一位，第二位，第三位任意1个位置或多个位置上选择1个号码，所选号码与相同位置上的开奖号码一致，即为中奖。</font></span></span></td>
            <td class="xl80" style="border-bottom: #474747 0.5pt solid; border-left: #474747; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl101" style="border-bottom: #ece9d8; border-left: #f2f2f2; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><span style="mso-spacerun: yes">&nbsp; </span>如：第一位选择01，开奖号码为01<font class="font9"><strong> * * * *</strong></font><font class="font8">，即为中奖。</font></font></span></span></td>
        </tr>
        <tr height="28" style="height: 21pt; mso-height-source: userset">
            <td class="xl71" height="28" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2; background-color: #474747; height: 21pt; border-top: #f2f2f2 0.5pt solid; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">第二位</font></span></span></td>
            <td class="xl83" style="border-bottom: #474747 0.5pt solid; border-left: #474747; background-color: #474747; border-top: #474747; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl91" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #f2f2f2; background-color: #474747; border-top: #f2f2f2 0.5pt solid; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><span style="mso-spacerun: yes">&nbsp; </span>如：第二位选择05，开奖号码为 <font class="font9"><strong>* </strong></font><font class="font8">05</font><font class="font9"><strong>* * *</strong></font><font class="font8">，即为中奖。</font></font></span></span></td>
        </tr>
        <tr height="28" style="height: 21pt; mso-height-source: userset">
            <td class="xl78" height="28" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2; background-color: #474747; height: 21pt; border-top: #ece9d8; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">第三位</font></span></span></td>
            <td class="xl76" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #ece9d8; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl102" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #f2f2f2; background-color: #474747; border-top: #ece9d8; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><span style="mso-spacerun: yes">&nbsp; </span>如：第三位选择07，开奖号码为 <font class="font9"><strong>* *</strong></font><font class="font8"> 07 </font><font class="font9"><strong>* *</strong></font><font class="font8">，即为中奖。</font></font></span></span></td>
        </tr>
        <tr height="49" style="height: 36.75pt; mso-height-source: userset">
            <td class="xl93" height="97" rowspan="2" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2 0.5pt solid; background-color: #474747; height: 72.75pt; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">趣味性</font></span></span></td>
            <td class="xl77" style="border-bottom: #ece9d8; text-align: center; border-left: #f2f2f2; background-color: #474747; border-top: #ece9d8; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">定单双</font></span></span></td>
            <td class="xl89" style="border-bottom: #ece9d8; border-left: #f2f2f2; background-color: #474747; border-top: #f2f2f2; border-right: #474747 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">从5种单双个数组合中选择1种组合，当期开奖号码的单双个数与所选单双组合一致，即为中奖。</font></span></span></td>
            <td class="xl68" style="border-bottom: #ece9d8; border-left: #ece9d8; background-color: #474747; border-top: #ece9d8; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl90" style="border-bottom: #ece9d8; border-left: #f2f2f2; background-color: #474747; border-top: #ece9d8; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><span style="mso-spacerun: yes">&nbsp; </span>如：选择5单0双，开奖号码01，03，05，07，09五个单数，即为中奖。</font></span></span></td>
        </tr>
        <tr height="48" style="height: 36pt; mso-height-source: userset">
            <td class="xl71" height="48" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2; background-color: #474747; height: 36pt; border-top: #f2f2f2 0.5pt solid; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">猜中位</font></span></span></td>
            <td class="xl79" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #f2f2f2; background-color: #474747; border-top: #f2f2f2 0.5pt solid; border-right: #474747 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">从3-9中选择1个号码进行购买，所选号码与5个开奖号码按照大小顺序排列后的第3个号码相同，即为中奖。</font></span></span></td>
            <td class="xl72" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2 0.5pt solid; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl91" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #f2f2f2; background-color: #474747; border-top: #f2f2f2 0.5pt solid; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><span style="mso-spacerun: yes">&nbsp; </span>如：选择8，开奖号码为11，04，09，05，08，按开奖号码的数字大小排列为04，05，08，09，11，中间数08，即为中奖。</font></span></span></td>
        </tr>
        <tr height="48" style="height: 36pt; mso-height-source: userset">
            <td class="xl93" height="394" rowspan="8" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2 0.5pt solid; background-color: #474747; height: 295.5pt; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">任选</font></span></span></td>
            <td class="xl77" style="border-bottom: #ece9d8; text-align: center; border-left: #f2f2f2; background-color: #474747; border-top: #ece9d8; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">任选一中一</font></span></span></td>
            <td class="xl89" style="border-bottom: #ece9d8; border-left: #f2f2f2; background-color: #474747; border-top: #f2f2f2; border-right: #474747 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">从01-11共11个号码中选择1个号码进行购买，只要当期顺序摇出的5个开奖号码中包含所选号码，即为中奖。</font></span></span></td>
            <td class="xl68" style="border-bottom: #ece9d8; border-left: #ece9d8; background-color: #474747; border-top: #ece9d8; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl84" style="border-bottom: #ece9d8; border-left: #f2f2f2; background-color: #474747; border-top: #ece9d8; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><span style="mso-spacerun: yes">&nbsp; </span>如：选择05，开奖号码为08 04 11 05 03，即为中奖</font></span></span></td>
        </tr>
        <tr height="48" style="height: 36pt; mso-height-source: userset">
            <td class="xl71" height="48" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2; background-color: #474747; height: 36pt; border-top: #f2f2f2 0.5pt solid; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">任选二中二</font></span></span></td>
            <td class="xl79" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #f2f2f2; background-color: #474747; border-top: #f2f2f2 0.5pt solid; border-right: #474747 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">从01-11共11个号码中选择2个号码进行购买，只要当期顺序摇出的5个开奖号码中包含所选号码，即为中奖。</font></span></span></td>
            <td class="xl72" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2 0.5pt solid; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl91" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #f2f2f2; background-color: #474747; border-top: #f2f2f2 0.5pt solid; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><span style="mso-spacerun: yes">&nbsp; </span>如：选择05 04，开奖号码为08 04 11 05 03，即为中奖。</font></span></span></td>
        </tr>
        <tr height="48" style="height: 36pt; mso-height-source: userset">
            <td class="xl77" height="48" style="border-bottom: #ece9d8; text-align: center; border-left: #f2f2f2; background-color: #474747; height: 36pt; border-top: #ece9d8; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">任选三中三</font></span></span></td>
            <td class="xl85" style="border-bottom: #ece9d8; border-left: #f2f2f2; background-color: #474747; border-top: #ece9d8; border-right: #474747 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">从01-11共11个号码中选择3个号码进行购买，只要当期顺序摇出的5个开奖号码中包含所选号码，即为中奖。</font></span></span></td>
            <td class="xl68" style="border-bottom: #ece9d8; border-left: #ece9d8; background-color: #474747; border-top: #ece9d8; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl90" style="border-bottom: #ece9d8; border-left: #f2f2f2; background-color: #474747; border-top: #ece9d8; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><span style="mso-spacerun: yes">&nbsp; </span>如：选择05 04 11，开奖号码为08 04 11 05 03，即为中奖。</font></span></span></td>
        </tr>
        <tr height="48" style="height: 36pt; mso-height-source: userset">
            <td class="xl71" height="48" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2; background-color: #474747; height: 36pt; border-top: #f2f2f2 0.5pt solid; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">任选四中四</font></span></span></td>
            <td class="xl79" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #f2f2f2; background-color: #474747; border-top: #f2f2f2 0.5pt solid; border-right: #474747 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">从01-11共11个号码中选择4个号码进行购买，只要当期顺序摇出的5个开奖号码中包含所选号码，即为中奖。</font></span></span></td>
            <td class="xl72" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2 0.5pt solid; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl91" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #f2f2f2; background-color: #474747; border-top: #f2f2f2 0.5pt solid; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><span style="mso-spacerun: yes">&nbsp; </span>如：选择05 04 08 03，开奖号码为08 04 11 05 03，即为中奖。</font></span></span></td>
        </tr>
        <tr height="48" style="height: 36pt; mso-height-source: userset">
            <td class="xl77" height="48" style="border-bottom: #ece9d8; text-align: center; border-left: #f2f2f2; background-color: #474747; height: 36pt; border-top: #ece9d8; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">任选五中五</font></span></span></td>
            <td class="xl85" style="border-bottom: #ece9d8; border-left: #f2f2f2; background-color: #474747; border-top: #ece9d8; border-right: #474747 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">从01-11共11个号码中选择5个号码进行购买，只要当期顺序摇出的5个开奖号码中包含所选号码，即为中奖。</font></span></span></td>
            <td class="xl68" style="border-bottom: #ece9d8; border-left: #ece9d8; background-color: #474747; border-top: #ece9d8; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl90" style="border-bottom: #ece9d8; border-left: #f2f2f2; background-color: #474747; border-top: #ece9d8; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><span style="mso-spacerun: yes">&nbsp; </span>如：选择05 04 11 03 08，开奖号码为08 04 11 05 03，即为中奖。</font></span></span></td>
        </tr>
        <tr height="48" style="height: 36pt; mso-height-source: userset">
            <td class="xl71" height="48" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2; background-color: #474747; height: 36pt; border-top: #f2f2f2 0.5pt solid; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">任选六中五</font></span></span></td>
            <td class="xl79" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #f2f2f2; background-color: #474747; border-top: #f2f2f2 0.5pt solid; border-right: #474747 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">从01-11共11个号码中选择6个号码进行购买，只要当期顺序摇出的5个开奖号码中包含所选号码，即为中奖。</font></span></span></td>
            <td class="xl72" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2 0.5pt solid; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl91" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #f2f2f2; background-color: #474747; border-top: #f2f2f2 0.5pt solid; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><span style="mso-spacerun: yes">&nbsp; </span>如：选择05 10 04 11 03 08，开奖号码为08 04 11 05 03，即为中奖。</font></span></span></td>
        </tr>
        <tr height="52" style="height: 39pt; mso-height-source: userset">
            <td class="xl77" height="52" style="border-bottom: #ece9d8; text-align: center; border-left: #f2f2f2; background-color: #474747; height: 39pt; border-top: #ece9d8; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">任选七中五<span style="mso-spacerun: yes">&nbsp;</span></font></span></span></td>
            <td class="xl85" style="border-bottom: #ece9d8; border-left: #f2f2f2; background-color: #474747; border-top: #ece9d8; border-right: #474747 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">从01-11共11个号码中选择7个号码进行购买，只要当期顺序摇出的5个开奖号码中包含所选号码，即为中奖。</font></span></span></td>
            <td class="xl68" style="border-bottom: #ece9d8; border-left: #ece9d8; background-color: #474747; border-top: #ece9d8; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl91" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #f2f2f2; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><span style="mso-spacerun: yes">&nbsp; </span>如：选择05 04 10 11 03 08 09，开奖号码为08 04 11 05 03，即为中奖。</font></span></span></td>
        </tr>
        <tr height="54" style="height: 40.5pt; mso-height-source: userset">
            <td class="xl71" height="54" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2; background-color: #474747; height: 40.5pt; border-top: #f2f2f2 0.5pt solid; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">任选八中五</font></span></span></td>
            <td class="xl79" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #f2f2f2; background-color: #474747; border-top: #f2f2f2 0.5pt solid; border-right: #474747 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">从01-11共11个号码中选择8个号码进行购买，只要当期顺序摇出的5个开奖号码中包含所选号码，即为中奖。</font></span></span></td>
            <td class="xl72" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2 0.5pt solid; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl91" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #f2f2f2; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><span style="mso-spacerun: yes">&nbsp; </span>如：选择05 04 11 03 08 10 09 01，开奖号码为08 04 11 05 03，即为中奖。</font></span></span></td>
        </tr>
    </tbody>
</table>
</p>        </div>
            <div class="help-content" id="general_table_2" style="display:none">
            <p>
<table border="0" cellspacing="0" cellpadding="0" width="100%" style="border-collapse: collapse">
    <colgroup><col width="92" style="width: 69pt; mso-width-source: userset; mso-width-alt: 2944" /><col width="122" style="width: 92pt; mso-width-source: userset; mso-width-alt: 3904" /><col width="388" style="width: 291pt; mso-width-source: userset; mso-width-alt: 12416" /><col width="22" style="width: 17pt; mso-width-source: userset; mso-width-alt: 704" /><col width="409" style="width: 307pt; mso-width-source: userset; mso-width-alt: 13088" /></colgroup>
    <tbody>
        <tr height="30" style="height: 22.5pt; mso-height-source: userset">
            <td class="xl82" height="65" colspan="5" align="center" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; height: 48.75pt; border-top: #ece9d8; border-right: #ece9d8"><span style="font-size: x-large"><span style="font-family: Tahoma"><strong><font color="#ff0000">时时乐、福彩3D</font></strong></span></span></td>
        </tr>
        <tr height="31" style="height: 23.25pt; mso-height-source: userset">
            <td class="xl68" height="31" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2 0.5pt solid; background-color: #474747; height: 23.25pt; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><strong>玩法组</strong></font></span></span></td>
            <td class="xl68" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><strong>玩法</strong></font></span></span></td>
            <td class="xl79" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2; background-color: #474747; border-top: #f2f2f2; border-right: #474747 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><strong>玩法说明</strong></font></span></span></td>
            <td class="xl71" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><strong>　</strong></font></span></span></td>
            <td class="xl71" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2 0.5pt solid; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><strong><font color="#ffffff">中奖举例</font></strong></span></span></td>
        </tr>
        <tr height="45" style="height: 33.75pt; mso-height-source: userset">
            <td class="xl81" height="139" rowspan="3" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2 0.5pt solid; background-color: #474747; height: 104.25pt; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">直选</font></span></span></td>
            <td class="xl69" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">直选复式</font></span></span></td>
            <td class="xl75" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #f2f2f2; background-color: #474747; border-top: #f2f2f2; border-right: #474747 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">从百位、十位、个位中选择一个3位数号码组成一注，所选号码与开奖号码相同，且顺序一致，即为中奖。</font></span></span></td>
            <td class="xl70" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl70" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><span style="mso-spacerun: yes">&nbsp; </span>如：百位选择1，十位选择2，个位选择3，开奖号码为是123，即为中奖。</font></span></span></td>
        </tr>
        <tr height="50" style="height: 37.5pt; mso-height-source: userset">
            <td class="xl69" height="50" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2; background-color: #474747; height: 37.5pt; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">直选单式</font></span></span></td>
            <td class="xl75" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #f2f2f2; background-color: #474747; border-top: #f2f2f2; border-right: #474747 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">手动输入一个3位数号码组成一注，所选号码与开奖号码相同，且顺序一致，即为中奖。</font></span></span></td>
            <td class="xl70" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl70" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><span style="mso-spacerun: yes">&nbsp; </span>如：手动输入123，开奖号码为是123，即为中奖。</font></span></span></td>
        </tr>
        <tr height="44" style="height: 33pt">
            <td class="xl69" height="44" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2; background-color: #474747; height: 33pt; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">直选和值</font></span></span></td>
            <td class="xl75" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #f2f2f2; background-color: #474747; border-top: #f2f2f2; border-right: #474747 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">所选数值等于开奖号码的三个数字相加之和，即为中奖。</font></span></span></td>
            <td class="xl70" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl70" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><span style="mso-spacerun: yes">&nbsp; </span>如：选择6，开奖号码为123、141、114、006、060等任意一个和值为6的结果，即为中奖。</font></span></span></td>
        </tr>
        <tr height="67" style="height: 50.25pt; mso-height-source: userset">
            <td class="xl81" height="247" rowspan="4" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2 0.5pt solid; background-color: #474747; height: 185.25pt; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">组选</font></span></span></td>
            <td class="xl69" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">组三</font></span></span></td>
            <td class="xl75" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #f2f2f2; background-color: #474747; border-top: #f2f2f2; border-right: #474747 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">从0-9中任意选择2个数字组成两注，所选号码与开奖号码相同，顺序不限，即为中奖。</font></span></span></td>
            <td class="xl70" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl70" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><span style="mso-spacerun: yes">&nbsp; </span>如：选择12（展开为122，212，221 和 112、121、211），开奖号码为212 或 121，即为中奖。</font></span></span></td>
        </tr>
        <tr height="72" style="height: 54pt; mso-height-source: userset">
            <td class="xl69" height="72" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2; background-color: #474747; height: 54pt; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">组六</font></span></span></td>
            <td class="xl75" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #f2f2f2; background-color: #474747; border-top: #f2f2f2; border-right: #474747 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">从0-9中任意选择3个号码组成一注，所选号码与开奖号码相同，顺序不限，即为中奖。</font></span></span></td>
            <td class="xl70" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl70" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><span style="mso-spacerun: yes">&nbsp; </span>如：选择123（展开为123，132，231，213，312，321），开奖号码为321，即为中奖。</font></span></span></td>
        </tr>
        <tr height="46" style="height: 34.5pt; mso-height-source: userset">
            <td class="xl69" height="46" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2; background-color: #474747; height: 34.5pt; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">组选和值</font></span></span></td>
            <td class="xl75" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #f2f2f2; background-color: #474747; border-top: #f2f2f2; border-right: #474747 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">所选数值等于开奖号码的三个数字相加之和，即为中奖。</font></span></span></td>
            <td class="xl70" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl70" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><span style="mso-spacerun: yes">&nbsp; </span>如：选择6，开奖号码为114中组三奖，开奖号码为015中组六奖。</font></span></span></td>
        </tr>
        <tr height="62" style="height: 46.5pt; mso-height-source: userset">
            <td class="xl69" height="62" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2; background-color: #474747; height: 46.5pt; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">混合组选</font></span></span></td>
            <td class="xl75" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #f2f2f2; background-color: #474747; border-top: #f2f2f2; border-right: #474747 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">手动输入购买号码，3个数字为一注，开奖号码符合组三或组六均为中奖。</font></span></span></td>
            <td class="xl70" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl70" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><span style="mso-spacerun: yes">&nbsp; </span>如：选择123、455，开奖号码为321即中组六奖，开奖号码为545即中组三奖。</font></span></span></td>
        </tr>
        <tr height="48" style="height: 36pt; mso-height-source: userset">
            <td class="xl85" height="113" rowspan="2" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2 0.5pt solid; background-color: #474747; height: 84.75pt; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">不定位</font></span></span></td>
            <td class="xl83" style="border-bottom: #ece9d8; text-align: center; border-left: #f2f2f2; background-color: #474747; border-top: #ece9d8; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">一码不定位</font></span></span></td>
            <td class="xl80" style="border-bottom: #ece9d8; border-left: #ece9d8; background-color: #474747; border-top: #ece9d8; border-right: #474747 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">从0-9中选择1个号码，每注由1个号码组成，只要开奖结果中包含所选号码，即为中奖。</font></span></span></td>
            <td class="xl70" style="border-bottom: #ece9d8; border-left: #ece9d8; background-color: #474747; border-top: #ece9d8; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl70" style="border-bottom: #ece9d8; border-left: #ece9d8; background-color: #474747; border-top: #ece9d8; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><span style="mso-spacerun: yes">&nbsp; </span>如：选择一码不定位4，开出4**、*4*、**4即为中奖。</font></span></span></td>
        </tr>
        <tr height="65" style="height: 48.75pt; mso-height-source: userset">
            <td class="xl81" height="65" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2; background-color: #474747; height: 48.75pt; border-top: #f2f2f2 0.5pt solid; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">二码不定位</font></span></span></td>
            <td class="xl73" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2 0.5pt solid; border-right: #474747 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">从0-9中选择2个号码，每注由2个不同的号码组成，开奖号码的百位、十位、个位中同时包含所选的2个号码，即为中奖。</font></span></span></td>
            <td class="xl74" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2 0.5pt solid; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl74" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2 0.5pt solid; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><span style="mso-spacerun: yes">&nbsp; </span>如：选择二码不定位4、5，开奖号码为*45、5*4、*54即为中奖。</font></span></span></td>
        </tr>
        <tr height="49" style="height: 36.75pt; mso-height-source: userset">
            <td class="xl81" height="387" rowspan="8" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2 0.5pt solid; background-color: #474747; height: 290.25pt; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">二星</font></span></span></td>
            <td class="xl69" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">前二直选复式</font></span></span></td>
            <td class="xl75" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #f2f2f2; background-color: #474747; border-top: #f2f2f2; border-right: #474747 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">从百位和十位上至少各选1个号码，所选号码与开奖号码百位、十位相同，且顺序一致，即为中奖。</font></span></span></td>
            <td class="xl70" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl70" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><span style="mso-spacerun: yes">&nbsp; </span>如：百位选择3，十位选择4，开奖号码为34*，即为中奖。</font></span></span></td>
        </tr>
        <tr height="48" style="height: 36pt; mso-height-source: userset">
            <td class="xl69" height="48" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2; background-color: #474747; height: 36pt; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">前二直选单式</font></span></span></td>
            <td class="xl75" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #f2f2f2; background-color: #474747; border-top: #f2f2f2; border-right: #474747 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">手动输入一个2位数号码组成一注，所选号码与开奖号码的百位、十位相同，且顺序一致，即为中奖。</font></span></span></td>
            <td class="xl70" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl70" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><span style="mso-spacerun: yes">&nbsp; </span>如：手动输入12，开奖号码为是12*，即为中奖。</font></span></span></td>
        </tr>
        <tr height="48" style="height: 36pt; mso-height-source: userset">
            <td class="xl69" height="48" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2; background-color: #474747; height: 36pt; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">前二组选复式</font></span></span></td>
            <td class="xl75" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #f2f2f2; background-color: #474747; border-top: #f2f2f2; border-right: #474747 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">从0-9中选2个号码组成一注，所选号码与开奖号码的百位、十位相同，顺序不限，即为中奖。</font></span></span></td>
            <td class="xl70" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl70" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><span style="mso-spacerun: yes">&nbsp; </span>如：百位选择7，十位选择8，开奖号码78*或87*，即为中奖。</font></span></span></td>
        </tr>
        <tr height="49" style="height: 36.75pt; mso-height-source: userset">
            <td class="xl69" height="49" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2; background-color: #474747; height: 36.75pt; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">前二组选单式</font></span></span></td>
            <td class="xl75" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #f2f2f2; background-color: #474747; border-top: #f2f2f2; border-right: #474747 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">手动输入购买号码，2个数字为一注，所选号码与开奖号码的百位、十位相同，顺序不限，即为中奖。</font></span></span></td>
            <td class="xl70" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl70" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><span style="mso-spacerun: yes">&nbsp; </span>如：手动输入12，开奖号码为是21*或12*，即为中奖。</font></span></span></td>
        </tr>
        <tr height="50" style="height: 37.5pt; mso-height-source: userset">
            <td class="xl69" height="50" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2; background-color: #474747; height: 37.5pt; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">后二直选复式</font></span></span></td>
            <td class="xl75" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #f2f2f2; background-color: #474747; border-top: #f2f2f2; border-right: #474747 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">从十位和个位上至少各选1个号码，所选号码与开奖号码的十位、个位相同，且顺序一致，即为中奖。</font></span></span></td>
            <td class="xl70" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl70" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><span style="mso-spacerun: yes">&nbsp; </span>如：十位选择3，个位选择4，开奖号码为*34，即为中奖。</font></span></span></td>
        </tr>
        <tr height="47" style="height: 35.25pt; mso-height-source: userset">
            <td class="xl69" height="47" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2; background-color: #474747; height: 35.25pt; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">后二直选单式</font></span></span></td>
            <td class="xl75" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #f2f2f2; background-color: #474747; border-top: #f2f2f2; border-right: #474747 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">手动输入一个2位数号码组成一注，所选号码与开奖号码的十位、个位相同，且顺序一致，即为中奖。</font></span></span></td>
            <td class="xl70" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl70" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><span style="mso-spacerun: yes">&nbsp; </span>如：手动输入12，开奖号码为是*12，即为中奖。</font></span></span></td>
        </tr>
        <tr height="48" style="height: 36pt; mso-height-source: userset">
            <td class="xl69" height="48" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2; background-color: #474747; height: 36pt; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">后二组选复式</font></span></span></td>
            <td class="xl75" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #f2f2f2; background-color: #474747; border-top: #f2f2f2; border-right: #474747 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">从0-9中选2个号码组成一注，所选号码与开奖号码的十位、个位相同，顺序不限，即为中奖。</font></span></span></td>
            <td class="xl70" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl70" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><span style="mso-spacerun: yes">&nbsp; </span>如：选择7、8，开奖号码*78或*87，即为中奖。</font></span></span></td>
        </tr>
        <tr height="48" style="height: 36pt; mso-height-source: userset">
            <td class="xl69" height="48" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2; background-color: #474747; height: 36pt; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">后二组选单式</font></span></span></td>
            <td class="xl75" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #f2f2f2; background-color: #474747; border-top: #f2f2f2; border-right: #474747 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">手动输入购买号码，2个数字为一注，所选号码与开奖号码的十位、个位相同，顺序不限，即为中奖。</font></span></span></td>
            <td class="xl70" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl70" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><span style="mso-spacerun: yes">&nbsp; </span>如：手动输入12，开奖号码为是*21或者*12，即为中奖。</font></span></span></td>
        </tr>
        <tr height="44" style="height: 33pt; mso-height-source: userset">
            <td class="xl81" height="133" rowspan="3" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2 0.5pt solid; background-color: #474747; height: 99.75pt; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">定位胆</font></span></span></td>
            <td class="xl69" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">百位</font></span></span></td>
            <td class="xl84" rowspan="3" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #f2f2f2 0.5pt solid; background-color: #474747; border-top: #f2f2f2; border-right: #474747 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">从百位、十位、个位任意1个位置或多个位置上选择1个号码，所选号码与相同位置上的开奖号码一致，即为中奖。</font></span></span></td>
            <td class="xl76" style="border-bottom: #474747 0.5pt solid; border-left: #474747; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl70" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><span style="mso-spacerun: yes">&nbsp; </span>如：定百位为3，开奖号码为3**，即为中奖。</font></span></span></td>
        </tr>
        <tr height="44" style="height: 33pt; mso-height-source: userset">
            <td class="xl69" height="44" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2; background-color: #474747; height: 33pt; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">十位</font></span></span></td>
            <td class="xl67" style="border-bottom: #ece9d8; border-left: #ece9d8; background-color: #474747; border-top: #ece9d8; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl70" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><span style="mso-spacerun: yes">&nbsp; </span>如：定十位为4，开奖号码为*4*，即为中奖。</font></span></span></td>
        </tr>
        <tr height="45" style="height: 33.75pt; mso-height-source: userset">
            <td class="xl73" height="45" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2; background-color: #474747; height: 33.75pt; border-top: #ece9d8; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">个位</font></span></span></td>
            <td class="xl77" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #474747; background-color: #474747; border-top: #474747 0.5pt solid; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl72" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #ece9d8; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><span style="mso-spacerun: yes">&nbsp; </span>如：定个位为5，开奖号码为**5，即为中奖。</font></span></span></td>
        </tr>
        <tr height="73" style="height: 54.75pt; mso-height-source: userset">
            <td class="xl85" height="146" rowspan="2" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2 0.5pt solid; background-color: #474747; height: 109.5pt; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">大小单双</font></span></span></td>
            <td class="xl81" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">前二</font></span></span></td>
            <td class="xl75" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #ece9d8"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">对百位和十位的&ldquo;大（56789）小（01234）、单（13579）双（02468）&rdquo;形态进行购买，所选号码的位置、形态与开奖号码的位置、形态相同，即为中奖。</font></span></span></td>
            <td class="xl76" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #474747 0.5pt solid; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl74" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><span style="mso-spacerun: yes">&nbsp; </span>如：百位选择大，十位选择单，开出63*即为中奖。</font></span></span></td>
        </tr>
        <tr height="73" style="height: 54.75pt; mso-height-source: userset">
            <td class="xl81" height="73" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2; background-color: #474747; height: 54.75pt; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">后二</font></span></span></td>
            <td class="xl75" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #ece9d8"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">对十位和个位的&ldquo;大（56789）小（01234）、单（13579）双（02468）&rdquo;形态进行购买，所选号码的位置、形态与开奖号码的位置、形态相同，即为中奖。</font></span></span></td>
            <td class="xl74" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl74" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><span style="mso-spacerun: yes">&nbsp; </span>如：十位选择小，个位选择双，开出*12即为中奖</font></span></span></td>
        </tr>
    </tbody>
</table>
</p>        </div>
            <div class="help-content" id="general_table_3" style="display:none">
            <p>
<table border="0" cellspacing="0" cellpadding="0" width="100%" style="border-collapse: collapse">
    <colgroup><col width="92" style="width: 69pt; mso-width-source: userset; mso-width-alt: 2944" /><col width="122" style="width: 92pt; mso-width-source: userset; mso-width-alt: 3904" /><col width="388" style="width: 291pt; mso-width-source: userset; mso-width-alt: 12416" /><col width="22" style="width: 17pt; mso-width-source: userset; mso-width-alt: 704" /><col width="409" style="width: 307pt; mso-width-source: userset; mso-width-alt: 13088" /></colgroup>
    <tbody>
        <tr height="31" style="height: 23.25pt; mso-height-source: userset">
            <td class="xl71" height="31" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2 0.5pt solid; background-color: #474747; height: 23.25pt; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><strong>玩法组</strong></font></span></span></td>
            <td class="xl71" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><strong>玩法</strong></font></span></span></td>
            <td class="xl72" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #474747 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><strong>玩法说明</strong></font></span></span></td>
            <td class="xl77" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2 0.5pt solid; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><strong>　</strong></font></span></span></td>
            <td class="xl77" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2 0.5pt solid; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><strong><font color="#ffffff">中奖举例</font></strong></span></span></td>
        </tr>
        <tr height="54" style="height: 40.5pt; mso-height-source: userset">
            <td class="xl85" height="184" rowspan="3" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2 0.5pt solid; background-color: #474747; height: 138pt; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">排三直选</font></span></span></td>
            <td class="xl81" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">直选复式</font></span></span></td>
            <td class="xl73" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #474747 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">从万位、千位、百位中选择一个3位数号码组成一注，所选号码与开奖号码前3位相同，且顺序一致，即为中奖。</font></span></span></td>
            <td class="xl74" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl74" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><span style="mso-spacerun: yes">&nbsp; </span>如：万位选择1，千位选择2，百位选择3，开奖号码为是123**，即为中奖。</font></span></span></td>
        </tr>
        <tr height="58" style="height: 43.5pt; mso-height-source: userset">
            <td class="xl81" height="58" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2; background-color: #474747; height: 43.5pt; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">直选单式</font></span></span></td>
            <td class="xl75" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #ece9d8"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">手动输入一个3位数号码组成一注，所选号码与开奖号码的万位、千位、百位相同，且顺序一致，即为中奖。</font></span></span></td>
            <td class="xl76" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #474747 0.5pt solid; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl74" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><span style="mso-spacerun: yes">&nbsp; </span>如：手动输入123，开奖号码为是123**，即为中奖。</font></span></span></td>
        </tr>
        <tr height="72" style="height: 54pt; mso-height-source: userset">
            <td class="xl81" height="72" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2; background-color: #474747; height: 54pt; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">直选和值</font></span></span></td>
            <td class="xl75" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #ece9d8"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">所选数值等于开奖号码万位、千位、百位三个数字相加之和，即为中奖。</font></span></span></td>
            <td class="xl76" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #474747 0.5pt solid; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl74" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><span style="mso-spacerun: yes">&nbsp; </span>如：选择6，开奖号码为123**、141**、114**、006**、060**等任意一个和值为6的结果，即为中奖。</font></span></span></td>
        </tr>
        <tr height="59" style="height: 44.25pt; mso-height-source: userset">
            <td class="xl85" height="228" rowspan="4" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2 0.5pt solid; background-color: #474747; height: 171pt; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">排三组选</font></span></span></td>
            <td class="xl83" style="border-bottom: #ece9d8; text-align: center; border-left: #f2f2f2; background-color: #474747; border-top: #ece9d8; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">组三</font></span></span></td>
            <td class="xl80" style="border-bottom: #ece9d8; border-left: #ece9d8; background-color: #474747; border-top: #ece9d8; border-right: #474747 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">从0-9中任意选择2个号码组成两注，所选号码与开奖号码的万位、千位、百位相同，且顺序不限，即为中奖。</font></span></span></td>
            <td class="xl70" style="border-bottom: #ece9d8; border-left: #ece9d8; background-color: #474747; border-top: #ece9d8; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl70" style="border-bottom: #ece9d8; border-left: #ece9d8; background-color: #474747; border-top: #ece9d8; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">如：选择12（展开为122**，212**，221** 和 112**、121**、211**），开奖号码为212** 或 121**，即为中奖。</font></span></span></td>
        </tr>
        <tr height="61" style="height: 45.75pt; mso-height-source: userset">
            <td class="xl81" height="61" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2; background-color: #474747; height: 45.75pt; border-top: #f2f2f2 0.5pt solid; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">组六</font></span></span></td>
            <td class="xl73" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2 0.5pt solid; border-right: #474747 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">从0-9中任意选择3个号码组成一注，所选号码与开奖号码的万位、千位、百位相同，顺序不限，即为中奖。</font></span></span></td>
            <td class="xl74" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2 0.5pt solid; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl74" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2 0.5pt solid; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><span style="mso-spacerun: yes">&nbsp; </span>如：选择123（展开为123**，132**，231**，213**，312**，321**），开奖号码为321**，即为中奖。</font></span></span></td>
        </tr>
        <tr height="54" style="height: 40.5pt; mso-height-source: userset">
            <td class="xl83" height="54" style="border-bottom: #ece9d8; text-align: center; border-left: #f2f2f2; background-color: #474747; height: 40.5pt; border-top: #ece9d8; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">组选和值</font></span></span></td>
            <td class="xl69" style="border-bottom: #ece9d8; border-left: #ece9d8; background-color: #474747; border-top: #ece9d8; border-right: #ece9d8"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">所选数值等于开奖号码万位、千位、百位三个数字相加之和，即为中奖。</font></span></span></td>
            <td class="xl70" style="border-bottom: #ece9d8; border-left: #ece9d8; background-color: #474747; border-top: #ece9d8; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl70" style="border-bottom: #ece9d8; border-left: #ece9d8; background-color: #474747; border-top: #ece9d8; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><span style="mso-spacerun: yes">&nbsp; </span>如：选择6，开奖号码为114**中组三奖，开奖号码为015**中组六奖。</font></span></span></td>
        </tr>
        <tr height="54" style="height: 40.5pt; mso-height-source: userset">
            <td class="xl81" height="54" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2; background-color: #474747; height: 40.5pt; border-top: #f2f2f2 0.5pt solid; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">混合组选</font></span></span></td>
            <td class="xl75" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2 0.5pt solid; border-right: #ece9d8"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">键盘手动输入购买号码，3个数字为一注，开奖号码的万位、千位、百位符合前三的组三或组六均为中奖。</font></span></span></td>
            <td class="xl76" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #474747 0.5pt solid; background-color: #474747; border-top: #f2f2f2 0.5pt solid; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl74" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2 0.5pt solid; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><span style="mso-spacerun: yes">&nbsp; </span>如：手动输入123、455，开奖号码为321**即中组六奖，开奖号码为545**即中组三奖。</font></span></span></td>
        </tr>
        <tr height="48" style="height: 36pt; mso-height-source: userset">
            <td class="xl85" height="113" rowspan="2" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2 0.5pt solid; background-color: #474747; height: 84.75pt; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">排三不定位</font></span></span></td>
            <td class="xl83" style="border-bottom: #ece9d8; text-align: center; border-left: #f2f2f2; background-color: #474747; border-top: #ece9d8; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">一码不定位</font></span></span></td>
            <td class="xl80" style="border-bottom: #ece9d8; border-left: #ece9d8; background-color: #474747; border-top: #ece9d8; border-right: #474747 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">从0-9中选择1个号码，每注由1个号码组成，只要开奖号码的万位、千位、百位中包含所选号码，即为中奖。</font></span></span></td>
            <td class="xl70" style="border-bottom: #ece9d8; border-left: #ece9d8; background-color: #474747; border-top: #ece9d8; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl70" style="border-bottom: #ece9d8; border-left: #ece9d8; background-color: #474747; border-top: #ece9d8; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><span style="mso-spacerun: yes">&nbsp; </span>如：选择一码不定位4，开出4****、*4***、**4**即为中奖。</font></span></span></td>
        </tr>
        <tr height="65" style="height: 48.75pt; mso-height-source: userset">
            <td class="xl81" height="65" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2; background-color: #474747; height: 48.75pt; border-top: #f2f2f2 0.5pt solid; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">二码不定位</font></span></span></td>
            <td class="xl73" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2 0.5pt solid; border-right: #474747 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">从0-9中选择2个号码，每注由2个不同的号码组成，开奖号码的万位、千位、百位中同时包含所选的2个号码，即为中奖。</font></span></span></td>
            <td class="xl74" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2 0.5pt solid; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl74" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2 0.5pt solid; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><span style="mso-spacerun: yes">&nbsp; </span>如：选择二码不定位4、5，开奖号码为*45**、*54**、4*5**、5*4**、45***、54***、即为中奖。</font></span></span></td>
        </tr>
        <tr height="49" style="height: 36.75pt; mso-height-source: userset">
            <td class="xl85" height="398" rowspan="8" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2 0.5pt solid; background-color: #474747; height: 298.5pt; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">排五二星</font></span></span></td>
            <td class="xl81" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">前二直选复式</font></span></span></td>
            <td class="xl73" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #474747 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">从万位和千位上至少各选1个号码，所选号码与开奖号码的万位、千位相同，且顺序一致，即为中奖。</font></span></span></td>
            <td class="xl74" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl74" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><span style="mso-spacerun: yes">&nbsp; </span>如：万位选择3，千位选择4，开出34***即为中奖。</font></span></span></td>
        </tr>
        <tr height="49" style="height: 36.75pt; mso-height-source: userset">
            <td class="xl81" height="49" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2; background-color: #474747; height: 36.75pt; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">前二直选单式</font></span></span></td>
            <td class="xl73" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #474747 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">手动输入一个2位数号码组成一注，所选号码与开奖号码的万位、千位相同，且顺序一致，即为中奖。</font></span></span></td>
            <td class="xl74" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl74" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><span style="mso-spacerun: yes">&nbsp; </span>如：手动输入12，开奖号码为是12***，即为中奖。</font></span></span></td>
        </tr>
        <tr height="50" style="height: 37.5pt; mso-height-source: userset">
            <td class="xl81" height="50" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2; background-color: #474747; height: 37.5pt; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">前二组选复式</font></span></span></td>
            <td class="xl73" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #474747 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">从0-9中选2个号码组成一注，所择号码与开奖号码的万位、千位相同，顺序不限，即为中奖。</font></span></span></td>
            <td class="xl74" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl74" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><span style="mso-spacerun: yes">&nbsp; </span>如：选择7、8，开奖号码78***或87***，即为中奖。</font></span></span></td>
        </tr>
        <tr height="50" style="height: 37.5pt; mso-height-source: userset">
            <td class="xl81" height="50" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2; background-color: #474747; height: 37.5pt; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">前二组选单式</font></span></span></td>
            <td class="xl73" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #474747 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">手动输入购买号码，2个数字为一注，所选号码与开奖号码的万位、千位相同，顺序不限，即为中奖。</font></span></span></td>
            <td class="xl74" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl74" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><span style="mso-spacerun: yes">&nbsp; </span>如：手动输入12，开奖号码为是21***或12***，即为中奖。</font></span></span></td>
        </tr>
        <tr height="50" style="height: 37.5pt; mso-height-source: userset">
            <td class="xl81" height="50" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2; background-color: #474747; height: 37.5pt; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">后二直选复式</font></span></span></td>
            <td class="xl73" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #474747 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">从十位和个位上至少各选1个号码，所选号码与开奖号码的十位、个位相同，且顺序一致，即为中奖。</font></span></span></td>
            <td class="xl74" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl74" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><span style="mso-spacerun: yes">&nbsp; </span>如：十位选择3，个位现在4，开奖号码为***34，即为中奖。</font></span></span></td>
        </tr>
        <tr height="50" style="height: 37.5pt; mso-height-source: userset">
            <td class="xl81" height="50" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2; background-color: #474747; height: 37.5pt; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">后二直选单式</font></span></span></td>
            <td class="xl73" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #474747 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">手动输入一个2位数号码组成一注，所选号码与开奖号码的十位、个位相同，且顺序一致，即为中奖。</font></span></span></td>
            <td class="xl74" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl74" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><span style="mso-spacerun: yes">&nbsp; </span>如：手动输入12，开奖号码为是***12，即为中奖。</font></span></span></td>
        </tr>
        <tr height="50" style="height: 37.5pt; mso-height-source: userset">
            <td class="xl81" height="50" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2; background-color: #474747; height: 37.5pt; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">后二组选复式</font></span></span></td>
            <td class="xl73" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #474747 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">从0-9中选2个号码组成一注，所选号码与开奖号码的十位、个位相同，顺序不限，即为中奖。</font></span></span></td>
            <td class="xl74" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl74" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><span style="mso-spacerun: yes">&nbsp; </span>如：选择7、8，开奖号码***78或***87即为中奖。</font></span></span></td>
        </tr>
        <tr height="50" style="height: 37.5pt; mso-height-source: userset">
            <td class="xl81" height="50" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2; background-color: #474747; height: 37.5pt; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">后二组选单式</font></span></span></td>
            <td class="xl80" style="border-bottom: #ece9d8; border-left: #ece9d8; background-color: #474747; border-top: #ece9d8; border-right: #474747 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">手动输入购买号码，2个数字为一注，所选号码与开奖号码的十位、个位相同，顺序不限，即为中奖。</font></span></span></td>
            <td class="xl74" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl74" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><span style="mso-spacerun: yes">&nbsp; </span>如：手动输入12，开奖号码为是***21或者***12，即为中奖。</font></span></span></td>
        </tr>
        <tr height="32" style="height: 24pt; mso-height-source: userset">
            <td class="xl85" height="160" rowspan="5" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2 0.5pt solid; background-color: #474747; height: 120pt; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">排五定位胆</font></span></span></td>
            <td class="xl81" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">万位</font></span></span></td>
            <td class="xl86" rowspan="5" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #f2f2f2 0.5pt solid; background-color: #474747; border-top: #f2f2f2 0.5pt solid; border-right: #ece9d8"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">从万位、千位、百位、十位、个位任意1个位置或多个位置上选择1个号码，所选号码与相同位置上的开奖号码一致，即为中奖。</font></span></span></td>
            <td class="xl78" style="border-bottom: #ece9d8; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl78" style="border-bottom: #ece9d8; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><span style="mso-spacerun: yes">&nbsp; </span>如：定万位为1，开奖号码为1****即为中奖。</font></span></span></td>
        </tr>
        <tr height="32" style="height: 24pt; mso-height-source: userset">
            <td class="xl81" height="32" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2; background-color: #474747; height: 24pt; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">千位</font></span></span></td>
            <td class="xl70" style="border-bottom: #ece9d8; border-left: #ece9d8; background-color: #474747; border-top: #ece9d8; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl74" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2 0.5pt solid; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><span style="mso-spacerun: yes">&nbsp; </span>如：定千位为2，开奖号码为*2***即为中奖。</font></span></span></td>
        </tr>
        <tr height="32" style="height: 24pt; mso-height-source: userset">
            <td class="xl81" height="32" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2; background-color: #474747; height: 24pt; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">百位</font></span></span></td>
            <td class="xl70" style="border-bottom: #ece9d8; border-left: #ece9d8; background-color: #474747; border-top: #ece9d8; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl70" style="border-bottom: #ece9d8; border-left: #ece9d8; background-color: #474747; border-top: #ece9d8; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><span style="mso-spacerun: yes">&nbsp; </span>如：定百位为3，开奖号码为**3**即为中奖。</font></span></span></td>
        </tr>
        <tr height="32" style="height: 24pt; mso-height-source: userset">
            <td class="xl81" height="32" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2; background-color: #474747; height: 24pt; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">十位</font></span></span></td>
            <td class="xl70" style="border-bottom: #ece9d8; border-left: #ece9d8; background-color: #474747; border-top: #ece9d8; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl74" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2 0.5pt solid; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><span style="mso-spacerun: yes">&nbsp; </span>如：定十位为4，开奖号码为***4*即为中奖。</font></span></span></td>
        </tr>
        <tr height="32" style="height: 24pt; mso-height-source: userset">
            <td class="xl84" height="32" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2; background-color: #474747; height: 24pt; border-top: #ece9d8; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">个位</font></span></span></td>
            <td class="xl79" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #ece9d8; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl79" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #ece9d8; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><span style="mso-spacerun: yes">&nbsp; </span>如：定个位为5，开奖号码为****5即为中奖。</font></span></span></td>
        </tr>
        <tr height="73" style="height: 54.75pt; mso-height-source: userset">
            <td class="xl85" height="146" rowspan="2" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2 0.5pt solid; background-color: #474747; height: 109.5pt; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">排五大小单双</font></span></span></td>
            <td class="xl81" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">前二</font></span></span></td>
            <td class="xl75" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #ece9d8"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">对万位和千位的&ldquo;大（56789）小（01234）、单（13579）双（02468）&rdquo;形态进行购买，所选号码的位置、形态与开奖号码的位置、形态相同，即为中奖。</font></span></span></td>
            <td class="xl76" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #474747 0.5pt solid; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl74" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><span style="mso-spacerun: yes">&nbsp; </span>如：万位选择大，千位选择单，开出63***即为中奖。</font></span></span></td>
        </tr>
        <tr height="73" style="height: 54.75pt; mso-height-source: userset">
            <td class="xl81" height="73" style="border-bottom: #f2f2f2 0.5pt solid; text-align: center; border-left: #f2f2f2; background-color: #474747; height: 54.75pt; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">后二</font></span></span></td>
            <td class="xl75" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #ece9d8"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">对十位和个位的&ldquo;大（56789）小（01234）、单（13579）双（02468）&rdquo;形态进行购买，所选号码的位置、形态与开奖号码的位置、形态相同，即为中奖。</font></span></span></td>
            <td class="xl74" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff">　</font></span></span></td>
            <td class="xl74" style="border-bottom: #f2f2f2 0.5pt solid; border-left: #ece9d8; background-color: #474747; border-top: #f2f2f2; border-right: #f2f2f2 0.5pt solid"><span style="font-size: small"><span style="font-family: Tahoma"><font color="#ffffff"><span style="mso-spacerun: yes">&nbsp; </span>如：十位选择小，个位选择双，开出***12即为中奖</font></span></span></td>
        </tr>
    </tbody>
</table>
</p>        </div>
    
</div>
<div id="footer"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td align="center"><table align="center" width="450">
<tr><td align="left">浏览器建议：首选IE 8.0浏览器，其次为火狐浏览器。</td></tr>
</table></td></tr><tr><td></td></tr></table></div>
<br/><br/>
</div></div>
<?php echo $count?>
</BODY></HTML>;