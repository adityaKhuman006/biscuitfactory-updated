@php
    use App\Models\Batch;
    use App\Models\masterProduct;
@endphp
<table class="table table-bordered dataTable" style="width:100%">
    <thead>
    <tr>
        <th>Product Name</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    @foreach($products as $product)
        <tr>
            <td>{{ $product->getProduct[0]->product_name }}</td>
            <td>
                    <?php
                    $batches = Batch::with(['getProduct', 'getMaterial'])->where('product_id', $product->product_id)->groupBy('batch_number', 'product_id')->get();
                    $items = Batch::with(['getProduct', 'getMaterial'])->where('batch_number', $product->batch_number)->where('product_id', $product->product_id)->get();
                    $itemsTotals = [];
                    ?>
                <div class="table-responsive">
                    <table class="table table-bordered dataTable-nested-{{ $product->id }}">
                        <thead>
                        <tr>
                            <th class="text-start">Batch No</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Time</th>
                            @foreach($items as $item)
                                <th>
                                        <?php
                                        $ItemName = masterProduct::where('id', $item->item_id)->pluck('product_name')->first();
                                        ?>
                                    {{$ItemName}}
                                </th>
                            @endforeach
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($batches as $batch)
                            <tr>
                                <td class="text-start">{{ $batch->batch_number - 1 }}</td>
                                <td>Production</td>
                                <td>{{ $batch->date}}</td>
                                <td>{{ $batch->time}}</td>
                                    <?php
                                    $itemValues = Batch::with(['getProduct', 'getMaterial'])
                                        ->where('batch_number', $batch->batch_number)
                                        ->where('product_id', $product->product_id)
                                        ->get();
                                    ?>
                                @foreach($itemValues as $values)
                                        <?php
                                        $itemSums = Batch::where('product_id', $product->product_id)->where('item_id',$values->item_id)->sum('actual_weight');
                                        $itemsTotals[$values->item_id] =  $itemSums;
                                        ?>
                                    <td>{{ $values->actual_weight}}</td>
                                @endforeach
                            </tr>
                            <tr>

                            </tr>
                        @endforeach
                        <tr>
                            <th>{{ count($batches) }}</th>
                            <th>--</th>
                            <th>--</th>
                            <th>--</th>
                            @foreach($itemsTotals as $totals)
                                <th>{{ $totals }}</th>
                            @endforeach

                        </tr>
                        </tbody>
                    </table>
                    {{--                                    <script>--}}
                    {{--                                        $('.dataTable-nested-'+{{ $product->id }}).DataTable({--}}
                    {{--                                            responsive: true--}}
                    {{--                                        });--}}
                    {{--                                    </script>--}}
                </div>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
