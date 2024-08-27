<script type="text/javascript">
    $(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#endUseSegmentFilter').on('keyup change', function(e) {
            e.preventDefault();
            table.draw();
        });
        
        var table = $('#endUseSegmentTable').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            searching: false,
            order: [
                [1, 'desc']
            ],
            ajax: {
                url: "{{ route('end_use_segments.list') }}",
                data: function(d) {
                    d.end_use_segment_search = $('#endUseSegmentFilter').val();
                    sort = (d.order[0].dir == 'asc') ? "asc" : "desc";
                    d.order = [{
                        column: 1,
                        dir: sort
                    }];
                }
            },
            columns: [{
                    data: null,
                    name: 'serial',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'end_use_segment',
                    name: 'end_use_segment'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
            rowCallback: function(row, data, index) {
                $('td:eq(0)', row).html(table.page.info().start + index + 1); // Update the index column with the correct row index
            },
            dom: '<"card-header flex-column flex-md-row"<"head-label text-center"><"dt-action-buttons text-end pt-3 pt-md-0"B>><"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            buttons: [{
                text: '<i class="bx bx-plus me-sm-1"></i> <span class="d-none d-sm-inline-block" >Add End Use Segment</span>',
                className: 'create-new btn btn-primary',
                attr: {
                    'data-bs-toggle': 'modal',
                    'data-bs-target': '#endUseSegmentModel',
                    'id': 'createBin',
                },
                action: function(e, dt, node, config) {
                    // Custom action for Add New Record button
                    $('#savedata').html("Save End Use Segment");
                    $('#end_use_segment_id').val('');
                    $('#endUseSegmentForm').trigger("reset");
                    $(".end_use_segment_error").html("");
                    $('#modelHeading').html("Create New End Use Segment");
                    $('#endUseSegmentModel').modal('show');
                }
            }],


        });

        $('#end_use_segment').on('input', function() {
            $('.end_use_segment_error').text('');
        });

        $('#savedata').click(function(e) {
            e.preventDefault();
            var button = $(this);
            sending(button);
            var url = $('#end_use_segment_id').val() ? "{{ route('end_use_segments.update', ':id') }}".replace(':id', $('#end_use_segment_id').val()) : "{{ route('end_use_segments.store') }}";
            var type = $('#end_use_segment_id').val() ? "PUT" : "POST";
            $.ajax({
                url: url,
                type: type,
                data: $('#endUseSegmentForm').serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        $('#endUseSegmentForm').trigger("reset");
                        $('#endUseSegmentModel').modal('hide');
                        showToast('success', response.msg);
                        table.draw();
                    }
                },
                error: function(xhr) {
                    handleAjaxError(xhr);
                    sending(button,true);
                }
            });
        });
        $('body').on('click', '.editbtn', function() {
            var id = $(this).data('id');
            $(".end_use_segment_error").html("");
            $.get("{{ route('end_use_segments.index') }}" + '/' + id + '/edit', function(data) {
                $('#modelHeading').html("Update End Use Segment");
                $('#savedata').val("edit-end-use-segment");
                $('#savedata').html("Update End Use Segment");
                $('#endUseSegmentModel').modal('show');
                $('#end_use_segment_id').val(data.id);
                $('#end_use_segment').val(data.end_use_segment);
            });
        });

        $('body').on('click', '.deletebtn', function() {
            var id = $(this).data('id');
            confirmDelete(id, function() {
                deleteProbabilityToClose(id);
            });
        });

        function deleteProbabilityToClose(id) {
            var url = "{{ route('end_use_segments.destroy', ':id') }}".replace(':id', id);
            $.ajax({
                url: url,
                type: "DELETE",
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    handleAjaxResponse(response, table);
                },
                error: function(xhr) {
                    console.error('Error:', xhr.statusText);
                    showError('Oops!', 'Failed to fetch data.');
                }
            });
        }
        $('body').on('click', '.showbtn', function() {
            var id = $(this).data('id');
            $.get("{{ route('end_use_segments.index') }}" + '/' + id, function(data) {
                $('#showEndUseSegmentModal').modal('show');
                $('#endUseSegmentShowForm #end_use_segment').val(data.end_use_segment);
            });
        });
    });
</script>
