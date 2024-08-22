<script type="text/javascript">
    $(function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var table = $('#datatable').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            order: [[0, 'desc']],
            ajax: {
                url: "{{ route('opportunity_stages.list') }}",
                data: function (d) {
                    sort = (d.order[0].dir == 'asc') ? "asc" : "desc";
                    d.order = [{ column: 0, dir: sort }];
                }
            },
            columns: [
                { data: 'id', name: 'id', orderable: false, searchable: false },
                { data: 'opportunity_stage', name: 'opportunity_stage' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            rowCallback: function (row, data, index) {
                $('td:eq(0)', row).html(table.page.info().start + index + 1); // Update the index column with the correct row index
            }
        });
        $('#createOpportunityStage').click(function () {
            $('.opportunity_stage_error').html('');
            $('#savedata').html("Save Opportunity Stage");
            $('#opportunity_stage_id').val('');
            $('#opportunityStageForm').trigger("reset");
            $('#modelHeading').html("Create New Opportunity Stage");
            $('#opportunityStageModel').modal('show');
        });
        $('#opportunityStageForm input').on('input', function () {
            let fieldName = $(this).attr('name');
            $('.' + fieldName + '_error').text('');
        })
        $('#savedata').click(function (e) {
            e.preventDefault();
            var button = $(this).html();
            $(this).html('Sending..');
            var url = $('#opportunity_stage_id').val() ? "{{ route('opportunity_stages.update', ':id') }}".replace(':id', $('#opportunity_stage_id').val()) : "{{ route('opportunity_stages.store') }}";
            var type = $('#opportunity_stage_id').val() ? "PUT" : "POST";
            $.ajax({
                url: url,
                type: type,
                data: $('#opportunityStageForm').serialize(),
                dataType: 'json',
                success: function (response) {
                    if (response.status == "success") {
                        $('#opportunityStageForm').trigger("reset");
                        $('#opportunityStageModel').modal('hide');
                        showToast('success', response.msg);
                        table.draw();
                    }
                },
                error: function (xhr) {
                    handleAjaxError(xhr);
                    $('#savedata').html(button);
                }
            });
        });
        $('body').on('click', '.editbtn', function () {
            $('.opportunity_stage_error').html('');
            var id = $(this).data('id');
            $.get("{{ route('opportunity_stages.index') }}" + '/' + id + '/edit', function (data) {
                $(".opportunity_stage_code_error").html("");
                $('#modelHeading').html("Edit Opportunity Stage");
                $('#savedata').val("edit-opportunity_stage");
                $('#savedata').html("Update Opportunity Stage");
                $('#opportunityStageModel').modal('show');
                $('#opportunity_stage_id').val(data.id);
                $('#opportunity_stage').val(data.opportunity_stage);
            });
        });
        $('body').on('click', '.deletebtn', function () {
            var id = $(this).data('id');
            confirmDelete(id, function () {
                deleteOpportunityStage(id);
            });
        });
        function deleteOpportunityStage(id) {
            var url = "{{ route('opportunity_stages.destroy', ':id') }}".replace(':id', id);
            $.ajax({
                url: url,
                type: "DELETE",
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    handleAjaxResponse(response, table);
                },
                error: function (xhr) {
                    console.error('Error:', xhr.statusText);
                    showError('Oops!', 'Failed to fetch data.');
                }
            });
        }

        $('body').on('click', '.showbtn', function () {
            var id = $(this).data('id');
            $.get("{{ route('opportunity_stages.index') }}" + '/' + id, function (data) {
                $('#modelHeading').html("Show Opportunity Stage");
                $('#savedata').val("edit-opportunity_stage");
                $('#showOpportunityStageModal').modal('show');
                $('#showOpportunityStageForm #opportunity_stage').val(data.opportunity_stage);

            });
        });

        setTimeout(() => {
            $('.dataTables_filter .form-control').removeClass('form-control-sm').css('margin-right', '20px');
            $('.dataTables_length .form-select').removeClass('form-select-sm').css('padding-left', '30px');
        }, 300);
    });

</script>
