<?php
session_start();
error_reporting(0);
require_once 'conn.php';
require_once 'check.php';

$uid = $_REQUEST['uid'];
$lottery = $_REQUEST['lottery'];
$method = $_REQUEST['method'];
$starttime = $_REQUEST['starttime'];
$endtime=$_REQUEST['endtime'];
$proxyid = $_REQUEST['proxyid'];
$isrequery = $_REQUEST['isrequery'];


if($starttime==""){
	if(date("H:i:s")<"03:00:00"){
		$starttime=date("Y-m-d",strtotime("-1 day"));
	}else{
		$starttime=date("Y-m-d");
	}
}
	$s1=$s1." and adddate>='".$starttime."'";

if($endtime==""){
	if(date("H:i:s")<"03:00:00"){
		$endtime=date("Y-m-d");
	}else{
		$endtime=date("Y-m-d",strtotime("+1 day"));
	}
}
	$s1=$s1." and adddate<='".$endtime."'";


if($proxyid!="" && $proxyid!="0"){
	$uid=$proxyid;
}

if($uid!=""){
	$s2=$s2." and (regup='".$uid."' or username='".$uid."')";
}else{
	$s2=$s2." and (regup='".$_SESSION["username"] ."' or username='".$_SESSION["username"] ."')";
}

if($isrequery!="1"){
	$s2=$s2." and 1=0";	
}

$s2=$s2." order by id asc";
$sql="select * from  ssc_fenhong where username='".$_SESSION["username"]."' ";
$rs = mysql_query($sql);
$total = mysql_num_rows($rs);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD><TITLE><?php echo $webname;?>  - 报表查询</TITLE>
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
<!--<SPAN class="action-span"><A href="report_today.php" target='_self'>今日报表</a></SPAN>-->
<SPAN class="action-span zhuangtai"><A href="report_game.php" target='_self'>分红查询</a></SPAN>
<SPAN class="action-span1"><DIV class='icons_mb1'></DIV>当前位置: <A href="/" target='_top'><?php echo $webname;?></a>
 - 分红查询 </SPAN><DIV style="clear:both"></DIV></H1>
<script type="text/javascript" src="js/calendar/jquery.dyndatetime.js"></script>
<script type="text/javascript" src="js/calendar/lang/calendar-utf8.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="js/calendar/css/calendar-blue2.css"  />
<script>
jQuery(document).ready(function() {
	jQuery("#starttime").dynDateTime({
		ifFormat: "%Y-%m-%d %H:%M:00",
		daFormat: "%l;%M %p, %e %m,  %Y",
		align: "Br",
		electric: true,
		singleClick: false,
		button: ".next()", //next sibling
		onUpdate:function(){
			$("#starttime").change();
		},
		showOthers: true,
		weekNumbers: true,
		showsTime: true
	});
	jQuery("#starttime").change(function(){
		if(! validateInputDate(jQuery("#starttime").val()) )
		{
			jQuery("#starttime").val('');
			alert("时间格式不正确,正确的格式为:2011-01-01 10:59");
		}
		if($("#endtime").val()!="")
		{
			if($("#starttime").val()>$("#endtime").val())
			{
				$("#starttime").val("");
				alert("输入的时间不符合逻辑, 起始时间大于结束时间");
			}
		}
	});
	jQuery("#endtime").dynDateTime({
		ifFormat: "%Y-%m-%d %H:%M:00",
		daFormat: "%l;%M %p, %e %m,  %Y",
		align: "Br",
		electric: true,
		singleClick: false,
		button: ".next()", //next sibling
		showOthers: true,
		onUpdate:function(){
			$("#endtime").change();
		},
		weekNumbers: true,
		showsTime: true
	});
	jQuery("#endtime").change(function(){
		if(! validateInputDate(jQuery("#endtime").val()) )
		{
			jQuery("#endtime").val('');
			alert("时间格式不正确,正确的格式为:2011-01-01 12:23");
		}
		if($("#starttime").val()!="")
		{
			if($("#starttime").val()>$("#endtime").val())
			{
				$("#endtime").val("");
				alert("输入的时间不符合逻辑, 起始时间大于结束时间");
			}
		}
	});
	jQuery("#lottery").change(function(){
		var data_method = {"1":{"14":{"lotteryid":"1","methodid":"14","methodname":"\u524d\u4e09\u76f4\u9009"},"15":{"lotteryid":"1","methodid":"15","methodname":"\u524d\u4e09\u76f4\u9009_\u548c\u503c"},"16":{"lotteryid":"1","methodid":"16","methodname":"\u540e\u4e09\u76f4\u9009"},"17":{"lotteryid":"1","methodid":"17","methodname":"\u540e\u4e09\u76f4\u9009_\u548c\u503c"},"18":{"lotteryid":"1","methodid":"18","methodname":"\u524d\u4e09\u7ec4\u9009_\u7ec4\u4e09"},"19":{"lotteryid":"1","methodid":"19","methodname":"\u524d\u4e09\u7ec4\u9009_\u7ec4\u516d"},"20":{"lotteryid":"1","methodid":"20","methodname":"\u524d\u4e09\u7ec4\u9009_\u6df7\u5408"},"21":{"lotteryid":"1","methodid":"21","methodname":"\u524d\u4e09\u7ec4\u9009_\u548c\u503c"},"22":{"lotteryid":"1","methodid":"22","methodname":"\u540e\u4e09\u7ec4\u9009_\u7ec4\u4e09"},"23":{"lotteryid":"1","methodid":"23","methodname":"\u540e\u4e09\u7ec4\u9009_\u7ec4\u516d"},"24":{"lotteryid":"1","methodid":"24","methodname":"\u540e\u4e09\u7ec4\u9009_\u6df7\u5408"},"25":{"lotteryid":"1","methodid":"25","methodname":"\u540e\u4e09\u7ec4\u9009_\u548c\u503c"},"26":{"lotteryid":"1","methodid":"26","methodname":"\u4e00\u7801\u4e0d\u5b9a\u4f4d"},"27":{"lotteryid":"1","methodid":"27","methodname":"\u4e8c\u7801\u4e0d\u5b9a\u4f4d"},"28":{"lotteryid":"1","methodid":"28","methodname":"\u524d\u4e8c\u76f4\u9009"},"29":{"lotteryid":"1","methodid":"29","methodname":"\u540e\u4e8c\u76f4\u9009"},"30":{"lotteryid":"1","methodid":"30","methodname":"\u524d\u4e8c\u7ec4\u9009"},"31":{"lotteryid":"1","methodid":"31","methodname":"\u540e\u4e8c\u7ec4\u9009"},"32":{"lotteryid":"1","methodid":"32","methodname":"\u4e07\u4f4d"},"33":{"lotteryid":"1","methodid":"33","methodname":"\u5343\u4f4d"},"34":{"lotteryid":"1","methodid":"34","methodname":"\u767e\u4f4d"},"35":{"lotteryid":"1","methodid":"35","methodname":"\u5341\u4f4d"},"36":{"lotteryid":"1","methodid":"36","methodname":"\u4e2a\u4f4d"},"37":{"lotteryid":"1","methodid":"37","methodname":"\u524d\u4e8c\u5927\u5c0f\u5355\u53cc"},"38":{"lotteryid":"1","methodid":"38","methodname":"\u540e\u4e8c\u5927\u5c0f\u5355\u53cc"}},"2":{"52":{"lotteryid":"2","methodid":"52","methodname":"\u524d\u4e09\u76f4\u9009"},"53":{"lotteryid":"2","methodid":"53","methodname":"\u524d\u4e09\u76f4\u9009_\u548c\u503c"},"54":{"lotteryid":"2","methodid":"54","methodname":"\u540e\u4e09\u76f4\u9009"},"55":{"lotteryid":"2","methodid":"55","methodname":"\u540e\u4e09\u76f4\u9009_\u548c\u503c"},"56":{"lotteryid":"2","methodid":"56","methodname":"\u524d\u4e09\u7ec4\u9009_\u7ec4\u4e09"},"57":{"lotteryid":"2","methodid":"57","methodname":"\u524d\u4e09\u7ec4\u9009_\u7ec4\u516d"},"58":{"lotteryid":"2","methodid":"58","methodname":"\u524d\u4e09\u7ec4\u9009_\u6df7\u5408"},"59":{"lotteryid":"2","methodid":"59","methodname":"\u524d\u4e09\u7ec4\u9009_\u548c\u503c"},"60":{"lotteryid":"2","methodid":"60","methodname":"\u540e\u4e09\u7ec4\u9009_\u7ec4\u4e09"},"61":{"lotteryid":"2","methodid":"61","methodname":"\u540e\u4e09\u7ec4\u9009_\u7ec4\u516d"},"62":{"lotteryid":"2","methodid":"62","methodname":"\u540e\u4e09\u7ec4\u9009_\u6df7\u5408"},"63":{"lotteryid":"2","methodid":"63","methodname":"\u540e\u4e09\u7ec4\u9009_\u548c\u503c"},"64":{"lotteryid":"2","methodid":"64","methodname":"\u4e00\u7801\u4e0d\u5b9a\u4f4d"},"65":{"lotteryid":"2","methodid":"65","methodname":"\u4e8c\u7801\u4e0d\u5b9a\u4f4d"},"66":{"lotteryid":"2","methodid":"66","methodname":"\u524d\u4e8c\u76f4\u9009"},"67":{"lotteryid":"2","methodid":"67","methodname":"\u540e\u4e8c\u76f4\u9009"},"68":{"lotteryid":"2","methodid":"68","methodname":"\u524d\u4e8c\u7ec4\u9009"},"69":{"lotteryid":"2","methodid":"69","methodname":"\u540e\u4e8c\u7ec4\u9009"},"70":{"lotteryid":"2","methodid":"70","methodname":"\u4e07\u4f4d"},"71":{"lotteryid":"2","methodid":"71","methodname":"\u5343\u4f4d"},"72":{"lotteryid":"2","methodid":"72","methodname":"\u767e\u4f4d"},"73":{"lotteryid":"2","methodid":"73","methodname":"\u5341\u4f4d"},"74":{"lotteryid":"2","methodid":"74","methodname":"\u4e2a\u4f4d"},"75":{"lotteryid":"2","methodid":"75","methodname":"\u524d\u4e8c\u5927\u5c0f\u5355\u53cc"},"76":{"lotteryid":"2","methodid":"76","methodname":"\u540e\u4e8c\u5927\u5c0f\u5355\u53cc"}},"3":{"90":{"lotteryid":"3","methodid":"90","methodname":"\u524d\u4e09\u76f4\u9009"},"91":{"lotteryid":"3","methodid":"91","methodname":"\u524d\u4e09\u76f4\u9009_\u548c\u503c"},"92":{"lotteryid":"3","methodid":"92","methodname":"\u540e\u4e09\u76f4\u9009"},"93":{"lotteryid":"3","methodid":"93","methodname":"\u540e\u4e09\u76f4\u9009_\u548c\u503c"},"94":{"lotteryid":"3","methodid":"94","methodname":"\u524d\u4e09\u7ec4\u9009_\u7ec4\u4e09"},"95":{"lotteryid":"3","methodid":"95","methodname":"\u524d\u4e09\u7ec4\u9009_\u7ec4\u516d"},"96":{"lotteryid":"3","methodid":"96","methodname":"\u524d\u4e09\u7ec4\u9009_\u6df7\u5408"},"97":{"lotteryid":"3","methodid":"97","methodname":"\u524d\u4e09\u7ec4\u9009_\u548c\u503c"},"98":{"lotteryid":"3","methodid":"98","methodname":"\u540e\u4e09\u7ec4\u9009_\u7ec4\u4e09"},"99":{"lotteryid":"3","methodid":"99","methodname":"\u540e\u4e09\u7ec4\u9009_\u7ec4\u516d"},"100":{"lotteryid":"3","methodid":"100","methodname":"\u540e\u4e09\u7ec4\u9009_\u6df7\u5408"},"101":{"lotteryid":"3","methodid":"101","methodname":"\u540e\u4e09\u7ec4\u9009_\u548c\u503c"},"102":{"lotteryid":"3","methodid":"102","methodname":"\u4e00\u7801\u4e0d\u5b9a\u4f4d"},"103":{"lotteryid":"3","methodid":"103","methodname":"\u4e8c\u7801\u4e0d\u5b9a\u4f4d"},"104":{"lotteryid":"3","methodid":"104","methodname":"\u524d\u4e8c\u76f4\u9009"},"105":{"lotteryid":"3","methodid":"105","methodname":"\u540e\u4e8c\u76f4\u9009"},"106":{"lotteryid":"3","methodid":"106","methodname":"\u524d\u4e8c\u7ec4\u9009"},"107":{"lotteryid":"3","methodid":"107","methodname":"\u540e\u4e8c\u7ec4\u9009"},"108":{"lotteryid":"3","methodid":"108","methodname":"\u4e07\u4f4d"},"109":{"lotteryid":"3","methodid":"109","methodname":"\u5343\u4f4d"},"110":{"lotteryid":"3","methodid":"110","methodname":"\u767e\u4f4d"},"111":{"lotteryid":"3","methodid":"111","methodname":"\u5341\u4f4d"},"112":{"lotteryid":"3","methodid":"112","methodname":"\u4e2a\u4f4d"},"113":{"lotteryid":"3","methodid":"113","methodname":"\u524d\u4e8c\u5927\u5c0f\u5355\u53cc"},"114":{"lotteryid":"3","methodid":"114","methodname":"\u540e\u4e8c\u5927\u5c0f\u5355\u53cc"}},"4":{"128":{"lotteryid":"4","methodid":"128","methodname":"\u524d\u4e09\u76f4\u9009"},"129":{"lotteryid":"4","methodid":"129","methodname":"\u524d\u4e09\u76f4\u9009_\u548c\u503c"},"130":{"lotteryid":"4","methodid":"130","methodname":"\u540e\u4e09\u76f4\u9009"},"131":{"lotteryid":"4","methodid":"131","methodname":"\u540e\u4e09\u76f4\u9009_\u548c\u503c"},"132":{"lotteryid":"4","methodid":"132","methodname":"\u524d\u4e09\u7ec4\u9009_\u7ec4\u4e09"},"133":{"lotteryid":"4","methodid":"133","methodname":"\u524d\u4e09\u7ec4\u9009_\u7ec4\u516d"},"134":{"lotteryid":"4","methodid":"134","methodname":"\u524d\u4e09\u7ec4\u9009_\u6df7\u5408"},"135":{"lotteryid":"4","methodid":"135","methodname":"\u524d\u4e09\u7ec4\u9009_\u548c\u503c"},"136":{"lotteryid":"4","methodid":"136","methodname":"\u540e\u4e09\u7ec4\u9009_\u7ec4\u4e09"},"137":{"lotteryid":"4","methodid":"137","methodname":"\u540e\u4e09\u7ec4\u9009_\u7ec4\u516d"},"138":{"lotteryid":"4","methodid":"138","methodname":"\u540e\u4e09\u7ec4\u9009_\u6df7\u5408"},"139":{"lotteryid":"4","methodid":"139","methodname":"\u540e\u4e09\u7ec4\u9009_\u548c\u503c"},"140":{"lotteryid":"4","methodid":"140","methodname":"\u4e00\u7801\u4e0d\u5b9a\u4f4d"},"141":{"lotteryid":"4","methodid":"141","methodname":"\u4e8c\u7801\u4e0d\u5b9a\u4f4d"},"142":{"lotteryid":"4","methodid":"142","methodname":"\u524d\u4e8c\u76f4\u9009"},"143":{"lotteryid":"4","methodid":"143","methodname":"\u540e\u4e8c\u76f4\u9009"},"144":{"lotteryid":"4","methodid":"144","methodname":"\u524d\u4e8c\u7ec4\u9009"},"145":{"lotteryid":"4","methodid":"145","methodname":"\u540e\u4e8c\u7ec4\u9009"},"146":{"lotteryid":"4","methodid":"146","methodname":"\u4e07\u4f4d"},"147":{"lotteryid":"4","methodid":"147","methodname":"\u5343\u4f4d"},"148":{"lotteryid":"4","methodid":"148","methodname":"\u767e\u4f4d"},"149":{"lotteryid":"4","methodid":"149","methodname":"\u5341\u4f4d"},"150":{"lotteryid":"4","methodid":"150","methodname":"\u4e2a\u4f4d"},"151":{"lotteryid":"4","methodid":"151","methodname":"\u524d\u4e8c\u5927\u5c0f\u5355\u53cc"},"152":{"lotteryid":"4","methodid":"152","methodname":"\u540e\u4e8c\u5927\u5c0f\u5355\u53cc"}},"5":{"164":{"lotteryid":"5","methodid":"164","methodname":"\u76f4\u9009"},"165":{"lotteryid":"5","methodid":"165","methodname":"\u76f4\u9009_\u548c\u503c"},"166":{"lotteryid":"5","methodid":"166","methodname":"\u7ec4\u4e09"},"167":{"lotteryid":"5","methodid":"167","methodname":"\u7ec4\u516d"},"168":{"lotteryid":"5","methodid":"168","methodname":"\u6df7\u5408\u7ec4\u9009"},"169":{"lotteryid":"5","methodid":"169","methodname":"\u7ec4\u9009\u548c\u503c"},"170":{"lotteryid":"5","methodid":"170","methodname":"\u4e00\u7801\u4e0d\u5b9a\u4f4d"},"171":{"lotteryid":"5","methodid":"171","methodname":"\u4e8c\u7801\u4e0d\u5b9a\u4f4d"},"172":{"lotteryid":"5","methodid":"172","methodname":"\u524d\u4e8c\u76f4\u9009"},"173":{"lotteryid":"5","methodid":"173","methodname":"\u540e\u4e8c\u76f4\u9009"},"174":{"lotteryid":"5","methodid":"174","methodname":"\u524d\u4e8c\u7ec4\u9009"},"175":{"lotteryid":"5","methodid":"175","methodname":"\u540e\u4e8c\u7ec4\u9009"},"176":{"lotteryid":"5","methodid":"176","methodname":"\u767e\u4f4d"},"177":{"lotteryid":"5","methodid":"177","methodname":"\u5341\u4f4d"},"178":{"lotteryid":"5","methodid":"178","methodname":"\u4e2a\u4f4d"},"179":{"lotteryid":"5","methodid":"179","methodname":"\u524d\u4e8c\u5927\u5c0f\u5355\u53cc"},"180":{"lotteryid":"5","methodid":"180","methodname":"\u540e\u4e8c\u5927\u5c0f\u5355\u53cc"}},"6":{"197":{"lotteryid":"6","methodid":"197","methodname":"\u524d\u4e09\u76f4\u9009"},"198":{"lotteryid":"6","methodid":"198","methodname":"\u524d\u4e09\u7ec4\u9009"},"199":{"lotteryid":"6","methodid":"199","methodname":"\u524d\u4e8c\u76f4\u9009"},"200":{"lotteryid":"6","methodid":"200","methodname":"\u524d\u4e8c\u7ec4\u9009"},"201":{"lotteryid":"6","methodid":"201","methodname":"\u524d\u4e09\u4e0d\u5b9a\u4f4d"},"202":{"lotteryid":"6","methodid":"202","methodname":"\u7b2c\u4e00\u4f4d"},"203":{"lotteryid":"6","methodid":"203","methodname":"\u7b2c\u4e8c\u4f4d"},"204":{"lotteryid":"6","methodid":"204","methodname":"\u7b2c\u4e09\u4f4d"},"205":{"lotteryid":"6","methodid":"205","methodname":"\u5b9a\u5355\u53cc"},"206":{"lotteryid":"6","methodid":"206","methodname":"\u731c\u4e2d\u4f4d"},"207":{"lotteryid":"6","methodid":"207","methodname":"\u4efb\u9009\u4e00\u4e2d\u4e00"},"208":{"lotteryid":"6","methodid":"208","methodname":"\u4efb\u9009\u4e8c\u4e2d\u4e8c"},"209":{"lotteryid":"6","methodid":"209","methodname":"\u4efb\u9009\u4e09\u4e2d\u4e09"},"210":{"lotteryid":"6","methodid":"210","methodname":"\u4efb\u9009\u56db\u4e2d\u56db"},"211":{"lotteryid":"6","methodid":"211","methodname":"\u4efb\u9009\u4e94\u4e2d\u4e94"},"212":{"lotteryid":"6","methodid":"212","methodname":"\u4efb\u9009\u516d\u4e2d\u4e94"},"213":{"lotteryid":"6","methodid":"213","methodname":"\u4efb\u9009\u4e03\u4e2d\u4e94"},"214":{"lotteryid":"6","methodid":"214","methodname":"\u4efb\u9009\u516b\u4e2d\u4e94"}},"7":{"231":{"lotteryid":"7","methodid":"231","methodname":"\u524d\u4e09\u76f4\u9009"},"232":{"lotteryid":"7","methodid":"232","methodname":"\u524d\u4e09\u7ec4\u9009"},"233":{"lotteryid":"7","methodid":"233","methodname":"\u524d\u4e8c\u76f4\u9009"},"234":{"lotteryid":"7","methodid":"234","methodname":"\u524d\u4e8c\u7ec4\u9009"},"235":{"lotteryid":"7","methodid":"235","methodname":"\u524d\u4e09\u4e0d\u5b9a\u4f4d"},"236":{"lotteryid":"7","methodid":"236","methodname":"\u7b2c\u4e00\u4f4d"},"237":{"lotteryid":"7","methodid":"237","methodname":"\u7b2c\u4e8c\u4f4d"},"238":{"lotteryid":"7","methodid":"238","methodname":"\u7b2c\u4e09\u4f4d"},"239":{"lotteryid":"7","methodid":"239","methodname":"\u5b9a\u5355\u53cc"},"240":{"lotteryid":"7","methodid":"240","methodname":"\u731c\u4e2d\u4f4d"},"241":{"lotteryid":"7","methodid":"241","methodname":"\u4efb\u9009\u4e00\u4e2d\u4e00"},"242":{"lotteryid":"7","methodid":"242","methodname":"\u4efb\u9009\u4e8c\u4e2d\u4e8c"},"243":{"lotteryid":"7","methodid":"243","methodname":"\u4efb\u9009\u4e09\u4e2d\u4e09"},"244":{"lotteryid":"7","methodid":"244","methodname":"\u4efb\u9009\u56db\u4e2d\u56db"},"245":{"lotteryid":"7","methodid":"245","methodname":"\u4efb\u9009\u4e94\u4e2d\u4e94"},"246":{"lotteryid":"7","methodid":"246","methodname":"\u4efb\u9009\u516d\u4e2d\u4e94"},"247":{"lotteryid":"7","methodid":"247","methodname":"\u4efb\u9009\u4e03\u4e2d\u4e94"},"248":{"lotteryid":"7","methodid":"248","methodname":"\u4efb\u9009\u516b\u4e2d\u4e94"}},"8":{"265":{"lotteryid":"8","methodid":"265","methodname":"\u524d\u4e09\u76f4\u9009"},"266":{"lotteryid":"8","methodid":"266","methodname":"\u524d\u4e09\u7ec4\u9009"},"267":{"lotteryid":"8","methodid":"267","methodname":"\u524d\u4e8c\u76f4\u9009"},"268":{"lotteryid":"8","methodid":"268","methodname":"\u524d\u4e8c\u7ec4\u9009"},"269":{"lotteryid":"8","methodid":"269","methodname":"\u524d\u4e09\u4e0d\u5b9a\u4f4d"},"270":{"lotteryid":"8","methodid":"270","methodname":"\u7b2c\u4e00\u4f4d"},"271":{"lotteryid":"8","methodid":"271","methodname":"\u7b2c\u4e8c\u4f4d"},"272":{"lotteryid":"8","methodid":"272","methodname":"\u7b2c\u4e09\u4f4d"},"273":{"lotteryid":"8","methodid":"273","methodname":"\u5b9a\u5355\u53cc"},"274":{"lotteryid":"8","methodid":"274","methodname":"\u731c\u4e2d\u4f4d"},"275":{"lotteryid":"8","methodid":"275","methodname":"\u4efb\u9009\u4e00\u4e2d\u4e00"},"276":{"lotteryid":"8","methodid":"276","methodname":"\u4efb\u9009\u4e8c\u4e2d\u4e8c"},"277":{"lotteryid":"8","methodid":"277","methodname":"\u4efb\u9009\u4e09\u4e2d\u4e09"},"278":{"lotteryid":"8","methodid":"278","methodname":"\u4efb\u9009\u56db\u4e2d\u56db"},"279":{"lotteryid":"8","methodid":"279","methodname":"\u4efb\u9009\u4e94\u4e2d\u4e94"},"280":{"lotteryid":"8","methodid":"280","methodname":"\u4efb\u9009\u516d\u4e2d\u4e94"},"281":{"lotteryid":"8","methodid":"281","methodname":"\u4efb\u9009\u4e03\u4e2d\u4e94"},"282":{"lotteryid":"8","methodid":"282","methodname":"\u4efb\u9009\u516b\u4e2d\u4e94"}},"9":{"294":{"lotteryid":"9","methodid":"294","methodname":"\u76f4\u9009"},"295":{"lotteryid":"9","methodid":"295","methodname":"\u76f4\u9009_\u548c\u503c"},"296":{"lotteryid":"9","methodid":"296","methodname":"\u7ec4\u4e09"},"297":{"lotteryid":"9","methodid":"297","methodname":"\u7ec4\u516d"},"298":{"lotteryid":"9","methodid":"298","methodname":"\u6df7\u5408\u7ec4\u9009"},"299":{"lotteryid":"9","methodid":"299","methodname":"\u7ec4\u9009\u548c\u503c"},"300":{"lotteryid":"9","methodid":"300","methodname":"\u4e00\u7801\u4e0d\u5b9a\u4f4d"},"301":{"lotteryid":"9","methodid":"301","methodname":"\u4e8c\u7801\u4e0d\u5b9a\u4f4d"},"302":{"lotteryid":"9","methodid":"302","methodname":"\u524d\u4e8c\u76f4\u9009"},"303":{"lotteryid":"9","methodid":"303","methodname":"\u540e\u4e8c\u76f4\u9009"},"304":{"lotteryid":"9","methodid":"304","methodname":"\u524d\u4e8c\u7ec4\u9009"},"305":{"lotteryid":"9","methodid":"305","methodname":"\u540e\u4e8c\u7ec4\u9009"},"306":{"lotteryid":"9","methodid":"306","methodname":"\u767e\u4f4d"},"307":{"lotteryid":"9","methodid":"307","methodname":"\u5341\u4f4d"},"308":{"lotteryid":"9","methodid":"308","methodname":"\u4e2a\u4f4d"},"309":{"lotteryid":"9","methodid":"309","methodname":"\u524d\u4e8c\u5927\u5c0f\u5355\u53cc"},"310":{"lotteryid":"9","methodid":"310","methodname":"\u540e\u4e8c\u5927\u5c0f\u5355\u53cc"}},"10":{"322":{"lotteryid":"10","methodid":"322","methodname":"\u6392\u4e09\u76f4\u9009"},"323":{"lotteryid":"10","methodid":"323","methodname":"\u6392\u4e09\u76f4\u9009_\u548c\u503c"},"324":{"lotteryid":"10","methodid":"324","methodname":"\u6392\u4e09\u7ec4\u9009_\u7ec4\u4e09"},"325":{"lotteryid":"10","methodid":"325","methodname":"\u6392\u4e09\u7ec4\u9009_\u7ec4\u516d"},"326":{"lotteryid":"10","methodid":"326","methodname":"\u6392\u4e09\u7ec4\u9009_\u6df7\u5408"},"327":{"lotteryid":"10","methodid":"327","methodname":"\u6392\u4e09\u7ec4\u9009_\u548c\u503c"},"328":{"lotteryid":"10","methodid":"328","methodname":"\u4e00\u7801\u4e0d\u5b9a\u4f4d"},"329":{"lotteryid":"10","methodid":"329","methodname":"\u4e8c\u7801\u4e0d\u5b9a\u4f4d"},"330":{"lotteryid":"10","methodid":"330","methodname":"\u6392\u4e94\u524d\u4e8c\u76f4\u9009"},"331":{"lotteryid":"10","methodid":"331","methodname":"\u6392\u4e94\u540e\u4e8c\u76f4\u9009"},"332":{"lotteryid":"10","methodid":"332","methodname":"\u6392\u4e94\u524d\u4e8c\u7ec4\u9009"},"333":{"lotteryid":"10","methodid":"333","methodname":"\u6392\u4e94\u540e\u4e8c\u7ec4\u9009"},"334":{"lotteryid":"10","methodid":"334","methodname":"\u4e07\u4f4d"},"335":{"lotteryid":"10","methodid":"335","methodname":"\u5343\u4f4d"},"336":{"lotteryid":"10","methodid":"336","methodname":"\u767e\u4f4d"},"337":{"lotteryid":"10","methodid":"337","methodname":"\u5341\u4f4d"},"338":{"lotteryid":"10","methodid":"338","methodname":"\u4e2a\u4f4d"},"339":{"lotteryid":"10","methodid":"339","methodname":"\u524d\u4e8c\u5927\u5c0f\u5355\u53cc"},"340":{"lotteryid":"10","methodid":"340","methodname":"\u540e\u4e8c\u5927\u5c0f\u5355\u53cc"}},"11":{"358":{"lotteryid":"11","methodid":"358","methodname":"\u524d\u4e09\u76f4\u9009"},"359":{"lotteryid":"11","methodid":"359","methodname":"\u524d\u4e09\u7ec4\u9009"},"360":{"lotteryid":"11","methodid":"360","methodname":"\u524d\u4e8c\u76f4\u9009"},"361":{"lotteryid":"11","methodid":"361","methodname":"\u524d\u4e8c\u7ec4\u9009"},"362":{"lotteryid":"11","methodid":"362","methodname":"\u524d\u4e09\u4e0d\u5b9a\u4f4d"},"363":{"lotteryid":"11","methodid":"363","methodname":"\u7b2c\u4e00\u4f4d"},"364":{"lotteryid":"11","methodid":"364","methodname":"\u7b2c\u4e8c\u4f4d"},"365":{"lotteryid":"11","methodid":"365","methodname":"\u7b2c\u4e09\u4f4d"},"366":{"lotteryid":"11","methodid":"366","methodname":"\u5b9a\u5355\u53cc"},"367":{"lotteryid":"11","methodid":"367","methodname":"\u731c\u4e2d\u4f4d"},"368":{"lotteryid":"11","methodid":"368","methodname":"\u4efb\u9009\u4e00\u4e2d\u4e00"},"369":{"lotteryid":"11","methodid":"369","methodname":"\u4efb\u9009\u4e8c\u4e2d\u4e8c"},"370":{"lotteryid":"11","methodid":"370","methodname":"\u4efb\u9009\u4e09\u4e2d\u4e09"},"371":{"lotteryid":"11","methodid":"371","methodname":"\u4efb\u9009\u56db\u4e2d\u56db"},"372":{"lotteryid":"11","methodid":"372","methodname":"\u4efb\u9009\u4e94\u4e2d\u4e94"},"373":{"lotteryid":"11","methodid":"373","methodname":"\u4efb\u9009\u516d\u4e2d\u4e94"},"374":{"lotteryid":"11","methodid":"374","methodname":"\u4efb\u9009\u4e03\u4e2d\u4e94"},"375":{"lotteryid":"11","methodid":"375","methodname":"\u4efb\u9009\u516b\u4e2d\u4e94"}}};
		var obj_method = $("#method")[0];
		i =  $("#lottery").val();
		$("#method").empty();
		addItem( obj_method,'所有玩法',0 );
		if(i>0)
		{
			$.each(data_method[i],function(j,k){
				addItem( obj_method,k.methodname,k.methodid );
			});
		}
		SelectItem(obj_method,0);
	});
	$("#lottery").val(0);
	$("#lottery").change();
});
</script>

<div id="tabbar-div">
	   <span class="tabbar_bian1"></span>
	   <span class="tabbar_bianz">
		  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="86%">分红查询</td>
    <td width="14%" align="center">&nbsp;</td>
  </tr>
</table>

			</span>
		<span class="tabbar_bian2"></span>
	    	</div>
<div class="ld">
<table class='st' border="0" cellspacing="0" cellpadding="0">
<form action="" method="GET" name="searchForm">
<input type="hidden" name="isrequery" value="1">
<tr>
    <td>
	<img src="images/icon_search.gif" width="26" height="22" border="0" TITLE="SEARCH" />
    时间: 
	<input type="text" name="starttime" id="starttime" value="<?=$starttime?>" />
	<img class='icons_mb4' src="images/comm/t.gif">
	&nbsp;&nbsp;至&nbsp;&nbsp;
	<input type="text" name="endtime" id="endtime" value="<?=$endtime?>"/>
	<img class='icons_mb4' src="images/comm/t.gif">
     
	</td>
</tr>
<tr>
    <td>
	&nbsp;&nbsp;
	状态: <select name="proxyid">
    <option value=" ">全部</option>
	<option value="0">未提现</option>
    <option value="1">已提现</option>
        </select>&nbsp;&nbsp;
   <button name="submit" type="submit" width='69' height='26' class="btn_search" /></button>
    </td>
</tr>
</form>
</table>
</div>
<div class="ld">
<table class="lt" border="0" cellspacing="0" cellpadding="0">
	<tr class='th'>
    	<td>日期</td>
        <td><div class='line'></div>下级消费金额</td>
        <td><div class='line'></div>分红金额</td>
        <td><div class='line'></div>状态</td>
    </tr>
<?php
if($total==0){
?>
	<tr>
    	<td colspan="8" class=needq><span>请选择查询条件之后进行查询</span></td>
    </tr>
<?php
}else{
	$tgmoney=0;
	$tfmoney=0;
	$twmoney=0;
	while ($row = mysql_fetch_array($rs)){
	$tgmoney=$tgmoney+$gmoney;
	$tfmoney=$tfmoney+$fmoney;
	$twmoney=$twmoney+$wmoney;
?>
        <tr align="center">
        <td><?=$row['riqi']?></td>
        <td><?=$row['xfje']?></td>
        <td><?=$row['fhje']?></td>
        <td colspan="5"><?=($row['zt']==1)?("已提现"):("未提现")?></td>
        </tr>
<?php }?>
    <tr align="center">
        <td colspan="2">合计</td>
        <td><?=number_format($tgmoney,4)?></td>
        <td colspan="5"><?=number_format($tfmoney,4)?></td>
        </tr>
<?php }?>
</table>
</div>
<div id="footer"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td align="center"><table align="center" width="450">
<tr><td align="left">浏览器建议：首选IE 8.0浏览器，其次为火狐浏览器。</td></tr>
</table></td></tr><tr><td></td></tr></table></div>
<br/><br/>
</div></div>
<?php echo $count?>
</BODY></HTML>