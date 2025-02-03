<script type="text/javascript">
    
    $(function() {
       
    updateItemTotal()
    var product_data=$("#product_data").val();
    function updateExtended(rowIndex) {
    const qty = parseFloat($(`#qty_${rowIndex}`).val()) || 0; 
    const unitPrice = parseFloat($(`#unit_price_${rowIndex}`).val()) || 0; 
    const extended = qty * unitPrice; 
    $(`#extended_${rowIndex}`).val(extended.toFixed(2)); 
}

function updateTotal() {
   
    let total = 0;   
    $('.extended-field').each(function () {
        const value = parseFloat($(this).val()) || 0;
        total += value;
    });
    $('#itemTotal').text(`$${total.toFixed(2)}`);  
   
    calculateTotal();
}
$(document).on('input', '[id^="qty_"], [id^="unit_price_"]', function () {
    const idParts = $(this).attr('id').split('_');
    const rowIndex = idParts[idParts.length - 1];
    updateExtended(rowIndex);
    updateTotal(); 
});

$('#addMoreButton').hide();
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

    $('#supplierInvoicePackingForm input, #supplierInvoicePackingForm select').on('input change', function() {
            let fieldName = $(this).attr('name');
            $('.' + fieldName + '_error').text('');
        });

        $('#savedata').click(function(e) {
            
            e.preventDefault();
            var button = $(this);
            sending(button);

            var url = $('#supplier_invoice_id').val()
                ? "{{ route('supplier_invoices.update', ':id') }}".replace(':id', $('#supplier_invoice_id').val())
                : "{{ route('supplier_invoices.store') }}";
            var type = $('#supplier_invoice_id').val() ? "PUT" : "POST";
            
            var products = [];
            $('#supplierProducts tbody tr').each(function(index, row) {
                var product = {
                    po_id: $('#po_id').val(),
                    product_id: $(row).find('[name="product_id[]"]').val(), 
                    description: $(row).find('[name="description[]"]').val(),
                    supp_note: $(row).find('[name="supp_note[]"]').val(),
                    alt_qty: $(row).find('[name="alt_qty[]"]').val(),
                    qty: $(row).find('[name="qty[]"]').val(),
                    unit_price: $(row).find('[name="unit_price[]"]').val(),
                    extended: $(row).find('[name="extended[]"]').val(),
                    
                };
                products.push(product);
            });
             
    if (products.length === 0) {
            alert('No product data found.');
                }
            var formData = $('#supplierInvoicePackingForm').serializeArray();
            formData.push({ name: 'products', value: JSON.stringify(products) });

            $.ajax({
                url: url,
                type: type,
                data: formData,
                dataType: 'json',
                success: function(response) {
                
                    if (response.status === "success") {
            
                        $('#supplierInvoicePackingForm').trigger("reset");
                        showToast('success', response.msg);
                        table.draw();
                        var id = response.id;
                        window.location.href = "{{ route('supplier_invoice.supplier_invoice_packing', ':id') }}".replace(':id', id);
                    }
                },
                error: function(xhr) {
                    handleAjaxError(xhr);
                    sending(button, true);
                }
            });
             
});
        
$(document).ready(function () {
    $('#selectAll').on('change', function () {
        const isChecked = $(this).prop('checked');
        $('#supplierProducts tbody input[type="checkbox"]').prop('checked', isChecked);
    });

   
    $('#supplier_id').on('change', function () {
    var SupplierId = $(this).val();
    var tbody = $('#supplierProducts tbody');

    if (tbody.hasClass('loading')) return;

    if (SupplierId) {
        var url = "{{ route('fetch_supplier_details_product', ':id') }}";
        url = url.replace(':id', SupplierId);
        tbody.addClass('loading');

        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                $('#addMoreButton').show();
                tbody.removeClass('loading');
                if (response.success) {
                    $('#supplier_address').val(response.data.supplier.ship_address).prop('readonly', true);
                    $('#supplier_suite').val(response.data.supplier.ship_suite).prop('readonly', true);
                    $('#supplier_city').val(response.data.supplier.ship_city).prop('readonly', true);
                    $('#supplier_state').val(response.data.supplier.ship_state).prop('readonly', true);
                    $('#supplier_zip').val(response.data.supplier.ship_zip).prop('readonly', true);
                    $('#supplier_country_id').val(response.data.supplier.ship_country_id).trigger('change').prop('readonly', true);
                    $('#payment_term_id').val(response.data.supplier.payment_terms_id).trigger('change');
                    $('#freight_forwarder_id').val(response.data.supplier.frieght_forwarder_id).trigger('change');
                    tbody.empty();

                    if (response.data.products && response.data.products.length > 0) {
                        $("#product_data").val(1);
                    } else {
                        $("#product_data").val(0);
                    }

                    response.data.products.forEach((product, index) => {
                        const dataRow = `
                            <tr>
                                <td><input type="checkbox" class="form-check-input" id="product_check_id_${index}" name="product_check_id[]" /></td>
                                <td>
                                    <span id="po_number_${index}" aria-label="PO Number">${product.po_number || ''}</span>
                                    ${product.po_date || ''}
                                </td>
                                <td><span id="location_${index}" aria-label="Location">${product.company_name || ''}</span></td>
                                <td><span id="product_${index}" aria-label="Product">${product.product_name || ''}</span>
                                </td>
                                <td>
                                 <input type="hidden" class="form-control" id="product_id_${index}" name="product_id[]" value="${product.product_id || ''}" placeholder="Description" aria-label="Description" />
                                
                                <input type="text" class="form-control" id="description_${index}" name="description[]" value="${product.description || ''}" placeholder="Description" aria-label="Description" /></td>
                                <td><input type="text" class="form-control" id="supp_note_${index}" name="supp_note[]" value="${product.supplier_purchasng_note || ''}" placeholder="Supp./Pur. Note" aria-label="Supp./Pur. Note" /></td>
                                <td><input type="text" class="form-control" id="alt_qty_${index}" name="alt_qty[]" value="${product.slab || ''}" placeholder="Alt.Qty" aria-label="Alt.Qty" />Slabs</td>
                                <td></td>
                                <td><input type="text" class="form-control" id="qty_${index}" name="qty[]" value="${product.quantity || ''}" placeholder="Qty" aria-label="Qty" /></td>
                                <td><input type="text" class="form-control" id="unit_price_${index}" name="unit_price[]" value="${product.unit_price || ''}" placeholder="Unit Price" aria-label="Unit Price" /></td>
                                <td><input type="button" style="color: #007bff;" value="SP" /></td>
                                <td><input type="text" readonly class="form-control extended-field" id="extended_${index}" name="extended[]" value="${product.extended || ''}" placeholder="Extended" aria-label="Extended" /></td>
                            </tr>
                        `;
                        tbody.append(dataRow);
                    });

                    let currentIndex = tbody.find('tr').length;

                    for (let i = currentIndex; i < currentIndex + 3; i++) {
                        const emptyRow = `
                            <tr>
                                <td><input type="checkbox" class="form-check-input" id="product_check_id_${i}" name="product_check_id[]" /></td>
                               <td><span id="po_number_${i}" name="po_number[]"></span></td>
                                <td><span id="location_${i}" name="location[]"></span></td>
                                <td>
                                    <select class="form-select select2 product-select" name="product[]" id="product_${i}" data-allow-clear="true">
                                        <option value="">--Select Product--</option>
                                        @foreach($product as $prd)
                                            <option value="{{ $prd->id }}">{{ $prd->product_name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td><input type="text" class="form-control" id="description_${i}" name="description[]" placeholder="" aria-label="" /></td>
                                <td><input type="text" class="form-control" id="supp_note_${i}" name="supp_note[]" placeholder="Supp./Pur. Note" aria-label="Supp./Pur. Note" /></td>
                                <td><input type="text" class="form-control" id="alt_qty_${i}" name="alt_qty[]" placeholder="Alt.Qty" aria-label="Alt.Qty" /></td>
                                <td></td>
                                <td><input type="text" class="form-control" id="qty_${i}" name="qty[]" placeholder="Qty" aria-label="Qty" /></td>
                                <td><input type="text" class="form-control unit-price" id="unit_price_${i}" name="unit_price[]" placeholder="Unit Price" aria-label="Unit Price" /></td>
                                <td><input type="button" style="color: #007bff;" value="SP" /></td>
                                <td><input type="text" readonly class="form-control extended-field" id="extended_${i}" name="extended[]" placeholder="Extended" aria-label="Extended" /></td>
                            </tr>
                        `;
                        tbody.append(emptyRow);
                    }
                    tbody.on('change', '.product-select', function() {
                    const $row = $(this).closest('tr');
                    const $checkbox = $row.find('input[type="checkbox"]'); 
                    const $unitPrice = $row.find('.unit-price');
                    
                    $checkbox.prop('checked', !!$(this).val()); 
                    $unitPrice.val('0.00');
                });
                updateTotal();
                }
            }
        });
        tbody.on('change', '.product-select', function () {
        const $row = $(this).closest('tr'); 
        const $checkbox = $row.find('input[type="checkbox"]');
        const $unitPrice = $row.find('.unit-price'); 
        const selectedProductId = $(this).val(); 
        $checkbox.prop('checked', !!selectedProductId); 
        $unitPrice.val('0.00');
        let $hiddenInput = $row.find('input[name="product_id[]"]');
        if ($hiddenInput.length === 0) {
          
            const hiddenInput = `
                <input type="hidden" class="form-control" id="product_id_${$row.index()}" name="product_id[]" value="${selectedProductId}" placeholder="Description" aria-label="Description" />
            `;
            $row.append(hiddenInput);
        } else {
           
            $hiddenInput.val(selectedProductId);
        }
    });

    }
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

                    $('#purchase_location_address').val(response.data.address)
                        .prop('readonly', true);
                    $('#purchase_location_suite').val(response.data.address_2).prop(
                        'readonly', true);
                    $('#purchase_location_city').val(response.data.city).prop(
                        'readonly', true);
                    $('#purchase_location_state').val(response.data.state).prop(
                        'readonly', true);
                    $('#purchase_location_zip').val(response.data.zip).prop('readonly',
                        true);
                    $('#purchase_location_country_id').val(response.data.data.country_id).trigger('change').prop('readonly', true);
                   
                   
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
                 
                    $('#ship_to_location_address').val(response.data.shipping_address)
                        .prop('readonly', true);
                    $('#ship_to_location_attn').val(response.data.shipping_address_2).prop(
                        'readonly', true);
                    $('#ship_to_location_suite').val(response.data.shipping_address_2).prop(
                        'readonly', true);
                    $('#ship_to_location_city').val(response.data.shipping_city).prop(
                        'readonly', true);
                    $('#ship_to_location_state').val(response.data.shipping_state).prop(
                        'readonly', true);
                    $('#ship_to_location_zip').val(response.data.shipping_zip).prop('readonly',
                        true);
                    $('#ship_to_location_country_id').val(response.data.shipping_country_id)
                            .trigger('change')

                    
                   
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
 
    const tbody = document.getElementById('tbody_supplier_products');
const addMoreButton = document.getElementById('addMoreButton');

addMoreButton.addEventListener('click', function () {
    let currentIndex = tbody.querySelectorAll('tr').length;
    for (let i = currentIndex; i < currentIndex + 3; i++) {
        const emptyRow = `
            <tr>
                <td><input type="checkbox" class="form-check-input" id="product_check_id_${i}" name="product_check_id[]" /></td>
              <td><span id="po_number_${i}" name="po_number[]"></span></td>
                <td><span id="location_${i}" name="location[]"></span></td>
                <td>
                    <select class="form-select select2 product-select" name="product[]" id="product_${i}" data-allow-clear="true">
                        <option value="">--Select Product--</option>
                        @foreach($product as $prd)
                            <option value="{{ $prd->id }}">{{ $prd->product_name }}</option>
                        @endforeach
                    </select>
                </td>
                <td><input type="text" class="form-control" id="description_${i}" name="description[]" placeholder="" aria-label="" /></td>
                <td><input type="text" class="form-control" id="supp_note_${i}" name="supp_note[]" placeholder="Supp./Pur. Note" aria-label="Supp./Pur. Note" /></td>
                <td><input type="text" class="form-control" id="alt_qty_${i}" name="alt_qty[]" placeholder="Alt.Qty" aria-label="Alt.Qty" /></td>
                <td></td>
                <td><input type="text" class="form-control" id="qty_${i}" name="qty[]" placeholder="Qty" aria-label="Qty" /></td>
                <td><input type="text" class="form-control unit-price " id="unit_price_${i}" name="unit_price[]" placeholder="Unit Price" aria-label="Unit Price" /></td>
                <td><input type="button" style="color: #007bff;" value="SP" /></td>
                <td><input type="text"  class="form-control extended-field" id="extended_${i}" name="extended[]" placeholder="Extended" aria-label="Extended" /></td>
            </tr>
        `;
        tbody.insertAdjacentHTML('beforeend', emptyRow);
    }
    tbody.on('change', '.product-select', function() {
    const $row = $(this).closest('tr'); 
    const $checkbox = $row.find('input[type="checkbox"]');
    const $unitPrice = $row.find('.unit-price'); 
    
    $checkbox.prop('checked', !!$(this).val());
    $unitPrice.val('0.00'); 
});
    updateTotal();
});

});
});

const tbody = document.getElementById('tbody_supplier_products');
const addMoreButton = document.getElementById('addMoreEdit');

addMoreButton.addEventListener('click', function () {
    let currentIndex = tbody.querySelectorAll('tr').length; 
    for (let i = currentIndex; i < currentIndex + 3; i++) {
        const emptyRow = `
            <tr>
                <td>
                    <input type="hidden" name="product[${i}][po_id]" value="${document.getElementById('po_id').value}" />
                    <input type="checkbox" name="product[${i}][selected]" value="1" />
                </td>
                <td><span>${document.getElementById('po_id').value}</span></td>
                <td>
                    <select name="product[${i}][product_id]" class="form-select">
                        @foreach($product as $prd)
                            <option value="{{ $prd->id }}">{{ $prd->product_name }}</option>
                        @endforeach
                    </select>
                </td>
                <td><input type="text" class="form-control" name="product[${i}][description]" /></td>
                <td><input type="text" class="form-control" name="product[${i}][supplier_purchasng_note]" /></td>
                <td><input type="text" class="form-control" name="product[${i}][slab]" /></td>
                <td></td>
                <td><input type="number" class="form-control" name="product[${i}][quantity]" oninput="calculateExtended(this)" /></td>
                <td><input type="number" class="form-control" name="product[${i}][unit_price]" oninput="calculateExtended(this)" /></td>
                <td><input type="button" style="color: #007bff;" value="SP" /></td>
                <td><input type="text" class="form-control" name="product[${i}][extended]" readonly /></td>
            </tr>
        `;
        tbody.insertAdjacentHTML('beforeend', emptyRow);
    }
    updateTotal();
});



function calculateTotal() {
        let otherTotal = 0;
        const extendedFields = document.querySelectorAll('.extended');
        
        
        extendedFields.forEach(field => {
            const value = parseFloat(field.value) || 0; 
            otherTotal += value;
        });

        
        document.getElementById('otherTotal').textContent = `$${otherTotal.toFixed(2)}`;
    
        const itemTotalElement = document.getElementById('itemTotal');
        const itemTotalValue = parseFloat(itemTotalElement.textContent.replace('$', '')) || 0;
        const total = itemTotalValue + otherTotal;
        document.getElementById('total').textContent = `$${total.toFixed(2)}`;
    }
    

    function calculateExtended(element) {
   
    const row = element.closest('tr');
    const quantity = parseFloat(row.querySelector('[name*="[quantity]"]').value) || 0;
    const unitPrice = parseFloat(row.querySelector('[name*="[unit_price]"]').value) || 0;
    const extended = quantity * unitPrice;
    row.querySelector('[name*="[extended]"]').value = extended.toFixed(2);
    updateItemTotal();
}

function updateItemTotal() {
    let itemTotal = 0;
    document.querySelectorAll('#tbody_supplier_products [name*="[extended]"]').forEach(function (extendedField) {
        itemTotal += parseFloat(extendedField.value) || 0;
    });
    const itemTotalElement = document.getElementById('itemTotal');
    if (itemTotalElement) {
        itemTotalElement.textContent = `$${itemTotal.toFixed(2)}`;
    }
    updateTotal();
}


function updateTotal() {
    const itemTotal = parseFloat(document.getElementById('itemTotal')?.textContent.replace('$', '').trim()) || 0;
    const otherTotal = parseFloat(document.getElementById('otherTotal')?.textContent.replace('$', '').trim()) || 0;
    const total = itemTotal + otherTotal;
    const totalElement = document.getElementById('total');
    if (totalElement) {
        totalElement.textContent = `$${total.toFixed(2)}`;
    }
}

document.querySelectorAll('[name*="[quantity]"], [name*="[unit_price]"]').forEach(function (element) {
    element.addEventListener('input', function () {
        calculateExtended(this);
    });
});

function fetchAccounts(index) {
    var serviceId = $('#service_id' + index).val();
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
                        
                        let selectElement = $('#account_id' + index); 
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



    function calculateTotal() {
    let total = 0;
 
    document.querySelectorAll('.extended').forEach(input => {
        let value = parseFloat(input.value) || 0;
        total += value;
    });

    document.getElementById('otherTotal').textContent = `$${total.toFixed(2)}`;

    updateGrandTotal();
}

function updateGrandTotal() {
    let itemTotal = parseFloat(document.getElementById('itemTotal').textContent.replace('$', '')) || 0;
    let otherTotal = parseFloat(document.getElementById('otherTotal').textContent.replace('$', '')) || 0;

    let grandTotal = itemTotal + otherTotal;
    document.getElementById('total').textContent = `$${grandTotal.toFixed(2)}`;
}


document.addEventListener('DOMContentLoaded', calculateTotal);

</script>