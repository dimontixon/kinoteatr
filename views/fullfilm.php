<?php
$film_id=(int)$_GET['film_id'];
include_once "views/sql_include.php";
$MyData = new mysqli($host, $user, $pass, $database);
$MyData->query("SET NAMES 'utf8'");
$allfilms = $MyData->query("SELECT * FROM `film` WHERE `film`.`id` = ".$film_id);
$allgenre = $MyData->query("SELECT `genre`.`name` FROM `genre`, `film`, `film_genre` WHERE `film_genre`.`genre_id` = `genre`.`id` AND `film_genre`.`film_id` = `film`.`id` AND `film`.`id` = ".$film_id);
$allcountry = $MyData->query("SELECT `country`.`name` FROM `country`, `film`, `film_country` WHERE `film_country`.`country_id` = `country`.`id` AND `film_country`.`film_id` = `film`.`id` AND `film`.`id` = ".$film_id);
$rowfilm = $allfilms->fetch_row();
?>

<div class="site-blocks-cover overlay" style="margin-top: -30px;background-image: url('.<?= $rowfilm[8] ?>');" data-aos="fade" data-stellar-background-ratio="0.5" data-aos="fade">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-md-8 text-center" data-aos="fade-up" data-aos-delay="400">
                <h1 style="font-size:47px;" class="mb-4">Фільм <strong>"<?= $rowfilm[1] ?>"</strong></h1>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="featured-property-half d-flex">
        <div class="image"  style="background-image: url('.<?= $rowfilm[8] ?>'); background-size:100% 100%;"></div>
        <div class="text">
            <h2>Все про фільм <strong>"<?= $rowfilm[1] ?>"</strong></h2>

            <ul style="font-size:20px;" class="property-list-details mb-5">
                <li>Вік: <strong><?= $rowfilm[2] ?>+</strong></li>
                <br>
                <li>Дата виходу в світі: <strong><?= date("d.m.Y", strtotime($rowfilm[3])) ?></strong></li>
                <br>
                <li>Дата виходу в Україні: <strong><?= date("d.m.Y", strtotime($rowfilm[4])) ?></strong></li>
                <br>
                <li>Тривалість: <strong><?= $rowfilm[5] ?> хв.</strong></li>
                <br>
                <li>Бюджет: <strong><?= $rowfilm[6] ?> млн. дол. США</strong></li>
                <br>
                <li><strong>Жанр:</strong>
                    <?php
                    while(($rowgenre = $allgenre->fetch_assoc())!=false){
                        echo $rowgenre["name"].", ";
                    }
                    ?>
                </li>
                <br>
                <li><strong>Країна:</strong>
                    <?php
                    while(($rowcountry = $allcountry->fetch_assoc())!=false){
                        echo $rowcountry["name"].", ";
                    }
                    ?>
                </li>
            </ul>
        </div>
    </div>
</div>

<div style="margin-top:-60px;" class="site-section">
    <div class="container">

        <div class="col-lg-10 mb-5 mb-lg-0">
            <div class="mb-5">
                <h3 class="footer-heading mb-4">Опис фільму "<strong><?= $rowfilm[1] ?></strong>"</h3>
                <div class="block-16">
                    <samp><?=$rowfilm[7]?></samp>
                    <!-- <p><?=//$rowfilm[7]?></p> -->
                </div>
            </div>
        </div>

        <div class="col-lg-8 mb-5 mb-lg-0">
            <div class="mb-5">
                <h3 class="footer-heading mb-4">Трейлер фільму "<strong><?= $rowfilm[1] ?></strong>"</h3>

                <div class="block-16">
                    <figure>
                        <iframe width="840" height="473" src="https://www.youtube.com/embed/<?= $rowfilm[9] ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </figure>
                </div>

            </div>
        </div>
    </div>



</div>
