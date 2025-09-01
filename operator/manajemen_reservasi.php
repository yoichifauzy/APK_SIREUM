<?php

session_start();
require '../config/database.php';
if (!isset($_SESSION['nama_operator'])) {
    header("Location: manajemen_reservasi.php");
    exit();
}
$nama_operator = $_SESSION['nama_operator'];
try {
    // Jika ada aksi POST, proses pembaruan status
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id_reservasi = $_POST['id_reservasi'];
        $aksi = $_POST['aksi']; // 'konfirmasi' atau 'batalkan'
        $id_operator = $_SESSION['id_operator']; // Ambil ID operator dari sessio
    
        if ($aksi === 'konfirmasi') {
            // Update status menjadi Dikonfirmasi
            $sql_update = "UPDATE reservasi SET status_reservasi = 'Dikonfirmasi', id_operator = ? WHERE id_reservasi = ?";
        } elseif ($aksi === 'batalkan') {
            // Update status menjadi Dibatalkan
            $sql_update = "UPDATE reservasi SET status_reservasi = 'Dibatalkan', id_operator = ? WHERE id_reservasi = ?";
        } else {
            throw new Exception("Aksi tidak valid.");
        }
    
        // Siapkan dan eksekusi query
        $stmt = $koneksi->prepare($sql_update);
        $stmt->bind_param('ii', $id_operator, $id_reservasi); // Gunakan id_operator
        if ($stmt->execute()) {
            $_SESSION['pesan'] = "Status reservasi berhasil diperbarui oleh operator.";
        } else {
            throw new Exception("Gagal memperbarui status reservasi.");
        }
    
        $stmt->close();
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
    


    // Query untuk mengambil data reservasi dengan nama operator
    $sql = "SELECT 
            r.id_reservasi, 
            p.nama_pengunjung AS nama_pengunjung, 
            r.nomor_reservasi, 
            r.tanggal_reservasi, 
            r.jam_kunjungan, 
            r.jumlah_pengunjung, 
            r.tanggal_pemesanan, 
            o.nama_operator, 
            r.status_reservasi 
        FROM reservasi r
        JOIN pengunjung p ON r.id_pengunjung = p.id_pengunjung
        LEFT JOIN operator o ON r.id_operator = o.id_operator"; // Mengambil nama_operator

    $result = $koneksi->query($sql);

    if (!$result) {
        throw new Exception("Query Error: " . $koneksi->error);
    }
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Manajemen_Reservasi</title>

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

    <!-- Navbar -->
    <?php
        include 'navbar.php';

    ?>
  <!-- /.navbar -->
  <?php
        include 'sidebar.php';

    ?>
  <!-- Main Sidebar Container -->>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          <h1 class="m-0">
          <span class="badge badge-dark"><i class="fa-solid fa-receipt"></i>&nbsp;Manajemen Reservasi</span>
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
                        <h3 class="card-title">Manajemen Data Reservasi</h3>
                    </div>
                    <!-- Notifikasi Pesan -->
                    <div class="card-body">
                    <?php
                        if (isset($_SESSION['pesan'])) {
                            echo "<div class='alert alert-info' id='pesan'>" . $_SESSION['pesan'] . "</div>";
                            unset($_SESSION['pesan']); // Hapus pesan setelah ditampilkan
                        }
                    ?>

                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Nama Pengunjung</th>
                                        <th>No. Reservasi</th>
                                        <th>Tgl. Reservasi</th>
                                        <th>Jam Kunjungan</th>
                                        <th>Jumlah Pengunjung</th>
                                        <th>Tgl. Pemesanan</th>
                                        <th>Nama Operator</th>
                                        <th>Status Reservasi</th>
                                        <th>AKSI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<tr>";
                                            echo "<td>" . $row['nama_pengunjung'] . "</td>";
                                            echo "<td>" . $row['nomor_reservasi'] . "</td>";
                                            echo "<td>" . $row['tanggal_reservasi'] . "</td>";
                                            echo "<td>" . $row['jam_kunjungan'] . "</td>";
                                            echo "<td>" . $row['jumlah_pengunjung'] . "</td>";
                                            echo "<td>" . $row['tanggal_pemesanan'] . "</td>";
                                            echo "<td>" . ($row['nama_operator'] ?? 'Belum Ditentukan') . "</td>";
                                            echo "<td>" . $row['status_reservasi'] . "</td>";

                                          // Tombol Konfirmasi dan Batalkan
echo "<td>";
echo "<form method='POST' action=''>";

echo "<input type='hidden' name='id_reservasi' value='" . $row['id_reservasi'] . "'>";
echo "<input type='hidden' name='nama_operator' value='" . htmlspecialchars($nama_operator) . "'>";  // Menambahkan nama_operator dalam form
echo "<div class='btn-group' role='group' aria-label='Aksi'>";

// Tombol Konfirmasi
$disabled_konfirmasi = ($row['status_reservasi'] === 'Dikonfirmasi') ? 'disabled' : '';
echo "<button type='submit' name='aksi' value='konfirmasi' class='btn btn-success btn-sm' $disabled_konfirmasi style='margin-right: 5px;'>Konfirmasi</button>";

// Tombol Batalkan
$disabled_batalkan = ($row['status_reservasi'] === 'Dibatalkan') ? 'disabled' : '';
echo "<button type='submit' name='aksi' value='batalkan' class='btn btn-danger btn-sm' $disabled_batalkan>Batalkan</button>";

echo "</div>";
echo "</form>";
echo "</td>";


                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='9'>Tidak ada data.</td></tr>";
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
    </div>
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

<script>
    // Setelah 10 detik (10000 ms), sembunyikan elemen dengan id 'pesan'
    setTimeout(function() {
        var pesan = document.getElementById('pesan');
        if (pesan) {
            pesan.style.display = 'none';
        }
    }, 10000); // 10000 ms = 10 detik
</script>

</body>
</html>
