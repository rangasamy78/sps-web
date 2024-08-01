<script type="text/javascript">
    $(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('#purchaseShipmentMethodTable').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            order: [
                [0, 'desc']
            ],
            ajax: {
                url: "{{ route('purchase_shipment_methods.list') }}",
                data: function(d) {
                    sort = (d.order[0].dir == 'asc') ? "asc" : "desc";
                    d.order = [{
                        column: 0,
                        dir: sort
                    }];
                }
            },
            columns: [{
                    data: 'id',
                    name: 'id',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'shipment_method_name',
                    name: 'shipment_method_name'
                },
                {
                    data: 'shipment_method_description',
                    name: 'shipment_method_description'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
            rowCallback: function(row, data, index) {
                $('td:eq(0)', row).html(table.page.info().start + index + 1); // Update the index column with the correct row index
            },
            dom: '<"card-header flex-column flex-md-row"<"head-label text-center"><"dt-action-buttons text-end pt-3 pt-md-0"B>><"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            // displayLength: 7,
            // lengthMenu: [7, 10, 25, 50, 75, 100],
            buttons: [{
                text: '<i class="bx bx-plus me-sm-1"></i> <span class="d-none d-sm-inline-block" >Add New Record</span>',
                className: 'create-new btn btn-primary',
                attr: {
                    'data-bs-toggle': 'modal',
                    'data-bs-target': '#purchaseShipmentMethodModel',
                    'id': 'createBin',
                },
                action: function(e, dt, node, config) {
                    $('#savedata').html("Save Purchase Shipment Method");
                    $('#purchase_shipment_method_id').val('');
                    $('#purchaseShipmentMethodForm').trigger("reset");
                    $('.shipment_method_name_error').html('');
                    $('.shipment_method_description_error').html('');
                     clearEditor();
                    $('#modelHeading').html("Create New Purchase Shipment Method");
                    $('#purchaseShipmentMethodModel').modal('show');
                }
            }],
        });

        $('#purchaseShipmentMethodForm input').on('input', function() {
            let fieldName = $(this).attr('name');
            $('.' + fieldName + '_error').text('');
        });

        $('#savedata').click(function(e) {
            e.preventDefault();
            $(this).html('Sending..');
            var url = $('#purchase_shipment_method_id').val() ? "{{ route('purchase_shipment_methods.update', ':id') }}".replace(':id', $('#purchase_shipment_method_id').val()) : "{{ route('purchase_shipment_methods.store') }}";
            var type = $('#purchase_shipment_method_id').val() ? "PUT" : "POST";
            $.ajax({
                url: url,
                type: type,
                data: $('#purchaseShipmentMethodForm').serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        $('#purchaseShipmentMethodForm').trigger("reset");
                        $('#purchaseShipmentMethodModel').modal('hide');
                        table.draw();
                        var successMessage = type === 'POST' ? 'Purchase Shipment Method Added Successfully!' : 'Purchase Shipment Method Updated Successfully!';
                        var successTitle = type === 'POST' ? 'Created!' : 'Updated!';
                        showSuccessMessage(successTitle, successMessage);
                    }
                },
                error: function(xhr) {
                    handleAjaxError(xhr);
                    var button = type === 'POST' ? 'Save Purchase Shipment Method' : 'Update Purchase Shipment Method';
                    $('#savedata').html(button);
                }
            });
        });

        $('body').on('click', '.editbtn', function() {
            var id = $(this).data('id');
            $.get("{{ route('purchase_shipment_methods.index') }}" + '/' + id + '/edit', function(data) {
                $(".shipment_method_name_error").html("");
                $('#modelHeading').html("Edit Purchase Shipment Method");
                $('#savedata').val("edit-purchase-shipment-method");
                $('#savedata').html("Update Purchase Shipment Method");
                $('#purchaseShipmentMethodModel').modal('show');
                $('#purchase_shipment_method_id').val(data.id);
                $('#shipment_method_name').val(data.shipment_method_name);
                $('#shipment_method_description').val(data.shipment_method_description);
                descriptionEditor.root.innerHTML = data.shipment_method_description;
            });
        });

        $('body').on('click', '.deletebtn', function() {
            var id = $(this).data('id');
            confirmDelete(id, function() {
                deletePurchaseShipmentMethod(id);
            });
        });

        function deletePurchaseShipmentMethod(id) {
            var url = "{{ route('purchase_shipment_methods.destroy', ':id') }}".replace(':id', id);

            $.ajax({
                url: url,
                type: "DELETE",
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.status === "success") {
                        table.draw(); // Assuming 'table' is defined for DataTables
                        showSuccessMessage('Deleted!', 'Purchase Shipment Method Deleted Successfully!');
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

        $('body').on('click', '.showbtn', function() {
            var id = $(this).data('id');
            $.get("{{ route('purchase_shipment_methods.index') }}" + '/' + id, function(data) {
                $('#showPurchaseShipmentMethodModal').modal('show');
                $('#showPurchaseShipmentMethodForm #shipment_method_name').val(data.shipment_method_name);
                $('#showPurchaseShipmentMethodForm #shipment_method_description').val(data.shipment_method_description);
                showDescriptionEditor.root.innerHTML = data.shipment_method_description;
            });
        });
        setTimeout(() => {
            $('.dataTables_filter .form-control').removeClass('form-control-sm').css('margin-right', '20px');
            $('.dataTables_length .form-select').removeClass('form-select-sm').css('padding-left', '30px');
        }, 300);
        //Description Editor
        const fullToolbar = [
            [{ font: [] }, { size: [] } ],
            ['bold', 'italic', 'underline', 'strike'],
            [{ color: [] }, { background: []}],
            [{
                    script: 'super'
                },
                {
                    script: 'sub'
                }
            ],
            [{
                    header: '1'
                },
                {
                    header: '2'
                },
                'blockquote',
                'code-block'
            ],
            [{
                    list: 'ordered'
                },
                {
                    list: 'bullet'
                },
                {
                    indent: '-1'
                },
                {
                    indent: '+1'
                }
            ],
            [{
                direction: 'rtl'
            }],
            // ['link', 'image', 'video', 'formula'],
            ['clean']
        ];
        const descriptionEditor = new Quill('#descriptionEditor', {
            bounds: '#descriptionEditor',
            placeholder: 'Type Description...',
            modules: {
                formula: true,
                toolbar: fullToolbar
            },
            theme: 'snow',
        });

        descriptionEditor.on('text-change', function() {
            document.getElementById('shipment_method_description').value = descriptionEditor.root.innerHTML;
        });

        function clearEditor() {
            descriptionEditor.setContents([]); // Clear all content
        }

        const showDescriptionEditor = new Quill('#showDescriptionEditor', {
            bounds: '#showDescriptionEditor',
            modules: {
                formula: true,
                toolbar: fullToolbar
            },
            theme: 'snow',
        });
        showDescriptionEditor.enable(false);
    });
</script>