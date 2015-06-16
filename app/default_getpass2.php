<?php
session_start();
error_reporting(0);
require_once 'conn.php';

$name = trim($_POST['username']);
$pwd = trim($_POST['loginpass_source']);
$vcode = trim($_POST['validcode_source']);

if ($name == "" || $pwd == "") {
	echo "<script language=javascript>window.location='default_getpass.php';</script>";
	exit;
}
if ($vcode != $_SESSION['valicode']) {
	echo "<script language=javascript>alert('验证码不正确，请重新输入');window.location='default_getpass.php';</script>";
	exit;
}

$sql = "select * from ssc_member WHERE username='" . $name . "'";
$query = mysql_query($sql);
$dduser = mysql_fetch_array($query);

if(empty($dduser)){
	echo "<script>alert('帐号和资金密码验证失败');window.location='default_getpass.php';</script>"; 
	exit;
}else{
	$pwd2 = $dduser['cwpwd'];
	if($pwd2==md5($pwd)){
//	if($pwd2==$pwd){
	
	}else{
		echo "<script language=javascript>alert('帐号和资金密码验证失败2');window.location='default_getpass.php';</script>";
		exit;
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<TITLE>找回密码</TITLE>
<SCRIPT LANGUAGE='JavaScript'>function ResumeError() {return true;} window.onerror = ResumeError; </SCRIPT> 
<SCRIPT type="text/javascript" src="js/jquery.js"></SCRIPT>
<SCRIPT type="text/javascript" src="js/jquery.md5.js"></SCRIPT>
<LINK href="css/login.css" rel="stylesheet" type="text/css" />
</HEAD>
<BODY>
<script type="text/javascript">
if(top.location != self.location) {top.location=self.location;}
$(document).ready(function(){
	$("input.text").focus(
		function(){
			$("input.text").parent().parent().removeClass("inputGreen");
			$(this).parent().parent().addClass("inputGreen");}
	);
	$("input.text").blur(
		function(){ 
			$(this).parent().parent().removeClass("inputGreen");}
	);
	$("#loginpass_first")[0].value = '';
	$("#loginpass_source")[0].value = '';
	$("#loginpass_first").focus();
}); 
function LoginNow() 
{ 
    var loginpass = $("#loginpass_first").val();
    var typepw = $("#loginpass_source").val();
    if( loginpass == '' ){
        alert('请填写 新的登录密码');
        return false;
    }
    if( loginpass != typepw ){
		$("#loginpass_first")[0].value = '';
		$("#loginpass_source")[0].value = '';
		$("#loginpass_first").focus();
        alert('两次输入的密码不一致，请重新确认');
        return false;
    }
    document.forms['login'].submit();     
}
</script>
<div id="allbox">
    <div id="header">
       <div id="header_content">
          <div id="header_logo"></div>
          <div id="header_right">
			  <div id="header_tips">欢迎使用<?php echo $webname;?>终端..</div>
			  <div id="header_menu" style='margin-left:400px;'>

				<ul id="menu">
		<li class="link1"><a href="./">登录系统</a></li>
				</ul>
			   </div>
           </div>
         </div>  	
     </div>

     <div id="top_line"></div>

		<div id="reg_content">
			<div id="content_reg_box_top"></div>
			<div id="content_reg_box_center">
				<div id="maintitle">找回登录密码</div>	
				<div id="maincontent">
        	<div style="width:684px; margin:auto;">
					<form name='login' method="post" action="default_getpass3.php" onSubmit="javascript:LoginNow(); return false;">
					<input type="hidden" name="username" value="<?=$name?>" />
            		<div style="width:100%;text-align:center;">
                    	<font color="#FF0000"></font>
                    </div>
                    <div class="content_reg_line"><span style="font-size:14px;"><strong><font color="#FF0000">第二步：</font>填写新的登录密码，然后确认。</strong></span></div>
                    <div class="content_reg_line">
                    	<div class="form_title">新的登录密码：</div>
                        <div class="form_word">
						<span class="inputBox input180"><cite><input type="password" name="loginpass_first" id="loginpass_first" maxlength="32" value="" class="text"/></cite></span>
                        <span style="float:left; margin-left:120px;">由6-16个字母和数字组成,必须包含数字和字母,不允许连续三位相同,不能和资金密码相同</span>
						</div>
                    </div>

                    <div class="content_reg_line">
                    	<div class="form_title">确认登录密码：</div>
                        <div class="form_word"><span class="inputBox input180"><cite><input type="password" name="loginpass_source" id="loginpass_source" maxlength="20" value="" class="text"/></cite></span></div>
                    </div>

                    <div style="border-top:1px dotted #ccc; width:90%; margin:5px auto; height:1px; font-size:0; overflow:hidden;margin-bottom:20px;"></div>

					<div style="height:30px; text-align:center;">
                    <button name="submit" type="submit" width='69' height='26' class="btn_submit" /></button>
                    </div>
					</form>
            </div>
        </div>&nbsp;
	</div>
	<div id="content_reg_box_bottom"></div>
</div>
</div>
</BODY>
</HTML>