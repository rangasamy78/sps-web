<div class="tab-pane" id="crm" role="tabpanel">
    <form id="uploadFileForm" enctype="multipart/form-data">
        <div class="row">
            <input type="text" class="form-control" hidden name="product_id" id="product_id" value="">
        </div>
        <table class="datatables-basic table tables-basic border-top table-striped" id="productFile">
            <thead class="table-header-bold">
                <tr>
                    <th>Entered By </th>
                    <th>Assigned To </th>
                    <th>Title / Description </th>
                    <th>Type</th>
                    <th>Sch. Date / Time</th>
                    <th>Products / Price </th>
                    <th>Type</th>

                </tr>
            </thead>
            <tbody id="fileUploadRow">
            </tbody>
        </table>
    </form>
</div>