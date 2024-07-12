<?php include "service/connection.php";
session_start();
ob_start();
if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("Location: login.php");
}
if (!isset($_SESSION['isLogin'])) {
    header("Location:
    login.php");
} ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    </head>

<body class="container">
<center>
    <table border="0" class="text-center">
        <tr>
            <th rowspan="4"><img src="assets/umi.png" width="150px" alt="..."></th>
            <th class="display-4">Universitas Methodist Indonesia</th>
        </tr>
        <tr>
            <th class="display-6">Laporan Pengaduan Mahasiswa</th>
        </tr>
        <tr>
            <th>JL. Hang Tuah No. 8, Madras Hulu Kec. Medan Polonia, Kota Medan, Sumatera Utara 20151</th>
        </tr>
        <tr>
            <th><hr style="border: 2px solid black;"></th>
        </tr>
    </table>
    </center>
    <br>
    <h1 align="center">Data Pengaduan Mahasiswa</h1>
    <br>
    <table border="1" class="table table-bordered">
        <tr>
            <th>No.</th>
            <th>NIM</th>
            <th>Nama</th>
            <th>Subjek</th>
            <th>Pesan</th>
            <th>Status</th>
            <th>Tanggal</th>
        </tr>
            <?php
            $no = 1;
            $queryData = "select *from laporanmasuk";
            $resultData = mysqli_query($db, $queryData);
            while($row = mysqli_fetch_assoc($resultData)){
                ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $row['nim'] ?></td>
                        <td><?= $row['nama'] ?></td>
                        <td><?= $row['subjek'] ?></td>
                        <td><?= $row['pesan'] ?></td>
                        <td><?= $row['status'] ?></td>
                        <td><?= $row['tanggal'] ?></td>
                    </tr>
                <?php
            }
            ?>
        </table>
    </center>
    <a href="exportword.php">
        <button class="btn btn-warning">Download</button>
    </a>

</body>

</html>