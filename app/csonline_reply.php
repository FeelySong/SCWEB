<?php
session_start();
error_reporting(0);
require_once 'conn.php';

$flag=$_REQUEST['flag'];
if($flag=="replay"){
	if($_POST['text']!=""){
		$sql = "insert into ssc_kf set tid='".$_REQUEST['id']."', cont='".$_REQUEST['text']."', username='".$_SESSION["username"] ."', adddate='".date("Y-m-d H:i:s")."'";
		$exe = mysql_query($sql);
		$sql = "update ssc_kf set zt='0' where id='".$_REQUEST['id']."'";
		$exe = mysql_query($sql);
	}
	echo "{\"stats\":\"ok\",\"data\":{\"writetime\":\"".date("Y-m-d H:i:s")."\",\"user\":\"".$_SESSION["username"] ."\",\"msg\":\"".$_REQUEST['text']."\"}}";
}else if($flag=="getnew"){
	echo "{\"stats\":\"error\",\"data\":\"4\"}";
}else{
	$sql = "select * from ssc_kf WHERE id='".$_REQUEST['id']."' or tid='".$_REQUEST['id']."' order by id asc";
//	echo $sql;
	$rs = mysql_query($sql);
echo "{\"stats\":\"ok\",\"data\":\"      <div class='chat' >";	
	while ($row = mysql_fetch_array($rs)){
		if($row['kf']=="0"){
			$username_mem=$row['username'];
			echo "<div class=cboxb>";
		}else{
			$username_mem="\u5ba2\u670d";
			echo "<div class=cboxy>";
		}
		echo "<div class=msbox><table border=0 cellspacing=0 cellpadding=0><tr class=t><td class=tl></td><td class=tm></td><td class=tr></td></tr><tr class=mm><td class=ml><img src='images/comm/t.gif'></td><td><table class=ti border=0 cellspacing=0 cellpadding=0><tr><td>".$row['adddate']." ( ".$username_mem." )</td></tr></table>".$row['cont']."</td><td class=mr><img src='images/comm/t.gif'></td></tr><tr class=b><td class=bl></td><td class=bm><img src='images/comm/t.gif'></td><td class=br></td></tr></table><div class=ar><div class=ic></div></div></div></div>";
	}
echo "</div><table border=0 cellspacing=0 cellpadding=0><tr><td style='padding-top:4px;'>    <input type='hidden' name='cslastid' id='cslastid' value='T8T34I' /><TEXTAREA class='ta0' NAME='csreplay' id='csreplay' title='not' style='color:#999999;' ROWS='6' COLS='68' maxlength='100'>\u8bf7\u5728\u8fd9\u91cc\u8f93\u5165\u60a8\u7684\u56de\u590d\u6d88\u606f\u3002\u8bf7\u6ce8\u610f, \u4e3a\u4fdd\u8bc1\u53ca\u76d1\u7763\u670d\u52a1\u8d28\u91cf, \u60a8\u7684\u4e0a\u7ea7\u53ef\u4ee5\u67e5\u770b\u60a8\u4e0e\u5ba2\u670d\u4e4b\u95f4\u7684\u5bf9\u8bdd\u3002</TEXTAREA></td><td style='text-align:right;float:right; color:#666666; line-height:25px;'>\u5df2\u8f93\u5165<font id='inputlen'>0</font>\u5b57<br>\u6700\u591a1000\u4e2a\u5b57<br><br><input type='button' id='replaysubmit' value='&nbsp;&nbsp;\u63d0 \u4ea4&nbsp;&nbsp;' class=yh></td></tr></table>\"}";
}
?>