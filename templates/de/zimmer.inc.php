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
    <title>Zimmer & Preise | Art Hotel Vienna</title>

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
                                <h1 class="mil-mb-40">Unsere Zimmer</h1>
                                <div class="mil-suptitle mil-breadcrumbs">
                                    <ul>
                                        <li><a href="<?=$GLOBAL["linkroot"];?>">Start</a></li>
                                        <li><a href="#">Zimmer & Preise</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
        <!-- banner end -->


        <!-- rooms -->
        <div class="mil-rooms mil-p-100-20">
            <img src="<?=$GLOBAL["root"];?>assets/img/shapes/4.png" class="mil-shape mil-fade-up" style="width: 110%; bottom: 15%; left: -30%; opacity: .2" alt="shape">
            <img src="<?=$GLOBAL["root"];?>assets/img/shapes/4.png" class="mil-shape mil-fade-up" style="width: 85%; bottom: -20%; right: -25%; transform: rotate(-30deg) scaleX(-1);" alt="shape">
            <div class="container">


                <div class="row mil-mb-40">
                    <div class="col-md-6 col-xl-4">

                        <div class="mil-card mil-mb-40-adapt mil-fade-up">
                            <div class="swiper-container mil-card-slider">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <div class="mil-card-cover">
                                            <img src="<?=$GLOBAL["root"];?>assets/img/zimmer/einzel_1.jpg" alt="cover" data-swiper-parallax="-100" data-swiper-parallax-scale="1.1">
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="mil-card-cover">
                                            <img src="<?=$GLOBAL["root"];?>assets/img/zimmer/einzel_2.jpg" alt="cover" data-swiper-parallax="-100" data-swiper-parallax-scale="1.1">
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="mil-card-cover">
                                            <img src="<?=$GLOBAL["root"];?>assets/img/zimmer/einzel_3.jpg" alt="cover" data-swiper-parallax="-100" data-swiper-parallax-scale="1.1">
                                        </div>
                                    </div>
                                </div>
                                <div class="mil-card-nav">
                                    <div class="mil-slider-btn mil-card-prev">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right">
                                            <line x1="5" y1="12" x2="19" y2="12"></line>
                                            <polyline points="12 5 19 12 12 19"></polyline>
                                        </svg>
                                    </div>
                                    <div class="mil-slider-btn mil-card-next">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right">
                                            <line x1="5" y1="12" x2="19" y2="12"></line>
                                            <polyline points="12 5 19 12 12 19"></polyline>
                                        </svg>
                                    </div>
                                </div>
                                <div class="mil-card-pagination"></div>
                            </div>
                            <ul class="mil-parameters">
                                <li>
                                    <div class="mil-icon">
                                        <svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g>
                                                <path d="M12.7432 5.75582C12.6516 7.02721 11.7084 8.00663 10.6799 8.00663C9.65144 8.00663 8.70673 7.02752 8.6167 5.75582C8.52291 4.43315 9.44106 3.505 10.6799 3.505C11.9188 3.505 12.837 4.45722 12.7432 5.75582Z" stroke="black" stroke-width="1.00189" stroke-linecap="round" stroke-linejoin="round" />
                                                <path d="M10.6793 10.0067C8.64232 10.0067 6.68345 11.0185 6.19272 12.9889C6.12771 13.2496 6.29118 13.5075 6.55905 13.5075H14.7999C15.0678 13.5075 15.2303 13.2496 15.1662 12.9889C14.6755 10.9869 12.7166 10.0067 10.6793 10.0067Z" stroke="black" stroke-width="1.00189" stroke-miterlimit="10" />
                                                <path d="M6.42937 6.31713C6.3562 7.33276 5.59385 8.13264 4.77209 8.13264C3.95033 8.13264 3.18672 7.33308 3.1148 6.31713C3.04007 5.26053 3.7821 4.50537 4.77209 4.50537C5.76208 4.50537 6.50411 5.27992 6.42937 6.31713Z" stroke="black" stroke-width="1.00189" stroke-linecap="round" stroke-linejoin="round" />
                                                <path d="M6.61604 10.0688C6.05177 9.81023 5.4303 9.71082 4.77162 9.71082C3.14604 9.71082 1.57985 10.5189 1.18752 12.0929C1.13594 12.3011 1.26661 12.5071 1.48043 12.5071H4.99045" stroke="black" stroke-width="1.00189" stroke-miterlimit="10" stroke-linecap="round" />
                                            </g>
                                            <defs>
                                                <clipPath>
                                                    <rect width="16.0035" height="16.0035" fill="white" transform="translate(0.176514 0.504028)" />
                                                </clipPath>
                                            </defs>
                                        </svg>
                                    </div>
                                    <div>Max. 1 Person</div>
                                </li>
                                <li>
                                    <div class="mil-icon">
                                        <svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M10.9578 14.6084H12.7089C13.1733 14.6084 13.6187 14.4239 13.9471 14.0955C14.2755 13.7671 14.46 13.3217 14.46 12.8573V11.1062" stroke="black" stroke-width="1.00189" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M14.46 6.10644V4.35534C14.46 3.89092 14.2755 3.44553 13.9471 3.11713C13.6187 2.78874 13.1733 2.60425 12.7089 2.60425H10.9578" stroke="black" stroke-width="1.00189" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M5.95898 14.6084H4.20788C3.74346 14.6084 3.29806 14.4239 2.96967 14.0955C2.64128 13.7671 2.45679 13.3217 2.45679 12.8573V11.1062" stroke="black" stroke-width="1.00189" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M2.45679 6.10644V4.35534C2.45679 3.89092 2.64128 3.44553 2.96967 3.11713C3.29806 2.78874 3.74346 2.60425 4.20788 2.60425H5.95898" stroke="black" stroke-width="1.00189" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </div>
                                    <div>Größe: Ca. 15m²</div>
                                </li>
                            </ul>
                            <div class="mil-descr">
                                <h3 class="mil-mb-20">Einzelzimmer</h3>
                                <p class="mil-mb-40">Die günstige und komfortable Option für Alleine-Reisende. Frühstück inklusive.</p>
                                <div class="mil-divider"></div>
                                <div class="mil-card-bottom">
                                    <div class="mil-price"><span class="mil-symbol">Ab €</span><span class="mil-number">49</span>/Nacht</div>
                                    <a href="#." class="mil-link mil-open-book-popup">
                                        <span>Preis prüfen</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right">
                                            <line x1="5" y1="12" x2="19" y2="12"></line>
                                            <polyline points="12 5 19 12 12 19"></polyline>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-6 col-xl-4">

                        <div class="mil-card mil-mb-40-adapt mil-fade-up">
                            <div class="swiper-container mil-card-slider">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <div class="mil-card-cover">
                                            <img src="<?=$GLOBAL["root"];?>assets/img/zimmer/doppel_1.jpg" alt="cover" data-swiper-parallax="-100" data-swiper-parallax-scale="1.1">
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="mil-card-cover">
                                            <img src="<?=$GLOBAL["root"];?>assets/img/zimmer/doppel_2.jpg" alt="cover" data-swiper-parallax="-100" data-swiper-parallax-scale="1.1">
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="mil-card-cover">
                                            <img src="<?=$GLOBAL["root"];?>assets/img/zimmer/doppel_3.jpg" alt="cover" data-swiper-parallax="-100" data-swiper-parallax-scale="1.1">
                                        </div>
                                    </div>
                                </div>
                                <div class="mil-card-nav">
                                    <div class="mil-slider-btn mil-card-prev">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right">
                                            <line x1="5" y1="12" x2="19" y2="12"></line>
                                            <polyline points="12 5 19 12 12 19"></polyline>
                                        </svg>
                                    </div>
                                    <div class="mil-slider-btn mil-card-next">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right">
                                            <line x1="5" y1="12" x2="19" y2="12"></line>
                                            <polyline points="12 5 19 12 12 19"></polyline>
                                        </svg>
                                    </div>
                                </div>
                                <div class="mil-card-pagination"></div>
                            </div>
                            <ul class="mil-parameters">
                                <li>
                                    <div class="mil-icon">
                                        <svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g>
                                                <path d="M12.7432 5.75582C12.6516 7.02721 11.7084 8.00663 10.6799 8.00663C9.65144 8.00663 8.70673 7.02752 8.6167 5.75582C8.52291 4.43315 9.44106 3.505 10.6799 3.505C11.9188 3.505 12.837 4.45722 12.7432 5.75582Z" stroke="black" stroke-width="1.00189" stroke-linecap="round" stroke-linejoin="round" />
                                                <path d="M10.6793 10.0067C8.64232 10.0067 6.68345 11.0185 6.19272 12.9889C6.12771 13.2496 6.29118 13.5075 6.55905 13.5075H14.7999C15.0678 13.5075 15.2303 13.2496 15.1662 12.9889C14.6755 10.9869 12.7166 10.0067 10.6793 10.0067Z" stroke="black" stroke-width="1.00189" stroke-miterlimit="10" />
                                                <path d="M6.42937 6.31713C6.3562 7.33276 5.59385 8.13264 4.77209 8.13264C3.95033 8.13264 3.18672 7.33308 3.1148 6.31713C3.04007 5.26053 3.7821 4.50537 4.77209 4.50537C5.76208 4.50537 6.50411 5.27992 6.42937 6.31713Z" stroke="black" stroke-width="1.00189" stroke-linecap="round" stroke-linejoin="round" />
                                                <path d="M6.61604 10.0688C6.05177 9.81023 5.4303 9.71082 4.77162 9.71082C3.14604 9.71082 1.57985 10.5189 1.18752 12.0929C1.13594 12.3011 1.26661 12.5071 1.48043 12.5071H4.99045" stroke="black" stroke-width="1.00189" stroke-miterlimit="10" stroke-linecap="round" />
                                            </g>
                                            <defs>
                                                <clipPath>
                                                    <rect width="16.0035" height="16.0035" fill="white" transform="translate(0.176514 0.504028)" />
                                                </clipPath>
                                            </defs>
                                        </svg>
                                    </div>
                                    <div>Max. 2 Personen</div>
                                </li>
                                <li>
                                    <div class="mil-icon">
                                        <svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M10.9578 14.6084H12.7089C13.1733 14.6084 13.6187 14.4239 13.9471 14.0955C14.2755 13.7671 14.46 13.3217 14.46 12.8573V11.1062" stroke="black" stroke-width="1.00189" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M14.46 6.10644V4.35534C14.46 3.89092 14.2755 3.44553 13.9471 3.11713C13.6187 2.78874 13.1733 2.60425 12.7089 2.60425H10.9578" stroke="black" stroke-width="1.00189" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M5.95898 14.6084H4.20788C3.74346 14.6084 3.29806 14.4239 2.96967 14.0955C2.64128 13.7671 2.45679 13.3217 2.45679 12.8573V11.1062" stroke="black" stroke-width="1.00189" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M2.45679 6.10644V4.35534C2.45679 3.89092 2.64128 3.44553 2.96967 3.11713C3.29806 2.78874 3.74346 2.60425 4.20788 2.60425H5.95898" stroke="black" stroke-width="1.00189" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </div>
                                    <div>Größe: Ca. 25m²</div>
                                </li>
                            </ul>
                            <div class="mil-descr">
                                <h3 class="mil-mb-20">Doppelzimmer</h3>
                                <p class="mil-mb-40">Die gehobene Economy Klasse für Städtetrips zu zweit. Frühstück inklusive.</p>
                                <div class="mil-divider"></div>
                                <div class="mil-card-bottom">
                                    <div class="mil-price"><span class="mil-symbol">Ab €</span><span class="mil-number">69</span>/Nacht</div>
                                    <a href="#." class="mil-link mil-open-book-popup">
                                        <span>Preis prüfen</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right">
                                            <line x1="5" y1="12" x2="19" y2="12"></line>
                                            <polyline points="12 5 19 12 12 19"></polyline>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-6 col-xl-4">

                        <div class="mil-card mil-mb-40-adapt mil-fade-up">
                            <div class="swiper-container mil-card-slider">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <div class="mil-card-cover">
                                            <img src="<?=$GLOBAL["root"];?>assets/img/zimmer/supreme_1.jpg" alt="cover" data-swiper-parallax="-100" data-swiper-parallax-scale="1.1">
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="mil-card-cover">
                                            <img src="<?=$GLOBAL["root"];?>assets/img/zimmer/supreme_2.jpg" alt="cover" data-swiper-parallax="-100" data-swiper-parallax-scale="1.1">
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="mil-card-cover">
                                            <img src="<?=$GLOBAL["root"];?>assets/img/zimmer/supreme_3.jpg" alt="cover" data-swiper-parallax="-100" data-swiper-parallax-scale="1.1">
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="mil-card-cover">
                                            <img src="<?=$GLOBAL["root"];?>assets/img/zimmer/supreme_4.jpg" alt="cover" data-swiper-parallax="-100" data-swiper-parallax-scale="1.1">
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="mil-card-cover">
                                            <img src="<?=$GLOBAL["root"];?>assets/img/zimmer/supreme_5.jpg" alt="cover" data-swiper-parallax="-100" data-swiper-parallax-scale="1.1">
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="mil-card-cover">
                                            <img src="<?=$GLOBAL["root"];?>assets/img/zimmer/supreme_6.jpg" alt="cover" data-swiper-parallax="-100" data-swiper-parallax-scale="1.1">
                                        </div>
                                    </div>
                                </div>
                                <div class="mil-card-nav">
                                    <div class="mil-slider-btn mil-card-prev">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right">
                                            <line x1="5" y1="12" x2="19" y2="12"></line>
                                            <polyline points="12 5 19 12 12 19"></polyline>
                                        </svg>
                                    </div>
                                    <div class="mil-slider-btn mil-card-next">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right">
                                            <line x1="5" y1="12" x2="19" y2="12"></line>
                                            <polyline points="12 5 19 12 12 19"></polyline>
                                        </svg>
                                    </div>
                                </div>
                                <div class="mil-card-pagination"></div>
                            </div>
                            <ul class="mil-parameters">
                                <li>
                                    <div class="mil-icon">
                                        <svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g>
                                                <path d="M12.7432 5.75582C12.6516 7.02721 11.7084 8.00663 10.6799 8.00663C9.65144 8.00663 8.70673 7.02752 8.6167 5.75582C8.52291 4.43315 9.44106 3.505 10.6799 3.505C11.9188 3.505 12.837 4.45722 12.7432 5.75582Z" stroke="black" stroke-width="1.00189" stroke-linecap="round" stroke-linejoin="round" />
                                                <path d="M10.6793 10.0067C8.64232 10.0067 6.68345 11.0185 6.19272 12.9889C6.12771 13.2496 6.29118 13.5075 6.55905 13.5075H14.7999C15.0678 13.5075 15.2303 13.2496 15.1662 12.9889C14.6755 10.9869 12.7166 10.0067 10.6793 10.0067Z" stroke="black" stroke-width="1.00189" stroke-miterlimit="10" />
                                                <path d="M6.42937 6.31713C6.3562 7.33276 5.59385 8.13264 4.77209 8.13264C3.95033 8.13264 3.18672 7.33308 3.1148 6.31713C3.04007 5.26053 3.7821 4.50537 4.77209 4.50537C5.76208 4.50537 6.50411 5.27992 6.42937 6.31713Z" stroke="black" stroke-width="1.00189" stroke-linecap="round" stroke-linejoin="round" />
                                                <path d="M6.61604 10.0688C6.05177 9.81023 5.4303 9.71082 4.77162 9.71082C3.14604 9.71082 1.57985 10.5189 1.18752 12.0929C1.13594 12.3011 1.26661 12.5071 1.48043 12.5071H4.99045" stroke="black" stroke-width="1.00189" stroke-miterlimit="10" stroke-linecap="round" />
                                            </g>
                                            <defs>
                                                <clipPath>
                                                    <rect width="16.0035" height="16.0035" fill="white" transform="translate(0.176514 0.504028)" />
                                                </clipPath>
                                            </defs>
                                        </svg>
                                    </div>
                                    <div>Max. 3 Personen</div>
                                </li>
                                <li>
                                    <div class="mil-icon">
                                        <svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M10.9578 14.6084H12.7089C13.1733 14.6084 13.6187 14.4239 13.9471 14.0955C14.2755 13.7671 14.46 13.3217 14.46 12.8573V11.1062" stroke="black" stroke-width="1.00189" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M14.46 6.10644V4.35534C14.46 3.89092 14.2755 3.44553 13.9471 3.11713C13.6187 2.78874 13.1733 2.60425 12.7089 2.60425H10.9578" stroke="black" stroke-width="1.00189" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M5.95898 14.6084H4.20788C3.74346 14.6084 3.29806 14.4239 2.96967 14.0955C2.64128 13.7671 2.45679 13.3217 2.45679 12.8573V11.1062" stroke="black" stroke-width="1.00189" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M2.45679 6.10644V4.35534C2.45679 3.89092 2.64128 3.44553 2.96967 3.11713C3.29806 2.78874 3.74346 2.60425 4.20788 2.60425H5.95898" stroke="black" stroke-width="1.00189" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </div>
                                    <div>Größe: Ca. 35m²</div>
                                </li>
                            </ul>
                            <div class="mil-descr">
                                <h3 class="mil-mb-20">Doppelzimmer Supreme</h3>
                                <p class="mil-mb-40">Mehr Platz, die beste Aussicht und ein ausziehbares Sofa. Frühstück inklusive.</p>
                                <div class="mil-divider"></div>
                                <div class="mil-card-bottom">
                                    <div class="mil-price"><span class="mil-symbol">Ab €</span><span class="mil-number">89</span>/Nacht</div>
                                    <a href="#." class="mil-link mil-open-book-popup">
                                        <span>Preis prüfen</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right">
                                            <line x1="5" y1="12" x2="19" y2="12"></line>
                                            <polyline points="12 5 19 12 12 19"></polyline>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
        <!-- rooms end -->

        <!-- call to action -->
        <div class="mil-content-pad mil-p-100-100 mil-fade-up">
            <div class="container">
                <div class="mil-text-center">
                    <div class="mil-suptitle mil-mb-20 mil-fade-up">Haben Sie Fragen?</div>
                    <p><b>Wir sind gerne für Sie da:</b></p>
                    <h2 class="mil-h2-lg mil-mb-40 mil-fade-up">
                    +43 670 20 20 541</h2>
                </div>
            </div>
        </div>
        <!-- call to action end -->

        <!-- about 1 -->
        <div class="mil-about mil-p-100-0">
            <img src="<?=$GLOBAL["root"];?>assets/img/shapes/4.png" class="mil-shape" style="width: 180%; bottom: -100%; left: -20%; opacity: .2" alt="shape">
            <div class="container">
                <div class="row justify-content-between align-items-center">
                    <div class="col-xl-5 mil-mb-100">

                        <div class="mil-text-frame">
                            <div class="mil-suptitle mil-mb-20 mil-fade-up">Drei gute Gründe</div>
                            <h2 class="mil-mb-60 mil-fade-up">Warum unsere Gäste immer wieder kommen</h2>
                            <ul class="mil-about-list">
                                <li class="mil-fade-up">
                                    <div class="mil-item-head">
                                        <span>01.</span>
                                        <h4>Einzigartiges Kunst-Erlebnis</h4>
                                    </div>
                                    <p>Erleben Sie ein einzigartiges Kunst-Erlebnis in Wien. Im Art Hotel Vienna vereinen sich Gastfreundschaft und Kunst zu einem inspirierenden Gesamtkonzept. Unsere individuell gestalteten Zimmer sind mehr als nur eine Unterkunft – sie bieten ein unvergleichliches Ambiente, das Sie lange in Erinnerung behalten werden.
</p>
                                </li>
                                <li class="mil-fade-up">
                                    <div class="mil-item-head">
                                        <span>02.</span>
                                        <h4>Perfekte Lage</h4>
                                    </div>
                                    <p>Unsere Lage ermöglicht es Ihnen, die Stadt mühelos zu erkunden. Sehenswürdigkeiten sind in maximal 30 Minuten mit öffentlichen Verkehrsmitteln erreichbar. Supermärkte und Restaurants befinden sich direkt in unserer Nachbarschaft, ebenso wie Haltestellen für öffentliche Verkehrsmittel. Diese optimale Erreichbarkeit macht uns zum idealen Ausgangspunkt für alle die das lebendige Kulturleben Wiens erleben möchten.
</p>
                                </li>
                                <li class="mil-fade-up">
                                    <div class="mil-item-head">
                                        <span>03.</span>
                                        <h4>Herausragender Service</h4>
                                    </div>
                                    <p>Unser Fokus liegt auf Ihnen als Gast. Unser Team arbeitet daran, Ihren Aufenthalt persönlich und angenehm zu gestalten. Von herzlichen Empfängen bis zu Stadttipps – wir kümmern uns mit Herz und Seele darum, dass sich unsere Gäste rundum wohlfühlen und wiederkommen.
</p>
                                </li>
                            </ul>
                        </div>

                    </div>
                    <div class="col-xl-5 mil-mb-100">

                        <div class="mil-illustration-1">
                            <img src="<?=$GLOBAL["root"];?>assets/img/shapes/4.png" class="mil-shape mil-fade-up" alt="shape">
                            <div class="mil-circle mil-1 mil-fade-up">
                                <img src="<?=$GLOBAL["root"];?>assets/img/services/1.jpg" alt="img">
                            </div>
                            <div class="mil-circle mil-2 mil-fade-up">
                                <img src="<?=$GLOBAL["root"];?>assets/img/services/2.jpg" alt="img">
                            </div>
                            <div class="mil-circle mil-3 mil-fade-up">
                                <img src="<?=$GLOBAL["root"];?>assets/img/services/3.jpg" alt="img">
                            </div>
                            <div class="mil-circle mil-4 mil-fade-up">
                                <img src="<?=$GLOBAL["root"];?>assets/img/services/4.jpg" alt="img">
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- about 1 end -->


        <?
        include("footer.inc.php");
        ?>

        <div class="mil-progressbar"></div>


    </div>
    <!-- wrapper end -->

    <!-- jQuery js -->
    <script src="<?=$GLOBAL["root"];?>assets/js/plugins/jquery.min.js"></script>
    <!-- swiper js -->
    <script src="<?=$GLOBAL["root"];?>assets/js/plugins/swiper.min.js"></script>
    <!-- datepicker js -->
    <script src="<?=$GLOBAL["root"];?>assets/js/plugins/datepicker.js"></script>
    <!-- Art Hotel js -->
    <script src="<?=$GLOBAL["root"];?>assets/js/main.js"></script>
</body>

</html>
