<?php
session_start();
require 'koneksi.php';

$keranjang = $_SESSION['keranjang'] ?? [];
$total = 0;
$bahan_detail = [];

foreach ($keranjang as $id => $porsi) {
    $stmt = $conn->prepare(query: "SELECT * FROM bahan WHERE id = :id");
    $stmt->bindParam(param: ':id', var: $id, type: PDO::PARAM_INT);
    $stmt->execute();
    $b = $stmt->fetch(mode: PDO::FETCH_ASSOC);
    $b['porsi'] = $porsi;
    $b['subtotal'] = $porsi * $b['harga'];
    $total += $b['subtotal'];
    $bahan_detail[] = $b;
}
?>

<h2>Keranjang Belanja</h2>
<table border="1">
<tr><th>Nama</th><th>Harga</th><th>Porsi</th><th>Subtotal</th><th>Aksi</th></tr>
<?php foreach ($bahan_detail as $b): ?>
<tr>
    <td><?= $b['nama'] ?></td>
    <td><?= $b['harga'] ?></td>
    <td>
        <form action="crud.php" method="post" style="display:inline">
            <input type="hidden" name="aksi" value="ubah">
            <input type="hidden" name="id" value="<?= $b['id'] ?>">
            <input type="number" name="porsi" value="<?= $b['porsi'] ?>" min="1">
            <button type="submit">Ubah</button>
        </form>
    </td>
    <td><?= $b['subtotal'] ?></td>
    <td><a href="crud.php?aksi=hapus&id=<?= $b['id'] ?>">Hapus</a></td>
</tr>
<?php endforeach; ?>
<tr><td colspan="3">Total</td><td colspan="2">Rp<?= $total ?></td></tr>
</table>

<a href="index.php">Kembali Pilih Bahan</a>
