<?php
if ( !isset( $_SESSION['username'] ) )
{
	echo "<script language='javascript'>alert('登陆时间超时，请重新登陆');parent.location='default_logout.php'</script>";
	exit;
}
if($_SESSION["sess_uid"]=="" || $_SESSION["username"] =="" || $_SESSION["valid"]=="")
{
	echo "<script language='javascript'>alert('登录时间超时,请重新登录1! ');parent.location='default_logout.php'</script>";
	exit;
}
if($webzt!='1'){
	echo "<script>alert('对不起,系统维护中!');window.location='".$gourl."';</script>"; 
	exit;
}
if(Get_member(zt)=="2"){
	echo "<script language='javascript'>alert('您的帐户被冻结合! ');parent.location='default_logout.php'</script>";
	exit;
}
?>