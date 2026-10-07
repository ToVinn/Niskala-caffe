<?php
session_start();
include 'koneksi.php';

if (!isset($_GET['id'])) {
    die("ID Transaksi tidak ditemukan.");
}

$id_transaksi = (int)$_GET['id'];

// Ambil info transaksi
$queryTrx = mysqli_query($koneksi, "
    SELECT t.*, u.name, u.username, u.email, u.hp, u.alamat 
    FROM tb_transaksi t 
    LEFT JOIN tb_user u ON t.id_pelanggan = u.id 
    WHERE t.id_transaksi = '$id_transaksi'
");

if (mysqli_num_rows($queryTrx) == 0) {
    die("Transaksi tidak ditemukan.");
}

$trx = mysqli_fetch_assoc($queryTrx);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Nota Transaksi #<?= $id_transaksi ?></title>
  <style>
    body {
        font-family: 'Courier New', Courier, monospace;
        background: #f4f4f4;
        padding: 20px;
    }
    .nota-container {
        background: #fff;
        max-width: 600px;
        margin: 0 auto;
        padding: 30px;
        border: 1px dashed #ccc;
    }
    .header { text-align: center; border-bottom: 2px dashed #333; padding-bottom: 10px; margin-bottom: 20px; }
    .header h2 { margin: 0; font-size: 24px; }
    .header p { margin: 5px 0 0; font-size: 14px; }
    .info { margin-bottom: 20px; font-size: 14px; }
    .info table { width: 100%; }
    .info td { padding: 3px 0; }
    .items { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
    .items th, .items td { text-align: left; padding: 8px 0; border-bottom: 1px dashed #ccc; }
    .items th.right, .items td.right { text-align: right; }
    .total-row { font-weight: bold; font-size: 16px; }
    .total-row td { border-top: 2px dashed #333; border-bottom: none; padding-top: 15px; }
    .footer { text-align: center; margin-top: 30px; font-size: 13px; }
    .btn-print {
        display: block; width: 100px; margin: 30px auto; padding: 10px; text-align: center;
        background: #333; color: #fff; text-decoration: none; cursor: pointer; border-radius: 5px;
    }
    @media print {
        body { background: #fff; padding: 0; }
        .nota-container { border: none; padding: 0; }
        .btn-print { display: none; }
    }
  </style>
</head>
<body>

<div class="nota-container">
    <div class="header">
        <h2>NISKALLA CAFFE</h2>
        <p>Jl. Kopi Kenangan No. 1, Jakarta</p>
        <p>Telp: 08123456789</p>
    </div>

    <div class="info">
        <table>
            <tr>
                <td width="30%"><strong>No. Nota</strong></td>
                <td>: TRX-<?= str_pad($id_transaksi, 5, "0", STR_PAD_LEFT) ?></td>
            </tr>
            <tr>
                <td><strong>Tanggal</strong></td>
                <td>: <?= date('d M Y', strtotime($trx['tanggal'])) ?></td>
            </tr>
            <tr>
                <td><strong>Pelanggan</strong></td>
                <td>: <?= htmlspecialchars($trx['name'] ?? $trx['username'] ?? 'User Dihapus') ?></td>
            </tr>
            <tr>
                <td><strong>No HP</strong></td>
                <td>: <?= htmlspecialchars($trx['hp'] ?? '-') ?></td>
            </tr>
            <tr>
                <td><strong>Alamat</strong></td>
                <td>: <?= htmlspecialchars($trx['alamat'] ?? '-') ?></td>
            </tr>
            <tr>
                <td><strong>Tipe Pesanan</strong></td>
                <td>: <?= htmlspecialchars($trx['metode_kirim'] ?? 'Dine-in') ?></td>
            </tr>
            <tr>
                <td><strong>Pembayaran</strong></td>
                <td>: <?= htmlspecialchars($trx['metode_bayar'] ?? 'Transfer Bank') ?></td>
            </tr>
        </table>
    </div>

    <table class="items">
        <thead>
            <tr>
                <th>Produk</th>
                <th class="right">Jml</th>
                <th class="right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $queryDetail = mysqli_query($koneksi, "
                SELECT d.*, p.nama_produk, p.harga 
                FROM tb_detail d 
                JOIN tb_produk p ON d.id_produk = p.id 
                WHERE d.id_transaksi = '$id_transaksi'
            ");
            while ($dt = mysqli_fetch_assoc($queryDetail)):
                $subtotal = $dt['jumlah'] * $dt['harga'];
            ?>
            <tr>
                <td><?= htmlspecialchars($dt['nama_produk']) ?><br><small>@ Rp <?= number_format($dt['harga'], 0, ',', '.') ?></small></td>
                <td class="right"><?= $dt['jumlah'] ?></td>
                <td class="right">Rp <?= number_format($subtotal, 0, ',', '.') ?></td>
            </tr>
            <?php endwhile; ?>
            <tr class="total-row">
                <td colspan="2">TOTAL</td>
                <td class="right">Rp <?= number_format($trx['total_harga'], 0, ',', '.') ?></td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <p>Terima kasih atas kunjungan Anda!</p>
        <p>Taste Everything</p>
        <br>
        <a href="index.php" style="color: #333; text-decoration: underline;">Kembali ke Beranda</a>
    </div>
</div>

<button class="btn-print" onclick="window.print()">Cetak Nota</button>

</body>
</html>
