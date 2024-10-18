<script type="text/javascript">
  $(function() {

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    var table_opportunity = $('#datatablesOpportunity').DataTable({
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

  });
</script>