<?php
session_start();
error_reporting(0);
require_once 'conn.php';


if (strpos($_SESSION['admin_flag'],'13') ){}else{ 
	echo "<script language=javascript>alert('对不起，您无此权限！');window.history.go(-1);</script>";
exit;}

if($_GET['act']=="dels"){       //批量删除   
	$ids=$_POST['lids'];  
	$ids=implode(",", $ids);   //implode函数 把数组元素组合为一个字符串。   
	$sql="delete from ssc_kf where id in ($ids) or tid in ($ids)";  
	mysql_query($sql); 
	echo "<script>alert('删除消息成功！');window.location.href='kf.php';</script>"; 
	exit;
}

if($_GET['act']=="del"){
	mysql_query("Delete from ssc_kf where id='".$_GET['id']."' or tid='".$_GET['id']."'");
	echo "<script>alert('删除消息成功！');window.location.href='kf.php';</script>"; 
	exit;
}

$page = !($_GET['page'])?'1':intval($_GET['page']);
$pagesize=20;
$page2=($page-1)*$pagesize;

$zt=$_GET['zt'];
if($zt==""){
	$zt=0;
}
$s1=" and zt='".$zt."'";

$s1=$s1." order by id desc";
$sql="select * from ssc_kf where sign='1'".$s1;
$rs = mysql_query($sql);
$total = mysql_num_rows($rs);

$sql="select * from ssc_kf where sign='1'".$s1." limit $page2,$pagesize";
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
<script type="text/javascript">  
var checkall=document.getElementsByName("lids[]");  
function select(){                          //全选   
	for(var $i=0;$i<checkall.length;$i++){  
		checkall[$i].checked=true;  
	} 
}  
function fanselect(){                        //反选   
	for(var $i=0;$i<checkall.length;$i++){  
		if(checkall[$i].checked){  
			checkall[$i].checked=false;  
		}else{  
			checkall[$i].checked=true;  
		}  
	}  
}           
function noselect(){                          //全不选   
	for(var $i=0;$i<checkall.length;$i++){  
		checkall[$i].checked=false;  
	}  
}  
</script>  
<body>
<br />
	<table width="95%" border="0" cellpadding="0" cellspacing="0" class="top_list">
      <tr>
        <td class="top_list_td icons_a1">　　您现在的位置是：信息管理 &gt; 会员消息</td>
        <td width="160" class="top_list_td"><a href="?zt=0">未处理消息</a> <a href="?zt=1">已处理消息</a></td>
      </tr>
    </table>
  <br />
  	<form method=post action="?act=dels">
	<table width="95%" border="1" cellpadding="0" cellspacing="0" bordercolor="#DDDDDD" class="t_list">
        <tr>
            <td class="t_list_caption">选择</td>
            <td class="t_list_caption">序号</td>
            <td class="t_list_caption">用户名</td>
            <td class="t_list_caption">内容</td>
          <td class="t_list_caption">提问时间</td>
            <td class="t_list_caption">状态</td>
          <td class="t_list_caption">操作</td>
      </tr>
        <?php
		while ($row = mysql_fetch_array($rsnewslist))
		{
		?>
            <tr class="t_list_tr_0" onMouseOver="this.style.backgroundColor='#FFFFA2'" onMouseOut="this.style.backgroundColor=''">
                <td height="25"><input name="lids[]" type="checkbox" id="checkbox2" value="<?=$row['id']?>"></td> 
                <td height="25"><?=$row['id']?></td>
              <td><?=$row['username']?></td>
                <td align="left"><?=$row['cont']?></td>
              <td><?=$row['adddate']?></td>
                <td><?php if($row['zt']=="0"){?><font color="#FF0000">未解决</font><?php }else{?><font color="#006600">已解决</font><?php }?></td>
              <td><a href="javascript:void(0);" onClick="window.open('kfs.php?id=<?=$row['id']?>','kfs','width=600,height=600,directories=no,status=no,scrollbars=yes,resizable=yes,menubar=no,toolbar=no')">查看</a> <a href="kf.php?act=del&id=<?=$row['id']?>" onClick="return confirm('确认要删除吗?');">删除</a></td>
  </tr>
 		<?php
		}
		?>
      <tr>
            <td colspan="7" class="t_list_bottom"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="170" height="35">　选择：<a href="javascript:select()">全选</a> - <a href="javascript:fanselect()">反选</a> - <a href="javascript:noselect()">不选</a></td>
                <td width="150"><input name="Submit" type="submit" class="btndel" onClick="return confirm('确认要删除吗?');" value=" " /></td>
                <td><div style='text-align:right;'>总计  <?=$total?> 条数据,  共 <?=$lastpg?> 页 , 当前第 <?=$page?> 页  |  <?php if($page>1){?> <A HREF="?<?=$urls?>&page=1">首页</A> <A HREF="?<?=$urls?>&page=<?=$page-1?>">上页</A><?php }?><?php for($i=$p1;$i<=$p2;$i++){
		if($i==$page){?> <span class='Font_R'><?=$i?></span> <?php }else{?> <A HREF="?<?=$urls?>&page=<?=$i?>"><?=$i?></A> <?php }}?><?php if($page!=$lastpg){?> <A HREF="?<?=$urls?>&page=<?=$page+1?>">下页</A> <A HREF="?<?=$urls?>&page=<?=$lastpg?>">尾页</A> <?php }?> | 转至 <SCRIPT LANGUAGE="JAVASCRIPT">function keepKeyNum(obj,evt){var  k=window.event?evt.keyCode:evt.which; if( k==13 ){ goPage(obj.value);return false; }} function goPage( iPage ){ if( !isNaN(parseInt(iPage)) ) { if(iPage< 0 ){iPage=0;} window.location.href="?<?=$urls?>&page="+iPage;}}</SCRIPT><INPUT onKeyPress="return keepKeyNum(this,event);" TYPE="TEXT" ID="iGotoPage" NAME="iGotoPage" size="3"> 页  &nbsp;<BUTTON onClick="javascript:goPage( document.getElementById('iGotoPage').value );return false;">GO</BUTTON></div></td>
              </tr>
            </table></td>
      </tr>
</table>
</form>
<br>


</body>
</html> 