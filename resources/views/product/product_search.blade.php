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


    .pagination {
        font-size: 14px; /* Adjust font size */
    }
    .pagination .page-item .page-link {
        padding: 5px 10px; /* Adjust padding */
        border-radius: 4px; /* Add some border-radius for rounded corners */
    }
</style>

@endsection
@section('content')
<div class="content-wrapper">
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4 float-right"><span class="text-muted fw-light">Home / </span>Product</h4>
    @include('product.__product_searchfilter')
    <div class="row mb-3">
      <div class="col">
        <div class="card pt-0 p-4">
          <div class="row">
            <div class="col">
            <table class="datatables-basic table border-top table-striped" id="searchProductdatatable">
            <thead class="table-header-bold">
                <tr>
                    <th style="text-align: center;">&nbsp;</th>
                    <th style="text-align: center;">&nbsp;</th>
                    <th style="text-align: center;">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products->chunk(5) as $chunk) <!-- Use chunk of 3 for 3 columns per row -->
                <tr>
                    @foreach ($chunk as $product)
                    <td style="text-align: center;">
                        <img
                            src="{{ asset('storage/app/public/' . $product->image) }}"
                            alt="Product Image"
                            class="d-block rounded"
                            height="100"
                            width="100"
                            id="uploadedAvatar" />
                    </td>
                    @endforeach

                    <!-- Fill the remaining columns if the chunk has fewer than 3 products -->
                    @for ($i = 0; $i < 3 - count($chunk); $i++)
                    <td></td>
                    @endfor
                </tr>
                @endforeach
            </tbody>
        </table>

&nbsp;&nbsp;

<div class="d-flex justify-content-center">
    <ul class="pagination pagination-sm">

        {{ $products->links('pagination::bootstrap-4') }} <!-- Bootstrap Pagination Style -->
    </ul>
</div>






            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
@section('scripts')
@include('product.__product_search_script')
@endsection
