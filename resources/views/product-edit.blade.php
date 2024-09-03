@include('dashboard')
<style>
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 14px;
    }
    .select2-container .select2-selection--single {
         height: unset;
    }
    .select2-container {
        width: 244.075px !important;
    }
</style>
<div class="main-panel">
    <div class="content-wrapper p-2">
        <div class="row">
            <div class="col-12 p-2">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Update Product</h4>
                        <!-- Show the form to add a product if no products exist -->
                        <form method="POST" action="{{ route('product.update') }}">
                            @csrf
                            <input type="hidden" name="product-id" value="{{ $product->id }}">
                            <div class="row">
                                <div class="col-lg-3 col-6">
                                    <div class="form-group">
                                        <label>Product Name</label>
                                        <input type="text" name="product_name" required
                                               value="{{ $product->name ?? '' }}"
                                               class="form-control form-control-sm border-black"
                                               placeholder="Product Name">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-6">
                                    <div class="form-group">
                                        <label>Pack Size</label>
                                        <input type="text" name="pack_size" required
                                               value="{{ $product->pack_size ?? '' }}"
                                               class="form-control form-control-sm border-black"
                                               placeholder="Batch Size">
                                    </div>
                                </div>
                            </div>
                            <div class="border border-5 m-3" style="margin-left: 0 !important;"></div>

                            <h4 class="card-title">Update items</h4>
                            <div class="repeater">
                                <div data-repeater-list="category-group">
                                    <div id="show_item">
                                        <div class="row" data-repeater-item
                                             style="border-bottom: 2px solid #0000003b; margin: 10px 10px 10px 0px; border-radius: 10px">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <div class="form-group">
                                                        <label>Item</label>
                                                        <select name="item" class="form-control items-select">
                                                            <option value=""></option>
                                                            @foreach($productItems as $item)
                                                                <option data-uom ="{{ $item->uom }}"  value="{{ $item->id }}">{{ $item->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <div class="form-group">
                                                        <div class="form-group">
                                                            <label>Resepi weight</label>
                                                            <input type="text" name="resepi_weight" required
                                                                   class="form-control form-control-sm border-black"
                                                                   placeholder="Resepi weight">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <div class="form-group">
                                                        <label>UOM</label>
                                                        <select name="uom" class="form-control uom-select">
                                                            <option value=""></option>
                                                            @foreach($uoms as $uom)
                                                                <option value="{{ $uom->id }}">{{ $uom->name }}</option>
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
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover tab-pane m-2">
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Recipe Weight</th>
                                        <th>UOM</th>
                                        <th>Action</th>
                                    </tr>
                                    @foreach($items as $key => $item)
                                        <tr class="removeble-tr-{{ $item->id }}">
                                            <td>{{ $key + 1 }}</td>
                                            <td>
                                                <select class="border-0 form-control update-name"
                                                        data-id='{{$item->id}}'
                                                        onchange="updateUomData('{{ $item->id }}',$(this).val(),'name')">
                                                    <option value=""></option>
                                                    @foreach($productItems as $productItem)
                                                    <option {{ $productItem->id == $item->item_id ? 'selected' : '' }} value="{{ $productItem->id }}">{{ $productItem->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" class="border-0 update-weight"
                                                       data-id='{{$item->id}}'
                                                       onchange="updateUomData('{{ $item->id }}',$(this).val(),'recipieWeight')"
                                                       value=" {{ $item->recipie_weight }}"></td>
                                            <td>
                                                <select class="form-control update-name"
                                                        data-id='{{$item->id}}'
                                                        onchange="updateUomData('{{ $item->id }}',$(this).val(),'uom')">
                                                    <option value=""></option>
                                                    @foreach($uoms as $uom)
                                                        <option {{ $uom->id == $item->uom ? 'selected' : '' }} value="{{ $uom->id }}">{{ $uom->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <button type="button" delete-id='{{ $item->id }}'
                                                        class="add-item delete-items border-0 bg-danger rounded-3"
                                                        style="padding:4px 5px 3px 5px;"><i
                                                        class="fs-6 text-white mdi mdi-delete"></i></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this record?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" id="deleteButton" class="btn btn-danger">DELETE</button>
            </div>
        </div>
    </div>
</div>
@include('footer')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{ asset('assets/js/repeater.min.js') }}"></script>
<script>
    $('.repeater').repeater({
        initEmpty: true,
        defaultValues: {
            'text-input': 'foo'
        },
        show: function () {
            $(this).slideDown();
            $('.items-select').select2({
                placeholder: 'Select an option'
            });
            $('.uom-select').select2({
                placeholder: 'Select an option'
            });
        },
        hide: function (deleteElement) {
            $(this).slideUp(deleteElement);
        },
        isFirstItemUndeletable: true
    });
    $(document).ready(function () {
        $('.items-select').select2({
            placeholder: 'Select an option'
        });
        $('.uom-select').select2({
            placeholder: 'Select an option'
        });
        $('.update-name').select2({
            placeholder: 'Select an option'
        });
    });

    function updateUomData(id, value, type) {
        $.ajax({
            url: '{{ route('update.product.items') }}',
            method: 'POST',
            data: {
                id: id,
                value: value,
                type: type,
                _token: '{{ csrf_token() }}'
            },
            success: function (response) {
                $.notify("update success", "success");
            },
            error: function (response) {
                alert(response);
            }
        })
    }

    $(".delete-items").click(function () {
        $("#loader").show();
        var deleteId = $(this).attr('delete-id');
        $("#deleteButton").attr('delete-id', deleteId)
        $("#deleteModal").modal('show')
        $("#loader").hide();
    })

    $("#deleteButton").click(function () {
        $("#loader").show();
        var deleteId = $(this).attr('delete-id');
        $.ajax({
            url: '{{ route('product.items.delete') }}',
            method: 'POST',
            data: {
                id: deleteId,
                _token: '{{ csrf_token() }}'
            }, success: function (response) {
                $("#deleteModal").modal('hide')
                $("#loader").hide();
                $.notify("Delete success", "error");
                $(".removeble-tr-" + deleteId).fadeOut();
            }, error: function (response) {
                $.notify(response, "error");
            }
        })
    })
    $(document).on('change', '.items-select', function () {
        var uomId = $(this).find("option:selected").data("uom");
        var $uomSelect = $(this).parent().parent().parent().find('.uom-select');
        $uomSelect.val(uomId).trigger('change');
    });


</script>

{{-- @endsection --}}
