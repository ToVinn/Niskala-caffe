<?php
session_start();
include 'koneksi.php';

// Cek apakah user sudah login
if (!isset($_SESSION['id_user'])) {
    echo "<script>alert('Silakan login terlebih dahulu untuk melihat riwayat transaksi'); window.location.href='login.php';</script>";
    exit();
}

$id_user = $_SESSION['id_user'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Riwayat Transaksi — Niskalla Caffe</title>
  
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
            canopy: '#2D3F31',
            moss: '#4A5D4A',
            amber: '#D4A04E',
            charcoal: '#2A2620',
            mist: '#6B6357',
            twig: '#C9B89A',
            rose: '#D88B96',
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

  <nav class="sticky top-0 z-50 bg-cream/90 backdrop-blur-md border-b border-twig/30">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center h-20">
      <a href="index.php" class="font-poppins font-bold lowercase text-3xl text-canopy tracking-tight">
        Niskalla<span class="text-amber">Caffe</span>
      </a>
      <a href="index.php" class="text-sm font-semibold text-mist hover:text-moss transition">Kembali ke Menu</a>
    </div>
  </nav>

  <main class="flex-1 py-12 px-4">
    <div class="max-w-4xl mx-auto bg-white/70 backdrop-blur-sm rounded-[32px] border border-twig/30 shadow-xl overflow-hidden">
      
      <div class="p-8 border-b border-twig/30 bg-sand/30">
        <h1 class="font-anton text-3xl text-canopy uppercase tracking-wide">Riwayat Transaksi</h1>
        <p class="text-mist text-sm mt-1">Daftar pesanan kopi dan cemilanmu sebelumnya</p>
      </div>

      <div class="p-8">
        <?php
        $queryTrx = mysqli_query($koneksi, "SELECT * FROM tb_transaksi WHERE id_pelanggan = '$id_user' ORDER BY id_transaksi DESC");
        if (mysqli_num_rows($queryTrx) > 0):
        ?>
          <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
              <thead>
                <tr class="border-b-2 border-twig/30 text-mist text-xs uppercase tracking-wider">
                  <th class="py-3 px-4 font-semibold">No Nota</th>
                  <th class="py-3 px-4 font-semibold text-center">Tanggal</th>
                  <th class="py-3 px-4 font-semibold text-center">Status</th>
                  <th class="py-3 px-4 font-semibold text-right">Total Belanja</th>
                  <th class="py-3 px-4 font-semibold text-center">Nota</th>
                </tr>
              </thead>
              <tbody>
                <?php while ($trx = mysqli_fetch_assoc($queryTrx)): 
                  $status = isset($trx['status']) ? $trx['status'] : 'Pending';
                ?>
                  <tr class="border-b border-twig/20 hover:bg-sand/20 transition-colors">
                    <td class="py-4 px-4 font-semibold text-canopy">TRX-<?= str_pad($trx['id_transaksi'], 5, "0", STR_PAD_LEFT) ?></td>
                    <td class="py-4 px-4 text-center font-medium"><?= date('d M Y', strtotime($trx['tanggal'])) ?></td>
                    <td class="py-4 px-4 text-center font-medium text-amber-600"><?= htmlspecialchars($status) ?></td>
                    <td class="py-4 px-4 text-right font-bold text-canopy">Rp <?= number_format($trx['total_harga'], 0, ',', '.') ?></td>
                    <td class="py-4 px-4 text-center">
                      <a href="cetak.php?id=<?= $trx['id_transaksi'] ?>" class="inline-block border border-moss text-moss hover:bg-moss hover:text-cream px-4 py-1.5 rounded-full font-semibold text-xs transition-colors" target="_blank">Lihat Nota</a>
                    </td>
                  </tr>
                <?php endwhile; ?>
              </tbody>
            </table>
          </div>
        <?php else: ?>
          <div class="text-center py-16">
            <div class="w-24 h-24 mx-auto bg-sand/50 rounded-full flex items-center justify-center mb-4 text-mist">
              <svg class="w-10 h-10" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
            </div>
            <p class="text-lg font-semibold text-canopy mb-2">Belum ada riwayat transaksi</p>
            <p class="text-mist text-sm mb-6">Mulai pesanan pertamamu sekarang!</p>
            <a href="index.php" class="inline-block border-2 border-moss text-moss hover:bg-moss hover:text-cream px-6 py-2.5 rounded-full font-semibold transition-colors">
              Lihat Menu
            </a>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </main>

  <footer class="bg-canopy text-cream py-6 mt-auto text-center">
    <p class="text-dew text-sm">© <?= date('Y') ?> Niskalla Caffe. Taste Everything.</p>
  </footer>

</body>
</html>
