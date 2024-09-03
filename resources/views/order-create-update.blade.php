@include('dashboard')
<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
<div class="main-panel">
    <div class="content-wrapper p-2">
        <div class="row">
            <div class="col-12 p-2">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Create Order</h4>

                        <!-- Show the form to add a product if no products exist -->
                        <form method="POST" action="{{ route('order.create.edit') }}" id="dataMachineryAdd"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{ $OrderCreateUpdate->id }}">
                            <div class="row">
                                <div class="col-lg-2 col-2">
                                    <div class="form-group">
                                        <label>Date</label>
                                        <input type="date" id="dateInput" value="{{ $OrderCreateUpdate->date }}"
                                            name="date" required class="form-control form-control-sm border-black"
                                            placeholder="Date">
                                    </div>
                                </div>
                                <div class="col-lg-2 col-2">
                                    <label>Name</label>
                                    <input type="text" name="name" required value="{{ $OrderCreateUpdate->name }}"
                                        class="form-control form-control-sm border-black" placeholder="Name">
                                </div>
                                <div class="col-lg-2 col-2">
                                    <label>Order No</label>
                                    <input type="text" value="{{ $OrderCreateUpdate->order_no }}"
                                        class="form-control form-control-sm border-black"
                                        value="{{ strtoupper(Str::random(6)) . str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT) }}"
                                        name="order_no">
                                </div>

                                <div class="col-lg-2 col-2">
                                    <div class="form-group">
                                        <label>Contact Person</label>
                                        <input type="number" value="{{ $OrderCreateUpdate->contact_person }}"
                                            name="contact_person" required
                                            class="form-control form-control-sm border-black"
                                            placeholder="Contact Person">
                                    </div>
                                </div>
                                <div class="col-lg-2 col-2">
                                    <label>Customer Name</label>
                                    <select name="customer_name"
                                        class="update-weight1 form-select form-control-sm border-dark"
                                        id="batchSizeSelect">
                                        <option selected disabled>Choose an item</option>
                                        @foreach ($customer_name as $item)
                                            <option
                                                {{ $item->id == $OrderCreateUpdate->customer_name ? 'selected' : '' }}
                                                value="{{ $item->id }}">{{ $item->compaey_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label>Hide</label>
                                            <select name="hide" class="form-select form-control-sm border-dark"
                                                required>
                                                <option
                                                    {{ $OrderCreateUpdate->hide == \App\Models\OrderProduct::YES ? 'selected' : '' }}
                                                    value="{{ \App\Models\OrderProduct::YES }}">
                                                    yes
                                                </option>
                                                <option
                                                    {{ $OrderCreateUpdate->hide == \App\Models\OrderProduct::NO ? 'selected' : '' }}
                                                    value="{{ \App\Models\OrderProduct::NO }}">no
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="border border-5 m-3" style="margin-left: 0 !important;"></div>


                            @foreach ($collection as $item)
                            <input type="hidden" name="id" value="{{ $item->order_id }}">
                                <div class="repeater">
                                    <div data-repeater-list="category-group">
                                        <h4 class="card-title">Add items</h4>
                                        <div id="show_item">
                                            <div class="row" data-repeater-item>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Product</label>
                                                        <select name="product" required
                                                            class="form-select update-weight2 form-control-sm border-dark">
                                                            <option value="" disabled>Choose an item</option>
                                                            @foreach ($product as $prod)
                                                                <option value="{{ $prod->id }}"
                                                                    {{ $prod->id == $item->product ? 'selected' : '' }}>
                                                                    {{ $prod->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Brand Name</label>
                                                        <select name="brand_name" required
                                                            class="form-select update-weight3 form-control-sm border-dark">
                                                            <option value="" disabled>Choose an item</option>
                                                            @foreach ($brand_name as $brand)
                                                                <option value="{{ $brand->id }}"
                                                                    {{ $brand->id == $item->brand_name ? 'selected' : '' }}>
                                                                    {{ $brand->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Pack Size</label>
                                                        <select name="pack_size" required
                                                            class="form-select batchSizeSelect form-control-sm border-dark">
                                                            <option value="" disabled>Choose a uom</option>
                                                            @foreach ($pack_size as $pack)
                                                                <option value="{{ $pack->id }}"
                                                                    data-qty="{{ $pack->loading_in_container }}"
                                                                    {{ $pack->id == $item->pack_size ? 'selected' : '' }}>
                                                                    {{ $pack->pack_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Qty Container</label>
                                                        <input type="text" value="{{ $item->qty_container }}"
                                                            name="qty_container" required
                                                            class="form-control qty_container form-control-sm border-black"
                                                            placeholder="Qty Container">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Reqd Qty</label>
                                                        <input type="text" value="{{ $item->reqd_oty }}"
                                                            name="reqd_oty" required
                                                            class="form-control form-control-sm border-black"
                                                            placeholder="Reqd Qty">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Container Date</label>
                                                        <input type="date" value="{{ $item->container_date }}"
                                                            name="container_date" required
                                                            class="form-control form-control-sm border-black"
                                                            placeholder="Container Date">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label>Container Booked</label>
                                                        <select name="container_booked"
                                                            class="form-select form-control-sm border-dark" required>
                                                            <option value="{{ \App\Models\OrderProduct::YES }}"
                                                                {{ $item->container_booked == \App\Models\OrderProduct::YES ? 'selected' : '' }}>
                                                                Yes
                                                            </option>
                                                            <option value="{{ \App\Models\OrderProduct::NO }}"
                                                                {{ $item->container_booked == \App\Models\OrderProduct::NO ? 'selected' : '' }}>
                                                                No
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label>Die Name</label>
                                                        <select name="die_name" required
                                                            class="form-select form-control-sm border-dark">
                                                            <option value="" disabled>Choose an item</option>
                                                            @foreach ($biscuit_masters as $biscuit)
                                                                <option value="{{ $biscuit->id }}"
                                                                    {{ $biscuit->id == $item->die_name ? 'selected' : '' }}>
                                                                    {{ $biscuit->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <h4 class="card-title">Attach Document Name</h4>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Wrapper Design</label>
                                                        <input type="file" name="wrapper_design"
                                                            class="form-control form-control-sm"
                                                            placeholder="Wrapper Design">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Box Design</label>
                                                        <input type="file" name="box_design"
                                                            class="form-control form-control-sm"
                                                            placeholder="Box Design">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Approval From Customer</label>
                                                        <input type="file"
                                                            name="approval_from_customer"
                                                            class="form-control form-control-sm"
                                                            placeholder="Approval From Customer">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach


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
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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

    $(document).ready(function() {
        $('.update-weight1').select2({
            placeholder: 'select'
        });
    })

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
        $(document).on('change', '.batchSizeSelect', function() {
            var qtyContainer = $(this).find("option:selected").attr("data-qty");
            var $qty = $(this).parent().parent().parent().parent().find('.qty_container');
            $qty.val(qtyContainer);
        });
    })


    // $(document).ready(function() {
    //     $("#deleteItem").click(function() {
    //         $("#loader").show();
    //         var id = $(this).attr('data-id');
    //         $.ajax({
    //             url: '{{ route('Order.Create.Delete') }}',
    //             method: 'POST',
    //             data: {
    //                 id: id,
    //                 _token: '{{ csrf_token() }}'
    //             },
    //             success: function(response) {
    //                 $.notify("Type deleted", "error");
    //                 $("#loader").hide();
    //                 $("#deleteModal").modal('hide');
    //                 $(".removeble-tr-" + id).fadeOut();
    //             },
    //             error: function(response) {
    //                 alert(response);
    //             }
    //         })
    //     })
    // })


    // $(".delete-items").click(function() {
    //     var id = $(this).attr('delete-id');
    //     $("#deleteItem").attr('data-id', id)
    //     $("#deleteModal").modal('show');
    // })
</script>
</body>

</html>
