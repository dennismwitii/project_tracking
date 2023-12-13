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


$('#filter').on('click',function(e){
  e.preventDefault();
  $('#announcements_list').bootstrapTable('refresh');
});

