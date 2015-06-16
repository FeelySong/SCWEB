<?php
session_start();
error_reporting(0);
require_once 'conn.php';

$act=$_GET['act'];
$id=$_GET['id'];

if($act=="add"){
	if($_POST['content']!=""){
		$sql="insert into ssc_kf set cont='".$_POST['content']."',adddate='".date("Y-m-d H:i:s")."',tid='".$id."',kf='1',username='客服".$_SESSION["ausername"]."'";
		$exe=mysql_query($sql) or  die("数据库修改出错12");
		$sql="update ssc_kf set answer='客服',answerdate='".date("Y-m-d H:i:s")."',zt='1' where id='".$id."'";
		$exe=mysql_query($sql) or  die("数据库修改出错1");
	}
	echo "<script>window.location.href='kfs.php?id=".$id."';</script>"; 
	exit;
}

if($act=="del"){
	mysql_query("Delete from ssc_kf where id='".$_GET['did']."' or tid='".$_GET['did']."'");
	echo "<script>alert('删除成功！');window.location.href='kfs.php?id=".$id."';</script>"; 
	exit;
}

$zt=$_GET['zt'];
if($zt=="0"){
	$sql=" and zt='0'";
}

$sql = "select * from ssc_kf WHERE id='".$id."' or tid='".$id."' order by id asc";
$rs = mysql_query($sql);
$total = mysql_num_rows($rsnewslist);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="css/index.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<style type="text/css">
<!--
body {
	background-color: #B5B5B5;
}
-->
</style></head>

<body>
<div class=chat>
<?php 
	while ($row = mysql_fetch_array($rs)){
	if($row['kf']=="0"){echo "<div class=cboxb>";}else{?>
    <div class=cboxy>
<?php }?>	
	<div class=msbox>
    	<table border=0 cellspacing=0 cellpadding=0 width=100%>
        	<tr class=t>
            	<td class=tl></td>
                <td class=tm></td>
                <td class=tr></td>
            </tr>
            <tr class=mm>
            	<td class=ml><img src='images/comm/t.gif'></td>
                <td>
                	<table class=ti border=0 cellspacing=0 cellpadding=0 width=100%>
                    	<tr>
                        	<td><?=$row['adddate']?> ( <?=$row['username']?> )</td>
                            <td width="100"><a href="kfs.php?act=del&id=<?=$id?>&did=<?=$row['id']?>" onClick="return confirm('确认要删除吗?');">删除</a></td>
                    	</tr>
                    </table>
				  <?=$row['cont']?>
                </td>
                <td class=mr><img src='images/comm/t.gif'></td>
            </tr>
            <tr class=b>
            	<td class=bl></td>
                <td class=bm><img src='images/comm/t.gif'></td>
                <td class=br></td>
            </tr>
        </table>
        <div class=ar><div class=ic></div></div>
    </div>
	</div>
<?php } ?>
</div>
<form method=post action="kfs.php?act=add&id=<?=$id?>">
<table border=0 cellspacing=0 cellpadding=0 width=560><tr><td style='padding-top:4px;'>    <TEXTAREA class='ta0' NAME='content' id='content' title='not' style='color:#999999;' ROWS='6' COLS='68' maxlength='100'></TEXTAREA></td><td style='text-align:right;float:right; color:#666666; line-height:25px;'><br>最多1000个字<br><br><input name="提交" type='submit' class=yh id='replaysubmit' onClick="return confirm('确认要发布吗?');" value='&nbsp;&nbsp;提 交&nbsp;&nbsp;'></td></tr></table>
</form>
</body>
</html>
