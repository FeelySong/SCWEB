<?php
session_start();
error_reporting(0);
require_once 'conn.php';
require_once 'check.php';

$flag=$_REQUEST['flag'];

if($flag=="insert"){
	
	if($_REQUEST['usertype']!="" && $_REQUEST['username']!="" && $_REQUEST['userpass']!="" && $_REQUEST['nickname']!=""){
		$sqla = "SELECT * FROM ssc_member where username='".$_REQUEST['username']."'";
		$rsa = mysql_query($sqla);
		$nums=mysql_num_rows($rsa);
		if($nums>0){
			$_SESSION["backtitle"]="用户名已存在";
			$_SESSION["backurl"]="users_add.php";
			$_SESSION["backzt"]="failed";
			$_SESSION["backname"]="增加用户";
			echo "<script language=javascript>window.location='sysmessage.php';</script>";
			exit;
		}
		if($_REQUEST['keeppoint']!=""){
			$rstra=explode(";",Get_member(rebate));
			for ($i=0; $i<count($rstra)-1; $i++) {
				$rstrb=explode(",",$rstra[$i]);
				$rebatea=$rebatea.$rstrb[0].",".judgez($rstrb[1]-$_REQUEST['keeppoint']).",".$rstrb[2].";";
				if($i==0){
					$flevel=judgez($rstrb[1]-$_REQUEST['keeppoint']);
				}
			}
		}else{
			$sqla = "SELECT * FROM ssc_classb order by id asc";
			$rsa = mysql_query($sqla);
			while ($row = mysql_fetch_array($rsa)){
				$pid=$row['cid']."_".$row['mid'];
				$rebatea=$rebatea.$pid.",".$_REQUEST['point_'.$pid].",1;";
				if($row['mid']=="1"){
					$flevel=$_REQUEST['point_1_1'];	
				}
			}
		}
		$regtop=Get_member(regtop);
		if($regtop==""){
			$regtop=$_SESSION["username"] ;
		}
		$sql = "insert into ssc_member set username='" . $_REQUEST['username'] . "', password='" . md5($_REQUEST['userpass']) . "', nickname='" . $_REQUEST['nickname'] . "', regfrom='&" .$_SESSION["username"] ."&".Get_member(regfrom) . "', regup='" . $_SESSION["username"] . "', regtop='" . $regtop . "', rebate='" . $rebatea . "', flevel='" . $flevel . "', level='" . $_REQUEST['usertype'] . "', regdate='" . date("Y-m-d H:i:s") . "'";
		$exe = mysql_query($sql);
		
		
		$sqla = "SELECT * FROM ssc_activity where id ='3'";
		$rsa = mysql_query($sqla);
		$rowa = mysql_fetch_array($rsa);
		if($rowa['zt']==1){
			if(date("Y-m-d H:i:s")>$rowa['starttime'] && date("Y-m-d H:i:s")<$rowa['endtime']){
				if(floatval($rowa['tjz'])>0){
					$sqlc = "select * from ssc_record order by id desc limit 1";		//帐变
					$rsc = mysql_query($sqlc);
					$rowc = mysql_fetch_array($rsc);
					$dan1 = sprintf("%07s",strtoupper(base_convert($rowc['id']+1,10,36)));
					
					$sqlc = "select * from ssc_member where username ='".$_REQUEST['username']."'";	
					$rsc = mysql_query($sqlc);
					$rowc = mysql_fetch_array($rsc);
					$uid=$rowc['id'];
					
					$sqlb="insert into ssc_record set dan='".$dan1."', uid='".$uid."', username='".$_REQUEST['username']."', types='32', smoney=".floatval($rowa['tjz']).",leftmoney=".(floatval($rowa['tjz'])).", regtop='" . $regtop . "', regup='" . $_SESSION["username"] . "', regfrom='&" .$_SESSION["username"] ."&".Get_member(regfrom) . "', adddate='".date("Y-m-d H:i:s")."'";
					$exe=mysql_query($sqlb) or  die("数据库修改出错6!!!".mysql_error());
					
					$sql="update ssc_member set leftmoney ='".floatval($rowa['tjz'])."' where username ='".$_REQUEST['username']."'";
					$exe=mysql_query($sql) or  die("数据库修改出错6!!!".mysql_error());
					
				}
			}
		}
		
		amend("增加用户 ".$_REQUEST['username']);	
		
		$_SESSION["backtitle"]="操作成功";
		$_SESSION["backurl"]="users_list.php";
		$_SESSION["backzt"]="successed";
		$_SESSION["backname"]="用户列表";
		echo "<script language=javascript>window.location='sysmessage.php';</script>";
		exit;
	}
}

$sql = "select * from ssc_member WHERE username='" . $_SESSION["username"] . "'";
$rs = mysql_query($sql);
$row = mysql_fetch_array($rs);
$stra=explode(";",$row['rebate']);
for ($i=0; $i<count($stra)-1; $i++) {
	$strb=explode(",",$stra[$i]);
//	echo $strb[0]."_".$strb[1]."_".$strb[2]."<br>";
	$strc=explode("_",$strb[0]);
	$rebate[$strc[1]]=$strb[1];
	$zt[$strc[1]]=$ztt[$strb[2]];
}

	$sqld = "select * from ssc_class order by id asc";
	$rsd = mysql_query($sqld);
	while ($rowd = mysql_fetch_array($rsd)){
		$strd=explode(";",$rowd['rates']);
		for ($i=0; $i<count($strd); $i++) {
			$rate[$rowd['mid']][$i]=$strd[$i];
		}
	}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD><TITLE><?php echo $webname;?>  - 增加用户</TITLE>
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
<SCRIPT LANGUAGE='JavaScript'>function ResumeError() {return true;} window.onerror = ResumeError; </SCRIPT> 
</HEAD>
<BODY STYLE='background-color:#838383;'>
<H1>
<SPAN class="action-span1"><DIV class='icons_mb1'></DIV>当前位置: <A href="/" target='_top'><?php echo $webname;?></a>
 - 增加用户 </SPAN><DIV style="clear:both"></DIV></H1>
<br/>
<script type="text/javascript">
;(function($){
$(document).ready(function(){
	$("span[id^='general_tab_']","#tabbar-div-s2").click(function(){
		$k = $(this).attr("id").replace("general_tab_","");
		$k = parseInt($k,10);
		$("span[id^='general_tab_']","#tabbar-div-s2").attr("class","tab-back");
		$("div[id^='general_txt_']").hide();
		$(this).attr("class","tab-front");
		$("#general_txt_"+$k).show();
		$k==1 ? $("span[id^='tabbar_tab_']:first").click() : "";
		$k==1 ? $("#addtype").val("xx") : $("#addtype").val("ks");
	});
	$("span[id^='tabbar_tab_']").click(function(){
		$z = $(this).attr("id").replace("tabbar_tab_","");
		$("span[id^='tabbar_tab_']").attr("class","tab-back");
		$("table[id^='tabbar_txt_']").hide();
		$(this).attr("class","tab-front");
		$("#tabbar_txt_"+$z).show();
	});
	$("span[id^='general_tab_']:first","#tabbar-div-s2").click();
		$(":checkbox[id^='selall_']").click(function(){
		var lotid = $(this).attr("id").replace("selall_","");
		$("#tabbar_txt_"+lotid).find("input[type='checkbox']").attr("checked",$(this).attr("checked"));
	});
	$("input[type='text'][name^='point_']").keyup(function(){
		$(this).val( filterPercent($(this).val()) );
		$(this).closest("tr").find("input[type='checkbox']").attr("checked",true);
	});
	$("input[type='button'][name^='tpbutton_']").click(function(){
		var lotid = $(this).attr("id").replace("tpbutton_","");
		var p = filterPercent($("#tpoint_"+lotid).val());
		$("input[type='text'][name^='point_'][title!='spec']","#tabbar_txt_"+lotid).val(p);
		$("input[type='checkbox'][id^='method_'][title!='spec']","#tabbar_txt_"+lotid).attr("checked",true);
	});
	$("input[type='text'][name^='tpoint_']").keyup(function(){
		$(this).val( filterPercent($(this).val()) );
	});
	$("#keeppoint").keyup(function(){
		$(this).val( filterPercent($(this).val()) );
	});
});
})(jQuery);
function checkform(obj)
{
  if( !validateUserName(obj.username.value) )
  {
     alert("登陆帐号 不符合规则，请重新输入");
	 obj.username.focus();
	 return false;
  }
  if( !validateUserPss(obj.userpass.value) )
  {
  	alert("登陆密码 不符合规则，请重新输入");
	obj.userpass.focus();
	return false;
  }
  if( !validateNickName(obj.nickname.value) )
  {
  	alert("呢称 不符合规则，请重新输入");
	obj.nickname.focus();
	return false;
  }
  if( $("#addtype").val() == 'xx' ){
  	isverfer = true;
	$("input[type='checkbox'][id^='method_']").each(function(){
		if( $(this).attr("checked") ==  true ){
			id   = $(this).attr("id").replace("method_","");
			maxp = Number($("input[name='maxpoint_"+id+"']").val());
			point= Number($("input[name='point_"+id+"']").val());
			if( point > maxp || point < Number(0.5) ){
				$("input[name='point_"+id+"']").nextAll("span").html('&nbsp;&nbsp;<font color="red">返点错误</font>').show();
				isverfer = false;
			}else{
				$("input[name='point_"+id+"']").nextAll("span").html('');
			}
		}
	});
	if( isverfer == false ){
		alert("返点设置错误，请检查");
		return false;
	}
  }else{
  	minp = Number($("#keepmin").val());
  	maxp = Number($("#keepmax").val());
	point= Number($("#keeppoint").val());
	if( point > maxp || point < minp ){
		alert("保留返点设置错误，请检查");
		return false;
	}
  }
  obj.submit.disabled=true;
  return true;
}
//返点输入框输入过滤
function filterPercent(num){
	num = num.replace(/^[^\d]/g,'');
	num = num.replace(/[^\d.]/g,'');
	num = num.replace(/\.{2,}/g,'.');
	num = num.replace(".","$#$").replace(/\./g,"").replace("$#$",".");
	if( num.indexOf(".") != -1 ){
		var data = num.split('.');
		num = (data[0].substr(0,3))+'.'+(data[1].substr(0,1));
	}else{
		num = num.substr(0,3);
	}
	num = num > 100 ? 100 : num;
	return num;
}
</script>

<CENTER>
<div class="div_s1" style='text-align:left'>
<form method="post" name="updateform" onsubmit="return checkform(this)">
<input type="hidden" name="addtype" id="addtype" value="ks" />
<input type="hidden" name="flag" value="insert" />
<div class='header'> &nbsp;&nbsp;填写基本信息</div>
<div class="tab-div-s2" STYLE='border-top: 1px solid #ededed;'>
    <div STYLE='background-color:#ededed;'><table class="ct2" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td width="10%" class="nl">用户级别:</td>
		<td width="85%">
			<label><input type="radio" name="usertype" value="1" checked="checked" />代理用户</label>&nbsp;&nbsp;
			<label><input type="radio" name="usertype" value="0" />会员用户</label>
		</td>
	  </tr>
	  <tr>
		<td class="nl">登陆帐号:</td>
		<td><input type="text" name="username" class='w160'/> <span class='helpinfo'>( 由0-9,a-z,A-Z组成的6-16个字符 )</span></td>
	  </tr>
	  <tr>
		<td class="nl">登陆密码:</td>
		<td><input type="password" name="userpass" class='w160'/> <span class='helpinfo'>( 由字母和数字组成6-16个字符；且必须包含数字和字母，不允许连续三位相同 )</span></td>
	  </tr>
	  <tr>
		<td class="nl">用户呢称:</td>
		<td><input type="text" name="nickname" class='w160'/> <span class='helpinfo'>( 由2至8个字符组成 )</span></td>
	  </tr>
      	</table></div>
	<table width='100%' border="0" cellspacing="0" cellpadding="0"><tr><td id="tabbar-div-s2">
	    <span class="tab-front"  id="general_tab_0">
		  <span class="tabbar-left"></span>
		  <span class="content">快速设置</span>
		  <span class="tabbar-right"></span>
		</span>
		<span class="tab-back"  id="general_tab_1">
		  <span class="tabbar-left"></span>
		  <span class="content">详细设置</span>
		  <span class="tabbar-right"></span>
		</span>
	</td></tr>
	</table>
	<div class='bd'><div class='bd2' id="general_txt_0"><BR/>
		<div STYLE='margin:0px 30px 16px 20px;padding-bottom:5px;color:#333333;line-height:22px;border-bottom:1px dotted #fff;'>
		提示信息：此处的<font color='#0251e4'>“快速设置”</font>及“详细设置”只能二选一填写。<BR/>
	　　例如：您当前的直选返点为 0.8% 并且您的不定位返点为 0.6%， 而您在下面 “保留返点”处填写 0.5<BR/>
	　　那么：您开设新账户的直选返点即为  0.3%,  不定位返点为 0.1%<BR/>
		</div>
	    	<div STYLE='margin:0 0 18px 40px;font-size:12px;color:#333;'><font color="#333">您的返点级别：<?=Get_member(flevel)?></font>&nbsp;&nbsp;&nbsp;&nbsp;保留返点: 
		<input type="text" name="keeppoint" id="keeppoint" style='width:45px;' value="0.5"/><input type="hidden" name="keepmin" id="keepmin" value="0.5" /><input type="hidden" name="keepmax" id="keepmax" value="<?=Get_member(flevel)?>" /> % ( 可填范围: 0.5～<?=Get_member(flevel)?> )
		&nbsp;&nbsp;&nbsp;&nbsp;
		<input name='submit1' type="submit" value="&nbsp;执行开户&nbsp;">
	</div>
	</div></div>
	<div class='bd' style='_width:100%; width:100%;'><div class='bd2' id="general_txt_1"><BR/>
		<div STYLE='margin:0px 0px 16px 0px;padding-bottom:5px;color:#333;line-height:18px;border-bottom:1px dotted #626262;'>
		&nbsp;&nbsp;提示信息：此处的“快速设置”及<font color='#0251e4'>“详细设置”</font>只能二选一填写。<BR/>
		</div>
    	<table class="tabbar-div-s3" width='100%' border="0" cellspacing="0" cellpadding="0">
	  <tr>
        <td>
						 <span id="tabbar_tab_1" class="tab-back" TITLE='重庆时时彩 (CQSSC)' ALT='重庆时时彩 (CQSSC)'>
				<span class="tabbar-left"></span>
				<span class="content">重庆</span>
				<span class="tabbar-right"></span>
			 </span>
						 <span id="tabbar_tab_2" class="tab-back" TITLE='SC五分彩 (HLJSSC)' ALT='SC五分彩 (HLJSSC)'>
				<span class="tabbar-left"></span>
				<span class="content">全天</span>
				<span class="tabbar-right"></span>
			 </span>
						 <span id="tabbar_tab_3" class="tab-back" TITLE='新疆时时彩 (XJSSC)' ALT='新疆时时彩 (XJSSC)'>
				<span class="tabbar-left"></span>
				<span class="content">新疆</span>
				<span class="tabbar-right"></span>
			 </span>
						 <span id="tabbar_tab_4" class="tab-back" TITLE='江西时时彩 (JXSSC)' ALT='江西时时彩 (JXSSC)'>
				<span class="tabbar-left"></span>
				<span class="content">江西</span>
				<span class="tabbar-right"></span>
			 </span>
						 <span id="tabbar_tab_5" class="tab-back" TITLE='上海时时乐 (SHSSL)' ALT='上海时时乐 (SHSSL)'>
				<span class="tabbar-left"></span>
				<span class="content">时时乐</span>
				<span class="tabbar-right"></span>
			 </span>
						 <span id="tabbar_tab_6" class="tab-back" TITLE='十一运夺金 (山东11选5,SD11-5)' ALT='十一运夺金 (山东11选5,SD11-5)'>
				<span class="tabbar-left"></span>
				<span class="content">十一运</span>
				<span class="tabbar-right"></span>
			 </span>
						 <span id="tabbar_tab_7" class="tab-back" TITLE='多乐彩 (江西11选5,JX11-5)' ALT='多乐彩 (江西11选5,JX11-5)'>
				<span class="tabbar-left"></span>
				<span class="content">多乐彩</span>
				<span class="tabbar-right"></span>
			 </span>
						 <span id="tabbar_tab_8" class="tab-back" TITLE='广东11选5 (GD11-5)' ALT='广东11选5 (GD11-5)'>
				<span class="tabbar-left"></span>
				<span class="content">广东11选5</span>
				<span class="tabbar-right"></span>
			 </span>
						 <span id="tabbar_tab_9" class="tab-back" TITLE='福彩3D (3D)' ALT='福彩3D (3D)'>
				<span class="tabbar-left"></span>
				<span class="content">3D</span>
				<span class="tabbar-right"></span>
			 </span>
						 <span id="tabbar_tab_10" class="tab-back" TITLE='排列三、五 (P3P5)' ALT='排列三、五 (P3P5)'>
				<span class="tabbar-left"></span>
				<span class="content">排列3-5</span>
				<span class="tabbar-right"></span>
			 </span>
						 <span id="tabbar_tab_11" class="tab-back" TITLE='重庆十一选五' ALT='重庆十一选五'>
				<span class="tabbar-left"></span>
				<span class="content">重庆11选5</span>
				<span class="tabbar-right"></span>
			 </span>
					</td>
	  </tr>
	</table>
	<div class="ld" style='margin:auto;width:96%; margin:0px 10px 0px 10px;'>
    	<table class="lt" id="tabbar_txt_1" style="display:none;" border="0" cellspacing="0" cellpadding="0">
		<tr class='th' id="tabbar_title_1">
			<td width=10%><input type="checkbox" id="selall_1" checked="checked" />全选</td>
			<td><div class='line'></div>玩法</td>
			<td><div class='line'></div>
                        奖金
                        </td>
			<td><div class='line'></div>统一返点 <input type="text" style="width:70px;" value="0" name="tpoint_1" id="tpoint_1">% <input type="button" STYLE='height:24px;' name="tpbutton_1" id="tpbutton_1" value="统一设置"></td>
		</tr>
        <tr><td align="center"><input type="checkbox" title="spec" name="method_1_5" id="method_1_5" value="1" checked="checked"></td><td align="center">一码不定位</td><td align="center">奖金：<?=$rate[26][0]?><br /></td><td align="center">返点 <input type="text" title="spec" style="width:70px;" value="0" name="point_1_5"><input type="hidden" name="maxpoint_1_5" value="<?=$rebate[5]?>">% (范围：0.5~<?=$rebate[5]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_1_6" id="method_1_6" value="1" checked="checked"></td><td align="center">二码不定位</td><td align="center">奖金：<?=$rate[27][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_1_6"><input type="hidden" name="maxpoint_1_6" value="<?=$rebate[6]?>">% (范围：0.5~<?=$rebate[6]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_1_1" id="method_1_1" value="1" checked="checked"></td><td align="center">前三直选</td><td align="center">奖金：<?=$rate[14][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_1_1"><input type="hidden" name="maxpoint_1_1" value="<?=$rebate[1]?>">% (范围：0.5~<?=$rebate[1]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_1_2" id="method_1_2" value="1" checked="checked"></td><td align="center">后三直选</td><td align="center">奖金：<?=$rate[16][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_1_2"><input type="hidden" name="maxpoint_1_2" value="<?=$rebate[2]?>">% (范围：0.5~<?=$rebate[2]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_1_3" id="method_1_3" value="1" checked="checked"></td><td align="center">前三组选</td><td align="center">组三奖金：<?=$rate[20][0]?><br />组六奖金：<?=$rate[20][1]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_1_3"><input type="hidden" name="maxpoint_1_3" value="<?=$rebate[3]?>">% (范围：0.5~<?=$rebate[3]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_1_4" id="method_1_4" value="1" checked="checked"></td><td align="center">后三组选</td><td align="center">组三奖金：<?=$rate[24][0]?><br />组六奖金：<?=$rate[24][1]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_1_4"><input type="hidden" name="maxpoint_1_4" value="<?=$rebate[4]?>">% (范围：0.5~<?=$rebate[4]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_1_7" id="method_1_7" value="1" checked="checked"></td><td align="center">前二直选</td><td align="center">奖金：<?=$rate[28][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_1_7"><input type="hidden" name="maxpoint_1_7" value="<?=$rebate[7]?>">% (范围：0.5~<?=$rebate[7]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_1_8" id="method_1_8" value="1" checked="checked"></td><td align="center">后二直选</td><td align="center">奖金：<?=$rate[29][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_1_8"><input type="hidden" name="maxpoint_1_8" value="<?=$rebate[8]?>">% (范围：0.5~<?=$rebate[8]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_1_9" id="method_1_9" value="1" checked="checked"></td><td align="center">前二组选</td><td align="center">奖金：<?=$rate[30][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_1_9"><input type="hidden" name="maxpoint_1_9" value="<?=$rebate[9]?>">% (范围：0.5~<?=$rebate[9]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_1_10" id="method_1_10" value="1" checked="checked"></td><td align="center">后二组选</td><td align="center">奖金：<?=$rate[31][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_1_10"><input type="hidden" name="maxpoint_1_10" value="<?=$rebate[10]?>">% (范围：0.5~<?=$rebate[10]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_1_11" id="method_1_11" value="1" checked="checked"></td><td align="center">定位胆</td><td align="center">奖金：<?=$rate[32][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_1_11"><input type="hidden" name="maxpoint_1_11" value="<?=$rebate[11]?>">% (范围：0.5~<?=$rebate[11]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_1_12" id="method_1_12" value="1" checked="checked"></td><td align="center">大小单双(前二)</td><td align="center">奖金：<?=$rate[37][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_1_12"><input type="hidden" name="maxpoint_1_12" value="<?=$rebate[12]?>">% (范围：0.5~<?=$rebate[12]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_1_13" id="method_1_13" value="1" checked="checked"></td><td align="center">大小单双(后二)</td><td align="center">奖金：<?=$rate[38][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_1_13"><input type="hidden" name="maxpoint_1_13" value="<?=$rebate[13]?>">% (范围：0.5~<?=$rebate[13]?>%)<span></span></td></tr>	</table>
    	<table class="lt" id="tabbar_txt_2" style="display:none;" border="0" cellspacing="0" cellpadding="0">
		<tr class='th' id="tabbar_title_2">
			<td width=10%><input type="checkbox" id="selall_2" checked="checked" />全选</td>
			<td><div class='line'></div>玩法</td>
			<td><div class='line'></div>
                        奖金
                        </td>
			<td><div class='line'></div>统一返点 <input type="text" style="width:70px;" value="0" name="tpoint_2" id="tpoint_2">% <input type="button" STYLE='height:24px;' name="tpbutton_2" id="tpbutton_2" value="统一设置"></td>
		</tr>
        <tr><td align="center"><input type="checkbox" title="spec" name="method_2_43" id="method_2_43" value="1" checked="checked"></td><td align="center">一码不定位</td><td align="center">奖金：<?=$rate[64][0]?><br /></td><td align="center">返点 <input type="text" title="spec" style="width:70px;" value="0" name="point_2_43"><input type="hidden" name="maxpoint_2_43" value="<?=$rebate[43]?>">% (范围：0.5~<?=$rebate[43]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_2_44" id="method_2_44" value="1" checked="checked"></td><td align="center">二码不定位</td><td align="center">奖金：<?=$rate[65][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_2_44"><input type="hidden" name="maxpoint_2_44" value="<?=$rebate[44]?>">% (范围：0.5~<?=$rebate[44]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_2_39" id="method_2_39" value="1" checked="checked"></td><td align="center">前三直选</td><td align="center">奖金：<?=$rate[52][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_2_39"><input type="hidden" name="maxpoint_2_39" value="<?=$rebate[39]?>">% (范围：0.5~<?=$rebate[39]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_2_40" id="method_2_40" value="1" checked="checked"></td><td align="center">后三直选</td><td align="center">奖金：<?=$rate[54][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_2_40"><input type="hidden" name="maxpoint_2_40" value="<?=$rebate[40]?>">% (范围：0.5~<?=$rebate[40]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_2_41" id="method_2_41" value="1" checked="checked"></td><td align="center">前三组选</td><td align="center">组三奖金：<?=$rate[58][0]?><br />组六奖金：<?=$rate[58][1]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_2_41"><input type="hidden" name="maxpoint_2_41" value="<?=$rebate[41]?>">% (范围：0.5~<?=$rebate[41]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_2_42" id="method_2_42" value="1" checked="checked"></td><td align="center">后三组选</td><td align="center">组三奖金：<?=$rate[62][0]?><br />组六奖金：<?=$rate[62][1]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_2_42"><input type="hidden" name="maxpoint_2_42" value="<?=$rebate[42]?>">% (范围：0.5~<?=$rebate[42]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_2_45" id="method_2_45" value="1" checked="checked"></td><td align="center">前二直选</td><td align="center">奖金：<?=$rate[66][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_2_45"><input type="hidden" name="maxpoint_2_45" value="<?=$rebate[45]?>">% (范围：0.5~<?=$rebate[45]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_2_46" id="method_2_46" value="1" checked="checked"></td><td align="center">后二直选</td><td align="center">奖金：<?=$rate[67][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_2_46"><input type="hidden" name="maxpoint_2_46" value="<?=$rebate[46]?>">% (范围：0.5~<?=$rebate[46]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_2_47" id="method_2_47" value="1" checked="checked"></td><td align="center">前二组选</td><td align="center">奖金：<?=$rate[68][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_2_47"><input type="hidden" name="maxpoint_2_47" value="<?=$rebate[47]?>">% (范围：0.5~<?=$rebate[47]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_2_48" id="method_2_48" value="1" checked="checked"></td><td align="center">后二组选</td><td align="center">奖金：<?=$rate[69][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_2_48"><input type="hidden" name="maxpoint_2_48" value="<?=$rebate[48]?>">% (范围：0.5~<?=$rebate[48]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_2_49" id="method_2_49" value="1" checked="checked"></td><td align="center">定位胆</td><td align="center">奖金：<?=$rate[70][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_2_49"><input type="hidden" name="maxpoint_2_49" value="<?=$rebate[49]?>">% (范围：0.5~<?=$rebate[49]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_2_50" id="method_2_50" value="1" checked="checked"></td><td align="center">大小单双(前二)</td><td align="center">奖金：<?=$rate[75][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_2_50"><input type="hidden" name="maxpoint_2_50" value="<?=$rebate[50]?>">% (范围：0.5~<?=$rebate[50]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_2_51" id="method_2_51" value="1" checked="checked"></td><td align="center">大小单双(后二)</td><td align="center">奖金：<?=$rate[76][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_2_51"><input type="hidden" name="maxpoint_2_51" value="<?=$rebate[51]?>">% (范围：0.5~<?=$rebate[51]?>%)<span></span></td></tr>	</table>
    	<table class="lt" id="tabbar_txt_3" style="display:none;" border="0" cellspacing="0" cellpadding="0">
		<tr class='th' id="tabbar_title_3">
			<td width=10%><input type="checkbox" id="selall_3" checked="checked" />全选</td>
			<td><div class='line'></div>玩法</td>
			<td><div class='line'></div>
                        奖金
                        </td>
			<td><div class='line'></div>统一返点 <input type="text" style="width:70px;" value="0" name="tpoint_3" id="tpoint_3">% <input type="button" STYLE='height:24px;' name="tpbutton_3" id="tpbutton_3" value="统一设置"></td>
		</tr>
        <tr><td align="center"><input type="checkbox" title="spec" name="method_3_81" id="method_3_81" value="1" checked="checked"></td><td align="center">一码不定位</td><td align="center">奖金：<?=$rate[102][0]?><br /></td><td align="center">返点 <input type="text" title="spec" style="width:70px;" value="0" name="point_3_81"><input type="hidden" name="maxpoint_3_81" value="<?=$rebate[81]?>">% (范围：0.5~<?=$rebate[81]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_3_82" id="method_3_82" value="1" checked="checked"></td><td align="center">二码不定位</td><td align="center">奖金：<?=$rate[103][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_3_82"><input type="hidden" name="maxpoint_3_82" value="<?=$rebate[82]?>">% (范围：0.5~<?=$rebate[82]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_3_77" id="method_3_77" value="1" checked="checked"></td><td align="center">前三直选</td><td align="center">奖金：<?=$rate[90][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_3_77"><input type="hidden" name="maxpoint_3_77" value="<?=$rebate[77]?>">% (范围：0.5~<?=$rebate[77]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_3_78" id="method_3_78" value="1" checked="checked"></td><td align="center">后三直选</td><td align="center">奖金：<?=$rate[92][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_3_78"><input type="hidden" name="maxpoint_3_78" value="<?=$rebate[78]?>">% (范围：0.5~<?=$rebate[78]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_3_79" id="method_3_79" value="1" checked="checked"></td><td align="center">前三组选</td><td align="center">组三奖金：<?=$rate[96][0]?><br />组六奖金：<?=$rate[96][1]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_3_79"><input type="hidden" name="maxpoint_3_79" value="<?=$rebate[79]?>">% (范围：0.5~<?=$rebate[79]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_3_80" id="method_3_80" value="1" checked="checked"></td><td align="center">后三组选</td><td align="center">组三奖金：<?=$rate[100][0]?><br />组六奖金：<?=$rate[100][1]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_3_80"><input type="hidden" name="maxpoint_3_80" value="<?=$rebate[80]?>">% (范围：0.5~<?=$rebate[80]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_3_83" id="method_3_83" value="1" checked="checked"></td><td align="center">前二直选</td><td align="center">奖金：<?=$rate[104][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_3_83"><input type="hidden" name="maxpoint_3_83" value="<?=$rebate[83]?>">% (范围：0.5~<?=$rebate[83]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_3_84" id="method_3_84" value="1" checked="checked"></td><td align="center">后二直选</td><td align="center">奖金：<?=$rate[105][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_3_84"><input type="hidden" name="maxpoint_3_84" value="<?=$rebate[84]?>">% (范围：0.5~<?=$rebate[84]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_3_85" id="method_3_85" value="1" checked="checked"></td><td align="center">前二组选</td><td align="center">奖金：<?=$rate[106][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_3_85"><input type="hidden" name="maxpoint_3_85" value="<?=$rebate[85]?>">% (范围：0.5~<?=$rebate[85]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_3_86" id="method_3_86" value="1" checked="checked"></td><td align="center">后二组选</td><td align="center">奖金：<?=$rate[107][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_3_86"><input type="hidden" name="maxpoint_3_86" value="<?=$rebate[86]?>">% (范围：0.5~<?=$rebate[86]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_3_87" id="method_3_87" value="1" checked="checked"></td><td align="center">定位胆</td><td align="center">奖金：<?=$rate[108][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_3_87"><input type="hidden" name="maxpoint_3_87" value="<?=$rebate[87]?>">% (范围：0.5~<?=$rebate[87]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_3_88" id="method_3_88" value="1" checked="checked"></td><td align="center">大小单双(前二)</td><td align="center">奖金：<?=$rate[113][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_3_88"><input type="hidden" name="maxpoint_3_88" value="<?=$rebate[88]?>">% (范围：0.5~<?=$rebate[88]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_3_89" id="method_3_89" value="1" checked="checked"></td><td align="center">大小单双(后二)</td><td align="center">奖金：<?=$rate[114][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_3_89"><input type="hidden" name="maxpoint_3_89" value="<?=$rebate[89]?>">% (范围：0.5~<?=$rebate[89]?>%)<span></span></td></tr>	</table>
    	<table class="lt" id="tabbar_txt_4" style="display:none;" border="0" cellspacing="0" cellpadding="0">
		<tr class='th' id="tabbar_title_4">
			<td width=10%><input type="checkbox" id="selall_4" checked="checked" />全选</td>
			<td><div class='line'></div>玩法</td>
			<td><div class='line'></div>
                        奖金
                        </td>
			<td><div class='line'></div>统一返点 <input type="text" style="width:70px;" value="0" name="tpoint_4" id="tpoint_4">% <input type="button" STYLE='height:24px;' name="tpbutton_4" id="tpbutton_4" value="统一设置"></td>
		</tr>
        <tr><td align="center"><input type="checkbox" title="spec" name="method_4_119" id="method_4_119" value="1" checked="checked"></td><td align="center">一码不定位</td><td align="center">奖金：<?=$rate[140][0]?><br /></td><td align="center">返点 <input type="text" title="spec" style="width:70px;" value="0" name="point_4_119"><input type="hidden" name="maxpoint_4_119" value="<?=$rebate[119]?>">% (范围：0.5~<?=$rebate[119]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_4_120" id="method_4_120" value="1" checked="checked"></td><td align="center">二码不定位</td><td align="center">奖金：<?=$rate[141][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_4_120"><input type="hidden" name="maxpoint_4_120" value="<?=$rebate[120]?>">% (范围：0.5~<?=$rebate[120]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_4_115" id="method_4_115" value="1" checked="checked"></td><td align="center">前三直选</td><td align="center">奖金：<?=$rate[128][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_4_115"><input type="hidden" name="maxpoint_4_115" value="<?=$rebate[115]?>">% (范围：0.5~<?=$rebate[115]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_4_116" id="method_4_116" value="1" checked="checked"></td><td align="center">后三直选</td><td align="center">奖金：<?=$rate[130][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_4_116"><input type="hidden" name="maxpoint_4_116" value="<?=$rebate[116]?>">% (范围：0.5~<?=$rebate[116]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_4_117" id="method_4_117" value="1" checked="checked"></td><td align="center">前三组选</td><td align="center">组三奖金：<?=$rate[134][0]?><br />组六奖金：<?=$rate[134][1]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_4_117"><input type="hidden" name="maxpoint_4_117" value="<?=$rebate[117]?>">% (范围：0.5~<?=$rebate[117]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_4_118" id="method_4_118" value="1" checked="checked"></td><td align="center">后三组选</td><td align="center">组三奖金：<?=$rate[138][0]?><br />组六奖金：<?=$rate[138][1]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_4_118"><input type="hidden" name="maxpoint_4_118" value="<?=$rebate[118]?>">% (范围：0.5~<?=$rebate[118]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_4_121" id="method_4_121" value="1" checked="checked"></td><td align="center">前二直选</td><td align="center">奖金：<?=$rate[142][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_4_121"><input type="hidden" name="maxpoint_4_121" value="<?=$rebate[121]?>">% (范围：0.5~<?=$rebate[121]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_4_122" id="method_4_122" value="1" checked="checked"></td><td align="center">后二直选</td><td align="center">奖金：<?=$rate[143][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_4_122"><input type="hidden" name="maxpoint_4_122" value="<?=$rebate[122]?>">% (范围：0.5~<?=$rebate[122]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_4_123" id="method_4_123" value="1" checked="checked"></td><td align="center">前二组选</td><td align="center">奖金：<?=$rate[144][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_4_123"><input type="hidden" name="maxpoint_4_123" value="<?=$rebate[123]?>">% (范围：0.5~<?=$rebate[123]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_4_124" id="method_4_124" value="1" checked="checked"></td><td align="center">后二组选</td><td align="center">奖金：<?=$rate[145][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_4_124"><input type="hidden" name="maxpoint_4_124" value="<?=$rebate[124]?>">% (范围：0.5~<?=$rebate[124]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_4_125" id="method_4_125" value="1" checked="checked"></td><td align="center">定位胆</td><td align="center">奖金：<?=$rate[146][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_4_125"><input type="hidden" name="maxpoint_4_125" value="<?=$rebate[125]?>">% (范围：0.5~<?=$rebate[125]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_4_126" id="method_4_126" value="1" checked="checked"></td><td align="center">大小单双(前二)</td><td align="center">奖金：<?=$rate[151][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_4_126"><input type="hidden" name="maxpoint_4_126" value="<?=$rebate[126]?>">% (范围：0.5~<?=$rebate[126]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_4_127" id="method_4_127" value="1" checked="checked"></td><td align="center">大小单双(后二)</td><td align="center">奖金：<?=$rate[152][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_4_127"><input type="hidden" name="maxpoint_4_127" value="<?=$rebate[127]?>">% (范围：0.5~<?=$rebate[127]?>%)<span></span></td></tr>	</table>
    	<table class="lt" id="tabbar_txt_5" style="display:none;" border="0" cellspacing="0" cellpadding="0">
		<tr class='th' id="tabbar_title_5">
			<td width=10%><input type="checkbox" id="selall_5" checked="checked" />全选</td>
			<td><div class='line'></div>玩法</td>
			<td><div class='line'></div>
                        奖金
                        </td>
			<td><div class='line'></div>统一返点 <input type="text" style="width:70px;" value="0" name="tpoint_5" id="tpoint_5">% <input type="button" STYLE='height:24px;' name="tpbutton_5" id="tpbutton_5" value="统一设置"></td>
		</tr>
        <tr><td align="center"><input type="checkbox" title="spec" name="method_5_155" id="method_5_155" value="1" checked="checked"></td><td align="center">一码不定位</td><td align="center">奖金：<?=$rate[170][0]?><br /></td><td align="center">返点 <input type="text" title="spec" style="width:70px;" value="0" name="point_5_155"><input type="hidden" name="maxpoint_5_155" value="<?=$rebate[155]?>">% (范围：0.5~<?=$rebate[155]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_5_156" id="method_5_156" value="1" checked="checked"></td><td align="center">二码不定位</td><td align="center">奖金：<?=$rate[171][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_5_156"><input type="hidden" name="maxpoint_5_156" value="<?=$rebate[156]?>">% (范围：0.5~<?=$rebate[156]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_5_153" id="method_5_153" value="1" checked="checked"></td><td align="center">直选</td><td align="center">奖金：<?=$rate[164][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_5_153"><input type="hidden" name="maxpoint_5_153" value="<?=$rebate[153]?>">% (范围：0.5~<?=$rebate[153]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_5_154" id="method_5_154" value="1" checked="checked"></td><td align="center">组选</td><td align="center">组三奖金：<?=$rate[168][0]?><br />组六奖金：<?=$rate[168][1]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_5_154"><input type="hidden" name="maxpoint_5_154" value="<?=$rebate[154]?>">% (范围：0.5~<?=$rebate[154]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_5_157" id="method_5_157" value="1" checked="checked"></td><td align="center">前二直选</td><td align="center">奖金：<?=$rate[172][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_5_157"><input type="hidden" name="maxpoint_5_157" value="<?=$rebate[157]?>">% (范围：0.5~<?=$rebate[157]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_5_158" id="method_5_158" value="1" checked="checked"></td><td align="center">后二直选</td><td align="center">奖金：<?=$rate[173][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_5_158"><input type="hidden" name="maxpoint_5_158" value="<?=$rebate[158]?>">% (范围：0.5~<?=$rebate[158]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_5_159" id="method_5_159" value="1" checked="checked"></td><td align="center">前二组选</td><td align="center">奖金：<?=$rate[174][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_5_159"><input type="hidden" name="maxpoint_5_159" value="<?=$rebate[159]?>">% (范围：0.5~<?=$rebate[159]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_5_160" id="method_5_160" value="1" checked="checked"></td><td align="center">后二组选</td><td align="center">奖金：<?=$rate[175][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_5_160"><input type="hidden" name="maxpoint_5_160" value="<?=$rebate[160]?>">% (范围：0.5~<?=$rebate[160]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_5_161" id="method_5_161" value="1" checked="checked"></td><td align="center">定位胆</td><td align="center">奖金：<?=$rate[176][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_5_161"><input type="hidden" name="maxpoint_5_161" value="<?=$rebate[161]?>">% (范围：0.5~<?=$rebate[161]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_5_162" id="method_5_162" value="1" checked="checked"></td><td align="center">大小单双(前二)</td><td align="center">奖金：<?=$rate[179][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_5_162"><input type="hidden" name="maxpoint_5_162" value="<?=$rebate[162]?>">% (范围：0.5~<?=$rebate[162]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_5_163" id="method_5_163" value="1" checked="checked"></td><td align="center">大小单双(后二)</td><td align="center">奖金：<?=$rate[180][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_5_163"><input type="hidden" name="maxpoint_5_163" value="<?=$rebate[163]?>">% (范围：0.5~<?=$rebate[163]?>%)<span></span></td></tr>	</table>
    	<table class="lt" id="tabbar_txt_6" style="display:none;" border="0" cellspacing="0" cellpadding="0">
		<tr class='th' id="tabbar_title_6">
			<td width=10%><input type="checkbox" id="selall_6" checked="checked" />全选</td>
			<td><div class='line'></div>玩法</td>
			<td><div class='line'></div>
                        奖金
                        </td>
			<td><div class='line'></div>统一返点 <input type="text" style="width:70px;" value="0" name="tpoint_6" id="tpoint_6">% <input type="button" STYLE='height:24px;' name="tpbutton_6" id="tpbutton_6" value="统一设置"></td>
		</tr>
        <tr><td align="center"><input type="checkbox" name="method_6_181" id="method_6_181" value="1" checked="checked"></td><td align="center">前三直选</td><td align="center">奖金：<?=$rate[197][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_6_181"><input type="hidden" name="maxpoint_6_181" value="<?=$rebate[181]?>">% (范围：0.5~<?=$rebate[181]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_6_182" id="method_6_182" value="1" checked="checked"></td><td align="center">前三组选</td><td align="center">奖金：<?=$rate[198][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_6_182"><input type="hidden" name="maxpoint_6_182" value="<?=$rebate[182]?>">% (范围：0.5~<?=$rebate[182]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_6_183" id="method_6_183" value="1" checked="checked"></td><td align="center">前二直选</td><td align="center">奖金：<?=$rate[199][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_6_183"><input type="hidden" name="maxpoint_6_183" value="<?=$rebate[183]?>">% (范围：0.5~<?=$rebate[183]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_6_184" id="method_6_184" value="1" checked="checked"></td><td align="center">前二组选</td><td align="center">奖金：<?=$rate[200][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_6_184"><input type="hidden" name="maxpoint_6_184" value="<?=$rebate[184]?>">% (范围：0.5~<?=$rebate[184]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_6_185" id="method_6_185" value="1" checked="checked"></td><td align="center">不定位</td><td align="center">奖金：<?=$rate[201][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_6_185"><input type="hidden" name="maxpoint_6_185" value="<?=$rebate[185]?>">% (范围：0.5~<?=$rebate[185]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_6_186" id="method_6_186" value="1" checked="checked"></td><td align="center">定位胆</td><td align="center">奖金：<?=$rate[202][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_6_186"><input type="hidden" name="maxpoint_6_186" value="<?=$rebate[186]?>">% (范围：0.5~<?=$rebate[186]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_6_187" id="method_6_187" value="1" checked="checked"></td><td align="center">定单双</td><td align="center">0单5双：<?=$rate[205][0]?><br />5单0双：<?=$rate[205][1]?><br />1单4双：<?=$rate[205][2]?><br />4单1双：<?=$rate[205][3]?><br />2单3双：<?=$rate[205][4]?><br />3单2双：<?=$rate[205][5]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_6_187"><input type="hidden" name="maxpoint_6_187" value="<?=$rebate[187]?>">% (范围：0.5~<?=$rebate[187]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_6_188" id="method_6_188" value="1" checked="checked"></td><td align="center">猜中位</td><td align="center">03,09：<?=$rate[206][0]?><br />04,08：<?=$rate[206][1]?><br />05,07：<?=$rate[206][2]?><br />06：<?=$rate[206][3]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_6_188"><input type="hidden" name="maxpoint_6_188" value="<?=$rebate[188]?>">% (范围：0.5~<?=$rebate[188]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_6_189" id="method_6_189" value="1" checked="checked"></td><td align="center">任选一中一</td><td align="center">奖金：<?=$rate[207][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_6_189"><input type="hidden" name="maxpoint_6_189" value="<?=$rebate[189]?>">% (范围：0.5~<?=$rebate[189]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_6_190" id="method_6_190" value="1" checked="checked"></td><td align="center">任选二中二</td><td align="center">奖金：<?=$rate[208][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_6_190"><input type="hidden" name="maxpoint_6_190" value="<?=$rebate[190]?>">% (范围：0.5~<?=$rebate[190]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_6_191" id="method_6_191" value="1" checked="checked"></td><td align="center">任选三中三</td><td align="center">奖金：<?=$rate[209][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_6_191"><input type="hidden" name="maxpoint_6_191" value="<?=$rebate[191]?>">% (范围：0.5~<?=$rebate[191]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_6_192" id="method_6_192" value="1" checked="checked"></td><td align="center">任选四中四</td><td align="center">奖金：<?=$rate[210][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_6_192"><input type="hidden" name="maxpoint_6_192" value="<?=$rebate[192]?>">% (范围：0.5~<?=$rebate[192]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_6_193" id="method_6_193" value="1" checked="checked"></td><td align="center">任选五中五</td><td align="center">奖金：<?=$rate[211][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_6_193"><input type="hidden" name="maxpoint_6_193" value="<?=$rebate[193]?>">% (范围：0.5~<?=$rebate[193]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_6_194" id="method_6_194" value="1" checked="checked"></td><td align="center">任选六中五</td><td align="center">奖金：<?=$rate[212][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_6_194"><input type="hidden" name="maxpoint_6_194" value="<?=$rebate[194]?>">% (范围：0.5~<?=$rebate[194]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_6_195" id="method_6_195" value="1" checked="checked"></td><td align="center">任选七中五</td><td align="center">奖金：<?=$rate[213][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_6_195"><input type="hidden" name="maxpoint_6_195" value="<?=$rebate[195]?>">% (范围：0.5~<?=$rebate[195]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_6_196" id="method_6_196" value="1" checked="checked"></td><td align="center">任选八中五</td><td align="center">奖金：<?=$rate[214][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_6_196"><input type="hidden" name="maxpoint_6_196" value="<?=$rebate[196]?>">% (范围：0.5~<?=$rebate[196]?>%)<span></span></td></tr>	</table>
    	<table class="lt" id="tabbar_txt_7" style="display:none;" border="0" cellspacing="0" cellpadding="0">
		<tr class='th' id="tabbar_title_7">
			<td width=10%><input type="checkbox" id="selall_7" checked="checked" />全选</td>
			<td><div class='line'></div>玩法</td>
			<td><div class='line'></div>
                        奖金
                        </td>
			<td><div class='line'></div>统一返点 <input type="text" style="width:70px;" value="0" name="tpoint_7" id="tpoint_7">% <input type="button" STYLE='height:24px;' name="tpbutton_7" id="tpbutton_7" value="统一设置"></td>
		</tr>
        <tr><td align="center"><input type="checkbox" name="method_7_215" id="method_7_215" value="1" checked="checked"></td><td align="center">前三直选</td><td align="center">奖金：<?=$rate[231][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_7_215"><input type="hidden" name="maxpoint_7_215" value="<?=$rebate[215]?>">% (范围：0.5~<?=$rebate[215]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_7_216" id="method_7_216" value="1" checked="checked"></td><td align="center">前三组选</td><td align="center">奖金：<?=$rate[232][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_7_216"><input type="hidden" name="maxpoint_7_216" value="<?=$rebate[216]?>">% (范围：0.5~<?=$rebate[216]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_7_217" id="method_7_217" value="1" checked="checked"></td><td align="center">前二直选</td><td align="center">奖金：<?=$rate[233][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_7_217"><input type="hidden" name="maxpoint_7_217" value="<?=$rebate[217]?>">% (范围：0.5~<?=$rebate[217]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_7_218" id="method_7_218" value="1" checked="checked"></td><td align="center">前二组选</td><td align="center">奖金：<?=$rate[234][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_7_218"><input type="hidden" name="maxpoint_7_218" value="<?=$rebate[218]?>">% (范围：0.5~<?=$rebate[218]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_7_219" id="method_7_219" value="1" checked="checked"></td><td align="center">不定位</td><td align="center">奖金：<?=$rate[235][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_7_219"><input type="hidden" name="maxpoint_7_219" value="<?=$rebate[219]?>">% (范围：0.5~<?=$rebate[219]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_7_220" id="method_7_220" value="1" checked="checked"></td><td align="center">定位胆</td><td align="center">奖金：<?=$rate[236][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_7_220"><input type="hidden" name="maxpoint_7_220" value="<?=$rebate[220]?>">% (范围：0.5~<?=$rebate[220]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_7_221" id="method_7_221" value="1" checked="checked"></td><td align="center">定单双</td><td align="center">0单5双：<?=$rate[239][0]?><br />5单0双：<?=$rate[239][1]?><br />1单4双：<?=$rate[239][2]?><br />4单1双：<?=$rate[239][3]?><br />2单3双：<?=$rate[239][4]?><br />3单2双：<?=$rate[239][5]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_7_221"><input type="hidden" name="maxpoint_7_221" value="<?=$rebate[221]?>">% (范围：0.5~<?=$rebate[221]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_7_222" id="method_7_222" value="1" checked="checked"></td><td align="center">猜中位</td><td align="center">03,09：<?=$rate[240][0]?><br />04,08：<?=$rate[240][1]?><br />05,07：<?=$rate[240][2]?><br />06：<?=$rate[240][3]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_7_222"><input type="hidden" name="maxpoint_7_222" value="<?=$rebate[222]?>">% (范围：0.5~<?=$rebate[222]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_7_223" id="method_7_223" value="1" checked="checked"></td><td align="center">任选一中一</td><td align="center">奖金：<?=$rate[241][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_7_223"><input type="hidden" name="maxpoint_7_223" value="<?=$rebate[223]?>">% (范围：0.5~<?=$rebate[223]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_7_224" id="method_7_224" value="1" checked="checked"></td><td align="center">任选二中二</td><td align="center">奖金：<?=$rate[242][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_7_224"><input type="hidden" name="maxpoint_7_224" value="<?=$rebate[224]?>">% (范围：0.5~<?=$rebate[224]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_7_225" id="method_7_225" value="1" checked="checked"></td><td align="center">任选三中三</td><td align="center">奖金：<?=$rate[243][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_7_225"><input type="hidden" name="maxpoint_7_225" value="<?=$rebate[225]?>">% (范围：0.5~<?=$rebate[225]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_7_226" id="method_7_226" value="1" checked="checked"></td><td align="center">任选四中四</td><td align="center">奖金：<?=$rate[244][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_7_226"><input type="hidden" name="maxpoint_7_226" value="<?=$rebate[226]?>">% (范围：0.5~<?=$rebate[226]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_7_227" id="method_7_227" value="1" checked="checked"></td><td align="center">任选五中五</td><td align="center">奖金：<?=$rate[245][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_7_227"><input type="hidden" name="maxpoint_7_227" value="<?=$rebate[227]?>">% (范围：0.5~<?=$rebate[227]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_7_228" id="method_7_228" value="1" checked="checked"></td><td align="center">任选六中五</td><td align="center">奖金：<?=$rate[246][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_7_228"><input type="hidden" name="maxpoint_7_228" value="<?=$rebate[228]?>">% (范围：0.5~<?=$rebate[228]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_7_229" id="method_7_229" value="1" checked="checked"></td><td align="center">任选七中五</td><td align="center">奖金：<?=$rate[247][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_7_229"><input type="hidden" name="maxpoint_7_229" value="<?=$rebate[229]?>">% (范围：0.5~<?=$rebate[229]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_7_230" id="method_7_230" value="1" checked="checked"></td><td align="center">任选八中五</td><td align="center">奖金：<?=$rate[248][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_7_230"><input type="hidden" name="maxpoint_7_230" value="<?=$rebate[230]?>">% (范围：0.5~<?=$rebate[230]?>%)<span></span></td></tr>	</table>
    	<table class="lt" id="tabbar_txt_8" style="display:none;" border="0" cellspacing="0" cellpadding="0">
		<tr class='th' id="tabbar_title_8">
			<td width=10%><input type="checkbox" id="selall_8" checked="checked" />全选</td>
			<td><div class='line'></div>玩法</td>
			<td><div class='line'></div>
                        奖金
                        </td>
			<td><div class='line'></div>统一返点 <input type="text" style="width:70px;" value="0" name="tpoint_8" id="tpoint_8">% <input type="button" STYLE='height:24px;' name="tpbutton_8" id="tpbutton_8" value="统一设置"></td>
		</tr>
        <tr><td align="center"><input type="checkbox" name="method_8_249" id="method_8_249" value="1" checked="checked"></td><td align="center">前三直选</td><td align="center">奖金：<?=$rate[265][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_8_249"><input type="hidden" name="maxpoint_8_249" value="<?=$rebate[249]?>">% (范围：0.5~<?=$rebate[249]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_8_250" id="method_8_250" value="1" checked="checked"></td><td align="center">前三组选</td><td align="center">奖金：<?=$rate[266][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_8_250"><input type="hidden" name="maxpoint_8_250" value="<?=$rebate[250]?>">% (范围：0.5~<?=$rebate[250]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_8_251" id="method_8_251" value="1" checked="checked"></td><td align="center">前二直选</td><td align="center">奖金：<?=$rate[267][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_8_251"><input type="hidden" name="maxpoint_8_251" value="<?=$rebate[251]?>">% (范围：0.5~<?=$rebate[251]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_8_252" id="method_8_252" value="1" checked="checked"></td><td align="center">前二组选</td><td align="center">奖金：<?=$rate[268][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_8_252"><input type="hidden" name="maxpoint_8_252" value="<?=$rebate[252]?>">% (范围：0.5~<?=$rebate[252]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_8_253" id="method_8_253" value="1" checked="checked"></td><td align="center">不定位</td><td align="center">奖金：<?=$rate[269][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_8_253"><input type="hidden" name="maxpoint_8_253" value="<?=$rebate[253]?>">% (范围：0.5~<?=$rebate[253]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_8_254" id="method_8_254" value="1" checked="checked"></td><td align="center">定位胆</td><td align="center">奖金：<?=$rate[270][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_8_254"><input type="hidden" name="maxpoint_8_254" value="<?=$rebate[254]?>">% (范围：0.5~<?=$rebate[254]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_8_255" id="method_8_255" value="1" checked="checked"></td><td align="center">定单双</td><td align="center">0单5双：<?=$rate[273][0]?><br />5单0双：<?=$rate[273][1]?><br />1单4双：<?=$rate[273][2]?><br />4单1双：<?=$rate[273][3]?><br />2单3双：<?=$rate[273][4]?><br />3单2双：<?=$rate[273][5]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_8_255"><input type="hidden" name="maxpoint_8_255" value="<?=$rebate[255]?>">% (范围：0.5~<?=$rebate[255]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_8_256" id="method_8_256" value="1" checked="checked"></td><td align="center">猜中位</td><td align="center">03,09：<?=$rate[274][0]?><br />04,08：<?=$rate[274][1]?><br />05,07：<?=$rate[274][2]?><br />06：<?=$rate[274][3]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_8_256"><input type="hidden" name="maxpoint_8_256" value="<?=$rebate[256]?>">% (范围：0.5~<?=$rebate[256]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_8_257" id="method_8_257" value="1" checked="checked"></td><td align="center">任选一中一</td><td align="center">奖金：<?=$rate[275][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_8_257"><input type="hidden" name="maxpoint_8_257" value="<?=$rebate[257]?>">% (范围：0.5~<?=$rebate[257]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_8_258" id="method_8_258" value="1" checked="checked"></td><td align="center">任选二中二</td><td align="center">奖金：<?=$rate[276][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_8_258"><input type="hidden" name="maxpoint_8_258" value="<?=$rebate[258]?>">% (范围：0.5~<?=$rebate[258]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_8_259" id="method_8_259" value="1" checked="checked"></td><td align="center">任选三中三</td><td align="center">奖金：<?=$rate[277][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_8_259"><input type="hidden" name="maxpoint_8_259" value="<?=$rebate[259]?>">% (范围：0.5~<?=$rebate[259]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_8_260" id="method_8_260" value="1" checked="checked"></td><td align="center">任选四中四</td><td align="center">奖金：<?=$rate[278][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_8_260"><input type="hidden" name="maxpoint_8_260" value="<?=$rebate[260]?>">% (范围：0.5~<?=$rebate[260]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_8_261" id="method_8_261" value="1" checked="checked"></td><td align="center">任选五中五</td><td align="center">奖金：<?=$rate[279][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_8_261"><input type="hidden" name="maxpoint_8_261" value="<?=$rebate[261]?>">% (范围：0.5~<?=$rebate[261]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_8_262" id="method_8_262" value="1" checked="checked"></td><td align="center">任选六中五</td><td align="center">奖金：<?=$rate[280][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_8_262"><input type="hidden" name="maxpoint_8_262" value="<?=$rebate[262]?>">% (范围：0.5~<?=$rebate[262]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_8_263" id="method_8_263" value="1" checked="checked"></td><td align="center">任选七中五</td><td align="center">奖金：<?=$rate[281][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_8_263"><input type="hidden" name="maxpoint_8_263" value="<?=$rebate[263]?>">% (范围：0.5~<?=$rebate[263]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_8_264" id="method_8_264" value="1" checked="checked"></td><td align="center">任选八中五</td><td align="center">奖金：<?=$rate[282][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_8_264"><input type="hidden" name="maxpoint_8_264" value="<?=$rebate[264]?>">% (范围：0.5~<?=$rebate[264]?>%)<span></span></td></tr>	</table>
    	<table class="lt" id="tabbar_txt_9" style="display:none;" border="0" cellspacing="0" cellpadding="0">
		<tr class='th' id="tabbar_title_9">
			<td width=10%><input type="checkbox" id="selall_9" checked="checked" />全选</td>
			<td><div class='line'></div>玩法</td>
			<td><div class='line'></div>
                        奖金
                        </td>
			<td><div class='line'></div>统一返点 <input type="text" style="width:70px;" value="0" name="tpoint_9" id="tpoint_9">% <input type="button" STYLE='height:24px;' name="tpbutton_9" id="tpbutton_9" value="统一设置"></td>
		</tr>
        <tr><td align="center"><input type="checkbox" title="spec" name="method_9_285" id="method_9_285" value="1" checked="checked"></td><td align="center">一码不定位</td><td align="center">奖金：<?=$rate[300][0]?><br /></td><td align="center">返点 <input type="text" title="spec" style="width:70px;" value="0" name="point_9_285"><input type="hidden" name="maxpoint_9_285" value="<?=$rebate[285]?>">% (范围：0.5~<?=$rebate[285]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_9_286" id="method_9_286" value="1" checked="checked"></td><td align="center">二码不定位</td><td align="center">奖金：<?=$rate[301][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_9_286"><input type="hidden" name="maxpoint_9_286" value="<?=$rebate[286]?>">% (范围：0.5~<?=$rebate[286]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_9_283" id="method_9_283" value="1" checked="checked"></td><td align="center">直选</td><td align="center">奖金：<?=$rate[294][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_9_283"><input type="hidden" name="maxpoint_9_283" value="<?=$rebate[283]?>">% (范围：0.5~<?=$rebate[283]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_9_284" id="method_9_284" value="1" checked="checked"></td><td align="center">组选</td><td align="center">组三奖金：<?=$rate[298][0]?><br />组六奖金：<?=$rate[298][1]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_9_284"><input type="hidden" name="maxpoint_9_284" value="<?=$rebate[284]?>">% (范围：0.5~<?=$rebate[284]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_9_287" id="method_9_287" value="1" checked="checked"></td><td align="center">前二直选</td><td align="center">奖金：<?=$rate[302][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_9_287"><input type="hidden" name="maxpoint_9_287" value="<?=$rebate[287]?>">% (范围：0.5~<?=$rebate[287]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_9_288" id="method_9_288" value="1" checked="checked"></td><td align="center">后二直选</td><td align="center">奖金：<?=$rate[303][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_9_288"><input type="hidden" name="maxpoint_9_288" value="<?=$rebate[288]?>">% (范围：0.5~<?=$rebate[288]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_9_289" id="method_9_289" value="1" checked="checked"></td><td align="center">前二组选</td><td align="center">奖金：<?=$rate[304][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_9_289"><input type="hidden" name="maxpoint_9_289" value="<?=$rebate[289]?>">% (范围：0.5~<?=$rebate[289]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_9_290" id="method_9_290" value="1" checked="checked"></td><td align="center">后二组选</td><td align="center">奖金：<?=$rate[305][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_9_290"><input type="hidden" name="maxpoint_9_290" value="<?=$rebate[290]?>">% (范围：0.5~<?=$rebate[290]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_9_291" id="method_9_291" value="1" checked="checked"></td><td align="center">定位胆</td><td align="center">奖金：<?=$rate[306][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_9_291"><input type="hidden" name="maxpoint_9_291" value="<?=$rebate[291]?>">% (范围：0.5~<?=$rebate[291]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_9_292" id="method_9_292" value="1" checked="checked"></td><td align="center">大小单双(前二)</td><td align="center">奖金：<?=$rate[309][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_9_292"><input type="hidden" name="maxpoint_9_292" value="<?=$rebate[292]?>">% (范围：0.5~<?=$rebate[292]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_9_293" id="method_9_293" value="1" checked="checked"></td><td align="center">大小单双(后二)</td><td align="center">奖金：<?=$rate[310][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_9_293"><input type="hidden" name="maxpoint_9_293" value="<?=$rebate[293]?>">% (范围：0.5~<?=$rebate[293]?>%)<span></span></td></tr>	</table>
    	<table class="lt" id="tabbar_txt_10" style="display:none;" border="0" cellspacing="0" cellpadding="0">
		<tr class='th' id="tabbar_title_10">
			<td width=10%><input type="checkbox" id="selall_10" checked="checked" />全选</td>
			<td><div class='line'></div>玩法</td>
			<td><div class='line'></div>
                        奖金
                        </td>
			<td><div class='line'></div>统一返点 <input type="text" style="width:70px;" value="0" name="tpoint_10" id="tpoint_10">% <input type="button" STYLE='height:24px;' name="tpbutton_10" id="tpbutton_10" value="统一设置"></td>
		</tr>
        <tr><td align="center"><input type="checkbox" title="spec" name="method_10_313" id="method_10_313" value="1" checked="checked"></td><td align="center">一码不定位</td><td align="center">奖金：<?=$rate[328][0]?><br /></td><td align="center">返点 <input type="text" title="spec" style="width:70px;" value="0" name="point_10_313"><input type="hidden" name="maxpoint_10_313" value="<?=$rebate[313]?>">% (范围：0.5~<?=$rebate[313]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_10_314" id="method_10_314" value="1" checked="checked"></td><td align="center">二码不定位</td><td align="center">奖金：<?=$rate[329][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_10_314"><input type="hidden" name="maxpoint_10_314" value="<?=$rebate[314]?>">% (范围：0.5~<?=$rebate[314]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_10_311" id="method_10_311" value="1" checked="checked"></td><td align="center">排三直选</td><td align="center">奖金：<?=$rate[322][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_10_311"><input type="hidden" name="maxpoint_10_311" value="<?=$rebate[311]?>">% (范围：0.5~<?=$rebate[311]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_10_312" id="method_10_312" value="1" checked="checked"></td><td align="center">排三组选</td><td align="center">组三奖金：<?=$rate[326][0]?><br />组六奖金：<?=$rate[326][1]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_10_312"><input type="hidden" name="maxpoint_10_312" value="<?=$rebate[312]?>">% (范围：0.5~<?=$rebate[312]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_10_315" id="method_10_315" value="1" checked="checked"></td><td align="center">排五前二直选</td><td align="center">奖金：<?=$rate[330][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_10_315"><input type="hidden" name="maxpoint_10_315" value="<?=$rebate[315]?>">% (范围：0.5~<?=$rebate[315]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_10_316" id="method_10_316" value="1" checked="checked"></td><td align="center">排五后二直选</td><td align="center">奖金：<?=$rate[331][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_10_316"><input type="hidden" name="maxpoint_10_316" value="<?=$rebate[316]?>">% (范围：0.5~<?=$rebate[316]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_10_317" id="method_10_317" value="1" checked="checked"></td><td align="center">排五前二组选</td><td align="center">奖金：<?=$rate[332][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_10_317"><input type="hidden" name="maxpoint_10_317" value="<?=$rebate[317]?>">% (范围：0.5~<?=$rebate[317]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_10_318" id="method_10_318" value="1" checked="checked"></td><td align="center">排五后二组选</td><td align="center">奖金：<?=$rate[333][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_10_318"><input type="hidden" name="maxpoint_10_318" value="<?=$rebate[318]?>">% (范围：0.5~<?=$rebate[318]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_10_319" id="method_10_319" value="1" checked="checked"></td><td align="center">定位胆</td><td align="center">奖金：<?=$rate[334][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_10_319"><input type="hidden" name="maxpoint_10_319" value="<?=$rebate[319]?>">% (范围：0.5~<?=$rebate[319]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_10_320" id="method_10_320" value="1" checked="checked"></td><td align="center">前二大小单双</td><td align="center">奖金：<?=$rate[339][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_10_320"><input type="hidden" name="maxpoint_10_320" value="<?=$rebate[320]?>">% (范围：0.5~<?=$rebate[320]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_10_321" id="method_10_321" value="1" checked="checked"></td><td align="center">后二大小单双</td><td align="center">奖金：<?=$rate[340][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_10_321"><input type="hidden" name="maxpoint_10_321" value="<?=$rebate[321]?>">% (范围：0.5~<?=$rebate[321]?>%)<span></span></td></tr>	</table>
    	<table class="lt" id="tabbar_txt_11" style="display:none;" border="0" cellspacing="0" cellpadding="0">
		<tr class='th' id="tabbar_title_11">
			<td width=10%><input type="checkbox" id="selall_11" checked="checked" />全选</td>
			<td><div class='line'></div>玩法</td>
			<td><div class='line'></div>
                        奖金
                        </td>
			<td><div class='line'></div>统一返点 <input type="text" style="width:70px;" value="0" name="tpoint_11" id="tpoint_11">% <input type="button" STYLE='height:24px;' name="tpbutton_11" id="tpbutton_11" value="统一设置"></td>
		</tr>
        <tr><td align="center"><input type="checkbox" name="method_11_341" id="method_11_341" value="1" checked="checked"></td><td align="center">前三直选</td><td align="center">奖金：<?=$rate[358][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_11_341"><input type="hidden" name="maxpoint_11_341" value="<?=$rebate[341]?>">% (范围：0.5~<?=$rebate[341]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_11_342" id="method_11_342" value="1" checked="checked"></td><td align="center">前三组选</td><td align="center">奖金：<?=$rate[359][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_11_342"><input type="hidden" name="maxpoint_11_342" value="<?=$rebate[342]?>">% (范围：0.5~<?=$rebate[342]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_11_343" id="method_11_343" value="1" checked="checked"></td><td align="center">前二直选</td><td align="center">奖金：<?=$rate[360][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_11_343"><input type="hidden" name="maxpoint_11_343" value="<?=$rebate[343]?>">% (范围：0.5~<?=$rebate[343]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_11_344" id="method_11_344" value="1" checked="checked"></td><td align="center">前二组选</td><td align="center">奖金：<?=$rate[361][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_11_344"><input type="hidden" name="maxpoint_11_344" value="<?=$rebate[344]?>">% (范围：0.5~<?=$rebate[344]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_11_345" id="method_11_345" value="1" checked="checked"></td><td align="center">不定位</td><td align="center">奖金：<?=$rate[362][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_11_345"><input type="hidden" name="maxpoint_11_345" value="<?=$rebate[345]?>">% (范围：0.5~<?=$rebate[345]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_11_346" id="method_11_346" value="1" checked="checked"></td><td align="center">定位胆</td><td align="center">奖金：<?=$rate[363][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_11_346"><input type="hidden" name="maxpoint_11_346" value="<?=$rebate[346]?>">% (范围：0.5~<?=$rebate[346]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_11_347" id="method_11_347" value="1" checked="checked"></td><td align="center">定单双</td><td align="center">0单5双：<?=$rate[366][0]?><br />5单0双：<?=$rate[366][1]?><br />1单4双：<?=$rate[366][2]?><br />4单1双：<?=$rate[366][3]?><br />2单3双：<?=$rate[366][4]?><br />3单2双：<?=$rate[366][5]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_11_347"><input type="hidden" name="maxpoint_11_347" value="<?=$rebate[347]?>">% (范围：0.5~<?=$rebate[347]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_11_348" id="method_11_348" value="1" checked="checked"></td><td align="center">猜中位</td><td align="center">03,09：<?=$rate[367][0]?><br />04,08：<?=$rate[367][1]?><br />05,07：<?=$rate[367][2]?><br />06：<?=$rate[367][3]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_11_348"><input type="hidden" name="maxpoint_11_348" value="<?=$rebate[348]?>">% (范围：0.5~<?=$rebate[348]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_11_349" id="method_11_349" value="1" checked="checked"></td><td align="center">任选一中一</td><td align="center">奖金：<?=$rate[368][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_11_349"><input type="hidden" name="maxpoint_11_349" value="<?=$rebate[349]?>">% (范围：0.5~<?=$rebate[349]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_11_350" id="method_11_350" value="1" checked="checked"></td><td align="center">任选二中二</td><td align="center">奖金：<?=$rate[369][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_11_350"><input type="hidden" name="maxpoint_11_350" value="<?=$rebate[350]?>">% (范围：0.5~<?=$rebate[350]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_11_351" id="method_11_351" value="1" checked="checked"></td><td align="center">任选三中三</td><td align="center">奖金：<?=$rate[370][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_11_351"><input type="hidden" name="maxpoint_11_351" value="<?=$rebate[351]?>">% (范围：0.5~<?=$rebate[351]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_11_352" id="method_11_352" value="1" checked="checked"></td><td align="center">任选四中四</td><td align="center">奖金：<?=$rate[371][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_11_352"><input type="hidden" name="maxpoint_11_352" value="<?=$rebate[352]?>">% (范围：0.5~<?=$rebate[352]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_11_353" id="method_11_353" value="1" checked="checked"></td><td align="center">任选五中五</td><td align="center">奖金：<?=$rate[372][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_11_353"><input type="hidden" name="maxpoint_11_353" value="<?=$rebate[353]?>">% (范围：0.5~<?=$rebate[353]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_11_354" id="method_11_354" value="1" checked="checked"></td><td align="center">任选六中五</td><td align="center">奖金：<?=$rate[373][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_11_354"><input type="hidden" name="maxpoint_11_354" value="<?=$rebate[354]?>">% (范围：0.5~<?=$rebate[354]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_11_355" id="method_11_355" value="1" checked="checked"></td><td align="center">任选七中五</td><td align="center">奖金：<?=$rate[374][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_11_355"><input type="hidden" name="maxpoint_11_355" value="<?=$rebate[355]?>">% (范围：0.5~<?=$rebate[355]?>%)<span></span></td></tr><tr><td align="center"><input type="checkbox" name="method_11_356" id="method_11_356" value="1" checked="checked"></td><td align="center">任选八中五</td><td align="center">奖金：<?=$rate[375][0]?><br /></td><td align="center">返点 <input type="text" style="width:70px;" value="0" name="point_11_356"><input type="hidden" name="maxpoint_11_356" value="<?=$rebate[356]?>">% (范围：0.5~<?=$rebate[356]?>%)<span></span></td></tr>	</table>
    	</div><BR/>
    <div STYLE='margin:0 0 18px 50px;font-size:14px;color:#FFF;'>
		<input name='submit1' type="submit" value="&nbsp;执行开户&nbsp;"></span></span>
	</div>
    </div></div>
</div></form></div>
<div class="div_s1" style='line-height:22px;'>
<table STYLE='background-color:#E3E3E3;' width="100%" align="center" border="0" cellspacing="0" cellpadding="0">
<tr><td align="center"><div id="footer"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td align="center"><table align="center" width="450">
<tr><td align="left">浏览器建议：首选IE 8.0浏览器，其次为火狐浏览器。</td></tr>
</table></td></tr><tr><td></td></tr></table></div>
</td></tr></table>
</div></CENTER><br/><br/>
<?php echo $count?>
</BODY></HTML>