<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>ERT Contábil 1.0</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App favicon -->       
    <link rel="apple-touch-icon" sizes="180x180" href="<?php print site_url() ?>assets/icon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php print site_url() ?>assets/icon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php print site_url() ?>assets/icon/favicon-16x16.png">
    <link rel="manifest" href="<?php print site_url() ?>assets/icon/site.webmanifest">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    <link href="<?php print site_url() ?>assets/plugins/c3/c3.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php print site_url() ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php print site_url() ?>assets/css/core.css" rel="stylesheet" type="text/css" />
    <link href="<?php print site_url() ?>assets/css/components.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('assets/css/font-awesome.min.css')?>" rel="stylesheet" type="text/css" />
    <link href="<?php print site_url() ?>assets/css/icons.css" rel="stylesheet" type="text/css" />
    <link href="<?php print site_url() ?>assets/css/pages.css" rel="stylesheet" type="text/css" />
    <link href="<?php print site_url() ?>assets/css/menu.css" rel="stylesheet" type="text/css" />
    <link href="<?php print site_url() ?>assets/css/responsive.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('assets/css/sweetalert2.min.css')?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/dataTables.bootstrap.min.css')?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('assets/css/responsive.bootstrap.min.css')?>" rel="stylesheet" type="text/css" />
    <link href="<?php print site_url() ?>assets/css/style.css" rel="stylesheet" type="text/css" />
    <link href="<?php print site_url() ?>assets/plugins/tooltipster/tooltipster.bundle.min.css" rel="stylesheet" type="text/css" />
     
    <script src="<?php print site_url() ?>assets/js/modernizr.min.js"></script>
    <style type="text/css">
        .pagination > .active > a,
        .pagination > .active > span,
        .pagination > .active > a:hover,
        .pagination > .active > span:hover,
        .pagination > .active > a:focus,
        .pagination > .active > span:focus {
            background-color: #3d4d86;
            border-color: #3d4d86;
        }

        .icon-btn {
            cursor: pointer;
            color:#3d4d86;
        }
    </style>
</head>

<body>
    <div id="wrapper">
        <div class="topbar">
            <div class="topbar-left" style="background-color: #343C49;">
                <a href="index.html" class="logo"> <span> <img src="<?php print site_url('assets/images/logo.jpg')?>" alt="" height="65"> </span> <i><!-- <img src="assets/images/logo_sm.png" alt="" height="28"> --> </i> </a>
            </div>
            <div class="navbar navbar-default" role="navigation" style="background-color: #3d4d86;">
                <div class="container">
                    <ul class="nav navbar-nav navbar-left nav-menu-left">
                        <li>
                            <button type="button" class="button-menu-mobile open-left waves-effect" style="background-color: #3d4d86; color:#fff"> <i class="dripicons-menu"></i> </button>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <a href="<?php print site_url('login/sair')?>" class="right-menu-item "> <i class="dripicons-exit" style="color: #fff"></i> </a>
                            <!-- <ul class="dropdown-menu dropdown-menu-right dropdown-lg user-list notify-list"> <li class="list-group notification-list m-b-0"> <div class="slimscroll"> <a href="javascript:void(0);" class="list-group-item"> <div class="media"> <div class="media-left p-r-10"> <em class="fa fa-diamond bg-primary"></em> </div><div class="media-body"> <h5 class="media-heading text-primary">A new order has been placed A new order has been placed</h5> <p class="m-0"> There are new settings available </p></div></div></a> </div></li></ul> -->
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="left side-menu">
            <div class="slimscroll-menu" id="remove-scroll" style=" color: #fff;">
                <div id="sidebar-menu">
                    <ul class="metisMenu nav" id="side-menu">
                        <li class="menu-title" style="color: #fff">Menu</li>
                        <?php if($this->session->auth == 'admin'){ ?>
                            <li style="color: #fff"><a style="color: #fff" href="<?php print site_url('projetos') ?>"><i class="fa fa-group fa-2x"></i> <span>Empresas</span> </a></li>
                        <?php } else {  ?>
                            <li style="color: #fff"><a style="color: #fff" href="<?php print site_url('login/principal') ?>"><i class="fa fa-folder fa-2x"></i> <span>Pasta Principal</span> </a></li>
                        <?php  } ?>
                    </ul>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>