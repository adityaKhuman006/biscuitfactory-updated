{{-- @extends('layouts.master')
@section('content') --}}
@include('dashboard')
<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="card p-2">
                <div class="col-12">
                    <div class="card-body pt-10 ">
                        <h4 class="card-title">Transfer Material</h4>
                        <!-- Show the form to add a product if no products exist -->
                        <form method="POST" action="{{ route('transfer.material.create') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-lg-3 col-6">
                                    <div class="form-group">
                                        <label>Date</label>
                                        <input type="date" id="dateInput" name="date" required
                                            class="form-control form-control-sm border-black"
                                            placeholder="Product Name">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-6">
                                    <div class="form-group">
                                        <label>Time</label>
                                        <input type="time" id="timeInput" name="time" required
                                            class="form-control form-control-sm border-black" placeholder="Batch Size">
                                    </div>
                                </div>
                                <!-- <div class="border border-5 m-3" style="margin-left: 0 !important;"></div> -->
                                <div class="repeater">
                                    <div data-repeater-list="category-group">
                                        <h4 class="card-title">Add items</h4>
                                        <div>
                                            <input type="file" name="item_images">
                                        </div>
                                        <div id="show_item">
                                            <div class="row mt-3" data-repeater-item>
                                                <div class="col-md-3">
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
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <div class="form-group">
                                                            <label>Quantity</label>
                                                            <input type="number" name="quantity"
                                                                class="form-control form-control-sm border-black"
                                                                placeholder="Quantity">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <div class="form-group">
                                                            <label>UOM</label>
                                                            <select name="uom"
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
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>From</label>
                                                        <input type="text" name="from"
                                                            class="form-control form-control-sm border-black"
                                                            placeholder="From">
                                                    </div>
                                                </div>
                                                <!-- <div class="col-md-2">
                                                    <div class="form-group">
                                                        <div class="form-group">
                                                            <label>Rate</label>
                                                            <input type="number " name="umd"
                                                                class="form-control form-control-sm border-black"
                                                                placeholder="Rate">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <div class="form-group">
                                                            <label>Amount</label>
                                                            <input type="nunmber" name="umd"
                                                                class="form-control form-control-sm border-black"
                                                                placeholder="Amount">
                                                        </div>
                                                    </div>
                                                </div> -->
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>To</label>
                                                            <input type="text" name="to"
                                                                class="form-control form-control-sm border-black"
                                                                placeholder="To">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>Person</label>
                                                            <input type="text" name="person"
                                                                class="form-control form-control-sm border-black"
                                                                placeholder="Person">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <div class="form-group">
                                                                <label>Remark</label>
                                                                <input type="text" name="remark"
                                                                    class="form-control form-control-sm border-black"
                                                                    placeholder="Remark">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <div class="form-group">
                                                                <br>
                                                                <div class="text-end mt-2">
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
                                    </div>
                                    <div class="text-end">
                                        </button>
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
    document.addEventListener('DOMContentLoaded', function() {
        const now = new Date();
        const dateString = now.toISOString().split('T')[0];
        const timeString = now.toTimeString().split(' ')[0].slice(0, 5);
        document.getElementById('dateInput').value = dateString;
        document.getElementById('timeInput').value = timeString;
    });

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
