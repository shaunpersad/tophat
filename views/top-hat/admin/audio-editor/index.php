<div id="audio-editor">

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
                <li><a data-toggle="tab" href="#source-embed-code">Embed Code</a>
                </li>

            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div id="source-computer" class="tab-pane fade active in">

                    <div class="col-sm-12">

                        <h4 class="text-center">Upload an audio file from your computer.</h4>

                    </div>

                    <div class="col-sm-12">

                        <form class="form-inline text-center" action="/admin/audio-editor/upload" method="post" enctype="multipart/form-data">

                            <div class="form-group">
                                <input type="file" name="audio" class="required" />
                            </div>
                            <button class="btn btn-default" type="submit">Upload</button>

                        </form>

                    </div>




                </div>

                <div id="source-url" class="tab-pane fade">

                    <div class="col-sm-12">

                        <h4 class="text-center">Upload an audio file from a URL</h4>

                    </div>

                    <div class="col-sm-12 text-center">

                        <form class="form-inline" action="/admin/audio-editor/upload" method="post">

                            <div class="form-group">
                                <input name="audio_url" type="text" class="form-control required"/>
                            </div>
                            <button class="btn btn-default" type="submit">Upload</button>

                        </form>

                    </div>

                </div>


                <div id="source-embed-code" class="tab-pane fade">

                    <div class="col-sm-12">

                        <h4 class="text-center">Use an embed code</h4>

                    </div>

                    <div class="col-sm-12 text-center">

                        <form action="/admin/audio-editor/upload" method="post">

                            <div class="form-group">

                                <textarea name="audio_embed_code" rows="3" class="form-control required"></textarea>
                                <p class="help-block">Warning: embed codes are not validated.  Please be careful.</p>

                            </div>
                            <div class="form-group">
                                <button class="btn btn-default" type="submit">Upload</button>
                            </div>

                        </form>

                    </div>

                </div>



            </div>
        </div>
        <!-- /.panel-body -->
    </div>


</div>

 