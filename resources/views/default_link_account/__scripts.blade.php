<script type="text/javascript">
        $(function () {

                $.ajaxSetup({
                        headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                });

                $('#retained_earning_id').select2({
                        placeholder: 'Select Retained Earnings',
                        dropdownParent: $('#retained_earning_id').parent()
                });

                $('#supplier_payment_cash_account_id').select2({
                        placeholder: 'Select Retained Earnings',
                        dropdownParent: $('#supplier_payment_cash_account_id').parent()
                });

                $('#vendor_payment_cash_account_id').select2({
                        placeholder: 'Vendor Payment - Cash Account',
                        dropdownParent: $('#vendor_payment_cash_account_id').parent()
                });

                $('#customer_payment_cash_account_id').select2({
                        placeholder: 'Customer Payment - Cash Account',
                        dropdownParent: $('#customer_payment_cash_account_id').parent()
                });

                $('#miscellaneous_expense_id').select2({
                        placeholder: 'Miscellaneous Expense',
                        dropdownParent: $('#miscellaneous_expense_id').parent()
                });

                $('#receipt_cash_account_id').select2({
                        placeholder: 'Select Account for New Products',
                        dropdownParent: $('#receipt_cash_account_id').parent()
                });

                $('#miscellaneous_income_id').select2({
                        placeholder: 'Select Miscellaneous Income',
                        dropdownParent: $('#miscellaneous_income_id').parent()
                });

                $('#positive_adjustment_id').select2({
                        placeholder: 'Select Positive Adjustments',
                        dropdownParent: $('#positive_adjustment_id').parent()
                });

                $('#inventory_write_off_id').select2({
                        placeholder: 'Select Inventory Write Offs',
                        dropdownParent: $('#inventory_write_off_id').parent()
                });

                $('#reclassify_renumbering_split_id').select2({
                        placeholder: 'Select Reclassify/Renumbering/Split',
                        dropdownParent: $('#reclassify_renumbering_split_id').parent()
                });

                $('#revaluation_adjustment_id').select2({
                        placeholder: 'Select Revaluation Adjustments',
                        dropdownParent: $('#revaluation_adjustment_id').parent()
                });

                $('#account_for_new_product_id').select2({
                        placeholder: 'Select Account for New Products',
                        dropdownParent: $('#account_for_new_product_id').parent()
                });

                $('#inventory_in_transit_id').select2({
                        placeholder: 'Select Inventory in Transit',
                        dropdownParent: $('#inventory_in_transit_id').parent()
                });

                $('#other_charges_in_po_sipl_id').select2({
                        placeholder: 'Select Other Charges in PO & SIPL',
                        dropdownParent: $('#other_charges_in_po_sipl_id').parent()
                });

                $('#payments_discount_id').select2({
                        placeholder: 'Select Payments Discounts',
                        dropdownParent: $('#payments_discount_id').parent()
                });

                $('#restocking_fees_on_pur_return_id').select2({
                        placeholder: 'Select Restocking Fees on Pur. Returns',
                        dropdownParent: $('#restocking_fees_on_pur_return_id').parent()
                });

                $('#freight_account_on_purchase_id').select2({
                        placeholder: 'Select Freight Account on Purchases',
                        dropdownParent: $('#freight_account_on_purchase_id').parent()
                });

                $('#supplier_invoice_variance_id').select2({
                        placeholder: 'Supplier Invoice Variance',
                        dropdownParent: $('#supplier_invoice_variance_id').parent()
                });

                $('#supp_credit_memos_variance_id').select2({
                        placeholder: 'Select Supp. Credit Memos Variance',
                        dropdownParent: $('#supp_credit_memos_variance_id').parent()
                });

                $('#customer_ar_id').select2({
                        placeholder: 'Select Customer - AR',
                        dropdownParent: $('#customer_ar_id').parent()
                });

                $('#sales_income_product_id').select2({
                        placeholder: 'Select Sales Income - Product',
                        dropdownParent: $('#sales_income_product_id').parent()
                });

                $('#sales_income_service_id').select2({
                        placeholder: 'Select Sales Income - Service',
                        dropdownParent: $('#sales_income_service_id').parent()
                });

                $('#cogs_account_id').select2({
                        placeholder: 'Select COGS Account',
                        dropdownParent: $('#cogs_account_id').parent()
                });
                $('#restocking_fee_income_account_id').select2({
                        placeholder: 'Select Restocking Fee Income Account',
                        dropdownParent: $('#restocking_fee_income_account_id').parent()
                });

                $('#sales_tax_liability_account_id').select2({
                        placeholder: 'Select Sales Tax liability Account',
                        dropdownParent: $('#sales_tax_liability_account_id').parent()
                });

                $('#sales_discount_id').select2({
                        placeholder: 'Select Sales Discounts',
                        dropdownParent: $('#sales_discount_id').parent()
                });

                // General function to handle form change events
                function handleFormChange() {
                        $('select').on('change', function (e) {
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
                                        success: function (response) {
                                                if (response.status === "success") {
                                                        showToast('success', response.msg);
                                                }
                                        },
                                        error: function (xhr) {
                                                handleAjaxError(xhr);
                                        }
                                });
                        });
                }

                // Function to determine the route based on form ID
                function getRouteForForm(formId) {
                        switch (formId) {
                                case 'inventoryAssetForm':
                                        return '{{ route( 'default_link_accounts.inventory_asset.save' ) }}';
                                case 'inventoryInTransitOnTransferForm':
                                        return '{{ route( 'default_link_accounts.inventory_in_transit_on_transfer.save' ) }}';
                                case 'inventoryAdjustmentAccountForm':
                                        return '{{ route( 'default_link_accounts.inventory_adjustment.save' ) }}';
                                case 'bankingPaymentForm':
                                        return '{{ route( 'default_link_accounts.banking_payment.save' ) }}';
                                case 'otherChargeAccountForm':
                                        return '{{ route( 'default_link_accounts.other_charges_discounts_variance.save' ) }}';
                                case 'saleAccountForm':
                                        return '{{ route( 'default_link_accounts.sale.save' ) }}';
                                case 'accountingForm':
                                        return '{{ route( 'default_link_accounts.accounting.save' ) }}';
                                case 'bankingReceiptForm':
                                        return '{{ route( 'default_link_accounts.banking_receipt.save' ) }}';
                                default:
                                        console.warn('No route found for form ID:', formId);
                                        return '';
                        }
                }
                // Call the function to set up event handlers
                handleFormChange();
                // Function to check if a value is empty
                function isEmpty(value) {
                        return $.trim(value) === '';
                }
        });
</script>