<!DOCTYPE html>
<html lang="en">

<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Auto Update System &mdash; <?= get_compnay_title(); ?></title>

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
            <h1>Updater (Version: <?=$db_current_version?>)</h1>
          </div>

          <div class="section-body">

            <div class="card">
              <div class="alert alert-danger">
                  <div class="alert-title">NOTE:</div>
                  Make sure you update system in sequence. Like if you have current version 1.0 and you want to update this version to 1.5 then you can't update it directly. You must have to update in sequence like first update version 1.2 then 1.3 and 1.4 so on.
              </div>
            </div>

            <?php if($file_current_version == false){ ?>
              <div class="card">
                <div class="card-header">
                  <h4>No Update found!</h4>
                </div>
                <div class="card-body">
                  It's seems like you don't have new update OR you have not uploaded the update zip file to the proper location. If you have got <b>update - v.XX to v.XX.zip</b> file with you then please upload update zip file proper location.
                </div>
              </div>
            <?php }elseif($is_updatable == false){ ?>
              <div class="card">
                <div class="card-header">
                  <h4>Invalid update file!</h4>
                </div>
                <div class="card-body">
                  It's seems like you are trying to update the system using wrong file.
                </div>
              </div>
            <?php }else{ ?>
              <div class="card">
                <div class="card-header">
                  <h4>Update from <?=$db_current_version?> to <?=$file_current_version?></h4>
                </div>
                <div class="card-body">
                  This is an Automatic Updater helps you update your App From <?=$db_current_version?> to <?=$file_current_version?>
                  <p>Click on update button to start updating...</p>
                  <span id='success-msg' class="d-none">
                  <div class="alert alert-success">
                      <div class="alert-title">Successful</div>
                      System updated successfully. Click on reload button to see the magic.
                  </div>
                  <a href="<?=base_url();?>" class="btn btn-danger text-white">Reload Now</a>
                  </span>
                  <div id="notsuccess-msg" class="alert alert-danger d-none">
                    Something goes wrong. Please try again...
                  </div>
                </div>
                <div class="card-footer text-right">
                  <button id="updater-btn" class="btn btn-primary">Update Now</button>
                </div>
              </div>
            <?php } ?>

          </div>
        </section>
      </div>

      <?php include('include-footer.php'); ?>

    </div>
  </div>

<?php include('include-js.php'); ?>
<script type="text/javascript">
  $(document).on('click','#updater-btn',function(e){
    if(confirm("Are you sure want to upgrade the system?")){
        e.preventDefault();
        $.ajax({
            url : base_url+'updater/update',
            type: "POST",
            data: csrfName+'='+csrfHash,
            dataType:'json',
            beforeSend: function() {
                // $('#result').fadeIn(100);
                $('#updater-btn').html('Please Wait... System is being updated'); 
                $('#updater-btn').prop('disabled', true);
            },
            success: function(result){

                csrfName = result['csrfName'];
                csrfHash = result['csrfHash'] ;
                console.log(result['error']);
                if(result['error'] == false){
                    $('#success-msg').removeClass('d-none');
                    $('#updater-btn').hide();
                }else{
                    $('#notsuccess-msg').removeClass('d-none');
                    $('#updater-btn').hide();
                }
                
            }
        });
    }
});
</script>
</body>

</html>