<script type="text/javascript">
  $(function() {

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $(' #accountNumberFilter,#accountNameFilter,#alternateNumberFilter,#alternateNameFilter,#accountTypeFilter,#subAccountTypeFilter,#specialAccountTypeFilter,#subAccountOfFilter, #statusFilter', ).on('keyup change', function(e) {
      e.preventDefault();
      table.draw();
    });

    var table = $('#datatablesAccount').DataTable({
      // scrollX: true, // Enable horizontal scrolling
      // paging: true,
      responsive: true,
      processing: true,
      serverSide: true,
      searching: false,
      order: [
        [1, 'desc']
      ],
      ajax: {
        url: "{{ route('accounts.list') }}",
        data: function(d) {
          d.account_number_search = $('#accountNumberFilter').val();
          d.account_name_search = $('#accountNameFilter').val();
          d.alternate_number_search = $('#alternateNumberFilter').val();
          d.alternate_name_search = $('#alternateNameFilter').val();
          d.account_type_search = $('#accountTypeFilter').val();
          d.sub_account_type_search = $('#subAccountTypeFilter').val();
          d.special_account_type_search = $('#specialAccountTypeFilter').val();
          d.sub_account_of_search = $('#subAccountOfFilter').val();
          d.status_search = $('#statusFilter').val();
          sort = (d.order[0].dir == 'asc') ? "asc" : "desc";
          d.order = [{
            column: 1,
            dir: sort
          }];
        }
      },
      columns: [{
          data: 'id',
          name: 'id'
        },
        {
          data: 'account_number',
          name: 'account_number'
        },
        {
          data: 'account_name',
          name: 'account_name'
        },
        {
          data: 'alternate_number',
          name: 'alternate_number'
        },
        {
          data: 'alternate_name',
          name: 'alternate_name'
        },
        {
          data: 'account_type_id',
          name: 'account_type_id'
        },
        {
          data: 'account_sub_type_id',
          name: 'account_sub_type_id'
        },
        {
          data: 'special_account_type_id',
          name: 'special_account_type_id'
        },
        {
          data: 'is_sub_account_of_id',
          name: 'is_sub_account_of_id'
        },
        {
          data: 'balance',
          name: 'balance'
        },
        {
          data: 'status',
          name: 'status'
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
        if (data.status === 'Inactive') {
          $(row).addClass('table-danger');
        }
      },
      dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex align-items-center justify-content-end"B>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
      buttons: [{
        text: '<i class="bx bx-plus me-sm-1"></i> <span class="d-none d-sm-inline-block">Add Account</span>',
        className: 'create-new btn btn-primary',
        action: function(e, dt, node, config) {
          window.location.href = "{{ route('accounts.create') }}";
        }
      }]
    });

    $('#accountForm input, #accountForm select').on('input change', function() {
      let fieldName = $(this).attr('name');
      $('.' + fieldName + '_error').text('');
    });


    $('#accountEditForm input,#accountEditForm input').on('input change', function() {
      let fieldName = $(this).attr('name');
      $('.' + fieldName + '_error').text('');
    });

    $('#accountSearch').select2({
      placeholder: 'Select which filter you want to search for',
      dropdownParent: $('#accountSearch').parent()
    });
    $('#accountTypeFilter').select2({
      placeholder: '--select account type--',
      dropdownParent: $('#accountTypeFilter').parent()
    });
    $('#subAccountTypeFilter').select2({
      placeholder: '--select sub account type--',
      dropdownParent: $('#subAccountTypeFilter').parent()
    });
    $('#specialAccountTypeFilter').select2({
      placeholder: '--select special account type--',
      dropdownParent: $('#specialAccountTypeFilter').parent()
    });
    $('#subAccountOfFilter').select2({
      placeholder: '--select sub account of--',
      dropdownParent: $('#subAccountOfFilter').parent()
    });
    $('#statusFilter').select2({
      placeholder: '--select status--',
      dropdownParent: $('#statusFilter').parent()
    });

    $('#savedata').click(function(e) {
      e.preventDefault();
      var button = $(this);
      sending(button);
      var url = $('#account_id').val() ? "{{ route('accounts.update', ':id') }}".replace(':id', $('#account_id').val()) : "{{ route('accounts.store') }}";
      var type = $('#account_id').val() ? "PUT" : "POST";
      var data = $('#account_id').val() ? $('#accountEditForm').serialize() : $('#accountForm').serialize();
      $.ajax({
        url: url,
        type: type,
        data: data,
        dataType: 'json',
        success: function(response) {
          if (response.status == "success") {
            $('#accountForm').trigger("reset");
            showToast('success', response.msg);
            table.draw();
            window.location.href = "{{ route(name: 'accounts.index') }}";
          }
        },
        error: function(xhr) {
          handleAjaxError(xhr);
          sending(button, true);
        }
      });
    });
    $('#cancelButton').click(function() {
      window.location.href = "{{ route('accounts.index') }}";
    });

    // is sub type of account
    $('#account_type_id').on('change', function() {
      const selectedValues = $(this).val();
      var url = '{{ route("accounts.is_subtype", ":id") }}';
      url = url.replace(':id', selectedValues);

      $.ajax({
        url: url,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
          console.log(response.type);
          if (response.type) {
            $('.bankCard').show();
            $('#bank_name').prop('required', true);
          } else {
            $('.bankCard').hide();
            $('#bank_name').prop('required', false);
          }
          if (response.isSubAccountOf) {
            let subAccounts = response.data;
            let $select = $('#is_sub_account_of_id');
            $select.empty();
            $select.append('<option value="">--select--</option>');
            $.each(subAccounts, function(key, account) {
              $select.append('<option value="' + account.id + '">' + account.account_name + '</option>');
            });
          } else {
            $('#is_sub_account_of_id').empty().append('<option value="">--no sub accounts--</option>');
          }
        },
        error: function(xhr) {
          handleAjaxError(xhr);
        }
      });
    });

    $('body').on('click', '.showbtn', function() {
      var id = $(this).data('id');
      var showUrl = "{{ route('accounts.show', ':id') }}";
      showUrl = showUrl.replace(':id', id);
      window.location.href = showUrl;
    });

    $('body').on('click', '.deletebtn', function() {
      var id = $(this).data('id');
      confirmDelete(id, function() {
        deleteAccount(id);
      });
    });

    function deleteAccount(id) {
      var url = "{{ route('accounts.destroy', ':id') }}".replace(':id', id);
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
            window.location.href = "{{ route('accounts.index') }}";
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

    $('.inactivebtn').click(function(e) {
      e.preventDefault();
      var button = $(this);
      var supplierId = button.data('id');
      var url = '{{ route("accounts.status", ":id") }}';
      url = url.replace(':id', supplierId);
      var data = {
        status: 0
      };
      $.ajax({
        url: url,
        type: 'get',
        data: data,
        dataType: 'json',
        success: function(response) {
          if (response.status == "success") {
            showToast('success', response.msg);
            window.location.href = "{{ route('accounts.show', ':id') }}".replace(':id', supplierId);
          }
        },
        error: function(xhr) {
          handleAjaxError(xhr); // Handle error response
          sending(button, true); // Reset the button state if applicable
        }
      });

    });

    //search(filter)
    $(document).ready(function() {
      $('#accountSearch').on('change', function() {
        const selectedValues = $(this).val();
        $('.filter-input').hide();
        selectedValues.forEach(function(value) {
          switch (value) {
            case '1':
              $('#accountNumberDiv').show();
              break;
            case '2':
              $('#accountNameDiv').show();
              break;
            case '3':
              $('#alternateNumberDiv').show();
              break;
            case '4':
              $('#alternateNameDiv').show();
              break;
            case '5':
              $('#accountTypeDiv').show();
              break;
            case '6':
              $('#subAccountTypeDiv').show();
              break;
            case '7':
              $('#specialAccountTypeDiv').show();
              break;
            case '8':
              $('#subAccountOfDiv').show();
              break;
            case '9':
              $('#statusDiv').show();
              break;
            default:
              break;
          }
        });
      });
    });
  });
</script>