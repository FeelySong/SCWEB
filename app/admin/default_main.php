<?php
session_start();
setcookie(session_name(), session_id(), time() + 3600*24, "/");
error_reporting(0);
require_once 'conn.php';



//	$_SESSION["ausername"]="admin";
//	$_SESSION['admin_flag']=",a1";

if($_SESSION["ausername"]=="" || $_SESSION['admin_flag']==""){
	echo "<script language=javascript>window.location='default_logout.php';</script>";
	exit;
}
	$flag=$_SESSION['admin_flag'];
	$sqla="select count(*) as numa from ssc_kf where sign=1 and zt=0";
	$rsa=mysql_query($sqla) or  die("数据库修改出错!!!!".mysql_error());
	$rowa = mysql_fetch_array($rsa);
	$msga=$rowa['numa'];

	$sqlb="select count(*) as numb from ssc_drawlist where zt=0";
	$rsb=mysql_query($sqlb) or  die("数据库修改出错!!!!".mysql_error());
	$rowb = mysql_fetch_array($rsb);
	$msgb=$rowb['numb'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<TITLE><?=$webname?> 后台管理中心</TITLE>
<style>
/* Start New Product Page Design [date] */
img{border-style:none;}
a{text-decoration:none;color:#1a7ec2;}
a:hover{text-decoration:underline;color:#ee7d36;}
ul,li{padding:0;margin:0;}
#wrapper{width:100%;margin:0 auto;background:#fff;font-size:14px;}
#header{color: #039;background:url('images/menu1.jpg') repeat-x;}
.header-holder{overflow:hidden;height:1%;padding: 11px 5px 5px;}

#header .panel{ overflow:hidden;height:1%;padding: 0 3px 0 75px; font-weight:bold;margin-bottom:-1px;position:relative;}
.tabset{margin: 0 10px 0 0; padding:0;list-style:none;float:left;position:relative;z-index: 3;height:31px;}
.tabset li{float:left;margin-right:3px;}
#header .tabset a{ float: left;padding: 9px 2px 7px;color:#fff;line-height:12px;cursor:pointer;width: 90px;font-weight: bold; text-align:center;}
#header .tabset a:hover{text-decoration:none;}
#header .tabset .active a{ background: url('images/menu2.jpg') no-repeat;color: #1A7EC2;border-color:#fc0; padding-bottom: 10px;}
a {outline: none;}
a:active {star:expression(this.onFocus=this.blur());}
:focus { outline:0; }
/* 子菜单 */
.sub-menu{height: 27px;background: url('header-sprite.png') repeat-x 0 -125px;border-top: 3px solid #197EC2;padding: 0 0 6px 0;margin-top: -3px;border-bottom: 1px #AAA solid;text-align: left;}
.sub-menu ul {list-style-type: none; padding-left: 0; margin-left: 0;margin-top:0; padding-top:7px;}
.sub-menu li { float: left;margin:0;padding: 0 20px 0 20px;color:#777;font-size:12px;line-height:22px;}

.sub-menu li a{ display:block;width:66px;line-height:22px;text-decoration:none;text-align: center; }
.sub-menu li a:hover{ color:#fff;font-weight:bold;background:#1C74C8;}
.actived a{ color:#fff;background:#1C74C8;}

/*


.item_main li{position:relative;*float:left;width:100%;}
.item_main li a{ display:block;height:28px;line-height:28px; border-top:1px solid #767878;border-bottom:1px solid #444;
	background:#616363 url("../images/v1/ico_arrow_sub.gif") no-repeat 12px;color:#ededed;text-decoration:none; }
.item_main li a:hover{ background-color:#FFFC77;color:#f40;text-decoration:none; background-image:url("../images/v1/ico_arrow_right.gif");}
.item_main li a.sub{background:#616363 url("../images/v1/ico_arrow_sub.gif") no-repeat 112px center;}
.item_main li a.active:visited, .item_main li a.active:link{color:#f40;}
.item_main li a.active{ color:#f40;font-weight:bold;background:#fff600 url("../images/v1/ico_arrow_right.gif") no-repeat 126px center;}
.item_main li a.active:hover{background-image:url("../images/v1/ico_arrow_right.gif");}
 */
.sub-menu li.inline{float: left;background: url('line.png') no-repeat right;}
.sub-menu li.inline .clink{ color:#444;font-size: 12px;}
#tab-2,#tab-3,#tab-4,#tab-5,#tab-6,#tab-7,#tab-8,#tab-9,#tab-10,#tab-11,#tab-12{display: none;}
.clear {clear:both;}
</style>
<script language="JavaScript" type="text/javascript">
if(self.parent.frames.length != 0) {self.parent.location=document.location;}
</script>
<LINK href="css/main.css" rel="stylesheet" type="text/css" />
<SCRIPT type="text/javascript" src="js/jquery.js"></SCRIPT>
<script language="javascript" type="text/javascript" src="js/common.js"></script>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript" src="jquery.main.js"></script>


<SCRIPT language="javascript" type="text/javascript">
var  resizeTimer = null;
jQuery(document).ready(function(){
	$(".sub-menu").find("a").click(function(){
		$(".sub-menu").find("a").attr("class","");
		$(".sub-menu").find("a").blur();
	    $(this).attr("class","active");
	});
	
	jQuery("#mainbox").height( jQuery(document).height()-jQuery("#topbox").height()-jQuery("#wrapper").height() );
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
			jQuery("#leftbox").css({width:"180px"}).show();
			jQuery("#mainbox").css({width:"auto"});
		}
	});

_fastData = setInterval(function(){
	$.ajax({
		type : 'POST',
		url  : 'queryautos.php',
		timeout : 12000,
		success : function(data){
			return true;
		}
	});
},15000);

_fastData = setInterval(function(){
	$.ajax({
		type : 'POST',
		url  : 'default_getdata.php',
		timeout : 9000,
		success : function(data){
				var partn = /<(.*)>.*<\/\1>/;
				if( partn.exec(data) ){
					window.top.location.href="default_main.php";
					return false;
				}
				eval("data="+data+";");
				//用户余额
				if( data.msga == 'Error' ){
					window.top.location.href="index.php";
					return false;
				}
				if( data.msga != 'empty' ){
					var dd = data.msga;
					$("#msga").html(dd);
				}
				if( data.msgb != 'empty' ){
					var dd = data.msgb;
					$("#msgb").html(dd);
				}
				if( (data.msga != 'empty' && data.msga != '0') || (data.msgb != 'empty' && data.msgb != '0') ){
					document.SoundMSG1.play();
				}
				return true;
		}
	});
},10000);

});

function resizewindow(){
	jQuery("#mainbox").height( jQuery(window).height()-jQuery("#topbox").height()-jQuery("#wrapper").height() );
	jQuery("#leftbox").height( jQuery(window).height()-jQuery("#topbox").height()-jQuery("#wrapper").height() );
	resizeTimer = null;
}


document.onreadystatechange=function()     //当页面状态改变时执行函数 
{ 
if(document.readyState == "complete")         //当页面加载状态为完成时执行条件内容 

{ 
  var li = document.getElementById("smid").getElementsByTagName("li");  //获取页面所有li节点 
  for(var i=0;i<li.length;i++)                                     //循环li节点 
  { 
   li[i].onclick=function(){                                         //为循环的li节点绑定 onclick事件 
    for(var j=0;j<li.length;j++) 
    { 
//     li[j].style.backgroundColor="";                  //将所有li背景颜色修改 
     li[j].className="inline";                  //将所有li背景颜色修改 
     this.className="actived inline";                //将当前点击的li背景颜色修改 
    } 
   } 
  } 
} 
}
</script>
<SCRIPT LANGUAGE='JavaScript'>function ResumeError() {return true;} window.onerror = ResumeError; </SCRIPT>
<style>
html {overflow: hidden;}
</style>
</HEAD>
<BODY>

<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
	<td width="200" height="80" align="center" id="topbox"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="250" height="60"><div align="center"><img src="images/logo.png" width="190" height="53" /></div></td>
        <td valign="bottom"><div align="center">
          <table width="270" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="35"><img src="images/icon5.gif" width="25" height="18" /></td>
              <td><a TITLE='在线客服信息' class="wf14" href="kf.php?zt=0" target="mainframe">最新消息(<span id="msga" style='color:#f00;'><?=$msga?></span>)</a></td>
              <td width="35"><img src="images/icon6.gif" width="24" height="24" /></td>
              <td><a TITLE='提款信息' class='wf14' href="account_tx.php" target="mainframe">提现请求(<span id="msgb" style='color:#f00;'><?=$msgb?></span>)</a></td>
            </tr>
          </table>
        </div></td>
        <td width="350"><table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="70" height="40"><div align="center"><img src="images/icon1.gif" width="31" height="30" /></div></td>
              <td width="70"><div align="center"><img src="images/icon2.gif" width="25" height="28" /></div></td>
              <td width="70"><div align="center"><img src="images/icon4.gif" width="30" height="28" /></div></td>
              <td width="70"><div align="center"><img src="images/icon3.gif" width="26" height="29" /></div></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td height="20"><a TITLE='首页' href="info.php" target="mainframe"><div align="center" class="wf14">管理首页</div></a></td>
              <td><a TITLE='首页' href="manager_pass.php" target="mainframe"><div align="center" class="wf14">修改密码</div></a></td>
              <td><a TITLE='刷新当前页' href="javascript:window.top.frames['mainframe'].document.location.reload();"><div align="center" class="wf14">刷新页面</div></a></td>
              <td><a TITLE='退出系统' onClick="return confirm('确认退出系统?');" href="default_logout.php" target="_top"><div align="center" class="wf14">安全退出</div></a></td>
              <td>&nbsp;</td>
            </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>

<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
	<td>
<div id="wrapper">
   <!-- header -->
        <div id="header">
                <div class="panel">
                        <!-- navigation tab -->
                        <ul class="tabset" id="tab-list">
                                <li ><a href="#tab-1" class="tab" onClick="return false;">信息管理</a></li>
                                <li ><a href="#tab-2" class="tab" onClick="return false;">会员管理</a></li>
                                <li ><a href="#tab-3" class="tab" onClick="return false;">财务管理</a></li>
                                <li ><a href="#tab-4" class="tab" onClick="return false;">业务流水</a></li>
                                <li ><a href="#tab-5" class="tab" onClick="return false;">报表管理</a></li>
                                <li ><a href="#tab-6" class="tab" onClick="return false;">数据统计</a></li>
                          		<li ><a href="#tab-7" class="tab" onClick="return false;">游戏管理</a></li>
                                <li ><a href="#tab-8" class="tab" onClick="return false;">奖金管理</a></li>
                                <li ><a href="#tab-9" class="tab" onClick="return false;">系统管理</a></li>
                                <li ><a href="#tab-10" class="tab" onClick="return false;">权限管理</a></li>
                                <li ><a href="#tab-11" class="tab" onClick="return false;">计划任务</a></li>
                                <li ><a href="#tab-12" class="tab" onClick="return false;">帮助中心</a></li>
                        </ul>
          		</div>
                 <!-- navigation -->
                <div id="smid"> 
                <div class="sub-menu" id="tab-1" style=display:none>
                        <ul>
                            <?php if (strpos($flag,'11')){?><li class="inline"><a href="affiche_edit.php?act=add" target="mainframe" class="clink">添加公告</a></li><?php } ?> 
                            <?php if (strpos($flag,'12')){?><li class="inline"><a href="affiche.php" target="mainframe" class="clink">公告管理</a></li><?php } ?> 
							<?php if (strpos($flag,'13')){?><li class="inline"><a href="kf.php" target="mainframe" class="clink">会员消息</a></li><?php } ?> 
							<?php if (strpos($flag,'14')){?><li class="inline"><a href="message.php" target="mainframe" class="clink">系统消息</a></li><?php } ?> 
                        </ul>
                </div>
                <div class="sub-menu" id="tab-2" style=display:none>
                        <ul>
                            <?php if (strpos($flag,'21')){?><li class="inline"><a href="mem_edit.php?act=add" target="mainframe" class="clink">新增会员</a></li><?php } ?> 
							<?php if (strpos($flag,'22')){?><li class="inline"><a href="mem_list.php" target="mainframe" class="clink">会员列表</a></li><?php } ?> 
							<?php if (strpos($flag,'23')){?><li class="inline"><a href="mem_card.php" target="mainframe" class="clink">银行信息</a></li><?php } ?> 
							<?php if (strpos($flag,'24')){?><li class="inline"><a href="mem_logs.php" target="mainframe" class="clink">登录日志</a></li><?php } ?> 
							<?php if (strpos($flag,'25')){?><li class="inline"><a href="mem_amend.php" target="mainframe" class="clink">操作日志</a></li><?php } ?> 
							<?php if (strpos($flag,'26')){?><li class="inline"><a href="mem_total.php" target="mainframe" class="clink">用户统计</a></li><?php } ?> 
							<?php if (strpos($flag,'27')){?><li class="inline"><a href="mem_ztotal.php" target="mainframe" class="clink">用户总计</a></li><?php } ?> 
 							<?php if (strpos($flag,'28')){?><li class="inline"><a href="total.php" target="mainframe" class="clink">访问统计</a></li><?php } ?> 
							<?php if (strpos($flag,'29')){?><li class="inline"><a href="online.php" target="mainframe" class="clink">在线人员</a></li><?php } ?> 
                       </ul>
                </div>
                <div class="sub-menu" id="tab-3" style=display:none>
                        <ul>
                            <?php if (strpos($flag,'31')){?><li class="inline"><a href="account_cz.php" target="mainframe" class="clink">手动充值</a></li><?php } ?> 
							<?php if (strpos($flag,'32')){?><li class="inline"><a href="account_czlist.php" target="mainframe" class="clink">充值记录</a></li><?php } ?> 
							<?php if (strpos($flag,'33')){?><li class="inline"><a href="account_tx.php" target="mainframe" class="clink">提现请求</a></li><?php } ?> 
							<?php if (strpos($flag,'34')){?><li class="inline"><a href="account_txlist.php" target="mainframe" class="clink">提现记录</a></li><?php } ?> 
                        </ul>
                </div>
                <div class="sub-menu" id="tab-4" style=display:none>
                        <ul>
                            <?php if (strpos($flag,'41')){?><li class="inline"><a href="account_tz.php" target="mainframe" class="clink">投注记录</a></li><?php } ?> 
							<?php if (strpos($flag,'42')){?><li class="inline"><a href="account_zh.php" target="mainframe" class="clink">追号记录</a></li><?php } ?> 
							<?php if (strpos($flag,'43')){?><li class="inline"><a href="account_prize.php" target="mainframe" class="clink">中奖记录</a></li><?php } ?> 
							<?php if (strpos($flag,'44')){?><li class="inline"><a href="account_rebate.php" target="mainframe" class="clink">返点记录</a></li><?php } ?> 
							<?php if (strpos($flag,'45')){?><li class="inline"><a href="account_fh.php" target="mainframe" class="clink">分红记录</a></li><?php } ?> 
							<?php if (strpos($flag,'46')){?><li class="inline"><a href="account_record.php" target="mainframe" class="clink">账变明细</a></li><?php } ?> 
							<?php if (strpos($flag,'47')){?><li class="inline"><a href="error.php" target="mainframe" class="clink">可疑数据</a></li><?php } ?> 
							<?php if (strpos($flag,'48')){?><li class="inline"><a href="account_check.php" target="mainframe" class="clink">开奖检测</a></li><?php } ?> 
                        </ul>
                </div>
                <div class="sub-menu" id="tab-5" style=display:none>
                        <ul>
                            <?php if (strpos($flag,'51')){?><li class="inline"><a href="total_xf.php" target="mainframe" class="clink">消费报表</a></li><?php } ?> 
							<?php if (strpos($flag,'52')){?><li class="inline"><a href="total_js.php" target="mainframe" class="clink">结算报表</a></li><?php } ?> 
                        </ul>
                </div>
                <div class="sub-menu" id="tab-6" style=display:none>
                        <ul>
                            <?php if (strpos($flag,'61')){?><li class="inline"><a href="total_yk.php" target="mainframe" class="clink">盈亏统计</a></li><?php } ?> 
							<?php if (strpos($flag,'62')){?><li class="inline"><a href="total_cz.php" target="mainframe" class="clink">充值统计</a></li><?php } ?> 
							<?php if (strpos($flag,'63')){?><li class="inline"><a href="total_tx.php" target="mainframe" class="clink">提现统计</a></li><?php } ?> 
							<?php if (strpos($flag,'64')){?><li class="inline"><a href="total_tz.php" target="mainframe" class="clink">投注统计</a></li><?php } ?> 
							<?php if (strpos($flag,'65')){?><li class="inline"><a href="total_prize.php" target="mainframe" class="clink">中奖统计</a></li><?php } ?> 
							<?php if (strpos($flag,'66')){?><li class="inline"><a href="total_rebate.php" target="mainframe" class="clink">返点统计</a></li><?php } ?> 
							<?php if (strpos($flag,'67')){?><li class="inline"><a href="total_fh.php" target="mainframe" class="clink">分红统计</a></li><?php } ?> 
							<?php if (strpos($flag,'68')){?><li class="inline"><a href="total_hd.php" target="mainframe" class="clink">活动统计</a></li><?php } ?> 
                        </ul>
                </div>
                <div class="sub-menu" id="tab-7" style=display:none>
                        <ul>
                            <?php if (strpos($flag,'71')){?><li class="inline"><a href="lottery_nums.php" target="mainframe" class="clink">时间管理</a></li><?php } ?> 
							<?php if (strpos($flag,'72')){?><li class="inline"><a href="lottery_data.php" target="mainframe" class="clink">开奖号码</a></li><?php } ?> 
							<?php if (strpos($flag,'73')){?><li class="inline"><a href="lottery_port.php" target="mainframe" class="clink">接口管理</a></li><?php } ?> 
							<?php if (strpos($flag,'74')){?><li class="inline"><a href="lottery_game.php" target="mainframe" class="clink">游戏设置</a></li><?php } ?> 
							<?php if (strpos($flag,'74')){?><li class="inline"><a href="lottery_set.php" target="mainframe" class="clink">彩种设置</a></li><?php } ?> 
							<?php if (strpos($flag,'75')){?><li class="inline"><a href="lottery_class.php" target="mainframe" class="clink">玩法设置</a></li><?php } ?> 
							<?php if (strpos($flag,'76')){?><li class="inline"><a href="lottery_bei.php" target="mainframe" class="clink">限倍管理</a></li><?php } ?> 
							<?php if (strpos($flag,'77')){?><li class="inline"><a href="lottery_zhu.php" target="mainframe" class="clink">限注管理</a></li><?php } ?> 
                        </ul>
                </div>
                <div class="sub-menu" id="tab-8" style=display:none>
                        <ul>
							<?php if (strpos($flag,'81')){?><li class="inline"><a href="lottery_rate.php" target="mainframe" class="clink">资金设置</a></li><?php } ?> 
							<?php if (strpos($flag,'82')){?><li class="inline"><a href="lottery_rebate.php" target="mainframe" class="clink">返点设置</a></li><?php } ?> 
                        </ul>
                </div>
          		<div class="sub-menu" id="tab-9" style=display:none>
                        <ul>
                            <?php if (strpos($flag,'91')){?><li class="inline"><a href="config.php" target="mainframe" class="clink">系统设置</a></li><?php } ?> 
							<?php if (strpos($flag,'92')){?><li class="inline"><a href="banks.php" target="mainframe" class="clink">银行设置</a></li><?php } ?> 
							<?php if (strpos($flag,'93')){?><li class="inline"><a href="banks_cz.php" target="mainframe" class="clink">充值设置</a></li><?php } ?> 
							<?php if (strpos($flag,'94')){?><li class="inline"><a href="banks_tx.php" target="mainframe" class="clink">提现设置</a></li><?php } ?> 
							<?php if (strpos($flag,'95')){?><li class="inline"><a href="activitys.php" target="mainframe" class="clink">活动设置</a></li><?php } ?> 
                            <?php if (strpos($flag,'96')){?><li class="inline"><a href="url.php" target="mainframe" class="clink">域名验证</a></li><?php } ?> 
							<?php if (strpos($flag,'97')){?><li class="inline"><a href="lockip.php" target="mainframe" class="clink">锁定IP</a></li><?php } ?> 
							<?php if (strpos($flag,'98')){?><li class="inline"><a href="backup.php" target="mainframe" class="clink">数据备份</a></li><?php } ?> 
							<?php if (strpos($flag,'99')){?><li class="inline"><a href="clear.php" target="mainframe" class="clink">数据清理</a></li><?php } ?> 
                        </ul>
          </div>
                <div class="sub-menu" id="tab-10" style=display:none>
                        <ul>
                            <?php if (strpos($flag,'a1')){?><li class="inline"><a href="manager.php" target="mainframe" class="clink">管理员</a></li><?php } ?> 
							<?php if (strpos($flag,'a2')){?><li class="inline"><a href="admin_logs.php" target="mainframe" class="clink">登录日志</a></li><?php } ?> 
							<?php if (strpos($flag,'a3')){?><li class="inline"><a href="admin_amend.php" target="mainframe" class="clink">操作记录</a></li><?php } ?> 
                        </ul>
          </div>
                <div class="sub-menu" id="tab-11" style=display:none>
                        <ul>
                            <?php if (strpos($flag,'b1')){?><li class="inline"><a href="plan_list.php" target="mainframe" class="clink">任务列表</a></li><?php } ?> 
                            <?php if (strpos($flag,'b2')){?><li class="inline"><a href="plan.php" target="mainframe" class="clink">任务日志</a></li><?php } ?> 
                        </ul>
                </div>
                <div class="sub-menu" id="tab-12" style=display:none>
                        <ul>
                            <?php if (strpos($flag,'c1')){?><li class="inline"><a href="intro1.php" target="mainframe" class="clink">玩法介绍</a></li><?php } ?> 
							<?php if (strpos($flag,'c2')){?><li class="inline"><a href="intro2.php" target="mainframe" class="clink">功能介绍</a></li><?php } ?> 
							<?php if (strpos($flag,'c3')){?><li class="inline"><a href="intro3.php" target="mainframe" class="clink">常见问题</a></li><?php } ?> 
                        </ul>
                </div>
				</div>
        </div><!-- header -->   
  </div><!-- wrapper -->
    
	</td>
</tr>
</table>

<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
    	<td style="width:198px; height:100%; background: #D94733;" valign="top" id="leftbox">
            <iframe name="leftframe" id="leftframe" frameborder="0" width="100%" height="100%" scrolling="auto" style="overflow:visible;" src="default_left.php"></iframe>
        </td>
        <td valign="top" id="dragbox"><img src="images/comm/t.gif" class='img_arrow_l' border="0" id="dragbutton" style="cursor:pointer;" /></td>
        <td id="mainbox" valign="top">

        <iframe name="mainframe" id="mainframe" frameborder="0" width="100%" height="100%" scrolling="auto" style="overflow:visible;" src="info.php"></iframe></td>
    </tr>
</table>
<EMBED NAME="SoundMSG1" SRC="Sound/msg1.mp3" LOOP=FALSE AUTOSTART=FALSE HIDDEN=TRUE MASTERSOUND>
<EMBED NAME="SoundMSG2" SRC="Sound/msg2.mp3" LOOP=FALSE AUTOSTART=FALSE HIDDEN=TRUE MASTERSOUND>
</BODY>
</HTML>