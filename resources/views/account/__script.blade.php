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
    var table = $('#datatablesAccount').DataTable({
      responsive: true,
      processing: true,
      serverSide: true,
      searching: false,
      order: [
        [1, 'desc']
      ],
      ajax: {
        url: "{{ route('account.list') }}",
        data: function(d) {
          d.supplier_name_search = $('#supplierNameFilter').val();
          d.currency_search = $('#currencyFilter').val();
          d.supplier_type_search = $('#supplierTypeFilter').val();
          d.address_search = $('#addressFilter').val();
          d.phone_search = $('#phoneFilter').val();
          d.location_search = $('#locationFilter').val();
          d.payment_term_search = $('#paymentTermFilter').val();
          d.language_search = $('#languageFilter').val();
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
          $(row).addClass('table-danger'); // You can replace this with a custom class
        }
      },
      dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex align-items-center justify-content-end"fB>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
      buttons: [{
        text: '<i class="bx bx-plus me-sm-1"></i> <span class="d-none d-sm-inline-block">Add Account</span>',
        className: 'create-new btn btn-primary',
        action: function(e, dt, node, config) {
          window.location.href = "{{ route('account.create') }}";
        }
      }]
    });




  });
</script>