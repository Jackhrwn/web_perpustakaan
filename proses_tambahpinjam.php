<?php
include 'koneksi.php';

    if(isset($_POST['submit'])) {
        $id_buk = $_POST['id_buku'];
        $nama = $_POST['nama_peminjam'];
        $tgl = $_POST['tgl_pinjam'];


        // Query Insert
        $query = "INSERT INTO peminjaman (id_buku, nama_peminjam, tgl_pinjam)
              VALUES ('$id_buk', '$nama', '$tgl')";
   
        if(mysqli_query($koneksi, $query)) {
            header("Location: peminjaman.php"); // Kembali ke halaman utama jika sukses
        } else {
            echo "Gagal menambah data!";
        }
    }
?>