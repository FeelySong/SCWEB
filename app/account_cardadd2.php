<?php
session_start();
error_reporting(0);
require_once 'conn.php';
require_once 'check.php';

$flag = trim($_POST['flag']);
if($flag=="confirm"){
	$sql = "insert into ssc_bankcard set uid='" . $_SESSION["sess_uid"] . "', username='" . $_SESSION["username"] . "', realname='" . trim($_POST['realname']) . "', bankid='" . trim($_POST['bank']) . "', bankname='" .Get_bank($_POST['bank']) . "', province='" . trim($_POST['province']) . "', city='" . trim($_POST['city']) . "', bankbranch='" . trim($_POST['branch']) . "', cardno='" . trim($_POST['cardno']) . "', adddate='" . date("Y-m-d H:i:s") . "'";
	$exe = mysql_query($sql);
	amend("绑定银行卡".$_POST['cardno']);
	$_SESSION["backtitle"]="操作成功";
	$_SESSION["backurl"]="account_banks.php?check=114";
	$_SESSION["backzt"]="successed";
	$_SESSION["backname"]="我的银行卡";
	echo "<script language=javascript>window.location='sysmessage.php';</script>";
	exit;

}else{
	$bank = trim($_POST['bank']);
	$province = trim($_POST['province']);
	$city = trim($_POST['city']);
	$branch = trim($_POST['branch']);
	$realname = trim($_POST['realname']);
	$cardno = trim($_POST['cardno']);
	$cardno_again = trim($_POST['cardno_again']);

	if($cardno != $cardno_again){
		$_SESSION["backtitle"]="操作失败，卡号不一致";
		$_SESSION["backurl"]="account_cardadd.php?check=114";
		$_SESSION["backzt"]="failed";
		$_SESSION["backname"]="新增银行卡";
		echo "<script language=javascript>window.location='sysmessage.php';</script>";
		exit;
	}
	$sqla = "select * from ssc_bankcard WHERE username='" . $_SESSION["username"] . "'";
	$rsa = mysql_query($sqla);
	$rowa = mysql_fetch_array($rsa);
	if(empty($rowa)){
	}else{
		if($rowa['realname']!=$realname){
			$_SESSION["backtitle"]="操作失败，开户人姓名不一致";
			$_SESSION["backurl"]="account_cardadd.php?check=114";
			$_SESSION["backzt"]="failed";
			$_SESSION["backname"]="新增银行卡";
			echo "<script language=javascript>window.location='sysmessage.php';</script>";
			exit;
		}
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD><TITLE><?php echo $webname;?>  - 增加银行卡 (确认页)</TITLE>
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

<H1><SPAN class="action-span"><A href="account_banks.php" target='_self'>我的银行卡</a></SPAN>
<SPAN class="action-span1"><DIV class='icons_mb1'></DIV>当前位置: <A href="/" target='_top'><?php echo $webname;?></a>
 - 增加银行卡 (确认页) </SPAN><DIV style="clear:both"></DIV></H1>
<div class="ld"><table class='st' border="0" cellspacing="0" cellpadding="0"><tr><td width='100%'>
<font color='#ff0000'>使用提示: </font>请仔细确认以下信息后, 点击 <font color=#ff0000>"立即绑定"</font> 按钮.<br/>
</td></tr></table></div><div style="clear:both; height:10px;"></div>

<div class="ld">
<table class="ct" border="0" cellspacing="0" cellpadding="0">
<form action="" method="post" name="addform" onsubmit="return checkform(this)">
<input type="hidden" name="flag" value="confirm" />
<input type="hidden" name="nickname"	value="<?=$realname?>" />
<input type="hidden" name="bank"	value="<?=$bank?>" />
<input type="hidden" name="province"	value="<?=$province?>" />
<input type="hidden" name="city"	value="<?=$city?>" />
<input type="hidden" name="branch"	value="<?=$branch?>" />
<input type="hidden" name="realname" value="<?=$realname?>" />
<input type="hidden" name="cardno"	value="<?=$cardno?>" />
<input type="hidden" name="isverify" value="yes" />
<!--<tr><td class="nl">别名:</td><td>王华</td></tr>-->
<tr><td class="nl">开户银行:</td><td><?=Get_bank($bank)?></td></tr>
<?php if($bank==1 || $bank==2 || $bank==3){?>
<tr><td class="nl">开户银行省份:</td><td><?=Get_province($province)?></td></tr>
<tr><td class="nl">开户银行城市:</td><td><?=Get_city($city)?></td></tr>
<?php }?>
<?php if($bank==2){?>
<tr><td class="nl">支行名称:</td><td><?=$branch?></td></tr>
<?php }?>
<tr><td class="nl">开户人姓名:</td><td><?=$realname?></td></tr>
<tr><td class="nl"><?php if($bank==1 || $bank==2 || $bank==3){echo "银行";}else{echo "财付通";}?>账号:</td>
<td><font style='font-family:Verdana,Arial,Tahoma;line-height:36px;height:36px;font-size:26px;background-color:#000;color:#fC0;padding:0px 8px 0px 8px;'><?=$cardno?></font></td></tr>
<tr><td></td><td><br/><input type="submit" name="submit" value="立即绑定" class="button" />　<input type="button" value="返回" onclick="history.back();" class="button" /><br/><br/></td></tr>
</form></table></div>

<div id="footer"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td align="center"><table align="center" width="450">
<tr><td align="left">浏览器建议：首选IE 8.0浏览器，其次为火狐浏览器。</td></tr>
</table></td></tr><tr><td></td></tr></table></div>
<br/><br/>
</div></div>
<?php echo $count;?>
</BODY></HTML>