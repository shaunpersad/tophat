$.ajaxSetup({
    url: "/get-execution-time.php",
    global: false
});

var superfast = ['Crazy fast!', 'Sweet.', 'Aw yiss.'];
var fast = ['Not bad at all.', 'Nice.'];
var medium = ['Ehhh.', 'Could be better.'];
var slow = ['Oops.', 'Well that\'s kind of embarassing.', 'We\'ll do better next time :('];

var blurb_timer,scroll_timer = false;
var hover_interval = 500;
var scroll_interval = 100;


function randomElement(arr) {

    return arr[Math.floor(Math.random()*arr.length)];
}

function getExecutionTime() {

    $.get('/get-execution-time.php', function(response) {

        if (response) {

            var time = parseFloat(response);
            var comment = '';
            if (time <= 0.015) {
                comment = randomElement(superfast);
            } else if (time <= 0.05) {
                comment = randomElement(fast);
            } else if (time < 0.1) {
                comment = randomElement(medium);
            } else {
                comment = randomElement(slow);
            }

            $('#footer .execution-time').html('Server-side execution time: '+time.toFixed(4) + ' sec.');
            $('#footer .execution-time-comment').html(comment);
        }

    });
}

/**
 * Changes the blurb text and fades in the new text.
 *
 * Assign a callback for what to do after the fade.
 *
 * @param text
 * @param callback
 */
function changeBlurb(text, callback) {

    var $temp = $('.top-blurb .temporary');

    $('.top-blurb .original, .top-blurb .temporary').stop().hide();
    $temp.html(text).fadeIn('slow', callback);

}

/**
 * Reverts the blurb back to the original text.
 */
function revertBlurb() {

    blurb_timer = setTimeout(function() {

        $('.top-blurb .temporary').fadeOut('slow', function() {
            $('.top-blurb .original').show();
        });

    }, hover_interval);
}

$(document).ready(function() {


    getExecutionTime();

    var posts = new Object(); //used as an associative array of posts

    // on page load, find the position of all posts
    $('.post-list .post-box').each(function() {

        var offset = $(this).offset();

        posts[offset.top] = $(this).attr('id');

    });

    $('.sidebar .sublinks li a').each(function() {

        var key = 'read-'+ $(this).attr('class').replace('-nav', '');

        if (docCookies.hasItem(key)) {

            $(this).append('<i class="fa fa-check fa-fw"></i>');
        }
    });

    if ($('.post-box.single-post').length) {

        var key = 'read-'+$('.post-box.single-post').attr('id');

        docCookies.setItem(key, 'yes', Infinity, '/');
    }


    $('.open-fancybox').fancybox({
        width: 968
    });

    $(document)

        .on('mouseenter', '.replace-blurb', function(e) {

            var text = $(this).attr('data-blurb'); //get new blurb

            /**
             * Prevent any previous hovers from changing the blurb text.
             */
            if (blurb_timer) {

                clearTimeout(blurb_timer);
            }

            /**
             * Wait to change the blurb text.
             * @type {number}
             */
            blurb_timer = setTimeout(function() {


                changeBlurb(text, revertBlurb);

            }, hover_interval);



        })

        .on('mouseleave', '.replace-blurb', function(e) {

            /**
             * Prevent any previous hovers from changing the blurb text.
             */
            if (blurb_timer) {

                clearTimeout(blurb_timer);
            }
            /**
             * Show original blurb text.
             */
            revertBlurb();

        })

        .on('keyup', '.search-blog input[name="s"]', function() {

            /**
             * Get text from the input, wrapped in the custom cursor span.
             *
             * @type {string}
             */
            var text = '<span class="custom-cursor">'+$(this).val()+'</span>';

            /**
             * Change the blurb text to what was typed.
             */
            changeBlurb(text);


        })

        .on('focus', '.search-blog input[name="s"]', function() {

            /**
             * Get text from the input, wrapped in the custom cursor span.
             *
             * @type {string}
             */
            var text = '<span class="custom-cursor">'+$(this).val()+'</span>';

            /**
             * Change the blurb text to what was typed.
             */
            changeBlurb(text);


        })

        .on('blur', '.search-blog input[name="s"]', function() {

            /**
             * Show original blurb text.
             */
            revertBlurb();

        })

        .on('click', '.view-image', function(e) {

            e.preventDefault();

            var fancybox_options = {
                type: 'image',
                href: $(this).attr('href')
            };

            $.fancybox.open(fancybox_options);
        })

        .on('scroll', function() {

            if (blurb_timer) {

                clearTimeout(blurb_timer);
            }

            scroll_timer = setTimeout(function() {

                var position = $(window).scrollTop();

                var scrolled_to = false;

                for (var offset in posts) {
                    if (position + 150 > offset) {

                        scrolled_to = posts[offset];
                    }
                }
                if (scrolled_to) {

                    $('.current').removeClass('current');
                    $('.'+scrolled_to+'-nav').addClass('current');
                }

            }, scroll_interval);


        })

        .on('click', '.back-to-top', function(e) {

            e.preventDefault();

            var href = $(this).attr('href');

            $('html, body').animate({
                scrollTop: $(href).offset().top
            }, 'fast');

        })

        .bind("ajaxSend", function(){

        })

        .bind("ajaxComplete", function(){

            getExecutionTime();
        });
    ;

});
