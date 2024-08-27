<script type="text/javascript">
  $(function() {
    $("#showDescriptionEditor").attr('disabled', true);

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    $('#shipmentTermsFilter').on('keyup change', function(e) {
            e.preventDefault();
            table.draw();
    });
    
    var table = $('#shipmentTermTable').DataTable({
      responsive: true,
      processing: true,
      serverSide: true,
      searching: false,
      order: [
        [0, 'desc']
      ],
      ajax: {
        url: "{{ route('shipment_terms.list') }}",
        data: function(d) {
          d.shipment_terms_search = $('#shipmentTermsFilter').val();
          sort = (d.order[0].dir == 'asc') ? "asc" : "desc";
          d.order = [{
            column: 0,
            dir: sort
          }];
        }
      },
      columns: [{
          data: 'id',
          name: 'id',

        }, {
          data: 'shipment_term_name',
          name: 'shipment_term_name'
        },
        {
          data: 'description',
          name: 'description'
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
      // displayLength: 7,
      // lengthMenu: [7, 10, 25, 50, 75, 100],
      buttons: [{
        text: '<i class="bx bx-plus me-sm-1"></i> <span class="d-none d-sm-inline-block" >Create Shipment Term</span>',
        className: 'create-new btn btn-primary',
        attr: {
          'data-bs-toggle': 'modal',
          'data-bs-target': '#shipmentTermModel',
          'id': 'createBin',
        },
        action: function(e, dt, node, config) {
          $('#savedata').html("Save Shipment Term");
          $('#shipment_term_id').val('');
          $('#shipmentTermForm').trigger("reset");
          $('.shipment_term_name_error').html('');
          $('.description_error').html('');
          clearEditor();
          $('#modelHeading').html("Create New Shipment Term");
          $('#shipmentTermModel').modal('show');
        }
      }],
    });

    $('#shipmentTermForm input').on('input', function() {
      let fieldName = $(this).attr('name');
      $('.' + fieldName + '_error').text('');
    });

    $('#savedata').click(function(e) {
      e.preventDefault();
      $(this).html('Sending..');
      var url = $('#shipment_term_id').val() ? "{{ route('shipment_terms.update', ':id') }}".replace(':id', $('#shipment_term_id').val()) : "{{ route('shipment_terms.store') }}";
      var type = $('#shipment_term_id').val() ? "PUT" : "POST";
      $.ajax({
        url: url,
        type: type,
        data: $('#shipmentTermForm').serialize(),
        dataType: 'json',
        success: function(response) {
          if (response.status == "success") {
            $('#shipmentTermForm').trigger("reset");
            $('#shipmentTermModel').modal('hide');
            showToast('success', response.msg);
            table.draw();
          }
        },
        error: function(xhr) {
          handleAjaxError(xhr);
          var button = type === 'POST' ? 'Save Shipment Term' : 'Update Shipment Term';
          $('#savedata').html(button);
        }
      });
    });

    $('body').on('click', '.editbtn', function() {
      var id = $(this).data('id');
      $.get("{{ route('shipment_terms.index') }}" + '/' + id + '/edit', function(data) {
        $(".shipment_term_name_error").html("");
        $(".description_error").html("");
        $('#modelHeading').html("Edit Shipment Term");
        $('#savedata').val("edit-shipment-term");
        $('#savedata').html("Update Shipment Term");
        $('#shipmentTermModel').modal('show');
        $('#shipment_term_id').val(data.id);
        $('#shipment_term_name').val(data.shipment_term_name);
        $('#description').val(data.description);
        descriptionEditor.root.innerHTML = data.description;
      });
    });


    $('body').on('click', '.deletebtn', function() {
      var id = $(this).data('id');
      confirmDelete(id, function() {
        deleteShipmentTerm(id);
      });
    });

    function deleteShipmentTerm(id) {
      var url = "{{ route('shipment_terms.destroy', ':id') }}".replace(':id', id);

      $.ajax({
        url: url,
        type: "DELETE",
        data: {
          id: id,
          _token: '{{ csrf_token() }}'
        },
        success: function(response) {
          if (response.status === "success") {
            handleAjaxResponse(response, table);
          } else {
            showError('Deleted!', response.msg);
          }
        },
        error: function(xhr) {
          console.error('Error:', xhr.statusText);
          showError('Oops!', 'Failed to fetch data.');
        }
      });
    }

    $('body').on('click', '.showbtn', function() {
      var id = $(this).data('id');
      $.get("{{ route('shipment_terms.index') }}" + '/' + id, function(data) {
        $('#showShipmentTermModal').modal('show');
        $('#showShipmentTermForm #shipment_term_name').val(data.shipment_term_name);
        $('#showShipmentTermForm #description').val(data.description);
        showDescriptionEditor.root.innerHTML = data.description;
      });
    });

    setTimeout(() => {
      $('.dataTables_filter .form-control').removeClass('form-control-sm').css('margin-right', '20px');
      $('.dataTables_length .form-select').removeClass('form-select-sm').css('padding-left', '30px');
    }, 300);
    //Description Editor
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
      // ['link', 'image', 'video', 'formula'],
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
      descriptionEditor.setContents([]); // Clear all content
    }

    const showDescriptionEditor = new Quill('#showDescriptionEditor', {
      bounds: '#showDescriptionEditor',
      modules: {
        formula: true,
        toolbar: fullToolbar
      },
      theme: 'snow',
    });
    showDescriptionEditor.enable(false);
  });
</script>
