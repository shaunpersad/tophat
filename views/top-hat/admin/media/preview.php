<?php
if (!empty($vars->media) && $media = $vars->media) { ?>

    <div class="media preview-media">

        <div class="media-body">
            <h4 class="media-heading"><?=$media->title?></h4>

            <?=$media->embed(array('width' => '100%', 'height' => 'auto'))?>

        </div>
    </div>
<?php
}


