<?php
error_reporting(0);
require_once 'conn.php';

$sql="select * from ssc_set where id=3 order by id asc";
$rsnewslist = mysql_query($sql);
$row=mysql_fetch_array($rsnewslist);
$url=$row['port'];
//		$url="http://www.xjflcp.com/servlet/sscflash?type=full&rand=2266";

		$doc = new DOMDocument();
		$doc->load($url); //读取xml文件
	//	$datas= $doc->saveXML();
//		$lst = $doc->getElementsByTagName('history1');
//		$t1 = $lst->item(0)->getElementsByTagName("draw")->item(0)->nodeValue; //取得name的标签的对象数组 
//		$t1 = substr($t1,2,6)."0".substr($t1,-2);
//		$t2 = $lst->item(0)->getElementsByTagName("prize_number")->item(0)->nodeValue; //取得name的标签的对象数组 
//		$t2 = str_replace("|",",",$t2);	
		
		
		$lst = $doc->getElementsByTagName('row');
	//    for ($i=0; $i<$lst->length; $i++) {
		for ($i=0; $i<2; $i++) {
			$iframe= $lst->item($i);
			$t1=$iframe->attributes->getNamedItem('expect')->value;
			$t2=$iframe->attributes->getNamedItem('opencode')->value;
			$t3=$iframe->attributes->getNamedItem('opentime')->value;

//			$t1=substr($t1,-9);
			kjdata($t2,3,$t1,"2000-01-01 01:01:01");
		 } 		
		 
?>
