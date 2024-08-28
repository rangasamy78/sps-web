<div class="card mb-6">
    <div class="card-header header-elements">
        <h5 class="mb-0 me-2">Inventory Adjustments - Income/Expense accounts</h5>
    </div>
    <div class="card-body">
        <form id="inventoryAdjustmentAccountForm" name="inventoryAdjustmentAccountForm" class="form-horizontal" method="POST">
            <div class="row g-6">
                <div class="col-md-12">
                    <div class="row">
                        <label class="col-sm-3 text-sm-end" for="formtabs-positive-adjustments">Positive Adjustments</label>
                        <div class="col-sm-9">
                            <input type="hidden" name="id" id="id" value="{{ $data['inventoryAdjustment']['id'] ?? '' }}">
                            <select id="positive_adjustment_id" class="form-select select2" name="positive_adjustment_id" data-allow-clear="true">
                                <option value="">--Select--</option>
                                @foreach($data['linkedAccounts'] as $key => $linkedAccount)
                                @php $selectedValue = (isset($data['inventoryAdjustment']['positive_adjustment_id']) ? $data['inventoryAdjustment']['positive_adjustment_id'] : '') @endphp
                                <option value="{{ $linkedAccount['value'] }}" {{ $linkedAccount['value'] == $selectedValue ? 'selected' : '' }}>{{ $linkedAccount['label'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row g-6">
                <div class="col-md-12">
                    <div class="row">
                        <label class="col-sm-3 text-sm-end" for="formtabs-inventory-write-offs">Inventory Write Offs</label>
                        <div class="col-sm-9">
                            <select id="inventory_write_off_id" class="form-select select2" name="inventory_write_off_id" data-allow-clear="true">
                                <option value="">--Select--</option>
                                @foreach($data['linkedAccounts'] as $key => $linkedAccount)
                                @php $selectedValue = (isset($data['inventoryAdjustment']['inventory_write_off_id']) ? $data['inventoryAdjustment']['inventory_write_off_id'] : '') @endphp
                                <option value="{{ $linkedAccount['value'] }}" {{ $linkedAccount['value'] == $selectedValue ? 'selected' : '' }}>{{ $linkedAccount['label'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row g-6">
                <div class="col-md-12">
                    <div class="row">
                        <label class="col-sm-3 text-sm-end" for="formtabs-reclassify-renumbering-split">Reclassify/Renumbering/Split</label>
                        <div class="col-sm-9">
                            <select id="reclassify_renumbering_split_id" class="form-select select2" name="reclassify_renumbering_split_id" data-allow-clear="true">
                                <option value="">--Select--</option>
                                @foreach($data['linkedAccounts'] as $key => $linkedAccount)
                                @php $selectedValue = (isset($data['inventoryAdjustment']['reclassify_renumbering_split_id']) ? $data['inventoryAdjustment']['reclassify_renumbering_split_id'] : '') @endphp
                                <option value="{{ $linkedAccount['value'] }}" {{ $linkedAccount['value'] == $selectedValue ? 'selected' : '' }}>{{ $linkedAccount['label'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row g-6">
                <div class="col-md-12">
                    <div class="row">
                        <label class="col-sm-3 text-sm-end" for="formtabs-revaluation-adjustments">Revaluation Adjustments</label>
                        <div class="col-sm-9">
                            <select id="revaluation_adjustment_id" class="form-select select2" name="revaluation_adjustment_id" data-allow-clear="true">
                                <option value="">--Select--</option>
                                @foreach($data['linkedAccounts'] as $key => $linkedAccount)
                                @php $selectedValue = (isset($data['inventoryAdjustment']['revaluation_adjustment_id']) ? $data['inventoryAdjustment']['revaluation_adjustment_id'] : '') @endphp
                                <option value="{{ $linkedAccount['value'] }}" {{ $linkedAccount['value'] == $selectedValue ? 'selected' : '' }}>{{ $linkedAccount['label'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
