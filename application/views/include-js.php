
  <!-- General JS Scripts -->
  <script src="<?=base_url('assets/modules/jquery.min.js');?>"></script>
  <script src="<?=base_url('assets/modules/popper.js');?>"></script>
  <script src="<?=base_url('assets/modules/tooltip.js');?>"></script>
  <script src="<?=base_url('assets/modules/bootstrap/js/'.$rtl.'bootstrap.min.js');?>"></script>
  <script src="<?=base_url('assets/modules/nicescroll/jquery.nicescroll.min.js');?>"></script>
  <script src="<?=base_url('assets/modules/moment.min.js');?>"></script>
  <script src="<?=base_url('assets/modules/select2/dist/js/select2.full.min.js');?>"></script>
  <script src="<?=base_url('assets/modules/bootstrap-daterangepicker/daterangepicker.js');?>"></script>
  <script src="<?=base_url('assets/js/stisla.js');?>"></script>
  
  <!-- JS Libraies -->
  <script src="<?=base_url('assets/modules/jquery.sparkline.min.js');?>"></script>
  <script src="<?=base_url('assets/modules/chart.min.js');?>"></script>
  <script src="<?=base_url('assets/modules/owlcarousel2/dist/owl.carousel.min.js');?>"></script> 
  <script src="<?=base_url('assets/modules/summernote/summernote-bs4.js');?>"></script>
  <script src="<?=base_url('assets/modules/chocolat/dist/js/jquery.chocolat.min.js');?>"></script>
  
  <script src="<?=base_url('assets/modules/dropzonejs/min/dropzone.min.js');?>"></script>
  <script src="<?=base_url('assets/modules/selectize/selectize.min.js');?>"></script>
  
  <script src="<?=base_url('assets/modules/dragula/dragula.min.js');?>"></script>

  <script src="<?=base_url('assets/modules/pagedown/Markdown.Converter.js');?>"></script>
  <script src="<?=base_url('assets/modules/pagedown/Markdown.Sanitizer.js');?>"></script>
  <script src="<?=base_url('assets/modules/pagedown/Markdown.Editor.js');?>"></script>

  <script src="<?=base_url('assets/modules/izitoast/js/iziToast.min.js');?>"></script>

  <script src="<?=base_url('assets/js/page/modules-toastr.js');?>"></script>
  <script src="<?=base_url('assets/modules/sweetalert/sweetalert.min.js');?>"></script>
  <script src="<?=base_url('assets/modules/cropper/cropper.min.js');?>"></script>

  <script src="<?=base_url('assets/modules/bootstrap-table/bootstrap-table.min.js');?>"></script>
  <script src="<?=base_url('assets/modules/bootstrap-table/bootstrap-table-mobile.js');?>"></script>
  <script src="<?=base_url('assets/modules/lightbox/lightbox.min.js');?>"></script>
  
  <script src="<?=base_url('assets/js/scripts.js');?>"></script>
  <script src="<?=base_url('assets/js/custom.js');?>"></script>
  <script src="<?=base_url('assets/js/common.js');?>"></script>

  <script src="<?=base_url('assets/fullcalendar/core/main.js');?>"></script>
  <script src="<?=base_url('assets/fullcalendar/interaction/main.js');?>"></script>
  <script src="<?=base_url('assets/fullcalendar/daygrid/main.js');?>"></script>
  <script src="<?=base_url('assets/fullcalendar/list/main.js');?>"></script>
  <script src="<?=base_url('assets/fullcalendar/google-calendar/main.js');?>"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/at.js/1.5.4/js/jquery.atwho.min.js" integrity="sha512-qYer2wXu9iDH5tmX2z/X4GybJuSqnYoW5llUtcrCd97bOmzyvkVrpMDkj9yeBrMXRfi3cIUF2jWvEeeIhCEQfw==" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Caret.js/0.3.1/jquery.caret.min.js" integrity="sha512-qclRGh1kwCdmGsi68M9XYAhbCC4xpGRq9VqVlYAQmsG29wQG0DKke/QiMFmuFY1NGXdJ75Wjkhez5nMcuTelgQ==" crossorigin="anonymous"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.8.4/tinymce.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.16.0/jquery.validate.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.3/jspdf.min.js"></script>
  <script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>

<?php if($this->session->flashdata('message')){ ?>
  <script>
  iziToast.<?=$this->session->flashdata('message_type');?>({
    title: "<?=$this->session->flashdata('message');?>",
    message: '',
    position: 'topRight'
  });
  </script>
<?php } ?>

