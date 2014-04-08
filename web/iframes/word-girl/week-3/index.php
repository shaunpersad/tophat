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


.popup {
	
    display: none;
    left: 28px;
    position: absolute;
    top: 198px;
    z-index: 2;

}
.puzzle {
	
	background-image: url('images/puzzle.png');
	width: 742px;
	height: 525px;
	margin: 0 auto;
	margin-top: 28px;	
}

.right p {

    font-family: Verdana;
    font-size: 14px;
    font-weight: bold;
    margin-left: 25px;
    margin-right: 65px;
    margin-top: 104px;	
	
}

.hover {
	color: #15a29f;
}
.active, .clicked {
	color: #15a29f;
	background: #ffff99;	
}

.title{
	
	width: 794px;
	margin: 0 auto;
	display:block;
	padding-top: 52px;
	
}
.ice-cream {
	bottom: 33px;
    position: absolute;
    right: 30px;
}
.bottom-left {
	
	position: absolute;
	left: 0;
	bottom: 11px;	
}


.letters {
	
	border: 3px solid black;
	width: 370px;
	height: 346px;
	margin-left: 40px;
	padding: 2px;
	float: left;
}
.padding {
	width: inherit;
	height: 130px;
	text-align:center;
}

.padding p {

    font-family: Verdana;
    font-size: 14px;
    font-weight: bold;
    padding-top: 82px;	
	
}

.letters span {
	
    float: left;
    font-family: "Comic Sans MS",cursive;
    font-size: 15px;
    height: 19px;
    text-align: center;
    text-transform: uppercase;
    width: 20px;
}

.letters .ui-selecting { background: #FECA40; }
.letters .ui-selected { background: #ffff99; color: #15a29f; }

.words {
	float: left;
	list-style: none;
	font-family: "pragmatica-web",sans-serif;
	text-transform:uppercase;	
    margin: 0;
    padding: 0 0 0 30px;
    font-size: 21px;
    line-height: 1.3;		
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

String.prototype.reverse=function(){return this.split("").reverse().join("");}

var letters = 'ZSYHLMEATLOAFIKAPUAPMOYLHKJSSBMOQELSIGUEYXJYSCOSOALDAAUVIULAHNUHTIFRANBCIILIXNWEJHETCSBCTACSDASXPOTATOESDKAAMWSFZADINNEREVEGETABLESXGJSNQJUOIPAOUUNKXTTPLIFRUITZTWCTELYAQNFFORKTIFPAOXSIPRGHWGSVOVKVBKTWYWBEFIVNINHKTRAUYSBXGLJLL';
			   
var words = ['dinner', 
			 'steak', 
			 'meatloaf', 
			 'salad', 
			 'potatoes', 
			 'vegetables', 
			 'sundae', 
			 'stir fry', 
			 'fruit', 
			 'chicken', 
			 'juice', 
			 'fork', 
			 'spoon', 
			 'plate'];			   
var num_wins = 0;

function prepareGame(num_rows, num_cols) {
	
	
	
	$.each(letters.split(''), function(index, letter) {
		
		$('.letters').append('<span>'+letter+'</span>');
		
	});
	$.each(words, function(index, word) {
		
		$('.words').append('<li>'+word+'</li>');
		
	});
	
	var height = $('.letters').height();
	var width = $('.letters').width();
	
	var span_width = width / num_cols;
	var span_height = height / num_rows;
	
	$('.letters span').width(span_width).height(span_height);
	
	$('.letters').selectable({
		stop: function() {
			
			var word = $( ".ui-selected", this ).text().toLowerCase();
			
			var x;
			var original;
			for(x = words.length - 1; x >=0; x--) {
				
				original = words[x].replace(/ /g, '').toLowerCase();
			
				if (word == original || word == original.reverse()) {
				
					$('.words li:eq('+x+')').addClass('hover');	
					$( ".ui-selected", this ).addClass('active');
					num_wins++;
					break;
				}
			}
							
			if (num_wins == words.length) {

				$('.puzzle').delay(500).fadeOut('fast', function() {
					
					$('.popup').fadeIn('slow');
				});					
			}
			
			

		}		
		
	});


}





$(document).ready(function(e) {
 

	prepareGame(15, 15);
    	
	
});


</script>


</head>

<body>

    <div class="wrapper">
    
    	<img class="title" src="images/title.png" />

        <div class="puzzle">
        
        	<div class="padding">
            
            	<p>Click and hold to select the words you find!</p>
            </div>
        
        	<div class="letters"></div>
            <ul class="words">
            </ul>
 
        
        </div>
        <img class="popup" src="images/popup.png" />
        <img class="ice-cream" src="images/ice-cream.png" />
    	<img class="bottom-left" src="images/bottom-left.jpg" />
    </div>

</body>
</html>