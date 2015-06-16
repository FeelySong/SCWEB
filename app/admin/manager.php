<?php
session_start();
error_reporting(0);
require_once 'conn.php';

if (strpos($_SESSION['admin_flag'],'a1') ){}else{ 
	echo "<script language=javascript>alert('对不起，您无此权限！');window.history.go(-1);</script>";
exit;}

if($_GET['act']=="dels"){
	$ids=$_POST['lids']; 
	for($i=0;$i<count($ids);$i=$i+1){
		$idss=$idss.Get_aname($ids[$i]).",";
	}
	$ids=implode(",", $ids);   //implode函数 把数组元素组合为一个字符串。 
	$sql="delete from ssc_manager where id in ($ids)";  
	mysql_query($sql); 
	
	mysql_query("Delete from ssc_managerlogin where uid in ($ids)");
	mysql_query("Delete from ssc_manageramend where uid in ($ids)");
	amend("删除管理员 ".$idss);	
	
	echo "<script language=javascript>window.location='?';</script>";
	exit;
}

if($_GET['act']=="add"){
	for ($i=0; $i<count($_POST['flag']); $i=$i+1)
	{
		$flags=$flags.",".$_POST['flag'][$i];
	}

	$sql="insert into ssc_manager set username='".$_POST['username']."',name='".$_POST['name']."',department='".$_POST['department']."',password='".md5($_POST['password'])."',qx='".$flags."',regdate='".date("Y-m-d H:i:s")."'";
	$exe=mysql_query($sql) or  die("数据库修改出错1");
	echo "<script>window.location.href='manager.php';</script>"; 
	exit;
}
if($_GET['act']=="edit"){
	for ($i=0; $i<count($_POST['flag']); $i=$i+1)
	{
		$flags=$flags.",".$_POST['flag'][$i];
	}
	
	if($_POST['password']!=""){
		$sql="update ssc_manager set password='".md5($_POST['password'])."',name='".$_POST['name']."',department='".$_POST['department']."',qx='".$flags."' where id=".$_GET['id'];
		$exe=mysql_query($sql) or  die("数据库修改出错2");
	}else{
		$sql="update ssc_manager set name='".$_POST['name']."',department='".$_POST['department']."',qx='".$flags."' where id=".$_GET['id'];
		$exe=mysql_query($sql) or  die("数据库修改出错2");
	}
	echo "<script>window.location.href='manager.php';</script>"; 
	exit;
}
if($_GET['act']=="del"){
	mysql_query("Delete from ssc_manager where id=".$_GET['id']);
	mysql_query("Delete from ssc_managerlogin where uid=".$_GET['id']);
	mysql_query("Delete from ssc_manageramend where uid=".$_GET['id']);
	amend("删除管理员 ".Get_aname($_GET['id']));	
	echo "<script>window.location.href='manager.php';</script>"; 
	exit;
}

$page = !($_GET['page'])?'1':intval($_GET['page']);
$pagesize=20;
$page2=($page-1)*$pagesize;

$sql="select * from ssc_manager order by id asc";
$rs = mysql_query($sql);
$total = mysql_num_rows($rs);

$sql="select * from ssc_manager order by id asc limit $page2,$pagesize";
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
        <td class="top_list_td icons_a10">　　您现在的位置是：权限管理 &gt; 管理员</td>
        <td width="100" class="top_list_td"><input name="Add_User" type="button" value="添加管理员" class="Font_B" onClick="javascript:window.location='manager_edit.php?act=add';"></td>
      </tr>
    </table>
  <br />
  <form method=post action="?act=dels">
	<table width="95%" border="1" cellpadding="0" cellspacing="0" bordercolor="#DDDDDD" class="t_list">
        <tr>
            <td class="t_list_caption">选择</td>
            <td class="t_list_caption">序号</td>
            <td class="t_list_caption">用户名</td>
            <td class="t_list_caption">姓名</td>
            <td class="t_list_caption">所属部门</td>
            <td class="t_list_caption">创建时间</td>
            <td class="t_list_caption">上次登陆时间</td>
            <td class="t_list_caption">上次登陆地址</td>
            <td class="t_list_caption">登陆次数</td>
            <td class="t_list_caption">◎</td>
            <td class="t_list_caption">操作</td>
        </tr>
        <?php
		while ($row = mysql_fetch_array($rsnewslist))
		{
		?>
            <tr class="t_list_tr_0" onMouseOver="this.style.backgroundColor='#FFFFA2'" onMouseOut="this.style.backgroundColor=''">
                <td height="25"><?php if($row['username']!="admin"){?><input name="lids[]" type="checkbox" id="checkbox2" value="<?=$row['id']?>"><?php }?></td> 
                <td height="25"><?=$row['id']?></td>
              <td><?=$row['username']?></td>
                <td><?=$row['name']?></td>
                <td><?=$row['department']?></td>
                <td><?=$row['regdate']?></td>
                <td><?=$row['lastdate']?></td>
                <td><?=$row['lastarea']?></td>
                <td><?=$row['lognums']?></td>
                <td><img src='images/USER_<?php echo Get_online($row['username'])?>.gif'></td>
              <td><a href="manager_edit.php?act=edit&id=<?=$row['id']?>">编辑</a> <?php if($row['username']!="admin"){?><a href="manager.php?act=del&id=<?=$row['id']?>">删除</a><?php }?></td>
  </tr>
 		<?php
		}
		?>

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
</form>

</body>
</html> 