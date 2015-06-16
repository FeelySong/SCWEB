<?php	//
	$serr="";
	$ssuccess=0;
	$sfail=0;
	
	$sissue=$_REQUEST['lt_issue_start'];
	if($sissue<$issue){//已停止投注
		echo "{\"stats\":\"error\",\"data\":\"\u7b2c[".$sissue."]\u671f\u5df2\u505c\u6b62\u9500\u552e\"}";
		exit;
	}
	if($_SESSION["username"] ==""){//
		echo "{\"stats\":\"error\",\"data\":\"请重新登录\"}";
		exit;
	}
	$sql = "select * from ssc_member where username='" . $_SESSION["username"] . "'";
	$rs = mysql_query($sql);
	$row = mysql_fetch_array($rs);
	$zt=$row['zt'];
	if($zt==1){//
		echo "{\"stats\":\"error\",\"data\":\"你的帐户被冻结\"}";
		exit;
	}
	if($zt==2){//
		echo "{\"stats\":\"error\",\"data\":\"你的帐户被锁定\"}";
		exit;
	}
	
	if($_REQUEST['lt_trace_if']=="yes"){		//追号次数
		$ztimes=0;
		$zcount=count($_REQUEST['lt_trace_issues']);
		for ($ii=0; $ii<$zcount; $ii++) {
			$ztimes=$ztimes+$_REQUEST['lt_trace_times_'.$_REQUEST['lt_trace_issues'][$ii]];
		}
	}

	for ($i=0; $i<count($_REQUEST['lt_project']); $i++) {
//		echo $_REQUEST['lt_project'][$i];
		$stra=str_replace("\'","\"",$_REQUEST['lt_project'][$i]);//localhost
		$stra=str_replace("'",'"',$stra);
		$strb=json_decode($stra);//var_export($stra);
		
		$sql = "select * from ssc_member where username='" . $_SESSION["username"] . "'";
		$rs = mysql_query($sql);
		$row = mysql_fetch_array($rs);
		$leftmoney=$row['leftmoney'];
		//session ？
		//玩法是否关闭
		//限注 限倍 限额
		if($strb->mode==2){
			$modes=0.1;
		}else{
			$modes=1;
		}
		
		$sqla = "select * from ssc_class where mid='".$strb->methodid."'";
//		echo $sqla;
		$rsa = mysql_query($sqla);
		$rowa = mysql_fetch_array($rsa);
		$sstri=$rowa['sid'];
		$maxzhu=$rowa['maxzhu'];
		
		$sstra=explode(";",$row['rebate']);	
		$sstrb=explode(",",$sstra[$sstri-1]);
		$spoints=$sstrb[1]/100;

		if($strb->methodid=="20" || $strb->methodid=="21" || $strb->methodid=="24" || $strb->methodid=="25" || $strb->methodid=="58" || $strb->methodid=="59" || $strb->methodid=="62" || $strb->methodid=="63" || $strb->methodid=="96" || $strb->methodid=="97" || $strb->methodid=="100" || $strb->methodid=="101" || $strb->methodid=="134" || $strb->methodid=="135" || $strb->methodid=="138" || $strb->methodid=="139" || $strb->methodid=="168" || $strb->methodid=="169" || $strb->methodid=="205" || $strb->methodid=="206" || $strb->methodid=="239" || $strb->methodid=="240" || $strb->methodid=="273" || $strb->methodid=="274" || $strb->methodid=="298" || $strb->methodid=="299" || $strb->methodid=="326" || $strb->methodid=="327" || $strb->methodid=="366" || $strb->methodid=="367"){//point处理
			$spoint=$spoints;
		}else{
			$spoint=$strb->point;
		}

		$eerr="";
		if($rowa['maxzhu'] < $strb->nums){
			$sfail=$sfail+1;
			$eerr=1;
			if($sfail>1){
				$serr=$serr.",";
			}
			$serr=$serr."{\"desc\":\"[".$strb->desc."\",\"errmsg\":\"超过最大投注注数\"}";
		}

		if($rowa['maxbei'] < $strb->times && $eerr==""){
			$sfail=$sfail+1;
			$eerr=1;
			if($sfail>1){
				$serr=$serr.",";
			}
			$serr=$serr."{\"desc\":\"[".$strb->desc."\",\"errmsg\":\"超过最大投注倍数\"}";
		}

		if($rowa['zt'] !="1" && $eerr==""){
			$sfail=$sfail+1;
			$eerr=1;
			if($sfail>1){
				$serr=$serr.",";
			}
			$serr=$serr."{\"desc\":\"[".$strb->desc."\",\"errmsg\":\"该玩法已被关闭\"}";
		}

		if($_REQUEST['lt_trace_if']!="yes"){		//不追号
			
			if($leftmoney<$strb->money && $eerr==""){
				$sfail=$sfail+1;
				$eerr=1;
				if($sfail>1){
					$serr=$serr.",";
				}
				$serr=$serr."{\"desc\":\"[".$strb->desc."\",\"errmsg\":\"余额不足\"}";
			}
			

			if(round($strb->nums*$strb->times*$modes * 2) != round($strb->money) && $eerr==""){
//				alert();
				$sfail=$sfail+1;
				$eerr=1;
				if($sfail>1){
					$serr=$serr.",";
				}
				$serr=$serr."{\"desc\":\"[".$strb->desc."\",\"errmsg\":\"该注单异常\"}";
			}
			
			if($eerr==""){
				$ssuccess=$ssuccess+1;
//				if($strb->methodid==32 || $strb->methodid==70 || $strb->methodid=="108" || $strb->methodid=="146" || $strb->methodid=="176" || $strb->methodid=="306" || $strb->methodid=="334"){
				if($strb->methodid==32 || $strb->methodid==33 || $strb->methodid==34 || $strb->methodid==35 || $strb->methodid==36 || $strb->methodid==70 || $strb->methodid=="108" || $strb->methodid=="109" || $strb->methodid=="110" || $strb->methodid=="111" || $strb->methodid=="112" || $strb->methodid=="146" || $strb->methodid=="147" || $strb->methodid=="148" || $strb->methodid=="149" || $strb->methodid=="150" || $strb->methodid=="176" || $strb->methodid=="306" || $strb->methodid=="307" || $strb->methodid=="308" || $strb->methodid=="334" || $strb->methodid=="335" || $strb->methodid=="336" || $strb->methodid=="337" || $strb->methodid=="338"){
					$strcs=$strb->codes;
					$stra=explode("|",$strcs);
					for ($i=0; $i<count($stra); $i++) {
						$smid=$strb->methodid+$i;
						$scodes=$stra[$i];
						$strc=explode("&",$stra[$i]);
						$snums=count($strc);
						$smoney=$snums*$strb->times*$modes * 2;
						if($scodes!=""){
						
						
							$sql = "select * from ssc_member where username='" . $_SESSION["username"] . "'";
							$rs = mysql_query($sql);
							$row = mysql_fetch_array($rs);
							$leftmoney=$row['leftmoney'];
							
							$sqla = "select * from ssc_bills order by id desc limit 1";
							$rsa = mysql_query($sqla);
							$rowa = mysql_fetch_array($rsa);
							$dan = sprintf("%06s",strtoupper(base_convert($rowa['id']+1,10,36)));//注单
							
							$canceldead=Get_canceldate($lotteryid,$sissue);
							$sqla="INSERT INTO ssc_bills set lotteryid='".$lotteryid."', lottery='".$lottery."', dan='".$dan."', uid='".$_SESSION["sess_uid"]."', username='".$_SESSION["username"] ."', issue='".$sissue."', type='".$strb->type."', mid='".$smid."', codes='".$scodes."', nums='".$snums."', times='".$strb->times."', money='".$smoney."', mode='".$strb->mode."', rates='".$strb->prize."', point='".$spoint."', cont='".$strb->desc."', regtop='".$row['regtop']."', regup='".$row['regup']."', regfrom='".$row['regfrom']."', userip='".$_SERVER['REMOTE_ADDR']."', adddate='".date("Y-m-d H:i:s")."', canceldead='".$canceldead."'";
							$exe=mysql_query($sqla) or  die("数据库修改出错1!!".mysql_error());
			
							$lmoney=$leftmoney - $smoney;
							$lmoney2=$lmoney + $smoney * $spoint;
							
							$sqla="update ssc_member set leftmoney=".$lmoney2.", usedmoney=usedmoney+".$smoney." where username='".$_SESSION["username"] ."'"; 
							$exe=mysql_query($sqla) or  die("数据库修改出错2!!!".mysql_error());
							
							$sqla = "select * from ssc_savelist where username='" . $_SESSION["username"] . "' order by id desc limit 1";
							$rsa = mysql_query($sqla);
							$rowa = mysql_fetch_array($rsa);
							
							$sqla="update ssc_savelist set xf=xf+".$smoney." where id='".$rowa['id']."'"; 
							$exe=mysql_query($sqla) or  die("数据库修改出错2!!!".mysql_error());
							
							$sqla = "select * from ssc_record order by id desc limit 1";
							$rsa = mysql_query($sqla);
							$rowa = mysql_fetch_array($rsa);
							$dan1 = sprintf("%07s",strtoupper(base_convert($rowa['id']+1,10,36)));
							
							$sqla="insert into ssc_record set lotteryid='".$lotteryid."', lottery='".$lottery."', dan='".$dan1."', dan1='".$dan."', uid='".$_SESSION["sess_uid"]."', username='".$_SESSION["username"] ."', issue='".$sissue."', types='7', mid='".$smid."', mode='".$strb->mode."', zmoney=".$smoney.",leftmoney=".$lmoney.", cont='".$strb->desc."', regtop='".$row['regtop']."', regup='".$row['regup']."', regfrom='".$row['regfrom']."', adddate='".date("Y-m-d H:i:s")."'";
							$exe=mysql_query($sqla) or  die("数据库修改出错3!!!".mysql_error());

//xc  返点							
							if($spoint!="0"){
								$sqla = "select * from ssc_record order by id desc limit 1";
								$rsa = mysql_query($sqla);
								$rowa = mysql_fetch_array($rsa);
								$dan1 = sprintf("%07s",strtoupper(base_convert($rowa['id']+1,10,36)));
								$sqla="insert into ssc_record set lotteryid='".$lotteryid."', lottery='".$lottery."', dan='".$dan1."', dan1='".$dan."', uid='".$_SESSION["sess_uid"]."', username='".$_SESSION["username"] ."', issue='".$sissue."', types='11', mid='".$smid."', mode='".$strb->mode."', smoney=".$smoney*$spoint.",leftmoney=".$lmoney2.", cont='".$strb->desc."', regtop='".$row['regtop']."', regup='".$row['regup']."', regfrom='".$row['regfrom']."', adddate='".date("Y-m-d H:i:s")."'";
								$exe=mysql_query($sqla) or  die("数据库修改出错4!!!".mysql_error());
							}
							
							if($row['regfrom']!=""){
								$sstrp=$spoints*100;
								$regfrom=explode("&&",$row['regfrom']);
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
										$sqla="insert into ssc_record set lotteryid='".$lotteryid."', lottery='".$lottery."', dan='".$dan1."', dan1='".$dan."', uid='".Get_memid($susername)."', username='".$susername."', issue='".$sissue."', types='11', mid='".$smid."', mode='".$strb->mode."', smoney=".($smoney*($sstrb[1]-$sstrp)/100).",leftmoney=".(Get_mmoneys($susername)+$smoney*($sstrb[1]-$sstrp)/100).", cont='".$strb->desc."', regtop='".$row['regtop']."', regup='".$row['regup']."', regfrom='".$row['regfrom']."', adddate='".date("Y-m-d H:i:s")."'";
//										echo $smoney."___".($sstrb[1]-$sstrp);
										$exe=mysql_query($sqla) or  die("数据库修改出错4!!!".mysql_error());
					
										$sqla="update ssc_member set leftmoney=leftmoney+".($smoney*($sstrb[1]-$sstrp)/100)." where username='".$susername."'"; 
										$exe=mysql_query($sqla) or  die("数据库修改出错12!!!".mysql_error());
										$sstrp=$sstrb[1];
									}
								}
							}						
						
						}
					}
					
				}else{
					$sqla = "select * from ssc_bills order by id desc limit 1";
					$rsa = mysql_query($sqla);
					$rowa = mysql_fetch_array($rsa);
					$dan = sprintf("%06s",strtoupper(base_convert($rowa['id']+1,10,36)));//注单
					
					$canceldead=Get_canceldate($lotteryid,$sissue);
					$sqla="INSERT INTO ssc_bills set lotteryid='".$lotteryid."', lottery='".$lottery."', dan='".$dan."', uid='".$_SESSION["sess_uid"]."', username='".$_SESSION["username"] ."', issue='".$sissue."', type='".$strb->type."', mid='".$strb->methodid."', codes='".$strb->codes."', nums='".$strb->nums."', times='".$strb->times."', money='".$strb->money."', mode='".$strb->mode."', rates='".$strb->prize."', point='".$spoint."', cont='".$strb->desc."', regtop='".$row['regtop']."', regup='".$row['regup']."', regfrom='".$row['regfrom']."', userip='".$_SERVER['REMOTE_ADDR']."', adddate='".date("Y-m-d H:i:s")."', canceldead='".$canceldead."'";
					$exe=mysql_query($sqla) or  die("数据库修改出错1!!".mysql_error());
	
					$lmoney=$leftmoney - $strb->money;
					$lmoney2=$lmoney + $strb->money * $spoint;
					
					$sqla="update ssc_member set leftmoney=".$lmoney2.", usedmoney=usedmoney+".$strb->money." where username='".$_SESSION["username"] ."'"; 
					$exe=mysql_query($sqla) or  die("数据库修改出错2!!!".mysql_error());
					
					$sqla = "select * from ssc_savelist where username='" . $_SESSION["username"] . "' order by id desc limit 1";
					$rsa = mysql_query($sqla);
					$rowa = mysql_fetch_array($rsa);
					
					$sqla="update ssc_savelist set xf=xf+".$strb->money." where id='".$rowa['id']."'"; 
					$exe=mysql_query($sqla) or  die("数据库修改出错2!!!".mysql_error());
					
					$sqla = "select * from ssc_record order by id desc limit 1";
					$rsa = mysql_query($sqla);
					$rowa = mysql_fetch_array($rsa);
					$dan1 = sprintf("%07s",strtoupper(base_convert($rowa['id']+1,10,36)));
					
					$sqla="insert into ssc_record set lotteryid='".$lotteryid."', lottery='".$lottery."', dan='".$dan1."', dan1='".$dan."', uid='".$_SESSION["sess_uid"]."', username='".$_SESSION["username"] ."', issue='".$sissue."', types='7', mid='".$strb->methodid."', mode='".$strb->mode."', zmoney=".$strb->money.",leftmoney=".$lmoney.", cont='".$strb->desc."', regtop='".$row['regtop']."', regup='".$row['regup']."', regfrom='".$row['regfrom']."', adddate='".date("Y-m-d H:i:s")."'";
					$exe=mysql_query($sqla) or  die("数据库修改出错3!!!".mysql_error());
					
//xc  返点					
					if($spoint!="0"){
						$sqla = "select * from ssc_record order by id desc limit 1";
						$rsa = mysql_query($sqla);
						$rowa = mysql_fetch_array($rsa);
						$dan1 = sprintf("%07s",strtoupper(base_convert($rowa['id']+1,10,36)));
						$sqla="insert into ssc_record set lotteryid='".$lotteryid."', lottery='".$lottery."', dan='".$dan1."', dan1='".$dan."', uid='".$_SESSION["sess_uid"]."', username='".$_SESSION["username"] ."', issue='".$sissue."', types='11', mid='".$strb->methodid."', mode='".$strb->mode."', smoney=".$strb->money*$spoint.",leftmoney=".$lmoney2.", cont='".$strb->desc."', regtop='".$row['regtop']."', regup='".$row['regup']."', regfrom='".$row['regfrom']."', adddate='".date("Y-m-d H:i:s")."'";
						$exe=mysql_query($sqla) or  die("数据库修改出错4!!!".mysql_error());
					}
					
					if($row['regfrom']!=""){
						$sstrp=$spoints*100;
						$regfrom=explode("&&",$row['regfrom']);
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
								$sqla="insert into ssc_record set lotteryid='".$lotteryid."', lottery='".$lottery."', dan='".$dan1."', dan1='".$dan."', uid='".Get_memid($susername)."', username='".$susername."', issue='".$sissue."', types='11', mid='".$strb->methodid."', mode='".$strb->mode."', smoney=".($strb->money*($sstrb[1]-$sstrp)/100).",leftmoney=".(Get_mmoneys($susername)+$strb->money*($sstrb[1]-$sstrp)/100).", cont='".$strb->desc."', regtop='".$row['regtop']."', regup='".$row['regup']."', regfrom='".$row['regfrom']."', adddate='".date("Y-m-d H:i:s")."'";
//								echo $strb->money."___".($sstrb[1]-$sstrp);
								$exe=mysql_query($sqla) or  die("数据库修改出错4!!!".mysql_error());
			
								$sqla="update ssc_member set leftmoney=leftmoney+".($strb->money*($sstrb[1]-$sstrp)/100)." where username='".$susername."'"; 
								$exe=mysql_query($sqla) or  die("数据库修改出错12!!!".mysql_error());
								$sstrp=$sstrb[1];
							}
						}
					}
					
				}
			}
		}else{//zh
			$zmoney=($strb->money/$strb->times)*$ztimes;
			if($leftmoney<$zmoney){
				$sfail=$sfail+1;
				if($sfail>1){
					$serr=$serr.",";
				}
				$serr=$serr."{\"desc\":\"[".$strb->desc."\",\"errmsg\":\"余额不足\"}";
			}else{
				$ssuccess=$ssuccess+1;
				
				//if($strb->methodid==32 || $strb->methodid==70 || $strb->methodid=="108" || $strb->methodid=="146" || $strb->methodid=="176" || $strb->methodid=="306" || $strb->methodid=="334"){
				if($strb->methodid==32 || $strb->methodid==33 || $strb->methodid==34 || $strb->methodid==35 || $strb->methodid==36 || $strb->methodid==70 || $strb->methodid=="108" || $strb->methodid=="109" || $strb->methodid=="110" || $strb->methodid=="111" || $strb->methodid=="112" || $strb->methodid=="146" || $strb->methodid=="147" || $strb->methodid=="148" || $strb->methodid=="149" || $strb->methodid=="150" || $strb->methodid=="176" || $strb->methodid=="306" || $strb->methodid=="307" || $strb->methodid=="308" || $strb->methodid=="334" || $strb->methodid=="335" || $strb->methodid=="336" || $strb->methodid=="337" || $strb->methodid=="338"){
					$strcs=$strb->codes;
					$stra=explode("|",$strcs);
					for ($i=0; $i<count($stra); $i++) {
						$smid=$strb->methodid+$i;
						$scodes=$stra[$i];
						$strc=explode("&",$stra[$i]);
						$snums=count($strc);
						$smoney=$snums*$strb->times*$modes * 2;
						$zmoney=($smoney/$strb->times)*$ztimes;
						if($scodes!=""){
						
							$sql = "select * from ssc_member where username='" . $_SESSION["username"] . "'";
							$rs = mysql_query($sql);
							$row = mysql_fetch_array($rs);
							$leftmoney=$row['leftmoney'];
	
					
							$sqla = "select * from ssc_zbills order by id desc limit 1";
							$rsa = mysql_query($sqla);
							$rowa = mysql_fetch_array($rsa);
							$dan = sprintf("%06s",strtoupper(base_convert($rowa['id']+1,10,36)));
							
							$sqla="INSERT INTO ssc_zbills set lotteryid='".$lotteryid."', lottery='".$lottery."', dan='".$dan."', uid='".$_SESSION["sess_uid"]."', username='".$_SESSION["username"] ."', issue='".$sissue."', type='".$strb->type."', mid='".$smid."', codes='".$scodes."', nums='".$snums."', znums='".$zcount."', money='".$zmoney."', mode='".$strb->mode."', rates='".$strb->prize."', point='".$spoint."', cont='".$strb->desc."', regtop='".$row['regtop']."', regup='".$row['regup']."', regfrom='".$row['regfrom']."', userip='".$_SERVER['REMOTE_ADDR']."', autostop='".$_REQUEST['lt_trace_stop']."', adddate='".date("Y-m-d H:i:s")."'";
							$exe=mysql_query($sqla) or  die("数据库修改出错5!!!!".mysql_error());
			
							$lmoney=$leftmoney - $zmoney;
			
							$sqla = "select * from ssc_record order by id desc limit 1";		//帐变zh扣款
							$rsa = mysql_query($sqla);
							$rowa = mysql_fetch_array($rsa);
							$dan1 = sprintf("%07s",strtoupper(base_convert($rowa['id']+1,10,36)));
							$sqla="insert into ssc_record set lotteryid='".$lotteryid."', lottery='".$lottery."', dan='".$dan1."', dan2='".$dan."', uid='".$_SESSION["sess_uid"]."', username='".$_SESSION["username"] ."', issue='".$sissue."', types='9', mid='".$smid."', mode='".$strb->mode."', zmoney=".$zmoney.",leftmoney=".$lmoney.", cont='".$strb->desc."', regtop='".$row['regtop']."', regup='".$row['regup']."', regfrom='".$row['regfrom']."', adddate='".date("Y-m-d H:i:s")."'";
							$exe=mysql_query($sqla) or  die("数据库修改出错6!!!".mysql_error());
							
							$sqla="update ssc_member set leftmoney=leftmoney-".$zmoney.", usedmoney=usedmoney+".$zmoney." where username='".$_SESSION["username"] ."'"; 
							$exe=mysql_query($sqla) or  die("数据库修改出错7!!!".mysql_error());
							
							$sqla = "select * from ssc_savelist where username='" . $_SESSION["username"] . "' order by id desc limit 1";
							$rsa = mysql_query($sqla);
							$rowa = mysql_fetch_array($rsa);
							
							$sqla="update ssc_savelist set xf=xf+".$zmoney." where id='".$rowa['id']."'"; 
							$exe=mysql_query($sqla) or  die("数据库修改出错2!!!".mysql_error());
							
							for ($ii=0; $ii<$zcount; $ii++) {
			//					$ztimes=$ztimes+$_REQUEST['lt_trace_times_'.$_REQUEST['lt_trace_issues'][$ii]];
								$dmoney=($smoney/$strb->times)*$_REQUEST['lt_trace_times_'.$_REQUEST['lt_trace_issues'][$ii]];
								$sqla="INSERT INTO ssc_zdetail set lotteryid='".$lotteryid."', lottery='".$lottery."', dan='".$dan."', uid='".$_SESSION["sess_uid"]."', username='".$_SESSION["username"] ."', issue='".$_REQUEST['lt_trace_issues'][$ii]."', type='".$strb->type."', mid='".$smid."', codes='".$scodes."', nums='".$snums."', times='".$_REQUEST['lt_trace_times_'.$_REQUEST['lt_trace_issues'][$ii]]."', money='".$dmoney."', mode='".$strb->mode."', rates='".$strb->prize."', point='".$spoint."', cont='".$strb->desc."', regtop='".$row['regtop']."', regup='".$row['regup']."', regfrom='".$row['regfrom']."', userip='".$_SERVER['REMOTE_ADDR']."', autostop='".$_REQUEST['lt_trace_stop']."', adddate='".date("Y-m-d H:i:s")."', canceldead='".Get_canceldate($lotteryid,$_REQUEST['lt_trace_issues'][$ii])."'";
								$exe=mysql_query($sqla) or  die("数据库修改出错8!!!!".mysql_error());
			
								if($_REQUEST['lt_trace_issues'][$ii]==$issue){
									$sqla = "update ssc_zbills set fnums=fnums+1, fmoney=fmoney+".$dmoney." where dan='".$dan."'";
									$rsa = mysql_query($sqla);
			
									$sqla = "select * from ssc_record order by id desc limit 1";
									$rsa = mysql_query($sqla);
									$rowa = mysql_fetch_array($rsa);
									$dan1 = sprintf("%07s",strtoupper(base_convert($rowa['id']+1,10,36)));//追号返款
									$sqla="insert into ssc_record set lotteryid='".$lotteryid."', lottery='".$lottery."', dan='".$dan1."', dan2='".$dan."', uid='".$_SESSION["sess_uid"]."', username='".$_SESSION["username"] ."', issue='".$_REQUEST['lt_trace_issues'][$ii]."', types='10', mid='".$smid."', mode='".$strb->mode."', smoney=".$dmoney.",leftmoney=".($lmoney+$dmoney).", cont='".$strb->desc."', regtop='".$row['regtop']."', regup='".$row['regup']."', regfrom='".$row['regfrom']."', adddate='".date("Y-m-d H:i:s")."'";
									$exe=mysql_query($sqla) or  die("数据库修改出错9!!!".mysql_error());
			
									$sqla = "select * from ssc_bills order by id desc limit 1";
									$rsa = mysql_query($sqla);
									$rowa = mysql_fetch_array($rsa);
									$dan2 = sprintf("%06s",strtoupper(base_convert($rowa['id']+1,10,36)));//转注单
									
									$sqla="INSERT INTO ssc_bills set lotteryid='".$lotteryid."', lottery='".$lottery."', dan='".$dan2."', dan1='".$dan."', uid='".$_SESSION["sess_uid"]."', username='".$_SESSION["username"] ."', issue='".$_REQUEST['lt_trace_issues'][$ii]."', type='".$strb->type."', mid='".$smid."', codes='".$scodes."', nums='".$snums."', times='".$_REQUEST['lt_trace_times_'.$_REQUEST['lt_trace_issues'][$ii]]."', money='".$dmoney."', mode='".$strb->mode."', rates='".$strb->prize."', point='".$spoint."', cont='".$strb->desc."', regtop='".$row['regtop']."', regup='".$row['regup']."', regfrom='".$row['regfrom']."', userip='".$_SERVER['REMOTE_ADDR']."', adddate='".date("Y-m-d H:i:s")."', canceldead='".Get_canceldate($lotteryid,$_REQUEST['lt_trace_issues'][$ii])."', autostop='".$_REQUEST['lt_trace_stop']."'";
									$exe=mysql_query($sqla) or  die("数据库修改出错10!!!!".mysql_error());
									
									$sqla = "update ssc_zdetail set danb='".$dan2."', zt=1 where dan='".$dan."' and issue='".$_REQUEST['lt_trace_issues'][$ii]."'";
									$rsa = mysql_query($sqla);
			
									$sqla = "select * from ssc_record order by id desc limit 1";
									$rsa = mysql_query($sqla);
									$rowa = mysql_fetch_array($rsa);
									$dan1 = sprintf("%07s",strtoupper(base_convert($rowa['id']+1,10,36)));//投注扣款
									$sqla="insert into ssc_record set lotteryid='".$lotteryid."', lottery='".$lottery."', dan='".$dan1."', dan1='".$dan2."', dan2='".$dan."', uid='".$_SESSION["sess_uid"]."', username='".$_SESSION["username"] ."', issue='".$_REQUEST['lt_trace_issues'][$ii]."', types='7', mid='".$smid."', mode='".$strb->mode."', zmoney=".$dmoney.",leftmoney=".$lmoney.", cont='".$strb->desc."', regtop='".$row['regtop']."', regup='".$row['regup']."', regfrom='".$row['regfrom']."', adddate='".date("Y-m-d H:i:s")."'";
									$exe=mysql_query($sqla) or  die("数据库修改出错11!!!".mysql_error());
									

//xc  返点															
									if($spoint!="0"){
										$sqla = "select * from ssc_record order by id desc limit 1";
										$rsa = mysql_query($sqla);
										$rowa = mysql_fetch_array($rsa);
										$dan1 = sprintf("%07s",strtoupper(base_convert($rowa['id']+1,10,36)));
										$sqla="insert into ssc_record set lotteryid='".$lotteryid."', lottery='".$lottery."', dan='".$dan1."', dan1='".$dan2."', dan2='".$dan."', uid='".$_SESSION["sess_uid"]."', username='".$_SESSION["username"] ."', issue='".$_REQUEST['lt_trace_issues'][$ii]."', types='11', mid='".$smid."', mode='".$strb->mode."', smoney=".$dmoney*$spoint.",leftmoney=".($lmoney+$dmoney*$spoint).", cont='".$strb->desc."', regtop='".$row['regtop']."', regup='".$row['regup']."', regfrom='".$row['regfrom']."', adddate='".date("Y-m-d H:i:s")."'";
										$exe=mysql_query($sqla) or  die("数据库修改出错4!!!".mysql_error());
			
										$sqla="update ssc_member set leftmoney=".($lmoney+$dmoney*$spoint)." where username='".$_SESSION["username"] ."'"; 
										$exe=mysql_query($sqla) or  die("数据库修改出错12!!!".mysql_error());
									}
										//上级返点
										
										if($row['regfrom']!=""){
											$sstrp=$spoints*100;
											$regfrom=explode("&&",$row['regfrom']);
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
													$sqla="insert into ssc_record set lotteryid='".$lotteryid."', lottery='".$lottery."', dan='".$dan1."', dan1='".$dan2."', dan2='".$dan."', uid='".Get_memid($susername)."', username='".$susername."', issue='".$_REQUEST['lt_trace_issues'][$ii]."', types='11', mid='".$smid."', mode='".$strb->mode."', smoney=".($dmoney*($sstrb[1]-$sstrp)/100).",leftmoney=".(Get_mmoneys($susername)+$dmoney*($sstrb[1]-$sstrp)/100).", cont='".$strb->desc."', regtop='".$row['regtop']."', regup='".$row['regup']."', regfrom='".$row['regfrom']."', adddate='".date("Y-m-d H:i:s")."'";
													$exe=mysql_query($sqla) or  die("数据库修改出错4!!!".mysql_error());
						
													$sqla="update ssc_member set leftmoney=leftmoney+".($dmoney*($sstrb[1]-$sstrp)/100)." where username='".$susername."'"; 
													$exe=mysql_query($sqla) or  die("数据库修改出错12!!!".mysql_error());
													$sstrp=$sstrb[1];
												}
											}
										}
								
								}
							}		
						}	
					}	
				}else{
					$sqla = "select * from ssc_zbills order by id desc limit 1";
					$rsa = mysql_query($sqla);
					$rowa = mysql_fetch_array($rsa);
					$dan = sprintf("%06s",strtoupper(base_convert($rowa['id']+1,10,36)));
					
					$sqla="INSERT INTO ssc_zbills set lotteryid='".$lotteryid."', lottery='".$lottery."', dan='".$dan."', uid='".$_SESSION["sess_uid"]."', username='".$_SESSION["username"] ."', issue='".$sissue."', type='".$strb->type."', mid='".$strb->methodid."', codes='".$strb->codes."', nums='".$strb->nums."', znums='".$zcount."', money='".$zmoney."', mode='".$strb->mode."', rates='".$strb->prize."', point='".$spoint."', cont='".$strb->desc."', regtop='".$row['regtop']."', regup='".$row['regup']."', regfrom='".$row['regfrom']."', userip='".$_SERVER['REMOTE_ADDR']."', autostop='".$_REQUEST['lt_trace_stop']."', adddate='".date("Y-m-d H:i:s")."'";
					$exe=mysql_query($sqla) or  die("数据库修改出错5!!!!".mysql_error());
	
					$lmoney=intval($leftmoney) - intval($zmoney);
	
					$sqla = "select * from ssc_record order by id desc limit 1";		//帐变zh扣款
					$rsa = mysql_query($sqla);
					$rowa = mysql_fetch_array($rsa);
					$dan1 = sprintf("%07s",strtoupper(base_convert($rowa['id']+1,10,36)));
					$sqla="insert into ssc_record set lotteryid='".$lotteryid."', lottery='".$lottery."', dan='".$dan1."', dan2='".$dan."', uid='".$_SESSION["sess_uid"]."', username='".$_SESSION["username"] ."', issue='".$sissue."', types='9', mid='".$strb->methodid."', mode='".$strb->mode."', zmoney=".$zmoney.",leftmoney=".$lmoney.", cont='".$strb->desc."', regtop='".$row['regtop']."', regup='".$row['regup']."', regfrom='".$row['regfrom']."', adddate='".date("Y-m-d H:i:s")."'";
					$exe=mysql_query($sqla) or  die("数据库修改出错6!!!".mysql_error());
					
					$sqla="update ssc_member set leftmoney=".$lmoney.", usedmoney=usedmoney+".$zmoney." where username='".$_SESSION["username"] ."'"; 
					$exe=mysql_query($sqla) or  die("数据库修改出错7!!!".mysql_error());
					
					$sqla = "select * from ssc_savelist where username='" . $_SESSION["username"] . "' order by id desc limit 1";
					$rsa = mysql_query($sqla);
					$rowa = mysql_fetch_array($rsa);
					
					$sqla="update ssc_savelist set xf=xf+".$zmoney." where id='".$rowa['id']."'"; 
					$exe=mysql_query($sqla) or  die("数据库修改出错2!!!".mysql_error());
					
					for ($ii=0; $ii<$zcount; $ii++) {
	//					$ztimes=$ztimes+$_REQUEST['lt_trace_times_'.$_REQUEST['lt_trace_issues'][$ii]];
						$dmoney=($strb->money/$strb->times)*$_REQUEST['lt_trace_times_'.$_REQUEST['lt_trace_issues'][$ii]];
						$sqla="INSERT INTO ssc_zdetail set lotteryid='".$lotteryid."', lottery='".$lottery."', dan='".$dan."', uid='".$_SESSION["sess_uid"]."', username='".$_SESSION["username"] ."', issue='".$_REQUEST['lt_trace_issues'][$ii]."', type='".$strb->type."', mid='".$strb->methodid."', codes='".$strb->codes."', nums='".$strb->nums."', times='".$_REQUEST['lt_trace_times_'.$_REQUEST['lt_trace_issues'][$ii]]."', money='".$dmoney."', mode='".$strb->mode."', rates='".$strb->prize."', point='".$spoint."', cont='".$strb->desc."', regtop='".$row['regtop']."', regup='".$row['regup']."', regfrom='".$row['regfrom']."', userip='".$_SERVER['REMOTE_ADDR']."', autostop='".$_REQUEST['lt_trace_stop']."', adddate='".date("Y-m-d H:i:s")."', canceldead='".Get_canceldate($lotteryid,$_REQUEST['lt_trace_issues'][$ii])."'";
						$exe=mysql_query($sqla) or  die("数据库修改出错8!!!!".mysql_error());
	
						if($_REQUEST['lt_trace_issues'][$ii]==$issue){
							$sqla = "update ssc_zbills set fnums=fnums+1, fmoney=fmoney+".$dmoney." where dan='".$dan."'";
							$rsa = mysql_query($sqla);
	
							$sqla = "select * from ssc_record order by id desc limit 1";
							$rsa = mysql_query($sqla);
							$rowa = mysql_fetch_array($rsa);
							$dan1 = sprintf("%07s",strtoupper(base_convert($rowa['id']+1,10,36)));//追号返款
							$sqla="insert into ssc_record set lotteryid='".$lotteryid."', lottery='".$lottery."', dan='".$dan1."', dan2='".$dan."', uid='".$_SESSION["sess_uid"]."', username='".$_SESSION["username"] ."', issue='".$_REQUEST['lt_trace_issues'][$ii]."', types='10', mid='".$strb->methodid."', mode='".$strb->mode."', smoney=".$dmoney.",leftmoney=".($lmoney+$dmoney).", cont='".$strb->desc."', regtop='".$row['regtop']."', regup='".$row['regup']."', regfrom='".$row['regfrom']."', adddate='".date("Y-m-d H:i:s")."'";
							$exe=mysql_query($sqla) or  die("数据库修改出错9!!!".mysql_error());
	
							$sqla = "select * from ssc_bills order by id desc limit 1";
							$rsa = mysql_query($sqla);
							$rowa = mysql_fetch_array($rsa);
							$dan2 = sprintf("%06s",strtoupper(base_convert($rowa['id']+1,10,36)));//转注单
							
							$sqla="INSERT INTO ssc_bills set lotteryid='".$lotteryid."', lottery='".$lottery."', dan='".$dan2."', dan1='".$dan."', uid='".$_SESSION["sess_uid"]."', username='".$_SESSION["username"] ."', issue='".$_REQUEST['lt_trace_issues'][$ii]."', type='".$strb->type."', mid='".$strb->methodid."', codes='".$strb->codes."', nums='".$strb->nums."', times='".$_REQUEST['lt_trace_times_'.$_REQUEST['lt_trace_issues'][$ii]]."', money='".$dmoney."', mode='".$strb->mode."', rates='".$strb->prize."', point='".$spoint."', cont='".$strb->desc."', regtop='".$row['regtop']."', regup='".$row['regup']."', regfrom='".$row['regfrom']."', userip='".$_SERVER['REMOTE_ADDR']."', adddate='".date("Y-m-d H:i:s")."', canceldead='".Get_canceldate($lotteryid,$_REQUEST['lt_trace_issues'][$ii])."', autostop='".$_REQUEST['lt_trace_stop']."'";
							$exe=mysql_query($sqla) or  die("数据库修改出错10!!!!".mysql_error());
							
							$sqla = "update ssc_zdetail set danb='".$dan2."', zt=1 where dan='".$dan."' and issue='".$_REQUEST['lt_trace_issues'][$ii]."'";
							$rsa = mysql_query($sqla);
	
							$sqla = "select * from ssc_record order by id desc limit 1";
							$rsa = mysql_query($sqla);
							$rowa = mysql_fetch_array($rsa);
							$dan1 = sprintf("%07s",strtoupper(base_convert($rowa['id']+1,10,36)));//投注扣款
							$sqla="insert into ssc_record set lotteryid='".$lotteryid."', lottery='".$lottery."', dan='".$dan1."', dan1='".$dan2."', dan2='".$dan."', uid='".$_SESSION["sess_uid"]."', username='".$_SESSION["username"] ."', issue='".$_REQUEST['lt_trace_issues'][$ii]."', types='7', mid='".$strb->methodid."', mode='".$strb->mode."', zmoney=".$dmoney.",leftmoney=".$lmoney.", cont='".$strb->desc."', regtop='".$row['regtop']."', regup='".$row['regup']."', regfrom='".$row['regfrom']."', adddate='".date("Y-m-d H:i:s")."'";
							$exe=mysql_query($sqla) or  die("数据库修改出错11!!!".mysql_error());
							

//xc  返点													
							if($spoint!="0"){
								$sqla = "select * from ssc_record order by id desc limit 1";
								$rsa = mysql_query($sqla);
								$rowa = mysql_fetch_array($rsa);
								$dan1 = sprintf("%07s",strtoupper(base_convert($rowa['id']+1,10,36)));
								$sqla="insert into ssc_record set lotteryid='".$lotteryid."', lottery='".$lottery."', dan='".$dan1."', dan1='".$dan2."', dan2='".$dan."', uid='".$_SESSION["sess_uid"]."', username='".$_SESSION["username"] ."', issue='".$_REQUEST['lt_trace_issues'][$ii]."', types='11', mid='".$strb->methodid."', mode='".$strb->mode."', smoney=".$dmoney*$spoint.",leftmoney=".($lmoney+$dmoney*$spoint).", cont='".$strb->desc."', regtop='".$row['regtop']."', regup='".$row['regup']."', regfrom='".$row['regfrom']."', adddate='".date("Y-m-d H:i:s")."'";
								$exe=mysql_query($sqla) or  die("数据库修改出错4!!!".mysql_error());
	
								$sqla="update ssc_member set leftmoney=".($lmoney+$dmoney*$spoint)." where username='".$_SESSION["username"] ."'"; 
								$exe=mysql_query($sqla) or  die("数据库修改出错12!!!".mysql_error());
							}
								//上级返点
								
								if($row['regfrom']!=""){
									$sstrp=$spoints*100;
									$regfrom=explode("&&",$row['regfrom']);
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
											$sqla="insert into ssc_record set lotteryid='".$lotteryid."', lottery='".$lottery."', dan='".$dan1."', dan1='".$dan2."', dan2='".$dan."', uid='".Get_memid($susername)."', username='".$susername."', issue='".$_REQUEST['lt_trace_issues'][$ii]."', types='11', mid='".$strb->methodid."', mode='".$strb->mode."', smoney=".($dmoney*($sstrb[1]-$sstrp)/100).",leftmoney=".(Get_mmoneys($susername)+$dmoney*($sstrb[1]-$sstrp)/100).", cont='".$strb->desc."', regtop='".$row['regtop']."', regup='".$row['regup']."', regfrom='".$row['regfrom']."', adddate='".date("Y-m-d H:i:s")."'";
											$exe=mysql_query($sqla) or  die("数据库修改出错4!!!".mysql_error());
				
											$sqla="update ssc_member set leftmoney=leftmoney+".($dmoney*($sstrb[1]-$sstrp)/100)." where username='".$susername."'"; 
											$exe=mysql_query($sqla) or  die("数据库修改出错12!!!".mysql_error());
											$sstrp=$sstrb[1];
										}
									}
								}
						
						}
					}
				}
			}
		}
	}
	if($sfail>0){
		echo "{\"stats\":\"fail\",\"data\":{\"success\":".$ssuccess.",\"fail\":".$sfail.",\"content\":[".$serr."]}}";
	}else{
		echo "success";
	}	
?>