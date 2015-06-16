<?php
session_start();
error_reporting(0);
require_once 'conn.php';
require_once 'check.php';

$sql = "select * from ssc_member WHERE username='" . $_SESSION["username"] . "'";
$query = mysql_query($sql);
$dduser = mysql_fetch_array($query);
$fs=100;
if($dduser['cwpwd'] == ""){
	$fs=$fs-30;
	$cont=$cont."-30 分 ： <font color=red>[警告]</font> 您没有设置资金密码，建议尽快设置。<br/>";
}

$sql = "select * from ssc_bankcard WHERE username='" . $_SESSION["username"] . "'";
$rs = mysql_query($sql);
$bank = mysql_fetch_array($rs);
if(empty($bank)){
	$fs=$fs-30;
	$cont=$cont."-30 分 ： <font color=red>[警告]</font> 您未绑定银行卡， <a href='./account_banks.php'>点击这里绑定银行卡。</a><br/>";
}else{
	if($dduser['cardlock'] != "1"){
		$fs=$fs-8;
		$cont=$cont."-8 分 ： <font color=green>[提示]</font> 您的银行卡<font color=red>未锁定</font>，为了您资金安全,建议进行锁定。<br/>";
	}
}

if($dduser['question'] == ""){
	$fs=$fs-15;
	$cont=$cont."-15 分 ： <font color=red>[警告]</font> 您尚未设置登录问候语！请使用〖<font color=#ff3366>修改密码</font>〗功能进行设置。<br/>";
}

$odate = strtotime($dduser['cwpwddate']);
$ndate = time();
$cday=($ndate-$odate)/24/3600;
if($cday>=15){
	$fs=$fs-9;
	$cont=$cont."-9 分 ： <font color=green>[提示]</font> 您的资金密码已有 15 天未更新，为了您的资金安全，建议定期更换。<br/>";
}

if($dduser['lastip2'] != "" && $dduser['lastip']!=$dduser['lastip2']){
	$fs=$fs-2;
	$cont=$cont."-2 分 ： <font color=green>[提示]</font> 上次登录：".$dduser['lastdate2']."， 参考位置：".$dduser['lastarea2']."。<br/>";
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD><TITLE><?php echo $webname;?>  - 信息中心</TITLE>
<META http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<META http-equiv="Pragma" content="no-cache" />
<LINK href="css/v1.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.STYLE1 {
	color: #FF0000;
	font-size: 24px;
	font-weight: bold;
}
.STYLE3 {color: #FF0000; font-size: 36px; font-weight: bold; }
-->
</style>
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
<BODY STYLE="background:#FFF url('images/v1/main_bg_0001.jpg') 0px -490px repeat-x; padding:10px;" onload="javascript:sAlert()">
 
<DIV ID='main_box'>
<div class="box l"></div>
<div class="box c"></div>
<div class="box r"></div>
<div class="box m">

<!--<H1>
<SPAN class="action-span1"><DIV class='tubiao'></DIV>当前位置: <A href="/" target='_top'><?php echo $webname;?></a>
 - 信息中心 </SPAN><DIV style="clear:both"></DIV></H1>-->
<script>
$(document).ready(function(){
	$("a[rel='notice']").click(function(){
		$("tr[id^='notice_content_']").hide();
		$("#notice_content_"+$(this).attr("id")).show();
	});
	$("tr[id^='notice_content_']").hide();
	$("a[rel='notice']:first").click();
});
</script>
<!--<div class=d450><table border=0 cellspacing=0 cellpadding=0>
<tr class=t><td class=tl></td><td class=tm>&nbsp;</td><td class=tr></td></tr>
<tr class=mm><td class=ml><img src='images/comm/t.gif'></td><td>

<table border=0 cellspacing=0 cellpadding=0>
<tr>
	<td width=170 align=center valign=middle><table border=0 cellspacing=0 cellpadding=0 class=tb1><tr><td><?=$fs?></td></tr></table></td>
	<td width=2><img src='images/comm/t.gif' class='l1'></td>
	<td valign=top><table border=0 cellspacing=0 cellpadding=0 class=tb2><tr><td STYLE='padding-top:10px;line-height:20px;'>
您的账户安全评分为： <?=$fs?> 分 ( 满分100 )<br/>
您的本次登录参考位置： <font color='#008000'><?=$dduser['lastarea']?></font><br/><br/>
<?=$cont?>
</td></tr></table></td></tr>
</table>

</td><td class=mr><img src='images/comm/t.gif'></td></tr>
<tr class=b><td class=bl></td><td class=bm>&nbsp;</td><td class=br></td></tr></table>
</div>-->


<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="0.5%" align="left" valign="top"><img src="images/v1/jiao1.png" width="9" height="44" /></td>
    <td width="99.9%" style="background:url('images/v1/b1.jpg') repeat-x;height:44px;line-height:44px;color:#006837; font-size:16px; font-weight:bold;">系统公告</td>
    <td width="0.5%" align="right"><img src="images/v1/jiao2.png" width="9" height="44" /></td>
  </tr>
</table>

<div class=d450><table border=0 cellpadding=0 cellspacing=0 >
<tr class=t><td></td><td>&nbsp;</td><td></td></tr>
<tr class=mm><td class=ml><img src='images/comm/t.gif'></td>
<td style="background:#fafafa">
<table border=0 cellspacing=0 cellpadding=0><tr>
	<td align=left valign=top width=290 align=center valign=middle>
		<font color=red></font>
		<table border=0 cellspacing=0 cellpadding=2 style="padding:12px;line-height:20px;" >
        	<?php
            $sql = "select * from ssc_news order by id desc";
			$rsnews = mysql_query($sql);
			$id=0;
			while ($rownews = mysql_fetch_array($rsnews)){
				if($rownews['lev']==1){
					echo "<tr><td width=12>&nbsp;</td><td width=75 style='color:#999999; font-family:Verdana ;'>".$rownews['adddate']."</td><td><a href='javascript:' rel=\"notice\" id=\"".$id."\"  style=\"color:#FF0000;\">".$rownews['topic']."</a></td></tr>";
				}else{
					echo "<tr><td width=12>&nbsp;</td><td width=75 style='color:#999999; font-family:Verdana;'>".$rownews['adddate']."</td><td ><a href='javascript:' rel=\"notice\" id=\"".$id."\"  style='color:#666;'>".$rownews['topic']."</a></td></tr>";				
				}
				$id=$id+1;
			}
			?>
			  </table>
	</td>
	<td valign=top width=2><img src='images/comm/t.gif' class='l1'></td>
    <td align=left valign=top>
	<table border=0 cellspacing=0 cellpadding=0 class=tb2 style=" margin-top:5px; font-size:12px;">
        <?php
            $sql = "select * from ssc_news order by id desc";
			$rsnews = mysql_query($sql);
			$id=0;
			while ($rownews = mysql_fetch_array($rsnews)){
				echo "<tr id=\"notice_content_".$id."\" style=\"display:none; \"><td>".$rownews['cont']."<p style=\"text-align: right\"><span style=\"color: rgb(128,128,128)\">-----诚信铸造品牌，安全值得信赖&nbsp;</span></p></td></tr>";
				$id=$id+1;
			}
			?>
        </table></td>
</tr></table>

</td><td class=mr><img src='images/comm/t.gif'></td></tr>
<tr class=b><td class=bl></td><td class=bm>&nbsp;</td><td class=br></td></tr></table>
</div>

<div id="footer"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td align="center"><table align="center" width="450">
<tr><td align="left">浏览器建议：首选IE 8.0浏览器，其次为火狐浏览器。</td></tr>
</table></td></tr><tr><td></td></tr></table></div>
<br/><br/>
</div></div>
<?php echo $count?>

<script type="text/javascript" language="javascript">
//            function sAlert(){
//            var msgw,msgh,bordercolor;
//            msgw=650;//提示窗口的宽度
//            msgh=400;//提示窗口的高度
//            bordercolor="#000";//提示窗口的边框颜色
//            titlecolor="#000";//提示窗口的标题颜色
//            
//            var sWidth,sHeight;
//            sWidth=document.body.offsetWidth;
//            sHeight=document.body.offsetHeight;
//            
//
//            var bgObj=document.createElement("div");
//            bgObj.setAttribute('id','bgDiv');
//            bgObj.style.position="absolute";
//            bgObj.style.top="0";
//            bgObj.style.background="#000";
//            bgObj.style.filter="progid:DXImageTransform.Microsoft.Alpha(style=3,opacity=25,finishOpacity=75";
//            bgObj.style.opacity="0.6";
//            bgObj.style.left="0";
//            bgObj.style.width=sWidth + "px";
//            bgObj.style.height=sHeight + "px";
//            document.body.appendChild(bgObj);
//            var msgObj=document.createElement("div")
//            msgObj.setAttribute("id","msgDiv");
//            msgObj.setAttribute("align","center");
//            msgObj.style.position="absolute";
//            msgObj.style.background="white";
//            msgObj.style.font="12px/1.6em Verdana, Geneva, Arial, Helvetica, sans-serif";
//            msgObj.style.border="1px solid " + bordercolor;
//            msgObj.style.width=msgw + "px";
//            msgObj.style.height=msgh + "px";
//          msgObj.style.top=(document.documentElement.scrollTop + (sHeight-msgh)/2) + "px";
//          msgObj.style.left=(sWidth-msgw)/2 + "px";
//          var title=document.createElement("h4");
//          title.setAttribute("id","msgTitle");
//          title.setAttribute("align","right");
//          title.style.margin="0";
//          title.style.padding="3px";
//          title.style.background=bordercolor;
//          title.style.filter="progid:DXImageTransform.Microsoft.Alpha(startX=20, startY=20, finishX=100, finishY=100,style=1,opacity=75,finishOpacity=100);";
//          title.style.opacity="0.75";
//          title.style.border="1px solid " + bordercolor;
//          title.style.height="18px";
//          title.style.font="12px Verdana, Geneva, Arial, Helvetica, sans-serif";
//          title.style.color="white";
//          title.style.cursor="pointer";
//          title.innerHTML="关闭";
//          title.onclick=function(){
//            document.body.removeChild(bgObj);
//        document.getElementById("msgDiv").removeChild(title);
//        document.body.removeChild(msgObj);
//        }
//          document.body.appendChild(msgObj);
//          document.getElementById("msgDiv").appendChild(title);
//          var txt=document.createElement("p");
//          txt.style.margin="1em 0"
//          txt.setAttribute("id","msgTxt");
//          txt.innerHTML='<div><span class="STYLE3">鑫马游戏平台登录每日送红包</span></div><div style="margin-left:10px"  align="left"><br /><br /><span class="STYLE1"><strong>1、活动期间，新会员老会员每日登录奖励3元红包。<br /> <br />  2、本次活动永久不关闭，只要会员每日登录就有奖励。<br /><br /> 3、奖金可用于提现或投注，无投注量要求。<br /><br /> 4、每天欢乐送，你来我就送.每月可领取90元红包。<br /> <br /> 5、先到先得，每天指定时间抢购彩金。<br /><br />6、同一帐号、同一IP、同一银行卡每天只可获取1次（登录红包）</strong> </span></div>';
//      document.getElementById("msgDiv").appendChild(txt);
//      }
        </script>
</BODY></HTML>