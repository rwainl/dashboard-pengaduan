<?php
session_start();
ob_start();
if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("Location: login.php");
}
if(!isset($_SESSION['isLogin'])){
    header("Location: login.php");
}
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
    <header>
        <div class="container">
            <div class="top">
                <div class="navbar-brand">
                    <div class="brand">Dashboard Pengaduan</div>
                </div>
                <i class="bx bx-menu" id="iconMenu"></i>
                <nav class="navbar">
                    <ul>
                        <li><a href="index.php#beranda">Dashboard</a></li>
                    </ul>
                    <ul>
                        <li><a href="index.php#daftar-pengaduan">Daftar Pengaduan</a></li>
                    </ul>
                    <ul>
                        <li><a href="#form-pengaduan" class="active">Form Pengaduan</a></li>
                    </ul>
                    <?php
                    $akses = "Admin";
                    if ($_SESSION['akses'] == $akses) {
                        ?>
                        <ul>
                            <li><a href="export.php">Export Data</a></li>
                        </ul>
                        <?php
                    }
                    ?>
                    <ul>
                        <li><form action="index.php" method="post"><button type="submit" name="logout">Log Out</button></form></li>
                    </ul>
                </nav>
            </div>
            <section id="beranda">
                <div class="middle">
                    <div class="container">
                        <h3>Selamat Datang di Website Pengaduan Mahasiswa</h3>
                        <p align="center">Website ini dibuat khusus untuk mahasiswa agar memudahkan<br> mereka
                            memberikan
                            pengaduan yang mereka inginkan</p>
                        <!-- <form action="">
                            <input type="search" name="search" placeholder="Search">
                            <button type="submit" name="submit">Search</button>
                        </form> -->
                    </div>
                </div>
            </section>
        </div>
    </header>
    <section id="form-pengaduan">
        <div class="container">
            <div class="box">
                <div class="header">
                    <h4>Form Pengaduan</h4>
                </div>
                <div class="main">
                    <form action="form.php" method="POST" enctype="multipart/form-data">
                        <input type="text" name="nim" placeholder="Nomor Induk Mahasiswa" required>
                        <input type="text" name="nama" placeholder="Nama" required>
                        <input type="text" name="subjek" placeholder="Subjek Pesan" required>
                        <textarea name="pesan" cols="30" rows="10" placeholder="Pesan" required></textarea>
                        <p>*Opsional</p>
                        <input type="file" name="gambar" placeholder="" required>
                        <input type="hidden" name="tanggal" value="<?php echo date("d-m-Y"); ?>">
                        <div class="button">
                            <input name="submit" type="submit" value="Kirim Pesan" class="btn">
                        </div>
                    </form>
                        <?php
                        include "service/connection.php";
                        if (isset($_POST['submit'])) {
                            $id = time();
                            $nim = $_POST['nim'];
                            $nama = $_POST['nama'];
                            $subjek = $_POST['subjek'];
                            $pesan = $_POST['pesan'];
                            $date = $_POST['tanggal'];
                            
                            $allowed = ['png', 'gif', 'jpg', 'jpeg'];
                            $img_data = addslashes(file_get_contents($_FILES['gambar']['tmp_name']));
                            // $file_img = $_FILES['gambar']['name'];

                            $status = "Belum Selesai";
                                $queryKirim = "insert into laporanmasuk values ('$id','$nim','$nama','$subjek','$pesan','$status','$date','$img_data')";
                                $resultKirim = mysqli_query($db, $queryKirim);
                                if ($resultKirim) {
                                    try{
                                        // echo '<script type="text/JavaScript"> alert("Data Berhasil Dikirim"); </script>';
                                        echo "<script>alert('Data Berhasil Dikirim, Silahkan Kembali ke Daftar Pengaduan');</script>";
                                        header ("Location: index.php#daftar-pengaduan");
                                    }catch(mysqli_sql_exception){
                                        die("Error");
                                    }
                                } else {
                                    die("Error");
                                }
                            $db->close();
                        }
                        ?>
                </div>
            </div>
        </div>
    </section>
    

    <script src="js/script.js"></script>
</body>

</html>