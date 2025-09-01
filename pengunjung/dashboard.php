<?php
include 'middleware.php';
cekLogin();
require '../config/database.php';

// Query untuk mendapatkan data
$sql = "SELECT 
            (SELECT COUNT(id_konten) FROM konten) AS total_konten,
            (SELECT COUNT(id_foto) FROM galeri) AS total_galeri,
            (SELECT SUM(jumlah_pengunjung) FROM reservasi) AS total_pengunjung";

$result = $koneksi->query($sql);

// Ambil hasilnya
if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $total_konten = $row['total_konten'];
    $total_galeri = $row['total_galeri'];
    $total_pengunjung = $row['total_pengunjung'];
} else {
    $total_konten = $total_galeri = $total_pengunjung = 0;
}

// Tutup koneksi
$koneksi->close();
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard</title>

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
  <!-- summernote -->
  <link rel="stylesheet" href="../assets/plugins/summernote/summernote-bs4.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="hold-transition layout-top-nav">
<div class="wrapper">
<?php
        include 'navbar.php';

    ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-dark card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle bg-light"
                       src="../gambar/logo.jpg"
                       alt="User profile picture">
                </div>

                <h3 class="profile-username text-center">Sireum Nusantara</h3>

                <p class="text-muted text-center">MUSEUM INDONESIA</p>

                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                      <b>Jumlah Acara atau Konten Museum</b> 
                      <a class="float-right text-light bg-dark p-1 rounded"><?php echo $total_konten; ?></a>
                  </li>
                  <li class="list-group-item">
                      <b>Jumlah Galeri Museum</b> 
                      <a class="float-right text-light bg-dark p-1 rounded"><?php echo $total_galeri; ?></a>
                  </li>
                  <li class="list-group-item">
                      <b>Jumlah Pengunjung Museum</b> 
                      <a class="float-right text-light bg-dark p-1 rounded"><?php echo $total_pengunjung; ?></a>
                  </li>
              </ul>

                <a href="#instagram" class="btn btn-danger btn-block"><b>Follow</b></a>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- About Me Box -->
            <div class="card card-dark">
              <div class="card-header">
                <h3 class="card-title"><i class=" nav-icon fa-solid fa-building-columns"></i>&nbsp;Tentang Museum</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <strong><i class="fas fa-book mr-1"></i> Nama Museum</strong>

                <p class="text-muted">
                  Museum Nusantara <br> By APK SIREUM The kel 8 <a class="float-right text-light bg-dark p-1 rounded">FFU</a>
                </p>

                <hr>

                <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong><br>
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15081.382987372288!2d106.54139039381423!3d-6.1828779508728715!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69fe4fc675da0f%3A0x84a0e5fc6c009127!2sPoliteknik%20Gajah%20Tunggal!5e1!3m2!1sen!2sid!4v1735632879904!5m2!1sen!2sid" width="320" height="215" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active bg-danger text-white" href="#activity" data-toggle="tab">Sejarah</a></li>
                  <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Timeline</a></li>
                  <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Pendiri</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="activity">
                    <!-- Post -->
                    <div class="post">
                      <div class="user-block">
                        <img class="img-circle img-bordered-sm" src="../gambar/logo.jpg" alt="user image">
                        <span class="username">
                          <a href="#" class="text-danger">Museum Nusantara</a>
                          <a href="#" class="float-right btn-tool"></a>
                        </span>
                        <span class="description">Dibagikan Publik - 16.27 WIB </span>
                      </div>
                      <!-- /.user-block -->
                      <p>
                      Museum Nusantara Di ambang cakrawala waktu,
                      Kisah bangsa terpahat dalam ruang yang bisu. <br>
                      Setiap sudutnya, alunan harmoni,
                      Menyatukan warisan dan visi tak bertepi. <br>

                      Di bawah cahaya yang lembut memeluk, Tradisi dan harapan saling berbisik. <br>
                      Museum ini bukan hanya saksi, Namun pengawal mimpi generasi. <br><br>
                      <a class="text-light bg-danger p-1 rounded">Museum Nusantara</a>
                      didirikan sebagai penjaga identitas budaya bangsa. Berdiri di jantung peradaban Indonesia, museum ini mengumpulkan artefak dari berbagai daerah, menceritakan kekayaan budaya yang beragam. Dari peradaban kuno hingga modern, museum ini lahir untuk menyatukan sejarah dan aspirasi masa depan, menjadikannya mercusuar pendidikan dan kebanggaan nasional.
                      </p>

                      <p>
                        <a href="#" class="link-black text-sm mr-2"><i class="fas fa-share mr-1"></i> Bagikeun</a>
                        <a href="#" class="link-black text-sm"><i class="far fa-thumbs-up mr-1"></i> Keren</a>
                        <span class="float-right">
                          <a href="#" class="link-black text-sm">
                            <i class="far fa-comments mr-1"></i> OziYoichi
                          </a>
                        </span>
                      </p>
                    </div>
                    <!-- /.post -->

                    <!-- Post -->
                    <div class="post">
                      <div class="user-block">
                        <img class="img-circle img-bordered-sm" src="../gambar/logo.jpg" alt="User Image">
                        <span class="username">
                        <a href="#" class="text-danger">Museum Nusantara</a>
                          <a href="#" class="float-right btn-tool"></a>
                        </span>
                        <span class="description">5 Foto - 5 Hari yang lalu</span>
                      </div>
                      <!-- /.user-block -->
                      <div class="row mb-3">
                        <div class="col-sm-6">
                          <img class="img-fluid" src="../gambar/dash_pengunjung/museum1.jpg" alt="Photo">
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-6">
                          <div class="row">
                            <div class="col-sm-6">
                              <img class="img-fluid mb-3" src="../gambar/dash_pengunjung/culture.jpg" alt="Photo">
                              <img class="img-fluid" src="../gambar/dash_pengunjung/culture1.jpg" alt="Photo">
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-6">
                              <img class="img-fluid mb-3" src="../gambar/dash_pengunjung/museum.jpg" alt="Photo">
                              <img class="img-fluid" src="../gambar/dash_pengunjung/travel.jpg" alt="Photo">
                            </div>
                            <!-- /.col -->
                          </div>
                          <!-- /.row -->
                        </div>
                        <!-- /.col -->
                      </div>
                      <!-- /.row -->

                      <p>
                        <a href="#" class="link-black text-sm mr-2"><i class="fas fa-share mr-1"></i> Bagikeun</a>
                        <a href="#" class="link-black text-sm"><i class="far fa-thumbs-up mr-1"></i> Keren</a>
                        <span class="float-right">
                          <a href="#" class="link-black text-sm">
                            <i class="far fa-comments mr-1"></i> OziYoichi
                          </a>
                        </span>
                      </p>
                    </div>
                    <!-- /.post -->
                  </div>
                  <!-- /.tab-pane -->
                  <div class="tab-pane" id="timeline">
                    <!-- The timeline -->
                    <div class="timeline timeline-inverse">
                      <!-- timeline time label -->
                      <div class="time-label">
                        <span class="bg-danger">
                          01 Januari 2024
                        </span>
                      </div>
                      <!-- /.timeline-label -->
                        <!-- timeline item -->
                        <div>
                          <i class="fas fa-solid fa-building-columns bg-primary"></i>

                          <div class="timeline-item">
                            <span class="time"><i class="far fa-clock"></i> </span>

                            <h3 class="timeline-header"><a href="#">Peresmian Pembukaan</a></h3>

                            <div class="timeline-body">
                              Museum Nusantara secara resmi dibuka untuk umum oleh Menteri Kebudayaan dan Pariwisata dalam sebuah acara
                              peresmian yang megah. Peresmian ini dihadiri oleh tokoh-tokoh budaya, seniman, akademisi,
                              serta perwakilan dari berbagai daerah di Indonesia. Dalam sambutannya, Menteri Kebudayaan
                              menekankan pentingnya museum ini sebagai penjaga identitas budaya bangsa dan sarana edukasi lintas generasi.

                            </div>

                            <div class="timeline-body">
                              <img src="../gambar/dash/timeline/timeline1.jpg" width="150" height="100" style="border-radius: 10px;">
                              <img src="../gambar/dash/timeline/timeline2.jpg" width="150" height="100" style="border-radius: 10px;">
                              <img src="../gambar/dash/timeline/timeline3.jpg" width="150" height="100" style="border-radius: 10px;">
                              <img src="../gambar/dash/timeline/timeline4.jpg" width="150" height="100" style="border-radius: 10px;">
                              <img src="../gambar/dash/timeline/timeline5.jpg" width="150" height="100" style="border-radius: 10px;">
                            </div>


                          </div>
                        </div>
                     
                      <div>
                        <i class="far fa-clock bg-gray"></i>
                      </div>
                    </div>
                  </div>
                  <!-- /.tab-pane -->

                  <div class="tab-pane" id="settings">
                    <form class="form-horizontal">
                      <div class="form-group row">
                        
                          <!-- /.col -->
                      <div class="col-md-4">
                        <!-- Widget: user widget style 1 -->
                      <div class="card card-widget widget-user">
                          <!-- Add the bg color to the header using any of the bg-* classes -->
                        <div class="widget-user-header text-white"
                              style="background: url('../gambar/dash/timeline/profile/fuji_bg.jpg') center center;">
                            <h3 class="widget-user-desc text-right">Ahmad Fauzi</h3>
                            <h5 class="widget-user-desc text-right">CEO Museum Nusantara</h5>
                          </div>
                          <div class="widget-user-image">
                            <img data-toggle="modal" data-target="#modal-p1" class="img-circle elevation-2" src="../gambar/dash/timeline/profile/yuzi.png" alt="User Avatar">
                          </div>
                          <div class="card-footer">
                          <div class="row">
                            <div class="col-sm-4 border-right">
                              <div class="description-block">
                              
                              <a href="https://www.instagram.com/zeexezee">
                              <img src="../gambar/dash/timeline/medsos/ig.jpg" alt="Followers Icon" 
                              class="img-thumbnail rounded-circle mt-2 small-circle-img" style="width: 50px; height: 50px;">
                                </a>
                                <span class="description-text">Instagram</span>
                              </div>
                              <!-- /.description-block -->
                            </div>
              <!-- /.col -->
                              <div class="col-sm-4 border-right">
                                <div class="description-block">
                                  
                                  <a href="https://www.facebook.com/Ahm Fauzii">
                                  <img src="../gambar/dash/timeline/medsos/fb.jpg" alt="Followers Icon" 
                                  class="img-thumbnail rounded-circle mt-2 small-circle-img" style="width: 50px; height: 50px;">
                                  </a>
                                  <span class="description-text">Facebook</span>
                                </div>
                                <!-- /.description-block -->
                              </div>
                              <!-- /.col -->
                              <div class="col-sm-4">
                                <div class="description-block">
                                  
                                  <a href="https://www.tiktok.com/@yuzikayhb">
                                  <img src="../gambar/dash/timeline/medsos/tt.jpg" alt="Followers Icon" 
                                  class="img-thumbnail rounded-circle mt-2 small-circle-img" style="width: 50px; height: 50px;">
                                  </a>
                                  <span class="description-text">Tiktok</span>
                                </div>
                                <!-- /.description-block -->
                              </div>
                              <!-- /.col -->
                            </div>

                        </div>
                        <!-- /.widget-user -->
                        
                  

                      </div>
        
            

            <!-- /.card -->
          </div>
                    <div class="col-md-4">
                        <!-- Widget: user widget style 1 -->
                      <div class="card card-widget widget-user">
                          <!-- Add the bg color to the header using any of the bg-* classes -->
                        <div class="widget-user-header text-white"
                              style="background: url('../gambar/dash/timeline/profile/febri_bg.jpg') center center;">
                            <h3 class="widget-user-desc text-right">Febri Nabilah</h3>
                            <h5 class="widget-user-desc text-right">CFO Museum Nusantara</h5>
                          </div>
                          <div class="widget-user-image">
                          <img data-toggle="modal" data-target="#modal-p2" src="../gambar/dash/timeline/profile/febri_pp.png" alt="User Avatar" 
                               style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover;">

                          </div>
                          <div class="card-footer">
                          <div class="row">
                            <div class="col-sm-4 border-right">
                              <div class="description-block">
                              
                              <a href="https://www.instagram.com/fblirn">
                              <img src="../gambar/dash/timeline/medsos/ig.jpg" alt="Followers Icon" 
                              class="img-thumbnail rounded-circle mt-2 small-circle-img" style="width: 50px; height: 50px;">
                                </a>
                                <span class="description-text">Instagram</span>
                              </div>
                              <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                              <div class="col-sm-4 border-right">
                                <div class="description-block">
                                  
                                  <a href="https://www.instagram.com/fblirn">
                                  <img src="../gambar/dash/timeline/medsos/fb.jpg" alt="Followers Icon" 
                                  class="img-thumbnail rounded-circle mt-2 small-circle-img" style="width: 50px; height: 50px;">
                                  </a>
                                  <span class="description-text">Facebook</span>
                                </div>
                                <!-- /.description-block -->
                              </div>
                              <!-- /.col -->
                              <div class="col-sm-4">
                                <div class="description-block">
                                  
                                <a href="https://www.tiktok.com/@febrinabilah_">
                                  <img src="../gambar/dash/timeline/medsos/tt.jpg" alt="Followers Icon" 
                                  class="img-thumbnail rounded-circle mt-2 small-circle-img" style="width: 50px; height: 50px;">
                                  </a>
                                  <span class="description-text">Tiktok</span>
                                </div>
                                <!-- /.description-block -->
                              </div>
                              <!-- /.col -->
                            </div>

                        </div>

                        

                        
                        

                        
          <!-- /.col -->
        </div>
        
        
        <!-- /.row -->
      </div><!-- /.container-fluid -->
      <div class="col-md-4">
                        <!-- Widget: user widget style 1 -->
                      <div class="card card-widget widget-user">
                          <!-- Add the bg color to the header using any of the bg-* classes -->
                        <div class="widget-user-header text-white"
                              style="background: url('../gambar/dash/timeline/profile/ulum_bg.jpg') center center;">
                            <h3 class="widget-user-desc text-right">Muhammad Pauzul Ulum</h3>
                            <h5 class="widget-user-desc text-right">COO Museum Nusantara</h5>
                          </div>
                          <div class="widget-user-image">
                          <img data-toggle="modal" data-target="#modal-p3" src="../gambar/dash/timeline/profile/ulum_pp.png" alt="User Avatar" 
                          style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover;">
                          </div>
                          <div class="card-footer">
                          <div class="row">
                            <div class="col-sm-4 border-right">
                              <div class="description-block">
                              
                              <a href="https://www.instagram.com/__ulumulu">
                              <img src="../gambar/dash/timeline/medsos/ig.jpg" alt="Followers Icon" 
                              class="img-thumbnail rounded-circle mt-2 small-circle-img" style="width: 50px; height: 50px;">
                                </a>
                                <span class="description-text">Instagram</span>
                              </div>
                              <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                              <div class="col-sm-4 border-right">
                                <div class="description-block">
                                  
                                  <a href="https://example.com/followers" target="_blank">
                                  <img src="../gambar/dash/timeline/medsos/fb.jpg" alt="Followers Icon" 
                                  class="img-thumbnail rounded-circle mt-2 small-circle-img" style="width: 50px; height: 50px;">
                                  </a>
                                  <span class="description-text">Facebook</span>
                                </div>
                                <!-- /.description-block -->
                              </div>
                              <!-- /.col -->
                              <div class="col-sm-4">
                                <div class="description-block">
                                  
                                <a href="https://www.tiktok.com/@kimyu__">
                                  <img src="../gambar/dash/timeline/medsos/tt.jpg" alt="Followers Icon" 
                                  class="img-thumbnail rounded-circle mt-2 small-circle-img" style="width: 50px; height: 50px;">
                                  </a>
                                  <span class="description-text">Tiktok</span>
                                </div>
                                <!-- /.description-block -->
                              </div>
                              <!-- /.col -->
                            </div>

                        </div>

                        <!-- Modal Ahmad Fauzi -->
                        <div class="modal fade" id="modal-p1">
                          <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h4 class="modal-title">Ahmad Fauzi</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body d-flex align-items-center">
                                  <!-- Gambar -->
                                  <img 
                                      src="../gambar/dash/timeline/profile/yuzi.png" 
                                      alt="User Avatar" 
                                      style="width: 35%; height: auto; border-radius: 10px; margin-right: 20px;">
                                  
                                  <!-- Biodata -->
                                  <div>
                                    <b>Ahmad Fauzi</b>
                                    <span class="badge bg-danger h-50">CEO Museum Nusantara</span>
                                    <div style="margin-top: 10px;">
                                        <div style="display: flex; justify-content: flex-start; gap: 10px;">
                                            <p style="min-width: 150px;"><strong>Umur:</strong></p>
                                            <p>18 Tahun</p>
                                        </div>
                                        <div style="display: flex; justify-content: flex-start; gap: 10px;">
                                            <p style="min-width: 150px;"><strong>Jenis Kelamin:</strong></p>
                                            <p>Laki-laki</p>
                                        </div>
                                        <div style="display: flex; justify-content: flex-start; gap: 10px;">
                                            <p style="min-width: 150px;"><strong>Tempat, Tgl Lahir:</strong></p>
                                            <p>Majalengka, 24 Januari</p>
                                        </div>
                                        <div style="display: flex; justify-content: flex-start; gap: 10px;">
                                            <p style="min-width: 150px;"><strong>Hobi:</strong></p>
                                            <p>Badminton, Catur dan Futsal</p>
                                        </div>
                                        <div style="display: flex; justify-content: flex-start; gap: 10px;">
                                            <p style="min-width: 150px;"><strong>Visi:</strong></p>
                                            <p>Membangun kehidupan yang seimbang antara spiritual, sosial, dan profesional.</p>
                                        </div>
                                        <div style="display: flex; justify-content: flex-start; gap: 10px;">
                                            <p style="min-width: 150px;"><strong>Misi:</strong></p>
                                            <p> Berlatih disiplin, tanggung jawab, dan ketekunan untuk menjadi lebih baik setiap hari.</p>
                                        </div>
                                    </div>
                                </div>
                              </div>
                            </div>
                            <!-- /.modal-content -->
                          </div>
                          <!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal -->

                        <!-- Modal Febri Nabilah -->
                        <div class="modal fade" id="modal-p2">
                          <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h4 class="modal-title">Febri Nabilah</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body d-flex align-items-center">
                                  <!-- Gambar -->
                                  <img 
                                      src="../gambar/dash/timeline/profile/febri_pp.png" 
                                      alt="User Avatar" 
                                      style="width: 35%; height: auto; border-radius: 10px; margin-right: 20px;">
                                  
                                  <!-- Biodata -->
                                  <div>
                                    <b>Febri Nabilah</b>
                                    <span class="badge bg-pink h-50">COO Museum Nusantara</span>
                                    <div style="margin-top: 10px;">
                                        <div style="display: flex; justify-content: flex-start; gap: 10px;">
                                            <p style="min-width: 150px;"><strong>Umur:</strong></p>
                                            <p>19 Tahun</p>
                                        </div>
                                        <div style="display: flex; justify-content: flex-start; gap: 10px;">
                                            <p style="min-width: 150px;"><strong>Jenis Kelamin:</strong></p>
                                            <p>Perempuan</p>
                                        </div>
                                        <div style="display: flex; justify-content: flex-start; gap: 10px;">
                                            <p style="min-width: 150px;"><strong>Tempat, Tgl Lahir:</strong></p>
                                            <p>Brebes, 7 Februari 2006</p>
                                        </div>
                                        <div style="display: flex; justify-content: flex-start; gap: 10px;">
                                            <p style="min-width: 150px;"><strong>Hobi:</strong></p>
                                            <p>Baca AU</p>
                                        </div>
                                        <div style="display: flex; justify-content: flex-start; gap: 10px;">
                                            <p style="min-width: 150px;"><strong>Visi:</strong></p>
                                            <p>Menjadi Manusia Paling Kaya</p>
                                        </div>
                                        <div style="display: flex; justify-content: flex-start; gap: 10px;">
                                            <p style="min-width: 150px;"><strong>Misi:</strong></p>
                                            <p>Cari Uang Yang Banyak</p>
                                        </div>
                                    </div>
                                </div>
                              </div>
                            </div>
                            <!-- /.modal-content -->
                          </div>
                          <!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal -->

                        <!-- Modal Muhammad Pauzul Ulum -->
                        <div class="modal fade" id="modal-p3">
                          <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h4 class="modal-title">Muhammad Pauzul Ulum</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body d-flex align-items-center">
                                  <!-- Gambar -->
                                  <img 
                                      src="../gambar/dash/timeline/profile/ulum_pp.png" 
                                      alt="User Avatar" 
                                      style="width: 35%; height: auto; border-radius: 10px; margin-right: 20px;">
                                  
                                  <!-- Biodata -->
                                  <div>
                                    <b>Muhammad Pauzul Ulum</b>
                                    <span class="badge bg-danger h-50">COO Museum Nusantara</span>
                                    <div style="margin-top: 10px;">
                                        <div style="display: flex; justify-content: flex-start; gap: 10px;">
                                            <p style="min-width: 150px;"><strong>Umur:</strong></p>
                                            <p>19 Tahun</p>
                                        </div>
                                        <div style="display: flex; justify-content: flex-start; gap: 10px;">
                                            <p style="min-width: 150px;"><strong>Jenis Kelamin:</strong></p>
                                            <p>Laki - Laki</p>
                                        </div>
                                        <div style="display: flex; justify-content: flex-start; gap: 10px;">
                                            <p style="min-width: 150px;"><strong>Tempat, Tgl Lahir:</strong></p>
                                            <p>Tangerang, 13 Desember 2005</p>
                                        </div>
                                        <div style="display: flex; justify-content: flex-start; gap: 10px;">
                                            <p style="min-width: 150px;"><strong>Hobi:</strong></p>
                                            <p>Menonton Drama Korea</p>
                                        </div>
                                        <div style="display: flex; justify-content: flex-start; gap: 10px;">
                                            <p style="min-width: 150px;"><strong>Visi:</strong></p>
                                            <p>Menjadi Manusia Berhati Lembut dan mengikhlaskan segala hal</p>
                                        </div>
                                        <div style="display: flex; justify-content: flex-start; gap: 10px;">
                                            <p style="min-width: 150px;"><strong>Misi:</strong></p>
                                            <p>Tetap Tekun, tabah dan Tawakal</p>
                                        </div>
                                    </div>
                                </div>
                              </div>
                            </div>
                            <!-- /.modal-content -->
                          </div>
                          <!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal -->
    </section>
    <!-- /.content -->
  </div>

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
<!-- AdminLTE for demo purposes -->

<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="../assets/dist/js/pages/dashboard.js"></script>
<script>
  $(document).on('shown.bs.tab', '.nav-pills a[data-toggle="tab"]', function (e) {
    $('.nav-pills .nav-link').removeClass('bg-danger text-white'); // Hapus kelas sebelumnya
    $(e.target).addClass('bg-danger text-white'); // Tambahkan ke elemen aktif
  });
</script>


</body>
</html>

