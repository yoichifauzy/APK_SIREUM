<?php
// Memulai sesi
session_start();

// Memanggil file konfigurasi database
require '../config/database.php';

// Periksa koneksi
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Query untuk mendapatkan data dari tabel
$queryReservasi = "SELECT COUNT(*) AS jumlah_pengunjung FROM reservasi";
$queryKonten = "SELECT SUM(id_konten) AS jumlah_konten FROM konten";
$queryGaleri = "SELECT COUNT(id_foto) AS jumlah_galeri FROM galeri";
$queryMoney = "SELECT harga_update AS harga_update FROM money" ;
$queryTransaksiOnline = "SELECT COUNT(*) AS jumlah_online FROM transaksi WHERE metode_transaksi = 'Online'";
$queryTransaksiCOD = "SELECT COUNT(*) AS jumlah_cod FROM transaksi WHERE metode_transaksi = 'COD'";

// Eksekusi query dan simpan hasilnya
$resultReservasi = $koneksi->query($queryReservasi);
$resultKonten = $koneksi->query($queryKonten);
$resultGaleri = $koneksi->query($queryGaleri);
$resultMoney = $koneksi->query($queryMoney);
$resultTransaksiOnline = $koneksi->query($queryTransaksiOnline);
$resultTransaksiCOD = $koneksi->query($queryTransaksiCOD);

// Ambil data dari hasil query
$jumlahPengunjung = $resultReservasi->fetch_assoc()['jumlah_pengunjung'] ?? 0;
$jumlahKonten = $resultKonten->fetch_assoc()['jumlah_konten'] ?? 0;
$jumlahGaleri = $resultGaleri->fetch_assoc()['jumlah_galeri'] ?? 0;
$hargaUpdate = $resultMoney->fetch_assoc()['harga_update'] ?? 'Rp. 0';
$jumlahOnline = $resultTransaksiOnline->fetch_assoc()['jumlah_online'] ?? 0;
$jumlahCOD = $resultTransaksiCOD->fetch_assoc()['jumlah_cod'] ?? 0;
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

    <?php include 'navbar.php'; ?>
    <?php include 'sidebar.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          <h1 class="m-0">
          <span class="badge badge-dark"><i class="fa-solid fa-folder-open"></i>&nbsp;Manajemen Laporan</span>
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
    <thead>
        <tr>
            <th rowspan="2" style="text-align: center; vertical-align: middle;">Jumlah Pengunjung</th>
            <th rowspan="2" style="text-align: center; vertical-align: middle;">Jumlah Konten</th>
            <th rowspan="2" style="text-align: center; vertical-align: middle;">Jumlah Galeri</th>
            <th rowspan="2" style="text-align: center; vertical-align: middle;">Harga Update</th>
            <th colspan="2" style="text-align: center; vertical-align: middle;">Metode Transaksi</th> <!-- Gabungkan dua kolom -->
        </tr>
        <tr>
            <th style="text-align: center;">Online</th>
            <th style="text-align: center;">Offline</th>
        </tr>
    </thead>
    <tbody>
    <tr>
                    <td style="text-align: left;"><?php echo $jumlahPengunjung; ?></td>
                    <td style="text-align: left;"><?php echo $jumlahKonten; ?></td>
                    <td style="text-align: left;"><?php echo $jumlahGaleri; ?></td>
                    <td style="text-align: left;"><?php echo $hargaUpdate; ?></td>
                    <td style="text-align: left;"><?php echo $jumlahOnline; ?></td>
                    <td style="text-align: left;"><?php echo $jumlahCOD; ?></td>
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

  <?php include 'footer.php'; ?>

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
<!-- AdminLTE App -->
<script src="../assets/dist/js/adminlte.js"></script>
<script src="../assets/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->

<!-- Page specific script -->
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
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
