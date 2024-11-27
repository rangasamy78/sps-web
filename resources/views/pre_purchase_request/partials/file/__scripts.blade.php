<script type="text/javascript">
    $(function() {
        var id = $("#internalNoteForm #pre_purchase_request_id").val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('#prePurchaseRequestFile').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            searching: false,
            order: [
                [0, 'desc']
            ],
            ajax: {
                url: "{{ route('pre_purchase_request_files.list') }}",
                data: function(d) {
                    d.id = id;
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
                    data: 'images',
                    render: function(data, type, row) {
                        var imageUrl = '{{ asset("storage/app/public/") }}/' + data;
                        return '<img src="' + imageUrl + '" width="50px" height="50px" class="img-thumbnail rounded-circle previewImage">';
                    }
                },
                {
                    data: 'title',
                    name: 'title',
                },
                {
                    data: 'notes',
                    name: 'notes',
                },
                {
                    data: 'user_name',
                    name: 'user_name',
                },
                {
                    data: 'created_date',
                    name: 'created_date',
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
                text: '<i class="bx bx-plus me-sm-1"></i> <span class="d-none d-sm-inline-block" >Add File</span>',
                className: 'create-new btn btn-primary',
                attr: {
                    'data-bs-toggle': 'modal',
                    'data-bs-target': '#prePurchaseRequestFileModel',
                    'id': 'createFile',
                },
                action: function(e, dt, node, config) {
                    $('#saveFileData').html("Save File");
                    $('#pre_purchase_request_file_id').val('');
                    $('#prePurchaseRequestFileModelForm').trigger("reset");
                    $('#prePurchaseRequestFileModelForm #image').show();
                    $('#prePurchaseRequestFileModelForm #note').hide();
                    $('.images_error').html('');
                    $('#prePurchaseRequestFileModel #modelHeading').html("Create New File");
                    $('#prePurchaseRequestFileModel').modal('show');
                }
            }],
        });

        $('#prePurchaseRequestFileModelForm input, #prePurchaseRequestFileModelForm select').on('input change', function() {
            let fieldName = $(this).attr('name');
            $('.' + fieldName + '_error').text('');
        });


        $('#saveFileData').click(function(e) {
            e.preventDefault();
            var button = $(this);
            sending(button);
            var form = $('#prePurchaseRequestFileModelForm')[0];
            var fd = new FormData(form);

            var url = $('#pre_purchase_request_file_id').val() ? "{{ route('pre_purchase_request_files.update', ':id') }}".replace(':id',
                $('#pre_purchase_request_file_id').val()) : "{{ route('pre_purchase_request_files.store') }}";
            var type = $('#pre_purchase_request_file_id').val() ? "POST" : "POST";

            $.ajax({
                url: url,
                type: type,
                data: fd,
                processData: false, // Don't process the files
                contentType: false, // Set contentType to false to send FormData correctly
                dataType: 'json',
                success: function(response) {
                    if (response.status === "success") {
                        $('#addCompanyForm').trigger("reset");
                        $('#prePurchaseRequestFileModel').modal('hide');
                        showToast('success', response.msg);
                        table.draw();
                    }
                },
                error: function(xhr) {
                    var res = xhr.responseJSON;
                    if (!$.isEmptyObject(res.errors)) {
                        $.each(res.errors, function(prefix, val) {
                            if (prefix.indexOf('.') !== -1) {
                                $('#prePurchaseRequestFileModel span.' + prefix.replace('.0', '') + '_error').text(val[0]);
                            } else {
                                $('#prePurchaseRequestFileModel span.' + prefix + '_error').text(val[0]);
                            }
                        });
                    }
                    sending(button, true);
                }
            });
        });

        $('body').on('click', '.fileseditbtn', function() {
            $(".notes_error").html("");
            var id = $(this).data('id');
            $.get("{{ route('pre_purchase_request_files.index') }}" + '/' + id + '/edit', function(data) {
                $('#prePurchaseRequestFileModel #modelHeading').html("Edit File");
                $('#saveFileData').val("edit-file");
                $('#saveFileData').html("Update File");
                $('#prePurchaseRequestFileModel').modal('show');
                $('#prePurchaseRequestFileModelForm #image').hide();
                $('#prePurchaseRequestFileModelForm #note').show();
                $('#pre_purchase_request_file_id').val(data.id);
                $('#notes').val('');
            });
        });

        $('body').on('click', '.deletebtn', function() {
            var id = $(this).data('id');
            confirmDelete(id, function() {
                deleteFIle(id);
            });
        });

        function deleteFIle(id) {
            var url = "{{ route('pre_purchase_request_files.destroy', ':id') }}".replace(':id', id);
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

        document.addEventListener("click",function (e){
            if(e.target.classList.contains("previewImage")){
                const src = e.target.getAttribute("src");
                document.querySelector(".file_modal_img").src = src;
                const myModal = new bootstrap.Modal(document.getElementById('file_popup'));
                myModal.show();
            }
        });

    });
</script>
