<?php
use TopHat\Media;
use TopHat\MediaAudio;

$title = '';
$url = '';
$path = '';
$embed_code = '';
$source = '';

$error = false;

$uniqid = uniqid('audio_');

if (!empty($vars->audio)) {

    $title = $vars->audio->title;
    $source = $vars->audio->source;

    if ($source == Media::SOURCE_FILE) {

        $path = $vars->audio->path();
        $url = $vars->audio->url();

    } elseif ($source == Media::SOURCE_URL) {

        $url = $vars->audio->url();

    } elseif ($source == Media::SOURCE_EMBED) {

        $embed_code = $vars->audio->embed_code;
    }


} elseif (!empty($vars->audio_data)) {

    if (!empty($vars->audio_data['error'])) {

        $error = true;
    } else {

        $source = $vars->audio_data['source'];

        if ($source == Media::SOURCE_FILE) {

            $path = $vars->audio_data['path'];
            $url = $vars->audio_data['url'];

        } elseif ($source == Media::SOURCE_URL) {

            $url = $vars->audio_data['url'];

        } elseif ($source == Media::SOURCE_EMBED) {

            $embed_code = $vars->audio_data['embed_code'];
        }


    }


}
?>

<div id="audio-editor">

    <div class="panel panel-default">

        <div class="panel-heading">
            <a href="/admin/audio-editor" class="btn btn-default open-popup">Create New Audio</a>

        </div>
        <div class="panel-body">
            <?php

            if ($error) { ?>

                <p>An error occurred.  If you were uploading a file, please make sure it is not too large.
                    You may need to utilize uploading via URL instead.
                </p>

            <?php
            } else { ?>

                <form id="save-audio-data" role="form" autocomplete="off" action="/admin/audio-editor/save" method="post">


                    <div class="col-sm-12 well">

                        <label>Title:</label>

                        <div class="form-group">

                            <input name="id" type="hidden" value="<?=@$vars->audio->id?>" />
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


                        <div class="form-group audio">

                            <?php

                            if (!empty($url)) { ?>

                                <audio controls>
                                    <source src="<?=$url?>" type='audio/<?=\TopHat\Core::extensionFromFilename($url)?>' />
                                </audio>

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