<?php
session_start();
ob_start();
if (isset($_SESSION['isLogin'])) {
    header("Location: index.php");
}
$login_message = "";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300..700&display=swap" rel="stylesheet">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <style>
        <?php include "css/style.css" ?>
    </style>
</head>

<body>
    <section class="login">
        <div class="login-container">
            <div class="login-header">
                <h2>Login</h2>
            </div>
            <div class="login-form">
                <form action="login.php" method="POST" name="formLogin">
                    <input type="text" name="email" placeholder="Email" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <i><?=$login_message ?></i>
                    <p>Belum Memiliki Akun? <span><a href="register.php">Daftar Sekarang</a></span></p>
                    <input name="login" type="submit" value="Login" class="btn">
                </form>
                <?php
                include "service/connection.php";
                if (isset($_POST['login'])) {
                    $email = $_POST['email'];
                    $password = $_POST['password'];
                    $hash_password = hash("sha256", $password);
                    try {
                        $query = "select *from akun where email='$email' and password='$hash_password'";
                        $result = mysqli_query($db, $query);
                        if ($result->num_rows > 0) {
                            $data = $result->fetch_assoc();
                            $_SESSION["username"] = $data["username"];
                            $_SESSION["akses"] = $data["akses"];
                            $_SESSION["isLogin"] = true;
                            $_SESSION["content"] = "All";
                            // $username = $_GET['username'];
                            header("Location: index.php");
                            echo "<script>alert ('berhasil')</script>";
                            exit();

                        } else {
                            $login_message = "Akun tidak ditemukan";
                            // echo "<script>alert ('Gagal Login')</script>";
                        }
                    } catch (mysqli_sql_exception) {
                        $login_message = "Akun tidak ditemukan";
                    }
                    $db->close();
                }
                ?>
            </div>
        </div>
    </section>
</body>

</html>