<?php
session_start();
include 'koneksi.php';

// Cek apakah user sudah login
if (!isset($_SESSION['id_user'])) {
    echo "<script>alert('Silakan login terlebih dahulu untuk mengakses keranjang'); window.location.href='login.php';</script>";
    exit();
}

$id_user = $_SESSION['id_user'];

// PROSES TAMBAH KE KERANJANG
if (isset($_POST["add"])) {
    $id_produk = (int)$_GET["id"];

    if (isset($_SESSION["cart"][$id_produk])) {
        $_SESSION["cart"][$id_produk]['jumlah'] += (int)$_POST["jumlah"];
    } else {
        $_SESSION["cart"][$id_produk] = array(
            'id' => $id_produk,
            'nama' => $_POST["hidden_nama"],
            'harga' => $_POST["hidden_harga"],
            'foto' => $_POST["hidden_poto"],
            'jumlah' => (int)$_POST["jumlah"]
        );
    }
    header('Location: keranjang.php');
    exit();
}

// PROSES HAPUS / BELI
if (isset($_GET["aksi"])) {
    if ($_GET["aksi"] == "hapus") {
        $id_produk = (int)$_GET["id"];
        if (isset($_SESSION["cart"][$id_produk])) {
            unset($_SESSION["cart"][$id_produk]);
        }
        header('Location: keranjang.php');
        exit();

    } elseif ($_GET["aksi"] == "beli") {
        if (empty($_SESSION["cart"])) {
            echo "<script>alert('Keranjang kosong!'); window.location='keranjang.php';</script>";
            exit();
        }

        $total = 0;
        foreach ($_SESSION["cart"] as $value) {
            $total += ($value["jumlah"] * $value["harga"]);
        }

        // Insert tb_transaksi
        $tanggal = date("Y-m-d");
        $metode_kirim = isset($_POST['metode_kirim']) ? $_POST['metode_kirim'] : 'Ambil di Toko';
        $metode_bayar = isset($_POST['metode_bayar']) ? $_POST['metode_bayar'] : 'Transfer Bank';
        $status = 'Pending';
        
        $stmtTrx = mysqli_prepare($koneksi, "INSERT INTO tb_transaksi (tanggal, id_pelanggan, total_harga, metode_bayar, metode_kirim, status) VALUES (?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmtTrx, "siisss", $tanggal, $id_user, $total, $metode_bayar, $metode_kirim, $status);
        if(mysqli_stmt_execute($stmtTrx)) {
            $id_transaksi = mysqli_insert_id($koneksi);

            // Insert tb_detail
            $stmtDetail = mysqli_prepare($koneksi, "INSERT INTO tb_detail (id_transaksi, id_produk, jumlah) VALUES (?, ?, ?)");
            foreach ($_SESSION["cart"] as $value) {
                mysqli_stmt_bind_param($stmtDetail, "iii", $id_transaksi, $value['id'], $value['jumlah']);
                mysqli_stmt_execute($stmtDetail);
            }

            unset($_SESSION["cart"]);
            header("Location: cetak.php?id=" . $id_transaksi);
            exit();
        } else {
            die("Error insert transaksi: " . mysqli_error($koneksi));
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Keranjang — Niskalla Caffe</title>
  
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
        <h1 class="font-anton text-3xl text-canopy uppercase tracking-wide">Keranjang Belanja</h1>
        <p class="text-mist text-sm mt-1">Selesaikan pesanan kopi dan cemilanmu</p>
      </div>

      <div class="p-8">
        <?php if (!empty($_SESSION["cart"])): ?>
          <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
              <thead>
                <tr class="border-b-2 border-twig/30 text-mist text-xs uppercase tracking-wider">
                  <th class="py-3 px-4 font-semibold">Produk</th>
                  <th class="py-3 px-4 font-semibold text-center">Jumlah</th>
                  <th class="py-3 px-4 font-semibold text-right">Harga</th>
                  <th class="py-3 px-4 font-semibold text-right">Subtotal</th>
                  <th class="py-3 px-4 font-semibold text-center">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $total = 0;
                foreach ($_SESSION["cart"] as $key => $value):
                  $subtotal = $value["jumlah"] * $value["harga"];
                  $total += $subtotal;
                ?>
                  <tr class="border-b border-twig/20 hover:bg-sand/20 transition-colors">
                    <td class="py-4 px-4 flex items-center gap-4">
                      <div class="w-16 h-16 rounded-xl overflow-hidden bg-sand/50 border border-twig/30 flex-shrink-0">
                        <img src="assets/img/<?= htmlspecialchars($value['foto']) ?>" class="w-full h-full object-cover">
                      </div>
                      <span class="font-semibold text-canopy"><?= htmlspecialchars($value['nama']) ?></span>
                    </td>
                    <td class="py-4 px-4 text-center font-medium"><?= $value['jumlah'] ?></td>
                    <td class="py-4 px-4 text-right text-mist">Rp <?= number_format($value['harga'], 0, ',', '.') ?></td>
                    <td class="py-4 px-4 text-right font-bold text-canopy">Rp <?= number_format($subtotal, 0, ',', '.') ?></td>
                    <td class="py-4 px-4 text-center">
                      <a href="keranjang.php?aksi=hapus&id=<?= $value['id'] ?>" class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-rose/10 text-rose hover:bg-rose hover:text-white transition-colors" title="Hapus">
                        ✕
                      </a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>

          <form action="keranjang.php?aksi=beli" method="POST" class="mt-8 flex flex-col md:flex-row justify-between items-center gap-6 bg-sand/30 p-6 rounded-2xl border border-twig/30">
            <div class="flex flex-col gap-4 w-full md:w-auto">
              <div>
                <p class="text-sm uppercase tracking-wider text-mist font-semibold">Total Pembayaran</p>
                <p class="font-anton text-3xl text-amber">Rp <?= number_format($total, 0, ',', '.') ?></p>
              </div>
            </div>
            
            <div class="flex flex-col md:flex-row gap-4 w-full md:w-auto items-end">
              <div class="w-full md:w-48">
                <label class="block text-sm font-semibold text-canopy mb-1">Tipe Pesanan</label>
                <select name="metode_kirim" class="w-full px-4 py-2 rounded-lg border border-twig/50 bg-white text-sm focus:outline-none focus:border-moss" required>
                  <option value="Dine-in (Makan di Tempat)">Dine-in (Makan di Tempat)</option>
                  <option value="Takeaway (Bungkus)">Takeaway (Bungkus)</option>
                </select>
              </div>
              
              <div class="w-full md:w-48">
                <label class="block text-sm font-semibold text-canopy mb-1">Metode Pembayaran</label>
                <select name="metode_bayar" class="w-full px-4 py-2 rounded-lg border border-twig/50 bg-white text-sm focus:outline-none focus:border-moss" required>
                  <option value="Bayar di Kasir">Bayar di Kasir</option>
                  <option value="E-Wallet (QRIS/Dana/Ovo)">E-Wallet (QRIS/Dana/Ovo)</option>
                </select>
              </div>

              <button type="submit" class="w-full md:w-auto bg-moss hover:bg-canopy text-cream px-8 py-2.5 rounded-lg font-bold uppercase tracking-widest text-sm transition-all shadow-lg hover:-translate-y-1 text-center h-full">
                Checkout
              </button>
            </div>
          </form>

        <?php else: ?>
          <div class="text-center py-16">
            <div class="w-24 h-24 mx-auto bg-sand/50 rounded-full flex items-center justify-center mb-4 text-mist">
              <svg class="w-10 h-10" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
            </div>
            <p class="text-lg font-semibold text-canopy mb-2">Keranjangmu masih kosong</p>
            <p class="text-mist text-sm mb-6">Yuk, pilih menu kopi favoritmu sekarang!</p>
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
