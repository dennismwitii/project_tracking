<form action="<?=base_url('workspace/create')?>" id="modal-add-Workspace-part" class="modal-part">
    <div class="form-group">
    <label><?= !empty($this->lang->line('label_name'))?$this->lang->line('label_name'):'Name'; ?></label>
    <div class="input-group">
        <input type="text" name="title" placeholder="Workspace Name" class="form-control">
    </div>
    </div> 
</form>

<form action="<?=base_url('workspace/edit')?>" id="modal-edit-Workspace-part" class="modal-part">
    <div class="form-group">
    <label><?= !empty($this->lang->line('label_name'))?$this->lang->line('label_name'):'Name'; ?></label>
    <div class="input-group">
        <input type="text" value="<?=get_workspace()?>" id="edit_title" name="title" placeholder="Workspace Name" class="form-control">
    </div>
    </div> 
</form>

<footer class="main-footer">
    <div class="footer-left">
    </div>
    <div class="footer-right">
        Copyright &copy; <?=date('Y');?> <div class="bullet"></div> Design & Developed By <a href="https://www.infinitietech.com/" target="_blank">Infinitie Technologies</a>
    </div>
</footer>

<script>
    base_url = "<?php echo base_url();?>";
    csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
    csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
</script>

