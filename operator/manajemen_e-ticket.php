<?php
session_start();
require '../config/database.php';

// Periksa apakah tombol konfirmasi ditekan
if (isset($_POST['konfirmasi'])) {
  $id_transaksi = intval($_POST['id_transaksi']);
  
  // Cek status tiket
  $query_check = "SELECT status_tiket FROM transaksi WHERE id_transaksi = ?";
  $stmt_check = $koneksi->prepare($query_check);
  $stmt_check->bind_param("i", $id_transaksi);
  $stmt_check->execute();
  $stmt_check->bind_result($status_tiket);
  $stmt_check->fetch();
  $stmt_check->close();

  if ($status_tiket == 1) {
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
          <script>
              Swal.fire({
                  icon: 'info',
                  title: 'Sudah Dikonfirmasi!',
                  text: 'Tiket ini sudah dikonfirmasi sebelumnya.',
                  confirmButtonText: 'OK'
              });
          </script>";
  } else {
      // Update status tiket
      $query_update = "UPDATE transaksi SET status_tiket = 1 WHERE id_transaksi = ?";
      $stmt = $koneksi->prepare($query_update);
      $stmt->bind_param("i", $id_transaksi);

      if ($stmt->execute()) {
        ?>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <body></body>
        <script>
            Swal.fire({
                title: 'Sukses!',
                text: 'Tiket berhasil dikonfirmasi!!',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.href = 'manajemen_e-ticket.php';
            });
        </script>
        <?php
        exit(); // Menghentikan eksekusi PHP
      } else {
        ?>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <body></body>
        <script>
            Swal.fire({
                title: 'Gagal!',
                text: 'Gagal mengkonfirmasi tiket!',
                icon: 'Error',
                confirmButtonText: 'OK'
            }).then(() => {
                history.back(); // Kembali ke halaman 
            });
        </script>
        <?php
        exit(); // Menghentikan eksekusi PHP
      }
      $stmt->close();
  }
}


// Query untuk mengambil data dari database
$query = "
    SELECT 
        p.nama_pengunjung,
        p.nomor_telepon_pengunjung,
        r.tanggal_reservasi,
        r.jam_kunjungan,
        r.jumlah_pengunjung,
        r.nomor_reservasi,
        r.status_reservasi,
        t.id_transaksi,
        t.nomor_transaksi,
        t.metode_transaksi,
        t.uang_transaksi,
        t.status_transaksi,
        t.status_tiket
    FROM pengunjung p
    JOIN reservasi r ON p.id_pengunjung = r.id_pengunjung
    JOIN transaksi t ON r.id_reservasi = t.id_reservasi
";

$result = mysqli_query($koneksi, $query);

// Periksa apakah query berhasil
if (!$result) {
    die("Query Error: " . mysqli_error($koneksi));
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Manajemen E-Ticket</title>

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
  <!-- Theme style -->
  <link rel="stylesheet" href="../assets/dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="../assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="../assets/plugins/daterangepicker/daterangepicker.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="../assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="../assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
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
          <span class="badge badge-dark"><i class="fa-solid fa-money-bill-trend-up"></i>&nbsp;Manajemen Tiket</span>
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
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Manajemen Data E-Ticket</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th>Nama Pengunjung</th>
                                <th>Tanggal Kunjungan</th>
                                <th>Jam Kunjungan</th>
                                <th>Jumlah Pengunjung</th>
                                <th>No. Telp Pengunjung</th>
                                <th>Nomor Reservasi</th>
                                <th>Nomor Transaksi</th>
                                <th>Metode Transaksi</th>
                                <th>Uang Transaksi</th>
                                <th>Status Reservasi</th>
                                <th>Status Transaksi</th>
                                <th>Status Tiket</th>
                                <th>Konfirmasi Tiket</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['nama_pengunjung']); ?></td>
                                    <td><?= htmlspecialchars($row['tanggal_reservasi']); ?></td>
                                    <td><?= htmlspecialchars($row['jam_kunjungan']); ?></td>
                                    <td><?= htmlspecialchars($row['jumlah_pengunjung']); ?></td>
                                    <td><?= htmlspecialchars($row['nomor_telepon_pengunjung']); ?></td>
                                    <td><?= htmlspecialchars($row['nomor_reservasi']); ?></td>
                                    <td><?= htmlspecialchars($row['nomor_transaksi']); ?></td>
                                    <td><?= htmlspecialchars($row['metode_transaksi']); ?></td>
                                    <td><?= htmlspecialchars($row['uang_transaksi']); ?></td>
                                    <td>
                                        <span class="badge <?= $row['status_reservasi'] == 'Confirmed' ? 'badge-success' : 'badge-warning'; ?>">
                                            <?= htmlspecialchars($row['status_reservasi']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge <?= $row['status_transaksi'] == 'Completed' ? 'badge-success' : 'badge-danger'; ?>">
                                            <?= htmlspecialchars($row['status_transaksi']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php if ($row['status_tiket'] == 1): ?>
                                            <span class="badge badge-success">Tiket Sudah Dikonfirmasi</span>
                                        <?php else: ?>
                                            <span class="badge badge-warning">Tiket Belum Dikonfirmasi</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <?php if ($row['status_tiket'] == 1): ?>
                                                <button class="btn btn-success btn-sm" disabled>
                                                    <i class="fas fa-check"></i> Sudah Dikonfirmasi
                                                </button>
                                            <?php else: ?>
                                                <form method="POST" style="display: inline;">
                                                    <input type="hidden" name="id_transaksi" value="<?= htmlspecialchars($row['id_transaksi']) ?>">
                                                    <button type="submit" name="konfirmasi" class="btn btn-primary btn-sm">
                                                        <i class="fas fa-check-circle"></i> Konfirmasi
                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

          
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
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
<script src="../assets/dist/js/adminlte.js"></script>
<script src="../assets/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->

<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="../assets/dist/js/pages/dashboard.js"></script>

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

