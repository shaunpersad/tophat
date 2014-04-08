<?php

if (!empty($vars->post)) {

    $post = $vars->post;
} ?>
<div class="panel panel-default section-post">

    <button class="btn btn-default btn-xs btn-remove" type="button"><i class="fa fa-times"></i></button>
    <input name="post_ids[]" value="<?=$post->id?>" type="hidden" />
    <div class="media">

        <?php
        if ($image = $post->image()) { ?>

        <a href="<?=$image->url();?>" class="pull-left view-image">

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

        } else { ?>

            <a href="#" class="pull-left">
                <img src="/images/placeholder.jpg" width="64" height="64" />
            </a>
        <?php
        } ?>


        <div class="media-body">
            <h4 class="media-heading"><?=@$post->title?></h4>
            <?=@$post->teaser?>
        </div>
    </div>

</div>
