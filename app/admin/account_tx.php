<?php
session_start();
error_reporting(0);
require_once 'conn.php';

if (strpos($_SESSION['admin_flag'],'33') ){}else{ 
	echo "<script language=javascript>alert('对不起，您无此权限！');window.history.go(-1);</script>";
exit;}

$jb=array("用户","代理","总代理"); 

$uname=$_REQUEST['uname'];

$username_mem=$_REQUEST['username'];
$dan=$_REQUEST['dan'];
$zt=$_REQUEST['zt'];

$t_VIP_Estate=$_GET['t_VIP_Estate'];
$Stop_ID=$_GET['Stop_ID'];

if($_GET['act']=="tx"){
	if($_POST['button']=="审核"){
		$sqla="update ssc_drawlist set cno='".$_POST['dan']."', cdate='".date("Y-m-d H:i:s")."', zt='1' where dan='".$_POST['sid']."'";
		$exe=mysql_query($sqla) or  die("数据库修改出错6!!!".mysql_error());

		$sqla="insert into ssc_message set username='".$_POST["uid"]."',types='充提消息',topic='&nbsp;&nbsp;&nbsp;&nbsp;恭喜您，提现【<font color=blue>".$_POST['sid']."</font>】已成功处理', content='<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;您的提现申请【编号：<font color=blue>".$_POST['sid']."</font>】已经成功处理, 请注意查看您的帐变信息，如果有任何疑问请联系我们在线客服。</p>',adddate='".date("Y-m-d H:i:s")."'";
//		echo $sqla;
		$exe=mysql_query($sqla) or  die("数据库修改出错6!!!".mysql_error());
		
	}else if($_POST['button']=="拒绝"){
		$sqla="update ssc_drawlist set cno='".$_POST['dan']."', cdate='".date("Y-m-d H:i:s")."', zt='2' where dan='".$_POST['sid']."'";	
		$exe=mysql_query($sqla) or  die("数据库修改出错6!!!".mysql_error());

		$sqlb = "select * from ssc_drawlist WHERE dan='" . $_POST["sid"] . "'";
		$rsb = mysql_query($sqlb);
		$rowb = mysql_fetch_array($rsb);

		$sqla = "select * from ssc_member WHERE username='" . $_POST["uid"] . "'";
		$rsa = mysql_query($sqla);
		$rowa = mysql_fetch_array($rsa);
		$lmoney=$rowa['leftmoney']+$rowb['money'];
	
		$sqlc = "select * from ssc_record order by id desc limit 1";		//帐变
		$rsc = mysql_query($sqlc);
		$rowc = mysql_fetch_array($rsc);
		$dan1 = sprintf("%07s",strtoupper(base_convert($rowc['id']+1,10,36)));		

		$sqla="insert into ssc_record set dan='".$dan1."', uid='".$rowa['id']."', username='".$rowa['username']."', types='3', smoney=".$rowb['money'].",leftmoney=".$lmoney.", regtop='".$rowa['regtop']."', regup='".$rowa['regup']."', regfrom='".$rowa['regfrom']."', adddate='".date("Y-m-d H:i:s")."'";
		$exe=mysql_query($sqla) or  die("数据库修改出错6!!!".mysql_error());
		
		$sqla="update ssc_member set leftmoney=".$lmoney." where id='".$rowa['id']."'"; 
		$exe=mysql_query($sqla) or  die("数据库修改出错2!!!".mysql_error());
	}
	echo "<script>alert('操作成功！');window.location.href='?';</script>"; 
	exit;
}

$page = !($_GET['page'])?'1':intval($_GET['page']);
$pagesize=20;
$page2=($page-1)*$pagesize;

if($username_mem!=""){
	$s1=$s1." and username='".$username_mem."'";
}else{
	if($uname!=""){
		$s1=$s1." and username='".$uname."'";
	}
}

if($dan!=""){
	$s1=$s1." and id='".$dan."'";
}

//if($zt!=""){
	$s1=$s1." and zt='0'";
//}
$urls="username=".$username_mem."&dan=".$dan."&uname=".$uname;

$s1=$s1." order by id desc";
$sql="select * from ssc_drawlist where 1=1".$s1;

$rs = mysql_query($sql);
$total = mysql_num_rows($rs);

$sql="select * from ssc_drawlist where 1=1".$s1." limit $page2,$pagesize";
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
        <td class="top_list_td icons_a3">　　您现在的位置是：财务管理 &gt; 提现请求</td>
      </tr>
    </table>
    <br>
    <form name="memberForm" method="post" action="?">
    <table width="95%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td class="top_list_td">用户名:
          <input type="text" name="username" maxlength="30" size="15" class="inpa" id="username">
&nbsp;提现编号:
<input type="text" name="dan" maxlength="30" size="15" value="" class="inpa" id="dan">
&nbsp;
          <input name="Find_VN" type="submit" class="btnb" value="搜 索" style="position: relative; top: 2px;"></td>
        <td width="100" class="top_list_td">&nbsp;</td>
      </tr>
    </table>
    </form>
<br>
<table width="95%" border="1" cellpadding="0" cellspacing="0" bordercolor="#DDDDDD" class="t_list">
  <tr>
    <td class="t_list_caption">用户名</td>
    <td class="t_list_caption">提现编号</td>
    <td class="t_list_caption">申请发起时间</td>
	<td class="t_list_caption">提现银行</td>
	<td class="t_list_caption">开户省市</td>
    <td class="t_list_caption">支行名称</td>
    <td class="t_list_caption">开户姓名</td>
    <td class="t_list_caption">银行帐号</td>
    <td class="t_list_caption">提现金额</td>
    <td class="t_list_caption">手续费</td>
    <td class="t_list_caption">到账金额</td>
    <td class="t_list_caption">状态</td>
    
    <td class="t_list_caption">提现单号</td>
    <td class="t_list_caption">操作</td>
  </tr>
  <?php
		while ($row = mysql_fetch_array($rsnewslist))
		{
		?>
            <form action="?act=tx" method="post" name="form1" id="form1">
  <tr class="t_list_tr_0" onMouseOver="this.style.backgroundColor='#FFFFA2'" onMouseOut="this.style.backgroundColor=''">
    <td><?=$row['username']?></td>
    <td><?=$row['dan']?>
      <input type="hidden" name="sid" value="<?=$row['dan']?>" />
      <input type="hidden" name="uid" value="<?=$row['username']?>" /></td>
    <td><?=$row['adddate']?></td>
	<td><?=$row['bank']?></td>
	<td><?=$row['province'].$row['city']?></td>
    <td><?=$row['branch']?></td>
    <td><?=$row['realname']?></td>
    <td><?=$row['cardno']?></td>
    <td><?=number_format($row['money'],2)?></td>
    <td><?=number_format($row['sxmoney'],2)?></td>
    <td><?=number_format($row['rmoney'],2)?></td>
    <td id="status"><?php if($row['zt']=="0"){?><font color="#FF0000">等待处理</font><?php }else if($row['zt']=="1"){?><font color=#669900>提现成功</font><?php }else if($row['zt']=="2"){?><font color="#0000FF">提现失败</font><?php }?></td>
    <td><input name="dan" type="text" class="inp1" id="dan" onFocus="this.className='inp1a'" onBlur="this.className='inp1';" onKeyPress="alphaOnly(event);" value="<?=$row['cno']?>" size="15" maxlength="30" ></td>
    <td><a href="account_record.php?uname=<?=$row['username']?>">
      <input name="button" type="submit" class="but1" id="button" value="审核"  onClick="return confirm('确认要审核吗?');"/>
      <input name="button" type="submit" class="but1" id="button" value="拒绝"  onClick="return confirm('确认要拒绝吗?');"/>
    </a></td>
  </tr>
  </form>
  <?php
		}
		?>
  <tr>
    <td colspan="14" class="t_list_bottom"><table width="100%" border="0" cellspacing="0" cellpadding="0">
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