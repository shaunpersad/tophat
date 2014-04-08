<?php
$base_url ='/admin/sections/list';
?>
<div class="table-responsive">

    <form class="form-inline" role="form" action="<?=$base_url?>">


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

                if ($vars->order_by == 'sections.title' && $vars->order_dir == 'ASC') {

                    $order_dir = 'DESC';
                }

                $new_args = array(
                    'order_by' => 'sections.title',
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

                if ($vars->order_by == 'sections.slug' && $vars->order_dir == 'ASC') {

                    $order_dir = 'DESC';
                }

                $new_args = array(
                    'order_by' => 'sections.slug',
                    'page' => 1,
                    'order_dir' => $order_dir
                );

                $url = $base_url.'?'.http_build_query(array_merge($vars->args, $new_args));

                ?>


                <a href="<?=$url?>">Slug</a>

            </th>

            <th>

                <?php
                $order_dir = 'DESC';

                if ($vars->order_by == 'sections.date_created' && $vars->order_dir == 'DESC') {

                    $order_dir = 'ASC';
                }

                $new_args = array(
                    'order_by' => 'sections.date_created',
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

                if ($vars->order_by == 'sections.date_updated' && $vars->order_dir == 'DESC') {

                    $order_dir = 'ASC';
                }

                $new_args = array(
                    'order_by' => 'sections.date_updated',
                    'page' => 1,
                    'order_dir' => $order_dir
                );

                $url = $base_url.'?'.http_build_query(array_merge($vars->args, $new_args));

                ?>


                <a href="<?=$url?>">Date Updated</a>

            </th>

            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($vars->sections as $section) { ?>

            <tr>
                <td class="section-title"><?=$section->title?></td>
                <td class="section-slug"><?=$section->slug?></td>
                <td><?=$section->date_created?></td>
                <td><?=$section->date_updated?></td>

                <td class="actions">
                    <button class="btn btn-default edit-section btn-xs" data-section-id="<?=$section->id?>">Edit</button>
                    <a class="btn btn-default curate-section btn-xs" href="/admin/sections/<?=$section->id?>/curate">Curate</a>
                </td>


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