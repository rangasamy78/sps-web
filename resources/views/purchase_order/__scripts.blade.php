<script type="text/javascript">
$(function() {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
   
    $('#purchaseOrderForm').on('input change', 'input, select', function() {
        let fieldName = $(this).attr('name');
        $('.' + fieldName + '_error').text('');
    });

    $('#purchaseOrderForm').on('input change', 'input[type="date"]', function() {
        let fieldName = $(this).attr('name');
        $('.' + fieldName + '_error').text('');
    });


    $('#shipment_term_id').select2({
            placeholder: 'Select Shipment Terms',
            dropdownParent: $('#shipment_term_id').parent()
    });

    $('#supplier_id').select2({
            placeholder: 'Select Supplier',
            dropdownParent: $('#supplier_id').parent()
    });

    $('#supplier_address_id').select2({
            placeholder: 'Select Address',
            dropdownParent: $('#supplier_address_id').parent()
    });

    $('#country_id').select2({
            placeholder: 'Select Country',
            dropdownParent: $('#country_id').parent()
    });

    $('#payment_term_id').select2({
            placeholder: 'Select Payment Terms',
            dropdownParent: $('#payment_term_id').parent()
    });
    $('#purchase_location_id').select2({
            placeholder: 'Select Location',
            dropdownParent: $('#purchase_location_id').parent()
    });

    $('#purchase_location_country_id').select2({
            placeholder: 'Select Country',
            dropdownParent: $('#purchase_location_country_id').parent()
    });
    $('#ship_to_location_id').select2({
            placeholder: 'Select Location',
            dropdownParent: $('#ship_to_location_id').parent()
    });
    $('#ship_to_location_country_id').select2({
            placeholder: 'Select Country',
            dropdownParent: $('#ship_to_location_country_id').parent()
    });
    $('#pre_purchase_term_id').select2({
            placeholder: 'Select P.O.Terms',
            dropdownParent: $('#pre_purchase_term_id').parent()
    });

    $('#freight_forwarder_id').select2({
            placeholder: 'Select Freight Forwarder',
            dropdownParent: $('#freight_forwarder_id').parent()
    });

    $('#departure_port_id').select2({
            placeholder: 'Select Departure Port',
            dropdownParent: $('#departure_port_id').parent()
    });  $('#arrival_port_id').select2({
            placeholder: 'Select Arrival Port',
            dropdownParent: $('#arrival_port_id').parent()
    });

    $('#discharge_port_id').select2({
            placeholder: 'Select Discharge Port',
            dropdownParent: $('#discharge_port_id').parent()
    });  $('#special_instruction_id').select2({
            placeholder: 'Select Special Instructions',
            dropdownParent: $('#special_instruction_id').parent()
    });
    $('#closePOBtn').click(function() {
    
      if (confirm("Are you sure you want to Close this PO?")) {

        var po_id = $("#po_id").val();
       
            if (po_id) {
                var url = "{{ route('close_po', ':id') }}";
                url = url.replace(':id', po_id);
                $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        $("#po_status").val('Closed');
                        var approved_state = $('#approved_state_val').val();
                            

                            $("#closePOBtn, #addMoreLinesBtn, #prepayment-btn, #product_supplier").hide();

                            if (approved_state === "0") {
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
                            }
                            else{

                            }

                       
       
                    },
                    error: function(xhr, status, error) {
                        console.log('Error:', error);
                    }
                });
            }

            }
                
    });
    $(document).ready(function () {
    var po_status = $("#po_status").val();

    function updateStatusBar(status) {
        $(".status-item").removeClass("active").addClass("inactive");
        
        if (status === "Pending") {
            $("#pendingStatus").removeClass("inactive").addClass("active");
        } else if (status === "Fulfilled") {
            $("#fulfilledStatus").removeClass("inactive").addClass("active");
        } else if (status === "Closed") {
            $("#closedStatus").removeClass("inactive").addClass("active");
        }
    }

    
    updateStatusBar(po_status);

    if (po_status === "Closed") {
     
        $("#closePOBtn, #addMoreLinesBtn, #prepayment-btn, #product_supplier").hide();
    } else {
        $("#closePOBtn, #addMoreLinesBtn, #prepayment-btn, #product_supplier").show();
    }

   
    $("#closePOBtn").click(function () {
        po_status = "Closed";
        $("#po_status").val(po_status);
        updateStatusBar(po_status);
        if (po_status === "Closed") {
            $(this).hide();
        }
    });
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
                data: 'age',
                name: 'age'
            },
            {
                data: 'supplier_so_number',
                name: 'supplier_so_number'
            },
            {
                data: 'inventory_supplier',
                name: 'inventory_supplier'
            },
            {
                data: 'supplier_type',
                name: 'supplier_type'
            },
          
            {
                data: 'purchase_location',
                name: 'purchase_location'
            },
            {
                data: 'ship_location',
                name: 'ship_location'
            },
          

            {
                data: 'approval_status',
                name: 'approval_status'
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
        },
        dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex align-items-center justify-content-end"fB>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
        buttons: [{
            text: '<span class="d-none d-sm-inline-block">New Purchase Order</span>',
            className: 'btn btn-primary me-2',
            attr: {
                id: 'product',
            },
            action: function(e, dt, node, config) {
                window.location.href = "{{ route('purchase_orders.create') }}";
            }
        }, ],
    });



    $('body').on('click', '.deletebtn', function() {
       
       var id = $(this).data('id');
       confirmDelete(id, function() {
           deletePO(id);
       });
   });

   function deletePO(id) {
       var url = "{{ route('purchase_orders.destroy', ':id') }}".replace(':id', id);
       $.ajax({
           url: url,
           type: "DELETE",
           data: {
               id: id,
               _token: '{{ csrf_token() }}'
           },
           success: function(response) {

                   window.location.href = "{{ route('purchase_orders.index') }}";
           },
           error: function(xhr) {
               console.error('Error:', xhr.statusText);
               showError('Oops!', 'Failed to fetch data.');
           }
       });
   }


    const fullToolbar = [
      [{
          font: []
        },
        {
          size: []
        }
      ],
      ['bold', 'italic', 'underline', 'strike'],
      [{
          color: []
        },
        {
          background: []
        }
      ],
      [{
          script: 'super'
        },
        {
          script: 'sub'
        }
      ],
      [{
          header: '1'
        },
        {
          header: '2'
        },
        'blockquote',
        'code-block'
      ],
      [{
          list: 'ordered'
        },
        {
          list: 'bullet'
        },
        {
          indent: '-1'
        },
        {
          indent: '+1'
        }
      ],
      [{
        direction: 'rtl'
      }],
      
      ['clean']
    ];
    const descriptionEditor = new Quill('#descriptionEditor', {
      bounds: '#descriptionEditor',
      placeholder: 'Type Description...',
      modules: {
        formula: true,
        toolbar: fullToolbar
      },
      theme: 'snow',
    });

    descriptionEditor.on('text-change', function() {
      document.getElementById('description').value = descriptionEditor.root.innerHTML;
    });

    function clearEditor() {
      descriptionEditor.setContents([]);
    }

    
    
    $('#pre_purchase_term_id').on('change', function() {

            var selectId = $(this).val();

            if (selectId) {
                var url = "{{ route('fetch_policy', ':id') }}";
                url = url.replace(':id', selectId);
              

                $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                       
                        descriptionEditor.root.innerHTML = response.policy;
                        
                            $('#terms').val(response.policy)
                       
                    },
                    error: function(xhr, status, error) {
                        console.log('Error:', error);
                    }
                });
            }
        }); 
        
        $(document).ready(function() {
        $('#supplier_id').on('change', function() {
            var SupplierId = $(this).val();

            if (SupplierId) {
                var url = "{{ route('fetch_supplier_details', ':id') }}";
                url = url.replace(':id', SupplierId);
                $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                        
                            $('#supplier_address').val(response.data.ship_address)
                                .prop('readonly', true);
                            $('#supplier_suite').val(response.data.ship_suite).prop(
                                'readonly', true);
                            $('#supplier_city').val(response.data.ship_city).prop(
                                'readonly', true);
                            $('#supplier_state').val(response.data.ship_state).prop(
                                'readonly', true);
                            $('#supplier_zip').val(response.data.ship_zip).prop('readonly',
                                true);
                            $('#supplier_country_id').val(response.data.ship_country_id)
                                .trigger('change')
                                .prop('readonly', true);
                            $('#payment_term_id').val(response.data
                                .payment_terms_id).trigger('change');
                        } else {
                            alert('Supplier details not found.');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log('Error:', error);
                    }
                });
            }
        });

        $('#purchase_location_id').on('change', function() {
            var locationId = $(this).val();
            if (locationId) {
                var url = "{{ route('purchase_location_details', ':id') }}";
                url = url.replace(':id', locationId);
                $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                       
                            $('#purchase_location_address').val(response.data.address)
                                .prop('readonly', true);
                            $('#purchase_location_suite').val(response.data.address_2).prop(
                                'readonly', true);
                            $('#purchase_location_city').val(response.data.city).prop(
                                'readonly', true);
                            $('#purchase_location_state').val(response.data.state).prop(
                                'readonly', true);
                            $('#purchase_location_zip').val(response.data.zip).prop('readonly',
                                true);
                            $('#purchase_location_country_id').val(response.data.country_id)
                            .trigger('change')
                           
                           
                        } else {
                            alert(' details not found.');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log('Error:', error);
                    }
                });
            }
        });


        $('#ship_to_location_id').on('change', function() {
            
            var locationId = $(this).val();
            if (locationId) {
                var url = "{{ route('ship_location_details', ':id') }}";
                url = url.replace(':id', locationId);
                $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        
                        if (response.success) {
                         
                            $('#ship_to_location_address').val(response.data.shipping_address)
                                .prop('readonly', true);
                            $('#ship_to_location_attn').val(response.data.shipping_address_2).prop(
                                'readonly', true);
                            $('#ship_to_location_suite').val(response.data.shipping_address_2).prop(
                                'readonly', true);
                            $('#ship_to_location_city').val(response.data.shipping_city).prop(
                                'readonly', true);
                            $('#ship_to_location_state').val(response.data.shipping_state).prop(
                                'readonly', true);
                            $('#ship_to_location_zip').val(response.data.shipping_zip).prop('readonly',
                                true);
                            $('#ship_to_location_country_id').val(response.data.shipping_country_id)
                            .trigger('change')
                           
                        } else {
                            alert(' details not found.');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log('Error:', error);
                    }
                });
            }
        });





    });
        
    $('#savedata').click(function(e) {
        e.preventDefault();
        var button = $(this);
        sending(button);
        var url = $('#purchase_order_id').val() ? "{{ route('purchase_orders.update', ':id') }}"
            .replace(':id', $('#purchase_order_id').val()) : "{{ route('purchase_orders.store') }}";
        var type = $('#purchase_order_id').val() ? "PUT" : "POST";
        $.ajax({
            url: url,
            type: type,
            data: $('#purchaseOrderForm').serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.status == "success") {
                    $('#purchaseOrderForm').trigger("reset");
                    $('#purchaseOrderModel').modal('hide');
                    showToast('success', response.msg);
                    table.draw();
                    var id = response.id;
                    window.location.href =
                        "{{ route('purchase_orders.purchase_details', ':id') }}".replace(
                            ':id', id);
                }
            },
            error: function(xhr) {
                handleAjaxError(xhr);
                sending(button, true);
            }
        });
    });


   








});
</script>