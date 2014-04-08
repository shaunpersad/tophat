<?php
$this->render('_globals/blurb');

?>

<article class="box col-lg-12 clearfix blog">


    <div class="col-sm-7 col-md-7 col-lg-8 post-list blog-main">

        <?php


        foreach ($vars->posts as $post) {

            $url = '/blog/post/'.$post->id.'/'.$post->slug; ?>

            <div class="box post-box" id="post-<?=$post->id?>">

                <h4 class="post-title"><a href="<?=$url?>"><?=$post->title?></a></h4>

                <?php
                if ($image = $post->image()) {


                    ?>

                    <div class="post-image">
                        <a href="<?=$url?>"><img src="<?=$image->url(900, array(16, 9))?>" /></a>
                    </div>
                    <?php
                }
                ?>

                <p class="post-teaser">
                    <?=$post->teaser?>
                </p>
                <p class="post-read-more">
                    <a href="<?=$url?>"> read more <i class="fa fa-sign-in fa-fw"></i></a>
                </p>

            </div>

            <?php
        }

        if (!count($vars->posts)) { ?>

            <div class="box" style="text-align: center">

                <p>No posts found.</p>
            </div>
        <?php
        }

        ?>


        <div class="box paging">



            <ul class="pagination pagination-sm">
                <?php

                $num_pages = count($vars->page_list);

                $base_url = $vars->base_url;

                if ($num_pages) {

                    $last_page = $vars->page_list[count($vars->page_list) - 1];
                    $prev = 0;
                    $next = 0;


                    if ($vars->current_page > 1) {

                        $prev = $vars->current_page - 1;
                    }

                    if ($vars->current_page < $last_page) {

                        $next = $vars->current_page + 1;
                    }
                    ?>

                    <li class="<?php if (!$prev){ echo 'disabled'; }?>">
                        <a href="<?=$base_url.'?'.http_build_query(array_merge($vars->args, array('page' => $prev)))?>">
                            <i class="fa fa-reply fa-fw"></i>
                        </a>
                    </li>
                    <?php
                    foreach ($vars->page_list as $page) {

                        $active = '';
                        if ($vars->current_page == $page) {
                            $active = ' active';
                        } ?>

                        <li class="<?=$active?>">
                            <a href="<?=$base_url.'?'.http_build_query(array_merge($vars->args, array('page' => $page)))?>"><?=$page?></a>
                        </li>

                    <?php
                    }
                    ?>

                    <li class="<?php if (!$next){ echo ' disabled'; }?>">
                        <a href="<?=$base_url.'?'.http_build_query(array_merge($vars->args, array('page' => $next)))?>">
                            <i class="fa fa-share fa-fw"></i>
                        </a>
                    </li>

                <?php
                } ?>

            </ul>


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

                            foreach ($vars->posts as $post) {

                                if ($post->hasTag($tag_title)) {

                                    $class[] = 'post-'.$post->id.'-nav';
                                }
                            } ?>
                            <a class="<?=implode(' ', $class)?>" href="<?=$url?>"><?=$tag_title?></a>

                        <?php
                        } ?>

                    </div>

                </div>

            <?php
            }

            ?>


            <div class="box clearfix">

                <h4><i class="fa fa-anchor fa-fw"></i> Anchors</h4>

                <div class="col-lg-12 full-width">

                    <ul class="sublinks">
                        <?php

                        foreach ($vars->posts as $post) {

                            $url = '#post-'.$post->id;
                            ?>

                            <li><a class="post-<?=$post->id?>-nav" href="<?=$url?>">
                                    <?=$post->title?>
                                </a>
                            </li>

                        <?php
                        }

                        ?>


                    </ul>


                </div>

            </div>

            <a href="#top" class=" btn back-to-top">
                back to top <i class="fa fa-rocket fa-fw"></i>
            </a>
            <?php
            if (!empty($vars->s)) { ?>

                <a href="/blog" class=" btn back-to-blog">
                    back to blog <i class="fa fa-comment-o fa-fw"></i>
                </a>
            <?php
            }
            ?>

        </div>

    </div>





</article>
