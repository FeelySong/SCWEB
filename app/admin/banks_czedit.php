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
        <td class="top_list_td icons_a9">　　您现在的位置是：系统管理 &gt; <?php if($_GET['act']=="edit"){echo "编辑银行充值信息";}?></td>
      </tr>
    </table>
<br>
<form name="sonMemberForm" method="post" action="banks_cz.php?act=<?=$_GET['act']?>&id=<?=$_GET['id']?>" onSubmit="return SubChk()">
<table width="95%" border="1" cellpadding="0" cellspacing="0" bordercolor="#DDDDDD" class="t_list">
    <tr>
        <td width="150" height="40" class="t_Edit_caption">银行名称</td>
        <td class="t_Edit_td"><?=$rs['name']?></td>
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
      <td height="40" class="t_Edit_caption">补充值手续费额</td>
      <td class="t_Edit_td"><input name="climit" type="text" class="inp2" id="climit" onFocus="this.className='inp2a'" onBlur="this.className='inp2';" value="<?=$rs['climit']?>" size="20"></td>
    </tr>
    <tr>
      <td height="40" class="t_Edit_caption">充值类型</td>
      <td class="t_Edit_td"><label>
        <select name="types" id="types">
          <option value="1" <?php if($rs['types']==1 || $rs['types']==""){echo "selected";}?>>自动充值</option>
          <option value="2" <?php if($rs['types']==2){echo "selected";}?>>手动充值</option>
        </select>
      </label></td>
    </tr>
    <tr>
      <td height="40" class="t_Edit_caption">充值时间起</td>
      <td class="t_Edit_td"><input name="cztimemin" type="text" class="inp2" id="cztimemin" onFocus="this.className='inp2a'" onBlur="this.className='inp2';" value="<?=$rs['cztimemin']?>" size="20"></td>
    </tr>
    <tr>
      <td height="40" class="t_Edit_caption">充值时间止</td>
      <td class="t_Edit_td"><input name="cztimemax" type="text" class="inp2" id="cztimemax" onFocus="this.className='inp2a'" onBlur="this.className='inp2';" value="<?=$rs['cztimemax']?>" size="20"></td>
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