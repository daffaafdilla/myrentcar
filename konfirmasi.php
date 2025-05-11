<?php
    session_start();
    require 'koneksi/koneksi.php';
    include 'header.php';
    
    if(empty($_SESSION['USER'])) {
        echo '<script>alert("Harap Login");window.location="index.php"</script>';
        exit;
    }
    
    $kode_booking = $_GET['id'];
    
    // Gunakan prepared statement untuk keamanan
    $stmt = $koneksi->prepare("SELECT * FROM booking WHERE kode_booking = ?");
    $stmt->execute([$kode_booking]);
    $hasil = $stmt->fetch();
    
    if (!$hasil) {
        echo '<script>alert("Data tidak ditemukan");window.location="index.php"</script>';
        exit;
    }
    
    $id = $hasil['id_mobil'];
    $stmt2 = $koneksi->prepare("SELECT * FROM mobil WHERE id_mobil = ?");
    $stmt2->execute([$id]);
    $isi = $stmt2->fetch();
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title">Pembayaran Dapat Melalui:</h5>
                    <hr>
                    <p class="font-weight-bold text-primary"> <?= htmlspecialchars($info_web->no_rek); ?> </p>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h4 class="mb-3">Konfirmasi Pembayaran</h4>
                    <form method="post" action="koneksi/proses.php?id=konfirmasi">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <td><strong>Kode Booking</strong></td>
                                    <td><?php echo htmlspecialchars($hasil['kode_booking']); ?></td>
                                </tr>
                                <tr>
                                    <td><strong>No Rekening</strong></td>
                                    <td><input type="text" name="no_rekening" required class="form-control"></td>
                                </tr>
                                <tr>
                                    <td><strong>Atas Nama</strong></td>
                                    <td><input type="text" name="nama" required class="form-control"></td>
                                </tr>
                                <tr>
                                    <td><strong>Nominal</strong></td>
                                    <td><input type="number" name="nominal" required class="form-control"></td>
                                </tr>
                                <tr>
                                    <td><strong>Tanggal Transfer</strong></td>
                                    <td><input type="date" name="tgl" required class="form-control"></td>
                                </tr>
                                <tr>
                                    <td><strong>Total yg Harus Dibayar</strong></td>
                                    <td class="text-danger font-weight-bold">Rp. <?php echo number_format($hasil['total_harga'], 0, ',', '.'); ?></td>
                                </tr>
                            </table>
                        </div>
                        <input type="hidden" name="id_booking" value="<?php echo htmlspecialchars($hasil['id_booking']); ?>">
                        <button type="submit" class="btn btn-primary btn-block">Kirim Konfirmasi</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>