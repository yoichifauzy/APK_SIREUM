<?php
session_start();
require 'config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nama_pengunjung = $koneksi->real_escape_string($_POST['nama_pengunjung']);
  $email_pengunjung = $koneksi->real_escape_string($_POST['email']);

  // Cek data yang dikirim
  error_log("Nama: " . $nama_pengunjung);
  error_log("Email: " . $email_pengunjung);

  // Query untuk validasi nama dan email
  $query = "SELECT * FROM pengunjung WHERE nama_pengunjung = '$nama_pengunjung' AND email_pengunjung = '$email_pengunjung'";
  $result = $koneksi->query($query);

  if ($result->num_rows > 0) {
    echo json_encode(['status' => 'success']);
  } else {
    echo json_encode(['status' => 'not_found']);
  }
  exit();
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
    <!-- Login Section -->
    <div class="login-box-wrapper">
      <div class="login-box">
        <div class="card card-outline card-dark">
          <div class="card-header text-center">
            <div class="d-flex justify-content-center align-items-center flex-column">
              <img src="gambar/logo.jpg" alt="Logo Museum" class="img-fluid mb-2" style="width: 100px; height: 100px; border-radius: 50%; border: 2px solid rgb(255, 255, 255);">
              <a href="../../index2.html" class="h1 text-dark font-weight-bold" style="font-family: 'Tangerine', serif; font-size:50px;">Validasi Password</a>
            </div>
          </div>
          <div class="card-body">
            <p class="login-box-msg">Silahkan Validasi Kisanak</p>
            <form method="post">
              <div class="input-group mb-3">
                <input type="text" class="form-control" name="nama_pengunjung" placeholder="NAMA LENGKAP" required>
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fa-solid fa-user"></span>
                  </div>
                </div>
              </div>
              <div class="input-group mb-3">
                <input type="email" class="form-control" name="email" placeholder="EMAIL" required>
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fa-solid fa-lock"></span>
                  </div>
                </div>
              </div>
              <div class="d-flex justify-content-end">
                <a href="login.php" class="btn btn-warning">Kembali</a>
                <button type="submit" class="btn btn-danger" style="margin-left: 10px;">Validasi</button>
              </div>
            </form>
          </div>
        </div>
      </div>
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
  <script>
    document.querySelector('form').addEventListener('submit', function(e) {
      e.preventDefault();

      const formData = new FormData(this);

      fetch('lupa_password.php', {
          method: 'POST',
          body: formData
        })
        .then(response => response.json())
        .then(data => {
          if (data.status === 'success') {
            Swal.fire({
              title: 'Masukkan Password Baru',
              html: `
                    <form id="resetPasswordForm">
                        <div style="position: relative;">
                            <input type="password" id="newPassword" class="swal2-input" placeholder="Password Baru" required>
                            <i class="fa fa-eye toggle-visibility" id="toggleNewPassword" 
                               style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;"></i>
                        </div>
                        <div style="position: relative;">
                            <input type="password" id="confirmPassword" class="swal2-input" placeholder="Konfirmasi Password" required>
                            <i class="fa fa-eye toggle-visibility" id="toggleConfirmPassword" 
                               style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;"></i>
                        </div>
                    </form>
                `,
              focusConfirm: false,
              showCancelButton: true,
              cancelButtonText: 'Batal',
              confirmButtonText: 'Simpan Password',
              preConfirm: () => {
                const newPassword = document.getElementById('newPassword').value;
                const confirmPassword = document.getElementById('confirmPassword').value;

                if (!newPassword && !confirmPassword) {
                  // Tampilkan alert konfirmasi jika user tidak ingin mengganti password
                  return Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Apakah Anda yakin tidak ingin mengubah password?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Lanjutkan',
                    cancelButtonText: 'Kembali'
                  }).then((result) => {
                    if (result.isConfirmed) {
                      window.location.href = 'login.php';
                    }
                    return false; // Stop preConfirm execution
                  });
                }

                if (newPassword !== confirmPassword) {
                  Swal.showValidationMessage('Password tidak cocok');
                  return false; // Stop preConfirm execution
                }

                return {
                  newPassword
                };
              }
            }).then((result) => {
              if (result.value) {
                const passwordData = new FormData();
                passwordData.append('nama_pengunjung', formData.get('nama_pengunjung'));
                passwordData.append('email_pengunjung', formData.get('email'));
                passwordData.append('password', result.value.newPassword);

                fetch('reset_password.php', {
                    method: 'POST',
                    body: passwordData
                  })
                  .then(res => res.json())
                  .then(res => {
                    if (res.status === 'success') {
                      Swal.fire('Sukses!', 'Password berhasil diubah.', 'success').then(() => {
                        window.location.href = 'login.php';
                      });
                    } else {
                      Swal.fire('Gagal!', 'Terjadi kesalahan saat mengubah password.', 'error');
                    }
                  });
              }
            });

            // Tambahkan event listener untuk toggle visibility
            setTimeout(() => { // Ensure elements are loaded in DOM
              document.getElementById('toggleNewPassword').addEventListener('click', function() {
                const passwordInput = document.getElementById('newPassword');
                const icon = this;
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

              document.getElementById('toggleConfirmPassword').addEventListener('click', function() {
                const passwordInput = document.getElementById('confirmPassword');
                const icon = this;
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
            }, 0); // Ensures the event listeners are added after the Swal is rendered
          } else {
            Swal.fire({
              title: 'Gagal!',
              text: 'Nama atau email tidak ditemukan.',
              icon: 'error',
              confirmButtonText: 'Coba Lagi'
            });
          }
        })
        .catch(error => {
          console.error(error);
          Swal.fire('Error!', 'Terjadi kesalahan pada server.', 'error');
        });
    });
  </script>