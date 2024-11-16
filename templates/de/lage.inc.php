<?
if($_REQUEST["consent"]) {
	$_SESSION["cookieconsent"] = "ok";
}
?>

<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- bootstrap grid css -->
    <link rel="stylesheet" href="<?=$GLOBAL["root"];?>assets/css/plugins/bootstrap-grid.css">
    <!-- swiper css -->
    <link rel="stylesheet" href="<?=$GLOBAL["root"];?>assets/css/plugins/swiper.min.css">
    <!-- datepicker css -->
    <link rel="stylesheet" href="<?=$GLOBAL["root"];?>assets/css/plugins/datepicker.css">
    <!-- Art Hotel css -->
    <link rel="stylesheet" href="<?=$GLOBAL["root"];?>assets/css/style.css">
    <!-- page name -->
    <title>Lage | Art Hotel Vienna</title>

    <link rel="shortcut icon" href="<?=$GLOBAL["root"];?>favicon.ico" type="image/x-icon">
    <link rel="icon" href="<?=$GLOBAL["root"];?>favicon.ico" type="image/x-icon">
</head>

<body>
    <!-- wrapper -->
    <div class="mil-wrapper">

        <?
        include("header.inc.php");
        ?>

        <!-- banner -->
        <div class="mil-banner-sm">
            <img src="<?=$GLOBAL["root"];?>assets/img/shapes/4.png" class="mil-shape" style="width: 70%; top: 0; right: -35%; transform: rotate(190deg)" alt="shape">
            <img src="<?=$GLOBAL["root"];?>assets/img/shapes/4.png" class="mil-shape" style="width: 70%; bottom: -12%; left: -30%; transform: rotate(40deg)" alt="shape">
            <img src="<?=$GLOBAL["root"];?>assets/img/shapes/4.png" class="mil-shape" style="width: 110%; top: -5%; left: -30%; opacity: .3" alt="shape">
            <div class="container">

                <div class="row align-items-center justify-content-center">
                    <div class="col-xl-6">

                        <div class="mil-banner-content-frame">
                            <div class="mil-banner-content mil-text-center">
                                <h1 class="mil-mb-40">Hier finden Sie uns</h1>
                                <div class="mil-suptitle mil-breadcrumbs">
                                    <ul>
                                        <li><a href="<?=$GLOBAL["linkroot"];?>">Start</a></li>
                                        <li><a href="#">Lage</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
        <!-- banner end -->
		
        <!-- map -->
        <div class="mil-p-0-100">
            <div class="container">
                
				
				<?
				if($_SESSION["cookieconsent"] != "ok") {
					?>
					<div style="max-width:700px;background:white;padding:40px 20px;margin:auto;text-align:center;">
					<i>Um den Lageplan anzuzeigen nutzen wir Google Maps. Dabei werden Drittanbietercookies von Google und Matomo gesetzt. </i>
					<br><br>
					<a href="?consent=true" style="color:black;text-decoration:none;margin:20px;">
						<span style="background:transparent;border:black solid 1px;padding:10px;color:black;text-decoration:none;">&raquo; Einverstanden, Karte laden</span>
					</a>
					</div>
					<?
				}else{
					?>
					<div class="mil-map-frame mil-fade-up">
						<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d6512.266932352884!2d16.352414144102408!3d48.18497361966317!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x476da82f0ab20579%3A0xaba768b897e4a53!2sThe%20Art%20Hotel%20Vienna!5e0!3m2!1sde!2sat!4v1714492351799!5m2!1sde!2sat" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
					</div>
					<?
				}
				?>
				
            </div>
        </div>
        <!-- map end -->

        


        <?
        include("footer.inc.php");
        ?>

        <div class="mil-progressbar"></div>


    </div>
    <!-- wrapper end -->

    <!-- jQuery js -->
    <script src="<?=$GLOBAL["root"];?>assets/js/plugins/jquery.min.js"></script>
    <!-- smooth scroll js -->
    <script src="<?=$GLOBAL["root"];?>assets/js/plugins/smooth-scroll.js"></script>
    <!-- swiper js -->
    <script src="<?=$GLOBAL["root"];?>assets/js/plugins/swiper.min.js"></script>
    <!-- datepicker js -->
    <script src="<?=$GLOBAL["root"];?>assets/js/plugins/datepicker.js"></script>
    <!-- Art Hotel js -->
    <script src="<?=$GLOBAL["root"];?>assets/js/main.js"></script>
</body>

</html>
