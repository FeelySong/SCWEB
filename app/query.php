<?php

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
		type : 'GET',
		url  : 'http://www.cailele.com/static/ssc/newlyopenlist.xml',
		timeout : 9000,
		success : function(data){
				alert(data);
				return true;
		}
	});
},10000);

});
</script>
</HEAD>
<BODY>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
	<td id="topbox">
		<div id="header-div">
		  <div id="logo-div" onclick="javascript:window.top.location='./';"><img src="images/comm/t.gif" class='main_logo' title="返回首页"/></div>
		  <div id="submenu-div">
			<ul>
			  <li><a TITLE='首页' href="/" style="border-left:none;" target="_top"><img class='link1' src='images/comm/t.gif'>首页</a></li>
			  			  <li><a TITLE='在线客服' style='color:#09C;padding-left:6px;' href="csonline_addnew.php" target="mainframe"><img src='images/comm/t.gif'>在线客服</a></li>
			  <li><a TITLE='刷新当前页' href="javascript:window.top.frames['mainframe'].document.location.reload();"><img class='link2' src='images/comm/t.gif'>刷新</a></li>
			  <li><a TITLE='退出系统' style='color:#090' onClick="return confirm('确认退出系统?');" href="default_logout.php" target="_top"><img class='link4' src='images/comm/t.gif'>退出</a></li>
			  			</ul>
  </div>
</div></td></tr></table>

<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
    	<td style="width:160px; height:100%; background: #D94733;" valign="top" id="leftbox">
            <iframe name="leftframe" id="leftframe" frameborder="0" width="100%" height="100%" scrolling="auto" style="overflow:visible;" src="default_menu.php"></iframe>
        </td>
        <td valign="top" id="dragbox"><img src="images/comm/t.gif" class='img_arrow_l' border="0" id="dragbutton" style="cursor:pointer;" /></td>
        <td id="mainbox" valign="top"></td>
    </tr>
</table>
</BODY>
</HTML>
