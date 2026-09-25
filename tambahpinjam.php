<?php include 'koneksi.php';?>
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
    </header>

    <div class="contentbuku">
        <h2>Tambah Peminjam Baru</h2>
       
        <form action="proses_tambahpinjam.php" method="POST">
           
            <div class="form-group">
                <label for="id_buku">Pilih Buku:</label>
                <select id="id_buku" name="id_buku" required>
                    <option value="">-- Pilih Buku --</option>
                    <?php
                    // Looping dari database untuk dropdown
                    $buk = mysqli_query($koneksi, "SELECT * FROM buku");
                    while($data_buk = mysqli_fetch_assoc($buk)) {
                        echo "<option value='{$data_buk['id_buku']}'>{$data_buk['judul_buku']}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="nama_peminjam">Nama Peminjam:</label>
                <input type="text" id="nama_peminjam" name="nama_peminjam" placeholder="Masukkan Nama" required>
            </div>

            <div class="form-group">
                <label for="tgl_pinjam">Tanggal Pinjam:</label>
                <input type="date" id="tgl_pinjam" name="tgl_pinjam" placeholder="Masukkan Tanggal" required>
            </div>

            <button type="submit" class="btn" name="submit">Simpan Data</button>
            <a href="peminjaman.php" class="btn" style="background-color: #95a5a6; margin-left: 10px;">Batal</a>

        </form>
    </div>
    <div class="credit">
        <footer>
            <p>&copy; 2026 Jaka Permana Herawan</p>
        </footer>  
    </div>
</body>
</html>
