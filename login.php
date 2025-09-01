<?php
session_start();
require 'config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $koneksi->real_escape_string($_POST['nama_pengunjung']);
  $email = $koneksi->real_escape_string($_POST['email']);
  $password = $_POST['password'];

  // Flag untuk menandakan apakah ada kecocokan
  $found = false;

  // Fungsi untuk hash password jika belum di-hash
  function hash_and_update_password($koneksi, $table, $id_field, $id_value, $password_field, $password_plain)
  {
    if (strlen($password_plain) < 60) { // Jika password belum di-hash
      $hashed_password = password_hash($password_plain, PASSWORD_DEFAULT);
      $update_query = "UPDATE $table SET $password_field = ? WHERE $id_field = ?";
      $stmt = $koneksi->prepare($update_query);
      $stmt->bind_param("si", $hashed_password, $id_value);
      $stmt->execute();
      $stmt->close();
    }
  }

  // Cek di tabel admin
  $query_admin = "SELECT * FROM admin WHERE username_admin = '$username' AND email_admin = '$email'";
  $result_admin = $koneksi->query($query_admin);

  if ($result_admin->num_rows > 0) {
    $row = $result_admin->fetch_assoc();
    if (password_verify($password, $row['password_admin'])) {
      // Login berhasil sebagai admin
      $_SESSION['id_admin'] = $row['id_admin'];
      $_SESSION['username_admin'] = $row['username_admin'];
      $_SESSION['role'] = 'admin';
?>
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

      <body></body>
      <script>
        Swal.fire({
          title: 'Sukses!',
          text: 'Login admin berhasil!',
          icon: 'success',
          confirmButtonText: 'OK'
        }).then(() => {
          window.location.href = './admin/dashboard.php';
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
          text: 'password salah!',
          icon: 'error',
          confirmButtonText: 'Coba Lagi'
        }).then(() => {
          history.back('login.php'); // Kembali ke halaman login
        });
      </script>
    <?php
      exit(); // Menghentikan eksekusi PHP
    }
    $found = true; // Menandakan ada kecocokan di tabel admin
  }

  // Cek di tabel operator
  $query_operator = "SELECT * FROM operator WHERE username_operator = '$username' AND email_operator = '$email'";
  $result_operator = $koneksi->query($query_operator);

  if ($result_operator->num_rows > 0) {
    $row = $result_operator->fetch_assoc();
    if (password_verify($password, $row['password_operator'])) {
      $_SESSION['id_operator'] = $row['id_operator'];
      $_SESSION['username_operator'] = $row['username_operator'];
      $_SESSION['nama_operator'] = $row['nama_operator']; // Tambahkan ini
      $_SESSION['role'] = 'operator';
    ?>
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

      <body></body>
      <script>
        Swal.fire({
          title: 'Sukses!',
          text: 'Login operator berhasil!',
          icon: 'success',
          confirmButtonText: 'OK'
        }).then(() => {
          window.location.href = './operator/dashboard.php';
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
          text: 'password salah!',
          icon: 'error',
          confirmButtonText: 'Coba Lagi'
        }).then(() => {
          history.back('login.php'); // Kembali ke halaman login
        });
      </script>
    <?php
      exit(); // Menghentikan eksekusi PHP
    }
    $found = true; // Menandakan ada kecocokan di tabel operator
  }

  // Cek di tabel pengunjung
  $query_pengunjung = "SELECT * FROM pengunjung WHERE nama_pengunjung = '$username' AND email_pengunjung = '$email'";
  $result_pengunjung = $koneksi->query($query_pengunjung);

  if ($result_pengunjung->num_rows > 0) {
    $row = $result_pengunjung->fetch_assoc();
    if (password_verify($password, $row['password_pengunjung'])) {
      $_SESSION['id_pengunjung'] = $row['id_pengunjung'];
      $_SESSION['nama_pengunjung'] = $row['nama_pengunjung'];
      $_SESSION['role'] = 'pengunjung';
    ?>
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

      <body></body>
      <script>
        Swal.fire({
          title: 'Sukses!',
          text: 'Login pengunjung berhasil!',
          icon: 'success',
          confirmButtonText: 'OK'
        }).then(() => {
          window.location.href = './pengunjung/dashboard.php';
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
          text: 'password salah!',
          icon: 'error',
          confirmButtonText: 'Coba Lagi'
        }).then(() => {
          history.back('login.php'); // Kembali ke halaman login
        });
      </script>
    <?php
      exit(); // Menghentikan eksekusi PHP
    }
    $found = true; // Menandakan ada kecocokan di tabel pengunjung
  }

  // Jika tidak ada kecocokan
  if (!$found) {
    ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <body></body>
    <script>
      Swal.fire({
        title: 'Gagal!',
        text: 'username tidak ditemukan!',
        icon: 'error',
        confirmButtonText: 'Coba Lagi'
      }).then(() => {
        history.back('login.php'); // Kembali ke halaman login
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
  <title>Museum Nusantara</title>

  <style>
    /* Pastikan card login berada di tengah */
    .login-box-wrapper {
      min-height: calc(100vh - 80px);
      /* Tinggi penuh layar dikurangi tinggi navbar */
      display: flex;
      justify-content: center;
      align-items: center;
      padding-top: 20px;
      /* Tambahkan sedikit jarak dari navbar */
      background-color: #f4f6f9;
      /* Warna latar belakang opsional */
    }

    /* Sesuaikan tampilan login box */
    .login-box {
      width: 100%;
      max-width: 400px;
      /* Atur lebar maksimal */
    }
  </style>


  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Tangerine">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="assets/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>

<body class="hold-transition layout-top-nav">
  <div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand-md navbar-light navbar-white" style="height: 80px; padding: 10px 20px; font-size: 18px;">
      <div class="container-fluid" style="padding: 0 20px;">
        <a href="#" class="navbar-brand d-flex align-items-center" style="gap: 10px;">
          <img src="gambar/logo.jpg" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: 1; height: 55px; width: 55px; border: 2px solid #ddd;">
          <span class="brand-text font-weight-bold" style="font-family: 'Tangerine', serif; font-size: 42px; color:rgb(29, 21, 10); text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.3);">
            Sireum Nusantara
          </span>
        </a>
        <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
          <li class="nav-item">
            <div class="d-flex align-items-center justify-content-center" style="gap: 10px;">
              <button type="button" class="btn btn-warning" style="width: 80px;" onclick="location.href='index.php';">Beranda</button>
              <button type="button" class="btn btn-outline-info" style="width: 80px;" onclick="location.href='info.php';">Info</button>
              <button type="button" class="btn btn-outline-dark" onclick="location.href='login.php';">Sign In</button>
              <button type="button" class="btn btn-outline-danger" onclick="location.href='registrasi.php';">Sign Up</button>

            </div>
          </li>
        </ul>
      </div>
    </nav>
    <!-- /.navbar -->

    <!-- Login Section -->
    <div class="login-box-wrapper">
      <div class="login-box">
        <div class="card card-outline card-dark">
          <div class="card-header text-center">
            <div class="d-flex justify-content-center align-items-center flex-column">
              <img src="gambar/logo.jpg" alt="Logo Museum" class="img-fluid mb-2" style="width: 100px; height: 100px; border-radius: 50%; border: 2px solid rgb(255, 255, 255);">
              <a href="../../index2.html" class="h1 text-dark font-weight-bold" style="font-family: 'Tangerine', serif; font-size:50px;">Museum Nusantara</a>
            </div>
          </div>
          <div class="card-body">
            <p class="login-box-msg">Silahkan Login Kisanak</p>
            <form method="post">
              <div class="input-group mb-3">
                <input type="text" class="form-control" id="nama_pengunjung" name="nama_pengunjung" placeholder="NAMA LENGKAP" required>
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fa-solid fa-user"></span>
                  </div>
                </div>
              </div>
              <div class="input-group mb-3">
                <input type="email" class="form-control" id="email" name="email" placeholder="EMAIL" required>
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fa-solid fa-lock"></span>
                  </div>
                </div>
              </div>
              <div class="input-group mb-3">
                <input id="passwordInput" type="password" class="form-control" name="password" placeholder="PASSWORD" required>
                <div class="input-group-append">
                  <div class="btn btn-outline-light toggle-password">
                    <span class="fas fa-eye"></span>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-8">
                  <div class="icheck-primary">
                    <input type="checkbox" id="agreeTerms" name="terms" value="agree">
                    <label for="agreeTerms">Belum Punya Akun</label>
                  </div>
                  <p class="mb-0">
                    <a href="registrasi.php" class="text-center" style="color: red;" onclick="return showAlert()">Silahkan Registrasi</a>
                  </p>
                  <p class="mb-0">
                    <a href="lupa_password.php" class="text-center" style="color: blue;">Lupa Password?</a>
                  </p>
                </div>
                <div class="col-4">
                  <button type="submit" class="btn btn-danger btn-block d-flex align-items-center justify-content-center" style="gap: 10px; padding: 5px;">
                    <i class="fa-solid fa-shield-halved" style="color:rgb(233, 226, 226); font-size: 1.5rem;"></i>
                    <span style="font-size: 20px; color: white;"><b>Login</b></span>
                  </button>
                </div>
              </div>
            </form>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
    </div>
    <!-- /.login-section -->
  </div>


  <!-- ./wrapper -->

  <!-- jQuery -->
  <script src="../assets/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="../assets/dist/js/adminlte.min.js"></script>
  <script>
    document.querySelector('.toggle-password').addEventListener('click', function() {
      const passwordInput = document.getElementById('passwordInput');
      const icon = this.querySelector('i');

      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
      } else {
        passwordInput.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
      }
    });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <body></body>
  <script>
    function showAlert() {
      Swal.fire({
        icon: 'info',
        title: 'Selamat Datang!',
        text: 'Selamat datang di registrasi',
        confirmButtonText: 'Lanjutkan'
      }).then((result) => {
        if (result.isConfirmed) {
          // Redirect ke halaman registrasi.php setelah pengguna menutup SweetAlert
          window.location.href = 'registrasi.php';
        }
      });
      return false; // Mencegah redirect default jika dipanggil dari elemen <a> atau form
    }
  </script>
</body>

</html>