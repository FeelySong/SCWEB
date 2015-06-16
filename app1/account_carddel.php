<?php
session_start();
error_reporting(0);
require_once 'conn.php';
require_once 'check.php';

$id = trim($_GET['id']);

if(Get_member(cardlock)=="1"){
	$_SESSION["backtitle"]="您的银行卡资料已锁定";
	$_SESSION["backurl"]="account_banks.php?check=114";
	$_SESSION["backzt"]="failed";
	$_SESSION["backname"]="我的银行卡";
	echo "<script language=javascript>window.location='sysmessage.php';</script>";
	exit;
}
	
	if($_SESSION["cardflag"]!="ok"){
		$_SESSION["cardurl"]="account_carddel.php?id=".$id;
		echo "<script language=javascript>window.location='account_confirm.php?id=".$id."';</script>";
		exit;
	}
	$_SESSION["cardflag"]="";

if($_POST['isverify']=="yes"){
	$_SESSION["cardflag"]="";
	$sqlb = "select * from ssc_member WHERE username='" . $_SESSION["username"] . "'";
	$rsb = mysql_query($sqlb);
	$rowb = mysql_fetch_array($rsb);
	
	if(md5($_POST['spwd'])==$rowb['cwpwd']){
		$sqlb = "delete from ssc_bankcard WHERE id='" . $_POST['delid'] . "'";
		$rsb = mysql_query($sqlb);
		$_SESSION["backtitle"]="操作成功";
		$_SESSION["backurl"]="account_banks.php?check=114";
		$_SESSION["backzt"]="successed";
		$_SESSION["backname"]="我的银行卡";
		echo "<script language=javascript>window.location='sysmessage.php';</script>";
		exit;
	}else{
		$_SESSION["backtitle"]="资金密码错误";
		$_SESSION["backurl"]="account_banks.php?check=114";
		$_SESSION["backzt"]="failed";
		$_SESSION["backname"]="我的银行卡";
		echo "<script language=javascript>window.location='sysmessage.php';</script>";
		exit;
	}
}

$sqla = "select * from ssc_bankcard WHERE id='" . $id . "' and username='" . $_SESSION["username"] . "'";
$rsa = mysql_query($sqla);
$rowa = mysql_fetch_array($rsa);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD><TITLE><?php echo $webname;?>  - 解除绑定银行卡</TITLE>
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

<H1><SPAN class="action-span"><A href="account_banks.php?check=114" target='_self'>我的银行卡</a></SPAN>
<SPAN class="action-span1"><DIV class='icons_mb1'></DIV>当前位置: <A href="/" target='_top'><?php echo $webname;?></a>
 - 解除绑定银行卡 </SPAN><DIV style="clear:both"></DIV></H1>
<div class="ld"><table class='st' border="0" cellspacing="0" cellpadding="0"><tr><td width='100%'>
<font color='#ff0000'>使用提示: </font>请仔细确认以下信息后, 点击 <font color=#ff0000>"解除绑定"</font> 按钮.<br/>
</td></tr></table></div><div style="clear:both; height:10px;"></div>

<div class="ld">
<table class="ct" border="0" cellspacing="0" cellpadding="0">
<form action="account_carddel2.php" method="post" name="addform" onsubmit="return checkform(this)">
<input type="hidden" name="delid" value="<?=$id?>" />
<input type="hidden" name="isverify" value="yes" />
<!--<tr><td class="nl">别名:</td><td>张三</td></tr>-->
<tr><td class="nl">开户银行:</td><td><?=Get_bank($rowa['bankid'])?></td></tr>
<tr><td class="nl">银行账号:</td><td>***************<?=substr($rowa['cardno'],-4)?></font></td></tr>
<tr><td class="nl">绑定时间</td><td><?=$rowa['adddate']?></td></tr>
<tr><td class="nl">资金密码:</td><td><input type="password" name="spwd" maxlength="20" style='width:160px;'/></font></td></tr>
<tr><td></td><td><br/><input type="submit" name="submit" value="解除绑定" class="button" /><br/><br/></td></tr>
</form></table></div>
<div id="footer"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td align="center"><table align="center" width="450">
<tr><td align="left">浏览器建议：首选IE 8.0浏览器，其次为火狐浏览器。</td></tr>
</table></td></tr><tr><td></td></tr></table></div>
<br/><br/>
</div></div>
<?php echo $count?>
</BODY></HTML>