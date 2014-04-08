<?php

$current_site = $_SERVER['SERVER_NAME'];
$current_site = str_replace('www.','',strtolower($current_site));
$logo = 'ryans';
$analytics = 'UA-19672012-17';

switch($current_site) {	
	case 'oldcountrybuffet.com':
		$logo = 'old-country';
		$analytics = 'UA-19672012-16';
	break;
	case 'countrybuffet.com':
		$logo = 'country';
		$analytics = 'UA-19672012-1';
	break;
	case 'firemountainbuffet.com':
		$logo = 'fire-mountain';
	break;
	case 'hometownbuffet.com':
		$logo = 'hometown';
		$analytics = 'UA-19672012-15';
	break;
}
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
		<link rel="stylesheet" href="css/fonts/cubano/stylesheet.css">
		<link rel="stylesheet" href="css/fonts/museosans/stylesheet.css">
		<link rel="stylesheet" href="css/fonts/missiongothic/stylesheet.css">
        
        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="css/main.css">
        <script src="js/vendor/modernizr-2.6.2.min.js"></script>
    </head>
    <body>
    
    	<div style="display:none;">
        	<img src="images/background-homepage.jpg" />
            <img src="images/background-map.jpg" />
            
            <img src="images/where/background-bakery.jpg" />
            <img src="images/where/background-carving-station.jpg" />
            <img src="images/where/background-dining-tables.jpg" />
            <img src="images/where/background-fresh-market.jpg" />
            <img src="images/where/background-game-room.jpg" />
            <img src="images/where/background-grill.jpg" />
            <img src="images/where/background-omelet-station.jpg" />

            <img src="images/where/winner-background-bakery.jpg" />
            <img src="images/where/winner-background-carving-station.jpg" />
            <img src="images/where/winner-background-dining-tables.jpg" />
            <img src="images/where/winner-background-fresh-market.jpg" />
            <img src="images/where/winner-background-game-room.jpg" />
            <img src="images/where/winner-background-grill.jpg" />
            <img src="images/where/winner-background-omelet-station.jpg" />

            <img src="images/who/polaroid-cashier-white.png" />
            <img src="images/who/polaroid-chef-green.png" />
            <img src="images/who/polaroid-grill-pro-plum.png" />
            <img src="images/who/polaroid-manager-mustard.png" />
            <img src="images/who/polaroid-penny-peacock.png" />
            <img src="images/who/polaroid-sally-scarlet.png" />
        
        </div>

		<div class="wrapper">
        
        	<article id="home">

                <a id="logo-ryans"><img src="images/logos/<?=$logo?>.png" /></a>
                <a id="logo-clue"></a>

				<img src="images/case-of-the-missing-plate.png" />
                
                <button class="btn investigate go-to-page" data-page="#map">LET'S INVESTIGATE <img src="images/icons-buttons/magnifying-glass.png" /></button>
            
            </article>
            
         	<article class="page-with-nav" id="map">
            	<nav>
                	<div class="nav-content">
                        <div class="left">
                            <div class="timer">
                            
                                <div class="time">
                                	00:00
                                </div>
                                
                                <div class="additions">
                                	<span class="plus">+</span><span class="addition">30</span>                                
                                </div>                       
                            </div>
                            <button class="btn guess">GUESS! <img src="images/icons-buttons/question-mark.png" /></button>
                        </div>
                        
                        <div class="right">
                            
                            <button class="btn leaderboard">LEADERBOARD <img src="images/icons-buttons/trophy.png" /></button>
                            <button class="btn the-rules">THE RULES <img src="images/icons-buttons/book.png" /></button>                   
                        </div>
                    </div>               
                </nav>
                
                <section>
                
                	<a href="#station" class="station go-to-page" id="overlay-bakery"><span>BAKE SHOP</span></a>
                	<a href="#station" class="station go-to-page" id="overlay-carving-station"><span>THE CARVERY</span></a>
                	<a href="#station" class="station go-to-page" id="overlay-dining-tables-1"><span>DINING TABLES</span></a>
                	<a href="#station" class="station go-to-page" id="overlay-dining-tables-2"></a>
                	<a href="#station" class="station go-to-page" id="overlay-fresh-market"><span>SALAD BAR</span></a>
                	<a href="#station" class="station go-to-page" id="overlay-game-room"><span>GAME ROOM</span></a>
                	<a href="#station" class="station go-to-page" id="overlay-grill"><span>RANCHER'S SELECT<sup>&reg;</sup> GRILL</span></a>
                	<a href="#station" class="station go-to-page" id="overlay-omelet-station"><span>GRANDE VIA</span></a>
                                    
                </section>
            
            </article> 
            
         	<article class="page-with-nav" id="station">
            	<nav>
                
                	<div class="nav-content">
    
                        <div class="left">
                            <div class="timer">
                            
                                <div class="time">
                                	00:00
                                </div>
                                
                                <div class="additions">
                                	<span class="plus">+</span><span class="addition">30</span>                                
                                </div>                       
                            </div>
                            <button class="btn guess">GUESS! <img src="images/icons-buttons/question-mark.png" /></button>
                        </div>
                    
                    </div>
                
                </nav>
                
                <section>
                
                	<button class="btn-circular red back-to-map go-to-page" data-page="#map"><img src="images/icons-buttons/pull-out-arrow-left.png" /></button>
                	<a href="#map" class="back-to-map go-to-page"> DISCOVER MORE CLUES</a>
                </section>
            
            </article>  
            
         	<article class="page-with-nav" id="incorrect">
            	<nav>
                
                	<div class="nav-content">
                
                        <div class="left">
                            <div class="timer">
                            
                                <div class="time">
                                	00:00
                                </div>
                                
                                <div class="additions">
                                	<span class="plus">+</span><span class="addition">30</span>                                
                                </div>                       
                            </div>
                                                    
                        </div>
                        
                        <div class="right">
                            
                            <button class="btn try-again go-to-page" data-page="#map">TRY AGAIN <img src="images/icons-buttons/question-mark.png" /></button>
                        
                        </div>                
                	</div>
                </nav>
                
                <section>
                
                	<img class="polaroid-who" src="" />
                	<img class="polaroid-what" src="" />
                
                	<img class="icon-correct" src="images/incorrect.png" />
                
                </section>
            
            </article>                         


         	<article class="page-with-nav" id="correct">

            	<nav>

                	<div class="nav-content">

                        <div class="left">
                            <div class="timer">
                            
                                <div class="time">
                                	00:00
                                </div>
                                
                                <div class="additions">
                                	<span class="plus">+</span><span class="addition">30</span>                                
                                </div>                       
                            </div>
                                                    
                        </div>
                        
                        <div class="right">
                            
                            <button class="btn try-again go-to-page" data-page="#print">NEXT <img src="images/icons-buttons/arrow-right.png" /></button>
                        
                        </div>                     
                    
					</div>                                               
                </nav>
                
                <section>
                
                	<img class="polaroid-who" src="" />
                	<img class="polaroid-what" src="" />
                
                	<img class="icon-correct" src="images/correct.png" />
                
                </section>
            
            </article>  
            
         	<article class="page-with-nav" id="print">

            	<nav>

                	<div class="nav-content">
              
                        <div class="left">
                        
                            <button onClick="_gaq.push(['_trackEvent', 'CLUE', 'play again', 'Clicked on play again button']);" class="btn play-again" data-page="#">PLAY AGAIN <img src="images/icons-buttons/question-mark.png" /></button>						                   
                        </div>
                        
                        <div class="right">
                            
                            <button onClick="_gaq.push(['_trackEvent', 'CLUE', 'print', 'Clicked on print button']);" class="btn print">PRINT <img src="images/icons-buttons/print.png" /></button>
                        
                        </div>                
                	</div>
                </nav>
                
                <section>
                
                	<img src="images/coupon.jpg" />
					<span class="print-name">CALVIN</span>
					 <p style="position: absolute; z-index: 30; color: #fff; bottom: 45px; font-size: 12px;">This is an advertisement.</p>                
                </section>
                
            	<iframe id="ifrOutput" style="display:none;"></iframe> 
            
            </article>                                   
            

            <aside id="info-overlay">
            	<div class="translucent">
                
                    <div class="content">
                        <img id="info-timer" src="images/time-is-ticking-solve-the-case.png" />
                        <img id="info-additions" src="images/time-is-added-for-every-room-you-enter.png" />
                        <img id="info-guess" src="images/when-you-are-ready-solve-the-case.png" />
                        <img id="info-leaderboard" src="images/our-top-ten-swiftest-detectives.png" />
                        <img id="info-rules" src="images/forget-the-rules-sneak-a-peek.png" />
                    </div>
                    <button class="btn start">START NOW <img src="images/icons-buttons/arrow-right.png" /></button>                
                
                </div>

            
            </aside>            
            
            <aside id="folder-rules" class="peeking">
                            
            	<div class="content">
                
                	<button class="btn-circular black open-folder-rules"><img src="images/icons-buttons/pull-out-arrow-left.png" /></button>
                	<button class="btn-circular black close-folder-rules"><img src="images/icons-buttons/pull-out-arrow-right.png" /></button>
                
                	<div class="top">
                        <h2>THE MYSTERY</h2>
                        <p>
    						We made you a yummy plate of food, but someone swiped it before you saw it! It’s your job, as our lead detective, to find out which suspect is hiding in which station with which plate of your food. Travel to each station to cross clues off of your list. Soon, you’ll discover who stole your plate, where they’re hiding and what you’ll be eating – if you find it in time!                     
                        </p>
                	</div>
                	
                    <div class="bottom">
                    	<h2>HOW TO PLAY</h2>
                        <ol>
                        	<li>
								<span class="number">1</span>
                                <div>
                                Find your yummy mystery plate as fast as you can. <span class="highlighted">Time is ticking!</span>
                                </div>                            
                            </li>
                        	<li>
                            	<span class="number">2</span>
                                <div>
                                	Stop by different stations to find more clues. But be smart! Every clue adds <span class="highlighted">10 seconds</span> to your time.
                                </div>                                
                            </li>
                        	<li>
								<span class="number">3</span>
                               	<div>
                                	Once enough items are crossed off your list, click GUESS at the top of your screen. Choose one suspect, one plate, and one station. But be careful – every wrong guess adds <span class="highlighted">30 seconds</span> to your time!
                            	</div>
                            </li>
                        	<li>
								<span class="number">4</span>
                                <div>
                                	Guess right and receive an extra special <span class="highlighted">surprise!</span>   
                                </div>                             
                            </li>                        
                        </ol>

                    </div>
                    
                </div>
            
            </aside>
            
            <aside id="folder-clue-sheet">
            	
                <div class="content">

                    <div class="select pick-who">
                    
                    	<a href="#" id="grill-pro-plum" class="selectable">
                        	<img class="pick-thumb" src="images/who/grill-pro-plum.jpg" />
                        	<img class="pick-overlay" src="images/overlay-x.png" />                           
                        </a>
                    	<a href="#" id="penny-peacock" class="selectable">
                        	<img class="pick-thumb" src="images/who/penny-peacock.jpg" />
                        	<img class="pick-overlay" src="images/overlay-x.png" />                           
                        </a>
                    	<a href="#" id="cashier-white" class="selectable">
                        	<img class="pick-thumb" src="images/who/cashier-white.jpg" />
                        	<img class="pick-overlay" src="images/overlay-x.png" />                           
                        </a>
                    	<a href="#" id="chef-green" class="selectable">
                        	<img class="pick-thumb" src="images/who/chef-green.jpg" />
                        	<img class="pick-overlay" src="images/overlay-x.png" />                           
                        </a>
                    	<a href="#" id="manager-mustard" class="selectable">
                        	<img class="pick-thumb" src="images/who/manager-mustard.jpg" />
                        	<img class="pick-overlay" src="images/overlay-x.png" />                           
                        </a>
                    	<a href="#" id="sally-scarlet" class="selectable">
                        	<img class="pick-thumb" src="images/who/sally-scarlet.jpg" />
                        	<img class="pick-overlay" src="images/overlay-x.png" />                           
                        </a>                  
                    
                    </div>
    
                    <div class="select pick-what">
                    
                    	<a href="#" id="steak-and-salad" class="selectable">
                        	<img class="pick-thumb" src="images/what/steak-and-salad.jpg" />
                        	<img class="pick-overlay" src="images/overlay-x.png" />                                                       
                        </a>
                    	<a href="#" id="spaghetti" class="selectable">
                        	<img class="pick-thumb" src="images/what/spaghetti.jpg" />
                        	<img class="pick-overlay" src="images/overlay-x.png" />                           
                        </a>
                    	<a href="#" id="chicken" class="selectable">
                        	<img class="pick-thumb" src="images/what/chicken.jpg" />
                        	<img class="pick-overlay" src="images/overlay-x.png" />                           
                        </a>
                    	<a href="#" id="omelet" class="selectable">
                        	<img class="pick-thumb" src="images/what/omelet.jpg" />
                        	<img class="pick-overlay" src="images/overlay-x.png" />                                                       
                        </a>
                    	<a href="#" id="carrot-cake" class="selectable">
                        	<img class="pick-thumb" src="images/what/carrot-cake.jpg" />
                        	<img class="pick-overlay" src="images/overlay-x.png" />                           
                        </a>
                    	<a href="#" id="chocolate-chip-cookies" class="selectable">
                        	<img class="pick-thumb" src="images/what/chocolate-chip-cookies.jpg" />
                        	<img class="pick-overlay" src="images/overlay-x.png" />                           
                        </a>                    
                    </div>              
                    
                    <div class="select pick-where">

                    	<a href="#" id="bakery" class="selectable">
                        	<img class="pick-thumb" src="images/where/bakery.jpg" />
                        	<img class="pick-overlay" src="images/overlay-x.png" />                           
                        </a>
                    	<a href="#" id="fresh-market" class="selectable">
                        	<img class="pick-thumb" src="images/where/fresh-market.jpg" />
                        	<img class="pick-overlay" src="images/overlay-x.png" />                           
                        </a>
                    	<a href="#" id="game-room" class="selectable">
                        	<img class="pick-thumb" src="images/where/game-room.jpg" />
                        	<img class="pick-overlay" src="images/overlay-x.png" />                           
                        </a>
                    	<a href="#" id="dining-tables" class="selectable">
                        	<img class="pick-thumb" src="images/where/dining-tables.jpg" />
                        	<img class="pick-overlay" src="images/overlay-x.png" />                           
                        </a>
                    	<a href="#" id="carving-station" class="selectable">
                        	<img class="pick-thumb" src="images/where/carving-station.jpg" />
                        	<img class="pick-overlay" src="images/overlay-x.png" />                           
                        </a>
                    	<a href="#" id="grill" class="selectable">
                        	<img class="pick-thumb" src="images/where/grill.jpg" />
                        	<img class="pick-overlay" src="images/overlay-x.png" />                           
                        </a> 

                    
                    </div>                
                            
                
                
                </div>

            </aside>
            
            <aside id="leaderboard">
                            	
                <ol>
                    <li class="bg">
                        <span class="rank">1</span>
                        <span class="name">JOHNNY</span> 
                        <span class="record">04:30</span>    
                    </li>
                    <li>
                        <span class="rank">2</span>
                        <span class="name">JOHNNY</span> 
                        <span class="record">04:30</span>    
                    </li>
                    
                    <li class="bg">
                        <span class="rank">3</span>
                        <span class="name">JOHNNY</span> 
                        <span class="record">04:30</span>    
                    </li>

                    <li>
                        <span class="rank">4</span>
                        <span class="name">JOHNNY</span> 
                        <span class="record">04:30</span>    
                    </li>
                    <li class="bg">
                        <span class="rank">5</span>
                        <span class="name">JOHNNY</span> 
                        <span class="record">04:30</span>    
                    </li>
                    
                    <li>
                        <span class="rank">6</span>
                        <span class="name">JOHNNY</span> 
                        <span class="record">04:30</span>    
                    </li>
                    
                    <li class="bg">
                        <span class="rank">7</span>
                        <span class="name">JOHNNY</span> 
                        <span class="record">04:30</span>    
                    </li>
                    <li>
                        <span class="rank">8</span>
                        <span class="name">JOHNNY</span> 
                        <span class="record">04:30</span>    
                    </li>
                    
                    <li class="bg">
                        <span class="rank">9</span>
                        <span class="name">JOHNNY</span> 
                        <span class="record">04:30</span>    
                    </li>
                    
                    <li>
                        <span class="rank">10</span>
                        <span class="name">JOHNNY</span> 
                        <span class="record">04:30</span>    
                    </li>                                                
                                                                                                                   

                </ol>
                
                
            </aside>
            
            
            <aside id="congratulations">
            
            	<div class="content">

					<form>
                    	<div>
                            <img src="images/background-square.jpg" />
                            <input type="text" name="name" placeholder="NAME" class="required" maxlength="20" />
                            <span>04:30</span>
                        </div>
                    	<button onClick="_gaq.push(['_trackEvent', 'CLUE', 'entered name', 'Entered name to get coupon']);" class="btn submit-name">SUBMIT NAME <img src="images/icons-buttons/arrow-right.png" /></button>                
                        
                    </form>
                
                </div>
                                
            </aside>            
            
            <aside id="clues">
            	<div class="content">

                    <div class="speech-bubble">
                    	<p>
                        	I smell <span class="highlighted">Spaghetti</span> being eaten in the <span class="highlighted">Game Room</span>.
                        </p>
                    </div>
                    <!--<button class="btn-circular red"><img src="images/icons-buttons/pull-out-arrow-right.png" /></button>-->
                    <img src="" id="clue-character" />
                
                </div>
                
            </aside>
            
            <aside id="guess">
            	
            	<h2>Tell us who did it?</h2>
            
            	<ul>
                	<li class="guess-who">
                    	<div>
							<img src="images/who/chef-green.jpg" data-slug="" class="pick-thumb">                        
                        </div>
                        <h3>WHO?</h3>
                    
                    </li>
                    <li class="guess-what">
                    	<div>
							<img src="images/what/steak-and-salad.jpg" data-slug="" class="pick-thumb">                        
                        </div>
                        <h3>WHAT?</h3>  
                                          
                    </li>                    
                    <li class="guess-where">
                    	<div>
                        	<img src="images/where/fresh-market.jpg" data-slug="" class="pick-thumb">
                        </div>
                        <h3>WHERE?</h3>  
                                          
                    </li>
                
                </ul>
                <button class="btn guess">GUESS! <img src="images/icons-buttons/question-mark.png" /></button>
                
                
            
            </aside>
            
            <aside id="full-overlay" class="translucent">
            
            
            </aside>  
            
            <aside id="partial-overlay" class="translucent">
            
            
            </aside>                      
        
        </div>

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.10.2.min.js"><\/script>')</script>
        <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
        <script src="js/imagesloaded.pkgd.min.js"></script>        
        <script src="js/plugins.js"></script>
        <script src="js/jquery.validate.js"></script>
        <script src="js/main.js"></script>

        <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
		<script>
        var _gaq=[['_setAccount','<?=$analytics?>'],['_trackPageview']];
        (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
        g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
        s.parentNode.insertBefore(g,s)}(document,'script'));
        </script>        

    </body>
</html>