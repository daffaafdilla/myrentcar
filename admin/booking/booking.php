<?php
    require '../../koneksi/koneksi.php';
    $title_web = 'Daftar Booking';
    include '../header.php';
    
    if(empty($_SESSION['USER'])) {
        session_start();
    }
    
    if(!empty($_GET['id'])) {
        $id = strip_tags($_GET['id']);
        $sql = "SELECT mobil.merk, booking.* FROM booking JOIN mobil ON 
                booking.id_mobil=mobil.id_mobil WHERE id_login = '$id' ORDER BY id_booking DESC";
    } else {
        $sql = "SELECT mobil.merk, booking.* FROM booking JOIN mobil ON 
                booking.id_mobil=mobil.id_mobil ORDER BY id_booking DESC";
    }
    
    $hasil = $koneksi->query($sql)->fetchAll();
?>

<div class="container my-5">
    <div class="card shadow-lg border-0 rounded-3">
        <div class="card-header bg-primary text-white text-center py-3">
            <h3 class="fw-bold mb-0">Daftar Booking</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered text-center">
                    <thead class="table-dark">
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
                    <tbody class="align-middle">
                        <?php $no = 1; foreach ($hasil as $isi) { ?>
                        <tr>
                            <td class="fw-bold"><?php echo $no; ?></td>
                            <td><?= $isi['kode_booking']; ?></td>
                            <td><?= $isi['merk']; ?></td>
                            <td><?= $isi['nama']; ?></td>
                            <td><?= date('d M Y', strtotime($isi['tanggal'])); ?></td>
                            <td><?= $isi['lama_sewa']; ?> hari</td>
                            <td class="text-success fw-bold">Rp. <?= number_format($isi['total_harga']); ?></td>
                            <td>
                                <span class="badge <?php echo ($isi['konfirmasi_pembayaran'] == 'Sudah') ? 'bg-success' : 'bg-danger'; ?>">
                                    <?= $isi['konfirmasi_pembayaran']; ?>
                                </span>
                            </td>
                            <td>
                                <a class="btn btn-sm btn-primary" href="bayar.php?id=<?= $isi['kode_booking']; ?>">
                                    <i class="fas fa-info-circle"></i> Detail
                                </a>
                            </td>
                        </tr>
                        <?php $no++; } ?>
                    </tbody>
                </table>
            </div>
            <hr>
            <div class="text-end">
                <a href="laporan.php" class="btn btn-success">
                    <i class="fas fa-file-download"></i> Unduh CSV
                </a>
            </div>
        </div>
    </div>
</div>

<?php include '../footer.php'; ?>