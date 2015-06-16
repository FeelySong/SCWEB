<?php 
session_start();
error_reporting(0);
require_once 'conn.php';
require_once 'check.php';

$id=$_REQUEST['id'];
	$sql="select * from ssc_data where cid='".$id."' order by issue desc limit 30";
	$rs=mysql_query($sql) or  die("数据库修改出错!!!!".mysql_error());
	$total= mysql_num_rows($rs);

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
		<td align=left width=200>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong><font color="#FF0000">重庆时时彩：</font>基本走势</strong></td>
		<td align=right><form method="POST">
		<input type="checkbox" name="checkbox2" value="checkbox" id="has_line" />
		  <span><label for="has_line">显示折线</label></span>&nbsp;
		  <input type="checkbox" name="checkbox" value="checkbox" id="no_miss" />
		  <span><label for="no_miss">不带遗漏</label></span>&nbsp;&nbsp;&nbsp;

            <a href="./history_code.php?id=1&issuecount=30">最近30期</a>&nbsp;
			<a href="./history_code.php?id=1&issuecount=50">最近50期</a>&nbsp;
            <a href="./history_code.php?id=1&issuecount=50">最近100期</a>&nbsp;
            <a href="./history_code.php?id=1&wday=b">前天</a>&nbsp;
            <a href="./history_code.php?id=1&wday=y">昨天</a>&nbsp;
            <a href="./history_code.php?id=1&wday=t">今天</a>&nbsp;
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
		 <td rowspan="2" colspan="5">开奖号码</td>
		 		 <td colspan="10">万位</td>
		 		 <td colspan="10">千位</td>
		 		 <td colspan="10">百位</td>
		 		 <td colspan="10">十位</td>
		 		 <td colspan="10">个位</td>
		 	</tr>
			<tr class='th'>
							<td class="wdh">0</td>
							<td class="wdh">1</td>
							<td class="wdh">2</td>
							<td class="wdh">3</td>
							<td class="wdh">4</td>
							<td class="wdh">5</td>
							<td class="wdh">6</td>
							<td class="wdh">7</td>
							<td class="wdh">8</td>
							<td class="wdh">9</td>
												<td class="wdh">0</td>
							<td class="wdh">1</td>
							<td class="wdh">2</td>
							<td class="wdh">3</td>
							<td class="wdh">4</td>
							<td class="wdh">5</td>
							<td class="wdh">6</td>
							<td class="wdh">7</td>
							<td class="wdh">8</td>
							<td class="wdh">9</td>
												<td class="wdh">0</td>
							<td class="wdh">1</td>
							<td class="wdh">2</td>
							<td class="wdh">3</td>
							<td class="wdh">4</td>
							<td class="wdh">5</td>
							<td class="wdh">6</td>
							<td class="wdh">7</td>
							<td class="wdh">8</td>
							<td class="wdh">9</td>
												<td class="wdh">0</td>
							<td class="wdh">1</td>
							<td class="wdh">2</td>
							<td class="wdh">3</td>
							<td class="wdh">4</td>
							<td class="wdh">5</td>
							<td class="wdh">6</td>
							<td class="wdh">7</td>
							<td class="wdh">8</td>
							<td class="wdh">9</td>
												<td class="wdh">0</td>
							<td class="wdh">1</td>
							<td class="wdh">2</td>
							<td class="wdh">3</td>
							<td class="wdh">4</td>
							<td class="wdh">5</td>
							<td class="wdh">6</td>
							<td class="wdh">7</td>
							<td class="wdh">8</td>
							<td class="wdh">9</td>
						</tr>
<?php
			$s10=0;
			$s11=0;
			$s12=0;
			$s13=0;
			$s14=0;
			$s15=0;
			$s16=0;
			$s17=0;
			$s18=0;
			$s19=0;

			$s20=0;
			$s21=0;
			$s22=0;
			$s23=0;
			$s24=0;
			$s25=0;
			$s26=0;
			$s27=0;
			$s28=0;
			$s29=0;

			$s30=0;
			$s31=0;
			$s32=0;
			$s33=0;
			$s34=0;
			$s35=0;
			$s36=0;
			$s37=0;
			$s38=0;
			$s39=0;

			$s40=0;
			$s41=0;
			$s42=0;
			$s43=0;
			$s44=0;
			$s45=0;
			$s46=0;
			$s47=0;
			$s48=0;
			$s49=0;

			$s50=0;
			$s51=0;
			$s52=0;
			$s53=0;
			$s54=0;
			$s55=0;
			$s56=0;
			$s57=0;
			$s58=0;
			$s59=0;

			while ($row = mysql_fetch_array($rs)){
			$n1=$row['n1'];
			$n2=$row['n2'];
			$n3=$row['n3'];
			$n4=$row['n4'];
			$n5=$row['n5'];
			
			$n10=$n10+1;
			$n11=$n11+1;
			$n12=$n12+1;
			$n13=$n13+1;
			$n14=$n14+1;
			$n15=$n15+1;
			$n16=$n16+1;
			$n17=$n17+1;
			$n18=$n18+1;
			$n19=$n19+1;

			$n20=$n20+1;
			$n21=$n21+1;
			$n22=$n22+1;
			$n23=$n23+1;
			$n24=$n24+1;
			$n25=$n25+1;
			$n26=$n26+1;
			$n27=$n27+1;
			$n28=$n28+1;
			$n29=$n29+1;

			$n30=$n30+1;
			$n31=$n31+1;
			$n32=$n32+1;
			$n33=$n33+1;
			$n34=$n34+1;
			$n35=$n35+1;
			$n36=$n36+1;
			$n37=$n37+1;
			$n38=$n38+1;
			$n39=$n39+1;

			$n40=$n40+1;
			$n41=$n41+1;
			$n42=$n42+1;
			$n43=$n43+1;
			$n44=$n44+1;
			$n45=$n45+1;
			$n46=$n46+1;
			$n47=$n47+1;
			$n48=$n48+1;
			$n49=$n49+1;

			$n50=$n50+1;
			$n51=$n51+1;
			$n52=$n52+1;
			$n53=$n53+1;
			$n54=$n54+1;
			$n55=$n55+1;
			$n56=$n56+1;
			$n57=$n57+1;
			$n58=$n58+1;
			$n59=$n59+1;
			


?>			
            <tr>
			<td class='issue'><?=$row['issue']?></td>
						<td class="wth" align="center"><?=$row['n1']?></td>
						<td class="wth" align="center"><?=$row['n2']?></td>
						<td class="wth" align="center"><?=$row['n3']?></td>
						<td class="wth" align="center"><?=$row['n4']?></td>
						<td class="wth" align="center"><?=$row['n5']?></td>
                        
						<td class="wdh td0" align="center"><?php if($n1==0){echo "<div class='ball01'>".$n1."</div>";$n10=0;$s10=$s10+1;}else{echo "<div class='ball13'>".$n10."</div>";}?></td>
						<td class="wdh td0" align="center"><?php if($n1==1){echo "<div class='ball01'>".$n1."</div>";$n11=0;$s11=$s11+1;}else{echo "<div class='ball13'>".$n11."</div>";}?></td>
						<td class="wdh td0" align="center"><?php if($n1==2){echo "<div class='ball01'>".$n1."</div>";$n12=0;$s12=$s12+1;}else{echo "<div class='ball13'>".$n12."</div>";}?></td>
						<td class="wdh td0" align="center"><?php if($n1==3){echo "<div class='ball01'>".$n1."</div>";$n13=0;$s13=$s13+1;}else{echo "<div class='ball13'>".$n13."</div>";}?></td>
						<td class="wdh td0" align="center"><?php if($n1==4){echo "<div class='ball01'>".$n1."</div>";$n14=0;$s14=$s14+1;}else{echo "<div class='ball13'>".$n14."</div>";}?></td>
						<td class="wdh td0" align="center"><?php if($n1==5){echo "<div class='ball01'>".$n1."</div>";$n15=0;$s15=$s15+1;}else{echo "<div class='ball13'>".$n15."</div>";}?></td>
						<td class="wdh td0" align="center"><?php if($n1==6){echo "<div class='ball01'>".$n1."</div>";$n16=0;$s16=$s16+1;}else{echo "<div class='ball13'>".$n16."</div>";}?></td>
						<td class="wdh td0" align="center"><?php if($n1==7){echo "<div class='ball01'>".$n1."</div>";$n17=0;$s17=$s17+1;}else{echo "<div class='ball13'>".$n17."</div>";}?></td>
						<td class="wdh td0" align="center"><?php if($n1==8){echo "<div class='ball01'>".$n1."</div>";$n18=0;$s18=$s18+1;}else{echo "<div class='ball13'>".$n18."</div>";}?></td>
						<td class="wdh td0" align="center"><?php if($n1==9){echo "<div class='ball01'>".$n1."</div>";$n19=0;$s19=$s19+1;}else{echo "<div class='ball13'>".$n19."</div>";}?></td>
                        
						<td class="wdh td1" align="center"><?php if($n2==0){echo "<div class='ball02'>".$n2."</div>";$n20=0;$s20=$s20+1;}else{echo "<div class='ball14'>".$n20."</div>";}?></td>
						<td class="wdh td1" align="center"><?php if($n2==1){echo "<div class='ball02'>".$n2."</div>";$n21=0;$s21=$s21+1;}else{echo "<div class='ball14'>".$n21."</div>";}?></td>
						<td class="wdh td1" align="center"><?php if($n2==2){echo "<div class='ball02'>".$n2."</div>";$n22=0;$s22=$s22+1;}else{echo "<div class='ball14'>".$n22."</div>";}?></td>
						<td class="wdh td1" align="center"><?php if($n2==3){echo "<div class='ball02'>".$n2."</div>";$n23=0;$s23=$s23+1;}else{echo "<div class='ball14'>".$n23."</div>";}?></td>
						<td class="wdh td1" align="center"><?php if($n2==4){echo "<div class='ball02'>".$n2."</div>";$n24=0;$s24=$s24+1;}else{echo "<div class='ball14'>".$n24."</div>";}?></td>
						<td class="wdh td1" align="center"><?php if($n2==5){echo "<div class='ball02'>".$n2."</div>";$n25=0;$s25=$s25+1;}else{echo "<div class='ball14'>".$n25."</div>";}?></td>
						<td class="wdh td1" align="center"><?php if($n2==6){echo "<div class='ball02'>".$n2."</div>";$n26=0;$s26=$s26+1;}else{echo "<div class='ball14'>".$n26."</div>";}?></td>
						<td class="wdh td1" align="center"><?php if($n2==7){echo "<div class='ball02'>".$n2."</div>";$n27=0;$s27=$s27+1;}else{echo "<div class='ball14'>".$n27."</div>";}?></td>
						<td class="wdh td1" align="center"><?php if($n2==8){echo "<div class='ball02'>".$n2."</div>";$n28=0;$s28=$s28+1;}else{echo "<div class='ball14'>".$n28."</div>";}?></td>
						<td class="wdh td1" align="center"><?php if($n2==9){echo "<div class='ball02'>".$n2."</div>";$n29=0;$s29=$s29+1;}else{echo "<div class='ball14'>".$n29."</div>";}?></td>
																										

						<td class="wdh td0" align="center"><?php if($n3==0){echo "<div class='ball01'>".$n3."</div>";$n30=0;$s30=$s30+1;}else{echo "<div class='ball13'>".$n30."</div>";}?></td>
						<td class="wdh td0" align="center"><?php if($n3==1){echo "<div class='ball01'>".$n3."</div>";$n31=0;$s31=$s31+1;}else{echo "<div class='ball13'>".$n31."</div>";}?></td>
						<td class="wdh td0" align="center"><?php if($n3==2){echo "<div class='ball01'>".$n3."</div>";$n32=0;$s32=$s32+1;}else{echo "<div class='ball13'>".$n32."</div>";}?></td>
						<td class="wdh td0" align="center"><?php if($n3==3){echo "<div class='ball01'>".$n3."</div>";$n33=0;$s33=$s33+1;}else{echo "<div class='ball13'>".$n33."</div>";}?></td>
						<td class="wdh td0" align="center"><?php if($n3==4){echo "<div class='ball01'>".$n3."</div>";$n34=0;$s34=$s34+1;}else{echo "<div class='ball13'>".$n34."</div>";}?></td>
						<td class="wdh td0" align="center"><?php if($n3==5){echo "<div class='ball01'>".$n3."</div>";$n35=0;$s35=$s35+1;}else{echo "<div class='ball13'>".$n35."</div>";}?></td>
						<td class="wdh td0" align="center"><?php if($n3==6){echo "<div class='ball01'>".$n3."</div>";$n36=0;$s36=$s36+1;}else{echo "<div class='ball13'>".$n36."</div>";}?></td>
						<td class="wdh td0" align="center"><?php if($n3==7){echo "<div class='ball01'>".$n3."</div>";$n37=0;$s37=$s37+1;}else{echo "<div class='ball13'>".$n37."</div>";}?></td>
						<td class="wdh td0" align="center"><?php if($n3==8){echo "<div class='ball01'>".$n3."</div>";$n38=0;$s38=$s38+1;}else{echo "<div class='ball13'>".$n38."</div>";}?></td>
						<td class="wdh td0" align="center"><?php if($n3==9){echo "<div class='ball01'>".$n3."</div>";$n39=0;$s39=$s39+1;}else{echo "<div class='ball13'>".$n39."</div>";}?></td>
                        
						<td class="wdh td1" align="center"><?php if($n4==0){echo "<div class='ball02'>".$n4."</div>";$n40=0;$s40=$s40+1;}else{echo "<div class='ball14'>".$n40."</div>";}?></td>
						<td class="wdh td1" align="center"><?php if($n4==1){echo "<div class='ball02'>".$n4."</div>";$n41=0;$s41=$s41+1;}else{echo "<div class='ball14'>".$n41."</div>";}?></td>
						<td class="wdh td1" align="center"><?php if($n4==2){echo "<div class='ball02'>".$n4."</div>";$n42=0;$s42=$s42+1;}else{echo "<div class='ball14'>".$n42."</div>";}?></td>
						<td class="wdh td1" align="center"><?php if($n4==3){echo "<div class='ball02'>".$n4."</div>";$n43=0;$s43=$s43+1;}else{echo "<div class='ball14'>".$n43."</div>";}?></td>
						<td class="wdh td1" align="center"><?php if($n4==4){echo "<div class='ball02'>".$n4."</div>";$n44=0;$s44=$s44+1;}else{echo "<div class='ball14'>".$n44."</div>";}?></td>
						<td class="wdh td1" align="center"><?php if($n4==5){echo "<div class='ball02'>".$n4."</div>";$n45=0;$s45=$s45+1;}else{echo "<div class='ball14'>".$n45."</div>";}?></td>
						<td class="wdh td1" align="center"><?php if($n4==6){echo "<div class='ball02'>".$n4."</div>";$n46=0;$s46=$s46+1;}else{echo "<div class='ball14'>".$n46."</div>";}?></td>
						<td class="wdh td1" align="center"><?php if($n4==7){echo "<div class='ball02'>".$n4."</div>";$n47=0;$s47=$s47+1;}else{echo "<div class='ball14'>".$n47."</div>";}?></td>
						<td class="wdh td1" align="center"><?php if($n4==8){echo "<div class='ball02'>".$n4."</div>";$n48=0;$s48=$s48+1;}else{echo "<div class='ball14'>".$n48."</div>";}?></td>
						<td class="wdh td1" align="center"><?php if($n4==9){echo "<div class='ball02'>".$n4."</div>";$n49=0;$s49=$s49+1;}else{echo "<div class='ball14'>".$n49."</div>";}?></td>
                        
						<td class="wdh td0" align="center"><?php if($n5==0){echo "<div class='ball01'>".$n5."</div>";$n50=0;$s50=$s50+1;}else{echo "<div class='ball13'>".$n50."</div>";}?></td>
						<td class="wdh td0" align="center"><?php if($n5==1){echo "<div class='ball01'>".$n5."</div>";$n51=0;$s51=$s51+1;}else{echo "<div class='ball13'>".$n51."</div>";}?></td>
						<td class="wdh td0" align="center"><?php if($n5==2){echo "<div class='ball01'>".$n5."</div>";$n52=0;$s52=$s52+1;}else{echo "<div class='ball13'>".$n52."</div>";}?></td>
						<td class="wdh td0" align="center"><?php if($n5==3){echo "<div class='ball01'>".$n5."</div>";$n53=0;$s53=$s53+1;}else{echo "<div class='ball13'>".$n53."</div>";}?></td>
						<td class="wdh td0" align="center"><?php if($n5==4){echo "<div class='ball01'>".$n5."</div>";$n54=0;$s54=$s54+1;}else{echo "<div class='ball13'>".$n54."</div>";}?></td>
						<td class="wdh td0" align="center"><?php if($n5==5){echo "<div class='ball01'>".$n5."</div>";$n55=0;$s55=$s55+1;}else{echo "<div class='ball13'>".$n55."</div>";}?></td>
						<td class="wdh td0" align="center"><?php if($n5==6){echo "<div class='ball01'>".$n5."</div>";$n56=0;$s56=$s56+1;}else{echo "<div class='ball13'>".$n56."</div>";}?></td>
						<td class="wdh td0" align="center"><?php if($n5==7){echo "<div class='ball01'>".$n5."</div>";$n57=0;$s57=$s57+1;}else{echo "<div class='ball13'>".$n57."</div>";}?></td>
						<td class="wdh td0" align="center"><?php if($n5==8){echo "<div class='ball01'>".$n5."</div>";$n58=0;$s58=$s58+1;}else{echo "<div class='ball13'>".$n58."</div>";}?></td>
						<td class="wdh td0" align="center"><?php if($n5==9){echo "<div class='ball01'>".$n5."</div>";$n59=0;$s59=$s59+1;}else{echo "<div class='ball13'>".$n59."</div>";}?></td>
					</tr>
                                                        
 <?php }?>                                                       
                                                        


	<tr class=tb>
		<td nowrap>出现总次数</td>
		<td align="center" colspan="5">&nbsp;</td>
						<td align="center"><?=$s10?></td>
						<td align="center"><?=$s11?></td>
						<td align="center"><?=$s12?></td>
						<td align="center"><?=$s13?></td>
						<td align="center"><?=$s14?></td>
						<td align="center"><?=$s15?></td>
						<td align="center"><?=$s16?></td>
						<td align="center"><?=$s17?></td>
						<td align="center"><?=$s18?></td>
						<td align="center"><?=$s19?></td>
                        
						<td align="center"><?=$s20?></td>
						<td align="center"><?=$s21?></td>
						<td align="center"><?=$s22?></td>
						<td align="center"><?=$s23?></td>
						<td align="center"><?=$s24?></td>
						<td align="center"><?=$s25?></td>
						<td align="center"><?=$s26?></td>
						<td align="center"><?=$s27?></td>
						<td align="center"><?=$s28?></td>
						<td align="center"><?=$s29?></td>

						<td align="center"><?=$s30?></td>
						<td align="center"><?=$s31?></td>
						<td align="center"><?=$s32?></td>
						<td align="center"><?=$s33?></td>
						<td align="center"><?=$s34?></td>
						<td align="center"><?=$s35?></td>
						<td align="center"><?=$s36?></td>
						<td align="center"><?=$s37?></td>
						<td align="center"><?=$s38?></td>
						<td align="center"><?=$s39?></td>

						<td align="center"><?=$s40?></td>
						<td align="center"><?=$s41?></td>
						<td align="center"><?=$s42?></td>
						<td align="center"><?=$s43?></td>
						<td align="center"><?=$s44?></td>
						<td align="center"><?=$s45?></td>
						<td align="center"><?=$s46?></td>
						<td align="center"><?=$s47?></td>
						<td align="center"><?=$s48?></td>
						<td align="center"><?=$s49?></td>

						<td align="center"><?=$s50?></td>
						<td align="center"><?=$s51?></td>
						<td align="center"><?=$s52?></td>
						<td align="center"><?=$s53?></td>
						<td align="center"><?=$s54?></td>
						<td align="center"><?=$s55?></td>
						<td align="center"><?=$s56?></td>
						<td align="center"><?=$s57?></td>
						<td align="center"><?=$s58?></td>
						<td align="center"><?=$s59?></td>

						</tr>
	<tr class=tb>
		<td nowrap>平均遗漏值</td>
		<td align="center" colspan="5">&nbsp;</td>
						<td align="center"><?=intval($total/$s10)?></td>
						<td align="center"><?=intval($total/$s11)?></td>
						<td align="center"><?=intval($total/$s12)?></td>
						<td align="center"><?=intval($total/$s13)?></td>
						<td align="center"><?=intval($total/$s14)?></td>
						<td align="center"><?=intval($total/$s15)?></td>
						<td align="center"><?=intval($total/$s16)?></td>
						<td align="center"><?=intval($total/$s17)?></td>
						<td align="center"><?=intval($total/$s18)?></td>
						<td align="center"><?=intval($total/$s19)?></td>
                        
						<td align="center"><?=intval($total/$s20)?></td>
						<td align="center"><?=intval($total/$s21)?></td>
						<td align="center"><?=intval($total/$s22)?></td>
						<td align="center"><?=intval($total/$s23)?></td>
						<td align="center"><?=intval($total/$s24)?></td>
						<td align="center"><?=intval($total/$s25)?></td>
						<td align="center"><?=intval($total/$s26)?></td>
						<td align="center"><?=intval($total/$s27)?></td>
						<td align="center"><?=intval($total/$s28)?></td>
						<td align="center"><?=intval($total/$s29)?></td>

						<td align="center"><?=intval($total/$s30)?></td>
						<td align="center"><?=intval($total/$s31)?></td>
						<td align="center"><?=intval($total/$s32)?></td>
						<td align="center"><?=intval($total/$s33)?></td>
						<td align="center"><?=intval($total/$s34)?></td>
						<td align="center"><?=intval($total/$s35)?></td>
						<td align="center"><?=intval($total/$s36)?></td>
						<td align="center"><?=intval($total/$s37)?></td>
						<td align="center"><?=intval($total/$s38)?></td>
						<td align="center"><?=intval($total/$s39)?></td>

						<td align="center"><?=intval($total/$s40)?></td>
						<td align="center"><?=intval($total/$s41)?></td>
						<td align="center"><?=intval($total/$s42)?></td>
						<td align="center"><?=intval($total/$s43)?></td>
						<td align="center"><?=intval($total/$s44)?></td>
						<td align="center"><?=intval($total/$s45)?></td>
						<td align="center"><?=intval($total/$s46)?></td>
						<td align="center"><?=intval($total/$s47)?></td>
						<td align="center"><?=intval($total/$s48)?></td>
						<td align="center"><?=intval($total/$s49)?></td>

						<td align="center"><?=intval($total/$s50)?></td>
						<td align="center"><?=intval($total/$s51)?></td>
						<td align="center"><?=intval($total/$s52)?></td>
						<td align="center"><?=intval($total/$s53)?></td>
						<td align="center"><?=intval($total/$s54)?></td>
						<td align="center"><?=intval($total/$s55)?></td>
						<td align="center"><?=intval($total/$s56)?></td>
						<td align="center"><?=intval($total/$s57)?></td>
						<td align="center"><?=intval($total/$s58)?></td>
						<td align="center"><?=intval($total/$s59)?></td>

						</tr>
	<tr class=tb>
		<td nowrap>最大遗漏值</td>
		<td align="center" colspan="5">&nbsp;</td>
								<td align="center"></td>
						<td align="center">25</td>
						<td align="center">12</td>
						<td align="center">50</td>
						<td align="center">20</td>
						<td align="center">15</td>
						<td align="center">19</td>
						<td align="center">24</td>
						<td align="center">20</td>
						<td align="center">13</td>
											<td align="center">10</td>
						<td align="center">21</td>
						<td align="center">16</td>
						<td align="center">13</td>
						<td align="center">29</td>
						<td align="center">18</td>
						<td align="center">35</td>
						<td align="center">46</td>
						<td align="center">16</td>
						<td align="center">18</td>
											<td align="center">16</td>
						<td align="center">19</td>
						<td align="center">20</td>
						<td align="center">41</td>
						<td align="center">10</td>
						<td align="center">6</td>
						<td align="center">10</td>
						<td align="center">21</td>
						<td align="center">12</td>
						<td align="center">15</td>
											<td align="center">13</td>
						<td align="center">13</td>
						<td align="center">20</td>
						<td align="center">25</td>
						<td align="center">16</td>
						<td align="center">10</td>
						<td align="center">89</td>
						<td align="center">20</td>
						<td align="center">30</td>
						<td align="center">10</td>
											<td align="center">17</td>
						<td align="center">7</td>
						<td align="center">16</td>
						<td align="center">29</td>
						<td align="center">27</td>
						<td align="center">12</td>
						<td align="center">15</td>
						<td align="center">20</td>
						<td align="center">26</td>
						<td align="center">42</td>
						</tr>

	<tr class=tb>
		<td nowrap>最大连出值</td>
		<td align="center" colspan="5">&nbsp;</td>
								<td align="center">2</td>
						<td align="center">1</td>
						<td align="center">1</td>
						<td align="center">2</td>
						<td align="center">2</td>
						<td align="center">1</td>
						<td align="center">1</td>
						<td align="center">1</td>
						<td align="center">1</td>
						<td align="center">2</td>
											<td align="center">1</td>
						<td align="center">1</td>
						<td align="center">3</td>
						<td align="center">1</td>
						<td align="center">2</td>
						<td align="center">1</td>
						<td align="center">2</td>
						<td align="center">0</td>
						<td align="center">1</td>
						<td align="center">1</td>
											<td align="center">1</td>
						<td align="center">1</td>
						<td align="center">1</td>
						<td align="center">1</td>
						<td align="center">1</td>
						<td align="center">1</td>
						<td align="center">1</td>
						<td align="center">1</td>
						<td align="center">1</td>
						<td align="center">1</td>
											<td align="center">1</td>
						<td align="center">1</td>
						<td align="center">1</td>
						<td align="center">2</td>
						<td align="center">1</td>
						<td align="center">2</td>
						<td align="center">0</td>
						<td align="center">1</td>
						<td align="center">1</td>
						<td align="center">1</td>
											<td align="center">2</td>
						<td align="center">1</td>
						<td align="center">1</td>
						<td align="center">1</td>
						<td align="center">1</td>
						<td align="center">1</td>
						<td align="center">1</td>
						<td align="center">2</td>
						<td align="center">1</td>
						<td align="center">1</td>
						</tr>

	<tr class=th>
		<td rowspan="2" >期号</td>
		<td rowspan="2" colspan="5">开奖号码</td>
									<td>0</td>
							<td>1</td>
							<td>2</td>
							<td>3</td>
							<td>4</td>
							<td>5</td>
							<td>6</td>
							<td>7</td>
							<td>8</td>
							<td>9</td>
												<td>0</td>
							<td>1</td>
							<td>2</td>
							<td>3</td>
							<td>4</td>
							<td>5</td>
							<td>6</td>
							<td>7</td>
							<td>8</td>
							<td>9</td>
												<td>0</td>
							<td>1</td>
							<td>2</td>
							<td>3</td>
							<td>4</td>
							<td>5</td>
							<td>6</td>
							<td>7</td>
							<td>8</td>
							<td>9</td>
												<td>0</td>
							<td>1</td>
							<td>2</td>
							<td>3</td>
							<td>4</td>
							<td>5</td>
							<td>6</td>
							<td>7</td>
							<td>8</td>
							<td>9</td>
												<td>0</td>
							<td>1</td>
							<td>2</td>
							<td>3</td>
							<td>4</td>
							<td>5</td>
							<td>6</td>
							<td>7</td>
							<td>8</td>
							<td>9</td>
						</tr>
	<tr class=th>
		 		 <td colspan="10">万位</td>
		 		 <td colspan="10">千位</td>
		 		 <td colspan="10">百位</td>
		 		 <td colspan="10">十位</td>
		 		 <td colspan="10">个位</td>
		                      
	</tr>
</table>
</div>
<br/>

</CENTER>
