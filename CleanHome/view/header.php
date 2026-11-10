<?php
// Menentukan path berdasarkan lokasi halaman yang sedang dibuka
$basePath = (basename(dirname($_SERVER['SCRIPT_NAME'])) === 'view') ? '..' : '.';
?>

<!-- Bagian header web -->
<header>
    <h1>CleanHome</h1>
    <nav>
        <ul>
            <!-- Tombol navigasi -->
            <li><a href="<?= $basePath ?>/index.php">Home</a></li>
            <li><a href="<?= $basePath ?>/view/customer.php">Daftar Pelanggan</a></li>
            <li><a href="<?= $basePath ?>/view/service.php">Daftar Layanan</a></li>
            <li><a href="<?= $basePath ?>/view/booking.php">Daftar Pemesanan</a></li>
        </ul>
    </nav>
</header>