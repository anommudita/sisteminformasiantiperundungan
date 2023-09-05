<!-- Header -->
<div class="header bg-primary pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <h6 class="h2 text-white d-inline-block mb-0">Tambah Siswa</h6>
                </div>
                <div class="col-lg-6 col-5 text-right">
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                            <li class="breadcrumb-item"><a href="<?php echo site_url('guru'); ?>"><i class="fas fa-users"></i></a></li>
                            <li class="breadcrumb-item"><a href="<?= base_url('guru/siswa'); ?>">Siswa</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Tambah</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Page content -->
<div class="container-fluid mt--6">
    <?= form_open_multipart('guru/tambah_siswa') ?>

    <div class="row">
        <div class="col-md-8">
            <div class="card-wrapper">
                <div class="card">
                    <div class="card-header">
                        <h3 class="mb-0">Data Siswa</h3>
                    </div>

                    <div class="card-body">

                        <!-- NISN -->
                        <div class="form-group">
                            <label class="form-control-label" for="nisn">NISN:</label>
                            <input type="number" name="nisn" value="<?= set_value('nisn') ?>" class="form-control" id="nisn">
                            <small class="text-danger"> <?= form_error('nisn'); ?></small>
                        </div>

                        <!-- Nama Siswa -->
                        <div class="form-group">
                            <label class="form-control-label" for="name">Nama siswa:</label>
                            <input type="text" name="name" value="<?= set_value('name') ?>" class="form-control" id="name">
                            <small class="text-danger"> <?= form_error('name'); ?></small>
                        </div>

                        <!-- Kelas -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-control-label" for="kelas">Kelas:</label>
                                    <select name="kelas" class="form-control" id="kelas">
                                        <option value="">Pilih..</option>
                                        <?php foreach ($kelas as $row) : ?>
                                            <option value="<?= $row['id']; ?>"><?= strtoupper($row['kelas']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <small class="text-danger"> <?= form_error('kelas'); ?></small>
                                </div>
                            </div>
                        </div>

                        <!-- Tanggal Lahir -->
                        <div class="form-group">
                            <label class="form-control-label" for="tanggal_lahir">Tanggal lahir:</label>
                            <input type="date" name="tanggal_lahir" value="<?= set_value('tanggal_lahir') ?>" class="form-control" id="tanggal_lahir">
                            <small class="text-danger"> <?= form_error('tanggal_lahir'); ?></small>
                        </div>


                        <!-- Umur -->
                        <div class="form-group">
                            <label class="form-control-label" for="umur">Umur:</label>
                            <input type="text" name="umur" value="<?= set_value('umur') ?>" class="form-control" id="umur">
                            <small class="text-danger"> <?= form_error('umur'); ?></small>
                        </div>

                        <!-- Jenis Kelamin -->
                        <div class="form-group">
                            <label for="jenis_kelamin_kelamin">Jenis Kelamin</label>
                            <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                                <option value="">Pilih..</option>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                            <?= form_error('jenis_kelamin', '<small class="text-danger pl-3">', '</small'); ?>
                        </div>


                        <!-- Alamat Siswa -->
                        <div class="form-group">
                            <label class="form-control-label" for="alamat">Alamat siswa:</label>
                            <input type="text" name="alamat" value="<?= set_value('alamat') ?>" class="form-control" id="alamat">
                            <small class="text-danger"> <?= form_error('alamat'); ?></small>
                        </div>

                        <!-- Telepon Siswa -->
                        <div class="form-group">
                            <label class="form-control-label" for="no_telepon">Telepon siswa atau orang tua:</label>
                            <input type="number" name="no_telepon" value="<?= set_value('no_telepon') ?>" class="form-control" id="no_telepon">
                            <small class="text-danger"> <?= form_error('no_telepon'); ?></small>
                        </div>

                        <!-- Pilih Sekolah
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-control-label" for="sekolah">Sekolah:</label>
                                    <select name="sekolah" class="form-control" id="sekolah">
                                        <option value="">Pilih..</option>
                                        <?php foreach ($sekolah as $row) : ?>
                                            <option value="<?= $row['id']; ?>"><?= strtoupper($row['nama_sekolah']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <small class="text-danger"> <?= form_error('sekolah'); ?></small>
                                </div>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>

        </div>

        <!-- profile -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0">Profile</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-control-label" for="image">Foto:</label>
                        <div class="col-sm-10 pl-1 mb-2" id="preview">
                            <img src="<?= base_url('assets') ?>/img/siswa/default.png" alt="default" class="img-thumbnail">
                        </div>
                        <input type="file" name="image" class="form-control" id="image" onchange="getImagePreview(event)">
                        <small class="text-muted">Pilih foto PNG atau JPG dengan ukuran maksimal 5MB</small>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="<?= base_url('guru/siswa') ?>" class="btn btn-danger mr-4">Batal</a>
                    <input type="submit" value="Tambah Siswa" class="btn btn-primary">
                </div>
            </div>
        </div>
    </div>

    </form>

    <!-- Script Untuk Mencari Nilai Umur dari Nilai tanggal lahir  (menampilan 12 tahun 2 bulan) Siswa-->
    <script>
        document.getElementById('tanggal_lahir').addEventListener('change', function() {
            var tanggalLahir = this.value;
            var today = new Date();
            var birthDate = new Date(tanggalLahir);
            var age = today.getFullYear() - birthDate.getFullYear();
            var monthDiff = today.getMonth() - birthDate.getMonth();

            // Jika ulang tahun belum terjadi pada tahun ini, kurangi umur satu tahun
            if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                age--;
                monthDiff = 12 + monthDiff; // Menghitung selisih bulan dengan mengubah ke positif
            }

            // Formatkan umur ke dalam string "X tahun Y bulan"
            var umurString = age + " tahun";
            if (monthDiff > 0) {
                umurString += " " + monthDiff + " bulan";
            }

            // jika tanggal lahir belum lengkap diisi
            if (tanggalLahir == '') {
                umurString = 'Masukan Tanggal Lahir';
                document.getElementById('umur').Placeholder = umurString;
            }
            document.getElementById('umur').value = umurString;
        });
    </script>