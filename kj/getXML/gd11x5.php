<?php  
$opts = array(
    'http'=>array(
        'method'=>"GET",
        'header'=>
        "User-Agent: mozilla/5.0 (windows; u; windows nt 5.1; zh-cn; rv:1.9.2.3) gecko/20100401 firefox/3.6.3" .
        "Accept: *//*"
    )
);
$context = stream_context_create($opts);
$url = "http://www.cailele.com/static/gd11x5/newlyopenlist.xml";
$content = file_get_contents($url, false, $context);
$parser = xml_parser_create();                       
xml_parse_into_struct($parser, $content, $values, $index);    
xml_parser_free($parser);       
//echo $content;
$doc = new DOMDocument();
$doc = $content;
echo $doc;
?> 
	  
