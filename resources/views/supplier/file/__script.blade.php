<script type="text/javascript">
    $(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $id = $('#supplier_id').val();
        var table_accountfile = $('#supplierFile').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            searching: false,
            ajax: {
                url: "{{ route('supplier_files.list', ':id') }}".replace(':id', $id),
                type: 'GET',
                data: function(d) {

                },
            },
            columns: [{
                    data: 'image',
                    name: 'image',
                    orderable: false
                },
                {
                    data: 'file_name',
                    name: 'file_name'
                },
                {
                    data: 'file_type_id',
                    name: 'file_type_id'
                },
                {
                    data: 'notes',
                    name: 'notes'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
            rowCallback: function(row, data, index) {
                $(row).addClass('row-' + data.id);
            }
        });

        var fileTypes = @json($fileTypes);
        let rowCount = 0;
        let defaultImage = "{{ asset('public/assets/img/elements/22.png') }}";

        $('#upload').on('change', function() {
            let files = this.files;
            for (let i = 0; i < files.length; i++) {
                let fileInput = files[i];

                if (fileInput) {
                    rowCount++;
                    let fileURL = fileInput.type.startsWith('image/') ? window.URL.createObjectURL(fileInput) : defaultImage;

                    let $select = $('#supplierFileUploadRow');
                    let newRow = $(`
                <tr id="row-${rowCount}">
                    <td>
                        <img src="${fileURL}" alt="file-preview" class="d-block rounded" height="40" width="40" id="uploadedAvatar-${rowCount}" />
                    </td>
                    <td>
                        <label>${fileInput.name}</label>
                        <input type="file" name="file_name[]" hidden class="border-0 form-control form-control-lg">
                    </td>
                     <td>
                        <select id="file_type_id-${rowCount}" name="file_type_id[]" class="select2 form-select" data-allow-clear="true">
                            <option value="">--select--</option>
                        </select>
                    </td>
                    <td>
                        <input type="text" value="" class="form-control" name="notes[]">
                    </td>
                    <td>
                        <button type="button" class="btn btn-md rounded-pill btn-icon btn-label-danger deleteRow" data-row="row-${rowCount}">
                           X
                        </button>
                    </td>
                </tr>
                `);
                    // Append the new row
                    $select.append(newRow);
                    // Populate the select with fileTypes
                    let $newSelect = $(`#file_type_id-${rowCount}`);
                    fileTypes.forEach(function(fileType) {
                        $newSelect.append(`<option value="${fileType.id}">${fileType.file_Type}</option>`);
                    });
                    // Attach the file to the newly created file input
                    let newFileInput = newRow.find('input[type="file"]')[0];
                    let dataTransfer = new DataTransfer();
                    dataTransfer.items.add(fileInput);
                    newFileInput.files = dataTransfer.files;
                }
            }
        });

        // Remove the row when the delete button is clicked
        $(document).on('click', '.deleteRow', function() {
            const rowId = $(this).data('row');
            $(`#${rowId}`).remove();
        });

        $('#saveFile').click(function(e) {
            e.preventDefault();
            var form = $('#uploadSupplierFileForm')[0]; // Get the form element
            var formData = new FormData(form); // Create FormData object
            console.log(formData);
            $.ajax({
                url: '{{ route("supplier_files.store") }}', // Your upload route
                type: 'POST',
                data: formData,
                processData: false, // Important for sending FormData
                contentType: false, // Important for file uploads
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // CSRF token for Laravel
                },
                success: function(response) {
                    if (response.status === 'success') {
                        showToast('success', response.msg);
                        table_accountfile.draw();
                        $('#uploadSupplierFileForm')[0].reset();
                    } else {
                        showToast('error', response.msg);
                    }
                },
                error: function(xhr) {
                    handleAjaxError(xhr);
                }
            });
        });

        $('body').on('click', '.fileedit', function() {
            var id = $(this).data('id');
            var row = $(this).closest('tr');
            var notesInput = row.find('input[name="notes"]');
            var fileTypeSelect = row.find('select[name="file_type_id"]');
            var updateButton = row.find('.updateFile');
            if (notesInput.prop('readonly') && fileTypeSelect.prop('disabled')) {
                notesInput.removeAttr('readonly').removeClass('bg-label-secondary');
                fileTypeSelect.removeAttr('disabled').removeClass('bg-label-secondary');
                $(this).addClass('d-none');
                updateButton.removeClass('d-none');
            }
        });

        $(document).on('click', '.updateFile', function(e) {
            e.preventDefault();
            var button = $(this);
            var id = button.data('id');
            var row = $('.row-' + id);
            var notesInput = row.find('input[name="notes"]');
            var fileTypeSelect = row.find('select[name="file_type_id"]');

            // Ensure file_type_id is included in formData
            var formData = {
                notes: notesInput.val(),
                file_type_id: fileTypeSelect.val(),
                _token: '{{ csrf_token() }}',
                _method: 'PUT'
            };

            $.ajax({
                url: "{{ route('supplier_files.update', ':id') }}".replace(':id', id),
                type: 'POST',
                data: formData,
                success: function(response) {
                    if (response.status === 'success') {
                        showToast('success', response.msg);
                        notesInput.attr('readonly', true);
                        fileTypeSelect.attr('disabled', true);
                        button.addClass('d-none');
                        row.find('.fileedit').removeClass('d-none');
                    } else {
                        showToast('error', 'Notes update failed.');
                    }
                },
                error: function(xhr) {
                    showToast('error', 'An error occurred while updating the notes.');
                }
            });
        });

        $('body').on('click', '.filedelete', function() {
            var id = $(this).data('id');
            confirmDelete(id, function() {
                deleteSupplierFile(id);
            });
        });

        function deleteSupplierFile(id) {
            var url = "{{ route('supplier_files.destroy', ':id') }}".replace(':id', id);
            $.ajax({
                url: url,
                type: "DELETE",
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.status === "success") {
                        handleAjaxResponse(response, table_accountfile);
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

    });
</script>