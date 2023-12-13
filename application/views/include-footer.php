<form action="<?= base_url('workspace/create') ?>" id="modal-add-Workspace-part" class="modal-part">
    <div class="form-group">
        <label><?= !empty($this->lang->line('label_name')) ? $this->lang->line('label_name') : 'Name'; ?></label>
        <div class="input-group">
            <input type="text" name="title" placeholder="Workspace Name" class="form-control">
        </div>
    </div>
</form>
<div class="modal-edit-workspace"></div>
<form action="<?= base_url('workspace/edit') ?>" id="modal-edit-Workspace-part" class="modal-part">
    <input type="hidden" id="workspace_id" name="workspace_id">
    <div class="form-group">
        <label><?= !empty($this->lang->line('label_name')) ? $this->lang->line('label_name') : 'Name'; ?></label>
        <div class="input-group">
            <input type="text" id="update_title" name="title" placeholder="Workspace Name" class="form-control">
        </div>
    </div>
    <div class="form-group status_div">
        <label><?= !empty($this->lang->line('label_status')) ? $this->lang->line('label_status') : 'Status'; ?></label>
        <div class="selectgroup w-100">
            <label class="selectgroup-item">
                <input type="radio" name="status" value="1" class="selectgroup-input">
                <span class="selectgroup-button"><?= !empty($this->lang->line('label_active')) ? $this->lang->line('label_active') : 'Active'; ?></span>
            </label>
            <label class="selectgroup-item">
                <input type="radio" name="status" value="0" class="selectgroup-input">
                <span class="selectgroup-button"><?= !empty($this->lang->line('label_deactive')) ? $this->lang->line('label_deactive') : 'Deactive'; ?></span>
            </label>
        </div>
    </div>
</form>

<footer class="main-footer">
    <div class="footer-left">
    </div>
    <div class="footer-right">
        Copyright &copy; <?= date('Y'); ?> <div class="bullet"></div> 
    </div>
</footer>

<script>
    base_url = "<?php echo base_url(); ?>";
    csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
        csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
</script>