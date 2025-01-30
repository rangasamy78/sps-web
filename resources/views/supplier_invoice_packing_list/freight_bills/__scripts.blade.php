<script type="text/javascript">
    $(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
     

             
});
        
$(document).ready(function () {
    
    let po_id = $('#po_id').val();
   
    if (po_id) {
        var url = "{{ route('fetch_bills_data', ':id') }}";
        url = url.replace(':id', po_id);

        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
               
                if (response.success) {
                    let data = response.data;
                  

                    let tbody = $('#freightBills');
                    tbody.empty();

                    if (data && data.length > 0) {
                        data.forEach((item) => {
                            let row = `
                                <tr>
                                    <td>${item.invoice_number || ''}</td>
                                    <td>${item.invoice_date || ''}</td>
                                    <td>${item.supplier_name || ''}</td>
                                    <td>${item.extended_total || ''}</td>
                                     <td>${item.extended_total || ''}</td>
                                    
                                    
                                </tr>`;
                            tbody.append(row); 
                        });
                    } else {
                       
                        tbody.append(`<tr><td colspan="11" class="text-center">No data found.</td></tr>`);
                    }

                } else {
                    alert('Details not found.');
                }
            },
            error: function(xhr, status, error) {
                console.log('Error:', error);
            }
        });
    }
});


$(document).ready(function () {
    
    let po_id = $('#po_id').val();
    if (po_id) {
          var url = "{{ route('fetch_product_details', ':id') }}";
          url = url.replace(':id', po_id);

          $.ajax({
              url: url,
              type: 'GET',
              dataType: 'json',
              success: function(response) {
    if (response.success) {
        let data = response.data; 
        let tbody = $('#productDataFreight');
        tbody.empty(); 

        if (data && data.length > 0) {
            data.forEach((item) => {
                let row = `
                <tr>
                    <td>${item.product.product_name || ''}</td>
                     <td>${item.quantity || ''}</td>
                    <td>${item.unit_price || ''}</td>
                    <td></td>
                    <td></td>
                   <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                   
                </tr>`;
            tbody.append(row);
            });
        } else {
           
            tbody.append(`<tr><td colspan="13" class="text-center">No data found.</td></tr>`);
        }
    } else {
        alert('Details not found.');
    }
},

              error: function(xhr, status, error) {
                  console.log('Error:', error);
              }
          });
      } 
  
});

</script>