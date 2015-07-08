<?php
session_start();
error_reporting(0);
require_once 'conn.php';

	$sqla="select * from ssc_member where username='".$_SESSION["username"]."'";
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
<link href="css/buttons.css" rel="stylesheet" type="text/css" />
</HEAD>
<BODY>
<div class="mem_header">
<dl><dt><div class='t_header currsorauto'><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>会员中心</td>
    <td><a TITLE='退出系统' style='color:#407e3f' onClick="return confirm('确认退出系统?');" href="default_logout.php" target="_top" ><img src="images/v1/tuichu.png" style="border:none;" /></a></td>
  </tr>
</table>
</div></dt>
	<dd>
		<ul class='t_infobox'>
			<li id='userswitch' TITLE='隐藏/显示'><img class='l_link1' src='images/comm/t.gif' style="vertical-align:middle;"><span style=" font-weight:bold;"><?=$rowa['nickname']?></span>
			   
			</li>
			<li id='refreshimg' style="" TITLE='点击刷新余额'>余额: <span id="leftusermoney" style="color:#fdd205; font-weight:bold;"><?=number_format($lmoney,2)?></span></li>
            <?php if($total>0){?>
			<li TITLE='消息列表' style="" onClick="javascript:window.top.frames['mainframe'].document.location.href='./users_message.php'" >未读消息: <?=$total?> 条</li>
			<?php }?>
		</ul>
        <ul class='t_infobox'>
            <li style="text-align:left; font-size:12px; cursor:default;">
            <a href="http://www.bootcss.com/" class="button button-glow button-border button-rounded button-primary" style="float: left;margin-left: 10px;">充值</a>
            <a href="http://www.bootcss.com/" class="button button-glow button-border button-rounded button-primary" style="margin-left: 10px;">提现</a>
            <?php if($_SESSION["level"]==2){?><a href="account_fenhong.php" style="border:0; margin:0; padding:0;" target="mainframe"><img src='images/comm/t.gif' name="tximg" border="0" class='ttt0' id="tximg" TITLE='分红'></a><?php }?>
			<!--a href="promotion_center.php" style="border:0; margin:0; padding:0;" target="mainframe"><img TITLE='活动' id="hbimg" class='e0' src='images/comm/t.gif' border="0"></a-->            </li>
		</ul>
	</dd>
</dl></div>


<div class="mem_header">
<dl>
<?php if($_SESSION["level"]<2){?>
    <ul>
	<dt><div class='t_header currsorauto'>开始游戏</div></dt><span class='actived'></span>
	<dd class="item_main">
        	<ul>
			<?php 
			$sql="select * from ssc_set where zt=1 order by lid asc";
			$rsnewslist = mysql_query($sql);
			while ($row = mysql_fetch_array($rsnewslist)){
			?>
					<li TITLE='<?=$row['name']?> (<?=$row['cname']?>)' ALT='<?=$row['name']?> (<?=$row['cname']?>)'><a target="mainframe" href="<?=$row['urls']?>"><?=$row['name']?></a></li>
            <?php }?>
            		
					
		    	</ul>
    	</dd>
	</ul>
	<ul>
<?php }?>	
	<dt class="explode" name='dtmenu'><div title="menu" class='item_title'><span class='actived'></span></div></dt>
	<dd class="item_main">
        	<ul>
					<li TITLE='查询游戏统计信息' ALT='查询游戏统计信息'></li>
					<li TITLE='查看所有账变信息' ALT='查看所有账变信息'></li>
		    	</ul>
    	</dd>
	</ul>	
     
     
   </dl>
   <!--<dt><div style="height:25px; text-align:center;"><a href="http://175.41.17.206/1.rar" target="_blank"><img src="images/v1/down.gif" border="0" /></a></div>
   </dt>-->
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
//						var dd = moneyFormat(data.money);
						var dd = data.money;
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