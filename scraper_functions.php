<?php
// Include simple_html_dom.php
include('simple_html_dom.php');

// Function untuk scraping ke website Elevenia
function getFromElevenia($keyword, $limit = 4){
    // Mengubah kata pencarian
    $word = str_replace(" ", "+", htmlspecialchars($keyword));

    // Alamat url pencarian di Elevenia
    $websiteUrl = "https://www.elevenia.co.id/search?q=" . $word . "&lCtgrNo=";

    // Mengambil DOM website Elevenia
    $html = file_get_html($websiteUrl);
    
    // Mendefinisikan array untuk hasil dari scraping
    $elevenia = [];

    // Inisialisasi variabel i
    $i = 1;

    // Pengulangan untuk memgambil seluruh data hasil pencarian
    foreach ($html->find('div.group') as $grup) {
        // Pengecekan limit
        if ($i > htmlspecialchars($limit)) break;

        // Mengambil data nama produk
        $nama = $grup->find('a.pordLink.notranslate', 0)->plaintext;

        // Mengambil data harga produk
        $harga = $grup->find('div.prc strong', 0)->plaintext;

        // Mengambil data nama toko produk
        $toko = $grup->find('li.stroeName a', 0)->plaintext;

        // Mengambil data lokasi toko produk
        $lokasi = $grup->find('ul.sellerPlace li', 0)->plaintext;

        // Mengambil link detail produk di Elevenia
        $linkAsli = $grup->find('a.pordLink.notranslate', 0)->href;

        // Mengambil data gambar produk
        $gambar = $grup->find('img', 0)->src;

        // Memasukkan setiap baris scraping ke array hasil
        $hasil = [
            'nama' => $nama,
            'harga' => $harga,
            'toko' => $toko,
            'lokasi' => $lokasi,
            'linkAsli' => $linkAsli,
            'gambar' => $gambar
        ];

        // Memassukkan setiap index hasil ke array elevenia
        $elevenia[] = $hasil;
        
        // Increment i
        $i++;
    }

    // Membersihkan variabel untuk menghindari memory leak 
    $html->clear();
    unset($html);

    return $elevenia; // Mengembalikkan array elevenia
}

// Function untuk scraping ke website FJB Kaskus
function getFromFjbKaskus($keyword, $limit = 4){
    // Mengubah kata pencarian
    $word = str_replace(" ", "+", htmlspecialchars($keyword));

    // Alamat url pencarian di FJB Kaskus
    $websiteUrl = "https://www.kaskus.co.id/search/fjb?q=". $word ."&forumchoice=";
    
    // Mengambil seluruh file html websit FJB Kaskus
    $html = file_get_html($websiteUrl);

    // Mendefinisikan array untuk hasil dari scraping
    $fjbKaskus = [];

    // Inisialisasi variabel i
    $i = 1;

    // Pengulangan untuk mengambil seluruh data hasil pencarian
    foreach ($html->find('li.product__item') as $item ) {
        // Pengencekan limit
        if ($i > htmlspecialchars($limit)) break;

        // Mengambil data nama produk
        $nama = $item->find('div.title a', 0)->plaintext;

        // Mengambil data harga produk
        $harga = $item->find('div.price div', 0)->plaintext;

        // Mengambil data nama penjual produk
        $penjual = $item->find('div.user a div.username', 0)->plaintext;

        // Mengambil data kategori produk
        $kategori = $item->find('div.category a', 0)->plaintext;

        // Mengambil data jumlah user yang melihat produk
        $pelihat = $item->find('div.info__data div.data--views', 0)->plaintext;

        // Mengambil data jumlah produk terjual
        $terjual = $item->find('div.info__data div.data--reply', 0)->plaintext;

        // Mengambil data gambar produk
        $gambar = $item->find('div.image__photo', 0)->style;
        preg_match("/background-image:url\((.*?)\)/i", $gambar, $linkGambar);
        $gambar = $linkGambar[1];

        // Mengambil data link produk
        $linkAsli = $item->find('div.title a', 0)->href; 

        // Memasukkan setiap baris scraping ke array hasil
        $hasil = [
            'nama' => $nama,
            'harga' => $harga,
            'penjual' => $penjual,
            'kategori' => $kategori,
            'jmlPelihat' => $pelihat,
            'jmlTerjual' => $terjual,
            'gambar' => $gambar,
            'linkAsli' => $linkAsli
        ];

        // Memasukkan setiap index hasil ke array fjbKaskus
        $fjbKaskus[] = $hasil;

        // Increment i
        $i++;
    }

    // Membersihkan variabel untuk menghindari memory leak
    $html->clear();
    unset($hmtl); 

    return $fjbKaskus; // Mengembalikkan array fjbKaskus
}

// Function untuk scraping ke website Blanja
function getFromBlanja($keyword, $limit = 4){
    // Mengubah kata pencarian
    $word = str_replace(" ", "+", htmlspecialchars($keyword));

    // Alamat url pencarian di Blanja
    $websiteUrl = "https://www.blanja.com/search?keywords=" . $word . "&pageno=0&searchtype=product";
    
    // Mengambil DOM website Blanja
    $html = file_get_html($websiteUrl);

    // Mendefinisikan array untuk hasil dari scraping
    $blanja = [];

    // Inisialisasi variabel i
    $i = 1;

    // Pengulanagn untuk mengambil seluruh darta hasil pencarian
    foreach ($html->find('div.product-box') as $product) {
        // Pengecekan limit
        if ($i > htmlspecialchars($limit)) break;
        
        // Mengambil data nama produk
        $nama = $product->find('h3.product-name', 0)->plaintext;

        // Mengambil data harga produk
        $harga = $product->find('div.product-price', 0)->plaintext;

        // Mengambil data toko penjual produk
        $toko = $product->find('a.shop-name.shop-name-grey div', 0)->plaintext;

        // Mengambil data gambar produk
        $gambar = $product->find('a.prod-anchor figure.product-image div img.lazy', 0)->{'data-original'};
        preg_match("/(.*?)\?w=180/i", $gambar, $linkGambar);
        $gambar = ($linkGambar[1]);

        // Mengambil data link asli produk
        $linkAsli = $product->find('a.prod-anchor', 0)->href;

        // Memasukkan setiap baris scraping ke array hasil
        $hasil = [
            'nama' => $nama,
            'harga' => $harga,
            'toko' => $toko,
            'gambar' => $gambar,
            'linkAsli' => $linkAsli
        ];

        // Memasukkan setiap index ke array Blanja
        $blanja[] = $hasil;

        // Increment i
        $i++;
    }

    // Membersihkan variabel untuk meghindari memory leak
    $html->clear();
    unset($html);

    return $blanja; // Mengembalikan array blanja
}

?>

