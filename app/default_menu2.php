<?php
session_start();
error_reporting(0);
require_once 'conn.php';

	$sqla="select * from ssc_member where username='".$_SESSION["username"] ."'";
	$rsa=mysql_query($sqla) or  die("数据库修改出错!!!!".mysql_error());
	$rowa = mysql_fetch_array($rsa);
	if(empty($rowa)){
		//退出
//		$lmoney="0.00";
	}else{
		$lmoney=$rowa['leftmoney'];
	}
	
$flag=$_REQUEST['flag'];
if($flag=="getmoney"){
	echo " {\"money\":\"".number_format($lmoney,4)."\"}";
}else{
	$sql="select * from ssc_message where zt='0' and username='" . $_SESSION["username"] . "'";
	$rs = mysql_query($sql);
	$total = mysql_num_rows($rs);
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
			<li id='userswitch' TITLE='隐藏/显示'><img class='l_link1' src='images/comm/t.gif'><?=$rowa['nickname']?><span class='r1'></span>
			   
			</li>
			<li id='refreshimg' style="" TITLE='点击刷新余额'>余额: <span id="leftusermoney"><?=number_format($lmoney,2)?></span><span class='r2'></span></li>
            <?php if($total>0){?>
			<li TITLE='消息列表' style="" onClick="javascript:window.top.frames['mainframe'].document.location.href='./users_message.php'" >未读消息: <?=$total?> 条<span class='r3'></span></li><?php }?>
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
	<dt class="explode" name='dtmenu'><div title="menu" class='item_title'>开始游戏<span class='actived'></span></div></dt>
	<dd class="item_main">
        	<ul>
			<?php 
			$sql="select * from ssc_set where zt=1 order by lid asc";
			$rsnewslist = mysql_query($sql);
			while ($row = mysql_fetch_array($rsnewslist)){
			?>
					<li TITLE='<?=$row['name']?> (<?=$row['cname']?>)' ALT='<?=$row['name']?> (<?=$row['cname']?>)'><a target="mainframe" href="<?=$row['urls']?>"><?=$row['name']?></a></li>
            <?php }?>
					<li TITLE='黑龙江时时彩 (HLJSSC)' ALT='黑龙江时时彩 (HLJSSC)'><a target="mainframe" href="play_hljssc.php">黑龙江时时彩</a></li>
					<li TITLE='新疆时时彩 (XJSSC)' ALT='新疆时时彩 (XJSSC)'><a target="mainframe" href="play_xjssc.php">新疆时时彩</a></li>
					<li TITLE='江西时时彩 (JXSSC)' ALT='江西时时彩 (JXSSC)'><a target="mainframe" href="play_jxssc.php">江西时时彩</a></li>
					<li TITLE='上海时时乐 (SHSSL)' ALT='上海时时乐 (SHSSL)'><a target="mainframe" href="play_shssl.php">上海时时乐</a></li>
					<li TITLE='十一运夺金 (山东11选5,SD11-5)' ALT='十一运夺金 (山东11选5,SD11-5)'><a target="mainframe" href="play_sd115.php">十一运夺金</a></li>
					<li TITLE='多乐彩 (江西11选5,JX11-5)' ALT='多乐彩 (江西11选5,JX11-5)'><a target="mainframe" href="play_jx115.php">多乐彩</a></li>
					<li TITLE='广东11选5 (GD11-5)' ALT='广东11选5 (GD11-5)'><a target="mainframe" href="play_gd115.php">广东十一选五</a></li>
					<li TITLE='重庆十一选五(CQ11-5)' ALT='重庆十一选五(CQ11-5)'><a target="mainframe" href="play_cq115.php">重庆十一选五</a></li>
					<li TITLE='福彩3D (3D)' ALT='福彩3D (3D)'><a target="mainframe" href="play_fucai3d.php">福彩3D</a></li>
					<li TITLE='排列三、五 (P3P5)' ALT='排列三、五 (P3P5)'><a target="mainframe" href="play_p3p5.php">排列三、五</a></li>
		    	</ul>
    	</dd>
	</ul>
     <ul>
	<dt class="explode" name='dtmenu'><div title="menu" class='item_title'>游戏记录<span class='actived'></span></div></dt>
	<dd class="item_main">
        	<ul>
					<li TITLE='投注记录查看' ALT='投注记录查看'><a target="mainframe" href="history_playlist.php">投注记录</a></li>
					<li TITLE='追号记录查看' ALT='追号记录查看'><a target="mainframe" href="history_tasklist.php">追号记录</a></li>
		    	</ul>
    	</dd>
	</ul>
     <ul>
	<dt class="explode" name='dtmenu'><div title="menu" class='item_title'>用户管理<span class='actived'></span></div></dt>
	<dd class="item_main">
        	<ul>
					<li TITLE='所有用户信息' ALT='所有用户信息'><a target="mainframe" href="users_list.php">用户列表</a></li>
					<li TITLE='增加下级用户' ALT='增加下级用户'><a target="mainframe" href="users_add.php">增加用户</a></li>
					<li TITLE='修改自己的昵称' ALT='修改自己的昵称'><a target="mainframe" href="users_edit.php">修改昵称</a></li>
					<li TITLE='查看平台消息' ALT='查看平台消息'><a target="mainframe" href="users_message.php">我的消息</a></li>
					<li TITLE='查看各彩种奖金' ALT='查看各彩种奖金'><a target="mainframe" href="users_info.php">奖金详情</a></li>
		    	</ul>
    	</dd>
	</ul>
     <ul>
	<dt class="explode" name='dtmenu'><div title="menu" class='item_title'>报表管理<span class='actived'></span></div></dt>
	<dd class="item_main">
        	<ul>
					<li TITLE='查看所有账变信息' ALT='查看所有账变信息'><a target="mainframe" href="report_list.php">账变列表</a></li>
					<li TITLE='查询游戏统计信息' ALT='查询游戏统计信息'><a target="mainframe" href="report_game.php">报表查询</a></li>
					<li TITLE='统计返点情况' ALT='统计返点情况'><a target="mainframe" href="report_reward.php">返点统计</a></li>
					<li TITLE='今日游戏统计' ALT='今日游戏统计'><a target="mainframe" href="report_today.php">今日报表</a></li>
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
	<dt class="explode" name='dtmenu'><div title="menu" class='item_title'>帮助中心<span class='actived'></span></div></dt>
	<dd class="item_main">
        	<ul>
					<li TITLE='信息中心' ALT='信息中心'><a target="mainframe" href="help_security.php">信息中心</a></li>
					<li TITLE='玩法介绍' ALT='玩法介绍'><a target="mainframe" href="help_game.php">玩法介绍</a></li>
					<li TITLE='平台功能介绍' ALT='平台功能介绍'><a target="mainframe" href="help_fun.php">功能介绍</a></li>
					<li TITLE='常见问题说明' ALT='常见问题说明'><a target="mainframe" href="help_general.php">常见问题</a></li>
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
				url  : 'default_menu.php',
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
<?php }?>