<?php defined( 'BASEPATH') OR exit( 'No direct script access allowed'); 

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>EuroZoneGlobal</title>

    <!-- Bootstrap -->
    <link href="<?php echo base_url("assets/vendors/bootstrap/dist/css/bootstrap.min.css");?>" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?php echo base_url("assets/vendors/font-awesome/css/font-awesome.min.css");?>" rel="stylesheet">

    <link href="<?php echo base_url("assets/vendors/animate.css/animate.min.css");?>" rel="stylesheet">

    <!-- NProgress -->
    <link href="<?php echo base_url("assets/vendors/nprogress/nprogress.css");?>" rel="stylesheet">
    <!-- iCheck -->
    <link href="<?php echo base_url("assets/vendors/iCheck/skins/flat/green.css");?>" rel="stylesheet">
    <!-- bootstrap-progressbar -->
    <link href="<?php echo base_url("assets/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css");?>" rel="stylesheet">
    <!-- JQVMap -->
    <link href="<?php echo base_url("assets/vendors/jqvmap/dist/jqvmap.min.css");?>" rel="stylesheet"/>

    <!-- Custom Theme Style -->
    <link href="<?php echo base_url("assets/build/css/custom.min.css");?>" rel="stylesheet">

    <!-- Favicon and touch icons -->
    <link rel="shortcut icon" href="<?php echo base_url("assets/ico/euro-xxl.png"); ?>">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo base_url("assets/ico/euro-xxl.png"); ?>">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo base_url("assets/ico/euro-xxl.png"); ?>">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo base_url("assets/ico/euro-xxl.png"); ?>">
    <link rel="apple-touch-icon-precomposed" href="<?php echo base_url("assets/ico/euro-xxl.png"); ?>">

    <!-- Datatables -->
    <link href="<?php echo base_url("assets/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css");?>" rel="stylesheet">
    <link href="<?php echo base_url("assets/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css");?>" rel="stylesheet">
    <link href="<?php echo base_url("assets/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css");?>" rel="stylesheet">
    <link href="<?php echo base_url("assets/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css");?>" rel="stylesheet">
    <link href="<?php echo base_url("assets/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css");?>" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.css">


  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="<?php echo base_url('dashboard');?>" class="site_title"><!--<i class="fa fa-paw">--></i> 
              <span class="glyphicon glyphicon-euro"></span>
              <span>EuroZoneGlobal</span></a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->

            <div class="profile">
            <div class="profile_pic">

                <img src="<?php echo base_url("assets/images/photo.jpg");?>" alt="..." class="img-circle profile_img">

              </div>
              <div class="profile_info">
                <span>Welcome,</span>
                <h2><?php //echo $uname; ?></h2>
              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3><?php echo $uname; ?></h3>
                <ul class="nav side-menu">
                  <li><a><i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?php echo base_url('dashboard');?>">Dashboard</a></li>
                      <!--
                      <li><a href="index2.html">Dashboard2</a></li>
                      <li><a href="index3.html">Dashboard3</a></li>
                      -->
                    </ul>
                  </li>

<!-- menu for admin & members only -->
                  <?php if ($role==1 || $role==3) { ?>
                  <li><a><i class="fa fa-desktop"></i> Network & Bonus <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?php echo base_url("reg_downline");?>">Register Downline</a></li>
<!--
                      <li><a href="#">Upgrade Package</a></li>
-->
                      <li><a href="<?php echo base_url("downline");?>">Downline List</a></li>
                      <li><a href="<?php echo base_url("bonus");?>">Bonus List</a></li>
<!--
                      <li><a href="#">Bonus Statement</a></li>
                      <li><a href="glyphicons.html">Glyphicons</a></li>
                      <li><a href="widgets.html">Widgets</a></li>
                      <li><a href="invoice.html">Invoice</a></li>
                      <li><a href="inbox.html">Inbox</a></li>
                      <li><a href="calendar.html">Calendar</a></li>
-->
                    </ul>
                  </li>
                  <?php } ?>
<!-- end menu for admin & members only -->

<!-- menu for paymaster, members -->
                  <?php //if ($role==2 || $role==3) { ?>
                  <li><a><i class="fa fa-table"></i>Wallet<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?php echo base_url("wallet");?>">Wallet Transfer</a></li>
                      <li><a href="<?php echo base_url("cash");?>">Cash Transaction</a></li>
                      <li><a href="<?php echo base_url("register");?>">Register Transaction</a></li>
<!-- 
                      <li><a href="#">Reg Upgrade Wallet Transaction</a></li>
                      <li><a href="#">Sponsor Wallet Transaction</a></li>
                      <li><a href="#">Sponsor Wallet Transfer</a></li>
-->
                    </ul>
                  </li>
                  <?php //} ?>
<!-- end menu for paymaster -->

<!-- withdrawall --
                  <li><a><i class="fa fa-bar-chart-o"></i> Withdrawal <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="#">Withdrawal</a></li>
                      <li><a href="#">Withdrawal Status</a></li>
                      
                      <li><a href="morisjs.html">Moris JS</a></li>
                      <li><a href="echarts.html">ECharts</a></li>
                      <li><a href="other_charts.html">Other Charts</a></li>

                    </ul>
end of withdrawa-->
                  <li><a><i class="fa fa-edit"></i> Profile <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?php echo base_url("profile");?>">View Profile</a></li>
                      <li><a href="<?php echo base_url("change_pass");?>">Change Password</a></li>
                      <li><a href="<?php echo base_url("login_new/logout");?>">Logout</a></li>
                      <!--
                      <li><a href="form_wizards.html">Form Wizard</a></li>
                      <li><a href="form_upload.html">Form Upload</a></li>
                      <li><a href="form_buttons.html">Form Buttons</a></li>
                      -->
                    </ul>
                  </li>

                  </li>

<!-- menu for admin -->
                  <?php if ($role==1) { ?>
                  <li><a><i class="fa fa-clone"></i>Admin <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?php echo base_url("manage/user");?>">Manage User</a></li>
                      <li><a href="<?php echo base_url("manage/passwd");?>">Reset Password</a></li>
                      <li><a href="<?php echo base_url("manage");?>">Setting</a></li>
                    </ul>
                  </li>
                  <?php } ?>
<!-- end menu for admin -->

                </ul>
              </div>
              <!--
              <div class="menu_section">
                <h3>Live On</h3>
                <ul class="nav side-menu">
                  <li><a><i class="fa fa-bug"></i> Additional Pages <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="e_commerce.html">E-commerce</a></li>
                      <li><a href="projects.html">Projects</a></li>
                      <li><a href="project_detail.html">Project Detail</a></li>
                      <li><a href="contacts.html">Contacts</a></li>
                      <li><a href="<?php echo base_url('profile');?>">Profile</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-windows"></i> Extras <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="page_403.html">403 Error</a></li>
                      <li><a href="page_404.html">404 Error</a></li>
                      <li><a href="page_500.html">500 Error</a></li>
                      <li><a href="plain_page.html">Plain Page</a></li>
                      <li><a href="login.html">Login Page</a></li>
                      <li><a href="pricing_tables.html">Pricing Tables</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-sitemap"></i> Multilevel Menu <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="#level1_1">Level One</a>
                        <li><a>Level One<span class="fa fa-chevron-down"></span></a>
                          <ul class="nav child_menu">
                            <li class="sub_menu"><a href="level2.html">Level Two</a>
                            </li>
                            <li><a href="#level2_1">Level Two</a>
                            </li>
                            <li><a href="#level2_2">Level Two</a>
                            </li>
                          </ul>
                        </li>
                        <li><a href="#level1_2">Level One</a>
                        </li>
                    </ul>
                  </li>                  
                  <li><a href="javascript:void(0)"><i class="fa fa-laptop"></i> Landing Page <span class="label label-success pull-right">Coming Soon</span></a></li>
                </ul>
              </div>
              -->
            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small">

              <a data-toggle="tooltip" data-placement="top" title="">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
              </a>

              <a data-toggle="tooltip" data-placement="top" title="Logout" href="<?php echo base_url("login_new/logout"); ?>">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>
            </div>
            <!-- /menu footer buttons -->
          </div>
        </div>
        </body>
      </html>