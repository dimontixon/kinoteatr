<div class="site-blocks-cover overlay" style="background-image: url('images/hero_bg_2.jpg');" data-aos="fade" data-stellar-background-ratio="0.5" data-aos="fade">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-md-8 text-center" data-aos="fade-up" data-aos-delay="400">
                <h1 style="font-size:47px;" ="mb-4">Редагування сеансу</h1>
                <!-- <p class="mb-5">перелік усіх фільмів, які є в прокаті</p> -->
            </div>
        </div>
    </div>
</div>




<?php
$session_id=(int)$_GET['session_id'];
include_once "views/sql_include.php";
$MyData = new mysqli($host, $user, $pass, $database);
$MyData->query("SET NAMES 'utf8'");
$allsession = $MyData->query("SELECT * from `session` WHERE `id` = ".$session_id);
$allfilms = $MyData->query("SELECT `id`, `name` from `film`");

$row = $allsession->fetch_assoc();
$film_id=$row["film_id"];
$date = $row["date"];
$format = $row["format"];
$time = $row["time"];
$price = $row["price"];

if(isset($_POST["send"])){
        $film_id=htmlspecialchars ($_POST["name"]);
        $date = $_POST["date"];
        $format = $_POST["format"];
        $time = $_POST["time"];
        $price = $_POST["price"];

        $MyData->query("UPDATE `session` SET `film_id` = '$film_id', `date` = '$date', `format` = '$format',  `time` = '$time', `price` = '$price'  WHERE `id` = '$session_id'");
        echo "<script>location.assign('?action=session')</script>";
        // include_once "views/main.php";
        // include_once "layout/footer.php";
        // exit;

}
$MyData->close();
?>





<?php if(isset($_SESSION["MyID"])){ ?>
    <div style="margin-top:-50px;" class="site-section border-bottom">
        <div class="container">
            <div class="row ">
                <div class="col-md-12 col-lg-7 mb-5">
                    <form method="post" class="contact-form" role="form" enctype="multipart/form-data">
                        <div class="row form-group">
                            <div class="col-md-8 mb-3 mb-md-0">
                                <label class="font-weight-bold" for="film_name">Назва фільму:</label>
                                <select required class="form-control" size="0" name="name">
                                    <?php
                                    while(($row_films = $allfilms->fetch_assoc())!=false){
                                            if($row['film_id'] == $row_films['id']){
                                                echo "<option selected value='".$row_films['id']."'>".$row_films['name']."</option><br/>";
                                            } else {
                                                echo "<option value='".$row_films['id']."'>".$row_films['name']."</option><br/>";
                                            }
                                    }
                                    ?>
                                </select>
                            </div>

                        </div>

                        <div class="row form-group">
                            <div class="col-md-4">
                                <label class="font-weight-bold" for="date">Дата:</label>
                                <input required value="<?=$date?>" name="date" type="date" id="date" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label class="font-weight-bold" for="format">Формат:</label>
                                <select required class="form-control" size="0" name="format">
                                    <?php
                                    if($format == "2D"){
                                        echo "<option selected value='2D'>2D</option><br/>";
                                        echo "<option value='3D'>3D</option><br/>";
                                    } else {
                                        echo "<option value='2D'>2D</option><br/>";
                                        echo "<option selected value='3D'>3D</option><br/>";
                                    }
                                    ?>
                                </select>
                             </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-4">
                                <label class="font-weight-bold" for="time">Час:</label>
                                <input required value="<?=$time?>" name="time" type="time" id="time" class="form-control" placeholder="Час">
                            </div>
                            <div class="col-md-4">
                                <label class="font-weight-bold" for="price">Ціна:</label>
                                <input required value="<?=$price?>" name="price" type="number" id="price" class="form-control" placeholder="Ціна">
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-4">
                                <button type="submit" name="send" class="btn btn-primary py-3 px-4">Редагувати</button>
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
