@extends('layouts.admin')

@section('title', 'Supplier Invoices')

@section('styles')
@endsection
@section('content')
<div class="content-wrapper">
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4 float-right"><span class="text-muted fw-light">Home / </span>Supplier Invoices</h4>
 
    <div class="row mb-3">
      <div class="col">
        <div class="card pt-0 p-4">
          <div class="row">
            <div class="col">
              <table class="datatables-basic table tables-basic border-top table-striped" id="datatable">
                <thead class="table-header-bold">
                  <tr class="odd gradeX">
                  <th>Sl No.</th>
                    <th>SIPL#</th>
                    <th>P.O.#</th>
                    <th>Entry Date</th>
                    <th>Invoice#</th>
                    <th>Payment Terms</th>
                    <th>Supplier SO#</th>
                    <th>Container#</th>
                    <th>Supplier</th>
                    <th>Ship To	</th>
                    <th>Ship Date	</th>
                    <th>SIPL Status	</th>
                    <th>Freight Forwarder	</th>
                    <th>Status 	</th>
                    <th>Received Date 	</th>
                    <th>Amount	</th>
                    <th>Balance Due</th>
                    <th></th>
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
@include('supplier_invoice_packing_list.__scripts')
@endsection
