<?php
use TopHat\Core;
use TopHat\Media;
use TopHat\User;

$post = false;
if (!empty($vars->post)) {

    $post = $vars->post;
}

?>
<div class="row">
    <form id="post-form" role="form" autocomplete="off" action="/admin/posts/save" method="post">

        <div class="col-lg-12">

            <div class="form-group">

                <button class="btn btn-default" type="submit">Save</button>

            </div>

        </div>

        <div class="col-lg-6">

            <h3>The Essentials</h3>

            <?php
            if ($post) { ?>

                <input type="hidden" name="post[id]" value="<?=$post->id?>" />
            <?php
            }
            ?>

            <div class="form-group">
                <label for="post-title">Title</label>
                <input id="post-title" type="text" name="post[title]" class="form-control required" value="<?=@$post->title?>" />
                <p class="help-block">A title is required.</p>
            </div>

            <div class="form-group">
                <label for="post-status">Status</label>
                <select id="post-status" name="post[status]" class="form-control">

                    <?php
                    foreach (Core::$statuses as $status => $display) {

                        $selected = '';
                        if (@$post->status == $status) {

                            $selected = ' selected="selected"';
                        } ?>
                        <option value="<?=$status?>"<?=$selected?>><?=ucwords($display)?></option>
                    <?php
                    }
                    ?>

                </select>
            </div>

            <div class="form-group">
                <label for="post-body">Body</label>
                <textarea id="post-body" name="post[body]" rows="6" class="form-control"><?=@$post->body?></textarea>

                <label for="post-is-fancy-text" class="checkbox">
                    <?php
                    $checked = '';
                    if (@$post->is_fancy_text || !$post) {

                        $checked = ' checked="checked"';
                    }
                    ?>

                    <input id="post-is-fancy-text" class="toggle-fancy-text" name="post[is_fancy_text]" value="1" type="checkbox"<?=$checked?>> toggle fancy text
                </label>

            </div>

            <div class="form-group">
                <label>Image</label>
                <div class="formspacer">
                    <?php

                    $popup_url = '/admin/image-editor';
                    $hidden = ' hidden';
                    if ($post && !empty($post->image_id)) {

                        $popup_url.='?image_id='.$post->image_id;
                        $hidden = '';
                    }
                    ?>

                    <a class="btn btn-default open-popup media-selector" href="/admin/media-editor/selector?media_type=<?=Media::TYPE_IMAGE?>">Choose Image</a>

                    <a class="btn btn-default open-popup can-hide media-editor<?=$hidden?>" href="/admin/media-editor/edit">Edit</a>

                    <button class="btn btn-default can-hide remove-destination<?=$hidden?>" type="button">Remove</button>

                    <input type="hidden" id="post-image-id" name="post[image_id]" class="destination" value="<?=@$post->image_id?>" />

                </div>
                <div class="formspacer post-image-container">

                    <div class="post-image">

                        <?php
                        if ($post && $image = $post->image()) { ?>

                            <a class="view-image" href="<?=$image->url()?>">
                                <img src="<?=$image->url()?>" class="img-thumbnail" />
                            </a>
                        <?php
                        } else { ?>
                            <img style="width: 300px; height: 300px" src="/images/placeholder.jpg" class="post-thumbnail" />
                        <?php
                        }
                        ?>
                    </div>

                </div>
            </div>


        </div>
        <!-- /.col-lg-6 (primary col) -->

        <div class="col-lg-1">

        </div>

        <div class="col-lg-5">

            <div class="col-lg-12">

                <h3>
                    Categories
                    <button class="btn btn-xs btn-default btn-toggle-dropdowns" data-toggle="collapse" data-target="#categories-container" type="button">
                        <i class="fa fa-caret-up"></i>
                    </button>
                </h3>


                <div id="categories-container" class="form-group collapse in">

                    <div class="categories-container form-control">

                        <ul class="list-unstyled">

                            <?php

                            $categories = Core::getCategories(array('per_page' => 1000));

                            if (!empty($categories)) {

                                foreach ($categories as $category) {

                                    $class = '';
                                    $checked = '';
                                    if ($post && $post->isInCategory($category->id)) {

                                        $class = ' class="checked"';
                                        $checked = ' checked="checked"';
                                    }
                                    ?>

                                    <li>
                                        <label<?=$class?>>
                                            <input type="checkbox" name="category_ids[]" value="<?=$category->id?>"<?=$checked?> />
                                            <?=$category->title?>
                                        </label>
                                    </li>

                                <?php
                                }
                            }
                            ?>

                        </ul>


                    </div>

                    <p class="help-block">Check all that apply.</p>

                </div>

            </div>
            <!-- /.col-lg-12 (Categories) -->

            <div class="col-lg-12">

                <?php
                $all_meta = array();

                if ($post) {

                    $all_meta = $post->meta()->all();
                }

                $direction = 'down';
                $count = count($all_meta);

                if ($count) {

                    $direction = 'up';
                }

                ?>

                <h3>
                    Meta
                    <button class="btn btn-xs btn-default btn-toggle-dropdowns" data-toggle="collapse" data-target="#meta-container" type="button">
                        <i class="fa fa-caret-<?=$direction?>"></i>
                    </button>
                </h3>


                <div id="meta-container" class="collapse <?php if ($direction == 'up') { echo 'in'; }?>">

                    <div id="accordion" class="panel-group">

                        <?php

                        if (!empty($all_meta)) {

                            foreach ($all_meta as $title => $meta_data) {

                                foreach ($meta_data as $meta) {

                                    $this->render(
                                        'posts/meta-field',
                                        array(
                                            'title' => $meta['title'],
                                            'value' => $meta['value'],
                                            'type' => $meta['type']
                                        )
                                    );
                                }

                            }

                        }

                        $this->render('posts/meta-field');
                        ?>


                    </div>

                    <button class="btn btn-default add-another-meta-field" type="button">Add Another</button>

                </div>

            </div>
            <!-- /.col-lg-12 (Meta) -->

            <div class="col-lg-12">


                <h3>
                    Optional
                    <button class="btn btn-xs btn-default btn-toggle-dropdowns" data-toggle="collapse" data-target="#optional-container" type="button">
                        <i class="fa fa-caret-down"></i>
                    </button>
                </h3>

                <div id="optional-container" class="collapse">

                    <div class="form-group">
                        <label for="post-teaser">Teaser (optional)</label>
                        <textarea id="post-teaser" name="post[teaser]" rows="3" class="form-control"><?=@$post->teaser?></textarea>
                        <p class="help-block">A preview of the post.  By default will be based on the body.</p>
                    </div>

                    <div class="form-group">
                        <label for="post-slug">Slug (optional)</label>
                        <input id="post-slug" type="text" name="post[slug]" class="form-control" value="<?=@$post->slug?>" />
                        <p class="help-block">This appears as part of the url for this post.  By default will be based on the title.</p>
                    </div>

                    <?php
                    $current_user = Core::getCurrentUser();

                    if ($current_user && $current_user->type >= User::TYPE_ADMIN) { ?>

                        <div class="form-group">
                            <label for="post-author-id">Author (optional)</label>
                            <select id="post-author-id" name="post[author_id]" class="form-control">

                                <?php

                                $user_args = array(
                                    'user_type_in' => array(
                                        \TopHat\User::TYPE_AUTHOR,
                                        \TopHat\User::TYPE_ADMIN,
                                        \TopHat\User::TYPE_DEV
                                    ),
                                    'per_page' => 1000
                                );

                                $users = Core::getUsers($user_args);
                                $author_id = intval(@$post->author_id);

                                foreach ($users as $user) {

                                    $selected = '';

                                    if ((!$author_id && $user->id == $current_user->id) || $author_id == $user->id) {

                                        $selected = ' selected="selected"';
                                    } ?>
                                    <option value="<?=$user->id?>"<?=$selected?>><?=ucwords($user->display_name)?></option>
                                <?php
                                }
                                ?>

                            </select>
                            <p class="help-block">By default will be the current logged in user (you).</p>

                        </div>

                    <?php
                    }
                    ?>
                    <div class="form-group">
                        <label for="post-date-published">Date Published (optional)</label>
                        <?php
                        $date_published = '';
                        if (!empty($post->date_published)) {

                            $date_published = new \DateTime($post->date_published, new \DateTimeZone(TIMEZONE));
                            $date_published = $date_published->format('m/d/Y H:i');
                        }

                        ?>
                        <input id="post-date-published" placeholder="mm/dd/yyyy HH:mm (24 hour time)" type="text" name="post[date_published]" class="form-control" value="<?=$date_published?>" />
                        <p class="help-block">Note: setting this to a point in the future will not automatically publish this post at that time!</p>
                    </div>

                    <div class="form-group">
                        <label for="post-tags">Tags (optional)</label>

                        <?php

                        $tags = array();

                        if ($post) {

                            $tags = $post->tags();
                        }

                        ?>

                        <input type="text" id="post-tags" name="tags" rows="3" placeholder="Hit enter or place a comma to create a tag" value="<?=implode(', ', $tags)?>" />
                        <p class="help-block">Increases the searchability of your post..</p>


                    </div>


                </div>

            </div>
            <!-- /.col-lg-12 (Optional) -->


        </div>
        <!-- /.col-lg-5 (secondary col) -->


    </form>

</div>
