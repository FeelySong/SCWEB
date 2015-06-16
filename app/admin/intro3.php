<?php
session_start();
error_reporting(0);

require_once 'conn.php';

if (strpos($_SESSION['admin_flag'],'c3') ){}else{ 
	echo "<script language=javascript>alert('对不起，您无此权限！');window.history.go(-1);</script>";
exit;}

if($_GET['act']=="edit"){
	$sql="update ssc_intro set content='".$_POST['content']."' where id='3' ";
	$exe=mysql_query($sql) or  die("数据库修改出错6!!!".mysql_error());
	echo "<script>alert('修改成功！');window.location.href='?';</script>"; 
	exit;
}
	$sql="select * from ssc_intro where id='3' ";
	$query = mysql_query($sql);
	$rs = mysql_fetch_array($query);
	$cont = $rs['content'];

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
        <td class="top_list_td icons_a12">　　您现在的位置是：帮助中心 &gt; 常见问题</td>
      </tr>
    </table>
<br>
<form name="sonMemberForm" method="post" action="intro3.php?act=edit" onSubmit="return SubChk()">
<table width="95%" border="1" cellpadding="0" cellspacing="0" bordercolor="#DDDDDD" class="t_list">
    <tr>
        <td height="40" class="t_Edit_caption"><textarea name="content" cols="150" rows="60" id="content"><?=$cont?></textarea></td>
    </tr>
  </table>
<table width="500">
        <tr align="center">
            <td><br>
<input type="submit" name="Submit" value="確 定" class="btn2" onMouseOver="this.className='btn2a'" onMouseOut="this.className='btn2'"  onClick="return confirm('确认要修改吗?');"/>　<input type="button" name="cancel" value="取 消" class="btn2" onClick="javascript:history.go(-1)" onMouseOver="this.className='btn2a'" onMouseOut="this.className='btn2'" />
            </td>
        </tr>
    </table>
</form>

</body>
</html>