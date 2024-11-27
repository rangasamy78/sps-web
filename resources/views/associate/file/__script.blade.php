<script type="text/javascript">
$(function() {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $id = $('#associate_id').val();
    var table_associatefile = $('#associateFile').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        searching: false,
        ajax: {
            url: "{{ route('associate_files.list', ':id') }}".replace(':id', $id),
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

    let rowCount = 0;
    $('#upload').on('change', function() {
        let files = this.files;
        let defaultImage = "{{ asset('public/assets/img/elements/22.png') }}";
        for (let i = 0; i < files.length; i++) {
            let fileInput = files[i];

            if (fileInput) {
                rowCount++;
                let fileURL = "";
                if (fileInput.type.startsWith('image/')) {
                    fileURL = window.URL.createObjectURL(fileInput);
                } else {
                    fileURL = defaultImage;
                }
                let $select = $('#fileUploadRow');
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
                        <input type="text" value="" class="form-control" name="notes[]">
                    </td>
                    <td>
                        <button type="button" class="btn btn-md rounded-pill btn-icon btn-label-danger deleteRow" data-row="row-${rowCount}">
                           X
                        </button>
                    </td>
                </tr>
            `);
                $select.append(newRow);
                let newFileInput = newRow.find('input[type="file"]')[0];
                let dataTransfer = new DataTransfer();
                dataTransfer.items.add(fileInput);
                newFileInput.files = dataTransfer.files;
            }
        }
    });

    $(document).on('click', '.deleteRow', function() {
        const rowId = $(this).data('row');
        $(`#${rowId}`).remove();
    });

    $('#saveFile').click(function(e) {

        e.preventDefault();
        var form = $('#uploadFileForm')[0]; // Get the form element
        var formData = new FormData(form); // Create FormData object
        $.ajax({
            url: '{{ route("associate_files.store") }}', // Your upload route
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
                    table_associatefile.draw();
                    $('#uploadFileForm')[0].reset();
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
        var updateButton = row.find('.updateFile');
        if (notesInput.prop('readonly')) {
            notesInput.removeAttr('readonly').removeClass('bg-label-secondary');
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
        var formData = {
            notes: notesInput.val(),
            _token: '{{ csrf_token() }}',
            _method: 'PUT'
        };
        $.ajax({
            url: "{{ route('associate_files.update', ':id') }}".replace(':id', id),
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response.status === 'success') {
                    showToast('success', response.msg);
                    notesInput.attr('readonly', true);
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
            deleteAssociateFile(id);
        });

        function deleteAssociateFile(id) {
            var url = "{{ route('associate_files.destroy', ':id') }}".replace(':id', id);
            $.ajax({
                url: url,
                type: "DELETE",
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.status === "success") {
                        handleAjaxResponse(response, table_associatefile);
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
});
</script>