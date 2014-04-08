<?php
use TopHat\Media;
use TopHat\MediaDocument;

$title = '';
$url = '';
$path = '';
$embed_code = '';
$source = '';

$error = false;

$uniqid = uniqid('document_');

if (!empty($vars->document)) {

    $title = $vars->document->title;
    $source = $vars->document->source;

    if ($source == Media::SOURCE_FILE) {

        $path = $vars->document->path();
        $url = $vars->document->url();

    } elseif ($source == Media::SOURCE_URL) {

        $url = $vars->document->url();

    } elseif ($source == Media::SOURCE_EMBED) {

        $embed_code = $vars->document->embed_code;
    }


} elseif (!empty($vars->document_data)) {

    if (!empty($vars->document_data['error'])) {

        $error = true;
    } else {

        $source = $vars->document_data['source'];

        if ($source == Media::SOURCE_FILE) {

            $path = $vars->document_data['path'];
            $url = $vars->document_data['url'];

        } elseif ($source == Media::SOURCE_URL) {

            $url = $vars->document_data['url'];

        } elseif ($source == Media::SOURCE_EMBED) {

            $embed_code = $vars->document_data['embed_code'];
        }


    }


}
?>

<div id="document-editor">

    <div class="panel panel-default">

        <div class="panel-heading">
            <a href="/admin/document-editor" class="btn btn-default open-popup">Create New Document</a>

        </div>
        <div class="panel-body">
            <?php

            if ($error) { ?>

                <p>An error occurred.  If you were uploading a file, please make sure it is not too large.
                    You may need to utilize uploading via URL instead.
                </p>

            <?php
            } else { ?>

                <form id="save-document-data" role="form" autocomplete="off" action="/admin/document-editor/save" method="post">


                    <div class="col-sm-12 well">

                        <label>Title:</label>

                        <div class="form-group">

                            <input name="id" type="hidden" value="<?=@$vars->document->id?>" />
                            <input name="source" type="hidden" value="<?=$source?>" />

                            <input type="text" class="required form-control" name="title" value="<?=@$title?>" />
                        </div>

                        <?php
                        if (!empty($path)) { ?>

                            <input type="hidden" name="path" value="<?=$path?>" />
                        <?php
                        }
                        if (!empty($url)) {

                            if ($source == Media::SOURCE_URL) { ?>
                                <div class="form-group">
                                    <input type="text" class="required form-control" name="url" value="<?=@$url?>" />
                                </div>
                            <?php
                            } else { ?>
                                <div class="form-group">
                                    <input type="text" disabled="disabled" class="required form-control" name="url" value="<?=@$url?>" />
                                </div>
                            <?php
                            }


                        }
                        if (!empty($embed_code)) { ?>

                            <div class="form-group">
                                <textarea name="embed_code" rows="3" class="form-control required"><?=$embed_code?></textarea>
                                <p class="help-block">Warning: embed codes are not validated.  Please be careful.</p>
                            </div>

                        <?php
                        }
                        ?>


                        <div class="form-group document">

                            <?php

                            if (!empty($url)) { ?>

                                <iframe src="<?=$url?>"></iframe>

                            <?php
                            } elseif (!empty($embed_code)) {

                                echo $embed_code;
                            }


                            ?>

                        </div>


                        <div class="form-group clearfix">

                            <button class="btn btn-default" type="submit">Save and Use</button>

                        </div>

                    </div>

                </form>

            <?php
            }
            ?>


        </div>
    </div>

</div>