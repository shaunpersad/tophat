<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?=$vars->_site_title?></title>

    <!-- Core CSS - Include with every page -->
    <link href="<?=SCRIPT_BASE?>/_admin/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?=SCRIPT_BASE?>/_admin/font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- SB Admin CSS - Include with every page -->
    <link href="<?=SCRIPT_BASE?>/_admin/css/sb-admin.css" rel="stylesheet">

</head>

<body>

<div class="container">

    <?php

    $all_alerts = \TopHat\Core::getAllAlerts();

    foreach ($all_alerts as $alert_type => $alerts) {

        foreach ($alerts as $alert) { ?>

            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <div class="alert alert-danger alert-dismissable">
                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                        <?=$alert?>
                    </div>
                </div>
            </div>

        <?php
        }
    }
    ?>

    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Please Sign In</h3>
                </div>
                <div class="panel-body">
                    <form role="form" method="post" action="/admin/login/process">
                        <fieldset>
                            <div class="form-group">
                                <input class="form-control email required" placeholder="E-mail" name="email" type="email" autofocus>
                            </div>
                            <div class="form-group">
                                <input class="form-control required" placeholder="Password" name="password" type="password" value="">
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input name="remember" type="checkbox" value="Remember Me">Remember Me
                                </label>
                            </div>
                            <!-- Change this to a button or input when using this as a form -->
                            <input type="submit" class="btn btn-lg btn-success btn-block" value="Login" />
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Core Scripts - Include with every page -->

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="<?=SCRIPT_BASE?>/js/vendor/jquery-1.10.2.min.js"><\/script>')</script>

<script src="<?=SCRIPT_BASE?>/_admin/js/bootstrap.min.js"></script>
<script src="<?=SCRIPT_BASE?>/_admin/js/plugins/metisMenu/jquery.metisMenu.js"></script>

<!-- SB Admin Scripts - Include with every page -->
<script src="<?=SCRIPT_BASE?>/_admin/js/sb-admin.js"></script>

</body>

</html>
