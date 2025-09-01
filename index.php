<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Museum Nusantara</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Tangerine">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="assets/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- untuk pavicon -->
    <link rel="icon" type="image/jpeg" href="gambar/museum.jpeg">

    <style>
        /* Container untuk background slide */
        .background-slide {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            /* Letakkan di belakang konten */
            background-size: cover;
            background-position: center;
            animation: slide 25s infinite;
            /* 5 gambar x 5 detik = 25 detik */
        }

        /* Animasi untuk slide */
        @keyframes slide {
            0% {
                background-image: url('gambar/slide/1.jpg');
            }

            20% {
                background-image: url('gambar/slide/2.jpg');
            }

            25% {
                background-image: url('gambar/slide/3.jpg');
            }

            45% {
                background-image: url('gambar/slide/4.jpg');
            }

            50% {
                background-image: url('gambar/slide/5.jpg');
            }

            70% {
                background-image: url('gambar/slide/6.jpg');
            }

            75% {
                background-image: url('gambar/slide/7.jpg');
            }

            95% {
                background-image: url('gambar/slide/8.jpg');
            }

            100% {
                background-image: url('gambar/slide/1.jpg');
            }
        }

        /* Pastikan konten di atas background slide */
        .content-wrapper {
            position: relative;
            z-index: 1;
            background-color: rgba(254, 254, 254, 0);
            /* Tambahkan lapisan transparan agar teks mudah dibaca */
        }
    </style>

</head>

<body class="hold-transition layout-top-nav">
    <div class="background-slide"></div>
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand-md navbar-light navbar-white" style="height: 80px; padding: 10px 20px; font-size: 18px;">
            <div class="container-fluid" style="padding: 0 20px;">
                <a href="#" class="navbar-brand d-flex align-items-center" style="gap: 10px;">
                    <img src="gambar/logo.jpg" alt="AdminLTE Logo"
                        class="brand-image img-circle elevation-3"
                        style="opacity: 1; height: 55px; width: 55px; border: 2px solid #ddd;">
                    <span class="brand-text font-weight-bold"
                        style="font-family: 'Tangerine', serif; font-size: 42px; color:rgb(29, 21, 10); text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.3);">
                        Sireum Nusantara
                    </span>
                </a>
                <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
                    <li class="nav-item">
                        <div class="d-flex align-items-center justify-content-center" style="gap: 10px;">
                            <button type="button" class="btn btn-warning" style="width: 80px;" onclick="location.href='index.php';">Beranda</button>
                            <button type="button" class="btn btn-outline-info" style="width: 80px;" onclick="location.href='info.php';">Info</button>
                            <button type="button" class="btn btn-outline-dark" onclick="location.href='login.php';">Sign In</button>
                            <button type="button" class="btn btn-outline-danger" onclick="location.href='registrasi.php';">Sign Up</button>

                        </div>
                    </li>
                </ul>
            </div>
        </nav>
        <!-- /.navbar -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <div class="content">
                <div class="container-fluid d-flex justify-content-center align-items-center" style="height: 80vh;">
                    <div class="text-center">
                        <h1 style="color:white; text-decoration:bold;font-family: 'Tangerine', serif; font-size: 60px;"><strong>Selamat Datang di Sireum Nusantara <br> Software Museum Nusantara By Kelompok 3</strong>
                        </h1>
                    </div>
                </div>
            </div>
        </div>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        <footer class="main-footer">
            <!-- To the right -->
            <div class="float-right d-none d-sm-inline">
                Museum Nusantara by Sireum
            </div>
            <!-- Default to the left -->
            <strong>Copyright &copy; 2025 <a href="https://adminlte.io">IT PGT</a>.</strong> All rights reserved.
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="assets/dist/js/adminlte.min.js"></script>

</body>

</html>