@if (isset($products))
    @foreach ($products as $item)
        <div data-repeater-list="category-group mt-5">
            <div id="show_item">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="form-group">
                                <label>Product Name</label>
                                <input type="text" name="product_name" required value="{{ $item->product_name }}"
                                    class="form-control form-control-sm border-black" placeholder="Product Name">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="form-group">
                                <label>Batch Size</label>
                                <input type="number" name="batch_size" required value="{{ $item->batch_size }}"
                                    class="form-control form-control-sm border-black" placeholder="Batch Size">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="form-group">
                                <label>Batch Required</label>
                                <input type="number" name="batch_required" required value="{{ $item->batch_required }}"
                                    class="form-control form-control-sm border-black" placeholder="Batch Required">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endif


<form class="form-sample" method="POST" action="{{ route('product.add') }}">
    @csrf
    <div>
        <div data-repeater-list="category-group">
            <div id="show_item">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="form-group">
                                <label>Product Name</label>
                                <input type="text" name="product_name" required
                                    class="form-control form-control-sm border-black" placeholder="Product Name">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="form-group">
                                <label>Batch Size</label>
                                <input type="number" name="batch_size" required
                                    class="form-control form-control-sm border-black" placeholder="Batch Size">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="form-group">
                                <label>Batch Required</label>
                                <input type="number" name="batch_required" required
                                    class="form-control form-control-sm border-black" placeholder="Batch Required">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>