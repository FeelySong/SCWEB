<?php
include_once ("connect.php");
$bianhao[1] = '';
$bianhao[2] = '';

// 获得当前期号, 期号以当前年月日时分表示,如201312012359
function GetQiHao ()
{
    // $result=mysql_query("select * from yx_kjtime where
    // kjtime='".date("H:i:00")."'");
    // $row=mysql_fetch_array($result);
    // $qihao=date("Ymd").$row['qihao'];
    // return $qihao;
    return date("YmdHi");
}

// 生成赔率
function GetPeiLv ()
{
    $qihao = GetQiHao();
    $result_peilv = mysql_query(
            "select * from yx_startinfo where qihao='" . $qihao . "'");
    $row_peilv = mysql_fetch_array($result_peilv);
    $peilv = $row_peilv['peilv'];
    return $peilv;
}

// 这个方法要从数据库读取用户名的密码判断是否正确
function CheckUserInfo ($username, $password)
{
    $username = mysql_real_escape_string($username);
    $password = mysql_real_escape_string($password);
    
    $result_mem = mysql_query(
            "select * from ssc_member where username='$username' and password='$password'");
    $row_mem = mysql_fetch_array($result_mem);
    if ($row_mem['id'])
    {
        return true;
    }
    return false;
}

// 盈利模式
function yingli($kjbh)
{
	$qihao = GetQihao();
    
//    $result = mysql_query(
//            "select * from yx_startinfo where qihao='" . $qihao . "'");
//    if (! mysql_num_rows($result))
//        return 0;
    
    $peilv = explode(" ", GetPeiLv());
		$result_kj = mysql_query("select * from ssc_bills where issue='$qihao'");
		while ($row_kj = mysql_fetch_array($result_kj))
		{
			if ($kjbh == $row_kj['codes'])
			{
				// 中奖
				$jiangjin = 0;
				if ($kjbh > 0 && $kjbh < 9)
				{
					$jiangjin = $row_kj['money'] * $peilv[$kjbh - 1];
				} else 
					if ($kjbh == 11)
					{
						$jiangjin = $jiangjin+$row_kj['money'] * 36;
					} else 
						if ($kjbh == 12)
						{
							$jiangjin = $jiangjin+$row_kj['money'] * 24;
						}
			} else 
				if ($row_kj['codes'] == 9)
				{
					if ($kjbh == 1 || $kjbh == 3 || $kjbh == 5 || $kjbh == 7)
					{
						// 中奖
						$jiangjin = $jiangjin+$row_kj['money'] * 2;
					}
				} else 
					if ($row_kj['codes'] == 10)
					{
						if ($kjbh == 2 || $kjbh == 4 || $kjbh == 6 || $kjbh == 8)
						{
							// 中奖
							$jiangjin = $jiangjin+$row_kj['money'] * 2;
						}
					} 
		}

		$result_xz = mysql_query("select sum(money) as money_zj from ssc_bills where issue='$qihao'");
		$row_xz = mysql_fetch_array($result_xz);		
		if($jiangjin>$row_xz['money_zj']){
			if($kjbh==5){
				$kjbh1=6;	
			}elseif($kjbh==6){
				$kjbh1=7;	
			}elseif($kjbh==7){
				$kjbh1=8;	
			}elseif($kjbh==8){
				$kjbh1=7;	
			}else{
				$kjbh1=7;	
			}
		}else{
			$kjbh1=$kjbh;
		}
		return $kjbh1;
}
		
// 将投注信息写入到数据库,$arr的键=动物类型,值=投注金额
function WriteTouZhu ($username, $arr) // 键从1-12
{
    $qihao = GetQiHao();
    foreach ($arr as $tz_id => $tz_jine)
    {
        $result_mem = mysql_query(
                "select * from ssc_member where username='$username'");
        $row_mem = mysql_fetch_array($result_mem);
        $uid = $row_mem['id'];
        if ($uid)
        {
            
            if ($row_mem['leftmoney'] - $tz_jine < 0)
            {
                // 金额不足,记录
                return;
            }
            $jine = $row_mem['leftmoney'] - $tz_jine;
            mysql_query(
                    "update ssc_member set leftmoney='$jine' where id='" . $uid . "'");
//            mysql_query(
//                    "insert into yx_touzhu(uid,tz_id,tz_jine,qishu,zhtai,jiangjin)values('$uid','$tz_id','$tz_jine','$qihao','0','0')");
			$sqla = "select * from ssc_bills order by id desc limit 1";
			$rsa = mysql_query($sqla);
			$rowa = mysql_fetch_array($rsa);
			$dan = sprintf("%06s",strtoupper(base_convert($rowa['id']+1,10,36)));//注单
			mysql_query(
                    "INSERT INTO ssc_bills set lotteryid='100', lottery='金鲨银鲨', dan='".$dan."', uid='".$uid."', username='".$username."', issue='".$qihao."', type='digital', mid='0', codes='".$tz_id."', nums='0', times='0', money='".$tz_jine."', mode='1', rates='0', point='0', cont='0', regtop='".$row_mem['regtop']."', regup='".$row_mem['regup']."', regfrom='".$row_mem['regfrom']."', userip='".$_SERVER['REMOTE_ADDR']."', adddate='".date("Y-m-d H:i:s")."', canceldead='".$canceldead."'");
					
			$sqla = "select * from ssc_record order by id desc limit 1";
			$rsa = mysql_query($sqla);
			$rowa = mysql_fetch_array($rsa);
			$dan1 = sprintf("%07s",strtoupper(base_convert($rowa['id']+1,10,36)));
			$sqla="insert into ssc_record set lotteryid='100', lottery='金鲨银鲨', dan='".$dan1."', dan1='".$dan."', uid='".$uid."', username='".$username."', issue='".$qihao."', types='7', mid='0', mode='1', zmoney=".$tz_jine.",leftmoney=".$jine.", cont='0', regtop='".$row_mem['regtop']."', regup='".$row_mem['regup']."', regfrom='".$row_mem['regfrom']."', adddate='".date("Y-m-d H:i:s")."'";
			$exe=mysql_query($sqla) or  die("数据库修改出错4!!!".mysql_error());
        }
    }
}

// 获得用户的当前总金额
function GetUserZJE ($username)
{
    $result_mem = mysql_query(
            "select * from ssc_member where username='$username'");
    $row_mem = mysql_fetch_array($result_mem);
    return $row_mem['leftmoney'];
}

// 最后一期中奖金额,没投注这期就是0
function GetUserZJJE ($username)
{
    $qiahao = GetQiHao();
    $result_kj = mysql_query(
            "select * from ssc_member where username='$username'");
    $row_kj = @mysql_fetch_array($result_kj);
    $uid = $row_kj['id'];
    $jiangjin = 0;
    
    $result_kj = mysql_query(
            "select * from ssc_bills where issue='$qiahao' and uid='$uid'");
    while ($row = mysql_fetch_array($result_kj))
    {
        $jiangjin += $row['prize'];
    }
    return $jiangjin;
}
// 从数据库获得最后一期的开奖编号
function GetKJHM ()
{
    $qihao = GetQiHao();
    $result_kj = mysql_query("select * from yx_kaijiang where qihao='$qihao'");
    $row_kj = @mysql_fetch_array($result_kj);
    return $row_kj['bianhao'];
}

// 开局信息,获得倒计时,暂时固定是45,
function GetTimeLeft ()
{
    return "40";
}

// objAnimal[1] = "yinsha";
// objAnimal[2] = "laoying";
// objAnimal[3] = "laoying";
// objAnimal[4] = "laoying";
// objAnimal[5] = "jinsha";
// objAnimal[6] = "shizi";
// objAnimal[7] = "shizi";
// objAnimal[8] = "shizi";
// objAnimal[9] = "yinsha";
// objAnimal[10] = "xiongmao";
// objAnimal[11] = "xiongmao";
// objAnimal[12] = "jinsha";
// objAnimal[13] = "houzi";
// objAnimal[14] = "houzi";
// objAnimal[15] = "yinsha";
// objAnimal[16] = "tuzi";
// objAnimal[17] = "tuzi";
// objAnimal[18] = "tuzi";
// objAnimal[19] = "jinsha";
// objAnimal[20] = "yanzi";
// objAnimal[21] = "yanzi";
// objAnimal[22] = "yanzi";
// objAnimal[23] = "yinsha";
// objAnimal[24] = "gezi";
// objAnimal[25] = "gezi";
// objAnimal[26] = "jinsha";
// objAnimal[27] = "kongque";
// objAnimal[28] = "kongque";

// 计算开奖,写入数据库
function CalCKJ ()
{
    $qihao = GetQihao();
    
    $result = mysql_query(
            "select * from yx_startinfo where qihao='" . $qihao . "'");
    if (! mysql_num_rows($result))
        return 0;
    
    $peilv = explode(" ", GetPeiLv());
    
    // 开奖编号
    $kjbh_arr = array(
            1 => '1',
            2 => '2',
            3 => '3',
            4 => '4',
            5 => '5',
            6 => '6',
            7 => '7',
            8 => '8',
            9 => '11',
            10 => '12'
    );
    
    // 旋转显示编号
    $kjxsbh_arr[1] = array(
            1 => '2',
            2 => '3',
            3 => '4'
    );
    $kjxsbh_arr[2] = array(
            1 => '6',
            2 => '7',
            3 => '8'
    );
    $kjxsbh_arr[3] = array(
            1 => '27',
            2 => '28'
    );
    $kjxsbh_arr[4] = array(
            1 => '10',
            2 => '11'
    );
    $kjxsbh_arr[5] = array(
            1 => '24',
            2 => '25'
    );
    $kjxsbh_arr[6] = array(
            1 => '13',
            2 => '14'
    );
    $kjxsbh_arr[7] = array(
            1 => '20',
            2 => '21',
            3 => '22'
    );
    $kjxsbh_arr[8] = array(
            1 => '16',
            2 => '17',
            3 => '18'
    );
    $kjxsbh_arr[11] = array(
            1 => '5',
            2 => '12',
            3 => '19',
            4 => '26'
    );
    $kjxsbh_arr[12] = array(
            1 => '1',
            2 => '9',
            3 => '15',
            4 => '23'
    );
	
    $sql="select * from ssc_config";
	$query_mode = mysql_query($sql);
	$rs_mode = mysql_fetch_array($query_mode);
	if($rs_mode['jsys_mode']==1){
		$kjbh1 = $kjbh_arr[rand(1, 10)];
		$kjbh=yingli($kjbh1);
	}else{
		$kjbh = $kjbh_arr[rand(1, 10)];	
	}
    $result_kj = mysql_query("select * from ssc_bills where issue='$qihao'");
    while ($row_kj = mysql_fetch_array($result_kj))
    {
        if ($kjbh == $row_kj['codes'])
        {
            // 中奖
            $jiangjin = 0;
            if ($kjbh > 0 && $kjbh < 9)
            {
                $jiangjin = $row_kj['money'] * $peilv[$kjbh - 1];
            } else 
                if ($kjbh == 11)
                {
                    $jiangjin = $row_kj['money'] * 36;
                } else 
                    if ($kjbh == 12)
                    {
                        $jiangjin = $row_kj['money'] * 24;
                    }
            mysql_query(
                    "update ssc_bills set zt=1,prize='" . $jiangjin .
                             "',kjcode='$kjbh' where id=" . $row_kj['id']);
            $result_mem = mysql_query(
                    "select * from ssc_member where id='" . $row_kj['uid'] . "'");
            $row_mem = mysql_fetch_array($result_mem);
            $jine = $row_mem['leftmoney'] + $jiangjin;
			
			$sqla = "select * from ssc_record order by id desc limit 1";
			$rsa = mysql_query($sqla);
			$rowa = mysql_fetch_array($rsa);
			$dan1 = sprintf("%07s",strtoupper(base_convert($rowa['id']+1,10,36)));
			$lmoney =$jine;
			$sqla="insert into ssc_record set lotteryid='100', lottery='金鲨银鲨', dan='".$dan1."', dan1='".$rows['dan']."', dan2='".$row_kj['dan1']."', uid='".$row_kj['uid']."', username='".$row_kj['username']."', issue='".$row_kj['issue']."', types='12', mid='".$row_kj['mid']."', mode='".$row_kj['mode']."', smoney=".$jiangjin.",leftmoney=".$lmoney.", cont='".$row_kj['cont']."', regtop='".$row_kj['regtop']."', regup='".$row_kj['regup']."', regfrom='".$row_kj['regfrom']."', adddate='".date("Y-m-d H:i:s")."'";
			$exe=mysql_query($sqla) or  die("数据库修改出错!!!".mysql_error());
				
            mysql_query(
                    "update ssc_member set leftmoney='$jine' where id='" .
                             $row_kj['uid'] . "'");
        } else 
            if ($row_kj['codes'] == 9)
            {
                if ($kjbh == 1 || $kjbh == 3 || $kjbh == 5 || $kjbh == 7)
                {
                    // 中奖
                    $jiangjin = $row_kj['money'] * 2;
                    mysql_query(
                            "update ssc_bills set zt=1,prize='" . $jiangjin .
                                     "',kjcode='$kjbh' where id=" . $row_kj['id']);
                    $result_mem = mysql_query(
                            "select * from ssc_member where id='" . $row_kj['uid'] .
                                     "'");
                    $row_mem = mysql_fetch_array($result_mem);
                    $jine = $row_mem['leftmoney'] + $jiangjin;
			
			$sqla = "select * from ssc_record order by id desc limit 1";
			$rsa = mysql_query($sqla);
			$rowa = mysql_fetch_array($rsa);
			$dan1 = sprintf("%07s",strtoupper(base_convert($rowa['id']+1,10,36)));
			$lmoney =$jine;
			$sqla="insert into ssc_record set lotteryid='100', lottery='金鲨银鲨', dan='".$dan1."', dan1='".$rows['dan']."', dan2='".$row_kj['dan1']."', uid='".$row_kj['uid']."', username='".$row_kj['username']."', issue='".$row_kj['issue']."', types='12', mid='".$row_kj['mid']."', mode='".$row_kj['mode']."', smoney=".$jiangjin.",leftmoney=".$lmoney.", cont='".$row_kj['cont']."', regtop='".$row_kj['regtop']."', regup='".$row_kj['regup']."', regfrom='".$row_kj['regfrom']."', adddate='".date("Y-m-d H:i:s")."'";
			$exe=mysql_query($sqla) or  die("数据库修改出错!!!".mysql_error());
					
                    mysql_query(
                            "update ssc_member set leftmoney='$jine' where id='" .
                                     $row_kj['uid'] . "'");
                } else
                {
                    // 未中奖
                    mysql_query(
                            "update ssc_bills set zt=2,prize='0',kjcode='$kjbh' where id=" .
                                     $row_kj['id']);
                }
            } else 
                if ($row_kj['codes'] == 10)
                {
                    if ($kjbh == 2 || $kjbh == 4 || $kjbh == 6 || $kjbh == 8)
                    {
                        // 中奖
                        $jiangjin = $row_kj['money'] * 2;
                        mysql_query(
                                "update ssc_bills set zt=1,prize='" .
                                         $jiangjin . "',kjcode='$kjbh' where id=" .
                                         $row_kj['id']);
                        $result_mem = mysql_query(
                                "select * from ssc_member where id='" .
                                         $row_kj['uid'] . "'");
                        $row_mem = mysql_fetch_array($result_mem);
                        $jine = $row_mem['leftmoney'] + $jiangjin;
						
						$sqla = "select * from ssc_record order by id desc limit 1";
						$rsa = mysql_query($sqla);
						$rowa = mysql_fetch_array($rsa);
						$dan1 = sprintf("%07s",strtoupper(base_convert($rowa['id']+1,10,36)));
						$lmoney =$jine;
						$sqla="insert into ssc_record set lotteryid='100', lottery='金鲨银鲨', dan='".$dan1."', dan1='".$rows['dan']."', dan2='".$row_kj['dan1']."', uid='".$row_kj['uid']."', username='".$row_kj['username']."', issue='".$row_kj['issue']."', types='12', mid='".$row_kj['mid']."', mode='".$row_kj['mode']."', smoney=".$jiangjin.",leftmoney=".$lmoney.", cont='".$row_kj['cont']."', regtop='".$row_kj['regtop']."', regup='".$row_kj['regup']."', regfrom='".$row_kj['regfrom']."', adddate='".date("Y-m-d H:i:s")."'";
						$exe=mysql_query($sqla) or  die("数据库修改出错!!!".mysql_error());
			
                        mysql_query(
                                "update ssc_member set leftmoney='$jine' where id='" .
                                         $row_kj['uid'] . "'");
                    } else
                    {
                        // 未中奖
                        mysql_query(
                                "update ssc_bills set zt=2,prize='0',kjcode='$kjbh' where id=" .
                                         $row_kj['id']);
                    }
                } else
                {
                    // 未中奖
                    mysql_query(
                            "update ssc_bills set zt=2,prize='0',kjcode='$kjbh' where id=" .
                                     $row_kj['id']);
                }
    }
    
    $kjxsbh_num = count($kjxsbh_arr[$kjbh]);
    $kjxsbh = $kjxsbh_arr[$kjbh][rand(1, $kjxsbh_num)];
    mysql_query(
            "insert into yx_kaijiang(qihao,bianhao)values('$qihao','$kjxsbh')");
    
    return 1;
}
// 开始新的一局
function initnew ()
{
    $qihao = GetQiHao();
    
    $result_peilv = mysql_query(
            "select * from yx_startinfo where qihao='" . $qihao . "'");
    $row_peilv = mysql_fetch_array($result_peilv);
    if (! $row_peilv['peilv'])
    {
        $result_peilv = mysql_query(
                "select * from yx_peilv order by rand() limit 0,1");
        $row_peilv = mysql_fetch_array($result_peilv);
        $peilv = $row_peilv['content'];
        mysql_query(
                "insert into yx_startinfo(`qihao` ,`peilv`)values('$qihao','$peilv')");
    }
}


?>