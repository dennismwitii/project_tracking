$(document).ready(function () {
  var flg = 0;
  $('#update_expense_type_id').on("select2:open", function () {
    flg++;
    if (flg == 1) {
      $this_html = jQuery('#wrp').html();
      $(".select2-results").append("<div class='select2-results__option'>" +
        $this_html + "</div>");
    }
  });
});
$(document).ready(function () {
  var flg = 0;
  $('#expense_type_id').on("select2:open", function () {
    flg++;
    if (flg == 1) {
      $this_html = jQuery('#wrp').html();
      $(".select2-results").append("<div class='select2-results__option'>" +
        $this_html + "</div>");
    }
  });
});
$(document).on('click', '#modal-add-expense-type', function () {
  $("#expense_type_id").select2("close");


});

$(document).on('click', '#modal-add-expense-type', function () {
  $("#update_expense_type_id").select2("close");

});
$('#fire-modal-5').on('hidden.bs.modal', function (e) {
  $(this).find('form').trigger('reset');
});

$('#fire-modal-3').on('hidden.bs.modal', function (e) {
  $(this).find('form').trigger('reset');
});
$('#fire-modal-51').on('hidden.bs.modal', function (e) {
  $(this).find('form').trigger('reset');
});
$('#fire-modal-31').on('hidden.bs.modal', function (e) {
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
