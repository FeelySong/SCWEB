<?php
session_start();
error_reporting(0);
require_once 'conn.php';
require_once 'check.php';

$sqla = "select * from ssc_bankcard WHERE  username='" . $_SESSION["username"] . "'";
$rsa = mysql_query($sqla);
$cardnums=mysql_num_rows($rsa);
if($cardnums==0){
	$_SESSION["backtitle"]="您暂时还没有绑定任何银行卡，请先绑定银行卡";
	$_SESSION["backurl"]="account_banks.php?check=114";
	$_SESSION["backzt"]="failed";
	$_SESSION["backname"]="我的银行卡";
	echo "<script language=javascript>window.location='sysmessage.php';</script>";
	exit;
}

if($_POST['flag']=="lock"){
	$sqlb = "select * from ssc_member WHERE username='" . $_SESSION["username"] . "'";
	$rsb = mysql_query($sqlb);
	$rowb = mysql_fetch_array($rsb);
	
	if(md5($_POST['spwd'])==$rowb['cwpwd']){
		$sqlb = "update ssc_member set cardlock='1' WHERE username='" . $_SESSION["username"] . "'";
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


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD><TITLE><?php echo $webname;?>  - 锁定银行卡</TITLE>
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
<SCRIPT LANGUAGE='JavaScript'>function ResumeError() {return true;} window.onerror = ResumeError; </SCRIPT>
 <link href="js/keyboard/css/jquery-ui.css" rel="stylesheet">
<link href="js/keyboard/css/keyboard.css" rel="stylesheet">
<script src="js/keyboard/jquery.min.js"></script>
<script src="js/keyboard/jquery-ui.min.js"></script>
<script src="js/keyboard/jquery.keyboard.js"></script>
<script src="js/keyboard/keyboard.js"></script> 
</HEAD>
<BODY STYLE="background:#FFF url('images/v1/main_bg_0001.jpg') 0px -490px repeat-x; padding:10px;">
 

<DIV ID='main_box'>
<div class="box l"></div>
<div class="box c"></div>
<div class="box r"></div>
<div class="box m">

<H1><SPAN class="action-span"><A href="account_banks.php?check=114" target='_self'>我的银行卡</a></SPAN>
<SPAN class="action-span1"><DIV class='icons_mb1'></DIV>当前位置: <A href="/" target='_top'><?php echo $webname;?></a>
 - 锁定银行卡 </SPAN><DIV style="clear:both"></DIV></H1>
<script>
function checkform()
{
	return confirm("警告：银行卡锁定后，将无法再增加、删除银行卡。\n您是否确定要锁定您账户的银行卡？");
}
</script>

<div class="ld"><table class='st' border="0" cellspacing="0" cellpadding="0"><tr><td width='100%'>
<font color='#0066FF'>温馨提示:</font> <font color="#FF0000"  style="font-weight:bold;">银行卡锁定以后，不能增加新的银行卡绑定，同时也不能解绑已绑定的银行卡</font><br/>
</td></tr></table></div><div style="clear:both; height:10px;"></div>

<div class="ld">
<table class="ct" border="0" cellspacing="0" cellpadding="0">
<form action="" method="post" name="addform" onsubmit="return checkform()">
<input type="hidden" name="flag" value="lock" />
<?php
	while ($rowa = mysql_fetch_array($rsa)){
?>
<tr><td class="nl"><?=Get_bank($rowa['bankid'])?>:</td><td>***************<?=substr($rowa['cardno'],-4)?></td></tr>
<?php }?>
<tr><td class="nl">资金密码:</td><td><input type="password" name="spwd" id="spwd" maxlength="20" style='width:160px;'/></font></td></tr>
<tr><td class="nl">温馨提示:</td><td style='line-height:24px;color:#693'>银行卡锁定，可以一定程度增强您的账户安全。<br/>
例：账户被他人盗用后，由于此功能的限制，您账户的资金不会被他人提现。<br/>
与此同时，客服<font color=red>不提供</font>账户银行卡解除锁定功能，所以：<font color=red>锁定前请自行斟酌</font>。</td></tr>
<tr><td></td><td><br/><input type="submit" name="submit" value=" 立即锁定 " class="button" /><br/><br/></td></tr>
</form></table></div>
<div id="footer"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td align="center"><table align="center" width="450">
<tr><td align="left">浏览器建议：首选IE 8.0浏览器，其次为火狐浏览器。</td></tr>
</table></td></tr><tr><td></td></tr></table></div>
<br/><br/>
</div></div>
<script>
$(function(){
	getKeyBoard($('#spwd'));
});
</script>
<?php echo $count?>
</BODY></HTML>