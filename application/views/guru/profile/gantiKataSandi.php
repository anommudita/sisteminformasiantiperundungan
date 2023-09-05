<!-- Header -->
<div class="header bg-primary pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <h6 class="h2 text-white d-inline-block mb-0">Ganti Kata Sandi</h6>
                    <!-- flash data -->
                    <?= $this->session->flashdata('message'); ?>
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
                            <li class="breadcrumb-item active" aria-current="page">Kata Sandi</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Page content -->
<div class="container-fluid mt--6">
    <?php echo form_open_multipart('guru/gantiKataSandi/' . $user['id']); ?>

    <div class="row">
        <div class="col-md-8">
            <div class="card-wrapper">
                <div class="card">
                    <div class="card-header">
                        <h3 class="mb-0">Kata Sandi</h3>
                    </div>

                    <div class="card-body">
                        <!-- kata sandi lama -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-control-label" for="passwordcurrent">Kata Sandi Lama:</label>
                                    <input type="password" name="passwordcurrent" value="" class="form-control" id="passwordcurrent">
                                    <small class="text-danger"> <?= form_error('passwordcurrent'); ?></small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- nama -->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-control-label" for="passwordnew">Kata Sandi Baru:</label>
                                    <input type="password" name="passwordnew" value="" class="form-control" id="passwordnew">
                                    <small class="text-danger"> <?= form_error('passwordnew'); ?></small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- nama -->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-control-label" for="passwordconfirm">Konfirmasi Kata Sandi:</label>
                                    <input type="password" name="passwordconfirm" value="" class="form-control" id="passwordconfirm">
                                    <small class="text-danger"> <?= form_error('passwordconfirm'); ?></small>
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
                    <h3 class="mb-0">Profile Anda</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-control-label" for="image">Profile:</label>
                        <div class="col-sm-10 pl-1 mb-2" id="preview">

                            <?php if ($user['foto'] === 'default.png'|| $user['foto'] == null) : ?>
                                <img src="<?= base_url('assets/img/guru/default1.png') ?>" alt="profile" class="img-thumbnail">
                            <?php else : ?>
                                <img src="<?= base_url('assets/img/guru/profile/' . $user['foto']) ?>" alt="profile" class="img-thumbnail">
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    </form>