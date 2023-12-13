function queryParams(p){

  return {
    limit:p.limit,
    sort:p.sort,
    order:p.order,
    offset:p.offset,
    search:p.search
  };
}

$('#fillter-tasks').on('click',function(e){
  e.preventDefault();
  $('#tasks_list').bootstrapTable('refresh');
});
    
$(function() {

  $('#leaves_between').daterangepicker({

        showDropdowns: true,
        alwaysShowCalendars:true,
        autoUpdateInput: false,
        ranges: {
          'Tomorrow': [moment().add(1, 'days'),moment().add(1, 'days')],
          'Upcoming 7 Days': [moment().add(1, 'days'),moment().add(7, 'days')],
          'Upcoming 30 Days': [moment().add(1, 'days'),moment().add(30, 'days')]
        },
        startDate:moment().subtract(29, 'days'),
        endDate:moment(),
        locale: {
          "format": "DD/MM/YYYY",
          "separator": " - ",
          "cancelLabel": 'Clear'
        }
  });

  $('#leaves_between').on('apply.daterangepicker', function(ev, picker) {
      $('#leave_from').val(picker.startDate.format('YYYY-MM-DD'));
      $('#leave_to').val(picker.endDate.format('YYYY-MM-DD'));
      $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
  });

  $('#leaves_between').on('cancel.daterangepicker', function(ev, picker) {
      $(this).val('');
      $('#leave_from').val('');
      $('#leave_to').val('');
  });

});

$(function() {

  $('#edit_leaves_between').daterangepicker({

        showDropdowns: true,
        alwaysShowCalendars:true,
        autoUpdateInput: false,
        ranges: {
          'Tomorrow': [moment().add(1, 'days'),moment().add(1, 'days')],
          'Upcoming 7 Days': [moment().add(1, 'days'),moment().add(7, 'days')],
          'Upcoming 30 Days': [moment().add(1, 'days'),moment().add(30, 'days')]
        },
        startDate:moment().subtract(29, 'days'),
        endDate:moment(),
        locale: {
          "format": "DD/MM/YYYY",
          "separator": " - ",
          "cancelLabel": 'Clear'
        }
  });

  $('#edit_leaves_between').on('apply.daterangepicker', function(ev, picker) {
      $('#edit_leave_from').val(picker.startDate.format('YYYY-MM-DD'));
      $('#edit_leave_to').val(picker.endDate.format('YYYY-MM-DD'));
      $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
  });

  $('#edit_leaves_between').on('cancel.daterangepicker', function(ev, picker) {
      $(this).val('');
      $('#edit_leave_from').val('');
      $('#edit_leave_to').val('');
  });

});

