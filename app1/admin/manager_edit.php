<?php
session_start();
error_reporting(0);

require_once 'conn.php';

if (strpos($_SESSION['admin_flag'],'a1') ){}else{ 
	echo "<script language=javascript>alert('对不起，您无此权限！');window.history.go(-1);</script>";
exit;}

$uid=$_GET['uid'];
if($_GET['act']=="edit"){
	$sql="select * from ssc_manager where id= ".$_GET['id'];
	$query = mysql_query($sql);
	$rs = mysql_fetch_array($query);
	$username_mem = $rs['username'];
	$name = $rs['name'];
	$department = $rs['department'];
	$flag = $rs['qx'];
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
var checkall=document.getElementsByName("flag[]");  
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
</script>

<link href="css/index.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<br />
	<table width="95%" border="0" cellpadding="0" cellspacing="0" class="top_list">
      <tr>
        <td class="top_list_td icons_a10">　　您现在的位置是：权限管理 &gt; <?php if($_GET['act']=="edit"){echo "修改密码";}else{echo "新增管理员";}?></td>
      </tr>
    </table>
<br>
<form name="sonMemberForm" method="post" action="manager.php?act=<?=$_GET['act']?>&id=<?=$_GET['id']?>" onSubmit="return SubChk()">
<table width="95%" border="1" cellpadding="0" cellspacing="0" bordercolor="#DDDDDD" class="t_list">
    <tr>
        <td height="40" colspan="2" class="t_Edit_caption" width="200">用户名</td>
        <td class="t_Edit_td"><?php if($_GET['act']=="edit"){echo $username_mem;}else{?><input name="username" type="text" class="inp2" onFocus="this.className='inp2a'" onBlur="this.className='inp2';" value="<?=$username_mem?>" size="70"><?php }?></td>
    </tr>
    <tr>
      <td height="40" colspan="2" class="t_Edit_caption">密码</td>
      <td class="t_Edit_td"><input name="password" type="password" class="inp2" id="password" onFocus="this.className='inp2a'" onBlur="this.className='inp2';" value="" size="70"></td>
    </tr>
    <tr>
      <td height="40" colspan="2" class="t_Edit_caption">姓名</td>
      <td class="t_Edit_td"><input name="name" type="text" class="inp2" id="name" onFocus="this.className='inp2a'" onBlur="this.className='inp2';" value="<?=$name?>" size="70"></td>
    </tr>
    <tr>
      <td height="40" colspan="2" class="t_Edit_caption">部门</td>
      <td class="t_Edit_td"><input name="department" type="text" class="inp2" id="department" onFocus="this.className='inp2a'" onBlur="this.className='inp2';" value="<?=$department?>" size="70"></td>
    </tr>
    <tr>
      <td width="80" height="40" rowspan="12" class="t_Edit_caption">权限</td>
      <td width="120" class="t_Edit_caption">信息管理</td>
      <td class="t_Edit_td"><input name="flag[]" type="checkbox" value="11" <?php if (strpos($flag,'11')){echo "checked=checked";}?>>
添加公告 
  <input name="flag[]" type="checkbox" value="12" <?php if (strpos($flag,'12')){echo "checked=checked";}?>>
  公告管理 
  <input name="flag[]" type="checkbox" value="13" <?php if (strpos($flag,'13')){echo "checked=checked";}?>>
  会员消息 
  <input name="flag[]" type="checkbox" value="14" <?php if (strpos($flag,'14')){echo "checked=checked";}?>>
  系统消息</td>
    </tr>
    <tr>
      <td class="t_Edit_caption">会员管理</td>
      <td class="t_Edit_td"><input name="flag[]" type="checkbox" value="21" <?php if (strpos($flag,'21')){echo "checked=checked";}?>>
新增会员
  <input name="flag[]" type="checkbox" value="22" <?php if (strpos($flag,'22')){echo "checked=checked";}?>>
会员列表
<input name="flag[]" type="checkbox" value="23" <?php if (strpos($flag,'23')){echo "checked=checked";}?>>
银行信息
<input name="flag[]" type="checkbox" value="24" <?php if (strpos($flag,'24')){echo "checked=checked";}?>>
登陆日志
<input name="flag[]" type="checkbox" value="25" <?php if (strpos($flag,'25')){echo "checked=checked";}?>>
操作日志
<input name="flag[]" type="checkbox" value="26" <?php if (strpos($flag,'26')){echo "checked=checked";}?>>
用户统计
<input name="flag[]" type="checkbox" value="27" <?php if (strpos($flag,'27')){echo "checked=checked";}?>>
用户总计
<input name="flag[]" type="checkbox" value="28" <?php if (strpos($flag,'28')){echo "checked=checked";}?>>
访问统计
<input name="flag[]" type="checkbox" value="29" <?php if (strpos($flag,'29')){echo "checked=checked";}?>> 
在线人员</td>
    </tr>
    <tr>
      <td class="t_Edit_caption">财务管理</td>
      <td class="t_Edit_td"><input name="flag[]" type="checkbox" value="31" <?php if (strpos($flag,'31')){echo "checked=checked";}?>>
手动充值
  <input name="flag[]" type="checkbox" value="32" <?php if (strpos($flag,'32')){echo "checked=checked";}?>>
充值记录
<input name="flag[]" type="checkbox" value="33" <?php if (strpos($flag,'33')){echo "checked=checked";}?>>
提现请求
<input name="flag[]" type="checkbox" value="34" <?php if (strpos($flag,'34')){echo "checked=checked";}?>> 
提现记录</td>
    </tr>
    <tr>
      <td class="t_Edit_caption">业务流水</td>
      <td class="t_Edit_td"><input name="flag[]" type="checkbox" value="41" <?php if (strpos($flag,'41')){echo "checked=checked";}?>>
投注记录
  <input name="flag[]" type="checkbox" value="42" <?php if (strpos($flag,'42')){echo "checked=checked";}?>>
追号记录
<input name="flag[]" type="checkbox" value="43" <?php if (strpos($flag,'43')){echo "checked=checked";}?>>
中奖记录
<input name="flag[]" type="checkbox" value="44" <?php if (strpos($flag,'44')){echo "checked=checked";}?>> 
返点记录
<input name="flag[]" type="checkbox" value="45" <?php if (strpos($flag,'45')){echo "checked=checked";}?>> 
分红记录
<input name="flag[]" type="checkbox" value="46" <?php if (strpos($flag,'46')){echo "checked=checked";}?>> 
帐变明细
<input name="flag[]" type="checkbox" value="47" <?php if (strpos($flag,'47')){echo "checked=checked";}?>> 
可疑数据
<input name="flag[]" type="checkbox" value="48" <?php if (strpos($flag,'48')){echo "checked=checked";}?>> 
开奖检测</td>
    </tr>
    <tr>
      <td class="t_Edit_caption">报表管理</td>
      <td class="t_Edit_td"><input name="flag[]" type="checkbox" value="51" <?php if (strpos($flag,'51')){echo "checked=checked";}?>>
消费报表
  <input name="flag[]" type="checkbox" value="52" <?php if (strpos($flag,'52')){echo "checked=checked";}?>>
结算报表</td>
    </tr>
    <tr>
      <td class="t_Edit_caption">数据统计</td>
      <td class="t_Edit_td"><input name="flag[]" type="checkbox" value="61" <?php if (strpos($flag,'61')){echo "checked=checked";}?>>
盈亏统计
  <input name="flag[]" type="checkbox" value="62" <?php if (strpos($flag,'62')){echo "checked=checked";}?>>
充值统计
<input name="flag[]" type="checkbox" value="63" <?php if (strpos($flag,'63')){echo "checked=checked";}?>>
提现统计
<input name="flag[]" type="checkbox" value="64" <?php if (strpos($flag,'64')){echo "checked=checked";}?>> 
投注统计
<input name="flag[]" type="checkbox" value="65" <?php if (strpos($flag,'65')){echo "checked=checked";}?>> 
中奖统计
<input name="flag[]" type="checkbox" value="66" <?php if (strpos($flag,'66')){echo "checked=checked";}?>> 
返点统计
<input name="flag[]" type="checkbox" value="67" <?php if (strpos($flag,'67')){echo "checked=checked";}?>> 
分红统计
<input name="flag[]" type="checkbox" value="68" <?php if (strpos($flag,'68')){echo "checked=checked";}?>> 
活动统计</td>
    </tr>
    <tr>
      <td class="t_Edit_caption">游戏管理</td>
      <td class="t_Edit_td"><input name="flag[]" type="checkbox" value="71" <?php if (strpos($flag,'71')){echo "checked=checked";}?>>
时间管理
  <input name="flag[]" type="checkbox" value="72" <?php if (strpos($flag,'72')){echo "checked=checked";}?>>
开奖号码
<input name="flag[]" type="checkbox" value="73" <?php if (strpos($flag,'73')){echo "checked=checked";}?>>
接口管理
<input name="flag[]" type="checkbox" value="74" <?php if (strpos($flag,'74')){echo "checked=checked";}?>> 
彩种设置
<input name="flag[]" type="checkbox" value="75" <?php if (strpos($flag,'75')){echo "checked=checked";}?>> 
玩法设置
<input name="flag[]" type="checkbox" value="76" <?php if (strpos($flag,'76')){echo "checked=checked";}?>> 
限倍管理
<input name="flag[]" type="checkbox" value="77" <?php if (strpos($flag,'77')){echo "checked=checked";}?>> 
限注管理</td>
    </tr>
    <tr>
      <td class="t_Edit_caption">奖金管理</td>
      <td class="t_Edit_td"><input name="flag[]" type="checkbox" value="81" <?php if (strpos($flag,'81')){echo "checked=checked";}?>>
奖金设置
  <input name="flag[]" type="checkbox" value="82" <?php if (strpos($flag,'82')){echo "checked=checked";}?>>
返点设置</td>
    </tr>
    <tr>
      <td class="t_Edit_caption">系统管理</td>
      <td class="t_Edit_td"><input name="flag[]" type="checkbox" value="91" <?php if (strpos($flag,'91')){echo "checked=checked";}?>>
系统设置
  <input name="flag[]" type="checkbox" value="92" <?php if (strpos($flag,'92')){echo "checked=checked";}?>>
银行设置
<input name="flag[]" type="checkbox" value="93" <?php if (strpos($flag,'93')){echo "checked=checked";}?>>
充值设置
<input name="flag[]" type="checkbox" value="94" <?php if (strpos($flag,'94')){echo "checked=checked";}?>> 
提现设置
<input name="flag[]" type="checkbox" value="95" <?php if (strpos($flag,'95')){echo "checked=checked";}?>> 
活动设置
<input name="flag[]" type="checkbox" value="96" <?php if (strpos($flag,'96')){echo "checked=checked";}?>> 
锁定IP
<input name="flag[]" type="checkbox" value="97" <?php if (strpos($flag,'97')){echo "checked=checked";}?>> 
数据备份
<input name="flag[]" type="checkbox" value="98" <?php if (strpos($flag,'98')){echo "checked=checked";}?>> 
数据清理</td>
    </tr>
    <tr>
      <td class="t_Edit_caption">权限管理</td>
      <td class="t_Edit_td"><input name="flag[]" type="checkbox" value="a1" <?php if (strpos($flag,'a1')){echo "checked=checked";}?>>
管理员　
  <input name="flag[]" type="checkbox" value="a2" <?php if (strpos($flag,'a2')){echo "checked=checked";}?>>
登陆日志
<input name="flag[]" type="checkbox" value="a3" <?php if (strpos($flag,'a3')){echo "checked=checked";}?>>
操作记录</td>
    </tr>
    <tr>
      <td class="t_Edit_caption">计划任务</td>
      <td class="t_Edit_td"><input name="flag[]" type="checkbox" value="b1" <?php if (strpos($flag,'b1')){echo "checked=checked";}?>>
任务列表
  <input name="flag[]" type="checkbox" value="b2" <?php if (strpos($flag,'b2')){echo "checked=checked";}?>>
  任务日志</td>
    </tr>
    <tr>
      <td class="t_Edit_caption">帮助中心</td>
      <td class="t_Edit_td"><input name="flag[]" type="checkbox" value="c1" <?php if (strpos($flag,'c1')){echo "checked=checked";}?>>
玩法介绍
  <input name="flag[]" type="checkbox" value="c2" <?php if (strpos($flag,'c2')){echo "checked=checked";}?>>
功能介绍
<input name="flag[]" type="checkbox" value="c3" <?php if (strpos($flag,'c3')){echo "checked=checked";}?>>
常见问题</td>
    </tr>
    <tr>
      <td height="40" class="t_Edit_caption">&nbsp;</td>
      <td class="t_Edit_caption">&nbsp;</td>
      <td class="t_Edit_td">选择：<a href="javascript:select()">全选</a> - <a href="javascript:fanselect()">反选</a> - <a href="javascript:noselect()">不选</a>&nbsp;</td>
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