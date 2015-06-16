<SCRIPT type="text/javascript">
//if (top.location == self.location) top.location.href = "index.php"; </script>
<?php
session_start();

//error_reporting(0);
require_once 'conn.php';
require_once 'check.php';

if ( isset( $_GET['act'] ) ){
	if ($_GET['act']=="save") {		
		
		$date_num = $_POST['num'];
		$path = "backup/";
		if ( !file_exists( $path ) )
		{
				mkdir( $path );
		}
		$rtable = array( "bills");
		$pathdate = date( "Y-m-d" );
		
		$file = date( "YmdHis" );
		$file .="-".$date_num;
		$filetype = ".rar";
		$files = $file.$filetype;
		$filepahtname = $path.$files;
		if ( !opendir( $path ) )
		{
			mkdir( $path, 448 );
		}
		$fpath = @fopen( $filepahtname, "a" );
		$fors = "<?php \r\n";
		$ss = " where nums='{$date_num}'";
		$fors .= "mysql_query(\"delete from bills ".$ss."\",\$conn)".";\r\n";
		fwrite( $fpath, $fors );
				
		$sql_bill = mysql_query( "select * from bills {$ss}", $conn );
		while ( $row = mysql_fetch_row( $sql_bill ) )
		{
			$fds = "";
			$i = 0;
			for ( ;	$i < count( $row );	++$i	)
			{
				$fds .= "'".$row[$i]."',";
			}
			$fm = "insert into bills values(".substr( $fds, 0, strlen( $fds ) - 1 ).")";
			$fin = "mysql_query(\"".$fm."\",\$conn)".";\r\n";
			fwrite( $fpath, $fin );
		}
				
				$_SESSION['fsave'] = "yes";
				$_SESSION['fpath'] = $filepahtname;
		

		$exe=mysql_query("insert into backup Set nums='".$date_num."',username='".$_SESSION['ausername']."',types='".$_POST['types']."',filename='".$filepahtname."',adddate='".date("Y-m-d H:i:s")."'" );

		echo "<script>window.location.href='backup.php';</script>"; 
		exit;
	}
	if ($_GET['act']=="del") {	
		if(file_exists($_GET['fn'])){
			unlink($_GET['fn']);
		}
		$exe=mysql_query("delete from backup where id='".$_GET['id']."'" );
		echo "<script>window.location.href='backup.php';</script>"; 
		exit;
	}
	if ($_GET['act']=="cover") {		
	
	}
}



$result=mysql_query("Select * from backup order by id asc");
?>
<html>
<head>
<link href="css/index.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>

<body>
<br>  
<form name="My_InfoForm" method="post" action="backup.php?act=save">
<table border="0" width="800">
<tr>
    <td  align="center"><input type="submit" name="button" id="button" value="備份數據">
    </label></td>
</tr>
</table>
</form>
<table border="0" cellspacing="1" cellpadding="0" class="t_list">
    <tr>
      <td width="100" class="t_list_caption">编号</td>
      <td width="280" class="t_list_caption">备份文件名</td>
      <td width="150" class="t_list_caption">备份時间</td>
      <td width="70" class="t_list_caption">类型</td>
      <td width="100" class="t_list_caption">操作者</td>
      <td width="100" class="t_list_caption">功能</td>
    </tr>
    <?php
	$I=0;
	while($image = mysql_fetch_array($result)){
		?>
    <tr class="t_list_tr_<?php echo $I%2;?>" onMouseOver="this.style.backgroundColor='#FFFFA2'" onMouseOut="this.style.backgroundColor=''">
      <td><?=$image['id']?></td>
      <td><?=$image['filename']?></td>
      <td><?=$image['adddate']?></td>
      <td><?php if($image['types']==0){echo "註單";}else{echo "全部";}?></td>
      <td><?=$image['username']?></td>
      <td><a href='<?=$image['filename']?>'>下载</a> <a href="?act=del&id=<?=$image['id']?>&fn=<?=$image['filename']?>">刪除</a> <a href="?act=cover&id=<?=$image['id']?>">还原</a></td>
    </tr>
    <?php
	$I=$I+1;
	}?>
</table>

</body>
</html>