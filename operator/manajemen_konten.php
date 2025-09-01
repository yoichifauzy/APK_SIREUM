<?php
session_start();

// Pastikan sudah ada koneksi database
require '../config/database.php';

// Ambil Data Konten dan Nama Operator
$query = "SELECT konten.*, operator.nama_operator 
          FROM konten 
          JOIN operator ON konten.id_operator = operator.id_operator";
$result = mysqli_query($koneksi, $query);

// Fungsi untuk mengubah path absolut menjadi URL relatif
function convertToRelativePath($absolutePath) {
  $basePath = __DIR__ . "/"; // Base path proyek Anda
  $relativePath = str_replace($basePath, "/", $absolutePath);
  $relativePath = str_replace("\\", "/", $relativePath); // Ubah backslash menjadi slash untuk URL
  // Tambahkan ./ di awal path relatif
  return './' . $relativePath;
}


// Fungsi Validasi File Upload
function validateFile($file) {
    $allowedExtensions = ['jpg', 'jpeg', 'png'];
    $maxFileSize = 10 * 1024 * 1024; // 10 MB

    $fileSize = $file['size'];
    $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    if (!in_array($fileExtension, $allowedExtensions)) {
        return "Ekstensi file tidak diperbolehkan! Hanya jpg, jpeg, dan png.";
    }

    if ($fileSize > $maxFileSize) {
        return "Ukuran file terlalu besar! Maksimal 10 MB.";
    }

    return null;
}

// Tambah Konten
if (isset($_POST['tambah_konten'])) {
    if (isset($_SESSION['id_operator'])) {
        $id_operator = $_SESSION['id_operator'];

        $nama_konten = htmlspecialchars($_POST['nama_konten']);
        $isi_konten = htmlspecialchars($_POST['isi_konten']);
        $tanggal_update = $_POST['tanggal_update'];
        $jam_mulai = $_POST['jam_mulai'];
        $jam_selesai = $_POST['jam_selesai'];

        // Validasi dan Upload Foto
        $foto = $_FILES['foto'];
        $error = validateFile($foto);

        if ($error === null) {
            $fotoName = time() . '_' . basename($foto['name']);
            $uploadDir = __DIR__ . "/upload/konten/";

            // Buat folder jika belum ada
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $path_foto = $uploadDir . $fotoName;

            if (move_uploaded_file($foto['tmp_name'], $path_foto)) {
                $query = "INSERT INTO konten (id_operator, nama_konten, isi_konten, tanggal_update, jam_mulai, jam_selesai, foto, path_foto)
                          VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

                $stmt = mysqli_prepare($koneksi, $query);
                mysqli_stmt_bind_param($stmt, 'isssssss', $id_operator, $nama_konten, $isi_konten, $tanggal_update, $jam_mulai, $jam_selesai, $fotoName, $path_foto);

                if (mysqli_stmt_execute($stmt)) {
                  ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <body></body>
    <script>
        Swal.fire({
            title: 'Sukses!',
            text: 'Konten berhasil ditambahkan!',
            icon: 'success',
            confirmButtonText: 'OK'
        }).then(() => {
            window.location.href = 'manajemen_konten.php';
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
                          text: 'Gagal menambahkan konten: " . mysqli_error($koneksi) . "',
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
                          text: 'Gagal mengunggah foto!',
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
          echo "<script>alert('$error');</script>";
      }
  } else {
      ?>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <body></body>
        <script>
              Swal.fire({
                title: 'Gagal!',
                text: 'Session operator tidak ditemukan!',
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

// Edit Konten
if (isset($_POST['edit_konten'])) {
    $id_konten = $_POST['id_konten'];
    $nama_konten = htmlspecialchars($_POST['nama_konten']);
    $isi_konten = htmlspecialchars($_POST['isi_konten']);
    $tanggal_update = $_POST['tanggal_update'];
    $jam_mulai = $_POST['jam_mulai'];
    $jam_selesai = $_POST['jam_selesai'];

    $query = "UPDATE konten SET 
                nama_konten=?, 
                isi_konten=?, 
                tanggal_update=?,
                jam_mulai=?,
                jam_selesai=?";

    // Cek jika ada foto baru
    if (!empty($_FILES['foto']['name'])) {
        $foto = $_FILES['foto'];
        $error = validateFile($foto);

        if ($error === null) {
            $fotoName = time() . '_' . basename($foto['name']);
            $uploadDir = __DIR__ . "/upload/konten/";

            // Buat folder jika belum ada
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $path_foto = $uploadDir . $fotoName;

            if (move_uploaded_file($foto['tmp_name'], $path_foto)) {
                $query .= ", foto=?, path_foto=?";
                $fotoParams = [$fotoName, $path_foto];
            } else {
              ?>
              <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
              <body></body>
              <script>
                  Swal.fire({
                      title: 'Gagal!',
                      text: 'Gagal mengunggah foto baru!',
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
            echo "<script>alert('$error');</script>";
        }
    }

    $query .= " WHERE id_konten=?";

    $stmt = mysqli_prepare($koneksi, $query);
    if (isset($fotoParams)) {
        mysqli_stmt_bind_param($stmt, 'sssssssi', $nama_konten, $isi_konten, $tanggal_update, $jam_mulai, $jam_selesai, $fotoParams[0], $fotoParams[1], $id_konten);
    } else {
        mysqli_stmt_bind_param($stmt, 'sssssi', $nama_konten, $isi_konten, $tanggal_update, $jam_mulai, $jam_selesai, $id_konten);
    }

    if (mysqli_stmt_execute($stmt)) {
      ?>
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
      <body></body>
      <script>
          Swal.fire({
              title: 'Sukses!',
              text: 'Konten berhasil diperbarui!',
              icon: 'success',
              confirmButtonText: 'OK'
          }).then(() => {
              window.location.href = 'manajemen_konten.php';
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
              text: 'Gagal memperbarui konten: " . mysqli_error($koneksi) . "',
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

// Hapus Konten
if (isset($_POST['hapus_konten'])) {
    $id_konten = $_POST['id_konten'];

    // Hapus file foto jika ada
    $fotoQuery = "SELECT path_foto FROM konten WHERE id_konten=?";
    $stmt = mysqli_prepare($koneksi, $fotoQuery);
    mysqli_stmt_bind_param($stmt, 'i', $id_konten);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        $path_foto = $row['path_foto'];
        if (file_exists($path_foto)) {
            unlink($path_foto);
        }
    }

    $query = "DELETE FROM konten WHERE id_konten=?";
    $stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($stmt, 'i', $id_konten);

    if (mysqli_stmt_execute($stmt)) {
      ?>
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
      <body></body>
      <script>
          Swal.fire({
              title: 'Sukses!',
              text: 'Konten berhasil dihapus!',
              icon: 'success',
              confirmButtonText: 'OK'
          }).then(() => {
              window.location.href = 'manajemen_konten.php';
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
              text: 'Gagal menghapus konten: " . mysqli_error($koneksi) . "',
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
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Manajemen Konten</title>

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
<body class="hold-transition sidebar-mini layout-fixed">

<?php include 'navbar.php'; ?>
<?php include 'sidebar.php'; ?>

<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
        <h1 class="m-0">
        <span class="badge badge-dark"><i class="fa-solid fa-camera-rotate"></i>&nbsp;Kelola Konten</span>
        </div>
      </div>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <div class="d-flex justify-content-between align-items-center">
                <h3 class="card-title">Daftar Konten</h3>
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-info"><i class="fa-regular fa-square-plus"></i>&nbsp;Tambah Konten</button>
              </div>
            </div>

            <div class="card-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama Konten</th>
                    <th>Isi Konten</th>
                    <th>Tanggal</th>
                    <th>Jam Mulai</th>
                    <th>Jam Selesai</th>
                    <th>Foto</th>
                    <th>Nama Operator</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>

                <?php
                      // Ambil data konten dari database
                      $query = "SELECT k.*, o.nama_operator 
                                FROM konten k 
                                LEFT JOIN operator o ON k.id_operator = o.id_operator";
                      $result = mysqli_query($koneksi, $query);

                      if (!$result) {
                          die("Query gagal: " . mysqli_error($koneksi));
                      }

                      $no = 1; 
                      while ($row = mysqli_fetch_assoc($result)) : 
                        $urlFoto = convertToRelativePath($row['path_foto']);
                  ?>
                  
                  <tr>
                    <td><?= $no++; ?></td>
                    <td style="max-width: 300px; overflow-x: auto;">
  <?= $row['nama_konten']; ?>
</td>

                    <td><?= $row['isi_konten']; ?></td>
                    <td><?= $row['tanggal_update']; ?></td>
                    <td><?= $row['jam_mulai']; ?></td>
                    <td><?= $row['jam_selesai']; ?></td>
                    <td><img src="<?= $urlFoto; ?>" alt="Foto Konten" width="50"></td>
                    <td><?= $row['nama_operator']; ?></td>
                    <td class="d-flex flex-wrap">
                    <div class="row">
  <div class="col-auto">
    <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalEdit<?= $row['id_konten']; ?>">
      <i class="fa-solid fa-pen-to-square"></i>&nbsp; <b>Edit</b>
    </button>
  </div>
  
  <div class="col-auto">
  <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalLihatGambar<?= $row['id_konten']; ?>">
    <i class="fa-solid fa-eye"></i>&nbsp;<b>Lihat</b>
  </button>
</div>

  <div class="col-auto">
    <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalHapus<?= $row['id_konten']; ?>">
      <i class="fa-solid fa-trash-arrow-up"></i>&nbsp; <b>Hapus</b>
    </button>
  </div>
</div>

                    </td>
                  </tr>

                  <div class="modal fade" id="modalEdit<?= $row['id_konten']; ?>" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <form method="POST" enctype="multipart/form-data">
                          <div class="modal-header">
                            <h5 class="modal-title">Edit Konten</h5>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                          </div>
                          <div class="modal-body">
                            <input type="hidden" name="id_konten" value="<?= $row['id_konten']; ?>">
                            <div class="form-group">
                              <label>Nama Konten</label>
                              <input maxlength="255"  type="text" name="nama_konten" value="<?= $row['nama_konten']; ?>" class="form-control" required>
                            </div>
                            <div class="form-group">
                              <label>Isi Konten</label>
                              <textarea name="isi_konten" class="form-control" required><?= $row['isi_konten']; ?></textarea>
                            </div>
                            <div class="form-group">
                              <label>Tanggal</label>
                              <input type="date" name="tanggal_update" value="<?= $row['tanggal_update']; ?>" class="form-control" required>
                            </div>
                            <div class="form-group">
                              <label>Jam Mulai</label>
                              <input type="time" name="jam_mulai" value="<?= $row['jam_mulai']; ?>" class="form-control" required>
                            </div>
                            <div class="form-group">
                              <label>Jam Selesai</label>
                              <input type="time" name="jam_selesai" value="<?= $row['jam_selesai']; ?>" class="form-control" required>
                            </div>
                            <div class="form-group">
                              <label>Foto</label>
                              <input type="file" name="foto" id="foto" class="form-control">
                              <input type="hidden" name="path_foto_lama" value="<?= $row['path_foto']; ?>">
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="submit" name="edit_konten" class="btn btn-primary">Simpan</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>

                  <div class="modal fade" id="modalHapus<?= $row['id_konten']; ?>" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <form method="POST">
                          <div class="modal-header">
                            <h5 class="modal-title">Hapus Konten</h5>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                          </div>
                          <div class="modal-body">
                            <p>Apakah Anda yakin ingin menghapus konten <strong><?= $row['nama_konten']; ?></strong>?</p>
                            <input type="hidden" name="id_konten" value="<?= $row['id_konten']; ?>">
                          </div>
                          <div class="modal-footer">
                            <button type="submit" name="hapus_konten" class="btn btn-danger">Hapus</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>

                  <div class="modal fade" id="modalLihatGambar<?= $row['id_konten']; ?>" tabindex="-1" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title"><?= $row['nama_konten']; ?></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body text-center">
                            <img src="<?= $urlFoto; ?>" alt="Gambar Konten" class="img-fluid" style="max-width: 100%; height: auto;">
                          </div>
                        </div>
                      </div>
                    </div>


                <?php endwhile; ?>
                </tbody>
              </table>

              <div class="modal fade" id="modal-info">
                <div class="modal-dialog">
                  <div class="modal-content bg-info">
                    <form method="POST" enctype="multipart/form-data">
                      <div class="modal-header">
                        <h4 class="modal-title">Tambah Konten</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <div class="form-group">
                          <label>Nama Konten</label>
                          <input type="text" name="nama_konten" class="form-control" required>
                        </div>
                        <div class="form-group">
                          <label>Isi Konten</label>
                          <textarea name="isi_konten" class="form-control" required></textarea>
                        </div>
                        <div class="form-group">
                          <label>Tanggal</label>
                          <input type="date" name="tanggal_update" class="form-control" required>
                        </div>
                        <div class="form-group">
                          <label>Jam Mulai</label>
                          <input type="time" name="jam_mulai" class="form-control" required>
                        </div>
                        <div class="form-group">
                          <label>Jam Selesai</label>
                          <input type="time" name="jam_selesai" class="form-control" required>
                        </div>
                        <div class="form-group">
                          <label>Foto</label>
                          <input type="file" name="foto" class="form-control" required>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-dark" data-dismiss="modal">Tutup</button>
                        <button type="submit" name="tambah_konten" class="btn btn-success">Tambah</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>


            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<?php include 'footer.php'; ?>

<script src="../assets/plugins/jquery/jquery.min.js"></script>
<script src="../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
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

<script>
  $(function () {
    $("#example2").DataTable({
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
