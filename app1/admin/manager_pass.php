<?php
session_start();
error_reporting(0);

require_once 'conn.php';

if($_GET['act']=="edit"){
	if($_POST['password']!=""){
		$sql="update ssc_manager set password='".md5($_POST['password'])."' where username='".$_SESSION["ausername"]."'";
		$exe=mysql_query($sql) or  die("数据库修改出错2");
		amend("修改用户密码 ".$_SESSION["ausername"]);
	}
	echo "<script>window.location.href='info.php';</script>"; 
	exit;
}
?>
<html>
<head>
<title></title> 
<script type="text/javascript" language="javascript">

function SubChk(){

	if(document.all.topic.value.length < 1){
		alert("请输入公告名称！");
		document.all.topic.focus();
		return false;
	}
	return true;
	    
}

</script>

<link href="css/index.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>
<body>
<br />
	<table width="95%" border="0" cellpadding="0" cellspacing="0" class="top_list">
      <tr>
        <td class="top_list_td icons_a10">　　您现在的位置是：权限管理 &gt; 修改密码</td>
      </tr>
    </table>
<br>
<form name="sonMemberForm" method="post" action="?act=edit" onSubmit="return SubChk()">
<table width="95%" border="1" cellpadding="0" cellspacing="0" bordercolor="#DDDDDD" class="t_list">
    <tr>
        <td width="150" height="40" class="t_Edit_caption">用户名</td>
        <td class="t_Edit_td"><?=$_SESSION["ausername"]?></td>
    </tr>
    <tr>
      <td height="40" class="t_Edit_caption">密码</td>
      <td class="t_Edit_td"><input name="password" type="password" class="inp2" id="password" onFocus="this.className='inp2a'" onBlur="this.className='inp2';" value="" size="70"></td>
    </tr>
  </table>
<table width="500">
        <tr align="center">
            <td><br>
<input type="submit" name="Submit" value="確 定" class="btn2" onMouseOver="this.className='btn2a'" onMouseOut="this.className='btn2'" onClick="return confirm('确认要保存吗?');" />　<input type="button" name="cancel" value="取 消" class="btn2" onClick="javascript:history.go(-1)" onMouseOver="this.className='btn2a'" onMouseOut="this.className='btn2'" />
            </td>
        </tr>
    </table>
</form>

</body>
</html>