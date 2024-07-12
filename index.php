<?php
include "service/connection.php";
session_start();
ob_start();
if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("Location: login.php");
}
if (!isset($_SESSION['isLogin'])) {
    header("Location: login.php");
}
$_SESSION['content'];
$resultTampil;
// $itemSearch;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum Pengaduan</title>
    <!-- <link rel="stylesheet" href="style.css"> -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300..700&display=swap" rel="stylesheet">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
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
                <!-- <i class="bx bx-menu" id="iconMenu"></i> -->
                <nav class="navbar">
                    <ul>
                        <li><a href="#beranda" class="active">Dashboard</a></li>
                    </ul>
                    <ul>
                        <li><a href="#daftar-pengaduan">Daftar Pengaduan</a></li>
                    </ul>
                    <ul>
                        <li><a href="form.php#form-pengaduan">Form Pengaduan</a></li>
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
                        <li>
                            <form action="index.php" method="post"><button type="submit" name="logout">Log Out</button>
                            </form>
                        </li>
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
                        <form action="index.php" method="post">
                            <input type="text" name="itemC" placeholder="Search">
                            <button type="submit" name="buttonC">Search</button>
                        </form>
                        <?php
                        // if (isset($_POST['buttonC'])) {
                        //     $itemSearch = $_POST['itemC'];
                        //     $_SESSION['content'] = "Cari";
                        //     header("Location: index.php#daftar-pengaduan");
                        // } else {
                        //     die("Error");
                        // }
                        ?>
                    </div>
                </div>
            </section>
        </div>
    </header>
    <section id="daftar-pengaduan">
        <div class="container">
            <div class="left">
                <div class="header">
                    <h4>Daftar Pengaduan Terbaru</h4>
                </div>
                <hr>
                <div class="card-container">
                    <?php
                    $case1 = "Cari";
                    $case2 = "Selesai";
                    $case3 = "Dalam Pengerjaan";
                    $case4 = "Belum Selesai";
                    if ($_SESSION['content'] == $case2) {
                        $queryTampil = "select *from laporanmasuk where status='$case2'";
                        $resultTampil = mysqli_query($db, $queryTampil);
                    } else if ($_SESSION['content'] == $case3) {
                        $queryTampil = "select *from laporanmasuk where status='$case3'";
                        $resultTampil = mysqli_query($db, $queryTampil);
                    } else if ($_SESSION['content'] == $case4) {
                        $queryTampil = "select *from laporanmasuk where status='$case4'";
                        $resultTampil = mysqli_query($db, $queryTampil);
                    } else if ($_SESSION['content'] == $case1) {
                        $itemS;
                        if (isset($_GET['itemSearch'])) {
                            $itemS = $_GET['itemSearch'];
                        }
                        $queryTampil = "select *from laporanmasuk where subjek like '%$itemS%'";
                        $resultTampil = mysqli_query($db, $queryTampil);
                    } else {
                        $queryTampil = "select *from laporanmasuk";
                        $resultTampil = mysqli_query($db, $queryTampil);
                    }
                    while ($row = mysqli_fetch_assoc($resultTampil)) {
                        // $id = $row['id'];
                        ?>
                        <div class="card">
                            <h2><?= $row['subjek'] ?></h2>
                            <h5><span><?= $row['tanggal'] ?> </span>(<?= $row['status'] ?>)</h5>
                            <h5 class="namaCard"><?= $row['nama'] ?></h5>
                            <p><?= $row['pesan'] ?></p>
                            <?php
                            if (!$row['gambar'] == NULL) {
                                ?>
                                <div class="button-thumbnail">
                                    <div class="thumb">
                                        <form action="gambar.php?id=<?= $row['id'] ?>" method="post">
                                            <button type="submit" name="gambar">Lihat Gambar</button>
                                        </form>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            <?php
                            $akses = "Admin";
                            if ($_SESSION['akses'] == $akses) {
                                ?>
                                <div class="admin-button">
                                    <form action="index.php?id=<?= $row['id'] ?>" method="POST">
                                        <div class="abutton">
                                            <button type="submit" name="buttonS" class="selesai">Selesai</button>
                                        </div>
                                        <div class="abutton">
                                            <button type="submit" name="buttonDP" class="dpengerjaan">Dalam Pengerjaan</button>
                                        </div>
                                        <div class="abutton">
                                            <button type="submit" name="buttonBS" class="bselesai">Belum Selesai</button>
                                        </div>
                                        <div class="abutton">
                                            <button type="submit" name="buttonH" class="bhapus">Hapus</button>
                                        </div>
                                    </form>
                                </div>
                                <?php
                                if (isset($_GET['id'])) {
                                    $id = $_GET['id'];
                                    if (isset($_POST['buttonH'])) {
                                        $queryHapus = "delete from laporanmasuk where id='$id'";
                                        $resultHapus = mysqli_query($db, $queryHapus);
                                        if ($resultHapus) {
                                            try {
                                                echo "<script>alert('berhasil')</script>";
                                                header("Location: index.php#daftar-pengaduan");
                                            } catch (mysqli_sql_exception) {
                                                // die("Error");
                                                echo "<script>alert('gagal')</script>";
                                            }
                                        }
                                    }
                                }
                            }
                            ?>
                        </div>
                        <?php
                    }

                    if (isset($_GET['id'])) {
                        $id = $_GET['id'];
                        if (isset($_POST['buttonS'])) {
                            $status = "Selesai";
                            $queryUpdate = "update laporanmasuk set status='$status' where id='$id'";
                            $resultUpdate = mysqli_query($db, $queryUpdate);
                            if ($resultUpdate) {
                                try {
                                    echo "<script>alert('Status Berhasil Diperbarui');</script>";
                                    header("Location: index.php#daftar-pengaduan");
                                    // exit();
                                } catch (mysqli_sql_exception) {
                                    die("error");
                                }
                            } else {
                                die("error");
                            }
                        } else if (isset($_POST['buttonDP'])) {
                            $status = "Dalam Pengerjaan";
                            $queryUpdate = "update laporanmasuk set status='$status' where id='$id'";
                            $resultUpdate = mysqli_query($db, $queryUpdate);
                            if ($resultUpdate) {
                                try {
                                    echo "<script>alert('Status Berhasil Diperbarui');</script>";
                                    header("Location: index.php#daftar-pengaduan");
                                    // exit();
                                } catch (mysqli_sql_exception) {
                                    die("error");
                                }
                            }
                        } else if (isset($_POST['buttonBS'])) {
                            $status = "Belum Selesai";
                            $queryUpdate = "update laporanmasuk set status='$status' where id='$id'";
                            $resultUpdate = mysqli_query($db, $queryUpdate);
                            if ($resultUpdate) {
                                try {
                                    echo "<script>alert('Status Berhasil Diperbarui');</script>";
                                    header("Location: index.php#daftar-pengaduan");
                                    // exit();
                                } catch (mysqli_sql_exception) {
                                    die("error");
                                }
                            }
                        }
                    }

                    ?>
                    <!-- <div class="card">
                        <h2>Judul Pengaduan</h2>
                        <h5>Status</h5>
                        <h5>Nama</h5>
                        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Nostrum doloribus nulla quam nemo
                            beatae consequuntur quidem alias atque sapiente vitae quae obcaecati sit, ratione, inventore
                            unde repudiandae, expedita impedit! Quasi.</p>
                        <div class="button-thumbs">
                            <div class="thumb-up">
                                <span class="material-symbols-outlined">
                                    thumb_up
                                </span>
                            </div>
                            <div class="thumb-down">
                                <span class="material-symbols-outlined">
                                    thumb_down
                                </span>
                            </div>
                        </div>
                        <div class="admin-button">
                            <div class="abutton">
                                <span class="selesai">Selesai</span>
                            </div>
                            <div class="abutton">
                                <span class="dpengerjaan">Dalam Pengerjaan</span>
                            </div>
                            <div class="abutton">
                                <span class="bselesai">Belum Selesai</span>
                            </div>
                        </div>
                    </div> -->
                </div>
                <div class="footer"></div>
            </div>
            <div class="right">
                <div class="boxc">
                    <div class="card-container">
                        <div class="card">
                            <h3>Jumlah Pengaduan Masuk</h3>
                            <?php
                            $queryJumlahMasuk = "select count(*) from laporanmasuk";
                            $resultJumlahMasuk = mysqli_query($db, $queryJumlahMasuk);
                            while ($row = mysqli_fetch_assoc($resultJumlahMasuk)) {
                                echo "<h4>" . $row['count(*)'] . "</h4>";
                            }
                            ?>
                            <!-- <h4>5</h4> -->
                            <div class="button">
                                <form action="index.php" method="post">
                                    <button name="buttonA" type="submit">
                                        <p>Lihat Selengkapnya</p>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="card">
                            <h3>Jumlah Pengaduan Selesai</h3>
                            <?php
                            $queryJumlahS = "select count(status) from laporanmasuk where status='Selesai'";
                            $resultJumlahS = mysqli_query($db, $queryJumlahS);
                            while ($row = mysqli_fetch_assoc($resultJumlahS)) {
                                echo "<h4>" . $row['count(status)'] . "</h4>";
                            }
                            ?>
                            <!-- <h4>5</h4> -->
                            <div class="button">
                                <form action="index.php" method="post">
                                    <button name="buttonPS" type="submit">
                                        <p>Lihat Selengkapnya</p>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="card">
                            <h3>Jumlah Pengaduan Dalam Pengerjaan</h3>
                            <?php
                            $queryJumlahS = "select count(status) from laporanmasuk where status='Dalam Pengerjaan'";
                            $resultJumlahS = mysqli_query($db, $queryJumlahS);
                            while ($row = mysqli_fetch_assoc($resultJumlahS)) {
                                echo "<h4>" . $row['count(status)'] . "</h4>";
                            }
                            ?>
                            <!-- <h4>5</h4> -->
                            <div class="button">
                                <form action="index.php" method="post">
                                    <button name="buttonPDP" type="submit">
                                        <p>Lihat Selengkapnya</p>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="card">
                            <h3>Jumlah Pengaduan Belum Selesai</h3>
                            <?php
                            $queryJumlahS = "select count(status) from laporanmasuk where status='Belum Selesai'";
                            $resultJumlahS = mysqli_query($db, $queryJumlahS);
                            while ($row = mysqli_fetch_assoc($resultJumlahS)) {
                                echo "<h4>" . $row['count(status)'] . "</h4>";
                            }
                            ?>
                            <!-- <h4>5</h4> -->
                            <div class="button">
                                <form action="index.php" method="post">
                                    <button name="buttonPBS" type="submit">
                                        Lihat Selengkapnya
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php
    if (isset($_POST['buttonPS'])) {
        $_SESSION['content'] = "Selesai";
        header("Location: index.php#daftar-pengaduan");
    } else if (isset($_POST['buttonPDP'])) {
        $_SESSION['content'] = "Dalam Pengerjaan";
        header("Location: index.php#daftar-pengaduan");
    } else if (isset($_POST['buttonPBS'])) {
        $_SESSION['content'] = "Belum Selesai";
        header("Location: index.php#daftar-pengaduan");
    } else if (isset($_POST['buttonA'])) {
        $_SESSION['content'] = "All";
        header("Location: index.php#daftar-pengaduan");
    } else if (isset($_POST['buttonC'])) {
        $_SESSION['content'] = "Cari";
        $itemSearch = $_POST['itemC'];
        header("Location: index.php?itemSearch=$itemSearch");
    } else {
        $_SESSION['content'] = "All";
        // header("Location: index.php#daftar-pengaduan");
    }
    ?>

    <footer class="footer">
        <div class="social">
            <a href="https://web.facebook.com/methodist.indonesia"><i class="bx bxl-facebook"></i></a>
            <a href="https://www.instagram.com/universitasmethodistindonesia/?hl=en"><i
                    class="bx bxl-instagram"></i></a>
        </div>
        <div class="contact">
            <div class="con-container">
                <div class="con1">
                    <h1><span class="material-symbols-outlined">
                            corporate_fare
                        </span> Tentang UMI</h1>
                    <p align="justify">Universitas Methodist Indonesia adalah lembaga Pendidikan Tinggi yang
                        bertekad untuk
                        turut serta
                        membangun negeri dalam mencerdaskan kehidupan bangsa.</p>
                </div>
                <div class="con2">
                    <h1><span class="material-symbols-outlined">
                            menu_book
                        </span> Fakultas</h1>
                    <ul>
                        <li>Fakultas Sastra</li>
                        <li>Fakultas Kedokteran</li>
                        <li>Fakultas Pertanian</li>
                        <li>Fakultas Ekonomi</li>
                        <li>Fakultas Ilmu Komputer</li>
                    </ul>
                </div>
                <div class="con3">
                    <h1><span class="material-symbols-outlined">
                            manufacturing
                        </span> Fasilitas</h1>
                    <ul>
                        <li>Laboratorium Komputer</li>
                        <li>Fasilitas Olahraga</li>
                        <li>Laboratorium Akutansi</li>
                        <li>Laboratorium Biologi</li>
                        <li>Perpustakaan</li>
                    </ul>
                </div>
                <div class="con4">
                    <h1><span class="material-symbols-outlined">
                            call
                        </span> Kontak</h1>
                    <ul>
                        <li>Biro Rektorat UMI</li>
                        <li>JL. Hang Tuah No. 8 Medan</li>
                        <li>Madras Hulu Medan Polonia, Medan</li>
                        <li>20151, Phone +62 61 415-7882</li>
                        <li>Fax. +62 61 456-7533</li>
                    </ul>
                </div>
            </div>
        </div>
        <p class="copyright">
            &copy
        </p>
    </footer>

    <script src="js/script.js"></script>
</body>



</html>