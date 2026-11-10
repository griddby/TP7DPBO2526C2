<?php
// Memanggil class Service untuk mengakses database
require_once __DIR__ . '/../class/Service.php';

// Membuat objek Service
$service = new Service();

// Memproses penambahan data layanan
if(isset($_POST['create'])){
    $result = $service->createService($_POST['nama_service'], $_POST['deskripsi'], $_POST['durasi'], $_POST['harga']);
    header("Location: service.php?status=" . ($result ? "created" : "failed"));
    exit;
}

// Memproses perubahan data layanan
if(isset($_POST['update'])){
    $result = $service->updateService($_POST['nama_service'], $_POST['deskripsi'], $_POST['durasi'], $_POST['harga'], $_POST['id_service']);
    header("Location: service.php?status=" . ($result ? "updated" : "failed"));
    exit;
}

// Memproses penghapusan data layanan
if(isset($_POST['delete'])){
    $result = $service->deleteService($_POST['id_service']);
    header("Location: service.php?status=" . ($result ? "deleted" : "failed"));
    exit;
}

// Mengambil data layanan berdasarkan ID untuk proses edit
$editService = null;

if(isset($_GET['edit'])){
    $editService = $service->getServiceById($_GET['edit']);
}

// Mengambil seluruh data layanan dari database
$services = $service->getAllService();

// Mengambil status proses untuk menampilkan pesan
$status = $_GET['status'] ?? '';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Layanan - CleanHome</title>

    <!-- Menghubungkan file CSS -->
    <link rel="stylesheet" href="../style.css">
</head>
<body>

<!-- Memanggil komponen header -->
<?php require_once 'header.php'; ?>

<main class="container">
    <h2>Manajemen Layanan</h2>
    <p>Kelola data layanan kebersihan CleanHome.</p>

    <!-- Menampilkan pesan berdasarkan hasil proses CRUD -->
    <?php if($status == 'created'): ?>
        <p>Layanan berhasil ditambahkan!</p>
    <?php elseif($status == 'updated'): ?>
        <p>Layanan berhasil diperbarui!</p>
    <?php elseif($status == 'deleted'): ?>
        <p>Layanan berhasil dihapus!</p>
    <?php elseif($status == 'failed'): ?>
        <p>Proses gagal dilakukan!</p>
    <?php endif; ?>

    <!-- Form untuk menambahkan atau mengubah data layanan -->
    <section>
        <h3><?= $editService ? 'Edit Layanan' : 'Tambah Layanan'; ?></h3>

        <form method="POST">
            <!-- Menyimpan ID layanan ketika proses edit -->
            <?php if($editService): ?>
                <input type="hidden" name="id_service" value="<?= htmlspecialchars($editService['id_service']); ?>">
            <?php endif; ?>

            <!-- Input nama layanan -->
            <label>Nama Layanan</label><br>
            <input type="text" name="nama_service" value="<?= htmlspecialchars($editService['nama_service'] ?? ''); ?>" required><br><br>

            <!-- Input deskripsi layanan -->
            <label>Deskripsi</label><br>
            <textarea name="deskripsi"><?= htmlspecialchars($editService['deskripsi'] ?? ''); ?></textarea><br><br>

            <!-- Input durasi layanan -->
            <label>Durasi (Menit)</label><br>
            <input type="number" name="durasi" min="1" value="<?= htmlspecialchars($editService['durasi'] ?? ''); ?>" required><br><br>

            <!-- Input harga layanan -->
            <label>Harga (Rp)</label><br>
            <input type="number" name="harga" min="0" step="0.01" value="<?= htmlspecialchars($editService['harga'] ?? ''); ?>" required><br><br>

            <!-- Tombol disesuaikan dengan proses yang dilakukan -->
            <?php if($editService): ?>
                <button type="submit" name="update">Update Layanan</button>
                <a href="service.php">Batal</a>
            <?php else: ?>
                <button type="submit" name="create">Tambah Layanan</button>
            <?php endif; ?>
        </form>
    </section>
    
    <hr>
    <!-- Menampilkan seluruh data layanan -->
    <section>
        <h3>Daftar Layanan</h3>

        <table border="1" cellpadding="10" cellspacing="0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Layanan</th>
                    <th>Deskripsi</th>
                    <th>Durasi (Menit)</th>
                    <th>Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>

                <!-- Melakukan perulangan untuk menampilkan data layanan -->
                <?php if(!empty($services)): ?>
                    <?php $no = 1; ?>
                    <?php foreach($services as $row): ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= htmlspecialchars($row['nama_service']); ?></td>
                            <td><?= htmlspecialchars($row['deskripsi'] ?? ''); ?></td>
                            <td><?= htmlspecialchars($row['durasi']); ?> menit </td>
                            <td>Rp <?= number_format($row['harga'], 0, ',', '.'); ?></td>
                            <td>
                                <!-- Form untuk memilih data yang akan diedit -->
                                <form method="GET" style="display:inline;">
                                    <input type="hidden" name="edit" value="<?= htmlspecialchars($row['id_service']); ?>">
                                    <button type="submit" class="btn-edit">Edit</button>
                                </form>

                                <!-- Form untuk menghapus data layanan -->
                                <form method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus layanan ini?')">
                                    <input type="hidden" name="id_service" value="<?= htmlspecialchars($row['id_service']); ?>">
                                    <button type="submit" name="delete">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                <!-- Pesan jika belum terdapat data layanan -->
                <?php else: ?>
                    <tr>
                        <td colspan="6">Belum ada data layanan.</td>
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
