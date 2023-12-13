
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
  $('#fire-modal-4').on('hidden.bs.modal', function (e) {
    $(this).find('form').trigger('reset');
  });
function queryParams(p){
    return {
      status:$("#status").val(),
      limit:p.limit,
      sort:p.sort,
      order:p.order,
      offset:p.offset,
      search:p.search
    };
    }
$(document).ready(function () {
    var flg = 0;

    $('#item_id').on("select2:open", function () {
        flg++;
        if (flg == 1) {
            $this_html = jQuery('#wrp').html();
            $(".select2-results").append("<div class='select2-results__option'>" +
                $this_html + "</div>");
        }
    });
});
$(document).on('click', '#modal-add-item', function () {
    $("#item_id").select2("close");


});
$('#client_id').on('change', function (e) {

    var client_id = $('#client_id').val();
    if (client_id != '') {
        $.ajax({
            type: 'POST',
            url: base_url + 'users/get_user_by_id/' + client_id,
            data: csrfName + '=' + csrfHash,
            dataType: "json",
            success: function (result) {
                csrfName = csrfName;
                csrfHash = result[0].csrfHash;
                billing_name = $(".billing_name").html();
                if(billing_name != '--'){
                    $('.billing_name').html(billing_name);
                    $('#update_name').val(billing_name);
                    $('#name').val(billing_name);
                }else{
                    $('.billing_name').html(result[0].name);
                    $('#update_name').val(result[0].name);
                    $('#name').val(result[0].name);
                }
                billing_address = $(".billing_address").html();
                if(billing_address != '--'){
                    $('.billing_address').html(billing_address);
                    $("textarea#update_address").val(billing_address);
                    $('#address').val(billing_address);
                }else{
                    $('.billing_address').html(result[0].address);
                    $("textarea#update_address").val(result[0].address);
                    $('#address').val(result[0].address);
                }
                billing_contact = $(".billing_contact").html();
                if(billing_contact != '--'){
                    $('.billing_contact').html(billing_contact);
                    $('#update_contact').val(billing_contact);
                    $('#contact').val(billing_contact);
                }else{
                    $('.billing_contact').html(result[0].phone);
                    $('#update_contact').val(result[0].phone);
                    $('#contact').val(result[0].phone);
                }
                billing_city = $(".billing_city").html();
                if(billing_city != '--'){
                    $('.billing_city').html(billing_city);
                    $('#update_city').val(billing_city);
                    $('#city').val(billing_city);
                }else{
                    $('.billing_city').html(result[0].city);
                    $('#update_city').val(result[0].city);
                    $('#city').val(result[0].city);
                }
                billing_state = $(".billing_state").html();
                if(billing_state != '--'){
                    $('.billing_state').html(billing_state);
                    $('#update_state').val(billing_state);
                    $('#state').val(billing_state);
                }else{
                    $('.billing_state').html(result[0].state);
                    $('#update_state').val(result[0].state);
                    $('#state').val(result[0].state);
                }
                billing_country = $(".billing_country").html();
                if(billing_country != '--'){
                    $('.billing_country').html(billing_country);
                    $('#update_country').val(billing_country);
                    $('#country').val(billing_country);
                }else{
                    $('.billing_country').html(result[0].country);
                    $('#update_country').val(result[0].country);
                    $('#country').val(result[0].country);
                }
                billing_zip = $(".billing_zip").html();
                if(billing_zip != '--'){
                    $('.billing_zip').html(billing_zip);
                    $('#update_zip_code').val(billing_zip);
                    $('#zip_code').val(billing_zip);
                }else{
                    $('.billing_zip').html(result[0].zip_code);
                    $('#update_zip_code').val(result[0].zip_code);
                    $('#zip_code').val(result[0].zip_code);
                }

                $('#id').val(result[0].id);

            }
        });
    } else {
        $('.billing_name').html('--');
        $('.billing_address').html('--');
        $('.billing_city').html('--');
        $('.billing_state').html('--');
        $('.billing_country').html('--');
        $('.billing_zip').html('--');
        $('.billing_contact').html('--');

        $('#update_name').val('');
        $("textarea#update_address").val('');
        $('#update_city').val('');
        $('#update_state').val('');
        $('#update_zip_code').val('');
        $('#update_country').val('');
        $('#update_contact').val('');
        $('#id').val('');

        $('#name').val('');
        $("textarea#address").val('');
        $('#contact').val('');
    }

});

$('#item_id').on('change', function (e) {

    var item_id = $('#item_id').val();
    if (item_id != '') {
        $.ajax({
            type: 'POST',
            url: base_url + 'items/get_item_by_id/' + item_id,
            data: csrfName + '=' + csrfHash,
            dataType: "json",
            success: function (result) {
                csrfName = csrfName;
                csrfHash = result.csrfHash;

                $('#item_0_title').val(result.title);
                $("textarea#item_0_description").val(result.description);
                $('#item_0_rate').val(result.price);
                if(result.unit_id == '0' || result.unit_id == ''){
                    $('#item_0_unit').val("");
                }else{
                    $('#item_0_unit').val(result.unit_id);
                }

            }
        });
    }
    // $('#item_id').val('');
});

$('#fire-modal-3').on('hidden.bs.modal', function (e) {
    if ($('#id').val() == '') {
        $(this).find('form').trigger('reset');
    }
});
$('#fire-modal-31').on('hidden.bs.modal', function (e) {
    // if ($('#id').val() == '') {
        $(this).find('form').trigger('reset');
    // }
});
$('#fire-modal-4').on('hidden.bs.modal', function (e) {
    $(this).find('form').trigger('reset');
});
$('#fire-modal-41').on('hidden.bs.modal', function (e) {
    $(this).find('form').trigger('reset');
});

$("#modal-edit-billing-address").fireModal({
    size: 'modal-md',
    title: 'Update Billing Address',
    body: $("#modal-edit-billing-address-part"),
    footerClass: 'bg-whitesmoke',
    autoFocus: false,


    onFormSubmit: function (modal, e, form) {
        var id = $('#id').val();
        form.stopProgress();
        $('#fire-modal-4').modal('hide');
        $('#fire-modal-41').modal('hide');
        if (id != '') {
            var name = $('#update_name').val();
            var address = $("textarea#update_address").val();
            var city = $('#update_city').val();
            var state = $('#update_state').val();
            var country = $('#update_country').val();
            var zip_code = $('#update_zip_code').val();
            var contact = $('#update_contact').val();

            $('.billing_name').html(name);
            $('.billing_address').html(address);
            $('.billing_city').html(city);
            $('.billing_state').html(state);
            $('.billing_country').html(country);
            $('.billing_zip').html(zip_code);
            $('.billing_contact').html(contact);

            $('#name').val(name);
            $("textarea#address").val(address);
            $('#city').val(city);
            $('#state').val(state);
            $('#country').val(country);
            $('#zip_code').val(zip_code);
            $('#contact').val(contact);

            iziToast.success({
                title: 'Billing address updated successfully!',
                message: '',
                position: 'topRight'
            });
        }else{
            iziToast.error({
                title: 'Invalid attempt detected please try again!',
                message: '',
                position: 'topRight'
            });
        }
        $('#fire-modal-41').modal('hide')
        $('#fire-modal-4').modal('hide');

        e.preventDefault();
    },
    shown: function (modal, form) {

        //   console.log(form)
    },

    buttons: [
        {
            text: 'Apply',
            submit: true,
            class: 'btn btn-primary btn-shadow',
            id: 'editbillingaddressbtn',
            handler: function (modal) {
            }
        }
    ]

});
var i = 0;
$(document).on('click', '.add-estimate-item', function (e) {
    e.preventDefault();
    item_id = $("#item_id").val();
    item_ids = $("#item_ids").val();
    item_ids = item_ids.toString();
    if(item_ids != ''){
        item_ids = item_ids+','+item_id;
    }
    else{
        item_ids = item_id;
    }
    $("#item_ids").val(item_ids)
    var title = $("#item_0_title").val();
    var description = $("#item_0_description").val();
    var quantity = $("#item_0_quantity").val();
    var unit = $("#item_0_unit").val();
    var rate = $("#item_0_rate").val();
    var tax = $("#item_0_tax").val();
    var tax_percentage = $("#item_0_tax option:selected").text();
    var amount = $("#item_0_amount").val();
    if(amount == ''){
        amount = rate * quantity;
    }
    amount = +amount + +0;
    amount = amount.toFixed(2);
    var tax_amount = amount / 100 * tax_percentage;
    if (title != '') {
        $('#item_id').val('').trigger('change');
        i++;
        html = '<div class="estimate-item py-1">' +
            '<div class="row">' +
            // '<input type="hidden" id=item_' + i + '_id name="item_id">' +
            '<input type="hidden" id=item_' + i + ' name="item[]">' +
            '<div class="col-md-3 custom-col">' +
            '<input type="text" class="form-control title" name="title[]" id=item_' + i + '_title placeholder="Title">' +
            '</div>' +
            '<div class="col-md-3 custom-col">' +
            '<textarea type="textarea" class="form-control" placeholder="Description" name="description[]" id=item_' + i + '_description></textarea>' +
            '</div>' +
            '<div class="col-md-1 custom-col">' +
            '<input type="number" class="form-control quantity" name="quantity[]" id="item_' + i + '_quantity" onchange="update_amount('+i+')" min="1" placeholder="Qty" data-id="test">' +

            '</div>' +
            '<div class="col-md-1 custom-col">' +
            '<select class="form-control" name="unit[]" id=item_' + i + '_unit>' +
            units +
            '</select>' +
            '</div>' +
            '<div class="col-md-1 custom-col">' +
            '<input type="number" class="form-control" name="rate[]" id="item_' + i + '_rate" onchange="update_amount('+i+')" min="0" placeholder="Rate">' +
            '</div>' +
            '<div class="col-md-1 custom-col">' +
            '<select class="form-control" name="tax[]" id="item_' + i + '_tax" onchange="update_amount('+i+');update_tax_title('+i+')">' +
            taxes +
            '</select>' +
            '<div class="item_'+i+'_tax_title"></div>'+
            '</div>' +
            '<div class="col-md-1 custom-col">'+
            '<input type="number" class="form-control" name="amount[]" id="item_' + i + '_amount" onchange="update_amount1('+i+')" placeholder="'+ currency +'"></input>'+
            '</div>' +
            '<div class="col-md-1 custom-col">' +
            '<a href="#" class="btn btn-icon btn-danger remove-estimate-item" data-count='+i+'><i class="fas fa-trash"></i></a>' +
            '</div></div>' +
            '</div>';

        $('#estimate_items').append(html);
        // $('#item_' + i + '_id_1').val(item_id);
        $('#item_' + i).val(item_id);
        $('#item_' + i + '_title').val(title);
        $('#item_' + i + '_description').val(description);
        $('#item_' + i + '_quantity').val(quantity);
        $('#item_' + i + '_unit').val(unit);
        $('#item_' + i + '_rate').val(rate);
        $('#item_' + i + '_tax').val(tax);
        $('#item_' + i + '_tax_title').val(tax);
        $('#item_' + i + '_amount').val(amount);
        sub_total = $('#sub_total').val();
        new_sub_total = +sub_total + +amount;
        rounded_sub_total = new_sub_total.toFixed(2);
        $('#sub_total').val(rounded_sub_total);
        total_tax = $('#total_tax').val();
        new_total_tax = +tax_amount + +total_tax;
        rounded_total_tax = new_total_tax.toFixed(2);
        $('#total_tax').val(rounded_total_tax);
        total_tax = $('#total_tax').val();
        
        sub_total = $('#sub_total').val();
        final_total = +sub_total+ +total_tax;
        rounded_final_total = final_total.toFixed(2);
        $('#final_total').val(rounded_final_total);
        update_tax_title(i);

        $("#item_0_title").val('');
        $("#item_0_description").val('');
        $("#item_0_quantity").val('');
        $("#item_0_unit").val('');
        $("#item_0_rate").val('');
        $("#item_0_tax").val('');
        $("#item_0_amount").val('');
    } else {
        iziToast.error({
            title: "Please choose product / service",
            message: '',
            position: 'topRight'
        });
    }


});
$(document).on('click', '.remove-estimate-item', function (e) {
    e.preventDefault();
    count = $(this).data('count');
    item_ids = $("#item_ids").val();
    item_ids = item_ids.split(',');
    item_id = $("#item_"+count+"_id").val();
    
    if(jQuery.inArray(item_id, item_ids) != -1){
        removeA(item_ids, item_id);
        $("#item_ids").val(item_ids);
    }
    item_ids = $("#item_ids").val()
    // console.log(item_id);
    var quantity = $("#item_"+count+"_quantity").val();
    var rate = $("#item_"+count+"_rate").val();
                
    var amount = rate * quantity;
    var tax_amount = amount / 100 * tax_percentage;
    var final_amount = +amount + +tax_amount;
    rounded_final_amount = final_amount.toFixed(2);

    sub_total = $('#sub_total').val();
    new_sub_total = sub_total - amount;
    rounded_sub_total = new_sub_total.toFixed(2);
    $('#sub_total').val(rounded_sub_total);

    total_tax = $('#total_tax').val();
    new_tax_amount = total_tax - tax_amount;
    rounded_tax_amount = new_tax_amount.toFixed(2);
    $('#total_tax').val(rounded_tax_amount);

    current_final_total = $('#final_total').val();
    new_final_total = current_final_total - rounded_final_amount;

    new_final_total = new_final_total.toFixed(2);
    $('#final_total').val(new_final_total);
    $(this).closest('.estimate-item').remove();
});
function update_amount(count){

    quantity = $('#item_'+count+'_quantity').val();
    amount = $('#item_'+count+'_amount').val();
    rate = $('#item_'+count+'_rate').val();
    new_amount = rate * quantity;
    new_amount = parseFloat(new_amount).toFixed(2);
    $('#item_'+count+'_amount').val(new_amount);

    sub_total = $('#sub_total').val();
    new_sub_total = +sub_total + +new_amount;
    new_sub_total = new_sub_total - amount;
    new_sub_total = parseFloat(new_sub_total).toFixed(2);
    $('#sub_total').val(new_sub_total);

    total_tax = $('#total_tax').val();
    tax_percentage = $("#item_"+i+"_tax option:selected").text();
    tax_amount = rate * quantity / 100 * tax_percentage;
    new_total_tax = +total_tax + +tax_amount;
    new_total_tax = new_total_tax - total_tax;
    new_total_tax = parseFloat(new_total_tax).toFixed(2);
    $('#total_tax').val(new_total_tax);

    final_total = $('#final_total').val();
    total_tax = $('#total_tax').val();
    sub_total = $('#sub_total').val();
    new_final_total = +total_tax + +sub_total;
    new_final_total = parseFloat(new_final_total).toFixed(2);
    $('#final_total').val(new_final_total);
}

function update_amount1(count){

    quantity = $('#item_'+count+'_quantity').val();
    rate = $('#item_'+count+'_rate').val();
    new_amount = rate * quantity;
    new_amount = parseFloat(new_amount).toFixed(2);

    sub_total = $('#sub_total').val();
    new_sub_total = +sub_total + +new_amount;
    new_sub_total = parseFloat(new_sub_total).toFixed(2);
    $('#sub_total').val(new_sub_total);

    total_tax = $('#total_tax').val();
    tax_percentage = $("#item_"+i+"_tax option:selected").text();
    tax_amount = rate * quantity / 100 * tax_percentage;
    new_total_tax = +total_tax + +tax_amount;
    new_total_tax = parseFloat(new_total_tax).toFixed(2);
    $('#total_tax').val(new_total_tax);

    final_total = $('#final_total').val();
    total_tax = $('#total_tax').val();
    sub_total = $('#sub_total').val();
    new_final_total = +total_tax + +sub_total;
    new_final_total = parseFloat(new_final_total).toFixed(2);
    $('#final_total').val(new_final_total);
}
function update_tax_title(count){
    tax_id = $('#item_'+count+'_tax').val();
    if (tax_id != '') {
        $.ajax({
            type: 'POST',
            url: base_url + 'taxes/get_tax_by_id/' + tax_id,
            data: csrfName + '=' + csrfHash,
            dataType: "json",
            success: function (result) {
                csrfName = csrfName;
                csrfHash = result.csrfHash;
                $('.item_'+count+'_tax_title').html(result.title+'('+result.percentage+'%)');

            }
        });
    }else{
        $('.item_'+count+'_tax_title').html('');
    }
    
}
function removeA(arr) {
    var what, a = arguments, L = a.length, ax;
    while (L > 1 && arr.length) {
        what = a[--L];
        while ((ax= arr.indexOf(what)) !== -1) {
            arr.splice(ax, 1);
        }
    }
    return arr;
}

  $('#create_invoice_form').validate({
    rules:{
    client_id:"required",
    final_total:"required",
    }
  });

  $('#create_invoice_form').on('submit',function(e){
      e.preventDefault();
      var formData = new FormData(this);
      formData.append(csrfName, csrfHash);
      if ($("#create_invoice_form").validate().form()) {
      $.ajax({
      type:'POST',
      url: $(this).attr('action'),
      data:formData,
      beforeSend:function(){$('#submit_button').html('Please Wait..');$('#submit_button').attr('disabled',true);},
      cache:false,
      contentType: false,
      processData: false,
      dataType: "json",
      success:function(result){
        $('#submit_button').html('Submit');$('#submit_button').attr('disabled',false);
        csrfName = result['csrfName'];
        csrfHash = result['csrfHash'];
        if(result['error'] == false){
          location.reload();
        }else{
            iziToast.error({
                title: result['message'],
                message: '',
                position: 'topRight'
              });
        }
    
      }
      });
    }
    });
    $('.nav-pills').on('click', 'li a', function() {
        $('.nav-pills li a.active').removeClass('active');
        $(this).addClass('active');
        status = $(this).data("id");
        $("#status").val(status);
        $("#invoice_list").bootstrapTable('refresh');
    })
