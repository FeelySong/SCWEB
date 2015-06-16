<?php
//error_reporting(0);
require_once 'conn.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD><TITLE><?php echo $webname;?> </TITLE>
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
</SPAN><DIV style="clear:both"></DIV></H1>
<STYLE>
.info{line-height:21px;padding:8px 0px;}
.info div{line-height:18px;font-size:12px;padding:0px;margin:0px;}
div .q{color:#222;padding-left:18px;padding-top:3px;}
div .a{color:#070;padding-left:18px;padding-top:3px;padding-bottom:12px;}
.ld .nl{width:150px;font-weight:bold;color:#21366D;text-align:right;padding-right:11px}
</STYLE>
<script language="javascript" src="js/dialog/jquery.dialogUI.js"></script>
<SCRIPT language="javascipt" type="text/javascript">
(function($){
$(document).ready(function(){
	$("#getmyegg").click(function(){
		$.blockUI({
            message: "<div style='border:1px solid #666666; padding:5px 30px; background-color:#FFFFFF;'><img src='images/comm/loading.gif'>&nbsp;正在抽取您的幸运龍蛋......</div>",
            overlayCSS: {backgroundColor: '#000000',opacity: 0.3,cursor:'wait'}
            });
		$.ajax({
			type: "POST",
		    url: "./promotion_center.php",
		    data: "flag=getluckegg",
		    success: function(data){
				$.unblockUI({fadeInTime: 0, fadeOutTime: 0});
				var partn = /<script.*>.*<\/script>/;
				//alert(data);return false;
				if( partn.test(data) ){
					alert('请重新登录！');
					top.location.href="./";
					return false;
				}
				eval("data = "+ data +";");
				if( data.error=='yes' ){
					alert(data.msg);
					return false;
				}else{
			    	$.alert("<img src='images/promotion/egg"+data.egg+".png'><br />"+data.msg,'中奖提示',function(){
						document.location.reload();
					});
					return true;
				}
		    }
		});
	});
});
})(jQuery);
</SCRIPT>
<div class="tab-div">

<div class="ld" style='width:99%;margin:5px 0px 0px 0px;'>
<table width="100%" class="ct" border="0" cellspacing="0" cellpadding="0">
<form action="" method="post" name="drawform" id="drawform">
	<input type="hidden" name="flag" value="getgift" />
<tr>
	<td class="nl" style="color:#FF6633;">回馈活动第二期：</td>
	<td STYLE='line-height:20px;padding:5px 0px'><font style="font-size:16px;color:#F30;font-weight:bold;">龍年拿龍蛋，幸运九重“添”</font>
	</td>
</tr>
<tr>
	<td class="nl">活动日期</td>
    <td class='info' style="font-size:14px;">
<font color="#0033FF">2012年2月20日早上9点</font>&nbsp;&nbsp;至&nbsp;&nbsp;<font color="#0033FF">2012年3月15日凌晨2点</font>  <br/>
	</td>
</tr>
<tr>
	<td class="nl">活动内容</td>
    <td class='info' style="font-size:14px;">
<font color="#FF0000"><strong>奖上加奖！</strong></font>凡在首存有效期内充值成功，则可获取&nbsp;<font color="#FF3300">50%</font>&nbsp;首存红利；还可同时参与抽取龍蛋的活动，获取额外红利，最高加送&nbsp;<font color="#FF0000"><strong>100%</strong></font><br/>	</td>
</tr>
<tr>
	<td class="nl" valign="top"><br />活动规则</td>
    <td class='info' style="font-size:12px;line-height:25px;">
    1, <font color="#0066FF"><b>首存有效期</b></font> 截至为 <font color="#FF6600">2012年2月29日凌晨2点</font>。<br/>
    &nbsp;&nbsp;&nbsp;红利和龍蛋领取截至日期为 2012年3月15日凌晨2点。<br />
    &nbsp;&nbsp;&nbsp;有效投注额累计计算截至日期为 2012年3月15日凌晨2点。<br />
	2, 本优惠活动适用于所有存款账户。<br/>
    3, 本优惠活动适用于如下任何一种支付方式：工行、农行、建行或者财付通<br/>
    4, 本次优惠活动红利分为两个部分：一是自2012年2月20日早上9点后第一次充值成功后，即可获取50%首存红利；<br/>
    &nbsp;&nbsp;&nbsp;第二部分是额外红利，凡充值成功后，登录本页面即可参与抽取幸运龍蛋的活动。<br/>
    &nbsp;&nbsp;&nbsp;本娱乐平台将根据玩家抽取龍蛋所对应的奖金比例，额外赠送红利，可获得总红利累计高达 <font color="#FF0000" size="+1">9999</font> <br/>
    5, 自活动开始（2012年2月20日早上9点），凡累计有效投注额达到首存金额和总红利金额总数的20倍，则可通过下方【领取红包】，获得红利。<br/>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;例子：<br/>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;首存金额为：1000<br/>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;则首存红利为：1000 × 50% = 500<br/>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;若抽中龍蛋为金龍，比例为100%<br/>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;则额外红利为：1000 × 100% = 1000<br/>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;总红利金额 = 首存红利 + 额外红利 = 500 + 1000 =1500<br/>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;累计有效投注额 =（首存金额+总红利金额） × 20 =（1000 + 1500）×20 = 50000<br/>
    6, 累计有效投注额是指开奖以后的实际投注额，不包括撤单和未开奖的投注。<br/>
    7, 活动期间玩家提现不受活动限制，仅领取红利时需达到相应累计有效投注额。<br/>
    8, 此优惠活动每个账户，仅可申请一次。<br/>
    9, 本次优惠活动共提供九种龍蛋，请参见如下介绍。<br/>
        <table>
        <tr>
            <td align="center">&nbsp;&nbsp;<img src='images/promotion/egg1.png' width="45" height="62">&nbsp;&nbsp;</td>
            <td align="center">&nbsp;&nbsp;<img src='images/promotion/egg2.png' width="45" height="62">&nbsp;&nbsp;</td>
            <td align="center">&nbsp;&nbsp;<img src='images/promotion/egg3.png' width="45" height="62">&nbsp;&nbsp;</td>
            <td align="center">&nbsp;&nbsp;<img src='images/promotion/egg4.png' width="45" height="62">&nbsp;&nbsp;</td>
            <td align="center">&nbsp;&nbsp;<img src='images/promotion/egg5.png' width="45" height="62">&nbsp;&nbsp;</td>
            <td align="center">&nbsp;&nbsp;<img src='images/promotion/egg6.png' width="45" height="62">&nbsp;&nbsp;</td>
            <td align="center">&nbsp;&nbsp;<img src='images/promotion/egg7.png' width="45" height="62">&nbsp;&nbsp;</td>
            <td align="center">&nbsp;&nbsp;<img src='images/promotion/egg8.png' width="45" height="62">&nbsp;&nbsp;</td>
            <td align="center">&nbsp;&nbsp;<img src='images/promotion/egg9.png' width="45" height="62">&nbsp;&nbsp;</td>
        </tr><tr>
            <td align="center">&nbsp;风龍<br /><font color="#0066CC">一福千金</font><br /><font size="+1" color="#FF0000">10%</font>&nbsp;</td>
            <td align="center">&nbsp;火龍<br /><font color="#0066CC">双喜临门</font><br /><font size="+1" color="#FF0000">20%</font>&nbsp;</td>
            <td align="center">&nbsp;雪龍<br /><font color="#0066CC">招财进宝</font><br /><font size="+1" color="#FF0000">30%</font>&nbsp;</td>
            <td align="center">&nbsp;青龍<br /><font color="#0066CC">四季发财</font><br /><font size="+1" color="#FF0000">40%</font>&nbsp;</td>
            <td align="center">&nbsp;蓝龍<br /><font color="#0066CC">五谷丰登</font><br /><font size="+1" color="#FF0000">50%</font>&nbsp;</td>
            <td align="center">&nbsp;紫龍<br /><font color="#0066CC">六畜兴旺</font><br /><font size="+1" color="#FF0000">60%</font>&nbsp;</td>
            <td align="center">&nbsp;铜龍<br /><font color="#0066CC">步步高升</font><br /><font size="+1" color="#FF0000">70%</font>&nbsp;</td>
            <td align="center">&nbsp;银龍<br /><font color="#0066CC">八方来财</font><br /><font size="+1" color="#FF0000">80%</font>&nbsp;</td>
            <td align="center">&nbsp;金龍<br /><font color="#0066CC">财源广进</font><br /><font size="+1" color="#FF0000">100%</font>&nbsp;</td>
        </tr>
        </table><br/>
    10, 本娱乐平台将对本次活动全程监控，活动禁止违规操作，如有发现，将取消活动资格。<br/>
	</td>
</tr>
	    
                <tr>
        <td style="border-left:1px solid #E5E5E5;">&nbsp;</td>
        <td height="30"><font color="#0066FF">友情提示：</font><font color="#FF0000" size="+1">您还没有充值，请先充值才能参加活动！</font></td>
    </tr>
                
    </form>
</table>
</div>
<div id="footer"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td align="center"><table align="center" width="450">
<tr><td align="left">浏览器建议：首选IE 8.0浏览器，其次为火狐浏览器。</td></tr>
</table></td></tr><tr><td></td></tr></table></div>
<br/><br/>
</div></div>
<?php echo $count?>
</BODY></HTML>