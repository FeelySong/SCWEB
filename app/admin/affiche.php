<?php
session_start();
error_reporting(0);
require_once 'conn.php';

if (strpos($_SESSION['admin_flag'],'12') ){}else{ 
	echo "<script language=javascript>alert('对不起，您无此权限！');window.history.go(-1);</script>";
exit;}

if($_GET['act']=="dels"){       //批量删除   
	$ids=$_POST['lids'];  
	$ids=implode(",", $ids);   //implode函数 把数组元素组合为一个字符串。   
	$sql="delete from ssc_news where id in ($ids)";  
	mysql_query($sql);  
	echo "<script>alert('删除公告成功！');window.location.href='affiche.php';</script>"; 
	exit;

}

if($_GET['act']=="add"){
	$sql="insert into ssc_news set topic='".$_POST['topic']."',cont='".$_POST['content1']."',adddate='".$_POST['adddate']."',lev='".$_POST['lev']."'";
	$exe=mysql_query($sql) or  die("数据库修改出错1");
	echo "<script>alert('新增公告成功！');window.location.href='affiche.php';</script>"; 
	exit;
}
if($_GET['act']=="edit"){
//	echo $_POST['content1'];
	$sql="update ssc_news set topic='".$_POST['topic']."',cont='".$_POST['content1']."',adddate='".$_POST['adddate']."',lev='".$_POST['lev']."' where id=".$_GET['id'];
//	echo $sql;
	$exe=mysql_query($sql) or  die("数据库修改出错2");
	echo "<script>alert('编辑公告成功！');window.location.href='affiche.php';</script>"; 
	exit;
}
if($_GET['act']=="tj"){
	$sql="update ssc_news set lev='".$_GET['zt']."' where id=".$_GET['id'];
	$exe=mysql_query($sql) or  die("数据库修改出错2");
	echo "<script>window.location.href='affiche.php';</script>"; 
	exit;
}

if($_GET['act']=="del"){
	mysql_query("Delete from ssc_news where id=".$_GET['id']);
	echo "<script>alert('删除公告成功！');window.location.href='affiche.php';</script>"; 
	exit;
}

$page = !($_GET['page'])?'1':intval($_GET['page']);
$pagesize=20;
$page2=($page-1)*$pagesize;

$sql="select * from ssc_news order by id desc";
$rs = mysql_query($sql);
$total = mysql_num_rows($rs);

$sql="select * from ssc_news order by id desc limit $page2,$pagesize";
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
        <td class="top_list_td icons_a1">　　您现在的位置是：信息管理 &gt; 公告管理</td>
        <td width="100" class="top_list_td"><input name="Add_User" type="button" value="添加公告" class="Font_B" onClick="javascript:window.location='affiche_edit.php?act=add';"></td>
      </tr>
    </table>
  <br />
  	<form method=post action="?act=dels">
	<table width="95%" border="1" cellpadding="0" cellspacing="0" bordercolor="#DDDDDD" class="t_list">
        <tr>
            <td class="t_list_caption">选择</td>
            <td class="t_list_caption">序号</td>
            <td class="t_list_caption">公告标题</td>
            <td class="t_list_caption">发布时间</td>
            <td class="t_list_caption">醒目显示</td>
            <td class="t_list_caption">操作</td>
        </tr>
        <?php
		while ($row = mysql_fetch_array($rsnewslist))
		{
		?>
            <tr class="t_list_tr_0" onMouseOver="this.style.backgroundColor='#FFFFA2'" onMouseOut="this.style.backgroundColor=''">
                <td height="25"><input name="lids[]" type="checkbox" id="checkbox2" value="<?=$row['id']?>"></td> 
                <td><?=$row['id']?></td>
              <td><?=$row['topic']?></td>
                <td><?=$row['adddate']?></td>
                <td><?php if($row['lev']==1){?>
                  <a href="?act=tj&zt=0&id=<?=$row['id']?>"><img src="images/001.gif" width="16" height="14"></a>
                <?php }else{?>
                <a href="?act=tj&zt=1&id=<?=$row['id']?>"><img src="images/002.gif" width="16" height="16"></a>                <?php }?></td>
              <td><a href="affiche_edit.php?act=edit&id=<?=$row['id']?>">修改</a> <a  onClick="return confirm('确认要删除吗?');" href="affiche.php?act=del&id=<?=$row['id']?>">删除</a></td>
  </tr>
 		<?php
		}
		?>

      <tr>
            <td colspan="6" class="t_list_bottom"><table width="100%" border="0" cellspacing="0" cellpadding="0">
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