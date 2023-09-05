<!-- header -->
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Admin</title>
    <!-- Favicon -->
    <link rel="icon" href="<?= base_url('assets/img/logo/logo_siap.png'); ?>" type="image/png">

    <!-- Fonts -->
    <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700"> -->
    <!-- Icons -->
    <link rel="stylesheet" href="<?= base_url('assets/themes/argon1/js/plugins/nucleo/css/nucleo.css'); ?>" type="text/css">
    <link rel="stylesheet" href="<?= base_url('assets/themes/argon1/js/plugins/@fortawesome/fontawesome-free/css/all.min.css'); ?>" type="text/css">

    <!-- Fontawesome Icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/fontawesome.min.css" integrity="sha384-jLKHWM3JRmfMU0A5x5AkjWkw/EYfGUAGagvnfryNV3F9VqM98XiIH7VBGVoxVSc7" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Argon CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/themes/argon1/css/argon9f1e.css?v=1.1.0'); ?>" type="text/css">

    <script src="<?= base_url('assets/themes/argon1/vendor/jquery/dist/jquery.min.js'); ?>"></script>
    <script src="<?= base_url('assets/themes/argon1/vendor/bootstrap/dist/js/bootstrap.bundle.min.js'); ?>"></script>

</head>

<body class="@yield('sidebar_type')">
    <!-- side bar  -->
    <!-- Sidenav -->
    <nav class="sidenav navbar navbar-vertical fixed-left navbar-expand-sm navbar-light bg-white" id="sidenav-main">
        <div class="scrollbar-inner">
            <!-- Brand -->
            <div class="sidenav-header d-flex align-items-center">

                <a class="navbar-brand" href="<?php echo base_url('admin'); ?>">
                    Administrator
                </a>
                <div class="ml-auto">
                    <!-- Sidenav toggler -->
                    <div class="sidenav-toggler d-none d-xl-block" data-action="sidenav-unpin" data-target="#sidenav-main">
                        <div class="sidenav-toggler-inner">
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="navbar-inner">
                <!-- Collapse -->
                <div class="collapse navbar-collapse" id="sidenav-collapse-main">
                    <!-- Nav items -->
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('admin') ?>">
                                <i class="ni ni-tv-2 text-primary"></i>
                                <span class="nav-link-text">Dashboard</span>
                            </a>
                        </li>
                        <!-- klasifikasi -->
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('admin/klasifikasi') ?>">
                                <i class="fa fa-solid fa-person-dots-from-line"></i>
                                <span class="nav-link-text">Klasifikasi</span>
                            </a>
                        </li>
                        <!-- nav sekolah -->
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('admin/sekolah') ?>">
                                <i class="fa fa-solid fa-school text-success"></i>
                                <span class="nav-link-text">Sekolah</span>
                            </a>
                        </li>
                        <!-- nav akun guru -->
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('admin/akun_guru') ?>">
                                <i class="fa fa-user text-primary"></i>
                                <span class="nav-link-text">Akun Guru</span>
                            </a>
                        </li>
                        <!-- nav data siswa -->
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('admin/siswa') ?>">
                                <i class="fa fa-users text-warning"></i>
                                <span class="nav-link-text">Data Siswa</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('admin/lapor_siswa') ?>">
                                <i class="fa fa-edit text-danger"></i>
                                <span class="nav-link-text">Lapor Perundungan</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Konten -->
    <div class="main-content" id="panel">
        <!-- Topnav -->
        <nav class="navbar navbar-top navbar-expand navbar-dark bg-primary border-bottom">
            <div class="container-fluid">
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Search form -->
                    <form class="navbar-search navbar-search-light form-inline mr-sm-3" action="<?= base_url('admin/cari_sekolah') ?>" method="post" required>
                        <div class="form-group mb-0">
                            <div class="input-group input-group-alternative input-group-merge">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                </div>
                                <input class="form-control" value="" name="cari_sekolah" id="cari_sekolah" placeholder="Cari sekolah..." type="text">
                            </div>
                        </div>
                        <button type="button" class="close" data-action="search-close" data-target="#navbar-search-main" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </form>
                    <!-- Navbar links -->
                    <ul class="navbar-nav align-items-center ml-md-auto">
                        <li class="nav-item d-xl-none">
                            <!-- Sidenav toggler -->
                            <div class="pr-3 sidenav-toggler sidenav-toggler-dark" data-action="sidenav-pin" data-target="#sidenav-main">
                                <div class="sidenav-toggler-inner">
                                    <i class="sidenav-toggler-line"></i>
                                    <i class="sidenav-toggler-line"></i>
                                    <i class="sidenav-toggler-line"></i>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item d-sm-none">
                            <a class="nav-link" href="#" data-action="search-show" data-target="#navbar-search-main">
                                <i class="ni ni-zoom-split-in"></i>
                            </a>
                        </li>

                    </ul>
                    <ul class="navbar-nav align-items-center ml-auto ml-md-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <div class="media align-items-center">
                                    <span class="avatar avatar-sm rounded-circle">
                                        <?php if ($user['foto'] === 'default.png') : ?>
                                            <img src="<?= base_url('assets/img/admin/default.png') ?>">
                                        <?php else : ?>
                                            <img src="<?= base_url('assets/img/admin/profile/' . $user['foto']) ?>">
                                        <?php endif; ?>
                                    </span>
                                    <div class="media-body ml-2 d-none d-lg-block">
                                        <span class="mb-0 text-sm  font-weight-bold"></span>
                                    </div>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <div class="dropdown-header noti-title">
                                    <h6 class="text-overflow m-0">Welcome!</h6>
                                </div>
                                <a href="<?php echo site_url('admin/profile'); ?>" class="dropdown-item">
                                    <i class="ni ni-single-02"></i>
                                    <span>Profil</span>
                                </a>

                                <div class="dropdown-divider"></div>
                                <a href="#" class="dropdown-item" data-toggle="modal" data-target="#logout">
                                    <i class="ni ni-user-run"></i>
                                    <span>Logout</span>
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>


        <!-- Modal -->
        <div class="modal fade" id="logout" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <!-- <h5 class="modal-title" id="exampleModalLabel">Modal title</h5> -->
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h2 class="text-center">Apakah anda ingin logout ?</h2>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <a href="<?= base_url('logout') ?>" class="btn btn-primary">Logout</a>
                    </div>
                </div>
            </div>
        </div>



        <!-- Konten PHP -->
        <div class="header bg-primary pb-6">
            <div class="container-fluid">
                <div class="header-body">
                    <div class="row align-items-center py-4">
                        <div class="col-lg-6 col-7">
                            <h6 class="h2 text-white d-inline-block mb-0">Dashboard</h6>
                        </div>
                        <div class="col-lg-6 col-5 text-right">
                            <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                    <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <!-- Card stats -->
                    <div class="row">
                        <div class="col-xl-3 col-md-6">
                            <div class="card card-stats">
                                <!-- Card body -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="card-title text-uppercase text-muted mb-0">Sekolah</h5>
                                            <span class="h2 font-weight-bold mb-0"><?= $sekolah ?></span>
                                        </div>
                                        <div class="col-auto">
                                            <div class="icon icon-shape bg-gradient-green text-white rounded-circle shadow">
                                                <i class="ni fa-solid fa-school"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="mt-3 mb-0 text-sm">
                                        <span class="text-success mr-2"><i class="fa fa-arrow-up"></i></span>
                                        <span class="text-nowrap">Jumlah sekolah terdaftar</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card card-stats">
                                <!-- Card body -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="card-title text-uppercase text-muted mb-0">Akun Guru</h5>
                                            <span class="h2 font-weight-bold mb-0"><?= $guru ?></span>
                                        </div>
                                        <div class="col-auto">
                                            <div class="icon icon-shape bg-gradient-blue text-white rounded-circle shadow">
                                                <i class="ni ni-circle-08"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="mt-3 mb-0 text-sm">
                                        <span class="text-success mr-2"><i class="fa fa-arrow-up"></i></span>
                                        <span class="text-nowrap">Akun yang terdaftar</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card card-stats">
                                <!-- Card body -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="card-title text-uppercase text-muted mb-0">Siswa</h5>
                                            <span class="h2 font-weight-bold mb-0"><?= $siswa ?></span>
                                        </div>
                                        <div class="col-auto">
                                            <div class="icon icon-shape bg-gradient-orange text-white rounded-circle shadow">
                                                <i class="fa fa-users"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="mt-3 mb-0 text-sm">
                                        <span class="text-success mr-2"><i class="fa fa-arrow-up"></i></span>
                                        <span class="text-nowrap">Jumlah siswa dididata</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card card-stats">
                                <!-- Card body -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="card-title text-uppercase text-muted mb-0">Laporan Perundungan</h5>
                                            <span class="h2 font-weight-bold mb-0"><?= $laporan ?></span>
                                        </div>
                                        <div class="col-auto">
                                            <div class="icon icon-shape bg-gradient-red text-white rounded-circle shadow">
                                                <i class="fa fa-edit"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="mt-3 mb-0 text-sm">
                                        <span class="text-success mr-2"><i class="fa fa-arrow-up"></i></span>
                                        <span class="text-nowrap">Total Perundungan</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Page content -->
        <div class="container-fluid mt--6">
            <div class="row">
                <div class="col-xl-8">
                    <div class="card bg-default">
                        <div class="card-header bg-transparent">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h6 class="text-light text-uppercase ls-1 mb-1">Ringkasan</h6>
                                    <h5 class="h3 text-white mb-0">Perundungan</h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Chart -->
                            <div class="chart">
                                <!-- Chart wrapper -->
                                <canvas id="chart-sales-dark" class="chart-canvas"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="card">
                        <div class="card-header bg-transparent">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h6 class="text-uppercase text-muted ls-1 mb-1">Ringkasan</h6>
                                    <h5 class="h3 mb-0">Siswa Terdata</h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Chart -->
                            <div class="chart">
                                <canvas id="chart-bars" class="chart-canvas"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Footer -->
            <footer class="footer pt-0">
                <div class="row align-items-center justify-content-lg-between">
                    <div class="col-lg-6">
                        <div class="copyright text-center text-lg-left text-muted">
                            &copy; <?= date('Y') ?> <a href="#" class="font-weight-bold ml-1" target="_blank"><a href="#">Sistem Informasi Anti Perundungan</a></a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Argon Scripts -->
    <!-- Core -->
    <script src="<?= base_url('assets/themes/argon1/vendor/js-cookie/js.cookie.js'); ?>"></script>
    <script src="<?= base_url('assets/themes/argon1/vendor/jquery.scrollbar/jquery.scrollbar.min.js'); ?>"></script>
    <script src="<?= base_url('assets/themes/argon1/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js'); ?>"></script>

    <!-- Argon JS -->
    <script src="<?= base_url('assets/themes/argon1/js/argon9f1e.js?v=1.1.0'); ?>"></script>

    <!-- datatabel -->
    <script src="<?= base_url('assets/'); ?>plugins/datatables/datatables.min.js"></script>
    <script src="<?= base_url('assets/'); ?>plugins/datatables/datatables.js"></script>

    <!-- sweetalert2 -->
    <script src="<?= base_url('assets/') ?>/plugins/sweetalert2/sweetalert2.all.min.js"></script>
    <script src="<?= base_url('assets/'); ?>/plugins/sweetalert2/myscript.js"></script>


    <!-- Pastikan Anda telah memasukkan SweetAlert dan JavaScript-nya pada halaman HTML Anda

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const formErrorElement = document.querySelector('.text-danger.ql-size-small');

        if (formErrorElement && formErrorElement.textContent.trim() !== '') {
            let timerInterval;

            Swal.fire({
                title: 'Auto close alert!',
                html: 'I will close in <b></b> milliseconds.',
                timer: 2000,
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading();
                    const b = Swal.getHtmlContainer().querySelector('b');
                    timerInterval = setInterval(() => {
                        b.textContent = Swal.getTimerLeft();
                    }, 100);
                },
                willClose: () => {
                    clearInterval(timerInterval);
                }
            }).then((result) => {
                if (result.dismiss === Swal.DismissReason.timer) {
                    console.log('I was closed by the timer');
                    // a.href = "<?= base_url('admin/akun_guru'); ?>";/
                }
            });
        }
    });
</script> -->



    <script>
        $(document).ready(function($) {
            $('#dataTable').DataTable({
                // ajax: {
                //     url: '<?php echo site_url('admin/data_api?action=list'); ?>',
                //     dataSrc: 'data'
                // },
                // columns: [{
                //         data: 'id'
                //     },
                //     {
                //         data: 'nama'
                //     },
                //     {
                //         data: 'email'
                //     },
                //     {
                //     }
                // ],
                "language": {
                    "search": "Cari:",
                    "lengthMenu": "Menampilkan _MENU_ data",
                    "info": "Menampilkan _START_ sampai _END_ data dari _TOTAL_ data",
                    "infoEmpty": "Tidak ada data yang ditampilkan",
                    "infoFiltered": "(dari total _MAX_ data)",
                    "zeroRecords": "Tidak ada hasil pencarian ditemukan",
                    "paginate": {
                        "first": "&laquo;",
                        "last": "&raquo;",
                        "next": "&rsaquo;",
                        "previous": "&lsaquo;"
                    }
                }
            });
        });
    </script>



    <!-- Script untuk upload gambat agar terlihat ditampilan inputnya -->
    <script>
        $('.custom-file-input').on('change', function() {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        });
    </script>


    <!-- script untuk preview gambar -->
    <script>
        function getImagePreview(event) {
            var image = URL.createObjectURL(event.target.files[0]);
            var iamgediv = document.getElementById('preview')

            var newImage = document.createElement('img');
            iamgediv.innerHTML = '';
            newImage.src = image;
            newImage.style.width = '100%';

            // Menambahkan class "img-thumbnail" pada elemen gambar
            newImage.classList.add('img-thumbnail');

            iamgediv.appendChild(newImage);
        }
    </script>


    <!-- Script untuk edit preview gambar -->
    <script>
        function getImagePreviewEdit(event) {
            var image = URL.createObjectURL(event.target.files[0]);
            var iamgediv = document.getElementById('edit_preview')

            var newImage = document.createElement('img');
            iamgediv.innerHTML = '';
            newImage.src = image;
            newImage.style.width = '100%';

            // Menambahkan class "img-thumbnail" pada elemen gambar
            newImage.classList.add('img-thumbnail');

            iamgediv.appendChild(newImage);
        }
    </script>

    <!-- script untuk seleksi data yang akan ditampilkan -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Ketika tombol Kabupaten di klik
            $('#kabupaten').on('change', function() {
                var kabupatenId = $(this).val();

                console.log(kabupatenId);

                // Hapus data kecamatan sebelumnya
                $('#kecamatan').empty();

                // Hapus data kota sebelumnya
                $('#kota').empty();

                // Ambil data kecamatan berdasarkan kabupatenId
                $.ajax({
                    url: "<?php echo base_url('admin/getKecamatan'); ?>",
                    type: "POST",
                    data: {
                        kabupatenId: kabupatenId
                    },
                    dataType: "json",
                    success: function(data) {
                        // Tambahkan opsi kecamatan ke dropdown
                        if (data.length > 0) {
                            $('#kecamatan').append('<option value="">Pilih..</option>');
                            $.each(data, function(key, value) {
                                $('#kecamatan').append('<option value="' + value.id + '">' + value.kecamatan + '</option>');
                            });
                        } else {
                            $('#kecamatan').append('<option value="">Tidak ada kecamatan</option>');
                        }
                    }
                });
            });

            // Ketika tombol Kecamatan di klik
            $('#kabupaten').on('change', function() {
                var kabupatenId = $(this).val();

                // Hapus data kota sebelumnya
                $('#kota').empty();

                // Ambil data kota berdasarkan kecamatanId
                $.ajax({
                    url: "<?php echo base_url('admin/getKota'); ?>",
                    type: "POST",
                    data: {
                        kabupatenId: kabupatenId
                    },
                    dataType: "json",
                    success: function(data) {
                        // Tambahkan opsi kota ke dropdown
                        if (data.length > 0) {
                            $.each(data, function(key, value) {
                                $('#kota').append('<option value="' + value.id + '">' + value.kota + '</option>');
                                // $('#kota').append('<option value="10">Kosongkan Kota</option>');
                            });
                        } else {
                            $('#kota').append('<option value="">Tidak ada kota</option>');
                        }
                    }
                });
            });
        });
    </script>




</body>

</html>