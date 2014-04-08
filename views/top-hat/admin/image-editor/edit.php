<?php
if (!empty($vars->image)) {

    $title = $vars->image->title;
    $url = $vars->image->url();
    $path = $vars->image->path();

    $img = $vars->image->getWideImageObject();

    $orientation = 'horizontal';

    if ($img->getHeight() > $img->getWidth()) {

        $orientation = 'vertical';
    }

} elseif (!empty($vars->image_data)) {

    $url = $vars->image_data['url'];
    $orientation = $vars->image_data['orientation'];
    $path = $vars->image_data['path'];
}
?>

<div id="image-editor">

    <div class="panel panel-default">

        <div class="panel-heading">
            <a href="/admin/image-editor" class="btn btn-default open-popup">Create New Image</a>

        </div>
        <div class="panel-body">

            <form id="save-image-data" role="form" autocomplete="off" action="/admin/image-editor/save" method="post">


                <div class="col-sm-9 well">

                    <label>Title:</label>

                    <div class="form-group">

                        <input name="id" type="hidden" value="<?=@$vars->image->id?>" />

                        <input type="text" class="required form-control" name="title" value="<?=@$title?>" />
                    </div>

                    <div class="image-to-edit">

                        <?php

                        if (!empty($url) && !empty($orientation) && !empty($path)) { ?>

                            <img src="<?=$url?>" class="img-<?=$orientation?>" data-path="<?=$path?>">
                        <?php
                        }


                        ?>

                    </div>


                </div>
                <div class="col-sm-3">


                    <div class="radio-container">

                        <?php
                        $rand = rand();
                        ?>

                        <label>Ratios:</label>

                        <div class="form-group clearfix">
                            <input type="radio" name="ratio" value="ratio-original" class="ratio-original active" checked="checked" id="ratio-original-<?=$rand?>">
                            <label class="btn btn-default" for="ratio-original-<?=$rand?>">original</label>
                        </div>

                        <?php
                        $ratios = array(
                            array(16, 9),
                            array(4, 3)
                        );
                        $ratio_data = array();

                        if (!empty($vars->image)) {

                            $ratio_data = $vars->image->getRatioData();

                        }


                        foreach ($ratios as $ratio) {

                            $breadth = $ratio[0];
                            $length = $ratio[1];

                            if (!empty($ratio_data[$breadth.':'.$length])) {

                                $data = $ratio_data[$breadth.':'.$length];

                                ?>
                                <div class="form-group clearfix">

                                    <input type="radio"
                                           name="ratio"
                                           value="ratio-<?=$breadth.':'.$length?>"
                                           id="ratio-<?=$breadth.'-'.$length.'-'.$rand?>"
                                           data-x1="<?=$data['x1']?>"
                                           data-y1="<?=$data['y1']?>"
                                           data-x2="<?=$data['x2']?>"
                                           data-y2="<?=$data['y2']?>"
                                           data-width="<?=$data['width']?>"
                                           data-height="<?=$data['height']?>">

                                    <label for="ratio-<?=$breadth.'-'.$length.'-'.$rand?>" class="btn btn-default">
                                        <?=$breadth.' : '.$length?>
                                    </label>

                                </div>

                            <?php

                            } else { ?>

                                <div class="form-group clearfix">

                                    <input type="radio"
                                           name="ratio"
                                           value="ratio-<?=$breadth.':'.$length?>"
                                           id="ratio-<?=$breadth.'-'.$length.'-'.$rand?>">

                                    <label for="ratio-<?=$breadth.'-'.$length.'-'.$rand?>" class="btn btn-default">
                                        <?=$breadth.' : '.$length?>
                                    </label>

                                </div>

                            <?php
                            }
                        }

                        ?>

                        <div class="form-group clearfix">

                            <button class="btn btn-default" type="submit">Save and Use</button>

                        </div>



                    </div>




                </div>
            </form>

        </div>
    </div>

</div>