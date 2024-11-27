<script type="text/javascript">
    $(function() {
        let id = $('#pre_purchase_request_id').val();
        let supplier_id = $('#internalNoteForm #supplier_id').val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#departmentFilter').on('keyup change', function(e) {
            e.preventDefault();
            table.draw();
        });

        var table = $('#prePurchaseRequestProduct').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            searching: false,
            order: [
                [0, 'desc']
            ],
            ajax: {
                url: "{{ route('pre_purchase_request_products.list') }}",
                data: function(d) {
                    d.id = id;
                    d.supplier_id = supplier_id;
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
                }, // Row index column
                {
                    data: 'product_sku',
                    name: 'product_sku',
                },
                {
                    data: 'product_name',
                    name: 'product_name',
                },
                {
                    data: 'description',
                    name: 'description',
                },
                {
                    data: 'picking_qty',
                    name: 'picking_qty',
                },
                {
                    data: 'slab',
                    name: 'slab',
                },
                {
                    data: 'qty',
                    name: 'qty',
                },
                {
                    data: 'purchasing_note',
                    name: 'purchasing_note',
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ],
            rowCallback: function(row, data, index) {
                $('td:eq(0)', row).html(table.page.info().start + index + 1); // Update the index column with the correct row index
            },
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex align-items-center justify-content-end"fB>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            buttons: [{
                text: '<i class="bx bx-plus me-sm-1"></i> <span class="d-none d-sm-inline-block" >Add Product</span>',
                className: 'create-new btn btn-primary',
                attr: {
                    'data-bs-toggle': 'modal',
                    'data-bs-target': '#prePurchaseRequestProductModel',
                    'id': 'createProduct',
                },
                action: function(e, dt, node, config) {
                    $('#saveProductData').html("Save Product");
                    $('#pre_purchase_request_product_id').val('');
                    $('#prePurchaseRequestProductModelForm').trigger("reset");
                    $('.product_name_error').html('');
                    $('#modelHeading').html("Create New Product");
                    $('#prePurchaseRequestProductModel').modal('show');
                }
            }],
        });

        $('#prePurchaseRequestProductModelForm input, #prePurchaseRequestProductModelForm select').on('input change', function() {
            let fieldName = $(this).attr('name');
            $('.' + fieldName + '_error').text('');
        });

        $('#saveProductData').click(function(e) {
            e.preventDefault();
            var button = $(this);
            sending(button);
            var url = $('#pre_purchase_request_product_id').val() ? "{{ route('pre_purchase_request_products.update', ':id') }}".replace(':id', $('#pre_purchase_request_product_id').val()) : "{{ route('pre_purchase_request_products.store') }}";
            var type = $('#pre_purchase_request_product_id').val() ? "PUT" : "POST";
            var formData = $('#prePurchaseRequestProductModelForm').serializeArray();
            var serializedData = $.param(formData);
            $.ajax({
                url: url,
                type: type,
                data: serializedData,
                dataType: 'json',
                success: function(response) {
                    if (response.status === "success") {
                        $('#prePurchaseRequestProductModelForm').trigger("reset");
                        $('#prePurchaseRequestProductModel').modal('hide');
                        showToast('success', response.msg);
                        table.draw();
                    }
                },
                error: function(xhr) {
                    handleAjaxError(xhr);
                    sending(button, true);
                }
            });
        });

        $('body').on('click', '.editbtn', function() {
            resetForm();
            var id = $(this).data('id');
            $.get("{{ route('pre_purchase_request_products.index') }}" + '/' + id + '/edit', function(data) {
                $('#modelHeading').html("Edit Product");
                $('#saveProductData').val("edit-product");
                $('#saveProductData').html("Update Product");
                $('#prePurchaseRequestProductModel').modal('show');
                $('#pre_purchase_request_product_id').val(data.id);
                $('#s_no').val(data.s_no);
                $('#product_sku').val(data.product_sku);
                $('#product_id').val(data.product_id).trigger('change');
                $('#description').val(data.description);
                $('#purchasing_note').val(data.purchasing_note);
                $('#length').val(data.length);
                $('#picking_qty').val(data.picking_qty);
                $('#picking_unit').val(data.picking_unit);
                $('#slab').val(data.slab);
                $('#qty').val(data.qty);
            });
        });

        function resetForm() {
            $(".product_id_error").html("");
            $(".qty_error").html("");
        }

        $('body').on('click', '.deleteProductbtn', function() {
            var id = $(this).data('id');
            confirmDelete(id, function() {
                deleteProduct(id);
            });
        });

        function deleteProduct(id) {
            var url = "{{ route('pre_purchase_request_products.destroy', ':id') }}".replace(':id', id);
            $.ajax({
                url: url,
                type: "DELETE",
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.status === "success") {
                        handleAjaxResponse(response, table);
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

        function calculateTotal() {
            var qty1 = parseFloat($('#picking_qty').val()) || 0;
            var qty2 = parseFloat($('#picking_unit').val()) || 0;
            var total = 0;
            var totalCost = 0;
            if (qty1 > 0 && qty2 > 0) {
                var avg_est_cost = $("#avg_est_cost").val();
                var total = qty1 * qty2;
                var totalCost = total * avg_est_cost;
                $('#slab').val(total);
                $('#pur_qty').val(total.toFixed(2));
                $('#qty').val(totalCost.toFixed(2));
            } else {
                $('#slab, #qty').val('');
            }
        }

        $('#picking_qty, #picking_unit').on('input', function() {
            calculateTotal();
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

        $('#qty').on('change', function() {
            var qty = parseFloat($(this).val()) || 0;
            $(this).val(qty.toFixed(2));
        });

    });
</script>
