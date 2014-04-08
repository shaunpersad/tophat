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
}
.left {
	position: absolute;
	margin-top: 65px;
	z-index: 1;
} 
.right {
	
	width: 417px;
	height: 612px;
	background-image:url('images/puzzle.png');
	float: right;
	margin-right: 10px;
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
	font-size:25px;
	text-transform:uppercase;
	margin-top: -35px;
	margin-left: 45px;
	
}
.game span {
	
	width: 22px;
	display: block;
	float: left;	
	text-align: center;
}
.game > .word-row {
	padding-bottom: 5px;
}
.hover, .active {
	color: #15a29f;
}
.scrambled {
	position:absolute;
	bottom: 6px;
	
}
.unscrambled {
	
}
.word-row {
	position: relative;
	
}
.letters {
	
	padding-right: 22px;	
	float: left;
}
.right p {

    font-family: Verdana;
    font-size: 14px;
    font-weight: bold;
    margin-left: 25px;
    margin-right: 65px;
    margin-top: 104px;	
	
}
.scrambled span {
	cursor:pointer;
}

</style>
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

String.prototype.shuffle = function () {
    var a = this.split(""),
        n = a.length;

    for(var i = n - 1; i > 0; i--) {
        var j = Math.floor(Math.random() * (i + 1));
        var tmp = a[i];
        a[i] = a[j];
        a[j] = tmp;
    }
    return a.join("");
}

var num_wins = 0;
var words = ['omelets', 'steak', 'meatloaf', 'fried chicken', 'vegetables', 'carrot cake'];

function prepareGame(words) {
		

	$.each(words, function(index, word) {
				
		var x;
		var character;		
		var unscrambled_word;
		var scrambled_word;		
		var pos = index + 1;
		var row_class = 'word_row_'+pos;
		var row = $('<div></div>').addClass(row_class).addClass('word-row');
		row.html('<div class="scrambled"></div><br /><div class="unscrambled"></div><br />');
		row.appendTo('.game');
		
		var apart = word.split(' ');	
		var unscrambled = '';
		var scrambled = '';
		
		$.each(apart, function(index, w) {
			
			var unscrambled_word = w;
			var scrambled_word = w.shuffle();
			
			unscrambled+='<div class="unscrambled-container letters">';
			scrambled+='<div class="scrambled-container letters">';	
		
			for (x = 0; x < scrambled_word.length; x++) {
				
				character = scrambled_word.charAt(x);
				
				unscrambled+='<span>_</span>';
				scrambled+='<span>'+character+'</span>';
			}	
			unscrambled+='</div>';
			scrambled+='</div>';
		});
		$('.'+row_class+' .unscrambled').append(unscrambled);
		$('.'+row_class+' .scrambled').append(scrambled);


		$( "."+row_class+" .scrambled-container" ).sortable({ 
			cursor: "move",
			//cursorAt: { bottom: 0, right: 0 },
			start: function( event, ui ) {
				
				var index = $(this).closest('.word-row').find('.scrambled-container').index(ui.item.parent('.scrambled-container'));
				$(this).closest('.word-row').find('.unscrambled-container:eq('+index+')').addClass('hover');

				
				ui.item.addClass('hover');
				
			},
			stop: function( event, ui ) {

				$(this).closest('.word-row').find('.unscrambled-container').removeClass('hover');
				ui.item.removeClass('hover');
				
				var index = $('.game .word-row').index($(this).closest('.word-row'));
				
				if ($(this).closest('.scrambled').text() == words[index].replace(' ', '')) {
					
					
					$(this).closest('.scrambled').effect("highlight", {}, 1200, function() {
					
						$(this).addClass('hover');	
						num_wins++;
						
						if (num_wins == words.length) {
							
							$('.right').delay(500).fadeOut('fast', function() {
								
								$('.popup').fadeIn('slow');
							});
							
						}						
						
					});
					$(this).sortable( "option", "disabled", true );
					
				}
								
				
			}
		});	
			
	});

		
}


$(document).ready(function(e) {
    	
	prepareGame(words);
	
});

</script>


</head>

<body>

    <div class="wrapper">
    	<img class="left" src="images/left.png" />
        <div class="right">
 			<p>Help us unscramble them by dragging and dropping the letters in the right order!</p>       
            <div class="game">
            
            
            
            
            </div>
        
        </div>
        <img class="popup" src="images/popup.png" />
    
    </div>

</body>
</html>