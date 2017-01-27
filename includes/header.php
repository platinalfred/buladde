<?php
session_start();
require_once("lib/Libraries.php");
$staff = new Staff();
$logged = $_SESSION["Logged"];

if(!$logged){
	header("Location:index.php");
}
$logged_in_user = $staff->findNamesById($_SESSION['id']);
$foto = $staff->findPersonsPhoto($_SESSION['person_number']);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="apple-touch-icon" sizes="57x57" href="img/fav.png">
	<link rel="icon" type="image/png" sizes="16x16" href="img/fav.png">
    <title>Buladde Financial Services - <?php echo isset($page_title)?$page_title:"";?></title>
	<link rel="icon" href="img/fav.png" type="image/x-icon">
    <!-- Bootstrap -->
    <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- bootstrap-daterangepicker -->
    <link href="vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
	<!-- iCheck -->
    <link href="vendors/iCheck/skins/flat/green.css" rel="stylesheet">
	<link href="css/general.css" rel="stylesheet">
	<?php 
	if($show_table_js){ ?>
		 <!-- Datatables -->
		<link href="vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
		<link href="vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
		<link href="vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
		<link href="vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
		<link href="vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
	<?php 
	}
	?>
	 <!-- PNotify -->
    <link href="vendors/pnotify/dist/pnotify.css" rel="stylesheet">
    <link href="vendors/pnotify/dist/pnotify.buttons.css" rel="stylesheet">
    <link href="vendors/pnotify/dist/pnotify.nonblock.css" rel="stylesheet">

    <!-- bootstrap-wysiwyg -->
    <!-- Custom Theme Style -->
    <link href="build/css/custom.min.css" rel="stylesheet">
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col menu_fixed">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
				<img src="img/logo.png" style="width:70%;margin-top:10px;margin-left: 6%;"/>
            </div>
            <div class="clearfix"></div>
           <div class="profile">
              <div class="profile_pic">
                <img src="<?php if($foto){ echo $foto; }else{ echo "img/profiles/blank.png"; }; ?>" style="width:56px; height:56px;"  alt="profile photo" class="img-circle profile_img">
              </div>
              <div class="profile_info">
                <span>Welcome,</span>
                <h2><?php echo $_SESSION['username']; ?></h2>
              </div>
            </div>
			
			<div class="clearfix"></div>
            <hr style="background:#ddd; height:2px;" />
			  <div class="clearfix"></div>
            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <!--<h3>General</h3>-->
                <ul class="nav side-menu">
			<?php if(isset($_SESSION['access_level'])&&in_array($_SESSION['access_level'],array(1,2))){?>
                  <li><a href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>
                  </li>
                  <li><a><i class="fa fa-edit"></i> Reports <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
					  <li><a href="view_loans.php">Loans</a></li>
                      <li><a href="view_shares.php">Shares</a></li>
                      <li><a href="view_subscriptions.php">Subscriptions</a></li>
                      <li><a href="view_ledger.php">Ledger</a></li>
                      <li><a href="view_member_savings.php">Member's Savings</a></li>
                       <li><a href="#">Inactive Accounts</a></li>
					   <li><a href="#">Log Reports</a></li>
                    </ul>
                  </li>
				   <li><a href="view_income.php"> <i class="fa fa-money"></i>Income</a></li>
				  <?php 
				  }else{?>
					<li><a href="view_loans.php"><i class="fa fa-money"></i> Loans</a> </li>
					<?php 
				  }?>
				  
                  <li><a href="view_members.php"><i class="fa fa-users"></i> Members</a> </li>
				  
				  <?php
				  if(isset($_SESSION['access_level'])&&in_array($_SESSION['access_level'],array(1,2))){?>
                  <li><a href="staff.php"><i class="fa fa-users"></i>Staff</a></li>
				  <?php }?>
				  
                  <li><a href="view_expenses.php"><i class="fa fa-table"></i>Expenses</a></li>
                  <li><a href="manage_accounts.php"><i class="fa fa-user"></i>Manage Accounts</a> </li>
                </ul>
              </div>
			<?php if(isset($_SESSION['access_level'])&&in_array($_SESSION['access_level'],array(1,2))){?>
              <div class="menu_section">
                <h3>More</h3>
                <ul class="nav side-menu">
                  <li><a href="settings.php"><i class="fa fa-gear"></i> Settings <span class="fa fa-chevron-right"></span></a>
                    <!--<ul class="nav child_menu">
						<li><a href="#">Security Types</a></li>
						<li><a href="#">Member Types</a></li>
						<li><a href="#">Person Types</a></li>
						<li><a href="#">Account Type</a></li>
						<li><a href="#">Branches</a></li>
					    <li><a href="#">Access Levels</a></li>
						<li><a href="#">Loan Types</a></li>
                    </ul>-->
                  </li>
                </ul>
              </div>
			<?php }?>

            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small">
              <a data-toggle="tooltip" href="settings.php" data-placement="top" title="Settings">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" href="logout.php" data-placement="top" title="Logout">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>
            </div>
            <!-- /menu footer buttons -->
          </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>
				<div class="col-md-4">
					<div  id="notice_message" >
						<div id="top_message" >
							<span id="notice">
								
							</span>
						</div>
					</div>
				</div>
				
				<ul class="nav navbar-nav navbar-right">
					<li class="">
					  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
						<img src="<?php if($foto){ echo $foto; }else{ echo "img/profiles/blank.png"; }; ?>" alt=""><?php   echo $_SESSION['username']; ?>
						<span class=" fa fa-angle-down"></span>
					  </a>
					  <ul class="dropdown-menu dropdown-usermenu pull-right">
						<li><a href="javascript:;"> Profile</a></li>
						<li><a href="javascript:;">Help</a></li>
						<li><a href="logout.php"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
					  </ul>
					</li>
				</ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->
