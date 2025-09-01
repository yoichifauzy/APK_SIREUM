<?php
session_start();
require '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_reservasi = $_POST['id_reservasi'];
    $aksi = $_POST['aksi']; // konfirmasi atau batalkan

    // Validasi input
    if (!empty($id_reservasi) && in_array($aksi, ['konfirmasi', 'batalkan'])) {
        // Tentukan status baru berdasarkan aksi
        $status_baru = ($aksi === 'konfirmasi') ? 'Sudah Dikonfirmasi' : 'Dibatalkan';
        
        // Ambil username operator dari session
        $username_operator = isset($_SESSION['username_operator']) ? $_SESSION['username_operator'] : 'Tidak Diketahui';

        try {
            // Query untuk mendapatkan id_operator berdasarkan username_operator
            $sql = "SELECT id_operator FROM operator WHERE username_operator = ?";
            $stmt = $koneksi->prepare($sql);
            $stmt->bind_param("s", $username_operator);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($id_operator);
            $stmt->fetch();

            // Pastikan id_operator ditemukan
            if (!$id_operator) {
                throw new Exception("Operator tidak ditemukan.");
            }

            // Query untuk memperbarui status_reservasi dan id_operator yang melakukan aksi
            $sql = "UPDATE reservasi SET status_reservasi = ?, id_operator = ? WHERE id_reservasi = ?";
            $stmt = $koneksi->prepare($sql);
            $stmt->bind_param("sii", $status_baru, $id_operator, $id_reservasi);

            if ($stmt->execute()) {
                $_SESSION['pesan'] = "Reservasi berhasil diubah menjadi '$status_baru'.";
            } else {
                throw new Exception("Gagal memperbarui status reservasi.");
            }
        } catch (Exception $e) {
            $_SESSION['pesan'] = "Error: " . $e->getMessage();
        }
    } else {
        $_SESSION['pesan'] = "Aksi tidak valid.";
    }

    // Redirect kembali ke halaman manajemen reservasi
    header("Location: manajemen_reservasi.php");
    exit;
} else {
    header("Location: manajemen_reservasi.php");
    exit;
}
?>
