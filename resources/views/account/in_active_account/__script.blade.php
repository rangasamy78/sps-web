<script type="text/javascript">
    $(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var table = $('#datatablesInAccount').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            searching: false,
            order: [
                [1, 'desc']
            ],
            ajax: {
                url: "{{ route('accounts.in_active_list') }}",
                data: function(d) {
                    sort = (d.order[0].dir == 'asc') ? "asc" : "desc";
                    d.order = [{
                        column: 1,
                        dir: sort
                    }];
                }
            },
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'account_number',
                    name: 'account_number'
                },
                {
                    data: 'account_name',
                    name: 'account_name'
                },
                {
                    data: 'alternate_number',
                    name: 'alternate_number'
                },
                {
                    data: 'alternate_name',
                    name: 'alternate_name'
                },
                {
                    data: 'account_type_id',
                    name: 'account_type_id'
                },
                {
                    data: 'account_sub_type_id',
                    name: 'account_sub_type_id'
                },
                {
                    data: 'special_account_type_id',
                    name: 'special_account_type_id'
                },
                {
                    data: 'is_sub_account_of_id',
                    name: 'is_sub_account_of_id'
                },
                {
                    data: 'balance',
                    name: 'balance'
                },
                {
                    data: 'status',
                    name: 'status'
                }
            ],
            rowCallback: function(row, data, index) {
                $('td:eq(0)', row).html(table.page.info().start + index + 1);
                if (data.status === 'Inactive') {
                    $(row).addClass('table-danger');
                }
            },
        });
    });
</script>