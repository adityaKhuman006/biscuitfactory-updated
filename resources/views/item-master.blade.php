@include('dashboard')
<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="card p-2">
                <div class="col-12">
                    <h3 class="fw-bold p-2">Items Master</h3>
                    <div class="table-responsive">
                    <table class="table table-hover tab-pane">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Uom</th>
                            <th>Uom 2</th>
                            <th>Remark</th>
                            <th>Action</th>
                        </tr>
                        @foreach ($items as $key => $item)
                            <tr class="removeble-tr-{{ $item->id }}">
                                <td>{{ $key + 1 }}</td>
                                <td>
                                    <input type="text" class="border-0 update-name"
                                           onchange="updateUomData('{{ $item->id }}',$(this).val(),'name')"
                                           data-id='{{ $item->id }}'
                                           value="{{ $item->name }}">
                                </td>
                                <td>
                                    <select name="type" onchange="updateUomData('{{ $item->id }}',$(this).val(),'type')"
                                            class="form-control type-select form-control-sm border-black"
                                            required>
                                        <option value=""></option>
                                        @foreach($types as $type)
                                            <option {{ $type->id == $item->type ? 'selected':'' }}
                                                value="{{ $type->id }}">{{ $type->short_name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select name="uom" onchange="updateUomData('{{ $item->id }}',$(this).val(),'uom')"
                                            class="form-control uom-select form-control-sm border-black"
                                            required>
                                        <option value=""></option>
                                        @foreach($uoms as $uom)
                                            <option data-uom2="{{ $uom->uom_2 }}" {{ $uom->id == $item->uom ? 'selected':'' }}
                                                    value="{{ $uom->id }}">{{ $uom->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="text" class="border-0 update-uom-2" data-id='{{ $item->id }}'
                                           onchange="updateUomData('{{ $item->id }}',$(this).val(),'uom2')"
                                           value=" {{ $item->uom2 }}">
                                </td>
                                <td>
                                    <input type="text" class="border-0 update-uom-2" data-id='{{ $item->id }}'
                                           onchange="updateUomData('{{ $item->id }}',$(this).val(),'remark')"
                                           value=" {{ $item->remark }}">
                                </td>
                                <td>
                                    <button type="button" delete-id='{{ $item->id }}'
                                            class="btn btn-danger add-item delete-items"
                                            style="padding:4px 5px 3px 5px;"><i
                                            class="fs-5 text-white mdi mdi-delete"></i></button>
                                </td>
                                @endforeach
                            </tr>
                    </table>
                    </div>
                    <div class="card-body pt-10 ">
                        <!-- Show the form to add a product if no products exist -->
                        <form method="POST" action="{{ route('master.items.create') }}">
                            @csrf
                            <!-- <div class="border border-5 m-3" style="margin-left: 0 !important;"></div> -->
                            <div class="repeater">
                                <div data-repeater-list="category-group">
                                    <h4 class="card-title">Create</h4>
                                    <div id="show_item">
                                        <div class="row mt-3" data-repeater-item>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Name</label>
                                                    <input type="text" name="name" required
                                                           class="form-control form-control-sm border-black"
                                                           placeholder="Enter Name">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Type</label>
                                                    <select name="type"
                                                            class="form-control type-select form-control-sm border-black"
                                                            required>
                                                        <option value=""></option>
                                                        @foreach($types as $type)
                                                            <option
                                                                value="{{ $type->id }}">{{ $type->short_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Uom</label>
                                                    <select name="uom"
                                                            class="form-control uom-select form-control-sm border-black"
                                                            required>
                                                        <option value=""></option>
                                                        @foreach($uoms as $uom)
                                                            <option data-uom2="{{ $uom->uom_2 }}"
                                                                    value="{{ $uom->id }}">{{ $uom->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Uom 2</label>
                                                    <input type="text" name="uom_2" required
                                                           class="form-control uom-2 form-control-sm border-black"
                                                           placeholder="Enter uom 2">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Remark</label>
                                                    <input type="text" name="remark"
                                                           class="form-control form-control-sm border-black"
                                                           placeholder="Enter remark">
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
        show: function () {
            $(this).slideDown();
            $('.type-select').select2({
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
        $('.type-select').select2({
            placeholder: 'Select an option'
        });

        $('.uom-select').select2({
            placeholder: 'Select an option'
        });

        // $(".uom-select").change(function () {
        //     var selectedUom2 = $(this).find("option:selected").attr("data-uom2");
        //
        //     $(".uom-2").val(selectedUom2);
        // });

    })
    $(document).on('change', '.uom-select', function () {
        var selectedUom2 = $(this).find("option:selected").attr("data-uom2");
        $(this).parent().parent().parent().find('.uom-2').val(selectedUom2)
    });

    $("#deleteItem").click(function () {
        $("#loader").show();
        var id = $(this).attr('data-id');
        $.ajax({
            url: '{{ route('delete.items') }}',
            method: 'POST',
            data: {
                id: id,
                _token: '{{ csrf_token() }}'
            }, success: function (response) {
                $.notify("Uom deleted", "error");
                $("#loader").hide();
                $("#deleteModal").modal('hide');
                $(".removeble-tr-" + id).fadeOut();
            }, error: function (response) {
                alert(response);
            }
        })
    })


    $(".delete-items").click(function () {
        var id = $(this).attr('delete-id');
        $("#deleteItem").attr('data-id', id)
        $("#deleteModal").modal('show');
    })

    function updateUomData(id, value, type) {
        $.ajax({
            url: '{{ route('update.items') }}',
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
</script>
