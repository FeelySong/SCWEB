<?php
session_start();
error_reporting(0);
require_once 'conn.php';
require_once 'check.php';

$sqla = "select * from ssc_member WHERE username='" . $_SESSION["username"] . "'";
$rsa = mysql_query($sqla);
$rowa = mysql_fetch_array($rsa);
if($rowa['cwpwd']==""){
	$_SESSION["cwurl"]="account_banks.php";
	echo "<script language=javascript>window.location='account_setpwd.php';</script>";
	exit;
}
if($_GET['check']!="114"){
	if($_SESSION["cwflag"]!="ok"){
		$_SESSION["cwurl"]="account_banks.php";
		echo "<script language=javascript>window.location='account_check.php';</script>";
		exit;
	}
}
$_SESSION["cwflag"]="";
$sql = "select * from ssc_bankcard WHERE username='" . $_SESSION["username"] . "'";
$rs = mysql_query($sql);
$banknums=mysql_num_rows($rs);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD><TITLE><?php echo $webname;?>  - 我的银行卡</TITLE>
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
<BODY STYLE="background:#FFF url('images/v1/main_bg_0001.jpg') 0px -490px repeat-x; padding:10px;">

<DIV ID='main_box'>
<div class="box l"></div>
<div class="box c"></div>
<div class="box r"></div>
<div class="box m">

<H1>
<SPAN class="action-span"><A href="account_update.php" target='_self'>修改密码</a></SPAN>
<SPAN class="action-span zhuangtai"><A href="account_banks.php" target='_self'>我的银行卡</a></SPAN>
<SPAN class="action-span"><A href="users_message.php" target='_self'>我的消息</a></SPAN>
<SPAN class="action-span"><A href="users_info.php" target='_self'>奖金详情</a></SPAN>


<SPAN class="action-span1"><DIV class='tubiao'></DIV>当前位置: <A href="/" target='_top'><?php echo $webname;?></a>
 - 我的银行卡 </SPAN><DIV style="clear:both"></DIV></H1>


<div id="tabbar-div">
	   <span class="tabbar_bian1"></span>
	   <span class="tabbar_bianz">
		  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="86%">我的银行卡</td>
    <td width="14%" align="center">
	<SPAN class="action-span"><A href="account_cardadd.php?check=114" target='_self' style="color:#000; text-decoration:none;">增加银行卡</a></SPAN>
	</td>
  </tr>
</table>

			</span>
		<span class="tabbar_bian2"></span>
	    	</div>
<div class="ld"><table class='st' border="0" cellspacing="0" cellpadding="0">
<tr><td width='100%'><font color='#0066FF'>使用提示：</font>每个游戏账户最多绑定 <font style="font-size:16px;color:#FF3300"><b>5</b></font>  张银行卡, 您已成功绑定 <font style="font-size:16px;color:#FF3300"><b><?=$banknums?></b></font> 张。<br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color="#FF0000"  style="font-weight:bold;">银行卡锁定以后，不能增加新的银行卡绑定，同时也不能解绑已绑定的银行卡</font><br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;新绑定的提款银行卡需要绑定时间超过&nbsp;<font style="font-size:16px;color:#F30;font-weight:bold;">6</font>&nbsp;小时才能正常提款。
</td></tr></table></div>
<div class="ld">
<table width="100%" class="lt" border="0" cellspacing="0" cellpadding="0">
  <tr class='th'>
    <!--<td>别名</td>-->
    <td width="10%"><!--<div class='line'></div>-->银行名称</td>
    <td><div class='line'></div>卡号</td>
    <td width="18%"><div class='line'></div>绑定时间</td>
<?php
  if($rowa['cardlock']!=1){
?>
	<td width="10%"><div class='line'></div>操作</td>
<?php }?>
  </tr>
<?php
  if($banknums==0){
?>
  <tr align="center"><td colspan="4" class='no-records'><span>您还没有绑定任何银行卡</span></td></tr>
<?php
  }else{
	while ($row = mysql_fetch_array($rs)){
?>
  <tr align="center">
    <!--<td>王华</td>-->
    <td><?=Get_bank($row['bankid'])?></td>
    <td>***************<?=substr($row['cardno'],-4)?></td>
    <td><?=$row['adddate']?></td>
<?php
  if($rowa['cardlock']!=1){
?>    
    <td><a href="./account_carddel.php?id=<?=$row['id']?>">解绑</a></td>
<?php }?>
  </tr>
  <?php
    }
  }
  ?>
</table>
<br />
<?php
  if($rowa['cardlock']==1){
?>
&nbsp;&nbsp;&nbsp;<font color="#FF0000"  style="font-weight:bold;">您的银行卡资料已锁定</font>
<?php }else{?>
<input name="addcard" type="button" style="font-weight:bold;" value="&nbsp;增加银行卡&nbsp;" onclick="window.location.href='./account_cardadd.php?check=114'" class="button">&nbsp;&nbsp;<input name="addcard" type="button" value="&nbsp;锁定银行卡资料&nbsp;" onclick="window.location.href='./account_cardlock.php'" class="button" style="color:#FF0000; font-weight:bold;">
<?php }?>
</div>
<div id="footer"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td align="center"><table align="center" width="450">
<tr><td align="left">浏览器建议：首选IE 8.0浏览器，其次为火狐浏览器。</td></tr>
</table></td></tr><tr><td></td></tr></table></div>
<br/><br/>
</div></div>
<?php echo $count;?>
</BODY></HTML>