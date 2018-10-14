var start_date = $("#start-date").val();
var end_date = $("#end-date").val();

optionsDataTable = {
  "ajax": {
    url: apiData,
    "type": "POST",
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    data: function (d) {
      d.start_date = start_date,
      d.end_date = end_date
    }
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
      "data": "created_at",
      "name": "created_at"
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

      $('#ajax-messases-loading').css({ "display": "none" });

      $('html, body').animate({
        scrollTop: 0
      }, 500);

      table.ajax.reload();

    } else {}

  },
  beforeSubmit: function(arr, $form, options) {
    if (!confirm("Bạn có chắc chắn chọn thao tác này không !"))
      return false;

    $('#ajax-messases-loading').css({ "display": "block" });
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

$("#btn-search").click(function() {
  start_date = $("#start-date").val();
  end_date = $("#end-date").val();
  if(start_date && end_date)
    $("#title-filter").html(start_date + ' đến ' + end_date);
  else
    $("#title-filter").html($("#title-filter-none").data('value'));
  table.ajax.reload();
})