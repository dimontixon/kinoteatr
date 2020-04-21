<div class="site-blocks-cover overlay" style="background-image: url('images/hero_bg_2.jpg');" data-aos="fade" data-stellar-background-ratio="0.5" data-aos="fade">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-md-8 text-center" data-aos="fade-up" data-aos-delay="400">
                <h1 style="font-size:47px;" ="mb-4">Мапа місць залу</h1>
            </div>
        </div>
    </div>
</div>


<?php
$s_id=(int)$_GET['session_id'];
include_once "views/sql_include.php";
$MyData = new mysqli($host, $user, $pass, $database);
$MyData->query("SET NAMES 'utf8'");
$allplaces = $MyData->query("SELECT `date`, `format`, `time`, `price`, `places` from `session` WHERE `id` = ".$s_id);
$filmName = $MyData->query("SELECT `name` from `film`, `session` WHERE `film`.`id` = `session`.`film_id` AND `session`.`id` = ".$s_id);

$rowFilmName = $filmName->fetch_row();
$row = $allplaces->fetch_assoc();
$places = $row["places"];
//print($places);
echo "<p style='font-size:30px;'>Вибір місць для сеансу:</p><pre style='font-size:25px;'>Фільм - <b>".$rowFilmName[0]."</b>,    Дата - <b>".$row['date']."</b>,    Час - <b>".$row['time']."</b>,     Формат - <b>".$row['format']."</b>,     Ціна - <b>".$row['price']."грн.</b></pre>";
$arrayPlaces = explode(" ", $places);

if(isset($_POST["send"])){
        $allSelectedPlaces = "";
        $place = 1;
        for($i=0;$i<6;$i++){
            for($j=0;$j<9;$j++){
                if(isset($_POST["place".$place])){
                    $allSelectedPlaces = $allSelectedPlaces."".$place." ";
                }
                $place++;
            }
        }
        //print($allSelectedPlaces);

        $MyData->query("UPDATE `session` SET `places` = '$allSelectedPlaces' WHERE `id` = '$s_id'");
        echo "<script>location.assign('?action=place&session_id=$s_id')</script>";
        // include_once "views/main.php";
        // include_once "layout/footer.php";
        // exit;
}
$MyData->close();
?>

<?php if(isset($_SESSION["MyID"])){ ?>
    <table class="table">
            <form method="post">
                <div class="btn-group-toggle" data-toggle="buttons">
                    <tr>
                        <td></td><td></td><td></td><td></td>
                        <td style="font-size:30px;"><strong>Екран</strong></td>
                        <td></td><td></td><td></td><td></td>
                    </tr>
        <?php
        $place = 1;

        for($i=0;$i<6;$i++){
            echo "<tr>";
            for($j=0;$j<9;$j++){
                echo "<td><label class='btn btn-secondary active'>";
                $k = 0;
                    foreach ($arrayPlaces as $p) {
                        if($place == $p){
                            echo "<input checked name='place".$place."' value='".$place."' type='checkbox' autocomplete='off'>".$place;
                            $k = 0;
                            break;
                        } else{
                            $k=1;
                        }
                    }
                    if($k == 1){
                         echo "<input name='place".$place."' value='".$place."' type='checkbox' autocomplete='off'>".$place;
                    }
                echo "</label></td>";
                $place++;
            }
            echo "<br></tr>";
        }

        ?>
        <button style="margin-top:-200px;" class="btn btn-primary py-3 px-4" type="submit" name="send">Зберегти</button>
    </div>
        </form>
    </table>


<?php } ?>
