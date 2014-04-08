<?php

$this->render('_globals/blurb');

$this->render('_globals/quick-links');

if (!empty($vars->posts)) { ?>

    <article class="box col-lg-12 clearfix">

        <div class="col-lg-12 header">

            <h3><i class="fa fa-pencil fa-fw"></i> recent posts</h3>

        </div>

        <?php
        foreach ($vars->posts as $post) {

            $url = '/blog/post/'.$post->id.'/'.$post->slug;?>

            <div class="col-sm-4 recent-post">

                <div>
                    <h4 class="post-title"><a href="<?=$url?>"><?=$post->title?></a></h4>

                    <p class="post-teaser">
                        <?=$post->teaser?>
                    </p>
                    <p class="post-read-more">
                        <a href="<?=$url?>"> read more <i class="fa fa-sign-in fa-fw"></i></a>
                    </p>

                </div>


            </div>

            <?php
        }
        ?>

    </article>

    <?php
}