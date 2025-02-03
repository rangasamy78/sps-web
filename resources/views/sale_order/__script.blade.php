<script type="text/javascript">
    $(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#salesOrderNumberFilter, #salesOrderDateFilter, #customerPoNumberFilter, #jobNameFilter, #shipToTypeFilter, #requestedShipDateFilter, #estDeliveryDateFilter, #billingCustomerFilter, #locationIdFilter, #salesPersonFilter').on('keyup change', function(e) {
            e.preventDefault();
            table_sales_order.draw();
        });

        var table_sales_order = $('#datatablesSalesOrder').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            searching: false,
            ajax: {
                url: "{{ route('sale_orders.list') }}",
                data: function(d) {
                    d.sales_order_code = $('#salesOrderNumberFilter').val();
                    d.sales_order_date = $('#salesOrderDateFilter').val();
                    d.customer_po_code = $('#customerPoNumberFilter').val();
                    d.ship_to_job_name = $('#jobNameFilter').val();
                    d.ship_to_type = $('#shipToTypeFilter').val();
                    d.requested_ship_date = $('#requestedShipDateFilter').val();
                    d.est_delivery_date = $('#estDeliveryDateFilter').val();
                    d.billing_customer = $('#billingCustomerFilter').val();
                    d.location = $('#locationIdFilter').val();
                    d.sales_person = $('#salesPersonFilter').val();
                    sort = (d.order[0].dir == 'asc') ? "asc" : "desc";
                    d.order = [{
                        column: 1,
                        dir: sort
                    }];
                }
            },
            columns: [{
                    data: 'sales_order_code',
                    name: 'sales_order_code'
                },
                {
                    data: 'sales_order_date',
                    name: 'sales_order_date'
                },
                {
                    data: 'customer_po_code',
                    name: 'customer_po_code'
                },
                {
                    data: 'ship_to_job_name',
                    name: 'ship_to_job_name'
                },
                {
                    data: 'ship_to_type',
                    name: 'ship_to_type'
                },
                {
                    data: 'requested_ship_date',
                    name: 'requested_ship_date'
                },
                {
                    data: 'est_delivery_date',
                    name: 'est_delivery_date'
                },
                {
                    data: 'billing_customer',
                    name: 'billing_customer'
                },
                {
                    data: 'location',
                    name: 'location'
                },
                {
                    data: 'sales_person',
                    name: 'sales_person'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
            rowCallback: function(row, data, index) {},
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex align-items-center justify-content-end"B>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            buttons: [{
                    text: '<i class="bx bx-plus me-sm-1"></i> <span class="d-none d-sm-inline-block">Add Sale Order</span>',
                    className: 'create-new btn btn-primary',
                    action: function(e, dt, node, config) {
                        window.location.href = "{{ route(name: 'sale_orders.create') }}";
                    }
                },
                {
                    extend: 'collection',
                    className: 'btn btn-label-secondary dropdown-toggle mx-3',
                    text: '<i class="bx bx-export me-1"></i> Export',
                    buttons: [{
                            extend: 'print',
                            text: '<i class="bx bx-printer me-2"></i> Print',
                            className: 'dropdown-item'
                        },
                        {
                            extend: 'csv',
                            text: '<i class="bx bx-file me-2"></i> CSV',
                            className: 'dropdown-item'
                        },
                        {
                            extend: 'excel',
                            text: '<i class="bx bxs-file-export me-2"></i> Excel',
                            className: 'dropdown-item'
                        },
                        {
                            extend: 'pdf',
                            text: '<i class="bx bxs-file-pdf me-2"></i> PDF',
                            className: 'dropdown-item'
                        },
                        {
                            extend: 'copy',
                            text: '<i class="bx bx-copy me-2"></i> Copy',
                            className: 'dropdown-item'
                        }
                    ]
                }
            ]
        });

        $('#saleOrderForm input, #saleOrderForm select').on('keyup change', function() {
            var inputName = $(this).attr('name');
            $('.' + inputName + '_error').html('');
        });
        $('#savedata').click(function(e) {
            e.preventDefault();
            var button = $(this);
            sending(button);
            var editorContent = document.querySelector('.ql-editor').innerHTML;
            document.querySelector('#print_doc_description_editor').value = editorContent;

            var activeDeliveryMethod = $('#pills-tab .nav-link.active').val();
            var url = $('#sales_order_id').val() ? "{{ route('sale_orders.update', ':id') }}".replace(
                ':id', $('#sales_order_id').val()) : "{{ route('sale_orders.store') }}";
            var type = $('#sales_order_id').val() ? "PUT" : "POST";
            var data = $('#sales_order_id').val() ? $('#saleOrderEditForm').serialize() +
                "&ship_to_type=" + activeDeliveryMethod : $('#saleOrderForm').serialize() +
                "&ship_to_type=" + activeDeliveryMethod;
            var id = $('#sales_order_id').val();
            var redirect = id ?
                "{{ route('sale_orders.show', ':id') }}".replace(':id', id) :
                "{{ route('sale_orders.index') }}";
            $.ajax({
                url: url,
                type: type,
                data: data,
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        $('#supplierForm').trigger("reset");
                        table_sales_order.draw();
                        showToast('success', response.msg);
                        window.location.href = redirect;
                    }
                },
                error: function(xhr) {
                    handleAjaxError(xhr);
                    sending(button, true);
                }
            });
        });

        $(document).ready(function() {
      $('#saleOrderSearch').on('change', function() {
        const selectedValues = $(this).val();
        $('.filter-input').hide();
        selectedValues.forEach(function(value) {
          switch (value) {
            case '1':
              $('#salesOrderNumberDiv').show();
              break;
            case '2':
              $('#salesOrderDateDiv').show();
              break;
            case '3':
              $('#customerPoNumberDiv').show();
              break;
            case '4':
              $('#jobNameDiv').show();
              break;
            case '5':
              $('#shipToTypeDiv').show();
              break;
            case '6':
              $('#requestedShipDateDiv').show();
              break;
            case '7':
              $('#estDeliveryDateDiv').show();
              break;
            case '8':
              $('#billingCustomerDiv').show();
              break;
            case '9':
              $('#locationIdDiv').show();
              break;
            case '10':
              $('#salesPersonDiv').show();
              break;
            default:
              break;
          }
        });
      });
    });

    });
</script>
