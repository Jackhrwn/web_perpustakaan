# Perpustakaan Digital Hogwarts

Aplikasi manajemen perpustakaan sederhana yang dibuat menggunakan **PHP native**
(tanpa framework) dan **MySQL/MariaDB**. Aplikasi ini menyediakan dua modul utama,
yaitu pengelolaan data buku dan pengelolaan data peminjaman, yang saling
terhubung melalui relasi database.

---

## Penjelasan Awal

### Latar Belakang

Pengelolaan perpustakaan secara manual — mulai dari pencatatan judul buku,
pengelompokan kategori, hingga pencatatan siapa yang sedang meminjam buku —
rawan terhadap kesalahan. Sulit mencari catatan tertentu, data mudah hilang, dan
tidak ada catatan kapan buku harus dikembalikan.

Aplikasi ini menyediakan solusi CRUD (Create, Read, Update, Delete) untuk data
buku dan data peminjaman dalam satu antarmuka web sederhana.

### Fitur

| Modul | Fitur | Keterangan |
| --- | --- | --- |
| **Buku** | Lihat daftar | Menampilkan judul, pengarang, dan kategori buku |
| | Tambah buku | Mencatat buku baru beserta kategori |
| | Edit buku | Mengubah judul, pengarang, atau kategori buku |
| | Hapus buku | Menghapus buku, **dengan validasi** jika buku sedang dipinjam |
| **Peminjaman** | Lihat daftar | Menampilkan buku yang dipinjam, nama peminjam, dan tanggal pinjam |
| | Tambah peminjaman | Mencatat peminjaman baru dengan tanggal |
| | Edit peminjaman | Mengubah buku, nama peminjam, atau tanggal |
| | Hapus peminjaman | Menghapus riwayat peminjaman (mis. buku sudah dikembalikan) |
| **GLOBAL** | Navigasi | Header dengan menu berpindah antara dua halaman daftar |
| | Validasi hapus | Buku yang sedang dipinjam tidak dapat dihapus |

### Teknologi

- **Bahasa:** PHP 7.4+ / 8.x
- **Database:** MySQL / MariaDB (dibuat dengan MariaDB 10.4.32)
- **Server:** Apache (XAMPP)
- **Frontend:** HTML5, CSS3 (murni, tanpa framework)
- **Tampilan:** Desktop dan mobile (menggunakan `<meta name="viewport">`)

---

## Dokumentasi Tampilan

Seluruh tampilan aplikasi didokumentasikan pada bagian ini. Setiap screenshot
menunjukkan file PHP yang menghasilkannya, elemen antarmuka yang terlihat, serta
kelas CSS yang mengendalikannya.

### Ringkasan Dokumentasi

| Screenshot | File PHP | Menampilkan |
| --- | --- | --- |
| `Tampilan Tabel Tambah Buku.png` | `index.php` | Tabel daftar buku |
| `Tampilan Tabel Tambah Peminjam.png` | `peminjaman.php` | Tabel daftar peminjam |
| `Tampilan Saat Tambah Buku.png` | `tambah.php` | Form tambah buku |
| `Tampilan Saat Tambah Peminjam.png` | `tambahpinjam.php` | Form tambah peminjam |
| `Tampilan Saat Mode Edit Buku.png` | `edit.php` | Form edit buku |
| `Tampilan Saat Mode Edit Peminjam.png` | `editpinjam.php` | Form edit peminjam |
| `Tampilan Header.png` | semua halaman daftar | Header & navigasi |
| `Tampilan Footer.png` | semua halaman | Footer / copyright |

---

### 1. Tampilan Tabel Tambah Buku

![Tampilan Tabel Tambah Buku](assets/img/Tampilan%20Tabel%20Tambah%20Buku.png)

Berasal dari **`index.php`** — halaman utama aplikasi.

**Elemen yang terlihat:**

- Judul section **"Data Buku"** — diatur oleh `.content h2` (garis bawah tipis
  sebagai pemisah).
- Tombol **"+ Tambah Buku Baru"** — ber-tautan ke `tambah.php`, bergaya
  `.btn-tambah` dengan font monospace.
- Tabel 5 kolom: `No.`, `Judul Buku`, `Pengarang`, `Kategori`, `Aksi`.
- Kolom `No.` diisi berurutan oleh variabel `$i++`, dimulai dari 1.
- Dua tombol aksi per baris: **Edit** (kelas `.btn-edit`, warna emas) dan
  **Hapus** (kelas `.btn-hapus`, warna merah).

**Catatan teknis:**

- Kolom `Kategori` berisi `nama_kategori`, bukan `id_kategori`. Nilainya
  diperoleh lewat `INNER JOIN` sehingga tabel `kategori` tidak perlu dibaca
  ulang di PHP.
- Baris tabel bergantian warna (*zebra striping*) berdasarkan aturan
  `.table tr:nth-child(even)`.
- Tiap tombol Edit/Hapus membawa `id_buku` sebagai parameter URL, misalnya
  `edit.php?id=1`.
- Tombol Hapus memasang `onclick="return confirm(...)"` sehingga browser
  meminta konfirmasi sebelum permintaan dikirim.

---

### 2. Tampilan Tabel Tambah Peminjam

![Tampilan Tabel Tambah Peminjam](assets/img/Tampilan%20Tabel%20Tambah%20Peminjam.png)

Berasal dari **`peminjaman.php`** — halaman kedua aplikasi.

**Elemen yang terlihat:**

- Judul section **"Data Peminjam"**.
- Tombol **"+ Tambah Peminjam Baru"** — ber-tautan ke `tambahpinjam.php`.
- Tabel 5 kolom: `No.`, `Judul Buku`, `Nama Peminjam`, `Tanggal Pinjam`,
  `Aksi`.
- Kolom `Tanggal Pinjam` ditampilkan dalam format `YYYY-MM-DD` sesuai tipe kolom
  `date` di database.

**Catatan teknis:**

- Kolom `Judul Buku` **bukan** milik tabel `peminjaman`. Nilainya diambil dari
  tabel `buku` melalui `INNER JOIN peminjaman.id_buku = buku.id_buku`.
- Karena memakai `INNER JOIN`, transaksi yang `id_buku`-nya menunjuk buku yang
  sudah terhapus tidak akan muncul di tabel ini.
- Aksi Edit/Hapus di sini mengarah ke `editpinjam.php` dan `hapuspinjam.php` —
  berbeda dengan halaman buku.

---

### 3. Tampilan Saat Tambah Buku

![Tampilan Saat Tambah Buku](assets/img/Tampilan%20Saat%20Tambah%20Buku.png)

Berasal dari **`tambah.php`**.

**Elemen yang terlihat:**

- Judul **"Tambah Buku Baru"**.
- Tiga isian form, masing-masing dibungkus `.form-group`:
  1. `Nama Buku` — `<input type="text" name="judul_buku">`
  2. `Nama Pengarang` — `<input type="text" name="pengarang">`
  3. `Pilih Kategori` — `<select name="id_kategori">`
- Dua tombol: **Simpan Data** (`.btn`) dan **Batal** (link kembali ke
  `index.php`).

**Catatan teknis:**

- Opsi dropdown kategori **di-generate dari database**, bukan ditulis manual:

  ```php
  $kat = mysqli_query($koneksi, "SELECT * FROM kategori");
  while ($data_kat = mysqli_fetch_assoc($kat)) {
      echo "<option value='{$data_kat['id_kategori']}'>{$data_kat['nama_kategori']}</option>";
  }
  ```

  Opsi pertama selalu `value=""` dengan teks *"-- Pilih Kategori --"* agar
  pengguna tidak bisa mengirim nilai kosong.
- Ketiga field memakai atribut `required`, sehingga browser memblokir submit
  bila ada yang kosong.
- Tombol submit diberi `name="submit"`. Nama inilah yang dipakai file proses
  untuk mendeteksi apakah form benar-benar terkirim (lihat
  `isset($_POST['submit'])`).
- Tampilan form memakai kelas `.contentbuku` (lebar maksimal 800px dan terpusat),
  berbeda dari `.content` yang dipakai halaman daftar.

---

### 4. Tampilan Saat Tambah Peminjam

![Tampilan Saat Tambah Peminjam](assets/img/Tampilan%20Saat%20Tambah%20Peminjam.png)

Berasal dari **`tambahpinjam.php`**.

**Elemen yang terlihat:**

- Judul **"Tambah Peminjam Baru"**.
- Tiga isian form:
  1. `Pilih Buku` — `<select name="id_buku">`
  2. `Nama Peminjam` — `<input type="text" name="nama_peminjam">`
  3. `Tanggal Pinjam` — `<input type="date" name="tgl_pinjam">`
- Dua tombol: **Simpan Data** dan **Batal** (kembali ke `peminjaman.php`).

**Catatan teknis:**

- Dropdown diisi dari tabel `buku` (`SELECT * FROM buku`), memakai
  `judul_buku` sebagai teks dan `id_buku` sebagai nilai yang dikirim.
- `input type="date"` memunculkan date picker bawaan browser. Nilainya dikirim
  dalam format `YYYY-MM-DD` yang langsung cocok dengan kolom `date`.
- Kolom `nama_peminjam` hanya menyimpan teks, **tidak** ada tabel anggota
  terpisah.

---

### 5. Tampilan Saat Mode Edit Buku

![Tampilan Saat Mode Edit Buku](assets/img/Tampilan%20Saat%20Mode%20Edit%20Buku.png)

Berasal dari **`edit.php`**.

**Elemen yang terlihat:**

- Judul **"Edit Buku"**.
- Form **sudah terisi data lama**: `The Diary of a Young Girl`,
  `Anne Frank`, dan kategori `Sejarah` terpilih.
- Tombol berbunyi **"Simpan Perubahan"** (bukan "Simpan Data" seperti pada form
  tambah).

**Catatan teknis:**

- Form edit memuat validasi yang tidak dimiliki form tambah:

  ```php
  if (!isset($_GET['id']))      die('ID tidak diberikan.');
  $id = mysqli_real_escape_string($koneksi, $_GET['id']);
  ```

  Bila dibuka tanpa `?id=...`, program berhenti dengan pesan, bukan error fatal.
- Kategori yang sedang dipakai ditandai otomatis lewat pengecekan:

  ```php
  $pilih = ($data_kat['id_kategori'] == $data['id_kategori']) ? 'selected' : '';
  ```

  Inilah yang membuat dropdown langsung menampilkan kategori lama tanpa perlu
  pengguna memilih ulang.
- `id_buku` dirender sebagai `<input type="hidden" name="id_buku">`. Field ini
  tidak terlihat, tetapi wajib ada karena form hanya mengirim data yang berada
  di dalam `<form>` — sedangkan `id` aslinya datang dari URL.
- `edit.php` memakai `require_once` (bukan `include`) dan memeriksa nilai
  `$koneksi`, sehingga halaman ini merupakan satu-satunya file yang melakukan
  pengecekan koneksi berlapis.

---

### 6. Tampilan Saat Mode Edit Peminjam

![Tampilan Saat Mode Edit Peminjam](assets/img/Tampilan%20Saat%20Mode%20Edit%20Peminjam.png)

Berasal dari **`editpinjam.php`**.

**Elemen yang terlihat:**

- Judul **"Edit Data Peminjam"**.
- Form terisi data lama: buku `The Alchemist`, peminjam `MAGI` (selesai), dan
  tanggal `10/04/2026`.

**Catatan teknis:**

- Pola identik dengan `edit.php`: baca `?id=`, query satu baris, isi form, tandai
  opsi terpilih, kirim `id_peminjaman` lewat field tersembunyi.
- Judul memakai frasa "Edit Data Peminjam" (bukan "Edit Peminjaman") agar
  konsisten dengan halaman daftar yang bernama "Data Peminjam".
- **Kekurangan:** file ini belum memvalidasi keberadaan `$_GET['id']`, berbeda
  dengan `edit.php`. Buka `editpinjam.php` tanpa `?id=` akan memicu PHP notice.

---

### 7. Tampilan Header

![Tampilan Header](assets/img/Tampilan%20Header.png)

Header bersifat **global** dan dipakai oleh kedua halaman daftar (`index.php` dan
`peminjaman.php`).

**Elemen yang terlihat:**

- Latar belakang biru tua (`rgb(18, 18, 74)`, kelas `header`).
- Logo (`assets/img/logo.png`) berada di samping kiri judul, ditampilkan
  `width="100"`.
- Judul **"Perpustakaan Digital Hogwarts"** berwarna emas
  (`rgb(194, 142, 22)`), dengan `vertical-align: middle` agar logo dan teks
  sejajar.
- Dua tombol navigasi: **Daftar Buku** dan **Daftar Peminjam**.

**Catatan teknis:**

- Menu navigasi hanya berisi dua tautan statis, tanpa penanda halaman aktif.
  Tampilan kedua tombol selalu sama, sehingga pengguna tidak dapat langsung
  tahu sedang berada di halaman mana.
- Gambar logo memakai `alt="Logo"`. Sebaiknya `alt` yang lebih deskriptif
  (misalnya "Logo Perpustakaan Hogwarts") akan lebih baik untuk aksesibilitas.
- Header **tidak ikut** dipakai oleh halaman form
  (`tambah.php`, `edit.php`, `tambahpinjam.php`, `editpinjam.php`) — halaman
  form hanya menampilkan judul tanpa menu navigasi.

---

### 8. Tampilan Footer

![Tampilan Footer](assets/img/Tampilan%20Footer.png)

Footer bersifat **global** dan muncul di **semua** halaman, termasuk halaman
form.

**Elemen yang terlihat:**

- Latar belakang biru tua sama seperti header (kelas `.credit`).
- Teks **"© 2026 Jaka Permana Herawan"** berwarna putih, rata tengah.

**Catatan teknis:**

- Nama kelas `.credit` tidak lagi mencerminkan isinya — area ini sekarang
  berfungsi sebagai footer. Nama aslinya berasal dari template bawaan yang
  gayanya sudah tidak sesuai dengan fungsinya sekarang.
- Selector `.credit` diberi `margin-top: 100px` sehingga footer selalu terdorong
  ke bawah, terpisah dari konten.
- Karena ditulis langsung di dalam kode, tahun dan nama penulis harus diubah
  manual setiap tahun.

---

## Struktur Folder

```
web_perpustakaan/
│
├── index.php                  # Halaman utama: daftar buku
├── peminjaman.php             # Halaman daftar peminjam
│
├── tambah.php                 # Form tambah buku
├── edit.php                   # Form edit buku
├── hapus.php                  # Proses hapus buku
│
├── tambahpinjam.php           # Form tambah peminjam
├── editpinjam.php             # Form edit peminjam
├── hapuspinjam.php            # Proses hapus peminjam
│
├── proses_tambahbuku.php      # Handler submit form buku (tambah)
├── proses_editbuku.php        # Handler submit form buku (edit)
├── proses_tambahpinjam.php    # Handler submit form peminjam (tambah)
├── proses_editpinjam.php      # Handler submit form peminjam (edit)
│
├── koneksi.php                # Konfigurasi & koneksi database
│
├── assets/                    # Aset statis (tidak dieksekusi PHP)
│   ├── css/
│   │   └── style.css          # Seluruh gaya tampilan aplikasi
│   └── img/
│       ├── logo.png                    # Logo di header
│       ├── Tampilan Header.png         # Screenshot: header & navigasi
│       ├── Tampilan Footer.png         # Screenshot: footer
│       ├── Tampilan Tabel Tambah Buku.png
│       ├── Tampilan Tabel Tambah Peminjam.png
│       ├── Tampilan Saat Tambah Buku.png
│       ├── Tampilan Saat Tambah Peminjam.png
│       ├── Tampilan Saat Mode Edit Buku.png
│       └── Tampilan Saat Mode Edit Peminjam.png
│
├── database/
│   └── db_perpustakaan.sql    # Struktur & data awal tabel
│
└── README.md                  # Dokumentasi ini
```

### Pembagian File

| Kelompok | File | Fungsi |
| --- | --- | --- |
| **Halaman utama** | `index.php`, `peminjaman.php` | Menampilkan daftar data (*read*) |
| **Form input** | `tambah.php`, `edit.php`, `tambahpinjam.php`, `editpinjam.php` | Formulir membuat & mengubah data |
| **Aksi hapus** | `hapus.php`, `hapuspinjam.php` | Menghapus data lalu redirect ke halaman daftar |
| **Proses** | `proses_*.php` | Menerima `POST` dari form, menjalankan query, lalu `header("Location: ...")` |
| **Koneksi** | `koneksi.php` | Satu-satunya file yang memanggil `mysqli_connect()` |
| **Aset** | `assets/css/`, `assets/img/` | CSS, logo, dan screenshot dokumentasi |
| **Database** | `database/db_perpustakaan.sql` | Script import tabel & data contoh |

### Struktur Assets

Folder `assets/` dipisah dari file PHP karena isinya murni statis — tidak ada
kode yang dieksekusi. Pemisahan ini memudahkan:

- Penyuntingan tampilan cukup dilakukan di `assets/css/style.css`, tanpa perlu
  menyentuh file PHP.
- Seluruh gambar (logo dan screenshot dokumentasi) terkumpul di satu tempat.
- Path aset ditulis relatif dari root, misal
  `<link rel="stylesheet" href="assets/css/style.css">`.

**Catatan:** screenshot di `assets/img/` hanya dipakai oleh README (dokumentasi),
tidak dirujuk oleh kode aplikasi mana pun. Aset-aset ini diperuntukkan bagi
dokumentasi, bukan bagian dari runtime aplikasi.

---

## Alur Program

### 0. Inisialisasi (Pola yang Digunakan Setiap Halaman)

Semua file yang butuh database mengikuti pola yang sama:

```php
include 'koneksi.php';   // 1. Hubungkan ke database
$query = "SELECT ...";   // 2. Susun query
$result = mysqli_query($koneksi, $query);   // 3. Jalankan query
```

`koneksi.php` melakukan pengecekan koneksi dan menghentikan program (`die()`)
bila gagal:

```
koneksi.php
├── $host, $user, $pass, $db  (dibaca dari atas file)
├── mysqli_connect()  ──gagal──▶  die("Koneksi gagal: ...")
└── berhasil ──▶ variabel $koneksi siap dipakai
```

### 1. Alur Menampilkan Daftar Buku

```
Browser ──GET /index.php──▶ index.php
                              │
                              ├──▶ koneksi.php (mysqli_connect)
                              │
                              ├──▶ SELECT buku + kategori (INNER JOIN)
                              │
                              ├──▶ while(mysqli_fetch_assoc($result))
                              │     └── cetak <tr> per baris
                              │
                              └──▶ HTML dikirim ke browser
```

Query yang digunakan menggabungkan dua tabel agar nama kategori ikut tampil:

```sql
SELECT buku.id_buku, buku.judul_buku, buku.pengarang,
       buku.id_kategori, kategori.nama_kategori
FROM buku
INNER JOIN kategori ON buku.id_kategori = kategori.id_kategori;
```

Alur untuk **Daftar Peminjam** (`peminjaman.php`) identik, hanya joining tabel
`peminjaman` dengan `buku`.

### 2. Alur Tambah Buku

```
[index.php]  klik "+ Tambah Buku Baru"
      │
      ▼
[tambah.php]  ── Ambil kategori untuk dropdown ──▶ SELECT * FROM kategori
      │  form method="POST" action="proses_tambahbuku.php"
      │  [judul_buku] [pengarang] [id_kategori] [submit]
      ▼
[proses_tambahbuku.php]
      │
      ├──▶ isset($_POST['submit']) ?  ──tidak──▶ tidak ada aksi
      │
      ├──▶ INSERT INTO buku (judul_buku, pengarang, id_kategori) VALUES (...)
      │
      ├──▶ mysqli_query() berhasil?
      │        ├── ya ──▶ header("Location: index.php")
      │        └── tidak ──▶ echo "Gagal menambah data!"
```

### 3. Alur Edit Buku

```
[index.php]  klik "Edit" pada baris tertentu
      │  link membawa ?id=<id_buku>
      ▼
[edit.php]
      │
      ├──▶ Validasi: $_GET['id'] harus ada  ──tidak──▶ die('ID tidak diberikan.')
      ├──▶ mysqli_real_escape_string($koneksi, $_GET['id'])
      ├──▶ SELECT * FROM buku WHERE id_buku = '$id'
      │        └── tidak ditemukan ──▶ die('Buku tidak ditemukan.')
      │
      ├──▶ Isi form dengan nilai lama
      ├──▶ Tandai kategori saat ini sebagai "selected"
      └──▶ <input type="hidden" name="id_buku">  (kirim id untuk WHERE)
      │
      ▼
[proses_editbuku.php]
      │
      ├──▶ UPDATE buku SET judul_buku, pengarang, id_kategori
      │      WHERE id_buku = '$id'
      │
      └──▶ header("Location: index.php")
```

`id_buku` dikirim lewat `input type="hidden"` karena form hanya mengirim data
yang dirender di dalam `<form>`, sedangkan `id` aslinya datang dari URL.

### 4. Alur Hapus Buku (dengan Validasi)

```
[index.php]  klik "Hapus" ──▶ confirm() konfirmasi di browser
      │  ?id=<id_buku>
      ▼
[hapus.php]
      │
      ├──▶ SELECT * FROM peminjaman WHERE id_buku = '$id'
      │
      ├──▶ mysqli_num_rows() > 0 ?  (buku sedang dipinjam)
      │        ├── YA ──▶ alert("Gagal! Buku tidak bisa dihapus
      │        │            karena masih di pinjam")
      │        │            window.location.href = 'index.php'
      │        │
      │        └── TIDAK ──▶ DELETE FROM buku WHERE id_buku = '$id'
      │                        ├── berhasil ──▶ header("Location: index.php")
      │                        └── gagal ──▶ echo "Gagal menghapus data!"
```

Validasi ini adalah **fitur penting**: tanpa itu, menghapus buku yang sedang
dipinjam akan meninggalkan transaksi peminjaman yang menunjuk ke buku yang sudah
tidak ada (mengganggu referential integrity).

### 5. Alur Tambah Peminjaman

```
[peminjaman.php]  klik "+ Tambah Peminjam Baru"
      │
      ▼
[tambahpinjam.php] ── Ambil buku untuk dropdown ──▶ SELECT * FROM buku
      │  [id_buku] [nama_peminjam] [tgl_pinjam] [submit]
      ▼
[proses_tambahpinjam.php]
      ├──▶ INSERT INTO peminjaman (id_buku, nama_peminjam, tgl_pinjam)
      └──▶ header("Location: peminjaman.php")
```

### 6. Alur Edit Peminjaman

```
[peminjaman.php]  klik "Edit" ──▶ ?id=<id_peminjaman>
      ▼
[editpinjam.php]
      ├──▶ SELECT * FROM peminjaman WHERE id_peminjaman = '$id'
      ├──▶ Isi form dengan nilai lama
      ├──▶ Tandai buku saat ini sebagai "selected"
      └──▶ <input type="hidden" name="id_peminjaman">
      ▼
[proses_editpinjam.php]
      ├──▶ UPDATE peminjaman SET id_buku, nama_peminjam, tgl_pinjam
      │      WHERE id_peminjaman = '$id'
      └──▶ header("Location: peminjaman.php")
```

### 7. Alur Hapus Peminjaman

```
[peminjaman.php]  klik "Hapus" ──▶ confirm() ──▶ ?id=<id_peminjaman>
      ▼
[hapuspinjam.php]
      ├──▶ DELETE FROM peminjaman WHERE id_peminjaman = '$id'
      └──▶ header("Location: peminjaman.php")
```

Dipakai ketika buku sudah dikembalikan. Tidak ada validasi tambahan karena
menghapus transaksi tidak berdampak bagi tabel `buku`.

### Ringkasan Pola Redirect

| Aksi | File Proses | Redirect ke |
| --- | --- | --- |
| Tambah buku | `proses_tambahbuku.php` | `index.php` |
| Edit buku | `proses_editbuku.php` | `index.php` |
| Hapus buku | `hapus.php` | `index.php` |
| Tambah peminjaman | `proses_tambahpinjam.php` | `peminjaman.php` |
| Edit peminjaman | `proses_editpinjam.php` | `peminjaman.php` |
| Hapus peminjaman | `hapuspinjam.php` | `peminjaman.php` |

---

## Struktur Database

Tiga tabel dengan relasi `kategori ← buku ← peminjaman`:

```
kategori (1) ────────< (N) buku (1) ────────< (N) peminjaman
  id_kategori            id_buku                id_peminjaman
  nama_kategori          judul_buku             id_buku  (FK)
                         pengarang              nama_peminjam
                         id_kategori (FK)       tgl_pinjam
```

### `kategori`

| Kolom | Tipe | Keterangan |
| --- | --- | --- |
| `id_kategori` | `int(11)` | Primary key, auto increment |
| `nama_kategori` | `varchar(100)` | Nama kategori |

### `buku`

| Kolom | Tipe | Keterangan |
| --- | --- | --- |
| `id_buku` | `int(11)` | Primary key, auto increment |
| `judul_buku` | `varchar(225)` | Judul buku |
| `pengarang` | `varchar(100)` | Nama pengarang |
| `id_kategori` | `int(11)` | Foreign key → `kategori.id_kategori` |

### `peminjaman`

| Kolom | Tipe | Keterangan |
| --- | --- | --- |
| `id_peminjaman` | `int(11)` | Primary key, auto increment |
| `id_buku` | `int(11)` | Foreign key → `buku.id_buku` |
| `nama_peminjam` | `varchar(100)` | Nama orang yang meminjam |
| `tgl_pinjam` | `date` | Tanggal peminjaman |

Foreign key ditandai `ON UPDATE CASCADE`, dan `DROP TABLE IF EXISTS` dipakai di
script agar file bisa di-import berulang kali tanpa error.

---

## Cara Menjalankan

### Kebutuhan

- XAMPP (atau Apache + MySQL versi terbaru)
- PHP 7.4 atau lebih baru

### Langkah

1. Salin folder ini ke `C:\xampp\htdocs\web_perpustakaan`
2. Jalankan **Apache** dan **MySQL** melalui XAMPP Control Panel
3. Buka browser ke `http://localhost/phpmyadmin`
4. Klik tab **Import**, pilih file `database/db_perpustakaan.sql`, lalu **Go**
5. Buka `http://localhost/web_perpustakaan/`

Database `db_perpustakaan` beserta data contoh akan otomatis dibuat saat
di-import: 8 kategori, 7 buku, dan 4 transaksi peminjaman.

### Menyesuaikan Koneksi

Bila user atau password MySQL berbeda, ubah bagian atas `koneksi.php`:

```php
$host = "localhost";
$user = "root";
$pass = "";           // default XAMPP kosong
$db   = "db_perpustakaan";
```

Bila file dibuka langsung tanpa Apache (misal klik dua kali `index.php`),
aplikasi tidak akan berjalan — kode ini butuh server untuk memproses PHP.

---

## Catatan Teknis

### Catatan tentang screenshot

Screenshot di `assets/img/` diambil dari kondisi database saat dokumentasi
dibuat, yang isinya **sedikit berbeda** dari file `database/db_perpustakaan.sql`
(ada judul buku tambahan, dan jumlah transaksi peminjaman tidak sama). Screenshots
berfungsi sebagai ilustrasi tampilan, bukan dump data.

### Isu yang perlu diperbaiki

Beberapa hal berikut sudah berjalan, namun belum aman bila dipakai di server
nyata. Daftar ini sengaja dicatat sebagai bahan perbaikan:

**1. SQL Injection.** File `proses_tambahbuku.php`, `proses_editbuku.php`,
`proses_tambahpinjam.php`, `proses_editpinjam.php`, `hapus.php`, dan
`hapuspinjam.php` memasukkan `$_POST`/`$_GET` langsung ke dalam query tanpa
escaping. `edit.php` sudah memakai `mysqli_real_escape_string()`, tetapi
file-file proses belum. Perbaikannya:

```php
$judul = mysqli_real_escape_string($koneksi, $_POST['judul_buku']);
```

Alternatif yang lebih aman adalah memakai prepared statement (`mysqli_prepare`).

**2. `$_GET['id']` tanpa validasi.** `hapus.php`, `hapuspinjam.php`, dan
`editpinjam.php` langsung memakai `$_GET['id']` tanpa mengecek apakah
parameternya ada. `edit.php` sudah lebih aman karena memvalidasi
`isset($_GET['id'])`.

**3. XSS.** Nilai dari database dicetak ke HTML tanpa `htmlspecialchars()`,
contohnya `<?= $row['judul_buku']; ?>`. Judul buku berisi `<script>` akan
dieksekusi sebagai JavaScript.

**4. Password database tersimpan di dalam kode.** Nilai `$user` dan `$pass`
tert-commit ke repository. Untuk produksi, gunakan environment variable.

**5. Tidak ada autentikasi.** Semua orang yang dapat mengakses URL dapat
menambah, mengubah, dan menghapus data. Untuk digunakan di lingkungan nyata,
perlu ditambahkan login.

### Saran Pengembangan

- Gunakan prepared statement untuk seluruh query.
- Tambahkan pagination dan pencarian pada halaman daftar.
- Tambahkan kolom `tgl_kembali` serta fitur pengembalian buku.
- Samakan validasi `editpinjam.php` dengan `edit.php`.
- Gunakan `.env` atau environment variable untuk kredensial database.
- Tandai menu navigasi yang sedang aktif agar pengguna tahu posisi halaman.
- Ganti nama kelas `.credit` menjadi `.footer` agar sesuai fungsinya.
- Buat helper `redirect()` agar penulisan `header("Location: ...")` tidak
  berulang di enam file.
