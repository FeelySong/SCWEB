<?php
session_start();
error_reporting(0);
require_once 'conn.php';

$name = trim($_POST['username']);
$vcode = trim($_POST['validcode_source']);

if ($name == "") {
	echo "<script language=javascript>window.location='./';</script>";
	exit;
}
if ($vcode != $_SESSION['valicode']) {
	echo "<script language=javascript>alert('验证码不正确，请重新输入');window.location='./';</script>";
	exit;
}

$sql = "select * from ssc_member WHERE username='" . $name . "'";
$query = mysql_query($sql);
$dduser = mysql_fetch_array($query);

if(empty($dduser)){
	echo "<script>window.location='".$gourl."';</script>"; 
	exit;
}else{
	$question = $dduser['question'];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<TITLE>用户登陆</TITLE>
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
	$("#loginpass_source").focus();
});
function LoginNow() 
{ 
    var typepw = $("#loginpass_source").val();
    if( typepw == '' ){
        alert('请填写 通行证密码');
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
			  <div id="header_tips"><?php echo $webname;?>欢迎您</div>
			  <div id="header_menu" style='margin-left:400px;'></div>
           </div>
         </div>  	
     </div>
     <div id="top_line"></div>
		<div id="reg_content">
			<div id="content_reg_box_top"></div>
			<div id="content_reg_box_center">
				<div id="maintitle">通行证登录</div>	
				<div id="maincontent">	
        	<div style="width:500px; margin:auto;">
					<form name='login' method="post" action="login2.php" onSubmit="javascript:LoginNow(); return false;">
            		<div style="width:100%;text-align:center;">
                    	<font color="#FF0000"></font>
                    </div>
                    <div class="content_reg_line">
                    	<div class="form_title">通行证账号：</div>
                        <div class="form_word" style='font-size:14px;'><?=$name?></div>
						<input type="hidden" name="username" id="username" value="<?=$name?>"/>
                    </div>
					<div class="content_reg_line">
                    	<div class="form_title">问候语：</div>
                        <div class="form_word" style='font-size:14px;color:#f33;height:25px;line-height:25px;width:360px;padding-left:3px;'>
						<?php if($question==""){echo "<font style='color:#333;'>您还没有设置问候语，为了您的安全，请尽快设置！</font>";}else{echo $question;}?><br /> 
                        <span style="font-size:12px;color:#999;">如果问候语与您预设不一致，则为仿冒！不要输入密码！</span>
                        <br />&nbsp;
                        </div>
                    </div>
                    <div class="content_reg_line">
                    	<div class="form_title">登陆密码：</div>
                        <div class="form_word"><span class="inputBox input180"><cite><input type="password" name="loginpass_source" id="loginpass_source" maxlength="20" value="" class="text"/></cite></span></div>
                    </div>
                    <div style="border-top:1px dotted #ccc; width:90%; margin:5px auto; height:1px; font-size:0; overflow:hidden;margin-bottom:20px;"></div>
					<div style="height:30px; text-align:center;">
                    <input name="Submit" type="image" id="Submit" src="images/comm/t.gif" class='inputSubmit' title="点击开始游戏" width="104" height="30"/>
                    &nbsp;&nbsp;<a href="default_getpass.php">忘记密码？</a></div>
					<div style="padding-top:32px; margin:2px 0px; text-align:center;">小提示: 使用 <font color=red>IE (Internet Explorer ) 8.0</font> 浏览器可达到最佳使用效果 </div>
					</form>
            </div>
        </div>&nbsp;
	</div>
	<div id="content_reg_box_bottom"></div>
</div>
</div>
</BODY>
</HTML>