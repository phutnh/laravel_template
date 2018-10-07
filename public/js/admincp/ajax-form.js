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

        $('body').animate({
          scrollTop: 0
        }, 500);

        resetFormError();

      } else {
        console.clear();
        showFormError(response.responseJSON);
      }

    },
    beforeSerialize: function($form, options) {
    },
    beforeSubmit: function(arr, $form, options) {
    },

    resetForm: true
  };


  var optionsUpdate = {
    complete: function(response) {
      if (response.status == 200) {
        $('body').animate({
          scrollTop: 0
        }, 500);
        $("#ajax-messases").css({
          "display": "block"
        });

        $("#ajax-messases").find('.messases-text').html("Chỉnh sửa thông tin thành công");

        window.setTimeout(function() {
          $("#ajax-messases").css({
            "display": "none"
          });
        }, 3000);

        resetFormError();

      } else {
        console.clear();
        showFormError(response.responseJSON);
      }
    },
    beforeSerialize: function($form, options) {
    },
    beforeSubmit: function(arr, $form, options) {
    }
  };

  $("#form-create").ajaxForm(optionsCreate);
  $("#form-update").ajaxForm(optionsUpdate);


  function showFormError(responseText) {
    resetFormError();
    dataFieldError = responseText;
    $.each(responseText, function(k, v) {
      id_error = $('#'+k);
      id_error.addClass('is-invalid');
      html_feedback = `<div class="invalid-feedback mc-invalid-feedback">${v}</div>`;
      id_error.parent('.mc-form-input').append(html_feedback);
    });
  }

  function resetFormError() {
    console.log(dataFieldError);
    $.each(dataFieldError, function(k, v) {
      id_error = $('#'+k);
      id_error.removeClass('is-invalid');
      id_error.parent('.mc-form-input').find('.mc-invalid-feedback').html('');
    });

    dataFieldError = '';
  }

});