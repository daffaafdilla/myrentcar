    <?php
    require 'koneksi.php';

    if ($_GET['id'] == 'login') {
        $user = trim($_POST['user']);
        $pass = trim($_POST['pass']);

        $row = $koneksi->prepare("SELECT * FROM user WHERE username = ? AND password = md5(?)");
        $row->execute([$user, $pass]);

        if ($row->rowCount() > 0) {
            session_start();
            $_SESSION['USER'] = $row->fetch();

            $redirect = ($_SESSION['USER']['level'] == 'admin') ? "../admin/index.php" : "../index.php";
            echo '<script>alert("✔️ Login Sukses!");window.location="'.$redirect.'";</script>';
        } else {
            echo '<script>alert("❌ Login Gagal! Username / Password salah");window.location="../index.php";</script>';
        }
    }

    // PROSES PENDAFTARAN
    if ($_GET['id'] == 'daftar') {
        if (!isset($_POST['ktp'], $_POST['nama'], $_POST['user'], $_POST['pass'], $_POST['alamat'], $_POST['no_hp'])) {
            die('<script>alert("❌ Data tidak lengkap!");window.location="../index.php";</script>');
        }

        $ktp = trim($_POST['ktp']);
        $nama = trim($_POST['nama']);
        $username = trim($_POST['user']);
        $password = trim($_POST['pass']);
        $alamat = trim($_POST['alamat']);
        $no_hp = trim($_POST['no_hp']);
        $level = 'pengguna';

        // Validasi panjang password minimal 8 karakter
        if (strlen($password) < 8) {
            die('<script>alert("❌ Password harus minimal 8 karakter!");window.location="../index.php";</script>');
        }

        // Enkripsi password setelah validasi
        $password = md5($password);

        // Cek apakah username sudah digunakan
        $checkUser = $koneksi->prepare("SELECT * FROM user WHERE username = ?");
        $checkUser->execute([$username]);

        if ($checkUser->rowCount() > 0) {
            echo '<script>alert("❌ Username sudah digunakan!");window.location="../index.php";</script>';
        } else {
            try {
                $sql = "INSERT INTO user (ktp, nama_pengguna, username, password, alamat, no_hp, level)
                        VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmt = $koneksi->prepare($sql);
                $stmt->execute([$ktp, $nama, $username, $password, $alamat, $no_hp, $level]);

                echo '<script>alert("✔️ Pendaftaran berhasil, Silakan login.");window.location="../index.php";</script>';
            } catch (PDOException $e) {
                die('<script>alert("❌ Error: ' . addslashes($e->getMessage()) . '");window.location="../index.php";</script>');
            }
        }
    }

    // PROSES BOOKING
    if ($_GET['id'] == 'booking') {
        if (!isset($_POST['id_login'], $_POST['id_mobil'], $_POST['ktp'], $_POST['nama'], $_POST['alamat'], $_POST['no_tlp'], $_POST['tanggal'], $_POST['lama_sewa'], $_POST['total_harga'])) {
            die('<script>alert("❌ Data tidak lengkap!");window.location="../index.php";</script>');
        }

        $total = $_POST['total_harga'] * $_POST['lama_sewa'];
        $unik = random_int(100, 999);
        $total_harga = $total + $unik;

        $data = [
            time(),
            $_POST['id_login'],
            $_POST['id_mobil'],
            $_POST['ktp'],
            $_POST['nama'],
            $_POST['alamat'],
            $_POST['no_tlp'],
            $_POST['tanggal'],
            $_POST['lama_sewa'],
            $total_harga,
            "Belum Bayar",
            date('Y-m-d')
        ];

        try {
            $sql = "INSERT INTO booking (kode_booking, id_login, id_mobil, ktp, nama, alamat, no_tlp, tanggal, lama_sewa, total_harga, konfirmasi_pembayaran, tgl_input) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $koneksi->prepare($sql);
            $stmt->execute($data);

            echo '<script>alert("✔️ Booking berhasil! Silakan melakukan pembayaran.");window.location="../bayar.php?id=' . time() . '";</script>';
        } catch (PDOException $e) {
            die('<script>alert("❌ Error: ' . addslashes($e->getMessage()) . '");window.location="../index.php";</script>');
        }
    }

    // KONFIRMASI PEMBAYARAN
    if ($_GET['id'] == 'konfirmasi') {
        if (!isset($_POST['id_booking'], $_POST['no_rekening'], $_POST['nama'], $_POST['nominal'], $_POST['tgl'])) {
            die('<script>alert("❌ Data tidak lengkap!");window.location="../index.php";</script>');
        }

        try {
            $sql = "INSERT INTO pembayaran (id_booking, no_rekening, nama_rekening, nominal, tanggal) 
                    VALUES (?, ?, ?, ?, ?)";
            $stmt = $koneksi->prepare($sql);
            $stmt->execute([$_POST['id_booking'], $_POST['no_rekening'], $_POST['nama'], $_POST['nominal'], $_POST['tgl']]);

            $updateSql = "UPDATE booking SET konfirmasi_pembayaran = 'Sedang di proses' WHERE id_booking = ?";
            $stmt2 = $koneksi->prepare($updateSql);
            $stmt2->execute([$_POST['id_booking']]);

            echo '<script>alert("✔️ Konfirmasi berhasil! Pembayaran sedang diproses.");history.go(-2);</script>';
        } catch (PDOException $e) {
            die('<script>alert("❌ Error: ' . addslashes($e->getMessage()) . '");window.location="../index.php";</script>');
        }
    }
    ?>