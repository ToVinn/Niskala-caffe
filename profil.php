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
    
    // Proses upload foto jika ada
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $foto = $_FILES['foto']['name'];
        $ext = strtolower(pathinfo($foto, PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($ext, $allowed)) {
            $foto_baru = time() . '_' . rand(100,999) . '.' . $ext;
            $path = "assets/img/users/" . $foto_baru;
            if (move_uploaded_file($_FILES['foto']['tmp_name'], $path)) {
                $stmtFoto = mysqli_prepare($koneksi, "UPDATE tb_user SET foto=? WHERE id=?");
                mysqli_stmt_bind_param($stmtFoto, "si", $foto_baru, $id_user);
                mysqli_stmt_execute($stmtFoto);
            }
        }
    }
    
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
<body class="min-h-screen font-inter overflow-x-hidden" style="background: linear-gradient(180deg, #F5F0E1 0%, #E8DCC4 100%);">
  
  <!-- Navbar -->
  <nav class="sticky top-0 z-50 bg-cream/90 backdrop-blur-md border-b border-twig/30">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center h-20">
        <a href="index.php" class="font-poppins font-bold lowercase text-2xl md:text-3xl text-canopy tracking-tight">
          Niskalla<span class="text-amber">Caffe</span>
        </a>
        <div class="hidden md:flex items-center gap-4">
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

  <div class="max-w-3xl mx-auto py-8 md:py-12 px-4 sm:px-6 pb-28 md:pb-12">
    <div class="bg-white/70 backdrop-blur-sm rounded-[28px] border border-twig/30 overflow-hidden shadow-lg p-6 sm:p-12">
      <div class="text-center mb-10">
        <h1 class="font-anton text-4xl uppercase tracking-wide text-canopy mb-2">Profil Saya</h1>
        <p class="text-mist">Kelola informasi data diri dan alamat pengiriman Anda.</p>
      </div>

      <?= $pesan ?>

      <form method="POST" action="profil.php" enctype="multipart/form-data" class="space-y-8">
        
        <!-- Avatar Section -->
        <div class="flex flex-col items-center justify-center">
          <div class="relative w-28 h-28 mb-3 group">
            <div class="w-full h-full rounded-full overflow-hidden border-4 border-twig/30 bg-sand/50 shadow-md">
              <?php $firstChar = strtoupper(substr($user['name'] ?? 'U', 0, 1)); ?>
              <img src="<?= !empty($user['foto']) ? 'assets/img/users/'.htmlspecialchars($user['foto']) : 'https://placehold.co/200x200/E8DCC4/6B6357?text='.$firstChar ?>" class="w-full h-full object-cover object-center" id="avatarPreview">
            </div>
            <label for="foto" class="absolute bottom-0 right-0 w-8 h-8 bg-moss text-cream rounded-full flex items-center justify-center border-2 border-white cursor-pointer shadow-sm hover:bg-canopy hover:scale-105 transition-all" title="Ubah Foto">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
            </label>
            <input type="file" id="foto" name="foto" accept="image/png, image/jpeg, image/jpg" class="hidden" onchange="previewImage(this)">
          </div>
          <p class="text-[10px] text-mist uppercase tracking-widest font-semibold">Foto Profil</p>
        </div>

        <script>
          function previewImage(input) {
            if (input.files && input.files[0]) {
              var reader = new FileReader();
              reader.onload = function(e) {
                document.getElementById('avatarPreview').src = e.target.result;
              }
              reader.readAsDataURL(input.files[0]);
            }
          }
        </script>

        <!-- Informasi Pribadi Card -->
        <div class="bg-sand/20 border border-twig/30 p-6 md:p-8 rounded-3xl space-y-6">
          <h2 class="font-anton text-xl tracking-wide text-canopy border-b border-twig/30 pb-3">Informasi Pribadi</h2>
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
              <label class="block text-xs uppercase tracking-[0.15em] text-mist mb-2 font-semibold">Nama Lengkap</label>
              <input type="text" name="name" value="<?= htmlspecialchars($user['name'] ?? '') ?>" class="w-full rounded-full border border-twig/70 bg-white px-5 py-3 text-sm text-charcoal focus:border-moss focus:outline-none transition-all shadow-sm">
            </div>
            <div>
              <label class="block text-xs uppercase tracking-[0.15em] text-mist mb-2 font-semibold">Username</label>
              <input type="text" value="<?= htmlspecialchars($user['username'] ?? '') ?>" disabled class="w-full rounded-full border border-twig/30 bg-gray-100/50 px-5 py-3 text-sm text-mist cursor-not-allowed">
              <p class="text-[10px] text-mist mt-1 pl-3">Username tidak dapat diubah.</p>
            </div>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
              <label class="block text-xs uppercase tracking-[0.15em] text-mist mb-2 font-semibold">Email</label>
              <input type="email" name="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>" required class="w-full rounded-full border border-twig/70 bg-white px-5 py-3 text-sm text-charcoal focus:border-moss focus:outline-none transition-all shadow-sm">
            </div>
            <div>
              <label class="block text-xs uppercase tracking-[0.15em] text-mist mb-2 font-semibold">Nomor WhatsApp / HP</label>
              <input type="text" name="hp" value="<?= htmlspecialchars($user['hp'] ?? '') ?>" placeholder="Contoh: 08123456789" class="w-full rounded-full border border-twig/70 bg-white px-5 py-3 text-sm text-charcoal focus:border-moss focus:outline-none transition-all shadow-sm">
            </div>
          </div>

          <div>
            <label class="block text-xs uppercase tracking-[0.15em] text-mist mb-2 font-semibold">Alamat Lengkap</label>
            <textarea name="alamat" rows="3" placeholder="Masukkan alamat lengkap Anda..." class="w-full rounded-2xl border border-twig/70 bg-white px-5 py-3 text-sm text-charcoal focus:border-moss focus:outline-none transition-all shadow-sm"><?= htmlspecialchars($user['alamat'] ?? '') ?></textarea>
          </div>
        </div>

        <!-- Keamanan Card -->
        <div class="bg-sand/20 border border-twig/30 p-6 md:p-8 rounded-3xl space-y-6">
          <h2 class="font-anton text-xl tracking-wide text-canopy border-b border-twig/30 pb-3">Keamanan</h2>
          <div>
            <label class="block text-xs uppercase tracking-[0.15em] text-mist mb-2 font-semibold">Password Baru (Opsional)</label>
            <input type="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah password" class="w-full rounded-full border border-twig/70 bg-white px-5 py-3 text-sm text-charcoal focus:border-moss focus:outline-none transition-all shadow-sm">
          </div>
        </div>

        <div class="pt-4 flex justify-end">
          <button type="submit" name="update_profil" class="bg-moss hover:bg-canopy text-cream px-8 py-3 rounded-full text-sm font-bold tracking-wide transition-all shadow-lg shadow-moss/30 hover:shadow-xl hover:-translate-y-0.5 w-full sm:w-auto">
            Simpan Perubahan
          </button>
        </div>
      </form>
      <div class="mt-8 text-center md:hidden">
        <a href="logout.php" class="text-sm font-semibold text-rose hover:text-red-700 transition underline">Logout Akun</a>
      </div>
    </div>
  </div>

  <!-- Bottom Nav (Mobile Only) -->
  <div class="md:hidden fixed bottom-0 left-0 w-full bg-cream border-t border-twig/30 flex justify-between px-8 py-2 z-50 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.05)]">
     <a href="index.php" class="flex flex-col items-center text-mist hover:text-canopy">
        <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
        <span class="text-[10px] font-semibold">Home</span>
     </a>
     <a href="keranjang.php" class="flex flex-col items-center text-mist hover:text-canopy">
        <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
        <span class="text-[10px] font-semibold">Order</span>
     </a>
     <a href="transaksi.php" class="flex flex-col items-center text-mist hover:text-canopy">
        <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
        <span class="text-[10px] font-semibold">Riwayat</span>
     </a>
     <a href="profil.php" class="flex flex-col items-center text-canopy">
        <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
        <span class="text-[10px] font-semibold">Profile</span>
     </a>
  </div>

</body>
</html>