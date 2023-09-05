<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIAP</title>

    <link rel="icon" href="<?= base_url('assets/img/logo/logo_siap.png'); ?>" type="image/png">
    <!-- FONTS ONLINE -->
    <link href='https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>

    <!--MAIN STYLE-->
    <link rel="stylesheet" type="text/css" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link href="<?= base_url('assets/themes/sprint/') ?>css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url('assets/themes/sprint/') ?>css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url('assets/themes/sprint/') ?>css/main.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url('assets/themes/sprint/') ?>css/style.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url('assets/themes/sprint/') ?>css/responsive.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url('assets/themes/sprint/') ?>css/animate.css" rel="stylesheet" type="text/css">

    <style>
        #loader {
            bottom: 0;
            z-index: 999;
            transition: 1s;
        }

        .img-loader {
            width: 20rem;
            height: 20rem;
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


    <!-- Plugins CSS (All Plugins Files) -->
    <link rel="stylesheet" href="<?= base_url('/assets/'); ?>plugins/loader/swiper-bundle.min.css" />
    <link rel="stylesheet" href="<?= base_url('/assets/'); ?>plugins/loader/animate.min.css" />
    <link rel="stylesheet" href="<?= base_url('/assets/'); ?>plugins/loader/aos.min.css" />
    <link rel="stylesheet" href="<?= base_url('/assets/'); ?>plugins/loader/nice-select.min.css" />
    <link rel="stylesheet" href="<?= base_url('/assets/'); ?>plugins/loader/jquery-ui.min.css" />
    <link rel="stylesheet" href="<?= base_url('/assets/'); ?>plugins/loader/odometer.min.css" />
    <link rel="stylesheet" href="<?= base_url('/assets/'); ?>plugins/loader/fancybox.min.css" />

    <!-- SLIDER REVOLUTION 4.x CSS SETTINGS -->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/themes/sprint/') ?>rs-plugin/css/settings.css" media="screen" />

    <!-- CSS Files -->
    <link id="pagestyle" href="<?= base_url('assets/themes/argon2/') ?>css/argon-dashboard.css?v=2.0.4" rel="stylesheet" />

    <style>
        body {
            margin: 0;
            padding: 0;
            overflow: hidden;
        }

        .home-slider {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            background: url('<?= base_url('assets/img/login/home.png') ?>') no-repeat center center;
            background-size: cover;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            text-align: center;
            color: #fff;
            z-index: -1;
        }

        .mask {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
    </style>
</head>

<body onload="loaderEnd()">

    <section id="loader" class="vh-100 vw-100 bg-white overflow-hidden d-flex position-fixed flex-column justify-content-center align-items-center">
        <img src="<?= base_url('/assets/img/logo/logo_siap.png'); ?>" class="img-loader" alt="">
    </section>


    <header class="main-header">
        <div class="container">
            <div class="logo"> <a href="<?= base_url('') ?>"> <img src="<?= base_url('assets/img/logo/logo_siap1.png') ?>" alt="Sprint Logo" width="150px"></a></div>
            <!-- Nav -->
            <nav>
                <ul id="ownmenu" class="ownmenu">
                    <li><a href="<?= base_url('') ?>" style="margin-top: 10px;"><b style="font-size:20px; color:#fff; ">Home</b></a></li>
                    <li><a href="<?= base_url('login') ?>" style="margin-top: 10px;"><b style="font-size:20px; color:#fff; ">Login</b></a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!--======= HOME MAIN SLIDER =========-->
    <div class="home-slider">
        <span class="mask bg-gradient-primary opacity-6"></span>
        <h4 class="mt-5 text-white font-weight-bolder position-relative" style="font-size:30px;">"Sistem Informasi Anti Perundungan"</h4>
        <p class="text-white position-relative" style="font-size:20px;">Sistem Informasi Anti Perundungan adalah teknologi yang diciptakan untuk mengatasi dan mencegah perundungan</p>
    </div>

    <script src="<?= base_url('assets/themes/sprint/') ?>js/jquery-1.11.3.min.js"></script>
    <script src="<?= base_url('assets/themes/sprint/') ?>js/bootstrap.min.js"></script>
    <script src="<?= base_url('assets/themes/sprint/') ?>js/own-menu.js"></script>
    <script src="<?= base_url('assets/themes/sprint/') ?>js/owl.carousel.min.js"></script>
    <script src="<?= base_url('assets/themes/sprint/') ?>js/jquery.isotope.min.js"></script>
    <script src="<?= base_url('assets/themes/sprint/') ?>js/counter.js"></script>

</body>

<script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E=" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- loading javascript -->
<script src="<?= base_url('assets/plugins/') ?>loader-hander.js"></script>

</html>