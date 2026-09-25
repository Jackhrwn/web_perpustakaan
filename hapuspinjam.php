
<?php
include 'koneksi.php';


// Menangkap ID dari URL
$id = $_GET['id'];


// Query Hapus
$query = "DELETE FROM peminjaman WHERE id_peminjaman = '$id'";


if(mysqli_query($koneksi, $query)) {
    header("Location: peminjaman.php");
} else {
    echo "Gagal menghapus data!";
}
?>
