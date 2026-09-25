<?php
include 'koneksi.php';


// Menangkap ID dari URL
$id = $_GET['id'];


$cek_peminjaman = mysqli_query($koneksi, "SELECT * FROM peminjaman WHERE id_buku = '$id'");

if (mysqli_num_rows($cek_peminjaman) > 0) {
    // Jika ditemukan di tabel peminjaman, tampilkan pesan gagal
    echo "<script>
            alert('Gagal! Buku tidak bisa dihapus karena masih di pinjam');
            window.location.href='index.php';
          </script>";
} else {
    // Jika tidak ada di tabel peminjaman, baru eksekusi perintah hapus
    $query_hapus = "DELETE FROM buku WHERE id_buku = '$id'";
    if (mysqli_query($koneksi, $query_hapus)) {
        header("Location: index.php");
    } else {
        echo "Gagal menghapus data!";
    }
}
?>
