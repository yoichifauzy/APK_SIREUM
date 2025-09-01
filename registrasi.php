<?php
// Koneksi ke database
require 'config/database.php';

// Tambahkan negara baru jika data dikirim dari modal
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nama_negara_baru'])) {
  $nama_negara_baru = $koneksi->real_escape_string($_POST['nama_negara_baru']);

  // Periksa apakah negara sudah ada
  $checkNegara = "SELECT nama_negara FROM negara WHERE nama_negara = '$nama_negara_baru'";
  $result = $koneksi->query($checkNegara);

  if ($result->num_rows > 0) {
?>
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>

    <body></body>
    <script>
      Swal.fire({
        icon: 'warning',
        title: 'Negara Sudah Ada',
        text: 'Negara sudah ada dalam daftar.',
      }).then(() => {
        window.history.back();
      });
    </script>
    <?php
    exit(); // Menghentikan eksekusi PHP
  } else {
    // Masukkan negara baru ke database
    $sqlNegara = "INSERT INTO negara (nama_negara) VALUES ('$nama_negara_baru')";
    if ($koneksi->query($sqlNegara) === TRUE) {
    ?>
      <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>

      <body></body>
      <script>
        Swal.fire({
          icon: 'success',
          title: 'Berhasil!',
          text: 'Negara baru berhasil ditambahkan.',
        }).then(() => {
          window.location.href = 'registrasi.php';
        });
      </script>
    <?php
      exit(); // Menghentikan eksekusi PHP
    } else {
      // Jika terjadi kesalahan saat menambahkan
    ?>
      <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>

      <body></body>
      <script>
        Swal.fire({
          icon: 'error',
          title: 'Terjadi Kesalahan',
          text: 'Gagal menambahkan negara baru.',
        }).then(() => {
          window.history.back();
        });
      </script>
    <?php
      exit(); // Menghentikan eksekusi PHP
    }
  }
}

// Proses registrasi pengunjung
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nomor_identitas'])) {
  $nomor_identitas = $koneksi->real_escape_string($_POST['nomor_identitas']);
  $nama_pengunjung = $koneksi->real_escape_string($_POST['nama_pengunjung']);
  $tanggal_lahir = $koneksi->real_escape_string($_POST['tanggal_lahir']);
  $jenis_kelamin = $koneksi->real_escape_string($_POST['jenis_kelamin']);
  $alamat = $koneksi->real_escape_string($_POST['alamat']);
  $id_negara = $koneksi->real_escape_string($_POST['kewarganegaraan']);
  $nomor_telepon = $koneksi->real_escape_string($_POST['nomor_telepon']);
  $email = $koneksi->real_escape_string($_POST['email']);
  $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash password

  // Periksa apakah email sudah digunakan
  $checkEmail = "SELECT email_pengunjung FROM pengunjung WHERE email_pengunjung = '$email'";
  $result = $koneksi->query($checkEmail);

  if ($result->num_rows > 0) {
    ?>
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>

    <body></body>
    <script>
      Swal.fire({
        icon: 'warning',
        title: 'Email sudah digunakan',
        text: 'Email sudah terdaftar. Silakan gunakan email lain.',
      }).then(() => {
        window.history.back();
      });
    </script>
    <?php
    exit(); // Menghentikan eksekusi PHP
  } else {
    // Masukkan data pengunjung
    $sql = "INSERT INTO pengunjung (nomor_identitas_pengunjung, nama_pengunjung, tanggal_lahir_pengunjung, jenis_kelamin_pengunjung, alamat_pengunjung, kewarganegaraan, nomor_telepon_pengunjung, email_pengunjung, password_pengunjung) 
                VALUES ('$nomor_identitas', '$nama_pengunjung', '$tanggal_lahir', '$jenis_kelamin', '$alamat', $id_negara, '$nomor_telepon', '$email', '$password')";

    if ($koneksi->query($sql) === TRUE) {
    ?>
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

      <body></body>
      <script>
        Swal.fire({
          title: 'Sukses!',
          text: 'Registrasi berhasil. Silakan login.',
          icon: 'success',
          confirmButtonText: 'OK'
        }).then(() => {
          window.location.href = 'login.php';
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
          text: 'Terjadi kesalahan saat menyimpan data pengunjung.',
          icon: 'Error',
          confirmButtonText: 'OK'
        }).then(() => {
          window.history.back();
        });
      </script>
<?php
      exit(); // Menghentikan eksekusi PHP
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Registrasi</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Tangerine">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
  <!-- daterange picker -->
  <link rel="stylesheet" href="assets/plugins/daterangepicker/daterangepicker.css">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- Bootstrap4 Duallistbox -->
  <link rel="stylesheet" href="assets/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
  <!-- BS Stepper -->
  <link rel="stylesheet" href="assets/plugins/bs-stepper/css/bs-stepper.min.css">
  <!-- dropzonejs -->
  <link rel="stylesheet" href="assets/plugins/dropzone/min/dropzone.min.cssassets">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/simple-icons/14.0.1/simpleicons.svg">
  <!-- Theme style -->
  <link rel="stylesheet" href="assets/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>

<body class="hold-transition layout-top-nav">
  <div class="wrapper">

    <nav class="main-header navbar navbar-expand-md navbar-light navbar-white" style="height: 80px; padding: 10px 20px; font-size: 18px;">
      <div class="container-fluid" style="padding: 0 20px;">
        <a href="#" class="navbar-brand d-flex align-items-center" style="gap: 10px;">
          <img src="gambar/logo.jpg" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: 1; height: 55px; width: 55px; border: 2px solid #ddd;">
          <span class="brand-text font-weight-bold" style="font-family: 'Tangerine', serif; font-size: 42px; color: rgb(29, 21, 10); text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.3);">
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

    <!-- Card Section -->
    <div class="container d-flex justify-content-center align-items-center" style="min-height: calc(100vh - 80px);">
      <div class="card card-outline card-dark w-75">
        <div class="card-header text-center">
          <a href="../../index2.html" class="h1"><b>Regis</b>KangKunjung</a>
        </div>
        <div class="card-body">
          <p class="login-box-msg">Silahkan Login KangKunjung</p>

          <form action="" method="POST">
            <!-- Bagian row untuk kolom input -->
            <div class="row">
              <!-- Kolom kiri -->
              <div class="col-md-6">
                <div class="input-group mb-3">
                  <input type="number" class="form-control" name="nomor_identitas" placeholder="NO. IDENTITAS" required>
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fa-solid fa-pen-to-square"></span>
                    </div>
                  </div>
                </div>
                <div class="input-group mb-3">
                  <input type="text" class="form-control" name="nama_pengunjung" placeholder="NAMA LENGKAP" required>
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fa-solid fa-user-tie"></span>
                    </div>
                  </div>
                </div>
                <div class="input-group mb-3" id="reservationdate" data-target-input="nearest">
                  <input class="form-control datetimepicker-input" data-target="#reservationdate" name="tanggal_lahir" placeholder="TANGGAL LAHIR" required>
                  <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                    <div class="input-group-text">
                      <span class="fa fa-calendar"></span>
                    </div>
                  </div>
                </div>
                <div class="input-group mb-3">
                  <select class="form-control select2" name="jenis_kelamin" required>
                    <option selected="selected">Privasi gender</option>
                    <option>Laki-laki</option>
                    <option>Perempuan</option>
                  </select>
                  <div class="input-group-text">
                    <span class="fa fa-user"></span>
                  </div>
                </div>
              </div>

              <!-- Kolom kanan -->
              <div class="col-md-6">
                <div class="input-group mb-3">
                  <input id="passwordInput" type="password" class="form-control" name="password" placeholder="PASSWORD" required>
                  <div class="input-group-append">
                    <div class="btn btn-outline-light toggle-password">
                      <span class="fas fa-eye"></span>
                    </div>
                  </div>
                </div>
                <div class="input-group mb-3">
                  <select class="form-control select2" name="kewarganegaraan" required>
                    <option value="">-- Pilih Negara --</option>
                    <!-- PHP loop untuk menambahkan negara -->
                    <?php
                    $query = "SELECT id_negara, nama_negara FROM negara";
                    $result = $koneksi->query($query);
                    while ($row = $result->fetch_assoc()) {
                      echo "<option value='" . $row['id_negara'] . "'>" . $row['nama_negara'] . "</option>";
                    }
                    ?>
                  </select>
                  <div class="input-group-text" data-toggle="modal" data-target="#modal-default">
                    <span class="fa-solid fa-flag"></span>
                  </div>
                </div>
                <div class="input-group mb-3">
                  <input type="number" class="form-control" name="nomor_telepon" placeholder="NO TELP" required>
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fa-solid fa-phone"></span>
                    </div>
                  </div>
                </div>
                <div class="input-group mb-3">
                  <input type="email" class="form-control" name="email" placeholder="E-MAIL" required>
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fa-solid fa-envelope"></span>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Kolom Alamat mengambil dua kolom -->
            <div class="row">
              <div class="col-12">
                <div class="input-group mb-3">
                  <textarea class="form-control" rows="2" name="alamat" placeholder="MASUKKAN ALAMAT" required></textarea>
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fa-solid fa-location-dot"></span>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Bagian footer tombol -->
            <div class="row">
              <div class="col-8">
                <div class="icheck-dark">
                  <input type="checkbox" id="agreeTerms" name="terms" value="agree" required>
                  <label for="agreeTerms">Valid</label>
                </div>
              </div>
              <div class="col-2">
                <a href="index.php" class="btn btn-outline-danger btn-block">Kembali</a>
              </div>
              <div class="col-2">
                <button type="submit" class="btn btn-dark btn-block">Register</button>
              </div>
            </div>
          </form>


          <div class="modal fade" id="modal-default">
            <div class="modal-dialog">
              <form method="POST" action=""> <!-- Tambahkan form -->
                <div class="modal-content">
                  <div class="modal-header" style="background-color:rgba(1, 19, 22, 0.87); color: white;">
                    <h4 class="modal-title">Tambah Negara</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <p>Pastikan Penulisan Negara Dengan Benar&hellip;</p>
                    <input type="text" class="form-control" name="nama_negara_baru" placeholder="Tambah Negara Baru">
                  </div>
                  <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save changes</button>
                  </div>
                </div>
              </form>
              <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
          </div>

        </div>
      </div>
    </div>

  </div>
  </div>

  <!-- /.register-box -->


  <!-- Bootstrap CSS dan JS -->



  <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> -->

  <!-- jQuery -->
  <script src="assets/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="assets/dist/js/adminlte.min.js"></script>
  <!-- Select2 -->
  <script src="assets/plugins/select2/js/select2.full.min.js"></script>
  <!-- Bootstrap4 Duallistbox -->
  <script src="assets/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
  <!-- InputMask -->
  <script src="assets/plugins/moment/moment.min.js"></script>
  <script src="assets/plugins/inputmask/jquery.inputmask.min.js"></script>
  <!-- date-range-picker -->
  <script src="assets/plugins/daterangepicker/daterangepicker.js"></script>
  <!-- bootstrap color picker -->
  <script src="assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src="assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
  <!-- Bootstrap Switch -->
  <script src="assets/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
  <!-- BS-Stepper -->
  <script src="assets/plugins/bs-stepper/js/bs-stepper.min.js"></script>
  <!-- dropzonejs -->
  <script src="assets/plugins/dropzone/min/dropzone.min.js"></script>


  <script>
    $(function() {
      //Initialize Select2 Elements
      $('.select2').select2()

      //Initialize Select2 Elements
      $('.select2bs4').select2({
        theme: 'bootstrap4'
      })

      //Datemask dd/mm/yyyy
      $('#datemask').inputmask('dd/mm/yyyy', {
        'placeholder': 'dd/mm/yyyy'
      })
      //Datemask2 mm/dd/yyyy
      $('#datemask2').inputmask('mm/dd/yyyy', {
        'placeholder': 'mm/dd/yyyy'
      })


      //Date picker
      $('#reservationdate').datetimepicker({
        format: 'YYYY-MM-DD', // Format sesuai MySQL DATE
        icons: {
          time: 'far fa-clock',
          date: 'far fa-calendar',
          up: 'fas fa-chevron-up',
          down: 'fas fa-chevron-down',
          previous: 'fas fa-chevron-left',
          next: 'fas fa-chevron-right',
          today: 'far fa-calendar-check',
          clear: 'far fa-trash-alt',
          close: 'far fa-times-circle'
        }
      });

      //Date and time picker
      $('#reservationdatetime').datetimepicker({
        icons: {
          time: 'far fa-clock'
        }
      });

      //Date range picker
      $('#reservation').daterangepicker()
      //Date range picker with time picker
      $('#reservationtime').daterangepicker({
        timePicker: true,
        timePickerIncrement: 30,
        locale: {
          format: 'MM/DD/YYYY hh:mm A'
        }
      })
      //Date range as a button
      $('#daterange-btn').daterangepicker({
          ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
          },
          startDate: moment().subtract(29, 'days'),
          endDate: moment()
        },
        function(start, end) {
          $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
        }
      )

      //Timepicker
      $('#timepicker').datetimepicker({
        format: 'LT'
      })

      //Bootstrap Duallistbox
      $('.duallistbox').bootstrapDualListbox()

      //Colorpicker
      $('.my-colorpicker1').colorpicker()
      //color picker with addon
      $('.my-colorpicker2').colorpicker()

      $('.my-colorpicker2').on('colorpickerChange', function(event) {
        $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
      })

      $("input[data-bootstrap-switch]").each(function() {
        $(this).bootstrapSwitch('state', $(this).prop('checked'));
      })

    })
  </script>
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



</body>

</html>