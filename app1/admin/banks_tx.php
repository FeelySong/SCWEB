<?php
session_start();
error_reporting(0);
require_once 'conn.php';

if (strpos($_SESSION['admin_flag'],'94') ){}else{ 
	echo "<script language=javascript>alert('对不起，您无此权限！');window.history.go(-1);</script>";
exit;}

if($_GET['act']=="edit"){
	$sql="update ssc_config set txmin='".$_POST['txmin']."',txmax='".$_POST['txmax']."',txrates='".$_POST['txrates']."',txlimit='".$_POST['txlimit']."',txnums='".$_POST['txnums']."',timemin='".$_POST['timemin']."',timemax='".$_POST['timemax']."',txhours='".$_POST['txhours']."',txsxmax='".$_POST['txsxmax']."' where id='1'";
//	echo $sql;
	$exe=mysql_query($sql) or  die("数据库修改出错2");
	echo "<script>alert('操作成功！');window.location.href='banks_tx.php';</script>"; 
	exit;
} 
	$sql="select * from ssc_config";
	$query = mysql_query($sql);
	$rs = mysql_fetch_array($query);

?>
<html>
<head>
<title></title> 
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
        <td class="top_list_td icons_a9">　　您现在的位置是：系统管理 &gt; 提现设置</td>
      </tr>
    </table>
<br>
<form name="sonMemberForm" method="post" action="?act=edit" onSubmit="return SubChk()">
<table width="95%" border="1" cellpadding="0" cellspacing="0" bordercolor="#DDDDDD" class="t_list">
    <tr>
        <td width="150" height="40" class="t_Edit_caption">提款最小限额</td>
        <td class="t_Edit_td"><input name="txmin" type="text" class="inp2" id="txmin" onFocus="this.className='inp2a'" onBlur="this.className='inp2';" value="<?=$rs['txmin']?>" size="20">		</td>
    </tr>
    <tr>
      <td height="40" class="t_Edit_caption">提款最大限额</td>
      <td class="t_Edit_td"><input name="txmax" type="text" class="inp2" id="txmax" onFocus="this.className='inp2a'" onBlur="this.className='inp2';" value="<?=$rs['txmax']?>" size="20"></td>
    </tr>
    <tr>
      <td height="40" class="t_Edit_caption">提款手续费率</td>
      <td class="t_Edit_td"><input name="txrates" type="text" class="inp2" id="txrates" onFocus="this.className='inp2a'" onBlur="this.className='inp2';" value="<?=$rs['txrates']?>" size="20">‰</td>
    </tr>
    <tr>
      <td height="40" class="t_Edit_caption">免提款手续费额</td>
      <td class="t_Edit_td"><input name="txlimit" type="text" class="inp2" id="txlimit" onFocus="this.className='inp2a'" onBlur="this.className='inp2';" value="<?=$rs['txlimit']?>" size="20"></td>
    </tr>
    <tr>
      <td height="40" class="t_Edit_caption">每日提现次数</td>
      <td class="t_Edit_td"><input name="txnums" type="text" class="inp2" id="txnums" onFocus="this.className='inp2a'" onBlur="this.className='inp2';" value="<?=$rs['txnums']?>" size="20"></td>
    </tr>
    <tr>
      <td height="40" class="t_Edit_caption">提现时间起</td>
      <td class="t_Edit_td"><input name="timemin" type="text" class="inp2" id="timemin" onFocus="this.className='inp2a'" onBlur="this.className='inp2';" value="<?=$rs['timemin']?>" size="20"></td>
    </tr>
    <tr>
      <td height="40" class="t_Edit_caption">提现时间止</td>
      <td class="t_Edit_td"><input name="timemax" type="text" class="inp2" id="timemax" onFocus="this.className='inp2a'" onBlur="this.className='inp2';" value="<?=$rs['timemax']?>" size="20"></td>
    </tr>
    <tr>
      <td height="40" class="t_Edit_caption">最高手续费</td>
      <td class="t_Edit_td"><input name="txsxmax" type="text" class="inp2" id="txsxmax" onFocus="this.className='inp2a'" onBlur="this.className='inp2';" value="<?=$rs['txsxmax']?>" size="20"></td>
    </tr>
    <tr>
      <td height="40" class="t_Edit_caption">新卡绑定限提时间</td>
      <td class="t_Edit_td"><input name="txhours" type="text" class="inp2" id="txhours" onFocus="this.className='inp2a'" onBlur="this.className='inp2';" value="<?=$rs['txhours']?>" size="20"></td>
    </tr>
  </table>
<table width="500">
        <tr align="center">
            <td><br>
<input type="submit" name="Submit" value="確 定" class="btn2" onClick="return confirm('确认要修改吗?');" onMouseOver="this.className='btn2a'" onMouseOut="this.className='btn2'" />　<input type="button" name="cancel" value="取 消" class="btn2" onClick="javascript:history.go(-1)" onMouseOver="this.className='btn2a'" onMouseOut="this.className='btn2'" />
            </td>
        </tr>
    </table>
</form>

</body>
</html>