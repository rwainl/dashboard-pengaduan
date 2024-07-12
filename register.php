<?php
session_start();
ob_start();
// if (isset($_SESSION['isLogin'])) {
//     header("Location: index.php");
// }
$register_message = "";
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
                <h2>Daftar</h2>
            </div>
            <div class="login-form">
                <form action="" method="POST" name="formLogin">
                    <input type="text" name="email" placeholder="Email" required>
                    <i><?php echo $register_message?></i>
                    <input type="text" name="username" placeholder="Username" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <p>Sudah Memiliki Akun? <span><a href="login.php">Login Sekarang</a></span></p>
                    <input name="daftar" type="submit" value="Daftar" class="btn">
                </form>
                <?php 
                include "service/connection.php";
                if (isset($_POST['daftar'])) {
                    $email = $_POST['email'];
                    $username = $_POST['username'];
                    $password = $_POST['password'];
                    $hash_password = hash("sha256", $password);
                    $akses = "User";
                    try {
                        $query = "insert into akun values('$email','$username','$hash_password','$akses')";
                        if ($db->query($query)) {
                            echo "<script>alert('Pendaftaran Berhasil');</script>";
                            header("Location: login.php");
                        } else {
                            echo "<script>alert('Pendaftaran Gagal')</script>";
                        }
                    } catch (mysqli_sql_exception) {
                        $register_message = "Email Sudah Digunakan";
                    }
                }
                ?>
            </div>
        </div>
    </section>
</body>

</html>