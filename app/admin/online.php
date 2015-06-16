<?php
session_start();
error_reporting(0);
require_once 'conn.php';

if (strpos($_SESSION['admin_flag'],'29') ){}else{ 
	echo "<script language=javascript>alert('对不起，您无此权限！');window.history.go(-1);</script>";
exit;}

$jb=array("用户","代理","总代理","管理员"); 

$ddf=date( "Y-m-d H:i:s",time()-33);
mysql_query( "delete from ssc_online where updatedate<'".$ddf."'");

if($_GET['act']=="del"){
	mysql_query("Delete from ssc_online where id=".$_GET['id']);
	echo "<script>window.location.href='online.php';</script>"; 
	exit;
}
$page = !($_GET['page'])?'1':intval($_GET['page']);
$pagesize=15;
$page2=($page-1)*$pagesize;

$sql="select * from ssc_online where level!='3' order by id desc";
$rs = mysql_query($sql);
$total = mysql_num_rows($rs);

$sql="select * from ssc_online where level!='3' order by id desc  limit $page2,$pagesize";
$rsnewslist=mysql_query($sql);

$lastpg=ceil($total/$pagesize); //最后页，也是总页数
$page=min($lastpg,$page);
$prepg=$page-1; //上一页
$nextpg=($page==$lastpg ? 0 : $page+1); //下一页

if($page<5){
	$p1=1;
	$p2=min($lastpg,10);
}else{
	$p2=min($lastpg,$page+5);
	$p1=max($p2-9,1);
}
?>
<html>
<head>
<link href="css/index.css" rel="stylesheet" type="text/css">
<base target="mainframe" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>

<body>
<br>
	<table width="95%" border="0" cellpadding="0" cellspacing="0" class="top_list">
      <tr>
        <td class="top_list_td icons_a2">　　您现在的位置是：会员管理 &gt; 在线人员</td>
      </tr>
    </table>
<br>
	<table width="95%" border="1" cellpadding="0" cellspacing="0" bordercolor="#DDDDDD" class="t_list">
        <tr>
            <td class="t_list_caption">类型</td>
          <td class="t_list_caption">用户名</td>
            <td class="t_list_caption">IP地址</td>
            <td class="t_list_caption">IP地区</td>
            <td class="t_list_caption">浏览器</td>
            <td class="t_list_caption">操作系统</td>
            <td class="t_list_caption">移动设备</td>
            <td class="t_list_caption">上线时间</td>
            <td class="t_list_caption">操作</td>
        </tr>
        <?php
		while ($row = mysql_fetch_array($rsnewslist))
		{
		?>
            <tr class="t_list_tr_0" onMouseOver="this.style.backgroundColor='#FFFFA2'" onMouseOut="this.style.backgroundColor=''">
                <td><?=$jb[$row['level']]?></td> 
                <td><?=$row['username']?></td>
                <td><?=$row['ip']?></td>
                <td><?=$row['addr']?></td>
                <td><?=determinebrowser($row['explorer'])?></td>
                <td><?=determineplatform($row['explorer'])?></td>
                <td><?="否"?></td>
                <td><?=$row['adddate']?></td>
                <td><a href="online.php?act=del&id=<?=$row['id']?>" onClick="return confirm('确认要踢人吗?');">踢人</a></td>
  </tr>
 		<?php
		}
		?>

      <tr>
            <td colspan="9" class="t_list_bottom"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="170" height="35">&nbsp;</td>
                <td width="150">&nbsp;</td>
                <td><div style='text-align:right;'>总计  <?=$total?> 条数据,  共 <?=$lastpg?> 页 , 当前第 <?=$page?> 页  |  <?php if($page>1){?> <A HREF="?<?=$urls?>&page=1">首页</A> <A HREF="?<?=$urls?>&page=<?=$page-1?>">上页</A><?php }?><?php for($i=$p1;$i<=$p2;$i++){
		if($i==$page){?> <span class='Font_R'><?=$i?></span> <?php }else{?> <A HREF="?<?=$urls?>&page=<?=$i?>"><?=$i?></A> <?php }}?><?php if($page!=$lastpg){?> <A HREF="?<?=$urls?>&page=<?=$page+1?>">下页</A> <A HREF="?<?=$urls?>&page=<?=$lastpg?>">尾页</A> <?php }?> | 转至 <SCRIPT LANGUAGE="JAVASCRIPT">function keepKeyNum(obj,evt){var  k=window.event?evt.keyCode:evt.which; if( k==13 ){ goPage(obj.value);return false; }} function goPage( iPage ){ if( !isNaN(parseInt(iPage)) ) { if(iPage< 0 ){iPage=0;} window.location.href="?<?=$urls?>&page="+iPage;}}</SCRIPT><INPUT onKeyPress="return keepKeyNum(this,event);" TYPE="TEXT" ID="iGotoPage" NAME="iGotoPage" size="3"> 页  &nbsp;<BUTTON onClick="javascript:goPage( document.getElementById('iGotoPage').value );return false;">GO</BUTTON></div></td>
              </tr>
            </table></td>
      </tr>
</table>
<br>


</body>
</html> 