<?php $data = get_system_settings('general');
if(!empty($data)){
  $data = json_decode($data[0]['data']);
}
$rtl = is_rtl()?'rtl/':'';
?>  
  
<link rel="shortcut icon" href="<?= !empty($data->favicon)? base_url('assets/icons/'.$data->favicon):base_url('assets/icons/logo-half.png'); ?>">
 
 <!-- General CSS Files -->
  
  <link rel="stylesheet" href="<?=base_url('assets/modules/bootstrap/css/'.$rtl.'bootstrap.min.css');?>">
  <link rel="stylesheet" href="<?=base_url('assets/modules/fontawesome/css/all.min.css');?>">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="<?=base_url('assets/modules/dragula/dragula.min.css');?>" >
  
  <link rel="stylesheet" href="<?=base_url('assets/modules/bootstrap-daterangepicker/daterangepicker.css');?>">
  <link rel="stylesheet" href="<?=base_url('assets/modules/select2/dist/css/select2.min.css');?>">
  <link rel="stylesheet" href="<?=base_url('assets/modules/jqvmap/dist/jqvmap.min.css');?>">
  <link rel="stylesheet" href="<?=base_url('assets/modules/summernote/summernote-bs4.css');?>">
  <link rel="stylesheet" href="<?=base_url('assets/modules/owlcarousel2/dist/assets/owl.carousel.min.css');?>">
  <link rel="stylesheet" href="<?=base_url('assets/modules/owlcarousel2/dist/assets/owl.theme.default.min.css');?>">
  
  <link rel="stylesheet" href="<?=base_url('assets/modules/chocolat/dist/css/chocolat.css');?>">
  
  <link rel="stylesheet" href="<?=base_url('assets/modules/dropzonejs/dropzone.css');?>">
  
  <!-- Template CSS -->
  <link rel="stylesheet" href="<?=base_url('assets/css/'.$rtl.'style.css');?>">
  <link rel="stylesheet" href="<?=base_url('assets/css/'.$rtl.'components.css');?>">
  <link rel="stylesheet" href="<?=base_url('assets/css/'.$rtl.'custom.css');?>"> 

  <link rel="stylesheet" href="<?=base_url('assets/modules/izitoast/css/iziToast.min.css');?>">
    
  <link rel="stylesheet" href="<?=base_url('assets/modules/selectize/selectize.min.css');?>">
  <link rel="stylesheet" href="<?=base_url('assets/modules/cropper/cropper.min.css');?>">
  <link rel="stylesheet" href="<?=base_url('assets/modules/bootstrap-table/bootstrap-table.min.css');?>">
  <link rel="stylesheet" href="<?=base_url('assets/modules/lightbox/lightbox.min.css');?>">

<?php $my_system_fonts = get_system_fonts();
  if($my_system_fonts != 'default' && !empty($my_system_fonts->id) && !empty($my_system_fonts->font_cdn) && !empty($my_system_fonts->font_name) && !empty($my_system_fonts->font_family) && !empty($my_system_fonts->class)){ ?>
  <link rel="stylesheet" href="<?=$my_system_fonts->font_cdn?>">
  <style>
    body {
      font-family: <?=$my_system_fonts->font_family?>;
    }
  </style>
<?php } ?>  