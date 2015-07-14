<?php
session_start();
error_reporting(0);
require_once 'conn.php';

if (strpos($_SESSION['admin_flag'],'45') ){}else{ 
	echo "<script language=javascript>alert('对不起，您无此权限！');window.history.go(-1);</script>";
exit;}

$jb=array("用户","代理","总代理"); 

$uname=$_REQUEST['uname'];

$starttime = $_REQUEST['starttime'];
$endtime = $_REQUEST['endtime'];
$lotteryid=$_REQUEST['lotteryid'];
$methodid=$_REQUEST['methodid'];
$mode=$_REQUEST['mode'];

$username_mem=$_REQUEST['username'];
$dan=$_REQUEST['dan'];

if($_GET['act']=="dels"){       //批量删除   
	$ids=$_POST['lids'];  
	$ids=implode(",", $ids);   //implode函数 把数组元素组合为一个字符串。   
	$sql="delete from ssc_record where id in ($ids)";  
	mysql_query($sql); 
}

if($_GET['act']=="del"){
	mysql_query("Delete from ssc_record where id=".$_GET['id']);
	echo "<script>window.location.href='account_rebate.php';</script>"; 
	exit;
}

if($_GET['act']=="cd"){
	$sql="select * from ssc_record where dan='".$_GET['dan']."'";
	$rs = mysql_query($sql);
	$row = mysql_fetch_array($rs);
	if($row['tag']!="撤消分红" && $row['smoney']!=""){
		mysql_query("update ssc_record set tag='撤消分红' where dan='".$_GET['dan']."'");	

		$sqlb="select * from ssc_record where dan='".$_GET['dan']."'";
		$rsb=mysql_query($sqlb) or  die("数据库修改出错!!!!".mysql_error());
		$rowb = mysql_fetch_array($rsb);
		
		$sqla = "select * from ssc_record order by id desc limit 1";
		$rsa = mysql_query($sqla);
		$rowa = mysql_fetch_array($rsa);
		$dan1 = sprintf("%07s",strtoupper(base_convert($rowa['id']+1,10,36)));
	
		$lmoney=Get_mmoney($rowb['uid'])-$rowb['smoney'];
	
		$sqla="insert into ssc_record set lotteryid='".$rowb['lotteryid']."', lottery='".$rowb['lottery']."', dan='".$dan1."', dan1='".$rowb['dan1']."', dan2='".$rowb['dan2']."', uid='".$rowb['uid']."', username='".$rowb['username']."', issue='".$rowb['issue']."', types='40', mid='".$rowb['mid']."', mode='".$rowb['mode']."', zmoney=".$rowb['smoney'].",leftmoney=".$lmoney.", cont='".$rowb['cont']."', regtop='".$rowb['regtop']."', regup='".$rowb['regup']."', regfrom='".$rowb['regfrom']."', adddate='".date("Y-m-d H:i:s")."'";
	//			echo $sqla;
		$exe=mysql_query($sqla) or  die("数据库修改出错3!!!".mysql_error());
				
		$sqla="update ssc_member set leftmoney=".$lmoney." where id='".$rowb['uid']."'"; 
		$exe=mysql_query($sqla) or  die("数据库修改出错2!!!".mysql_error());
				
//		mysql_query("Delete from ssc_record where id=".$_GET['id']);
		echo "<script>window.location.href='account_fh.php';</script>"; 
		exit;
	}else{
		echo "<script>alert('该单不能被处理！');window.location.href='account_fh.php';</script>"; 
		exit;
	}
}


$page = !($_GET['page'])?'1':intval($_GET['page']);
$pagesize=20;
$page2=($page-1)*$pagesize;

if($starttime==""){
	if(date("H:i:s")<"03:00:00"){
		$starttime=date("Y-m-d",strtotime("-1 day"))." 03:00:00";
	}else{
		$starttime=date("Y-m-d")." 03:00:00";
	}
}
	$s1=$s1." and adddate>='".$starttime."'";

if($endtime==""){
	if(date("H:i:s")<"03:00:00"){
		$endtime=date("Y-m-d")." 03:00:00";
	}else{
		$endtime=date("Y-m-d",strtotime("+1 day"))." 03:00:00";
	}
}
	$s1=$s1." and adddate<='".$endtime."'";
	$s1=$s1." and types='40'";

if($lotteryid!="" && $lotteryid!="0"){
	$s1=$s1." and lotteryid='".$lotteryid."'";
}else{
	$lotteryid=0;
}

if($uname!=""){
	$username_mem=$uname;
}

if($username_mem!=""){
	$s1=$s1." and username='".$username_mem."'";
}

if($dan!=""){
	$s1=$s1." and dan='".$dan."'";
}

$urls="starttime=".$starttime."&endtime=".$endtime."&lotteryid=".$lotteryid."&uname=".$uname."&username=".$username_mem."&dan=".$dan;
$s1=$s1." order by id desc";
$sql="select * from ssc_record where 1=1".$s1;

$rs = mysql_query($sql);
$total = mysql_num_rows($rs);

$sql="select * from ssc_record where 1=1".$s1." limit $page2,$pagesize";
$rsnewslist=mysql_query($sql);

$lastpg=ceil($total/$pagesize); //最后页，也是总页数
$page=min($lastpg,$page);
$prepg=$page-1; //上一页
$nextpg=($page==$lastpg ? 0 : $page+1); //下一页

if($page<5){
	$p1=1;
	$p2=min($lastpg,10);
}else{
	$p2=min($lastpg,$page+5);
	$p1=max($p2-9,1);
}


$page = !($_GET['page'])?'1':intval($_GET['page']);
$pagesize=20;
$page2=($page-1)*$pagesize;

?>
<html>
<head>
<link href="css/index.css" rel="stylesheet" type="text/css">
<script language="javascript" type="text/javascript" src="js/jquery.js"></script>
<script language="javascript" type="text/javascript" src="js/common.js"></script>
<script type="text/javascript" src="js/calendar/jquery.dyndatetime.js"></script>
<script type="text/javascript" src="js/calendar/lang/calendar-utf8.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="js/calendar/css/calendar-blue2.css"  />
<script type="text/javascript">
jQuery(document).ready(function() {		
	jQuery("#starttime").dynDateTime({
		ifFormat: "%Y-%m-%d %H:%M:00",
		daFormat: "%l;%M %p, %e %m,  %Y",
		align: "Br",
		electric: true,
		singleClick: false,
		button: ".next()", //next sibling
		onUpdate:function(){
			$("#starttime").change();
		},
		showOthers: true,
		weekNumbers: true,
		showsTime: true
	});
	jQuery("#starttime").change(function(){
		if(! validateInputDate(jQuery("#starttime").val()) )
		{
			jQuery("#starttime").val('');
			alert("时间格式不正确,正确的格式为:2011-01-01 12:01");
		}
		if($("#endtime").val()!="")
		{
			if($("#starttime").val()>$("#endtime").val())
			{
				$("#starttime").val("");
				alert("输入的时间不符合逻辑.");
			}
		}
	});
	jQuery("#endtime").dynDateTime({
		ifFormat: "%Y-%m-%d %H:%M:00",
		daFormat: "%l;%M %p, %e %m,  %Y",
		align: "Br",
		electric: true,
		singleClick: false,
		button: ".next()", //next sibling
		onUpdate:function(){
			$("#endtime").change();
		},
		showOthers: true,
		weekNumbers: true,
		showsTime: true
	});
	jQuery("#endtime").change(function(){
		if(! validateInputDate(jQuery("#endtime").val()) )
		{
			jQuery("#endtime").val('');
			alert("时间格式不正确,正确的格式为:2011-01-01 12:01");
		}
		if($("#starttime").val()!="")
		{
			if($("#starttime").val()>$("#endtime").val())
			{
				$("#endtime").val("");
				alert("输入的时间不符合逻辑.");
			}
		}
	});
});

function checkForm(obj)
{
	if( jQuery.trim(obj.ordertime_min.value) != "" )
	{
		if( false == validateInputDate(obj.ordertime_min.value) )
		{
			alert("时间格式不正确");
			obj.ordertime_min.focus();
			return false;
		}
	}
	if( jQuery.trim(obj.ordertime_max.value) != "" )
	{
		if( false == validateInputDate(obj.ordertime_max.value) )
		{
			alert("时间格式不正确");
			obj.ordertime_max.focus();
			return false;
		}
	}
}
var checkall=document.getElementsByName("lids[]");  
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
<base target="mainframe" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>

<body>
<br>
	<table width="95%" border="0" cellpadding="0" cellspacing="0" class="top_list">
      <tr>
        <td class="top_list_td icons_a4">　　您现在的位置是：业务流水 &gt; 分红记录</td>
      </tr>
    </table>
    <br>
    <form name="memberForm" method="post" action="?">
    <table width="95%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td class="top_list_td">分红时间:
          <input name="starttime" type="text" class="inpa" id="starttime" style='width:144px;' value="<?=$starttime?>" size="19" />
          <img class='icons_mb4' src="images/comm/t.gif" id="time_min_button" style="cursor:pointer;" /> 至
          <input name="endtime" type="text" class="inpa" id="endtime" style='width:144px;' value="<?=$endtime?>" size="19" / >
          <img class='icons_mb4' src="images/comm/t.gif" id="time_min_button" style="cursor:pointer;" />&nbsp;&nbsp;游戏名称:
          <select name="lotteryid" id="lotteryid" style="width:100px;">
            <option value="0" <?php if($lotteryid==0 || $lotteryid==""){echo "SELECTED";}?>>所有游戏</option>
            <option value="1" <?php if($lotteryid==1){echo "SELECTED";}?>>重庆时时彩</option>
            <option value="2" <?php if($lotteryid==2){echo "SELECTED";}?>>SC五分彩时时彩</option>
            <option value="3" <?php if($lotteryid==3){echo "SELECTED";}?>>新疆时时彩</option>
            <option value="4" <?php if($lotteryid==4){echo "SELECTED";}?>>江西时时彩</option>
            <option value="5" <?php if($lotteryid==5){echo "SELECTED";}?>>上海时时乐</option>
            <option value="6" <?php if($lotteryid==6){echo "SELECTED";}?>>十一运夺金</option>
            <option value="7" <?php if($lotteryid==7){echo "SELECTED";}?>>多乐彩</option>
            <option value="8" <?php if($lotteryid==8){echo "SELECTED";}?>>广东十一选五</option>
            <option value="9" <?php if($lotteryid==9){echo "SELECTED";}?>>福彩3D</option>
            <option value="10" <?php if($lotteryid==10){echo "SELECTED";}?>>排列三、五</option>
            <option value="11" <?php if($lotteryid==11){echo "SELECTED";}?>>重庆十一选五</option>
          </select>
          &nbsp;帐变编号:
<input name="dan" type="text" class="inpa" value="" size="10" maxlength="30" id="dan">
&nbsp;&nbsp;用户名:
<input name="username" type="text" class="inpa" id="username" size="10" maxlength="30">
<input name="Find_VN" type="submit" class="btnb" value="搜 索" style="position: relative; top: 2px;">
<br></td>
     </tr>
    </table>
</form>
<br>
  	<form method=post action="?act=dels">
	<table width="95%" border="1" cellpadding="0" cellspacing="0" bordercolor="#DDDDDD" class="t_list">
        <tr>
            <td class="t_list_caption">选择</td>
            <td class="t_list_caption">帐变编号</td>
          <td class="t_list_caption">用户名</td>
          <td class="t_list_caption">时间</td>
          <td class="t_list_caption">类型</td>
            <td class="t_list_caption">游戏</td>
            <td class="t_list_caption">玩法</td>
            <td class="t_list_caption">期号</td>
            <td class="t_list_caption">模式</td>
            <td class="t_list_caption">收入</td>
            <td class="t_list_caption">支出</td>
            <td class="t_list_caption">余额</td>
            <td class="t_list_caption">备注</td>
          <td class="t_list_caption">操作</td>
      </tr>
        <?php
		while ($row = mysql_fetch_array($rsnewslist))
		{
		?>
            <tr class="t_list_tr_0" onMouseOver="this.style.backgroundColor='#FFFFA2'" onMouseOut="this.style.backgroundColor=''">
                <td><input name="lids[]" type="checkbox" id="checkbox2" value="<?=$row['id']?>"></td> 
                <td><?=$row['dan']?></td>
                <td><?=$row['username']?></td>
                <td><?=$row['adddate']?></td>
              	<td><?php if($row['types']==1){echo "账户充值";
        }else if($row['types']==2){echo "账户提现";
        }else if($row['types']==3){echo "提现失败";
        }else if($row['types']==7){echo "投注扣款";
        }else if($row['types']==9){echo "追号扣款";
        }else if($row['types']==10){echo "追号返款";
        }else if($row['types']==11){echo "游戏返点";
        }else if($row['types']==12){echo "奖金派送";
        }else if($row['types']==13){echo "撤单返款";
        }else if($row['types']==14){echo "撤单手续费";
        }else if($row['types']==15){echo "撤消返点";
        }else if($row['types']==16){echo "撤消派奖";
        }else if($row['types']==30){echo "充值扣费";
        }else if($row['types']==31){echo "上级充值";
        }else if($row['types']==32){echo "活动礼金";
        }else if($row['types']==40){echo "系统分红";
        }else if($row['types']==50){echo "系统扣款";
		}else if($row['types']==70){echo "投注佣金返利";
        }else if($row['types']==999){echo "其他";}
		?></td>
                <td><?php if($row['lottery']!=''){echo $row['lottery'];}else{echo "<font color='#D0D0D0'>---";}?></td>
                <td><?php if($row['mid']!=''){echo Get_mid($row['mid']);}else{echo "<font color='#D0D0D0'>---";}?></td>
                <td><?php if($row['issue']!=''){echo $row['issue'];}else{echo "<font color='#D0D0D0'>---";}?></td>
                <td><?php if($row['mode']=='1'){echo "元";}else if($row['mode']=='2'){echo "角";}elseif($row['mode']=='3'){echo "分";}else{echo "<font color='#D0D0D0'>---";}?></td>
                <td><?php if($row['smoney']>=0){echo "<font color='#669900'>+".number_format($row['smoney'],4)."</font>";}else{echo "<font color='#D0D0D0'>---";}?></td>
                <td><?php if($row['smoney']<0){echo "<font color='#FF3300'>".number_format($row['smoney'],4)."</font>";}else{echo "<font color='#D0D0D0'>---";}?></td>
                <td><?=number_format($row['leftmoney'],4)?></td>
                <td><?php if($row['tag']!=''){echo $row['tag'];}else{echo "<font color='#D0D0D0'>---";}?></td>
              <td><a href="?act=cd&dan=<?=$row['dan']?>" onClick="return confirm('确认要撤消分红吗?');">撤消分红</a> <a href="?act=del&id=<?=$row['id']?>" onClick="return confirm('确认要删除吗?');">删除</a></td>
  </tr>
 		<?php
		}
		?>

      <tr>
            <td colspan="14" class="t_list_bottom"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="170" height="35">　选择：<a href="javascript:select()">全选</a> - <a href="javascript:fanselect()">反选</a> - <a href="javascript:noselect()">不选</a></td>
                <td width="150"><input name="Submit" type="submit" class="btndel" onClick="return confirm('确认要删除吗?');" value=" " /></td>
                <td><div style='text-align:right;'>总计  <?=$total?> 条数据,  共 <?=$lastpg?> 页 , 当前第 <?=$page?> 页  |  <?php if($page>1){?> <A HREF="?<?=$urls?>&page=1">首页</A> <A HREF="?<?=$urls?>&page=<?=$page-1?>">上页</A><?php }?><?php for($i=$p1;$i<=$p2;$i++){
		if($i==$page){?> <span class='Font_R'><?=$i?></span> <?php }else{?> <A HREF="?<?=$urls?>&page=<?=$i?>"><?=$i?></A> <?php }}?><?php if($page!=$lastpg){?> <A HREF="?<?=$urls?>&page=<?=$page+1?>">下页</A> <A HREF="?<?=$urls?>&page=<?=$lastpg?>">尾页</A> <?php }?> | 转至 <SCRIPT LANGUAGE="JAVASCRIPT">function keepKeyNum(obj,evt){var  k=window.event?evt.keyCode:evt.which; if( k==13 ){ goPage(obj.value);return false; }} function goPage( iPage ){ if( !isNaN(parseInt(iPage)) ) { if(iPage< 0 ){iPage=0;} window.location.href="?<?=$urls?>&page="+iPage;}}</SCRIPT><INPUT onKeyPress="return keepKeyNum(this,event);" TYPE="TEXT" ID="iGotoPage" NAME="iGotoPage" size="3"> 页  &nbsp;<BUTTON onClick="javascript:goPage( document.getElementById('iGotoPage').value );return false;">GO</BUTTON></div></td>
              </tr>
            </table></td>
      </tr>
</table>
</form>
<br>


</body>
</html> 