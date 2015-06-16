<?php
session_start();
error_reporting(0);
require_once 'conn.php';
require_once 'check.php';

$bid=$_POST["bankinfo"];
$sqla = "SELECT * FROM ssc_banks WHERE tid='" . $bid . "'";
$rsa = mysql_query($sqla);
$rowa = mysql_fetch_array($rsa);

if($bid==3){
	$sqlc = "select * from ssc_bankcard WHERE id='" . $_POST["mybank"] . "'";
	$rsc = mysql_query($sqlc);
	$rowc = mysql_fetch_array($rsc);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD><TITLE><?php echo $webname;?>  - 自动充值</TITLE>
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

<H1><SPAN class="action-span"><A href="account_savelist.php?check=952" target='_self'>充值记录</a></SPAN><SPAN class="action-span"><A href="account_save.php?check=952" target='_self'>人工充值</a></SPAN>
<SPAN class="action-span1"><DIV class='tubiao'></DIV>当前位置: <A href="/" target='_top'><?php echo $webname;?></a>
 - 自动充值 </SPAN><DIV style="clear:both"></DIV></H1>
<div class="ld">
<div id="demobox" style="position:absolute; display:none; margin-top:-40px; z-index:100; float:right;"><img src="images/help/zdcz<?=$bid?>.png" style="border:2px solid #333333;" /></div>
<table class="ct" border="0" cellspacing="0" cellpadding="0">
<tr>
	<td class="nl">充值银行：</td>
	<td><a href="<?=$rowa['url']?>" target="_blank"><img src="images/banks/<?=$rowa['tid']?>.jpg" border="0" /></a>&nbsp;&nbsp;&nbsp;<a href="<?=$rowa['url']?>" style="color:#009900; font-size:14px; font-weight:bold;" target="_blank">←点此进入网上银行</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;页面有效期倒计时：<span id="expire_time" style="color:#006699; font-size:14px; font-weight:bold;">00:00</span></td>
</tr>
<?php if($bid==19){?>
<tr>
    <td class="nl">财付通付款方式：</td>
    <td style="color:#080;">向亲朋好友付款</td>
</tr>
<?php }?>
<tr>
    <td class="nl">收款账户名：</td>
    <td style="color:#333333;"><span id="copy_name_txt" style="padding-right:10px;"><?=$rowa['uname']?></span> <a href='#' TITLE='复制' onClick="javascript:copyToClipboard( 'copy_name_txt','【收款账户名】' )" ><img src="images/comm/copy.gif" border="0" />复制</a></td>
</tr>
<tr>
	<td class="nl">收款账号：</td>
    <td style="color:#333333;"><span id="copy_account_txt" style="padding-right:10px;"><?=$rowa['account']?></span> <a href='#' TITLE='复制' onClick="javascript:copyToClipboard( 'copy_account_txt','【收款账号】' )" ><img src="images/comm/copy.gif" border="0" />复制</a></td>
</tr>
<tr>
	<td class="nl">充值金额：</td>
    <td style="color:#333333;"><span id="copy_monye_txt" style="padding-right:10px;"><?=number_format($_POST['real_money'],2)?></span> <a href='#' TITLE='复制' onClick="javascript:copyToClipboard( 'copy_monye_txt','【充值金额】' )" ><img src="images/comm/copy.gif" border="0" />复制</a></td>
</tr>
<?php if($bid==1){?>
<tr>
	<td class="nl">温馨提示：</td>
    <td style="color:#080;">在工商银行的网银界面中，使用“E-mail 汇款”功能。</td>
</tr>
<?php }?>
<?php if($bid==3){?>
<tr>
	<td class="nl">您的汇款银行卡：</td>
    <td style="line-height:23px;color:#FF0000;">请使用您在平台绑定的<font color="#006699">【尾号为<?=substr($rowc['cardno'],-4)?>】</font>的建行卡进行汇款，否则不能到账！<br/>
	注意: 建行每天会在 <b style='color:#069'>22:30-00:00</b> 维护,请避开维护时段！</td>
</tr>
<?php }?>
<?php if($bid==1 || $bid==4 || $bid==19 || $bid==7){?>
<tr>
	<td class="nl">附言(充值编号)：</td>
    <td style="color:#FF0000;"><span id="copy_msg_txt" style="padding-right:10px; font-family:fixedsys;"><?=$_SESSION["sess_uid"]?></span> <a href='#' TITLE='复制' onClick="javascript:copyToClipboard( 'copy_msg_txt','【附言(充值编号)】' )" ><img src="images/comm/copy.gif" border="0" />复制</a>&nbsp;&nbsp;&nbsp;&nbsp;<font color="#FF0000">←务必将此充值编号正确填写到汇款附言里</font></td>
</tr>
<?php }?>
<tr>
	<td class="nl" style="color:#FF0000;">充值说明：</td>
    <td style="line-height:25px; padding:5px 0; color:#333333;">
<?php if($bid==3){?>
    1、务必使用您在平台绑定的建设银行卡进行充值，否则充值将无法到账。<br />
<?php }else{?>
    1、务必将“充值编号”正确填写到银行汇款页面的“附言”栏中(复制->粘帖[CTRL+V])，否则充值将无法到账。<br />
<?php }?> 
2、充值金额低于<font style="font-size:12px;color:#F30;font-weight:bold;"><?=$rowa['fmoney']?></font>&nbsp;不享受“充值即返手续费”的优惠政策<br />
3、充值编号为随机生成，一个充值编号只能充值一次，过期或重复使用充值将无法到账。<br />
4、收款账户名和收款账号会不定期更换，请在获取最新信息后充值，否则充值将无法到账。<br />
5、“充值金额”与网银转账金额不符，充值将无法到账。<br /></td>
</tr>
<tr>
	<td class="nl">&nbsp;</td>
    <td style="color:#333333;"><input type="button" name="showdemo" id="showdemo" value="充值演示" class="button" /></td>
</tr>
</table>
</div>
<script type="text/javascript">
jQuery(document).ready(function(){
TimeCountDown('expire_time',600,function(){window.location.href="./help_security.php";;});
setTimeout(function(){alert('<?php if($bid==3){?>请使用您在平台绑定的【尾号为<?=substr($rowc['cardno'],-4)?>】的建行卡进行汇款\n否则充值无法到账！\n\n注意: 建行每天会在 22:30-00:00 维护,请避开维护时段！<?php }else{?>务必将“充值编号”正确填写到银行汇款页面的“附言”栏中(复制→ 粘帖[CTRL+V])，否则充值将无法到账。<?php }?>');},1000);
var demoleft = $("#showdemo").offset();
demoleft = demoleft.left +120;
$("#demobox").css({"left":demoleft+"px"});
$("#showdemo").click(function(){
	if($(this).val()=='充值演示'){
		$("#demobox").show();
		$(this).val("关闭演示");
	}else{
		$("#demobox").hide();
		$(this).val("充值演示");
	}
});
});
</script>
<div id="footer"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td align="center"><table align="center" width="450">
<tr><td align="left">浏览器建议：首选IE 8.0浏览器，其次为火狐浏览器。</td></tr>
</table></td></tr><tr><td></td></tr></table></div>
<br/><br/>
</div></div>
<?php echo $count;?>
</BODY></HTML>