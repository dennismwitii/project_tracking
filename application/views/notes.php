<!DOCTYPE html>
<html lang="en">

<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Notes &mdash; <?= get_compnay_title(); ?></title>

  <?php include('include-css.php'); ?>
</head>

<body>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">

    
    <?php include('include-header.php'); ?>
    
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1><?= !empty($this->lang->line('label_notes'))?$this->lang->line('label_notes'):'Notes'; ?></h1>
            <div class="section-header-breadcrumb">
              <i class="btn btn-primary btn-rounded no-shadow" id="modal-add-note" data-value="add"><?= !empty($this->lang->line('label_create_note'))?$this->lang->line('label_create_note'):'Create Note'; ?></i>
            </div>
          </div>

          <div class="section-body">
            <div class="row sticky-notes">
            <div class="modal-edit-note"></div>
              <?php if(!empty($notes)){ foreach ($notes as $note){ ?>
                <div class="col-md-4 sticky-note">
                    <div class="sticky-content sticky-note-<?=$note->class?>">
                        <h4><?= $note->title ?> <i class="fas fa-pencil-alt" id="modal-edit-note" data-id="<?= $note->id ?>"></i></h4>
                        <p><?= $note->description ?></p>
                    </div>
                </div>
              <?php } }else {  ?>
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                            <h4>No Notes Found!</h4>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
          </div>
        </section>
      </div>
      
      <?= form_open('notes/create', 'id="modal-add-note-part"', 'class="modal-part"'); ?>
        <div class="form-group">
          <label><?= !empty($this->lang->line('label_title'))?$this->lang->line('label_title'):'Title'; ?></label>
          <div class="input-group">
            <?=form_input(['name'=>'title','placeholder'=>'Title','class'=>'form-control'])?>
          </div>
        </div>
        <div class="form-group">
          <label><?= !empty($this->lang->line('label_description'))?$this->lang->line('label_description'):'Description'; ?></label>
          <div class="input-group">
          <textarea type="textarea" class="form-control" placeholder="description" name="description"></textarea>
          </div>
        </div>
        <div class="form-group">
          <label><?= !empty($this->lang->line('label_color'))?$this->lang->line('label_color'):'Color'; ?></label>
          <select class="form-control" name="class">
            <option value="bg-info"><?= !empty($this->lang->line('label_info'))?$this->lang->line('label_info'):'Info'; ?></option>
            <option value="bg-warning"><?= !empty($this->lang->line('label_warning'))?$this->lang->line('label_warning'):'Warning'; ?></option>
            <option value="bg-danger"><?= !empty($this->lang->line('label_danger'))?$this->lang->line('label_danger'):'Danger'; ?></option>
          </select>
        </div>
      </form>

      <?= form_open('notes/edit', 'id="modal-edit-note-part"', 'class="modal-part"'); ?>
        <div class="form-group">
          <label><?= !empty($this->lang->line('label_title'))?$this->lang->line('label_title'):'Title'; ?></label>
          <div class="input-group">
          <input type="hidden" name="update_id" id="update_id">
            <input type="text" class="form-control" placeholder="title" name="title" id="update_title">
          </div>
        </div>
        <div class="form-group">
          <label><?= !empty($this->lang->line('label_description'))?$this->lang->line('label_description'):'Description'; ?></label>
          <div class="input-group">
            <textarea type="textarea" class="form-control" placeholder="description" name="description" id="update_description"></textarea>
          </div>
        </div>
        <div class="form-group">
          <label>Color</label>
          <select class="form-control" name="class" id="update_class">
            <option value="bg-info"><?= !empty($this->lang->line('label_info'))?$this->lang->line('label_info'):'Info'; ?></option>
            <option value="bg-warning"><?= !empty($this->lang->line('label_warning'))?$this->lang->line('label_warning'):'Warning'; ?></option>
            <option value="bg-danger"><?= !empty($this->lang->line('label_danger'))?$this->lang->line('label_danger'):'Danger'; ?></option>
          </select>
        </div>
      </form>

      <?php include('include-footer.php'); ?>

    </div>
  </div>

<?php include('include-js.php'); ?>

</body>

</html>