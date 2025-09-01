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

</head>

<body class="hold-transition layout-top-nav">
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
      <!-- Content Header (Page header) -->
      <div class="content-header">

      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <div class="content">
        <div class="container-fluid">

          <div class="row">

            <div class="col-lg-12">
              <div class="card">
                <div class="card-header bg-navy text-white d-flex justify-content-center align-items-center">
                  <h5 class="card-title m-0">INFORMASI</h5>
                </div>
              </div>

            </div>
          </div>


          <div class="row">

            <div class="col-lg-4">
              <div class="card">
                <div class="card-header bg-maroon text-white d-flex justify-content-center align-items-center">
                  <h5 class="card-title m-0">Admin</h5>
                </div>
                <div class="card-body">
                  <h6 class="card-title">
                    <span class="badge bg-secondary px-4" style="font-size: 1rem; margin-bottom:5px;">Definisi Admin Museum</span>
                  </h6>
                  <p class="card-text" style="text-align: justify;">Admin adalah pihak yang memiliki otoritas tertinggi dalam pengelolaan aplikasi SIREUM. Admin bertanggung jawab untuk mengawasi, mengontrol, dan memastikan kelancaran operasional sistem.</p>

                </div>
              </div>

              <div class="card card-secondary card-outline" style="height: 52%;">
                <div class="card-header">
                  <h5 class="card-title m-0">Fitur dan halaman Admin</h5>
                </div>
                <div class="card-body">
                  <a class="btn btn-app btn-sm bg-secondary" data-toggle="modal" data-target="#modal-xl1">
                    <span class="badge bg-danger">1</span>
                    <i class="fa-brands fa-dashcube fa-xl"></i> <br>Dashboard
                  </a>
                  <a class="btn btn-app btn-sm bg-orange" data-toggle="modal" data-target="#modal-xl25">
                    <span class="badge bg-danger">2</span>
                    <i class="fa-solid fa-user-tie fa-2xl"></i> <br>+ Admin
                  </a>
                  <a class="btn btn-app btn-sm bg-success" data-toggle="modal" data-target="#modal-xl2">
                    <span class="badge bg-danger">3</span>
                    <i class="fa-brands fa-redhat fa-2xl"></i> <br>+ Operator
                  </a>
                  <a class="btn btn-app btn-sm bg-info" data-toggle="modal" data-target="#modal-xl3">
                    <span class="badge bg-teal">4</span>
                    <i class="fa-solid fa-address-book fa-xl"></i><br><i class="fa-regular fa-eye fa-sm"></i>&nbsp;Kontak
                  </a>
                  <a class="btn btn-app btn-sm bg-warning" data-toggle="modal" data-target="#modal-xl4">
                    <span class="badge bg-info">5</span>
                    <i class="fa-solid fa-file fa-xl"></i><br><i class="fa-regular fa-eye fa-sm"></i>&nbsp;Laporan
                  </a>
                  <a class="btn btn-app btn-sm bg-danger">
                    <span class="badge bg-info">6</span>
                    <i class="fa-solid fa-power-off fa-xl"></i><br> Logout
                  </a>
                </div>

              </div>
            </div>
            <!-- /.col-md-6 -->
            <div class="col-lg-4">
              <div class="card">
                <div class="card-header bg-olive text-white d-flex justify-content-center align-items-center">
                  <h5 class="card-title m-0">Operator</h5>
                </div>
                <div class="card-body">
                  <h6 class="card-title">
                    <span class="badge bg-secondary px-4" style="font-size: 1rem; margin-bottom:5px;">Definisi Operator Museum</span>
                  </h6>

                  <p class="card-text" style="text-align: justify;">Operator adalah pihak yang bertanggung jawab dalam pengelolaan operasional museum, termasuk konten, galeri, data pengunjung, harga tiket, reservasi, transaksi, e-ticket, dan penyusunan laporan.</p>

                </div>
              </div>

              <div class="card card-secondary card-outline" style="height: 52%;">
                <div class="card-header">
                  <h5 class="card-title m-0">Fitur dan halaman Operator ( Manajemen )</h5>
                </div>
                <div class="card-body">

                  <!-- Application buttons -->
                  <a class="btn btn-app bg-secondary" data-toggle="modal" data-target="#modal-xl5">
                    <span class="badge bg-success">1</span>
                    <i class="fa-brands fa-dashcube fa-xl"></i><br> Dashboard
                  </a>
                  <a class="btn btn-app bg-success" data-toggle="modal" data-target="#modal-xl6">
                    <span class="badge bg-purple">2</span>
                    <i class="fa-solid fa-arrows-to-circle fa-xl"></i><br> + Konten
                  </a>
                  <a class="btn btn-app bg-maroon" data-toggle="modal" data-target="#modal-xl7">
                    <span class="badge bg-teal">3</span>
                    <i class="fa-solid fa-camera-retro fa-xl"></i><br> + Galeri
                  </a>
                  <a class="btn btn-app bg-warning" data-toggle="modal" data-target="#modal-xl8">
                    <span class="badge bg-info">4</span>
                    <i class="fa-solid fa-people-pulling fa-xl"></i><br><i class="fa-solid fa-eye fa-sm"></i>&nbsp;pengunjung
                  </a>
                  <a class="btn btn-app bg-info" data-toggle="modal" data-target="#modal-xl9">
                    <span class="badge bg-danger">5</span>
                    <i class="fa-solid fa-sack-dollar fa-xl"></i><br> + Harga
                  </a>
                  <a class="btn btn-app bg-indigo" data-toggle="modal" data-target="#modal-xl10">
                    <span class="badge bg-danger">6</span>
                    <i class="fa-solid fa-bell-concierge fa-xl"></i><br> <i class="fa-solid fa-square-check fa-sm"></i>&nbsp;Reservasi
                  </a>
                  <a class="btn btn-app bg-orange" data-toggle="modal" data-target="#modal-xl11">
                    <span class="badge bg-danger">7</span>
                    <i class="fa-solid fa-hand-holding-dollar fa-xl"></i><br> <i class="fa-solid fa-square-check fa-sm"></i>&nbsp;Transaksi
                  </a>
                  <a class="btn btn-app bg-pink" data-toggle="modal" data-target="#modal-xl12">
                    <span class="badge bg-danger">8</span>
                    <i class="fa-solid fa-ticket fa-xl"></i><br> <i class="fa-solid fa-square-check fa-sm"></i>&nbsp;E-Tiket
                  </a>
                  <a class="btn btn-app bg-lime" data-toggle="modal" data-target="#modal-xl13">
                    <span class="badge bg-danger">9</span>
                    <i class="fa-solid fa-print fa-xl"></i><br> <i class="fa-solid fa-square-check fa-sm"></i>&nbsp;Laporan
                  </a>
                  <a class="btn btn-app btn-sm bg-danger" data-toggle="modal" data-target="#modal-xl14">
                    <span class="badge bg-info">10</span>
                    <i class="fa-solid fa-power-off fa-xl"></i><br> Logout
                  </a>


                </div>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="card">
                <div class="card-header bg-orange text-white d-flex justify-content-center align-items-center">
                  <h5 class="card-title m-0">Pengunjung</h5>
                </div>
                <div class="card-body">
                  <h6 class="card-title">
                    <span class="badge bg-secondary px-4" style="font-size: 1rem; margin-bottom:5px;">Definisi Pengunjung Museum</span>
                  </h6>

                  <p class="card-text" style="text-align: justify;">Pengunjung adalah pihak yang memiliki hak untuk mengakses konten atau acara yang tersedia, melihat galeri, melakukan proses reservasi dan transaksi untuk kunjungan ke museum, serta mencetak tiket sebagai bukti reservasi yang telah dilakukan.</p>

                </div>
              </div>

              <div class="card card-secondary card-outline" style="height: 52%;">
                <div class="card-header">
                  <h5 class="card-title m-0">Fitur dan halaman Pengunjung</h5>
                </div>
                <div class="card-body">
                  <a class="btn btn-app bg-secondary">
                    <span class="badge bg-success">1</span>
                    <i class="fa-brands fa-dashcube fa-xl"></i><br> Dashboard
                  </a>
                  <a class="btn btn-app bg-success">
                    <span class="badge bg-purple">2</span>
                    <i class="fa-solid fa-arrows-to-circle fa-xl"></i><br><i class="fa-solid fa-eye fa-sm"></i>&nbsp;Konten
                  </a>
                  <a class="btn btn-app bg-maroon">
                    <span class="badge bg-teal">3</span>
                    <i class="fa-solid fa-camera-retro fa-xl"></i><br><i class="fa-solid fa-square-caret-down fa-sm"></i>&nbsp;Galeri
                  </a>

                  <a class="btn btn-app bg-indigo">
                    <span class="badge bg-danger">4</span>
                    <i class="fa-solid fa-bell-concierge fa-xl"></i><br> <i class="fa-solid fa-list fa-sm"></i>&nbsp;Reservasi
                  </a>
                  <a class="btn btn-app bg-orange">
                    <span class="badge bg-danger">5</span>
                    <i class="fa-solid fa-comments-dollar fa-xl"></i><br> <i class="fa-solid fa-list fa-sm"></i>&nbsp;Transaksi
                  </a>
                  <a class="btn btn-app bg-pink">
                    <span class="badge bg-danger">6</span>
                    <i class="fa-solid fa-ticket fa-xl"></i><br> <i class="fa-solid fa-print fa-sm"></i>&nbsp;E-Tiket
                  </a>
                  <a class="btn btn-app bg-lime">
                    <span class="badge bg-danger">7</span>
                    <i class="fa-regular fa-star fa-xl"></i><br> <i class="fa-solid fa-pen-clip fa-sm"></i>&nbsp;Review
                  </a>
                  <a class="btn btn-app bg-black">
                    <span class="badge bg-danger">8</span>
                    <i class="fa-solid fa-unlock-keyhole fa-xl"></i><br> <i class="fa-solid fa-key fa-sm"></i></i>&nbsp;Password
                  </a>
                  <a class="btn btn-app btn-sm bg-danger">
                    <span class="badge bg-info">9</span>
                    <i class="fa-solid fa-power-off fa-xl"></i><br> Logout
                  </a>


                </div>
              </div>
            </div>

            <!-- /.col-md-6 -->
          </div>
          <!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>

      <!-- Modal Admin  -->
      <div class="modal fade" id="modal-xl1">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Halaman Dashboard Admin</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <img src="./gambar/dash/admin/dashboard_admin.png" alt="" style="width: 70%; height: 60%;">
            </div>

            <div class="modal-footer justify-content-end">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>

          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

      <div class="modal fade" id="modal-xl2">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Halaman Manajemen Operator</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <img src="./gambar/dash/admin/manOperator_admin.png" alt="" style="width: 70%; height: 60%;">
            </div>

            <div class="modal-footer justify-content-end">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>

          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

      <div class="modal fade" id="modal-xl3">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Halaman Manajemen Kontak</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <img src="./gambar/dash/admin/manKontak_admin.png" alt="" style="width: 70%; height: 60%;">
            </div>

            <div class="modal-footer justify-content-end">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>

          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

      <div class="modal fade" id="modal-xl4">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Halaman Manajemen Laporan</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <img src="./gambar/dash/admin/manLaporan_admin.png" alt="" style="width: 70%; height: 60%;">
            </div>

            <div class="modal-footer justify-content-end">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>

          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

      <div class="modal fade" id="modal-xl25">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Halaman Manajemen Admin</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <img src="./gambar/dash/admin/manAdmin.png" alt="" style="width: 70%; height: 60%;">
            </div>

            <div class="modal-footer justify-content-end">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>

          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

      <!-- Modal Operator -->
      <div class="modal fade" id="modal-xl5">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Halaman Dashboard Operartor</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <img src="./gambar/dash/operator/dashboard_operator.png" alt="" style="width: 70%; height: 60%;">
            </div>

            <div class="modal-footer justify-content-end">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>

          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

      <div class="modal fade" id="modal-xl6">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Halaman Manajemen Konten</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <img src="./gambar/dash/operator/manKonten1_operator.png" alt="" style="width: 70%; height: 60%;">
            </div>

            <div class="modal-footer justify-content-end">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>

          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

      <div class="modal fade" id="modal-xl7">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Halaman Manajemen Galeri</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <img src="./gambar/dash/operator/manGaleri1.png" alt="" style="width: 70%; height: 60%;">
            </div>

            <div class="modal-footer justify-content-end">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>

          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

      <div class="modal fade" id="modal-xl8">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Halaman Manajemen Pengunjung</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <img src="./gambar/dash/operator/manPengunjung_operator.png" alt="" style="width: 70%; height: 60%;">
            </div>

            <div class="modal-footer justify-content-end">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>

          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

      <div class="modal fade" id="modal-xl9">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Halaman Manajemen Harga</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <img src="./gambar/dash/operator/manHarga_operator.png" alt="" style="width: 70%; height: 60%;">
            </div>

            <div class="modal-footer justify-content-end">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>

          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

      <div class="modal fade" id="modal-xl10">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Halaman Manajemen Reservasi</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <img src="./gambar/dash/operator/manReservasi_operator.png" alt="" style="width: 70%; height: 60%;">
            </div>

            <div class="modal-footer justify-content-end">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>

          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

      <div class="modal fade" id="modal-xl11">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Halaman Manajemen Transaksi</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <img src="./gambar/dash/operator/manTransaksi_operator.png" alt="" style="width: 70%; height: 60%;">
            </div>

            <div class="modal-footer justify-content-end">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>

          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

      <div class="modal fade" id="modal-xl12">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Halaman Manajemen E-Tiket</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <img src="./gambar/dash/operator/manTiket_operator.png" alt="" style="width: 70%; height: 60%;">
            </div>

            <div class="modal-footer justify-content-end">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>

          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

      <div class="modal fade" id="modal-xl13">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Halaman Manajemen Laporan</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <img src="./gambar/dash/operator/manLaporan_operator.png" alt="" style="width: 70%; height: 60%;">
            </div>

            <div class="modal-footer justify-content-end">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>

          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->


      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

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