<?php
session_start();
error_reporting(0);
require_once 'conn.php';
require_once 'check.php';

if($_REQUEST['check']!="914"){
	if($_SESSION["cwflag"]!="ok"){
		$_SESSION["cwurl"]="account_drawlist.php";
		echo "<script language=javascript>window.location='account_check.php';</script>";
		exit;
	}
}
$_SESSION["cwflag"]="";

$page = !($_GET['page'])?'1':intval($_GET['page']);
$pagesize=25;
$page2=($page-1)*$pagesize;

$time_min = $_REQUEST['time_min'];
$time_max = $_REQUEST['time_max'];

if($time_min==""){
	$time_min=date("Y-m-d",strtotime("-2 week"))." 02:20";
}
	$s1=$s1." and adddate>='".$time_min."'";

if($time_max!=""){
	$s1=$s1." and adddate>='".$time_max."'";
}

$urls="time_min=".$time_min."&time_max=".$time_max."&check=914";
$s1=$s1." order by id desc";
$sql="select * from ssc_drawlist where username='" . $_SESSION["username"] . "'".$s1;
//echo $sql;
$rs = mysql_query($sql);
$total = mysql_num_rows($rs);

$sql="select * from ssc_drawlist where username='" . $_SESSION["username"] . "'".$s1." limit $page2,$pagesize";
$rsnewslist=mysql_query($sql);

$lastpg=ceil($total/$pagesize); //最后页，也是总页数
$page=min($lastpg,$page);
$prepg=$page-1; //上一页
$nextpg=($page==$lastpg ? 0 : $page+1); //下一页

if($page<5){
	$p1=1;
	$p2=min($lastpg,10);
}else{
	$p2=min($lastpg,$page+5);
	$p1=max($p2-9,1);
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD><TITLE><?php echo $webname;?>  - 提现记录</TITLE>
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

<H1><SPAN class="action-span"><A href="account_drawlist.php?check=914" target='_self'>提现记录</a></SPAN><SPAN class="action-span"><A href="account_draw.php?check=914" target='_self'>提现申请</a></SPAN>
<SPAN class="action-span1"><DIV class='icons_mb1'></DIV>当前位置: <A href="/" target='_top'><?php echo $webname;?></a>
 - 提现记录 </SPAN><DIV style="clear:both"></DIV></H1>
<script type="text/javascript" src="js/calendar/jquery.dyndatetime.js"></script>
<script type="text/javascript" src="js/calendar/lang/calendar-utf8.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="js/calendar/css/calendar-blue2.css"  />
<script type="text/javascript">
	jQuery("#loadhtml").hide();	//去掉loading界面
	jQuery(document).ready(function() {		
		jQuery("#time_min").dynDateTime({
			ifFormat: "%Y-%m-%d %H:%M",
			daFormat: "%l;%M %p, %e %m,  %Y",
			align: "Br",
			electric: true,
			singleClick: false,
			button: ".next()", //next sibling
			showOthers: true,
			weekNumbers: true,
			//onUpdate: function(){alert('1');}
			showsTime: true
		});
		jQuery("#time_max").dynDateTime({
			ifFormat: "%Y-%m-%d %H:%M",
			daFormat: "%l;%M %p, %e %m,  %Y",
			align: "Br",
			electric: true,
			singleClick: false,
			button: ".next()", //next sibling
			showOthers: true,
			weekNumbers: true,
			//onUpdate: function(){alert('1');}
			showsTime: true
		});
		jQuery("#helpimg").click(function(){
			jQuery("#helpnotice").toggle();
		});
		
		// 取消
		cancelWithdraw = function(id){
			if (confirm("确认取消吗？")){
				$.ajax({
					type:"POST",
					url:'',
					data:'id=' + id + '&flag=ajax',
					success:function(data){
						if (data == true){
							$("#status" + id).html("已取消");
							$("#cancel" + id).fadeOut("slow");
							alert("取消成功");
						} else if (data == -1){
							alert("系统结算时间,暂停提现操作");
						} else {
							alert("取消失败");
						}
					}
				});
			}
		}
	});

function checkForm(obj)
{
	if( jQuery.trim(obj.time_min.value) != "" )
	{
		if( false == validateInputDate(obj.time_min.value) )
		{
			alert("时间格式不正确");
			obj.time_min.focus();
			return false;
		}
	}
	if( jQuery.trim(obj.time_max.value) != "" )
	{
		if( false == validateInputDate(obj.time_max.value) )
		{
			alert("时间格式不正确");
			obj.time_max.focus();
			return false;
		}
	}
}
</script>
<STYLE>
.sbox{font-weight:bold;font-size:16px;padding:3px 8px;height:23px;line-height:23px;background-color:#222;color:#B4FF00;border:#BBB 1px solid;}
</STYLE>
<div class="tab-div">
	<div id="tabbar-div">
		  <span class="tab-back"  id="general_tab_0">
		  <span class="tabbar-left"></span>
		  <span class="content" onclick="window.location.href='./account_draw.php?check=914'">提现申请</span>
		  <span class="tabbar-right"></span>		</span>
	    <span class="tab-front"  id="general_tab_1">
		    <span class="tabbar-left"></span>
		    <span class="content">提现记录</span>
		    <span class="tabbar-right"></span>		</span>	</div>
<div class="tabbar-bottom"></div>

<div class="ld" style='width:100%;margin:2px 10px 0px 0px;'>
<table class='st' border="0" cellspacing="0" cellpadding="0">
<form action="" method="get" name="search" onsubmit="return checkForm(this)">
<input type="hidden" name="check" value="914" />
<tr><td>
提现时间: <input type="text" size="16" name="time_min" id="time_min" value="<?=$time_min?>" /> 
<img class='icons_mb4' src="images/comm/t.gif" id="time_min_button" />
&nbsp;至&nbsp;
<input type="text" size="16" name="time_max" id="time_max" value="<?=$time_max?>" /> 
<img class='icons_mb4' src="images/comm/t.gif" />&nbsp;&nbsp;<button name="submit" type="submit" width='69' height='26' class="btn_search" /></button>&nbsp;&nbsp;&nbsp;
</td></tr></form></table>
</div>

<div class="ld" style='width:100%;margin:0px 0px 0px 0px;'>
<table class="lt" border="0" cellspacing="0" cellpadding="0">
	<tr class='th'>
    	<td>提现编号</td>
        <td><div class='line'></div>申请发起时间</td>
		<td><div class='line'></div>提现银行</td>
		<td TITLE='银行卡尾号'><div class='line'></div>尾号</td>
        <td><div class='line'></div>提现金额</td>
        <td><div class='line'></div>手续费</td>
        <td><div class='line'></div>到账金额</td>
        <td><div class='line'></div>状态</td>
    </tr>
<?php
  if($total==0){
?>
    	<tr align="center"><td colspan="9" class='no-records'><span>暂无数据</span></td></tr>
<?php
  }else{
	while ($row = mysql_fetch_array($rsnewslist)){
  	$tmoney=$tmoney+$row['money'];
	$tsxmoney=$tsxmoney+$row['sxmoney'];
  	$trmoney=$trmoney+$row['rmoney'];
?>
    <tr align="center">
    	<td><?=$row['dan']?></td>
    	<td><?=$row['adddate']?></td>
		<td><?=$row['bank']?></td>
		<td><?=substr($row['cardno'],-4)?></td>
    	<td><?=number_format($row['money'],4)?></td>
    	<td><?=number_format($row['sxmoney'],4)?></td>
    	<td><?=number_format($row['rmoney'],4)?></td>
    	<td id="status"><?php if($row['zt']=="0"){?><font color="#999999">等待处理</font><?php }else if($row['zt']=="1"){?><font color=#669900>提现成功</font><?php }else if($row['zt']=="2"){?><font color="#FF3300">提现失败</font><?php }?></td>
	</tr>
<?php }}?>
       <tr style="color:#FF3300">
    	<td colspan=4>&nbsp;&nbsp;&nbsp;&nbsp;
		<font color="#FF3300">合计: </font>&nbsp;&nbsp;</td>
		<td align="center"><font color="#FF3300"><?=number_format($tmoney,2)?></font></td>
		<td align="center"><font color="#FF3300"><?=number_format($tsxmoney,2)?></font></td>
		<td align="center"><font color="#FF3300"><?=number_format($trmoney,2)?></font></td>
	    <td></td>
    </tr>
<tr><td class='b' colspan="9" valign="middle"><div style='text-align:right;'><ul class="pager">总计  <?=$total?> 条数据,  共 <?=$lastpg?> 页 , 当前第 <?=$page?> 页  |  <?php if($page>1){?><LI><A HREF="?<?=$urls?>&page=1">首页</A></LI><LI><A HREF="?<?=$urls?>&page=<?=$page-1?>">上页</A></LI><?php }?><?php for($i=$p1;$i<=$p2;$i++){
		if($i==$page){?><LI CLASS='current' ><A HREF="#"><?=$i?></A></LI><?php }else{?><LI><A HREF="?<?=$urls?>&page=<?=$i?>"><?=$i?></A></LI><?php }}?><?php if($page!=$lastpg){?><LI><A HREF="?<?=$urls?>&page=<?=$page+1?>">下页</A></LI><LI><A HREF="?<?=$urls?>&page=<?=$lastpg?>">尾页</A></LI><?php }?> | 转至 <SCRIPT LANGUAGE="JAVASCRIPT">function keepKeyNum(obj,evt){var  k=window.event?evt.keyCode:evt.which; if( k==13 ){ goPage(obj.value);return false; }} function goPage( iPage ){ if( !isNaN(parseInt(iPage)) ) { if(iPage> 0 ){iPage=0;} window.location.href="?<?=$urls?>&page="+iPage;}}</SCRIPT><INPUT onKeyPress="return keepKeyNum(this,event);" TYPE="TEXT" ID="iGotoPage" NAME="iGotoPage" size="3"> 页  &nbsp;<BUTTON onclick="javascript:goPage( document.getElementById('iGotoPage').value );return false;">GO</BUTTON>  </ul></div></td></tr>
</table>
</div>
<SCRIPT>
function showH(objId)
{
	var obj = document.getElementById(objId);
	if(obj.style.display=="none")
	{
		obj.style.display="block";
	}
	else
	{
		obj.style.display="none";
	}
}
</SCRIPT>
<div id="footer"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td align="center"><table align="center" width="450">
<tr><td align="left">浏览器建议：首选IE 8.0浏览器，其次为火狐浏览器。</td></tr>
</table></td></tr><tr><td></td></tr></table></div>
<br/><br/>
</div></div>
<?php echo $count;?>
</BODY></HTML>