
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

<?php if($this->session->flashdata('message')){ ?>
  <script>
  iziToast.info({
    title: "<?=$this->session->flashdata('message');?>",
    message: '',
    position: 'topRight'
  });
  </script>
<?php } ?>