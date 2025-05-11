<?php
    require '../../koneksi/koneksi.php';
    $title_web = 'Peminjaman';
    include '../header.php';
    if(empty($_SESSION['USER']))
    {
        session_start();
    }
    if(!empty($_GET['id'])){
        $kode_booking = $_GET['id'];
        
        $hasil = $koneksi->query("SELECT * FROM booking WHERE kode_booking = '$kode_booking'")->fetch();
        $id_booking = $hasil['id_booking'] ?? null;
        
        if(!$id_booking)
        {
            echo '<script>alert("Tidak Ada Data !");window.location="peminjaman.php"</script>';
        }
        
        $hsl = $koneksi->query("SELECT * FROM pembayaran WHERE id_booking = '$id_booking'")->fetch();
        if (!$hsl) {
            $hsl = ['no_rekening' => '-', 'nama_rekening' => '-', 'nominal' => 0, 'tanggal' => '-'];
        }
        
        $id = $hasil['id_mobil'];
        $isi = $koneksi->query("SELECT * FROM mobil WHERE id_mobil = '$id'")->fetch();
    }
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Cari Booking</h5>
                </div>
                <div class="card-body">
                    <form method="get" action="peminjaman.php">
                        <input type="text" class="form-control" name="id" 
                               value="<?php echo $_GET['id'] ?? ''; ?>" 
                               placeholder="Tulis Kode Booking [ ENTER ]">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php if(!empty($_GET['id'])) { ?>
    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card shadow border-0">
                <div class="card-header bg-info text-white">
                    <h5>Detail Pembayaran</h5>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr><td>No Rekening</td><td>:</td><td><?= $hsl['no_rekening'];?></td></tr>
                        <tr><td>Atas Nama</td><td>:</td><td><?= $hsl['nama_rekening'];?></td></tr>
                        <tr><td>Nominal</td><td>:</td><td>Rp. <?= number_format($hsl['nominal']);?></td></tr>
                        <tr><td>Tgl Transfer</td><td>:</td><td><?= $hsl['tanggal'];?></td></tr>
                    </table>
                </div>
            </div>
            <div class="card mt-3 shadow border-0">
                <div class="card-header bg-white text-black">
                    <h5 class="mb-0">Mobil: <?php echo $isi['merk'];?></h5>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item <?= ($isi['status'] == 'Tersedia') ? 'bg-primary' : 'bg-danger'; ?> text-white">
                        <i class="fa <?= ($isi['status'] == 'Tersedia') ? 'fa-check' : 'fa-close'; ?>"></i> 
                        <?= ($isi['status'] == 'Tersedia') ? 'Available' : 'Not Available'; ?>
                    </li>
                    <li class="list-group-item bg-dark text-white"><i class="fa fa-money"></i> Rp. <?php echo number_format($isi['harga']);?> / day</li>
                </ul>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card shadow border-0">
                <div class="card-header bg-info text-white">
                    <h5>Penyewaan Kendaraan & Status Kendaraan</h5>
                </div>
                <div class="card-body">
                    <form method="post" action="proses.php?id=konfirmasi">
                        <table class="table">
                            <tr><td>Kode Booking</td><td>:</td><td><?php echo $hasil['kode_booking'];?></td></tr>
                            <tr><td>KTP</td><td>:</td><td><?php echo $hasil['ktp'];?></td></tr>
                            <tr><td>Nama</td><td>:</td><td><?php echo $hasil['nama'];?></td></tr>
                            <tr><td>Telepon</td><td>:</td><td><?php echo $hasil['no_tlp'];?></td></tr>
                            <tr><td>Tanggal Sewa</td><td>:</td><td><?php echo $hasil['tanggal'];?></td></tr>
                            <tr><td>Lama Sewa</td><td>:</td><td><?php echo $hasil['lama_sewa'];?> hari</td></tr>
                            <tr><td>Total Harga</td><td>:</td><td>Rp. <?php echo number_format($hasil['total_harga']);?></td></tr>
                            <tr>
                                <td>Status Mobil</td><td>:</td>
                                <td>
                                    <select class="form-control" name="status">
                                        <option value="Tersedia" <?= ($isi['status'] == 'Tersedia') ? 'selected' : ''; ?>>Tersedia (KEMBALI)</option>
                                        <option value="Tidak Tersedia" <?= ($isi['status'] == 'Tidak Tersedia') ? 'selected' : ''; ?>>Tidak Tersedia (DISEWA)</option>
                                    </select>
                                </td>
                            </tr>
                        </table>
                        <input type="hidden" name="id_mobil" value="<?php echo $isi['id_mobil'];?>">
                        <button type="submit" class="btn btn-success float-right">Edit Status</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
</div>
<?php include '../footer.php'; ?>