<?php
require '../../koneksi/koneksi.php';

session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_GET['aksi']) && $_GET['aksi'] == 'tambah') {

    $allowedImageTypes = array("image/gif", "image/jpeg", "image/pjpeg", "image/png", "image/x-png", 'image/webp');
    
    if (!empty($_FILES['gambar']['tmp_name'])) {
        $filepath = $_FILES['gambar']['tmp_name'];
        $fileinfo = finfo_open(FILEINFO_MIME_TYPE);
        $filetype = finfo_file($fileinfo, $filepath);
        finfo_close($fileinfo);

        if (!in_array($filetype, $allowedImageTypes)) {
            echo '<script>alert("You can only upload JPG, PNG, and webp files");window.location="tambah.php"</script>';
            exit();
        } elseif ($_FILES['gambar']["error"] > 0) {
            echo '<script>alert("Error uploading file");history.go(-1)</script>';
            exit();
        } elseif ($_FILES['gambar']["size"] > 4096 * 1024) {
            echo '<script>alert("WARNING !!! Gambar tidak boleh lebih dari 4 MB !");window.location="tambah.php"</script>';
            exit();
        } else {
            $dir = '../../assets/image/';
            $temp = explode(".", $_FILES["gambar"]["name"]);
            $newfilename = round(microtime(true)) . '.' . end($temp);
            $target_path = $dir . basename($newfilename);
            if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target_path)) {
                $data = [
                    $_POST['no_plat'],
                    $_POST['merk'],
                    $_POST['harga'],
                    $_POST['deskripsi'],
                    $_POST['status'],
                    $newfilename
                ];

                $sql = "INSERT INTO mobil (no_plat, merk, harga, deskripsi, status, gambar) VALUES (?, ?, ?, ?, ?, ?)";
                $row = $koneksi->prepare($sql);
                if ($row->execute($data)) {
                    echo '<script>alert("Upload Data Kendaraan berhasil");window.location="mobil.php"</script>';
                } else {
                    echo '<script>alert("Error inserting data");history.go(-1)</script>';
                }
            } else {
                echo '<script>alert("Error moving uploaded file");window.location="tambah.php"</script>';
            }
        }
    } else {
        echo '<script>alert("Please upload image");window.location="tambah.php"</script>';
    }
}

if (isset($_GET['aksi']) && $_GET['aksi'] == 'edit') {
    $id = $_GET['id'];
    $gambar = $_POST['gambar_cek'];
    $data = [
        $_POST['no_plat'],
        $_POST['merk'],
        $_POST['harga'],
        $_POST['deskripsi'],
        $_POST['status']
    ];

    if (!empty($_FILES['gambar']['tmp_name'])) {
        $filepath = $_FILES['gambar']['tmp_name'];
        $fileinfo = finfo_open(FILEINFO_MIME_TYPE);
        $filetype = finfo_file($fileinfo, $filepath);
        finfo_close($fileinfo);

        if (!in_array($filetype, $allowedImageTypes)) {
            echo '<script>alert("You can only upload JPG, PNG, and GIF files");history.go(-1)</script>';
            exit();
        } elseif ($_FILES['gambar']["error"] > 0) {
            echo '<script>alert("Error uploading file");history.go(-1)</script>';
            exit();
        } elseif ($_FILES['gambar']["size"] > 4096 * 1024) {
            echo '<script>alert("WARNING !!! Gambar tidak boleh lebih dari 4 MB !");history.go(-1)</script>';
            exit();
        } else {
            $dir = '../../assets/image/';
            $temp = explode(".", $_FILES["gambar"]["name"]);
            $newfilename = round(microtime(true)) . '.' . end($temp);
            $target_path = $dir . basename($newfilename);
            if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target_path)) {
                if (file_exists('../../assets/image/' . $gambar)) {
                    unlink('../../assets/image/' . $gambar);
                }
                $data[] = $newfilename;
            } else {
                echo '<script>alert("Error moving uploaded file");history.go(-1)</script>';
                exit();
            }
        }
    } else {
        $data[] = $gambar;
    }

    $data[] = $id;

    $sql = "UPDATE mobil SET no_plat = ?, merk = ?, harga = ?, deskripsi = ?, status = ?, gambar = ? WHERE id_mobil = ?";
    $row = $koneksi->prepare($sql);
    if ($row->execute($data)) {
        echo '<script>alert("Edit Data Mobil Berhasil");window.location="mobil.php"</script>';
    } else {
        echo '<script>alert("Error updating data");history.go(-1)</script>';
    }
}

if (!empty($_GET['aksi']) && $_GET['aksi'] == 'hapus') {
    $id = $_GET['id'];
    $gambar = $_GET['gambar'];

    if (file_exists('../../assets/image/' . $gambar)) {
        unlink('../../assets/image/' . $gambar);
    }

    $sql = "DELETE FROM mobil WHERE id_mobil = ?";
    $row = $koneksi->prepare($sql);
    if ($row->execute([$id])) {
        echo '<script>alert("Hapus data mobil berhasil");window.location="mobil.php"</script>';
    } else {
        echo '<script>alert("Error deleting data");history.go(-1)</script>';
    }
}
?>
