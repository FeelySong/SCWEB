<?php
session_start();
error_reporting(0);
require_once 'conn.php';
require_once 'check.php';

	$sql="select * from ssc_savelist where id= ".$_GET['id'];
	$query = mysql_query($sql);
	$row = mysql_fetch_array($query);

	$sqla = "SELECT * FROM ssc_banks WHERE id='" . $row['bankid'] . "'";
	$rsa = mysql_query($sqla);
	$rowa = mysql_fetch_array($rsa);

if($_POST['flag']=="cancel"){
    $sqla="update ssc_savelist set zt='3' where id='".$_POST['hashid']."'";
    $exe=mysql_query($sqla) or  die("数据库修改出错6!!!".mysql_error());
    
        $_SESSION["backtitle"]="操作成功, 充值申请已撤销";
        $_SESSION["backurl"]="account_savelist.php?check=952";
        $_SESSION["backzt"]="successed";
        $_SESSION["backname"]="充值记录";
        echo "<script language=javascript>window.location='sysmessage.php';</script>";
        exit;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD><TITLE><?php echo $webname;?>  - 充值记录详情</TITLE>
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
<BODY STYLE="background:#fff; padding:10px;">
 

<DIV ID='main_box'>
<div class="box l"></div>
<div class="box c"></div>
<div class="box r"></div>
<div class="box m">

<H1><SPAN class="action-span"><A href="./account_savelist.php?check=952" target='_self'>充值记录</a></SPAN><SPAN class="action-span"><A href="./account_autosave.php?check=952" target='_self'>自动充值</a></SPAN>
<SPAN class="action-span1">
<DIV class='icons_mb1'></DIV>当前位置: <A href="/" target='_top'><?php echo $webname;?></a>
 - 充值记录详情 </SPAN><DIV style="clear:both"></DIV></H1>
<script type="text/javascript">
jQuery(document).ready(function() {
jQuery("#chineseMoney").html( changeMoneyToChinese( <?=$row['money']?> ) )
var demoleft = $("#showdemo").offset();
demoleft = demoleft.left +100;
$("#demobox").css({"left":demoleft+"px"});
$("#showdemo").click(function(){
	if($(this).val()=='充值演示'){
		$("#demobox").show();
		$(this).val("关闭演示");
	}else{
		$("#demobox").hide();
		$(this).val("充值演示");
	}
});
});
function checkForm(obj)
{
	return confirm("确定撤销这条充值?");
}
</script>
<div class="ld">
<div id="demobox" style="position:absolute; display:none; margin-top:-40px; z-index:100; float:right;"><img src="images/help/czys<?=$row['bankid']?>.png" style="border:2px solid #999999;" /></div>
<table class="ct" align="center" border="0" cellspacing="0" cellpadding="0">
<form action="" method="post" onsubmit="return checkForm(this)">
<input type="hidden" name="flag" value="cancel" />
<input type="hidden" name="hashid" value="<?=$row['id']?>" />
  <tr><td class="nl">充值单号:</td><td><?=$row['dan']?></td></tr>
  <tr><td class="nl">实际充值金额:</td><td><span id='realin'><?=number_format($row['money'],2)?></span></td></tr>
  <tr><td class="nl">实际充值金额(大写):</td><td><span id="chineseMoney"></span></td></tr>
  <tr><td class="nl">返还手续费:</td><td><?=$row['sxmoney']?></td></tr>
  <tr><td class="nl">上分金额:</td><td><?=$row['rmoney']?></td></tr>
  <tr><td class="nl">申请发起时间:</td><td><?=$row['adddate']?></td></tr>
  <tr><td class="nl">充值银行:</td><td><img src="images/banks/<?php if($row['bank']=="财付通"){echo "19";}else if($row['bank']=="中国工商银行"){echo "1";}?>.jpg" border="0" title="<?=$row['bank']?>" />&nbsp;&nbsp;&nbsp;</td></tr>
    <tr><td class="nl">状态:</td><td><?php if($row['zt']==1){echo "<font color=#669900>充值成功</font>";}else if($row['zt']==0){?><font color=#999999>等待处理</font>&nbsp;&nbsp;&nbsp; <input type="submit" name="submit" value="撤销充值" class="button" />&nbsp;&nbsp;<input type="button" name="showdemo" id="showdemo" value="充值演示" class="button" /><?php }else if($row['zt']==2){echo "<font color=#999999>充值失败</font>";}else if($row['zt']==3){echo "<font color=#999999>用户撤消</font>";}?>
  </td></tr>
  </table>
</div>
<div id="footer"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td align="center"><table align="center" width="450">
<tr><td align="left">浏览器建议：首选IE 8.0浏览器，其次为火狐浏览器。</td></tr>
</table></td></tr><tr><td></td></tr></table></div>
<br/><br/>
</div></div>
<?php echo $count?>
</BODY></HTML>