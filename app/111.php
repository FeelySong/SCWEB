<?php 

//switch(mname){
//	case"ZXHZ":var cc={0:1,1:3,2:6,3:10,4:15,5:21,6:28,7:36,8:45,9:55,10:63,11:69,12:73,13:75,14:75,15:73,16:69,17:63,18:55,19:45,20:36,21:28,22:21,23:15,24:10,25:6,26:3,27:1};
//	case"ZUHZ":if(mname=="ZUHZ"){cc={1:1,2:2,3:2,4:4,5:5,6:6,7:8,8:10,9:11,10:13,11:14,12:14,13:15,14:15,15:14,16:14,17:13,18:11,19:10,20:8,21:6,22:5,23:4,24:2,25:2,26:1}}for(i=0;i<=max_place;i++){var s=data_sel[i].length;for(j=0;j<s;j++){nums+=cc[parseInt(data_sel[i][j],10)]}}break;
//	
//	case"ZUS":for(i=0;i<=max_place;i++){var s=data_sel[i].length;if(s>1){nums+=s*(s-1)}}break;
//	case"ZUL":for(i=0;i<=max_place;i++){var s=data_sel[i].length;if(s>2){nums+=s*(s-1)*(s-2)/6}}break;
//	case"BDW2":case"ZU2":for(i=0;i<=max_place;i++){var s=data_sel[i].length;if(s>1){nums+=s*(s-1)/2}}break;
//	case"DWD":for(i=0;i<=max_place;i++){nums+=data_sel[i].length}break;
//	case"SDZX3":nums=0;if(data_sel[0].length>0&&data_sel[1].length>0&&data_sel[2].length>0){for(i=0;i<data_sel[0].length;i++){for(j=0;j<data_sel[1].length;j++){for(k=0;k<data_sel[2].length;k++){if(data_seWx`l[0][i]!=data_sel[1][j]&&data_sel[0][i]!=data_sel[2][k]&&data_sel[1][j]!=data_sel[2][k]){nums++}}}}}break;
//	case"SDZU3":for(i=0;i<=max_place;i++){var s=data_sel[i].length;if(s>2){nums+=s*(s-1)*(s-2)/6}}break;
//	case"SDZX2":nums=0;if(data_sel[0].length>0&&data_sel[1].length>0){for(i=0;i<data_sel[0].length;i++){for(j=0;j<data_sel[1].length;j++){if(data_sel[0][i]!=data_sel[1][j]){nums++}}}}break;
//	case"SDZU2":for(i=0;i<=max_place;i++){var s=data_sel[i].length;if(s>1){nums+=s*(s-1)/2}}break;
//	case"SDBDW":case"SDDWD":case"SDDDS":case"SDCZW":case"SDRX1":for(i=0;i<=max_place;i++){nums+=data_sel[i].length}break;		 	case"SDRX2":for(i=0;i<=max_place;i++){var s=data_sel[i].length;if(s>1){nums+=s*(s-1)/2}}break;
//	case"SDRX3":for(i=0;i<=max_place;i++){var s=data_sel[i].length;if(s>2){nums+=s*(s-1)*(s-2)/6}}break;
//	case"SDRX4":for(i=0;i<=max_place;i++){var s=data_sel[i].length;if(s>3){nums+=s*(s-1)*(s-2)*(s-3)/24}}break;
//	case"SDRX5":for(i=0;i<=max_place;i++){var s=data_sel[i].length;if(s>4){nums+=s*(s-1)*(s-2)*(s-3)*(s-4)/120}}break;
//	case"SDRX6":for(i=0;i<=max_place;i++){var s=data_sel[i].length;if(s>5){nums+=s*(s-1)*(s-2)*(s-3)*(s-4)*(s-5)/720}}break;	 	case"SDRX7":for(i=0;i<=max_place;i++){var s=data_sel[i].length;if(s>6){nums+=s*(s-1)*(s-2)*(s-3)*(s-4)*(s-5)*(s-6)/5040}}break;
//	case"SDRX8":for(i=0;i<=max_place;i++){var s=data_sel[i].length;if(s>7){nums+=s*(s-1)*(s-2)*(s-3)*(s-4)*(s-5)*(s-6)*(s-7)/40320}}break;
//	default:for(i=0;i<=max_place;i++){if(data_sel[i].length==0){tmp_nums=0;break;break}tmp_nums*=data_sel[i].length}nums=tmp_nums;break}}var times=parseInt($($.lt_id_data.id_sel_times).val(),10);if(isNaN(times)){times=1;$($.lt_id_data.id_sel_times).val(1)}var money=Math.round(times*nums*2*($.lt_method_data.modes[modes].rate*1000))/1000;money=isNaN(money)?0:money;$($.lt_id_data.id_sel_num).html(nums);$($.lt_id_data.id_sel_money).html(money)}var dumpNum=function(isdeal){var l=data_sel[0].length;var err=[];var news=[];if(l==0){return err}for(i=0;i<l;i++){if($.inArray(data_sel[0][i],err)!=-1){continue}for(j=i+1;j<l;j++){if(data_sel[0][i]==data_sel[0][j]){err.push(data_sel[0][i]);break}}news.push(data_sel[0][i])}if(isdeal){data_sel[0]=news}return err
//	};


function jiance($codes,$mid){
	if($mid==15 || $mid==17 || $mid==53 || $mid==55 || $mid==91 || $mid==129 || $mid==131 || $mid==165 || $mid==295 || $mid==323){//直选和值
		$xyzs["ZXHZ"]=array(0=>1,1=>3,2=>6,3=>10,4=>15,5=>21,6=>28,7=>36,8=>45,9=>55,10=>63,11=>69,12=>73,13=>75,14=>75,15=>73,16=>69,17=>63,18=>55,19=>45,20=>36,21=>28,22=>21,23=>15,24=>10,25=>6,26=>3,27=>1);
		$stra=explode("&",$codes);
		for($i=0; $i<count($stra); $i++) {
			$nums+=$xyzs["ZXHZ"][$stra[$i]];
		}
		return $nums;
	}elseif($mid==21 || $mid==25 || $mid==59 || $mid==63 || $mid==97 || $mid==101 || $mid==135 || $mid==139 || $mid==169 || $mid==299 || $mid==327){//组选和值
		$xyzs["ZUHZ"]=array(1=>1,2=>2,3=>2,4=>4,5=>5,6=>6,7=>8,8=>10,9=>11,10=>13,11=>14,12=>14,13=>15,14=>15,15=>14,16=>14,17=>13,18=>11,19=>10,20=>8,21=>6,22=>5,23=>4,24=>2,25=>2,26=>1);
		$stra=explode("&",$codes);
		for($i=0; $i<count($stra); $i++) {
			$nums+=$xyzs["ZUHZ"][$stra[$i]];
		}
		return $nums;
	}elseif($mid==18 || $mid==22 || $mid==56 || $mid==60 || $mid==94 || $mid==98 || $mid==132 || $mid==136 || $mid==166 || $mid==296 || $mid==324){//ZUS组三
		$xyzs["ZUS"]=array(2=>2,3=>6,4=>12,5=>20,6=>30,7=>42,8=>56,9=>72,10=>90);
		$stra=explode("&",$codes);
		$nums=$xyzs["ZUS"][count($stra)];
		return $nums;
	}elseif($mid==19 || $mid==23 || $mid==57 || $mid==61 || $mid==95 || $mid==99 || $mid==133 || $mid==137 || $mid==167 || $mid==297 || $mid==325){//ZUL组六
		$xyzs["ZUL"]=array(3=>1,4=>4,5=>10,6=>20,7=>35,8=>56,9=>84,10=>120);
		$stra=explode("&",$codes);
		$nums=$xyzs["ZUL"][count($stra)];
		return $nums;
	}elseif($mid==27 || $mid==65 || $mid==103 || $mid==141 || $mid==171 || $mid==301 || $mid==329 || $mid==30 || $mid==31 || $mid==68 || $mid==69 || $mid==106 || $mid==107 || $mid==144 || $mid==145 || $mid==174 || $mid==175 || $mid==304 || $mid==305 || $mid==332 || $mid==333){//BDW2二码  ZU2前二组选复式
		$xyzs["ZU2"]=array(2=>1,3=>3,4=>6,5=>10,6=>15,7=>21,8=>28,9=>36,10=>45);
		$stra=explode("&",$codes);
		$nums=$xyzs["ZU2"][count($stra)];
		return $nums;
	}elseif($mid==32 || $mid==33 || $mid==34 || $mid==35 || $mid==36 || $mid==70 || $mid==71 || $mid==72 || $mid==73 || $mid==74 || $mid==108 || $mid==109 || $mid==110 || $mid==111 || $mid==112 || $mid==146 || $mid==147 || $mid==148 || $mid==149 || $mid==150 || $mid==176 || $mid==177 || $mid==178 || $mid==306 || $mid==307 || $mid==308 || $mid==334 || $mid==335 || $mid==336 || $mid==337 || $mid==338){//DWD 定位胆
		$stra=explode("&",$codes);
		$nums=count($stra);
		return $nums;
	}/*elseif($mid==197 || $mid==231 || $mid==265 || $mid==358){//SDZX3 前三直选复式----
		$stra=explode("|",$codes);
		$nums_cf=0;
		$strb=explode("&",$stra[0]);
		$strc=explode("&",$stra[1]);
		$strd=explode("&",$stra[2]);
		for ($i=0; $i<count($strc); $i++) {
			if(in_array($strc[$i],$strb)==true){
				$nums_cf=$nums_cf+1;	
			}
		}
		for ($i=0; $i<count($strd); $i++) {
			if(in_array($strd[$i],$strb)==true){
				$nums_cf=$nums_cf+1;	
			}
		}
		$nums=count($strb)*count($strc)*count($strd)-$nums_cf;
		return $nums;
	}*/elseif($mid==198 || $mid==232 || $mid==266 || $mid==359){//SDZU3 前三组选复式
		$xyzs["SDZU3"]=array(3=>1,4=>4,5=>10,6=>20,7=>35,8=>56,9=>84,10=>120,11=>165);
		$stra=explode("&",$codes);
		$nums=$xyzs["SDZU3"][count($stra)];
		return $nums;
	}elseif($mid==199 || $mid==233 || $mid==267 || $mid==360){//SDZX2 前二直选复式
		$stra=explode("|",$codes);
		$nums_cf=0;
		$strb=explode("&",$stra[0]);
		$strc=explode("&",$stra[1]);
		for ($i=0; $i<count($strc); $i++) {
			if(in_array($strc[$i],$strb)==true){
				$nums_cf=$nums_cf+1;	
			}
		}
		$nums=count($strb)*count($strc)-$nums_cf;
		return $nums;
	}elseif($mid==200 || $mid==234 || $mid==268 || $mid==361){//SDZU2 前二组选复式
		$xyzs["SDZU2"]=array(2=>1,3=>3,4=>6,5=>10,6=>15,7=>21,8=>28,9=>36,10=>45,11=>55);
		$stra=explode("&",$codes);
		$nums=$xyzs["SDZU2"][count($stra)];
		return $nums;
	}elseif($mid==201 || $mid==235 || $mid==269 || $mid==362 || $mid==202 || $mid==203 || $mid==236 || $mid==237 || $mid==270 || $mid==271 || $mid==272 || $mid==363 || $mid==364 || $mid==365 || $mid==205 || $mid==239 || $mid==273 || $mid==366 || $mid==206 || $mid==240 || $mid==274 || $mid==367 || $mid==207 || $mid==241 || $mid==275 || $mid==368){//SDBDW 前二组选复式  SDDWD 定位胆  SDDDS 定单双 SDCZW猜中位 SDRX1任选一中一---
		$stra=explode("&",$codes);
		$nums=count($stra);
		return $nums;
	}elseif($mid==208 || $mid==242 || $mid==276 || $mid==369){//SDRX2 任选二中二
		$xyzs["SDRX2"]=array(2=>1,3=>3,4=>6,5=>10,6=>15,7=>21,8=>28,9=>36,10=>45,11=>55);
		$stra=explode("&",$codes);
		$nums=$xyzs["SDRX2"][count($stra)];
		return $nums;
	}elseif($mid==209 || $mid==243 || $mid==277 || $mid==370){//SDRX3 任选三中三
		$xyzs["SDRX3"]=array(3=>1,4=>4,5=>10,6=>20,7=>35,8=>56,9=>84,10=>120,11=>165);
		$stra=explode("&",$codes);
		$nums=$xyzs["SDRX3"][count($stra)];
		return $nums;
	}elseif($mid==210 || $mid==244 || $mid==278 || $mid==371){//SDRX4 任选四中四
		$xyzs["SDRX4"]=array(4=>1,5=>5,6=>15,7=>35,8=>70,9=>126,10=>210,11=>330);
		$stra=explode("&",$codes);
		$nums=$xyzs["SDRX4"][count($stra)];
		return $nums;
	}elseif($mid==211 || $mid==245 || $mid==279 || $mid==372){//SDRX5 任选五中五
		$xyzs["SDRX5"]=array(5=>1,6=>6,7=>21,8=>56,9=>126,10=>252,11=>462);
		$stra=explode("&",$codes);
		$nums=$xyzs["SDRX5"][count($stra)];
		return $nums;
	}elseif($mid==212 || $mid==246 || $mid==280 || $mid==373){//SDRX6 任选六中五
		$xyzs["SDRX6"]=array(6=>1,7=>7,8=>28,9=>84,10=>210,11=>462);
		$stra=explode("&",$codes);
		$nums=$xyzs["SDRX6"][count($stra)];
		return $nums;
	}elseif($mid==213 || $mid==247 || $mid==281 || $mid==374){//SDRX7 任选七中五
		$xyzs["SDRX7"]=array(7=>1,8=>8,9=>36,10=>120,11=>330);
		$stra=explode("&",$codes);
		$nums=$xyzs["SDRX7"][count($stra)];
		return $nums;
	}elseif($mid==214 || $mid==248 || $mid==282 || $mid==375){//SDRX8 任选八中五
		$xyzs["SDRX8"]=array(8=>1,9=>9,10=>45,11=>165);
		$stra=explode("&",$codes);
		$nums=$xyzs["SDRX8"][count($stra)];
		return $nums;
	}elseif($mid==14 || $mid==16 || $mid==52 || $mid==54 || $mid==90 || $mid==92 || $mid==128 || $mid==130 || $mid==164 || $mid==294 || $mid==322 || $mid==403){
		$stra=explode("|",$codes);
		$nums=1;
		for ($i=0; $i<count($stra); $i++) {
			$strb=explode("&",$stra[$i]);
			$nums=$nums*count($strb);
		}
		return $nums;
	}elseif($mid==28 || $mid==29 || $mid==66 || $mid==67 || $mid==104 || $mid==105 || $mid==142 || $mid==143 || $mid==172 || $mid==173 || $mid==302 || $mid==303 || $mid==330 || $mid==331){//前二/后二直选复式
		$stra=explode("|",$codes);
		$nums=1;
		for ($i=0; $i<count($stra); $i++) {
			$strb=explode("&",$stra[$i]);
			$nums=$nums*count($strb);
		}
		return $nums;
	}elseif($mid==20 || $mid==24 || $mid==58 || $mid==62 || $mid==96 || $mid==100 || $mid==134 || $mid==138 || $mid==168 || $mid==298 || $mid==326){//HHZX 混合组选
		$stra=explode("&",$codes);
		$nums=count($stra);
		return $nums;
	}elseif($mid==26 || $mid==64 || $mid==102 || $mid==140 || $mid==170 || $mid==300 || $mid==328){//BDW1 不定位一码
		$stra=explode("&",$codes);
		$nums=count($stra);
		return $nums;
	}
	
}

echo(jiance("1&8&9|1&8&9|1&8&9&2",14));
exit;


	

$yxwf["ZX3"]=array(14,16,52,54,90,92,128,130,164,294,322,403);
$yxwf["ZXHZ"]=array(15,17,53,55,91,129,131,165,295,323);
$yxwf["ZUS"]=array(18,22,56,60,94,98,132,136,166,296,324);
$yxwf["ZUL"]=array(19,23,57,61,95,99,133,137,167,297,325);
$yxwf["HHZX"]=array(20,24,58,62,96,100,134,138,168,298,326);
$yxwf["ZUHZ"]=array(21,25,59,63,97,101,135,139,169,299,327);
$yxwf["BDW1"]=array(26,64,102,140,170,300,328);
$yxwf["BDW2"]=array(27,65,103,141,171,301,329);
$yxwf["ZX2"]=array(28,29,66,67,104,105,142,143,172,173,302,303,330,331);
$yxwf["ZU2"]=array(30,31,68,69,106,107,144,145,174,175,304,305,332,333);
$yxwf["DWD"]=array(32,33,34,35,36,70,71,72,73,74,108,109,110,111,112,146,147,148,149,150,176,177,178,306,307,308,334,335,336,337,338);
$yxwf["DXDS"]=array(37,38,75,76,113,114,151,152,179,180,309,310,339,340);
$yxwf["SDZX3"]=array(197,231,265,358);
$yxwf["SDZU3"]=array(198,232,266,359);
$yxwf["SDZX2"]=array(199,233,267,360);
$yxwf["SDZU2"]=array(200,234,268,361);
$yxwf["SDBDW"]=array(201,235,269,362);
$yxwf["SDDWD"]=array(202,203,236,237,270,271,272,363,364,365);
$yxwf["SDDDS"]=array(205,239,273,366);
$yxwf["SDCZW"]=array(206,240,274,367);
$YXWF["SDRX1"]=array(207,241,275,368);
$YXWF["SDRX2"]=array(208,242,276,369);
$YXWF["SDRX3"]=array(209,243,277,370);
$YXWF["SDRX4"]=array(210,244,278,371);
$YXWF["SDRX5"]=array(211,245,279,372);
$YXWF["SDRX6"]=array(212,246,280,373);
$YXWF["SDRX7"]=array(213,247,281,374);
$YXWF["SDRX8"]=array(214,248,282,375);
print_r($yxwf["zx3"]);

$stra=explode("|","0&1&2&3&4|0&1&2&3&4|0&1&2&3&4&5");
$snums=1;
for ($i=0; $i<count($stra); $i++) {
	$strc=explode("&",$stra[$i]);
	$snums=$snums*count($strc);
}
echo($snums."<br>");
	
	
	
	
//var data_sel=[];var max_place=0;var otype=opts.type.toLowerCase();var methodname=$.lt_method[$.lt_method_data.methodid];var html="";if(otype=="input"){var tempdes="";switch(methodname){case"SDZX3":case"SDZU3":case"SDZX2":case"SDRX1":case"SDRX2":case"SDRX3":case"SDRX4":case"SDRX5":case"SDRX6":case"SDRX7":case"SDRX8":case"SDZU2":tempdes=lot_lang.dec_s26;break;default:tempdes=lot_lang.dec_s4;break}html+='<div class=nbs><table class=ha><tr><td valign=top><textarea id="lt_write_box" style="width:600px;height:80px;"></textarea><br />'+tempdes+'</td><td valign=top><span class=ds><span class=lsbb><input name="lt_write_del" type="button" value="删除重复号" class="lsb" id="lt_write_del"></span></span><!--<span class=ds><span class=lsbb><input name="lt_write_import" type="button" value="&nbsp;导入文件&nbsp;" class="lsb" id="lt_write_import"></span></span>--><span class=ds><span class=lsbb><input name="lt_write_empty" type="button" value="&nbsp;清&nbsp;&nbsp;空&nbsp;" class="lsb" id="lt_write_empty"></span></span></td></tr></table></div><br /><br /><br /><br /><br /><br />';data_sel[0]=[];tempdes=null}else{if(otype=="digital"){$.each(opts.layout,function(i,n){if(typeof(n)=="object"){n.place=parseInt(n.place,10);max_place=n.place>max_place?n.place:max_place;data_sel[n.place]=[];html+='<div class="nbs">';if(n.cols>0){html+="<div class=ti><div class=l></div>";if(n.title.length>0){html+=n.title}html+="<div class=r></div></div>"}html+='<div class="nb">';numbers=n.no.split("|");j=numbers.length;if(j>12){html+="<span>"}for(i=0;i<j;i++){if((methodname=="ZXHZ"&&i==14)||(methodname=="ZUHZ"&&i==13)){html+="</span><span>"}html+='<div name="lt_place_'+n.place+'">'+numbers[i]+"</div>"}if(j>12){html+="</span>"}html+="</div>";if(opts.isButton==true){html+='<div class=to><ul><li class="l"></li><li class="dxjoq" name="all">'+lot_lang.bt_sel_all+'</li><li class="dxjoq" name="big">'+lot_lang.bt_sel_big+'</li><li class="dxjoq" name="small">'+lot_lang.bt_sel_small+'</li><li class="dxjoq" name="odd">'+lot_lang.bt_sel_odd+'</li><li class="dxjoq" name="even">'+lot_lang.bt_sel_even+'</li><li class="dxjoq" name="clean">'+lot_lang.bt_sel_clean+'</li><li class="r"></li></ul></div>'}html+="</div>"}})}else{if(otype=="dxds"){$.each(opts.layout,function(i,n){n.place=parseInt(n.place,10);max_place=n.place>max_place?n.place:max_place;data_sel[n.place]=[];html+='<div class="nbs" style="width:80%;">';if(n.cols>0){html+="<div class=ti><div class=l></div>";if(n.title.length>0){html+=n.title}html+="<div class=r></div></div>"}html+='<div class="nb">';numbers=n.no.split("|");j=numbers.length;for(i=0;i<j;i++){html+='<div name="lt_place_'+n.place+'">'+numbers[i]+"</div>"}html+='</div><div class=to><ul><li class="l"></li><li class="dxjoq" name="clean">'+lot_lang.bt_sel_clean+'</li><li class="r"></li></ul></div></div>'})}else{if(otype=="dds"){$.each(opts.layout,function(i,n){n.place=parseInt(n.place,10);max_place=n.place>max_place?n.place:max_place;data_sel[n.place]=[];html+='<div class="nbs">';if(n.cols>0){html+="<div class=ti><div class=l></div>";if(n.title.length>0){html+=n.title}html+="<div class=r></div></div>"}html+='<div class="bl">';numbers=n.no.split("|");temphtml="";if(n.prize){tmpprize=n.prize.split(",")}j=numbers.length;for(i=0;i<j;i++){html+='<div name="lt_place_'+n.place+'">'+numbers[i]+"</div>";if(n.prize){temphtml+="<span>"+$.lt_method_data.prize[parseInt(tmpprize[i],10)]+"</span>"}}html+=temphtml+"</div>"})}}}}html+='<div class="c"></div>';$html=$(html);$(this).empty();$html.appendTo(this);var me=this;var _SortNum=function(a,b){if(otype!="input"){a=a.replace(/5单0双/g,0).replace(/4单1双/g,1).replace(/3单2双/g,2).replace(/2单3双/g,3).replace(/1单4双/g,4).replace(/0单5双/g,5);a=a.replace(/大/g,0).replace(/小/g,1).replace(/单/g,2).replace(/双/g,3).replace(/\s/g,"");b=b.replace(/5单0双/g,0).replace(/4单1双/g,1).replace(/3单2双/g,2).replace(/2单3双/g,3).replace(/1单4双/g,4).replace(/0单5双/g,5);b=b.replace(/大/g,0).replace(/小/g,1).replace(/单/g,2).replace(/双/g,3).replace(/\s/g,"")}a=parseInt(a,10);b=parseInt(b,10);if(isNaN(a)||isNaN(b)){return true}return(a-b)};var _HHZXcheck=function(n,len){if(len==2){var a=["00","11","22","33","44","55","66","77","88","99"]}else{var a=["000","111","222","333","444","555","666","777","888","999"]}n=n.toString();if($.inArray(n,a)==-1){return true}return false};var _SDinputCheck=function(n,len){t=n.split(" ");l=t.length;for(i=0;i<l;i++){if(Number(t[i])>11||Number(t[i])<1){return false}for(j=i+1;j<l;j++){if(Number(t[i])==Number(t[j])){return false}}}return true};var _inputCheck_Num=function(l,e,fun,sort){var nums=data_sel[0].length;var error=[];var newsel=[];var partn="";l=parseInt(l,10);switch(l){case 2:partn=/^[0-9]{2}$/;break;case 5:partn=/^[0-9\s]{5}$/;break;case 8:partn=/^[0-9\s]{8}$/;break;case 11:partn=/^[0-9\s]{11}$/;break;case 14:partn=/^[0-9\s]{14}$/;break;case 17:partn=/^[0-9\s]{17}$/;break;case 20:partn=/^[0-9\s]{20}$/;break;case 23:partn=/^[0-9\s]{23}$/;break;default:partn=/^[0-9]{3}$/;break}fun=$.isFunction(fun)?fun:function(s){return true};$.each(data_sel[0],function(i,n){n=$.trim(n);if(partn.test(n)&&fun(n,l)){if(sort){if(n.indexOf(" ")==-1){n=n.split("");n.sort(_SortNum);n=n.join("")}else{n=n.split(" ");n.sort(_SortNum);n=n.join(" ")}}data_sel[0][i]=n;newsel.push(n)}else{if(n.length>0){error.push(n)}nums=nums-1}});if(e==true){data_sel[0]=newsel;return error}return nums};function checkNum(){var nums=0,mname=$.lt_method[$.lt_method_data.methodid];var modes=parseInt($($.lt_id_data.id_sel_modes).val(),10);if(otype=="input"){if(data_sel[0].length>0){switch(mname){case"ZX3":nums=_inputCheck_Num(3,false);break;case"HHZX":nums=_inputCheck_Num(3,false,_HHZXcheck,true);break;case"ZX2":nums=_inputCheck_Num(2,false);break;case"ZU2":nums=_inputCheck_Num(2,false,_HHZXcheck,true);break;case"SDZX3":nums=_inputCheck_Num(8,false,_SDinputCheck,false);break;case"SDZU3":nums=_inputCheck_Num(8,false,_SDinputCheck,true);break;case"SDZX2":nums=_inputCheck_Num(5,false,_SDinputCheck,false);break;case"SDZU2":nums=_inputCheck_Num(5,false,_SDinputCheck,true);break;case"SDRX1":nums=_inputCheck_Num(2,false,_SDinputCheck,false);break;case"SDRX2":nums=_inputCheck_Num(5,false,_SDinputCheck,true);break;case"SDRX3":nums=_inputCheck_Num(8,false,_SDinputCheck,true);break;case"SDRX4":nums=_inputCheck_Num(11,false,_SDinputCheck,true);break;case"SDRX5":nums=_inputCheck_Num(14,false,_SDinputCheck,true);break;case"SDRX6":nums=_inputCheck_Num(17,false,_SDinputCheck,true);break;case"SDRX7":nums=_inputCheck_Num(20,false,_SDinputCheck,true);break;case"SDRX8":nums=_inputCheck_Num(23,false,_SDinputCheck,true);break;default:break}}}else{var tmp_nums=1;

?>