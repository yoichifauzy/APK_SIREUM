<?php
session_start();
require '../config/database.php';

// Jika form dikirimkan
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_harga'])) {
    $harga_awal = $_POST['harga_awal'];
    $harga_update = $_POST['harga_update'];

    // Periksa apakah input kosong
    if (empty($harga_awal) || empty($harga_update)) {
        echo "<script>alert('Harga tidak boleh kosong.');</script>";
    } else {
        // Query untuk memperbarui data di tabel money
        $query_update_harga = "
            UPDATE money 
            SET harga_awal = '$harga_awal', harga_update = '$harga_update'
            WHERE id_money = 1
        ";

        if (mysqli_query($koneksi, $query_update_harga)) {
            echo "<script>alert('Harga berhasil diperbarui!');</script>";
        } else {
            die("Error: " . mysqli_error($koneksi));
        }
    }
}

// Ambil data harga saat ini untuk ditampilkan di input
$query_current_harga = "SELECT harga_awal, harga_update FROM money WHERE id_money = 1";
$result_current_harga = mysqli_query($koneksi, $query_current_harga);

// Periksa apakah query berhasil
if ($result_current_harga && mysqli_num_rows($result_current_harga) > 0) {
    $current_harga = mysqli_fetch_assoc($result_current_harga);
    $harga_awal = htmlspecialchars($current_harga['harga_awal']);
    $harga_update = htmlspecialchars($current_harga['harga_update']);
} else {
    // Default nilai jika data tidak ditemukan
    $harga_awal = "";
    $harga_update = "";
    echo "<script>alert('Data harga tidak ditemukan. Pastikan data tersedia di tabel money.');</script>";
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Manajemen Harga</title>

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
          <span class="badge badge-dark"><i class="fa-solid fa-comments-dollar"></i>&nbsp;Manajemen Harga</span>
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
                        <h3 class="card-title">Manajemen Data Harga</h3>
                    </div>
                    <div class="card-body">
                        <div class="text-center mt-3">
                            <!-- Tombol untuk membuka modal -->
                            <a class="btn btn-app bg-gradient-danger d-inline-block shadow rounded-pill" style="width: auto; padding: 10px 20px;" data-toggle="modal" data-target="#modal-default">
                                <i class="fa-solid fa-circle-dollar-to-slot fa-beat fa-2x text-light"></i><br>
                                <span class="font-weight-bold text-light" style="font-size: 1rem;">Update Harga</span>
                            </a>
                        </div>

                        <!-- Tabel Data Harga -->
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Nama Operator</th>
                                    <th>Harga Awal</th>
                                    <th>Harga Update</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                    // Query untuk mengambil data dari tabel money dan tabel operator
                                    $query = "
                                            SELECT operator.nama_operator, money.harga_awal, money.harga_update 
                                            FROM money
                                            JOIN operator ON money.id_operator = operator.id_operator
                                        ";
                                        $result = mysqli_query($koneksi, $query);

                                        if ($result && mysqli_num_rows($result) > 0) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo "<tr>";
                                                echo "<td>" . htmlspecialchars($row['nama_operator']) . "</td>";
                                                echo "<td>" . htmlspecialchars($row['harga_awal']) . "</td>";
                                                echo "<td>" . htmlspecialchars($row['harga_update']) . "</td>";
                                                echo "</tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='3' class='text-center'>Tidak ada data tersedia</td></tr>";
                                        }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

    <!-- Modal Form untuk Update Harga -->
<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Manajemen Harga Tiket Museum</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="">
                <div class="modal-body">
                <?php
                    // Ambil data harga saat ini berdasarkan operator
                    $query_current_harga = "
                        SELECT harga_awal, harga_update 
                        FROM money 
                        WHERE id_money = 1
                    ";
                    $result_current_harga = mysqli_query($koneksi, $query_current_harga);

                    // Periksa apakah data tersedia
                    if ($result_current_harga && mysqli_num_rows($result_current_harga) > 0) {
                        $current_harga = mysqli_fetch_assoc($result_current_harga);
                        $harga_awal = htmlspecialchars($current_harga['harga_awal']);
                        $harga_update = htmlspecialchars($current_harga['harga_update']);
                    } else {
                        // Default nilai jika data tidak ditemukan
                        $harga_awal = "";
                        $harga_update = "";
                        echo "<script>alert('Data harga tidak ditemukan. Pastikan data tersedia di tabel money.');</script>";
                    }
                    ?>

                    <label for="harga_awal">Harga Awal:</label>
                    <input class="form-control form-control-lg" type="text" name="harga_awal" id="harga_awal" value="<?= $harga_awal ?>" placeholder="Masukkan Harga Awal" required>
                    <br>
                    <label for="harga_update">Harga Update:</label>
                    <input class="form-control form-control-lg" type="text" name="harga_update" id="harga_update" value="<?= $harga_update ?>" placeholder="Masukkan Harga Update" required>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Batal</button>
                    <button type="submit" name="update_harga" class="btn btn-dark">Simpan Harga</button>
                </div>
            </form>
        </div>
    </div>
</div>


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

<script src="../assets/dist/js/adminlte.js"></script>
<script src="../assets/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->

<!-- Page specific script -->

<script>
    document.querySelector('form').addEventListener('submit', function (e) {
    const hargaAwal = document.getElementById('harga_awal').value;
    const hargaUpdate = document.getElementById('harga_update').value;

    if (!hargaAwal || !hargaUpdate) {
        alert('Harga tidak boleh kosong.');
        e.preventDefault(); // Cegah pengiriman form
    }
});

</script>
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
