<?php
error_reporting(0);
require_once 'conn.php';

$sql="select * from ssc_set where id=11 order by id asc";
$rsnewslist = mysql_query($sql);
$row=mysql_fetch_array($rsnewslist);
$url=$row['port'];
//		$url="http://www.cailele.com/static/cq11x5/newlyopenlist.xml";

		$doc = new DOMDocument();
		$doc->load($url); //读取xml文件
		$lst = $doc->getElementsByTagName('row');
	//    for ($i=0; $i<$lst->length; $i++) {
		for ($i=0; $i<2; $i++) {
			$iframe= $lst->item($i);
			$t1=$iframe->attributes->getNamedItem('expect')->value;
			$t2=$iframe->attributes->getNamedItem('opencode')->value;
			$t3=$iframe->attributes->getNamedItem('opentime')->value;

			$t1=substr($t1,-8);	
			kjdata($t2,11,$t1,$t3);
		 } 
		 
?>
