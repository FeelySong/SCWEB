<?php
session_start();
error_reporting(0);

require_once 'conn.php';

if (strpos($_SESSION['admin_flag'],'98') ){}else{ 
	echo "<script language=javascript>alert('对不起，您无此权限！');window.history.go(-1);</script>";
	exit;
}

$bday=$_POST['bdays'];
$bdays=date("Y-m-d",strtotime("-".$bday." day"))." 03:00:00";

if($_GET['act']=="a1"){
	$sql="delete from ssc_member where leftmoney<=".$_POST['bmoney']." and lastdate <'".$bdays."'";
//	echo $sql;
	$exe=mysql_query($sql) or  die("数据库修改出错2");
}else if($_GET['act']=="a2"){
	$sql="delete from ssc_record where adddate <'".$bdays."'";
	$exe=mysql_query($sql) or  die("数据库修改出错2");
	$sql="delete from ssc_bills where adddate <'".$bdays."'";
	$exe=mysql_query($sql) or  die("数据库修改出错2");
	$sql="delete from ssc_zbills where adddate <'".$bdays."'";
	$exe=mysql_query($sql) or  die("数据库修改出错2");
	$sql="delete from ssc_zdetail where adddate <'".$bdays."'";
	$exe=mysql_query($sql) or  die("数据库修改出错2");
}else if($_GET['act']=="a3"){
	$sql="delete from ssc_memberlogin where logindate <'".$bdays."'";
	$exe=mysql_query($sql) or  die("数据库修改出错2");
}else if($_GET['act']=="a4"){
	$sql="delete from ssc_memberamend where adddate <'".$bdays."'";
	$exe=mysql_query($sql) or  die("数据库修改出错2");
}else if($_GET['act']=="a5"){
	$sql="delete from ssc_data where addtime <'".$bdays."'";
	$exe=mysql_query($sql) or  die("数据库修改出错2");
}else if($_GET['act']=="a6"){
	$sql="delete from ssc_savelist where adddate <'".$bdays."'";
	$exe=mysql_query($sql) or  die("数据库修改出错2");
}else if($_GET['act']=="a7"){
	$sql="delete from ssc_drawlist where adddate <'".$bdays."'";
	$exe=mysql_query($sql) or  die("数据库修改出错2");
}else if($_GET['act']=="a8"){
	$sql="delete from ssc_managerlogin where logindate <'".$bdays."'";
	$exe=mysql_query($sql) or  die("数据库修改出错2");
}else if($_GET['act']=="a9"){
	$sql="delete from ssc_manageramend where adddate <'".$bdays."'";
	$exe=mysql_query($sql) or  die("数据库修改出错2");
}else if($_GET['act']=="a10"){
	$sql="delete from ssc_kf where adddate <'".$bdays."'";
	$exe=mysql_query($sql) or  die("数据库修改出错2");
}else if($_GET['act']=="a11"){
	$sql="delete from ssc_message where adddate <'".$bdays."'";
	$exe=mysql_query($sql) or  die("数据库修改出错2");
}
if($_GET['act']!=""){
	echo "<script>alert('清理成功！');</script>"; 
}
	$sql="select id from ssc_member";
	$rs = mysql_query($sql);
	$t1 = mysql_num_rows($rs);

	$sql="select id from ssc_record";
	$rs = mysql_query($sql);
	$t2 = mysql_num_rows($rs);

	$sql="select id from ssc_memberlogin";
	$rs = mysql_query($sql);
	$t3 = mysql_num_rows($rs);

	$sql="select id from ssc_memberamend";
	$rs = mysql_query($sql);
	$t4 = mysql_num_rows($rs);

	$sql="select id from ssc_data";
	$rs = mysql_query($sql);
	$t5 = mysql_num_rows($rs);

	$sql="select id from ssc_savelist";
	$rs = mysql_query($sql);
	$t6 = mysql_num_rows($rs);

	$sql="select id from ssc_drawlist";
	$rs = mysql_query($sql);
	$t7 = mysql_num_rows($rs);

	$sql="select id from ssc_managerlogin";
	$rs = mysql_query($sql);
	$t8 = mysql_num_rows($rs);

	$sql="select id from ssc_manageramend";
	$rs = mysql_query($sql);
	$t9 = mysql_num_rows($rs);

	$sql="select id from ssc_kf";
	$rs = mysql_query($sql);
	$t10 = mysql_num_rows($rs);

	$sql="select id from ssc_message";
	$rs = mysql_query($sql);
	$t11 = mysql_num_rows($rs);

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
        <td class="top_list_td icons_a9">　　您现在的位置是：系统管理 &gt; 数据清理</td>
      </tr>
    </table>
<br>
<table width="95%" border="1" cellpadding="0" cellspacing="0" bordercolor="#DDDDDD" class="t_list">
	<form name="form1" method="post" action="?act=a1">
    <tr>
        <td width="20%" height="40" class="t_Edit_caption">会员</td>
      	<td class="t_Edit_td">当前数据 <font color='#FF0000'><?=$t1?> </font>条</td>
        <td width="35%" class="t_Edit_td">
          <select name="bdays" id="bdays">
            <option value="180">六个月未登陆</option>
            <option value="90">三个月未登陆</option>
            <option value="30">一个月未登陆</option>
            <option value="15">半个月未登陆</option>
            <option value="7">一周未登陆</option>
            <option value="3">三天未登陆</option>
          </select>
        &nbsp;余额小于
        <input name="bmoney" type="text" class="inpa" id="bmoney" value="0.1" size="10">
        元</td>
        <td width="15%" class="t_Edit_td"><div align="center">
          <input type="submit" name="Submit2" value="清 理" class="btn2" onMouseOver="this.className='btn2a'" onMouseOut="this.className='btn2'"  onClick="return confirm('确认要清理吗?');"/>
        </div></td>
    </tr>
	</form>
	<form name="form1" method="post" action="?act=a2">
    <tr>
      <td height="40" class="t_Edit_caption">财变/投注/追号</td>
      <td class="t_Edit_td">当前数据 <font color='#FF0000'><?=$t2?> </font>条</td>
      <td class="t_Edit_td"><select name="bdays" id="bdays">
        <option value="180">保留六个月</option>
        <option value="90">保留三个月</option>
        <option value="30">保留一个月</option>
        <option value="15">保留半个月</option>
        <option value="7">保留一周</option>
        <option value="3">保留三天</option>
      </select></td>
      <td class="t_Edit_td"><div align="center">
        <input type="submit" name="Submit3" value="清 理" class="btn2" onMouseOver="this.className='btn2a'" onMouseOut="this.className='btn2'"  onClick="return confirm('确认要清理吗?');"/>
      </div></td>
    </tr>
	</form>
	<form name="form1" method="post" action="?act=a3">
    <tr>
      <td height="40" class="t_Edit_caption">会员登陆日志</td>
      <td class="t_Edit_td">当前数据 <font color='#FF0000'><?=$t3?> </font>条</td>
      <td class="t_Edit_td"><select name="bdays" id="bdays">
        <option value="180">保留六个月</option>
        <option value="90">保留三个月</option>
        <option value="30">保留一个月</option>
        <option value="15">保留半个月</option>
        <option value="7">保留一周</option>
        <option value="3">保留三天</option>
      </select></td>
      <td class="t_Edit_td"><div align="center">
        <input type="submit" name="Submit4" value="清 理" class="btn2" onMouseOver="this.className='btn2a'" onMouseOut="this.className='btn2'"  onClick="return confirm('确认要清理吗?');"/>
      </div></td>
    </tr>
	</form>
	<form name="form1" method="post" action="?act=a4">
    <tr>
      <td height="40" class="t_Edit_caption">会员操作日志</td>
      <td class="t_Edit_td">当前数据 <font color='#FF0000'><?=$t4?> </font>条</td>
      <td class="t_Edit_td"><select name="bdays" id="bdays">
        <option value="180">保留六个月</option>
        <option value="90">保留三个月</option>
        <option value="30">保留一个月</option>
        <option value="15">保留半个月</option>
        <option value="7">保留一周</option>
        <option value="3">保留三天</option>
      </select></td>
      <td class="t_Edit_td"><div align="center">
        <input type="submit" name="Submit5" value="清 理" class="btn2" onMouseOver="this.className='btn2a'" onMouseOut="this.className='btn2'"  onClick="return confirm('确认要清理吗?');"/>
      </div></td>
    </tr>
	</form>
	<form name="form1" method="post" action="?act=a5">
    <tr>
      <td height="40" class="t_Edit_caption">开奖数据</td>
      <td class="t_Edit_td">当前数据 <font color='#FF0000'><?=$t5?> </font>条</td>
      <td class="t_Edit_td"><select name="bdays" id="bdays">
        <option value="180">保留六个月</option>
        <option value="90">保留三个月</option>
        <option value="30">保留一个月</option>
        <option value="15">保留半个月</option>
        <option value="7">保留一周</option>
        <option value="3">保留三天</option>
      </select></td>
      <td class="t_Edit_td"><div align="center">
        <input type="submit" name="Submit6" value="清 理" class="btn2" onMouseOver="this.className='btn2a'" onMouseOut="this.className='btn2'"  onClick="return confirm('确认要清理吗?');"/>
      </div></td>
    </tr>
	</form>
	<form name="form1" method="post" action="?act=a6">
    <tr>
      <td height="40" class="t_Edit_caption">充值记录</td>
      <td class="t_Edit_td">当前数据 <font color='#FF0000'><?=$t6?> </font>条</td>
      <td class="t_Edit_td"><select name="bdays" id="bdays">
        <option value="180">保留六个月</option>
        <option value="90">保留三个月</option>
        <option value="30">保留一个月</option>
        <option value="15">保留半个月</option>
        <option value="7">保留一周</option>
        <option value="3">保留三天</option>
      </select></td>
      <td class="t_Edit_td"><div align="center">
        <input type="submit" name="Submit7" value="清 理" class="btn2" onMouseOver="this.className='btn2a'" onMouseOut="this.className='btn2'"  onClick="return confirm('确认要清理吗?');"/>
      </div></td>
    </tr>
	</form>
	<form name="form1" method="post" action="?act=a7">
    <tr>
      <td height="40" class="t_Edit_caption">提款记录</td>
      <td class="t_Edit_td">当前数据 <font color='#FF0000'><?=$t7?> </font>条</td>
      <td class="t_Edit_td"><select name="bdays" id="bdays">
        <option value="180">保留六个月</option>
        <option value="90">保留三个月</option>
        <option value="30">保留一个月</option>
        <option value="15">保留半个月</option>
        <option value="7">保留一周</option>
        <option value="3">保留三天</option>
      </select></td>
      <td class="t_Edit_td"><div align="center">
        <input type="submit" name="Submit8" value="清 理" class="btn2" onMouseOver="this.className='btn2a'" onMouseOut="this.className='btn2'"  onClick="return confirm('确认要清理吗?');"/>
      </div></td>
    </tr>
	</form>
	<form name="form1" method="post" action="?act=a8">
    <tr>
      <td height="40" class="t_Edit_caption">管理员登陆日志</td>
      <td class="t_Edit_td">当前数据 <font color='#FF0000'><?=$t8?> </font>条</td>
      <td class="t_Edit_td"><select name="bdays" id="bdays">
        <option value="180">保留六个月</option>
        <option value="90">保留三个月</option>
        <option value="30">保留一个月</option>
        <option value="15">保留半个月</option>
        <option value="7">保留一周</option>
        <option value="3">保留三天</option>
      </select></td>
      <td class="t_Edit_td"><div align="center">
        <input type="submit" name="Submit9" value="清 理" class="btn2" onMouseOver="this.className='btn2a'" onMouseOut="this.className='btn2'"  onClick="return confirm('确认要清理吗?');"/>
      </div></td>
    </tr>
	</form>
	<form name="form1" method="post" action="?act=a9">
    <tr>
      <td height="40" class="t_Edit_caption">管理员操作日志</td>
      <td class="t_Edit_td">当前数据 <font color='#FF0000'><?=$t9?> </font>条</td>
      <td class="t_Edit_td"><select name="bdays" id="bdays">
        <option value="180">保留六个月</option>
        <option value="90">保留三个月</option>
        <option value="30">保留一个月</option>
        <option value="15">保留半个月</option>
        <option value="7">保留一周</option>
        <option value="3">保留三天</option>
      </select></td>
      <td class="t_Edit_td"><div align="center">
        <input type="submit" name="Submit10" value="清 理" class="btn2" onMouseOver="this.className='btn2a'" onMouseOut="this.className='btn2'"  onClick="return confirm('确认要清理吗?');"/>
      </div></td>
    </tr>
	</form>
	<form name="form1" method="post" action="?act=a10">
    <tr>
      <td height="40" class="t_Edit_caption">客服消息</td>
      <td class="t_Edit_td">当前数据 <font color='#FF0000'><?=$t10?> </font>条</td>
      <td class="t_Edit_td"><select name="bdays" id="bdays">
        <option value="180">保留六个月</option>
        <option value="90">保留三个月</option>
        <option value="30">保留一个月</option>
        <option value="15">保留半个月</option>
        <option value="7">保留一周</option>
        <option value="3">保留三天</option>
      </select></td>
      <td class="t_Edit_td"><div align="center">
        <input type="submit" name="Submit11" value="清 理" class="btn2" onMouseOver="this.className='btn2a'" onMouseOut="this.className='btn2'"  onClick="return confirm('确认要清理吗?');"/>
      </div></td>
    </tr>
	</form>
	<form name="form1" method="post" action="?act=a11">
    <tr>
      <td height="40" class="t_Edit_caption">系统消息</td>
      <td class="t_Edit_td">当前数据 <font color='#FF0000'><?=$t11?> </font>条</td>
      <td class="t_Edit_td"><select name="bdays" id="bdays">
        <option value="180">保留六个月</option>
        <option value="90">保留三个月</option>
        <option value="30">保留一个月</option>
        <option value="15">保留半个月</option>
        <option value="7">保留一周</option>
        <option value="3">保留三天</option>
      </select></td>
      <td class="t_Edit_td"><div align="center">
        <input type="submit" name="Submit12" value="清 理" class="btn2" onMouseOver="this.className='btn2a'" onMouseOut="this.className='btn2'"  onClick="return confirm('确认要清理吗?');"/>
      </div></td>
    </tr>
	</form>
  </table>



</body>
</html>