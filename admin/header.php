<!doctype html>
<html lang="en">
<head>
    <title><?php echo $title_web;?> | Lets Rent Car</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?php echo $url;?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $url;?>assets/css/font-awesome.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar {
            background: linear-gradient(135deg,rgb(17, 113, 203),rgb(4, 37, 94));
        }
        .navbar-brand {
            font-weight: bold;
        }
        .nav-item .nav-link {
            color: #fff;
            transition: 0.3s;
        }
        .nav-item .nav-link:hover {
            color: #ffd700;
        }
        .jumbotron {
            background: linear-gradient(135deg, rgb(17, 113, 203), rgb(4, 37, 94));
            color: white;
            padding: 2rem;
            border-radius: 10px;
        }
        .user-info {
            color: #fff;
            font-weight: bold;
        }
        .user-section {
            display: flex;
            align-items: center;
            margin-left: auto;
        }
    </style>
</head>
<body>
    <?php
        session_start();
        $hasil_login = isset($_SESSION['user']) ? $_SESSION['user'] : null;
    ?>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="<?php echo $url;?>admin/">Lets RentCar</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item <?php if($title_web == 'Dashboard'){ echo 'active';}?>">
                        <a class="nav-link" href="<?php echo $url;?>admin/">Dashboard</a>
                    </li>
                    <li class="nav-item <?php if($title_web == 'User'){ echo 'active';}?>">
                        <a class="nav-link" href="<?php echo $url;?>admin/user/index.php">Member</a>
                    </li>
                    <li class="nav-item <?php if(in_array($title_web, ['Daftar Mobil', 'Tambah Mobil', 'Edit Mobil'])){ echo 'active';}?>">
                        <a class="nav-link" href="<?php echo $url;?>admin/mobil/mobil.php">Mobil</a>
                    </li>
                    <li class="nav-item <?php if(in_array($title_web, ['Daftar Booking', 'Konfirmasi'])){ echo 'active';}?>">
                        <a class="nav-link" href="<?php echo $url;?>admin/booking/booking.php">Pembookingan</a>
                    </li>
                    <li class="nav-item <?php if($title_web == 'Peminjaman'){ echo 'active';}?>">
                        <a class="nav-link" href="<?php echo $url;?>admin/peminjaman/peminjaman.php">Penyewaan</a>
                    </li>
                </ul>
                <ul class="navbar-nav user-section">
                    <li class="nav-item">
                        <a class="nav-link user-info" href="#">
                            <i class="fa fa-user"></i> Hallo, <?php echo isset($hasil_login['nama_pengguna']) ? $hasil_login['nama_pengguna'] : 'Guest'; ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" onclick="return confirm('Apakah anda ingin logout?');" href="<?php echo $url;?>admin/logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <script src="<?php echo $url;?>assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
