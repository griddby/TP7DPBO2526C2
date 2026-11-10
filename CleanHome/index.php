<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Judul halaman website -->
    <title>CleanHome - Home Cleaning Service</title>
    <!-- Menghubungkan file CSS -->
    <link rel="stylesheet" href="style.css">
</head>
<body>

<!-- Memanggil komponen header dan navigasi -->
<?php require_once 'view/header.php'; ?>

<!-- Konten utama halaman -->
<main class="container">
    <!-- Bagian sambutan website -->
    <section class="welcome">
        <h2>Welcome to CleanHome</h2>
        <p>Sistem Manajemen Home Cleaning untuk mengelola pelanggan, layanan kebersihan, dan pemesanan jasa.</p>
    </section>

    <!-- Bagian menu pengelolaan data -->
    <section class="management">
        <h2>Management Menu</h2>

        <!-- Menampilkan tiga card menu utama -->
        <div class="card-container">

            <!-- Card untuk pengelolaan data customer -->
            <div class="card">
                <span class="card-number">01</span>
                <h3>Pelanggan</h3>
                <p>Kelola data pelanggan yang menggunakan layanan CleanHome.</p>
                <a href="view/customer.php">Read More</a>
            </div>

            <!-- Card untuk pengelolaan data service -->
            <div class="card">
                <span class="card-number">02</span>
                <h3>Layanan</h3>
                <p>Kelola daftar layanan kebersihan beserta durasi dan harganya.</p>
                <a href="view/service.php">Read More</a>
            </div>

            <!-- Card untuk pengelolaan data booking -->
            <div class="card">
                <span class="card-number">03</span>
                <h3>Pemesanan</h3>
                <p>Kelola pemesanan layanan, jadwal, dan status booking pelanggan.</p>
                <a href="view/booking.php">Read More</a>
            </div>

        </div>
    </section>
</main>

<!-- Memanggil komponen footer -->
<?php require_once 'view/footer.php'; ?>

</body>
</html>
