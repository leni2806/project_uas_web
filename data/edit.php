<?php
require "../config/database.php";
require "../layout/header.php";

// ===========================
// AMBIL ID DARI URL
// ===========================
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if ($id <= 0) {
    die("ID tidak valid!");
}

// ===========================
// AMBIL DATA PRODUK LAMA
// ===========================
$sql = "SELECT * FROM makeup WHERE id = $id";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Query error: " . mysqli_error($conn));
}

$data = mysqli_fetch_assoc($result);

if (!$data) {
    die("Data tidak ditemukan!");
}

// ===========================
// PROSES UPDATE JIKA FORM DIKIRIM
// ===========================
if (isset($_POST['update'])) {
    $nama       = mysqli_real_escape_string($conn, $_POST['nama']);
    $kategori   = mysqli_real_escape_string($conn, $_POST['kategori']);
    $harga_jual = (int) $_POST['harga_jual'];
    $harga_beli = (int) $_POST['harga_beli'];
    $stok       = (int) $_POST['stok'];

    // ===========================
    // CEK APAKAH GAMBAR DIGANTI
    // ===========================
    if (!empty($_FILES['gambar']['name'])) {
        $gambar = $_FILES['gambar']['name'];
        $tmp    = $_FILES['gambar']['tmp_name'];

        // Pindahkan file ke folder images
        move_uploaded_file($tmp, "../images/" . $gambar);

        $sql_update = "
            UPDATE makeup SET
                nama='$nama',
                kategori='$kategori',
                harga_jual=$harga_jual,
                harga_beli=$harga_beli,
                stok=$stok,
                gambar='$gambar'
            WHERE id=$id
        ";
    } else {
        $sql_update = "
            UPDATE makeup SET
                nama='$nama',
                kategori='$kategori',
                harga_jual=$harga_jual,
                harga_beli=$harga_beli,
                stok=$stok
            WHERE id=$id
        ";
    }

    // Eksekusi query
    if (mysqli_query($conn, $sql_update)) {
        header("Location: ../index.php");
        exit;
    } else {
        die("Update gagal: " . mysqli_error($conn));
    }
}
?>

<div class="card shadow border-0">
    <div class="card-header bg-light">
        <h5 class="mb-0">💄 Edit Produk Makeup</h5>
    </div>

    <div class="card-body">
        <form method="POST" enctype="multipart/form-data">

            <div class="mb-3">
                <label>Nama Produk</label>
                <input type="text" name="nama_barang" class="form-control"
                       value="<?= htmlspecialchars($data['nama']); ?>" required>
            </div>

            <div class="mb-3">
                <label>Kategori Makeup</label>
                <input type="text" name="kategori" class="form-control"
                       value="<?= htmlspecialchars($data['kategori']); ?>" required>
            </div>

            <div class="mb-3">
                <label>Harga Jual</label>
                <input type="number" name="harga_jual" class="form-control"
                       value="<?= $data['harga_jual']; ?>" required>
            </div>

            <div class="mb-3">
                <label>Harga Beli</label>
                <input type="number" name="harga_beli" class="form-control"
                       value="<?= $data['harga_beli']; ?>" required>
            </div>

            <div class="mb-3">
                <label>Stok</label>
                <input type="number" name="stok" class="form-control"
                       value="<?= $data['stok']; ?>" required>
            </div>

            <div class="mb-3">
                <label>Gambar (kosongkan jika tidak diganti)</label><br>
                <img src="../images/<?= $data['gambar']; ?>" width="80" class="mb-2 rounded">
                <input type="file" name="gambar" class="form-control">
            </div>

            <button name="update" class="btn btn-primary">Update</button>
            <a href="../index.php" class="btn btn-secondary">Kembali</a>

        </form>
    </div>
</div>

<?php require "../layout/footer.php"; ?>
