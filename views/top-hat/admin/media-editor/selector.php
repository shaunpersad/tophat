<div id="media-selector">

    <div class="panel panel-default">
        <div class="panel-heading">

            <?php
            $create_new_url = '/admin/media-editor/create-new';
            $title = 'Media';
            if (!empty($vars->media_type)) {
                $create_new_url.='?media_type='.urlencode($vars->media_type);
                $title = ucwords($vars->media_type);
            }
            $base_url = '/admin/media-editor/selector';
            ?>

            <a href="<?=$create_new_url?>" class="btn btn-default open-popup">Create New <?=$title?></a>

        </div>
        <div class="panel-body">


            <div class="table-responsive">

                <form class="form-inline" role="form" action="<?=$base_url?>">
                    <div class="form-group">
                        <?php
                        if (!empty($vars->media_type)) {?>

                            <input type="hidden" name="media_type" value="<?=$vars->media_type?>" />
                        <?php
                        } ?>

                        <input type="text" class="form-control required" placeholder="search" name="s" value="<?=$vars->s?>">
                    </div>
                    <button type="submit" class="btn btn-default">Go</button>
                    <a href="<?=$base_url.'?media_type='.urlencode($vars->media_type)?>" class="btn btn-default">Reset</a>
                </form>


                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>
                            <?php
                            $order_dir = 'ASC';

                            if ($vars->order_by == 'media.title' && $vars->order_dir == 'ASC') {

                                $order_dir = 'DESC';
                            }

                            $new_args = array(
                                'order_by' => 'media.title',
                                'page' => 1,
                                'order_dir' => $order_dir
                            );

                            $url = $base_url.'?'.http_build_query(array_merge($vars->args, $new_args));

                            ?>


                            <a href="<?=$url?>">Title</a>
                        </th>
                        <?php
                        if (empty($vars->media_type)) { ?>

                            <th>

                                <?php
                                $order_dir = 'ASC';

                                if ($vars->order_by == 'media.type' && $vars->order_dir == 'ASC') {

                                    $order_dir = 'DESC';
                                }

                                $new_args = array(
                                    'order_by' => 'media.type',
                                    'page' => 1,
                                    'order_dir' => $order_dir
                                );

                                $url = $base_url.'?'.http_build_query(array_merge($vars->args, $new_args));

                                ?>


                                <a href="<?=$url?>">Type</a>

                            </th>

                        <?php
                        }
                        ?>
                        <th>

                            <?php
                            $order_dir = 'ASC';

                            if ($vars->order_by == 'media.source' && $vars->order_dir == 'ASC') {

                                $order_dir = 'DESC';
                            }

                            $new_args = array(
                                'order_by' => 'media.source',
                                'page' => 1,
                                'order_dir' => $order_dir
                            );

                            $url = $base_url.'?'.http_build_query(array_merge($vars->args, $new_args));

                            ?>


                            <a href="<?=$url?>">Source</a>



                        </th>
                        <th>

                            <?php
                            $order_dir = 'DESC';

                            if ($vars->order_by == 'media.date_updated' && $vars->order_dir == 'DESC') {

                                $order_dir = 'ASC';
                            }

                            $new_args = array(
                                'order_by' => 'media.date_updated',
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
                    foreach ($vars->medias as $media) { ?>

                        <tr>
                            <td><?=$media->title?></td>
                            <?php
                            if (empty($vars->media_type)) { ?>

                                <td><?=ucwords($media->type)?></td>

                            <?php
                            }
                            ?>
                            <td><?=ucwords($media->source)?></td>
                            <td><?=$media->date_updated?></td>
                            <td class="actions"><a class="btn btn-default btn-xs open-popup" href="/admin/media-editor/<?=$media->id?>/edit">Edit and Use</a></td>
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

    </div>

</div>

 