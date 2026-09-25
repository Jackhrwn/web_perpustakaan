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
        <h2>Tambah Buku Baru</h2>
       
        <form action="proses_tambahbuku.php" method="POST">
           
            <div class="form-group">
                <label for="judul_buku">Nama Buku:</label>
                <input type="text" id="judul_buku" name="judul_buku" placeholder="Masukkan Nama Judul" required>
            </div>


            <div class="form-group">
                <label for="pengarang">Nama Pengarang:</label>
                <input type="text" id="pengarang" name="pengarang" placeholder="Masukan Nama Pengarang" required>
            </div>


            <div class="form-group">
                <label for="id_kategori">Pilih Kategori:</label>
                <select id="id_kategori" name="id_kategori" required>
                    <option value="">-- Pilih Kategori --</option>
                    <?php
                    // Looping dari database untuk dropdown
                    $kat = mysqli_query($koneksi, "SELECT * FROM kategori");
                    while($data_kat = mysqli_fetch_assoc($kat)) {
                        echo "<option value='{$data_kat['id_kategori']}'>{$data_kat['nama_kategori']}</option>";
                    }
                    ?>
                </select>
            </div>


            <button type="submit" class="btn" name="submit">Simpan Data</button>
            <a href="index.php" class="btn" style="background-color: #95a5a6; margin-left: 10px;">Batal</a>

        </form>
    </div>
    <div class="credit">
        <footer>
            <p>&copy; 2026 Jaka Permana Herawan</p>
        </footer>  
    </div>
</body>
</html>
