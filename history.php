<?php
session_start();
require 'koneksi/koneksi.php';
include 'header.php';

if (empty($_SESSION['USER'])) {
    echo '<script>alert("Harap Login");window.location="index.php"</script>';
    exit;
}

$id_login = $_SESSION['USER']['id_login'];

$sql = "SELECT mobil.merk, booking.* 
        FROM booking 
        JOIN mobil ON booking.id_mobil = mobil.id_mobil 
        WHERE booking.id_login = :id_login 
        ORDER BY booking.id_booking DESC";

$stmt = $koneksi->prepare($sql);
$stmt->execute(['id_login' => $id_login]);
$hasil = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-lg border-0 rounded">
                <div class="card-header bg-primary text-white text-center">
                    <h4><i class="fas fa-list"></i> Daftar Transaksi</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped table-bordered">
                            <thead class="table-dark text-center">
                                <tr>
                                    <th>No.</th>
                                    <th>Kode Booking</th>
                                    <th>Merk Mobil</th>
                                    <th>Nama</th>
                                    <th>Tanggal Sewa</th>
                                    <th>Lama Sewa</th>
                                    <th>Total Harga</th>
                                    <th>Konfirmasi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (count($hasil) > 0): ?>
                                    <?php $no = 1; foreach ($hasil as $isi): ?>
                                        <tr class="text-center align-middle">
                                            <td><?= $no; ?></td>
                                            <td><span class="badge bg-info text-dark">#<?= htmlspecialchars($isi['kode_booking']); ?></span></td>
                                            <td><?= htmlspecialchars($isi['merk']); ?></td>
                                            <td><?= htmlspecialchars($isi['nama']); ?></td>
                                            <td><?= htmlspecialchars($isi['tanggal']); ?></td>
                                            <td><?= htmlspecialchars($isi['lama_sewa']); ?> hari</td>
                                            <td class="text-success fw-bold">Rp. <?= number_format($isi['total_harga']); ?></td>
                                            <td>
                                                <span class="badge <?= $isi['konfirmasi_pembayaran'] == 'Sudah' ? 'bg-success' : 'bg-danger'; ?>">
                                                    <?= htmlspecialchars($isi['konfirmasi_pembayaran']); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <a class="btn btn-sm btn-primary" href="bayar.php?id=<?= htmlspecialchars($isi['kode_booking']); ?>">
                                                    <i class="fas fa-eye"></i> Detail
                                                </a>   
                                            </td>
                                        </tr>
                                        <?php $no++; endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="9" class="text-center text-muted">Tidak ada transaksi ditemukan.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> 
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>