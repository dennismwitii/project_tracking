"use strict";

function queryParams(p){
  return {
    "type": $('#type').val(),
    "user_type": $('#user_type').val(),
    limit:p.limit,
    sort:p.sort,
    order:p.order,
    offset:p.offset,
    search:p.search
  };
}
$('#filter-type').on('click',function(e){ 
  e.preventDefault();
  $('#notifications_list').bootstrapTable('refresh');
});

