<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../modules/auth/login.php");
    exit;
}

require "layout/header.php";
?>

<!-- HEADER DASHBOARD -->
<h3 class="mb-2">💄 Dashboard Makeup Store</h3>
<p class="text-muted">
    Login sebagai: <b><?= htmlspecialchars($_SESSION['role']); ?></b>
</p>

<div class="row mt-4 g-3">

    <!-- DATA PRODUK -->
    <div class="col-md-4">
        <div class="card p-4 text-center shadow-sm card-soft">
            <h5>📦 Data Produk</h5>
            <p class="small text-muted">Lihat semua produk makeup</p>
            <a href="index.php" class="btn btn-pink w-100 mt-2">
                Lihat Produk
            </a>
        </div>
    </div>

    <!-- TAMBAH PRODUK (ADMIN SAJA) -->
    <?php if ($_SESSION['role'] == 'admin'): ?>
    <div class="col-md-4">
        <div class="card p-4 text-center shadow-sm card-soft">
            <h5>➕ Tambah Produk</h5>
            <p class="small text-muted">Input produk makeup baru</p>
            <a href="data/add.php" class="btn btn-purple w-100 mt-2">
                Tambah Produk
            </a>
        </div>
    </div>
    <?php endif; ?>

    <!-- LOGOUT -->
    <div class="col-md-4">
        <div class="card p-4 text-center shadow-sm card-soft">
            <h5>🚪 Logout</h5>
            <p class="small text-muted">Keluar dari sistem</p>
            <a href="modules/auth/logout.php" class="btn btn-pink-soft w-100 mt-2">
                Logout
            </a>
        </div>
    </div>

</div>

<?php require "layout/footer.php"; ?>
