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

function sending(button, reset = false) {
    if (reset) {
        return button.html(button.data('original-text'));
    } else {
        if (!button.data('original-text')) {
            button.data('original-text', button.html());
        }
        return button.html('Sending&nbsp;&nbsp;<span class="spinner-border spinner-border-sm"></span>');
    }
}

var toastMixin = Swal.mixin({
    toast: true,
    icon: 'success', // This can be 'success', 'info', 'warning', or 'error'
    title: 'General Title',
    animation: false,
    position: 'top-right',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    customClass: {
        container: 'swal-toast-success' // Change this class based on the type of notification
    },
    didOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer)
      toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});

// Function to display toast with dynamic color
function showToast(type, title) {
    let className;

    switch(type) {
        case 'success':
            className = 'swal-toast-success';
            break;
        case 'info':
            className = 'swal-toast-info';
            break;
        case 'warning':
            className = 'swal-toast-warning';
            break;
        case 'error':
            className = 'swal-toast-error';
            break;
        default:
            className = '';
    }

    toastMixin.fire({
        icon: type,
        title: title,
        customClass: {
            container: className
        }
    });
}

// Example usage
// showToast('success', 'Operation Successful');

setTimeout(() => {
    $('.dataTables_filter .form-control').removeClass('form-control-sm').css('margin-right',
        '20px');
    $('.dataTables_length .form-select').removeClass('form-select-sm').css('padding-left',
        '30px');
}, 300);
