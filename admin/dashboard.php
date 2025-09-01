<?php
session_start();
?>

<?php
// Panggil koneksi
require '../config/database.php';

// Query untuk menghitung jumlah operator
$query_jumlah = "SELECT COUNT(*) AS jumlah_operator FROM operator";
$result_jumlah = mysqli_query($koneksi, $query_jumlah);
$row_jumlah = mysqli_fetch_assoc($result_jumlah);
$jumlah_operator = $row_jumlah['jumlah_operator'];

// Query untuk mengambil data operator
$query_operator = "SELECT id_operator, username_operator, nama_operator, nomor_telepon_operator FROM operator";
$result_operator = mysqli_query($koneksi, $query_operator);

// Simpan data operator ke dalam array
$operators = [];
while ($row = mysqli_fetch_assoc($result_operator)) {
  $operators[] = $row;
}

// Query untuk mendapatkan jumlah kontak
$query_kontak_jumlah = "SELECT COUNT(id_kontak) AS jumlah_kontak FROM kontak";
$result_kontak_jumlah = mysqli_query($koneksi, $query_kontak_jumlah);
$row_kontak_jumlah = mysqli_fetch_assoc($result_kontak_jumlah);
$jumlah_kontak = $row_kontak_jumlah['jumlah_kontak'];

// Query untuk mengambil data kontak
$query_kontak = "SELECT username, isi_pesan FROM kontak";
$result_kontak = mysqli_query($koneksi, $query_kontak);

// Simpan data kontak ke dalam array
$kontaks = [];
while ($row = mysqli_fetch_assoc($result_kontak)) {
  $kontaks[] = $row;
}

// Query untuk mendapatkan jumlah uang transaksi (total pendapatan)
$query_uang_transaksi = "SELECT SUM(uang_transaksi) AS total_pendapatan FROM transaksi";
$result_uang_transaksi = mysqli_query($koneksi, $query_uang_transaksi);
$row_uang_transaksi = mysqli_fetch_assoc($result_uang_transaksi);
$jumlah_uang_transaksi = $row_uang_transaksi['total_pendapatan'];

// Query untuk mendapatkan nama pengunjung, jumlah kunjungan, dan metode transaksi
$query_pengunjung = "
    SELECT 
        pengunjung.nama_pengunjung, jumlah_pengunjung,
        transaksi.metode_transaksi
    FROM pengunjung
    LEFT JOIN reservasi ON pengunjung.id_pengunjung = reservasi.id_pengunjung
    LEFT JOIN transaksi ON reservasi.id_reservasi = transaksi.id_reservasi
    GROUP BY pengunjung.nama_pengunjung, transaksi.metode_transaksi, reservasi.jumlah_pengunjung
";
$result_pengunjung = mysqli_query($koneksi, $query_pengunjung);

// Simpan data pengunjung ke dalam array
$data_pengunjung = [];
while ($row = mysqli_fetch_assoc($result_pengunjung)) {
  $data_pengunjung[] = $row;
}

// Query untuk mengambil data harga_awal dan harga_update
$query_money = "SELECT harga_awal, harga_update FROM money";
$result_money = mysqli_query($koneksi, $query_money);

// Simpan data money ke dalam array
$money_data = [];
while ($row = mysqli_fetch_assoc($result_money)) {
  $money_data[] = $row;
}

// Ambil harga_update untuk ditampilkan secara langsung
$harga_update = isset($money_data[0]['harga_update']) ? $money_data[0]['harga_update'] : 0;
?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard Admin</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../assets/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/simple-icons/14.0.1/simpleicons.svg">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="../assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="../assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="../assets/plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../assets/dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="../assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="../assets/plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="../assets/plugins/summernote/summernote-bs4.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">

  <div class="wrapper">


    <!-- Navbar -->
    <?php
    include 'navbar.php';

    ?>
    <!-- /.navbar -->

    <?php
    include 'sidebar.php';

    ?>
    <!-- Main Sidebar Container -->


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">
                <span class="badge badge-dark"><i class="fa-solid fa-user-tie"></i>&nbsp;Dashboard Admin</span>
            </div><!-- /.col -->
            <div class="col-sm-6">

            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <!-- Small boxes (Stat box) -->
          <div class="row">
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-info">
                <div class="inner">
                  <h3><?= $jumlah_operator; ?>&nbsp;Operator</h3>

                  <p>Jumlah Operator</p>
                </div>
                <div class="icon">
                  <i class="fa-solid fa-user fa-flip"></i>
                </div>
                <a href="#modal-default1" data-toggle="modal" class="small-box-footer">Lihat Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-success">
                <div class="inner">
                  <h3><?= $jumlah_kontak; ?>&nbsp;Pesan</h3>

                  <p>Jumlah Pesan Pengunjung</p>
                </div>
                <div class="icon">
                  <i class="fa-solid fa-envelope-open fa-fade"></i>
                </div>
                <a href="#modal-default2" data-toggle="modal" class="small-box-footer">Lihat Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-warning">
                <div class="inner">
                  <h3>Rp. <?= number_format($jumlah_uang_transaksi, 0, ',', '.'); ?></h3>

                  <p>Jumlah Pendapatan</p>
                </div>
                <div class="icon">
                  <i class="fa-solid fa-hand-holding-dollar fa-bounce" style="color: #030303;"></i>
                </div>
                <a href="#modal-default3" data-toggle="modal" class="small-box-footer">Lihat Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-danger">
                <div class="inner">
                  <h3>Rp. <?= number_format($harga_update, 0, ',', '.'); ?>&nbsp;</h3>

                  <p>Harga Tiket Museum</p>
                </div>
                <div class="icon">
                  <i class="fa-solid fa-ticket-simple fa-shake"></i>
                </div>
                <a href="#modal-default4" data-toggle="modal" class="small-box-footer">Lihat Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
          </div>
          <!-- /.row -->
          <!-- Main row -->
          <div class="row">
            <!-- Left col -->

            <!-- right col -->
          </div>

          <?php
          include 'chartjs.php';
          ?>


          <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
      </section>
      <!-- /.content -->

      <div class="modal fade" id="modal-default1">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Profil Mini Operator</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">

              <div class="card">

                <!-- /.card-header -->

                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>Id</th>
                      <th>Nama</th>
                      <th>Username</th>
                      <th>No Telp</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($operators as $operator): ?>
                      <tr>
                        <td><?= htmlspecialchars($operator['id_operator']); ?></td>
                        <td><?= htmlspecialchars($operator['nama_operator']); ?></td>
                        <td><?= htmlspecialchars($operator['username_operator']); ?></td>
                        <td><?= htmlspecialchars($operator['nomor_telepon_operator']); ?></td>
                      </tr>
                    <?php endforeach; ?>
                    </tfoot>
                </table>

                <!-- /.card-body -->
              </div>

            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>

            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>

      <!-- Modal 2 -->
      <div class="modal fade" id="modal-default2">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Pesan Pengunjung</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="card">

                <!-- /.card-header -->

                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>Nama Pengunjung</th>
                      <th>Pesan Pengunjung</th>

                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($kontaks as $kontak): ?>
                      <tr>
                        <td><?= htmlspecialchars($kontak['username']); ?></td>
                        <td><?= htmlspecialchars($kontak['isi_pesan']); ?></td>
                      </tr>
                    <?php endforeach; ?>
                    </tfoot>
                </table>

                <!-- /.card-body -->
              </div>

            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>

            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>

      <!-- Modal 3 -->
      <div class="modal fade" id="modal-default3">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Jumlah Pendapatan</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="card">

                <!-- /.card-header -->

                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>Nama Pengunjung</th>
                      <th>Jumlah Orang Berkunjung</th>
                      <th>Metode Transaksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($data_pengunjung as $pengunjung): ?>
                      <tr>
                        <td><?= htmlspecialchars(strval($pengunjung['nama_pengunjung'] ?? '')); ?></td>
                        <td><?= htmlspecialchars(strval($pengunjung['jumlah_pengunjung'] ?? '')); ?></td>
                        <td><?= htmlspecialchars(strval($pengunjung['metode_transaksi'] ?? '')); ?></td>
                      </tr>
                    <?php endforeach; ?>X`
                  </tbody>
                </table>

                <!-- /.card-body -->
              </div>

            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>

            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>

      <!-- Modal 4 -->
      <div class="modal fade" id="modal-default4">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Data Harga Museum</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="card">

                <!-- /.card-header -->

                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>Harga Awal</th>
                      <th>Harga Update</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($money_data as $money): ?>
                      <tr>
                        <td>Rp. <?= number_format($money['harga_awal'], 0, ',', '.'); ?></td>
                        <td>Rp. <?= number_format($money['harga_update'], 0, ',', '.'); ?></td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>

                <!-- /.card-body -->
              </div>

            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>

            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>



    </div>
    <!-- /.content-wrapper -->


    <?php
    include 'footer.php';
    ?>

    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>

    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->

  <!-- jQuery -->
  <script src="../assets/plugins/jquery/jquery.min.js"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="../assets/plugins/jquery-ui/jquery-ui.min.js"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button)
  </script>
  <!-- Bootstrap 4 -->
  <script src="../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- ChartJS -->
  <script src="../assets/plugins/chart.js/Chart.min.js"></script>
  <!-- Sparkline -->
  <script src="../assets/plugins/sparklines/sparkline.js"></script>
  <!-- JQVMap -->
  <script src="../assets/plugins/jqvmap/jquery.vmap.min.js"></script>
  <script src="../assets/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
  <!-- jQuery Knob Chart -->
  <script src="../assets/plugins/jquery-knob/jquery.knob.min.js"></script>
  <!-- daterangepicker -->
  <script src="../assets/plugins/moment/moment.min.js"></script>
  <script src="../assets/plugins/daterangepicker/daterangepicker.js"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src="../assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
  <!-- Summernote -->
  <script src="../assets/plugins/summernote/summernote-bs4.min.js"></script>
  <!-- overlayScrollbars -->
  <script src="../assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <!-- AdminLTE App -->
  <!-- AdminLTE App -->
  <script src="../assets/dist/js/adminlte.js"></script>
  <script src="../assets/dist/js/adminlte.min.js"></script>
  <!-- AdminLTE for demo purposes -->

  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <script src="../assets/dist/js/pages/dashboard.js"></script>
  <script>
    $(function() {
      /* ChartJS
       * -------
       * Here we will create a few charts using ChartJS
       */

      //--------------
      //- AREA CHART -
      //--------------

      // Get context with jQuery - using jQuery's .get() method.
      var areaChartCanvas = $('#areaChart').get(0).getContext('2d')

      var areaChartData = {
        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
        datasets: [{
            label: 'Digital Goods',
            backgroundColor: 'rgba(60,141,188,0.9)',
            borderColor: 'rgba(60,141,188,0.8)',
            pointRadius: false,
            pointColor: '#3b8bba',
            pointStrokeColor: 'rgba(60,141,188,1)',
            pointHighlightFill: '#fff',
            pointHighlightStroke: 'rgba(60,141,188,1)',
            data: [28, 48, 40, 19, 86, 27, 90]
          },
          {
            label: 'Electronics',
            backgroundColor: 'rgba(210, 214, 222, 1)',
            borderColor: 'rgba(210, 214, 222, 1)',
            pointRadius: false,
            pointColor: 'rgba(210, 214, 222, 1)',
            pointStrokeColor: '#c1c7d1',
            pointHighlightFill: '#fff',
            pointHighlightStroke: 'rgba(220,220,220,1)',
            data: [65, 59, 80, 81, 56, 55, 40]
          },
        ]
      }

      var areaChartOptions = {
        maintainAspectRatio: false,
        responsive: true,
        legend: {
          display: false
        },
        scales: {
          xAxes: [{
            gridLines: {
              display: false,
            }
          }],
          yAxes: [{
            gridLines: {
              display: false,
            }
          }]
        }
      }

      // This will get the first returned node in the jQuery collection.
      new Chart(areaChartCanvas, {
        type: 'line',
        data: areaChartData,
        options: areaChartOptions
      })

      //-------------
      //- LINE CHART -
      //--------------
      var lineChartCanvas = $('#lineChart').get(0).getContext('2d')
      var lineChartOptions = $.extend(true, {}, areaChartOptions)
      var lineChartData = $.extend(true, {}, areaChartData)
      lineChartData.datasets[0].fill = false;
      lineChartData.datasets[1].fill = false;
      lineChartOptions.datasetFill = false

      var lineChart = new Chart(lineChartCanvas, {
        type: 'line',
        data: lineChartData,
        options: lineChartOptions
      })

      //-------------
      //- DONUT CHART -
      //-------------
      // Get context with jQuery - using jQuery's .get() method.
      var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
      var donutData = {
        labels: [
          'Chrome',
          'IE',
          'FireFox',
          'Safari',
          'Opera',
          'Navigator',
        ],
        datasets: [{
          data: [700, 500, 400, 600, 300, 100],
          backgroundColor: ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
        }]
      }
      var donutOptions = {
        maintainAspectRatio: false,
        responsive: true,
      }
      //Create pie or douhnut chart
      // You can switch between pie and douhnut using the method below.
      new Chart(donutChartCanvas, {
        type: 'doughnut',
        data: donutData,
        options: donutOptions
      })

      //-------------
      //- PIE CHART -
      //-------------
      // Get context with jQuery - using jQuery's .get() method.
      var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
      var pieData = donutData;
      var pieOptions = {
        maintainAspectRatio: false,
        responsive: true,
      }
      //Create pie or douhnut chart
      // You can switch between pie and douhnut using the method below.
      new Chart(pieChartCanvas, {
        type: 'pie',
        data: pieData,
        options: pieOptions
      })

      //-------------
      //- BAR CHART -
      //-------------
      var barChartCanvas = $('#barChart').get(0).getContext('2d')
      var barChartData = $.extend(true, {}, areaChartData)
      var temp0 = areaChartData.datasets[0]
      var temp1 = areaChartData.datasets[1]
      barChartData.datasets[0] = temp1
      barChartData.datasets[1] = temp0

      var barChartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        datasetFill: false
      }

      new Chart(barChartCanvas, {
        type: 'bar',
        data: barChartData,
        options: barChartOptions
      })

      //---------------------
      //- STACKED BAR CHART -
      //---------------------
      var stackedBarChartCanvas = $('#stackedBarChart').get(0).getContext('2d')
      var stackedBarChartData = $.extend(true, {}, barChartData)

      var stackedBarChartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          xAxes: [{
            stacked: true,
          }],
          yAxes: [{
            stacked: true
          }]
        }
      }

      new Chart(stackedBarChartCanvas, {
        type: 'bar',
        data: stackedBarChartData,
        options: stackedBarChartOptions
      })
    })
  </script>
</body>

</html>