<script type="text/javascript">
  $(function() {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    $('#kindFilter').on('keyup change', function(e) {
      e.preventDefault();
      table.draw();
    });

    var table = $('#productKindTable').DataTable({
      responsive: true,
      processing: true,
      serverSide: true,
      searching: false,
      order: [
        [0, 'desc']
      ],
      ajax: {
        url: "{{ route('product_kinds.list') }}",
        data: function(d) {
          d.kind_search = $('#kindFilter').val();
          sort = (d.order[0].dir == 'asc') ? "asc" : "desc";
          d.order = [{
            column: 1,
            dir: sort
          }];
        }
      },
      columns: [{
          data: 'id',
          name: 'id',
        }, {
          data: 'product_kind_name',
          name: 'product_kind_name'
        },
        {
          data: 'action',
          name: 'action',
          orderable: false,
          searchable: false
        }
      ],
      rowCallback: function(row, data, index) {
        $('td:eq(0)', row).html(table.page.info().start + index + 1);
      },
      dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex align-items-center justify-content-end"fB>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
      buttons: [{
        text: '<i class="bx bx-plus me-sm-1"></i> <span class="d-none d-sm-inline-block" >Add Product Kind</span>',
        className: 'create-new btn btn-primary',
        attr: {
          'data-bs-toggle': 'modal',
          'data-bs-target': '#productKindModel',
          'id': 'createproductKindModel',
        },
        action: function(e, dt, node, config) {
          $('#savedata').html("Save Product Kind");
          $('#product_kind_id').val('');
          $('#productKindForm').trigger("reset");
          $('.product_kind_name_error').html('');
          $('#modelHeading').html("Create New Product Kind");
          $('#productKindModel').modal('show');
        }
      }],
    });
    $('#productKindForm input').on('input', function() {
      let fieldName = $(this).attr('name');
      $('.' + fieldName + '_error').text('');
    });
    $('#savedata').click(function(e) {
      e.preventDefault();
      var button = $(this);
      sending(button);
      var url = $('#product_kind_id').val() ? "{{ route('product_kinds.update', ':id') }}".replace(':id', $('#product_kind_id').val()) : "{{ route('product_kinds.store') }}";
      var type = $('#product_kind_id').val() ? "PUT" : "POST";
      $.ajax({
        url: url,
        type: type,
        data: $('#productKindForm').serialize(),
        dataType: 'json',
        success: function(response) {
          if (response.status == "success") {
            $('#productKindForm').trigger("reset");
            $('#productKindModel').modal('hide');
            showToast('success', response.msg);
            table.draw();
          }
        },
        error: function(xhr) {
          handleAjaxError(xhr);
          sending(button, true);
        }
      });
    });

    $('body').on('click', '.editbtn', function() {
      var id = $(this).data('id');
      $.get("{{ route('product_kinds.index') }}" + '/' + id + '/edit', function(data) {
        $('.product_kind_name_error').html('');
        $('#modelHeading').html("Update Product Kind");
        $('#savedata').html("Update Product Kind");
        $('#productKindModel').modal('show');
        $('#product_kind_id').val(data.id);
        $('#product_kind_name').val(data.product_kind_name);
      });
    });

    $('body').on('click', '.deletebtn', function() {
      var id = $(this).data('id');
      confirmDelete(id, function() {
        deleteproductKind(id);
      });
    });

    function deleteproductKind(id) {
      var url = "{{ route('product_kinds.destroy', ':id') }}".replace(':id', id);
      $.ajax({
        url: url,
        type: "DELETE",
        data: {
          id: id,
          _token: '{{ csrf_token() }}'
        },
        success: function(response) {
          if (response.status === "success") {
            handleAjaxResponse(response, table);
          } else {
            showError('Deleted!', response.msg);
          }
        },
        error: function(xhr) {
          console.error('Error:', xhr.statusText);
          showError('Oops!', 'Failed to fetch data.');
        }
      });
    }

    $('body').on('click', '.showbtn', function() {
      var id = $(this).data('id');
      $.get("{{ route('product_kinds.index') }}" + '/' + id, function(data) {
        $('#showproductKindModal').modal('show');
        $('#showproductKindForm #product_kind_name').val(data.product_kind_name);
      });
    });
  });
</script>