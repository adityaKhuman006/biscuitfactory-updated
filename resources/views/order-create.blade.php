@include('dashboard')
<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
<div class="main-panel">
    <div class="content-wrapper p-2">
        <div class="row">
            <div class="col-12 p-2">

                <div class="table-responsive">
                    <table class="table table-hover tab-pane">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Order No</th>
                            <th>Action</th>
                        </tr>
                        @foreach ($order as $key => $item)
                            <tr class="removeble-tr-{{ $item->id }}">
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->order_no }}</td>
                                <td>
                                    <button type="button" class="btn btn-success add-item"
                                        style="padding:4px 5px 3px 5px;"><a
                                            href="{{ route('order.create.update', $item->id) }}"><i
                                                class="fs-5 text-white mdi mdi-pen"></i></a></button>
                                    <button type="button" delete-id='{{ $item->id }}'
                                        class="btn btn-danger add-item delete-items" style="padding:4px 5px 3px 5px;"><i
                                            class="fs-5 text-white mdi mdi-delete"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Create Order</h4>

                        <!-- Show the form to add a product if no products exist -->
                        <form method="POST" id="OrderCreateAdd" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-lg-2 col-2">
                                    <div class="form-group">
                                        <label>Date</label>
                                        <input type="date" id="dateInput" name="date" required
                                            class="form-control form-control-sm border-black" placeholder="Date">
                                    </div>
                                </div>
                                <div class="col-lg-2 col-2">
                                    <label>Name</label>
                                    <input type="text" name="name" required
                                        class="form-control form-control-sm border-black" placeholder="Name">
                                </div>
                                <div class="col-lg-2 col-2">
                                    <label>Order No</label>
                                    <input type="text" class="form-control form-control-sm border-black"
                                        value="{{ strtoupper(Str::random(6)) . str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT) }}"
                                        name="order_no">
                                </div>

                                <div class="col-lg-2 col-2">
                                    <div class="form-group">
                                        <label>Contact Person</label>
                                        <input type="number" name="contact_person" required
                                            class="form-control form-control-sm border-black"
                                            placeholder="Contact Person">
                                    </div>
                                </div>
                                <div class="col-lg-2 col-2">
                                    <label>Customer Name</label>
                                    <select name="customer_name"
                                        class="update-weight1 form-select form-control-sm border-dark"
                                        id="batchSizeSelect">
                                        <option selected disabled>Choose an compaey name</option>
                                        @foreach ($customer_name as $item)
                                            <option value="{{ $item->id }}">{{ $item->compaey_name }}
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
                                                <option value="" selected disabled>Select</option>
                                                <option value="{{ \App\Models\OrderProduct::YES }}">yes
                                                </option>
                                                <option value="{{ \App\Models\OrderProduct::NO }}">no
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="border border-5 m-3" style="margin-left: 0 !important;"></div>

                            <div class="repeater">
                                <div data-repeater-list="category-group">
                                    <h4 class="card-title">Add items</h4>
                                    <div id="show_item">
                                        <div class="row" data-repeater-item>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <div class="form-group">
                                                        <label>Product</label>
                                                        <select name="product" required
                                                            class="form-select update-weight2 form-control-sm border-dark"
                                                            id="batchSizeSelect">
                                                            <option selected disabled>Choose an product</option>
                                                            @foreach ($product as $item)
                                                                <option value="{{ $item->id }}">
                                                                    {{ $item->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <div class="form-group">
                                                        <label>Brand Name</label>
                                                        <select name="brand_name" required
                                                            class="form-select update-weight3 form-control-sm border-dark"
                                                            id="batchSizeSelect">
                                                            <option selected disabled>Choose an brand</option>
                                                            @foreach ($brand_name as $item)
                                                                <option value="{{ $item->id }}">
                                                                    {{ $item->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <div class="form-group">
                                                        <label>Pack Size</label>
                                                        <select name="pack_size" required
                                                            class="form-select batchSizeSelect form-control-sm border-dark"
                                                            id="">
                                                            <option selected disabled>Choose an pack</option>
                                                            @foreach ($pack_size as $item)
                                                                <option data-qty="{{ $item->loading_in_container }}"
                                                                    value="{{ $item->id }}">{{ $item->pack_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <div class="form-group">
                                                        <label>Qty Container</label>
                                                        <input type="text" name="qty_container" required
                                                            class="form-control qty_container form-control-sm border-black"
                                                            placeholder="Qty Container">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <div class="form-group">
                                                        <label>Reqd Qty</label>
                                                        <input type="text" name="reqd_oty" required
                                                            class="form-control form-control-sm border-black"
                                                            placeholder="Reqd Qty">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <div class="form-group">
                                                        <label>Container Date</label>
                                                        <input type="date" name="container_date" required
                                                            class="form-control form-control-sm border-black"
                                                            placeholder="Container Date">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <div class="form-group">
                                                        <label>Container Booked</label>
                                                        <select name="container_booked"
                                                            class="form-select form-control-sm border-dark" required>
                                                            <option value="" selected disabled>Select</option>
                                                            <option value="{{ \App\Models\OrderProduct::YES }}">yes
                                                            </option>
                                                            <option value="{{ \App\Models\OrderProduct::NO }}">no
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <div class="form-group">
                                                        <label>Die Name</label>
                                                        <select name="die_name" required
                                                            class="form-select form-control-sm border-dark"
                                                            id="batchSizeSelect">
                                                            <option selected disabled>Choose an die</option>
                                                            @foreach ($biscuit_masters as $item)
                                                                <option value="{{ $item->id }}">
                                                                    {{ $item->name }} </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <h4 class="card-title">Attach Document Name</h4>


                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div class="form-group">
                                                        <label>Wrapper Design</label>
                                                        <input type="file" name="wrapper_design"
                                                            class="form-control form-control-sm"
                                                            placeholder="Wrapper Design">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div class="form-group">
                                                        <label>Box Design</label>
                                                        <input type="file" name="box_design"
                                                            class="form-control form-control-sm"
                                                            placeholder="Box Design">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div class="form-group">
                                                        <label>Approval From Customer</label>
                                                        <input type="file" name="approval_from_customer"
                                                            class="form-control form-control-sm"
                                                            placeholder="Approval From Customer">
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
                                <button class="btn btn-primary" type="submit" name="submit">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Master Type</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body mt-4 mb-4">
                are you sure you want to delete?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary text-white" data-bs-dismiss="modal">Close</button>
                <button type="button" id="deleteItem" class="btn btn-danger text-white">Delete</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="OrderCreateRender" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="OrderCreateBody">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


@include('footer')
<script src="{{ asset('assets/js/repeater.min.js') }}"></script>
<script src="{{ asset('assets/js/notify.min.js') }}"></script>
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


    $(document).ready(function() {
        $("#deleteItem").click(function() {
            $("#loader").show();
            var id = $(this).attr('data-id');
            $.ajax({
                url: '{{ route('Order.Create.Delete') }}',
                method: 'POST',
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $.notify("Type deleted", "error");
                    $("#loader").hide();
                    $("#deleteModal").modal('hide');
                    $(".removeble-tr-" + id).fadeOut();
                },
                error: function(response) {
                    alert(response);
                }
            })
        })
    })


    $(".delete-items").click(function() {
        var id = $(this).attr('delete-id');
        $("#deleteItem").attr('data-id', id)
        $("#deleteModal").modal('show');
    })

    $(document).ready(function() {
        $('#OrderCreateAdd').on('submit', function(e) {
            e.preventDefault();

            var formData = new FormData(this);

            $.ajax({
                url: "{{ route('Order.Create.add') }}",
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {

                    var responseOrder = response.order;
                    // alert(responseOrder);

                    if (response.order) {
                        $.ajax({
                            url: "{{ route('Order.Render') }}",
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                order: responseOrder
                            },
                            success: function(response) {
                                $("#OrderCreateRender").modal('show');
                                $("#OrderCreateBody").html(response.html);
                            },
                            error: function(xhr, status, error) {
                                alert('An error occurred: ' + error);
                            }
                        });
                    } else {
                        alert('Invalid response from the server.');
                    }
                },
                error: function(xhr, status, error) {
                    alert('An error occurred: ' + error);
                }
            });
        });
    });
</script>
</body>

</html>
