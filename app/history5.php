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
<DIV ID='main_box_s2'><DIV class='icons_mb2'></DIV>当前位置: <A href="/" target='_top'>嘟嘟游戏</a> - 前二和值走势 </DIV>
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
		<td colspan="19">和值</td>
		<td colspan="10">和尾</td>
		<td colspan="2">大小</td>
		<td colspan="2">奇偶</td>
		<td colspan="2">质合</td>
		<td colspan="3">除3余数</td>
	</tr>
	<tr class='th'>
		<td class="wdh">3</td>
		<td class="wdh">4</td>
		<td class="wdh">5</td>
		<td class="wdh">6</td>
		<td class="wdh">7</td>
		<td class="wdh">8</td>
		<td class="wdh">9</td>
		<td class="wdh">10</td>
		<td class="wdh">11</td>
		<td class="wdh">12</td>
		<td class="wdh">13</td>
		<td class="wdh">14</td>
		<td class="wdh">15</td>
		<td class="wdh">16</td>
		<td class="wdh">17</td>
		<td class="wdh">18</td>
		<td class="wdh">19</td>
		<td class="wdh">20</td>
		<td class="wdh">21</td>
        
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

		<td class="wdh">大</td>
		<td class="wdh">小</td>
		<td class="wdh">奇</td>
		<td class="wdh">偶</td>
		<td class="wdh">质</td>
		<td class="wdh">合</td>

		<td class="wdh">0</td>
		<td class="wdh">1</td>
		<td class="wdh">2</td>
	</tr>
<?php
	for($i=0;$i<39;$i++){
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

		$nt=$n1+$n2;
		$nw=$nt%10;
		$ny=$nt%3;
		if($nt>10){$nd=0;}
		else{$nd=1;}
		
		if($nt%2){$nj=0;}
		else{$nj=1;}
		
		$nz=0;
		for($i=2;$i<sqrt($nt);$i++){
			if($nt%$i==0){
				$nz=1;
				break;
			}
		}
		
		for($i=0;$i<39;$i++){
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

		<td class="wdh td0" align="center"><?php if($nt==3){echo "<div class='ball01'>3</div>";$a[1]=0;$s[1]=$s[1]+1;}else{echo "<div class='ball13'>".$a[1]."</div>";$c[1]=0;}?></td>
		<td class="wdh td0" align="center"><?php if($nt==4){echo "<div class='ball01'>4</div>";$a[2]=0;$s[2]=$s[2]+1;}else{echo "<div class='ball13'>".$a[2]."</div>";$c[2]=0;}?></td>
		<td class="wdh td0" align="center"><?php if($nt==5){echo "<div class='ball01'>5</div>";$a[3]=0;$s[3]=$s[3]+1;}else{echo "<div class='ball13'>".$a[3]."</div>";$c[3]=0;}?></td>
		<td class="wdh td0" align="center"><?php if($nt==6){echo "<div class='ball01'>6</div>";$a[4]=0;$s[4]=$s[4]+1;}else{echo "<div class='ball13'>".$a[4]."</div>";$c[4]=0;}?></td>
		<td class="wdh td0" align="center"><?php if($nt==7){echo "<div class='ball01'>7</div>";$a[5]=0;$s[5]=$s[5]+1;}else{echo "<div class='ball13'>".$a[5]."</div>";$c[5]=0;}?></td>
		<td class="wdh td0" align="center"><?php if($nt==8){echo "<div class='ball01'>8</div>";$a[6]=0;$s[6]=$s[6]+1;}else{echo "<div class='ball13'>".$a[6]."</div>";$c[6]=0;}?></td>
		<td class="wdh td0" align="center"><?php if($nt==9){echo "<div class='ball01'>9</div>";$a[7]=0;$s[7]=$s[7]+1;}else{echo "<div class='ball13'>".$a[7]."</div>";$c[7]=0;}?></td>
		<td class="wdh td0" align="center"><?php if($nt==10){echo "<div class='ball01'>10</div>";$a[8]=0;$s[8]=$s[8]+1;}else{echo "<div class='ball13'>".$a[8]."</div>";$c[8]=0;}?></td>
		<td class="wdh td0" align="center"><?php if($nt==11){echo "<div class='ball01'>11</div>";$a[9]=0;$s[9]=$s[9]+1;}else{echo "<div class='ball13'>".$a[9]."</div>";$c[9]=0;}?></td>
		<td class="wdh td0" align="center"><?php if($nt==12){echo "<div class='ball01'>12</div>";$a[10]=0;$s[10]=$s[10]+1;}else{echo "<div class='ball13'>".$a[10]."</div>";$c[10]=0;}?></td>
		<td class="wdh td0" align="center"><?php if($nt==13){echo "<div class='ball01'>13</div>";$a[11]=0;$s[11]=$s[11]+1;}else{echo "<div class='ball13'>".$a[11]."</div>";$c[11]=0;}?></td>
		<td class="wdh td0" align="center"><?php if($nt==14){echo "<div class='ball01'>14</div>";$a[12]=0;$s[12]=$s[12]+1;}else{echo "<div class='ball13'>".$a[12]."</div>";$c[12]=0;}?></td>
		<td class="wdh td0" align="center"><?php if($nt==15){echo "<div class='ball01'>15</div>";$a[13]=0;$s[13]=$s[13]+1;}else{echo "<div class='ball13'>".$a[13]."</div>";$c[13]=0;}?></td>
		<td class="wdh td0" align="center"><?php if($nt==16){echo "<div class='ball01'>16</div>";$a[14]=0;$s[14]=$s[14]+1;}else{echo "<div class='ball13'>".$a[14]."</div>";$c[14]=0;}?></td>
		<td class="wdh td0" align="center"><?php if($nt==17){echo "<div class='ball01'>17</div>";$a[15]=0;$s[15]=$s[15]+1;}else{echo "<div class='ball13'>".$a[15]."</div>";$c[15]=0;}?></td>
		<td class="wdh td0" align="center"><?php if($nt==18){echo "<div class='ball01'>18</div>";$a[16]=0;$s[16]=$s[16]+1;}else{echo "<div class='ball13'>".$a[16]."</div>";$c[16]=0;}?></td>
		<td class="wdh td0" align="center"><?php if($nt==19){echo "<div class='ball01'>19</div>";$a[17]=0;$s[17]=$s[17]+1;}else{echo "<div class='ball13'>".$a[17]."</div>";$c[17]=0;}?></td>
		<td class="wdh td0" align="center"><?php if($nt==20){echo "<div class='ball01'>20</div>";$a[18]=0;$s[18]=$s[18]+1;}else{echo "<div class='ball13'>".$a[18]."</div>";$c[18]=0;}?></td>
		<td class="wdh td0" align="center"><?php if($nt==21){echo "<div class='ball01'>21</div>";$a[19]=0;$s[19]=$s[19]+1;}else{echo "<div class='ball13'>".$a[19]."</div>";$c[19]=0;}?></td>

		<td class="wdh td1" align="center"><?php if($nw==0){echo "<div class='ball02'>0</div>";$a[20]=0;$s[20]=$s[20]+1;}else{echo "<div class='ball14'>".$a[20]."</div>";$c[20]=0;}?></td>
		<td class="wdh td1" align="center"><?php if($nw==1){echo "<div class='ball02'>1</div>";$a[21]=0;$s[21]=$s[21]+1;}else{echo "<div class='ball14'>".$a[21]."</div>";$c[21]=0;}?></td>
		<td class="wdh td1" align="center"><?php if($nw==2){echo "<div class='ball02'>2</div>";$a[22]=0;$s[22]=$s[22]+1;}else{echo "<div class='ball14'>".$a[22]."</div>";$c[22]=0;}?></td>
		<td class="wdh td1" align="center"><?php if($nw==3){echo "<div class='ball02'>3</div>";$a[23]=0;$s[23]=$s[23]+1;}else{echo "<div class='ball14'>".$a[23]."</div>";$c[23]=0;}?></td>
		<td class="wdh td1" align="center"><?php if($nw==4){echo "<div class='ball02'>4</div>";$a[24]=0;$s[24]=$s[24]+1;}else{echo "<div class='ball14'>".$a[24]."</div>";$c[24]=0;}?></td>
		<td class="wdh td1" align="center"><?php if($nw==5){echo "<div class='ball02'>5</div>";$a[25]=0;$s[25]=$s[25]+1;}else{echo "<div class='ball14'>".$a[25]."</div>";$c[25]=0;}?></td>
		<td class="wdh td1" align="center"><?php if($nw==6){echo "<div class='ball02'>6</div>";$a[26]=0;$s[26]=$s[26]+1;}else{echo "<div class='ball14'>".$a[26]."</div>";$c[26]=0;}?></td>
		<td class="wdh td1" align="center"><?php if($nw==7){echo "<div class='ball02'>7</div>";$a[27]=0;$s[27]=$s[27]+1;}else{echo "<div class='ball14'>".$a[27]."</div>";$c[27]=0;}?></td>
		<td class="wdh td1" align="center"><?php if($nw==8){echo "<div class='ball02'>8</div>";$a[28]=0;$s[28]=$s[28]+1;}else{echo "<div class='ball14'>".$a[28]."</div>";$c[28]=0;}?></td>
		<td class="wdh td1" align="center"><?php if($nw==9){echo "<div class='ball02'>9</div>";$a[29]=0;$s[29]=$s[29]+1;}else{echo "<div class='ball14'>".$a[29]."</div>";$c[29]=0;}?></td>
        
		<td class="wdh td0" align="center"><?php if($nd==0){echo "<div class='ball03'>大</div>";$a[30]=0;$s[30]=$s[30]+1;}else{echo "<div class='ball13'>".$a[30]."</div>";$c[30]=0;}?></td>
		<td class="wdh td0" align="center"><?php if($nd==1){echo "<div class='ball03'>小</div>";$a[31]=0;$s[31]=$s[31]+1;}else{echo "<div class='ball13'>".$a[31]."</div>";$c[31]=0;}?></td>

		<td class="wdh td1" align="center"><?php if($nj==0){echo "<div class='ball04'>奇</div>";$a[32]=0;$s[32]=$s[32]+1;}else{echo "<div class='ball14'>".$a[32]."</div>";$c[32]=0;}?></td>
		<td class="wdh td1" align="center"><?php if($nj==1){echo "<div class='ball04'>偶</div>";$a[33]=0;$s[33]=$s[33]+1;}else{echo "<div class='ball14'>".$a[33]."</div>";$c[33]=0;}?></td>

		<td class="wdh td0" align="center"><?php if($nz==0){echo "<div class='ball03'>质</div>";$a[34]=0;$s[34]=$s[34]+1;}else{echo "<div class='ball13'>".$a[34]."</div>";$c[34]=0;}?></td>
		<td class="wdh td0" align="center"><?php if($nz==1){echo "<div class='ball03'>合</div>";$a[35]=0;$s[35]=$s[35]+1;}else{echo "<div class='ball13'>".$a[35]."</div>";$c[35]=0;}?></td>

		<td class="wdh td1" align="center"><?php if($ny==0){echo "<div class='ball02'>0</div>";$a[36]=0;$s[36]=$s[36]+1;}else{echo "<div class='ball14'>".$a[36]."</div>";$c[36]=0;}?></td>
		<td class="wdh td1" align="center"><?php if($ny==1){echo "<div class='ball02'>1</div>";$a[37]=0;$s[37]=$s[37]+1;}else{echo "<div class='ball14'>".$a[37]."</div>";$c[37]=0;}?></td>
		<td class="wdh td1" align="center"><?php if($ny==2){echo "<div class='ball02'>2</div>";$a[38]=0;$s[38]=$s[38]+1;}else{echo "<div class='ball14'>".$a[38]."</div>";$c[38]=0;}?></td>

	</tr>
 <?php }?>                                                       
	<tr class=tb>
		<td nowrap>出现总次数</td>
		<td align="center" colspan="2">&nbsp;</td>
<?php for($i=1;$i<39;$i++){?>
		<td align="center"><?=$s[$i]?></td>
<?php }?>
	</tr>
	<tr class=tb>
		<td nowrap>当前遗漏值</td>
		<td align="center" colspan="2">&nbsp;</td>
<?php for($i=1;$i<39;$i++){?>
		<td align="center"><?=$a[$i]?></td>
<?php }?>
	</tr>
	<tr class=tb>
		<td nowrap>平均遗漏值</td>
		<td align="center" colspan="2">&nbsp;</td>
<?php for($i=1;$i<39;$i++){
	if($s[$i]==0){$av=$total;}
	else{$av=intval($total/$s[$i]);}
?>
		<td align="center"><?=$av?></td>
<?php }?>
	</tr>
	<tr class=tb>
		<td nowrap>最大遗漏值</td>
		<td align="center" colspan="2">&nbsp;</td>
<?php for($i=1;$i<39;$i++){
	if($b[$i]-1<$a[$i]){$bv=$a[$i];}
	else{$bv=$b[$i]-1;}
?>
		<td align="center"><?=$bv?></td>
<?php }?>
	</tr>
	<tr class=tb>
		<td nowrap>最大连出值</td>
		<td align="center" colspan="2">&nbsp;</td>
<?php for($i=1;$i<39;$i++){
	if($d[$i]-1<$c[$i]){$dv=$c[$i];}
	else{$dv=$d[$i]-1;}
?>
		<td align="center"><?=$dv?></td>
<?php }?>
	</tr>
	<tr class=th>
		<td rowspan="2" >期号</td>
		<td rowspan="2" colspan="2">开奖号码</td>
		<td class="wdh">3</td>
		<td class="wdh">4</td>
		<td class="wdh">5</td>
		<td class="wdh">6</td>
		<td class="wdh">7</td>
		<td class="wdh">8</td>
		<td class="wdh">9</td>
		<td class="wdh">10</td>
		<td class="wdh">11</td>
		<td class="wdh">12</td>
		<td class="wdh">13</td>
		<td class="wdh">14</td>
		<td class="wdh">15</td>
		<td class="wdh">16</td>
		<td class="wdh">17</td>
		<td class="wdh">18</td>
		<td class="wdh">19</td>
		<td class="wdh">20</td>
		<td class="wdh">21</td>
        
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

		<td class="wdh">大</td>
		<td class="wdh">小</td>
		<td class="wdh">奇</td>
		<td class="wdh">偶</td>
		<td class="wdh">质</td>
		<td class="wdh">合</td>

		<td class="wdh">0</td>
		<td class="wdh">1</td>
		<td class="wdh">2</td>
	</tr>
	<tr class=th>
		<td colspan="19">和值</td>
		<td colspan="10">和尾</td>
		<td colspan="2">大小</td>
		<td colspan="2">奇偶</td>
		<td colspan="2">质合</td>
		<td colspan="3">除3余数</td>
	</tr>
</table>
</div>
<br/>

</CENTER>
