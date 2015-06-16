<?php
session_start();
error_reporting(0);
require_once 'conn.php';

if (strpos($_SESSION['admin_flag'],'b1') ){}else{ 
	echo "<script language=javascript>alert('对不起，您无此权限！');window.history.go(-1);</script>";
exit;}

$jb=array("用户","代理"); 

if($_GET['act']=="dels"){
	$ids=$_POST['lids']; 
	for($i=0;$i<count($ids);$i=$i+1){
		$idss=$idss.Get_aname($ids[$i]).",";
	}
	$ids=implode(",", $ids);   //implode函数 把数组元素组合为一个字符串。 
	$sql="delete from ssc_planlist where id in ($ids)";  
	mysql_query($sql); 
	amend("删除计划任务 ".$idss);	
	
	echo "<script language=javascript>window.location='?';</script>";
	exit;
}


if($_GET['act']=="del"){
	mysql_query("Delete from ssc_planlist where id=".$_GET['id']);
	echo "<script>window.location.href='plan_list.php';</script>"; 
	exit;
}

if($_GET['act']=="add"){
	mysql_query("insert into ssc_planlist set topic='".$_POST['topic']."',ztopic='".$_POST['ztopic']."'");
	echo "<script>window.location.href='plan_list.php';</script>"; 
	exit;
}

$sql="select * from ssc_planlist order by id desc";
$rsnewslist = mysql_query($sql);

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
<br>
	<table width="95%" border="0" cellpadding="0" cellspacing="0" class="top_list">
      <tr>
        <td class="top_list_td icons_a11">　　您现在的位置是：计划任务 &gt; 任务列表</td>
      </tr>
    </table>
    <br>
<table width="95%" border="1" cellpadding="0" cellspacing="0" bordercolor="#DDDDDD" class="t_list">
  <tr>
    <td class="t_list_caption">选择</td>
    <td class="t_list_caption">序号</td>
    <td class="t_list_caption">任务名称</td>
    <td class="t_list_caption">子进程</td>
    <td class="t_list_caption">操作</td>
  </tr>
  <form method=post action="?act=dels">
  <?php
	while ($row = mysql_fetch_array($rsnewslist)){
  ?>
  <tr class="t_list_tr_0" onMouseOver="this.style.backgroundColor='#FFFFA2'" onMouseOut="this.style.backgroundColor=''">
    <td><input name="lids[]" type="checkbox" id="checkbox2" value="<?=$row['id']?>"></td>
    <td><?=$row['id']?></td>
    <td><?=$row['topic']?></td>
    <td><?=$row['ztopic']?></td>
    <td><a href="?act=del&id=<?=$row['id']?>" onClick="return confirm('确认要删除吗?');">删除</a></td>
  </tr>
  <?php }?>
  </form>
  <form method="post" action="?act=add">
  <tr class="t_list_tr_2">
    <td colspan="2">新增任务</td>
    <td><input name="topic" type="text" id="topic" value="<?=$row['topic']?>" size="20"></td>
    <td><input name="ztopic" type="text" id="ztopic" value="<?=$row['ztopic']?>" size="20"></td>
    <td>
      <input name="button" type="submit" class="but1" id="button" value="新增"  onClick="return confirm('确认要新增吗?');"/>    </td>
  </tr>
  </form>
      <tr>
            <td colspan="11" class="t_list_bottom"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="170" height="35">　选择：<a href="javascript:select()">全选</a> - <a href="javascript:fanselect()">反选</a> - <a href="javascript:noselect()">不选</a></td>
                <td width="150"><input name="Submit" type="submit" class="btndel" onClick="return confirm('确认要删除吗?');" value=" " /></td>
                <td><div style='text-align:right;'>总计  <?=$total?> 条数据,  共 <?=$lastpg?> 页 , 当前第 <?=$page?> 页  |  <?php if($page>1){?> <A HREF="?<?=$urls?>&page=1">首页</A> <A HREF="?<?=$urls?>&page=<?=$page-1?>">上页</A><?php }?><?php for($i=$p1;$i<=$p2;$i++){
		if($i==$page){?> <span class='Font_R'><?=$i?></span> <?php }else{?> <A HREF="?<?=$urls?>&page=<?=$i?>"><?=$i?></A> <?php }}?><?php if($page!=$lastpg){?> <A HREF="?<?=$urls?>&page=<?=$page+1?>">下页</A> <A HREF="?<?=$urls?>&page=<?=$lastpg?>">尾页</A> <?php }?> | 转至 <SCRIPT LANGUAGE="JAVASCRIPT">function keepKeyNum(obj,evt){var  k=window.event?evt.keyCode:evt.which; if( k==13 ){ goPage(obj.value);return false; }} function goPage( iPage ){ if( !isNaN(parseInt(iPage)) ) { if(iPage< 0 ){iPage=0;} window.location.href="?<?=$urls?>&page="+iPage;}}</SCRIPT><INPUT onKeyPress="return keepKeyNum(this,event);" TYPE="TEXT" ID="iGotoPage" NAME="iGotoPage" size="3"> 页  &nbsp;<BUTTON onClick="javascript:goPage( document.getElementById('iGotoPage').value );return false;">GO</BUTTON></div></td>
              </tr>
            </table></td>
      </tr>  
</table>
<br>


</body>
</html> 