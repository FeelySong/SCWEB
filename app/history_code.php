<?php 
session_start();
error_reporting(0);
require_once 'conn.php';
//require_once 'check.php';

$id=$_REQUEST['id'];
$issuecount=$_REQUEST['issuecount'];
if($id==""){
	$id=1;
}

if($issuecount==""){
	$issuecount=30;
}

	$sql="select * from ssc_data where cid='".$id."' order by issue desc limit ".$issuecount."";
	$rs=mysql_query($sql) or  die("数据库修改出错!!!!".mysql_error());
	$total= mysql_num_rows($rs);

if($id<5 || $id==10){
	$ns=5;
	$nts=50;
	$ntx=0;
	$ntd=9;
	$ntn=10;
}else if($id==5 || $id==9){
	$ns=3;
	$nts=30;
	$ntx=0;
	$ntd=9;
	$ntn=10;
}else if($id==6 || $id==7 || $id==8 || $id==11){
	$ns=5;
	$nts=55;
	$ntx=1;
	$ntd=11;
	$ntn=11;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD><TITLE><?php echo $webname;?>  - 遗漏分析</TITLE>
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
<DIV ID='main_box_s2'><DIV class='icons_mb2'></DIV>当前位置: <A href="/" target='_top'><?php echo $webname;?></a> - 遗漏分析 </DIV>
<script language="javascript" src="js/dialog/jquery.dialogUI.js"></script>
<link rel="stylesheet" href="css/line.css" type="text/css" />
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
	jQuery("#starttime").dynDateTime({
		ifFormat: "%Y-%m-%d",
		daFormat: "%l;%M %p, %e %m,  %Y",
		align: "Br",
		electric: true,
		singleClick: true,
		button: ".next()", //next sibling
		onUpdate:function(){
			$("#starttime").change();
		},
		showOthers: true,
		weekNumbers: true,
		showsTime: false
	});
	jQuery("#starttime").change(function(){
		if(! validateInputDate(jQuery("#starttime").val()) )
		{
			jQuery("#starttime").val('');
			$.alert("日期格式不正确,正确的格式为:2011-01-01");
		}
		if($("#endtime").val()!="")
		{
			if($("#starttime").val()>$("#endtime").val())
			{
				$("#starttime").val("");
				$.alert("输入的时间不符合逻辑, 起始时间大于结束时间");
			}
			else
			{
			    if(daysBetween($("#starttime").val(),$("#endtime").val()) > 1)
			    {
			        $("#starttime").val("");
			        $.alert("输入的时间跨度不能超过2天！");
			    }
			}
		}
	});
	jQuery("#endtime").dynDateTime({
		ifFormat: "%Y-%m-%d",
		daFormat: "%l;%M %p, %e %m,  %Y",
		align: "Br",
		electric: true,
		singleClick: true,
		button: ".next()", //next sibling
		onUpdate:function(){
			$("#endtime").change();
		},
		showOthers: true,
		weekNumbers: true,
		showsTime: false
	});
	jQuery("#endtime").change(function(){
		if(! validateInputDate(jQuery("#endtime").val()) )
		{
			jQuery("#endtime").val('');
			$.alert("日期格式不正确,正确的格式为:2011-01-01");
		}
		if($("#starttime").val()!="")
		{
			if($("#starttime").val()>$("#endtime").val())
			{
				$("#endtime").val("");
				$.alert("输入的时间不符合逻辑, 起始时间大于结束时间");
			}
			else
			{
			    if(daysBetween($("#starttime").val(),$("#endtime").val()) > 1)
			    {
			        $("#endtime").val("");
			        $.alert("输入的时间跨度不能超过2天！");
			    }
			}
		}
	});
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
function daysBetween(start, end){
   var startY = start.substring(0, start.indexOf('-'));
   var startM = start.substring(start.indexOf('-')+1, start.lastIndexOf('-'));
   var startD = start.substring(start.lastIndexOf('-')+1, start.length);
  
   var endY = end.substring(0, end.indexOf('-'));
   var endM = end.substring(end.indexOf('-')+1, end.lastIndexOf('-'));
   var endD = end.substring(end.lastIndexOf('-')+1, end.length);
  
   var val = (Date.parse(endY+'/'+endM+'/'+endD)-Date.parse(startY+'/'+startM+'/'+startD))/86400000;
   return Math.abs(val);
}
</script>

<CENTER>
<div class=div_s1><table width=100% id=tm border=0 cellpadding=0 cellspacing=0>
	<tr>
		<td align=left width=200>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong><font color="#FF0000"><?=Get_lottery($id)?>：</font>基本走势</strong></td>
		<td align=right><form method="POST">
		<input type="checkbox" name="checkbox2" value="checkbox" id="has_line" />
		  <span><label for="has_line">显示折线</label></span>&nbsp;
		  <input type="checkbox" name="checkbox" value="checkbox" id="no_miss" />
		  <span><label for="no_miss">不带遗漏</label></span>&nbsp;&nbsp;&nbsp;

            <a href="./history_code.php?id=<?=$id?>&issuecount=30">最近30期</a>&nbsp;
			<a href="./history_code.php?id=<?=$id?>&issuecount=50">最近50期</a>&nbsp;
            <a href="./history_code.php?id=<?=$id?>&issuecount=50">最近100期</a>&nbsp;
            <a href="./history_code.php?id=<?=$id?>&wday=b">前天</a>&nbsp;
            <a href="./history_code.php?id=<?=$id?>&wday=y">昨天</a>&nbsp;
            <a href="./history_code.php?id=<?=$id?>&wday=t">今天</a>&nbsp;
                        <input class=in type="text" value="" name="starttime" id="starttime">
			<img class='icons_mb4' src="images/comm/t.gif" style="vertical-align:middle;">
			&nbsp;至&nbsp;
			<input class=in type="text" value="" name="endtime" id="endtime">
			<img class='icons_mb4' src="images/comm/t.gif" style="vertical-align:middle;">
			<input type="submit" value="搜索">&nbsp;&nbsp;&nbsp;
            </form>
		</td>
	</tr>

</table></div><br/>


<div class='div_s1' id="container">

<table id="chartsTable" width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor='#D0D0D0'>
	<tr class="th">
                 <td rowspan="2">期号</td>
                 <td rowspan="2" colspan="<?=$ns?>">开奖号码</td>
<?php if($ns==5){ ?>
                 <td colspan="<?=$ntn?>">万位</td>
                 <td colspan="<?=$ntn?>">千位</td>
<?php }?>
                 <td colspan="<?=$ntn?>">百位</td>
		 		 <td colspan="<?=$ntn?>">十位</td>
		 		 <td colspan="<?=$ntn?>">个位</td>
		 	</tr>
			<tr class='th'>
<?php
		for($i=0;$i<$ns;$i++){
			for($ii=$ntx;$ii<=$ntd;$ii++){
?>
				<td class="wdh"><?=$ii?></td>
<?php }}?>
			</tr>
<?php
	for($i=0;$i<=$nts;$i++){
		$s[$i]=0;
		$a[$i]=0;
		$b[$i]=0;
		$c[$i]=0;
		$d[$i]=0;
	}
	while ($row = mysql_fetch_array($rs)){

		$na[1]=$row['n1'];
		$na[2]=$row['n2'];
		$na[3]=$row['n3'];
		$na[4]=$row['n4'];
		$na[5]=$row['n5'];
		
		for($i=0;$i<=$nts;$i++){
			$a[$i]=$a[$i]+1;
			$c[$i]=$c[$i]+1;
			if($b[$i]<$a[$i]){
				$b[$i]=$a[$i];
			}
			if($d[$i]<$c[$i]){
				$d[$i]=$c[$i];
			}
		}
?>			
            <tr>
				<td class='issue'><?=$row['issue']?></td>

				<td class="wth" align="center"><?=$row['n1']?></td>
				<td class="wth" align="center"><?=$row['n2']?></td>
				<td class="wth" align="center"><?=$row['n3']?></td>
<?php if($ns==5){ ?>
				<td class="wth" align="center"><?=$row['n4']?></td>
				<td class="wth" align="center"><?=$row['n5']?></td>
<?php }?>

<?php
		$iii=0;
		for($i=0;$i<$ns;$i++){
			for($ii=$ntx;$ii<=$ntd;$ii++){
				$iii=$iii+1;
?>
				<td class="wdh td<?=$i%2?>" align="center"><?php if($na[$i+1]==$ii){echo "<div class='ball0".($i%2+1)."'>".$na[$i+1]."</div>";$a[$iii]=0;$s[$iii]=$s[$iii]+1;}else{echo "<div class='ball13'>".$a[$iii]."</div>";$c[$iii]=0;}?></td>
<?php }}?>
			</tr>
 <?php }?>
                                                        


	<tr class=tb>
		<td nowrap>出现总次数</td>
		<td align="center" colspan="<?=$ns?>">&nbsp;</td>
<?php for($i=1;$i<=$nts;$i++){?>
		<td align="center"><?=$s[$i]?></td>
<?php }?>
	</tr>
	<tr class=tb>
		<td nowrap>平均遗漏值</td>
		<td align="center" colspan="<?=$ns?>">&nbsp;</td>
<?php for($i=1;$i<=$nts;$i++){
	if($s[$i]==0){$av=$total;}
	else{$av=intval($total/$s[$i]);}
?>
		<td align="center"><?=$av?></td>
<?php }?>
	</tr>
	<tr class=tb>
		<td nowrap>最大遗漏值</td>
		<td align="center" colspan="<?=$ns?>">&nbsp;</td>
<?php for($i=1;$i<=$nts;$i++){
	if($b[$i]-1<$a[$i]){$bv=$a[$i];}
	else{$bv=$b[$i]-1;}
?>
		<td align="center"><?=$bv?></td>
<?php }?>
	</tr>

	<tr class=tb>
		<td nowrap>最大连出值</td>
		<td align="center" colspan="<?=$ns?>">&nbsp;</td>
<?php for($i=1;$i<=$nts;$i++){
	if($d[$i]-1<$c[$i]){$dv=$c[$i];}
	else{$dv=$d[$i]-1;}
?>
		<td align="center"><?=$dv?></td>
<?php }?>
	</tr>

	<tr class=th>
		<td rowspan="2" >期号</td>
		<td rowspan="2" colspan="<?=$ns?>">开奖号码</td>
<?php
		for($i=0;$i<$ns;$i++){
			for($ii=$ntx;$ii<=$ntd;$ii++){
?>
		<td class="wdh"><?=$ii?></td>
<?php }}?>

	</tr>
	<tr class=th>
<?php if($ns==5){ ?>
                 <td colspan="<?=$ntn?>">万位</td>
                 <td colspan="<?=$ntn?>">千位</td>
<?php }?>
                 <td colspan="<?=$ntn?>">百位</td>
		 		 <td colspan="<?=$ntn?>">十位</td>
		 		 <td colspan="<?=$ntn?>">个位</td>		                      
	</tr>
</table>
</div>
<br/>

</CENTER>
