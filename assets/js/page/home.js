"use strict";

var ctx = document.getElementById('line-projects-chart').getContext('2d');
var projectChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: [label_ongoing, label_finished, label_onhold],
      datasets: [
        {
          label: label_projects,
          backgroundColor: ["#3abaf4", "#63ed7a", "#fc544b"],
          data: [ongoing_project_count,finished_project_count,onhold_project_count]
        }
      ]
    },
    options: {
      legend: { display: false },
    }
});

var ctx1 = document.getElementById('line-tasks-chart').getContext('2d');
var taskmyChart = new Chart(ctx1, {
    type: 'bar',
    data: {
      labels: [label_todo, label_in_progress, label_review, label_done],
      datasets: [
        {
          label: label_tasks,
          backgroundColor: ["#3abaf4", "#fc544b", "#ffc107","#63ed7a"],
          data: [todo_task,inprogress_task,review_task,done_task]
        }
      ]
    },
    options: {
      legend: { display: false },
    }
});
function queryParams(p){

  var from = $('#tasks_start_date').val();
  var to = $('#tasks_end_date').val();
  if(from !== '' && to !== ''){
    from = moment(from).format('YYYY-MM-DD');
    to = moment(to).format('YYYY-MM-DD');
    // console.log(from +'-'+ to);
  }
  return {
    "project": $('#projects_name').val(),
    "status": $('#tasks_status').val(),
    "from": from,
    "to": to,
    "workspace_id": home_workspace_id,
    "user_id": home_user_id,
    "is_admin": home_is_super_admin,
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