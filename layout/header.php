<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Кінотеатр &mdash; "Чаплін"</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito+Sans:200,300,400,700,900|Oswald:400,700">
    <link rel="stylesheet" href="fonts/icomoon/style.css">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/jquery-ui.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="css/mediaelementplayer.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="fonts/flaticon/font/flaticon.css">
    <link rel="stylesheet" href="css/fl-bigmug-line.css">


    <link rel="stylesheet" href="css/aos.css">

    <link rel="stylesheet" href="css/style.css">

  </head>
  <body>




  <div class="site-wrap">

    <div  class="site-navbar mt-4">
        <div class="container py-1">
          <div class="row align-items-center">
            <div class="col-8 col-md-8 col-lg-4">
              <h1 class="mb-0"><a href="index.php" class="text-white h2 mb-0"><strong>Кінотеатр "Чаплін"</strong></a></h1>
            </div>
            <div class="col-4 col-md-4 col-lg-8">
              <nav class="site-navigation text-right text-md-right" role="navigation">

                <div class="d-inline-block d-lg-none ml-md-0 mr-auto py-3"><a href="#" class="site-menu-toggle js-menu-toggle text-white"><span class="icon-menu h3"></span></a></div>

                <ul style="font-size:22px;" class="site-menu js-clone-nav d-none d-lg-block">
                  <li class="active"><a href="?action=session">Сеанси</a></li>
                  <li class="active"><a href="?action=films">Фільми</a></li>
                  <li class="active"><a href="#contact">Контакти</a></li>
                  <?php
                  if(isset($_SESSION["MyID"])){
                      // echo "<li><a href='?action=createRecipe'>Додати фільм</a></li>";
                      // echo "<li><a href='?action=myRecipe'>Додати сеанс</a></li>";
                      // echo "<li><a href='?action=myFavorite'>Улюблені</a></li>";
                      // echo "<li><a href='?action=myAccount'>Профіль</a></li>";
                      echo "<li class='active'><a href='?action=sessionEnd'>Вийти</a></li>";
                  }
                  ?>
                </ul>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </div>



        <div class="site-mobile-menu">
          <div class="site-mobile-menu-header">
            <div class="site-mobile-menu-close mt-3">
              <span class="icon-close2 js-menu-toggle"></span>
            </div>
          </div>
          <div class="site-mobile-menu-body"></div>
        </div> <!-- .site-mobile-menu -->
