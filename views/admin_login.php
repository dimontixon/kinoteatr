<?php
$errorMsg="";
if(isset($_POST["send"]) ){
	$error=false;
	$loginFlag=false;
	$passwordFlag=false;
	$login=htmlspecialchars ($_POST["login"]);
	$password=htmlspecialchars ($_POST["password"]);
	$MyID;
	// $MyAdm;

	include_once "views/sql_include.php";
	$MyData = new mysqli($host, $user, $pass, $database);
	$MyData->query("SET NAMES 'utf8'");
	$resultLogin = $MyData->query("SELECT * FROM `user` WHERE `login` = '$login'");
	if($resultLogin->num_rows == 0)
	{
		//echo "Такого логіна чи E-mail адреси не зареєстровано!";
		$errorMsg="Такого логіна не існує!";
		//include_once 'layout/footer.php';
		//exit;
	} else {
		$row;
		if($resultLogin->num_rows > 0){
			$row = $resultLogin->fetch_assoc();
		}
		$loginFlag=true;
		$MyID=$row["id"];
		if($password == $row['password']){
			$passwordFlag = true;
		}

	}

	if($passwordFlag==false||$loginFlag==false){
		$error=true;
		$errorMsg="Неправильний логін або пароль!";
	}
	$MyData->close();

	if($error==false){
		$_SESSION["MyLogin"]=$login;
		$_SESSION["MyID"]=$MyID;
		// $_SESSION["MyAdm"]=$MyAdm;
		echo "<script>location.assign('index.php')</script>";
		//exit;
	}
}
?>

<div class="site-blocks-cover overlay" style="margin-top: -30px;background-image: url('images/hero_bg_2.jpg');" data-aos="fade" data-stellar-background-ratio="0.5" data-aos="fade">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-md-8 text-center" data-aos="fade-up" data-aos-delay="400">
                <h1 style="font-size:47px;" ="mb-4">Адмін-панель</h1>
                <p class="mb-5">Вхід тільки для адміністратора</p>
            </div>
        </div>
    </div>
</div>

<?php if(!isset($_SESSION["MyID"])){ ?>
<div class="site-section border-bottom">
<div class="container">
  <div class="row align-items-center justify-content-center">
    <div class="col-md-12 col-lg-7 mb-5">
      <form method="post" class="contact-form">
          <div style="color:red;" class="help-block with-errors"><?=$errorMsg?></div>
        <div class="row form-group">
          <div class="col-md-12 mb-3 mb-md-0">
            <label class="font-weight-bold" for="login">Логін:</label>
            <input name="login" type="text" id="login" class="form-control" placeholder="Логін">
          </div>
        </div>

        <div class="row form-group">
          <div class="col-md-12">
            <label class="font-weight-bold" for="password">Пароль:</label>
            <input name="password" type="password" id="password" class="form-control" placeholder="Пароль">
          </div>
        </div>

        <div class="row form-group">
          <div class="col-md-12">
            <!-- <input type="submit" value="Увійти" name="send" class="btn btn-primary py-3 px-4"> -->
            <button type="submit" name="send" class="btn btn-primary py-3 px-4">Увійти</button>
          </div>
        </div>

      </form>
    </div>
  </div>
</div>
</div>
<?php } ?>
