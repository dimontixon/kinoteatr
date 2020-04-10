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


    <table class="table table-dark">
        <div  data-toggle="buttons">
            <form action="?action=place" method="post">
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

        if(isset($_POST["send"])){
            $allSelectedPlaces = "";
            $place = 1;
            for($i=0;$i<6;$i++){
                for($j=0;$j<9;$j++){
                    if(isset($_POST["place".$place])){
                        $allSelectedPlaces = $allSelectedPlaces." - ".$place.", ";
                    }
                    $place++;
                }
            }
            print($allSelectedPlaces);
        }

        ?>
        <button class="btn btn-primary py-3 px-4" type="submit" name="send">Зберегти</button>
        </form>
        </div>
    </table>
