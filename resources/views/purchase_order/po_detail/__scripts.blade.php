<script type="text/javascript">
$(function() {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    

    $('#product_id').select2({
            placeholder: 'Select Product',
            dropdownParent: $('#product_id').parent()
    });


    $(document).ready(function() {

        $('#product_data_update').hide();
        $('#product_data').hide();
        $('#product_id').change(function() {

            var productId = $(this).val();
            var productName = $(this).find('option:selected').text();;

            if (productId) {
                $('#product_id_hid').val(productId)
                $('#product_name').val(productName).prop('disabled', true);
                $('#product_data').show();
                $('#product_data_update').hide();

            } else {

                $('#product_data').hide();
                $('#product_data_update').hide();
            }
        });
        
    });
   

    $('.canceldata').click(function(event) {
    event.preventDefault();
    $('#product_data input[type="text"]').val('');
    $('#product_data').hide();
    $('#product_id').select2({
        allowClear: true,
    });

    const defaultProductId = "";
    $('#product_id').val(defaultProductId).trigger('change');
});


    $('#savedataProduct').on('click', function(e) {
        e.preventDefault();
       
        var po_id = $('#po_id').val();

        $.ajax({
            url: '{{ route("purchase_orders.po_product_save") }}',
            type: 'POST',
            data: $('#poProductForm').serialize(),
            success: function(response) {
                if (response.status === 'success') {
                    showToast('success', response.msg);
                    $('#poProductForm')[0].reset();

                    const newRow = `
                <tr>
                    <td>${response.product.so || ''}</td>
                    <td>${response.product.product_name || ''}</td>
                    <td>${response.product.description || ''}</td>
                    <td class="quantity">${response.product.quantity || ''}</td>
                    <td class="unit_price">${response.product.unit_price || ''}</td>
                    <td class="extended">${(response.product.quantity && response.product.unit_price) ? (response.product.quantity * response.product.unit_price).toFixed(2) : 'empty'}</td>
                      <td>
                        <button class="btn btn-warning btn-sm edit-btn-po" data-id="${response.product.id}">Edit</button>
                        <button class="btn btn-danger btn-sm delete-btn" data-id="${response.product.id}">Delete</button>
                    </td>
                </tr>
                `;
                    $('#product_details_table tbody').prepend(newRow);

                    updateSubtotalAndTotal();
                } else {
                    showToast('error', response.msg);
                }
            },
            error: function(xhr) {
                console.error(xhr.responseText);
                showToast('error', 'An error occurred while saving the product.');
            }
        });


        function updateSubtotalAndTotal() {
            let subtotal = 0;
            let total = 0;

            $('#product_details_table tbody tr').each(function() {
                const quantity = parseFloat($(this).find('.quantity').text()) || 0;
                const unit_price = parseFloat($(this).find('.unit_price').text()) || 0;
                const extended = quantity * unit_price;
                $(this).find('.extended').text(extended.toFixed(2));

                subtotal += extended;
            });

            $('#subtotal').text(subtotal.toFixed(2));
            $('#total').text(subtotal.toFixed(
                2));
            $('#product_data').hide();
        }

    });

    $(document).ready(function() {

        const $quantityInput = $('#quantity');
        const $unitPriceInput = $('#unit_price');
        const $extendedInput = $('#extended');

        function updateExtendedPrice() {
            const quantity = parseFloat($quantityInput.val()) || 0;
            const unitPrice = parseFloat($unitPriceInput.val()) || 0;
            const extendedPrice = quantity * unitPrice;
            $extendedInput.val(extendedPrice.toFixed(2));
        }

        $quantityInput.on('input', updateExtendedPrice);
        $unitPriceInput.on('input', updateExtendedPrice);
        

        function calculateTotals() {
            let subtotal = 0;

            $('.extended').each(function() {
                const extendedValue = parseFloat($(this).text()) || 0;
                subtotal += extendedValue;
            });

            $('#subtotal').text(subtotal.toFixed(2));
            $('#total').text(subtotal.toFixed(2));
        }

        calculateTotals();

        $(document).on('input change', '.quantity, .unit_price', function() {
          
            const row = $(this).closest('tr');
            const quantity = parseFloat(row.find('.quantity').text()) || 0;
            const unitPrice = parseFloat(row.find('.unit_price').text()) || 0;
            const extended = quantity * unitPrice;
            row.find('.extended').text(extended.toFixed(2));
            calculateTotals();
        });



       
        const $bundlesInput = $('#bundles');
        const $slabBundlesInput = $('#slab_bundles');
        const $slabInput = $('#slab');

     n
        const $editBundlesInput = $('#edit_bundles');
        const $editSlabBundlesInput = $('#edit_slab_bundles');
        const $editSlabsInput = $('#edit_slabs');

        function updateSlabCalculations(bundlesInput, slabBundlesInput, slabOutput) {
            const bundles = parseFloat(bundlesInput.val()) || 0;
            const slabBundles = parseFloat(slabBundlesInput.val()) || 0;
            const slab = bundles * slabBundles;
            slabOutput.val(slab);
        }

        $bundlesInput.on('input', () => updateSlabCalculations($bundlesInput, $slabBundlesInput, $slabInput));
        $slabBundlesInput.on('input', () => updateSlabCalculations($bundlesInput, $slabBundlesInput, $slabInput));

        $editBundlesInput.on('input', () => updateSlabCalculations($editBundlesInput, $editSlabBundlesInput, $editSlabsInput));
        $editSlabBundlesInput.on('input', () => updateSlabCalculations($editBundlesInput, $editSlabBundlesInput, $editSlabsInput));


        $(document).on('input change', '.length, .width, .bundles, .slab_bundles', function() {
        const row = $(this).closest('tr');
        const bundles = parseFloat(row.find('.bundles').val()) || 0;
        const slabBundles = parseFloat(row.find('.slab_bundles').val()) || 0;
        const slab = bundles * slabBundles;    
        row.find('.slab').text(slab); 
        
        const length= $('#length').val();
        const width= $('#width').val();
        const bundl= $('#bundles').val();
        const slabbundle= $('#slab_bundles').val();
        const quantity_val = (bundl * slabbundle * length * width) / 144;
        const rounded_quantity_val = quantity_val.toFixed(3);
        $('#quantity').val(rounded_quantity_val) 

        const edit_length= $('#edit_length').val();
        const edit_width= $('#edit_width').val();
        const edit_bundl= $('#edit_bundles').val();
        const editslabbundle= $('#edit_slab_bundles').val();
        const editquantity_val = (edit_bundl * editslabbundle * edit_length * edit_width) / 144;
        const editrounded_quantity_val = editquantity_val.toFixed(3);
        $('#edit_quantity').val(editrounded_quantity_val) 

        
  
    });
        
    });


    $(document).ready(function () {
    const $quantityInput = $('#edit_quantity');
    const $unitPriceInput = $('#edit_unit_price');
    const $extendedInput = $('#edit_extended');

    function updateExtendedPrice() {
        const quantity = parseFloat($quantityInput.val()) || 0;
        const unitPrice = parseFloat($unitPriceInput.val()) || 0;
        const extendedPrice = quantity * unitPrice;
        $extendedInput.val(extendedPrice.toFixed(2));
    }

    
    $quantityInput.on('input', updateExtendedPrice);
    $unitPriceInput.on('input', updateExtendedPrice);

   
    function calculateTotals() {
        let subtotal = 0;

        $('.extended').each(function () {
            const extendedValue = parseFloat($(this).text()) || 0;
            subtotal += extendedValue;
        });

        $('#subtotal').text(subtotal.toFixed(2));
        $('#total').text(subtotal.toFixed(2));
    }

    calculateTotals();

    
    $(document).on('input change', '.quantity, .unit_price', function () {
        const row = $(this).closest('tr');
        const quantity = parseFloat(row.find('.quantity').text()) || 0;
        const unitPrice = parseFloat(row.find('.unit_price').text()) || 0;
        const extended = quantity * unitPrice;
        row.find('.extended').text(extended.toFixed(2));
        calculateTotals();
    });
});
    document.getElementById('saveButton').addEventListener('click', function() {

         

        var poId = $('#purchase_order_id').val();
        if (poId) {
            var url = "{{ route('po_approve_check', ':id') }}";
            url = url.replace(':id', poId);
            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                success: function(response) {

                if (response.success) {
                    $('#approval_status_note').val(response.approval_status_note);
                    window.location.href = "{{ route('purchase_orders.po_details', ':id') }}".replace(':id', poId);
                } else {
                    alert('Details not found.');
                }
            },
                    error: function(xhr, status, error) {
                        console.log('Error:', error);
                    }
                    });
                }

    });

});
$(document).on('click', '.delete-btn', function() {

    var poId = $(this).data('id');
    if (poId) {
        var url = "{{ route('deletePo', ':id') }}".replace(':id', poId);

        $.ajax({
            url: url,
            type: 'DELETE',
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    showToast('success', response.msg);
                    $(`button[data-id="${poId}"]`).closest('tr').remove();

                    updateSubtotalAndTotal();
                } else {
                    showToast('error', response.msg);
                }
            },
            error: function(xhr) {
                console.error(xhr.responseText);
                showToast('error', 'An error occurred while deleting the product.');
            }
        });
    }
});

$(document).on('click', '.edit-btn-po', function() {

    $('#product_data').hide();
        $('#product_data_update').show();
        var productId = $(this).data('id');
        var productName = $(this).data('product_name');

        if (productId) {
            var url = "{{ route('fetch_product_po_details', ':id') }}";
            url = url.replace(':id', productId);
            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                console.log(response);
                    if (response.success) {
                        $('#edit_id').val(productId);
                        $('#edit_po_id').val(response.data.po_id);
                        $('#edit_product_id_hid').val(response.data.product_id);
                        $('#edit_product_name').val(response.data.product.product_name).prop('disabled', true);
                        $('#edit_so').val(response.data.so);
                        $('#edit_description').val(response.data.description);
                        $('#edit_supplier_purchasng_note').val(response.data.supplier_purchasng_note);
                        $('#edit_length').val(response.data.length);
                        $('#edit_width').val(response.data.width);
                        $('#edit_bundles').val(response.data.bundles);
                        $('#edit_slabs').val(response.data.slab);
                        $('#edit_slab_bundles').val(response.data.slab_bundles);
                        $('#edit_unit_price').val(response.data.unit_price);
                        $('#edit_quantity').val(response.data.quantity);
                        $('#edit_extended').val(response.data.extended);
                        if (response.data && typeof response.data.purchased_as !== 'undefined') {
                            const checkbox = document.getElementById('edit_purchase_as');
                            checkbox.checked = response.data.purchased_as == 1; 
                        } else {
                            console.error('purchased_as property is missing or undefined in response.data');
                        }
                                        } else {
                                            alert('Product details not found.');
                                        }
                                    },
                                    error: function(xhr, status, error) {
                                        console.log('Error:', error);
                                    }
                                });
                            }
});

function updateSubtotalAndTotal() {
    let subtotal = 0;

    $('#product_details_table tbody tr').each(function() {
        const quantity = parseFloat($(this).find('.quantity').text()) || 0;
        const unitPrice = parseFloat($(this).find('.unit_price').text()) || 0;

        const extended = quantity * unitPrice;
        subtotal += extended;

        $(this).find('.extended').text(extended.toFixed(2));
    });

    $('#subtotal').text(subtotal.toFixed(2));
    const tax = parseFloat($('#tax').val()) || 0;
    const total = subtotal + tax;
    $('#total').text(total.toFixed(2));
}

$('#updatedataProduct').on('click', function(e) {
    e.preventDefault();

    var po_id = $('#po_id').val();

    $.ajax({
        url: '{{ route("purchase_orders.po_product_update") }}',
        type: 'PUT',
        data: $('#poProductFormUpdate').serialize(),
        success: function(response) {
            if (response.status === 'success') {
                showToast('success', response.msg);

                
                const row = $(`#product_details_table tbody tr button[data-id="${response.product.id}"]`).closest('tr');

                
                row.find('td:nth-child(1)').text(response.product.so || '');
                row.find('td:nth-child(2)').text(response.product.product_name || '');
                row.find('td:nth-child(3)').text(response.product.description || '');
                row.find('td:nth-child(4)').text(response.product.quantity || '');
                row.find('td:nth-child(5)').text(response.product.unit_price || '');
                row.find('td:nth-child(6)').text(
                    (response.product.quantity && response.product.unit_price) 
                        ? (response.product.quantity * response.product.unit_price).toFixed(2) 
                        : 'empty'
                );

                
                $('#poProductFormUpdate')[0].reset();
                updateSubtotalAndTotal();
            } else {
                showToast('error', response.msg);
            }
        },
        error: function(xhr) {
            console.error(xhr.responseText);
            showToast('error', 'An error occurred while saving the product.');
        }
    });

    function updateSubtotalAndTotal() {
        let subtotal = 0;
        let total = 0;

        $('#product_details_table tbody tr').each(function() {
            const quantity = parseFloat($(this).find('.quantity').text()) || 0;
            const unit_price = parseFloat($(this).find('.unit_price').text()) || 0;
            const extended = quantity * unit_price;

            $(this).find('.extended').text(extended.toFixed(2));


            subtotal += extended;
        });

        $('#subtotal').text(subtotal.toFixed(2));
        $('#total').text(subtotal.toFixed(2));
        $('#product_data_update').hide();
    }




});
</script>