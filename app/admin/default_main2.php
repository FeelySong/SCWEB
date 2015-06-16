<?php
session_start();
error_reporting(0);
require_once 'conn.php';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<TITLE>嘟嘟游戏 后台管理中心</TITLE>
<style>
/* Start New Product Page Design [date] */
body{margin:0;color:#333;font-family:\5B8B\4F53,Arial Narrow,arial,serif;background:#f7f7f0;min-width:1001px;}
img{border-style:none;}
a{text-decoration:none;color:#1a7ec2;}
a:hover{text-decoration:underline;color:#ee7d36;}
ul,li{padding:0;margin:0;}
#wrapper{width:100%;margin:0 auto;background:#fff;font-size:14px;}
#header{color: #039;background:url('images/menu1.jpg') repeat-x;}
.header-holder{overflow:hidden;height:1%;padding: 11px 5px 5px;}

#header .panel{ overflow:hidden;height:1%;padding: 0 3px 0 75px; font-weight:bold;margin-bottom:-1px;position:relative;}
.tabset{margin: 0 10px 0 0; padding:0;list-style:none;float:left;position:relative;z-index: 3;}
.tabset li{float:left;margin-right:3px;}
#header .tabset a{ float: left;padding: 9px 2px 7px;color:#fff;line-height:12px;cursor:pointer;width: 90px;font-weight: bold; text-align:center;}
#header .tabset a:hover{text-decoration:none;}
#header .tabset .active a{ background: url('images/menu2.jpg') no-repeat;color: #1A7EC2;border-color:#fc0; padding-bottom: 10px;}

/* 子菜单 */
.sub-menu{height: 27px;background: url('header-sprite.png') repeat-x 0 -125px;border-top: 3px solid #197EC2;padding: 0 0 6px 0;margin-top: -3px;border-bottom: 1px #AAA solid;text-align: left;}
.sub-menu ul {list-style-type: none; padding-left: 0; margin-left: 0;margin-top:0; padding-top:7px;}
.sub-menu li { float: left;margin:0;padding: 0 20px 0 20px;color:#777;font-size:12px;line-height:22px;}
.sub-menu li.inline{float: left;background: url('line.png') no-repeat right;}
.sub-menu li.inline .clink{ color:#444;font-size: 12px;}
#tab-2,#tab-3,#tab-4,#tab-5,#tab-6,#tab-7,#tab-8,#tab-9,#tab-10{display: none;}
.clear {clear:both;}
</style>


<LINK href="css/main.css" rel="stylesheet" type="text/css" />
<SCRIPT type="text/javascript" src="js/jquery.js"></SCRIPT>
<script language="javascript" type="text/javascript" src="js/common.js"></script>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript" src="jquery.main.js"></script>


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
			jQuery("#leftbox").css({width:"180px"}).show();
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
		url  : 'default_main.php',
		data : 'flag=gettoprize',
		timeout : 30000,
		success : function(data){
				var partn = /<(.*)>.*<\/\1>/;
				if( partn.exec(data) ){
					window.top.location.href="default_main.php";
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
				if( data.money != 'empty' ){
					var dd = moneyFormat(data.money);
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
<style>
html {overflow: hidden;}
</style>
</HEAD>
<BODY>

<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
	<td id="topbox">
		<div id="header-div">
		  <div id="logo-div" onclick="javascript:window.top.location='./';"><img src="images/comm/t.gif" class='main_logo' title="返回首页"/></div>
		  <div id="submenu-div">
			<ul>
			  <li><a TITLE='首页' href="/" style="border-left:none;" target="_top"><img src='images/comm/t.gif'>首页</a></li>
			  <li><a TITLE='在线客服信息' style='color:#09C;padding-left:6px;' href="csonline_addnew.php" target="mainframe"><img class='link1' src='images/comm/t.gif'>客服信息(0)</a></li>
			  <li><a TITLE='刷新当前页' href="javascript:window.top.frames['mainframe'].document.location.reload();"><img class='link2' src='images/comm/t.gif'>提款信息(0)</a></li>
			  <li><a TITLE='刷新当前页' style='color:#090;padding-left:6px;' href="javascript:window.top.frames['mainframe'].document.location.reload();"><img src='images/comm/t.gif'>刷新</a></li>
			  <li><a TITLE='退出系统' style='color:#090;padding-left:6px;' onClick="return confirm('确认退出系统?');" href="default_logout.php" target="_top"><img src='images/comm/t.gif'>退出</a></li>
			</ul>
  		  </div>
          
		</div>
	</td>
</tr>
</table>

<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
	<td>
<div id="wrapper">
   <!-- header -->
        <div id="header">
                <div class="panel">
                        <!-- navigation tab -->
                        <ul class="tabset" id="tab-list">
                                <li ><a href="#tab-1" class="tab" onClick="return false;">信息管理</a></li>
                                <li ><a href="#tab-2" class="tab" onClick="return false;">会员管理</a></li>
                                <li class=active><a href="#tab-3" class="tab" onClick="return false;">财务管理</a></li>
                                <li ><a href="#tab-4" class="tab" onClick="return false;">业务流水</a></li>
                                <li ><a href="#tab-5" class="tab" onClick="return false;">报表管理</a></li>
                        </ul>
                </div>
                 <!-- navigation -->
                <div class="sub-menu" id="tab-1" style=display:none>
                        <ul>
                            <li class="inline"><a href="#" class="clink">公告管理</a></li>
							<li class="inline"><a href="#" class="clink">消息管理</a></li>
							<li class="inline"><a href="#" class="clink">电子邮件营销</a></li>
							<li class="inline"><a href="#" class="clink">苏州网站建设</a></li>
							<li class="inline"><a href="#" class="clink">苏州网站推广</a></li>
                                <li ><a href="#tab-6" class="tab" onClick="return false;">数据统计</a></li>
                                <li ><a href="#tab-7" class="tab" onClick="return false;">项目管理</a></li>
                                <li ><a href="#tab-8" class="tab" onClick="return false;">系统管理</a></li>
                                <li ><a href="#tab-9" class="tab" onClick="return false;">管理员</a></li>
                                <li ><a href="#tab-10" class="tab" onClick="return false;">计划任务</a></li>
                        </ul>
                </div>
                <div class="sub-menu" id="tab-2" style=display:none>
                        <ul>
                            <li class="inline"><a href="#" class="clink">网页特效代码</a></li>
							<li class="inline"><a href="#" class="clink">网络营销实务</a></li>
							<li class="inline"><a href="#" class="clink">电子邮件营销</a></li>
							<li class="inline"><a href="#" class="clink">苏州网站建设</a></li>
							<li class="inline"><a href="#" class="clink">苏州网站推广</a></li>
                        </ul>
                </div>
                <div class="sub-menu" id="tab-3" style=display:block>
                        <ul>
                            <li class="inline"><a href="#" class="clink">苏州网站优化</a></li>
							<li class="inline"><a href="#" class="clink">零度对策</a></li>
							<li class="inline"><a href="#" class="clink">苏州网站推广</a></li>
							<li class="inline"><a href="#" class="clink">苏州网页制作</a></li>
							<li class="inline"><a href="#" class="clink">苏州网站建设</a></li>
                        </ul>
                </div>
                <div class="sub-menu" id="tab-4" style=display:none>
                        <ul>
                            <li class="inline"><a href="#" class="clink">网页特效代码</a></li>
							<li class="inline"><a href="#" class="clink">网络营销实务</a></li>
							<li class="inline"><a href="#" class="clink">电子邮件营销</a></li>
							<li class="inline"><a href="#" class="clink">苏州网站建设</a></li>
							<li class="inline"><a href="#" class="clink">苏州网站推广</a></li>
                        </ul>
                </div>
                <div class="sub-menu" id="tab-5" style=display:none>
                        <ul>
                            <li class="inline"><a href="#" class="clink">网页特效代码</a></li>
							<li class="inline"><a href="#" class="clink">网络营销实务</a></li>
							<li class="inline"><a href="#" class="clink">电子邮件营销</a></li>
							<li class="inline"><a href="#" class="clink">苏州网站建设</a></li>
							<li class="inline"><a href="#" class="clink">苏州网站推广</a></li>
                        </ul>
                </div>

        </div><!-- header -->   
  </div><!-- wrapper -->
    
	</td>
</tr>
</table>

<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
    	<td style="width:198px; height:100%; background: #D94733;" valign="top" id="leftbox">
            <iframe name="leftframe" id="leftframe" frameborder="0" width="100%" height="100%" scrolling="auto" style="overflow:visible;" src="default_left.php"></iframe>
        </td>
        <td valign="top" id="dragbox"><img src="images/comm/t.gif" class='img_arrow_l' border="0" id="dragbutton" style="cursor:pointer;" /></td>
        <td id="mainbox" valign="top">

        <iframe name="mainframe" id="mainframe" frameborder="0" width="100%" height="100%" scrolling="auto" style="overflow:visible;" src="lottery_set.php"></iframe></td>
    </tr>
</table>

</BODY>
</HTML>