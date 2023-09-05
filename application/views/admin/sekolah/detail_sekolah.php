<!-- Header -->
<div class="header bg-primary pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <h6 class="h2 text-white d-inline-block mb-0"><?= strtoupper($sekolah['nama_sekolah']) ?></h6>
                </div>
                <div class="col-lg-6 col-5 text-right">
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                            <li class="breadcrumb-item"><a href="<?= base_url('admin'); ?>"><i class="fas fa-solid fa-school"></i></a></li>
                            <li class="breadcrumb-item"><a href="<?= base_url('admin/sekolah'); ?>">Sekolah</a></li>
                            <li class="breadcrumb-item active" aria-current="page">SMK Negeri 3 Singaraja</li>
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
        <div class="col-md-4">
            <div class="card-wrapper">
                <div class="card">
                    <div class="card-header">
                        <h3 class="mb-0">Data Sekolah</h3>
                    </div>
                    <div class="card-body p-0">
                        <div>
                            <img alt="gambar_sekolah" class="img img-fluid rounded" src="
                            <?php if ($sekolah['gambar'] == 'default.png'|| $sekolah['gambar'] == null) : ?>
                                    <?php echo base_url('assets/img/sekolah/default.png'); ?>
                            <?php else : ?>
                                    <?php echo base_url('assets/img/sekolah/gambar/' . $sekolah['gambar']); ?>
                            <?php endif; ?>
                            ">
                        </div>

                        <ul class="list-group">
                            <li class="list-group-item">
                                <h2> <?= strtoupper($sekolah['nama_sekolah']) ?></h2>
                            </li>
                            <li class="list-group-item">
                                <p> <b> No. Telp : <?= $sekolah['no_telepon'] ?></b></p>
                            </li>
                            <li class="list-group-item">
                                <p><b>Alamat : <?= $sekolah['alamat'] ?></b></p>
                            </li>
                            <li class="list-group-item">
                                <p><b>Kabuputen : <?= $sekolah['nama_kabupaten'] ?></b></p>
                            </li>
                            <li class="list-group-item">
                                <p><b>Kecamatan : <?= $sekolah['nama_kecamatan'] ?></b></p>
                            </li>
                            <li class="list-group-item">
                                <p><b>Kota : <?= $sekolah['nama_kota'] ?></b></p>
                            </li>
                            <li class="list-group-item">
                                <h4> <?= strtoupper('Total Perundungan : '.$lapor_siswa) ?></h4>
                            </li>
                        </ul>
                    </div>
                    <div class="card-footer text-right">
                        <a href="<?= base_url('admin/edit_sekolah/' . $sekolah['id']) ?>" class="btn btn-warning"><i class="fa fa-edit"></i></a>
                        <a href="<?= base_url('admin/hapus_sekolah/' . $sekolah['id']); ?>" class="btn btn-danger delete-sekolah"><i class="fa fa-trash"></i></a>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="mb-0">Data Siswa</h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <!-- Projects table -->
                        <table class="table align-items-center table-flush table-striped" id="dataTableSiswa">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Umur</th>
                                    <th scope="col">Jenis Kelamin</th>
                                    <th scope="col">Alamat</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($siswa as $row) : ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= $row['nama']; ?></td>
                                        <td><?= $row['umur']; ?></td>
                                        <td>
                                            <?= $row['jenis_kelamin']; ?>
                                        </td>
                                        <td><?= $row['alamat']; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


    </div>

    <!-- modifkasi style pada pagination table -->
    <style>
        .pagination {
            /* margin-left: 310px; */
            float: right;
        }
    </style>

    <script>
        $('#deleteProductForm').submit(function(e) {
            e.preventDefault();

            var btn = $('.btn-delete');
            var data = $(this).serialize();

            btn.html('<i class="fa fa-spin fa-spinner"></i> Menghapus...').attr('disabled', true);

            $.ajax({
                method: 'POST',
                url: '<?php echo site_url('admin/products/product_api?action=delete_product'); ?>',
                data: data,
                success: function(res) {
                    if (res.code == 204) {
                        setTimeout(function() {
                            btn.html('<i class="fa fa-check"></i> Terhapus!');
                            $('.deleteText').fadeOut(function() {
                                $(this).text('Produk berhasil dihapus')
                            }).fadeIn();
                        }, 2000);

                        setTimeout(function() {
                            $('.deleteText').fadeOut(function() {
                                $(this).text('Mengalihkan...')
                            }).fadeIn();
                        }, 4000);

                        setTimeout(function() {
                            window.location = '<?php echo site_url('admin/products'); ?>';
                        }, 6000);
                    } else {
                        console.log('Terjadi kesalahan sata menghapus produk');
                    }
                }
            })
        })
    </script>

    <!-- table data siswa di sekolahan -->
    <script>
        $(document).ready(function($) {
            $('#dataTableSiswa').DataTable({
                "language": {
                    "search": "Cari:",
                    "lengthMenu": "Menampilkan_MENU_",
                    "info": "Menampilkan _START_ sampai _END_ data dari _TOTAL_ data",
                    "infoEmpty": "Tidak ada data yang ditampilkan",
                    "infoFiltered": "(dari total _MAX_ data)",
                    "zeroRecords": "Tidak ada hasil pencarian ditemukan",
                    "paginate": {
                        "first": "&laquo;",
                        "last": "&raquo;",
                        "next": "&rsaquo;",
                        "previous": "&lsaquo;"
                    },
                }
            });
        });
    </script>