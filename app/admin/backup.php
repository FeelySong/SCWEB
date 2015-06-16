<?php
session_start();
error_reporting(0);
require_once 'conn.php';
if (strpos($_SESSION['admin_flag'],'97') ){}else{ 
	echo "<script language=javascript>alert('对不起，您无此权限！');window.history.go(-1);</script>";
exit;}

if ( isset( $_GET['act'] ) ){
	if ($_GET['act']=="save") {		
		
		$date_num = $_POST['num'];
		$path = "backup/";
		if ( !file_exists( $path ) )
		{
				mkdir( $path );
		}
		$rtable = array( "ssc_bills","ssc_record","ssc_member","ssc_banks","ssc_bankcard","ssc_class","ssc_classb","ssc_config","ssc_data");
		$pathdate = date( "Y-m-d" );
		
		$file = date( "YmdHis" );
		$filetype = ".rar";
		$files = $file.$filetype;
		$filepahtname = $path.$files;
		if ( !opendir( $path ) )
		{
			mkdir( $path, 448 );
		}
		$fpath = @fopen( $filepahtname, "a" );
		$fors = "<?php \r\n";
		$ss = "";
//		$fors .= "mysql_query(\"delete from bills ".$ss."\",\$conn)".";\r\n";
		fwrite( $fpath, $fors );

		$f = 0;
		for ( ;	$f < count( $rtable );	++$f	)
		{
			$tbs = $rtable[$f];
				
			$sql_bill = mysql_query( "select * from {$tbs}", $conn );
			while ( $row = mysql_fetch_row( $sql_bill ) )
			{
				$fds = "";
				$i = 0;
				for ( ;	$i < count( $row );	++$i	)
				{
					$fds .= "'".$row[$i]."',";
				}
				$fm = "insert into {$tbs} values(".substr( $fds, 0, strlen( $fds ) - 1 ).")";
				$fin = "mysql_query(\"".$fm."\",\$conn)".";\r\n";
				fwrite( $fpath, $fin );
			}
		}
		$_SESSION['fsave'] = "yes";
		$_SESSION['fpath'] = $filepahtname;
		$end = " ?> \r\n";
//		fwrite( $fpath, $end );
		

		$exe=mysql_query("insert into ssc_backup Set username='".$_SESSION['ausername']."',filename='".$filepahtname."',adddate='".date("Y-m-d H:i:s")."'" );

		echo "<script>alert('备份成功！');window.location.href='backup.php';</script>"; 
		exit;
	}
	if ($_GET['act']=="del") {	
		if(file_exists($_GET['fn'])){
			unlink($_GET['fn']);
		}
		$exe=mysql_query("delete from ssc_backup where id='".$_GET['id']."'" );
		echo "<script>alert('删除成功！');window.location.href='backup.php';</script>"; 
		exit;
	}
	if ($_GET['act']=="cover") {		
	
	}
}

$result=mysql_query("Select * from ssc_backup order by id asc");
?>
<html>
<head>
<link href="css/index.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>

<body>
<br>
<table width="95%" border="0" cellpadding="0" cellspacing="0" class="top_list">
  <tr>
    <td class="top_list_td icons_a9">　　您现在的位置是：系统管理 &gt; 数据备份</td>
  </tr>
</table>
<br>  
<form name="My_InfoForm" method="post" action="backup.php?act=save">
<table border="0" width="800">
<tr>
    <td  align="center"><input type="submit" name="button" id="button" value="备份数据" onClick="return confirm('确认要备份吗?');">
    </label></td>
</tr>
</table>
</form>
<br>
<table width="95%" border="0" cellpadding="0" cellspacing="1" class="t_list">
<tr>
      <td class="t_list_caption">编号</td>
      <td class="t_list_caption">备份文件名</td>
    <td class="t_list_caption">备份時间</td>
      <td class="t_list_caption">操作者</td>
    <td class="t_list_caption">操作</td>
  </tr>
    <?php
	$I=0;
	while($image = mysql_fetch_array($result)){
		?>
    <tr class="t_list_tr_<?php echo $I%2;?>" onMouseOver="this.style.backgroundColor='#FFFFA2'" onMouseOut="this.style.backgroundColor=''">
      <td><?=$image['id']?></td>
      <td><?=$image['filename']?></td>
      <td><?=$image['adddate']?></td>
      <td><?=$image['username']?></td>
      <td><a href='<?=$image['filename']?>'>下载</a> <a href="?act=del&id=<?=$image['id']?>&fn=<?=$image['filename']?>"  onClick="return confirm('确认要删除吗?');">刪除</a></td>
    </tr>
    <?php
	$I=$I+1;
	}?>
</table>

</body>
</html>