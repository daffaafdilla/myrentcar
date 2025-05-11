<?php
    session_start();
    require 'koneksi/koneksi.php';
    include 'header.php';

    if(empty($_SESSION['USER'])) {
        echo '<script>alert("Harap login!");window.location="index.php"</script>';
        exit;
    }

    $kode_booking = $_GET['id'] ?? '';
    $stmt = $koneksi->prepare("SELECT * FROM booking WHERE kode_booking = ?");
    $stmt->execute([$kode_booking]);
    $hasil = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$hasil) {
        die("Data booking tidak ditemukan.");
    }

    $id_mobil = $hasil['id_mobil'];
    $stmtMobil = $koneksi->prepare("SELECT * FROM mobil WHERE id_mobil = ?");
    $stmtMobil->execute([$id_mobil]);
    $isi = $stmtMobil->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Booking</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <style>
        body {
            background: linear-gradient(135deg, #eef2f3, #ffffff);
        }
        .card-custom {
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
            transition: transform 0.3s;
        }
        .card-custom:hover {
            transform: scale(1.02);
        }
        .status-available {
            background-color: #28a745 !important;
        }
        .status-unavailable {
            background-color: #dc3545 !important;
        }
        .btn-custom {
            border-radius: 50px;
            font-weight: bold;
            background: linear-gradient(90deg, #007bff, #0056b3);
            color: white;
            border: none;
            padding: 10px 20px;
        }
        .btn-custom:hover {
            background: linear-gradient(90deg, #0056b3, #004494);
        }
        .center-button {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row">
            <div class="col-md-4">
                <div class="card card-custom">
                    <div class="card-body text-center">
                        <h5>Pembayaran Dapat Melalui :</h5>
                        <hr/>
                        <p class="fw-bold"> <?= htmlspecialchars($info_web->no_rek); ?> </p>
                    </div>
                </div>
                <br/>
                <div class="card card-custom">
                    <div class="card-body text-center">
                        <img src="assets/image/<?= htmlspecialchars($isi['gambar']); ?>" alt="Foto Mobil" class="img-fluid rounded" style="max-height: 200px; object-fit: cover;">
                        <h5 class="mt-3 fw-bold"> <?= htmlspecialchars($isi['merk']); ?> </h5>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item text-white <?= $isi['status'] == 'Tersedia' ? 'status-available' : 'status-unavailable'; ?>">
                            <i class="fa <?= $isi['status'] == 'Tersedia' ? 'fa-check' : 'fa-times'; ?>"></i> 
                            <?= $isi['status'] == 'Tersedia' ? 'Available' : 'Not Available'; ?>
                        </li>
                        <li class="list-group-item bg-info text-white"><i class="fa fa-gift"></i> Free E-toll 50k</li>
                        <li class="list-group-item bg-dark text-white"><i class="fa fa-money-bill-wave"></i> Rp. <?= number_format($isi['harga']); ?> / day</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card card-custom">
                    <div class="card-body">
                        <h4 class="fw-bold text-center mb-3">Detail Booking</h4>
                        <table class="table table-striped">
                            <tr><td><b>Kode Booking</b></td><td>:</td><td><?= htmlspecialchars($hasil['kode_booking']); ?></td></tr>
                            <tr><td><b>KTP</b></td><td>:</td><td><?= htmlspecialchars($hasil['ktp']); ?></td></tr>
                            <tr><td><b>Nama</b></td><td>:</td><td><?= htmlspecialchars($hasil['nama']); ?></td></tr>
                            <tr><td><b>Telepon</b></td><td>:</td><td><?= htmlspecialchars($hasil['no_tlp']); ?></td></tr>
                            <tr><td><b>Tanggal Sewa</b></td><td>:</td><td><?= htmlspecialchars($hasil['tanggal']); ?></td></tr>
                            <tr><td><b>Lama Sewa</b></td><td>:</td><td><?= htmlspecialchars($hasil['lama_sewa']); ?> hari</td></tr>
                            <tr><td><b>Total Harga</b></td><td>:</td><td>Rp. <?= number_format($hasil['total_harga']); ?></td></tr>
                            <tr><td><b>Status</b></td><td>:</td><td><span class="badge bg-<?= $hasil['konfirmasi_pembayaran'] == 'Belum Bayar' ? 'danger' : 'success'; ?>"> <?= htmlspecialchars($hasil['konfirmasi_pembayaran']); ?> </span></td></tr>
                        </table>
                        <?php if($hasil['konfirmasi_pembayaran'] == 'Belum Bayar'){ ?>
                            <div class="center-button">
                                <a href="konfirmasi.php?id=<?= urlencode($kode_booking); ?>" class="btn btn-custom btn-lg">Konfirmasi Pembayaran</a>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>