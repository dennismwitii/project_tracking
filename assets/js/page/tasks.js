function queryParams(p){

  var from = $('#tasks_start_date').val();
  var to = $('#tasks_end_date').val();
  if(from !== '' && to !== ''){
    from = moment(from).format('YYYY-MM-DD');
    to = moment(to).format('YYYY-MM-DD');
  }
  return {
    "user_id": $('#user_id').val(),
    "client_id": $('#client_id').val(),
    "project": $('#projects_name').val(),
    "status": $('#tasks_status').val(),
    "from": from,
    "to": to,
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

  $('#tasks_between').daterangepicker({

        showDropdowns: true,
        alwaysShowCalendars:true,
        autoUpdateInput: false,
        ranges: {
          'Today': [moment(), moment()],
          'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days': [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month': [moment().startOf('month'), moment().endOf('month')],
          'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate:moment().subtract(29, 'days'),
        endDate:moment(),
        locale: {
          "format": "DD/MM/YYYY",
          "separator": " - ",
          "cancelLabel": 'Clear'
        }
  });

  $('#tasks_between').on('apply.daterangepicker', function(ev, picker) {
      $('#tasks_start_date').val(picker.startDate.format('MM/DD/YYYY'));
      $('#tasks_end_date').val(picker.endDate.format('MM/DD/YYYY'));
      $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
  });

  $('#tasks_between').on('cancel.daterangepicker', function(ev, picker) {
      $(this).val('');
      $('#tasks_start_date').val('');
      $('#tasks_end_date').val('');
  });

});

!function (a) {
    "use strict";
    var t = function () {
        this.$body = a("body")
    };
    t.prototype.init = function () {
        a('[data-plugin="dragula"]').each(function () {
            var t = a(this).data("containers"), n = [];
            if (t) for (var i = 0; i < t.length; i++) n.push(a("#" + t[i])[0]); else n = [a(this)[0]];
            var r = a(this).data("handleclass");
            r ? dragula(n, {
                moves: function (a, t, n) {
                    return n.classList.contains(r)
                }
            }) : dragula(n).on('drop', function (el, target, source, sibling) {

                var sort = [];
                $("#"+target.id+" > div").each(function () {
                    sort[$(this).index()]=$(this).attr('id');
                });

                var id = el.id;
                var old_status = $("#"+source.id).data('status');
                var new_status = $("#"+target.id).data('status');
                var project_id = '1';

                $("#"+source.id).parent().find('.count').text($("#"+source.id+" > div").length);
                $("#"+target.id).parent().find('.count').text($("#"+target.id+" > div").length);
                
                // console.log('csrfHash:' +csrfHash);
                
                $.ajax({
                    url: base_url+'projects/task_status_update',
                    type: 'POST',
                    data: "id="+id+"&status="+new_status+"&"+csrfName+"="+csrfHash,
                    dataType: "json",
                    success: function(data){
                        
                        csrfName = data['csrfName'];
                        csrfHash = data['csrfHash'];
                    }
                });
                

            });


        })
    }, a.Dragula = new t, a.Dragula.Constructor = t
}(window.jQuery), function (a) {
    "use strict";
    a.Dragula.init()
}(window.jQuery);
