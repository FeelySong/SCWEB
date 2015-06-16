<?php 
error_reporting(0);
require_once 'conn.php';

$act=$_GET['act'];
if($act=="add"){
	$sql="insert into ssc_data set issue = '".$_POST['issue']."', n1 = '".$_POST['n1']."', n2 = '".$_POST['n2']."', n3 = '".$_POST['n3']."', n4 = '".$_POST['n4']."', n5 = '".$_POST['n5']."',cid='6'";
//	echo $sql;
	if (!mysql_query($sql)){
	  	die('Error: ' . mysql_error());
	}
	echo "<script language=javascript>window.location='?';</script>";
	exit;
}
if($act=="edit"){
	if($_POST['button']=="修改"){
		$sql="update ssc_data set issue = '".$_POST['issue']."', n1 = '".$_POST['n1']."', n2 = '".$_POST['n2']."', n3 = '".$_POST['n3']."', n4 = '".$_POST['n4']."', n5 = '".$_POST['n5']."' where id ='".$_POST['id']."'";
		if (!mysql_query($sql)){
			die('Error: ' . mysql_error());
		}
		echo "<script language=javascript>window.location='?';</script>";
		exit;
	}
	if($_POST['button']=="删除"){
		$sql="delete from ssc_data where id ='".$_POST['id']."'";
		if (!mysql_query($sql)){
			die('Error: ' . mysql_error());
		}
		echo "<script language=javascript>window.location='?';</script>";
		exit;
	}
}



$id=6;
	$sql="select * from ssc_data where cid='".$id."' order by issue desc";
	$rs=mysql_query($sql) or  die("数据库修改出错!!!!".mysql_error());
	$total= mysql_num_rows($rs);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD><TITLE>嘟嘟游戏  - 遗漏分析</TITLE>
<META http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<META http-equiv="Pragma" content="no-cache" />
<LINK href="css/v1.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="js/jquery.js"></script>
<script language="javascript" type="text/javascript" src="js/common.js"></script>
<script language="javascipt" type="text/javascript">

</script>
<SCRIPT LANGUAGE='JavaScript'>function ResumeError() {return true;} window.onerror = ResumeError; </SCRIPT> 
</HEAD>
<BODY STYLE='background-color:#838383;'>
<DIV ID='main_box_s2'><DIV class='icons_mb2'></DIV>当前位置: <A href="/" target='_top'>嘟嘟游戏</a> - 数据管理 </DIV>
<script language="javascript" src="js/dialog/jquery.dialogUI.js"></script>
<link rel="stylesheet" href="css/line2.css" type="text/css" />
<script language="javascript" type="text/javascript" src="js/common/line.js"></script>

<script language="javascript">
fw.onReady(function(){

	if($("#chartsTable").width()>$('body').width())
	{
	   $('body').width($("#chartsTable").width() + "px");
	}
	$("#container").height($("#chartsTable").height() + "px");
	$("#missedTable").width($("#chartsTable").width() + "px");
    resize();
	var nols = $("div[class^='ball1']");
	$("#no_miss").click(function(){
		var checked = $(this).attr("checked");
		$.each(nols,function(i,n){
			if(checked==true){
				n.style.display='none';
			}else{
				n.style.display='block';
			}
		});
	});
});
function resize(){
    window.onresize = func;
    function func(){
        window.location.href=window.location.href;
    }
}
</script>

<CENTER>
<br>
<div class='div_s1' id="container">

<table id="chartsTable" width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor='#D0D0D0'>
	<tr class="th">
		<td>序号</td>
	    <td>期号</td>
	    <td>开奖号码</td>
	    <td>功能</td>
	</tr>
    <form method=post action="?act=add">
	<tr>
		<td width="15%">新增</td>
	    <td width="20%"><input name="issue" type="text" id="issue" size="15" /></td>
	    <td>球1:<input name="n1" type="text" id="n1" size="4" /> 球2:<input name="n2" type="text" id="n2" size="4" /> 球3:<input name="n3" type="text" id="n3" size="4" /> 球4:<input name="n4" type="text" id="n4" size="4" /> 球5:<input name="n5" type="text" id="n5" size="4" /></td>
	    <td width="15%"><input type="submit" name="button" id="button" value="保存" /></td>
	</tr>
    </form>
<?php 
	while ($row = mysql_fetch_array($rs)){
?>    
    <form method=post action="?act=edit">
	<tr class=tb>
		<td><?=$row['id']?><input name="id" type="hidden" id="id" value="<?=$row['id']?>"/></td>
	    <td><input name="issue" type="text" id="issue" value="<?=$row['issue']?>" size="15" /></td>
	    <td>球1:<input name="n1" type="text" id="n1" value="<?=$row['n1']?>" size="4" /> 球2:<input name="n2" type="text" id="n2" value="<?=$row['n2']?>" size="4" /> 球3:<input name="n3" type="text" id="n3" value="<?=$row['n3']?>" size="4" /> 球4:<input name="n4" type="text" id="n4" value="<?=$row['n4']?>" size="4" /> 球5:<input name="n5" type="text" id="n5" value="<?=$row['n5']?>" size="4" /></td>
	    <td><input type="submit" name="button" id="button" value="修改" /> <input type="submit" name="button" id="button" value="删除" /></td>
	</tr>
    </form>
<?php }?>
</table>
</div>
<br/>

</CENTER>
