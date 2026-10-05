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

if (isset($_POST['simpan_stok'])) {
    $stok_baru = (int)$_POST['stok'];
    $stok_lama = (int)$data['stok'];
    $selisih = $stok_baru - $stok_lama;
    
    if ($selisih != 0) {
        $stmtInsert = mysqli_prepare($koneksi, "INSERT INTO tb_stok_masuk (id_produk, jumlah) VALUES (?, ?)");
        mysqli_stmt_bind_param($stmtInsert, "ii", $id, $selisih);
        mysqli_stmt_execute($stmtInsert);
    }
    
    header("location: dasbor.php");
    exit();
}
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Ubah Stok — Niskalla-Caffe</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Anton&family=Inter:wght@400;600;700&display=swap" rel="stylesheet" />
  <style>
    body { background-color: #F5F0E1; font-family: 'Inter', sans-serif; color: #2A2620; }
    .btn-moss { background: #4A5D4A; color: #F5F0E1; border-radius: 9999px; padding: 10px 24px; font-weight: 600; cursor: pointer; }
    .btn-moss:hover { background: #2D3F31; }
    .stok-btn { width: 40px; height: 40px; border-radius: 9999px; background: #C9B89A; color: #2A2620; font-weight: bold; font-size: 1.25rem; display: flex; align-items: center; justify-content: center; cursor: pointer; border: none; }
    .stok-btn:hover { background: #A8B89E; }
    .stok-input { border: 1px solid #C9B89A; border-radius: 9999px; text-align: center; width: 120px; font-size: 1.25rem; font-weight: bold; background: rgba(237, 227, 204, 0.5); padding: 0.5rem; }
    .stok-input:focus { border-color: #4A5D4A; outline: none; }
    input[type=number]::-webkit-inner-spin-button, input[type=number]::-webkit-outer-spin-button { -webkit-appearance: none; margin: 0; }
  </style>
</head>
<body class="min-h-screen p-8 flex items-center justify-center">
  <div class="w-full max-w-md bg-white/70 backdrop-blur-sm rounded-[28px] border border-[#C9B89A]/30 p-8 shadow-lg text-center">
    <div class="mb-6">
      <h2 class="font-anton text-2xl uppercase tracking-wide text-[#2D3F31]">Ubah Stok</h2>
      <p class="text-[#6B6357] font-semibold mt-2"><?= htmlspecialchars($data['nama_produk']) ?></p>
    </div>
    <form action="" method="post">
      <div class="flex items-center justify-center gap-4 mb-8">
        <button type="button" class="stok-btn" onclick="kurang()">-</button>
        <input type="number" id="stok" name="stok" value="<?= htmlspecialchars($data['stok']) ?>" required class="stok-input">
        <button type="button" class="stok-btn" onclick="tambah()">+</button>
      </div>
      <div class="flex gap-4 justify-center">
        <button type="submit" name="simpan_stok" class="btn-moss w-full">Simpan</button>
        <a href="dasbor.php" class="inline-flex items-center justify-center px-6 py-2.5 border border-[#4A5D4A] text-[#4A5D4A] rounded-full font-semibold hover:bg-[#4A5D4A] hover:text-[#F5F0E1] transition-colors w-full">Batal</a>
      </div>
    </form>
  </div>
  <script>
    const inputStok = document.getElementById('stok');
    function tambah() {
      inputStok.value = parseInt(inputStok.value || 0) + 1;
    }
    function kurang() {
      let val = parseInt(inputStok.value || 0);
      if (val > 0) {
        inputStok.value = val - 1;
      }
    }
  </script>
</body>
</html>