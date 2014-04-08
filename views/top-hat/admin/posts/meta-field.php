<?php
use TopHat\Core;
use TopHat\Meta;
use TopHat\Media;

$title = '';
$type = Meta::TYPE_TEXT;
$value = '';
$uniqid = uniqid('meta-field-');

if (!empty($vars->title)) {

    $title = $vars->title;
}
if (!empty($vars->type)) {

    $type = $vars->type;
}
if (!empty($vars->value)) {

    $value = $vars->value;
}
if (!empty($vars->uniqid)) {

    $uniqid = $vars->uniqid;
}
?>

<div class="panel panel-default meta-panel" id="<?=$uniqid?>">


    <div class="panel-heading">
        <a class="btn btn-default btn-xs btn-remove remove-meta"><i class="fa fa-times"></i></a>

        <div class="panel-title clearfix form-group form-inline">

                <div class="col-sm-6">
                    <input id="meta-title-<?=$uniqid?>" type="text" name="meta[<?=$uniqid?>][title]" class="form-control meta-title" value="<?=$title?>" placeholder="enter meta title here" />

                </div>

                <div class="col-sm-6">
                    <a href="#collapse-<?=$uniqid?>" data-parent="#accordion" data-toggle="collapse" class="collapsed btn btn-default pull-right">configure</a>

                </div>

            </div>
    </div>
    <div class="panel-collapse collapse" id="collapse-<?=$uniqid?>">
        <div class="panel-body">


            <div class="form-group">
                <label for="meta-type-<?=$uniqid?>">Meta Type:</label>
                <select id="meta-type-<?=$uniqid?>" name="meta[<?=$uniqid?>][type]" class="form-control meta-type">

                    <?php
                    foreach (Meta::$types as $meta_type) {

                        $selected = '';
                        if ($type == $meta_type) {
                            $selected = ' selected="selected"';
                        }
                        ?>
                        <option value="<?=$meta_type?>"<?=$selected?>><?=ucwords(str_replace('_', ' ',$meta_type))?></option>
                    <?php
                    }
                    ?>

                </select>
            </div>

            <div class="form-group meta-values">
                <label for="meta-value-<?=$uniqid?>">Meta Value:</label>

                <?php

                if ($type == Meta::TYPE_TEXT) { ?>

                    <textarea id="meta-value-<?=$uniqid?>" name="meta[<?=$uniqid?>][value]" rows="3" class="form-control meta-value"><?=$value?></textarea>

                <?php
                } elseif ($type == Meta::TYPE_FANCY_TEXT) { ?>

                    <textarea id="meta-value-<?=$uniqid?>" name="meta[<?=$uniqid?>][value]" rows="3" class="form-control meta-value"><?=$value?></textarea>
                <?php
                } elseif ($type == Meta::TYPE_DATE) {

                    if ((!empty($value))) {

                        try {

                            $date = new \DateTime($value, new \DateTimeZone(TIMEZONE));
                            $value = $date->format('m/d/Y');

                        } catch (Exception $e) {
                            $value = '';
                        }

                    }
                    ?>

                    <input id="meta-value-<?=$uniqid?>" placeholder="mm/dd/yyyy" type="text" name="meta[<?=$uniqid?>][value]" class="form-control meta-value" value="<?=$value?>" />

                <?php
                } elseif ($type == Meta::TYPE_DATE_TIME) {

                    if ((!empty($value))) {

                        try {

                            $date = new \DateTime($value, new \DateTimeZone(TIMEZONE));
                            $value = $date->format('m/d/Y H:i');

                        } catch (Exception $e) {

                            $value = '';
                        }

                    }
                    ?>

                    <input id="meta-value-<?=$uniqid?>" placeholder="mm/dd/yyyy HH:mm (24 hour time)" type="text" name="meta[<?=$uniqid?>][value]" class="form-control meta-value" value="<?=$value?>" />

                <?php
                } elseif ($type == Meta::TYPE_POST) { ?>

                    <div class="formspacer">

                        <?php
                        $post_id = 0;
                        $hidden = ' hidden';
                        $preview_url = '/admin/posts/preview';

                        if (is_numeric($value)) {

                            $post = Core::getPost($value);

                            if ($post) {
                                $post_id = $post->id;
                                $hidden = '';
                                $preview_url = '/admin/posts/'.$post_id.'/preview';

                            }
                        } ?>

                        <a class="btn btn-default open-popup posts-selector" href="/admin/posts/selector">Choose Post</a>

                        <a class="btn btn-default can-hide preview<?=$hidden?>"  data-popover-url="" href="<?=$preview_url?>">Preview</a>

                        <button class="btn btn-default can-hide remove-destination<?=$hidden?>" type="button">Remove</button>

                        <input id="meta-value-<?=$uniqid?>" type="hidden" name="meta[<?=$uniqid?>][value]" value="<?=$post_id?>" class="meta-value destination" />


                    </div>

                <?php

                } elseif ($type == Meta::TYPE_MEDIA) { ?>

                    <div class="formspacer">

                        <?php
                        $media_id = '';
                        $hidden = ' hidden';
                        $edit_url = '/admin/media-editor/edit';
                        $preview_url = '/admin/media/preview';

                        if (is_numeric($value)) {

                            $media = Core::getMedia($value);

                            if ($media) {
                                $media_id = $media->id;
                                $hidden = '';
                                $edit_url = '/admin/media-editor/'.$media_id.'/edit';
                                $preview_url = '/admin/media/'.$media_id.'/preview';

                            }
                        } ?>

                        <a class="btn btn-default open-popup media-selector" href="/admin/media-editor/selector">Choose Media</a>

                        <a class="btn btn-default can-hide preview<?=$hidden?>"  data-popover-url="" href="<?=$preview_url?>">Preview</a>

                        <a class="btn btn-default open-popup can-hide media-editor<?=$hidden?>" href="<?=$edit_url?>">Edit</a>

                        <button class="btn btn-default can-hide remove-destination<?=$hidden?>" type="button">Remove</button>

                        <input id="meta-value-<?=$uniqid?>" type="hidden" name="meta[<?=$uniqid?>][value]" value="<?=$media_id?>" class="meta-value destination" />

                    </div>

                <?php

                } ?>

            </div>


        </div>
    </div>


</div>

