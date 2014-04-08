<div class="row">
    <div class="col-lg-12">
        <h1>Manage Sections</h1>
        <ol class="breadcrumb">
            <li class="active"><i class="icon-dashboard"></i> Sections</li>
        </ol>
    </div>
</div><!-- /.row -->
<div class="row">

    <div class="col-lg-4">

        <form id="section-form" method="post" action="/admin/sections/save" autocomplete="off">

            <div class="form-group">

                <button class="btn btn-default" type="submit">Save</button>
                <button class="btn btn-default" type="reset">Create New</button>

            </div>

            <input type="hidden" name="id" value="" />

            <div class="form-group">
                <label for="section-title">Title</label>
                <input id="section-title" type="text" name="title" class="form-control required" value="" />
                <p class="help-block">A title is required.</p>
            </div>

            <div class="form-group">
                <label for="section-slug">Slug (optional)</label>
                <input id="section-slug" type="text" name="slug" class="form-control" value="" />
                <p class="help-block">This appears as part of the url for this section.  By default will be based on the title.</p>
            </div>

        </form>
    </div>

    <div class="col-lg-1">

    </div>

    <div class="col-lg-7" id="sections-list">

        <?php

        $this->view = 'sections/list';
        $this->listAction();
        ?>
    </div>

</div>