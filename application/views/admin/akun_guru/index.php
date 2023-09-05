<!-- Header -->
<div class="header bg-primary pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <h6 class="h2 text-white d-inline-block mb-0">Kelola Akun Guru</h6>
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                            <li class="breadcrumb-item"><a href="#"><i class="fas fa-user"></i></a></li>
                            <li class="breadcrumb-item active"><a href="<?= base_url('admin/akun_guru') ?>">Akun Guru</a></li>
                        </ol>
                    </nav>
                    <!-- Flashdata! -->
                    <?php if ($this->session->flashdata('flash')) : ?>
                        <div class="col">
                            <div class="row mt-2">
                                <div class="alert alert-success alert-dismissible fade show" role="alert">Akun Guru
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
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">Akun Guru
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
                    <a href="#" data-target="#addModal" data-toggle="modal" class="btn btn-sm btn-neutral">Tambah</a>
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
                    <h3 class="mb-0">Akun Guru</h3>
                </div>

                <div class="packageContainer">
                    <!-- Light table -->
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush" id="dataTable" style="width: 100%">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" width="5%">No</th>
                                    <th scope="col" width="20%">Nama</th>
                                    <th scope="col" width="10%">Username</th>
                                    <th scope="col" width="15%">Email</th>
                                    <th scope="col" width="10%">Status</th>
                                    <th scope="col" width="10%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <!-- modal box detail -->
                                <?php foreach ($akun_guru as $row) : ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= $row['nama']; ?></td>
                                        <td><?= $row['username']; ?></td>
                                        <td><?= $row['email']; ?></td>
                                        <td><?= $row['status_login'] == 0 ? '<i class="fa-solid fa-circle fa-beat" style="color:  #e74a3b;"></i> Offline' : '<i class="fa-solid fa-circle fa-beat" style="color:  #1cc88a;"></i> Online'; ?></td>
                                        <td>
                                            <!-- detail -->
                                            <a href="#" class="btn btn-success btn-sm" data-toggle="modal" data-target="#detailModal<?= $row['id']; ?>"><i class="fa fa-info"></i></a>
                                            <!-- active -->
                                            <a href="<?= base_url('admin/active_akun/' . $row['username']) ?>" class="btn btn-primary btn-sm active-akun" data-toggle="modal"><i class="fa fa-solid fa-user-check"></i></a>
                                            <!-- edit -->
                                            <a href="#" class="btn btn-warning btn-sm btnEdit" data-id="<?= $row['id'] ?>"><i class=" fa fa-edit"></i></a>
                                            <!-- hapus -->
                                            <a href="<?= base_url('admin/hapus_akun_guru/') . $row['username'] ?>" class="btn btn-danger btn-sm delete-akun_guru"><i class="fa fa-trash"></i></a>
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

    <!-- modal box detail -->
    <?php foreach ($akun_guru as $row) : ?>
        <div class="modal fade" id="detailModal<?= $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Detail Akun Guru</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-4 mt-3">
                                    <?php if ($row['foto'] == 'default.png' || $row['foto'] == 'default1.png'|| $row['foto'] == null) : ?>
                                        <img src="<?= base_url('assets/img/guru/default1.png') ?>" class="img-fluid">
                                    <?php else : ?>
                                        <img src="<?= base_url('assets/img/guru/profile/') . $row['foto'] ?>" class="img-fluid">
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-8">
                                    <ul class="list-group">
                                        <li class="list-group-item">
                                            <h3><?= $row['nama'] ?></h3>
                                        </li>
                                        <li class="list-group-item"> Email : <?= $row['email'] ?></li>
                                        <li class="list-group-item"> Username : <?= $row['username'] ?></li>
                                        <!-- <li class="list-group-item"> Role : <?= $row['role'] == 2 ? 'Guru' : 'Tidak Diketahui'  ?></li> -->
                                        <li class="list-group-item"> Sekolah :
                                            <?= ($row['sekolah']) ? $row['sekolah'] : '<b class="text-danger">Data belum diisi</b>'; ?>
                                        </li>
                                        <li class="list-group-item"> Alamat :
                                            <?= ($row['alamat']) ? $row['alamat'] : '<b class="text-danger">Data belum diisi</b>'; ?></li>
                                        <li class="list-group-item"> Nomor Telepon : <?= ($row['no_telp']) ? $row['no_telp'] : '<b class="text-danger">Data belum diisi</b>'; ?></li>
                                        <li class="list-group-item"> Aktivasi :
                                            <?= $row['is_active'] == 1 ? '<b class="text-success">Sudah Aktivasi</b>' : '<b class="text-danger">Belum Aktivasi</b>' ?></li>
                                        <li class="list-group-item"> Terdaftar : <?= $row['date_created'] ?></li>
                                        <li class="list-group-item"> Total Lapor Perundungan : <?= $row['total_lapor_perundungan']; ?></li>
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

    <!-- modal box tambah akun guru -->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
        <div class="modal-dialog modal- modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <div class="card bg-secondary border-0 mb-0">
                        <div class="card-header bg-transparent">
                            <h3 class="card-heading text-center mt-2">Tambah Akun Guru</h3>
                        </div>
                        <div class="card-body px-lg-5 py-lg-5">
                            <!-- <?= form_open_multipart('admin/tambah_akun_guru'); ?> -->
                            <form action="<?= base_url('admin/tambah_akun_guru') ?>" id="addAkunGuru" method="post" enctype="multipart/form-data">

                                <!-- Nama Guru -->
                                <div class="form-group mb-3">
                                    <div class="input-group input-group-merge input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa-solid fa-id-card"></i></span>
                                        </div>
                                        <input class="form-control" name="name" id="name" placeholder="Nama Lengkap" type="text" autocomplete="off" value="<?= set_value('name') ?>">
                                    </div>
                                    <!-- notif eror -->
                                    <small class="text-danger ql-size-small"> <?= form_error('name'); ?></small>
                                </div>

                                <!-- Email -->
                                <div class="form-group mb-3">
                                    <div class="input-group input-group-merge input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
                                        </div>
                                        <input class="form-control" name="email" id="email" placeholder="Email" type="email" autocomplete="off" value="<?= set_value('email') ?>">
                                    </div>
                                    <!-- notif eror -->
                                    <small class="text-danger"> <?= form_error('email'); ?></small>
                                </div>

                                <!-- Username -->
                                <div class="form-group mb-3">
                                    <div class="input-group input-group-merge input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                                        </div>
                                        <input class="form-control" name="username" id="username" placeholder="Username" type="text" autocomplete="off" value="<?= set_value('username') ?>">
                                    </div>
                                    <!-- notif eror -->
                                    <small class="text-danger"> <?= form_error('username'); ?></small>

                                </div>

                                <!-- Password -->
                                <div class="form-group mb-3">
                                    <div class="input-group input-group-merge input-group-alternative">

                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                                        </div>
                                        <input class="form-control" name="password" id="password" placeholder="Password" type="password" autocomplete="off">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="showPasswordButton">
                                                <i class="fa fa-eye"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <!-- notif eror -->
                                    <small class="text-danger"> <?= form_error('password'); ?></small>
                                </div>

                                <div>
                                    <button type="button" class="btn btn-success" id="generatePasswordButton">Generate</button>
                                </div>

                                <!-- Gambar -->
                                <div class="form-group mb-3">
                                    <label for="gambar">Profile</label>
                                    <div class="col-sm-12">
                                        <div class="row">
                                            <div class="col-sm-4 pl-1" id="preview">
                                                <img src="<?= base_url('assets') ?>/img/guru/default1.png" alt="default" class="img-thumbnail">
                                            </div>
                                            <div class="col-sm-8 pr-1">
                                                <div class="custom-file">
                                                    <div class="input-group input-group-merge input-group-alternative">
                                                        <input class="form-control" name="image" id="image" placeholder="Gambar" type="file" autocomplete="off" onchange="getImagePreview(event)">
                                                    </div>
                                                    <!-- notif eror -->
                                                    <small class="text-danger">Format gambar PNG atau JPG</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-left">
                                        <button type="button" class="btn btn-secondary my-4" data-dismiss="modal">Batal</button>
                                    </div>
                                    <div class="float-right" style="margin-top: -90px">
                                        <button type="submit" class="btn btn-primary my-4" id="addButtonAkun">Tambah</button>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end modal box tambah -->




<!-- modal box edit akun guru -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="card bg-secondary border-0 mb-0">
                    <div class="card-header bg-transparent">
                        <h3 class="card-heading text-center mt-2">Edit Akun Guru</h3>
                    </div>
                    <div class="card-body px-lg-5 py-lg-5">
                        <form action="" id="editAkunGuru" method="post" enctype="multipart/form-data">

                            <input hidden type="text" class="edit_id">

                            <!-- Nama Guru -->
                            <div class="form-group mb-3">
                                <div class="input-group input-group-merge input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa-solid fa-id-card"></i></span>
                                    </div>
                                    <input class="form-control edit_name" name="edit_name" id="edit_name" placeholder="Nama Lengkap" type="text" autocomplete="off">
                                </div>
                                <!-- notif eror -->
                                <small class="text-danger"> <?= form_error('edit_name'); ?></small>
                            </div>

                            <!-- Email -->
                            <div class="form-group mb-3">
                                <div class="input-group input-group-merge input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
                                    </div>
                                    <input class="form-control" name="edit_email" id="edit_email" placeholder="Email" type="email" autocomplete="off" readonly>
                                </div>
                                <!-- notif eror -->
                                <small class="text-danger"> <?= form_error('edit_email'); ?></small>
                            </div>

                            <!-- Username -->
                            <div class="form-group mb-3">
                                <div class="input-group input-group-merge input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa-solid fa-user" readonly></i></span readonly>
                                    </div>
                                    <input class="form-control" name="edit_username" id="edit_username" placeholder="Username" type="text" autocomplete="off" value="<?= set_value('username') ?>" readonly>
                                </div>
                                <!-- notif eror -->
                                <small class="text-danger"> <?= form_error('edit_username'); ?></small>
                            </div>

                            <!-- Password -->
                            <div class="form-group mb-3">
                                <div class="input-group input-group-merge input-group-alternative">

                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                                    </div>
                                    <input class="form-control" name="edit_password" id="edit_password" placeholder="Password" type="password" autocomplete="off">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="showPasswordButton1">
                                            <i class="fa fa-eye"></i>
                                        </span>
                                    </div>
                                </div>
                                <!-- notif eror -->
                                <small class="text-danger"> <?= form_error('edit_password'); ?></small>
                            </div>

                            <!-- Gambar -->
                            <div class="form-group mb-3">
                                <label for="gambar">Profile</label>
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-sm-4 pl-1" id="edit_preview">
                                            <img src="" alt="default" class="img-thumbnail" id="profile_guru">
                                        </div>
                                        <div class="col-sm-8 pr-1">
                                            <div class="custom-file">
                                                <div class="input-group input-group-merge input-group-alternative">
                                                    <input class="form-control" name="edit_image" id="edit_image" placeholder="Gambar" type="file" onchange="getImagePreviewEdit(event)">
                                                </div>
                                                <!-- notif eror -->
                                                <small class="text-danger">Format gambar PNG atau JPG</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-left">
                                    <button type="button" class="btn btn-secondary my-4" data-dismiss="modal">Batal</button>
                                </div>
                                <div class="float-right" style="margin-top: -90px">
                                    <button type="submit" class="btn btn-primary my-4" id="editButtonAkun">Simpan</button>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- end modal box edit -->



<link href="<?= base_url('assets/themes/argon1/vendor/datatables.net-bs4/css/dataTables.bootstrap4.min.css'); ?>" rel="stylesheet">
<script src="<?= base_url('assets/themes/argon1/vendor/datatables.net/js/jquery.dataTables.min.js'); ?>"></script>
<script src="<?= base_url('assets/themes/argon1/vendor/datatables.net-bs4/js/dataTables.bootstrap4.min.js'); ?>"></script>
<script src="<?= base_url('assets/plugins/datatables.lang.js'); ?>"></script>




<script>
    $(document).ready(function($) {
        $(document).on('click', '.btnEdit', function() {
            var id = $(this).data('id');

            $.ajax({
                method: 'GET',
                url: '<?php echo site_url('admin/data_api?action=view_data'); ?>',
                data: {
                    id: id
                },
                success: function(res) {
                    if (res.data) {
                        var d = res.data[0];
                        // console.log(d);
                        $('#edit_name').val(d.nama);
                        $('#edit_email').val(d.email);
                        $('#edit_username').val(d.username);
                        $('.edit_id').val(d.id);

                        // Update the image source
                        // $('#edit_image').attr('src', d.foto);
                        if (d.foto == 'default.png' || d.foto == 'default1.png' || d.foto == '') {
                            var imageUrl = '<?php echo base_url('assets/img/guru/default1.png'); ?>';
                        } else {
                            var imageUrl = '<?php echo base_url('assets/img/guru/profile/'); ?>' + d.foto;
                        }
                        // console.log(imageUrl);
                        $('#profile_guru').attr('src', imageUrl);

                        $('#editModal').modal('show');
                    }
                }
            });
        });

        document.getElementById("editAkunGuru").addEventListener("submit", function(event) {
            event.preventDefault(); // Prevent the default form submission
            var id = document.querySelector('.edit_id').value;
            var editForm = document.getElementById("editAkunGuru");
            editForm.action = '<?php echo site_url('admin/edit_akun_guru/'); ?>' + id; // Change the action URL
            editForm.submit(); // Submit the form
        });
    });
</script>


<!-- Script untuk generate password menggunakan ajax-->
<script>
    $(document).ready(function() {
        $('#generatePasswordButton').click(function() {
            $.ajax({
                url: '<?= base_url('admin/generate_password'); ?>',
                type: 'GET',
                success: function(response) {
                    $('#password').val(response);
                }
            });
        });
    });
</script>


<!-- script untuk melihat password dan menutup password-->
<script>
    document.getElementById("showPasswordButton").addEventListener("click", function() {
        togglePasswordVisibility("password", "showPasswordButton");
    });

    document.getElementById("showPasswordButton1").addEventListener("click", function() {
        togglePasswordVisibility("edit_password", "showPasswordButton1");
    });

    function togglePasswordVisibility(passwordInputId, showPasswordButtonId) {
        var passwordInput = document.getElementById(passwordInputId);
        var showPasswordButton = document.getElementById(showPasswordButtonId);
        // console.log(passwordInput);
        // console.log(showPasswordButton);

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            showPasswordButton.innerHTML = '<i class="fa fa-eye-slash"></i>';
        } else {
            passwordInput.type = "password";
            showPasswordButton.innerHTML = '<i class="fa fa-eye"></i>';
        }
    }
</script>

<!-- ketika mengirim form maka tombol tambah akan disable -->
<script>
    document.getElementById("addAkunGuru").addEventListener("submit", function() {
        document.getElementById("addButtonAkun").disabled = true;
    });
</script>

<!-- ketika mengirim form maka tombol edit akan disable -->
<script>
    document.getElementById("editAkunGuru").addEventListener("submit", function() {
        document.getElementById("editButtonAkun").disabled = true;
    });
</script>