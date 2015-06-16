<?php
session_start();
error_reporting(0);
require_once 'conn.php';

if (strpos($_SESSION['admin_flag'],'28') ){}else{ 
	echo "<script language=javascript>alert('对不起，您无此权限！');window.history.go(-1);</script>";
exit;}

$cid=$_GET['id'];
if($cid==""){
	$cid="1";
}

$urls="id=".$cid;

$page = !($_GET['page'])?'1':intval($_GET['page']);
$pagesize=20;
$page2=($page-1)*$pagesize;

if ($cid==1){ 
	$sql = "SELECT DATE_FORMAT( logdate, '%Y-%m-%d' ) AS numa, count( * ) AS numb, sum(nums0) AS numc FROM ssc_total GROUP BY DATE_FORMAT( logdate, '%Y-%m-%d' )";
}
if ($cid==2){ 
	$sql = "SELECT DATE_FORMAT( logdate, '%Y-%m' ) AS numa, count( * ) AS numb, sum(nums0) AS numc FROM ssc_total GROUP BY DATE_FORMAT( logdate, '%Y-%m' )";
}
if ($cid==3){ 
	$sql = "SELECT DATE_FORMAT( logdate, '%Y' ) AS numa, count( * ) AS numb, sum(nums0) AS numc FROM ssc_total GROUP BY DATE_FORMAT( logdate, '%Y' )";
}
$rs = mysql_query($sql);
$total = mysql_num_rows($rs);

if ($cid==1){ 
	$sql = "SELECT DATE_FORMAT( logdate, '%Y-%m-%d' ) AS numa, count( * ) AS numb, sum(nums0) AS numc, sum(nums1) AS numd, sum(nums2) AS nume FROM ssc_total GROUP BY DATE_FORMAT( logdate, '%Y-%m-%d' ) order by numa desc limit $page2,$pagesize";
}
if ($cid==2){ 
	$sql = "SELECT DATE_FORMAT( logdate, '%Y-%m' ) AS numa, count( * ) AS numb, sum(nums0) AS numc, sum(nums1) AS numd, sum(nums2) AS nume FROM ssc_total GROUP BY DATE_FORMAT( logdate, '%Y-%m' ) order by numa desc limit $page2,$pagesize";
}
if ($cid==3){ 
	$sql = "SELECT DATE_FORMAT( logdate, '%Y' ) AS numa, count( * ) AS numb , sum(nums0) AS numc, sum(nums1) AS numd, sum(nums2) AS nume FROM ssc_total GROUP BY DATE_FORMAT( logdate, '%Y' ) order by numa desc limit $page2,$pagesize";
}
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
        <td class="top_list_td icons_a2">　　您现在的位置是：会员管理 &gt; 访问统计 &gt; <?php if($cid==1){echo "按日统计";}else if($cid==2){echo "按月统计";}else if($cid==3){echo "按年统计";}?></td>
      </tr>
    </table>
  	<br />
  	<table width="95%" border="0" cellspacing="0" cellpadding="0" class="nav_list">
    	<tr>
      		<td class="nav_list_td"><a href="?id=1">按日统计</a>　<a href="?id=2">按月统计</a>　<a href="?id=3">按年统计</a></td>
    	</tr>
  	</table>
  <br />
<table width="95%" border="1" cellpadding="0" cellspacing="0" bordercolor="#DDDDDD" class="t_list">
		  	<tr>
				<td class="t_list_caption"><?php if($cid==2){echo "统计月份";}else if($cid==3){echo "统计年份";}else{echo "统计日期";}?></td>
			  <td class="t_list_caption">用户</td>
		        <td class="t_list_caption">代理</td>
		        <td class="t_list_caption">总代理</td>
		        <td class="t_list_caption">合计</td>
	  	  </tr>
			<?php 
			$i=0;
			while ($row = mysql_fetch_array($rsnewslist)){
			?>
			<tr class="t_list_tr_<?=$i%2?>" onMouseOver="this.style.backgroundColor='#E8F1FF'" onMouseOut="this.style.backgroundColor=''">
			  <td height="25" align="center"><?=$row['numa']?></td>
				<td align="center"><?=$row['numc']?></td>
		        <td align="center"><?=$row['numd']?></td>
		        <td align="center"><?=$row['nume']?></td>
		        <td align="center"><?=$row['numc']+$row['numd']+$row['nume']?></td>
			</tr>
			<?php 
			$i=$i+1;
			}
			?>
      <tr>
            <td colspan="5" class="t_list_bottom"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="170" height="35">&nbsp;</td>
                <td width="150">&nbsp;</td>
                <td><div style='text-align:right;'>总计  <?=$total?> 条数据,  共 <?=$lastpg?> 页 , 当前第 <?=$page?> 页  |  <?php if($page>1){?> <A HREF="?<?=$urls?>&page=1">首页</A> <A HREF="?<?=$urls?>&page=<?=$page-1?>">上页</A><?php }?><?php for($i=$p1;$i<=$p2;$i++){
		if($i==$page){?> <span class='Font_R'><?=$i?></span> <?php }else{?> <A HREF="?<?=$urls?>&page=<?=$i?>"><?=$i?></A> <?php }}?><?php if($page!=$lastpg){?> <A HREF="?<?=$urls?>&page=<?=$page+1?>">下页</A> <A HREF="?<?=$urls?>&page=<?=$lastpg?>">尾页</A> <?php }?> | 转至 <SCRIPT LANGUAGE="JAVASCRIPT">function keepKeyNum(obj,evt){var  k=window.event?evt.keyCode:evt.which; if( k==13 ){ goPage(obj.value);return false; }} function goPage( iPage ){ if( !isNaN(parseInt(iPage)) ) { if(iPage< 0 ){iPage=0;} window.location.href="?<?=$urls?>&page="+iPage;}}</SCRIPT><INPUT onKeyPress="return keepKeyNum(this,event);" TYPE="TEXT" ID="iGotoPage" NAME="iGotoPage" size="3"> 页  &nbsp;<BUTTON onClick="javascript:goPage( document.getElementById('iGotoPage').value );return false;">GO</BUTTON></div></td>
              </tr>
            </table></td>
      </tr>
  </table>
</div>
</body>
</html>
