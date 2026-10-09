<?php
include '../koneksi.php';
session_start();
if (!isset($_SESSION['admin'])) {
  header('location: ../login.php');
  exit();
}
/** @var mysqli $koneksi */
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Customers — Niskalla-Caffe</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Anton&family=Inter:wght@400;600;700&display=swap" rel="stylesheet" />
  <style>
    body { background-color: #F5F0E1; font-family: 'Inter', sans-serif; color: #2A2620; }
    .sidebar-link:hover { background: rgba(74, 93, 74, 0.1); color: #4A5D4A; }
    .sidebar-link.active { background: rgba(74, 93, 74, 0.15); color: #2D3F31; border-right: 3px solid #4A5D4A; }
    .niskala-table th { background: linear-gradient(180deg, #EDE3CC 0%, #E8DCC4 100%); font-weight: 700; text-transform: uppercase; font-size: 0.75rem; color: #6B6357; }
  </style>
</head>
<body class="min-h-screen">
  <div class="flex min-h-screen">
    <!-- SIDEBAR -->
    <aside class="hidden md:block w-64 bg-[#E8DCC4]/80 backdrop-blur-sm border-r border-[#C9B89A]/30 flex-shrink-0 fixed h-full z-40">
      <div class="flex flex-col h-full">
        <div class="p-6 border-b border-[#C9B89A]/30">
          <a href="../index.php" class="font-bold lowercase text-2xl text-[#2D3F31]">Niskalla<span class="text-[#D4A04E]">Caffe</span></a>
          <p class="text-[10px] uppercase tracking-[0.2em] text-[#6B6357] mt-1">Admin Dashboard</p>
        </div>
        <nav class="flex-1 overflow-y-auto py-4 px-3">
          <ul class="space-y-1">
            <li>
              <a href="dasbor.php" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium text-[#2A2620]/70">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                Dashboard Admin
              </a>
            </li>
            <li>
              <a href="dasbor.php" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium text-[#2A2620]/70">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                Produk
              </a>
            </li>
            <li>
              <a href="transaksi.php" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium text-[#2A2620]/70">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                Transaksi
              </a>
            </li>
            <li>
              <a href="customers.php" class="sidebar-link active flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                Customers
              </a>
            </li>
          </ul>
          <div class="mt-auto pt-4 border-t border-[#C9B89A]/30 space-y-1">
            <li>
              <a href="../logout.php" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm text-[#D88B96] hover:bg-[#D88B96]/10">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                Sign out
              </a>
            </li>
          </div>
        </nav>
      </div>
    </aside>

    <main class="flex-1 md:ml-64 pb-24 md:pb-0 w-full overflow-x-hidden">
      <header class="sticky top-0 z-30 bg-white/90 backdrop-blur-md border-b border-[#C9B89A]/30 px-4 md:px-8 py-4">
        <div class="flex flex-col md:flex-row md:items-center gap-1 md:gap-4">
          <div class="md:hidden mb-2 border-b border-[#C9B89A]/30 pb-2">
            <a href="../index.php" class="font-poppins font-bold lowercase text-xl text-[#2D3F31]">Niskalla<span class="text-[#D4A04E]">Caffe</span></a>
          </div>
          <div>
            <h1 class="font-anton text-2xl uppercase tracking-wide text-[#2D3F31]">Customers</h1>
            <p class="text-xs text-[#6B6357] mt-0.5">Daftar pelanggan terdaftar</p>
          </div>
        </div>
      </header>

      <div class="p-3 md:p-8">
        <div class="bg-white/70 backdrop-blur-sm rounded-2xl md:rounded-[28px] border border-[#C9B89A]/30 overflow-hidden shadow-lg max-w-6xl mx-auto">
          <div class="p-4 md:p-6 border-b border-[#C9B89A]/30 flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-[#4A5D4A]/10 flex items-center justify-center">
              <svg class="w-5 h-5 text-[#4A5D4A]" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
            </div>
            <div>
              <h2 class="font-anton text-lg uppercase tracking-wide text-[#2D3F31]">Data Pelanggan</h2>
            </div>
          </div>

          <div class="p-4 md:p-6 overflow-x-auto">
            <table class="w-full text-sm text-left border-collapse niskala-table">
              <thead>
                <tr class="border-b-2 border-[#C9B89A]/30">
                  <th class="py-3 px-4 font-semibold uppercase tracking-wide text-xs">NO</th>
                  <th class="py-3 px-4 font-semibold uppercase tracking-wide text-xs">Nama / Username</th>
                  <th class="py-3 px-4 font-semibold uppercase tracking-wide text-xs">Email</th>
                  <th class="py-3 px-4 font-semibold uppercase tracking-wide text-xs">No HP</th>
                  <th class="py-3 px-4 font-semibold uppercase tracking-wide text-xs">Alamat</th>
                  <th class="py-3 px-4 font-semibold uppercase tracking-wide text-xs text-center">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                // Proses Aksi (Hapus / Reset Password)
                if (isset($_GET['action']) && isset($_GET['id'])) {
                    $action = $_GET['action'];
                    $user_id = (int)$_GET['id'];
                    
                    if ($action == 'reset') {
                        // Reset password jadi 123456
                        $new_pass = '123456';
                        $stmt = mysqli_prepare($koneksi, "UPDATE tb_user SET password = ? WHERE id = ?");
                        mysqli_stmt_bind_param($stmt, "si", $new_pass, $user_id);
                        mysqli_stmt_execute($stmt);
                        echo "<script>alert('Password berhasil direset menjadi: 123456'); window.location='customers.php';</script>";
                    } elseif ($action == 'hapus') {
                        $stmt = mysqli_prepare($koneksi, "DELETE FROM tb_user WHERE id = ?");
                        mysqli_stmt_bind_param($stmt, "i", $user_id);
                        mysqli_stmt_execute($stmt);
                        echo "<script>alert('Pelanggan berhasil dihapus!'); window.location='customers.php';</script>";
                    }
                }

                $no = 1;
                $hasil = mysqli_query($koneksi, "SELECT * FROM tb_user WHERE role != 'admin' ORDER BY id DESC");
                while ($data = mysqli_fetch_assoc($hasil)) {
                ?>
                  <tr class="border-b border-[#C9B89A]/20 hover:bg-[#D4A04E]/5 transition-all">
                    <td class="py-4 px-4"><?= $no++ ?></td>
                    <td class="py-4 px-4 font-medium"><?= htmlspecialchars($data['name'] ?? $data['username'] ?? '') ?></td>
                    <td class="py-4 px-4"><?= htmlspecialchars($data['email'] ?? '') ?></td>
                    <td class="py-4 px-4"><?= htmlspecialchars($data['hp'] ?? '') ?></td>
                    <td class="py-4 px-4"><?= htmlspecialchars($data['alamat'] ?? '') ?></td>
                    <td class="py-4 px-4 text-center">
                      <div class="flex items-center justify-center gap-2">
                        <a href="customers.php?action=reset&id=<?= $data['id'] ?>" onclick="return confirm('Reset password user ini menjadi 123456?');" class="bg-blue-500/10 text-blue-600 text-xs font-semibold px-3 py-1.5 rounded-full hover:bg-blue-500/20 transition-all">Reset Sandi</a>
                        <a href="customers.php?action=hapus&id=<?= $data['id'] ?>" onclick="return confirm('Hapus pelanggan ini permanen?');" class="bg-red-500/10 text-red-500 text-xs font-semibold px-3 py-1.5 rounded-full hover:bg-red-500/20 transition-all">Hapus</a>
                      </div>
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table></div>
          </div>
        </div>
      </div>
    </main>
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
