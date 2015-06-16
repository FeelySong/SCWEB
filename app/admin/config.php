<?php
session_start();
error_reporting(0);

require_once 'conn.php';

if (strpos($_SESSION['admin_flag'],'91') ){}else{ 
	echo "<script language=javascript>alert('对不起，您无此权限！');window.history.go(-1);</script>";
exit;}

if($_GET['act']=="edit"){
	$sql="update ssc_config set webname='".$_POST['webname']."',rurl='".$_POST['rurl']."',cdrates='".$_POST['cdrates']."',cdnums='".$_POST['cdnums']."',counts='".$_POST['counts']."',stopstart='".$_POST['stopstart']."',stopend='".$_POST['stopend']."',zt='".$_POST['zt']."',ht='".$_POST['ht']."',my18='".$_POST['my18']."',jsys_mode='".$_POST['jsys_mode']."' where id='1'";
//	echo $sql;
	$exe=mysql_query($sql) or  die("数据库修改出错2".mysql_error());
	echo "<script>alert('修改成功！');window.location.href='config.php';</script>"; 
	exit;
} 
	$sql="select * from ssc_config";
	$query = mysql_query($sql);
	$rs = mysql_fetch_array($query);

?>
<html>
<head>
<title></title>
<SCRIPT type="text/javascript">
if (top.location == self.location) top.location.href = "index.php"; </script> 
<script type="text/javascript" language="javascript">

function SubChk(){

//	if(document.all.adcontent.value.length < 1){
//		alert("请输入公告内容！");
//		document.all.VIP_Name.focus();
//		return false;
//	}
	return true;
	    
}

</script>

<link href="css/index.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>
<body>
<br />
	<table width="95%" border="0" cellpadding="0" cellspacing="0" class="top_list">
      <tr>
        <td class="top_list_td icons_a9">　　您现在的位置是：系统管理 &gt; 系统设置</td>
      </tr>
    </table>
<br>
<form name="sonMemberForm" method="post" action="?act=edit" onSubmit="return SubChk()">
<table width="95%" border="1" cellpadding="0" cellspacing="0" bordercolor="#DDDDDD" class="t_list">
    <tr>
        <td width="150" height="40" class="t_Edit_caption">网站名称</td>
        <td class="t_Edit_td"><input name="webname" type="text" class="inp2" id="webname" onFocus="this.className='inp2a'" onBlur="this.className='inp2';" value="<?=$rs['webname']?>" size="70">		</td>
    </tr>
    <tr>
      <td height="40" class="t_Edit_caption">跳转地址</td>
      <td class="t_Edit_td"><input name="rurl" type="text" class="inp2" id="rurl" onFocus="this.className='inp2a'" onBlur="this.className='inp2';" value="<?=$rs['rurl']?>" size="70">
      <span class="Font_R">用户名不对或锁定时的跳转地址</span></td>
    </tr>
    <tr>
      <td height="40" class="t_Edit_caption">用户登陆</td>
      <td class="t_Edit_td"><input name="zt" type="radio" id="radio" value="1" <?php if($rs['zt']==1){echo "checked";}?>>
        开启  <input type="radio" name="zt" id="radio2" value="0" <?php if($rs['zt']==0){echo "checked";}?>> 
        关闭</td>
    </tr>
    
    <tr>
      <td height="40" class="t_Edit_caption">管理员登陆</td>
      <td class="t_Edit_td"><input name="ht" type="radio" id="radio3" value="1" <?php if($rs['ht']==1){echo "checked";}?>>
        开启
          <input type="radio" name="ht" id="radio4" value="0" <?php if($rs['ht']==0){echo "checked";}?>>
      关闭</td>
    </tr>
    
    <tr>
      <td height="40" class="t_Edit_caption">撤单手续费率</td>
      <td class="t_Edit_td"><input name="cdrates" type="text" class="inp2" id="cdrates" onFocus="this.className='inp2a'" onBlur="this.className='inp2';" value="<?=$rs['cdrates']?>" size="20">%</td>
    </tr>
    <tr>
      <td height="40" class="t_Edit_caption">免费撤单笔数</td>
      <td class="t_Edit_td"><input name="cdnums" type="text" class="inp2" id="cdnums" onFocus="this.className='inp2a'" onBlur="this.className='inp2';" value="<?=$rs['cdnums']?>" size="20">
      <span class="Font_R">每天免费撤单笔数</span></td>
    </tr>
    <tr>
      <td height="40" class="t_Edit_caption">春节停开起</td>
      <td class="t_Edit_td"><input name="stopstart" type="text" class="inp2" id="stopstart" onFocus="this.className='inp2a'" onBlur="this.className='inp2';" value="<?=$rs['stopstart']?>" size="20"></td>
    </tr>
    <tr>
      <td height="40" class="t_Edit_caption">春节停开止</td>
      <td class="t_Edit_td"><span class="Font_R">
        <input name="stopend" type="text" class="inp2" id="stopend" onFocus="this.className='inp2a'" onBlur="this.className='inp2';" value="<?=$rs['stopend']?>" size="20">
</span></td>
    </tr>
    
    <tr>
      <td height="40" class="t_Edit_caption">MY18充值监控</td>
      <td class="t_Edit_td"><input name="my18" type="radio" id="radio5" value="1" <?php if($rs['my18']==1){echo "checked";}?>>
开启
  <input type="radio" name="my18" id="radio6" value="0" <?php if($rs['my18']==0){echo "checked";}?>>
关闭　<span class="Font_R">如果您不使用MY18，请不要开启，这将会额外的开启一个后台进程，增加不必要的服务器负担。</span></td>
    </tr>
    <tr>
      <td height="40" class="t_Edit_caption">金鲨银鲨开奖模式</td>
      <td class="t_Edit_td"><input name="jsys_mode" type="radio" id="radio7" value="1" <?php if($rs['jsys_mode']==1){echo "checked";}?>>
盈利
  <input type="radio" name="jsys_mode" id="radio7" value="0" <?php if($rs['jsys_mode']==0){echo "checked";}?>>
随机　</td>
    </tr>    
    <tr>
      <td height="100" class="t_Edit_caption">统计代码</td>
      <td class="t_Edit_td"><textarea name="counts" cols="60" rows="6" id="counts"><?=$rs['counts']?></textarea></td>
    </tr>
  </table>
<table width="500">
        <tr align="center">
            <td><br>
<input type="submit" name="Submit" value="確 定" class="btn2" onMouseOver="this.className='btn2a'" onMouseOut="this.className='btn2'"  onClick="return confirm('确认要保存吗?');"/>　<input type="button" name="cancel" value="取 消" class="btn2" onClick="javascript:history.go(-1)" onMouseOver="this.className='btn2a'" onMouseOut="this.className='btn2'" />
            </td>
        </tr>
    </table>
</form>

</body>
</html>