
var showed_info_overlay = false;

var current_article_id = '#home';

var map = new Object();
var whos = new Array();
var whats = new Array();
var wheres = new Array();

var clues_whos = new Array();
var clues_whats = new Array();
var clues_wheres = new Array();

var timer = false;

var winner = new Object();

function showArticle(article_id) {
	
	$('aside').hide();
	$('article').hide();
	$('.polaroid-who').hide();
	$('.polaroid-what').hide();
	$('.icon-correct').hide();
	$(article_id).fadeIn('fast', function() {
		
		if (article_id == '#home') {
			
			$('#folder-rules').removeClass('showing').removeClass('hiding').addClass('peeking').show();	
			$('.close-folder-rules').hide();
			$('.open-folder-rules').show();
			pauseTimer();
			start = false;		
			
		} else if (article_id == '#station') {
	
			makeClue();
			
			addPenaltyTime(10);
					
			$('#folder-clue-sheet').removeClass('showing').removeClass('hiding').addClass('peeking').show();
			$('#folder-clue-sheet').switchClass( "peeking", "showing", 500 );
			$('.speech-bubble').hide();
			$('#clues .content .btn-circular').hide();
			$('#clues').hide().css('bottom', -$('#clues').height()).show().delay(400).animate({bottom: 0}, 'slow', function() {
				
				$('.speech-bubble').fadeIn('slow', function() {
					
					$('#clues .content .btn-circular').fadeIn('fast');
				});
			});
			
		} else if (article_id == '#map' && !showed_info_overlay) {
			
			$('#info-overlay').addClass('showing').fadeIn(200);	
			showed_info_overlay = true;	
			
		} else if (article_id == '#incorrect' || article_id == '#correct') {
				
			$(article_id+' .polaroid-who').delay(200).fadeIn('slow', function() {
				
				$(article_id+' .icon-correct').fadeIn('fast');	
			});
	
			$(article_id+' .polaroid-what').fadeIn('slow');
			
			if (article_id == '#incorrect') {
				
				addPenaltyTime(30);	
			} else {
			
				pauseTimer();	
			}
	
			
		} else if (article_id == '#print') {
	
			$('#congratulations span').text($('.timer .time').first().text());
			$('#congratulations').delay(200).fadeIn('fast');	
			$('#full-overlay').show();	
			
		}
		
		current_article_id = article_id;

		
	});	
	
}



function printElem(old_elem) {
	var elem = $(old_elem).clone();
	
	elem.find('nav').remove();
	
	elem.find('section').css({
			"position": "relative",
    		"text-align": "center"
			});
	
	elem.find('img').css({ 
						"left": 0, 
						"position": "absolute", 
						"top": 0, 
						"z-index": 1
						});

	elem.find('span').css({
							"display": "block", 
							"font-family": "cubanoregular", 
							"font-size": "45px", 
							"padding-top": "315px", 
							"position": "relative", 
							"z-index": 2
						});

	
	printContainer( elem.html(), 'css/main.css');
}

function printContainer(content, styleSheet) {
	var output = document.getElementById("ifrOutput").contentWindow;
	output.document.open();
	if (styleSheet !== undefined) {
	
		output.document.write('<link href="css/fonts/cubano/stylesheet.css" rel="stylesheet" type="text/css" />');
	}
	output.document.write(content);
	output.document.close();
	output.focus();
	output.print();
}

function escapeRegExp(str) {
	return str.replace(/[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g, "\\$&");
}

function replaceAll(find, replace, str) {
	
	return str.replace(new RegExp(escapeRegExp(find), 'g'), replace);
}

function ucwords (str) {
  return (str + '').replace(/^([a-z\u00E0-\u00FC])|\s+([a-z\u00E0-\u00FC])/g, function ($1) {
    return $1.toUpperCase();
  });
}

function addSeconds (date, seconds) {
	

    return new Date(date.getTime() + seconds*1000);
}

function stringLeadingZeroes(num) {
    return ( num < 10 ? "0" : "" ) + num;
}

function addPenaltyTime(added_seconds) {
	
	pauseTimer();
	
	var start = new Date();
	
	var old_time_string = $('.timer .time').first().text();
	var explode = old_time_string.split(':');
	var old_minutes = parseInt(explode[0]);
	var old_seconds = parseInt(explode[1]);
	
	
	start.setMinutes(old_minutes, old_seconds);		
	start = addSeconds(start, added_seconds);

	$('.additions .addition').text(added_seconds);
	
	$('.additions').removeClass('top-spot').addClass('bottom-spot').show().switchClass('bottom-spot', 'top-spot', 1000).fadeOut(1000);
	
	var total_seconds = start / 1000;   
	
	var hours = Math.floor(total_seconds / 3600);
	total_seconds = total_seconds % 3600;
	
	var minutes = Math.floor(total_seconds / 60);
	total_seconds = total_seconds % 60;
	
	var seconds = Math.floor(total_seconds);
	
	//hours = stringLeadingZeroes(hours);
	minutes = stringLeadingZeroes(minutes);
	seconds = stringLeadingZeroes(seconds);
	
	//var time_string = hours + ":" + minutes + ":" + seconds;
	var time_string = minutes + ':' + seconds;
	
	$('.timer .time').text(time_string);	
	
	startTimer();
}


function startTimer() {
	

	var start = new Date();
	
	var old_time_string = $('.timer .time').first().text();
	var explode = old_time_string.split(':');
	var old_minutes = parseInt(explode[0]);
	var old_seconds = parseInt(explode[1]);
	
	
	start.setMinutes(old_minutes, old_seconds);
	
	timer = setInterval(function() {
		
		start = addSeconds(start, 1);
		
		var total_seconds = start / 1000;   
		
		var hours = Math.floor(total_seconds / 3600);
		
		
		total_seconds = total_seconds % 3600;
		
		var minutes = Math.floor(total_seconds / 60);
		
		if (minutes > 55) {
			
			window.location.reload();
			return;	
		}
		
		
		total_seconds = total_seconds % 60;
		
		var seconds = Math.floor(total_seconds);
		
		//hours = stringLeadingZeroes(hours);
		minutes = stringLeadingZeroes(minutes);
		seconds = stringLeadingZeroes(seconds);
		
		//var time_string = hours + ":" + minutes + ":" + seconds;
		var time_string = minutes + ':' + seconds;
		
		$('.timer .time').text(time_string);
	}, 1000);
	
}

function pauseTimer() {
	
	if (timer) {

		clearInterval(timer);		
	}	
}


function initializeGame() {
	
	winner['who'] = whos[Math.floor(Math.random() * whos.length)];
	winner['what'] = whats[Math.floor(Math.random() * whats.length)];
	winner['where'] = wheres[Math.floor(Math.random() * wheres.length)];
	
	console.log(winner);
}

function pickWho() {

	var result = false;
	
	if (clues_whos.length < whos.length - 1) { // pick from all whos who arent the answer

		result = whos[Math.floor(Math.random() * whos.length)];
		while (result == winner['who'] || $.inArray(result, clues_whos) > -1) {
			
			result = whos[Math.floor(Math.random() * whos.length)];		
		}
		clues_whos.push(result);							
		
	} else { //all whos have been picked, so pick from existing clues
		result = clues_whos[Math.floor(Math.random() * clues_whos.length)];			
	}	
	
	return result;
}

function pickWhat() {

	var result = false;
	
	if (clues_whats.length < whats.length - 1) { // pick from all whats who arent the answer

		result = whats[Math.floor(Math.random() * whats.length)];
		while (result == winner['what'] || $.inArray(result, clues_whats) > -1) {
			
			result = whats[Math.floor(Math.random() * whats.length)];		
		}							
		clues_whats.push(result);
	} else { //all whats have been picked, so pick from existing clues
		result = clues_whats[Math.floor(Math.random() * clues_whats.length)];			
	}	
	
	return result;
	
}

function pickWhere() {

	var result = false;
	
	if (clues_wheres.length < wheres.length - 1) { // pick from all whos who arent the answer

		result = wheres[Math.floor(Math.random() * wheres.length)];
		while (result == winner['where'] || $.inArray(result, clues_wheres) > -1) {
			
			result = wheres[Math.floor(Math.random() * wheres.length)];		
		}							
		clues_wheres.push(result);
	} else { //all whos have been picked, so pick from existing clues
		result = clues_wheres[Math.floor(Math.random() * clues_wheres.length)];			
	}	
	
	return result;	
	
}


function makeClue() {

	var choice = 0;

	if (clues_whos.length == clues_whats.length && clues_whos.length == clues_wheres.length) {
	
		choice =  Math.floor((Math.random()*10)) % 3; 
	
	} else {
	
		var clues_counts = [clues_whos.length, clues_whats.length, clues_wheres.length];
	
		clues_counts.sort();
		
		var least_clues = clues_counts[0];
		var second_least_clues = clues_counts[1];
		
		if ((clues_whos.length == least_clues && clues_wheres.length == second_least_clues) ||
		 	(clues_wheres.length == least_clues && clues_whos.length == second_least_clues)) {
			
			choice = 2;
		
		} else if ((clues_whos.length == least_clues && clues_whats.length == second_least_clues) ||
		 		  (clues_whats.length == least_clues && clues_whos.length == second_least_clues)) {
			
			choice = 1;
		
		}		
	}
			
	/*
		I heard (character) in the (station).
		I saw (character) eating (plate).
		I smelled (plate) near the (station).		
	*/
	var who = '';
	var what = '';
	var where = '';
		
	var clue_string = '';
	
	if (choice == 2) { 
		
		who = pickWho();
		where = pickWhere();
		
		setTimeout(function() {
		
			$('#'+who+' .pick-overlay').fadeIn('fast').closest('a').removeClass('selectable');
			$('#'+where+' .pick-overlay').fadeIn('fast').closest('a').removeClass('selectable');		
		}, 3000);	
		
		clue_string = 'I heard <span class="highlighted">'+ map[who] +'</span> at the <span class="highlighted">'+ map[where]+ '</span>.';	

	} else if (choice == 1) {
		
		who = pickWho();
		what = pickWhat();
		
		setTimeout(function() {
		
			$('#'+who+' .pick-overlay').fadeIn('fast').closest('a').removeClass('selectable');
			$('#'+what+' .pick-overlay').fadeIn('fast').closest('a').removeClass('selectable');
				
		}, 3000);
		
		clue_string = 'I saw <span class="highlighted">'+ map[who] +'</span> eating <span class="highlighted">'+ map[what]+ '</span>.';	
				
	} else {
		
		what = pickWhat();
		where = pickWhere();
		
		setTimeout(function() {
		
			$('#'+what+' .pick-overlay').fadeIn('fast').closest('a').removeClass('selectable');
			$('#'+where+' .pick-overlay').fadeIn('fast').closest('a').removeClass('selectable');	
				
		}, 3000);
				
		clue_string = 'I smelled <span class="highlighted">'+ map[what] +'</span> near the <span class="highlighted">'+ map[where]+ '</span>.';	
	}	
	
	$('#clues .speech-bubble p').html(clue_string);
	
	var character = whos[Math.floor(Math.random() * whos.length)];
	
	if (who) {
		
		while (who == character) {
			
			character = whos[Math.floor(Math.random() * whos.length)];
		}
			
	}
	
	$('#clue-character').attr('src', 'images/who/clue-'+character+'.png');
}



$(document).ready(function(e) {
	
	$('#leaderboard').load('get-leaderboard.php');
	
	$('.wrapper').imagesLoaded(function() {
		
		$('.wrapper').show();
		
		$('#home > img').animate({marginLeft: 0}, 400, 'easeOutQuint', function() {
			
			$('#home .btn.investigate').fadeIn('slow');
		});
		
	});
	
		
	$('#folder-clue-sheet .select a').each(function(index, element) {
		
		var slug = $(this).attr('id');
		
		var $select = $(this).closest('.select');
		
		if ($select.hasClass('pick-who')) {
			
			whos.push(slug);
		} else if ($select.hasClass('pick-what')) {
			
			whats.push(slug);
		} else if ($select.hasClass('pick-where')) {
			
			wheres.push(slug);
		}
		
	
		if (slug == 'chicken') {
			
			map[slug] = 'Fried Chicken & Mashed Potatoes';
			
			
		} else if (slug == 'steak-and-salad') {
			
			map[slug] = 'Steak & Salad';
			
		} else {

			var display = replaceAll('-', ' ', slug );		
			map[slug] = ucwords(display);						
		}
	
		
	});
	
	initializeGame();	
	

	$('#congratulations form').validate({
		submitHandler: function(form) {
			
			var name = $('#congratulations form input[type="text"]').val();
			var time = $('.timer .time').first().text();
			
			var data = { name: name, time: time };
	
			$('#congratulations').fadeOut('fast');
			$('#full-overlay').hide();
			$('#print .print-name').html(name);
			
			$.post('save-time.php', data, function(response) {
				
				$('#leaderboard').html(response);
			});
		}
	});


	
	$(document).on('click', 'button.go-to-page', function(e) {
		
		e.preventDefault();
		
		var id = $(this).attr('data-page');
		
		showArticle(id);
		
	}).on('click', 'a.go-to-page', function(e) {
		
		e.preventDefault();
		
		var id = $(this).attr('href');
		
		showArticle(id);
		
	}).on('mouseenter', '#map section a', function(e) {
		
		e.preventDefault();
		
		var id = $(this).attr('id');
		
		if (id == 'overlay-dining-tables-1' || id == 'overlay-dining-tables-2') {
			
			$('#overlay-dining-tables-1,#overlay-dining-tables-2').addClass('hover');
		} else {
			
			$(this).addClass('hover')	
		}
		
		
		
	}).on('mouseleave', '#map section a', function() {
		
		var id = $(this).attr('id');
		
		if (id == 'overlay-dining-tables-1' || id == 'overlay-dining-tables-2') {

			$('#overlay-dining-tables-1,#overlay-dining-tables-2').removeClass('hover');
		} else {
			
			$(this).removeClass('hover')	
		}

	}).on('click', '#map section a', function(e) {
		
		e.preventDefault();
		
		var id = $(this).attr('id').replace('overlay-', '');

		if (id == 'dining-tables-1' || id == 'dining-tables-2') {

			id = 'dining-tables';
			$('#overlay-dining-tables-1, #overlay-dining-tables-2').addClass('visited');			
		} else {
			
			$(this).addClass('visited');		
		}
		
		$('#station section').css('background-image', 'url("images/where/background-'+id+'.jpg")');


	}).on('click', '.btn.start', function(e) {
		
		e.preventDefault();
		
		$('#info-overlay').removeClass('showing').hide();
		
		startTimer();
			
		
	}).on('click', '.open-folder-rules', function(e) {
		
		e.preventDefault();
		
		pauseTimer();
		
		$('#full-overlay').show();
		
		$('#folder-rules').show().switchClass('hiding', 'peeking', 500, function () {
			
			$(this).switchClass( "peeking", "showing", 500 );
		});
		
		$(this).hide();		
		$('.close-folder-rules').show();
		
	}).on('click', '.close-folder-rules', function(e) {
		
		e.preventDefault();
		
		$('#full-overlay').hide();
		
		if (current_article_id == '#home') {
			
			$('#folder-rules').switchClass( "showing", "peeking", 500 );
			
		} else {
			$('#folder-rules').switchClass( "showing", "peeking", 500, function() {
				
				$(this).switchClass('peeking', 'hiding', function() {
					
					startTimer();	
				});
			});
		}		
		$(this).hide();		
		$('.open-folder-rules').show();		
		
	}).on('click', 'nav button.guess', function(e) {
		
		e.preventDefault();
		
		if ($('#guess').is(':visible')) {
			
			$('#guess').fadeOut('fast');
			$('#partial-overlay').hide();
			
			if (current_article_id != '#station') {
							
				$('#folder-clue-sheet').removeClass('peeking').removeClass('hiding');
				$('#folder-clue-sheet').switchClass( "showing", "peeking", 500, function() {
					$('#folder-clue-sheet').switchClass( "peeking", "hiding", 500);					
				});					
			}
			
			
			
		} else {
			$('.guess-who img').attr('src', '').attr('data-slug', '').hide();
			$('.guess-what img').attr('src', '').attr('data-slug', '').hide();
			$('.guess-where img').attr('src', '').attr('data-slug', '').hide();
			
			
			$('#guess').fadeIn('fast');
			$('#partial-overlay').show();
			
			if (current_article_id != '#station') {
				
				$('#folder-clue-sheet').removeClass('showing').removeClass('hiding').addClass('peeking').show();
				$('#folder-clue-sheet').switchClass( "peeking", "showing", 500 );				
			}			

		}		
		
	}).on('click', '#guess button.guess', function(e) {
		
		e.preventDefault();
		
		var who = $('.guess-who img').attr('data-slug');
		var what = $('.guess-what img').attr('data-slug');
		var where = $('.guess-where img').attr('data-slug');
		
		if (who.length && what.length && where.length) {
		
			$('.polaroid-who').attr('src', 'images/who/polaroid-'+who+'.png');
			$('.polaroid-what').attr('src', 'images/what/polaroid-'+what+'.png');
			$('#correct section, #incorrect section').css('background-image', 'url("images/where/background-'+where+'.jpg")');	
					
			if (who == winner['who'] && what == winner['what'] && where == winner['where']) {
								
				showArticle('#correct');						
			} else {
				
				showArticle('#incorrect');						
			}
			
		}
				
	}).on('click', '.btn.play-again', function(e) {
		
		e.preventDefault();
		
		window.location.reload();
			
	}).on('click', '.btn.the-rules', function(e) {
		
		e.preventDefault();
		$('.open-folder-rules').click();
	}).on('click', '.btn.print', function(e) {
		
		e.preventDefault();
		
			printElem($('#print'));		
		
	}).on('click', '.btn.leaderboard', function(e) {
		
		e.preventDefault();
		
		if ($('#leaderboard').is(':visible')) {
			
			$('#leaderboard').fadeOut('fast', function() {
				
				startTimer();	
			});
			$('#partial-overlay').hide();
			
			$('nav .btn').prop('disabled', false);						
			
			
		} else {
			
			pauseTimer();
			
			$('#leaderboard').fadeIn('fast');
			$('#partial-overlay').show();
			
			$('nav .btn').prop('disabled', true);						
			
			$('nav .btn.leaderboard').prop('disabled', false);
		}
				
		
	}).on('click', '.select.pick-who .selectable', function(e) {
		
		e.preventDefault();
		
		var src =  $(this).find('.pick-thumb').attr('src');
		var slug = $(this).attr('id');

		if (!$('#guess').is(':visible')) {
				
			$('.guess-what img').attr('src', '').attr('data-slug', '').hide();
			$('.guess-where img').attr('src', '').attr('data-slug', '').hide();				
			$('.guess-who img').hide();
						
			$('#guess').fadeIn('fast', function() {
				
				$('.guess-who img').attr('src', src).attr('data-slug', slug).fadeIn('fast');
				
			});
			$('#partial-overlay').show();

		} else {
			
			$('.guess-who img').hide().attr('src', src).attr('data-slug', slug).fadeIn('fast');
		}
			
		
	}).on('click', '.select.pick-what .selectable', function(e) {
		
		e.preventDefault();
		
		var src =  $(this).find('.pick-thumb').attr('src');
		var slug = $(this).attr('id');
							
		if (!$('#guess').is(':visible')) {
			
			$('.guess-who img').attr('src', '').attr('data-slug', '').hide();
			$('.guess-where img').attr('src', '').attr('data-slug', '').hide();	
			$('.guess-what img').hide();
								
			$('#guess').fadeIn('fast', function() {
				
				$('.guess-what img').attr('src', src).attr('data-slug', slug).fadeIn('fast');		
				
			});
			$('#partial-overlay').show();
			
		} else {
			
			$('.guess-what img').hide().attr('src', src).attr('data-slug', slug).fadeIn('fast');			
		}
					
	}).on('click', '.select.pick-where .selectable', function(e) {
		
		e.preventDefault();
		
		var src =  $(this).find('.pick-thumb').attr('src');
		var slug = $(this).attr('id');
		
		if (!$('#guess').is(':visible')) {
						
			$('.guess-who img').attr('src', '').attr('data-slug', '').hide();
			$('.guess-what img').attr('src', '').attr('data-slug', '').hide();
			$('.guess-where img').hide();	
								
			$('#guess').fadeIn('fast', function() {
				
				$('.guess-where img').attr('src', src).attr('data-slug', slug).fadeIn('fast');
			});
			$('#partial-overlay').show();

		} else {
			
			$('.guess-where img').hide().attr('src', src).attr('data-slug', slug).fadeIn('fast');		
		}
			

		
	}).on('mouseenter', '.select .selectable', function(e) {

		$(this).addClass('hover');
		
	}).on('mouseleave', '.select .selectable', function(e) {
		
		$(this).removeClass('hover');
		
	}).on('keypress', '#congratulations form input[type="text"]', function(e) {
		
    	var code = e.which || e.keyCode;		

		if (code == 32) {
			
			e.preventDefault();	
		}
		
	}).on('mouseenter', '.btn, .btn-circular', function() {
	
		var $this = $(this);
	
		$this.removeClass('animate-down').addClass('animate-up');
		
		setTimeout(function() {
			
			$this.removeClass('animate-up').addClass('animate-down');
			
			setTimeout(function() {
			
				$this.removeClass('animate-down')

			}, 100);			
			
			
		}, 100);
		
		
		
	})
	
	
	;
	
	
});

