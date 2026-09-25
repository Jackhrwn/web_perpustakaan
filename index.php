<?php
include 'koneksi.php';

// Query INNER JOIN
$query = "SELECT buku.id_buku,buku.judul_buku,buku.pengarang,buku.id_kategori, kategori.nama_kategori 
          FROM buku 
          INNER JOIN kategori ON buku.id_kategori = kategori.id_kategori";
$result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan Hogwarts</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header>
        <!--Judul-->
        <h1><img src="assets/img/logo.png" alt="Logo" width="100">Perpustakaan Digital Hogwarts</h1>
        <nav>
            <ul>
                <li><a class="btn btn-daftar" href="index.php">Daftar Buku</a></li>
                <li><a class="btn btn-daftar" href="peminjaman.php">Daftar Peminjam</a></li>
            </ul>
        </nav>
    </header>

    <div class="content">
        <h2>Data Buku</h2>
            <a href="tambah.php" class="btn btn-tambah">+ Tambah Buku Baru </a>
        <!--table-->
        <table class="table">
            <tr>
                <th>No.</th>
                <th>Judul Buku</th>
                <th>Pengarang</th>
                <th>Kategori</th>
                <th>Aksi</th>
            </tr>
            <?php $i=1; while($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?= $i++; ?></td>
                <td><?= $row['judul_buku']; ?></td>
                <td><?= $row['pengarang']; ?></td>
                <td><?= $row['nama_kategori']; ?></td>
                <td>
                    <a href="edit.php?id=<?= $row['id_buku']; ?>"class="btn btn-edit">Edit</a>  
                    <a href="hapus.php?id=<?= $row['id_buku']; ?>" class="btn btn-hapus" onclick="return confirm('Yakin mau hapus buku ini?')">Hapus</a>
                </td>
            </tr>
            <?php } ?>
        </table>
    </div>

    <div class="credit">
        <footer>
            <p>&copy; 2026 Jaka Permana Herawan</p>
        </footer>  
    </div>
</body>
</html>
