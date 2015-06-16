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
#tab-2,#tab-3,#tab-4,#tab-5,#tab-6,#tab-7,#tab-8,#tab-9,#tab-10,#tab-11,#tab-12{display: none;}
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
	
	jQuery("#mainbox").height( jQuery(document).height()-jQuery("#topbox").height()-67 );
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

_fastData = setInterval(function(){
	$.ajax({
		type : 'POST',
		url  : 'query.php',
		timeout : 9000,
		success : function(data){
			return true;
		}
	});
},10000);

_fastData = setInterval(function(){
	$.ajax({
		type : 'POST',
		url  : 'default_getdata.php',
		timeout : 9000,
		success : function(data){
				var partn = /<(.*)>.*<\/\1>/;
				if( partn.exec(data) ){
					window.top.location.href="default_main.php";
					return false;
				}
				eval("data="+data+";");
				//用户余额
				if( data.msga != 'empty' ){
					var dd = data.msga;
					$("#msga").html(dd);
				}
				if( data.msgb != 'empty' ){
					var dd = data.msgb;
					$("#msgb").html(dd);
				}
				if( (data.msga != 'empty' && data.msga != '0') || (data.msgb != 'empty' && data.msgb != '0') ){
					document.SoundMSG1.play();
				}
				return true;
		}
	});
},10000);

});

function resizewindow(){
	jQuery("#mainbox").height( jQuery(window).height()-jQuery("#topbox").height()-67 );
	jQuery("#leftbox").height( jQuery(window).height()-jQuery("#topbox").height()-67 );
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
			  <li><a TITLE='在线客服信息' style='color:#f00;padding-left:6px;' href="kf.php?zt=0" target="mainframe"><img class='link1' src='images/comm/t.gif'>客服信息(<span id="msga">0</span>)</a></li>
			  <li><a TITLE='提款信息' style='color:#f00;padding-left:6px;' href="account_tx.php" target="mainframe"><img class='link2' src='images/comm/t.gif'>提款信息(<span id="msgb">0</span>)</a></li>
			  <li><a TITLE='刷新当前页' style='color:#000;padding-left:6px;' href="javascript:window.top.frames['mainframe'].document.location.reload();"><img src='images/comm/t.gif'>刷新</a></li>
			  <li><a TITLE='退出系统' style='color:#00f;padding-left:6px;' onClick="return confirm('确认退出系统?');" href="default_logout.php" target="_top"><img src='images/comm/t.gif'>退出</a></li>
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
                                <li ><a href="#tab-6" class="tab" onClick="return false;">数据统计</a></li>
                          		<li ><a href="#tab-7" class="tab" onClick="return false;">游戏管理</a></li>
                                <li ><a href="#tab-8" class="tab" onClick="return false;">奖金管理</a></li>
                                <li ><a href="#tab-9" class="tab" onClick="return false;">系统管理</a></li>
                                <li ><a href="#tab-10" class="tab" onClick="return false;">权限管理</a></li>
                                <li ><a href="#tab-11" class="tab" onClick="return false;">计划任务</a></li>
                                <li ><a href="#tab-12" class="tab" onClick="return false;">帮助中心</a></li>
                        </ul>
          </div>
                 <!-- navigation -->
                <div class="sub-menu" id="tab-1" style=display:none>
                        <ul>
                            <li class="inline"><a href="affiche_edit.php?act=add" target="mainframe" class="clink">添加公告</a></li>
                            <li class="inline"><a href="affiche.php" target="mainframe" class="clink">公告管理</a></li>
							<li class="inline"><a href="kf.php" target="mainframe" class="clink">会员消息</a></li>
							<li class="inline"><a href="message.php" target="mainframe" class="clink">系统消息</a></li>
                        </ul>
                </div>
                <div class="sub-menu" id="tab-2" style=display:none>
                        <ul>
                            <li class="inline"><a href="mem_edit.php?act=add" target="mainframe" class="clink">新增会员</a></li>
							<li class="inline"><a href="mem_list.php" target="mainframe" class="clink">会员列表</a></li>
							<li class="inline"><a href="mem_card.php" target="mainframe" class="clink">银行信息</a></li>
							<li class="inline"><a href="mem_logs.php" target="mainframe" class="clink">登陆日志</a></li>
							<li class="inline"><a href="mem_amend.php" target="mainframe" class="clink">操作日志</a></li>
                        </ul>
                </div>
                <div class="sub-menu" id="tab-3" style=display:block>
                        <ul>
                            <li class="inline"><a href="account_cz.php" target="mainframe" class="clink">手动充值</a></li>
							<li class="inline"><a href="account_czlist.php" target="mainframe" class="clink">充值记录</a></li>
							<li class="inline"><a href="account_tx.php" target="mainframe" class="clink">提现请求</a></li>
							<li class="inline"><a href="account_txlist.php" target="mainframe" class="clink">提现记录</a></li>
                        </ul>
                </div>
                <div class="sub-menu" id="tab-4" style=display:none>
                        <ul>
                            <li class="inline"><a href="account_tz.php" target="mainframe" class="clink">投注记录</a></li>
							<li class="inline"><a href="account_zh.php" target="mainframe" class="clink">追号记录</a></li>
							<li class="inline"><a href="account_prize.php" target="mainframe" class="clink">中奖记录</a></li>
							<li class="inline"><a href="account_rebate.php" target="mainframe" class="clink">返点记录</a></li>
							<li class="inline"><a href="account_record.php" target="mainframe" class="clink">账变明细</a></li>
							<li class="inline"><a href="error.php" target="mainframe" class="clink">可疑数据</a></li>
                        </ul>
                </div>
                <div class="sub-menu" id="tab-5" style=display:none>
                        <ul>
                            <li class="inline"><a href="total_xf.php" target="mainframe" class="clink">消费报表</a></li>
							<li class="inline"><a href="total_yk.php" target="mainframe" class="clink">结算报表</a></li>
                        </ul>
                </div>
                <div class="sub-menu" id="tab-6" style=display:none>
                        <ul>
                            <li class="inline"><a href="total_yk.php" target="mainframe" class="clink">盈亏统计</a></li>
							<li class="inline"><a href="total_cz.php" target="mainframe" class="clink">充值统计</a></li>
							<li class="inline"><a href="total_tx.php" target="mainframe" class="clink">提现统计</a></li>
							<li class="inline"><a href="total_tz.php" target="mainframe" class="clink">投注统计</a></li>
							<li class="inline"><a href="total_prize.php" target="mainframe" class="clink">中奖统计</a></li>
							<li class="inline"><a href="total_rebate.php" target="mainframe" class="clink">返点统计</a></li>
							<li class="inline"><a href="total_fh.php" target="mainframe" class="clink">分红统计</a></li>
							<li class="inline"><a href="total_hd.php" target="mainframe" class="clink">活动统计</a></li>
                        </ul>
                </div>
                <div class="sub-menu" id="tab-7" style=display:none>
                        <ul>
                            <li class="inline"><a href="lottery_nums.php" target="mainframe" class="clink">时间管理</a></li>
							<li class="inline"><a href="lottery_data.php" target="mainframe" class="clink">开奖号码</a></li>
							<li class="inline"><a href="lottery_port.php" target="mainframe" class="clink">接口管理</a></li>
							<li class="inline"><a href="lottery_set.php" target="mainframe" class="clink">彩种设置</a></li>
							<li class="inline"><a href="lottery_class.php" target="mainframe" class="clink">玩法设置</a></li>
							<li class="inline"><a href="lottery_bei.php" target="mainframe" class="clink">限倍管理</a></li>
							<li class="inline"><a href="lottery_zhu.php" target="mainframe" class="clink">限注管理</a></li>
                        </ul>
                </div>
                <div class="sub-menu" id="tab-8" style=display:none>
                        <ul>
							<li class="inline"><a href="lottery_rate.php" target="mainframe" class="clink">资金设置</a></li>
							<li class="inline"><a href="lottery_rebate.php" target="mainframe" class="clink">返点设置</a></li>
                        </ul>
                </div>
          		<div class="sub-menu" id="tab-9" style=display:none>
                        <ul>
                            <li class="inline"><a href="config.php" target="mainframe" class="clink">系统设置</a></li>
							<li class="inline"><a href="banks.php" target="mainframe" class="clink">银行设置</a></li>
							<li class="inline"><a href="banks_cz.php" target="mainframe" class="clink">充值设置</a></li>
							<li class="inline"><a href="banks_tx.php" target="mainframe" class="clink">提现设置</a></li>
							<li class="inline"><a href="activity.php" target="mainframe" class="clink">活动设置</a></li>
							<li class="inline"><a href="backup.php" target="mainframe" class="clink">数据备份</a></li>
							<li class="inline"><a href="total.php" target="mainframe" class="clink">访问统计</a></li>
							<li class="inline"><a href="online.php" target="mainframe" class="clink">在线人员</a></li>
                        </ul>
          </div>
                <div class="sub-menu" id="tab-10" style=display:none>
                        <ul>
                            <li class="inline"><a href="manager.php" target="mainframe" class="clink">管理员</a></li>
							<li class="inline"><a href="admin_logs.php" target="mainframe" class="clink">登陆日志</a></li>
							<li class="inline"><a href="admin_amend.php" target="mainframe" class="clink">操作记录</a></li>
                        </ul>
          </div>
                <div class="sub-menu" id="tab-11" style=display:none>
                        <ul>
                            <li class="inline"><a href="plan.php" target="mainframe" class="clink">任务日志</a></li>
                        </ul>
                </div>
                <div class="sub-menu" id="tab-12" style=display:none>
                        <ul>
                            <li class="inline"><a href="intro1.php" target="mainframe" class="clink">玩法介绍</a></li>
							<li class="inline"><a href="intro2.php" target="mainframe" class="clink">功能介绍</a></li>
							<li class="inline"><a href="intro3.php" target="mainframe" class="clink">常见问题</a></li>
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

        <iframe name="mainframe" id="mainframe" frameborder="0" width="100%" height="100%" scrolling="auto" style="overflow:visible;" src="lottery_class.php"></iframe></td>
    </tr>
</table>
<EMBED NAME="SoundMSG1" SRC="Sound/msg1.mp3" LOOP=FALSE AUTOSTART=FALSE HIDDEN=TRUE MASTERSOUND>
<EMBED NAME="SoundMSG2" SRC="Sound/msg2.mp3" LOOP=FALSE AUTOSTART=FALSE HIDDEN=TRUE MASTERSOUND>
</BODY>
</HTML>