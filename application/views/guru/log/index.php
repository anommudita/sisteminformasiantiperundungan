<!-- Header -->
<div class="header bg-primary pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <h6 class="h2 text-white d-inline-block mb-0">Log Laporan Siswa</h6>
                </div>
                <div class="col-lg-6 col-5 text-right">
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                            <li class="breadcrumb-item"><a href="<?php echo site_url('guru'); ?>"><i class="fas fa-file-invoice"></i></a></li>
                            <li class="breadcrumb-item"><a href="<?= base_url('guru/lapor_siswa'); ?>">Kelola Log</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Page content -->
<div class="container-fluid mt--6">

    <div class="row">

        <!-- keterangan -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0">Keterangan</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="keterangan">Keterangan Perundungan:</label>
                        <textarea class="form-control" id="keterangan" name="keterangan" rows="16" disabled><?= $lapor['keterangan'] ?></textarea>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="<?= base_url('guru/lapor_siswa') ?>" class="btn btn-danger mr-4">Batal</a>
                </div>
            </div>
        </div>

        <!-- Log Laporan -->
        <div class="col-md-8">
            <!-- Flashdata! -->
            <?php if ($this->session->flashdata('flash')) : ?>
                <div class="col">
                    <div class="row mt-2">
                        <div class="alert alert-success alert-dismissible fade show" role="alert">Data log laporan
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
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?= $this->session->flashdata('flash_failed'); ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <div class="card">
                <div class="card-header py-3">
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <h3 class="mb-0">Log Laporan Siswa</h3>
                            <h3 class="mb-0"><b>Klasifikasi :</b> <?= $lapor['klasifikasi']; ?></h3>
                        </div>
                        <div class="col-md-6 col-12 mt-3 mt-md-0 text-md-right">
                            <a href="#" class="btn btn-primary mt-2 mt-md-0" data-target="#addLog" data-toggle="modal">Tambah</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <!-- Projects table -->
                        <table class="table align-items-center table-flush table-striped" id="dataTableSiswa">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">DateTime Mulai</th>
                                    <th scope="col">DateTime Selesai</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Keterangan</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($log as $row) : ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td><?= $row['date_time_mulai'] ?></td>
                                        <td><?= $row['date_time_selesai'] ?></td>
                                        <td><?= strtoupper($row['status']) ?></td>
                                        <?php if (strlen($row['keterangan']) >= 35) : ?>
                                            <td><a href="#" class="btn btn-success btn-sm" data-toggle="modal" data-target="#keteranganModal<?= $row['id_log']; ?>"><i class="fa fa-info"></i></a></td>
                                        <?php else : ?>
                                            <td><?= $row['keterangan'] ?></td>
                                        <?php endif; ?>
                                        <td>
                                            <!-- edit -->
                                            <a href="#" class="btn btn-warning btn-sm btnEdit" data-id="<?= $row['id_log'] ?>"><i class=" fa fa-edit"></i></a>
                                            <!-- hapus -->
                                            <a href="<?= base_url('guru/hapus_log/') . $lapor['id_laporan'] . '/' . $row['id_log'] ?>" class="btn btn-danger btn-sm delete-log"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>

                                    <!-- modal keterangan -->
                                    <div class="modal fade" id="keteranganModal<?= $row['id_log'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalCenterTitle">Keterangan Log</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="message-text" class="col-form-label">Keterangan:</label>
                                                        <textarea class="form-control" id="message-text" rows="5"><?= $row['keterangan'] ?></textarea>
                                                    </div>

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                                                    <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end modal keterangan -->
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- add modal log -->
    <div class="modal fade" id="addLog" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
        <div class="modal-dialog modal- modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <div class="card bg-secondary border-0 mb-0">
                        <div class="card-header bg-transparent">
                            <h3 class="card-heading text-center mt-2">Tambah Log Laporan</h3>
                        </div>
                        <div class="card-body px-lg-5 py-lg-5">
                            <form action="<?= base_url('guru/tambah_log/' . $lapor['id_laporan']) ?>" method="post">

                                <!-- Date Mulai -->
                                <div class="form-group mb-3">
                                    <label class="form-control-label" for="date_mulai">Date Mulai:</label>
                                    <div class="input-group input-group-merge input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa-solid fa-calendar-days"></i></span>
                                        </div>
                                        <input class="form-control " name="date_mulai" id="date_mulai" type="text" autocomplete="off" value="<?= $dateMulai ?>">
                                    </div>
                                    <!-- notif eror -->
                                    <small class="text-danger ql-size-small"> <?= form_error('date_mulai'); ?></small>
                                </div>

                                <!-- Date Selesai -->
                                <div class="form-group mb-3">
                                    <label class="form-control-label" for="date_selesai">Date Selesai:</label>
                                    <div class="input-group input-group-merge input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa-solid fa-calendar-days"></i></span>
                                        </div>
                                        <input class="form-control" name="date_selesai" id="date_selesai" type="text">
                                    </div>
                                    <!-- notif eror -->
                                    <small class="text-danger ql-size-small"> <?= form_error('date_selesai'); ?></small>
                                </div>

                                <input hidden type="text" value="" id="klasifikasi" name="klasifikasi">

                                <!-- Status -->
                                <div class="form-group mb-3">
                                    <label class="form-control-label" for="optionStatus">Status:</label>
                                    <div class="input-group input-group-merge input-group-alternative">
                                        <select name="optionStatus" class="form-control" id="optionStatus">
                                            <option value="">Pilih..</option>
                                            <?php foreach ($status as $row) : ?>
                                                <option value=" <?= $row['id']; ?>" data-kabupaten="<?= $row['id']; ?>"><?= strtoupper($row['status']); ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <!-- notif eror -->
                                    <small class="text-danger ql-size-small"> <?= form_error('optionStatus'); ?></small>
                                </div>

                                <!-- Keterangan -->
                                <div class="form-group mb-3">
                                    <label class="form-control-label" for="keterangan">Keterangan:</label>
                                    <div class="input-group input-group-merge input-group-alternative">
                                        <textarea class="form-control" id="keterangan" name="keterangan" rows="5"></textarea>
                                    </div>
                                    <!-- notif eror -->
                                    <small class="text-danger ql-size-small"> <?= form_error('keterangan'); ?></small>
                                </div>

                                <div class="form-group mb-3">
                                    <div class="text-left">
                                        <button type="button" class="btn btn-secondary my-4" data-dismiss="modal">Batal</button>
                                    </div>
                                    <div class="float-right" style="margin-top: -90px">
                                        <button type="submit" class="btn btn-primary my-4">Tambah</button>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- modal box edit -->
<div class="modal fade" id="editLog" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="card bg-secondary border-0 mb-0">
                    <div class="card-header bg-transparent">
                        <h3 class="card-heading text-center mt-2">Edit Log Laporan</h3>
                    </div>
                    <div class="card-body px-lg-5 py-lg-5">
                        <form action="" method="post" id="formEditLog">

                            <!-- id log -->
                            <input hidden type="text" name="edit_id_log" id="edit_id_log">
                            <!-- id lapor siswa -->
                            <input hidden type="text" name="edit_lapor_siswa" id="edit_lapor_siswa">

                            <!-- Date Mulai -->
                            <div class="form-group mb-3">
                                <label class="form-control-label" for="edit_date_mulai">Date Mulai:</label>
                                <div class="input-group input-group-merge input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa-solid fa-calendar-days"></i></span>
                                    </div>
                                    <input class="form-control " name="edit_date_mulai" id="edit_date_mulai" type="text" autocomplete="off" value="<?= $dateMulai ?>">
                                </div>
                                <!-- notif eror -->
                                <small class="text-danger ql-size-small"> <?= form_error('edit_date_mulai'); ?></small>
                            </div>

                            <!-- Date Selesai -->
                            <div class="form-group mb-3">
                                <label class="form-control-label" for="edit_date_selesai">Date Selesai:</label>
                                <div class="input-group input-group-merge input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa-solid fa-calendar-days"></i></span>
                                    </div>
                                    <input class="form-control" name="edit_date_selesai" id="edit_date_selesai" type="text">
                                </div>
                                <!-- notif eror -->
                                <small class="text-danger ql-size-small"> <?= form_error('edit_date_selesai'); ?></small>
                            </div>

                            <!-- Status -->
                            <div class="form-group mb-3">
                                <label class="form-control-label" for="edit_optionStatus">Status:</label>
                                <div class="input-group input-group-merge input-group-alternative">
                                    <select name="edit_optionStatus" class="form-control" id="edit_optionStatus">
                                        <option value="">Pilih..</option>
                                        <?php foreach ($status as $row) : ?>
                                            <option value=" <?= $row['id']; ?>"><?= strtoupper($row['status']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <!-- notif eror -->
                                <small class="text-danger ql-size-small"> <?= form_error('edit_optionStatus'); ?></small>
                            </div>

                            <!-- Keterangan -->
                            <div class="form-group mb-3">
                                <label class="form-control-label" for="edit_keterangan">Keterangan:</label>
                                <div class="input-group input-group-merge input-group-alternative">
                                    <textarea class="form-control" id="edit_keterangan" name="edit_keterangan" rows="5"></textarea>
                                </div>
                                <!-- notif eror -->
                                <small class="text-danger ql-size-small"> <?= form_error('edit_keterangan'); ?></small>
                            </div>
                            <div class="form-group mb-3">
                                <div class="text-left">
                                    <button type="button" class="btn btn-secondary my-4" data-dismiss="modal">Batal</button>
                                </div>
                                <div class="float-right" style="margin-top: -90px">
                                    <button type="submit" class="btn btn-primary my-4">Simpan</button>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<!-- edit modal box -->
<script>
    $(document).ready(function($) {
        $(document).on('click', '.btnEdit', function() {
            var id = $(this).data('id');

            $.ajax({
                method: 'GET',
                url: '<?php echo site_url('guru/data_api?action=view_data_edit_log'); ?>',
                data: {
                    id: id
                },
                success: function(res) {
                    if (res.data) {
                        var d = res.data[0];
                        // console.log(d);
                        $('#edit_date_selesai').val(d.date_time_selesai);
                        $('#edit_keterangan').val(d.keterangan);
                        $('#edit_optionStatus').val(d.status);
                        $('#edit_id_log').val(d.id_log);
                        $('#edit_lapor_siswa').val(d.lapor_siswa);


                        var editOptionStatus = $('#edit_optionStatus');
                        // Menghapus opsi yang ada saat ini (jika ada)
                        editOptionStatus.empty();

                        var statusOptions = <?php echo $statusJson; ?>;
                        // Loop melalui opsi status yang ingin Anda tampilkan
                        // var statusOptions = ['Option 1', 'Option 2', 'Option 3']; // Ganti ini dengan data status yang sesuai
                        console.log(statusOptions);
                        for (var i = 0; i < statusOptions.length - 1; i++) {
                            var option = $('<option>', {
                                value: i + 1,
                                text: statusOptions[i].toUpperCase()
                            });
                            // Menandai opsi yang sesuai dengan status data dari respons
                            if (statusOptions[i] === d.status) {
                                option.prop('selected', true);
                            }
                            // Menambahkan opsi ke elemen select
                            editOptionStatus.append(option);
                        }
                        $('#editLog').modal('show');
                    }
                }
            });
        });
        document.getElementById("formEditLog").addEventListener("submit", function(event) {
            event.preventDefault(); // Prevent the default form submission
            var id = document.querySelector('#edit_id_log').value;
            var editForm = document.getElementById("formEditLog");
            editForm.action = '<?php echo site_url('guru/edit_log/'); ?>' + id; // Change the action URL
            editForm.submit(); // Submit the form
        });


        // document.getElementById("formUpdateKlasifikasi").addEventListener("submit", function(event) {
        //     event.preventDefault(); // Prevent the default form submission
        //     var id = document.querySelector('#klasifikasi_by_id_laporan').value;
        //     var editForm = document.getElementById("formUpdateKlasifikasi");

        //     // Check which button was clicked and set the appropriate action URL
        //     if (event.submitter && event.submitter.name === "updateButton") {
        //         editForm.action = '<?php echo site_url('guru/updateKlasifikasi/'); ?>' + id;
        //     } else if (event.submitter && event.submitter.name === "terapkanButton") {
        //         editForm.action = '<?php echo site_url('guru/terapkanKlasifikasi/'); ?>' + id;
        //     }

        //     editForm.submit(); // Submit the form
        // });

    });
</script>



<!-- Ajax Get Data DateNow -->
<script>
    $(document).ready(function() {
        // Bind a function to the input event of the NIK field
        $('#optionStatus').on('change', function() {

            var id_status = $(this).val();;
            // console.log(id_status);
            // Make an AJAX request to retrieve historical data
            $.ajax({
                url: '<?= base_url('guru/get_date'); ?>',
                method: 'POST',
                data: {
                    id_status: id_status
                },
                dataType: 'json',
                success: function(response) {

                    if (response.success) {
                        // Populate form fields with historical data
                        if (response.data.dateSelesai) {
                            $('#date_selesai').val(response.data.dateSelesai);
                        } else {
                            $('#date_selesai').val('-');
                        }
                    } else {
                        // Clear form fields if no historical data found
                        $('#date_selesai').val('-');
                    }
                }
            });
        });
    });
</script>


<!-- Ajax Get Data DateNow  untuk edit-->
<script>
    $(document).ready(function() {
        // Bind a function to the input event of the NIK field
        $('#edit_optionStatus').on('change', function() {

            var id_status = $(this).val();;
            // console.log(id_status);
            // Make an AJAX request to retrieve historical data
            $.ajax({
                url: '<?= base_url('guru/get_date'); ?>',
                method: 'POST',
                data: {
                    id_status: id_status
                },
                dataType: 'json',
                success: function(response) {

                    if (response.success) {
                        // Populate form fields with historical data
                        if (response.data.dateSelesai) {
                            $('#edit_date_selesai').val(response.data.dateSelesai);
                        } else {
                            $('#edit_date_selesai').val('-');
                        }
                    } else {
                        // Clear form fields if no historical data found
                        $('#edit_date_selesai').val('-');
                    }
                }
            });
        });
    });
</script>