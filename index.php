<?php
    include('scraper_functions.php');
?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon -->
    <link rel="shortcut icon" href="img/pilihdulu.png" type="image/x-icon">
    <link rel="icon" href="img/pilihdulu.png" type="image/x-icon">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Style tambahan -->
    <link rel="stylesheet" href="css/style.css">
    
    <title>PilihDulu</title>
</head>
<body>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="#"><img src="img/pildul.png" width="70" height="40"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-item nav-link active" href="">Cari Produk</a>
            </div>
        </div>
    </div>
</nav>
<!-- Navbar -->
<!-- Container -->
<div class="container">
    <div class="row mt-3 justify-content-center">
        <div class="col-md-7">
            <h1 class="text-center">Cari Produk</h1>
            <!-- Input pencarian -->
                <form action="" method="POST" class="form-inline justify-content-center">
                    <div class="input-group mb-3 col-md-9">
                        <input type="text" class="form-control" placeholder="Cari nama produk..." id="search-input" name="keyword" value="<?php if(isset($_POST['cari'])) echo $_POST["keyword"] ?>" autocomplete="off" required>
                        <div class="input-group-append">
                            <button class="btn btn-dark" type="submit" id="search-button" name="cari">Cari</button>
                        </div>
                    </div>
                </form>
            <!-- Input pencarian -->    
        </div>
    </div>
<!-- Input pencarian -->
    <hr>
<!-- Pengecekan input -->
<?php
    // Memeriksa jika tombol cari sudah ditekan dan keyword telah diisi
    if(isset($_POST['cari']) && isset($_POST['keyword'])) :
    
    // Inisialisasi variabel
    $keyword = $_POST['keyword'];

    //Memanggil function scraper
    $elevenia = getFromElevenia($keyword);
    $kaskus = getFromFjbKaskus($keyword);
    $blanja = getFromBlanja($keyword);
?>
<!-- Input pencarian -->
<!-- Row data produk -->
    <div class="row">
    <!-- Menampilkan data dari Elevenia -->
        <div class="col" id="daftar-produk">
        <a href="https://elevenia.com" target="_blank"><img src="img/elevenia.png" width="125" class="mb-3"></a>
        <?php foreach ($elevenia as $item) : ?> 
            <div class="card mb-3" style="width: 18rem;">
            <img src="<?= $item["gambar"]; ?>" class="card-img-top rounded-lg" alt="...">
                <div class="card-body">
                    <h6 class="card-title"><a href="<?= $item["linkAsli"]; ?>" target="_blank"><?= $item["nama"]; ?></a></h6>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><h6><strong>Harga : </strong></h6><?= $item["harga"]; ?></li>
                    <li class="list-group-item"><strong>Toko : </strong><?= $item["toko"]; ?></li>
                    <li class="list-group-item"><strong>Lokasi : </strong><?= $item["lokasi"]; ?></li>
                </ul>
                <div class="card-body">
                    <a href="<?= $item["linkAsli"]; ?>" class="btn btn-info" target="_blank">Sekarang di Elevenia</a>
                </div>
            </div>
        <?php endforeach; ?>
        </div>
        <!-- Menampilkan data dari Elevenia -->
        <!-- Menampilkan data dari FJB Kaskus -->
        <div class="col" id="daftar-produk">
        <a href="https://fjb.kaskus.co.id/" target="_blank"><img src="img/fjb.jpg" width="125" class="mb-3"></a>
        <?php foreach($kaskus as $barang) : ?>
            <div class="card mb-3" style="width: 18rem;">
                <img src="<?= $barang["gambar"]; ?>" class="card-img-top rounded-lg" alt="..." width="12">
                <div class="card-body">
                    <h6 class="card-title"><a href="<?= $barang["linkAsli"]; ?>" target="_blank"><?= $barang["nama"]; ?></a></h6>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><h6><strong>Harga : </strong></h6><?= $barang["harga"]; ?></li>
                    <li class="list-group-item"><strong>Penjual : </strong><?= $barang["penjual"]; ?></li>
                    <li class="list-group-item"><strong>Kategori : </strong><?= $barang["kategori"]; ?></li>
                    <li class="list-group-item"><strong>Dilihat : </strong><?= $barang["jmlPelihat"]; ?></li>
                    <li class="list-group-item"><strong>Terjual : </strong><?= $barang["jmlTerjual"]; ?></li>
                </ul>
                <div class="card-body">
                    <a href="<?= $barang["linkAsli"]; ?>" class="btn btn-info" target="_blank">Sekarang di FJB Kaskus</a>
                </div>
            </div>
        <?php endforeach; ?>
        </div>
        <!-- Menampilkan data dari FJB Kaskus -->
        <!-- Menampilkan data dari Blanja -->
        <div class="col" id="daftar-produk">
        <a href="https://www.blanja.com/" target="_blank"><img src="img/blanja.png" width="125" class="mb-3"></a>
        <?php foreach($blanja as $produk) : ?>
            <div class="card mb-3" style="width: 18rem;">
                <img src="<?= $produk["gambar"]; ?>" class="card-img-top rounded-lg" alt="...">
                <div class="card-body">
                    <h6 class="card-title"><a href="<?= $produk["linkAsli"]; ?>" target="_blank"><?= $produk["nama"]; ?><?= $produk["nama"]; ?></a></h6>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><h6><strong>Harga : </strong></h6><?= $barang["harga"]; ?></li>
                    <li class="list-group-item"><strong>Toko : </strong><?= $produk["toko"]; ?></li>
                </ul>
                <div class="card-body">
                    <a href="<?= $produk["linkAsli"]; ?>" class="btn btn-info" target="_blank">Sekarang di Blanja</a>
                </div>
            </div>
        <?php endforeach; ?>
        </div>
    </div>
    <!-- Menampilkan data dari Blanja -->
<!-- Row data produk -->
    <hr>

    <?php endif; ?>
<!-- Footer -->
    <div class="partial PartialFooter partial2 of3">
        <div class="PartialFooter-body">
            <ul class="PartialFooter-list">
                <li class="PartialFooter-item">
                    <a class="PartialFooter-item-link"  href='/privacy'>Farhan</a>
                </li>
                <li class="PartialFooter-item">
                    <a class="PartialFooter-item-link"  href='/terms'>Genta</a>
                </li>
                <li class="PartialFooter-item">
                    <a class="PartialFooter-item-link"  href='/cookies'>Haekal</a>
                </li>
            </ul>
        <div class="PartialFooter-copyright">© 2019 Pronto, LLC. All Rights Reserved</div>
    </div>
<!-- Footer -->
</div>
<!-- Container -->
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>