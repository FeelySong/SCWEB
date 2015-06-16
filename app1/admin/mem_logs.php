<?php
session_start();
error_reporting(0);
require_once 'conn.php';

$jb=array("用户","代理","总代理"); 

if (strpos($_SESSION['admin_flag'],'24') ){}else{ 
	echo "<script language=javascript>alert('对不起，您无此权限！');window.history.go(-1);</script>";
exit;}

$uname=$_REQUEST['uname'];
$starttime=$_REQUEST['starttime'];
$endtime=$_REQUEST['endtime'];
$level=$_REQUEST['level'];

$username_mem=$_REQUEST['username'];
$loginip=$_REQUEST['loginip'];

if($_GET['act']=="dels"){       //批量删除   
	$ids=$_POST['lids'];  
	$ids=implode(",", $ids);   //implode函数 把数组元素组合为一个字符串。   
	$sql="delete from ssc_memberlogin where id in ($ids)";  
	mysql_query($sql);  
}

if($_GET['act']=="del"){
	mysql_query("Delete from ssc_memberlogin where id=".$_GET['id']);
	echo "<script>window.location.href='mem_logs.php';</script>"; 
	exit;
}
$page = !($_GET['page'])?'1':intval($_GET['page']);
$pagesize=15;
$page2=($page-1)*$pagesize;

if($starttime==""){
	if(date("H:i:s")<"03:00:00"){
		$starttime=date("Y-m-d",strtotime("-1 day"))." 03:00:00";
	}else{
		$starttime=date("Y-m-d")." 03:00:00";
	}
}
	$s1=$s1." and logindate>='".$starttime."'";

if($endtime==""){
	if(date("H:i:s")<"03:00:00"){
		$endtime=date("Y-m-d")." 03:00:00";
	}else{
		$endtime=date("Y-m-d",strtotime("+1 day"))." 03:00:00";
	}
}
	$s1=$s1." and logindate<='".$endtime."'";

if($uname!=""){
	$username_mem=$uname;
}

if($username_mem!=""){
	$s1=$s1." and username='".$username_mem."'";
}

if($level!=""){
	$s1=$s1." and level='".$level."'";
}

if($loginip!=""){
	$s1=$s1." and loginip='".$loginip."'";
}

$urls="starttime=".$starttime."&endtime=".$endtime."&username=".$username_mem."&loginip=".$loginip."&level=".$level;

$s1=$s1." order by id desc";
$sql="select * from ssc_memberlogin where 1=1".$s1;
$rs = mysql_query($sql);
$total = mysql_num_rows($rs);

$sql="select * from ssc_memberlogin where 1=1".$s1." limit $page2,$pagesize";
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
<html>
<head>
<link href="css/index.css" rel="stylesheet" type="text/css">
<base target="mainframe" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>
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
<body>
<br>
	<table width="95%" border="0" cellpadding="0" cellspacing="0" class="top_list">
      <tr>
        <td class="top_list_td icons_a2">　　您现在的位置是：会员管理 &gt; 登录日志</td>
      </tr>
    </table>
<br>
    <form name="memberForm" method="post" action="?">
    <table width="95%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td class="top_list_td">登录时间:
          <input name="starttime" type="text" class="inpa" id="starttime" style='width:144px;' value="<?=$starttime?>" size="19" />
          <img class='icons_mb4' src="images/comm/t.gif" id="time_min_button" style="cursor:pointer;" /> 至
          <input name="endtime" type="text" class="inpa" id="endtime" style='width:144px;' value="<?=$endtime?>" size="19" / >
          <img class='icons_mb4' src="images/comm/t.gif" id="time_min_button" style="cursor:pointer;" />
          &nbsp;
          类型:
          <select name="level" style='cursor: hand' id="types">
            <option value="">全部</option>
            <option value="0" <?php if($level=="0") echo "selected";?>>用户</option>
            <option value="1" <?php if($level=="1") echo "selected";?>>代理</option>
            <option value="2" <?php if($level=="2") echo "selected";?>>总代理</option>
          </select>
          &nbsp;用户名:
          
          <input name="username" type="text" class="inpa" value="" size="15" maxlength="30" id="username">
          &nbsp;IP地址:
          
          <input name="loginip" type="text" class="inpa" value="" size="20" maxlength="30" id="loginip">
          &nbsp;
        <input name="Find_VN" type="submit" class="btnb" value="搜 索" style="position: relative; top: 2px;"></td>
      </tr>
    </table>
</form>
<br>
  	<form method=post action="?act=dels">
	<table width="95%" border="1" cellpadding="0" cellspacing="0" bordercolor="#DDDDDD" class="t_list">
        <tr>
            <td class="t_list_caption">选择</td>
            <td class="t_list_caption">序号</td>
            <td class="t_list_caption">类型</td>
          <td class="t_list_caption">用户名</td>
            <td class="t_list_caption">IP地址</td>
            <td class="t_list_caption">IP地区</td>
            <td class="t_list_caption">浏览器</td>
            <td class="t_list_caption">操作系统</td>
            <td class="t_list_caption">移动设置</td>
            <td class="t_list_caption">登陆时间</td>
            <td class="t_list_caption">操作</td>
      </tr>
        <?php
		while ($row = mysql_fetch_array($rsnewslist))
		{
		?>
            <tr class="t_list_tr_0" onMouseOver="this.style.backgroundColor='#FFFFA2'" onMouseOut="this.style.backgroundColor=''">
                <td><input name="lids[]" type="checkbox" id="checkbox2" value="<?=$row['id']?>"></td> 
                <td><?=$row['id']?></td>
                <td><?=$jb[$row['level']]?></td>
                <td><a href="?uname=<?=$row['username']?>"><?=$row['username']?></a></td>
              <td><?=$row['loginip']?></td>
                <td><?=$row['loginarea']?></td>
                <td><?=determinebrowser($row['explorer'])?></td>
                <td><?=determineplatform($row['explorer'])?></td>
                <td><?="否"?></td>
                <td><?=$row['logindate']?></td>
                <td><a href="?uname=<?=$row['username']."&".$urls?>">只看此人</a> <a href="mem_logs.php?act=del&id=<?=$row['id']?>" onClick="return confirm('确认要删除吗?');">删除</a></td>
      </tr>
 		<?php
		}
		?>

      <tr>
            <td colspan="11" class="t_list_bottom"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="170" height="35">　选择：<a href="javascript:select()">全选</a> - <a href="javascript:fanselect()">反选</a> - <a href="javascript:noselect()">不选</a></td>
                <td width="150"><input name="Submit" type="submit" class="btndel" onClick="return confirm('确认要删除吗?');" value=" " /></td>
                <td><div style='text-align:right;'>总计  <?=$total?> 条数据,  共 <?=$lastpg?> 页 , 当前第 <?=$page?> 页  |  <?php if($page>1){?> <A HREF="?<?=$urls?>&page=1">首页</A> <A HREF="?<?=$urls?>&page=<?=$page-1?>">上页</A><?php }?><?php for($i=$p1;$i<=$p2;$i++){
		if($i==$page){?> <span class='Font_R'><?=$i?></span> <?php }else{?> <A HREF="?<?=$urls?>&page=<?=$i?>"><?=$i?></A> <?php }}?><?php if($page!=$lastpg){?> <A HREF="?<?=$urls?>&page=<?=$page+1?>">下页</A> <A HREF="?<?=$urls?>&page=<?=$lastpg?>">尾页</A> <?php }?> | 转至 <SCRIPT LANGUAGE="JAVASCRIPT">function keepKeyNum(obj,evt){var  k=window.event?evt.keyCode:evt.which; if( k==13 ){ goPage(obj.value);return false; }} function goPage( iPage ){ if( !isNaN(parseInt(iPage)) ) { if(iPage< 0 ){iPage=0;} window.location.href="?<?=$urls?>&page="+iPage;}}</SCRIPT><INPUT onKeyPress="return keepKeyNum(this,event);" TYPE="TEXT" ID="iGotoPage" NAME="iGotoPage" size="3"> 页  &nbsp;<BUTTON onClick="javascript:goPage( document.getElementById('iGotoPage').value );return false;">GO</BUTTON></div></td>
              </tr>
            </table></td>
      </tr>
</table>
</form>
<br>


</body>
</html> 