<!-- Header -->
<div class="header bg-primary pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <h6 class="h2 text-white d-inline-block mb-0">Edit Sekolah</h6>
                </div>
                <div class="col-lg-6 col-5 text-right">
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                            <li class="breadcrumb-item"><a href="<?php echo site_url('admin'); ?>"><i class="fas fa-solid fa-school"></i></a></li>
                            <li class="breadcrumb-item"><a href="<?= base_url('admin/sekolah'); ?>">Sekolah</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Page content -->
<div class="container-fluid mt--6">
    <?= form_open_multipart('admin/edit_sekolah/' . $sekolah['id']) ?>

    <div class="row">
        <div class="col-md-8">
            <div class="card-wrapper">
                <div class="card">
                    <div class="card-header">
                        <h3 class="mb-0">Data Sekolah</h3>
                    </div>

                    <div class="card-body">
                        <!-- Nama Sekolah -->
                        <div class="form-group">
                            <label class="form-control-label" for="name">Nama sekolah:</label>
                            <input type="text" name="name" value="<?= $sekolah['nama_sekolah'] ?>" class="form-control" id="name">
                            <small class="text-danger"> <?= form_error('name'); ?></small>
                        </div>

                        <!-- Alamat Sekolah -->
                        <div class="form-group">
                            <label class="form-control-label" for="alamat">Alamat sekolah:</label>
                            <input type="text" name="alamat" value="<?= $sekolah['alamat'] ?>" class="form-control" id="alamat">
                            <small class="text-danger"> <?= form_error('alamat'); ?></small>
                        </div>

                        <!-- Telepon Sekolah -->
                        <div class="form-group">
                            <label class="form-control-label" for="no_telepon">Telepon sekolah:</label>
                            <input type="number" name="no_telepon" value="<?= $sekolah['no_telepon'] ?>" class="form-control" id="no_telepon">
                            <small class="text-danger"> <?= form_error('no_telepon'); ?></small>
                        </div>

                        <!-- Kabupaten Sekolah -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-control-label" for="kabupaten">Kabupaten:</label>
                                    <select name="kabupaten" class="form-control" id="kabupaten">
                                        <option value="" id="value_kabupaten">Pilih..</option>
                                        <?php foreach ($kabupaten as $row) : ?>
                                            <option value="<?= $row['id']; ?>" <?php if ($sekolah['kabupaten'] == $row['id']) : ?> selected <?php endif ?>><?= $row['kabupaten'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <small class="text-danger"> <?= form_error('kabupaten'); ?></small>
                                </div>
                            </div>
                        </div>

                        <!-- Kecamatan Sekolah -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-control-label" for="kecamatan">Kecamatan:</label>
                                    <select name="kecamatan" class="form-control" id="kecamatan">
                                        <option value="">Pilih..</option>
                                        <?php foreach ($kecamatan as $row) : ?>
                                            <option value="<?= $row['id']; ?>" <?php if ($sekolah['kecamatan'] == $row['id']) : ?> selected <?php endif ?>><?= $row['kecamatan'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <small class="text-danger"> <?= form_error('kecamatan'); ?></small>
                                </div>
                            </div>
                        </div>
                        <!-- Kota -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-control-label" for="kota">Kota:</label>
                                    <select name="kota" class="form-control" id="kota">
                                        <option value="">Pilih..</option>
                                        <?php foreach ($kota as $row) : ?>
                                            <option value="<?= $row['id']; ?>" <?php if ($sekolah['kota'] == $row['id']) : ?> selected <?php endif ?>><?= $row['kota'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <small class="text-danger"> <?= form_error('kota'); ?></small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0">Foto</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-control-label" for="image">Foto:</label>
                        <div class="col-sm-10 pl-1 mb-2" id="preview">
                            <?php if ($sekolah['gambar'] == 'default.png'|| $sekolah['gambar'] == null) : ?>
                                <img src="<?= base_url('assets/img/sekolah/default.png') ?>" alt="default" class="img-thumbnail">
                            <?php else : ?>
                                <img src="<?= base_url('assets/img/sekolah/gambar/' . $sekolah['gambar']) ?>" alt="<?= $sekolah['gambar'] ?>" class="img-thumbnail">
                            <?php endif; ?>
                        </div>
                        <input type="file" name="image" class="form-control" id="image" onchange="getImagePreview(event)">
                        <small class="text-muted">Pilih foto PNG atau JPG dengan ukuran maksimal 5MB</small>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="javascript:history.back()" class="btn btn-danger mr-4">Batal</a>
                    <input type="submit" value="Simpan Sekolah" class="btn btn-primary">
                </div>
            </div>
        </div>
    </div>

    </form>