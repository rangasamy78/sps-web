<script type="text/javascript">
  $(function() {

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    var table_opportunity = $('#datatablesOpportunity').DataTable({
      responsive: true,
      processing: true,
      serverSide: true,
      searching: false,
      ajax: {
        url: "{{ route('opportunities.list') }}",
        data: function(d) {}
      },
      columns: [{
          data: 'opportunity_code',
          name: 'opportunity_code'
        },
        {
          data: 'opportunity_date',
          name: 'opportunity_date'
        },
        {
          data: 'ship_to_name',
          name: 'ship_to_name'
        },
        {
          data: 'delivery',
          name: 'delivery'
        },
        {
          data: 'customer_1',
          name: 'customer_1'
        },
        {
          data: 'location',
          name: 'location'
        },
        {
          data: 'endUseSegment',
          name: 'endUseSegment'
        },
        {
          data: 'projectTypeName',
          name: 'projectTypeName'
        },
        {
          data: 'sales_person',
          name: 'sales_person'
        },
        {
          data: 'associates',
          name: 'associates'
        },
        {
          data: 'days',
          name: 'days'
        },
        {
          data: 'sub_transaction',
          name: 'sub_transaction'
        },
        {
          data: 'internal_notes',
          name: 'internal_notes'
        },
        {
          data: 'action',
          name: 'action',
          orderable: false,
          searchable: false
        }
      ],
      rowCallback: function(row, data, index) {

      },
      dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex align-items-center justify-content-end"B>>t<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
      buttons: [{
          text: '<i class="bx bx-plus me-sm-1"></i> <span class="d-none d-sm-inline-block">Add Opportunity</span>',
          className: 'create-new btn btn-primary',
          action: function(e, dt, node, config) {
            window.location.href = "{{ route(name: 'opportunities.create') }}";
          }
        },
        {
          extend: 'collection',
          className: 'btn btn-label-secondary dropdown-toggle mx-3',
          text: '<i class="bx bx-export me-1"></i> Export',
          buttons: [{
              extend: 'print',
              text: '<i class="bx bx-printer me-2"></i> Print',
              className: 'dropdown-item'
            },
            {
              extend: 'csv',
              text: '<i class="bx bx-file me-2"></i> CSV',
              className: 'dropdown-item'
            },
            {
              extend: 'excel',
              text: '<i class="bx bxs-file-export me-2"></i> Excel',
              className: 'dropdown-item'
            },
            {
              extend: 'pdf',
              text: '<i class="bx bxs-file-pdf me-2"></i> PDF',
              className: 'dropdown-item'
            },
            {
              extend: 'copy',
              text: '<i class="bx bx-copy me-2"></i> Copy',
              className: 'dropdown-item'
            }
          ]
        }
      ]
    });

    $('#opportunityForm input, #opportunityForm select').on('keyup change', function() {
      var inputName = $(this).attr('name');
      $('.' + inputName + '_error').html('');
    });
    $('#savedata').click(function(e) {
      e.preventDefault();
      var button = $(this);
      sending(button);
      var activeDeliveryMethod = $('#pills-tab .nav-link.active').val();
      var url = $('#opportunity_id').val() ? "{{ route('opportunities.update', ':id') }}".replace(':id', $('#opportunity_id').val()) : "{{ route('opportunities.store') }}";
      var type = $('#opportunity_id').val() ? "PUT" : "POST";
      var data = $('#opportunity_id').val() ? $('#opportunityEditForm').serialize() + "&ship_to_type=" + activeDeliveryMethod : $('#opportunityForm').serialize() + "&ship_to_type=" + activeDeliveryMethod;
      var id = $('#opportunity_id').val();
      var redirect = id ?
        "{{ route('opportunities.show', ':id') }}".replace(':id', id) :
        "{{ route('opportunities.index') }}";
      $.ajax({
        url: url,
        type: type,
        data: data,
        dataType: 'json',
        success: function(response) {
          // alert(response.msg);
          if (response.status == "success") {
            $('#supplierForm').trigger("reset");
            table_opportunity.draw();
            showToast('success', response.msg);
            window.location.href = redirect;
          }
        },
        error: function(xhr) {
          handleAjaxError(xhr);
          sending(button, true);
        }
      });
    });
    // Function to copy the billing customer name to a target field
    function copyBillingCustomer(target) {
      let billingCustomer = $('#billing_customer_name').val();
      $(target).val(billingCustomer || '');
    }
    // Function to concatenate lot and sub-division with the billing customer name
    function setCustomerWithLotAndDivision(lotSelector, subDivisionSelector, target) {
      let billingCustomer = $('#billing_customer_name').val();
      let lot = $(lotSelector).val();
      let subDivision = $(subDivisionSelector).val();
      let formattedCustomer = billingCustomer;
      if (lot || subDivision) {
        formattedCustomer += ` (${lot || ''}/${subDivision || ''})`;
      }
      $(target).val(formattedCustomer);
    }
    // Event listeners for pick and delivery operations
    $('#copy_bill_to').click(function() {
      copyBillingCustomer('#ship_to_job_name');
    });
    $('#copy_lot_division').click(function() {
      setCustomerWithLotAndDivision('#ship_to_lot', '#ship_to_sub_division', '#ship_to_job_name');
    });
    // $('#delivery_copy_bill').click(function() {
    //   copyBillingCustomer('#ship_to_job_name');
    // });
    // $('#delivery_lot_division').click(function() {
    //   setCustomerWithLotAndDivision('#ship_to_lot', '#ship_to_sub_division', '#ship_to_job_name');
    // });

    $('#ship_to_copy_bill').click(function() {
      const fields = [{
          from: 'billing_customer_id',
          to: 'ship_to_id'
        },
        {
          from: 'billing_customer_name',
          to: 'ship_to_name'
        },
        {
          from: 'address',
          to: 'ship_to_address'
        },
        {
          from: 'suite',
          to: 'ship_to_suite'
        },
        {
          from: 'city',
          to: 'ship_to_city'
        },
        {
          from: 'state',
          to: 'ship_to_state'
        },
        {
          from: 'zip',
          to: 'ship_to_zip'
        },
        {
          from: 'country',
          to: 'ship_to_country_id'
        },
        {
          from: 'phone',
          to: 'ship_to_phone'
        },
        {
          from: 'fax',
          to: 'ship_to_fax'
        },
        {
          from: 'mobile',
          to: 'ship_to_mobile'
        },
        {
          from: 'email',
          to: 'ship_to_email'
        }
      ];

      // Loop through each field and copy the values
      fields.forEach(({
        from,
        to
      }) => {
        $(`#${to}`).val($(`#${from}`).val());
      });
    });
    //ship to fields hide and show
    document.querySelectorAll('[data-bs-toggle="pill"]').forEach(button => {
      button.addEventListener('click', () => {
        const type = button.getAttribute('data-type');
        document.querySelectorAll('.conditional-fields').forEach(field => field.classList.add('d-none'));
        document.querySelector(`#${type}-fields`).classList.remove('d-none');
      });
    });


  });
</script>