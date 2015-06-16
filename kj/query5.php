<?php
error_reporting(0);
require_once 'conn.php';

		$url="http://cp.swlc.sh.cn/cams/xml/award_02.xml";

		$doc = new DOMDocument();
		$doc->load($url); //读取xml文件
		$lst = $doc->getElementsByTagName('p');
		for ($i=0; $i<1; $i++) {
			$iframe= $lst->item($i);
			$t1=$iframe->attributes->getNamedItem('id')->value;
			$t1 = substr($t1,2,6).substr($t1,-2);
			$t2=$iframe->attributes->getNamedItem('c')->value;
			$t3=$iframe->attributes->getNamedItem('t')->value;
//			echo $t1.$t2.$t3."<br>";
			kjdata($t2,5,$t1,$t3);
		}
		 
?>
