<?php
 session_start();
 // Pastikan sudah ada koneksi database
require '../config/database.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Manajemen Pengunjung</title>

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
          <span class="badge badge-dark"><i class="fa-solid fa-person-rays"></i>&nbsp;Manajemen Pengunjung</span>
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

                    <!-- ISI KONTEN -->
                    <div class="card">
              <div class="card-header">
                <h3 class="card-title">Manajemen Data Pengunjung</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>Nomor Identitas</th>
                    <th>Nama</th>
                    <th>Tanggal Lahir </th>
                    <th>Jenis Kelamin</th>
                    <th>Kewarganegaran</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                  </tr>
                  </thead>
                  <tbody>
                                <?php
if (isset($_POST['hapus_pengunjung'])) {
    if (isset($_POST['id_pengunjung']) && is_numeric($_POST['id_pengunjung'])) {
        $id_pengunjung = intval($_POST['id_pengunjung']); // Pastikan ID adalah integer

        // Mulai transaksi
        mysqli_begin_transaction($koneksi);

        try {
            // Cek apakah ada data terkait di tabel reservasi
            $query_check = "SELECT COUNT(*) AS count FROM reservasi WHERE id_pengunjung = $id_pengunjung";
            $result_check = mysqli_query($koneksi, $query_check);

            if (!$result_check) {
                throw new Exception("Error checking reservasi: " . mysqli_error($koneksi));
            }

            $row_check = mysqli_fetch_assoc($result_check);

            if ($row_check['count'] > 0) {
                // Hapus data terkait di tabel reservasi
                $query_delete_reservasi = "DELETE FROM reservasi WHERE id_pengunjung = $id_pengunjung";
                if (!mysqli_query($koneksi, $query_delete_reservasi)) {
                    throw new Exception("Error deleting reservasi: " . mysqli_error($koneksi));
                }
            }

            // Hapus data terkait di tabel transaksi
            $query_delete_transaksi = "DELETE FROM transaksi WHERE id_reservasi IN (SELECT id_reservasi FROM reservasi WHERE id_pengunjung = $id_pengunjung)";
            if (!mysqli_query($koneksi, $query_delete_transaksi)) {
                throw new Exception("Error deleting transaksi: " . mysqli_error($koneksi));
            }

            // Hapus data pengunjung
            $query_delete_pengunjung = "DELETE FROM pengunjung WHERE id_pengunjung = $id_pengunjung";
            if (!mysqli_query($koneksi, $query_delete_pengunjung)) {
                throw new Exception("Error deleting pengunjung: " . mysqli_error($koneksi));
            }

            // Commit transaksi
            mysqli_commit($koneksi);

            ?>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <body></body>
            <script>
                Swal.fire({
                    title: 'Sukses!',
                    text: 'Hapus pengunjung berhasil!',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.href = 'manajemen_pengunjung.php';
                });
            </script>
            <?php
        } catch (Exception $e) {
            // Rollback transaksi jika terjadi error
            mysqli_rollback($koneksi);

            error_log("Error: " . $e->getMessage()); // Catat error di log server

            ?>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <body></body>
            <script>
                Swal.fire({
                    title: 'Gagal!',
                    text: 'Terjadi kesalahan saat menghapus data pengunjung: <?= addslashes($e->getMessage()); ?>',
                    icon: 'error',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.href = 'manajemen_pengunjung.php';
                });
            </script>
            <?php
            exit(); // Hentikan eksekusi PHP setelah menampilkan pesan error
        }
    }
}

// Query untuk menampilkan data pengunjung
$query = "SELECT 
            p.id_pengunjung, 
            p.nomor_identitas_pengunjung, 
            p.nama_pengunjung, 
            p.tanggal_lahir_pengunjung, 
            p.jenis_kelamin_pengunjung, 
            n.nama_negara AS kewarganegaraan,
            p.alamat_pengunjung
          FROM 
            pengunjung p
          INNER JOIN 
            negara n
          ON 
            p.kewarganegaraan = n.id_negara";

$result = mysqli_query($koneksi, $query);

if (mysqli_num_rows($result) > 0) {
    $no = 1;
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $no++ . "</td>";
        echo "<td>" . $row['nomor_identitas_pengunjung'] . "</td>";
        echo "<td>" . $row['nama_pengunjung'] . "</td>";
        echo "<td>" . $row['tanggal_lahir_pengunjung'] . "</td>";
        echo "<td>" . $row['jenis_kelamin_pengunjung'] . "</td>";
        echo "<td>" . $row['kewarganegaraan'] . "</td>";
        echo "<td>" . $row['alamat_pengunjung'] . "</td>";
        echo "<td>
                <button class='btn btn-danger btn-sm' data-toggle='modal' data-target='#modalHapus" . $row['id_pengunjung'] . "'>
                    Hapus
                </button>
              </td>";
        echo "</tr>";

        // Modal Hapus
        echo "<div class='modal fade' id='modalHapus" . $row['id_pengunjung'] . "' tabindex='-1' aria-hidden='true'>
        <div class='modal-dialog'>
          <div class='modal-content'>
            <form method='POST'>
              <div class='modal-header'>
                <h5 class='modal-title'>Hapus Pengunjung</h5>
                <button type='button' class='close' data-dismiss='modal'>&times;</button>
              </div>
              <div class='modal-body'>
                <p>Apakah Anda yakin ingin menghapus pengunjung <strong>" . $row['nama_pengunjung'] . "</strong>?</p>
                <input type='hidden' name='id_pengunjung' value='" . $row['id_pengunjung'] . "'>
              </div>
              <div class='modal-footer'>
                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Batal</button>
                <button type='submit' name='hapus_pengunjung' class='btn btn-danger'>Hapus</button>
              </div>
            </form>
          </div>
        </div>
      </div>";
    }
} else {
    echo "<tr><td colspan='8'>Tidak ada data</td></tr>";
}
?>
                        </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            

        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          <section class="col-lg-7 connectedSortable">
            

            <!-- Kiri -->

           
          </section>
          <!-- /.Left col -->
          <!-- right col (We are only adding the ID to make the widgets sortable)-->
          <section class="col-lg-5 connectedSortable">

          
            <!-- Kanan -->
          

            
          </section>
          <!-- right col -->
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

