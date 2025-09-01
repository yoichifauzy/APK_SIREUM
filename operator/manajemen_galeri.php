<?php
session_start();
require '../config/database.php';

if (isset($_POST['tambah_kategori'])) {
    $nama_kategori = htmlspecialchars($_POST['nama_kategori']);
    $id_operator = $_SESSION['id_operator']; // Pastikan session operator tersedia

    $query = "INSERT INTO kategori (nama_kategori, id_operator) VALUES (?, ?)";
    $stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($stmt, 'si', $nama_kategori, $id_operator);

    if (mysqli_stmt_execute($stmt)) {
      ?>
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
      <body></body>
      <script>
          Swal.fire({
              title: 'Sukses!',
              text: 'Kategori berhasil ditambahkan!',
              icon: 'success',
              confirmButtonText: 'OK'
          }).then(() => {
              window.location.href = 'manajemen_galeri.php';
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
              text: 'Gagal menambahkan kategori! " . mysqli_error($koneksi) . "',
              icon: 'error',
              confirmButtonText: 'Coba Lagi'
          }).then(() => {
              history.back(); // Kembali ke halaman
          });
      </script>
      <?php
      exit(); // Menghentikan eksekusi PHP
    }
}

if (isset($_POST['tambah_galeri'])) {
    $id_kategori = $_POST['id_kategori'];
    $id_operator = $_SESSION['id_operator'];
    $foto = $_FILES['foto'];
    $fotoName = time() . '_' . basename($foto['name']);
    $uploadDir = './upload/galeri/';

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $path_foto = $uploadDir . $fotoName;

    if (move_uploaded_file($foto['tmp_name'], $path_foto)) {
        $query = "INSERT INTO galeri (id_kategori, id_operator, foto, path_foto) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($koneksi, $query);
        mysqli_stmt_bind_param($stmt, 'iiss', $id_kategori, $id_operator, $fotoName, $path_foto);

        if (mysqli_stmt_execute($stmt)) {
          ?>
          <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
          <body></body>
          <script>
              Swal.fire({
                  title: 'Sukses!',
                  text: 'Galeri berhasil ditambahkan!',
                  icon: 'success',
                  confirmButtonText: 'OK'
              }).then(() => {
                  window.location.href = 'manajemen_galeri.php';
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
                  text: 'Gagal menambahkan galeri! " . mysqli_error($koneksi) . "',
                  icon: 'error',
                  confirmButtonText: 'Coba Lagi'
              }).then(() => {
                  history.back(); // Kembali ke halaman 
              });
          </script>
          <?php
          exit(); // Menghentikan eksekusi PHP
        }
    } else {
      ?>
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
      <body></body>
      <script>
          Swal.fire({
              title: 'Gagal!',
              text: 'Gagal mengunggah foto! " . mysqli_error($koneksi) . "',
              icon: 'error',
              confirmButtonText: 'Coba Lagi'
          }).then(() => {
              history.back(); // Kembali ke halaman 
          });
      </script>
      <?php
      exit(); // Menghentikan eksekusi PHP
    }
}

// Logika Hapus Galeri
if (isset($_GET['hapus_galeri']) && $_GET['hapus_galeri'] == 1 && isset($_GET['id_foto'])) {
  $id_foto = $_GET['id_foto'];

  // Ambil path foto untuk menghapus file dari server
  $query = "SELECT path_foto FROM galeri WHERE id_foto = ?";
  $stmt = mysqli_prepare($koneksi, $query);
  mysqli_stmt_bind_param($stmt, 'i', $id_foto);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  
  if ($row = mysqli_fetch_assoc($result)) {
      $oldPath = $row['path_foto'];
      if (file_exists($oldPath)) {
          unlink($oldPath);  // Hapus foto dari server
      }
  }

  // Hapus galeri dari database
  $query = "DELETE FROM galeri WHERE id_foto = ?";
  $stmt = mysqli_prepare($koneksi, $query);
  mysqli_stmt_bind_param($stmt, 'i', $id_foto);
  if (mysqli_stmt_execute($stmt)) {
    ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <body></body>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: 'Galeri berhasil dihapus!',
        }).then((result) => {
            if (result.isConfirmed) {
                window.location = 'manajemen_galeri.php';
            }
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
            icon: 'error',
            title: 'Gagal',
            text: 'Gagal menghapus galeri!',
        }).then((result) => {
            if (result.isConfirmed) {
                window.location = 'manajemen_galeri.php';
            }
        });
    </script>
     <?php
          exit(); // Menghentikan eksekusi PHP
}

}




?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Manajemen Galeri</title>

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
  <!-- Main Sidebar Container -->
  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          <h1 class="m-0">
          <span class="badge badge-dark"><i class="fa-solid fa-panorama"></i>&nbsp;Manajemen Galeri</span>
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
            
            <!-- /.card -->

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Manajemen Data Galeri</h3>
              </div>
              <div class="card-body">
                  <button type="button" class="btn btn-outline-dark" data-toggle="modal" data-target="#modal-default">
                  <i class="fa-solid fa-folder-plus fa-lg"></i>&nbsp;Tambah Kategori
                  </button>
                  <button type="button" class="btn btn-info float-right" data-toggle="modal" data-target="#modal-warning">
                  <i class="fa-solid fa-square-plus fa-lg"></i>&nbsp;Tambah Galeri
                </button>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>Kategori Foto</th>
                    <th>Foto</th>
                    <th>Nama Operator</th>
                    <th>nama foto</th>             
                    <th>Aksi</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
$query = "SELECT galeri.*, kategori.nama_kategori, operator.nama_operator 
          FROM galeri 
          JOIN kategori ON galeri.id_kategori = kategori.id_kategori 
          JOIN operator ON galeri.id_operator = operator.id_operator";
$result = mysqli_query($koneksi, $query);
$no = 1;

while ($row = mysqli_fetch_assoc($result)) {
    ?>
    <tr>
        <td><?= $no++ ?></td>
        <td><?= $row['nama_kategori'] ?></td>
        <td><img src="./upload/galeri/<?= $row['foto'] ?>" width="100" height="50"></td>
        <td><?= $row['nama_operator'] ?></td>
        <td><?= $row['foto'] ?></td> <!-- Menampilkan Nama Foto -->
        <td>
        
       
            <!-- Tombol Hapus -->
            <a href="manajemen_galeri.php?hapus_galeri=1&id_foto=<?= $row['id_foto']; ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus galeri ini?')">
                <i class="fa-solid fa-trash"></i> Hapus
            </a>

            <!-- Tombol Lihat -->
            <a class="btn btn-primary" 
               data-toggle="modal" 
               data-target="#modal-xl" 
               data-foto="./upload/galeri/<?= $row['foto']; ?>" 
               data-kategori="<?= $row['nama_kategori']; ?>">
               <i class="fa-solid fa-face-rolling-eyes"></i> Lihat
            </a>
        </td>
    </tr>
    <?php
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

    <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
          <div class="modal-content">
          <form action="" method="POST">
            <div class="modal-header">
              <h4 class="modal-title">Tambah Kategori</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                    <div class="form-group">
                        <label for="nama_kategori">Nama Kategori</label>
                        <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" required>
                    </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
              <button type="submit" name="tambah_kategori" class="btn btn-primary">Simpan</button>
            </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div> 
        <!-- /.modal-dialog -->
      </div>

      <div class="modal fade" id="modal-warning">
        <div class="modal-dialog">
          <div class="modal-content bg-warning">
          <form action="" method="POST" enctype="multipart/form-data">
            <div class="modal-header">
              <h4 class="modal-title">Tambah Galeri</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="form-group">
                          <label for="id_kategori">Kategori</label>
                          <select name="id_kategori" id="id_kategori" class="form-control" required>
                              <option value="" disabled selected>Pilih Kategori</option>
                              <?php
                              $query = "SELECT * FROM kategori";
                              $result = mysqli_query($koneksi, $query);
                              while ($row = mysqli_fetch_assoc($result)) {
                                  echo "<option value='" . $row['id_kategori'] . "'>" . $row['nama_kategori'] . "</option>";
                              }
                              ?>
                          </select>
                      </div>
                      <div class="form-group">
                        <label for="foto">Upload Foto</label>
                        <input type="file" class="form-control" id="foto" name="foto" required>
                    </div>
              </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Tutup</button>
              <button type="submit" name="tambah_galeri" class="btn btn-dark">Simpan Kategori</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      

      

      <!--Modal Lihat -->
      <div class="modal fade" id="modal-xl">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title" id="kategoriFoto"></h4>


              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body" style=" text-align: center;">
              <img id="fotoGaleri" src="" alt="Foto Galeri" style="max-width: 100%; height: auto;"> <!-- Gambar -->
           </div>

            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
              
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

  </div>
  <!-- /.content-wrapper -->
  
    <?php
        include 'footer.php';
    ?>
    <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  
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
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["colvis"]
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
$(document).on('click', '[data-toggle="modal"]', function () {
    // Ambil data dari tombol
    var foto = $(this).data('foto');
    var kategori = $(this).data('kategori');

    // Isi konten modal
    $('#fotoGaleri').attr('src', foto); // Ganti src gambar
    $('#kategoriFoto').text(kategori ? kategori : 'Kategori tidak tersedia'); // Ganti teks kategori
});
</script>



</body>
</html>
