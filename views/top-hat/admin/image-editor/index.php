<div id="image-editor">

    <div class="panel panel-default">

        <div class="panel-heading">
            <h4>Please select a source:</h4>
        </div>
        <div class="panel-body">

            <!-- Nav tabs -->
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#source-computer">Computer</a>
                </li>
                <li><a data-toggle="tab" href="#source-url">From URL</a>
                </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div id="source-computer" class="tab-pane fade active in">

                    <div class="col-sm-12">

                        <h4 class="text-center">Upload an image from your computer.</h4>

                    </div>

                    <div class="col-sm-12">

                        <form class="form-inline text-center" action="/admin/image-editor/upload" method="post" enctype="multipart/form-data">

                            <div class="form-group">
                                <input type="file" name="image" class="required" />
                            </div>
                            <button class="btn btn-default" type="submit">Upload</button>

                        </form>

                    </div>




                </div>

                <div id="source-url" class="tab-pane fade">

                    <div class="col-sm-12">

                        <h4 class="text-center">Upload an image from a URL</h4>

                    </div>

                    <div class="col-sm-12 text-center">

                        <form class="form-inline" action="/admin/image-editor/upload" method="post">

                            <div class="form-group">
                                <input name="image_url" type="text" class="form-control required"/>
                            </div>
                            <button class="btn btn-default" type="submit">Upload</button>

                        </form>

                    </div>

                </div>
            </div>
        </div>
        <!-- /.panel-body -->
    </div>


</div>

 