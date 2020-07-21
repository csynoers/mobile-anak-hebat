<div class="card border-0">
    <img class="card-img-top" src="https://anakhebatindonesia.com/joimg/book/<?= esc($book->image) ?>" alt="<?= esc($book->title) ?>">
    <div class="card-body">
        <h5 class="card-title"><?= esc($book->title) ?></h5>
        <p>
            Authors : 
            <?php
                $authors_htmls = [];
                foreach ($authors as $key => $value) : 
                    $authors_htmls[] = '<a href="'.base_url('/author/detail/' .esc($value->id_author) .'/' .esc($value->seo)).'">'.esc($value->name).'</a>';
                endforeach;
                echo implode(', ',$authors_htmls);
            ?>
        </p>
        <p><?= esc($book->hargaMod) ?></p>
        <table class="table">
            <tbody>
                <tr>
                    <td>Judul</td>
                    <td>: <?= esc($book->title) ?></td>
                </tr>
                <tr>
                    <td>Nomor ISBN</td>
                    <td>: <?= esc($book->isbn) ?></td>
                </tr>
                <tr>
                    <td>Penerbit</td>
                    <td>: <a href="<?= base_url('/penerbit/detail/' .esc($penerbit->id_unit_usaha) .'/' .esc($penerbit->seo)) ?>"><?= esc($penerbit->title) ?></a></td>
                </tr>
                <tr>
                    <td>Kategori</td>
                    <td>: <a href="<?= base_url('/kategori/detail/' .esc($kategori->id_sub_kat_imprint) .'/' .esc($kategori->seo)) ?>"><?= esc($kategori->title) ?></a></td>
                </tr>
                <tr>
                    <td>Jenis Cover</td>
                    <td>: <?= esc($book->jenis_cover) ?></td>
                </tr>
                <tr>
                    <td>Kertas Isi</td>
                    <td>: <?= esc($book->kertas_isi) ?></td>
                </tr>
                <tr>
                    <td>Tebal Buku</td>
                    <td>: <?= esc("{$book->tebal} Halaman") ?></td>
                </tr>
                <tr>
                    <td>Berat Buku</td>
                    <td>: <?= esc(($book->berat*1000). " Gram") ?></td>
                </tr>
                <tr>
                    <td>Dimensi</td>
                    <td>: <?= esc($book->ukuran) ?></td>
                </tr>
                <tr>
                    <td>Lokasi Stok</td>
                    <td>: 
                        <?php
                            if (esc($book->stok) == 'Y') {
                                echo "Gudang Anak Hebat Indonesia";
                            }elseif(esc($book->stok) == 'S'){
                                echo "Gudang Supplier";
                            }else{
                                echo "- Habis -";
                            }
                        ?>
                    </td>
                </tr>
            </tbody>
        </table>
        
        <hr>

        <!-- Nav tabs -->
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#home">Sinopsis</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#menu1">Keunggulan</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#menu2">Resensi</a>
            </li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content pt-3 text-justify">
            <div class="tab-pane container active" id="home"><?= html_entity_decode(esc($book->sinopsis)) ?></div>
            <div class="tab-pane container fade" id="menu1"><?= html_entity_decode(esc($book->keunggulan)) ?></div>
            <div class="tab-pane container fade" id="menu2">
                <?php
                    if (count($resensies) > 0) {
                        # if not empty resensies
                    } else {
                        # if empty resensies
                        echo "
                            <div class='alert alert-info'>
                                <strong>Maaf!</strong> Belum ada resensi mengenai buku ini dan untuk mengisi resensi anda harus memiliki buku ini terlebih dahulu dengan cara membelinya.                                                  
                            </div>
                        ";
                    }
                ?>
            </div>
        </div>

    </div>
</div>