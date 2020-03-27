<div class="site-blocks-cover overlay" style="background-image: url('images/hero_bg_2.jpg');" data-aos="fade" data-stellar-background-ratio="0.5" data-aos="fade">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-md-8 text-center" data-aos="fade-up" data-aos-delay="400">
                <h1 style="font-size:47px;" ="mb-4">Редагування фільму</h1>
                <!-- <p class="mb-5">перелік усіх фільмів, які є в прокаті</p> -->
            </div>
        </div>
    </div>
</div>

<?php
$film_id=(int)$_GET['film_id'];
include_once "views/sql_include.php";
$MyData = new mysqli($host, $user, $pass, $database);
$MyData->query("SET NAMES 'utf8'");
$allfilms = $MyData->query("SELECT * FROM `film` WHERE `id` = ".$film_id);
$allcountry = $MyData->query("SELECT * from `country`");
$allgenre = $MyData->query("SELECT * from `genre`");

$allfilmgenre = $MyData->query("SELECT `genre`.`id`, `genre`.`name` FROM `genre`, `film`, `film_genre` WHERE `film_genre`.`genre_id` = `genre`.`id`
        AND `film_genre`.`film_id` = `film`.`id` AND `film`.`id` = ".$film_id);
$rowfilmgenre = $allfilmgenre->fetch_assoc();

$allfilmcountry = $MyData->query("SELECT `country`.`id` FROM `country`, `film`, `film_country` WHERE `film_country`.`country_id` = `country`.`id`
    AND `film_country`.`film_id` = `film`.`id` AND `film`.`id` = ".$film_id);
// $rowfilmcountry = $allfilmcountry->fetch_assoc();



$row = $allfilms->fetch_assoc();
$name=$row["name"];
$age=$row["age"];
$release_date_world=$row["release_date_world"];
$release_date_ukraine=$row["release_date_ukraine"];
$duration_minute=$row["duration_minute"];
$budget_mln_usd=$row["budget_mln_usd"];
$description=$row["description"];
$value_photo = $row["photo"];
$trailer = $row["trailer"];

if($row["visible"] == 1){
    $visible = 'checked';
} else {
    $visible = '';
}
$full_photo_path = $file_name = $file_tmp = '';

if(isset($_POST["send"])){
    if(!isset($_FILES['photo'])){
		$full_photo_path = $row["photo"];
	}else{
		$file_name = $_FILES['photo']['name'];
		$file_tmp = $_FILES['photo']['tmp_name'];
		if($_FILES['photo']['size'] > 2097152){
			$photoErr = 'Фото повинно бути розміром менше 2 Мб';
			$wasError = true;
		}
	}

    if(empty($_FILES['photo']['name'])){
        $full_photo_path = $row["photo"];
    }else{
        move_uploaded_file($file_tmp,"images/films/".$file_name);
        $full_photo_path = "/images/films/".$file_name;
    }

        $name=htmlspecialchars ($_POST["name"]);
        $age=$_POST["age"];
        $release_date_world = $_POST["release_date_world"];
        $release_date_ukraine = $_POST["release_date_ukraine"];
        $duration_minute=$_POST["duration_minute"];
        $budget_mln_usd=$_POST["budget_mln_usd"];
        $description=htmlspecialchars ($_POST["description"]);
        $trailer=htmlspecialchars ($_POST["trailer"]);

        if(isset($_POST["visible"])){
            $visible = 1;
        } else {
            $visible = 0;
        }

        $MyData->query("UPDATE `film` SET `name` = '$name', `age` = '$age', `release_date_world` = '$release_date_world',  `release_date_ukraine` = '$release_date_ukraine', `duration_minute` = '$duration_minute',
        `budget_mln_usd` = '$budget_mln_usd', `description` = '$description', `photo` = '$full_photo_path', `trailer` = '$trailer', `visible` = '$visible'  WHERE `id` = '$film_id'");
        // include_once "views/main.php";
        // include_once "layout/footer.php";
        // exit;

}
$MyData->close();
?>


<?php if(isset($_SESSION["MyID"])){ ?>
    <div class="site-section border-bottom">
        <div class="container">
            <div class="row ">
                <div class="col-md-12 col-lg-7 mb-5">
                    <form method="post" class="contact-form">
                        <div class="row form-group">
                            <div class="col-md-12 mb-3 mb-md-0">
                                <label class="font-weight-bold" for="film_name">Назва фільму:</label>
                                <input required name="name" value="<?=$name?>" type="text" id="film_name" class="form-control" placeholder="Назва фільму">
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-4">
                                <label class="font-weight-bold" for="age">Вікове обмеження:</label>
                                <input required name="age" type="number" value="<?=$age?>" id="age" class="form-control" placeholder="Вікове обмеження">
                            </div>
                            <div class="col-md-3">
                                <label class="font-weight-bold" for="duration_minute">Тривалість, хв:</label>
                                <input required name="duration_minute" value="<?= $duration_minute ?>" type="number" id="duration_minute" class="form-control" placeholder="Тривалість">
                            </div>
                            <div class="col-md-5">
                                <label class="font-weight-bold" for="budget_mln_usd">Бюджет, млн. дол. США:</label>
                                <input required name="budget_mln_usd" value="<?=$budget_mln_usd?>" type="number" id="budget_mln_usd" class="form-control" placeholder="Бюджет">
                            </div>

                        </div>

                        <div class="row form-group">
                            <div class="col-md-4">
                                <label class="font-weight-bold" for="release_date_world">Дата виходу в світі:</label>
                                <input required name="release_date_world" value="<?=$release_date_world?>" type="date" id="release_date_world" class="form-control" placeholder="Дата виходу в світі">
                            </div>
                            <div class="col-md-4">
                                <label class="font-weight-bold" for="release_date_ukraine">Дата виходу в Україні:</label>
                                <input required name="release_date_ukraine" value="<?=$release_date_ukraine?>" type="date" id="release_date_ukraine" class="form-control" placeholder="Дата виходу в Україні">
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-4">
                                <label class="font-weight-bold" for="country">Країна виробник:</label>
                                <select multiple required title="Виберіть країну" class="form-control selectpicker" size="0" name="country[]" id="country">
                                    <?php

                                    while(($row_country = $allcountry->fetch_assoc())!=false ){
                                        while(($rowfilmcountry = $allfilmcountry->fetch_assoc())!=false){
                                            if($row_country['id'] == $rowfilmcountry['id']){
                                                echo "<option selected value='".$row_country['id']."'>".$row_country['name']."</option><br/>";
                                            } else {
                                                echo "<option value='".$row_country['id']."'>".$row_country['name']."</option><br/>";
                                            }
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="font-weight-bold" for="genre">Жанр:</label>
                                <select multiple required title="Виберіть жанр" class="form-control selectpicker" size="0" name="genre[]" id="genre">
                                    <?php
                                    while(($row_genre = $allgenre->fetch_assoc())!=false){
                                        if($rowfilmgenre['id'] == $row_genre['id']){
                                            echo "<option selected value='".$row_genre['id']."'>".$row_genre['name']."</option><br/>";
                                        } else {
                                            echo "<option value='".$row_genre['id']."'>".$row_genre['name']."</option><br/>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-12">
                                <label class="font-weight-bold" for="description">Опис фільму:</label>
                                <textarea required rows="15" name="description" type="date" id="description" class="form-control" placeholder="Опис фільму"><?=$description?></textarea>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-10">
                                <label class="font-weight-bold" for="form_photo">Фото:</label>
                                <input name="photo" value="<?= $value_photo ?>" type="file" id="form_photo" class="form-control-file">
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-12">
                                <label class="font-weight-bold" for="trailer">Посилання на трейлер в YouTube:</label>
                                <p style="font-size:13px;"><span style="color:red;">!!!</span> (відкрийте відео на YouTube та скопіюйте з URL тільки частину після "watch?v=" і вставте нижче)</p>
                                <input required name="trailer" value="<?=$trailer?>" type="text" id="trailer" class="form-control" placeholder="Посилання на трейлер">
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-12">
                                <label  class="font-weight-bold" for="visible">В прокаті?(так/ні):</label>
                                <input  style="margin-left:10px;margin-top:10px;" <?= $visible ?> name="visible" type="checkbox" id="visible" class="form-check-input">
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-4">
                                <button type="submit" name="send" class="btn btn-primary py-3 px-4">Редагувати</button>
                            </div>
                            <div class="col-md-6">
                                <a href="?action=films" class="btn btn-primary py-3 px-4">Скасувати</a>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
