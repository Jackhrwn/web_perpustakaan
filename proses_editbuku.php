<?php
include 'koneksi.php';

if(isset($_POST['submit'])) {
    // Menangkap data dari form edit
    $id = $_POST['id_buku'];
    $judul = $_POST['judul_buku'];
    $pengarang = $_POST['pengarang'];
    $id_kat = $_POST['id_kategori'];


    // Query Update
    $query = "UPDATE buku SET
                judul_buku = '$judul',
                pengarang = '$pengarang',
                id_kategori = '$id_kat'
              WHERE id_buku = '$id'";
   
    if(mysqli_query($koneksi, $query)) {
        header("Location: index.php"); // Kembali ke halaman utama jika sukses
    } else {
        echo "Gagal mengupdate data!";
    }
}
?>