<?php
    session_start();
    require 'koneksi/koneksi.php';
    include 'header.php';
    
    if(empty($_SESSION['USER'])) {
        echo '<script>alert("Harap Login");window.location="index.php"</script>';
        exit;
    }

    if(!empty($_POST['nama_pengguna'])) {
        $nama_pengguna = htmlspecialchars($_POST["nama_pengguna"]);
        $username = htmlspecialchars($_POST["username"]);
        $password = $_POST["password"];
        
        if(strlen($password) < 8) {
            echo '<script>alert("Password harus minimal 8 karakter");window.location="profil.php"</script>';
            exit;
        }

        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $id_login = $_SESSION['USER']['id_login'];

        $sql = "UPDATE user SET nama_pengguna = ?, username = ?, password = ? WHERE id_login = ?";
        $stmt = $koneksi->prepare($sql);
        $stmt->execute([$nama_pengguna, $username, $hashed_password, $id_login]);

        echo '<script>alert("Data Profil Berhasil diubah");window.location="profil.php"</script>';
        exit;
    }

    $id = $_SESSION["USER"]["id_login"];
    $sql = "SELECT * FROM user WHERE id_login = ?";
    $stmt = $koneksi->prepare($sql);
    $stmt->execute([$id]);
    $edit_profil = $stmt->fetch(PDO::FETCH_OBJ);
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg p-4">
                <div class="card-body">
                    <h4 class="text-center mb-4">Edit Profil</h4>
                    <form action="" method="post">
                        <div class="mb-3">
                            <label class="form-label">Nama Pengguna</label>
                            <input type="text" class="form-control" value="<?= $edit_profil->nama_pengguna; ?>" name="nama_pengguna" required />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" class="form-control" value="<?= $edit_profil->username; ?>" name="username" required />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" id="password" required />
                            <small class="text-muted">Minimal 8 karakter</small>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
