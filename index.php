<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['keranjang'])) {
    $_SESSION['keranjang'] = [];
}

$bahan = $conn->query(query: "SELECT * FROM bahan")->fetchAll(mode: PDO::FETCH_ASSOC);
?>

<h2>Pilih Bahan Jamu</h2>
<form action="crud.php" method="post">
    <input type="hidden" name="aksi" value="tambah">
    <?php foreach ($bahan as $b): ?>
        <input type="checkbox" name="bahan[]" value="<?= $b['id'] ?>"> <?= $b['nama'] ?> <?= $b['deskripsi'] ?> (Rp<?= $b['harga'] ?>)<br>
    <?php endforeach; ?>
    Porsi: <input type="number" name="porsi" value="1" min="1"><br>
    <button type="submit">Tambah ke Keranjang</button>
</form>

<a href="keranjang.php">Lihat Keranjang</a>
