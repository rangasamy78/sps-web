<!-- Modal for designation -->
<div class="modal fade" id="linkedAccountModel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modelHeading"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="linkedAccountForm" class="form-horizontal">
                    <input type="hidden" name="linked_account_id" id="linked_account_id">
                    <div class="form-group mb-3">
                        <label for="account_code" class="col control-label pb-1">Account Code<sup style="color: red;"><b>*</b></sup></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="account_code" name="account_code" placeholder="Enter Account Code" value="">
                        </div>
                        <span class="text-danger error-text account_code_error"></span>
                    </div>
                    <div class="form-group mb-3">
                        <label for="account_code" class="col control-label pb-1">Account Name<sup style="color: red;"><b>*</b></sup></label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="account_name" name="account_name" placeholder="Enter Account Name" value="">
                        </div>
                        <span class="text-danger error-text account_name_error"></span>
                    </div>
                    <div class="form-group mb-3">
                        <label for="account_type" class="col control-label pb-1">Account Type<sup style="color: red;"><b>*</b></sup></label>
                        <div class="col-sm-12">
                            <select class="form-select "  name="account_type" id="account_type">
                                <option value="">--Select--</option>
                                @foreach($accountTypes as $accountType)
                                <option value="{{$accountType->id}}">{{$accountType->account_type_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <span class="text-danger error-text account_type_error"></span>
                    </div>
                    <div class="form-group mb-3">
                        <label for="account_sub_type" class="col control-label pb-1">Account Sub Type<sup style="color: red;"><b>*</b></sup></label>
                        <div class="col">
                            <select class="form-select "  name="account_sub_type" id="account_sub_type">
                                <option value="">--Select-- </option>
                                @foreach($accountSubTypes as $accountSubType)
                                <option value="{{$accountSubType->id}}">{{$accountSubType->sub_type_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <span class="text-danger error-text account_sub_type_error"></span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="savedata" name="savedata" value="Save">Save</button>
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="showLinkedAccountModal" tabindex="-1" aria-labelledby="showLinkedAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="showLinkedAccountModalLabel">Show Linked Account</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="showLinkedAccountForm" name="showLinkedAccountForm" class="form-horizontal">
                <div class="form-group mb-3">
                        <label for="account_code" class=" control-label">Account Code</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" disabled id="account_code" name="account_code" placeholder="Enter Account Code" value="">
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="account_code" class=" control-label">Account Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" disabled id="account_name" name="account_name" placeholder="Enter Account Name" value="">
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="account_code" class=" control-label">Account Type</label>
                        <div class="col-sm-12">
                            <select class="form-select " disabled name="account_type" id="account_type">
                                <option value="">Select Account Type</option>
                                @foreach($accountTypes as $accountType)
                                <option value="{{$accountType->id}}">{{$accountType->account_type_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="account_code" class=" control-label">Account Sub Type</label>
                        <div class="col-sm-12">
                            <select class="form-select "  disabled name="account_sub_type" id="account_sub_type">
                                <option value="">Select Account Sub Type</option>
                                @foreach($accountSubTypes as $accountSubType)
                                <option value="{{$accountSubType->id}}">{{$accountSubType->sub_type_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
