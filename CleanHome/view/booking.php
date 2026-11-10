<?php
// Memanggil class Booking, Customer, dan Service untuk mengakses database
require_once __DIR__ . '/../class/Booking.php';
require_once __DIR__ . '/../class/Customer.php';
require_once __DIR__ . '/../class/Service.php';

// Membuat objek Booking, Customer, dan Service
$booking = new Booking();
$customer = new Customer();
$service = new Service();

// Memproses penambahan data booking
if(isset($_POST['create'])){
    $result = $booking->createBooking($_POST['id_customer'], $_POST['id_service'], $_POST['tanggal_booking'], $_POST['jam_booking'], $_POST['jenis_properti'], $_POST['alamat_layanan'], $_POST['catatan'] ?: null, $_POST['status_booking'], $_POST['total_harga']);
    header("Location: booking.php?status=" . ($result ? "created" : "failed"));
    exit;
}

// Memproses perubahan data booking
if(isset($_POST['update'])){
    $result = $booking->updateBooking($_POST['id_customer'], $_POST['id_service'], $_POST['tanggal_booking'], $_POST['jam_booking'], $_POST['jenis_properti'], $_POST['alamat_layanan'], $_POST['catatan'] ?: null, $_POST['status_booking'], $_POST['total_harga'], $_POST['id_booking']);
    header("Location: booking.php?status=" . ($result ? "updated" : "failed"));
    exit;
}

// Memproses penghapusan data booking
if(isset($_POST['delete'])){
    $result = $booking->deleteBooking($_POST['id_booking']);
    header("Location: booking.php?status=" . ($result ? "deleted" : "failed"));
    exit;
}

// Menyiapkan variabel untuk data booking yang akan diedit
$editBooking = null;

// Mengambil data booking berdasarkan ID untuk proses edit
if(isset($_GET['edit'])){
    $editBooking = $booking->getBookingById($_GET['edit']);
}

// Mengambil seluruh data booking, customer, dan service dari database
$bookings = $booking->getAllBooking();
$customers = $customer->getAllCustomer();
$services = $service->getAllService();

// Mengambil status proses untuk menampilkan pesan
$status = $_GET['status'] ?? '';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Booking - CleanHome</title>

    <!-- Menghubungkan file CSS -->
    <link rel="stylesheet" href="../style.css">
</head>
<body>

<!-- Memanggil komponen header -->
<?php require_once 'header.php'; ?>

<main class="container">
    <h2>Manajemen Booking</h2>
    <p>Kelola data pemesanan layanan kebersihan CleanHome.</p>

    <!-- Menampilkan pesan berdasarkan hasil proses CRUD -->
    <?php if($status == 'created'): ?>
        <p>Booking berhasil ditambahkan!</p>
    <?php elseif($status == 'updated'): ?>
        <p>Booking berhasil diperbarui!</p>
    <?php elseif($status == 'deleted'): ?>
        <p>Booking berhasil dihapus!</p>
    <?php elseif($status == 'failed'): ?>
        <p>Proses gagal dilakukan!</p>
    <?php endif; ?>

    <!-- Form untuk menambahkan atau mengubah data booking -->
    <section>
        <h3><?= $editBooking ? 'Edit Booking' : 'Tambah Booking'; ?></h3>

        <form method="POST">

            <!-- Menyimpan ID booking ketika proses edit -->
            <?php if($editBooking): ?>
                <input type="hidden" name="id_booking" value="<?= htmlspecialchars($editBooking['id_booking']); ?>">
            <?php endif; ?>

            <!-- Memilih customer yang melakukan booking -->
            <label>Nama Pelanggan</label><br>
            <select name="id_customer" required>
                <option value="">Pilih Pelanggan</option>
                <?php foreach($customers as $row): ?>
                    <option value="<?= htmlspecialchars($row['id_customer']); ?>" <?= ($editBooking && $editBooking['id_customer'] == $row['id_customer']) ? 'selected' : ''; ?>>
                        <?= htmlspecialchars($row['nama_customer']); ?>
                    </option>
                <?php endforeach; ?>
            </select><br><br>

            <!-- Memilih layanan yang akan dipesan -->
            <label>Nama Layanan</label><br>
            <select name="id_service" required>
                <option value="">Pilih Layanan</option>
                <?php foreach($services as $row): ?>
                    <option value="<?= htmlspecialchars($row['id_service']); ?>" <?= ($editBooking && $editBooking['id_service'] == $row['id_service']) ? 'selected' : ''; ?>>
                        <?= htmlspecialchars($row['nama_service']); ?>
                    </option>
                <?php endforeach; ?>
            </select><br><br>

            <!-- Input tanggal booking -->
            <label>Tanggal Booking</label><br>
            <input type="date" name="tanggal_booking" value="<?= htmlspecialchars($editBooking['tanggal_booking'] ?? date('Y-m-d')); ?>" required><br><br>

            <!-- Input jam booking -->
            <label>Jam Booking</label><br>
            <input type="time" name="jam_booking" value="<?= htmlspecialchars($editBooking['jam_booking'] ?? ''); ?>" required><br><br>

            <!-- Memilih jenis properti customer -->
            <label>Jenis Properti</label><br>
            <select name="jenis_properti" required>
                <option value="">Pilih Jenis Properti</option>
                <option value="Rumah" <?= ($editBooking && $editBooking['jenis_properti'] == 'Rumah') ? 'selected' : ''; ?>>Rumah</option>
                <option value="Apartemen" <?= ($editBooking && $editBooking['jenis_properti'] == 'Apartemen') ? 'selected' : ''; ?>>Apartemen</option>
                <option value="Kos" <?= ($editBooking && $editBooking['jenis_properti'] == 'Kos') ? 'selected' : ''; ?>>Kos</option>
            </select><br><br>

            <!-- Input alamat lokasi layanan -->
            <label>Alamat Layanan</label><br>
            <textarea name="alamat_layanan" required><?= htmlspecialchars($editBooking['alamat_layanan'] ?? ''); ?></textarea><br><br>

            <!-- Input catatan tambahan booking -->
            <label>Catatan</label><br>
            <textarea name="catatan"><?= htmlspecialchars($editBooking['catatan'] ?? ''); ?></textarea><br><br>

            <!-- Memilih status booking -->
            <label>Status Booking</label><br>
            <select name="status_booking" required>
                <option value="">Pilih Status</option>
                <option value="Pending" <?= ($editBooking && $editBooking['status_booking'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                <option value="Confirmed" <?= ($editBooking && $editBooking['status_booking'] == 'Confirmed') ? 'selected' : ''; ?>>Confirmed</option>
                <option value="In Progress" <?= ($editBooking && $editBooking['status_booking'] == 'In Progress') ? 'selected' : ''; ?>>In Progress</option>
                <option value="Completed" <?= ($editBooking && $editBooking['status_booking'] == 'Completed') ? 'selected' : ''; ?>>Completed</option>
                <option value="Cancelled" <?= ($editBooking && $editBooking['status_booking'] == 'Cancelled') ? 'selected' : ''; ?>>Cancelled</option>
            </select><br><br>

            <!-- Input total harga booking -->
            <label>Total Harga (Rp)</label><br>
            <input type="number" name="total_harga" min="0" step="0.01" value="<?= htmlspecialchars($editBooking['total_harga'] ?? ''); ?>" required><br><br>

            <!-- Tombol disesuaikan dengan proses yang dilakukan -->
            <?php if($editBooking): ?>
                <button type="submit" name="update">Update Booking</button>
                <a href="booking.php">Batal</a>
            <?php else: ?>
                <button type="submit" name="create">Tambah Booking</button>
            <?php endif; ?>
        </form>
    </section>

    <hr>

    <!-- Menampilkan seluruh data booking -->
    <section>
        <h3>Daftar Booking</h3>
        <table border="1" cellpadding="10" cellspacing="0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Pelanggan</th>
                    <th>Layanan</th>
                    <th>Tanggal</th>
                    <th>Jam</th>
                    <th>Jenis Properti</th>
                    <th>Alamat</th>
                    <th>Catatan</th>
                    <th>Status</th>
                    <th>Total Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                <!-- Melakukan perulangan untuk menampilkan data booking -->
                <?php if(!empty($bookings)): ?>
                    <?php $no = 1; ?>
                    <?php foreach($bookings as $row): ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= htmlspecialchars($customer->getAllCustomerById($row['id_customer'])['nama_customer'] ?? 'Tidak ditemukan'); ?></td>
                            <td><?= htmlspecialchars($service->getServiceById($row['id_service'])['nama_service'] ?? 'Tidak ditemukan'); ?></td>
                            <td><?= htmlspecialchars($row['tanggal_booking']); ?></td>
                            <td><?= htmlspecialchars($row['jam_booking']); ?></td>
                            <td><?= htmlspecialchars($row['jenis_properti']); ?></td>
                            <td><?= htmlspecialchars($row['alamat_layanan']); ?></td>
                            <td><?= htmlspecialchars($row['catatan'] ?? ''); ?></td>
                            <td><?= htmlspecialchars($row['status_booking']); ?></td>
                            <td>Rp <?= number_format($row['total_harga'], 0, ',', '.'); ?></td>
                            <td>
                                <!-- Form untuk memilih data yang akan diedit -->
                                <form method="GET" style="display:inline;">
                                    <input type="hidden" name="edit" value="<?= htmlspecialchars($row['id_booking']); ?>">
                                    <button type="submit" class="btn-edit">Edit</button>
                                </form>

                                <!-- Form untuk menghapus data booking -->
                                <form method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus booking ini?')">
                                    <input type="hidden" name="id_booking" value="<?= htmlspecialchars($row['id_booking']); ?>">
                                    <button type="submit" name="delete">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                <!-- Pesan jika belum terdapat data booking -->
                <?php else: ?>
                    <tr>
                        <td colspan="11">Belum ada data booking.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </section>
</main>

<!-- Memanggil komponen footer -->
<?php require_once 'footer.php'; ?>

</body>
</html>