    <!-- Sidenav -->
    <nav class="sidenav navbar navbar-vertical fixed-left navbar-expand-sm navbar-light bg-white d-none d-sm-none d-md-block" id="sidenav-main">
        <div class="scrollbar-inner">
            <!-- Brand -->
            <div class="sidenav-header d-flex align-items-center">

                <a class="navbar-brand" href="<?php echo base_url('guru'); ?>">
                    Guru
                </a>
                <div class="ml-auto">
                    <!-- Sidenav toggler -->
                    <div class="sidenav-toggler d-none d-xl-block" data-action="sidenav-unpin" data-target="#sidenav-main">
                        <div class="sidenav-toggler-inner">
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="navbar-inner">
                <!-- Collapse -->
                <div class="collapse navbar-collapse" id="sidenav-collapse-main">
                    <!-- Nav items -->
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('guru') ?>">
                                <i class="ni ni-tv-2 text-primary"></i>
                                <span class="nav-link-text">Dashboard</span>
                            </a>
                        </li>
                        <!-- nav data siswa -->
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('guru/siswa') ?>">
                                <i class="fa fa-users text-success"></i>
                                <span class="nav-link-text">Data Siswa</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('guru/lapor_siswa') ?>">
                                <i class="fa fa-edit text-danger"></i>
                                <span class="nav-link-text">Lapor Perundungan</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>