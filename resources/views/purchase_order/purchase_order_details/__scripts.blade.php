<script type="text/javascript">
    
$(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
           
var poId = $('#po_id').val();
var approved_state = $('#approved_state').val();
var approval_status = $('#approval_status').val();
var approval_date = $('#approval_date').val();
var approval_note = $('#approval_note').val();
var po_status = $("#po_status").val();


if (po_status === "Closed") {
   
    const closedMessage = `
        <div style="padding: 20px; border: 1px solid #ccc; width: 320px; text-align: center; font-family: Arial, sans-serif;">
            <p>
                <strong>Approval Status:</strong><br>
                This PO needed approval because the PO total is &gt; $5,000.00.
            </p>
        </div>
    `;
    $('#parent-container').html(closedMessage);
    $('#product_supplier').hide(); 
} else if (approval_status === 'Disapprove' && approved_state == 0) {
    const approvalDiv = `
        <div style="padding: 20px; border: 1px solid #ccc; width: 300px; text-align: center;">
            <p>
                <strong>Approval Status!</strong><br>
                This PO needs approval because the PO total is &gt; $5,000.00.
            </p>
            <button class="btn-approve" id="approvebtn" style="margin: 5px; padding: 10px; background-color: green; color: white; border: none; cursor: pointer;" 
                onclick="handleApproval(true)">
                Approve
            </button>
            <button class="btn-disapprove" id="disapprove" style="margin: 5px; padding: 10px; background-color: red; color: white; border: none; cursor: pointer;" 
                onclick="handleApproval(false)">
                Disapprove
            </button>
        </div>
    `;
    $('#parent-container').html(approvalDiv);
    setTimeout(function() {
        $('#product_supplier').hide();
    }, 500);

} else if (approval_status === 'Disapprove' && approved_state == 1) {
    const approvalDivP = `
        <div style="padding: 20px; border: 1px solid #ccc; width: 320px; text-align: center; font-family: Arial, sans-serif;">
            <p>
                <strong>Disapproval Status:</strong><br>
                This PO needed approval because the PO total is &gt; $5,000.00.<br><br>
                <strong>PO Disapproved on:</strong> ${approval_date} by .<br>
                <strong>Disapproved Notes:</strong> ${approval_note}
            </p>
        </div>
    `;
    $('#product_supplier').show();
    $('#parent-container').html(approvalDivP);
    $('#approved_state_val').val(1);


    setTimeout(function() {
        $('#product_supplier').hide();
    }, 500);

} else if (approval_status === 'Approve' && approved_state == 1) {
    const approvalDivP = `
        <div style="padding: 20px; border: 1px solid #ccc; width: 320px; text-align: center; font-family: Arial, sans-serif;">
            <p>
                <strong>Approval Status:</strong><br>
                This PO needed approval because the PO total is &gt; $5,000.00.<br><br>
                <strong>PO Approved on:</strong> ${approval_date} by .<br>
                <strong>Approved Notes:</strong> ${approval_note}
            </p>
        </div>
    `;
    $('#product_supplier').show();
    $('#parent-container').html(approvalDivP);
    $('#approved_state_val').val(1);

    setTimeout(function() {
        $('#product_supplier').show();
    }, 500);

} else {
    $('#parent-container').html('');
}



$(document).on('click', '#approvebtn', function() {
   
    var approval_note = $('#approval_note').val();
   
    Swal.fire({
        title: 'Approve PO',
        html: `
            <p>Date: ${new Date().toLocaleDateString()}</p>
            <p>Approved By: </p>
            <textarea id="approval-notes" class="swal2-textarea" placeholder="Add your notes here...">${approval_note}</textarea>
        `,
        showCancelButton: true,
        confirmButtonText: 'Approve',
        cancelButtonText: 'Cancel',
        preConfirm: () => {
            const notes = document.getElementById('approval-notes').value;
            if (!notes) {
                Swal.showValidationMessage('Notes are required!');
                return false;
            }
            return notes;
        }
    }).then((details) => {
        if (details.isConfirmed) {
            const notes = details.value;  

           
            $.ajax({
                url: "{{ route('update_po_status') }}", 
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    po_id: poId, 
                    status: 'Approve',
                    notes: notes
                },
                success: (response) => {
                    
                    const currentDate = new Date();
                    const options = {
                        weekday: 'short',
                        year: 'numeric',
                        month: 'short',
                        day: 'numeric',
                        hour: 'numeric',
                        minute: 'numeric',
                        hour12: true
                    };
                    const formattedDate = currentDate.toLocaleString('en-US', options);
                    const approverName = ""; 

                    
                    const approvalDivP = `
                        <div style="padding: 20px; border: 1px solid #ccc; width: 320px; text-align: center; font-family: Arial, sans-serif;">
                            <p>
                                <strong>Approval Status:</strong><br>
                                This PO needed approval because the PO total is &gt; $5,000.00.<br><br>
                                <strong>PO Approved on:</strong> ${formattedDate} by ${approverName}.<br>
                                <strong>Approved Notes:</strong> ${notes}
                            </p>
                        </div>
                    `;

                    $('#product_supplier').show();
                    $('#parent-container').html(approvalDivP);
                },
                error: (error) => {
                    Swal.fire('Error', 'Failed to update approval status.', 'error');
                }
            });
        }
    });
});


$(document).on('click', '#disapprove', function() {
    var approval_note = $('#approval_note').val();
    Swal.fire({
        title: 'Disapprove PO',
        html: `
            <p>Date: ${new Date().toLocaleDateString()}</p>
            <p>Disapproved By: </p>
            <textarea id="disapproval-notes" class="swal2-textarea" placeholder="Add your notes here...">${approval_note}</textarea>
        `,
        showCancelButton: true,
        confirmButtonText: 'Disapprove',
        cancelButtonText: 'Cancel',
        preConfirm: () => {
            const notes = document.getElementById('disapproval-notes').value;
            if (!notes) {
                Swal.showValidationMessage('Notes are required!');
                return false;
            }
            return notes;
        }
    }).then((details) => {
        if (details.isConfirmed) {
            const notes = details.value; 
            
            $.ajax({
                url: "{{ route('update_po_status') }}",
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    po_id: poId, 
                    status: 'Disapprove',
                    notes: notes
                },
                success: (response) => {
                    
                    const currentDate = new Date();
                    const options = {
                        weekday: 'short',
                        year: 'numeric',
                        month: 'short',
                        day: 'numeric',
                        hour: 'numeric',
                        minute: 'numeric',
                        hour12: true
                    };
                    const formattedDate = currentDate.toLocaleString('en-US', options);
                    
                    const disapproverName = "Surya (IT)";
                    const disapprovalDivP = `
                        <div style="padding: 20px; border: 1px solid #ccc; width: 320px; text-align: center; font-family: Arial, sans-serif;">
                            <p>
                                <strong>Approval Status:</strong><br>
                                This PO needed Approval because the PO total is &gt; $5,000.00.<br><br>
                                <strong>PO Disapproved on:</strong> ${formattedDate} by ${disapproverName}.<br>
                                <strong>Disapproved Notes:</strong> ${notes}
                            </p>
                        </div>
                    `;
                                        
                    $('#parent-container').html(disapprovalDivP);
                    
                    
                },
                error: (error) => {
                    Swal.fire('Error', 'Failed to update disapproval status.', 'error');
                }
            });
        }
    });
});

document.getElementById('addMoreLinesBtn').addEventListener('click', function() {
        var poId = $('#po_id').val(); 
        var url = "{{ route('purchase_orders.purchase_details', ':id') }}"; 
        url = url.replace(':id', poId); 
        window.location.href = url; 
    });


    var table = $('#supplierInvoiceTable').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        searching: false,
        order: [
            [0, 'desc']
        ],
        ajax: {
            url: "{{ route('purchase_orders.list') }}",
            data: function(d) {
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
                data: 'po_number',
                name: 'po_number'
            },
            {
                data: 'po_date',
                name: 'po_date'
            },
            {
                data: 'required_ship_date',
                name: 'required_ship_date'
            },
            {
                data: 'supplier_so_number',
                name: 'supplier_so_number'
            },
            {
                data: 'supplier_id',
                name: 'supplier_id'
            },
            {
                data: 'container_number',
                name: 'container_number'
            },
            {
                data: 'payment_term_id',
                name: 'payment_term_id'
            }, {
                data: 'po_number',
                name: 'po_number'
            }
        ],
        rowCallback: function(row, data, index) {
            $('td:eq(0)', row).html(table.page.info().start + index + 1);
        },
        dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex align-items-center justify-content-end"fB>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
        buttons: [{
            text: '<span class="d-none d-sm-inline-block">Supplier Invoice/Packing List</span>',
            className: 'btn btn-primary me-2',
            attr: {
                id: 'product_supplier',
            },
            action: function(e, dt, node, config) {
                var poId = $('#po_id').val();

                window.location.href = "{{ route('supplier_invoice.create', ':id') }}"
                    .replace(':id', poId);

            }
        }, ],
    });
    

});
</script>