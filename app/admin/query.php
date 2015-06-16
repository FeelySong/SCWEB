<?php
session_start();
error_reporting(0);
require_once 'conn.php';

$sql = "select * from ssc_set where zt=1 order by id asc";
$rs = mysql_query($sql);
while ($row = mysql_fetch_array($rs)){
	$doc = new DOMDocument();
	$doc->load($row['port']); //读取xml文件
//	$datas= $doc->saveXML();
	if($row['id']==3){
		$lst = $doc->getElementsByTagName('history1');
		$t1 = $lst->item(0)->getElementsByTagName("draw")->item(0)->nodeValue; //取得name的标签的对象数组 
		$t1 = substr($t1,2,6)."0".substr($t1,-2);
		$t2 = $lst->item(0)->getElementsByTagName("prize_number")->item(0)->nodeValue; //取得name的标签的对象数组 
		$t2 = str_replace("|",",",$t2);	

		kjdata($t2,$row['id'],$t1,"2000-01-01 01:01:01");
	}else{
	
		$lst = $doc->getElementsByTagName('row');
	//    for ($i=0; $i<$lst->length; $i++) {
		for ($i=0; $i<4; $i++) {
			$iframe= $lst->item($i);
			$t1=$iframe->attributes->getNamedItem('expect')->value;
			$t2=$iframe->attributes->getNamedItem('opencode')->value;
			$t3=$iframe->attributes->getNamedItem('opentime')->value;

			if($row['id']<5){
				$t1=substr($t1,-9);
			}else if($row['id']==5 || $row['id']==6 || $row['id']==7 || $row['id']==8 || $row['id']==11){
				$t1=substr($t1,-8);	
			}else if($row['id']==9 || $row['id']==10){
				$t1=substr($t1,-5);
			}
			kjdata($t2,$row['id'],$t1,$t3);
		 } 
	 
	 }

}
function kjdata($t2,$cid,$t1,$t3){
		if($t2!=""){
			$t4=split(",",$t2);
			$n1=$t4[0];
			$n2=$t4[1];
			$n3=$t4[2];
	//			echo $row['id'];
			if($cid!=5 && $cid!=9){
				$n4=$t4[3];
				$n5=$t4[4];
			}
		}
		$n1=intval($n1);
		$n2=intval($n2);
		$n3=intval($n3);
		$n4=intval($n4);
		$n5=intval($n5);
		
//			echo $row['name']."第".$t1."期:".$t2."<br>";
		
		$sql = "select * from ssc_data where cid='".$cid."' and issue='".$t1."'";		
//			echo $sql."<br>";
		$rsa = mysql_query($sql);
		$rowa = mysql_fetch_array($rsa);
		$tts=0;
		if($cid==1 || $cid==2 || $cid==3 || $cid==4){
			if($n1=="0" && $n2=="0" && $n3=="0" && $n4=="0" && $n5=="0"){$tts=1;}
			if($n1>9 || $n2>9 || $n3>9 || $n4>9 || $n5>9){$tts=1;}			
		}else if($cid==5){
			if($n1=="0" && $n2=="0" && $n3=="0"){$tts=1;}
			if($n1>9 || $n2>9 || $n3>9){$tts=1;}			
		}else if($cid==6 || $cid==7 || $cid==8 || $cid==11){
			if($n1=="0" && $n2=="0" && $n3=="0" && $n4=="0" && $n5=="0"){$tts=1;}
			if($n1>11 || $n2>11 || $n3>11 || $n4>11 || $n5>11){$tts=1;}
		}else if($cid==9){
			if($n1=="0" && $n2=="0" && $n3=="0"){$tts=1;}
			if($n1>9 || $n2>9 || $n3>9){$tts=1;}
		}else if($cid==10){
			if($n1=="0" && $n2=="0" && $n3=="0" && $n4=="0" && $n5=="0"){$tts=1;}
			if($n1>9 || $n2>9 || $n3>9 || $n4>9 || $n5>9){$tts=1;}			
		}
		
		if(empty($rowa)){
			if($tts==0){
				$sql="INSERT INTO ssc_data set cid='".$cid."', name='".Get_lottery($cid)."', issue='".$t1."', code='".$t2."', n1='".$n1."', n2='".$n2."', n3='".$n3."', n4='".$n4."', n5='".$n5."', opentime='".$t3."', addtime='".date("Y-m-d H:i:s")."'";
//				echo $row['name']."第".$t1."期:".$t2."<br>";
				$exe=mysql_query($sql) or  die("数据库修改出错!!!!".mysql_error());
			}
		}
}

?>
