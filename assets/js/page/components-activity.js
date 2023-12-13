"use strict";

function queryParams(p){
  return {
    "activity": $('#activity').val(),
    "activity_type": $('#activity_type').val(),
    limit:p.limit,
    sort:p.sort,
    order:p.order,
    offset:p.offset,
    search:p.search
  };
}

$('#filter-activity').on('click',function(e){ 
  e.preventDefault();
  $('#activity_log_list').bootstrapTable('refresh');
});

