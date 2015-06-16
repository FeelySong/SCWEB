<?php
session_start();
error_reporting(0);
require_once 'conn.php';

if (strpos($_SESSION['admin_flag'],'65') ){}else{ 
	echo "<script language=javascript>alert('对不起，您无此权限！');window.history.go(-1);</script>";
exit;}

$cid=$_GET['id'];
if($cid==""){
	$cid="1";
}

$starttime = $_REQUEST['starttime'];
$endtime = $_REQUEST['endtime'];

if($starttime!=""){
	$s1=$s1." and adddate>='".$starttime."'";
}

if($endtime!=""){
	$s1=$s1." and adddate<='".$endtime."'";
}

$urls="starttime=".$starttime."&endtime=".$endtime."&id=".$cid;

$page = !($_GET['page'])?'1':intval($_GET['page']);
$pagesize=20;
$page2=($page-1)*$pagesize;

if ($cid==2){ 
	$sql="select DATE_FORMAT( adddate, '%Y-%m' ) AS t0 from ssc_record where 1=1 ".$s1." GROUP BY DATE_FORMAT( adddate, '%Y-%m' )";
}else{
	$sql="select DATE_FORMAT( adddate, '%Y-%m-%d' ) AS t0 from ssc_record where 1=1 ".$s1." GROUP BY DATE_FORMAT( adddate, '%Y-%m-%d' )";
}
$rs = mysql_query($sql);
$total = mysql_num_rows($rs);

if ($cid==2){ 
	$sql="select DATE_FORMAT( adddate, '%Y-%m' ) AS t0,SUM(IF(types = 12, smoney, 0)) as t12,SUM(IF(types = 16, zmoney, 0)) as t16 from ssc_record where 1=1 ".$s1." GROUP BY DATE_FORMAT( adddate, '%Y-%m' ) order by t0 desc limit $page2,$pagesize";
}else{
	$sql="select DATE_FORMAT( adddate, '%Y-%m-%d' ) AS t0,SUM(IF(types = 12, smoney, 0)) as t12,SUM(IF(types = 16, zmoney, 0)) as t16 from ssc_record where 1=1 ".$s1." GROUP BY DATE_FORMAT( adddate, '%Y-%m-%d' ) order by t0 desc limit $page2,$pagesize";
}
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
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link href="css/index.css" rel="stylesheet" type="text/css">
<script language="javascript" type="text/javascript" src="js/jquery.js"></script>
<script language="javascript" type="text/javascript" src="js/common.js"></script>
<script type="text/javascript" src="js/calendar/jquery.dyndatetime.js"></script>
<script type="text/javascript" src="js/calendar/lang/calendar-utf8.js"></script>
<script language="javascript" src="js/dialog/jquery.dialogUI.js"></script>
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
</script>
</head>

<body>
<div align="center"><br />
	<table width="95%" border="0" cellpadding="0" cellspacing="0" class="top_list">
      <tr>
        <td class="top_list_td icons_a6">　　您现在的位置是：数据统计 &gt; 中奖统计</td>
      </tr>
    </table>
  	<br />
    <form name="memberForm" method="post" action="?">
    <table width="95%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td align="left" class="top_list_td">统计时间：
          <input name="id" type="hidden" value="<?=$cid?>"/><input name="starttime" type="text" class="inpb" id="starttime" value="<?=$starttime?>" size="21" />
          <img class='icons_mb4' src="images/comm/t.gif" id="time_min_button" style="cursor:pointer;" /> 至
          <input name="endtime" type="text" class="inpb" id="endtime" value="<?=$endtime?>" size="21" />
          <img class='icons_mb4' src="images/comm/t.gif" id="time_min_button" style="cursor:pointer;" />&nbsp;
        <input name="Find_VN" type="submit" class="btnb" value="搜 索"></td>
        <td width="150" class="top_list_td"><span class="nav_list_td"><a href="?id=1&starttime=<?=$starttime?>&endtime=<?=$endtime?>">按日统计</a>　<a href="?id=2&starttime=<?=$starttime?>&endtime=<?=$endtime?>">按月统计</a></span></td>
      </tr>
    </table>
    </form>
  <br />
<table width="95%" border="1" cellpadding="0" cellspacing="0" bordercolor="#DDDDDD" class="t_list">
		  	<tr>
				<td class="t_list_caption"><?php if($cid==2){echo "统计月份";}else{echo "统计日期";}?></td>
			  <td class="t_list_caption">中奖总额</td>
    </tr>
			<?php 
			$i=0;
			while ($row = mysql_fetch_array($rsnewslist)){
			$tt12=$tt12+$row['t12']-$row['t16'];
			?>
			<tr class="t_list_tr_<?=$i%2?>" onMouseOver="this.style.backgroundColor='#E8F1FF'" onMouseOut="this.style.backgroundColor=''">
				<td height="25"  align="center"><?=$row['t0']?></td>
			  <td align="center"><?=number_format($row['t12']-$row['t16'],2)?></td>
			</tr>
			<?php 
			$i=$i+1;
			}
			?>
			<tr class="t_list_tr_2" >
			  <td height="25"  align="center">小结</td>
			  <td align="center"><?=number_format($tt12,2)?></td>
    </tr>
			<tr class="t_list_bottom" >
			  <td height="25" colspan="9"  align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="170" height="35">&nbsp;</td>
                <td width="150">&nbsp;</td>
                <td><div style='text-align:right;'>总计  <?=$total?> 条数据,  共 <?=$lastpg?> 页 , 当前第 <?=$page?> 页  |  <?php if($page>1){?> <A HREF="?<?=$urls?>&page=1">首页</A> <A HREF="?<?=$urls?>&page=<?=$page-1?>">上页</A><?php }?><?php for($i=$p1;$i<=$p2;$i++){
		if($i==$page){?> <span class='Font_R'><?=$i?></span> <?php }else{?> <A HREF="?<?=$urls?>&page=<?=$i?>"><?=$i?></A> <?php }}?><?php if($page!=$lastpg){?> <A HREF="?<?=$urls?>&page=<?=$page+1?>">下页</A> <A HREF="?<?=$urls?>&page=<?=$lastpg?>">尾页</A> <?php }?> | 转至 <SCRIPT LANGUAGE="JAVASCRIPT">function keepKeyNum(obj,evt){var  k=window.event?evt.keyCode:evt.which; if( k==13 ){ goPage(obj.value);return false; }} function goPage( iPage ){ if( !isNaN(parseInt(iPage)) ) { if(iPage< 0 ){iPage=0;} window.location.href="?<?=$urls?>&page="+iPage;}}</SCRIPT><INPUT onKeyPress="return keepKeyNum(this,event);" TYPE="TEXT" ID="iGotoPage" NAME="iGotoPage" size="3"> 页  &nbsp;<BUTTON onClick="javascript:goPage( document.getElementById('iGotoPage').value );return false;">GO</BUTTON></div></td>
              </tr>
            </table></td>
		    </tr>  </table>
</div>
</body>
</html>
