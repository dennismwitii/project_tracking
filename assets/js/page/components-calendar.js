"use strict";

function queryParams(p){
  return {
    "type": $('#type').val(),
    limit:p.limit,
    sort:p.sort,
    order:p.order,
    offset:p.offset,
    search:p.search
  };
}

$('#filter-activity').on('click',function(e){
  e.preventDefault();
  $('#events_list').bootstrapTable('refresh');
});

