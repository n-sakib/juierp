
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>পি.ও.এস</title>

    <link rel="stylesheet" type="text/css" href="template/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="template/font-awesome/css/font-awesome.min.css" />
    <link rel="stylesheet" type="text/css" href="template/css/local.css" />

    <script type="text/javascript" src="template/js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="template/bootstrap/js/bootstrap.min.js"></script>

<!-- v 0.1 
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="font-awesome/css/font-awesome.min.css" />
    <link rel="stylesheet" type="text/css" href="css/local.css" />

    <script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
-->

    <!-- you need to include the shieldui css and js assets in order for the charts to work -->
    <!--
    <link rel="stylesheet" type="text/css" href="http://www.shieldui.com/shared/components/latest/css/shieldui-all.min.css" />
    <link rel="stylesheet" type="text/css" href="http://www.shieldui.com/shared/components/latest/css/light-bootstrap/all.min.css" />
    <link id="gridcss" rel="stylesheet" type="text/css" href="http://www.shieldui.com/shared/components/latest/css/dark-bootstrap/all.min.css" />

    <script type="text/javascript" src="http://www.shieldui.com/shared/components/latest/js/shieldui-all.min.js"></script>
    <script type="text/javascript" src="http://www.prepbootstrap.com/Content/js/gridData.js"></script> -->
</head>
<body>

    <div id="wrapper">

          <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html">ই. আর. পি</a>
                <!-- <button class="btn btn-primary refresh-btn cur fa fa-refresh fa-lg pull-right"></button> -->
            </div>

            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul id="active" class="nav navbar-nav side-nav">
                    <!-- <li class="selected"> -->
                    <li class="<?php echo @$bikri ?>"><a href="sell.php"><i class="fa fa-briefcase"></i> বিক্রি</a></li>
                    <li class="<?php echo @$kena ?>"><a href="purchase.php"><i class="fa fa-shopping-cart"></i> কেনা</a></li>
                    <li class="<?php echo @$ferot ?>"><a href="purchase.php"><i class="fa fa-undo"></i> ফেরত</a></li>
                    <li class="<?php echo @$mojud ?>"><a href="inventory.php"><i class="fa fa-dropbox"></i> মজুদ</a></li>
                    <li class="<?php echo @$report ?>"><a href="reports.php"><i class="fa fa-table"></i> রিপোর্ট</a></li>
                    <li class="<?php echo @$profile ?>"><a href="profiles.php"><i class="fa fa-users"></i> প্রফাইলসমুহ</a></li>
<!--                     <li><a href="timeline.html"><i class="fa fa-font"></i> Timeline</a></li>
                    <li><a href="forms.html"><i class="fa fa-list-ol"></i> Forms</a></li>
                    <li><a href="typography.html"><i class="fa fa-font"></i> Typography</a></li>
                    <li><a href="bootstrap-elements.html"><i class="fa fa-list-ul"></i> Bootstrap Elements</a></li>
                    <li><a href="bootstrap-grid.html"><i class="fa fa-table"></i> Bootstrap Grid</a></li> -->
                </ul>

                <ul class="nav navbar-nav navbar-right navbar-user">
                    <li class="dropdown messages-dropdown">
                        <!-- <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-envelope"></i> Messages <span class="badge">2</span> <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li class="dropdown-header">2 New Messages</li>
                            <li class="message-preview">
                                <a href="#">
                                    <span class="avatar"><i class="fa fa-bell"></i></span>
                                    <span class="message">Security alert</span>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li class="message-preview">
                                <a href="#">
                                    <span class="avatar"><i class="fa fa-bell"></i></span>
                                    <span class="message">Security alert</span>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li><a href="#">Go to Inbox <span class="badge">2</span></a></li>
                        </ul> -->
                    </li>
                    <?php 
                        require_once '../model/user.php';               

                        include '../view/sections/top-bar-login-form.php';
                        @session_start();
                     ?>
                    

                    <li class="divider-vertical"></li>
                    <li class="dropdown user-dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i><?php if(isset($_SESSION['user'])){echo $_SESSION['user'];} ?><b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="#"><i class="fa fa-user"></i> প্রোফাইল</a></li>
                            <li class="divider"></li>
                            <li><a href="logout.php"><i class="fa fa-power-off"></i> লগ আউট</a></li>

                        </ul>
                    </li>
                    
                    <!-- <li>
                        <form class="navbar-search">
                            <input type="text" placeholder="Search" class="form-control">
                        </form>
                    </li> -->
                </ul>
            </div>
        </nav>
<div id="page-wrapper">
    <div class="row">