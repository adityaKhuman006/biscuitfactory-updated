@include('dashboard')
<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
<div class="main-panel">
    <div class="content-wrapper p-2">
        <div class="row">
            <div class="col-12 p-2">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Main Order</h4>

                        <!-- Show the form to add a product if no products exist -->
                        <form method="POST" action="{{ route('main.Order.Create') }}" id="dataPackingAdd"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-lg-3 col-6">
                                    <div class="form-group">
                                        <label>Product Name</label>
                                        <input type="text" name="product_name" required
                                            class="form-control form-control-sm border-black"
                                            placeholder="Product Name">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-6">
                                    <div class="form-group">
                                        <label>Date</label>
                                        <input type="date" id="dateInput" name="date" required
                                            class="form-control form-control-sm border-black" placeholder="Date">
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
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <div class="form-group">
                                                        <label>Items</label>
                                                        <select name="item"
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
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <div class="form-group">
                                                        <label>Quantity</label>
                                                        <input type="number" name="quantity" step="any"
                                                            class="form-control form-control-sm border-black"
                                                            placeholder="Quantity">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <div class="form-group">
                                                        <label>UOM</label>
                                                        <input type="text" name="uom"
                                                            class="form-control form-control-sm border-black"
                                                            placeholder="UOM">
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
                                    {{-- <input type="file" class="mt-5" name="img"> --}}
                                    <button data-repeater-create type="button" class="btn btn-success add-item"
                                        style="margin-top: 15px;"><i class="mdi mdi-plus"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="d-flex justify-content-center">
                                <button class="btn btn-primary" type="submit" name="submit">Submit</button>
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
</body>

</html>
