<?php
session_start();
error_reporting(0);
require_once 'conn.php';
if($webzt!='1'){
	echo "<script>window.location='".$gourl."';</script>"; 
	exit;
}

if($_SESSION["sess_uid"]!="" && $_SESSION["username"] !="" && $_SESSION["valid"]!=""){
	$result = mysql_query("select * from ssc_online where valid='".$_SESSION["valid"]."' and username='".$_SESSION["username"] ."'");  
	$total = mysql_num_rows($result);
	if($total!=0){
		echo "<script language=javascript>window.location='default_frame.php';</script>";
		exit;
	}
}

$sql = "select * from ssc_lockip WHERE ip='" . $_SERVER['REMOTE_ADDR'] . "'";
$query = mysql_query($sql);
$dduser = mysql_fetch_array($query);
if(empty($dduser)){
}else{
	echo "<script>window.location='".$gourl."';</script>"; 
	exit;
}

if($_POST['act']=="login"){
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
        	<div style="width:684px; margin:auto;">
					<form name='login' method="post" action="./" onSubmit="javascript:LoginNow(); return false;">
            		<div style="width:100%;text-align:center;">
                    	<font color="#FF0000"></font>
                    </div>
                    <div class="content_reg_line">
                    	<div class="form_title">通行证账号：</div>
                        <div class="form_word" style='font-size:14px;'><?=$name?></div>
						<input type="hidden" name="username" id="username" value="<?=$name?>"/>
                        <input type="hidden" name="act" id="act" value="finish"/>
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
<?php 
exit;
}
if($_POST['act']=="finish"){
$name = trim($_POST['username']);
$pwd = trim($_POST['loginpass_source']);

if ($name == "" || $pwd == "") {
	echo "<script language=javascript>window.location='./';</script>";
	exit;
}

$sql = "select * from ssc_member WHERE username='" . $name . "'";
$query = mysql_query($sql);
$dduser = mysql_fetch_array($query);

if(empty($dduser)){
	echo "<script>window.location='".$gourl."';</script>"; 
	exit;
}else{
	$pwd2 = $dduser['password'];
	$uid = $dduser['id'];
	$pwd= md5($pwd);
	if($pwd == $pwd2){
		if($dduser['zt']==2){
			echo "<script language=javascript>alert('您的帐户被锁定！');window.location='./';</script>";
			exit;
		}
		$_SESSION["sess_uid"] = $uid; 
		$_SESSION["username"] = $name; 
		$_SESSION["level"] = $dduser['level'];
		$_SESSION["valid"] = mt_rand(100000,999999);

		require_once 'ip.php';
		$ip1 = $_SERVER['REMOTE_ADDR'];
		$iplocation = new iplocate();
		$address=$iplocation->getaddress($ip1);
		$iparea = $address['area1'].$address['area2'];

//		$ip1=$_SERVER['REMOTE_ADDR'];
//		$ip2=explode(".",$ip1);
//		if(count($ip2)==4){
//			$ip3=$ip2[0]*256*256*256+$ip2[1]*256*256+$ip2[2]*256+$ip2[3];
						
//			$sql = "select * from ssc_ipdata WHERE StartIP<=".$ip3." and EndIP>=".$ip3."";
//			$quip = mysql_query($sql) or  die("数据库修改出错". mysql_error());
//			$dip = mysql_fetch_array($quip);
//			$iparea = $dip['Country']." ".$dip['Local'];
//		}
		$exe = mysql_query("update ssc_member set lognums=lognums+1, lastip2=lastip, lastarea2=lastarea, lastdate2=lastdate, lastip='".$ip1."', lastarea='".$iparea."', lastdate='".date("Y-m-d H:i:s")."' where username='".$name."'");
		$exe = mysql_query("insert into ssc_memberlogin set uid='".$dduser['id']."', username='".$name."', nickname='".$dduser['nickname']."', loginip='".$ip1."', loginarea='".$iparea."', explorer='".$_SERVER['HTTP_USER_AGENT']."', logindate='".date("Y-m-d H:i:s")."', level='".$dduser['level']."'");
		$exe = mysql_query( "delete from ssc_online where username='".$name."'");
		$exe=mysql_query("delete from ssc_online where username='".$name."'") or  die("数据库修改出错". mysql_error());
		$exe=mysql_query("insert into ssc_online set uid='".$dduser['id']."', username='".$name."', nickname='".$dduser['nickname']."', ip='".$ip1."', explorer='".$_SERVER['HTTP_USER_AGENT']."', addr='".$iparea."', adddate='".date("Y-m-d H:i:s")."', updatedate='".date("Y-m-d H:i:s")."', valid='".$_SESSION["valid"]."', level='".$dduser['level']."'") or  die("数据库修改出错". mysql_error());
		$sqla = "select * from ssc_total WHERE logdate='" . date("Y-m-d") . "'";
		$rsa = mysql_query($sqla);
		$rowa = mysql_fetch_array($rsa);
		if(empty($rowa)){
			$exe=mysql_query("insert into ssc_total set nums".$dduser['level']."=nums".$dduser['level']."+1, logdate='" . date("Y-m-d") . "'") or  die("数据库修改出错". mysql_error());
		}else{
			$exe=mysql_query("update ssc_total set nums".$dduser['level']."=nums".$dduser['level']."+1 where logdate='" . date("Y-m-d") . "'") or  die("数据库修改出错". mysql_error());
		}

//登录充值开始		
$sql_jc = "select * from ssc_huodong where id=3";
$rs_jc = mysql_query($sql_jc);
$row_jc = mysql_fetch_array($rs_jc);	
if($row_jc['kg']==1){
		$sql_login = "select count(id) as tj from ssc_memberlogin WHERE uid='" .$dduser['id']. "' and logindate like'%".date("Y-m-d")."%'";
		$rs_login = mysql_query($sql_login);
		$row_login = mysql_fetch_array($rs_login);	
		
		$sql_loginip= "select count(id) as tjip from ssc_memberlogin WHERE loginip='".$ip1."' and logindate like'%".date("Y-m-d")."%'";
		$rs_loginip = mysql_query($sql_loginip);
		$row_loginip = mysql_fetch_array($rs_loginip);	
	
	if($row_login['tj']==1 && $row_loginip['tjip']==1){

		$sqla = "select * from ssc_member WHERE id='" . $dduser['id'] . "'";
		$rsa = mysql_query($sqla);
		$rowa = mysql_fetch_array($rsa);
		$leftmoney=$rowa['leftmoney'];
		$sqlc = "select * from ssc_record order by id desc limit 1";		//帐变
		$rsc = mysql_query($sqlc);
		$rowc = mysql_fetch_array($rsc);
		$dan1 = sprintf("%07s",strtoupper(base_convert($rowc['id']+1,10,36)));
			$lmoney=$row_jc['jieguo'];
		
			$sqla="insert into ssc_record set dan='".$dan1."', uid='".$dduser['id']."', username='".Get_mname($dduser['id'])."', types='60', smoney=".$lmoney.",leftmoney=leftmoney+".$lmoney.", regtop='".$rowa['regtop']."', regup='".$rowa['regup']."', regfrom='".$rowa['regfrom']."', adddate='".date("Y-m-d H:i:s")."'";
			$exe=mysql_query($sqla) or  die("数据库修改出错6!!!".mysql_error());

			$sqlb="insert into ssc_savelist set uid='".$dduser['id']."', username='".Get_mname($dduser['id'])."', bank='登录充值', bankid='0', cardno='', money=".$lmoney.", sxmoney='0', rmoney=".$lmoney.", adddate='".date("Y-m-d H:i:s")."',zt='1',types='60'";
			$exe=mysql_query($sqlb) or  die("数据库修改出错6!!!".mysql_error());


			$sql="update ssc_member set leftmoney =(leftmoney+".$lmoney."),totalmoney=(totalmoney+".$lmoney.") where id ='".$dduser['id']."'";
			$exe=mysql_query($sql) or  die("数据库修改出错6!!!".mysql_error());		
	}	
}		
//登录充值结束		
		
		echo "<script language=javascript>window.location='default_frame.php';</script>";
		exit;
	}else{
		echo "<script language=javascript>alert('登陆失败，请检查您的帐户名与密码');window.location='./';</script>";
		exit;
	}
}
exit;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD><META http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<TITLE>用户登陆</TITLE>
<SCRIPT LANGUAGE='JavaScript'>function ResumeError() {return true;} window.onerror = ResumeError; </SCRIPT> 
<SCRIPT type="text/javascript" src="js/jquery.js"></SCRIPT>
<SCRIPT type="text/javascript" src="js/jquery.md5.js"></SCRIPT>
<LINK href="css/login.css" rel="stylesheet" type="text/css" />
</HEAD><BODY>
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
	//$("#loginpass_source")[0].value = '';
	$("#username").focus();
}); 
function refreshimg(){
document.getElementById("vcsImg").src="ValiCode_new.php?"+  new Date().getTime();
}
function LoginNow() 
{ 
    var loginuser = $("#username").val();
    var randnum = $("#validcode_source").val();
    if (loginuser == ''){
        alert('请填写 通行证账号');
        return false;
    }
    if (randnum == '') {
        alert('请填写 图片验证码');
        return false;
    }
    var submitvc = $.md5(randnum);
	$("#validcode")[0].value = submitvc;
    document.forms['login'].submit();
}
</script>
<div id="allbox">
    <div id="header">
       <div id="header_content">
          <div id="header_logo"></div>
          <div id="header_right">
			  <div id="header_tips"><?php echo $webname;?>欢迎您</div>
			  <div id="header_menu" style='margin-left:400px;'>
			  <!--
				<ul id="menu">
		<li class="link1"><a href="#1"><img src="images/comm/t.gif" width="100" height="33" border="0" title="登录系统"/></a></li>
		<li class="link2"><a href="#2"><img src="images/comm/t.gif" width="110" height="33" border="0" title="帮助"/></a></li>
				</ul>
				//-->
			   </div>
           </div>
         </div> 
     </div>
     <div id="top_line"></div>
		<div id="reg_content">
			<div id="content_reg_box_top"></div>
			<div id="content_reg_box_center">
				<div id="maintitle">通行证登录</div>	
				<div id="maincontent">	
        	<div style="width:684px; margin:auto;">
					<form name='login' method="post"  action="./"  onSubmit="javascript:LoginNow(); return false;"">
					<input type="hidden" name="validcode" id="validcode">
					<input type="hidden" name="act" value="login" />
            		<div style="width:100%;text-align:center;">
                    	<font color="#FF0000"></font>
                    </div>
                    <div class="content_reg_line">
                    	<div class="form_title">通行证账号：</div>
                        <div class="form_word">
						<span class="inputBox input180"><cite><input type="text" name="username" id="username" maxlength="32" value="" class="text"/></cite></span>
						</div>
                    </div>
					<div class="content_reg_line">
                    	<div class="form_title">图片验证码：</div>
                        <div class="form_word"><span class="inputBox input60"><cite><input type="text" name="validcode_source" id="validcode_source" maxlength="4" value="" class="text"/></cite></span></div> 
						<img id="vcsImg" src="ValiCode_New.php"  name="validate" align="absbottom" style="margin-left:6px;cursor:pointer; border: 1px solid #999" onClick="refreshimg()" alt="点击图片更新验证码">
                    </div>
                    <div style="border-top:1px dotted #ccc; width:90%; margin:5px auto; height:1px; font-size:0; overflow:hidden;margin-bottom:20px;"></div>
					<div style="height:30px; text-align:center;">
                    <input name="Submit" type="image" id="Submit" src="images/comm/t.gif" class='inputNext' title="下一步" width="104" height="30"/>
                    &nbsp;&nbsp;<a href="default_getpass.php">忘记密码？</a></div>
					<div style="padding-top:32px; margin:2px 0px; text-align:center;">小提示: 使用 <font color=red>IE (Internet Explorer ) 8.0</font> 浏览器可达到最佳使用效果 </div>
					</form>
            </div>
        </div>&nbsp;
	</div>
	<div id="content_reg_box_bottom"></div>
</div>
</div>
<?php echo $count?>
</BODY>
</HTML>