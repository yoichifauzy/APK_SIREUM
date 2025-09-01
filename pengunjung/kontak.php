<?php
require '../config/database.php'; // Pastikan Anda telah membuat file koneksi.php
include 'middleware.php';
cekLogin();

$message = ''; // Variabel untuk menyimpan pesan

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);
    $subjek = mysqli_real_escape_string($koneksi, $_POST['subjek']);
    $isi_pesan = mysqli_real_escape_string($koneksi, $_POST['isi_pesan']);

    // Query untuk menyimpan data ke database
    $query = "INSERT INTO kontak (username, email, subjek, isi_pesan) VALUES ('$username', '$email', '$subjek', '$isi_pesan')";

    if (mysqli_query($koneksi, $query)) {
        $message = "Terima kasih telah memberikan pendapat";
    } else {
        $message = "Gagal mengirim pesan: " . mysqli_error($koneksi);
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Halaman Kontak</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../assets/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../assets/dist/css/adminlte.min.css">
</head>
<body class="hold-transition layout-top-nav">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  <?php
        include 'navbar.php';

    ?>
  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          <h1 class="m-0 bg-navy text-white p-2 rounded w-25 text-center">Kontak</h1>
          </div>
          <div class="col-sm-6">
            
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card col-md-8 col-sm-8 mx-auto">
        <div class="card-body row">
          <div class="col-5 text-center d-flex align-items-center justify-content-center">
            <div class="">
            <img class="profile-user-img img-fluid img-circle bg-gray-dark" src="../gambar/logo.jpg" alt="User profile picture"><br><br>
              <h2>Sireum
                <br><strong>Nusantara</strong></h2>
              <p class="lead mb-5">Nusantara, Indonesia<br>
                Phone: +62 888 8888
              </p>
            </div>
          </div>
          <div class="col-7">
          <form method="POST" action="">
          <div class="mb-3">
                <label for="inputName" class="form-label">Nama Lengkap</label>
                <input type="text"id="username" name="username" class="form-control form-control-lg" placeholder="Nama Lengkap Anda" required>
            </div>


            <div class="mb-3">
                <label for="inputName" class="form-label">Email Anda</label>
                <input type="email" id="email" name="email" class="form-control form-control-lg" placeholder="Email Anda" required>
            </div>

            <div class="mb-3">
                <label for="inputName" class="form-label">Subjek</label>
                <input type="text"  id="subjek" name="subjek" class="form-control form-control-lg" placeholder="Subjek" required>
            </div>

            <div class="form-group">
              <label for="inputMessage">Pesan</label>
              <textarea id="isi_pesan" name="isi_pesan" class="form-control form-control-lg" rows="3" placeholder="Masukkan Pesan" required></textarea>
            </div>
            <div class="form-group">
              <input type="submit" class="btn btn-danger float-right" value="Kirim">
            </div>
            <!-- Area untuk pesan sukses -->
            <div id="successMessage" class="text-white bg-success p-2 rounded mt-2 w-75 mx-auto text-center">
                    <?php if (!empty($message)) echo $message; ?>
                </div>
            </form>
          </div>
        </div>
      </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  

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
<!-- AdminLTE App -->
<script src="../assets/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->

<script>
    // Tunggu hingga halaman dimuat
    document.addEventListener("DOMContentLoaded", function() {
        // Cari elemen pesan sukses
        const successMessage = document.getElementById("successMessage");

        // Jika ada pesan sukses, sembunyikan setelah 10 detik
        if (successMessage && successMessage.innerHTML.trim() !== "") {
            setTimeout(() => {
                successMessage.style.display = "none";
            }, 10000); // 10000 ms = 10 detik
        }
    });
</script>

</body>
</html>
