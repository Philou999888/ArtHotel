<?
go_v("https://arthotelmwhome.kross.travel/book/step1?guests=".$_REQUEST["adults"]."&from=".$_REQUEST["from"]."&to=".$_REQUEST["to"], 1);
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
    <title>The Art Hotel Vienna</title>

    <link rel="shortcut icon" href="<?=$GLOBAL["root"];?>favicon.ico" type="image/x-icon">
    <link rel="icon" href="<?=$GLOBAL["root"];?>favicon.ico" type="image/x-icon">

</head>

<body>
    <!-- wrapper -->
    <div class="mil-wrapper">

	    <!-- preloader -->
	    <div class="mil-loader mil-active">
	        <div class="mil-loader-content">
	            <div class="mil-loader-logo">
	                <img src="<?=$GLOBAL["root"];?>assets/img/logo.png" alt="Logo">
	            </div>
	            <div class="mil-loader-progress">
	                <div class="mil-loader-bar"></div>
	            </div>
	        </div>
	    </div>    
	    <!-- preloader end -->


	    <div class="mil-progressbar"></div>
	</div>

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
