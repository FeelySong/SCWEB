<?php
session_start();
error_reporting(0);
require_once 'conn.php';
$tday=date("Y-m-d");
$tday2=date("Ymd");
if($cid==""){
	$cid="1";
}
//$sql="select * from ssc_data where cid='1' and DATE_FORMAT(opentime, '%Y-%m-%d')='".$tday."' order by id asc";
$sql="select * from ssc_bills where 1=1 order by id desc";
$rsnewslist = mysql_query($sql) or  die("数据库修改出错!!!!".mysql_error());;
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
  <table width="500" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td>重庆时时彩 黑龙江时时彩 </td>
    </tr>
  </table>
  <br />
  <table border="0" cellspacing="1" cellpadding="0" class="t_list">
		<form action="lottery_set.php?action=kaguan" method="post" name="form1" id="form1">
		  	<tr>
				<td width="100" class="t_list_caption">单号</td>
				<td width="60" class="t_list_caption">用户名</td>
				<td width="100" class="t_list_caption">彩种</td>
				<td width="80" class="t_list_caption">玩法</td>
				<td width="100" class="t_list_caption">期号</td>
				<td width="40" class="t_list_caption">追号</td>
				<td width="40" class="t_list_caption">自停</td>
				<td width="40" class="t_list_caption">模式</td>
				<td width="40" class="t_list_caption">返点</td>
				<td width="150" class="t_list_caption">投注号码</td>
				<td width="70" class="t_list_caption">中奖金额</td>
				<td width="80" class="t_list_caption">操作</td>
			</tr>
			<?php 
			$i=0;
			while ($row = mysql_fetch_array($rsnewslist)){
			?>
		  <tr class="t_list_tr_<?=$i%2?>" onMouseOver="this.style.backgroundColor='#FFFFA2'" onMouseOut="this.style.backgroundColor=''">
				<td height="25"  align="center"><?=$row['dan']?></td>
				<td align="center"><?=$row['username']?></td>
				<td align="center"><?=$row['lottery']?></td>
				<td align="center"><?=$row['mid']?></td>
				<td align="center"><?=$row['issue']?></td>
				<td align="center"><?=$row['zt']?></td>
				<td align="center">&nbsp;</td>
				<td align="center">&nbsp;</td>
				<td align="center">&nbsp;</td>
				<td align="center"><input type="text" name="VIP_Name3" maxlength="15" size="15" value="<?=$desc?>" onkeypress="alphaOnly(event);" onblur="this.className='inp1';" class="inp1" onfocus="this.className='inp1a'" /></td>
				<td align="center"><?=$row['prize']?></td>
				<td align="center"><button onClick="javascript:location.href='lottery_set.php?action=kazi&amp;ids=709'" class="button_a" style="width:80;height:22" ;>修改</button></td>
		  </tr>
			<?php 
			$i=$i+1;
			}
			?>
		</form>
  </table>
</div>
</body>
</html>
