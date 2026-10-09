<?php
session_start();
include 'koneksi.php';
/** @var mysqli $koneksi */
?>
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="description" content="Niskalla Caffe - Taste Everything" />
  <meta name="theme-color" content="#2D3F31" />
  <title>Niskalla Caffe</title>

  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Anton&family=Caveat:wght@400;600&family=Inter:wght@400;600;700&family=Poppins:wght@600;700&display=swap" rel="stylesheet" />

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
        },
      },
    };
  </script>
  <style>
    /* Hide scrollbar for Chrome, Safari and Opera */
    .no-scrollbar::-webkit-scrollbar {
      display: none;
    }
    /* Hide scrollbar for IE, Edge and Firefox */
    .no-scrollbar {
      -ms-overflow-style: none;  /* IE and Edge */
      scrollbar-width: none;  /* Firefox */
    }
  </style>
</head>
<body class="bg-cream text-charcoal font-inter antialiased overflow-x-hidden">

  <!-- MOBILE UI (Home Screen) -->
  <div class="md:hidden pb-24 font-inter bg-cream min-h-screen">
    <!-- Top Header -->
    <div class="px-5 pt-8 pb-4">
      <h1 class="text-3xl font-bold mb-6 text-canopy">Good Morning,<br><span class="text-amber"><?= isset($_SESSION['pelanggan']) ? htmlspecialchars($_SESSION['pelanggan']) : 'Pelanggan' ?></span></h1>
      
      <!-- Search -->
      <form method="GET" action="index.php" class="relative mb-6">
        <input type="text" name="search" placeholder="Search your favorite coffee..." class="w-full bg-white border border-twig/30 rounded-full py-3 pl-12 pr-10 focus:outline-none focus:border-moss text-sm shadow-sm">
        <svg class="w-5 h-5 absolute left-4 top-3.5 text-mist" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        <button type="submit" class="absolute right-4 top-3.5 text-mist hover:text-moss transition">
           <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/></svg>
        </button>
      </form>
    </div>

    <!-- Categories -->
    <?php
    $kat_mobile = isset($_GET['kategori_search']) ? $_GET['kategori_search'] : '';
    $search_mobile = isset($_GET['search']) ? $_GET['search'] : '';
    $is_searching_mobile = ($kat_mobile != '' || $search_mobile != '');
    ?>
    <div class="px-5 mb-6 overflow-x-auto no-scrollbar snap-x snap-mandatory">
      <div class="flex gap-3">
        <a href="index.php" class="snap-start px-5 py-2.5 rounded-full text-sm font-semibold whitespace-nowrap flex flex-row items-center gap-2 border shadow-sm transition <?= ($kat_mobile == '') ? 'bg-moss text-cream border-moss' : 'border-twig/50 bg-white text-canopy hover:border-moss hover:bg-moss/5' ?>">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
          All
        </a>
        <?php
        $mobileKat = mysqli_query($koneksi, "SELECT * FROM tb_kategori LIMIT 4");
        while($k = mysqli_fetch_array($mobileKat)):
            $is_active = ($kat_mobile == $k['id_kategori']);
        ?>
        <a href="index.php?kategori_search=<?= $k['id_kategori'] ?>" class="snap-start px-5 py-2.5 rounded-full text-sm font-semibold whitespace-nowrap flex flex-row items-center gap-2 border transition shadow-sm <?= $is_active ? 'bg-moss text-cream border-moss' : 'border-twig/50 bg-white text-canopy hover:border-moss hover:bg-moss/5' ?>">
           <svg class="w-5 h-5 <?= $is_active ? 'text-cream' : 'text-amber' ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
           <?= htmlspecialchars($k['nama_kategori']) ?>
        </a>
        <?php endwhile; ?>
      </div>
    </div>

    <?php if (!$is_searching_mobile): ?>
    <!-- Popular Now -->
    <div class="px-5 mb-8">
      <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-bold text-canopy">Popular Now</h2>
        <a href="index.php?search=" class="text-sm text-mist font-semibold">View all</a>
      </div>
      <div class="flex gap-4 overflow-x-auto no-scrollbar pb-2 snap-x snap-mandatory">
        <?php
        $populer = mysqli_query($koneksi, "SELECT * FROM tb_produk LIMIT 4");
        while($p = mysqli_fetch_array($populer)):
        ?>
        <div class="snap-start min-w-[160px] max-w-[160px] bg-white rounded-2xl border border-twig/30 overflow-hidden shrink-0 shadow-sm relative flex flex-col">
          <div class="h-32 bg-sand/30 relative">
             <img src="assets/img/<?= htmlspecialchars($p['poto']) ?>" class="w-full h-full object-cover" onerror="this.src='https://placehold.co/200x200/E8DCC4/6B6357?text=No+Image'">
          </div>
          <div class="p-3 flex flex-col flex-1">
             <h3 class="font-bold text-sm text-canopy truncate"><?= htmlspecialchars($p['nama_produk']) ?></h3>
             <p class="text-xs text-mist mb-3 truncate flex-1"><?= htmlspecialchars($p['deskripsi'] ?: 'Kopi nikmat Niskala') ?></p>
             <div class="flex justify-between items-center mt-auto">
                <span class="font-bold text-sm text-moss">Rp <?= number_format($p['harga'], 0, ',', '.') ?></span>
                <a href="detail.php?id=<?= $p['id'] ?>" class="w-6 h-6 bg-amber text-white rounded-full flex items-center justify-center font-bold text-lg leading-none">+</a>
             </div>
          </div>
        </div>
        <?php endwhile; ?>
      </div>
    </div>

    <!-- Special For You -->
    <div class="px-5">
      <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-bold text-canopy">Special For You</h2>
        <a href="index.php?search=" class="text-sm text-mist font-semibold">View all</a>
      </div>
      <div class="flex flex-col gap-4">
        <?php
        $special = mysqli_query($koneksi, "SELECT * FROM tb_produk ORDER BY id DESC LIMIT 3");
        while($p = mysqli_fetch_array($special)):
        ?>
        <a href="detail.php?id=<?= $p['id'] ?>" class="bg-white rounded-2xl border border-twig/30 p-3 flex gap-4 shadow-sm items-center">
           <div class="w-20 h-20 bg-sand/30 rounded-xl overflow-hidden shrink-0">
               <img src="assets/img/<?= htmlspecialchars($p['poto']) ?>" class="w-full h-full object-cover" onerror="this.src='https://placehold.co/100x100/E8DCC4/6B6357?text=Img'">
           </div>
           <div class="flex-1 overflow-hidden">
               <h3 class="font-bold text-base text-canopy truncate"><?= htmlspecialchars($p['nama_produk']) ?></h3>
               <p class="text-xs text-mist mb-2 truncate">Racikan spesial untuk Anda.</p>
               <span class="font-bold text-sm text-moss">Rp <?= number_format($p['harga'], 0, ',', '.') ?></span>
           </div>
        </a>
        <?php endwhile; ?>
      </div>
    </div>
    
    <?php else: ?>
    <!-- Search / Filter Results -->
    <div class="px-5">
      <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-bold text-canopy">Hasil Pencarian</h2>
      </div>
      <div class="flex flex-col gap-4">
        <?php
        $where_mobile = "1=1";
        if ($search_mobile != '') {
            $sm = mysqli_real_escape_string($koneksi, $search_mobile);
            $where_mobile .= " AND nama_produk LIKE '%$sm%'";
        }
        if ($kat_mobile != '') {
            $km = mysqli_real_escape_string($koneksi, $kat_mobile);
            $where_mobile .= " AND id_kategori = '$km'";
        }
        
        $queryHasil = mysqli_query($koneksi, "SELECT * FROM tb_produk WHERE $where_mobile");
        
        if(mysqli_num_rows($queryHasil) > 0):
            while($p = mysqli_fetch_array($queryHasil)):
        ?>
        <a href="detail.php?id=<?= $p['id'] ?>" class="bg-white rounded-2xl border border-twig/30 p-3 flex gap-4 shadow-sm items-center">
           <div class="w-20 h-20 bg-sand/30 rounded-xl overflow-hidden shrink-0">
               <img src="assets/img/<?= htmlspecialchars($p['poto']) ?>" class="w-full h-full object-cover" onerror="this.src='https://placehold.co/100x100/E8DCC4/6B6357?text=Img'">
           </div>
           <div class="flex-1 overflow-hidden">
               <h3 class="font-bold text-base text-canopy truncate"><?= htmlspecialchars($p['nama_produk']) ?></h3>
               <p class="text-xs text-mist mb-2 truncate"><?= htmlspecialchars($p['deskripsi'] ?: 'Kopi nikmat Niskala') ?></p>
               <span class="font-bold text-sm text-moss">Rp <?= number_format($p['harga'], 0, ',', '.') ?></span>
           </div>
        </a>
        <?php 
            endwhile;
        else:
        ?>
        <div class="text-center py-10 bg-white rounded-2xl border border-twig/30">
          <p class="text-mist text-sm">Oops! Menu tidak ditemukan.</p>
        </div>
        <?php endif; ?>
      </div>
    </div>
    <?php endif; ?>

  </div>

  <!-- Bottom Nav (Mobile Only) -->
  <div class="md:hidden fixed bottom-0 left-0 w-full bg-cream border-t border-twig/30 flex justify-between px-8 py-2 z-50">
     <a href="index.php" class="flex flex-col items-center text-canopy">
        <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
        <span class="text-[10px] font-semibold">Home</span>
     </a>
     <a href="keranjang.php" class="flex flex-col items-center text-mist hover:text-canopy">
        <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
        <span class="text-[10px] font-semibold">Order</span>
     </a>
     <?php if (isset($_SESSION['pelanggan'])): ?>
     <a href="transaksi.php" class="flex flex-col items-center text-mist hover:text-canopy">
        <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
        <span class="text-[10px] font-semibold">Riwayat</span>
     </a>
     <?php else: ?>
     <a href="login.php" class="flex flex-col items-center text-mist hover:text-canopy">
        <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
        <span class="text-[10px] font-semibold">Login</span>
     </a>
     <?php endif; ?>
     <a href="profil.php" class="flex flex-col items-center text-mist hover:text-canopy">
        <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
        <span class="text-[10px] font-semibold">Profile</span>
     </a>
  </div>

  <!-- DESKTOP UI WRAPPER -->
  <div class="hidden md:block">

  <!-- Navbar -->
  <nav class="sticky top-0 z-50 bg-cream/90 backdrop-blur-md border-b border-twig/30">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center h-20">
        <!-- Logo -->
        <a href="index.php" class="font-poppins font-bold lowercase text-2xl md:text-3xl text-canopy tracking-tight">
          Niskalla<span class="text-amber">Caffe</span>
        </a>
        
        <!-- Menu -->
        <div class="flex flex-wrap items-center gap-2 sm:gap-4">
          <?php if (isset($_SESSION['pelanggan'])): ?>
            <a href="transaksi.php" class="text-sm font-semibold text-mist hover:text-moss transition">Riwayat</a>
          <?php endif; ?>
          <a href="keranjang.php" class="relative text-canopy hover:text-moss transition">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
            <?php if(isset($_SESSION['cart']) && count($_SESSION['cart']) > 0): ?>
              <span class="absolute -top-1.5 -right-1.5 bg-rose text-white text-[10px] font-bold w-4 h-4 flex items-center justify-center rounded-full">
                <?= count($_SESSION['cart']) ?>
              </span>
            <?php endif; ?>
          </a>
          
          <?php if (isset($_SESSION['admin'])): ?>
            <a href="dashboard/dasbor.php" class="text-sm font-semibold text-moss hover:text-canopy transition">Dashboard</a>
            <a href="logout.php" class="text-sm font-semibold text-rose hover:text-red-700 transition">Logout</a>
          <?php elseif (isset($_SESSION['pelanggan'])): ?>
            <a href="profil.php" class="text-xs sm:text-sm font-medium text-moss hover:text-canopy transition font-semibold truncate max-w-[80px] sm:max-w-[150px] md:max-w-none inline-block align-bottom">Halo, <?= htmlspecialchars($_SESSION['pelanggan']) ?></a>
            <a href="logout.php" class="text-sm font-semibold text-rose hover:text-red-700 transition">Logout</a>
          <?php else: ?>
            <a href="login.php" class="text-sm font-semibold text-moss hover:text-canopy transition">Login</a>
            <a href="register.php" class="bg-moss hover:bg-canopy text-cream px-3 py-1.5 md:px-5 md:py-2.5 rounded-full text-xs md:text-sm font-semibold tracking-wide transition-all shadow-md shadow-moss/20 hover:shadow-lg hover:-translate-y-0.5">Daftar</a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </nav>

  <!-- Carousel Hero Section -->
  <header class="relative overflow-hidden pt-24 pb-32">
    <!-- Background Decor -->
    <div class="absolute top-0 right-0 -translate-y-12 translate-x-1/3 w-[600px] h-[600px] bg-dew/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 translate-y-1/3 -translate-x-1/3 w-[500px] h-[500px] bg-amber/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="relative w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 z-10">
      <!-- Carousel Container -->
      <div id="carousel" class="relative overflow-hidden rounded-2xl bg-white/40 border border-twig/20 shadow-xl">
        <div id="carousel-inner" class="flex transition-transform duration-500 ease-in-out">
          
          <?php
          $queryCarousel = mysqli_query($koneksi, "SELECT * FROM tb_produk WHERE stok > 0 ORDER BY RAND() LIMIT 3");
          $slidesCount = mysqli_num_rows($queryCarousel);
          if ($slidesCount > 0):
            while ($slide = mysqli_fetch_assoc($queryCarousel)):
          ?>
          <!-- Dynamic Slide -->
          <div class="min-w-full flex-shrink-0 flex flex-col md:flex-row items-center p-8 md:p-12 gap-8 text-center md:text-left">
            <div class="flex-1 md:w-1/2">
              <p class="font-poppins text-amber font-bold tracking-[0.2em] uppercase text-sm mb-4">Rekomendasi Kami</p>
              <h1 class="font-anton text-4xl sm:text-5xl md:text-6xl text-canopy uppercase tracking-wide mb-4 line-clamp-2">
                <?= htmlspecialchars($slide['nama_produk']) ?>
              </h1>
              <p class="font-poppins text-2xl text-moss font-bold mb-4">Rp <?= number_format($slide['harga'], 0, ',', '.') ?></p>
              <p class="text-mist md:text-lg mb-8 leading-relaxed line-clamp-3">
                <?= htmlspecialchars($slide['deskripsi'] ?: 'Nikmati racikan spesial dari Niskalla Caffe. Dibuat dengan bahan premium untuk cita rasa tak terlupakan.') ?>
              </p>
              <a href="detail.php?id=<?= $slide['id'] ?>" class="inline-flex items-center gap-2 bg-canopy hover:bg-moss text-cream px-8 py-4 rounded-full font-bold uppercase tracking-widest text-sm transition-all shadow-xl shadow-canopy/20 hover:scale-105">
                Lihat Detail
              </a>
            </div>
            <div class="flex-1 md:w-1/2 flex justify-center">
              <div class="w-64 h-64 md:w-80 md:h-80 rounded-full overflow-hidden border-4 border-white/50 shadow-2xl">
                <img src="assets/img/<?= htmlspecialchars($slide['poto']) ?>" alt="<?= htmlspecialchars($slide['nama_produk']) ?>" class="w-full h-full object-cover hover:scale-110 transition-transform duration-500" onerror="this.src='https://placehold.co/400x300/E8DCC4/6B6357?text=No+Image'">
              </div>
            </div>
          </div>
          <?php 
            endwhile;
          else:
          ?>
          <!-- Default Slide if no products -->
          <div class="min-w-full flex-shrink-0 flex flex-col md:flex-row items-center p-8 md:p-12 gap-8 text-center md:text-left">
            <div class="flex-1">
              <p class="font-poppins text-amber font-bold tracking-[0.2em] uppercase text-sm mb-4">Taste Everything</p>
              <h1 class="font-anton text-4xl sm:text-5xl md:text-7xl text-canopy uppercase tracking-wide mb-6">
                Kopi & <span class="text-moss">Cerita</span>
              </h1>
              <p class="text-mist md:text-lg mb-8 leading-relaxed">
                Temukan racikan kopi terbaik dan berbagai menu andalan kami yang siap menemani momen santaimu. Pesan sekarang dan rasakan kehangatannya.
              </p>
              <a href="#menu" class="inline-flex items-center gap-2 bg-canopy hover:bg-moss text-cream px-8 py-4 rounded-full font-bold uppercase tracking-widest text-sm transition-all shadow-xl shadow-canopy/20 hover:scale-105">
                Lihat Menu
              </a>
            </div>
          </div>
          <?php endif; ?>

        </div>

        <!-- Carousel Controls -->
        <button id="prevBtn" class="absolute left-4 top-1/2 -translate-y-1/2 w-10 h-10 bg-canopy/80 text-cream rounded-full flex items-center justify-center hover:bg-canopy transition-colors">
          ❮
        </button>
        <button id="nextBtn" class="absolute right-4 top-1/2 -translate-y-1/2 w-10 h-10 bg-canopy/80 text-cream rounded-full flex items-center justify-center hover:bg-canopy transition-colors">
          ❯
        </button>
      </div>
    </div>
  </header>

  <script>
    const inner = document.getElementById('carousel-inner');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    let currentIndex = 0;
    const slidesCount = <?= $slidesCount > 0 ? $slidesCount : 1 ?>;

    function showSlide(index) {
      if (slidesCount <= 1) return;
      if (index < 0) index = slidesCount - 1;
      if (index >= slidesCount) index = 0;
      inner.style.transform = `translateX(-${index * 100}%)`;
      currentIndex = index;
    }

    if(slidesCount > 1) {
      prevBtn.addEventListener('click', () => showSlide(currentIndex - 1));
      nextBtn.addEventListener('click', () => showSlide(currentIndex + 1));
      setInterval(() => showSlide(currentIndex + 1), 5000);
    } else {
      prevBtn.style.display = 'none';
      nextBtn.style.display = 'none';
    }
  </script>

  <!-- Menu Section -->
  <section id="menu" class="py-24 bg-white/50 border-t border-twig/20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      
      <div class="text-center mb-10">
        <h2 class="font-anton text-4xl text-canopy uppercase tracking-wide">Pilihan Menu</h2>
        <p class="text-mist mt-3 text-sm">Dibuat dengan bahan premium untuk cita rasa tak terlupakan</p>
      </div>

      <!-- Form Pencarian -->
      <div class="max-w-2xl mx-auto mb-16">
        <form method="GET" action="index.php#menu" class="flex flex-col sm:flex-row gap-3">
          <select name="kategori_search" class="px-5 py-3 rounded-full border border-twig/50 bg-white text-sm text-charcoal focus:outline-none focus:border-moss transition-all shadow-sm">
            <option value="">Semua Kategori</option>
            <?php
            $katDropdown = mysqli_query($koneksi, "SELECT * FROM tb_kategori");
            while ($k = mysqli_fetch_array($katDropdown)) {
              $selected = (isset($_GET['kategori_search']) && $_GET['kategori_search'] == $k['id_kategori']) ? 'selected' : '';
              echo "<option value='{$k['id_kategori']}' $selected>{$k['nama_kategori']}</option>";
            }
            ?>
          </select>
          <div class="relative flex-1">
            <input type="text" name="search" value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>" placeholder="Cari menu favoritmu..." class="w-full pl-12 pr-5 py-3 rounded-full border border-twig/50 bg-white text-sm text-charcoal focus:outline-none focus:border-moss transition-all shadow-sm">
            <div class="absolute left-4 top-1/2 -translate-y-1/2 text-mist">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
              </svg>
            </div>
          </div>
          <button type="submit" class="bg-moss text-white px-8 py-3 rounded-full text-sm hover:bg-canopy transition-all font-bold shadow-md hover:shadow-lg">Cari</button>
        </form>
      </div>

      <?php
      $search = isset($_GET['search']) ? mysqli_real_escape_string($koneksi, $_GET['search']) : '';
      $kat_search = isset($_GET['kategori_search']) ? mysqli_real_escape_string($koneksi, $_GET['kategori_search']) : '';
      
      $where = "1=1";
      if ($search != '') {
          $where .= " AND p.nama_produk LIKE '%$search%'";
      }
      if ($kat_search != '') {
          $where .= " AND p.id_kategori = '$kat_search'";
      }

      // Ambil semua kategori yang ada produknya (sesuai filter)
      $queryKategori = mysqli_query($koneksi, "SELECT DISTINCT k.id_kategori, k.nama_kategori FROM tb_kategori k 
JOIN tb_produk p ON k.id_kategori = p.id_kategori 
WHERE $where
ORDER BY CASE WHEN k.id_kategori = 5 THEN 0 ELSE 1 END, k.id_kategori ASC");

      if (mysqli_num_rows($queryKategori) == 0): ?>
        <div class="text-center py-10">
          <p class="text-mist">Oops! Menu yang kamu cari tidak ditemukan.</p>
        </div>
      <?php else:
        while ($kat = mysqli_fetch_assoc($queryKategori)):
      ?>
        <div class="mb-16">
          <div class="flex items-center gap-4 mb-8">
            <h3 class="font-poppins font-bold text-2xl text-moss"><?= htmlspecialchars($kat['nama_kategori']) ?></h3>
            <div class="h-px flex-1 bg-twig/30"></div>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            <?php
            $idKat = $kat['id_kategori'];
            $queryProduk = mysqli_query($koneksi, "SELECT p.* FROM tb_produk p WHERE p.id_kategori = '$idKat' AND $where");
            while ($produk = mysqli_fetch_assoc($queryProduk)):
            ?>
              <div class="bg-cream/80 backdrop-blur-sm rounded-[28px] border border-twig/30 overflow-hidden hover:shadow-2xl hover:shadow-canopy/10 hover:-translate-y-2 transition-all duration-300 group flex flex-col">
                <div class="relative h-56 overflow-hidden bg-sand/50">
                  <img src="assets/img/<?= htmlspecialchars($produk['poto']) ?>" alt="<?= htmlspecialchars($produk['nama_produk']) ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onerror="this.src='https://placehold.co/400x300/E8DCC4/6B6357?text=No+Image'">
                </div>
                <div class="p-6 flex flex-col flex-1">
                  <h4 class="font-bold text-lg text-canopy mb-1 leading-tight"><?= htmlspecialchars($produk['nama_produk']) ?></h4>
                  <p class="font-anton text-amber text-xl tracking-wide mb-1">Rp <?= number_format($produk['harga'], 0, ',', '.') ?></p>
                  <p class="text-xs font-semibold text-moss mb-3">Stok: <?= $produk['stok'] ?></p>
                  <p class="text-mist text-sm line-clamp-2 mb-6 flex-1">
                    <?= htmlspecialchars($produk['deskripsi'] ?: 'Tidak ada deskripsi') ?>
                  </p>
                  
                  <div class="mt-auto">
                    <a href="detail.php?id=<?= $produk['id'] ?>" class="block w-full text-center py-3 rounded-full border-2 border-moss text-moss font-semibold hover:bg-moss hover:text-cream transition-colors">
                      Detail Produk
                    </a>
                  </div>
                </div>
              </div>
            <?php endwhile; ?>
          </div>
          </div>
      <?php endwhile; endif; ?>

    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-canopy text-cream py-12 border-t-4 border-amber">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center gap-6">
      <div>
        <a href="#" class="font-poppins font-bold lowercase text-3xl tracking-tight text-cream">
          Niskalla<span class="text-amber">Caffe</span>
        </a>
        <p class="text-dew text-sm mt-2">© <?= date('Y') ?> Taste Everything.</p>
      </div>
      <div class="flex gap-6">
        <a href="#" class="text-dew hover:text-amber transition"><svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg></a>
        <a href="#" class="text-dew hover:text-amber transition"><svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg></a>
      </div>
    </div>
  </footer>

  </div>

</body>
</html>