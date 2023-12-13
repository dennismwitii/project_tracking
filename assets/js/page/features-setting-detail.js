"use strict";

$("#languages-setting-form").submit(function (e) {

  e.preventDefault();

  let save_button = $(this).find('#languages-save-btn'),
    output_status = $("#output-status"),
    card = $('#languages-settings-card');

  let card_progress = $.cardProgress(card, {
    spinner: false
  });
  save_button.addClass('btn-progress');
  output_status.html('');


  var formData = new FormData(this);

  $.ajax({
    type: 'POST',
    url: $(this).attr('action'),
    data: formData,
    dataType: 'json',
    cache: false,
    contentType: false,
    processData: false,
    success: function (result) {

      csrfName = result['csrfName'];
      csrfHash = result['csrfHash'];
      if (result['error'] == false) {
        location.reload();
      } else {
        $('#result').prepend('<div class="alert alert-danger">' + result['message'] + '</div>')
        $('#result').delay(4000).fadeOut();
      }
    }
  });

  card_progress.dismiss(function () {
    save_button.removeClass('btn-progress');
  });


});

$("#general-setting-form").submit(function (e) {

  e.preventDefault();

  let save_button = $(this).find('#general-save-btn'),
    output_status = $("#output-status"),
    card = $('#general-settings-card');

  let card_progress = $.cardProgress(card, {
    spinner: false
  });
  save_button.addClass('btn-progress');
  output_status.html('');


  var formData = new FormData(this);

  $.ajax({
    type: 'POST',
    url: $(this).attr('action'),
    data: formData,
    dataType: 'json',
    cache: false,
    contentType: false,
    processData: false,
    success: function (result) {

      csrfName = result['csrfName'];
      csrfHash = result['csrfHash'];
      if (result['error'] == false) {
        location.reload();
      } else if (result['error'] == true && result['is_reload'] == 1) {
        location.reload();
      }
      else {
        $('#result').prepend('<div class="alert alert-danger">' + result['message'] + '</div>')
        $('#result').delay(4000).fadeOut();
      }
    }
  });

  card_progress.dismiss(function () {
    save_button.removeClass('btn-progress');
  });


});


$("#email-setting-form").submit(function (e) {

  e.preventDefault();

  let save_button = $(this).find('#email-save-btn'),
    output_status = $("#output-status"),
    card = $('#email-settings-card');

  let card_progress = $.cardProgress(card, {
    spinner: false
  });
  save_button.addClass('btn-progress');
  output_status.html('');


  var formData = new FormData(this);

  $.ajax({
    type: 'POST',
    url: $(this).attr('action'),
    data: formData,
    dataType: 'json',
    cache: false,
    contentType: false,
    processData: false,
    success: function (result) {

      csrfName = result['csrfName'];
      csrfHash = result['csrfHash'];
      if (result['error'] == false) {
        location.reload();
      }
      else if (result['error'] == true && result['is_reload'] == 1) {
        location.reload();
      } else {
        $('#result').prepend('<div class="alert alert-danger">' + result['message'] + '</div>')
        $('#result').delay(4000).fadeOut();
      }
    }
  });

  card_progress.dismiss(function () {
    save_button.removeClass('btn-progress');
  });


});

$("#system-setting-form").submit(function (e) {

  e.preventDefault();

  let save_button = $(this).find('#system-save-btn'),
    output_status = $("#output-status"),
    card = $('#system-settings-card');

  let card_progress = $.cardProgress(card, {
    spinner: false
  });
  save_button.addClass('btn-progress');
  output_status.html('');


  var formData = new FormData(this);

  $.ajax({
    type: 'POST',
    url: $(this).attr('action'),
    data: formData,
    dataType: 'json',
    cache: false,
    contentType: false,
    processData: false,
    success: function (result) {

      csrfName = result['csrfName'];
      csrfHash = result['csrfHash'];
      if (result['error'] == false) {
        location.reload();
      } else if (result['error'] == true && result['is_reload'] == 1) {
        location.reload();
      }
      else {
        $('#result').prepend('<div class="alert alert-danger">' + result['message'] + '</div>')
        $('#result').delay(4000).fadeOut();
      }

    }
  });

  card_progress.dismiss(function () {
    save_button.removeClass('btn-progress');
  });


});
