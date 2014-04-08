<?php
if (!empty($vars->post) && $post = $vars->post) { ?>

    <div class="media preview-post">
        <?php
        if ($image = $post->image()) { ?>

            <a class="pull-left view-image" href="<?=$image->url()?>">

                <?php

                echo $image->embed(
                    array(
                        'width' => 64,
                        'height' => 64,
                        'class' => 'media-object',
                        'href' => false,
                        'url' => $image->url(array(64, 64))
                    )
                ); ?>

            </a>
            <?php
        }
        ?>

        <div class="media-body">
            <h4 class="media-heading"><?=$post->title?></h4>

            <?=$post->teaser?>

        </div>
    </div>
    <?php
}


