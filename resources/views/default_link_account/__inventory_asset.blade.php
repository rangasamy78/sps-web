<div class="card mb-6">
    <div class="card-header header-elements">
        <h5 class="mb-0 me-2">Inventory Asset</h5>
    </div>
    <div class="card-body">
        <div class="row g-6">
            <div class="col-md-12">
                <form id="inventoryAssetForm" name="inventoryAssetForm" class="form-horizontal" method="POST">
                    <div class="row">
                        <label class="col-sm-3 col-form-label text-sm-end" for="formtabs-account-for-new-products">Account for New Products</label>
                        <div class="col-sm-9">
                            <input type="hidden" name="id" id="id" value="{{ $data['inventoryAsset']['id'] ?? '' }}">
                            <select id="account_for_new_product_id" class="form-select" name="account_for_new_product_id">
                                <option value="">--Select--</option>
                                @foreach($data['linkedAccounts'] as $key => $linkedAccount)
                                    @php $selectedValue = (isset($data['inventoryAsset']['account_for_new_product_id']) ? $data['inventoryAsset']['account_for_new_product_id'] : '') @endphp
                                    <option value="{{ $linkedAccount['value'] }}" {{ $linkedAccount['value'] == $selectedValue ? 'selected' : '' }}>{{ $linkedAccount['label'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
