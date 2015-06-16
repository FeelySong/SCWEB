<?php
if(Get_member(zt)=="1"){
	echo "<script language='javascript'>alert('您的帐户被锁定! ');window.history.go(-1);</script>";
	exit;
}
?>