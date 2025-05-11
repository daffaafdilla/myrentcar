<?php
    require '../../koneksi/koneksi.php';
    $title_web = 'User';
    include '../header.php';
    if(empty($_SESSION['USER'])) {
        session_start();
    }
?>

<div class="container mt-5">
    <div class="card shadow-lg border-0 rounded-3">
        <div class="card-header bg-white text-black text-center py-3">
            <h4 class="mb-0 font-weight-bold">Daftar User / Pelanggan</h4>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-between mb-3">
                <button class="btn btn-success shadow-sm" onclick="location.reload()">
                    <i class="fas fa-sync-alt"></i> Refresh Data
                </button>
                <input type="text" id="search" class="form-control w-25" placeholder="Cari Pengguna...">
            </div>
            <div class="table-responsive">
                <table class="table table-hover table-striped table-bordered text-center" id="userTable">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th>No</th>
                            <th>Nama Pengguna</th>
                            <th>Username</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $no = 1;
                            $sql = "SELECT * FROM user WHERE level = 'Pengguna' ORDER BY id_login DESC";
                            $row = $koneksi->prepare($sql);
                            $row->execute();
                            $hasil = $row->fetchAll(PDO::FETCH_OBJ);
                            foreach($hasil as $r){
                        ?>
                        <tr class="align-middle">
                            <td class="fw-bold"><?= $no;?></td>   
                            <td class="text-capitalize"> <?= htmlspecialchars($r->nama_pengguna);?></td>      
                            <td><?= htmlspecialchars($r->username);?></td>      
                            <td>
                                <a href="<?php echo $url;?>admin/booking/booking.php?id=<?= $r->id_login;?>" 
                                    class="btn btn-sm btn-info shadow-sm px-3 py-2">
                                    <i class="fas fa-eye"></i> Detail Transaksi
                                </a>    
                            </td>   
                        </tr>
                        <?php $no++; }?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById("search").addEventListener("keyup", function() {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll("#userTable tbody tr");
        rows.forEach(row => {
            let nama = row.cells[1].textContent.toLowerCase();
            let username = row.cells[2].textContent.toLowerCase();
            if (nama.includes(filter) || username.includes(filter)) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    });
</script>

<?php include '../footer.php'; ?>
