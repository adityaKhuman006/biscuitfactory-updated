<div class="card">
    <div class="card-body">
        <div class="table-responsive">

            <table class="table border-none">
                <thead>
                <tr>
                    <th class="border-dark">Batch No</th>
                    <th class="border-dark">Batch Req</th>
                    <th class="border-dark">Date</th>
                    <th class="border-dark">Time</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="fw-bold fs-5 text-danger">{{ $batchNumber }}</td>
                    <td class="fw-bold fs-5 text-danger">{{ $product->batch_required }}</td>
                    <td class="fw-bold">{{ date('d M Y') }}</td>
                    <td class="fw-bold">{{ \Carbon\Carbon::now()->format('h:i:s a') }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<form action="{{ route('production.add') }}" method="POST">
    @csrf
    <input type="hidden" name="product_id" value="{{ $product->id }}">
    <input type="hidden" name="batch_number" value="{{ $batchNumber }}">
    <input type="hidden" name="date" value="{{ date('d M Y') }}">
    <input type="hidden" name="time" value="{{ \Carbon\Carbon::now()->format('h:i:s a') }}">
    <div class="row">
        <div class="col-lg-12 pt-2 grid-margin stretch-card">
            <div class="card">
                <div class="card-body p-1">
                    <div class="table-responsive">
                        <table class="table">
                            <tr>
                                <th>Item</th>
                                <th>Recipie</th>
{{--                                <th>UOM</th>--}}
                                <th>Actual</th>
                            </tr>
                            {{-- <tr>
                                <th></th>
                                <th>Quantity</th>
                                <th>Quantity</th>
                            </tr> --}}
                            <tbody>
                            @foreach ($materials as $key => $item)
                                <input type="hidden" name="item_id[]" value="{{ $item->getItem[0]->id }}">
                                <tr>
                                    <td class="fs-5">{{ $item->getItem[0]->product_name }}</td>
                                    <td class="fs-5">{{ $item->recipie_weight }} {{ $item->umd }}</td>
                                    <td class="fs-5">
                                        <input type="hidden" name="material_id[]"
                                               value="{{ $item->id }}" id="">
                                        <input type="number" style="width: 100px;" required
                                               name="actual_weight_{{ $item->id }}" value="{{ $item->recipie_weight }}"
                                               class="form-control form-control-sm border-primary" placeholder="Weight" step="any">
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Button trigger modal -->
        <div class="text-center">
            <button type="submit" class="btn btn-success">Save</button>
        </div>
</form>
