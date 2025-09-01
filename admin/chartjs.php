<?php
require '../config/database.php';

// Menghitung jumlah data dari masing-masing tabel
$jumlahGaleri = $koneksi->query("SELECT COUNT(id_foto) AS jumlah FROM galeri")->fetch_assoc()['jumlah'];
$jumlahKategori = $koneksi->query("SELECT COUNT(id_kategori) AS jumlah FROM kategori")->fetch_assoc()['jumlah'];
$jumlahKontak = $koneksi->query("SELECT COUNT(id_kontak) AS jumlah FROM kontak")->fetch_assoc()['jumlah'];
$jumlahKonten = $koneksi->query("SELECT COUNT(id_konten) AS jumlah FROM konten")->fetch_assoc()['jumlah'];
$jumlahNegara = $koneksi->query("SELECT COUNT(id_negara) AS jumlah FROM negara")->fetch_assoc()['jumlah'];
$jumlahOperator = $koneksi->query("SELECT COUNT(id_operator) AS jumlah FROM operator")->fetch_assoc()['jumlah'];
$jumlahPengunjung = $koneksi->query("SELECT COUNT(id_pengunjung) AS jumlah FROM pengunjung")->fetch_assoc()['jumlah'];

// Mengambil data dari tabel Money
$hargaAwal = $koneksi->query("SELECT SUM(harga_awal) AS total FROM money")->fetch_assoc()['total'];
$hargaUpdate = $koneksi->query("SELECT SUM(harga_update) AS total FROM money")->fetch_assoc()['total'];

// Menghitung jumlah metode transaksi
$transaksiOnline = $koneksi->query("SELECT COUNT(*) AS total FROM transaksi WHERE metode_transaksi = 'Online'")->fetch_assoc()['total'];
$transaksiCOD = $koneksi->query("SELECT COUNT(*) AS total FROM transaksi WHERE metode_transaksi = 'COD'")->fetch_assoc()['total'];

$koneksi->close();

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | ChartJS</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../assets/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../assets/dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <!-- Navbar -->


    <!-- Content Wrapper. Contains page content -->
    <div class="content">
      <!-- Content Header (Page header) -->


      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-6">

              <!-- DONUT CHART -->
              <div class="card card-danger">
                <div class="card-header">
                  <h3 class="card-title">SIREUM Chart | Jumlah Keseluruhan dari Tugas Manajemen Museum</h3>

                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                      <i class="fas fa-times"></i>
                    </button>
                  </div>
                </div>
                <div class="card-body">
                  <canvas id="donutChart" style="min-height:300px; height:300px; max-height:300px; max-width: 100%;"></canvas>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->



            </div>
            <!-- /.col (LEFT) -->
            <div class="col-md-6">


              <!-- BAR CHART -->
              <div class="card card-success">
                <div class="card-header">
                  <h3 class="card-title">SIREUM Chart | Bagian Tentang Keuangan dan Metode Transaksi</h3>

                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                      <i class="fas fa-times"></i>
                    </button>
                  </div>
                </div>
                <div class="card-body">
                    <div class="row">
                    <div class="col-md-6">
                      <div class="chart">
                      <canvas id="pieChart" style="min-height:300px; height:300px; max-height:300px; max-width: 100%;"></canvas>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="chart">
                      <canvas id="polarChart" style="min-height:300px; height:300px; max-height:300px; max-width: 100%;"></canvas>
                      </div>
                    </div>
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->



            </div>
            <!-- /.col (RIGHT) -->
          </div>
          <!-- /.row -->
        </div><!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->


    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Add Content Here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->

  <!-- jQuery -->
  <script src="../assets/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- ChartJS -->
  <script src="../assets/plugins/chart.js/Chart.min.js"></script>

  <!-- AdminLTE App -->
  <script src="../assets/dist/js/adminlte.js"></script>
  <script src="../assets/dist/js/adminlte.min.js"></script>



  <script>
    // Data dari PHP untuk Donut Chart
    const labelsDonut = ['Jumlah Galeri', 'Jumlah Kategori', 'Jumlah Kontak', 'Jumlah Konten', 'Jumlah Negara', 'Jumlah Operator', 'Jumlah Pengunjung'];
    const dataDonut = [
      <?php echo $jumlahGaleri; ?>,
      <?php echo $jumlahKategori; ?>,
      <?php echo $jumlahKontak; ?>,
      <?php echo $jumlahKonten; ?>,
      <?php echo $jumlahNegara; ?>,
      <?php echo $jumlahOperator; ?>,
      <?php echo $jumlahPengunjung; ?>
    ];

    // Membuat Donut Chart
    const ctxDonut = document.getElementById('donutChart').getContext('2d');
    const donutChart = new Chart(ctxDonut, {
      type: 'doughnut',
      data: {
        labels: labelsDonut,
        datasets: [{
          data: dataDonut,
          backgroundColor: [
            '#f56954', '#00a65a', '#f39c12', '#00c0ef',
            '#3c8dbc', '#d2d6de', '#ff6384'
          ],
          hoverBackgroundColor: [
            '#f56954', '#00a65a', '#f39c12', '#00c0ef',
            '#3c8dbc', '#d2d6de', '#ff6384'
          ]
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            position: 'top',
          }
        }
      }
    });

    // Data dari PHP untuk Pie Chart
    const labelsPie = ['Harga Awal', 'Harga Update'];
    const dataPie = [
      <?php echo $hargaAwal; ?>,
      <?php echo $hargaUpdate; ?>
    ];

    // Membuat Pie Chart
    const ctxPie = document.getElementById('pieChart').getContext('2d');
    const pieChart = new Chart(ctxPie, {
      type: 'pie',
      data: {
        labels: labelsPie,
        datasets: [{
          data: dataPie,
          backgroundColor: ['#f56954', '#00a65a'],
          hoverBackgroundColor: ['#f56954', '#00a65a']
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            position: 'top',
          }
        }
      }
    });

    // Data dari PHP untuk Polar Chart
    const labelsPolar = ['Transaksi Online', 'Transaksi COD'];
    const dataPolar = [
      <?php echo $transaksiOnline; ?>,
      <?php echo $transaksiCOD; ?>
    ];

    // Membuat Polar Chart
    const ctxPolar = document.getElementById('polarChart').getContext('2d');
    const polarChart = new Chart(ctxPolar, {
      type: 'polarArea',
      data: {
        labels: labelsPolar,
        datasets: [{
          data: dataPolar,
          backgroundColor: ['#ff6384', '#36a2eb'],
          hoverBackgroundColor: ['#ff6384', '#36a2eb']
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            position: 'top',
          }
        }
      }
    });
  </script>


</body>

</html>