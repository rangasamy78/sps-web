<script type="text/javascript">
  $(function() {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    $('#costLevelFilter, #costCodeFilter, #costLabelFilter').on('keyup change', function(e) {
      e.preventDefault();
      table.draw();
    });

    var table = $('#supplierCostListLabelTable').DataTable({
      responsive: true,
      processing: true,
      serverSide: true,
      searching: false,
      order: [
        [0, 'desc']
      ],
      ajax: {
        url: "{{ route('supplier_cost_list_labels.list') }}",
        data: function(d) {
          d.cost_level_search = $('#costLevelFilter').val();
          d.cost_code_search = $('#costCodeFilter').val();
          d.cost_label_search = $('#costLabelFilter').val();
          sort = (d.order[0].dir == 'asc') ? "asc" : "desc";
          d.order = [{
            column: 1,
            dir: sort
          }];
        }
      },
      columns: [{
          data: null,
          name: 'serial',
          orderable: false,
          searchable: false,
        }, {
          data: 'cost_level',
          name: 'cost_level'
        },
        {
          data: 'cost_code',
          name: 'cost_code'
        },
        {
          data: 'cost_label',
          name: 'cost_label'
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
        text: '<i class="bx bx-plus me-sm-1"></i> <span class="d-none d-sm-inline-block">Add Supplier Cost List Label</span>',
        className: 'create-new btn btn-primary',
        attr: {
          'data-bs-toggle': 'modal',
          'data-bs-target': '#supplierCostListLabelModel',
          'id': 'createSupplierCostListLabelModel',
        },
        action: function(e, dt, node, config) {
          $('#savedata').html("Save Supplier Cost List Label");
          $('#supplier_cost_list_label_id').val('');
          $('#supplierCostListLabelForm').trigger("reset");
          resetFormFields();
          $('#modelHeading').html("Create New Supplier Cost List Label");
          $('#supplierCostListLabelModel').modal('show');
        }
      }],
    });

    $('#supplierCostListLabelForm input').on('input', function() {
      let fieldName = $(this).attr('name');
      $('.' + fieldName + '_error').text('');
    });

    $('#savedata').click(function(e) {
      e.preventDefault();
      var button = $(this);
      sending(button);
      var url = $('#supplier_cost_list_label_id').val() ? "{{ route('supplier_cost_list_labels.update', ':id') }}".replace(':id', $('#supplier_cost_list_label_id').val()) : "{{ route('supplier_cost_list_labels.store') }}";
      var type = $('#supplier_cost_list_label_id').val() ? "PUT" : "POST";
      $.ajax({
        url: url,
        type: type,
        data: $('#supplierCostListLabelForm').serialize(),
        dataType: 'json',
        success: function(response) {
          if (response.status == "success") {
            $('#supplierCostListLabelForm').trigger("reset");
            $('#supplierCostListLabelModel').modal('hide');
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
      $.get("{{ route('supplier_cost_list_labels.index') }}" + '/' + id + '/edit', function(data) {
        resetFormFields();
        $('#modelHeading').html("Edit Supplier Cost List Label");
        $('#savedata').html("Update Supplier Cost List Label");
        $('#supplierCostListLabelModel').modal('show');
        $('#supplier_cost_list_label_id').val(data.id);
        $('#cost_level').val(data.cost_level);
        $('#cost_code').val(data.cost_code);
        $('#cost_label').val(data.cost_label);
      });
    });


    $('body').on('click', '.deletebtn', function() {
      var id = $(this).data('id');
      confirmDelete(id, function() {
        deleteSupplierCostListLabel(id);
      });
    });

    function deleteSupplierCostListLabel(id) {
      var url = "{{ route('supplier_cost_list_labels.destroy', ':id') }}".replace(':id', id);

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
      resetFormFields();
      var id = $(this).data('id');
      $.get("{{ route('supplier_cost_list_labels.index') }}" + '/' + id, function(data) {
        $('#showSupplierCostListLabelModal').modal('show');
        $('#showSupplierCostListLabelForm #cost_level').val(data.cost_level);
        $('#showSupplierCostListLabelForm #cost_code').val(data.cost_code);
        $('#showSupplierCostListLabelForm #cost_label').val(data.cost_label);
      });
    });

    function resetFormFields() {
      $('.cost_level_error').html('');
      $('.cost_code_error').html('');
      $('.cost_label_error').html('');
    }

  });
</script>
