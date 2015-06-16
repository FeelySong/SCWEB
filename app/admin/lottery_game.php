<?php
session_start();
error_reporting(0);
require_once 'conn.php';

if (strpos($_SESSION['admin_flag'],'74') ){}else{ 
	echo "<script language=javascript>alert('对不起，您无此权限！');window.history.go(-1);</script>";
exit;}

$act=$_GET['act'];
if($act=="edit"){
	$sql="update ssc_set set zt = '".$_POST['zt']."' where id ='".$_POST['sid']."'";
//	echo $sql;
	if (!mysql_query($sql)){
	  	die('Error: ' . mysql_error());
	}
	echo "<script language=javascript>alert('修改成功！');window.location='?';</script>";
	exit;
}

$sql="select * from ssc_set order by id asc";
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
        <td class="top_list_td icons_a7">　　您现在的位置是：游戏管理 &gt; 彩种设置</td>
      </tr>
    </table>
  <br />
	<table width="95%" border="1" cellpadding="0" cellspacing="0" bordercolor="#DDDDDD" class="t_list">
			<tr>
				<td class="t_list_caption">序号</td>
				<td class="t_list_caption">名称</td>
				<td class="t_list_caption">别名</td>
				<td class="t_list_caption">开启/关闭</td>
				<td class="t_list_caption">操作</td>
	  </tr>
			<?php 
			$i=0;
			while ($row = mysql_fetch_array($rsnewslist)){?>
            <form action="?act=edit" method="post" name="form1" id="form1">
			<tr class="t_list_tr_<?=$i%2?>" onMouseOver="this.style.backgroundColor='#E8F1FF'" onMouseOut="this.style.backgroundColor=''">
				<td height="25"  align="center"><input type="hidden" name="sid" value="<?=$row['id']?>"/><?=$row['id']?></td>
				<td align="center"><?=$row['name']?></td>
				<td align="center"><?=$row['cname']?></td>
				<td align="center">
			    <input name="zt" type="radio" id="radio" value="1" <?php if($row['zt']==1){echo "checked='checked'";}?>/>
			    开启
			    &nbsp;&nbsp;
			    <input type="radio" name="zt" id="radio2" value="0" <?php if($row['zt']==0){echo "checked='checked'";}?>/>
			    关闭			    </td>
				<td align="center"><input type="submit" class="but1" value="修改"  onClick="return confirm('确认要修改吗?');"/></td>
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
