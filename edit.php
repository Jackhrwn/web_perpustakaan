<?php
require_once 'koneksi.php';
if (!isset($koneksi) || !$koneksi) {
    die('Koneksi database tidak tersedia.');
}

if (!isset($_GET['id'])) {
    die('ID tidak diberikan.');
}

$id = mysqli_real_escape_string($koneksi, $_GET['id']);
$query_buku = mysqli_query($koneksi, "SELECT * FROM buku WHERE id_buku = '$id'") or die(mysqli_error($koneksi));
$data = mysqli_fetch_assoc($query_buku);
if (!$data) {
    die('Buku tidak ditemukan.');
}
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
    </header>

    <div class="content">
        <h2>Edit Buku</h2>
       
        <form action="proses_editbuku.php" method="POST">
           
            <input type="hidden" name="id_buku" value="<?= $data['id_buku']; ?>">

            <div class="form-group">
                <label for="judul_buku">Nama Buku:</label>
                <input type="text" id="judul_buku" name="judul_buku" value="<?= $data['judul_buku']; ?>" required>
            </div>


            <div class="form-group">
                <label for="pengarang">Nama Pengarang:</label>
                <input type="text" id="pengarang" name="pengarang" value="<?= $data['pengarang']; ?>" required>
            </div>


            <div class="form-group">
                <label for="id_kategori">Pilih Kategori:</label>
                <select id="id_kategori" name="id_kategori" required>
                    <option value="">-- Pilih Kategori --</option>
                    <?php
                    // Looping dari database untuk dropdown
                    $kat = mysqli_query($koneksi, "SELECT * FROM kategori");
                    while($data_kat = mysqli_fetch_assoc($kat)) {
                        $pilih = ($data_kat['id_kategori'] == $data['id_kategori']) ? 'selected' : '';
                        echo "<option value='{$data_kat['id_kategori']}' $pilih>{$data_kat['nama_kategori']}</option>";
                    }
                    ?>
                </select>
            </div>


            <button type="submit" class="btn" name="submit">Simpan Perubahan</button>
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
