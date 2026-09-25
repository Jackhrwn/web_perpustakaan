<?php
include 'koneksi.php';

    if(isset($_POST['submit'])) {
        $judul = $_POST['judul_buku'];
        $pengarang = $_POST['pengarang'];
        $id_kat = $_POST['id_kategori'];


        // Query Insert
        $query = "INSERT INTO buku (judul_buku, pengarang, id_kategori)
              VALUES ('$judul', '$pengarang', '$id_kat')";
   
        if(mysqli_query($koneksi, $query)) {
            header("Location: index.php"); // Kembali ke halaman utama jika sukses
        } else {
            echo "Gagal menambah data!";
        }
    }
?>