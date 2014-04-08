<?php
$current_user = \TopHat\Core::getCurrentUser();
?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?=$vars->_site_title?></title>

    <!-- Core CSS - Include with every page -->
    <link href="<?=SCRIPT_BASE?>/_admin/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?=SCRIPT_BASE?>/_admin/font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- Page-Level Plugin CSS - Blank -->
    <link rel="stylesheet" href="<?=SCRIPT_BASE?>/js/fancybox/source/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
    <link rel="stylesheet" type="text/css" href="<?=SCRIPT_BASE?>/js/imgareaselect/css/imgareaselect-default.css" />
    <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css" />
    <link rel="stylesheet" href="<?=SCRIPT_BASE?>/js/timepicker/jquery-ui-timepicker-addon.css" />
    <link rel="stylesheet" href="//vjs.zencdn.net/4.4/video-js.css" />

    <link href="<?=SCRIPT_BASE?>/js/sliptree-bootstrap-tokenfield/dist/css/bootstrap-tokenfield.min.css" rel="stylesheet">

    <!-- SB Admin CSS - Include with every page -->
    <link href="<?=SCRIPT_BASE?>/_admin/css/sb-admin.css" rel="stylesheet">

    <!-- Page-Level Plugin CSS - Morris -->
    <link href="<?=SCRIPT_BASE?>/_admin/css/plugins/morris/morris-0.4.3.min.css" rel="stylesheet">

    <link rel="stylesheet" href="<?=SCRIPT_BASE?>/_admin/css/main.css" />


</head>

<body>

<div id="wrapper">

<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
<div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="/admin/dashboard"><img src="<?=SITE_URL?>/_admin/images/tophat-logo.png" /> </a>
</div>
<!-- /.navbar-header -->

<ul class="nav navbar-top-links navbar-right">

<!-- /.dropdown -->
<li class="dropdown">
    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
    </a>
    <ul class="dropdown-menu dropdown-user">
        <li><a href="/admin/users/<?=$current_user->id?>/edit"><i class="fa fa-user fa-fw"></i> User Profile</a>
        </li>
        <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
        </li>
        <li class="divider"></li>
        <li><a href="/admin/logout"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
        </li>
    </ul>
    <!-- /.dropdown-user -->
</li>
<!-- /.dropdown -->
</ul>
<!-- /.navbar-top-links -->

</nav>
<!-- /.navbar-static-top -->

<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav" id="side-menu">
            <li class="sidebar-search">
                <div class="input-group custom-search-form">
                    <form action="/admin/posts/view-all">
                        <input name="s" type="text" class="form-control" placeholder="Search...">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                    </form>

                </div>
                <!-- /input-group -->
            </li>
            <li>
                <a href="/admin/dashboard"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
            </li>
            <li>
                <a href="#"><i class="fa fa-edit fa-fw"></i> Posts<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="/admin/posts"><i class="fa fa-bars fa-fw"></i>View All</a>
                    </li>
                    <li>
                        <a href="/admin/posts/add"><i class="fa  fa-pencil fa-fw"></i> Add New</a>
                    </li>

                </ul>
                <!-- /.nav-second-level -->
            </li>

            <li>
                <a href="/admin/categories"><i class="fa fa-sitemap fa-fw"></i> Categories</a>
            </li>

            <li>
                <a href="/admin/sections"><i class="fa fa-sort-numeric-asc fa-fw"></i> Sections</a>
            </li>

            <li>
                <a href="#"><i class="fa fa-users fa-fw"></i> Users<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="/admin/users"><i class="fa fa-bars fa-fw"></i>View All</a>
                    </li>
                    <li>
                        <a href="/admin/users/add"><i class="fa  fa-pencil fa-fw"></i> Add New</a>
                    </li>

                </ul>
                <!-- /.nav-second-level -->
            </li>
            <li>

                <a href="/admin/settings"><i class="fa fa-wrench fa-fw"></i> Settings</a>

            </li>

        </ul>
        <!-- /#side-menu -->
    </div>
    <!-- /.sidebar-collapse -->
</nav>
<!-- /.navbar-static-side -->

<div id="page-wrapper">

    <div class="alerts">

        <?php
        $this->render('_globals/alerts');
        ?>

    </div>

    <?php
    if (empty($vars->_content) && $this->viewExists($this->view)) {
        $this->render($this->view);
    } else {
        echo $vars->_content;
    }
    ?>


</div>
<!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<!-- Core Scripts - Include with every page -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="<?=SCRIPT_BASE?>/js/vendor/jquery-1.10.2.min.js"><\/script>')</script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>

<script src="<?=SCRIPT_BASE?>/_admin/js/bootstrap.min.js"></script>
<script src="<?=SCRIPT_BASE?>/_admin/js/plugins/metisMenu/jquery.metisMenu.js"></script>


<!-- SB Admin Scripts - Include with every page -->
<script src="<?=SCRIPT_BASE?>/_admin/js/sb-admin.js"></script>

<!-- Page-Level Plugin Scripts - Morris -->
<script src="<?=SCRIPT_BASE?>/_admin/js/plugins/morris/raphael-2.1.0.min.js"></script>
<script src="<?=SCRIPT_BASE?>/_admin/js/plugins/morris/morris.js"></script>

<script src="<?=SCRIPT_BASE?>/js/fancybox/source/jquery.fancybox.pack.js?v=2.1.5"></script>
<script src="<?=SCRIPT_BASE?>/js/imgareaselect/scripts/jquery.imgareaselect.min.js"></script>
<script src="<?=SCRIPT_BASE?>/js/form/jquery.form.js"></script>
<script src="<?=SCRIPT_BASE?>/js/validation/dist/jquery.validate.min.js"></script>
<script src="<?=SCRIPT_BASE?>/js/ckeditor/ckeditor.js"></script>
<script src="<?=SCRIPT_BASE?>/js/ckeditor/adapters/jquery.js"></script>
<script src="<?=SCRIPT_BASE?>/js/typeahead.bundle.min.js"></script>
<script src="<?=SCRIPT_BASE?>/js/sliptree-bootstrap-tokenfield/dist/bootstrap-tokenfield.min.js"></script>
<script src="<?=SCRIPT_BASE?>/js/timepicker/jquery-ui-timepicker-addon.js"></script>
<script src="//vjs.zencdn.net/4.4/video.js"></script>

<script src="<?=SCRIPT_BASE?>/_admin/js/main.js"></script>


</body>

</html>
