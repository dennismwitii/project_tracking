
//   $(document).ready(function () {
//     var flg = 0;
//     $('#update_payment_mode_id').on("select2:open", function () {
//       flg++;
//       if (flg == 1) {
//         $this_html = jQuery('#wrp1').html();
//         $(".select2-results").append("<div class='select2-results__option'>" +
//           $this_html + "</div>");
//       }
//     });
//   });
$(document).ready(function () {
  var flg = 0;
  $('#payment_mode_id').on("select2:open", function () {
    flg++;
    if (flg == 1) {
      $this_html = jQuery('#wrp').html();
      $(".select2-results").append("<div class='select2-results__option'>" +
        $this_html + "</div>");
    }
  });
});
$(document).on('click', '#modal-add-payment-mode', function () {
  $("#payment_mode_id").select2("close");


});

$('#fire-modal-41').on('hidden.bs.modal', function (e) {
  $(this).find('form').trigger('reset');
});
$('#fire-modal-31').on('hidden.bs.modal', function (e) {
  $(this).find('form').trigger('reset');
});
$('#fire-modal-4').on('hidden.bs.modal', function (e) {
  $(this).find('form').trigger('reset');
});
$('#fire-modal-3').on('hidden.bs.modal', function (e) {
  $(this).find('form').trigger('reset');
});

function queryParams(p) {
  return {
    limit: p.limit,
    sort: p.sort,
    order: p.order,
    offset: p.offset,
    search: p.search
  };
}
