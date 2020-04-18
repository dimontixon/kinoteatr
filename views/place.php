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
$s_id = 0;
$s_id=(int)$_GET['s_id'];
include_once "views/sql_include.php";
$MyData = new mysqli($host, $user, $pass, $database);
$MyData->query("SET NAMES 'utf8'");
$allplaces = $MyData->query("SELECT `places` from `session` WHERE `id` = ".$s_id);

$row = $allplaces->fetch_assoc();
$places = $row["places"];

if(isset($_POST["send"])){
        $allSelectedPlaces = "";
        $place = 1;
        for($i=0;$i<6;$i++){
            for($j=0;$j<9;$j++){
                if(isset($_POST["place".$place])){
                    $allSelectedPlaces = $allSelectedPlaces." ".$place." ";
                }
                $place++;
            }
        }
        print($allSelectedPlaces);

        $MyData->query("UPDATE `session` SET `places` = '$allSelectedPlaces' WHERE `id` = '$s_id'");
        //echo "<script>location.assign('?action=session')</script>";
        // include_once "views/main.php";
        // include_once "layout/footer.php";
        // exit;
}
$MyData->close();
?>

<?php if(isset($_SESSION["MyID"])){ ?>
    <table class="table">
            <form action="?action=place" method="post">
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
                    echo "<input name='place".$place."' value='".$place."' type='checkbox' autocomplete='off'>".$place;
                echo "</label></td>";
                $place++;
            }
            echo "<br></tr>";
        }
/*
        if(isset($_POST["send"])){
            $allSelectedPlaces = "";
            $place = 1;
            for($i=0;$i<6;$i++){
                for($j=0;$j<9;$j++){
                    if(isset($_POST["place".$place])){
                        $allSelectedPlaces = $allSelectedPlaces." ".$place." ";
                    }
                    $place++;
                }
            }
            print($allSelectedPlaces);
        }*/

        ?>
        <button class="btn btn-primary py-3 px-4" type="submit" name="send">Зберегти</button>
    </div>
        </form>
    </table>


<?php } ?>
