<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="<?= base_url('assets/themes/argon2/') ?>img/apple-icon.png">
    <link rel="icon" href="<?= base_url('assets/img/logo/logo_siap.png'); ?>" type="image/png">
    <title>
        SIAP - Login
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

    <!-- script loading dan  disable-->
    <script>
        var blockEndTime = <?php echo json_encode($this->session->userdata('blockEndTime') ?? null); ?>;
        console.log(blockEndTime);

        function disableButtonAndCountdown() {
            var submitButton = document.getElementById("submitButton");
            var countdownElement = document.getElementById("countdown");

            if (blockEndTime && new Date().getTime() / 1000 < blockEndTime) {
                submitButton.disabled = true;
                countdownElement.style.display = "inline"; // Menampilkan elemen countdown

                var countdownInterval = setInterval(function() {
                    var remainingTime = blockEndTime - Math.floor(Date.now() / 1000);
                    if (remainingTime > 0) {
                        var minutes = Math.floor(remainingTime / 60);
                        var seconds = remainingTime % 60;
                        countdownElement.innerHTML = "Menunggu selama " + minutes + " menit " + seconds + " detik";
                    } else {
                        clearInterval(countdownInterval);
                        countdownElement.style.display = "none"; // Menyembunyikan elemen countdown
                        submitButton.value = "Login";
                        submitButton.disabled = false;
                    }
                }, 1000);
            }
        }

        // Panggil fungsi saat halaman selesai dimuat
        window.onload = disableButtonAndCountdown;
    </script>


    <!-- styling animation loading -->
    <style>
        #loader {
            bottom: 0;
            z-index: 999;
            transition: 1s;
        }

        .img-loader {
            width: 15rem;
            height: 15rem;
            animation: 4s ease-out 1s infinite reverse both running loader;
            transition: 1s;
        }

        @keyframes loader {
            0% {
                opacity: 1;
            }

            50% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }

        .active-link1 {
            color: #00FFFF !important;
        }
    </style>
</head>

<body class="" onload="loaderEnd()">

    <section id="loader" class="vh-100 vw-100 bg-white overflow-hidden d-flex position-fixed flex-column justify-content-center align-items-center">
        <img src="<?= base_url('/assets/img/logo/logo_siap.png'); ?>" class="img-loader" alt="">
    </section>

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
                                    <h4 class="font-weight-bolder">Log In</h4>
                                    <p class="mb-0">Masukan email dan password untuk login</p>
                                </div>

                                <div class="card-body">
                                    <!-- notif eror -->
                                    <?= $this->session->flashdata('message'); ?>

                                    <form role="form" method="post" action="<?= base_url('auth') ?>">
                                        <!-- username -->
                                        <div class="mb-3">
                                            <p>
                                                <small class="text-danger"> <?= form_error('username'); ?></small>
                                            </p>
                                            <input type="text" class="form-control form-control-lg" placeholder="Username" aria-label="username" id="username" name="username" value="<?= set_value('username') ?>">
                                        </div>
                                        <!-- password -->
                                        <div class="mb-3">
                                            <p><small class="text-danger"> <?= form_error('password'); ?></small></p>
                                            <input type="password" class="form-control form-control-lg" placeholder="Password" aria-label="Password" id="password" name="password">
                                        </div>
                                        <!-- remember me  -->
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" id="rememberMe" name="rememberMe" value="1">
                                                    <label class="form-check-label" for="rememberMe">Remember me</label>
                                                </div>
                                            </div>
                                            <div>
                                                <a href="<?= base_url('lupaPassword') ?>" class="text-primary text-gradient font-weight-bold text-sm">lupa password</a>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0" id="submitButton">Log in</button>
                                        </div>
                                        <div class="text-center">
                                            <a href="<?= base_url('') ?>" class="btn btn-lg btn-success btn-lg w-100 mt-4 mb-0">Back to Home</a>
                                        </div>
                                    </form>
                                    <!-- Elemen untuk menampilkan countdown -->
                                    <div class="text-center pt-3">
                                        <p id="countdown" style="display: none;" class="text-center"></p>
                                    </div>
                                </div>
                                <div class="card-footer text-center pt-0 px-lg-2 px-1">
                                    <p class="mb-4 text-sm mx-auto">
                                        Tidak memiliki akun?
                                        <a href="javascript:;" class="text-primary text-gradient font-weight-bold">Hubungi</a>
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

    <!-- loading javascript -->
    <script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="<?= base_url('assets/plugins/') ?>loader-hander.js"></script>

    <!-- Panggil fungsi saat dokumen telah dimuat -->
    <script>
        $(document).ready(function() {
            disableButtonAndCountdown();
        });
    </script>
</body>

</html>