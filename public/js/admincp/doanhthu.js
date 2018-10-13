optionsDataTable = {
  "ajax": {
    url: apiData,
    "type": "POST",
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
  },
  "language": languageDatatable,
  "processing": true,
  "serverSide": true,
  "columns": [{
      "data": "id",
      "orderable": false,
      "searchable": false
    },
    {
      "data": "nhanvien.tennhanvien",
      "name": "nhanvien.tennhanvien"
    },
    {
      "data": "hopdong.sohopdong",
      "name": "hopdong.sohopdong"
    },
    {
      "data": "hopdong.tenhopdong",
      "name": "hopdong.tenhopdong"
    },
    {
      "data": "giatri",
      "name": "giatri"
    },
    {
      "data": "loaihoahong",
      "name": "loaihoahong"
    },
  ],
  'order': [1, 'asc'],
  'columnDefs': [{
    'targets': 0,
    'searchable': false,
    'orderable': false,
    'className': 'dt-body-center',
    'render': function(data, type, full, meta) {
      return `<label class="mc-container">&nbsp;
        <input type="checkbox" class="listCheckbox" name="id[]" value="${$('<div/>').text(data).html()}">
        <span class="mc-checkmark"></span>
      </label>`;

      return '<input type="checkbox" name="id[]" value="' +
        $('<div/>').text(data).html() + '">';
    }
  }],
};

table = $('#table-data-content').DataTable(optionsDataTable);

$('#ckb-select-all').on('click', function() {
  var rows = table.rows({
    'search': 'applied'
  }).nodes();
  $('input[type="checkbox"]', rows).prop('checked', this.checked);
});

$('#table-data-content tbody').on('change', 'input[type="checkbox"]', function() {
  if (!this.checked) {
    var el = $('#ckb-select-all').get(0);
    if (el && el.checked && ('indeterminate' in el)) {
      el.indeterminate = true;
    }
  }
});

$("#form-data-doanhthu").ajaxForm({
  complete: function(response) {
    if (response.status == 200) {

      $("#ajax-messases").css({
        "display": "block"
      });

      messages = response.responseJSON.messages;
      $("#ajax-messases").find('.messases-text').html(messages);

      window.setTimeout(function() {
        $("#ajax-messases").css({
          "display": "none"
        });
      }, 3000);

      $('html, body').animate({
        scrollTop: 0
      }, 500);

      table.ajax.reload();

    } else {}

  },
  beforeSubmit: function(arr, $form, options) {
    if (!confirm("Bạn có chắc chắn chọn thao tác này không !"))
      return false;
  },
});

$('#form-data-doanhthu').on('submit', function(e) {
  var form = this;
  table.$('input[type="checkbox"]').each(function() {
    if (!$.contains(document, this)) {
      if (this.checked) {
        $(form).append(
          $('<input>')
          .attr('type', 'hidden')
          .attr('name', this.name)
          .val(this.value)
        );
      }
    }
  });
  e.preventDefault();
});