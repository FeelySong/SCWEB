<?php
session_start();
error_reporting(0);
require_once 'conn.php';

if (strpos($_SESSION['admin_flag'],'51') ){}else{ 
	echo "<script language=javascript>alert('对不起，您无此权限！');window.history.go(-1);</script>";
exit;}

$starttime = $_REQUEST['starttime'];
$endtime = $_REQUEST['endtime'];
$username_mem=$_REQUEST['username'];

$page = !($_GET['page'])?'1':intval($_GET['page']);
$pagesize=20;
$page2=($page-1)*$pagesize;

if($starttime!=""){
	$s1=$s1." and adddate>='".$starttime."'";
}

if($endtime!=""){
	$s1=$s1." and adddate<='".$endtime."'";
}

if($username_mem!=""){
	$s1=$s1." and username='".$username_mem."'";
}

$urls="starttime=".$starttime."&endtime=".$endtime."&username=".$username_mem;

$sql="select username,SUM(IF(types = 1, smoney, 0)) as t1,SUM(IF(types = 2, zmoney, 0)) as t2,SUM(IF(types = 3, smoney, 0)) as t3,SUM(IF(types = 7, zmoney, 0)) as t7,SUM(IF(types = 11, smoney, 0)) as t11,SUM(IF(types = 12, smoney, 0)) as t12,SUM(IF(types = 13, smoney, 0)) as t13,SUM(IF(types = 15, zmoney, 0)) as t15,SUM(IF(types = 16, zmoney, 0)) as t16,SUM(IF(types = 32, smoney, 0)) as t32,SUM(IF(types = 40, smoney, 0)) as t40 from ssc_record where 1=1".$s1." GROUP BY username";
$rs = mysql_query($sql);
$total = mysql_num_rows($rs);

$sql="select username,SUM(IF(types = 1, smoney, 0)) as t1,SUM(IF(types = 2, zmoney, 0)) as t2,SUM(IF(types = 3, smoney, 0)) as t3,SUM(IF(types = 7, zmoney, 0)) as t7,SUM(IF(types = 11, smoney, 0)) as t11,SUM(IF(types = 12, smoney, 0)) as t12,SUM(IF(types = 13, smoney, 0)) as t13,SUM(IF(types = 15, zmoney, 0)) as t15,SUM(IF(types = 16, zmoney, 0)) as t16,SUM(IF(types = 32, smoney, 0)) as t32,SUM(IF(types = 40, smoney, 0)) as t40 from ssc_record where 1=1".$s1." GROUP BY username limit $page2,$pagesize";

$rsnewslist = mysql_query($sql) or  die("数据库修改出错!!!!".mysql_error());
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
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link href="css/index.css" rel="stylesheet" type="text/css">
<script language="javascript" type="text/javascript" src="js/jquery.js"></script>
<script language="javascript" type="text/javascript" src="js/common.js"></script>
<script type="text/javascript" src="js/calendar/jquery.dyndatetime.js"></script>
<script type="text/javascript" src="js/calendar/lang/calendar-utf8.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="js/calendar/css/calendar-blue2.css"  />
<script type="text/javascript">
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
			alert("时间格式不正确,正确的格式为:2011-01-01 12:01");
		}
		if($("#endtime").val()!="")
		{
			if($("#starttime").val()>$("#endtime").val())
			{
				$("#starttime").val("");
				alert("输入的时间不符合逻辑.");
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
		onUpdate:function(){
			$("#endtime").change();
		},
		showOthers: true,
		weekNumbers: true,
		showsTime: true
	});
	jQuery("#endtime").change(function(){
		if(! validateInputDate(jQuery("#endtime").val()) )
		{
			jQuery("#endtime").val('');
			alert("时间格式不正确,正确的格式为:2011-01-01 12:01");
		}
		if($("#starttime").val()!="")
		{
			if($("#starttime").val()>$("#endtime").val())
			{
				$("#endtime").val("");
				alert("输入的时间不符合逻辑.");
			}
		}
	});
});

function checkForm(obj)
{
	if( jQuery.trim(obj.ordertime_min.value) != "" )
	{
		if( false == validateInputDate(obj.ordertime_min.value) )
		{
			alert("时间格式不正确");
			obj.ordertime_min.focus();
			return false;
		}
	}
	if( jQuery.trim(obj.ordertime_max.value) != "" )
	{
		if( false == validateInputDate(obj.ordertime_max.value) )
		{
			alert("时间格式不正确");
			obj.ordertime_max.focus();
			return false;
		}
	}
}
var checkall=document.getElementsByName("lids[]");  
function select(){                          //全选   
	for(var $i=0;$i<checkall.length;$i++){  
		checkall[$i].checked=true;  
	} 
}  
function fanselect(){                        //反选   
	for(var $i=0;$i<checkall.length;$i++){  
		if(checkall[$i].checked){  
			checkall[$i].checked=false;  
		}else{  
			checkall[$i].checked=true;  
		}  
	}  
}           
function noselect(){                          //全不选   
	for(var $i=0;$i<checkall.length;$i++){  
		checkall[$i].checked=false;  
	}  
}  
</script>
</head>

<body>
<div align="center"><br />
	<table width="95%" border="0" cellpadding="0" cellspacing="0" class="top_list">
      <tr>
        <td class="top_list_td icons_a5">　　您现在的位置是：报表管理 &gt; 消费报表</td>
      </tr>
    </table>
  	<br />
    <form name="memberForm" method="post" action="?">
  	<table width="95%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td align="left" class="top_list_td">消费时间：
          <input name="starttime" type="text" class="inpb" id="starttime" value="<?=$starttime?>" size="21" />
          <img class='icons_mb4' src="images/comm/t.gif" id="time_min_button" style="cursor:pointer;" /> 至
          <input name="endtime" type="text" class="inpb" id="endtime" value="<?=$endtime?>" size="21" />
          <img class='icons_mb4' src="images/comm/t.gif" id="time_min_button" style="cursor:pointer;" />&nbsp;
        用户名:
        <input name="username" type="text" class="inpb" id="username" size="10" maxlength="30" />
<input name="Find_VN" type="submit" class="btnb" value="搜 索"></td>
        <td width="100" class="top_list_td">&nbsp;</td>
      </tr>
    </table>
    </form>
  	<br />
<table width="95%" border="1" cellpadding="0" cellspacing="0" bordercolor="#DDDDDD" class="t_list">
		  	<tr>
				<td class="t_list_caption">序号</td>
				<td class="t_list_caption">用户名</td>
				<td class="t_list_caption">活动礼金</td>
		      <td class="t_list_caption">充值总额</td>
		      <td class="t_list_caption">提现总额</td>
			  <td class="t_list_caption">投注总额</td>
		      <td class="t_list_caption">返点总额</td>
              <td class="t_list_caption">中奖总额</td>
              <td class="t_list_caption">分红总额</td>
              <td class="t_list_caption">盈亏总额</td>
  	</tr>
			<?php 
			$i=0;
			while ($row = mysql_fetch_array($rsnewslist)){
			$ts=$row['t7']+$row['t9']-$row['t11']-$row['t12']-$row['t13']+$row['t15']+$row['t16']-$row['t32']-$row['t40'];
			$tt1=$tt1+$row['t1'];
			$tt32=$tt32+$row['t32'];
			$tt2=$tt2+$row['t2']-$row['t3'];
			$tt7=$tt7+$row['t7']-$row['t13'];
			$tt11=$tt11+$row['t11']-$row['t15'];
			$tt12=$tt12+$row['t12']-$row['t16'];
			$tt40=$tt40+$row['t40'];
			$tts=$tts+$ts;
			
			?>
			<tr class="t_list_tr_<?=$i%2?>" onMouseOver="this.style.backgroundColor='#E8F1FF'" onMouseOut="this.style.backgroundColor=''">
				<td height="25"  align="center"><?=($i+1+($page-1)*20)?></td>
			    <td height="25"  align="center"><?=$row['username']?></td>
		      <td align="center"><?=number_format($row['t32'],2)?></td>
			  <td align="center"><?=number_format($row['t1'],2)?></td>
			  <td align="center"><?=number_format($row['t2']-$row['t3'],2)?></td>
				<td align="center"><?=number_format($row['t7']-$row['t13'],2)?></td>
				<td align="center"><?=number_format($row['t11']-$row['t15'],2)?></td>
			    <td align="center"><?=number_format($row['t12']-$row['t16'],2)?></td>
			    <td align="center"><?=number_format($row['t40'],2)?></td>
			    <td align="center"><?php if($ts<0){echo "<font color='#FF0000'>".number_format($ts,2)."</font>";}else{echo "<font color='#00FF00'>".number_format($ts,2)."</font>";}?></td>
			</tr>
			<?php 
			$i=$i+1;
			}
			?>
			<tr class="t_list_tr_2" >
			  <td height="25" colspan="2"  align="center">小结</td>
			  <td align="center"><?=number_format($tt32,2)?></td>
			  <td align="center"><?=number_format($tt1,2)?></td>
			  <td align="center"><?=number_format($tt2,2)?></td>
			  <td align="center"><?=number_format($tt7,2)?></td>
			  <td align="center"><?=number_format($tt11,2)?></td>
			  <td align="center"><?=number_format($tt12,2)?></td>
			  <td align="center"><?=number_format($tt40,2)?></td>
			  <td align="center"><?php if($tts<0){echo "<font color='#FF0000'>".number_format($tts,2)."</font>";}else{echo "<font color='#00FF00'>".number_format($tts,2)."</font>";}?></td>
    </tr>
      <tr>
            <td colspan="10" class="t_list_bottom"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="170" height="35">&nbsp;</td>
                <td width="150">&nbsp;</td>
                <td><div style='text-align:right;'>总计  <?=$total?> 条数据,  共 <?=$lastpg?> 页 , 当前第 <?=$page?> 页  |  <?php if($page>1){?> <A HREF="?<?=$urls?>&page=1">首页</A> <A HREF="?<?=$urls?>&page=<?=$page-1?>">上页</A><?php }?><?php for($i=$p1;$i<=$p2;$i++){
		if($i==$page){?> <span class='Font_R'><?=$i?></span> <?php }else{?> <A HREF="?<?=$urls?>&page=<?=$i?>"><?=$i?></A> <?php }}?><?php if($page!=$lastpg){?> <A HREF="?<?=$urls?>&page=<?=$page+1?>">下页</A> <A HREF="?<?=$urls?>&page=<?=$lastpg?>">尾页</A> <?php }?> | 转至 <SCRIPT LANGUAGE="JAVASCRIPT">function keepKeyNum(obj,evt){var  k=window.event?evt.keyCode:evt.which; if( k==13 ){ goPage(obj.value);return false; }} function goPage( iPage ){ if( !isNaN(parseInt(iPage)) ) { if(iPage< 0 ){iPage=0;} window.location.href="?<?=$urls?>&page="+iPage;}}</SCRIPT><INPUT onKeyPress="return keepKeyNum(this,event);" TYPE="TEXT" ID="iGotoPage" NAME="iGotoPage" size="3"> 页  &nbsp;<BUTTON onClick="javascript:goPage( document.getElementById('iGotoPage').value );return false;">GO</BUTTON></div></td>
              </tr>
            </table></td>
      </tr>
  </table>
</div>
</body>
</html>
