<?php
include 'koneksi.php';
/** @var mysqli $koneksi */

if (isset($_POST['register'])) {

    $name     = $_POST['name'];
    $username = $_POST['username'];
    $email    = $_POST['email'];
    $hp       = $_POST['hp'];
    $alamat   = $_POST['alamat'];
    $password = $_POST['password'];

        $stmt = mysqli_prepare($koneksi, "INSERT INTO tb_user (name, username, password, email, hp, alamat, role) VALUES (?, ?, ?, ?, ?, ?, 'pelanggan')");
        mysqli_stmt_bind_param($stmt, "ssssss", $name, $username, $password, $email, $hp, $alamat);
        $register = mysqli_stmt_execute($stmt);

        if ($register) {
            echo "<script>
                alert('Mantap, berhasil daftar!');
                window.location.href = 'login.php';
            </script>";
        } else {
            $error = "Gagal mendaftar, silakan coba lagi!";
        }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="description" content="Daftar akun baru Niskalla Caffe" />
  <meta name="theme-color" content="#2D3F31" />
  <title>Registrasi — Niskalla Caffe</title>

  <!-- Google Fonts: Anton + Inter + Poppins -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Anton&family=Caveat:wght@400;600&family=Inter:wght@400;600;700&family=Poppins:wght@600;700&display=swap" rel="stylesheet" />

  <!-- Tailwind CSS via CDN -->
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
            anton: ['Anton', 'Impact', 'sans-serif'],
            inter: ['Inter', 'sans-serif'],
            poppins: ['Poppins', 'sans-serif'],
          },
          borderRadius: {
            squircle: '28px',
          },
        },
      },
    };
  </script>
</head>

<body class="min-h-screen flex items-center justify-center py-16 px-5" style="background: linear-gradient(180deg, #F5F0E1 0%, #E8DCC4 45%, #A8B89E 100%);">
  
  <!-- Background decoration -->
  <div class="fixed inset-0 overflow-hidden pointer-events-none" aria-hidden="true">
    <div class="absolute top-20 right-10 w-72 h-72 bg-dew/20 rounded-full blur-3xl"></div>
    <div class="absolute bottom-20 left-10 w-96 h-96 bg-leaf/15 rounded-full blur-3xl"></div>
  </div>

  <div class="w-full max-w-md relative z-10">
    <!-- Card Register -->
    <div class="bg-cream/95 backdrop-blur-sm rounded-[28px] p-8 shadow-2xl border border-twig/30">
      <!-- Logo -->
      <div class="text-center mb-8">
        <a href="index.php" class="font-poppins font-bold lowercase text-4xl text-canopy">Niskalla<span class="text-amber">Caffe</span></a>
        <p class="font-bold uppercase tracking-[0.15em] text-[11px] text-mist mt-2">Buat Akun Baru</p>
      </div>

      <?php if (isset($error) && $error): ?>
        <div class="mb-6 rounded-xl bg-rose/15 border border-rose/40 px-4 py-3 text-sm text-canopy">
          <?= htmlspecialchars($error) ?>
        </div>
      <?php endif; ?>

      <form method="POST" action="" class="space-y-4">
        <div>
          <label class="block text-xs uppercase tracking-[0.15em] text-mist mb-1.5 font-semibold">Nama Lengkap *</label>
          <input type="text" name="name" required 
                 placeholder="Masukkan nama lengkap"
                 class="w-full rounded-full border border-twig bg-kraft/50 px-5 py-3.5 text-sm text-charcoal focus:border-moss focus:outline-none focus:ring-2 focus:ring-dew/60 transition-all">
        </div>

        <div>
          <label class="block text-xs uppercase tracking-[0.15em] text-mist mb-1.5 font-semibold">Username *</label>
          <input type="text" name="username" required 
                 placeholder="Minimal 3 karakter"
                 class="w-full rounded-full border border-twig bg-kraft/50 px-5 py-3.5 text-sm text-charcoal focus:border-moss focus:outline-none focus:ring-2 focus:ring-dew/60 transition-all">
        </div>

        <div>
          <label class="block text-xs uppercase tracking-[0.15em] text-mist mb-1.5 font-semibold">Email *</label>
          <input type="email" name="email" required
                 placeholder="contoh@email.com"
                 class="w-full rounded-full border border-twig bg-kraft/50 px-5 py-3.5 text-sm text-charcoal focus:border-moss focus:outline-none focus:ring-2 focus:ring-dew/60 transition-all">
        </div>

        <div>
          <label class="block text-xs uppercase tracking-[0.15em] text-mist mb-1.5 font-semibold">No HP</label>
          <input type="text" name="hp"
                 placeholder="08xxxxxxxxxx"
                 class="w-full rounded-full border border-twig bg-kraft/50 px-5 py-3.5 text-sm text-charcoal focus:border-moss focus:outline-none focus:ring-2 focus:ring-dew/60 transition-all">
        </div>

        <div>
          <label class="block text-xs uppercase tracking-[0.15em] text-mist mb-1.5 font-semibold">Alamat</label>
          <input type="text" name="alamat"
                 placeholder="Alamat lengkap"
                 class="w-full rounded-full border border-twig bg-kraft/50 px-5 py-3.5 text-sm text-charcoal focus:border-moss focus:outline-none focus:ring-2 focus:ring-dew/60 transition-all">
        </div>

        <div>
          <label class="block text-xs uppercase tracking-[0.15em] text-mist mb-1.5 font-semibold">Password *</label>
          <div class="relative">
            <input type="password" name="password" required 
                   id="password-input"
                   placeholder="Minimal 6 karakter"
                   class="w-full rounded-full border border-twig bg-kraft/50 px-5 py-3.5 pr-12 text-sm text-charcoal focus:border-moss focus:outline-none focus:ring-2 focus:ring-dew/60 transition-all">
            <button type="button" onclick="togglePassword()" 
                    class="absolute right-4 top-1/2 -translate-y-1/2 text-mist hover:text-charcoal transition-colors"
                    aria-label="Tampilkan password">
              <svg id="eye-icon" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                <circle cx="12" cy="12" r="3"/>
              </svg>
            </button>
          </div>
        </div>

        <button type="submit" name="register"
                class="w-full rounded-full bg-moss px-6 py-3.5 text-sm font-semibold uppercase tracking-[0.12em] text-cream shadow-md shadow-moss/25 hover:scale-[1.02] hover:bg-canopy transition-all duration-300 mt-4">
          Daftar Sekarang
        </button>
      </form>

      <!-- Link Login -->
      <div class="mt-6 text-center">
        <p class="text-sm text-mist">
          Sudah punya akun? 
          <a href="login.php" class="font-semibold text-moss hover:text-canopy hover:underline transition-colors">Login di Sini</a>
        </p>
      </div>

      <div class="mt-8 pt-6 border-t border-twig/30">
        <p class="mt-4 text-center">
          <a href="index.php" class="text-xs text-mist hover:text-moss transition-colors inline-flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Beranda
          </a>
        </p>
      </div>
    </div>
    
    <!-- Footer text -->
    <p class="mt-6 text-center text-xs text-mist/70">© <?= date('Y') ?> Niskalla Caffe</p>
  </div>

<script>
// Toggle password visibility
function togglePassword() {
  const input = document.getElementById('password-input');
  const icon = document.getElementById('eye-icon');
  
  if (input.type === 'password') {
    input.type = 'text';
    icon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>';
  } else {
    input.type = 'password';
    icon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
  }
}
</script>

</body>
</html>
