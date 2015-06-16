<?php
session_start();
//error_reporting(0);
require_once 'conn.php';

//function autokj($n1,$n2,$n3,$n4,$n5,$lid,$issue,$sign){

$sqlz = "select * from ssc_data where zt=0 or (zt=2 and sign>5) order by issue asc";
$rsz = mysql_query($sqlz);
while ($rowz = mysql_fetch_array($rsz)){
	$n1=$rowz['n1'];
	$n2=$rowz['n2'];
	$n3=$rowz['n3'];
	$n4=$rowz['n4'];
	$n5=$rowz['n5'];

	$lid=$rowz['cid'];
	$issue=dlid($rowz['issue'],$lid);
	echo $issue."_".$lid;
	
	if($rowz['sign']>0){
		$sign=1;
	}else{
		$sign=0;
	}

	if($sign==1){
		$signa=1;
		$signb=2;
	}else{
		$signa=0;
		$signb=0;
	}
	
	if($lid==1 || $lid==2 || $lid==3 || $lid==4 || $lid==10){
		$kjcode=$n1.$n2.$n3.$n4.$n5;
	}else if($lid==5 || $lid==9){
		$kjcode=$n1.$n2.$n3;	
	}else if($lid==6 || $lid==7 || $lid==8 || $lid==11){
		$kjcode=sprintf("%02d",$n1)." ".sprintf("%02d",$n2)." ".sprintf("%02d",$n3)." ".sprintf("%02d",$n4)." ".sprintf("%02d",$n5);
	}

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
	
	
//	$sql="select * from ssc_bills where zt=0 order by id asc";
	$sql="select * from ssc_bills where lotteryid='".$lid."' and issue='".$issue."' and zt=0 order by id asc";
	$rs=mysql_query($sql) or  die("数据库修改出错1".mysql_error());
	while ($row = mysql_fetch_array($rs)){
		$mid=$row['mid'];
		if($row['mode']=="1"){
			$modes=1;
		}else if($row['mode']=="2"){
			$modes=0.1;
		}

		if($mid=="400" || $mid=="420" || $mid=="440" || $mid=="460"){//5星
			$stra=explode("|",$row['codes']);
			$nums=0;
			for ($i=0; $i<count($stra); $i++) {
				$strb=explode("&",$stra[$i]);
				for ($ii=0; $ii<count($strb); $ii++) {
					if($strb[$ii]==$na[$i]){$nums=$nums+1;}
				}
			}
			if($nums==5){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");	
				echo "1";					
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");	
			}
		}else if($mid=="401" || $mid=="421" || $mid=="441" || $mid=="461"){//前四
			$stra=explode("|",$row['codes']);
			$nums=0;
			for ($i=0; $i<count($stra); $i++) {
				$strb=explode("&",$stra[$i]);
				for ($ii=0; $ii<count($strb); $ii++) {
					if($strb[$ii]==$na[$i]){$nums=$nums+1;}
				}
			}
			if($nums==4){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="402" || $mid=="422" || $mid=="442" || $mid=="462"){//后四
			$stra=explode("|",$row['codes']);
			$nums=0;
			for ($i=0; $i<count($stra); $i++) {
				$strb=explode("&",$stra[$i]);
				for ($ii=0; $ii<count($strb); $ii++) {
					if($strb[$ii]==$na[$i+1]){$nums=$nums+1;}
				}
			}
			if($nums==4){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="403" || $mid=="423" || $mid=="443" || $mid=="463"){//中三
			if($row['type']=="input"){//单式
				$cs=$n2.$n3.$n4;
				if(strpos($row['codes'],$cs)===false){
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");
				}else{
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");
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
				if($nums==3){
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");						
				}else{
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
				}
			}
		}else if($mid=="404" || $mid=="424" || $mid=="444" || $mid=="464"){//中三和值
			$zt=2;
			$cs=$n2+$n3+$n4;
			$stra=explode("&",$row['codes']);
			for ($i=0; $i<count($stra); $i++) {
				if($stra[$i]==$cs){
					$zt=1;
					break;
				}
			}
			if($zt=="1"){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");		
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="405" || $mid=="425" || $mid=="445" || $mid=="465"){//中组三
			$nums=0;
			if($n2==$n3 || $n2==$n4 || $n3==$n4){
				$stra=explode("&",$row['codes']);
				for ($i=0; $i<count($stra); $i++) {
					if($stra[$i]==$n2 || $stra[$i]==$n3 || $stra[$i]==$n4){$nums=$nums+1;}
				}
			}
			if($nums>=2){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="406" || $mid=="426" || $mid=="446" || $mid=="466"){//中组六
			$nums=0;
//			if($n2!=$n3 && $n2!=$n4 && $n3!=$n4){
				$stra=explode("&",$row['codes']);
				for ($i=0; $i<count($stra); $i++) {
					if($stra[$i]==$n2 || $stra[$i]==$n3 || $stra[$i]==$n4){$nums=$nums+1;}
				}
//			}
			if($nums>=3){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="407" || $mid=="427" || $mid=="447" || $mid=="467"){//中三组选，混合 inputok 168时时乐混合组选 298 3d 326p3
			$zt=2;
			if(strpos($row['codes'],$n2.$n3.$n4)===false && strpos($row['codes'],$n2.$n4.$n3)===false && strpos($row['codes'],$n3.$n2.$n4)===false && strpos($row['codes'],$n3.$n4.$n2)===false && strpos($row['codes'],$n4.$n2.$n3)===false && strpos($row['codes'],$n4.$n3.$n2)===false){
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");
			}else{
				$rates=explode(";",Get_rate($mid));
				if($n2==$n3 || $n2==$n4 || $n3==$n4){//组三
					mysql_query("update ssc_bills set zt=".$signa.",prize=".(floor(($rates[0]*$ratea)/18+0.00001)/100*$modes)."*times where id='".$row['id']."'");
				}else{
					mysql_query("update ssc_bills set zt=".$signa.",prize=".(floor(($rates[1]*$ratea)/18+0.00001)/100*$modes)."*times where id='".$row['id']."'");
				}
			}
		}else if($mid=="408" || $mid=="428" || $mid=="448" || $mid=="468"){//中三组合值
			$zt=2;
			$cs=$n2+$n3+$n4;
			$stra=explode("&",$row['codes']);
			for ($i=0; $i<count($stra); $i++) {
				if($stra[$i]==$cs){
					$zt=1;
					break;
				}
			}
			if($zt=="1"){
				$rates=explode(";",Get_rate($mid));			
				if($n2==$n3 || $n2==$n4 || $n3==$n4){//组3
					mysql_query("update ssc_bills set zt=".$signa.",prize=".(floor(($rates[0]*$ratea)/18+0.00001)/100*$modes)."*times where id='".$row['id']."'");
				}else{
					mysql_query("update ssc_bills set zt=".$signa.",prize=".(floor(($rates[1]*$ratea)/18+0.00001)/100*$modes)."*times where id='".$row['id']."'");				
				}
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="409" || $mid=="429" || $mid=="449" || $mid=="469"){//百家乐
			$na1a="zzz";
			$na2a="zzz";
			$na3a="zzz";
			$na4a="zzz";
			$na1b="zzz";
			$na2b="zzz";
			$na3b="zzz";
			$na4b="zzz";

			if($n1+$n2>$n4+$n5){$na1a="庄闲";}
			if($n1+$n2<$n4+$n5){$na1b="庄闲";}

			if($n1==$n2){$na2a="对子";}
			if($n4==$n5){$na2b="对子";}
			
			if($n1==$n2 && $n1==$n3){$na3a="豹子";}
			if($n3==$n4 && $n4==$n5){$na3b="豹子";}

			if($n1+$n2==8 || $n1+$n2==9){$na4a="天王";}
			if($n4+$n5==8 || $n4+$n5==9){$na4b="天王";}
			
			$stra=explode("|",$row['codes']);
			$numa=0;
			$strb=explode("&",$stra[0]);
			
			$rates=explode(";",Get_rate($mid));
			
			for ($ii=0; $ii<count($strb); $ii++) {
				if($strb[$ii]==$na1a){
					$numa=$numa+$rates[0];
				}else if($strb[$ii]==$na2a){
					$numa=$numa+$rates[1];
				}else if($strb[$ii]==$na3a){
					$numa=$numa+$rates[2];
				}else if($strb[$ii]==$na4a){
					$numa=$numa+$rates[3];
				}
			}
			$strb=explode("&",$stra[1]);
			for ($ii=0; $ii<count($strb); $ii++) {
				if($strb[$ii]==$na1b){
					$numa=$numa+$rates[0];
				}else if($strb[$ii]==$na2b){
					$numa=$numa+$rates[1];
				}else if($strb[$ii]==$na3b){
					$numa=$numa+$rates[2];
				}else if($strb[$ii]==$na4b){
					$numa=$numa+$rates[3];
				}
			}
			
//			$nums=$numa+$numb;
//			echo "zzzz".$numa;
			
			if($numa>0){
				mysql_query("update ssc_bills set zt=".$signa.",prize=".(floor(($numa*$ratea)/18+0.00001)/100*$modes)."*times where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="410" || $mid=="430" || $mid=="450" || $mid=="470"){//任三
			$stra=explode("|",$row['codes']);
			$nums=0;
			for ($i=0; $i<count($stra); $i++) {
				$strb=explode("&",$stra[$i]);
				for ($ii=0; $ii<count($strb); $ii++) {
					if($strb[$ii]==$na[$i]){$nums=$nums+1;}
				}
			}
			if($nums==3){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="411" || $mid=="431" || $mid=="451" || $mid=="471"){//任二
			$stra=explode("|",$row['codes']);
			$nums=0;
			for ($i=0; $i<count($stra); $i++) {
				$strb=explode("&",$stra[$i]);
				for ($ii=0; $ii<count($strb); $ii++) {
					if($strb[$ii]==$na[$i]){$nums=$nums+1;}
				}
			}
			if($nums==2){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
///////////////////////////////////////
		}else if($mid=="14" || $mid=="52" || $mid=="90" || $mid=="128" || $mid=="164" || $mid=="294" || $mid=="322"){//前三直选ok164时时乐2943d 322p3
			if($row['type']=="input"){//单式
				$cs=$n1.$n2.$n3;
				if(strpos($row['codes'],$cs)===false){
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");
				}else{
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");
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
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");						
				}else{
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
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
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");		
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="16" || $mid=="54" || $mid=="92" || $mid=="130"){//后三直选
			if($row['type']=="input"){//单式
				$cs=$n3.$n4.$n5;
				if(strpos($row['codes'],$cs)===false){
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");
				}else{
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");
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
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");						
				}else{
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
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
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");		
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
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
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
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
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="20" || $mid=="58" || $mid=="96" || $mid=="134" || $mid=="168" || $mid=="298" || $mid=="326"){//前三组选，混合 inputok 168时时乐混合组选 298 3d 326p3
			$zt=2;
			if(strpos($row['codes'],$n1.$n2.$n3)===false && strpos($row['codes'],$n1.$n3.$n2)===false && strpos($row['codes'],$n2.$n1.$n3)===false && strpos($row['codes'],$n2.$n3.$n1)===false && strpos($row['codes'],$n3.$n1.$n2)===false && strpos($row['codes'],$n3.$n2.$n1)===false){
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");					
			}else{
				$rates=explode(";",Get_rate($mid));
				if($n1==$n2 || $n1==$n3 || $n2==$n3){//组三
					mysql_query("update ssc_bills set zt=".$signa.",prize=".($rates[0]*$modes)."*times where id='".$row['id']."'");										
				}else{				
					mysql_query("update ssc_bills set zt=".$signa.",prize=".($rates[1]*$modes)."*times where id='".$row['id']."'");						
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
					mysql_query("update ssc_bills set zt=".$signa.",prize=".($rates[0]*$modes)."*times where id='".$row['id']."'");
				}else{
					mysql_query("update ssc_bills set zt=".$signa.",prize=".($rates[1]*$modes)."*times where id='".$row['id']."'");				
				}
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
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
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
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
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}		
		}else if($mid=="24" || $mid=="62" || $mid=="100" || $mid=="138"){//后三组混合
			$zt=2;
			if(strpos($row['codes'],$n3.$n4.$n5)===false && strpos($row['codes'],$n3.$n5.$n4)===false && strpos($row['codes'],$n4.$n3.$n5)===false && strpos($row['codes'],$n4.$n5.$n3)===false && strpos($row['codes'],$n5.$n3.$n4)===false && strpos($row['codes'],$n5.$n4.$n3)===false){
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");					
			}else{
				$rates=explode(";",Get_rate($mid));
				if($n3==$n4 || $n3==$n5 || $n4==$n5){//组三
					mysql_query("update ssc_bills set zt=".$signa.",prize=".($rates[0]*$modes)."*times where id='".$row['id']."'");										
				}else{				
					mysql_query("update ssc_bills set zt=".$signa.",prize=".($rates[1]*$modes)."*times where id='".$row['id']."'");						
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
					mysql_query("update ssc_bills set zt=".$signa.",prize=".($rates[0]*$modes)."*times where id='".$row['id']."'");
				}else{
					mysql_query("update ssc_bills set zt=".$signa.",prize=".($rates[1]*$modes)."*times where id='".$row['id']."'");				
				}		
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}		
		}else if($mid=="26" || $mid=="64" || $mid=="102" || $mid=="140"){//一码不定位ok
			$nums=0;
			$stra=explode("&",$row['codes']);
			for ($i=0; $i<count($stra); $i++) {
				if($stra[$i]==$n3 || $stra[$i]==$n4 || $stra[$i]==$n5){$nums=$nums+1;}
			}
			if($nums>=1){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$nums." where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="27" || $mid=="65" || $mid=="103" || $mid=="141"){//二码不定位ok
			$nums=0;
			$stra=explode("&",$row['codes']);
			for ($i=0; $i<count($stra); $i++) {
				if($stra[$i]==$n3 || $stra[$i]==$n4 || $stra[$i]==$n5){$nums=$nums+1;}
			}
			if($nums==2){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");						
			}else if($nums==3){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*3 where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="28" || $mid=="66" || $mid=="104" || $mid=="142" || $mid=="172" || $mid=="302" || $mid=="330"){//前二直选 172时时乐前2直 302 3d 330p3
			if($row['type']=="input"){//单式
				$cs=$n1.$n2;
				$pos= strpos($row['codes'],$cs);
				if(strpos($row['codes'],$cs)===false){
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");
				}else{
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");
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
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");						
				}else{
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
				}
			}		
		}else if($mid=="29" || $mid=="67" || $mid=="105" || $mid=="143" || $mid=="331"){//后二直选 331p3
			if($row['type']=="input"){//单式
				$cs=$n4.$n5;
				if(strpos($row['codes'],$cs)===false){
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");
				}else{
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");
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
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");						
				}else{
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
				}
			}		
		}else if($mid=="30" || $mid=="68" || $mid=="106" || $mid=="144" || $mid=="174" || $mid=="304" || $mid=="332"){//前二组选 174时时乐前二组 304 3d 332p3
			if($row['type']=="input"){//单式
				if(strpos($row['codes'],$n1.$n2)===false && strpos($row['codes'],$n2.$n1)===false){
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");					
				}else{
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");						
				}
			}else{
				$nums=0;
				$stra=explode("&",$row['codes']);
				for ($i=0; $i<count($stra); $i++) {
					if($stra[$i]==$n1 || $stra[$i]==$n2){$nums=$nums+1;}
				}
				if($nums>=2){
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");						
				}else{
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
				}
			}
		}else if($mid=="31" || $mid=="69" || $mid=="107" || $mid=="145" || $mid=="333"){//后二组选 333p3
			if($row['type']=="input"){//单式
				if(strpos($row['codes'],$n4.$n5)===false && strpos($row['codes'],$n5.$n4)===false){
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");					
				}else{
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");						
				}			
			}else{
				$nums=0;
				$stra=explode("&",$row['codes']);
				for ($i=0; $i<count($stra); $i++) {
					if($stra[$i]==$n4 || $stra[$i]==$n5){$nums=$nums+1;}
				}
				if($nums>=2){
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");						
				}else{
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
				}
			}
//		}else if($mid=="32" || $mid=="70" || $mid=="108" || $mid=="146" || $mid=="176" || $mid=="306" || $mid=="334"){//定位胆ok 176时时乐 306 3d 334 p3 
//			$stra=explode("|",$row['codes']);
//			$nums=0;
//			for ($i=0; $i<count($stra); $i++) {
//				$strb=explode("&",$stra[$i]);
//				for ($ii=0; $ii<count($strb); $ii++) {
//					if($strb[$ii]==$na[$i]){$nums=$nums+1;}
//				}
//			}
//			if($nums>=1){
//				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$nums." where id='".$row['id']."'");						
//			}else{
//				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
//			}
		}else if($mid=="32" || $mid=="70" || $mid=="108" || $mid=="146" || $mid=="176" || $mid=="306" || $mid=="334"){//定位胆ok 176时时乐 306 3d 334 p3  万位
			$nums=0;
			$strb=explode("&",$row['codes']);
			for ($ii=0; $ii<count($strb); $ii++) {
				if($strb[$ii]==$n1){$nums=$nums+1;}
			}
			
			if($nums>=1){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="33" || $mid=="71" || $mid=="109" || $mid=="147" || $mid=="177" || $mid=="307" || $mid=="335"){//定位胆ok 176时时乐 306 3d 334 p3 
			$nums=0;
			$strb=explode("&",$row['codes']);
			for ($ii=0; $ii<count($strb); $ii++) {
				if($strb[$ii]==$n2){$nums=$nums+1;}
			}
			
			if($nums>=1){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="34" || $mid=="72" || $mid=="110" || $mid=="148" || $mid=="178" || $mid=="308" || $mid=="336"){//定位胆ok 176时时乐 306 3d 334 p3 
			$nums=0;
			$strb=explode("&",$row['codes']);
			for ($ii=0; $ii<count($strb); $ii++) {
				if($strb[$ii]==$n3){$nums=$nums+1;}
			}
			
			if($nums>=1){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="35" || $mid=="73" || $mid=="111" || $mid=="149" || $mid=="337"){//定位胆ok 176时时乐 306 3d 334 p3 
			$nums=0;
			$strb=explode("&",$row['codes']);
			for ($ii=0; $ii<count($strb); $ii++) {
				if($strb[$ii]==$n4){$nums=$nums+1;}
			}
			
			if($nums>=1){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="36" || $mid=="74" || $mid=="112" || $mid=="150" || $mid=="338"){//定位胆ok 176时时乐 306 3d 334 p3 
			$nums=0;
			$strb=explode("&",$row['codes']);
			for ($ii=0; $ii<count($strb); $ii++) {
				if($strb[$ii]==$n5){$nums=$nums+1;}
			}
			
			if($nums>=1){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="37" || $mid=="75" || $mid=="113" || $mid=="151" || $mid=="179" || $mid=="309" || $mid=="339"){//前二大小单双 179时时乐 309 3d 335 p3
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
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$nums." where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="38" || $mid=="76" || $mid=="114" || $mid=="152" || $mid=="340"){//后二大小单双ok 336 p3
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
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$nums." where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
		}else if($mid=="170" || $mid=="300" || $mid=="328"){//时时乐一码不定位ok 300 3d 328 p3
			$nums=0;
			$stra=explode("&",$row['codes']);
			for ($i=0; $i<count($stra); $i++) {
				if($stra[$i]==$n1 || $stra[$i]==$n2 || $stra[$i]==$n3){$nums=$nums+1;}
			}
			if($nums>=1){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$nums." where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="171" || $mid=="301" || $mid=="329"){//时时乐二码不定位ok 301 3d 329 p3
			$nums=0;
			$stra=explode("&",$row['codes']);
			for ($i=0; $i<count($stra); $i++) {
				if($stra[$i]==$n1 || $stra[$i]==$n2 || $stra[$i]==$n3){$nums=$nums+1;}
			}
			if($nums==2){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");						
			}else if($nums==3){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*3 where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}
		}else if($mid=="173" || $mid=="303"){//时时乐后二直选 303 3d
			if($row['type']=="input"){//单式
				$cs=$n2.$n3;
				if(strpos($row['codes'],$cs)===false){
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");
				}else{
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");
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
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");						
				}else{
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
				}
			}				
		}else if($mid=="175" || $mid=="305"){//时时乐后二组选 305 3d
			if($row['type']=="input"){//单式
				if(strpos($row['codes'],$n2.$n3)===false && strpos($row['codes'],$n3.$n2)===false){
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");					
				}else{
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");						
				}			
			}else{
				$nums=0;
				$stra=explode("&",$row['codes']);
				for ($i=0; $i<count($stra); $i++) {
					if($stra[$i]==$n2 || $stra[$i]==$n3){$nums=$nums+1;}
				}
				if($nums>=2){
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");						
				}else{
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
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
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$nums." where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
			}			
			/
		}else if($mid=="197" || $mid=="231" || $mid=="265" || $mid=="357"){//115前三直选
			if($row['type']=="input"){//单式
				$cs=sprintf("%02d",$n1)." ".sprintf("%02d",$n2)." ".sprintf("%02d",$n3);
				$pos= strpos($row['codes'],$cs);
				if(strpos($row['codes'],$cs)===false){
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");
				}else{
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");
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
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");						
				}else{
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
				}
			}
		}else if($mid=="198" || $mid=="232" || $mid=="266" || $mid=="358"){//115前三组选
			if($row['type']=="input"){//单式
				$zt=2;
				if(strpos($row['codes'],sprintf("%02d",$n1)." ".sprintf("%02d",$n2)." ".sprintf("%02d",$n3))===false && strpos($row['codes'],sprintf("%02d",$n1)." ".sprintf("%02d",$n3)." ".sprintf("%02d",$n2))===false && strpos($row['codes'],sprintf("%02d",$n2)." ".sprintf("%02d",$n1)." ".sprintf("%02d",$n3))===false && strpos($row['codes'],sprintf("%02d",$n2)." ".sprintf("%02d",$n3)." ".sprintf("%02d",$n1))===false && strpos($row['codes'],sprintf("%02d",$n3)." ".sprintf("%02d",$n1)." ".sprintf("%02d",$n2))===false && strpos($row['codes'],sprintf("%02d",$n3)." ".sprintf("%02d",$n2)." ".sprintf("%02d",$n1))===false){
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");					
				}else{
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");										
				}
			}else{
				$nums=0;
				$stra=explode("&",$row['codes']);
				for ($i=0; $i<count($stra); $i++) {
					if($stra[$i]==sprintf("%02d",$n1) || $stra[$i]==sprintf("%02d",$n2) || $stra[$i]==sprintf("%02d",$n3)){$nums=$nums+1;}
				}
				if($nums>=3){
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");						
				}else{
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
				}
			}
		}else if($mid=="199" || $mid=="233" || $mid=="267" || $mid=="359"){//115前二直选
			if($row['type']=="input"){//单式
				$cs=sprintf("%02d",$n1)." ".sprintf("%02d",$n2);
				if(strpos($row['codes'],$cs)===false){
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");
				}else{
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");
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
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");						
				}else{
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
				}
			}
		}else if($mid=="200" || $mid=="234" || $mid=="268" || $mid=="360"){//115前二组选
			if($row['type']=="input"){//单式
				if(strpos($row['codes'],sprintf("%02d",$n1)." ".sprintf("%02d",$n2))===false && strpos($row['codes'],sprintf("%02d",$n2)." ".sprintf("%02d",$n1))===false){
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");					
				}else{
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");						
				}
			}else{
				$nums=0;
				$stra=explode("&",$row['codes']);
				for ($i=0; $i<count($stra); $i++) {
					if($stra[$i]==sprintf("%02d",$n1) || $stra[$i]==sprintf("%02d",$n2)){$nums=$nums+1;}
				}
				if($nums>=2){
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");						
				}else{
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
				}
			}
		}else if($mid=="201" || $mid=="235" || $mid=="269" || $mid=="361"){//115前三不定位ok
			$nums=0;
			$stra=explode("&",$row['codes']);
			for ($i=0; $i<count($stra); $i++) {
				if($stra[$i]==sprintf("%02d",$n1) || $stra[$i]==sprintf("%02d",$n2) || $stra[$i]==sprintf("%02d",$n3)){$nums=$nums+1;}
			}
			if($nums>=1){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$nums." where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
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
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$nums." where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
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
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");
			}else{
				mysql_query("update ssc_bills set zt=".$signa.",prize=".($rates[$numa]*$modes)."*times where id='".$row['id']."'");
			}
		}else if($mid=="206" || $mid=="240" || $mid=="274" || $mid=="367"){//猜中位
			$rates=explode(";",Get_rate($mid));
			$nums=$nb[2];
			if(strpos($row['codes'],strval($nums))===false){//字符类型转换
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");
			}else{
				if($nums>6){
					$nums=12-$nums;
				}
			echo $nums;
				mysql_query("update ssc_bills set zt=".$signa.",prize=".($rates[$nums-3]*$modes)."*times where id='".$row['id']."'");
			}
			echo $nb[2];
		}else if($mid=="207" || $mid=="241" || $mid=="275" || $mid=="368"){//任选1中1
			$nums=0;
			$stra=explode("&",$row['codes']);
			for ($i=0; $i<count($stra); $i++) {
				if($stra[$i]==sprintf("%02d",$n1) || $stra[$i]==sprintf("%02d",$n2) || $stra[$i]==sprintf("%02d",$n3) || $stra[$i]==sprintf("%02d",$n4) || $stra[$i]==sprintf("%02d",$n5)){$nums=$nums+1;}
			}
			if($nums>=1){
				mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$nums." where id='".$row['id']."'");						
			}else{
				mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
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
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$nums." where id='".$row['id']."'");						
				}else{
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
				}
			}else{
				$nums=0;
				$stra=explode("&",$row['codes']);
				for ($i=0; $i<count($stra); $i++) {
					if($stra[$i]==sprintf("%02d",$n1) || $stra[$i]==sprintf("%02d",$n2) || $stra[$i]==sprintf("%02d",$n3) || $stra[$i]==sprintf("%02d",$n4) || $stra[$i]==sprintf("%02d",$n5)){$nums=$nums+1;}
				}
				if($nums>=2){
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".($nums*($nums-1)/2)." where id='".$row['id']."'");						
				}else{
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
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
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$nums." where id='".$row['id']."'");						
				}else{
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
				}
			}else{
				$nums=0;
				$stra=explode("&",$row['codes']);
				for ($i=0; $i<count($stra); $i++) {
					if($stra[$i]==sprintf("%02d",$n1) || $stra[$i]==sprintf("%02d",$n2) || $stra[$i]==sprintf("%02d",$n3) || $stra[$i]==sprintf("%02d",$n4) || $stra[$i]==sprintf("%02d",$n5)){$nums=$nums+1;}
				}
				if($nums>=3){
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".($nums*($nums-1)*($nums-2)/6)." where id='".$row['id']."'");						
				}else{
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
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
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$nums." where id='".$row['id']."'");						
				}else{
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
				}
			}else{
				$nums=0;
				$stra=explode("&",$row['codes']);
				for ($i=0; $i<count($stra); $i++) {
					if($stra[$i]==sprintf("%02d",$n1) || $stra[$i]==sprintf("%02d",$n2) || $stra[$i]==sprintf("%02d",$n3) || $stra[$i]==sprintf("%02d",$n4) || $stra[$i]==sprintf("%02d",$n5)){$nums=$nums+1;}
				}
				if($nums>=4){
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".($nums*($nums-1)*($nums-2)*($nums-3)/24)." where id='".$row['id']."'");
				}else{
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
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
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$nums." where id='".$row['id']."'");						
				}else{
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
				}
			}else{
				$nums=0;
				$stra=explode("&",$row['codes']);
				for ($i=0; $i<count($stra); $i++) {
					if($stra[$i]==sprintf("%02d",$n1) || $stra[$i]==sprintf("%02d",$n2) || $stra[$i]==sprintf("%02d",$n3) || $stra[$i]==sprintf("%02d",$n4) || $stra[$i]==sprintf("%02d",$n5)){$nums=$nums+1;}
				}
				if($nums>=5){
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");
				}else{
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
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
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times*".$nums." where id='".$row['id']."'");						
				}else{
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");		
				}
			}else{
				$nums=0;
				$stra=explode("&",$row['codes']);
				for ($i=0; $i<count($stra); $i++) {
					if($stra[$i]==sprintf("%02d",$n1) || $stra[$i]==sprintf("%02d",$n2) || $stra[$i]==sprintf("%02d",$n3) || $stra[$i]==sprintf("%02d",$n4) || $stra[$i]==sprintf("%02d",$n5)){$nums=$nums+1;}
				}
				if($nums>=5){
					mysql_query("update ssc_bills set zt=".$signa.",prize=rates*times where id='".$row['id']."'");
				}else{
					mysql_query("update ssc_bills set zt=".$signb.",prize=0 where id='".$row['id']."'");	
				}
			}

		}
		
		if($sign==1){
			$sqls="update ssc_bills set kjcode='".$kjcode."' where id ='".$row['id']."'";
			$rss=mysql_query($sqls) or  die("数据库修改出错1".mysql_error());
			
			$sqls="select * from ssc_bills where id ='".$row['id']."'";
			$rss=mysql_query($sqls) or  die("数据库修改出错1".mysql_error());
			$rows = mysql_fetch_array($rss);
			
			if($rows['regfrom']!=""){
				$sqla = "select * from ssc_class where mid='".$mid."'";
				$rsa = mysql_query($sqla);
				$rowa = mysql_fetch_array($rsa);
				$sstri=$rowa['sid'];
				
				$sqlb = "select * from ssc_member where username='" . $rows['username'] . "'";
				$rsb = mysql_query($sqlb);
				$rowb = mysql_fetch_array($rsb);
		
				$sstra=explode(";",$rowb['rebate']);	
				$sstrb=explode(",",$sstra[$sstri-1]);
				$sstrp=$sstrb[1];
				
				$regfrom=explode("&&",$rows['regfrom']);
				for ($ia=0; $ia<count($regfrom); $ia++) {
											
					$susername=str_replace("&","",$regfrom[$ia]);
					$sqla = "select * from ssc_member where username='".$susername."'";
					$rsa = mysql_query($sqla);
					$rowa = mysql_fetch_array($rsa);
					$sstra=explode(";",$rowa['rebate']);
											
					$sstrb=explode(",",$sstra[$sstri-1]);
					$sstrc=explode("_",$rstrb[0]);
					if(($sstrb[1]-$sstrp)>0){
									
						$sqla = "select * from ssc_record order by id desc limit 1";
						$rsa = mysql_query($sqla);
						$rowa = mysql_fetch_array($rsa);
						$dan1 = sprintf("%07s",strtoupper(base_convert($rowa['id']+1,10,36)));
						$sqla="insert into ssc_record set lotteryid='".$rows['lotteryid']."', lottery='".$rows['lottery']."', dan='".$dan1."', dan1='".$dan."', uid='".Get_memid($susername)."', username='".$susername."', issue='".$rows['issue']."', types='11', mid='".$rows['mid']."', mode='".$rows['mode']."', smoney=".($rows['money']*($sstrb[1]-$sstrp)/100).",leftmoney=".(Get_mmoneys($susername)+$rows['money']*($sstrb[1]-$sstrp)/100).", cont='".$rows['cont']."', regtop='".$rowa['regtop']."', regup='".$rowa['regup']."', regfrom='".$rowa['regfrom']."', adddate='".date("Y-m-d H:i:s")."'";
		//								echo $smoney."___".($sstrb[1]-$sstrp);
						$exe=mysql_query($sqla) or  die("数据库修改出错4!!!".mysql_error());
					
						$sqla="update ssc_member set leftmoney=leftmoney+".($rows['money']*($sstrb[1]-$sstrp)/100)." where username='".$susername."'"; 
						$exe=mysql_query($sqla) or  die("数据库修改出错12!!!".mysql_error());
						$sstrp=$sstrb[1];
					}
				}
			}	
			
			
			
			if($rows['zt']==1){	
				$sqla = "select * from ssc_record order by id desc limit 1";
				$rsa = mysql_query($sqla);
				$rowa = mysql_fetch_array($rsa);
				$dan1 = sprintf("%07s",strtoupper(base_convert($rowa['id']+1,10,36)));
				$lmoney = Get_mmoney($rows['uid'])+$rows['prize'];
				$sqla="insert into ssc_record set lotteryid='".$rows['lotteryid']."', lottery='".$rows['lottery']."', dan='".$dan1."', dan1='".$rows['dan']."', dan2='".$rows['dan1']."', uid='".$rows['uid']."', username='".$rows['username']."', issue='".$rows['issue']."', types='12', mid='".$rows['mid']."', codes='".$rows['codes']."', mode='".$rows['mode']."', smoney=".$rows['prize'].",leftmoney=".$lmoney.", cont='".$rows['cont']."', regtop='".$rows['regtop']."', regup='".$rows['regup']."', regfrom='".$rows['regfrom']."', adddate='".date("Y-m-d H:i:s")."'";
				$exe=mysql_query($sqla) or  die("数据库修改出错!!!".mysql_error());
				
				$sqla="update ssc_member set leftmoney=".$lmoney." where id='".$rows['uid']."'"; 
				$exe=mysql_query($sqla) or  die("数据库修改出错!!!".mysql_error());
				
				if($rows['dan1']!=""){
					$sqla = "update ssc_zbills set prize=prize+".$rows['prize'].", zjnums=zjnums+1 where dan='".$rows['dan1']."'";
					$rsa = mysql_query($sqla);
				}
				
				if($rows['autostop']=="yes"){//多余转结
					//
					$sqla="select sum(money) as tmoney,count(*) as cnums from ssc_zdetail where zt=0 and dan='".$rows['dan1']."'";
					$rsa = mysql_query($sqla);
					$rowa = mysql_fetch_array($rsa);
					$ttm=$rowa['tmoney'];
					if($ttm>0){
						$sqla = "update ssc_zbills set cnums=cnums+".$rowa['cnums'].", cmoney=cmoney+".$ttm." where dan='".$rows['dan1']."'";
						$rsa = mysql_query($sqla);

						$sqla = "select * from ssc_record order by id desc limit 1";
						$rsa = mysql_query($sqla);
						$rowa = mysql_fetch_array($rsa);
						$dan1 = sprintf("%07s",strtoupper(base_convert($rowa['id']+1,10,36)));//追号返款
						$sqla="insert into ssc_record set lotteryid='".$rows['lotteryid']."', lottery='".$rows['lottery']."', dan='".$dan1."', dan2='".$rows['dan1']."', uid='".$rows['uid']."', username='".$rows['username']."', issue='".$rows['issue']."', types='10', mid='".$rows['mid']."', codes='".$rows['codes']."', mode='".$rows['mode']."', smoney=".$ttm.",leftmoney=".($lmoney+$ttm).", cont='".$rows['cont']."', regtop='".$rows['regtop']."', regup='".$rows['regup']."', regfrom='".$rows['regfrom']."', adddate='".date("Y-m-d H:i:s")."'";
						$exe=mysql_query($sqla) or  die("数据库修改出错9!!!".mysql_error());

						$sqla="update ssc_member set leftmoney=".($lmoney+$ttm)." where id='".$rows['uid']."'"; 
						$exe=mysql_query($sqla) or  die("数据库修改出错!!!".mysql_error());
						
						
					}
					
					$sqla="update ssc_zdetail set zt=2 where dan='".$rows['dan1']."' and zt=0"; 
					$exe=mysql_query($sqla) or  die("数据库修改出错!!!".mysql_error());
				}
			}
		}
	}
	//
//	echo "zzz";
	if($sign==0){
		$sqlb="update ssc_data set zt=2 where id ='".$rowz['id']."'";
		$rsb=mysql_query($sqlb) or  die("数据库修改出错1".mysql_error());
	
		$sqlb="select SUM(IF(types = 1, smoney, 0)) as t1,SUM(IF(types = 2, zmoney, 0)) as t2,SUM(IF(types = 3, smoney, 0)) as t3,SUM(IF(types = 7, zmoney, 0)) as t7,SUM(IF(types = 11, smoney, 0)) as t11,SUM(IF(types = 12, smoney, 0)) as t12,SUM(IF(types = 13, smoney, 0)) as t13,SUM(IF(types = 15, zmoney, 0)) as t15,SUM(IF(types = 16, zmoney, 0)) as t16,SUM(IF(types = 32, smoney, 0)) as t32,SUM(IF(types = 40, smoney, 0)) as t40 from ssc_record where lotteryid='".$lid."' and issue='".$issue."'";
		$rsb = mysql_query($sqlb);
		$rowb = mysql_fetch_array($rsb);

		$sqlc="select SUM(prize) as zj from ssc_bills where lotteryid='".$lid."' and issue='".$issue."'";
		$rsc = mysql_query($sqlc);
		$rowc = mysql_fetch_array($rsc);

		$sqld="insert into ssc_info set lotteryid='".$lid."', lottery='".Get_lottery($lid)."', issue='".$issue."', tz='".($rowb['t7']-$rowb['t13'])."', fd='".($rowb['t11']-$rowb['t15'])."', zj='".$rowc['zj']."', adddate='".date("Y-m-d H:i:s")."'";
		$exe=mysql_query($sqld) or  die("数据库修改出错!!!".mysql_error());
		
	}else if($sign==1){//计分红 zh
		$sqlb="update ssc_data set zt=1 where id ='".$rowz['id']."'";
		$rsb=mysql_query($sqlb) or  die("数据库修改出错1".mysql_error());

		//转zh
		$issueb=dlid(intval(ddlid($issue,$lid))+1,$lid);
		$sqlb="select * from ssc_zdetail where lotteryid='".$lid."' and issue='".$issueb."' and zt=0";
		$rsb = mysql_query($sqlb);
		while ($rowb = mysql_fetch_array($rsb)){
			$sqla = "update ssc_zbills set fnums=fnums+1, fmoney=fmoney+".$rowb['money']." where dan='".$rowb['dan']."'";
			$rsa = mysql_query($sqla);
		
			$sql = "select * from ssc_member where username='" . $rowb['username'] . "'";
			$rs = mysql_query($sql);
			$row = mysql_fetch_array($rs);
			$lmoney=$row['leftmoney'];

			$sstra=explode(";",$row['rebate']);	
			$sstrb=explode(",",$sstra[$sstri-1]);
			$spoints=$sstrb[1]/100;
		
			if($rowb['mid']=="20" || $rowb['mid']=="21" || $rowb['mid']=="24" || $rowb['mid']=="25" || $rowb['mid']=="58" || $rowb['mid']=="59" || $rowb['mid']=="62" || $rowb['mid']=="63" || $rowb['mid']=="96" || $rowb['mid']=="97" || $rowb['mid']=="100" || $rowb['mid']=="101" || $rowb['mid']=="134" || $rowb['mid']=="135" || $rowb['mid']=="138" || $rowb['mid']=="139" || $rowb['mid']=="168" || $rowb['mid']=="169" || $rowb['mid']=="205" || $rowb['mid']=="206" || $rowb['mid']=="239" || $rowb['mid']=="240" || $rowb['mid']=="273" || $rowb['mid']=="274" || $rowb['mid']=="298" || $rowb['mid']=="299" || $rowb['mid']=="326" || $rowb['mid']=="327" || $rowb['mid']=="366" || $rowb['mid']=="367"){//point处理
				$spoint=$spoints;
			}else{
				$spoint=$rowb['point'];
			}
		
			$sqla = "select * from ssc_record order by id desc limit 1";
			$rsa = mysql_query($sqla);
			$rowa = mysql_fetch_array($rsa);
			$dan1 = sprintf("%07s",strtoupper(base_convert($rowa['id']+1,10,36)));//追号返款
			$sqla="insert into ssc_record set lotteryid='".$rowb['lotteryid']."', lottery='".$rowb['lottery']."', dan='".$dan1."', dan2='".$rowb['dan']."', uid='".$rowb['uid']."', username='".$rowb['username']."', issue='".$rowb['issue']."', types='10', mid='".$rowb['mid']."', codes='".$rowb['codes']."', mode='".$rowb['mode']."', smoney=".$rowb['money'].",leftmoney=".($lmoney+$rowb['money']).", cont='".$rowb['cont']."', regtop='".$rowb['regtop']."', regup='".$rowb['regup']."', regfrom='".$rowb['regfrom']."', adddate='".date("Y-m-d H:i:s")."'";
			$exe=mysql_query($sqla) or  die("数据库修改出错9!!!".mysql_error());

			$sqla = "select * from ssc_bills order by id desc limit 1";
			$rsa = mysql_query($sqla);
			$rowa = mysql_fetch_array($rsa);
			$dan2 = sprintf("%06s",strtoupper(base_convert($rowa['id']+1,10,36)));//转注单
						
			$sqla="INSERT INTO ssc_bills set lotteryid='".$rowb['lotteryid']."', lottery='".$rowb['lottery']."', dan='".$dan2."', dan1='".$rowb['dan']."', uid='".$rowb['uid']."', username='".$rowb['username']."', issue='".$rowb['issue']."', type='".$rowb['type']."', mid='".$rowb['mid']."', codes='".$rowb['codes']."', nums='".$rowb['nums']."', times='".$rowb['times']."', money='".$rowb['money']."', mode='".$rowb['mode']."', rates='".$rowb['rates']."', point='".$rowb['point']."', cont='".$rowb['cont']."', regtop='".$rowb['regtop']."', regup='".$rowb['regup']."', regfrom='".$rowb['regfrom']."', userip='".$rowb['userip']."', adddate='".date("Y-m-d H:i:s")."', canceldead='".$rowb['canceldead']."', autostop='".$rowb['autostop']."'";
			$exe=mysql_query($sqla) or  die("数据库修改出错10!!!!".mysql_error());
			
			$sqla = "update ssc_zdetail set danb='".$dan2."', zt=1 where id='".$rowb['id']."'";
			$rsa = mysql_query($sqla);
						
			$sqla = "select * from ssc_record order by id desc limit 1";
			$rsa = mysql_query($sqla);
			$rowa = mysql_fetch_array($rsa);
			$dan1 = sprintf("%07s",strtoupper(base_convert($rowa['id']+1,10,36)));//投注扣款
			$sqla="insert into ssc_record set lotteryid='".$rowb['lotteryid']."', lottery='".$rowb['lottery']."', dan='".$dan1."', dan1='".$dan2."', dan2='".$rowb['dan']."', uid='".$rowb['uid']."', username='".$rowb['username']."', issue='".$rowb['issue']."', types='7', mid='".$rowb['mid']."', codes='".$rowb['codes']."', mode='".$rowb['mode']."', zmoney=".$rowb['money'].",leftmoney=".$lmoney.", cont='".$rowb['cont']."', regtop='".$rowb['regtop']."', regup='".$rowb['regup']."', regfrom='".$rowb['regfrom']."', adddate='".date("Y-m-d H:i:s")."'";
			$exe=mysql_query($sqla) or  die("数据库修改出错11!!!".mysql_error());
			
			if($spoint!="0"){
				$sqla = "select * from ssc_record order by id desc limit 1";
				$rsa = mysql_query($sqla);
				$rowa = mysql_fetch_array($rsa);
				$dan1 = sprintf("%07s",strtoupper(base_convert($rowa['id']+1,10,36)));
				$sqla="insert into ssc_record set lotteryid='".$rowb['lotteryid']."', lottery='".$rowb['lottery']."', dan='".$dan1."', dan1='".$dan2."', dan2='".$rowb['dan']."', uid='".$rowb['uid']."', username='".$rowb['username']."', issue='".$rowb['issue']."', types='11', mid='".$rowb['mid']."', codes='".$rowb['codes']."', mode='".$rowb['mode']."', smoney=".$rowb['money']*$spoint.",leftmoney=".($lmoney+$rowb['money']*$spoint).", cont='".$rowb['cont']."', regtop='".$rowb['regtop']."', regup='".$rowb['regup']."', regfrom='".$rowb['regfrom']."', adddate='".date("Y-m-d H:i:s")."'";
				$exe=mysql_query($sqla) or  die("数据库修改出错4!!!".mysql_error());

				$sqla="update ssc_member set leftmoney=".($lmoney+$rowb['money']*$spoint)." where username='".$rowb['username']."'"; 
				$exe=mysql_query($sqla) or  die("数据库修改出错12!!!".mysql_error());
			}
							//上级返点
				
//				if($rowb['regfrom']!=""){
//					$sstrp=$spoints*100;
//					$sqla = "select * from ssc_class where mid='".$rowb['mid']."'";
//					$rsa = mysql_query($sqla);
//					$rowa = mysql_fetch_array($rsa);
//					$sstri=$rowa['sid'];				
				
//					$regfrom=explode("&&",$rowb['regfrom']);
//					for ($ia=0; $ia<count($regfrom); $ia++) {
									
//						$susername=str_replace("&","",$regfrom[$ia]);
//						$sqla = "select * from ssc_member where username='".$susername."'";
//						$rsa = mysql_query($sqla);
//						$rowa = mysql_fetch_array($rsa);
//						$sstra=explode(";",$rowa['rebate']);
						
//						$sstrb=explode(",",$sstra[$sstri-1]);
//						$sstrc=explode("_",$rstrb[0]);
//						if(($sstrb[1]-$sstrp)>0){

//							$sqla = "select * from ssc_record order by id desc limit 1";
//							$rsa = mysql_query($sqla);
//							$rowa = mysql_fetch_array($rsa);
//							$dan1 = sprintf("%07s",strtoupper(base_convert($rowa['id']+1,10,36)));
//							$sqla="insert into ssc_record set lotteryid='".$rowb['lotteryid']."', lottery='".$rowb['lottery']."', dan='".$dan1."', dan1='".$dan2."', dan2='".$rowb['dan']."', uid='".Get_memid($susername)."', username='".$susername."', issue='".$rowb['issue']."', types='11', mid='".$rowb['mid']."', codes='".$rowb['codes']."', mode='".$rowb['mode']."', smoney=".($rowb['money']*($sstrb[1]-$sstrp)/100).",leftmoney=".(Get_mmoneys($susername)+$rowb['money']*($sstrb[1]-$sstrp)/100).", cont='".$rowb['cont']."', regtop='".$rowb['regtop']."', regup='".$rowb['regup']."', regfrom='".$rowb['regfrom']."', adddate='".date("Y-m-d H:i:s")."'";
//							$exe=mysql_query($sqla) or  die("数据库修改出错4!!!".mysql_error());
			
//							$sqla="update ssc_member set leftmoney=leftmoney+".($rowb['money']*($sstrb[1]-$sstrp)/100)." where username='".$susername."'"; 
//							$exe=mysql_query($sqla) or  die("数据库修改出错12!!!".mysql_error());
//							$sstrp=$sstrb[1];
//						}
//					}
//				}
		}
		
		$sqla="select * from ssc_zbills where lotteryid='".$lid."' and zt='0'";
		$rsa = mysql_query($sqla) or  die("数据库修改出错!!!".mysql_error());
		while ($rowa = mysql_fetch_array($rsa)){
			$sqlb="select * from ssc_zdetail where dan='".$rowa['dan']."' and zt='0'";
			$rsb = mysql_query($sqlb) or  die("数据库修改出错!!!".mysql_error());
			$total = mysql_num_rows($rsb);
			if($total==0){
				$sqlb="update ssc_zbills set zt='1' where dan='".$rowa['dan']."'"; 
				$exe=mysql_query($sqlb) or  die("数据库修改出错!!!".mysql_error());
			}
		}
		//分红
		$sqlb="select regtop, SUM(IF(types = 1, smoney, 0)) as t1,SUM(IF(types = 2, zmoney, 0)) as t2,SUM(IF(types = 3, smoney, 0)) as t3,SUM(IF(types = 7, zmoney, 0)) as t7,SUM(IF(types = 11, smoney, 0)) as t11,SUM(IF(types = 12, smoney, 0)) as t12,SUM(IF(types = 13, smoney, 0)) as t13,SUM(IF(types = 15, zmoney, 0)) as t15,SUM(IF(types = 16, zmoney, 0)) as t16,SUM(IF(types = 32, smoney, 0)) as t32,SUM(IF(types = 40, smoney, 0)) as t40 from ssc_record where lotteryid='".$lid."' and issue='".$issue."' group by regtop";
		$rsb = mysql_query($sqlb);
		while ($rowb = mysql_fetch_array($rsb)){
			if($rowb['regtop']!=""){
				$sqls="select * from ssc_member where username ='".$rowb['regtop']."'";
				$rss=mysql_query($sqls) or  die("数据库修改出错1".mysql_error());
				$rows = mysql_fetch_array($rss);
				if($rows['zc']>0){
//					$zmoney = $rows['zc']*($rowb['t7']-$rowb['t11']-$rowb['t12']-$rowb['t13']+$rowb['t15']+$rowb['t16'])/100;
					$sqlc="select SUM(money) as smoney from ssc_bills where zt='1' and lotteryid='".$lid."' and issue='".$issue."' and regtop='".$rowb['regtop']."'";
					$rsc = mysql_query($sqlc);
					$rowc = mysql_fetch_array($rsc);
					
					$zmoney = $rows['zc']*($rowb['t7']-$rowb['t11']-$rowb['t13']+$rowb['t15']-$rowc['smoney'])/100;
					if($zmoney>0){
						$lmoney = $rows['leftmoney']+$zmoney;
					
						$sqla = "select * from ssc_record order by id desc limit 1";
						$rsa = mysql_query($sqla);
						$rowa = mysql_fetch_array($rsa);
						$dan1 = sprintf("%07s",strtoupper(base_convert($rowa['id']+1,10,36)));
					
						$sqla="insert into ssc_record set lotteryid='".$lid."', lottery='".Get_lottery($lid)."', dan='".$dan1."', uid='".$rows['uid']."', username='".$rowb['regtop']."', issue='".$issue."', types='40', smoney=".$zmoney.",leftmoney=".$lmoney.", adddate='".date("Y-m-d H:i:s")."'";
						$exe=mysql_query($sqla) or  die("数据库修改出错!!!".mysql_error());
						
						$sqla="update ssc_member set leftmoney=".$lmoney." where username='".$rowb['regtop']."'"; 
						$exe=mysql_query($sqla) or  die("数据库修改出错!!!".mysql_error());
					}
				}
			}
		}		
	}
}
?>