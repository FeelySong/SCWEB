<?php
error_reporting(0);
require_once 'conn.php';
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
	$("#username")[0].value = '';
	$("#validcode_source")[0].value = '';
	$("#loginpass_source")[0].value = '';
	$("#username").focus();
}); 
function refreshimg(){
document.getElementById("vcsImg").src="ValiCode_new.php?"+  new Date().getTime();
}
function LoginNow() 
{ 
    var loginuser = $("#username").val();
    var typepw = $("#loginpass_source").val();
    if (loginuser == ''){
        alert('请填写 通行证账号');
        return false;
    }
    if  (typepw == '') {
        alert('请填写 资金密码');
        return false;
    }
    if (randnum == '') {
        alert('请填写 图片验证码');
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
					<form name='login' method="post" action="default_getpass2.php" onSubmit="javascript:LoginNow(); return false;"">
            		<div style="width:100%;text-align:center;">
                    	<font color="#FF0000"></font>
                    </div>
                    <div class="content_reg_line"><span style="font-size:14px;"><strong><font color="#FF0000">第一步：</font>验证通行证账号和资金密码。</strong></span></div>
                    <div class="content_reg_line">
                    	<div class="form_title">通行证账号：</div>
                        <div class="form_word">
						<span class="inputBox input180"><cite><input type="text" name="username" id="username" maxlength="32" value="" class="text"/></cite></span>
						</div>
                    </div>

                    <div class="content_reg_line">
                    	<div class="form_title">资金密码：</div>
                        <div class="form_word"><span class="inputBox input180"><cite><input type="password" name="loginpass_source" id="loginpass_source" maxlength="20" value="" class="text"/></cite></span></div>
                    </div>

					<div class="content_reg_line">
                    	<div class="form_title">验证码：</div>
                        <div class="form_word"><span class="inputBox input60"><cite><input type="text" name="validcode_source" id="validcode_source" maxlength="5" value="" class="text"/></cite></span></div> 
						<img id="vcsImg" src="ValiCode_New.php"  name="validate" align="absbottom" style="margin-left:6px;cursor:pointer; border: 1px solid #999" onClick="refreshimg()" alt="点击图片更新验证码">
                    </div>

                    <div style="border-top:1px dotted #ccc; width:90%; margin:5px auto; height:1px; font-size:0; overflow:hidden;margin-bottom:20px;"></div>

					<div style="height:30px; text-align:center;">
                    <button name="submit" type="submit" width='69' height='26' class="btn_next" /></button>
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