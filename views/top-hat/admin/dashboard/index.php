<div class="row">
    <div class="col-lg-12">
        <h1>Welcome, <?=$vars->current_user->display_name?></h1>
        <ol class="breadcrumb">
            <li class="active"><i class="icon-dashboard"></i> Dashboard</li>
        </ol>
    </div>
</div><!-- /.row -->
<div class="row">

    <div class="col-lg-4">

        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-bar-chart-o fa-fw"></i> Cache Hits/Misses
            </div>
            <div class="panel-body">

                <div id="cache-hits-misses">



                </div>

                <a class="btn btn-default btn-block" href="/admin/dashboard/increment-cache-generation">Increment Cache Generation</a>
            </div>
            <!-- /.panel-body -->
        </div>

    </div>

    <div class="col-lg-4">

        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-bar-chart-o fa-fw"></i> Cache Memory Usage (mb)
            </div>
            <div class="panel-body">

                <div id="cache-memory-usage">



                </div>

                <a class="btn btn-default btn-block" href="/admin/dashboard/flush-cache">Flush Cache</a>
            </div>
            <!-- /.panel-body -->
        </div>


    </div>

    <div class="col-lg-4">


    </div>




</div>