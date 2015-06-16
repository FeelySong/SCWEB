<?php
session_start();
//error_reporting(0);
require_once 'conn.php';

if (strpos($_SESSION['admin_flag'],'31') ){}else{ 
	echo "<script language=javascript>alert('对不起，您无此权限！');window.history.go(-1);</script>";
exit;}

$jb=array("用户","代理","总代理"); 

$uname=$_REQUEST['uname'];

$username_mem=$_REQUEST['username'];

$t_VIP_Estate=$_GET['t_VIP_Estate'];
$Stop_ID=$_GET['Stop_ID'];

if($_GET['act']=="cz"){

	$cmoney=floatval($_POST['money']);	
	if($cmoney==0){
		echo "<script>alert('请输入正确金额！');window.location.href='?uname=".$_POST['uid']."';</script>"; 
		exit;
	}
	
	$sqla = "select * from ssc_member WHERE username='" . $_POST["uid"] . "'";
	$rsa = mysql_query($sqla);
	$rowa = mysql_fetch_array($rsa);
	$leftmoney=$rowa['leftmoney'];

	$sqlc = "select * from ssc_record order by id desc limit 1";		//帐变
	$rsc = mysql_query($sqlc);
	$rowc = mysql_fetch_array($rsc);
	$dan1 = sprintf("%07s",strtoupper(base_convert($rowc['id']+1,10,36)));
	if($_POST['button']=="充值"){
		$lmoney=$leftmoney+$cmoney;
		$sqla="insert into ssc_record set dan='".$dan1."', uid='".$_POST['sid']."', username='".$_POST['uid']."', types='1', smoney=".$cmoney.",leftmoney=".$lmoney.", regtop='".$rowa['regtop']."', regup='".$rowa['regup']."', regfrom='".$rowa['regfrom']."', adddate='".date("Y-m-d H:i:s")."'";
		$exe=mysql_query($sqla) or  die("数据库修改出错6!!!".mysql_error());

		$sqla="insert into ssc_message set username='".$_POST["uid"]."',types='充提消息',topic='&nbsp;&nbsp;&nbsp;&nbsp;恭喜您，充值成功', content='<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;您成功充值".$cmoney."元, 请注意查看您的帐变信息，如果有任何疑问请联系我们在线客服。</p>',adddate='".date("Y-m-d H:i:s")."'";
//		echo $sqla;
		$exe=mysql_query($sqla) or  die("数据库修改出错6!!!".mysql_error());
		
		$sqlb="insert into ssc_savelist set uid='".$_POST['sid']."', username='".$_POST['uid']."', bank='手动充值', bankid='0', cardno='', money=".$cmoney.", sxmoney='0', rmoney=".$cmoney.", adddate='".date("Y-m-d H:i:s")."',zt='1',types='2'";
		$exe=mysql_query($sqlb) or  die("数据库修改出错6!!!".mysql_error());
		
		$sqlb = "SELECT * FROM ssc_activity where id ='1'";
		$rsb = mysql_query($sqlb);
		$rowb = mysql_fetch_array($rsb);
		if($rowb['zt']==1){
			if(date("Y-m-d H:i:s")>$rowb['starttime'] && date("Y-m-d H:i:s")<$rowb['endtime']){
				if(floatval($rowb['tjz'])>0){
					$cmoney2=$cmoney*floatval($rowb['tjz']);
					$lmoney=$lmoney+$cmoney2;

					$sqlc = "select * from ssc_record order by id desc limit 1";		//帐变
					$rsc = mysql_query($sqlc);
					$rowc = mysql_fetch_array($rsc);
					$dan1 = sprintf("%07s",strtoupper(base_convert($rowc['id']+1,10,36)));
					
					$sql="insert into ssc_record set dan='".$dan1."', uid='".$_POST['sid']."', username='".$_POST['uid']."', types='32', smoney=".$cmoney2.",leftmoney=".$lmoney.", regtop='".$rowa['regtop']."', regup='".$rowa['regup']."', regfrom='".$rowa['regfrom']."', adddate='".date("Y-m-d H:i:s")."'";
					$exe=mysql_query($sql) or  die("数据库修改出错6!!!".mysql_error());
				}
			}
		}

		$sql="update ssc_member set leftmoney ='".$lmoney."',totalmoney=totalmoney+ '".$cmoney."' where id ='".$_POST['sid']."'";
		if (!mysql_query($sql)){
			die('Error: ' . mysql_error());
		}
		
		amend("帐户充值 ".$_POST['uid']." ".$cmoney."元");
		
		echo "<script language=javascript>alert('充值成功！');</script>";

	}else if($_POST['button']=="扣款"){
		$lmoney=$leftmoney-$cmoney;
		$sql="update ssc_member set leftmoney ='".$lmoney."',totalmoney=totalmoney- '".$cmoney."' where id ='".$_POST['sid']."'";
		if (!mysql_query($sql)){
			die('Error: ' . mysql_error());
		}
		$sqla="insert into ssc_record set dan='".$dan1."',uid='".$_POST['sid']."', username='".$_POST['uid']."', types='50', zmoney=".$cmoney.",leftmoney=".$lmoney.", regtop='".$rowa['regtop']."', regup='".$rowa['regup']."', regfrom='".$rowa['regfrom']."', adddate='".date("Y-m-d H:i:s")."'";
		$exe=mysql_query($sqla) or  die("数据库修改出错6!!!".mysql_error());
		amend("帐户扣款 ".$_POST['uid']." ".$cmoney."元");
		
		echo "<script language=javascript>alert('扣款成功！');</script>";
	}	
//	$sqla="insert into ssc_savelist set uid='".$_POST['sid']."', username='".$_POST['uid']."', money=".$_POST['money'].", sxmoney='0', rmoney=".$_POST['money'].", adddate='".date("Y-m-d H:i:s")."',zt='1'";
//	$exe=mysql_query($sqla) or  die("数据库修改出错6!!!".mysql_error());
	
	echo "<script>window.location.href='?uname=".$_POST['uid']."';</script>"; 
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
	}else{
		$s1=$s1." and 1=0";	
	}
}

$urls="username=".$username_mem."&uname=".$uname;

$s1=$s1." order by id desc";
$sql="select * from ssc_member where 1=1".$s1;

$rs = mysql_query($sql);
$total = mysql_num_rows($rs);

$sql="select * from ssc_member where 1=1".$s1." limit $page2,$pagesize";
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
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body>
<br>
	<table width="95%" border="0" cellpadding="0" cellspacing="0" class="top_list">
      <tr>
        <td class="top_list_td icons_a3">　　您现在的位置是：财务管理 &gt; 手动充值</td>
      </tr>
    </table>
    <br>
    <form name="memberForm" method="post" action="?">
    <table width="95%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td class="top_list_td">用户名
          <input type="text" name="username" maxlength="30" size="20" value="" class="inpa" id="username">
          &nbsp;
          <input name="Find_VN" type="submit" class="btnb" value="搜 索" style="position: relative; top: 2px;"></td>
        <td width="100" class="top_list_td">&nbsp;</td>
      </tr>
    </table>
    </form>
<br>
<table width="95%" border="1" cellpadding="0" cellspacing="0" bordercolor="#DDDDDD" class="t_list">
  <tr>
    <td class="t_list_caption">序号</td>
    <td class="t_list_caption">用户名</td>
    <td width="30" class="t_list_caption">◎</td>
    <td class="t_list_caption">类型</td>
    <td class="t_list_caption">余额</td>
    <td class="t_list_caption">总充值</td>
    <td class="t_list_caption">总消费</td>
    <td class="t_list_caption">开户时间</td>
    <td class="t_list_caption">最后登录</td>
    <td class="t_list_caption">登录次数</td>
    <td class="t_list_caption">状态</td>
    <td class="t_list_caption">充值金额</td>
    <td class="t_list_caption">操作</td>
  </tr>
  <?php
		while ($row = mysql_fetch_array($rsnewslist))
		{
		?>
            <form action="?act=cz" method="post" name="form1" id="form1">
  <tr class="t_list_tr_0" onMouseOver="this.style.backgroundColor='#FFFFA2'" onMouseOut="this.style.backgroundColor=''">
    <td><?=$row['id']?><input type="hidden" name="sid" value="<?=$row['id']?>" /><input type="hidden" name="uid" value="<?=$row['username']?>" /></td>
    <td><?=$row['username']?></td>
    <td><img src='images/USER_<?php echo Get_online($row['username'])?>.gif'></td>
    <td><?=$jb[$row['level']]?></td>
    <td><?=$row['leftmoney']?></td>
    <td><?=$row['totalmoney']?></td>
    <td><?=$row['usedmoney']?></td>
    <td><?=date("Y-m-d",strtotime($row['regdate']))?></td>
    <td><?php if($row['lastdate']==""){echo "------";}else{echo date("Y-m-d",strtotime($row['lastdate']));}?></td>
    <td><?=$row['lognums']?></td>
    <td><?php if($row['zt']==0){echo "<span class='Font_G'>正常</span>";}else if($row['zt']==1){echo "<span class='Font_B'>冻结</span>";}else if($row['zt']==2){echo "<span class='Font_Y'>锁定</span>";}else if($row['zt']==3){echo "<span class='Font_R'>清理</span>";}?></td>
    <td><input name="money" type="text" class="inp1" id="money" onFocus="this.className='inp1a'" onBlur="this.className='inp1';" onKeyPress="alphaOnly(event);" value="0" size="10" maxlength="15" ></td>
    <td>
      <input name="button" type="submit" class="but1" id="button" value="充值"  onClick="return confirm('确认要充值吗?');"/>
      &nbsp;
      <input name="button" type="submit" class="but1" id="button" value="扣款"  onClick="return confirm('确认要扣款吗?');"/></td>
  </tr>
  </form>
  <?php
		}
		?>
</table>
<br>


</body>
</html> 