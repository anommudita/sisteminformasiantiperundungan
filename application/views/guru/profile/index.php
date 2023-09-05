<!-- Header -->
<div class="header bg-primary pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <h6 class="h2 text-white d-inline-block mb-0">Profil Anda</h6>
                    <!-- Flashdata! -->
                    <?php if ($this->session->flashdata('flash')) : ?>
                        <div class="col">
                            <div class="row mt-2">
                                <div class="alert alert-success alert-dismissible fade show" role="alert">Profile Anda
                                    <strong>berhasil</strong> <?= $this->session->flashdata('flash'); ?>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Flashdata! -->
                    <?php if ($this->session->flashdata('flash_failed')) : ?>
                        <div class="col">
                            <div class="row mt-2">
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">Profile Anda
                                    <strong>gagal</strong> <?= $this->session->flashdata('flash_failed'); ?>
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
    <?php echo form_open_multipart('guru/update_profile/' . $user['username']); ?>

    <div class="row">
        <div class="col-md-8">
            <div class="card-wrapper">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                <h3 class="mb-0">Identitas :</h3>
                            </div>
                            <div class="col-md-6">
                                <!-- <h3 class="mb-0">KODE SEKOLAH : <?= $user['sekolah'] ?></h3> -->
                            </div>
                        </div>

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
                                    <p class="text-muted"><small>Nama lengkap dan berserta gelar pendidikan</small></p>
                                    <small class="text-danger"> <?= form_error('nama'); ?></small>
                                </div>
                            </div>

                            <!-- Sekolah -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="sekolah">Sekolah:</label>
                                    <select name="sekolah" class="form-control" id="sekolah">
                                        <option value="" <?= ($user['sekolah'] === null) ? 'selected' : ''; ?>>Pilih..</option>
                                        <?php foreach ($sekolah as $row) : ?>
                                            <option value=" <?= $row['id']; ?>" <?= ($row['id'] === $user['sekolah']) ? 'selected' : ''; ?> <?= ($user['sekolah']) ? 'disabled' : ''; ?>><?= strtoupper($row['nama_sekolah']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <small class="text-danger"> <?= form_error('sekolah'); ?></small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Alamat -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="alamat">Alamat:</label>
                                    <input type="text" name="alamat" value="<?= $user['alamat'] ?>" class="form-control" id="alamat">
                                    <small class="text-danger"> <?= form_error('alamat'); ?></small>
                                </div>
                            </div>

                            <!-- nomor telepon -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="nomor_telepon">Nomor Telepon:</label>
                                    <input type="number" name="nomor_telepon" value="<?= $user['no_telp'] ?>" class="form-control" id="nomor_telepon">
                                    <small class="text-danger"> <?= form_error('nomor_telepon'); ?></small>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 text-md-left text-center mb-2 mb-md-0">
                            <a href="<?= base_url('guru/gantiKataSandi/' . $user['id']) ?>" class="btn btn-success">Ganti Kata Sandi</a>
                        </div>
                        <div class="col-md-6 text-md-right text-center">
                            <a href="javascript:history.back()" class="btn btn-danger">Batal</a>
                            <input type="submit" class="btn btn-primary ml-md-4 mt-2 mt-md-0" value="Simpan">
                        </div>
                    </div>
                </div>
            </div>
            <!-- 
            <div class="card">
                <div class="card-body">
                    <input type="submit" class="btn btn-primary float-right" value="Simpan">
                    <a href="javascript:history.back()" class="btn btn-danger float-right mr-4">Batal</a>
                    <a href="<?= base_url('guru/gantiKataSandi/' . $user['id']) ?>" class="btn btn-success float-left">Ganti Kata Sandi</a>
                </div>
            </div> -->

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

                            <?php if ($user['foto'] === 'default.png' || $user['foto'] == null) : ?>
                                <img src="<?= base_url('assets/img/guru/default1.png') ?>" alt="profile" class="img-thumbnail">
                            <?php else : ?>
                                <img src="<?= base_url('assets/img/guru/profile/' . $user['foto']) ?>" alt="profile" class="img-thumbnail">
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

    <!-- script disable option sekolah -->
    <script>
        function checkSelect() {
            var selectedValue = document.getElementById('sekolah').value;
            var submitButton = document.getElementById('sekolah');

            if (selectedValue !== "") {
                submitButton.disabled = false;
            } else {
                submitButton.disabled = true;
            }
        }
    </script>