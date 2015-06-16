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
            <div class="help-content" id="general_table_0" >
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
如果5分钟内未到账，请提供您的<span style="color: rgb(255,0,0)">汇款银行</span>，<span style="color: rgb(255,0,0)">汇款金额</span>，<span style="color: rgb(255,0,0)">汇款流水号</span>给在线客服进行处理</p>        </div>
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
&nbsp;</p>        </div>
    
</div>
<div id="footer"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td align="center"><table align="center" width="450">
<tr><td align="left">浏览器建议：首选IE 8.0浏览器，其次为火狐浏览器。</td></tr>
</table></td></tr><tr><td></td></tr></table></div>
<br/><br/>
</div></div>
<?php echo $count?>
</BODY></HTML>