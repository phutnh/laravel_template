$(document).ready(function() {

  var optionsAdd = {
    complete: function(response) {
      if (response.status == 200) {
        for (instance in CKEDITOR.instances) {
          CKEDITOR.instances[instance].setData('');
        }

        $("#resultMess").parents(".alert-ajax").css({
          "display": "block"
        });
        $("#resultMess").html("Thêm mới thành công");
        window.setTimeout(function() {
          $("#resultMess").parents(".alert-ajax").css({
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

      $("#loadingAjaxForm").css({
        "display": "none"
      });
    },
    beforeSerialize: function($form, options) {
      for (instance in CKEDITOR.instances) {
        CKEDITOR.instances[instance].updateElement();
      }
    },
    beforeSubmit: function(arr, $form, options) {
      $("#loadingAjaxForm").css({
        "display": "block"
      });
    },
    resetForm: true
  };


  var optionsEdit = {
    complete: function(response) {
      if (response.status == 200) {
        $('body').animate({
          scrollTop: 0
        }, 500);

        $("#resultMess").parents(".alert-ajax").css({
          "display": "block"
        });
        $("#resultMess").html("Chỉnh sửa thành công");
        window.setTimeout(function() {
          $("#resultMess").parents(".alert-ajax").css({
            "display": "none"
          });
        }, 3000);
      } else {
        console.clear();
        showFormError(response.responseJSON);
      }

      $("#loadingAjaxForm").css({
        "display": "none"
      });
    },
    beforeSerialize: function($form, options) {
      for (instance in CKEDITOR.instances) {
        CKEDITOR.instances[instance].updateElement();
      }
    },
    beforeSubmit: function(arr, $form, options) {
      $("#loadingAjaxForm").css({
        "display": "block"
      });
    }
  };

  $("#formAddData").ajaxForm(optionsAdd);
  $("#formEditData").ajaxForm(optionsEdit);


  function showFormError(responseText) {
    var errorData = '';

    $.each(responseText, function(data, v) {
      errorData += '- ' + v + '<br>';
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
    $.each(responseJSON, function(data, v) {
      msgData += '- ' + v + '<br>';
    });

    return msgData;
  }

});