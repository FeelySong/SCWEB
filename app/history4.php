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
<DIV ID='main_box_s2'><DIV class='icons_mb2'></DIV>当前位置: <A href="/" target='_top'>嘟嘟游戏</a> - 前二直选走势 </DIV>
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
		<td rowspan="2">期号</td>
		<td rowspan="2" colspan="2">开奖号码</td>
		<td colspan="11">第一位</td>
		<td colspan="11">第二位</td>
		<td colspan="3">大小比</td>
		<td colspan="3">奇偶比</td>
	</tr>
	<tr class='th'>
		<td class="wdh">01</td>
		<td class="wdh">02</td>
		<td class="wdh">03</td>
		<td class="wdh">04</td>
		<td class="wdh">05</td>
		<td class="wdh">06</td>
		<td class="wdh">07</td>
		<td class="wdh">08</td>
		<td class="wdh">09</td>
		<td class="wdh">10</td>
		<td class="wdh">11</td>
		<td class="wdh">01</td>
		<td class="wdh">02</td>
		<td class="wdh">03</td>
		<td class="wdh">04</td>
		<td class="wdh">05</td>
		<td class="wdh">06</td>
		<td class="wdh">07</td>
		<td class="wdh">08</td>
		<td class="wdh">09</td>
		<td class="wdh">10</td>
		<td class="wdh">11</td>

		<td class="wdh">2:0</td>
		<td class="wdh">1:1</td>
		<td class="wdh">0:2</td>
        
		<td class="wdh">2:0</td>
		<td class="wdh">1:1</td>
		<td class="wdh">0:2</td>
	</tr>
<?php
	for($i=0;$i<42;$i++){
		$s[$i]=0;	
		$a[$i]=0;	
		$b[$i]=0;	
		$c[$i]=0;	
		$d[$i]=0;
	}
	while ($row = mysql_fetch_array($rs)){
		$na=0;
		$nb=0;
		$n1=$row['n1'];
		$n2=$row['n2'];
		$n3=$row['n3'];
		$n4=$row['n4'];
		$n5=$row['n5'];
		if($n1>5){$na=$na+1;}
		if($n2>5){$na=$na+1;}

		if($n1%2){$nb=$nb+1;}
		if($n2%2){$nb=$nb+1;}
		
		$nt=$n1+$n2+$n3+$n4+$n5;
		$nw=$nt%10;
		
		for($i=0;$i<42;$i++){
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
                                
		<td class="wdh td0" align="center"><?php if($n1==1){echo "<div class='ball01'>1</div>";$a[1]=0;$s[1]=$s[1]+1;}else{echo "<div class='ball13'>".$a[1]."</div>";$c[1]=0;}?></td>
		<td class="wdh td0" align="center"><?php if($n1==2){echo "<div class='ball01'>2</div>";$a[2]=0;$s[2]=$s[2]+1;}else{echo "<div class='ball13'>".$a[2]."</div>";$c[2]=0;}?></td>
		<td class="wdh td0" align="center"><?php if($n1==3){echo "<div class='ball01'>3</div>";$a[3]=0;$s[3]=$s[3]+1;}else{echo "<div class='ball13'>".$a[3]."</div>";$c[3]=0;}?></td>
		<td class="wdh td0" align="center"><?php if($n1==4){echo "<div class='ball01'>4</div>";$a[4]=0;$s[4]=$s[4]+1;}else{echo "<div class='ball13'>".$a[4]."</div>";$c[4]=0;}?></td>
		<td class="wdh td0" align="center"><?php if($n1==5){echo "<div class='ball01'>5</div>";$a[5]=0;$s[5]=$s[5]+1;}else{echo "<div class='ball13'>".$a[5]."</div>";$c[5]=0;}?></td>
		<td class="wdh td0" align="center"><?php if($n1==6){echo "<div class='ball01'>6</div>";$a[6]=0;$s[6]=$s[6]+1;}else{echo "<div class='ball13'>".$a[6]."</div>";$c[6]=0;}?></td>
		<td class="wdh td0" align="center"><?php if($n1==7){echo "<div class='ball01'>7</div>";$a[7]=0;$s[7]=$s[7]+1;}else{echo "<div class='ball13'>".$a[7]."</div>";$c[7]=0;}?></td>
		<td class="wdh td0" align="center"><?php if($n1==8){echo "<div class='ball01'>8</div>";$a[8]=0;$s[8]=$s[8]+1;}else{echo "<div class='ball13'>".$a[8]."</div>";$c[8]=0;}?></td>
		<td class="wdh td0" align="center"><?php if($n1==9){echo "<div class='ball01'>9</div>";$a[9]=0;$s[9]=$s[9]+1;}else{echo "<div class='ball13'>".$a[9]."</div>";$c[9]=0;}?></td>
		<td class="wdh td0" align="center"><?php if($n1==10){echo "<div class='ball01'>10</div>";$a[10]=0;$s[10]=$s[10]+1;}else{echo "<div class='ball13'>".$a[10]."</div>";$c[10]=0;}?></td>
		<td class="wdh td0" align="center"><?php if($n1==11){echo "<div class='ball01'>11</div>";$a[11]=0;$s[11]=$s[11]+1;}else{echo "<div class='ball13'>".$a[11]."</div>";$c[11]=0;}?></td>
		<td class="wdh td1" align="center"><?php if($n2==1){echo "<div class='ball02'>1</div>";$a[12]=0;$s[12]=$s[12]+1;}else{echo "<div class='ball14'>".$a[12]."</div>";$c[12]=0;}?></td>
		<td class="wdh td1" align="center"><?php if($n2==2){echo "<div class='ball02'>2</div>";$a[13]=0;$s[13]=$s[13]+1;}else{echo "<div class='ball14'>".$a[13]."</div>";$c[13]=0;}?></td>
		<td class="wdh td1" align="center"><?php if($n2==3){echo "<div class='ball02'>3</div>";$a[14]=0;$s[14]=$s[14]+1;}else{echo "<div class='ball14'>".$a[14]."</div>";$c[14]=0;}?></td>
		<td class="wdh td1" align="center"><?php if($n2==4){echo "<div class='ball02'>4</div>";$a[15]=0;$s[15]=$s[15]+1;}else{echo "<div class='ball14'>".$a[15]."</div>";$c[15]=0;}?></td>
		<td class="wdh td1" align="center"><?php if($n2==5){echo "<div class='ball02'>5</div>";$a[16]=0;$s[16]=$s[16]+1;}else{echo "<div class='ball14'>".$a[16]."</div>";$c[16]=0;}?></td>
		<td class="wdh td1" align="center"><?php if($n2==6){echo "<div class='ball02'>6</div>";$a[17]=0;$s[17]=$s[17]+1;}else{echo "<div class='ball14'>".$a[17]."</div>";$c[17]=0;}?></td>
		<td class="wdh td1" align="center"><?php if($n2==7){echo "<div class='ball02'>7</div>";$a[18]=0;$s[18]=$s[18]+1;}else{echo "<div class='ball14'>".$a[18]."</div>";$c[18]=0;}?></td>
		<td class="wdh td1" align="center"><?php if($n2==8){echo "<div class='ball02'>8</div>";$a[19]=0;$s[19]=$s[19]+1;}else{echo "<div class='ball14'>".$a[19]."</div>";$c[19]=0;}?></td>
		<td class="wdh td1" align="center"><?php if($n2==9){echo "<div class='ball02'>9</div>";$a[20]=0;$s[20]=$s[20]+1;}else{echo "<div class='ball14'>".$a[20]."</div>";$c[20]=0;}?></td>
		<td class="wdh td1" align="center"><?php if($n2==10){echo "<div class='ball02'>10</div>";$a[21]=0;$s[21]=$s[21]+1;}else{echo "<div class='ball14'>".$a[21]."</div>";$c[21]=0;}?></td>
		<td class="wdh td1" align="center"><?php if($n2==11){echo "<div class='ball02'>11</div>";$a[22]=0;$s[22]=$s[22]+1;}else{echo "<div class='ball14'>".$a[22]."</div>";$c[22]=0;}?></td>
        
		<td class="wdh td0" align="center"><?php if($na==2){echo "<div class='ball03'>2:0</div>";$a[23]=0;$s[23]=$s[23]+1;}else{echo "<div class='ball13'>".$a[23]."</div>";$c[23]=0;}?></td>
		<td class="wdh td0" align="center"><?php if($na==1){echo "<div class='ball03'>1:1</div>";$a[24]=0;$s[24]=$s[24]+1;}else{echo "<div class='ball13'>".$a[24]."</div>";$c[24]=0;}?></td>
		<td class="wdh td0" align="center"><?php if($na==0){echo "<div class='ball03'>0:2</div>";$a[25]=0;$s[25]=$s[25]+1;}else{echo "<div class='ball13'>".$a[25]."</div>";$c[25]=0;}?></td>
		<td class="wdh td0" align="center"><?php if($nb==2){echo "<div class='ball04'>2:0</div>";$a[26]=0;$s[26]=$s[26]+1;}else{echo "<div class='ball14'>".$a[26]."</div>";$c[26]=0;}?></td>
		<td class="wdh td0" align="center"><?php if($nb==1){echo "<div class='ball04'>1:1</div>";$a[27]=0;$s[27]=$s[27]+1;}else{echo "<div class='ball14'>".$a[27]."</div>";$c[27]=0;}?></td>
		<td class="wdh td0" align="center"><?php if($nb==0){echo "<div class='ball04'>0:2</div>";$a[28]=0;$s[28]=$s[28]+1;}else{echo "<div class='ball14'>".$a[28]."</div>";$c[28]=0;}?></td>

	</tr>
 <?php }?>                                                       
	<tr class=tb>
		<td nowrap>出现总次数</td>
		<td align="center" colspan="2">&nbsp;</td>
<?php for($i=1;$i<29;$i++){?>
		<td align="center"><?=$s[$i]?></td>
<?php }?>
	</tr>
	<tr class=tb>
		<td nowrap>当前遗漏值</td>
		<td align="center" colspan="2">&nbsp;</td>
<?php for($i=1;$i<29;$i++){?>
		<td align="center"><?=$a[$i]?></td>
<?php }?>
	</tr>
	<tr class=tb>
		<td nowrap>平均遗漏值</td>
		<td align="center" colspan="2">&nbsp;</td>
<?php for($i=1;$i<29;$i++){
	if($s[$i]==0){$av=$total;}
	else{$av=intval($total/$s[$i]);}
?>
		<td align="center"><?=$av?></td>
<?php }?>
	</tr>
	<tr class=tb>
		<td nowrap>最大遗漏值</td>
		<td align="center" colspan="2">&nbsp;</td>
<?php for($i=1;$i<29;$i++){
	if($b[$i]-1<$a[$i]){$bv=$a[$i];}
	else{$bv=$b[$i]-1;}
?>
		<td align="center"><?=$bv?></td>
<?php }?>
	</tr>
	<tr class=tb>
		<td nowrap>最大连出值</td>
		<td align="center" colspan="2">&nbsp;</td>
<?php for($i=1;$i<29;$i++){
	if($d[$i]-1<$c[$i]){$dv=$c[$i];}
	else{$dv=$d[$i]-1;}
?>
		<td align="center"><?=$dv?></td>
<?php }?>
	</tr>
	<tr class=th>
		<td rowspan="2" >期号</td>
		<td rowspan="2" colspan="2">开奖号码</td>
		<td class="wdh">01</td>
		<td class="wdh">02</td>
		<td class="wdh">03</td>
		<td class="wdh">04</td>
		<td class="wdh">05</td>
		<td class="wdh">06</td>
		<td class="wdh">07</td>
		<td class="wdh">08</td>
		<td class="wdh">09</td>
		<td class="wdh">10</td>
		<td class="wdh">11</td>
		<td class="wdh">01</td>
		<td class="wdh">02</td>
		<td class="wdh">03</td>
		<td class="wdh">04</td>
		<td class="wdh">05</td>
		<td class="wdh">06</td>
		<td class="wdh">07</td>
		<td class="wdh">08</td>
		<td class="wdh">09</td>
		<td class="wdh">10</td>
		<td class="wdh">11</td>

		<td class="wdh">2:0</td>
		<td class="wdh">1:1</td>
		<td class="wdh">0:2</td>
        
		<td class="wdh">2:0</td>
		<td class="wdh">1:1</td>
		<td class="wdh">0:2</td>
	</tr>
	<tr class=th>
		<td colspan="11">第一位</td>
		<td colspan="11">第二位</td>
		<td colspan="3">大小比</td>
		<td colspan="3">奇偶比</td>
	</tr>
</table>
</div>
<br/>

</CENTER>
