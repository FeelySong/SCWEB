<?php
session_start();
error_reporting(0);

require_once 'conn.php';

if($_GET['act']=="edit"){
	$sql="select * from ssc_banks where id= ".$_GET['id'];
	$query = mysql_query($sql);
	$rs = mysql_fetch_array($query);
} 

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
        <td class="top_list_td icons_a1">　　您现在的位置是：嘟嘟游戏 &gt; <?php if($_GET['act']=="edit"){echo "编辑银行";}else{echo "新增银行";}?></td>
      </tr>
    </table>
<br>
<form name="sonMemberForm" method="post" action="banks.php?act=<?=$_GET['act']?>&id=<?=$_GET['id']?>" onSubmit="return SubChk()">
<table width="95%" border="1" cellpadding="0" cellspacing="0" bordercolor="#DDDDDD" class="t_list">
    <tr>
        <td width="150" height="40" class="t_Edit_caption">银行名称</td>
        <td class="t_Edit_td"><input name="name" type="text" class="inp2" id="name" onFocus="this.className='inp2a'" onBlur="this.className='inp2';" value="<?=$rs['name']?>" size="70">		</td>
    </tr>
    <tr>
      <td height="40" class="t_Edit_caption">银行网址</td>
      <td class="t_Edit_td"><input name="url" type="text" class="inp2" id="url" onFocus="this.className='inp2a'" onBlur="this.className='inp2';" value="<?=$rs['url']?>" size="70"></td>
    </tr>
    <tr>
      <td height="40" class="t_Edit_caption">支行名称</td>
      <td class="t_Edit_td"><input name="branch" type="text" class="inp2" id="branch" onFocus="this.className='inp2a'" onBlur="this.className='inp2';" value="<?=$rs['branch']?>" size="70"></td>
    </tr>
    <tr>
      <td height="40" class="t_Edit_caption">收款帐号</td>
      <td class="t_Edit_td"><input name="account" type="text" class="inp2" id="account" onFocus="this.className='inp2a'" onBlur="this.className='inp2';" value="<?=$rs['account']?>" size="40"></td>
    </tr>
    <tr>
      <td height="40" class="t_Edit_caption">收 款 人</td>
      <td class="t_Edit_td"><input name="uname" type="text" class="inp2" id="uname" onFocus="this.className='inp2a'" onBlur="this.className='inp2';" value="<?=$rs['uname']?>" size="20"></td>
    </tr>
    <tr>
      <td height="40" class="t_Edit_caption">充值最小限额</td>
      <td class="t_Edit_td"><input name="cmin" type="text" class="inp2" id="cmin" onFocus="this.className='inp2a'" onBlur="this.className='inp2';" value="<?=$rs['cmin']?>" size="20"></td>
    </tr>
    <tr>
      <td height="40" class="t_Edit_caption">充值最大限额</td>
      <td class="t_Edit_td"><input name="cmax" type="text" class="inp2" id="cmax" onFocus="this.className='inp2a'" onBlur="this.className='inp2';" value="<?=$rs['cmax']?>" size="20"></td>
    </tr>
    <tr>
      <td height="40" class="t_Edit_caption">充值手续费率</td>
      <td class="t_Edit_td"><input name="crates" type="text" class="inp2" id="crates" onFocus="this.className='inp2a'" onBlur="this.className='inp2';" value="<?=$rs['crates']?>" size="20"> 
        %</td>
    </tr>
    <tr>
      <td height="40" class="t_Edit_caption">补贴充值限额</td>
      <td class="t_Edit_td"><input name="climit" type="text" class="inp2" id="climit" onFocus="this.className='inp2a'" onBlur="this.className='inp2';" value="<?=$rs['climit']?>" size="20"></td>
    </tr>
    <tr>
      <td height="40" class="t_Edit_caption">提款最小限额</td>
      <td class="t_Edit_td"><input name="tmin" type="text" class="inp2" id="tmin" onFocus="this.className='inp2a'" onBlur="this.className='inp2';" value="<?=$rs['tmin']?>" size="20"></td>
    </tr>
    <tr>
      <td height="40" class="t_Edit_caption">提款最大限额</td>
      <td class="t_Edit_td"><input name="tmax" type="text" class="inp2" id="tmax" onFocus="this.className='inp2a'" onBlur="this.className='inp2';" value="<?=$rs['tmax']?>" size="20"></td>
    </tr>
    <tr>
      <td height="40" class="t_Edit_caption">提款手续费率</td>
      <td class="t_Edit_td"><input name="trates" type="text" class="inp2" id="trates" onFocus="this.className='inp2a'" onBlur="this.className='inp2';" value="<?=$rs['trates']?>" size="20">
%</td>
    </tr>
    <tr>
      <td height="40" class="t_Edit_caption">免提款手续费额</td>
      <td class="t_Edit_td"><input name="tlimit" type="text" class="inp2" id="tlimit" onFocus="this.className='inp2a'" onBlur="this.className='inp2';" value="<?=$rs['tlimit']?>" size="20"></td>
    </tr>
    <tr>
      <td height="40" class="t_Edit_caption">银行类型</td>
      <td class="t_Edit_td"><label>
        <select name="types" id="types">
          <option value="1" <?php if($rs['types']==1 || $rs['types']==""){echo "selected";}?>>自动充值</option>
          <option value="2" <?php if($rs['types']==2){echo "selected";}?>>手动充值</option>
        </select>
      </label></td>
    </tr>
  
  <tr>
    <td height="40" class="t_Edit_caption">状　　态</td>
    <td class="t_Edit_td"><label>
      <input name="zt" type="checkbox" id="zt" value="1" <?php if($rs['zt']==1){echo "checked";}?>>
    </label></td>
  </tr>
  </table>
<table width="500">
        <tr align="center">
            <td><br>
<input type="submit" name="Submit" value="確 定" class="btn2" onMouseOver="this.className='btn2a'" onMouseOut="this.className='btn2'" />　<input type="button" name="cancel" value="取 消" class="btn2" onClick="javascript:history.go(-1)" onMouseOver="this.className='btn2a'" onMouseOut="this.className='btn2'" />
            </td>
        </tr>
    </table>
</form>

</body>
</html>