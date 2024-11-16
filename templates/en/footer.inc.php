        <!-- footer -->
        <footer>
            <img src="<?=$GLOBAL["root"];?>assets/img/shapes/4.png" class="mil-shape mil-fade-up" style="width: 85%; top: -15%; left: -40%; transform: rotate(-50deg)" alt="shape">
            <div class="mil-footer-content mil-fade-up">
                <div class="container">


                    <div class="mil-divider"></div>

                    <div class="row justify-content-between flex-sm-row-reverse mil-p-100-40">
                        <div class="col-md-7 col-lg-8">

                            <div class="row justify-content-between">
                                <div class="col-md-6 col-lg-4 mil-mb-40">
                                    <div class="footmenu">
                                        <h5 class="mil-mb-20">Navigation</h5>
                                        <a href="<?=$GLOBAL["linkroot"];?>">> Home</a><br>
                                        <a href="<?=$GLOBAL["linkroot"];?>/ueber-uns">> Our Philosophy</a><br>
                                        <a href="<?=$GLOBAL["linkroot"];?>/zimmer">> Rooms & Prices</a>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 mil-mb-40">
                                    <div class="footmenu">
                                        <h5 class="mil-mb-20">Contact</h5>
                                        <span style="padding-bottom:5px;">Mo-Su | 8:00 - 23:00 Uhr</span><br>
                                        arthotel@ahgroup-hotels.com<br>
                                        +43 670 20 20 541<br>
                                        <br>                                        
                                        

                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 mil-mb-40">
                                    <h5 class="mil-mb-20"><a href="<?=$GLOBAL["linkroot"];?>/impressum" style="color:black;">Imprint</a></h5>
                                    <p>
                                    Art Hotel Vienna<br>
                                    Brandmayergasse 7<br>
                                    1050 Wien</p>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-4 col-lg-4 mil-mb-60">
                            <p class="mil-light-soft">© 2024 - Art Hotel Vienna</p>
                            <a href="<?=$GLOBAL["linkroot"];?>/impressum" style="color:black;text-decoration: none;">Data Protection</a>
							<br><br>

							<a href="<?=$GLOBAL["root"];?>de"><img src="<?=$GLOBAL["root"];?>assets/img/de.png" style="width:30px;margin-right:10px;"></a>
							<a href="<?=$GLOBAL["root"];?>en"><img src="<?=$GLOBAL["root"];?>assets/img/en.png" style="width:30px;"></a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- footer end -->

        <!-- book popup -->
        <div class="mil-book-popup-frame">
            <div class="mil-book-popup">
                <div class="mil-popup-head mil-mb-40">
                    <h3 class="mil-h3-lg">Book now</h3>
                    <div class="mil-close-button">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </div>
                </div>
                <form action="<?=$GLOBAL["linkroot"];?>/booker" method="POST"> 
                    <div class="mil-field-frame mil-mb-20">
                        <label>Arrival</label>
                        <input id="check-in-2" type="text" name="from" class="datepicker-here" data-position="bottom left" placeholder="Datum auswählen" autocomplete="off" readonly="readonly">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                    </div>
                    <div class="mil-field-frame mil-mb-20">
                        <label>Departure</label>
                        <input id="check-out-2" type="text" name="to" class="datepicker-here" data-position="bottom left" placeholder="Datum auswählen" autocomplete="off" readonly="readonly">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                    </div>
                    <div class="mil-field-frame mil-mb-20">
                        <label>Guests (Adults)</label>
                        <input type="text" name="adults" placeholder="Enter quantity" value="1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                    </div>
                    <button type="submit" class="mil-button mil-accent-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                        <span>Check Prices</span>
                    </button>
                </form>
            </div>
        </div>
        <!-- book popup end -->