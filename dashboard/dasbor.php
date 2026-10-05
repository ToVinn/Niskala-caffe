<?php
include '../koneksi.php';
session_start();
if (!isset($_SESSION['admin'])) {
  header('location: login.php');
}

error_reporting(E_ALL);
ini_set('display_errors', 1);
/** @var mysqli $koneksi */

if (isset($_POST['tambah'])) {
  $nama_produk = $_POST['nama_produk'];
  $harga = $_POST['harga'];
  $stok = $_POST['stok'];
  $kategori = $_POST['kategori'];
  $deskripsi = $_POST['deskripsi'];
  $poto = $_FILES['poto']['name'];

  // Cek ekstensi file
  $ext = strtolower(pathinfo($poto, PATHINFO_EXTENSION));
  $allowed = ['jpg', 'jpeg', 'png', 'gif'];
  if (!in_array($ext, $allowed)) {
    die("Hanya file gambar yang diizinkan!");
  }

  $path = "../assets/img/" . $poto;
  $file_tmp = $_FILES['poto']['tmp_name'];
  move_uploaded_file($file_tmp, $path);

  $stmt = mysqli_prepare($koneksi, "INSERT INTO tb_produk (nama_produk, harga, stok, poto, id_kategori, deskripsi) VALUES (?, ?, ?, ?, ?, ?)");
  mysqli_stmt_bind_param($stmt, "siisis", $nama_produk, $harga, $stok, $poto, $kategori, $deskripsi);
  $simpan = mysqli_stmt_execute($stmt);

  if ($simpan > 0) {
    header("location: dasbor.php");
  }
}
?>
<!doctype html>
<html lang="id">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="description" content="Dashboard Admin RusiaLearn" />
  <meta name="theme-color" content="#2D3F31" />
  <title>Dashboard — Niskalla-Caffe</title>

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

  <style>
    * {
      box-sizing: border-box;
    }

    body {
      background-color: #F5F0E1;
      font-family: 'Inter', sans-serif;
      color: #2A2620;
    }

    /* Custom scrollbar */
    ::-webkit-scrollbar {
      width: 8px;
      height: 8px;
    }

    ::-webkit-scrollbar-track {
      background: #EDE3CC;
      border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb {
      background: #7A8B6F;
      border-radius: 4px;
    }

    /* Sidebar link hover */
    .sidebar-link {
      transition: all 0.2s ease;
    }

    .sidebar-link:hover {
      background: rgba(74, 93, 74, 0.1);
      color: #4A5D4A;
    }

    .sidebar-link.active {
      background: rgba(74, 93, 74, 0.15);
      color: #2D3F31;
      border-right: 3px solid #4A5D4A;
    }

    /* Card hover effect */
    .niskala-card {
      transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .niskala-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 12px 32px rgba(74, 93, 74, 0.15);
    }

    /* Table styling */
    .niskala-table th {
      background: linear-gradient(180deg, #EDE3CC 0%, #E8DCC4 100%);
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.05em;
      font-size: 0.75rem;
      color: #6B6357;
    }

    .niskala-table tr:nth-child(even) td {
      background: rgba(237, 227, 204, 0.5);
    }

    .niskala-table tr:hover td {
      background: rgba(168, 184, 158, 0.15);
    }

    /* Input focus */
    .niskala-input:focus {
      border-color: #4A5D4A;
      outline: none;
      box-shadow: 0 0 0 3px rgba(168, 184, 158, 0.4);
    }

    /* Button styles */
    .btn-moss {
      background: #4A5D4A;
      color: #F5F0E1;
      border-radius: 9999px;
      padding: 10px 24px;
      font-weight: 600;
      transition: all 0.25s ease;
      box-shadow: 0 4px 14px rgba(74, 93, 74, 0.25);
    }

    .btn-moss:hover {
      background: #2D3F31;
      transform: scale(1.02);
    }

    .btn-outline-moss {
      border: 1px solid #4A5D4A;
      color: #4A5D4A;
      border-radius: 9999px;
      padding: 8px 16px;
      font-size: 0.85rem;
      transition: all 0.25s ease;
    }

    .btn-outline-moss:hover {
      background: #4A5D4A;
      color: #F5F0E1;
    }
  </style>
</head>

<body class="min-h-screen">

  <div class="flex min-h-screen">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-sand/80 backdrop-blur-sm border-r border-twig/30 flex-shrink-0 fixed h-full z-40">
      <div class="flex flex-col h-full">

        <!-- Logo / Brand -->
        <div class="p-6 border-b border-twig/30">
          <a href="../index.php" class="font-poppins font-bold lowercase text-2xl text-canopy">Niskalla<span class="text-amber">Caffe</span></a>
          <p class="text-[10px] uppercase tracking-[0.2em] text-mist mt-1">Admin Dashboard</p>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 overflow-y-auto py-4 px-3">
          <ul class="space-y-1">

            <li>
              <a href="dasbor.php" class="sidebar-link active flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                  <path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Dashboard Admin
              </a>
            </li>

            <li>
              <a href="dasbor.php" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium text-charcoal/70">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                  <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
                Produk
              </a>
            </li>

            <li>
              <a href="transaksi.php" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium text-charcoal/70">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                Transaksi
              </a>
            </li>

            <li>
              <a href="customers.php" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium text-charcoal/70">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                  <path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                Customers
              </a>
            </li>
            
            <li>
              <a href="aktivitas.php" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium text-charcoal/70">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Log Aktivitas
              </a>
            </li>

          </ul>

          <!-- Bottom section -->
          <div class="mt-auto pt-4 border-t border-twig/30 space-y-1">

            <li>
              <a href="../logout.php" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm text-rose hover:bg-rose/10">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                  <path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                Sign out
              </a>
            </li>

          </div>

        </nav>
      </div>
    </aside>

    <main class="flex-1 ml-64">
      <header class="sticky top-0 z-30 bg-cream/90 backdrop-blur-md border-b border-twig/30 px-8 py-4">
        <div class="flex items-center justify-between">
          <div>
            <h1 class="font-anton text-2xl uppercase tracking-wide text-canopy">Dashboard</h1>
            <p class="text-xs text-mist mt-0.5">Kelola produk dan data</p>
          </div>
        </div>
      </header>
      <div class="p-8">
        <div class="bg-white/70 backdrop-blur-sm rounded-[28px] border border-twig/30 p-8 shadow-lg niskala-card mb-8">
          <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 rounded-full bg-moss/10 flex items-center justify-center">
              <svg class="w-5 h-5 text-moss" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path d="M12 4v16m8-8H4" />
              </svg>
            </div>
            <div>
              <h2 class="font-anton text-lg uppercase tracking-wide text-canopy">Tambah Produk</h2>
              <p class="text-xs text-mist">Isi form di bawah untuk menambahkan produk baru</p>
            </div>
          </div>

          <form action="" method="post" enctype="multipart/form-data" class="space-y-5">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

              <div>
                <label for="nama_produk" class="block text-xs uppercase tracking-[0.12em] text-mist font-semibold mb-2">Nama Produk</label>
                <input type="text" id="nama_produk" name="nama_produk" placeholder=". . . ."
                  class="niskala-input w-full rounded-full border border-twig bg-kraft/50 px-5 py-3 text-sm text-charcoal transition-all">
              </div>

              <div>
                <label class="block text-xs uppercase tracking-[0.12em] text-mist font-semibold mb-2">Harga</label>
                <div class="flex">
                  <span class="inline-flex items-center rounded-l-full border border-r-0 border-twig bg-kraft/50 px-4 text-sm text-mist">Rp</span>
                  <input type="text" name="harga" aria-label="Harga"
                    class="niskala-input w-full rounded-r-full border border-twig bg-kraft/50 px-4 py-3 text-sm text-charcoal transition-all">
                  <span class="inline-flex items-center rounded-r-full border border-l-0 border-twig bg-kraft/50 px-4 text-sm text-mist">.00</span>
                </div>
              </div>

              <div>
                <label for="stok" class="block text-xs uppercase tracking-[0.12em] text-mist font-semibold mb-2">Jumlah Stok</label>
                <input type="text" id="stok" name="stok" placeholder="Jumlah Stok . . ."
                  class="niskala-input w-full rounded-full border border-twig bg-kraft/50 px-5 py-3 text-sm text-charcoal transition-all">
              </div>

              <div>
                <label for="kategori" class="block text-xs uppercase tracking-[0.12em] text-mist font-semibold mb-2">Pilih Kategori</label>

                <select id="kategori" name="kategori" class="niskala-input w-full rounded-full border border-twig bg-kraft/50 px-5 py-3 text-sm text-charcoal transition-all">
                  <option value="" disabled selected>Pilih Kategori . . .</option>

                  <?php
                  $result = mysqli_query($koneksi, "SELECT * FROM tb_kategori");
                  while ($list = mysqli_fetch_array($result)) { ?>
                    <option value="<?= $list['id_kategori'] ?>"><?= $list['nama_kategori'] ?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="md:col-span-2">
                <label class="block text-xs uppercase tracking-[0.12em] text-mist font-semibold mb-2">Foto Produk</label>
                <div class="flex items-center gap-3">
                  <div class="flex-1">
                    <input type="file" id="poto" name="poto" accept="image/*"
                      class="niskala-input w-full rounded-full border border-dashed border-twig bg-kraft/30 px-5 py-3 text-sm text-charcoal file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-moss/10 file:text-moss cursor-pointer">
                  </div>
                  <button type="button" id="btnCancelFile"
                    class="hidden px-3 py-2 rounded-full bg-rose/10 text-rose text-sm hover:bg-rose/20 transition-colors"
                    title="Hapus pilihan file">
                    ✕
                  </button>
                </div>
                <p class="text-xs text-mist/70 mt-2 ml-1">Format: JPG, PNG. Max 2MB.</p>
              </div>

              <div class="md:col-span-2">
                <label for="deskripsi" class="block text-xs uppercase tracking-[0.12em] text-mist font-semibold mb-2">Deskripsi</label>
                <input type="text" id="deskripsi" name="deskripsi" placeholder="Deskripsi produk..."
                  class="niskala-input w-full rounded-full border border-twig bg-kraft/50 px-5 py-3 text-sm text-charcoal transition-all">
              </div>

            </div>

            <div class="pt-4">
              <button type="submit" name="tambah" class="btn-moss inline-flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <path d="M12 4v16m8-8H4" />
                </svg>
                Tambah Produk
              </button>
            </div>
          </form>
        </div>

        <div class="bg-white/70 backdrop-blur-sm rounded-[28px] border border-twig/30 overflow-hidden shadow-lg niskala-card max-w-6xl mx-auto mt-8">

          <div class="p-6 border-b border-twig/30 flex items-center justify-between flex-wrap gap-4">
            <div class="flex items-center gap-3">
              <div class="w-10 h-10 rounded-full bg-amber/10 flex items-center justify-center">
                <svg class="w-5 h-5 text-amber" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
              </div>
              <div>
                <h2 class="font-anton text-lg uppercase tracking-wide text-canopy">Data Produk</h2>
                <p class="text-xs text-mist">Semua produk yang terdaftar</p>
              </div>
            </div>
            
            <form method="GET" action="dasbor.php" class="flex items-center gap-2">
              <select name="kategori_search" class="niskala-input px-4 py-2 rounded-full border border-twig bg-kraft/50 text-sm text-charcoal focus:outline-none focus:border-moss transition-all">
                <option value="">Semua Kategori</option>
                <?php
                $kat_query = mysqli_query($koneksi, "SELECT * FROM tb_kategori");
                while ($k = mysqli_fetch_array($kat_query)) {
                  $selected = (isset($_GET['kategori_search']) && $_GET['kategori_search'] == $k['id_kategori']) ? 'selected' : '';
                  echo "<option value='{$k['id_kategori']}' $selected>{$k['nama_kategori']}</option>";
                }
                ?>
              </select>
              <div class="relative">
                <input type="text" name="search" value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>" placeholder="Cari produk..." class="niskala-input pl-10 pr-4 py-2 rounded-full border border-twig bg-kraft/50 text-sm text-charcoal focus:outline-none focus:border-moss transition-all w-48 sm:w-64">
                <div class="absolute left-3 top-1/2 -translate-y-1/2 text-mist">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                  </svg>
                </div>
              </div>
              <button type="submit" class="bg-moss text-white px-4 py-2 rounded-full text-sm hover:bg-canopy transition-all font-semibold shadow-sm">Cari</button>
            </form>
          </div>

          <div class="p-6 overflow-x-auto">
            <table class="w-full text-sm text-left border-collapse">
              <thead>
                <tr class="border-b-2 border-twig/30">
                  <th class="py-3 px-4 font-semibold uppercase tracking-wide text-xs text-mist">NO</th>
                  <th class="py-3 px-4 font-semibold uppercase tracking-wide text-xs text-mist">Nama</th>
                  <th class="py-3 px-4 font-semibold uppercase tracking-wide text-xs text-mist">Harga</th>
                  <th class="py-3 px-4 font-semibold uppercase tracking-wide text-xs text-mist">Stok</th>
                  <th class="py-3 px-4 font-semibold uppercase tracking-wide text-xs text-mist">Foto</th>
                  <th class="py-3 px-4 font-semibold uppercase tracking-wide text-xs text-mist">Kategori</th>
                  <th class="py-3 px-4 font-semibold uppercase tracking-wide text-xs text-mist">Deskripsi</th>
                  <th class="py-3 px-4 font-semibold uppercase tracking-wide text-xs text-mist">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 1;
                $search = isset($_GET['search']) ? mysqli_real_escape_string($koneksi, $_GET['search']) : '';
                $kat_search = isset($_GET['kategori_search']) ? mysqli_real_escape_string($koneksi, $_GET['kategori_search']) : '';
                
                $queryStr = "SELECT p.*, k.nama_kategori FROM tb_produk p, tb_kategori k WHERE p.id_kategori = k.id_kategori";
                if ($search != '') {
                    $queryStr .= " AND p.nama_produk LIKE '%$search%'";
                }
                if ($kat_search != '') {
                    $queryStr .= " AND p.id_kategori = '$kat_search'";
                }
                $queryStr .= " ORDER BY p.id DESC";
                
                $hasil = mysqli_query($koneksi, $queryStr);
                while ($data = mysqli_fetch_array($hasil)) {
                  $stokClass = $data['stok'] <= 5 ? 'text-red-500 font-bold' : 'text-charcoal';
                ?>
                  <tr class="border-b border-twig/20 hover:bg-amber/5 transition-all">
                    <td class="py-4 px-4 text-charcoal"><?= $no++ ?></td>
                    <td class="py-4 px-4 text-charcoal font-medium"><?= $data['nama_produk'] ?></td>
                    <td class="py-4 px-4 text-charcoal">Rp <?= number_format($data['harga'], 0, ',', '.') ?></td>
                    <td class="py-4 px-4 <?= $stokClass ?>"><?= $data['stok'] ?></td>
                    <td class="py-4 px-4 text-mist">
                      <div class="w-16 h-16 rounded-xl overflow-hidden border border-twig/20 bg-gray-100 shadow-sm">
                        <img
                          src="../assets/img/<?= $data['poto'] ?>"
                          alt="<?= htmlspecialchars($data['nama_produk']) ?>"
                          class="w-full h-full object-cover hover:scale-105 transition-transform duration-200">
                      </div>
                    </td>
                    <td class="py-4 px-4 text-charcoal"><?= $data['nama_kategori'] ?></td>
                      <td class="py-4 px-4 text-mist max-w-[200px] truncate"><?= $data['deskripsi'] ?></td>
                      <td class="py-4 px-4 flex gap-1">
                        <a href="ubah_stok.php?id=<?= $data['id'] ?>" class="bg-moss/10 text-moss text-xs font-semibold px-3 py-1.5 rounded-full hover:bg-moss/20 transition-all">Stok</a>
                        <a href="edit.php?id=<?= $data['id'] ?>" class="bg-amber/10 text-amber text-xs font-semibold px-3 py-1.5 rounded-full hover:bg-amber/20 transition-all">Edit</a>
                        <a href="hapus.php?id=<?= $data['id'] ?>" class="bg-red-500/10 text-red-500 text-xs font-semibold px-3 py-1.5 rounded-full hover:bg-red-500/20 transition-all">Hapus</a>
                      </td>
                    </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

    </main>

  </div>

  <script>
    // File input cancel button functionality
    const fileInput = document.getElementById('poto');
    const cancelBtn = document.getElementById('btnCancelFile');

    if (fileInput && cancelBtn) {
      fileInput.addEventListener('change', function() {
        if (this.value) {
          cancelBtn.style.display = 'inline-block';
        } else {
          cancelBtn.style.display = 'none';
        }
      });

      cancelBtn.addEventListener('click', function() {
        fileInput.value = '';
        this.style.display = 'none';
      });
    }
  </script>

</body>

</html>