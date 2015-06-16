<?php
session_start();
error_reporting(0);
require_once 'conn.php';

if (strpos($_SESSION['admin_flag'],'23') ){}else{ 
	echo "<script language=javascript>alert('对不起，您无此权限！');window.history.go(-1);</script>";
exit;}

$jb=array("用户","代理","总代理"); 

$uname=$_REQUEST['uname'];

$username_mem=$_REQUEST['username'];
$realname=$_REQUEST['realname'];
$cardno=$_REQUEST['cardno'];

$t_VIP_Estate=$_GET['t_VIP_Estate'];
$Stop_ID=$_GET['Stop_ID'];

if($_GET['act']=="dels"){       //批量删除
	$ids=$_POST['lids'];  
	for($i=0;$i<count($ids);$i=$i+1){
		$idss=$idss.Get_cname($ids[$i]).",";
	}
	$ids=implode(",", $ids);   //implode函数 把数组元素组合为一个字符串。   
	$sql="delete from ssc_bankcard where id in ($ids)";  
	mysql_query($sql); 
	amend("删除用户银行卡 ".$idss);
	echo "<script>alert('删除成功！');window.location.href='mem_card.php';</script>"; 
}

if($_GET['act']=="del"){
	mysql_query("Delete from ssc_bankcard where id=".$_GET['id']);
	amend("删除用户银行卡 ".Get_cname($_GET['id']));	
	echo "<script>alert('删除成功！');window.location.href='mem_card.php';</script>"; 
	exit;
}

if($_GET['act']=="edit"){
	$sql="update ssc_bankcard set realname='".$_POST['realname']."',cardno='".$_POST['cardno']."', bankid='".trim($_POST['bank'])."', bankname='".Get_bank($_POST['bank'])."',bankbranch='".$_POST['bankbranch']."', province='" . trim($_POST['province']) . "', city='" . trim($_POST['city']) . "' where id=".$_GET['id'];
	$exe=mysql_query($sql) or  die("数据库修改出错2");
	amend("编辑用户银行卡 ".Get_cname($_GET['id']));
	echo "<script>alert('修改成功！');window.location.href='mem_card.php';</script>"; 
	exit;
}

$page = !($_GET['page'])?'1':intval($_GET['page']);
$pagesize=15;
$page2=($page-1)*$pagesize;

if($username_mem!=""){
	$s1=$s1." and username='".$username_mem."'";
}else{
	if($uname!=""){
		$s1=$s1." and username='".$uname."'";
	}
}

if($realname!=""){
	$s1=$s1." and realname='".$realname."'";
}

if($cardno!=""){
	$s1=$s1." and cardno='".$cardno."'";
}

$urls="username=".$username_mem."&realname=".$realname."&cardno=".$cardno."&uname=".$uname;

$s1=$s1." order by id desc";
$sql="select * from ssc_bankcard where 1=1".$s1;

$rs = mysql_query($sql);
$total = mysql_num_rows($rs);

$sql="select * from ssc_bankcard where 1=1".$s1." limit $page2,$pagesize";
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
<br>
	<table width="95%" border="0" cellpadding="0" cellspacing="0" class="top_list">
      <tr>
        <td class="top_list_td icons_a2">　　您现在的位置是：会员管理 &gt; 银行信息</td>
      </tr>
    </table>
    <br>
    <form name="memberForm" method="post" action="?">
    <table width="95%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td class="top_list_td">          用户名:&nbsp;
          <input type="text" name="username" maxlength="30" size="15" value="" onKeyPress="alphaOnly(event);" class="inpa" id="username">
          开户姓名:&nbsp;
          <input type="text" name="realname" maxlength="30" size="15" value="" onKeyPress="alphaOnly(event);" class="inpa" id="realname">
          银行帐号:&nbsp;
          <input type="text" name="cardno" maxlength="30" size="30" onKeyPress="alphaOnly(event);" class="inpa" id="cardno">
          &nbsp;
        <input name="Find_VN" type="submit" class="btnb" value="搜 索" style="position: relative; top: 2px;"></td>
        <td width="100" class="top_list_td">&nbsp;</td>
      </tr>
    </table>
    </form>
<br>
  	<form method=post action="?act=dels">
	<table width="95%" border="1" cellpadding="0" cellspacing="0" bordercolor="#DDDDDD" class="t_list">
        <tr>
            <td class="t_list_caption">选择</td>
            <td class="t_list_caption">序号</td>
          <td class="t_list_caption">用户名</td>
          <td class="t_list_caption">开户银行</td>
            <td class="t_list_caption">开户省市</td>
            <td class="t_list_caption">支行名称</td>
            <td class="t_list_caption">开户姓名</td>
          <td class="t_list_caption">银行帐号</td>
          <td class="t_list_caption">绑定时间</td>
          <td class="t_list_caption">操作</td>
      </tr>
        <?php
		while ($row = mysql_fetch_array($rsnewslist))
		{
		?>
            <tr class="t_list_tr_0" onMouseOver="this.style.backgroundColor='#FFFFA2'" onMouseOut="this.style.backgroundColor=''">
                <td><input name="lids[]" type="checkbox" id="checkbox2" value="<?=$row['id']?>"></td> 
                <td><?=$row['id']?></td>
                <td><a href="?uname=<?=$row['username']?>"><?=$row['username']?></a></td>
                <td><?=Get_bank($row['bankid'])?></td>
                <td><?=Get_province($row['province']).Get_city($row['city'])?></td>
                <td><?=$row['bankbranch']?></td>
                <td><?=$row['realname']?></td>
              <td><?=$row['cardno']?></td>
              <td><?=$row['adddate']?></td>
              <td><a href="mem_cardedit.php?act=edit&id=<?=$row['id']?>">修改</a> <a onClick="return confirm('确认要删除吗?');" href="mem_card.php?act=del&id=<?=$row['id']?>">删除</a></td>
  </tr>
 		<?php
		}
		?>

      <tr>
            <td colspan="10" class="t_list_bottom"><table width="100%" border="0" cellspacing="0" cellpadding="0">
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