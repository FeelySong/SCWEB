<?php
session_start();
error_reporting(0);
require_once 'conn.php';
$flag_left=$_REQUEST['flag'];

$lastdate=date("Y-m-d H:i:s",strtotime("-1 day"));
$sql = "delete from ssc_info where adddate <'".$lastdate."'";
$rs = mysql_query($sql);

$sql = "select * from ssc_info order by id desc limit 10";
$rs = mysql_query($sql);
$total = mysql_num_rows($rs);

if($flag_left=="getinfo"){
//	$lotteryid=$_REQUEST['lotteryid'];
//	$issue=$_REQUEST['issue'];	//120225076	30条
	echo "[";
	$i=0;
	while ($row = mysql_fetch_array($rs)){
		echo "{\"lotteryid\":\"".$row['lotteryid']."\",\"lottery\":\"".$row['lottery']."\",\"issue\":\"".$row['issue']."\",\"tz\":\"".$row['tz']."\",\"fd\":\"".$row['fd']."\",\"zj\":\"".$row['zj']."\",\"yk\":\"".($row['tz']-$row['fd']-$row['zj'])."\"}";
		if($i!=$total-1){echo ",";}
		$i=$i+1;
	}
	echo "]";
	exit;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head><title>左侧菜单</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
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
		url  : 'default_left.php',
		data : 'flag=getinfo',
		timeout : 10000,
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
						html += '<li><a href="account_tz.php?lotteryid='+n.lotteryid+'" target="mainframe">【'+n.lottery+'】'+n.issue+' 期, 投注 <span class=c3>'+n.tz+'</span> 返点 <span class=c3>'+n.fd+'</span> 中奖 <span class=c3>'+n.zj+'</span> 盈亏 <span class=c1>'+n.yk+'</span></a></li>';
					});
					$("#infoa").empty();
					$(html).appendTo("#infoa");
					//alert(html);
				}
				return true;
		},
		error: function(){
			$lf.html("<font color='#A20000'>获取失败</font>");
		}
	});
},12000);

});

</script>
<SCRIPT LANGUAGE='JavaScript'>function ResumeError() {return true;} window.onerror = ResumeError; </SCRIPT>
<link href="css/main.css" rel="stylesheet" type="text/css" />
</HEAD>
<BODY>
<div class="left_header">
<dl><dt></dt>
	<dd>
		<ul id="infoa">
<?php	while ($row = mysql_fetch_array($rs)){?>
			<li><a href="account_tz.php?lotteryid=<?=$row['lotteryid']?>" target="mainframe">【<?=$row['lottery']?>】<?=$row['issue']?> 期, 投注 <span class=c3><?=$row['tz']?></span> 返点 <span class=c3><?=$row['fd']?></span> 中奖 <span class=c3><?=$row['zj']?></span> 盈亏 <span class=c1><?=$row['tz']-$row['fd']-$row['zj']?></span></a></li>
<?php } ?>
		</ul>
	</dd>
</dl></div>
</BODY>
</HTML>