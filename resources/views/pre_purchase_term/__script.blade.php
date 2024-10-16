<script type="text/javascript">
    $(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#PrePurchaseTermNameFilter').on('keyup change', function(e) {
            e.preventDefault();
            table.draw();
        });

        var table = $('#datatable').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            searching: false,
            order: [
                [0, 'desc']
            ],
            ajax: {
                url: "{{ route('pre_purchase_terms.list') }}",
                data: function(d) {
                    sort = (d.order[0].dir == 'asc') ? "asc" : "desc";
                    d.pre_purchase_term_name = $('#PrePurchaseTermNameFilter').val();
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
                },
                {
                    data: 'pre_purchase_term_name',
                    name: 'pre_purchase_term_name'
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
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex align-items-center justify-content-end"fB>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            buttons: [{
                text: '<i class="bx bx-plus me-sm-1"></i> <span class="d-none d-sm-inline-block" >Add Pre Purchase Term</span>',
                className: 'create-new btn btn-primary',
                attr: {
                    'data-bs-toggle': 'modal',
                    'data-bs-target': '#prePurchaseTermModel',
                    'id': 'createBin',
                },
                action: function(e, dt, node, config) {
                    $('#savedata').html("Save Pre Purchase Term");
                    $('#pre_purchase_term_id').val('');
                    $('#prePurchaseTermForm').trigger("reset");
                    $('.pre_purchase_term_name_error').html('');
                    clearEditor();
                    $('#modelHeading').html("Create New Pre Purchase Term");
                    $('#prePurchaseTermModel').modal('show');
                }
            }],
        });

        $('#prePurchaseTermForm input').on('input', function() {
            let fieldName = $(this).attr('name');
            $('.' + fieldName + '_error').text('');
        });

        $('#savedata').click(function(e) {
            e.preventDefault();
            var button = $(this);
            sending(button);
            var url = $('#pre_purchase_term_id').val() ? "{{ route('pre_purchase_terms.update', ':id') }}".replace(':id', $('#pre_purchase_term_id').val()) : "{{ route('pre_purchase_terms.store') }}";
            var type = $('#pre_purchase_term_id').val() ? "PUT" : "POST";
            $.ajax({
                url: url,
                type: type,
                data: $('#prePurchaseTermForm').serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        $('#prePurchaseTermForm').trigger("reset");
                        $('#prePurchaseTermModel').modal('hide');
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
            var id = $(this).data('id');
            $.get("{{ route('pre_purchase_terms.index') }}" + '/' + id + '/edit', function(data) {
                $(".pre_purchase_term_name_error").html("");
                $('#modelHeading').html("Edit Pre Purchase Term");
                $('#savedata').val("edit-purchase-shipment-method");
                $('#savedata').html("Update Pre Purchase Term");
                $('#prePurchaseTermModel').modal('show');
                $('#pre_purchase_term_id').val(data.id);
                $('#pre_purchase_term_name').val(data.pre_purchase_term_name);
            });
        });

        $('body').on('click', '.deletebtn', function() {
            var id = $(this).data('id');
            confirmDelete(id, function() {
                deletePrePurchaseTerm(id);
            });
        });

        function deletePrePurchaseTerm(id) {
            var url = "{{ route('pre_purchase_terms.destroy', ':id') }}".replace(':id', id);

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

        $('body').on('click', '.showbtn', function() {
            var id = $(this).data('id');
            $.get("{{ route('pre_purchase_terms.index') }}" + '/' + id, function(data) {
                $('#showPrePurchaseTermModal').modal('show');
                $('#showPrePurchaseTermForm #pre_purchase_term_name').val(data.pre_purchase_term_name);
            });
        });

    });
</script>
