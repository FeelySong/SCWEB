<?php 
session_start();
error_reporting(0);
require_once 'conn.php';

$id=6;
	$sql="select * from ssc_data where cid='".$id."' order by issue asc";
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

<div class='div_s1' id="container">

<table id="chartsTable" width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor='#D0D0D0'>
	<tr class="th">
		 <td rowspan="2">期号</td>
		 <td rowspan="2" colspan="5">开奖号码</td>
		 		 <td colspan="11">开奖号码分布图</td>
		 	</tr>
			<tr class='th'>
							<td class="wdh">1</td>
							<td class="wdh">2</td>
							<td class="wdh">3</td>
							<td class="wdh">4</td>
							<td class="wdh">5</td>
							<td class="wdh">6</td>
							<td class="wdh">7</td>
							<td class="wdh">8</td>
							<td class="wdh">9</td>
							<td class="wdh">10</td>
							<td class="wdh">11</td>
						</tr>
<?php
			$s1=0;
			$s2=0;
			$s3=0;
			$s4=0;
			$s5=0;
			$s6=0;
			$s7=0;
			$s8=0;
			$s9=0;
			$s10=0;
			$s11=0;

			$a1=0;
			$a2=0;
			$a3=0;
			$a4=0;
			$a5=0;
			$a6=0;
			$a7=0;
			$a8=0;
			$a9=0;
			$a10=0;
			$a11=0;

			$b1=0;
			$b2=0;
			$b3=0;
			$b4=0;
			$b5=0;
			$b6=0;
			$b7=0;
			$b8=0;
			$b9=0;
			$b10=0;
			$b11=0;

			$c1=0;
			$c2=0;
			$c3=0;
			$c4=0;
			$c5=0;
			$c6=0;
			$c7=0;
			$c8=0;
			$c9=0;
			$c10=0;
			$c11=0;

			$d1=0;
			$d2=0;
			$d3=0;
			$d4=0;
			$d5=0;
			$d6=0;
			$d7=0;
			$d8=0;
			$d9=0;
			$d10=0;
			$d11=0;

			while ($row = mysql_fetch_array($rs)){
			$n1=$row['n1'];
			$n2=$row['n2'];
			$n3=$row['n3'];
			$n4=$row['n4'];
			$n5=$row['n5'];
			
			$a1=$a1+1;
			$a2=$a2+1;
			$a3=$a3+1;
			$a4=$a4+1;
			$a5=$a5+1;
			$a6=$a6+1;
			$a7=$a7+1;
			$a8=$a8+1;
			$a9=$a9+1;
			$a10=$a10+1;
			$a11=$a11+1;

			$c1=$c1+1;
			$c2=$c2+1;
			$c3=$c3+1;
			$c4=$c4+1;
			$c5=$c5+1;
			$c6=$c6+1;
			$c7=$c7+1;
			$c8=$c8+1;
			$c9=$c9+1;
			$c10=$c10+1;
			$c11=$c11+1;
?>			
            <tr>
			<td class='issue'><?=$row['issue']?></td>
						<td class="wth" align="center"><?=$row['n1']?></td>
						<td class="wth" align="center"><?=$row['n2']?></td>
						<td class="wth" align="center"><?=$row['n3']?></td>
						<td class="wth" align="center"><?=$row['n4']?></td>
						<td class="wth" align="center"><?=$row['n5']?></td>
                        
						<td class="wdh td0" align="center"><?php if($n1==1 || $n2==1 || $n3==1 || $n4==1 || $n5==1){echo "<div class='ball01'>1</div>";if($b1<$a1){$b1=$a1;};$a1=0;$s1=$s1+1;}else{echo "<div class='ball13'>".$a1."</div>";if($d1<$c1){$d1=$c1;};$c1=0;}?></td>
						<td class="wdh td0" align="center"><?php if($n1==2 || $n2==2 || $n3==2 || $n4==2 || $n5==2){echo "<div class='ball01'>2</div>";if($b2<$a2){$b2=$a2;};$a2=0;$s2=$s2+1;}else{echo "<div class='ball13'>".$a2."</div>";if($d2<$c2){$d2=$c2;};$c2=0;}?></td>
						<td class="wdh td0" align="center"><?php if($n1==3 || $n2==3 || $n3==3 || $n4==3 || $n5==3){echo "<div class='ball01'>3</div>";if($b3<$a3){$b3=$a3;};$a3=0;$s3=$s3+1;}else{echo "<div class='ball13'>".$a3."</div>";if($d3<$c3){$d3=$c3;};$c3=0;}?></td>
						<td class="wdh td0" align="center"><?php if($n1==4 || $n2==4 || $n3==4 || $n4==4 || $n5==4){echo "<div class='ball01'>4</div>";if($b4<$a4){$b4=$a4;};$a4=0;$s4=$s4+1;}else{echo "<div class='ball13'>".$a4."</div>";if($d4<$c4){$d4=$c4;};$c4=0;}?></td>
						<td class="wdh td0" align="center"><?php if($n1==5 || $n2==5 || $n3==5 || $n4==5 || $n5==5){echo "<div class='ball01'>5</div>";if($b5<$a5){$b5=$a5;};$a5=0;$s5=$s5+1;}else{echo "<div class='ball13'>".$a5."</div>";if($d5<$c5){$d5=$c5;};$c5=0;}?></td>
						<td class="wdh td0" align="center"><?php if($n1==6 || $n2==6 || $n3==6 || $n4==6 || $n5==6){echo "<div class='ball01'>6</div>";if($b6<$a6){$b6=$a6;};$a6=0;$s6=$s6+1;}else{echo "<div class='ball13'>".$a6."</div>";if($d6<$c6){$d6=$c6;};$c6=0;}?></td>
						<td class="wdh td0" align="center"><?php if($n1==7 || $n2==7 || $n3==7 || $n4==7 || $n5==7){echo "<div class='ball01'>7</div>";if($b7<$a7){$b7=$a7;};$a7=0;$s7=$s7+1;}else{echo "<div class='ball13'>".$a7."</div>";if($d7<$c7){$d7=$c7;};$c7=0;}?></td>
						<td class="wdh td0" align="center"><?php if($n1==8 || $n2==8 || $n3==8 || $n4==8 || $n5==8){echo "<div class='ball01'>8</div>";if($b8<$a8){$b8=$a8;};$a8=0;$s8=$s8+1;}else{echo "<div class='ball13'>".$a8."</div>";if($d8<$c8){$d8=$c8;};$c8=0;}?></td>
						<td class="wdh td0" align="center"><?php if($n1==9 || $n2==9 || $n3==9 || $n4==9 || $n5==9){echo "<div class='ball01'>9</div>";if($b9<$a9){$b9=$a9;};$a9=0;$s9=$s9+1;}else{echo "<div class='ball13'>".$a9."</div>";if($d9<$c9){$d9=$c9;};$c9=0;}?></td>
						<td class="wdh td0" align="center"><?php if($n1==10 || $n2==10 || $n3==10 || $n4==10 || $n5==10){echo "<div class='ball01'>10</div>";if($b10<$a10){$b10=$a10;};$a10=0;$s10=$s10+1;}else{echo "<div class='ball13'>".$a10."</div>";if($d10<$c10){$d10=$c10;};$c10=0;}?></td>
						<td class="wdh td0" align="center"><?php if($n1==11 || $n2==11 || $n3==11 || $n4==11 || $n5==11){echo "<div class='ball01'>11</div>";if($b11<$a11){$b11=$a11;};$a11=0;$s11=$s11+1;}else{echo "<div class='ball13'>".$a11."</div>";if($d11<$c11){$d11=$c11;};$c11=0;}?></td>
					</tr>
 <?php }?>                                                       
	<tr class=tb>
		<td nowrap>出现总次数</td>
		<td align="center" colspan="5">&nbsp;</td>
						<td align="center"><?=$s1?></td>
						<td align="center"><?=$s2?></td>
						<td align="center"><?=$s3?></td>
						<td align="center"><?=$s4?></td>
						<td align="center"><?=$s5?></td>
						<td align="center"><?=$s6?></td>
						<td align="center"><?=$s7?></td>
						<td align="center"><?=$s8?></td>
						<td align="center"><?=$s9?></td>
						<td align="center"><?=$s10?></td>
						<td align="center"><?=$s11?></td>
						</tr>
	<tr class=tb>
		<td nowrap>当前遗漏值</td>
		<td align="center" colspan="5">&nbsp;</td>
						<td align="center"><?=$a1?></td>
						<td align="center"><?=$a2?></td>
						<td align="center"><?=$a3?></td>
						<td align="center"><?=$a4?></td>
						<td align="center"><?=$a5?></td>
						<td align="center"><?=$a6?></td>
						<td align="center"><?=$a7?></td>
						<td align="center"><?=$a8?></td>
						<td align="center"><?=$a9?></td>
						<td align="center"><?=$a10?></td>
						<td align="center"><?=$a11?></td>
						</tr>
	<tr class=tb>
		<td nowrap>平均遗漏值</td>
		<td align="center" colspan="5">&nbsp;</td>
						<td align="center"><?=intval($total/$s1)?></td>
						<td align="center"><?=intval($total/$s2)?></td>
						<td align="center"><?=intval($total/$s3)?></td>
						<td align="center"><?=intval($total/$s4)?></td>
						<td align="center"><?=intval($total/$s5)?></td>
						<td align="center"><?=intval($total/$s6)?></td>
						<td align="center"><?=intval($total/$s7)?></td>
						<td align="center"><?=intval($total/$s8)?></td>
						<td align="center"><?=intval($total/$s9)?></td>
						<td align="center"><?=intval($total/$s10)?></td>
						<td align="center"><?=intval($total/$s11)?></td>
						</tr>
	<tr class=tb>
		<td nowrap>最大遗漏值</td>
		<td align="center" colspan="5">&nbsp;</td>
						<td align="center"><?=$b1-1?></td>
						<td align="center"><?=$b2-1?></td>
						<td align="center"><?=$b3-1?></td>
						<td align="center"><?=$b4-1?></td>
						<td align="center"><?=$b5-1?></td>
						<td align="center"><?=$b6-1?></td>
						<td align="center"><?=$b7-1?></td>
						<td align="center"><?=$b8-1?></td>
						<td align="center"><?=$b9-1?></td>
						<td align="center"><?=$b10-1?></td>
						<td align="center"><?=$b11-1?></td>
						</tr>
	<tr class=tb>
		<td nowrap>最大连出值</td>
		<td align="center" colspan="5">&nbsp;</td>
						<td align="center"><?=$d1-1?></td>
						<td align="center"><?=$d2-1?></td>
						<td align="center"><?=$d3-1?></td>
						<td align="center"><?=$d4-1?></td>
						<td align="center"><?=$d5-1?></td>
						<td align="center"><?=$d6-1?></td>
						<td align="center"><?=$d7-1?></td>
						<td align="center"><?=$d8-1?></td>
						<td align="center"><?=$d9-1?></td>
						<td align="center"><?=$d10-1?></td>
						<td align="center"><?=$d11-1?></td>
						</tr>

	<tr class=th>
		<td rowspan="2" >期号</td>
		<td rowspan="2" colspan="5">开奖号码</td>
							<td>1</td>
							<td>2</td>
							<td>3</td>
							<td>4</td>
							<td>5</td>
							<td>6</td>
							<td>7</td>
							<td>8</td>
							<td>9</td>
							<td>10</td>
							<td>11</td>
						</tr>
	<tr class=th>
		 		 <td colspan="11">开奖号码分布图</td>
	</tr>
</table>
</div>
<br/>

</CENTER>
