<?php
session_start();
error_reporting(0);

require_once 'conn.php';
$uid=$_GET['uid'];
if($_GET['act']=="edit"){
	$sql="select * from ssc_message where id= ".$_GET['id'];
	$query = mysql_query($sql);
	$rs = mysql_fetch_array($query);
	$username_mem = $rs['username'];
	$topic = $rs['topic'];
	$content = $rs['content'];
	$types = $rs['types'];
	$lev = $rs['lev'];
}else{
	if($uid!=""){$username_mem=$uid;}
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
        <td class="top_list_td icons_a1">　　您现在的位置是：信息管理 &gt; <?php if($_GET['act']=="edit"){echo "编辑消息";}else{echo "新增消息";}?></td>
      </tr>
    </table>
<br>
<form name="sonMemberForm" method="post" action="message.php?act=<?=$_GET['act']?>&id=<?=$_GET['id']?>" onSubmit="return SubChk()">
<table width="95%" border="1" cellpadding="0" cellspacing="0" bordercolor="#DDDDDD" class="t_list">
    <tr>
        <td width="150" height="40" class="t_Edit_caption">接收者</td>
        <td class="t_Edit_td"><input name="username" type="text" class="inp2" onFocus="this.className='inp2a'" onBlur="this.className='inp2';" value="<?=$username_mem?>" size="70"></td>
    </tr>
    <tr>
      <td height="40" class="t_Edit_caption">消息标题</td>
      <td class="t_Edit_td"><input name="topic" type="text" class="inp2" id="topic" onFocus="this.className='inp2a'" onBlur="this.className='inp2';" value="<?=$topic?>" size="70"></td>
    </tr>
  <tr>
    <td height="430" class="t_Edit_caption">消息內容</td>
    <td class="t_Edit_td"><input type="hidden" name="content1" value="<?=$content?>"><IFRAME ID="eWebEditor1" src="eWebEditor/ewebeditor.htm?id=content1&style=light" frameborder="0" scrolling="no" width="600" height="400"></IFRAME></td>
  </tr>
  <tr>
    <td height="40" class="t_Edit_caption">消息类型</td>
    <td class="t_Edit_td"><label>
      <select name="types" id="types">
        <option value="系统消息" <?php if($types=="系统消息"){echo "selected";}?>>系统消息</option>
        <option value="充提消息" <?php if($types=="充提消息"){echo "selected";}?>>充提消息</option>
      </select>
    </label></td>
  </tr>
  </table>
<table width="500">
        <tr align="center">
            <td><br>
<input type="submit" name="Submit" value="確 定" class="btn2" onClick="return confirm('确认要发布吗?');" onMouseOver="this.className='btn2a'" onMouseOut="this.className='btn2'" />　<input type="button" name="cancel" value="取 消" class="btn2" onClick="javascript:history.go(-1)" onMouseOver="this.className='btn2a'" onMouseOut="this.className='btn2'" />
            </td>
        </tr>
    </table>
</form>

</body>
</html>