<?php
    require '../../koneksi/koneksi.php';
    $title_web = 'Daftar Mobil';
    include '../header.php';
    if(empty($_SESSION['USER']))
    {
        session_start();
    }
?>

<br>
<div class="container mt-4">
    <div class="card shadow-lg rounded">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Daftar Mobil</h4>
            <a class="btn btn-success" href="tambah.php" role="button">Tambah Mobil</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>No.</th>
                            <th>Gambar</th>
                            <th>Merk Mobil</th>
                            <th>No Plat</th>
                            <th>Harga</th>
                            <th>Status</th>
                            <th>Deskripsi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $sql = "SELECT * FROM mobil ORDER BY id_mobil ASC";
                            $row = $koneksi->prepare($sql);
                            $row->execute();
                            $hasil = $row->fetchAll();
                            $no = 1;

                            foreach($hasil as $isi)
                            {
                        ?>
                        <tr>
                            <td><?php echo $no;?></td>
                            <td>
                                <img src="../../assets/image/<?php echo $isi['gambar'];?>" class="img-thumbnail" style="width:150px; height:100px; object-fit: cover;">
                            </td>
                            <td class="fw-bold text-primary"><?php echo $isi['merk'];?></td>
                            <td><?php echo $isi['no_plat'];?></td>
                            <td class="text-success fw-bold">Rp<?php echo number_format($isi['harga'], 0, ',', '.');?></td>
                            <td>
                                <span class="badge <?php echo ($isi['status'] == 'Tersedia') ? 'bg-success' : 'bg-danger'; ?>">
                                    <?php echo $isi['status']; ?>
                                </span>
                            </td>
                            <td><?php echo substr($isi['deskripsi'], 0, 50); ?>...</td>
                            <td>
                                <a class="btn btn-primary btn-sm" href="edit.php?id=<?php echo $isi['id_mobil'];?>" role="button">Edit</a>  
                                <a class="btn btn-danger btn-sm" href="proses.php?aksi=hapus&id=<?= $isi['id_mobil'];?>&gambar=<?= $isi['gambar'];?>" role="button" onclick="return confirm('Apakah Anda yakin ingin menghapus mobil ini?');">Hapus</a>  
                            </td>
                        </tr>
                        <?php $no++; }?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include '../footer.php'; ?>
