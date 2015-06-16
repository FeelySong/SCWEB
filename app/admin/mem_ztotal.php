<?php
session_start();
error_reporting(0);
require_once 'conn.php';

if (strpos($_SESSION['admin_flag'],'27') ){}else{ 
	echo "<script language=javascript>alert('对不起，您无此权限！');window.history.go(-1);</script>";
exit;}

	$sql = "SELECT count(IF(level = 0, level, null)) as numa, count(IF(level = 1, level, null)) as numb, count(IF(level = 2, level, null)) as numc, count(IF(level = 0 and DATE_FORMAT(regdate,'%Y-%m')='".date("Y-m")."', level, null)) as numa1, count(IF(level = 1 and DATE_FORMAT(regdate,'%Y-%m')='".date("Y-m")."', level, null)) as numb1, count(IF(level = 2 and DATE_FORMAT(regdate,'%Y-%m')='".date("Y-m")."', level, null)) as numc1, count(IF(level = 0 and DATE_FORMAT(regdate,'%Y-%m')='".date('Y-m',strtotime("-1 month"))."', level, null)) as numa2, count(IF(level = 1 and DATE_FORMAT(regdate,'%Y-%m')='".date('Y-m',strtotime("-1 month"))."', level, null)) as numb2, count(IF(level = 2 and DATE_FORMAT(regdate,'%Y-%m')='".date('Y-m',strtotime("-1 month"))."', level, null)) as numc2 FROM ssc_member";

$rs = mysql_query($sql);
$row = mysql_fetch_array($rs);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link href="css/index.css" rel="stylesheet" type="text/css">
</head>

<body>
<div align="center"><br />
	<table width="95%" border="0" cellpadding="0" cellspacing="0" class="top_list">
      <tr>
        <td class="top_list_td icons_a2">　　您现在的位置是：会员管理 &gt; 用户总计</td>
      </tr>
    </table>
  <br />
<table width="95%" border="1" cellpadding="0" cellspacing="0" bordercolor="#DDDDDD" class="t_list">
		  	<tr>
				<td class="t_list_caption">日期</td>
				<td class="t_list_caption">用户</td>
		        <td class="t_list_caption">代理</td>
		        <td class="t_list_caption">总代理</td>
		        <td class="t_list_caption">合计</td>
	  	  </tr>
			<tr class="t_list_tr_0" onMouseOver="this.style.backgroundColor='#E8F1FF'" onMouseOut="this.style.backgroundColor=''">
			  <td height="25" align="center">本月</td>
				<td align="center"><?=$row['numa1']?></td>
		        <td align="center"><?=$row['numb1']?></td>
		        <td align="center"><?=$row['numc1']?></td>
		        <td align="center"><?=$row['numa1']+$row['numb1']+$row['numc1']?></td>
			</tr>
			<tr class="t_list_tr_0" onMouseOver="this.style.backgroundColor='#E8F1FF'" onMouseOut="this.style.backgroundColor=''">
			  <td height="25" align="center">上月</td>
			  <td align="center"><?=$row['numa2']?></td>
			  <td align="center"><?=$row['numb2']?></td>
			  <td align="center"><?=$row['numc2']?></td>
			  <td align="center"><?=$row['numa2']+$row['numb2']+$row['numc2']?></td>
    </tr>
			<tr class="t_list_tr_1" onMouseOver="this.style.backgroundColor='#E8F1FF'" onMouseOut="this.style.backgroundColor=''">
			  <td height="25" align="center">总计</td>
			  <td align="center"><?=$row['numa']?></td>
			  <td align="center"><?=$row['numb']?></td>
			  <td align="center"><?=$row['numc']?></td>
			  <td align="center"><?=$row['numa']+$row['numb']+$row['numc']?></td>
    </tr>
  </table>
</div>
</body>
</html>
