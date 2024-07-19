function showSuccessMessage(title, message) {
    Swal.fire({
        title: title,
        text: message,
        icon: 'success',
        customClass: {
            confirmButton: 'btn btn-primary'
        },
        buttonsStyling: false
    });
}

function showError(title, message) {
    Swal.fire({
        icon: 'error',
        title: title || 'Oops!',
        text: message || 'Something went wrong. Please try again later.',
        customClass: {
            confirmButton: 'btn btn-danger'
        }
    });
}

function handleAjaxError(xhr, operationType, modelName) {
    var res = xhr.responseJSON;
    if ($.isEmptyObject(res) === false) {
        $.each(res.errors, function(prefix, val) {
            $('span.' + prefix + '_error').text(val[0]);
        });
    }

    // Determine operation type and update UI accordingly
    if (operationType === 'create') {
        $('#savedata').html('Save '+ modelName);
    } else if (operationType === 'update') {
        $('#savedata').html('Update '+ modelName);
    }

    // var errorMessage = xhr.responseJSON.msg || 'An error occurred.';
    // var errorTitle = type === 'POST' ? 'Created!' : 'Updated!';
    // showError(errorTitle, errorMessage);
}

function confirmDelete(id, callback) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
        customClass: {
            confirmButton: 'btn btn-primary me-1',
            cancelButton: 'btn btn-label-secondary'
        },
        buttonsStyling: false
    }).then((result) => {
        if (result.isConfirmed) {
            callback();
        }
    });
}
