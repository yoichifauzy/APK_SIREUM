<?php
session_start();
// Koneksi ke database
require '../config/database.php';

// Query untuk mendapatkan jumlah operator
$query_operator = "SELECT COUNT(id_operator) AS jumlah_operator FROM operator";
$result_operator = mysqli_query($koneksi, $query_operator);
$row_operator = mysqli_fetch_assoc($result_operator);
$jumlah_operator = $row_operator['jumlah_operator'];

// Query untuk mendapatkan jumlah kontak us
$query_kontak = "SELECT COUNT(id_kontak) AS jumlah_kontak FROM kontak";
$result_kontak = mysqli_query($koneksi, $query_kontak);
$row_kontak = mysqli_fetch_assoc($result_kontak);
$jumlah_kontak = $row_kontak['jumlah_kontak'];

// Query untuk mendapatkan jumlah tiket (total transaksi)
$query_total_tiket = "SELECT COUNT(id_transaksi) AS total_tiket FROM transaksi";
$result_total_tiket = mysqli_query($koneksi, $query_total_tiket);
$row_total_tiket = mysqli_fetch_assoc($result_total_tiket);
$total_tiket = $row_total_tiket['total_tiket'];

// Query untuk mendapatkan jumlah tiket belum dikonfirmasi
$query_tiket_belum = "SELECT COUNT(id_transaksi) AS tiket_belum FROM transaksi WHERE status_tiket = 0";
$result_tiket_belum = mysqli_query($koneksi, $query_tiket_belum);
$row_tiket_belum = mysqli_fetch_assoc($result_tiket_belum);
$tiket_belum = $row_tiket_belum['tiket_belum'];

// Query untuk mendapatkan jumlah tiket sudah dikonfirmasi
$query_tiket_sudah = "SELECT COUNT(id_transaksi) AS tiket_sudah FROM transaksi WHERE status_tiket = 1";
$result_tiket_sudah = mysqli_query($koneksi, $query_tiket_sudah);
$row_tiket_sudah = mysqli_fetch_assoc($result_tiket_sudah);
$tiket_sudah = $row_tiket_sudah['tiket_sudah'];

// Query untuk mendapatkan jumlah uang
$query_uang = "SELECT SUM(uang_transaksi) AS total_uang FROM transaksi";
$result_uang = mysqli_query($koneksi, $query_uang);
$row_uang = mysqli_fetch_assoc($result_uang);
$total_uang = $row_uang['total_uang'];
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Manajemen Laporan</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../assets/plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="../assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="../assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../assets/dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <?php
    include 'navbar.php';

    ?>
    <!-- /.navbar -->

    <?php
    include 'sidebar.php';

    ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">
                <span class="badge badge-dark"><i class="fa-solid fa-chart-column"></i>&nbsp;Manajemen Laporan</span>
            </div>
            <div class="col-sm-6">

            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">


              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Manajemen Data Laporan</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead class="thead-dark">
                      <tr>
                        <th rowspan="2" style="text-align: center; vertical-align: middle;">Jumlah Operator</th>
                        <th rowspan="2" style="text-align: center; vertical-align: middle;">Jumlah Kontak Us</th>
                        <th colspan="3" style="text-align: center; vertical-align: middle;">Jumlah Ticket</th> <!-- Gabungkan 3 kolom -->
                        <th rowspan="2" style="text-align: center; vertical-align: middle;">Jumlah Uang</th>
                      </tr>
                      <tr>
                        <th style="text-align: center;">Total Tiket</th>
                        <th style="text-align: center;">Belum Dikonfirmasi</th>
                        <th style="text-align: center;">Sudah Dikonfirmasi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td style="text-align: left;"><?php echo htmlspecialchars($jumlah_operator); ?></td>
                        <td style="text-align: left;"><?php echo htmlspecialchars($jumlah_kontak); ?></td>
                        <td style="text-align: left;"><?php echo htmlspecialchars($total_tiket); ?></td>
                        <td style="text-align: left;"><?php echo htmlspecialchars($tiket_belum); ?></td>
                        <td style="text-align: left;"><?php echo htmlspecialchars($tiket_sudah); ?></td>
                        <td style="text-align: center;"><?php echo "Rp. " . number_format($total_uang, 0, ',', '.'); ?></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <?php
    include 'footer.php';
    ?>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->

  <!-- jQuery -->
  <script src="../assets/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- DataTables  & Plugins -->
  <script src="../assets/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="../assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="../assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="../assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="../assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
  <script src="../assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
  <script src="../assets/plugins/jszip/jszip.min.js"></script>
  <script src="../assets/plugins/pdfmake/pdfmake.min.js"></script>
  <script src="../assets/plugins/pdfmake/vfs_fonts.js"></script>
  <script src="../assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
  <script src="../assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
  <script src="../assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
  <!-- AdminLTE App -->
  <script src="../assets/dist/js/adminlte.js"></script>
  <script src="../assets/dist/js/adminlte.min.js"></script>
  <!-- AdminLTE for demo purposes -->

  <!-- Page specific script -->
  <script>
    $(function() {
      $("#example1").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
      $('#example2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
      });
    });
  </script>
</body>

</html>