<script type="text/javascript">
$(function() {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#supplierInvoiceForm').on('input change', 'input, select', function() {
        let fieldName = $(this).attr('name');
        $('.' + fieldName + '_error').text('');
    });

    $('#supplierInvoiceForm').on('input change', 'input[type="date"]', function() {
        let fieldName = $(this).attr('name');
        $('.' + fieldName + '_error').text('');
    });


    document.getElementById('selectAll').addEventListener('change', function() {
        const isChecked = this.checked;
        const checkboxes = document.querySelectorAll('.rowCheckbox');
        
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = isChecked;
        });
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
            url: "{{ route('purchase_orders.list') }}",
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
                data: 'po_number',
                name: 'po_number'
            },
            {
                data: 'po_date',
                name: 'po_date'
            },
            {
                data: 'required_ship_date',
                name: 'required_ship_date'
            },
            {
                data: 'supplier_so_number',
                name: 'supplier_so_number'
            },
            {
                data: 'supplier_id',
                name: 'supplier_id'
            },
            {
                data: 'container_number',
                name: 'container_number'
            },
            {
                data: 'payment_term_id',
                name: 'payment_term_id'
            }, {
                data: 'po_number',
                name: 'po_number'
            },
            {
                data: 'po_number',
                name: 'po_number'
            },
            {
                data: 'po_number',
                name: 'po_number'
            },
            {
                data: 'po_number',
                name: 'po_number'
            },
            {
                data: 'po_number',
                name: 'po_number'
            }, ,
            {
                data: 'po_number',
                name: 'po_number'
            },
            {
                data: 'po_number',
                name: 'po_number'
            },
            {
                data: 'po_number',
                name: 'po_number'
            },
            {
                data: 'po_number',
                name: 'po_number'
            },
            {
                data: 'po_number',
                name: 'po_number'
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
            text: '<span class="d-none d-sm-inline-block">New Purchase Order</span>',
            className: 'btn btn-primary me-2',
            attr: {
                id: 'product',
            },
            action: function(e, dt, node, config) {
                window.location.href = "{{ route('purchase_orders.create') }}";
            }
        }, ],
    });
    $('#savedata').on('click', function(e) {
    e.preventDefault();

  
    var hasCheckedItems = $('td input.rowCheckbox:checked').length > 0;

    if (!hasCheckedItems) {
       
        var confirmSave = confirm('Are you sure you want to create a Purchase with no items?');
        if (!confirmSave) {
          
            return false;
        }
    }

    
    var button = $(this);
    sending(button);
    var po_id = $('#po_id').val();
    var url = "{{ route('supplier_invoice.supplier_save') }}";
    var type = "POST";

    $.ajax({
        url: url,
        type: type,
        data: $('#supplierInvoiceForm').serialize(),
        dataType: 'json',
        success: function(response) {
            if (response.status == "success") {
                $('#supplierInvoiceForm').trigger("reset");
                showToast('success', response.msg);
                table.draw();
                var id = response.id;

                window.location.href =
                    "{{ route('supplier_invoice.supplier_invoice_packing', ':id') }}".replace(':id', id);
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

            if (SupplierId) {
                var url = "{{ route('fetch_supplier_details', ':id') }}";
                url = url.replace(':id', SupplierId);

                $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            $('#supplier_address').val(response.data.ship_address);
                            $('#supplier_suite').val(response.data.ship_suite);
                            $('#supplier_city').val(response.data.ship_city);
                            $('#supplier_state').val(response.data.ship_state);
                            $('#zip').val(response.data.ship_zip);
                            $('#country_id').val(response.data.ship_country_id)
                                .trigger('change');
                            $('#payment_term_id').val(response.data
                                .payment_terms_id).trigger('change');

                        } else {
                            alert('Supplier details not found.');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log('Error:', error);
                    }
                });
            }
        });
    });


    $('#purchase_location_id').on('change', function() {
            var locationId = $(this).val();
            if (locationId) {
                var url = "{{ route('purchase_location_details', ':id') }}";
                url = url.replace(':id', locationId);
                $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                         
                            $('#purchase_location_address').val(response.data.address_line_1)
                                .prop('readonly', true);
                            $('#purchase_location_suite').val(response.data.address_line_2).prop(
                                'readonly', true);
                            $('#purchase_location_city').val(response.data.city).prop(
                                'readonly', true);
                            $('#purchase_location_state').val(response.data.state).prop(
                                'readonly', true);
                            $('#purchase_location_zip').val(response.data.zip).prop('readonly',
                                true);
                           
                        } else {
                            alert(' details not found.');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log('Error:', error);
                    }
                });
            }
        });


        $('#ship_to_location_id').on('change', function() {
            
            var locationId = $(this).val();
            if (locationId) {
                var url = "{{ route('ship_location_details', ':id') }}";
                url = url.replace(':id', locationId);
                $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                         
                            $('#ship_to_location_address').val(response.data.address_line_1)
                                .prop('readonly', true);
                            $('#ship_to_location_suite').val(response.data.address_line_2).prop(
                                'readonly', true);
                            $('#ship_to_location_city').val(response.data.city).prop(
                                'readonly', true);
                            $('#ship_to_location_state').val(response.data.state).prop(
                                'readonly', true);
                            $('#ship_to_location_zip').val(response.data.zip).prop('readonly',
                                true);
                           
                        } else {
                            alert(' details not found.');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log('Error:', error);
                    }
                });
            }
        });


});

function fetchAccounts(index) {
   
    var serviceId = $('#service_id_' + index).val();
 
        if (serviceId) {
                var url = "{{ route('fetch_service_account_details', ':id') }}";
                url = url.replace(':id', serviceId);
                $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                      
                        if(response.success) {
                        let accountId = response.data.gl_cost_of_sales_account_id;
                        
                        let selectElement = $('#freight_forwarder_id_' + index); 
                        selectElement.find('option').each(function() {
                            if ($(this).val() == accountId) {
                                $(this).prop('selected', true);  
                            }
                        });
                        
                        selectElement.trigger('change');
}

                    else {
                            alert(' details not found.');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log('Error:', error);
                    }
                });
            }



    }

$(document).ready(function() {

    function fetchPurchaseOrderProducts() {
        var po_id = $('#po_id').val();

        var url = "{{ route('fetch_po_products', ':id') }}";
        url = url.replace(':id', po_id);
        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            success: function(data) {},
            error: function(xhr, status, error) {
                console.error('Error fetching data:', error);
                $('#fileUploadRow').html('<tr><td colspan="10">Error fetching data</td></tr>');
            }
        });
    }

    fetchPurchaseOrderProducts();
});


function calculateTotals() {
        
        const inputs = document.querySelectorAll('.extended');
        let otherTotal = 0;
        inputs.forEach(input => {
            const value = parseFloat(input.value) || 0;
            otherTotal += value;
        });

        const itemsTotal = parseFloat("{{ $subTotal }}") || 0;

        document.getElementById('otherTotal').innerText = `$${otherTotal.toFixed(2)}`;
        document.getElementById('totalSum').innerText = `$${(itemsTotal + otherTotal).toFixed(2)}`;
    }

    document.addEventListener('DOMContentLoaded', function () {
        calculateTotals();
    });
</script>