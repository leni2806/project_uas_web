<?php
require "../config/database.php";
require "../layout/header.php";

if (isset($_POST['simpan'])) {
    $nama        = $_POST['nama_makeup'];
    $kategori    = $_POST['kategori'];
    $harga_jual  = $_POST['harga_jual'];
    $harga_beli  = $_POST['harga_beli'];
    $stok        = $_POST['stok'];

    // upload gambar
    $gambar = $_FILES['gambar']['name'];
    $tmp    = $_FILES['gambar']['tmp_name'];

    move_uploaded_file($tmp, "../images/" . $gambar);

    mysqli_query($conn, "
        INSERT INTO makeup 
        (nama_makeup, kategori, harga_jual, harga_beli, stok, gambar)
        VALUES
        ('$nama', '$kategori', '$harga_jual', '$harga_beli', '$stok', '$gambar')
    ");

    header("Location: ../index.php");
    exit;
}
?>

<div class="card form-card p-4 fade-in">
    <h4 class="form-title">💄 Tambah Produk Makeup</h4>

    <form method="POST" enctype="multipart/form-data">

        <div class="mb-3">
            <label class="form-label">Nama Produk</label>
            <input type="text" name="nama_makeup" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Kategori Makeup</label>
            <input type="text" name="kategori" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Harga Jual</label>
            <input type="number" name="harga_jual" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Harga Beli</label>
            <input type="number" name="harga_beli" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Stok</label>
            <input type="number" name="stok" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Foto Produk</label>
            <input type="file" name="gambar" class="form-control" required>
        </div>

        <div class="d-flex gap-2">
            <button name="simpan" class="btn btn-pink">
                💾 Simpan
            </button>
            <a href="../index.php" class="btn btn-pink-outline">
                Kembali
            </a>
        </div>

    </form>
</div>


<?php require "../layout/footer.php"; ?>
