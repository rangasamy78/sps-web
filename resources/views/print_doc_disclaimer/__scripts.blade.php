<script type="text/javascript">
    $(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#titleFilter, #select_type_category_id_filter, #select_type_sub_category_id_filter, #policyFilter').on('keyup change', function(e) {
            e.preventDefault();
            table.draw();
        });

        var table = $('#datatable').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            searching: false,
            order: [
                [1, 'desc']
            ],
            ajax: {
                url: "{{ route('print_doc_disclaimers.list') }}",
                data: function(d) {
                    d.title_search = $('#titleFilter').val();
                    d.select_type_category_search = $('#select_type_category_id_filter').val();
                    d.select_type_sub_category_search = $('#select_type_sub_category_id_filter').val();
                    d.policy_search = $('#policyFilter').val();
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
                },
                {
                    data: 'title',
                    name: 'title'
                },
                {
                    data: 'select_type_category_id',
                    name: 'select_type_category_id'
                },
                {
                    data: 'select_type_sub_category_id',
                    name: 'select_type_sub_category_id'
                },
                {
                    data: 'policy',
                    name: 'policy'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
            rowCallback: function(row, data, index) {
                $('td:eq(0)', row).html(table.page.info().start + index + 1);
            },
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex align-items-center justify-content-end"fB>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            buttons: [{
                text: '<i class="bx bx-plus me-sm-1"></i> <span class="d-none d-sm-inline-block">Create New Policies And Print Forms</span>',
                className: 'create-new btn btn-primary',
                attr: {
                    'data-bs-toggle': 'modal',
                    'data-bs-target': '#expenseCategoryModel',
                },
                action: function(e, dt, node, config) {
                    clearEditor()
                    resetForm()
                    $('#savedata').html("Save Policies And Print Forms");
                    $('#print_doc_disclaimer_id').val('');
                    $('#printDocDisclaimerForm').trigger("reset");
                    $('#modelHeading').html("Create New Policies And Print Forms");
                    $('#printDocDisclaimerModel').modal('show');
                }
            }],
        });

        $('#createPrintDocDisclaimer').click(function() {
            clearEditor()
            resetForm()
            $('#savedata').html("Save Policies And Print Forms");
            $('#print_doc_disclaimer_id').val('');
            $('#printDocDisclaimerForm').trigger("reset");
            $('#select_type_sub_category_id, #select_type_category_id').val('').trigger('change');
            $('#modelHeading').html("Create New Policies And Print Forms");
            $('#printDocDisclaimerModel').modal('show');
        });

        $('#printDocDisclaimerForm').on('input', 'input, select', function() {
            let fieldName = $(this).attr('name');
            $('.' + fieldName + '_error').text('');
        });

        $('#savedata').click(function(e) {
            e.preventDefault();
            var button = $(this);
            sending(button);
            var url = $('#print_doc_disclaimer_id').val() ? "{{ route('print_doc_disclaimers.update', ':id') }}".replace(':id', $('#print_doc_disclaimer_id').val()) : "{{ route('print_doc_disclaimers.store') }}";
            var type = $('#print_doc_disclaimer_id').val() ? "PUT" : "POST";
            $.ajax({
                url: url,
                type: type,
                data: $('#printDocDisclaimerForm').serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        $('#printDocDisclaimerForm').trigger("reset");
                        $('#printDocDisclaimerModel').modal('hide');
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
            $.get("{{ route('print_doc_disclaimers.index') }}" + '/' + id + '/edit', function(data) {
                resetForm()
                $('#modelHeading').html("Edit Policies And Print Forms");
                $('#savedata').val("edit-print-doc-disclaimer");
                $('#savedata').html("Update Policies And Print Forms");
                $('#printDocDisclaimerModel').modal('show');
                $('#print_doc_disclaimer_id').val(data.id);
                $('#title').val(data.title);
                $('#select_type_category_id').val(data.select_type_category_id);
                getSubcategories(data.select_type_category_id, data.select_type_sub_category_id, "edit");
                $('#policy').val(data.policy);
                descriptionEditor.root.innerHTML = data.policy;
            });
        });

        $('body').on('click', '.deletebtn', function() {
            var id = $(this).data('id');
            confirmDelete(id, function() {
                deletePrintDocDisclaimer(id);
            });
        });

        function deletePrintDocDisclaimer(id) {
            var url = "{{ route('print_doc_disclaimers.destroy', ':id') }}".replace(':id', id);
            $.ajax({
                url: url,
                type: "DELETE",
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    handleAjaxResponse(response, table);
                },
                error: function(xhr) {
                    console.error('Error:', xhr.statusText);
                    showError('Oops!', 'Failed to fetch data.');
                }
            });
        }

        $('body').on('click', '.showbtn', function() {
            var id = $(this).data('id');
            $.get("{{ route('print_doc_disclaimers.index') }}" + '/' + id, function(data) {
                $('#modelHeading').html("Show Policies And Print Forms");
                $('#savedata').val("edit-print-doc-disclaimer");
                $('#showPrintDocDisclaimerModal').modal('show');
                $('#showPrintDocDisclaimerForm #title').val(data.title);
                $('#showPrintDocDisclaimerForm #select_type_category_id').val(data.select_type_category_id);
                getSubcategories(data.select_type_category_id, data.select_type_sub_category_id, "show");
                $('#showPrintDocDisclaimerForm #policy').val(data.policy);
                showDescriptionEditor.root.innerHTML = data.policy;
            });
        });
    });

    const fullToolbar = [
        [{
            font: []
        }, {
            size: []
        }],
        ['bold', 'italic', 'underline', 'strike'],
        [{
            color: []
        }, {
            background: []
        }],
        [{
            script: 'super'
        }, {
            script: 'sub'
        }],
        [{
            header: '1'
        }, {
            header: '2'
        }, 'blockquote', 'code-block'],
        [{
            list: 'ordered'
        }, {
            list: 'bullet'
        }, {
            indent: '-1'
        }, {
            indent: '+1'
        }],
        [{
            direction: 'rtl'
        }],
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
        document.getElementById('policy').value = descriptionEditor.root.innerHTML;
    });

    const showDescriptionEditor = new Quill('#showDescriptionEditor', {
        bounds: '#showDescriptionEditor',
        modules: {
            formula: true,
            toolbar: fullToolbar
        },
        theme: 'snow',
    });
    showDescriptionEditor.enable(false);
    clearEditor()

    function clearEditor() {
        descriptionEditor.setContents([]);
    }

    $(document).ready(function() {
        $('#select_type_category_id, #select_type_category_id_filter').on('change', function() {
            var typeId = $(this).val();
            getSubcategories(typeId, "", "create");
        });
    });

    function getSubcategories(typeId, selectedSubcategoryId, type) {
        var $selectSubcategory;
        if (type === "show") {
            $selectSubcategory = $('#showPrintDocDisclaimerForm #select_type_sub_category_id');
        } else {
            $selectSubcategory = $([
                '#select_type_sub_category_id',
                '#select_type_sub_category_id_filter'
            ].join(', '));
        }
        $selectSubcategory.empty().append('<option value="">--Select Type Sub Category--</option>');
        if (typeId) {
            $.ajax({
                url: '{{ route("get_sub_categories") }}',
                type: 'GET',
                data: {
                    type_id: typeId
                },
                success: function(data) {
                    $.each(data.subcategories, function(key, value) {
                        if (value.select_type !== null) {
                            $selectSubcategory.append('<option value="' + value.id + '">' + value.select_type_sub_category_name + '</option>');
                        }
                    });
                    if (selectedSubcategoryId) {
                        $selectSubcategory.val(selectedSubcategoryId);
                    }
                    $selectSubcategory.prop('disabled', type === "show");
                },
                error: function() {
                    $selectSubcategory.empty().append('<option value="">--Select Type Sub Category--</option>');
                    $selectSubcategory.prop('disabled', type === "show");
                }
            });
        } else {
            $selectSubcategory.prop('disabled', type === "show");
        }
    }

    function resetForm() {
        $('.title_error').html('');
        $('.select_type_category_id_error').html('');
        $('.select_type_sub_category_id_error').html('');
    }
</script>