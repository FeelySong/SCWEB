<?php
session_start();
error_reporting(0);
require_once 'conn.php';

if (strpos($_SESSION['admin_flag'],'96') ){}else{ 
	echo "<script language=javascript>alert('对不起，您无此权限！');window.history.go(-1);</script>";
exit;}

if($_GET['act']=="dels"){       //批量删除   
	$ids=$_POST['lids'];  
	$ids=implode(",", $ids);   //implode函数 把数组元素组合为一个字符串。   
	$sql="delete from ssc_lockip where id in ($ids)";  
	mysql_query($sql);  
}

if($_GET['act']=="add"){
	$sql="select * from ssc_lockip where ip='".$_POST['ip']."'";
	$rs=mysql_query($sql) or  die("数据库修改出错2");
	$total = mysql_num_rows($rs);
	if($total==0){
		$ip1=$_REQUEST['ip'];
		$ip2=explode(".",$ip1);
		if(count($ip2)==4){
			$ip3=$ip2[0]*256*256*256+$ip2[1]*256*256+$ip2[2]*256+$ip2[3];
						
			$sql = "select * from ssc_ipdata WHERE StartIP<=".$ip3." and EndIP>=".$ip3."";
			$quip = mysql_query($sql) or  die("数据库修改出错". mysql_error());
			$dip = mysql_fetch_array($quip);
			$iparea = $dip['Country']." ".$dip['Local'];
		}
		$sql="insert into ssc_lockip set ip='".$ip1."',area='".$iparea."',reason='".$_POST['reason']."',username='".$_SESSION["ausername"]."',adddate='".date("Y-m-d H:i:s")."'";
	//	echo $sql;
		$exe=mysql_query($sql) or  die("数据库修改出错2");
		echo "<script>alert('添加IP地址成功');window.location.href='lockip.php';</script>"; 
		exit;
	}else{
		echo "<script>alert('该IP地址已存在！');window.location.href='lockip.php';</script>"; 
		exit;
	}
}
if($_GET['act']=="del"){
	$sql = "delete from ssc_lockip WHERE id=".$_GET['id']."";
	$exe = mysql_query($sql) or  die("数据库修改出错". mysql_error());
	echo "<script>alert('删除IP地址成功');window.location.href='lockip.php';</script>"; 
	exit;
}

$page = !($_GET['page'])?'1':intval($_GET['page']);
$pagesize=20;
$page2=($page-1)*$pagesize;

$sql="select * from ssc_lockip order by id asc";
$rs = mysql_query($sql);
$total = mysql_num_rows($rs);

$sql="select * from ssc_lockip order by id asc limit $page2,$pagesize";
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
</head>

<body>
<div align="center"><br />
	<table width="95%" border="0" cellpadding="0" cellspacing="0" class="top_list">
      <tr>
        <td class="top_list_td icons_a9">　　您现在的位置是：系统管理 &gt; 锁定</td>
      </tr>
    </table>
  <br />
	<table width="95%" border="1" cellpadding="0" cellspacing="0" bordercolor="#DDDDDD" class="t_list">
			<tr>
				<td class="t_list_caption">选择</td>
				<td class="t_list_caption">序号</td>
				<td class="t_list_caption">IP地址</td>
				<td class="t_list_caption">位置</td>
				<td class="t_list_caption">原因</td>
				<td class="t_list_caption">操作</td>
			</tr>
  			<form method=post action="?act=dels">
			<?php 
			$i=0;
			while ($row = mysql_fetch_array($rsnewslist)){?>
			<tr class="t_list_tr_<?=$i%2?>" onMouseOver="this.style.backgroundColor='#E8F1FF'" onMouseOut="this.style.backgroundColor=''">
				<td height="25"  align="center"><input name="lids[]" type="checkbox" id="checkbox2" value="<?=$row['id']?>" /></td>
				<td height="25"  align="center"><?=$row['id']?></td>
				<td align="center"><?=$row['ip']?></td>
				<td align="center"><?=$row['area']?></td>
				<td align="center"><?=$row['reason']?></td>
				<td align="center"><a href="lockip.php?act=del&id=<?=$row['id']?>">删除</a></td>
			</tr>
			<?php 
			$i=$i+1;
			}
			?>
			</form>
      		<form method=post action="?act=add">
			<tr class="t_list_tr_2">
				<td colspan="2" class="t_list_tr_2">新增IP</td>
				<td colspan="2" class="t_list_tr_2"><input type="text" name="ip" id="ip" /></td>
				<td class="t_list_tr_2"><input type="text" name="reason" id="reason" /></td>
				<td class="t_list_tr_2"><input type="submit" name="button" id="button" value="新增"  class="but1"/></td>
            </tr>  
            </form><tr>
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
</div>
</body>
</html>
