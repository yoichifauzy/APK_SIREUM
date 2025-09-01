<?php
require 'cek.php';
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Tangerine">
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="index3.html" class="brand-link">
    <img src="../gambar/logo.jpg" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light" style="font-family: 'Tangerine', serif;font-size: 26px;">Sireum Apk</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center">
      <div class="image">
        <img src="../assets/dist/img/avatar5.png" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info ml-3">
        <a href="#" class="d-block" style="font-size: 18px;">
          <?php echo htmlspecialchars($username_admin); ?><br>
          <span class="badge badge-danger">Admin Museum</span>
        </a>

        <!-- Menambahkan margin-top untuk memberi jarak antara "Operator Museum" dan "Online" -->
        <div class="status d-flex align-items-center mt-2"> <!-- mt-2 menambahkan margin-top -->
          <i class="fas fa-check-circle text-success mr-2"></i>
          <span class="text-success font-weight-bold">Online</span>
        </div>

      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
                          with font-awesome or any other icon font library -->

        <li class="nav-item">
          <a href="dashboard.php" class="nav-link">
            <i class="nav-icon fa-solid fa-house-user"></i>
            <p>
              Dashboard
              <span class="right badge badge-danger">New</span>
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="manajemen_admin.php" class="nav-link">
            <i class="nav-icon fa-solid fa-user-doctor"></i>
            <p>
              Manajemen Admin

            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="manajemen_operator.php" class="nav-link">
            <i class="nav-icon fa-solid fa-robot"></i>
            <p>
              Manajemen Operator

            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="manajemen_kontak.php" class="nav-link">
            <i class="nav-icon fa-solid fa-inbox"></i>
            <p>
              Manajemen Kontak Us

            </p>
          </a>
        </li>

        <!-- <li class="nav-item">
          <a href="manajemen_chating.php" class="nav-link">
            <i class="nav-icon fa-brands fa-rocketchat fa-bounce"></i>
            <p>
              Manajemen Chating

            </p>
          </a>
        </li> -->

        <li class="nav-item">
          <a href="manajemen_laporan.php" class="nav-link">
            <i class="nav-icon fa-solid fa-chart-simple"></i>
            <p>
              Manajemen Laporan

            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="logout.php" class="nav-link">
            <i class="nav-icon fa fa-power-off"></i>
            <p>
              Logout

            </p>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>