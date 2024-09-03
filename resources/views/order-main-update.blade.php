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
                        <form method="POST" action="{{ route('Order.update', $order->id) }}" id="dataPackingAdd" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-lg-3 col-6">
                                    <div class="form-group">
                                        <label>Product Name</label>
                                        <input type="text" value="{{ old('product_name', $order->product_name) }}" name="product_name" required
                                            class="form-control form-control-sm border-black"
                                            placeholder="Product Name">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-6">
                                    <div class="form-group">
                                        <label>Date</label>
                                        <input type="date" id="dateInput" name="date" value="{{ old('date', $order->date) }}" required class="form-control form-control-sm border-black" placeholder="Date">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-6">
                                    <div class="form-group">
                                        <label>Batch Size</label>
                                        <input type="number" name="batch_size" value="{{ old('batch_size', $order->batch_size) }}" required
                                            class="form-control form-control-sm border-black" placeholder="Batch Size">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-6">
                                    <div class="form-group">
                                        <label>Batch Required</label>
                                        <input type="number" name="batch_required" value="{{ old('batch_required', $order->batch_required) }}" required
                                            class="form-control form-control-sm border-black"
                                            placeholder="Batch Required">
                                    </div>
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
