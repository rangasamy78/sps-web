          @extends('layouts.admin')

          @section('title', 'Price List Label')

          @section('styles')
          <style>
            
          </style>
          @endsection
          @section('content')
          <div class="content-wrapper">
            <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="py-3 mb-4"><span class="text-muted fw-light">Home / </span>Price List Label </h4>
              @include('price_list_label.__search')
              <div class="row mb-3">
                <div class="card">
                  <div class="row mb-2 p-2">
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
          @include('price_list_label.__model')
          @endsection
          @section('scripts')
          @include('price_list_label.__script')
          @endsection
