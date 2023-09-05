<!-- Header -->
<div class="header bg-primary pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <h6 class="h2 text-white d-inline-block mb-0">Kelola Data Klasifikasi</h6>
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                            <li class="breadcrumb-item"><a href="#"><i class="fas fa fa-solid fa-person-dots-from-line"></i></a></li>
                            <li class="breadcrumb-item active"><a href="<?= base_url('admin/klasifikasi') ?>">Data Klasifikasi</a></li>
                        </ol>
                    </nav>
                    <!-- Flashdata! -->
                    <?php if ($this->session->flashdata('flash')) : ?>
                        <div class="col">
                            <div class="row mt-2">
                                <div class="alert alert-success alert-dismissible fade show" role="alert">Data Klasifikasi
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
                    <a href="#" data-target="#addKlasifikasiModal" data-toggle="modal" class="btn btn-sm btn-neutral">Tambah</a>
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
                    <h3 class="mb-0">Data Klasifikasi</h3>
                </div>

                <div class="packageContainer">
                    <!-- Light table -->
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush" id="dataTable" style="width: 100%">
                            <thead class="thead-light">
                                <tr>
                                    <th style="width: 5%;">No</th>
                                    <th style="width: 70%;">Klasifikasi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <!-- modal box detail -->
                                <?php foreach ($klasifikasi as $row) : ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= $row['klasifikasi']; ?></td>
                                        <td>
                                            <!-- edit -->
                                            <a href="#" class="btn btn-warning btn-sm btnEdit" data-id="<?= $row['id'] ?>"><i class=" fa fa-edit"></i></a>
                                            <!-- hapus -->
                                            <a href="<?= base_url('admin/hapus_klasifikasi/') . $row['id'] ?>" class="btn btn-danger btn-sm delete-klasifikasi"><i class="fa fa-trash"></i></a>
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


    <!-- modal box tambah klasifikas -->
    <div class="modal fade" id="addKlasifikasiModal" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
        <div class="modal-dialog modal- modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <div class="card bg-secondary border-0 mb-0">
                        <div class="card-header bg-transparent">
                            <h3 class="card-heading text-center mt-2">Tambah Klasifikasi Perundungan</h3>
                        </div>
                        <div class="card-body px-lg-5 py-lg-5">

                            <form action="<?= base_url('admin/tambah_klasifikasi') ?>" id="addKlasifikasi" method="post">

                                <!-- Klasifikasi -->
                                <div class="form-group mb-3">
                                    <div class="input-group input-group-merge input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa-solid fa-person-dots-from-line"></i></span>
                                        </div>
                                        <input class="form-control" name="klasifikasi" id="klasifikasi" placeholder="Klasifikasi Perundungan" type="text" autocomplete="off" value="<?= set_value('klasifikasi') ?>" autofocus>
                                    </div>
                                    <!-- notif eror -->
                                    <small class="text-danger ql-size-small"> <?= form_error('klasifikasi'); ?></small>
                                </div>

                                <div class="form-group mb-3">
                                    <div class="text-left">
                                        <button type="button" class="btn btn-secondary my-4" data-dismiss="modal">Batal</button>
                                    </div>
                                    <div class="float-right" style="margin-top: -90px">
                                        <button type="submit" class="btn btn-primary my-4" id="addButtonKlasifikasi">Tambah</button>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- modal box edit klasifikas -->
<div class="modal fade" id="editKlasifikasiModal" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="card bg-secondary border-0 mb-0">
                    <div class="card-header bg-transparent">
                        <h3 class="card-heading text-center mt-2">Edit Klasifikasi Perundungan</h3>
                    </div>
                    <div class="card-body px-lg-5 py-lg-5">

                        <form id="editKlasifikasi" method="post">

                            <input type="text" class="edit_id" hidden>

                            <!-- Klasifikasi -->
                            <div class="form-group mb-3">
                                <div class="input-group input-group-merge input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa-solid fa-person-dots-from-line"></i></span>
                                    </div>
                                    <input class="form-control" name="edit_klasifikasi" id="edit_klasifikasi" placeholder="Klasifikasi Perundungan" type="text" autocomplete="off" value="" autofocus>
                                </div>
                                <!-- notif eror -->
                                <small class="text-danger ql-size-small"> <?= form_error('edit_klasifikasi'); ?></small>
                            </div>

                            <div class="form-group mb-3">
                                <div class="text-left">
                                    <button type="button" class="btn btn-secondary my-4" data-dismiss="modal">Batal</button>
                                </div>
                                <div class="float-right" style="margin-top: -90px">
                                    <button type="submit" class="btn btn-primary my-4" id="editButtonKlasifikasi">Simpan</button>
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


<!-- modal box edit klasifikas -->
<div class="modal fade" id="editKlasifikasiModal" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="card bg-secondary border-0 mb-0">
                    <div class="card-header bg-transparent">
                        <h3 class="card-heading text-center mt-2">Edit Klasifikasi Perundungan</h3>
                    </div>
                    <div class="card-body px-lg-5 py-lg-5">

                        <form id="editKlasifikasi" method="post">

                            <input type="text" class="edit_id" hidden>

                            <!-- Klasifikasi -->
                            <div class="form-group mb-3">
                                <div class="input-group input-group-merge input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa-solid fa-person-dots-from-line"></i></span>
                                    </div>
                                    <input class="form-control" name="edit_klasifikasi" id="edit_klasifikasi" placeholder="Klasifikasi Perundungan" type="text" autocomplete="off" value="" autofocus>
                                </div>
                                <!-- notif eror -->
                                <small class="text-danger ql-size-small"> <?= form_error('edit_klasifikasi'); ?></small>
                            </div>

                            <div class="form-group mb-3">
                                <div class="text-left">
                                    <button type="button" class="btn btn-secondary my-4" data-dismiss="modal">Batal</button>
                                </div>
                                <div class="float-right" style="margin-top: -90px">
                                    <button type="submit" class="btn btn-primary my-4" id="editButtonKlasifikasi">Simpan</button>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>



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
                url: '<?php echo site_url('admin/data_api?action=view_data_edit_klasifikasi'); ?>',
                data: {
                    id: id
                },
                success: function(res) {
                    if (res.data) {
                        var d = res.data[0];
                        // console.log(d);
                        $('#edit_klasifikasi').val(d.klasifikasi);
                        $('.edit_id').val(d.id);

                        // console.log(d.klasifikasi);

                        $('#editKlasifikasiModal').modal('show');
                    }
                }
            });
        });

        document.getElementById("editKlasifikasi").addEventListener("submit", function(event) {
            event.preventDefault(); // Prevent the default form submission
            var id = document.querySelector('.edit_id').value;
            var editForm = document.getElementById("editKlasifikasi");
            editForm.action = '<?php echo site_url('admin/edit_klasifikasi/'); ?>' + id; // Change the action URL
            editForm.submit(); // Submit the form
        });
    });
</script>