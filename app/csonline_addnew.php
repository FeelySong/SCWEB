<?php
session_start();
error_reporting(0);
require_once 'conn.php';
require_once 'check.php';

$flag = trim($_POST['flag']);
if($flag=="save"){
	$sql = "insert into ssc_kf set sign='1', cont='".$_REQUEST['message']."', username='".$_SESSION["username"] ."', regup='".Get_member(regup)."', adddate='".date("Y-m-d H:i:s")."'";
	$exe = mysql_query($sql);
	echo "<script language=javascript>window.location='csonline_addnew.php';</script>";
	exit;
}

$sql = "select * from ssc_kf WHERE sign='1' and username='" . $_SESSION["username"] . "' and DATE_FORMAT( adddate, '%Y-%m-%d' )='".date("Y-m-d")."' order by id desc limit 10";
$rs = mysql_query($sql);
$kfnums=mysql_num_rows($rs);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD><TITLE><?php echo $webname;?>  - 在线客服问答</TITLE>
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
 - 在线客服问答 </SPAN><DIV style="clear:both"></DIV></H1>
<script language="javascript" src="js/dialog/jquery.dialogUI.js"></script>
<script type="text/javascript">
;(function($){$(document).ready(function(){
	$("#message").keyup(function(){
		var len = $("#message").val().length;
		if( len > 1000 ){
			alert("超过字数限制，系统会截断您的内容");
			$("#message").val($("#message").val().substring(0, 1000));
			len = 1000;
		}
		$("#inputlen").html(len);
	}).keydown(function(){
		var len = $("#message").val().length;
		if( len > 1000 ){
			alert("超过字数限制，系统会截断您的内容");
			$("#message").val($("#message").val().substring(0, 1000));
			len = 1000;
		}
		$("#inputlen").html(len);
	});
	
	var notime = 0;
	var fltfunction = function(id){
		var lid = $("#cslastid").val();
		if( lid != undefined ){
			$.ajax({
					type: 'POST',
					url : 'csonline_reply.php',
					data: "id="+id+"&flag=getnew&lid="+lid,
					dataType: "json",
					global: false,
					success : function(data){//成功
						if( typeof(data) == 'object' && data.stats != 'error' ){
							$(data.data.datas).appendTo("div[class='chat']");
							var chatdiv = $("div[class='chat']")[0];
							chatdiv.scrollTop = chatdiv.scrollHeight;
							$("#cslastid").val(data.data.lastid);
							notime = 0;
							window.setTimeout(fltfunction,20000,id);
						}else if( typeof(data) == 'object' && data.data=='4' ){
							notime++;
							window.setTimeout(fltfunction,(notime*2000+20000),id);
						}
					},
					error: function(){
						window.setTimeout(fltfunction,300000,id);
					}
			});
		}else{
			return false;
		}
	};
	
	$("a[rel='msginfo']").click(function(){
		me = this;
		$mid = $(this).attr('title');
		$.blockUI({
            message: '<div style="width:200px;padding:10px 100px;background-color:#fff;border:4px #666 solid;"><img src="images/comm/loading.gif" style="margin-right:10px;">正在读取详细信息...</div>',
            overlayCSS: {backgroundColor: '#000000',opacity: 0.3,cursor:'wait'}
        });
		$.ajax({
			type: 'POST',
            url : 'csonline_reply.php',
            data: "id="+$mid,
			dataType: "json",
            success : function(data){//成功
						$.unblockUI({fadeInTime: 0, fadeOutTime: 0});
						if( typeof(data) != 'object' ){
							$.alert('<IMG src="images/comm/t.gif" class=icons_mb5_e style="margin:5px 15px 0 0;">读取数据出1错，请重试');
						}else{
							if( data.stats=='error' ){
								$.alert('<IMG src="images/comm/t.gif" class=icons_mb5_e style="margin:5px 15px 0 0;">读取数据出错2，请重试');
							}else{
								$.dialogBox(data.data,'问题详情',600,false);
								var chatdiv = $("div[class='chat']")[0];
								chatdiv.scrollTop = chatdiv.scrollHeight;
								window.setTimeout(fltfunction,30000,$mid);
								$("#csreplay").click(function(){
									if( $(this).attr("title") == 'not' ){
										$(this).val("").css("color","#000000").attr("title",'');
									}
								}).blur(function(){
									if($(this).val()==""){
										$(this).val("请在这里输入您的回复消息。\r\n请注意, 为保证及监督服务质量, 您的上级可以查看您与客服之间的对话。").css("color","#999999").attr("title",'not');
									}
								}).keyup(function(){
									var len = $(this).val().length;
									if( len > 1000 ){
										$(this).val($(this).val().substring(0, 1000));
										len = 1000;
									}
									$("#inputlen").html(len);
								});
								$("#replaysubmit").click(function(){
									if( $("#csreplay").attr("title") == 'not' ){
										alert("请填写 回复内容");
										return false;
									}
									var text = $("#csreplay").val();
									text = text.replace(/\s+$/,'').replace(/(\r|\n)+/g,'\r\n');
									$("#csreplay").val(text);
									if( text == "" ){
										alert("请填写 回复内容");
										return false;
									}
									$(this).ajaxStart(function(){
										$(this).attr("disabled",true).val("提交中..");
									}).ajaxStop(function(){
										$(this).attr("disabled",false).val("  提  交  ");
									});  
									$.ajax({
											type: 'POST',
											url : 'csonline_reply.php',
											data: "id="+$mid+"&flag=replay&text="+text,
											dataType: "json",
											success : function(data){//成功
												if( typeof(data) != 'object' || data.stats == 'error' ){
													alert("服务器繁忙，请稍候再试");
													return false;
												}
												data = data.data;
												var html = '<div class=cboxb><div class=msbox><table border=0 cellspacing=0 cellpadding=0><tr class=t><td class=tl></td><td class=tm></td><td class=tr></td></tr><tr class=mm><td class=ml><img src="images/comm/t.gif"></td><td><table class=ti border=0 cellspacing=0 cellpadding=0><tr><td>'+data.writetime+' ( '+data.user+' )</td></tr></table>'+data.msg+'</td><td class=mr><img src="images/comm/t.gif"></td></tr><tr class=b><td class=bl></td><td class=bm><img src="images/comm/t.gif"></td><td class=br></td></tr></table><div class=ar><div class=ic></div></div></div></div>';
												$("#csreplay").val("请在这里输入您的回复消息。\r\n请注意, 为保证及监督服务质量, 您的上级可以查看您与客服之间的对话。").css("color","#999999").attr("title",'not');
												$(html).appendTo("div[class='chat']");
												var chatdiv = $("div[class='chat']")[0];
												chatdiv.scrollTop = chatdiv.scrollHeight;
											}

									});
								});
							}
						}
					  },
			error: function(){
				$.unblockUI({fadeInTime: 0, fadeOutTime: 0});
				$.alert('<IMG src="images/comm/t.gif" class=icons_mb5_e style="margin:5px 15px 0 0;">读取数据出错3，请重试');
			}
		});
			
	});
	
});})(jQuery);
function checkForm(obj)
{
	var text = document.getElementById("message").value;
	text = text.replace(/\s+$/,'').replace(/(\r|\n)+/g,'\r\n');
	document.getElementById("message").value=text;
	if( text == "" || text.length<5 ){
		alert("请填写 '问题描述'，并且不少于5个字");
		obj.message.focus();
		return false;
	}
	if( obj.agree.checked == false  )
	{
		alert("请阅读 《充值使用说明》后, 并勾选 '我同意并遵守' ");
		obj.agree.focus();
		return false;
	}
}
var __sto = setTimeout;    
window.setTimeout=function(callback,timeout,param){var args = Array.prototype.slice.call(arguments,2);var _cb=function(){callback.apply(null,args);};__sto(_cb,timeout);};
</script>
<STYLE>
.info{line-height:21px;padding:8px 0px;}
.info div{line-height:18px;font-size:12px;padding:0px;margin:0px;}
div .q{color:#222;padding-left:18px;padding-top:3px;}
div .a{color:#070;padding-left:18px;padding-top:3px;padding-bottom:12px;}
.ld .ct .nl{width:15%;}
</STYLE>
<div class="tab-div">
	<div id="tabbar-div">
		  <span class="tab-back"  id="general_tab_0">
		  <span class="tabbar-left"></span>
		  <span class="content" onclick="window.location.href='./csonline_list.php'">历史问题列表</span>
		  <span class="tabbar-right"></span>
		</span>
	    <span class="tab-front"  id="general_tab_1">
		    <span class="tabbar-left"></span>
		    <span class="content">今日问题提交</span>
		    <span class="tabbar-right"></span>
		</span>
	</div>
<div class="tabbar-bottom"></div>

<div class="ld" style='width:99%;margin:5px 0px 0px 0px;'>
<table width="100%" class="ct" border="0" cellspacing="0" cellpadding="0">
<form action="" method="post" name="drawform" id="drawform" onsubmit="return checkForm(this)">
<input type="hidden" name="flag" value="save" />

<tr>
	<td class="nl">今日问题：</td>
    <td>

<table class="lt" border="0" cellspacing="0" cellpadding="0" style="width:80%;">
<?php
if($kfnums==0){?>
<tr align="center"><td colspan="6" class='no-records' style="text-align:left;"><span>今日暂无问题提交</span></td></tr>
<?php
}else{
	while ($row = mysql_fetch_array($rs)){
?>
	<tr align="center">
		<td align="left" style="color:#000000;"><?=$row['cont']?></td>
        <td><?php if($row['zt']=="0"){?><font color="#FF0000">未解决</font><?php }else{?><font color="#006600">已解决</font><?php }?></td>
        <td><?=date("Y-m-d")?></td>
        <td><a TITLE='<?=$row['id']?>' href='javascript:' rel="msginfo">继续提问</a></td>
    </tr>
<?php }}?>
	</table>

    </td>
</tr>
<?php if($kfnums==0){?>
<tr>
	<td class="nl">新问题描述: </td>
    <td style="line-height:25px;"><TEXTAREA NAME="message" id="message" ROWS="5" COLS="70" maxlength="100"></TEXTAREA><br />
    您已输入<font id="inputlen">0</font>字，最多可以输入1000个字</td>
</tr>
<tr>
	<td class="nl">&nbsp;</td>
    <td style="color:#FF0000; font-weight:bold;">
	<button name="submit" type="submit" width='69' height='26' class="btn_submit" /></button> &nbsp;&nbsp;
	<LABEL><INPUT TYPE="checkbox" NAME="agree" ID="agree" VALUE='on' checked="checked"> 我同意并遵守以下的 《在线客服使用须知》</LABEL></td>
</tr>
<?php }?>
<tr>
	<td class="nl">&nbsp;</td>
    <td class='info'>
<font color=red>《在线客服使用须知》</font>: <br/>
&nbsp;&nbsp;1, 客服的服务时间为每天 早上9:00 - 凌晨2:00。<br/>
&nbsp;&nbsp;2, 为保证及监督服务质量,  <font color=red>您的上级</font> 可以查看您与客服之间的对话。<br/>
&nbsp;&nbsp;3, 客服人员 <font color=red>禁止使用</font> 非本系统以外的交谈方式(例如:QQ,SKYPE,等..), 也请您不要主动提供您的联系方式。<br/>
&nbsp;&nbsp;4, 在处理问题的整个过程中,客服人员 <font color=red>绝对不会</font> 要求您提供账户密码,或资金密码,或完整的银行卡账户。<br/>
&nbsp;&nbsp;5, 如果觉得问题我们回答的不清楚，可以在 “全部问题列表”找到相关问题后直接回复，不需要重新提交一次问题。<br/><br/>

	</td>
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
</BODY></HTML>/