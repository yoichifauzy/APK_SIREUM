<?php
session_start();
?>

<?php
require '../config/database.php';

// Ambil Data Operator
$query = "SELECT * FROM operator";
$result = mysqli_query($koneksi, $query);

// Tambah Operator
if (isset($_POST['tambah_operator'])) {
    $id_admin = $_SESSION['id_admin']; // Pastikan session id_admin sudah ada dan aktif

    $nama = mysqli_real_escape_string($koneksi, $_POST['nama_operator']);
    $alamat = mysqli_real_escape_string($koneksi, $_POST['alamat_operator']);
    $jenis_kelamin = mysqli_real_escape_string($koneksi, $_POST['jenis_kelamin_operator']);
    $telepon = mysqli_real_escape_string($koneksi, $_POST['nomor_telepon_operator']);
    $email = mysqli_real_escape_string($koneksi, $_POST['email_operator']);
    $username = mysqli_real_escape_string($koneksi, $_POST['username_operator']);
    $password = password_hash($_POST['password_operator'], PASSWORD_BCRYPT); // Hash password

    $query = "INSERT INTO operator (id_admin, nama_operator, alamat_operator, jenis_kelamin_operator, nomor_telepon_operator, email_operator, username_operator, password_operator)
                  VALUES ('$id_admin', '$nama', '$alamat', '$jenis_kelamin', '$telepon', '$email', '$username', '$password')";
    if (mysqli_query($koneksi, $query)) {
?>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <body></body>
        <script>
            Swal.fire({
                title: 'Sukses!',
                text: 'Operator berhasil ditambahkan!',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.href = 'manajemen_operator.php';
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
                text: 'Operator gagal ditambahkan!',
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

// Cek jika ada parameter status

if (isset($_GET['status'])) {
    $status = htmlspecialchars($_GET['status']);
    ?>
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script>
        window.onload = function() {
            const status = "<?= $status ?>";
            if (status === "edit_success") {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Data operator berhasil diperbarui!',
                }).then(() => {
                    window.history.replaceState(null, null, window.location.pathname);
                    window.location.reload(); // Tambahkan ini untuk memuat ulang halaman
                });
            } else if (status === "edit_error") {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: 'Terjadi kesalahan saat memperbarui data operator.',
                }).then(() => {
                    window.history.replaceState(null, null, window.location.pathname);
                    window.location.reload(); // Tambahkan ini untuk memuat ulang halaman
                });
            } else if (status === "delete_success") {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Data operator berhasil dihapus!',
                }).then(() => {
                    window.history.replaceState(null, null, window.location.pathname);
                    window.location.reload(); // Tambahkan ini untuk memuat ulang halaman
                });
            } else if (status === "delete_error") {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: 'Terjadi kesalahan saat menghapus data operator.',
                }).then(() => {
                    window.history.replaceState(null, null, window.location.pathname);
                    window.location.reload(); // Tambahkan ini untuk memuat ulang halaman
                });
            }
        }
    </script>
<?php
    exit(); // Menghentikan eksekusi PHP
}

// Edit Operator
if (isset($_POST['edit_operator'])) {
    $id = $_POST['id_operator'];
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama_operator']);
    $alamat = mysqli_real_escape_string($koneksi, $_POST['alamat_operator']);
    $jenis_kelamin = mysqli_real_escape_string($koneksi, $_POST['jenis_kelamin_operator']);
    $telepon = mysqli_real_escape_string($koneksi, $_POST['nomor_telepon_operator']);
    $email = mysqli_real_escape_string($koneksi, $_POST['email_operator']);
    $username = mysqli_real_escape_string($koneksi, $_POST['username_operator']);
    $password = $_POST['password_operator'];

    // Siapkan query dasar
    $query = "UPDATE operator SET 
                nama_operator='$nama', 
                alamat_operator='$alamat', 
                jenis_kelamin_operator='$jenis_kelamin', 
                nomor_telepon_operator='$telepon', 
                email_operator='$email', 
                username_operator='$username'";

    // Tambahkan password jika diisi
    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $query .= ", password_operator='$hashed_password'";
    }

    $query .= " WHERE id_operator=$id";

    // Eksekusi query dan cek hasil
    if (mysqli_query($koneksi, $query)) {
        // Redirect dengan status sukses
        header("Location: manajemen_operator.php?status=edit_success");
    } else {
        // Redirect dengan status gagal
        header("Location: manajemen_operator.php?status=edit_error");
    }
    exit();
}




// Hapus Operator
if (isset($_POST['hapus_operator'])) {
    $id = $_POST['id_operator'];
    $query = "DELETE FROM operator WHERE id_operator=$id";

    if (mysqli_query($koneksi, $query)) {
        header("Location: manajemen_operator.php?status=delete_success");
    } else {
        header("Location: manajemen_operator.php?status=delete_error");
    }
    exit();
}


?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manajemen Operator</title>

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
                            <span class="badge badge-dark"><i class="fa-solid fa-users-gear"></i>&nbsp;Manajemen Operator</span>
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
                                <div class="d-flex justify-content-between align-items-center">
                                    <h3 class="card-title me-3">Manajemen Data Operator</h3>
                                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-info">
                                        <i class="fa-solid fa-user-plus"></i>&nbsp;Tambah Operator
                                    </button>
                                </div>
                            </div>

                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example2" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nama</th>
                                            <th>Alamat</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Telepon</th>
                                            <th>Email</th>
                                            <th>Username</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                            <tr>
                                                <td><?= $row['id_operator']; ?></td>
                                                <td><?= $row['nama_operator']; ?></td>
                                                <td><?= $row['alamat_operator']; ?></td>
                                                <td><?= $row['jenis_kelamin_operator']; ?></td>
                                                <td><?= $row['nomor_telepon_operator']; ?></td>
                                                <td><?= $row['email_operator']; ?></td>
                                                <td><?= $row['username_operator']; ?></td>
                                                <td>
                                                    <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalEdit<?= $row['id_operator']; ?>"><i class="fa-solid fa-user-pen fa-lg"></i>&nbsp;Edit</button>
                                                    <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalHapus<?= $row['id_operator']; ?>"><i class="fa-solid fa-user-xmark fa-lg"></i>&nbsp;Hapus</button>
                                                </td>
                                            </tr>

                                            <!-- Modal Edit -->
                                            <div class="modal fade" id="modalEdit<?= $row['id_operator']; ?>" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <form method="POST">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit Operator</h5>
                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <input type="hidden" name="id_operator" value="<?= $row['id_operator']; ?>">
                                                                <div class="form-group">
                                                                    <label>Nama</label>
                                                                    <input type="text" name="nama_operator" value="<?= $row['nama_operator']; ?>" class="form-control" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Alamat</label>
                                                                    <input type="text" name="alamat_operator" value="<?= $row['alamat_operator']; ?>" class="form-control" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Jenis Kelamin</label>
                                                                    <select name="jenis_kelamin_operator" class="form-control">
                                                                        <option value="Laki-laki" <?= $row['jenis_kelamin_operator'] == 'Laki-laki' ? 'selected' : ''; ?>>Laki-laki</option>
                                                                        <option value="Perempuan" <?= $row['jenis_kelamin_operator'] == 'Perempuan' ? 'selected' : ''; ?>>Perempuan</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Telepon</label>
                                                                    <input type="text" name="nomor_telepon_operator" value="<?= $row['nomor_telepon_operator']; ?>" class="form-control" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Email</label>
                                                                    <input type="email" name="email_operator" value="<?= $row['email_operator']; ?>" class="form-control" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Username</label>
                                                                    <input type="text" name="username_operator" value="<?= $row['username_operator']; ?>" class="form-control" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Password Baru (Opsional)</label>
                                                                    <input type="password" name="password_operator" class="form-control" placeholder="Masukkan password baru">
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="submit" name="edit_operator" class="btn btn-primary">Simpan</button>
                                                            </div>
                                                        </form>

                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Modal Hapus -->
                                            <div class="modal fade" id="modalHapus<?= $row['id_operator']; ?>" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <form method="POST">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Hapus Operator</h5>
                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Apakah Anda yakin ingin menghapus operator <strong><?= $row['nama_operator']; ?></strong>?</p>
                                                                <input type="hidden" name="id_operator" value="<?= $row['id_operator']; ?>">
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="submit" name="hapus_operator" class="btn btn-danger">Hapus</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>

                                        </tfoot>
                                </table>

                                <div class="modal fade" id="modal-info">
                                    <div class="modal-dialog">
                                        <div class="modal-content bg-info">
                                            <form method="POST">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Tambah Operator</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label>Nama</label>
                                                        <input type="text" name="nama_operator" class="form-control" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Alamat</label>
                                                        <input type="text" name="alamat_operator" class="form-control" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Jenis Kelamin</label>
                                                        <select name="jenis_kelamin_operator" class="form-control">
                                                            <option value="Laki-laki">Laki-laki</option>
                                                            <option value="Perempuan">Perempuan</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Telepon</label>
                                                        <input type="text" name="nomor_telepon_operator" class="form-control" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Email</label>
                                                        <input type="email" name="email_operator" class="form-control" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Username</label>
                                                        <input type="text" name="username_operator" class="form-control" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Password</label>
                                                        <input type="password" name="password_operator" class="form-control" required>
                                                    </div>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
                                                    <button type="submit" name="tambah_operator" class="btn btn-success">Tambah</button>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                                <!-- /.modal -->


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


    <!-- /.modal -->

    <?php
    include 'footer.php';
    ?>


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
    <script src="../../dist/js/adminlte.min.js"></script>
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