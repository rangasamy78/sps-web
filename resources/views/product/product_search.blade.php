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
            <table class="datatables-basic table tables-basic border-top table-striped" id="searchProductdatatable">
    <thead class="table-header-bold">
        <tr>
&nbsp;
            <!-- Add other headers if needed -->
        </tr>
    </thead>
    <tbody>
        @foreach ($products as $product)
        <tr>
            <td style="width: 100px; text-align: center;">
                <img
                    src="{{ asset('storage/app/public/' . $product->image) }}"
                    alt="Product Image"
                    class="d-block rounded"
                    height="100"
                    width="100"
                    id="uploadedAvatar" />
            </td>
            <!-- Add other td's if necessary -->
        </tr>
        @endforeach
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
