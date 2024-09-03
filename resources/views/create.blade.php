{{-- @extends('layouts.master')
@section('content') --}}
@include('dashboard')
<div class="main-panel">
    <div class="content-wrapper p-2">
        <div class="row">
            <div class="col-12 p-2">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Add Order</h4>
                        <!-- Show the form to add a product if no products exist -->
                        <form method="POST" action="{{ route('product.add') }}">
                            @csrf
                            <div class="row">
                                <div class="col-lg-3 col-6">
                                    <div class="form-group">
                                        <label>Order Name</label>
                                        <input type="text" name="product_name" required
                                            class="form-control form-control-sm border-black" placeholder="Order Name">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-6">
                                    <div class="form-group">
                                        <label>Batch Size</label>
                                        <input type="number" name="batch_size" required
                                            class="form-control form-control-sm border-black" placeholder="Batch Size">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-6">
                                    <div class="form-group">
                                        <label>Batch Required</label>
                                        <input type="number" name="batch_required" required
                                            class="form-control form-control-sm border-black"
                                            placeholder="Batch Required">
                                    </div>
                                </div>
                            </div>

                            <div class="border border-5 m-3" style="margin-left: 0 !important;"></div>

                            <div class="repeater">
                                <div data-repeater-list="category-group">
                                    <h4 class="card-title">Add items</h4>
                                    <div id="show_item">
                                        <div class="row" data-repeater-item>
                                            <div class="col-md-3  ">
                                                <div class="form-group">
                                                    <div class="form-group">
                                                        <label>Item Name</label>
                                                        <select name="item_id"
                                                            class="form-select form-control-sm border-dark"
                                                            id="batchSizeSelect">
                                                            <option selected disabled>Choose an item</option>
                                                            @foreach ($raw as $item)
                                                                <option>{{ $item->product_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <div class="form-group">
                                                        <label>Recipie Weight</label>
                                                        <input type="number" name="recipie_weight"
                                                            class="form-control form-control-sm border-black"
                                                            placeholder="Recipie Weight" step="0.0000000000001">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <div class="form-group">
                                                        <label>UOM</label>
                                                        <select name="umd"
                                                            class="form-select form-control-sm border-dark"
                                                            id="batchSizeSelect">
                                                            <option selected disabled>Choose an uom</option>
                                                            @foreach ($UOM as $item)
                                                                <option>{{ $item->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <div class="form-group">
                                                        <br>
                                                        <div class="text-end">
                                                            <button data-repeater-delete type="button"
                                                                class="btn btn-danger add-item"><i
                                                                    class=" mdi mdi-delete"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <button data-repeater-create type="button" class="btn btn-success add-item"
                                        style="margin-top: 15px;"><i class="mdi mdi-plus"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="d-flex justify-content-center">
                                <button class="btn btn-primary" type="submit">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('footer')
<script src="{{ asset('assets/js/repeater.min.js') }}"></script>
<script>
    $('.repeater').repeater({
        defaultValues: {
            'text-input': 'foo'
        },
        show: function() {
            $(this).slideDown();
        },
        hide: function(deleteElement) {
            $(this).slideUp(deleteElement);
        },
        isFirstItemUndeletable: true
    });
</script>
<!-- partial:partials/_footer.html -->
</body>

</html>
{{-- @endsection --}}
