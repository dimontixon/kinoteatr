<div class="bg-primary" data-aos="fade">
    <div class="container">
        <div class="row">
            <a href="#" class="col-2 text-center py-4 social-icon d-block"><span class=" text-white"></span></a>
            <a href="#" class="col-2 text-center py-4 social-icon d-block"><span class=" text-white"></span></a>
            <a target="_blank" href="https://www.facebook.com/people/%D0%A7%D0%B0%D0%BF%D0%BB%D1%96%D0%BD-%D0%94%D0%BE%D0%BB%D0%B8%D0%BD%D0%B0/100018903855555" class="col-2 text-center py-4 social-icon d-block"><span class="icon-facebook text-white"></span></a>
            <a target="_blank" href="https://www.instagram.com/kinoteatrchaplin9996/?hl=uk" class="col-2 text-center py-4 social-icon d-block"><span class="icon-instagram text-white"></span></a>
        </div>
    </div>
</div>

<footer id="contact" class="site-footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-5">
                <div class="mb-5">
                    <h3 class="footer-heading mb-4">Про кінотеатр "Чаплін"</h3>
                    <p>Міський кінотеатр знаходиться за адресою
                        вул. Грушевського, 7, м. Долина, Івано-Франківська обл., 77500.
                        Відкритий у 2014 році. У кінозалі є 54 комфортні місця для перегляду фільмів. Також при кінотеатрі
                        є кілька столиків та можливість
                        придбати напої та різні снеки до фільму.</p>
                    </div>
                    <div class="mb-5">
                        <div class="col-lg-6">
                            <div class="mb-5">
                                <h3 class="footer-heading mb-4">Телефончик</h3>
                                <p>Телефон для бронювання квитків <strong>0953269996</strong> (10:00-22:00)</p>
                            </div>
                        </div>
                    </div>
                    <?php
                        if(!isset($_SESSION["MyID"])){
                    ?>
                            <div class="mb-5">
                                <div class="col-lg-6">
                                    <div class="mb-5">

                                                <p>Ви адміністратор?
                                                <a class="btn btn-primary py-3 px-4" href='?action=admin_login'>Увійти</a>
                                                </p>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }
                    ?>

</div>
<div class="col-lg-7 mb-2 mb-lg-0">
    <div class="mb-5">
        <h3 class="footer-heading mb-4">Нас легко знайти</h3>
        <div class="block-16">
            <figure>
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d755.9573630950568!2d23.97694362652029!3d48.97613599642037!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x473a0f5505315c49%3A0x374636ee36ec59ce!2z0JrRltC90L7RgtC10LDRgtGAINCn0LDQv9C70ZbQvQ!5e0!3m2!1sru!2sua!4v1583791182807!5m2!1sru!2sua" width="600" height="450" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
            </figure>
        </div>
    </div>
</div>
</div>
</footer>
</div>

<script src="js/jquery-3.3.1.min.js"></script>
<script src="js/jquery-migrate-3.0.1.min.js"></script>
<script src="js/jquery-ui.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/owl.carousel.min.js"></script>
<script src="js/mediaelement-and-player.min.js"></script>
<script src="js/jquery.stellar.min.js"></script>
<script src="js/jquery.countdown.min.js"></script>
<script src="js/jquery.magnific-popup.min.js"></script>
<script src="js/bootstrap-datepicker.min.js"></script>
<script src="js/aos.js"></script>
<script src="js/circleaudioplayer.js"></script>

<script src="js/main.js"></script>

</body>
</html>
