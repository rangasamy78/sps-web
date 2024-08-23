<script type="text/javascript">
  $(function() {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    var table = $('#accountSubTypeTable').DataTable({
      responsive: true,
      processing: true,
      serverSide: true,
      order: [
        [0, 'desc']
      ],
      ajax: {
        url: "{{ route('account_sub_types.list') }}",
        data: function(d) {
          sort = (d.order[0].dir == 'asc') ? "asc" : "desc";
          d.order = [{
            column: 0,
            dir: sort
          }];
        }
      },
      columns: [{
          data: 'id',
          name: 'id',

        }, {
          data: 'sub_type_name',
          name: 'sub_type_name'
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
      dom: '<"card-header flex-column flex-md-row"<"head-label text-center"><"dt-action-buttons text-end pt-3 pt-md-0"B>><"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
      buttons: [{
        text: '<i class="bx bx-plus me-sm-1"></i> <span class="d-none d-sm-inline-block" >Create Tax Exempt Reason</span>',
        className: 'create-new btn btn-primary',
        attr: {
          'data-bs-toggle': 'modal',
          'data-bs-target': '#accountSubTypeModel',
        },
        action: function(e, dt, node, config) {
          $('#savedata').html("Save Account Sub Type");
          $('#account_sub_type_id').val('');
          $('#accountSubTypeForm').trigger("reset");
          $('.sub_type_name_error').html('');
          $('#modelHeading').html("Create New Account Sub Type");
          $('#accountSubTypeModel').modal('show');
        }
      }],
    });

    $('#accountSubTypeForm input').on('input', function() {
      let fieldName = $(this).attr('name');
      $('.' + fieldName + '_error').text('');
    });

    $('#savedata').click(function(e) {
      e.preventDefault();
      $(this).html('Sending..');
      var url = $('#account_sub_type_id').val() ? "{{ route('account_sub_types.update', ':id') }}".replace(':id', $('#account_sub_type_id').val()) : "{{ route('account_sub_types.store') }}";
      var type = $('#account_sub_type_id').val() ? "PUT" : "POST";
      $.ajax({
        url: url,
        type: type,
        data: $('#accountSubTypeForm').serialize(),
        dataType: 'json',
        success: function(response) {
          if (response.status == "success") {
            $('#accountSubTypeForm').trigger("reset");
            $('#accountSubTypeModel').modal('hide');
            table.draw();
            var successMessage = type === 'POST' ? 'Account Sub Type Added Successfully!' : 'Account Sub Type Updated Successfully!';
            var successTitle = type === 'POST' ? 'Created!' : 'Updated!';
            showSuccessMessage(successTitle, successMessage);
          }
        },
        error: function(xhr) {
          handleAjaxError(xhr);
          var button = type === 'POST' ? 'Save Account Sub Type' : 'Update Account Sub Type';
          $('#savedata').html(button);
        }
      });
    });

    $('body').on('click', '.editbtn', function() {
      var id = $(this).data('id');
      $.get("{{ route('account_sub_types.index') }}" + '/' + id + '/edit', function(data) {
        $('.sub_type_name_error').html('');
        $('#modelHeading').html("Update Account Sub Type");
        $('#savedata').html("Update Account Sub Type");
        $('#accountSubTypeModel').modal('show');
        $('#account_sub_type_id').val(data.id);
        $('#sub_type_name').val(data.sub_type_name);
      });
    });
    $('body').on('click', '.deletebtn', function() {
      var id = $(this).data('id');
      confirmDelete(id, function() {
        deleteAccountSubType(id);
      });
    });

    function deleteAccountSubType(id) {
      var url = "{{ route('account_sub_types.destroy', ':id') }}".replace(':id', id);

      $.ajax({
        url: url,
        type: "DELETE",
        data: {
          id: id,
          _token: '{{ csrf_token() }}'
        },
        success: function(response) {
          if (response.status === "success") {
            table.draw();
            showSuccessMessage('Deleted!', 'Account Sub Type Deleted Successfully!');
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
      $.get("{{ route('account_sub_types.index') }}" + '/' + id, function(data) {
        $('#showAccountSubTypeModal').modal('show');
        $('#showAccountSubTypeForm #sub_type_name').val(data.sub_type_name);
      });
    });
    setTimeout(() => {
      $('.dataTables_filter .form-control').removeClass('form-control-sm').css('margin-right', '20px');
      $('.dataTables_length .form-select').removeClass('form-select-sm').css('padding-left', '30px');
    }, 300);
  });
</script>
