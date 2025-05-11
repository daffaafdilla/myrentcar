<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rental Mobil</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .navbar {
            background: linear-gradient(to right, #007bff,rgb(20, 59, 104));
        }
        .navbar .nav-link {
            color: white !important;
            font-weight: bold;
        }
        .navbar .nav-link:hover {
            text-decoration: underline;
        }
        .navbar .btn-search {
            background-color:rgb(119, 119, 119);
            color: #000;
        }
        .navbar .btn-search:hover {
            background-color:rgb(136, 178, 255);
        }
        .welcome-text {
            color: white;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark shadow">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><b>LetsRentCar</b></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="blog.php">Daftar Mobil</a></li>
                    <?php if(!empty($_SESSION['USER'])){ ?>
                        <li class="nav-item"><a class="nav-link" href="history.php">Penyewaan & Pengembalian</a></li>
                        <li class="nav-item"><a class="nav-link" href="profil.php">Profil</a></li>
                    <?php } ?>
                </ul>
                <form class="d-flex" method="get" action="blog.php">
                    <input class="form-control me-2" type="search" name="cari" placeholder="Cari Nama Mobil" aria-label="Search">
                    <button class="btn btn-search" type="submit">Search</button>
                </form>
                <?php if(!empty($_SESSION['USER'])){ ?>
                <ul class="navbar-nav ms-3">
                    <li class="nav-item">
                        <span class="nav-link welcome-text"><i class="fa fa-user"></i> Hallo, <?php echo $_SESSION['USER']['nama_pengguna']; ?></span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-warning" onclick="return confirm('Apakah anda ingin logout?');" href="<?php echo $url;?>admin/logout.php">Logout</a>
                    </li>
                </ul>
                <?php } ?>
            </div>
        </div>
    </nav>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
