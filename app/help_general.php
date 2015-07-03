<?php
//error_reporting(0);
require_once 'conn.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD><TITLE><?php echo $webname;?>  - 常见问题</TITLE>
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

<H1>
<SPAN class="action-span1"><DIV class='icons_mb1'></DIV>当前位置: <A href="/" target='_top'><?php echo $webname;?></a>
 - 常见问题 </SPAN><DIV style="clear:both"></DIV></H1>
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
	    <span class="tab-front"  id="general_tab_00">
		  <span class="tabbar-left"></span>
		  <span class="content">玩法介绍</span>
		  <span class="tabbar-right"></span>
		</span>
		<span class="tab-front"  id="general_tab_0">
		  <span class="tabbar-left"></span>
		  <span class="content">工行充值</span>
		  <span class="tabbar-right"></span>
		</span>
			<span class="tab-back"  id="general_tab_1">
		  <span class="tabbar-left"></span>
		  <span class="content">建行充值</span>
		  <span class="tabbar-right"></span>
		</span>
			<span class="tab-back"  id="general_tab_2">
		  <span class="tabbar-left"></span>
		  <span class="content">农行充值</span>
		  <span class="tabbar-right"></span>
		</span>
			<span class="tab-back"  id="general_tab_3">
		  <span class="tabbar-left"></span>
		  <span class="content">提现说明</span>
		  <span class="tabbar-right"></span>
		</span>
			<span class="tab-back"  id="general_tab_4">
		  <span class="tabbar-left"></span>
		  <span class="content">平台充值免责声明</span>
		  <span class="tabbar-right"></span>
		</span>
			<span class="tab-back"  id="general_tab_5">
		  <span class="tabbar-left"></span>
		  <span class="content">常见问题帮助</span>
		  <span class="tabbar-right"></span>
		</span>
	</div>
  <div class="tabbar-bottom"></div>
            <div class="help-content" id="general_table_00" >
                <div class="help_t_int">
 <p class="f_center">
<strong>彩票“重庆时时彩”游戏规则</strong>
</p>
<p>
<strong>第一章　 游戏介绍</strong>
</p>
<p>“时时彩”分为“星彩玩法”以及“大小单双玩法”“二星组选”</p>
<p>1、星彩玩法分为一星、二星、三星、五星四种玩法。“时时彩”每期开奖号码为一个五位数号码，分为个、十、百、千、万位。</p>
<p>1）一星采用的是开奖号的最后一位（即个位），单注中奖18元；</p>
<p>2）二星采用的是开奖号的后两位（即十位、个位），单注中奖180元；</p>
<p>3）三星采用的是开奖号的后三位（即百位、十位、个位），单注中奖1800元；</p>
<p>4）五星则代表5位全部（即万位、千位、百位、十位、个位）单注中奖180,000元。</p>
<p>无论采用几星投注方式，每注彩票的金额均为2元。</p>
<p>2、大小单双玩法是指猜时时彩“个位”和“十位”这两个位置的“大小、单双”玩法，即把10个自然数按“大”、“小”或“单”、“双”性质分为两组，0-4为小号，5-9为大号，0、2、4、6、8为双号，1、3、5、7、9为单号。投注者可对“个位、十位”的数字进行“大小、单双”的指定投注。投注者投注的号码位置、性质与开奖号码位置、性质相同即中奖。单注投注金额2元，单注中奖金额为4元。</p>
<p>3、附加玩法.</p>
<p>二星组选是“时时彩二星”的附加玩法。是指投注者可在从0-9个数字中任选两个不同的数字对十个位进行投注。所选的号码与当期开奖号码相同（与3D组选一样顺序不限），即为中奖。</p>
<p>例如：例如：二星组选投注号码为81，开奖号码的十位、个位为18或者81都中奖。 二星组选中奖概率:1/55()</p>
<p>
<strong>第二章　 投　 注</strong>
</p>
<p>1、投注者可在所有经福利彩票发行中心批准、并展示《中国福利彩票“时时彩”销售许可证》的投注站和网站投注。</p>
<p>2、投注者可选择服务平台投注或投注卡、银行卡投注，并遵守相应规范。</p>
<p>3、按不同游戏，投注方法可分自选和机选号码投注；单倍和多倍投注。</p>
<p>4、通过投注单投注时，按照投注单上的要求及所示方法正确填涂。</p>
<p>5、投注号码经投注机确认，打印在“时时彩”电脑福利彩票上，作为对奖凭证，交投注者保存。</p>
<p>6、每注投注金额为人民币2元，每张彩票可打印1―5注投注号码，投注者可选择多倍投注。</p>
<p>7、投注前彩民应对投注进行确认，彩票售出后不得退换。</p>
<p>8、如因投注机或通讯故障，投注站销售金额受限等原因造成投注不成功，投注站应立即退还相应收取的投注金额，彩民可选择到其它投注站投注或服务平台投注的方式。如使用卡投注，系统将在一个工作日内返回相应投注款。</p>
<p>9、每期的每个投注号码的投注注数，根据市场销售情况限量发行。如投注号码受限，投注不能成功，属时时彩游戏规则规定的正常运行情况，投注者只能在该号码恢复销售后继续投注。</p>
<p>11、未成年人不得参与投注。</p>
<p>
<strong>第三章　 奖金设置</strong>
</p>
<p>1、每期销售总额的 50 %计提当期返奖奖金。设置奖池，奖池由当期计提奖金与实际中出奖金的差额以及弃奖奖金组成。当期实际中出奖金未达当期计提奖金时，余额进入奖池；当期实际中出奖金超过当期计提奖金时，差额由奖池补充。当奖池总额不足时，由发行经费垫支。</p>
<p>2、“星彩”游戏共设四个奖等，固定设奖，单注奖额分别为五星奖180，000元、三星奖1800元、二星奖180元、一星奖18元。</p>
<p>3、“星彩”游戏5星复式，将1星、2星、3星、5星组合投注在一张彩票上，按实际中得奖等，合并计算奖金。奖金设置分别适用1星、2星、3星、5星中奖条件。</p>
<p>
<strong>第四章 　开 　奖</strong>
</p>
<p>1、每10分钟开奖一次,开奖通过电子开奖系统进行。开奖结果由视频信号或公众媒体播出。</p>
<p>2、销售截止，销售数据收集完毕，通过电子签名进行不可更改的电子加密后，方可正式开奖。</p>
<p>3、中奖号码由电子开奖系统产生。开奖时按个、十、百、千、万位先后产生5个号码组成中奖号码。例如，如依次产生的5个号码分别为：4，0，1，3，5。那么“53104”的数字排列序列称为中奖号码。</p>
<p>4、福利彩票发行中心根据中奖号码进行检索、派彩，产生当期各奖等中奖注数及总奖额。</p>
<p>5、各期开奖后，立即通过网络向投注终端发布中奖号码和开奖结果。</p>
<p>
<strong>第五章　 中　 奖</strong>
</p>
<p>按投注号码与中奖号码按位相符情况确定中奖奖级，中奖号码从个位对起：</p>
<p>按“星”级进行对奖，即五星方式限对特等奖，三星方式限对一等奖，二星方式限对二等奖，一星方式限对三等奖，互不混对。凡符合下列情况的，即获得相应中奖资格：</p>
<p>5星奖：单注投注号码的5个号码与当期中奖号码的5位号码按位全部相符，即中奖；</p>
<p>3星奖：单注投注号码与当期中奖号码的连续后3位号码按位相符（百位+十位+个位），即中奖；</p>
<p>2星奖：单注投注号码与当期中奖号码的连续后2位号码按位相符（十位+个位），即中奖；</p>
<p>1星奖：单注投注号码与当期中奖号码的个位号码按位相符，即中奖；</p>
<p>
<strong>
</strong>
</p>
<p>
<strong>时时彩 玩法附则</strong>
</p>
<p>第一条</p>
<p>根据财政部《彩票发行与销售管理暂行规定》以及中国福利彩票发行管理中心有关规则,结合计算机网络技术和数字型彩票的特点，结合《数字型电脑福利彩票"时时彩"游戏规则》之相关条款，制定本附则</p>
<p>第二条</p>
<p>本附则是《数字型电脑福利彩票"时时彩"游戏规则》之附加规则。《数字型电脑福利彩票"时时彩"游戏规则》之有关规则均适用于本附则</p>
<p>第三条</p>
<p>个位和十位的两个位置"猜大小，猜单双"附加玩法，即把10个自然数按"大""小"，或者"单"，"双" 性质分为两组，0-4为小号，5-9为大号。0，2，4，6，8 为双号。1，3，5，7，9 为单号。投注者可对个位和十位的数字性质进行投注，投注者投注的号码位置、性质与开奖号码位置、性质相同即中奖。单注投注金额为2元。</p>
<p>投注示例如下：</p>
<p>猜十位和个位为"大小"投注：----大小</p>
<p>猜十位和个位为"单双投注：-----单双</p>
<p>第四条</p>
<p>二星"组选二"附加玩法，即投注者可在0-9这10个自然数中任意选择2个或者2个以上的不同的数字，对十位和个位进行投注，所选号码与当期开奖号码相同且顺序不限，即该注彩票中奖。例如，开奖号码为:34 ,彩票为 二星组选34 、43 之一均视为中奖。选择2个不同数字进行组选投注视为1注，单注投注金额为2元。 投注示例如下：</p>
<p>对十位、个位进行二星"组选二"投注：二星组选二 34</p>
<p>第五条</p>
<p>"五星通选"附加玩法，即投注者在00000-99999中选择一个五位数进行投注，所选择的五位数与开奖号码数字全部相同且排列一致，则中的"五星通选"一等奖；如所选择的五位数的首或尾连续三个数与开奖号码首或尾三位数数字相同且排列一致则中得"五星通选"二等奖；依次类推。每个位置上的选择一个号进行投注视为一注。单注投注金额2元。 投注示例如下：</p>
<p>"五星通选"投注：五星通选 12345</p>
<p>第六条</p>
<p>各附加玩法按"时时彩"销售期销售，并按"时时彩"期号编排</p>
<p>第七条</p>
<p>各附加玩法可在全市开通"时时彩"销售特权的电脑福利彩票投注站中进行投注。投注方法可分自选投注和机选投注；当期投注和多期投注；单倍投注和多倍投注。</p>
<p>第八条</p>
<p>投注站为有纸投注，投注号码经投注机打印出票，确认无误后，交投注者保存，该打印票即为"时时彩"投注电脑福利彩票，该彩票是中奖者唯一的对奖凭证。此打印票不记名，不挂失，不返还本金。</p>
<p>第九条</p>
<p>自选投注是由投注者自行选定，输入投注机进行投注；机选投注是由投注机随即产生，进行投注。</p>
<p>第十条</p>
<p>当期投注是指只购买当期的彩票，多期投注是指购买从当期起连续若干期的彩票；多倍投注是指购买多倍的投注。</p>
<p>第十一条</p>
<p>"猜大小、猜单双" 采用固定设奖，单注奖金为4元。当期每注只有一次中奖机会，不能兼中兼得，特别设奖除外。</p>
<p>示例：</p>
<p>投注：</p>
<p>-----大小，开奖号码为87654或00092 都中奖，奖金4元；开奖号码为87655或00099都未中奖；</p>
<p>-----单双，开奖号码为87654或00092都中奖，奖金为4元；开奖号码为87655或00099则未中奖。</p>
<p>第十二条</p>
<p>二星"组选二" 采用固定设奖结构，单注中奖奖金为50元。当期每注号码只有一次中奖机会，不能兼中兼得，特别设奖除外。</p>
<p>示例：</p>
<p>投注：二星组选二 34，开奖号码为15134 ，或者15143 均中奖，奖金为50元。开奖号码为34151，或15341则未中奖。</p>
<p>第十三条</p>
<p>"五星通选"采用固定设奖结构，当期每注号码可兼中兼得，特别设奖除外。</p>
<p>示例：</p>
<p>以开奖号码为12345为例：</p>
<p>一等奖，彩票5位数号码与中奖号码5位数号码与中奖号码数字相同且排列一致，如彩票12345；</p>
<p>二等奖，彩票号码中首或尾连续3位数号码与中奖号码首或尾连续3位数数字相同且排列一致，如彩票12356，34345；</p>
<p>三等奖，彩票号码中首或为连续2位数号码与中奖号码首或尾连续2位数数字相同且排列一致，如彩票12456，34545.</p>
<p>第十四条</p>
<p>附加玩法返奖资金为当期销售额的50%，与"时时彩" 共用奖池，奖池资金由单注奖金以元为单位取整后的余额以及未中出奖金、弃奖奖金构成。</p>
<p>第十五条</p>
<p>兑奖时间 、期限、方法均同"时时彩"游戏规则。</p>
<p>第十六条</p>
<p>本附则由是福利彩票中心解释、修订</p>
<p>第十七条</p>
<p>本附则自发布之日起实施，原附则自行废止。</p>
<p>
<strong>
</strong>
</p>
<p>
<strong>电脑福利彩票时时彩三星幸运游戏规则</strong>
</p>
<p>第一条</p>
<p>根据财政部《彩票发行与销售管理暂行规定》以及中国福利彩票发行管理中心有关规则,结合计算机网络技术和数字型彩票的特点，结合《数字型电脑福利彩票"时时彩"游戏规则》之相关条款，制定本附则</p>
<p>第二条</p>
<p>本附则是《数字型电脑福利彩票"时时彩"游戏规则》之附加规则。《数字型电脑福利彩票"时时彩"游戏规则》之有关规则均适用于本附则</p>
<p>第三条</p>
<p>电脑福利彩票时时彩三星幸运附加玩法（以下简称三星幸运），是指将三星投注号码的所有排列方式作为一注投注号码进行的单注投注。如果一注号码的三个数字各不相同，则有6种不同的排列方式，有6个中奖机会，这种投注方式成为"幸运包号" ；如果一注号码的三个数字中有两个数字相同，则有3个不同的排列方式，有3个中奖机会。这种投注方式成为"幸运包对"，单注投注金额人民币2元</p>
<p>投注示例:</p>
<p>幸运包号投注:123;幸运包对投注，113</p>
<p>第四条</p>
<p>三星幸运按时时彩销售期销售，并按时时彩期号编排。</p>
<p>第五条</p>
<p>三星幸运为有纸投注，投注号码经投注机打印出票，确认无误后，交投注者保存，该打印票即为三星幸运彩票，该彩票是中奖者唯一的对奖凭证。此打印票不记名，不挂失，不返还本金。</p>
<p>第六条</p>
<p>三星幸运可在全市开通"时时彩"的投注站进行投注。投注方法可分自选投注和机选投注；当期投注和多期投注；单倍投注和多倍投注。</p>
<p>第七条</p>
<p>自选投注是由投注者自行选定，输入投注机进行投注；机选投注是由投注机随即产生，进行投注。</p>
<p>第八条</p>
<p>当期投注是指只购买当期的彩票，多期投注是指购买从当期起连续若干期的彩票；多倍投注是指购买多倍的投注。</p>
<p>第九条</p>
<p>三星幸运采用固定设奖，幸运包号单注中奖奖金为160元，幸运包对单注中奖奖金为320.当期每注号码只有一次中奖机会，不能兼中兼得。特别设奖除外。</p>
<p>中奖示例：</p>
<p>幸运包号投注为123，当期时时彩开奖号码的后三位为123，132，213，231，321，312 均中奖，奖金为160元。幸运包对投注为：113，当期时时彩的开奖号码的后三位为：113，131，311均中奖，奖金为320元。</p>
<p>第十条</p>
<p>三星幸运兑奖时间、期限、方法均同时时彩游戏规则</p>
<div class="pageBreak">
</div>
<p>
<strong>五星通选：</strong>
</p>
<p>从万、千、百、十、个位各选1个或多个号码，单注金额为2元。所选号码与开奖号码一一对应奖金为2万元。所选号码前三位或后三位与开奖一一对应，奖金为200元，前二位或者后二位与开奖一一对应，奖金为20元。</p>
<p>例：</p>
<p>开奖号码：<strong>
<font color="red">1 2 3 4 5</font>
</strong>
</p>
<p>投注号码：<strong>
<font color="#1e50a2">1 2 3 4 5</font>
</strong>
</p>
<p>五个号码全部命中，获得奖金20000元</p>
<p>开奖号码：<strong>
<font color="red">1 2 3 4 5</font>
</strong>
</p>
<p>投注号码：<strong>
<font color="#1e50a2">1 2 3</font>
</strong>6 7（或6 7 <strong>
<font color="#1e50a2">3 4 5</font>
</strong>）</p>
<p>命中前三位或后三位号码，获得奖金200元</p>
<p>开奖号码：<strong>
<font color="red">1 2 3 4 5</font>
</strong>
</p>
<p>投注号码：<strong>
<font color="#1e50a2">1 2</font>
</strong>5 6 7（或3 2 1 <strong>
<font color="#1e50a2">4 5</font>
</strong>）</p>
<p>命中前二位或后二位号码，获得奖金20元</p>
<p>
<strong>
</strong>
</p>
<p>
<strong>
</strong>&nbsp;</p>
<p>
<strong>五星复式：</strong>
</p>
<p>从个、十、百、千、万位各选1个或多个号码，所选号码与开奖号码一一对应，即为中奖，2元一注，单注奖金18万元。</p>
<p>例：</p>
<p>开奖号码：<strong>
<font color="red">1 2 3 4 5</font>
</strong>
</p>
<p>投注号码：<strong>
<font color="#1e50a2">1 2 3 4 5</font>
</strong>
</p>
<p>五个号码全部命中，获得奖金180000元</p>
<p>
<strong>
</strong>
</p>
<p>
<strong>
</strong>&nbsp;</p>
<p>
<strong>三星复式：</strong>
</p>
<p>竞猜开奖号码后三位，分别选择百位、十位和个位的1个或多个号码投注，奖金1800元。</p>
<p>例：</p>
<p>开奖号码：<strong>
<font color="red">1 2 3 4 5</font>
</strong>
</p>
<p>投注号码：<strong>
<font color="#1e50a2">3 4 5</font>
</strong>
</p>
<p>命中后三位号码，获得奖金1800元。</p>
<p>
<strong>
</strong>
</p>
<p>
<strong>
</strong>&nbsp;</p>
<p>
<strong>三星和值：</strong>
</p>
<p>和值是复式投注的一种，根据购买者选定的和值计算出对应玩法下的数字组合方案，并以此进行复式投注。</p>
<p>在三星和值投注中，和值的计算方式是取3位数的百位、十位、个位的三个数字进行相加，故和值的范围是0~27。</p>
<p>如果通过和值生成选号中的号码全部猜中，奖金1800元 。</p>
<p>
<strong>
</strong>
</p>
<p>
<strong>
</strong>&nbsp;</p>
<p>
<strong>三星组三：</strong>
</p>
<p>三星组三投注即从0~9中选择两个数字，指定其一为重复两次的数字，形成一注注彩票的投注。</p>
<p>如果命中此有个数字重复的三位数，则获得奖金320元。</p>
<p>
<strong>
</strong>
</p>
<p>
<strong>
</strong>&nbsp;</p>
<p>
<strong>三星组六：</strong>
</p>
<p>竞猜开奖号码后三位，选择3个或以上号码投注，如果开奖号码后三位的三个数字各不相同，且全部猜中奖金160元。</p>
<p>
<strong>
</strong>
</p>
<p>
<strong>二星复式：</strong>
</p>
<p>竞猜开奖号码后两位，分别选择十位和个位的1个或多个号码投注，全部猜中奖金180元。</p>
<p>例：</p>
<p>开奖号码：<strong>
<font color="red">1 2 3 4 5</font>
</strong>
</p>
<p>投注号码：<strong>
<font color="#1e50a2">4 5</font>
</strong>
</p>
<p>命中后两位号码，获得奖金180元</p>
<p>
<strong>
</strong>
</p>
<p>
<strong>
</strong>&nbsp;</p>
<p>
<strong>二星和值：</strong>
</p>
<p>在时时彩二星和值投注中，和值的计算方式是取后2位数的十位、个位的两个数字进行相加，故和值的范围是0~18。</p>
<p>例：当选择和值“2”做为选号依据时，玩法中十位、个位之和为2的共有3组数字，分别为：</p>
<p>02、20、11，同时形成三注彩票；</p>
<p>当选择的和值数字为多个时，例如“1”和“2”，则将和值为“1”与“2”的组合进行同时投注，形成5注彩票。</p>
<p>
<strong>
</strong>
</p>
<p>
<strong>
</strong>&nbsp;</p>
<p>
<strong>二星组选：</strong>
</p>
<p>二星组选从0-9中选2个或多个不同的号码对十位、个位投注，位置不限。投注号码与与当期开奖号码相同（位置不限）即中奖。单注投注金额2元，单注中奖金额为50元。</p>
<p>例如：当投注号码“45”时，无论开奖号码后两位是“45”或“54”，都为中奖！</p>
<p>
<strong>
</strong>
</p>
<p>
<strong>
</strong>&nbsp;</p>
<p>
<strong>二星组选和值：</strong>
</p>
<p>二星组选和值玩法是由二星直选和组选组合而成的复合玩法，它是根据中奖号码十位、个位数字加起来的总和值进行投注。</p>
<p>例：当选择和值6进行投注时，实际投注注数为4注，分别为：</p>
<p>二星直选：3、3（当中奖号码后两位为33时即中奖，中奖金额180元）</p>
<p>二星组选：2、4（当中奖号码后两位为24或42时即中奖，中奖金额50元）</p>
<p>二星组选：1、5（当中奖号码后两位为15或51时即中奖，中奖金额50元）</p>
<p>二星组选：0、6（当中奖号码后两位为06或60时即中奖，中奖金额50元）</p>
<p>
<strong>
</strong>
</p>
<p>
<strong>
</strong>&nbsp;</p>
<p>
<strong>二星组选分位：</strong>
</p>
<p>组选分位是指可以在十位或者个位上分别选1个以上（含1个）数字进行投注。若开出的奖号十位、个位数字分别包含在所投号码中（位置不限）即中奖。若十位和个位开出对子号，则中奖180元；若为两个不同号，则中奖50元。</p>
<p>分位组选投注注数计算公式：十位所选数字个数×个位所选数字个数＝注数</p>
<p>例如：十位选5、7、6，个位选4、6、9，注数计算：3×3＝9注。即组合为：54、56、59、74、76、79、64、66、69等九注号码。若当期开出二星中奖号码是“66”，即中奖180元；若当期开出二星中奖号码是为“46”则中奖50元</p>
<p>注意：分位组选投注方式，组合注数超过25注没意义。当两个位置同时选相同号时，有相同的组选号码，选中可中多注组选奖。</p>
<p>例如：十位选4.5.6，个位选4.5.6，组合为：44、45、46、54、55、56、64、65、66若开出“46”则有46、64两注中奖，每注奖金50元，共计180元。</p>
<p>
<strong>
</strong>
</p>
<p>
<strong>
</strong>&nbsp;</p>
<p>
<strong>一星复式：</strong>
</p>
<p>竞猜开奖号码最后一位，选择1个或多个号码投注，猜中最后一位数字奖金18元。</p>
<p>例：</p>
<p>开奖号码：<strong>
<font color="red">1 2 3 4 5</font>
</strong>
</p>
<p>投注号码：<strong>
<font color="#1e50a2">5</font>
</strong>
</p>
<p>命中最后一位号码，获得奖金18元；</p>
<p>
<strong>
</strong>
</p>
<p>
<strong>
</strong>&nbsp;</p>
<p>
<strong>大小单双：</strong>
</p>
<p>竞猜开奖号码后两位的大小单双，分别选择十位、个位投注，全部猜中则中奖，奖金4元。</p>
<p>例：s</p>
<p>开奖号码：<font color="red">
<strong>1 2 3 4 5</strong>
</font>
</p>
<p>投注号码：<strong>
<font color="#1e50a2">双 单</font>
</strong>（<font color="#1e50a2">
<strong>小 大、双 大、小 单</strong>
</font>）</p>
<p>命中十位与个位的大小单双，即获奖金4元。</p>
<p>
<strong>&nbsp;</strong>
</p>
<div class="pageBreak">
</div>
<p>“时时彩”设11个奖级，每个奖级对应其各自的玩法：已看懂规则 <a href="."><img alt="立即投注" src="http://img6.cache.netease.com/help/2014/1/23/2014012316561502fd5.png" /></a></p>
<p class="f_left">&nbsp;
</p>
<table bgcolor="#cccccc" border="0" width="100%" cellpadding="0" cellspacing="1">
<tbody>
<tr align="center">
<td colspan="2" bgcolor="#efefef" height="25">奖级</td>
<td bgcolor="#efefef" height="25">中奖条件</td>
<td bgcolor="#efefef" height="25">中奖号码示例</td>
<td bgcolor="#efefef" height="25">单注奖金</td>
<td bgcolor="#efefef" height="25">中奖概率</td>
<td bgcolor="#efefef" height="25">单注赔率</td>
</tr>
<tr align="center">
<td rowspan="4" bgcolor="#ffffff" height="25">五星</td>
<td bgcolor="#ffffff" height="25">直选奖</td>
<td bgcolor="#ffffff" height="25">定位中5码</td>
<td bgcolor="#ffffff" height="25">45678</td>
<td bgcolor="#ffffff" height="25">180000元</td>
<td bgcolor="#ffffff" height="25">1/100000</td>
<td bgcolor="#ffffff" height="25">1:50000</td>
</tr>
<tr align="center">
<td bgcolor="#ffffff" height="25">通选一等奖</td>
<td bgcolor="#ffffff" height="25">定位中5码</td>
<td bgcolor="#ffffff" height="25">45678</td>
<td bgcolor="#ffffff" height="25">20000元</td>
<td bgcolor="#ffffff" height="25">1/100000</td>
<td bgcolor="#ffffff" height="25">1:10000</td>
</tr>
<tr align="center">
<td bgcolor="#ffffff" height="25">通选二等奖</td>
<td bgcolor="#ffffff" height="25">定位中前三码或后三码</td>
<td bgcolor="#ffffff" height="25">456XX或XX678</td>
<td bgcolor="#ffffff" height="25">200元</td>
<td bgcolor="#ffffff" height="25">1/500</td>
<td bgcolor="#ffffff" height="25">1:100</td>
</tr>
<tr align="center">
<td bgcolor="#ffffff" height="25">通选三等奖</td>
<td bgcolor="#ffffff" height="25">定位中前两码或后两码</td>
<td bgcolor="#ffffff" height="25">45XXX或XXX78</td>
<td bgcolor="#ffffff" height="25">20元</td>
<td bgcolor="#ffffff" height="25">1/50</td>
<td bgcolor="#ffffff" height="25">1:10</td>
</tr>
<tr align="center">
<td rowspan="3" bgcolor="#f8f8f8" height="25">三星</td>
<td bgcolor="#f8f8f8" height="25">直选奖</td>
<td bgcolor="#f8f8f8" height="25">定位中后三码</td>
<td bgcolor="#f8f8f8" height="25">678</td>
<td bgcolor="#f8f8f8" height="25">1000元</td>
<td bgcolor="#f8f8f8" height="25">1/1000</td>
<td bgcolor="#f8f8f8" height="25">1:500</td>
</tr>
<tr align="center">
<td bgcolor="#f8f8f8" height="25">组选三奖</td>
<td bgcolor="#f8f8f8" height="25">不定位中后三码</td>
<td bgcolor="#f8f8f8" height="25">668、686、866</td>
<td bgcolor="#f8f8f8" height="25">320元</td>
<td bgcolor="#f8f8f8" height="25">1/333</td>
<td bgcolor="#f8f8f8" height="25">1:160</td>
</tr>
<tr align="center">
<td bgcolor="#f8f8f8" height="25">组选六奖</td>
<td bgcolor="#f8f8f8" height="25">不定位中后三码</td>
<td bgcolor="#f8f8f8" height="25">678、687、768、786、867、876</td>
<td bgcolor="#f8f8f8" height="25">160元</td>
<td bgcolor="#f8f8f8" height="25">1/167</td>
<td bgcolor="#f8f8f8" height="25">1:80</td>
</tr>
<tr align="center">
<td rowspan="2" bgcolor="#ffffff" height="25">二星</td>
<td bgcolor="#ffffff" height="25">直选奖</td>
<td bgcolor="#ffffff" height="25">定位中后两码</td>
<td bgcolor="#ffffff" height="25">78</td>
<td bgcolor="#ffffff" height="25">100元</td>
<td bgcolor="#ffffff" height="25">1/100</td>
<td bgcolor="#ffffff" height="25">1:50</td>
</tr>
<tr align="center">
<td bgcolor="#ffffff" height="25">组选奖</td>
<td bgcolor="#ffffff" height="25">不定位中后两码</td>
<td bgcolor="#ffffff" height="25">78、87</td>
<td bgcolor="#ffffff" height="25">50元</td>
<td bgcolor="#ffffff" height="25">1/45</td>
<td bgcolor="#ffffff" height="25">1:25</td>
</tr>
<tr align="center">
<td colspan="2" bgcolor="#f8f8f8" height="25">一星</td>
<td bgcolor="#f8f8f8" height="25">中个位号码</td>
<td bgcolor="#f8f8f8" height="25">8</td>
<td bgcolor="#f8f8f8" height="25">10元</td>
<td bgcolor="#f8f8f8" height="25">1/10</td>
<td bgcolor="#f8f8f8" height="25">1:5</td>
</tr>
<tr align="center">
<td colspan="2" bgcolor="#ffffff" height="25">大小单双</td>
<td bgcolor="#ffffff" height="25">中十位和个位大小单双</td>
<td bgcolor="#ffffff" height="25">大大、大双、单双、单大</td>
<td bgcolor="#ffffff" height="25">4元</td>
<td bgcolor="#ffffff" height="25">1/4</td>
<td bgcolor="#ffffff" height="25">1:2</td>
</tr>
</tbody>
</table>
<p>注：&lt;1&gt;、假设当期的开奖号码为45678（组选三适用开奖号码为45668）。</p>
<p>
<br  />　　 &lt;2&gt;、前三码和后三码：前三码指开奖号码的前三位号码，后三码指开奖号码的后三位号码。示例：开奖号码为45678，前三码为456，后三码为678。 </p>
<p>
<br  />　　 &lt;3&gt;、前两码和后两码：前两码指开奖号码的前两位号码，后两码指开号码的后两位号码。示例：开奖号码为45678，前两码为45，后两码为78。</p>
<p>
<br  />　　 &lt;4&gt;、定位和不定位：定位指投注号码与开奖号码按位一致，不定位指投注号码与开奖号码一致，顺序不限。示例：开奖号码为45678，78则定位中后两码，78或87则为不定位中后两码。</p>
<p>
<br  />　　 &lt;5&gt;、五星通选一注号码，可三个奖级通吃，共有5次中奖机会，兼中兼得。即中了一等奖，同时也就中了2个二等奖和2个三等奖。同理，中了1注二等奖，同时也中了1注三等奖。<br  />
</p>
<p class="f_center">
<br  />&nbsp;</p>
      </div>
            </div>
            <div class="help-content" id="general_table_0" style="display:none">
            <p style="line-height: 30px; color: #ff0000; margin-left: 20px; font-size: 16px; font-weight: bold">在充值之前，请认真阅读充值使用说明，以确保整个充值流程不发生错误和资金的正常到账。</p>
            <p style="margin-left: 20px"><font size="+1"><strong>第一步：</strong></font></p>
            <p style="line-height: 25px; margin-left: 35px">点击前台<span style="color: rgb(51,153,102)">【充值】</span>或<span style="color: rgb(51,153,102)">【充值申请】</span>，选择<span style="color: rgb(0,0,255)">【自动充值】</span>，然后选择<span style="color: rgb(255,0,255)">&ldquo;中国工商银行&rdquo;</span>，输入充值金额，然后点击下一步</p>
            <p style="margin-left: 20px"><font size="+1"><strong>第二步：</strong></font></p>
            <p style="line-height: 25px; margin-left: 35px">获取到平台最新的工行<span style="color: rgb(255,0,0)">&ldquo;收款账户名&rdquo;</span>，<span style="color: rgb(255,0,0)">&ldquo;收款账号(email)&rdquo;</span>，<span style="color: rgb(255,0,0)">&ldquo;汇款附言&rdquo;&nbsp;</span>等信息</p>
            <p style="margin-left: 20px"><font size="+1"><strong>第三步：</strong></font></p>
            <p style="line-height: 25px; margin-left: 35px">登录中国工商银行网上银行，然后点击<span style="color: rgb(0,0,255)">【转账汇款】</span></p>
            <p style="margin-left: 20px"><font size="+1"><strong>第四步：</strong></font></p>
            <p style="line-height: 25px; margin-left: 35px">在转账汇款页面的左侧菜单栏选择<span style="color: rgb(0,0,255)">【e-mail汇款】</span></p>
            <p style="margin-left: 20px"><font size="+1"><strong>第五步：</strong></font></p>
            <p style="line-height: 25px; margin-left: 35px">按以下图解对应填入相关信息： <br />
            <img alt="" style="border-bottom: #333333 1px solid; border-left: #333333 1px solid; border-top: #333333 1px solid; border-right: #333333 1px solid" src="./images/help/zdcz1.png" /></p>
            <p style="margin-left: 20px"><font size="+1"><strong>第六步：</strong></font></p>
            <p style="line-height: 25px; margin-left: 35px">然后提交并确认信息，输入U盾密码等步骤完成工行汇款</p>
            <p style="margin-left: 20px"><font size="+1"><strong>第七步：</strong></font></p>
            <p style="line-height: 25px; margin-left: 35px">汇款完成后到平台查看到账情况，自动充值一般1分钟内到账<br />
            如果5分钟内未到账，请提供您的<span style="color: rgb(255,0,0)">汇款银行</span>，<span style="color: rgb(255,0,0)">汇款金额</span>，<span style="color: rgb(255,0,0)">汇款流水号</span>给在线客服进行处理</p>
            </div>
            <div class="help-content" id="general_table_1" style="display:none">
            <p style="line-height: 30px; color: #ff0000; margin-left: 20px; font-size: 16px; font-weight: bold">在充值之前，请认真阅读充值使用说明，以确保整个充值流程不发生错误和资金的正常到账。</p>
            <p style="margin-left: 20px"><font size="+1"><strong>第一步：</strong></font></p>
            <p style="line-height: 25px; margin-left: 35px">点击前台<span style="color: rgb(51,153,102)">【充值】</span>或<span style="color: rgb(51,153,102)">【充值申请】</span>，选择<span style="color: rgb(0,0,255)">【自动充值】</span>，然后选择<span style="color: rgb(255,0,255)">&ldquo;中国建设银行&rdquo;</span>，选择一张您绑定在平台的建行卡，输入充值金额，然后点击下一步</p>
            <p style="margin-left: 20px"><font size="+1"><strong>第二步：</strong></font></p>
            <p style="line-height: 25px; margin-left: 35px">获取到平台最新的建设银行的<span style="color: rgb(255,0,0)">&ldquo;收款账户名&rdquo;</span>，<span style="color: rgb(255,0,0)">&ldquo;收款账号&rdquo;</span><span style="color: rgb(255,0,0)">&nbsp;</span>等信息</p>
            <p style="margin-left: 20px"><font size="+1"><strong>第三步：</strong></font></p>
            <p style="line-height: 25px; margin-left: 35px">使用您刚才选择的绑定在平台的建行卡，登录中国建设银行网上银行，，然后点击<span style="color: rgb(0,0,255)">【转账汇款】&rarr;&rdquo;活期转账汇款&ldquo;</span></p>
            <p style="margin-left: 20px"><font size="+1"><strong>第四步：</strong></font></p>
            <p style="line-height: 25px; margin-left: 35px">按以下图解对应填入相关信息： <br />
            <img alt="" style="border-bottom: #333333 1px solid; border-left: #333333 1px solid; border-top: #333333 1px solid; border-right: #333333 1px solid" src="./images/help/zdcz3.png" /></p>
            <p style="margin-left: 20px"><font size="+1"><strong>第五步：</strong></font></p>
            <p style="line-height: 25px; margin-left: 35px">然后提交并确认信息，输入U盾密码等步骤完成建行汇款</p>
            <p style="margin-left: 20px"><font size="+1"><strong>第六步：</strong></font></p>
            <p style="line-height: 25px; margin-left: 35px">汇款完成后到平台查看到账情况，自动充值一般1分钟内到账<br />
            如果5分钟内未到账，请提供您的<span style="color: rgb(255,0,0)">汇款银行</span>，<span style="color: rgb(255,0,0)">汇款金额</span>，<span style="color: rgb(255,0,0)">汇款卡号后8位</span>给在线客服进行处理</p>        </div>
            <div class="help-content" id="general_table_2" style="display:none">
            <p style="line-height: 30px; color: #ff0000; margin-left: 20px; font-size: 16px; font-weight: bold">在充值之前，请认真阅读充值使用说明，以确保整个充值流程不发生错误和资金的正常到账。</p>
            <p style="margin-left: 20px"><font size="+1"><strong>第一步：</strong></font></p>
            <p style="line-height: 25px; margin-left: 35px">点击前台<span style="color: rgb(51,153,102)">【充值】</span>或<span style="color: rgb(51,153,102)">【充值申请】</span>，选择<span style="color: rgb(0,0,255)">【人工充值】</span>，然后选择<span style="color: rgb(255,0,255)">&ldquo;中国农业银行&rdquo;</span>，填写期望的充值金额，同时勾选&rdquo;同意并遵守以下的《充值使用说明》&ldquo;，点击&rdquo;下一步&ldquo;。</p>
            <p style="margin-left: 20px"><font size="+1"><strong>第二步：</strong></font></p>
            <p style="line-height: 25px; margin-left: 35px">确认充值申请表单，如没有问题，则提交</p>
            <p style="margin-left: 20px"><font size="+1"><strong>第三步：</strong></font></p>
            <p style="line-height: 25px; margin-left: 35px">申请通过以后，会跳转到&ldquo;充值记录&rdquo;，并显示刚提交的充值申请的详情<br />
            查看并获取<font color="#ff0000"><strong>&rdquo;实际汇款的金额&ldquo;、&rdquo;收款银行&ldquo;、&rdquo;收款银行支行&ldquo;、&rdquo;收款人账号&ldquo;、&rdquo;收款人姓名&ldquo;、&rdquo;附言编号（转账用途）&ldquo;</strong></font></p>
            <p style="margin-left: 20px"><font size="+1"><strong>第四步：</strong></font></p>
            <p style="line-height: 25px; margin-left: 35px">登录中国农业银行网上银行，然后点击<span style="color: rgb(0,0,255)">【转账汇款】&rarr;&rdquo;单笔转账&ldquo;</span></p>
            <p style="margin-left: 20px"><font size="+1"><strong>第五步：</strong></font></p>
            <p style="line-height: 25px; margin-left: 35px">按以下图解对应填入相关信息：<br />
            <img alt="" style="border-bottom: #333333 1px solid; border-left: #333333 1px solid; border-top: #333333 1px solid; border-right: #333333 1px solid" src="./images/help/czys2.png" /></p>
            <p style="margin-left: 20px"><font size="+1"><strong>第六步：</strong></font></p>
            <p style="line-height: 25px; margin-left: 35px">然后提交并确认信息，输入U盾密码等步骤完成农行汇款</p>
            <p style="margin-left: 20px"><font size="+1"><strong>第七步：</strong></font></p>
            <p style="line-height: 25px; margin-left: 35px">汇款完成后到平台查看到账情况，人工充值一般10分钟内到账<br />
            如果20分钟内未到账，请提供您的<span style="color: rgb(255,0,0)">汇款银行</span>，<span style="color: rgb(255,0,0)">汇款金额</span>，<span style="color: rgb(255,0,0)">汇款附言，汇款时间</span>给在线客服进行处理</p>        </div>
            <div class="help-content" id="general_table_3" style="display:none">
            <p style="margin-left:20px;"><font size="+1"><strong>第一步：</strong></font></p>
            <p style="margin-left:35px;line-height:25px;">进入“我的银行卡”，然后绑定银行卡，如果已有绑定的银行卡，可以跳过这一步。</p>
            <p style="margin-left:20px;"><font size="+1"><strong>第二步：</strong></font></p>
            <p style="margin-left:35px;line-height:25px;">填写要提现的金额以及选择绑定的银行卡，然后点击“下一步”。</p>
            <p style="margin-left:20px;"><font size="+1"><strong>第三步：</strong></font></p>
            <p style="margin-left:35px;line-height:25px;">在确认页面，确认提现涉及的一些信息，包括：<font color="#FF0000">提现金额</font>，<font color="#FF0000">到账金额</font>，以及<font color="#FF0000">提现银行卡信息</font>是否正确，如无误，则提交。</p>
            <p style="margin-left:20px;"><font size="+1"><strong>第四步：</strong></font></p>
            <p style="margin-left:35px;line-height:25px;">查看提现记录，并跟踪处理情况，如果系统已处理好转账，那申请的状态会变为“提现成功”。</p>
            <p style="margin-left:20px;"><font size="+1"><strong>第五步：</strong></font></p>
            <p style="margin-left:35px;line-height:25px;">根据提现银行卡，到具体的银行查看到账情况。</p>        </div>
            <div class="help-content" id="general_table_4" style="display:none">
            <p style="line-height: 25px; margin-left: 35px">第一条：平台充值只支持个人网上银行的及时到账汇款方式进行充值，如果采用非个人网上银行或者非及时到账方式进行充值而导致的损失与本平台无关。</p>
            <p style="line-height: 25px; margin-left: 35px">第二条：平台充值不支持跨行转账汇款方式进行汇款，如果采用了跨行转账方式进行汇款而导致的损失与本平台无关。</p>
            <p style="line-height: 25px; margin-left: 35px">第三条：平台会不定期更换收款银行卡，请在汇款前确认最新的收款卡信息，如果汇款到非最新的收款卡而导致的损失与本平台无关。</p>
            <p style="line-height: 25px; margin-left: 35px">第四条：由于客户银行卡信息泄露或者与他人共享了银行卡信息，而导致的损失与本平台无关。</p>
            <p style="line-height: 25px; margin-left: 35px">第五条：如果客户未按照平台充值要求操作，错误充值到他人账户上，而导致的损失与本平台无关。</p>
            <p style="line-height: 25px; margin-left: 35px">第六条：本平台之声明以及其修改权、更新权和最终解释权均属本平台所有。</p>        </div>
            <div class="help-content" id="general_table_5" style="display:none">
            <p style="margin-left: 20px"><font color="#006699" size="+1">1.登陆过程中为什么会跳转到谷歌界面？</font><br />
        <span style="line-height: 25px; margin-left: 20px">在登陆过程中，如果用户名和密码错误，以及使用了非平台域名均会导致跳转到谷歌界面。如果平台域名变动，请及时联系上级或者在线客服。</span></p>
        <p style="margin-left: 20px"><font color="#006699" size="+1">2.忘记密码了怎么办？</font><br />
        <span style="line-height: 25px; margin-left: 20px">每个用户在平台有两个密码，一个是登录密码，一个是资金密码。<br />
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;a) 如果登录密码忘记，可以在登录页点击 &ldquo;忘记密码&rdquo; 转到找回密码界面，在验证资金密码以后可以对登录密码进行修改。<br />
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;b) 如果资金密码忘记，可以通过登录密码登录到平台后联系在线客服进行处理。<br />
        <font color="#0099cc">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;提示：初始账号是没有设置资金密码的，强烈建议您在拿到新账号以后，进入到&ldquo;账户管理-&gt;修改密码&rdquo;，修改登录密码和设置资金密码，并且妥善保管好两个密码。</font><br />
        <font color="#ff0000">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;注意：如果登录密码和资金密码同时遗忘，那么将无法再找回或者修改密码。</font> </span></p>
        <p style="margin-left: 20px"><font color="#006699" size="+1">3.信息中心的账户安全评分有什么用？</font><br />
        <span style="line-height: 25px; margin-left: 20px">账户安全评分主要是为了提高用户账户安全级别，针对用户账户安全提出一些建议。</span></p>
        <p style="margin-left: 20px"><font color="#006699" size="+1">4.平台充值提现支持哪些银行以及服务时间？</font><br />
        <span style="line-height: 25px; margin-left: 20px">平台充值支持&ldquo;工商银行&rdquo;、&ldquo;建设银行&rdquo;和&rdquo;财付通&ldquo;的自动充值，以及&rdquo;农业银行&ldquo;的人工充值。</span><br />
        <span style="line-height: 25px; margin-left: 20px">平台提款支持&ldquo;工商银行&rdquo;、&ldquo;农业银行&rdquo;、&ldquo;建设银行&rdquo;和&rdquo;财付通&ldquo;。</span><br />
        <span style="line-height: 25px; margin-left: 20px">自动充值服务时间为每天早上9:00到次日凌晨2:00，人工充值和提款时间为每天早上10:00到次日凌晨2:00。</span></p>
        <p style="margin-left: 20px"><font color="#006699" size="+1">5.为什么我的充值没有及时到账？</font><br />
        <span style="line-height: 25px; margin-left: 20px">以下几点会导致充值不能及时到账，如果出现以下问题，请及时联系在线客服或者上级。<br />
        &nbsp;&nbsp;&nbsp;&nbsp;a)工行充值和财付通充值未正确填写附言<br />
        &nbsp;&nbsp;&nbsp;&nbsp;b)建行充值未使用选择绑定在平台的建行卡进行汇款。<br />
        &nbsp;&nbsp;&nbsp;&nbsp;c)农行汇款时未正确填写&rdquo;附加用途&ldquo;<br />
        &nbsp;&nbsp;&nbsp;&nbsp;d)充值时间在平台服务时间外。 </span></p>
        <p style="margin-left: 20px"><font color="#006699" size="+1">6.为什么我无法进行游戏撤单？</font><br />
        <span style="line-height: 25px; margin-left: 20px">如果要撤单，必须在停止投注之前进行撤单，如果投注时间已截止，那么将无法再进行撤单操作。如果是撤消追号单，需要到&ldquo;追号记录-&gt;追号详情&rdquo;里进行撤消追号处理。</span></p>
        <p style="margin-left: 20px"><font color="#006699" size="+1">7.第三方机构未开奖时，我的投注单会怎么处理？</font><br />
        <span style="line-height: 25px; margin-left: 20px">如果是第三方机构不开奖，则会对不开奖的奖期进行撤单返款的处理。</span></p>
        <p style="margin-left: 20px"><font color="#006699" size="+1">8.什么是动态奖金返点？</font><br />
        <span style="line-height: 25px; margin-left: 20px">在投注的时候，会有个&ldquo;选择奖金返点&rdquo;，即动态奖金返点。动态奖金返点是根据用户自身的返点，然后利用舍弃返点，来提高中奖金额的一种模式，比如您重庆时时彩的前三直选的奖金是1700，返点是5%，那么在投注的时候可以选择动态奖金1800，返点0%。这种情况下如果您中奖，那么奖金便是1800。</span></p>
        <p style="margin-left: 20px"><font color="#006699" size="+1">9.什么是奖金限额？ 平台奖金限额多少？</font><br />
        <span style="line-height: 25px; margin-left: 20px">1.平台奖金限额是指在投注过程中，同一个彩种的同一个玩法中，单期购买相同号码的所有注单的总奖金的限制额度。</span><br />
        <span style="line-height: 25px; margin-left: 20px">2.平台高频彩(时时彩、时时乐、11选5)的奖金限额是40万，低频彩(3D、排列三、排列五)奖金限额10万</span><br />
        &nbsp;</p>
  </div>
    
</div>
<div id="footer"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td align="center"><table align="center" width="450">
<tr><td align="left">浏览器建议：首选IE 8.0浏览器，其次为火狐浏览器。</td></tr>
</table></td></tr><tr><td></td></tr></table></div>
<br/><br/>
</div></div>
<?php echo $count?>
</BODY></HTML>