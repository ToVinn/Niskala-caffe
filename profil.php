<?php
session_start();
include 'koneksi.php';
/** @var mysqli $koneksi */

// Pastikan pengguna sudah login
if (!isset($_SESSION['id_user']) || !isset($_SESSION['pelanggan'])) {
    header('Location: login.php');
    exit();
}

$id_user = $_SESSION['id_user'];
$pesan = "";

// Jika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_profil'])) {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $hp = $_POST['hp'] ?? '';
    $alamat = $_POST['alamat'] ?? '';
    $password_baru = $_POST['password'] ?? '';
    
    if (!empty($password_baru)) {
        // Update termasuk password
        $stmt = mysqli_prepare($koneksi, "UPDATE tb_user SET name=?, email=?, hp=?, alamat=?, password=? WHERE id=?");
        mysqli_stmt_bind_param($stmt, "sssssi", $name, $email, $hp, $alamat, $password_baru, $id_user);
    } else {
        // Update tanpa ganti password
        $stmt = mysqli_prepare($koneksi, "UPDATE tb_user SET name=?, email=?, hp=?, alamat=? WHERE id=?");
        mysqli_stmt_bind_param($stmt, "ssssi", $name, $email, $hp, $alamat, $id_user);
    }
    
    if (mysqli_stmt_execute($stmt)) {
        $pesan = "<div class='mb-6 rounded-xl bg-leaf/15 border border-leaf/40 px-4 py-3 text-sm text-canopy font-medium'>Profil berhasil diperbarui.</div>";
    } else {
        $pesan = "<div class='mb-6 rounded-xl bg-rose/15 border border-rose/40 px-4 py-3 text-sm text-canopy font-medium'>Gagal memperbarui profil: " . mysqli_error($koneksi) . "</div>";
    }
}

// Ambil data user
$stmt = mysqli_prepare($koneksi, "SELECT * FROM tb_user WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id_user);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_array($result);

?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Profil Pembeli &mdash; Niskala Caffe</title>
  
  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Anton&family=Inter:wght@400;600;700&family=Poppins:wght@600;700&display=swap" rel="stylesheet" />

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            cream: '#F5F0E1',
            sand: '#E8DCC4',
            kraft: '#EDE3CC',
            canopy: '#2D3F31',
            moss: '#4A5D4A',
            leaf: '#7A8B6F',
            dew: '#A8B89E',
            bark: '#6B5444',
            clay: '#C4956A',
            rose: '#D88B96',
            amber: '#D4A04E',
            charcoal: '#2A2620',
            mist: '#6B6357',
            twig: '#C9B89A',
          },
          fontFamily: {
            anton: ['Anton', 'sans-serif'],
            inter: ['Inter', 'sans-serif'],
            poppins: ['Poppins', 'sans-serif'],
          },
        },
      },
    };
  </script>
</head>
<body class="min-h-screen font-inter" style="background: linear-gradient(180deg, #F5F0E1 0%, #E8DCC4 100%);">
  
  <!-- Navbar -->
  <nav class="sticky top-0 z-50 bg-cream/90 backdrop-blur-md border-b border-twig/30">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center h-20">
        <a href="index.php" class="font-poppins font-bold lowercase text-3xl text-canopy tracking-tight">
          Niskalla<span class="text-amber">Caffe</span>
        </a>
        <div class="flex items-center gap-4">
          <a href="index.php" class="text-sm font-semibold text-moss hover:text-canopy transition">Menu Utama</a>
          <a href="transaksi.php" class="text-sm font-semibold text-mist hover:text-moss transition">Riwayat</a>
          <a href="keranjang.php" class="relative text-canopy hover:text-moss transition">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
            <?php if(isset($_SESSION['cart']) && count($_SESSION['cart']) > 0): ?>
              <span class="absolute -top-1.5 -right-1.5 bg-rose text-white text-[10px] font-bold w-4 h-4 flex items-center justify-center rounded-full">
                <?= count($_SESSION['cart']) ?>
              </span>
            <?php endif; ?>
          </a>
          <a href="logout.php" class="text-sm font-semibold text-rose hover:text-red-700 transition">Logout</a>
        </div>
      </div>
    </div>
  </nav>

  <div class="max-w-3xl mx-auto py-12 px-4 sm:px-6">
    <div class="bg-white/70 backdrop-blur-sm rounded-[28px] border border-twig/30 overflow-hidden shadow-lg p-8 sm:p-12">
      <div class="text-center mb-10">
        <h1 class="font-anton text-4xl uppercase tracking-wide text-canopy mb-2">Profil Saya</h1>
        <p class="text-mist">Kelola informasi data diri dan alamat pengiriman Anda.</p>
      </div>

      <?= $pesan ?>

      <form method="POST" action="profil.php" class="space-y-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
          <div>
            <label class="block text-xs uppercase tracking-[0.15em] text-mist mb-2 font-semibold">Nama Lengkap</label>
            <input type="text" name="name" value="<?= htmlspecialchars($user['name'] ?? '') ?>" class="w-full rounded-full border border-twig bg-kraft/50 px-5 py-3 text-sm text-charcoal focus:border-moss focus:outline-none transition-all">
          </div>
          <div>
            <label class="block text-xs uppercase tracking-[0.15em] text-mist mb-2 font-semibold">Username</label>
            <input type="text" value="<?= htmlspecialchars($user['username'] ?? '') ?>" disabled class="w-full rounded-full border border-twig/50 bg-gray-100 px-5 py-3 text-sm text-mist cursor-not-allowed">
            <p class="text-[10px] text-mist mt-1 pl-3">Username tidak dapat diubah.</p>
          </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
          <div>
            <label class="block text-xs uppercase tracking-[0.15em] text-mist mb-2 font-semibold">Email</label>
            <input type="email" name="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>" required class="w-full rounded-full border border-twig bg-kraft/50 px-5 py-3 text-sm text-charcoal focus:border-moss focus:outline-none transition-all">
          </div>
          <div>
            <label class="block text-xs uppercase tracking-[0.15em] text-mist mb-2 font-semibold">Nomor WhatsApp / HP</label>
            <input type="text" name="hp" value="<?= htmlspecialchars($user['hp'] ?? '') ?>" placeholder="Contoh: 08123456789" class="w-full rounded-full border border-twig bg-kraft/50 px-5 py-3 text-sm text-charcoal focus:border-moss focus:outline-none transition-all">
          </div>
        </div>

        <div>
          <label class="block text-xs uppercase tracking-[0.15em] text-mist mb-2 font-semibold">Alamat Lengkap</label>
          <textarea name="alamat" rows="3" placeholder="Masukkan alamat lengkap Anda..." class="w-full rounded-2xl border border-twig bg-kraft/50 px-5 py-3 text-sm text-charcoal focus:border-moss focus:outline-none transition-all"><?= htmlspecialchars($user['alamat'] ?? '') ?></textarea>
        </div>

        <div>
          <label class="block text-xs uppercase tracking-[0.15em] text-mist mb-2 font-semibold">Password Baru (Opsional)</label>
          <input type="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah password" class="w-full rounded-full border border-twig bg-kraft/50 px-5 py-3 text-sm text-charcoal focus:border-moss focus:outline-none transition-all">
        </div>

        <div class="pt-4 border-t border-twig/30 flex justify-end">
          <button type="submit" name="update_profil" class="bg-moss hover:bg-canopy text-cream px-8 py-3 rounded-full text-sm font-bold tracking-wide transition-all shadow-md shadow-moss/20 hover:shadow-lg hover:-translate-y-0.5">
            Simpan Perubahan
          </button>
        </div>
      </form>
    </div>
  </div>

</body>
</html>