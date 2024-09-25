<script type="text/javascript">
    $(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table_contact = $('#supplierPriceSheet').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            searching: false,

            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex align-items-center justify-content-end"fB>>t<"row"<"col-sm-12"i><"col-sm-12"p>>',
            buttons: [{
                text: '<i class="bx bx-plus me-sm-1"></i> <span class="d-none d-sm-inline-block">Add Supplier Price</span>',
                className: 'create-new btn btn-primary',
                attr: {
                    'data-bs-toggle': 'offcanvas',
                    'data-bs-target': '#offcanvasPriceSheet',
                    'aria-controls': 'offcanvasExample',
                },
                action: function(e, dt, node, config) {}
            }]
        });

        // $('#saveContactForm input, #saveContactForm select').on('input change', function() {
        //     let fieldName = $(this).attr('name');
        //     $('.' + fieldName + '_error').text('');
        // });
        // $('#savecontactdata').click(function(e) {
        //     e.preventDefault();
        //     var button = $('#savecontactdata');
        //     sending(button);
        //     $.ajax({
        //         url: "{{ route('contacts.save') }}",
        //         type: "POST",
        //         data: $('#saveContactForm').serialize(),
        //         dataType: 'json',
        //         success: function(response) {
        //             if (response.status === "success") {
        //                 $('#saveContactForm').trigger("reset");
        //                 table_contact.draw();
        //                 showToast('success', response.msg);
        //                 $('#offcanvasRight').offcanvas('hide');
        //                 sending(button, true);
        //                 button.attr('data-bs-dismiss', 'offcanvas');
        //             } else {
        //                 button.removeAttr('data-bs-dismiss');
        //                 if (response.errors) {
        //                     $.each(response.errors, function(field, error) {
        //                         $('.' + field + '_error').text(error[0]);
        //                     });
        //                 }
        //             }
        //             button.removeAttr('data-bs-dismiss');
        //         },
        //         error: function(xhr) {
        //             handleAjaxError(xhr);
        //             sending(button, true);
        //             button.removeAttr('data-bs-dismiss');
        //         }
        //     });
        // });

    });
</script>