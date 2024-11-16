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

        <?
        include("header.inc.php");
        ?>

        <!-- banner -->
        <div class="mil-banner">
            <img src="<?=$GLOBAL["root"];?>assets/img/shapes/4.png" class="mil-shape" style="width: 70%; top: 0; right: -12%; transform: rotate(180deg)" alt="shape">
            <img src="<?=$GLOBAL["root"];?>assets/img/shapes/4.png" class="mil-shape" style="width: 80%; bottom: -12%; right: -22%; transform: rotate(0deg) scaleX(-1);" alt="shape">
            <img src="<?=$GLOBAL["root"];?>assets/img/shapes/4.png" class="mil-shape" style="width: 110%; top: -5%; left: -30%; opacity: .2" alt="shape">

            <img src="<?=$GLOBAL["root"];?>assets/img/bird.png" class="mil-shape" style="width: 20%; top: 20%; right: 3%; opacity:0.9;" alt="shape">

            <div class="container">
                <div class="mil-banner-img-2">
                    <img src="<?=$GLOBAL["root"];?>assets/img/images/6.png" alt="_">

                </div>
                <div class="row align-items-center">
                    <div class="col-xl-10">

                        <div class="mil-banner-content-frame">
                            <div class="mil-banner-content">
                                <h1 class="mil-mb-20" style="font-family:Vibezz;">The Viennese Art of...</h1>
                                <h1 class="mil-mb-40"><span id="target" style="font-family:Outfit;line-height:50px;"></span> &nbsp;</h1>
                                <div class="mil-search-panel mil-mb-20">
                                    <form action="<?=$GLOBAL["linkroot"];?>/booker" method="POST">                                        
                                        <div class="mil-form-grid">
                                            <div class="mil-col-5 mil-field-frame">
                                                <label>Ankunft</label>
                                                <input type="text" name="from" class="datepicker-here" data-position="bottom left" placeholder="Datum auswählen" autocomplete="off" readonly="readonly">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar">
                                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                                    <line x1="16" y1="2" x2="16" y2="6"></line>
                                                    <line x1="8" y1="2" x2="8" y2="6"></line>
                                                    <line x1="3" y1="10" x2="21" y2="10"></line>
                                                </svg>
                                            </div>
                                            <div class="mil-col-5 mil-field-frame">
                                                <label>Abreise</label>
                                                <input type="text" name="to" class="datepicker-here" data-position="bottom left" placeholder="Datum auswählen" autocomplete="off" readonly="readonly">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar">
                                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                                    <line x1="16" y1="2" x2="16" y2="6"></line>
                                                    <line x1="8" y1="2" x2="8" y2="6"></line>
                                                    <line x1="3" y1="10" x2="21" y2="10"></line>
                                                </svg>
                                            </div>
                                            <div class="mil-col-2 mil-field-frame">
                                                <label>Erwachsene</label>
                                                <input type="text" name="adults" placeholder="Enter quantity" value="1">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users">
                                                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                                    <circle cx="9" cy="7" r="4"></circle>
                                                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                                </svg>
                                            </div>
                                        </div>
                                        <button type="submit">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search">
                                                <circle cx="11" cy="11" r="8"></circle>
                                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                            </svg>
                                            <span>Verfügbarkeit prüfen</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
        <!-- banner end -->

        <script type="text/javascript">
            document.addEventListener('DOMContentLoaded', function() {
              const words = [ 'Comfort.', 'Service.', 'Hospitality.', 'Beauty.'];
              let currentWordIndex = 0;
              let currentCharIndex = 0;
              const wordBox = document.getElementById('target');

              function typeWord() {
                if (currentCharIndex < words[currentWordIndex].length) {
                  wordBox.textContent += words[currentWordIndex][currentCharIndex];
                  currentCharIndex++;
                  setTimeout(typeWord, 200);  // Geschwindigkeit des Tippeffekts
                } else {
                  setTimeout(clearWord, 1500);  // Wartezeit nach jedem vollständigen Wort
                }
              }

              function clearWord() {
                wordBox.textContent = ' ';  // Löscht das aktuelle Wort
                currentCharIndex = 0;
                currentWordIndex = (currentWordIndex + 1) % words.length;
                setTimeout(typeWord, 0);  // kurze Pause vor dem Start des nächsten Wortes
              }

              typeWord();
            });
        </script>

        <!-- services -->
        <div class="mil-content-pad mil-p-100-100">
            <div class="container">
                <div class="mil-text-center">
                    <div class="mil-suptitle mil-mb-20 mil-fade-up">Das Art Hotel</div>
                    <h2 class="mil-mb-20 mil-fade-up">Wir freuen uns, Sie im Art Hotel Vienna begrüßen zu dürfen</h2>
                </div>

                <div class="row mil-mb-60">
                    <div class="col-lg-12 mil-text-center">
                        <p class="mil-fade-up">Erleben Sie Wiener Kunst und Kultur in unserem mit künstlerischen Details gestalteten Hotel auf 3-Sterne-Standard. Unsere neu gestalteten Zimmer und Apartments bestechen durch ein exklusives Interior Design. Buchen Sie noch heute und genießen Sie einen unvergesslichen Aufenthalt in Wien.

                        </p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 col-xl-3">
                        <a href="service.html" class="mil-service-card mil-mb-40-adapt mil-fade-up">
                            <div class="mil-img-frame">
                                <img src="<?=$GLOBAL["root"];?>assets/img/start1.jpg" alt="img">
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <a href="service.html" class="mil-service-card mil-offset mil-mb-40-adapt mil-fade-up">
                            <div class="mil-img-frame">
                                <img src="<?=$GLOBAL["root"];?>assets/img/start2.jpg" alt="img">
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <a href="service.html" class="mil-service-card mil-mb-40-adapt mil-fade-up">
                            <div class="mil-img-frame">
                                <img src="<?=$GLOBAL["root"];?>assets/img/start3.jpg" alt="img">
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <a href="service.html" class="mil-service-card mil-offset mil-mb-40-adapt mil-fade-up">
                            <div class="mil-img-frame">
                                <img src="<?=$GLOBAL["root"];?>assets/img/start4.jpg" alt="img">
                            </div>
                        </a>
                    </div>
                </div>

            </div>
        </div>
        <!-- services end -->

        <!-- features -->
        <div class="mil-features mil-p-100-60">
            <img src="<?=$GLOBAL["root"];?>assets/img/shapes/4.png" class="mil-shape mil-fade-up" style="width: 85%; top: -20%; left: -30%; transform: rotate(35deg)" alt="shape">
            <div class="container">
                <div class="mil-text-center">
                    <div class="mil-suptitle mil-mb-20 mil-fade-up">Ihre Vorteile</div>
                    <h2 class="mil-mb-100 mil-fade-up">Warum Sie das Art Hotel lieben werden</h2>
                </div>
                <div class="row">
                    <div class="col-md-6 col-xl-4">
                        <div class="mil-iconbox mil-mb-40-adapt mil-fade-up">
                            <div class="mil-bg-icon"></div>
                            <div class="mil-icon">
                                <svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M8.2041 1.91858C5.71919 1.91858 3.70312 3.83743 3.70312 6.20076C3.70312 8.9201 6.70378 13.2295 7.80558 14.7179C7.85132 14.7808 7.91126 14.8319 7.98052 14.8671C8.04978 14.9024 8.12639 14.9208 8.2041 14.9208C8.28182 14.9208 8.35843 14.9024 8.42769 14.8671C8.49695 14.8319 8.55689 14.7808 8.60263 14.7179C9.70443 13.2301 12.7051 8.92229 12.7051 6.20076C12.7051 3.83743 10.689 1.91858 8.2041 1.91858Z" stroke="black" stroke-width="1.00189" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M8.20553 7.92217C9.03475 7.92217 9.70696 7.24996 9.70696 6.42074C9.70696 5.59152 9.03475 4.91931 8.20553 4.91931C7.37631 4.91931 6.7041 5.59152 6.7041 6.42074C6.7041 7.24996 7.37631 7.92217 8.20553 7.92217Z" stroke="black" stroke-width="1.00189" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                            </div>
                            <h3 class="mil-mb-20">Perfekte Erreichbarkeit</h3>
                            <p>Unser Hotel liegt nur 20 Minuten vom Wiener Hauptbahnhof entfernt. Supermärkte und Restaurants sind in nur 5 Minuten zu Fuß erreichbar. In 30 Minuten können Sie nahezu alle Wiener Sehenswürdigkeiten erreichen. Reisen Sie mit dem Auto an? Buchen Sie einfach unsere Tiefgarage. 
</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-4">
                        <div class="mil-iconbox mil-mb-40-adapt mil-fade-up">
                            <div class="mil-bg-icon"></div>
                            <div class="mil-icon mil-mb-40">
                                <svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12.2709 8.32831H3.26892V5.0776C3.26991 4.74632 3.40195 4.42888 3.63621 4.19462C3.87047 3.96036 4.1879 3.82832 4.51919 3.82733H12.0208C12.3521 3.82832 12.6696 3.96036 12.9038 4.19462C13.1381 4.42888 13.2701 4.74632 13.2711 5.0776V8.32831H12.2709Z" stroke="black" stroke-width="1.00189" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M1.76868 13.8293V10.3285C1.77024 9.79843 1.98151 9.29052 2.35632 8.91571C2.73114 8.54089 3.23905 8.32963 3.76911 8.32806H12.7711C13.3011 8.32963 13.809 8.54089 14.1839 8.91571C14.5587 9.29052 14.7699 9.79843 14.7715 10.3285V13.8293" stroke="black" stroke-width="1.00189" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M1.76868 13.8294V13.5794C1.76925 13.3806 1.84847 13.1901 1.98903 13.0496C2.12959 12.909 2.32006 12.8298 2.51884 12.8292H14.0213C14.2201 12.8298 14.4106 12.909 14.5512 13.0496C14.6917 13.1901 14.7709 13.3806 14.7715 13.5794V13.8294" stroke="black" stroke-width="1.00189" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M3.76904 8.32824V7.82806C3.76979 7.56297 3.87542 7.30896 4.06286 7.12152C4.25031 6.93407 4.50432 6.82844 4.7694 6.8277H7.2703C7.53539 6.82844 7.7894 6.93407 7.97685 7.12152C8.16429 7.30896 8.26992 7.56297 8.27066 7.82806V8.32824" stroke="black" stroke-width="1.00189" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M8.2699 8.32824V7.82806C8.27064 7.56297 8.37627 7.30896 8.56372 7.12152C8.75116 6.93407 9.00517 6.82844 9.27026 6.8277H11.7712C12.0362 6.82844 12.2903 6.93407 12.4777 7.12152C12.6651 7.30896 12.7708 7.56297 12.7715 7.82806V8.32824" stroke="black" stroke-width="1.00189" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                            </div>
                            <h3 class="mil-mb-20">Gehobener Comfort</h3>
                            <p>Unsere Hotelzimmer sind mit Handtüchern, Pflegeprodukten, einem Föhn und einer Kochnische ausgestattet. In unseren Apartments finden Sie zusätzlich eine voll ausgestattete Küche. Wir bieten Ihnen ein umfangreiches Frühstücksbuffet, damit Sie gestärkt in Ihren Urlaubstag starten können.
</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-4">
                        <div class="mil-iconbox mil-mb-40-adapt mil-fade-up">
                            <div class="mil-bg-icon"></div>
                            <div class="mil-icon">
                                <svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_5_848)">
                                        <path d="M6.99805 5.81199C6.84492 5.06047 6.6608 4.04998 6.6608 3.5189C6.65943 3.30596 6.70036 3.09487 6.78121 2.89787C6.86207 2.70087 6.98124 2.52189 7.13182 2.37132C7.28239 2.22074 7.46137 2.10157 7.65837 2.02071C7.85536 1.93986 8.06646 1.89893 8.2794 1.9003V1.9003C9.1734 1.9003 9.898 2.64212 9.898 3.5189C9.898 4.03557 9.71481 5.0517 9.56075 5.81199" stroke="black" stroke-width="1.00189" stroke-miterlimit="10" stroke-linecap="round"></path>
                                        <path d="M6.99805 12.0153C6.8443 12.7687 6.6608 13.7738 6.6608 14.3084C6.65943 14.5213 6.70036 14.7324 6.78121 14.9294C6.86207 15.1264 6.98124 15.3054 7.13182 15.4559C7.28239 15.6065 7.46137 15.7257 7.65837 15.8065C7.85536 15.8874 8.06646 15.9283 8.2794 15.927V15.927C9.1734 15.927 9.898 15.1851 9.898 14.3084C9.898 13.7904 9.71481 12.7762 9.56075 12.0153" stroke="black" stroke-width="1.00189" stroke-miterlimit="10" stroke-linecap="round"></path>
                                        <path d="M11.3809 7.63208C12.1343 7.47833 13.1394 7.29483 13.674 7.29483C13.8869 7.29346 14.098 7.33439 14.295 7.41525C14.492 7.4961 14.671 7.61527 14.8215 7.76585C14.9721 7.91642 15.0913 8.0954 15.1721 8.2924C15.253 8.4894 15.2939 8.70049 15.2926 8.91343V8.91343C15.2926 9.80743 14.5507 10.532 13.674 10.532C13.1573 10.532 12.1412 10.3488 11.3809 10.1948" stroke="black" stroke-width="1.00189" stroke-miterlimit="10" stroke-linecap="round"></path>
                                        <path d="M5.17735 7.63177C4.42582 7.47864 3.41596 7.29483 2.88426 7.29483C2.67132 7.29346 2.46022 7.33439 2.26323 7.41525C2.06623 7.4961 1.88725 7.61527 1.73667 7.76585C1.5861 7.91642 1.46693 8.0954 1.38607 8.2924C1.30521 8.4894 1.26429 8.70049 1.26566 8.91343V8.91343C1.26566 9.80743 2.00748 10.532 2.88426 10.532C3.40093 10.532 4.41706 10.3488 5.17735 10.1948" stroke="black" stroke-width="1.00189" stroke-miterlimit="10" stroke-linecap="round"></path>
                                        <path d="M9.56018 5.81169C9.98448 5.17038 10.5716 4.33212 10.9496 3.95448C11.0991 3.8029 11.2773 3.68255 11.4738 3.6004C11.6703 3.51825 11.8811 3.47595 12.0941 3.47595C12.307 3.47595 12.5179 3.51825 12.7143 3.6004C12.9108 3.68255 13.089 3.8029 13.2386 3.95448V3.95448C13.8708 4.5867 13.8586 5.62349 13.2386 6.2435C12.8735 6.60893 12.0277 7.20389 11.3814 7.63288" stroke="black" stroke-width="1.00189" stroke-miterlimit="10" stroke-linecap="round"></path>
                                        <path d="M5.17704 10.1948C4.53574 10.6191 3.69748 11.2062 3.31983 11.5841C3.16826 11.7337 3.0479 11.9119 2.96576 12.1084C2.88361 12.3049 2.84131 12.5157 2.84131 12.7287C2.84131 12.9416 2.88361 13.1524 2.96576 13.3489C3.0479 13.5454 3.16826 13.7236 3.31983 13.8732C3.95206 14.5054 4.98885 14.4932 5.60886 13.8732C5.97429 13.5081 6.56924 12.6623 6.99824 12.016" stroke="black" stroke-width="1.00189" stroke-miterlimit="10" stroke-linecap="round"></path>
                                        <path d="M11.3814 10.1948C12.0227 10.6191 12.8609 11.2062 13.2386 11.5841C13.3902 11.7337 13.5105 11.9119 13.5927 12.1084C13.6748 12.3049 13.7171 12.5157 13.7171 12.7287C13.7171 12.9416 13.6748 13.1524 13.5927 13.3489C13.5105 13.5454 13.3902 13.7236 13.2386 13.8732V13.8732C12.6064 14.5054 11.5696 14.4932 10.9496 13.8732C10.5835 13.5071 9.98949 12.6629 9.56018 12.016" stroke="black" stroke-width="1.00189" stroke-miterlimit="10" stroke-linecap="round"></path>
                                        <path d="M6.99822 5.81169C6.57455 5.17195 5.98429 4.32993 5.60884 3.95448C5.45926 3.8029 5.28106 3.68255 5.08459 3.6004C4.88812 3.51825 4.67728 3.47595 4.46433 3.47595C4.25137 3.47595 4.04054 3.51825 3.84407 3.6004C3.64759 3.68255 3.4694 3.8029 3.31982 3.95448V3.95448C2.6876 4.5867 2.69981 5.62349 3.31982 6.2435C3.68337 6.60705 4.53165 7.2042 5.17703 7.63288" stroke="black" stroke-width="1.00189" stroke-miterlimit="10" stroke-linecap="round"></path>
                                        <path d="M8.27897 10.918C9.38579 10.918 10.283 10.0208 10.283 8.91398C10.283 7.80716 9.38579 6.90991 8.27897 6.90991C7.17215 6.90991 6.2749 7.80716 6.2749 8.91398C6.2749 10.0208 7.17215 10.918 8.27897 10.918Z" stroke="black" stroke-width="1.00189" stroke-miterlimit="10" stroke-linecap="round"></path>
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_5_848">
                                            <rect width="16.0303" height="16.0303" fill="white" transform="translate(0.263672 0.89856)"></rect>
                                        </clipPath>
                                    </defs>
                                </svg>
                            </div>
                            <h3 class="mil-mb-20">Bester Service</h3>
                            <p>Unsere Rezeption heißt Sie bei Ihrer Anreise herzlich willkommen, unterstützt Sie in allen Angelegenheiten und beantwortet Ihre Fragen. Unser Serviceteam sorgt dafür, dass Ihr Aufenthalt angenehm und reibungslos verläuft.
</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- features end -->

        <!-- reviews -->
        <div class="mil-content-pad mil-p-100-100 mil-mb-100" style="background-image: url(<?=$GLOBAL["root"];?>assets/img/shapes/5.png); background-size: 100%">
            <div class="container">

                <div class="mil-text-center">
                    <div class="mil-suptitle mil-mb-20 mil-fade-up">Kundenstimmen</div>
                    <h2 class="mil-mb-40 mil-fade-up">Das sagen unsere Gäste</h2>
                </div>


                <div class="row mil-relative justify-content-center">
                    <div class="col-lg-8">

                        <svg width="24" height="19" viewBox="0 0 24 19" fill="none" xmlns="http://www.w3.org/2000/svg" class="mil-quote-icon mil-fade-up">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M1.98153 16.5432L1.96873 16.5275C0.970391 15.3023 0.511963 13.7557 0.511963 11.9758C0.511963 9.67596 1.19329 7.53976 2.53323 5.58922C3.85431 3.62895 5.51386 2.14449 7.5121 1.16577L8.40283 0.729492L9.55276 3.02935L8.89401 3.53126C8.21398 4.04938 7.60022 4.72403 7.05823 5.57088C6.67538 6.16909 6.36018 6.89486 6.1236 7.76055L6.33141 7.81003C7.78521 8.1431 8.99251 8.7862 9.86883 9.79182C10.7881 10.7656 11.248 11.9611 11.248 13.3198C11.248 14.7682 10.7384 16.0131 9.69719 16.964C8.71506 17.8953 7.49463 18.3518 6.10396 18.3518C4.4575 18.3518 3.05714 17.7591 1.99497 16.5584L1.98153 16.5432ZM9.01596 16.2318C9.8373 15.4852 10.248 14.5145 10.248 13.3198C10.248 12.1998 9.87463 11.2478 9.12796 10.4638C8.41863 9.6425 7.41063 9.0825 6.10396 8.78383L4.92796 8.50383C5.1893 7.12249 5.61863 5.96516 6.21596 5.03183C6.58142 4.4608 6.98181 3.95267 7.41714 3.50741C7.69184 3.22645 7.98045 2.97052 8.28297 2.73964C8.28463 2.73837 8.2863 2.7371 8.28796 2.73583L7.95196 2.06383C7.90926 2.08474 7.86672 2.10591 7.82435 2.12734C7.81171 2.13373 7.79908 2.14014 7.78647 2.14658C7.54355 2.27054 7.30601 2.40289 7.07384 2.54364C6.97633 2.60276 6.87977 2.66335 6.78416 2.72542C5.4614 3.58418 4.32 4.72632 3.35996 6.15183C2.12796 7.94383 1.51196 9.88516 1.51196 11.9758C1.51196 13.5812 1.92263 14.8878 2.74396 15.8958C3.60263 16.8665 4.72263 17.3518 6.10396 17.3518C7.2613 17.3518 8.23196 16.9785 9.01596 16.2318ZM13.7975 16.5432L13.7847 16.5275C12.7864 15.3023 12.328 13.7557 12.328 11.9758C12.328 9.67597 13.0093 7.53977 14.3492 5.58924C15.6703 3.62895 17.3299 2.1445 19.3281 1.16577L20.2188 0.729492L21.3688 3.02935L20.71 3.53126C20.03 4.04938 19.4162 4.72403 18.8742 5.57088C18.4914 6.16909 18.1762 6.89486 17.9396 7.76055L18.1474 7.81004C19.6012 8.14311 20.8085 8.78622 21.6848 9.79183C22.6041 10.7656 23.064 11.9611 23.064 13.3198C23.064 14.7681 22.5545 16.0131 21.5132 16.9639C20.5311 17.8953 19.3107 18.3518 17.92 18.3518C16.2735 18.3518 14.8731 17.7591 13.811 16.5584L13.7975 16.5432ZM20.832 16.2318C21.6533 15.4852 22.064 14.5145 22.064 13.3198C22.064 12.1998 21.6906 11.2478 20.944 10.4638C20.2346 9.6425 19.2266 9.0825 17.92 8.78383L16.744 8.50383C17.0053 7.12249 17.4346 5.96516 18.032 5.03183C18.3974 4.4608 18.7978 3.95266 19.2331 3.50741C19.5078 3.22645 19.7965 2.97052 20.099 2.73964C20.1006 2.73837 20.1023 2.7371 20.104 2.73583L19.768 2.06383C19.7253 2.08474 19.6827 2.10591 19.6404 2.12734C19.6277 2.13375 19.615 2.14018 19.6024 2.14664C19.3595 2.27058 19.122 2.40292 18.8898 2.54364C18.7923 2.60276 18.6958 2.66335 18.6002 2.72542C17.2774 3.58418 16.136 4.72632 15.176 6.15183C13.944 7.94383 13.328 9.88516 13.328 11.9758C13.328 13.5812 13.7386 14.8878 14.56 15.8958C15.4186 16.8665 16.5386 17.3518 17.92 17.3518C19.0773 17.3518 20.048 16.9785 20.832 16.2318Z" fill="black" />
                        </svg>

                        <div class="swiper-container mil-reviews-slider">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <div class="mil-review-frame mil-text-center" data-swiper-parallax="-250" data-swiper-parallax-opacity="0">
                                        <p class="mil-fade-up mil-mb-20">Das Hotel überzeugte durch seinen außergewöhnlichen Service und die herzliche Gastfreundschaft, die man in jedem Detail spüren konnte. Die zentrale Lage ermöglichte es uns, die wunderschöne Stadt Wien bequem zu erkunden. Ein perfekter Aufenthalt für unseren Städtetrip.</p>
                                        <div class="mil-fade-up">
                                            <h3 class="mil-mb-10">Sarah T.</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="mil-review-frame mil-text-center" data-swiper-parallax="-250" data-swiper-parallax-opacity="0">
                                        <p class="mil-fade-up mil-mb-20">Unser Zimmer im Hotel war gemütlich und sauber, mit einem schönen Blick auf die lebendigen Straßen Wiens. Das Frühstücksbuffet bot eine reiche Auswahl an frischen Produkten, die uns sehr positiv überraschten.</p>
                                        <div class="mil-fade-up">
                                            <h3 class="mil-mb-10">Maximilian S.</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="mil-review-frame mil-text-center" data-swiper-parallax="-250" data-swiper-parallax-opacity="0">
                                        <p class="mil-fade-up mil-mb-20">Ich war geschäftlich in Wien und fand in diesem Hotel genau das, was ich brauchte: eine ruhige Atmosphäre, schnelles WLAN und ein effizienter Zimmerservice. Die Nähe zur U-Bahn war ein zusätzlicher Bonus. Die kunstvolle und durchdachte Einrichtung kann man wirklich nur positiv hervorheben!</p>
                                        <div class="mil-fade-up">
                                            <h3 class="mil-mb-10">Paul M.</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="mil-review-frame mil-text-center" data-swiper-parallax="-250" data-swiper-parallax-opacity="0">
                                        <p class="mil-fade-up mil-mb-20">Das Hotel bot uns eine wundervolle Erfahrung mit seinem traditionellen Wiener Charme und modernen Annehmlichkeiten. Die Mitarbeiter waren immer freundlich und zuvorkommend, was unseren Aufenthalt besonders angenehm machte. Ein großartiges Preis-Leistungs-Verhältnis und ideal für Familien.</p>
                                        <div class="mil-fade-up">
                                            <h3 class="mil-mb-10">Laura K.</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mil-slider-nav mil-reviews-nav mil-fade-up">
                            <div class="mil-slider-arrow mil-prev mil-revi-prev mil-arrow-place">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right">
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                    <polyline points="12 5 19 12 12 19"></polyline>
                                </svg>
                            </div>
                            <div class="mil-slider-arrow mil-revi-next mil-arrow-place">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right">
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                    <polyline points="12 5 19 12 12 19"></polyline>
                                </svg>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
        <!-- reviews end -->

        <!-- about 2 -->
        <div class="mil-about">
            <div class="container">
                <div class="row justify-content-between align-items-center flex-sm-row-reverse">
                    <div class="col-xl-5 mil-mb-100">

                        <div class="mil-text-frame">
                            <div class="mil-suptitle mil-mb-20 mil-fade-up">Über Uns</div>
                            <h2 class="mil-mb-40 mil-fade-up">Art for the people!</h2>
                            <p class="mil-mb-20 mil-fade-up">Die Kultur der Stadt Wien, ihre Geschichte und ihr urbaner Flair setzen sich in unserem Art Hotel Vienna fort. Das Art Hotel zeichnet sich durch seine künstlerische Gestaltung aus. Diese beginnt bei einer farbenfrohen Malerei, die sich über die gesamte Fassade des Hotels erstreckt, und setzt sich in Form von Kunstwerken und Wandmalereien in den Innenräumen fort. Auch die Zimmer wurden kürzlich neu gestaltet und bieten eine Wohlfühl-Atmosphäre mit modernem und hochwertigem Interior Design.
</p>

                            <p class="mil-mb-40 mil-fade-up">Der künstlerische Flair ist der Feinschliff. Selbstverständlich können Sie auch alle Annehmlichkeiten eines gut geführten Hotels erwarten. Dazu gehören unter anderem ruhige und komfortable Zimmer, ein umfangreiches Frühstück und Pflegeprodukte in allen Zimmern.
</p>

                            <span class="mil-buttons-frame mil-fade-up">
                                <a href="#." class="mil-button mil-open-book-popup">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail">
                                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                        <polyline points="22,6 12,13 2,6"></polyline>
                                    </svg>
                                    <span>Jetzt buchen</span>
                                </a>
                                <a href="<?=$GLOBAL["linkroot"];?>/ueber-uns" class="mil-link">
                                    <span>Unsere Philosophie</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right">
                                        <line x1="5" y1="12" x2="19" y2="12"></line>
                                        <polyline points="12 5 19 12 12 19"></polyline>
                                    </svg>
                                </a>
                            </span>
                        </div>

                    </div>
                    <div class="col-xl-6 mil-mb-100">

                        <div class="mil-illustration-2">
                            <img src="<?=$GLOBAL["root"];?>assets/img/shapes/4.png" class="mil-shape mil-fade-up" alt="shape">
                            <div class="mil-main-img mil-fade-up">
                                <img src="<?=$GLOBAL["root"];?>assets/img/images/5.png" alt="img">
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- about 2 end -->


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
