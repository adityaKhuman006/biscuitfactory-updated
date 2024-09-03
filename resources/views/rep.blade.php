@php
    use App\Models\Batch;
    use App\Models\masterProduct;
@endphp
@include('dashboard')
<style>
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 0px !important;
    }

    .select2-container .select2-selection--single .select2-selection__rendered {
        overflow: unset;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        top: -5px !important;
    }

    .dt-layout-full {
        overflow: auto !important;
    }
</style>
<!-- <h1 class="text-center">report</h1> -->
<div class="main-panel">
    <div class="content-wrapper p-2">
        <div class="card">
            <div class="row container p-3">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="form-label fw-bold">Form Date</label>
                        <input type="date" class="form-control form-date" onchange="getDataBuyDate()" name="form_date">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="form-label fw-bold">To Date</label>
                        <input type="date" class="form-control to-date" onchange="getDataBuyDate()" name="form_date">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group d-flex flex-column">
                        <label class="form-label fw-bold">Product</label>
                        <select class="form-group filter-product" name="filter_product" onchange="getDataBuyDate()">
                            <option value=""></option>
                            @foreach($productMaster as $product)
                                <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="container m-0 reportDataTable">
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

                {{--                                    <div class="border border-2 rounded-3 p-3 m-2" style="background: #84add63b">--}}
                {{--                                        <div>--}}
                {{--                                            <span class="fw-bold">Product Name</span>--}}
                {{--                                            : </span>{{ $product->getProduct[0]->product_name}}</span>--}}
                {{--                                        </div>--}}
                {{--                                            <?php--}}
                {{--                                            $batches = Batch::with(['getProduct', 'getMaterial'])->where('product_id', $product->product_id)->groupBy('batch_number', 'product_id')->get();--}}
                {{--                                            $items = Batch::with(['getProduct', 'getMaterial'])->where('batch_number', $product->batch_number)->where('product_id', $product->product_id)->get();--}}
                {{--                //                        dd($items);--}}
                {{--                                            ?>--}}
                {{--                                        <table class="table table-bordered dataTable" style="width:100%">--}}
                {{--                                            <thead>--}}
                {{--                                            <tr>--}}
                {{--                                                <th class="text-start">Batch No</th>--}}
                {{--                                                <th>Status</th>--}}
                {{--                                                <th>Date</th>--}}
                {{--                                                <th>Time</th>--}}
                {{--                                                @foreach($items as $item)--}}
                {{--                                                    <th>--}}
                {{--                                                            <?php--}}
                {{--                                                            $ItemName = masterProduct::where('id', $item->item_id)->pluck('product_name')->first();--}}
                {{--                                                            ?>--}}
                {{--                                                        {{$ItemName}}--}}
                {{--                                                    </th>--}}
                {{--                                                @endforeach--}}
                {{--                                            </tr>--}}
                {{--                                            </thead>--}}
                {{--                                            <tbody>--}}
                {{--                                            @foreach($batches as $batch)--}}
                {{--                                                <tr>--}}
                {{--                                                    <td class="text-start">{{ $batch->batch_number - 1 }}</td>--}}
                {{--                                                    <td>Production</td>--}}
                {{--                                                    <td>{{ $batch->date}}</td>--}}
                {{--                                                    <td>{{ $batch->time}}</td>--}}
                {{--                                                        <?php--}}
                {{--                                                        $itemValues = Batch::with(['getProduct', 'getMaterial'])--}}
                {{--                                                            ->where('batch_number', $batch->batch_number)--}}
                {{--                                                            ->where('product_id', $product->product_id)--}}
                {{--                                                            ->get();--}}
                {{--                                                        ?>--}}
                {{--                                                    @foreach($itemValues as $values)--}}
                {{--                                                        <td>{{ $values->actual_weight}}</td>--}}
                {{--                                                    @endforeach--}}
                {{--                                                </tr>--}}
                {{--                                            @endforeach--}}
                {{--                                            </tbody>--}}
                {{--                                        </table>--}}
                {{--                                    </div>--}}
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="viewReportModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Report</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="reportData">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@include('footer')

<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/2.1.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.1.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.2/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.2/js/responsive.bootstrap5.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{ asset('assets/js/notify.min.js') }}"></script>
<script>
    $(document).ready(function () {
        $('.dataTable').DataTable({
            responsive: true
        });
    });

    function getDataBuyDate() {
        var formDate = $('.form-date').val();
        var toDate = $('.to-date').val();
        var filterProduct = $('.filter-product').val() || 'all';

        $("#loader").show();
        $.ajax({
            url: '{{ route('get.data.by.date') }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                formDate: formDate,
                toDate: toDate,
                filterProduct: filterProduct,
            },
            success: function (response) {
                if (response.html) {
                    $(".reportDataTable").html(response.html);
                    $('.dataTable').DataTable({
                        responsive: true
                    });
                    $("#loader").hide();
                }
            },
            error: function (response) {
                $("#loader").hide();
                alert('An error occurred: ' + response.responseText);
            }
        });
    }


    $('.filter-product').select2({
        placeholder: 'Select an option'
    });
    $(document).on('click', '.viewReport', function () {
        $("#loader").show();
        var batchId = $(this).attr('data-batch-id');
        var productId = $(this).attr('data-product-id');
        $.ajax({
            url: '{{ route('get.material') }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                productId: productId,
                batchId: batchId
            },
            success: function (response) {
                if (response.html) {
                    $("#reportData").html(response.html)
                    $("#viewReportModal").modal('show')
                    $("#loader").hide();
                }
            }, error: function (response) {
                console.log(response)
            }
        })
    })

</script>
</body>

</html>
