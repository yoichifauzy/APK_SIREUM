<?php
// Memulai session
session_start();

// Memasukkan file konfigurasi database
require '../config/database.php';

// Query untuk mengambil data
$sql = "SELECT 
            pengunjung.nama_pengunjung,
            transaksi.nomor_transaksi,
            reservasi.nomor_reservasi,
            transaksi.tanggal_transaksi,
            reservasi.tanggal_reservasi,
            reservasi.status_reservasi,
            transaksi.status_transaksi,
            transaksi.metode_transaksi,
            transaksi.uang_transaksi,
            transaksi.nomor_payment
        FROM transaksi
        LEFT JOIN pengunjung ON transaksi.id_pengunjung = pengunjung.id_pengunjung
        LEFT JOIN reservasi ON transaksi.id_reservasi = reservasi.id_reservasi";

$result = $koneksi->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Manajemen Transaksi</title>

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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="hold-transition sidebar-mini">
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
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          <h1 class="m-0">
          <span class="badge badge-dark"><i class="fa-solid fa-money-bill-trend-up"></i>&nbsp;Manajemen Transaksi</span>
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
                <h3 class="card-title">Manajemen Data Transaksi</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Nama Pengunjung</th>
                    <th>Nomor Transaksi</th>
                    <th>Nomor Reservasi</th>
                    <th>Tanggal Transaksi</th>
                    <th>Tanggal Reservasi</th>
                    <th>Status Reservasi</th>
                    <th>Status Transaksi</th>
                    <th>Metode Transaksi</th>
                    <th>Uang Transaksi</th>
                    <th>Nomor Payment</th>
                  </tr>
                  </thead>
                  <tbody>
                                <?php
                                if ($result && $result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . htmlspecialchars($row['nama_pengunjung']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['nomor_transaksi']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['nomor_reservasi']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['tanggal_transaksi']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['tanggal_reservasi']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['status_reservasi']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['status_transaksi']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['metode_transaksi']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['uang_transaksi']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['nomor_payment']) . "</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='10'>Tidak ada data</td></tr>";
                                }
                                ?>
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
