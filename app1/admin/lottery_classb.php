<?php
session_start();
error_reporting(0);
require_once 'conn.php';
$cid=$_GET['id'];
if($cid==""){
	$cid="1";
}

$act=$_GET['act'];
if($act=="edit"){
	$jmoney="";
	for($ii=0;$ii<$_POST['scount'];$ii++){
		$jmoney=$jmoney.$_POST['jmoney_'.$ii];
		if($ii!=$_POST['scount']-1){
			$jmoney=$jmoney.";";
		}
	}
	$sql="update ssc_classb set jmoney = '".$jmoney."', rebate = '".$_POST['rebate']."', minbei = '".$_POST['minbei']."', maxbei = '".$_POST['maxbei']."', maxzhu = '".$_POST['maxzhu']."', zt = '".$_POST['zt']."' where id ='".$_POST['sid']."'";
//	echo $sql;
	if (!mysql_query($sql)){
	  	die('Error: ' . mysql_error());
	}
	echo "<script language=javascript>window.location='?id=".$cid."';</script>";
	exit;
}

$sql="select * from ssc_classb where cid='".$cid."' order by id asc";
$rsnewslist = mysql_query($sql) or  die("数据库修改出错!!!!".mysql_error());;
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
        <td class="top_list_td icons_a1">　　您现在的位置是：嘟嘟游戏 &gt; 玩法设置</td>
      </tr>
    </table>
  	<br />
  	<table width="95%" border="0" cellspacing="0" cellpadding="0" class="nav_list">
    	<tr>
      		<td class="nav_list_td"><div class="tabs">	
			<ul><li <?php if($cid==1){echo "class='select'";}?>><a href="?id=1">重庆</a></li><li <?php if($cid==2){echo "class='select'";}?>><a href="?id=2">黑龙江</a></li><li <?php if($cid==3){echo "class='select'";}?>><a href="?id=3">新疆</a></li><li <?php if($cid==4){echo "class='select'";}?>><a href="?id=4">江西</a></li><li <?php if($cid==5){echo "class='select'";}?>><a href="?id=5">时时乐</a></li><li <?php if($cid==6){echo "class='select'";}?>><a href="?id=6">十一运</a></li><li <?php if($cid==7){echo "class='select'";}?>><a href="?id=7">多乐彩</a></li><li <?php if($cid==8){echo "class='select'";}?>><a href="?id=8">广东11选5</a></li><li <?php if($cid==9){echo "class='select'";}?>><a href="?id=9">3D</a></li><li <?php if($cid==10){echo "class='select'";}?>><a href="?id=10">排列3-5</a></li><li <?php if($cid==11){echo "class='select'";}?>><a href="?id=11">重庆11选5</a></li></ul></div></td>
    	</tr>
  	</table>
  <br />
<table width="95%" border="1" cellpadding="0" cellspacing="0" bordercolor="#DDDDDD" class="t_list">
		  	<tr>
				<td width="60" class="t_list_caption">序号</td>
				<td width="100" class="t_list_caption">彩种</td>
			  <td width="100" class="t_list_caption">玩法</td>
			  <td class="t_list_caption">奖级</td>
			  <td width="80" class="t_list_caption">奖金</td>
				<td width="80" class="t_list_caption">返点</td>
		        <td width="80" class="t_list_caption">最小倍数</td>
		        <td width="80" class="t_list_caption">最大倍数</td>
	            <td width="80" class="t_list_caption">最大注数</td>
              <td width="50" class="t_list_caption">状态</td>
		      <td width="80" class="t_list_caption">操作</td>
		  </tr>
			<?php 
			$i=0;
			while ($row = mysql_fetch_array($rsnewslist)){
			$stra=explode(";",$row['jmoney']);
			$strc=explode(";",$row['jname']);
			?>
            <form action="?act=edit&id=<?=$cid?>" method="post" name="form1" id="form1">
			<tr class="t_list_tr_<?=$i%2?>" onMouseOver="this.style.backgroundColor='#E8F1FF'" onMouseOut="this.style.backgroundColor=''">
				<td height="25"  align="center"><input type="hidden" name="sid" value="<?=$row['id']?>" /><input type="hidden" name="scount" value="<?=count($stra)?>"><?=$row['mid']?></td>
				<td align="center"><?=$row['cname']?></td>
				<td align="center"><?=$row['name']?></td>
				<td align="center">
                	<table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <?php for($ii=0;$ii<count($stra);$ii++){?>
                  		<tr>
                    		<td height=30 align="center"><?=$strc[$ii]?></td>
                  		</tr>
                    <?php }?>
                	</table>			    </td>
				<td align="center">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <?php for($ii=0;$ii<count($stra);$ii++){?>
                  		<tr>
                    		<td height=30 align="center"><input type="text" name="jmoney_<?=$ii?>" maxlength="15" size="9" value="<?=$stra[$ii]?>" onkeypress="alphaOnly(event);" onblur="this.className='inp1';" class="inp1" onfocus="this.className='inp1a'" ></td>
                  		</tr>
                    <?php }?>
                	</table>                </td>
				<td align="center"><input type="text" name="rebate" maxlength="15" size="8" value="<?=$row['rebate']?>" onkeypress="alphaOnly(event);" onblur="this.className='inp1';" class="inp1" onfocus="this.className='inp1a'" ></td>
				<td align="center"><input name="minbei" type="text" class="inp1" id="minbei" onfocus="this.className='inp1a'" onblur="this.className='inp1';" onkeypress="alphaOnly(event);" value="<?=$row['minbei']?>" size="8" maxlength="15" /></td>
				<td align="center"><input name="maxbei" type="text" class="inp1" id="maxbei" onfocus="this.className='inp1a'" onblur="this.className='inp1';" onkeypress="alphaOnly(event);" value="<?=$row['maxbei']?>" size="8" maxlength="15" /></td>
				<td align="center"><input name="maxzhu" type="text" class="inp1" id="maxzhu" onfocus="this.className='inp1a'" onblur="this.className='inp1';" onkeypress="alphaOnly(event);" value="<?=$row['maxzhu']?>" size="8" maxlength="15" /></td>
				<td align="center"><input name="zt" type="checkbox" value="1" <?php if($row['zt']==1){echo "checked";}?>/></td>
				<td align="center"><input type="submit" class="but1" value="修改" /></td>
		  	</tr>
			</form>
			<?php 
			$i=$i+1;
			}
			?>
  </table>
</div>
</body>
</html>
