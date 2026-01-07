<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: modules/auth/login.php");
    exit;
}

require "config/database.php";
require "data/barang.php";
require "layout/header.php";
?>

<!-- HEADER + LOGIN / LOGOUT -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">Daftar Produk Makeup</h4>

    <?php if (!isset($_SESSION['login'])): ?>
        <!-- BELUM LOGIN -->
        <a href="modules/auth/login.php" class="btn btn-outline-primary">
            Login
        </a>
    <?php else: ?>
        <!-- SUDAH LOGIN -->
        <div class="d-flex gap-2">
            <a href="dashboard.php" class="btn btn-outline-secondary">
                Dashboard
            </a>
            <a href="modules/auth/logout.php" class="btn btn-outline-danger">
                Logout
            </a>
        </div>
    <?php endif; ?>
</div>

<!-- TOMBOL TAMBAH + FORM CARI -->
<div class="row mb-3">
    <div class="col-md-6">
        <?php if (isset($_SESSION['login']) && $_SESSION['role'] == 'admin'): ?>
            <a href="data/add.php" class="btn btn-primary">
                + Tambah Produk
            </a>
        <?php endif; ?>
    </div>

    <div class="col-md-6">
        <form method="GET" class="d-flex justify-content-end">
            <input type="text"
                   name="cari"
                   class="form-control w-50 me-2"
                   placeholder="Cari produk..."
                   value="<?= isset($_GET['cari']) ? $_GET['cari'] : '' ?>">
            <button class="btn btn-primary">Cari</button>
        </form>
    </div>
</div>

<!-- TABEL DATA -->
<table class="table table-bordered text-center align-middle">
    <thead class="table-light">
        <tr>
            <th>Gambar</th>
            <th>Nama Produk</th>
            <th>Kategori</th>
            <th>Harga Jual</th>
            <th>Harga Beli</th>
            <th>Stok</th>
            <?php if (isset($_SESSION['login']) && $_SESSION['role'] == 'admin'): ?>
                <th>Aksi</th>
            <?php endif; ?>
        </tr>
    </thead>

    <tbody>
        <?php if (mysqli_num_rows($data) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($data)) { ?>
            <tr>
                <td>
                    <img src="images/<?= $row['gambar']; ?>" width="60">
                </td>
                <td><?= $row['nama']; ?></td>
                <td><?= $row['kategori']; ?></td>
                <td><?= number_format($row['harga_jual'], 0, ',', '.'); ?></td>
                <td><?= number_format($row['harga_beli'], 0, ',', '.'); ?></td>
                <td><?= $row['stok']; ?></td>

                <?php if (isset($_SESSION['login']) && $_SESSION['role'] == 'admin'): ?>
<td>
    <a href="data/edit.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
    <a href="data/delete.php?id=<?= $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus produk?')">Delete</a>
</td>
                <?php endif; ?>
            </tr>
            <?php } ?>
        <?php else: ?>
            <tr>
                <td colspan="7">Data tidak ditemukan</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<!-- PAGINATION -->
<nav>
<ul class="pagination justify-content-center">
<?php
$cari = isset($_GET['cari']) ? $_GET['cari'] : '';
?>

<?php if ($page > 1): ?>
<li class="page-item">
    <a class="page-link" href="?page=<?= $page - 1 ?>&cari=<?= $cari ?>">&laquo;</a>
</li>
<?php endif; ?>

<?php for ($i = 1; $i <= $total_page; $i++): ?>
<li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
    <a class="page-link" href="?page=<?= $i ?>&cari=<?= $cari ?>">
        <?= $i ?>
    </a>
</li>
<?php endfor; ?>

<?php if ($page < $total_page): ?>
<li class="page-item">
    <a class="page-link" href="?page=<?= $page + 1 ?>&cari=<?= $cari ?>">&raquo;</a>
</li>
<?php endif; ?>
</ul>
</nav>

<?php require "layout/footer.php"; ?>
