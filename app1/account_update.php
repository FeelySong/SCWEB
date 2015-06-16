<?php
session_start();
error_reporting(0);
require_once 'conn.php';
require_once 'check.php';

$flag=$_REQUEST['flag'];

$sql = "select * from ssc_member where username='".$_SESSION["username"] ."'";
$rs = mysql_query($sql);
$row = mysql_fetch_array($rs);

if($flag=="changepass"){
	$changetype=$_REQUEST['changetype'];
	if($changetype=="loginpass"){
		if($_REQUEST['oldpass']!="" && $_REQUEST['newpass']!="" && $_REQUEST['newpass']==$_REQUEST['confirm_newpass']){
			if(md5($_REQUEST['oldpass'])==$row['password']){
				$sql="update ssc_member set password='".md5($_REQUEST['newpass'])."' where username ='".$_SESSION["username"] ."'";
				$exe=mysql_query($sql) or  die("数据库修改出错!!!!".mysql_error());
				amend("修改登录密码");
				$_SESSION["backtitle"]="登录密码修改成功";
				$_SESSION["backurl"]="account_update.php";
				$_SESSION["backzt"]="successed";				
				$_SESSION["backname"]="返回上一页";
				echo "<script language=javascript>window.location='sysmessage.php';</script>";
				exit;
			}else{
				$_SESSION["backtitle"]="原始密码错误";
				$_SESSION["backurl"]="account_update.php";
				$_SESSION["backzt"]="failed";				
				$_SESSION["backname"]="返回上一页";
				echo "<script language=javascript>window.location='sysmessage.php';</script>";
				exit;
			}
		}
	}else if($changetype=="secpass"){
		if($row['cwpwd']==""){
			if($_REQUEST['newpass']!="" && $_REQUEST['newpass']==$_REQUEST['confirm_newpass']){
				$sql="update ssc_member set cwpwd='".md5($_REQUEST['newpass'])."' where username ='".$_SESSION["username"] ."'";
				$exe=mysql_query($sql) or  die("数据库修改出错!!!!".mysql_error());
				amend("设置资金密码");
				$_SESSION["backtitle"]="资金密码修改成功";
				$_SESSION["backurl"]="account_update.php";
				$_SESSION["backzt"]="successed";				
				$_SESSION["backname"]="返回上一页";
				echo "<script language=javascript>window.location='sysmessage.php';</script>";
				exit;
			}
		}else{
			if($_REQUEST['oldpass']!="" && $_REQUEST['newpass']!="" && $_REQUEST['newpass']==$_REQUEST['confirm_newpass']){
				if(md5($_REQUEST['oldpass'])==$row['cwpwd']){
					$sql="update ssc_member set cwpwd='".md5($_REQUEST['newpass'])."' where username ='".$_SESSION["username"] ."'";
					$exe=mysql_query($sql) or  die("数据库修改出错!!!!".mysql_error());
					amend("修改资金密码");
					$_SESSION["backtitle"]="资金密码修改成功";
					$_SESSION["backurl"]="account_update.php";
					$_SESSION["backzt"]="successed";				
					$_SESSION["backname"]="返回上一页";
					echo "<script language=javascript>window.location='sysmessage.php';</script>";
					exit;
				}else{
					$_SESSION["backtitle"]="资金密码错误";
					$_SESSION["backurl"]="account_update.php";
					$_SESSION["backzt"]="failed";				
					$_SESSION["backname"]="返回上一页";
					echo "<script language=javascript>window.location='sysmessage.php';</script>";
					exit;
				}
			}
		}
	}else if($changetype=="loginmsg"){
//		if($_REQUEST['logmsg']!=""){
			if(Get_member(question)==""){
				amend("设置登录问候语");
			}else{
				amend("修改登录问候语");
			}

			$sql="update ssc_member set question='".$_REQUEST['logmsg']."' where username ='".$_SESSION["username"] ."'";
			$exe=mysql_query($sql) or  die("数据库修改出错!!!!".mysql_error());
			$_SESSION["backtitle"]="登陆问候语修改成功";
			$_SESSION["backurl"]="account_update.php";
			$_SESSION["backzt"]="successed";				
			$_SESSION["backname"]="返回上一页";
			echo "<script language=javascript>window.location='sysmessage.php';</script>";
			exit;
//		}
	}
	

}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD><TITLE><?php echo $webname;?>  - 修改密码</TITLE>
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
<H1>
<SPAN class="action-span zhuangtai"><A href="account_update.php" target='_self'>修改密码</a></SPAN>
<SPAN class="action-span"><A href="account_banks.php" target='_self'>我的银行卡</a></SPAN>
<SPAN class="action-span"><A href="users_message.php" target='_self'>我的消息</a></SPAN>
<SPAN class="action-span"><A href="users_info.php" target='_self'>奖金详情</a></SPAN>
<SPAN class="action-span1"><DIV class='icons_mb1'></DIV>当前位置: <A href="/" target='_top'><?php echo $webname;?></a>
 - 修改密码 </SPAN><DIV style="clear:both"></DIV></H1>
 
<link href="js/keyboard/css/jquery-ui.css" rel="stylesheet">
<link href="js/keyboard/css/keyboard.css" rel="stylesheet">
<script src="js/keyboard/jquery.min.js"></script>
<script src="js/keyboard/jquery-ui.min.js"></script>
<script src="js/keyboard/jquery.keyboard.js"></script>
<script src="js/keyboard/keyboard.js"></script>
<script> 
	$(function(){
		getKeyBoard($('#oldpass,#newpass,#confirm_newpass'));
	});
</script>
<script type="text/javascript">
function checkform(obj)
{
	if( !validateUserPss(obj.newpass.value) ){
		alert("密码不符合规则，请重新输入");
		obj.newpass.focus();
		return false;
	}
	if( obj.newpass.value != obj.confirm_newpass.value ){
		alert("两次输入密码不相同");
		obj.newpass.focus();
		return false;
	}
	if( obj.oldpass == "" ){
		alert("请输入原始密码");
		obj.oldpass.focus();
		return false;
	}
	return true;
}
</script>
<div class="ld">
<form action="" method="post" name="changepass" onsubmit="return checkform(this)">
<table class="ct" border="0" cellspacing="0" cellpadding="0">
<tr><th colspan="2" align='left'>&nbsp; A. 修改登陆密码</th></tr>
<tr><td class="nl">输入旧登陆密码: </td>
<td><input type="password" name="oldpass" id="oldpass"/></td></tr>
<tr><td class="nl">输入新登陆密码: </td>
<td><input type="password" name="newpass" id="newpass" />由字母和数字组成6-16个字符；且必须包含数字和字母，不允许连续三位相同，不能和资金密码相同</td></tr>
<tr><td class="nl">确认新登陆密码: </td>
<td><input type="password" name="confirm_newpass" id="confirm_newpass" /></td></tr><tr><td></td><td>
<button name="submit" type="submit" width='69' height='26' class="btn_submit" /></button>
<input type="hidden" name="check" value="" />
<input type="hidden" name="flag" value="changepass" />
<input type="hidden" name="changetype" value="loginpass" />
</td></tr></table></form></div><br>
<div class="ld" id="listDiv">
<form action="" method="post" name="changepass" onsubmit="return checkform(this)">
<table class="ct" border="0" cellspacing="0" cellpadding="0"><tr><th colspan="2" align='left'>&nbsp; B. 修改资金密码</th></tr>
<?php if($row["cwpwd"]!=""){?><tr><td class="nl">输入旧资金密码: </td><td><input type="password" name="oldpass" id="oldpass" /></td></tr><?php }?>
<tr><td class="nl">输入新资金密码: </td>
<td><input type="password" name="newpass" id="newpass"/>由字母和数字组成6-16个字符；且必须包含数字和字母，不允许连续三位相同，不能和登陆密码相同
</td></tr>
<tr><td class="nl">确认新资金密码: </td><td>
<input type="password" name="confirm_newpass" id="confirm_newpass"/></td></tr><tr><td></td><td>
<button name="submit" type="submit" width='69' height='26' class="btn_submit" /></button>
<input type="hidden" name="check" value="" />
<input type="hidden" name="flag" value="changepass" />
<input type="hidden" name="changetype" value="secpass" /></td></tr></table></form></div><br/>

<div class="ld" id="listDiv">
<form action="" method="post" name="changepass">
<table class="ct" border="0" cellspacing="0" cellpadding="0"><tr><th colspan="2" align='left'>&nbsp; C. 修改登录问候语</th></tr>
<tr><td class="nl">登陆问候语: </td>
<td><input type="text" maxlength='50' style='color:#f33;height:25px;line-height:25px;width:360px;padding-left:3px;' name="logmsg" value='<?=$row["question"]?>'/>
<br/><br/>在登录界面,输入用户名后,您会看到此处设置的登录问候语,避免仿冒钓鱼网站<br/><br/>
</td></tr>
<tr><td></td><td>
<button name="submit" type="submit" width='69' height='26' class="btn_submit" /></button>
<input type="hidden" name="check" value="" />
<input type="hidden" name="flag" value="changepass" />
<input type="hidden" name="changetype" value="loginmsg" />
</td></tr></table></form></div>
<div id="footer"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td align="center"><table align="center" width="450">
<tr><td align="left">浏览器建议：首选IE 8.0浏览器，其次为火狐浏览器。</td></tr>
</table></td></tr><tr><td></td></tr></table></div>
<br/><br/>
</div></div>
<?php echo $count?>
</BODY></HTML>