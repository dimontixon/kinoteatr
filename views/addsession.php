<div class="site-blocks-cover overlay" style="background-image: url('images/hero_bg_2.jpg');" data-aos="fade" data-stellar-background-ratio="0.5" data-aos="fade">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-md-8 text-center" data-aos="fade-up" data-aos-delay="400">
                <h1 style="font-size:47px;" ="mb-4">Додавання сеансу</h1>
            </div>
        </div>
    </div>
</div>


<?php
include_once "views/sql_include.php";
$MyData = new mysqli($host, $user, $pass, $database);
$MyData->query("SET NAMES 'utf8'");
$allfilms = $MyData->query("SELECT `id`, `name` from `film` where `visible` = 1");
$wasError = false;

if(isset($_POST["send"])){
        if ($wasError == false){
        $film_id=htmlspecialchars ($_POST["name"]);
        $date = $_POST["date"];
        $format = $_POST["format"];
        $time = $_POST["time"];
        $price = $_POST["price"];

         $MyData->query("INSERT INTO `session` (`film_id`, `date`, `format`, `time`, `price`)
         VALUES ('$film_id', '$date', '$format', '$time', '$price')");
        echo "<script>location.assign('?action=session')</script>";
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
                    <form method="post" class="contact-form" role="form" enctype="multipart/form-data">
                        <div class="row form-group">
                            <div class="col-md-12 mb-3 mb-md-0">
                                <label class="font-weight-bold" for="film_name">Назва фільму:</label>
                                <select required class="form-control" size="0" name="name">
                                    <?php
                                    while(($row = $allfilms->fetch_assoc())!=false){
                                        echo "<option value='".$row['id']."'>".$row['name']."</option><br/>";
                                    }
                                    ?>
                                </select>
                            </div>

                        </div>

                        <div class="row form-group">
                            <div class="col-md-4">
                                <label class="font-weight-bold" for="date">Дата:</label>
                                <input required name="date" type="date" id="date" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label class="font-weight-bold" for="format">Формат:</label>
                                <select required class="form-control" size="0" name="format">
                                        <option value="2D">2D</option><br/>
                                        <option value="3D">3D</option><br/>
                                </select>
                             </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-4">
                                <label class="font-weight-bold" for="time">Час:</label>
                                <input required name="time" type="time" id="time" class="form-control" placeholder="Час">
                            </div>
                            <div class="col-md-4">
                                <label class="font-weight-bold" for="price">Ціна:</label>
                                <input required name="price" type="number" id="price" class="form-control" placeholder="Ціна">
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
