@include('dashboard')
<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
<div class="main-panel">
    <div class="content-wrapper p-2">
        <div class="row">
            <div class="col-12 p-2">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Inward Packing Material</h4>

                        <!-- Show the form to add a product if no products exist -->
                        <form method="POST" action="" id="dataMachineryAdd" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-lg-3 col-6">
                                    <div class="form-group">
                                        <label>Date</label>
                                        <input type="date" id="dateInput" name="date" required
                                            class="form-control form-control-sm border-black" placeholder="Date">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-6">
                                    <div class="form-group">
                                        <label>Time</label>
                                        <input type="time" id="timeInput" name="time" required
                                            class="form-control form-control-sm border-black" placeholder="Time">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-6">
                                    <label>Compaey Name</label>
                                    <select name="compaey_name" class="form-select form-control-sm border-dark"
                                        id="batchSizeSelect">
                                        <option selected disabled>Choose an item</option>
                                        @foreach ($company as $item)
                                            <option>{{ $item->compaey_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-3 col-6">
                                    <div class="form-group">
                                        <label>Location</label>
                                        <input type="text" name="location" required
                                            class="form-control form-control-sm border-black" placeholder="Location">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-3 col-6">
                                    <div class="form-group">
                                        <label>INV/Challan Number</label>
                                        <input type="number" name="inv_challan_number" required
                                            class="form-control form-control-sm border-black"
                                            placeholder="INV/Challan Number ">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-6">
                                    <div class="form-group">
                                        <label>INV/Challan Date</label>
                                        <input type="Date" name="inv_challan_date" required
                                            class="form-control form-control-sm border-black"
                                            placeholder="INV/Challan Date">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-6">
                                    <div class="form-group">
                                        <label>Vehicle Number</label>
                                        <input type="number" name="vehicle_number" required
                                            class="form-control form-control-sm border-black"
                                            placeholder="Truck Number">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-6">
                                    <div class="form-group">
                                        <label>Mobile</label>
                                        <input type="number" name="mobile" required
                                            class="form-control form-control-sm border-black" placeholder="Mobail">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-6"></div>
                                <div class="col-lg-3 col-6"></div>
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
                                                        <input type="number" name="quantity"
                                                            class="form-control form-control-sm border-black"
                                                            placeholder="Quantity">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
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
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <div class="form-group">
                                                        <label>Rate</label>
                                                        <input type="number " name="rate"
                                                            class="form-control form-control-sm border-black"
                                                            placeholder="Rate">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <div class="form-group">
                                                        <label>Amount</label>
                                                        <input type="number" name="amount"
                                                            class="form-control form-control-sm border-black"
                                                            placeholder="Amount">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <div class="form-group">
                                                        <label>Remark</label>
                                                        <input type="text" name="remark"
                                                            class="form-control form-control-sm border-black"
                                                            placeholder="Amount">
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
                                    <input type="file" class="mt-5" name="img">
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

    document.addEventListener('DOMContentLoaded', function() {
        var dateInput = document.getElementById('dateInput');
        var today = new Date().toISOString().split('T')[0];
        dateInput.value = today;
        var timeInput = document.getElementById('timeInput');
        var now = new Date();

        var hours = String(now.getHours()).padStart(2, '0');
        var minutes = String(now.getMinutes()).padStart(2, '0');
        timeInput.value = hours + ':' + minutes;
    });

    $(document).ready(function() {
        $('#dataMachineryAdd').on('submit', function(event) {
            event.preventDefault();
            $("#loader").show();
            var formData = new FormData(this);
            formData.append('_token', '{{ csrf_token() }}');

            $.ajax({
                url: '/machinery-material-create',
                data: formData,
                type: 'post',
                contentType: false,
                processData: false,

                success: function(data) {
                    $('#dataMachineryAdd')[0].reset();
                    $("#loader").hide();
                },

                error: function(xhr) {
                    // Handle error response
                    console.log(xhr.responseText);
                    $("#loader").hide();
                }
            });
        });
    });
</script>
</body>

</html>