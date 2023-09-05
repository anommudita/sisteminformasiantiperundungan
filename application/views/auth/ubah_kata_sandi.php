<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="<?= base_url('assets/themes/argon2/') ?>img/apple-icon.png">
    <link rel="icon" href="<?= base_url('assets/img/logo/logo_siap.png'); ?>" type="image/png">
    <title>
        SIAP - Ubah Kata Sandi
    </title>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="<?= base_url('assets/themes/argon2/') ?>css/nucleo-icons.css" rel="stylesheet" />
    <link href="<?= base_url('assets/themes/argon2/') ?>css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="<?= base_url('assets/themes/argon2/') ?>css/nucleo-svg.css" rel="stylesheet" />
    <!-- CSS Files -->
    <link id="pagestyle" href="<?= base_url('assets/themes/argon2/') ?>css/argon-dashboard.css?v=2.0.4" rel="stylesheet" />
</head>

<body class="">
    <div class="container position-sticky z-index-sticky top-0">
    </div>
    <main class="main-content  mt-0">
        <section>
            <div class="page-header min-vh-100">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
                            <div class="card card-plain">
                                <div class="card-header pb-0 text-start">
                                    <h4 class="font-weight-bolder">Ganti Kata Sandi</h4>
                                    <p class="mb-0">Masukan kata sandi dan konfirmasi kata sandi </p>
                                </div>
                                <div class="card-body">
                                    <!-- notif eror -->
                                    <?= $this->session->flashdata('message'); ?>

                                    <form role="form" method="post" action="<?= base_url('auth/ubahKataSandi') ?>">
                                        <!-- kata sandi -->
                                        <div class="mb-3">
                                            <p>
                                                <small class="text-danger"> <?= form_error('password1'); ?></small>
                                            </p>
                                            <input type="password" class="form-control form-control-lg" placeholder="Kata Sandi" aria-label="password1" id="password1" name="password1">
                                        </div>

                                        <div class="mb-3">
                                            <p>
                                                <small class="text-danger"> <?= form_error('password2'); ?></small>
                                            </p>
                                            <input type="password" class="form-control form-control-lg" placeholder="Konfirmasi Kata Sandi" aria-label="password2" id="password2" name="password2">
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0" id="SimpanKataSandi">Simpan Kata Sandi</button>
                                        </div>
                                    </form>
                                    <!-- Elemen untuk menampilkan countdown -->
                                    <div class="text-center pt-3">
                                        <p id="countdown" style="display: none;" class="text-center"></p>
                                    </div>
                                </div>
                                <div class="card-footer text-center pt-0 px-lg-2 px-1">
                                    <p class="mb-4 text-sm mx-auto">
                                        Jika sudah memiliki akun silahkan
                                        <a href="<?= base_url('login') ?>" class="text-primary text-gradient font-weight-bold">Login</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column">
                            <div class="position-relative bg-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center overflow-hidden" style="background-image: url('<?= base_url('assets/img/login/default.png') ?>');background-size: cover;">
                                <span class="mask bg-gradient-primary opacity-6"></span>
                                <h4 class="mt-5 text-white font-weight-bolder position-relative">"Sistem Informasi Anti Perundungan"</h4>
                                <p class="text-white position-relative">Sistem Informasi Anti Perundungan adalah teknologi yang diciptakan untuk mengatasi dan mencegah perundungan</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <!--   Core JS Files   -->
    <script src="<?= base_url('assets/themes/argon2/') ?>js/core/popper.min.js"></script>
    <script src="<?= base_url('assets/themes/argon2/') ?>js/core/bootstrap.min.js"></script>
    <script src="<?= base_url('assets/themes/argon2/') ?>js/plugins/perfect-scrollbar.min.js"></script>
    <script src="<?= base_url('assets/themes/argon2/') ?>js/plugins/smooth-scrollbar.min.js"></script>
    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="<?= base_url('assets/themes/argon2/') ?>js/argon-dashboard.min.js?v=2.0.4"></script>
</body>

</html>