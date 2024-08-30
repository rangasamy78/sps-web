@extends('layouts.admin')

@section('title', 'Department')

@section('styles')
@endsection
@section('content')
<div class="content-wrapper">
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4 float-right"><span class="text-muted fw-light">Home / </span> Department</h4>
    @include('department.__search')
    <div class="row mb-3">
      <div class="col">
        <div class="card p-4 pt-0">
          <div class="row">
            <div class="col">
              <table class="datatables-basic table tables-basic border-top table-striped" id="datatable">
                <thead class="table-header-bold">
                  <tr class="odd gradeX">
                    <th>Sl.No</th>
                    <th>Department Name</th>
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
@include('department.__model')
@endsection
@section('scripts')
@include('department.__scripts')
{{-- <script type="text/javascript">
    $(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('#datatable').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: "{{ route('departments.list') }}",
columns: [
{
data: 'id',
name: 'id',
orderable: false,
searchable: false
}, // Row index column
{
data: 'department_name',
name: 'department_name',
},
{
data: 'action',
name: 'action',
orderable: false,
searchable: false
},
],
rowCallback: function(row, data, index) {
$('td:eq(0)', row).html(index + 1); // Update the index column with the correct row index
}
});

setTimeout(() => {
$('.dataTables_filter .form-control').removeClass('form-control-sm').css('margin-right',
'20px');
$('.dataTables_length .form-select').removeClass('form-select-sm').css('padding-left',
'30px');
}, 300);

});

</script> --}}
@endsection
