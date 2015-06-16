<?php
session_start();
error_reporting(0);
require_once 'conn.php';
require_once 'check.php';


$sql = "SELECT * FROM ssc_member WHERE id='" . $_REQUEST['uid'] . "'";
$rs = mysql_query($sql);
$row = mysql_fetch_array($rs);
if(empty($row)){
	$_SESSION["backtitle"]="操作失败，无此用户";
	$_SESSION["backurl"]="users_listb.php";
	$_SESSION["backzt"]="failed";
	$_SESSION["backname"]="用户列表";
	echo "<script language=javascript>window.location='sysmessage.php';</script>";
	exit;
}

$sqla = "SELECT * FROM ssc_member WHERE username='" . $_SESSION["username"] . "'";
$rsa = mysql_query($sqla);
$rowa = mysql_fetch_array($rsa);


$cmoney=floatval($_POST['money']);
	if($cmoney==0){
		$_SESSION["backtitle"]="操作失败，请输入正确充值金额";
		$_SESSION["backurl"]="users_saveup.php?uid=".$_REQUEST['uid'];
		$_SESSION["backzt"]="failed";
		$_SESSION["backname"]="用户充值";
		echo "<script language=javascript>window.location='sysmessage.php';</script>";
		exit;
	}

$flag = trim($_POST['flag']);
if($flag=="confirm"){	
		
	if($rowa['czzt']!="1" || $rowa['zt']!="0"){
		$_SESSION["backtitle"]="操作失败，您无此权限";
		$_SESSION["backurl"]="users_listb.php";
		$_SESSION["backzt"]="failed";				
		$_SESSION["backname"]="用户列表";
		echo "<script language=javascript>window.location='sysmessage.php';</script>";
		exit;
	}
	
	if(md5(trim($_POST['spwd']))!=$rowa['cwpwd']){
		$_SESSION["backtitle"]="操作失败，资金密码错误";
		$_SESSION["backurl"]="users_listb.php";
		$_SESSION["backzt"]="failed";
		$_SESSION["backname"]="用户列表";
		echo "<script language=javascript>window.location='sysmessage.php';</script>";
		exit;
	}
	
	if(floatval($rowa['czxg'])<$cmoney){
		$_SESSION["backtitle"]="操作失败，充值金额超过限额";
		$_SESSION["backurl"]="users_listb.php";
		$_SESSION["backzt"]="failed";
		$_SESSION["backname"]="用户列表";
		echo "<script language=javascript>window.location='sysmessage.php';</script>";
		exit;
	}

	if(floatval($rowa['leftmoney'])<$cmoney){
		$_SESSION["backtitle"]="操作失败，您的余额不足";
		$_SESSION["backurl"]="users_saveup.php?uid=".$_REQUEST['uid'];
		$_SESSION["backzt"]="failed";
		$_SESSION["backname"]="用户充值";
		echo "<script language=javascript>window.location='sysmessage.php';</script>";
		exit;
	}


	$lmoney=$rowa['leftmoney']-$cmoney;
	
	$sqlc = "select * from ssc_record order by id desc limit 1";		//帐变
	$rsc = mysql_query($sqlc);
	$rowc = mysql_fetch_array($rsc);
	$dan1 = sprintf("%07s",strtoupper(base_convert($rowc['id']+1,10,36)));
	
	$sqlb="insert into ssc_record set dan='".$dan1."', uid='".$rowa['id']."', username='".$rowa['username']."', types='30', zmoney=".$cmoney.",leftmoney=".$lmoney.", regtop='".$rowa['regtop']."', regup='".$rowa['regup']."', regfrom='".$rowa['regfrom']."', adddate='".date("Y-m-d H:i:s")."'";
	$exe=mysql_query($sqlb) or  die("数据库修改出错6!!!".mysql_error());

	$sql="update ssc_member set leftmoney ='".$lmoney."',cztotal=cztotal+".$cmoney." where username ='".$_SESSION["username"] ."'";
	if (!mysql_query($sql)){
		die('Error: ' . mysql_error());
	}

	if(floatval($rowa['cztotal'])>5000 && floatval($rowa['czxg'])<1000){
		$sql="update ssc_member set czxg ='1000' where username ='".$_SESSION["username"] ."'";
		if (!mysql_query($sql)){
			die('Error: ' . mysql_error());
		}
	}
	if(floatval($rowa['cztotal'])>20000 && floatval($rowa['czxg'])<5000){
		$sql="update ssc_member set czxg ='5000' where username ='".$_SESSION["username"] ."'";
		if (!mysql_query($sql)){
			die('Error: ' . mysql_error());
		}
	}	
	
	$lmoney=$row['leftmoney']+$cmoney;

	$sqlc = "select * from ssc_record order by id desc limit 1";		//帐变
	$rsc = mysql_query($sqlc);
	$rowc = mysql_fetch_array($rsc);
	$dan1 = sprintf("%07s",strtoupper(base_convert($rowc['id']+1,10,36)));

	$sqlb="insert into ssc_record set dan='".$dan1."', uid='".$row['id']."', username='".$row['username']."', types='31', smoney=".$cmoney.",leftmoney=".$lmoney.", regtop='".$row['regtop']."', regup='".$row['regup']."', regfrom='".$row['regfrom']."', adddate='".date("Y-m-d H:i:s")."'";
	$exe=mysql_query($sqlb) or  die("数据库修改出错6!!!".mysql_error());

	$sqlb="insert into ssc_savelist set uid='".$row['id']."', username='".$row['username']."', bank='上级充值', bankid='0', cardno='', money=".$cmoney.", sxmoney='0', rmoney=".$cmoney.", adddate='".date("Y-m-d H:i:s")."',zt='1',types='2'";
	$exe=mysql_query($sqlb) or  die("数据库修改出错6!!!".mysql_error());
	
	$sql="update ssc_member set leftmoney ='".$lmoney."',totalmoney=totalmoney+ '".$cmoney."' where id ='".$row['id']."'";
	if (!mysql_query($sql)){
		die('Error: ' . mysql_error());
	}
	

	
	$_SESSION["backtitle"]="充值成功";
	$_SESSION["backurl"]="users_listb.php";
	$_SESSION["backzt"]="successed";
	$_SESSION["backname"]="用户列表";
	echo "<script language=javascript>window.location='sysmessage.php';</script>";
	exit;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD><TITLE><?php echo $webname;?>  - 账户充值 (确认页)</TITLE>
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
<SPAN class="action-span1"><DIV class='icons_mb1'></DIV>当前位置: <A href="/" target='_top'>东森游戏</a>
 - 账户充值 (确认页) </SPAN><DIV style="clear:both"></DIV></H1>
<link href="js/keyboard/css/jquery-ui.css" rel="stylesheet">
<link href="js/keyboard/css/keyboard.css" rel="stylesheet">
<script src="js/keyboard/jquery.min.js"></script>
<script src="js/keyboard/jquery-ui.min.js"></script>
<script src="js/keyboard/jquery.keyboard.js"></script>
<script src="js/keyboard/keyboard.js"></script>
<script> 
$(function(){
	getKeyBoard($('#spwd'));
});
</script>
<script type="text/javascript"> 
jQuery("document").ready( function(){
	jQuery("#chineseMoney").html(changeMoneyToChinese(<?=$cmoney?>));
});
</script>
<div class="ld">
<table class="ct">
<form action="" method="post" onsubmit="this.submit.disabled=true;">
<input type="hidden" name="uid" value="<?=$_REQUEST['uid']?>" />
<input type="hidden" name="money" id="money" value="<?=$cmoney?>" />
<input type="hidden" name="flag" value="confirm" />
	<tr>
    	<td class="nl">目标账户: </td>
        <td><?=$row['username']?></td>
    </tr>
    <tr>
    	<td class="nl">充值金额: </td>
        <td><?=number_format($cmoney,4)?></td>
    </tr>
    <tr>
    	<td class="nl">充值金额(大写): </td>
        <td><span id="chineseMoney" style="background-color:#DDD;"></span></td>
    </tr>
    <tr>
    	<td class="nl" style="color:#FF0000;">资金密码: </td>
        <td><input type="password" id="spwd" name="spwd" maxlength="20" style='width:160px;'/></td>
    </tr>
    <tr>
    	<td></td>
    	<td><input type="submit" name="submit" value="确认充值"  class="button" /></td>
    </tr>
</form>
</table>
</div>
<div id="footer"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td align="center"><table align="center" width="450">
<tr><td align="left">浏览器建议：首选IE 8.0浏览器，其次为火狐浏览器。</td></tr>
</table></td></tr><tr><td></td></tr></table></div>
<br/><br/>
</div></div>
</BODY></HTML>