<?php
error_reporting(0);
require_once 'conn.php';

if($webzt!='1'){
	echo "<script>alert('对不起,系统维护中!');window.location='".$gourl."';</script>"; 
	exit;
}

$sql = "select * from ssc_lockip WHERE ip='" . $_SERVER['REMOTE_ADDR'] . "'";
$query = mysql_query($sql);
$dduser = mysql_fetch_array($query);
if(empty($dduser)){
}else{
	echo "<script>window.location='".$gourl."';</script>"; 
	exit;
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
<META content="IE=7.0000" http-equiv="X-UA-Compatible">
<TITLE>管理后台——欢迎光临商城</TITLE>
<META content="text/html; charset=utf-8" http-equiv=Content-Type><LINK rel=stylesheet type=text/css href="CSS/logstyle.css">
<script type="text/javascript">
function refreshimg(){
document.getElementById("vcsImg").src="ValiCode_new.php?"+  new Date().getTime();
}
function submit()
{
document.forms[0].submit()
}
</script>
</HEAD>
<BODY>
<FORM id=form1 method=post action=Login.php>
<DIV class=container>
<DIV class=loim>
<DIV 
style="Z-INDEX: 1; BORDER-BOTTOM: #000000 1px; POSITION: relative; BORDER-LEFT: #000000 1px; BORDER-TOP: #000000 1px; BORDER-RIGHT: #000000 1px" 
class=content>
<DIV class=content_1>
<DIV class=content_2>
<DIV class=content_2_bd>
<DIV class=bd_1></DIV>
<DIV class=bd_2><INPUT style="WIDTH: 160px;background-color:transparent;border:0px" id=AdminId name=AdminId> <SPAN style="DISPLAY: none" id=RequiredFieldValidator1 
class=fontsiz controltovalidate="AdminId" errormessage="账号不能为空" 
display="Dynamic" initialvalue isvalid="true">账号不能为空</SPAN> </DIV>
<DIV class=clearer></DIV></DIV></DIV>
<DIV class=content_2>
<DIV class=content_2_bd>
<DIV class=bd_1></DIV>
<DIV class=bd_2><INPUT style="WIDTH: 160px;background-color:transparent;border:0px" id=Password value="" type=password name=Password ><SPAN style="DISPLAY: none" 
id=RequiredFieldValidator2 class=fontsiz controltovalidate="Password" errormessage="密码不能为空" display="Dynamic" initialvalue isvalid="true">密码不能为空</SPAN></DIV>
<DIV class=clearer></DIV></DIV></DIV>
<DIV class=content_2>
<DIV class=content_2_bd>
<DIV class=bd_3></DIV>
<DIV class=bd_4><INPUT style="WIDTH: 90px;background-color:transparent;border:0px" id=Code name=Code><img id="vcsImg" src="ValiCode_New.php"  name="validate" align="absbottom" style="margin-left:6px;cursor:pointer; border: 1px solid #999" onClick="refreshimg()" alt="点击图片更新验证码"></DIV>
<DIV class=clearer></DIV></DIV></DIV>
<DIV style="WIDTH: 395px" class=content_3><DIV class=content_31><A id=LinkButton1 class=footer_1 href='javascript:submit()'> </A></div> 
<DIV class=content_32><A class=footer_1 onclick=javascript:form1.reset(); href="javascript:void(0);"> </A></div> <SPAN style="COLOR: red" 
id=ErrorMessage class=fontsiz></SPAN></DIV></DIV>
<DIV class=clearer></DIV></DIV></DIV></DIV>
</FORM></BODY></HTML>
