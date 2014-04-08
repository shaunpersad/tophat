

<?php

$this->render('_globals/blurb');

foreach ($vars->posts as $post) {

    $title = $post->title;

    $body = $post->body;

    $meta = $post->meta();

    $icon_meta = $meta->getFirst('fa-icon');
    $icon = '';
    if ($icon_meta) {

        $icon = $icon_meta['value'];
    }

    ?>

    <article class="box col-lg-12 clearfix about">


        <div class="col-lg-12 header">

            <h3><i class="fa <?=$icon?> fa-fw"></i> <?=$title?></h3>

        </div>

        <div class="col-lg-12">

            <?=$body?>

        </div>

    </article>

    <?php
}

?>


<?php
$this->render('_globals/quick-links');
?>
