<?php
session_start();
error_reporting(0);
require_once 'conn.php';
require_once 'check.php';

$flag = trim($_POST['flag']);
if($flag=="check"){
	$sql = "select * from ssc_bankcard WHERE id='" . $_POST["verifyid"] . "'";
	$rs = mysql_query($sql);
	$row = mysql_fetch_array($rs);
	
//	echo $sql;
//	echo $_POST['cardno'].$_POST['realname'];
//	echo $row['cardno'].$row['realname'];
	if($_POST['cardno']==$row['cardno'] && $_POST['realname']==$row['realname']){
		$_SESSION["cardflag"]="ok";
		echo "<script language=javascript>window.location='".$_SESSION["cardurl"]."';</script>";
		exit;
	}else{
		$_SESSION["cardflag"]="failed";
		$_SESSION["backtitle"]="旧卡信息验证失败，请仔细检查";
		$_SESSION["backurl"]="account_banks.php?check=114";
		$_SESSION["backzt"]="failed";
		$_SESSION["backname"]="我的银行卡";
		echo "<script language=javascript>window.location='sysmessage.php';</script>";
		exit;
	}
}

$bid=$_GET["id"];
if($bid==""){
$sqla = "select * from ssc_bankcard WHERE username='" . $_SESSION["username"] . "'";
}else{
$sqla = "select * from ssc_bankcard WHERE id='" . $bid . "' and username='" . $_SESSION["username"] . "'";
}
$rsa = mysql_query($sqla);
$rowa = mysql_fetch_array($rsa);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD><TITLE><?php echo $webname;?>  - 验证银行卡信息</TITLE>
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
 - 验证银行卡信息 </SPAN><DIV style="clear:both"></DIV></H1>
<link href="js/keyboard/css/jquery-ui.css" rel="stylesheet">
<link href="js/keyboard/css/keyboard.css" rel="stylesheet">
<script src="js/keyboard/jquery.min.js"></script>
<script src="js/keyboard/jquery-ui.min.js"></script>
<script src="js/keyboard/jquery.keyboard.js"></script>
<script src="js/keyboard/keyboard.js"></script>
<script> 
        $(function(){
                getNumKeyBoard($('#cardno'));
        });
</script>
<script type="text/javascript">
jQuery("document").ready( function(){
	
});
function exceptSpecial(obj){
	obj.value = obj.value.replace(/[\<\>\~\!\@\#\$\%\^\&\*\-\+\=\|\\\'\?\,\.\/\[\]\{}\(\)\"]{1,}/,'');
}
function checkform(obj){
  var repSpecial = /[\<\>\~\!\@\#\$\%\^\&\*\-\+\=\|\\\'\"\?\,\.\/\[\]\{}\(\)]{1,}/;
  var re = /^(.){1,10}$/;
  if( !re.test(obj.realname.value) || repSpecial.test(obj.realname.value) || obj.realname == ""){
    alert('"开户人姓名" 不符合规则, 请重新输入');
	obj.realname.focus();
	return false;
  }
<?php if($rowa['bankname']='财付通'){?>
	return true;
<?php } ?>
<?php if($rowa['bankid']==4){ ?>
    var re = /^\d{5,14}$/;
<?php }else{ ?>
    var re = /^\d{16}$|^\d{19}$/;
<?php } ?>
	  var cardno = document.getElementById("cardno");
	  if (!re.test(cardno.value)){
		alert('"银行账号" 不符合规则, 请重新输入');
		cardno.focus();
		return false;
	  }
  }
</script>


<div class="ld"><table class='st' border="0" cellspacing="0" cellpadding="0"><tr><td width='100%'>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color='#0066FF'>使用提示: </font><font color="#FF0000">请输入您已绑定银行卡的相关信息进行安全验证</font>
</td></tr></table></div><div style="clear:both; height:10px;"></div>


<div class="ld">
<table class="ct" border="0" cellspacing="0" cellpadding="0">
<form action="" method="post" name="addform" id='addform' onsubmit="return checkform(this)">
<input type="hidden" name="verifyid" value="<?=$rowa['id']?>" />
<input type="hidden" name="flag" value="check" />
  <tr>
  	<td class="nl">已绑定的<font color="#0066FF"><?=Get_bank($rowa['bankid'])?></font>卡:</td>
    <td>***************<?=substr($rowa['cardno'],-4)?></td>
  </tr>
  <tr>
	<td class="nl"><font color="#FF0000">*</font>&nbsp;银行账号:</td>
	<td>
    <input maxlength="19" type="text" name="cardno" id="cardno" style="width:220px;" />&nbsp;&nbsp;&nbsp;<span id="realname_msg">( 请输入对应绑定卡的银行卡号 )</span>
    </td>
   </tr>
  <tr>
  	<td class="nl"><font color="#FF0000">*</font>&nbsp;开户人姓名:</td>
    <td>
		<input type="text" name="realname" maxlength="10" id="realname" onkeyup="exceptSpecial(this);" onchange="exceptSpecial(this);" style='width:220px;' />&nbsp;&nbsp;&nbsp;<span id="realname_msg">( 请输入对应绑定卡的开户名 )</span>
    </td>
  </tr>
  <tr><td>&nbsp;</td><td><br/><button name="submit" type="submit" width='69' height='26' class="btn_next" /></button><br/><br/></td></tr>
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