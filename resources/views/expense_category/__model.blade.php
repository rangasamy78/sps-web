    <div class="modal fade" id="expenseCategoryModel" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modelHeading"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="expenseCategoryForm" name="expenseCategoryForm" class="form-horizontal">
                        <input type="hidden" name="expense_category_id" id="expense_category_id">
                        <div class="form-group mb-3">
                            <label for="expense_category_name" class="control-label pb-1">Expense Category Name<sup style="color:red"><strong>*</strong></sup></label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="expense_category_name" name="expense_category_name" placeholder="Enter Expense Category Name" value="">
                            </div>
                            <span class="text-danger error-text expense_category_name_error"></span>
                        </div>
                        <div class="form-group mb-3">
                            <label for="expense_account" class="control-label pb-1">Expense Account<sup style="color:red"><strong>*</strong></sup></label>
                            <div class="col-sm-12">
                                <select class="form-select " name="expense_account" id="expense_account">
                                    <option value="">--select here--</option>
                                    @foreach($data['linkedAccounts'] as $key => $linkedAccount)
                                        <option value="{{ $linkedAccount['value'] }}">{{ $linkedAccount['label'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <span class="text-danger error-text expense_account_error"></span>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="savedata" name="savedata">Save</button>
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="showExpenseCategoryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Show Expense Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="showExpenseCategoryForm" name="showExpenseCategoryForm" class="form-horizontal">
                        <div class="form-group mb-3">
                            <label for="expense_category_name" class="control-label pb-1">Expense Category Name </label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" disabled id="expense_category_name" name="expense_category_name" value="">
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="expense_account" class="control-label pb-1">Expense Account </label>
                            <div class="col-sm-12">
                                <select class="form-select " disabled name="expense_account" id="expense_account">
                                    <option value="">--select here--</option>
                                    @foreach($data['linkedAccounts'] as $key => $linkedAccount)
                                        <option value="{{ $linkedAccount['value'] }}" >{{ $linkedAccount['label'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>