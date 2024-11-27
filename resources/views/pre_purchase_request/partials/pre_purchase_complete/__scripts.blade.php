<script type="text/javascript">
    $(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#saveCompletedData').click(function(e) {
            e.preventDefault();
            var prePurchaseRequestId = $("#pre_purchase_request_id").val();
            var supplierRequestId = $("#supplier_request_id").val();
            var button = $(this);
            sending(button);
            var url = "{{ route('pre_purchase_complete.store') }}";
            var type =  "POST";
            var formData = $('#prePurchaseCompleteForm').serializeArray();
            var serializedData = $.param(formData);
            $.ajax({
                url: url,
                type: type,
                data: serializedData,
                dataType: 'json',
                success: function(response) {
                    if (response.status === "success") {
                        showToast('success', response.msg);
                        let redirectedUrl = "{{ route('pre_purchase_requests.show', [':id']) }}"
                                .replace(':id', prePurchaseRequestId);
                        window.location.href = redirectedUrl;
                    }
                },
                error: function(xhr) {
                    handleAjaxError(xhr);
                    sending(button, true);
                }
            });
        });

        $('#product_id').on('change', function () {
            var productUrl = "{{ route('get_pre_purchase_request_product_details') }}";
            var productId = $(this).val();
            $.ajax({
                url: productUrl,
                method: 'GET',
                data: {
                    id: productId
                },
                success: function(response) {
                    if (response.status === 'success') {
                        setProductPrimaryFields(response.data);
                    } else {
                        setProductPrimaryFields({});
                    }
                },
                error: function() {
                    setProductPrimaryFields({});
                    Swal.fire('Error', 'Failed to fetch supplier address','error');
                }
            });
        });

        function setProductPrimaryFields(data) {
            $('#product_sku').val(data.product_sku || '');
            $('#length').val(data.length || '');
            $('#width').val(data.width || '');
            $('#avg_est_cost').val(data.avg_est_cost || '');
            if(data.purchasing_unit_id){
                $("#pur_uom").show();
                $('#pur_uom_id').val(data.purchasing_unit_id || '').trigger('change');
            }else {
                $("#pur_uom").hide();
            }

        }

        $('.unitPrice').on('change', function() {
            var id = $(this).data('id');
            var qty = parseFloat($('#response_qty_' + id).val()) || 0;
            var unitPrice = parseFloat($(this).val()) || 0;
            var total = qty * unitPrice;
            $('#total_price_' + id).val(total.toFixed(2));
        });

        $('.checkItem').click(function() {
            let id = $(this).data('id');
            $('#generic_name_' + id + ',#generic_sku_' + id + ',#unit_price_' + id + ', #requested_product_' + id + ', #response_qty_' + id + ', #total_price_' + id + ', #comments_' + id)
            .prop('disabled', !$(this).is(':checked'));
        });

        function validateCheckboxes() {
            if ($('.checkItem:checked').length === 0) {
                alert('Please select at least one checkbox.');
                return false;
            }
            return true;
        }

        document.getElementById('checkAll').onclick = function() {
            let checkboxes = document.querySelectorAll('.checkItem');
            for (let checkbox of checkboxes) {
                checkbox.checked = this.checked;
            }
        };

        $('#response_shipment_term_id').on('change', function() {
            var selectedText = $(this).select2('data')[0].text;
            $('#prePurchaseResponseForm #response_shipment_terms').val(selectedText);
        });

        $('#response_shipment_term_id').select2({
            placeholder: 'Select Shipment Term',
            dropdownParent: $('#response_shipment_term_id').parent()
        });

    });
</script>
