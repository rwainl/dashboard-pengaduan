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

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        <?php include "css/style.css"; ?>
    </style>
</head>

<body>
    <section id="gambarLaporan">
        <div class="image">
            <?php
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $queryGambar = "select gambar from laporanmasuk where id='$id'";
                $resultGambar = mysqli_query($db, $queryGambar);
                while ($row = mysqli_fetch_array($resultGambar)) {
                    try {
                        echo '<img src="data:image/jpeg;base64,' . base64_encode($row['gambar']) . '" alt="Gambar Laporan"/>';
                    } catch (mysqli_sql_exception) {
                        die("Error");
                    }
                }
            }
            ?>
        </div>
    </section>
</body>

</html>