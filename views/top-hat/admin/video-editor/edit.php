<?php
use TopHat\Media;
use TopHat\MediaVideo;

$title = '';
$url = '';
$path = '';
$embed_code = '';
$source = '';

$error = false;

$uniqid = uniqid('videojs_');

if (!empty($vars->video)) {

    $title = $vars->video->title;
    $source = $vars->video->source;

    if ($source == Media::SOURCE_FILE) {

        $path = $vars->video->path();
        $url = $vars->video->url();

    } elseif ($source == Media::SOURCE_URL) {

        $url = $vars->video->url();

    } elseif ($source == Media::SOURCE_EMBED) {

        $embed_code = $vars->video->embed_code;
    }


} elseif (!empty($vars->video_data)) {

    if (!empty($vars->video_data['error'])) {

        $error = true;
    } else {

        $source = $vars->video_data['source'];

        if ($source == Media::SOURCE_FILE) {

            $path = $vars->video_data['path'];
            $url = $vars->video_data['url'];

        } elseif ($source == Media::SOURCE_URL) {

            $url = $vars->video_data['url'];

        } elseif ($source == Media::SOURCE_EMBED) {

            $embed_code = $vars->video_data['embed_code'];
        }


    }


}
?>

<div id="video-editor">

    <div class="panel panel-default">

        <div class="panel-heading">
            <a href="/admin/video-editor" class="btn btn-default open-popup">Create New Video</a>

        </div>
        <div class="panel-body">
            <?php

            if ($error) { ?>

                <p>An error occurred.  If you were uploading a video, please make sure it is not too large.
                    You may need to utilize uploading via URL instead.
                </p>

                    <?php
            } else { ?>

                <form id="save-video-data" role="form" autocomplete="off" action="/admin/video-editor/save" method="post">


                    <div class="col-sm-12 well">

                        <label>Title:</label>

                        <div class="form-group">

                            <input name="id" type="hidden" value="<?=@$vars->video->id?>" />
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


                        <div class="form-group video">

                            <?php

                            if (!empty($url)) { ?>

                                <video id="<?=$uniqid?>" class="video-js vjs-default-skin"
                                       controls preload="auto" width="640" height="264">
                                    <source src="<?=$url?>" type='video/<?=\TopHat\Core::extensionFromFilename($url)?>' />
                                </video>

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