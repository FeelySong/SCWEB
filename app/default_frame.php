<?php
session_start();
error_reporting(0);
require_once 'conn.php';
/*
if($_SESSION["sess_uid"]=="" || $_SESSION["username"] =="" || $_SESSION["valid"]==""){
	echo "<script language=javascript>window.location='default_logout.php';</script>";
	exit;
}
*/

$flag=$_REQUEST['flag'];

$sql = "select ssc_bills.*,ssc_member.nickname from ssc_bills left join ssc_member on ssc_bills.uid=ssc_member.id where ssc_bills.zt=1 order by ssc_bills.id desc limit 15";
$rs = mysql_query($sql);
$total = mysql_num_rows($rs);

if($flag=="gettoprize"){
//	$lotteryid=$_REQUEST['lotteryid'];
//	$issue=$_REQUEST['issue'];	//120225076	30条
	echo "[";
	$i=0;
	while ($row = mysql_fetch_array($rs)){
		echo "{\"name\":\"".$row['nickname']."\",\"lottery\":\"".$row['lottery']."\",\"issue\":\"".$row['issue']."\",\"prize\":\"".$row['prize']."\",\"s\":3}";
		if($i!=$total-1){echo ",";}
		$i=$i+1;
	}
	echo "]";

}else{

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<TITLE><?php echo $webname;?></TITLE>
<STYLE type="text/css">
.gonggaodiv div{height:32px;overflow:hidden;}
</STYLE>
<LINK href="css/main.css" rel="stylesheet" type="text/css" />
<link type="text/css" rel="stylesheet" href="css/buttons.css">
<SCRIPT type="text/javascript" src="js/jquery.js"></SCRIPT>
<script language="javascript" type="text/javascript" src="js/common.js"></script>
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
<style>
html {overflow: hidden;}
</style>
</HEAD>
<BODY>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
	<td id="topbox">
		<div id="header-div" >
		 <div id="submenu-div2">
                    <div id="logo-div" onclick="javascript:window.top.location='./default_frame.php';"><img src="images/v1/logo.png" width="200" height="80"  title="返回首页"/></div>
                    <div id="nav_t">
                       <ul>
                          <li id="nav_1"><a href="default_frame.php"><span>&nbsp;</span></a></li>
                          <li id="nav_2" TITLE='填写充值申请' ALT='填写充值申请'><a target="mainframe" href="account_autosave.php"><span>&nbsp;</span></a></li>
                          <li id="nav_3" TITLE='投注记录查看' ALT='投注记录查看'><a  target="mainframe" href="history_playlist.php"><span>&nbsp;</span></a></li>
                          <li id="nav_4" TITLE='所有用户信息' ALT='所有用户信息'><a target="mainframe" href="users_list.php"><span>&nbsp;</span></a></li>
                          <li id="nav_5" TITLE='查询游戏统计信息' ALT='查询游戏统计信息'><a target="mainframe" href="report_game.php"><span>&nbsp;</span></a></li>
                          <li id="nav_6" TITLE='查看各彩种奖金' ALT='查看各彩种奖金'><a target="mainframe" href="users_info.php"><span>&nbsp;</span></a></li>
                          <li id="nav_7" TITLE='常见问题说明' ALT='常见问题说明'><a target="mainframe" href="help_general.php"><span>&nbsp;</span></a></li>
                          <!-- <li id="nav_8" TITLE='在线客服' ALT='在线客服'><a href="csonline_addnew.php" target="_blank"><span>&nbsp;</span></a></li> -->
                          <li id="nav_8" TITLE='在线客服' ALT='在线客服'><a href="http://wpa.qq.com/msgrd?V=3&uin=1975418259&Site=%E4%BA%91%E5%BD%A9%E5%A8%B1%E4%B9%90&Menu=yes&from=discuz" target="_blank"><span>&nbsp;</span></a></li>
                       </ul></div>
  </div>
</div></td></tr></table>

<table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td valign="top" id="leftbox" rowspan="2" style="width:180px; height:100%; background: #D94733;">
            <iframe name="leftframe" id="leftframe" frameborder="0" width="100%" height="100%" scrolling="no"  style="overflow:hidden;" src="default_menu.php"></iframe>
        </td>
        <td valign="middle" id="dragbox" class="left_sidbar" rowspan="2">
            <div id="dragbutton" class="lsid_cen"></div>
        </td>
        <td id="noticebox" valign="top">
            <div class="gonggaodiv">
                <div>
                    <span class="nocticetitle">最新大奖名单:</span>
                    <ul id="zjtgul">
                        <?php
                        while ($row = mysql_fetch_array($rs)){
                                echo "<li>恭喜 【<span class=c1>".$row['nickname']."</span>】 ".$row['lottery']." <span class=c2>".$row['issue']."</span> 期, 喜中 <span class=c3>".$row['prize']."</span> 大奖!</li>";
                        }
                        ?>
                        </ul>
                </div>
            </div>
        </td>
    </tr>
    <tr>
        <td id="mainbox" valign="top">
            <iframe name="mainframe" id="mainframe" frameborder="0" width="100%" height="100%" scrolling="yes" style="overflow:hidden;" src="help_security.php"></iframe>
        </td>
    </tr>
</table>

<!--<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
   	  <td style="width:160px; height:100%; background: #D94733;" valign="top" id="leftbox"><iframe name="leftframe" id="leftframe" frameborder="0" width="100%" height="100%" scrolling="auto" style="overflow:visible;" src="default_menu.php"></iframe></td>
        <td valign="top" id="dragbox"><img src="images/comm/t.gif" class='img_arrow_l' border="0" id="dragbutton" style="cursor:pointer;" /></td>
        <td id="mainbox" valign="top">

        <iframe name="mainframe" id="mainframe" frameborder="0" width="100%" height="100%" scrolling="auto" style="overflow:visible;" src="help_security.php"></iframe></td>
    </tr>
</table>-->
</BODY>
</HTML>
<?php }?>