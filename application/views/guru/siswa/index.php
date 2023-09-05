<!-- Header -->
<div class="header bg-primary pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <h6 class="h2 text-white d-inline-block mb-0">Kelola Data Siswa</h6>
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                            <li class="breadcrumb-item"><a href="#"><i class="fas fa-users"></i></a></li>
                            <li class="breadcrumb-item active"><a href="<?= base_url('guru/siswa') ?>">Data Siswa</a></li>
                        </ol>
                    </nav>
                    <!-- Flashdata! -->
                    <?php if ($this->session->flashdata('flash')) : ?>
                        <div class="col">
                            <div class="row mt-2">
                                <div class="alert alert-success alert-dismissible fade show" role="alert">Data Siswa
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
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">Data siswa
                                    <strong>gagal</strong> <?= $this->session->flashdata('flash_failed'); ?>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>


                    <!-- Flashdata! -->
                    <?php if ($this->session->flashdata('flash_import_excel')) : ?>
                        <div class="col">
                            <div class="row mt-2">
                                <div class="alert alert-danger alert-dismissible fade show" role="alert"><?= $this->session->flashdata('flash_import_excel'); ?>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>


                </div>
                <div class="col-lg-6 col-5 text-right">
                    <!-- <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#DownloadFile" data-whatever="@mdo">Download Excel Format</button> -->
                    <a href="<?= base_url('guru/downloadFileExcel') ?>" class="btn btn-sm btn-success">Download File Excel</a>
                    <button type="button" class="btn btn-sm btn-neutral" data-toggle="modal" data-target="#uploadFile" data-whatever="@mdo">Upload File</button>
                    <a href="<?= base_url('guru/tambah_siswa') ?>" class="btn btn-sm btn-neutral">Tambah</a>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Page content -->
<div class="container-fluid mt--6">
    <div class="row">
        <div class="col">
            <div class="card">
                <!-- Card header -->
                <div class="card-header border-0">
                    <h3 class="mb-0">Data Siswa</h3>
                </div>

                <div class="packageContainer">
                    <!-- Light table -->
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush" id="dataTable" style="width: 100%">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">NISN</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Sekolah</th>
                                    <th scope="col">Alamat</th>
                                    <th scope="col">No Telepon</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <!-- modal box detail -->
                                <?php foreach ($siswa as $row) : ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= $row['nisn']; ?></td>
                                        <td><?= $row['nama']; ?></td>
                                        <td><?= $row['nama_sekolah']; ?></td>
                                        <td><?= $row['alamat_siswa']; ?></td>
                                        <td><?= $row['no_telepon_siswa']; ?></td>
                                        <td>
                                            <!-- detail -->
                                            <a href="#" class="btn btn-success btn-sm" data-toggle="modal" data-target="#detailModal<?= $row['nisn']; ?>"><i class="fa fa-info"></i></a>
                                            <!-- edit -->
                                            <a href="<?= base_url('guru/edit_siswa/' . $row['id_siswa']) ?>" class="btn btn-warning btn-sm btnEdit"><i class=" fa fa-edit"></i></a>
                                            <!-- hapus -->
                                            <a href="<?= base_url('guru/hapus_siswa/') . $row['id_siswa'] ?>" class="btn btn-danger btn-sm delete-siswa"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                <!-- end modal box -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- modal upload file -->
    <div class="modal fade" id="uploadFile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Upload File Excel</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="<?= base_url('guru/uploadFileExcel') ?>" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Format Excel</label>
                            <input type="file" class="form-control" id="uploadFile" name="uploadFile">
                            <small class="text-danger">File harus berformat xlsx dan xls</small>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary mr-3">Upload</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- modal upload file -->

    <!-- modal detail information siswa -->
    <?php foreach ($siswa as $row) : ?>
        <div class="modal fade" id="detailModal<?= $row['nisn']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Detail Data Siswa</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-4 mt-3">
                                    <?php if ($row['foto'] == 'default.png' || $row['foto'] == null) : ?>
                                        <img src="<?= base_url('assets/img/siswa/default.png') ?>" class="img-fluid">
                                    <?php else : ?>
                                        <img src="<?= base_url('assets/img/siswa/foto/') . $row['foto'] ?>" class="img-fluid">
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-8">
                                    <ul class="list-group">
                                        <li class="list-group-item">
                                            <h3><?= $row['nama'] ?></h3>
                                        </li>
                                        <li class="list-group-item"> NISN : <?= $row['nisn'] ?></li>
                                        <li class="list-group-item"> Kelas : <?= $row['kelas'] ?></li>
                                        <li class="list-group-item"> Sekolah : <?= $row['nama_sekolah'] ?></li>
                                        <li class="list-group-item"> Tanggal Lahir : <?= $row['tanggal_lahir'] ?></li>
                                        <li class="list-group-item"> Umur : <?= $row['umur'] ?></li>
                                        <li class="list-group-item"> Jenis Kelamin : <?= $row['jenis_kelamin'] ?></li>
                                        <li class="list-group-item"> Alamat : <?= $row['alamat_siswa'] ?></li>
                                        <li class="list-group-item"> Nomor Telepon : <?= $row['no_telepon_siswa'] ?></li>
                                        <li class="list-group-item"> Total Perundungan : <?= $row['total_rundungan'] ?></li>
                                        <li class="list-group-item"> Didata : <?= $row['date_created'] ?></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    <!-- end modal  -->

    <!-- modal download file -->
    <!-- <div class="modal fade" id="DownloadFile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Pilih Format File </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="<?= base_url('guru/downloadFileExcel') ?>" method="post"> -->
    <!-- Pilih format file -->
    <!-- <div class="form-group mb-3">
                            <label class="form-control-label" for="pilihFormatFile">Pilih Format:</label>
                            <div class="input-group input-group-merge input-group-alternative">
                                <select name="pilihFormatFile" class="form-control" id="pilihFormatFile">
                                    <option value="">Pilih..</option>
                                    <option value="1">CSV</option>
                                    <option value="2">XLS</option>
                                    <option value="3">XLSX</option>
                                </select>
                            </div> -->
    <!-- notif eror -->
    <!-- <small class="text-danger ql-size-small"> <?= form_error('pilihFormatFile'); ?></small>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary mr-3">Download</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>  -->
    <!-- modal upload file -->



    <link href="<?= base_url('assets/themes/argon1/vendor/datatables.net-bs4/css/dataTables.bootstrap4.min.css'); ?>" rel="stylesheet">
    <script src="<?= base_url('assets/themes/argon1/vendor/datatables.net/js/jquery.dataTables.min.js'); ?>"></script>
    <script src="<?= base_url('assets/themes/argon1/vendor/datatables.net-bs4/js/dataTables.bootstrap4.min.js'); ?>"></script>
    <script src="<?= base_url('assets/plugins/datatables.lang.js'); ?>"></script>