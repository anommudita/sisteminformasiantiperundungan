<!-- Header -->
<div class="header bg-primary pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <h6 class="h2 text-white d-inline-block mb-0">Tambah Lapor Perundungan</h6>
                </div>
                <div class="col-lg-6 col-5 text-right">
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                            <li class="breadcrumb-item"><a href="<?php echo site_url('admin'); ?>"><i class="fas fa-edit"></i></a></li>
                            <li class="breadcrumb-item"><a href="<?= base_url('admin/lapor_siswa'); ?>">Lapor Perundungan</a></li>
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
    <?= form_open_multipart('admin/tambah_lapor_siswa') ?>

    <div class="row">
        <div class="col-md-5">
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
                            <small id="notif" name="notif" class="text-danger pl-1"></small>
                        </div>

                        <!-- ID Siswa -->
                        <div class="form-group">
                            <label class="form-control-label" for="id_siswa" hidden>ID SIswa:</label>
                            <input hidden type="number" name="id_siswa" value="" class="form-control" id="id_siswa">
                        </div>

                        <!-- Nama Siswa -->
                        <div class="form-group">
                            <label class="form-control-label" for="name">Nama siswa:</label>
                            <input readonly type="text" name="name" value="<?= set_value('name') ?>" class="form-control" id="name">
                            <small class="text-danger"> <?= form_error('name'); ?></small>
                        </div>

                        <!-- Kelas -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-control-label" for="kelas">Kelas:</label>
                                    <select name="kelas" class="form-control" id="kelas" readonly>
                                        <option value="">Pilih..</option>
                                        <?php foreach ($kelas as $row) : ?>
                                            <option value="<?= $row['id']; ?>"><?= strtoupper($row['kelas']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <small class="text-danger"> <?= form_error('kelas'); ?></small>
                                </div>
                            </div>
                        </div>


                        <!-- Pilih Sekolah -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-control-label" for="sekolah">Sekolah:</label>
                                    <select name="sekolah" class="form-control" id="sekolah" readonly>
                                        <option value="">Pilih..</option>
                                        <?php foreach ($sekolah as $row) : ?>
                                            <option value="<?= $row['id']; ?>"><?= strtoupper($row['nama_sekolah']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <small class="text-danger"> <?= form_error('sekolah'); ?></small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- keterangan -->
        <div class="col-md-7">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0">Keterangan</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="keterangan">Keterangan Perundungan:</label>
                        <textarea class="form-control" id="keterangan" name="keterangan" rows="16"></textarea>
                    </div>
                    <small class="text-danger"> <?= form_error('keterangan'); ?></small>
                </div>
                <div class="card-footer">
                    <a href="<?= base_url('admin/lapor_siswa') ?>" class="btn btn-danger mr-4">Batal</a>
                    <input type="submit" value="Tambah Laporan" class="btn btn-primary">
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


    <!-- Data histori untuk tambah data -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Bind a function to the input event of the NIK field
            $('#nisn').on('input', function() {
                var nisn = $(this).val();
                // Make an AJAX request to retrieve historical data
                $.ajax({
                    url: '<?= base_url('admin/get_data_nisn'); ?>',
                    method: 'POST',
                    data: {
                        nisn: nisn
                    },
                    dataType: 'json',
                    success: function(response) {
                        // Process the response and populate the form fields with historical data
                        if (response.success) {
                            // Populate form fields with historical data
                            $('#name').val(response.data.nama);
                            $('#id_siswa').val(response.data.id_siswa);
                            $('#kelas').val(response.data.id_kelas);
                            $('#sekolah').val(response.data.sekolah);
                            $('#notif').text('');
                        } else {
                            // Clear form fields if no historical data found
                            $('#name').val('');
                            $('#id_siswa').val('');
                            $('#kelas').val('');
                            $('#sekolah').val('');
                            $('#notif').text('Sedang mencari data, pastikan data siswa sudah terdaftar');
                        }
                    }
                });
            });
        });
    </script>