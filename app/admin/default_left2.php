<?php
//error_reporting(0);
require_once 'conn.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head><title>左侧菜单</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script language="javascript" type="text/javascript" src="js/jquery.js"></script>
<script language="javascript" type="text/javascript" src="js/common.js"></script>
<SCRIPT LANGUAGE='JavaScript'>function ResumeError() {return true;} window.onerror = ResumeError; </SCRIPT>
<link href="css/main.css" rel="stylesheet" type="text/css" />
</HEAD>
<BODY>
<div class="mem_header">
<dl><dt><div class='t_header currsorauto'>会员中心</div></dt>
	<dd>
		<ul class='t_infobox'>
			<li id='userswitch' TITLE='隐藏/显示'><img class='l_link1' src='images/comm/t.gif'>彩神<span class='r1'></span>
			   
			</li>
			<li id='refreshimg' style="" TITLE='点击刷新余额'>余额: <span id="leftusermoney">0.00</span><span class='r2'></span></li>
					</ul>
        <ul class='t_infobox'>
            <li style="text-align:center; font-size:12px; cursor:default;">
            <a href="account_autosave.php" style="border:0; margin:0; padding:0;" target="mainframe"><img id="czimg" TITLE='充值' class='c0' src='images/comm/t.gif' border="0"></a>
			<a href="account_draw.php" style="border:0; margin:0; padding:0;" target="mainframe"><img id="tximg" TITLE='提款' class='t0' src='images/comm/t.gif' border="0"></a>
			<a href="promotion_center.php" style="border:0; margin:0; padding:0;" target="mainframe"><img TITLE='活动' id="hbimg" class='e0' src='images/comm/t.gif' border="0"></a>            </li>
		</ul>
	</dd>
</dl></div>


<div class="mem_header">
<dl><dt><div class='t_header' id='menu-tab'>功能菜单</div></dt> 
    <ul>
	<dt class="explode" name='dtmenu'><div title="menu" class='item_title'>业务流水<span class='actived'></span></div></dt>
	<dd class="item_main">
        	<ul>
					<li TITLE='重庆时时彩 (CQSSC)' ALT='重庆时时彩 (CQSSC)'><a target="mainframe" href="play_cqssc.php">投注记录</a></li>
					<li TITLE='黑龙江时时彩 (HLJSSC)' ALT='黑龙江时时彩 (HLJSSC)'><a target="mainframe" href="play_hljssc.php">追号记录</a></li>
					<li TITLE='新疆时时彩 (XJSSC)' ALT='新疆时时彩 (XJSSC)'><a target="mainframe" href="play_xjssc.php">中奖记录</a></li>
					<li TITLE='江西时时彩 (JXSSC)' ALT='江西时时彩 (JXSSC)'><a target="mainframe" href="play_jxssc.php">返点记录</a></li>
					<li TITLE='上海时时乐 (SHSSL)' ALT='上海时时乐 (SHSSL)'><a target="mainframe" href="play_shssl.php">帐变记录</a></li>
					<li TITLE='十一运夺金 (山东11选5,SD11-5)' ALT='十一运夺金 (山东11选5,SD11-5)'><a target="mainframe" href="play_sd115.php">可疑数据</a></li>
		    </ul>
    	</dd>
	</ul>
    <ul>
	<dt class="explode" name='dtmenu'><div title="menu" class='item_title'>用户管理<span class='actived'></span></div></dt>
	<dd class="item_main">
        	<ul>
					<li TITLE='增加下级用户' ALT='增加下级用户'><a target="mainframe" href="users_add.php">增加用户</a></li>
					<li TITLE='所有用户信息' ALT='所有用户信息'><a target="mainframe" href="users_list.php">用户列表</a></li>
					<li TITLE='所有用户信息' ALT='所有用户信息'><a target="mainframe" href="users_list.php">银行信息</a></li>
					<li TITLE='增加下级用户' ALT='增加下级用户'><a target="mainframe" href="users_add.php">用户返点</a></li>
					<li TITLE='投注记录查看' ALT='投注记录查看'><a target="mainframe" href="history_playlist.php">登陆日志</a></li>
					<li TITLE='追号记录查看' ALT='追号记录查看'><a target="mainframe" href="history_tasklist.php">操作日志</a></li>
		    </ul>
    	</dd>
	</ul>
    <ul>
	<dt class="explode" name='dtmenu'><div title="menu" class='item_title'>财务管理<span class='actived'></span></div></dt>
	<dd class="item_main">
        	<ul>
					<li TITLE='所有用户信息' ALT='所有用户信息'><a target="mainframe" href="users_list.php">手动充值</a></li>
					<li TITLE='增加下级用户' ALT='增加下级用户'><a target="mainframe" href="users_add.php">充值记录</a></li>
					<li TITLE='修改自己的昵称' ALT='修改自己的昵称'><a target="mainframe" href="users_edit.php">提现请求</a></li>
					<li TITLE='查看平台消息' ALT='查看平台消息'><a target="mainframe" href="users_message.php">提现记录</a></li>
		    </ul>
    	</dd>
	</ul>
    <ul>
	<dt class="explode" name='dtmenu'><div title="menu" class='item_title'>数据统计<span class='actived'></span></div></dt>
	<dd class="item_main">
        	<ul>
					<li TITLE='查看所有账变信息' ALT='查看所有账变信息'><a target="mainframe" href="report_list.php">盈亏统计</a></li>
					<li TITLE='查询游戏统计信息' ALT='查询游戏统计信息'><a target="mainframe" href="report_game.php">充值统计</a></li>
					<li TITLE='统计返点情况' ALT='统计返点情况'><a target="mainframe" href="report_reward.php">提现统计</a></li>
					<li TITLE='今日游戏统计' ALT='今日游戏统计'><a target="mainframe" href="report_today.php">投注统计</a></li>
					<li TITLE='今日游戏统计' ALT='今日游戏统计'><a target="mainframe" href="report_today.php">中奖统计</a></li>
					<li TITLE='今日游戏统计' ALT='今日游戏统计'><a target="mainframe" href="report_today.php">返点统计</a></li>
					<li TITLE='今日游戏统计' ALT='今日游戏统计'><a target="mainframe" href="report_today.php">分红统计</a></li>
					<li TITLE='今日游戏统计' ALT='今日游戏统计'><a target="mainframe" href="report_today.php">活动统计</a></li>
					<li TITLE='今日游戏统计' ALT='今日游戏统计'><a target="mainframe" href="report_today.php">投注统计</a></li>
		    </ul>
    	</dd>
	</ul>
     <ul>
	<dt class="explode" name='dtmenu'><div title="menu" class='item_title'>账户管理<span class='actived'></span></div></dt>
	<dd class="item_main">
        	<ul>
					<li TITLE='修改登陆密码和资金密码' ALT='修改登陆密码和资金密码'><a target="mainframe" href="account_update.php">修改密码</a></li>
					<li TITLE='填写充值申请' ALT='填写充值申请'><a target="mainframe" href="account_autosave.php">充值申请</a></li>
					<li TITLE='填写提现申请' ALT='填写提现申请'><a target="mainframe" href="account_draw.php">提现申请</a></li>
					<li TITLE='管理我的银行卡' ALT='管理我的银行卡'><a target="mainframe" href="account_banks.php">我的银行卡</a></li>
		    </ul>
    	</dd>
	</ul>
     <ul>
	<dt class="explode" name='dtmenu'><div title="menu" class='item_title'>彩票设置<span class='actived'></span></div></dt>
	<dd class="item_main">
        	<ul>
					<li TITLE='信息中心' ALT='信息中心'><a target="mainframe" href="lottery_nums.php">时间管理</a></li>
					<li TITLE='玩法介绍' ALT='玩法介绍'><a target="mainframe" href="lottery_data.php">开奖号码</a></li>
					<li TITLE='平台功能介绍' ALT='平台功能介绍'><a target="mainframe" href="lottery_port.php">接口管理</a></li>
					<li TITLE='常见问题说明' ALT='常见问题说明'><a target="mainframe" href="lottery_bei.php">限倍管理</a></li>
					<li TITLE='常见问题说明' ALT='常见问题说明'><a target="mainframe" href="lottery_zhu.php">限注管理</a></li>
					<li TITLE='常见问题说明' ALT='常见问题说明'><a target="mainframe" href="lottery_set.php">彩种设置</a></li>
					<li TITLE='常见问题说明' ALT='常见问题说明'><a target="mainframe" href="help_general.php">玩法设置</a></li>
		    </ul>
    	</dd>
	</ul>
     <ul>
	<dt class="explode" name='dtmenu'><div title="menu" class='item_title'>系统设置<span class='actived'></span></div></dt>
	<dd class="item_main">
        	<ul>
					<li TITLE='信息中心' ALT='信息中心'><a target="mainframe" href="help_security.php">系统设置</a></li>
					<li TITLE='玩法介绍' ALT='玩法介绍'><a target="mainframe" href="help_game.php">银行设置</a></li>
					<li TITLE='平台功能介绍' ALT='平台功能介绍'><a target="mainframe" href="help_fun.php">充值设置</a></li>
					<li TITLE='常见问题说明' ALT='常见问题说明'><a target="mainframe" href="help_general.php">提现设置</a></li>
					<li TITLE='常见问题说明' ALT='常见问题说明'><a target="mainframe" href="help_general.php">活动设置</a></li>
					<li TITLE='常见问题说明' ALT='常见问题说明'><a target="mainframe" href="help_general.php">公告管理</a></li>
					<li TITLE='常见问题说明' ALT='常见问题说明'><a target="mainframe" href="help_general.php">消息管理</a></li>
					<li TITLE='常见问题说明' ALT='常见问题说明'><a target="mainframe" href="help_general.php">数据备份</a></li>
					<li TITLE='常见问题说明' ALT='常见问题说明'><a target="mainframe" href="help_general.php">访问统计</a></li>
					<li TITLE='常见问题说明' ALT='常见问题说明'><a target="mainframe" href="help_general.php">在线人数</a></li>
		    </ul>
    	</dd>
	</ul>
    <ul>
	<dt class="explode" name='dtmenu'><div title="menu" class='item_title'>管理员<span class='actived'></span></div></dt>
	<dd class="item_main">
        	<ul>
					<li TITLE='信息中心' ALT='信息中心'><a target="mainframe" href="help_security.php">管理员列表</a></li>
					<li TITLE='玩法介绍' ALT='玩法介绍'><a target="mainframe" href="help_game.php">操作日志</a></li>
					<li TITLE='平台功能介绍' ALT='平台功能介绍'><a target="mainframe" href="help_fun.php">登陆日志</a></li>
		    </ul>
    	</dd>
	</ul>
     <ul>
	<dt class="explode" name='dtmenu'><div title="menu" class='item_title'>计划任务<span class='actived'></span></div></dt>
	<dd class="item_main">
        	<ul>
					<li TITLE='信息中心' ALT='信息中心'><a target="mainframe" href="help_security.php">任务日志</a></li>
		    </ul>
    	</dd>
	</ul>
   </dl>
</div><br/>

<script language="JavaScript">
<!--
jQuery.noConflict();
jQuery("#menu-tab").click(function(){
	if( jQuery("dt[name='dtmenu']").attr("class") == "explode" ){
		jQuery("dt[name='dtmenu']").attr("class","collapse").parent().children("dd").slideUp("fast");
		jQuery(".actived").attr("class","unactived");
		jQuery("#menu-tab").attr("title","展开所有菜单");
	}else{
		jQuery("dt[name='dtmenu']").attr("class","explode").parent().children("dd").slideDown("fast");
		jQuery(".unactived").attr("class","actived");
		jQuery("#menu-tab").attr("title","收缩所有菜单");
	}
});
jQuery("div[title='menu']").click(function(){
	if( jQuery(this).parent().attr("class") == "explode" ){
		jQuery(this).parent().attr("class","collapse").parent().children("dd").slideUp("fast");
		jQuery(this).children("span").attr("class","unactived");
	}else{
		jQuery(this).parent().attr("class","explode").parent().children("dd").slideDown("fast");
		jQuery(this).children("span").attr("class","actived");
	}
});

(function($){
$(document).ready(function(){
	var isopen = false;
	$("#userswitch").click(function(){
		if( isopen == true ){
			isopen = false;
			$(this).nextAll().fadeIn('fast');
			//$(this).html("隐藏");
		}else{
			isopen = true;
			$(this).nextAll().fadeOut('fast');
			//$(this).html("展开");
		}
	});
	$(".item_main").find("a").click(function(){
		$(".item_main").find("a").attr("class","");
		$(".item_main").find("a").blur();
	    $(this).attr("class","active");
	});
	$("#czimg").mouseover(function(){
		$(this).attr("class","c1");
	}).mouseout(function(){
		$(this).attr("class","c0");
	});
	$("#tximg").mouseover(function(){
		$(this).attr("class","t1");
	}).mouseout(function(){
		$(this).attr("class","t0");
	});
	$("#hbimg").mouseover(function(){
		$(this).attr("class","e1");
	}).mouseout(function(){
		$(this).attr("class","e0");
	});

	$("#refreshimg").click(function(){
			$("#leftusermoney").html("<font color='#CCFF00'>载入中</font>");
			$.ajax({
				type : 'POST',
				url  : '/default_menu.php',
				data : 'flag=getmoney',
				timeout : 8000,
				success : function(data){
					if( data == "error" ){//
						$("#leftusermoney").html("<font color='#A20000'>获取失败</font>");
						return false;
					}else{
						var partn = /<(.*)>.*<\/\1>/;
						if( partn.exec(data) ){
							window.top.location.href="default_frame.php";
							return false;
						}
						eval("data="+data+";");
						var dd = moneyFormat(data.money);
						dd = dd.substring(0,(dd.length-2));
						$("#leftusermoney").html(dd);
						return true;
					}
				},
				error: function(){
					$("#leftusermoney").html("<font color='#A20000'>获取失败</font>");
				}
			});
		});
});
})(jQuery);
//-->
</script>
</BODY>
</HTML>