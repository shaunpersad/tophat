<form class="form-horizontal search-blog" role="form" action="/blog">
    <div class="input-group">

        <input type="text" class="form-control required" name="s" value="<?=@$vars->s?>" placeholder="search">
                <span class="input-group-btn">
                    <button type="submit" class="btn btn-default">
                        <i class="fa fa-search"></i>
                    </button>
                </span>
    </div>
</form>