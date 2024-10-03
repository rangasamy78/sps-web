@extends('layouts.admin')

@section('title', 'Product')

@section('styles')
<style>
  .product-link {
    color: black;
    text-decoration: none; 
}

.product-link:hover {
    text-decoration: underline; 
}

</style>
@endsection
@section('content')
<div class="content-wrapper">
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4 float-right"><span class="text-muted fw-light">Home / </span>Product</h4>
    @include('product.__search')
    <div class="row mb-3">
      <div class="col">
        <div class="card pt-0 p-4">
          <div class="row">
            <div class="col">
              <table class="datatables-basic table tables-basic border-top table-striped" id="PriceListdatatable">
                <thead class="table-header-bold">
                  <tr class="odd gradeX">
                    <th>Sl.No</th>
                    <th>Name</th>
                    <th>SKU</th>
                    <th>Category</th>
                    <th>Sub Category</th>
                    <th>Type</th>
                    <th>Group</th>
                    <th>Pref.Supplier</th>
                    <th>Loose Slab Price</th>
                    <th>Bundle Price</th>
                    <th>Special Price</th>
                    <th>Price4</th>
                    <th>Price5</th>
                    <th>Price6</th>
                    <th>Price7</th>
                    <th>Price8</th>
                    <th>Price9</th>
                    <th>Price10</th>
                    <th>Price11</th>
                    <th>Price12</th>                    
                    <th>Status</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
@section('scripts')
@include('product.__scripts')
@endsection
