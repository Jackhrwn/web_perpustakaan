<?php
include 'koneksi.php';

if(isset($_POST['submit'])) {
    // Menangkap data dari form edit
    $id = $_POST['id_peminjaman'];
    $id_buk = $_POST['id_buku'];
    $nama = $_POST['nama_peminjam'];
    $tgl = $_POST['tgl_pinjam'];


    // Query Update
    $query = "UPDATE peminjaman SET
                id_buku = '$id_buk',
                nama_peminjam = '$nama',
                tgl_pinjam = '$tgl'
              WHERE id_peminjaman = '$id'";
   
    if(mysqli_query($koneksi, $query)) {
        header("Location: peminjaman.php"); // Kembali ke halaman utama jika sukses
    } else {
        echo "Gagal mengupdate data!";
    }
}
?>