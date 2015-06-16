<?php
session_start();
error_reporting(0);
require_once 'conn.php';

if (strpos($_SESSION['admin_flag'],'93') ){}else{ 
	echo "<script language=javascript>alert('对不起，您无此权限！');window.history.go(-1);</script>";
exit;}

if($_GET['act']=="edit"){
//	echo $_POST['content1'];
	$sql="update ssc_banks set cmin='".$_POST['cmin']."',cmax='".$_POST['cmax']."',crates='".$_POST['crates']."',climit='".$_POST['climit']."',types='".$_POST['types']."',cztimemin='".$_POST['cztimemin']."',cztimemax='".$_POST['cztimemax']."' where id=".$_GET['id'];
//	echo $sql;
	$exe=mysql_query($sql) or  die("数据库修改出错2");
	echo "<script>alert('修改成功！');window.location.href='banks_cz.php';</script>"; 
	exit;
}

$sql="select * from ssc_banks order by sort desc";
$rsnewslist = mysql_query($sql);
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
        <td class="top_list_td icons_a9">　　您现在的位置是：系统管理 &gt; 充值设置</td>
      </tr>
    </table>
  <br />
	<table width="95%" border="1" cellpadding="0" cellspacing="0" bordercolor="#DDDDDD" class="t_list">
			<tr>
				<td class="t_list_caption">序号</td>
			  <td class="t_list_caption">银行名称</td>
			  <td class="t_list_caption">最小充值</td>
				<td class="t_list_caption">最大充值</td>
			  <td class="t_list_caption">手续费率%</td>
			  <td  class="t_list_caption">补贴限额</td>
				<td class="t_list_caption">充值类型</td>
			    <td class="t_list_caption">状态</td>
		      <td width="80" class="t_list_caption">操作</td>
			</tr>
			<?php 
			$i=0;
			while ($row = mysql_fetch_array($rsnewslist)){?>
            <form action="?act=edit" method="post" name="form1" id="form1">
			<tr class="t_list_tr_<?=$i%2?>" onMouseOver="this.style.backgroundColor='#E8F1FF'" onMouseOut="this.style.backgroundColor=''">
				<td height="25"  align="center"><?=($i+1)?></td>
				<td align="center"><?=$row['name']?></td>
				<td align="center"><?=$row['cmin']?></td>
				<td align="center"><?=$row['cmax']?></td>
				<td align="center"><?=$row['crates']?></td>
				<td align="center"><?=$row['climit']?></td>
				<td align="center"><?php if($row['types']==1){echo "自动充值";}else{echo "手动充值";}?></td>
				<td align="center"><?php if($row['zt']==1){echo "<font color='#00FF00'>正常</font>";}else{echo "<font color='#FF0000'>暂停</font>";}?></td>
				<td align="center"><a href="banks_czedit.php?act=edit&amp;id=<?=$row['id']?>">修改</a></td>
			</tr>
			</form>
			<?php 
			$i=$i+1;
			}
			?>
	</table>
</div>
</body>
</html>
