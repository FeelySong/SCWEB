<?php
@session_start();
error_reporting(0);
require_once 'conn.php';
require_once 'check.php';
$sqla = "SELECT * FROM ssc_member WHERE username='" . $_SESSION["username"] . "'";
$rsa = mysql_query($sqla);
$rowa = mysql_fetch_array($rsa);
if($rowa['cwpwd']==""){
	$_SESSION["cwurl"]="account_autosave.php";
	echo "<script language=javascript>window.location='account_setpwd.php';</script>";
	exit;
}
if($_GET['check']!="952"){
	if($_SESSION["cwflag"]!="ok"){
		$_SESSION["cwurl"]="account_autosave.php";
		echo "<script language=javascript>window.location='account_check.php';</script>";
		exit;
	}
}
$_SESSION["cwflag"]="";
$sqlb = "select * from ssc_bankcard WHERE username='" . $_SESSION["username"] . "' and bankid='3'";
$rsb = mysql_query($sqlb);
$cardnums=mysql_num_rows($rsb);
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

<H1><SPAN class="action-span"><A href="account_drawlist.php?check=914" target='_self'>提现记录</a></SPAN><SPAN class="action-span"><A href="account_draw.php?check=914" target='_self'>平台提现</a></SPAN><SPAN class="action-span zhuangtai"><A href="account_autosave.php?check=952
" target='_self'>自动充值</a></SPAN>
<SPAN class="action-span1"><DIV class='tubiao'></DIV>当前位置: <A href="/" target='_top'><?php echo $webname;?></a>
 - 自动充值 </SPAN><DIV style="clear:both"></DIV></H1>
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
	
}
function showPaymentFee(){
	document.drawform.real_money.value = document.drawform.real_money.value.replace(/\D+/g,'');
	jQuery("#chineseMoney").html( changeMoneyToChinese(document.drawform.real_money.value) );
}
function changbank(obj){
	var id = $(obj).attr("id");
	var $banklist={
<?php
$sqla = "select * from ssc_banks WHERE zt='1' and types='1' order by id asc";
$rsa = mysql_query($sqla);
$total = mysql_num_rows($rsa);
$i=0;
while ($rowa = mysql_fetch_array($rsa)){
?>"bank_<?=$rowa['tid']?>":{"minload":"<?=$rowa['cmin']?>","maxload":"<?=$rowa['cmax']?>"}
<?php 
		if($i!=$total-1){echo ",";}
		$i=$i+1;
}?>};
	$("#loadmin").html($banklist[id]['minload']);
	$("#loadmax").html($banklist[id]['maxload']);
	id = parseInt(id.replace("bank_",""),10);
	if( id == 3 ){
<?php 
if($cardnums=="0"){
?>
		alert("请先绑定您的建行银行卡");
		self.location = "account_banks.php";
		return false;
<?php }?>
			}
	$("tr[id^=msg_]").hide();
	$("#msg_bank_"+id).show();
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
       <span class="tabbar_bian1"></span>
            <span class="tabbar_bianz">
                 自动充值
            </span>
        <span class="tabbar_bian2"></span>
    </div>

<div class="ld" style='width:99%;margin:0px 0px 0px 0px;'>
<table width="100%" class="ct" border="0" cellspacing="0" cellpadding="0">
    <form action="account_autosave2.php" method="post" name="drawform" id="drawform" onsubmit="return checkForm(this)">
        <input type="hidden" name="flag" value="confirm" />
        <tr>
            <td class="nl">充值银行: </td>
            <td style='height:60px;'>
         <?php
        $dd=date("H:i:s");
        $sqla = "select * from ssc_banks WHERE zt='1' and types='1' and ((cztimemin>cztimemax and (cztimemax>'".$dd."' or cztimemin<'".$dd."')) or (cztimemin<cztimemax and cztimemin<'".$dd."' and cztimemax>'".$dd."')) order by sort desc";
        $rsa = mysql_query($sqla);
        while ($rowa = mysql_fetch_array($rsa)){
        ?>    	   	
            <input type="radio" id='bank_<?=$rowa['tid']?>' name="bankinfo" value="<?=$rowa['tid']?>"  onclick="changbank(this)" />&nbsp;<label for='bank_<?=$rowa['tid']?>'><img STYLE='cursor:pointer;' src="images/banks/<?=$rowa['tid']?>.jpg" /></label>&nbsp;&nbsp;&nbsp;
        <?php }?>
                &nbsp;&nbsp;<span style="color:red; display:none"><input type="radio" name="bankinfo" value="" /></span>    </td>
        </tr>
        <?php if($cardnums>0){?>
        <tr id="msg_bank_3" style="display:none;">
                <td class="nl">您要汇款的银行卡</td>
            <td style="font-size:12px; font-weight:bold; color:#FF0000; line-height:20px;">
            <select name="mybank" id="mybank">
                        <?php while ($rowb = mysql_fetch_array($rsb)){?>
                                        <option value="<?=$rowb['id']?>"><?=$rowb['bankname']?> | 银行卡尾号: <?=substr($rowb['cardno'],-4)?> </option>
                <?php }?>
                            </select>&nbsp;&nbsp;
            使用建行充值时，必须使用您选择的建行卡进行汇款，否则不能到账！
            </td>
        </tr>
        <?php }?>
        <tr>
                <td class="nl">充值金额: </td>
            <td style='height:66px;'><input type="text" name="real_money" id="real_money" maxlength="10" onkeyup="showPaymentFee();" />
                &nbsp;&nbsp;<span style="color:red;"></span> ( 单笔充值限额：最低：&nbsp;<font style="color:#FF3300" id="loadmin">&nbsp;</font>&nbsp;元，最高：&nbsp;<font style="color:#FF3300" id="loadmax">&nbsp;</font>&nbsp;元 ) </td>
        </tr>
        <tr>
                <td class="nl">充值金额(大写): </td>
            <td style='height:60px;'>&nbsp;<span id="chineseMoney"></span><input type="hidden" id="hiddenchinese" /></td>
        </tr>
        <tr>
            <td class="nl"></td>
            <td height="30"><br/><button name="submit" type="submit" width='69' height='26' class="btn_next" /></button>
            &nbsp;&nbsp;&nbsp;&nbsp;<br/><br/></td>
        </tr>
        <!--
        <tr>
            <td class="nl"><font color="#FF3300">自动充值提示:</font></td>
            <td STYLE='line-height:23px;padding:5px 0px'>
            充值金额低于<font style="font-size:16px;color:#F30;font-weight:bold;">100</font>&nbsp;不享受“充值即返手续费”的优惠<br/>
            充值后, <font color='#ff0000'>请手动刷新您的余额</font>及查看相关帐变信息,若超过1分钟未上分,请与客服联系<br/>
            选择充值银行, 填写充值金额, 点击 <font color=#0000FF>[下一步]</font> 后, 将有详细文字说明及<font color=red>充值演示</font>	</td>
        </tr>
        -->
    </form>
</table>
</div>
<div id="footer"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td align="center"><table align="center" width="450">
<tr><td align="left">浏览器建议：首选IE 8.0浏览器，其次为火狐浏览器。</td></tr>
</table></td></tr><tr><td></td></tr></table></div>
<br/><br/>
</div></div>
<?php echo $count;?>
</BODY></HTML>