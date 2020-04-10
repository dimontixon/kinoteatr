<div class="site-blocks-cover overlay" style="background-image: url('images/hero_bg_2.jpg');" data-aos="fade" data-stellar-background-ratio="0.5" data-aos="fade">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-md-8 text-center" data-aos="fade-up" data-aos-delay="400">
                <h1 style="font-size:47px;" ="mb-4">Сеанси</h1>
                <p class="mb-5">перегляд сеансів та пошук за різними критеріями</p>
            </div>
        </div>
    </div>
</div>

<?php
include_once "views/sql_include.php";
$MyData = new mysqli($host, $user, $pass, $database);
$MyData->query("SET NAMES 'utf8'");
function rus_date() {
    $translate = array(
    "am" => "дп",
    "pm" => "пп",
    "AM" => "ДП",
    "PM" => "ПП",
    "Monday" => "Понеділок",
    "Mon" => "Пн",
    "Tuesday" => "Вівторок",
    "Tue" => "Вт",
    "Wednesday" => "Середа",
    "Wed" => "Ср",
    "Thursday" => "Четвер",
    "Thu" => "Чт",
    "Friday" => "П'ятниця",
    "Fri" => "Пт",
    "Saturday" => "Субота",
    "Sat" => "Сб",
    "Sunday" => "Неділя",
    "Sun" => "Нд",
    "January" => "Января",
    "Jan" => "Янв",
    "February" => "Февраля",
    "Feb" => "Фев",
    "March" => "Марта",
    "Mar" => "Мар",
    "April" => "Апреля",
    "Apr" => "Апр",
    "May" => "Мая",
    "May" => "Мая",
    "June" => "Июня",
    "Jun" => "Июн",
    "July" => "Июля",
    "Jul" => "Июл",
    "August" => "Августа",
    "Aug" => "Авг",
    "September" => "Сентября",
    "Sep" => "Сен",
    "October" => "Октября",
    "Oct" => "Окт",
    "November" => "Ноября",
    "Nov" => "Ноя",
    "December" => "Декабря",
    "Dec" => "Дек",
    "st" => "ое",
    "nd" => "ое",
    "rd" => "е",
    "th" => "ое"
    );

    if (func_num_args() > 1) {
        $timestamp = func_get_arg(1);
        return strtr(date(func_get_arg(0), $timestamp), $translate);
    } else {
        return strtr(date(func_get_arg(0)), $translate);
    }
}

$today = date("Y-m-d");
$tomorrow = date('Y-m-d', strtotime($today . ' +1 day'));
$aftertomorrow = date('Y-m-d', strtotime($tomorrow . ' +1 day'));
$afteraftertomorrow = date('Y-m-d', strtotime($aftertomorrow . ' +1 day'));
$afterafteraftertomorrow = date('Y-m-d', strtotime($afteraftertomorrow . ' +1 day'));
$afterafterafteraftertomorrow = date('Y-m-d', strtotime($afterafteraftertomorrow . ' +1 day'));
$allgenre = $MyData->query("SELECT * from `genre`");
?>

<!-- КНОПКА "ДОДАТИ СЕАНС" -->
<div class="row">
    <div class="site-section-heading  mb-3 w-border col-md-2 mx-auto">
        <?php
        if(isset($_SESSION["MyID"])){
        ?>
            <a href='?action=addsession' style="margin-top:-80px;"  class='btn btn-primary px-4 py-2'>Додати сеанс</a>

        <?php
        }
        ?>
    </div>
</div>


<div style="margin-top:-80px;" class="site-section">
    <div class="container">
        <div class="row">
            <div class="site-section-heading  mb-5 w-border col-md-3 mx-auto">
                <form action="" method="post">
                    <select required class="form-control" size="0" name="day">
                        <option value="0">Всі</option><br/>
                        <option value="<?= $today ?>">Сьогодні</option><br/>
                        <option value="<?= $tomorrow ?>">Завтра</option><br/>
                        <option value="<?= $aftertomorrow ?>"><?=rus_date("l", strtotime($aftertomorrow));?></option><br/>
                        <option value="<?= $afteraftertomorrow ?>"><?=rus_date("l", strtotime($afteraftertomorrow));?></option><br/>
                        <option value="<?= $afterafteraftertomorrow ?>"><?=rus_date("l", strtotime($afterafteraftertomorrow));?></option><br/>
                        <option value="<?= $afterafterafteraftertomorrow ?>"><?=rus_date("l", strtotime($afterafterafteraftertomorrow));?></option><br/>
                    </select>
                </div>
                <div class="site-section-heading mb-5 w-border col-md-3 mx-auto">
                    <select class="form-control" size="0" name="time">
                        <option value="0">Оберіть час</option><br/>
                        <option value="before">До обіду</option><br/>
                        <option value="after">Після обіду</option><br/>
                    </select>
                </div>
                <div class="site-section-heading mb-5 w-border col-md-3 mx-auto">
                    <select class="form-control" size="0" name="genre">
                        <option value="0">Оберіть жанр</option><br/>
                        <?php
                        while(($row = $allgenre->fetch_assoc())!=false){
                            echo "<option value='".$row['name']."'>".$row['name']."</option><br/>";
                        }
                        ?>
                    </select>
                </div>
                <div class="site-section-heading mb-5 w-border col-md-2 mx-auto">
                    <button style="margin-top:-2px;" class="btn btn-primary px-4 py-2" type="submit" name="send">Знайти</button>
                </form>
            </div>
        </div>


        <div class="row">
            <?php
            $allfilms = $MyData->query("SELECT DISTINCT `session`.`id` as `s_id`,
                `genre`.`name` as `genre_name`, `film`.`id`, `film`.`photo`, `film`.`name`, `session`.`date`, `session`.`time`, `session`.`price`, `session`.`format`
                 FROM `session`, `film`, `genre`, `film_genre` WHERE `session`.`film_id` = `film`.`id` AND `film`.`id` = `film_genre`.`film_id` AND `film_genre`.`genre_id` = `genre`.`id`
                   group by `s_id`
                   order by `session`.`date`, `session`.`time`");

                if(isset($_POST["send"])){
                    $post_genre = $_POST["genre"];
                    // ВВЕДЕНО ТІЛЬКИ ДЕНЬ
                    if(!empty($_POST["day"]) && empty($_POST["time"]) && empty($_POST["genre"])){
                        while(($row = $allfilms->fetch_assoc())!=false){
                            if($row["date"] == $_POST["day"]){
                                ?>
                                <div class="col-md-6 col-lg-3 mb-5" data-aos="fade-up" data-aos-delay="100">
                                    <a href="?action=fullfilm&film_id=<?= $row["id"] ?>" class="unit-9">
                                        <div class="image" style="background-image: url('.<?=$row['photo']?>');"></div>
                                        <div class="unit-9-content">
                                            <h2><?=$row["name"]?></h2>
                                            <span>Час:<strong><?=$row["time"]?></strong> &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;|&ensp;&ensp;&ensp;&ensp;&ensp;Ціна:<strong><?=$row["price"]?></strong> грн.</span>
                                            <span>Формат:<strong><?=$row["format"]?></strong> &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;<strong><?=$row["date"]?></strong></span>
                                        </div>
                                    </a>
                                    <?php
                                    if(isset($_SESSION["MyID"])){
                                    ?>
                                    <a href='?action=editsession&session_id=<?= $row["s_id"] ?>' class='btn btn-primary px-2 py-2'>Редагувати</a><br>
                                    <a href='?action=place&session_id=<?= $row["s_id"] ?>' class='btn btn-primary px-3 py-2'>Місця</a>
                                    <?php
                                    }
                                    ?>
                                </div>

                                <?php
                            }
                        }
                    // ВВЕДЕНО ТІЛЬКИ ЧАС
                    }elseif(!empty($_POST["time"]) && empty($_POST["day"]) && empty($_POST["genre"])){
                        // ДО ОБІДУ
                        if($_POST["time"] == 'before'){
                            while(($row = $allfilms->fetch_assoc())!=false){
                                if($row["time"] <= '14:00'){
                                    ?>
                                    <div class="col-md-6 col-lg-3 mb-5" data-aos="fade-up" data-aos-delay="100">
                                        <a href="?action=fullfilm&film_id=<?= $row["id"] ?>" class="unit-9">
                                            <div class="image" style="background-image: url('.<?=$row['photo']?>');"></div>
                                            <div class="unit-9-content">
                                                <h2><?=$row["name"]?></h2>
                                                <span>Час:<strong><?=$row["time"]?></strong> &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;|&ensp;&ensp;&ensp;&ensp;&ensp;Ціна:<strong><?=$row["price"]?></strong> грн.</span>
                                                <span>Формат:<strong><?=$row["format"]?></strong> &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;<strong><?=$row["date"]?></strong></span>
                                            </div>
                                        </a>
                                        <?php
                                        if(isset($_SESSION["MyID"])){
                                        ?>
                                        <a href='?action=editsession&session_id=<?= $row["s_id"] ?>' class='btn btn-primary px-4 py-2'>Редагувати</a>
                                        <?php
                                        }
                                        ?>
                                    </div>

                                    <?php
                                }
                            }
                        //  ПІСЛЯ ОБІДУ
                        } elseif($_POST["time"] == 'after') {
                            while(($row = $allfilms->fetch_assoc())!=false){
                                if($row["time"] > '14:00'){
                                    ?>
                                    <div class="col-md-6 col-lg-3 mb-5" data-aos="fade-up" data-aos-delay="100">
                                        <a href="?action=fullfilm&film_id=<?= $row["id"] ?>" class="unit-9">
                                            <div class="image" style="background-image: url('.<?=$row['photo']?>');"></div>
                                            <div class="unit-9-content">
                                                <h2><?=$row["name"]?></h2>
                                                <span>Час:<strong><?=$row["time"]?></strong> &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;|&ensp;&ensp;&ensp;&ensp;&ensp;Ціна:<strong><?=$row["price"]?></strong> грн.</span>
                                                <span>Формат:<strong><?=$row["format"]?></strong> &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;<strong><?=$row["date"]?></strong></span>
                                            </div>
                                        </a>
                                        <?php
                                        if(isset($_SESSION["MyID"])){
                                        ?>
                                        <a href='?action=editsession&session_id=<?= $row["s_id"] ?>' class='btn btn-primary px-4 py-2'>Редагувати</a>
                                        <?php
                                        }
                                        ?>
                                    </div>

                                    <?php
                                }
                            }
                        }
                    // ВИБРАНО ТІЛЬКИ ЖАНР
                    }elseif(!empty($_POST["genre"]) && empty($_POST["day"]) && empty($_POST["time"])){
                        $allfilms_genre = $MyData->query("SELECT DISTINCT `session`.`id` as `s_id`,
                            `genre`.`name` as `genre_name`, `film`.`id`, `film`.`photo`, `film`.`name`, `session`.`date`, `session`.`time`, `session`.`price`, `session`.`format`
                             FROM `session`, `film`, `genre`, `film_genre` WHERE `session`.`film_id` = `film`.`id`
                             AND `film`.`id` = `film_genre`.`film_id` AND `film_genre`.`genre_id` = `genre`.`id`
                             AND `genre`.`name` = '$post_genre'
                               group by `s_id`
                               order by `session`.`time`");
                        while(($row = $allfilms_genre->fetch_assoc())!=false){
                            //if($_POST["genre"] == $row["genre_name"]){
                                ?>
                                <div class="col-md-6 col-lg-3 mb-5" data-aos="fade-up" data-aos-delay="100">
                                    <a href="?action=fullfilm&film_id=<?= $row["id"] ?>" class="unit-9">
                                        <div class="image" style="background-image: url('.<?=$row['photo']?>');"></div>
                                        <div class="unit-9-content">
                                            <h2><?=$row["name"]?></h2>
                                            <span>Час:<strong><?=$row["time"]?></strong> &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;|&ensp;&ensp;&ensp;&ensp;&ensp;Ціна:<strong><?=$row["price"]?></strong> грн.</span>
                                            <span>Формат:<strong><?=$row["format"]?></strong> &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;<strong><?=$row["date"]?></strong></span>
                                        </div>
                                    </a>
                                    <?php
                                    if(isset($_SESSION["MyID"])){
                                    ?>
                                    <a href='?action=editsession&session_id=<?= $row["s_id"] ?>' class='btn btn-primary px-4 py-2'>Редагувати</a>
                                    <?php
                                    }
                                    ?>
                                </div>

                                <?php
                            //}
                        }
                    // ВИБРАНО ТІЛЬКИ ДЕНЬ І ЧАС
                    }elseif(!empty($_POST["day"]) && !empty($_POST["time"]) && empty($_POST["genre"])){
                        // ДО ОБІДУ
                        if($_POST["time"] == 'before'){
                            while(($row = $allfilms->fetch_assoc())!=false){
                                if($row["time"] <= '14:00' && $row["date"] == $_POST["day"]){
                                    ?>
                                    <div class="col-md-6 col-lg-3 mb-5" data-aos="fade-up" data-aos-delay="100">
                                        <a href="?action=fullfilm&film_id=<?= $row["id"] ?>" class="unit-9">
                                            <div class="image" style="background-image: url('.<?=$row['photo']?>');"></div>
                                            <div class="unit-9-content">
                                                <h2><?=$row["name"]?></h2>
                                                <span>Час:<strong><?=$row["time"]?></strong> &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;|&ensp;&ensp;&ensp;&ensp;&ensp;Ціна:<strong><?=$row["price"]?></strong> грн.</span>
                                                <span>Формат:<strong><?=$row["format"]?></strong> &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;<strong><?=$row["date"]?></strong></span>
                                            </div>
                                            <?php
                                            if(isset($_SESSION["MyID"])){
                                            ?>
                                            <a href='?action=editsession&session_id=<?= $row["s_id"] ?>' class='btn btn-primary px-4 py-2'>Редагувати</a>
                                            <?php
                                            }
                                            ?>
                                        </a>
                                    </div>

                                    <?php
                                }
                            }
                        //  ПІСЛЯ ОБІДУ
                        } elseif($_POST["time"] == 'after') {
                            while(($row = $allfilms->fetch_assoc())!=false){
                                if($row["time"] > '14:00' && $row["date"] == $_POST["day"]){
                                    ?>
                                    <div class="col-md-6 col-lg-3 mb-5" data-aos="fade-up" data-aos-delay="100">
                                        <a href="?action=fullfilm&film_id=<?= $row["id"] ?>" class="unit-9">
                                            <div class="image" style="background-image: url('.<?=$row['photo']?>');"></div>
                                            <div class="unit-9-content">
                                                <h2><?=$row["name"]?></h2>
                                                <span>Час:<strong><?=$row["time"]?></strong> &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;|&ensp;&ensp;&ensp;&ensp;&ensp;Ціна:<strong><?=$row["price"]?></strong> грн.</span>
                                                <span>Формат:<strong><?=$row["format"]?></strong> &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;<strong><?=$row["date"]?></strong></span>
                                            </div>
                                        </a>
                                        <?php
                                        if(isset($_SESSION["MyID"])){
                                        ?>
                                        <a href='?action=editsession&session_id=<?= $row["s_id"] ?>' class='btn btn-primary px-4 py-2'>Редагувати</a>
                                        <?php
                                        }
                                        ?>
                                    </div>

                                    <?php
                                }
                            }
                        }
                    // ВИБРАНО ДЕНЬ І ЖАНР
                    }elseif(!empty($_POST["genre"]) && !empty($_POST["day"]) && empty($_POST["time"])){
                        $allfilms_genre = $MyData->query("SELECT DISTINCT `session`.`id` as `s_id`,
                            `genre`.`name` as `genre_name`, `film`.`id`, `film`.`photo`, `film`.`name`, `session`.`date`, `session`.`time`, `session`.`price`, `session`.`format`
                             FROM `session`, `film`, `genre`, `film_genre` WHERE `session`.`film_id` = `film`.`id`
                             AND `film`.`id` = `film_genre`.`film_id` AND `film_genre`.`genre_id` = `genre`.`id`
                             AND `genre`.`name` = '$post_genre'
                               group by `s_id`
                               order by `session`.`time`");
                        while(($row = $allfilms_genre->fetch_assoc())!=false){
                            if($_POST["day"] == $row["date"]){
                                ?>
                                <div class="col-md-6 col-lg-3 mb-5" data-aos="fade-up" data-aos-delay="100">
                                    <a href="?action=fullfilm&film_id=<?= $row["id"] ?>" class="unit-9">
                                        <div class="image" style="background-image: url('.<?=$row['photo']?>');"></div>
                                        <div class="unit-9-content">
                                            <h2><?=$row["name"]?></h2>
                                            <span>Час:<strong><?=$row["time"]?></strong> &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;|&ensp;&ensp;&ensp;&ensp;&ensp;Ціна:<strong><?=$row["price"]?></strong> грн.</span>
                                            <span>Формат:<strong><?=$row["format"]?></strong> &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;<strong><?=$row["date"]?></strong></span>
                                        </div>
                                    </a>
                                    <?php
                                    if(isset($_SESSION["MyID"])){
                                    ?>
                                    <a href='?action=editsession&session_id=<?= $row["s_id"] ?>' class='btn btn-primary px-4 py-2'>Редагувати</a>
                                    <?php
                                    }
                                    ?>
                                </div>

                                <?php
                            }
                        }
                    }
                    //ВИБРАНО ЧАС І ЖАНР
                    elseif(!empty($_POST["genre"]) && empty($_POST["day"]) && !empty($_POST["time"])){
                    $allfilms_genre = $MyData->query("SELECT DISTINCT `session`.`id` as `s_id`,
                        `genre`.`name` as `genre_name`, `film`.`id`, `film`.`photo`, `film`.`name`, `session`.`date`, `session`.`time`, `session`.`price`, `session`.`format`
                         FROM `session`, `film`, `genre`, `film_genre` WHERE `session`.`film_id` = `film`.`id`
                         AND `film`.`id` = `film_genre`.`film_id` AND `film_genre`.`genre_id` = `genre`.`id`
                         AND `genre`.`name` = '$post_genre'
                           group by `s_id`
                           order by `session`.`time`");

                       // ДО ОБІДУ
                       if($_POST["time"] == 'before'){
                           while(($row = $allfilms_genre->fetch_assoc())!=false){
                               if($row["time"] <= '14:00'){
                                   ?>
                                   <div class="col-md-6 col-lg-3 mb-5" data-aos="fade-up" data-aos-delay="100">
                                       <a href="?action=fullfilm&film_id=<?= $row["id"] ?>" class="unit-9">
                                           <div class="image" style="background-image: url('.<?=$row['photo']?>');"></div>
                                           <div class="unit-9-content">
                                               <h2><?=$row["name"]?></h2>
                                               <span>Час:<strong><?=$row["time"]?></strong> &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;|&ensp;&ensp;&ensp;&ensp;&ensp;Ціна:<strong><?=$row["price"]?></strong> грн.</span>
                                               <span>Формат:<strong><?=$row["format"]?></strong> &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;<strong><?=$row["date"]?></strong></span>
                                           </div>
                                       </a>
                                       <?php
                                       if(isset($_SESSION["MyID"])){
                                       ?>
                                       <a href='?action=editsession&session_id=<?= $row["s_id"] ?>' class='btn btn-primary px-4 py-2'>Редагувати</a>
                                       <?php
                                       }
                                       ?>
                                   </div>

                                   <?php
                               }
                           }
                       //  ПІСЛЯ ОБІДУ
                       } elseif($_POST["time"] == 'after') {
                           while(($row = $allfilms_genre->fetch_assoc())!=false){
                               if($row["time"] > '14:00'){
                                   ?>
                                   <div class="col-md-6 col-lg-3 mb-5" data-aos="fade-up" data-aos-delay="100">
                                       <a href="?action=fullfilm&film_id=<?= $row["id"] ?>" class="unit-9">
                                           <div class="image" style="background-image: url('.<?=$row['photo']?>');"></div>
                                           <div class="unit-9-content">
                                               <h2><?=$row["name"]?></h2>
                                               <span>Час:<strong><?=$row["time"]?></strong> &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;|&ensp;&ensp;&ensp;&ensp;&ensp;Ціна:<strong><?=$row["price"]?></strong> грн.</span>
                                               <span>Формат:<strong><?=$row["format"]?></strong> &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;<strong><?=$row["date"]?></strong></span>
                                           </div>
                                       </a>
                                       <?php
                                       if(isset($_SESSION["MyID"])){
                                       ?>
                                       <a href='?action=editsession&session_id=<?= $row["s_id"] ?>' class='btn btn-primary px-4 py-2'>Редагувати</a>
                                       <?php
                                       }
                                       ?>
                                   </div>

                                   <?php
                               }
                           }
                       }
                    // КОЛИ ОБРАНО ВСЕ
                    }elseif(!empty($_POST["genre"]) && !empty($_POST["day"]) && !empty($_POST["time"])){
                    $allfilms_genre = $MyData->query("SELECT DISTINCT `session`.`id` as `s_id`,
                        `genre`.`name` as `genre_name`, `film`.`id`, `film`.`photo`, `film`.`name`, `session`.`date`, `session`.`time`, `session`.`price`, `session`.`format`
                         FROM `session`, `film`, `genre`, `film_genre` WHERE `session`.`film_id` = `film`.`id`
                         AND `film`.`id` = `film_genre`.`film_id` AND `film_genre`.`genre_id` = `genre`.`id`
                         AND `genre`.`name` = '$post_genre'
                           group by `s_id`
                           order by `session`.`time`");
                           if($_POST["time"] == 'before'){
                               while(($row = $allfilms_genre->fetch_assoc())!=false){
                                   if($row["time"] <= '14:00' && $row["date"] == $_POST["day"]){
                                       ?>
                                       <div class="col-md-6 col-lg-3 mb-5" data-aos="fade-up" data-aos-delay="100">
                                           <a href="?action=fullfilm&film_id=<?= $row["id"] ?>" class="unit-9">
                                               <div class="image" style="background-image: url('.<?=$row['photo']?>');"></div>
                                               <div class="unit-9-content">
                                                   <h2><?=$row["name"]?></h2>
                                                   <span>Час:<strong><?=$row["time"]?></strong> &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;|&ensp;&ensp;&ensp;&ensp;&ensp;Ціна:<strong><?=$row["price"]?></strong> грн.</span>
                                                   <span>Формат:<strong><?=$row["format"]?></strong> &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;<strong><?=$row["date"]?></strong></span>
                                               </div>
                                           </a>
                                           <?php
                                           if(isset($_SESSION["MyID"])){
                                           ?>
                                           <a href='?action=editsession&session_id=<?= $row["s_id"] ?>' class='btn btn-primary px-4 py-2'>Редагувати</a>
                                           <?php
                                           }
                                           ?>
                                       </div>

                                       <?php
                                   }
                               }
                           //  ПІСЛЯ ОБІДУ
                           } elseif($_POST["time"] == 'after') {
                               while(($row = $allfilms_genre->fetch_assoc())!=false){
                                   if($row["time"] > '14:00' && $row["date"] == $_POST["day"]){
                                       ?>
                                       <div class="col-md-6 col-lg-3 mb-5" data-aos="fade-up" data-aos-delay="100">
                                           <a href="?action=fullfilm&film_id=<?= $row["id"] ?>" class="unit-9">
                                               <div class="image" style="background-image: url('.<?=$row['photo']?>');"></div>
                                               <div class="unit-9-content">
                                                   <h2><?=$row["name"]?></h2>
                                                   <span>Час:<strong><?=$row["time"]?></strong> &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;|&ensp;&ensp;&ensp;&ensp;&ensp;Ціна:<strong><?=$row["price"]?></strong> грн.</span>
                                                   <span>Формат:<strong><?=$row["format"]?></strong> &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;<strong><?=$row["date"]?></strong></span>
                                               </div>
                                           </a>
                                           <?php
                                           if(isset($_SESSION["MyID"])){
                                           ?>
                                           <a href='?action=editsession&session_id=<?= $row["s_id"] ?>' class='btn btn-primary px-4 py-2'>Редагувати</a>
                                           <?php
                                           }
                                           ?>
                                       </div>

                                       <?php
                                   }
                               }
                           }
                    // КОЛИ НІЧОГО НЕ ОБРАНО
                    } else {
                        while(($row = $allfilms->fetch_assoc())!=false){
                            ?>
                            <div class="col-md-6 col-lg-3 mb-5" data-aos="fade-up" data-aos-delay="100">
                                <a href="?action=fullfilm&film_id=<?= $row["id"] ?>" class="unit-9">
                                    <div class="image" style="background-image: url('.<?=$row['photo']?>');"></div>
                                    <div class="unit-9-content">
                                        <h2><?=$row["name"]?></h2>
                                        <span>Час:<strong><?=$row["time"]?></strong> &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;|&ensp;&ensp;&ensp;&ensp;&ensp;Ціна:<strong><?=$row["price"]?></strong> грн.</span>
                                        <span>Формат:<strong><?=$row["format"]?></strong> &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;<strong><?=$row["date"]?></strong></span>
                                    </div>
                                </a>
                                <?php
                                if(isset($_SESSION["MyID"])){
                                ?>
                                <a href='?action=editsession&session_id=<?= $row["s_id"] ?>' class='btn btn-primary px-4 py-2'>Редагувати</a>
                                <?php
                                }
                                ?>
                            </div>

                            <?php

                        }
                    }
                } else {
                    while(($row = $allfilms->fetch_assoc())!=false){
                        ?>
                        <div class="col-md-6 col-lg-3 mb-5" data-aos="fade-up" data-aos-delay="100">
                            <a href="?action=fullfilm&film_id=<?= $row["id"] ?>" class="unit-9">
                                <div class="image" style="background-image: url('.<?=$row['photo']?>');"></div>
                                <div class="unit-9-content">
                                    <h2><?=$row["name"]?></h2>
                                    <span>Час:<strong><?=$row["time"]?></strong> &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;|&ensp;&ensp;&ensp;&ensp;&ensp;Ціна:<strong><?=$row["price"]?></strong> грн.</span>
                                    <span>Формат:<strong><?=$row["format"]?></strong> &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;<strong><?=$row["date"]?></strong></span>
                                </div>
                            </a>
                            <?php
                            if(isset($_SESSION["MyID"])){
                            ?>
                            <a href='?action=editsession&session_id=<?= $row["s_id"] ?>' class='btn btn-primary px-4 py-2'>Редагувати</a>
                            <?php
                            }
                            ?>
                        </div>

                        <?php

                    }
                }
                $MyData->close();
                ?>
            </div>

        </div>
    </div>
