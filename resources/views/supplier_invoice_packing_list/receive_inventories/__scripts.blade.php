<script type="text/javascript">
    $(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        let currentDate = new Date().toISOString().split('T')[0];
        $('#receivedDate').val(currentDate);

             
});

$(document).ready(function () {

    function calculateTotals() {
        let subTotal = 0;

 
        $('#productData tr').each(function () {
            let extendedValue = parseFloat($(this).find('td:nth-child(8)').text()) || 0;
            subTotal += extendedValue;
        });

      
        $('#OtherChargeInventory tr').each(function () {
            let extendedValue = parseFloat($(this).find('td:nth-child(9)').text()) || 0;
            subTotal += extendedValue;
        });

     
        $('#subTotal').text(subTotal.toFixed(2));
        $('#total').text(subTotal.toFixed(2));
        $('#balanceDue').text(subTotal.toFixed(2));
    }

    let po_id = $('#po_id').val();
    let po_location = $('#po_location').val();
    if (po_id) {
        let url = "{{ route('fetch_product_details', ':id') }}".replace(':id', po_id);

        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    let data = response.data;
                    let tbody = $('#productData');
                    tbody.empty();

                    let totalBilledQty = 0;
                    let totalCost = 0;
                    let totalReceivedQty = 0;
                    let totalFreight = 0;

                    if (data && data.length > 0) {
                        data.forEach((item) => {
                            const billedQty = parseFloat(item.alt_qty || 0);
                            const receivedQty = parseFloat(item.quantity || 0);
                            const unitPrice = parseFloat(item.unit_price || 0);
                            const extended = parseFloat(item.extended || 0); 

                            totalBilledQty += billedQty;
                            totalCost += extended; 
                            totalReceivedQty += receivedQty;

                            let row = `
                                <tr>
                                    <td>${item.product.product_name || ''}</td>
                                    <td></td>
                                    <td>${billedQty}</td>
                                    <td>${unitPrice.toFixed(2)}</td>
                                    <td>${extended.toFixed(2)}</td>
                                    <td>${receivedQty}</td>
                                    <td>${receivedQty}</td>
                                    <td>${(extended / receivedQty || 0).toFixed(2)}</td>
                                    <td>0.00</td>
                                    <td>0.00</td>
                                    <td>0.00</td>
                                    <td>0.00</td>
                                </tr>`;
                            tbody.append(row);
                        });

                       
                        $('#totalBilledQty').text(totalBilledQty.toFixed(2));
                        $('#totalCost').text(totalCost.toFixed(2)); 
                        $('#totalReceivedQty').text(totalReceivedQty.toFixed(2));
                        $('#totalFreight').text(totalFreight.toFixed(2));
                    } else {
                        tbody.append(`<tr><td colspan="12" class="text-center">No data found.</td></tr>`);
                    }
                } else {
                    alert('Product details not found.');
                }
            },
            error: function (xhr, status, error) {
                console.error('Error fetching product details:', error);
            }
        });
    }

    if (po_id) {
    var url = "{{ route('fetch_bills_data', ':id') }}";
    url = url.replace(':id', po_id);
    $.ajax({
        url: url,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                let data = response.data;
                let tbody = $('#freightBills');
                tbody.empty(); 
                let totalExtended = 0;

                if (data && data.length > 0) {
                    data.forEach((item) => {
                        let extendedTotal = parseFloat(item.extended_total) || 0;
                        totalExtended += extendedTotal;
                       
                        let row = `
                            <tr class="main-row">
                                <td>${item.invoice_number || ''}</td>
                                <td>${item.invoice_date || ''}</td>
                                <td>${item.supplier_name || ''}</td>
                                <td>${extendedTotal.toFixed(2)}</td>
                                <td>${extendedTotal.toFixed(2)}</td>
                            </tr>
                            <tr class="subtable-row" style="display: none;">
                                <td colspan="5">
                                    <table style="width: 100%">
                                        <tr>
                                            <td><strong>Account</strong></td>
                                            <td><strong>Location</strong></td>
                                            <td><strong>Service</strong></td>
                                            <td><strong>Extended</strong></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>`;

                        tbody.append(row);

                    
                        let detailsUrl = "{{ route('fetch_other_details', ':id') }}".replace(':id', po_id);
                        $.ajax({
                            url: detailsUrl,
                            type: 'GET',
                            dataType: 'json',
                            success: function(detailsResponse) {
                                if (detailsResponse.success) {
                                    let details = detailsResponse.data;
                                    details.forEach((detail) => {
                                        let subTableRow = `
                                            <tr>
                                                <td>${detail.account.account_name || ''}</td>
                                                <td>${po_location|| ''}</td>
                                                <td>${detail.service.service_name || ''}</td>
                                                <td>${detail.extended || ''}</td>
                                              
                                               
                                            </tr>`;
                                        
                                        $(tbody).find('.subtable-row:last-child table').append(subTableRow);
                                    });
                                }
                            },
                            error: function(xhr, status, error) {
                                console.log('Error fetching details:', error);
                            }
                        });
                    });

                   
                    $('tfoot td:last-child').text(`$${totalExtended.toFixed(2)}`);
                } else {
                    tbody.append(`<tr><td colspan="5" class="text-center">No data found.</td></tr>`);
                    $('tfoot td:last-child').text('$0.00'); 
                }

               
                $('tr.main-row').on('click', function () {
                    let nextRow = $(this).next('.subtable-row');
                    nextRow.toggle(); 
                });

            } else {
                alert('Details not found.');
            }
        },
        error: function(xhr, status, error) {
            console.log('Error:', error);
        }
    });
}
let id = $('#id').val();

if (id) {
        let url = "{{ route('fetch_unreceive_data', ':id') }}".replace(':id', id);

        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    let data = response.data;
                    let tbody = $('#UnreceiveData');
                    tbody.empty();

                    if (data && data.length > 0) {
                        data.forEach((item) => {
                         
                            let row = `
                                <tr>
                                    <td>${item.sipl_bill || ''}</td>
                                    <td>${item.purchase_order.po_number || ''}</td>
                                    <td>${item.entry_date || ''}</td>
                                    <td>${item.supplier_so || ''}</td>
                                    <td>${item.container_number || ''}</td>
                                    <td>${item.supplier_id || ''}</td>
                                    <td>${item.ship_to_location_id || ''}</td>
                                    <td>${item.ship_date || ''}</td>
                                    <td>${item.purchase_order.extended_total || ''}</td>
                                  
                                   
                                </tr>`;
                            tbody.append(row);
                        });

                       
                      
                    } else {
                        tbody.append(`<tr><td colspan="12" class="text-center">No data found.</td></tr>`);
                    }
                } else {
                    alert(' details not found.');
                }
            },
            error: function (xhr, status, error) {
                console.error('Error fetching product details:', error);
            }
        });
    }

});



$('#receiveInvoiceButton').on('click', function() {
    

let po_id = $('#po_id').val();
let supplier_invoice_id = $('#id').val();
let received_date = $('#receivedDate').val();
var url = "{{ route('receive_inventory_details', ':id') }}".replace(':id', supplier_invoice_id);
var type = "POST";

$.ajax({
    url: url,
    type: type,
    data: {
        
        supplier_invoice_id: supplier_invoice_id,
        received_date: received_date
    },
    dataType: 'json',
    success: function(response) {
        var id = response.id;
        window.location.href = "{{ route('supplier_invoice.supplier_invoice_packing', ':id') }}".replace(':id', id);
    },
    error: function(xhr) {
        handleAjaxError(xhr);
        
    }
});
});

$('#receiveInvoiceEditButton').on('click', function() {
    

    let po_id = $('#po_id').val();
    let supplier_invoice_id = $('#id').val();
    let received_date = $('#receivedDate').val();
    var url = "{{ route('receive_inventory_details_update', ':id') }}".replace(':id', supplier_invoice_id);
    var type = "POST";
    
    $.ajax({
        url: url,
        type: type,
        data: {
            
            supplier_invoice_id: supplier_invoice_id,
            received_date: received_date
        },
        dataType: 'json',
        success: function(response) {
            var id = response.id;
            window.location.href = "{{ route('supplier_invoice.supplier_invoice_packing', ':id') }}".replace(':id', id);
        },
        error: function(xhr) {
            handleAjaxError(xhr);
            
        }
    });
    });
    
    $('#unreceiveInvoiceButton').on('click', function() {
    

    let po_id = $('#po_id').val();
    let supplier_invoice_id = $('#id').val();
    let received_date = $('#receivedDate').val();
    var url = "{{ route('unreceive_inventory_details', ':id') }}".replace(':id', supplier_invoice_id);
    var type = "POST";
    
    $.ajax({
        url: url,
        type: type,
        data: {
            
            supplier_invoice_id: supplier_invoice_id,
            received_date: received_date
        },
        dataType: 'json',
        success: function(response) {
            var id = response.id;
            window.location.href = "{{ route('supplier_invoice.supplier_invoice_packing', ':id') }}".replace(':id', id);
        },
        error: function(xhr) {
            handleAjaxError(xhr);
            
        }
    });
    });


</script>