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


    <style>
        .transparent-button {
            background-color: transparent;
            /* Mengatur latar belakang tombol menjadi transparan */
            border: none;
            /* Menghapus border tombol */
            outline: none;
            /* Menghapus outline tombol saat di-focus */
            padding: 0;
            /* Menghapus padding default tombol */
            cursor: pointer;
            /* Mengubah cursor saat diarahkan ke tombol */
        }

        @media (max-width: 768px) {

            /* Sesuaikan dengan breakpoint mobile yang Anda gunakan */
            .transparent-button:focus,
            .transparent-button:active {
                outline: none;
            }
        }
    </style>

</head>

<body class="@yield('sidebar_type')">