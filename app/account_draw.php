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

$sqla = "select * from ssc_member WHERE username='" . $_SESSION["username"] . "'";
$rsa = mysql_query($sqla);
$rowa = mysql_fetch_array($rsa);
$leftmoney=$rowa['leftmoney'];

$sql = "select * from ssc_drawlist WHERE username='" . $_SESSION["username"] . "' and DATE_FORMAT( adddate, '%Y-%m-%d' )='".date("Y-m-d")."'";
$rs = mysql_query($sql);
$txnums=mysql_num_rows($rs);

if($rowa['cwpwd']==""){
	$_SESSION["cwurl"]="account_draw.php";
	echo "<script language=javascript>window.location='account_setpwd.php';</script>";
	exit;
}
if($_GET['check']!="914"){
	if($_SESSION["cwflag"]!="ok"){
		$_SESSION["cwurl"]="account_draw.php";
		echo "<script language=javascript>window.location='account_check.php';</script>";
		exit;
	}
}
$_SESSION["cwflag"]="";
$sqla = "select * from ssc_bankcard WHERE  username='" . $_SESSION["username"] . "'";
$rsa = mysql_query($sqla);
$cardnums=mysql_num_rows($rsa);
if($cardnums==0){
	$_SESSION["backtitle"]="操作失败，请先绑定银行卡";
	$_SESSION["backurl"]="account_banks.php?check=114";
	$_SESSION["backzt"]="failed";
	$_SESSION["backname"]="我的银行卡";
	echo "<script language=javascript>window.location='sysmessage.php';</script>";
	exit;
}

$flag=$_REQUEST['flag'];
if($flag=="confirm"){
	$ntime=date("Y-m-d H:i:s",strtotime("-".$txhours." hour"));
	$sqlb = "select * from ssc_bankcard WHERE id='".$_REQUEST['bankinfo']."'";
	$rsb = mysql_query($sqlb);
	$rowb = mysql_fetch_array($rsb);
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
			
			$sql = "insert into ssc_drawlist set dan='".$dan."', money='".$_REQUEST['real_money']."', sxmoney='0', rmoney='".$_REQUEST['real_money']."', bank='".$rowb['bankname']."', realname='".$rowb['realname']."', cardno='".$rowb['cardno']."', branch='".$rowb['bankbranch']."', province='".Get_province($rowb['province'])."', city='".Get_city($rowb['city'])."', uid='".$_SESSION["sess_uid"]."', username='".$_SESSION["username"] ."', adddate='".date("Y-m-d H:i:s")."'";
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
<HEAD><TITLE><?php echo $webname;?>  - 提现申请</TITLE>
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

<H1><SPAN class="action-span"><A href="account_drawlist.php?check=914" target='_self'>提现记录</a></SPAN><SPAN class="action-span  zhuangtai"><A href="account_draw.php?check=914" target='_self'>平台提现</a></SPAN><SPAN class="action-span"><A href="account_autosave.php?check=952
" target='_self'>自动充值</a></SPAN>
<SPAN class="action-span1"><DIV class='tubiao'></DIV>当前位置: <A href="/" target='_top'><?php echo $webname;?></a>
 - 自动充值 </SPAN><DIV style="clear:both"></DIV></H1>
<script type="text/javascript">
function checkForm(obj)
{
		if (obj.real_money.value == ""){
		alert("请填写 '提现金额'");
		obj.real_money.focus();
		return false;
	}
	if(obj.real_money.value < <?=$txmin?>)
	{
		alert("提现金额不能低于最低提现限额 ");
		$("#real_money").val(<?=$txmin?>);
		showPaymentFee(<?=$txmin?>);
		return false;
	}
	if(obj.real_money.value > <?=$txmax?>)
	{
		alert("提现金额不能高于最大提现限额 ");
		$("#real_money").val(<?=$txmax?>);
		showPaymentFee(<?=$txmax?>);
		return false;
	}
	if(obj.real_money.value > <?=$rowa['leftmoney']?>)
	{
		alert("提现金额不能高于您的账户余额 ");
		$("#real_money").val(<?=$rowa['leftmoney']?>);
		showPaymentFee(<?=$rowa['leftmoney']?>);
		return false;
	}
	if( obj.bankinfo.value == "" )
	{
		alert("请选择收款银行卡");
		return false;
	}
}
function showPaymentFee(i){
	document.drawform.real_money.value = formatFloat(""+i);
	document.drawform.money.value = FormatNumber( i ,2);
	jQuery("#chineseMoney").html( changeMoneyToChinese(document.drawform.money.value) );
}


/* format number 0.00 */
function FormatNumber(srcStr, nAfterDot){
	var srcStr,nAfterDot;
	var resultStr,nTen;
	srcStr = ""+srcStr+"";
	strLen = srcStr.length;
	dotPos = srcStr.indexOf(".",0);
	if (dotPos == -1){
	   resultStr = srcStr+".";
	   for (i=0; i<nAfterDot; i++){
	    resultStr = resultStr+"0";
	   }
	   
	}
	else{
	   if ((strLen - dotPos - 1) >= nAfterDot){
		   
	    nAfter = dotPos + nAfterDot + 1;
	    nTen =1;
	    for(j=0;j<nAfterDot;j++){
	     nTen = nTen*10;
	    }
	    resultStr = Math.round(parseFloat(srcStr)*nTen)/nTen;
	   }
	   else{
	    resultStr = srcStr;
	    
	    for (i=0;i<(nAfterDot - strLen + dotPos + 1);i++){
	     resultStr = resultStr+"0";
	    }
	    
	   }
	}
	return resultStr;
}
</script>

<div class="tab-div">
	<!--<div id="tabbar-div">
		  <span class="tab-front"  id="general_tab_0">
		  <span class="tabbar-left"></span>
		  <span class="content">提现申请</span>
		  <span class="tabbar-right"></span>
		</span>
	    <span class="tab-back"  id="general_tab_1">
		    <span class="tabbar-left"></span>
		    <span class="content" onclick="window.location.href='./account_drawlist.php?check=914'">提现记录</span>
		    <span class="tabbar-right"></span>
		</span>
	</div>-->

<div class="ld" style='width:99%;margin:5px 0px 0px 0px;'>
<table width="100%" class="ct" border="0" cellspacing="0" cellpadding="0">
<form action="account_draws.php?check=914" method="post" name="drawform" id="drawform" onsubmit="return checkForm(this)">
<input type="hidden" name="flag" value="confirm" />
<input type="hidden" name="money" value="" />
<input type="hidden" name='transferfee' id='transferfee' value=''/>
<tr>
	<td class="nl"><font color="#FF3300">提示信息：</font></td>
	<td STYLE='line-height:20px;padding:5px 0px'>每天限提&nbsp;<font style="font-size:16px;color:#F30;font-weight:bold;"> <?=$txtnums?> </font>&nbsp;次，今天您已经成功发起了&nbsp;<font style="font-size:16px;color:#690;font-weight:bold;"><?=$txnums?></font>&nbsp;次提现申请。<br/>
	每天的提现处理时间为：<font style="font-size:16px;color:#F30;font-weight:bold;">早上 10:00 至 次日凌晨 2:00</font><br/>
    <font color="#0066FF">新绑定的提款银行卡需要绑定时间超过&nbsp;<font style="font-size:16px;color:#F30;font-weight:bold;"><?=$txhours?></font>&nbsp;小时才能正常提款。</font><font color="#FF0000">（新）</font>
	</td>
</tr>
<tr>
	<td class="nl">可提现金额：</td>
	<td><?=$rowa['leftmoney']?></td>
</tr>
<tr>
	<td class="nl">收款银行卡信息：</td>
    <td>
    	<select name="bankinfo" id="bankinfo">
			<option value="">请选择银行卡...</option>
<?php 
$sqlb = "select ssc_bankcard.* from ssc_bankcard left join ssc_banks on ssc_bankcard.bankid=ssc_banks.tid WHERE ssc_bankcard.username='" . $_SESSION["username"] . "' and ssc_banks.zt3='1'";
$rsb = mysql_query($sqlb);
while ($rowb = mysql_fetch_array($rsb)){
?>
				<option value="<?=$rowb['id']?>"><?=Get_bank($rowb['bankid'])?> | <?=$rowb['id']?>银行卡尾号: <?=substr($rowb['cardno'],-4)?> </option>
<?php }?>
    		    	</select>&nbsp;&nbsp;<span style="color:red;"></span>
    </td>
</tr>
<tr>
	<td class="nl">提现金额：</td>
    <td><input type="text" name="real_money" id="real_money" onkeyup="showPaymentFee(this.value);" />&nbsp;&nbsp;<span style="color:red;"></span> ( 单笔提现限额：最低：&nbsp;<font style="color:#FF3300"><?=$txmin?></font>&nbsp;元，最高：&nbsp;<font style="color:#FF3300"><?=$txmax?></font>&nbsp;元 ) </td>
</tr>
<!--<tr>
	<td class="nl">实扣金额：</td>
    <td id="real_withdraw">&nbsp;</td>
</tr>
<tr>
	<td class="nl">提现手续费：</td>
    <td id="charge">&nbsp;</td>
</tr>
<tr>
	<td class="nl">到账金额：</td>
    <td id="money">&nbsp;</td>
</tr>-->
<tr>
	<td class="nl">提现金额(大写)：</td>
    <td>&nbsp;<span id="chineseMoney"></span><input type="hidden" id="hiddenchinese" /></td>
</tr>
<tr>
	<td class="nl"></td>
	<td height="30"><br/><button name="submit" type="submit" width='69' height='26' class="btn_next" /></button><br/><br/></td>
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