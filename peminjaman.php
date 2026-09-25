<?php
include 'koneksi.php';

// Query INNER JOIN
$query = "SELECT peminjaman.id_peminjaman,buku.judul_buku,peminjaman.nama_peminjam,peminjaman.tgl_pinjam
          FROM peminjaman 
          INNER JOIN buku ON peminjaman.id_buku = buku.id_buku";
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
        <h1><img src="assets/img/logo.png" alt="Logo" width="100">Perpustakaan Digital Hogwarts</h1>
        <nav>
            <ul>
                <li><a class="btn btn-daftar" href="index.php">Daftar Buku</a></li>
                <li><a class="btn btn-daftar" href="peminjaman.php">Daftar Peminjam</a></li>
            </ul>
        </nav>
    </header>

    <div class="content">
        <h2>Data Peminjam</h2>
        <a href="tambahpinjam.php" class="btn btn-tambah">+ Tambah Peminjam Baru </a>
        <!--table-->
        <table class="table">
            <tr>
                <th>No.</th>
                <th>Judul Buku</th>
                <th>Nama Peminjam</th>
                <th>Tanggal Pinjam</th>
                <th>Aksi</th>
            </tr>
            <?php $i=1; while($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?= $i++; ?></td>
                <td><?= $row['judul_buku']; ?></td>
                <td><?= $row['nama_peminjam']; ?></td>
                <td><?= $row['tgl_pinjam']; ?></td>
                <td>
                    <a href="editpinjam.php?id=<?= $row['id_peminjaman']; ?>"class="btn btn-edit">Edit</a>  
                    <a href="hapuspinjam.php?id=<?= $row['id_peminjaman']; ?>" class="btn btn-hapus" onclick="return confirm('Yakin mau hapus transaksi ini?')">Hapus</a>
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