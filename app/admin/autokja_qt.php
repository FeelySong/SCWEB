<?php
include_once("conn.php");
function autokj_qt($n1,$n2,$n3,$n4,$n5,$lid,$issue,$sign){
	if($sign==1){
		$signa=1;
		$signb=1;
	}else{
		$signa=0;
		$signb=0;
	}
	
//	if($lid==1 || $lid==2 || $lid==3 || $lid==4 || $lid==10){
		$kjcode=$n1.$n2.$n3.$n4.$n5;
//	}else if($lid==5 || $lid==9){
//		$kjcode=$n1.$n2.$n3;	
//	}else if($lid==6 || $lid==7 || $lid==8 || $lid==11){
//		$kjcode=$n1." ".$n2." ".$n3." ".$n4." ".$n5;
//	}
//	$n1=1;
//	$n2=2;
//	$n3=3;
//	$n4=4;
//	$n5=5;

	$na[0]=$n1;
	$na[1]=$n2;
	$na[2]=$n3;
	$na[3]=$n4;
	$na[4]=$n5;

	$nb[0]=$n1;
	$nb[1]=$n2;
	$nb[2]=$n3;
	$nb[3]=$n4;
	$nb[4]=$n5;

	for($i=0; $i<5; $i++) {
		for($j=4;$j>$i;$j--) {
			if ($nb[$j]<$nb[$j-1]) {
				$temp0=$nb[$j];
				$nb[$j]=$nb[$j-1];
				$nb[$j-1] =$temp0;
			}
		}
	}
	
//	$sql="select * from ssc_bills_qt where zt=0 order by id asc";
	$sql="select * from ssc_bills_qt where lotteryid='".$lid."' and issue='".$issue."' and zt=1 order by id asc";
	$rs=mysql_query($sql) or  die("数据库修改出错1".mysql_error());
	while ($row = mysql_fetch_array($rs)){
		$mid=$row['mid'];
		if($row['mode']=="1"){
			$modes=1;
		}else if($row['mode']=="2"){
			$modes=0.1;
		}
		
		if($mid=="14" || $mid=="52" || $mid=="90" || $mid=="128" || $mid=="164" || $mid=="294" || $mid=="322"){//前三直选ok164时时乐2943d 322p3
			if($row['type']=="input"){//单式
				$cs=$n1.$n2.$n3;
				if(strpos($row['codes'],$cs)===false){
					mysql_query("update ssc_bills_qt set zt=".$signb.",prize=0 where id='".$row['id']."'");
				}else{
					mysql_query("update ssc_bills_qt set zt=".$signa.",prize=rates*times where id='".$row['id']."'");
				}
			}else if($row['type']=="digital"){//复式
				$stra=explode("|",$row['codes']);
				$nums=0;
				for ($i=0; $i<count($stra); $i++) {
					$strb=explode("&",$stra[$i]);
					for ($ii=0; $ii<count($strb); $ii++) {
						if($strb[$ii]==$na[$i]){$nums=$nums+1;}
					}
				}
				if($nums==3){
					mysql_query("update ssc_bills_qt set zt=".$signa.",prize=rates*times where id='".$row['id']."'");						
				}else{
					mysql_query("update ssc_bills_qt set zt=".$signb.",prize=0 where id='".$row['id']."'");		
				}
			}
		}else if($mid=="15" || $mid=="53" || $mid=="91" || $mid=="129" || $mid=="165" || $mid=="295" || $mid=="323"){//前三和值ok165时时乐直选合值 295 3d 323p3
			$zt=2;
			$cs=$n1+$n2+$n3;
			$stra=explode("&",$row['codes']);
			for ($i=0; $i<count($stra); $i++) {
				if($stra[$i]==$cs){
					$zt=1;
					break;
				}
			}
			if($zt=="1"){
				mysql_query("update ssc_bills_qt set zt=".$signa.",prize=rates*times where id='".$row['id']."'");		
			}else{
				mysql_query("update ssc_bills_qt set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="16" || $mid=="54" || $mid=="92" || $mid=="130"){//后三直选
			if($row['type']=="input"){//单式
				$cs=$n3.$n4.$n5;
				if(strpos($row['codes'],$cs)===false){
					mysql_query("update ssc_bills_qt set zt=".$signb.",prize=0 where id='".$row['id']."'");
				}else{
					mysql_query("update ssc_bills_qt set zt=".$signa.",prize=rates*times where id='".$row['id']."'");
				}
			}else if($row['type']=="digital"){//复式
				$stra=explode("|",$row['codes']);
				$nums=0;
				for ($i=0; $i<count($stra); $i++) {
					$strb=explode("&",$stra[$i]);
					for ($ii=0; $ii<count($strb); $ii++) {
						if($strb[$ii]==$na[$i+2]){$nums=$nums+1;}
					}
				}
				if($nums==3){
					mysql_query("update ssc_bills_qt set zt=".$signa.",prize=rates*times where id='".$row['id']."'");						
				}else{
					mysql_query("update ssc_bills_qt set zt=".$signb.",prize=0 where id='".$row['id']."'");		
				}
			}
		}else if($mid=="17" || $mid=="55" || $mid=="93" || $mid=="131"){//后三和ok
			$zt=2;
			$cs=$n3+$n4+$n5;
			$stra=explode("&",$row['codes']);
			for ($i=0; $i<count($stra); $i++) {
				if($stra[$i]==$cs){
					$zt=1;
					break;
				}
			}
			if($zt=="1"){
				mysql_query("update ssc_bills_qt set zt=".$signa.",prize=rates*times where id='".$row['id']."'");		
			}else{
				mysql_query("update ssc_bills_qt set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="18" || $mid=="56" || $mid=="94" || $mid=="132" || $mid=="166" || $mid=="296" || $mid=="324"){//前组三ok 166时时乐组3 296 3d 324 p3
			$nums=0;
			if($n1==$n2 || $n1==$n3 || $n2==$n3){
				$stra=explode("&",$row['codes']);
				for ($i=0; $i<count($stra); $i++) {
					if($stra[$i]==$n1 || $stra[$i]==$n2 || $stra[$i]==$n3){$nums=$nums+1;}
				}
			}
			if($nums>=2){
				mysql_query("update ssc_bills_qt set zt=".$signa.",prize=rates*times where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills_qt set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="19" || $mid=="57" || $mid=="95" || $mid=="133" || $mid=="167" || $mid=="297" || $mid=="325"){//前组六ok 167时时乐组6 297 3d 325 p3
			$nums=0;
//			if($n1!=$n2 && $n1!=$n3 && $n2!=$n3){
				$stra=explode("&",$row['codes']);
				for ($i=0; $i<count($stra); $i++) {
					if($stra[$i]==$n1 || $stra[$i]==$n2 || $stra[$i]==$n3){$nums=$nums+1;}
				}
//			}
			if($nums>=3){
				mysql_query("update ssc_bills_qt set zt=".$signa.",prize=rates*times where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills_qt set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="20" || $mid=="58" || $mid=="96" || $mid=="134" || $mid=="168" || $mid=="298" || $mid=="326"){//前三组选，混合 inputok 168时时乐混合组选 298 3d 326p3
			$zt=2;
			if(strpos($row['codes'],$n1.$n2.$n3)===false && strpos($row['codes'],$n1.$n3.$n2)===false && strpos($row['codes'],$n2.$n1.$n3)===false && strpos($row['codes'],$n2.$n3.$n1)===false && strpos($row['codes'],$n3.$n1.$n2)===false && strpos($row['codes'],$n3.$n2.$n1)===false){
				mysql_query("update ssc_bills_qt set zt=".$signb.",prize=0 where id='".$row['id']."'");					
			}else{
				$rates=explode(";",Get_rate($mid));
				if($n1==$n2 || $n1==$n3 || $n2==$n3){//组三
					mysql_query("update ssc_bills_qt set zt=".$signa.",prize=".($rates[0]*$modes)."*times where id='".$row['id']."'");										
				}else{				
					mysql_query("update ssc_bills_qt set zt=".$signa.",prize=".($rates[1]*$modes)."*times where id='".$row['id']."'");						
				}
			}
		}else if($mid=="21" || $mid=="59" || $mid=="97" || $mid=="135" || $mid=="169" || $mid=="299" || $mid=="327"){//前三组合值ok 169时时乐组合值 299 3d 327 p3
			$zt=2;
			$cs=$n1+$n2+$n3;
			$stra=explode("&",$row['codes']);
			for ($i=0; $i<count($stra); $i++) {
				if($stra[$i]==$cs){
					$zt=1;
					break;
				}
			}
			if($zt=="1"){
				$rates=explode(";",Get_rate($mid));			
				if($n1==$n2 || $n1==$n3 || $n2==$n3){//组3
					mysql_query("update ssc_bills_qt set zt=".$signa.",prize=".($rates[0]*$modes)."*times where id='".$row['id']."'");
				}else{
					mysql_query("update ssc_bills_qt set zt=".$signa.",prize=".($rates[1]*$modes)."*times where id='".$row['id']."'");				
				}		
			}else{
				mysql_query("update ssc_bills_qt set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="22" || $mid=="60" || $mid=="98" || $mid=="136"){//后三组三
			$nums=0;
			if($n3==$n4 || $n3==$n5 || $n4==$n5){
				$stra=explode("&",$row['codes']);
				for ($i=0; $i<count($stra); $i++) {
					if($stra[$i]==$n3 || $stra[$i]==$n4 || $stra[$i]==$n5){$nums=$nums+1;}
				}
			}
			if($nums>=2){
				mysql_query("update ssc_bills_qt set zt=".$signa.",prize=rates*times where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills_qt set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}		
		}else if($mid=="23" || $mid=="61" || $mid=="99" || $mid=="137"){//后三组6
			$nums=0;
//			if($n3!=$n4 && $n3!=$n5 && $n4!=$n5){
				$stra=explode("&",$row['codes']);
				for ($i=0; $i<count($stra); $i++) {
					if($stra[$i]==$n3 || $stra[$i]==$n4 || $stra[$i]==$n5){$nums=$nums+1;}
				}
//			}
			if($nums>=3){
				mysql_query("update ssc_bills_qt set zt=".$signa.",prize=rates*times where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills_qt set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}		
		}else if($mid=="24" || $mid=="62" || $mid=="100" || $mid=="138"){//后三组混合
			$zt=2;
			if(strpos($row['codes'],$n3.$n4.$n5)===false && strpos($row['codes'],$n3.$n5.$n4)===false && strpos($row['codes'],$n4.$n3.$n5)===false && strpos($row['codes'],$n4.$n5.$n3)===false && strpos($row['codes'],$n5.$n3.$n4)===false && strpos($row['codes'],$n5.$n4.$n3)===false){
				mysql_query("update ssc_bills_qt set zt=".$signb.",prize=0 where id='".$row['id']."'");					
			}else{
				$rates=explode(";",Get_rate($mid));
				if($n3==$n4 || $n3==$n5 || $n4==$n5){//组三
					mysql_query("update ssc_bills_qt set zt=".$signa.",prize=".($rates[0]*$modes)."*times where id='".$row['id']."'");										
				}else{				
					mysql_query("update ssc_bills_qt set zt=".$signa.",prize=".($rates[1]*$modes)."*times where id='".$row['id']."'");						
				}
			}		
		}else if($mid=="25" || $mid=="63" || $mid=="101" || $mid=="139"){//后三组合值
			$zt=2;
			$cs=$n3+$n4+$n5;
			$stra=explode("&",$row['codes']);
			for ($i=0; $i<count($stra); $i++) {
				if($stra[$i]==$cs){
					$zt=1;
					break;
				}
			}
			if($zt=="1"){
				$rates=explode(";",Get_rate($mid));			
				if($n3==$n4 || $n3==$n5 || $n4==$n5){//组3
					mysql_query("update ssc_bills_qt set zt=".$signa.",prize=".($rates[0]*$modes)."*times where id='".$row['id']."'");
				}else{
					mysql_query("update ssc_bills_qt set zt=".$signa.",prize=".($rates[1]*$modes)."*times where id='".$row['id']."'");				
				}		
			}else{
				mysql_query("update ssc_bills_qt set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}		
		}else if($mid=="26" || $mid=="64" || $mid=="102" || $mid=="140"){//一码不定位ok
			$nums=0;
			$stra=explode("&",$row['codes']);
			for ($i=0; $i<count($stra); $i++) {
				if($stra[$i]==$n3 || $stra[$i]==$n4 || $stra[$i]==$n5){$nums=$nums+1;}
			}
			if($nums>=1){
				mysql_query("update ssc_bills_qt set zt=".$signa.",prize=rates*times*".$nums." where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills_qt set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="27" || $mid=="65" || $mid=="103" || $mid=="141"){//二码不定位ok
			$nums=0;
			$stra=explode("&",$row['codes']);
			for ($i=0; $i<count($stra); $i++) {
				if($stra[$i]==$n3 || $stra[$i]==$n4 || $stra[$i]==$n5){$nums=$nums+1;}
			}
			if($nums==2){
				mysql_query("update ssc_bills_qt set zt=".$signa.",prize=rates*times where id='".$row['id']."'");						
			}else if($nums==3){
				mysql_query("update ssc_bills_qt set zt=".$signa.",prize=rates*times*3 where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills_qt set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="28" || $mid=="66" || $mid=="104" || $mid=="142" || $mid=="172" || $mid=="302" || $mid=="330"){//前二直选 172时时乐前2直 302 3d 330p3
			if($row['type']=="input"){//单式
				$cs=$n1.$n2;
				$pos= strpos($row['codes'],$cs);
				if(strpos($row['codes'],$cs)===false){
					mysql_query("update ssc_bills_qt set zt=".$signb.",prize=0 where id='".$row['id']."'");
				}else{
					mysql_query("update ssc_bills_qt set zt=".$signa.",prize=rates*times where id='".$row['id']."'");
				}
			}else if($row['type']=="digital"){//复式
				$stra=explode("|",$row['codes']);
				$nums=0;
				for ($i=0; $i<count($stra); $i++) {
					$strb=explode("&",$stra[$i]);
					for ($ii=0; $ii<count($strb); $ii++) {
						if($strb[$ii]==$na[$i]){$nums=$nums+1;}
					}
				}
				if($nums==2){
					mysql_query("update ssc_bills_qt set zt=".$signa.",prize=rates*times where id='".$row['id']."'");						
				}else{
					mysql_query("update ssc_bills_qt set zt=".$signb.",prize=0 where id='".$row['id']."'");		
				}
			}		
		}else if($mid=="29" || $mid=="67" || $mid=="105" || $mid=="143" || $mid=="331"){//后二直选 331p3
			if($row['type']=="input"){//单式
				$cs=$n4.$n5;
				if(strpos($row['codes'],$cs)===false){
					mysql_query("update ssc_bills_qt set zt=".$signb.",prize=0 where id='".$row['id']."'");
				}else{
					mysql_query("update ssc_bills_qt set zt=".$signa.",prize=rates*times where id='".$row['id']."'");
				}
			}else if($row['type']=="digital"){//复式
				$stra=explode("|",$row['codes']);
				$nums=0;
				for ($i=0; $i<count($stra); $i++) {
					$strb=explode("&",$stra[$i]);
					for ($ii=0; $ii<count($strb); $ii++) {
						if($strb[$ii]==$na[$i+3]){$nums=$nums+1;}
					}
				}
				if($nums==2){
					mysql_query("update ssc_bills_qt set zt=".$signa.",prize=rates*times where id='".$row['id']."'");						
				}else{
					mysql_query("update ssc_bills_qt set zt=".$signb.",prize=0 where id='".$row['id']."'");		
				}
			}		
		}else if($mid=="30" || $mid=="68" || $mid=="106" || $mid=="144" || $mid=="174" || $mid=="304" || $mid=="332"){//前二组选 174时时乐前二组 304 3d 332p3
			if($row['type']=="input"){//单式
				if(strpos($row['codes'],$n1.$n2)===false && strpos($row['codes'],$n2.$n1)===false){
					mysql_query("update ssc_bills_qt set zt=".$signb.",prize=0 where id='".$row['id']."'");					
				}else{
					mysql_query("update ssc_bills_qt set zt=".$signa.",prize=rates*times where id='".$row['id']."'");						
				}
			}else{
				$nums=0;
				$stra=explode("&",$row['codes']);
				for ($i=0; $i<count($stra); $i++) {
					if($stra[$i]==$n1 || $stra[$i]==$n2){$nums=$nums+1;}
				}
				if($nums>=2){
					mysql_query("update ssc_bills_qt set zt=".$signa.",prize=rates*times where id='".$row['id']."'");						
				}else{
					mysql_query("update ssc_bills_qt set zt=".$signb.",prize=0 where id='".$row['id']."'");		
				}
			}
		}else if($mid=="31" || $mid=="69" || $mid=="107" || $mid=="145" || $mid=="333"){//后二组选 333p3
			if($row['type']=="input"){//单式
				if(strpos($row['codes'],$n4.$n5)===false && strpos($row['codes'],$n5.$n4)===false){
					mysql_query("update ssc_bills_qt set zt=".$signb.",prize=0 where id='".$row['id']."'");					
				}else{
					mysql_query("update ssc_bills_qt set zt=".$signa.",prize=rates*times where id='".$row['id']."'");						
				}			
			}else{
				$nums=0;
				$stra=explode("&",$row['codes']);
				for ($i=0; $i<count($stra); $i++) {
					if($stra[$i]==$n4 || $stra[$i]==$n5){$nums=$nums+1;}
				}
				if($nums>=2){
					mysql_query("update ssc_bills_qt set zt=".$signa.",prize=rates*times where id='".$row['id']."'");						
				}else{
					mysql_query("update ssc_bills_qt set zt=".$signb.",prize=0 where id='".$row['id']."'");		
				}
			}
		}else if($mid=="32" || $mid=="33" || $mid=="34" || $mid=="35" || $mid=="36" || $mid=="70" || $mid=="71" || $mid=="72" || $mid=="73" || $mid=="74" || $mid=="108" || $mid=="109" || $mid=="110" || $mid=="111" || $mid=="112" || $mid=="146" || $mid=="147" || $mid=="148" || $mid=="149" || $mid=="150" || $mid=="176" || $mid=="177" || $mid=="178" || $mid=="306" || $mid=="307" || $mid=="308" || $mid=="334" || $mid=="335" || $mid=="336" || $mid=="337" || $mid=="338"){//定位胆ok 176时时乐 306 3d 334 p3
//			$stra=explode("|",$row['codes']);
//			$nums=0;
//			for ($i=0; $i<count($stra); $i++) {
//				$strb=explode("&",$stra[$i]);
//				for ($ii=0; $ii<count($strb); $ii++) {
//					if($strb[$ii]==$na[$i]){$nums=$nums+1;}
//				}
//			}
//			
			
			
			//xc添加
			if($mid=="32" || $mid=="108" || $mid=="146" || $mid==334){//万位
				$nums=0;
				$strb=explode("&",$row['codes']);
				for ($ii=0; $ii<count($strb); $ii++) {
					if($strb[$ii]==$na[0]){$nums=$nums+1;}
				}
			}else if($mid=="33" || $mid=="109" || $mid=="147" || $mid==335){//千位
				$nums=0;
				$strb=explode("&",$row['codes']);
				for ($ii=0; $ii<count($strb); $ii++) {
					if($strb[$ii]==$na[1]){$nums=$nums+1;}
				}
			}else if($mid=="34" || $mid=="110" || $mid=="148" || $mid==336 || $mid==176 || $mid==306){//百位
				$nums=0;
				$strb=explode("&",$row['codes']);
				for ($ii=0; $ii<count($strb); $ii++) {
					if($strb[$ii]==$na[2]){$nums=$nums+1;}
				}
			}else if($mid=="35" || $mid=="111" || $mid=="149" || $mid==337 || $mid==177 || $mid==307){//十位
				$nums=0;
				$strb=explode("&",$row['codes']);
				for ($ii=0; $ii<count($strb); $ii++) {
					if($strb[$ii]==$na[3]){$nums=$nums+1;}
				}
			}else if($mid=="36" || $mid=="112" || $mid=="150" || $mid==338 || $mid==178 || $mid==308){//个位
				$nums=0;
				$strb=explode("&",$row['codes']);
				for ($ii=0; $ii<count($strb); $ii++) {
					if($strb[$ii]==$na[4]){$nums=$nums+1;}
				}
			}
			if($nums>=1){
				mysql_query("update ssc_bills_qt set zt=".$signa.",prize=rates*times*".$nums." where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills_qt set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="37" || $mid=="75" || $mid=="113" || $mid=="151" || $mid=="179" || $mid=="309" || $mid=="335"){//前二大小单双 179时时乐 309 3d 335 p3
			if($n1>4){$na1a="大";}else{$na1a="小";}
			if ($n1%2==1){$na1b="单";}else{$na1b="双";}
			if($n2>4){$na2a="大";}else{$na2a="小";}
			if ($n2%2==1){$na2b="单";}else{$na2b="双";}
			$stra=explode("|",$row['codes']);
			$numa=0;
			$numb=0;
			$strb=explode("&",$stra[0]);
			for ($ii=0; $ii<count($strb); $ii++) {
				if($strb[$ii]==$na1a || $strb[$ii]==$na1b){$numa=$numa+1;}
			}
			$strb=explode("&",$stra[1]);
			for ($ii=0; $ii<count($strb); $ii++) {
				if($strb[$ii]==$na2a || $strb[$ii]==$na2b){$numb=$numb+1;}
			}
//			echo $row['codes'].$numb."<br>";
			$nums=$numa*$numb;
			if($nums>=1){
				mysql_query("update ssc_bills_qt set zt=".$signa.",prize=rates*times*".$nums." where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills_qt set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="38" || $mid=="76" || $mid=="114" || $mid=="152" || $mid=="336"){//后二大小单双ok 336 p3
			if($n4>4){$na1a="大";}else{$na1a="小";}
			if ($n4%2==1){$na1b="单";}else{$na1b="双";}
			if($n5>4){$na2a="大";}else{$na2a="小";}
			if ($n5%2==1){$na2b="单";}else{$na2b="双";}
			$stra=explode("|",$row['codes']);
			$numa=0;
			$numb=0;
			$strb=explode("&",$stra[0]);
			for ($ii=0; $ii<count($strb); $ii++) {
				if($strb[$ii]==$na1a || $strb[$ii]==$na1b){$numa=$numa+1;}
			}
			$strb=explode("&",$stra[1]);
			for ($ii=0; $ii<count($strb); $ii++) {
				if($strb[$ii]==$na2a || $strb[$ii]==$na2b){$numb=$numb+1;}
			}
//			echo $numa.$row['codes'].$numb."<br>";
			
			$nums=$numa*$numb;
			if($nums>=1){
				mysql_query("update ssc_bills_qt set zt=".$signa.",prize=rates*times*".$nums." where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills_qt set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
		}else if($mid=="170" || $mid=="300" || $mid=="328"){//时时乐一码不定位ok 300 3d 328 p3
			$nums=0;
			$stra=explode("&",$row['codes']);
			for ($i=0; $i<count($stra); $i++) {
				if($stra[$i]==$n1 || $stra[$i]==$n2 || $stra[$i]==$n3){$nums=$nums+1;}
			}
			if($nums>=1){
				mysql_query("update ssc_bills_qt set zt=".$signa.",prize=rates*times*".$nums." where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills_qt set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="171" || $mid=="301" || $mid=="329"){//时时乐二码不定位ok 301 3d 329 p3
			$nums=0;
			$stra=explode("&",$row['codes']);
			for ($i=0; $i<count($stra); $i++) {
				if($stra[$i]==$n1 || $stra[$i]==$n2 || $stra[$i]==$n3){$nums=$nums+1;}
			}
			if($nums==2){
				mysql_query("update ssc_bills_qt set zt=".$signa.",prize=rates*times where id='".$row['id']."'");						
			}else if($nums==3){
				mysql_query("update ssc_bills_qt set zt=".$signa.",prize=rates*times*3 where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills_qt set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="173" || $mid=="303"){//时时乐后二直选 303 3d
			if($row['type']=="input"){//单式
				$cs=$n2.$n3;
				if(strpos($row['codes'],$cs)===false){
					mysql_query("update ssc_bills_qt set zt=".$signb.",prize=0 where id='".$row['id']."'");
				}else{
					mysql_query("update ssc_bills_qt set zt=".$signa.",prize=rates*times where id='".$row['id']."'");
				}
			}else if($row['type']=="digital"){//复式
				$stra=explode("|",$row['codes']);
				$nums=0;
				for ($i=0; $i<count($stra); $i++) {
					$strb=explode("&",$stra[$i]);
					for ($ii=0; $ii<count($strb); $ii++) {
						if($strb[$ii]==$na[$i+1]){$nums=$nums+1;}
					}
				}
				if($nums==2){
					mysql_query("update ssc_bills_qt set zt=".$signa.",prize=rates*times where id='".$row['id']."'");						
				}else{
					mysql_query("update ssc_bills_qt set zt=".$signb.",prize=0 where id='".$row['id']."'");		
				}
			}				
		}else if($mid=="175" || $mid=="305"){//时时乐后二组选 305 3d
			if($row['type']=="input"){//单式
				if(strpos($row['codes'],$n2.$n3)===false && strpos($row['codes'],$n3.$n2)===false){
					mysql_query("update ssc_bills_qt set zt=".$signb.",prize=0 where id='".$row['id']."'");					
				}else{
					mysql_query("update ssc_bills_qt set zt=".$signa.",prize=rates*times where id='".$row['id']."'");						
				}			
			}else{
				$nums=0;
				$stra=explode("&",$row['codes']);
				for ($i=0; $i<count($stra); $i++) {
					if($stra[$i]==$n2 || $stra[$i]==$n3){$nums=$nums+1;}
				}
				if($nums>=2){
					mysql_query("update ssc_bills_qt set zt=".$signa.",prize=rates*times where id='".$row['id']."'");						
				}else{
					mysql_query("update ssc_bills_qt set zt=".$signb.",prize=0 where id='".$row['id']."'");		
				}
			}
		}else if($mid=="180" || $mid=="310"){//时时乐后二大小单双ok	310 3d
			if($n2>4){$na1a="大";}else{$na1a="小";}
			if ($n2%2==1){$na1b="单";}else{$na1b="双";}
			if($n3>4){$na2a="大";}else{$na2a="小";}
			if ($n3%2==1){$na2b="单";}else{$na2b="双";}
			$stra=explode("|",$row['codes']);
			$numa=0;
			$numb=0;
			$strb=explode("&",$stra[0]);
			for ($ii=0; $ii<count($strb); $ii++) {
				if($strb[$ii]==$na1a || $strb[$ii]==$na1b){$numa=$numa+1;}
			}
			$strb=explode("&",$stra[1]);
			for ($ii=0; $ii<count($strb); $ii++) {
				if($strb[$ii]==$na2a || $strb[$ii]==$na2b){$numb=$numb+1;}
			}
//			echo $numa.$row['codes'].$numb."<br>";
			
			$nums=$numa*$numb;
			if($nums>=1){
				mysql_query("update ssc_bills_qt set zt=".$signa.",prize=rates*times*".$nums." where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills_qt set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}			
			///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		}else if($mid=="197" || $mid=="231" || $mid=="265" || $mid=="357"){//115前三直选
			if($row['type']=="input"){//单式
				$cs=sprintf("%02d",$n1)." ".sprintf("%02d",$n2)." ".sprintf("%02d",$n3);
				$pos= strpos($row['codes'],$cs);
				if(strpos($row['codes'],$cs)===false){
					mysql_query("update ssc_bills_qt set zt=".$signb.",prize=0 where id='".$row['id']."'");
				}else{
					mysql_query("update ssc_bills_qt set zt=".$signa.",prize=rates*times where id='".$row['id']."'");
				}
			}else if($row['type']=="digital"){//复式
				$stra=explode("|",$row['codes']);
				$nums=0;
				for ($i=0; $i<count($stra); $i++) {
					$strb=explode("&",$stra[$i]);
					for ($ii=0; $ii<count($strb); $ii++) {
						if($strb[$ii]==sprintf("%02d",$na[$i])){$nums=$nums+1;}
					}
				}
				if($nums==3){
					mysql_query("update ssc_bills_qt set zt=".$signa.",prize=rates*times where id='".$row['id']."'");						
				}else{
					mysql_query("update ssc_bills_qt set zt=".$signb.",prize=0 where id='".$row['id']."'");		
				}
			}
		}else if($mid=="198" || $mid=="232" || $mid=="266" || $mid=="358"){//115前三组选
			if($row['type']=="input"){//单式
				$zt=2;
				if(strpos($row['codes'],sprintf("%02d",$n1)." ".sprintf("%02d",$n2)." ".sprintf("%02d",$n3))===false && strpos($row['codes'],sprintf("%02d",$n1)." ".sprintf("%02d",$n3)." ".sprintf("%02d",$n2))===false && strpos($row['codes'],sprintf("%02d",$n2)." ".sprintf("%02d",$n1)." ".sprintf("%02d",$n3))===false && strpos($row['codes'],sprintf("%02d",$n2)." ".sprintf("%02d",$n3)." ".sprintf("%02d",$n1))===false && strpos($row['codes'],sprintf("%02d",$n3)." ".sprintf("%02d",$n1)." ".sprintf("%02d",$n2))===false && strpos($row['codes'],sprintf("%02d",$n3)." ".sprintf("%02d",$n2)." ".sprintf("%02d",$n1))===false){
					mysql_query("update ssc_bills_qt set zt=".$signb.",prize=0 where id='".$row['id']."'");					
				}else{
					mysql_query("update ssc_bills_qt set zt=".$signa.",prize=rates*times where id='".$row['id']."'");										
				}
			}else{
				$nums=0;
				$stra=explode("&",$row['codes']);
				for ($i=0; $i<count($stra); $i++) {
					if($stra[$i]==sprintf("%02d",$n1) || $stra[$i]==sprintf("%02d",$n2) || $stra[$i]==sprintf("%02d",$n3)){$nums=$nums+1;}
				}
				if($nums>=3){
					mysql_query("update ssc_bills_qt set zt=".$signa.",prize=rates*times where id='".$row['id']."'");						
				}else{
					mysql_query("update ssc_bills_qt set zt=".$signb.",prize=0 where id='".$row['id']."'");		
				}
			}
		}else if($mid=="199" || $mid=="233" || $mid=="267" || $mid=="359"){//115前二直选
			if($row['type']=="input"){//单式
				$cs=sprintf("%02d",$n1)." ".sprintf("%02d",$n2);
				if(strpos($row['codes'],$cs)===false){
					mysql_query("update ssc_bills_qt set zt=".$signb.",prize=0 where id='".$row['id']."'");
				}else{
					mysql_query("update ssc_bills_qt set zt=".$signa.",prize=rates*times where id='".$row['id']."'");
				}
			}else if($row['type']=="digital"){//复式
				$stra=explode("|",$row['codes']);
				$nums=0;
				for ($i=0; $i<count($stra); $i++) {
					$strb=explode("&",$stra[$i]);
					for ($ii=0; $ii<count($strb); $ii++) {
						if($strb[$ii]==sprintf("%02d",$na[$i])){$nums=$nums+1;}
					}
				}
				if($nums==2){
					mysql_query("update ssc_bills_qt set zt=".$signa.",prize=rates*times where id='".$row['id']."'");						
				}else{
					mysql_query("update ssc_bills_qt set zt=".$signb.",prize=0 where id='".$row['id']."'");		
				}
			}
		}else if($mid=="200" || $mid=="234" || $mid=="268" || $mid=="360"){//115前二组选
			if($row['type']=="input"){//单式
				if(strpos($row['codes'],sprintf("%02d",$n1)." ".sprintf("%02d",$n2))===false && strpos($row['codes'],sprintf("%02d",$n2)." ".sprintf("%02d",$n1))===false){
					mysql_query("update ssc_bills_qt set zt=".$signb.",prize=0 where id='".$row['id']."'");					
				}else{
					mysql_query("update ssc_bills_qt set zt=".$signa.",prize=rates*times where id='".$row['id']."'");						
				}
			}else{
				$nums=0;
				$stra=explode("&",$row['codes']);
				for ($i=0; $i<count($stra); $i++) {
					if($stra[$i]==sprintf("%02d",$n1) || $stra[$i]==sprintf("%02d",$n2)){$nums=$nums+1;}
				}
				if($nums>=2){
					mysql_query("update ssc_bills_qt set zt=".$signa.",prize=rates*times where id='".$row['id']."'");						
				}else{
					mysql_query("update ssc_bills_qt set zt=".$signb.",prize=0 where id='".$row['id']."'");		
				}
			}
		}else if($mid=="201" || $mid=="235" || $mid=="269" || $mid=="361"){//115前三不定位ok
			$nums=0;
			$stra=explode("&",$row['codes']);
			for ($i=0; $i<count($stra); $i++) {
				if($stra[$i]==sprintf("%02d",$n1) || $stra[$i]==sprintf("%02d",$n2) || $stra[$i]==sprintf("%02d",$n3)){$nums=$nums+1;}
			}
			if($nums>=1){
				mysql_query("update ssc_bills_qt set zt=".$signa.",prize=rates*times*".$nums." where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills_qt set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="202" || $mid=="236" || $mid=="270" || $mid=="362"){//定位胆ok 
			$stra=explode("|",$row['codes']);
			$nums=0;
			for ($i=0; $i<count($stra); $i++) {
				$strb=explode("&",$stra[$i]);
				for ($ii=0; $ii<count($strb); $ii++) {
					if($strb[$ii]==sprintf("%02d",$na[$i])){$nums=$nums+1;}
				}
			}
			if($nums>=1){
				mysql_query("update ssc_bills_qt set zt=".$signa.",prize=rates*times*".$nums." where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills_qt set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="205" || $mid=="239" || $mid=="273" || $mid=="365"){//定单双
			$numa=0;
			if ($n1%2==0){$numa=$numa+1;}
			if ($n2%2==0){$numa=$numa+1;}
			if ($n3%2==0){$numa=$numa+1;}
			if ($n4%2==0){$numa=$numa+1;}
			if ($n5%2==0){$numa=$numa+1;}
			$numstr=(5-$numa)."单".$numa."双";
			$rates=explode(";",Get_rate($mid));
			if(strpos($row['codes'],$numstr)===false){
				mysql_query("update ssc_bills_qt set zt=".$signb.",prize=0 where id='".$row['id']."'");
			}else{
				mysql_query("update ssc_bills_qt set zt=".$signa.",prize=".($rates[$numa]*$modes)."*times where id='".$row['id']."'");
			}
		}else if($mid=="206" || $mid=="240" || $mid=="274" || $mid=="367"){//猜中位
			$rates=explode(";",Get_rate($mid));
			$nums=$nb[2];
			if(strpos($row['codes'],strval($nums))===false){//字符类型转换
				mysql_query("update ssc_bills_qt set zt=".$signb.",prize=0 where id='".$row['id']."'");
			}else{
				if($nums>6){
					$nums=12-$nums;
				}
//			echo $nums;
				mysql_query("update ssc_bills_qt set zt=".$signa.",prize=".($rates[$nums-3]*$modes)."*times where id='".$row['id']."'");
			}
//			echo $nb[2];
		}else if($mid=="207" || $mid=="241" || $mid=="275" || $mid=="368"){//任选1中1
			$nums=0;
			$stra=explode("&",$row['codes']);
			for ($i=0; $i<count($stra); $i++) {
				if($stra[$i]==sprintf("%02d",$n1) || $stra[$i]==sprintf("%02d",$n2) || $stra[$i]==sprintf("%02d",$n3) || $stra[$i]==sprintf("%02d",$n4) || $stra[$i]==sprintf("%02d",$n5)){$nums=$nums+1;}
			}
			if($nums>=1){
				mysql_query("update ssc_bills_qt set zt=".$signa.",prize=rates*times*".$nums." where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills_qt set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="208" || $mid=="242" || $mid=="276" || $mid=="369"){//任选2中2
			if($row['type']=="input"){//单式
				$nums=0;
				$stra=explode("&",$row['codes']);
				for ($i=0; $i<count($stra); $i++) {
					$numa=0;
					$strb=explode(" ",$stra[$i]);
					for ($ii=0; $ii<count($strb); $ii++) {
						if($strb[$ii]==sprintf("%02d",$n1) || $strb[$ii]==sprintf("%02d",$n2) || $strb[$ii]==sprintf("%02d",$n3) || $strb[$ii]==sprintf("%02d",$n4) || $strb[$ii]==sprintf("%02d",$n5)){$numa=$numa+1;}
					}
					if($numa>=2){$nums=$nums+1;}
				}
				if($nums>=1){
					mysql_query("update ssc_bills_qt set zt=".$signa.",prize=rates*times*".$nums." where id='".$row['id']."'");						
				}else{
					mysql_query("update ssc_bills_qt set zt=".$signb.",prize=0 where id='".$row['id']."'");		
				}
			}else{
				$nums=0;
				$stra=explode("&",$row['codes']);
				for ($i=0; $i<count($stra); $i++) {
					if($stra[$i]==sprintf("%02d",$n1) || $stra[$i]==sprintf("%02d",$n2) || $stra[$i]==sprintf("%02d",$n3) || $stra[$i]==sprintf("%02d",$n4) || $stra[$i]==sprintf("%02d",$n5)){$nums=$nums+1;}
				}
				if($nums>=2){
					mysql_query("update ssc_bills_qt set zt=".$signa.",prize=rates*times*".($nums*($nums-1)/2)." where id='".$row['id']."'");						
				}else{
					mysql_query("update ssc_bills_qt set zt=".$signb.",prize=0 where id='".$row['id']."'");		
				}
			}
		}else if($mid=="209" || $mid=="243" || $mid=="277" || $mid=="370"){//任选3中3
			if($row['type']=="input"){//单式
				$nums=0;
				$stra=explode("&",$row['codes']);
				for ($i=0; $i<count($stra); $i++) {
					$numa=0;
					$strb=explode(" ",$stra[$i]);
					for ($ii=0; $ii<count($strb); $ii++) {
						if($strb[$ii]==sprintf("%02d",$n1) || $strb[$ii]==sprintf("%02d",$n2) || $strb[$ii]==sprintf("%02d",$n3) || $strb[$ii]==sprintf("%02d",$n4) || $strb[$ii]==sprintf("%02d",$n5)){$numa=$numa+1;}
					}
					if($numa>=3){$nums=$nums+1;}
				}
				if($nums>=1){
					mysql_query("update ssc_bills_qt set zt=".$signa.",prize=rates*times*".$nums." where id='".$row['id']."'");						
				}else{
					mysql_query("update ssc_bills_qt set zt=".$signb.",prize=0 where id='".$row['id']."'");		
				}
			}else{
				$nums=0;
				$stra=explode("&",$row['codes']);
				for ($i=0; $i<count($stra); $i++) {
					if($stra[$i]==sprintf("%02d",$n1) || $stra[$i]==sprintf("%02d",$n2) || $stra[$i]==sprintf("%02d",$n3) || $stra[$i]==sprintf("%02d",$n4) || $stra[$i]==sprintf("%02d",$n5)){$nums=$nums+1;}
				}
				if($nums>=3){
					mysql_query("update ssc_bills_qt set zt=".$signa.",prize=rates*times*".($nums*($nums-1)*($nums-2)/6)." where id='".$row['id']."'");						
				}else{
					mysql_query("update ssc_bills_qt set zt=".$signb.",prize=0 where id='".$row['id']."'");		
				}
			}
		}else if($mid=="210" || $mid=="244" || $mid=="278" || $mid=="371"){//任选4中4
			if($row['type']=="input"){//单式
				$nums=0;
				$stra=explode("&",$row['codes']);
				for ($i=0; $i<count($stra); $i++) {
					$numa=0;
					$strb=explode(" ",$stra[$i]);
					for ($ii=0; $ii<count($strb); $ii++) {
						if($strb[$ii]==sprintf("%02d",$n1) || $strb[$ii]==sprintf("%02d",$n2) || $strb[$ii]==sprintf("%02d",$n3) || $strb[$ii]==sprintf("%02d",$n4) || $strb[$ii]==sprintf("%02d",$n5)){$numa=$numa+1;}
					}
					if($numa>=4){$nums=$nums+1;}
				}
				if($nums>=1){
					mysql_query("update ssc_bills_qt set zt=".$signa.",prize=rates*times*".$nums." where id='".$row['id']."'");						
				}else{
					mysql_query("update ssc_bills_qt set zt=".$signb.",prize=0 where id='".$row['id']."'");		
				}
			}else{
				$nums=0;
				$stra=explode("&",$row['codes']);
				for ($i=0; $i<count($stra); $i++) {
					if($stra[$i]==sprintf("%02d",$n1) || $stra[$i]==sprintf("%02d",$n2) || $stra[$i]==sprintf("%02d",$n3) || $stra[$i]==sprintf("%02d",$n4) || $stra[$i]==sprintf("%02d",$n5)){$nums=$nums+1;}
				}
				if($nums>=4){
					mysql_query("update ssc_bills_qt set zt=".$signa.",prize=rates*times*".($nums*($nums-1)*($nums-2)*($nums-3)/24)." where id='".$row['id']."'");
				}else{
					mysql_query("update ssc_bills_qt set zt=".$signb.",prize=0 where id='".$row['id']."'");		
				}
			}
		}else if($mid=="211" || $mid=="245" || $mid=="279" || $mid=="372"){//任选5中5
			if($row['type']=="input"){//单式
				$nums=0;
				$stra=explode("&",$row['codes']);
				for ($i=0; $i<count($stra); $i++) {
					$numa=0;
					$strb=explode(" ",$stra[$i]);
					for ($ii=0; $ii<count($strb); $ii++) {
						if($strb[$ii]==sprintf("%02d",$n1) || $strb[$ii]==sprintf("%02d",$n2) || $strb[$ii]==sprintf("%02d",$n3) || $strb[$ii]==sprintf("%02d",$n4) || $strb[$ii]==sprintf("%02d",$n5)){$numa=$numa+1;}
					}
					if($numa>=5){$nums=$nums+1;}
				}
				if($nums>=1){
					mysql_query("update ssc_bills_qt set zt=".$signa.",prize=rates*times*".$nums." where id='".$row['id']."'");						
				}else{
					mysql_query("update ssc_bills_qt set zt=".$signb.",prize=0 where id='".$row['id']."'");		
				}
			}else{
				$nums=0;
				$stra=explode("&",$row['codes']);
				for ($i=0; $i<count($stra); $i++) {
					if($stra[$i]==sprintf("%02d",$n1) || $stra[$i]==sprintf("%02d",$n2) || $stra[$i]==sprintf("%02d",$n3) || $stra[$i]==sprintf("%02d",$n4) || $stra[$i]==sprintf("%02d",$n5)){$nums=$nums+1;}
				}
				if($nums>=5){
					mysql_query("update ssc_bills_qt set zt=".$signa.",prize=rates*times where id='".$row['id']."'");
				}else{
					mysql_query("update ssc_bills_qt set zt=".$signb.",prize=0 where id='".$row['id']."'");		
				}
			}
		}else if($mid=="212" || $mid=="213" || $mid=="214" || $mid=="246" || $mid=="247" || $mid=="248" || $mid=="280" || $mid=="281" || $mid=="282" || $mid=="373" || $mid=="374" || $mid=="375"){//任选6中5 75 85
			if($row['type']=="input"){//单式
				$nums=0;
				$stra=explode("&",$row['codes']);
				for ($i=0; $i<count($stra); $i++) {
					$numa=0;
					$strb=explode(" ",$stra[$i]);
					for ($ii=0; $ii<count($strb); $ii++) {
						if($strb[$ii]==sprintf("%02d",$n1) || $strb[$ii]==sprintf("%02d",$n2) || $strb[$ii]==sprintf("%02d",$n3) || $strb[$ii]==sprintf("%02d",$n4) || $strb[$ii]==sprintf("%02d",$n5)){$numa=$numa+1;}
					}
					if($numa>=5){$nums=$nums+1;}
				}
				if($nums>=1){
					mysql_query("update ssc_bills_qt set zt=".$signa.",prize=rates*times*".$nums." where id='".$row['id']."'");						
				}else{
					mysql_query("update ssc_bills_qt set zt=".$signb.",prize=0 where id='".$row['id']."'");		
				}
			}else{
				$nums=0;
				$stra=explode("&",$row['codes']);
				for ($i=0; $i<count($stra); $i++) {
					if($stra[$i]==sprintf("%02d",$n1) || $stra[$i]==sprintf("%02d",$n2) || $stra[$i]==sprintf("%02d",$n3) || $stra[$i]==sprintf("%02d",$n4) || $stra[$i]==sprintf("%02d",$n5)){$nums=$nums+1;}
				}
				if($nums>=5){
					mysql_query("update ssc_bills_qt set zt=".$signa.",prize=rates*times where id='".$row['id']."'");
				}else{
					mysql_query("update ssc_bills_qt set zt=".$signb.",prize=0 where id='".$row['id']."'");	
				}
			}

		}
		
		if($sign==1){
			$sqls="update ssc_bills_qt set kjcode='".$kjcode."' where id ='".$row['id']."'";
			$rss=mysql_query($sqls) or  die("数据库修改出错1".mysql_error());
			
			$sqls="select * from ssc_bills_qt where id ='".$row['id']."'";
			$rss=mysql_query($sqls) or  die("数据库修改出错1".mysql_error());
			$rows = mysql_fetch_array($rss);
		}
	}
	
	$sql="select * from ssc_bills_qt where lotteryid='".$lid."' and issue='".$issue."' and zt=1 order by id asc";
	$rs=mysql_query($sql) or  die("数据库修改出错1".mysql_error());
	$row = mysql_fetch_array($rs);	
	return  $row['kjcode'];
}

//$jieguo=autokj_qt(1,2,3,4,5,2,130625189,1);
//echo("aaa".$jieguo);
?>