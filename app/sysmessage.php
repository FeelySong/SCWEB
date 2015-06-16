<?php
session_start();
error_reporting(0);
require_once 'conn.php';
require_once 'check.php';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=utf-8" />
<TITLE>系统消息</TITLE>
<LINK href="css/v1.css" rel="stylesheet" type="text/css" />
<SCRIPT type="text/javascript" src="js/jquery.js"></SCRIPT>
</HEAD>
<BODY>
<STYLE>
.ct2 td{color:#111; font-size:12px;}
.successed {background:url('images/v1/icons.png') -35px -67px no-repeat;height:28px;width:26px;float:left; margin:0 12px 0 8px;}
.failed {background:url('images/v1/icons.png') -3px -67px no-repeat;height:28px;width:26px;float:left; margin:0 12px 0 8px;}
.red{color:#f00;}
.green{color:#393;}
li{margin:0px 0px 0px 20px;list-style-type: circle;}
li a{color:#555; text-decoration:none;}
li a:hover{color:#f33; text-decoration:underline;}
</STYLE>
<BODY STYLE='background-color:#838383;'>
<DIV ID='main_box_s2'><DIV class='icons_mb2'></DIV>当前位置: <A href="/" target='_top'><?php echo $webname;?></a> - 系统消息</DIV>
<br/>


<CENTER>
<div class="div_s1" style='text-align:left;width:90%;'>
<div class='header'><DIV class='icons_mb3'></DIV> 系统消息</div>

<div class="tab-div-s2" STYLE='border-top: 1px solid #505050;'>
    <div STYLE='background-color:#eee;'><table class="ct2" border="0" cellspacing="0" cellpadding="0">
	  <tr><td><span class='<?=$_SESSION["backzt"]?>'></span> <font STYLE='font-size:14px;' color='<?php if($_SESSION["backzt"]=="failed"){echo "red";}else{echo "green";}?>'><?=$_SESSION["backtitle"]?></font></td></tr>
	  <tr><td STYLE='border:0;padding-top:30px;line-height:23px;'>
		如果您不做出选择，将在 <span id="spanSeconds">9</span> 秒后跳转到第一个链接地址				<?php if($_SESSION["backurl"]=="users_list.php"){?><li><a href="users_add.php" target="_self">增加用户</a></li><?php }?><li><a href="<?=$_SESSION["backurl"]?>" target="_self"><?=$_SESSION["backname"]?></a></li>
			
	  </td></tr>
	</table></div>
</div>
</div>


<SCRIPT language="JavaScript">
<!--
var seconds = document.getElementById('spanSeconds').innerHTML;
var defaultUrl = "<?=$_SESSION["backurl"]?>";
var timeInterval = null;


onload = function()
{
 timeInterval = window.setInterval(redirection, 1000);
    document.getElementById('spanSeconds').innerHTML = seconds;
}

function redirection()
{
  seconds--;

  if (seconds <= 0)
  {
   clearInterval(timeInterval);
      window.location.href= defaultUrl;
  }
  else
  {
      document.getElementById('spanSeconds').innerHTML = seconds;
  }
}
//-->
</SCRIPT>
</BODY>
</HTML>