<script type="text/javascript">
    $(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var table = $('#datatable').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            searching: false,
            order: [
                [0, 'desc']
            ],
            ajax: {
                url: "{{ route('supplier_invoices.list') }}",
                data: function(d) {
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
                    searchable: false
                },
                {
                    data: 'sipl_bill',
                    name: 'sipl_bill'
                },
                {
                    data: 'po_id',
                    name: 'po_id'
                },
                {
                    data: 'entry_date',
                    name: 'entry_date'
                },
                {
                    data: 'invoice',
                    name: 'invoice'
                },
                {
                    data: 'payment_term_id',
                    name: 'payment_term_id'
                },
                {
                    data: 'supplier_so',
                    name: 'supplier_so'
                },
                {
                    data: 'container_number',
                    name: 'container_number'
                },
                {
                    data: 'supplier_id',
                    name: 'supplier_id'
                },
                {
                    data: 'ship_to_location_id',
                    name: 'ship_to_location_id'
                },
                {
                    data: 'ship_date',
                    name: 'ship_date'
                },
                {
                    data: 'sipl_status',
                    name: 'sipl_status'
                },
               
                {
                    data: 'freight_forwarder_id',
                    name: 'freight_forwarder_id'
                },
               
               
                {
                    data: 'received_date',
                    name: 'received_date'
                },
                {
                    data: 'item_total',
                    name: 'item_total'
                },
                 {
                    data: 'balance_due',
                    name: 'balance_due'
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
            text: '<span class="d-none d-sm-inline-block">New Supplier Invoice </span>',
            className: 'btn btn-primary me-2',
            attr: {
                id: 'product',
            },
            action: function(e, dt, node, config) {
                window.location.href = "{{ route('supplier_invoices.create') }}";
            }
        }, ],

            
           
        });

        $('#supplierInvoicePackingForm input').on('input', function() {
            let fieldName = $(this).attr('name');
            $('.' + fieldName + '_error').text('');
        })
        $('#savedata').click(function(e) {
            e.preventDefault();
            var button = $(this);
            sending(button);
            var url = $('#supplier_invoice_id').val() ? "{{ route('supplier_invoices.update', ':id') }}".replace(':id', $('#supplier_invoice_id').val()) : "{{ route('supplier_invoices.store') }}";
            var type = $('#supplier_invoice_id').val() ? "PUT" : "POST";
            $.ajax({
                url: url,
                type: type,
                data: $('#supplierInvoicePackingForm').serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        $('#supplierInvoicePackingForm').trigger("reset");                      
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

        $(document).ready(function() {
            $('#supplier_id').on('change', function() {
    var SupplierId = $(this).val();
    var tbody = $('#supplierProducts tbody');

    if (tbody.hasClass('loading')) return;  

    if (SupplierId) {
        var url = "{{ route('fetch_supplier_details', ':id') }}";
        url = url.replace(':id', SupplierId);

        tbody.addClass('loading');

        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                tbody.removeClass('loading');

                if (response.success) {
                    $('#supplier_address').val(response.data.ship_address).prop('readonly', true);
                    $('#supplier_suite').val(response.data.ship_suite).prop('readonly', true);
                    $('#supplier_city').val(response.data.ship_city).prop('readonly', true);
                    $('#supplier_state').val(response.data.ship_state).prop('readonly', true);
                    $('#zip').val(response.data.ship_zip).prop('readonly', true);
                    $('#country_id').val(response.data.ship_country_id).trigger('change').prop('readonly', true);
                    $('#payment_term_id').val(response.data.payment_terms_id).trigger('change');
                    tbody.empty();
                    var row = `
                        <tr>
                            <td><input type="checkbox" class="form-check-input" id="wiring_instruction_id" name="wiring_instruction_id" /></td>
                            <td></td>
                            <td>
                                <select class="form-select select2" name="product_id" id="product_id" data-allow-clear="true">
                                    <option value="">--Select --</option>
                                    <!-- Add product options dynamically here if needed -->
                                </select>
                            </td>
                            <td><input type="text" class="form-control" id="description" name="description" placeholder="Description" aria-label="Description" /></td>
                            <td><input type="text" class="form-control" id="supp_note" name="supp_note" placeholder="Supp./Pur. Note" aria-label="Supp./Pur. Note" /></td>
                            <td><input type="text" class="form-control" id="alt_qty" name="alt_qty" placeholder="Alt.Qty" aria-label="Alt.Qty" /></td>
                            <td></td>
                            <td><input type="text" class="form-control" id="pr_alt_uom" name="pr_alt_uom" placeholder="Pr./Alt.UOM" aria-label="Pr./Alt.UOM" /></td>
                            <td><input type="text" class="form-control" id="qty" name="qty" placeholder="Qty" aria-label="Qty" /></td>
                            <td><input type="text" class="form-control" id="unit_price" name="unit_price" placeholder="Unit Price" aria-label="Unit Price" /></td>
                            <td><input type="button" style="color: #007bff;" value="SP" /></td>
                            <td><input type="text" class="form-control" id="extended" name="extended" placeholder="Extended" aria-label="Extended" /></td>
                        </tr>
                    `;

                
                    for (var i = 0; i < 3; i++) {
                        tbody.append(row);  
                    }
                } else {
                    alert('Supplier details not found.');
                }
            },
            error: function() {
                tbody.removeClass('loading');
                alert('Error fetching supplier details');
            }
        });
    }
});

});

     
    });
</script>