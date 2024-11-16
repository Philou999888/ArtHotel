        <!-- top panel -->
        <div class="mil-top-panel">
            <div class="container">
                <div class="mil-top-panel-content">
                    <a href="<?=$GLOBAL["linkroot"];?>" class="mil-logo">
                        <img src="<?=$GLOBAL["root"];?>assets/img/logo.png" alt="Art Hotel">
                    </a>
                    <div class="mil-menu-btn">
                        <span></span>
                    </div>
                    <div class="mil-mobile-menu">
                        <nav class="mil-menu">
                            <ul>
                                <li<?if($GLOBAL["current_page"] == "home"){?> class="mil-current"<?}?>>
                                    <a href="<?=$GLOBAL["linkroot"];?>">Home</a>
                                </li>
                                <li<?if($GLOBAL["current_page"] == "/ueber-uns"){?> class="mil-current"<?}?>>
                                    <a href="<?=$GLOBAL["linkroot"];?>/ueber-uns">Philosophy</a>
                                </li>
                                <li<?if($GLOBAL["current_page"] == "/zimmer"){?> class="mil-current"<?}?>>
                                    <a href="<?=$GLOBAL["linkroot"];?>/zimmer">Rooms & Prices</a>
                                </li>
                                <li<?if($GLOBAL["current_page"] == "/lage"){?> class="mil-current"<?}?>>
                                    <a href="<?=$GLOBAL["linkroot"];?>/lage">Location</a>
                                </li>
                            </ul>
                        </nav>
                        <a href="#." class="mil-button mil-open-book-popup mil-top-panel-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bookmark">
                                <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path>
                            </svg>
                            <span>Book now!</span>
                        </a>
						
						<?
						if(IsMobile()) {
							?>
							<br style="clear:both;">
							<nobr style="margin-top:30px;">
								<a href="<?=$GLOBAL["root"];?>de"><img src="<?=$GLOBAL["root"];?>assets/img/de.png" style="width:30px;margin-right:10px;"></a>
								<a href="<?=$GLOBAL["root"];?>en"><img src="<?=$GLOBAL["root"];?>assets/img/en.png" style="width:30px;"></a>
							</nobr>
							<?
						}
						?>
                    </div>
                </div>
            </div>
        </div>
        <!-- top panel end -->
