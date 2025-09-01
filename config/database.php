<?php
$host = "localhost";
$user = "root"; // Ganti sesuai username database
$password = ""; // Ganti sesuai password database
$database = "sireum"; // Nama database Anda

$koneksi = mysqli_connect($host, $user, $password, $database);

if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>
