<div class="site-blocks-cover overlay" style="background-image: url('images/hero_bg_2.jpg');" data-aos="fade" data-stellar-background-ratio="0.5" data-aos="fade">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-md-8 text-center" data-aos="fade-up" data-aos-delay="400">
                <h1 style="font-size:47px;" ="mb-4">Фільми</h1>
                <p class="mb-5">перелік усіх фільмів, які є в прокаті</p>
            </div>
        </div>
    </div>
</div>

<div class="site-section">
    <div class="container">
        <?php
        if(isset($_SESSION["MyID"])){
        ?>
            <a href='?action=addfilm' style="margin-top:-80px;"  class='btn btn-primary px-4 py-2'>Додати фільм</a>
            <hr>
        <?php
        }
        ?>
        <?php
        include_once "views/sql_include.php";
        $MyData = new mysqli($host, $user, $pass, $database);
        $MyData->query("SET NAMES 'utf8'");
        $allfilms = $MyData->query("SELECT * FROM `film`");
        while(($row = $allfilms->fetch_assoc())!=false){
            if($row["visible"]==1){
            ?>
                <div style="margin-bottom:40px;" class="row">
                    <div class="col-lg-4">
                        <form method='get'>
                            <a href='?action=fullfilm&film_id=<?= $row["id"] ?>' ><img width="300px" height="600px" src="<?= $row["photo"] ?>" alt="Image" class="img-fluid"></a>
                        </form>

                    </div>
                    <div class="col-lg-6">
                        <div class="site-section-heading text-left mb-5 w-border col-md-12 mx-auto">
                            <form method='get'>
                                <a href='?action=fullfilm&film_id=<?= $row["id"] ?>' ><h2 class="mb-5"><?= $row["name"] ?></h2></a>
                            </form>
                            <p><strong>Вік:</strong> <?= $row["age"] ?>+</p>
                            <p><strong>Дата виходу в світі:</strong> <?= date("d.m.Y", strtotime($row["release_date_world"])) ?></p>
                            <p><strong>Дата виходу в Україні:</strong> <?= date("d.m.Y", strtotime($row["release_date_ukraine"])) ?></p>
                            <p><strong>Тривалість, хв:</strong> <?= $row["duration_minute"] ?></p>
                            <p><?= mb_strimwidth($row["description"], 0, 245, "...") ?></p>
                            <form method='get'>
                                <a href='?action=fullfilm&film_id=<?= $row["id"] ?>' class='btn btn-primary px-4 py-2'>Детальніше про фільм</a>
                                <?php
                                if(isset($_SESSION["MyID"])){
                                ?>
                                <a href='?action=editfilm&film_id=<?= $row["id"] ?>' class='btn btn-primary px-4 py-2'>Редагувати</a>
                                <?php
                                }
                                ?>
                            </form>


                        </div>
                    </div>
                </div>
            <?php
        }
        }
        $MyData->close();
        ?>

    </div>
</div>
