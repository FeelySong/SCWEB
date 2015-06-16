<?php
session_start();
error_reporting(0);
require_once 'conn.php';
require_once 'check.php';

$uid = $_REQUEST['uid'];
$starttime = $_REQUEST['starttime'];
$endtime=$_REQUEST['endtime'];


if($starttime==""){
	if(date("H:i:s")<"03:00:00"){
		$starttime=date("Y-m-d",strtotime("-1 day"))." 03:00:00";
	}else{
		$starttime=date("Y-m-d")." 03:00:00";
	}
}
	$s1=$s1." and adddate>='".$starttime."'";

if($endtime==""){
	if(date("H:i:s")<"03:00:00"){
		$endtime=date("Y-m-d")." 03:00:00";
	}else{
		$endtime=date("Y-m-d",strtotime("+1 day"))." 03:00:00";
	}
}
	$s1=$s1." and adddate<='".$endtime."'";

if($uid!=""){
	$s1=$s1." and username='".$uid."'";
}else{
	$s1=$s1." and username='".$_SESSION["username"] ."'";
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD><TITLE><?php echo $webname;?>  - 游戏明细</TITLE>
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
 - 游戏明细 </SPAN><DIV style="clear:both"></DIV></H1>
<script type="text/javascript" src="js/calendar/jquery.dyndatetime.js"></script>
<script type="text/javascript" src="js/calendar/lang/calendar-utf8.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="js/calendar/css/calendar-blue2.css"  />
<p>
  <script>
jQuery(document).ready(function() {
	jQuery("#starttime").dynDateTime({
		ifFormat: "%Y-%m-%d %H:%M:00",
		daFormat: "%l;%M %p, %e %m,  %Y",
		align: "Br",
		electric: true,
		singleClick: false,
		button: ".next()", //next sibling
		showOthers: true,
		weekNumbers: true,
		showsTime: true
	});
	jQuery("#starttime").change(function(){
		if(! validateInputDate(jQuery("#starttime").val()) )
		{jQuery("#starttime").val('');$.alert("时间格式不正确,正确的格式为:2011-01-01 12:01");}
	});
	jQuery("#endtime").dynDateTime({
		ifFormat: "%Y-%m-%d %H:%M:00",
		daFormat: "%l;%M %p, %e %m,  %Y",
		align: "Br",
		electric: true,
		singleClick: false,
		button: ".next()", //next sibling
		showOthers: true,
		weekNumbers: true,
		showsTime: true
	});
});
  </script>

<div class="right_02 d5d8de" style="width:98%;margin-bottom:10px;">
<div class="height5">
<div class="right_02_28"></div>
<div class="right_02_29"></div>
</div>
<div class="list-div" style="margin-left:10px;margin-bottom:5px;">
<form action="" method="get" class="list-form">
<input type="hidden" name="controller" value="report">
<input type="hidden" name="action" value="reportdetail">
<input type="hidden" name="userid" value="80094">
<img src="images/icon_search.gif" width="26" height="22" border="0" TITLE="SEARCH" />
开始时间:<input type="text" name="starttime" id="starttime" value="<?=$starttime?>">
<img class='icons_mb4' src="images/comm/t.gif" />
结束时间:<input type="text" name="endtime" id="endtime" value="<?=$endtime?>">
<img class='icons_mb4' src="images/comm/t.gif" />
<button name="submit" type="submit" width='69' height='26' class="btn_search" /></button>
</form>
</div>
<div class="ld">
<table class="lt" border="0" cellspacing="0" cellpadding="0">
	<tr class='th'>
        <td height="25" align="center">游戏</td>
        <td align="center">玩法</td>
        <td align="center">总代购费</td>
        <td align="center">实际总代购费</td>
        <td align="center">中奖金额</td>
        <td align="center">总结算</td>
    </tr>
<?php 
for($i=1;$i<12;$i=$i+1){
	$sqla="select * from ssc_class where cid='".$i."'";
	$rsa = mysql_query($sqla);
	$total = mysql_num_rows($rsa);
	$ii=1;
	$tgmoney=0;
	$tfmoney=0;
	$twmoney=0;
	while ($rowa = mysql_fetch_array($rsa)){
		$sqlb="select sum(zmoney) as sgmoney from ssc_record where mid='".$rowa['mid']."' and types='7'".$s1;
		$rsb = mysql_query($sqlb);
		$rowb = mysql_fetch_array($rsb);
		$gmoney=$rowb['sgmoney'];
		$tgmoney=$tgmoney+$gmoney;
		$sqlb="select sum(smoney) as sfmoney from ssc_record where mid='".$rowa['mid']."' and types='11'".$s1;
		$rsb = mysql_query($sqlb);
		$rowb = mysql_fetch_array($rsb);
		$fmoney=$rowb['sfmoney'];
		$tfmoney=$tfmoney+$fmoney;
		$sqla="select sum(smoney) as swmoney from ssc_record where mid='".$rowa['mid']."' and types='12'".$s1;
		$rsb = mysql_query($sqlb);
		$rowb = mysql_fetch_array($rsb);
		$wmoney=$rowb['swmoney'];
		$twmoney=$twmoney+$wmoney;
?>
<tr align="center">
<?php if($ii==1){?>
<td rowspan="<?=$total?>" style="border-right:1px #E5E5E5 solid;"><?=$rowa['cname']?></td><?php }?>
<td><?=$rowa['name']?></td>
<td height="37"><?=number_format($gmoney,4)?></td>
<td><?=number_format($gmoney-$fmoney,4)?></td>
<td><?=number_format($wmoney,4)?></td>
<td style="border-right:1px #E5E5E5 solid;"><?=number_format(abs($gmoney-$fmoney-$wmoney),4)?></td>
</tr>
<?php
		$ii=$ii+1;
 }?>
<tr align="center">
<td height="37" colspan="2" style="background-color:#FFFF99;">小结</td>
<td style="background-color:#FFFF99;"><?=number_format($tgmoney,4)?></td>
<td style="background-color:#FFFF99;"><?=number_format($tgmoney-$tfmoney,4)?></td>
<td style="background-color:#FFFF99;"><?=number_format($twmoney,4)?></td>
<td style="background-color:#FFFF99;"><?=number_format(abs($tgmoney-$tfmoney-$twmoney),4)?></td>
</tr>
<?php }?>
</table>
</div>
<div class="height5">
<div class="right_02_24"></div>
<div class="right_02_25"></div>
</div>
</div>  <div id="footer"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td align="center"><table align="center" width="450">
<tr><td align="left">浏览器建议：首选IE 8.0浏览器，其次为火狐浏览器。</td></tr>
</table></td></tr><tr><td></td></tr></table></div>
<br/><br/>
</div></div>
<?php echo $count?>
</BODY></HTML>