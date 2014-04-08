<div class="row">
    <div class="col-lg-12">
        <h1>Manage Categories</h1>
        <ol class="breadcrumb">
            <li class="active"><i class="icon-dashboard"></i> Categories</li>
        </ol>
    </div>
</div><!-- /.row -->
<div class="row">

    <div class="col-lg-4">

        <form id="category-form" method="post" action="/admin/categories/save" autocomplete="off">

            <div class="form-group">

                <button class="btn btn-default" type="submit">Save</button>
                <button class="btn btn-default" type="reset">Create New</button>

            </div>

            <input type="hidden" name="id" value="<?=@$vars->category->id?>" />

            <div class="form-group">
                <label for="category-title">Title</label>
                <input id="category-title" type="text" name="title" class="form-control required" value="<?=@$vars->category->title?>" />
                <p class="help-block">A title is required.</p>
            </div>

            <div class="form-group">
                <label for="category-slug">Slug (optional)</label>
                <input id="category-slug" type="text" name="slug" class="form-control" value="<?=@$vars->category->slug?>" />
                <p class="help-block">This appears as part of the url for this category.  By default will be based on the title.</p>
            </div>

        </form>
    </div>

    <div class="col-lg-1">

    </div>

    <div class="col-lg-7" id="categories-list">

        <?php

        $this->view = 'categories/list';
        $this->listAction();
        ?>
    </div>

</div>