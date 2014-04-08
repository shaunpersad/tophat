<div class="row">
    <div class="col-lg-12">
        <h1>Curate "<?=@$vars->section->title?>" Posts</h1>
        <ol class="breadcrumb">
            <li class="active"><a href="/admin/sections"><i class="icon-dashboard"></i> Sections</a></li>
            <li class="active"><i class="icon-dashboard"></i> Curate</li>
        </ol>
    </div>
</div><!-- /.row -->
<div class="row">

    <div class="col-lg-4">

        <form id="curated-posts-form" method="post" action="/admin/sections/<?=$vars->section->id?>/save-curated-posts" autocomplete="off">

            <div class="form-group">

                <button class="btn btn-default" type="submit">Save</button>

            </div>

            <div class="form-group">

                <div id="section-posts" class="well">

                    <?php

                    $posts = $vars->section->getPosts();

                    foreach ($posts as $post) {

                        $this->render('sections/post', array('post' => $post));
                    }
                    ?>
                </div>

            </div>


        </form>






    </div>

    <div class="col-lg-1">

        <div class="row"></div>
    </div>

    <div class="col-lg-7 posts-for-sections" id="posts-list">

        <?php

        use TopHat\Core;

        $order_by = 'posts.date_updated';
        $order_dir = 'DESC';
        $per_page = 30;
        $current_page = 1;
        $category_id_in = array();
        $s = '';

        $args = array(
            'page' => $current_page,
            'per_page' => $per_page,
            'category_id_in' => $category_id_in,
            'order_by' => $order_by,
            'order_dir' => $order_dir,
            's' => $s
        );

        $all_posts_count = Core::getPosts(array_merge($args, array('count_only' => true)));

        $total_num_pages = ceil($all_posts_count / $per_page);

        $num_pages_to_display = 10;

        $this->vars->order_by = $order_by;
        $this->vars->order_dir = $order_dir;
        $this->vars->current_page = $current_page;
        $this->vars->category_id_in = $category_id_in;
        $this->vars->s = $s;
        $this->vars->args = $args;
        $this->vars->page_list = Core::getPageList($current_page, $total_num_pages, $num_pages_to_display);
        $this->vars->posts = Core::getPosts($args);

        $this->render('posts/list');
        ?>
    </div>

</div>