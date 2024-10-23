<script type="text/javascript">
  $(function() {

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    //list of customer pop up
    $('.existing_customer').click(function(e) {
      $('#CreateConsignmentModel').modal('show');
      e.preventDefault();
    });

    $(' #popup_customer_name,#popup_code,#popup_contact_input').on('keyup change', function(e) {
      e.preventDefault();
      table_list_customer.draw();
    });
    var table_list_customer = $('#datatablesListCustomer').DataTable({
      responsive: true,
      processing: true,
      serverSide: true,
      searching: false,
      ajax: {
        url: "{{ route('consignments.customer_list') }}",
        data: function(d) {
          d.customer_name = $('#popup_customer_name').val();
          d.code = $('#popup_code').val();
          d.contact_input = $('#popup_contact_input').val();
        }
      },
      columns: [{
          data: 'customer_name'
        },
        {
          data: 'address'
        },
        {
          data: 'phone'
        },
      ],
    });
    $('#datatablesListCustomer tbody').on('click', 'tr', function() {
      var rowData = table_list_customer.row(this).data();
      if (rowData) {
        var url = "{{ route('customers.show', ':id') }}".replace(':id', rowData.id);
        window.location.href = url;
      }
    });

    // list of create consignment
    $(document).ready(function() {
      $(' #customer_name,#contact_name,#address,#phone').on('keyup change', function(e) {
        e.preventDefault();
        table_list_create_consignmemt.draw();
      });
      // Initialize the DataTable with the default status (1 for Active)
      var initialStatus = '1'; // This corresponds to the "Active" radio button value
      var table_list_create_consignmemt = $('#datatablesCreateConsignment').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        searching: false,
        ajax: {
          url: "{{ route('consignments.create_customer_list', ':status') }}".replace(':status', initialStatus),
          data: function(d) {
            d.customer_name = $('#customer_name').val();
            d.contact_name = $('#contact_name').val();
            d.address = $('#address').val();
            d.phone = $('#phone').val();
          }
        },
        columns: [{
            data: 'customer_name'
          },
          {
            data: 'contact_name'
          },
          {
            data: 'address'
          },
          {
            data: 'phone'
          },
          {
            data: 'qty'
          },
          {
            data: 'action'
          }
        ],
      });

      // Update DataTable on radio button change
      $('.radio').change(function(e) {
        var status = $(this).val();

        // Update the DataTable's AJAX URL and reload it
        var newUrl = "{{ route('consignments.create_customer_list', ':status') }}".replace(':status', status);
        table_list_create_consignmemt.ajax.url(newUrl).load(); // Reload the DataTable with new data
      });
    });

    //list of consignment
    // filter search 
    $(document).ready(function() {
      $('#consignmentSearch').on('change', function() {
        const selectedValues = $(this).val(); // Get selected values from the dropdown
        $('.filter-input').hide(); // Hide all filter input divs initially
        if (!selectedValues) return; // If no values are selected, exit early
        selectedValues.forEach(function(value) {
          switch (value) {
            case '1':
              $('#consignmentLocationDiv').show();
              break;
            case '2':
              $('#codeDiv').show();
              break;
            case '3':
              $('#contactNameDiv').show();
              break;
            case '4':
              $('#parentLocationDiv').show();
              break;
            case '5':
              $('#setUpDateDiv').show();
              break;
            case '6':
              $('#typeDiv').show();
              break;
            case '7':
              $('#billingAddressDiv').show();
              break;
            case '8':
              $('#shippingAddressDiv').show();
              break;
            case '9':
              $('#phone1Div').show();
              break;
            case '10':
              $('#phone2Div').show();
              break;
            case '11':
              $('#mobileDiv').show();
              break;
            case '12':
              $('#saleDiv').show();
              break;
            case '13':
              $('#priceLevelDiv').show();
              break;
            case '14':
              $('#paymentTermsDiv').show();
              break;
            case '15':
              $('#taxDiv').show();
              break;
            default:
              break;
          }
        });
      });
    });

    $(' #consignmentLocationFilter,#codeFilter,#contactNameFilter,#parentLocationFilter,#dateFilter,#typeFilter,#billingAddressFilter,#shippingAddressFilter,#phone1Filter,#phone2Filter,#mobileFilter,#saleFilter,#priceLevelFilter,#paymentTermFilter,#taxFilter').on('keyup change', function(e) {
      e.preventDefault();
      table_consignment.draw();
    });
    var initialStatusDash = '1';
    var table_consignment = $('#datatablesConsignment').DataTable({
      responsive: true,
      processing: true,
      serverSide: true,
      searching: false,
      ajax: {
        url: "{{ route('consignments.list', ':status') }}".replace(':status', initialStatusDash),
        data: function(d) {
          d.consignmentLocationFilter = $('#consignmentLocationFilter').val();
          d.codeFilter = $('#codeFilter').val();
          d.contactNameFilter = $('#contactNameFilter').val();
          d.parentLocationFilter = $('#parentLocationFilter').val();
          d.dateFilter = $('#dateFilter').val();
          d.typeFilter = $('#typeFilter').val();
          d.billingAddressFilter = $('#billingAddressFilter').val();
          d.shippingAddressFilter = $('#shippingAddressFilter').val();
          d.phone1Filter = $('#phone1Filter').val();
          d.phone2Filter = $('#phone2Filter').val();
          d.mobileFilter = $('#mobileFilter').val();
          d.saleFilter = $('#saleFilter').val();
          d.priceLevelFilter = $('#priceLevelFilter').val();
          d.paymentTermFilter = $('#paymentTermFilter').val();
          d.taxFilter = $('#taxFilter').val();
        }
      },
      columns: [{
          data: ''
        },
        {
          data: 'customer_name'
        },
        {
          data: 'parent_location_id'
        },
        {
          data: 'consignment_date'
        },
        {
          data: 'consignment_type'
        },
        {
          data: 'address'
        },
        {
          data: 'shipping_address'
        },
        {
          data: 'phone'
        },
        {
          data: 'sales_person_id'
        },
        {
          data: 'payment_terms_id'
        },
        {
          data: 'internal_notes'
        },
        {
          data: 'details'
        }
      ],
      columnDefs: [{
        className: 'control',
        orderable: false,
        targets: 0,
        searchable: false,
        render: function() {
          return '';
        }
      }],
      destroy: true, // Allow reinitialization
      dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>' +
        't<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
      responsive: {
        details: {
          display: $.fn.dataTable.Responsive.display.modal({
            header: function(row) {
              const data = row.data();
              return `Details of ${data['customer_name']}`;
            }
          }),
          type: 'column',
          renderer: function(api, rowIdx, columns) {
            const data = columns.map(col =>
              col.title ? `<tr data-dt-row="${col.rowIndex}" data-dt-column="${col.columnIndex}">
                                                <td>${col.title}:</td><td>${col.data}</td>
                                             </tr>` :
              ''
            ).join('');
            return data ? $('<table class="table"><tbody />').append(data) : false;
          }
        }
      }
    });

    $('.radio_dash').change(function(e) {
      var status_dash = $(this).val();

      // Update the DataTable's AJAX URL and reload it
      var newUrl = "{{ route('consignments.list', ':status') }}".replace(':status', status_dash);
      table_consignment.ajax.url(newUrl).load(); // Reload the DataTable with new data
    });

    const today = new Date().toISOString().split('T')[0]; // Get current date in YYYY-MM-DD format
    document.getElementById('consignment_date').value = today;

    $('#saveconsignment').click(function(e) {
      e.preventDefault();
      var button = $(this);
      sending(button);
      var url = "{{ route('consignments.store') }}"; // API endpoint
      var type = "POST";
      var data = $('#consignmentForm').serialize(); // Form data
      $.ajax({
        url: url,
        type: type,
        data: data,
        dataType: 'json',
        success: function(response) {
          if (response.status === "success") {
            $('#consignmentForm').trigger("reset");
            $('#ConsignmentModel').modal('hide');
            showToast('success', response.msg);
            window.location.reload();
            table_consignment.draw();
            sending(button, true);
          }
        },
        error: function(xhr) {
          handleAjaxError(xhr);
          sending(button, true);
        }
      });
    });

    $('body').on('click', '.deleteconsignment', function() {
      var id = $(this).data('id');
      confirmDelete(id, function() {
        deleteConsignment(id);
      });
    });

    function deleteConsignment(id) {
      var url = "{{ route('consignments.destroy', ':id') }}".replace(':id', id);
      $.ajax({
        url: url,
        type: "DELETE",
        data: {
          id: id,
          _token: '{{ csrf_token() }}'
        },
        success: function(response) {
          handleAjaxResponse(response, table_consignment);
          window.location.reload();
        },
        error: function(xhr) {
          console.error('Error:', xhr.statusText);
          showError('Oops!', 'Failed to fetch data.');
        }
      });
    }
  });
</script>