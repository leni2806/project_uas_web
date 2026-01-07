<?php
require "config/database.php";

$per_page = 2;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;

$start = ($page - 1) * $per_page;

$keyword = isset($_GET['cari']) ? $_GET['cari'] : '';
$keyword = mysqli_real_escape_string($conn, $keyword);

$where = "";
if ($keyword != "") {
    $where = "WHERE nama LIKE '%$keyword%' 
              OR kategori LIKE '%$keyword%'";
}

// DATA PRODUK MAKEUP
$data = mysqli_query(
    $conn,
    "SELECT * FROM makeup $where LIMIT $start, $per_page"
);

// TOTAL DATA
$total = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "SELECT COUNT(*) AS total FROM makeup $where"
    )
)['total'];

$total_page = ceil($total / $per_page);
