$(document).ready(function() {
  var dataFieldError = '';

  var optionsCreate = {
    complete: function(response) {
      if (response.status == 200) {

        $("#ajax-messases").css({
          "display": "block"
        });

        $("#ajax-messases").find('.messases-text').html("Thêm mới thành công");

        window.setTimeout(function() {
          $("#ajax-messases").css({
            "display": "none"
          });
        }, 3000);

        $('html, body').animate({
          scrollTop: 0
        }, 1000);

        resetFormError();

      } else {
        // console.clear();
        showFormError(response.responseJSON);
      }
      $('#ajax-messases-loading').css({ "display": "none" });
      $('#button-create').attr('disabled', false);
    },
    beforeSerialize: function($form, options) {
    },
    beforeSubmit: function(arr, $form, options) {
      $('#send-process').width('0%');
      $('#ajax-messases-loading').css({ "display": "block" });
      $('#button-create').attr('disabled', true);
    },
    resetForm: true,
    uploadProgress: function(event, position, total, percentComplete) {
      percentVal = percentComplete + '%';
      $('#send-process').width(percentVal);
    },
  };


  var optionsUpdate = {
    complete: function(response) {
      if (response.status == 200) {
        $('body').animate({
          scrollTop: 0
        }, 1000);
        $("#ajax-messases").css({
          "display": "block"
        });

        $("#ajax-messases").find('.messases-text').html("Chỉnh sửa thông tin thành công");

        window.setTimeout(function() {
          $("#ajax-messases").css({
            "display": "none"
          });
        }, 3000);

        $('html, body').animate({
          scrollTop: 0
        }, 1000);

        resetFormError();

      } else {
        showFormError(response.responseJSON);
      }
      $('#ajax-messases-loading').css({ "display": "none" });
      $('#button-update').attr('disabled', false);
    },
    beforeSerialize: function($form, options) {
    },
    beforeSubmit: function(arr, $form, options) {
      $('#send-process').width('0%');
      $('#ajax-messases-loading').css({ "display": "block" });
      $('#button-update').attr('disabled', true);
    },
    uploadProgress: function(event, position, total, percentComplete) {
      percentVal = percentComplete + '%';
      $('#send-process').width(percentVal);
    },
  };

  $("#form-create").ajaxForm(optionsCreate);
  $("#form-update").ajaxForm(optionsUpdate);


  function showFormError(responseText) {
    $('html, body').animate({
      scrollTop: 0
    }, 1000);
    resetFormError();
    dataFieldError = responseText;
    $.each(responseText, function(k, v) {
      k = k.replace('.0','');
      id_error = $('#'+k);
      id_error.addClass('is-invalid');
      html_feedback = `<div class="invalid-feedback mc-invalid-feedback">${v}</div>`;
      id_error.closest('.mc-form-input').append(html_feedback);
    });
  }

  function resetFormError() {
    $.each(dataFieldError, function(k, v) {
      k = k.replace('.0','');
      id_error = $('#'+k);
      id_error.removeClass('is-invalid');
      id_error.closest('.mc-form-input').find('.mc-invalid-feedback').html('');
    });

    dataFieldError = '';

    $('#send-process').width('0%');
  }

});