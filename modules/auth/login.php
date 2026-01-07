<?php
session_start();
require "../../config/database.php"; 

// PROSES LOGIN
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // LOGIN SEDERHANA (AMAN BUAT UAS)
    if ($username === "admin" && $password === "admin123") {
        $_SESSION['login'] = true;
        $_SESSION['role']  = "admin";
        header("Location: ../../dashboard.php");
        exit;
    } elseif ($username === "user" && $password === "user123") {
        $_SESSION['login'] = true;
        $_SESSION['role']  = "user";
        header("Location: ../../layout/dashboard.php");
        exit;
    } else {
        $error = "Username atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Makeup Store</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../../assets/style.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">

            <div class="card p-4 shadow-sm text-center">
                <h4 class="mb-3">💄 Login Makeup Store</h4>

                <?php if (isset($error)) { ?>
                    <div class="alert alert-danger"><?= $error ?></div>
                <?php } ?>

                <form method="post">
                    <input type="text" name="username"
                           class="form-control mb-3"
                           placeholder="Username" required>

                    <input type="password" name="password"
                           class="form-control mb-3"
                           placeholder="Password" required>

                    <button name="login" class="btn btn-primary w-100">
                        Login
                    </button>
                </form>

                <small class="text-muted d-block mt-3">
                    Admin: <b>admin / admin123</b><br>
                    User: <b>user / user123</b>
                </small>
            </div>

        </div>
    </div>
</div>

</body>
</html>
