<div class="owl-carousel owl-slideshow owl-theme">
    <?php foreach ($slideshow as $key => $value) : ?>
        <div class="item">
            <img src="https://anakhebatindonesia.com/joimg/slide/<?= $value->gambar ?>" alt="">
        </div>
    <?php endforeach; ?>
</div>
<!-- End Slide ------------------------------------------------------------------------------->

<div class="ml-3 mr-3">
    <h4 class="float-left title-border-bottom-primary">New Release</h4>
    <a href="<?= base_url() ?>" class="float-right"><i class="fa fa fa-arrow-right"></i> View all</a>
</div>
<div class="owl-carousel owl-new-release owl-theme mt-5">
    <?php foreach ($new_release as $key => $value) : ?>
        <div class="item" title="<?= $value->title ?>">
            <div class="card border-0">
                <img class="card-img-top" src="https://anakhebatindonesia.com/joimg/book/small/small_<?= $value->image ?>" alt="Card image" style="width:100%">
                <div class="card-body text-center">
                    <a href="<?= base_url("/book/detail/{$value->id_book}/{$value->seo}") ?>" class="stretched-link"><h6 class="card-title"><?= character_limiter($value->title, $limit = 15, $end_char = '&#8230;') ?></h6></a>
                    <p><?= $value->hargaMod ?></p>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<!-- End New Release ------------------------------------------------------------------------->

<div class="ml-3 mr-3">
    <h4 class="float-left title-border-bottom-primary">Coming Soon</h4>
    <a href="<?= base_url() ?>" class="float-right"><i class="fa fa fa-arrow-right"></i> View all</a>
</div>
<div class="owl-carousel owl-coming-soon owl-theme mt-5">
    <?php foreach ($coming_soon as $key => $value) : ?>
        <div class="item" title="<?= $value->title ?>">
            <div class="card border-0">
                <img class="card-img-top" src="https://anakhebatindonesia.com/joimg/book/small/small_<?= $value->image ?>" alt="Card image" style="width:100%">
                <div class="card-body text-center">
                    <a href="<?= base_url("/book/detail/{$value->id_book}/{$value->seo}") ?>" class="stretched-link"><h6 class="card-title"><?= character_limiter($value->title, $limit = 15, $end_char = '&#8230;') ?></h6></a>
                    <p><?= $value->hargaMod ?></p>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<!-- End Coming Soon ------------------------------------------------------------------------->

<div class="ml-3 mr-3">
    <h4 class="float-left title-border-bottom-primary">Recomended Book</h4>
    <a href="<?= base_url() ?>" class="float-right"><i class="fa fa fa-arrow-right"></i> View all</a>
</div>
<div class="owl-carousel owl-best-seller owl-theme mt-5">
    <?php foreach ($best_seller as $key => $value) : ?>
        <div class="item" title="<?= $value->title ?>">
            <div class="card border-0">
                <img class="card-img-top" src="https://anakhebatindonesia.com/joimg/book/small/small_<?= $value->image ?>" alt="Card image" style="width:100%">
                <div class="card-body text-center">
                    <a href="<?= base_url("/book/detail/{$value->id_book}/{$value->seo}") ?>" class="stretched-link"><h6 class="card-title"><?= character_limiter($value->title, $limit = 15, $end_char = '&#8230;') ?></h6></a>
                    <p><?= $value->hargaMod ?></p>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<!-- End Recomended Book --------------------------------------------------------------------->