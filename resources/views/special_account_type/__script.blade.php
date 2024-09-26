<script type="text/javascript">
  $(function() {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    $('#specialAccountTypeFilter').on('keyup change', function(e) {
      e.preventDefault();
      table.draw();
    });

    var table = $('#specialAccountTypeTable').DataTable({
      responsive: true,
      processing: true,
      serverSide: true,
      searching: false,
      order: [
        [0, 'desc']
      ],
      ajax: {
        url: "{{ route('special_account_types.list') }}",
        data: function(d) {
          d.special_account_type = $('#specialAccountTypeFilter').val();
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
          data: 'special_account_type_name',
          name: 'special_account_type_name'
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
        text: '<i class="bx bx-plus me-sm-1"></i> <span class="d-none d-sm-inline-block" >Add Special Account Type</span>',
        className: 'create-new btn btn-primary',
        attr: {
          'data-bs-toggle': 'modal',
          'data-bs-target': '#specialAccountTypeModel',
          'id': 'createspecialAccountTypeModel',
        },
        action: function(e, dt, node, config) {
          $('#savedata').html("Save Special Account Type");
          $('#special_account_type_id').val('');
          $('#specialAccountTypeForm').trigger("reset");
          $('.special_account_type_name_error').html('');
          $('#modelHeading').html("Create New Special Account Type");
          $('#specialAccountTypeModel').modal('show');
        }
      }],
    });
    $('#specialAccountTypeForm input').on('input', function() {
      let fieldName = $(this).attr('name');
      $('.' + fieldName + '_error').text('');
    });
    $('#savedata').click(function(e) {
      e.preventDefault();
      var button = $(this);
      sending(button);
      var url = $('#special_account_type_id').val() ? "{{ route('special_account_types.update', ':id') }}".replace(':id', $('#special_account_type_id').val()) : "{{ route('special_account_types.store') }}";
      var type = $('#special_account_type_id').val() ? "PUT" : "POST";
      $.ajax({
        url: url,
        type: type,
        data: $('#specialAccountTypeForm').serialize(),
        dataType: 'json',
        success: function(response) {
          if (response.status == "success") {
            $('#specialAccountTypeForm').trigger("reset");
            $('#specialAccountTypeModel').modal('hide');
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
      $.get("{{ route('special_account_types.index') }}" + '/' + id + '/edit', function(data) {
        $('.special_account_type_name_error').html('');
        $('#modelHeading').html("Update Special Account Type");
        $('#savedata').html("Update Special Account Type");
        $('#specialAccountTypeModel').modal('show');
        $('#special_account_type_id').val(data.id);
        $('#special_account_type_name').val(data.special_account_type_name);
      });
    });

    $('body').on('click', '.deletebtn', function() {
      var id = $(this).data('id');
      confirmDelete(id, function() {
        deleteproductKind(id);
      });
    });

    function deleteproductKind(id) {
      var url = "{{ route('special_account_types.destroy', ':id') }}".replace(':id', id);
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
      $.get("{{ route('special_account_types.index') }}" + '/' + id, function(data) {
        $('#showSpecialAccountTypeModel').modal('show');
        $('#showspecialAccountTypeForm #special_account_type_name').val(data.special_account_type_name);
      });
    });
  });
</script>