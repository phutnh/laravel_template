$(document).ready(function() {

  var optionsCreate = {
    complete: function(response) {
      if (response.status == 200) {
        // for (instance in CKEDITOR.instances) {
        //   CKEDITOR.instances[instance].setData('');
        // }

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

      } else {
        console.clear();
        showFormError(response.responseJSON);
      }

    },
    beforeSerialize: function($form, options) {
      // for (instance in CKEDITOR.instances) {
      //   CKEDITOR.instances[instance].updateElement();
      // }
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

      } else {
        console.clear();
        showFormError(response.responseJSON);
      }
    },
    beforeSerialize: function($form, options) {
      // for (instance in CKEDITOR.instances) {
      //   CKEDITOR.instances[instance].updateElement();
      // }
    },
    beforeSubmit: function(arr, $form, options) {
    }
  };

  $("#form-create").ajaxForm(optionsCreate);
  $("#form-update").ajaxForm(optionsUpdate);


  function showFormError(responseText) {
    var errorData = '';

    $.each(responseText, function(k, v) {
      errorData += '- ' + v + '<br>';
      $('#'+k).addClass('is-invalid');
      console.log(k);
    });

    $.confirm({
      title: 'Lỗi nhập dữ liệu',
      content: errorData,
      type: "red",
      typeAnimated: true,
      useBootstrap: true,
      icon: 'icon-warning-sign',
      buttons: {
        'Đồng ý': function() {},
      }
    });
  }

  function getDataMessages(responseJSON) {
    var msgData = '';
    $.each(responseJSON, function(k, v) {
      msgData += '- ' + v + '<br>';
    });

    return msgData;
  }

});