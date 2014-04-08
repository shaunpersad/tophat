<?php
$this->render('_globals/blurb');

?>

<article class="box col-lg-12 clearfix portfolio post">


    <div class="col-lg-4">


        <h4><?=$vars->post->title?></h4>

        <div class="box">

            <?=$vars->post->body?>

        </div>

        <?php
        $meta = $vars->post->meta();

        $other = $meta->get('other');

        if ($other) {

            foreach ($other as $meta_data) {

                ?>

                <div class="box">

                    <?=$meta_data['value']?>

                </div>
                <?php
            }
        }
        ?>
        <a href="/portfolio" class=" btn back-to-portfolio">
            back to portfolio <i class="fa fa-eye fa-fw"></i>
        </a>



    </div>



    <div class="col-lg-8 detail-image">

        <?php

        if ($image = $vars->post->image()) {

            echo $image->embed();
        } else {

            ?>
            <img src="/images/placeholder.jpg" />

           <?php

        }
        ?>


    </div>

</article>


<?php
$this->render('_globals/quick-links');
?>
