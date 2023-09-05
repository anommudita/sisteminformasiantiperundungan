<!-- Main content -->
<div class="main-content" id="panel">
    <!-- Topnav -->
    <nav class="navbar navbar-top navbar-expand navbar-dark bg-primary border-bottom">
        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Navbar links -->
                <ul class="navbar-nav align-items-center ml-md-auto">
                    <li class="nav-item d-xl-none">
                        <!-- Sidenav toggler -->
                        <div class="pr-3 sidenav-toggler sidenav-toggler-dark">
                            <a class="nav-link pr-0 transparent-button" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <div class="sidenav-toggler-inner">
                                    <i class="sidenav-toggler-line"></i>
                                    <i class="sidenav-toggler-line"></i>
                                    <i class="sidenav-toggler-line"></i>
                                </div>
                            </a>
                            <div class="dropdown-menu center">
                                <div class="dropdown-header noti-title">
                                    <h6 class="text-overflow m-0">Menu</h6>
                                </div>
                                <div class="dropdown-divider"></div>
                                <a href="<?= base_url('guru') ?>" class="dropdown-item mt-2">
                                    <i class="ni ni-tv-2 text-primary"></i>
                                    <span class="nav-link-text">Dashboard</span>
                                </a>
                                <a href="<?= base_url('guru/siswa') ?>" class="dropdown-item mt-2">
                                    <i class="fa fa-users text-warning"></i>
                                    <span class="nav-link-text">Data Siswa</span>
                                </a>
                                <a href="<?= base_url('guru/lapor_siswa') ?>" class="dropdown-item mt-2">
                                    <i class="fa fa-edit text-danger"></i>
                                    <span class="nav-link-text">Lapor Perundungan</span>
                                </a>
                            </div>
                        </div>
                    </li>
                </ul>
                <ul class="navbar-nav align-items-center ml-auto ml-md-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link pr-0 transparent-button" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <div class="media align-items-center">
                                <span class="avatar avatar-sm rounded-circle">
                                    <?php if ($user['foto'] === 'default.png'|| $user['foto'] == null) : ?>
                                        <img src="<?= base_url('assets/img/guru/default1.png') ?>">
                                    <?php else : ?>
                                        <img src="<?= base_url('assets/img/guru/profile/' . $user['foto']) ?>">
                                    <?php endif; ?>
                                </span>
                                <div class="media-body ml-2 d-none d-lg-block">
                                    <span class="mb-0 text-sm  font-weight-bold"></span>
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <div class="dropdown-header noti-title">
                                <h6 class="text-overflow m-0">Welcome!</h6>
                            </div>
                            <a href="<?php echo site_url('guru/profile'); ?>" class="dropdown-item">
                                <i class="ni ni-single-02"></i>
                                <span>Profil</span>
                            </a>

                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item" data-toggle="modal" data-target="#logout">
                                <i class="ni ni-user-run"></i>
                                <span>Logout</span>
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <!-- Modal -->
    <div class="modal fade" id="logout" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <!-- <h5 class="modal-title" id="exampleModalLabel">Modal title</h5> -->
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h2 class="text-center">Apakah anda ingin logout ?</h2>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <a href="<?= base_url('logout') ?>" class="btn btn-primary">Logout</a>
                </div>
            </div>
        </div>
    </div>