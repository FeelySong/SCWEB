<?php
session_start();
error_reporting(0);
require_once 'conn.php';
require_once 'check.php';

$page = !($_GET['page'])?'1':intval($_GET['page']);
$pagesize=25;
$page2=($page-1)*$pagesize;

$uid = $_REQUEST['uid'];
$username_listb = $_REQUEST['username'];
$usergroup = $_REQUEST['usergroup'];
$bank_min = $_REQUEST['bank_min'];
$bank_max = $_REQUEST['bank_max'];
$point_min = $_REQUEST['point_min'];
$point_max = $_REQUEST['point_max'];
$sortby = $_REQUEST['sortby'];
$sortbymax = $_REQUEST['sortbymax'];


if($bank_min!=""){
	$s1=$s1." and leftmoney>='".$bank_min."'";
}

if($bank_max!=""){
	$s1=$s1." and leftmoney<='".$bank_max."'";
}

if($point_min!=""){
	$s1=$s1." and flevel>='".$point_min."'";
}

if($point_max!=""){
	$s1=$s1." and flevel<='".$point_max."'";
}

if($username_listb!=""){
	$s1=$s1." and username='".$username_listb."'";
}

if($uid!=""){
	$s1=$s1." and (regup='".$uid."' or username='".$uid."')";
	$sqla="select * from ssc_member where username='".$uid."'";
	$rsa = mysql_query($sqla);
	$rowa = mysql_fetch_array($rsa);
	$regfrom=explode("&&",$rowa['regfrom']);
	$dh="	 > ".$uid;
	for ($ia=0; $ia<count($regfrom); $ia++) {								
		$susername=str_replace("&","",$regfrom[$ia]);
		if($susername==$_SESSION["username"] ){
			break;
		}
		$dh="	 > <a href='./users_listb.php?frame=show&uid=".$susername."' target='userlist_content' style='color:#222; '>".$susername."</a>".$dh;
	}
}else{
	$s1=$s1." and regup='".$_SESSION["username"] ."'";
}

if($sortby==""){
	$sortby="id";
}

if($sortbymax=="1"){
	$sortbys="desc";
}else{
	$sortbys="asc";
}

$urls="bank_min=".$bank_min."&bank_max=".$bank_max."&username=".$username_listb;
$s1=$s1." order by ".$sortby." ".$sortbys;
$sql="select * from ssc_member where 1=1".$s1;
//echo $sql;
$rs = mysql_query($sql);
$total = mysql_num_rows($rs);

$sql="select * from ssc_member where 1=1".$s1." limit $page2,$pagesize";
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


function exchange($number){
	$arr=array("零","一","二","三","四","五","六","七","八","九");
	if(strlen($number)==1){
		$result=$arr[$number];
	}else{
		if($number<20){
			$result="十";
		}else{
			$result=$arr[substr($number,0,1)]."十";
		}
		if(substr($number,1,1)!="0"){
			$result.=$arr[substr($number,1,1)]; 
		}
	}
	return $result;
}
//echo exchange(15);
	$czzt=Get_member(czzt);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD><TITLE><?php echo $webname;?>  - 用户列表</TITLE>
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
<BODY STYLE="background:#FFF url('images/v1/main_bg_0001.jpg') 0px -490px repeat-x; padding:10px;"><DIV ID='main_box'>
<div class="box l"></div>
<div class="box c"></div>
<div class="box r"></div>
<div class="box m">

<H1>
<SPAN class="action-span"><A href="users_edit.php" target='mainframe'>更改昵称</a></SPAN>
<SPAN class="action-span"><A href="users_tg.php" target='mainframe'>推广链接</a></SPAN>
<SPAN class="action-span zhuangtai"><A href="users_add.php" target='mainframe'>增加用户</a></SPAN>
<SPAN class="action-span1"><DIV class='icons_mb1'></DIV>当前位置: <A href="/" target='_top'><?php echo $webname;?></a>
 - 用户列表 </SPAN><DIV style="clear:both"></DIV></H1>
<SCRIPT type="text/javascript" src="js/calendar/jquery.dyndatetime.js"></SCRIPT>
<script type="text/javascript" src="js/calendar/lang/calendar-utf8.js"></SCRIPT>
<LINK rel="stylesheet" type="text/css" media="all" href="js/calendar/css/calendar-blue2.css"  />
<script language="javascript">
function getTeamBank(obj,uid){if(jQuery(obj).closest("tr").next(".showteam").html()!=null){jQuery(obj).closest("tr").next(".showteam").show();}else{var html='<tr class="showteam"><td height="20" colspan=5>&nbsp;</td><td align="center"><span>正在读取数据....</span></td></tr>';jQuery(obj).closest("tr").after(html);jQuery.ajax({type:"GET",url:"./users_list.php?frame=team&uid="+uid,dataType:"json",cache:false,success:function(data){jQuery(obj).closest("tr").next(".showteam").find("span").html(data.error);if(data.error=="error"){jQuery(obj).closest("tr").next(".showteam").find("span").html('抱歉, 您没有权限&nbsp;&nbsp;<a href="javascript:" style="color:#CF0;" onclick="hideTeam(this)">[关闭]</a>');}else{if(data.error=="0"){jQuery(obj).closest("tr").next(".showteam").find("span").html('团队余额: <font color="#FFCC33">'+moneyFormat(data.result)+'</font>&nbsp;游戏币&nbsp;&nbsp;<a href="javascript:" style="color:#CF0;" onclick="hideTeam(this)">[关闭]</a>');}else{return true;}}}});}}function hideTeam(obj){jQuery(obj).closest("tr").hide();}
</script>
<div class="ld">
<table class='st' border="0" cellspacing="0" cellpadding="0">
<form action="" method="get" name="search" onSubmit="return checkForm(this)">
<input type="hidden" name="frame" value="show" />
<input type="hidden" name="flag" value="search" />
	<tr>
    	<td width='200'>用户名: <input type="text" size="16" name="username" value="" /></td>
        <td>账户余额: <input type="text" size="10" name="bank_min" value="" onKeyUp="checkMoney(this)" /> 至 <input type="text" size="10" name="bank_max" value="" onKeyUp="checkMoney(this)" />
        &nbsp;&nbsp;&nbsp;&nbsp;排序：<select name="sortby">
        			<option value="id" >默认排序</option>
        			<option value="username" >用户名</option>
                    <option value="leftmoney" >账户余额</option>
                    <option value="point" >返点级别</option>
                </select>
                <input type="checkbox" name="sortbymax" value="1"   />从大到小
		
		</td>
    </tr>
    <tr>
	<td>用户级别: <select name="usergroup" style="width:100px; height:20px;">
        			<option value="0" selected="selected">请选择..</option>
                    <option value="1" >代理用户</option>
                    <option value="2" >会员用户</option>
                   </select></td>
        <td>返点级别：<input type="text" size="10" name="point_min" value="" onKeyUp="checkMoney(this)" /> 至 <input type="text" size="10" name="point_max" value="" onKeyUp="checkMoney(this)" />
        &nbsp;&nbsp;&nbsp;
		<button name="submit" type="submit" width='69' height='26' class="btn_search" /></button>
        </td>
    </tr>
</form>
</table>
</div>

<div style="clear:both; height:10px;"></div>

<div class="ld" >
<table class="lt" border="0" cellspacing="0" cellpadding="0">
<form action="./" method="post">
	<tr>
    	<td class='t' colspan="7"><div>
		&nbsp;&nbsp;<a href="./users_listb.php?frame=show" target="userlist_content">我的用户</a>	<?=$dh?>	</div></td>
    </tr>
    <tr class='th'>
    	<td>用户名</td>
        <td><div class='line'></div>用户级别</td>
        <td><div class='line'></div>余额</td>
                <td><div class='line'></div>返点级别</td>
        <td><div class='line'></div>注册时间</td>
        <td><div class='line'></div>操作</td>
    </tr>
<?php
if($total==0){
?>
    <tr class="needchangebg" align="center">
        <td colspan="7" class='no-records'><span>没有找到指定条件的记录.</span></td>
    </tr>
<?php
}else{
	while ($row = mysql_fetch_array($rsnewslist)){
	$regfrom=explode("&&",$row['regfrom']);
	for ($ia=0; $ia<count($regfrom); $ia++) {								
		$ib=$ia;
		$susername=str_replace("&","",$regfrom[$ia]);
		if($susername==$_SESSION["username"] ){
			break;
		}
	}

?>    
    <tr  class="<?php if($row['username']==$uid){echo "self_tr";}else{echo "needchangebg";}?>" >
    	<td align="left" height="20">&nbsp;&nbsp;<a href="./users_listb.php?frame=show&uid=<?=$row['username']?>" target="userlist_content" style="color:#003399; text-decoration:none;"><?=$row['username']?></a></td>
        <td align="center"><?php if($row['level']==0){echo "会员用户";}else{echo exchange($ib+1)."级代理";}?></td>
        <td align="center"><?=$row['leftmoney']?></td>
                <td align="center"><?=$row['flevel']?></td>
        <td align="center"><?=$row['regdate']?></td>
        <td align="center"><?php if($czzt=="1"){?><a href="./users_saveup.php?uid=<?=$row['id']?>">充值</a><?php }?>             <?php if($row['regup']==$_SESSION["username"] ){?><a href="./users_update.php?uid=<?=$row['id']?>">编辑</a><?php }?>             <a href="./report_list.php?username=<?=$row['username']?>&isrequery=1">帐变</a>                       <a href="./users_info.php?uid=<?=$row['id']?>">用户详情</a> 
            <a href="javascript:" onclick="getTeamBank(this,<?=$row['id']?>)">团队余额</a>             <?php if($czzt=="1" && $row['level']!=0 && $ib==0){?><?php if($row['czzt']!="1"){?><a href="./users_editupsave.php?uid=<?=$row['id']?>&flag=open" onclick="return confirm('确定要开通此用户的代充功能吗?')">开通充值</a><?php }else{?><a href="./users_editupsave.php?uid=<?=$row['id']?>&flag=close" onclick="return confirm('确定要关闭此用户的代充功能吗?\n如果关闭，将关闭此用户和其所有下级的代充功能')">关闭充值</a><?php }?><?php }?>
        </td>
    </tr>
<?php }}?>


	        <tr><td class='b' colspan="7"><div style='text-align:right;'><ul class="pager">总计  <?=$total?> 条数据,  共 <?=$lastpg?> 页 , 当前第 <?=$page?> 页  |  <?php if($page>1){?><LI><A HREF="?<?=$urls?>&page=1">首页</A></LI><LI><A HREF="?<?=$urls?>&page=<?=$page-1?>">上页</A></LI><?php }?><?php for($i=$p1;$i<=$p2;$i++){
		if($i==$page){?><LI CLASS='current' ><A HREF="#"><?=$i?></A></LI><?php }else{?><LI><A HREF="?<?=$urls?>&page=<?=$i?>"><?=$i?></A></LI><?php }}?><?php if($page!=$lastpg){?><LI><A HREF="?<?=$urls?>&page=<?=$page+1?>">下页</A></LI><LI><A HREF="?<?=$urls?>&page=<?=$lastpg?>">尾页</A></LI><?php }?> | 转至 <SCRIPT LANGUAGE="JAVASCRIPT">function keepKeyNum(obj,evt){var  k=window.event?evt.keyCode:evt.which; if( k==13 ){ goPage(obj.value);return false; }} function goPage( iPage ){ if( !isNaN(parseInt(iPage)) ) { if(iPage> 0 ){iPage=0;} window.location.href="?frame=show&action_menuid=14&pn=20&p="+iPage;}}</SCRIPT><INPUT onKeyPress="return keepKeyNum(this,event);" TYPE="TEXT" ID="iGotoPage" NAME="iGotoPage" size="3"> 页  &nbsp;<BUTTON onclick="javascript:goPage( document.getElementById('iGotoPage').value );return false;">GO</BUTTON>&nbsp;&nbsp;</ul></div></td></tr>
</form>
</table>
</div>

<div id="footer"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td align="center"><table align="center" width="450">
<tr><td align="left">浏览器建议：首选IE 8.0浏览器，其次为火狐浏览器。</td></tr>
</table></td></tr><tr><td></td></tr></table></div>
<br/><br/>
</div></div>
<?php echo $count?>
</BODY></HTML>