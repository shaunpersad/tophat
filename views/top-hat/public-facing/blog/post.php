<?php
$this->render('_globals/blurb');

$post_url = '/blog/post/'.$vars->post->id.'/'.$vars->post->slug;
?>

<article class="box col-lg-12 clearfix blog">

    <div class="col-sm-7 col-md-7 col-lg-8 blog-main">

        <div class="box post-box single-post" id="post-<?=@$vars->post->id?>">

            <div class="post-header">

                <h4 class="post-title"><?=$vars->post->title?></h4>
                <small>

                    <?php
                    $date = new \DateTime($vars->post->date_published);
                    echo $date->format('F j, Y, g:i a');
                    ?>

                </small>
            </div>

            <?php
            if ($image = $vars->post->image()) {

                $image_url = $image->url(900, array(16, 9));
                ?>

                <div class="post-image">
                    <?=$image->embed(array('src' => $image_url, 'href' => $image->url()))?>
                </div>
            <?php
            }
            ?>

            <div class="post-body">

                <?=$vars->post->body?>

            </div>

        </div>
        <div class="box">
            <?php

            $args = array(
                'identifier' => 'post-'.$vars->post->id,
                'title' => $vars->post->title,
                'url' => SITE_URL.$post_url
            );

            $this->render('_globals/disqus', $args);
            ?>

        </div>


    </div>

    <div class="col-lg-12 visible-xs small-blog-search">

        <?php
        $this->render('blog/search-form');
        ?>

    </div>

    <div class="col-sm-5 col-md-4 col-lg-3 col-md-offset-1 col-lg-offset-1 blog-sidebar">

        <div class="sidebar hidden-xs" role="complementary" data-spy="affix" data-offset-top="225">

            <?php
            $this->render('blog/search-form');


            if (!empty($vars->tags)) { ?>

                <div class="box tags clearfix">

                    <h4><i class="fa fa-tags fa-fw"></i> Tags</h4>

                    <div class="col-lg-12 full-width">
                        <?php
                        foreach ($vars->tags as $tag_id => $tag_title) {

                            $url = '/blog/tag/'.$tag_id;
                            $class = array('btn', 'btn-sm', 'btn-tag');

                            if ($vars->post->hasTag($tag_title)) {

                                $class[] = 'current';
                            } ?>
                            <a class="<?=implode(' ', $class)?>" href="<?=$url?>"><?=$tag_title?></a>

                        <?php
                        } ?>

                    </div>

                </div>

            <?php
            }

            $meta = $vars->post->meta();

            if ($related_posts = $meta->get('related')) { ?>

                <div class="box related-posts clearfix">

                    <h4><i class="fa fa-tags fa-fw"></i> Related Posts</h4>

                    <div class="col-lg-12 full-width">
                        <?php

                        foreach ($related_posts as $post) {

                            $url = '/blog/post/'.$post->id.'/'.$post->slug;
                            ?>

                            <div class="post-box" id="post-5">

                                <h4 class="post-title"><a href="<?=$url?>"><?=$post->title?></a></h4>

                            </div>

                            <?php
                        }
                        ?>

                    </div>

                </div>

                <?php
            }

            ?>





            <div class="box share clearfix">
                <?php

                $encoded_url = urlencode(SITE_URL.$post_url);
                $facebook_url = 'https://www.facebook.com/sharer/sharer.php?u='.$encoded_url;
                $twitter_url = 'https://twitter.com/share?url='.$encoded_url;
                $gplus_url = 'https://plus.google.com/share?url='.$encoded_url;
                ?>

                <div class="col-xs-4">
                    <a class="btn btn-large btn-block" target="_blank" href="<?=$facebook_url?>"><i class="fa fa-facebook-square fa-fw fa-3x"></i></a>

                </div>
                <div class="col-xs-4">
                    <a class="btn btn-large btn-block" target="_blank"  href="<?=$twitter_url?>"><i class="fa fa-twitter-square fa-fw fa-3x"></i></a>
                </div>
                <div class="col-xs-4">
                    <a class="btn btn-large btn-block" target="_blank" href="<?=$gplus_url?>"><i class="fa fa-google-plus-square fa-fw fa-3x"></i></a>
                </div>


            </div>


            <a href="#top" class=" btn back-to-top">
                back to top <i class="fa fa-rocket fa-fw"></i>
            </a>
            <a href="/blog" class=" btn back-to-blog">
                back to blog <i class="fa fa-comment-o fa-fw"></i>
            </a>

        </div>

    </div>

</article>