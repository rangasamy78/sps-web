<script type="text/javascript">
    $(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
     

             
});
$(document).ready(function () {
    function calculateTotals() {
        let subTotal = 0;

        $('#productData tr').each(function () {
            let extendedValue = parseFloat($(this).find('td:nth-child(8)').text()) || 0;
            subTotal += extendedValue;
        });

       
        $('#OtherCharge tr').each(function () {
            let extendedValue = parseFloat($(this).find('td:nth-child(9)').text()) || 0;
            subTotal += extendedValue;
        });

        $('#subTotal').text(subTotal.toFixed(2));
        $('#total').text(subTotal.toFixed(2));
        $('#balanceDue').text(subTotal.toFixed(2));

        $('#invoiceTotal').text(subTotal.toFixed(2));
        $('#balanceDue').text(subTotal.toFixed(2));
    }

   
    let po_id = $('#po_id').val();
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

                    if (data && data.length > 0) {
                        data.forEach((item) => {
                            let row = `
                                <tr>
                                    <td>${item.product.product_name || ''}</td>
                                    <td></td>
                                    <td>${item.alt_qty || ''}</td>
                                    <td></td>
                                    <td></td>
                                    <td>${item.quantity || ''}</td>
                                    <td>${item.unit_price || ''}</td>
                                    <td>${item.extended || ''}</td>
                                    <td>0.00</td>
                                    <td></td>
                                    <td><button class="btn btn-danger btn-sm">Delete</button></td>
                                </tr>`;
                            tbody.append(row);
                        });
                    } else {
                        tbody.append(`<tr><td colspan="11" class="text-center">No data found.</td></tr>`);
                    }

                    calculateTotals();
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
        let url = "{{ route('fetch_other_details', ':id') }}".replace(':id', po_id);

        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    let data = response.data;
                    let tbody = $('#OtherCharge');
                    tbody.empty();

                    if (data && data.length > 0) {
                        data.forEach((item) => {
                            let row = `
                                <tr>
                                    <td>${item.service.service_name || ''}</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>${item.extended || ''}</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>`;
                            tbody.append(row);
                        });
                    } else {
                        tbody.append(`<tr><td colspan="13" class="text-center">No data found.</td></tr>`);
                    }

                    calculateTotals();
                } else {
                    alert('Other charge details not found.');
                }
            },
            error: function (xhr, status, error) {
                console.error('Error fetching other charge details:', error);
            }
        });
    }
});






</script>