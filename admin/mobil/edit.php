<?php
    require '../../koneksi/koneksi.php';
    $title_web = 'Edit Mobil';
    include '../header.php';
    if(empty($_SESSION['USER']))
    {
        session_start();
    }
    $id = $_GET['id'];

    $sql = "SELECT * FROM mobil WHERE id_mobil =  ?";
    $row = $koneksi->prepare($sql);
    $row->execute(array($id));
    $hasil = $row->fetch();
?>

<style>
    .card {
        border-radius: 15px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    .form-group label {
        font-weight: bold;
    }
    .btn-custom {
        border-radius: 25px;
        padding: 10px 20px;
    }
</style>

<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-primary text-white text-center">
            <h3>Edit Mobil - <?= $hasil['merk']; ?></h3>
        </div>
        <div class="card-body">
            <form method="post" action="proses.php?aksi=edit&id=<?= $id; ?>" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>No Plat</label>
                            <input type="text" class="form-control" value="<?= $hasil['no_plat']; ?>" name="no_plat" placeholder="Isi No Plat">
                        </div>
                        <div class="form-group">
                            <label>Merk Mobil</label>
                            <input type="text" class="form-control" value="<?= $hasil['merk']; ?>" name="merk" placeholder="Isi Merk">
                        </div>
                        <div class="form-group">
                            <label>Harga</label>
                            <input type="text" class="form-control" value="<?= $hasil['harga']; ?>" name="harga" placeholder="Isi Harga">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Deskripsi</label>
                            <input type="text" class="form-control" value="<?= $hasil['deskripsi']; ?>" name="deskripsi" placeholder="Isi Deskripsi">
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" name="status">
                                <option value="" disabled>Pilih Status</option>
                                <option <?= ($hasil['status'] == 'Tersedia') ? 'selected' : ''; ?>>Tersedia</option>
                                <option <?= ($hasil['status'] == 'Tidak Tersedia') ? 'selected' : ''; ?>>Tidak Tersedia</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Gambar</label>
                            <input type="file" accept="image/*" class="form-control" name="gambar">
                        </div>
                        <div class="form-group text-center">
                            <label>Gambar Saat Ini</label>
                            <div>
                                <img src="../../assets/image/<?= $hasil['gambar']; ?>" class="img-fluid rounded" style="max-width: 200px;">
                            </div>
                        </div>
                        <input type="hidden" value="<?= $hasil['gambar']; ?>" name="gambar_cek">
                    </div>
                </div>
                <div class="text-center mt-3">
                    <a class="btn btn-warning btn-custom" href="mobil.php">Kembali</a>
                    <button class="btn btn-primary btn-custom" type="submit">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include '../footer.php'; ?>