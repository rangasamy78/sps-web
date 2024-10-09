<script type="text/javascript">
  $(function() {

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $(' #supplierNameFilter,#currencyFilter,#supplierTypeFilter,#addressFilter,#phoneFilter,#locationFilter,#paymentTermFilter,#languageFilter', ).on('keyup change', function(e) {
      e.preventDefault();
      table.draw();
    });
    var table = $('#datatablesSupplier').DataTable({
      responsive: true,
      processing: true,
      serverSide: true,
      searching: false,
      ajax: {
        url: "{{ route('suppliers.list') }}",
        data: function(d) {
          d.supplier_name_search = $('#supplierNameFilter').val();
          d.currency_search = $('#currencyFilter').val();
          d.supplier_type_search = $('#supplierTypeFilter').val();
          d.address_search = $('#addressFilter').val();
          d.phone_search = $('#phoneFilter').val();
          d.location_search = $('#locationFilter').val();
          d.payment_term_search = $('#paymentTermFilter').val();
          d.language_search = $('#languageFilter').val();
        }
      },
      columns: [{
          data: 'id',
          name: 'id'
        },
        {
          data: 'supplier_name',
          name: 'supplier_name'
        },
        {
          data: 'currency_id',
          name: 'currency_id'
        },
        {
          data: 'supplier_type_id',
          name: 'supplier_type_id'
        },
        {
          data: 'remit_address',
          name: 'remit_address'
        },
        {
          data: 'mobile',
          name: 'mobile'
        },
        {
          data: 'parent_location_id',
          name: 'parent_location_id'
        },
        {
          data: 'payment_terms_id',
          name: 'payment_terms_id'
        },
        {
          data: 'language_id',
          name: 'language_id'
        },
        {
          data: 'combined_notes',
          name: 'combined_notes'
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
      dom: '<"row mx-2"' +
        '<"col-md-2"<"me-3"l>>' +
        '<"col-md-10"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0"fB>>' +
        '>t' +
        '<"row mx-2"' +
        '<"col-sm-12 col-md-6"i>' +
        '<"col-sm-12 col-md-6"p>' +
        '>',
      language: {
        sLengthMenu: '_MENU_',
        search: '',
        searchPlaceholder: 'Search..'
      },
      buttons: [{
          text: '<i class="bx bx-plus me-sm-1"></i> <span class="d-none d-sm-inline-block">Add Supplier</span>',
          className: 'create-new btn btn-primary',
          action: function(e, dt, node, config) {
            window.location.href = "{{ route('suppliers.create') }}";
          }
        },
        {
          extend: 'collection',
          className: 'btn btn-label-secondary dropdown-toggle mx-3',
          text: '<i class="bx bx-export me-1"></i>Export',
          buttons: [{
              extend: 'print',
              text: '<i class="bx bx-printer me-2"></i>Print',
              className: 'dropdown-item'
            },
            {
              extend: 'csv',
              text: '<i class="bx bx-file me-2"></i>Csv',
              className: 'dropdown-item'
            },
            {
              extend: 'excel',
              text: '<i class="bx bxs-file-export me-2"></i>Excel',
              className: 'dropdown-item'
            },
            {
              extend: 'pdf',
              text: '<i class="bx bxs-file-pdf me-2"></i>Pdf',
              className: 'dropdown-item'
            },
            {
              extend: 'copy',
              text: '<i class="bx bx-copy me-2"></i>Copy',
              className: 'dropdown-item'
            }
          ]
        }
      ]
    });


    $('#supplierForm input, #supplierForm select').on('input change', function() {
      let fieldName = $(this).attr('name');
      $('.' + fieldName + '_error').text('');
    });


    $('#supplierEditForm input,#supplierForm input').on('input change', function() {
      let fieldName = $(this).attr('name');
      $('.' + fieldName + '_error').text('');
    });

    $('#savedata').click(function(e) {
      e.preventDefault();
      var button = $(this);
      sending(button);
      var url = $('#supplier_id').val() ? "{{ route('suppliers.update', ':id') }}".replace(':id', $('#supplier_id').val()) : "{{ route('suppliers.store') }}";
      var type = $('#supplier_id').val() ? "PUT" : "POST";
      var data = $('#supplier_id').val() ? $('#supplierEditForm').serialize() : $('#supplierForm').serialize();
      var id = $('#supplier_id').val();
      var redirect = id ?
        "{{ route('suppliers.show', ':id') }}".replace(':id', id) :
        "{{ route('suppliers.index') }}";
      $.ajax({
        url: url,
        type: type,
        data: data,
        dataType: 'json',
        success: function(response) {
          if (response.status == "success") {
            $('#supplierForm').trigger("reset");
            showToast('success', response.msg);
            table.draw();
            window.location.href = redirect;
          }
        },
        error: function(xhr) {
          handleAjaxError(xhr);
          sending(button, true);
        }
      });
    });
    $('#cancelButton').click(function() {
      window.location.href = "{{ route('suppliers.index') }}";
    });

    function copyValues(sourcePrefix, destPrefix) {
      ['address', 'suite', 'city', 'state', 'zip', 'country_id'].forEach(function(field) {
        var source = $('#' + sourcePrefix + '_' + field).val();
        var dest = $('#' + destPrefix + '_' + field);
        console.log(dest.val(source));
        if (dest.val() === '' && source !== '') {
          dest.val(source);

          if (field === 'country_id') {
            dest.trigger('change.select2');
          }
        }
      });
    }

    // Copy remit address to shipping address on change
    $('#remit_address, #remit_suite, #remit_city, #remit_state, #remit_zip, #remit_country_id').on('change', function() {
      copyValues('remit', 'ship');
    });

    // Copy shipping address to remit address on change
    $('#ship_address, #ship_suite, #ship_city, #ship_state, #ship_zip, #ship_country_id').on('change', function() {
      copyValues('ship', 'remit');
    });

    $('body').on('click', '.showbtn', function() {
      var id = $(this).data('id');
      var showUrl = "{{ route('suppliers.show', ':id') }}";
      showUrl = showUrl.replace(':id', id);
      window.location.href = showUrl;
    });

    $('body').on('click', '.deletebtn', function() {
      var id = $(this).data('id');
      confirmDelete(id, function() {
        deleteSupplier(id);
      });
    });

    function deleteSupplier(id) {
      var url = "{{ route('suppliers.destroy', ':id') }}".replace(':id', id);

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
            window.location.href = "{{ route('suppliers.index') }}";
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
      var url = '{{ route("suppliers.status", ":id") }}';
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
            window.location.href = "{{ route('suppliers.show', ':id') }}".replace(':id', supplierId);
          }
        },
        error: function(xhr) {
          handleAjaxError(xhr); // Handle error response
          sending(button, true); // Reset the button state if applicable
        }
      });
    });



    $('#supplierSearch').select2({
      placeholder: 'Select which filter you want to search for',
      dropdownParent: $('#supplierSearch').parent()
    });
    $('#currencyFilter').select2({
      placeholder: '--select curency--',
      dropdownParent: $('#currencyFilter').parent()
    });
    $('#supplierTypeFilter').select2({
      placeholder: '--select supplier type--',
      dropdownParent: $('#supplierTypeFilter').parent()
    });
    $('#locationFilter').select2({
      placeholder: '--select location--',
      dropdownParent: $('#locationFilter').parent()
    });
    $('#paymentTermFilter').select2({
      placeholder: '--select payment term--',
      dropdownParent: $('#paymentTermFilter').parent()
    });
    $('#languageFilter').select2({
      placeholder: '--select language--',
      dropdownParent: $('#languageFilter').parent()
    });

    //search(filter)
    $(document).ready(function() {
      $('#supplierSearch').on('change', function() {
        const selectedValues = $(this).val();
        $('.filter-input').hide();
        selectedValues.forEach(function(value) {
          switch (value) {
            case '1':
              $('#supplierNameDiv').show();
              break;
            case '2':
              $('#currencyDiv').show();
              break;
            case '3':
              $('#supplierTypeDiv').show();
              break;
            case '4':
              $('#addressDiv').show();
              break;
            case '5':
              $('#phoneDiv').show();
              break;
            case '6':
              $('#locationDiv').show();
              break;
            case '7':
              $('#paymentTermDiv').show();
              break;
            case '8':
              $('#languageDiv').show();
              break;
            default:
              break;
          }
        });
      });
    });



  });
</script>