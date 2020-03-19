<div class="site-blocks-cover overlay" style="background-image: url('images/hero_bg_2.jpg');" data-aos="fade" data-stellar-background-ratio="0.5" data-aos="fade">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-md-8 text-center" data-aos="fade-up" data-aos-delay="400">
                <h1 style="font-size:47px;" ="mb-4">Додавання фільму</h1>
            </div>
        </div>
    </div>
</div>

<?php
include_once "views/sql_include.php";
$MyData = new mysqli($host, $user, $pass, $database);
$MyData->query("SET NAMES 'utf8'");
$allcountry = $MyData->query("SELECT * from `country`");
$allgenre = $MyData->query("SELECT * from `genre`");
$full_photo_path = $file_name = $file_tmp = '';
$wasError = false;

if(isset($_POST["send"])){
    // if(isset($_FILES['photo'])){
    //     $file_name = $_FILES['photo']['name'];
    //     $file_tmp = $_FILES['photo']['tmp_name'];
    //
    //     // move_uploaded_file($file_tmp,"img/photo_recipes/".$file_name);
    //     // $full_photo_path = "img/photo_recipes/".$file_name;
    //     if($_FILES['photo']['size'] > 2097152){
    //         $photoErr = 'Фото повинно бути розміром менше 2 Мб';
    //         $wasError = true;
    //     }
    //
    //     switch ($_FILES['photo']['type']) {
    //         case 'image/jpeg':
    //         //case 'image/jpg':
    //             $type = 'jpeg';
    //             break;
    //
    //         case 'image/png':
    //             $type = 'png';
    //             break;
    //
    //         default:
    //             $photoErr = "Фото повинно бути форматом jpeg або png та повинно бути розміром менше 2 Мб";
    //             $wasError = true;
    //             break;
    //     }
    //
    //
    //
    // }

    if ($wasError == false){
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
        if(isset($_FILES['photo'])){
            $file_name = $_FILES['photo']['name'];
            $file_tmp = $_FILES['photo']['tmp_name'];
            move_uploaded_file($file_tmp,"images/photo_films/".$file_name);
            $full_photo_path = "images/photo_films/".$file_name;
        }

         $MyData->query("INSERT INTO `film` (`name`, `age`, `release_date_world`, `release_date_ukraine`, `duration_minute`, `budget_mln_usd`, `description`, `photo`, `trailer`, `visible`)
         VALUES ('$name', '$age', '$release_date_world', '$release_date_ukraine', '$duration_minute', '$budget_mln_usd', '$description', '$full_photo_path', '$trailer', '$visible')");

        $maxFilms_id = $MyData->query("SELECT MAX(`id`) FROM `film`");
        $f_id = $maxFilms_id->fetch_row()[0];
        foreach ($_POST['country'] as $c ) {
            $MyData->query("INSERT INTO `film_country` (`film_id`, `country_id`) VALUES ('$f_id', '$c')");
        }
        foreach ($_POST['genre'] as $g ) {
            $MyData->query("INSERT INTO `film_genre` (`film_id`, `genre_id`) VALUES ('$f_id', '$g')");
        }
        //echo "<script>location.assign('?action=addfilm')</script>";
        //exit;


    }
}
$MyData->close();
?>

<?php if(isset($_SESSION["MyID"])){ ?>
    <div class="site-section border-bottom">
        <div class="container">
            <div class="row ">
                <div class="col-md-12 col-lg-7 mb-5">
                    <form method="post" class="contact-form">
                        <!-- <div style="color:red;" class="help-block with-errors"><?=$errorMsg?></div> -->
                        <div class="row form-group">
                            <div class="col-md-12 mb-3 mb-md-0">
                                <label class="font-weight-bold" for="film_name">Назва фільму:</label>
                                <input required name="name" type="text" id="film_name" class="form-control" placeholder="Назва фільму">
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-4">
                                <label class="font-weight-bold" for="age">Вікове обмеження:</label>
                                <input required name="age" type="number" id="age" class="form-control" placeholder="Вікове обмеження">
                            </div>
                            <div class="col-md-3">
                                <label class="font-weight-bold" for="duration_minute">Тривалість, хв:</label>
                                <input required name="duration_minute" type="number" id="duration_minute" class="form-control" placeholder="Тривалість">
                            </div>
                            <div class="col-md-5">
                                <label class="font-weight-bold" for="budget_mln_usd">Бюджет, млн. дол. США:</label>
                                <input required name="budget_mln_usd" type="number" id="budget_mln_usd" class="form-control" placeholder="Бюджет">
                            </div>

                        </div>

                        <div class="row form-group">
                            <div class="col-md-4">
                                <label class="font-weight-bold" for="release_date_world">Дата виходу в світі:</label>
                                <input required name="release_date_world" type="date" id="release_date_world" class="form-control" placeholder="Дата виходу в світі">
                            </div>
                            <div class="col-md-4">
                                <label class="font-weight-bold" for="release_date_ukraine">Дата виходу в Україні:</label>
                                <input required name="release_date_ukraine" type="date" id="release_date_ukraine" class="form-control" placeholder="Дата виходу в Україні">
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-4">
                                <label class="font-weight-bold" for="country">Країна виробник:</label>
                                <select multiple required title="Виберіть країну" class="form-control selectpicker" size="0" name="country[]" id="country">
                                    <?php
                                    while(($row = $allcountry->fetch_assoc())!=false){
                                        echo "<option value='".$row['id']."'>".$row['name']."</option><br/>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="font-weight-bold" for="genre">Жанр:</label>
                                <select multiple required title="Виберіть жанр" class="form-control selectpicker" size="0" name="genre[]" id="genre">
                                    <?php
                                    while(($row = $allgenre->fetch_assoc())!=false){
                                        echo "<option value='".$row['id']."'>".$row['name']."</option><br/>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-12">
                                <label class="font-weight-bold" for="description">Опис фільму:</label>
                                <textarea required rows="6" name="description" type="date" id="description" class="form-control" placeholder="Опис фільму"></textarea>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-10">
                                <label class="font-weight-bold" for="form_photo">Фото:</label>
                                <input required name="photo" type="file" id="form_photo" class="form-control-file">
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-12">
                                <label class="font-weight-bold" for="trailer">Посилання на трейлер в YouTube:</label>
                                <input required name="trailer" type="text" id="trailer" class="form-control" placeholder="Посилання на трейлер">
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-12">
                                <label  class="font-weight-bold" for="visible">В прокаті?(так/ні):</label>
                                <input  style="margin-left:10px;margin-top:10px;" value="0" name="visible" type="checkbox" id="visible" class="form-check-input">
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-4">
                                <button type="submit" name="send" class="btn btn-primary py-3 px-4">Додати</button>
                            </div>
                            <div class="col-md-6">
                                <button type="reset" name="reset" class="btn btn-primary py-3 px-4">Очистити</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
