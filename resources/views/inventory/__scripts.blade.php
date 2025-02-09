<script type="text/javascript">
    $(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

 
    var table = $('#datatable').DataTable({
    responsive: true,
    processing: true,
    serverSide: true,
    searching: false,
    order: [
        [0, 'desc']
    ],
    ajax: {
        url: "{{ route('inventories.list') }}",
        data: function(d) {
            sort = (d.order[0].dir == 'asc') ? "asc" : "desc";
            d.order = [{
                column: 1,
                dir: sort
            }];
        }
    },
    columns: [
        {
            data: null,
            name: 'serial',
            orderable: false,
            searchable: false
        },
        {
            data: 'product_name',
            name: 'product_name'
        },
        {
            data: 'inventory',
            name: 'inventory'
        },
        {
            data: 'product_type_id',
            name: 'product_type_id'
        },
        {
            data: 'product_category_id',
            name: 'product_category_id'
        },
        {
            data: 'product_origin',
            name: 'product_origin'
        },
        {
            data: 'product_colors',
            name: 'product_colors'
        },
        {
            data: 'product_group_id',
            name: 'product_group_id'
        },
        {
            data: 'action',
            name: 'action',
            orderable: false,
            searchable: false
        }
    ],
    rowCallback: function(row, data, index) {
    $('td:eq(0)', row).html(table.page.info().start + index + 1);

    $(row).on('click', function () {
        var product_id = data.product_id; 
        var rowIndex = $(this).index();
        var rowDetail = $('#details-' + rowIndex);

        if (!rowDetail.length) {
            var url = "{{ route('fetch_supplier_slab_details', ':id') }}";
            url = url.replace(':id', product_id);

            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    var slabsBySipl = {}; // Grouped data by sipl_id
                    var detailsRow = '<tr id="details-' + rowIndex + '"><td colspan="9">';
                    detailsRow += '<table class="table table-bordered">';
                    detailsRow += '<tr>';
                    detailsRow += '<td><strong>Serial Num</strong></td>';
                    detailsRow += '<td> </td>';
                    detailsRow += '<td><strong>Lot/Block</strong></td>';
                    detailsRow += '<td><strong>Bundle</strong></td>';
                    detailsRow += '<td><strong>Supp. Ref</strong></td>';
                    detailsRow += '<td><strong>Present Location</strong></td>';
                    detailsRow += '<td><strong>Bin</strong></td>';
                    detailsRow += '<td><strong>Quantity</strong></td>';
                    detailsRow += '<td><strong>P</strong></td>';
                    detailsRow += '<td><strong>N</strong></td>';
                    detailsRow += '<td><strong>D</strong></td>';
                    detailsRow += '</tr>';
                    
                    var lastSiplId = null;
                    response.data.forEach(function (item, index) {
                        // If new sipl_id, store last one and insert total before switching
                        if (lastSiplId !== null && lastSiplId !== item.sipl_id) {
                            var slabData = slabsBySipl[lastSiplId];
                            detailsRow += '<tr style="background-color: #f8f9fa; font-weight: bold;">';
                            detailsRow += '<td colspan="7">Total ' + slabData.totalSlabs + ' Slabs (SIPL ID: ' + lastSiplId + ')</td>';
                            detailsRow += '<td colspan="4">' + slabData.totalSF.toFixed(2) + ' SF</td>';
                            detailsRow += '</tr>';
                        }

                        // Add row data
                        detailsRow += '<tr>';
                        detailsRow += '<td>' + item.serial_no + '</td>';
                        detailsRow += '<td>' + item.bar_code_no + '</td>';
                        detailsRow += '<td>' + item.lot_block + '</td>';
                        detailsRow += '<td>' + item.bundle + '</td>';
                        detailsRow += '<td>' + item.supplier_ref + '</td>';
                        detailsRow += '<td>' + item.present_location + '</td>';
                        detailsRow += '<td>' + item.bin_type_name + '</td>';
                        detailsRow += '<td>' + item.received_sizes + '</td>';
                        detailsRow += '<td></td>';
                        detailsRow += '<td></td>';
                        detailsRow += '<td></td>';
                        detailsRow += '</tr>';

                        // Group received_sizes by sipl_id
                        if (item.sipl_id) {
                            if (!slabsBySipl[item.sipl_id]) {
                                slabsBySipl[item.sipl_id] = {
                                    totalSlabs: 0,
                                    totalSF: 0
                                };
                            }
                            slabsBySipl[item.sipl_id].totalSlabs++;
                            slabsBySipl[item.sipl_id].totalSF += parseFloat(item.received_sizes || 0);
                        }

                        // Store last sipl_id to track changes
                        lastSiplId = item.sipl_id;
                    });

                    // Ensure last sipl_id total row is inserted
                    if (lastSiplId !== null) {
                        var slabData = slabsBySipl[lastSiplId];
                        detailsRow += '<tr style="background-color: #f8f9fa; font-weight: bold;">';
                        detailsRow += '<td colspan="7">Total ' + slabData.totalSlabs + ' Slabs (SIPL ID: ' + lastSiplId + ')</td>';
                        detailsRow += '<td colspan="4">' + slabData.totalSF.toFixed(2) + ' SF</td>';
                        detailsRow += '</tr>';
                    }

                    detailsRow += '</table></td></tr>';
                    $(row).after(detailsRow);
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching details:', error);
                    alert('Failed to fetch details. Please try again.');
                }
            });
        } else {
            rowDetail.toggle();
        }
    });
}

});



        $('#productColorForm input').on('input', function() {
            let fieldName = $(this).attr('name');
            $('.' + fieldName + '_error').text('');
        })
        $('#savedata').click(function(e) {
            e.preventDefault();
            var button = $(this);
            sending(button);
            var url = $('#inventory_id').val() ? "{{ route('inventories.update', ':id') }}".replace(':id', $('#inventory_id').val()) : "{{ route('inventories.store') }}";
            var type = $('#inventory_id').val() ? "PUT" : "POST";
            $.ajax({
                url: url,
                type: type,
                data: $('#productColorForm').serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status == "success") {
                        $('#productColorForm').trigger("reset");
                        $('#productColorModel').modal('hide');
                        showToast('success', response.msg);
                        table.draw();
                    }
                },
                error: function(xhr) {
                    handleAjaxError(xhr);
                    sending(button, true);
                }
            });
        });
    
        $('body').on('click', '.deletebtn', function() {
            var id = $(this).data('id');
            confirmDelete(id, function() {
                deleteInventory(id);
            });
        });

        function deleteInventory(id) {
            var url = "{{ route('inventories.destroy', ':id') }}".replace(':id', id);
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

    });
</script>