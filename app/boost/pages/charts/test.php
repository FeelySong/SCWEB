<?php

require_once '../../../conn.php';

$flag=$_REQUEST['flag'];
$lotteryid="1";
$lottery="重庆时时彩";

$sqls="select * from ssc_nums where cid='1' and endtime>='".date("H:i:s")."' order by id asc limit 1";
$rss=mysql_query($sqls) or  die("数据库修改出错1".mysql_error());
$nums=mysql_num_rows($rss);
$dymd=date("Ymd");
$dymd2=date("Y-m-d");
if($nums==0){
	$sqls="select * from ssc_nums where cid='1' and endtime>='".date("H:i:s")."' order by id asc limit 1";
	$rss=mysql_query($sqls) or  die("数据库修改出错2".mysql_error());
	$dymd=date("ymd");
	$dymd2=date("Y-m-d");
}
$rows = mysql_fetch_array($rss);
$salenums=intval($rows['nums'])-1;
$leftnums=intval(120-$salenums);
$issue=intval($dymd.$rows['nums']);
$opentime=$dymd2." ".$rows['opentime'];
$endtime=$dymd2." ".$rows['endtime'];


//$salenums=31;
//$leftnums=89;
//$issue=121231032;
//$opentime=iconv("UTF-8","GB2312", "2012-12-31 11:19:10");
//$endtime=iconv("UTF-8","GB2312", "2012-12-31 11:19:10");

//echo($salenums."<br>");
//echo($leftnums."<br>");
//echo($issue."<br>");
//echo($opentime."<br>");
//echo($endtime."<br>");

if($rows['nums']=="024"){
	if(date("H:i:s")<$rows['starttime']){
		$signss=1;	
	}
}

if($flag=="gettime"){
//	$lotteryid=$_REQUEST['lotteryid'];
//	$issue=$_REQUEST['issue'];	//120225076
	echo abs(strtotime($endtime)-time());
}else if($flag=="gethistory"){
	$sqla="select * from ssc_data where cid='1' and issue='".$_REQUEST['issue']."'";
	$rsa=mysql_query($sqla) or  die("数据库修改出错3".mysql_error());
	$rowa = mysql_fetch_array($rsa);
	if(empty($rowa)){
		echo "empty";
	}else{
		echo "{\"code\":[\"".$rowa['n1']."\",\"".$rowa['n2']."\",\"".$rowa['n3']."\",\"".$rowa['n4']."\",\"".$rowa['n5']."\"],\"issue\":\"".$_REQUEST['issue']."\",\"statuscode\":\"2\"}";//empty
	}
}else if($flag=="read"){
	if($signss==1){
		echo "empty";
	}else{
		echo "{issue:'".$issue."',nowtime:'".date("Y-m-d H:i:s")."',opentime:'".$opentime."',saleend:'".$endtime."',sale:'".$salenums."',left:'".$leftnums."'}";//empty未到销售时间
	}
}else if($flag=="save"){
	require_once '../../../playact.php';
}else{

	$sqlc="select * from ssc_data where cid='1' order by issue desc limit 1";
	$rsc=mysql_query($sqlc) or  die("数据库修改出错!!".mysql_error());
	$rowc = mysql_fetch_array($rsc);
	
	$sqld = "select * from ssc_class WHERE cid='1' order by id asc";
	$rsd = mysql_query($sqld);
	while ($rowd = mysql_fetch_array($rsd)){
		$strd=explode(";",$rowd['rates']);
		for ($i=0; $i<count($strd); $i++) {
			$rate[$rowd['mid']][$i]=$strd[$i];
		}
	}

	$sqld = "select * from ssc_classb WHERE cid='".$lotteryid."' order by id asc";
	$rsd = mysql_query($sqld);
	while ($rowd = mysql_fetch_array($rsd)){
		$zt[$rowd['mid']]=$rowd['zt'];
	}
	
	$rstra=explode(";",Get_member(rebate));
	for ($i=0; $i<count($rstra)-1; $i++) {
		$rstrb=explode(",",$rstra[$i]);
		$rstrc=explode("_",$rstrb[0]);
		$rebate[$rstrc[1]]=$rstrb[1];
//		$zt[$rstrc[1]]=$rstrb[2];
	}
	
	if($signss==1){
		$_SESSION["backtitle"]="未到销售时间";
		$_SESSION["backurl"]="../../../help_security.php";
		$_SESSION["backzt"]="failed";
		$_SESSION["backname"]="系统公告";
		echo "<script language=javascript>window.location='../../../sysmessage.php';</script>";
		exit;	
	}
//	print_r($rate);
?>

<!DOCTYPE html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo $webname;?></title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="../../css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="../../css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="../../css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="../../css/AdminLTE.css" rel="stylesheet" type="text/css" />

        <link rel="icon" type="image/vnd.microsoft.icon" href="/favicon.ico"/>
        <link rel="stylesheet" href="http://s0.cp.360.cn/trade/2013/static/v1/css/src/reset.css" />
        <link rel="stylesheet" href="http://s0.cp.360.cn/trade/merge/i6Fzam6N7fIj.css?v1.0.50.css" />
        <link rel="stylesheet" href="http://s0.cp.360.cn/trade/2013/static/v1/css/lottery/mod.caiz.css?v1.0.50.css" />
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="skin-blue">
        <!-- header logo: style can be found in header.less -->
        <header class="header">
            <a href="../../index.html" class="logo">
                <!-- Add the class icon to your logo image or logo icon to add the margining -->
                AdminLTE
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <div class="navbar-right">
                    <ul class="nav navbar-nav">
                        <!-- Messages: style can be found in dropdown.less-->
                        <li class="dropdown messages-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-envelope"></i>
                                <span class="label label-success">4</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header">You have 4 messages</li>
                                <li>
                                    <!-- inner menu: contains the actual data -->
                                    <ul class="menu">
                                        <li><!-- start message -->
                                            <a href="#">
                                                <div class="pull-left">
                                                    <img src="../../img/avatar3.png" class="img-circle" alt="User Image"/>
                                                </div>
                                                <h4>
                                                    Support Team
                                                    <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                                </h4>
                                                <p>Why not buy a new awesome theme?</p>
                                            </a>
                                        </li><!-- end message -->
                                        <li>
                                            <a href="#">
                                                <div class="pull-left">
                                                    <img src="../../img/avatar2.png" class="img-circle" alt="user image"/>
                                                </div>
                                                <h4>
                                                    AdminLTE Design Team
                                                    <small><i class="fa fa-clock-o"></i> 2 hours</small>
                                                </h4>
                                                <p>Why not buy a new awesome theme?</p>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <div class="pull-left">
                                                    <img src="../../img/avatar.png" class="img-circle" alt="user image"/>
                                                </div>
                                                <h4>
                                                    Developers
                                                    <small><i class="fa fa-clock-o"></i> Today</small>
                                                </h4>
                                                <p>Why not buy a new awesome theme?</p>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <div class="pull-left">
                                                    <img src="../../img/avatar2.png" class="img-circle" alt="user image"/>
                                                </div>
                                                <h4>
                                                    Sales Department
                                                    <small><i class="fa fa-clock-o"></i> Yesterday</small>
                                                </h4>
                                                <p>Why not buy a new awesome theme?</p>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <div class="pull-left">
                                                    <img src="../../img/avatar.png" class="img-circle" alt="user image"/>
                                                </div>
                                                <h4>
                                                    Reviewers
                                                    <small><i class="fa fa-clock-o"></i> 2 days</small>
                                                </h4>
                                                <p>Why not buy a new awesome theme?</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="footer"><a href="#">See All Messages</a></li>
                            </ul>
                        </li>
                        <!-- Notifications: style can be found in dropdown.less -->
                        <li class="dropdown notifications-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-warning"></i>
                                <span class="label label-warning">10</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header">You have 10 notifications</li>
                                <li>
                                    <!-- inner menu: contains the actual data -->
                                    <ul class="menu">
                                        <li>
                                            <a href="#">
                                                <i class="ion ion-ios7-people info"></i> 5 new members joined today
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="fa fa-warning danger"></i> Very long description here that may not fit into the page and may cause design problems
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="fa fa-users warning"></i> 5 new members joined
                                            </a>
                                        </li>

                                        <li>
                                            <a href="#">
                                                <i class="ion ion-ios7-cart success"></i> 25 sales made
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="ion ion-ios7-person danger"></i> You changed your username
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="footer"><a href="#">View all</a></li>
                            </ul>
                        </li>
                        <!-- Tasks: style can be found in dropdown.less -->
                        <li class="dropdown tasks-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-tasks"></i>
                                <span class="label label-danger">9</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header">You have 9 tasks</li>
                                <li>
                                    <!-- inner menu: contains the actual data -->
                                    <ul class="menu">
                                        <li><!-- Task item -->
                                            <a href="#">
                                                <h3>
                                                    Design some buttons
                                                    <small class="pull-right">20%</small>
                                                </h3>
                                                <div class="progress xs">
                                                    <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                        <span class="sr-only">20% Complete</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </li><!-- end task item -->
                                        <li><!-- Task item -->
                                            <a href="#">
                                                <h3>
                                                    Create a nice theme
                                                    <small class="pull-right">40%</small>
                                                </h3>
                                                <div class="progress xs">
                                                    <div class="progress-bar progress-bar-green" style="width: 40%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                        <span class="sr-only">40% Complete</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </li><!-- end task item -->
                                        <li><!-- Task item -->
                                            <a href="#">
                                                <h3>
                                                    Some task I need to do
                                                    <small class="pull-right">60%</small>
                                                </h3>
                                                <div class="progress xs">
                                                    <div class="progress-bar progress-bar-red" style="width: 60%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                        <span class="sr-only">60% Complete</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </li><!-- end task item -->
                                        <li><!-- Task item -->
                                            <a href="#">
                                                <h3>
                                                    Make beautiful transitions
                                                    <small class="pull-right">80%</small>
                                                </h3>
                                                <div class="progress xs">
                                                    <div class="progress-bar progress-bar-yellow" style="width: 80%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                        <span class="sr-only">80% Complete</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </li><!-- end task item -->
                                    </ul>
                                </li>
                                <li class="footer">
                                    <a href="#">View all tasks</a>
                                </li>
                            </ul>
                        </li>
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-user"></i>
                                <span>Jane Doe <i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header bg-light-blue">
                                    <img src="../../img/avatar3.png" class="img-circle" alt="User Image" />
                                    <p>
                                        Jane Doe - Web Developer
                                        <small>Member since Nov. 2012</small>
                                    </p>
                                </li>
                                <!-- Menu Body -->
                                <li class="user-body">
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Followers</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Sales</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Friends</a>
                                    </div>
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="#" class="btn btn-default btn-flat">Profile</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="#" class="btn btn-default btn-flat">Sign out</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas">                
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                        <div class="pull-left image">
                            <img src="../../img/avatar3.png" class="img-circle" alt="User Image" />
                        </div>
                        <div class="pull-left info">
                            <p>Hello, Jane</p>

                            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                        </div>
                    </div>
                    <!-- search form -->
                    <form action="#" method="get" class="sidebar-form">
                        <div class="input-group">
                            <input type="text" name="q" class="form-control" placeholder="Search..."/>
                            <span class="input-group-btn">
                                <button type='submit' name='seach' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </form>
                    <!-- /.search form -->
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">
                        <li class="active">
                            <a href="../../index.html">
                                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                            </a>
                        </li>
                        <li>
                            <a href="../widgets.html">
                                <i class="fa fa-th"></i> <span>Widgets</span> <small class="badge pull-right bg-green">new</small>
                            </a>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-bar-chart-o"></i>
                                <span>Charts</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="morris.html"><i class="fa fa-angle-double-right"></i> Morris</a></li>
                                <li><a href="flot.html"><i class="fa fa-angle-double-right"></i> Flot</a></li>
                                <li><a href="inline.html"><i class="fa fa-angle-double-right"></i> Inline charts</a></li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-laptop"></i>
                                <span>UI Elements</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="../UI/general.html"><i class="fa fa-angle-double-right"></i> General</a></li>
                                <li><a href="../UI/icons.html"><i class="fa fa-angle-double-right"></i> Icons</a></li>
                                <li><a href="../UI/buttons.html"><i class="fa fa-angle-double-right"></i> Buttons</a></li>
                                <li><a href="../UI/sliders.html"><i class="fa fa-angle-double-right"></i> Sliders</a></li>
                                <li><a href="../UI/timeline.html"><i class="fa fa-angle-double-right"></i> Timeline</a></li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-edit"></i> <span>Forms</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="../forms/general.html"><i class="fa fa-angle-double-right"></i> General Elements</a></li>
                                <li><a href="../forms/advanced.html"><i class="fa fa-angle-double-right"></i> Advanced Elements</a></li>
                                <li><a href="../forms/editors.html"><i class="fa fa-angle-double-right"></i> Editors</a></li>                                
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-table"></i> <span>Tables</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="../tables/simple.html"><i class="fa fa-angle-double-right"></i> Simple tables</a></li>
                                <li><a href="../tables/data.html"><i class="fa fa-angle-double-right"></i> Data tables</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="../calendar.html">
                                <i class="fa fa-calendar"></i> <span>Calendar</span>
                                <small class="badge pull-right bg-red">3</small>
                            </a>
                        </li>
                        <li>
                            <a href="../mailbox.html">
                                <i class="fa fa-envelope"></i> <span>Mailbox</span>
                                <small class="badge pull-right bg-yellow">12</small>
                            </a>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-folder"></i> <span>Examples</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="../examples/invoice.html"><i class="fa fa-angle-double-right"></i> Invoice</a></li>
                                <li><a href="../examples/login.html"><i class="fa fa-angle-double-right"></i> Login</a></li>
                                <li><a href="../examples/register.html"><i class="fa fa-angle-double-right"></i> Register</a></li>
                                <li><a href="../examples/lockscreen.html"><i class="fa fa-angle-double-right"></i> Lockscreen</a></li>
                                <li><a href="../examples/404.html"><i class="fa fa-angle-double-right"></i> 404 Error</a></li>
                                <li><a href="../examples/500.html"><i class="fa fa-angle-double-right"></i> 500 Error</a></li>                                
                                <li><a href="../examples/blank.html"><i class="fa fa-angle-double-right"></i> Blank Page</a></li>
                            </ul>
                        </li>
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>
            
            <aside class="right-side"> 
                <div class="kpc-bd" id="bd">
                <div class="mod-cz-hd">
            <div class="hd clearfix">
            <div class="cz-logo cz-xssclogo">
            <a href="#"></a>
        </div>
        <h1 class="cz-name">老时时彩 <span> 第<em id="curr_issue"><?php echo $issue ?></em>期</span></h1>
        <ul class="cz-params cz-params-kp">
            <li>
            <span class="k countdown_tag">投注还剩：</span><b>01</b>分<b>15</b>秒</span>            </li>
            <li>
                                 销售：10:00～22:00～02:00（120期）  返奖<b>50%</b>
            </li>
        </ul>
        <span class="label label-important">正在销售</span>
    </div>
    <div class="bd">
        <div class="nav-cz-main clearfix">
            <ul class="main">
                <li class="active"><a href="/ssccqx/">选号投注</a></li>
                <li><a href="/ssccqx/yl">遗漏数据</a></li>
                <li><a href="/ssccqx/ds/">单式上传</a></li>
            </ul>
                        <div class="helper-nav">
                <a href="javascript:;">购彩小助手<i class="ico ico-arrow02"></i></a>
            </div>
                        <ul class="quirk">
                <li><a target="_blank" href="http://chart.cp.360.cn/zst/ssccq/">走势图表</a></li>
                <li class="divider">|</li>
                <li><a target="_blank" href="/shdd/ssccq">杀号定胆</a></li>
                <li class="divider">|</li>
                <li><a id="sd_plays" target="_blank" href="http://bbs.360safe.com/thread-2917077-1-1.html">玩法介绍</a></li>
                <li class="divider">|</li>
                <li><a id="sd_zhongjiang" target="_blank" href="http://bbs.360safe.com/thread-2917123-1-1.html">中奖说明</a></li>
                <li class="divider">|</li>
                <li><a target="_blank" href="/tools/xbeitou?lotid=255401">倍投计算器</a></li>
            </ul>
        </div>
    </div>
</div>

                <div style="overflow: hidden;_padding-bottom: 10px;" class="cz-helper clearfix none">
        <div class="hd clearfix">
            <div class="cz-helper-tit">
                <h3><i class="ico ico-user3"></i>我的老时时彩</h3>
                <span>这里将提醒您近12期购彩、中奖情况</span>
                <span class="c"><a id="my_helper_refresh" href="#">刷新</a> | <a id="my_helper_up" href="#">收起</a> <img src="http://p4.qhimg.com/t01d75074755ea9e041.gif" id="my_loading" style="vertical-align: middle;" class="none"></span>
            </div>
            <div class="cz-helper-fr">
                <span>注：<em>如当期购买多笔订单，则显示当期订单总奖金</em></span>
            </div>
        </div>
        <div class="bd">
            <ul class="lottery-list"></ul>
            <span class="more"><a target="_blank" class="lnk" href="/pfbet/">更多记录</a></span>
        </div>
    </div>
                <div class="mod-cz-bd">
             <div class="nav-cz-sub">
         <ul id="plays" class="clearfix">
                <li zst="false" combo="false" desc="5D"><a href="#">五星</a></li>
        <li zst="true" combo="true" desc="3D"><a href="#">三星</a></li>
        <li zst="true" combo="true" desc="2D"><a href="#">二星</a></li>
        <li zst="true" combo="true" class="active" desc="1D"><a href="#">一星</a></li>
        <li zst="true" combo="false" playtext="大小|单双" desc="DD"><a href="#">大小单双</a></li>
            </ul>
</div>
            <div class="grid-1 clearfix">
                <div class="article">
                   <div class="plays_box">
						<div class="fr-tab">
	<span class="numcount"><i class="ico ico-numtabledown ico-numtableup"></i> 遗漏统计</span><span class="divider ">|</span><span class="chart">近期走势</span>
</div>
<div class="mod-select-filter zx_plays none">
	<label><input type="radio" name="5d" value="5D|五星|直选" desc="&lt;i class='ico ico-info-s'&gt;&lt;/i&gt;&lt;b&gt;玩法提示：&lt;/b&gt;&lt;span&gt;从个、十、百、千、万位各选1个或多个号码，所选号码与开奖号码一一对应，即中奖&lt;em class='red'&gt;100000&lt;/em&gt;元" playtip="&lt;em&gt;选号区&lt;/em&gt;每位至少选择1个号码" autocomplete="off" idx="0" checked="checked"><span>直选</span></label>
	<label><input type="radio" name="5d" value="5T|五星|通选" desc="&lt;i class='ico ico-info-s'&gt;&lt;/i&gt;&lt;b&gt;玩法提示：&lt;/b&gt;&lt;span&gt;从个、十、百、千、万位各选1个或多个号码，所选号码与开奖号码一一对应，兼中兼得，即中奖&lt;em class='red'&gt;20440&lt;br&gt;&lt;/em&gt;元；如所选号码和开奖号码，前三位或后三位一一对应，即中奖&lt;em class='red'&gt;220&lt;/em&gt;元；如前二位或者后二位一一对应，即中奖&lt;em class='red'&gt;20&lt;/em&gt;元" playtip="&lt;em&gt;选号区&lt;/em&gt;每位至少选择1个号码" idx="0" autocomplete="off"><span>通选</span></label>
</div>
<div class="mod-select-filter zx_plays none">
	<label><input type="radio" code="27033" name="3d" value="3D|三星|直选" desc="&lt;i class='ico ico-info-s'&gt;&lt;/i&gt;&lt;b&gt;玩法提示：&lt;/b&gt;&lt;span&gt;从个、十、百位各选1个或多个号码，选号与奖号后三位相同（且顺序一致），即中奖&lt;em class='red'&gt;1000&lt;/em&gt;元" playtip="&lt;em&gt;选号区&lt;/em&gt;每位至少选择1个号码" autocomplete="off" idx="0" checked="checked"><span>直选</span></label>
	<label><input type="radio" code="27452" name="3d" value="Z3|三星|组三" desc="&lt;i class='ico ico-info-s'&gt;&lt;/i&gt;&lt;b&gt;玩法提示：&lt;/b&gt;&lt;span&gt;从0～9中任选2个或多个号码，所选号码与开奖号码后三位号码相同（顺序不限），即中奖&lt;em class='red'&gt;320&lt;/em&gt;元" playtip="&lt;em&gt;选号区&lt;/em&gt;至少选择2个号码" autocomplete="off" idx="1"><span>组三</span></label>
	<label><input type="radio" code="27452" name="3d" value="Z3|三星|组三|胆拖" desc="&lt;i class='ico ico-info-s'&gt;&lt;/i&gt;&lt;b&gt;玩法提示：&lt;/b&gt;&lt;span&gt;选1个胆码、1～9个拖码，胆码加拖码不少于2个，单注奖金&lt;em class='red'&gt;320&lt;/em&gt;元" play="dt" playtip="&lt;em&gt;胆码区&lt;/em&gt;选择1个胆码" autocomplete="off" idx="3"><span>组三胆拖</span></label>
	<label><input type="radio" code="27463" name="3d" value="Z6|三星|组六" desc="&lt;i class='ico ico-info-s'&gt;&lt;/i&gt;&lt;b&gt;玩法提示：&lt;/b&gt;&lt;span&gt;从0～9中任选3个或多个号码，所选号码与开奖号码后三位号码相同（顺序不限），即中奖&lt;em class='red'&gt;160&lt;/em&gt;元" playtip="&lt;em&gt;选号区&lt;/em&gt;至少选择3个号码" autocomplete="off" idx="2"><span>组六</span></label>
	<label><input type="radio" code="27463" name="3d" value="Z6|三星|组六|胆拖" desc="&lt;i class='ico ico-info-s'&gt;&lt;/i&gt;&lt;b&gt;玩法提示：&lt;/b&gt;&lt;span&gt;选1～2个胆码、1～9个拖码，胆码加拖码不少于3个，单注奖金&lt;em class='red'&gt;160&lt;/em&gt;元" play="dt" playtip="&lt;em&gt;胆码区&lt;/em&gt;选1～2个胆码" autocomplete="off" idx="4"><span>组六胆拖</span></label>
</div>
<div class="mod-select-filter zx_plays none">
	<label><input type="radio" code="27032" name="2d" value="2D|二星|直选" desc="&lt;i class='ico ico-info-s'&gt;&lt;/i&gt;&lt;b&gt;玩法提示：&lt;/b&gt;&lt;span&gt;从个、十位各选1个或多个号码，所选号码与开奖号码后两位号码相同（且顺序一致），即中奖&lt;em class='red'&gt;100&lt;/em&gt;元" playtip="&lt;em&gt;选号区&lt;/em&gt;每位至少选择1个号码" autocomplete="off" idx="0" checked="checked"><span>直选</span></label>
	<label><input type="radio" code="27489" name="2d" value="H2|二星|直选和值" desc="&lt;i class='ico ico-info-s'&gt;&lt;/i&gt;&lt;b&gt;玩法提示：&lt;/b&gt;&lt;span&gt;二星和值指个位和十位相加之和，所选和值号码与开奖号码后两位之和相同，即中奖&lt;em class='red'&gt;100&lt;/em&gt;元" playtip="&lt;em&gt;选号区&lt;/em&gt;至少选择1个号码" autocomplete="off" idx="1"><span>直选和值</span></label>
	<label><input type="radio" code="27042" name="2d" value="Z2|二星|组选" desc="&lt;i class='ico ico-info-s'&gt;&lt;/i&gt;&lt;b&gt;玩法提示：&lt;/b&gt;&lt;span&gt;从0～9中选2个或多个号码，选号与奖号后二位相同（顺序不限，不含对子号），即中奖&lt;em class='red'&gt;50&lt;/em&gt;元" playtip="&lt;em&gt;选号区&lt;/em&gt;至少选择2个号码" autocomplete="off" idx="2"><span>组选单式</span></label>
	<label><input type="radio" code="27483" name="2d" value="F2|二星|组选复式" desc="&lt;i class='ico ico-info-s'&gt;&lt;/i&gt;&lt;b&gt;玩法提示：&lt;/b&gt;&lt;span&gt;选3～6个号，选号与奖号后两位相同（顺序不限,不含对子号），即中奖&lt;em class='red'&gt;50&lt;/em&gt;元" playtip="&lt;em&gt;选号区&lt;/em&gt;至少选3个,最多选6个" autocomplete="off" idx="3"><span>组选复式</span></label>
	<label><input type="radio" code="27488" name="2d" value="S2|二星|组选和值" desc="&lt;i class='ico ico-info-s'&gt;&lt;/i&gt;&lt;b&gt;玩法提示：&lt;/b&gt;&lt;span&gt;所选和值号码与开奖号码后两位之和相同，即中奖&lt;em class='red'&gt;50&lt;/em&gt;元，如奖号为对子号，即中奖&lt;em class='red'&gt;100&lt;/em&gt;元" playtip="&lt;em&gt;选号区&lt;/em&gt;至少选择1个号码" autocomplete="off" idx="4"><span>组选和值</span></label>
	<label><input type="radio" code="27042" name="2d" value="Z2|二星|组选|胆拖" desc="&lt;i class='ico ico-info-s'&gt;&lt;/i&gt;&lt;b&gt;玩法提示：&lt;/b&gt;&lt;span&gt;选1个胆码、1～9个拖码，胆码加拖码不少于2个，即中奖&lt;em class='red'&gt;50&lt;/em&gt;元" playtip="&lt;em&gt;选号区&lt;/em&gt;选择1个胆码" autocomplete="off" idx="100"><span>组选胆拖</span></label>
</div>
<div class="mod-select-filter zx_plays">
	<label><input type="radio" code="10005" name="1D" value="1D|一星|直选" autocomplete="off" idx="0" checked="checked"><span>直选</span></label>
</div>
<div class="mod-select-filter zx_plays none">
	<label style="display:none;"><input type="radio" name="zx" value="DD|大小|单双" autocomplete="off" checked="checked"><span>直选</span></label>
</div>

						<div class="mod-select-bolls kpc-select-item">
	<div class="bd clearfix">
		<div style="margin-top: 10px;" class="tools-boll-list yl-combo tools-boll-xssc none ">
			<span style="right:80px;" class="sd"></span>
			<div class="boll-item">
				<div class="k">
					<span class="k1">
						<div class="xssc-select">
								<input type="hidden" value="1D" id="yilou_play_list">
								<span class="txt-box">
									<em class="txt">一星直选</em>
									 <i class="ico"></i>
								</span>
								<ul style="" class="list">
									<li val="1D">一星直选</li>
									<li val="2D">二星直选</li>
									<li val="H2">直选和值</li>
									<li val="Z2">组选单式</li>
									<li val="F2">组选复式</li>
									<li val="S2">组选和值</li>
									<li val="3D">三星直选</li>
									<li val="Z3">三星组三</li>
									<li val="Z6">三星组六</li>
								</ul>
						</div>
					</span>
					<span class="k2">当前遗漏</span>
					<span class="k2 not">最大遗漏</span>
				</div>
				<div class="v">
					<div class="num-list">
						<ul>
							<li><em class="btn-middle">9</em><span class="n red">16</span><span class="n">117</span></li><li><em class="btn-middle">0</em><span class="n red">14</span><span class="n">93</span></li><li><em class="btn-middle">5</em><span class="n red">7</span><span class="n">120</span></li><li><em class="btn-middle">2</em><span class="n red">6</span><span class="n">125</span></li><li><em class="btn-middle">8</em><span class="n red">5</span><span class="n">90</span></li><li><em class="btn-middle">3</em><span class="n red">4</span><span class="n">96</span></li><li><em class="btn-middle">7</em><span class="n red">3</span><span class="n">93</span></li>						</ul>
					</div>
				</div>
			</div>
		</div>
		<div id="mini-zst" style="margin-top: 10px;" class="tools-boll-list tools-boll-chart nonum none"><span class="sd"></span>
<div class="chart-item">
    <div class="hd clearfix">
        <ul class="period-tab"><li type="dww1" class="active"><em>万位</em></li><li type="dww2"><em>千位</em></li><li type="dww3"><em>百位</em></li><li type="dww4"><em>十位</em></li><li type="dww5"><em>个位</em></li></ul>
        <span class="fr chart-filter">
            <label><input type="checkbox" val="yl" class="ipt-c c-yilou">遗漏数据</label>
            <label><input type="checkbox" val="fc" class="ipt-c c-fenceng">遗漏分层</label><label><input type="checkbox" val="zx" class="ipt-c c-line">折线</label></span>
    </div>
    <div class="chart-tab">
        <table width="100%" class="chart-table">
            <thead>
                <tr><th width="60" class="brt">期号</th><th width="45" class="brt">奖号</th><th width="22">0</th><th width="22">1</th><th width="22">2</th><th width="22">3</th><th width="22">4</th><th width="22">5</th><th width="22">6</th><th width="22">7</th><th width="22">8</th><th width="22" class="brt">9</th><th width="22">大</th><th width="22" class="brt">小</th><th width="22">奇</th><th width="22" class="brt">偶</th><th width="22">升</th><th width="22">平</th><th width="22" class="">降</th></tr>
            </thead>
            <tbody id="yilou_zst_chart"><tr><td class="brt">069</td><td class="brt"><b class="red">77751</b></td><td class="tdbg_8">4</td><td class="tdbg_8">15</td><td class="tdbg_8">2</td><td class="tdbg_8">9</td><td class="tdbg_8">1</td><td class="tdbg_8">13</td><td class="tdbg_8">6</td><td hit="" class="tdbg_2"><span class="ball ball_5">7</span></td><td class="tdbg_8">10</td><td class="tdbg_8 brt">8</td><td hit="" class="tdbg_2"><span class="ball ball_17">大</span></td><td class="tdbg_8 brt">1</td><td hit="" class="tdbg_2"><span class="ball ball_1">奇</span></td><td class="tdbg_8 brt">1</td><td hit="" class="tdbg_2"><span class="ball ball_2">升</span></td><td class="tdbg_8">2</td><td class="tdbg_8 ">4</td></tr><tr><td class="brt">070</td><td class="brt"><b class="red">34377</b></td><td class="tdbg_8">5</td><td class="tdbg_8">16</td><td class="tdbg_8">3</td><td hit="" class="tdbg_2"><span class="ball ball_5">3</span></td><td class="tdbg_8">2</td><td class="tdbg_8">14</td><td class="tdbg_8">7</td><td class="tdbg_8">1</td><td class="tdbg_8">11</td><td class="tdbg_8 brt">9</td><td class="tdbg_8">1</td><td hit="" class="tdbg_2 brt"><span class="ball ball_17">小</span></td><td hit="" class="tdbg_2"><span class="ball ball_1">奇</span></td><td class="tdbg_8 brt">2</td><td class="tdbg_8">1</td><td class="tdbg_8">3</td><td hit="" class="tdbg_2 "><span class="ball ball_2">降</span></td></tr><tr><td class="brt">071</td><td class="brt"><b class="red">65325</b></td><td class="tdbg_8">6</td><td class="tdbg_8">17</td><td class="tdbg_8">4</td><td class="tdbg_8">1</td><td class="tdbg_8">3</td><td class="tdbg_8">15</td><td hit="" class="tdbg_2"><span class="ball ball_5">6</span></td><td class="tdbg_8">2</td><td class="tdbg_8">12</td><td class="tdbg_8 brt">10</td><td hit="" class="tdbg_2"><span class="ball ball_17">大</span></td><td class="tdbg_8 brt">1</td><td class="tdbg_8">1</td><td hit="" class="tdbg_2 brt"><span class="ball ball_1">偶</span></td><td hit="" class="tdbg_2"><span class="ball ball_2">升</span></td><td class="tdbg_8">4</td><td class="tdbg_8 ">1</td></tr><tr><td class="brt">072</td><td class="brt"><b class="red">03682</b></td><td hit="" class="tdbg_2"><span class="ball ball_5">0</span></td><td class="tdbg_8">18</td><td class="tdbg_8">5</td><td class="tdbg_8">2</td><td class="tdbg_8">4</td><td class="tdbg_8">16</td><td class="tdbg_8">1</td><td class="tdbg_8">3</td><td class="tdbg_8">13</td><td class="tdbg_8 brt">11</td><td class="tdbg_8">1</td><td hit="" class="tdbg_2 brt"><span class="ball ball_17">小</span></td><td class="tdbg_8">2</td><td hit="" class="tdbg_2 brt"><span class="ball ball_1">偶</span></td><td class="tdbg_8">1</td><td class="tdbg_8">5</td><td hit="" class="tdbg_2 "><span class="ball ball_2">降</span></td></tr><tr><td class="brt">073</td><td class="brt"><b class="red">89098</b></td><td class="tdbg_8">1</td><td class="tdbg_8">19</td><td class="tdbg_8">6</td><td class="tdbg_8">3</td><td class="tdbg_8">5</td><td class="tdbg_8">17</td><td class="tdbg_8">2</td><td class="tdbg_8">4</td><td hit="" class="tdbg_2"><span class="ball ball_5">8</span></td><td class="tdbg_8 brt">12</td><td hit="" class="tdbg_2"><span class="ball ball_17">大</span></td><td class="tdbg_8 brt">1</td><td class="tdbg_8">3</td><td hit="" class="tdbg_2 brt"><span class="ball ball_1">偶</span></td><td hit="" class="tdbg_2"><span class="ball ball_2">升</span></td><td class="tdbg_8">6</td><td class="tdbg_8 ">1</td></tr><tr><td class="brt">074</td><td class="brt"><b class="red">73763</b></td><td class="tdbg_8">2</td><td class="tdbg_8">20</td><td class="tdbg_8">7</td><td class="tdbg_8">4</td><td class="tdbg_8">6</td><td class="tdbg_8">18</td><td class="tdbg_8">3</td><td hit="" class="tdbg_2"><span class="ball ball_5">7</span></td><td class="tdbg_8">1</td><td class="tdbg_8 brt">13</td><td hit="" class="tdbg_2"><span class="ball ball_17">大</span></td><td class="tdbg_8 brt">2</td><td hit="" class="tdbg_2"><span class="ball ball_1">奇</span></td><td class="tdbg_8 brt">1</td><td class="tdbg_8">1</td><td class="tdbg_8">7</td><td hit="" class="tdbg_2 "><span class="ball ball_2">降</span></td></tr><tr><td class="brt">075</td><td class="brt"><b class="red">81647</b></td><td class="tdbg_8">3</td><td class="tdbg_8">21</td><td class="tdbg_8">8</td><td class="tdbg_8">5</td><td class="tdbg_8">7</td><td class="tdbg_8">19</td><td class="tdbg_8">4</td><td class="tdbg_8">1</td><td hit="" class="tdbg_2"><span class="ball ball_5">8</span></td><td class="tdbg_8 brt">14</td><td hit="" class="tdbg_2"><span class="ball ball_17">大</span></td><td class="tdbg_8 brt">3</td><td class="tdbg_8">1</td><td hit="" class="tdbg_2 brt"><span class="ball ball_1">偶</span></td><td hit="" class="tdbg_2"><span class="ball ball_2">升</span></td><td class="tdbg_8">8</td><td class="tdbg_8 ">1</td></tr><tr><td class="brt">076</td><td class="brt"><b class="red">25451</b></td><td class="tdbg_8">4</td><td class="tdbg_8">22</td><td hit="" class="tdbg_2"><span class="ball ball_5">2</span></td><td class="tdbg_8">6</td><td class="tdbg_8">8</td><td class="tdbg_8">20</td><td class="tdbg_8">5</td><td class="tdbg_8">2</td><td class="tdbg_8">1</td><td class="tdbg_8 brt">15</td><td class="tdbg_8">1</td><td hit="" class="tdbg_2 brt"><span class="ball ball_17">小</span></td><td class="tdbg_8">2</td><td hit="" class="tdbg_2 brt"><span class="ball ball_1">偶</span></td><td class="tdbg_8">1</td><td class="tdbg_8">9</td><td hit="" class="tdbg_2 "><span class="ball ball_2">降</span></td></tr><tr><td class="brt">077</td><td class="brt"><b class="red">93256</b></td><td class="tdbg_8">5</td><td class="tdbg_8">23</td><td class="tdbg_8">1</td><td class="tdbg_8">7</td><td class="tdbg_8">9</td><td class="tdbg_8">21</td><td class="tdbg_8">6</td><td class="tdbg_8">3</td><td class="tdbg_8">2</td><td hit="" class="tdbg_2 brt"><span class="ball ball_5">9</span></td><td hit="" class="tdbg_2"><span class="ball ball_17">大</span></td><td class="tdbg_8 brt">1</td><td hit="" class="tdbg_2"><span class="ball ball_1">奇</span></td><td class="tdbg_8 brt">1</td><td hit="" class="tdbg_2"><span class="ball ball_2">升</span></td><td class="tdbg_8">10</td><td class="tdbg_8 ">1</td></tr><tr><td class="brt">078</td><td class="brt"><b class="red">98434</b></td><td class="tdbg_8">6</td><td class="tdbg_8">24</td><td class="tdbg_8">2</td><td class="tdbg_8">8</td><td class="tdbg_8">10</td><td class="tdbg_8">22</td><td class="tdbg_8">7</td><td class="tdbg_8">4</td><td class="tdbg_8">3</td><td hit="" class="tdbg_2 brt"><span class="ball ball_5">9</span></td><td hit="" class="tdbg_2"><span class="ball ball_17">大</span></td><td class="tdbg_8 brt">2</td><td hit="" class="tdbg_2"><span class="ball ball_1">奇</span></td><td class="tdbg_8 brt">2</td><td class="tdbg_8">1</td><td hit="" class="tdbg_2"><span class="ball ball_2">平</span></td><td class="tdbg_8 ">2</td></tr></tbody>
            </table>
        <div id="chart-svg" class="chart-svg"></div>
    </div>
</div></div>
	</div>
</div>
<!-- {{普通投注 -->
                    <div class="plays none plays_area_5d" style="display: none;">
                    <div class="mod-select-info">
	<p class="plays-memo"><i class="ico ico-info-s"></i><b>玩法提示：</b><span>从个、十、百、千、万位各选1个或多个号码，所选号码与开奖号码一一对应，即中奖<em class="red">100000</em>元</span></p>
</div>
<div class="mod-select-bolls code_box">
	<div class="hd">
		<h3 class="clearfix">
			<span class="t1 play_tips"><em>选号区</em>每位至少选择1个号码</span><span class="t2"><em>操作区</em>快捷选号</span>
		</h3>
	</div>
	<div class="bd">
		<div class="tools-boll-list ">
			<div class="boll-item boll-item-col3 sd_zx_5d">
				<div class="k">
					<span class="k1">万位<span class="caret"></span></span>
					<span class="k2">遗漏</span>
				</div>
				<div class="v">
					<div onselectstart="return false;" unselectable="on" class="boll-list">
						<ul class="clearfix">
							<li><em class="btn-boll">0</em><span>6</span></li><li><em class="btn-boll">1</em><span class="red">24</span></li><li><em class="btn-boll">2</em><span>2</span></li><li><em class="btn-boll">3</em><span>8</span></li><li><em class="btn-boll">4</em><span>10</span></li><li><em class="btn-boll">5</em><span>22</span></li><li><em class="btn-boll">6</em><span>7</span></li><li><em class="btn-boll">7</em><span>4</span></li><li><em class="btn-boll">8</em><span>3</span></li><li><em class="btn-boll">9</em><span>0</span></li>						</ul>
					</div>
				</div>
				 <div class="t">
    <div class="tool-list">
        <ul class="clearfix dxjo">
            <li><a class="btn btn-middle" href="#">全</a></li>
            <li><a class="btn btn-middle" href="#">大</a></li>
            <li><a class="btn btn-middle" href="#">小</a></li>
            <li><a class="btn btn-middle" href="#">奇</a></li>
            <li><a class="btn btn-middle" href="#">偶</a></li>
            <li><a class="lnk" href="#">清除</a></li>
        </ul>
    </div>
</div>

			</div>
			<div class="boll-item boll-item-col3 sd_zx_5d">
				<div class="k">
					<span class="k1">千位<span class="caret"></span></span>
				</div>
				<div class="v">
					<div onselectstart="return false;" unselectable="on" class="boll-list">
						<ul class="clearfix">
							<li><em class="btn-boll">0</em><span class="red">36</span></li><li><em class="btn-boll">1</em><span>3</span></li><li><em class="btn-boll">2</em><span>12</span></li><li><em class="btn-boll">3</em><span>1</span></li><li><em class="btn-boll">4</em><span>8</span></li><li><em class="btn-boll">5</em><span>2</span></li><li><em class="btn-boll">6</em><span>16</span></li><li><em class="btn-boll">7</em><span>9</span></li><li><em class="btn-boll">8</em><span>0</span></li><li><em class="btn-boll">9</em><span>5</span></li>						</ul>
					</div>
				</div>
				 <div class="t">
    <div class="tool-list">
        <ul class="clearfix dxjo">
            <li><a class="btn btn-middle" href="#">全</a></li>
            <li><a class="btn btn-middle" href="#">大</a></li>
            <li><a class="btn btn-middle" href="#">小</a></li>
            <li><a class="btn btn-middle" href="#">奇</a></li>
            <li><a class="btn btn-middle" href="#">偶</a></li>
            <li><a class="lnk" href="#">清除</a></li>
        </ul>
    </div>
</div>

			</div>
			<div class="boll-item boll-item-col3 sd_zx_5d">
				<div class="k">
					<span class="k1">百位<span class="caret"></span></span>
				</div>
				<div class="v">
					<div class="boll-list">
						<ul class="clearfix">
							<li><em class="btn-boll">0</em><span>5</span></li><li><em class="btn-boll">1</em><span>21</span></li><li><em class="btn-boll">2</em><span>1</span></li><li><em class="btn-boll">3</em><span>7</span></li><li><em class="btn-boll">4</em><span>0</span></li><li><em class="btn-boll">5</em><span>17</span></li><li><em class="btn-boll">6</em><span>3</span></li><li><em class="btn-boll">7</em><span>4</span></li><li><em class="btn-boll">8</em><span>13</span></li><li><em class="btn-boll">9</em><span class="red">28</span></li>						</ul>
					</div>
				</div>
				 <div class="t">
    <div class="tool-list">
        <ul class="clearfix dxjo">
            <li><a class="btn btn-middle" href="#">全</a></li>
            <li><a class="btn btn-middle" href="#">大</a></li>
            <li><a class="btn btn-middle" href="#">小</a></li>
            <li><a class="btn btn-middle" href="#">奇</a></li>
            <li><a class="btn btn-middle" href="#">偶</a></li>
            <li><a class="lnk" href="#">清除</a></li>
        </ul>
    </div>
</div>

			 </div>
			<div class="boll-item boll-item-col3 sd_zx_5d">
				<div class="k">
					<span class="k1">十位<span class="caret"></span></span>
				</div>
				<div class="v">
					<div onselectstart="return false;" unselectable="on" class="boll-list">
						<ul class="clearfix">
							<li><em class="btn-boll">0</em><span>12</span></li><li><em class="btn-boll">1</em><span class="red">33</span></li><li><em class="btn-boll">2</em><span>7</span></li><li><em class="btn-boll">3</em><span>0</span></li><li><em class="btn-boll">4</em><span>3</span></li><li><em class="btn-boll">5</em><span>1</span></li><li><em class="btn-boll">6</em><span>4</span></li><li><em class="btn-boll">7</em><span>8</span></li><li><em class="btn-boll">8</em><span>6</span></li><li><em class="btn-boll">9</em><span>5</span></li>						</ul>
					</div>
				</div>
				 <div class="t">
    <div class="tool-list">
        <ul class="clearfix dxjo">
            <li><a class="btn btn-middle" href="#">全</a></li>
            <li><a class="btn btn-middle" href="#">大</a></li>
            <li><a class="btn btn-middle" href="#">小</a></li>
            <li><a class="btn btn-middle" href="#">奇</a></li>
            <li><a class="btn btn-middle" href="#">偶</a></li>
            <li><a class="lnk" href="#">清除</a></li>
        </ul>
    </div>
</div>

			</div>
			<div class="boll-item boll-item-col3 sd_zx_5d">
				<div class="k">
					<span class="k1">个位<span class="caret"></span></span>
				</div>
				<div class="v">
					<div onselectstart="return false;" unselectable="on" class="boll-list">
						<ul class="clearfix">
							<li><em class="btn-boll">0</em><span>14</span></li><li><em class="btn-boll">1</em><span>2</span></li><li><em class="btn-boll">2</em><span>6</span></li><li><em class="btn-boll">3</em><span>4</span></li><li><em class="btn-boll">4</em><span>0</span></li><li><em class="btn-boll">5</em><span>7</span></li><li><em class="btn-boll">6</em><span>1</span></li><li><em class="btn-boll">7</em><span>3</span></li><li><em class="btn-boll">8</em><span>5</span></li><li><em class="btn-boll">9</em><span class="red">16</span></li>						</ul>
					</div>
				</div>
				 <div class="t">
    <div class="tool-list">
        <ul class="clearfix dxjo">
            <li><a class="btn btn-middle" href="#">全</a></li>
            <li><a class="btn btn-middle" href="#">大</a></li>
            <li><a class="btn btn-middle" href="#">小</a></li>
            <li><a class="btn btn-middle" href="#">奇</a></li>
            <li><a class="btn btn-middle" href="#">偶</a></li>
            <li><a class="lnk" href="#">清除</a></li>
        </ul>
    </div>
</div>

			</div>
		 </div>
		<div class="ft">
    <p class="sel_info">您选了 <b>0</b> 注，共 <b>0</b> 元  <em></em></p>
</div>

	</div>
</div>


                    </div>
<!-- 普通投注}} -->
                    <div class="plays none plays_area_3d" style="display: none;">
                    <div class="mod-select-info">
	<p class="plays-memo" id="zx_sm"><i class="ico ico-info-s"></i><b>玩法提示：</b><span>从个、十、百位各选1个或多个号码，选号与奖号后三位相同（且顺序一致），即中奖<em class="red">1000</em>元</span></p>
</div>
<div class="mod-select-bolls code_box">
	<div class="hd">
		<h3 class="clearfix">
			<span class="t1 play_tips"><em>选号区</em>每位至少选择1个号码</span><span class="t2"><em>操作区</em>快捷选号</span>
		</h3>
	</div>
	<div class="bd">
		<div class="tools-boll-list">
			<div class="boll-item boll-item-col3 sd_zx_3d">
				<div class="k">
					<span class="k1">百位<span class="caret"></span></span>
					<span class="k2">遗漏</span>
				</div>
				<div class="v">
					<div class="boll-list">
						<ul class="clearfix">
							<li><em class="btn-boll">0</em><span>5</span></li><li><em class="btn-boll">1</em><span>21</span></li><li><em class="btn-boll">2</em><span>1</span></li><li><em class="btn-boll">3</em><span>7</span></li><li><em class="btn-boll">4</em><span>0</span></li><li><em class="btn-boll">5</em><span>17</span></li><li><em class="btn-boll">6</em><span>3</span></li><li><em class="btn-boll">7</em><span>4</span></li><li><em class="btn-boll">8</em><span>13</span></li><li><em class="btn-boll">9</em><span class="red">28</span></li>						</ul>
					</div>
				</div>
				 <div class="t">
    <div class="tool-list">
        <ul class="clearfix dxjo">
            <li><a class="btn btn-middle" href="#">全</a></li>
            <li><a class="btn btn-middle" href="#">大</a></li>
            <li><a class="btn btn-middle" href="#">小</a></li>
            <li><a class="btn btn-middle" href="#">奇</a></li>
            <li><a class="btn btn-middle" href="#">偶</a></li>
            <li><a class="lnk" href="#">清除</a></li>
        </ul>
    </div>
</div>

			 </div>
			<div class="boll-item boll-item-col3 sd_zx_3d">
				<div class="k">
					<span class="k1">十位<span class="caret"></span></span>
				</div>
				<div class="v">
					<div onselectstart="return false;" unselectable="on" class="boll-list">
						<ul class="clearfix">
							<li><em class="btn-boll">0</em><span>12</span></li><li><em class="btn-boll">1</em><span class="red">33</span></li><li><em class="btn-boll">2</em><span>7</span></li><li><em class="btn-boll">3</em><span>0</span></li><li><em class="btn-boll">4</em><span>3</span></li><li><em class="btn-boll">5</em><span>1</span></li><li><em class="btn-boll">6</em><span>4</span></li><li><em class="btn-boll">7</em><span>8</span></li><li><em class="btn-boll">8</em><span>6</span></li><li><em class="btn-boll">9</em><span>5</span></li>						</ul>
					</div>
				</div>
				 <div class="t">
    <div class="tool-list">
        <ul class="clearfix dxjo">
            <li><a class="btn btn-middle" href="#">全</a></li>
            <li><a class="btn btn-middle" href="#">大</a></li>
            <li><a class="btn btn-middle" href="#">小</a></li>
            <li><a class="btn btn-middle" href="#">奇</a></li>
            <li><a class="btn btn-middle" href="#">偶</a></li>
            <li><a class="lnk" href="#">清除</a></li>
        </ul>
    </div>
</div>

			</div>
			<div class="boll-item boll-item-col3 sd_zx_3d">
				<div class="k">
					<span class="k1">个位<span class="caret"></span></span>
				</div>
				<div class="v">
					<div onselectstart="return false;" unselectable="on" class="boll-list">
						<ul class="clearfix">
							<li><em class="btn-boll">0</em><span>14</span></li><li><em class="btn-boll">1</em><span>2</span></li><li><em class="btn-boll">2</em><span>6</span></li><li><em class="btn-boll">3</em><span>4</span></li><li><em class="btn-boll">4</em><span>0</span></li><li><em class="btn-boll">5</em><span>7</span></li><li><em class="btn-boll">6</em><span>1</span></li><li><em class="btn-boll">7</em><span>3</span></li><li><em class="btn-boll">8</em><span>5</span></li><li><em class="btn-boll">9</em><span class="red">16</span></li>						</ul>
					</div>
				</div>
				 <div class="t">
    <div class="tool-list">
        <ul class="clearfix dxjo">
            <li><a class="btn btn-middle" href="#">全</a></li>
            <li><a class="btn btn-middle" href="#">大</a></li>
            <li><a class="btn btn-middle" href="#">小</a></li>
            <li><a class="btn btn-middle" href="#">奇</a></li>
            <li><a class="btn btn-middle" href="#">偶</a></li>
            <li><a class="lnk" href="#">清除</a></li>
        </ul>
    </div>
</div>

			</div>
			<div class="boll-item boll-item-col3 sd_zx_z3 sd_zx_z6 none">
				<div class="k">
					<span class="k1">号码<span class="caret"></span></span>
					<span class="k2">遗漏</span>
				</div>
				<div class="v">
					<div onselectstart="return false;" unselectable="on" class="boll-list">
						<ul class="clearfix">
							<li><em class="btn-boll">0</em><span class="red">5</span></li><li><em class="btn-boll">1</em><span>2</span></li><li><em class="btn-boll">2</em><span>1</span></li><li><em class="btn-boll">3</em><span>0</span></li><li><em class="btn-boll">4</em><span>0</span></li><li><em class="btn-boll">5</em><span>1</span></li><li><em class="btn-boll">6</em><span>1</span></li><li><em class="btn-boll">7</em><span>3</span></li><li><em class="btn-boll">8</em><span class="red">5</span></li><li><em class="btn-boll">9</em><span class="red">5</span></li>						</ul>
					</div>
				</div>
				 <div class="t">
    <div class="tool-list">
        <ul class="clearfix dxjo">
            <li><a class="btn btn-middle" href="#">全</a></li>
            <li><a class="btn btn-middle" href="#">大</a></li>
            <li><a class="btn btn-middle" href="#">小</a></li>
            <li><a class="btn btn-middle" href="#">奇</a></li>
            <li><a class="btn btn-middle" href="#">偶</a></li>
            <li><a class="lnk" href="#">清除</a></li>
        </ul>
    </div>
</div>

			</div>
		 </div>
		<div class="ft">
    <p class="sel_info">您选了 <b>0</b> 注，共 <b>0</b> 元  <em></em></p>
</div>

	</div>
</div>
<div class="mod-select-bolls code_box none">
	<div class="hd">
		<h3 class="clearfix">
			<span style="margin-left: -210px;" class="t1 play_tips"><em>胆码区</em>选择1个胆码</span>
		</h3>
	</div>
	<div class="bd">
		<div class="tools-boll-list">
			<div class="boll-item boll-item-col3 sd_dt_3d sd_zx_z6 sd_zx_z3">
				<div class="k">
					<span class="k1">胆码<span class="caret"></span></span>
					<span class="k2">遗漏</span>
				</div>
				<div class="v">
					<div class="boll-list">
						<ul class="clearfix">
							<li><em class="btn-boll">0</em><span>5</span></li><li><em class="btn-boll">1</em><span>21</span></li><li><em class="btn-boll">2</em><span>1</span></li><li><em class="btn-boll">3</em><span>7</span></li><li><em class="btn-boll">4</em><span>0</span></li><li><em class="btn-boll">5</em><span>17</span></li><li><em class="btn-boll">6</em><span>3</span></li><li><em class="btn-boll">7</em><span>4</span></li><li><em class="btn-boll">8</em><span>13</span></li><li><em class="btn-boll">9</em><span class="red">28</span></li>						</ul>
					</div>
				</div>
			 </div>
	   </div>
	</div>
	<div class="hd">
		<h3 class="clearfix">
			<span style="width: 325px;" class="t1"><em>拖码区</em>至少选择1个拖码</span><span class="t2"><em>操作区</em>快捷选号</span>
		</h3>
	</div>
	<div class="bd">
		<div class="tools-boll-list">
			<div class="boll-item boll-item-col3 sd_dt_3d  sd_zx_z6 sd_zx_z3">
				<div class="k">
					<span class="k1">拖码<span class="caret"></span></span>
					<span class="k2">遗漏</span>
				</div>
				<div class="v">
					<div class="boll-list">
						<ul class="clearfix">
							<li><em class="btn-boll">0</em><span>5</span></li><li><em class="btn-boll">1</em><span>21</span></li><li><em class="btn-boll">2</em><span>1</span></li><li><em class="btn-boll">3</em><span>7</span></li><li><em class="btn-boll">4</em><span>0</span></li><li><em class="btn-boll">5</em><span>17</span></li><li><em class="btn-boll">6</em><span>3</span></li><li><em class="btn-boll">7</em><span>4</span></li><li><em class="btn-boll">8</em><span>13</span></li><li><em class="btn-boll">9</em><span class="red">28</span></li>						</ul>
					</div>
				</div>
				<div style="width: 110px;" class="t">
					<div class="tool-list">
						<ul class="clearfix dxjo">
							<li><a class="btn btn-middle dt-qb" href="#">拖码全包</a></li>
							<li><a class="lnk dt-qb-clr" href="#">清除</a></li>
						</ul>
					</div>
			   </div>
			 </div>
	   </div>
		<div class="ft">
    <p class="sel_info">您选了 <b>0</b> 注，共 <b>0</b> 元  <em></em></p>
</div>

	</div>
</div>

                    </div>
                    <div class="plays none plays_area_2d" style="display: none;">
                    <div class="mod-select-info">
	<p class="plays-memo" id="zx_sm"><i class="ico ico-info-s"></i><b>玩法提示：</b><span>从个、十位各选1个或多个号码，所选号码与开奖号码后两位号码相同（且顺序一致），即中奖<em class="red">100</em>元</span></p>
</div>
<div class="mod-select-bolls sd_2d_1">
	<div class="hd">
		<h3 class="clearfix">
			<span class="t1 play_tips"><em>选号区</em>每位至少选择1个号码</span><span class="t2"><em>操作区</em>快捷选号</span>
		</h3>
	</div>
	<div class="bd">
		<div class="tools-boll-list code_box">
			<div class="boll-item boll-item-col3 sd_zx_2d">
				<div class="k">
					<span class="k1">十位<span class="caret"></span></span>
					 <span class="k2">遗漏</span>
				</div>
				<div class="v">
					<div onselectstart="return false;" unselectable="on" class="boll-list">
						<ul class="clearfix">
							<li><em class="btn-boll">0</em><span>12</span></li><li><em class="btn-boll">1</em><span class="red">33</span></li><li><em class="btn-boll">2</em><span>7</span></li><li><em class="btn-boll">3</em><span>0</span></li><li><em class="btn-boll">4</em><span>3</span></li><li><em class="btn-boll">5</em><span>1</span></li><li><em class="btn-boll">6</em><span>4</span></li><li><em class="btn-boll">7</em><span>8</span></li><li><em class="btn-boll">8</em><span>6</span></li><li><em class="btn-boll">9</em><span>5</span></li>						</ul>
					</div>
				</div>
				 <div class="t">
    <div class="tool-list">
        <ul class="clearfix dxjo">
            <li><a class="btn btn-middle" href="#">全</a></li>
            <li><a class="btn btn-middle" href="#">大</a></li>
            <li><a class="btn btn-middle" href="#">小</a></li>
            <li><a class="btn btn-middle" href="#">奇</a></li>
            <li><a class="btn btn-middle" href="#">偶</a></li>
            <li><a class="lnk" href="#">清除</a></li>
        </ul>
    </div>
</div>

			</div>
			<div class="boll-item boll-item-col3 sd_zx_2d">
				<div class="k">
					<span class="k1">个位<span class="caret"></span></span>
				</div>
				<div class="v">
					<div onselectstart="return false;" unselectable="on" class="boll-list">
						<ul class="clearfix">
							<li><em class="btn-boll">0</em><span>14</span></li><li><em class="btn-boll">1</em><span>2</span></li><li><em class="btn-boll">2</em><span>6</span></li><li><em class="btn-boll">3</em><span>4</span></li><li><em class="btn-boll">4</em><span>0</span></li><li><em class="btn-boll">5</em><span>7</span></li><li><em class="btn-boll">6</em><span>1</span></li><li><em class="btn-boll">7</em><span>3</span></li><li><em class="btn-boll">8</em><span>5</span></li><li><em class="btn-boll">9</em><span class="red">16</span></li>						</ul>
					</div>
				</div>
				 <div class="t">
    <div class="tool-list">
        <ul class="clearfix dxjo">
            <li><a class="btn btn-middle" href="#">全</a></li>
            <li><a class="btn btn-middle" href="#">大</a></li>
            <li><a class="btn btn-middle" href="#">小</a></li>
            <li><a class="btn btn-middle" href="#">奇</a></li>
            <li><a class="btn btn-middle" href="#">偶</a></li>
            <li><a class="lnk" href="#">清除</a></li>
        </ul>
    </div>
</div>

			</div>
			<div class="boll-item boll-item-col3 sd_zx_f2 sd_zx_z2 none">
				<div class="k">
					<span class="k1">号码<span class="caret"></span></span>
					<span class="k2">遗漏</span>
				</div>
				<div class="v">
					<div onselectstart="return false;" unselectable="on" class="boll-list">
						<ul class="clearfix">
							<li><em class="btn-boll">0</em><span class="red">12</span></li><li><em class="btn-boll">1</em><span>2</span></li><li><em class="btn-boll">2</em><span>6</span></li><li><em class="btn-boll">3</em><span>0</span></li><li><em class="btn-boll">4</em><span>0</span></li><li><em class="btn-boll">5</em><span>1</span></li><li><em class="btn-boll">6</em><span>1</span></li><li><em class="btn-boll">7</em><span>3</span></li><li><em class="btn-boll">8</em><span>5</span></li><li><em class="btn-boll">9</em><span>5</span></li>						</ul>
					</div>
				</div>
				 <div class="t">
    <div class="tool-list">
        <ul class="clearfix dxjo">
            <li><a class="btn btn-middle" href="#">全</a></li>
            <li><a class="btn btn-middle" href="#">大</a></li>
            <li><a class="btn btn-middle" href="#">小</a></li>
            <li><a class="btn btn-middle" href="#">奇</a></li>
            <li><a class="btn btn-middle" href="#">偶</a></li>
            <li><a class="lnk" href="#">清除</a></li>
        </ul>
    </div>
</div>

			</div>
		 </div>
		<div class="ft">
    <p class="sel_info">您选了 <b>0</b> 注，共 <b>0</b> 元  <em></em></p>
</div>

	</div>
</div>
<div class="mod-select-bolls sd_2d_2 none ">
	<div class="hd">
		<h3 class="clearfix">
			<span class="t1 play_tips"><em>选号区</em>至少选择1个号码</span>
		</h3>
	</div>
	<div class="bd">
		<div class="tools-boll-list code_box">
			<div class="boll-item boll-item-col3 sd_zx_h2">
				<div class="k">
					<span class="k1">和值<span class="caret"></span></span>
					<span class="k2">遗漏</span>
				</div>
				<div style="width: 575px;" class="v">
					<div onselectstart="return false;" unselectable="on" class="boll-list">
						<ul class="clearfix">
							<li><em class="btn-boll">0</em><span>25</span></li><li><em class="btn-boll">1</em><span>41</span></li><li><em class="btn-boll">2</em><span>49</span></li><li><em class="btn-boll">3</em><span class="red">98</span></li><li><em class="btn-boll">4</em><span>12</span></li><li><em class="btn-boll">5</em><span>55</span></li><li><em class="btn-boll">6</em><span>2</span></li><li><em class="btn-boll">7</em><span>0</span></li><li><em class="btn-boll">8</em><span>17</span></li><li><em class="btn-boll">9</em><span>4</span></li><li><em class="btn-boll">10</em><span>6</span></li><li><em class="btn-boll">11</em><span>1</span></li><li><em class="btn-boll">12</em><span>13</span></li><li><em class="btn-boll">13</em><span>23</span></li><li><em class="btn-boll">14</em><span>8</span></li><li><em class="btn-boll">15</em><span>83</span></li><li><em class="btn-boll">16</em><span>16</span></li><li><em class="btn-boll">17</em><span>5</span></li><li><em class="btn-boll">18</em><span>73</span></li>						</ul>
					</div>
				</div>
			</div>
		 </div>
		<div class="ft">
    <p class="sel_info">您选了 <b>0</b> 注，共 <b>0</b> 元  <em></em></p>
</div>

	</div>
</div>
  <div class="mod-select-bolls sd_2d_3 none">
	<div class="hd">
		<h3 class="clearfix">
			<span style="margin-left: -210px;" class="t1 play_tips"><em>胆码区</em>选择1个胆码</span>
		</h3>
	</div>
	<div class="bd">
		<div class="tools-boll-list">
			<div class="boll-item boll-item-col3 sd_dt_2d sd_zx_z2">
				<div class="k">
					<span class="k1">胆码<span class="caret"></span></span>
					<span class="k2">遗漏</span>
				</div>
				<div class="v">
					<div class="boll-list">
						<ul class="clearfix">
						   <li><em class="btn-boll">0</em><span class="red">12</span></li><li><em class="btn-boll">1</em><span>2</span></li><li><em class="btn-boll">2</em><span>6</span></li><li><em class="btn-boll">3</em><span>0</span></li><li><em class="btn-boll">4</em><span>0</span></li><li><em class="btn-boll">5</em><span>1</span></li><li><em class="btn-boll">6</em><span>1</span></li><li><em class="btn-boll">7</em><span>3</span></li><li><em class="btn-boll">8</em><span>5</span></li><li><em class="btn-boll">9</em><span>5</span></li>						</ul>
					</div>
				</div>
			 </div>
	   </div>
	</div>
	<div class="hd">
		<h3 class="clearfix">
			<span style="width: 325px;" class="t1"><em>拖码区</em>至少选择1个拖码</span><span class="t2"><em>操作区</em>快捷选号</span>
		</h3>
	</div>
	<div class="bd">
		<div class="tools-boll-list">
			<div class="boll-item boll-item-col3 sd_dt_2d sd_zx_z2">
				<div class="k">
					<span class="k1">拖码<span class="caret"></span></span>
					<span class="k2">遗漏</span>
				</div>
				<div class="v">
					<div class="boll-list">
						<ul class="clearfix">
							<li><em class="btn-boll">0</em><span class="red">12</span></li><li><em class="btn-boll">1</em><span>2</span></li><li><em class="btn-boll">2</em><span>6</span></li><li><em class="btn-boll">3</em><span>0</span></li><li><em class="btn-boll">4</em><span>0</span></li><li><em class="btn-boll">5</em><span>1</span></li><li><em class="btn-boll">6</em><span>1</span></li><li><em class="btn-boll">7</em><span>3</span></li><li><em class="btn-boll">8</em><span>5</span></li><li><em class="btn-boll">9</em><span>5</span></li>						</ul>
					</div>
				</div>
				<div style="width: 110px;" class="t">
					<div class="tool-list">
						<ul class="clearfix dxjo">
							<li><a class="btn btn-middle dt-qb" href="#">拖码全包</a></li>
							<li><a class="lnk dt-qb-clr" href="#">清除</a></li>
						</ul>
					</div>
			   </div>
			 </div>
	   </div>
		<div class="ft">
    <p class="sel_info">您选了 <b>0</b> 注，共 <b>0</b> 元  <em></em></p>
</div>

	</div>
</div>

                    </div>
                    <div class="plays plays_area_1d">
                    <div class="mod-select-info">
	<p class="plays-memo" id="zx_sm"><i class="ico ico-info-s"></i><b>玩法提示：</b><span>从0～9十个号码中任选1个或多个号码，所选号码与开奖号码最后一位号码相同，即中奖<em class="red">10</em>元</span></p>
</div>
 <div class="mod-select-bolls code_box">
	<div class="hd">
		<h3 class="clearfix">
			<span id="play_tips" class="t1"><em>选号区</em>至少选择1个号码</span><span class="t2"><em>操作区</em>快捷选号</span>
		</h3>
	</div>
	<div class="bd">
		<div class="tools-boll-list">
			<div class="boll-item boll-item-col3 sd_zx_1d">
				<div style="width:51px;" class="k">
					<span style="margin-left:9px;" class="k1">个位<span class="caret"></span></span>
					 <span style="padding-left:0;" class="k2">当前遗漏</span>
					 <span style="padding-left:0;" class="k2 not">最大遗漏</span>
				</div>
				<div style="width:378px;" class="v">
					<div onselectstart="return false;" unselectable="on" class="boll-list">
						<ul class="clearfix">
							<li><em class="btn-boll">0</em><span>14</span><em class="ssc-gray">93</em></li><li><em class="btn-boll">1</em><span>2</span><em class="ssc-gray">105</em></li><li><em class="btn-boll">2</em><span>6</span><em class="ssc-gray">125</em></li><li><em class="btn-boll">3</em><span>4</span><em class="ssc-gray">96</em></li><li><em class="btn-boll">4</em><span>0</span><em class="ssc-gray">105</em></li><li><em class="btn-boll">5</em><span>7</span><em class="ssc-gray">120</em></li><li><em class="btn-boll">6</em><span>1</span><em class="ssc-gray">91</em></li><li><em class="btn-boll">7</em><span>3</span><em class="ssc-gray">93</em></li><li><em class="btn-boll">8</em><span>5</span><em class="ssc-gray">90</em></li><li><em class="btn-boll">9</em><span class="red">16</span><em class="ssc-gray">117</em></li>						</ul>
					</div>
				</div>
				 <div class="t">
    <div class="tool-list">
        <ul class="clearfix dxjo">
            <li><a class="btn btn-middle" href="#">全</a></li>
            <li><a class="btn btn-middle" href="#">大</a></li>
            <li><a class="btn btn-middle" href="#">小</a></li>
            <li><a class="btn btn-middle" href="#">奇</a></li>
            <li><a class="btn btn-middle" href="#">偶</a></li>
            <li><a class="lnk" href="#">清除</a></li>
        </ul>
    </div>
</div>

			</div>
		 </div>
		<div class="ft">
    <p class="sel_info">您选了 <b>0</b> 注，共 <b>0</b> 元  <em></em></p>
</div>

	</div>
</div>

                    </div>
                    <div class="plays none plays_area_dd" style="display: none;">
                    <div class="mod-select-info">
	<p style="padding-right:50px" class="plays-memo" id="zx_sm"><i class="ico ico-info-s"></i><b>玩法提示：</b><span>从个、十位中的大小单双4种属性中各选1种属性，所选属性与开奖号码的属性相同，即中奖<em class="red">4</em>元，注：号码5～9为大，0～4为小；13579为单，02468为双；举例：开奖号码9,5,8,0,8；十位：小双 ，个位：大双 ，用户选：小大、双双、小双、双大，都算中奖</span></p>
</div>
<div class="mod-select-bolls mod-select-bolls-col4">
	<div class="hd">
		<h3 class="clearfix">
			<span id="play_tips" class="t1"><em>选号区</em> 十位 <span class="muted">(请选择一种属性)</span></span><span class="t2"><em>选号区</em> 个位 <span class="muted">(请选择一种属性)</span></span>
		</h3>
	</div>
	<div class="bd">
		<div class="tools-boll-list  code_box">
			<div class="boll-item boll-item-col5 sd_zx_dd">
				<div style="margin-top:10px;" class="k">
					<span class="k1">号码<span class="caret"></span></span>
					<span class="k2">遗漏</span>
				</div>
				<div class="v">
					<div class="boll-list btn-boll-large-box">
						<ul class="clearfix">
							<li><em class="btn-boll btn-boll-large">大</em><span>1</span></li><li><em class="btn-boll btn-boll-large">小</em><span>0</span></li><li><em class="btn-boll btn-boll-large">单</em><span>0</span></li><li><em class="btn-boll btn-boll-large">双</em><span class="red">3</span></li>						</ul>
					</div>
				</div>
				<div class="t">
					<div class="boll-list btn-boll-large-box">
						<ul class="clearfix">
							<li><em class="btn-boll btn-boll-large">大</em><span>1</span></li><li><em class="btn-boll btn-boll-large">小</em><span>0</span></li><li><em class="btn-boll btn-boll-large">单</em><span class="red">2</span></li><li><em class="btn-boll btn-boll-large">双</em><span>0</span></li>						</ul>
					</div>
				</div>
			</div>
		</div>
		<div class="ft"><p class="sel_info">您选了 <b>0</b> 注，共 <b>0</b> 元 <em></em></p></div>
	</div>
</div>

                    </div>
<!-- {{选号结果 -->
                                    <div class="mod-select-result">
                    <div style="position:absolute; bottom: 143px;right: 58px;width: 130px;cursor: pointer;_overflow: hidden;" id="cd_list_try" class="panel panel-t9 none">
                        <div class="panel-content">
                            <div class="bd">
                                <p>手气不错，机选一注试试</p>
                            </div>
                        </div>
                        <span class="sd"></span>
                    </div>
                    <div style="margin-left: 200px;text-align: left;" class="hd confirm_sel_code_list">
                        <button id="confirm_sel_code" class="btn" type="button"><span class="btn-large btn-slt-ok"><i class="l"><i class="r">确认选号</i></i></span></button>
                        <a class="lnk lnk-calcel" href="javascript:;">清空选号</a>
                        <a bk="cp_tool_kpfilter" style="position: relative;margin-left: 15px;" id="zn_filter" class="lnk none" href="javascript:;">在线过滤</a>

                    </div>
                    <div class="bd clearfix">
                        <div class="result">
                                                                                    <div style="height:140px;" class="content">
                                <ul class="clearfix codelist"></ul>
                            </div>
                            <div class="ctrls none">
                                                                                            </div>
                        </div>
                        <div class="qkmethod">
                            <ul plays="Z1|直选">
                                <li><a href="#" count="1" class="btn-middle">机选1注</a></li>
                                <li><a href="#" count="5" class="btn-middle">机选5注</a></li>
                                <li><a href="#" count="10" class="btn-middle">机选10注</a></li>
                                <li><a href="#" count="0" class="btn-middle">清空列表</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

<!-- 选号结果}} -->
                    <iframe frameborder="no" style="display:none;" name="uploadds" src="about:blank" autocomplete="off" id="uploadds" border="0" marginwidth="0" marginheight="0" scrolling="no"></iframe>
                </div>



<div id="result" class="mod-select-result">
	    <div class="ft">
        <div class="total">
            您选了 <b id="count" class="em">0</b> 注，
            倍投 <input type="text" value="1" id="mul" class="text"> 倍，共 <b id="money" class="em" style="display: inline-block;">0</b> 元
                        <!--?if($this->lotInfo["lotID"]=='220051' || $this->lotInfo["lotID"]=='220028' || $this->lotInfo["lotID"]=='120029'){
                echo '<span style="color:#666;margin-left:1em;">（选号是否中过大奖?--<a href="#" class="lnk lnk-compare" style="position: relative;margin:0;">对比历史开奖</a>）</span>';
            }?-->


        </div>
    </div>
</div>



<!-- {{购买方式 -->
                <div class="mod-buy-method">

    <div id="buy_type" class="nav-tab clearfix">
        <span class="rd-group">
            <b>投注方式：</b>
            <label><input type="radio" checked="checked" name="a2" desc="由购买人自行全额购买彩票&lt;i class='ico ico-help' val='bet' style='margin-top:-2px'&gt;&lt;/i&gt;" value="bet"> <span>自购</span></label>
            <label><input type="radio" name="a2" desc="连续多期购买同一个（组）号码&lt;i class='ico ico-help' val='trace' style='margin-top:-2px'&gt;&lt;/i&gt;" value="trace"> <span>我要追号</span></label>

            <label><input type="radio" name="a2" desc="连续多期购买同一个（组）号码&lt;i class='ico ico-help' val='zntrace' style='margin-top:-2px'&gt;&lt;/i&gt;" value="zntrace"> <span>智能追号</span></label>
            	<!-- 追号提示 -->
            <div style="position: absolute;  width: 150px;  padding-left:6px; padding-right:6px; margin-top: -50px; *margin-top: -30px; margin-left: 144px;*margin-left:-104px;cursor:pointer;_margin-top: -25px; _margin-left:-72px;" id="zhTip" class="panel panel-t9 ">
		                <div style="width:150px;" class="bd">
		                    设置盈利率 科学加倍才赚钱
		                </div>
		            <span class="sd"> </span>
		 		</div>                    </span>
        <span class="tips type_tips">由购买人自行全额购买彩票<i style="margin-top:-2px" val="bet" class="ico ico-help"></i></span>

    </div>

    <div id="buy_type_content" class="tab-content">
                                   <div class="tab-pane tab-pane-zh none">
                                <div class="table">
                                    <div class="hd">
                                        <table width="100%">
                                            <tbody><tr>
                                                <td class="s0">序</td>
                                                <td class="s1"><label><input type="checkbox" id="zh_all_issue" autocomplete="off" checked="checked" class="checkbox"> <span>选择</span></label>
                                                    <select style="font-weight: normal;" id="zh_issue_list">
                                                        <option value="2">追2期</option>
                                                        <option value="3">追3期</option>
                                                        <option value="4">追4期</option>
                                                        <option value="5">追5期</option>
                                                        <option value="6">追6期</option>
                                                        <option value="7">追7期</option>
                                                        <option value="8">追8期</option>
                                                        <option value="9">追9期</option>
                                                        <option selected="selected" value="10">追10期</option>
                                                        <option value="15">追15期</option>
                                                        <option value="20">追20期</option>
                                                        <option value="30">追30期</option>
                                                        <option value="40">追40期</option>
                                                        <option value="50">追50期</option>
                                                                                                                <option value="70">追70期</option>
                                                        <option value="90">追90期</option>
                                                        <option value="120">追120期</option>
                                                                                                                                                                   </select>
                                                 </td>
                                                <td class="s2"><input type="text" class="text" value="1" id="zh_set_mul" autocomplete="off" style="font-weight: normal;"> 倍数</td>
                                                <td class="s3">金额（元）</td>
                                                <td class="s4">预计开奖时间</td>
                                            </tr>
                                        </tbody></table>
                                    </div>
                                    <div class="bd box">
                                        <table width="100%">
                                            <tbody id="zh_list">
                                                <tr>
                                                    <td class="s0"></td>
                                                    <td class="s1"></td>
                                                    <td class="s2 gray">请先选号投注</td>
                                                    <td class="s3"></td>
                                                    <td class="s4"></td>
                                                </tr>
                                        </tbody></table>
                                    </div>
                                </div>
                                <div class="total clearfix">
                                    <span id="zh_total" class="count">共追：<b class="em">0</b> 期   总金额：<b class="em">0</b> 元 </span>
                                    <span class="help"><label for="zh_stop_trace"><input type="checkbox" checked="checked" id="zh_stop_trace" autocomplete="off" class="checkbox"> <em class="zh_stop_type">中奖后停止追号</em></label><em class="zh_stop_type none">当中奖金额&gt; <input type="text" value="0" id="zh_stop_money" autocomplete="off" class="text ipt48">，停止追号</em><i style="margin-top:-2px" id="zh_tips" class="ico ico-help"></i></span>
                                </div>

                            </div>

                                   <div class="tab-pane tab-pane-znzh none">
                                <div style="margin: 10px 10px 10px 20px;" class="form clearfix">
                                    <div class="fm-item">
                                        <label class="k">追号设置：</label>
                                        <span class="v">从 <select class="rangeSel" autocomplete="off" tabindex="3" name="a3" id="znzh_issue_select">
                                                        <option selected="selected" value="0">130913042</option>
                                                    </select>
                                                    期开始，连追 <input type="text" autocomplete="off" value="10" class="text input-xmini issueLen"> 期，起始倍 <input type="text" style="width:35px;" autocomplete="off" value="1" class="text input-xmini sMul"> 倍，已投入 <input type="text" maxlength="6" autocomplete="off" value="0" class="text input-xmini user-in" style="width:35px;"> 元
                                        </span>
                                    </div>
                                    <div class="fm-item">
                                        <label class="k" for="">奖金设置：</label>
                                        <span class="v">单倍奖金 <input type="text" maxlength="6" autocomplete="off" value="0" id="hm_own_buy" tabindex="4" class="text input-mini singleBouns"> 元</span>
                                        <span class="t">（注：系统默认为单式奖金或复式最低奖金，可进行自定义设置）</span>
                                    </div>
                                    <div class="fm-item">
                                        <div style="margin-top: 60px;" class="fm-btn fr">
                                            <button type="button" class="btn makeSel"><span class="btn-large2 btn-small-primary">生成追号</span></button>
                                            <a class="lnk clearSel" href="#">清空设置</a>
                                        </div>
                                        <label class="k" for="">盈利设置：</label>
                                        <span class="v">
                                            <p><label for="znzh_bm1"><input type="radio" val="minRate" value="0" name="znzh_bm" autocomplete="off" checked="checked" id="znzh_bm1"> <em>全程最低盈利率</em></label> <input type="text" value="30" class="text input-xmini minRate"> %</p>
                                            <p class="dissel"><label for="znzh_bm2"><input type="radio" val="sepRate" value="0" name="znzh_bm" autocomplete="off" id="znzh_bm2"> <em> 前 </em></label><em> <input type="text" disabled="disabled" value="5" class="text input-xmini preIssue"> 期盈利率 <input type="text" disabled="disabled" value="30" class="text input-xmini preRate"> %，之后盈利率 <input type="text" disabled="disabled" value="5" class="text input-xmini nextRate">  %</em></p>
                                            <p class="dissel"><label for="znzh_bm3"><input type="radio" val="minus" value="0" name="znzh_bm" autocomplete="off" id="znzh_bm3"> <em>全程最低盈利</em></label> <input type="text" style="width:61px" disabled="disabled" value="10" class="text input-xmini minus"> 元</p>
                                        </span>
                                    </div>
                                </div>
                                <div class="table">
                                    <div class="hd">
                                        <table width="100%">
                                            <tbody>
                                                <tr>
                                                    <th width="6%">序</th>
                                                    <th width="22%">期次</th>
                                                    <th width="12%">倍数</th>
                                                    <th width="14%">投入金额</th>
                                                    <th width="14%">累计投入</th>
                                                    <th width="15%">中奖盈利</th>
                                                    <th width="14%">盈利率</th>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="bd">
                                        <table width="100%">
                                            <tbody id="zzhlist"><tr><td colspan="7" style="height: 70px;line-height: 70px;">暂无生成追号</td></tr></tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="total clearfix stopBonus">
                                    <span class="count">追号期数：<b class="em znzh-count">0</b> 期   追号总金额：<b class="em znzh-money">0</b> 元 </span>
                                    <span class="help"><label for="a"><input type="checkbox" checked="checked" class="checkbox zh_stop_zntrace" id="a"> <span>中奖后停止追号</span></label><i class="ico ico-help"></i></span>
                                </div>

                            </div>
    </div>
</div>


<!-- 购买方式}} -->
<!-- {{提交 -->
                    <div class="mod-submit">
                        <button class="btn btn-sd" id="post_data" type="button"><span class="btn-large2 btn-large2-primary">立即投注</span></button><br><br>                         <p style="padding-bottom: 0;"><label><input type="checkbox" checked="checked" id="user_xieyi" class="checkbox"> <span>我已阅读并同意<a name="user_xieyi_content" id="user_xieyi_content" class="lnk" href="#">《用户委托投注协议》</a></span></label></p>

                         <p><label><input type="checkbox" checked="checked" id="user_xianhao" class="checkbox"> <span>我已阅读并同意<a id="user_xianhao_content" class="lnk" href="#">《限号投注风险须知》</a></span></label></p>

                    </div>
<!-- 提交}} -->
<!-- {{中奖说明 -->
                                     <div class="mod-cz-desc mod-cz-desc02">
                        <div class="hd clearfix">
                            <span id="open_code_list_ctrl" class="hdr">
                                收起 <i class="ico  ico-numtableup ico-numtabledown"></i>
                            </span>
                            <h3>今日开奖</h3><em class="gray">注：白天72期，10分钟开奖；夜间48期，5分钟开奖</em>
                        </div>
                        <div class="bd open-code-list">
                            <div class="mod-cz-table">

                                <table width="100%" class="mod-kjnum-table">
                                    <thead>
                                        <tr>
                                            <th width="25%" class="br2"><span>期号</span><em>开奖号</em>&#12288;后二&nbsp;&nbsp;后三</th>
                                            <th width="25%" class="br2"><span>期号</span><em>开奖号</em>&#12288;后二&nbsp;&nbsp;后三</th>
                                            <th width="25%" class="br2"><span>期号</span><em>开奖号</em>&#12288;后二&nbsp;&nbsp;后三</th>
                                            <th><span>期号</span>开奖号&#12288;后二&nbsp;&nbsp;后三</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <tr> <td><span class="gary">001</span><em class="code">87040</em><em class="code2 gray"></em><em class="code3 orange">组三</em></td> <td><span class="gary">031</span><em class="code">48937</em><em class="code2 gray"></em><em class="code3 gray">组六</em></td> <td><span class="gary">061</span><em class="code">99562</em><em class="code2 gray"></em><em class="code3 gray">组六</em></td> <td><span class="gary">091</span><em class="code"></em><em class="code2 gray"></em><em class="code3 gray"></em></td></tr><tr> <td><span class="gary">002</span><em class="code">64289</em><em class="code2 orange">连号</em><em class="code3 gray">组六</em></td> <td><span class="gary">032</span><em class="code">84334</em><em class="code2 orange">连号</em><em class="code3 orange">组三</em></td> <td><span class="gary">062</span><em class="code">66079</em><em class="code2 gray"></em><em class="code3 gray">组六</em></td> <td><span class="gary">092</span><em class="code"></em><em class="code2 gray"></em><em class="code3 gray"></em></td></tr><tr> <td><span class="gary">003</span><em class="code">52676</em><em class="code2 orange">连号</em><em class="code3 orange">组三</em></td> <td><span class="gary">033</span><em class="code">08329</em><em class="code2 gray"></em><em class="code3 gray">组六</em></td> <td><span class="gary">063</span><em class="code">64643</em><em class="code2 orange">连号</em><em class="code3 gray">组六</em></td> <td><span class="gary">093</span><em class="code"></em><em class="code2 gray"></em><em class="code3 gray"></em></td></tr><tr> <td><span class="gary">004</span><em class="code">26560</em><em class="code2 gray"></em><em class="code3 gray">组六</em></td> <td><span class="gary">034</span><em class="code">46166</em><em class="code2 green">对子</em><em class="code3 orange">组三</em></td> <td><span class="gary">064</span><em class="code">25660</em><em class="code2 gray"></em><em class="code3 orange">组三</em></td> <td><span class="gary">094</span><em class="code"></em><em class="code2 gray"></em><em class="code3 gray"></em></td></tr><tr> <td><span class="gary">005</span><em class="code">86399</em><em class="code2 green">对子</em><em class="code3 orange">组三</em></td> <td><span class="gary">035</span><em class="code">20424</em><em class="code2 gray"></em><em class="code3 orange">组三</em></td> <td><span class="gary">065</span><em class="code">09893</em><em class="code2 gray"></em><em class="code3 gray">组六</em></td> <td><span class="gary">095</span><em class="code"></em><em class="code2 gray"></em><em class="code3 gray"></em></td></tr><tr> <td><span class="gary">006</span><em class="code">22141</em><em class="code2 gray"></em><em class="code3 orange">组三</em></td> <td><span class="gary">036</span><em class="code">50037</em><em class="code2 gray"></em><em class="code3 gray">组六</em></td> <td><span class="gary">066</span><em class="code">22204</em><em class="code2 gray"></em><em class="code3 gray">组六</em></td> <td><span class="gary">096</span><em class="code"></em><em class="code2 gray"></em><em class="code3 gray"></em></td></tr><tr> <td><span class="gary">007</span><em class="code">39306</em><em class="code2 gray"></em><em class="code3 gray">组六</em></td> <td><span class="gary">037</span><em class="code">81001</em><em class="code2 orange">连号</em><em class="code3 orange">组三</em></td> <td><span class="gary">067</span><em class="code">25063</em><em class="code2 gray"></em><em class="code3 gray">组六</em></td> <td><span class="gary">097</span><em class="code"></em><em class="code2 gray"></em><em class="code3 gray"></em></td></tr><tr> <td><span class="gary">008</span><em class="code">28204</em><em class="code2 gray"></em><em class="code3 gray">组六</em></td> <td><span class="gary">038</span><em class="code">11880</em><em class="code2 gray"></em><em class="code3 orange">组三</em></td> <td><span class="gary">068</span><em class="code">47038</em><em class="code2 gray"></em><em class="code3 gray">组六</em></td> <td><span class="gary">098</span><em class="code"></em><em class="code2 gray"></em><em class="code3 gray"></em></td></tr><tr> <td><span class="gary">009</span><em class="code">65715</em><em class="code2 gray"></em><em class="code3 gray">组六</em></td> <td><span class="gary">039</span><em class="code">84429</em><em class="code2 gray"></em><em class="code3 gray">组六</em></td> <td><span class="gary">069</span><em class="code">77751</em><em class="code2 gray"></em><em class="code3 gray">组六</em></td> <td><span class="gary">099</span><em class="code"></em><em class="code2 gray"></em><em class="code3 gray"></em></td></tr><tr> <td><span class="gary">010</span><em class="code">35183</em><em class="code2 gray"></em><em class="code3 gray">组六</em></td> <td><span class="gary">040</span><em class="code">18655</em><em class="code2 green">对子</em><em class="code3 orange">组三</em></td> <td><span class="gary">070</span><em class="code">34377</em><em class="code2 green">对子</em><em class="code3 orange">组三</em></td> <td><span class="gary">100</span><em class="code"></em><em class="code2 gray"></em><em class="code3 gray"></em></td></tr><tr> <td><span class="gary">011</span><em class="code">84185</em><em class="code2 gray"></em><em class="code3 gray">组六</em></td> <td><span class="gary">041</span><em class="code">60294</em><em class="code2 gray"></em><em class="code3 gray">组六</em></td> <td><span class="gary">071</span><em class="code">65325</em><em class="code2 gray"></em><em class="code3 gray">组六</em></td> <td><span class="gary">101</span><em class="code"></em><em class="code2 gray"></em><em class="code3 gray"></em></td></tr><tr> <td><span class="gary">012</span><em class="code">68063</em><em class="code2 gray"></em><em class="code3 gray">组六</em></td> <td><span class="gary">042</span><em class="code">50222</em><em class="code2 green">对子</em><em class="code3 green">豹子</em></td> <td><span class="gary">072</span><em class="code">03682</em><em class="code2 gray"></em><em class="code3 gray">组六</em></td> <td><span class="gary">102</span><em class="code"></em><em class="code2 gray"></em><em class="code3 gray"></em></td></tr><tr> <td><span class="gary">013</span><em class="code">46244</em><em class="code2 green">对子</em><em class="code3 orange">组三</em></td> <td><span class="gary">043</span><em class="code">59283</em><em class="code2 gray"></em><em class="code3 gray">组六</em></td> <td><span class="gary">073</span><em class="code">89098</em><em class="code2 orange">连号</em><em class="code3 gray">组六</em></td> <td><span class="gary">103</span><em class="code"></em><em class="code2 gray"></em><em class="code3 gray"></em></td></tr><tr> <td><span class="gary">014</span><em class="code">09402</em><em class="code2 gray"></em><em class="code3 gray">组六</em></td> <td><span class="gary">044</span><em class="code">01557</em><em class="code2 gray"></em><em class="code3 orange">组三</em></td> <td><span class="gary">074</span><em class="code">73763</em><em class="code2 gray"></em><em class="code3 gray">组六</em></td> <td><span class="gary">104</span><em class="code"></em><em class="code2 gray"></em><em class="code3 gray"></em></td></tr><tr> <td><span class="gary">015</span><em class="code">89419</em><em class="code2 gray"></em><em class="code3 gray">组六</em></td> <td><span class="gary">045</span><em class="code">76715</em><em class="code2 gray"></em><em class="code3 gray">组六</em></td> <td><span class="gary">075</span><em class="code">81647</em><em class="code2 gray"></em><em class="code3 gray">组六</em></td> <td><span class="gary">105</span><em class="code"></em><em class="code2 gray"></em><em class="code3 gray"></em></td></tr><tr> <td><span class="gary">016</span><em class="code">78098</em><em class="code2 orange">连号</em><em class="code3 gray">组六</em></td> <td><span class="gary">046</span><em class="code">82624</em><em class="code2 gray"></em><em class="code3 gray">组六</em></td> <td><span class="gary">076</span><em class="code">25451</em><em class="code2 gray"></em><em class="code3 gray">组六</em></td> <td><span class="gary">106</span><em class="code"></em><em class="code2 gray"></em><em class="code3 gray"></em></td></tr><tr> <td><span class="gary">017</span><em class="code">11998</em><em class="code2 orange">连号</em><em class="code3 orange">组三</em></td> <td><span class="gary">047</span><em class="code">07126</em><em class="code2 gray"></em><em class="code3 gray">组六</em></td> <td><span class="gary">077</span><em class="code">93256</em><em class="code2 orange">连号</em><em class="code3 gray">组六</em></td> <td><span class="gary">107</span><em class="code"></em><em class="code2 gray"></em><em class="code3 gray"></em></td></tr><tr> <td><span class="gary">018</span><em class="code">72640</em><em class="code2 gray"></em><em class="code3 gray">组六</em></td> <td><span class="gary">048</span><em class="code">91508</em><em class="code2 gray"></em><em class="code3 gray">组六</em></td> <td><span class="gary">078</span><em class="code">98434</em><em class="code2 orange">连号</em><em class="code3 orange">组三</em></td> <td><span class="gary">108</span><em class="code"></em><em class="code2 gray"></em><em class="code3 gray"></em></td></tr><tr> <td><span class="gary">019</span><em class="code">27738</em><em class="code2 gray"></em><em class="code3 gray">组六</em></td> <td><span class="gary">049</span><em class="code">18109</em><em class="code2 orange">连号</em><em class="code3 gray">组六</em></td> <td><span class="gary">079</span><em class="code"></em><em class="code2 gray"></em><em class="code3 gray"></em></td> <td><span class="gary">109</span><em class="code"></em><em class="code2 gray"></em><em class="code3 gray"></em></td></tr><tr> <td><span class="gary">020</span><em class="code">59098</em><em class="code2 orange">连号</em><em class="code3 gray">组六</em></td> <td><span class="gary">050</span><em class="code">27964</em><em class="code2 gray"></em><em class="code3 gray">组六</em></td> <td><span class="gary">080</span><em class="code"></em><em class="code2 gray"></em><em class="code3 gray"></em></td> <td><span class="gary">110</span><em class="code"></em><em class="code2 gray"></em><em class="code3 gray"></em></td></tr><tr> <td><span class="gary">021</span><em class="code">78577</em><em class="code2 green">对子</em><em class="code3 orange">组三</em></td> <td><span class="gary">051</span><em class="code">53098</em><em class="code2 orange">连号</em><em class="code3 gray">组六</em></td> <td><span class="gary">081</span><em class="code"></em><em class="code2 gray"></em><em class="code3 gray"></em></td> <td><span class="gary">111</span><em class="code"></em><em class="code2 gray"></em><em class="code3 gray"></em></td></tr><tr> <td><span class="gary">022</span><em class="code">41649</em><em class="code2 gray"></em><em class="code3 gray">组六</em></td> <td><span class="gary">052</span><em class="code">86707</em><em class="code2 gray"></em><em class="code3 orange">组三</em></td> <td><span class="gary">082</span><em class="code"></em><em class="code2 gray"></em><em class="code3 gray"></em></td> <td><span class="gary">112</span><em class="code"></em><em class="code2 gray"></em><em class="code3 gray"></em></td></tr><tr> <td><span class="gary">023</span><em class="code">55541</em><em class="code2 gray"></em><em class="code3 gray">组六</em></td> <td><span class="gary">053</span><em class="code">66000</em><em class="code2 green">对子</em><em class="code3 green">豹子</em></td> <td><span class="gary">083</span><em class="code"></em><em class="code2 gray"></em><em class="code3 gray"></em></td> <td><span class="gary">113</span><em class="code"></em><em class="code2 gray"></em><em class="code3 gray"></em></td></tr><tr> <td><span class="gary">024</span><em class="code">32554</em><em class="code2 orange">连号</em><em class="code3 orange">组三</em></td> <td><span class="gary">054</span><em class="code">11388</em><em class="code2 green">对子</em><em class="code3 orange">组三</em></td> <td><span class="gary">084</span><em class="code"></em><em class="code2 gray"></em><em class="code3 gray"></em></td> <td><span class="gary">114</span><em class="code"></em><em class="code2 gray"></em><em class="code3 gray"></em></td></tr><tr> <td><span class="gary">025</span><em class="code">31157</em><em class="code2 gray"></em><em class="code3 gray">组六</em></td> <td><span class="gary">055</span><em class="code">23094</em><em class="code2 gray"></em><em class="code3 gray">组六</em></td> <td><span class="gary">085</span><em class="code"></em><em class="code2 gray"></em><em class="code3 gray"></em></td> <td><span class="gary">115</span><em class="code"></em><em class="code2 gray"></em><em class="code3 gray"></em></td></tr><tr> <td><span class="gary">026</span><em class="code">54897</em><em class="code2 gray"></em><em class="code3 gray">组六</em></td> <td><span class="gary">056</span><em class="code">59455</em><em class="code2 green">对子</em><em class="code3 orange">组三</em></td> <td><span class="gary">086</span><em class="code"></em><em class="code2 gray"></em><em class="code3 gray"></em></td> <td><span class="gary">116</span><em class="code"></em><em class="code2 gray"></em><em class="code3 gray"></em></td></tr><tr> <td><span class="gary">027</span><em class="code">16946</em><em class="code2 gray"></em><em class="code3 gray">组六</em></td> <td><span class="gary">057</span><em class="code">47159</em><em class="code2 gray"></em><em class="code3 gray">组六</em></td> <td><span class="gary">087</span><em class="code"></em><em class="code2 gray"></em><em class="code3 gray"></em></td> <td><span class="gary">117</span><em class="code"></em><em class="code2 gray"></em><em class="code3 gray"></em></td></tr><tr> <td><span class="gary">028</span><em class="code">22652</em><em class="code2 gray"></em><em class="code3 gray">组六</em></td> <td><span class="gary">058</span><em class="code">61626</em><em class="code2 gray"></em><em class="code3 orange">组三</em></td> <td><span class="gary">088</span><em class="code"></em><em class="code2 gray"></em><em class="code3 gray"></em></td> <td><span class="gary">118</span><em class="code"></em><em class="code2 gray"></em><em class="code3 gray"></em></td></tr><tr> <td><span class="gary">029</span><em class="code">11720</em><em class="code2 gray"></em><em class="code3 gray">组六</em></td> <td><span class="gary">059</span><em class="code">86035</em><em class="code2 gray"></em><em class="code3 gray">组六</em></td> <td><span class="gary">089</span><em class="code"></em><em class="code2 gray"></em><em class="code3 gray"></em></td> <td><span class="gary">119</span><em class="code"></em><em class="code2 gray"></em><em class="code3 gray"></em></td></tr><tr> <td><span class="gary">030</span><em class="code">39194</em><em class="code2 gray"></em><em class="code3 gray">组六</em></td> <td><span class="gary">060</span><em class="code">31633</em><em class="code2 green">对子</em><em class="code3 orange">组三</em></td> <td><span class="gary">090</span><em class="code"></em><em class="code2 gray"></em><em class="code3 gray"></em></td> <td><span class="gary">120</span><em class="code"></em><em class="code2 gray"></em><em class="code3 gray"></em></td></tr>                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                 <div class="mod-cz-desc mod-cz-desc02">
                        <div class="hd clearfix">
                            <h3 id="kp_zj_tip">中奖说明</h3>
                        </div>
                        <div class="bd">
                            <div class="mod-cz-table">

                                <table width="100%" class="mod-explaina-table">
                                    <thead>
                                        <tr>
                                            <th width="10%">玩法</th>
                                            <th width="14%">开奖号码示例</th>
                                            <th width="24%">投注号码示例</th>
                                            <th width="40%">中奖规则</th>
                                            <th width="12%">单注奖金</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>五星直选</td>
                                        <td rowspan="9">1 2 3 4 5</td>
                                        <td>1 2 3 4 5</td>
                                        <td>选5个号码，与开奖号码完全按位全部相符</td>
                                        <td class="red kjhm-rj">100000元</td>
                                    </tr>
                                    <tr>
                                        <td rowspan="3">五星通选</td>
                                        <td>1 2 3 4 5</td>
                                        <td>选5个号码，与开奖号码完全按位全部相符</td>
                                        <td class="red kjhm-rj">20440元</td>
                                    </tr>
                                    <tr>
                                      <td>1 2 3 * *或者 * * 3 4 5</td>
                                        <td>选5个号码，与开奖号码前三位或后三位按位相符</td>
                                        <td class="red kjhm-rj">220元</td>
                                    </tr>
                                    <tr>
                                      <td>1 2 * * *或* * * 4 5</td>
                                        <td>选5个号码，与开奖号码前二位或后二位按位相符</td>
                                        <td class="red kjhm-rj">20元</td>
                                    </tr>
                                    <tr>
                                        <td>三星</td>
                                        <td>- - 3 4 5</td>
                                        <td>选3个号码，与开奖号码连续后三位按位相符</td>
                                        <td class="red kjhm-rj">1000元</td>
                                    </tr>

                                    <tr>
                                        <td>二星直选</td>
                                        <td>- - - 4 5</td>
                                        <td>选2个号码，与开奖号码连续后二位按位相符</td>
                                        <td class="red kjhm-rj">100元</td>
                                    </tr>
                                    <tr>
                                        <td>二星组选</td>
                                        <td>- - - 4 5或- - - 5 4</td>
                                        <td>选2个号码，与开奖号码连续后二位相符</td>
                                        <td class="red kjhm-rj">50元</td>
                                    </tr>
                                    <tr>
                                        <td>一星</td>
                                        <td>- - - - 5</td>
                                        <td>选1个号码，与开奖号码个位相符</td>
                                        <td class="red kjhm-rj">10元</td>
                                    </tr>
                                    <tr>
                                        <td>大小单双</td>
                                        <td>双单(或双大、小单、小大)</td>
                                        <td>与开奖号码后二位数字属性按位相符</td>
                                        <td class="red kjhm-rj">4元</td>
                                    </tr>
                                    <tr>
                                        <td>三星组三</td>
                                        <td>1 2 3 4 4</td>
                                        <td>- - 3 4 4</td>
                                        <td>选3个号码，与开奖号码的数字相同，顺序不限</td>
                                        <td class="red kjhm-rj">320元</td>
                                    </tr>
                                    <tr>
                                        <td>三星组六</td>
                                        <td>1 2 3 4 5</td>
                                        <td>- - 3 4 5</td>
                                        <td>选三个号码，与开奖号码连续后三位相符(顺序不限)</td>
                                        <td class="red kjhm-rj">160元</td>
                                    </tr>
                                    <tr>
                                        <td class="muted " colspan="5">注：大号码为5~9; 小号码为0~4; 单数为：13579; 双数为：02468</td>
                                    </tr>
                                  </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
<!-- 中奖说明}} -->
                </div>
                <!--  -->
                <div class="aside">
<div class="mod-aside mod-aside-xssckj">
                        <div class="hd clearfix">
                            <h3>老时时彩 第 <em id="open_issue" class="red">0116078</em> 期 开奖</h3><div class="ball-num clearfix"><ul id="open_code_list"><li class="ico-ball3">9</li> <li class="ico-ball3">8</li> <li class="ico-ball3">4</li> <li class="ico-ball3">3</li> <li class="ico-ball3">4</li> </ul></div><p class="kj-date"><em class="kj-date-txt">今天已开78期，还剩42期</em></p>                        </div>
                        <div class="bd">
                            <div class="kpkjcode">
                                <table width="100%">
                                    <thead>
                                        <tr>
                                            <th width="27">期号</th>
                                            <th width="53">开奖号</th>
                                            <th width="140">
                                                <p><em class="tabtit active" play="h3">后三</em><em class="tabtit last" play="h2">后二</em></p>
												<p play="h3"><span>形态</span><span>大小比</span><span>奇偶比</span></p>
												<p play="h2" class="none"><span>形态</span><span>十位</span><span>个位</span></p>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <tr> <td class="gray">078</td>
                                            <td>9 8 <em class="red">4 3 4</em></td>
                                            <td play="h3"><span class="orange">组三</span><span class="gray666">0:3</span><span class="gray666">1:2</span></td>
                                            <td play="h2" class="none"><span class="orange">连号</span><span class="gray666">小单</span><span class="gray666">小双</span></td>
                                        </tr><tr> <td class="gray">077</td>
                                            <td>9 3 <em class="red">2 5 6</em></td>
                                            <td play="h3"><span class="gray">组六</span><span class="gray666">2:1</span><span class="gray666">1:2</span></td>
                                            <td play="h2" class="none"><span class="orange">连号</span><span class="gray666">大单</span><span class="gray666">大双</span></td>
                                        </tr><tr> <td class="gray">076</td>
                                            <td>2 5 <em class="red">4 5 1</em></td>
                                            <td play="h3"><span class="gray">组六</span><span class="gray666">1:2</span><span class="gray666">2:1</span></td>
                                            <td play="h2" class="none"><span class="gray">&nbsp;</span><span class="gray666">大单</span><span class="gray666">小单</span></td>
                                        </tr><tr> <td class="gray">075</td>
                                            <td>8 1 <em class="red">6 4 7</em></td>
                                            <td play="h3"><span class="gray">组六</span><span class="gray666">2:1</span><span class="gray666">1:2</span></td>
                                            <td play="h2" class="none"><span class="gray">&nbsp;</span><span class="gray666">小双</span><span class="gray666">大单</span></td>
                                        </tr><tr> <td class="gray">074</td>
                                            <td>7 3 <em class="red">7 6 3</em></td>
                                            <td play="h3"><span class="gray">组六</span><span class="gray666">2:1</span><span class="gray666">2:1</span></td>
                                            <td play="h2" class="none"><span class="gray">&nbsp;</span><span class="gray666">大双</span><span class="gray666">小单</span></td>
                                        </tr><tr> <td class="gray">073</td>
                                            <td>8 9 <em class="red">0 9 8</em></td>
                                            <td play="h3"><span class="gray">组六</span><span class="gray666">2:1</span><span class="gray666">1:2</span></td>
                                            <td play="h2" class="none"><span class="orange">连号</span><span class="gray666">大单</span><span class="gray666">大双</span></td>
                                        </tr><tr> <td class="gray">072</td>
                                            <td>0 3 <em class="red">6 8 2</em></td>
                                            <td play="h3"><span class="gray">组六</span><span class="gray666">2:1</span><span class="gray666">0:3</span></td>
                                            <td play="h2" class="none"><span class="gray">&nbsp;</span><span class="gray666">大双</span><span class="gray666">小双</span></td>
                                        </tr><tr> <td class="gray">071</td>
                                            <td>6 5 <em class="red">3 2 5</em></td>
                                            <td play="h3"><span class="gray">组六</span><span class="gray666">1:2</span><span class="gray666">2:1</span></td>
                                            <td play="h2" class="none"><span class="gray">&nbsp;</span><span class="gray666">小双</span><span class="gray666">大单</span></td>
                                        </tr><tr> <td class="gray">070</td>
                                            <td>3 4 <em class="red">3 7 7</em></td>
                                            <td play="h3"><span class="orange">组三</span><span class="gray666">2:1</span><span class="gray666">3:0</span></td>
                                            <td play="h2" class="none"><span class="green">对子</span><span class="gray666">大单</span><span class="gray666">大单</span></td>
                                        </tr><tr> <td class="gray">069</td>
                                            <td>7 7 <em class="red">7 5 1</em></td>
                                            <td play="h3"><span class="gray">组六</span><span class="gray666">2:1</span><span class="gray666">3:0</span></td>
                                            <td play="h2" class="none"><span class="gray">&nbsp;</span><span class="gray666">大单</span><span class="gray666">小单</span></td>
                                        </tr>                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div style="margin-top: 6px;" class="ft text-right muted"><a class="lnk" target="_blank" href="http://chart.cp.360.cn/kaijiang/ssccq/">查询历史开奖</a> | <a class="lnk" target="_blank" href="http://chart.cp.360.cn/zst/ssccq/">查看走势图表</a></div>
                    </div>
                    <div class="mod-aside mod-aside-t4">
                        <div id="yilou" class="hd clearfix">
                            <h3>形态统计</h3>
                            <div class="nav-tab">
                                <ul class="clearfix">
                                    <li class="first active"><a href="#">今天</a></li>
                                    <li><a href="#">昨天</a></li>
                                    <li><a href="#">前天</a></li>
                                </ul>
                            </div>
                        </div>
                        <div id="yilou_content" class="bd">
                                                        <div class="tab-content">
                                <div class="tab-pane active">
                                    <p class="muted">统计以下几种形态，今天出现多少次</p>
                                    <ul class="list-ball-t1">
                                        <li>
                                                <div class="k">三星组三</div><div class="progress progress-t3"><div style="width: 43%;" class="bar"></div></div><span class="txt-2"><b class="red">23</b>次</span>
                                            </li><li>
                                                <div class="k">三星组六</div><div class="progress progress-t3"><div style="width: 100%;" class="bar"></div></div><span class="txt-2"><b class="red">53</b>次</span>
                                            </li><li>
                                                <div class="k">三星豹子</div><div class="progress progress-t3"><div style="width: 4%;" class="bar"></div></div><span class="txt-2"><b class="red">2</b>次</span>
                                            </li><li>
                                                <div class="k">二星对子</div><div class="progress progress-t3"><div style="width: 21%;" class="bar blue-bar"></div></div><span class="txt-2"><b class="red">11</b>次</span>
                                            </li><li>
                                                <div class="k">二星连号</div><div class="progress progress-t3"><div style="width: 25%;" class="bar blue-bar"></div></div><span class="txt-2"><b class="red">13</b>次</span>
                                            </li><li>
                                                <div class="k kwauto">三星组六最大连出：</div><span class="txt-2"><b class="red">7</b>次</span>
                                            </li><li>
                                                <div class="k kwauto">三星组三最大连出：</div><span class="txt-2"><b class="red">2</b>次</span>
                                            </li>                                    </ul>
                                </div>
                                <div class="tab-pane" style="display: none;">
                                    <p class="muted">统计以下几种形态，昨天出现多少次</p>
                                    <ul class="list-ball-t1">
                                        <li>
                                                <div class="k">三星组三</div><div class="progress progress-t3"><div style="width: 43%;" class="bar"></div></div><span class="txt-2"><b class="red">36</b>次</span>
                                            </li><li>
                                                <div class="k">三星组六</div><div class="progress progress-t3"><div style="width: 100%;" class="bar"></div></div><span class="txt-2"><b class="red">83</b>次</span>
                                            </li><li>
                                                <div class="k">三星豹子</div><div class="progress progress-t3"><div style="width: 0%;" class="bar"></div></div><span class="txt-2"><b class="red">0</b>次</span>
                                            </li><li>
                                                <div class="k">二星对子</div><div class="progress progress-t3"><div style="width: 11%;" class="bar blue-bar"></div></div><span class="txt-2"><b class="red">9</b>次</span>
                                            </li><li>
                                                <div class="k">二星连号</div><div class="progress progress-t3"><div style="width: 29%;" class="bar blue-bar"></div></div><span class="txt-2"><b class="red">24</b>次</span>
                                            </li><li>
                                                <div class="k kwauto">三星组六最大连出：</div><span class="txt-2"><b class="red">9</b>次</span>
                                            </li><li>
                                                <div class="k kwauto">三星组三最大连出：</div><span class="txt-2"><b class="red">3</b>次</span>
                                            </li>                                    </ul>
                                </div>
                                <div class="tab-pane" style="display: none;">
                                    <p class="muted">统计以下几种形态，前天出现多少次</p>
                                    <ul class="list-ball-t1">
                                        <li>
                                                <div class="k">三星组三</div><div class="progress progress-t3"><div style="width: 28%;" class="bar"></div></div><span class="txt-2"><b class="red">26</b>次</span>
                                            </li><li>
                                                <div class="k">三星组六</div><div class="progress progress-t3"><div style="width: 100%;" class="bar"></div></div><span class="txt-2"><b class="red">93</b>次</span>
                                            </li><li>
                                                <div class="k">三星豹子</div><div class="progress progress-t3"><div style="width: 0%;" class="bar"></div></div><span class="txt-2"><b class="red">0</b>次</span>
                                            </li><li>
                                                <div class="k">二星对子</div><div class="progress progress-t3"><div style="width: 9%;" class="bar blue-bar"></div></div><span class="txt-2"><b class="red">8</b>次</span>
                                            </li><li>
                                                <div class="k">二星连号</div><div class="progress progress-t3"><div style="width: 26%;" class="bar blue-bar"></div></div><span class="txt-2"><b class="red">24</b>次</span>
                                            </li><li>
                                                <div class="k kwauto">三星组六最大连出：</div><span class="txt-2"><b class="red">12</b>次</span>
                                            </li><li>
                                                <div class="k kwauto">三星组三最大连出：</div><span class="txt-2"><b class="red">2</b>次</span>
                                            </li>                                    </ul>
                                </div>

                            </div>

                        </div>
                    </div>
                    <div class="mod-aside">
        <div class="hd clearfix">
            <h3>走势图表</h3>
            <a class="more" target="_blank" href="http://chart.cp.360.cn/zst/ssccq/?sb_spm=93f1c1fccf8878f94e0802e5357a7e77">更多&gt;&gt;</a>
        </div>
        <div class="bd">
            <ul style="padding-top:10px;" class="list list-h">
                <li>
                    <a href="http://chart.cp.360.cn/zst/getchartdata?sb_spm=d7925bbf6e67754f224a810c9a52c3c8&amp;lotId=255401&amp;chartType=x5" class="ib" target="_blank">五星走势图</a>
                    <a href="http://chart.cp.360.cn/zst/getchartdata?sb_spm=f5680ee5882ca165a8c5bd742e714cbf&amp;lotId=255401&amp;chartType=x2zhx" class="ib" target="_blank">二星直选图</a>
                    <a href="http://chart.cp.360.cn/zst/getchartdata?sb_spm=ac6137b13706d45d7eb9b6fde87d210a&amp;lotId=255401&amp;chartType=x3zx" class="ib" target="_blank">三星组选图</a>
                </li>
                <li>
                    <a href="http://chart.cp.360.cn/zst/getchartdata?sb_spm=e2a543e01421a373840fd73ed6de3272&amp;lotId=255401&amp;chartType=dww5" class="ib" target="_blank">一星走势图</a>
                    <a href="http://chart.cp.360.cn/zst/getchartdata?sb_spm=8e9169a066eb3743ac2b207ed3c63950&amp;lotId=255401&amp;chartType=x2kd" class="ib" target="_blank">二星跨度图</a>
                    <a href="http://chart.cp.360.cn/zst/getchartdata?sb_spm=782f0b8d8ea9f6c302cbb184eeece6b1&amp;lotId=255401&amp;chartType=x3hz" class="ib" target="_blank">三星和值图</a>
                </li>
                <li>
                    <a href="http://chart.cp.360.cn/zst/getchartdata?sb_spm=fa9e802af0712885a5f54edfc78228ab&amp;lotId=255401&amp;chartType=dxds" class="ib" target="_blank">大小单双图</a>
                    <a href="http://chart.cp.360.cn/zst/getchartdata?sb_spm=f22363fd96f5c774200f8f53bbbc056b&amp;lotId=255401&amp;chartType=x2012" class="ib" target="_blank">二星012路图</a>
                    <a href="http://chart.cp.360.cn/zst/getchartdata?sb_spm=6056222a0fbf4c6a32f90ab8df1bcc86&amp;lotId=255401&amp;chartType=x3pj" class="ib" target="_blank">三星均值图</a>
                </li>
                <li>
                    <a href="http://zst.cp.360.cn/chart.html?sb_spm=6dd69836d232a908ddaea892acb9c770&amp;LotID=10401&amp;ChartID=20343&amp;StatType=1&amp;MinIssue=130502050&amp;MaxIssue=130506075&amp;IssueTop=500&amp;ChartType=4&amp;tab=-1" class="ib" target="_blank">遗漏统计图</a>
                    <a href="http://chart.cp.360.cn/zst/getchartdata?sb_spm=843952d2ffb5ab555a4470aec9da0905&amp;lotId=255401&amp;chartType=x2spj" class="ib" target="_blank">二星升平降图</a>
                    <a href="http://chart.cp.360.cn/zst/getchartdata?sb_spm=8ab9d59f72eb65deef62e2253824fef0&amp;lotId=255401&amp;chartType=x3kd" class="ib" target="_blank">三星跨度图</a>
                </li>
            </ul>
        </div>
    </div>
                    <div class="mod-aside">
    <div class="hd clearfix">
        <h3>投注技巧</h3>
        <a href="http://bbs.360safe.com/forum-246-1.html" target="_blank" class="more">更多&gt;&gt;</a>
    </div>
    <div class="bd">
        <ul class="list">
            <li><a href="http://bbs.360safe.com/thread-2912195-1-1.html" target="_blank">时时彩投注技巧之：遗漏追号三种玩法</a></li>
            <li><a href="http://bbs.360safe.com/thread-2912187-1-1.html" target="_blank">时时彩投注技巧之：新手要避免的错误</a></li>
            <li><a href="http://bbs.360safe.com/thread-2912159-1-1.html" target="_blank">时时彩投注技巧之：三种出号理论概率</a></li>
            <li><a href="http://bbs.360safe.com/thread-2912137-1-1.html" target="_blank">时时彩投注技巧之：用重号排除杀号法</a></li>
            <li><a href="http://bbs.360safe.com/thread-2912116-1-1.html" target="_blank">时时彩投注技巧之：倍投拆分勿需犹豫</a></li>
            <li><a href="http://bbs.360safe.com/thread-2912111-1-1.html" target="_blank">时时彩投注技巧之：胆拖投注定胆方法</a></li>
            <li><a href="http://bbs.360safe.com/thread-2912103-1-1.html" target="_blank">时时彩投注技巧之：三种出号理论概率</a></li>
            <li><a href="http://bbs.360safe.com/thread-2912092-1-1.html" target="_blank">时时彩投注技巧之：三星组六简介技巧</a></li>
            <li><a href="http://bbs.360safe.com/thread-2912068-1-1.html" target="_blank">时时彩投注技巧之：二星追号的三方法</a></li>
            <li><a href="http://bbs.360safe.com/thread-2912038-1-1.html" target="_blank">时时彩投注技巧之：一星还可以这样玩</a></li>
        </ul>
    </div>
</div>
                        <div class="mod-aside mod-aside-t3">
        <div class="hd clearfix">
            <h3>排行榜</h3>
            <div id="paihang" class="nav-tab">
                <ul class="clearfix">
                    <li class="first active"><a href="#">日榜</a></li>
                    <li><a href="#">周榜</a></li>
                    <li><a href="#">总榜</a></li>                    </ul>
            </div>
        </div>
        <div class="bd">
            <div id="paihang_content" class="tab-content">
                <div class="tab-pane none" style="display: block;"><ul class="list-ball-t2 clearfix">
                        <li>
				    	    <span class="ico-ball">1</span>
                            <span class="name">x**</span>
                            <span class="money">10100元</span>
                        </li>
                        <li>
				    	    <span class="ico-ball">2</span>
                            <span class="name">2**</span>
                            <span class="money">7200元</span>
                        </li>
                        <li>
				    	    <span class="ico-ball">3</span>
                            <span class="name">a**</span>
                            <span class="money">7000元</span>
                        </li>
                        <li>
				    	    <span class="ico-ball ico-ball-dis">4</span>
                            <span class="name">y**</span>
                            <span class="money money2">6500元</span>
                        </li>
                        <li>
				    	    <span class="ico-ball ico-ball-dis">5</span>
                            <span class="name">z**</span>
                            <span class="money money2">5000元</span>
                        </li>
                        <li>
				    	    <span class="ico-ball ico-ball-dis">6</span>
                            <span class="name">我**</span>
                            <span class="money money2">3400元</span>
                        </li>
                        <li>
				    	    <span class="ico-ball ico-ball-dis">7</span>
                            <span class="name">y**</span>
                            <span class="money money2">3300元</span>
                        </li>
                        <li>
				    	    <span class="ico-ball ico-ball-dis">8</span>
                            <span class="name">烟**</span>
                            <span class="money money2">3200元</span>
                        </li>
                        <li>
				    	    <span class="ico-ball ico-ball-dis">9</span>
                            <span class="name">y**</span>
                            <span class="money money2">2660元</span>
                        </li>
                        <li>
				    	    <span class="ico-ball ico-ball-dis">10</span>
                            <span class="name">王**</span>
                            <span class="money money2">2000元</span>
                        </li></ul></div><div class="tab-pane active" style="display: none;"><ul class="list-ball-t2 clearfix">
                        <li>
				    	    <span class="ico-ball">1</span>
                            <span class="name">y**</span>
                            <span class="money">173700元</span>
                        </li>
                        <li>
				    	    <span class="ico-ball">2</span>
                            <span class="name">y**</span>
                            <span class="money">28200元</span>
                        </li>
                        <li>
				    	    <span class="ico-ball">3</span>
                            <span class="name">j**</span>
                            <span class="money">20800元</span>
                        </li>
                        <li>
				    	    <span class="ico-ball ico-ball-dis">4</span>
                            <span class="name">x**</span>
                            <span class="money money2">17000元</span>
                        </li>
                        <li>
				    	    <span class="ico-ball ico-ball-dis">5</span>
                            <span class="name">z**</span>
                            <span class="money money2">14000元</span>
                        </li>
                        <li>
				    	    <span class="ico-ball ico-ball-dis">6</span>
                            <span class="name">X**</span>
                            <span class="money money2">13800元</span>
                        </li>
                        <li>
				    	    <span class="ico-ball ico-ball-dis">7</span>
                            <span class="name">龙**</span>
                            <span class="money money2">11880元</span>
                        </li>
                        <li>
				    	    <span class="ico-ball ico-ball-dis">8</span>
                            <span class="name">绝**</span>
                            <span class="money money2">11520元</span>
                        </li>
                        <li>
				    	    <span class="ico-ball ico-ball-dis">9</span>
                            <span class="name">x**</span>
                            <span class="money money2">10100元</span>
                        </li>
                        <li>
				    	    <span class="ico-ball ico-ball-dis">10</span>
                            <span class="name">狐**</span>
                            <span class="money money2">10000元</span>
                        </li></ul></div><div class="tab-pane none" style="display: none;"><ul class="list-ball-t2 clearfix">
                        <li>
				    	    <span class="ico-ball">1</span>
                            <span class="name">l**</span>
                            <span class="money">7758500元</span>
                        </li>
                        <li>
				    	    <span class="ico-ball">2</span>
                            <span class="name">黄**</span>
                            <span class="money">2371000元</span>
                        </li>
                        <li>
				    	    <span class="ico-ball">3</span>
                            <span class="name">l**</span>
                            <span class="money">1988100元</span>
                        </li>
                        <li>
				    	    <span class="ico-ball ico-ball-dis">4</span>
                            <span class="name">L**</span>
                            <span class="money money2">1286240元</span>
                        </li>
                        <li>
				    	    <span class="ico-ball ico-ball-dis">5</span>
                            <span class="name">X**</span>
                            <span class="money money2">1103500元</span>
                        </li>
                        <li>
				    	    <span class="ico-ball ico-ball-dis">6</span>
                            <span class="name">s**</span>
                            <span class="money money2">912480元</span>
                        </li>
                        <li>
				    	    <span class="ico-ball ico-ball-dis">7</span>
                            <span class="name">y**</span>
                            <span class="money money2">891160元</span>
                        </li>
                        <li>
				    	    <span class="ico-ball ico-ball-dis">8</span>
                            <span class="name">z**</span>
                            <span class="money money2">851480元</span>
                        </li>
                        <li>
				    	    <span class="ico-ball ico-ball-dis">9</span>
                            <span class="name">c**</span>
                            <span class="money money2">722140元</span>
                        </li>
                        <li>
				    	    <span class="ico-ball ico-ball-dis">10</span>
                            <span class="name">j**</span>
                            <span class="money money2">677000元</span>
                        </li></ul></div>
               <div class="tab-pane"></div>
            </div>
        </div>
    </div>
</div>

                <!--  -->
            </div>
            <!--  -->
        </div>
        <!--  -->
    </div>
                </div>


        <!-- jQuery 2.0.2 -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="../../js/bootstrap.min.js" type="text/javascript"></script>
        <!-- AdminLTE App -->
        <script src="../../js/AdminLTE/app.js" type="text/javascript"></script>

        
        <script type="text/javascript">
            window.lott_info = {
            lott_type_id : '258001' * 1, //彩种ID
            play_id : '', //玩法ID,各别彩种有
            path : '/sscjx', //彩种路径
            name : '新时时彩', //彩种名称
            issue : '150117014', //当前期号
            is_sale : ('1') * 1, //是否销售
            is_kaijiang : ('0') * 1, //是否今日开奖
            is_jiajiang : ('01') * 1, //是否加奖 
            own_perc : '0.05' * 1, //发起人最低认购比例
            max_mul : '099999' * 1 || 999999, //最大投注倍数
            float_perc : '0.2' * 1 + 1, //先发起后上传浮动比例
            sys_time : '1421464494', //系统时间
            open_time : '68', //快频开奖时间
            endtime : '1421464856', //代购截止时间
            update_open_code_wait : '50' * 1, //获取新期次后内多少秒后开始获取开奖号码
            sale_time : '', //每期开售时间
            ds_pre_time : '0' * 1, //单式上传截止前多少秒限制注数
            zh_stop_money : '0' * 1, //中奖停追金额
            ds_pre_max_count : '20000' * 1//限制注数是多少
            }; 
            </script>
            <script language="javascript" src="../../../js/lottery/jquery.lottery.js"></script>
            
            <script src="http://s5.cp.360.cn/trade/2013/static/v1/js/src/lib/jquery-1.10.2.min.js"></script>
            <script src="http://s6.cp.360.cn/trade/2013/static/v1/js/src/lib/underscore-min.js"></script>
            <script src="http://s6.cp.360.cn/trade/merge/BNzyAvI3euey.js?v1.0.83.js"></script>
            <script src="http://s6.cp.360.cn/trade/merge/baYJNbvURv6f.js?v1.0.83.js"></script>
            <script src="http://s5.cp.360.cn/trade/2013/static/v1/js/lottery/public/filter.js?v1.0.83.js"></script>
            <script src="http://s6.cp.360.cn/trade/2013/static/v1/js/lottery/jxssc/index.js?v1.0.83.js"></script>
        <script>
</BODY>
</HTML><?php }?>