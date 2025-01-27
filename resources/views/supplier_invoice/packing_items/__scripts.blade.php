<script type="text/javascript">
    const unitValues = {
        'm' : 5,
        'cm': 508,
        'mm': 5080,
        'in': 200
    };
    const conversionTable = {
        'm' : 39.37,    // 1 square meter = 39.37 square feet
        'cm': 0.394,   // 1 square centimeter = 0.394 square feet
        'mm': 0.0394,  // 1 square millimeter = 0.0394 square feet
        'in': 1        // 1 square inch = 1 square feet
    };

    $(document).ready(function () {
        const $listGroupItem = $('.list-group-item');
        const $addBtnProduct = $(".add-btn");
        const $incrementBtn = $('.incrementBtn');
        const $decrementBtn = $('.decrementBtn');
        const $cancel = $('.cancel');
        const $unitPackLength = $('.unit_pack_length');
        const $unitPackWidth = $('.unit_pack_width');
        const $packLength = $('.pack_length');
        const $packWidth = $('.pack_width');

        $unitPackLength.on('change blur', function (e) {
            e.preventDefault();
            handlePkgValidation($(this), 'Length', getEndValue, convertToSquareFeet);
        });

        $unitPackWidth.on('change blur', function (e) {
            e.preventDefault();
            handlePkgValidation($(this), 'Width', getEndValue, convertToSquareFeet);
        });

        $packLength.on('change blur', function (e) {
            e.preventDefault();
            handleSubPkgValidation($(this), 'Length', getEndValue);
        });

        $packWidth.on('change blur', function (e) {
            e.preventDefault();
            handleSubPkgValidation($(this), 'Width', getEndValue);
        });

        $(document).on('click', '.cancel_slab', function(e) {
            e.preventDefault();
            window.location.reload();
        });

        $listGroupItem.on('click', function(e) {
            e.preventDefault();
            const userDetailId = $(this).find('.list-item').data('user');
            const row = $(this).find('.list-item').data('column');
            const rowId = $(this).find('.list-item').data('row');
            (row === 1) ? $('#' + userDetailId).hide(): $('#' + userDetailId).show();
            clearFields(rowId)
            $listGroupItem.removeClass('active');
            const unitType = $(this).find('.list-item').data('unit');
            $(`#unit_type_name_${rowId}`).val(unitType);
            $(this).addClass('active');
        });

        $addBtnProduct.on('click', function (e) {
            e.preventDefault();
            var row = $(this).data('row');
            const userDetailId = $(this).data('user');
            $(`#${userDetailId}`).toggle();
            $(".list-group-item").removeClass('active');
            $(`#group_${row}`).find('.list-group-item:first').addClass('active');
            const productIds = @json($products);
            fetchProducts(productIds);
            setTimeout(() => {
                $(`#block_${row}, #bundle_${row}, #supplier_ref_${row}`).val('');
                console.log(`Cleared fields for row ${row}`);
            }, 600);
        });

        const handleButtonClick = (isIncrement, $btn) => {
            const row = $btn.data('row');
            updateValue(isIncrement, $btn.data('target'));
            const getValue = id => Number($(`#${id}_${row}`).val()) || 0;
            const altQty = getValue('alt_qty');
            const totalQty = getValue('billed_total') + getValue('count');
            $(`#slabBtn_${row}`).prop('disabled', altQty < totalQty);
            if (altQty < totalQty) {
                $('#altQtyModel').modal('show');
                appendToModalTable(row, altQty, totalQty);
            }
        };

        $incrementBtn.on('click', function (e) {
            e.preventDefault();
            handleButtonClick(true, $(this));
        });

        $decrementBtn.on('click', function (e) {
            e.preventDefault();
            handleButtonClick(false, $(this));
        });

        $cancel.on('click', function (e) {
            e.preventDefault();
            $(`#${$(this).data('target')}`).hide();
            $(".list-group-item").removeClass('active');
        });

        $(document).on('change', '.allowMaxQty', ({ target }) => $(`#slabBtn_${$(target).data('row')}`).prop('disabled', !$(target).prop('checked')));

        const appendToModalTable = (row, altQty, totalQty) => {
            const $firstRow = $('<tr>');
            const $billedQtyTd = $('<td>').html(`<span class="BilledQty">${altQty}</span> Slabs`);
            const $recQtyTd = $('<td>').css('color', 'red').html(`<span id="RecQty">${totalQty}</span> Slabs`);
            $firstRow.append($billedQtyTd, $recQtyTd);
            const $secondRow = $('<tr>');
            const $checkboxTd = $('<td>', { colspan: 2 }).html(`
                <input type="checkbox" class="allowMaxQty" data-row="${row}" id="allowMaxQty_${row}"
                style="vertical-align: sub;width: 17px; height: 17px;">
                Check this box if you want to proceed with the above discrepancy?
            `);
            $secondRow.append($checkboxTd);
            $('#altQtyModel table tbody').empty().append($firstRow, $secondRow);
        };

        const handlePkgValidation = ($input, dimensionType, getEndValue, convertToSquareFeet) => {
            const rowId = $input.data('row');
            const activeUnit = $(`#group_${rowId}`).find('.list-group-item.active a').data('unit');
            const curValue = parseFloat($input.val()) || 0;
            const endValue = getEndValue(activeUnit);

            $input.siblings('.error-message').remove();

            if (!activeUnit || curValue > endValue || !curValue || isNaN(curValue)) {
                const message = !activeUnit
                    ? `Pls select the unit.`
                    : curValue > endValue
                    ? `Pls enter a valid ${dimensionType}.`
                    : `Pls enter a Pkg ${dimensionType}.`;

                $input.after(`<span class="error-message" style="color: red; font-size: 12px;">${message}</span>`);
                $(`#pack_${dimensionType.toLowerCase()}_${rowId}, #rec_${dimensionType.toLowerCase()}_${rowId}`).val('');
                return;
            }

            const finalValue = activeUnit !== 'in' ? convertToSquareFeet(curValue, activeUnit) : curValue;
            $(`#pack_${dimensionType.toLowerCase()}_${rowId}, #rec_${dimensionType.toLowerCase()}_${rowId}`).val(finalValue.toFixed(2));
        };

        const handleSubPkgValidation = ( $input, dimensionType, getEndValue ) => {
            const rowId = $input.data('row');
            const activeUnit = $(`#group_${rowId}`).find('.list-group-item.active a').data('unit');
            const curValue = parseFloat($input.val()) || 0;
            const endValue = getEndValue('in');

            $input.siblings('.error-message').remove();

            if (!activeUnit || curValue > endValue || !curValue || isNaN(curValue)) {
                const message = !activeUnit
                    ? `Pls select the unit.`
                    : curValue > endValue
                    ? `Pls enter valid ${dimensionType}.`
                    : `Pls enter a Pkg ${dimensionType}.`;

                $input.after(`<span class="error-message" style="color: red; font-size: 12px;">${message}</span>`);
                $(`#rec_${dimensionType.toLowerCase()}_${rowId}`).val('');
                return;
            }

            $(`#rec_${dimensionType.toLowerCase()}_${rowId}`).val(curValue);
        };

        const updateValue = (isIncrement, targetId) => {
            const $input = $(`#${targetId}`);
            let currentValue = parseInt($input.val()) || 1;
            if (!isIncrement && currentValue <= 1) { return false }
            $input.val(isIncrement ? currentValue + 1 : Math.max(0, currentValue - 1));
        };

        const convertToSquareFeet = (value, unit) => {
            const conversionFactor = conversionTable[unit];
            if (!conversionFactor) {
                throw new Error(`Conversion factor for unit '${unit}' not found.`);
            }
            return value * conversionFactor;
        };

        const getEndValue = (unit) => unitValues[unit] || unitValues['in'];

        $('body').on('click', '.proDelBtn', function() {
            var id = $(this).data('id');
            confirmDelete(id, function() {
                deleteSupplierInvoiceProduct(id);
            });
        });

        function deleteSupplierInvoiceProduct(id) {
            var url = "{{ route('supplier_invoice_packing_items.destroy', ':id') }}".replace(':id', id);
            $.ajax({
                url: url,
                type: "DELETE",
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.status === "success") {
                        showToast('success', response.msg);
                        window.location.reload();
                    } else {
                        showError('Deleted!', response.msg);
                    }
                },
                error: function(xhr) {
                    console.error('Error:', xhr.statusText);
                    showError('Oops!', 'Failed to fetch data.');
                }
            });
        }

        $('.slabBtn').on('click', function (e) {
            e.preventDefault();
            var row = $(this).data('row');
            const getValue = id => Number($(`#${id}_${row}`).val()) || 0;
            const altQty = getValue('alt_qty');
            const totalQty = getValue('billed_total') + getValue('count');
            $(`#slabBtn_${row}`).prop('disabled', altQty < totalQty);
            if (altQty < totalQty) {
                $('#altQtyModel').modal('show');
                appendToModalTable(row, altQty, totalQty);
                return false;
            }
            var url = "{{ route('supplier_invoice_packing_items.store') }}";
            var type = "POST";
            var formData = $("#supplier_invoice_product_"+ row).serializeArray();
            var serializedData = $.param(formData);
            $.ajax({
                url: url,
                type: "POST",
                data: serializedData,
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    if (response.status === "success") {
                        $(`#main_group_${row}`).hide();
                        $(".list-group-item").removeClass('active');
                        showToast('success', response.msg);
                        updateBarcodeTable(response.data, response.product_id, response.max_serial_no, response.max_lot_block, response.max_bundle, response.max_supplier_ref, row);
                    } else {
                        showNoBarcodesMessage();
                    }
                },
                error: function(xhr) {
                    handleAjaxError(xhr);
                }
            });
        });

        const updateBarcodeTable = (barcodes, productId, maxSerialNo, maxLotBlock, maxBundle, maxSupplierRef, rowId) => {
            $(`#product_item_${productId} tbody`).empty();
            let totalSlabs = 0, totalPackingSize = 0, totalReceivedSize = 0;
            barcodes.forEach((barcode, index) => {
                const row = createBarcodeRow(index + 1, barcode);
                $(`#product_item_${productId} tbody`).append(row);
                totalSlabs++;
                totalPackingSize += extractSquareFeet(barcode.packing_list_sizes);
                totalReceivedSize += extractSquareFeet(barcode.received_sizes);
            });
            const footerRow = createFooterRow(totalSlabs, totalPackingSize, totalReceivedSize, rowId);
            $(`#product_item_${productId} tfoot`).html(footerRow);
            $(".serialNo, .testSerialNo").val(maxSerialNo);
            $(".maxLotBlock").val(maxLotBlock);
            $(".maxBundle").val(maxBundle);
            $(".maxSupplierRef").val(maxSupplierRef);
        };

        const createBarcodeRow = (index, barcode) => {
            return `
                <tr>
                    <td  style="font-size: 12px;text-align: left;">${barcode.seq_no}</td>
                    <td  style="font-size: 12px;text-align: left;">${barcode.bar_code_no}</td>
                    <td  style="font-size: 12px;text-align: left;">${barcode.lot_block}</td>
                    <td  style="font-size: 12px;text-align: left;">${barcode.bundle}</td>
                    <td  style="font-size: 12px;text-align: left;">${barcode.supplier_ref}</td>
                    <td  style="font-size: 12px;text-align: left;">${barcode.present_location}</td>
                    <td  style="font-size: 12px;text-align: left;">${barcode.packing_list_sizes}</td>
                    <td  style="font-size: 12px;text-align: left;">${barcode.received_sizes}</td>
                    <td  style="font-size: 12px;text-align: left;">
                        <a title="${barcode.notes}">
                            <img src="{{ asset('public/images/icon_exclamation.gif') }}" alt="Notes Icon" style="width: 20px; height: 20px;">
                        </a>
                    </td>
                    <td  style="font-size: 12px;text-align: left;"><a class='showbtn text-warning' href='javascript:void(0);' data-id="${barcode.id}" data-product-id="${barcode.product_id}"><img src="{{ asset('public/images/icon_window.gif') }}" alt="Associate Icon" style="width: 16px; height: auto;"></a></td>
                    <td  style="font-size: 12px;text-align: left;"></td>
                    <td  style="font-size: 12px;text-align: left;"><img src="{{ asset('public/images/intransit.png') }}" alt="Associate Icon" style="width: 26px; height: auto;"></td>
                </tr>
            `;
        };

        const createFooterRow = (totalSlabs, totalPackingSize, totalReceivedSize, rowId) => {
            return `
                <tr>
                    <td colspan="6" class="bold right" style="text-align: right;"><b>Total ${totalSlabs} Slabs</b> <input type="hidden" id="billed_total_${rowId}" data-row="${rowId}" value="${totalSlabs??0}" /></td>
                    <td class="bold right pad" style="text-align: right;"><b>${totalPackingSize.toFixed(2)} SF</b></td>
                    <td class="bold right pad" style="text-align: right;"><b>${totalReceivedSize.toFixed(2)} SF</b></td>
                    <td colspan="4"></td>
                </tr>
            `;
        };

        function showNoBarcodesMessage() {
            $('#barcodeTable tbody').html('<tr><td colspan="2">No barcodes available</td></tr>');
        }

        $('.bin_type').on('change', (e) => {
            e.preventDefault();
            var row = $(e.target).data('id');
            var binTypeName = $(`#bin_type_id_${row} option:selected`).text();
            $(`#bin_type_name_${row}`).val(binTypeName);
        });

        function extractSquareFeet(packingListSize) {
            const match = packingListSize.match(/(\d+\.\d+) SF/);
            return match ? parseFloat(match[1]) : 0;
        }

        $('[data-toggle="tooltip"]').tooltip()

        $('.edit-btn').on('click', function (e) {
            e.preventDefault();
            var row = $(this).data('row');
            $(`#main_group_${row}`).hide();
            var formId = $(this).data('form-id');
            var productId = $(this).data('product-id');
            var poId = $(this).data('id');
            var url = "{{ route('supplier_invoice_packing_items.edit', ':id') }}".replace(':id', $(this).data('id'));
            var formData = $("#supplier_invoice_product_"+ row).serializeArray();
            var serializedData = $.param(formData);
            $.ajax({
                url: url,
                type: "GET",
                data: {
                    po_id : poId,
                    product_id : productId,
                    formId : formId
                },
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    if (response.status === "success") {
                        updateTableHeader(`product_item_${formId}`, row);
                        updateTableBody(`product_item_${formId}`, response.data, row);
                        updateTableFooterBody(`product_item_${formId}`, row, formId);
                    } else {
                        showNoBarcodesMessage();
                    }
                },
                error: function(xhr) {
                    handleAjaxError(xhr);
                }
            });
        });

        function updateTableHeader(tableId, rowId) {
            const headerHtml = `
                <tr>
                    <th style="width:3%;"><input type="checkbox" id="select_all_${rowId}" data-row="${rowId}" class="selectAll"></th>
                    <th style="font-size: 14px;text-align: left;text-transform: capitalize !important;width:5%;">S.no</th>
                    <th style="font-size: 14px;text-align: left;text-transform: capitalize !important;width:15%;">Lot/Block</th>
                    <th style="font-size: 14px;text-align: left;text-transform: capitalize !important;width:13%;">Bundle</th>
                    <th style="font-size: 14px;text-align: left;text-transform: capitalize !important;width:11%;">Supp. Ref</th>
                    <th style="font-size: 14px;text-align: left;text-transform: capitalize !important;width:18%;">Packinglist Sizes</th>
                    <th style="font-size: 14px;text-align: left;text-transform: capitalize !important;width:18%;">Received Sizes</th>
                    <th style="font-size: 14px;text-align: left;text-transform: capitalize !important;width:17%;">Notes</th>
                </tr>`;
            $(`#${tableId} thead`).empty().append(headerHtml);
        }

        function updateTableBody(tableId, rows, rowId) {
            let bodyHtml;
            if (rows.length === 0) {
                bodyHtml = renderNoRecordsRow(8);
            } else {
                let i = 0;
                bodyHtml = rows.map((row, index) => `
                    <tr>
                        <td>
                            <input type="checkbox" class="row-checkbox hidden" data-product-id="${row.product_id}" data-po-id="${row.po_id}" data-row="${rowId}" id="selected_${index}" name="data[${index}][selected]" value="${row.id}">
                        </td>
                        <td>
                            <div style="display: flex; align-items: center;">
                                ${row.seq_no}
                            </div>
                        </td>
                        <td>
                            <div style="display: flex; align-items: center;">
                                <input type="text" class="form-control" id="lot_block_${rowId}_${index}" name="data[${index}][lot_block]" value="${row.lot_block}" style="width: 72%;">
                                ${generateCopyButtons(index, 'lot_block', rowId)}
                            </div>
                        </td>
                        <td>
                            <div style="display: flex; align-items: center;">
                                <input type="text" class="form-control" id="lot_bundle_${rowId}_${index}" name="data[${index}][bundle]" value="${row.bundle}" style="width: 72%;">
                                ${generateCopyButtons(index, 'lot_bundle', rowId)}
                            </div>
                        </td>
                        <td>
                            <div style="display: flex; align-items: center;">
                                <input type="text" class="form-control" id="lot_supplier_ref_${rowId}_${index}" name="data[${index}][supplier_ref]" value="${row.supplier_ref}" style="width: 72%;">
                                ${generateCopyButtons(index, 'lot_supplier_ref', rowId)}
                            </div>
                        </td>
                        <td>
                            <div style="display: flex; align-items: center;">
                                <input type="text" class="form-control" id="lot_pack_length_${rowId}_${index}" name="data[${index}][pack_length]" value="${row.pack_length}" style="width: 41%;">
                                ${generateCopyButtons(index, 'lot_pack_length', rowId)}
                                <input type="text" class="form-control" id="lot_pack_width_${rowId}_${index}" name="data[${index}][pack_width]" value="${row.pack_width}" style="width: 41%;">
                                ${generateCopyButtons(index, 'lot_pack_width', rowId)}
                            </div>
                        </td>
                        <td>
                            <div style="display: flex; align-items: center;">
                                <input type="text" class="form-control" id="lot_rec_length_${rowId}_${index}" name="data[${index}][rec_length]" value="${row.rec_length}" style="width: 41%;">
                                ${generateCopyButtons(index, 'lot_rec_length', rowId)}
                                <input type="text" class="form-control" id="lot_rec_width_${rowId}_${index}" name="data[${index}][rec_width]" value="${row.rec_width}" style="width: 41%;">
                                ${generateCopyButtons(index, 'lot_rec_width', rowId)}
                            </div>
                        </td>
                        <td>
                            <div style="display: flex; align-items: center;">
                                <input type="text" class="form-control" id="lot_notes_${rowId}_${index}" name="data[${index}][notes]" value="${row.notes}" style="width: 85%;">
                                ${generateCopyButtons(index, 'lot_notes', rowId)}
                            </div>
                            <input type="hidden" class="form-control" id="id_${index}" name="data[${index}][id]" value="${row.id}">
                            <input type="hidden" class="form-control" id="po_id_${index}" name="data[${index}][po_id]" value="${row.po_id}">
                            <input type="hidden" class="form-control" id="product_id_${index}" name="data[${index}][product_id]" value="${row.product_id}">
                        </td>
                    </tr>
                `).join('');
            }
            $(`#${tableId} tbody`).empty().append(bodyHtml);
        }

        const updateTableFooterBody = (tableId, rowId, formId) => {
            var productCount = $(`#${tableId} tbody tr`).length;
            const headerHtml = `
                <tr>
                    <td colspan="3">&nbsp;</td>
                    <td colspan="2" style="text-align:right;"><button" id="delete_slab_item_${rowId}" data-form-id="${formId}" data-row="${rowId}" class="btn btn-primary delete_slab_item" value="Delete" data-bs-toggle="tooltip" title="Delete slab info">Delete selected slab info</button></td>
                    <td style="text-align:right;"><button" id="assign_slab_item_${rowId}" data-form-id="${formId}" data-row="${rowId}" class="btn btn-primary assign_slab_item" data-bs-toggle="tooltip" title="Assign slab to item">Assign slab to item</button></td>
                    <td style="text-align:right;"><button" id="cancel_slab_${rowId}" data-id="${rowId}" data-row="${rowId}" class="btn btn-primary cancel_slab" value="Cancel" data-bs-toggle="tooltip" title="Cancel slab">Cancel</button></td>
                    <td style="text-align:right;"><button" type="submit" id="update_slab_${rowId}" data-id="${rowId}" data-row="${rowId}" class="btn btn-primary update_slab" value="Update" data-bs-toggle="tooltip" title="Update slab">Update Slab info</button>
                    <input type="hidden" id="LineCount_${rowId}" value="${productCount}"></td>
                </tr>`;
            $(`#${tableId} tfoot`).empty().append(headerHtml);
        }

        $(document).on('change', '.selectAll', function () {
            const isChecked = $(this).prop('checked');
            var row = $(this).data('row');
            $(`#supplier_invoice_update_product_${row} .row-checkbox`).prop('checked', isChecked);
        });

        $(document).on('change', '.row-checkbox', function () {
            var row = $(this).data('row');
            const allChecked = $(`#supplier_invoice_update_product_${row} .row-checkbox`).length === $(`#supplier_invoice_update_product_${row} .row-checkbox:checked`).length;
            $(`#supplier_invoice_update_product_${row}`).find(`#select_all_${row}`).prop('checked', allChecked);
        });
        $('body').on('click', '.assign_slab_item', function () {
            const formId = $(this).data('form-id');
            const row = $(this).data('row');
            const csrfToken = '{{ csrf_token() }}';
            const assignSlabUrl = "{{ route('supplier_invoice_packing_items.assign_slab_multiple') }}";
            const $rowContainer = getRowContainer(row);
            const $selectedItems = $rowContainer.find('.row-checkbox:checked');
            const selectedData = $selectedItems.map(function () {
                return {
                    selectedItemId: $(this).val(),
                    itemId: $(this).data('po-id'),
                    productId: $(this).data('product-id')
                };
            }).get();
            const selectedItemIds = selectedData.map(item => item.selectedItemId);
            const itemIds = selectedData.map(item => item.itemId);
            const productIds = selectedData.map(item => item.productId);
            const productId = productIds.length > 0 ? [...new Set(productIds)] : 0;
            const poId = itemIds.length > 0 ? [...new Set(itemIds)] : 0;
            if (poId.length > 0) {
                fetchSlabItem(productId,selectedItemIds, assignSlabUrl, csrfToken, poId);
            } else {
                showToast('error', 'Please select atleast one slab line to assign.');
            }
        });

        const appendModalBody = (response) => {
            const modalBody = $('#assignSlabItems .modal-body');
            modalBody.empty();
            if (response.data.length > 0) {
                response.data.forEach(item => {
                    const $radioDiv = $('<div>', { class: 'd-flex align-items-center gap-2' });
                    const $radioInput = $('<input>', { type: 'radio', id: `product-${item.product_id}`, name: 'product_id', value: item.product_id });
                    const $label = $('<label>', { for: `product-${item.product_id}`, class: 'form-label', style:'margin-top: 9px;'}).text(item.product_name);
                    $radioDiv.append($radioInput, $label);
                    modalBody.append($radioDiv);
                });
            } else {
                const $noItemsMessage = $('<div>', { class: 'mb-3' });
                const $message = $('<p>').text('There are no other "SLAB" items to move this inventory');
                $noItemsMessage.append($message);
                modalBody.append($noItemsMessage);
            }
        };

        const appendModalFooter = (response) => {
            const modalFooter = $('#assignSlabItems .modal-footer');
            modalFooter.empty();
            const $footerDiv = $('<div>', { class: 'mb-3' });
            const $input = $('<input>', {type: 'hidden',id: 'items',name: 'items[]',value: response.selectItems});
            const $submitButton = $('<button>', {type: 'button',class: 'btn btn-primary slabSubmit me-3','data-bs-target': '#static',id: 'slabSubmit'}).text('Submit');
            const $closeButton = $('<button>', {type: 'button',class: 'btn btn-danger','data-bs-dismiss': 'modal'}).text('Close');
            $footerDiv.append($input, $submitButton, $closeButton);
            modalFooter.append($footerDiv);
        };

        const handleResponse = (response, csrfToken, poId) => {
            if (response.status === "success") {
                appendModalBody(response);
                appendModalFooter(response);
                $('#assignSlabItems').modal('show');
            } else {
                showNoBarcodesMessage();
            }
        };

        const fetchSlabItem = (productId, selectedItemIds, assignSlabUrl, csrfToken, poId) => {
            $.ajax({
                url: assignSlabUrl,
                type: "POST",
                data: {
                    _token: csrfToken,
                    selectedItemIds: selectedItemIds,
                    po_id: poId,
                    product_id: productId,
                },
                dataType: 'json',
                success: (response) => handleResponse(response, csrfToken, poId),
                error: (xhr) => handleAjaxError(xhr),
            });
        };

        $('body').on('click', '.slabSubmit', function (event) {
            event.preventDefault();
            const csrfToken = '{{ csrf_token() }}';
            const updateSlabUrl = "{{ route('supplier_invoice_packing_items.update_slab_multiple') }}";
            let items = $("#slabForm").find("#items").val();
            let product_id = $("#slabForm").find("input[name='product_id']:checked").val();
            if (!product_id) {
                showToast('error', 'Please select at least one product.');
                return false;
            }
            $.ajax({
                url: updateSlabUrl,
                method: 'POST',
                data: { _token: csrfToken, items, product_id },
                success: function(response) {
                    showToast('success', 'Selected inventory to other item move successfully!');
                    $('#assignSlabItems').modal('hide');
                },
                error: function(error) {
                    console.error('AJAX Error:', error);
                    alert('There was an error submitting the form');
                }
            });
        });

        $('body').on('click', '.delete_slab_item', function () {
            const formId = $(this).data('form-id');
            const row = $(this).data('row');
            const csrfToken = '{{ csrf_token() }}';
            const deleteUrl = "{{ route('supplier_invoice_packing_items.delete_multiple') }}";
            const $rowContainer = getRowContainer(row);
            const $selectedItems = $rowContainer.find('.row-checkbox:checked');
            if ($selectedItems.length > 0) {
                processDeletion($selectedItems, formId, deleteUrl, csrfToken);
            } else {
                showToast('error', 'No items selected for deletion.');
            }
        });

        function processDeletion($selectedItems, formId, deleteUrl, csrfToken) {
            const itemIds = $selectedItems.map(function () {
                return $(this).val();
            }).get();

            if (confirm(`Are you sure you want to delete items?`)) {
                deleteItems(
                    deleteUrl,
                    { item_ids: itemIds, _token: csrfToken },
                    function () {
                        // $selectedItems.closest('tr').remove();
                        // const headerHtml = renderNoRecordsRow(8);
                        // $(`#product_item_${formId} tbody`).empty().append(headerHtml);
                        window.location.reload();
                        showToast('success', 'Selected items deleted successfully!');
                    },
                    function (error) {
                        console.error('Deletion failed:', error);
                    }
                );
            }
        }

        function deleteItems(url, data, onSuccess, onError) {
            $.ajax({
                url: url,
                type: "POST",
                data: data,
                success: function (response) {
                    if (response.status === "success") {
                        showToast('success', response.msg);
                        onSuccess(response);
                    } else {
                        showError('Deleted!', response.msg);
                    }
                },
                error: function (xhr) {
                    console.error('Error:', xhr.statusText);
                    showError('Oops!', 'Failed to fetch data.');
                    if (onError) onError(xhr);
                }
            });
        }

        function getRowContainer(row) {
            return $(`#supplier_invoice_update_product_${row}`);
        }

        function renderNoRecordsRow(colspan, message = "No records found") {
            return `<tr>
                <td colspan="${colspan}" class="text-center text-muted">${message}</td>
            </tr>`;
        }

        $('body').on('click', '.update_slab', function (e) {
            e.preventDefault();
            const id = $(this).data('id');
            const csrfToken = '{{ csrf_token() }}';
            var selectedData = [];
            $(`#supplier_invoice_update_product_${id}`).find('.row-checkbox:checked').each(function() {
                var $row = $(this).closest('tr');
                var rowIndex = $row.index();
                var rowData = {
                    seq_no: $row.find(`input[name="data[${rowIndex}][seq_no]"]`).val(),
                    lot_block: $row.find(`input[name="data[${rowIndex}][lot_block]"]`).val(),
                    bundle: $row.find(`input[name="data[${rowIndex}][bundle]"]`).val(),
                    supplier_ref: $row.find(`input[name="data[${rowIndex}][supplier_ref]"]`).val(),
                    pack_length: $row.find(`input[name="data[${rowIndex}][pack_length]"]`).val(),
                    pack_width: $row.find(`input[name="data[${rowIndex}][pack_width]"]`).val(),
                    rec_length: $row.find(`input[name="data[${rowIndex}][rec_length]"]`).val(),
                    rec_width: $row.find(`input[name="data[${rowIndex}][rec_width]"]`).val(),
                    notes: $row.find(`input[name="data[${rowIndex}][notes]"]`).val(),
                    id: $row.find(`input[name="data[${rowIndex}][id]"]`).val(),
                    product_id: $row.find(`input[name="data[${rowIndex}][product_id]"]`).val(),
                    po_id: $row.find(`input[name="data[${rowIndex}][po_id]"]`).val(),
                    row_id: id,
                };
                selectedData.push(rowData);  // Add row data to the selectedData array
            });

            if (selectedData.length > 0) {
                var url = "{{ route('supplier_invoice_packing_items.update_multiple') }}";
                $.ajax({
                    url: url,
                    type: "POST",
                    data: {
                        selectedData : selectedData,
                        _token: csrfToken
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === "success") {
                            showToast('success', response.msg);
                            window.location.reload();
                        } else {
                            showNoBarcodesMessage();
                        }
                    },
                    error: function(xhr) {
                        handleAjaxError(xhr);
                    }
                });
            } else {
                showToast('error', "Please select more than one row to update.");
            }
        });

        $('body').on('click', '.showbtn', function() {
            const id = $(this).data('id');
            const productId = $(this).data('product-id');
            $.get("{{ route('supplier_invoice_packing_items.index') }}" + '/' + id, function(response) {
                data = response.data;
                let packingListSizes = data.packing_list_sizes || '';
                packingListSizes = packingListSizes.replace(/\s+/g, ' ').trim();

                if (packingListSizes.includes('=')) {
                    let parts = packingListSizes.split('=');
                    var beforeEqual = parts[0].trim();
                    var afterEqual = parts[1].trim();
                }
                $('#showSupplierInvoicePackingItemModal').modal('show');
                $('#showSupplierInvoicePackingItemForm #seq_no').html(data.seq_no ?? '');
                $('#showSupplierInvoicePackingItemForm #material').html(data.product?.product_name ?? '');
                $('#showSupplierInvoicePackingItemForm #location').html(data.present_location ?? '');
                $('#showSupplierInvoicePackingItemForm #supplier').html(data.product?.supplier?.supplier_name ?? '');
                $('#showSupplierInvoicePackingItemForm #type').html(data.product?.product_type?.product_type ?? '');
                $('#showSupplierInvoicePackingItemForm #category').html(
                    (data.product?.product_category?.product_category_name ?? '') +
                    '-' +
                    (data.product?.product_sub_category?.product_sub_category_name ?? '')
                );
                $('#showSupplierInvoicePackingItemForm #group').html(data.product?.product_group?.product_group_name ?? '');
                $('#showSupplierInvoicePackingItemForm #bar_code_no').html(data.bar_code_no ?? '');
                $('#showSupplierInvoicePackingItemForm #bc_num').html(data.bc_num ?? '');
                $('#showSupplierInvoicePackingItemForm #lot_block').html(data.lot_block ?? '');
                $('#showSupplierInvoicePackingItemForm #bundle').html(data.bundle ?? '');
                $('#showSupplierInvoicePackingItemForm #supplier_ref').html(data.supplier_ref ?? '');
                $('#showSupplierInvoicePackingItemForm #notes').val(data.notes ?? '');
                $('#showSupplierInvoicePackingItemForm #id').val(data.id ?? '');
                $('#showSupplierInvoicePackingItemForm #packingTableBody').empty();
                $('#showSupplierInvoicePackingItemForm #packingTableBody').append(`
                    <tr>
                        <td>Packing List</td>
                        <td>${beforeEqual??''}</td>
                        <td>${afterEqual??''}</td>
                        <td>$ ${response.unit_price}</td>
                        <td>$ ${ (parseFloat(afterEqual) * parseFloat(response.unit_price)).toFixed(2) } FOB Cost</td>
                    </tr>
                    <tr>
                        <td>Received</td>
                        <td>${beforeEqual??''}</td>
                        <td>${afterEqual??''}</td>
                        <td>$ 0.00</td>
                        <td>$ 0.00 Landed Cost</td>
                    </tr>
                    <tr>
                        <td>Current</td>
                        <td>${beforeEqual??''}</td>
                        <td>${afterEqual??''}</td>
                        <td>$ 0.00</td>
                        <td>$ 0.00 Current</td>
                    </tr>

                `);
                console.log('product', data.product.product_price);
                $('#showSupplierInvoicePackingItemForm #productsTableBody').empty();
                $('#showSupplierInvoicePackingItemForm #productsTableBody').append(`
                    <tr>
                        <td>Packing List</td>
                        <td>$ ${parseFloat(data.product.product_price?.homeowner_price ?? 0).toFixed(2)}</td>
                        <td>$ ${parseFloat(data.product.product_price?.bundle_price ?? 0).toFixed(2)}</td>
                        <td>$ ${parseFloat(data.product.product_price?.special_price ?? 0).toFixed(2)}</td>
                        <td>$ ${parseFloat(data.product.product_price?.loose_slab_price ?? 0).toFixed(2)}</td>
                        <td>$ ${parseFloat(data.product.product_price?.bundle_price_sqft ?? 0).toFixed(2)}</td>
                        <td>$ ${parseFloat(data.product.product_price?.special_price_per_sqft ?? 0).toFixed(2)}</td>
                        <td>$ ${parseFloat(data.product.product_price?.owner_approval_price ?? 0).toFixed(2)}</td>
                        <td>$ ${parseFloat(data.product.product_price?.loose_slab_per_slab ?? 0).toFixed(2)}</td>
                        <td>$ ${parseFloat(data.product.product_price?.bundle_price_per_slab ?? 0).toFixed(2)}</td>
                        <td>$ ${parseFloat(data.product.product_price?.special_price_per_slab ?? 0).toFixed(2)}</td>
                        <td>$ ${parseFloat(data.product.product_price?.owner_approval_price_per_slab ?? 0).toFixed(2)}</td>
                        <td>$ ${parseFloat(data.product.product_price?.price12 ?? 0).toFixed(2)}</td>
                    </tr>
                `);

            });
        });

        function fetchProducts(productIds) {
            var url = "{{ route('supplier_invoice_packing_items.fetch_products_all') }}";
            $.ajax({
                url: url,
                type: "GET",
                data: {
                    _token: '{{ csrf_token() }}',
                    products: productIds
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status === "success") {
                        response.data.forEach(function(product, index) {
                            updateBarcodeTable(product.records, product.productRowId, product.maxSerialNo, product.maxLotBlock, product.maxBundle, product.maxSupplierRef, index);
                        });
                    } else {
                        showNoBarcodesMessage();
                    }
                },
                error: function(xhr) {
                    handleAjaxError(xhr);
                }
            });
        }
        const productIds = @json($products);
        fetchProducts(productIds);

        $(document).on('click', '#editBtn', function() {
            $('#showSupplierInvoicePackingItemForm #notes').prop('disabled', false);
            var note = $('#showSupplierInvoicePackingItemForm #notes').val();
            $('#editBtn').hide();
            $('#saveBtn').show();
        });

        $(document).on('click', '#saveBtn', function() {
            $('#showSupplierInvoicePackingItemForm #notes').prop('disabled', true);
            var note = $('#showSupplierInvoicePackingItemForm #notes').val();
            var id = $('#showSupplierInvoicePackingItemForm #id').val();
            var url = "{{ route('supplier_invoice_packing_items.note_update') }}";
            const csrfToken = '{{ csrf_token() }}';
            if (note.trim() !== '') {
                $.ajax({
                    url: url,
                    type: "POST",
                    data: {
                        note : note,
                        id : id,
                        _token: csrfToken
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === "success") {
                            showToast('success', response.msg);
                            $('#saveBtn').hide();
                            $('#editBtn').show();
                            const productIds = @json($products);
                            fetchProducts(productIds);
                        }
                    },
                    error: function(xhr) {
                        handleAjaxError(xhr);
                    }
                });
            } else {
                $('#showSupplierInvoicePackingItemForm #notes').prop('disabled', false);
                showToast('error', "Please enter the note.");
            }
        });


        function CopyAll(prefix,rowId) {
            var LineCount = parseInt($(`#LineCount_${rowId}`).val());
            for (var i = 0; i < LineCount - 1; i++) {
                var nextIndex = i + 1;
                var currentFieldValue = $('#' + prefix + i).val();
                $('#' + prefix + nextIndex).val(currentFieldValue);
            }
        }

        function copyOne(prefix, current) {
            var previousIndex = current - 1;
            $('#' + prefix + current).val($('#' + prefix + previousIndex).val());
        }

        function CopyAllDown(prefix, startIndex, rowId) {
            var LineCount = parseInt($(`#LineCount_${rowId}`).val());
            for (var i = startIndex; i < LineCount - 1; i++) {
                var nextIndex = i + 1;
                $("#" + prefix + nextIndex).val($("#" + prefix + i).val());
            }
        }

        $(document).on('click', '.copyAll', function() {
            var id = $(this).data('id');
            var rowId = $(this).data('row');
            var { prefix, lastIndex } = getPrefixAndIndex(id);
            CopyAll(prefix,rowId);
        });

        $(document).on('click', '.copyOne', function() {
            var id = $(this).data('id');
            var { prefix, lastIndex } = getPrefixAndIndex(id);
            copyOne(prefix, lastIndex);
        });

        $(document).on('click', '.copyAllDown', function() {
            var id = $(this).data('id');
            var rowId = $(this).data('row');
            var { prefix, lastIndex } = getPrefixAndIndex(id);
            CopyAllDown(prefix,lastIndex,rowId);
        });

        const getPrefixAndIndex = id => {
            if (typeof id !== 'string' || !id.includes('_')) {
                showToast('error', "Invalid ID format");
            }
            const parts = id.split('_');
            const lastIndex = parseInt(parts.pop(), 10);
            if (isNaN(lastIndex)) {
                showToast('error', "Invalid index in the ID");
            }
            const prefix = parts.join('_') + '_';
            return { prefix, lastIndex };
        };

        const generateCopyButtons = (index, prefix, rowId) => {
           const basePath = '{{ asset('public/images') }}';
           const finalTitles = { copyOne: 'Copy One', copyAllDown: 'Copy All Down', copyAll: 'Copy All' };
           const generateImgTag = (src, cssClass, dataRow, dataId, title) => `
                <img src="${basePath}/${src}" style="cursor: pointer;" class="${cssClass}" data-row="${dataRow}" data-id="${dataId}" title="${title}">
            `;
            return index >= 1
                ? `
                    ${generateImgTag('icon_import.png', 'copyOne', index, `${prefix}_${rowId}_${index}`, finalTitles.copyOne)}
                    ${generateImgTag('import.png', 'copyAllDown', rowId, `${prefix}_${rowId}_${index}`, finalTitles.copyAllDown)}
                `
                : generateImgTag('import.png', 'copyAll', rowId, `${prefix}_${rowId}_${index}`, finalTitles.copyAll);
        };

        function clearFields(rowId) {
            $(`#unit_pack_length_${rowId}, #unit_pack_width_${rowId}, #pack_length_${rowId}, #pack_width_${rowId}, #rec_length_${rowId}, #rec_width_${rowId}, #block_${rowId}, #bundle_${rowId}, #supplier_ref_${rowId}`).val('');
        }
    });
</script>
