<script type="text/javascript">
    $(function() {
        var companyCount = @json($companyCount);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#companyNameFilter, #emailFilter, #cityFilter, #stateFilter, #zipFilter, #phoneFilter, #websiteFilter').on('keyup change', function(e) {
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
                url: "{{ route('companies.list') }}",
                data: function(d) {
                    d.company_name_search = $('#companyNameFilter').val();
                    d.email_search = $('#emailFilter').val();
                    d.city_search = $('#cityFilter').val();
                    d.state_search = $('#stateFilter').val();
                    d.phone_search = $('#phoneFilter').val();
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
                    data: 'company_name',
                    name: 'company_name',
                },
                {
                    data: 'logo',
                    render: function(data, type, row) {
                        var imageUrl = '{{ asset("storage/app/public/") }}/' + data;
                        return '<img src="' + imageUrl + '" width="50px" height="50px" class="img-thumbnail rounded-circle">';
                    }
                },
                {
                    data: 'email',
                    name: 'email',
                },
                {
                    data: 'phone_1',
                    name: 'phone',
                },
                {
                    data: 'state',
                    name: 'state',
                },
                {
                    data: 'city',
                    name: 'city',
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ],
            rowCallback: function(row, data, index) {
                $('td:eq(0)', row).html(table.page.info().start + index + 1);
            },
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex align-items-center justify-content-end"fB>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            buttons: [{
                text: '<i class="bx bx-plus me-sm-1"></i> <span class="d-none d-sm-inline-block">Add Company</span>',
                className: 'create-new btn btn-primary',
                attr: {
                    'id' : 'create-new',
                    'data-bs-toggle': 'modal',
                    'data-bs-target': '#companyModel',
                },
                action: function(e, dt, node, config) {
                    resetFormFields();
                    $('#savedata').html("Save Company");
                    $('#company_id').val('');
                    $('#addCompanyForm').trigger("reset");
                    $('#modelHeading').html("Create New Company");
                    $('#addCompanyForm #logo').val('');
                    let defaultPath = `{{ asset('public/assets/img/branding/location-logo.png') }}`;
                    $('#addCompanyForm #imagePreview #previewImage').attr('src', defaultPath);
                    $('#companyModel').modal('show');
                }
            }],
        });

        $('#addCompanyForm input, textarea').on('input', function() {
            let fieldName = $(this).attr('name');
            $('.' + fieldName + '_error').text('');
        });

        $("#addCompanyForm").submit(function(e) {
            e.preventDefault();
            const fd = new FormData(this);
            $('#savedata').html('Sending&nbsp;&nbsp;<span class="spinner-border spinner-border-sm"></span>');
            $.ajax({
                url: "{{ route('companies.store') }}",
                method: 'post',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        $('#addCompanyForm').trigger("reset");
                        $('#companyModel').modal('hide');
                        let storagePath = `{{ asset('storage/app/public/') }}`;
                        let defaultPath = `{{ asset('public/assets/img/branding/location-logo.png') }}`;
                        let logoUrl = response.company_logo ? `${storagePath}/${response.company_logo}` : defaultPath;
                        setImageSource('.app-brand .logo-container img', logoUrl, defaultPath);
                        showToast('success', response.msg);
                        toggleCreateNewButton(response.companyCount == 1)
                        table.draw();
                    }
                },
                error: function(xhr) {
                    var res = xhr.responseJSON;
                    if ($.isEmptyObject(res) == false) {
                        $.each(res.errors, function(prefix, val) {
                            $('span.' + prefix + '_error').text(val[0]);
                        });
                    }
                    $('#addCompanyForm #savedata').html('Save Company');
                }
            });
        });

        $('body').on('click', '.editbtn', function() {
            resetFormFields();
            var id = $(this).data('id');
            $.get("{{ route('companies.index') }}" + '/' + id + '/edit', function(data) {
                populateEditForm(data);
                $('#editCompanyForm #logo').val('');
                $('#editCompanyModel').modal('show');
            });
        });

        function populateEditForm(data) {
            let defaultPath = `{{ asset('public/assets/img/branding/location-logo.png') }}`;
            const form = $('#editCompanyModel');
            form.find('#modelHeading').html("Edit Company");
            form.find('#savedata').val("edit-Company").html("Update Company");
            form.find('#company_id').val(data.id);
            form.find('#company_name').val(data.company_name);
            form.find('#email').val(data.email);
            form.find('#address_line_1').val(data.address_line_1);
            form.find('#address_line_2').val(data.address_line_2);
            form.find('#city').val(data.city);
            form.find('#state').val(data.state);
            form.find('#zip').val(data.zip);
            form.find('#phone_1').val(data.phone_1);
            form.find('#phone_2').val(data.phone_2);
            form.find('#website').val(data.website);
            form.find('#is_bin_pre_defined').prop('checked', data.is_bin_pre_defined);
            let logoUrl = data.logo ? `{{ asset('storage/app/public/') }}/${data.logo}` : defaultPath;
            form.find('#imagePreview #previewImage').attr('src', logoUrl).show();
        }

        $("#editCompanyForm").submit(function(e) {
            e.preventDefault();
            const form = new FormData(this);
            let companyId = $('#editCompanyForm #company_id').val();
            $('#editCompanyForm #savedata').html('Sending&nbsp;&nbsp;<span class="spinner-border spinner-border-sm"></span>');
            $.ajax({
                url: `{{ route('companies.update', ':id') }}`.replace(':id', companyId), // Replace :id with actual company ID
                method: 'post',
                data: form,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        $('#editCompanyForm').trigger("reset");
                        $('#editCompanyModel').modal('hide');
                        let storagePath = `{{ asset('storage/app/public/') }}`;
                        let defaultPath = `{{ asset('public/assets/img/branding/location-logo.png') }}`;
                        let logoUrl = response.company_logo ? `${storagePath}/${response.company_logo}` : defaultPath;
                        setImageSource('.app-brand .logo-container img', logoUrl, defaultPath);
                        table.draw();
                        showToast('success', response.msg);
                    }
                },
                error: function(xhr) {
                    var res = xhr.responseJSON;
                    if ($.isEmptyObject(res) == false) {
                        $.each(res.errors, function(prefix, val) {
                            $('span.' + prefix + '_error').text(val[0]);
                        });
                    }
                    $('#editCompanyForm #savedata').html('Update Company');
                }
            });
        });

        $('body').on('click', '.deletebtn', function() {
            var id = $(this).data('id');
            confirmDelete(id, function() {
                deleteCompany(id);
            });
        });

        function deleteCompany(id) {
            var url = "{{ route('companies.delete', ':id') }}".replace(':id', id);
            $.ajax({
                url: url,
                type: "DELETE",
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    handleAjaxResponse(response, table);
                    toggleCreateNewButton(companyCount = 0);
                },
                error: function(xhr) {
                    console.error('Error:', xhr.statusText);
                    showError('Oops!', 'Failed to fetch data.');
                }
            });
        }

        $('body').on('click', '.showbtn', function() {
            var id = $(this).data('id');
            $.get("{{ route('companies.index') }}" + '/' + id + '/show', function(data) {
                let defaultPath = `{{ asset('public/assets/img/branding/location-logo.png') }}`;
                $('#showCompanyForm #modelHeading').html("Show Company");
                $('#showCompanyForm #savedata').val("show-Company");
                $('#showCompanyModel').modal('show');
                $('#showCompanyForm #company_name').val(data.company_name);
                $('#showCompanyForm #email').val(data.email);
                $('#showCompanyForm #address_line_1').val(data.address_line_1);
                $('#showCompanyForm #address_line_2').val(data.address_line_2);
                $('#showCompanyForm #city').val(data.city);
                $('#showCompanyForm #state').val(data.state);
                $('#showCompanyForm #zip').val(data.zip);
                $('#showCompanyForm #phone_1').val(data.phone_1);
                $('#showCompanyForm #phone_2').val(data.phone_2);
                $('#showCompanyForm #website').val(data.website);
                $('#showCompanyForm #is_bin_pre_defined').prop('checked', data.is_bin_pre_defined);
                let logoUrl = data.logo ? `{{ asset('storage/app/public/') }}/${data.logo}` : defaultPath;
                $("#showCompanyForm #imagePreview #previewImage").attr('src', logoUrl).show();
            });
        });

        $('#addCompanyForm #logo').change(function() {
            let file = this.files[0];
            if (file) {
                let reader = new FileReader();
                reader.onload = function(e) {
                    $('#addCompanyForm #previewImage').attr('src', e.target.result);
                    $('#addCompanyForm #previewImage').show();
                }
                reader.readAsDataURL(file);
            } else {
                $('#addCompanyForm #previewImage').hide();
            }
        });

        $('#editCompanyForm #logo').change(function() {
            let file = this.files[0];
            if (file) {
                let reader = new FileReader();
                reader.onload = function(e) {
                    $('#editCompanyForm #previewImage').attr('src', e.target.result);
                    $('#editCompanyForm #previewImage').show();
                }
                reader.readAsDataURL(file);
            } else {
                $('#editCompanyForm #previewImage').hide();
            }
        });

        function resetFormFields() {
            $('.company_name_error').html('');
            $('.email_error').html('');
            $('.address_line_1_error').html('');
            $('.city_error').html('');
            $('.state_error').html('');
            $('.zip_error').html('');
            $('.phone_1_error').html('');
            $('.logo_error').html('');
            $('.is_bin_pre_defined_error').html('');
        }

        function setImageSource(selector, imagePath, defaultPath) {
            let imageUrl = imagePath ? `${imagePath}` : defaultPath;
            $(selector).attr('src', imageUrl);
        }

        function toggleCreateNewButton(shouldShow) {
            var button = $('#datatable').DataTable().buttons().container().find('#create-new');
            if (!shouldShow) {
                button.show();
            } else {
                button.hide();
            }
        }

        toggleCreateNewButton(companyCount == 1);
    });
</script>
