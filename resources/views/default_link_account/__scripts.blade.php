<script type="text/javascript">
    $(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function() {
            // General function to handle form change events
            function handleFormChange() {
                $('select').on('change', function(e) {
                    e.preventDefault();
                    var form = $(this).closest('form');
                    var formId = form.attr('id');
                    var route = getRouteForForm(formId);
                    if (isEmpty($(this).val())) {
                        return false;
                    }
                    var formData = form.serialize();
                    $.ajax({
                        url: route,
                        type: "POST",
                        data: formData,
                        dataType: 'json',
                        success: function(response) {
                            if (response.status === "success") {
                                var successMessage = response.msg ?? '';
                                var successTitle = 'Saved!';
                                showSuccessMessage(successTitle, successMessage);
                            }
                        },
                        error: function(xhr) {
                            handleAjaxError(xhr);
                        }
                    });
                });
            }

            // Function to determine the route based on form ID
            function getRouteForForm(formId) {
                switch (formId) {
                    case 'inventoryAssetForm':
                        return '{{ route('default_link_accounts.inventory_asset.save') }}';
                    case 'inventoryInTransitOnTransferForm':
                        return '{{ route('default_link_accounts.inventory_in_transit_on_transfer.save') }}';
                    case 'inventoryAdjustmentAccountForm':
                        return '{{ route('default_link_accounts.inventory_adjustment.save') }}';
                    case 'bankingPaymentForm':
                        return '{{ route('default_link_accounts.banking_payment.save') }}';
                    case 'otherChargeAccountForm':
                        return '{{ route('default_link_accounts.other_charges_discounts_variance.save') }}';
                    case 'saleAccountForm':
                        return '{{ route('default_link_accounts.sale.save') }}';
                    case 'accountingForm':
                        return '{{ route('default_link_accounts.accounting.save') }}';
                    case 'bankingReceiptForm':
                        return '{{ route('default_link_accounts.banking_receipt.save') }}';
                    default:
                        console.warn('No route found for form ID:', formId);
                        return '';
                }
            }
            // Call the function to set up event handlers
            handleFormChange();
        });

        // Function to check if a value is empty
        function isEmpty(value) {
            return $.trim(value) === '';
        }

        setTimeout(() => {
            $('.dataTables_filter .form-control').removeClass('form-control-sm').css('margin-right', '20px');
            $('.dataTables_length .form-select').removeClass('form-select-sm').css('padding-left', '30px');
        }, 300);
    });
</script>
