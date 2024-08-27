<script type="text/javascript">
  $(function() {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    $('#reasonFilter').on('keyup change', function(e) {
        e.preventDefault();
        table.draw();
    });

    var table = $('#taxExemptReasonTable').DataTable({
      responsive: true,
      processing: true,
      serverSide: true,
      searching: false,
      order: [
        [0, 'desc']
      ],
      ajax: {
        url: "{{ route('tax_exempt_reasons.list') }}",
        data: function(d) {
          d.reason_search = $('#reasonFilter').val();
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
          data: 'reason',
          name: 'reason'
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
          'data-bs-target': '#taxExemptReasonModel',
          'id': 'createTaxExemptReasonModel',
        },
        action: function(e, dt, node, config) {
          $('#savedata').html("Save Tax Exempt Reason");
          $('#tax_exempt_reason_id').val('');
          $('#taxExemptReasonForm').trigger("reset");
          $('.reason_error').html('');
          $('#modelHeading').html("Create New Tax Exempt Reason");
          $('#taxExemptReasonModel').modal('show');
        }
      }],
    });
    $('#taxExemptReasonForm input').on('input', function() {
      let fieldName = $(this).attr('name');
      $('.' + fieldName + '_error').text('');
    });
    $('#savedata').click(function(e) {
      e.preventDefault();
      $(this).html('Sending..');
      var url = $('#tax_exempt_reason_id').val() ? "{{ route('tax_exempt_reasons.update', ':id') }}".replace(':id', $('#tax_exempt_reason_id').val()) : "{{ route('tax_exempt_reasons.store') }}";
      var type = $('#tax_exempt_reason_id').val() ? "PUT" : "POST";
      $.ajax({
        url: url,
        type: type,
        data: $('#taxExemptReasonForm').serialize(),
        dataType: 'json',
        success: function(response) {
          if (response.status == "success") {
            $('#taxExemptReasonForm').trigger("reset");
            $('#taxExemptReasonModel').modal('hide');
            showToast('success', response.msg);
            table.draw();
          }
        },
        error: function(xhr) {
          handleAjaxError(xhr);
          var button = type === 'POST' ? 'Save Tax Exempt Reason' : 'Update Tax Exempt Reason';
          $('#savedata').html(button);
        }
      });
    });

    $('body').on('click', '.editbtn', function() {
      var id = $(this).data('id');
      $.get("{{ route('tax_exempt_reasons.index') }}" + '/' + id + '/edit', function(data) {
        $('.reason_error').html('');
        $('#modelHeading').html("Update Tax Exempt Reason");
        $('#savedata').html("Update Tax Exempt Reason");
        $('#taxExemptReasonModel').modal('show');
        $('#tax_exempt_reason_id').val(data.id);
        $('#reason').val(data.reason);
      });
    });

    $('body').on('click', '.deletebtn', function() {
      var id = $(this).data('id');
      confirmDelete(id, function() {
        deleteTaxExemptReason(id);
      });
    });

    function deleteTaxExemptReason(id) {
      var url = "{{ route('tax_exempt_reasons.destroy', ':id') }}".replace(':id', id);

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
      $.get("{{ route('tax_exempt_reasons.index') }}" + '/' + id, function(data) {
        $('#showTaxExemptReasonModal').modal('show');
        $('#showTaxExemptReasonForm #reason').val(data.reason);
      });
    });
     
  });
</script>
