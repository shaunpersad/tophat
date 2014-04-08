<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title><?=$vars->_site_title?></title>
    <?php

    foreach($vars->_meta as $name => $content) { ?>

        <meta name="<?=$name?>" content="<?=$content?>">
    <?php
    }
    foreach($vars->_fb_meta as $property => $content) { ?>

        <meta property="<?=$property?>" content="<?=$content?>">
    <?php
    }

    ?>


    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?=SCRIPT_BASE?>/js/fancybox/source/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" href="<?=SCRIPT_BASE?>/css/main.css">
    <script src="<?=SCRIPT_BASE?>/js/vendor/modernizr-2.6.2.min.js"></script>
</head>
<body>

<div class="container">

    <header id="top">
        <p><a href="<?=SITE_URL?>">shaun persad.</a>

            <button data-target=".navbar-collapse" data-toggle="collapse" class="btn visible-xs pull-right" type="button">
                <i class="fa fa-bars"></i>
            </button>
        </p>

    </header>

    <div>

        <nav class="clearfix" role="navigation">

            <div class="collapse navbar-collapse">

                <?php
                $controller = $this->request->controller;
                ?>


                <div class="col-sm-2 col-sm-offset-1<?php if ($controller == 'index') { echo ' active';} ?>">
                    <a class="btn replace-blurb btn-block btn-link" href="/" data-blurb="It's where the heart is.">home <i class="fa fa-heart-o fa-fw"></i></a>
                </div>
                <div class="col-sm-2<?php if ($controller == 'about') { echo ' active';} ?>">
                    <a class="btn replace-blurb btn-block btn-link" href="/about" data-blurb="I think, therefore I am. Sometimes.">about <i class="fa fa-lightbulb-o fa-fw"></i></a>
                </div>
                <div class="col-sm-2<?php if ($controller == 'portfolio') { echo ' active';} ?>">
                    <a class="btn replace-blurb btn-block btn-link" href="/portfolio" data-blurb="Seeing is believing.">portfolio <i class="fa fa-eye fa-fw"></i></a>
                </div>
                <div class="col-sm-2<?php if ($controller == 'blog') { echo ' active';} ?>">
                    <a class="btn replace-blurb btn-block btn-link" href="/blog" data-blurb="I write more than just code.">blog <i class="fa fa-comment-o fa-fw"></i></a>
                </div>
                <div class="col-sm-2<?php if ($controller == 'contact') { echo ' active';} ?>">
                    <a class="btn replace-blurb btn-block btn-link" href="/contact" data-blurb="Say something nice.">contact <i class="fa fa-smile-o fa-fw"></i></a>
                </div>

            </div>
        </nav>


    </div>

    <div class="primary-content clearfix">


        <?php
        if (empty($vars->_content) && $this->viewExists($this->view)) {
            $this->render($this->view);
        } else {
            echo $vars->_content;
        }
        ?>

    </div>

    <footer id="footer" class="clearfix">

        <div class="col-sm-6">

            <div class="execution-time col-lg-12">
            </div>
            <div class="execution-time-comment col-lg-12">
            </div>
        </div>
        <div class="col-sm-6 copyright">

            <div class="col-lg-12">
            </div>
            <div class="col-lg-12">

                &copy; <?=date('Y')?> shaun persad.

            </div>
        </div>

    </footer>


</div>






<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="<?=SCRIPT_BASE?>/js/vendor/jquery-1.10.2.min.js"><\/script>')</script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
<script src="<?=SCRIPT_BASE?>/js/cookies.js"></script>
<script src="<?=SCRIPT_BASE?>/js/fancybox/source/jquery.fancybox.pack.js?v=2.1.5"></script>

<script src="<?=SCRIPT_BASE?>/js/main.js"></script>

<?php
if (defined ('GOOGLE_ANALYTICS_CODE')) { ?>

    <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
    <script>
        (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
            function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
            e=o.createElement(i);r=o.getElementsByTagName(i)[0];
            e.src='//www.google-analytics.com/analytics.js';
            r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
        ga('create','<?=GOOGLE_ANALYTICS_CODE?>');ga('send','pageview');
    </script>

    <?php
}
?>

</body>
</html>