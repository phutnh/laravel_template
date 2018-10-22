start_date = $("#start-date").val();
end_date = $("#end-date").val();
trangthai = $("#trangthai option:selected").val();

optionsDataTable = {
  "ajax": {
    url: apiData,
    "type": "POST",
    data: function (d) {
      d.start_date = start_date,
      d.end_date = end_date,
      d.trangthai = trangthai
    },
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
  },
  "language": languageDatatable,
  "processing": true,
  "serverSide": true,
  "columns": [{
      "className": 'details-control',
      "orderable": false,
      "searchable": false,
      "data": null,
      "defaultContent": ''
    },
    {
      "data": "sohopdong",
      "orderable": false,
      "searchable": false
    },
    {
      "data": "sohopdong", className: "nowrap"
    },
    {
      "data": "tenhopdong", className: "nowrap"
    },
    {
      "data": "tenkhachhang", className: "nowrap"
    },
    {
      "data": "giatri", className: "nowrap"
    },
    {
      "data": "trangthai", className: "nowrap"
    },
    {
      "data": "email", className: "nowrap"
    },
    {
      "data": "action",
      "orderable": false,
      "searchable": false
    }
  ],
  'columnDefs': [{
    'targets': 1,
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
  'order': [2, 'asc'],
};

table = $('#table-data-content').DataTable(optionsDataTable);
// table.columns( [7] ).visible( false );
// table.columns.adjust().draw( false );

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

$('#table-data-content tbody').on('click', 'td.details-control', function() {
  var tr = $(this).closest('tr');
  var row = table.row(tr);

  if (row.child.isShown()) {
    row.child.hide();
    tr.removeClass('shown');
  } else {
    row.child(formatDataDetail(row.data())).show();
    tr.addClass('shown');
  }
});

function formatDataDetail(d) {
  dinhkem = d.dinhkem.split('|');
  links = '';

  $.each(dinhkem, function(key, value) {
    filetype = value.split('.').pop();
    links += `<a class="document-item" href="uploads/hopdong/${value}" filetype="${filetype}">
      <span class="fileCorner"></span>Chi tiết</a>`;
  });

  if(dinhkem[0] == '')
    links = '';

  return '<b>Email khách hàng:</b> ' + d.email + '<br>' +
    '<b>Địa chỉ:</b> ' + d.diachi + '<br>' +
    '<b>Đính kèm:</b> <br>' + links;
}


$("#form-data-hopdong").ajaxForm({
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
    
    $('#ajax-messases-loading').css({ "display": "none" });

  },
  beforeSubmit: function(arr, $form, options) {
    if (!confirm("Bạn có chắc chắn chọn thao tác này không !"))
      return false;
    $('#ajax-messases-loading').css({ "display": "block" });
  },
});

$('#form-data-hopdong').on('submit', function(e) {
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
  trangthai = $("#trangthai option:selected").val();
  if(!start_date && !end_date)
  {
    $("#start-date").val($("#start-date").data('init'));
    $("#end-date").val($("#end-date").data('init'));
  }
  table.ajax.reload();
});