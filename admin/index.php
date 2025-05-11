<?php
    require '../koneksi/koneksi.php';
    $title_web = 'Dashboard';
    include 'header.php';
    if(empty($_SESSION['USER'])) {
        session_start();
    }
    
    if(!empty($_POST['nama_rental'])) {
        $data = [
            htmlspecialchars($_POST['nama_rental']),
            htmlspecialchars($_POST['telp']),
            htmlspecialchars($_POST['alamat']),
            htmlspecialchars($_POST['email']),
            htmlspecialchars($_POST['no_rek']),
            1
        ];
        $sql = "UPDATE infoweb SET nama_rental = ?, telp = ?, alamat = ?, email = ?, no_rek = ? WHERE id = ?";
        $row = $koneksi->prepare($sql);
        $row->execute($data);
        echo '<script>alert("Update Data Info Website Berhasil!");window.location="index.php"</script>';
        exit;
    }
    
    if(!empty($_POST['nama_pengguna'])) {
        $data = [
            htmlspecialchars($_POST['nama_pengguna']),
            htmlspecialchars($_POST['username']),
            md5($_POST['password']),
            $_SESSION['USER']['id_login']
        ];
        $sql = "UPDATE user SET nama_pengguna = ?, username = ?, password = ? WHERE id_login = ?";
        $row = $koneksi->prepare($sql);
        $row->execute($data);
        echo '<script>alert("Data Profil Berhasil diubah");window.location="index.php"</script>';
        exit;
    }
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-6">
            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-header bg-primary text-white text-center">
                    <h5>Info Website</h5>
                </div>
                <div class="card-body">
                    <form action="" method="post">
                        <?php
                            $sql = "SELECT * FROM infoweb WHERE id = 1";
                            $row = $koneksi->prepare($sql);
                            $row->execute();
                            $edit = $row->fetch(PDO::FETCH_OBJ);
                        ?>
                        <div class="mb-3">
                            <label class="form-label">Nama Rental</label>
                            <input type="text" class="form-control" value="<?= $edit->nama_rental;?>" name="nama_rental" placeholder="Masukkan nama rental"/>
                        </div>
                        <div class="mb-3 row">
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" value="<?= $edit->email;?>" name="email" placeholder="Masukkan email"/>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Telepon</label>
                                <input type="text" class="form-control" value="<?= $edit->telp;?>" name="telp" placeholder="Masukkan nomor telepon"/>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <textarea class="form-control" name="alamat" placeholder="Masukkan alamat"><?= $edit->alamat;?></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">No Rekening</label>
                            <input type="text" class="form-control" value="<?= $edit->no_rek;?>" name="no_rek" placeholder="Masukkan nomor rekening"/>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-header bg-success text-white text-center">
                    <h5>Profil Admin</h5>
                </div>
                <div class="card-body">
                    <form action="" method="post">
                    <?php
                        $id =  $_SESSION['USER']['id_login'];
                        $sql = "SELECT * FROM user WHERE id_login = ?";
                        $row = $koneksi->prepare($sql);
                        $row->execute(array($id));
                        $edit_profil = $row->fetch(PDO::FETCH_OBJ);
                    ?>
                        <div class="mb-3">
                            <label class="form-label">Nama Pengguna</label>
                            <input type="text" class="form-control" value="<?= $edit_profil->nama_pengguna;?>" name="nama_pengguna" placeholder="Masukkan nama pengguna"/>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" class="form-control" required value="<?= $edit_profil->username;?>" name="username" placeholder="Masukkan username"/>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" class="form-control" required name="password" placeholder="Masukkan password baru"/>
                        </div>
                        <button type="submit" class="btn btn-success w-100">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>