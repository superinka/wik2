<form action="<?php echo base_url('site') ?>/search/index" method="get">
<div class="search-row">
    <input type="text" name="search_term" id="search_term" class="form-control" placeholder="Tìm kiếm..." required>
    <button type="submit" class="btn btn-primary btn-sm">
        <i class="ace-icon fa fa-search icon-on-right bigger-110"></i>
    </button>
</div>
</form>
<style>
.search-row{
    position:relative;
}
.search-row button {
    position:absolute;
    top:3px;
    right:5px;
}

</style>
