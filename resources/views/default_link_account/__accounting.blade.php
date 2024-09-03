<div class="card mb-6">
    <div class="card-header header-elements">
        <h5 class="mb-0 me-2">Accounting</h5>
    </div>
    <div class="card-body">
        <form id="accountingForm" name="accountingForm" class="form-horizontal" method="POST">
            <div class="row g-6">
                <div class="col-md-12">
                    <div class="row">
                        <label class="col-sm-3 text-sm-end" for="formtabs-retained-earnings">Retained Earnings</label>
                        <div class="col-sm-9">
                            <input type="hidden" name="id" id="id" value="{{ $data['accounting']['id'] ?? '' }}">
                            <select id="retained_earning_id" class="form-select select2" name="retained_earning_id" data-allow-clear="true">
                                @foreach($data['linkedAccounts'] as $key => $linkedAccount)
                                @php $selectedValue = (isset($data['accounting']['retained_earning_id']) ? $data['accounting']['retained_earning_id'] : '') @endphp
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
