<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TRILOCOR Shop | <?php echo $currentPage; ?></title>
    <link rel="shortcut icon" type="image/jpg" href="/assets/images/icons/favicon.ico" />
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../assets/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="../../assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="../../assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="../../assets/plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../assets/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="../../assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="../../assets/plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="../../assets/plugins/summernote/summernote-bs4.min.css">
    <!-- Calendar -->
    <link rel="stylesheet" href="../../assets/plugins/fullcalendar/main.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <?php
    if ($currentPage === 'Dashboard') {
      echo '<div class="preloader flex-column justify-content-center align-items-center"><img class="animation__shake" src="../../assets/images/icons/favicon.ico" height="60" width="60"></div>';
    }
    ?>

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Notifications Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-bell"></i>
                        <span class="badge badge-warning navbar-badge">2</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-item dropdown-header">2 Notifications</span>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-file mr-2"></i> Order shipped
                            <span class="float-right text-muted text-sm">2 days</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-file mr-2"></i> Order shipped
                            <span class="float-right text-muted text-sm">5 days</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/logout" role="button">
                        <i class="fa fa-sign-out-alt"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="#" class="brand-link">
                <img src="../../assets/images/icons/favicon.ico" alt="AdminLTE Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">TRILOCOR ROBOTICS</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="../../assets/images/user2-160x160.jpg" class="img-circle elevation-2"
                            alt="User Image">
                    </div>
                    <div class="info">
                        <div class="row">
                            <h6 style="color: #C2C7D0; padding-left: 10px; margin: 0px;">Username:&nbsp;
                            </h6><a href="#" id="username" class="d-block"
                                style="padding-right: 10px; line-height: 1.2;"><?php echo $_SESSION['username']; ?></a>
                        </div>
                        <div class="row">
                            <h6 style="color: #C2C7D0; padding-left: 10px; margin: 0px;">User ID:&nbsp;
                            </h6><a href="#" id="uid" class="d-block"
                                style="padding-right: 10px; line-height: 1.2;"><?php echo $_SESSION['id']; ?></a>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                        <li class="nav-item">
                            <a href="/dashboard" class="nav-link <?php if ($currentPage === 'Dashboard') {
                                                      echo 'active';
                                                    } ?>">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/profile" class="nav-link <?php if ($currentPage === 'Profile') {
                                                    echo 'active';
                                                  } ?>">
                                <i class="nav-icon fas fa-user"></i>
                                <p>
                                    Profile
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link <?php if ($currentPage === 'Products') {
                                            echo 'active';
                                          } elseif ($currentPage === 'Purchase Products') {
                                            echo 'active';
                                          } elseif ($currentPage === 'Orders') {
                                            echo 'active';
                                          } ?>">
                                <i class="nav-icon fas fa-copy"></i>
                                <p>
                                    Products
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="/products" class="nav-link <?php if ($currentPage === 'Products') {
                                                        echo 'active';
                                                      } ?>">
                                        <p>All Products</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/products/buy" class="nav-link <?php if ($currentPage === 'Purchase Products') {
                                                            echo 'active';
                                                          } ?>">
                                        <p>Purchase Products</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/products/orders" class="nav-link <?php if ($currentPage === 'Orders') {
                                                                echo 'active';
                                                              } ?>">
                                        <p>All Orders</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link <?php if ($currentPage === 'Projects') {
                                            echo 'active';
                                          } elseif ($currentPage === 'Add Project') {
                                            echo 'active';
                                          } ?>">
                                <i class="nav-icon fas fa-copy"></i>
                                <p>
                                    Projects
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="/projects" class="nav-link <?php if ($currentPage === 'Projects') {
                                                        echo 'active';
                                                      } ?>">
                                        <p>All Projects</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/projects/add" class="nav-link <?php if ($currentPage === 'Add Project') {
                                                            echo 'active';
                                                          } ?>">
                                        <p>Add Project</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="/calendar" class="nav-link <?php if ($currentPage === 'Calendar') {
                                                    echo 'active';
                                                  } ?>">
                                <i class="nav-icon far fa-calendar-alt"></i>
                                <p>
                                    Calendar
                                </p>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>