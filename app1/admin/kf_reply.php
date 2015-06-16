<?php
session_start();
error_reporting(0);
require_once 'conn.php';

$act=$_GET['act'];
$id=$_GET['id'];

if($act=="add"){
	$sql="insert into ssc_kf set cont='".$_POST['content']."',adddate='".date("Y-m-d H:i:s")."',tid='".$id."',kf='1',username='客服'";
	$exe=mysql_query($sql) or  die("数据库修改出错1");
	$sql="update ssc_kf set answer='客服',answerdate='".date("Y-m-d H:i:s")."',zt='1' where id='".$id."'";
	$exe=mysql_query($sql) or  die("数据库修改出错1");
	echo "<script>window.location.href='kf_reply.php?id=".$id."';</script>"; 
	exit;
}
if($act=="edit"){
	$sql="update ssc_kf set topic='".$_POST['adclass']."',cont='".$_POST['content']."' where id=".$_GET['id'];
	echo $sql;
	$exe=mysql_query($sql) or  die("数据库修改出错2");
	echo "<script>window.location.href='affiche.php';</script>"; 
	exit;
}
if($act=="del"){
	mysql_query("Delete from ssc_kf where id='".$_GET['did']."' or tid='".$_GET['did']."'");
	echo "<script>window.location.href='kf_reply.php?id=".$id."';</script>"; 
	exit;
}

$zt=$_GET['zt'];
if($zt=="0"){
	$sql=" and zt='0'";
}
$sql = "select * from ssc_kf WHERE id='".$id."' or tid='".$id."' order by id asc";
$rsnewslist = mysql_query($sql);
$total = mysql_num_rows($rsnewslist);

?>
<html>
<head>
<link href="css/index.css" rel="stylesheet" type="text/css">
<base target="mainframe" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>

<body>
<br />
	<table width="95%" border="0" cellpadding="0" cellspacing="0" class="top_list">
      <tr>
        <td class="top_list_td icons_a1">　　您现在的位置是：信息管理 &gt; 客户回复</td>
        <td width="140" class="top_list_td">&nbsp;</td>
      </tr>
    </table>
  <br />
	<table width="95%" border="1" cellpadding="0" cellspacing="0" bordercolor="#DDDDDD" class="t_list">
        <?php
		while ($row = mysql_fetch_array($rsnewslist))
		{
		?>
        <tr class="t_list_tr_<?php if($row['kf']==1){echo "2";}else{echo "0";}?>">
          <td width="80">序号</td>
          <td width="150"><?=$row['id']?></td>
          <td width="150">用户名</td>
          <td width="150"><?=$row['username']?></td>
          <td width="150">提问时间</td>
          <td><?=$row['adddate']?></td>
          <td width="150"><a href="kf_reply.php?act=del&id=<?=$id?>&did=<?=$row['id']?>" onClick="return confirm('确认要删除吗?');">删除</a></td>
      </tr>
            <tr class="t_list_tr_<?php if($row['kf']==1){echo "2";}else{echo "0";}?>">
            <td height="30" colspan="7" align="left">　　<?=$row['cont']?></td> 
      </tr>
 		<?php
		}
		?>
      </tr>
      <form method=post action="kf_reply.php?act=add&id=<?=$id?>">
      <tr class="t_list_tr_0">
        <td height="150" colspan="7" align="left"><label>
          　
        <textarea name="content" cols="80" rows="8" id="content"></textarea>
        <input type="submit" name="Submit" value="確 定"  onClick="return confirm('确认要发布吗?');" class="btn2" onMouseOver="this.className='btn2a'" onMouseOut="this.className='btn2'" />
        　
        <input type="button" name="cancel" value="取 消" class="btn2" onClick="javascript:history.go(-1)" onMouseOver="this.className='btn2a'" onMouseOut="this.className='btn2'" />
        </label></td> 
      </tr>
      </form>
</table>
<br>


</body>
</html> 