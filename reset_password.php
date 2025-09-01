<?php
session_start();
require 'config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_pengunjung = $koneksi->real_escape_string($_POST['nama_pengunjung']);
    $email_pengunjung = $koneksi->real_escape_string($_POST['email_pengunjung']);
    $password_baru = password_hash($koneksi->real_escape_string($_POST['password']), PASSWORD_BCRYPT);

    $query = "UPDATE pengunjung SET password_pengunjung = '$password_baru' WHERE nama_pengunjung = '$nama_pengunjung' AND email_pengunjung = '$email_pengunjung'";
    if ($koneksi->query($query)) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error']);
    }
    exit();
}
?>
