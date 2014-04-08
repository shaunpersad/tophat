<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Untitled Document</title>
<style>

/* HTML5 Boilerplate  */

article, aside, details, figcaption, figure, footer, header, hgroup, nav, section { display: block; }
audio, canvas, video { display: inline-block; *display: inline; *zoom: 1; }
audio:not([controls]) { display: none; }
[hidden] { display: none; }

html { font-size: 100%; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
html, button, input, select, textarea { font-family: sans-serif; color: #222; }
body { margin: 0; font-size: 1em; line-height: 1.4; }

::-moz-selection { background: #fe57a1; color: #fff; text-shadow: none; }
::selection { background: #fe57a1; color: #fff; text-shadow: none; }

a { color: #00e; }
a:visited { color: #551a8b; }
a:hover { color: #06e; }
a:focus { outline: thin dotted; }
a:hover, a:active { outline: 0; }
abbr[title] { border-bottom: 1px dotted; }
b, strong { font-weight: bold; }
blockquote { margin: 1em 40px; }
dfn { font-style: italic; }
hr { display: block; height: 1px; border: 0; border-top: 1px solid #ccc; margin: 1em 0; padding: 0; }
ins { background: #ff9; color: #000; text-decoration: none; }
mark { background: #ff0; color: #000; font-style: italic; font-weight: bold; }
pre, code, kbd, samp { font-family: monospace, serif; _font-family: 'courier new', monospace; font-size: 1em; }
pre { white-space: pre; white-space: pre-wrap; word-wrap: break-word; }

q { quotes: none; }
q:before, q:after { content: ""; content: none; }
small { font-size: 85%; }
sub, sup { font-size: 75%; line-height: 0; position: relative; vertical-align: baseline; }
sup { top: -0.5em; }
sub { bottom: -0.25em; }

ul, ol { margin: 1em 0; padding: 0 0 0 40px; }
dd { margin: 0 0 0 40px; }
nav ul, nav ol { list-style: none; list-style-image: none; margin: 0; padding: 0; }

img { border: 0; -ms-interpolation-mode: bicubic; vertical-align: middle; }
svg:not(:root) { overflow: hidden; }
figure { margin: 0; }

form { margin: 0; }
fieldset { border: 0; margin: 0; padding: 0; }

label { cursor: pointer; }
legend { border: 0; *margin-left: -7px; padding: 0; white-space: normal; }
button, input, select, textarea { font-size: 100%; margin: 0; vertical-align: baseline; *vertical-align: middle; }
button, input { line-height: normal; }
button, input[type="button"], input[type="reset"], input[type="submit"] { cursor: pointer; -webkit-appearance: button; *overflow: visible; }
button[disabled], input[disabled] { cursor: default; }
input[type="checkbox"], input[type="radio"] { box-sizing: border-box; padding: 0; *width: 13px; *height: 13px; }
input[type="search"] { -webkit-appearance: textfield; -moz-box-sizing: content-box; -webkit-box-sizing: content-box; box-sizing: content-box; }
input[type="search"]::-webkit-search-decoration, input[type="search"]::-webkit-search-cancel-button { -webkit-appearance: none; }
button::-moz-focus-inner, input::-moz-focus-inner { border: 0; padding: 0; }
textarea { overflow: auto; vertical-align: top; resize: vertical; }
input:valid, textarea:valid { }
input:invalid, textarea:invalid { background-color: #f0dddd; }

table { border-collapse: collapse; border-spacing: 0; }
td { vertical-align: top; }	
	


.wrapper {
	width: 859px;
	height: 712px;
	background-image:url('images/background.jpg');
	position:relative;
    margin: 0 auto;
}
.left {
	position: absolute;
	margin-top: 65px;
	z-index: 1;
} 
.right {
	
	width: 369px;
	height: 450px;
	background-image:url('images/puzzle.png');
	float: right;
	margin-right: 70px;
	margin-top: 45px;
}
.popup {
	
	position: absolute;
	top: 60px;
	right: 8px;
	z-index: 2;
	display:none;

}
.game {
	
	font-family: "pragmatica-web",sans-serif;
	font-size:22px;
	text-transform:uppercase;
	margin-top: -35px;
	margin-left: 45px;
	
}
.right p {

    font-family: Verdana;
    font-size: 14px;
    font-weight: bold;
    margin-left: 25px;
    margin-right: 65px;
    margin-top: 104px;	
	
}

.hover, .active {
	color: #15a29f;
}

.left-list, .right-list {

	list-style: none;
	float: left;
	padding-top: 10px;	
}
.left-list {

	padding-left: 10px !important;	
}
.right-list {

	padding-left: 35px !important;	
	
}
.left-list li, .right-list li {
	cursor:pointer;	
}

</style>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
 <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script type="text/javascript" src="//use.typekit.net/xiq2lxl.js"></script>
<script type="text/javascript">try{Typekit.load();}catch(e){}</script>
<script>


if (!Array.prototype.indexOf) {
	Array.prototype.indexOf = function(obj, start) {
		 for (var i = (start || 0), j = this.length; i < j; i++) {
			 if (this[i] === obj) { return i; }
		 }
		 return -1;
	}
}

var list_1 = ['crunchy', 'tasty', 'dinner', 'plate', 'cup', 'drink', 'sweets', 'chef'];
var list_2 = ['crispy', 'delicious', 'supper', 'dish', 'glass', 'beverage', 'dessert', 'cook'];

function shuffle(array) {
    var counter = array.length, temp, index;

    // While there are elements in the array
    while (--counter > -1) {
        // Pick a random index
        index = ~~(Math.random() * counter);

        // And swap the last element with it
        temp = array[counter];
        array[counter] = array[index];
        array[index] = temp;
    }

    return array;
}


function prepareGame(random_1, random_2) {

	var left_list = $('<ul class="left-list"></ul>');	
	var right_list = $('<ul class="right-list"></ul>');	
	
	$.each(random_1, function(index, word) {
		
		left_list.append('<li data-array-index="'+list_1.indexOf(word)+'">'+word+'</li>');
	});
	
	$.each(random_2, function(index, word) {
		
		right_list.append('<li data-array-index="'+list_2.indexOf(word)+'">'+word+'</li>');
	});	
	
	$('.game').append(left_list).append(right_list);





	$('.left-list, .right-list').sortable({
		cursor: "move",
		start: function( event, ui ) {
			
			ui.item.addClass('hover');
			
		},
		stop: function( event, ui ) {
			ui.item.removeClass('hover');
			
			var list_index = $(this).closest('ul').find('li').index(ui.item);
			
			var left_word;
			var right_word;
			var num_wins = 0;
			$('.left-list li').each(function(index, element) {
				
				left_word = $(this);
				right_word = $('.right-list li:eq('+index+')');	
							
				if (list_1.indexOf(left_word.text()) == list_2.indexOf(right_word.text())) {
					
					left_word.addClass('hover');
					right_word.addClass('hover');
					num_wins++;
					
					if (index == list_index) {
							
						$('.left-list li:eq('+index+'), .right-list li:eq('+index+')').effect("highlight", {}, 1200, function() {
											
							if (num_wins == list_1.length) {
								
								$('.right').fadeOut('fast', function() {
									
									$('.popup').fadeIn('slow');
								});
								
							}						
							
						});					
						

						
					}
				
					
				} else {

					left_word.removeClass('hover');
					right_word.removeClass('hover');
					
				}
				
            });

		}
	});
	
	
}





$(document).ready(function(e) {
 

	var num_ran = 0;

	var keep_shuffling = true;
	var y;
	var random_1;
	var random_2;
	outer_loop:
	while(keep_shuffling) {

		keep_shuffling = false;
		random_1 = shuffle(list_1.slice(0));
		random_2 = shuffle(list_2.slice(0));
		var word_1;
		var word_2;
		var index_1;
		var index_2;
		
		for (y = list_1.length - 1; y >= 0; y--) {
			
			word_1 = random_1[y];
			word_2 = random_2[y];
						
			index_1 = list_1.indexOf(word_1);
			index_2 = list_2.indexOf(word_2);
			
			if (index_1 == index_2) {
				
				keep_shuffling = true;
			}
		}	
	} 
	 
		prepareGame(random_1, random_2);
    	
	
});


</script>


</head>

<body>

    <div class="wrapper">
    	<img class="left" src="images/left.png" />
        <div class="right">
 			<p>Drag and drop the words below so the synonyms are matched next to each other!</p>       
            <div class="game">

            
            </div>
        
        </div>
        <img class="popup" src="images/popup.png" />
    
    </div>

</body>
</html>