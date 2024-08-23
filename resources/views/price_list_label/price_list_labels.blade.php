          @extends('layouts.admin')

          @section('title', 'Price List Label')

          @section('styles')
          <style>
            .custom-container {
              max-height: 120px;
              /* Adjust the height as needed */
              overflow-y: auto;
              min-height: 120px;
            }

            .custom-container::-webkit-scrollbar {
              width: 8px;
              /* Width of the scrollbar */
            }

            .custom-container::-webkit-scrollbar-track {
              background: #f1f1f1;
              /* Background of the scrollbar track */
              border-radius: 10px;
              /* Rounded corners of the track */
            }

            .custom-container::-webkit-scrollbar-thumb {
              background: #888;
              /* Color of the scrollbar thumb */
              border-radius: 10px;
              /* Rounded corners of the thumb */
            }

            .custom-container::-webkit-scrollbar-thumb:hover {
              background: #555;
              /* Color of the scrollbar thumb when hovered */
            }

            .custom-container::-webkit-scrollbar-corner {
              background: #f1f1f1;
              /* Color of the scrollbar corner */
            }
          </style>
          @endsection
          @section('content')
          <!-- Content -->
          <div class="content-wrapper">
            <!-- Content -->
            <div class="container-xxl flex-grow-1 container-p-y">
              <!-- //toast -->
              <div class="container-toast">

              </div>
              <h4 class="py-3 mb-4"><span class="text-muted fw-light">Home / </span> Price List Label </h4>
              <div class="row mb-3">
                <!-- DataTable with Buttons -->
                <div class="card p-4 pt-0">
                  <!-- </div> -->
                  <div class="row">

                    <div class="col">
                      <table class="datatables-basic table tables-basic border-top table-striped" id="priceListLabelTable">
                        <thead class="table-header-bold">
                          <tr class="odd gradeX">
                            <th class="center">Sl.No</th>
                            <th>Price Label</th>
                            <th>Price Code</th>
                            <th>Discount % off Retail(P1)</th>
                            <th>Margin</th>
                            <th>Markup</th>
                            <th>Sales Rep com%</th>
                            <th>Actions</th>
                          </tr>
                        </thead>
                        <tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>

            </div>

          </div>

          <!-- / Content -->
          @include('price_list_label.__model')
          @endsection
          @section('scripts')
          @include('price_list_label.__script')
          @endsection