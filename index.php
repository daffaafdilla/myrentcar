<?php
session_start();
require 'koneksi/koneksi.php';
include 'header.php';

// Ambil data mobil
$querymobil = $koneksi->query('SELECT * FROM mobil ORDER BY id_mobil DESC')->fetchAll();
?>

<div id="carouselId" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
        <?php foreach ($querymobil as $index => $isi) : ?>
            <li data-target="#carouselId" data-slide-to="<?= $index; ?>" class="<?= $index == 0 ? 'active' : ''; ?>"></li>
        <?php endforeach; ?>
    </ol>
    <div class="carousel-inner">
        <?php foreach ($querymobil as $index => $isi) : ?>
            <div class="carousel-item <?= $index == 0 ? 'active' : ''; ?>">
                <img src="assets/image/<?= htmlspecialchars($isi['gambar']); ?>" class="img-fluid" style="object-fit:cover;width:100%;height:500px;">
            </div>
        <?php endforeach; ?>
    </div>
    <a class="carousel-control-prev" href="#carouselId" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </a>
    <a class="carousel-control-next" href="#carouselId" role="button" data-slide="next">
        <span class="carousel-control-next-icon"></span>
    </a>
</div>

<div class="container-fluid mt-5">
    <div class="row">
        <div class="col-sm-3">
            <div class="card bg-light">
                <div class="card-body">
                    <?php if (isset($_SESSION['USER'])) : ?>
                        <p>Selamat Datang, <strong><?= htmlspecialchars($_SESSION['USER']['nama_pengguna']); ?></strong></p>
                        <center>
                            <a href="<?= $_SESSION['USER']['level'] == 'admin' ? 'admin/index.php' : 'blog.php'; ?>" class="btn btn-primary mb-2 btn-block">
                                <?= $_SESSION['USER']['level'] == 'admin' ? 'Dashboard' : 'Booking Sekarang!'; ?>
                            </a>
                            <a href="admin/logout.php" class="btn btn-danger btn-block">Logout</a>
                        </center>
                    <?php else : ?>
                        <form method="post" action="koneksi/proses.php?id=login">
                            <h5 class="text-center">Login</h5>
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" name="user" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="pass" class="form-control" required>
                            </div>
                            <center>
                                <button class="btn btn-primary">Login</button>
                                <a class="btn btn-danger" data-toggle="modal" data-target="#modelId">Daftar</a>
                            </center>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="col-sm-9">
            <div class="row">
                <?php foreach ($querymobil as $isi) : ?>
                    <div class="col-sm-4">
                        <div class="card">
                            <img src="assets/image/<?= htmlspecialchars($isi['gambar']); ?>" class="card-img-top" style="height:200px;">
                            <div class="card-body bg-light">
                                <h5 class="card-title"><?= htmlspecialchars($isi['merk']); ?></h5>
                            </div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item <?= $isi['status'] == 'Tersedia' ? 'bg-success' : 'bg-danger'; ?> text-white">
                                    <i class="fa <?= $isi['status'] == 'Tersedia' ? 'fa-check' : 'fa-close'; ?>"></i>
                                    <?= $isi['status'] == 'Tersedia' ? 'Available' : 'Not Available'; ?>
                                </li>
                                <li class="list-group-item bg-primary text-white">Free E-toll 50k</li>
                                <li class="list-group-item bg-dark text-white">Rp. <?= number_format($isi['harga']); ?>/ day</li>
                            </ul>
                            <div class="card-body text-center">
                                <?php if ($isi['status'] == 'Tersedia') : ?>
                                    <a href="booking.php?id=<?= $isi['id_mobil']; ?>" class="btn btn-success">Booking now!</a>
                                <?php endif; ?>
                                <a href="detail.php?id=<?= $isi['id_mobil']; ?>" class="btn btn-info">Detail</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<!-- Modal Daftar -->
<div class="modal fade" id="modelId" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="fa fa-user-plus"></i> Daftar Pengguna</h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form method="post" action="koneksi/proses.php?id=daftar">
                    <div class="form-group">
                        <label>NIK KTP</label>
                        <input type="text" name="ktp" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="user" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="pass" class="form-control" required minlength="8">
                    </div>
                    <div class="form-group">
                        <label>Alamat</label>
                        <textarea name="alamat" class="form-control" rows="2" required></textarea>
                    </div>
                    <div class="form-group">
                        <label>No. Handphone</label>
                        <input type="text" name="no_hp" class="form-control" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
