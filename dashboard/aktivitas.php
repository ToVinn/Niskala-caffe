<?php
include '../koneksi.php';
session_start();
if (!isset($_SESSION['admin'])) {
  header('location: login.php');
}

error_reporting(E_ALL);
ini_set('display_errors', 1);
/** @var mysqli $koneksi */

if (isset($_POST['hapus_terpilih']) && !empty($_POST['hapus'])) {
    foreach ($_POST['hapus'] as $val) {
        $parts = explode('|', $val);
        if (count($parts) == 2) {
            $tbl = mysqli_real_escape_string($koneksi, $parts[0]);
            $row_id = (int)$parts[1];
            
            if ($tbl == 'tb_stok_masuk') {
                mysqli_query($koneksi, "DELETE FROM tb_stok_masuk WHERE id_stok_masuk = $row_id");
            } elseif ($tbl == 'tb_transaksi') {
                mysqli_query($koneksi, "DELETE FROM tb_detail WHERE id_transaksi = $row_id");
                mysqli_query($koneksi, "DELETE FROM tb_transaksi WHERE id_transaksi = $row_id");
            }
        }
    }
    header("location: aktivitas.php");
    exit();
}

?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="theme-color" content="#2D3F31" />
  <title>Log Aktivitas — Niskalla-Caffe</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Anton&family=Inter:wght@400;600;700&family=Poppins:wght@600;700&display=swap" rel="stylesheet" />
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: { cream: '#F5F0E1', sand: '#E8DCC4', kraft: '#EDE3CC', canopy: '#2D3F31', moss: '#4A5D4A', leaf: '#7A8B6F', dew: '#A8B89E', bark: '#6B5444', clay: '#C4956A', rose: '#D88B96', amber: '#D4A04E', charcoal: '#2A2620', mist: '#6B6357', twig: '#C9B89A' },
          fontFamily: { anton: ['Anton', 'sans-serif'], inter: ['Inter', 'sans-serif'], poppins: ['Poppins', 'sans-serif'] },
        }
      }
    }
  </script>
  <style>
    body { background-color: #F5F0E1; font-family: 'Inter', sans-serif; color: #2A2620; }
    .sidebar-link:hover { background: rgba(74, 93, 74, 0.1); color: #4A5D4A; }
    .sidebar-link.active { background: rgba(74, 93, 74, 0.15); color: #2D3F31; border-right: 3px solid #4A5D4A; }
    .niskala-card { transition: all 0.35s ease; }
    .niskala-card:hover { transform: translateY(-4px); box-shadow: 0 12px 32px rgba(74, 93, 74, 0.15); }
  </style>
</head>
<body class="min-h-screen">
  <div class="flex min-h-screen">
    <aside class="w-64 bg-sand/80 backdrop-blur-sm border-r border-twig/30 flex-shrink-0 fixed h-full z-40">
      <div class="flex flex-col h-full">
        <div class="p-6 border-b border-twig/30">
          <a href="../index.php" class="font-poppins font-bold lowercase text-2xl text-canopy">Niskalla<span class="text-amber">Caffe</span></a>
          <p class="text-[10px] uppercase tracking-[0.2em] text-mist mt-1">Admin Dashboard</p>
        </div>
        <nav class="flex-1 overflow-y-auto py-4 px-3">
          <ul class="space-y-1">
            <li><a href="dasbor.php" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium text-charcoal/70"><svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>Dashboard Admin</a></li>
            <li><a href="dasbor.php" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium text-charcoal/70"><svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>Produk</a></li>
            <li><a href="transaksi.php" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium text-charcoal/70"><svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>Transaksi</a></li>
            <li><a href="customers.php" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium text-charcoal/70"><svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>Customers</a></li>
            <li><a href="aktivitas.php" class="sidebar-link active flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium"><svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>Log Aktivitas</a></li>
          </ul>
          <div class="mt-auto pt-4 border-t border-twig/30 space-y-1">
            <li><a href="../logout.php" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm text-rose hover:bg-rose/10"><svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>Sign out</a></li>
          </div>
        </nav>
      </div>
    </aside>

    <main class="flex-1 ml-64">
      <header class="sticky top-0 z-30 bg-cream/90 backdrop-blur-md border-b border-twig/30 px-8 py-4">
        <div>
          <h1 class="font-anton text-2xl uppercase tracking-wide text-canopy">Log Aktivitas</h1>
          <p class="text-xs text-mist mt-0.5">Riwayat stok masuk, pendaftaran, dan pesanan</p>
        </div>
      </header>
      
      <div class="p-8">
        <form method="post" action="">
          <div class="mb-4 flex justify-between items-center">
            <button type="submit" name="hapus_terpilih" class="bg-rose/10 text-rose px-4 py-2 rounded-full text-sm font-semibold hover:bg-rose hover:text-white transition-colors" onclick="return confirm('Yakin hapus data terpilih? Perhatian: Ini menghapus data asli (Transaksi/User/Stok).')">
              Hapus Terpilih
            </button>
          </div>
          <div class="bg-white/70 backdrop-blur-sm rounded-[28px] border border-twig/30 overflow-hidden shadow-lg niskala-card max-w-6xl mx-auto">
            <div class="p-6 overflow-x-auto">
              <table class="w-full text-sm text-left border-collapse">
                <thead>
                  <tr class="border-b-2 border-twig/30">
                    <th class="py-3 px-4 w-10"><input type="checkbox" id="checkAll" class="rounded border-twig text-moss focus:ring-moss"></th>
                    <th class="py-3 px-4 font-semibold uppercase tracking-wide text-xs text-mist">Waktu</th>
                    <th class="py-3 px-4 font-semibold uppercase tracking-wide text-xs text-mist">Jenis Aktivitas</th>
                    <th class="py-3 px-4 font-semibold uppercase tracking-wide text-xs text-mist">Detail</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $queryStr = "
                    SELECT 'tb_stok_masuk' as tbl, id_stok_masuk as row_id, 'Stok Masuk' as jenis, s.tanggal as waktu, CONCAT('Stok ditambah ', s.jumlah, ' untuk ', p.nama_produk) as detail 
                    FROM tb_stok_masuk s JOIN tb_produk p ON s.id_produk = p.id
                    
                    UNION ALL
                    
                    SELECT 'tb_transaksi' as tbl, id_transaksi as row_id, 'Pesanan Baru' as jenis, t.tanggal as waktu, CONCAT('Pesanan baru dari ', COALESCE(u.name, 'Unknown'), ' senilai Rp ', FORMAT(t.total_harga, 0, 'id_ID')) as detail 
                    FROM tb_transaksi t LEFT JOIN tb_user u ON t.id_pelanggan = u.id
                    
                    UNION ALL
                    
                    SELECT 'tb_user' as tbl, id as row_id, 'Registrasi' as jenis, waktu_regis as waktu, CONCAT('User baru mendaftar: ', name) as detail 
                    FROM tb_user WHERE role = 'pelanggan'
                    
                    ORDER BY waktu DESC LIMIT 100
                  ";
                  
                  $hasil = mysqli_query($koneksi, $queryStr);
                  if(mysqli_num_rows($hasil) > 0) {
                    while ($data = mysqli_fetch_array($hasil)) {
                      $jenisClass = 'text-charcoal';
                      if($data['jenis'] == 'Stok Masuk') $jenisClass = 'text-amber font-bold';
                      if($data['jenis'] == 'Pesanan Baru') $jenisClass = 'text-moss font-bold';
                      if($data['jenis'] == 'Registrasi') $jenisClass = 'text-canopy font-bold';
                  ?>
                    <tr class="border-b border-twig/20 hover:bg-amber/5 transition-all">
                    <td class="py-4 px-4">
                      <?php if($data['tbl'] == 'tb_user'): ?>
                        <span class="text-[10px] text-mist/50 italic" title="Data pelanggan tidak bisa dihapus dari log">Aman</span>
                      <?php else: ?>
                        <input type="checkbox" name="hapus[]" value="<?= $data['tbl'] . '|' . $data['row_id'] ?>" class="checkItem rounded border-twig text-moss focus:ring-moss">
                      <?php endif; ?>
                    </td>
                    <td class="py-4 px-4 text-mist whitespace-nowrap"><?= date('d M Y, H:i', strtotime($data['waktu'] ?? 'now')) ?></td>
                    <td class="py-4 px-4 <?= $jenisClass ?>"><?= $data['jenis'] ?></td>
                    <td class="py-4 px-4 text-charcoal"><?= $data['detail'] ?></td>
                  </tr>
                  <?php 
                    }
                  } else {
                  ?>
                    <tr><td colspan="4" class="py-4 px-4 text-center text-mist">Belum ada aktivitas</td></tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </form>
      </div>
    </main>
  </div>
  <script>
    document.getElementById('checkAll').addEventListener('change', function() {
      let checkboxes = document.querySelectorAll('.checkItem');
      checkboxes.forEach(cb => cb.checked = this.checked);
    });
  </script>
</body>
</html>