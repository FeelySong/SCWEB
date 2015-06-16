<?php
session_start();
error_reporting(0);
require_once 'conn.php';
require_once 'check.php';

$result=mysql_query("Select * from ssc_config"); 
$raa=mysql_fetch_array($result); 
$txmin = $raa[txmin];
$txmax = $raa[txmax];
$txtnums = $raa[txnums];
$txhours = $raa[txhours];
$txrates = $raa[txrates];
$txlimit = $raa[txlimit];
$txsxmax = $raa[txsxmax];
$yz_min=strtotime($raa['timemin']);
$yz_max=strtotime($raa['timemax']);
$transferfee = 0;
function istimerange($imin,$imax){
	$curtime=time();
	if($imin>$imax){
		if($imax>=$curtime || $imin<=$curtime){
			return 1;
		}else{
			return 0;
		}
	}else{
		if($imin<=$curtime && $imax>=$curtime){
			return 1;
		}else{
			return 0;
		}
	}
}
//$sqla = "select * from ssc_savelist where username='" . $_SESSION["username"] . "' order by id desc limit 1";
//$rsa = mysql_query($sqla);
//$rowa = mysql_fetch_array($rsa);
//if(empty($rowa)){
//}else{
//	if($rowa['rmoney']*0.1>$rowa['xf']){
	if($_POST['real_money']<$txlimit){
		$transferfee=$_POST['real_money']*$txrates/1000;
		if($transferfee>$txsxmax){
			$transferfee=$txsxmax;
		}
	}
//	}
//}

$sqla = "select * from ssc_member WHERE username='" . $_SESSION["username"] . "'";
$rsa = mysql_query($sqla);
$rowa = mysql_fetch_array($rsa);
$leftmoney=$rowa['leftmoney'];

$sql = "select * from ssc_drawlist WHERE username='" . $_SESSION["username"] . "' and DATE_FORMAT( adddate, '%Y-%m-%d' )='".date("Y-m-d")."'";
$rs = mysql_query($sql);
$txnums=mysql_num_rows($rs);

if($_GET['check']!="914"){
	if($_SESSION["cwflag"]!="ok"){
		$_SESSION["cwurl"]="account_draw.php";
		echo "<script language=javascript>window.location='account_check.php';</script>";
		exit;
	}
}
$_SESSION["cwflag"]="";

	$sqlb = "select * from ssc_bankcard WHERE id='".$_REQUEST['bankinfo']."'";
	$rsb = mysql_query($sqlb);
	$rowb = mysql_fetch_array($rsb);

$flag=$_REQUEST['flag'];
if(!istimerange($yz_min,$yz_max)){
		$_SESSION["backtitle"]="操作失败，当日充提时间已过.";
		$_SESSION["backurl"]="account_draw.php?check=914";
		$_SESSION["backzt"]="failed";
		$_SESSION["backname"]="提现申请";
		echo "<script language=javascript>window.location='sysmessage.php';</script>";
		exit;
	}
if($flag=="final"){

	$ntime=date("Y-m-d H:i:s",strtotime("-".$txhours." hour"));

	if($ntime<$rowb['adddate']){
		$_SESSION["backtitle"]="操作失败，新卡绑定".$txhours."小时后才能提现";
		$_SESSION["backurl"]="account_draw.php?check=914";
		$_SESSION["backzt"]="failed";
		$_SESSION["backname"]="提现申请";
		echo "<script language=javascript>window.location='sysmessage.php';</script>";
		exit;	
	}
	
	if($txnums>=$txtnums){
		$_SESSION["backtitle"]="操作失败，您今天已提现了".$txnums."次";
		$_SESSION["backurl"]="account_draw.php?check=914";
		$_SESSION["backzt"]="failed";
		$_SESSION["backname"]="提现申请";
		echo "<script language=javascript>window.location='sysmessage.php';</script>";
		exit;
	}
	$sql = "select * from ssc_member where username='" . $_SESSION["username"] . "'";
	$rs = mysql_query($sql);
	$row = mysql_fetch_array($rs);
	$zt=$row['zt'];
	if($zt==1){//
		$_SESSION["backtitle"]="操作失败，您的帐户被冻结";
		$_SESSION["backurl"]="account_draw.php?check=914";
		$_SESSION["backzt"]="failed";
		$_SESSION["backname"]="提现申请";
		echo "<script language=javascript>window.location='sysmessage.php';</script>";
		exit;
	}
	if($zt==2){//
		$_SESSION["backtitle"]="操作失败，您的帐户被锁定";
		$_SESSION["backurl"]="account_draw.php?check=914";
		$_SESSION["backzt"]="failed";
		$_SESSION["backname"]="提现申请";
		echo "<script language=javascript>window.location='sysmessage.php';</script>";
		exit;
	}
	
	if($_POST['real_money']!="" && $_POST['bankinfo']!=""){
		if($leftmoney>=$_REQUEST['real_money']){
			$lmoney=$leftmoney-$_REQUEST['real_money'];

			$sqlc = "select * from ssc_drawlist order by id desc limit 1";		//帐变
			$rsc = mysql_query($sqlc);
			$rowc = mysql_fetch_array($rsc);
			$dan = sprintf("%07s",strtoupper(base_convert($rowc['id']+1,10,36)));					
			
			$sql = "insert into ssc_drawlist set dan='".$dan."', money='".$_REQUEST['real_money']."', sxmoney='".$_REQUEST['transferfee']."', rmoney='".$_REQUEST['money']."', bank='".$rowb['bankname']."', realname='".$rowb['realname']."', cardno='".$rowb['cardno']."', branch='".$rowb['bankbranch']."', province='".Get_province($rowb['province'])."', city='".Get_city($rowb['city'])."', uid='".$_SESSION["sess_uid"]."', username='".$_SESSION["username"] ."', adddate='".date("Y-m-d H:i:s")."'";
	//		echo $sql;
			$exe = mysql_query($sql);
	
	
			$sqlc = "select * from ssc_record order by id desc limit 1";		//帐变zh扣款
			$rsc = mysql_query($sqlc);
			$rowc = mysql_fetch_array($rsc);
			$dan1 = sprintf("%07s",strtoupper(base_convert($rowc['id']+1,10,36)));
			$sqla="insert into ssc_record set dan='".$dan1."', uid='".$_SESSION["sess_uid"]."', username='".$_SESSION["username"] ."', types='2', zmoney=".$_REQUEST['real_money'].",leftmoney=".$lmoney.", regtop='".$rowa['regtop']."', regup='".$rowa['regup']."', regfrom='".$rowa['regfrom']."', adddate='".date("Y-m-d H:i:s")."'";
			$exe=mysql_query($sqla) or  die("数据库修改出错6!!!".mysql_error());

			$sqla="update ssc_member set leftmoney=".$lmoney." where username='".$_SESSION["username"] ."'"; 
			$exe=mysql_query($sqla) or  die("数据库修改出错7!!!".mysql_error());

			$_SESSION["backtitle"]="操作成功";
			$_SESSION["backurl"]="account_drawlist.php?check=914";
			$_SESSION["backzt"]="successed";
			$_SESSION["backname"]="提现记录";
			echo "<script language=javascript>window.location='sysmessage.php';</script>";
			exit;
		}else{
			$_SESSION["backtitle"]="操作失败，余额不足";
			$_SESSION["backurl"]="account_draw.php?check=914";
			$_SESSION["backzt"]="failed";
			$_SESSION["backname"]="提现申请";
			echo "<script language=javascript>window.location='sysmessage.php';</script>";
			exit;		
		}
	}
	
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD><TITLE><?php echo $webname;?>  - 提现申请 (确认页)</TITLE>
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
<SPAN class="action-span1"><DIV class='icons_mb1'></DIV>当前位置: <A href="/" target='_top'><?php echo $webname;?></a>
 - 提现申请 (确认页) </SPAN><DIV style="clear:both"></DIV></H1>
<div class="ld">
<table width="100%" class="ct" border="0" cellspacing="0" cellpadding="0">
<form action="" method="post" name="drawform">
<input type="hidden" name="flag" value="final" />
<input type="hidden" name="real_money" value="<?=$_POST['real_money']?>" />
<input type="hidden" name="transferfee" value="<?=$transferfee?>" />
<input type="hidden" name="money" value="<?=$_POST['real_money']-$transferfee?>" />
<input type="hidden" name="bankinfo" value="<?=$_POST['bankinfo']?>" />
<tr>
	<td class="nl">实扣金额：</td>
    <td><?=$_POST['real_money']?></td>
</tr>
<?php if($transferfee>0){?>
<tr>
	<td class="nl">提现手续费：</td>
	<td><?=$transferfee?> &nbsp;&nbsp;&nbsp;<font color="#FF0000">投注金额低于充值金额的10%，收取 9‰ 的提款手续费，最高25元</font></td>
</tr>
<?php }?>
<tr>
	<td class="nl">到账金额：</td>
    <td><?=$_POST['real_money']-$transferfee?></td>
</tr>
<tr>
	<td class="nl">开户银行名称：</td>
	<td><?=$rowb['bankname']?></td>
</tr>
<tr>
	<td class="nl">银行卡账号：</td>
	<td>***************<?=substr($rowb['cardno'],-4)?></td>
</tr>
<?php if($transferfee>0){?>
<tr>
	<td class="nl" style="color:#006600;">友情提示：</td>
	<td style="color:#0099FF;">您的投注金额低于充值金额的&nbsp;<font color="#FF0000" size="+1">10%</font>，提款需要特别申请，请联系在线客服处理，如果您已经申请了，请继续。</td>
</tr>
<?php }?>
<tr>
	<td colspan="2"><br/>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<button name="submit" type="submit" width='69' height='26' class="btn_submit" /></button>
		注: <font color='#FF3300'>实扣金额、手续费、到账金额以本页数据为准。</font><br/><br/>
	</td>
</tr>
</form>
</table>
</div>

<div id="footer"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td align="center"><table align="center" width="450">
<tr><td align="left">浏览器建议：首选IE 8.0浏览器，其次为火狐浏览器。</td></tr>
</table></td></tr><tr><td></td></tr></table></div>
<br/><br/>
</div></div>
<?php echo $count;?>
</BODY></HTML>