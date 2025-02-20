<?php 
include "../function.php";
include "../db.php";


if(!empty($_GET["id"])) {
    $lastId = $_GET["id"];
} 
else if (empty($_GET['id'])) {
    header("Location: tiket.php");
    exit();
}


// Tangkap Jumlah Tiket
$jmlhTiket = query("SELECT * FROM pemesanan WHERE id = $lastId")[0]["jumlah_tiket"];

// Memasukkan data ke database 
if (isset($_POST["detail"])) {
    $nama = $_POST["nama"];
    $telp = $_POST["telp"];

    for ($i = 0; $i < $jmlhTiket; $i++) {
        $namaSanitized = mysqli_real_escape_string($conn, $nama[$i]);
        $telpSanitized = mysqli_real_escape_string($conn, $telp[$i]);

        $query = "INSERT INTO detail_tiket (id, transaksi_id, nama_pelanggan, telp, pembayaran_id) 
                    VALUES (NULL, '$lastId', '$namaSanitized', '$telpSanitized', 1)";
        mysqli_query($conn, $query);
    }

    // Redirect atau tampilkan pesan sukses
    header("Location: ../pembayaran/cek_pembayaran.php");
    exit();
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Tiket</title>
    <link rel="stylesheet" href="../style/style_detail_tiket.css">
</head>
<body>
    <form action="" method="post">
        <?php for ($i = 1; $i <= $jmlhTiket; $i++) : ?>
            <h3>Detail Tiket <?= $i; ?></h3>
            <label for="nama-<?= $i; ?>">Nama: </label>
            <input type="text" name="nama[]" id="nama-<?= $i; ?>" required><br>

            <label for="telp-<?= $i; ?>">Telp: </label>
            <input type="text" name="telp[]" id="telp-<?= $i; ?>" required><br>
        <?php endfor; ?>

        <button type="submit" name="detail">Tambahkan</button>
    </form>
</body>
