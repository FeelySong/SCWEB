<?php
session_start();
error_reporting(0);
require_once 'conn.php';
require_once 'check.php';

if($_GET['check']!="952"){
	if($_SESSION["cwflag"]!="ok"){
		$_SESSION["cwurl"]="account_save.php";
		echo "<script language=javascript>window.location='account_check.php';</script>";
		exit;
	}
}
$_SESSION["cwflag"]="";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD><TITLE><?php echo $webname;?>  - 人工充值</TITLE>
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

<H1><SPAN class="action-span"><A href="account_savelist.php?check=952" target='_self'>充值记录</a></SPAN><SPAN class="action-span"><A href="account_autosave.php?check=952" target='_self'>自动充值</a></SPAN>
<SPAN class="action-span1"><DIV class='icons_mb1'></DIV>当前位置: <A href="/" target='_top'><?php echo $webname;?></a>
 - 人工充值 </SPAN><DIV style="clear:both"></DIV></H1>
<script type="text/javascript">
function checkForm(obj)
{
	s = obj.bankinfo.length;
	ischecked = false;
	for( i=0; i<s; i++ ){
		if( obj.bankinfo[i].checked == true ){
			ischecked = true;
		}
	}
	if( ischecked == false ){
		alert("请选择充值银行");
		return false;
	}
	if (obj.real_money.value == ""){
		alert("请填写 '期望充值金额'");
		obj.real_money.focus();
		return false;
	}
	var loadmin = $("#loadmin").html();
	var loadmax = $("#loadmax").html();
	loadmin = Number(loadmin);
	loadmax = Number(loadmax);
	if(obj.real_money.value < loadmin)
	{
		alert("充值金额不能低于最低充值限额 ");
		$("#real_money").val(loadmin);
		showPaymentFee();
		return false;
	}
	if(obj.real_money.value > loadmax)
	{
		alert("充值金额不能高于最高充值限额 ");
		$("#real_money").val(loadmax);
		showPaymentFee();
		return false;
	}
	if( obj.agree.checked == false  )
	{
		alert("请阅读 《充值使用说明》后, 并勾选 '我同意并遵守' ");
		obj.agree.focus();
		return false;
	}
}
function changeBankInfo(obj){
	var $banklist={"bank2":{"minload":"100","maxload":"40000"}};
	var idname = $(obj).attr("id");
	$("#loadmin").html($banklist[idname]['minload']);
	$("#loadmax").html($banklist[idname]['maxload']);
}
function showPaymentFee(){
	document.drawform.real_money.value = document.drawform.real_money.value.replace(/\D+/g,'');
	jQuery("#chineseMoney").html( changeMoneyToChinese(document.drawform.real_money.value) );
}
</script>
<STYLE>
.info{line-height:21px;
	padding:8px 0px;
	}
.info div{line-height:18px;
	font-size:12px;
	padding:0px;
	margin:0px;
	}
div .q{color:#222;
	padding-left:18px;
	padding-top:3px;
	}
div .a{color:#070;
	padding-left:18px;
	padding-top:3px;
	padding-bottom:12px;
	}
</STYLE>
<div class="tab-div">
	<div id="tabbar-div">
	    <span class="tab-back" id="general_tab_0">
		  <span class="tabbar-left"></span>
		  <span class="content" onclick="window.location.href='./account_autosave.php?check=952'">自动充值</span>
		  <span class="tabbar-right"></span>		</span>
		  <span class="tab-front"  id="general_tab_0">
		  <span class="tabbar-left"></span>
		  <span class="content">人工充值</span>
		  <span class="tabbar-right"></span>		</span>
	    <span class="tab-back"  id="general_tab_1">
		    <span class="tabbar-left"></span>
		    <span class="content" onclick="window.location.href='./account_savelist.php?check=952'">充值记录</span>
		    <span class="tabbar-right"></span>		</span>	</div>

<div class="ld" style='width:99%;margin:5px 0px 0px 0px;'>
<table width="100%" class="ct" border="0" cellspacing="0" cellpadding="0">
<form action="" method="post" name="drawform" id="drawform" onsubmit="return checkForm(this)">
<input type="hidden" name="flag" value="confirm" />
<tr>
	<td class="nl"><font color="#FF3300">提示信息：</font></td>
	<td STYLE='line-height:20px;padding:5px 0px'>每次充值需间隔&nbsp;<font style="font-size:16px;color:#F30;font-weight:bold;">2</font>&nbsp;分钟。<br/>
	<!--每天的充值处理时间为：<font style="font-size:16px;color:#F30;font-weight:bold;">10:00-2:00</font>//-->
	每天的充值处理时间为：<font style="font-size:16px;color:#F30;font-weight:bold;">早上 10:00 至 次日凌晨 2:00</font><br/>	</td>
</tr>
<tr>
	<td class="nl">选择充值银行: </td>
    <td>
    	
    <input type="radio" name="bankinfo" value="T8QRS5" id="bank2" onchange="changeBankInfo(this)" />&nbsp;<label for='bank2'><img src="images/banks/2.jpg" STYLE='cursor:pointer;' /></label>&nbsp;&nbsp;&nbsp;
    	&nbsp;&nbsp;<span style="color:red; display:none"><input type="radio" name="bankinfo" value="" /></span>    </td>
</tr>
<tr>
	<td class="nl">期望充值金额: </td>
    <td><input type="text" name="real_money" id="real_money" maxlength="10" onkeyup="showPaymentFee();" />
	&nbsp;&nbsp;<span style="color:red;"></span> ( 单笔充值限额：最低：&nbsp;<font style="color:#FF3300" id="loadmin">&nbsp;</font>&nbsp;元，最高：&nbsp;<font style="color:#FF3300" id="loadmax">&nbsp;</font>&nbsp;元 ) </td>
</tr>
<tr>
	<td class="nl">期望充值金额(大写): </td>
    <td>&nbsp;<span id="chineseMoney"></span><input type="hidden" id="hiddenchinese" /></td>
</tr>
<tr>
	<td class="nl">&nbsp;</td>
    <td style="color:#FF0000; font-weight:bold;"><LABEL><INPUT TYPE="checkbox" NAME="agree" ID="agree" VALUE='on'> 我同意并遵守以下的 《人工充值使用说明》</LABEL></td>
</tr>
<tr>
	<td class="nl"></td>
	<td height="30"><br/><button name="submit" type="submit" width='69' height='26' class="btn_next" /></button><br/><br/></td>
</tr>
<tr>
	<td class="nl">&nbsp;</td>
    <td class='info'>
<font color=red>《人工充值使用说明》</font> - 平台充值步骤: <br/>
&nbsp;&nbsp;1, 在本页上述充值申请表中填写 <font color=blue>“期望充值金额”</font>。 <font color='#007700'>（例：希望充值 888 元，则在此处填写 888 即可）</font><br/>
&nbsp;&nbsp;2, 根据您所持有的银行卡，在本页选择<font color=blue>“充值银行”</font>。 <font color='#007700'>（提示：选择同行充值将更快的的到账）</font><br/>
&nbsp;&nbsp;3, 在了解 《充值使用说明》 后， 勾选 <font color=blue>“我同意并遵守以下的 《充值使用说明》”</font><br/>
&nbsp;&nbsp;4, 点击 <font color=blue>“下一步”</font> 按钮进入确认页面，再次确认您输入的“期望充值金额” 与 “充值银行”。<br/>
&nbsp;&nbsp;5, 点击 <font color=blue>“提交”</font> 按钮后，将为您转向到“充值记录详情”页面。<br/>
&nbsp;&nbsp;6.1, 在“充值记录详情” 页面中，您将看到 <font color=blue>“实际充值金额”</font>。  <font color='#007700'>（例：实际充值金额： 888.05 元 ）</font><br/>
&nbsp;&nbsp;6.2, 同时还将看到收款银行卡开户人姓名、开户支行等转账汇款时必要的信息……<br/>
&nbsp;&nbsp;6.3, 在您转账或汇款时，请严格按照<font color=blue>“实际充值金额”</font>的数字进行填写。<font color='#007700'>（注：请不要忽略小数部分）</font><br />
&nbsp;&nbsp;6.4, 每次充值都将享有<font color="#FF0000">“充值即返手续费”</font>的优惠政策,手续费将以游戏币的形式返还到您的游戏账户中。<br/><br/>
&nbsp;&nbsp;<span style="font-size:14px; font-weight:bold;">如有任何疑问，请查看<font color="#0066CC">帮助中心</font>-><a href="./help_general.php" style="color:#0066CC;" target="_blank">常见问题</a> 里的 <a href="./help_general.php" style="color:#0066CC;" target="_blank">充值说明</a>，或者联系在线客服。</span>	</td>
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
</BODY></HTML>