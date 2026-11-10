<?php
// Memanggil class Customer untuk mengakses database
require_once __DIR__ . '/../class/Customer.php';

// Membuat objek Customer
$customer = new Customer();

// Memproses penambahan data customer
if(isset($_POST['create'])){
    $result = $customer->createCustomer($_POST['nama_customer'], $_POST['email'], $_POST['no_telepon']);
    header("Location: customer.php?status=" . ($result ? "created" : "failed"));
    exit;
}

// Memproses perubahan data customer
if(isset($_POST['update'])){
    $result = $customer->updateCustomer($_POST['id_customer'], $_POST['nama_customer'], $_POST['email'], $_POST['no_telepon']);
    header("Location: customer.php?status=" . ($result ? "updated" : "failed"));
    exit;
}

// Memproses penghapusan data customer
if(isset($_POST['delete'])){
    $result = $customer->deleteCustomer($_POST['id_customer']);
    header("Location: customer.php?status=" . ($result ? "deleted" : "failed"));
    exit;
}

// Menyiapkan variabel untuk data customer yang akan diedit
$editCustomer = null;

// Mengambil data customer berdasarkan ID untuk proses edit
if(isset($_GET['edit'])){
    $editCustomer = $customer->getAllCustomerById($_GET['edit']);
}

// Mengambil seluruh data customer dari database
$customers = $customer->getAllCustomer();

// Mengambil status proses untuk menampilkan pesan
$status = $_GET['status'] ?? '';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Customer - CleanHome</title>

    <!-- Menghubungkan file CSS -->
    <link rel="stylesheet" href="../style.css">
</head>
<body>

<!-- Memanggil komponen header -->
<?php require_once 'header.php'; ?>

<main class="container">
    <h2>Manajemen Customer</h2>
    <p>Kelola data pelanggan CleanHome.</p>

    <!-- Menampilkan pesan berdasarkan hasil proses CRUD -->
    <?php if($status == 'created'): ?>
        <p>Customer berhasil ditambahkan!</p>
    <?php elseif($status == 'updated'): ?>
        <p>Customer berhasil diperbarui!</p>
    <?php elseif($status == 'deleted'): ?>
        <p>Customer berhasil dihapus!</p>
    <?php elseif($status == 'failed'): ?>
        <p>Proses gagal dilakukan!</p>
    <?php endif; ?>

    <!-- Form untuk menambahkan atau mengubah data customer -->
    <section>
        <h3><?= $editCustomer ? 'Edit Pelanggan' : 'Tambah Pelanggan'; ?></h3>

        <form method="POST">

            <!-- Menyimpan ID customer ketika proses edit -->
            <?php if($editCustomer): ?>
                <input type="hidden" name="id_customer" value="<?= htmlspecialchars($editCustomer['id_customer']); ?>">
            <?php endif; ?>

            <!-- Input nama customer -->
            <label>Nama Pelanggan</label><br>
            <input type="text" name="nama_customer" value="<?= htmlspecialchars($editCustomer['nama_customer'] ?? ''); ?>" required><br><br>

            <!-- Input email customer -->
            <label>Email Pelanggan</label>
            <input type="email" name="email" value="<?= htmlspecialchars($editCustomer['email'] ?? ''); ?>" required><br><br>

            <!-- Input nomor telepon customer -->
            <label>Nomor Telepon Pelanggan</label>
            <input type="text" name="no_telepon" value="<?= htmlspecialchars($editCustomer['no_telepon'] ?? ''); ?>" required><br><br>

            <!-- Tombol disesuaikan dengan proses yang dilakukan -->
            <?php if($editCustomer): ?>
                <button type="submit" name="update">Update Pelanggan</button>
                <a href="customer.php">Batal</a>
            <?php else: ?>
                <button type="submit" name="create">Tambah Pelanggan</button>
            <?php endif; ?>
        </form>
    </section>

    <hr>

    <!-- Menampilkan seluruh data customer -->
    <section>
        <h3>Daftar Pelanggan</h3>
        <table border="1" cellpadding="10" cellspacing="0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Pelanggan</th>
                    <th>Email</th>
                    <th>No Telepon</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                <!-- Melakukan perulangan untuk menampilkan data customer -->
                <?php if(!empty($customers)): ?>
                    <?php $no = 1; ?>
                    <?php foreach($customers as $row): ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= htmlspecialchars($row['nama_customer']); ?></td>
                            <td><?= htmlspecialchars($row['email']); ?></td>
                            <td><?= htmlspecialchars($row['no_telepon']); ?></td>
                            <td>
                                <!-- Form untuk memilih data yang akan diedit -->
                                <form method="GET" style="display:inline;">
                                    <input type="hidden" name="edit" value="<?= htmlspecialchars($row['id_customer']); ?>">
                                    <button type="submit" class="btn-edit">Edit</button>
                                </form>

                                <!-- Form untuk menghapus data customer -->
                                <form method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus pelanggan ini?')">
                                    <input type="hidden" name="id_customer" value="<?= htmlspecialchars($row['id_customer']); ?>">
                                    <button type="submit" name="delete">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                <!-- Pesan jika belum terdapat data customer -->
                <?php else: ?>
                    <tr>
                        <td colspan="5">Belum ada data customer.</td>
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
