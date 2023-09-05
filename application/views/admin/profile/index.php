<!-- Header -->
<div class="header bg-primary pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <h6 class="h2 text-white d-inline-block mb-0">Profil Admin</h6>
                    <!-- Flashdata! -->
                    <?php if ($this->session->flashdata('flash')) : ?>
                        <div class="col">
                            <div class="row mt-2">
                                <div class="alert alert-success alert-dismissible fade show" role="alert">Profile Admin
                                    <strong>berhasil</strong> <?= $this->session->flashdata('flash'); ?>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-lg-6 col-5 text-right">
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                            <li class="breadcrumb-item"><a href="<?php echo site_url('admin/profile'); ?>"><i class="fas fa-solid fa-gear"></i></a></li>
                            <li class="breadcrumb-item"><a href="<?php echo site_url('admin/profile'); ?>">Pengaturan</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Profil</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Page content -->
<div class="container-fluid mt--6">
    <?php echo form_open_multipart('admin/update_profile/' . $user['username']); ?>

    <div class="row">
        <div class="col-md-8">
            <div class="card-wrapper">
                <div class="card">
                    <div class="card-header">
                        <h3 class="mb-0">Identitas</h3>
                    </div>

                    <div class="card-body">
                        <!-- username -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="username">Username:</label>
                                    <input type="text" name="username" value="<?= $user['username'] ?>" class="form-control" id="username" readonly>
                                    <small class="text-danger"> <?= form_error('username'); ?></small>
                                </div>
                            </div>

                            <!-- email -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="email">Email:</label>
                                    <input type="text" name="email" value="<?= $user['email'] ?>" class="form-control" id="email">
                                    <small class="text-danger"> <?= form_error('email'); ?></small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- nama -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="nama">Nama:</label>
                                    <input type="text" name="nama" value="<?= $user['nama'] ?>" class="form-control" id="nama">
                                    <small class="text-danger"> <?= form_error('nama'); ?></small>
                                </div>
                            </div>

                            <!-- password -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="password">Password:</label>
                                    <input type="password" name="password" value="" class="form-control" id="password">
                                    <p class="text-muted"><small>Kosongkan password jika tidak ingin mengganti</small></p>
                                    <small class="text-danger"> <?= form_error('password'); ?></small>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <input type="submit" class="btn btn-primary float-right" value="Simpan">
                    <a href="javascript:history.back()" class="btn btn-danger float-right mr-4">Batal</a>
                </div>
            </div>

        </div>
        <div class="col-md-4">
            <div class="card card-profile">
                <div class="card-header">
                    <h3 class="mb-0">Profile</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-control-label" for="image">Profile Anda:</label>
                        <div class="col-sm-10 pl-1 mb-2" id="preview">

                            <?php if ($user['foto'] == 'default.png' || $user['foto'] == null) : ?>
                                <img src="<?= base_url('assets/img/admin/default.png') ?>" alt="profile" class="img-thumbnail">
                            <?php else : ?>
                                <img src="<?= base_url('assets/img/admin/profile/' . $user['foto']) ?>" alt="profile" class="img-thumbnail">
                            <?php endif; ?>
                        </div>
                        <input type="file" name="image" class="form-control" id="image" onchange="getImagePreview(event)">
                        <small class="text-muted">Pilih foto PNG atau JPG dengan ukuran maksimal 5MB</small>
                    </div>
                </div>
            </div>

        </div>
    </div>
    </form>