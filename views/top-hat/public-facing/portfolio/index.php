<?php
$this->render('_globals/blurb');
?>

<article class="box col-lg-12 clearfix portfolio">


    <div class="col-lg-12 header">

        <h3><i class="fa fa-briefcase fa-fw"></i> work</h3>

    </div>

    <?php
    if (!empty($vars->posts)) {

        foreach ($vars->posts as $post) { ?>

            <div class="col-sm-4 project-thumb-container">

                <div class="project-thumb">

                    <div class="project-view simple-transition">

                        <?php
                        $url = '/images/placeholder.jpg';

                        if ($image = $post->image()) {

                            $url = $image->url(760);
                        }
                        ?>


                        <div class="project-image" style="background-image: url('<?=$url?>');">

                            <a href="/portfolio/project/<?=$post->id?>/<?=$post->slug?>"></a>
                        </div>
                        <div class="mask">
                            <h2><?=$post->title?></h2>
                            <p><?=$post->teaser?></p>
                            <a href="/portfolio/project/<?=$post->id?>/<?=$post->slug?>" class="info"></a>
                        </div>
                    </div>

                </div>

            </div>

            <?php
        }
    }
    ?>


</article>


<?php
$this->render('_globals/quick-links');
?>
