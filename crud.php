<?php
session_start();
require 'koneksi.php';

$aksi = $_POST['aksi'] ?? $_GET['aksi'] ?? '';

if ($aksi === 'tambah') {
    $bahan_ids = $_POST['bahan'] ?? [];
    $porsi = max(1, (int)($_POST['porsi'] ?? 1));
    
    foreach ($bahan_ids as $id) {
        if (!isset($_SESSION['keranjang'][$id])) {
            $_SESSION['keranjang'][$id] = $porsi;
        } else {
            $_SESSION['keranjang'][$id] += $porsi;
        }
    }

    header(header: 'Location: keranjang.php');
    exit;
}

if ($aksi === 'hapus' && isset($_GET['id'])) {
    unset($_SESSION['keranjang'][$_GET['id']]);
    header(header: 'Location: keranjang.php');
    exit;
}

if ($aksi === 'ubah' && isset($_POST['id'], $_POST['porsi'])) {
    $_SESSION['keranjang'][$_POST['id']] = max(1, (int)$_POST['porsi']);
    header(header: 'Location: keranjang.php');
    exit;
}
