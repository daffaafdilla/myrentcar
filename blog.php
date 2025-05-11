<?php
    session_start();
    require 'koneksi/koneksi.php';
    include 'header.php';

    if(isset($_GET['cari']) && !empty($_GET['cari'])) // Periksa apakah 'cari' ada dan tidak kosong
    {
        $cari = strip_tags($_GET['cari']);
        $query = $koneksi->query('SELECT * FROM mobil WHERE merk LIKE "%'.$cari.'%" ORDER BY id_mobil DESC')->fetchAll();
    } else {
        $query = $koneksi->query('SELECT * FROM mobil ORDER BY id_mobil DESC')->fetchAll();
        $cari = ""; // Hindari undefined variable saat digunakan di HTML
    }
?>
<br>
<br>
<div class="container">
<div class="row">
    <div class="col-sm-12">
        <?php 
            if(!empty($cari)) // Cek apakah $cari berisi nilai
            {
                echo '<h4> Keyword Pencarian : '.$cari.'</h4>';
            } else {
                echo '<h4> Semua Mobil</h4>';
            }
        ?>
        <div class="row mt-3">
        <?php 
            foreach($query as $isi)
            {
        ?>
            <div class="col-sm-4 mb-4">
                <div class="card">
                <img src="assets/image/<?php echo $isi['gambar'];?>" class="card-img-top" style="height:200px;object-fit:cover;">
                    <div class="card-body bg-light">
                        <h5 class="card-title"><?php echo htmlspecialchars($isi['merk']);?></h5>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item <?php echo $isi['status'] == 'Tersedia' ? 'bg-success text-white' : 'bg-danger text-white'; ?>">
                            <?php echo $isi['status'] == 'Tersedia' ? '<i class="fa fa-check"></i> Available' : '<i class="fa fa-close"></i> Not Available'; ?>
                        </li>
                        <li class="list-group-item bg-primary text-white"><i class="fa fa-check"></i> Free E-toll 50k</li>
                        <li class="list-group-item bg-dark text-white">
                            <i class="fa fa-money"></i> Rp. <?php echo number_format($isi['harga']);?>/ day
                        </li>
                    </ul>
                    <div class="card-body text-center">
                        <?php if ($isi['status'] == 'Tersedia') { ?>
                            <a href="booking.php?id=<?php echo $isi['id_mobil'];?>" class="btn btn-success">Booking now!</a>
                        <?php } ?>
                        <a href="detail.php?id=<?php echo $isi['id_mobil'];?>" class="btn btn-info">Detail</a>
                    </div>
                </div>
            </div>
        <?php } ?>
        </div>
    </div>
</div>
</div>

<br>
<br>
<br>
<?php include 'footer.php';?>
