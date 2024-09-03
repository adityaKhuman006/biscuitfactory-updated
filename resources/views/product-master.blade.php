@include('dashboard')
<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="card p-2">
                <div class="col-12">
                    <h3 class="fw-bold p-2">Product Master</h3>
                    <div class="table-responsive">
                        <table class="table table-hover tab-pane">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Pack Size</th>
                                <th>Action</th>
                            </tr>
                            @foreach ($products as $key => $product)
                                <tr class="removeble-tr-{{ $product->id }}">
                                    <td>{{ $key + 1 }}</td>
                                    <td>
                                        {{ $product->name }}
                                    </td>

                                    <td>
                                        {{ $product->pack_size }}
                                    </td>
                                    <td>
                                        <a href="{{ route('product.edit', $product->id) }}" class="btn btn-primary"
                                            style="padding:4px 5px 3px 5px;">
                                            <i class="fs-5 text-white mdi mdi-pencil"></i></a>

                                        <button type="button" delete-id='{{ $product->id }}'
                                            class="btn btn-danger add-item delete-items"
                                            style="padding:4px 5px 3px 5px;"><i
                                                class="fs-5 text-white mdi mdi-delete"></i>
                                        </button>
                                    </td>
                            @endforeach
                            </tr>
                        </table>
                    </div>
                    <div class="card-body pt-10 ">
                        <!-- Show the form to add a product if no products exist -->
                        <form method="POST" action="{{ route('product.master.create') }}">
                            <h4 class="card-title">Create</h4>
                            @csrf
                            <div>
                                <div class="row mt-3">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Product name</label>
                                            <input type="text" name="product_name" required
                                                class="form-control form-control-sm border-black"
                                                placeholder="Enter product name">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Pack size</label>
                                            <input type="text" name="pack_size" required
                                                class="form-control form-control-sm border-black"
                                                placeholder="Pack size">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <!-- <div class="border border-5 m-3" style="margin-left: 0 !important;"></div> -->
                            <div class="repeater">
                                <div data-repeater-list="category-group">
                                    <div id="show_item">
                                        <div class="row mt-3" data-repeater-item>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Item</label>
                                                    <select name="item" class="form-control items-select">
                                                        <option value=""></option>
                                                        @foreach ($items as $item)
                                                            <option data-uom ="{{ $item->uom }}"
                                                                value="{{ $item->id }}">{{ $item->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Resepi weight</label>
                                                    <input type="text" name="resepi_weight" required
                                                        class="form-control form-control-sm border-black"
                                                        placeholder="Resepi weight">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>UOM</label>
                                                    <select name="uom" class="form-control uom-select">
                                                        <option value=""></option>
                                                        @foreach ($uoms as $uom)
                                                            <option value="{{ $uom->id }}">{{ $uom->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <br>
                                                    <div class="text-end mt-2">
                                                        <button data-repeater-delete type="button"
                                                            class="btn btn-sm btn-danger add-item"><i
                                                                class=" mdi mdi-delete"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <button data-repeater-create type="button" class="btn-sm btn btn-success add-item"
                                        style="margin-top: 15px;"><i class="mdi mdi-plus"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-3">
                                <button class="btn btn-primary" type="submit">Submit</button>
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

@include('footer')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{ asset('assets/js/repeater.min.js') }}"></script>
<script src="{{ asset('assets/js/notify.min.js') }}"></script>
<script>
    $('.repeater').repeater({
        defaultValues: {
            'text-input': 'foo'
        },
        show: function() {
            $(this).slideDown();
            $('.items-select').select2({
                placeholder: 'Select an option'
            });
            $('.uom-select').select2({
                placeholder: 'Select an option'
            });
        },
        hide: function(deleteElement) {
            $(this).slideUp(deleteElement);
        },
        isFirstItemUndeletable: true
    });

    $(document).ready(function() {
        $('.items-select').select2({
            placeholder: 'Select an option'
        });
        $('.uom-select').select2({
            placeholder: 'Select an option'
        });

        $(document).on('change', '.items-select', function() {
            var uomId = $(this).find("option:selected").data("uom");
            var $uomSelect = $(this).parent().parent().parent().find('.uom-select');
            $uomSelect.val(uomId).trigger('change');
        });

    })

    $("#deleteItem").click(function() {
        $("#loader").show();
        var id = $(this).attr('data-id');
        $.ajax({
            url: '{{ route('delete.product') }}',
            method: 'POST',
            data: {
                id: id,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                $("#deleteModal").modal('hide');
                $("#loader").hide();
                $.notify("Product deleted", "error");
                $(".removeble-tr-" + id).fadeOut();
            },
            error: function(response) {
                alert(response);
            }
        })
    })


    $(".delete-items").click(function() {
        var id = $(this).attr('delete-id');
        $("#deleteItem").attr('data-id', id)
        $("#deleteModal").modal('show');
    })
</script>
