<?php
session_start();
error_reporting(0);
require_once 'conn.php';
require_once 'check.php';

$page = !($_GET['page'])?'1':intval($_GET['page']);
$pagesize=25;
$page2=($page-1)*$pagesize;


$time_min = $_REQUEST['time_min'];
$time_max = $_REQUEST['time_max'];
$cid = $_REQUEST['cid'];

if($time_min!=""){
	$s1=$s1." and adddate>='".$time_min."'";
}

if($time_max!=""){
	$s1=$s1." and adddate>='".$time_max."'";
}

if($cid!=""){
	if($cid=="-1"){
		$s1=$s1." and username='".$_SESSION["username"] ."'";
	}else if($cid=="0"){
		$s1=$s1." and regup='".$_SESSION["username"] ."'";	
	}else{
		$s1=$s1." and username='".$cid."'";	
	}
}else{
	$s1=$s1." and username='".$_SESSION["username"] ."'";
}

$urls="time_min=".$time_min."&time_max=".$time_max."&cid=".$cid;
$s1=$s1." order by id desc";
$sql="select * from ssc_kf where sign='1'".$s1;
//echo $sql;
$rs = mysql_query($sql);
$total = mysql_num_rows($rs);

$sql="select * from ssc_kf where sign='1'".$s1." limit $page2,$pagesize";
$rsnewslist=mysql_query($sql);

$lastpg=ceil($total/$pagesize); //最后页，也是总页数
$page=min($lastpg,$page);
$prepg=$page-1; //上一页
$nextpg=($page==$lastpg ? 0 : $page+1); //下一页

if($page<5){
	$p1=1;
	$p2=min($lastpg,10);
}else{
	$p2=min($lastpg,$page+5);
	$p1=max($p2-9,1);
}
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
<script type="text/javascript" src="js/calendar/jquery.dyndatetime.js"></script>
<script type="text/javascript" src="js/calendar/lang/calendar-utf8.js"></script>
<script language="javascript" src="js/dialog/jquery.dialogUI.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="js/calendar/css/calendar-blue2.css"  />
<script type="text/javascript">
	jQuery(document).ready(function() {		
		jQuery("#time_min").dynDateTime({ifFormat: "%Y-%m-%d %H:%M",daFormat: "%l;%M %p, %e %m,  %Y",align: "Br",electric: true,singleClick: false,button: ".next()", showOthers: true,weekNumbers: true,showsTime: true});
		jQuery("#time_max").dynDateTime({ifFormat: "%Y-%m-%d %H:%M",daFormat: "%l;%M %p, %e %m,  %Y",align: "Br",electric: true,singleClick: false,button: ".next()",showOthers: true,weekNumbers: true,showsTime: true});
		jQuery("#helpimg").click(function(){jQuery("#helpnotice").toggle();});
	});
	
function checkForm(obj){if(jQuery.trim(obj.time_min.value)!=""){if(false==validateInputDate(obj.time_min.value)){alert("时间格式不正确");obj.time_min.focus();return false;}}if( jQuery.trim(obj.time_max.value)!=""){if(false==validateInputDate(obj.time_max.value)){alert("时间格式不正确");obj.time_max.focus();return false;}}}
;(function($){$(document).ready(function(){
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
							$.alert('<IMG src="images/comm/t.gif" class=icons_mb5_e style="margin:5px 15px 0 0;">读取数据出错1，请重试');
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
				$.alert('<IMG src="images/comm/t.gif" class=icons_mb5_e style="margin:5px 15px 0 0;">读取数据出错，请重试');
			}
		});
			
	});
});})(jQuery);
var __sto = setTimeout;    
window.setTimeout=function(callback,timeout,param){var args = Array.prototype.slice.call(arguments,2);var _cb=function(){callback.apply(null,args);};__sto(_cb,timeout);};
</script>
<div class="tab-div">
	<div id="tabbar-div">
		  <span class="tab-front"  id="general_tab_0">
		  <span class="tabbar-left"></span>
		  <span class="content">历史问题列表</span>
		  <span class="tabbar-right"></span>
		</span>
	    <span class="tab-back"  id="general_tab_1">
		    <span class="tabbar-left"></span>
		    <span class="content" onclick="window.location.href='./csonline_addnew.php'">今日问题提交</span>
		    <span class="tabbar-right"></span>
		</span>
	</div>
<div class="tabbar-bottom"></div>

<div class="ld" style='width:100%;margin:2px 10px 0px 0px;'>
<table class='st' border="0" cellspacing="0" cellpadding="0">
<form action="" method="get" name="search" onsubmit="return checkForm(this)">
<tr><td>
时间: <input type="text" size="16" name="time_min" id="time_min" value="" /> 
<img class='icons_mb4' src="images/comm/t.gif" id="time_min_button" />
&nbsp;至&nbsp;
<input type="text" size="16" name="time_max" id="time_max" value="" /> 
<img class='icons_mb4' src="images/comm/t.gif" />&nbsp;&nbsp;
代理: <SELECT name='cid'>
<option value="-1" selected="selected">自己</option>
<OPTION value="0" >全部下级</OPTION>
<?php 
$sqla = "select * from ssc_member WHERE regup='" . $_SESSION["username"] . "'";
$rsa = mysql_query($sqla);
while ($rowa = mysql_fetch_array($rsa)){
?>
<option value="<?=$rowa['username']?>" ><?=$rowa['username']?></option>
<?php }?>
</SELECT>
<button name="submit" type="submit" width='69' height='26' class="btn_search" /></button>
</td></tr></form></table>
</div>


<div class="ld" style='width:100%;margin:0px 0px 0px 0px;'>
<table class="lt" border="0" cellspacing="0" cellpadding="0">
	<tr class='th'>
    	<td>用户名</td>
        <td><div class='line'></div>提问日期</td>
		<td style="width:50%;"><div class='line'></div>问题描述</td>
        <td><div class='line'></div>最后回复</td>
        <td><div class='line'></div>状态</td>
		<td><div class='line'></div>操作</td>
    </tr>
<?php
	while ($row = mysql_fetch_array($rs)){
?>
    <tr align="center">
    	<td><?=$row['username']?></td>
    	<td><?=$row['adddate']?></td>
		<td align="left" style="color:#000000;"><?=$row['cont']?></td>
		<td style="color:#666666; line-height:20px;"><font color="#009900"><?=$row['answer']?></font><br /><?=$row['answerdate']?></td>
    	<td><?php if($row['zt']=="0"){?><font color="#FF0000">未解决</font><?php }else{?><font color="#006600">已解决</font><?php }?></td>
        <td><a TITLE='<?=$row['id']?>' href='javascript:' rel="msginfo">查看</a></td>
    </tr>
<?php }?>
	<tr><td class='b' colspan="8" valign="middle"><div style='text-align:right;'><ul class="pager">总计  <?=$total?> 条数据,  共 <?=$lastpg?> 页 , 当前第 <?=$page?> 页  |  <?php if($page>1){?><LI><A HREF="?<?=$urls?>&page=1">首页</A></LI><LI><A HREF="?<?=$urls?>&page=<?=$page-1?>">上页</A></LI><?php }?><?php for($i=$p1;$i<=$p2;$i++){
		if($i==$page){?><LI CLASS='current' ><A HREF="#"><?=$i?></A></LI><?php }else{?><LI><A HREF="?<?=$urls?>&page=<?=$i?>"><?=$i?></A></LI><?php }}?><?php if($page!=$lastpg){?><LI><A HREF="?<?=$urls?>&page=<?=$page+1?>">下页</A></LI><LI><A HREF="?<?=$urls?>&page=<?=$lastpg?>">尾页</A></LI><?php }?> | 转至 <SCRIPT LANGUAGE="JAVASCRIPT">function keepKeyNum(obj,evt){var  k=window.event?evt.keyCode:evt.which; if( k==13 ){ goPage(obj.value);return false; }} function goPage( iPage ){ if( !isNaN(parseInt(iPage)) ) { if(iPage> 1 ){iPage=1;} window.location.href="?<?=$urls?>&page="+iPage;}}</SCRIPT><INPUT onKeyPress="return keepKeyNum(this,event);" TYPE="TEXT" ID="iGotoPage" NAME="iGotoPage" size="3"> 页  &nbsp;<BUTTON onclick="javascript:goPage( document.getElementById('iGotoPage').value );return false;">GO</BUTTON>&nbsp;&nbsp;</ul></div></td></tr>
</table>
</div>
<div id="footer"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td align="center"><table align="center" width="450">
<tr><td align="left">浏览器建议：首选IE 8.0浏览器，其次为火狐浏览器。</td></tr>
</table></td></tr><tr><td></td></tr></table></div>
<br/><br/>
</div></div>
<?php echo $count?>
</BODY></HTML>