<script type="text/javascript">
    /**
     * Account Settings - Account
     */

    'use strict';
    document.addEventListener('DOMContentLoaded', function(e) {
        (function() {
            let accountUserImage = document.getElementById('uploadedAvatar');
            const fileInput = document.querySelector('.account-file-input'),
                resetFileInput = document.querySelector('.account-image-reset'),
                cancelButton = document.querySelector('.cancel-button');
                
            if (accountUserImage) {
                const resetImage = accountUserImage.src;
                fileInput.onchange = () => {
                    if (fileInput.files[0]) {
                        accountUserImage.src = window.URL.createObjectURL(fileInput.files[0]);
                    }
                };
                resetFileInput.onclick = () => {
                    fileInput.value = null;
                    accountUserImage.src = "{{ asset('public/assets/img/avatars/1.png') }}";
                };
            }
            if (cancelButton) {
                cancelButton.onclick = () => {
                    window.location.href = "{{ route('home') }}";
                };
            }

            $('#userProfileUpdateForm input').on('input', function() {
                let fieldName = $(this).attr('name');
                $('.' + fieldName + '_error').text('');
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#savedata').click(function(e) {
                e.preventDefault();
                var button = $(this);
                sending(button);

                var formData = new FormData($('#userProfileUpdateForm')[0]);
                var userProfileUpdateId = $('#user_id').val();
                $.ajax({
                    url: "{{ route('user_profile_updates.update', ':id') }}".replace(':id', userProfileUpdateId),
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'logout' && response.msg.includes('logged out')) {
                            window.location.href = "{{ route('login') }}";
                        } else if (response.status === "success") {
                            showToast('success', response.msg);
                        }
                        let storagePath = `{{ asset('storage/app/public/') }}`;
                        let defaultPath = `{{ asset('public/assets/img/avatars/1.png') }}`;
                        let logoUrl = response.user_image ? `${storagePath}/${response.user_image}` : defaultPath;
                        setImageSource(logoUrl, defaultPath);
                        sending(button, true);
                    },
                    error: function(xhr) {
                        handleAjaxError(xhr);
                        sending(button, true);
                    }
                });
            });

            function setImageSource(imagePath, defaultPath) {
                let imageUrl = imagePath ? `${imagePath}` : defaultPath;
                $('#navbarUserImage').attr('src', imageUrl);
                $('#navbarUserImage1').attr('src', imageUrl);
            }
        })();
    });
</script>