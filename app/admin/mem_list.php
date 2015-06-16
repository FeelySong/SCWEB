<?php
session_start();
error_reporting(0);
require_once 'conn.php';

if (strpos($_SESSION['admin_flag'],'22') ){}else{ 
	echo "<script language=javascript>alert('对不起，您无此权限！');window.history.go(-1);</script>";
exit;}

$jb=array("用户","代理","总代理"); 
$zts=array("启用","冻结","锁定"); 
$UP_ID=$_GET['UP_ID'];

$Compositor=$_POST['Compositor'];
$Ascending=$_POST['Ascending'];
$FindTxt=$_POST['FindTxt'];
$FindType=$_POST['FindType'];
$zt=$_POST['zt'];

$t_VIP_Estate=$_GET['t_VIP_Estate'];
$Stop_ID=$_GET['Stop_ID'];

if($Stop_ID!=""){
	$sql="update ssc_member set zt='".$t_VIP_Estate."' where id='".$Stop_ID."'";
	$exe=mysql_query($sql) or  die("数据库修改出错2");
	
	amend($zts[$t_VIP_Estate]."用户 ".Get_mname($Stop_ID));	
	echo "<script>window.location.href='?';</script>"; 
	exit;
}

if($_GET['act']=="dels"){
	$ids=$_POST['lids']; 
	for($i=0;$i<count($ids);$i=$i+1){
		$idss=$idss."'".Get_mname($ids[$i])."'";
		if($i!=count($ids)-1){
			$idss=$idss.",";
		}
	}
//	echo $idss;
	$ids=implode(",", $ids);   //implode函数 把数组元素组合为一个字符串。 
	if($_POST['button']=="删除"){
		$sql="delete from ssc_member where id in ($ids)";  
		mysql_query($sql); 
		mysql_query("Delete from ssc_record where uid in ($ids)");
		mysql_query("Delete from ssc_bills where uid in ($ids)");
		mysql_query("Delete from ssc_zbills where uid in ($ids)");
		mysql_query("Delete from ssc_zdetail where uid in ($ids)");
		mysql_query("Delete from ssc_savelist where uid in ($ids)");
		mysql_query("Delete from ssc_bankcard where uid in ($ids)");
		mysql_query("Delete from ssc_kf where username in ($idss)");
		mysql_query("Delete from ssc_message where username in ($idss)");
		mysql_query("Delete from ssc_memberlogin where uid in ($ids)");
		mysql_query("Delete from ssc_memberamend where uid in ($ids)");
		
		amend("删除用户 ".$idss);	
	}else if($_POST['button']=="冻结"){
		$sql="update ssc_member set zt='1' where id in ($ids)";  
		mysql_query($sql); 	
		amend("冻结用户 ".$idss);	
	}else if($_POST['button']=="锁定"){
		$sql="update ssc_member set zt='2' where id in ($ids)";  
		mysql_query($sql); 
		amend("锁定用户 ".$idss);	
	}else if($_POST['button']=="正常"){
		$sql="update ssc_member set zt='0' where id in ($ids)";  
		mysql_query($sql); 
		amend("启用用户 ".$idss);	
	}
	
	echo "<script language=javascript>window.location='?';</script>";
	exit;
}

if($_GET['act']=="add"){
	if($_REQUEST['usertype']=="" || $_REQUEST['username']=="" || $_REQUEST['userpass']=="" || $_REQUEST['nickname']==""){
		echo "<script language=javascript>alert('用户信息必填项请填写！');window.history.go(-1);</script>";
		exit;	
	}

	if(strpos($_POST['username']," ") || strpos($_POST['username'],"'") || strpos($_POST['username'],"_")){
	  echo "<script>alert('用户名含特殊字符!');window.history.go(-1);</script>"; 
	  exit;
	}
	
		$sqls = "SELECT * FROM ssc_member where username='".$_REQUEST['username']."'";
		$rss = mysql_query($sqls);
		$nums=mysql_num_rows($rss);
		if($nums>0){
			echo "<script language=javascript>alert('该用户名已存在，请重新输入！');window.history.go(-1);</script>";
			exit;
		}
		if($_REQUEST['keeppoint']!=""){
			$sqla = "SELECT * FROM ssc_classb order by id asc";
			$rsa = mysql_query($sqla);
			while ($row = mysql_fetch_array($rsa)){
				$rstrb=explode(",",$rstra[$i]);
				$pid=$row['cid']."_".$row['mid'];
				$rebatea=$rebatea.$pid.",".judgez($row['rebate']-$_REQUEST['keeppoint']).",1;";
				if($row['mid']=="1"){
					$flevel=judgez($row['rebate']-$_REQUEST['keeppoint']);	
				}
			}
		}else{
			$sqla = "SELECT * FROM ssc_classb order by id asc";
			$rsa = mysql_query($sqla);
			while ($row = mysql_fetch_array($rsa)){
				$pid=$row['cid']."_".$row['mid'];
				$rebatea=$rebatea.$pid.",".$_REQUEST['point_'.$pid].",1;";
				if($row['mid']=="1"){
					$flevel=$_REQUEST['point_1_1'];	
				}
			}
		}

		if($_REQUEST['usertype']==2){
			$zc=$_REQUEST['zc'];
		}else{
			$zc=0;
		}
		$sql = "insert into ssc_member set username='" . $_REQUEST['username'] . "', password='" . md5($_REQUEST['userpass']) . "', nickname='" . $_REQUEST['nickname'] . "', regfrom='', regup='', regtop='', rebate='" . $rebatea . "', flevel='" . $flevel . "', zc='" . $zc . "', level='" . $_REQUEST['usertype'] . "', regdate='" . date("Y-m-d H:i:s") . "'";
		$exe = mysql_query($sql);
		
		$sqla = "SELECT * FROM ssc_activity where id ='3'";
		$rsa = mysql_query($sqla);
		$rowa = mysql_fetch_array($rsa);
		if($rowa['zt']==1){
			if(date("Y-m-d H:i:s")>$rowa['starttime'] && date("Y-m-d H:i:s")<$rowa['endtime']){
				if(floatval($rowa['tjz'])>0){
					$sqlc = "select * from ssc_record order by id desc limit 1";		//帐变
					$rsc = mysql_query($sqlc);
					$rowc = mysql_fetch_array($rsc);
					$dan1 = sprintf("%07s",strtoupper(base_convert($rowc['id']+1,10,36)));
					
					$sqlc = "select * from ssc_member where username ='".$_REQUEST['username']."'";	
					$rsc = mysql_query($sqlc);
					$rowc = mysql_fetch_array($rsc);
					$uid=$rowc['id'];
					
					$sqlb="insert into ssc_record set dan='".$dan1."', uid='".$uid."', username='".$_REQUEST['username']."', types='32', smoney=".floatval($rowa['tjz']).",leftmoney=".(floatval($rowa['tjz'])).", regtop='', regup='', regfrom='', adddate='".date("Y-m-d H:i:s")."'";
					$exe=mysql_query($sqlb) or  die("数据库修改出错6!!!".mysql_error());
					
					$sql="update ssc_member set leftmoney ='".floatval($rowa['tjz'])."' where username ='".$_REQUEST['username']."'";
					$exe=mysql_query($sql) or  die("数据库修改出错6!!!".mysql_error());
					
				}
			}
		}

		amend("创建用户 ".$_REQUEST['username']);	
		echo "<script language=javascript>alert('创建用户成功！');window.location='mem_list.php';</script>";
		exit;
}
if($_GET['act']=="edit"){
	if($_POST['button']=="充 值" || $_POST['button']=="扣 款"){
		$cmoney=floatval($_POST['cmoney']);
		if($cmoney==0){
			echo "<script>alert('请输入正确金额！');window.location.href='mem_edit.php?act=edit&uid=".$_GET['uid']."';</script>"; 
			exit;
		}
		
		$sqla = "select * from ssc_member WHERE id='" . $_GET["uid"] . "'";
		$rsa = mysql_query($sqla);
		$rowa = mysql_fetch_array($rsa);
		$leftmoney=$rowa['leftmoney'];
		$sqlc = "select * from ssc_record order by id desc limit 1";		//帐变
		$rsc = mysql_query($sqlc);
		$rowc = mysql_fetch_array($rsc);
		$dan1 = sprintf("%07s",strtoupper(base_convert($rowc['id']+1,10,36)));
		if($_POST['button']=="充 值"){
			$lmoney=$leftmoney+$cmoney;
		
			$sqla="insert into ssc_record set dan='".$dan1."', uid='".$_GET['uid']."', username='".Get_mname($_GET['uid'])."', types='1', smoney=".$cmoney.",leftmoney=".$lmoney.", regtop='".$rowa['regtop']."', regup='".$rowa['regup']."', regfrom='".$rowa['regfrom']."', adddate='".date("Y-m-d H:i:s")."'";
			$exe=mysql_query($sqla) or  die("数据库修改出错6!!!".mysql_error());

			$sqlb="insert into ssc_savelist set uid='".$_GET['uid']."', username='".Get_mname($_GET['uid'])."', bank='手动充值', bankid='0', cardno='', money=".$cmoney.", sxmoney='0', rmoney=".$cmoney.", adddate='".date("Y-m-d H:i:s")."',zt='1',types='2'";
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
						
						$sql="insert into ssc_record set dan='".$dan1."', uid='".$_GET['uid']."', username='".Get_mname($_GET['uid'])."', types='32', smoney=".$cmoney2.",leftmoney=".$lmoney.", regtop='".$rowa['regtop']."', regup='".$rowa['regup']."', regfrom='".$rowa['regfrom']."', adddate='".date("Y-m-d H:i:s")."'";
						$exe=mysql_query($sql) or  die("数据库修改出错6!!!".mysql_error());
					}
				}
			}

			$sql="update ssc_member set leftmoney ='".$lmoney."',totalmoney=totalmoney+ '".$cmoney."' where id ='".$_GET['uid']."'";
			$exe=mysql_query($sql) or  die("数据库修改出错6!!!".mysql_error());
			
			amend("帐户充值 ".Get_mname($_GET['uid'])." ".$cmoney."元");	
			echo "<script language=javascript>alert('充值成功！');</script>";			
		}else if($_POST['button']=="扣 款"){
			$lmoney=$leftmoney-$cmoney;
			$sql="update ssc_member set leftmoney ='".$lmoney."',totalmoney=totalmoney- '".$cmoney."' where id ='".$_GET['uid']."'";
			$exe=mysql_query($sql) or  die("数据库修改出错6!!!".mysql_error());
		
			$sqla="insert into ssc_record set dan='".$dan1."', uid='".$_GET['uid']."', username='".Get_mname($_GET['uid'])."', types='50', zmoney=".$cmoney.",leftmoney=".$lmoney.", regtop='".$rowa['regtop']."', regup='".$rowa['regup']."', regfrom='".$rowa['regfrom']."', adddate='".date("Y-m-d H:i:s")."'";
			$exe=mysql_query($sqla) or  die("数据库修改出错6!!!".mysql_error());
			amend("帐户扣款 ".Get_mname($_GET['uid'])." ".$cmoney."元");	
			echo "<script language=javascript>alert('扣款成功！');</script>";

		}
		echo "<script>window.location.href='mem_edit.php?act=edit&uid=".$_GET['uid']."';</script>"; 
		exit;
	}

		if($_REQUEST['keeppoint']!=""){
			$sqla = "SELECT * FROM ssc_classb order by id asc";
			$rsa = mysql_query($sqla);
			while ($row = mysql_fetch_array($rsa)){
				$rstrb=explode(",",$rstra[$i]);
				$pid=$row['cid']."_".$row['mid'];
				$rebatea=$rebatea.$pid.",".judgez($row['rebate']-$_REQUEST['keeppoint']).",1;";
				if($row['mid']=="1"){
					$flevel=judgez($row['rebate']-$_REQUEST['keeppoint']);	
				}
			}
		}else{
			$sqla = "SELECT * FROM ssc_classb order by id asc";
			$rsa = mysql_query($sqla);
			while ($row = mysql_fetch_array($rsa)){
				$pid=$row['cid']."_".$row['mid'];
				$rebatea=$rebatea.$pid.",".$_REQUEST['point_'.$pid].",1;";
				if($row['mid']=="1"){
					$flevel=$_REQUEST['point_1_1'];	
				}
			}
		}

		if($_REQUEST['usertype']==2){
			$zc=$_REQUEST['zc'];
		}else{
			$zc=0;
		}
		
		if($_REQUEST['userpass']==""){
			if($_REQUEST['cwpassword']==""){
				$sql = "update ssc_member set nickname='" . $_REQUEST['nickname'] . "', rebate='" . $rebatea . "', flevel='" . $flevel . "', zc='" . $zc . "' where id='" . $_GET['uid'] . "'";
			}else{
				$sql = "update ssc_member set cwpwd='" . md5($_REQUEST['cwpassword']) . "', nickname='" . $_REQUEST['nickname'] . "', rebate='" . $rebatea . "', flevel='" . $flevel . "', zc='" . $zc . "' where id='" . $_GET['uid'] . "'";
			}
		}else{
			if($_REQUEST['cwpassword']==""){		
				$sql = "update ssc_member set password='" . md5($_REQUEST['userpass']) . "', nickname='" . $_REQUEST['nickname'] . "', rebate='" . $rebatea . "', flevel='" . $flevel . "', zc='" . $zc . "' where id='" . $_GET['uid'] . "'";		
			}else{
				$sql = "update ssc_member set password='" . md5($_REQUEST['userpass']) . "', cwpwd='" . md5($_REQUEST['cwpassword']) . "', nickname='" . $_REQUEST['nickname'] . "', rebate='" . $rebatea . "', flevel='" . $flevel . "', zc='" . $zc . "' where id='" . $_GET['uid'] . "'";
			}
		}
		$exe = mysql_query($sql) or  die("数据库修改出错2");

		amend("修改用户资料 ".Get_mname($_GET['uid']));	

		echo "<script language=javascript>alert('修改用户成功！');window.location='mem_list.php';</script>";
		exit;
}

if($_GET['act']=="del"){
	$uid=$_GET['id'];
	$uname=Get_mname($_GET['id']);
	mysql_query("Delete from ssc_member where id=".$uid);
	mysql_query("Delete from ssc_record where uid=".$uid);
	mysql_query("Delete from ssc_bills where uid=".$uid);
	mysql_query("Delete from ssc_zbills where uid=".$uid);
	mysql_query("Delete from ssc_zdetail where uid=".$uid);
	mysql_query("Delete from ssc_savelist where uid=".$uid);
	mysql_query("Delete from ssc_bankcard where uid=".$uid);
//	echo "Delete from ssc_bankcard where uid=".$uid;
	mysql_query("Delete from ssc_kf where username ='".$uname."'");
	mysql_query("Delete from ssc_message where username ='".$uname."'");
//	echo "Delete from ssc_message where username ='".$uname."'";
	mysql_query("Delete from ssc_memberlogin where uid=".$uid);
//	echo "Delete from ssc_memberlogin where uid=".$uid;
	mysql_query("Delete from ssc_memberamend where uid=".$uid);

	amend("删除用户 ".$uname);	
	
	echo "<script>alert('删除用户成功！');window.location.href='mem_list.php';</script>"; 
	exit;
}
if($_GET['act']=="czzt"){
	mysql_query("update ssc_member set czzt='".$_GET['czzt']."',czxg='500' where id=".$_GET['uid']);
	
	amend("修改用户 ".Get_mname($_GET['uid'])."充值状态为".$_GET['czzt']);	
	
	echo "<script>alert('修改用户充值状态成功！');window.location.href='mem_list.php';</script>"; 
	exit;	
}
if($_GET['act']=="bank"){
	mysql_query("update ssc_member set cardlock='".$_GET['cardlock']."' where id=".$_GET['uid']);
	
	amend("修改用户 ".Get_mname($_GET['uid'])."银行卡状态为".$_GET['cardlock']);	
	
	echo "<script>alert('修改用户银行卡状态成功！');window.location.href='mem_list.php';</script>"; 
	exit;	
}
$page = !($_GET['page'])?'1':intval($_GET['page']);
$pagesize=15;
$page2=($page-1)*$pagesize;

if($Compositor==""){
$Compositor="id";
$Ascending="desc";
}
if($zt!=""){
	$s1=" and zt='".$zt."'";
}
if($FindType!=""){
	$s1=$s1." and level='".$FindType."'";
}
if($FindTxt!=""){
	$s1=$s1." and username='".$FindTxt."'";
}else{
	if($UP_ID!=""){
		$s1=$s1." and regup='".$UP_ID."'";
	}
}

$urls="FindType=".$FindType."&FindTxt=".$FindTxt."&UP_ID=".$UP_ID."&Compositor=".$Compositor."&Ascending=".$Ascending;

$s1=$s1." order by ".$Compositor." ".$Ascending;
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
function open_Estate(t_id,t_Estate,evt){
	document.all.Stop_UserID.value=t_id;
	document.all.t_user_Estate[Number(t_Estate)].checked = true;

	var estate_window = document.getElementById("estate_window");	
	
	estate_window.style.top = evt.clientY + 12 + document.body.scrollTop;
	estate_window.style.left = evt.clientX - 80;
	
	estate_window.style.display="block";
	
	Timt_HE=setTimeout("Hide_Estate();",4000);
}
function Hide_Estate(){
    clearTimeout(Timt_HE);
    estate_window.style.display='none'
}
function stopOnClick(t_Estate) {
	document.all["estate_window"].style.display="none";

    window.location="?Stop_ID=" + document.all.Stop_UserID.value + "&t_VIP_Estate=" + t_Estate + "&Compositor=username&Ascending=asc&sPage=1";
}

</script> 
<body>
<br>
	<table width="95%" border="0" cellpadding="0" cellspacing="0" class="top_list">
      <tr>
        <td class="top_list_td icons_a2">　　您现在的位置是：会员管理 &gt; 会员列表</td>
      </tr>
    </table>
    <br>
    <form name="memberForm" method="post" action="?">
    <table width="95%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td class="top_list_td">排序:
          <select name="Compositor" onChange="FromSubmit()" style='cursor: hand'>
            <option value="" <?php if($Compositor=="") echo "selected";?>>默认排序</option>
            <option value="username" <?php if($Compositor=="username") echo "selected";?>>帐号</option>
            <option value="leftmoney" <?php if($Compositor=="leftmoney") echo "selected";?>>可用余额</option>
            <option value="lockmoney" <?php if($Compositor=="lockmoney") echo "selected";?>>冻结金额</option>
            <option value="totalmoney" <?php if($Compositor=="totalmoney") echo "selected";?>>总充值额</option>
            <option value="usedmoney" <?php if($Compositor=="usedmoney") echo "selected";?>>总消费额</option>
            <option value="regdate" <?php if($Compositor=="regdate") echo "selected";?>>注册时间</option>
            <option value="lastdate" <?php if($Compositor=="lastdate") echo "selected";?>>最后登陆</option>
          </select>
          &nbsp;
          <select name="Ascending" onChange="FromSubmit()" style='cursor: hand'>
            <option value="asc" <?php if($Ascending=="asc") echo "selected";?>>由小到大</option>
            <option value="desc" <?php if($Ascending=="desc") echo "selected";?>>由大到小</option>
          </select>&nbsp;&nbsp;类型:
          <select name="FindType" style='cursor: hand'>
            <option value="" <?php if($FindType=="") echo "selected";?>>全部</option>
            <option value="1" <?php if($FindType=="1") echo "selected";?>>代理</option>
            <option value="0" <?php if($FindType=="0") echo "selected";?>>会员</option>
            <option value="2" <?php if($FindType=="2") echo "selected";?>>总代理</option>
          </select>
          &nbsp;状态:
          <select name="zt" style='cursor: hand' id="zt">
            <option value="" <?php if($zt=="") echo "selected";?>>全部</option>
            <option value="0" <?php if($zt=="0") echo "selected";?>>启用</option>
            <option value="1" <?php if($zt=="1") echo "selected";?>>冻结</option>
            <option value="2" <?php if($zt=="2") echo "selected";?>>锁定</option>
                              </select>
          &nbsp;帐号:
          <input type="text" name="FindTxt" maxlength="30" size="10" value="" class="inpa">
          &nbsp;
          <input name="Find_VN" type="submit" class="btnb" value="搜 索" style="position: relative; top: 2px;"></td>
        <td width="100" class="top_list_td"><input name="Add_User" type="button" value="新增会员" class="Font_B" onClick="javascript:window.location='mem_edit.php?act=add';"></td> 
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
          <td class="t_list_caption">◎</td>
          <td class="t_list_caption">类型</td>
            <td class="t_list_caption">余额</td>
          <td class="t_list_caption">总充值</td>
          <td class="t_list_caption">总消费</td>
          <td class="t_list_caption">开户时间</td>
            <td class="t_list_caption">最后登录</td>
            <td class="t_list_caption">登录次数</td>
            <td class="t_list_caption">状态</td>
            <td class="t_list_caption">充值</td>
            <td class="t_list_caption">银行卡</td>
          <td class="t_list_caption">操作</td>
      </tr>
        <?php
		while ($row = mysql_fetch_array($rsnewslist))
		{
		?>
            <tr class="t_list_tr_0" onMouseOver="this.style.backgroundColor='#FFFFA2'" onMouseOut="this.style.backgroundColor=''">
                <td><input name="lids[]" type="checkbox" id="checkbox2" value="<?=$row['id']?>"></td> 
                <td><?=$row['id']?></td>
                <td><a href="?UP_ID=<?=$row['username']?>"><?=$row['username']?></a></td>
                <td><img src='images/USER_<?php echo Get_online($row['username'])?>.gif'></td>
                <td><?=$jb[$row['level']]?></td>
                <td><?=$row['leftmoney']?></td>
                <td><?=$row['totalmoney']?></td>
                <td><?=$row['usedmoney']?></td>
                <td><?=date("Y-m-d",strtotime($row['regdate']))?></td>
                <td><?php if($row['lastdate']==""){echo "------";}else{echo date("Y-m-d",strtotime($row['lastdate']));}?></td>
                <td><?=$row['lognums']?></td>
                <td><?php if($row['zt']==0){echo "<span class='Font_G'>正常</span>";}else if($row['zt']==1){echo "<span class='Font_B'>冻结</span>";}else if($row['zt']==2){echo "<span class='Font_Y'>锁定</span>";}else if($row['zt']==3){echo "<span class='Font_R'>清理</span>";}?></td>
                <td><?php if($row['czzt']==1){echo "<a href=?act=czzt&uid=".$row['id']."&czzt=0><span class='Font_R'>允许</span></a>";}else{echo "<a href=?act=czzt&uid=".$row['id']."&czzt=1><span class='Font_G'>关闭</span></a>";}?></td>
                <td><?php if($row['cardlock']==1){echo "<a href=?act=bank&uid=".$row['id']."&cardlock=0><span class='Font_R'>锁定</span></a>";}else{echo "<a href=?act=bank&uid=".$row['id']."&cardlock=1><span class='Font_G'>正常</span></a>";}?></td>
              <td> <a href="javascript:void(0);" onClick="open_Estate('<?=$row['id']?>','<?=$row['zt']?>',event)">状态</a> <a href="mem_edit.php?act=edit&uid=<?=$row['id']?>">编辑</a> <a href="account_record.php?uname=<?=$row['username']?>">帐变</a> <a href="mem_card.php?uname=<?=$row['username']?>">银行</a> <a href="message_edit.php?act=add&uid=<?=$row['username']?>">发信</a> <a href="mem_logs.php?uname=<?=$row['username']?>">日志</a> <a href="mem_amend.php?uname=<?=$row['username']?>">操作</a> <a href="?act=del&id=<?=$row['id']?>" onClick="return confirm('确认要删除吗?');">删除</a></td>
  </tr>
 		<?php
		}
		?>

      <tr>
            <td colspan="15" class="t_list_bottom"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="170" height="35">　选择：<a href="javascript:select()">全选</a> - <a href="javascript:fanselect()">反选</a> - <a href="javascript:noselect()">不选</a></td>
                <td width="260"><input name="button" type="submit" class="btnc" onClick="return confirm('确认要删除吗?');" value="删除" id="button" />
                <input name="button" type="submit" class="btnc" onClick="return confirm('确认要锁定吗?');" value="锁定" id="button" />
                <input name="button" type="submit" class="btnc" onClick="return confirm('确认要冻结吗?');" value="冻结" id="button" />
                <input name="button" type="submit" class="btnc" onClick="return confirm('确认要启用吗?');" value="正常" id="button" /></td>
                <td><div style='text-align:right;'>总计  <?=$total?> 条数据,  共 <?=$lastpg?> 页 , 当前第 <?=$page?> 页  |  <?php if($page>1){?> <A HREF="?<?=$urls?>&page=1">首页</A> <A HREF="?<?=$urls?>&page=<?=$page-1?>">上页</A><?php }?><?php for($i=$p1;$i<=$p2;$i++){
		if($i==$page){?> <span class='Font_R'><?=$i?></span> <?php }else{?> <A HREF="?<?=$urls?>&page=<?=$i?>"><?=$i?></A> <?php }}?><?php if($page!=$lastpg){?> <A HREF="?<?=$urls?>&page=<?=$page+1?>">下页</A> <A HREF="?<?=$urls?>&page=<?=$lastpg?>">尾页</A> <?php }?> | 转至 <SCRIPT LANGUAGE="JAVASCRIPT">function keepKeyNum(obj,evt){var  k=window.event?evt.keyCode:evt.which; if( k==13 ){ goPage(obj.value);return false; }} function goPage( iPage ){ if( !isNaN(parseInt(iPage)) ) { if(iPage< 0 ){iPage=0;} window.location.href="?<?=$urls?>&page="+iPage;}}</SCRIPT><INPUT onKeyPress="return keepKeyNum(this,event);" TYPE="TEXT" ID="iGotoPage" NAME="iGotoPage" size="3"> 页  &nbsp;<BUTTON onClick="javascript:goPage( document.getElementById('iGotoPage').value );return false;">GO</BUTTON></div></td>
              </tr>
            </table></td>
      </tr>
</table>
</form>
<div id="estate_window" style="display: none;position:absolute; background-color: #FFFF00">
<table width="180" border="0" cellspacing="1" cellpadding="0" class="t_list">
  <tr>
    <td class="t_list_caption"><strong>帐戶状态</strong></td>
  </tr>
  <tr class="t_list_tr_0">
    <td><input name="t_user_Estate" type="radio" onClick="stopOnClick('0')" value="0">
    正常&nbsp;<input name="t_user_Estate" type="radio" onClick="stopOnClick('1')" value="1">冻结&nbsp;<input name="t_user_Estate" type="radio" onClick="stopOnClick('2')" value="2">锁定</td><input name="Stop_UserID" type="hidden">
  </tr>
</table>
</div>
</body>
</html> 