<?php
session_start();
error_reporting(0);
require_once 'conn.php';

	$sqla = "select * from ssc_manager WHERE username='" . $_SESSION['ausername'] . "'";
	$rsa = mysql_query($sqla);
	$rowa = mysql_fetch_array($rsa);

	$sqlb="select DATE_FORMAT( adddate, '%Y-%m-%d' ) AS t0,SUM(IF(types = 1, smoney, 0)) as t1,SUM(IF(types = 2, zmoney, 0)) as t2,SUM(IF(types = 3, smoney, 0)) as t3,SUM(IF(types = 7, zmoney, 0)) as t7,SUM(IF(types = 11, smoney, 0)) as t11,SUM(IF(types = 12, smoney, 0)) as t12,SUM(IF(types = 13, smoney, 0)) as t13,SUM(IF(types = 15, zmoney, 0)) as t15,SUM(IF(types = 16, zmoney, 0)) as t16,SUM(IF(types = 32, smoney, 0)) as t32,SUM(IF(types = 40, smoney, 0)) as t40 from ssc_record where DATE_FORMAT( adddate, '%Y-%m-%d' )='".date("Y-m-d")."'";
	$rsb = mysql_query($sqlb);
	$rowb = mysql_fetch_array($rsb);
	if(empty($rowb)){
		$at1=0;
		$at2=0;
		$at3=0;
		$at4=0;
		$at5=0;
		$at6=0;
		$at7=0;
		$at8=0;
	}else{
		$at1=number_format($rowb['t1'],2);
		$at2=number_format($rowb['t2']-$rowb['t3'],2);
		$at3=number_format($rowb['t7']-$rowb['t13'],2);
		$at4=number_format($rowb['t12']-$rowb['t16'],2);
		$at5=number_format($rowb['t11']-$rowb['t15'],2);
		$at6=number_format($rowb['t40'],2);
		$at7=number_format($rowb['t32'],2);
		$at8=$rowb['t7']-$rowb['t11']-$rowb['t12']-$rowb['t13']+$rowb['t15']+$rowb['t16']-$rowb['t32']-$rowb['t40'];
	}

	$sqlc="select DATE_FORMAT( adddate, '%Y-%m-%d' ) AS t0,SUM(IF(types = 1, smoney, 0)) as t1,SUM(IF(types = 2, zmoney, 0)) as t2,SUM(IF(types = 3, smoney, 0)) as t3,SUM(IF(types = 7, zmoney, 0)) as t7,SUM(IF(types = 11, smoney, 0)) as t11,SUM(IF(types = 12, smoney, 0)) as t12,SUM(IF(types = 13, smoney, 0)) as t13,SUM(IF(types = 15, zmoney, 0)) as t15,SUM(IF(types = 16, zmoney, 0)) as t16,SUM(IF(types = 32, smoney, 0)) as t32,SUM(IF(types = 40, smoney, 0)) as t40 from ssc_record where DATE_FORMAT( adddate, '%Y-%m-%d' )='".date("Y-m-d",strtotime("-1 day"))."'";
	$rsc = mysql_query($sqlc);
	$rowc = mysql_fetch_array($rsc);
	if(empty($rowc)){
		$bt1=0;
		$bt2=0;
		$bt3=0;
		$bt4=0;
		$bt5=0;
		$bt6=0;
		$bt7=0;
		$bt8=0;
	}else{
		$bt1=number_format($rowc['t1'],2);
		$bt2=number_format($rowc['t2']-$rowc['t3'],2);
		$bt3=number_format($rowc['t7']-$rowc['t13'],2);
		$bt4=number_format($rowc['t12']-$rowc['t16'],2);
		$bt5=number_format($rowc['t11']-$rowc['t15'],2);
		$bt6=number_format($rowc['t40'],2);
		$bt7=number_format($rowc['t32'],2);
		$bt8=$rowc['t7']-$rowc['t11']-$rowc['t12']-$rowc['t13']+$rowc['t15']+$rowc['t16']-$rowc['t32']-$rowc['t40'];
	}

	$sqld="select DATE_FORMAT( adddate, '%Y-%m' ) AS t0,SUM(IF(types = 1, smoney, 0)) as t1,SUM(IF(types = 2, zmoney, 0)) as t2,SUM(IF(types = 3, smoney, 0)) as t3,SUM(IF(types = 7, zmoney, 0)) as t7,SUM(IF(types = 11, smoney, 0)) as t11,SUM(IF(types = 12, smoney, 0)) as t12,SUM(IF(types = 13, smoney, 0)) as t13,SUM(IF(types = 15, zmoney, 0)) as t15,SUM(IF(types = 16, zmoney, 0)) as t16,SUM(IF(types = 32, smoney, 0)) as t32,SUM(IF(types = 40, smoney, 0)) as t40 from ssc_record where DATE_FORMAT( adddate, '%Y-%m' )='".date("Y-m")."'";
	$rsd = mysql_query($sqld);
	$rowd = mysql_fetch_array($rsd);
	if(empty($rowd)){
		$ct1=0;
		$ct2=0;
		$ct3=0;
		$ct4=0;
		$ct5=0;
		$ct6=0;
		$ct7=0;
		$ct8=0;
	}else{
		$ct1=number_format($rowd['t1'],2);
		$ct2=number_format($rowd['t2']-$rowd['t3'],2);
		$ct3=number_format($rowd['t7']-$rowd['t13'],2);
		$ct4=number_format($rowd['t12']-$rowd['t16'],2);
		$ct5=number_format($rowd['t11']-$rowd['t15'],2);
		$ct6=number_format($rowd['t40'],2);
		$ct7=number_format($rowd['t32'],2);
		$ct8=$rowd['t7']-$rowd['t11']-$rowd['t12']-$rowd['t13']+$rowd['t15']+$rowd['t16']-$rowd['t32']-$rowd['t40'];
	}
	
	$sqle="select DATE_FORMAT( adddate, '%Y-%m' ) AS t0,SUM(IF(types = 1, smoney, 0)) as t1,SUM(IF(types = 2, zmoney, 0)) as t2,SUM(IF(types = 3, smoney, 0)) as t3,SUM(IF(types = 7, zmoney, 0)) as t7,SUM(IF(types = 11, smoney, 0)) as t11,SUM(IF(types = 12, smoney, 0)) as t12,SUM(IF(types = 13, smoney, 0)) as t13,SUM(IF(types = 15, zmoney, 0)) as t15,SUM(IF(types = 16, zmoney, 0)) as t16,SUM(IF(types = 32, smoney, 0)) as t32,SUM(IF(types = 40, smoney, 0)) as t40 from ssc_record where DATE_FORMAT( adddate, '%Y-%m' )='".date("Y-m",strtotime("-1 month"))."'";
	$rse = mysql_query($sqle);
	$rowe = mysql_fetch_array($rse);
	if(empty($rowe)){
		$dt1=0;
		$dt2=0;
		$dt3=0;
		$dt4=0;
		$dt5=0;
		$dt6=0;
		$dt7=0;
		$dt8=0;
	}else{
		$dt1=number_format($rowe['t1'],2);
		$dt2=number_format($rowe['t2']-$rowe['t3'],2);
		$dt3=number_format($rowe['t7']-$rowe['t13'],2);
		$dt4=number_format($rowe['t12']-$rowe['t16'],2);
		$dt5=number_format($rowe['t11']-$rowe['t15'],2);
		$dt6=number_format($rowe['t40'],2);
		$dt7=number_format($rowe['t32'],2);
		$dt8=$rowe['t7']-$rowe['t11']-$rowe['t12']-$rowe['t13']+$rowe['t15']+$rowe['t16']-$rowe['t32']-$rowe['t40'];
	}
			
	$sqlf = "SELECT count(IF(DATE_FORMAT(regdate,'%Y-%m-%d')='".date('Y-m-d')."', id, null)) as numa,count(IF(DATE_FORMAT(regdate,'%Y-%m')='".date('Y-m')."', id, null)) as numb,count(IF(DATE_FORMAT(regdate,'%Y-%m')='".date('Y-m',strtotime("-1 month"))."', id, null)) as numc, count(IF(level = 0, level, null)) as numd, count(IF(level = 1, level, null)) as nume, count(*) as numf, count(*) as numf, sum(leftmoney) as numg FROM ssc_member";
	$rsf = mysql_query($sqlf);
	$rowf = mysql_fetch_array($rsf);

	$sqlg = "SELECT count(*) as numa FROM ssc_online WHERE yzstatus=0";
	$rsg = mysql_query($sqlg);
	$rowg = mysql_fetch_array($rsg);
?>
<html>
<head>
<link href="css/index.css" rel="stylesheet" type="text/css">
<base target="mainframe" />
<style>
.itab{
	bordr-collapse:collapse;
	border-top-width: 1;
	border-right-width: 0;
	border-bottom-width: 1;
	border-left-width: 0;
	border-top-style: solid;
	border-right-style: dashed;
	border-bottom-style: solid;
	border-left-style: dashed;
	border-top-color: #E8E8E8;
	border-bottom-color: #E8E8E8;
}

.itab1 {	bordr-collapse:collapse;
	border-top-width: 1;
	border-right-width: 0;
	border-bottom-width: 1;
	border-left-width: 0;
	border-top-style: solid;
	border-right-style: dashed;
	border-bottom-style: solid;
	border-left-style: dashed;
	border-top-color: #E8E8E8;
	border-bottom-color: #E8E8E8;
}
</style>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>

<body>
<br>
	<table width="95%" border="0" cellpadding="0" cellspacing="0" class="itop_list">
      <tr>
        <td width="40" class="top_list_td"><div align="center"><img src="images/icona.jpg" width="31" height="35"></div></td>
        <td colspan="4">您好，尊敬的 <?=$_SESSION['ausername']?><span class="Font_R">【超级管理员】</span></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>本次登录IP:<?=$rowa['lastip']?></td>
        <td>上次登录IP:<?=$rowa['lastip2']?></td>
        <td width="20"><img src="images/icond.jpg" width="18" height="18"></td>
        <td>上次登录时间:
        <?=$rowa['lastdate2']?></td>
      </tr>
    </table>
<br>
    <table width="95%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="40" class="top_list_td"><div align="center"><img src="images/iconb.jpg" width="27" height="27"></div></td>
        <td class="top_list_td Font_I">盈亏统计</td>
        <td width="100">&nbsp;</td>
      </tr>
    </table>
<br>
<table width="95%" border="1" cellpadding="0" cellspacing="0" bordercolor="#DDDDDD" class="t_list">
  <tr>
    <td class="icap itab">时间日期</td>
    <td class="icap itab">充值总额</td>
    <td class="icap itab">提现总额</td>
    <td class="icap itab">投注总额</td>
    <td class="icap itab">中奖总额</td>
    <td class="icap itab">返点总额</td>
    <td class="icap itab">分红总额</td>
    <td class="icap itab">活动派发</td>
    <td class="icap itab">盈亏</td>
  </tr>
  <tr class="t_list_tr_0">
    <td class="itab">今日统计</td>
    <td class="itab Font_R"><?=$at1?></td>
    <td class="itab Font_R"><?=$at2?></td>
    <td class="itab Font_G"><?=$at3?></td>
    <td class="itab Font_B"><?=$at4?></td>
    <td class="itab Font_R"><?=$at5?></td>
    <td class="itab Font_R"><?=$at6?></td>
    <td class="itab"><?=$at7?></td>
    <td class="itab"><?php if($at8<0){echo "<font color='#FF0000'>".number_format($at8,2)."</font>";}else{echo "<font color='#00FF00'>".number_format($at8,2)."</font>";}?></td>
    </tr>
  <tr class="t_list_tr_1">
    <td class="itab">昨日统计</td>
    <td class="itab Font_R"><?=$bt1?></td>
    <td class="itab Font_R"><?=$bt2?></td>
    <td class="itab Font_G"><?=$bt3?></td>
    <td class="itab Font_B"><?=$bt4?></td>
    <td class="itab Font_R"><?=$bt5?></td>
    <td class="itab Font_R"><?=$bt6?></td>
    <td class="itab"><?=$bt7?></td>
    <td class="itab"><?php if($bt8<0){echo "<font color='#FF0000'>".number_format($bt8,2)."</font>";}else{echo "<font color='#00FF00'>".number_format($bt8,2)."</font>";}?></td>
  </tr>
  <tr class="t_list_tr_0">
    <td class="itab">本月统计</td>
    <td class="itab Font_R"><?=$ct1?></td>
    <td class="itab Font_R"><?=$ct2?></td>
    <td class="itab Font_G"><?=$ct3?></td>
    <td class="itab Font_B"><?=$ct4?></td>
    <td class="itab Font_R"><?=$ct5?></td>
    <td class="itab Font_R"><?=$ct6?></td>
    <td class="itab"><?=$ct7?></td>
    <td class="itab"><?php if($ct8<0){echo "<font color='#FF0000'>".number_format($ct8,2)."</font>";}else{echo "<font color='#00FF00'>".number_format($ct8,2)."</font>";}?></td>
  </tr>
  <tr class="t_list_tr_1">
    <td class="itab">上月统计</td>
    <td class="itab Font_R"><?=$dt1?></td>
    <td class="itab Font_R"><?=$dt2?></td>
    <td class="itab Font_G"><?=$dt3?></td>
    <td class="itab Font_B"><?=$dt4?></td>
    <td class="itab Font_R"><?=$dt5?></td>
    <td class="itab Font_R"><?=$dt6?></td>
    <td class="itab"><?=$dt7?></td>
    <td class="itab"><?php if($dt8<0){echo "<font color='#FF0000'>".number_format($dt8,2)."</font>";}else{echo "<font color='#00FF00'>".number_format($dt8,2)."</font>";}?></td>
  </tr>
</table>
<br>
<table width="95%" border="1" cellpadding="0" cellspacing="0" bordercolor="#DDDDDD" class="t_list">
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#F6F6F6">
      <tr>
        <td width="40" height="33"><div align="center"><img src="images/iconc.jpg" width="25" height="23"></div></td>
        <td class="top_list_td Font_I">用户统计</td>
      </tr>
    </table></td>
  </tr>
  <tr class="t_list_tr_0">
    <td height="70"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="25"><div align="center">今日注册</div></td>
        <td><div align="center">本月注册</div></td>
        <td><div align="center">上月注册</div></td>
        <td><div align="center">会员人数</div></td>
        <td><div align="center">代理人数</div></td>
        <td><div align="center">当前在线</div></td>
        <td><div align="center">用户总数</div></td>
        <td><div align="center">余额总数</div></td>
        </tr>
      <tr>
        <td height="30"><div align="center">
          <table width="30" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td height="20" bgcolor="#FE6600"><div align="center" class="Font_W"><?=$rowf['numa']?></div></td>
            </tr>
          </table>
        </div></td>
        <td><div align="center">
          <table width="30" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td height="20" bgcolor="#FE6600"><div align="center" class="Font_W"><?=$rowf['numb']?></div></td>
            </tr>
          </table>
        </div></td>
        <td><div align="center">
          <table width="30" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td height="20" bgcolor="#FE6600"><div align="center" class="Font_W"><?=$rowf['numc']?></div></td>
            </tr>
          </table>
        </div></td>
        <td><div align="center">
          <table width="30" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td height="20" bgcolor="#FE6600"><div align="center" class="Font_W"><?=$rowf['numd']?></div></td>
            </tr>
          </table>
        </div></td>
        <td><div align="center">
          <table width="30" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td height="20" bgcolor="#FE6600"><div align="center" class="Font_W"><?=$rowf['nume']?></div></td>
            </tr>
          </table>
        </div></td>
        <td><div align="center">
          <table width="30" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td height="20" bgcolor="#FE6600"><div align="center" class="Font_W"><?=$rowg['numa']?></div></td>
            </tr>
          </table>
        </div></td>
        <td><div align="center">
          <table width="30" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td height="20" bgcolor="#FE6600"><div align="center" class="Font_W"><?=$rowf['numf']?></div></td>
            </tr>
          </table>
        </div></td>
        <td><div align="center">
          <table width="30" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td height="20" bgcolor="#FE6600"><div align="center" class="Font_W"><?=$rowf['numg']?></div></td>
            </tr>
          </table>
        </div></td>
        </tr>
    </table></td>
    </tr>
</table>
<br>

</body>
</html> 