<?php
    require '../../koneksi/koneksi.php';
    $title_web = 'Konfirmasi';
    include '../header.php';
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if (empty($_SESSION['USER'])) {
        echo '<script>alert("Login dulu");window.location="index.php"</script>';
    }
    
    $kode_booking = $_GET['id'];
    $hasil = $koneksi->query("SELECT * FROM booking WHERE kode_booking = '$kode_booking'")->fetch();
    $id_booking = $hasil['id_booking'];
    $hsl = $koneksi->query("SELECT * FROM pembayaran WHERE id_booking = '$id_booking'")->fetch();
    $c = $koneksi->query("SELECT * FROM pembayaran WHERE id_booking = '$id_booking'")->rowCount();
    $id = $hasil['id_mobil'];
    $isi = $koneksi->query("SELECT * FROM mobil WHERE id_mobil = '$id'")->fetch();
?>

<div class="container my-5">
    <div class="row">
        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white text-center">
                    <h5 class="mb-0">Detail Pembayaran</h5>
                </div>
                <div class="card-body">
                    <?php if($c > 0) { ?>
                        <table class="table table-striped">
                            <tr><td>No Rekening</td><td>:</td><td><?= $hsl['no_rekening']; ?></td></tr>
                            <tr><td>Atas Nama</td><td>:</td><td><?= $hsl['nama_rekening']; ?></td></tr>
                            <tr><td>Nominal</td><td>:</td><td>Rp. <?= number_format($hsl['nominal']); ?></td></tr>
                            <tr><td>Tgl Transfer</td><td>:</td><td><?= $hsl['tanggal']; ?></td></tr>
                        </table>
                    <?php } else { ?>
                        <h4 class="text-danger text-center">Belum dibayar</h4>
                    <?php } ?>
                </div>
            </div>
            <div class="card shadow-sm">
                <div class="card-header bg-white text-black text-center">
                    <h5 class="mb-0"><?php echo $isi['merk']; ?></h5>
                </div>
                <img src="../../assets/image/<?php echo $isi['gambar']; ?>" class="img-fluid" style="width:100%; height:auto; object-fit: cover;" alt="Gambar Mobil">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item <?php echo ($isi['status'] == 'Tersedia') ? 'bg-success text-white' : 'bg-danger text-white'; ?>">
                        <i class="fa <?php echo ($isi['status'] == 'Tersedia') ? 'fa-check' : 'fa-close'; ?>"></i>
                        <?php echo ($isi['status'] == 'Tersedia') ? 'Available' : 'Not Available'; ?>
                    </li>
                    <li class="list-group-item bg-primary text-white"><i class="fa fa-gift"></i> Free E-toll 50k</li>
                    <li class="list-group-item bg-dark text-white"><i class="fa fa-money"></i> Rp. <?php echo number_format($isi['harga']); ?> / day</li>
                </ul>
                <div class="card-footer text-center">
                    <a href="<?php echo $url; ?>admin/peminjaman/peminjaman.php?id=<?php echo $hasil['kode_booking']; ?>" class="btn btn-success btn-md">Ubah Status Kendaraan</a>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-secondary text-white text-center">
                    <h5 class="mb-0">Detail Booking</h5>
                </div>
                <div class="card-body">
                    <form method="post" action="proses.php?id=konfirmasi">
                        <table class="table table-bordered">
                            <tr><td>Kode Booking</td><td>:</td><td><?php echo $hasil['kode_booking']; ?></td></tr>
                            <tr><td>KTP</td><td>:</td><td><?php echo $hasil['ktp']; ?></td></tr>
                            <tr><td>Nama</td><td>:</td><td><?php echo $hasil['nama']; ?></td></tr>
                            <tr><td>Telepon</td><td>:</td><td><?php echo $hasil['no_tlp']; ?></td></tr>
                            <tr><td>Tanggal Sewa</td><td>:</td><td><?php echo $hasil['tanggal']; ?></td></tr>
                            <tr><td>Lama Sewa</td><td>:</td><td><?php echo $hasil['lama_sewa']; ?> hari</td></tr>
                            <tr><td>Total Harga</td><td>:</td><td>Rp. <?php echo number_format($hasil['total_harga']); ?></td></tr>
                            <tr>
                                <td>Status</td>
                                <td>:</td>
                                <td>
                                    <select class="form-control" name="status">
                                        <option <?php if($hasil['konfirmasi_pembayaran'] == 'Sedang di proses') { echo 'selected'; } ?>>Sedang diproses</option>
                                        <option <?php if($hasil['konfirmasi_pembayaran'] == 'Pembayaran di terima') { echo 'selected'; } ?>>Pembayaran diterima</option>
                                    </select>
                                </td>
                            </tr>
                        </table>
                        <input type="hidden" name="id_booking" value="<?php echo $hasil['id_booking']; ?>">
                        <button type="submit" class="btn btn-primary float-end">Ubah Status</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../footer.php'; ?>