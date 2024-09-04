document.addEventListener('DOMContentLoaded', function() {
    function setupFormValidation(formId) {
        var form = document.getElementById(formId);
        if (form) {
            form.addEventListener('input', function(event) {
                var field = event.target;
                if (field.tagName === 'INPUT') {
                    var fieldName = field.getAttribute('name');
                    var errorElement = document.querySelector('.' + fieldName + '_error');
                    if (errorElement) {
                        errorElement.textContent = '';
                    }
                    field.classList.remove('is-invalid');
                }
            });
        }
    }

    // Apply to multiple forms
    setupFormValidation('Login');
    setupFormValidation('Register');
});
