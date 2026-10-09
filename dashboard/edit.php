<?php
include '../koneksi.php';
session_start();
if (!isset($_SESSION['admin'])) {
  header('location: ../login.php');
  exit();
}

/** @var mysqli $koneksi */
if (!isset($_GET['id'])) {
    header("location: dasbor.php");
    exit();
}

$id = $_GET['id'];
$stmt = mysqli_prepare($koneksi, "SELECT * FROM tb_produk WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    header("location: dasbor.php");
    exit();
}

if (isset($_POST['edit'])) {
    $nama_produk = $_POST['nama_produk'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $kategori = $_POST['kategori'];
    $deskripsi = $_POST['deskripsi'];
    
    $poto = $_FILES['poto']['name'];

    if (!empty($poto)) {
        $ext = strtolower(pathinfo($poto, PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($ext, $allowed)) {
            die("Hanya file gambar yang diizinkan!");
        }

        $path = "../assets/img/" . $poto;
        $file_tmp = $_FILES['poto']['tmp_name'];
        move_uploaded_file($file_tmp, $path);

        $stmtUpdate = mysqli_prepare($koneksi, "UPDATE tb_produk SET nama_produk=?, harga=?, stok=?, poto=?, id_kategori=?, deskripsi=? WHERE id=?");
        mysqli_stmt_bind_param($stmtUpdate, "siisisi", $nama_produk, $harga, $stok, $poto, $kategori, $deskripsi, $id);
    } else {
        $stmtUpdate = mysqli_prepare($koneksi, "UPDATE tb_produk SET nama_produk=?, harga=?, stok=?, id_kategori=?, deskripsi=? WHERE id=?");
        mysqli_stmt_bind_param($stmtUpdate, "siissi", $nama_produk, $harga, $stok, $kategori, $deskripsi, $id);
    }
    
    mysqli_stmt_execute($stmtUpdate);
    header("location: dasbor.php");
    exit();
}
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Edit Produk — Niskalla-Caffe</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Anton&family=Inter:wght@400;600;700&display=swap" rel="stylesheet" />
  <style>
    body { background-color: #F5F0E1; font-family: 'Inter', sans-serif; color: #2A2620; }
    .niskala-input { border: 1px solid #C9B89A; border-radius: 9999px; padding: 0.75rem 1.25rem; width: 100%; font-size: 0.875rem; background: rgba(237, 227, 204, 0.5); }
    .niskala-input:focus { border-color: #4A5D4A; outline: none; }
    .btn-moss { background: #4A5D4A; color: #F5F0E1; border-radius: 9999px; padding: 10px 24px; font-weight: 600; cursor: pointer; }
    .btn-moss:hover { background: #2D3F31; }
  </style>
</head>
<body class="min-h-screen p-8">
  <div class="max-w-2xl mx-auto bg-white/70 backdrop-blur-sm rounded-[28px] border border-[#C9B89A]/30 p-4 md:p-8 shadow-lg">
    <div class="mb-6">
      <h2 class="font-anton text-2xl uppercase tracking-wide text-[#2D3F31]">Edit Produk</h2>
    </div>
    <form action="" method="post" enctype="multipart/form-data" class="space-y-5">
      <div>
        <label class="block text-xs uppercase text-[#6B6357] font-semibold mb-2">Nama Produk</label>
        <input type="text" name="nama_produk" value="<?= htmlspecialchars($data['nama_produk']) ?>" required class="niskala-input">
      </div>
      <div>
        <label class="block text-xs uppercase text-[#6B6357] font-semibold mb-2">Harga</label>
        <input type="number" name="harga" value="<?= htmlspecialchars($data['harga']) ?>" required class="niskala-input">
      </div>
      <div>
        <label class="block text-xs uppercase text-[#6B6357] font-semibold mb-2">Stok</label>
        <input type="number" name="stok" value="<?= htmlspecialchars($data['stok']) ?>" required class="niskala-input">
      </div>
      <div>
        <label class="block text-xs uppercase text-[#6B6357] font-semibold mb-2">Kategori</label>
        <select name="kategori" required class="niskala-input">
          <?php
          $resKat = mysqli_query($koneksi, "SELECT * FROM tb_kategori");
          while ($k = mysqli_fetch_assoc($resKat)) {
              $sel = ($k['id_kategori'] == $data['id_kategori']) ? 'selected' : '';
              echo "<option value='{$k['id_kategori']}' $sel>{$k['nama_kategori']}</option>";
          }
          ?>
        </select>
      </div>
      <div>
        <label class="block text-xs uppercase text-[#6B6357] font-semibold mb-2">Foto Produk Baru (Kosongkan jika tidak diubah)</label>
        <input type="file" name="poto" accept="image/*" class="niskala-input">
      </div>
      <div>
        <label class="block text-xs uppercase text-[#6B6357] font-semibold mb-2">Deskripsi</label>
        <input type="text" name="deskripsi" value="<?= htmlspecialchars($data['deskripsi']) ?>" class="niskala-input">
      </div>
      <div class="pt-4 flex gap-4">
        <button type="submit" name="edit" class="btn-moss">Simpan Perubahan</button>
        <a href="dasbor.php" class="inline-flex items-center justify-center px-6 py-2.5 border border-[#4A5D4A] text-[#4A5D4A] rounded-full font-semibold hover:bg-[#4A5D4A] hover:text-[#F5F0E1] transition-colors">Batal</a>
      </div>
    </form>
  </div>
  <div class="md:hidden fixed bottom-0 left-0 w-full bg-cream border-t border-twig/30 flex justify-between px-6 py-2 z-50 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.05)]">
     <a href="dasbor.php" class="flex flex-col items-center text-mist hover:text-canopy">
        <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
        <span class="text-[10px] font-semibold">Produk</span>
     </a>
     <a href="transaksi.php" class="flex flex-col items-center text-mist hover:text-canopy">
        <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
        <span class="text-[10px] font-semibold">Transaksi</span>
     </a>
     <a href="customers.php" class="flex flex-col items-center text-mist hover:text-canopy">
        <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
        <span class="text-[10px] font-semibold">Pelanggan</span>
     </a>
     <a href="aktivitas.php" class="flex flex-col items-center text-mist hover:text-canopy">
        <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
        <span class="text-[10px] font-semibold">Aktivitas</span>
     </a>
     <a href="../logout.php" class="flex flex-col items-center text-rose hover:text-red-700">
        <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
        <span class="text-[10px] font-semibold">Logout</span>
     </a>
  </div>
</body>
</html>
