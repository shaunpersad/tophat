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
    left: 20px;
    position: absolute;
    top: 33px;
    z-index: 2;
	width: 823px;
	height: 666px;
	background-image: url('images/popup.png');

}
.puzzle {
	
	background-image: url('images/puzzle.png');
	width: 784px;
	height: 626px;
    position: absolute;	
    left: 15px;
    top: 45px;
}

.puzzle p {

    font-family: Verdana;
    font-size: 14px;
    font-weight: bold;
    margin-left: 15px;
    margin-top: 90px;	
	margin-right: 15px;
}

.hover {
	color: #15a29f;
}
.active, .clicked {
	color: #15a29f;
	background: #ffff99;	
}

.title {
	
	width: 368px;
	height: 129px;
	display:block;
	position: absolute;
	left: 45px;
	top: 70px;
	
}

.bottom-left {
	
	position: absolute;
	left: 0;
	bottom: 11px;	
}

.words {
		
	width: 370px;
	height: 610px;
	margin-left: 413px;		
	font-family: "pragmatica-web",sans-serif;
    font-size: 21px;
    line-height: 1.3;
	padding-left:10px;
}

.words span, .words input {
	height: 22px;
	display: block;
	text-align: center;	
	float: left;
	text-transform:uppercase;
}
.words span {
	margin-bottom: 20px;
	width: 22px;
	
}
.words input {
	display: none;
	border: 1px solid dashed;
	width: 16px;
		
}
.sentence {
	
	margin: 0 auto;
	clear: both;
	
}
.paragraph-1 {
	margin: 0 auto;
}
.paragraph-2 {
	margin: 0 auto;
	margin-top: 110px;
}
.submit_button {

	display:block;
	width: 125px;
	height: 73px;
	background-image:url('images/submit.png');
    text-indent: -9999px;
	background-color: transparent;
	font-size: 0;
	line-height: 0;
	border:none;
	margin: 0 auto;
	margin-top: 10px;	
}
.name,.phrase {
	width: 310px;
	height: 40px;
	border: 3px solid black;
	display:block;
	margin: 0 auto;
	font-family:"Comic Sans MS", cursive;
	font-style:italic;
	padding: 3px;
}
.phrase {
	
	margin-top: 90px;	
}

.popup form {
	
	width: 345px;
	height: 300px;
    padding-left: 438px;
    padding-top: 260px;
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


var paragraph_1 = ['g:o:od f:o:od.','g:o:od fr:i:ends.','g:o:od t:im:es.'];
var paragraph_2 = ['j:o:in :us f:or', 'f:am:ily n:ight', ':ev:ery th:ursd:ay!'];

function prepareGame() {
	
	var sentence_div;
	var letters;
	var index;
	var letter;
	var span;
	
	
	$.each(paragraph_1, function(index, sentence) {

		sentence_div = $('<div class="sentence"></div>');
		letters = sentence.split('');
		index = 0;
		
		while (index < letters.length) {
			
			letter = letters[index];
			span = $('<span></span>');
			
			if (letter == ':') {
				
				index++;
				span.addClass('missing').attr('data-missing', letters[index]).html('_');
				sentence_div.append('<input type="text" maxlength="1" />');
			} else if(letter == '.') {
				
				span.css('text-align', 'left').html(letter);					
			} else if(letter == '!') {
				
				span.css('text-align', 'left').html(letter);					
			} else {
			
				span.html(letter);	
			}
			
			sentence_div.append(span);						
			index++;		
		}
		
		sentence_div.width(sentence_div.find('span').length * 22);		
		$('.paragraph-1').append(sentence_div);		
			
	});

	
	$.each(paragraph_2, function(index, sentence) {
		
		sentence_div = $('<div class="sentence"></div>');
		letters = sentence.split('');
		index = 0;
		
		while (index < letters.length) {
			
			letter = letters[index];
			span = $('<span></span>');		
			
			if (letter == ':') {
				
				index++;
				span.addClass('missing').attr('data-missing', letters[index]).html('_');
				sentence_div.append('<input type="text" maxlength="1" />');
			} else if(letter == '.') {
				
				span.css('text-align', 'left').html(letter);					
			} else if(letter == '!') {
				
				span.css('text-align', 'left').html(letter);					
			} else {
			
				span.html(letter);	
			}
			
			sentence_div.append(span);						
			index++;			
		}			
		sentence_div.width(sentence_div.find('span').length * 22);	
		$('.paragraph-2').append(sentence_div);		
			
	});
	
	
	$('.missing').click(function() {
		
		$(this).fadeOut('fast', function() {
			
			$(this).prev('input').show().focus();
		});
		
	});
	
	$('.words input').blur(function() {
		
		var missing_letter = $(this).next('.missing').attr('data-missing');

		$(this).fadeOut('fast', function() {

			$(this).next('.missing').show();			

			if (missing_letter == $(this).val()) {
				
				$(this).next('.missing').html(missing_letter).unbind('click').addClass('hover').effect("highlight", {}, 1200).removeClass('missing');
				
				var index = parseInt($('.words input').index(this)) + 1;
				
				if ($('.words input:eq('+index+')').length && $('.words input:eq('+index+')').next('.missing').length) {
					
					$('.words input:eq('+index+')').next('.missing').click();
				}
				
				if (!$('.missing').length) {
					
					$('.puzzle').delay(500).fadeOut('fast', function() {
						
						$('.popup').fadeIn('slow');
					});
					
				}
				
			}
		});
		
	}).keyup(function(event) {

		if (event.keyCode != 9) { 
		
			var missing_letter = $(this).next('.missing').attr('data-missing');
			if (missing_letter == $(this).val()) {
				
				$(this).blur();
			}
		}
		
	}).keydown(function(event) {
		// 9 == tab key code
		if (event.keyCode == 9) { 
			// Find the dropdown ...
			
			var index = parseInt($('.words input').index(this)) + 1;
			
			if ($('.words input:eq('+index+')').length && $('.words input:eq('+index+')').next('.missing').length) {
				
				$('.words input:eq('+index+')').next('.missing').click();
			}
			return false;
		}
    });
	
	$('.popup form').submit(function(e) {
        
		e.preventDefault();
		
		var words = ['super', 'vocabulary', 'power', 'punch'];
		
		if ($('.popup .phrase').val().toLowerCase().replace(/\s+/g,"") == words.join('')) {
	
			var url = 'coloring-sheet.php?name='+$('.name').val();
	
			try {
				
				var win=window.open(url, '_blank');
				win.focus();					
			
			} catch(err) {
			
				window.location = url;
			}			

		} else {
			$('.popup .phrase').val('Incorrect phrase.');
		}
		
		return false;
		
    });

}





$(document).ready(function(e) {
 

	prepareGame();
	
	
    	
	
});


</script>


</head>

<body>

    <div class="wrapper">
    
    	<img class="title" src="images/title.png" />

        <div class="puzzle">
        	<div class="words">
        		<p>Click each space below to enter the missing letter!</p>
            	<div class="paragraph-1"></div>
                <div class="paragraph-2"></div>
            </div>
        
        </div>
        <div class="popup">
        
        	<form>
            	<input type="text" class="name" />
            	<input type="text" class="phrase" />
                <input type="submit" class="submit_button" value="submit"/>
            </form>
        
        </div>
    	<img class="bottom-left" src="images/bottom-left.jpg" />
    </div>

</body>
</html>