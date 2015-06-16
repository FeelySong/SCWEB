<?php
//error_reporting(0);
require_once 'conn.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD><TITLE><?php echo $webname;?>  - 功能介绍</TITLE>
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
 - 功能介绍 </SPAN><DIV style="clear:both"></DIV></H1>
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
		  <span class="content">开始游戏</span>
		  <span class="tabbar-right"></span>
		</span>
			<span class="tab-back"  id="general_tab_1">
		  <span class="tabbar-left"></span>
		  <span class="content">游戏记录</span>
		  <span class="tabbar-right"></span>
		</span>
			<span class="tab-back"  id="general_tab_2">
		  <span class="tabbar-left"></span>
		  <span class="content">用户管理</span>
		  <span class="tabbar-right"></span>
		</span>
			<span class="tab-back"  id="general_tab_3">
		  <span class="tabbar-left"></span>
		  <span class="content">报表管理</span>
		  <span class="tabbar-right"></span>
		</span>
			<span class="tab-back"  id="general_tab_4">
		  <span class="tabbar-left"></span>
		  <span class="content">账户管理</span>
		  <span class="tabbar-right"></span>
		</span>
			<span class="tab-back"  id="general_tab_5">
		  <span class="tabbar-left"></span>
		  <span class="content">帮助中心</span>
		  <span class="tabbar-right"></span>
		</span>
		</div>

            <div class="help-content" id="general_table_0" >
            <p>一切平台的游戏从这里开始，选择一个游戏，然后进入到游戏界面，在同一个游戏中，所有玩法可以来回切换。</p>
<p style="margin-left:20px;"><font size="+1"><strong>第一步：</strong></font>首先选择玩法组和玩法，玩法组标签可以来回相互切换，然后选择不同的玩法。</p>
<p style="margin-left:20px;"><font size="+1"><strong>第二步：</strong></font>根据各个玩法规则，选择或者输入要购买的号码</p>
<p style="margin-left:20px;"><font size="+1"><strong>第三步：</strong></font>然后根据需要选择投注倍数、元角模式和动态奖金返点设置。</p>
<p style="margin-left:20px;"><font size="+1"><strong>第四步：</strong></font>确认选择的号码，然后点击“选好了”，把当前投注内容加入到投注项中，然后可以重复"<strong>第一步</strong>"到"<strong>第四步</strong>"，以添加不同玩法的不同投注内容到投注项中。</p>
<p style="margin-left:20px;"><font size="+1"><strong>第五步：</strong></font>如果是投注，则选择要投注的期号，然后点击“确认投注”。如果是追号，则点击“我要追号”，以展开追号计划表，根据自己的需要填写好追号计划以后，再点击“确认投注”。</p>        </div>
            <div class="help-content" id="general_table_1" style="display:none">
            <p style="margin-left: 20px"><font size="+1"><strong>一：投注记录</strong></font></p>
<p style="line-height: 25px; margin-left: 35px">默认不显示任何投注记录，需要在选择查询条件以后，点击搜索才能查询投注记录，在查询出的投注记录结果里，点击投注内容栏的&ldquo;详细号码&rdquo;，可以在当页浮动显示出该投注记录所选择投注号码，点击注单编号则会在弹出注单详情信息，在注单详情弹出框里可以针对在撤单时间范围内的注单进行撤单。如果是追号的注单，则在玩法后面会有&ldquo;查看追号详情&rdquo;的功能，点击可以切换到追号详情界面。<font color="#ff0000">（注意：注单详情中的撤单操作，只能在注单购买的那期停止销售前对注单进行撤单）</font></p>
<p style="margin-left: 20px"><font size="+1"><strong>一：追号记录</strong></font></p>
<p style="line-height: 25px; margin-left: 35px">和投注记录类似，默认不显示任何追号记录，需要在选择查询条件以后，点击搜索才能查询追号记录，在查询出的记录结果里，点击追号内容栏的&ldquo;详细号码&rdquo;，可以在当页浮动显示出该追号记录所选择的号码，点击追号编号会新打开一个追号详情窗口，在追号详情中可以对销售未截止或者未开始的奖期进行撤消追号处理。</p>        </div>
            <div class="help-content" id="general_table_2" style="display:none">
            <p>用来管理自己的下级用户和针对自己本人信息的查看和修改</p>
<p style="margin-left: 20px"><font size="+1"><strong>一：用户列表</strong></font></p>
<p style="line-height: 25px; margin-left: 35px">管理自己的下级用户。进入该功能以后，分为左边的用户树和用户信息列表两部分。默认情况下只显示所有直接下级的信息，在用户树里的用户名右边会有数字显示，这些数字表示该用户下的直接下级用户的数量，可以点击数字已展开下级的用户树。用户信息列表包括了用户名、所属组、当前余额和注册时间等信息，可以针对用户名，余额范围，以及用户组进行综合搜索，另外还可以按用户名和余额进行排序。<br />
<strong>a)&nbsp;用户详情：</strong>&nbsp;查看用户基本个人信息和游戏设定的信息。<br />
<strong>b)&nbsp;编辑用户：</strong>&nbsp;进入用户编辑界面，编辑用户的游戏设定。<br />
<strong>c)&nbsp;团队余额：</strong>&nbsp;点击&ldquo;团队余额&rdquo;会在该用户的下方显示该用户下的所有用户的余额的总和，即团队余额的信息。<br />
<strong>d)&nbsp;帐变记录：</strong>&nbsp;进入用户帐变查询界面，默认情况可以查看用户当天的所有帐变记录。</p>
<p style="margin-left: 20px"><font size="+1"><strong>二：增加用户</strong></font></p>
<p style="line-height: 25px; margin-left: 35px">增加用户时，首先必须要填写用户账号、登陆密码和昵称三个基本信息。然后在下面必须为新用户开通一个或者多个游戏。在开通游戏设置时，有两个选项：&ldquo;快速设置&rdquo;和&ldquo;详细设置&rdquo;，但同时只能使用一个。<br />
<strong>快速设置：</strong>&nbsp;选择针对新用户所有游戏的保留返点，系统会根据你填写的保留返点，为新用户设置每个游戏和玩法的返点。<font color="#ff0000">（推荐）</font><br />
<strong>详细设置：</strong>&nbsp;针对每个游戏，每个玩法根据自己的需要进行详细的游戏设置。 &nbsp;</p>
<p style="margin-left: 20px"><font size="+1"><strong>三：修改昵称</strong></font></p>
<p style="margin-left: 35px;line-height:25px;">修改自己在平台中的昵称信息。</p>
<p style="margin-left: 20px"><font size="+1"><strong>四：我的消息</strong></font></p>
<p style="margin-left: 35px;line-height:25px;">查看和管理自身的系统消息，点击&ldquo;查看&rdquo;可以查看消息详情，点击&ldquo;删除&rdquo;可以删除消息。</p>
<p style="margin-left: 20px"><font size="+1"><strong>五：奖金详情</strong></font></p>
<p style="margin-left: 35px;line-height:25px;">可以分游戏查看自身已开通游戏的奖金和返点设置信息。</p>        </div>
            <div class="help-content" id="general_table_3" style="display:none">
            <p style="margin-left: 20px"><font size="+1"><strong>一：帐变列表</strong></font></p>
<p style="line-height: 25px; margin-left: 35px">在账务方面，平台会记录用户每笔资金操作的去向，包括充值，提现和游戏等，即帐变。在帐变列表可以查询自身和所有下级的近期的帐变情况， 平台提供了一系列的搜索选项，帮助用户快速找到想要的信息，包括：帐变类型（比如，充值，提现，游戏，或者其他），帐变时间范围，指定用户，范围（自身，直接下级或者所有下级），帐变编号、注单编号和追号编号查询，如果是针对游戏帐变，还可以根据具体游戏，玩法，甚至奖期进行查询。另外系统还提供了几个自身的快捷查询：我充值的，我提现的，我投注的，我追号的，我的奖金，我的返点。在查询结果里显示信息包括，帐变的编号、用户名、帐变时间、帐变类型、对应游戏，玩法，奖期，变动金额（收入还是支出），以及该帐变后的账户余额等信息。</p>
<p style="margin-left: 20px"><font size="+1"><strong>二：报表查询</strong></font></p>
<p style="line-height: 25px; margin-left: 35px">根据时间和游戏查询下级每条用户树的游戏投注统计结果，显示信息包括：用户名，所属组，总代购费，返点，实际总代购费，中奖金额，总结算。点击&ldquo;查看下级&rdquo;可以查看每一级的统计结果，点击&ldquo;游戏明细&rdquo;可以查看针对具体游戏和玩法的统计。</p>
<p style="margin-left: 20px"><font size="+1"><strong>三：返点统计</strong></font></p>
<p style="line-height: 25px; margin-left: 35px">查询在指定时间里自己的返点总额，默认现实当天的返点金额。</p>
<p style="margin-left: 20px"><font size="+1"><strong>四：今日报表</strong></font></p>
<p style="line-height: 25px; margin-left: 35px">统计当天的团队余额，投注金额和中奖金额等信息</p>        </div>
            <div class="help-content" id="general_table_4" style="display:none">
            <p style="margin-left: 20px"><font size="+1"><strong>一：修改密码</strong></font></p>
<p style="margin-left: 35px;line-height:25px;">可以修改自己的登录密码和资金密码，在修改的同时是需要提供原始密码，以确保用户账户安全。</p>
<p style="margin-left: 20px"><font size="+1"><strong>二：充值申请</strong></font></p>
<p style="margin-left: 35px;line-height:25px;">在进入充值申请之前，需要验证用户资金密码。进入以后可以填写充值申请或者查看历史充值记录以及充值申请的跟踪情况。关于充值的详细说明，请查看&ldquo;<font color="#ff0000"><strong>常见问题-&gt;充值说明</strong></font>&rdquo;。</p>
<p style="margin-left: 20px"><font size="+1"><strong>三：提现申请</strong></font></p>
<p style="margin-left: 35px;line-height:25px;">和充值申请一样，在进入提现申请之前，需要验证用户资金密码。进入以后可以填写提现申请或者查看历史提现记录以及提现申请的跟踪情况。关于提现的详细说明，请查看&ldquo;<font color="#ff0000"><strong>常见问题-&gt;提现说明</strong></font>&rdquo;。</p>
<p style="margin-left: 20px"><font size="+1"><strong>四：我的银行卡</strong></font></p>
<p style="margin-left: 35px;line-height:25px;">对自己绑定在平台的银行卡进行管理，包括增加，删除。查看等。在进入管理之前同样需要检查资金密码。</p>        </div>
            <div class="help-content" id="general_table_5" style="display:none">
            <p style="margin-left: 20px"><font size="+1"><strong>一：信息中心</strong></font></p>
<p style="margin-left: 35px;line-height:25px;">综合信息区，可以查看系统对于自己账户安全的一个评分，以及一些对账户安全性提高的建议。还可以查看系统的公告信息，点击公告标题可以在右边显示公告内容。</p>
<p style="margin-left: 20px"><font size="+1"><strong>二：功能介绍</strong></font></p>
<p style="margin-left: 35px;line-height:25px;">针对平台的所有功能进行介绍，让您更快的熟悉本平台。</p>
<p style="margin-left: 20px"><font size="+1"><strong>三：常见问题</strong></font></p>
<p style="margin-left: 35px;line-height:25px;">以问答方式，解答用户在使用中的一些常见问题，包括<font color="#ff0000"><strong>&ldquo;充值说明&rdquo;</strong></font>、<font color="#ff0000"><strong>&ldquo;提现说明&rdquo;</strong></font>。</p>        </div>
    
</div>
<div id="footer"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td align="center"><table align="center" width="450">
<tr><td align="left">浏览器建议：首选IE 8.0浏览器，其次为火狐浏览器。</td></tr>
</table></td></tr><tr><td></td></tr></table></div>
<br/><br/>
</div></div>
<?php echo $count?>
</BODY></HTML>