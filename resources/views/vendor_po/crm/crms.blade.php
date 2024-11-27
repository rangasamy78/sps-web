<div class="tab-pane fade show active" id="contact" role="tabpanel">

    <table class="datatables-basic table table-striped" id="associateContact">
        <thead class="table-header-bold">
            <tr>
                <th>Entered By</th>
                <th>Assigned To </th>
                <th>Title / Description </th>
                <th>Type</th>
                <th>Sch. Date / Time </th>
                <th>Products / Price </th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

<form name="saveContactForm" id="saveContactForm">
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasEndLabel">

        <div class="offcanvas-header">
            <h5 id="offcanvasEndLabel" class="offcanvas-title">Add New Event</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body my-auto">
            <div class="form-group mb-3">
                <label for="county_id" class="form-label">Type</label>
                <div class="col-sm-12">
                    <select type="text" id="type" name="type" class="form-select">

                    </select>
                </div>
            </div>
            <div class="form-group mb-3">
                <label for="contact_name" class="form-label">Sch. Date </label>
                <div class="col-sm-12">
                    <input type="text" class="form-control" id="sch_date" name="sch_date"
                        placeholder="Enter Contact Name" value="">
                </div>
            </div>
            <div class="form-group mb-3">
                <label for="title" class="form-label">Time</label>
                <div class="col-sm-12">
                    <input type="text" class="form-control" id="time" name="time" placeholder="Enter Time" value="">
                </div>
            </div>

            <div class="form-group mb-3">
                <label for="address" class="form-label">Assigned To </label>
                <div class="col-sm-12">
                    <select type="text" id="assigned_to" name="assigned_to" class="form-select">
                    </select>
                </div>
            </div>
            <div class="form-group mb-3">
                <label for="address_2" class="form-label">Followers(CC)</label>
                <div class="col-sm-12">
                    <input type="text" class="form-control" id="follower" name="follower"
                        placeholder="Enter Followers(CC)" value="">
                </div>
            </div>
            <div class="form-group mb-3">
                <label for="state" class="form-label">Title</label>
                <div class="col-sm-12">
                    <input type="text" class="form-control" id="title" name="title" placeholder="Enter Title" value="">
                </div>
            </div>
            <div class="form-group mb-3 row">
                <div class="col-6">
                    <label for="city" class="form-label">Product</label>
                    <select type="text" id="product" name="product" class="form-select">
                    </select>
                </div>
                <div class="col-6">
                    <label for="zip" class="form-label">Price</label>
                    <input type="text" class="form-control" id="price" name="price" placeholder="Enter Zip" value="">
                </div>
            </div>
            <div class="form-group mb-3">
                <label for="county_id" class="form-label">Description</label>
                <div class="col-sm-12">
                    <textarea id="internal_notes" name="description" class="form-control" rows="2"
                        placeholder="Enter Description" style="resize:none"></textarea>
                </div>
            </div>

            <div class="row">
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary" id="savecontactdata"
                        name="savecontactdata">Save</button>
                    <button type="button" class="btn btn-label-secondary ms-2"
                        data-bs-dismiss="offcanvas">Cancel</button>
                </div>
            </div>
        </div>

    </div>
</form>