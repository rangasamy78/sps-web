<script type="text/javascript">
    $(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var table = $('#accountStandardPaymentTermTable').DataTable({
            searching: false,
            responsive: true,
            processing: true,
            serverSide: true,
            order: [[0, 'desc']],
            ajax: {
                url: "{{ route('account_payment_terms.list') }}",
                data: function (d) {
                    d.toggleBtnVal = $('button[name="btn_payment_standard_date_driven"].active').val();
                    d.code_search = $('#codeFilter').val();
                    d.label_search = $('#labelFilter').val();
                    d.term_search = $('#termFilter').val();
                    d.net_due_search = $('#netDueFilter').val();
                    sort = (d.order[0].dir == 'asc') ? "asc" : "desc";
                    d.order = [{ column: 0, dir: sort }];
                }
            },
            columns: [
                { data: 'id', name: 'id', orderable: false, searchable: false },
                { data: 'payment_code', name: 'payment_code' },
                { data: 'payment_label', name: 'payment_label' },
                { data: 'payment_type', name: 'payment_type' },
                { data: 'payment_net_due_day', name: 'payment_net_due_day' },
                { data: 'payment_usage', name: 'payment_usage' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            rowCallback: function (row, data, index) {
                $('td:eq(0)', row).html(table.page.info().start + index + 1); 
            },
        })
       
        $('#createPaymentTerm').click(function () {
            resetForm();
            var standard_date_driven = $('button[name="btn_payment_standard_date_driven"].active').val();
            var headingName = (standard_date_driven == 1) ? "Standard" : "Date Driven";  
            $('#savedata').html("Save Payment Term");
            $('#account_payment_term_id').val('');
            $('#accountPaymentTermForm').trigger("reset");
            $('#modelHeading').html("Create New " + headingName + " Payment Term");
            $('#accountPaymentTermModel').modal('show');
        });

        setTimeout(() => {
            $('.dataTables_filter .form-control').removeClass('form-control-sm').css('margin-right','20px');
            $('.dataTables_length .form-select').removeClass('form-select-sm').css('padding-left','30px');
        }, 300);

        $('#accountPaymentTermForm input, #accountPaymentTermForm select').on('input change', function () {
            let fieldName = $(this).attr('name');
            $('.' + fieldName + '_error').text('');
        });

        $('#savedata').click(function (e) {          
            e.preventDefault();
            var button = $(this).html();
            $(this).html('Sending..');
            var standard_date_driven = $('button[name="btn_payment_standard_date_driven"].active').val();
            var headingName = (standard_date_driven == 1) ? "Standard" : "Date Driven";  
            var url = $('#account_payment_term_id').val() ? "{{ route('account_payment_terms.update', ':id') }}".replace(':id', $('#account_payment_term_id').val()) : "{{ route('account_payment_terms.store') }}";
            var type = $('#account_payment_term_id').val() ? "PUT" : "POST";
            var formData = $('#accountPaymentTermForm').serializeArray();
            formData.push({ name: 'payment_not_used_sales', value: $('#payment_not_used_sales').is(':checked') ? '1' : '0' });
            formData.push({ name: 'payment_not_used_purchases', value: $('#payment_not_used_purchases').is(':checked') ? '1' : '0' });
            formData.push({ name: 'payment_standard_date_driven', value: standard_date_driven });
            var serializedData = $.param(formData);
            $.ajax({
                url: url,
                type: type,
                data: serializedData,
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        $('#accountPaymentTermForm').trigger("reset");
                        $('#accountPaymentTermModel').modal('hide');
                        table.draw();
                        var successMessage = type === 'POST' ?  headingName + ' Payment Term Added Successfully!' : headingName + ' Payment Term Updated Successfully!';
                        var successTitle = type === 'POST' ? 'Created!' : 'Updated!';
                        showSuccessMessage(successTitle, successMessage);
                    } 
                },
                error: function(xhr) {
                    handleAjaxError(xhr);
                    $('#savedata').html(button);
                }
            });
        });
        $('body').on('click', '.editbtn', function() {
            resetForm();           
            var standard_date_driven = $('button[name="btn_payment_standard_date_driven"].active').val();
            var headingName = (standard_date_driven == 1) ? "Standard" : "Date Driven";
            var id = $(this).data('id');
            $.get("{{ route('account_payment_terms.index') }}" + '/' + id + '/edit', function(data) {
                $('#modelHeading').html("Update " + headingName + " Payment Term");
                $('#savedata').html("Update Payment Term");
                $('#accountPaymentTermModel').modal('show');
                $('#account_payment_term_id').val(data.id);
                $('#payment_code').val(data.payment_code);
                $('#payment_label').val(data.payment_label);
                $('#payment_type').val(data.payment_type);
                $('#payment_net_due_day').val(data.payment_net_due_day);
                $('#payment_discount_percent').val(data.payment_discount_percent);
                $('#payment_threshold_days').val(data.payment_threshold_days);
                (data.payment_not_used_sales == 1) ? $('#payment_not_used_sales').prop('checked', true) : $('#payment_not_used_sales').prop('checked', false);
                (data.payment_not_used_purchases == 1) ? $('#payment_not_used_purchases').prop('checked', true) : $('#payment_not_used_purchases').prop('checked', false);
            });
        });

        $('body').on('click', '.deletebtn', function() {
            var id = $(this).data('id');
            confirmDelete(id, function () {
                deletePaymentTerm(id);
            });
        });
        
        function deletePaymentTerm(id) {
            var url = "{{ route('account_payment_terms.destroy', ':id') }}".replace(':id', id);
            $.ajax({
                url: url,
                type: "DELETE",
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    if (response.status === "success") {
                        table.draw(); 
                        var standard_date_driven = $('button[name="btn_payment_standard_date_driven"].active').val();
                        var headingName = (standard_date_driven == 1) ? "Standard" : "Date Driven";
                        showSuccessMessage('Deleted!', headingName + ' Payment Term Deleted Successfully!');
                    } else {
                        showError('Deleted!', response.msg);
                    }
                },
                error: function (xhr) {
                    console.error('Error:', xhr.statusText);
                    showError('Oops!', 'Failed to fetch data.');
                }
            });
        }
        $('body').on('click', '.showbtn', function() {          
            var standard_date_driven = $('button[name="btn_payment_standard_date_driven"].active').val();
            var headingName = (standard_date_driven == 1) ? "Standard" : "Date Driven";
            var id = $(this).data('id');
            $.get("{{ route('account_payment_terms.index') }}" + '/' + id, function(data) {
                $('#showAccountPaymentTermModal').modal('show');
                $('#showAccountPaymentTermModalLabel').html("Show " + headingName + " Payment Term");
                $('#showAccountPaymentTermForm #payment_code').val(data.payment_code);
                $('#showAccountPaymentTermForm #payment_label').val(data.payment_label);
                $('#showAccountPaymentTermForm #payment_type').val(data.payment_type);
                $('#showAccountPaymentTermForm #payment_net_due_day').val(data.payment_net_due_day);
                $('#showAccountPaymentTermForm #payment_discount_percent').val(data.payment_discount_percent);
                $('#showAccountPaymentTermForm #payment_threshold_days').val(data.payment_threshold_days);
                (data.payment_not_used_sales == 1) ? $('#showAccountPaymentTermForm #payment_not_used_sales').prop('checked', true) : $('#showAccountPaymentTermForm #payment_not_used_sales').prop('checked', false);
                (data.payment_not_used_purchases == 1) ? $('#showAccountPaymentTermForm #payment_not_used_purchases').prop('checked', true) : $('#showAccountPaymentTermForm #payment_not_used_purchases').prop('checked', false);
             });
        });
        function resetForm() {
            $('.payment_label_error').html('');
            $('.payment_type_error').html('');
            $('.payment_net_due_day_error').html('');
        }
        $('button[name="btn_payment_standard_date_driven"]').on('click', function() {
            const ids = ['codeFilter', 'labelFilter', 'termFilter', 'netDueFilter'];
            ids.forEach(id => {
                document.getElementById(id).value = '';
            });
            var toggleBtnVal = $(this).val();
            if(toggleBtnVal=='1'){
                $('#payment_net_due_day_label, #show_payment_net_due_day_label').html('Net Days to Pay');
                $('#lbl-name').html('In');            
                $('#payemnt_discount_display').show();
                $('#show_payemnt_discount_display').show();
                var headingName = "Standard";
            }
            else{
                $('#payment_net_due_day_label, #show_payment_net_due_day_label').html('Due on Day of Month');
                $('#lbl-name').html('On');
                $('#payemnt_discount_display').hide();
                $('#show_payemnt_discount_display').hide();
                var headingName = "Date Driven";
            }
            $('#main-head-label').html('List '+ headingName +' Payment Terms');
            $('#createPaymentTerm').html('<i class="bx bx-plus me-sm-1"></i>New '+ headingName +' Payment Term');
            table.draw(); 
        });

        $('#codeFilter, #labelFilter, #netDueFilter, #termFilter').on('keyup change', function(e) {
            e.preventDefault();
            table.draw();
        });
    });
</script>