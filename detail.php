<?php
session_start();
include 'koneksi.php';

// Mengambil ID dari URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    die("ID produk tidak ditemukan.");
}

// Mengambil data produk berdasarkan ID
$hasil = mysqli_query($koneksi, "SELECT * FROM tb_produk WHERE id='$id'");

if (!$hasil) {
    die("Query gagal: " . mysqli_error($koneksi));
}

if (mysqli_num_rows($hasil) == 0) {
    die("Produk tidak ditemukan.");
}

$data = mysqli_fetch_assoc($hasil);

$nama = $data['nama_produk'];
$harga = $data['harga'];
$deskripsi = $data['deskripsi'];
$poto = $data['poto'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?= htmlspecialchars($nama) ?> — Niskalla Caffe</title>

  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Anton&family=Inter:wght@400;600;700&family=Poppins:wght@600;700&display=swap" rel="stylesheet" />

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
</head>
<body class="bg-cream text-charcoal font-inter min-h-screen flex flex-col">

  <!-- Navbar -->
  <nav class="sticky top-0 z-50 bg-cream/90 backdrop-blur-md border-b border-twig/30">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center h-20">
        <a href="index.php" class="font-poppins font-bold lowercase text-3xl text-canopy tracking-tight">
          Niskalla<span class="text-amber">Caffe</span>
        </a>
      </div>
    </div>
  </nav>

  <main class="flex-1 py-16 px-4">
    <div class="max-w-5xl mx-auto bg-white/70 backdrop-blur-sm rounded-[32px] border border-twig/30 p-8 shadow-xl">
      <div class="flex flex-col md:flex-row gap-12 items-center">
        
        <!-- Gambar -->
        <div class="w-full md:w-1/2">
          <div class="rounded-[28px] overflow-hidden border-2 border-twig/30 bg-sand/50 shadow-inner">
            <img 
              src="assets/img/<?= htmlspecialchars($poto) ?>" 
              alt="<?= htmlspecialchars($nama) ?>"
              class="w-full aspect-square object-cover hover:scale-105 transition-transform duration-500"
              onerror="this.src='https://placehold.co/500x500/E8DCC4/6B6357?text=Gambar+Kosong'"
            >
          </div>
        </div>

        <!-- Info Produk -->
        <div class="w-full md:w-1/2">
          <h1 class="font-anton text-4xl text-canopy uppercase tracking-wide mb-2">
            <?= htmlspecialchars($nama) ?>
          </h1>
          <p class="font-poppins text-3xl text-amber font-bold mb-6">
            Rp <?= number_format($harga, 0, ',', '.') ?>
          </p>
          
          <div class="mb-8">
            <h3 class="text-sm uppercase tracking-[0.15em] text-mist font-semibold mb-2">Deskripsi Produk</h3>
            <p class="text-charcoal leading-relaxed">
              <?= nl2br(htmlspecialchars($deskripsi ?: 'Belum ada deskripsi untuk produk ini.')) ?>
            </p>
          </div>

          <!-- Form Add To Cart -->
          <form method="post" action="keranjang.php?id=<?= htmlspecialchars($id) ?>" class="bg-sand/30 p-6 rounded-[24px] border border-twig/30">
            <input type="hidden" name="hidden_poto" value="<?= htmlspecialchars($poto) ?>">
            <input type="hidden" name="hidden_nama" value="<?= htmlspecialchars($nama) ?>">
            <input type="hidden" name="hidden_harga" value="<?= htmlspecialchars($harga) ?>">

            <div class="flex items-end gap-4 mb-6">
              <div class="flex-1 max-w-[120px]">
                <label for="jumlah" class="block text-xs uppercase tracking-wider text-mist font-semibold mb-2">Jumlah</label>
                <input 
                  type="number" id="jumlah" name="jumlah" value="1" min="1" 
                  class="w-full rounded-full border border-twig bg-white px-4 py-3 text-center text-charcoal focus:border-moss focus:outline-none focus:ring-2 focus:ring-moss/30 transition-all font-semibold"
                >
              </div>
            </div>

            <button type="submit" name="add" class="w-full bg-moss hover:bg-canopy text-cream py-4 rounded-full font-bold uppercase tracking-widest text-sm transition-all shadow-md shadow-moss/20 hover:-translate-y-1">
              Tambah ke Keranjang
            </button>
          </form>

          <div class="mt-6 text-center md:text-left">
            <a href="index.php" class="inline-flex items-center gap-2 text-sm text-mist hover:text-moss transition font-medium">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
              Kembali ke Menu
            </a>
          </div>

        </div>
      </div>
    </div>
  </main>

  <footer class="bg-canopy text-cream py-8 mt-auto">
    <div class="text-center">
      <p class="text-dew text-sm">© <?= date('Y') ?> Niskalla Caffe. Taste Everything.</p>
    </div>
  </footer>

</body>
</html>