<link rel="stylesheet" href="<?php echo base_url();?>/assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet"
    href="<?php echo base_url();?>assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<script src="<?php echo base_url();?>assets/jquery.js"></script>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper" style="zoom:90%" !important>
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>
            <!-- Right navbar links -->

            <!-------selesai-------->
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="#" class="brand-link">
                <span class="brand-text font-weight-light">POS</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="info">
                        <a href="#" class="d-block"><?=$nama?></a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                        <li class="nav-item">
                            <a href="<?php echo base_url();?>Admin"
                                class="nav-link <?php if($namamenu=="Dashboard"){echo "active";}?>">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Penjualan
                                </p>
                            </a>
                        </li>
                        <li class="nav-item has-treeview">
                            <a href="<?php echo base_url();?>Admin/PML"
                                class="nav-link <?php if($namamenu=="Pemeliharaan"){echo "active";}?>">
                                <i class="nav-icon fa fa-cogs"></i>
                                <p>
                                    Pemeliharaan
                                </p>
                            </a>
                        </li>
                        <li class="nav-item has-treeview">
                            <a href="<?php echo base_url();?>Admin/PL"
                                class="nav-link <?php if($namamenu=="Pengeluaran Lain"){echo "active";}?>">
                                <i class="nav-icon fa fa-envelope"></i>
                                <p>
                                    Pengeluaran Lain
                                </p>
                            </a>
                        </li>
                        <li class="nav-item has-treeview">
                            <a href="<?php echo base_url();?>Admin/LPB"
                                class="nav-link <?php if($namamenu=="LPB"){echo "active";}?>">
                                <i class="nav-icon fa fa-sign-in-alt"></i>
                                <p>
                                    LPB
                                </p>
                            </a>
                        </li>
                        <li class="nav-item has-treeview">
                            <a href="<?php echo base_url();?>Admin/Laporan"
                                class="nav-link <?php if($namamenu=="Laporan"){echo "active";}?>">
                                <i class="nav-icon fas fa-money-bill-alt"></i>
                                <p>
                                    Laporan
                                </p>
                            </a>
                        </li>
                        <li class="nav-item has-treeview">
                            <a href="<?php echo base_url();?>Auth/logout" class="nav-link">
                                <i class="nav-icon fa fa-sign-out-alt"></i>
                                <p>
                                    Logout
                                </p>
                            </a>
                        </li>

                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>