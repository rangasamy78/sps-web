<div class="card mb-6">
    <div class="card-header header-elements">
        <h5 class="mb-0 me-2">Inventory In Transit & On Transfer</h5>
    </div>
    <div class="card-body">
        <div class="row g-6">
            <div class="col-md-12">
                <form id="inventoryInTransitOnTransferForm" name="inventoryInTransitOnTransferForm" class="form-horizontal" method="POST">
                    <div class="row">
                        <label class="col-sm-3 text-sm-end" for="formtabs-inventory-in-transit">Inventory in Transit</label>
                        <div class="col-sm-9">
                            <input type="hidden" name="id" id="id" value="{{ $data['inventoryInTransitOnTransfer']['id'] ?? '' }}">
                            <select id="inventory_in_transit_id" class="form-select select2" name="inventory_in_transit_id" data-allow-clear="true">
                                <option value="">--Select--</option>
                                @foreach($data['linkedAccounts'] as $key => $linkedAccount)
                                @php $selectedValue = (isset($data['inventoryInTransitOnTransfer']['inventory_in_transit_id']) ? $data['inventoryInTransitOnTransfer']['inventory_in_transit_id'] : '') @endphp
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
