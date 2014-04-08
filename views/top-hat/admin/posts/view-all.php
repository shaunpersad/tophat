<?php
use TopHat\Core;
$base_url = '/admin/posts/view-all';

?>

<div class="row">
    <div class="col-lg-12">
        <h1>View All Posts</h1>
        <ol class="breadcrumb">
            <li class="active"><i class="icon-dashboard"></i> Posts</li>
        </ol>
    </div>
</div><!-- /.row -->

<div class="row" id="posts-view-all">
    <div class="col-lg-12">




    <div class="table-responsive">

        <form class="form-inline" role="form" action="<?=$base_url?>">

            <div class="form-group">

                <select name="category_id_in[]" class="form-control">

                    <option value="">select a category</option>
                    <?php
                    $categories = Core::getCategories(array('per_page' => 1000));

                    foreach ($categories as $category) {

                        $selected = '';
                        if (in_array($category->id, $vars->category_id_in)) {

                            $selected = ' selected="selected"';
                        } ?>

                        <option value="<?=$category->id?>"<?=$selected?>><?=$category->title?></option>
                        <?php
                    }
                    ?>

                </select>
            </div>
            <div class="form-group">

                <select name="status" class="form-control">

                    <option value="">select a status</option>
                    <?php
                    foreach (Core::$statuses as $status => $display) {

                        $selected = '';
                        if ($vars->status == $status) {

                            $selected = ' selected="selected"';
                        } ?>
                        <option value="<?=$status?>"<?=$selected?>><?=ucwords($display)?></option>
                    <?php
                    }
                    ?>
                </select>


            </div>

            <div class="form-group">

                <input type="text" class="form-control required" placeholder="search" name="s" value="<?=$vars->s?>">

            </div>

            <button type="submit" class="btn btn-default">Go</button>
            <a href="<?=$base_url?>" class="btn btn-default">Reset</a>
        </form>


        <table class="table table-striped table-bordered table-hover">
            <thead>
            <tr>
                <th>
                    <?php
                    $order_dir = 'ASC';

                    if ($vars->order_by == 'posts.title' && $vars->order_dir == 'ASC') {

                        $order_dir = 'DESC';
                    }

                    $new_args = array(
                        'order_by' => 'posts.title',
                        'page' => 1,
                        'order_dir' => $order_dir
                    );

                    $url = $base_url.'?'.http_build_query(array_merge($vars->args, $new_args));

                    ?>


                    <a href="<?=$url?>">Title</a>
                </th>
                <th>

                    <?php
                    $order_dir = 'ASC';

                    if ($vars->order_by == 'posts.teaser' && $vars->order_dir == 'ASC') {

                        $order_dir = 'DESC';
                    }

                    $new_args = array(
                        'order_by' => 'posts.teaser',
                        'page' => 1,
                        'order_dir' => $order_dir
                    );

                    $url = $base_url.'?'.http_build_query(array_merge($vars->args, $new_args));

                    ?>


                    <a href="<?=$url?>">Teaser</a>

                </th>
                <th>

                    <?php
                    $order_dir = 'ASC';

                    if ($vars->order_by == 'users.display_name' && $vars->order_dir == 'ASC') {

                        $order_dir = 'DESC';
                    }

                    $new_args = array(
                        'order_by' => 'users.display_name',
                        'page' => 1,
                        'order_dir' => $order_dir
                    );

                    $url = $base_url.'?'.http_build_query(array_merge($vars->args, $new_args));

                    ?>


                    <a href="<?=$url?>">Author</a>



                </th>
                <th>

                    <?php
                    $order_dir = 'DESC';

                    if ($vars->order_by == 'posts.status' && $vars->order_dir == 'DESC') {

                        $order_dir = 'ASC';
                    }

                    $new_args = array(
                        'order_by' => 'posts.status',
                        'page' => 1,
                        'order_dir' => $order_dir
                    );

                    $url = $base_url.'?'.http_build_query(array_merge($vars->args, $new_args));

                    ?>


                    <a href="<?=$url?>">Status</a>

                </th>

                <th>

                    <?php
                    $order_dir = 'DESC';

                    if ($vars->order_by == 'posts.date_created' && $vars->order_dir == 'DESC') {

                        $order_dir = 'ASC';
                    }

                    $new_args = array(
                        'order_by' => 'posts.date_created',
                        'page' => 1,
                        'order_dir' => $order_dir
                    );

                    $url = $base_url.'?'.http_build_query(array_merge($vars->args, $new_args));

                    ?>


                    <a href="<?=$url?>">Date Created</a>

                </th>

                <th>

                    <?php
                    $order_dir = 'DESC';

                    if ($vars->order_by == 'posts.date_updated' && $vars->order_dir == 'DESC') {

                        $order_dir = 'ASC';
                    }

                    $new_args = array(
                        'order_by' => 'posts.date_updated',
                        'page' => 1,
                        'order_dir' => $order_dir
                    );

                    $url = $base_url.'?'.http_build_query(array_merge($vars->args, $new_args));

                    ?>


                    <a href="<?=$url?>">Date Updated</a>

                </th>

                <th>

                    <?php
                    $order_dir = 'DESC';

                    if ($vars->order_by == 'posts.date_published' && $vars->order_dir == 'DESC') {

                        $order_dir = 'ASC';
                    }

                    $new_args = array(
                        'order_by' => 'posts.date_published',
                        'page' => 1,
                        'order_dir' => $order_dir
                    );

                    $url = $base_url.'?'.http_build_query(array_merge($vars->args, $new_args));

                    ?>


                    <a href="<?=$url?>">Date Published</a>

                </th>

                <th>Categories</th>


                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($vars->posts as $post) { ?>

                <tr>
                    <td><?=$post->title?></td>
                    <td><?=$post->teaser?></td>
                    <td><?=$post->author_display_name?></td>
                    <td><?=Core::$statuses[$post->status]?></td>
                    <td><?=$post->date_created?></td>
                    <td><?=$post->date_updated?></td>
                    <td><?=$post->date_published?></td>
                    <td>
                        <?php
                        $categories = $post->categories();

                        foreach ($categories as $category) {

                            echo $category->title.'<br />';
                        }
                        ?>

                    </td>

                    <td class="actions"><a class="btn btn-default btn-xs" href="/admin/posts/<?=$post->id?>/edit">Edit</a></td>
                </tr>

            <?php
            } ?>

            </tbody>
        </table>
        <ul class="pagination">
            <?php

            $num_pages = count($vars->page_list);


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



                <li class="paginate_button previous<?php if (!$prev){ echo ' disabled'; }?>">
                    <a href="<?=$base_url.'?'.http_build_query(array_merge($vars->args, array('page' => $prev)))?>">Previous</a>
                </li>
                <?php
                foreach ($vars->page_list as $page) {

                    $active = '';
                    if ($vars->current_page == $page) {
                        $active = ' active';
                    } ?>

                    <li class="paginate_button<?=$active?>">
                        <a href="<?=$base_url.'?'.http_build_query(array_merge($vars->args, array('page' => $page)))?>"><?=$page?></a>
                    </li>

                <?php
                }
                ?>

                <li class="paginate_button next<?php if (!$next){ echo ' disabled'; }?>">
                    <a href="<?=$base_url.'?'.http_build_query(array_merge($vars->args, array('page' => $next)))?>">Next</a>
                </li>

                <?php
            } ?>

        </ul>

    </div>
    <!-- /.table-responsive -->


    </div>
    <!-- /.col-lg-12 -->
</div>