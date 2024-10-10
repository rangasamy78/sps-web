<script type="text/javascript">
    $(function() {


        $(document).ready(function() {
    // Update the table when a filter changes
    $('#productNameFilter, #productKindFilter, #productTypeFilter, #productCategoryFilter, #productGroupFilter, #productOriginFilter, #priceRangeFilter, #productUomFilter, #productColorFilter').on('change', function() {

        // Collect filter values
        var filters = {
            product_name: $('#productNameFilter').val(),
            product_kind: $('#productKindFilter').val(),
            product_type: $('#productTypeFilter').val(),
            product_category: $('#productCategoryFilter').val(),
            product_group: $('#productGroupFilter').val(),
            product_origin: $('#productOriginFilter').val(),
            price_range: $('#priceRangeFilter').val(),
            product_uom: $('#productUomFilter').val(),
            product_color: $('#productColorFilter').val()
        };

        $.ajax({
            url: "{{ route('products.search_list') }}", // Correct route URL from Blade
            type: 'GET',
            data: filters,
            success: function(response) {
                // Replace the table body with the new data
                $('#searchProductdatatable tbody').html(response);
            },
            error: function(xhr, status, error) {
                console.log('AJAX Error: ' + status + ' - ' + error);
            }
        });
    });
});



$('#productNameFilter').select2({

        placeholder: 'Select Name / Alt.Name / SKU:',
        dropdownParent: $('#productNameFilter').parent()
    });
$('#productTypeFilter').select2({
        placeholder: 'Select Type / Form',
        dropdownParent: $('#productTypeFilter').parent()
    });
    $('#productKindFilter').select2({
        placeholder: 'Select Product Kind',
        dropdownParent: $('#productKindFilter').parent()
    });
    $('#productCategoryFilter').select2({
        placeholder: 'Select Product Category',
        dropdownParent: $('#productCategoryFilter').parent()
    });

    $('#productSubCategoryFilter').select2({
        placeholder:'Select Category',
        dropdownParent: $('#productSubCategoryFilter').parent()
    });

    $('#productGroupFilter').select2({
        placeholder: 'Select Group',
        dropdownParent: $('#productGroupFilter').parent()
    });
    $('#productThicknessFilter').select2({
        placeholder: 'Select Thickness',
        dropdownParent: $('#productThicknessFilter').parent()
    });

    $('#productOriginFilter').select2({
        placeholder:'Select Origin',
        dropdownParent: $('#productOriginFilter').parent()
    });

    $('#priceRangeFilter').select2({
        placeholder: 'Select Price Range',
        dropdownParent: $('#priceRangeFilter').parent()
    });
    $('#productUomFilter').select2({
        placeholder:'Select UOM',
        dropdownParent: $('#productUomFilter').parent()
    });

    $('#productColorFilter').select2({
        placeholder: 'Select Product Color',
        dropdownParent: $('#productColorFilter').parent()
    });


    });
</script>
