<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<?php
@session_start();
error_reporting(0);
require_once 'conn.php';
$sql = "select * from ssc_zbills WHERE  dan='" . $_REQUEST['id'] . "'";
$rs = mysql_query($sql);
$row = mysql_fetch_array($rs);
?>
<HEAD><TITLE><?php echo $webname;?>  - 追号详情</TITLE>
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
 - 追号详情 </SPAN><DIV style="clear:both"></DIV></H1>
<script language="javascript" src="js/dialog/jquery.dialogUI.js"></script>
<script>
jQuery(document).ready(function(){
    $("#checkall").click(function(){
        $(":input").attr("checked",$("#checkall").attr("checked"));
    });
	$("a[rel='projectinfo']").click(function(){
		me = this;
		$pid = $(this).attr("name");
		$.blockUI({
            message: '<div style="width:200px;padding:10px 100px;background-color:#fff;border:4px #666 solid;"><img src="images/comm/loading.gif" style="margin-right:10px;">正在读取投注详情...</div>',
            overlayCSS: {backgroundColor: '#000000',opacity: 0.3,cursor:'wait'}
            });
		$.ajax({
			type: 'POST',
            url : 'history_playinfo.php',
            data: "id="+$pid,
            success : function(data){//成功
				$.unblockUI({fadeInTime: 0, fadeOutTime: 0});
				try{
					eval("data = "+ data +";");
					if( data.stats == 'error' ){
						$.alert('<IMG src="images/comm/t.gif" class=icons_mb5_e style="margin:5px 15px 0 0;">'+data.data);
					}else{
						data = data.data;
						stat = '未开奖';
						if(data.project.iscancel==0){
							if(data.project.isgetprize==0){
								stat = '未开奖';
							}else if(data.project.isgetprize==2){
								stat = '未中奖';
							}else if(data.project.isgetprize==1){
								if(data.project.prizestatus==0){
									stat = '未派奖';
								}else{
									stat = '已派奖';
								}
							}
						}else if(data.project.iscancel==1){
							stat = '本人撤单';
						}else if(data.project.iscancel==2){
							stat = '管理员撤单';
						}else if(data.project.iscancel==3){
							stat = '开错奖撤单';
						}
						$.blockUI_lang.button_sure = '关&nbsp;闭';
						html = '<table id=project_box border=0 cellspacing=0 cellpadding=0><tr><td><div class=zdinfo><table border=0 cellspacing=0 cellpadding=0>';
						html += '<tr><td width=30%>游戏用户：<span>'+data.project.username+'</span></td><td width=18%>游戏：<span>'+data.project.cnname+'</span></td><td width=18%>开奖号码：<span>'+data.project.nocode+'</span></td><td width=28%>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;总金额：<span>'+data.project.totalprice+'</span></td></tr>';
						html += '<tr><td>注单编号：<span>'+data.project.projectid+'</span></td><td>玩法：<span>'+data.project.methodname+'</span></td><td>注单状态：<span>'+stat+'</span></td><td>&nbsp;&nbsp;&nbsp;&nbsp;倍数模式：<span>'+data.project.multiple+'倍, '+ data.project.modes +'模式</span></td></tr>';
						html += '<tr><td>投单时间：<span>'+data.project.writetime+'</span></td><td>奖期：<span>'+data.project.issue+'</span></td><td>注单奖金：<span>'+data.project.bonus+'</span></td><td>';

						if( data.project.dypointdec.length>2 ){
							html += '动态奖金返点：<span>'+data.project.dypointdec+'</span>';
						}else{
						    html += '&nbsp;';
						}
						html += '</td></tr><tr><td colspan=4><IMG SRC="images/comm/t.gif" class=hr1></td></tr><tr><td colspan=4 STYLE="height:50px;">投注内容：<textarea class=t1 READONLY=TRUE style="width:578px;height:50px;">'+data.project.code+'</textarea></td></tr>';
						html += '<tr><td colspan=4><IMG SRC="images/comm/t.gif" class=hr1></td></tr><tr><td colspan=4>可能中奖情况：';
/*						if( data.can == 1 ){
							html += '&nbsp;&nbsp;<input type="button" value="&nbsp;撤&nbsp;单&nbsp;" class="class="yh" id="cancelproject">';
						}*/
						html += '<br/><br/>';
						html += '<div class=ld style="width:96%; margin:0px 10px 0px 10px;"><table class=lt border=0 cellspacing=0 cellpadding=0><tr class=th><td width=45>编号</td><td><div class=line></div>号码</td><td width=45><div class=line></div>倍数</td><td width=45><div class=line></div>奖级</td><td width=90><div class=line></div>奖金</td></tr>';
						$.each(data.prizelevel,function(i,k){
							html += '<tr class=d><td>'+i+'</td><td>'+(k.expandcode.length > 60 ? '<textarea READONLY=TRUE style="width:386px;height:50px;">'+k.expandcode+'</textarea>' :k.expandcode)+'</td><td>'+k.codetimes+'</td><td>'+k.level+'</td><td>'+k.prize+'</td></tr>';
						});
						html += '</table></div><tr><td colspan=4><IMG SRC="images/comm/t.gif" class=hr1></td></tr></td></tr></table></div></td></tr></table>';
						$.alert(html,'投注详情','',700,false);
						$("#cancelproject").click(function(){
					    	if(confirm("真的要撤单吗?"+(data.need==1 ? "\n撤销此单将收取撤单手续费金额:"+data.money+"元." : ""))){
								$.blockUI({
										message: '<div style="width:200px;padding:10px 100px;background-color:#fff;border:4px #666 solid;"><img src="images/comm/loading.gif" style="margin-right:10px;">正在提交撤单请求...</div>',
										overlayCSS: {backgroundColor: '#000000',opacity: 0.3,cursor:'wait'}
										});
								$.ajax({
										type: 'POST',
										url : 'history_playcancel.php',
										data: "id="+data.project.projectid,
										success : function(data){//成功
											$.unblockUI({fadeInTime: 0, fadeOutTime: 0});
											try{
												eval("data = "+ data +";");
												if( data.stats == 'error' ){
													$.alert('<IMG src="images/comm/t.gif" class=icons_mb5_e style="margin:5px 15px 0 0;">'+data.data);
												}else{
													$(me).closest("tr").find("td:last").html("本人撤单");
													$.alert('<IMG src="images/comm/t.gif" class=icons_mb5_s style="margin:5px 15px 0 0;">撤单成功');
												}
											}catch(e){
												$.alert('<IMG src="images/comm/t.gif" class=icons_mb5_e style="margin:5px 15px 0 0;">撤单失败，请梢后重试');
											}
										}
								});
							}
						});
					}
				}catch(e){
					$.alert('<IMG src="images/comm/t.gif" class=icons_mb5_e style="margin:5px 15px 0 0;">读取数据出错，请重试');
				}
			}
		});
	});
});
function cancel()
{
    if($(":input[name='taskid[]'][checked=true]").size()==0)
    {
        $.alert('<IMG src="images/comm/t.gif" class=icons_mb5_n style="margin:5px 15px 0 0;">请选择要终止追号的奖期.');
        return false;
    }
    else
    {
    	$.confirm('<IMG src="images/comm/t.gif" class=icons_mb5_q style="margin:0 15px 0 0;">真的要终止追号任务吗？',function(){
                $("#Form").submit();
            },function(){
                return false;
            } 
          ,'',240);
    }
}
</script>
<div class="ld">
<table class='lt' width="100%" border=0 cellpadding=2 cellspacing=0 style="table-layout:fixed;">
<tr><td width="200" height="37" class=nl>追号编号：</td><td><?=$row['dan']?></td>
<td height="37" class=nl>游戏用户：</td><td><?=$row['username']?></td>
</tr>
<tr><td height="37" class=nl>追号时间：</td><td><?=$row['adddate']?></td>
<td height="37" class=nl>游戏：</td><td><?=$row['lottery']?></td>
</tr>
<tr><td height="37" class=nl>玩法：</td><td><?=Get_mid($row['mid'])?></td>
<td height="37" class=nl>模式：</td><td><?php if($row['mode']==1){echo "元";}else{echo "角";}?></td></tr>
<tr><td height="37" class=nl>开始期号：</td><td><?=$row['issue']?></td>
<td height="37" class=nl>追号期数：</td><td><?=$row['znums']?>期</td>
</tr>
<tr><td height="37" class=nl>完成期数：</td><td><?=$row['fnums']?>期</td>
<td height="37" class=nl>取消期数：</td><td><?=$row['cnums']?>期</td>
</tr>
<tr><td height="37" class=nl>追号总金额：</td><td><?=$row['money']?></td>
<td height="37" class=nl>完成金额：</td><td><?=$row['fmoney']?></td>
</tr>
<tr><td height="37" class=nl>中奖期数：</td><td><?=$row['zjnums']?></td>
<td height="37" class=nl>派奖总金额：</td><td><?=$row['prize']?></td>
</tr>
<tr><td height="37" class=nl>取消金额：</td><td><?=$row['cmoney']?></td>
<td height="37" class=nl>中奖后终止任务：</td><td><?php if($row['autostop']=="yes"){echo "是";}else{echo "否";}?></td></tr>
<tr><td height="37" class=nl>追号内容：</td><td style="word-break:break-all;white-space:normal; width:85%;overflow:hidden;word-wrap:break-word;"><?=dcode($row['codes'],$row['lotteryid'])?></td>
<td height="37" class=nl>追号状态：</td><td><?php if($row['zt']==0){echo "进行中";}else{echo "已完成";}?></td></tr>
<tr><td height="37"></td><td colspan="3"><input type="button" class='button yh' value="关闭" onclick="self.close();">&nbsp;<?php if($row['zt']==0){?><!--<input type="button" class='button yh' value="终止追号" onclick="cancel()">--><?php }?></td></tr>
</table>
</div>
<br/><br/>

<form id="Form" action="./history_taskcancel.php" method="post">
<input type="hidden" name="id" value="<?=$row['dan']?>" />
<div class="ld">
<table class='lt' width="100%" border=0 cellpadding=0 cellspacing=0>
<tr class='th'>
	<td><input type="checkbox" id="checkall"> 奖期</td>
	<td><div class='line'></div>追号倍数</td>
	<td><div class='line'></div>追号状态</td>
	<td><div class='line'></div>注单详情</td>
</tr>
<tr>
<?php
$sqla = "select * from ssc_zdetail WHERE  dan='" . $_REQUEST['id'] . "' order by id asc";
$rsa = mysql_query($sqla);
	while ($rowa = mysql_fetch_array($rsa)){
?>
<tr align="center" class='needchangebg'>
	<td height="37"><?php if($rowa['canceldead']>date("Y-m-d H:i:s") && $rowa['zt']<2){?><input type="checkbox" name="taskid[]" value="<?=$rowa['id']?>"><?php }?><?=$rowa['issue']?></td>
	<td><?=$rowa['times']?>倍</td>
	<td><?php if($rowa['zt']==0){echo "进行中";}else if($rowa['zt']==1){echo "已完成";}else if($rowa['zt']==2){echo "已取消";}?></td>
	<td><?php if($rowa['zt']==1){?><a href="javascript:" rel="projectinfo" name="<?=$rowa['danb']?>" class="blue">详情</a><?php }?></td>
</tr>
<?php }?>
</table>
</div>
</form>

<div id="footer"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td align="center"><table align="center" width="450">
<tr><td align="left">浏览器建议：首选IE 8.0浏览器，其次为火狐浏览器。</td></tr>
</table></td></tr><tr><td></td></tr></table></div>
<br/><br/>
</div></div>
<?php echo $count?>
</BODY>
</HTML>