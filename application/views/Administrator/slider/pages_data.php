<div>
    <form method="post" action="<?= base_url() ?>pages_store/<?= $page_content->page_name ;?>/<?= $title ;?>" enctype="multipart/form-data">
        <div class="form-group">
            <label for="page_content">Page Content</label>
            <textarea name="page_content"class="form-control summernote" id="page_content" rows="3"><?= $page_content->content ;?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>




